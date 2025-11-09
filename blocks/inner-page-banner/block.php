<?php
/**
 * EKWA Inner Page Banner Block Template
 *
 * Displays page header with title, breadcrumbs, and background image.
 * Optimized for performance with responsive images, lazy loading, and consolidated CSS.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

// Create id attribute allowing for custom "anchor" value
$block_id = 'ekwa-banner-' . $block['id'];
if (!empty($block['anchor'])) {
    $block_id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and alignment
$class_name = 'ekwa-inner-page-banner';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $class_name .= ' align' . $block['align'];
}

// Get ACF fields with proper defaults
$background_color = get_field('background_color') ?: '#000000';
$overlay_opacity = get_field('overlay_opacity');
$overlay_opacity = ($overlay_opacity !== false && $overlay_opacity !== null) ? intval($overlay_opacity) : 5;
$padding_top_bottom = get_field('padding_top_bottom') ?: 180;
$heading_color = get_field('heading_color') ?: '#ffffff';
$breadcrumb_color = get_field('breadcrumb_color') ?: '#ffffff';
$common_banner = get_field('common_banner');
$custom_css = get_field('custom_css');
$show_breadcrumbs = get_field('show_breadcrumbs') !== false; // Default true

/**
 * Banner Image Logic - Improved
 * Priority: Featured Image > Custom Banner > None
 * Uses responsive images with proper srcset and sizes attributes
 */
$banner_image_data = null;
$has_image = false;

// Check for featured image first
if (has_post_thumbnail($post_id)) {
    $has_image = true;
    $attachment_id = get_post_thumbnail_id($post_id);

    // Determine image size based on device detection
    $image_size = 'full';
    if (function_exists('is_mobile') && is_mobile()) {
        // Use mobile-specific size if available
        $image_size = 'featured_mobile';
    }

    // Get image data for more control
    $banner_image_data = [
        'id' => $attachment_id,
        'size' => $image_size,
        'alt' => get_post_meta($attachment_id, '_wp_attachment_image_alt', true) ?: get_the_title($post_id),
        'source' => 'featured'
    ];

} elseif ($common_banner && is_array($common_banner)) {
    // Fallback to custom banner field
    $has_image = true;
    $banner_image_data = [
        'id' => $common_banner['ID'],
        'size' => 'full',
        'alt' => $common_banner['alt'] ?: get_the_title($post_id),
        'source' => 'custom'
    ];
}

// Add modifier classes
if ($has_image) {
    $class_name .= ' ekwa-banner--has-image';
} else {
    $class_name .= ' ekwa-banner--text-only';
}

/**
 * Generate Page Heading
 * Uses custom heading or theme function or falls back to page title
 */
$page_heading_html = '';

if ($custom_heading) {
    // Custom heading override
    $page_heading_html = '<h1 class="ekwa-banner__title">' . esc_html($custom_heading) . '</h1>';
} elseif (function_exists('inner_page_heading')) {
    // Theme function if available
    ob_start();
    inner_page_heading($post_id);
    $page_heading_html = ob_get_clean();

} else {
    // Default fallback
    $page_heading_html = '<h1 class="ekwa-banner__title">' . esc_html(get_the_title($post_id)) . '</h1>';
}

/**
 * Collect custom CSS for consolidated output in <head>
 * This prevents Cumulative Layout Shift (CLS)
 */
if (!is_admin() && !$is_preview) {
    global $ekwa_section_head_styles;

    if (!isset($ekwa_section_head_styles)) {
        $ekwa_section_head_styles = [];
    }

    $banner_css = "/* Inner Page Banner Styles for #" . $block_id . " */\n";

    // Base styles
    $banner_css .= "#" . $block_id . " {\n";
    $banner_css .= "  position: relative;\n";
    $banner_css .= "  z-index: 10;\n";
    $banner_css .= "  text-align: center;\n";
    $banner_css .= "  overflow: hidden;\n";
    $banner_css .= "}\n\n";

    // Text-only banner padding
    if (!$has_image) {
        $banner_css .= "#" . $block_id . ".ekwa-banner--text-only {\n";
        $banner_css .= "  padding-top: " . intval($padding_top_bottom) . "px;\n";
        $banner_css .= "  padding-bottom: " . intval($padding_top_bottom) . "px;\n";
        $banner_css .= "  background: " . esc_attr($background_color) . ";\n";
        $banner_css .= "}\n\n";
    }

    // Image styling
    $banner_css .= "#" . $block_id . " .ekwa-banner__image {\n";
    $banner_css .= "  width: 100%;\n";
    $banner_css .= "  height: auto;\n";
    $banner_css .= "  display: block;\n";
    $banner_css .= "  object-fit: cover;\n";
    $banner_css .= "}\n\n";

    // Overlay - only if image exists
    if ($has_image && $overlay_opacity > 0) {
        $banner_css .= "#" . $block_id . "::before {\n";
        $banner_css .= "  content: '';\n";
        $banner_css .= "  position: absolute;\n";
        $banner_css .= "  top: 0;\n";
        $banner_css .= "  left: 0;\n";
        $banner_css .= "  width: 100%;\n";
        $banner_css .= "  height: 100%;\n";
        $banner_css .= "  z-index: 100;\n";
        $banner_css .= "  background: " . esc_attr($background_color) . ";\n";
        $banner_css .= "  opacity: 0." . $overlay_opacity . ";\n";
        $banner_css .= "  pointer-events: none;\n";
        $banner_css .= "}\n\n";
    }

    // Container positioning
    $banner_css .= "#" . $block_id . " .ekwa-banner__container {\n";
    if ($has_image) {
        $banner_css .= "  position: absolute;\n";
        $banner_css .= "  top: 50%;\n";
        $banner_css .= "  left: 0;\n";
        $banner_css .= "  right: 0;\n";
        $banner_css .= "  transform: translateY(-50%);\n";
        $banner_css .= "  z-index: 200;\n";
    } else {
        $banner_css .= "  position: relative;\n";
        $banner_css .= "  z-index: 200;\n";
    }
    $banner_css .= "}\n\n";

    // Text colors
    $banner_css .= "#" . $block_id . " .ekwa-banner__container,\n";
    $banner_css .= "#" . $block_id . " .ekwa-banner__title {\n";
    $banner_css .= "  color: " . esc_attr($heading_color) . ";\n";
    $banner_css .= "}\n\n";

    $banner_css .= "#" . $block_id . " .ekwa-banner__breadcrumbs,\n";
    $banner_css .= "#" . $block_id . " .ekwa-banner__breadcrumbs a {\n";
    $banner_css .= "  color: " . esc_attr($breadcrumb_color) . ";\n";
    $banner_css .= "}\n\n";

    // Title styling
    $banner_css .= "#" . $block_id . " .ekwa-banner__title {\n";
    $banner_css .= "  margin-bottom: 15px;\n";
    $banner_css .= "  line-height: 1.2;\n";
    $banner_css .= "}\n\n";

    // Breadcrumbs styling
    $banner_css .= "#" . $block_id . " .ekwa-banner__breadcrumbs {\n";
    $banner_css .= "  margin-top: 10px;\n";
    $banner_css .= "}\n\n";

    // Custom CSS
    if ($custom_css) {
        $banner_css .= "/* Custom CSS for #" . $block_id . " */\n";
        $banner_css .= wp_strip_all_tags($custom_css) . "\n";
    }

    // Store for <head> output
    if (!empty($banner_css)) {
        $ekwa_section_head_styles[$block_id] = $banner_css;
    }
}
?>

