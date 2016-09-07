<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('lifecoach_sc_price_block_theme_setup')) {
	add_action( 'lifecoach_action_before_init_theme', 'lifecoach_sc_price_block_theme_setup' );
	function lifecoach_sc_price_block_theme_setup() {
		add_action('lifecoach_action_shortcodes_list', 		'lifecoach_sc_price_block_reg_shortcodes');
		if (function_exists('lifecoach_exists_visual_composer') && lifecoach_exists_visual_composer())
			add_action('lifecoach_action_shortcodes_list_vc','lifecoach_sc_price_block_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

if (!function_exists('lifecoach_sc_price_block')) {	
	function lifecoach_sc_price_block($atts, $content=null){	
		if (lifecoach_in_shortcode_blogger()) return '';
		extract(lifecoach_html_decode(shortcode_atts(array(
			// Individual params
			"style" => 1,
			"title" => "",
			"link" => "",
			"link_text" => "",
            "popular" => "",
			"icon" => "",
			"money" => "",
			"currency" => "$",
			"period" => "",
			"align" => "",
			"scheme" => "",
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
		$output = '';
		$class .= ($class ? ' ' : '') . lifecoach_get_css_position_as_classes($top, $right, $bottom, $left);
		$css .= lifecoach_get_css_dimensions_from_values($width, $height);
		if ($money) $money = do_shortcode('[trx_price money="'.esc_attr($money).'" period="'.esc_attr($period).'"'.($currency ? ' currency="'.esc_attr($currency).'"' : '').']');
		$content = do_shortcode(lifecoach_sc_clear_around($content));
		$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
					. ' class="sc_price_block sc_price_block_style_'.max(1, min(3, $style))
						. (!empty($class) ? ' '.esc_attr($class) : '')
						. ($scheme && !lifecoach_param_is_off($scheme) && !lifecoach_param_is_inherit($scheme) ? ' scheme_'.esc_attr($scheme) : '') 
						. ($align && $align!='none' ? ' align'.esc_attr($align) : '')
                        . (!empty($popular) ? ' popular' : '')
						. '"'
					. ($css!='' ? ' style="'.esc_attr($css).'"' : '')
					. (!lifecoach_param_is_off($animation) ? ' data-animation="'.esc_attr(lifecoach_get_animation_classes($animation)).'"' : '')
					. '>'
				. (!empty($title) ? '<div class="sc_price_block_title"><span>'.($title).'</span></div>' : '')
				. '<div class="sc_price_block_money">'
					. (!empty($icon) ? '<div class="sc_price_block_icon '.esc_attr($icon).'"></div>' : '')
					. ($money)
				. '</div>'
				. (!empty($content) ? '<div class="sc_price_block_description">'.($content).'</div>' : '')
				. (!empty($link_text) ? '<div class="sc_price_block_link">'.do_shortcode('[trx_button style="border" link="'.($link ? esc_url($link) : '#').'"]'.($link_text).'[/trx_button]').'</div>' : '')
			. '</div>';
		return apply_filters('lifecoach_shortcode_output', $output, 'trx_price_block', $atts, $content);
	}
	lifecoach_require_shortcode('trx_price_block', 'lifecoach_sc_price_block');
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'lifecoach_sc_price_block_reg_shortcodes' ) ) {
	//add_action('lifecoach_action_shortcodes_list', 'lifecoach_sc_price_block_reg_shortcodes');
	function lifecoach_sc_price_block_reg_shortcodes() {
	
		lifecoach_sc_map("trx_price_block", array(
			"title" => esc_html__("Price block", 'lifecoach'),
			"desc" => wp_kses_data( __("Insert price block with title, price and description", 'lifecoach') ),
			"decorate" => false,
			"container" => true,
			"params" => array(
				"style" => array(
					"title" => esc_html__("Block style", 'lifecoach'),
					"desc" => wp_kses_data( __("Select style for this price block", 'lifecoach') ),
					"value" => 1,
					"options" => lifecoach_get_list_styles(1, 3),
					"type" => "checklist"
				),
				"title" => array(
					"title" => esc_html__("Title", 'lifecoach'),
					"desc" => wp_kses_data( __("Block title", 'lifecoach') ),
					"value" => "",
					"type" => "text"
				),
				"link" => array(
					"title" => esc_html__("Link URL", 'lifecoach'),
					"desc" => wp_kses_data( __("URL for link from button (at bottom of the block)", 'lifecoach') ),
					"value" => "",
					"type" => "text"
				),
				"link_text" => array(
					"title" => esc_html__("Link text", 'lifecoach'),
					"desc" => wp_kses_data( __("Text (caption) for the link button (at bottom of the block). If empty - button not showed", 'lifecoach') ),
					"value" => "",
					"type" => "text"
				),
                "popular" => array(
                    "title" => esc_html__("Popular", 'lifecoach'),
                    "desc" => wp_kses_data( __("Display popular label", 'lifecoach') ),
                    "value" => "off",
                    "type" => "switch",
                    "options" => lifecoach_get_sc_param('on_off')
                ),
				"icon" => array(
					"title" => esc_html__("Icon",  'lifecoach'),
					"desc" => wp_kses_data( __('Select icon from Fontello icons set (placed before/instead price)',  'lifecoach') ),
					"value" => "",
					"type" => "icons",
					"options" => lifecoach_get_sc_param('icons')
				),
				"money" => array(
					"title" => esc_html__("Money", 'lifecoach'),
					"desc" => wp_kses_data( __("Money value (dot or comma separated)", 'lifecoach') ),
					"divider" => true,
					"value" => "",
					"type" => "text"
				),
				"currency" => array(
					"title" => esc_html__("Currency", 'lifecoach'),
					"desc" => wp_kses_data( __("Currency character", 'lifecoach') ),
					"value" => "$",
					"type" => "text"
				),
				"period" => array(
					"title" => esc_html__("Period", 'lifecoach'),
					"desc" => wp_kses_data( __("Period text (if need). For example: monthly, daily, etc.", 'lifecoach') ),
					"value" => "",
					"type" => "text"
				),
				"scheme" => array(
					"title" => esc_html__("Color scheme", 'lifecoach'),
					"desc" => wp_kses_data( __("Select color scheme for this block", 'lifecoach') ),
					"value" => "",
					"type" => "checklist",
					"options" => lifecoach_get_sc_param('schemes')
				),
				"align" => array(
					"title" => esc_html__("Alignment", 'lifecoach'),
					"desc" => wp_kses_data( __("Align price to left or right side", 'lifecoach') ),
					"divider" => true,
					"value" => "",
					"type" => "checklist",
					"dir" => "horizontal",
					"options" => lifecoach_get_sc_param('float')
				), 
				"_content_" => array(
					"title" => esc_html__("Description", 'lifecoach'),
					"desc" => wp_kses_data( __("Description for this price block", 'lifecoach') ),
					"divider" => true,
					"rows" => 4,
					"value" => "",
					"type" => "textarea"
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
if ( !function_exists( 'lifecoach_sc_price_block_reg_shortcodes_vc' ) ) {
	//add_action('lifecoach_action_shortcodes_list_vc', 'lifecoach_sc_price_block_reg_shortcodes_vc');
	function lifecoach_sc_price_block_reg_shortcodes_vc() {
	
		vc_map( array(
			"base" => "trx_price_block",
			"name" => esc_html__("Price block", 'lifecoach'),
			"description" => wp_kses_data( __("Insert price block with title, price and description", 'lifecoach') ),
			"category" => esc_html__('Content', 'lifecoach'),
			'icon' => 'icon_trx_price_block',
			"class" => "trx_sc_single trx_sc_price_block",
			"content_element" => true,
			"is_container" => false,
			"show_settings_on_create" => true,
			"params" => array(
				array(
					"param_name" => "style",
					"heading" => esc_html__("Block style", 'lifecoach'),
					"desc" => wp_kses_data( __("Select style of this price block", 'lifecoach') ),
					"admin_label" => true,
					"class" => "",
					"std" => 1,
					"value" => array_flip(lifecoach_get_list_styles(1, 3)),
					"type" => "dropdown"
				),
				array(
					"param_name" => "title",
					"heading" => esc_html__("Title", 'lifecoach'),
					"description" => wp_kses_data( __("Block title", 'lifecoach') ),
					"admin_label" => true,
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "link",
					"heading" => esc_html__("Link URL", 'lifecoach'),
					"description" => wp_kses_data( __("URL for link from button (at bottom of the block)", 'lifecoach') ),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "link_text",
					"heading" => esc_html__("Link text", 'lifecoach'),
					"description" => wp_kses_data( __("Text (caption) for the link button (at bottom of the block). If empty - button not showed", 'lifecoach') ),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
                array(
                    "param_name" => "popular",
                    "heading" => esc_html__("Popular", 'lifecoach'),
                    "description" => wp_kses_data( __("Display popular lable", 'lifecoach') ),
                    "class" => "",
                    "value" => array("Popular" => "off" ),
                    "type" => "checkbox"
                ),
				array(
					"param_name" => "icon",
					"heading" => esc_html__("Icon", 'lifecoach'),
					"description" => wp_kses_data( __("Select icon from Fontello icons set (placed before/instead price)", 'lifecoach') ),
					"class" => "",
					"value" => lifecoach_get_sc_param('icons'),
					"type" => "dropdown"
				),
				array(
					"param_name" => "money",
					"heading" => esc_html__("Money", 'lifecoach'),
					"description" => wp_kses_data( __("Money value (dot or comma separated)", 'lifecoach') ),
					"admin_label" => true,
					"group" => esc_html__('Money', 'lifecoach'),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "currency",
					"heading" => esc_html__("Currency symbol", 'lifecoach'),
					"description" => wp_kses_data( __("Currency character", 'lifecoach') ),
					"admin_label" => true,
					"group" => esc_html__('Money', 'lifecoach'),
					"class" => "",
					"value" => "$",
					"type" => "textfield"
				),
				array(
					"param_name" => "period",
					"heading" => esc_html__("Period", 'lifecoach'),
					"description" => wp_kses_data( __("Period text (if need). For example: monthly, daily, etc.", 'lifecoach') ),
					"admin_label" => true,
					"group" => esc_html__('Money', 'lifecoach'),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "scheme",
					"heading" => esc_html__("Color scheme", 'lifecoach'),
					"description" => wp_kses_data( __("Select color scheme for this block", 'lifecoach') ),
					"group" => esc_html__('Colors and Images', 'lifecoach'),
					"class" => "",
					"value" => array_flip(lifecoach_get_sc_param('schemes')),
					"type" => "dropdown"
				),
				array(
					"param_name" => "align",
					"heading" => esc_html__("Alignment", 'lifecoach'),
					"description" => wp_kses_data( __("Align price to left or right side", 'lifecoach') ),
					"admin_label" => true,
					"class" => "",
					"value" => array_flip(lifecoach_get_sc_param('float')),
					"type" => "dropdown"
				),
				array(
					"param_name" => "content",
					"heading" => esc_html__("Description", 'lifecoach'),
					"description" => wp_kses_data( __("Description for this price block", 'lifecoach') ),
					"class" => "",
					"value" => "",
					"type" => "textarea_html"
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
			),
			'js_view' => 'VcTrxTextView'
		) );
		
		class WPBakeryShortCode_Trx_PriceBlock extends LIFECOACH_VC_ShortCodeSingle {}
	}
}
?>