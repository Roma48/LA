<?php
/**
 * The Header for our theme.
 */

// Theme init - don't remove next row! Load custom options
lifecoach_core_init_theme();

?><!DOCTYPE html>
<html <?php language_attributes(); ?> >
<head>
	<?php
	wp_head();
	?>
</head>

<body <?php body_class();?>>

	<?php 
	lifecoach_profiler_add_point(esc_html__('BODY start', 'lifecoach'));
	
	echo force_balance_tags(lifecoach_get_custom_option('gtm_code'));

	do_action( 'before' );

	// Add TOC items 'Home' and "To top"
	if (lifecoach_get_custom_option('menu_toc_home')=='yes')
		echo trim(lifecoach_sc_anchor(array(
			'id' => "toc_home",
			'title' => esc_html__('Home', 'lifecoach'),
			'description' => esc_html__('{{Return to Home}} - ||navigate to home page of the site', 'lifecoach'),
			'icon' => "icon-home",
			'separator' => "yes",
			'url' => esc_url(home_url('/'))
			)
		)); 
	if (lifecoach_get_custom_option('menu_toc_top')=='yes')
		echo trim(lifecoach_sc_anchor(array(
			'id' => "toc_top",
			'title' => esc_html__('To Top', 'lifecoach'),
			'description' => esc_html__('{{Back to top}} - ||scroll to top of the page', 'lifecoach'),
			'icon' => "icon-double-up",
			'separator' => "yes")
			)); 
	?>

	<?php if ( !lifecoach_param_is_off(lifecoach_get_custom_option('show_sidebar_outer')) ) { ?>
	<div class="outer_wrap">
	<?php } ?>

	<?php get_template_part(lifecoach_get_file_slug('sidebar_outer.php')); ?>

	<?php
		$class = $style = '';
		if (lifecoach_get_custom_option('bg_custom')=='yes' && (lifecoach_get_custom_option('body_style')=='boxed' || lifecoach_get_custom_option('bg_image_load')=='always')) {
			if (($img = lifecoach_get_custom_option('bg_image_custom')) != '')
				$style = 'background: url('.esc_url($img).') ' . str_replace('_', ' ', lifecoach_get_custom_option('bg_image_custom_position')) . ' no-repeat fixed;';
			else if (($img = lifecoach_get_custom_option('bg_pattern_custom')) != '')
				$style = 'background: url('.esc_url($img).') 0 0 repeat fixed;';
			else if (($img = lifecoach_get_custom_option('bg_image')) > 0)
				$class = 'bg_image_'.($img);
			else if (($img = lifecoach_get_custom_option('bg_pattern')) > 0)
				$class = 'bg_pattern_'.($img);
			if (($img = lifecoach_get_custom_option('bg_color')) != '')
				$style .= 'background-color: '.($img).';';
		}
	?>

	<div class="body_wrap<?php echo !empty($class) ? ' '.esc_attr($class) : ''; ?>"<?php echo !empty($style) ? ' style="'.esc_attr($style).'"' : ''; ?>>

		<?php
		if (lifecoach_get_custom_option('show_video_bg')=='yes' && (lifecoach_get_custom_option('video_bg_youtube_code')!='' || lifecoach_get_custom_option('video_bg_url')!='')) {
			$youtube = lifecoach_get_custom_option('video_bg_youtube_code');
			$video   = lifecoach_get_custom_option('video_bg_url');
			$overlay = lifecoach_get_custom_option('video_bg_overlay')=='yes';
			if (!empty($youtube)) {
				?>
				<div class="video_bg<?php echo !empty($overlay) ? ' video_bg_overlay' : ''; ?>" data-youtube-code="<?php echo esc_attr($youtube); ?>"></div>
				<?php
			} else if (!empty($video)) {
				$info = pathinfo($video);
				$ext = !empty($info['extension']) ? $info['extension'] : 'src';
				?>
				<div class="video_bg<?php echo !empty($overlay) ? ' video_bg_overlay' : ''; ?>"><video class="video_bg_tag" width="1280" height="720" data-width="1280" data-height="720" data-ratio="16:9" preload="metadata" autoplay loop src="<?php echo esc_url($video); ?>"><source src="<?php echo esc_url($video); ?>" type="video/<?php echo esc_attr($ext); ?>"></source></video></div>
				<?php
			}
		}
		?>

		<div class="page_wrap">

			<?php
			lifecoach_profiler_add_point(esc_html__('Before Page Header', 'lifecoach'));
			// Top panel 'Above' or 'Over'
			if (in_array(lifecoach_get_custom_option('top_panel_position'), array('above', 'over'))) {
				lifecoach_show_post_layout(array(
					'layout' => lifecoach_get_custom_option('top_panel_style'),
					'position' => lifecoach_get_custom_option('top_panel_position'),
					'scheme' => lifecoach_get_custom_option('top_panel_scheme')
					), false);
				// Mobile Menu
				get_template_part(lifecoach_get_file_slug('templates/headers/_parts/header-mobile.php'));

				lifecoach_profiler_add_point(esc_html__('After show menu', 'lifecoach'));
			}

			// Slider
			get_template_part(lifecoach_get_file_slug('templates/headers/_parts/slider.php'));
			
			// Top panel 'Below'
			if (lifecoach_get_custom_option('top_panel_position') == 'below') {
				lifecoach_show_post_layout(array(
					'layout' => lifecoach_get_custom_option('top_panel_style'),
					'position' => lifecoach_get_custom_option('top_panel_position'),
					'scheme' => lifecoach_get_custom_option('top_panel_scheme')
					), false);
				// Mobile Menu
				get_template_part(lifecoach_get_file_slug('templates/headers/_parts/header-mobile.php'));

				lifecoach_profiler_add_point(esc_html__('After show menu', 'lifecoach'));
			}

			// Top of page section: page title and breadcrumbs
			$show_title = lifecoach_get_custom_option('show_page_title')=='yes';
			$show_navi = lifecoach_get_custom_option('show_page_title')=='yes' && is_single() && lifecoach_is_woocommerce_page();
			$show_breadcrumbs = lifecoach_get_custom_option('show_breadcrumbs')=='yes';
			if ($show_title || $show_breadcrumbs) {
				?>
				<div class="top_panel_title top_panel_style_<?php echo esc_attr(str_replace('header_', '', lifecoach_get_custom_option('top_panel_style'))); ?> <?php echo (!empty($show_title) ? ' title_present'.  ($show_navi ? ' navi_present' : '') : '') . (!empty($show_breadcrumbs) ? ' breadcrumbs_present' : ''); ?> scheme_<?php echo esc_attr(lifecoach_get_custom_option('top_panel_scheme')); ?>">
					<div class="top_panel_title_inner top_panel_inner_style_<?php echo esc_attr(str_replace('header_', '', lifecoach_get_custom_option('top_panel_style'))); ?> <?php echo (!empty($show_title) ? ' title_present_inner' : '') . (!empty($show_breadcrumbs) ? ' breadcrumbs_present_inner' : ''); ?>">
						<div class="content_wrap">
							<?php
							if ($show_title) {
								if ($show_navi) {
									?><div class="post_navi"><?php 
										previous_post_link( '<span class="post_navi_item post_navi_prev">%link</span>', '%title', true, '', 'product_cat' );
										next_post_link( '<span class="post_navi_item post_navi_next">%link</span>', '%title', true, '', 'product_cat' );
									?></div><?php
								} else {
									?><h1 class="page_title"><?php echo strip_tags(lifecoach_get_blog_title()); ?></h1><?php
								}
							}
							if ($show_breadcrumbs) {
								?><div class="breadcrumbs"><?php if (!is_404()) lifecoach_show_breadcrumbs(); ?></div><?php
							}
							?>
						</div>
					</div>
				</div>
				<?php
			}
			?>

			<div class="page_content_wrap page_paddings_<?php echo esc_attr(lifecoach_get_custom_option('body_paddings')); ?>">

                <?php
                if (!lifecoach_param_is_off(lifecoach_get_custom_option('header_custom_show'))) {
                ?>

                <div class="content_wrap">
                    <div
                        class="header_text"><?php echo do_shortcode(force_balance_tags(lifecoach_get_custom_option('header_custom'))); ?></div>
                </div>

                <?php
                }
				lifecoach_profiler_add_point(esc_html__('Before Page content', 'lifecoach'));
				// Content and sidebar wrapper
				if (lifecoach_get_custom_option('body_style')!='fullscreen') lifecoach_open_wrapper('<div class="content_wrap">');
				
				// Main content wrapper
				lifecoach_open_wrapper('<div class="content">');

				?>