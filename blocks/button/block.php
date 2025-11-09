<?php
/**
 * EKWA Button Block Template
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

// Create id attribute allowing for custom "anchor" value.
$block_id = 'ekwa-button-' . $block['id'];
if (!empty($block['anchor'])) {
    $block_id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'ekwa-button btn';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $class_name .= ' align' . $block['align'];
}

// Get ACF fields
$text = get_field('text');
$link = get_field('link');
$icon = get_field('icon');
$phone_number_btn = get_field('phone_number');
$show_phone_desktop = get_field('show_phone_number');
$custom_attribute = get_field('custom_attribute');
$attribute_name = get_field('attribute_name');
$attribute_value = get_field('attribute_value');

// Prepare link
$link_url = '#';
$link_target = '';
$phone_number = '';
$phone_number_desktop = '';

if ($phone_number_btn) {
    // Phone number button logic
    if ((isset($_COOKIE['adward_number']) || isset($_GET['ads']))) {
        $phone_number = mobile_number(get_theme_mod('adsense_number'));
        $phone_number_desktop = get_theme_mod('adsense_number');
    } else {
        $phone_number = mobile_number(get_theme_mod('call_tracking_number'));
        $phone_number_desktop = get_theme_mod('call_tracking_number');
    }
    $link_url = 'tel:' . $phone_number;
} elseif ($link) {
    $link_url = $link['url'];
    $link_target = !empty($link['target']) ? $link['target'] : '';
}

// Wrapper alignment class
$wrapper_align = '';
if (!empty($block['align'])) {
    $wrapper_align = ' align-' . $block['align'];
}
?>

<div class="ekwa-button-wrapper<?php echo esc_attr($wrapper_align); ?>" id="<?php echo esc_attr($block_id); ?>-wrapper">
    <a
        id="<?php echo esc_attr($block_id); ?>"
        class="<?php echo esc_attr($class_name); ?>"
        href="<?php echo esc_url($link_url); ?>"
        <?php if ($link_target): ?>
            target="<?php echo esc_attr($link_target); ?>"
            <?php if ($link_target === '_blank'): ?>
                rel="noopener noreferrer"
            <?php endif; ?>
        <?php endif; ?>
        <?php if ($custom_attribute && $attribute_name && $attribute_value): ?>
            <?php echo esc_attr($attribute_name); ?>="<?php echo esc_attr($attribute_value); ?>"
        <?php endif; ?>
    >
        <?php echo esc_html($text); ?>

        <?php if ($phone_number_btn && !is_mobile() && $show_phone_desktop): ?>
            <?php echo esc_html($phone_number_desktop); ?>
        <?php endif; ?>

        <?php if ($icon): ?>
            <i class="<?php echo esc_attr($icon); ?>" aria-hidden="true"></i>
        <?php endif; ?>
    </a>
</div>

<?php
// Output alignment styles only in editor preview
if ($is_preview): ?>
<style>
    /* Editor preview styles */
    #<?php echo esc_attr($block_id); ?>-wrapper {
        padding: 10px 0;
    }

    #<?php echo esc_attr($block_id); ?>-wrapper.align-left {
        text-align: left;
    }

    #<?php echo esc_attr($block_id); ?>-wrapper.align-center {
        text-align: center;
    }

    #<?php echo esc_attr($block_id); ?>-wrapper.align-right {
        text-align: right;
    }
</style>
<?php endif; ?>
