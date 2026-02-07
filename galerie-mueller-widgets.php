<?php
/**
 * Plugin Name: Galerie Mueller Widgets
 * Description: Custom Elementor widgets for Galerie Mueller – Wolfgang Mueller's art gallery website.
 * Plugin URI:  https://galerie-mueller.de
 * Version:     1.1.0
 * Author:      Abrarul Hoque
 * Author URI:  https://github.com/abrarulhoque
 * Text Domain: galerie-mueller-widgets
 * Domain Path: /languages
 *
 * Requires Plugins: elementor
 * Elementor tested up to: 3.25.0
 * Elementor Pro tested up to: 3.25.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Plugin constants.
define( 'GM_WIDGETS_VERSION', '1.1.0' );
define( 'GM_WIDGETS_FILE', __FILE__ );
define( 'GM_WIDGETS_PATH', plugin_dir_path( __FILE__ ) );
define( 'GM_WIDGETS_URL', plugin_dir_url( __FILE__ ) );

/**
 * Initialize the plugin.
 */
function galerie_mueller_widgets_init() {
	// Load the plugin class.
	require_once GM_WIDGETS_PATH . 'includes/plugin.php';

	// Run the plugin.
	\Galerie_Mueller_Widgets\Plugin::instance();
}
add_action( 'plugins_loaded', 'galerie_mueller_widgets_init' );
