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
 * Register EKWA custom blocks
 */
function ekwa_register_acf_blocks() {
    // Check if ACF is active
    if (!function_exists('acf_register_block_type')) {
        return;
    }

    // Register custom block category
    add_filter('block_categories_all', 'ekwa_block_categories', 10, 2);

    // Register EKWA Section Block
    register_block_type(get_template_directory() . '/blocks/section');

    // Register EKWA Button Block
    register_block_type(get_template_directory() . '/blocks/button');

    // Register EKWA Call Button Block
    register_block_type(get_template_directory() . '/blocks/call-button');

    // Register EKWA Conditional Block
    register_block_type(get_template_directory() . '/blocks/conditional');

    // Register EKWA Copyright Block
    register_block_type(get_template_directory() . '/blocks/copyright');

    // Register EKWA Address Block
    register_block_type(get_template_directory() . '/blocks/address');

    // Register EKWA Address Dropdown Block
    register_block_type(get_template_directory() . '/blocks/address-dropdown');

    // Register EKWA Icon Block
    register_block_type(get_template_directory() . '/blocks/icon');

    // Register EKWA Iframe Block
    register_block_type(get_template_directory() . '/blocks/iframe');

    // Register EKWA Inner Page Banner Block
    register_block_type(get_template_directory() . '/blocks/inner-page-banner');

    // Register EKWA Phone Number Block
    register_block_type(get_template_directory() . '/blocks/phone-number');

    // Register EKWA Working Hours Block
    register_block_type(get_template_directory() . '/blocks/working-hours');
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
