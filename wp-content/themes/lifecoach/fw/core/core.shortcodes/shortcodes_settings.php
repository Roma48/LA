<?php

// Check if shortcodes settings are now used
if ( !function_exists( 'lifecoach_shortcodes_is_used' ) ) {
	function lifecoach_shortcodes_is_used() {
		return lifecoach_options_is_used() 															// All modes when Theme Options are used
			|| (is_admin() && isset($_POST['action']) 
					&& in_array($_POST['action'], array('vc_edit_form', 'wpb_show_edit_form')))		// AJAX query when save post/page
			|| (is_admin() && lifecoach_strpos($_SERVER['REQUEST_URI'], 'vc-roles')!==false)			// VC Role Manager
			|| (function_exists('lifecoach_vc_is_frontend') && lifecoach_vc_is_frontend());			// VC Frontend editor mode
	}
}

// Width and height params
if ( !function_exists( 'lifecoach_shortcodes_width' ) ) {
	function lifecoach_shortcodes_width($w="") {
		return array(
			"title" => esc_html__("Width", 'lifecoach'),
			"divider" => true,
			"value" => $w,
			"type" => "text"
		);
	}
}
if ( !function_exists( 'lifecoach_shortcodes_height' ) ) {
	function lifecoach_shortcodes_height($h='') {
		return array(
			"title" => esc_html__("Height", 'lifecoach'),
			"desc" => wp_kses_data( __("Width and height of the element", 'lifecoach') ),
			"value" => $h,
			"type" => "text"
		);
	}
}

// Return sc_param value
if ( !function_exists( 'lifecoach_get_sc_param' ) ) {
	function lifecoach_get_sc_param($prm) {
		return lifecoach_storage_get_array('sc_params', $prm);
	}
}

// Set sc_param value
if ( !function_exists( 'lifecoach_set_sc_param' ) ) {
	function lifecoach_set_sc_param($prm, $val) {
		lifecoach_storage_set_array('sc_params', $prm, $val);
	}
}

// Add sc settings in the sc list
if ( !function_exists( 'lifecoach_sc_map' ) ) {
	function lifecoach_sc_map($sc_name, $sc_settings) {
		lifecoach_storage_set_array('shortcodes', $sc_name, $sc_settings);
	}
}

// Add sc settings in the sc list after the key
if ( !function_exists( 'lifecoach_sc_map_after' ) ) {
	function lifecoach_sc_map_after($after, $sc_name, $sc_settings='') {
		lifecoach_storage_set_array_after('shortcodes', $after, $sc_name, $sc_settings);
	}
}

// Add sc settings in the sc list before the key
if ( !function_exists( 'lifecoach_sc_map_before' ) ) {
	function lifecoach_sc_map_before($before, $sc_name, $sc_settings='') {
		lifecoach_storage_set_array_before('shortcodes', $before, $sc_name, $sc_settings);
	}
}

// Compare two shortcodes by title
if ( !function_exists( 'lifecoach_compare_sc_title' ) ) {
	function lifecoach_compare_sc_title($a, $b) {
		return strcmp($a['title'], $b['title']);
	}
}



