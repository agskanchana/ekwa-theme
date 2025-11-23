<?php
/**
 * EKWA Working Hours Block Template
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

// Create id attribute allowing for custom "anchor" value.
$block_id = 'ekwa-working-hours-' . $block['id'];
if (!empty($block['anchor'])) {
    $block_id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and alignment
$class_name = 'ekwa-working-hours';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $class_name .= ' align' . $block['align'];
}

// Get ACF fields
$location = get_field('location') ?: 1;
$show_closed = get_field('show_closed') ?: false;
$short_format = get_field('short_format') ?: false;
$group_format = get_field('group_format') ?: 'none';
$text_color = get_field('text_color') ?: '#000000';
$time_color = get_field('time_color') ?: '#666666';

// Get working hours data
$working_hours = array();
if (function_exists('get_location_working_hours')) {
    $working_hours = get_location_working_hours($location);
}

// Helper function to convert day names to short format
if (!function_exists('ekwa_get_short_day')) {
    function ekwa_get_short_day($day) {
        $short_days = array(
            'Monday' => 'Mon',
            'Tuesday' => 'Tue',
            'Wednesday' => 'Wed',
            'Thursday' => 'Thu',
            'Friday' => 'Fri',
            'Saturday' => 'Sat',
            'Sunday' => 'Sun'
        );
        return isset($short_days[$day]) ? $short_days[$day] : $day;
    }
}

// Helper function to format time signature (opening-closing)
if (!function_exists('ekwa_get_time_signature')) {
    function ekwa_get_time_signature($day_data) {
        if (empty($day_data['opening']) || empty($day_data['closing'])) {
            return '';
        }
        return $day_data['opening'] . '|' . $day_data['closing'];
    }
}

// Helper function to check if day is closed
if (!function_exists('ekwa_is_day_closed')) {
    function ekwa_is_day_closed($day_data) {
        return !empty($day_data['closed']) && ($day_data['closed'] === true || $day_data['closed'] === '1' || $day_data['closed'] === 1);
    }
}

// Process hours based on group format
$processed_hours = array();

if ($group_format === 'none') {
    // No grouping - show each day separately
    foreach ($working_hours as $day_data) {
        $is_closed = ekwa_is_day_closed($day_data);
        
        if (!$show_closed && $is_closed) {
            continue;
        }
        
        $day_name = $short_format ? ekwa_get_short_day($day_data['day']) : $day_data['day'];
        $time_display = $is_closed ? 'Closed' : $day_data['opening'] . ' – ' . $day_data['closing'];
        
        $processed_hours[] = array(
            'label' => $day_name,
            'time' => $time_display,
            'is_closed' => $is_closed
        );
    }
} elseif ($group_format === 'consecutive') {
    // Group consecutive days with same hours
    $i = 0;
    while ($i < count($working_hours)) {
        $current = $working_hours[$i];
        $is_closed = ekwa_is_day_closed($current);
        
        if (!$show_closed && $is_closed) {
            $i++;
            continue;
        }
        
        $current_time_sig = ekwa_get_time_signature($current);
        $start_day = $current['day'];
        $end_day = $current['day'];
        
        // Look ahead for consecutive days with same hours
        $j = $i + 1;
        while ($j < count($working_hours)) {
            $next = $working_hours[$j];
            $next_is_closed = ekwa_is_day_closed($next);
            $next_time_sig = ekwa_get_time_signature($next);
            
            // Check if same status (both closed or both open with same times)
            if ($is_closed === $next_is_closed) {
                if ($is_closed || $current_time_sig === $next_time_sig) {
                    $end_day = $next['day'];
                    $j++;
                    continue;
                }
            }
            break;
        }
        
        // Format the label
        if ($start_day === $end_day) {
            $label = $short_format ? ekwa_get_short_day($start_day) : $start_day;
        } else {
            $start_short = $short_format ? ekwa_get_short_day($start_day) : $start_day;
            $end_short = $short_format ? ekwa_get_short_day($end_day) : $end_day;
            $label = $start_short . ' to ' . $end_short;
        }
        
        $time_display = $is_closed ? 'Closed' : $current['opening'] . ' – ' . $current['closing'];
        
        $processed_hours[] = array(
            'label' => $label,
            'time' => $time_display,
            'is_closed' => $is_closed
        );
        
        $i = $j;
    }
} elseif ($group_format === 'all') {
    // Group all days with same hours (even if not consecutive)
    $time_groups = array();
    
    foreach ($working_hours as $day_data) {
        $is_closed = ekwa_is_day_closed($day_data);
        
        if (!$show_closed && $is_closed) {
            continue;
        }
        
        if ($is_closed) {
            $key = 'closed';
        } else {
            $key = ekwa_get_time_signature($day_data);
        }
        
        if (!isset($time_groups[$key])) {
            $time_groups[$key] = array(
                'days' => array(),
                'time' => $is_closed ? 'Closed' : ($day_data['opening'] . ' – ' . $day_data['closing']),
                'is_closed' => $is_closed
            );
        }
        
        $time_groups[$key]['days'][] = $day_data['day'];
    }
    
    // Convert groups to processed format
    foreach ($time_groups as $group) {
        $day_labels = array();
        foreach ($group['days'] as $day) {
            $day_labels[] = $short_format ? ekwa_get_short_day($day) : $day;
        }
        
        $processed_hours[] = array(
            'label' => implode(', ', $day_labels),
            'time' => $group['time'],
            'is_closed' => $group['is_closed']
        );
    }
}

// Collect custom CSS for consolidated output
if (!is_admin() && !$is_preview) {
    global $ekwa_section_head_styles;

    if (!isset($ekwa_section_head_styles)) {
        $ekwa_section_head_styles = [];
    }

    $hours_css = "/* Working Hours Block Styles for #" . $block_id . " */\n";
    $hours_css .= "#" . $block_id . " {\n";
    $hours_css .= "  padding: 20px;\n";
    $hours_css .= "}\n\n";
    $hours_css .= "#" . $block_id . " .ekwa-working-hours__list {\n";
    $hours_css .= "  display: flex;\n";
    $hours_css .= "  flex-direction: column;\n";
    $hours_css .= "  gap: 12px;\n";
    $hours_css .= "}\n\n";
    $hours_css .= "#" . $block_id . " .ekwa-working-hours__row {\n";
    $hours_css .= "  display: flex;\n";
    $hours_css .= "  justify-content: space-between;\n";
    $hours_css .= "  align-items: center;\n";
    $hours_css .= "  padding: 8px 0;\n";
    $hours_css .= "  border-bottom: 1px solid #eee;\n";
    $hours_css .= "}\n\n";
    $hours_css .= "#" . $block_id . " .ekwa-working-hours__row:last-child {\n";
    $hours_css .= "  border-bottom: none;\n";
    $hours_css .= "}\n\n";
    $hours_css .= "#" . $block_id . " .ekwa-working-hours__row--closed {\n";
    $hours_css .= "  opacity: 0.6;\n";
    $hours_css .= "}\n\n";
    $hours_css .= "#" . $block_id . " .ekwa-working-hours__day {\n";
    $hours_css .= "  font-weight: 600;\n";
    $hours_css .= "  color: " . esc_attr($text_color) . ";\n";
    $hours_css .= "}\n\n";
    $hours_css .= "#" . $block_id . " .ekwa-working-hours__time {\n";
    $hours_css .= "  color: " . esc_attr($time_color) . ";\n";
    $hours_css .= "}\n\n";
    $hours_css .= "#" . $block_id . " .ekwa-working-hours__empty {\n";
    $hours_css .= "  color: #999;\n";
    $hours_css .= "  font-style: italic;\n";
    $hours_css .= "  margin: 0;\n";
    $hours_css .= "}\n";

    $ekwa_section_head_styles[$block_id] = $hours_css;
}
?>

