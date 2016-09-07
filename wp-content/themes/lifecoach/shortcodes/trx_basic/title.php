<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('lifecoach_sc_title_theme_setup')) {
	add_action( 'lifecoach_action_before_init_theme', 'lifecoach_sc_title_theme_setup' );
	function lifecoach_sc_title_theme_setup() {
		add_action('lifecoach_action_shortcodes_list', 		'lifecoach_sc_title_reg_shortcodes');
		if (function_exists('lifecoach_exists_visual_composer') && lifecoach_exists_visual_composer())
			add_action('lifecoach_action_shortcodes_list_vc','lifecoach_sc_title_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_title id="unique_id" style='regular|iconed' icon='' image='' background="on|off" type="1-6"]Et adipiscing integer, scelerisque pid, augue mus vel tincidunt porta[/trx_title]
*/

if (!function_exists('lifecoach_sc_title')) {	
	function lifecoach_sc_title($atts, $content=null){	
		if (lifecoach_in_shortcode_blogger()) return '';
		extract(lifecoach_html_decode(shortcode_atts(array(
			// Individual params
			"type" => "1",
			"style" => "regular",
			"align" => "",
			"font_weight" => "",
			"font_size" => "",
			"color" => "",
			"icon" => "",
			"image" => "",
			"picture" => "",
			"image_size" => "small",
			"position" => "left",
			// Common params
			"id" => "",
			"class" => "",
			"animation" => "",
			"css" => "",
			"width" => "",
			"top" => "",
			"bottom" => "",
			"left" => "",
			"right" => ""
		), $atts)));
		$class .= ($class ? ' ' : '') . lifecoach_get_css_position_as_classes($top, $right, $bottom, $left);
		$css .= lifecoach_get_css_dimensions_from_values($width)
			.($align && $align!='none' && !lifecoach_param_is_inherit($align) ? 'text-align:' . esc_attr($align) .';' : '')
			.($color ? 'color:' . esc_attr($color) .';' : '')
			.($font_weight && !lifecoach_param_is_inherit($font_weight) ? 'font-weight:' . esc_attr($font_weight) .';' : '')
			.($font_size   ? 'font-size:' . esc_attr($font_size) .';' : '')
			;
		$type = min(6, max(1, $type));
		if ($picture > 0) {
			$attach = wp_get_attachment_image_src( $picture, 'full' );
			if (isset($attach[0]) && $attach[0]!='')
				$picture = $attach[0];
		}
		$pic = $style!='iconed' 
			? '' 
			: '<span class="sc_title_icon sc_title_icon_'.esc_attr($position).'  sc_title_icon_'.esc_attr($image_size).($icon!='' && $icon!='none' ? ' '.esc_attr($icon) : '').'"'.'>'
				.($picture ? '<img src="'.esc_url($picture).'" alt="" />' : '')
				.(empty($picture) && $image && $image!='none' ? '<img src="'.esc_url(lifecoach_strpos($image, 'http:')!==false ? $image : lifecoach_get_file_url('images/icons/'.($image).'.png')).'" alt="" />' : '')
				.'</span>';
		$output = '<h' . esc_attr($type) . ($id ? ' id="'.esc_attr($id).'"' : '')
				. ' class="sc_title sc_title_'.esc_attr($style)
					.($align && $align!='none' && !lifecoach_param_is_inherit($align) ? ' sc_align_' . esc_attr($align) : '')
					.(!empty($class) ? ' '.esc_attr($class) : '')
					.'"'
				. ($css!='' ? ' style="'.esc_attr($css).'"' : '')
				. (!lifecoach_param_is_off($animation) ? ' data-animation="'.esc_attr(lifecoach_get_animation_classes($animation)).'"' : '')
				. '>'
					. ($pic)
					. ($style=='divider' ? '<span class="sc_title_divider_before"'.($color ? ' style="background-color: '.esc_attr($color).'"' : '').'></span>' : '')
					. do_shortcode($content) 
					. ($style=='divider' ? '<span class="sc_title_divider_after"'.($color ? ' style="background-color: '.esc_attr($color).'"' : '').'></span>' : '')
				. '</h' . esc_attr($type) . '>';
		return apply_filters('lifecoach_shortcode_output', $output, 'trx_title', $atts, $content);
	}
	lifecoach_require_shortcode('trx_title', 'lifecoach_sc_title');
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'lifecoach_sc_title_reg_shortcodes' ) ) {
	//add_action('lifecoach_action_shortcodes_list', 'lifecoach_sc_title_reg_shortcodes');
	function lifecoach_sc_title_reg_shortcodes() {
	
		lifecoach_sc_map("trx_title", array(
			"title" => esc_html__("Title", 'lifecoach'),
			"desc" => wp_kses_data( __("Create header tag (1-6 level) with many styles", 'lifecoach') ),
			"decorate" => false,
			"container" => true,
			"params" => array(
				"_content_" => array(
					"title" => esc_html__("Title content", 'lifecoach'),
					"desc" => wp_kses_data( __("Title content", 'lifecoach') ),
					"rows" => 4,
					"value" => "",
					"type" => "textarea"
				),
				"type" => array(
					"title" => esc_html__("Title type", 'lifecoach'),
					"desc" => wp_kses_data( __("Title type (header level)", 'lifecoach') ),
					"divider" => true,
					"value" => "1",
					"type" => "select",
					"options" => array(
						'1' => esc_html__('Header 1', 'lifecoach'),
						'2' => esc_html__('Header 2', 'lifecoach'),
						'3' => esc_html__('Header 3', 'lifecoach'),
						'4' => esc_html__('Header 4', 'lifecoach'),
						'5' => esc_html__('Header 5', 'lifecoach'),
						'6' => esc_html__('Header 6', 'lifecoach'),
					)
				),
				"style" => array(
					"title" => esc_html__("Title style", 'lifecoach'),
					"desc" => wp_kses_data( __("Title style", 'lifecoach') ),
					"value" => "regular",
					"type" => "select",
					"options" => array(
						'regular' => esc_html__('Regular', 'lifecoach'),
						'underline' => esc_html__('Underline', 'lifecoach'),
						'divider' => esc_html__('Divider', 'lifecoach'),
						'iconed' => esc_html__('With icon (image)', 'lifecoach')
					)
				),
				"align" => array(
					"title" => esc_html__("Alignment", 'lifecoach'),
					"desc" => wp_kses_data( __("Title text alignment", 'lifecoach') ),
					"value" => "",
					"type" => "checklist",
					"dir" => "horizontal",
					"options" => lifecoach_get_sc_param('align')
				), 
				"font_size" => array(
					"title" => esc_html__("Font_size", 'lifecoach'),
					"desc" => wp_kses_data( __("Custom font size. If empty - use theme default", 'lifecoach') ),
					"value" => "",
					"type" => "text"
				),
				"font_weight" => array(
					"title" => esc_html__("Font weight", 'lifecoach'),
					"desc" => wp_kses_data( __("Custom font weight. If empty or inherit - use theme default", 'lifecoach') ),
					"value" => "",
					"type" => "select",
					"size" => "medium",
					"options" => array(
						'inherit' => esc_html__('Default', 'lifecoach'),
						'100' => esc_html__('Thin (100)', 'lifecoach'),
						'300' => esc_html__('Light (300)', 'lifecoach'),
						'400' => esc_html__('Normal (400)', 'lifecoach'),
						'600' => esc_html__('Semibold (600)', 'lifecoach'),
						'700' => esc_html__('Bold (700)', 'lifecoach'),
						'900' => esc_html__('Black (900)', 'lifecoach')
					)
				),
				"color" => array(
					"title" => esc_html__("Title color", 'lifecoach'),
					"desc" => wp_kses_data( __("Select color for the title", 'lifecoach') ),
					"value" => "",
					"type" => "color"
				),
				"icon" => array(
					"title" => esc_html__('Title font icon',  'lifecoach'),
					"desc" => wp_kses_data( __("Select font icon for the title from Fontello icons set (if style=iconed)",  'lifecoach') ),
					"dependency" => array(
						'style' => array('iconed')
					),
					"value" => "",
					"type" => "icons",
					"options" => lifecoach_get_sc_param('icons')
				),
				"image" => array(
					"title" => esc_html__('or image icon',  'lifecoach'),
					"desc" => wp_kses_data( __("Select image icon for the title instead icon above (if style=iconed)",  'lifecoach') ),
					"dependency" => array(
						'style' => array('iconed')
					),
					"value" => "",
					"type" => "images",
					"size" => "small",
					"options" => lifecoach_get_sc_param('images')
				),
				"picture" => array(
					"title" => esc_html__('or URL for image file', 'lifecoach'),
					"desc" => wp_kses_data( __("Select or upload image or write URL from other site (if style=iconed)", 'lifecoach') ),
					"dependency" => array(
						'style' => array('iconed')
					),
					"readonly" => false,
					"value" => "",
					"type" => "media"
				),
				"image_size" => array(
					"title" => esc_html__('Image (picture) size', 'lifecoach'),
					"desc" => wp_kses_data( __("Select image (picture) size (if style='iconed')", 'lifecoach') ),
					"dependency" => array(
						'style' => array('iconed')
					),
					"value" => "small",
					"type" => "checklist",
					"options" => array(
						'small' => esc_html__('Small', 'lifecoach'),
						'medium' => esc_html__('Medium', 'lifecoach'),
						'large' => esc_html__('Large', 'lifecoach')
					)
				),
				"position" => array(
					"title" => esc_html__('Icon (image) position', 'lifecoach'),
					"desc" => wp_kses_data( __("Select icon (image) position (if style=iconed)", 'lifecoach') ),
					"dependency" => array(
						'style' => array('iconed')
					),
					"value" => "left",
					"type" => "checklist",
					"options" => array(
						'top' => esc_html__('Top', 'lifecoach'),
						'left' => esc_html__('Left', 'lifecoach')
					)
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
if ( !function_exists( 'lifecoach_sc_title_reg_shortcodes_vc' ) ) {
	//add_action('lifecoach_action_shortcodes_list_vc', 'lifecoach_sc_title_reg_shortcodes_vc');
	function lifecoach_sc_title_reg_shortcodes_vc() {
	
		vc_map( array(
			"base" => "trx_title",
			"name" => esc_html__("Title", 'lifecoach'),
			"description" => wp_kses_data( __("Create header tag (1-6 level) with many styles", 'lifecoach') ),
			"category" => esc_html__('Content', 'lifecoach'),
			'icon' => 'icon_trx_title',
			"class" => "trx_sc_single trx_sc_title",
			"content_element" => true,
			"is_container" => false,
			"show_settings_on_create" => true,
			"params" => array(
				array(
					"param_name" => "content",
					"heading" => esc_html__("Title content", 'lifecoach'),
					"description" => wp_kses_data( __("Title content", 'lifecoach') ),
					"class" => "",
					"value" => "",
					"type" => "textarea_html"
				),
				array(
					"param_name" => "type",
					"heading" => esc_html__("Title type", 'lifecoach'),
					"description" => wp_kses_data( __("Title type (header level)", 'lifecoach') ),
					"admin_label" => true,
					"class" => "",
					"value" => array(
						esc_html__('Header 1', 'lifecoach') => '1',
						esc_html__('Header 2', 'lifecoach') => '2',
						esc_html__('Header 3', 'lifecoach') => '3',
						esc_html__('Header 4', 'lifecoach') => '4',
						esc_html__('Header 5', 'lifecoach') => '5',
						esc_html__('Header 6', 'lifecoach') => '6'
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "style",
					"heading" => esc_html__("Title style", 'lifecoach'),
					"description" => wp_kses_data( __("Title style: only text (regular) or with icon/image (iconed)", 'lifecoach') ),
					"admin_label" => true,
					"class" => "",
					"value" => array(
						esc_html__('Regular', 'lifecoach') => 'regular',
						esc_html__('Underline', 'lifecoach') => 'underline',
						esc_html__('Divider', 'lifecoach') => 'divider',
						esc_html__('With icon (image)', 'lifecoach') => 'iconed'
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "align",
					"heading" => esc_html__("Alignment", 'lifecoach'),
					"description" => wp_kses_data( __("Title text alignment", 'lifecoach') ),
					"admin_label" => true,
					"class" => "",
					"value" => array_flip(lifecoach_get_sc_param('align')),
					"type" => "dropdown"
				),
				array(
					"param_name" => "font_size",
					"heading" => esc_html__("Font size", 'lifecoach'),
					"description" => wp_kses_data( __("Custom font size. If empty - use theme default", 'lifecoach') ),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "font_weight",
					"heading" => esc_html__("Font weight", 'lifecoach'),
					"description" => wp_kses_data( __("Custom font weight. If empty or inherit - use theme default", 'lifecoach') ),
					"class" => "",
					"value" => array(
						esc_html__('Default', 'lifecoach') => 'inherit',
						esc_html__('Thin (100)', 'lifecoach') => '100',
						esc_html__('Light (300)', 'lifecoach') => '300',
						esc_html__('Normal (400)', 'lifecoach') => '400',
						esc_html__('Semibold (600)', 'lifecoach') => '600',
						esc_html__('Bold (700)', 'lifecoach') => '700',
						esc_html__('Black (900)', 'lifecoach') => '900'
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "color",
					"heading" => esc_html__("Title color", 'lifecoach'),
					"description" => wp_kses_data( __("Select color for the title", 'lifecoach') ),
					"class" => "",
					"value" => "",
					"type" => "colorpicker"
				),
				array(
					"param_name" => "icon",
					"heading" => esc_html__("Title font icon", 'lifecoach'),
					"description" => wp_kses_data( __("Select font icon for the title from Fontello icons set (if style=iconed)", 'lifecoach') ),
					"class" => "",
					"group" => esc_html__('Icon &amp; Image', 'lifecoach'),
					'dependency' => array(
						'element' => 'style',
						'value' => array('iconed')
					),
					"value" => lifecoach_get_sc_param('icons'),
					"type" => "dropdown"
				),
				array(
					"param_name" => "image",
					"heading" => esc_html__("or image icon", 'lifecoach'),
					"description" => wp_kses_data( __("Select image icon for the title instead icon above (if style=iconed)", 'lifecoach') ),
					"class" => "",
					"group" => esc_html__('Icon &amp; Image', 'lifecoach'),
					'dependency' => array(
						'element' => 'style',
						'value' => array('iconed')
					),
					"value" => lifecoach_get_sc_param('images'),
					"type" => "dropdown"
				),
				array(
					"param_name" => "picture",
					"heading" => esc_html__("or select uploaded image", 'lifecoach'),
					"description" => wp_kses_data( __("Select or upload image or write URL from other site (if style=iconed)", 'lifecoach') ),
					"group" => esc_html__('Icon &amp; Image', 'lifecoach'),
					"class" => "",
					"value" => "",
					"type" => "attach_image"
				),
				array(
					"param_name" => "image_size",
					"heading" => esc_html__("Image (picture) size", 'lifecoach'),
					"description" => wp_kses_data( __("Select image (picture) size (if style=iconed)", 'lifecoach') ),
					"group" => esc_html__('Icon &amp; Image', 'lifecoach'),
					"class" => "",
					"value" => array(
						esc_html__('Small', 'lifecoach') => 'small',
						esc_html__('Medium', 'lifecoach') => 'medium',
						esc_html__('Large', 'lifecoach') => 'large'
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "position",
					"heading" => esc_html__("Icon (image) position", 'lifecoach'),
					"description" => wp_kses_data( __("Select icon (image) position (if style=iconed)", 'lifecoach') ),
					"group" => esc_html__('Icon &amp; Image', 'lifecoach'),
					"class" => "",
					"std" => "left",
					"value" => array(
						esc_html__('Top', 'lifecoach') => 'top',
						esc_html__('Left', 'lifecoach') => 'left'
					),
					"type" => "dropdown"
				),
				lifecoach_get_vc_param('id'),
				lifecoach_get_vc_param('class'),
				lifecoach_get_vc_param('animation'),
				lifecoach_get_vc_param('css'),
				lifecoach_get_vc_param('margin_top'),
				lifecoach_get_vc_param('margin_bottom'),
				lifecoach_get_vc_param('margin_left'),
				lifecoach_get_vc_param('margin_right')
			),
			'js_view' => 'VcTrxTextView'
		) );
		
		class WPBakeryShortCode_Trx_Title extends LIFECOACH_VC_ShortCodeSingle {}
	}
}
?>