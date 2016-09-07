<?php
/*
 * The template for displaying "Page 404"
*/

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'lifecoach_template_404_theme_setup' ) ) {
	add_action( 'lifecoach_action_before_init_theme', 'lifecoach_template_404_theme_setup', 1 );
	function lifecoach_template_404_theme_setup() {
		lifecoach_add_template(array(
			'layout' => '404',
			'mode'   => 'internal',
			'title'  => 'Page 404',
			'theme_options' => array(
				'article_style' => 'stretch'
			)
		));
	}
}

// Template output
if ( !function_exists( 'lifecoach_template_404_output' ) ) {
	function lifecoach_template_404_output() {
		?>
		<article class="post_item post_item_404">
			<div class="post_content">
                <img class="image_404" src="<?php echo( get_stylesheet_directory_uri()); ?>/images/404.png" alt="404">
				<h1 class="page_subtitle"><?php esc_html_e('Can\'t Find That Page', 'lifecoach'); ?></h1>
                <h4 class="page_title"><?php esc_html_e( 'error 404', 'lifecoach' ); ?></h4>
				<p class="page_description"><?php echo wp_kses_data( sprintf( __('Cant find what you need? Take a moment and do a search below or start from <a href="%s">our homepage</a>.', 'lifecoach'), esc_url(home_url('/')) ) ); ?></p>
				<div class="page_search"><?php echo trim(lifecoach_sc_search(array('state'=>'fixed'))); ?></div>
			</div>
		</article>
		<?php
	}
}
?>