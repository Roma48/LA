<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('lifecoach_sc_googlemap_theme_setup')) {
	add_action( 'lifecoach_action_before_init_theme', 'lifecoach_sc_googlemap_theme_setup' );
	function lifecoach_sc_googlemap_theme_setup() {
		add_action('lifecoach_action_shortcodes_list', 		'lifecoach_sc_googlemap_reg_shortcodes');
		if (function_exists('lifecoach_exists_visual_composer') && lifecoach_exists_visual_composer())
			add_action('lifecoach_action_shortcodes_list_vc','lifecoach_sc_googlemap_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

//[trx_googlemap id="unique_id" width="width_in_pixels_or_percent" height="height_in_pixels"]
//	[trx_googlemap_marker address="your_address"]
//[/trx_googlemap]

if (!function_exists('lifecoach_sc_googlemap')) {	
	function lifecoach_sc_googlemap($atts, $content = null) {
		if (lifecoach_in_shortcode_blogger()) return '';
		extract(lifecoach_html_decode(shortcode_atts(array(
			// Individual params
			"zoom" => 16,
			"style" => 'default',
			"scheme" => "",
			// Common params
			"id" => "",
			"class" => "",
			"css" => "",
			"animation" => "",
			"width" => "100%",
			"height" => "400",
			"top" => "",
			"bottom" => "",
			"left" => "",
			"right" => ""
		), $atts)));
		$class .= ($class ? ' ' : '') . lifecoach_get_css_position_as_classes($top, $right, $bottom, $left);
		$css .= lifecoach_get_css_dimensions_from_values($width, $height);
		if (empty($id)) $id = 'sc_googlemap_'.str_replace('.', '', mt_rand());
		if (empty($style)) $style = lifecoach_get_custom_option('googlemap_style');
        $api_key = lifecoach_get_theme_option('api_google');
        lifecoach_enqueue_script( 'googlemap', lifecoach_get_protocol().'://maps.google.com/maps/api/js'.($api_key ? '?key='.$api_key : ''), array(), null, true );
        lifecoach_enqueue_script( 'lifecoach-googlemap-script', lifecoach_get_file_url('js/core.googlemap.js'), array(), null, true );
		lifecoach_storage_set('sc_googlemap_markers', array());
		$content = do_shortcode($content);
		$output = '';
		$markers = lifecoach_storage_get('sc_googlemap_markers');
		if (count($markers) == 0) {
			$markers[] = array(
				'title' => lifecoach_get_custom_option('googlemap_title'),
				'description' => lifecoach_strmacros(lifecoach_get_custom_option('googlemap_description')),
				'latlng' => lifecoach_get_custom_option('googlemap_latlng'),
				'address' => lifecoach_get_custom_option('googlemap_address'),
				'point' => lifecoach_get_custom_option('googlemap_marker')
			);
		}
		$output .= 
			($content ? '<div id="'.esc_attr($id).'_wrap" class="sc_googlemap_wrap'
					. ($scheme && !lifecoach_param_is_off($scheme) && !lifecoach_param_is_inherit($scheme) ? ' scheme_'.esc_attr($scheme) : '') 
					. '">' : '')
			. '<div id="'.esc_attr($id).'"'
				. ' class="sc_googlemap'. (!empty($class) ? ' '.esc_attr($class) : '').'"'
				. ($css!='' ? ' style="'.esc_attr($css).'"' : '') 
				. (!lifecoach_param_is_off($animation) ? ' data-animation="'.esc_attr(lifecoach_get_animation_classes($animation)).'"' : '')
				. ' data-zoom="'.esc_attr($zoom).'"'
				. ' data-style="'.esc_attr($style).'"'
				. '>';
		$cnt = 0;
		foreach ($markers as $marker) {
			$cnt++;
			if (empty($marker['id'])) $marker['id'] = $id.'_'.intval($cnt);
			$output .= '<div id="'.esc_attr($marker['id']).'" class="sc_googlemap_marker"'
				. ' data-title="'.esc_attr($marker['title']).'"'
				. ' data-description="'.esc_attr(lifecoach_strmacros($marker['description'])).'"'
				. ' data-address="'.esc_attr($marker['address']).'"'
				. ' data-latlng="'.esc_attr($marker['latlng']).'"'
				. ' data-point="'.esc_attr($marker['point']).'"'
				. '></div>';
		}
		$output .= '</div>'
			. ($content ? '<div class="sc_googlemap_content">' . trim($content) . '</div></div>' : '');
			
		return apply_filters('lifecoach_shortcode_output', $output, 'trx_googlemap', $atts, $content);
	}
	lifecoach_require_shortcode("trx_googlemap", "lifecoach_sc_googlemap");
}


if (!function_exists('lifecoach_sc_googlemap_marker')) {	
	function lifecoach_sc_googlemap_marker($atts, $content = null) {
		if (lifecoach_in_shortcode_blogger()) return '';
		extract(lifecoach_html_decode(shortcode_atts(array(
			// Individual params
			"title" => "",
			"address" => "",
			"latlng" => "",
			"point" => "",
			// Common params
			"id" => ""
		), $atts)));
		if (!empty($point)) {
			if ($point > 0) {
				$attach = wp_get_attachment_image_src( $point, 'full' );
				if (isset($attach[0]) && $attach[0]!='')
					$point = $attach[0];
			}
		}
		$content = do_shortcode($content);
		lifecoach_storage_set_array('sc_googlemap_markers', '', array(
			'id' => $id,
			'title' => $title,
			'description' => !empty($content) ? $content : $address,
			'latlng' => $latlng,
			'address' => $address,
			'point' => $point ? $point : lifecoach_get_custom_option('googlemap_marker')
			)
		);
		return '';
	}
	lifecoach_require_shortcode("trx_googlemap_marker", "lifecoach_sc_googlemap_marker");
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'lifecoach_sc_googlemap_reg_shortcodes' ) ) {
	//add_action('lifecoach_action_shortcodes_list', 'lifecoach_sc_googlemap_reg_shortcodes');
	function lifecoach_sc_googlemap_reg_shortcodes() {
	
		lifecoach_sc_map("trx_googlemap", array(
			"title" => esc_html__("Google map", 'lifecoach'),
			"desc" => wp_kses_data( __("Insert Google map with specified markers", 'lifecoach') ),
			"decorate" => false,
			"container" => true,
			"params" => array(
				"zoom" => array(
					"title" => esc_html__("Zoom", 'lifecoach'),
					"desc" => wp_kses_data( __("Map zoom factor", 'lifecoach') ),
					"divider" => true,
					"value" => 16,
					"min" => 1,
					"max" => 20,
					"type" => "spinner"
				),
				"style" => array(
					"title" => esc_html__("Map style", 'lifecoach'),
					"desc" => wp_kses_data( __("Select map style", 'lifecoach') ),
					"value" => "default",
					"type" => "checklist",
					"options" => lifecoach_get_sc_param('googlemap_styles')
				),
				"scheme" => array(
					"title" => esc_html__("Color scheme", 'lifecoach'),
					"desc" => wp_kses_data( __("Select color scheme for this block", 'lifecoach') ),
					"value" => "",
					"type" => "checklist",
					"options" => lifecoach_get_sc_param('schemes')
				),
				"width" => lifecoach_shortcodes_width('100%'),
				"height" => lifecoach_shortcodes_height(240),
				"top" => lifecoach_get_sc_param('top'),
				"bottom" => lifecoach_get_sc_param('bottom'),
				"left" => lifecoach_get_sc_param('left'),
				"right" => lifecoach_get_sc_param('right'),
				"id" => lifecoach_get_sc_param('id'),
				"class" => lifecoach_get_sc_param('class'),
				"animation" => lifecoach_get_sc_param('animation'),
				"css" => lifecoach_get_sc_param('css')
			),
			"children" => array(
				"name" => "trx_googlemap_marker",
				"title" => esc_html__("Google map marker", 'lifecoach'),
				"desc" => wp_kses_data( __("Google map marker", 'lifecoach') ),
				"decorate" => false,
				"container" => true,
				"params" => array(
					"address" => array(
						"title" => esc_html__("Address", 'lifecoach'),
						"desc" => wp_kses_data( __("Address of this marker", 'lifecoach') ),
						"value" => "",
						"type" => "text"
					),
					"latlng" => array(
						"title" => esc_html__("Latitude and Longitude", 'lifecoach'),
						"desc" => wp_kses_data( __("Comma separated marker's coorditanes (instead Address)", 'lifecoach') ),
						"value" => "",
						"type" => "text"
					),
					"point" => array(
						"title" => esc_html__("URL for marker image file", 'lifecoach'),
						"desc" => wp_kses_data( __("Select or upload image or write URL from other site for this marker. If empty - use default marker", 'lifecoach') ),
						"readonly" => false,
						"value" => "",
						"type" => "media"
					),
					"title" => array(
						"title" => esc_html__("Title", 'lifecoach'),
						"desc" => wp_kses_data( __("Title for this marker", 'lifecoach') ),
						"value" => "",
						"type" => "text"
					),
					"_content_" => array(
						"title" => esc_html__("Description", 'lifecoach'),
						"desc" => wp_kses_data( __("Description for this marker", 'lifecoach') ),
						"rows" => 4,
						"value" => "",
						"type" => "textarea"
					),
					"id" => lifecoach_get_sc_param('id')
				)
			)
		));
	}
}


/* Register shortcode in the VC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'lifecoach_sc_googlemap_reg_shortcodes_vc' ) ) {
	//add_action('lifecoach_action_shortcodes_list_vc', 'lifecoach_sc_googlemap_reg_shortcodes_vc');
	function lifecoach_sc_googlemap_reg_shortcodes_vc() {
	
		vc_map( array(
			"base" => "trx_googlemap",
			"name" => esc_html__("Google map", 'lifecoach'),
			"description" => wp_kses_data( __("Insert Google map with desired address or coordinates", 'lifecoach') ),
			"category" => esc_html__('Content', 'lifecoach'),
			'icon' => 'icon_trx_googlemap',
			"class" => "trx_sc_collection trx_sc_googlemap",
			"content_element" => true,
			"is_container" => true,
			"as_parent" => array('only' => 'trx_googlemap_marker,trx_form,trx_section,trx_block,trx_promo'),
			"show_settings_on_create" => true,
			"params" => array(
				array(
					"param_name" => "zoom",
					"heading" => esc_html__("Zoom", 'lifecoach'),
					"description" => wp_kses_data( __("Map zoom factor", 'lifecoach') ),
					"admin_label" => true,
					"class" => "",
					"value" => "16",
					"type" => "textfield"
				),
				array(
					"param_name" => "style",
					"heading" => esc_html__("Style", 'lifecoach'),
					"description" => wp_kses_data( __("Map custom style", 'lifecoach') ),
					"admin_label" => true,
					"class" => "",
					"value" => array_flip(lifecoach_get_sc_param('googlemap_styles')),
					"type" => "dropdown"
				),
				array(
					"param_name" => "scheme",
					"heading" => esc_html__("Color scheme", 'lifecoach'),
					"description" => wp_kses_data( __("Select color scheme for this block", 'lifecoach') ),
					"class" => "",
					"value" => array_flip(lifecoach_get_sc_param('schemes')),
					"type" => "dropdown"
				),
				lifecoach_get_vc_param('id'),
				lifecoach_get_vc_param('class'),
				lifecoach_get_vc_param('animation'),
				lifecoach_get_vc_param('css'),
				lifecoach_vc_width('100%'),
				lifecoach_vc_height(240),
				lifecoach_get_vc_param('margin_top'),
				lifecoach_get_vc_param('margin_bottom'),
				lifecoach_get_vc_param('margin_left'),
				lifecoach_get_vc_param('margin_right')
			)
		) );
		
		vc_map( array(
			"base" => "trx_googlemap_marker",
			"name" => esc_html__("Googlemap marker", 'lifecoach'),
			"description" => wp_kses_data( __("Insert new marker into Google map", 'lifecoach') ),
			"class" => "trx_sc_collection trx_sc_googlemap_marker",
			'icon' => 'icon_trx_googlemap_marker',
			//"allowed_container_element" => 'vc_row',
			"show_settings_on_create" => true,
			"content_element" => true,
			"is_container" => true,
			"as_child" => array('only' => 'trx_googlemap'), // Use only|except attributes to limit parent (separate multiple values with comma)
			"params" => array(
				array(
					"param_name" => "address",
					"heading" => esc_html__("Address", 'lifecoach'),
					"description" => wp_kses_data( __("Address of this marker", 'lifecoach') ),
					"admin_label" => true,
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "latlng",
					"heading" => esc_html__("Latitude and Longitude", 'lifecoach'),
					"description" => wp_kses_data( __("Comma separated marker's coorditanes (instead Address)", 'lifecoach') ),
					"admin_label" => true,
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "title",
					"heading" => esc_html__("Title", 'lifecoach'),
					"description" => wp_kses_data( __("Title for this marker", 'lifecoach') ),
					"admin_label" => true,
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "point",
					"heading" => esc_html__("URL for marker image file", 'lifecoach'),
					"description" => wp_kses_data( __("Select or upload image or write URL from other site for this marker. If empty - use default marker", 'lifecoach') ),
					"class" => "",
					"value" => "",
					"type" => "attach_image"
				),
				lifecoach_get_vc_param('id')
			)
		) );
		
		class WPBakeryShortCode_Trx_Googlemap extends LIFECOACH_VC_ShortCodeCollection {}
		class WPBakeryShortCode_Trx_Googlemap_Marker extends LIFECOACH_VC_ShortCodeCollection {}
	}
}
?>