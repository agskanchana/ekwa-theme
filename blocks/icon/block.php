<?php
/**
 * EKWA Icon Block Template
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

// Create id attribute allowing for custom "anchor" value.
$block_id = 'ekwa-icon-' . $block['id'];
if (!empty($block['anchor'])) {
    $block_id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and alignment
$class_name = 'ekwa-icon';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $class_name .= ' align' . $block['align'];
}

// Get ACF fields
$icon_value = get_field('icon_data')['value'] ?? '';

$icon_size = get_field('icon_size') ?: '48';
$icon_color = get_field('icon_color') ?: '#1e73be';
$link_type = get_field('link_type') ?: 'none';
$custom_link = get_field('custom_link');

// Determine link URL
$link_url = '';
$link_target = '';
$link_title = '';

if ($link_type === 'phone') {
    $phone_number = get_theme_mod('call_tracking_number', '');
    if (function_exists('mobile_number')) {
        $phone_number = mobile_number($phone_number);
    }
    $link_url = 'tel:' . $phone_number;
    $link_title = 'Call us at ' . $phone_number;
} elseif ($link_type === 'link' && $custom_link) {
    $link_url = $custom_link['url'];
    $link_target = $custom_link['target'] ?: '';
    $link_title = $custom_link['title'] ?: '';
}

// Collect custom CSS for consolidated output
if (!is_admin() && !$is_preview) {
    global $ekwa_section_head_styles;

    if (!isset($ekwa_section_head_styles)) {
        $ekwa_section_head_styles = [];
    }

    $icon_css = "/* Icon Block Styles for #" . $block_id . " */\n";
    $icon_css .= "#" . $block_id . " .ekwa-icon__svg { width: " . esc_attr($icon_size) . "px; height: " . esc_attr($icon_size) . "px; display: inline-block; }\n";
    $icon_css .= "#" . $block_id . " .ekwa-icon__svg svg { width: 100%; height: 100%; fill: " . esc_attr($icon_color) . "; }\n";

    $ekwa_section_head_styles[$block_id] = $icon_css;
}

// Wrapper opening tag
$wrapper_tag = 'div';
$wrapper_attrs = 'id="' . esc_attr($block_id) . '" class="' . esc_attr($class_name) . '"';

if ($link_url) {
    $wrapper_tag = 'a';
    $wrapper_attrs = 'id="' . esc_attr($block_id) . '" class="' . esc_attr($class_name) . '" href="' . esc_url($link_url) . '"';

    if ($link_target) {
        $wrapper_attrs .= ' target="' . esc_attr($link_target) . '"';
        if ($link_target === '_blank') {
            $wrapper_attrs .= ' rel="noopener noreferrer"';
        }
    }

    if ($link_title) {
        $wrapper_attrs .= ' aria-label="' . esc_attr($link_title) . '"';
    } else {
        $wrapper_attrs .= ' aria-label="Icon link"';
    }
}
?>

<<?php echo $wrapper_tag; ?> <?php echo $wrapper_attrs; ?>>
    <?php if (!empty($icon_value) && strpos($icon_value, '<svg') !== false): ?>
        <div class="ekwa-icon__svg" aria-hidden="true">
            <?php echo $icon_value; // SVG code already sanitized ?>
        </div>
    <?php else: ?>
        <div class="ekwa-icon__svg" aria-hidden="true">
            <i class="fas fa-icons"></i>
        </div>
    <?php endif; ?>
</<?php echo $wrapper_tag; ?>>

<?php
// Output styles only in editor preview
if ($is_preview): ?>
<style>
    /* Editor preview styles */
    #<?php echo esc_attr($block_id); ?> {
        display: inline-block;
        line-height: 1;
        transition: opacity 0.3s ease;
    }

    #<?php echo esc_attr($block_id); ?>.alignleft {
        text-align: left;
    }

    #<?php echo esc_attr($block_id); ?>.aligncenter {
        text-align: center;
        display: block;
    }

    #<?php echo esc_attr($block_id); ?>.alignright {
        text-align: right;
        display: block;
    }

    <?php if ($link_url): ?>
    #<?php echo esc_attr($block_id); ?>:hover {
        opacity: 0.8;
    }
    <?php endif; ?>

    #<?php echo esc_attr($block_id); ?> .ekwa-icon__svg {
        display: inline-block;
        width: <?php echo esc_attr($icon_size); ?>px;
        height: <?php echo esc_attr($icon_size); ?>px;
        line-height: 1;
    }

    #<?php echo esc_attr($block_id); ?> .ekwa-icon__svg svg {
        width: 100%;
        height: 100%;
        fill: <?php echo esc_attr($icon_color); ?>;
    }

    #<?php echo esc_attr($block_id); ?> .ekwa-icon__svg svg path,
    #<?php echo esc_attr($block_id); ?> .ekwa-icon__svg svg circle,
    #<?php echo esc_attr($block_id); ?> .ekwa-icon__svg svg rect,
    #<?php echo esc_attr($block_id); ?> .ekwa-icon__svg svg polygon {
        fill: <?php echo esc_attr($icon_color); ?>;
    }

    #<?php echo esc_attr($block_id); ?> .ekwa-icon__svg i {
        font-size: <?php echo esc_attr($icon_size); ?>px;
        color: #ccc;
    }
</style>
<?php endif; ?>
