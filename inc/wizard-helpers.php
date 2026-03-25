<?php
/**
 * EKWA Wizard Helper Functions
 *
 * Helper functions for managing the plugin installation wizard
 *
 * @package ekwa
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Reset the plugin wizard
 * This allows the wizard to be shown again
 * Useful for testing or re-running the wizard
 */
function ekwa_reset_wizard() {
	delete_option( 'ekwa_wizard_completed' );
	delete_option( 'ekwa_wizard_skipped' );
	delete_transient( 'ekwa_activation_redirect' );

	return true;
}

/**
 * Check if wizard has been completed
 *
 * @return bool True if wizard is completed
 */
function ekwa_is_wizard_completed() {
	return (bool) get_option( 'ekwa_wizard_completed' );
}

/**
 * Check if wizard was skipped
 *
 * @return bool True if wizard was skipped
 */
function ekwa_is_wizard_skipped() {
	return (bool) get_option( 'ekwa_wizard_skipped' );
}

/**
 * Force show wizard on next admin page load
 * Sets the activation redirect transient
 */
function ekwa_force_wizard_redirect() {
	set_transient( 'ekwa_activation_redirect', true, 30 );
}

/**
 * Get wizard URL
 *
 * @return string URL to the wizard page
 */
function ekwa_get_wizard_url() {
	return admin_url( 'themes.php?page=ekwa-plugin-wizard' );
}

/**
 * Admin bar menu item to access wizard
 */
function ekwa_wizard_admin_bar_menu( $wp_admin_bar ) {
	if ( ! current_user_can( 'install_plugins' ) ) {
		return;
	}

	$wp_admin_bar->add_node( array(
		'id'     => 'ekwa-plugin-wizard',
		'parent' => 'appearance',
		'title'  => __( 'Plugin Setup Wizard', 'ekwa' ),
		'href'   => ekwa_get_wizard_url(),
	) );
}
add_action( 'admin_bar_menu', 'ekwa_wizard_admin_bar_menu', 100 );

/**
 * Add reset wizard action to admin
 * Accessible via URL parameter: ?ekwa_reset_wizard=1
 */
function ekwa_handle_wizard_reset() {
	if ( ! isset( $_GET['ekwa_reset_wizard'] ) ) {
		return;
	}

	if ( ! current_user_can( 'install_plugins' ) ) {
		wp_die( __( 'You do not have permission to reset the wizard.', 'ekwa' ) );
	}

	// Verify nonce if provided
	if ( isset( $_GET['_wpnonce'] ) && ! wp_verify_nonce( $_GET['_wpnonce'], 'ekwa_reset_wizard' ) ) {
		wp_die( __( 'Security check failed.', 'ekwa' ) );
	}

	ekwa_reset_wizard();

	// Redirect to wizard
	wp_safe_redirect( ekwa_get_wizard_url() );
	exit;
}
add_action( 'admin_init', 'ekwa_handle_wizard_reset' );

/**
 * Add settings link on plugins page
 */
function ekwa_wizard_settings_link( $links ) {
	$wizard_link = sprintf(
		'<a href="%s">%s</a>',
		ekwa_get_wizard_url(),
		__( 'Setup Wizard', 'ekwa' )
	);

	array_unshift( $links, $wizard_link );

	return $links;
}
// This would be used if EKWA was a plugin, but keeping for reference

/**
 * Debug function - shows wizard status
 * Add ?ekwa_wizard_debug=1 to any admin URL
 */
