<?php
/**
 * EKWA Address Dropdown Block Template
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

// Create id attribute allowing for custom "anchor" value.
$block_id = 'ekwa-address-dropdown-' . $block['id'];
if (!empty($block['anchor'])) {
    $block_id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and alignment
$class_name = 'ekwa-address-dropdown';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $class_name .= ' align' . $block['align'];
}

// Get ACF fields
$trigger_bg_color = get_field('trigger_bg_color') ?: '#1e73be';
$trigger_text_color = get_field('trigger_text_color') ?: '#ffffff';
$dropdown_bg_color = get_field('dropdown_bg_color') ?: '#ffffff';
$dropdown_text_color = get_field('dropdown_text_color') ?: '#000000';
$dropdown_link_color = get_field('dropdown_link_color') ?: '#1e73be';

// Get all locations from Kirki
$location_rows = get_theme_mod('location_info', []);

// Collect custom CSS for consolidated output
if (!is_admin() && !$is_preview) {
    global $ekwa_section_head_styles;

    if (!isset($ekwa_section_head_styles)) {
        $ekwa_section_head_styles = [];
    }

    $dropdown_css = "/* Address Dropdown Styles for #" . $block_id . " */\n";
    $dropdown_css .= "#" . $block_id . " .ekwa-address-dropdown__trigger { background-color: " . esc_attr($trigger_bg_color) . "; color: " . esc_attr($trigger_text_color) . "; }\n";
    $dropdown_css .= "#" . $block_id . " .ekwa-address-dropdown__dropdown { background-color: " . esc_attr($dropdown_bg_color) . "; color: " . esc_attr($dropdown_text_color) . "; }\n";
    $dropdown_css .= "#" . $block_id . " .ekwa-address-dropdown__link { color: " . esc_attr($dropdown_link_color) . "; }\n";
    $dropdown_css .= "#" . $block_id . " .ekwa-address-dropdown__link:hover { color: " . esc_attr($trigger_bg_color) . "; }\n";

    $ekwa_section_head_styles[$block_id] = $dropdown_css;
}
?>

<div id="<?php echo esc_attr($block_id); ?>" class="<?php echo esc_attr($class_name); ?>">
    <div class="ekwa-address-dropdown__trigger">
        <svg class="ekwa-address-dropdown__icon" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path d="M12 2C8.13 2 5 5.13 5 9C5 14.25 12 22 12 22C12 22 19 14.25 19 9C19 5.13 15.87 2 12 2ZM12 11.5C10.62 11.5 9.5 10.38 9.5 9C9.5 7.62 10.62 6.5 12 6.5C13.38 6.5 14.5 7.62 14.5 9C14.5 10.38 13.38 11.5 12 11.5Z" fill="currentColor"/>
        </svg>
        <span>Directions</span>
    </div>

    <?php if (!empty($location_rows) && is_array($location_rows)): ?>
    <div class="ekwa-address-dropdown__dropdown">
        <?php foreach ($location_rows as $index => $location):
            $location_number = $index + 1;
            $city = isset($location['city']) ? $location['city'] : '';

            // Get direction URL
            $direction_url = '';
            if (function_exists('get_location')) {
                $direction_url = get_location('direction', $location_number);
            }

            // Get full address
            $address_text = '';
            if (function_exists('get_address')) {
                $address_text = get_address($location_number);
            }

            if ($city && $direction_url && $address_text):
        ?>
        <div class="ekwa-address-dropdown__location">
            <div class="ekwa-address-dropdown__city">
                <svg class="ekwa-address-dropdown__city-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M12 2C8.13 2 5 5.13 5 9C5 14.25 12 22 12 22C12 22 19 14.25 19 9C19 5.13 15.87 2 12 2ZM12 11.5C10.62 11.5 9.5 10.38 9.5 9C9.5 7.62 10.62 6.5 12 6.5C13.38 6.5 14.5 7.62 14.5 9C14.5 10.38 13.38 11.5 12 11.5Z" fill="currentColor"/>
                </svg>
                <span><?php echo esc_html($city); ?></span>
            </div>
            <a href="<?php echo esc_url($direction_url); ?>"
               class="ekwa-address-dropdown__link"
               target="_blank"
               rel="noopener noreferrer"
               aria-label="Get directions to <?php echo esc_attr($city); ?>">
                <?php echo wp_kses_post($address_text); ?>
            </a>
        </div>
        <?php
            endif;
        endforeach; ?>
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
        display: inline-block;
        max-width: 400px;
    }

    #<?php echo esc_attr($block_id); ?> .ekwa-address-dropdown__trigger {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 12px 20px;
        background-color: <?php echo esc_attr($trigger_bg_color); ?>;
        color: <?php echo esc_attr($trigger_text_color); ?>;
        border-radius: 5px;
        cursor: pointer;
        transition: opacity 0.3s ease;
        font-weight: 500;
    }

    #<?php echo esc_attr($block_id); ?> .ekwa-address-dropdown__trigger:hover {
        opacity: 0.9;
    }

    #<?php echo esc_attr($block_id); ?> .ekwa-address-dropdown__icon {
        flex-shrink: 0;
    }

    #<?php echo esc_attr($block_id); ?> .ekwa-address-dropdown__dropdown {
        position: absolute;
        top: 100%;
        left: 0;
        min-width: 320px;
        width: max-content;
        max-width: 500px;
        margin-top: 8px;
        padding: 1.5rem;
        background-color: <?php echo esc_attr($dropdown_bg_color); ?>;
        color: <?php echo esc_attr($dropdown_text_color); ?>;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        display: block;
        z-index: 100;
    }

    #<?php echo esc_attr($block_id); ?> .ekwa-address-dropdown__location {
        margin-bottom: 1.5rem;
    }

    #<?php echo esc_attr($block_id); ?> .ekwa-address-dropdown__location:last-child {
        margin-bottom: 0;
    }

    #<?php echo esc_attr($block_id); ?> .ekwa-address-dropdown__city {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 0.5rem;
        font-weight: 700;
        font-size: 0.95em;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    #<?php echo esc_attr($block_id); ?> .ekwa-address-dropdown__city-icon {
        flex-shrink: 0;
    }

    #<?php echo esc_attr($block_id); ?> .ekwa-address-dropdown__link {
        display: block;
        padding-left: 22px;
        color: <?php echo esc_attr($dropdown_link_color); ?>;
        text-decoration: none;
        transition: color 0.2s ease;
        line-height: 1.5;
    }

    #<?php echo esc_attr($block_id); ?> .ekwa-address-dropdown__link:hover {
        color: <?php echo esc_attr($trigger_bg_color); ?>;
        text-decoration: underline;
    }
</style>
<?php endif; ?>
