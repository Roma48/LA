<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'lifecoach_template_header_1_theme_setup' ) ) {
	add_action( 'lifecoach_action_before_init_theme', 'lifecoach_template_header_1_theme_setup', 1 );
	function lifecoach_template_header_1_theme_setup() {
		lifecoach_add_template(array(
			'layout' => 'header_1',
			'mode'   => 'header',
			'title'  => esc_html__('Header 1', 'lifecoach'),
			'icon'   => lifecoach_get_file_url('templates/headers/images/1.jpg')
			));
	}
}

// Template output
if ( !function_exists( 'lifecoach_template_header_1_output' ) ) {
	function lifecoach_template_header_1_output($post_options, $post_data) {

		// WP custom header
		$header_css = '';
		if ($post_options['position'] != 'over') {
			$header_image = get_header_image();
			$header_css = $header_image!='' 
				? ' style="background-image: url('.esc_url($header_image).')"' 
				: '';
		}
		?>
		
		<div class="top_panel_fixed_wrap"></div>

		<header class="top_panel_wrap top_panel_style_1 scheme_<?php echo esc_attr($post_options['scheme']); ?>">
			<div class="top_panel_wrap_inner top_panel_inner_style_1 top_panel_position_<?php echo esc_attr(lifecoach_get_custom_option('top_panel_position')); ?>">
			
			<?php if (lifecoach_get_custom_option('show_top_panel_top')=='yes') { ?>
				<div class="top_panel_top">
					<div class="content_wrap clearfix">
						<?php
						lifecoach_template_set_args('top-panel-top', array(
							'top_panel_top_components' => array('contact_greeting', 'login', 'socials')
						));
						get_template_part(lifecoach_get_file_slug('templates/headers/_parts/top-panel-top.php'));
						?>
					</div>
				</div>
			<?php } ?>

			<div class="top_panel_middle" <?php echo trim($header_css); ?>>
				<div class="content_wrap">
					<div class="columns_wrap columns_fluid">
						<div class="column-2_5 contact_logo">
							<?php lifecoach_show_logo(); ?>
						</div><div class="column-3_5 header_1_info">
                        <?php
                        if (lifecoach_get_custom_option('show_appointment_button') == 'yes') {
                            echo trim(lifecoach_sc_button(array('link'=>"/appointments/","size" => "small",'style'=>"border"), lifecoach_get_custom_option('appointment_caption')));
                        }
                        if (($contact_info=trim(lifecoach_get_custom_option('contact_info')))!='') {
                            ?>
                            <div class="top_panel_top_contact_area">
                                <?php echo force_balance_tags($contact_info); ?>
                            </div>
                        <?php
                        }
                        if (($contact_phone=trim(lifecoach_get_custom_option('contact_phone')))!='') {
                            ?>
                            <div class="top_panel_top_contact_phone icon-phone-1"><?php echo force_balance_tags($contact_phone); ?></div>
                        <?php
                        }

                        ?>
                        </div>
                        <?php
						?></div>
				</div>
			</div>

			<div class="top_panel_bottom">
				<div class="content_wrap clearfix">
					<nav class="menu_main_nav_area">
						<?php
						$menu_main = lifecoach_get_nav_menu('menu_main');
						if (empty($menu_main)) $menu_main = lifecoach_get_nav_menu();
						echo trim($menu_main);
						?>
					</nav>
					<?php if (lifecoach_get_custom_option('show_search')=='yes') echo trim(lifecoach_sc_search(array('class'=>"top_panel_icon", 'state'=>"closed"))); ?>
				</div>
			</div>

			</div>
		</header>

		<?php
		lifecoach_storage_set('header_mobile', array(
			 'open_hours' => false,
			 'login' => false,
			 'socials' => false,
			 'bookmarks' => false,
			 'contact_address' => false,
			 'contact_phone_email' => false,
			 'woo_cart' => false,
			 'search' => false
			)
		);
	}
}
?>