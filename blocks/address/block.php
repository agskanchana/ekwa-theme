<?php
/**
 * EKWA Address Block Template
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

// Create id attribute allowing for custom "anchor" value.
$block_id = 'ekwa-address-' . $block['id'];
if (!empty($block['anchor'])) {
    $block_id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and alignment
$class_name = 'ekwa-address';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $class_name .= ' align' . $block['align'];
}

// Get ACF fields
$mode = get_field('mode') ?: 'icon';
$location = get_field('location') ?: 1;
$text_color = get_field('text_color') ?: '#000000';
$icon_color = get_field('icon_color') ?: '#1e73be';

// Get direction link from theme function
$direction_url = '';
if (function_exists('get_location')) {
    $direction_url = get_location('direction', $location);
}

// Get address if mode is address
$address_text = '';
if ($mode === 'address' && function_exists('get_address')) {
    $address_text = get_address($location);
}

// Add mode class
$class_name .= ' ekwa-address--' . $mode;

// Collect custom CSS for consolidated output
if (!is_admin() && !$is_preview && $mode !== 'icon') {
    global $ekwa_section_head_styles;

    if (!isset($ekwa_section_head_styles)) {
        $ekwa_section_head_styles = [];
    }

    $direction_css = "/* Address Block Styles for #" . $block_id . " */\n";
    $direction_css .= "#" . $block_id . " { color: " . esc_attr($text_color) . "; }\n";
    $direction_css .= "#" . $block_id . " .ekwa-address__icon { color: " . esc_attr($icon_color) . "; }\n";

    $ekwa_section_head_styles[$block_id] = $direction_css;
}
?>

<a
    id="<?php echo esc_attr($block_id); ?>"
    class="<?php echo esc_attr($class_name); ?>"
    href="<?php echo esc_url($direction_url); ?>"
    target="_blank"
    rel="noreferrer nofollow"
    aria-label="Get directions to our location"
>
    <svg class="ekwa-address__icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <path d="M12 2C8.13 2 5 5.13 5 9C5 14.25 12 22 12 22C12 22 19 14.25 19 9C19 5.13 15.87 2 12 2ZM12 11.5C10.62 11.5 9.5 10.38 9.5 9C9.5 7.62 10.62 6.5 12 6.5C13.38 6.5 14.5 7.62 14.5 9C14.5 10.38 13.38 11.5 12 11.5Z" fill="currentColor"/>
    </svg>

    <?php if ($mode === 'text'): ?>
        <span class="ekwa-address__text">Directions</span>
    <?php elseif ($mode === 'address' && $address_text): ?>
        <span class="ekwa-address__address"><?php echo wp_kses_post($address_text); ?></span>
    <?php endif; ?>
</a>

<?php
// Output styles only in editor preview
if ($is_preview): ?>
<style>
    /* Editor preview styles */
    #<?php echo esc_attr($block_id); ?> {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 15px;
        border: 1px dashed #e0e0e0;
        text-decoration: none;
        transition: opacity 0.3s ease;
        <?php if ($mode !== 'icon'): ?>
        color: <?php echo esc_attr($text_color); ?>;
        <?php endif; ?>
    }

    #<?php echo esc_attr($block_id); ?>:hover {
        opacity: 0.8;
    }

    #<?php echo esc_attr($block_id); ?> .ekwa-address__icon {
        width: 24px;
        height: 24px;
        flex-shrink: 0;
        <?php if ($mode !== 'icon'): ?>
        color: <?php echo esc_attr($icon_color); ?>;
        <?php endif; ?>
    }

    #<?php echo esc_attr($block_id); ?>.ekwa-address--icon {
        padding: 12px;
        border-radius: 50%;
        background: #f5f5f5;
    }

    #<?php echo esc_attr($block_id); ?>.ekwa-address--icon .ekwa-address__icon {
        color: #1e73be;
    }
</style>
<?php endif; ?>