/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'lifecoach_shortcodes_settings_theme_setup' ) ) {
//	if ( lifecoach_vc_is_frontend() )
	if ( (isset($_GET['vc_editable']) && $_GET['vc_editable']=='true') || (isset($_GET['vc_action']) && $_GET['vc_action']=='vc_inline') )
		add_action( 'lifecoach_action_before_init_theme', 'lifecoach_shortcodes_settings_theme_setup', 20 );
	else
		add_action( 'lifecoach_action_after_init_theme', 'lifecoach_shortcodes_settings_theme_setup' );
	function lifecoach_shortcodes_settings_theme_setup() {
		if (lifecoach_shortcodes_is_used()) {

			// Sort templates alphabetically
			$tmp = lifecoach_storage_get('registered_templates');
			ksort($tmp);
			lifecoach_storage_set('registered_templates', $tmp);

			// Prepare arrays 
			lifecoach_storage_set('sc_params', array(
			
				// Current element id
				'id' => array(
					"title" => esc_html__("Element ID", 'lifecoach'),
					"desc" => wp_kses_data( __("ID for current element", 'lifecoach') ),
					"divider" => true,
					"value" => "",
					"type" => "text"
				),
			
				// Current element class
				'class' => array(
					"title" => esc_html__("Element CSS class", 'lifecoach'),
					"desc" => wp_kses_data( __("CSS class for current element (optional)", 'lifecoach') ),
					"value" => "",
					"type" => "text"
				),
			
				// Current element style
				'css' => array(
					"title" => esc_html__("CSS styles", 'lifecoach'),
					"desc" => wp_kses_data( __("Any additional CSS rules (if need)", 'lifecoach') ),
					"value" => "",
					"type" => "text"
				),
			
			
				// Switcher choises
				'list_styles' => array(
					'ul'	=> esc_html__('Unordered', 'lifecoach'),
					'ol'	=> esc_html__('Ordered', 'lifecoach'),
					'iconed'=> esc_html__('Iconed', 'lifecoach')
				),

				'yes_no'	=> lifecoach_get_list_yesno(),
				'on_off'	=> lifecoach_get_list_onoff(),
				'dir' 		=> lifecoach_get_list_directions(),
				'align'		=> lifecoach_get_list_alignments(),
				'float'		=> lifecoach_get_list_floats(),
				'hpos'		=> lifecoach_get_list_hpos(),
				'show_hide'	=> lifecoach_get_list_showhide(),
				'sorting' 	=> lifecoach_get_list_sortings(),
				'ordering' 	=> lifecoach_get_list_orderings(),
				'shapes'	=> lifecoach_get_list_shapes(),
				'sizes'		=> lifecoach_get_list_sizes(),
				'sliders'	=> lifecoach_get_list_sliders(),
				'controls'	=> lifecoach_get_list_controls(),
				'categories'=> lifecoach_get_list_categories(),
				'columns'	=> lifecoach_get_list_columns(),
				'images'	=> array_merge(array('none'=>"none"), lifecoach_get_list_files("images/icons", "png")),
				'icons'		=> array_merge(array("inherit", "none"), lifecoach_get_list_icons()),
				'locations'	=> lifecoach_get_list_dedicated_locations(),
				'filters'	=> lifecoach_get_list_portfolio_filters(),
				'formats'	=> lifecoach_get_list_post_formats_filters(),
				'hovers'	=> lifecoach_get_list_hovers(true),
				'hovers_dir'=> lifecoach_get_list_hovers_directions(true),
				'schemes'	=> lifecoach_get_list_color_schemes(true),
				'animations'		=> lifecoach_get_list_animations_in(),
				'margins' 			=> lifecoach_get_list_margins(true),
				'blogger_styles'	=> lifecoach_get_list_templates_blogger(),
				'forms'				=> lifecoach_get_list_templates_forms(),
				'posts_types'		=> lifecoach_get_list_posts_types(),
				'googlemap_styles'	=> lifecoach_get_list_googlemap_styles(),
				'field_types'		=> lifecoach_get_list_field_types(),
				'label_positions'	=> lifecoach_get_list_label_positions()
				)
			);

			// Common params
			lifecoach_set_sc_param('animation', array(
				"title" => esc_html__("Animation",  'lifecoach'),
				"desc" => wp_kses_data( __('Select animation while object enter in the visible area of page',  'lifecoach') ),
				"value" => "none",
				"type" => "select",
				"options" => lifecoach_get_sc_param('animations')
				)
			);
			lifecoach_set_sc_param('top', array(
				"title" => esc_html__("Top margin",  'lifecoach'),
				"divider" => true,
				"value" => "inherit",
				"type" => "select",
				"options" => lifecoach_get_sc_param('margins')
				)
			);
			lifecoach_set_sc_param('bottom', array(
				"title" => esc_html__("Bottom margin",  'lifecoach'),
				"value" => "inherit",
				"type" => "select",
				"options" => lifecoach_get_sc_param('margins')
				)
			);
			lifecoach_set_sc_param('left', array(
				"title" => esc_html__("Left margin",  'lifecoach'),
				"value" => "inherit",
				"type" => "select",
				"options" => lifecoach_get_sc_param('margins')
				)
			);
			lifecoach_set_sc_param('right', array(
				"title" => esc_html__("Right margin",  'lifecoach'),
				"desc" => wp_kses_data( __("Margins around this shortcode", 'lifecoach') ),
				"value" => "inherit",
				"type" => "select",
				"options" => lifecoach_get_sc_param('margins')
				)
			);

			lifecoach_storage_set('sc_params', apply_filters('lifecoach_filter_shortcodes_params', lifecoach_storage_get('sc_params')));

			// Shortcodes list
			//------------------------------------------------------------------
			lifecoach_storage_set('shortcodes', array());
			
			// Register shortcodes
			do_action('lifecoach_action_shortcodes_list');

			// Sort shortcodes list
			$tmp = lifecoach_storage_get('shortcodes');
			uasort($tmp, 'lifecoach_compare_sc_title');
			lifecoach_storage_set('shortcodes', $tmp);
		}
	}
}
?>