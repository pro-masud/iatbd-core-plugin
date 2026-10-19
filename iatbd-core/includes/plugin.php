<?php 
namespace Elementor_Test;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor_Test / IATBD_Core class.
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
	 * @var \Elementor_Test\Elementor_Test The single instance of the class.
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
	 * @return \Elementor_Test\Elementor_Test An instance of the class.
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
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'iatbd-core' ),
			'<strong>' . esc_html__( 'IATBD Core', 'iatbd-core' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'iatbd-core' ) . '</strong>'
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
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'iatbd-core' ),
			'<strong>' . esc_html__( 'IATBD Core', 'iatbd-core' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'iatbd-core' ) . '</strong>',
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
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'iatbd-core' ),
			'<strong>' . esc_html__( 'IATBD Core', 'iatbd-core' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'iatbd-core' ) . '</strong>',
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
		add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'enqueue_editor_assets' ] );
		add_action( 'elementor/preview/enqueue_styles', [ $this, 'enqueue_frontend_assets' ] );

		/* Ensure Elementor template shortcode [elementor-template id="..."] styles are loaded */
		add_filter( 'do_shortcode_tag', [ $this, 'enqueue_elementor_template_shortcode_styles' ], 10, 3 );
		
		/* Disable Contact Form 7 autop (<p> & <br>) to preserve custom grid layouts */
		add_filter( 'wpcf7_autop_or_not', '__return_false' );

		/* Register elementor widget categories */ 
		add_action( 'elementor/elements/categories_registered', [ $this, 'add_elementor_widget_categories' ] );
	}

	/**
	 * Get base URL for plugin assets
	 */
	private function get_asset_url( $path = '' ) {
		if ( defined( 'IATBD_CORE_URL' ) ) {
			return IATBD_CORE_URL . ltrim( $path, '/' );
		}
		return plugin_dir_url( dirname( __FILE__ ) ) . ltrim( $path, '/' );
	}

	public function enqueue_frontend_assets() {

		// Font Awesome 6
		wp_enqueue_style(
			'iatbd-core-fontawesome',
			'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css',
			[],
			'6.5.1'
		);

		// Google Fonts (Inter + Space Grotesk) - separate unique handle
		wp_enqueue_style(
			'iatbd-core-fonts',
			'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap',
			[],
			null
		);

		// Core plugin Tailwind styles
		wp_enqueue_style(
			'iatbd-core-style',
			$this->get_asset_url( 'assets/css/style.css' ),
			[],
			self::VERSION
		);

		// Custom addon animations and overrides
		wp_enqueue_style(
			'iatbd-core-custom-style',
			$this->get_asset_url( 'assets/css/custom.css' ),
			[ 'iatbd-core-style' ],
			self::VERSION
		);

		// Addon scripts
		wp_enqueue_script(
			'iatbd-core-script',
			$this->get_asset_url( 'assets/js/custom.js' ),
			[ 'jquery' ],
			self::VERSION,
			true
		);
	}

	/**
	 * Enqueue assets inside Elementor Editor preview
	 */
	public function enqueue_editor_assets() {
		wp_enqueue_style(
			'iatbd-core-style',
			$this->get_asset_url( 'assets/css/style.css' ),
			[],
			self::VERSION
		);
		wp_enqueue_style(
			'iatbd-core-custom-style',
			$this->get_asset_url( 'assets/css/custom.css' ),
			[ 'iatbd-core-style' ],
			self::VERSION
		);
	}

	/**
	 * Automatically enqueue Elementor template CSS when [elementor-template id="..."] shortcode is evaluated
	 */
	public function enqueue_elementor_template_shortcode_styles( $output, $tag, $attr ) {
		if ( 'elementor-template' === $tag && ! empty( $attr['id'] ) ) {
			if ( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
				$css_file = new \Elementor\Core\Files\CSS\Post( absint( $attr['id'] ) );
				$css_file->enqueue();
			}
		}
		return $output;
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
		require_once( __DIR__ . '/widgets/class-gc-faq-accordion.php' );
		require_once( __DIR__ . '/widgets/class-gc-related-services.php' );
		require_once( __DIR__ . '/widgets/class-gc-contact-cta.php' );
		require_once( __DIR__ . '/widgets/class-iatbd-plc-hero-widget.php' );
		require_once( __DIR__ . '/widgets/class-iatbd-plc-stats-widget.php' );
		require_once( __DIR__ . '/widgets/class-iatbd-plc-overview-widget.php' );
		require_once( __DIR__ . '/widgets/class-iatbd-plc-services-widget.php' );
		require_once( __DIR__ . '/widgets/class-iatbd-plc-process-widget.php' );
		require_once( __DIR__ . '/widgets/class-iatbd-plc-benefits-widget.php' );
		require_once( __DIR__ . '/widgets/class-iatbd-plc-testimonials-widget.php' );
		require_once( __DIR__ . '/widgets/class-iatbd-plc-faq-widget.php' );
		require_once( __DIR__ . '/widgets/class-iatbd-plc-related-widget.php' );
		require_once( __DIR__ . '/widgets/class-iatbd-store-hero-widget.php' );
		require_once( __DIR__ . '/widgets/class-iatbd-store-benefits-widget.php' );
		require_once( __DIR__ . '/widgets/class-iatbd-store-products-widget.php' );
		require_once( __DIR__ . '/widgets/class-iatbd-store-cta-widget.php' );
		require_once( __DIR__ . '/widgets/class-iatbd-hmi-hero-widget.php' );
		require_once( __DIR__ . '/widgets/class-iatbd-hmi-stats-widget.php' );
		require_once( __DIR__ . '/widgets/class-iatbd-hmi-overview-widget.php' );
		require_once( __DIR__ . '/widgets/class-iatbd-hmi-services-widget.php' );
		require_once( __DIR__ . '/widgets/class-iatbd-hmi-process-widget.php' );
		require_once( __DIR__ . '/widgets/class-iatbd-hmi-benefits-widget.php' );
		require_once( __DIR__ . '/widgets/class-iatbd-hero-slider.php' );
		require_once( __DIR__ . '/widgets/class-iatbd-stats-bar.php' );
		require_once( __DIR__ . '/widgets/iatbd-solutions-widget.php' );
		require_once( __DIR__ . '/widgets/class-gc-ai-automation.php' );
		require_once( __DIR__ . '/widgets/class-gc-industrial-cta.php' );
		require_once( __DIR__ . '/widgets/class-gc-contact-section.php' );
		require_once( __DIR__ . '/widgets/class-gc-blog-archive.php' );
		require_once( __DIR__ . '/widgets/class-gc-blog-single.php' );
		require_once( __DIR__ . '/widgets/class-gc-search-results.php' );
		require_once( __DIR__ . '/widgets/class-gc-maintenance-hero.php' );
		require_once( __DIR__ . '/widgets/class-gc-stats-bar.php' );
		require_once( __DIR__ . '/widgets/gc-service-cards-widget.php' );
		require_once( __DIR__ . '/widgets/class-brands-marquee-widget.php' );
		require_once( __DIR__ . '/widgets/class-repair-brands-marquee-widget.php' );
		require_once( __DIR__ . '/widgets/class-maintenance-process-widget.php' );

		// Header & Footer
		if ( class_exists( '\IATBD_Header_Widget' ) ) {
			$widgets_manager->register( new \IATBD_Header_Widget() );
		} elseif ( class_exists( '\Widget_1' ) ) {
			$widgets_manager->register( new \Widget_1() );
		}

		$widgets_manager->register( new \IATBD_Footer() );
		$widgets_manager->register( new \IATBD_Servo_Hero() );
		$widgets_manager->register( new \IATBD_Counter() );
		$widgets_manager->register( new \IATBD_Overview() );
		$widgets_manager->register( new \IATBD_Services() );
		$widgets_manager->register( new \IATBD_Brands() );
		$widgets_manager->register( new \IATBD_Process() );
		$widgets_manager->register( new \IATBD_Benefits_Widget() );

		if ( class_exists( '\IATBD_Testimonials_Slider_Widget' ) ) {
			$widgets_manager->register( new \IATBD_Testimonials_Slider_Widget() );
		} elseif ( class_exists( '\GC_Testimonials_Slider_Widget' ) ) {
			$widgets_manager->register( new \GC_Testimonials_Slider_Widget() );
		}

		$widgets_manager->register( new \GC_FAQ_Accordion_Widget() );
		$widgets_manager->register( new \GC_Related_Services_Widget() );
		$widgets_manager->register( new \GC_Contact_CTA_Widget() );

		// PLC Widgets
		$widgets_manager->register( new \IATBD_PLC_Hero_Widget() );
		$widgets_manager->register( new \IATBD_PLC_Stats_Widget() );
		$widgets_manager->register( new \IATBD_PLC_Overview_Widget() );
		$widgets_manager->register( new \IATBD_PLC_Services_Widget() );
		$widgets_manager->register( new \IATBD_PLC_Process_Widget() );
		$widgets_manager->register( new \IATBD_PLC_Benefits_Widget() );
		$widgets_manager->register( new \IATBD_PLC_Testimonials_Widget() );
		$widgets_manager->register( new \IATBD_PLC_FAQ_Widget() );
		$widgets_manager->register( new \IATBD_PLC_Related_Widget() );

		// Store Widgets
		$widgets_manager->register( new \IATBD_Store_Hero_Widget() );
		$widgets_manager->register( new \IATBD_Store_Benefits_Widget() );
		$widgets_manager->register( new \IATBD_Store_Products_Widget() );
		$widgets_manager->register( new \IATBD_Store_CTA_Widget() );

		// HMI Widgets
		$widgets_manager->register( new \IATBD_HMI_Hero_Widget() );
		$widgets_manager->register( new \IATBD_HMI_Stats_Widget() );
		$widgets_manager->register( new \IATBD_HMI_Overview_Widget() );
		$widgets_manager->register( new \IATBD_HMI_Services_Widget() );
		$widgets_manager->register( new \IATBD_HMI_Process_Widget() );
		$widgets_manager->register( new \IATBD_HMI_Benefits_Widget() );

		// Shared & Extra Widgets
		$widgets_manager->register( new \IATBD_Hero_Slider_Widget() );
		$widgets_manager->register( new \IATBD_Stats_Bar_Widget() );
		$widgets_manager->register( new \IATBD_Solutions_Widget() );
		$widgets_manager->register( new \GC_AI_Automation_Widget() );
		$widgets_manager->register( new \GC_Industrial_CTA_Widget() );

		// Register the GC_Contact_Section_Widget if it exists
		$widgets_manager->register( new \GC_Contact_Section_Widget() );
		$widgets_manager->register( new \GC_Blog_Archive_Widget() );
		$widgets_manager->register( new \GC_Blog_Single_Widget() );
		$widgets_manager->register( new \GC_Search_Results_Widget() );


		$widgets_manager->register( new \GC_Maintenance_Hero_Widget() );
		$widgets_manager->register( new \GC_Stats_Bar_Widget() );
		$widgets_manager->register( new \GC_Service_Cards_Widget() );
		$widgets_manager->register( new \IATBD_Brands_Marquee_Widget() );
		$widgets_manager->register( new \IATBD_Repair_Brands_Marquee_Widget() );
		$widgets_manager->register( new \IATBD_Maintenance_Process_Widget() );
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
		// Reserved for custom Elementor controls if needed
	}

	/**
	 * Register categories
	 * 
	 * Load widgets categories for Elementor.
	 * 
	 * Fired by `elementor/elements/categories_registered` action hook.
	 */ 
	public function add_elementor_widget_categories( $elements_manager ) {

		$elements_manager->add_category(
			'iatbd-addons',
			[
				'title' => esc_html__( 'IATBD Addons', 'iatbd-core' ),
				'icon'  => 'fa fa-plug',
			]
		);

		// Fallback category alias so legacy GC widgets are never uncategorized
		$elements_manager->add_category(
			'gc_widgets',
			[
				'title' => esc_html__( 'IATBD Extra Widgets', 'iatbd-core' ),
				'icon'  => 'fa fa-cubes',
			]
		);
	}
	
}

// Global class alias for backward compatibility
if ( ! class_exists( 'IATBD_Core' ) ) {
	class_alias( '\Elementor_Test\Elementor_Test', 'IATBD_Core' );
}