<?php
/**
 * LifeCoach Framework: messages subsystem
 *
 * @package	lifecoach
 * @since	lifecoach 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Theme init
if (!function_exists('lifecoach_messages_theme_setup')) {
	add_action( 'lifecoach_action_before_init_theme', 'lifecoach_messages_theme_setup' );
	function lifecoach_messages_theme_setup() {
		// Core messages strings
		add_action('lifecoach_action_add_scripts_inline', 'lifecoach_messages_add_scripts_inline');
	}
}


/* Session messages
------------------------------------------------------------------------------------- */

if (!function_exists('lifecoach_get_error_msg')) {
	function lifecoach_get_error_msg() {
		return lifecoach_storage_get('error_msg');
	}
}

if (!function_exists('lifecoach_set_error_msg')) {
	function lifecoach_set_error_msg($msg) {
		$msg2 = lifecoach_get_error_msg();
		lifecoach_storage_set('error_msg', trim($msg2) . ($msg2=='' ? '' : '<br />') . trim($msg));
	}
}

if (!function_exists('lifecoach_get_success_msg')) {
	function lifecoach_get_success_msg() {
		return lifecoach_storage_get('success_msg');
	}
}

if (!function_exists('lifecoach_set_success_msg')) {
	function lifecoach_set_success_msg($msg) {
		$msg2 = lifecoach_get_success_msg();
		lifecoach_storage_set('success_msg', trim($msg2) . ($msg2=='' ? '' : '<br />') . trim($msg));
	}
}

if (!function_exists('lifecoach_get_notice_msg')) {
	function lifecoach_get_notice_msg() {
		return lifecoach_storage_get('notice_msg');
	}
}

if (!function_exists('lifecoach_set_notice_msg')) {
	function lifecoach_set_notice_msg($msg) {
		$msg2 = lifecoach_get_notice_msg();
		lifecoach_storage_set('notice_msg', trim($msg2) . ($msg2=='' ? '' : '<br />') . trim($msg));
	}
}


/* System messages (save when page reload)
------------------------------------------------------------------------------------- */
if (!function_exists('lifecoach_set_system_message')) {
	function lifecoach_set_system_message($msg, $status='info', $hdr='') {
		update_option('lifecoach_message', array('message' => $msg, 'status' => $status, 'header' => $hdr));
	}
}

if (!function_exists('lifecoach_get_system_message')) {
	function lifecoach_get_system_message($del=false) {
		$msg = get_option('lifecoach_message', false);
		if (!$msg)
			$msg = array('message' => '', 'status' => '', 'header' => '');
		else if ($del)
			lifecoach_del_system_message();
		return $msg;
	}
}

if (!function_exists('lifecoach_del_system_message')) {
	function lifecoach_del_system_message() {
		delete_option('lifecoach_message');
	}
}


/* Messages strings
------------------------------------------------------------------------------------- */

