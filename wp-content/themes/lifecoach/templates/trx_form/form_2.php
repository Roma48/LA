<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'lifecoach_template_form_2_theme_setup' ) ) {
	add_action( 'lifecoach_action_before_init_theme', 'lifecoach_template_form_2_theme_setup', 1 );
	function lifecoach_template_form_2_theme_setup() {
		lifecoach_add_template(array(
			'layout' => 'form_2',
			'mode'   => 'forms',
			'title'  => esc_html__('Contact Form 2', 'lifecoach')
			));
	}
}

// Template output
if ( !function_exists( 'lifecoach_template_form_2_output' ) ) {
	function lifecoach_template_form_2_output($post_options, $post_data) {
		$address_1 = lifecoach_get_theme_option('contact_address_1');
		$address_2 = lifecoach_get_theme_option('contact_address_2');
		$phone = lifecoach_get_theme_option('contact_phone');
		$fax = lifecoach_get_theme_option('contact_fax');
		$email = lifecoach_get_theme_option('contact_email');
		$open_hours = lifecoach_get_theme_option('contact_open_hours');
		?>
		<div class="sc_columns columns_wrap">
			<div class="sc_form_fields column-1_3 offset-1_6">
				<form <?php echo !empty($post_options['id']) ? ' id="'.esc_attr($post_options['id']).'_form"' : ''; ?> data-formtype="<?php echo esc_attr($post_options['layout']); ?>" method="post" action="<?php echo esc_url($post_options['action'] ? $post_options['action'] : admin_url('admin-ajax.php')); ?>">
					<?php lifecoach_sc_form_show_fields($post_options['fields']); ?>
                    <h1 class="sc_form_title"><?php echo trim($post_options['title'])?></h1>
					<div class="sc_form_info">
						<div class="sc_form_item sc_form_field label_over"><label class="required" for="sc_form_username"><?php esc_html_e('Name', 'lifecoach'); ?></label><input id="sc_form_username" type="text" name="username" placeholder="<?php esc_attr_e('Name', 'lifecoach'); ?>"></div>
						<div class="sc_form_item sc_form_field label_over"><label class="required" for="sc_form_email"><?php esc_html_e('E-mail', 'lifecoach'); ?></label><input id="sc_form_email" type="text" name="email" placeholder="<?php esc_attr_e('E-mail', 'lifecoach'); ?>"></div>
					</div>
					<div class="sc_form_item sc_form_message label_over"><label class="required" for="sc_form_message"><?php esc_html_e('Message', 'lifecoach'); ?></label><textarea id="sc_form_message" name="message" placeholder="<?php esc_attr_e('Message', 'lifecoach'); ?>"></textarea></div>
					<div class="sc_form_item sc_form_button"><button><?php esc_html_e('Send Message', 'lifecoach'); ?></button></div>
					<div class="result sc_infobox"></div>
				</form>
			</div><div class="sc_form_address column-1_3 offset-1_12">
                <h1 class="sc_form_subtitle"><?php echo trim($post_options['subtitle'])?></h1>
                <div class="sc_form_address_field">
                    <span class="sc_form_address_label"><?php esc_html_e('Address:', 'lifecoach'); ?></span>
                    <span class="sc_form_address_data"><?php echo trim($address_1) . (!empty($address_1) && !empty($address_2) ? ', ' : '') . $address_2; ?></span>
                </div>
                <div class="sc_form_address_field">
                    <span class="sc_form_address_label"><?php esc_html_e('Phone number:', 'lifecoach'); ?></span>
                    <span class="sc_form_address_data"><?php echo trim($phone) . (!empty($phone) && !empty($fax) ? ', ' : '') . $fax; ?></span>
                </div>
                <div class="sc_form_address_field">
                    <span class="sc_form_address_label"><?php esc_html_e('Mail:', 'lifecoach'); ?></span>
                    <span class="sc_form_address_data mail"><?php echo trim($email); ?></span>
                </div>
                <div class="sc_form_address_field">
                    <span class="sc_form_address_label"><?php esc_html_e('We are open:', 'lifecoach'); ?></span>
                    <span class="sc_form_address_data"><?php echo trim($open_hours); ?></span>
                </div>
            </div>
		</div>
		<?php
	}
}
?>