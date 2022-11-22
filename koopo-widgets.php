<?php
/**
 * Plugin Name: Koopo Widgets
 * Description: Koopo Custom Elementor Widgets plugin wth cool widget and Pro Dynamic Tags Enabled.
 * Plugin URI:  https://benmarshall.me/build-custom-elementor-widgets/
 * Version:     2.1.1
 * Author:      Plu2oprinze
 * Author URI:  https://koopoworld.com
 * Text Domain: koopo-widgets
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
define( 'KOOPO_WIDGET__FILE__', 						__FILE__ );
define( 'KOOPO_WIDGET_PATH', 							plugin_dir_path( KOOPO_WIDGET__FILE__ ) );
define( 'ELEMENTOR_PRO_VERSION', '3.0.4' );//this is to add dynamic tags
define( 'KOOPO_WIDGETS_URL', 							plugins_url( '/', KOOPO_WIDGET__FILE__ ) );
define( 'KOOPO_WIDGETS_ASSETS_URL', 						KOOPO_WIDGETS_URL . 'assets/' );



/**
 * Wrapper for including files
 *
 * @since 1.1.3
 */
function koopo_include( $file ) {

	$path = koopo_get_path( $file );

	if ( file_exists( $path ) ) {
		include_once( $path );
	}
}

/**
 * Check if WooCommerce is active
 *
 * @since 1.6.0
 *
 */
if ( ! function_exists( 'is_woocommerce_active' ) ) {
	function is_woocommerce_active() {
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		
		return is_plugin_active( 'woocommerce/woocommerce.php' );
	}
}

/**
 * Returns the path to a file relative to our plugin
 *
 * @since 1.1.3
 */
function koopo_get_path( $path ) {
	
	return KOOPO_WIDGET_PATH . $path;
	
}
/**
 * Main Koopo Widgets Class
 *
 * The init class that runs the Koopo Widgets plugin.
 * Intended To make sure that the plugin's minimum requirements are met.
 *
 * You should only modify the constants to match your plugin's needs.
 *
 * Any custom code should go inside Plugin Class in the plugin.php file.
 * @since 1.0.0
 */


final class Koopo_Widgets {
 
  /**
   * Plugin Version
   *
   * @since 1.0.0
   * @var string The plugin version.
   */
  const VERSION = '2.0.0';
 
  /**
   * Minimum Elementor Version
   *
   * @since 1.0.0
   * @var string Minimum Elementor version required to run the plugin.
   */
  const MINIMUM_ELEMENTOR_VERSION = '2.0.0';
 
  /**
   * Minimum PHP Version
   *
   * @since 1.0.0
   * @var string Minimum PHP version required to run the plugin.
   */
  const MINIMUM_PHP_VERSION = '7.0';
 
  /**
   * Constructor
   *
   * @since 1.0.0
   * @access public
   */
  public function __construct() {
 
    // Load translation
    add_action( 'init', array( $this, 'i18n' ) );
 
    // Init Plugin
    add_action( 'plugins_loaded', array( $this, 'koopo_widgets_loaded' ) );
  }
 
  /**
   * Load Textdomain
   *
   * Load plugin localization files.
   * Fired by `init` action hook.
   *
   * @since 1.2.0
   * @access public
   */
  public function i18n() {
    load_plugin_textdomain( 'koopo-widgets' );
  }
 
  /**
   * Initialize the plugin
   *
   * Validates that Elementor is already loaded.
   * Checks for basic plugin requirements, if one check fail don't continue,
   * if all check have passed include the plugin class.
   *
   * Fired by `plugins_loaded` action hook.
   *
   * @since 1.2.0
   * @access public
   */
  public function koopo_widgets_loaded() {
 
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
    koopo_include( 'plugin.php' );
  }
 
  /**
   * Admin notice
   *
   * Warning when the site doesn't have Elementor installed or activated.
   *
   * @since 1.0.0
   * @access public
   */
  public function admin_notice_missing_main_plugin() {
    if ( isset( $_GET['activate'] ) ) {
      unset( $_GET['activate'] );
    }
 
    $message = sprintf(
      /* translators: 1: Plugin name 2: Elementor */
      esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'koopo-widgets' ),
      '<strong>' . esc_html__( 'Koopo Widgets', 'koopo-widgets' ) . '</strong>',
      '<strong>' . esc_html__( 'Elementor', 'koopo-widgets' ) . '</strong>'
    );
 
    printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
  }
 
  /**
   * Admin notice
   *
   * Warning when the site doesn't have a minimum required Elementor version.
   *
   * @since 1.0.0
   * @access public
   */
  public function admin_notice_minimum_elementor_version() {
    if ( isset( $_GET['activate'] ) ) {
      unset( $_GET['activate'] );
    }
 
    $message = sprintf(
      /* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
      esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'koopo-widgets' ),
      '<strong>' . esc_html__( 'Koopo Widgets', 'koopo-widgets' ) . '</strong>',
      '<strong>' . esc_html__( 'Elementor', 'koopo-widgets' ) . '</strong>',
      self::MINIMUM_ELEMENTOR_VERSION
    );
 
    printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
  }

 
  /**
   * Admin notice
   *
   * Warning when the site doesn't have a minimum required PHP version.
   *
   * @since 1.0.0
   * @access public
   */
  public function admin_notice_minimum_php_version() {
    if ( isset( $_GET['activate'] ) ) {
      unset( $_GET['activate'] );
    }
 
    $message = sprintf(
      /* translators: 1: Plugin name 2: PHP 3: Required PHP version */
      esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'koopo-widgets' ),
      '<strong>' . esc_html__( 'Koopo Widgets', 'koopo-widgets' ) . '</strong>',
      '<strong>' . esc_html__( 'PHP', 'koopo-widgets' ) . '</strong>',
      self::MINIMUM_PHP_VERSION
    );
 
    printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
  }
}
 
// Instantiate Koopo_Widgets.
new Koopo_Widgets();