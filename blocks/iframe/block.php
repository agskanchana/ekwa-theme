<?php
/**
 * EKWA Iframe Block Template
 *
 * Enhanced iframe embed block with responsive sizing, lazy loading,
 * aspect ratio control, and accessibility features.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

// Create id attribute allowing for custom "anchor" value
$block_id = 'ekwa-iframe-' . $block['id'];
if (!empty($block['anchor'])) {
    $block_id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and alignment
$class_name = 'ekwa-iframe-wrapper';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $class_name .= ' align' . $block['align'];
}

// Get ACF fields
$iframe_source = get_field('iframe_source') ?: '';
$iframe_title = get_field('iframe_title') ?: 'Embedded content';
$width_type = get_field('width_type') ?: 'responsive';
$custom_width = get_field('custom_width') ?: '100%';
$height_type = get_field('height_type') ?: 'custom';
$aspect_ratio = get_field('aspect_ratio') ?: '16:9';
$custom_height = get_field('custom_height') ?: '450px';
$lazy_load = get_field('lazy_load') !== false; // Default true
$border = get_field('border') !== false; // Default true
$allow_fullscreen = get_field('allow_fullscreen') !== false; // Default true
$loading_placeholder = get_field('loading_placeholder') ?: 'default';

// Calculate dimensions
$width = $width_type === 'custom' ? $custom_width : '100%';
$use_aspect_ratio = $height_type === 'aspect_ratio';

// Parse aspect ratio
$aspect_padding = '56.25%'; // Default 16:9
if ($use_aspect_ratio && $aspect_ratio) {
    $ratio_parts = explode(':', $aspect_ratio);
    if (count($ratio_parts) === 2 && is_numeric($ratio_parts[0]) && is_numeric($ratio_parts[1])) {
        $aspect_padding = ($ratio_parts[1] / $ratio_parts[0]) * 100 . '%';
    }
}

// Sanitize iframe URL
$iframe_url = esc_url($iframe_source);

// Collect custom CSS for consolidated output
if (!is_admin() && !$is_preview) {
    global $ekwa_section_head_styles;

    if (!isset($ekwa_section_head_styles)) {
        $ekwa_section_head_styles = [];
    }

    $iframe_css = "/* Iframe Block Styles for #" . $block_id . " */\n";
    $iframe_css .= "#" . $block_id . " { position: relative; overflow: hidden;";

    if ($width_type === 'custom') {
        $iframe_css .= " max-width: " . esc_attr($custom_width) . ";";
    }

    $iframe_css .= " }\n";

    if ($use_aspect_ratio) {
        $iframe_css .= "#" . $block_id . " .ekwa-iframe-container { position: relative; padding-bottom: " . $aspect_padding . "; height: 0; overflow: hidden; }\n";
        $iframe_css .= "#" . $block_id . " .ekwa-iframe-container iframe { position: absolute; top: 0; left: 0; width: 100%; height: 100%; }\n";
    } else {
        $iframe_css .= "#" . $block_id . " iframe { width: 100%; height: " . esc_attr($custom_height) . "; display: block; }\n";
    }

    if (!$border) {
        $iframe_css .= "#" . $block_id . " iframe { border: 0; }\n";
    }

    $ekwa_section_head_styles[$block_id] = $iframe_css;
}

// Prepare iframe attributes
$iframe_attrs = [];
$iframe_attrs['title'] = esc_attr($iframe_title);
$iframe_attrs['width'] = '100%';
$iframe_attrs['height'] = '100%';
$iframe_attrs['loading'] = 'lazy';
$iframe_attrs['referrerpolicy'] = 'no-referrer-when-downgrade';

if (!$border) {
    $iframe_attrs['style'] = 'border:0;';
}

if ($allow_fullscreen) {
    $iframe_attrs['allowfullscreen'] = '';
}

// Build iframe attributes string
$iframe_attrs_string = '';
foreach ($iframe_attrs as $key => $value) {
    if ($value === '') {
        $iframe_attrs_string .= ' ' . $key;
    } else {
        $iframe_attrs_string .= ' ' . $key . '="' . $value . '"';
    }
}

