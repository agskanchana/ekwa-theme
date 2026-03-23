<?php
/**
 * EKWA Copyright Block Template
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

// Create id attribute allowing for custom "anchor" value.
$block_id = 'ekwa-copyright-' . $block['id'];
if (!empty($block['anchor'])) {
    $block_id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and alignment
$class_name = 'ekwa-copyright';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $class_name .= ' align' . $block['align'];
}

// Get ACF fields with defaults
$text_color = get_field('text_color') ?: '#000000';
$link_color = get_field('link_color') ?: '#1e73be';
$link_color_hover = get_field('link_color_hover') ?: '#0d5aa7';

// Get practice name from theme settings
$practice_name = get_theme_mod('practise_name', get_bloginfo('name'));
$current_year = wp_date('Y');

// Collect custom CSS for consolidated output
if (!is_admin() && !$is_preview) {
    global $ekwa_section_head_styles;

    if (!isset($ekwa_section_head_styles)) {
        $ekwa_section_head_styles = [];
    }

    $copyright_css = "/* Copyright Block Styles for #" . $block_id . " */\n";
    $copyright_css .= "#" . $block_id . " { color: " . esc_attr($text_color) . "; }\n";
    $copyright_css .= "#" . $block_id . " a { color: " . esc_attr($link_color) . "; }\n";
    $copyright_css .= "#" . $block_id . " a:hover { color: " . esc_attr($link_color_hover) . "; }\n";

    $ekwa_section_head_styles[$block_id] = $copyright_css;
}
?>

<div id="<?php echo esc_attr($block_id); ?>" class="<?php echo esc_attr($class_name); ?>">
    &copy; <?php echo esc_html($current_year); ?> <?php echo esc_html($practice_name); ?>. All Rights Reserved.
    Powered by <a href="https://www.ekwa.com" target="_blank" rel="noreferrer nofollow">www.ekwa.com</a>
</div>

<?php
// Output styles only in editor preview
if ($is_preview): ?>
<style>
    /* Editor preview styles */
    #<?php echo esc_attr($block_id); ?> {
        padding: 15px;
        border: 1px dashed #e0e0e0;
        color: <?php echo esc_attr($text_color); ?>;
    }

    #<?php echo esc_attr($block_id); ?> a {
        color: <?php echo esc_attr($link_color); ?>;
        text-decoration: none;
    }

    #<?php echo esc_attr($block_id); ?> a:hover {
        color: <?php echo esc_attr($link_color_hover); ?>;
        text-decoration: underline;
    }
</style>
<?php endif; ?>
