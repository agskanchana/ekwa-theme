<?php
/**
 * EKWA Phone Number Block Template
 *
 * Displays a clickable phone number with icon and customizable text.
 * Supports multiple locations, ad tracking, and responsive design.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

// Create id attribute allowing for custom "anchor" value
$block_id = 'ekwa-phone-' . $block['id'];
if (!empty($block['anchor'])) {
    $block_id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and alignment
$class_name = 'ekwa-phone-number';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $class_name .= ' align' . $block['align'];
}

// Get ACF fields with proper defaults
$phone_type = get_field('type') ?: 'phone';
$prefix_text = get_field('text') ?: '';
$text_color = get_field('text_color') ?: '#000000';
$icon_color = get_field('icon_color') ?: '#000000';
$location = get_field('location') ?: 1;
$show_icon = get_field('show_icon') !== false; // Default true
$icon_style = get_field('icon_style') ?: 'fas fa-phone-alt';

/**
 * Phone Number Logic with Ad Tracking
 * Handles different phone types and ad tracking numbers
 */
$phone_number = '';
$mobile_number = '';
$should_display = true;

// Check for ad tracking cookie or parameter
$is_ad_tracking = (isset($_COOKIE['adward_number']) || isset($_GET['ads']));

// Get phone number based on type and tracking
if ($is_ad_tracking && $phone_type === 'phone') {
    // Use ad tracking number for new patients
    $phone_number = get_theme_mod('adsense_number', '');
    if (function_exists('mobile_number')) {
        $mobile_number = mobile_number($phone_number);
    } else {
        $mobile_number = preg_replace('/[^0-9]/', '', $phone_number);
    }
    $prefix_text = ''; // Remove prefix for ad tracking

} elseif ($is_ad_tracking && $phone_type === 'phone_ex') {
    // Hide existing patients number during ad tracking
    $should_display = false;

} else {
    // Normal phone number retrieval
    if (function_exists('get_location')) {
        $phone_number = get_location($phone_type, $location);
    }

    if (function_exists('mobile_number')) {
        $mobile_number = mobile_number($phone_number);
    } else {
        $mobile_number = preg_replace('/[^0-9]/', '', $phone_number);
    }
}

// Set default prefix text based on phone type if not custom
if (empty($prefix_text) && !$is_ad_tracking) {
    $prefix_text = ($phone_type === 'phone') ? 'New Patients:' : 'Existing Patients:';
}

// Exit early if block shouldn't display
if (!$should_display || empty($phone_number)) {
    if ($is_preview) {
        echo '<div class="ekwa-phone-number ekwa-phone-number--placeholder" style="padding: 20px; background: #f5f5f5; border: 2px dashed #ccc; text-align: center;">';
        echo '<p style="margin: 0; color: #666;"><i class="fas fa-phone-alt"></i> Phone Number Block</p>';
        if (!$should_display) {
            echo '<small style="color: #999;">Hidden during ad tracking</small>';
        } elseif (empty($phone_number)) {
            echo '<small style="color: #999;">No phone number configured for this location</small>';
        }
        echo '</div>';
    }
    return;
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

    $phone_css = "/* Phone Number Block Styles for #" . $block_id . " */\n";

    // Base styles
    $phone_css .= "#" . $block_id . " {\n";
    $phone_css .= "  display: inline-block;\n";
    $phone_css .= "}\n\n";

    // Link styles
    $phone_css .= "#" . $block_id . " .ekwa-phone-number__link {\n";
    $phone_css .= "  display: inline-flex;\n";
    $phone_css .= "  align-items: center;\n";
    $phone_css .= "  gap: 8px;\n";
    $phone_css .= "  text-decoration: none;\n";
    $phone_css .= "  transition: opacity 0.3s ease;\n";
    $phone_css .= "}\n\n";

    $phone_css .= "#" . $block_id . " .ekwa-phone-number__link:hover {\n";
    $phone_css .= "  opacity: 0.8;\n";
    $phone_css .= "}\n\n";

    // Icon styles
    $phone_css .= "#" . $block_id . " .ekwa-phone-number__icon {\n";
    $phone_css .= "  color: " . esc_attr($icon_color) . ";\n";
    $phone_css .= "  font-size: 1em;\n";
    $phone_css .= "}\n\n";

    // Text styles
    $phone_css .= "#" . $block_id . " .ekwa-phone-number__text {\n";
    $phone_css .= "  color: " . esc_attr($text_color) . ";\n";
    $phone_css .= "  line-height: 1.4;\n";
    $phone_css .= "}\n\n";

    // Alignment styles
    $phone_css .= "#" . $block_id . ".alignleft {\n";
    $phone_css .= "  text-align: left;\n";
    $phone_css .= "}\n\n";

    $phone_css .= "#" . $block_id . ".aligncenter {\n";
    $phone_css .= "  text-align: center;\n";
    $phone_css .= "  display: block;\n";
    $phone_css .= "}\n\n";

    $phone_css .= "#" . $block_id . ".alignright {\n";
    $phone_css .= "  text-align: right;\n";
    $phone_css .= "  display: block;\n";
    $phone_css .= "}\n\n";

    // Store for <head> output
    if (!empty($phone_css)) {
        $ekwa_section_head_styles[$block_id] = $phone_css;
    }
}
?>

<div id="<?php echo esc_attr($block_id); ?>" class="<?php echo esc_attr($class_name); ?>">
    <a href="tel:<?php echo esc_attr($mobile_number); ?>"
       class="ekwa-phone-number__link"
       aria-label="Call <?php echo esc_attr($phone_number); ?>">

        <?php if ($show_icon): ?>
            <i class="ekwa-phone-number__icon <?php echo esc_attr($icon_style); ?>" aria-hidden="true"></i>
        <?php endif; ?>

        <span class="ekwa-phone-number__text">
            <?php if (!empty($prefix_text)): ?>
                <span class="ekwa-phone-number__prefix"><?php echo esc_html($prefix_text); ?> </span>
            <?php endif; ?>
            <span class="ekwa-phone-number__number"><?php echo esc_html($phone_number); ?></span>
        </span>
    </a>
</div>

<?php
// Output styles only in editor preview
if ($is_preview): ?>
<style>
    /* Editor preview styles */
    #<?php echo esc_attr($block_id); ?> {
        display: inline-block;
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

    #<?php echo esc_attr($block_id); ?> .ekwa-phone-number__link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        transition: opacity 0.3s ease;
    }

    #<?php echo esc_attr($block_id); ?> .ekwa-phone-number__link:hover {
        opacity: 0.8;
    }

    #<?php echo esc_attr($block_id); ?> .ekwa-phone-number__icon {
        color: <?php echo esc_attr($icon_color); ?>;
        font-size: 1em;
    }

    #<?php echo esc_attr($block_id); ?> .ekwa-phone-number__text {
        color: <?php echo esc_attr($text_color); ?>;
        line-height: 1.4;
    }
</style>
<?php endif; ?>
