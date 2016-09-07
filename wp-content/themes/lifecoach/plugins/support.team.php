<?php
/**
 * LifeCoach Framework: Team support
 *
 * @package	lifecoach
 * @since	lifecoach 1.0
 */

// Theme init
if (!function_exists('lifecoach_team_theme_setup')) {
	add_action( 'lifecoach_action_before_init_theme', 'lifecoach_team_theme_setup', 1 );
	function lifecoach_team_theme_setup() {

		// Add item in the admin menu
		add_action('add_meta_boxes',						'lifecoach_team_add_meta_box');

		// Save data from meta box
		add_action('save_post',								'lifecoach_team_save_data');
		
		// Detect current page type, taxonomy and title (for custom post_types use priority < 10 to fire it handles early, than for standard post types)
		add_filter('lifecoach_filter_get_blog_type',			'lifecoach_team_get_blog_type', 9, 2);
		add_filter('lifecoach_filter_get_blog_title',		'lifecoach_team_get_blog_title', 9, 2);
		add_filter('lifecoach_filter_get_current_taxonomy',	'lifecoach_team_get_current_taxonomy', 9, 2);
		add_filter('lifecoach_filter_is_taxonomy',			'lifecoach_team_is_taxonomy', 9, 2);
		add_filter('lifecoach_filter_get_stream_page_title',	'lifecoach_team_get_stream_page_title', 9, 2);
		add_filter('lifecoach_filter_get_stream_page_link',	'lifecoach_team_get_stream_page_link', 9, 2);
		add_filter('lifecoach_filter_get_stream_page_id',	'lifecoach_team_get_stream_page_id', 9, 2);
		add_filter('lifecoach_filter_query_add_filters',		'lifecoach_team_query_add_filters', 9, 2);
		add_filter('lifecoach_filter_detect_inheritance_key','lifecoach_team_detect_inheritance_key', 9, 1);

		// Extra column for team members lists
		if (lifecoach_get_theme_option('show_overriden_posts')=='yes') {
			add_filter('manage_edit-team_columns',			'lifecoach_post_add_options_column', 9);
			add_filter('manage_team_posts_custom_column',	'lifecoach_post_fill_options_column', 9, 2);
		}

		// Register shortcodes [trx_team] and [trx_team_item]
		add_action('lifecoach_action_shortcodes_list',		'lifecoach_team_reg_shortcodes');
		if (function_exists('lifecoach_exists_visual_composer') && lifecoach_exists_visual_composer())
			add_action('lifecoach_action_shortcodes_list_vc','lifecoach_team_reg_shortcodes_vc');

		// Meta box fields
		lifecoach_storage_set('team_meta_box', array(
			'id' => 'team-meta-box',
			'title' => esc_html__('Team Member Details', 'lifecoach'),
			'page' => 'team',
			'context' => 'normal',
			'priority' => 'high',
			'fields' => array(
				"team_member_position" => array(
					"title" => esc_html__('Position',  'lifecoach'),
					"desc" => wp_kses_data( __("Position of the team member", 'lifecoach') ),
					"class" => "team_member_position",
					"std" => "",
					"type" => "text"),
				"team_member_email" => array(
					"title" => esc_html__("E-mail",  'lifecoach'),
					"desc" => wp_kses_data( __("E-mail of the team member - need to take Gravatar (if registered)", 'lifecoach') ),
					"class" => "team_member_email",
					"std" => "",
					"type" => "text"),
				"team_member_link" => array(
					"title" => esc_html__('Link to profile',  'lifecoach'),
					"desc" => wp_kses_data( __("URL of the team member profile page (if not this page)", 'lifecoach') ),
					"class" => "team_member_link",
					"std" => "",
					"type" => "text"),
				"team_member_socials" => array(
					"title" => esc_html__("Social links",  'lifecoach'),
					"desc" => wp_kses_data( __("Links to the social profiles of the team member", 'lifecoach') ),
					"class" => "team_member_email",
					"std" => "",
					"type" => "social")
				)
			)
		);
		
		// Add supported data types
		lifecoach_theme_support_pt('team');
		lifecoach_theme_support_tx('team_group');
	}
}

if ( !function_exists( 'lifecoach_team_settings_theme_setup2' ) ) {
	add_action( 'lifecoach_action_before_init_theme', 'lifecoach_team_settings_theme_setup2', 3 );
	function lifecoach_team_settings_theme_setup2() {
		// Add post type 'team' and taxonomy 'team_group' into theme inheritance list
		lifecoach_add_theme_inheritance( array('team' => array(
			'stream_template' => 'blog-team',
			'single_template' => 'single-team',
			'taxonomy' => array('team_group'),
			'taxonomy_tags' => array(),
			'post_type' => array('team'),
			'override' => 'custom'
			) )
		);
	}
}


// Add meta box
if (!function_exists('lifecoach_team_add_meta_box')) {
	//add_action('add_meta_boxes', 'lifecoach_team_add_meta_box');
	function lifecoach_team_add_meta_box() {
		$mb = lifecoach_storage_get('team_meta_box');
		add_meta_box($mb['id'], $mb['title'], 'lifecoach_team_show_meta_box', $mb['page'], $mb['context'], $mb['priority']);
	}
}

