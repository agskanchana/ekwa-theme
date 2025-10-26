<?php
/**
 * EKWA Plugin Installation Wizard
 *
 * Handles installation of required plugins on theme activation
 * Supports both WordPress.org plugins and bundled mu-plugins
 *
 * @package ekwa
 */

if ( ! class_exists( 'EKWA_Plugin_Wizard' ) ) {

	class EKWA_Plugin_Wizard {

		/**
		 * WordPress.org plugins (downloadable from repository)
		 */
		private $wp_org_plugins = array();

		/**
		 * Bundled plugins (included in theme's mu-plugins folder)
		 */
		private $bundled_plugins = array();

		/**
		 * Instance
		 */
		private static $instance = null;

		/**
		 * Get instance
		 */
		public static function get_instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * Constructor
		 */
		private function __construct() {
			// Define WordPress.org plugins
			$this->wp_org_plugins = apply_filters( 'ekwa_wp_org_plugins', array(
				array(
					'name'     => 'Kirki Customizer Framework',
					'slug'     => 'kirki',
					'required' => true,
					'version'  => '3.1.3',
				),
				array(
					'name'     => 'Yoast SEO',
					'slug'     => 'wordpress-seo',
					'required' => true,
					'version'  => '14.3',
				),
				array(
					'name'     => 'Duplicate Post Page Menu & Custom Post Type',
					'slug'     => 'duplicate-post-page-menu-custom-post-type',
					'required' => false,
					'version'  => '3.2.5',
				),
				array(
					'name'     => 'Rename wp-login.php',
					'slug'     => 'rename-wp-login',
					'required' => false,
					'version'  => '2.6.0',
				),
				array(
					'name'     => 'Limit Login Attempts Reloaded',
					'slug'     => 'limit-login-attempts-reloaded',
					'required' => false,
					'version'  => '2.13.0',
				),
				array(
					'name'     => 'Duplicate Menu',
					'slug'     => 'duplicate-menu',
					'required' => false,
					'version'  => '0.2.2',
				),
				array(
					'name'     => 'Wordfence Security – Firewall & Malware Scan',
					'slug'     => 'wordfence',
					'required' => false,
					'version'  => '7.5.9',
				),
			) );

		// Define bundled plugins
		$this->bundled_plugins = apply_filters( 'ekwa_bundled_plugins', array(
			array(
				'name'     => 'Advanced Custom Fields PRO',
				'slug'     => 'advanced-custom-fields-pro',
				'file'     => 'advanced-custom-fields-pro.zip',
				'source'   => 'local',
				'required' => true,
			),
			array(
				'name'     => 'Wufoo Form Builder',
				'slug'     => 'wufoo-form-builder-main',
				'source'   => 'github',
				'github_url' => 'https://github.com/agskanchana/wufoo-form-builder/archive/refs/heads/main.zip',
				'required' => true,
			),
			array(
				'name'     => 'Load Scripts from SW',
				'slug'     => 'load-scripts-from-sw-master',
				'source'   => 'github',
				'github_url' => 'https://github.com/agskanchana/load-scripts-from-sw/archive/refs/heads/master.zip',
				'required' => true,
			),
			array(
				'name'     => 'EKWA Related Articles',
				'slug'     => 'ekwa-related-articles-main',
				'source'   => 'github',
				'github_url' => 'https://github.com/agskanchana/ekwa-related-articles/archive/refs/heads/main.zip',
				'required' => false,
			),
		) );			// Admin hooks
			add_action( 'admin_menu', array( $this, 'add_wizard_page' ) );
			add_action( 'admin_init', array( $this, 'wizard_redirect' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
			add_action( 'admin_notices', array( $this, 'admin_notices' ) );

			// AJAX handlers
			add_action( 'wp_ajax_ekwa_install_wp_plugin', array( $this, 'ajax_install_wp_plugin' ) );
			add_action( 'wp_ajax_ekwa_install_bundled_plugin', array( $this, 'ajax_install_bundled_plugin' ) );
			add_action( 'wp_ajax_ekwa_activate_plugin', array( $this, 'ajax_activate_plugin' ) );
			add_action( 'wp_ajax_ekwa_skip_wizard', array( $this, 'ajax_skip_wizard' ) );
			add_action( 'wp_ajax_ekwa_complete_wizard', array( $this, 'ajax_complete_wizard' ) );
		}

		/**
		 * Check if wizard should be shown
		 *
		 * Note: This now checks ONLY if required plugins are active.
		 * The wizard will always show if ACF Pro or Kirki are missing,
		 * regardless of whether the user previously completed or skipped it.
		 * This ensures the wizard runs every time the theme is activated
		 * if required plugins are not present.
		 */
		public function should_show_wizard() {
			// Check if required plugins are installed and active
			$required_installed = true;

			// Check ACF Pro
			if ( ! class_exists( 'ACF' ) ) {
				$required_installed = false;
			}

			// Check Kirki
			if ( ! class_exists( 'Kirki' ) ) {
				$required_installed = false;
			}

			// If required plugins are missing, show wizard regardless of completion status
			if ( ! $required_installed ) {
				return true;
			}

			// If all required plugins are active, don't show wizard
			return false;
		}

		/**
		 * Redirect to wizard on theme activation
		 */
		public function wizard_redirect() {
			// Only redirect once
			if ( get_transient( 'ekwa_activation_redirect' ) ) {
				delete_transient( 'ekwa_activation_redirect' );

				if ( $this->should_show_wizard() && ! isset( $_GET['activate-multi'] ) ) {
					wp_safe_redirect( admin_url( 'themes.php?page=ekwa-plugin-wizard' ) );
					exit;
				}
			}
		}

		/**
		 * Add wizard page to admin menu
		 */
		public function add_wizard_page() {
			add_theme_page(
				__( 'EKWA Plugin Installation', 'ekwa' ),
				__( 'Plugin Setup', 'ekwa' ),
				'install_plugins',
				'ekwa-plugin-wizard',
				array( $this, 'render_wizard_page' )
			);
		}

		/**
		 * Enqueue scripts and styles
		 */
		public function enqueue_scripts( $hook ) {
			if ( 'appearance_page_ekwa-plugin-wizard' !== $hook ) {
				return;
			}

			wp_enqueue_style( 'ekwa-wizard', get_template_directory_uri() . '/inc/wizard-assets/wizard.css', array(), '1.0.0' );
			wp_enqueue_script( 'ekwa-wizard', get_template_directory_uri() . '/inc/wizard-assets/wizard.js', array( 'jquery' ), '1.0.0', true );

			wp_localize_script( 'ekwa-wizard', 'ekwaWizard', array(
				'ajaxurl'         => admin_url( 'admin-ajax.php' ),
				'adminUrl'        => admin_url(),
				'nonce'           => wp_create_nonce( 'ekwa_wizard_nonce' ),
				'installing'      => __( 'Installing...', 'ekwa' ),
				'activating'      => __( 'Activating...', 'ekwa' ),
				'success'         => __( 'Success!', 'ekwa' ),
				'error'           => __( 'Error', 'ekwa' ),
				'plugin_error'    => __( 'Plugin installation failed. Please try manually.', 'ekwa' ),
				'wp_org_plugins'  => $this->wp_org_plugins,
				'bundled_plugins' => $this->bundled_plugins,
			) );
		}

		/**
		 * Show admin notices if wizard not completed
		 */
		public function admin_notices() {
			if ( ! $this->should_show_wizard() ) {
				return;
			}

			$screen = get_current_screen();
			if ( 'appearance_page_ekwa-plugin-wizard' === $screen->id ) {
				return;
			}

			?>
			<div class="notice notice-warning is-dismissible">
				<p>
					<strong><?php esc_html_e( 'EKWA Theme:', 'ekwa' ); ?></strong>
					<?php esc_html_e( 'Required plugins are not installed. Please complete the setup wizard.', 'ekwa' ); ?>
				</p>
				<p>
					<a href="<?php echo esc_url( admin_url( 'themes.php?page=ekwa-plugin-wizard' ) ); ?>" class="button button-primary">
						<?php esc_html_e( 'Run Setup Wizard', 'ekwa' ); ?>
					</a>
				</p>
			</div>
			<?php
		}

		/**
		 * Render wizard page
		 */
		public function render_wizard_page() {
			?>
			<div class="ekwa-wizard-wrap">
				<div class="ekwa-wizard-container">
					<div class="ekwa-wizard-header">
						<h1><?php esc_html_e( 'Welcome to EKWA Theme', 'ekwa' ); ?></h1>
						<p><?php esc_html_e( 'This wizard will help you install required plugins for the theme to work properly.', 'ekwa' ); ?></p>
					</div>

					<div class="ekwa-wizard-steps">
						<div class="ekwa-step active" data-step="1">
							<span class="step-number">1</span>
							<span class="step-title"><?php esc_html_e( 'Required Plugins', 'ekwa' ); ?></span>
						</div>
						<div class="ekwa-step" data-step="2">
							<span class="step-number">2</span>
							<span class="step-title"><?php esc_html_e( 'Optional Plugins', 'ekwa' ); ?></span>
						</div>
						<div class="ekwa-step" data-step="3">
							<span class="step-number">3</span>
							<span class="step-title"><?php esc_html_e( 'Complete', 'ekwa' ); ?></span>
						</div>
					</div>

					<div class="ekwa-wizard-content">
						<!-- Step 1: Required Plugins -->
						<div class="ekwa-wizard-step-content" id="step-1">
							<h2><?php esc_html_e( 'Required Plugins', 'ekwa' ); ?></h2>
							<p><?php esc_html_e( 'These plugins are essential for the theme to function correctly.', 'ekwa' ); ?></p>

							<div class="ekwa-plugins-list">
								<?php $this->render_bundled_required_plugins(); ?>
								<?php $this->render_wp_org_required_plugins(); ?>
							</div>

							<div class="ekwa-wizard-actions">
								<button class="button button-primary button-hero" id="install-required">
									<?php esc_html_e( 'Install Required Plugins', 'ekwa' ); ?>
								</button>
							</div>
						</div>

						<!-- Step 2: Optional Plugins -->
						<div class="ekwa-wizard-step-content" id="step-2" style="display:none;">
							<h2><?php esc_html_e( 'Optional Plugins', 'ekwa' ); ?></h2>
							<p><?php esc_html_e( 'These plugins add additional functionality to your website.', 'ekwa' ); ?></p>

							<div class="ekwa-plugins-list">
								<?php $this->render_bundled_optional_plugins(); ?>
								<?php $this->render_wp_org_optional_plugins(); ?>
							</div>

							<div class="ekwa-wizard-actions">
								<button class="button button-primary button-hero" id="install-optional">
									<?php esc_html_e( 'Install Selected Plugins', 'ekwa' ); ?>
								</button>
								<button class="button button-secondary button-hero" id="skip-optional">
									<?php esc_html_e( 'Skip Optional Plugins', 'ekwa' ); ?>
								</button>
							</div>
						</div>

						<!-- Step 3: Complete -->
						<div class="ekwa-wizard-step-content" id="step-3" style="display:none;">
							<div class="ekwa-wizard-complete">
								<div class="ekwa-complete-icon">✓</div>
								<h2><?php esc_html_e( 'Setup Complete!', 'ekwa' ); ?></h2>
								<p><?php esc_html_e( 'All required plugins have been installed successfully.', 'ekwa' ); ?></p>
								<a href="<?php echo esc_url( admin_url() ); ?>" class="button button-primary button-hero">
									<?php esc_html_e( 'Go to Dashboard', 'ekwa' ); ?>
								</a>
							</div>
						</div>
					</div>

					<div class="ekwa-wizard-footer">
						<a href="#" id="skip-wizard"><?php esc_html_e( 'Skip this wizard and set up later', 'ekwa' ); ?></a>
					</div>
				</div>
			</div>
			<?php
		}

		/**
		 * Render required bundled plugins
		 */
		private function render_bundled_required_plugins() {
			foreach ( $this->bundled_plugins as $plugin ) {
				if ( ! $plugin['required'] ) {
					continue;
				}

				$status = $this->get_bundled_plugin_status( $plugin );
				$this->render_plugin_item( $plugin, $status, 'bundled', true );
			}
		}

		/**
		 * Render required WP.org plugins
		 */
		private function render_wp_org_required_plugins() {
			foreach ( $this->wp_org_plugins as $plugin ) {
				if ( ! $plugin['required'] ) {
					continue;
				}

				$status = $this->get_wp_plugin_status( $plugin );
				$this->render_plugin_item( $plugin, $status, 'wporg', true );
			}
		}

		/**
		 * Render optional bundled plugins
		 */
		private function render_bundled_optional_plugins() {
			foreach ( $this->bundled_plugins as $plugin ) {
				if ( $plugin['required'] ) {
					continue;
				}

				$status = $this->get_bundled_plugin_status( $plugin );
				$this->render_plugin_item( $plugin, $status, 'bundled', false );
			}
		}

		/**
		 * Render optional WP.org plugins
		 */
		private function render_wp_org_optional_plugins() {
			foreach ( $this->wp_org_plugins as $plugin ) {
				if ( $plugin['required'] ) {
					continue;
				}

				$status = $this->get_wp_plugin_status( $plugin );
				$this->render_plugin_item( $plugin, $status, 'wporg', false );
			}
		}

		/**
		 * Render a plugin item
		 */
		private function render_plugin_item( $plugin, $status, $type, $required ) {
			$status_class = 'status-' . $status;
			$checked = ! $required ? 'checked' : '';
			$disabled = $status === 'active' ? 'disabled' : '';
			?>
			<div class="ekwa-plugin-item <?php echo esc_attr( $status_class ); ?>" data-slug="<?php echo esc_attr( $plugin['slug'] ); ?>" data-type="<?php echo esc_attr( $type ); ?>">
				<?php if ( ! $required ) : ?>
					<input type="checkbox" <?php echo $checked; ?> <?php echo $disabled; ?> />
				<?php endif; ?>
				<div class="plugin-info">
					<h4><?php echo esc_html( $plugin['name'] ); ?></h4>
					<?php if ( $required ) : ?>
						<span class="required-badge"><?php esc_html_e( 'Required', 'ekwa' ); ?></span>
					<?php endif; ?>
				</div>
				<div class="plugin-status">
					<span class="status-text">
						<?php
						switch ( $status ) {
							case 'active':
								esc_html_e( 'Active', 'ekwa' );
								break;
							case 'inactive':
								esc_html_e( 'Installed', 'ekwa' );
								break;
							default:
								esc_html_e( 'Not Installed', 'ekwa' );
						}
						?>
					</span>
					<span class="spinner"></span>
				</div>
			</div>
			<?php
		}

		/**
		 * Get WP.org plugin status
		 */
		private function get_wp_plugin_status( $plugin ) {
			if ( ! function_exists( 'get_plugins' ) ) {
				require_once ABSPATH . 'wp-admin/includes/plugin.php';
			}

			$installed_plugins = get_plugins();
			$plugin_file = $this->get_plugin_file( $plugin['slug'] );

			if ( ! $plugin_file ) {
				return 'not-installed';
			}

			if ( is_plugin_active( $plugin_file ) ) {
				return 'active';
			}

			return 'inactive';
		}

		/**
		 * Get bundled plugin status
		 */
		private function get_bundled_plugin_status( $plugin ) {
			if ( ! function_exists( 'get_plugins' ) ) {
				require_once ABSPATH . 'wp-admin/includes/plugin.php';
			}

			$installed_plugins = get_plugins();
			$plugin_file = $this->get_plugin_file( $plugin['slug'] );

			if ( ! $plugin_file ) {
				return 'not-installed';
			}

			if ( is_plugin_active( $plugin_file ) ) {
				return 'active';
			}

			return 'inactive';
		}

		/**
		 * Get plugin file path
		 */
		private function get_plugin_file( $slug ) {
			if ( ! function_exists( 'get_plugins' ) ) {
				require_once ABSPATH . 'wp-admin/includes/plugin.php';
			}

			$plugins = get_plugins();

			foreach ( $plugins as $plugin_file => $plugin_info ) {
				if ( strpos( $plugin_file, $slug . '/' ) === 0 ) {
					return $plugin_file;
				}
			}

			return false;
		}

		/**
		 * AJAX: Install WordPress.org plugin
		 */
		public function ajax_install_wp_plugin() {
			check_ajax_referer( 'ekwa_wizard_nonce', 'nonce' );

			if ( ! current_user_can( 'install_plugins' ) ) {
				wp_send_json_error( array( 'message' => __( 'You do not have permission to install plugins.', 'ekwa' ) ) );
			}

			$slug = sanitize_text_field( $_POST['slug'] );

			require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
			require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
			require_once ABSPATH . 'wp-admin/includes/class-plugin-upgrader.php';

			$api = plugins_api( 'plugin_information', array(
				'slug'   => $slug,
				'fields' => array( 'sections' => false ),
			) );

			if ( is_wp_error( $api ) ) {
				wp_send_json_error( array( 'message' => $api->get_error_message() ) );
			}

			$upgrader = new Plugin_Upgrader( new WP_Ajax_Upgrader_Skin() );
			$result   = $upgrader->install( $api->download_link );

			if ( is_wp_error( $result ) ) {
				wp_send_json_error( array( 'message' => $result->get_error_message() ) );
			}

			wp_send_json_success( array( 'message' => __( 'Plugin installed successfully.', 'ekwa' ) ) );
		}

	/**
	 * AJAX: Install bundled plugin
	 */
	public function ajax_install_bundled_plugin() {
		check_ajax_referer( 'ekwa_wizard_nonce', 'nonce' );

		if ( ! current_user_can( 'install_plugins' ) ) {
			wp_send_json_error( array( 'message' => __( 'You do not have permission to install plugins.', 'ekwa' ) ) );
		}

		$slug = sanitize_text_field( $_POST['slug'] );

		// Find plugin info
		$plugin_info = null;
		foreach ( $this->bundled_plugins as $plugin ) {
			if ( $plugin['slug'] === $slug ) {
				$plugin_info = $plugin;
				break;
			}
		}

		if ( ! $plugin_info ) {
			wp_send_json_error( array( 'message' => __( 'Plugin not found.', 'ekwa' ) ) );
		}

		// Determine source and get zip file location
		if ( isset( $plugin_info['source'] ) && $plugin_info['source'] === 'github' ) {
			// Download from GitHub
			$download_url = $plugin_info['github_url'];
		} else {
			// Use local zip file
			$download_url = get_template_directory() . '/mu-plugins/' . $plugin_info['file'];

			if ( ! file_exists( $download_url ) ) {
				wp_send_json_error( array( 'message' => __( 'Plugin file not found.', 'ekwa' ) ) );
			}
		}

		require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
		require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
		require_once ABSPATH . 'wp-admin/includes/file.php';

		$upgrader = new Plugin_Upgrader( new WP_Ajax_Upgrader_Skin() );
		$result   = $upgrader->install( $download_url );

		if ( is_wp_error( $result ) ) {
			wp_send_json_error( array( 'message' => $result->get_error_message() ) );
		}

		wp_send_json_success( array( 'message' => __( 'Plugin installed successfully.', 'ekwa' ) ) );
	}		/**
		 * AJAX: Activate plugin
		 */
		public function ajax_activate_plugin() {
			check_ajax_referer( 'ekwa_wizard_nonce', 'nonce' );

			if ( ! current_user_can( 'activate_plugins' ) ) {
				wp_send_json_error( array( 'message' => __( 'You do not have permission to activate plugins.', 'ekwa' ) ) );
			}

			$slug = sanitize_text_field( $_POST['slug'] );
			$plugin_file = $this->get_plugin_file( $slug );

			if ( ! $plugin_file ) {
				wp_send_json_error( array( 'message' => __( 'Plugin file not found.', 'ekwa' ) ) );
			}

			$result = activate_plugin( $plugin_file );

			if ( is_wp_error( $result ) ) {
				wp_send_json_error( array( 'message' => $result->get_error_message() ) );
			}

			// If activating ACF Pro, automatically activate the license
			if ( $slug === 'advanced-custom-fields-pro' ) {
				$this->activate_acf_license();
			}

			wp_send_json_success( array( 'message' => __( 'Plugin activated successfully.', 'ekwa' ) ) );
		}

		/**
		 * Activate ACF Pro License
		 */
		private function activate_acf_license() {
			// ACF Pro license key
			$license_key = 'b3JkZXJfaWQ9MTIwMDUyfHR5cGU9ZGV2ZWxvcGVyfGRhdGU9MjAxNy0xMi0wNCAwMjozNjowMg==';

			// Define the constant if not already defined
			if ( ! defined( 'ACF_PRO_LICENSE' ) ) {
				// Add to wp-config.php programmatically
				$this->add_license_to_wp_config( $license_key );
			}

			// Also update the option as fallback
			update_option( 'acf_pro_license', $license_key );
		}

		/**
		 * Add ACF Pro license to wp-config.php
		 */
		private function add_license_to_wp_config( $license_key ) {
			$config_path = ABSPATH . 'wp-config.php';

			if ( ! file_exists( $config_path ) || ! is_writable( $config_path ) ) {
				return false;
			}

			$config_content = file_get_contents( $config_path );

			// Check if constant is already defined
			if ( strpos( $config_content, 'ACF_PRO_LICENSE' ) !== false ) {
				return false;
			}

			// Find the position to insert (before "That's all, stop editing!")
			$insert_marker = "/* That's all, stop editing!";
			$insert_position = strpos( $config_content, $insert_marker );

			if ( $insert_position === false ) {
				// If marker not found, try alternative marker
				$insert_marker = '<?php';
				$insert_position = strpos( $config_content, $insert_marker );
				if ( $insert_position !== false ) {
					$insert_position += strlen( $insert_marker );
				}
			}

			if ( $insert_position !== false ) {
				$license_definition = "\n// ACF Pro License - Auto-configured by EKWA Theme\ndefine( 'ACF_PRO_LICENSE', '" . $license_key . "' );\n\n";

				$new_config_content = substr_replace( $config_content, $license_definition, $insert_position, 0 );

				// Write back to file
				return file_put_contents( $config_path, $new_config_content );
			}

			return false;
		}		/**
		 * AJAX: Skip wizard
		 */
		public function ajax_skip_wizard() {
			check_ajax_referer( 'ekwa_wizard_nonce', 'nonce' );
			update_option( 'ekwa_wizard_skipped', true );
			wp_send_json_success();
		}

		/**
		 * AJAX: Complete wizard
		 */
		public function ajax_complete_wizard() {
			check_ajax_referer( 'ekwa_wizard_nonce', 'nonce' );
			update_option( 'ekwa_wizard_completed', true );
			delete_option( 'ekwa_wizard_skipped' );
			wp_send_json_success();
		}
	}
}

/**
 * Initialize wizard and set activation redirect
 */
function ekwa_wizard_init() {
	// Set transient for redirect on theme activation
	add_action( 'after_switch_theme', 'ekwa_set_wizard_redirect' );
}
add_action( 'after_setup_theme', 'ekwa_wizard_init' );

function ekwa_set_wizard_redirect() {
	// Check if required plugins are active
	$required_plugins_active = class_exists( 'ACF' ) && class_exists( 'Kirki' );

	// If required plugins are missing, clear completion status and set redirect
	if ( ! $required_plugins_active ) {
		delete_option( 'ekwa_wizard_completed' );
		delete_option( 'ekwa_wizard_skipped' );
		set_transient( 'ekwa_activation_redirect', true, 30 );
	}

	// Activate ACF Pro license if ACF is active
	if ( class_exists( 'ACF' ) && ! defined( 'ACF_PRO_LICENSE' ) ) {
		$license_key = 'b3JkZXJfaWQ9MTIwMDUyfHR5cGU9ZGV2ZWxvcGVyfGRhdGU9MjAxNy0xMi0wNCAwMjozNjowMg==';

		// Try to add to wp-config.php
		$config_path = ABSPATH . 'wp-config.php';
		if ( file_exists( $config_path ) && is_writable( $config_path ) ) {
			$config_content = file_get_contents( $config_path );

			// Check if constant is not already defined in file
			if ( strpos( $config_content, 'ACF_PRO_LICENSE' ) === false ) {
				$insert_marker = "/* That's all, stop editing!";
				$insert_position = strpos( $config_content, $insert_marker );

				if ( $insert_position !== false ) {
					$license_definition = "\n// ACF Pro License - Auto-configured by EKWA Theme\ndefine( 'ACF_PRO_LICENSE', '" . $license_key . "' );\n\n";
					$new_config_content = substr_replace( $config_content, $license_definition, $insert_position, 0 );
					file_put_contents( $config_path, $new_config_content );
				}
			}
		}

		// Also set as option
		update_option( 'acf_pro_license', $license_key );
	}
}