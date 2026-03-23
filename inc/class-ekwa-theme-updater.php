<?php
/**
 * GitHub-based Theme Updater
 *
 * Checks a GitHub repository's releases for theme updates and integrates
 * with the WordPress native update system.
 *
 * Usage (parent theme):
 *   new Ekwa_Theme_Updater( array(
 *       'slug'       => 'ekwa-theme',
 *       'repo'       => 'your-org/ekwa-theme',
 *       'token'      => defined('EKWA_GITHUB_TOKEN') ? EKWA_GITHUB_TOKEN : '',
 *       'theme_file' => get_template_directory() . '/style.css',
 *   ) );
 *
 * Usage (child theme):
 *   new Ekwa_Theme_Updater( array(
 *       'slug'       => 'my-child-theme',
 *       'repo'       => 'your-org/my-child-theme',
 *       'token'      => defined('EKWA_GITHUB_TOKEN') ? EKWA_GITHUB_TOKEN : '',
 *       'theme_file' => get_stylesheet_directory() . '/style.css',
 *   ) );
 *
 * @package EKWA
 * @since 2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Ekwa_Theme_Updater' ) ) :

class Ekwa_Theme_Updater {

	/**
	 * @var string Theme slug (directory name).
	 */
	private $slug;

	/**
	 * @var string GitHub owner/repo.
	 */
	private $repo;

	/**
	 * @var string GitHub personal access token (optional, for private repos).
	 */
	private $token;

	/**
	 * @var string Full path to style.css for version reading.
	 */
	private $theme_file;

	/**
	 * @var string Current installed version.
	 */
	private $version;

	/**
	 * @var array|null Cached GitHub release data.
	 */
	private $release_data;

	/**
	 * Constructor.
	 *
	 * @param array $config {
	 *     @type string $slug       Theme directory slug.
	 *     @type string $repo       GitHub repo in 'owner/repo' format.
	 *     @type string $token      Optional GitHub access token for private repos.
	 *     @type string $theme_file Path to the theme's style.css.
	 * }
	 */
	public function __construct( $config ) {
		$this->slug       = $config['slug'];
		$this->repo       = $config['repo'];
		$this->token      = isset( $config['token'] ) ? $config['token'] : '';
		$this->theme_file = $config['theme_file'];

		// Read current version from style.css
		$theme_data    = wp_get_theme( $this->slug );
		$this->version = $theme_data->get( 'Version' );

		add_filter( 'pre_set_site_transient_update_themes', array( $this, 'check_update' ) );
		add_filter( 'themes_api', array( $this, 'theme_info' ), 10, 3 );
		add_action( 'upgrader_process_complete', array( $this, 'after_update' ), 10, 2 );
	}

	/**
	 * Fetch latest release from GitHub API.
	 *
	 * @return array|false Release data or false on failure.
	 */
	private function get_latest_release() {
		if ( null !== $this->release_data ) {
			return $this->release_data;
		}

		$url = 'https://api.github.com/repos/' . $this->repo . '/releases/latest';

		$args = array(
			'headers' => array(
				'Accept' => 'application/vnd.github.v3+json',
			),
			'timeout' => 15,
		);

		if ( ! empty( $this->token ) ) {
			$args['headers']['Authorization'] = 'token ' . $this->token;
		}

		$response = wp_remote_get( $url, $args );

		if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
			$this->release_data = false;
			return false;
		}

		$body = json_decode( wp_remote_retrieve_body( $response ), true );

		if ( empty( $body ) || ! isset( $body['tag_name'] ) ) {
			$this->release_data = false;
			return false;
		}

		$this->release_data = $body;
		return $body;
	}

	/**
	 * Get the download URL for the latest release.
	 *
	 * Prefers the first .zip asset attached to the release. Falls back to the
	 * auto-generated zipball URL.
	 *
	 * @param array $release Release data from GitHub API.
	 * @return string Download URL.
	 */
	private function get_download_url( $release ) {
		// Look for a .zip asset first (recommended: upload a clean zip to the release)
		if ( ! empty( $release['assets'] ) ) {
			foreach ( $release['assets'] as $asset ) {
				if ( 'application/zip' === $asset['content_type'] || '.zip' === substr( $asset['name'], -4 ) ) {
					$url = $asset['browser_download_url'];
					if ( ! empty( $this->token ) ) {
						$url = add_query_arg( 'access_token', $this->token, $asset['url'] );
					}
					return $url;
				}
			}
		}

		// Fallback to zipball
		$url = $release['zipball_url'];
		if ( ! empty( $this->token ) ) {
			$url = add_query_arg( 'access_token', $this->token, $url );
		}
		return $url;
	}

	/**
	 * Inject update data into the WordPress update transient.
	 *
	 * @param object $transient Update transient data.
	 * @return object Modified transient.
	 */
	public function check_update( $transient ) {
		if ( empty( $transient->checked ) ) {
			return $transient;
		}

		$release = $this->get_latest_release();
		if ( ! $release ) {
			return $transient;
		}

		// Strip leading 'v' from tag (e.g. 'v2.1.0' → '2.1.0')
		$latest_version = ltrim( $release['tag_name'], 'v' );

		if ( version_compare( $latest_version, $this->version, '>' ) ) {
			$transient->response[ $this->slug ] = array(
				'theme'       => $this->slug,
				'new_version' => $latest_version,
				'url'         => $release['html_url'],
				'package'     => $this->get_download_url( $release ),
			);
		}

		return $transient;
	}

	/**
	 * Provide theme details for the WordPress theme info modal.
	 *
	 * @param false|object|array $result Default result.
	 * @param string             $action API action.
	 * @param object             $args   Arguments.
	 * @return false|object
	 */
	public function theme_info( $result, $action, $args ) {
		if ( 'theme_information' !== $action || $this->slug !== $args->slug ) {
			return $result;
		}

		$release = $this->get_latest_release();
		if ( ! $release ) {
			return $result;
		}

		$latest_version = ltrim( $release['tag_name'], 'v' );
		$theme_data     = wp_get_theme( $this->slug );

		return (object) array(
			'name'          => $theme_data->get( 'Name' ),
			'slug'          => $this->slug,
			'version'       => $latest_version,
			'author'        => $theme_data->get( 'Author' ),
			'homepage'      => $theme_data->get( 'ThemeURI' ),
			'download_link' => $this->get_download_url( $release ),
			'sections'      => array(
				'description' => $theme_data->get( 'Description' ),
				'changelog'   => nl2br( esc_html( $release['body'] ) ),
			),
		);
	}

	/**
	 * Clear cached release data after the theme is updated.
	 *
	 * @param WP_Upgrader $upgrader Upgrader instance.
	 * @param array       $options  Update data.
	 */
	public function after_update( $upgrader, $options ) {
		if ( 'update' === $options['action'] && 'theme' === $options['type'] ) {
			if ( isset( $options['themes'] ) && in_array( $this->slug, $options['themes'], true ) ) {
				$this->release_data = null;
				delete_transient( 'ekwa_theme_update_' . $this->slug );
			}
		}
	}
}

endif;