// Callback function to show fields in meta box
if (!function_exists('lifecoach_team_show_meta_box')) {
	function lifecoach_team_show_meta_box() {
		global $post;

		$data = get_post_meta($post->ID, 'lifecoach_team_data', true);
		$fields = lifecoach_storage_get_array('team_meta_box', 'fields');
		?>
		<input type="hidden" name="meta_box_team_nonce" value="<?php echo esc_attr(wp_create_nonce(admin_url())); ?>" />
		<table class="team_area">
		<?php
		if (is_array($fields) && count($fields) > 0) {
			foreach ($fields as $id=>$field) { 
				$meta = isset($data[$id]) ? $data[$id] : '';
				?>
				<tr class="team_field <?php echo esc_attr($field['class']); ?>" valign="top">
					<td><label for="<?php echo esc_attr($id); ?>"><?php echo esc_attr($field['title']); ?></label></td>
					<td>
						<?php
						if ($id == 'team_member_socials') {
							$socials_type = lifecoach_get_theme_setting('socials_type');
							$social_list = lifecoach_get_theme_option('social_icons');
							if (is_array($social_list) && count($social_list) > 0) {
								foreach ($social_list as $soc) {
									if ($socials_type == 'icons') {
										$parts = explode('-', $soc['icon'], 2);
										$sn = isset($parts[1]) ? $parts[1] : $soc['icon'];
									} else {
										$sn = basename($soc['icon']);
										$sn = lifecoach_substr($sn, 0, lifecoach_strrpos($sn, '.'));
										if (($pos=lifecoach_strrpos($sn, '_'))!==false)
											$sn = lifecoach_substr($sn, 0, $pos);
									}   
									$link = isset($meta[$sn]) ? $meta[$sn] : '';
									?>
									<label for="<?php echo esc_attr(($id).'_'.($sn)); ?>"><?php echo esc_attr(lifecoach_strtoproper($sn)); ?></label><br>
									<input type="text" name="<?php echo esc_attr($id); ?>[<?php echo esc_attr($sn); ?>]" id="<?php echo esc_attr(($id).'_'.($sn)); ?>" value="<?php echo esc_attr($link); ?>" size="30" /><br>
									<?php
								}
							}
						} else {
							?>
							<input type="text" name="<?php echo esc_attr($id); ?>" id="<?php echo esc_attr($id); ?>" value="<?php echo esc_attr($meta); ?>" size="30" />
							<?php
						}
						?>
						<br><small><?php echo esc_attr($field['desc']); ?></small>
					</td>
				</tr>
				<?php
			}
		}
		?>
		</table>
		<?php
	}
}


// Save data from meta box
if (!function_exists('lifecoach_team_save_data')) {
	//add_action('save_post', 'lifecoach_team_save_data');
	function lifecoach_team_save_data($post_id) {
		// verify nonce
		if ( !wp_verify_nonce( lifecoach_get_value_gp('meta_box_team_nonce'), admin_url() ) )
			return $post_id;

		// check autosave
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return $post_id;
		}

		// check permissions
		if ($_POST['post_type']!='team' || !current_user_can('edit_post', $post_id)) {
			return $post_id;
		}

		$data = array();

		$fields = lifecoach_storage_get_array('team_meta_box', 'fields');

		// Post type specific data handling
		if (is_array($fields) && count($fields) > 0) {
			foreach ($fields as $id=>$field) {
				if (isset($_POST[$id])) {
					if (is_array($_POST[$id]) && count($_POST[$id]) > 0) {
						foreach ($_POST[$id] as $sn=>$link) {
							$_POST[$id][$sn] = stripslashes($link);
						}
						$data[$id] = $_POST[$id];
					} else {
						$data[$id] = stripslashes($_POST[$id]);
					}
				}
			}
		}

		update_post_meta($post_id, 'lifecoach_team_data', $data);
	}
}



// Return true, if current page is team member page
if ( !function_exists( 'lifecoach_is_team_page' ) ) {
	function lifecoach_is_team_page() {
		$is = in_array(lifecoach_storage_get('page_template'), array('blog-team', 'single-team'));
		if (!$is) {
			if (!lifecoach_storage_empty('pre_query'))
				$is = lifecoach_storage_call_obj_method('pre_query', 'get', 'post_type')=='team' 
						|| lifecoach_storage_call_obj_method('pre_query', 'is_tax', 'team_group') 
						|| (lifecoach_storage_call_obj_method('pre_query', 'is_page') 
								&& ($id=lifecoach_get_template_page_id('blog-team')) > 0 
								&& $id==lifecoach_storage_get_obj_property('pre_query', 'queried_object_id', 0)
							);
			else
				$is = get_query_var('post_type')=='team' || is_tax('team_group') || (is_page() && ($id=lifecoach_get_template_page_id('blog-team')) > 0 && $id==get_the_ID());
		}
		return $is;
	}
}

// Filter to detect current page inheritance key
if ( !function_exists( 'lifecoach_team_detect_inheritance_key' ) ) {
	//add_filter('lifecoach_filter_detect_inheritance_key',	'lifecoach_team_detect_inheritance_key', 9, 1);
	function lifecoach_team_detect_inheritance_key($key) {
		if (!empty($key)) return $key;
		return lifecoach_is_team_page() ? 'team' : '';
	}
}

// Filter to detect current page slug
if ( !function_exists( 'lifecoach_team_get_blog_type' ) ) {
	//add_filter('lifecoach_filter_get_blog_type',	'lifecoach_team_get_blog_type', 9, 2);
	function lifecoach_team_get_blog_type($page, $query=null) {
		if (!empty($page)) return $page;
		if ($query && $query->is_tax('team_group') || is_tax('team_group'))
			$page = 'team_category';
		else if ($query && $query->get('post_type')=='team' || get_query_var('post_type')=='team')
			$page = $query && $query->is_single() || is_single() ? 'team_item' : 'team';
		return $page;
	}
}

// Filter to detect current page title
if ( !function_exists( 'lifecoach_team_get_blog_title' ) ) {
	//add_filter('lifecoach_filter_get_blog_title',	'lifecoach_team_get_blog_title', 9, 2);
	function lifecoach_team_get_blog_title($title, $page) {
		if (!empty($title)) return $title;
		if ( lifecoach_strpos($page, 'team')!==false ) {
			if ( $page == 'team_category' ) {
				$term = get_term_by( 'slug', get_query_var( 'team_group' ), 'team_group', OBJECT);
				$title = $term->name;
			} else if ( $page == 'team_item' ) {
				$title = lifecoach_get_post_title();
			} else {
				$title = esc_html__('All team', 'lifecoach');
			}
		}

		return $title;
	}
}

// Filter to detect stream page title
if ( !function_exists( 'lifecoach_team_get_stream_page_title' ) ) {
	//add_filter('lifecoach_filter_get_stream_page_title',	'lifecoach_team_get_stream_page_title', 9, 2);
	function lifecoach_team_get_stream_page_title($title, $page) {
		if (!empty($title)) return $title;
		if (lifecoach_strpos($page, 'team')!==false) {
			if (($page_id = lifecoach_team_get_stream_page_id(0, $page=='team' ? 'blog-team' : $page)) > 0)
				$title = lifecoach_get_post_title($page_id);
			else
				$title = esc_html__('All team', 'lifecoach');				
		}
		return $title;
	}
}

