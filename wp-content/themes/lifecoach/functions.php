<?php
/**
 * Theme sprecific functions and definitions
 */

/* Theme setup section
------------------------------------------------------------------- */

// Set the content width based on the theme's design and stylesheet.
if ( ! isset( $content_width ) ) $content_width = 1170; /* pixels */

// Add theme specific actions and filters
// Attention! Function were add theme specific actions and filters handlers must have priority 1
if ( !function_exists( 'lifecoach_theme_setup' ) ) {
	add_action( 'lifecoach_action_before_init_theme', 'lifecoach_theme_setup', 1 );
	function lifecoach_theme_setup() {

		// Register theme menus
		add_filter( 'lifecoach_filter_add_theme_menus',		'lifecoach_add_theme_menus' );

		// Register theme sidebars
		add_filter( 'lifecoach_filter_add_theme_sidebars',	'lifecoach_add_theme_sidebars' );

		// Set options for importer
		add_filter( 'lifecoach_filter_importer_options',		'lifecoach_set_importer_options' );

		// Add theme required plugins
		add_filter( 'lifecoach_filter_required_plugins',		'lifecoach_add_required_plugins' );

		// Add theme specified classes into the body

		add_filter( 'body_class', 'lifecoach_body_classes' );

        add_action('wp_head',								'lifecoach_head_add_page_meta', 1);

        add_filter('language_attributes', 'lifecoach_html_classes');

		// Set list of the theme required plugins
		lifecoach_storage_set('required_plugins', array(
			'booked',
			'essgrids',
			'instagram_widget',
			'revslider',
			'tribe_events',
			'trx_utils',
			'visual_composer',
			'vc_extensions_cqbundle',
			'woocommerce',
			)
		);
		
	}
}


// Add/Remove theme nav menus
if ( !function_exists( 'lifecoach_add_theme_menus' ) ) {
	//add_filter( 'lifecoach_filter_add_theme_menus', 'lifecoach_add_theme_menus' );
	function lifecoach_add_theme_menus($menus) {
		//For example:
		//$menus['menu_footer'] = esc_html__('Footer Menu', 'lifecoach');
		//if (isset($menus['menu_panel'])) unset($menus['menu_panel']);
		return $menus;
	}
}


// Add theme specific widgetized areas
if ( !function_exists( 'lifecoach_add_theme_sidebars' ) ) {
	//add_filter( 'lifecoach_filter_add_theme_sidebars',	'lifecoach_add_theme_sidebars' );
	function lifecoach_add_theme_sidebars($sidebars=array()) {
		if (is_array($sidebars)) {
			$theme_sidebars = array(
				'sidebar_main'		=> esc_html__( 'Main Sidebar', 'lifecoach' ),
				'sidebar_footer'	=> esc_html__( 'Footer Sidebar', 'lifecoach' )
			);
			if (function_exists('lifecoach_exists_woocommerce') && lifecoach_exists_woocommerce()) {
				$theme_sidebars['sidebar_cart']  = esc_html__( 'WooCommerce Cart Sidebar', 'lifecoach' );
			}
			$sidebars = array_merge($theme_sidebars, $sidebars);
		}
		return $sidebars;
	}
}

// Add page meta to the head
if (!function_exists('lifecoach_head_add_page_meta')) {
    //add_action('wp_head', 'themerex_head_add_page_meta', 1);
    function lifecoach_head_add_page_meta() {
        ?>
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1<?php if (lifecoach_get_theme_option('responsive_layouts')=='yes') echo ', maximum-scale=1'; ?>">
        <meta name="format-detection" content="telephone=no">

        <link rel="profile" href="http://gmpg.org/xfn/11" />
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
    <?php
    }
}


// Add theme required plugins
if ( !function_exists( 'lifecoach_add_required_plugins' ) ) {
	//add_filter( 'lifecoach_filter_required_plugins',		'lifecoach_add_required_plugins' );
	function lifecoach_add_required_plugins($plugins) {
		$plugins[] = array(
			'name' 		=> 'LifeCoach Utilities',
			'version'	=> '2.7',					// Minimal required version
			'slug' 		=> 'trx_utils',
			'source'	=> lifecoach_get_file_dir('plugins/install/trx_utils.zip'),
			'required' 	=> true
		);
		return $plugins;
	}
}


