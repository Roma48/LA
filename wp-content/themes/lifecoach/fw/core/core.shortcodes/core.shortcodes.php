<?php
/**
 * LifeCoach Framework: shortcodes manipulations
 *
 * @package	lifecoach
 * @since	lifecoach 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Theme init
if (!function_exists('lifecoach_sc_theme_setup')) {
	add_action( 'lifecoach_action_init_theme', 'lifecoach_sc_theme_setup', 1 );
	function lifecoach_sc_theme_setup() {
		// Add sc stylesheets
		add_action('lifecoach_action_add_styles', 'lifecoach_sc_add_styles', 1);
	}
}

if (!function_exists('lifecoach_sc_theme_setup2')) {
	add_action( 'lifecoach_action_before_init_theme', 'lifecoach_sc_theme_setup2' );
	function lifecoach_sc_theme_setup2() {

		if ( !is_admin() || isset($_POST['action']) ) {
			// Enable/disable shortcodes in excerpt
			add_filter('the_excerpt', 					'lifecoach_sc_excerpt_shortcodes');
	
			// Prepare shortcodes in the content
			if (function_exists('lifecoach_sc_prepare_content')) lifecoach_sc_prepare_content();
		}

		// Add init script into shortcodes output in VC frontend editor
		add_filter('lifecoach_shortcode_output', 'lifecoach_sc_add_scripts', 10, 4);

		// AJAX: Send contact form data
		add_action('wp_ajax_send_form',			'lifecoach_sc_form_send');
		add_action('wp_ajax_nopriv_send_form',	'lifecoach_sc_form_send');

		// Show shortcodes list in admin editor
		add_action('media_buttons',				'lifecoach_sc_selector_add_in_toolbar', 11);

	}
}


// Register shortcodes styles
if ( !function_exists( 'lifecoach_sc_add_styles' ) ) {
	//add_action('lifecoach_action_add_styles', 'lifecoach_sc_add_styles', 1);
	function lifecoach_sc_add_styles() {
		// Shortcodes
		lifecoach_enqueue_style( 'lifecoach-shortcodes-style',	lifecoach_get_file_url('shortcodes/theme.shortcodes.css'), array(), null );
	}
}


// Register shortcodes init scripts
if ( !function_exists( 'lifecoach_sc_add_scripts' ) ) {
	//add_filter('lifecoach_shortcode_output', 'lifecoach_sc_add_scripts', 10, 4);
	function lifecoach_sc_add_scripts($output, $tag='', $atts=array(), $content='') {

		if (lifecoach_storage_empty('shortcodes_scripts_added')) {
			lifecoach_storage_set('shortcodes_scripts_added', true);
			//lifecoach_enqueue_style( 'lifecoach-shortcodes-style', lifecoach_get_file_url('shortcodes/theme.shortcodes.css'), array(), null );
			lifecoach_enqueue_script( 'lifecoach-shortcodes-script', lifecoach_get_file_url('shortcodes/theme.shortcodes.js'), array('jquery'), null, true );	
		}
		
		return $output;
	}
}


/* Prepare text for shortcodes
-------------------------------------------------------------------------------- */

// Prepare shortcodes in content
if (!function_exists('lifecoach_sc_prepare_content')) {
	function lifecoach_sc_prepare_content() {
		if (function_exists('lifecoach_sc_clear_around')) {
			$filters = array(
				array('lifecoach', 'sc', 'clear', 'around'),
				array('widget', 'text'),
				array('the', 'excerpt'),
				array('the', 'content')
			);
			if (function_exists('lifecoach_exists_woocommerce') && lifecoach_exists_woocommerce()) {
				$filters[] = array('woocommerce', 'template', 'single', 'excerpt');
				$filters[] = array('woocommerce', 'short', 'description');
			}
			if (is_array($filters) && count($filters) > 0) {
				foreach ($filters as $flt)
					add_filter(join('_', $flt), 'lifecoach_sc_clear_around', 1);	// Priority 1 to clear spaces before do_shortcodes()
			}
		}
	}
}

