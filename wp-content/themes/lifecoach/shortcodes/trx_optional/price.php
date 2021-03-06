<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('lifecoach_sc_price_theme_setup')) {
	add_action( 'lifecoach_action_before_init_theme', 'lifecoach_sc_price_theme_setup' );
	function lifecoach_sc_price_theme_setup() {
		add_action('lifecoach_action_shortcodes_list', 		'lifecoach_sc_price_reg_shortcodes');
		if (function_exists('lifecoach_exists_visual_composer') && lifecoach_exists_visual_composer())
			add_action('lifecoach_action_shortcodes_list_vc','lifecoach_sc_price_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_price id="unique_id" currency="$" money="29.99" period="monthly"]
*/

if (!function_exists('lifecoach_sc_price')) {	
	function lifecoach_sc_price($atts, $content=null){	
		if (lifecoach_in_shortcode_blogger()) return '';
		extract(lifecoach_html_decode(shortcode_atts(array(
			// Individual params
			"money" => "",
			"currency" => "$",
			"period" => "",
			"align" => "",
			// Common params
			"id" => "",
			"class" => "",
			"css" => "",
			"top" => "",
			"bottom" => "",
			"left" => "",
			"right" => ""
		), $atts)));
		$output = '';
		if (!empty($money)) {
			$class .= ($class ? ' ' : '') . lifecoach_get_css_position_as_classes($top, $right, $bottom, $left);
			$m = explode('.', str_replace(',', '.', $money));
			$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
					. ' class="sc_price'
					. (!empty($class) ? ' '.esc_attr($class) : '')
					. ($align && $align!='none' ? ' align'.esc_attr($align) : '') 
					. '"'
					. ($css!='' ? ' style="'.esc_attr($css).'"' : '')
					. '>'
				. '<span class="sc_price_currency">'.($currency).'</span>'
				. '<span class="sc_price_money">'.($m[0]).'</span>'
				. (!empty($m[1]) ? '<span class="sc_price_info">' : '')
				. (!empty($m[1]) ? '<span class="sc_price_penny">'.($m[1]).'</span>' : '')
				. (!empty($period) ? '<span class="sc_price_period">'.($period).'</span>' : (!empty($m[1]) ? '<span class="sc_price_period_empty"></span>' : ''))
				. (!empty($m[1]) ? '</span>' : '')
				. '</div>';
		}
		return apply_filters('lifecoach_shortcode_output', $output, 'trx_price', $atts, $content);
	}
	lifecoach_require_shortcode('trx_price', 'lifecoach_sc_price');
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'lifecoach_sc_price_reg_shortcodes' ) ) {
	//add_action('lifecoach_action_shortcodes_list', 'lifecoach_sc_price_reg_shortcodes');
	function lifecoach_sc_price_reg_shortcodes() {
	
		lifecoach_sc_map("trx_price", array(
			"title" => esc_html__("Price", 'lifecoach'),
			"desc" => wp_kses_data( __("Insert price with decoration", 'lifecoach') ),
			"decorate" => false,
			"container" => false,
			"params" => array(
				"money" => array(
					"title" => esc_html__("Money", 'lifecoach'),
					"desc" => wp_kses_data( __("Money value (dot or comma separated)", 'lifecoach') ),
					"value" => "",
					"type" => "text"
				),
				"currency" => array(
					"title" => esc_html__("Currency", 'lifecoach'),
					"desc" => wp_kses_data( __("Currency character", 'lifecoach') ),
					"value" => "$",
					"type" => "text"
				),
				"period" => array(
					"title" => esc_html__("Period", 'lifecoach'),
					"desc" => wp_kses_data( __("Period text (if need). For example: monthly, daily, etc.", 'lifecoach') ),
					"value" => "",
					"type" => "text"
				),
				"align" => array(
					"title" => esc_html__("Alignment", 'lifecoach'),
					"desc" => wp_kses_data( __("Align price to left or right side", 'lifecoach') ),
					"value" => "",
					"type" => "checklist",
					"dir" => "horizontal",
					"options" => lifecoach_get_sc_param('float')
				), 
				"top" => lifecoach_get_sc_param('top'),
				"bottom" => lifecoach_get_sc_param('bottom'),
				"left" => lifecoach_get_sc_param('left'),
				"right" => lifecoach_get_sc_param('right'),
				"id" => lifecoach_get_sc_param('id'),
				"class" => lifecoach_get_sc_param('class'),
				"css" => lifecoach_get_sc_param('css')
			)
		));
	}
}


/* Register shortcode in the VC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'lifecoach_sc_price_reg_shortcodes_vc' ) ) {
	//add_action('lifecoach_action_shortcodes_list_vc', 'lifecoach_sc_price_reg_shortcodes_vc');
	function lifecoach_sc_price_reg_shortcodes_vc() {
	
		vc_map( array(
			"base" => "trx_price",
			"name" => esc_html__("Price", 'lifecoach'),
			"description" => wp_kses_data( __("Insert price with decoration", 'lifecoach') ),
			"category" => esc_html__('Content', 'lifecoach'),
			'icon' => 'icon_trx_price',
			"class" => "trx_sc_single trx_sc_price",
			"content_element" => true,
			"is_container" => false,
			"show_settings_on_create" => true,
			"params" => array(
				array(
					"param_name" => "money",
					"heading" => esc_html__("Money", 'lifecoach'),
					"description" => wp_kses_data( __("Money value (dot or comma separated)", 'lifecoach') ),
					"admin_label" => true,
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "currency",
					"heading" => esc_html__("Currency symbol", 'lifecoach'),
					"description" => wp_kses_data( __("Currency character", 'lifecoach') ),
					"admin_label" => true,
					"class" => "",
					"value" => "$",
					"type" => "textfield"
				),
				array(
					"param_name" => "period",
					"heading" => esc_html__("Period", 'lifecoach'),
					"description" => wp_kses_data( __("Period text (if need). For example: monthly, daily, etc.", 'lifecoach') ),
					"admin_label" => true,
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "align",
					"heading" => esc_html__("Alignment", 'lifecoach'),
					"description" => wp_kses_data( __("Align price to left or right side", 'lifecoach') ),
					"admin_label" => true,
					"class" => "",
					"value" => array_flip(lifecoach_get_sc_param('float')),
					"type" => "dropdown"
				),
				lifecoach_get_vc_param('id'),
				lifecoach_get_vc_param('class'),
				lifecoach_get_vc_param('css'),
				lifecoach_get_vc_param('margin_top'),
				lifecoach_get_vc_param('margin_bottom'),
				lifecoach_get_vc_param('margin_left'),
				lifecoach_get_vc_param('margin_right')
			)
		) );
		
		class WPBakeryShortCode_Trx_Price extends LIFECOACH_VC_ShortCodeSingle {}
	}
}
?>