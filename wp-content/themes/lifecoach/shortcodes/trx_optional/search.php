<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('lifecoach_sc_search_theme_setup')) {
	add_action( 'lifecoach_action_before_init_theme', 'lifecoach_sc_search_theme_setup' );
	function lifecoach_sc_search_theme_setup() {
		add_action('lifecoach_action_shortcodes_list', 		'lifecoach_sc_search_reg_shortcodes');
		if (function_exists('lifecoach_exists_visual_composer') && lifecoach_exists_visual_composer())
			add_action('lifecoach_action_shortcodes_list_vc','lifecoach_sc_search_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_search id="unique_id" open="yes|no"]
*/

if (!function_exists('lifecoach_sc_search')) {	
	function lifecoach_sc_search($atts, $content=null){	
		if (lifecoach_in_shortcode_blogger()) return '';
		extract(lifecoach_html_decode(shortcode_atts(array(
			// Individual params
			"style" => "regular",
			"state" => "fixed",
			"scheme" => "original",
			"ajax" => "",
			"title" => esc_html__('Search', 'lifecoach'),
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
		if (empty($ajax)) $ajax = lifecoach_get_theme_option('use_ajax_search');
		// Load core messages
		lifecoach_enqueue_messages();
		$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') . ' class="search_wrap search_style_'.esc_attr($style).' search_state_'.esc_attr($state)
						. (lifecoach_param_is_on($ajax) ? ' search_ajax' : '')
						. ($class ? ' '.esc_attr($class) : '')
						. '"'
					. ($css!='' ? ' style="'.esc_attr($css).'"' : '')
					. (!lifecoach_param_is_off($animation) ? ' data-animation="'.esc_attr(lifecoach_get_animation_classes($animation)).'"' : '')
					. '>
						<div class="search_form_wrap">
							<form role="search" method="get" class="search_form" action="' . esc_url(home_url('/')) . '">
								<button type="submit" class="search_submit" title="' . ($state=='closed' ? esc_attr__('Open search', 'lifecoach') : esc_attr__('Start search', 'lifecoach')) . '"> '. esc_attr__('Search', 'lifecoach') . '</button>
								<input type="text" class="search_field" placeholder="' . esc_attr($title) . '" value="' . esc_attr(get_search_query()) . '" name="s" />
							</form>
						</div>
						<div class="search_results widget_area' . ($scheme && !lifecoach_param_is_off($scheme) && !lifecoach_param_is_inherit($scheme) ? ' scheme_'.esc_attr($scheme) : '') . '"><a class="search_results_close icon-cancel"></a><div class="search_results_content"></div></div>
				</div>';
		return apply_filters('lifecoach_shortcode_output', $output, 'trx_search', $atts, $content);
	}
	lifecoach_require_shortcode('trx_search', 'lifecoach_sc_search');
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'lifecoach_sc_search_reg_shortcodes' ) ) {
	//add_action('lifecoach_action_shortcodes_list', 'lifecoach_sc_search_reg_shortcodes');
	function lifecoach_sc_search_reg_shortcodes() {
	
		lifecoach_sc_map("trx_search", array(
			"title" => esc_html__("Search", 'lifecoach'),
			"desc" => wp_kses_data( __("Show search form", 'lifecoach') ),
			"decorate" => false,
			"container" => false,
			"params" => array(
				"style" => array(
					"title" => esc_html__("Style", 'lifecoach'),
					"desc" => wp_kses_data( __("Select style to display search field", 'lifecoach') ),
					"value" => "regular",
					"options" => array(
						"regular" => esc_html__('Regular', 'lifecoach'),
						"rounded" => esc_html__('Rounded', 'lifecoach')
					),
					"type" => "checklist"
				),
				"state" => array(
					"title" => esc_html__("State", 'lifecoach'),
					"desc" => wp_kses_data( __("Select search field initial state", 'lifecoach') ),
					"value" => "fixed",
					"options" => array(
						"fixed"  => esc_html__('Fixed',  'lifecoach'),
						"opened" => esc_html__('Opened', 'lifecoach'),
						"closed" => esc_html__('Closed', 'lifecoach')
					),
					"type" => "checklist"
				),
				"title" => array(
					"title" => esc_html__("Title", 'lifecoach'),
					"desc" => wp_kses_data( __("Title (placeholder) for the search field", 'lifecoach') ),
					"value" => esc_html__("Search &hellip;", 'lifecoach'),
					"type" => "text"
				),
				"ajax" => array(
					"title" => esc_html__("AJAX", 'lifecoach'),
					"desc" => wp_kses_data( __("Search via AJAX or reload page", 'lifecoach') ),
					"value" => "yes",
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
			)
		));
	}
}


/* Register shortcode in the VC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'lifecoach_sc_search_reg_shortcodes_vc' ) ) {
	//add_action('lifecoach_action_shortcodes_list_vc', 'lifecoach_sc_search_reg_shortcodes_vc');
	function lifecoach_sc_search_reg_shortcodes_vc() {
	
		vc_map( array(
			"base" => "trx_search",
			"name" => esc_html__("Search form", 'lifecoach'),
			"description" => wp_kses_data( __("Insert search form", 'lifecoach') ),
			"category" => esc_html__('Content', 'lifecoach'),
			'icon' => 'icon_trx_search',
			"class" => "trx_sc_single trx_sc_search",
			"content_element" => true,
			"is_container" => false,
			"show_settings_on_create" => true,
			"params" => array(
				array(
					"param_name" => "style",
					"heading" => esc_html__("Style", 'lifecoach'),
					"description" => wp_kses_data( __("Select style to display search field", 'lifecoach') ),
					"class" => "",
					"value" => array(
						esc_html__('Regular', 'lifecoach') => "regular",
						esc_html__('Flat', 'lifecoach') => "flat"
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "state",
					"heading" => esc_html__("State", 'lifecoach'),
					"description" => wp_kses_data( __("Select search field initial state", 'lifecoach') ),
					"class" => "",
					"value" => array(
						esc_html__('Fixed', 'lifecoach')  => "fixed",
						esc_html__('Opened', 'lifecoach') => "opened",
						esc_html__('Closed', 'lifecoach') => "closed"
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "title",
					"heading" => esc_html__("Title", 'lifecoach'),
					"description" => wp_kses_data( __("Title (placeholder) for the search field", 'lifecoach') ),
					"admin_label" => true,
					"class" => "",
					"value" => esc_html__("Search &hellip;", 'lifecoach'),
					"type" => "textfield"
				),
				array(
					"param_name" => "ajax",
					"heading" => esc_html__("AJAX", 'lifecoach'),
					"description" => wp_kses_data( __("Search via AJAX or reload page", 'lifecoach') ),
					"class" => "",
					"value" => array(esc_html__('Use AJAX search', 'lifecoach') => 'yes'),
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
			)
		) );
		
		class WPBakeryShortCode_Trx_Search extends LIFECOACH_VC_ShortCodeSingle {}
	}
}
?>