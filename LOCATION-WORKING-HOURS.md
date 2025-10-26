# Location Working Hours - Usage Guide

## Overview
Each location in the Kirki repeater now supports nested working hours without using ACF or separate repeaters. Working hours are stored as JSON data within each location.

## How to Use in Customizer

1. Go to **Appearance → Customize → Site Settings → Location**
2. Add or edit a location
3. Scroll down to **Working Hours (JSON)** field
4. Click the **📅 Edit Working Hours** button
5. A modal will open with all 7 days of the week
6. For each day:
   - Check **Closed** if the location is closed that day
   - Or enter **Opening** and **Closing** times (e.g., "09:00 AM", "05:00 PM")
   - Add **Extra** text if needed (e.g., "By appointment only")
7. Click **Save Working Hours**
8. The button will show how many days are configured

## How to Display Working Hours in Your Theme

### Method 1: Get Raw Data (Array)
```php
<?php
// Get working hours for location 1
$hours = get_location_working_hours(1);

// Loop through each day
foreach ($hours as $day_data) {
    echo $day_data['day'] . ': ';

    if ($day_data['closed']) {
        echo 'Closed';
    } else {
        echo $day_data['opening'] . ' - ' . $day_data['closing'];
        if (!empty($day_data['extra_text'])) {
            echo ' (' . $day_data['extra_text'] . ')';
        }
    }
    echo '<br>';
}
?>
```

### Method 2: Display as List (Automatic)
```php
<?php
// Display as unordered list
display_location_working_hours(1, 'list');
?>
```

Output:
```html
<ul class="working-hours-list">
    <li class="day-monday"><strong>Monday:</strong> 09:00 AM - 05:00 PM</li>
    <li class="day-tuesday"><strong>Tuesday:</strong> 09:00 AM - 05:00 PM</li>
    <li class="day-wednesday"><strong>Wednesday:</strong> Closed</li>
    ...
</ul>
```

### Method 3: Display as Table
```php
<?php
// Display as table
display_location_working_hours(1, 'table');
?>
```

Output:
```html
<table class="working-hours-table">
    <tr>
        <td class="day-name"><strong>Monday</strong></td>
        <td class="hours">09:00 AM - 05:00 PM</td>
    </tr>
    ...
</table>
```

### Method 4: Get Schema.org Format
```php
<?php
// Get hours in Schema.org format for structured data
$schema_hours = display_location_working_hours(1, 'schema');

// Returns array like: ['Monday 09:00 AM-05:00 PM', 'Tuesday 09:00 AM-05:00 PM', ...]
?>
```

## Available Helper Functions

### `get_location_working_hours($which_location)`
Returns array of working hours data for specified location.

**Parameters:**
- `$which_location` (int) - Location index (1-based). Default: 1

**Returns:** Array of working hours with structure:
```php
[
    [
        'day' => 'Monday',
        'closed' => false,
        'opening' => '09:00 AM',
        'closing' => '05:00 PM',
        'extra_text' => 'By appointment'
    ],
    ...
]
```

### `display_location_working_hours($which_location, $format)`
Displays working hours in various formats.

**Parameters:**
- `$which_location` (int) - Location index (1-based). Default: 1
- `$format` (string) - Display format: 'list', 'table', or 'schema'. Default: 'list'

## Example: Display All Locations with Hours

```php
<?php
$locations = get_theme_mod('location_info', []);

foreach ($locations as $index => $location) {
    $location_number = $index + 1;
    ?>
    <div class="location-block">
        <h3><?php echo esc_html($location['city']); ?> Location</h3>

        <div class="location-address">
            <?php echo get_address($location_number); ?>
        </div>

        <div class="location-phone">
            <a href="tel:<?php echo mobile_number($location['phone']); ?>">
                <?php echo esc_html($location['phone']); ?>
            </a>
        </div>

        <div class="location-hours">
            <h4>Hours of Operation</h4>
            <?php display_location_working_hours($location_number, 'list'); ?>
        </div>
    </div>
    <?php
}
?>
```

## Data Structure

Working hours are stored as JSON in the `working_hours_data` field of each location:

```json
[
    {
        "day": "Monday",
        "closed": false,
        "opening": "09:00 AM",
        "closing": "05:00 PM",
        "extra_text": ""
    },
    {
        "day": "Tuesday",
        "closed": false,
        "opening": "09:00 AM",
        "closing": "05:00 PM",
        "extra_text": ""
    },
    {
        "day": "Wednesday",
        "closed": true,
        "opening": "",
        "closing": "",
        "extra_text": ""
    }
]
```

## Styling

Add custom CSS to style the working hours display:

```css
.working-hours-list {
    list-style: none;
    padding: 0;
}

.working-hours-list li {
    padding: 8px 0;
    border-bottom: 1px solid #eee;
}

.working-hours-list li strong {
    display: inline-block;
    min-width: 120px;
}

.working-hours-table {
    width: 100%;
    border-collapse: collapse;
}

.working-hours-table td {
    padding: 10px;
    border-bottom: 1px solid #eee;
}

.working-hours-table .day-name {
    font-weight: bold;
    width: 120px;
}

.extra-text {
    color: #666;
    font-size: 0.9em;
}
```

## Notes

- Working hours are stored as JSON within each location
- No database migrations needed
- Works with existing Kirki repeater
- Modal editor makes it easy to manage hours
- All 7 days of the week are always available
- Supports "Closed" status for any day
- Supports extra text for special notes
