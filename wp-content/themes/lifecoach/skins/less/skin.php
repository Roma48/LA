<?php
/**
 * Skin file for the theme.
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Theme init
if (!function_exists('lifecoach_action_skin_theme_setup')) {
	add_action( 'lifecoach_action_init_theme', 'lifecoach_action_skin_theme_setup', 1 );
	function lifecoach_action_skin_theme_setup() {

		// Add skin fonts in the used fonts list
		add_filter('lifecoach_filter_used_fonts',			'lifecoach_filter_skin_used_fonts');
		// Add skin fonts (from Google fonts) in the main fonts list (if not present).
		add_filter('lifecoach_filter_list_fonts',			'lifecoach_filter_skin_list_fonts');

		// Add skin stylesheets
		add_action('lifecoach_action_add_styles',			'lifecoach_action_skin_add_styles');
		// Add skin inline styles
		add_filter('lifecoach_filter_add_styles_inline',		'lifecoach_filter_skin_add_styles_inline');
		// Add skin responsive styles
		add_action('lifecoach_action_add_responsive',		'lifecoach_action_skin_add_responsive');
		// Add skin responsive inline styles
		add_filter('lifecoach_filter_add_responsive_inline',	'lifecoach_filter_skin_add_responsive_inline');

		// Add skin scripts
		add_action('lifecoach_action_add_scripts',			'lifecoach_action_skin_add_scripts');
		// Add skin scripts inline
		add_action('lifecoach_action_add_scripts_inline',	'lifecoach_action_skin_add_scripts_inline');

		// Add skin less files into list for compilation
		add_filter('lifecoach_filter_compile_less',			'lifecoach_filter_skin_compile_less');


		/* Color schemes
		
		// Accenterd colors
		accent1			- theme accented color 1
		accent1_hover	- theme accented color 1 (hover state)
		accent2			- theme accented color 2
		accent2_hover	- theme accented color 2 (hover state)		
		accent3			- theme accented color 3
		accent3_hover	- theme accented color 3 (hover state)		
		
		// Headers, text and links
		text			- main content
		text_light		- post info
		text_dark		- headers
		inverse_text	- text on accented background
		inverse_light	- post info on accented background
		inverse_dark	- headers on accented background
		inverse_link	- links on accented background
		inverse_hover	- hovered links on accented background
		
		// Block's border and background
		bd_color		- border for the entire block
		bg_color		- background color for the entire block
		bg_image, bg_image_position, bg_image_repeat, bg_image_attachment  - first background image for the entire block
		bg_image2,bg_image2_position,bg_image2_repeat,bg_image2_attachment - second background image for the entire block
		
		// Alternative colors - highlight blocks, form fields, etc.
		alter_text		- text on alternative background
		alter_light		- post info on alternative background
		alter_dark		- headers on alternative background
		alter_link		- links on alternative background
		alter_hover		- hovered links on alternative background
		alter_bd_color	- alternative border
		alter_bd_hover	- alternative border for hovered state or active field
		alter_bg_color	- alternative background
		alter_bg_hover	- alternative background for hovered state or active field 
		alter_bg_image, alter_bg_image_position, alter_bg_image_repeat, alter_bg_image_attachment - background image for the alternative block
		
		*/

		// Add color schemes
		lifecoach_add_color_scheme('original', array(

			'title'					=> esc_html__('Original', 'lifecoach'),

			// Accent colors
			'accent1'				=> '#294271', //+
			'accent1_hover'			=> '#25c6ed', //+
			'accent2'				=> '#f32769', //+
			'accent2_hover'			=> '#fee674', //+
//			'accent3'				=> '',
//			'accent3_hover'			=> '',
			
			// Headers, text and links colors
			'text'					=> '#767a82', //+
			'text_light'			=> '#acb4b6',
			'text_dark'				=> '#232a34',
			'inverse_text'			=> '#ffffff', //+
			'inverse_light'			=> '#ffffff',
			'inverse_dark'			=> '#ffffff',
			'inverse_link'			=> '#ffffff',
			'inverse_hover'			=> '#ffffff',
			
			// Whole block border and background
			'bd_color'				=> '#f4f7f9', //+
			'bg_color'				=> '#f2f8f8', //+
			'bg_image'				=> '',
			'bg_image_position'		=> 'left top',
			'bg_image_repeat'		=> 'repeat',
			'bg_image_attachment'	=> 'scroll',
			'bg_image2'				=> '',
			'bg_image2_position'	=> 'left top',
			'bg_image2_repeat'		=> 'repeat',
			'bg_image2_attachment'	=> 'scroll',
		
			// Alternative blocks (submenu items, form's fields, etc.)
			'alter_text'			=> '#8a8a8a',
			'alter_light'			=> '#acb4b6',
			'alter_dark'			=> '#232a34',
			'alter_link'			=> '#20c7ca',
			'alter_hover'			=> '#189799',
			'alter_bd_color'		=> '#dddddd',
			'alter_bd_hover'		=> '#bbbbbb',
			'alter_bg_color'		=> '#a5d2d0', //+
			'alter_bg_hover'		=> '#213355', //+
			'alter_bg_image'			=> '',
			'alter_bg_image_position'	=> 'left top',
			'alter_bg_image_repeat'		=> 'repeat',
			'alter_bg_image_attachment'	=> 'scroll',
			)
		);

        // Add color schemes
        lifecoach_add_color_scheme('blue', array(

                'title'					=> esc_html__('Blue', 'lifecoach'),

                // Accent colors
                'accent1'				=> '#294271', //+
                'accent1_hover'			=> '#25c6ed', //+
                'accent2'				=> '#01bbd4', //+
                'accent2_hover'			=> '#ffb052', //+
//			'accent3'				=> '',
//			'accent3_hover'			=> '',

                // Headers, text and links colors
                'text'					=> '#767a82', //+
                'text_light'			=> '#acb4b6',
                'text_dark'				=> '#232a34',
                'inverse_text'			=> '#ffffff', //+
                'inverse_light'			=> '#ffffff',
                'inverse_dark'			=> '#ffffff',
                'inverse_link'			=> '#ffffff',
                'inverse_hover'			=> '#ffffff',

                // Whole block border and background
                'bd_color'				=> '#f4f7f9', //+
                'bg_color'				=> '#faf0ee', //+
                'bg_image'				=> '',
                'bg_image_position'		=> 'left top',
                'bg_image_repeat'		=> 'repeat',
                'bg_image_attachment'	=> 'scroll',
                'bg_image2'				=> '',
                'bg_image2_position'	=> 'left top',
                'bg_image2_repeat'		=> 'repeat',
                'bg_image2_attachment'	=> 'scroll',

                // Alternative blocks (submenu items, form's fields, etc.)
                'alter_text'			=> '#8a8a8a',
                'alter_light'			=> '#acb4b6',
                'alter_dark'			=> '#232a34',
                'alter_link'			=> '#20c7ca',
                'alter_hover'			=> '#189799',
                'alter_bd_color'		=> '#dddddd',
                'alter_bd_hover'		=> '#bbbbbb',
                'alter_bg_color'		=> '#f8c5b9', //+
                'alter_bg_hover'		=> '#213355', //+
                'alter_bg_image'			=> '',
                'alter_bg_image_position'	=> 'left top',
                'alter_bg_image_repeat'		=> 'repeat',
                'alter_bg_image_attachment'	=> 'scroll',
            )
        );

        // Add color schemes
        lifecoach_add_color_scheme('yellow', array(

                'title'					=> esc_html__('Yellow', 'lifecoach'),

                // Accent colors
                'accent1'				=> '#294271', //+
                'accent1_hover'			=> '#25c6ed', //+
                'accent2'				=> '#ff9934', //+
                'accent2_hover'			=> '#15cc92', //+
//			'accent3'				=> '',
//			'accent3_hover'			=> '',

                // Headers, text and links colors
                'text'					=> '#767a82', //+
                'text_light'			=> '#acb4b6',
                'text_dark'				=> '#232a34',
                'inverse_text'			=> '#ffffff', //+
                'inverse_light'			=> '#ffffff',
                'inverse_dark'			=> '#ffffff',
                'inverse_link'			=> '#ffffff',
                'inverse_hover'			=> '#ffffff',

                // Whole block border and background
                'bd_color'				=> '#f4f7f9', //+
                'bg_color'				=> '#f2f8f8', //+
                'bg_image'				=> '',
                'bg_image_position'		=> 'left top',
                'bg_image_repeat'		=> 'repeat',
                'bg_image_attachment'	=> 'scroll',
                'bg_image2'				=> '',
                'bg_image2_position'	=> 'left top',
                'bg_image2_repeat'		=> 'repeat',
                'bg_image2_attachment'	=> 'scroll',

                // Alternative blocks (submenu items, form's fields, etc.)
                'alter_text'			=> '#8a8a8a',
                'alter_light'			=> '#acb4b6',
                'alter_dark'			=> '#232a34',
                'alter_link'			=> '#20c7ca',
                'alter_hover'			=> '#189799',
                'alter_bd_color'		=> '#dddddd',
                'alter_bd_hover'		=> '#bbbbbb',
                'alter_bg_color'		=> '#0189b2', //+
                'alter_bg_hover'		=> '#213355', //+
                'alter_bg_image'			=> '',
                'alter_bg_image_position'	=> 'left top',
                'alter_bg_image_repeat'		=> 'repeat',
                'alter_bg_image_attachment'	=> 'scroll',
            )
        );



		/* Font slugs:
		h1 ... h6	- headers
		p			- plain text
		link		- links
		info		- info blocks (Posted 15 May, 2015 by John Doe)
		menu		- main menu
		submenu		- dropdown menus
		logo		- logo text
		button		- button's caption
		input		- input fields
		*/

		// Add Custom fonts
		lifecoach_add_custom_font('h1', array(
			'title'			=> esc_html__('Heading 1', 'lifecoach'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '2.941em',
			'font-weight'	=> '400',
			'font-style'	=> '',
			'line-height'	=> '',
			'margin-top'	=> '0.5em',
			'margin-bottom'	=> '0.24em'
			)
		);
		lifecoach_add_custom_font('h2', array(
			'title'			=> esc_html__('Heading 2', 'lifecoach'),
			'description'	=> '',
			'font-family'	=> 'Montserrat',
			'font-size' 	=> '1.588em',
			'font-weight'	=> '400',
			'font-style'	=> '',
			'line-height'	=> '',
			'margin-top'	=> '0.6667em',
			'margin-bottom'	=> '0.65em'
			)
		);
		lifecoach_add_custom_font('h3', array(
			'title'			=> esc_html__('Heading 3', 'lifecoach'),
			'description'	=> '',
			'font-family'	=> 'Montserrat',
			'font-size' 	=> '1.059em',
			'font-weight'	=> '400',
			'font-style'	=> '',
			'line-height'	=> '',
			'margin-top'	=> '0.6667em',
			'margin-bottom'	=> '1.12em'
			)
		);
		lifecoach_add_custom_font('h4', array(
			'title'			=> esc_html__('Heading 4', 'lifecoach'),
			'description'	=> '',
			'font-family'	=> 'Montserrat',
			'font-size' 	=> '1.059em',
			'font-weight'	=> '400',
			'font-style'	=> '',
			'line-height'	=> '',
			'margin-top'	=> '0.6667em',
			'margin-bottom'	=> '1.05em'
			)
		);
		lifecoach_add_custom_font('h5', array(
			'title'			=> esc_html__('Heading 5', 'lifecoach'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '1.294em',
			'font-weight'	=> '400',
			'font-style'	=> '',
			'line-height'	=> '',
			'margin-top'	=> '1.2em',
			'margin-bottom'	=> '0.92em'
			)
		);
		lifecoach_add_custom_font('h6', array(
			'title'			=> esc_html__('Heading 6', 'lifecoach'),
			'description'	=> '',
			'font-family'	=> 'Montserrat',
			'font-size' 	=> '0.824em',
			'font-weight'	=> '400',
			'font-style'	=> '',
			'line-height'	=> '',
			'margin-top'	=> '1.25em',
			'margin-bottom'	=> '0.65em'
			)
		);
		lifecoach_add_custom_font('p', array(
			'title'			=> esc_html__('Text', 'lifecoach'),
			'description'	=> '',
			'font-family'	=> 'PT Serif',
			'font-size' 	=> '17px',
			'font-weight'	=> '400',
			'font-style'	=> '',
			'line-height'	=> '1.6470588em',
			'margin-top'	=> '',
			'margin-bottom'	=> '1em'
			)
		);
		lifecoach_add_custom_font('link', array(
			'title'			=> esc_html__('Links', 'lifecoach'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '',
			'font-weight'	=> '',
			'font-style'	=> ''
			)
		);
		lifecoach_add_custom_font('info', array(
			'title'			=> esc_html__('Post info', 'lifecoach'),
			'description'	=> '',
			'font-family'	=> 'Montserrat',
			'font-size' 	=> '',
			'font-weight'	=> '700',
			'font-style'	=> '',
			'line-height'	=> '',
			'margin-top'	=> '',
			'margin-bottom'	=> '0.3em'
			)
		);
		lifecoach_add_custom_font('menu', array(
			'title'			=> esc_html__('Main menu items', 'lifecoach'),
			'description'	=> '',
			'font-family'	=> 'Montserrat',
			'font-size' 	=> '0.824em',
			'font-weight'	=> '700',
			'font-style'	=> '',
			'line-height'	=> '1em',
			'margin-top'	=> '1.9em',
			'margin-bottom'	=> '2.75em'
			)
		);
		lifecoach_add_custom_font('submenu', array(
			'title'			=> esc_html__('Dropdown menu items', 'lifecoach'),
			'description'	=> '',
			'font-family'	=> 'Montserrat',
			'font-size' 	=> '0.824em',
			'font-weight'	=> '700',
			'font-style'	=> '',
			'line-height'	=> '1em',
			'margin-top'	=> '0.95em',
			'margin-bottom'	=> '0.95em'
			)
		);
		lifecoach_add_custom_font('logo', array(
			'title'			=> esc_html__('Logo', 'lifecoach'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '2.8571em',
			'font-weight'	=> '700',
			'font-style'	=> '',
			'line-height'	=> '0.75em',
			'margin-top'	=> '1.4em',
			'margin-bottom'	=> '0.6em'
			)
		);
		lifecoach_add_custom_font('button', array(
			'title'			=> esc_html__('Buttons', 'lifecoach'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '',
			'font-weight'	=> '',
			'font-style'	=> '',
			'line-height'	=> '1.2857em'
			)
		);
		lifecoach_add_custom_font('input', array(
			'title'			=> esc_html__('Input fields', 'lifecoach'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '',
			'font-weight'	=> '',
			'font-style'	=> '',
			'line-height'	=> '1.2857em'
			)
		);

	}
}





//------------------------------------------------------------------------------
// Skin's fonts
//------------------------------------------------------------------------------

// Add skin fonts in the used fonts list
if (!function_exists('lifecoach_filter_skin_used_fonts')) {
	//add_filter('lifecoach_filter_used_fonts', 'lifecoach_filter_skin_used_fonts');
	function lifecoach_filter_skin_used_fonts($theme_fonts) {
		$theme_fonts['PT Serif'] = 1;
		$theme_fonts['Montserrat'] = 1;
		$theme_fonts['Vollkorn'] = 1;
		return $theme_fonts;
	}
}

// Add skin fonts (from Google fonts) in the main fonts list (if not present).
// To use custom font-face you not need add it into list in this function
// How to install custom @font-face fonts into the theme?
// All @font-face fonts are located in "theme_name/css/font-face/" folder in the separate subfolders for the each font. Subfolder name is a font-family name!
// Place full set of the font files (for each font style and weight) and css-file named stylesheet.css in the each subfolder.
// Create your @font-face kit by using Fontsquirrel @font-face Generator (http://www.fontsquirrel.com/fontface/generator)
// and then extract the font kit (with folder in the kit) into the "theme_name/css/font-face" folder to install
if (!function_exists('lifecoach_filter_skin_list_fonts')) {
	//add_filter('lifecoach_filter_list_fonts', 'lifecoach_filter_skin_list_fonts');
	function lifecoach_filter_skin_list_fonts($list) {
		// Example:
		// if (!isset($list['Advent Pro'])) {
		//		$list['Advent Pro'] = array(
		//			'family' => 'sans-serif',																						// (required) font family
		//			'link'   => 'Advent+Pro:100,100italic,300,300italic,400,400italic,500,500italic,700,700italic,900,900italic',	// (optional) if you use Google font repository
		//			'css'    => lifecoach_get_file_url('/css/font-face/Advent-Pro/stylesheet.css')									// (optional) if you use custom font-face
		//			);
		// }
		if (!isset($list['PT Serif'])) {
            $list['PT Serif'] = array(
                'family'    =>  'serif',
                'link'      =>  'PT+Serif:400,400italic,700,700italic'
            );
        }
        if (!isset($list['Montserrat'])) {
            $list['Montserrat'] = array(
                'family'    =>  'sans-serif',
                'link'      =>  'Montserrat:400,700'
            );
        }
        if (!isset($list['Vollkorn'])) {
            $list['Vollkorn'] = array(
                'family'    =>  'serif',
                'link'      =>  'Vollkorn:400,400italic,700,700italic'
            );
        }
		return $list;
	}
}



//------------------------------------------------------------------------------
// Skin's stylesheets
//------------------------------------------------------------------------------
// Add skin stylesheets
if (!function_exists('lifecoach_action_skin_add_styles')) {
	//add_action('lifecoach_action_add_styles', 'lifecoach_action_skin_add_styles');
	function lifecoach_action_skin_add_styles() {
		// Add stylesheet files
		lifecoach_enqueue_style( 'lifecoach-skin-style', lifecoach_get_file_url('skin.css'), array(), null );
		if (file_exists(lifecoach_get_file_dir('skin.customizer.css')))
			lifecoach_enqueue_style( 'lifecoach-skin-customizer-style', lifecoach_get_file_url('skin.customizer.css'), array(), null );
	}
}

// Add skin inline styles
if (!function_exists('lifecoach_filter_skin_add_styles_inline')) {
	//add_filter('lifecoach_filter_add_styles_inline', 'lifecoach_filter_skin_add_styles_inline');
	function lifecoach_filter_skin_add_styles_inline($custom_style) {
		// Todo: add skin specific styles in the $custom_style to override
		//       rules from style.css and shortcodes.css
		// Example:
		//		$scheme = lifecoach_get_custom_option('body_scheme');
		//		if (empty($scheme)) $scheme = 'original';
		//		$clr = lifecoach_get_scheme_color('accent1');
		//		if (!empty($clr)) {
		// 			$custom_style .= '
		//				a,
		//				.bg_tint_light a,
		//				.top_panel .content .search_wrap.search_style_regular .search_form_wrap .search_submit,
		//				.top_panel .content .search_wrap.search_style_regular .search_icon,
		//				.search_results .post_more,
		//				.search_results .search_results_close {
		//					color:'.esc_attr($clr).';
		//				}
		//			';
		//		}
		return $custom_style;	
	}
}

// Add skin responsive styles
if (!function_exists('lifecoach_action_skin_add_responsive')) {
	//add_action('lifecoach_action_add_responsive', 'lifecoach_action_skin_add_responsive');
	function lifecoach_action_skin_add_responsive() {
		$suffix = lifecoach_param_is_off(lifecoach_get_custom_option('show_sidebar_outer')) ? '' : '-outer';
		if (file_exists(lifecoach_get_file_dir('skin.responsive'.($suffix).'.css'))) 
			lifecoach_enqueue_style( 'theme-skin-responsive-style', lifecoach_get_file_url('skin.responsive'.($suffix).'.css'), array(), null );
	}
}

// Add skin responsive inline styles
if (!function_exists('lifecoach_filter_skin_add_responsive_inline')) {
	//add_filter('lifecoach_filter_add_responsive_inline', 'lifecoach_filter_skin_add_responsive_inline');
	function lifecoach_filter_skin_add_responsive_inline($custom_style) {
		return $custom_style;	
	}
}

// Add skin.less into list files for compilation
if (!function_exists('lifecoach_filter_skin_compile_less')) {
	//add_filter('lifecoach_filter_compile_less', 'lifecoach_filter_skin_compile_less');
	function lifecoach_filter_skin_compile_less($files) {
		if (file_exists(lifecoach_get_file_dir('skin.less'))) {
		 	$files[] = lifecoach_get_file_dir('skin.less');
		}
		return $files;	
	}
}



//------------------------------------------------------------------------------
// Skin's scripts
//------------------------------------------------------------------------------

// Add skin scripts
if (!function_exists('lifecoach_action_skin_add_scripts')) {
	//add_action('lifecoach_action_add_scripts', 'lifecoach_action_skin_add_scripts');
	function lifecoach_action_skin_add_scripts() {
		if (file_exists(lifecoach_get_file_dir('skin.js')))
			lifecoach_enqueue_script( 'theme-skin-script', lifecoach_get_file_url('skin.js'), array(), null );
		if (lifecoach_get_theme_option('show_theme_customizer') == 'yes' && file_exists(lifecoach_get_file_dir('skin.customizer.js')))
			lifecoach_enqueue_script( 'theme-skin-customizer-script', lifecoach_get_file_url('skin.customizer.js'), array(), null );
	}
}

// Add skin scripts inline
if (!function_exists('lifecoach_action_skin_add_scripts_inline')) {
	//add_action('lifecoach_action_add_scripts_inline', 'lifecoach_action_skin_add_scripts_inline');
	function lifecoach_action_skin_add_scripts_inline() {
		// Todo: add skin specific scripts
		// Example:
		// echo '<script type="text/javascript">'
		//	. 'jQuery(document).ready(function() {'
		//	. "if (LIFECOACH_STORAGE['theme_font']=='') LIFECOACH_STORAGE['theme_font'] = '" . lifecoach_get_custom_font_settings('p', 'font-family') . "';"
		//	. "LIFECOACH_STORAGE['theme_skin_color'] = '" . lifecoach_get_scheme_color('accent1') . "';"
		//	. "});"
		//	. "< /script>";
	}
}
?>