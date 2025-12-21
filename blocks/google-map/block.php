<?php
/**
 * EKWA Google Map Block Template
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

// Create id attribute allowing for custom "anchor" value.
$block_id = 'ekwa-google-map-' . $block['id'];
if (!empty($block['anchor'])) {
    $block_id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and alignment
$class_name = 'ekwa-google-map';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $class_name .= ' align' . $block['align'];
}

// Get ACF fields
$iframe_input = get_field('iframe_input');
$map_height = get_field('map_height') ?: 450;
$map_title = get_field('map_title') ?: 'Google Map';

// Extract src from iframe or use input directly
$map_src = '';

if (!empty($iframe_input)) {
    $iframe_input = trim($iframe_input);
    
    // Check if input contains iframe tag
    if (strpos($iframe_input, '<iframe') !== false) {
        // Extract src from iframe using regex
        if (preg_match('/src=["\']([^"\']+)["\']/', $iframe_input, $matches)) {
            $map_src = $matches[1];
        }
    } else {
        // Use input directly as src URL
        $map_src = $iframe_input;
    }
}

// Collect custom CSS for consolidated output
if (!is_admin() && !$is_preview) {
    global $ekwa_section_head_styles;

    if (!isset($ekwa_section_head_styles)) {
        $ekwa_section_head_styles = [];
    }

    $map_css = "/* Google Map Styles for #" . $block_id . " */\n";
    $map_css .= "#" . $block_id . " { position: relative; width: 100%; overflow: hidden; }\n";
    $map_css .= "#" . $block_id . " iframe { width: 100%; height: " . intval($map_height) . "px; border: 0; display: block; }\n";

    $ekwa_section_head_styles[$block_id] = $map_css;
}
?>

<div id="<?php echo esc_attr($block_id); ?>" class="<?php echo esc_attr($class_name); ?>">
    <?php if (!empty($map_src)): ?>
        <?php if ($is_preview): ?>
            <iframe
                src="<?php echo esc_url($map_src); ?>"
                width="100%"
                height="<?php echo esc_attr($map_height); ?>"
                style="border:0;"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                title="<?php echo esc_attr($map_title); ?>">
            </iframe>
        <?php else: ?>
            <iframe
                data-src="<?php echo esc_url($map_src); ?>"
                class="lazyload"
                width="100%"
                height="<?php echo esc_attr($map_height); ?>"
                style="border:0;"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                title="<?php echo esc_attr($map_title); ?>">
            </iframe>
        <?php endif; ?>
    <?php else: ?>
        <div class="ekwa-google-map__placeholder">
            <p>Please add a Google Map iframe code or URL in the block settings.</p>
        </div>
    <?php endif; ?>
</div>

<?php
// Output styles only in editor preview
if ($is_preview): ?>
<style>
    /* Editor preview styles */
    #<?php echo esc_attr($block_id); ?> {
        position: relative;
        width: 100%;
        overflow: hidden;
        border: 1px dashed #e0e0e0;
        background: #fafafa;
    }

    #<?php echo esc_attr($block_id); ?> iframe {
        width: 100%;
        height: <?php echo intval($map_height); ?>px;
        border: 0;
        display: block;
    }

    #<?php echo esc_attr($block_id); ?> .ekwa-google-map__placeholder {
        padding: 40px 20px;
        text-align: center;
        background: #f5f5f5;
        border: 2px dashed #ddd;
        border-radius: 8px;
    }

    #<?php echo esc_attr($block_id); ?> .ekwa-google-map__placeholder p {
        margin: 0;
        color: #666;
        font-size: 14px;
    }
</style>
<?php endif; ?>
