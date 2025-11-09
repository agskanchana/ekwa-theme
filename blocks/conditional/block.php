<?php
/**
 * EKWA Conditional Block Template
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

/**
 * Check if content should be displayed based on conditions
 */
if (!function_exists('ekwa_check_conditional_display')) {
    function ekwa_check_conditional_display($display_mode, $selected_pages, $content_type, $device_type, $yoast_cornerstone) {
        global $post;

        // 1. Check Page Show/Hide conditions
        if ($display_mode === 'show_on_pages') {
            if (!is_page($selected_pages)) {
                return false;
            }
        } elseif ($display_mode === 'hide_on_pages') {
            if (is_page($selected_pages)) {
                return false;
            }
        }

        // 2. Check Content Type conditions
        if ($content_type === 'posts_only') {
            if (!is_single() || !is_singular('post')) {
                return false;
            }
        } elseif ($content_type === 'pages_only') {
            if (!is_page()) {
                return false;
            }
        } elseif ($content_type === 'hide_on_posts') {
            if (is_single() && is_singular('post')) {
                return false;
            }
        } elseif ($content_type === 'hide_on_pages') {
            if (is_page()) {
                return false;
            }
        }

        // 3. Check Device Type
        if ($device_type !== 'all') {
            $is_mobile = wp_is_mobile();

            if ($device_type === 'mobile_only' && !$is_mobile) {
                return false;
            } elseif ($device_type === 'desktop_only' && $is_mobile) {
                return false;
            }
        }

        // 4. Check Yoast Cornerstone Content and Posts
        if ($yoast_cornerstone && $post) {
            $should_show = false;

            // Always show on blog posts
            if (is_single() && is_singular('post')) {
                $should_show = true;
            }

            // For pages, check if cornerstone (only if Yoast is active)
            if (is_page() && class_exists('WPSEO_Meta')) {
                $is_cornerstone = get_post_meta($post->ID, '_yoast_wpseo_is_cornerstone', true);
                if ($is_cornerstone === '1') {
                    $should_show = true;
                }
            }

            // If neither post nor cornerstone page, hide it
            if (!$should_show) {
                return false;
            }
        }        // All conditions passed
        return true;
    }
}

// Create id attribute allowing for custom "anchor" value.
$block_id = 'ekwa-conditional-' . $block['id'];
if (!empty($block['anchor'])) {
    $block_id = $block['anchor'];
}

// Create class attribute allowing for custom "className"
$class_name = 'ekwa-conditional';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}

// Get ACF fields
$display_mode = get_field('display_mode') ?: 'show_everywhere';
$selected_pages = get_field('selected_pages') ?: [];
$content_type = get_field('content_type') ?: 'all';
$device_type = get_field('device_type') ?: 'all';
$yoast_cornerstone = get_field('yoast_cornerstone_only') ?: false;

// In admin/preview, always show the block
if (is_admin() || $is_preview) {
    ?>
    <div id="<?php echo esc_attr($block_id); ?>" class="<?php echo esc_attr($class_name); ?> ekwa-conditional--preview">
        <div class="ekwa-conditional__admin-notice">
            <strong>🔍 Conditional Block</strong> -
            <?php
            // Show current conditions
            $conditions = [];
            if ($display_mode === 'show_on_pages') {
                $conditions[] = 'Show on ' . count($selected_pages) . ' selected pages';
            } elseif ($display_mode === 'hide_on_pages') {
                $conditions[] = 'Hide on ' . count($selected_pages) . ' selected pages';
            }

            if ($content_type === 'posts_only') {
                $conditions[] = 'Posts only';
            } elseif ($content_type === 'pages_only') {
                $conditions[] = 'Pages only';
            } elseif ($content_type === 'hide_on_posts') {
                $conditions[] = 'Hidden on posts';
            } elseif ($content_type === 'hide_on_pages') {
                $conditions[] = 'Hidden on pages';
            }

            if ($device_type === 'mobile_only') {
                $conditions[] = 'Mobile only';
            } elseif ($device_type === 'desktop_only') {
                $conditions[] = 'Desktop only';
            }

            if ($yoast_cornerstone) {
                $conditions[] = 'Yoast cornerstone and posts only';
            }

            echo !empty($conditions) ? implode(' | ', $conditions) : 'Show everywhere';
            ?>
        </div>
        <InnerBlocks />
    </div>
    <style>
        .ekwa-conditional--preview {
            border: 2px dashed #0073aa;
            padding: 20px;
            margin: 10px 0;
            position: relative;
        }
        .ekwa-conditional__admin-notice {
            background: #0073aa;
            color: white;
            padding: 8px 12px;
            margin: -20px -20px 15px -20px;
            font-size: 13px;
            border-radius: 2px 2px 0 0;
        }
    </style>
    <?php
    return;
}

// Check all conditions on frontend
$should_display = ekwa_check_conditional_display(
    $display_mode,
    $selected_pages,
    $content_type,
    $device_type,
    $yoast_cornerstone
);

// Only render if conditions are met
if ($should_display) {
    ?>
    <div id="<?php echo esc_attr($block_id); ?>" class="<?php echo esc_attr($class_name); ?>">
        <InnerBlocks />
    </div>
    <?php
}
