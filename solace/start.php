<?php
/**
 * Start file handles bootstrap.
 *
 * @package Solace
 */

/**
 * Run theme functionality
 */
function solace_run() {
	define(
		'SOLACE_COMPATIBILITY_FEATURES',
		[
			'single_customizer'         => true,
			'repeater_control'          => true,
			'malformed_div_on_shop'     => true,
			'custom_post_types_enh'     => true,
			'mega_menu'                 => true,
			'scroll_to_top_icons'       => true,
			'palette_logo'              => true,
			'custom_icon'               => true,
			'link_control'              => true,
			'page_header_support'       => true,
			'featured_post'             => true,
			'php81_react_ctrls_fix'     => true,
			'gradient_picker'           => true,
			'custom_post_types_sidebar' => true,
			'meta_custom_fields'        => true,
			'sparks'                    => true,
			'advanced_search_component' => true,
			'submenu_style'             => true,
			'blog_hover_effects'        => true,
		]
	);
	$vendor_file = trailingslashit( get_template_directory() ) . 'vendor/autoload.php';
	if ( is_readable( $vendor_file ) ) {
		require_once $vendor_file;
	}

	require_once 'autoloader.php';
	$autoloader = new \Solace\Autoloader();
	$autoloader->add_namespace( 'Solace', get_template_directory() . '/inc/' );

	if ( defined( 'SOLACE_PRO_SPL_ROOT' ) ) {
		$autoloader->add_namespace( 'Solace_Pro', SOLACE_PRO_SPL_ROOT );
	}

	$autoloader->register();

	if ( class_exists( '\\Solace\\Core\\Core_Loader' ) ) {
		new \Solace\Core\Core_Loader();
	}

	if ( class_exists( '\\Solace_Pro\\Core\\Loader' ) ) {
		/**
		 * Legacy code, compatibility with old pro version.
		 */
		if ( is_file( SOLACE_PRO_SPL_ROOT . 'modules/header_footer_grid/components/Language_Switcher.php' ) ) {
			require_once SOLACE_PRO_SPL_ROOT . 'modules/header_footer_grid/components/Language_Switcher.php';
		}
		\Solace_Pro\Core\Loader::instance();
	}
}

solace_run();
