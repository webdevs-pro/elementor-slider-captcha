<?php
/**
* Plugin Name: Slider CAPTCHA for Elementor
* Description: This plugin adds a new field type CAPTCHA slider to the Elementor Pro form widget
* Plugin URI: https://github.com/webdevs-pro/elementor-slider-captcha
* Version: 0.0.1
* Author: Alex Ishchenko
* Author URI: https://github.com/webdevs-pro/
* License: GPL 3.0
* Text Domain: elementor-slider-captcha
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( ! function_exists( 'get_plugin_data' ) ){
	require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}
define('CPFE_VERSION', get_plugin_data( __FILE__ )['Version']);

final class ControlsPopupForElementor {

	const MINIMUM_ELEMENTOR_VERSION = '3.0.2';

	const MINIMUM_PHP_VERSION = '7.3';

	public function __construct() {

		// Load translation
		add_action( 'init', array( $this, 'i18n' ) );

		// Init Plugin
		add_action( 'plugins_loaded', array( $this, 'init' ) );
	}

	public function i18n() {
		load_plugin_textdomain( 'elementor-slider-captcha', false, basename( dirname( __FILE__ ) ) . '/languages' ); 
	}

	public function init() {

		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_missing_main_plugin' ) );
			return;
		}

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_elementor_version' ) );
			return;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_php_version' ) );
			return;
		}

		// Once we get here, We have passed all validation checks so we can safely include our plugin
		require_once( 'inc/plugin.php' );
	}

	public function admin_notice_missing_main_plugin() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'elementor-slider-captcha' ),
			'<strong>' . esc_html__( 'Controls popup for Elementor', 'elementor-slider-captcha' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'elementor-slider-captcha' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	public function admin_notice_minimum_elementor_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-slider-captcha' ),
			'<strong>' . esc_html__( 'Controls popup for Elementor', 'elementor-slider-captcha' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'elementor-slider-captcha' ) . '</strong>',
			self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	public function admin_notice_minimum_php_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-slider-captcha' ),
			'<strong>' . esc_html__( 'Controls popup for Elementor', 'elementor-slider-captcha' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'elementor-slider-captcha' ) . '</strong>',
			self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}
}
new ControlsPopupForElementor();


require 'inc/vendor/plugin-update-checker/plugin-update-checker.php';
$cpfeUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/webdevs-pro/elementor-slider-captcha/',
	__FILE__,
	'elementor-slider-captcha'
);

//Set the branch that contains the stable release.
$cpfeUpdateChecker->setBranch('main');