<?php
/**
 * Single post
 */
get_header(); 

$single_style = lifecoach_storage_get('single_style');
if (empty($single_style)) $single_style = lifecoach_get_custom_option('single_style');

while ( have_posts() ) { the_post();
	lifecoach_show_post_layout(
		array(
			'layout' => $single_style,
			'sidebar' => !lifecoach_param_is_off(lifecoach_get_custom_option('show_sidebar_main')),
			'content' => lifecoach_get_template_property($single_style, 'need_content'),
			'terms_list' => lifecoach_get_template_property($single_style, 'need_terms')
		)
	);
}

get_footer();
?>