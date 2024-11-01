<?php
/**
 * Functions to register the Voice admin menu.
 *
 * @package voice
 */

namespace Voice;

/**
 * Admin_Menu
 */
class Admin_Menu {

	/**
	 * Define plugin name.
	 *
	 * @var $plugin_name Plugin name.
	 */
	public static $plugin_name = 'Voice';

		/**
		 * Define text domain.
		 *
		 * @var $textdomain Textdomain
		 */
	public static $textdomain = 'voice';

	/**
	 * Define and register singleton.
	 *
	 * @var $instance A single instance of this class object.
	 */
	private static $instance = false;


	/**
	 * Returns a single instance of this class.
	 *
	 * @since 1.0.0
	 */
	public static function instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
			self::$instance->register_hooks();
		}
		return self::$instance;
	}
	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 */
	private function __construct() { }

	/**
	 * Clone
	 *
	 * @since 1.0.0
	 */
	private function __clone() { }

	/**
	 * Add actions and filters
	 *
	 * @uses add_action, add_filter
	 * @since 1.0.0
	 */
	public function register_hooks() {
		add_action( 'admin_menu', array( $this, 'setup_admin_menu' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'voice_admin_enqueue' ) );
	}

	/**
	 * Renders Voice Dashboard page
	 *
	 * @uses add_action, add_filter
	 * @since 1.0.0
	 */
	public function render_dashboard() {
		require_once 'dashboard.php';
	}

	/**
	 * Add menu items to WP-Admin.
	 *
	 * @since 1.0.0
	 */
	public function setup_admin_menu() {
		/**
		 * Settings Page
		 */
		add_menu_page(
			__( 'Voice', 'voice' ),
			// Page Title
			'Voice',
			// Menu Title
			'manage_options',
			// Capability
			'voice',
			// Menus Slug
			array( $this, 'render_dashboard' ),
			// Callable Function
			'dashicons-microphone',
			// Icon URL
			26
			// Position
		);
	}

	/**
	 * Renders Settings page inside of WP-Admin.
	 *
	 * @since 1.0.0
	 */
	public function settings_page() {
		?>
		<div class="voice_wrapper">
			<div class="voice_header">
				<div class="admin-page-title">Voice by Sunbreak Inc.</div>
			</div>
			<div class="voice_section">
			<h1>Settings</h1>
				<h2>Welcome to the first release of Voice!</h2>
				<p>We at <a href="https://sunbreak.io/about" target="_blank">Sunbreak Inc.</a> aim to create an intuitive and hassle-free way to expose your audience to voice technologies.  As a result, you’re already ready to start creating your first Voice Block!</p>
				<p>Simply, head to the <a href="<?php echo esc_url( admin_url( 'post-new.php' ) ); ?>">Editor</a> and click the "<span class="dashicons dashicons-plus-alt"></span>" symbol to get started.</p>

				<h2>Getting Support</h2>
				<p>Your feedback is important to use.  Please <a href="https://sunbreak.io/contact-us" target="_blank">Contact Us</a>, place a <a href="https://sunbreak.io/support/" target="_blank">Support Request</a>, or make a <a href="https://sunbreak.io/feature-request" target="_blank">Feature Request</a>.  We look forward to <i>hearing</i> from you!</p>

				<h2>Learn More</h2>
				<p>Visit our <a href="https://sunbreak.io/glossary/" target="_blank">Voice Glossary</a> for definitions of popular voice terminology or visit our WordPress blog for other helpful strategies for getting your business <i>heard</i>!</p>
			</div>
		</div><!--/.wrap-->
		<?php
	}

	/**
	 * Renders Settings page inside of WP-Admin.
	 *
	 * @since 1.0.0
	 */
	public function dashboard() {
		?>
			<main id="voice-dashboard" class="voice-page mdc-layout-grid">
				<header class="mdc-top-app-bar voice_header">
					<div class="mdc-top-app-bar__row">
						<section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start">
							<a class="header-logo" href="<?php echo esc_url( admin_url( 'admin.php?page=voice' ) ); ?>" rel="home">
								<h1>Voice</h1>
							</a>
						</section>
					</div>
				</header>
			</main>
		<?php
	}

		/**
		 * Enqueues admin styles for Sunbreak WP-Admin pages.
		 *
		 * @since 1.0.0
		 */
	public function voice_admin_enqueue() {
		$dir       = dirname( __FILE__ );
		$style_css = 'css/admin.css';

		wp_register_style(
			'voice_voice_admin_css',
			plugins_url( $style_css, $dir ),
			array(),
			filemtime( dirname( $dir ) . '/' . $style_css )
		);
		wp_enqueue_style( 'voice_voice_admin_css' );
	}

}
Admin_Menu::instance();