// Loading placeholder content
$placeholder_content = '';
if ($loading_placeholder === 'spinner') {
    $placeholder_content = '<div class="ekwa-iframe-loading" aria-hidden="true"><div class="ekwa-iframe-spinner"></div></div>';
} elseif ($loading_placeholder === 'text') {
    $placeholder_content = '<div class="ekwa-iframe-loading" aria-hidden="true"><p>Loading...</p></div>';
}
?>

<div id="<?php echo esc_attr($block_id); ?>" class="<?php echo esc_attr($class_name); ?>">
    <?php if (!empty($iframe_url)): ?>
        <?php if ($use_aspect_ratio): ?>
            <div class="ekwa-iframe-container">
                <?php echo $placeholder_content; ?>
                <?php if ($lazy_load): ?>
                    <iframe class="lazyload" data-src="<?php echo $iframe_url; ?>"<?php echo $iframe_attrs_string; ?>></iframe>
                <?php else: ?>
                    <iframe src="<?php echo $iframe_url; ?>"<?php echo $iframe_attrs_string; ?>></iframe>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <?php echo $placeholder_content; ?>
            <?php if ($lazy_load): ?>
                <iframe class="lazyload" data-src="<?php echo $iframe_url; ?>"<?php echo $iframe_attrs_string; ?>></iframe>
            <?php else: ?>
                <iframe src="<?php echo $iframe_url; ?>"<?php echo $iframe_attrs_string; ?>></iframe>
            <?php endif; ?>
        <?php endif; ?>
    <?php else: ?>
        <div class="ekwa-iframe-placeholder" style="padding: 40px; background: #f0f0f0; border: 2px dashed #ccc; text-align: center; border-radius: 4px;">
            <p style="margin: 0; color: #666;">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-bottom: 10px;">
                    <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                    <line x1="8" y1="21" x2="16" y2="21"></line>
                    <line x1="12" y1="17" x2="12" y2="21"></line>
                </svg>
                <br>
                <strong>Iframe Block</strong><br>
                <small>Enter an iframe source URL in the block settings</small>
            </p>
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
        overflow: hidden;
        margin: 20px 0;
        <?php if ($width_type === 'custom'): ?>
        max-width: <?php echo esc_attr($custom_width); ?>;
        <?php endif; ?>
    }

    #<?php echo esc_attr($block_id); ?>.alignwide {
        max-width: 1200px;
    }

    #<?php echo esc_attr($block_id); ?>.alignfull {
        max-width: 100%;
    }

    <?php if ($use_aspect_ratio): ?>
    #<?php echo esc_attr($block_id); ?> .ekwa-iframe-container {
        position: relative;
        padding-bottom: <?php echo $aspect_padding; ?>;
        height: 0;
        overflow: hidden;
        background: #f5f5f5;
    }

    #<?php echo esc_attr($block_id); ?> .ekwa-iframe-container iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
    <?php else: ?>
    #<?php echo esc_attr($block_id); ?> iframe {
        width: 100%;
        height: <?php echo esc_attr($custom_height); ?>;
        display: block;
    }
    <?php endif; ?>

    <?php if (!$border): ?>
    #<?php echo esc_attr($block_id); ?> iframe {
        border: 0;
    }
    <?php endif; ?>

    /* Loading placeholder styles */
    .ekwa-iframe-loading {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f5f5f5;
        z-index: 1;
    }

    .ekwa-iframe-spinner {
        width: 40px;
        height: 40px;
        border: 4px solid #e0e0e0;
        border-top-color: #666;
        border-radius: 50%;
        animation: ekwa-spinner-rotate 1s linear infinite;
    }

    @keyframes ekwa-spinner-rotate {
        to { transform: rotate(360deg); }
    }

    .ekwa-iframe-loading p {
        color: #666;
        font-size: 14px;
        margin: 0;
    }

    /* Hide loading when iframe loads */
    #<?php echo esc_attr($block_id); ?> iframe.lazyloaded ~ .ekwa-iframe-loading,
    #<?php echo esc_attr($block_id); ?> .ekwa-iframe-container iframe.lazyloaded ~ .ekwa-iframe-loading {
        display: none;
    }
</style>

<script>
(function($) {
    'use strict';

    // Hide loading placeholder when iframe loads
    $('#<?php echo esc_attr($block_id); ?> iframe').on('load', function() {
        $(this).siblings('.ekwa-iframe-loading').fadeOut(300);
    });

})(jQuery);
</script>
<?php endif; ?>
