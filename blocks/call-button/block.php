<?php
/**
 * EKWA Call Button Block Template
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

// Create id attribute allowing for custom "anchor" value.
$block_id = 'ekwa-call-button-' . $block['id'];
if (!empty($block['anchor'])) {
    $block_id = $block['anchor'];
}

// Create class attribute allowing for custom "className"
$class_name = 'ekwa-call-button';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}

// Get ACF fields
$text = get_field('text') ?: 'Call Us Today';
$text_color = get_field('text_color') ?: '#000000';
$icon_color = get_field('icon_color') ?: '#000000';
$dropdown_bg = get_field('drop_down_background') ?: '#1e73be';
$dropdown_color = get_field('drop_down_color') ?: '#ffffff';

// Check if using AdSense number
$using_adsense = isset($_COOKIE['adward_number']) || isset($_GET['ads']);

// Get phone numbers
if ($using_adsense) {
    $display_number = get_theme_mod('adsense_number');
    $phone_href = mobile_number($display_number);
} else {
    $display_number = get_theme_mod('call_tracking_number');
    $phone_href = mobile_number($display_number);
}

// Get location data - automatically detect multiple locations
$location_rows = get_theme_mod('location_info', '');
$has_multiple_locations = !empty($location_rows) && count($location_rows) > 1;
$show_dropdown = !$using_adsense;

// Collect custom CSS for consolidated output
if (!is_admin() && !$is_preview) {
    global $ekwa_section_head_styles;

    if (!isset($ekwa_section_head_styles)) {
        $ekwa_section_head_styles = [];
    }

    $button_css = "/* Call Button Styles for #" . $block_id . " */\n";
    $button_css .= "#" . $block_id . " .ekwa-call-button__trigger { color: " . esc_attr($text_color) . "; }\n";
    $button_css .= "#" . $block_id . " .ekwa-call-button__trigger i { color: " . esc_attr($icon_color) . "; }\n";
    $button_css .= "#" . $block_id . " .ekwa-call-button__dropdown { background-color: " . esc_attr($dropdown_bg) . "; }\n";
    $button_css .= "#" . $block_id . " .ekwa-call-button__dropdown a { color: " . esc_attr($dropdown_color) . "; }\n";
    $button_css .= "#" . $block_id . " .ekwa-call-button__dropdown i { color: " . esc_attr($dropdown_color) . "; }\n";

    $ekwa_section_head_styles[$block_id] = $button_css;
}
?>

