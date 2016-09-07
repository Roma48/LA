<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('lifecoach_sc_blogger_theme_setup')) {
	add_action( 'lifecoach_action_before_init_theme', 'lifecoach_sc_blogger_theme_setup' );
	function lifecoach_sc_blogger_theme_setup() {
		add_action('lifecoach_action_shortcodes_list', 		'lifecoach_sc_blogger_reg_shortcodes');
		if (function_exists('lifecoach_exists_visual_composer') && lifecoach_exists_visual_composer())
			add_action('lifecoach_action_shortcodes_list_vc','lifecoach_sc_blogger_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_blogger id="unique_id" ids="comma_separated_list" cat="id|slug" orderby="date|views|comments" order="asc|desc" count="5" descr="0" dir="horizontal|vertical" style="regular|date|image_large|image_medium|image_small|accordion|list" border="0"]
*/
lifecoach_storage_set('sc_blogger_busy', false);

if (!function_exists('lifecoach_sc_blogger')) {	
	function lifecoach_sc_blogger($atts, $content=null){	
		if (lifecoach_in_shortcode_blogger(true)) return '';
		extract(lifecoach_html_decode(shortcode_atts(array(
			// Individual params
			"style" => "accordion",
			"filters" => "no",
			"post_type" => "post",
			"ids" => "",
			"cat" => "",
			"count" => "3",
			"columns" => "",
			"offset" => "",
			"orderby" => "date",
			"order" => "desc",
			"only" => "no",
			"descr" => "",
			"readmore" => "",
			"loadmore" => "no",
			"location" => "default",
			"dir" => "horizontal",
			"hover" => lifecoach_get_theme_option('hover_style'),
			"hover_dir" => lifecoach_get_theme_option('hover_dir'),
			"scroll" => "no",
			"controls" => "no",
			"rating" => "no",
			"info" => "yes",
			"links" => "yes",
			"date_format" => "",
			"title" => "",
			"subtitle" => "",
			"description" => "",
			"link" => '',
			"link_caption" => esc_html__('Learn more', 'lifecoach'),
			// Common params
			"id" => "",
			"class" => "",
			"css" => "",
			"animation" => "",
			"width" => "",
			"height" => "",
			"top" => "",
			"bottom" => "",
			"left" => "",
			"right" => ""
		), $atts)));
	
		$class .= ($class ? ' ' : '') . lifecoach_get_css_position_as_classes($top, $right, $bottom, $left);

		$css .= lifecoach_get_css_dimensions_from_values($width, $height);
		$width  = lifecoach_prepare_css_value($width);
		$height = lifecoach_prepare_css_value($height);
	
		global $post;
	
		lifecoach_storage_set('sc_blogger_busy', true);
		lifecoach_storage_set('sc_blogger_counter', 0);
	
		if (empty($id)) $id = "sc_blogger_".str_replace('.', '', mt_rand());
		
		if ($style=='date' && empty($date_format)) $date_format = 'd.m+Y';
	
		if (!empty($ids)) {
			$posts = explode(',', str_replace(' ', '', $ids));
			$count = count($posts);
		}
		
		if ($descr == '') $descr = lifecoach_get_custom_option('post_excerpt_maxlength'.($columns > 1 ? '_masonry' : ''));
	
		if (!lifecoach_param_is_off($scroll)) {
			lifecoach_enqueue_slider();
			if (empty($id)) $id = 'sc_blogger_'.str_replace('.', '', mt_rand());
		}
		
		$class = apply_filters('lifecoach_filter_blog_class',
					'sc_blogger'
					. ' layout_'.esc_attr($style)
					. ' template_'.esc_attr(lifecoach_get_template_name($style))
					. (!empty($class) ? ' '.esc_attr($class) : '')
					. ' ' . esc_attr(lifecoach_get_template_property($style, 'container_classes'))
					. ' sc_blogger_' . ($dir=='vertical' ? 'vertical' : 'horizontal')
					. (lifecoach_param_is_on($scroll) && lifecoach_param_is_on($controls) ? ' sc_scroll_controls sc_scroll_controls_type_top sc_scroll_controls_'.esc_attr($dir) : '')
					. ($descr == 0 ? ' no_description' : ''),
					array('style'=>$style, 'dir'=>$dir, 'descr'=>$descr)
		);
	
		$container = apply_filters('lifecoach_filter_blog_container', lifecoach_get_template_property($style, 'container'), array('style'=>$style, 'dir'=>$dir));
		$container_start = $container_end = '';
		if (!empty($container)) {
			$container = explode('%s', $container);
			$container_start = !empty($container[0]) ? $container[0] : '';
			$container_end = !empty($container[1]) ? $container[1] : '';
		}
		$container2 = apply_filters('lifecoach_filter_blog_container2', lifecoach_get_template_property($style, 'container2'), array('style'=>$style, 'dir'=>$dir));
		$container2_start = $container2_end = '';
		if (!empty($container2)) {
			$container2 = explode('%s', $container2);
			$container2_start = !empty($container2[0]) ? $container2[0] : '';
			//$container2_start = str_replace(array('%css'), array('style="height:'.esc_attr($height).'"'), $container2_start);
			$container2_end = !empty($container2[1]) ? $container2[1] : '';
		}
	
		$output = '<div'
				. ($id ? ' id="'.esc_attr($id).'"' : '') 
				. ' class="'.($style=='list' ? 'sc_list sc_list_style_iconed ' : '') . esc_attr($class).'"'
				. ($css!='' ? ' style="'.esc_attr($css).'"' : '')
				. (!lifecoach_param_is_off($animation) ? ' data-animation="'.esc_attr(lifecoach_get_animation_classes($animation)).'"' : '')
			. '>'
			. ($container_start)
			. (!empty($subtitle) ? '<h6 class="sc_blogger_subtitle sc_item_subtitle">' . trim(lifecoach_strmacros($subtitle)) . '</h6>' : '')
			. (!empty($title) ? '<h2 class="sc_blogger_title sc_item_title">' . trim(lifecoach_strmacros($title)) . '</h2>' : '')
			. (!empty($description) ? '<div class="sc_blogger_descr sc_item_descr">' . trim(lifecoach_strmacros($description)) . '</div>' : '')
			. ($container2_start)
			. ($style=='list' ? '<ul class="sc_list sc_list_style_iconed">' : '')
			. ($dir=='horizontal' && $columns > 1 && lifecoach_get_template_property($style, 'need_columns') ? '<div class="columns_wrap">' : '')
			. (lifecoach_param_is_on($scroll) 
				? '<div id="'.esc_attr($id).'_scroll" class="sc_scroll sc_scroll_'.esc_attr($dir).' sc_slider_noresize swiper-slider-container scroll-container"'
					. ' style="'.($dir=='vertical' ? 'height:'.($height != '' ? $height : "230px").';' : 'width:'.($width != '' ? $width.';' : "100%;")).'"'
					. '>'
					. '<div class="sc_scroll_wrapper swiper-wrapper">' 
						. '<div class="sc_scroll_slide swiper-slide">' 
				: '')
			;
	
		if (lifecoach_get_template_property($style, 'need_isotope')) {
			if (!lifecoach_param_is_off($filters))
				$output .= '<div class="isotope_filters"></div>';
			if ($columns<1) $columns = lifecoach_substr($style, -1);
			$output .= '<div class="isotope_wrap" data-columns="'.max(1, min(12, $columns)).'">';
		}
	
		$args = array(
			'post_status' => current_user_can('read_private_pages') && current_user_can('read_private_posts') ? array('publish', 'private') : 'publish',
			'posts_per_page' => $count,
			'ignore_sticky_posts' => true,
			'order' => $order=='asc' ? 'asc' : 'desc',
			'orderby' => 'date',
		);
	
		if ($offset > 0 && empty($ids)) {
			$args['offset'] = $offset;
		}
	
		$args = lifecoach_query_add_sort_order($args, $orderby, $order);
		if (!lifecoach_param_is_off($only)) $args = lifecoach_query_add_filters($args, $only);
		$args = lifecoach_query_add_posts_and_cats($args, $ids, $post_type, $cat);
	
		$query = new WP_Query( $args );
	
		$flt_ids = array();
	
		while ( $query->have_posts() ) { $query->the_post();
	
			lifecoach_storage_inc('sc_blogger_counter');
	
			$args = array(
				'layout' => $style,
				'show' => false,
				'number' => lifecoach_storage_get('sc_blogger_counter'),
				'add_view_more' => false,
				'posts_on_page' => ($count > 0 ? $count : $query->found_posts),
				// Additional options to layout generator
				"location" => $location,
				"descr" => $descr,
				"readmore" => $readmore,
				"loadmore" => $loadmore,
				"reviews" => lifecoach_param_is_on($rating),
				"dir" => $dir,
				"scroll" => lifecoach_param_is_on($scroll),
				"info" => lifecoach_param_is_on($info),
				"links" => lifecoach_param_is_on($links),
				"orderby" => $orderby,
				"columns_count" => $columns,
				"date_format" => $date_format,
				// Get post data
				'strip_teaser' => false,
				'content' => lifecoach_get_template_property($style, 'need_content'),
				'terms_list' => !lifecoach_param_is_off($filters) || lifecoach_get_template_property($style, 'need_terms'),
				'filters' => lifecoach_param_is_off($filters) ? '' : $filters,
				'hover' => $hover,
				'hover_dir' => $hover_dir
			);
			$post_data = lifecoach_get_post_data($args);
			$output .= lifecoach_show_post_layout($args, $post_data);
		
			if (!lifecoach_param_is_off($filters)) {
				if ($filters == 'tags') {			// Use tags as filter items
					if (!empty($post_data['post_terms'][$post_data['post_taxonomy_tags']]->terms) && is_array($post_data['post_terms'][$post_data['post_taxonomy_tags']]->terms)) {
						foreach ($post_data['post_terms'][$post_data['post_taxonomy_tags']]->terms as $tag) {
							$flt_ids[$tag->term_id] = $tag->name;
						}
					}
				}
			}
	
		}
	
		wp_reset_postdata();
	
		// Close isotope wrapper
		if (lifecoach_get_template_property($style, 'need_isotope'))
			$output .= '</div>';
	
		// Isotope filters list
		if (!lifecoach_param_is_off($filters)) {
			$filters_list = '';
			if ($filters == 'categories') {			// Use categories as filter items
				$taxonomy = lifecoach_get_taxonomy_categories_by_post_type($post_type);
				$portfolio_parent = $cat ? max(0, lifecoach_get_parent_taxonomy_by_property($cat, 'show_filters', 'yes', true, $taxonomy)) : 0;
				$args2 = array(
					'type'			=> $post_type,
					'child_of'		=> $portfolio_parent,
					'orderby'		=> 'name',
					'order'			=> 'ASC',
					'hide_empty'	=> 1,
					'hierarchical'	=> 0,
					'exclude'		=> '',
					'include'		=> '',
					'number'		=> '',
					'taxonomy'		=> $taxonomy,
					'pad_counts'	=> false
				);
				$portfolio_list = get_categories($args2);
				if (is_array($portfolio_list) && count($portfolio_list) > 0) {
					$filters_list .= '<a href="#" data-filter="*" class="theme_button active">'.esc_html__('All', 'lifecoach').'</a>';
					foreach ($portfolio_list as $cat) {
						$filters_list .= '<a href="#" data-filter=".flt_'.esc_attr($cat->term_id).'" class="theme_button">'.($cat->name).'</a>';
					}
				}
			} else {								// Use tags as filter items
				if (is_array($flt_ids) && count($flt_ids) > 0) {
					$filters_list .= '<a href="#" data-filter="*" class="theme_button active">'.esc_html__('All', 'lifecoach').'</a>';
					foreach ($flt_ids as $flt_id=>$flt_name) {
						$filters_list .= '<a href="#" data-filter=".flt_'.esc_attr($flt_id).'" class="theme_button">'.($flt_name).'</a>';
					}
				}
			}
			if ($filters_list) {
				$output .= '<script type="text/javascript">'
					. 'jQuery(document).ready(function () {'
						. 'jQuery("#'.esc_attr($id).' .isotope_filters").append("'.addslashes($filters_list).'");'
					. '});'
					. '</script>';
			}
		}
		$output	.= (lifecoach_param_is_on($scroll) 
				? '</div></div><div id="'.esc_attr($id).'_scroll_bar" class="sc_scroll_bar sc_scroll_bar_'.esc_attr($dir).' '.esc_attr($id).'_scroll_bar"></div></div>'
					. (!lifecoach_param_is_off($controls) ? '<div class="sc_scroll_controls_wrap"><a class="sc_scroll_prev" href="#"></a><a class="sc_scroll_next" href="#"></a></div>' : '')
				: '')
			. ($dir=='horizontal' && $columns > 1 && lifecoach_get_template_property($style, 'need_columns') ? '</div>' :  '')
			. ($style == 'list' ? '</ul>' : '')
			. ($container2_end)
			. (!empty($link) 
				? '<div class="sc_blogger_button sc_item_button">'.do_shortcode('[trx_button link="'.esc_url($link).'" icon="icon-right"]'.esc_html($link_caption).'[/trx_button]').'</div>' 				: '')
			. ($container_end)
			. '</div>';
	
		// Add template specific scripts and styles
		do_action('lifecoach_action_blog_scripts', $style);
		
		lifecoach_storage_set('sc_blogger_busy', false);
	
		return apply_filters('lifecoach_shortcode_output', $output, 'trx_blogger', $atts, $content);
	}
	lifecoach_require_shortcode('trx_blogger', 'lifecoach_sc_blogger');
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'lifecoach_sc_blogger_reg_shortcodes' ) ) {
	//add_action('lifecoach_action_shortcodes_list', 'lifecoach_sc_blogger_reg_shortcodes');
	function lifecoach_sc_blogger_reg_shortcodes() {
	
		lifecoach_sc_map("trx_blogger", array(
			"title" => esc_html__("Blogger", 'lifecoach'),
			"desc" => wp_kses_data( __("Insert posts (pages) in many styles from desired categories or directly from ids", 'lifecoach') ),
			"decorate" => false,
			"container" => false,
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
					"title" => esc_html__("Posts output style", 'lifecoach'),
					"desc" => wp_kses_data( __("Select desired style for posts output", 'lifecoach') ),
					"value" => "accordion",
					"type" => "select",
					"options" => lifecoach_get_sc_param('blogger_styles')
				),
				"filters" => array(
					"title" => esc_html__("Show filters", 'lifecoach'),
					"desc" => wp_kses_data( __("Use post's tags or categories as filter buttons", 'lifecoach') ),
					"value" => "no",
					"dir" => "horizontal",
					"type" => "checklist",
					"options" => lifecoach_get_sc_param('filters')
				),
				"hover" => array(
					"title" => esc_html__("Hover effect", 'lifecoach'),
					"desc" => wp_kses_data( __("Select hover effect (only if style=Portfolio)", 'lifecoach') ),
					"dependency" => array(
						'style' => array('portfolio','grid','square','short','colored')
					),
					"value" => "",
					"type" => "select",
					"options" => lifecoach_get_sc_param('hovers')
				),
				"hover_dir" => array(
					"title" => esc_html__("Hover direction", 'lifecoach'),
					"desc" => wp_kses_data( __("Select hover direction (only if style=Portfolio and hover=Circle|Square)", 'lifecoach') ),
					"dependency" => array(
						'style' => array('portfolio','grid','square','short','colored'),
						'hover' => array('square','circle')
					),
					"value" => "left_to_right",
					"type" => "select",
					"options" => lifecoach_get_sc_param('hovers_dir')
				),
				"dir" => array(
					"title" => esc_html__("Posts direction", 'lifecoach'),
					"desc" => wp_kses_data( __("Display posts in horizontal or vertical direction", 'lifecoach') ),
					"value" => "horizontal",
					"type" => "switch",
					"size" => "big",
					"options" => lifecoach_get_sc_param('dir')
				),
				"post_type" => array(
					"title" => esc_html__("Post type", 'lifecoach'),
					"desc" => wp_kses_data( __("Select post type to show", 'lifecoach') ),
					"value" => "post",
					"type" => "select",
					"options" => lifecoach_get_sc_param('posts_types')
				),
				"ids" => array(
					"title" => esc_html__("Post IDs list", 'lifecoach'),
					"desc" => wp_kses_data( __("Comma separated list of posts ID. If set - parameters above are ignored!", 'lifecoach') ),
					"value" => "",
					"type" => "text"
				),
				"cat" => array(
					"title" => esc_html__("Categories list", 'lifecoach'),
					"desc" => wp_kses_data( __("Select the desired categories. If not selected - show posts from any category or from IDs list", 'lifecoach') ),
					"dependency" => array(
						'ids' => array('is_empty'),
						'post_type' => array('refresh')
					),
					"divider" => true,
					"value" => "",
					"type" => "select",
					"style" => "list",
					"multiple" => true,
					"options" => lifecoach_array_merge(array(0 => esc_html__('- Select category -', 'lifecoach')), lifecoach_get_sc_param('categories'))
				),
				"count" => array(
					"title" => esc_html__("Total posts to show", 'lifecoach'),
					"desc" => wp_kses_data( __("How many posts will be displayed? If used IDs - this parameter ignored.", 'lifecoach') ),
					"dependency" => array(
						'ids' => array('is_empty')
					),
					"value" => 3,
					"min" => 1,
					"max" => 100,
					"type" => "spinner"
				),
				"columns" => array(
					"title" => esc_html__("Columns number", 'lifecoach'),
					"desc" => wp_kses_data( __("How many columns used to show posts? If empty or 0 - equal to posts number", 'lifecoach') ),
					"dependency" => array(
						'dir' => array('horizontal')
					),
					"value" => 3,
					"min" => 1,
					"max" => 100,
					"type" => "spinner"
				),
				"offset" => array(
					"title" => esc_html__("Offset before select posts", 'lifecoach'),
					"desc" => wp_kses_data( __("Skip posts before select next part.", 'lifecoach') ),
					"dependency" => array(
						'ids' => array('is_empty')
					),
					"value" => 0,
					"min" => 0,
					"max" => 100,
					"type" => "spinner"
				),
				"orderby" => array(
					"title" => esc_html__("Post order by", 'lifecoach'),
					"desc" => wp_kses_data( __("Select desired posts sorting method", 'lifecoach') ),
					"value" => "date",
					"type" => "select",
					"options" => lifecoach_get_sc_param('sorting')
				),
				"order" => array(
					"title" => esc_html__("Post order", 'lifecoach'),
					"desc" => wp_kses_data( __("Select desired posts order", 'lifecoach') ),
					"value" => "desc",
					"type" => "switch",
					"size" => "big",
					"options" => lifecoach_get_sc_param('ordering')
				),
				"only" => array(
					"title" => esc_html__("Select posts only", 'lifecoach'),
					"desc" => wp_kses_data( __("Select posts only with reviews, videos, audios, thumbs or galleries", 'lifecoach') ),
					"value" => "no",
					"type" => "select",
					"options" => lifecoach_get_sc_param('formats')
				),
				"scroll" => array(
					"title" => esc_html__("Use scroller", 'lifecoach'),
					"desc" => wp_kses_data( __("Use scroller to show all posts", 'lifecoach') ),
					"divider" => true,
					"value" => "no",
					"type" => "switch",
					"options" => lifecoach_get_sc_param('yes_no')
				),
				"controls" => array(
					"title" => esc_html__("Show slider controls", 'lifecoach'),
					"desc" => wp_kses_data( __("Show arrows to control scroll slider", 'lifecoach') ),
					"dependency" => array(
						'scroll' => array('yes')
					),
					"value" => "no",
					"type" => "switch",
					"options" => lifecoach_get_sc_param('yes_no')
				),
				"location" => array(
					"title" => esc_html__("Dedicated content location", 'lifecoach'),
					"desc" => wp_kses_data( __("Select position for dedicated content (only for style=excerpt)", 'lifecoach') ),
					"divider" => true,
					"dependency" => array(
						'style' => array('excerpt')
					),
					"value" => "default",
					"type" => "select",
					"options" => lifecoach_get_sc_param('locations')
				),
				"rating" => array(
					"title" => esc_html__("Show rating stars", 'lifecoach'),
					"desc" => wp_kses_data( __("Show rating stars under post's header", 'lifecoach') ),
					"value" => "no",
					"type" => "switch",
					"options" => lifecoach_get_sc_param('yes_no')
				),
				"info" => array(
					"title" => esc_html__("Show post info block", 'lifecoach'),
					"desc" => wp_kses_data( __("Show post info block (author, date, tags, etc.)", 'lifecoach') ),
					"value" => "no",
					"type" => "switch",
					"options" => lifecoach_get_sc_param('yes_no')
				),
				"links" => array(
					"title" => esc_html__("Allow links on the post", 'lifecoach'),
					"desc" => wp_kses_data( __("Allow links on the post from each blogger item", 'lifecoach') ),
					"value" => "yes",
					"type" => "switch",
					"options" => lifecoach_get_sc_param('yes_no')
				),
				"descr" => array(
					"title" => esc_html__("Description length", 'lifecoach'),
					"desc" => wp_kses_data( __("How many characters are displayed from post excerpt? If 0 - don't show description", 'lifecoach') ),
					"value" => 0,
					"min" => 0,
					"step" => 10,
					"type" => "spinner"
				),
				"readmore" => array(
					"title" => esc_html__("More link text", 'lifecoach'),
					"desc" => wp_kses_data( __("Read more link text. If empty - show 'More', else - used as link text", 'lifecoach') ),
					"value" => "",
					"type" => "text"
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
if ( !function_exists( 'lifecoach_sc_blogger_reg_shortcodes_vc' ) ) {
	//add_action('lifecoach_action_shortcodes_list_vc', 'lifecoach_sc_blogger_reg_shortcodes_vc');
	function lifecoach_sc_blogger_reg_shortcodes_vc() {

		vc_map( array(
			"base" => "trx_blogger",
			"name" => esc_html__("Blogger", 'lifecoach'),
			"description" => wp_kses_data( __("Insert posts (pages) in many styles from desired categories or directly from ids", 'lifecoach') ),
			"category" => esc_html__('Content', 'lifecoach'),
			'icon' => 'icon_trx_blogger',
			"class" => "trx_sc_single trx_sc_blogger",
			"content_element" => true,
			"is_container" => false,
			"show_settings_on_create" => true,
			"params" => array(
				array(
					"param_name" => "style",
					"heading" => esc_html__("Output style", 'lifecoach'),
					"description" => wp_kses_data( __("Select desired style for posts output", 'lifecoach') ),
					"admin_label" => true,
					"std" => "accordion",
					"class" => "",
					"value" => array_flip(lifecoach_get_sc_param('blogger_styles')),
					"type" => "dropdown"
				),
				array(
					"param_name" => "filters",
					"heading" => esc_html__("Show filters", 'lifecoach'),
					"description" => wp_kses_data( __("Use post's tags or categories as filter buttons", 'lifecoach') ),
					"admin_label" => true,
					"class" => "",
					"value" => array_flip(lifecoach_get_sc_param('filters')),
					"type" => "dropdown"
				),
				array(
					"param_name" => "hover",
					"heading" => esc_html__("Hover effect", 'lifecoach'),
					"description" => wp_kses_data( __("Select hover effect (only if style=Portfolio)", 'lifecoach') ),
					"class" => "",
					"value" => array_flip(lifecoach_get_sc_param('hovers')),
					'dependency' => array(
						'element' => 'style',
						'value' => array('portfolio_2','portfolio_3','portfolio_4','grid_2','grid_3','grid_4','square_2','square_3','square_4','short_2','short_3','short_4','colored_2','colored_3','colored_4')
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "hover_dir",
					"heading" => esc_html__("Hover direction", 'lifecoach'),
					"description" => wp_kses_data( __("Select hover direction (only if style=Portfolio and hover=Circle|Square)", 'lifecoach') ),
					"class" => "",
					"value" => array_flip(lifecoach_get_sc_param('hovers_dir')),
					'dependency' => array(
						'element' => 'style',
						'value' => array('portfolio_2','portfolio_3','portfolio_4','grid_2','grid_3','grid_4','square_2','square_3','square_4','short_2','short_3','short_4','colored_2','colored_3','colored_4')
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "location",
					"heading" => esc_html__("Dedicated content location", 'lifecoach'),
					"description" => wp_kses_data( __("Select position for dedicated content (only for style=excerpt)", 'lifecoach') ),
					"class" => "",
					'dependency' => array(
						'element' => 'style',
						'value' => array('excerpt')
					),
					"value" => array_flip(lifecoach_get_sc_param('locations')),
					"type" => "dropdown"
				),
				array(
					"param_name" => "dir",
					"heading" => esc_html__("Posts direction", 'lifecoach'),
					"description" => wp_kses_data( __("Display posts in horizontal or vertical direction", 'lifecoach') ),
					"admin_label" => true,
					"class" => "",
					"std" => "horizontal",
					"value" => array_flip(lifecoach_get_sc_param('dir')),
					"type" => "dropdown"
				),
				array(
					"param_name" => "columns",
					"heading" => esc_html__("Columns number", 'lifecoach'),
					"description" => wp_kses_data( __("How many columns used to display posts?", 'lifecoach') ),
					'dependency' => array(
						'element' => 'dir',
						'value' => 'horizontal'
					),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "rating",
					"heading" => esc_html__("Show rating stars", 'lifecoach'),
					"description" => wp_kses_data( __("Show rating stars under post's header", 'lifecoach') ),
					"group" => esc_html__('Details', 'lifecoach'),
					"class" => "",
					"value" => array(esc_html__('Show rating', 'lifecoach') => 'yes'),
					"type" => "checkbox"
				),
				array(
					"param_name" => "info",
					"heading" => esc_html__("Show post info block", 'lifecoach'),
					"description" => wp_kses_data( __("Show post info block (author, date, tags, etc.)", 'lifecoach') ),
					"class" => "",
					"std" => 'yes',
					"value" => array(esc_html__('Show info', 'lifecoach') => 'yes'),
					"type" => "checkbox"
				),
				array(
					"param_name" => "descr",
					"heading" => esc_html__("Description length", 'lifecoach'),
					"description" => wp_kses_data( __("How many characters are displayed from post excerpt? If 0 - don't show description", 'lifecoach') ),
					"group" => esc_html__('Details', 'lifecoach'),
					"class" => "",
					"value" => 0,
					"type" => "textfield"
				),
				array(
					"param_name" => "links",
					"heading" => esc_html__("Allow links to the post", 'lifecoach'),
					"description" => wp_kses_data( __("Allow links to the post from each blogger item", 'lifecoach') ),
					"group" => esc_html__('Details', 'lifecoach'),
					"class" => "",
					"std" => 'yes',
					"value" => array(esc_html__('Allow links', 'lifecoach') => 'yes'),
					"type" => "checkbox"
				),
				array(
					"param_name" => "readmore",
					"heading" => esc_html__("More link text", 'lifecoach'),
					"description" => wp_kses_data( __("Read more link text. If empty - show 'More', else - used as link text", 'lifecoach') ),
					"group" => esc_html__('Details', 'lifecoach'),
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
					"param_name" => "post_type",
					"heading" => esc_html__("Post type", 'lifecoach'),
					"description" => wp_kses_data( __("Select post type to show", 'lifecoach') ),
					"group" => esc_html__('Query', 'lifecoach'),
					"class" => "",
					"value" => array_flip(lifecoach_get_sc_param('posts_types')),
					"type" => "dropdown"
				),
				array(
					"param_name" => "ids",
					"heading" => esc_html__("Post IDs list", 'lifecoach'),
					"description" => wp_kses_data( __("Comma separated list of posts ID. If set - parameters above are ignored!", 'lifecoach') ),
					"group" => esc_html__('Query', 'lifecoach'),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "cat",
					"heading" => esc_html__("Categories list", 'lifecoach'),
					"description" => wp_kses_data( __("Select category. If empty - show posts from any category or from IDs list", 'lifecoach') ),
					'dependency' => array(
						'element' => 'ids',
						'is_empty' => true
					),
					"group" => esc_html__('Query', 'lifecoach'),
					"class" => "",
					"value" => array_flip(lifecoach_array_merge(array(0 => esc_html__('- Select category -', 'lifecoach')), lifecoach_get_sc_param('categories'))),
					"type" => "dropdown"
				),
				array(
					"param_name" => "count",
					"heading" => esc_html__("Total posts to show", 'lifecoach'),
					"description" => wp_kses_data( __("How many posts will be displayed? If used IDs - this parameter ignored.", 'lifecoach') ),
					'dependency' => array(
						'element' => 'ids',
						'is_empty' => true
					),
					"admin_label" => true,
					"group" => esc_html__('Query', 'lifecoach'),
					"class" => "",
					"value" => 3,
					"type" => "textfield"
				),
				array(
					"param_name" => "offset",
					"heading" => esc_html__("Offset before select posts", 'lifecoach'),
					"description" => wp_kses_data( __("Skip posts before select next part.", 'lifecoach') ),
					'dependency' => array(
						'element' => 'ids',
						'is_empty' => true
					),
					"group" => esc_html__('Query', 'lifecoach'),
					"class" => "",
					"value" => 0,
					"type" => "textfield"
				),
				array(
					"param_name" => "orderby",
					"heading" => esc_html__("Post order by", 'lifecoach'),
					"description" => wp_kses_data( __("Select desired posts sorting method", 'lifecoach') ),
					"class" => "",
					"group" => esc_html__('Query', 'lifecoach'),
					"value" => array_flip(lifecoach_get_sc_param('sorting')),
					"type" => "dropdown"
				),
				array(
					"param_name" => "order",
					"heading" => esc_html__("Post order", 'lifecoach'),
					"description" => wp_kses_data( __("Select desired posts order", 'lifecoach') ),
					"class" => "",
					"group" => esc_html__('Query', 'lifecoach'),
					"value" => array_flip(lifecoach_get_sc_param('ordering')),
					"type" => "dropdown"
				),
				array(
					"param_name" => "only",
					"heading" => esc_html__("Select posts only", 'lifecoach'),
					"description" => wp_kses_data( __("Select posts only with reviews, videos, audios, thumbs or galleries", 'lifecoach') ),
					"class" => "",
					"group" => esc_html__('Query', 'lifecoach'),
					"value" => array_flip(lifecoach_get_sc_param('formats')),
					"type" => "dropdown"
				),
				array(
					"param_name" => "scroll",
					"heading" => esc_html__("Use scroller", 'lifecoach'),
					"description" => wp_kses_data( __("Use scroller to show all posts", 'lifecoach') ),
					"group" => esc_html__('Scroll', 'lifecoach'),
					"class" => "",
					"value" => array(esc_html__('Use scroller', 'lifecoach') => 'yes'),
					"type" => "checkbox"
				),
				array(
					"param_name" => "controls",
					"heading" => esc_html__("Show slider controls", 'lifecoach'),
					"description" => wp_kses_data( __("Show arrows to control scroll slider", 'lifecoach') ),
					"group" => esc_html__('Scroll', 'lifecoach'),
					"class" => "",
					"value" => array(esc_html__('Show controls', 'lifecoach') => 'yes'),
					"type" => "checkbox"
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
		) );
		
		class WPBakeryShortCode_Trx_Blogger extends LIFECOACH_VC_ShortCodeSingle {}
	}
}
?>