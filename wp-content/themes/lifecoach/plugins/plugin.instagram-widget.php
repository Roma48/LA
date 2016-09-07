<?php
/* Instagram Widget support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('lifecoach_instagram_widget_theme_setup')) {
	add_action( 'lifecoach_action_before_init_theme', 'lifecoach_instagram_widget_theme_setup', 1 );
	function lifecoach_instagram_widget_theme_setup() {
		if (lifecoach_exists_instagram_widget()) {
			add_action( 'lifecoach_action_add_styles', 						'lifecoach_instagram_widget_frontend_scripts' );
		}
		if (is_admin()) {
			add_filter( 'lifecoach_filter_importer_required_plugins',		'lifecoach_instagram_widget_importer_required_plugins', 10, 2 );
			add_filter( 'lifecoach_filter_required_plugins',					'lifecoach_instagram_widget_required_plugins' );
		}
	}
}

// Check if Instagram Widget installed and activated
if ( !function_exists( 'lifecoach_exists_instagram_widget' ) ) {
	function lifecoach_exists_instagram_widget() {
		return function_exists('wpiw_init');
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'lifecoach_instagram_widget_required_plugins' ) ) {
	//add_filter('lifecoach_filter_required_plugins',	'lifecoach_instagram_widget_required_plugins');
	function lifecoach_instagram_widget_required_plugins($list=array()) {
		if (in_array('instagram_widget', lifecoach_storage_get('required_plugins')))
			$list[] = array(
					'name' 		=> 'Instagram Widget',
					'slug' 		=> 'wp-instagram-widget',
					'required' 	=> false
				);
		return $list;
	}
}

// Enqueue custom styles
if ( !function_exists( 'lifecoach_instagram_widget_frontend_scripts' ) ) {
	//add_action( 'lifecoach_action_add_styles', 'lifecoach_instagram_widget_frontend_scripts' );
	function lifecoach_instagram_widget_frontend_scripts() {
		if (file_exists(lifecoach_get_file_dir('css/plugin.instagram-widget.css')))
			lifecoach_enqueue_style( 'lifecoach-plugin.instagram-widget-style',  lifecoach_get_file_url('css/plugin.instagram-widget.css'), array(), null );
	}
}



// One-click import support
//------------------------------------------------------------------------

// Check Instagram Widget in the required plugins
if ( !function_exists( 'lifecoach_instagram_widget_importer_required_plugins' ) ) {
	//add_filter( 'lifecoach_filter_importer_required_plugins',	'lifecoach_instagram_widget_importer_required_plugins', 10, 2 );
	function lifecoach_instagram_widget_importer_required_plugins($not_installed='', $list='') {
		//if (in_array('instagram_widget', lifecoach_storage_get('required_plugins')) && !lifecoach_exists_instagram_widget() )
		if (lifecoach_strpos($list, 'instagram_widget')!==false && !lifecoach_exists_instagram_widget() )
			$not_installed .= '<br>WP Instagram Widget';
		return $not_installed;
	}
}
?>