// Add theme specified classes into the body
if ( !function_exists('lifecoach_body_classes') ) {
	//add_filter( 'body_class', 'lifecoach_body_classes' );
	function lifecoach_body_classes( $classes ) {

		$classes[] = 'lifecoach_body';
		$classes[] = 'body_style_' . trim(lifecoach_get_custom_option('body_style'));
		$classes[] = 'body_' . (lifecoach_get_custom_option('body_filled')=='yes' ? 'filled' : 'transparent');
		$classes[] = 'theme_skin_' . trim(lifecoach_get_custom_option('theme_skin'));
		$classes[] = 'article_style_' . trim(lifecoach_get_custom_option('article_style'));
		
		$blog_style = lifecoach_get_custom_option(is_singular() && !lifecoach_storage_get('blog_streampage') ? 'single_style' : 'blog_style');
		$classes[] = 'layout_' . trim($blog_style);
		$classes[] = 'template_' . trim(lifecoach_get_template_name($blog_style));
		
		$body_scheme = lifecoach_get_custom_option('body_scheme');
		if (empty($body_scheme)  || lifecoach_is_inherit_option($body_scheme)) $body_scheme = 'original';
		$classes[] = 'scheme_' . $body_scheme;

		$top_panel_position = lifecoach_get_custom_option('top_panel_position');
		if (!lifecoach_param_is_off($top_panel_position)) {
			$classes[] = 'top_panel_show';
			$classes[] = 'top_panel_' . trim($top_panel_position);
		} else 
			$classes[] = 'top_panel_hide';
		$classes[] = lifecoach_get_sidebar_class();

		if (lifecoach_get_custom_option('show_video_bg')=='yes' && (lifecoach_get_custom_option('video_bg_youtube_code')!='' || lifecoach_get_custom_option('video_bg_url')!=''))
			$classes[] = 'video_bg_show';

		return $classes;
	}
}

// Add theme specified classes into the html tag
if ( !function_exists('lifecoach_html_classes') ) {
    function lifecoach_html_classes( $output ) {
        $class ='';
        if (lifecoach_get_custom_option('body_scheme')  || lifecoach_is_inherit_option(lifecoach_get_custom_option('body_scheme'))) {
            $class = 'scheme_original';
        } else {
            $class = 'scheme_' . esc_attr(lifecoach_get_custom_option('body_scheme'));
        }
        return $output . ' class="' . $class . '"';
    }
}

// Set theme specific importer options
if ( !function_exists( 'lifecoach_set_importer_options' ) ) {
	//add_filter( 'lifecoach_filter_importer_options',	'lifecoach_set_importer_options' );
	function lifecoach_set_importer_options($options=array()) {
		if (is_array($options)) {
			$options['debug'] = lifecoach_get_theme_option('debug_mode')=='yes';
			$options['menus'] = array(
				'menu-main'	  => esc_html__('Main menu', 'lifecoach'),
				'menu-user'	  => esc_html__('User menu', 'lifecoach'),
				'menu-footer' => esc_html__('Footer menu', 'lifecoach'),
			);

			// Prepare demo data
			$demo_data_url = esc_url('http://lifecoach.ancorathemes.com/demo/');
			
			// Main demo
			$options['files']['default'] = array(
				'title'				=> esc_html__('Basekit demo', 'lifecoach'),
				'file_with_posts'	=> esc_url($demo_data_url . 'default/posts.txt'),
				'file_with_users'	=> esc_url($demo_data_url . 'default/users.txt'),
				'file_with_mods'	=> esc_url($demo_data_url . 'default/theme_mods.txt'),
				'file_with_options'	=> esc_url($demo_data_url . 'default/theme_options.txt'),
				'file_with_templates'=>esc_url($demo_data_url . 'default/templates_options.txt'),
				'file_with_widgets'	=> esc_url($demo_data_url . 'default/widgets.txt'),
				'file_with_revsliders' => array(
                    esc_url($demo_data_url . 'default/revsliders/home_1.zip')
				),
				'file_with_attachments' => array(),
				'attachments_by_parts'	=> true,
				'domain_dev'	=> esc_url('lifecoach.dv.ancorathemes.com'),	// Developers domain ( without protocol, used only for str_replace(), not need esc_url() )
				'domain_demo'	=> esc_url('lifecoach.ancorathemes.com')	// Demo-site domain ( without protocol, used only for str_replace(), not need esc_url() )
			);
            for ($i=1; $i<=17; $i++) {
                $options['files']['default']['file_with_attachments'][] = esc_url($demo_data_url . 'default/uploads/uploads.' . sprintf('%03u', $i));
            }
		}
		return $options;
	}
}


/* Include framework core files
------------------------------------------------------------------- */
// If now is WP Heartbeat call - skip loading theme core files (to reduce server and DB uploads)
// Remove comments below only if your theme not work with own post types and/or taxonomies
//if (!isset($_POST['action']) || $_POST['action']!="heartbeat") {
    require_once trailingslashit( get_template_directory() ) . 'fw/loader.php';
//}
remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);

remove_action( 'woocommerce_before_subcategory', 'woocommerce_template_loop_category_link_open' );
remove_action( 'woocommerce_after_subcategory', 'woocommerce_template_loop_category_link_close' );
?>