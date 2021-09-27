<?php

namespace ProDevign\BlockMeister;

use  ProDevign\BlockMeister\Block_Builder\Block_Builder;
use  ProDevign\BlockMeister\Pattern_Builder\Pattern_Builder;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class BlockMeister {

	/**
	 * Plugin version
	 */
	const  VERSION = '2.0.8';

	/**
	 * The minimum PHP version that is required to run this plugin
	 */
	const  REQUIRED_PHP_VERSION = '5.6';

	/**
	 * The minimum WordPress version that is required to run this plugin
	 */
	const  REQUIRED_WP_VERSION = '5.5';

	/**
	 * Full plugin path and filename
	 */
	private static $plugin_file;

	/**
	 * Full plugin path (without filename)
	 */
	private static $plugin_dir;

	/**
	 * @var BlockMeister
	 */
	private static $instance = null;

	/**
	 * Constructor for the BlockMeister class
	 */
	private function __construct() {}

	/**
	 * Runs (and initializes) BlockMeister
	 *
	 * @param $plugin_file string The filename of plugin.
	 *
	 * @return void
	 */
	public static function init( $plugin_file ) {

		if ( is_null( BlockMeister::$instance ) ) {
			$blockmeister      = BlockMeister::$instance = new BlockMeister();
			self::$plugin_file = $plugin_file;
			self::$plugin_dir  = dirname( $plugin_file );

			register_activation_hook( $plugin_file, [ new Activator(), 'activate' ] );
			register_uninstall_hook( $plugin_file, [ Uninstaller::class, 'uninstall' ] );

			add_action( 'plugins_loaded', function () use ( $plugin_file ) {
				$plugin_rel_path = dirname( plugin_basename( $plugin_file ) ) . '/languages/';
				load_plugin_textdomain( 'blockmeister', false, $plugin_rel_path );
			} );
			if ( $blockmeister->meets_requirements() ) {
				Pattern_Builder::init();
			}
		}

	}

	/**
	 * Check for the required versions of WP and PHP
	 */
	private function meets_requirements() {

		// check PHP version
		if ( version_compare( phpversion(), self::REQUIRED_PHP_VERSION, '<' ) ) {
			$notice = wp_sprintf( 'BlockMeister requires PHP %s or higher to run.', self::REQUIRED_PHP_VERSION );
			$this->add_admin_error_notice_on_plugins_page( $notice );

			return false;
		}

		// check WP version
		if ( version_compare( $GLOBALS['wp_version'], self::REQUIRED_WP_VERSION, '<' ) ) {
			$notice = wp_sprintf( 'BlockMeister requires WordPress %s or later to run.', self::REQUIRED_WP_VERSION );
			$this->add_admin_error_notice_on_plugins_page( $notice );

			return false;
		}

		return true;
	}

	private function add_admin_error_notice_on_plugins_page( $notice ) {
		global $pagenow;
		if ( 'plugins.php' === $pagenow ) {
			add_action( 'admin_notices', function () use ( $notice ) {
				echo '<div class="notice notice-error"><p>' . esc_html__( $notice ) . '</p></div>';
			} );
		}
	}

	public static function get_path( $sub_path = "" ) {
		return wp_normalize_path(self::$plugin_dir . '/' . ( ( ! empty( $sub_path ) ? $sub_path . '/' : '' ) ) );
	}

	public static function get_build_path() {
		return self::get_path( 'build' );
	}

	public static function get_languages_path() {
		return self::get_path( 'languages' );
	}

	public static function get_includes_path() {
		return self::get_path( 'includes' );
	}

	public static function get_url( $sub_path = "" ) {
		return plugins_url( $sub_path, self::$plugin_file ) . '/';
	}

	public static function get_build_url() {
		return self::get_url( 'build' );
	}


} // BlockMeister