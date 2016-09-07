<?php
/**
 * LifeCoach Framework
 *
 * @package lifecoach
 * @since lifecoach 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Framework directory path from theme root
if ( ! defined( 'LIFECOACH_FW_DIR' ) )			define( 'LIFECOACH_FW_DIR', 'fw' );

// Theme timing
if ( ! defined( 'LIFECOACH_START_TIME' ) )		define( 'LIFECOACH_START_TIME', microtime(true));		// Framework start time
if ( ! defined( 'LIFECOACH_START_MEMORY' ) )		define( 'LIFECOACH_START_MEMORY', memory_get_usage());	// Memory usage before core loading
if ( ! defined( 'LIFECOACH_START_QUERIES' ) )	define( 'LIFECOACH_START_QUERIES', get_num_queries());	// DB queries used

// Include theme variables storage
require_once trailingslashit( get_template_directory() ) . LIFECOACH_FW_DIR . '/core/core.storage.php';

// Theme variables storage
//$theme_slug = str_replace(' ', '_', trim(strtolower(get_stylesheet())));
//lifecoach_storage_set('options_prefix', 'lifecoach'.'_'.trim($theme_slug));	// Used as prefix to store theme's options in the post meta and wp options
lifecoach_storage_set('options_prefix', 'lifecoach');	// Used as prefix to store theme's options in the post meta and wp options
lifecoach_storage_set('page_template', '');			// Storage for current page template name (used in the inheritance system)
lifecoach_storage_set('widgets_args', array(			// Arguments to register widgets
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget_title">',
		'after_title'   => '</h4>',
	)
);

/* Theme setup section
-------------------------------------------------------------------- */
if ( !function_exists( 'lifecoach_loader_theme_setup' ) ) {
	add_action( 'after_setup_theme', 'lifecoach_loader_theme_setup', 20 );
	function lifecoach_loader_theme_setup() {

		lifecoach_profiler_add_point(esc_html__('After load theme required files', 'lifecoach'));

		// Before init theme
		do_action('lifecoach_action_before_init_theme');

		// Load current values for main theme options
		lifecoach_load_main_options();

		// Theme core init - only for admin side. In frontend it called from header.php
		if ( is_admin() ) {
			lifecoach_core_init_theme();
		}
	}
}


/* Include core parts
------------------------------------------------------------------------ */
// Manual load important libraries before load all rest files
// core.strings must be first - we use lifecoach_str...() in the lifecoach_get_file_dir()
require_once trailingslashit( get_template_directory() ) . LIFECOACH_FW_DIR . '/core/core.strings.php';
// core.files must be first - we use lifecoach_get_file_dir() to include all rest parts
require_once trailingslashit( get_template_directory() ) . LIFECOACH_FW_DIR . '/core/core.files.php';

// Include debug and profiler
require_once trailingslashit( get_template_directory() ) . LIFECOACH_FW_DIR . '/core/core.debug.php';

// Include custom theme files
lifecoach_autoload_folder( 'includes' );

// Include core files
lifecoach_autoload_folder( 'core' );

// Include theme-specific plugins and post types
lifecoach_autoload_folder( 'plugins' );

// Include theme templates
lifecoach_autoload_folder( 'templates' );

// Include theme widgets
lifecoach_autoload_folder( 'widgets' );
?>