<section id="<?php echo esc_attr($block_id); ?>" class="<?php echo esc_attr($class_name); ?>" <?php if ($has_image): ?>role="banner"<?php endif; ?>>
    <?php if ($has_image && $banner_image_data): ?>
        <?php
        // Generate responsive image with proper attributes
        $image_attrs = [
            'class' => 'ekwa-banner__image',
            'alt' => esc_attr($banner_image_data['alt']),
            'loading' => 'eager', // Banner images should load immediately
        ];

        // Use wp_get_attachment_image for proper srcset and sizes
        echo wp_get_attachment_image(
            $banner_image_data['id'],
            $banner_image_data['size'],
            false,
            $image_attrs
        );
        ?>
    <?php endif; ?>

    <div class="container ekwa-banner__container">
        <?php
        // Output heading HTML (already escaped in generation)
        echo $page_heading_html;
        ?>

        <?php if ($show_breadcrumbs && function_exists('yoast_breadcrumb')): ?>
            <nav class="ekwa-banner__breadcrumbs" aria-label="Breadcrumb">
                <?php yoast_breadcrumb('<span id="breadcrumbs">', '</span>'); ?>
            </nav>
        <?php endif; ?>
    </div>
</section>

<?php
// Output styles only in editor preview
if ($is_preview): ?>
<style>
    /* Editor preview styles */
    #<?php echo esc_attr($block_id); ?> {
        position: relative;
        z-index: 10;
        text-align: center;
        min-height: 300px;
        overflow: hidden;
    }

    <?php if (!$has_image): ?>
    #<?php echo esc_attr($block_id); ?>.ekwa-banner--text-only {
        padding-top: <?php echo intval($padding_top_bottom); ?>px;
        padding-bottom: <?php echo intval($padding_top_bottom); ?>px;
        background: <?php echo esc_attr($background_color); ?>;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    <?php endif; ?>

    #<?php echo esc_attr($block_id); ?> .ekwa-banner__image {
        width: 100%;
        height: auto;
        display: block;
        object-fit: cover;
    }

    <?php if ($has_image && $overlay_opacity > 0): ?>
    #<?php echo esc_attr($block_id); ?>::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 100;
        background: <?php echo esc_attr($background_color); ?>;
        opacity: 0.<?php echo $overlay_opacity; ?>;
        pointer-events: none;
    }
    <?php endif; ?>

    #<?php echo esc_attr($block_id); ?> .ekwa-banner__container {
        <?php if ($has_image): ?>
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        transform: translateY(-50%);
        <?php else: ?>
        position: relative;
        <?php endif; ?>
        z-index: 200;
    }

    #<?php echo esc_attr($block_id); ?> .ekwa-banner__container,
    #<?php echo esc_attr($block_id); ?> .ekwa-banner__title {
        color: <?php echo esc_attr($heading_color); ?>;
    }

    #<?php echo esc_attr($block_id); ?> .ekwa-banner__title {
        font-size: 36px;
        margin-bottom: 15px;
        line-height: 1.2;
    }

    #<?php echo esc_attr($block_id); ?> .ekwa-banner__breadcrumbs,
    #<?php echo esc_attr($block_id); ?> .ekwa-banner__breadcrumbs a {
        color: <?php echo esc_attr($breadcrumb_color); ?>;
    }

    #<?php echo esc_attr($block_id); ?> .ekwa-banner__breadcrumbs {
        margin-top: 10px;
    }

    <?php if ($custom_css): ?>
    /* Custom CSS Preview */
    <?php echo wp_strip_all_tags($custom_css); ?>
    <?php endif; ?>
</style>
<?php endif; ?>