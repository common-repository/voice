<?php

/** Load WordPress dashboard API */
require_once ABSPATH . 'wp-admin/includes/dashboard.php';

// Register Sunbreak widgets
//wp_add_dashboard_widget( 'voice_support-rss-feed', 'Sunbreak Support', 'voice_support_dashboard_widget', 'normal', 'low' );
//wp_add_dashboard_widget( 'voice_voice-blog-rss-feed', 'Sunbreak Voice News', 'voice_voice_blog_dashboard_widget', 'normal', 'high' );
//wp_add_dashboard_widget( 'voice_voice-glossary-rss-feed', 'Voice Glossary', 'voice_voice_glossary_dashboard_widget', 'normal', 'default' );

wp_enqueue_script( 'dashboard' );

global $parent_file;
global $screen;

require_once ABSPATH . 'wp-admin/admin-header.php';
?>

<div class="wrap">
	<h1><?php voice_admin_header(); ?></h1>

	<?php
		$classes = 'welcome-panel';
	?>

	<div id="voice_welcome-panel" class="<?php echo esc_attr( $classes ); ?>">
		<?php wp_nonce_field( 'voice_welcome-panel-nonce', 'sunbreakwelcomepanelnonce', false ); ?>
		<?php
		/**
		 * Add content to the welcome panel on the admin dashboard.
		 *
		 * To remove the default welcome panel, use remove_action():
		 *
		 *     remove_action( 'welcome_panel', 'wp_welcome_panel' );
		 *
		 * @since 3.5.0
		 */
		voice_welcome_panel();
		?>
	</div>

	<div id="dashboard-widgets-wrap">
	<?php wp_dashboard(); ?>
	</div><!-- dashboard-widgets-wrap -->

</div><!-- wrap -->

<?php
wp_print_community_events_templates();

require_once ABSPATH . 'wp-admin/admin-footer.php';


/**
 * Displays a welcome panel to introduce users to Voice.
 *
 * @since 3.3.0
 */
function voice_welcome_panel() {
	?>
	<div class="welcome-panel-content">
	<h2><?php _e( 'Introducing Voice Blocks', 'voice' ); ?></h2>
	<p class="about-description"><?php _e( 'We&#8217;ve put together some information to get you started:', 'voice' ); ?></p>
	<div class="welcome-panel-column-container">
	<div class="welcome-panel-column">
			<h3><?php _e( 'Get Started', 'voice' ); ?></h3>
			<a class="button button-primary button-hero load-customize hide-if-no-customize" href="<?php echo esc_url( admin_url( 'post-new.php' ) ); ?>"><?php esc_html_e( 'Create your first Voice Block', 'voice' ); ?></a>
		<a class="button button-primary button-hero hide-if-customize" href="<?php echo esc_url( admin_url( 'themes.php' ) ); ?>"><?php esc_html_e( 'Customize Your Site', 'voice' ); ?></a>
			<p class="hide-if-no-customize">
			</p>
	</div>
	<div class="welcome-panel-column">
		<h3><?php _e( 'Usage', 'voice' ); ?></h3>
		<ul>
			<li>1. Create a new Voice Block from the 'Add New Block' menu in the WordPress editor.<li>
			<li>2. In the editor, click on ANY block, and then click the 'transform icon' to create a new Voice Block. Voice blocks support multiple blocks so you can create Voice Groups!<li>
		</ul>
	</div>
	<!--
	<div class="welcome-panel-column welcome-panel-last">
		<h3><?php _e( 'Getting Started', 'voice' ); ?></h3>
		<?php voice_getting_started_widget(); ?>
	</div>
	-->
	</div>
	</div>
	<?php
}

/**
 * Renders the Sunbreak WP-Admin header
 *
 * @since 1.0.0
 */
function voice_admin_header() {
	$logo_url = plugin_dir_url( dirname( __FILE__ ) ) . 'img/voice-logo-64.png';
	echo '<div class="voice_admin-header">';
	echo '<img src="' . esc_url( $logo_url ) . '" alt="' . esc_html( 'Voice for WordPress' ) . '"/>';
	echo '</div><!--voice_admin-header-->';
}

/**
 * Renders the Sunbreak RSS Dashboard widgets inner content.
 *
 * @param string $rss URL to RSS feed.
 * @since 1.0.0
 */
function voice_rss_dashboard_widget( $rss ) {
	include_once ABSPATH . WPINC . '/feed.php';
	$maxitems  = $rss->get_item_quantity( 10 );
	$rss_items = $rss->get_items( 0, $maxitems );
	?>
	<ul>
		<?php
		if ( 0 == $maxitems ) {
			echo '<li>No items</li>';
		} else {
			foreach ( $rss_items as $item ) {
				?>
						<li>
							<a href="<?php echo esc_url( $item->get_permalink() ); ?>" target="_blank">
							<?php echo esc_html( $item->get_title() ); ?>
							</a>
						</li>
					<?php
			}
		}
		?>
	</ul>
	<?php
}

/**
 * Displays a dashboard widget to the latest Sunbreak news.
 *
 * @since 1.0.0
 */
function voice_voice_blog_dashboard_widget() {
	$rss = fetch_feed( 'https://sunbreak.io/category/voice/feed/' );
	voice_rss_dashboard_widget( $rss );
}

/**
 * Displays a dashboard widget to the latest voice terminology.
 *
 * @since 1.0.0
 */
function voice_voice_glossary_dashboard_widget() {
	$rss = fetch_feed( 'https://sunbreak.io/topics/voice/feed/' );
	voice_rss_dashboard_widget( $rss );
}

/**
 * Displays a dashboard widget for linking to Sunbreak support.
 *
 * @since 1.0.0
 */
function voice_support_dashboard_widget() {
	$rss = fetch_feed( 'https://support.sunbreak.io/knowledge-base/feed/' );
	voice_rss_dashboard_widget( $rss );
}

/**
 * Displays a dashboard widget to getting started with Voice.
 *
 * @since 1.0.0
 */
function voice_getting_started_widget() {
	$rss = fetch_feed( 'https://support.sunbreak.io/article-categories/getting-started/feed/' );
	voice_rss_dashboard_widget( $rss );
}
