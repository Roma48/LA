<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('lifecoach_sc_promo_theme_setup')) {
	add_action( 'lifecoach_action_before_init_theme', 'lifecoach_sc_promo_theme_setup' );
	function lifecoach_sc_promo_theme_setup() {
		add_action('lifecoach_action_shortcodes_list', 		'lifecoach_sc_promo_reg_shortcodes');
		if (function_exists('lifecoach_exists_visual_composer') && lifecoach_exists_visual_composer())
			add_action('lifecoach_action_shortcodes_list_vc','lifecoach_sc_promo_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */


if (!function_exists('lifecoach_sc_promo')) {	
	function lifecoach_sc_promo($atts, $content=null){	
		if (lifecoach_in_shortcode_blogger()) return '';
		extract(lifecoach_html_decode(shortcode_atts(array(
			// Individual params
			"size" => "large",
			"align" => "none",
			"image" => "",
			"image_position" => "left",
			"image_width" => "50%",
			"text_margins" => '',
			"text_align" => "left",
			"scheme" => "",
			"title" => "",
			"subtitle" => "",
			"description" => "",
			"link_caption" => esc_html__('Learn more', 'lifecoach'),
			"link" => '',
			// Common params
			"id" => "",
			"class" => "",
			"animation" => "",
			"css" => "",
			"width" => "",
			"height" => "",
			"top" => "",
			"bottom" => "",
			"left" => "",
			"right" => ""
		), $atts)));
	
		if ($image > 0) {
			$attach = wp_get_attachment_image_src($image, 'full');
			if (isset($attach[0]) && $attach[0]!='')
				$image = $attach[0];
		}
		if ($image == '') {
			$image_width = '0%';
			$text_margins = '';
		}
		
		$width  = lifecoach_prepare_css_value($width);
		$height = lifecoach_prepare_css_value($height);
		
		$class .= ($class ? ' ' : '') . lifecoach_get_css_position_as_classes($top, $right, $bottom, $left);
		$css .= lifecoach_get_css_dimensions_from_values($width, $height);
		
		$css_image = (!empty($image) ? 'background-image:url(' . esc_url($image) . ');' : '')
				     . (!empty($image_width) ? 'width:'.trim($image_width).';' : '')
				     . (!empty($image_position) ? $image_position.': 0;' : '');
	
		$text_width = lifecoach_strpos($image_width, '%')!==false
						? (100 - (int) str_replace('%', '', $image_width)).'%'
						: 'calc(100%-'.trim($image_width).')';
		$css_text = 'width: '.esc_attr($text_width).'; float: '.($image_position=='left' ? 'right' : 'left').';'.(!empty($text_margins) ? ' margin:'.esc_attr($text_margins).';' : '');
		
		$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
					. ' class="sc_promo' 
						. ($class ? ' ' . esc_attr($class) : '') 
						. ($scheme && !lifecoach_param_is_off($scheme) && !lifecoach_param_is_inherit($scheme) ? ' scheme_'.esc_attr($scheme) : '') 
						. ($size ? ' sc_promo_size_'.esc_attr($size) : '') 
						. ($align && $align!='none' ? ' align'.esc_attr($align) : '') 
						. (empty($image) ? ' no_image' : '')
						. '"'
					. (!lifecoach_param_is_off($animation) ? ' data-animation="'.esc_attr(lifecoach_get_animation_classes($animation)).'"' : '')
					. ($css ? 'style="'.esc_attr($css).'"' : '')
					.'>' 
					. '<div class="sc_promo_inner">'
						. '<div class="sc_promo_image" style="'.esc_attr($css_image).'"></div>'
						. '<div class="sc_promo_block sc_align_'.esc_attr($text_align).'" style="'.esc_attr($css_text).'">'
							. '<div class="sc_promo_block_inner">'
									. (!empty($subtitle) ? '<h6 class="sc_promo_subtitle sc_item_subtitle">' . trim(lifecoach_strmacros($subtitle)) . '</h6>' : '')
									. (!empty($title) ? '<h2 class="sc_promo_title sc_item_title">' . trim(lifecoach_strmacros($title)) . '</h2>' : '')
									. (!empty($description) ? '<div class="sc_promo_descr sc_item_descr">' . trim(lifecoach_strmacros($description)) . '</div>' : '')
									. (!empty($content) ? '<div class="sc_promo_content">'.do_shortcode($content).'</div>' : '')
									. (!empty($link) ? '<div class="sc_promo_button sc_item_button">'.lifecoach_do_shortcode('[trx_button link="'.esc_url($link).'" icon="icon-right"]'.esc_html($link_caption).'[/trx_button]').'</div>' : '')
							. '</div>'
						. '</div>'
					. '</div>'
				. '</div>';
	
	
	
		return apply_filters('lifecoach_shortcode_output', $output, 'trx_promo', $atts, $content);
	}
	lifecoach_require_shortcode('trx_promo', 'lifecoach_sc_promo');
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'lifecoach_sc_promo_reg_shortcodes' ) ) {
	//add_action('lifecoach_action_shortcodes_list', 'lifecoach_sc_promo_reg_shortcodes');
	function lifecoach_sc_promo_reg_shortcodes() {
	
		lifecoach_sc_map("trx_promo", array(
			"title" => esc_html__("Promo", 'lifecoach'),
			"desc" => wp_kses_data( __("Insert promo diagramm in your page (post)", 'lifecoach') ),
			"decorate" => true,
			"container" => false,
			"params" => array(
				"align" => array(
					"title" => esc_html__("Alignment of the promo block", 'lifecoach'),
					"desc" => wp_kses_data( __("Align whole promo block to left or right side of the page or parent container", 'lifecoach') ),
					"value" => "",
					"type" => "checklist",
					"dir" => "horizontal",
					"options" => lifecoach_get_sc_param('float')
				), 
				"size" => array(
					"title" => esc_html__("Size of the promo block", 'lifecoach'),
					"desc" => wp_kses_data( __("Size of the promo block: large - one in the row, small - insize two or greater columns", 'lifecoach') ),
					"value" => "large",
					"type" => "switch",
					"options" => array(
						'small' => esc_html__('Small', 'lifecoach'),
						'large' => esc_html__('Large', 'lifecoach')
					)
				), 
				"image" => array(
					"title" => esc_html__("Image URL", 'lifecoach'),
					"desc" => wp_kses_data( __("Select the promo image from the library for this section", 'lifecoach') ),
					"readonly" => false,
					"value" => "",
					"type" => "media"
				),
				"image_position" => array(
					"title" => esc_html__("Image position", 'lifecoach'),
					"desc" => wp_kses_data( __("Place the image to the left or to the right from the text block", 'lifecoach') ),
					"value" => "left",
					"type" => "checklist",
					"dir" => "horizontal",
					"options" => lifecoach_get_sc_param('hpos')
				),
				"image_width" => array(
					"title" => esc_html__("Image width", 'lifecoach'),
					"desc" => wp_kses_data( __("Width (in pixels or percents) of the block with image", 'lifecoach') ),
					"value" => "50%",
					"type" => "text"
				),
				"text_margins" => array(
					"title" => esc_html__("Text margins", 'lifecoach'),
					"desc" => wp_kses_data( __("Margins for the all sides of the text block (Example: 30px 10px 40px 30px = top right botton left OR 30px = equal for all sides)", 'lifecoach') ),
					"value" => "",
					"type" => "text"
				),
				"text_align" => array(
					"title" => esc_html__("Text alignment", 'lifecoach'),
					"desc" => wp_kses_data( __("Align the text inside the block", 'lifecoach') ),
					"value" => "left",
					"type" => "checklist",
					"dir" => "horizontal",
					"options" => lifecoach_get_sc_param('align')
				),
				"scheme" => array(
					"title" => esc_html__("Color scheme", 'lifecoach'),
					"desc" => wp_kses_data( __("Select color scheme for the section with text", 'lifecoach') ),
					"value" => "",
					"type" => "checklist",
					"options" => lifecoach_get_sc_param('schemes')
				),
				"title" => array(
					"title" => esc_html__("Title", 'lifecoach'),
					"desc" => wp_kses_data( __("Title for the block", 'lifecoach') ),
					"value" => "",
					"type" => "text"
				),
				"subtitle" => array(
					"title" => esc_html__("Subtitle", 'lifecoach'),
					"desc" => wp_kses_data( __("Subtitle for the block", 'lifecoach') ),
					"value" => "",
					"type" => "text"
				),
				"description" => array(
					"title" => esc_html__("Description", 'lifecoach'),
					"desc" => wp_kses_data( __("Short description for the block", 'lifecoach') ),
					"value" => "",
					"type" => "textarea"
				),
				"link" => array(
					"title" => esc_html__("Button URL", 'lifecoach'),
					"desc" => wp_kses_data( __("Link URL for the button at the bottom of the block", 'lifecoach') ),
					"value" => "",
					"type" => "text"
				),
				"link_caption" => array(
					"title" => esc_html__("Button caption", 'lifecoach'),
					"desc" => wp_kses_data( __("Caption for the button at the bottom of the block", 'lifecoach') ),
					"value" => "",
					"type" => "text"
				), 
				"width" => lifecoach_shortcodes_width(),
				"height" => lifecoach_shortcodes_height(),
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
if ( !function_exists( 'lifecoach_sc_promo_reg_shortcodes_vc' ) ) {
	//add_action('lifecoach_action_shortcodes_list_vc', 'lifecoach_sc_promo_reg_shortcodes_vc');
	function lifecoach_sc_promo_reg_shortcodes_vc() {
	
		vc_map( array(
			"base" => "trx_promo",
			"name" => esc_html__("Promo", 'lifecoach'),
			"description" => wp_kses_data( __("Insert promo block", 'lifecoach') ),
			"category" => esc_html__('Content', 'lifecoach'),
			'icon' => 'icon_trx_promo',
			"class" => "trx_sc_collection trx_sc_promo",
			"content_element" => true,
			"is_container" => true,
			"show_settings_on_create" => true,
			"params" => array(
				array(
					"param_name" => "align",
					"heading" => esc_html__("Alignment of the promo block", 'lifecoach'),
					"description" => wp_kses_data( __("Align whole promo block to left or right side of the page or parent container", 'lifecoach') ),
					"class" => "",
					"std" => 'none',
					"value" => array_flip(lifecoach_get_sc_param('float')),
					"type" => "dropdown"
				),
				array(
					"param_name" => "size",
					"heading" => esc_html__("Size of the promo block", 'lifecoach'),
					"description" => wp_kses_data( __("Size of the promo block: large - one in the row, small - insize two or greater columns", 'lifecoach') ),
					"class" => "",
					"value" => array(esc_html__('Use small block', 'lifecoach') => 'small'),
					"type" => "checkbox"
				),
				array(
					"param_name" => "image",
					"heading" => esc_html__("Image URL", 'lifecoach'),
					"description" => wp_kses_data( __("Select the promo image from the library for this section", 'lifecoach') ),
					"class" => "",
					"value" => "",
					"type" => "attach_image"
				),
				array(
					"param_name" => "image_position",
					"heading" => esc_html__("Image position", 'lifecoach'),
					"description" => wp_kses_data( __("Place the image to the left or to the right from the text block", 'lifecoach') ),
					"class" => "",
					"std" => 'left',
					"value" => array_flip(lifecoach_get_sc_param('hpos')),
					"type" => "dropdown"
				),
				array(
					"param_name" => "image_width",
					"heading" => esc_html__("Image width", 'lifecoach'),
					"description" => wp_kses_data( __("Width (in pixels or percents) of the block with image", 'lifecoach') ),
					"value" => '',
					"std" => "50%",
					"type" => "textfield"
				),
				array(
					"param_name" => "text_margins",
					"heading" => esc_html__("Text margins", 'lifecoach'),
					"description" => wp_kses_data( __("Margins for the all sides of the text block (Example: 30px 10px 40px 30px = top right botton left OR 30px = equal for all sides)", 'lifecoach') ),
					"value" => '',
					"type" => "textfield"
				),
				array(
					"param_name" => "text_align",
					"heading" => esc_html__("Text alignment", 'lifecoach'),
					"description" => wp_kses_data( __("Align text to the left or to the right side inside the block", 'lifecoach') ),
					"class" => "",
					"std" => 'left',
					"value" => array_flip(lifecoach_get_sc_param('align')),
					"type" => "dropdown"
				),
				array(
					"param_name" => "scheme",
					"heading" => esc_html__("Color scheme", 'lifecoach'),
					"description" => wp_kses_data( __("Select color scheme for the section with text", 'lifecoach') ),
					"class" => "",
					"value" => array_flip(lifecoach_get_sc_param('schemes')),
					"type" => "dropdown"
				),
				array(
					"param_name" => "title",
					"heading" => esc_html__("Title", 'lifecoach'),
					"description" => wp_kses_data( __("Title for the block", 'lifecoach') ),
					"admin_label" => true,
					"group" => esc_html__('Captions', 'lifecoach'),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "subtitle",
					"heading" => esc_html__("Subtitle", 'lifecoach'),
					"description" => wp_kses_data( __("Subtitle for the block", 'lifecoach') ),
					"group" => esc_html__('Captions', 'lifecoach'),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "description",
					"heading" => esc_html__("Description", 'lifecoach'),
					"description" => wp_kses_data( __("Description for the block", 'lifecoach') ),
					"group" => esc_html__('Captions', 'lifecoach'),
					"class" => "",
					"value" => "",
					"type" => "textarea"
				),
				array(
					"param_name" => "link",
					"heading" => esc_html__("Button URL", 'lifecoach'),
					"description" => wp_kses_data( __("Link URL for the button at the bottom of the block", 'lifecoach') ),
					"group" => esc_html__('Captions', 'lifecoach'),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "link_caption",
					"heading" => esc_html__("Button caption", 'lifecoach'),
					"description" => wp_kses_data( __("Caption for the button at the bottom of the block", 'lifecoach') ),
					"group" => esc_html__('Captions', 'lifecoach'),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				lifecoach_get_vc_param('id'),
				lifecoach_get_vc_param('class'),
				lifecoach_get_vc_param('animation'),
				lifecoach_get_vc_param('css'),
				lifecoach_vc_width(),
				lifecoach_vc_height(),
				lifecoach_get_vc_param('margin_top'),
				lifecoach_get_vc_param('margin_bottom'),
				lifecoach_get_vc_param('margin_left'),
				lifecoach_get_vc_param('margin_right')
			)
		) );
		
		class WPBakeryShortCode_Trx_Promo extends LIFECOACH_VC_ShortCodeCollection {}
	}
}
?>