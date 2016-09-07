<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('lifecoach_sc_gap_theme_setup')) {
	add_action( 'lifecoach_action_before_init_theme', 'lifecoach_sc_gap_theme_setup' );
	function lifecoach_sc_gap_theme_setup() {
		add_action('lifecoach_action_shortcodes_list', 		'lifecoach_sc_gap_reg_shortcodes');
		if (function_exists('lifecoach_exists_visual_composer') && lifecoach_exists_visual_composer())
			add_action('lifecoach_action_shortcodes_list_vc','lifecoach_sc_gap_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

//[trx_gap]Fullwidth content[/trx_gap]

if (!function_exists('lifecoach_sc_gap')) {	
	function lifecoach_sc_gap($atts, $content = null) {
		if (lifecoach_in_shortcode_blogger()) return '';
		$output = lifecoach_gap_start() . do_shortcode($content) . lifecoach_gap_end();
		return apply_filters('lifecoach_shortcode_output', $output, 'trx_gap', $atts, $content);
	}
	lifecoach_require_shortcode("trx_gap", "lifecoach_sc_gap");
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'lifecoach_sc_gap_reg_shortcodes' ) ) {
	//add_action('lifecoach_action_shortcodes_list', 'lifecoach_sc_gap_reg_shortcodes');
	function lifecoach_sc_gap_reg_shortcodes() {
	
		lifecoach_sc_map("trx_gap", array(
			"title" => esc_html__("Gap", 'lifecoach'),
			"desc" => wp_kses_data( __("Insert gap (fullwidth area) in the post content. Attention! Use the gap only in the posts (pages) without left or right sidebar", 'lifecoach') ),
			"decorate" => true,
			"container" => true,
			"params" => array(
				"_content_" => array(
					"title" => esc_html__("Gap content", 'lifecoach'),
					"desc" => wp_kses_data( __("Gap inner content", 'lifecoach') ),
					"rows" => 4,
					"value" => "",
					"type" => "textarea"
				)
			)
		));
	}
}


/* Register shortcode in the VC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'lifecoach_sc_gap_reg_shortcodes_vc' ) ) {
	//add_action('lifecoach_action_shortcodes_list_vc', 'lifecoach_sc_gap_reg_shortcodes_vc');
	function lifecoach_sc_gap_reg_shortcodes_vc() {
	
		vc_map( array(
			"base" => "trx_gap",
			"name" => esc_html__("Gap", 'lifecoach'),
			"description" => wp_kses_data( __("Insert gap (fullwidth area) in the post content", 'lifecoach') ),
			"category" => esc_html__('Structure', 'lifecoach'),
			'icon' => 'icon_trx_gap',
			"class" => "trx_sc_collection trx_sc_gap",
			"content_element" => true,
			"is_container" => true,
			"show_settings_on_create" => false,
			"params" => array(
				/*
				array(
					"param_name" => "content",
					"heading" => esc_html__("Gap content", 'lifecoach'),
					"description" => wp_kses_data( __("Gap inner content", 'lifecoach') ),
					"class" => "",
					"value" => "",
					"type" => "textarea_html"
				)
				*/
			)
		) );
		
		class WPBakeryShortCode_Trx_Gap extends LIFECOACH_VC_ShortCodeCollection {}
	}
}
?>