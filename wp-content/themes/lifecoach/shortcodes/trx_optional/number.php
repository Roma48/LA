<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('lifecoach_sc_number_theme_setup')) {
	add_action( 'lifecoach_action_before_init_theme', 'lifecoach_sc_number_theme_setup' );
	function lifecoach_sc_number_theme_setup() {
		add_action('lifecoach_action_shortcodes_list', 		'lifecoach_sc_number_reg_shortcodes');
		if (function_exists('lifecoach_exists_visual_composer') && lifecoach_exists_visual_composer())
			add_action('lifecoach_action_shortcodes_list_vc','lifecoach_sc_number_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_number id="unique_id" value="400"]
*/

if (!function_exists('lifecoach_sc_number')) {	
	function lifecoach_sc_number($atts, $content=null){	
		if (lifecoach_in_shortcode_blogger()) return '';
		extract(lifecoach_html_decode(shortcode_atts(array(
			// Individual params
			"value" => "",
			"align" => "",
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
		$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
				. ' class="sc_number' 
					. (!empty($align) ? ' align'.esc_attr($align) : '') 
					. (!empty($class) ? ' '.esc_attr($class) : '') 
					. '"'
				. (!lifecoach_param_is_off($animation) ? ' data-animation="'.esc_attr(lifecoach_get_animation_classes($animation)).'"' : '')
				. ($css!='' ? ' style="'.esc_attr($css).'"' : '')
				. '>';
		for ($i=0; $i < lifecoach_strlen($value); $i++) {
			$output .= '<span class="sc_number_item">' . trim(lifecoach_substr($value, $i, 1)) . '</span>';
		}
		$output .= '</div>';
		return apply_filters('lifecoach_shortcode_output', $output, 'trx_number', $atts, $content);
	}
	lifecoach_require_shortcode('trx_number', 'lifecoach_sc_number');
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'lifecoach_sc_number_reg_shortcodes' ) ) {
	//add_action('lifecoach_action_shortcodes_list', 'lifecoach_sc_number_reg_shortcodes');
	function lifecoach_sc_number_reg_shortcodes() {
	
		lifecoach_sc_map("trx_number", array(
			"title" => esc_html__("Number", 'lifecoach'),
			"desc" => wp_kses_data( __("Insert number or any word as set separate characters", 'lifecoach') ),
			"decorate" => false,
			"container" => false,
			"params" => array(
				"value" => array(
					"title" => esc_html__("Value", 'lifecoach'),
					"desc" => wp_kses_data( __("Number or any word", 'lifecoach') ),
					"value" => "",
					"type" => "text"
				),
				"align" => array(
					"title" => esc_html__("Align", 'lifecoach'),
					"desc" => wp_kses_data( __("Select block alignment", 'lifecoach') ),
					"value" => "none",
					"type" => "checklist",
					"dir" => "horizontal",
					"options" => lifecoach_get_sc_param('align')
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
if ( !function_exists( 'lifecoach_sc_number_reg_shortcodes_vc' ) ) {
	//add_action('lifecoach_action_shortcodes_list_vc', 'lifecoach_sc_number_reg_shortcodes_vc');
	function lifecoach_sc_number_reg_shortcodes_vc() {
	
		vc_map( array(
			"base" => "trx_number",
			"name" => esc_html__("Number", 'lifecoach'),
			"description" => wp_kses_data( __("Insert number or any word as set of separated characters", 'lifecoach') ),
			"category" => esc_html__('Content', 'lifecoach'),
			"class" => "trx_sc_single trx_sc_number",
			'icon' => 'icon_trx_number',
			"content_element" => true,
			"is_container" => false,
			"show_settings_on_create" => true,
			"params" => array(
				array(
					"param_name" => "value",
					"heading" => esc_html__("Value", 'lifecoach'),
					"description" => wp_kses_data( __("Number or any word to separate", 'lifecoach') ),
					"admin_label" => true,
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "align",
					"heading" => esc_html__("Alignment", 'lifecoach'),
					"description" => wp_kses_data( __("Select block alignment", 'lifecoach') ),
					"class" => "",
					"value" => array_flip(lifecoach_get_sc_param('align')),
					"type" => "dropdown"
				),
				lifecoach_get_vc_param('id'),
				lifecoach_get_vc_param('class'),
				lifecoach_get_vc_param('animation'),
				lifecoach_get_vc_param('css'),
				lifecoach_get_vc_param('margin_top'),
				lifecoach_get_vc_param('margin_bottom'),
				lifecoach_get_vc_param('margin_left'),
				lifecoach_get_vc_param('margin_right')
			)
		) );
		
		class WPBakeryShortCode_Trx_Number extends LIFECOACH_VC_ShortCodeSingle {}
	}
}
?>