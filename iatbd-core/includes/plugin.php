<?php 
namespace Elementor_Test;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor_Test class.
 *
 * The main class that initiates and runs the addon.
 *
 * @since 1.0.0
 */
final class Elementor_Test {

	/**
	 * Addon Version
	 *
	 * @since 1.0.0
	 * @var string The addon version.
	 */
	const VERSION = '1.0.0';

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.0.0
	 * @var string Minimum Elementor version required to run the addon.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '3.16.0';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.0.0
	 * @var string Minimum PHP version required to run the addon.
	 */
	const MINIMUM_PHP_VERSION = '7.4';

	/**
	 * Instance
	 *
	 * @since 1.0.0
	 * @access private
	 * @static
	 * @var \Elementor_Test\Plugin The single instance of the class.
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
	 * @return \Elementor_Test\Plugin An instance of the class.
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
	 * Perform some compatibility checks to make sure basic requirements are meet.
	 * If all compatibility checks pass, initialize the functionality.
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
	 * Checks whether the site meets the addon requirement.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function is_compatible() {

		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			return false;
		}

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return false;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return false;
		}

		add_action( 'elementor/elements/categories_registered', [$this, 'add_elementor_widget_categories'] );

		return true;

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

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'elementor-test' ),
			'<strong>' . esc_html__( 'Elementor Test Addon', 'elementor-test' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'elementor-test' ) . '</strong>'
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

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-test' ),
			'<strong>' . esc_html__( 'Elementor Test Addon', 'elementor-test' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'elementor-test' ) . '</strong>',
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

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-test' ),
			'<strong>' . esc_html__( 'Elementor Test Addon', 'elementor-test' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'elementor-test' ) . '</strong>',
			 self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Initialize
	 *
	 * Load the addons functionality only after Elementor is initialized.
	 *
	 * Fired by `elementor/init` action hook.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function init() {

		add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );
		add_action( 'elementor/controls/register', [ $this, 'register_controls' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_frontend_assets' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_assets' ] );
		

		/* add action elementor test widgets */ 
		add_action( 'elementor/elements/categories_registered', [$this, 'add_elementor_widget_categories'] );
	}

	public function enqueue_frontend_assets() {

	    wp_enqueue_style(
        'iatbd-core-all-icon', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css',
        [],
        time()
    );
	    wp_enqueue_style(
        'iatbd-core-all-icon', '//fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap',
        [],
        time()
    );

    wp_enqueue_style(
        'iatbd-core-style',
        plugin_dir_url(__DIR__) . 'assets/css/style.css',
        [],
        time()
    );


    wp_enqueue_script(
        'iatbd-core-script',
        plugin_dir_url(__DIR__) . 'assets/js/custom.js',
        [],
        time(),
        false
    );
}

	public function enqueue_admin_assets( $hook ) {
		if ( 'toplevel_page_iatbd-demo' !== $hook ) {
			return;
		}

		wp_enqueue_style(
			'iatbd-core-style',
			plugin_dir_url(__DIR__) . 'assets/css/style.css',
			[],
			time()
		);

		wp_enqueue_script(
			'iatbd-core-script',
			plugin_dir_url(__DIR__) . 'assets/js/custom.js',
			[],
			time(),
			false
		);
	}

	/**
	 * Register Widgets
	 *
	 * Load widgets files and register new Elementor widgets.
	 *
	 * Fired by `elementor/widgets/register` action hook.
	 *
	 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
	 */
	public function register_widgets( $widgets_manager ) {

		require_once( __DIR__ . '/widgets/header-one.php' );
		require_once( __DIR__ . '/widgets/footer.php' );
		require_once( __DIR__ . '/widgets/hero-one.php' );
		require_once( __DIR__ . '/widgets/iatbd-counter-widget.php' );
		require_once( __DIR__ . '/widgets/iatbd-overview-widget.php' );
		require_once( __DIR__ . '/widgets/iatbd-services-widget.php' );
		require_once( __DIR__ . '/widgets/iatbd-brands-widget.php' );
		require_once( __DIR__ . '/widgets/iatbd-process-widget.php' );
		require_once( __DIR__ . '/widgets/iatbd-benefits-widget.php' );
		require_once( __DIR__ . '/widgets/iatbd-testimonials-widget.php' );

		$widgets_manager->register( new \Widget_1() );
		$widgets_manager->register( new \IATBD_Footer() );
		$widgets_manager->register( new \IATBD_Servo_Hero() );
		$widgets_manager->register( new \IATBD_Counter() );
		$widgets_manager->register( new \IATBD_Overview() );
		$widgets_manager->register( new \IATBD_Services() );
		$widgets_manager->register( new \IATBD_Brands() );
		$widgets_manager->register( new \IATBD_Process() );
		$widgets_manager->register( new \IATBD_Benefits_Widget() );
		$widgets_manager->register( new \GC_Testimonials_Slider_Widget() );

	}
	

	

	/**
	 * Register Controls
	 *
	 * Load controls files and register new Elementor controls.
	 *
	 * Fired by `elementor/controls/register` action hook.
	 *
	 * @param \Elementor\Controls_Manager $controls_manager Elementor controls manager.
	 */
	public function register_controls( $controls_manager ) {

		// require_once( __DIR__ . '/includes/controls/control-1.php' );
		// require_once( __DIR__ . '/includes/controls/control-2.php' );

		// $controls_manager->register( new \Control_1() );
		// $controls_manager->register( new \Control_2() );

	}

	/**
	 * Register categores
	 * 
	 * Load widgets files and register new Elementor widgets.
	 * 
	 * Fired by `elementor/widgets/register` action hook.
	 * */ 
	public function add_elementor_widget_categories( $elements_manager ) {

		$elements_manager->add_category(
			'iatbd-addons',
			[
				'title' => esc_html__( 'IATBD Addons', 'elementor-test' ),
				'icon' => 'fa fa-plug',
			]
		);	
	}
	
}