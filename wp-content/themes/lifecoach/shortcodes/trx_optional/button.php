<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('lifecoach_sc_button_theme_setup')) {
	add_action( 'lifecoach_action_before_init_theme', 'lifecoach_sc_button_theme_setup' );
	function lifecoach_sc_button_theme_setup() {
		add_action('lifecoach_action_shortcodes_list', 		'lifecoach_sc_button_reg_shortcodes');
		if (function_exists('lifecoach_exists_visual_composer') && lifecoach_exists_visual_composer())
			add_action('lifecoach_action_shortcodes_list_vc','lifecoach_sc_button_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_button id="unique_id" type="square|round" fullsize="0|1" style="global|light|dark" size="mini|medium|big|huge|banner" icon="icon-name" link='#' target='']Button caption[/trx_button]
*/

if (!function_exists('lifecoach_sc_button')) {	
	function lifecoach_sc_button($atts, $content=null){	
		if (lifecoach_in_shortcode_blogger()) return '';
		extract(lifecoach_html_decode(shortcode_atts(array(
			// Individual params
			"type" => "square",
			"style" => "filled",
			"size" => "small",
			"icon" => "",
			"color" => "",
			"bg_color" => "",
			"link" => "",
			"target" => "",
			"align" => "",
			"rel" => "",
			"popup" => "no",
			// Common params
			"id" => "",
			"class" => "",
			"css" => "",
			"animation" => "",
			"width" => "",
			"height" => "",
			"top" => "",
			"bottom" => "",
			"left" => "",
			"right" => ""
		), $atts)));
		$class .= ($class ? ' ' : '') . lifecoach_get_css_position_as_classes($top, $right, $bottom, $left);
		$css .= lifecoach_get_css_dimensions_from_values($width, $height)
			. ($color !== '' ? 'color:' . esc_attr($color) .';' : '')
			. ($bg_color !== '' ? 'background-color:' . esc_attr($bg_color) . '; border-color:'. esc_attr($bg_color) .';' : '');
		if (lifecoach_param_is_on($popup)) lifecoach_enqueue_popup('magnific');
		$output = '<a href="' . (empty($link) ? '#' : $link) . '"'
			. (!empty($target) ? ' target="'.esc_attr($target).'"' : '')
			. (!empty($rel) ? ' rel="'.esc_attr($rel).'"' : '')
			. (!lifecoach_param_is_off($animation) ? ' data-animation="'.esc_attr(lifecoach_get_animation_classes($animation)).'"' : '')
			. ' class="sc_button sc_button_' . esc_attr($type) 
					. ' sc_button_style_' . esc_attr($style) 
					. ' sc_button_size_' . esc_attr($size)
					. ($align && $align!='none' ? ' align'.esc_attr($align) : '') 
					. (!empty($class) ? ' '.esc_attr($class) : '')
					. ($icon!='' ? '  sc_button_iconed '. esc_attr($icon) : '') 
					. (lifecoach_param_is_on($popup) ? ' sc_popup_link' : '') 
					. '"'
			. ($id ? ' id="'.esc_attr($id).'"' : '') 
			. ($css!='' ? ' style="'.esc_attr($css).'"' : '') 
			. '>'
			. do_shortcode($content)
			. '</a>';
		return apply_filters('lifecoach_shortcode_output', $output, 'trx_button', $atts, $content);
	}
	lifecoach_require_shortcode('trx_button', 'lifecoach_sc_button');
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'lifecoach_sc_button_reg_shortcodes' ) ) {
	//add_action('lifecoach_action_shortcodes_list', 'lifecoach_sc_button_reg_shortcodes');
	function lifecoach_sc_button_reg_shortcodes() {
	
		lifecoach_sc_map("trx_button", array(
			"title" => esc_html__("Button", 'lifecoach'),
			"desc" => wp_kses_data( __("Button with link", 'lifecoach') ),
			"decorate" => false,
			"container" => true,
			"params" => array(
				"_content_" => array(
					"title" => esc_html__("Caption", 'lifecoach'),
					"desc" => wp_kses_data( __("Button caption", 'lifecoach') ),
					"value" => "",
					"type" => "text"
				),
				"type" => array(
					"title" => esc_html__("Button's shape", 'lifecoach'),
					"desc" => wp_kses_data( __("Select button's shape", 'lifecoach') ),
					"value" => "square",
					"size" => "medium",
					"options" => array(
						'square' => esc_html__('Square', 'lifecoach'),
						'round' => esc_html__('Round', 'lifecoach')
					),
					"type" => "switch"
				), 
				"style" => array(
					"title" => esc_html__("Button's style", 'lifecoach'),
					"desc" => wp_kses_data( __("Select button's style", 'lifecoach') ),
					"value" => "default",
					"dir" => "horizontal",
					"options" => array(
						'filled' => esc_html__('Filled', 'lifecoach'),
						'border' => esc_html__('Border', 'lifecoach')
					),
					"type" => "checklist"
				), 
				"size" => array(
					"title" => esc_html__("Button's size", 'lifecoach'),
					"desc" => wp_kses_data( __("Select button's size", 'lifecoach') ),
					"value" => "small",
					"dir" => "horizontal",
					"options" => array(
						'small' => esc_html__('Small', 'lifecoach'),
						'medium' => esc_html__('Medium', 'lifecoach'),
						'large' => esc_html__('Large', 'lifecoach')
					),
					"type" => "checklist"
				), 
				"icon" => array(
					"title" => esc_html__("Button's icon",  'lifecoach'),
					"desc" => wp_kses_data( __('Select icon for the title from Fontello icons set',  'lifecoach') ),
					"value" => "",
					"type" => "icons",
					"options" => lifecoach_get_sc_param('icons')
				),
				"color" => array(
					"title" => esc_html__("Button's text color", 'lifecoach'),
					"desc" => wp_kses_data( __("Any color for button's caption", 'lifecoach') ),
					"std" => "",
					"value" => "",
					"type" => "color"
				),
				"bg_color" => array(
					"title" => esc_html__("Button's backcolor", 'lifecoach'),
					"desc" => wp_kses_data( __("Any color for button's background", 'lifecoach') ),
					"value" => "",
					"type" => "color"
				),
				"align" => array(
					"title" => esc_html__("Button's alignment", 'lifecoach'),
					"desc" => wp_kses_data( __("Align button to left, center or right", 'lifecoach') ),
					"value" => "none",
					"type" => "checklist",
					"dir" => "horizontal",
					"options" => lifecoach_get_sc_param('align')
				), 
				"link" => array(
					"title" => esc_html__("Link URL", 'lifecoach'),
					"desc" => wp_kses_data( __("URL for link on button click", 'lifecoach') ),
					"divider" => true,
					"value" => "",
					"type" => "text"
				),
				"target" => array(
					"title" => esc_html__("Link target", 'lifecoach'),
					"desc" => wp_kses_data( __("Target for link on button click", 'lifecoach') ),
					"dependency" => array(
						'link' => array('not_empty')
					),
					"value" => "",
					"type" => "text"
				),
				"popup" => array(
					"title" => esc_html__("Open link in popup", 'lifecoach'),
					"desc" => wp_kses_data( __("Open link target in popup window", 'lifecoach') ),
					"dependency" => array(
						'link' => array('not_empty')
					),
					"value" => "no",
					"type" => "switch",
					"options" => lifecoach_get_sc_param('yes_no')
				), 
				"rel" => array(
					"title" => esc_html__("Rel attribute", 'lifecoach'),
					"desc" => wp_kses_data( __("Rel attribute for button's link (if need)", 'lifecoach') ),
					"dependency" => array(
						'link' => array('not_empty')
					),
					"value" => "",
					"type" => "text"
				),
				"width" => lifecoach_shortcodes_width(),
				"height" => lifecoach_shortcodes_height(),
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
if ( !function_exists( 'lifecoach_sc_button_reg_shortcodes_vc' ) ) {
	//add_action('lifecoach_action_shortcodes_list_vc', 'lifecoach_sc_button_reg_shortcodes_vc');
	function lifecoach_sc_button_reg_shortcodes_vc() {
	
		vc_map( array(
			"base" => "trx_button",
			"name" => esc_html__("Button", 'lifecoach'),
			"description" => wp_kses_data( __("Button with link", 'lifecoach') ),
			"category" => esc_html__('Content', 'lifecoach'),
			'icon' => 'icon_trx_button',
			"class" => "trx_sc_single trx_sc_button",
			"content_element" => true,
			"is_container" => false,
			"show_settings_on_create" => true,
			"params" => array(
				array(
					"param_name" => "content",
					"heading" => esc_html__("Caption", 'lifecoach'),
					"description" => wp_kses_data( __("Button caption", 'lifecoach') ),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "type",
					"heading" => esc_html__("Button's shape", 'lifecoach'),
					"description" => wp_kses_data( __("Select button's shape", 'lifecoach') ),
					"class" => "",
					"value" => array(
						esc_html__('Square', 'lifecoach') => 'square',
						esc_html__('Round', 'lifecoach') => 'round'
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "style",
					"heading" => esc_html__("Button's style", 'lifecoach'),
					"description" => wp_kses_data( __("Select button's style", 'lifecoach') ),
					"class" => "",
					"value" => array(
						esc_html__('Filled', 'lifecoach') => 'filled',
						esc_html__('Border', 'lifecoach') => 'border'
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "size",
					"heading" => esc_html__("Button's size", 'lifecoach'),
					"description" => wp_kses_data( __("Select button's size", 'lifecoach') ),
					"admin_label" => true,
					"class" => "",
					"value" => array(
						esc_html__('Small', 'lifecoach') => 'small',
						esc_html__('Medium', 'lifecoach') => 'medium',
						esc_html__('Large', 'lifecoach') => 'large'
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "icon",
					"heading" => esc_html__("Button's icon", 'lifecoach'),
					"description" => wp_kses_data( __("Select icon for the title from Fontello icons set", 'lifecoach') ),
					"class" => "",
					"value" => lifecoach_get_sc_param('icons'),
					"type" => "dropdown"
				),
				array(
					"param_name" => "color",
					"heading" => esc_html__("Button's text color", 'lifecoach'),
					"description" => wp_kses_data( __("Any color for button's caption", 'lifecoach') ),
					"class" => "",
					"value" => "",
					"type" => "colorpicker"
				),
				array(
					"param_name" => "bg_color",
					"heading" => esc_html__("Button's backcolor", 'lifecoach'),
					"description" => wp_kses_data( __("Any color for button's background", 'lifecoach') ),
					"class" => "",
					"value" => "",
					"type" => "colorpicker"
				),
				array(
					"param_name" => "align",
					"heading" => esc_html__("Button's alignment", 'lifecoach'),
					"description" => wp_kses_data( __("Align button to left, center or right", 'lifecoach') ),
					"class" => "",
					"value" => array_flip(lifecoach_get_sc_param('align')),
					"type" => "dropdown"
				),
				array(
					"param_name" => "link",
					"heading" => esc_html__("Link URL", 'lifecoach'),
					"description" => wp_kses_data( __("URL for the link on button click", 'lifecoach') ),
					"class" => "",
					"group" => esc_html__('Link', 'lifecoach'),
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "target",
					"heading" => esc_html__("Link target", 'lifecoach'),
					"description" => wp_kses_data( __("Target for the link on button click", 'lifecoach') ),
					"class" => "",
					"group" => esc_html__('Link', 'lifecoach'),
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "popup",
					"heading" => esc_html__("Open link in popup", 'lifecoach'),
					"description" => wp_kses_data( __("Open link target in popup window", 'lifecoach') ),
					"class" => "",
					"group" => esc_html__('Link', 'lifecoach'),
					"value" => array(esc_html__('Open in popup', 'lifecoach') => 'yes'),
					"type" => "checkbox"
				),
				array(
					"param_name" => "rel",
					"heading" => esc_html__("Rel attribute", 'lifecoach'),
					"description" => wp_kses_data( __("Rel attribute for the button's link (if need", 'lifecoach') ),
					"class" => "",
					"group" => esc_html__('Link', 'lifecoach'),
					"value" => "",
					"type" => "textfield"
				),
				lifecoach_get_vc_param('id'),
				lifecoach_get_vc_param('class'),
				lifecoach_get_vc_param('animation'),
				lifecoach_get_vc_param('css'),
				lifecoach_vc_width(),
				lifecoach_vc_height(),
				lifecoach_get_vc_param('margin_top'),
				lifecoach_get_vc_param('margin_bottom'),
				lifecoach_get_vc_param('margin_left'),
				lifecoach_get_vc_param('margin_right')
			),
			'js_view' => 'VcTrxTextView'
		) );
		
		class WPBakeryShortCode_Trx_Button extends LIFECOACH_VC_ShortCodeSingle {}
	}
}
?>