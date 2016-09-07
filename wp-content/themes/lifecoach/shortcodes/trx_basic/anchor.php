<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('lifecoach_sc_anchor_theme_setup')) {
	add_action( 'lifecoach_action_before_init_theme', 'lifecoach_sc_anchor_theme_setup' );
	function lifecoach_sc_anchor_theme_setup() {
		add_action('lifecoach_action_shortcodes_list', 		'lifecoach_sc_anchor_reg_shortcodes');
		if (function_exists('lifecoach_exists_visual_composer') && lifecoach_exists_visual_composer())
			add_action('lifecoach_action_shortcodes_list_vc','lifecoach_sc_anchor_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_anchor id="unique_id" description="Anchor description" title="Short Caption" icon="icon-class"]
*/

if (!function_exists('lifecoach_sc_anchor')) {	
	function lifecoach_sc_anchor($atts, $content = null) {
		if (lifecoach_in_shortcode_blogger()) return '';
		extract(lifecoach_html_decode(shortcode_atts(array(
			// Individual params
			"title" => "",
			"description" => '',
			"icon" => '',
			"url" => "",
			"separator" => "no",
			// Common params
			"id" => ""
		), $atts)));
		$output = $id 
			? '<a id="'.esc_attr($id).'"'
				. ' class="sc_anchor"' 
				. ' title="' . ($title ? esc_attr($title) : '') . '"'
				. ' data-description="' . ($description ? esc_attr(lifecoach_strmacros($description)) : ''). '"'
				. ' data-icon="' . ($icon ? $icon : '') . '"' 
				. ' data-url="' . ($url ? esc_attr($url) : '') . '"' 
				. ' data-separator="' . (lifecoach_param_is_on($separator) ? 'yes' : 'no') . '"'
				. '></a>'
			: '';
		return apply_filters('lifecoach_shortcode_output', $output, 'trx_anchor', $atts, $content);
	}
	lifecoach_require_shortcode("trx_anchor", "lifecoach_sc_anchor");
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'lifecoach_sc_anchor_reg_shortcodes' ) ) {
	//add_action('lifecoach_action_shortcodes_list', 'lifecoach_sc_anchor_reg_shortcodes');
	function lifecoach_sc_anchor_reg_shortcodes() {
	
		lifecoach_sc_map("trx_anchor", array(
			"title" => esc_html__("Anchor", 'lifecoach'),
			"desc" => wp_kses_data( __("Insert anchor for the TOC (table of content)", 'lifecoach') ),
			"decorate" => false,
			"container" => false,
			"params" => array(
				"icon" => array(
					"title" => esc_html__("Anchor's icon",  'lifecoach'),
					"desc" => wp_kses_data( __('Select icon for the anchor from Fontello icons set',  'lifecoach') ),
					"value" => "",
					"type" => "icons",
					"options" => lifecoach_get_sc_param('icons')
				),
				"title" => array(
					"title" => esc_html__("Short title", 'lifecoach'),
					"desc" => wp_kses_data( __("Short title of the anchor (for the table of content)", 'lifecoach') ),
					"value" => "",
					"type" => "text"
				),
				"description" => array(
					"title" => esc_html__("Long description", 'lifecoach'),
					"desc" => wp_kses_data( __("Description for the popup (then hover on the icon). You can use:<br>'{{' and '}}' - to make the text italic,<br>'((' and '))' - to make the text bold,<br>'||' - to insert line break", 'lifecoach') ),
					"value" => "",
					"type" => "text"
				),
				"url" => array(
					"title" => esc_html__("External URL", 'lifecoach'),
					"desc" => wp_kses_data( __("External URL for this TOC item", 'lifecoach') ),
					"value" => "",
					"type" => "text"
				),
				"separator" => array(
					"title" => esc_html__("Add separator", 'lifecoach'),
					"desc" => wp_kses_data( __("Add separator under item in the TOC", 'lifecoach') ),
					"value" => "no",
					"type" => "switch",
					"options" => lifecoach_get_sc_param('yes_no')
				),
				"id" => lifecoach_get_sc_param('id')
			)
		));
	}
}


/* Register shortcode in the VC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'lifecoach_sc_anchor_reg_shortcodes_vc' ) ) {
	//add_action('lifecoach_action_shortcodes_list_vc', 'lifecoach_sc_anchor_reg_shortcodes_vc');
	function lifecoach_sc_anchor_reg_shortcodes_vc() {
	
		vc_map( array(
			"base" => "trx_anchor",
			"name" => esc_html__("Anchor", 'lifecoach'),
			"description" => wp_kses_data( __("Insert anchor for the TOC (table of content)", 'lifecoach') ),
			"category" => esc_html__('Content', 'lifecoach'),
			'icon' => 'icon_trx_anchor',
			"class" => "trx_sc_single trx_sc_anchor",
			"content_element" => true,
			"is_container" => false,
			"show_settings_on_create" => true,
			"params" => array(
				array(
					"param_name" => "icon",
					"heading" => esc_html__("Anchor's icon", 'lifecoach'),
					"description" => wp_kses_data( __("Select icon for the anchor from Fontello icons set", 'lifecoach') ),
					"class" => "",
					"value" => lifecoach_get_sc_param('icons'),
					"type" => "dropdown"
				),
				array(
					"param_name" => "title",
					"heading" => esc_html__("Short title", 'lifecoach'),
					"description" => wp_kses_data( __("Short title of the anchor (for the table of content)", 'lifecoach') ),
					"admin_label" => true,
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "description",
					"heading" => esc_html__("Long description", 'lifecoach'),
					"description" => wp_kses_data( __("Description for the popup (then hover on the icon). You can use:<br>'{{' and '}}' - to make the text italic,<br>'((' and '))' - to make the text bold,<br>'||' - to insert line break", 'lifecoach') ),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "url",
					"heading" => esc_html__("External URL", 'lifecoach'),
					"description" => wp_kses_data( __("External URL for this TOC item", 'lifecoach') ),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "separator",
					"heading" => esc_html__("Add separator", 'lifecoach'),
					"description" => wp_kses_data( __("Add separator under item in the TOC", 'lifecoach') ),
					"class" => "",
					"value" => array("Add separator" => "yes" ),
					"type" => "checkbox"
				),
				lifecoach_get_vc_param('id')
			),
		) );
		
		class WPBakeryShortCode_Trx_Anchor extends LIFECOACH_VC_ShortCodeSingle {}
	}
}
?>