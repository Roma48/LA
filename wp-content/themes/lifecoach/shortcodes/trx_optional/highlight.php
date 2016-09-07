<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('lifecoach_sc_highlight_theme_setup')) {
	add_action( 'lifecoach_action_before_init_theme', 'lifecoach_sc_highlight_theme_setup' );
	function lifecoach_sc_highlight_theme_setup() {
		add_action('lifecoach_action_shortcodes_list', 		'lifecoach_sc_highlight_reg_shortcodes');
		if (function_exists('lifecoach_exists_visual_composer') && lifecoach_exists_visual_composer())
			add_action('lifecoach_action_shortcodes_list_vc','lifecoach_sc_highlight_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_highlight id="unique_id" color="fore_color's_name_or_#rrggbb" backcolor="back_color's_name_or_#rrggbb" style="custom_style"]Et adipiscing integer, scelerisque pid, augue mus vel tincidunt porta[/trx_highlight]
*/

if (!function_exists('lifecoach_sc_highlight')) {	
	function lifecoach_sc_highlight($atts, $content=null){	
		if (lifecoach_in_shortcode_blogger()) return '';
		extract(lifecoach_html_decode(shortcode_atts(array(
			// Individual params
			"color" => "",
			"bg_color" => "",
			"font_size" => "",
			"type" => "1",
			// Common params
			"id" => "",
			"class" => "",
			"css" => ""
		), $atts)));
		$css .= ($color != '' ? 'color:' . esc_attr($color) . ';' : '')
			.($bg_color != '' ? 'background-color:' . esc_attr($bg_color) . ';' : '')
			.($font_size != '' ? 'font-size:' . esc_attr(lifecoach_prepare_css_value($font_size)) . '; line-height: 1em;' : '');
		$output = '<span' . ($id ? ' id="'.esc_attr($id).'"' : '') 
				. ' class="sc_highlight'.($type>0 ? ' sc_highlight_style_'.esc_attr($type) : ''). (!empty($class) ? ' '.esc_attr($class) : '').'"'
				. ($css!='' ? ' style="'.esc_attr($css).'"' : '')
				. '>' 
				. do_shortcode($content) 
				. '</span>';
		return apply_filters('lifecoach_shortcode_output', $output, 'trx_highlight', $atts, $content);
	}
	lifecoach_require_shortcode('trx_highlight', 'lifecoach_sc_highlight');
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'lifecoach_sc_highlight_reg_shortcodes' ) ) {
	//add_action('lifecoach_action_shortcodes_list', 'lifecoach_sc_highlight_reg_shortcodes');
	function lifecoach_sc_highlight_reg_shortcodes() {
	
		lifecoach_sc_map("trx_highlight", array(
			"title" => esc_html__("Highlight text", 'lifecoach'),
			"desc" => wp_kses_data( __("Highlight text with selected color, background color and other styles", 'lifecoach') ),
			"decorate" => false,
			"container" => true,
			"params" => array(
				"type" => array(
					"title" => esc_html__("Type", 'lifecoach'),
					"desc" => wp_kses_data( __("Highlight type", 'lifecoach') ),
					"value" => "1",
					"type" => "checklist",
					"options" => array(
						0 => esc_html__('Custom', 'lifecoach'),
						1 => esc_html__('Type 1', 'lifecoach'),
						2 => esc_html__('Type 2', 'lifecoach'),
						3 => esc_html__('Type 3', 'lifecoach')
					)
				),
				"color" => array(
					"title" => esc_html__("Color", 'lifecoach'),
					"desc" => wp_kses_data( __("Color for the highlighted text", 'lifecoach') ),
					"divider" => true,
					"value" => "",
					"type" => "color"
				),
				"bg_color" => array(
					"title" => esc_html__("Background color", 'lifecoach'),
					"desc" => wp_kses_data( __("Background color for the highlighted text", 'lifecoach') ),
					"value" => "",
					"type" => "color"
				),
				"font_size" => array(
					"title" => esc_html__("Font size", 'lifecoach'),
					"desc" => wp_kses_data( __("Font size of the highlighted text (default - in pixels, allows any CSS units of measure)", 'lifecoach') ),
					"value" => "",
					"type" => "text"
				),
				"_content_" => array(
					"title" => esc_html__("Highlighting content", 'lifecoach'),
					"desc" => wp_kses_data( __("Content for highlight", 'lifecoach') ),
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


/* Register shortcode in the VC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'lifecoach_sc_highlight_reg_shortcodes_vc' ) ) {
	//add_action('lifecoach_action_shortcodes_list_vc', 'lifecoach_sc_highlight_reg_shortcodes_vc');
	function lifecoach_sc_highlight_reg_shortcodes_vc() {
	
		vc_map( array(
			"base" => "trx_highlight",
			"name" => esc_html__("Highlight text", 'lifecoach'),
			"description" => wp_kses_data( __("Highlight text with selected color, background color and other styles", 'lifecoach') ),
			"category" => esc_html__('Content', 'lifecoach'),
			'icon' => 'icon_trx_highlight',
			"class" => "trx_sc_single trx_sc_highlight",
			"content_element" => true,
			"is_container" => false,
			"show_settings_on_create" => true,
			"params" => array(
				array(
					"param_name" => "type",
					"heading" => esc_html__("Type", 'lifecoach'),
					"description" => wp_kses_data( __("Highlight type", 'lifecoach') ),
					"admin_label" => true,
					"class" => "",
					"value" => array(
							esc_html__('Custom', 'lifecoach') => 0,
							esc_html__('Type 1', 'lifecoach') => 1,
							esc_html__('Type 2', 'lifecoach') => 2,
							esc_html__('Type 3', 'lifecoach') => 3
						),
					"type" => "dropdown"
				),
				array(
					"param_name" => "color",
					"heading" => esc_html__("Text color", 'lifecoach'),
					"description" => wp_kses_data( __("Color for the highlighted text", 'lifecoach') ),
					"class" => "",
					"value" => "",
					"type" => "colorpicker"
				),
				array(
					"param_name" => "bg_color",
					"heading" => esc_html__("Background color", 'lifecoach'),
					"description" => wp_kses_data( __("Background color for the highlighted text", 'lifecoach') ),
					"class" => "",
					"value" => "",
					"type" => "colorpicker"
				),
				array(
					"param_name" => "font_size",
					"heading" => esc_html__("Font size", 'lifecoach'),
					"description" => wp_kses_data( __("Font size for the highlighted text (default - in pixels, allows any CSS units of measure)", 'lifecoach') ),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "content",
					"heading" => esc_html__("Highlight text", 'lifecoach'),
					"description" => wp_kses_data( __("Content for highlight", 'lifecoach') ),
					"class" => "",
					"value" => "",
					"type" => "textarea_html"
				),
				lifecoach_get_vc_param('id'),
				lifecoach_get_vc_param('class'),
				lifecoach_get_vc_param('css')
			),
			'js_view' => 'VcTrxTextView'
		) );
		
		class WPBakeryShortCode_Trx_Highlight extends LIFECOACH_VC_ShortCodeSingle {}
	}
}
?>