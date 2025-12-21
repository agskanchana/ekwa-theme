<?php
/**
 * EKWA WebP Image Block Template
 *
 * Display a WebP image with fallback image support and optional link.
 * Uses modern <picture> element for optimal performance and browser compatibility.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 * @param   array $context The context provided to the block by the post or it's parent block.
 *
 * @package EKWA
 * @since 1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Create id attribute allowing for custom "anchor" value
$block_id = 'ekwa-webp-image-' . $block['id'];
if (!empty($block['anchor'])) {
    $block_id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and alignment
$class_name = 'ekwa-webp-image';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $class_name .= ' align' . $block['align'];
}

// Get ACF fields
$webp_image = get_field('webp_image');
$fallback_image = get_field('fallback_image');
$link = get_field('link');
$lazy_load = get_field('lazy_load') ?? true; // Default to true
$image_fit = get_field('image_fit') ?: 'cover'; // cover, contain, fill, none
$custom_width = get_field('custom_width');
$custom_height = get_field('custom_height');
$use_lqip = get_field('use_lqip') ?? false; // Low Quality Image Placeholder
$lqip_image = get_field('lqip_image');

// Validate required fields
if (!$fallback_image || !isset($fallback_image['url'])) {
    if ($is_preview) {
        echo '<div class="acf-block-placeholder" style="padding: 20px; background: #f5f5f5; text-align: center;">';
        echo '<p><strong>EKWA WebP Image</strong></p>';
        echo '<p>Please select a fallback image</p>';
        echo '</div>';
    }
    return;
}

// Extract image properties
$img_url = $fallback_image['url'];
$img_width = $custom_width ?: ($fallback_image['width'] ?? 'auto');
$img_height = $custom_height ?: ($fallback_image['height'] ?? 'auto');
$img_alt = $fallback_image['alt'] ?: get_the_title();

// Build lazysizes classes
$lazyload_class = $lazy_load ? 'lazyload' : '';
$blur_up_class = ($use_lqip && $lqip_image) ? 'blur-up' : '';
$img_classes = trim($lazyload_class . ' ' . $blur_up_class);

// Determine src and data attributes for lazysizes
$src_attr = 'src';
$srcset_attr = 'srcset';
if ($lazy_load) {
    $src_attr = 'data-src';
    $srcset_attr = 'data-srcset';
    // If LQIP is enabled, use low quality image as src
    if ($use_lqip && $lqip_image) {
        $img_url = $lqip_image['url'];
        $src_attr = 'src'; // LQIP goes in src, high quality in data-src
    }
}

// Collect custom CSS for consolidated output
if (!is_admin() && !$is_preview) {
    global $ekwa_section_head_styles;

    if (!isset($ekwa_section_head_styles)) {
        $ekwa_section_head_styles = [];
    }

    $image_css = "/* WebP Image Block Styles for #" . $block_id . " */\n";
    $image_css .= "#" . $block_id . " { display: block; }\n";
    $image_css .= "#" . $block_id . " img { vertical-align: bottom; object-fit: " . esc_attr($image_fit) . "; max-width: 100%; height: auto; }\n";
    
    // Add blur-up effect CSS if LQIP is used
    if ($use_lqip) {
        $image_css .= "#" . $block_id . " img.blur-up { filter: blur(5px); transition: filter 400ms; }\n";
        $image_css .= "#" . $block_id . " img.blur-up.lazyloaded { filter: blur(0); }\n";
    }

    // Apply custom dimensions if set
    if ($custom_width || $custom_height) {
        $image_css .= "#" . $block_id . " img {";
        if ($custom_width) {
            $image_css .= " width: " . esc_attr($custom_width) . (is_numeric($custom_width) ? 'px' : '') . ";";
        }
        if ($custom_height) {
            $image_css .= " height: " . esc_attr($custom_height) . (is_numeric($custom_height) ? 'px' : '') . ";";
        }
        $image_css .= " }\n";
    }

    // Alignment styles
    $image_css .= "#" . $block_id . ".alignleft { text-align: left; }\n";
    $image_css .= "#" . $block_id . ".aligncenter { text-align: center; }\n";
    $image_css .= "#" . $block_id . ".alignright { text-align: right; }\n";
    $image_css .= "#" . $block_id . ".alignwide { max-width: 1200px; margin-left: auto; margin-right: auto; }\n";
    $image_css .= "#" . $block_id . ".alignfull { max-width: 100%; }\n";

    $ekwa_section_head_styles[$block_id] = $image_css;
}

