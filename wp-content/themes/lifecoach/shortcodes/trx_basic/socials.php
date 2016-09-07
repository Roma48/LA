<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('lifecoach_sc_socials_theme_setup')) {
	add_action( 'lifecoach_action_before_init_theme', 'lifecoach_sc_socials_theme_setup' );
	function lifecoach_sc_socials_theme_setup() {
		add_action('lifecoach_action_shortcodes_list', 		'lifecoach_sc_socials_reg_shortcodes');
		if (function_exists('lifecoach_exists_visual_composer') && lifecoach_exists_visual_composer())
			add_action('lifecoach_action_shortcodes_list_vc','lifecoach_sc_socials_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_socials id="unique_id" size="small"]
	[trx_social_item name="facebook" url="profile url" icon="path for the icon"]
	[trx_social_item name="twitter" url="profile url"]
[/trx_socials]
*/

if (!function_exists('lifecoach_sc_socials')) {	
	function lifecoach_sc_socials($atts, $content=null){	
		if (lifecoach_in_shortcode_blogger()) return '';
		extract(lifecoach_html_decode(shortcode_atts(array(
			// Individual params
			"size" => "small",		// tiny | small | medium | large
			"shape" => "square",	// round | square
			"type" => lifecoach_get_theme_setting('socials_type'),	// icons | images
			"socials" => "",
			"custom" => "no",
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
		lifecoach_storage_set('sc_social_data', array(
			'icons' => false,
            'type' => $type
            )
        );
		if (!empty($socials)) {
			$allowed = explode('|', $socials);
			$list = array();
			for ($i=0; $i<count($allowed); $i++) {
				$s = explode('=', $allowed[$i]);
				if (!empty($s[1])) {
					$list[] = array(
						'icon'	=> $type=='images' ? lifecoach_get_socials_url($s[0]) : 'icon-'.trim($s[0]),
						'url'	=> $s[1]
						);
				}
			}
			if (count($list) > 0) lifecoach_storage_set_array('sc_social_data', 'icons', $list);
		} else if (lifecoach_param_is_off($custom))
			$content = do_shortcode($content);
		if (lifecoach_storage_get_array('sc_social_data', 'icons')===false) lifecoach_storage_set_array('sc_social_data', 'icons', lifecoach_get_custom_option('social_icons'));
		$output = lifecoach_prepare_socials(lifecoach_storage_get_array('sc_social_data', 'icons'));
		$output = $output
			? '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
				. ' class="sc_socials sc_socials_type_' . esc_attr($type) . ' sc_socials_shape_' . esc_attr($shape) . ' sc_socials_size_' . esc_attr($size) . (!empty($class) ? ' '.esc_attr($class) : '') . '"' 
				. ($css!='' ? ' style="'.esc_attr($css).'"' : '') 
				. (!lifecoach_param_is_off($animation) ? ' data-animation="'.esc_attr(lifecoach_get_animation_classes($animation)).'"' : '')
				. '>' 
				. ($output)
				. '</div>'
			: '';
		return apply_filters('lifecoach_shortcode_output', $output, 'trx_socials', $atts, $content);
	}
	lifecoach_require_shortcode('trx_socials', 'lifecoach_sc_socials');
}


if (!function_exists('lifecoach_sc_social_item')) {	
	function lifecoach_sc_social_item($atts, $content=null){	
		if (lifecoach_in_shortcode_blogger()) return '';
		extract(lifecoach_html_decode(shortcode_atts(array(
			// Individual params
			"name" => "",
			"url" => "",
			"icon" => ""
		), $atts)));
		if (!empty($name) && empty($icon)) {
			$type = lifecoach_storage_get_array('sc_social_data', 'type');
			if ($type=='images') {
				if (file_exists(lifecoach_get_socials_dir($name.'.png')))
					$icon = lifecoach_get_socials_url($name.'.png');
			} else
				$icon = 'icon-'.esc_attr($name);
		}
		if (!empty($icon) && !empty($url)) {
			if (lifecoach_storage_get_array('sc_social_data', 'icons')===false) lifecoach_storage_set_array('sc_social_data', 'icons', array());
			lifecoach_storage_set_array2('sc_social_data', 'icons', '', array(
				'icon' => $icon,
				'url' => $url
				)
			);
		}
		return '';
	}
	lifecoach_require_shortcode('trx_social_item', 'lifecoach_sc_social_item');
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'lifecoach_sc_socials_reg_shortcodes' ) ) {
	//add_action('lifecoach_action_shortcodes_list', 'lifecoach_sc_socials_reg_shortcodes');
	function lifecoach_sc_socials_reg_shortcodes() {
	
		lifecoach_sc_map("trx_socials", array(
			"title" => esc_html__("Social icons", 'lifecoach'),
			"desc" => wp_kses_data( __("List of social icons (with hovers)", 'lifecoach') ),
			"decorate" => true,
			"container" => false,
			"params" => array(
				"type" => array(
					"title" => esc_html__("Icon's type", 'lifecoach'),
					"desc" => wp_kses_data( __("Type of the icons - images or font icons", 'lifecoach') ),
					"value" => lifecoach_get_theme_setting('socials_type'),
					"options" => array(
						'icons' => esc_html__('Icons', 'lifecoach'),
						'images' => esc_html__('Images', 'lifecoach')
					),
					"type" => "checklist"
				), 
				"size" => array(
					"title" => esc_html__("Icon's size", 'lifecoach'),
					"desc" => wp_kses_data( __("Size of the icons", 'lifecoach') ),
					"value" => "small",
					"options" => lifecoach_get_sc_param('sizes'),
					"type" => "checklist"
				), 
				"shape" => array(
					"title" => esc_html__("Icon's shape", 'lifecoach'),
					"desc" => wp_kses_data( __("Shape of the icons", 'lifecoach') ),
					"value" => "square",
					"options" => lifecoach_get_sc_param('shapes'),
					"type" => "checklist"
				), 
				"socials" => array(
					"title" => esc_html__("Manual socials list", 'lifecoach'),
					"desc" => wp_kses_data( __("Custom list of social networks. For example: twitter=http://twitter.com/my_profile|facebook=http://facebook.com/my_profile. If empty - use socials from Theme options.", 'lifecoach') ),
					"divider" => true,
					"value" => "",
					"type" => "text"
				),
				"custom" => array(
					"title" => esc_html__("Custom socials", 'lifecoach'),
					"desc" => wp_kses_data( __("Make custom icons from inner shortcodes (prepare it on tabs)", 'lifecoach') ),
					"divider" => true,
					"value" => "no",
					"options" => lifecoach_get_sc_param('yes_no'),
					"type" => "switch"
				),
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
				"name" => "trx_social_item",
				"title" => esc_html__("Custom social item", 'lifecoach'),
				"desc" => wp_kses_data( __("Custom social item: name, profile url and icon url", 'lifecoach') ),
				"decorate" => false,
				"container" => false,
				"params" => array(
					"name" => array(
						"title" => esc_html__("Social name", 'lifecoach'),
						"desc" => wp_kses_data( __("Name (slug) of the social network (twitter, facebook, linkedin, etc.)", 'lifecoach') ),
						"value" => "",
						"type" => "text"
					),
					"url" => array(
						"title" => esc_html__("Your profile URL", 'lifecoach'),
						"desc" => wp_kses_data( __("URL of your profile in specified social network", 'lifecoach') ),
						"value" => "",
						"type" => "text"
					),
					"icon" => array(
						"title" => esc_html__("URL (source) for icon file", 'lifecoach'),
						"desc" => wp_kses_data( __("Select or upload image or write URL from other site for the current social icon", 'lifecoach') ),
						"readonly" => false,
						"value" => "",
						"type" => "media"
					)
				)
			)
		));
	}
}


/* Register shortcode in the VC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'lifecoach_sc_socials_reg_shortcodes_vc' ) ) {
	//add_action('lifecoach_action_shortcodes_list_vc', 'lifecoach_sc_socials_reg_shortcodes_vc');
	function lifecoach_sc_socials_reg_shortcodes_vc() {
	
		vc_map( array(
			"base" => "trx_socials",
			"name" => esc_html__("Social icons", 'lifecoach'),
			"description" => wp_kses_data( __("Custom social icons", 'lifecoach') ),
			"category" => esc_html__('Content', 'lifecoach'),
			'icon' => 'icon_trx_socials',
			"class" => "trx_sc_collection trx_sc_socials",
			"content_element" => true,
			"is_container" => true,
			"show_settings_on_create" => true,
			"as_parent" => array('only' => 'trx_social_item'),
			"params" => array_merge(array(
				array(
					"param_name" => "type",
					"heading" => esc_html__("Icon's type", 'lifecoach'),
					"description" => wp_kses_data( __("Type of the icons - images or font icons", 'lifecoach') ),
					"class" => "",
					"std" => lifecoach_get_theme_setting('socials_type'),
					"value" => array(
						esc_html__('Icons', 'lifecoach') => 'icons',
						esc_html__('Images', 'lifecoach') => 'images'
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "size",
					"heading" => esc_html__("Icon's size", 'lifecoach'),
					"description" => wp_kses_data( __("Size of the icons", 'lifecoach') ),
					"class" => "",
					"std" => "small",
					"value" => array_flip(lifecoach_get_sc_param('sizes')),
					"type" => "dropdown"
				),
				array(
					"param_name" => "shape",
					"heading" => esc_html__("Icon's shape", 'lifecoach'),
					"description" => wp_kses_data( __("Shape of the icons", 'lifecoach') ),
					"class" => "",
					"std" => "square",
					"value" => array_flip(lifecoach_get_sc_param('shapes')),
					"type" => "dropdown"
				),
				array(
					"param_name" => "socials",
					"heading" => esc_html__("Manual socials list", 'lifecoach'),
					"description" => wp_kses_data( __("Custom list of social networks. For example: twitter=http://twitter.com/my_profile|facebook=http://facebook.com/my_profile. If empty - use socials from Theme options.", 'lifecoach') ),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "custom",
					"heading" => esc_html__("Custom socials", 'lifecoach'),
					"description" => wp_kses_data( __("Make custom icons from inner shortcodes (prepare it on tabs)", 'lifecoach') ),
					"class" => "",
					"value" => array(esc_html__('Custom socials', 'lifecoach') => 'yes'),
					"type" => "checkbox"
				),
				lifecoach_get_vc_param('id'),
				lifecoach_get_vc_param('class'),
				lifecoach_get_vc_param('animation'),
				lifecoach_get_vc_param('css'),
				lifecoach_get_vc_param('margin_top'),
				lifecoach_get_vc_param('margin_bottom'),
				lifecoach_get_vc_param('margin_left'),
				lifecoach_get_vc_param('margin_right')
			))
		) );
		
		
		vc_map( array(
			"base" => "trx_social_item",
			"name" => esc_html__("Custom social item", 'lifecoach'),
			"description" => wp_kses_data( __("Custom social item: name, profile url and icon url", 'lifecoach') ),
			"show_settings_on_create" => true,
			"content_element" => true,
			"is_container" => false,
			'icon' => 'icon_trx_social_item',
			"class" => "trx_sc_single trx_sc_social_item",
			"as_child" => array('only' => 'trx_socials'),
			"as_parent" => array('except' => 'trx_socials'),
			"params" => array(
				array(
					"param_name" => "name",
					"heading" => esc_html__("Social name", 'lifecoach'),
					"description" => wp_kses_data( __("Name (slug) of the social network (twitter, facebook, linkedin, etc.)", 'lifecoach') ),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "url",
					"heading" => esc_html__("Your profile URL", 'lifecoach'),
					"description" => wp_kses_data( __("URL of your profile in specified social network", 'lifecoach') ),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "icon",
					"heading" => esc_html__("URL (source) for icon file", 'lifecoach'),
					"description" => wp_kses_data( __("Select or upload image or write URL from other site for the current social icon", 'lifecoach') ),
					"admin_label" => true,
					"class" => "",
					"value" => "",
					"type" => "attach_image"
				)
			)
		) );
		
		class WPBakeryShortCode_Trx_Socials extends LIFECOACH_VC_ShortCodeCollection {}
		class WPBakeryShortCode_Trx_Social_Item extends LIFECOACH_VC_ShortCodeSingle {}
	}
}
?>