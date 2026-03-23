<?php
/**
 * EKWA Custom Blocks Registration
 *
 * Registers all custom ACF blocks for the EKWA theme
 *
 * @package EKWA
 * @since 1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get the path for a block, checking child theme first
 *
 * If a child theme provides blocks/{name}/block.json, that version is used.
 * Otherwise falls back to the parent theme block.
 *
 * @param string $block_name Block directory name (e.g. 'button')
 * @return string Full path to the block directory
 */
function ekwa_get_block_path( $block_name ) {
    // Check child theme first (only if active child theme differs from parent)
    if ( get_stylesheet_directory() !== get_template_directory() ) {
        $child_path = get_stylesheet_directory() . '/blocks/' . $block_name;
        if ( file_exists( $child_path . '/block.json' ) ) {
            return $child_path;
        }
    }
    return get_template_directory() . '/blocks/' . $block_name;
}

/**
 * Register EKWA custom blocks
 */
function ekwa_register_acf_blocks() {
    // Check if ACF is active
    if (!function_exists('acf_register_block_type')) {
        return;
    }

    // Register custom block category
    add_filter('block_categories_all', 'ekwa_block_categories', 10, 2);

    // Active blocks — child theme can override any by providing blocks/{name}/block.json
    $active_blocks = array(
        'button',
        'call-button',
        'conditional',
        'copyright',
        'address',
        'address-dropdown',
        'icon',
        'iframe',
        'inner-page-banner',
        'phone-number',
        'working-hours',
        'google-map',
        'policy-pages',
        'sitemap',
        'social-media-icons',
        'mobile-icon-menu',
    );

    // Inactive blocks (kept for reference, not registered):
    // 'section', 'main-menu', 'webp-image'

    foreach ( $active_blocks as $block_name ) {
        register_block_type( ekwa_get_block_path( $block_name ) );
    }
}
add_action('acf/init', 'ekwa_register_acf_blocks');

/**
 * Add custom block category
 */
function ekwa_block_categories($categories, $post) {
    return array_merge(
        $categories,
        [
            [
                'slug'  => 'ekwa-blocks',
                'title' => __('EKWA Blocks', 'ekwa'),
                'icon'  => 'layout',
            ],
        ]
    );
}

/**
 * Output consolidated section styles in <head> to prevent CLS
 * Uses output buffering to capture styles after blocks render
 */
function ekwa_output_section_head_styles() {
    global $ekwa_section_head_styles;

    // Exit if no sections have custom CSS
    if (empty($ekwa_section_head_styles)) {
        return;
    }

    echo "\n<!-- EKWA Section Styles (Consolidated) -->\n";
    echo "<style id='ekwa-sections-custom'>\n";

    // Output all collected CSS
    foreach ($ekwa_section_head_styles as $block_id => $css) {
        echo $css;
    }

    echo "</style>\n";
}
add_action('wp_footer', 'ekwa_output_section_head_styles', 1);

/**
 * Move section styles from footer to head using output buffering
 */
function ekwa_move_styles_to_head() {
    if (is_admin()) {
        return;
    }
    ob_start('ekwa_relocate_section_styles');
}
add_action('wp_head', 'ekwa_move_styles_to_head', 999);

/**
 * Relocate section styles from footer to head
 */
function ekwa_relocate_section_styles($html) {
    // Find the section styles in footer
    if (preg_match('/(<!-- EKWA Section Styles.*?<\/style>)/s', $html, $matches)) {
        $styles = $matches[1];
        // Remove from original location
        $html = str_replace($styles, '', $html);
        // Insert before </head>
        $html = str_replace('</head>', $styles . '</head>', $html);
    }
    return $html;
}
