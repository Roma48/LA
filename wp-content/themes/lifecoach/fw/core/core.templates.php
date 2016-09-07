<?php
/**
 * LifeCoach Framework: templates and thumbs management
 *
 * @package	lifecoach
 * @since	lifecoach 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Theme init
if (!function_exists('lifecoach_templates_theme_setup')) {
	add_action( 'lifecoach_action_before_init_theme', 'lifecoach_templates_theme_setup' );
	function lifecoach_templates_theme_setup() {

		// Add custom thumb sizes into media manager
		add_filter( 'image_size_names_choose', 'lifecoach_show_thumb_sizes');
	}
}



/* Templates
-------------------------------------------------------------------------------- */

// Add template (layout name)
// $tpl = array( 
//		'layout' => 'layout_name',
//		'template' => 'template_file_name',		// If empty - use 'layout' name
//		'body_style' => 'required_body_style',	// If not empty - use instead current body_style
//		'need_content' => true|false,			// true - for single posts or if template need prepared full content of the posts, else - false
//		'need_terms' => true|false,				// true - for single posts or if template need prepared terms list (categories, tags, product_cat, etc.), else - false
//		'need_columns' => true|false,			// true - if template need columns wrapper for horizontal direction, else - false
//		'need_isotope' => true|false,			// true - if template need isotope wrapper, else - false
//		'container' => '',						// Additional elements container (if need) for single post and blog streampage. For example: <div class="addit_wrap">%s</div>
//		'container_classes' => '',				// or additional classes for existing elements container
//		'mode'   => 'blog|single|widgets|blogger|internal',
//		'title'  => 'Layout title',
//		'thumb_title' => 'Thumb title',			// If empty - don't show in the thumbs list (and not add image size)
//		'thumb_slug' => 'Thumb slug',			// Optional. If empty - use Thumb title as slug
//		'w'      => width,
//		'h'      => height (null if no crop, but only scale),
//		'h_crop' => cropped height (optional),
//		);
// $tpl = array('layout' => 'excerpt', 'mode' => 'blog', 'title'=>'Excerpt', 'thumb_title'=>'Medium image size', 'w' => 720, 'h' => 460, 'h_crop' => 460);
// $tpl = array('layout' => 'fullpost', 'mode' => 'blog,single', 'title'=>'Fullwidth post', 'thumb_title'=>'Large image', 'w' => 1150, 'h' => null, 'h_crop' => 720);
// $tpl = array('layout' => 'accordion', 'mode' => 'blogger', 'title'=>'Accordion');
if (!function_exists('lifecoach_add_template')) {
	function lifecoach_add_template($tpl) {
		if (empty($tpl['mode']))						$tpl['mode'] = 'blog';
		if (empty($tpl['template']))					$tpl['template'] = $tpl['layout'];
		if (empty($tpl['need_content']))				$tpl['need_content'] = false;
		if (empty($tpl['need_terms']))					$tpl['need_terms'] = false;
		if (empty($tpl['need_columns']))				$tpl['need_columns'] = false;
		if (empty($tpl['need_isotope']))				$tpl['need_isotope'] = false;
		if (!isset($tpl['h_crop']) && isset($tpl['h']))	$tpl['h_crop'] = $tpl['h'];
		lifecoach_storage_set_array('registered_templates', $tpl['layout'], $tpl);
		if (!empty($tpl['thumb_title']) || !empty($tpl['thumb_slug']))
			lifecoach_add_thumb_sizes( $tpl );
		else 
			$tpl['thumb_title'] = '';
	}
}

// Return template file name
if (!function_exists('lifecoach_get_template_name')) {
	function lifecoach_get_template_name($layout_name) {
		$tpl = lifecoach_storage_get_array('registered_templates', $layout_name);
		return $tpl['template'];
	}
}

// Return true, if template required content
if (!function_exists('lifecoach_get_template_property')) {
	function lifecoach_get_template_property($layout_name, $what) {
		$tpl = lifecoach_storage_get_array('registered_templates', $layout_name);
		return !empty($tpl[$what]) ? $tpl[$what] : '';
	}
}

// Return template output function name
if (!function_exists('lifecoach_get_template_function_name')) {
	function lifecoach_get_template_function_name($layout_name) {
		$tpl = lifecoach_storage_get_array('registered_templates', $layout_name);
		return 'lifecoach_template_'.str_replace(array('-', '.'), '_', $tpl['template']).'_output';
	}
}

// Set template arguments
if (!function_exists('lifecoach_template_set_args')) {
	function lifecoach_template_set_args($tpl, $args) {
		lifecoach_storage_push_array('call_args', $tpl, $args);
	}
}


// Get template arguments
if (!function_exists('lifecoach_template_get_args')) {
	function lifecoach_template_get_args($tpl) {
		return lifecoach_storage_pop_array('call_args', $tpl, array());
	}
}


// Look for last template arguments (without removing it from storage)
if (!function_exists('lifecoach_template_last_args')) {
	function lifecoach_template_last_args($tpl) {
		$args = lifecoach_storage_get_array('call_args', $tpl, array());
		return is_array($args) ? array_pop($args) : array();
	}
}


