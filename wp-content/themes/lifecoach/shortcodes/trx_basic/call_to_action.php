<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('lifecoach_sc_call_to_action_theme_setup')) {
	add_action( 'lifecoach_action_before_init_theme', 'lifecoach_sc_call_to_action_theme_setup' );
	function lifecoach_sc_call_to_action_theme_setup() {
		add_action('lifecoach_action_shortcodes_list', 		'lifecoach_sc_call_to_action_reg_shortcodes');
		if (function_exists('lifecoach_exists_visual_composer') && lifecoach_exists_visual_composer())
			add_action('lifecoach_action_shortcodes_list_vc','lifecoach_sc_call_to_action_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_call_to_action id="unique_id" style="1|2" align="left|center|right"]
	[inner shortcodes]
[/trx_call_to_action]
*/

if (!function_exists('lifecoach_sc_call_to_action')) {	
	function lifecoach_sc_call_to_action($atts, $content=null){	
		if (lifecoach_in_shortcode_blogger()) return '';
		extract(lifecoach_html_decode(shortcode_atts(array(
			// Individual params
			"style" => "1",
			"align" => "center",
			"custom" => "no",
			"accent" => "no",
			"image" => "",
			"video" => "",
			"title" => "",
			"subtitle" => "",
			"description" => "",
			"link" => '',
			"link_caption" => esc_html__('Learn more', 'lifecoach'),
			"link2" => '',
			"link2_caption" => '',
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
	
		if (empty($id)) $id = "sc_call_to_action_".str_replace('.', '', mt_rand());
		if (empty($width)) $width = "100%";
	
		if ($image > 0) {
			$attach = wp_get_attachment_image_src( $image, 'full' );
			if (isset($attach[0]) && $attach[0]!='')
				$image = $attach[0];
		}
		if (!empty($image)) {
			$thumb_sizes = lifecoach_get_thumb_sizes(array('layout' => 'excerpt'));
			$image = !empty($video) 
				? lifecoach_get_resized_image_url($image, $thumb_sizes['w'], $thumb_sizes['h']) 
				: lifecoach_get_resized_image_tag($image, $thumb_sizes['w'], $thumb_sizes['h']);
		}
	
		if (!empty($video)) {
			$video = '<video' . ($id ? ' id="' . esc_attr($id.'_video') . '"' : '') 
				. ' class="sc_video"'
				. ' src="' . esc_url(lifecoach_get_video_player_url($video)) . '"'
				. ' width="' . esc_attr($width) . '" height="' . esc_attr($height) . '"' 
				. ' data-width="' . esc_attr($width) . '" data-height="' . esc_attr($height) . '"' 
				. ' data-ratio="16:9"'
				. ($image ? ' poster="'.esc_attr($image).'" data-image="'.esc_attr($image).'"' : '') 
				. ' controls="controls" loop="loop"'
				. '>'
				. '</video>';
			if (lifecoach_get_custom_option('substitute_video')=='no') {
				$video = lifecoach_get_video_frame($video, $image, '', '');
			} else {
				if ((isset($_GET['vc_editable']) && $_GET['vc_editable']=='true') && (isset($_POST['action']) && $_POST['action']=='vc_load_shortcode')) {
					$video = lifecoach_substitute_video($video, $width, $height, false);
				}
			}
			if (lifecoach_get_theme_option('use_mediaelement')=='yes')
				lifecoach_enqueue_script('wp-mediaelement');
		}
		
		$class .= ($class ? ' ' : '') . lifecoach_get_css_position_as_classes($top, $right, $bottom, $left);
		$css .= lifecoach_get_css_dimensions_from_values($width, $height);
		
		$content = do_shortcode($content);
		
		$featured = ($style==1 && (!empty($content) || !empty($image) || !empty($video))
					? '<div class="sc_call_to_action_featured column-1_2">'
						. (!empty($content) 
							? $content 
							: (!empty($video) 
								? $video 
								: $image)
							)
						. '</div>'
					: '');
	
		$need_columns = ($featured || $style==2) && !in_array($align, array('center', 'none'))
							? ($style==2 ? 4 : 2)
							: 0;
		
		$buttons = (!empty($link) || !empty($link2) 
						? '<div class="sc_call_to_action_buttons sc_item_buttons'.($need_columns && $style==2 ? ' column-1_'.esc_attr($need_columns) : '').'">'
							. (!empty($link) 
								? '<div class="sc_call_to_action_button sc_item_button">'.do_shortcode('[trx_button link="'.esc_url($link).'" size="medium"]'.esc_html($link_caption).'[/trx_button]').'</div>'
								: '')
							. (!empty($link2) 
								? '<div class="sc_call_to_action_button sc_item_button">'.do_shortcode('[trx_button link="'.esc_url($link2).'" size="medium"]'.esc_html($link2_caption).'[/trx_button]').'</div>'
								: '')
							. '</div>'
						: '');
	
		
		$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
				. ' class="sc_call_to_action'
					. (lifecoach_param_is_on($accent) ? ' sc_call_to_action_accented' : '')
					. ' sc_call_to_action_style_' . esc_attr($style) 
					. ' sc_call_to_action_align_'.esc_attr($align)
					. (!empty($class) ? ' '.esc_attr($class) : '')
					. '"'
				. (!lifecoach_param_is_off($animation) ? ' data-animation="'.esc_attr(lifecoach_get_animation_classes($animation)).'"' : '')
				. ($css!='' ? ' style="'.esc_attr($css).'"' : '')
			. '>'
//				. (lifecoach_param_is_on($accent) ? '<div class="content_wrap">' : '')
				. ($need_columns ? '<div class="columns_wrap">' : '')
				. ($align!='right' ? $featured : '')
				. ($style==2 && $align=='right' ? $buttons : '')
				. '<div class="sc_call_to_action_info'.($need_columns ? ' column-'.esc_attr($need_columns-1).'_'.esc_attr($need_columns) : '').'">'
					. (!empty($subtitle) ? '<h6 class="sc_call_to_action_subtitle sc_item_subtitle">' . trim(lifecoach_strmacros($subtitle)) . '</h6>' : '')
					. (!empty($title) ? '<h1 class="sc_call_to_action_title sc_item_title">' . trim(lifecoach_strmacros($title)) . '</h1>' : '')
					. (!empty($description) ? '<div class="sc_call_to_action_descr sc_item_descr">' . trim(lifecoach_strmacros($description)) . '</div>' : '')
					. ($style==1 ? $buttons : '')
				. '</div>'
				. ($style==2 && $align!='right' ? $buttons : '')
				. ($align=='right' ? $featured : '')
				. ($need_columns ? '</div>' : '')
//				. (lifecoach_param_is_on($accent) ? '</div>' : '')
			. '</div>';
	
		return apply_filters('lifecoach_shortcode_output', $output, 'trx_call_to_action', $atts, $content);
	}
	lifecoach_require_shortcode('trx_call_to_action', 'lifecoach_sc_call_to_action');
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'lifecoach_sc_call_to_action_reg_shortcodes' ) ) {
	//add_action('lifecoach_action_shortcodes_list', 'lifecoach_sc_call_to_action_reg_shortcodes');
	function lifecoach_sc_call_to_action_reg_shortcodes() {
	
		lifecoach_sc_map("trx_call_to_action", array(
			"title" => esc_html__("Call to action", 'lifecoach'),
			"desc" => wp_kses_data( __("Insert call to action block in your page (post)", 'lifecoach') ),
			"decorate" => true,
			"container" => true,
			"params" => array(
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
				"style" => array(
					"title" => esc_html__("Style", 'lifecoach'),
					"desc" => wp_kses_data( __("Select style to display block", 'lifecoach') ),
					"value" => "1",
					"type" => "checklist",
					"options" => lifecoach_get_list_styles(1, 2)
				),
				"align" => array(
					"title" => esc_html__("Alignment", 'lifecoach'),
					"desc" => wp_kses_data( __("Alignment elements in the block", 'lifecoach') ),
					"value" => "",
					"type" => "checklist",
					"dir" => "horizontal",
					"options" => lifecoach_get_sc_param('align')
				),
				"accent" => array(
					"title" => esc_html__("Accented", 'lifecoach'),
					"desc" => wp_kses_data( __("Fill entire block with Accent1 color from current color scheme", 'lifecoach') ),
					"divider" => true,
					"value" => "no",
					"type" => "switch",
					"options" => lifecoach_get_sc_param('yes_no')
				),
				"custom" => array(
					"title" => esc_html__("Custom", 'lifecoach'),
					"desc" => wp_kses_data( __("Allow get featured image or video from inner shortcodes (custom) or get it from shortcode parameters below", 'lifecoach') ),
					"divider" => true,
					"value" => "no",
					"type" => "switch",
					"options" => lifecoach_get_sc_param('yes_no')
				),
				"image" => array(
					"title" => esc_html__("Image", 'lifecoach'),
					"desc" => wp_kses_data( __("Select or upload image or write URL from other site to include image into this block", 'lifecoach') ),
					"divider" => true,
					"readonly" => false,
					"value" => "",
					"type" => "media"
				),
				"video" => array(
					"title" => esc_html__("URL for video file", 'lifecoach'),
					"desc" => wp_kses_data( __("Select video from media library or paste URL for video file from other site to include video into this block", 'lifecoach') ),
					"readonly" => false,
					"value" => "",
					"type" => "media",
					"before" => array(
						'title' => esc_html__('Choose video', 'lifecoach'),
						'action' => 'media_upload',
						'type' => 'video',
						'multiple' => false,
						'linked_field' => '',
						'captions' => array( 	
							'choose' => esc_html__('Choose video file', 'lifecoach'),
							'update' => esc_html__('Select video file', 'lifecoach')
						)
					),
					"after" => array(
						'icon' => 'icon-cancel',
						'action' => 'media_reset'
					)
				),
				"link" => array(
					"title" => esc_html__("Button URL", 'lifecoach'),
					"desc" => wp_kses_data( __("Link URL for the button at the bottom of the block", 'lifecoach') ),
					"divider" => true,
					"value" => "",
					"type" => "text"
				),
				"link_caption" => array(
					"title" => esc_html__("Button caption", 'lifecoach'),
					"desc" => wp_kses_data( __("Caption for the button at the bottom of the block", 'lifecoach') ),
					"value" => "",
					"type" => "text"
				),
				"link2" => array(
					"title" => esc_html__("Button 2 URL", 'lifecoach'),
					"desc" => wp_kses_data( __("Link URL for the second button at the bottom of the block", 'lifecoach') ),
					"divider" => true,
					"value" => "",
					"type" => "text"
				),
				"link2_caption" => array(
					"title" => esc_html__("Button 2 caption", 'lifecoach'),
					"desc" => wp_kses_data( __("Caption for the second button at the bottom of the block", 'lifecoach') ),
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
if ( !function_exists( 'lifecoach_sc_call_to_action_reg_shortcodes_vc' ) ) {
	//add_action('lifecoach_action_shortcodes_list_vc', 'lifecoach_sc_call_to_action_reg_shortcodes_vc');
	function lifecoach_sc_call_to_action_reg_shortcodes_vc() {
	
		vc_map( array(
			"base" => "trx_call_to_action",
			"name" => esc_html__("Call to Action", 'lifecoach'),
			"description" => wp_kses_data( __("Insert call to action block in your page (post)", 'lifecoach') ),
			"category" => esc_html__('Content', 'lifecoach'),
			'icon' => 'icon_trx_call_to_action',
			"class" => "trx_sc_collection trx_sc_call_to_action",
			"content_element" => true,
			"is_container" => true,
			"show_settings_on_create" => true,
			"params" => array(
				array(
					"param_name" => "style",
					"heading" => esc_html__("Block's style", 'lifecoach'),
					"description" => wp_kses_data( __("Select style to display this block", 'lifecoach') ),
					"class" => "",
					"admin_label" => true,
					"value" => array_flip(lifecoach_get_list_styles(1, 2)),
					"type" => "dropdown"
				),
				array(
					"param_name" => "align",
					"heading" => esc_html__("Alignment", 'lifecoach'),
					"description" => wp_kses_data( __("Select block alignment", 'lifecoach') ),
					"class" => "",
					"value" => array_flip(lifecoach_get_sc_param('align')),
					"type" => "dropdown"
				),
				array(
					"param_name" => "accent",
					"heading" => esc_html__("Accent", 'lifecoach'),
					"description" => wp_kses_data( __("Fill entire block with Accent1 color from current color scheme", 'lifecoach') ),
					"class" => "",
					"value" => array("Fill with Accent1 color" => "yes" ),
					"type" => "checkbox"
				),
				array(
					"param_name" => "custom",
					"heading" => esc_html__("Custom", 'lifecoach'),
					"description" => wp_kses_data( __("Allow get featured image or video from inner shortcodes (custom) or get it from shortcode parameters below", 'lifecoach') ),
					"class" => "",
					"value" => array("Custom content" => "yes" ),
					"type" => "checkbox"
				),
				array(
					"param_name" => "image",
					"heading" => esc_html__("Image", 'lifecoach'),
					"description" => wp_kses_data( __("Image to display inside block", 'lifecoach') ),
					'dependency' => array(
						'element' => 'custom',
						'is_empty' => true
					),
					"admin_label" => true,
					"class" => "",
					"value" => "",
					"type" => "attach_image"
				),
				array(
					"param_name" => "video",
					"heading" => esc_html__("URL for video file", 'lifecoach'),
					"description" => wp_kses_data( __("Paste URL for video file to display inside block", 'lifecoach') ),
					'dependency' => array(
						'element' => 'custom',
						'is_empty' => true
					),
					"admin_label" => true,
					"class" => "",
					"value" => "",
					"type" => "textfield"
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
				array(
					"param_name" => "link2",
					"heading" => esc_html__("Button 2 URL", 'lifecoach'),
					"description" => wp_kses_data( __("Link URL for the second button at the bottom of the block", 'lifecoach') ),
					"group" => esc_html__('Captions', 'lifecoach'),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "link2_caption",
					"heading" => esc_html__("Button 2 caption", 'lifecoach'),
					"description" => wp_kses_data( __("Caption for the second button at the bottom of the block", 'lifecoach') ),
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
		
		class WPBakeryShortCode_Trx_Call_To_Action extends LIFECOACH_VC_ShortCodeCollection {}
	}
}
?>