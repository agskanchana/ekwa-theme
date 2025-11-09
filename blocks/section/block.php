<?php
/**
 * EKWA Section Block Template - Optimized for Performance & CLS
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

// Create id attribute allowing for custom "anchor" value.
$block_id = 'ekwa-section-' . $block['id'];
if (!empty($block['anchor'])) {
    $block_id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'ekwa-section';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $class_name .= ' align' . $block['align'];
}

// Get ACF fields
$html_element = get_field('html_element') ?: 'section';
$background_color = get_field('background_color');
$background_image = get_field('background_image');
$background_size = get_field('background_size') ?: 'cover';
$background_position = get_field('background_position') ?: 'center center';
$background_repeat = get_field('background_repeat') ?: 'no-repeat';
$background_attachment = get_field('background_attachment') ?: 'scroll';
$lazyload = get_field('lazyload');
$desktop_only = get_field('desktop_only');
$custom_css = get_field('custom_css');

// Add modifier classes
if ($lazyload && $background_image) {
    $class_name .= ' lazyload';
}
if ($desktop_only) {
    $class_name .= ' ekwa-section--desktop-only';
}

// Allowed HTML elements
$allowed_elements = ['section', 'aside', 'main', 'article'];
$html_element = in_array($html_element, $allowed_elements) ? $html_element : 'section';

// Prepare inline styles (critical for immediate render)
$inline_styles = [];

// Background color
if ($background_color) {
    $inline_styles[] = 'background-color: ' . esc_attr($background_color);
}

// Background image - only if not lazyloading and not desktop only
if ($background_image && !$lazyload && !$desktop_only) {
    $inline_styles[] = 'background-image: url(' . esc_url($background_image['url']) . ')';
    $inline_styles[] = 'background-size: ' . esc_attr($background_size);
    $inline_styles[] = 'background-position: ' . esc_attr($background_position);
    $inline_styles[] = 'background-repeat: ' . esc_attr($background_repeat);
    $inline_styles[] = 'background-attachment: ' . esc_attr($background_attachment);
}

$style_attr = !empty($inline_styles) ? ' style="' . implode('; ', $inline_styles) . '"' : '';

// Collect custom CSS for consolidated <head> output (prevents CLS)
if (!is_admin() && !$is_preview) {
    global $ekwa_section_head_styles;

    if (!isset($ekwa_section_head_styles)) {
        $ekwa_section_head_styles = [];
    }

    $section_css = '';

    // Desktop only background styles
    if ($desktop_only && $background_image && !$lazyload) {
        $section_css .= "@media screen and (min-width: 767px) {\n";
        $section_css .= "  #" . $block_id . " {\n";
        $section_css .= "    background-image: url(" . esc_url($background_image['url']) . ");\n";
        $section_css .= "    background-size: " . esc_attr($background_size) . ";\n";
        $section_css .= "    background-position: " . esc_attr($background_position) . ";\n";
        $section_css .= "    background-repeat: " . esc_attr($background_repeat) . ";\n";
        $section_css .= "    background-attachment: " . esc_attr($background_attachment) . ";\n";
        $section_css .= "  }\n";
        $section_css .= "}\n";
    }

    // Desktop only with lazyload
    if ($desktop_only && $background_image && $lazyload) {
        $section_css .= "@media screen and (min-width: 767px) {\n";
        $section_css .= "  #" . $block_id . ".lazyloaded {\n";
        $section_css .= "    background-size: " . esc_attr($background_size) . ";\n";
        $section_css .= "    background-position: " . esc_attr($background_position) . ";\n";
        $section_css .= "    background-repeat: " . esc_attr($background_repeat) . ";\n";
        $section_css .= "    background-attachment: " . esc_attr($background_attachment) . ";\n";
        $section_css .= "  }\n";
        $section_css .= "}\n";
    }

    // Lazyload background (no desktop only)
    if (!$desktop_only && $lazyload && $background_image) {
        $section_css .= "#" . $block_id . ".lazyloaded {\n";
        $section_css .= "  background-size: " . esc_attr($background_size) . ";\n";
        $section_css .= "  background-position: " . esc_attr($background_position) . ";\n";
        $section_css .= "  background-repeat: " . esc_attr($background_repeat) . ";\n";
        $section_css .= "  background-attachment: " . esc_attr($background_attachment) . ";\n";
        $section_css .= "}\n";
    }

    // Custom CSS
    if ($custom_css) {
        $section_css .= "/* Custom CSS for #" . $block_id . " */\n";
        $section_css .= wp_strip_all_tags($custom_css) . "\n";
    }

    // Store for <head> output
    if (!empty($section_css)) {
        $ekwa_section_head_styles[$block_id] = $section_css;
    }
}

// InnerBlocks - allow all blocks
$template = [
    ['core/paragraph', ['placeholder' => 'Add content here...']],
];
?>

<<?php echo esc_html($html_element); ?>
    id="<?php echo esc_attr($block_id); ?>"
    class="<?php echo esc_attr($class_name); ?>"
    <?php echo $style_attr; ?>
    <?php if ($lazyload && $background_image): ?>
        data-bg="<?php echo esc_url($background_image['url']); ?>"
    <?php endif; ?>
>
    <div class="ekwa-section__inner">
        <InnerBlocks template="<?php echo esc_attr(wp_json_encode($template)); ?>" />
    </div>
</<?php echo esc_html($html_element); ?>>

<?php
// Output styles ONLY in editor preview (for convenience)
if ($is_preview): ?>
<style>
    /* Editor preview styles */
    #<?php echo esc_attr($block_id); ?> {
        padding: 30px;
        border: 1px solid #e0e0e0;
        min-height: 100px;
    }
    #<?php echo esc_attr($block_id); ?> .ekwa-section__inner {
        position: relative;
        z-index: 1;
    }

    <?php if ($desktop_only && $background_image && !$lazyload): ?>
    /* Desktop only background */
    @media screen and (min-width: 767px) {
        #<?php echo esc_attr($block_id); ?> {
            background-image: url(<?php echo esc_url($background_image['url']); ?>);
            background-size: <?php echo esc_attr($background_size); ?>;
            background-position: <?php echo esc_attr($background_position); ?>;
            background-repeat: <?php echo esc_attr($background_repeat); ?>;
            background-attachment: <?php echo esc_attr($background_attachment); ?>;
        }
    }
    <?php endif; ?>

    <?php if ($custom_css): ?>
    /* Custom CSS Preview */
    <?php echo wp_strip_all_tags($custom_css); ?>
    <?php endif; ?>
</style>
<?php endif; ?>
