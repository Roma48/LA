<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('lifecoach_sc_tooltip_theme_setup')) {
	add_action( 'lifecoach_action_before_init_theme', 'lifecoach_sc_tooltip_theme_setup' );
	function lifecoach_sc_tooltip_theme_setup() {
		add_action('lifecoach_action_shortcodes_list', 		'lifecoach_sc_tooltip_reg_shortcodes');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_tooltip id="unique_id" title="Tooltip text here"]Et adipiscing integer, scelerisque pid, augue mus vel tincidunt porta[/tooltip]
*/

if (!function_exists('lifecoach_sc_tooltip')) {	
	function lifecoach_sc_tooltip($atts, $content=null){	
		if (lifecoach_in_shortcode_blogger()) return '';
		extract(lifecoach_html_decode(shortcode_atts(array(
			// Individual params
			"title" => "",
			// Common params
			"id" => "",
			"class" => "",
			"css" => ""
		), $atts)));
		$output = '<span' . ($id ? ' id="'.esc_attr($id).'"' : '') 
					. ' class="sc_tooltip_parent'. (!empty($class) ? ' '.esc_attr($class) : '').'"'
					. ($css!='' ? ' style="'.esc_attr($css).'"' : '') 
					. '>'
						. do_shortcode($content)
						. '<span class="sc_tooltip">' . ($title) . '</span>'
					. '</span>';
		return apply_filters('lifecoach_shortcode_output', $output, 'trx_tooltip', $atts, $content);
	}
	lifecoach_require_shortcode('trx_tooltip', 'lifecoach_sc_tooltip');
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'lifecoach_sc_tooltip_reg_shortcodes' ) ) {
	//add_action('lifecoach_action_shortcodes_list', 'lifecoach_sc_tooltip_reg_shortcodes');
	function lifecoach_sc_tooltip_reg_shortcodes() {
	
		lifecoach_sc_map("trx_tooltip", array(
			"title" => esc_html__("Tooltip", 'lifecoach'),
			"desc" => wp_kses_data( __("Create tooltip for selected text", 'lifecoach') ),
			"decorate" => false,
			"container" => true,
			"params" => array(
				"title" => array(
					"title" => esc_html__("Title", 'lifecoach'),
					"desc" => wp_kses_data( __("Tooltip title (required)", 'lifecoach') ),
					"value" => "",
					"type" => "text"
				),
				"_content_" => array(
					"title" => esc_html__("Tipped content", 'lifecoach'),
					"desc" => wp_kses_data( __("Highlighted content with tooltip", 'lifecoach') ),
					"divider" => true,
					"rows" => 4,
					"value" => "",
					"type" => "textarea"
				),
				"id" => lifecoach_get_sc_param('id'),
				"class" => lifecoach_get_sc_param('class'),
				"css" => lifecoach_get_sc_param('css')
			)
		));
	}
}
?>