// Filter to detect stream page ID
if ( !function_exists( 'lifecoach_team_get_stream_page_id' ) ) {
	//add_filter('lifecoach_filter_get_stream_page_id',	'lifecoach_team_get_stream_page_id', 9, 2);
	function lifecoach_team_get_stream_page_id($id, $page) {
		if (!empty($id)) return $id;
		if (lifecoach_strpos($page, 'team')!==false) $id = lifecoach_get_template_page_id('blog-team');
		return $id;
	}
}

// Filter to detect stream page URL
if ( !function_exists( 'lifecoach_team_get_stream_page_link' ) ) {
	//add_filter('lifecoach_filter_get_stream_page_link',	'lifecoach_team_get_stream_page_link', 9, 2);
	function lifecoach_team_get_stream_page_link($url, $page) {
		if (!empty($url)) return $url;
		if (lifecoach_strpos($page, 'team')!==false) {
			$id = lifecoach_get_template_page_id('blog-team');
			if ($id) $url = get_permalink($id);
		}
		return $url;
	}
}

// Filter to detect current taxonomy
if ( !function_exists( 'lifecoach_team_get_current_taxonomy' ) ) {
	//add_filter('lifecoach_filter_get_current_taxonomy',	'lifecoach_team_get_current_taxonomy', 9, 2);
	function lifecoach_team_get_current_taxonomy($tax, $page) {
		if (!empty($tax)) return $tax;
		if ( lifecoach_strpos($page, 'team')!==false ) {
			$tax = 'team_group';
		}
		return $tax;
	}
}

// Return taxonomy name (slug) if current page is this taxonomy page
if ( !function_exists( 'lifecoach_team_is_taxonomy' ) ) {
	//add_filter('lifecoach_filter_is_taxonomy',	'lifecoach_team_is_taxonomy', 9, 2);
	function lifecoach_team_is_taxonomy($tax, $query=null) {
		if (!empty($tax))
			return $tax;
		else 
			return $query && $query->get('team_group')!='' || is_tax('team_group') ? 'team_group' : '';
	}
}

// Add custom post type and/or taxonomies arguments to the query
if ( !function_exists( 'lifecoach_team_query_add_filters' ) ) {
	//add_filter('lifecoach_filter_query_add_filters',	'lifecoach_team_query_add_filters', 9, 2);
	function lifecoach_team_query_add_filters($args, $filter) {
		if ($filter == 'team') {
			$args['post_type'] = 'team';
		}
		return $args;
	}
}





// ---------------------------------- [trx_team] ---------------------------------------

