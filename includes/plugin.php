<?php
namespace Galerie_Mueller_Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Plugin class.
 *
 * The main class that initiates and runs the Galerie Mueller Widgets addon.
 *
 * @since 1.0.0
 */
final class Plugin {

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.0.0
	 * @var string
	 */
	const MINIMUM_ELEMENTOR_VERSION = '3.20.0';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.0.0
	 * @var string
	 */
	const MINIMUM_PHP_VERSION = '7.4';

	/**
	 * Instance
	 *
	 * @since 1.0.0
	 * @access private
	 * @static
	 * @var Plugin|null
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 * @return Plugin
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Constructor
	 *
	 * Perform compatibility checks and initialize.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		if ( $this->is_compatible() ) {
			add_action( 'elementor/init', [ $this, 'init' ] );
		}
	}

	/**
	 * Compatibility Checks
	 *
	 * @since 1.0.0
	 * @access public
	 * @return bool
	 */
	public function is_compatible(): bool {

		// Check if Elementor is installed and activated.
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_elementor' ] );
			return false;
		}

		// Check for required Elementor version.
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return false;
		}

		// Check for required PHP version.
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return false;
		}

		return true;
	}

	/**
	 * Admin notice: Elementor missing.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_missing_elementor(): void {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'galerie-mueller-widgets' ),
			'<strong>' . esc_html__( 'Galerie Mueller Widgets', 'galerie-mueller-widgets' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'galerie-mueller-widgets' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	/**
	 * Admin notice: Elementor version too low.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version(): void {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'galerie-mueller-widgets' ),
			'<strong>' . esc_html__( 'Galerie Mueller Widgets', 'galerie-mueller-widgets' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'galerie-mueller-widgets' ) . '</strong>',
			self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	/**
	 * Admin notice: PHP version too low.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_php_version(): void {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'galerie-mueller-widgets' ),
			'<strong>' . esc_html__( 'Galerie Mueller Widgets', 'galerie-mueller-widgets' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'galerie-mueller-widgets' ) . '</strong>',
			self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	/**
	 * Initialize
	 *
	 * Load the addon functionality after Elementor is initialized.
	 * Fired by `elementor/init` action hook.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function init(): void {
		add_action( 'elementor/elements/categories_registered', [ $this, 'register_categories' ] );
		add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'register_widget_styles' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'register_widget_scripts' ] );

		// Also register in the editor preview.
		add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'register_widget_styles' ] );

		// Register Google Fonts.
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_google_fonts' ] );
	}

	/**
	 * Register custom widget category.
	 *
	 * @since 1.0.0
	 * @access public
	 * @param \Elementor\Elements_Manager $elements_manager Elementor elements manager.
	 */
	public function register_categories( $elements_manager ): void {
		$elements_manager->add_category(
			'galerie-mueller',
			[
				'title' => esc_html__( 'Galerie Mueller', 'galerie-mueller-widgets' ),
				'icon'  => 'fa fa-paint-brush',
			]
		);
	}

	/**
	 * Register Widgets
	 *
	 * Load widget files and register new Elementor widgets.
	 * Fired by `elementor/widgets/register` action hook.
	 *
	 * @since 1.0.0
	 * @access public
	 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
	 */
	public function register_widgets( $widgets_manager ): void {
		// Hero Widget.
		require_once GM_WIDGETS_PATH . 'includes/widgets/hero-widget.php';
		$widgets_manager->register( new Widgets\Hero_Widget() );
	}

	/**
	 * Register widget styles.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function register_widget_styles(): void {
		// Hero Widget CSS.
		wp_register_style(
			'gm-hero-style',
			GM_WIDGETS_URL . 'assets/css/hero-widget.css',
			[],
			GM_WIDGETS_VERSION
		);
	}

	/**
	 * Register widget scripts.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function register_widget_scripts(): void {
		// Future widget scripts will be registered here.
	}

	/**
	 * Enqueue Google Fonts used across widgets.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function enqueue_google_fonts(): void {
		wp_enqueue_style(
			'gm-google-fonts',
			'https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap',
			[],
			null
		);
	}
}