function ekwa_wizard_debug() {
	if ( ! isset( $_GET['ekwa_wizard_debug'] ) || ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$wizard = EKWA_Plugin_Wizard::get_instance();

	echo '<div class="notice notice-info" style="padding: 20px;">';
	echo '<h2>EKWA Wizard Debug Info</h2>';
	echo '<ul style="list-style: disc; margin-left: 20px;">';
	echo '<li><strong>Wizard Completed:</strong> ' . ( ekwa_is_wizard_completed() ? 'Yes' : 'No' ) . '</li>';
	echo '<li><strong>Wizard Skipped:</strong> ' . ( ekwa_is_wizard_skipped() ? 'Yes' : 'No' ) . '</li>';
	echo '<li><strong>Should Show Wizard:</strong> ' . ( $wizard->should_show_wizard() ? 'Yes' : 'No' ) . '</li>';
	echo '<li><strong>Activation Redirect Set:</strong> ' . ( get_transient( 'ekwa_activation_redirect' ) ? 'Yes' : 'No' ) . '</li>';
	echo '<li><strong>Wizard URL:</strong> <a href="' . ekwa_get_wizard_url() . '">' . ekwa_get_wizard_url() . '</a></li>';

	$reset_url = wp_nonce_url(
		add_query_arg( 'ekwa_reset_wizard', '1', admin_url() ),
		'ekwa_reset_wizard'
	);
	echo '<li><strong>Reset Wizard:</strong> <a href="' . $reset_url . '" class="button">Click to Reset</a></li>';

	echo '</ul>';

	// Check plugin status
	echo '<h3>Required Plugins Status</h3>';
	echo '<ul style="list-style: disc; margin-left: 20px;">';
	echo '<li><strong>ACF Pro:</strong> ' . ( class_exists( 'ACF' ) ? '✅ Installed' : '❌ Not Found' ) . '</li>';
	echo '<li><strong>Kirki:</strong> ' . ( class_exists( 'Kirki' ) ? '✅ Installed' : '❌ Not Found' ) . '</li>';
	echo '</ul>';

	echo '</div>';
}
add_action( 'admin_notices', 'ekwa_wizard_debug', 999 );

/**
 * WP-CLI command to reset wizard
 * Usage: wp ekwa wizard reset
 */
if ( defined( 'WP_CLI' ) && WP_CLI ) {
	WP_CLI::add_command( 'ekwa wizard', function( $args, $assoc_args ) {
		if ( empty( $args[0] ) ) {
			WP_CLI::error( 'Please specify an action: reset' );
			return;
		}

		switch ( $args[0] ) {
			case 'reset':
				ekwa_reset_wizard();
				WP_CLI::success( 'Wizard has been reset. Visit ' . ekwa_get_wizard_url() . ' to run it again.' );
				break;

			case 'status':
				WP_CLI::line( 'Wizard Status:' );
				WP_CLI::line( '- Completed: ' . ( ekwa_is_wizard_completed() ? 'Yes' : 'No' ) );
				WP_CLI::line( '- Skipped: ' . ( ekwa_is_wizard_skipped() ? 'Yes' : 'No' ) );
				WP_CLI::line( '- URL: ' . ekwa_get_wizard_url() );
				break;

			default:
				WP_CLI::error( 'Unknown action. Available actions: reset, status' );
		}
	} );
}

/* =====================================================================
 * Site Setup Wizard helpers
 * ===================================================================*/

/**
 * Check if site setup has been completed.
 *
 * @return bool
 */
function ekwa_is_site_setup_completed() {
	return (bool) get_option( 'ekwa_site_setup_completed' );
}

/**
 * Reset the site setup wizard so it appears again.
 */
function ekwa_reset_site_setup() {
	delete_option( 'ekwa_site_setup_completed' );
}

/**
 * URL to the site setup wizard page.
 *
 * @return string
 */
function ekwa_get_site_setup_url() {
	return admin_url( 'themes.php?page=ekwa-site-setup' );
}

/**
 * Admin-bar link for quick access.
 */
function ekwa_site_setup_admin_bar( $wp_admin_bar ) {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$wp_admin_bar->add_node( array(
		'id'     => 'ekwa-site-setup',
		'parent' => 'appearance',
		'title'  => __( 'Site Setup Wizard', 'ekwa' ),
		'href'   => ekwa_get_site_setup_url(),
	) );
}
add_action( 'admin_bar_menu', 'ekwa_site_setup_admin_bar', 101 );

/**
 * URL-based reset: ?ekwa_reset_site_setup=1
 */
function ekwa_handle_site_setup_reset() {
	if ( ! isset( $_GET['ekwa_reset_site_setup'] ) ) {
		return;
	}
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'Insufficient permissions.', 'ekwa' ) );
	}
	if ( isset( $_GET['_wpnonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ), 'ekwa_reset_site_setup' ) ) {
		wp_die( esc_html__( 'Security check failed.', 'ekwa' ) );
	}
	ekwa_reset_site_setup();
	wp_safe_redirect( ekwa_get_site_setup_url() );
	exit;
}
add_action( 'admin_init', 'ekwa_handle_site_setup_reset' );
