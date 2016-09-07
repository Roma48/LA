<?php
/**
 * The template for displaying the footer.
 */

				lifecoach_close_wrapper();	// <!-- </.content> -->


				// Show main sidebar
				get_sidebar();

				if (lifecoach_get_custom_option('body_style')!='fullscreen') lifecoach_close_wrapper();	// <!-- </.content_wrap> -->
				?>
			
			</div>		<!-- </.page_content_wrap> -->
			
			<?php
			// Footer Testimonials stream
			if (lifecoach_get_custom_option('show_testimonials_in_footer')=='yes') { 
				$count = max(1, lifecoach_get_custom_option('testimonials_count'));
				$data = lifecoach_sc_testimonials(array('count'=>$count));
				if ($data) {
					?>
					<footer class="testimonials_wrap sc_section scheme_<?php echo esc_attr(lifecoach_get_custom_option('testimonials_scheme')); ?>">
						<div class="testimonials_wrap_inner sc_section_inner sc_section_overlay">
							<div class="content_wrap"><?php echo trim($data); ?></div>
						</div>
					</footer>
					<?php
				}
			}

            // Footer Twitter stream
            if (lifecoach_get_custom_option('show_twitter_in_footer')=='yes') {
                $count = max(1, lifecoach_get_custom_option('twitter_count'));
                $data = lifecoach_sc_twitter(array('count'=>$count));
                if ($data) {
                    ?>
                    <footer class="twitter_wrap sc_section scheme_<?php echo esc_attr(lifecoach_get_custom_option('twitter_scheme')); ?>">
                        <div class="twitter_wrap_inner sc_section_inner sc_section_overlay">
                            <div class="content_wrap"><?php echo trim($data); ?></div>
                        </div>
                    </footer>
                <?php
                }
            }
			
			// Footer sidebar
			if (!lifecoach_param_is_off(lifecoach_get_custom_option('show_sidebar_footer')) && is_active_sidebar(lifecoach_get_custom_option('sidebar_footer'))) {
				lifecoach_storage_set('current_sidebar', 'footer');
				?>
				<footer class="footer_wrap widget_area scheme_<?php echo esc_attr(lifecoach_get_custom_option('sidebar_footer_scheme')); ?>">
					<div class="footer_wrap_inner widget_area_inner">
						<div class="content_wrap">
							<div class="columns_wrap"><?php
							ob_start();
							do_action( 'before_sidebar' );
							if ( !dynamic_sidebar(lifecoach_get_custom_option('sidebar_footer')) ) {
								// Put here html if user no set widgets in sidebar
							}
							do_action( 'after_sidebar' );
							$out = ob_get_contents();
							ob_end_clean();
							echo trim(chop(preg_replace("/<\/aside>[\r\n\s]*<aside/", "</aside><aside", $out)));
							?></div>	<!-- /.columns_wrap -->
						</div>	<!-- /.content_wrap -->
					</div>	<!-- /.footer_wrap_inner -->
				</footer>	<!-- /.footer_wrap -->
				<?php
			}



			// Google map
			if ( lifecoach_get_custom_option('show_googlemap')=='yes' ) { 
				$map_address = lifecoach_get_custom_option('googlemap_address');
				$map_latlng  = lifecoach_get_custom_option('googlemap_latlng');
				$map_zoom    = lifecoach_get_custom_option('googlemap_zoom');
				$map_style   = lifecoach_get_custom_option('googlemap_style');
				$map_height  = lifecoach_get_custom_option('googlemap_height');
				if (!empty($map_address) || !empty($map_latlng)) {
					$args = array();
					if (!empty($map_style))		$args['style'] = esc_attr($map_style);
					if (!empty($map_zoom))		$args['zoom'] = esc_attr($map_zoom);
					if (!empty($map_height))	$args['height'] = esc_attr($map_height);
					echo trim(lifecoach_sc_googlemap($args));
				}
			}

			// Footer contacts
			if (lifecoach_get_custom_option('show_contacts_in_footer')=='yes') { 
				$address_1 = lifecoach_get_theme_option('contact_address_1');
				$address_2 = lifecoach_get_theme_option('contact_address_2');
				$phone = lifecoach_get_theme_option('contact_phone');
				$fax = lifecoach_get_theme_option('contact_fax');
				$contact_info = lifecoach_get_theme_option('contact_info');
				if (!empty($address_1) || !empty($address_2) || !empty($phone) || !empty($fax)) {
					?>
					<footer class="contacts_wrap scheme_<?php echo esc_attr(lifecoach_get_custom_option('contacts_scheme')); ?>">
						<div class="contacts_wrap_inner">
							<div class="content_wrap">
								<?php lifecoach_show_logo(false, false, true); ?>
								<div class="contacts_address">
									<address class="address_right">
										<?php if (!empty($phone)) echo esc_html__(' ', 'lifecoach') . ' ' . esc_html($phone) . '<br>'; ?>
										<a><?php if (!empty($contact_info)) echo esc_html__(' ', 'lifecoach') . ' ' . esc_html($contact_info); ?></a>
									</address>
									<address class="address_left">
										<?php if (!empty($address_2)) echo esc_html($address_2) . '<br>'; ?>
										<?php if (!empty($address_1)) echo esc_html($address_1); ?>
									</address>
								</div>
								<?php echo trim(lifecoach_sc_socials(array('size'=>"tiny",'shape'=>"round"))); ?>
							</div>	<!-- /.content_wrap -->
						</div>	<!-- /.contacts_wrap_inner -->
					</footer>	<!-- /.contacts_wrap -->
					<?php
				}
			}

			// Copyright area
			if (!lifecoach_param_is_off(lifecoach_get_custom_option('show_copyright_in_footer'))) {
				?> 
				<div class="copyright_wrap copyright_style_<?php echo esc_attr(lifecoach_get_custom_option('show_copyright_in_footer')); ?>  scheme_<?php echo esc_attr(lifecoach_get_custom_option('copyright_scheme')); ?>">
					<div class="copyright_wrap_inner">
						<div class="content_wrap">
							<?php
							if (lifecoach_get_custom_option('show_copyright_in_footer') == 'menu') {
								if (($menu = lifecoach_get_nav_menu('menu_footer'))!='') {
									echo trim($menu);
								}
							} else if (lifecoach_get_custom_option('show_copyright_in_footer') == 'socials') {
								echo trim(lifecoach_sc_socials(array('size'=>"tiny")));
							}
							?>
							<div class="copyright_text"><?php echo force_balance_tags(lifecoach_get_custom_option('footer_copyright')); ?></div>
						</div>
					</div>
				</div>
				<?php
			}

			lifecoach_profiler_add_point(esc_html__('After Footer', 'lifecoach'));
			?>
			
		</div>	<!-- /.page_wrap -->

	</div>		<!-- /.body_wrap -->
	
	<?php if ( !lifecoach_param_is_off(lifecoach_get_custom_option('show_sidebar_outer')) ) { ?>
	</div>	<!-- /.outer_wrap -->
	<?php } ?>

<?php
// Post/Page views counter
get_template_part(lifecoach_get_file_slug('templates/_parts/views-counter.php'));

// Login/Register
if (lifecoach_get_theme_option('show_login')=='yes') {
	lifecoach_enqueue_popup();
	// Anyone can register ?
	if ( (int) get_option('users_can_register') > 0) {
		get_template_part(lifecoach_get_file_slug('templates/_parts/popup-register.php'));
	}
	get_template_part(lifecoach_get_file_slug('templates/_parts/popup-login.php'));
}

// Front customizer
if (lifecoach_get_custom_option('show_theme_customizer')=='yes') {
	get_template_part(lifecoach_get_file_slug('core/core.customizer/front.customizer.php'));
}
?>

<a href="#" class="scroll_to_top icon-up" title="<?php esc_attr_e('Scroll to top', 'lifecoach'); ?>"></a>

<div class="custom_html_section">
<?php echo force_balance_tags(lifecoach_get_custom_option('custom_code')); ?>
</div>

<?php
echo force_balance_tags(lifecoach_get_custom_option('gtm_code2'));

wp_footer();
?>

</body>
</html>