<div id="<?php echo esc_attr($block_id); ?>" class="<?php echo esc_attr($class_name); ?>">
    <?php if ($show_dropdown): ?>
        <!-- Multi-option button with dropdown -->
        <div class="ekwa-call-button__trigger">
            <i class="fas fa-phone-alt" aria-hidden="true"></i>
            <span><?php echo esc_html($text); ?></span>
        </div>

        <div class="ekwa-call-button__dropdown">
            <?php if ($has_multiple_locations): ?>
                <!-- Multiple Locations - Each with New/Existing Patient Numbers -->
                <?php foreach ($location_rows as $index => $location): ?>
                    <?php
                    $new_patient_phone = !empty($location['phone']) ? $location['phone'] : '';
                    $existing_patient_phone = !empty($location['phone_ex']) ? $location['phone_ex'] : '';
                    $city_name = !empty($location['city']) ? $location['city'] : (!empty($location['location_title']) ? $location['location_title'] : 'Location ' . ($index + 1));

                    if ($new_patient_phone || $existing_patient_phone):
                    ?>
                    <!-- City/Location Header -->
                    <div class="ekwa-call-button__location-group">
                        <div class="ekwa-call-button__location-header">
                            <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                            <span class="ekwa-call-button__city"><?php echo esc_html($city_name); ?></span>
                        </div>

                        <?php if ($new_patient_phone): ?>
                        <!-- New Patients for this location -->
                        <div class="ekwa-call-button__item">
                            <a href="tel:<?php echo esc_attr(mobile_number($new_patient_phone)); ?>" aria-label="Call New Patients - <?php echo esc_attr($city_name); ?>">
                                <i class="fas fa-phone-alt" aria-hidden="true"></i>
                                <div class="ekwa-call-button__details">
                                    <span class="ekwa-call-button__label">New Patients</span>
                                    <span class="ekwa-call-button__number"><?php echo esc_html($new_patient_phone); ?></span>
                                </div>
                            </a>
                        </div>
                        <?php endif; ?>

                        <?php if ($existing_patient_phone): ?>
                        <!-- Existing Patients for this location -->
                        <div class="ekwa-call-button__item">
                            <a href="tel:<?php echo esc_attr(mobile_number($existing_patient_phone)); ?>" aria-label="Call Existing Patients - <?php echo esc_attr($city_name); ?>">
                                <i class="fas fa-user-check" aria-hidden="true"></i>
                                <div class="ekwa-call-button__details">
                                    <span class="ekwa-call-button__label">Existing Patients</span>
                                    <span class="ekwa-call-button__number"><?php echo esc_html($existing_patient_phone); ?></span>
                                </div>
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                <?php endforeach; ?>

            <?php else: ?>
                <!-- Single Location - Show Patient Types from Location Data (No City Name) -->
                <?php
                // Get phone numbers from the single location
                $single_location = !empty($location_rows[0]) ? $location_rows[0] : [];
                $single_new_phone = !empty($single_location['phone']) ? $single_location['phone'] : get_theme_mod('call_tracking_number');
                $single_ex_phone = !empty($single_location['phone_ex']) ? $single_location['phone_ex'] : get_theme_mod('existing_patients_phone');
                ?>

                <?php if ($single_new_phone): ?>
                <div class="ekwa-call-button__item">
                    <a href="tel:<?php echo esc_attr(mobile_number($single_new_phone)); ?>" aria-label="Call New Patients Line">
                        <i class="fas fa-phone-alt" aria-hidden="true"></i>
                        <div class="ekwa-call-button__details">
                            <span class="ekwa-call-button__label">New Patients</span>
                            <span class="ekwa-call-button__number"><?php echo esc_html($single_new_phone); ?></span>
                        </div>
                    </a>
                </div>
                <?php endif; ?>

                <?php if ($single_ex_phone): ?>
                <div class="ekwa-call-button__item">
                    <a href="tel:<?php echo esc_attr(mobile_number($single_ex_phone)); ?>" aria-label="Call Existing Patients Line">
                        <i class="fas fa-user-check" aria-hidden="true"></i>
                        <div class="ekwa-call-button__details">
                            <span class="ekwa-call-button__label">Existing Patients</span>
                            <span class="ekwa-call-button__number"><?php echo esc_html($single_ex_phone); ?></span>
                        </div>
                    </a>
                </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>

    <?php else: ?>
        <!-- Simple direct call link (for AdSense numbers) -->
        <a href="tel:<?php echo esc_attr($phone_href); ?>" class="ekwa-call-button__simple" aria-label="Call <?php echo esc_attr($display_number); ?>">
            <i class="fas fa-phone-alt" aria-hidden="true"></i>
            <span><?php echo esc_html($text); ?> <?php echo esc_html($display_number); ?></span>
        </a>
    <?php endif; ?>
</div>

<?php
// Output styles only in editor preview
if ($is_preview): ?>
<style>
    /* Editor preview styles */
    #<?php echo esc_attr($block_id); ?> {
        padding: 15px;
        border: 1px dashed #e0e0e0;
        max-width: 300px;
    }

    #<?php echo esc_attr($block_id); ?> .ekwa-call-button__trigger {
        color: <?php echo esc_attr($text_color); ?>;
    }

    #<?php echo esc_attr($block_id); ?> .ekwa-call-button__trigger i {
        color: <?php echo esc_attr($icon_color); ?>;
    }

    #<?php echo esc_attr($block_id); ?> .ekwa-call-button__dropdown {
        background-color: <?php echo esc_attr($dropdown_bg); ?>;
        display: block !important; /* Show in preview */
        position: static !important;
        margin-top: 10px;
    }

    #<?php echo esc_attr($block_id); ?> .ekwa-call-button__dropdown a {
        color: <?php echo esc_attr($dropdown_color); ?>;
    }

    #<?php echo esc_attr($block_id); ?> .ekwa-call-button__dropdown i {
        color: <?php echo esc_attr($dropdown_color); ?>;
    }
</style>
<?php endif; ?>
