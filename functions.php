<?php
/**
 * ekwa functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package ekwa
 */


if ( ! function_exists( 'ekwa_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function ekwa_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on ekwa, use a find and replace
		 * to change 'ekwa' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'ekwa', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		//add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'ekwa' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'ekwa_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'ekwa_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function ekwa_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'ekwa_content_width', 640 );
}
add_action( 'after_setup_theme', 'ekwa_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */


function ekwa_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'ekwa' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'ekwa' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );



}
add_action( 'widgets_init', 'ekwa_widgets_init' );







/**
 * Enqueue scripts and styles.
 */
function ekwa_scripts() {

    // Removing default style sheet

	wp_enqueue_style( 'ekwa-style', get_stylesheet_uri(), array(), '2.0.0' );

     // Remove Default navigation.js

	//wp_enqueue_script( 'ekwa-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	//wp_enqueue_script( 'ekwa-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'ekwa_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';

}

/**
 * Initialize Plugin Installation Wizard
 */
require get_template_directory() . '/inc/class-ekwa-plugin-wizard.php';
require get_template_directory() . '/inc/wizard-helpers.php';

// Initialize the wizard
add_action( 'after_setup_theme', function() {
	if ( is_admin() ) {
		EKWA_Plugin_Wizard::get_instance();
	}
} );



require get_template_directory() . '/settings/theme-functions.php';
require get_template_directory() . '/settings/customizer.php';
require get_template_directory() . '/settings/acf.php';

// ACF Icon Picker Field - Load only if ACF is active
if (class_exists('ACF')) {
    require get_template_directory() . '/settings/acf-icon-picker/acf-icon-picker-field.php';
}

// ACF FontAwesome Icon Picker Field - Load only if ACF is active
if (class_exists('ACF')) {
    if (file_exists(get_template_directory() . '/acf-fields/acf-fontawesome/acf-fontawesome.php')) {
        require get_template_directory() . '/acf-fields/acf-fontawesome/acf-fontawesome.php';
    }
}

// Kirki Icon Picker Enhancement - Load scripts for customizer
add_action('customize_controls_enqueue_scripts', function() {
    if (class_exists('Kirki')) {
        wp_enqueue_style('fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css', array(), '6.5.1');
        wp_enqueue_style('kirki-icon-picker', get_template_directory_uri() . '/inc/kirki-controls/icon-picker.css', array(), '1.0.7');
        wp_enqueue_script('kirki-icon-picker', get_template_directory_uri() . '/inc/kirki-controls/icon-picker.js', array('jquery', 'customize-controls'), '1.0.7', true);
    }
}, 20);

/**
 * ACF JSON Save Point - Save to parent theme
 */
add_filter('acf/settings/save_json', 'ekwa_acf_json_save_point');
function ekwa_acf_json_save_point( $path ) {
    // Always save to parent theme
    $path = get_template_directory() . '/acf-json';
    return $path;
}

/**
 * ACF JSON Load Point - Load from parent theme (works with child themes)
 */
add_filter('acf/settings/load_json', 'ekwa_acf_json_load_point');
function ekwa_acf_json_load_point( $paths ) {
    // Remove original path
    unset($paths[0]);

    // Add parent theme path
    $paths[] = get_template_directory() . '/acf-json';

    // If using child theme, also check child theme folder (optional)
    if ( get_stylesheet_directory() !== get_template_directory() ) {
        $child_path = get_stylesheet_directory() . '/acf-json';
        if ( is_dir( $child_path ) ) {
            $paths[] = $child_path;
        }
    }

    return $paths;
}

/**
 * Customizer front-end CSS variable output (hooked to wp_head priority 1).
 */
require get_template_directory() . '/settings/customizer-font-end/index.php';



