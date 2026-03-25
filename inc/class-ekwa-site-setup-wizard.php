<?php
/**
 * EKWA Site Setup Wizard
 *
 * Multi-step wizard that prompts users to enter essential site settings
 * (practice info, locations, social media, header/footer) on theme activation.
 * Data is saved as Kirki theme_mods so blocks render correctly.
 *
 * @package ekwa
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'EKWA_Site_Setup_Wizard' ) ) {

	class EKWA_Site_Setup_Wizard {

		/** @var self|null */
		private static $instance = null;

		/** @var string */
		private $page_slug = 'ekwa-site-setup';

		/**
		 * Get singleton instance.
		 */
		public static function get_instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * Constructor — register hooks.
		 */
		private function __construct() {
			add_action( 'admin_menu', array( $this, 'add_page' ) );
			add_action( 'admin_init', array( $this, 'maybe_redirect' ), 20 );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_assets' ) );
			add_action( 'admin_notices', array( $this, 'admin_notice' ) );

			// AJAX handlers.
			add_action( 'wp_ajax_ekwa_site_setup_save', array( $this, 'ajax_save_step' ) );
			add_action( 'wp_ajax_ekwa_site_setup_skip', array( $this, 'ajax_skip' ) );
			add_action( 'wp_ajax_ekwa_site_setup_complete', array( $this, 'ajax_complete' ) );
		}

		/* ==================================================================
		 * Conditions
		 * ================================================================*/

		/**
		 * Required plugins must be active before the wizard can run.
		 */
		private function plugins_ready() {
			return class_exists( 'ACF' ) && class_exists( 'Kirki' );
		}

		/**
		 * Whether the setup wizard should be shown.
		 */
		public function should_show() {
			return $this->plugins_ready() && ! get_option( 'ekwa_site_setup_completed' );
		}

		/* ==================================================================
		 * Redirect on activation
		 * ================================================================*/

		/**
		 * One-time redirect after theme activation (runs after plugin wizard).
		 */
		public function maybe_redirect() {
			if ( ! get_transient( 'ekwa_site_setup_redirect' ) ) {
				return;
			}

			if ( ! $this->should_show() ) {
				delete_transient( 'ekwa_site_setup_redirect' );
				return;
			}

			// Don't redirect during multi-activate or AJAX.
			if ( isset( $_GET['activate-multi'] ) || wp_doing_ajax() ) {
				return;
			}

			// Don't redirect if already on the page.
			if ( isset( $_GET['page'] ) && $this->page_slug === $_GET['page'] ) {
				return;
			}

			delete_transient( 'ekwa_site_setup_redirect' );
			wp_safe_redirect( admin_url( 'themes.php?page=' . $this->page_slug ) );
			exit;
		}

		/* ==================================================================
		 * Admin menu & assets
		 * ================================================================*/

		public function add_page() {
			add_theme_page(
				__( 'Site Setup', 'ekwa' ),
				__( 'Site Setup', 'ekwa' ),
				'manage_options',
				$this->page_slug,
				array( $this, 'render_page' )
			);
		}

		public function enqueue_assets( $hook ) {
			if ( 'appearance_page_' . $this->page_slug !== $hook ) {
				return;
			}

			wp_enqueue_style(
				'ekwa-site-setup',
				get_template_directory_uri() . '/inc/wizard-assets/site-setup.css',
				array(),
				'1.0.0'
			);

			wp_enqueue_script(
				'ekwa-site-setup',
				get_template_directory_uri() . '/inc/wizard-assets/site-setup.js',
				array( 'jquery' ),
				'1.0.0',
				true
			);

			// Existing header/footer CPT posts for Step 4.
			$headers = get_posts( array(
				'post_type'   => 'ekwa_theme_headers',
				'numberposts' => 50,
				'post_status' => 'publish',
			) );
			$footers = get_posts( array(
				'post_type'   => 'ekwa_theme_footers',
				'numberposts' => 50,
				'post_status' => 'publish',
			) );

			$header_options = array();
			foreach ( $headers as $h ) {
				$header_options[] = array( 'id' => $h->ID, 'title' => $h->post_title );
			}
			$footer_options = array();
			foreach ( $footers as $f ) {
				$footer_options[] = array( 'id' => $f->ID, 'title' => $f->post_title );
			}

			wp_localize_script( 'ekwa-site-setup', 'ekwaSiteSetup', array(
				'ajaxurl'        => admin_url( 'admin-ajax.php' ),
				'nonce'          => wp_create_nonce( 'ekwa_site_setup_nonce' ),
				'adminUrl'       => admin_url(),
				'customizerUrl'  => admin_url( 'customize.php' ),
				'headers'        => $header_options,
				'footers'        => $footer_options,
				'currentHeader'  => get_theme_mod( 'select_header', '' ),
				'currentFooter'  => get_theme_mod( 'select_footer', '' ),
				// Pre-fill with any existing values.
				'existing'       => array(
					'client_name'              => get_theme_mod( 'client_name', '' ),
					'practise_name'            => get_theme_mod( 'practise_name', '' ),
					'organization_type'        => get_theme_mod( 'organization_type', 'Dentist' ),
					'email_address'            => get_theme_mod( 'email_address', '' ),
					'country'                  => get_theme_mod( 'country', 'United States' ),
					'appointment_page_type'    => get_theme_mod( 'appointment_page_type', 'external' ),
					'appointment_external_url' => get_theme_mod( 'appointment_external_url', '' ),
					'location_info'            => get_theme_mod( 'location_info', array() ),
					'social_media_links'       => get_theme_mod( 'social_media_links', array() ),
				),
			) );
		}

		/* ==================================================================
		 * Admin notice
		 * ================================================================*/

		public function admin_notice() {
			if ( ! $this->should_show() ) {
				return;
			}

			$screen = get_current_screen();
			if ( $screen && 'appearance_page_' . $this->page_slug === $screen->id ) {
				return;
			}
			?>
			<div class="notice notice-info is-dismissible">
				<p>
					<strong><?php esc_html_e( 'EKWA Theme:', 'ekwa' ); ?></strong>
					<?php esc_html_e( 'Site setup is incomplete. Please enter your practice details so the theme can display correctly.', 'ekwa' ); ?>
				</p>
				<p>
					<a href="<?php echo esc_url( admin_url( 'themes.php?page=' . $this->page_slug ) ); ?>" class="button button-primary">
						<?php esc_html_e( 'Complete Site Setup', 'ekwa' ); ?>
					</a>
				</p>
			</div>
			<?php
		}

		/* ==================================================================
		 * Render wizard page
		 * ================================================================*/

		public function render_page() {
			?>
			<div class="ekwa-setup-wrap">
				<div class="ekwa-setup-container">

					<!-- Header -->
					<div class="ekwa-setup-header">
						<h1><?php esc_html_e( 'Site Setup Wizard', 'ekwa' ); ?></h1>
						<p><?php esc_html_e( 'Enter your practice details so blocks, headers, and footers display correctly.', 'ekwa' ); ?></p>
					</div>

					<!-- Step indicators -->
					<div class="ekwa-setup-steps">
						<?php
						$steps = array(
							1 => __( 'Practice Info', 'ekwa' ),
							2 => __( 'Locations', 'ekwa' ),
							3 => __( 'Social Media', 'ekwa' ),
							4 => __( 'Header & Footer', 'ekwa' ),
							5 => __( 'Complete', 'ekwa' ),
						);
						foreach ( $steps as $num => $label ) :
							$active = 1 === $num ? ' active' : '';
							?>
							<div class="ekwa-setup-step<?php echo esc_attr( $active ); ?>" data-step="<?php echo esc_attr( $num ); ?>">
								<span class="step-num"><?php echo esc_html( $num ); ?></span>
								<span class="step-label"><?php echo esc_html( $label ); ?></span>
							</div>
						<?php endforeach; ?>
					</div>

					<!-- Step content -->
					<div class="ekwa-setup-body">

						<?php
						$this->render_step_practice();
						$this->render_step_locations();
						$this->render_step_social();
						$this->render_step_header_footer();
						$this->render_step_complete();
						?>

					</div>

					<!-- Footer -->
					<div class="ekwa-setup-footer">
						<a href="#" id="ekwa-skip-setup"><?php esc_html_e( 'Skip setup and configure later in Customizer', 'ekwa' ); ?></a>
					</div>

				</div>
			</div>
			<?php
		}

		/* ------------------------------------------------------------------
		 * Step 1 — Practice Info
		 * ----------------------------------------------------------------*/

		private function render_step_practice() {
			$org_types = array(
				'Dentist'              => __( 'Dentist', 'ekwa' ),
				'MedicalClinic'        => __( 'Medical Clinic', 'ekwa' ),
				'Attorney'             => __( 'Attorney', 'ekwa' ),
				'Physician'            => __( 'Physician', 'ekwa' ),
				'Optometrist'          => __( 'Optometrist', 'ekwa' ),
				'Dermatologist'        => __( 'Dermatologist', 'ekwa' ),
				'PlasticSurgery'       => __( 'Plastic Surgery', 'ekwa' ),
				'OralSurgeon'          => __( 'Oral Surgeon', 'ekwa' ),
				'Orthodontist'         => __( 'Orthodontist', 'ekwa' ),
				'Periodontist'         => __( 'Periodontist', 'ekwa' ),
				'Endodontist'          => __( 'Endodontist', 'ekwa' ),
				'VeterinaryCare'       => __( 'Veterinary Care', 'ekwa' ),
				'LocalBusiness'        => __( 'Local Business', 'ekwa' ),
			);

			$countries = array(
				'United States' => __( 'United States', 'ekwa' ),
				'Canada'        => __( 'Canada', 'ekwa' ),
				'Australia'     => __( 'Australia', 'ekwa' ),
				'England'       => __( 'England', 'ekwa' ),
				'Online Based'  => __( 'Online Based', 'ekwa' ),
			);
			?>
			<div class="ekwa-setup-step-content" id="setup-step-1">
				<h2><?php esc_html_e( 'Practice Information', 'ekwa' ); ?></h2>
				<p class="step-desc"><?php esc_html_e( 'Basic details about the practice. These appear in metadata, copyright, and throughout the site.', 'ekwa' ); ?></p>

				<div class="ekwa-form-grid">
					<div class="ekwa-field">
						<label for="client_name"><?php esc_html_e( 'Client Name', 'ekwa' ); ?> <span class="required">*</span></label>
						<input type="text" id="client_name" name="client_name" placeholder="<?php esc_attr_e( 'e.g. Dr. John Smith', 'ekwa' ); ?>" required>
					</div>
					<div class="ekwa-field">
						<label for="practise_name"><?php esc_html_e( 'Practice Name', 'ekwa' ); ?> <span class="required">*</span></label>
						<input type="text" id="practise_name" name="practise_name" placeholder="<?php esc_attr_e( 'e.g. Smith Family Dentistry', 'ekwa' ); ?>" required>
					</div>
					<div class="ekwa-field">
						<label for="organization_type"><?php esc_html_e( 'Organization Type', 'ekwa' ); ?></label>
						<select id="organization_type" name="organization_type">
							<?php foreach ( $org_types as $val => $label ) : ?>
								<option value="<?php echo esc_attr( $val ); ?>"><?php echo esc_html( $label ); ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="ekwa-field">
						<label for="email_address"><?php esc_html_e( 'Email Address', 'ekwa' ); ?></label>
						<input type="email" id="email_address" name="email_address" placeholder="<?php esc_attr_e( 'office@example.com', 'ekwa' ); ?>">
					</div>
					<div class="ekwa-field">
						<label for="country"><?php esc_html_e( 'Country', 'ekwa' ); ?></label>
						<select id="country" name="country">
							<?php foreach ( $countries as $val => $label ) : ?>
								<option value="<?php echo esc_attr( $val ); ?>"><?php echo esc_html( $label ); ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="ekwa-field">
						<label><?php esc_html_e( 'Appointment Type', 'ekwa' ); ?></label>
						<div class="ekwa-radio-group">
							<label><input type="radio" name="appointment_page_type" value="external" checked> <?php esc_html_e( 'External URL', 'ekwa' ); ?></label>
							<label><input type="radio" name="appointment_page_type" value="page"> <?php esc_html_e( 'Internal Page', 'ekwa' ); ?></label>
						</div>
					</div>
					<div class="ekwa-field ekwa-full-width" id="appointment-url-wrap">
						<label for="appointment_external_url"><?php esc_html_e( 'Appointment URL', 'ekwa' ); ?></label>
						<input type="url" id="appointment_external_url" name="appointment_external_url" placeholder="https://booking.example.com">
					</div>
				</div>

				<div class="ekwa-step-actions">
					<button type="button" class="button button-primary button-hero" id="save-step-1"><?php esc_html_e( 'Save & Continue', 'ekwa' ); ?></button>
				</div>
			</div>
			<?php
		}

		/* ------------------------------------------------------------------
		 * Step 2 — Locations
		 * ----------------------------------------------------------------*/

		private function render_step_locations() {
			?>
			<div class="ekwa-setup-step-content" id="setup-step-2" style="display:none;">
				<h2><?php esc_html_e( 'Location Information', 'ekwa' ); ?></h2>
				<p class="step-desc"><?php esc_html_e( 'Add each practice location. Phone numbers, addresses, and working hours are used by address, phone, and working-hours blocks.', 'ekwa' ); ?></p>

				<div id="ekwa-locations-list">
					<!-- JS injects location cards here -->
				</div>

				<button type="button" class="button" id="ekwa-add-location">
					+ <?php esc_html_e( 'Add Another Location', 'ekwa' ); ?>
				</button>

				<div class="ekwa-step-actions">
					<button type="button" class="button" id="back-step-2"><?php esc_html_e( 'Back', 'ekwa' ); ?></button>
					<button type="button" class="button button-primary button-hero" id="save-step-2"><?php esc_html_e( 'Save & Continue', 'ekwa' ); ?></button>
				</div>
			</div>
			<?php
		}

		/* ------------------------------------------------------------------
		 * Step 3 — Social Media
		 * ----------------------------------------------------------------*/

		private function render_step_social() {
			$platforms = array(
				array(
					'key'   => 'facebook',
					'label' => 'Facebook',
					'icon'  => 'fa-brands fa-facebook-f',
					'ph'    => 'https://facebook.com/yourpage',
				),
				array(
					'key'   => 'instagram',
					'label' => 'Instagram',
					'icon'  => 'fa-brands fa-instagram',
					'ph'    => 'https://instagram.com/yourpage',
				),
				array(
					'key'   => 'twitter',
					'label' => 'X (Twitter)',
					'icon'  => 'fa-brands fa-x-twitter',
					'ph'    => 'https://x.com/yourhandle',
				),
				array(
					'key'   => 'youtube',
					'label' => 'YouTube',
					'icon'  => 'fa-brands fa-youtube',
					'ph'    => 'https://youtube.com/@yourchannel',
				),
				array(
					'key'   => 'linkedin',
					'label' => 'LinkedIn',
					'icon'  => 'fa-brands fa-linkedin-in',
					'ph'    => 'https://linkedin.com/company/yours',
				),
				array(
					'key'   => 'tiktok',
					'label' => 'TikTok',
					'icon'  => 'fa-brands fa-tiktok',
					'ph'    => 'https://tiktok.com/@yourpage',
				),
				array(
					'key'   => 'yelp',
					'label' => 'Yelp',
					'icon'  => 'fa-brands fa-yelp',
					'ph'    => 'https://yelp.com/biz/yourbusiness',
				),
			);
			?>
			<div class="ekwa-setup-step-content" id="setup-step-3" style="display:none;">
				<h2><?php esc_html_e( 'Social Media Profiles', 'ekwa' ); ?></h2>
				<p class="step-desc"><?php esc_html_e( 'Enter the URLs for your social media profiles. Leave blank any you don\'t use. These are shown by the Social Media Icons block.', 'ekwa' ); ?></p>

				<div class="ekwa-social-list">
					<?php foreach ( $platforms as $p ) : ?>
						<div class="ekwa-social-row" data-platform="<?php echo esc_attr( $p['key'] ); ?>" data-icon="<?php echo esc_attr( $p['icon'] ); ?>">
							<span class="social-label">
								<i class="<?php echo esc_attr( $p['icon'] ); ?>"></i>
								<?php echo esc_html( $p['label'] ); ?>
							</span>
							<input type="url" name="social_<?php echo esc_attr( $p['key'] ); ?>" placeholder="<?php echo esc_attr( $p['ph'] ); ?>">
						</div>
					<?php endforeach; ?>
				</div>

				<div class="ekwa-step-actions">
					<button type="button" class="button" id="back-step-3"><?php esc_html_e( 'Back', 'ekwa' ); ?></button>
					<button type="button" class="button button-primary button-hero" id="save-step-3"><?php esc_html_e( 'Save & Continue', 'ekwa' ); ?></button>
				</div>
			</div>
			<?php
		}

		/* ------------------------------------------------------------------
		 * Step 4 — Header & Footer
		 * ----------------------------------------------------------------*/

		private function render_step_header_footer() {
			?>
			<div class="ekwa-setup-step-content" id="setup-step-4" style="display:none;">
				<h2><?php esc_html_e( 'Header & Footer', 'ekwa' ); ?></h2>
				<p class="step-desc"><?php esc_html_e( 'Select which Header and Footer CPT posts should be used site-wide. These are edited with the block editor.', 'ekwa' ); ?></p>

				<div class="ekwa-form-grid">
					<div class="ekwa-field">
						<label for="select_header"><?php esc_html_e( 'Select Header', 'ekwa' ); ?> <span class="required">*</span></label>
						<select id="select_header" name="select_header">
							<option value=""><?php esc_html_e( '— Select Header —', 'ekwa' ); ?></option>
							<!-- JS populates options -->
						</select>
						<p class="field-hint">
							<?php
							printf(
								/* translators: %s: URL to Headers CPT list */
								esc_html__( 'No headers? %s in the block editor first.', 'ekwa' ),
								'<a href="' . esc_url( admin_url( 'edit.php?post_type=ekwa_theme_headers' ) ) . '" target="_blank">' . esc_html__( 'Create one', 'ekwa' ) . '</a>'
							);
							?>
						</p>
					</div>
					<div class="ekwa-field">
						<label for="select_footer"><?php esc_html_e( 'Select Footer', 'ekwa' ); ?> <span class="required">*</span></label>
						<select id="select_footer" name="select_footer">
							<option value=""><?php esc_html_e( '— Select Footer —', 'ekwa' ); ?></option>
							<!-- JS populates options -->
						</select>
						<p class="field-hint">
							<?php
							printf(
								/* translators: %s: URL to Footers CPT list */
								esc_html__( 'No footers? %s in the block editor first.', 'ekwa' ),
								'<a href="' . esc_url( admin_url( 'edit.php?post_type=ekwa_theme_footers' ) ) . '" target="_blank">' . esc_html__( 'Create one', 'ekwa' ) . '</a>'
							);
							?>
						</p>
					</div>
				</div>

				<div class="ekwa-step-actions">
					<button type="button" class="button" id="back-step-4"><?php esc_html_e( 'Back', 'ekwa' ); ?></button>
					<button type="button" class="button button-primary button-hero" id="save-step-4"><?php esc_html_e( 'Save & Finish', 'ekwa' ); ?></button>
				</div>
			</div>
			<?php
		}

		/* ------------------------------------------------------------------
		 * Step 5 — Complete
		 * ----------------------------------------------------------------*/

		private function render_step_complete() {
			?>
			<div class="ekwa-setup-step-content" id="setup-step-5" style="display:none;">
				<div class="ekwa-setup-complete">
					<div class="ekwa-complete-icon">&#10003;</div>
					<h2><?php esc_html_e( 'Setup Complete!', 'ekwa' ); ?></h2>
					<p><?php esc_html_e( 'Your practice details have been saved. Blocks like Phone Number, Address, Working Hours, and Social Media Icons will now display your data.', 'ekwa' ); ?></p>
					<p><?php esc_html_e( 'You can fine-tune any setting in the Customizer at any time.', 'ekwa' ); ?></p>
					<div class="ekwa-complete-actions">
						<a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" class="button button-primary button-hero">
							<?php esc_html_e( 'Open Customizer', 'ekwa' ); ?>
						</a>
						<a href="<?php echo esc_url( admin_url() ); ?>" class="button button-secondary button-hero">
							<?php esc_html_e( 'Go to Dashboard', 'ekwa' ); ?>
						</a>
					</div>
				</div>
			</div>
			<?php
		}

		/* ==================================================================
		 * AJAX handlers
		 * ================================================================*/

		/**
		 * Save a single step's data.
		 */
		public function ajax_save_step() {
			check_ajax_referer( 'ekwa_site_setup_nonce', 'nonce' );

			if ( ! current_user_can( 'manage_options' ) ) {
				wp_send_json_error( array( 'message' => __( 'Permission denied.', 'ekwa' ) ) );
			}

			$step = isset( $_POST['step'] ) ? absint( $_POST['step'] ) : 0;
			// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
			$data = isset( $_POST['data'] ) ? $_POST['data'] : array();

			if ( ! $step || empty( $data ) ) {
				wp_send_json_error( array( 'message' => __( 'Invalid request.', 'ekwa' ) ) );
			}

			switch ( $step ) {
				case 1:
					$this->save_practice( $data );
					break;
				case 2:
					$this->save_locations( $data );
					break;
				case 3:
					$this->save_social( $data );
					break;
				case 4:
					$this->save_header_footer( $data );
					break;
				default:
					wp_send_json_error( array( 'message' => __( 'Unknown step.', 'ekwa' ) ) );
			}

			wp_send_json_success( array( 'message' => __( 'Saved.', 'ekwa' ) ) );
		}

		/**
		 * Skip the wizard.
		 */
		public function ajax_skip() {
			check_ajax_referer( 'ekwa_site_setup_nonce', 'nonce' );

			if ( ! current_user_can( 'manage_options' ) ) {
				wp_send_json_error();
			}

			update_option( 'ekwa_site_setup_completed', true );
			wp_send_json_success();
		}

		/**
		 * Mark setup as complete.
		 */
		public function ajax_complete() {
			check_ajax_referer( 'ekwa_site_setup_nonce', 'nonce' );

			if ( ! current_user_can( 'manage_options' ) ) {
				wp_send_json_error();
			}

			update_option( 'ekwa_site_setup_completed', true );
			wp_send_json_success();
		}

		/* ==================================================================
		 * Save helpers — sanitise & persist as theme_mods
		 * ================================================================*/

		private function save_practice( $data ) {
			$text_fields = array(
				'client_name',
				'practise_name',
				'organization_type',
				'country',
				'appointment_page_type',
			);
			foreach ( $text_fields as $key ) {
				if ( isset( $data[ $key ] ) ) {
					set_theme_mod( $key, sanitize_text_field( wp_unslash( $data[ $key ] ) ) );
				}
			}
			if ( isset( $data['email_address'] ) ) {
				set_theme_mod( 'email_address', sanitize_email( wp_unslash( $data['email_address'] ) ) );
			}
			if ( isset( $data['appointment_external_url'] ) ) {
				set_theme_mod( 'appointment_external_url', esc_url_raw( wp_unslash( $data['appointment_external_url'] ) ) );
			}
		}

		private function save_locations( $data ) {
			if ( empty( $data['locations'] ) || ! is_array( $data['locations'] ) ) {
				return;
			}

			$clean = array();
			foreach ( $data['locations'] as $loc ) {
				$location = array(
					'phone'              => isset( $loc['phone'] ) ? sanitize_text_field( wp_unslash( $loc['phone'] ) ) : '',
					'phone_ex'           => isset( $loc['phone_ex'] ) ? sanitize_text_field( wp_unslash( $loc['phone_ex'] ) ) : '',
					'street_address'     => isset( $loc['street_address'] ) ? sanitize_text_field( wp_unslash( $loc['street_address'] ) ) : '',
					'city'               => isset( $loc['city'] ) ? sanitize_text_field( wp_unslash( $loc['city'] ) ) : '',
					'state'              => isset( $loc['state'] ) ? sanitize_text_field( wp_unslash( $loc['state'] ) ) : '',
					'zip'                => isset( $loc['zip'] ) ? sanitize_text_field( wp_unslash( $loc['zip'] ) ) : '',
					'direction'          => isset( $loc['direction'] ) ? esc_url_raw( wp_unslash( $loc['direction'] ) ) : '',
					'latitude'           => isset( $loc['latitude'] ) ? sanitize_text_field( wp_unslash( $loc['latitude'] ) ) : '',
					'longitude'          => isset( $loc['longitude'] ) ? sanitize_text_field( wp_unslash( $loc['longitude'] ) ) : '',
				);

				// Working hours arrive as a JSON string from the JS side.
				if ( ! empty( $loc['working_hours_data'] ) ) {
					$raw   = wp_unslash( $loc['working_hours_data'] );
					$hours = json_decode( $raw, true );
					if ( json_last_error() === JSON_ERROR_NONE && is_array( $hours ) ) {
						// Re-encode after sanitising each field.
						$safe_hours = array();
						foreach ( $hours as $h ) {
							$safe_hours[] = array(
								'day'        => isset( $h['day'] ) ? sanitize_text_field( $h['day'] ) : '',
								'opening'    => isset( $h['opening'] ) ? sanitize_text_field( $h['opening'] ) : '',
								'closing'    => isset( $h['closing'] ) ? sanitize_text_field( $h['closing'] ) : '',
								'closed'     => ! empty( $h['closed'] ),
								'extra_text' => isset( $h['extra_text'] ) ? sanitize_text_field( $h['extra_text'] ) : '',
							);
						}
						$location['working_hours_data'] = wp_json_encode( $safe_hours );
					} else {
						$location['working_hours_data'] = '[]';
					}
				} else {
					$location['working_hours_data'] = '[]';
				}

				$clean[] = $location;
			}

			set_theme_mod( 'location_info', $clean );
		}

		private function save_social( $data ) {
			if ( empty( $data['social'] ) || ! is_array( $data['social'] ) ) {
				return;
			}

			$icon_map = array(
				'facebook'  => 'fa-brands fa-facebook-f',
				'instagram' => 'fa-brands fa-instagram',
				'twitter'   => 'fa-brands fa-x-twitter',
				'youtube'   => 'fa-brands fa-youtube',
				'linkedin'  => 'fa-brands fa-linkedin-in',
				'tiktok'    => 'fa-brands fa-tiktok',
				'yelp'      => 'fa-brands fa-yelp',
			);

			$label_map = array(
				'facebook'  => 'Facebook',
				'instagram' => 'Instagram',
				'twitter'   => 'X (Twitter)',
				'youtube'   => 'YouTube',
				'linkedin'  => 'LinkedIn',
				'tiktok'    => 'TikTok',
				'yelp'      => 'Yelp',
			);

			$repeater = array();
			foreach ( $data['social'] as $key => $url ) {
				$url = esc_url_raw( wp_unslash( $url ) );
				if ( '' === $url ) {
					continue;
				}
				$safe_key = sanitize_key( $key );
				$repeater[] = array(
					'profile_name'          => isset( $label_map[ $safe_key ] ) ? $label_map[ $safe_key ] : ucfirst( $safe_key ),
					'social_media_link'     => $url,
					'social_media_icon_font'  => isset( $icon_map[ $safe_key ] ) ? $icon_map[ $safe_key ] : '',
					'social_media_icon_image' => '',
				);
			}

			set_theme_mod( 'social_media_links', $repeater );
		}

		private function save_header_footer( $data ) {
			if ( isset( $data['select_header'] ) ) {
				$header_id = absint( $data['select_header'] );
				if ( $header_id && get_post( $header_id ) ) {
					set_theme_mod( 'select_header', $header_id );
				}
			}
			if ( isset( $data['select_footer'] ) ) {
				$footer_id = absint( $data['select_footer'] );
				if ( $footer_id && get_post( $footer_id ) ) {
					set_theme_mod( 'select_footer', $footer_id );
				}
			}
		}
	}
}
