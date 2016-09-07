<?php
/**
 * Attachment page
 */
get_header(); 

while ( have_posts() ) { the_post();

	// Move lifecoach_set_post_views to the javascript - counter will work under cache system
	if (lifecoach_get_custom_option('use_ajax_views_counter')=='no') {
		lifecoach_set_post_views(get_the_ID());
	}

	lifecoach_show_post_layout(
		array(
			'layout' => 'attachment',
			'sidebar' => !lifecoach_param_is_off(lifecoach_get_custom_option('show_sidebar_main'))
		)
	);

}

get_footer();
?>