/*
[trx_team id="unique_id" columns="3" style="team-1|team-2|..."]
	[trx_team_item user="user_login"]
	[trx_team_item member="member_id"]
	[trx_team_item name="team member name" photo="url" email="address" position="director"]
[/trx_team]
*/
if ( !function_exists( 'lifecoach_sc_team' ) ) {
	function lifecoach_sc_team($atts, $content=null){	
		if (lifecoach_in_shortcode_blogger()) return '';
		extract(lifecoach_html_decode(shortcode_atts(array(
			// Individual params
			"style" => "team-1",
			"slider" => "no",
			"controls" => "no",
			"slides_space" => 0,
			"interval" => "",
			"autoheight" => "no",
			"align" => "",
			"custom" => "no",
			"ids" => "",
			"cat" => "",
			"count" => 3,
			"columns" => 3,
			"offset" => "",
			"orderby" => "title",
			"order" => "asc",
			"title" => "",
			"subtitle" => "",
			"description" => "",
			"link_caption" => esc_html__('Learn more', 'lifecoach'),
			"link" => '',
			"scheme" => '',
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

		if (empty($id)) $id = "sc_team_".str_replace('.', '', mt_rand());
		if (empty($width)) $width = "100%";
		if (!empty($height) && lifecoach_param_is_on($autoheight)) $autoheight = "no";
		if (empty($interval)) $interval = mt_rand(5000, 10000);

		$class .= ($class ? ' ' : '') . lifecoach_get_css_position_as_classes($top, $right, $bottom, $left);

		$ws = lifecoach_get_css_dimensions_from_values($width);
		$hs = lifecoach_get_css_dimensions_from_values('', $height);
		$css .= ($hs) . ($ws);

		$count = max(1, (int) $count);
		$columns = max(1, min(12, (int) $columns));
		if (lifecoach_param_is_off($custom) && $count < $columns) $columns = $count;

		lifecoach_storage_set('sc_team_data', array(
			'id' => $id,
            'style' => $style,
            'columns' => $columns,
            'counter' => 0,
            'slider' => $slider,
            'css_wh' => $ws . $hs
            )
        );

		if (lifecoach_param_is_on($slider)) lifecoach_enqueue_slider('swiper');
	
		$output = '<div' . ($id ? ' id="'.esc_attr($id).'_wrap"' : '') 
						. ' class="sc_team_wrap'
						. ($scheme && !lifecoach_param_is_off($scheme) && !lifecoach_param_is_inherit($scheme) ? ' scheme_'.esc_attr($scheme) : '') 
						.'">'
					. '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
						. ' class="sc_team sc_team_style_'.esc_attr($style)
							. ' ' . esc_attr(lifecoach_get_template_property($style, 'container_classes'))
							. (lifecoach_param_is_on($slider)
								? 
								: '')
							. (!empty($class) ? ' '.esc_attr($class) : '')
							. ($align!='' && $align!='none' ? ' align'.esc_attr($align) : '')
						.'"'
						. ($css!='' ? ' style="'.esc_attr($css).'"' : '') 
						. (!lifecoach_param_is_off($animation) ? ' data-animation="'.esc_attr(lifecoach_get_animation_classes($animation)).'"' : '')
					. '>'
					. (!empty($subtitle) ? '<h6 class="sc_team_subtitle sc_item_subtitle">' . trim(lifecoach_strmacros($subtitle)) . '</h6>' : '')
					. (!empty($title) ? '<h2 class="sc_team_title sc_item_title">' . trim(lifecoach_strmacros($title)) . '</h2>' : '')
					. (!empty($description) ? '<div class="sc_team_descr sc_item_descr">' . trim(lifecoach_strmacros($description)) . '</div>' : '')
					. (lifecoach_param_is_on($slider) 
						? ('<div class="sc_slider_swiper swiper-slider-container'
										. ' ' . esc_attr(lifecoach_get_slider_controls_classes($controls))
										. (lifecoach_param_is_on($autoheight) ? ' sc_slider_height_auto' : '')
										. ($hs ? ' sc_slider_height_fixed' : '')
										. '"'
									. (!empty($width) && lifecoach_strpos($width, '%')===false ? ' data-old-width="' . esc_attr($width) . '"' : '')
									. (!empty($height) && lifecoach_strpos($height, '%')===false ? ' data-old-height="' . esc_attr($height) . '"' : '')
									. ((int) $interval > 0 ? ' data-interval="'.esc_attr($interval).'"' : '')
									. ($slides_space > 0 ? ' data-slides-space="' . esc_attr($slides_space) . '"' : '')
									. ($columns > 1 ? ' data-slides-per-view="' . esc_attr($columns) . '"' : '')
									. ' data-slides-min-width="250"'
								. '>'
							. '<div class="slides swiper-wrapper">')
						: ($columns > 1 // && lifecoach_get_template_property($style, 'need_columns')
							? '<div class="sc_columns columns_wrap">' 
							: '')
						);
	
		$content = do_shortcode($content);
	
		if (lifecoach_param_is_on($custom) && $content) {
			$output .= $content;
		} else {
			global $post;
	
			if (!empty($ids)) {
				$posts = explode(',', $ids);
				$count = count($posts);
			}
			
			$args = array(
				'post_type' => 'team',
				'post_status' => 'publish',
				'posts_per_page' => $count,
				'ignore_sticky_posts' => true,
				'order' => $order=='asc' ? 'asc' : 'desc',
			);
		
			if ($offset > 0 && empty($ids)) {
				$args['offset'] = $offset;
			}
		
			$args = lifecoach_query_add_sort_order($args, $orderby, $order);
			$args = lifecoach_query_add_posts_and_cats($args, $ids, 'team', $cat, 'team_group');
			$query = new WP_Query( $args );
	
			$post_number = 0;
				
			while ( $query->have_posts() ) { 
				$query->the_post();
				$post_number++;
				$args = array(
					'layout' => $style,
					'show' => false,
					'number' => $post_number,
					'posts_on_page' => ($count > 0 ? $count : $query->found_posts),
					"descr" => lifecoach_get_custom_option('post_excerpt_maxlength'.($columns > 1 ? '_masonry' : '')),
					"orderby" => $orderby,
					'content' => false,
					'terms_list' => false,
					"columns_count" => $columns,
					'slider' => $slider,
					'tag_id' => $id ? $id . '_' . $post_number : '',
					'tag_class' => '',
					'tag_animation' => '',
					'tag_css' => '',
					'tag_css_wh' => $ws . $hs
				);
				$post_data = lifecoach_get_post_data($args);
				$post_meta = get_post_meta($post_data['post_id'], 'lifecoach_team_data', true);
				$thumb_sizes = lifecoach_get_thumb_sizes(array('layout' => $style));
				$args['position'] = $post_meta['team_member_position'];
				$args['link'] = !empty($post_meta['team_member_link']) ? $post_meta['team_member_link'] : $post_data['post_link'];
				$args['email'] = $post_meta['team_member_email'];
				$args['photo'] = $post_data['post_thumb'];
				$mult = lifecoach_get_retina_multiplier();
				if (empty($args['photo']) && !empty($args['email'])) $args['photo'] = get_avatar($args['email'], $thumb_sizes['w']*$mult);
				$args['socials'] = '';
				$soc_list = $post_meta['team_member_socials'];
				if (is_array($soc_list) && count($soc_list)>0) {
					$soc_str = '';
					foreach ($soc_list as $sn=>$sl) {
						if (!empty($sl))
							$soc_str .= (!empty($soc_str) ? '|' : '') . ($sn) . '=' . ($sl);
					}
					if (!empty($soc_str))
						$args['socials'] = lifecoach_do_shortcode('[trx_socials size="tiny" shape="round" socials="'.esc_attr($soc_str).'"][/trx_socials]');
				}
	
				$output .= lifecoach_show_post_layout($args, $post_data);
			}
			wp_reset_postdata();
		}

		if (lifecoach_param_is_on($slider)) {
			$output .= '</div>'
				. '<div class="sc_slider_controls_wrap"><a class="sc_slider_prev" href="#"></a><a class="sc_slider_next" href="#"></a></div>'
				. '<div class="sc_slider_pagination_wrap"></div>'
				. '</div>';
		} else if ($columns > 1) {// && lifecoach_get_template_property($style, 'need_columns')) {
			$output .= '</div>';
		}

		$output .= (!empty($link) ? '<div class="sc_team_button sc_item_button">'.lifecoach_do_shortcode('[trx_button link="'.esc_url($link).'" icon="icon-right"]'.esc_html($link_caption).'[/trx_button]').'</div>' : '')
					. '</div><!-- /.sc_team -->'
				. '</div><!-- /.sc_team_wrap -->';
	
		// Add template specific scripts and styles
		do_action('lifecoach_action_blog_scripts', $style);
	
		return apply_filters('lifecoach_shortcode_output', $output, 'trx_team', $atts, $content);
	}
	lifecoach_require_shortcode('trx_team', 'lifecoach_sc_team');
}


if ( !function_exists( 'lifecoach_sc_team_item' ) ) {
	function lifecoach_sc_team_item($atts, $content=null) {
		if (lifecoach_in_shortcode_blogger()) return '';
		extract(lifecoach_html_decode(shortcode_atts( array(
			// Individual params
			"user" => "",
			"member" => "",
			"name" => "",
			"position" => "",
			"photo" => "",
			"email" => "",
			"link" => "",
			"socials" => "",
			// Common params
			"id" => "",
			"class" => "",
			"animation" => "",
			"css" => ""
		), $atts)));
	
		lifecoach_storage_inc_array('sc_team_data', 'counter');
	
		$id = $id ? $id : (lifecoach_storage_get_array('sc_team_data', 'id') ? lifecoach_storage_get_array('sc_team_data', 'id') . '_' . lifecoach_storage_get_array('sc_team_data', 'counter') : '');
	
		$descr = trim(chop(do_shortcode($content)));
	
		$thumb_sizes = lifecoach_get_thumb_sizes(array('layout' => lifecoach_storage_get_array('sc_team_data', 'style')));
	
		if (!empty($socials)) $socials = lifecoach_do_shortcode('[trx_socials size="tiny" shape="round" socials="'.esc_attr($socials).'"][/trx_socials]');
	
		if (!empty($user) && $user!='none' && ($user_obj = get_user_by('login', $user)) != false) {
			$meta = get_user_meta($user_obj->ID);
			if (empty($email))		$email = $user_obj->data->user_email;
			if (empty($name))		$name = $user_obj->data->display_name;
			if (empty($position))	$position = isset($meta['user_position'][0]) ? $meta['user_position'][0] : '';
			if (empty($descr))		$descr = isset($meta['description'][0]) ? $meta['description'][0] : '';
			if (empty($socials))	$socials = lifecoach_show_user_socials(array('author_id'=>$user_obj->ID, 'echo'=>false));
		}
	
		if (!empty($member) && $member!='none' && ($member_obj = (intval($member) > 0 ? get_post($member, OBJECT) : get_page_by_title($member, OBJECT, 'team'))) != null) {
			if (empty($name))		$name = $member_obj->post_title;
			if (empty($descr))		$descr = $member_obj->post_excerpt;
			$post_meta = get_post_meta($member_obj->ID, 'lifecoach_team_data', true);
			if (empty($position))	$position = $post_meta['team_member_position'];
			if (empty($link))		$link = !empty($post_meta['team_member_link']) ? $post_meta['team_member_link'] : get_permalink($member_obj->ID);
			if (empty($email))		$email = $post_meta['team_member_email'];
			if (empty($photo)) 		$photo = wp_get_attachment_url(get_post_thumbnail_id($member_obj->ID));
			if (empty($socials)) {
				$socials = '';
				$soc_list = $post_meta['team_member_socials'];
				if (is_array($soc_list) && count($soc_list)>0) {
					$soc_str = '';
					foreach ($soc_list as $sn=>$sl) {
						if (!empty($sl))
							$soc_str .= (!empty($soc_str) ? '|' : '') . ($sn) . '=' . ($sl);
					}
					if (!empty($soc_str))
						$socials = lifecoach_do_shortcode('[trx_socials size="tiny" shape="round" socials="'.esc_attr($soc_str).'"][/trx_socials]');
				}
			}
		}
		if (empty($photo)) {
			$mult = lifecoach_get_retina_multiplier();
			if (!empty($email)) $photo = get_avatar($email, $thumb_sizes['w']*$mult);
		} else {
			if ($photo > 0) {
				$attach = wp_get_attachment_image_src( $photo, 'full' );
				if (isset($attach[0]) && $attach[0]!='')
					$photo = $attach[0];
			}
			$photo = lifecoach_get_resized_image_tag($photo, $thumb_sizes['w'], $thumb_sizes['h']);
		}
		$post_data = array(
			'post_title' => $name,
			'post_excerpt' => $descr
		);
		$args = array(
			'layout' => lifecoach_storage_get_array('sc_team_data', 'style'),
			'number' => lifecoach_storage_get_array('sc_team_data', 'counter'),
			'columns_count' => lifecoach_storage_get_array('sc_team_data', 'columns'),
			'slider' => lifecoach_storage_get_array('sc_team_data', 'slider'),
			'show' => false,
			'descr'  => 0,
			'tag_id' => $id,
			'tag_class' => $class,
			'tag_animation' => $animation,
			'tag_css' => $css,
			'tag_css_wh' => lifecoach_storage_get_array('sc_team_data', 'css_wh'),
			'position' => $position,
			'link' => $link,
			'email' => $email,
			'photo' => $photo,
			'socials' => $socials
		);
		$output = lifecoach_show_post_layout($args, $post_data);

		return apply_filters('lifecoach_shortcode_output', $output, 'trx_team_item', $atts, $content);
	}
	lifecoach_require_shortcode('trx_team_item', 'lifecoach_sc_team_item');
}
// ---------------------------------- [/trx_team] ---------------------------------------



// Add [trx_team] and [trx_team_item] in the shortcodes list
if (!function_exists('lifecoach_team_reg_shortcodes')) {
	//add_filter('lifecoach_action_shortcodes_list',	'lifecoach_team_reg_shortcodes');
	function lifecoach_team_reg_shortcodes() {
		if (lifecoach_storage_isset('shortcodes')) {

			$users = lifecoach_get_list_users();
			$members = lifecoach_get_list_posts(false, array(
				'post_type'=>'team',
				'orderby'=>'title',
				'order'=>'asc',
				'return'=>'title'
				)
			);
			$team_groups = lifecoach_get_list_terms(false, 'team_group');
			$team_styles = lifecoach_get_list_templates('team');
			$controls	 = lifecoach_get_list_slider_controls();

			lifecoach_sc_map_after('trx_tabs', array(

				// Team
				"trx_team" => array(
					"title" => esc_html__("Team", 'lifecoach'),
					"desc" => wp_kses_data( __("Insert team in your page (post)", 'lifecoach') ),
					"decorate" => true,
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
							"title" => esc_html__("Team style", 'lifecoach'),
							"desc" => wp_kses_data( __("Select style to display team members", 'lifecoach') ),
							"value" => "1",
							"type" => "select",
							"options" => $team_styles
						),
						"columns" => array(
							"title" => esc_html__("Columns", 'lifecoach'),
							"desc" => wp_kses_data( __("How many columns use to show team members", 'lifecoach') ),
							"value" => 3,
							"min" => 2,
							"max" => 5,
							"step" => 1,
							"type" => "spinner"
						),
						"scheme" => array(
							"title" => esc_html__("Color scheme", 'lifecoach'),
							"desc" => wp_kses_data( __("Select color scheme for this block", 'lifecoach') ),
							"value" => "",
							"type" => "checklist",
							"options" => lifecoach_get_sc_param('schemes')
						),
						"slider" => array(
							"title" => esc_html__("Slider", 'lifecoach'),
							"desc" => wp_kses_data( __("Use slider to show team members", 'lifecoach') ),
							"value" => "no",
							"type" => "switch",
							"options" => lifecoach_get_sc_param('yes_no')
						),
						"controls" => array(
							"title" => esc_html__("Controls", 'lifecoach'),
							"desc" => wp_kses_data( __("Slider controls style and position", 'lifecoach') ),
							"dependency" => array(
								'slider' => array('yes')
							),
							"divider" => true,
							"value" => "",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $controls
						),
						"slides_space" => array(
							"title" => esc_html__("Space between slides", 'lifecoach'),
							"desc" => wp_kses_data( __("Size of space (in px) between slides", 'lifecoach') ),
							"dependency" => array(
								'slider' => array('yes')
							),
							"value" => 0,
							"min" => 0,
							"max" => 100,
							"step" => 10,
							"type" => "spinner"
						),
						"interval" => array(
							"title" => esc_html__("Slides change interval", 'lifecoach'),
							"desc" => wp_kses_data( __("Slides change interval (in milliseconds: 1000ms = 1s)", 'lifecoach') ),
							"dependency" => array(
								'slider' => array('yes')
							),
							"value" => 7000,
							"step" => 500,
							"min" => 0,
							"type" => "spinner"
						),
						"autoheight" => array(
							"title" => esc_html__("Autoheight", 'lifecoach'),
							"desc" => wp_kses_data( __("Change whole slider's height (make it equal current slide's height)", 'lifecoach') ),
							"dependency" => array(
								'slider' => array('yes')
							),
							"value" => "yes",
							"type" => "switch",
							"options" => lifecoach_get_sc_param('yes_no')
						),
						"align" => array(
							"title" => esc_html__("Alignment", 'lifecoach'),
							"desc" => wp_kses_data( __("Alignment of the team block", 'lifecoach') ),
							"divider" => true,
							"value" => "",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => lifecoach_get_sc_param('align')
						),
						"custom" => array(
							"title" => esc_html__("Custom", 'lifecoach'),
							"desc" => wp_kses_data( __("Allow get team members from inner shortcodes (custom) or get it from specified group (cat)", 'lifecoach') ),
							"divider" => true,
							"value" => "no",
							"type" => "switch",
							"options" => lifecoach_get_sc_param('yes_no')
						),
						"cat" => array(
							"title" => esc_html__("Categories", 'lifecoach'),
							"desc" => wp_kses_data( __("Select categories (groups) to show team members. If empty - select team members from any category (group) or from IDs list", 'lifecoach') ),
							"dependency" => array(
								'custom' => array('no')
							),
							"divider" => true,
							"value" => "",
							"type" => "select",
							"style" => "list",
							"multiple" => true,
							"options" => lifecoach_array_merge(array(0 => esc_html__('- Select category -', 'lifecoach')), $team_groups)
						),
						"count" => array(
							"title" => esc_html__("Number of posts", 'lifecoach'),
							"desc" => wp_kses_data( __("How many posts will be displayed? If used IDs - this parameter ignored.", 'lifecoach') ),
							"dependency" => array(
								'custom' => array('no')
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
								'custom' => array('no')
							),
							"value" => 0,
							"min" => 0,
							"type" => "spinner"
						),
						"orderby" => array(
							"title" => esc_html__("Post order by", 'lifecoach'),
							"desc" => wp_kses_data( __("Select desired posts sorting method", 'lifecoach') ),
							"dependency" => array(
								'custom' => array('no')
							),
							"value" => "title",
							"type" => "select",
							"options" => lifecoach_get_sc_param('sorting')
						),
						"order" => array(
							"title" => esc_html__("Post order", 'lifecoach'),
							"desc" => wp_kses_data( __("Select desired posts order", 'lifecoach') ),
							"dependency" => array(
								'custom' => array('no')
							),
							"value" => "asc",
							"type" => "switch",
							"size" => "big",
							"options" => lifecoach_get_sc_param('ordering')
						),
						"ids" => array(
							"title" => esc_html__("Post IDs list", 'lifecoach'),
							"desc" => wp_kses_data( __("Comma separated list of posts ID. If set - parameters above are ignored!", 'lifecoach') ),
							"dependency" => array(
								'custom' => array('no')
							),
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
					),
					"children" => array(
						"name" => "trx_team_item",
						"title" => esc_html__("Member", 'lifecoach'),
						"desc" => wp_kses_data( __("Team member", 'lifecoach') ),
						"container" => true,
						"params" => array(
							"user" => array(
								"title" => esc_html__("Registerd user", 'lifecoach'),
								"desc" => wp_kses_data( __("Select one of registered users (if present) or put name, position, etc. in fields below", 'lifecoach') ),
								"value" => "",
								"type" => "select",
								"options" => $users
							),
							"member" => array(
								"title" => esc_html__("Team member", 'lifecoach'),
								"desc" => wp_kses_data( __("Select one of team members (if present) or put name, position, etc. in fields below", 'lifecoach') ),
								"value" => "",
								"type" => "select",
								"options" => $members
							),
							"link" => array(
								"title" => esc_html__("Link", 'lifecoach'),
								"desc" => wp_kses_data( __("Link on team member's personal page", 'lifecoach') ),
								"divider" => true,
								"value" => "",
								"type" => "text"
							),
							"name" => array(
								"title" => esc_html__("Name", 'lifecoach'),
								"desc" => wp_kses_data( __("Team member's name", 'lifecoach') ),
								"divider" => true,
								"dependency" => array(
									'user' => array('is_empty', 'none'),
									'member' => array('is_empty', 'none')
								),
								"value" => "",
								"type" => "text"
							),
							"position" => array(
								"title" => esc_html__("Position", 'lifecoach'),
								"desc" => wp_kses_data( __("Team member's position", 'lifecoach') ),
								"dependency" => array(
									'user' => array('is_empty', 'none'),
									'member' => array('is_empty', 'none')
								),
								"value" => "",
								"type" => "text"
							),
							"email" => array(
								"title" => esc_html__("E-mail", 'lifecoach'),
								"desc" => wp_kses_data( __("Team member's e-mail", 'lifecoach') ),
								"dependency" => array(
									'user' => array('is_empty', 'none'),
									'member' => array('is_empty', 'none')
								),
								"value" => "",
								"type" => "text"
							),
							"photo" => array(
								"title" => esc_html__("Photo", 'lifecoach'),
								"desc" => wp_kses_data( __("Team member's photo (avatar)", 'lifecoach') ),
								"dependency" => array(
									'user' => array('is_empty', 'none'),
									'member' => array('is_empty', 'none')
								),
								"value" => "",
								"readonly" => false,
								"type" => "media"
							),
							"socials" => array(
								"title" => esc_html__("Socials", 'lifecoach'),
								"desc" => wp_kses_data( __("Team member's socials icons: name=url|name=url... For example: facebook=http://facebook.com/myaccount|twitter=http://twitter.com/myaccount", 'lifecoach') ),
								"dependency" => array(
									'user' => array('is_empty', 'none'),
									'member' => array('is_empty', 'none')
								),
								"value" => "",
								"type" => "text"
							),
							"_content_" => array(
								"title" => esc_html__("Description", 'lifecoach'),
								"desc" => wp_kses_data( __("Team member's short description", 'lifecoach') ),
								"divider" => true,
								"rows" => 4,
								"value" => "",
								"type" => "textarea"
							),
							"id" => lifecoach_get_sc_param('id'),
							"class" => lifecoach_get_sc_param('class'),
							"animation" => lifecoach_get_sc_param('animation'),
							"css" => lifecoach_get_sc_param('css')
						)
					)
				)

			));
		}
	}
}


// Add [trx_team] and [trx_team_item] in the VC shortcodes list
if (!function_exists('lifecoach_team_reg_shortcodes_vc')) {
	//add_filter('lifecoach_action_shortcodes_list_vc',	'lifecoach_team_reg_shortcodes_vc');
	function lifecoach_team_reg_shortcodes_vc() {

		$users = lifecoach_get_list_users();
		$members = lifecoach_get_list_posts(false, array(
			'post_type'=>'team',
			'orderby'=>'title',
			'order'=>'asc',
			'return'=>'title'
			)
		);
		$team_groups = lifecoach_get_list_terms(false, 'team_group');
		$team_styles = lifecoach_get_list_templates('team');
		$controls	 = lifecoach_get_list_slider_controls();

		// Team
		vc_map( array(
				"base" => "trx_team",
				"name" => esc_html__("Team", 'lifecoach'),
				"description" => wp_kses_data( __("Insert team members", 'lifecoach') ),
				"category" => esc_html__('Content', 'lifecoach'),
				'icon' => 'icon_trx_team',
				"class" => "trx_sc_columns trx_sc_team",
				"content_element" => true,
				"is_container" => true,
				"show_settings_on_create" => true,
				"as_parent" => array('only' => 'trx_team_item'),
				"params" => array(
					array(
						"param_name" => "style",
						"heading" => esc_html__("Team style", 'lifecoach'),
						"description" => wp_kses_data( __("Select style to display team members", 'lifecoach') ),
						"class" => "",
						"admin_label" => true,
						"value" => array_flip($team_styles),
						"type" => "dropdown"
					),
					array(
						"param_name" => "scheme",
						"heading" => esc_html__("Color scheme", 'lifecoach'),
						"description" => wp_kses_data( __("Select color scheme for this block", 'lifecoach') ),
						"class" => "",
						"value" => array_flip(lifecoach_get_sc_param('schemes')),
						"type" => "dropdown"
					),
					array(
						"param_name" => "slider",
						"heading" => esc_html__("Slider", 'lifecoach'),
						"description" => wp_kses_data( __("Use slider to show team members", 'lifecoach') ),
						"admin_label" => true,
						"group" => esc_html__('Slider', 'lifecoach'),
						"class" => "",
						"std" => "no",
						"value" => array_flip(lifecoach_get_sc_param('yes_no')),
						"type" => "dropdown"
					),
					array(
						"param_name" => "controls",
						"heading" => esc_html__("Controls", 'lifecoach'),
						"description" => wp_kses_data( __("Slider controls style and position", 'lifecoach') ),
						"admin_label" => true,
						"group" => esc_html__('Slider', 'lifecoach'),
						'dependency' => array(
							'element' => 'slider',
							'value' => 'yes'
						),
						"class" => "",
						"std" => "no",
						"value" => array_flip($controls),
						"type" => "dropdown"
					),
					array(
						"param_name" => "slides_space",
						"heading" => esc_html__("Space between slides", 'lifecoach'),
						"description" => wp_kses_data( __("Size of space (in px) between slides", 'lifecoach') ),
						"admin_label" => true,
						"group" => esc_html__('Slider', 'lifecoach'),
						'dependency' => array(
							'element' => 'slider',
							'value' => 'yes'
						),
						"class" => "",
						"value" => "0",
						"type" => "textfield"
					),
					array(
						"param_name" => "interval",
						"heading" => esc_html__("Slides change interval", 'lifecoach'),
						"description" => wp_kses_data( __("Slides change interval (in milliseconds: 1000ms = 1s)", 'lifecoach') ),
						"group" => esc_html__('Slider', 'lifecoach'),
						'dependency' => array(
							'element' => 'slider',
							'value' => 'yes'
						),
						"class" => "",
						"value" => "7000",
						"type" => "textfield"
					),
					array(
						"param_name" => "autoheight",
						"heading" => esc_html__("Autoheight", 'lifecoach'),
						"description" => wp_kses_data( __("Change whole slider's height (make it equal current slide's height)", 'lifecoach') ),
						"group" => esc_html__('Slider', 'lifecoach'),
						'dependency' => array(
							'element' => 'slider',
							'value' => 'yes'
						),
						"class" => "",
						"value" => array("Autoheight" => "yes" ),
						"type" => "checkbox"
					),
					array(
						"param_name" => "align",
						"heading" => esc_html__("Alignment", 'lifecoach'),
						"description" => wp_kses_data( __("Alignment of the team block", 'lifecoach') ),
						"class" => "",
						"value" => array_flip(lifecoach_get_sc_param('align')),
						"type" => "dropdown"
					),
					array(
						"param_name" => "custom",
						"heading" => esc_html__("Custom", 'lifecoach'),
						"description" => wp_kses_data( __("Allow get team members from inner shortcodes (custom) or get it from specified group (cat)", 'lifecoach') ),
						"class" => "",
						"value" => array("Custom members" => "yes" ),
						"type" => "checkbox"
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
						"param_name" => "cat",
						"heading" => esc_html__("Categories", 'lifecoach'),
						"description" => wp_kses_data( __("Select category to show team members. If empty - select team members from any category (group) or from IDs list", 'lifecoach') ),
						"group" => esc_html__('Query', 'lifecoach'),
						'dependency' => array(
							'element' => 'custom',
							'is_empty' => true
						),
						"class" => "",
						"value" => array_flip(lifecoach_array_merge(array(0 => esc_html__('- Select category -', 'lifecoach')), $team_groups)),
						"type" => "dropdown"
					),
					array(
						"param_name" => "columns",
						"heading" => esc_html__("Columns", 'lifecoach'),
						"description" => wp_kses_data( __("How many columns use to show team members", 'lifecoach') ),
						"group" => esc_html__('Query', 'lifecoach'),
						"admin_label" => true,
						"class" => "",
						"value" => "3",
						"type" => "textfield"
					),
					array(
						"param_name" => "count",
						"heading" => esc_html__("Number of posts", 'lifecoach'),
						"description" => wp_kses_data( __("How many posts will be displayed? If used IDs - this parameter ignored.", 'lifecoach') ),
						"group" => esc_html__('Query', 'lifecoach'),
						'dependency' => array(
							'element' => 'custom',
							'is_empty' => true
						),
						"class" => "",
						"value" => "3",
						"type" => "textfield"
					),
					array(
						"param_name" => "offset",
						"heading" => esc_html__("Offset before select posts", 'lifecoach'),
						"description" => wp_kses_data( __("Skip posts before select next part.", 'lifecoach') ),
						"group" => esc_html__('Query', 'lifecoach'),
						'dependency' => array(
							'element' => 'custom',
							'is_empty' => true
						),
						"class" => "",
						"value" => "0",
						"type" => "textfield"
					),
					array(
						"param_name" => "orderby",
						"heading" => esc_html__("Post sorting", 'lifecoach'),
						"description" => wp_kses_data( __("Select desired posts sorting method", 'lifecoach') ),
						"group" => esc_html__('Query', 'lifecoach'),
						'dependency' => array(
							'element' => 'custom',
							'is_empty' => true
						),
						"std" => "title",
						"class" => "",
						"value" => array_flip(lifecoach_get_sc_param('sorting')),
						"type" => "dropdown"
					),
					array(
						"param_name" => "order",
						"heading" => esc_html__("Post order", 'lifecoach'),
						"description" => wp_kses_data( __("Select desired posts order", 'lifecoach') ),
						"group" => esc_html__('Query', 'lifecoach'),
						'dependency' => array(
							'element' => 'custom',
							'is_empty' => true
						),
						"std" => "asc",
						"class" => "",
						"value" => array_flip(lifecoach_get_sc_param('ordering')),
						"type" => "dropdown"
					),
					array(
						"param_name" => "ids",
						"heading" => esc_html__("Team member's IDs list", 'lifecoach'),
						"description" => wp_kses_data( __("Comma separated list of team members's ID. If set - parameters above (category, count, order, etc.)  are ignored!", 'lifecoach') ),
						"group" => esc_html__('Query', 'lifecoach'),
						'dependency' => array(
							'element' => 'custom',
							'is_empty' => true
						),
						"class" => "",
						"value" => "",
						"type" => "textfield"
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
					lifecoach_vc_width(),
					lifecoach_vc_height(),
					lifecoach_get_vc_param('margin_top'),
					lifecoach_get_vc_param('margin_bottom'),
					lifecoach_get_vc_param('margin_left'),
					lifecoach_get_vc_param('margin_right'),
					lifecoach_get_vc_param('id'),
					lifecoach_get_vc_param('class'),
					lifecoach_get_vc_param('animation'),
					lifecoach_get_vc_param('css')
				),
				'default_content' => '
					[trx_team_item user="' . esc_html__( 'Member 1', 'lifecoach' ) . '"][/trx_team_item]
					[trx_team_item user="' . esc_html__( 'Member 2', 'lifecoach' ) . '"][/trx_team_item]
					[trx_team_item user="' . esc_html__( 'Member 4', 'lifecoach' ) . '"][/trx_team_item]
				',
				'js_view' => 'VcTrxColumnsView'
			) );
			
			
		vc_map( array(
				"base" => "trx_team_item",
				"name" => esc_html__("Team member", 'lifecoach'),
				"description" => wp_kses_data( __("Team member - all data pull out from it account on your site", 'lifecoach') ),
				"show_settings_on_create" => true,
				"class" => "trx_sc_collection trx_sc_column_item trx_sc_team_item",
				"content_element" => true,
				"is_container" => true,
				'icon' => 'icon_trx_team_item',
				"as_child" => array('only' => 'trx_team'),
				"as_parent" => array('except' => 'trx_team'),
				"params" => array(
					array(
						"param_name" => "user",
						"heading" => esc_html__("Registered user", 'lifecoach'),
						"description" => wp_kses_data( __("Select one of registered users (if present) or put name, position, etc. in fields below", 'lifecoach') ),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip($users),
						"type" => "dropdown"
					),
					array(
						"param_name" => "member",
						"heading" => esc_html__("Team member", 'lifecoach'),
						"description" => wp_kses_data( __("Select one of team members (if present) or put name, position, etc. in fields below", 'lifecoach') ),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip($members),
						"type" => "dropdown"
					),
					array(
						"param_name" => "link",
						"heading" => esc_html__("Link", 'lifecoach'),
						"description" => wp_kses_data( __("Link on team member's personal page", 'lifecoach') ),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "name",
						"heading" => esc_html__("Name", 'lifecoach'),
						"description" => wp_kses_data( __("Team member's name", 'lifecoach') ),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "position",
						"heading" => esc_html__("Position", 'lifecoach'),
						"description" => wp_kses_data( __("Team member's position", 'lifecoach') ),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "email",
						"heading" => esc_html__("E-mail", 'lifecoach'),
						"description" => wp_kses_data( __("Team member's e-mail", 'lifecoach') ),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "photo",
						"heading" => esc_html__("Member's Photo", 'lifecoach'),
						"description" => wp_kses_data( __("Team member's photo (avatar)", 'lifecoach') ),
						"class" => "",
						"value" => "",
						"type" => "attach_image"
					),
					array(
						"param_name" => "socials",
						"heading" => esc_html__("Socials", 'lifecoach'),
						"description" => wp_kses_data( __("Team member's socials icons: name=url|name=url... For example: facebook=http://facebook.com/myaccount|twitter=http://twitter.com/myaccount", 'lifecoach') ),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					lifecoach_get_vc_param('id'),
					lifecoach_get_vc_param('class'),
					lifecoach_get_vc_param('animation'),
					lifecoach_get_vc_param('css')
				),
				'js_view' => 'VcTrxColumnItemView'
			) );
			
		class WPBakeryShortCode_Trx_Team extends LIFECOACH_VC_ShortCodeColumns {}
		class WPBakeryShortCode_Trx_Team_Item extends LIFECOACH_VC_ShortCodeCollection {}

	}
}
?>