// Open link wrapper if link is provided
if ($link && !empty($link['url'])) :
    $link_url = $link['url'];
    $link_target = $link['target'] ?: '_self';
    $link_title = $link['title'] ?: $img_alt;
    ?>
    <a 
        href="<?php echo esc_url($link_url); ?>" 
        <?php if ($link_target === '_blank') : ?>
            target="_blank" 
            rel="noopener noreferrer"
        <?php endif; ?>
        <?php if ($link_title) : ?>
            aria-label="<?php echo esc_attr($link_title); ?>"
        <?php endif; ?>
    >
<?php endif; ?>

<picture 
    id="<?php echo esc_attr($block_id); ?>" 
    class="<?php echo esc_attr($class_name); ?>"
>
    <?php if ($webp_image && isset($webp_image['url']) && $lazy_load) : ?>
        <source data-srcset="<?php echo esc_url($webp_image['url']); ?>" type="image/webp">
    <?php elseif ($webp_image && isset($webp_image['url'])) : ?>
        <source srcset="<?php echo esc_url($webp_image['url']); ?>" type="image/webp">
    <?php endif; ?>
    
    <img 
        <?php if ($img_classes) : ?>class="<?php echo esc_attr($img_classes); ?>"<?php endif; ?>
        width="<?php echo esc_attr($img_width); ?>" 
        height="<?php echo esc_attr($img_height); ?>" 
        <?php if ($lazy_load && $use_lqip && $lqip_image) : ?>
            src="<?php echo esc_url($lqip_image['url']); ?>" 
            data-src="<?php echo esc_url($fallback_image['url']); ?>"
        <?php elseif ($lazy_load) : ?>
            data-src="<?php echo esc_url($img_url); ?>"
        <?php else : ?>
            src="<?php echo esc_url($img_url); ?>"
        <?php endif; ?>
        alt="<?php echo esc_attr($img_alt); ?>"
    >
</picture>

<?php if ($link && !empty($link['url'])) : ?>
    </a>
<?php endif; ?>

<?php
// Output inline styles for editor preview
if ($is_preview) :
?>
<style>
    #<?php echo esc_attr($block_id); ?> {
        display: block;
    }
    #<?php echo esc_attr($block_id); ?> img {
        vertical-align: bottom;
        object-fit: <?php echo esc_attr($image_fit); ?>;
        max-width: 100%;
        height: auto;
        <?php if ($custom_width) : ?>
        width: <?php echo esc_attr($custom_width); ?><?php echo is_numeric($custom_width) ? 'px' : ''; ?>;
        <?php endif; ?>
        <?php if ($custom_height) : ?>
        height: <?php echo esc_attr($custom_height); ?><?php echo is_numeric($custom_height) ? 'px' : ''; ?>;
        <?php endif; ?>
    }
    <?php if ($use_lqip) : ?>
    #<?php echo esc_attr($block_id); ?> img.blur-up {
        filter: blur(5px);
        transition: filter 400ms;
    }
    #<?php echo esc_attr($block_id); ?> img.blur-up.lazyloaded {
        filter: blur(0);
    }
    <?php endif; ?>
    #<?php echo esc_attr($block_id); ?>.alignleft {
        text-align: left;
    }
    #<?php echo esc_attr($block_id); ?>.aligncenter {
        text-align: center;
    }
    #<?php echo esc_attr($block_id); ?>.alignright {
        text-align: right;
    }
    #<?php echo esc_attr($block_id); ?>.alignwide {
        max-width: 1200px;
        margin-left: auto;
        margin-right: auto;
    }
    #<?php echo esc_attr($block_id); ?>.alignfull {
        max-width: 100%;
    }
</style>
<?php endif; ?>
