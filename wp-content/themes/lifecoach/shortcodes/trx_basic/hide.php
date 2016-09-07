<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('lifecoach_sc_hide_theme_setup')) {
	add_action( 'lifecoach_action_before_init_theme', 'lifecoach_sc_hide_theme_setup' );
	function lifecoach_sc_hide_theme_setup() {
		add_action('lifecoach_action_shortcodes_list', 		'lifecoach_sc_hide_reg_shortcodes');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_hide selector="unique_id"]
*/

if (!function_exists('lifecoach_sc_hide')) {	
	function lifecoach_sc_hide($atts, $content=null){	
		if (lifecoach_in_shortcode_blogger()) return '';
		extract(lifecoach_html_decode(shortcode_atts(array(
			// Individual params
			"selector" => "",
			"hide" => "on",
			"delay" => 0
		), $atts)));
		$selector = trim(chop($selector));
		$output = $selector == '' ? '' : 
			'<script type="text/javascript">
				jQuery(document).ready(function() {
					'.($delay>0 ? 'setTimeout(function() {' : '').'
					jQuery("'.esc_attr($selector).'").' . ($hide=='on' ? 'hide' : 'show') . '();
					'.($delay>0 ? '},'.($delay).');' : '').'
				});
			</script>';
		return apply_filters('lifecoach_shortcode_output', $output, 'trx_hide', $atts, $content);
	}
	lifecoach_require_shortcode('trx_hide', 'lifecoach_sc_hide');
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'lifecoach_sc_hide_reg_shortcodes' ) ) {
	//add_action('lifecoach_action_shortcodes_list', 'lifecoach_sc_hide_reg_shortcodes');
	function lifecoach_sc_hide_reg_shortcodes() {
	
		lifecoach_sc_map("trx_hide", array(
			"title" => esc_html__("Hide/Show any block", 'lifecoach'),
			"desc" => wp_kses_data( __("Hide or Show any block with desired CSS-selector", 'lifecoach') ),
			"decorate" => false,
			"container" => false,
			"params" => array(
				"selector" => array(
					"title" => esc_html__("Selector", 'lifecoach'),
					"desc" => wp_kses_data( __("Any block's CSS-selector", 'lifecoach') ),
					"value" => "",
					"type" => "text"
				),
				"hide" => array(
					"title" => esc_html__("Hide or Show", 'lifecoach'),
					"desc" => wp_kses_data( __("New state for the block: hide or show", 'lifecoach') ),
					"value" => "yes",
					"size" => "small",
					"options" => lifecoach_get_sc_param('yes_no'),
					"type" => "switch"
				)
			)
		));
	}
}
?>