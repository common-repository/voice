<?php
/**
 * Functions to register client-side assets (scripts and stylesheets) for the
 * Gutenberg block.
 *
 * @package voice
 */

namespace Voice;

/**
 * Registers all block assets so that they can be enqueued through Gutenberg in
 * the corresponding context.
 *
 * @see https://wordpress.org/gutenberg/handbook/designers-developers/developers/tutorials/block-tutorial/applying-styles-with-stylesheets/
 */
function voice_block_init() {
	// Skip block registration if Gutenberg is not enabled/merged.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}
	$dir = dirname( __FILE__ );

	$index_js = 'voice/index.js';
	wp_register_script(
		'voice-block-editor',
		plugins_url( $index_js, __FILE__ ),
		array(
			'wp-blocks',
			'wp-i18n',
			'wp-element',
			'wp-editor',
			'integrations',
		),
		filemtime( "$dir/$index_js" ),
		false
	);

	$integrations_js = 'voice/integrations.js';
	wp_register_script(
		'integrations',
		plugins_url( $integrations_js, __FILE__ ),
		array( 'wp-blocks' ),
		filemtime( "$dir/$integrations_js" ),
		true
	);

	$editor_css = '../css/editor.css';
	wp_register_style(
		'voice-block-editor',
		plugins_url( $editor_css, __FILE__ ),
		array(),
		filemtime( "$dir/$editor_css" )
	);

	$style_css = '../css/style.css';
	wp_register_style(
		'voice-block',
		plugins_url( $style_css, __FILE__ ),
		array( 'dashicons' ),
		filemtime( "$dir/$style_css" )
	);

	register_block_type(
		'voice/voice',
		array(
			'editor_script' => 'voice-block-editor',
			'editor_style'  => 'voice-block-editor',
			'style'         => 'voice-block',
		)
	);
}
add_action( 'init', 'Voice\voice_block_init' );


/**
 * Returns Jed-formatted localization data.
 *
 * @since 1.0.0
 *
 * @param string $domain Translation domain.
 * @return array
 */
function get_jed_locale_data( $domain ) {
	$translations = \get_translations_for_domain( $domain );

	$locale = array(
		'domain'      => $domain,
		'locale_data' => array(
			$domain => array(
				'' => array(
					'domain' => $domain,
					'lang'   => \is_admin() ? \get_user_locale() : \get_locale(),
				),
			),
		),
	);

	if ( ! empty( $translations->headers['Plural-Forms'] ) ) {
		$locale['locale_data'][ $domain ]['']['plural_forms'] = $translations->headers['Plural-Forms'];
	}

	foreach ( $translations->entries as $msgid => $entry ) {
		$locale['locale_data'][ $domain ][ $msgid ] = $entry->translations;
	}

	return $locale;
}

/**
 * Enqueues scripts for both the Theme and the block Editor
 */
function voice_enqueue_scripts() {
	// Required for both editor and render.
	wp_enqueue_script( 'integrations' );

	// Export locale data.
	wp_add_inline_script(
		'integrations',
		'wp.voice.setLocaleData( ' . wp_json_encode( get_jed_locale_data( 'integrations' ) ) . ' );',
		'after'
	);

}
add_action( 'enqueue_block_assets', 'Voice\voice_enqueue_scripts' );

