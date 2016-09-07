<?php
/**
 * LifeCoach Framework: Theme options custom fields
 *
 * @package	lifecoach
 * @since	lifecoach 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'lifecoach_options_custom_theme_setup' ) ) {
	add_action( 'lifecoach_action_before_init_theme', 'lifecoach_options_custom_theme_setup' );
	function lifecoach_options_custom_theme_setup() {

		if ( is_admin() ) {
			add_action("admin_enqueue_scripts",	'lifecoach_options_custom_load_scripts');
		}
		
	}
}

// Load required styles and scripts for custom options fields
if ( !function_exists( 'lifecoach_options_custom_load_scripts' ) ) {
	//add_action("admin_enqueue_scripts", 'lifecoach_options_custom_load_scripts');
	function lifecoach_options_custom_load_scripts() {
		lifecoach_enqueue_script( 'lifecoach-options-custom-script',	lifecoach_get_file_url('core/core.options/js/core.options-custom.js'), array(), null, true );	
	}
}


// Show theme specific fields in Post (and Page) options
if ( !function_exists( 'lifecoach_show_custom_field' ) ) {
	function lifecoach_show_custom_field($id, $field, $value) {
		$output = '';
		switch ($field['type']) {
			case 'reviews':
				$output .= '<div class="reviews_block">' . trim(lifecoach_reviews_get_markup($field, $value, true)) . '</div>';
				break;
	
			case 'mediamanager':
				wp_enqueue_media( );
				$output .= '<a id="'.esc_attr($id).'" class="button mediamanager lifecoach_media_selector"
					data-param="' . esc_attr($id) . '"
					data-choose="'.esc_attr(isset($field['multiple']) && $field['multiple'] ? esc_html__( 'Choose Images', 'lifecoach') : esc_html__( 'Choose Image', 'lifecoach')).'"
					data-update="'.esc_attr(isset($field['multiple']) && $field['multiple'] ? esc_html__( 'Add to Gallery', 'lifecoach') : esc_html__( 'Choose Image', 'lifecoach')).'"
					data-multiple="'.esc_attr(isset($field['multiple']) && $field['multiple'] ? 'true' : 'false').'"
					data-linked-field="'.esc_attr($field['media_field_id']).'"
					>' . (isset($field['multiple']) && $field['multiple'] ? esc_html__( 'Choose Images', 'lifecoach') : esc_html__( 'Choose Image', 'lifecoach')) . '</a>';
				break;
		}
		return apply_filters('lifecoach_filter_show_custom_field', $output, $id, $field, $value);
	}
}
?>