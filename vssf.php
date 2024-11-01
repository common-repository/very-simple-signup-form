<?php
/*
 * Plugin Name: Very Simple Signup Form
 * Description: This is a very simple signup form. Use the widget to display form in sidebar. For more info please check readme file.
 * Version: 5.7
 * Author: Guido
 * Author URI: https://www.guido.site
 * License: GNU General Public License v3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: very-simple-signup-form
 * Domain Path: /translation
 */

// disable direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// load plugin text domain
function vssf_init() { 
	load_plugin_textdomain( 'very-simple-signup-form', false, dirname( plugin_basename( __FILE__ ) ) . '/translation' );
}
add_action('plugins_loaded', 'vssf_init');

// enqueues plugin scripts
function vssf_scripts() {	
	if(!is_admin())	{
		wp_enqueue_style('vssf_style', plugins_url('/css/vssf-style.css',__FILE__));
	}
}
add_action('wp_enqueue_scripts', 'vssf_scripts');

// the sidebar widget
function register_vssf_widget() {
	register_widget( 'vssf_widget' );
}
add_action( 'widgets_init', 'register_vssf_widget' );

// function to get ip of user
function vssf_get_the_ip() {
	if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
		return $_SERVER["HTTP_X_FORWARDED_FOR"];
	}
	elseif (isset($_SERVER["HTTP_CLIENT_IP"])) {
		return $_SERVER["HTTP_CLIENT_IP"];
	}
	else {
		return $_SERVER["REMOTE_ADDR"];
	}
}

// function to create from email header
function vssf_from_header() {
	if ( !isset( $from_email ) ) {
		$sitename = strtolower( $_SERVER['SERVER_NAME'] );
		if ( substr( $sitename, 0, 4 ) == 'www.' ) {
			$sitename = substr( $sitename, 4 );
		}
		return 'wordpress@' . $sitename;
	}
}

// include form and widget file
include 'vssf-form.php';
include 'vssf-widget.php';
