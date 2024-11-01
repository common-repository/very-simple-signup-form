<?php
// disable direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Start session for captcha validation
if (!isset ($_SESSION)) session_start(); 
$_SESSION['vssf-rand'] = isset($_SESSION['vssf-rand']) ? $_SESSION['vssf-rand'] : rand(100, 999);

// The shortcode
function vssf_shortcode($vssf_atts) {
	$vssf_atts = shortcode_atts( array( 
		"email_admin" => get_bloginfo('admin_email'),
		"label_name" => __('Name', 'very-simple-signup-form'),
		"label_email" => __('Email', 'very-simple-signup-form'),
		"label_phone" => __('Phone', 'very-simple-signup-form'),
		"label_captcha" => __('Enter number %s', 'very-simple-signup-form'),
		"label_submit" => __('Signup', 'very-simple-signup-form'),
		"error_name" => __('Please enter at least 2 characters', 'very-simple-signup-form'),
		"error_phone" => __('Please enter at least 2 characters', 'very-simple-signup-form'),
		"error_captcha" => __('Please enter the correct number', 'very-simple-signup-form'),
		"error_email" => __('Please enter a valid email', 'very-simple-signup-form'),
		"message_success" => __('Thank you! You will receive a response as soon as possible.', 'very-simple-signup-form'),
		"message_error" => __('Error! Could not send form. This might be a server issue.', 'very-simple-signup-form'),
		"from_header" => '',
		"subject" => '',
		"hide_phone" => '',
		"auto_reply" => '',
		"auto_reply_message" => __('Thank you! You will receive a response as soon as possible.', 'very-simple-signup-form'),
		"scroll_to_form" => ''
	), $vssf_atts);

	// Set some variables 
	$form_data = array(
		'form_name' => '',
		'form_email' => '',
		'form_phone' => '',
		'form_captcha' => '',
		'form_firstname' => '',
		'form_lastname' => ''
	);
	$error = false;
	$sent = false;
	$fail = false;
	$info = '';

	if ( ($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['vssf_send']) ) {
	
		// Sanitize content
		$post_data = array(
			'form_name' => sanitize_text_field($_POST['vssf_name']),
			'form_email' => sanitize_email($_POST['vssf_email']),
			'form_phone' => sanitize_text_field($_POST['vssf_phone']),
			'form_captcha' => sanitize_text_field($_POST['vssf_captcha']),
			'form_firstname' => sanitize_text_field($_POST['vssf_firstname']),
			'form_lastname' => sanitize_text_field($_POST['vssf_lastname'])
		);

		// Validate name
		$value = $post_data['form_name'];
		if ( strlen($value)<2 ) {
			$error_class['form_name'] = true;
			$error = true;
		}
		$form_data['form_name'] = $value;

		// Validate email
		$value = $post_data['form_email'];
		if ( empty($value) ) {
			$error_class['form_email'] = true;
			$error = true;
		}
		$form_data['form_email'] = $value;

		// Validate phone
		if ($vssf_atts['hide_phone'] != "true") {		
			$value = $post_data['form_phone'];
			if ( strlen($value)<2 ) {
				$error_class['form_phone'] = true;
				$error = true;
			}
			$form_data['form_phone'] = $value;
		} 

		// Validate captcha
		$value = $post_data['form_captcha'];
		if ( $value != $_SESSION['vssf-rand'] ) { 
			$error_class['form_captcha'] = true;
			$error = true;
		}
		$form_data['form_captcha'] = $value;

		// Validate first honeypot field
		$value = $post_data['form_firstname'];
		if ( strlen($value)>0 ) {
			$error = true;
		}
		$form_data['form_firstname'] = $value;

		// Validate second honeypot field
		$value = $post_data['form_lastname'];
		if ( strlen($value)>0 ) {
			$error = true;
		}
		$form_data['form_lastname'] = $value;

		// Sending form submission
		if ($error == false) {
			// Hook to support plugin Contact Form DB
			do_action( 'vssf_before_send_mail', $form_data );
			// Hook ends
			$to = $vssf_atts['email_admin'];
			$auto_reply_to = $form_data['form_email'];
			// Subject
			if (!empty($vssf_atts['subject'])) {	
				$subject = $vssf_atts['subject'];
			} else {
				$subject = sprintf( esc_attr__( 'New signup: %s', 'very-simple-signup-form' ), get_bloginfo('name') );
			}
			// From email header
			if (empty($vssf_atts['from_header'])) {
				$from = vssf_from_header();
			} else {
				$from = $vssf_atts['from_header'];
			}
			// Mail
			$message = $form_data['form_name'] . "\r\n\r\n" . $form_data['form_email'] . "\r\n\r\n" . $form_data['form_phone'] . "\r\n\r\n" . sprintf( esc_attr__( 'IP: %s', 'very-simple-signup-form' ), vssf_get_the_ip() ); 
			$headers = "Content-Type: text/plain; charset=UTF-8" . "\r\n";
			$headers .= "Content-Transfer-Encoding: 8bit" . "\r\n";
			$headers .= "From: ".$form_data['form_name']." <".$from.">" . "\r\n";
			$headers .= "Reply-To: <".$form_data['form_email'].">" . "\r\n";
			$auto_reply_message = $vssf_atts['auto_reply_message'] . "\r\n\r\n" . $form_data['form_name'] . "\r\n\r\n" . $form_data['form_email'] . "\r\n\r\n" . $form_data['form_phone'] . "\r\n\r\n" . sprintf( esc_attr__( 'IP: %s', 'very-simple-signup-form' ), vssf_get_the_ip() ); 
			$auto_reply_headers = "Content-Type: text/plain; charset=UTF-8" . "\r\n";
			$auto_reply_headers .= "Content-Transfer-Encoding: 8bit" . "\r\n";
			$auto_reply_headers .= "From: ".get_bloginfo('name')." <".$from.">" . "\r\n";
			$auto_reply_headers .= "Reply-To: <".$vssf_atts['email_admin'].">" . "\r\n";

			if( wp_mail($to, $subject, $message, $headers) ) { 
				if ($vssf_atts['auto_reply'] == "true") {
					wp_mail($auto_reply_to, $subject, $auto_reply_message, $auto_reply_headers);
				}
				$result = $vssf_atts['message_success'];
				$sent = true;
			} else {
				$result = $vssf_atts['message_error'];
				$fail = true;
			}		
		}
	}

	// Hide or display phone field 
	if ($vssf_atts['hide_phone'] == "true") {
		$hide = true;
	}

	// After submit scroll to form 
	if ($vssf_atts['scroll_to_form'] == "true") {
		$action = 'action="#vssf-anchor"';
		$anchor_begin = '<div id="vssf-anchor">';
		$anchor_end = '</div>';
	} else {
		$action = esc_attr('');
		$anchor_begin = esc_attr('');
		$anchor_end = esc_attr('');
	}
	
	// Signup form
	$email_form = '<form class="vssf" id="vssf" method="post" '.$action.'>
		<div class="form-group">
			<label for="vssf_name">'.esc_attr($vssf_atts['label_name']).': <span class="'.(isset($error_class['form_name']) ? "error" : "hide").'" >'.esc_attr($vssf_atts['error_name']).'</span></label>
			<input type="text" name="vssf_name" id="vssf_name" '.(isset($error_class['form_name']) ? ' class="error"' : '').' maxlength="50" value="'.esc_attr($form_data['form_name']).'" />
		</div>
		<div class="form-group">
			<label for="vssf_email">'.esc_attr($vssf_atts['label_email']).': <span class="'.(isset($error_class['form_email']) ? "error" : "hide").'" >'.esc_attr($vssf_atts['error_email']).'</span></label>
			<input type="email" name="vssf_email" id="vssf_email" '.(isset($error_class['form_email']) ? ' class="error"' : '').' maxlength="50" value="'.esc_attr($form_data['form_email']).'" />
		</div>
		<div'.(isset($hide) ? ' class="hide"' : ' class="form-group"').'>
			<label for="vssf_phone">'.esc_attr($vssf_atts['label_phone']).': <span class="'.(isset($error_class['form_phone']) ? "error" : "hide").'" >'.esc_attr($vssf_atts['error_phone']).'</span></label>
			<input type="text" name="vssf_phone" id="vssf_phone" '.(isset($error_class['form_phone']) ? ' class="error"' : '').' maxlength="50" value="'.esc_attr($form_data['form_phone']).'" />
		</div>
		<div class="form-group">
			<label for="vssf_captcha">'.sprintf(esc_attr($vssf_atts['label_captcha']), $_SESSION['vssf-rand']).': <span class="'.(isset($error_class['form_captcha']) ? "error" : "hide").'" >'.esc_attr($vssf_atts['error_captcha']).'</span></label>
			<input type="text" name="vssf_captcha" id="vssf_captcha" '.(isset($error_class['form_captcha']) ? ' class="error"' : '').' maxlength="50" value="'.esc_attr($form_data['form_captcha']).'" />
		</div>
		<div class="form-group hide">
			<input type="text" name="vssf_firstname" id="vssf_firstname" maxlength="50" value="'.esc_attr($form_data['form_firstname']).'" />
		</div>
		<div class="form-group hide">
			<input type="text" name="vssf_lastname" id="vssf_lastname" maxlength="50" value="'.esc_attr($form_data['form_lastname']).'" />
		</div>
		<div class="form-group">
			<button type="submit" name="vssf_send" id="vssf_send" class="btn btn-primary">'.esc_attr($vssf_atts['label_submit']).'</button>
		</div>
	</form>';

	// After form validation
	if ($sent == true) {
		unset($_SESSION['vssf-rand']);
		return $anchor_begin . '<p class="vssf-info">'.esc_attr($result).'</p>' . $anchor_end;
	} elseif ($fail == true) {
		return $anchor_begin . '<p class="vssf-info">'.esc_attr($result).'</p>' . $anchor_end;
	} else {
		return $anchor_begin .$email_form. $anchor_end;
	}
} 
add_shortcode('signup', 'vssf_shortcode');
