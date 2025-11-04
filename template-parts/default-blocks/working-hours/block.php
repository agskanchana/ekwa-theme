<?php
$align = $block['align'];
$block_id = $block['id'];
if( !empty($block['anchor']) ) {
   $block_id = $block['anchor'];
}
$className = 'working-hrs';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
$color = '#000';
if(get_field('color')){
    $color = get_field('color');
}

// Get which location to display (default to location 1)
$which_location = get_field('location_number') ? get_field('location_number') : 1;

// Get display format (default to 'normal')
// Options: 'normal', 'group_consecutive', 'group_all'
$display_format = get_field('display_format') ? get_field('display_format') : 'normal';

// Get working hours from the location repeater
$working_hrs = get_location_working_hours($which_location);

/**
 * Group working hours based on display format
 */
if (!function_exists('group_working_hours')) {
    function group_working_hours($hours, $format) {
        if (empty($hours)) return array();

        if ($format === 'normal') {
            // Return as-is for normal display
            return $hours;
        }

        $grouped = array();
        $i = 0;
        $count = count($hours);

        if ($format === 'group_consecutive') {
            // Group only consecutive days with same hours
            while ($i < $count) {
                $current = $hours[$i];
                $days = array($current['day']);
                $j = $i + 1;

                // Check consecutive days
                while ($j < $count) {
                    $next = $hours[$j];

                    // Check if same hours (both closed or both have same opening/closing)
                    $same_hours = false;
                    if (!empty($current['closed']) && !empty($next['closed'])) {
                        $same_hours = true; // Both closed
                    } elseif (empty($current['closed']) && empty($next['closed']) &&
                              $current['opening'] === $next['opening'] &&
                              $current['closing'] === $next['closing']) {
                        $same_hours = true; // Same opening/closing times
                    }

                    if ($same_hours) {
                        $days[] = $next['day'];
                        $j++;
                    } else {
                        break; // Not consecutive anymore
                    }
                }

                $grouped[] = array(
                    'days' => $days,
                    'closed' => $current['closed'],
                    'opening' => $current['opening'],
                    'closing' => $current['closing'],
                    'extra_text' => $current['extra_text']
                );

                $i = $j;
            }

        } elseif ($format === 'group_all') {
            // Group all days with same hours regardless of position
            $time_groups = array();

            foreach ($hours as $hour) {
                // Create a key based on the hours
                if (!empty($hour['closed'])) {
                    $key = 'closed';
                } else {
                    $key = $hour['opening'] . '|' . $hour['closing'] . '|' . $hour['extra_text'];
                }

                if (!isset($time_groups[$key])) {
                    $time_groups[$key] = array(
                        'days' => array(),
                        'closed' => $hour['closed'],
                        'opening' => $hour['opening'],
                        'closing' => $hour['closing'],
                        'extra_text' => $hour['extra_text']
                    );
                }

                $time_groups[$key]['days'][] = $hour['day'];
            }

            $grouped = array_values($time_groups);
        }

        return $grouped;
    }
}

$grouped_hours = group_working_hours($working_hrs, $display_format);

?>
<div id="<?php echo $block_id;?>" class="<?php echo $className." "; if($align){echo $align;}?>">
<?php if($grouped_hours && !empty($grouped_hours)): ?>
    <div class="workin-hr-block">
        <?php if($display_format === 'normal'): ?>
            <?php // Normal display - show each day separately ?>
            <?php foreach( $grouped_hours as $working_hr ) : ?>
                <div class="working-hrs-raw">
                    <div class="day"><?php echo esc_html($working_hr['day']);?>: </div>
                    <div class="time">
                        <?php if(!empty($working_hr['closed']) && ($working_hr['closed'] == '1' || $working_hr['closed'] === true)): ?>
                            Closed
                        <?php else: ?>
                            <?php
                            // Display opening time
                            if(!empty($working_hr['opening'])) {
                                echo esc_html($working_hr['opening']);
                            }

                            // Display closing time if it exists
                            if(!empty($working_hr['closing'])) {
                                echo ' - ' . esc_html($working_hr['closing']);
                            }

                            // Display extra text if it exists
                            if(!empty($working_hr['extra_text'])) {
                                echo ' <span class="extra-text">(' . esc_html($working_hr['extra_text']) . ')</span>';
                            }
                            ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <?php // Grouped display - show day ranges ?>
            <?php foreach( $grouped_hours as $group ) : ?>
                <div class="working-hrs-raw">
                    <div class="day">
                        <?php
                        // Format day range
                        if (count($group['days']) === 1) {
                            echo esc_html($group['days'][0]);
                        } elseif (count($group['days']) === 2) {
                            echo esc_html($group['days'][0]) . ', ' . esc_html($group['days'][1]);
                        } else {
                            // Check if it's a consecutive range for group_consecutive
                            if ($display_format === 'group_consecutive') {
                                echo esc_html($group['days'][0]) . ' - ' . esc_html(end($group['days']));
                            } else {
                                // For group_all, list all days with commas
                                echo esc_html(implode(', ', $group['days']));
                            }
                        }
                        ?>:
                    </div>
                    <div class="time">
                        <?php if(!empty($group['closed']) && ($group['closed'] == '1' || $group['closed'] === true)): ?>
                            Closed
                        <?php else: ?>
                            <?php
                            // Display opening time
                            if(!empty($group['opening'])) {
                                echo esc_html($group['opening']);
                            }

                            // Display closing time if it exists
                            if(!empty($group['closing'])) {
                                echo ' - ' . esc_html($group['closing']);
                            }

                            // Display extra text if it exists
                            if(!empty($group['extra_text'])) {
                                echo ' <span class="extra-text">(' . esc_html($group['extra_text']) . ')</span>';
                            }
                            ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
<?php else: ?>
    <div class="workin-hr-block">
        <p>No working hours available for this location.</p>
    </div>
<?php endif;?>
</div>
<style>
    #<?php echo $block_id;?>.left .working-hrs-raw{
        justify-content: flex-start;
    }
    #<?php echo $block_id;?>.right .working-hrs-raw{
        justify-content: flex-end;
    }
    #<?php echo $block_id;?>.center .working-hrs-raw{
        justify-content: center;
    }
    .working-hrs-raw{
        display: flex;
        flex-wrap: wrap;
        margin-bottom: 10px;
    }
    .working-hrs-raw .day{
        margin-right: 20px;
        font-weight: 600;
    }
    #<?php echo $block_id;?>{
        color: <?php echo $color;?>;
    }
</style>