if (!function_exists('lifecoach_messages_add_scripts_inline')) {
	function lifecoach_messages_add_scripts_inline() {
		echo '<script type="text/javascript">'
			
			. "if (typeof LIFECOACH_STORAGE == 'undefined') var LIFECOACH_STORAGE = {};"
			
			// Strings for translation
			. 'LIFECOACH_STORAGE["strings"] = {'
				. 'ajax_error: 			"' . addslashes(esc_html__('Invalid server answer', 'lifecoach')) . '",'
				. 'bookmark_add: 		"' . addslashes(esc_html__('Add the bookmark', 'lifecoach')) . '",'
				. 'bookmark_added:		"' . addslashes(esc_html__('Current page has been successfully added to the bookmarks. You can see it in the right panel on the tab \'Bookmarks\'', 'lifecoach')) . '",'
				. 'bookmark_del: 		"' . addslashes(esc_html__('Delete this bookmark', 'lifecoach')) . '",'
				. 'bookmark_title:		"' . addslashes(esc_html__('Enter bookmark title', 'lifecoach')) . '",'
				. 'bookmark_exists:		"' . addslashes(esc_html__('Current page already exists in the bookmarks list', 'lifecoach')) . '",'
				. 'search_error:		"' . addslashes(esc_html__('Error occurs in AJAX search! Please, type your query and press search icon for the traditional search way.', 'lifecoach')) . '",'
				. 'email_confirm:		"' . addslashes(esc_html__('On the e-mail address "%s" we sent a confirmation email. Please, open it and click on the link.', 'lifecoach')) . '",'
				. 'reviews_vote:		"' . addslashes(esc_html__('Thanks for your vote! New average rating is:', 'lifecoach')) . '",'
				. 'reviews_error:		"' . addslashes(esc_html__('Error saving your vote! Please, try again later.', 'lifecoach')) . '",'
				. 'error_like:			"' . addslashes(esc_html__('Error saving your like! Please, try again later.', 'lifecoach')) . '",'
				. 'error_global:		"' . addslashes(esc_html__('Global error text', 'lifecoach')) . '",'
				. 'name_empty:			"' . addslashes(esc_html__('The name can\'t be empty', 'lifecoach')) . '",'
				. 'name_long:			"' . addslashes(esc_html__('Too long name', 'lifecoach')) . '",'
				. 'email_empty:			"' . addslashes(esc_html__('Too short (or empty) email address', 'lifecoach')) . '",'
				. 'email_long:			"' . addslashes(esc_html__('Too long email address', 'lifecoach')) . '",'
				. 'email_not_valid:		"' . addslashes(esc_html__('Invalid email address', 'lifecoach')) . '",'
				. 'subject_empty:		"' . addslashes(esc_html__('The subject can\'t be empty', 'lifecoach')) . '",'
				. 'subject_long:		"' . addslashes(esc_html__('Too long subject', 'lifecoach')) . '",'
				. 'text_empty:			"' . addslashes(esc_html__('The message text can\'t be empty', 'lifecoach')) . '",'
				. 'text_long:			"' . addslashes(esc_html__('Too long message text', 'lifecoach')) . '",'
				. 'send_complete:		"' . addslashes(esc_html__("Send message complete!", 'lifecoach')) . '",'
				. 'send_error:			"' . addslashes(esc_html__('Transmit failed!', 'lifecoach')) . '",'
				. 'login_empty:			"' . addslashes(esc_html__('The Login field can\'t be empty', 'lifecoach')) . '",'
				. 'login_long:			"' . addslashes(esc_html__('Too long login field', 'lifecoach')) . '",'
				. 'login_success:		"' . addslashes(esc_html__('Login success! The page will be reloaded in 3 sec.', 'lifecoach')) . '",'
				. 'login_failed:		"' . addslashes(esc_html__('Login failed!', 'lifecoach')) . '",'
				. 'password_empty:		"' . addslashes(esc_html__('The password can\'t be empty and shorter then 4 characters', 'lifecoach')) . '",'
				. 'password_long:		"' . addslashes(esc_html__('Too long password', 'lifecoach')) . '",'
				. 'password_not_equal:	"' . addslashes(esc_html__('The passwords in both fields are not equal', 'lifecoach')) . '",'
				. 'registration_success:"' . addslashes(esc_html__('Registration success! Please log in!', 'lifecoach')) . '",'
				. 'registration_failed:	"' . addslashes(esc_html__('Registration failed!', 'lifecoach')) . '",'
				. 'geocode_error:		"' . addslashes(esc_html__('Geocode was not successful for the following reason:', 'lifecoach')) . '",'
				. 'googlemap_not_avail:	"' . addslashes(esc_html__('Google map API not available!', 'lifecoach')) . '",'
				. 'editor_save_success:	"' . addslashes(esc_html__("Post content saved!", 'lifecoach')) . '",'
				. 'editor_save_error:	"' . addslashes(esc_html__("Error saving post data!", 'lifecoach')) . '",'
				. 'editor_delete_post:	"' . addslashes(esc_html__("You really want to delete the current post?", 'lifecoach')) . '",'
				. 'editor_delete_post_header:"' . addslashes(esc_html__("Delete post", 'lifecoach')) . '",'
				. 'editor_delete_success:	"' . addslashes(esc_html__("Post deleted!", 'lifecoach')) . '",'
				. 'editor_delete_error:		"' . addslashes(esc_html__("Error deleting post!", 'lifecoach')) . '",'
				. 'editor_caption_cancel:	"' . addslashes(esc_html__('Cancel', 'lifecoach')) . '",'
				. 'editor_caption_close:	"' . addslashes(esc_html__('Close', 'lifecoach')) . '"'
				. '};'
			
			. '</script>';
	}
}
?>