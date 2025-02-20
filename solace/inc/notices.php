<?php

// If the class is not found, terminate further execution of the script.
if ( class_exists( 'Solace_Extra_Admin' ) ) {
    return;
}

/**
 * Display admin notice.
 */
function solace_display_admin_notice() {
	$get_cookie_disable_admin_notices = isset( $_COOKIE['solace_disable_admin_notices'] ) ? sanitize_key( $_COOKIE['solace_disable_admin_notices'] ) : '';
	if ( 'disable' === $get_cookie_disable_admin_notices ) {
		return;
	}   
	?>
	<div class="notice-success notice-solace notice is-dismissible" style="width: 100%; padding: 0; background-image: url(<?php echo esc_url( SOLACE_ASSETS_URL . 'img/dashboard/solace-banner-dashboard.jpg' ); ?>); background-position: center; background-repeat: no-repeat; background-size: cover; min-height: 300px; max-height: 400px;">
		<div class="boxes">
			<div class="solace-col-left">
				<h2 class="notice-title"><?php esc_html_e( 'Welcome to Solace Theme! Build Your Stunning Website with Ease', 'solace' ); ?></h2>
				<p class="description"><?php esc_html_e( 'Get started quickly with our Starter Templates and create a professional website in minutes.', 'solace' ); ?></p>
				<div class="notice-actions">
					<button type="button" class="starter-templates"><?php esc_html_e( "Install Starter Templates Now", 'solace' ); ?></button>
					<button type="button" class="activating"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M142.9 142.9c-17.5 17.5-30.1 38-37.8 59.8c-5.9 16.7-24.2 25.4-40.8 19.5s-25.4-24.2-19.5-40.8C55.6 150.7 73.2 122 97.6 97.6c87.2-87.2 228.3-87.5 315.8-1L455 55c6.9-6.9 17.2-8.9 26.2-5.2s14.8 12.5 14.8 22.2l0 128c0 13.3-10.7 24-24 24l-8.4 0c0 0 0 0 0 0L344 224c-9.7 0-18.5-5.8-22.2-14.8s-1.7-19.3 5.2-26.2l41.1-41.1c-62.6-61.5-163.1-61.2-225.3 1zM16 312c0-13.3 10.7-24 24-24l7.6 0 .7 0L168 288c9.7 0 18.5 5.8 22.2 14.8s1.7 19.3-5.2 26.2l-41.1 41.1c62.6 61.5 163.1 61.2 225.3-1c17.5-17.5 30.1-38 37.8-59.8c5.9-16.7 24.2-25.4 40.8-19.5s25.4 24.2 19.5 40.8c-10.8 30.6-28.4 59.3-52.9 83.8c-87.2 87.2-228.3 87.5-315.8 1L57 457c-6.9 6.9-17.2 8.9-26.2 5.2S16 449.7 16 440l0-119.6 0-.7 0-7.6z"/></svg><?php esc_html_e( "Activating...", 'solace' ); ?></button>
				</div>
				<p class="sub-notice-description">
					<?php esc_html_e( 'Got feedback or found a bug?', 'solace' ); ?>
					<a href="<?php echo esc_url('https://solacewp.com/suggestions/'); ?>" target="_blank">
						<?php esc_html_e( 'Let Us Know Here', 'solace' ); ?>
					</a>
				</p>
			</div>
		</div>
	</div>
	<?php
}
add_action( 'admin_notices', 'solace_display_admin_notice' );

/**
 * Callback function for AJAX to dismiss admin notices and set a cookie.
 */
function solace_dismiss_notice_ajax_callback() {
	// Security check: Ensure nonce is valid.
	check_ajax_referer( 'solace-ajax-verification', 'mynonce' );

	// Set a cookie to disable admin notices for 7 days.
	// setcookie( 'solace_disable_admin_notices', 'disable', time() + ( 7 * 24 * 60 * 60 ) );

	// Set a cookie to permanently disable admin notices.
	setcookie( 'solace_disable_admin_notices', 'disable', time() + ( 5 * 365 * 24 * 60 * 60 ) ); // 5 Years.

	// Terminate the AJAX request.
	wp_send_json( array( 'success' => true ) );
	wp_die();
}
add_action( 'wp_ajax_solace_action_dismiss_notice', 'solace_dismiss_notice_ajax_callback' );

/**
 * AJAX callback to install and activate specified plugins if not already active.
 *
 * This function handles the installation and activation of plugins via an AJAX request.
 * It performs a security check with a nonce and checks user permissions before proceeding.
 * If the plugin is installed but inactive, it activates it directly. Otherwise, it downloads
 * and installs the plugin, then activates it.
 *
 * @return void Outputs a JSON response indicating success or error.
 */
function solace_ajax_install_and_activate_plugin() {

	// Security check: Ensure nonce is valid.
	check_ajax_referer( 'solace-ajax-verification', 'mynonce' );

	// Check user capability: Ensure the user has permission to install plugins.
	if ( ! current_user_can( 'install_plugins' ) ) {
		wp_send_json_error( [ 'error' => 'Unauthorized action!' ] );
	}

	// Set a cookie to permanently disable admin notices.
	setcookie( 'solace_disable_admin_notices', 'disable', time() + ( 5 * 365 * 24 * 60 * 60 ) ); // 5 Years.	

	// Define plugins to be installed and/or activated
	// $plugins_to_install = array( 'elementor' );
	$plugins_to_install = array( 'solace-extra' );

	// Load necessary WordPress files for plugin installation if not already included
	if ( ! function_exists( 'plugins_api' ) ) {
		require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
	}
	if ( ! class_exists( 'WP_Upgrader' ) ) {
		require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
	}

	foreach ( $plugins_to_install as $plugin_slug ) {
		// Check if the plugin file exists but is not yet active
		if ( file_exists( WP_PLUGIN_DIR . "/$plugin_slug/$plugin_slug.php" ) ) {
			if ( ! is_plugin_active( "$plugin_slug/$plugin_slug.php" ) ) {
				// Activate the plugin directly if it is installed but inactive
				activate_plugin( "$plugin_slug/$plugin_slug.php" );
			}
		} else {
			// If the plugin is not installed, proceed with the installation process
			$api = plugins_api( 'plugin_information', [ 'slug' => $plugin_slug ] );
			if ( isset( $api->download_link ) ) {
				$plugin_zip = download_url( $api->download_link );
				if ( ! is_wp_error( $plugin_zip ) ) {
					$zip = new ZipArchive;
					if ( $zip->open( $plugin_zip ) === true ) {
						$zip->extractTo( WP_PLUGIN_DIR );
						$zip->close();
						// Delete the downloaded zip file after extraction
						wp_delete_file( $plugin_zip );
						// Activate the plugin after successful installation
						activate_plugin( "$plugin_slug/$plugin_slug.php" );
					}
				}
			}
		}
	}

	// Construct the URL
	$redirect_url = admin_url( 'admin.php?page=solace' );

	// Make a GET request to the URL and check the HTTP response code
	$response = wp_remote_get( $redirect_url );

	if ( ! is_wp_error( $response ) && wp_remote_retrieve_response_code( $response ) === 200 ) {
		// If the response code is 200, redirect the user
		wp_redirect( esc_url( $redirect_url ) );
		exit;
	}	

	// Send a success response back to the AJAX request
	wp_send_json( array( 'success' => true ) );

	// Ensure proper termination of the AJAX request
	wp_die();
}
add_action( 'wp_ajax_solace_action_activating', 'solace_ajax_install_and_activate_plugin' );
