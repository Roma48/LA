<?php
if (!function_exists('lifecoach_theme_shortcodes_setup')) {
	add_action( 'lifecoach_action_before_init_theme', 'lifecoach_theme_shortcodes_setup', 1 );
	function lifecoach_theme_shortcodes_setup() {
		add_filter('lifecoach_filter_googlemap_styles', 'lifecoach_theme_shortcodes_googlemap_styles');
	}
}


// Add theme-specific Google map styles
if ( !function_exists( 'lifecoach_theme_shortcodes_googlemap_styles' ) ) {
	function lifecoach_theme_shortcodes_googlemap_styles($list) {
		$list['simple']		= esc_html__('Simple', 'lifecoach');
		$list['greyscale']	= esc_html__('Greyscale', 'lifecoach');
		$list['inverse']	= esc_html__('Inverse', 'lifecoach');
		return $list;
	}
}
?>