/* Thumbs
-------------------------------------------------------------------------------- */

// Add image dimensions with layout name
// $sizes = array( 
//		'layout' => 'layout_name',
//		'thumb_slug' => 'Thumb slug',	// Optional. If omitted - use thumb_title
//		'thumb_title' => 'Thumb title',
//		'w'      => width,
//		'h'      => height (null if no crop, but only scale),
//		'h_crop' => cropped height,
//		'add_image_size" => true
//		);
// $sizes = array('layout' => 'excerpt',  'thumb_title'=>'Medium image', 'w' => 720, 'h' => 460, 'h_crop' => 460);
// $sizes = array('layout' => 'fullpost', 'thumb_title'=>'Large image', 'w' => 1150, 'h' => null, 'h_crop' => 720);
if (!function_exists('lifecoach_add_thumb_sizes')) {
	function lifecoach_add_thumb_sizes($sizes) {
		static $mult = 0;
		if ($mult == 0) $mult = min(4, max(1, lifecoach_get_theme_option("retina_ready")));
		if (!isset($sizes['h_crop']))		$sizes['h_crop'] =  isset($sizes['h']) ? $sizes['h'] : null;
		//if (empty($sizes['mode']))		$sizes['mode'] = 'blog';
		if (empty($sizes['thumb_title']))	$sizes['thumb_title'] = lifecoach_strtoproper(!empty($sizes['layout']) ? $sizes['layout'] : $sizes['thumb_slug']);
		$thumb_slug = !empty($sizes['thumb_slug']) ? $sizes['thumb_slug'] : lifecoach_get_slug($sizes['thumb_title']);
		if (empty($sizes['layout']))		$sizes['layout'] = $thumb_slug;
		if (lifecoach_storage_get_array('thumb_sizes', $thumb_slug)=='') {
			lifecoach_storage_set_array('thumb_sizes', $thumb_slug, $sizes);
			// Register WP thumb size
			if (lifecoach_get_theme_setting('add_image_size') && (!isset($sizes['add_image_size']) || $sizes['add_image_size'])) {
				// Image thumb and retina version
				add_image_size( 'lifecoach-'.$thumb_slug, $sizes['w'], $sizes['h'], $sizes['h']!=null );
				if ($mult > 1)
					add_image_size( 'lifecoach-'.$thumb_slug.'-@retina', $sizes['w'] ? $sizes['w']*$mult : $sizes['w'], $sizes['h'] ? $sizes['h']*$mult : $sizes['h'], $sizes['h']!=null );
				// Cropped image thumb and retina version
				if ($sizes['h']!=$sizes['h_crop']) {
					add_image_size( 'lifecoach-'.$thumb_slug.'_crop', $sizes['w'], $sizes['h_crop'], true );
					if ($mult > 1) 
						add_image_size( 'lifecoach-'.$thumb_slug.'_crop-@retina', $sizes['w'] ? $sizes['w']*$mult : $sizes['w'], $sizes['h_crop'] ? $sizes['h_crop']*$mult : $sizes['h_crop'], true );
				}
			}
		}
	}
}

// Return image dimensions
if (!function_exists('lifecoach_get_thumb_sizes')) {
	function lifecoach_get_thumb_sizes($opt) {
		$opt = array_merge(array(
			'layout' => 'excerpt',
			'thumb_slug' => ''
		), $opt);
		$tpl = lifecoach_storage_get_array('registered_templates', $opt['layout']);
		$thumb_slug = !empty($opt['thumb_slug']) 
						? $opt['thumb_slug'] 
						: (empty($tpl['thumb_slug']) 
							? (empty($tpl['thumb_title']) 
								? '' 
								: lifecoach_get_slug($tpl['thumb_title'])
								) 
							: lifecoach_get_slug($tpl['thumb_slug'])
							);
		$thumb_size = lifecoach_storage_get_array('thumb_sizes', $thumb_slug);
		return !empty($thumb_size) ? $thumb_size : array('w'=>null, 'h'=>null, 'h_crop'=>null);
	}
}

// Show custom thumb sizes into media manager sizes list
if (!function_exists('lifecoach_show_thumb_sizes')) {
	function lifecoach_show_thumb_sizes( $sizes ) {
		$thumb_sizes = lifecoach_storage_get('thumb_sizes');
		if (is_array($thumb_sizes) && count($thumb_sizes) > 0) {
			$rez = array();
			foreach ($thumb_sizes as $k=>$v)
				$rez[$k] = !empty($v['thumb_title']) ? $v['thumb_title'] : $k;
			$sizes = array_merge( $sizes, $rez);
		}
		return $sizes;
	}
}

// AJAX callback: Get attachment url
if ( !function_exists( 'lifecoach_callback_get_attachment_url' ) ) {
	function lifecoach_callback_get_attachment_url() {
		if ( !wp_verify_nonce( lifecoach_get_value_gp('nonce'), admin_url('admin-ajax.php') ) )
			die();
	
		$response = array('error'=>'');
		
		$id = (int) $_REQUEST['attachment_id'];
		
		$response['data'] = wp_get_attachment_url($id);
		
		echo json_encode($response);
		die();
	}
}
?>