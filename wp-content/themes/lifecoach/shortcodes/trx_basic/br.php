<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('lifecoach_sc_br_theme_setup')) {
	add_action( 'lifecoach_action_before_init_theme', 'lifecoach_sc_br_theme_setup' );
	function lifecoach_sc_br_theme_setup() {
		add_action('lifecoach_action_shortcodes_list', 		'lifecoach_sc_br_reg_shortcodes');
		if (function_exists('lifecoach_exists_visual_composer') && lifecoach_exists_visual_composer())
			add_action('lifecoach_action_shortcodes_list_vc','lifecoach_sc_br_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_br clear="left|right|both"]
*/

if (!function_exists('lifecoach_sc_br')) {	
	function lifecoach_sc_br($atts, $content = null) {
		if (lifecoach_in_shortcode_blogger()) return '';
		extract(lifecoach_html_decode(shortcode_atts(array(
			"clear" => ""
		), $atts)));
		$output = in_array($clear, array('left', 'right', 'both', 'all')) 
			? '<div class="clearfix" style="clear:' . str_replace('all', 'both', $clear) . '"></div>'
			: '<br />';
		return apply_filters('lifecoach_shortcode_output', $output, 'trx_br', $atts, $content);
	}
	lifecoach_require_shortcode("trx_br", "lifecoach_sc_br");
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'lifecoach_sc_br_reg_shortcodes' ) ) {
	//add_action('lifecoach_action_shortcodes_list', 'lifecoach_sc_br_reg_shortcodes');
	function lifecoach_sc_br_reg_shortcodes() {
	
		lifecoach_sc_map("trx_br", array(
			"title" => esc_html__("Break", 'lifecoach'),
			"desc" => wp_kses_data( __("Line break with clear floating (if need)", 'lifecoach') ),
			"decorate" => false,
			"container" => false,
			"params" => array(
				"clear" => 	array(
					"title" => esc_html__("Clear floating", 'lifecoach'),
					"desc" => wp_kses_data( __("Clear floating (if need)", 'lifecoach') ),
					"value" => "",
					"type" => "checklist",
					"options" => array(
						'none' => esc_html__('None', 'lifecoach'),
						'left' => esc_html__('Left', 'lifecoach'),
						'right' => esc_html__('Right', 'lifecoach'),
						'both' => esc_html__('Both', 'lifecoach')
					)
				)
			)
		));
	}
}


/* Register shortcode in the VC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'lifecoach_sc_br_reg_shortcodes_vc' ) ) {
	//add_action('lifecoach_action_shortcodes_list_vc', 'lifecoach_sc_br_reg_shortcodes_vc');
	function lifecoach_sc_br_reg_shortcodes_vc() {
/*
		vc_map( array(
			"base" => "trx_br",
			"name" => esc_html__("Line break", 'lifecoach'),
			"description" => wp_kses_data( __("Line break or Clear Floating", 'lifecoach') ),
			"category" => esc_html__('Content', 'lifecoach'),
			'icon' => 'icon_trx_br',
			"class" => "trx_sc_single trx_sc_br",
			"content_element" => true,
			"is_container" => false,
			"show_settings_on_create" => true,
			"params" => array(
				array(
					"param_name" => "clear",
					"heading" => esc_html__("Clear floating", 'lifecoach'),
					"description" => wp_kses_data( __("Select clear side (if need)", 'lifecoach') ),
					"class" => "",
					"value" => "",
					"value" => array(
						esc_html__('None', 'lifecoach') => 'none',
						esc_html__('Left', 'lifecoach') => 'left',
						esc_html__('Right', 'lifecoach') => 'right',
						esc_html__('Both', 'lifecoach') => 'both'
					),
					"type" => "dropdown"
				)
			)
		) );
		
		class WPBakeryShortCode_Trx_Br extends LIFECOACH_VC_ShortCodeSingle {}
*/
	}
}
?>