<div
    id="<?php echo esc_attr($block_id); ?>"
    class="<?php echo esc_attr($class_name); ?>"
>
    <?php if (!empty($processed_hours)): ?>
        <div class="ekwa-working-hours__list">
            <?php foreach ($processed_hours as $hour_entry): ?>
                <div class="ekwa-working-hours__row<?php echo $hour_entry['is_closed'] ? ' ekwa-working-hours__row--closed' : ''; ?>">
                    <span class="ekwa-working-hours__day"><?php echo esc_html($hour_entry['label']); ?></span>
                    <span class="ekwa-working-hours__time"><?php echo esc_html($hour_entry['time']); ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="ekwa-working-hours__empty">No working hours available for this location.</p>
    <?php endif; ?>
</div>

<?php
// Output styles only in editor preview
if ($is_preview): ?>
<style>
    /* Editor preview styles */
    #<?php echo esc_attr($block_id); ?> {
        padding: 20px;
        border: 1px dashed #e0e0e0;
        background: #fafafa;
    }

    #<?php echo esc_attr($block_id); ?> .ekwa-working-hours__list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    #<?php echo esc_attr($block_id); ?> .ekwa-working-hours__row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px solid #eee;
    }

    #<?php echo esc_attr($block_id); ?> .ekwa-working-hours__row:last-child {
        border-bottom: none;
    }

    #<?php echo esc_attr($block_id); ?> .ekwa-working-hours__row--closed {
        opacity: 0.6;
    }

    #<?php echo esc_attr($block_id); ?> .ekwa-working-hours__day {
        font-weight: 600;
        color: <?php echo esc_attr($text_color); ?>;
    }

    #<?php echo esc_attr($block_id); ?> .ekwa-working-hours__time {
        color: <?php echo esc_attr($time_color); ?>;
    }

    #<?php echo esc_attr($block_id); ?> .ekwa-working-hours__empty {
        color: #999;
        font-style: italic;
        margin: 0;
    }
</style>
<?php endif; ?>
