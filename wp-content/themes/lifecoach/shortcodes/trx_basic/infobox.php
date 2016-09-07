<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('lifecoach_sc_infobox_theme_setup')) {
	add_action( 'lifecoach_action_before_init_theme', 'lifecoach_sc_infobox_theme_setup' );
	function lifecoach_sc_infobox_theme_setup() {
		add_action('lifecoach_action_shortcodes_list', 		'lifecoach_sc_infobox_reg_shortcodes');
		if (function_exists('lifecoach_exists_visual_composer') && lifecoach_exists_visual_composer())
			add_action('lifecoach_action_shortcodes_list_vc','lifecoach_sc_infobox_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_infobox id="unique_id" style="regular|info|success|error|result" static="0|1"]Et adipiscing integer, scelerisque pid, augue mus vel tincidunt porta[/trx_infobox]
*/

if (!function_exists('lifecoach_sc_infobox')) {	
	function lifecoach_sc_infobox($atts, $content=null){	
		if (lifecoach_in_shortcode_blogger()) return '';
		extract(lifecoach_html_decode(shortcode_atts(array(
			// Individual params
			"style" => "regular",
			"closeable" => "no",
			"icon" => "",
			"color" => "",
			"bg_color" => "",
			// Common params
			"id" => "",
			"class" => "",
			"animation" => "",
			"css" => "",
			"top" => "",
			"bottom" => "",
			"left" => "",
			"right" => ""
		), $atts)));
		$class .= ($class ? ' ' : '') . lifecoach_get_css_position_as_classes($top, $right, $bottom, $left);
		$css .= ($color !== '' ? 'color:' . esc_attr($color) .';' : '')
			. ($bg_color !== '' ? 'background-color:' . esc_attr($bg_color) .';' : '');
		if (empty($icon)) {
			if ($icon=='none')
				$icon = '';
			else if ($style=='regular')
				$icon = 'icon-cogs';
			else if ($style=='success')
				$icon = 'icon-ok';
            else if ($style=='result')
                $icon = 'icon-warning-empty';
			else if ($style=='error')
				$icon = 'icon-block';
			else if ($style=='info')
				$icon = 'icon-info-circled-alt';
		}
		$content = do_shortcode($content);
		$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
				. ' class="sc_infobox sc_infobox_style_' . esc_attr($style) 
					. (lifecoach_param_is_on($closeable) ? ' sc_infobox_closeable' : '') 
					. (!empty($class) ? ' '.esc_attr($class) : '') 
					. ($icon!='' && !lifecoach_param_is_inherit($icon) ? ' sc_infobox_iconed '. esc_attr($icon) : '') 
					. '"'
				. (!lifecoach_param_is_off($animation) ? ' data-animation="'.esc_attr(lifecoach_get_animation_classes($animation)).'"' : '')
				. ($css!='' ? ' style="'.esc_attr($css).'"' : '')
				. '>'
				. trim($content)
				. '</div>';
		return apply_filters('lifecoach_shortcode_output', $output, 'trx_infobox', $atts, $content);
	}
	lifecoach_require_shortcode('trx_infobox', 'lifecoach_sc_infobox');
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'lifecoach_sc_infobox_reg_shortcodes' ) ) {
	//add_action('lifecoach_action_shortcodes_list', 'lifecoach_sc_infobox_reg_shortcodes');
	function lifecoach_sc_infobox_reg_shortcodes() {
	
		lifecoach_sc_map("trx_infobox", array(
			"title" => esc_html__("Infobox", 'lifecoach'),
			"desc" => wp_kses_data( __("Insert infobox into your post (page)", 'lifecoach') ),
			"decorate" => false,
			"container" => true,
			"params" => array(
				"style" => array(
					"title" => esc_html__("Style", 'lifecoach'),
					"desc" => wp_kses_data( __("Infobox style", 'lifecoach') ),
					"value" => "regular",
					"type" => "checklist",
					"dir" => "horizontal",
					"options" => array(
						'regular' => esc_html__('Regular', 'lifecoach'),
						'info' => esc_html__('Info', 'lifecoach'),
						'success' => esc_html__('Success', 'lifecoach'),
						'error' => esc_html__('Error', 'lifecoach')
					)
				),
				"closeable" => array(
					"title" => esc_html__("Closeable box", 'lifecoach'),
					"desc" => wp_kses_data( __("Create closeable box (with close button)", 'lifecoach') ),
					"value" => "no",
					"type" => "switch",
					"options" => lifecoach_get_sc_param('yes_no')
				),
				"icon" => array(
					"title" => esc_html__("Custom icon",  'lifecoach'),
					"desc" => wp_kses_data( __('Select icon for the infobox from Fontello icons set. If empty - use default icon',  'lifecoach') ),
					"value" => "",
					"type" => "icons",
					"options" => lifecoach_get_sc_param('icons')
				),
				"color" => array(
					"title" => esc_html__("Text color", 'lifecoach'),
					"desc" => wp_kses_data( __("Any color for text and headers", 'lifecoach') ),
					"value" => "",
					"type" => "color"
				),
				"bg_color" => array(
					"title" => esc_html__("Background color", 'lifecoach'),
					"desc" => wp_kses_data( __("Any background color for this infobox", 'lifecoach') ),
					"value" => "",
					"type" => "color"
				),
				"_content_" => array(
					"title" => esc_html__("Infobox content", 'lifecoach'),
					"desc" => wp_kses_data( __("Content for infobox", 'lifecoach') ),
					"divider" => true,
					"rows" => 4,
					"value" => "",
					"type" => "textarea"
				),
				"top" => lifecoach_get_sc_param('top'),
				"bottom" => lifecoach_get_sc_param('bottom'),
				"left" => lifecoach_get_sc_param('left'),
				"right" => lifecoach_get_sc_param('right'),
				"id" => lifecoach_get_sc_param('id'),
				"class" => lifecoach_get_sc_param('class'),
				"animation" => lifecoach_get_sc_param('animation'),
				"css" => lifecoach_get_sc_param('css')
			)
		));
	}
}


/* Register shortcode in the VC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'lifecoach_sc_infobox_reg_shortcodes_vc' ) ) {
	//add_action('lifecoach_action_shortcodes_list_vc', 'lifecoach_sc_infobox_reg_shortcodes_vc');
	function lifecoach_sc_infobox_reg_shortcodes_vc() {
	
		vc_map( array(
			"base" => "trx_infobox",
			"name" => esc_html__("Infobox", 'lifecoach'),
			"description" => wp_kses_data( __("Box with info or error message", 'lifecoach') ),
			"category" => esc_html__('Content', 'lifecoach'),
			'icon' => 'icon_trx_infobox',
			"class" => "trx_sc_container trx_sc_infobox",
			"content_element" => true,
			"is_container" => true,
			"show_settings_on_create" => true,
			"params" => array(
				array(
					"param_name" => "style",
					"heading" => esc_html__("Style", 'lifecoach'),
					"description" => wp_kses_data( __("Infobox style", 'lifecoach') ),
					"admin_label" => true,
					"class" => "",
					"value" => array(
							esc_html__('Regular', 'lifecoach') => 'regular',
							esc_html__('Info', 'lifecoach') => 'info',
							esc_html__('Success', 'lifecoach') => 'success',
							esc_html__('Error', 'lifecoach') => 'error',
							esc_html__('Result', 'lifecoach') => 'result'
						),
					"type" => "dropdown"
				),
				array(
					"param_name" => "closeable",
					"heading" => esc_html__("Closeable", 'lifecoach'),
					"description" => wp_kses_data( __("Create closeable box (with close button)", 'lifecoach') ),
					"class" => "",
					"value" => array(esc_html__('Close button', 'lifecoach') => 'yes'),
					"type" => "checkbox"
				),
				array(
					"param_name" => "icon",
					"heading" => esc_html__("Custom icon", 'lifecoach'),
					"description" => wp_kses_data( __("Select icon for the infobox from Fontello icons set. If empty - use default icon", 'lifecoach') ),
					"class" => "",
					"value" => lifecoach_get_sc_param('icons'),
					"type" => "dropdown"
				),
				array(
					"param_name" => "color",
					"heading" => esc_html__("Text color", 'lifecoach'),
					"description" => wp_kses_data( __("Any color for the text and headers", 'lifecoach') ),
					"class" => "",
					"value" => "",
					"type" => "colorpicker"
				),
				array(
					"param_name" => "bg_color",
					"heading" => esc_html__("Background color", 'lifecoach'),
					"description" => wp_kses_data( __("Any background color for this infobox", 'lifecoach') ),
					"class" => "",
					"value" => "",
					"type" => "colorpicker"
				),
				/*
				array(
					"param_name" => "content",
					"heading" => esc_html__("Message text", 'lifecoach'),
					"description" => wp_kses_data( __("Message for the infobox", 'lifecoach') ),
					"class" => "",
					"value" => "",
					"type" => "textarea_html"
				),
				*/
				lifecoach_get_vc_param('id'),
				lifecoach_get_vc_param('class'),
				lifecoach_get_vc_param('animation'),
				lifecoach_get_vc_param('css'),
				lifecoach_get_vc_param('margin_top'),
				lifecoach_get_vc_param('margin_bottom'),
				lifecoach_get_vc_param('margin_left'),
				lifecoach_get_vc_param('margin_right')
			),
			'js_view' => 'VcTrxTextContainerView'
		) );
		
		class WPBakeryShortCode_Trx_Infobox extends LIFECOACH_VC_ShortCodeContainer {}
	}
}
?>