// Enable/Disable shortcodes in the excerpt
if (!function_exists('lifecoach_sc_excerpt_shortcodes')) {
	function lifecoach_sc_excerpt_shortcodes($content) {
		if (!empty($content)) {
			$content = do_shortcode($content);
			//$content = strip_shortcodes($content);
		}
		return $content;
	}
}



/*
// Remove spaces and line breaks between close and open shortcode brackets ][:
[trx_columns]
	[trx_column_item]Column text ...[/trx_column_item]
	[trx_column_item]Column text ...[/trx_column_item]
	[trx_column_item]Column text ...[/trx_column_item]
[/trx_columns]

convert to

[trx_columns][trx_column_item]Column text ...[/trx_column_item][trx_column_item]Column text ...[/trx_column_item][trx_column_item]Column text ...[/trx_column_item][/trx_columns]
*/
if (!function_exists('lifecoach_sc_clear_around')) {
	function lifecoach_sc_clear_around($content) {
		if (!empty($content)) $content = preg_replace("/\](\s|\n|\r)*\[/", "][", $content);
		return $content;
	}
}






/* Shortcodes support utils
---------------------------------------------------------------------- */

// LifeCoach shortcodes load scripts
if (!function_exists('lifecoach_sc_load_scripts')) {
	function lifecoach_sc_load_scripts() {
		lifecoach_enqueue_script( 'lifecoach-shortcodes_admin-script', lifecoach_get_file_url('core/core.shortcodes/shortcodes_admin.js'), array('jquery'), null, true );
		lifecoach_enqueue_script( 'lifecoach-selection-script',  lifecoach_get_file_url('js/jquery.selection.js'), array('jquery'), null, true );
		wp_localize_script( 'lifecoach-shortcodes_admin-script', 'LIFECOACH_SHORTCODES_DATA', lifecoach_storage_get('shortcodes') );
	}
}

// LifeCoach shortcodes prepare scripts
if (!function_exists('lifecoach_sc_prepare_scripts')) {
	function lifecoach_sc_prepare_scripts() {
		if (!lifecoach_storage_isset('shortcodes_prepared')) {
			lifecoach_storage_set('shortcodes_prepared', true);
			?>
			<script type="text/javascript">
				jQuery(document).ready(function(){
					LIFECOACH_STORAGE['shortcodes_cp'] = '<?php echo is_admin() ? (!lifecoach_storage_empty('to_colorpicker') ? lifecoach_storage_get('to_colorpicker') : 'wp') : 'custom'; ?>';	// wp | tiny | custom
				});
			</script>
			<?php
		}
	}
}

// Show shortcodes list in admin editor
if (!function_exists('lifecoach_sc_selector_add_in_toolbar')) {
	//add_action('media_buttons','lifecoach_sc_selector_add_in_toolbar', 11);
	function lifecoach_sc_selector_add_in_toolbar(){

		if ( !lifecoach_options_is_used() ) return;

		lifecoach_sc_load_scripts();
		lifecoach_sc_prepare_scripts();

		$shortcodes = lifecoach_storage_get('shortcodes');
		$shortcodes_list = '<select class="sc_selector"><option value="">&nbsp;'.esc_html__('- Select Shortcode -', 'lifecoach').'&nbsp;</option>';

		if (is_array($shortcodes) && count($shortcodes) > 0) {
			foreach ($shortcodes as $idx => $sc) {
				$shortcodes_list .= '<option value="'.esc_attr($idx).'" title="'.esc_attr($sc['desc']).'">'.esc_html($sc['title']).'</option>';
			}
		}

		$shortcodes_list .= '</select>';

		echo trim($shortcodes_list);
	}
}

// LifeCoach shortcodes builder settings
require_once trailingslashit( get_template_directory() ) . LIFECOACH_FW_DIR . '/core/core.shortcodes/shortcodes_settings.php';

// VC shortcodes settings
if ( class_exists('WPBakeryShortCode') ) {
    require_once trailingslashit( get_template_directory() ) . LIFECOACH_FW_DIR . '/core/core.shortcodes/shortcodes_vc.php';
}

// LifeCoach shortcodes implementation
lifecoach_autoload_folder( 'shortcodes/trx_basic' );
lifecoach_autoload_folder( 'shortcodes/trx_optional' );
?>