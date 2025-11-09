# EKWA Address Dropdown Block

A modern dropdown block that displays all practice locations with direction links.

## Features

- **Auto-populated Locations:** Automatically pulls all locations from Kirki theme settings
- **Hover Dropdown:** Shows locations on hover with smooth transition
- **City Headers:** Each location displays city name with icon
- **Direction Links:** Full address for each location links to Google Maps
- **Customizable Colors:** Control trigger button and dropdown colors
- **CSS Consolidation:** Moves styles to `<head>` for better performance
- **Accessibility:** Includes ARIA labels and semantic HTML

## Usage

1. Add "EKWA Address Dropdown" block in the WordPress editor
2. Configure colors in the accordions:
   - **Trigger Button:** Background and text colors
   - **Dropdown:** Background, text, and link colors
3. Block automatically displays all locations from your theme settings

## Display Format

```
┌─────────────────┐
│ 📍 Directions   │ ← Trigger (hover to show)
└─────────────────┘
     │
     ▼ (on hover)
┌────────────────────────────┐
│ 📍 CITY NAME 1             │
│   123 Main St, City, 12345 │ ← Link to directions
│                            │
│ 📍 CITY NAME 2             │
│   456 Oak Ave, Town, 67890 │ ← Link to directions
└────────────────────────────┘
```

## Technical Details

### Files
- `block.json` - Block registration (17 lines)
- `block.php` - Template logic (177 lines)
- ACF field group: `group_ekwa_address_dropdown.json`
- Base CSS: `critical.css` lines 517-598

### ACF Fields
1. **Trigger Button Accordion**
   - Background Color (color picker): Default #1e73be
   - Text Color (color picker): Default #ffffff

2. **Dropdown Accordion**
   - Background Color (color picker): Default #ffffff
   - Text Color (color picker): Default #000000
   - Link Color (color picker): Default #1e73be

### Dependencies
- **Theme Functions:**
  - `get_location('direction', $location_number)` - Returns Google Maps URL
  - `get_address($location_number)` - Returns formatted address string
- **Kirki Theme Mod:** `location_info` - Array of all locations
- **ACF Pro:** Required for block registration

### Block Properties
```json
{
  "name": "acf/ekwa-address-dropdown",
  "title": "EKWA Address Dropdown Block",
  "icon": "location-alt",
  "category": "ekwa-blocks",
  "supports": {
    "align": ["left", "center", "right"],
    "anchor": true,
    "className": true
  }
}
```

## CSS Classes

- `.ekwa-address-dropdown` - Base wrapper
- `.ekwa-address-dropdown__trigger` - Button that shows on hover
- `.ekwa-address-dropdown__icon` - SVG icon in trigger
- `.ekwa-address-dropdown__dropdown` - Dropdown container
- `.ekwa-address-dropdown__location` - Individual location wrapper
- `.ekwa-address-dropdown__city` - City name header
- `.ekwa-address-dropdown__city-icon` - Icon next to city name
- `.ekwa-address-dropdown__link` - Address link

## Example Output

### HTML Structure
```html
<div id="ekwa-address-dropdown-abc123" class="ekwa-address-dropdown">
    <div class="ekwa-address-dropdown__trigger">
        <svg class="ekwa-address-dropdown__icon">...</svg>
        <span>Directions</span>
    </div>

    <div class="ekwa-address-dropdown__dropdown">
        <!-- Location 1 -->
        <div class="ekwa-address-dropdown__location">
            <div class="ekwa-address-dropdown__city">
                <svg class="ekwa-address-dropdown__city-icon">...</svg>
                <span>New York</span>
            </div>
            <a href="https://maps.google.com/..."
               class="ekwa-address-dropdown__link">
                123 Main Street, New York, NY 10001
            </a>
        </div>

        <!-- Location 2 -->
        <div class="ekwa-address-dropdown__location">
            <div class="ekwa-address-dropdown__city">
                <svg class="ekwa-address-dropdown__city-icon">...</svg>
                <span>Los Angeles</span>
            </div>
            <a href="https://maps.google.com/..."
               class="ekwa-address-dropdown__link">
                456 Oak Avenue, Los Angeles, CA 90001
            </a>
        </div>
    </div>
</div>
```

### CSS Consolidation
```html
<!-- In <head> -->
<style id="ekwa-sections-custom">
#ekwa-address-dropdown-abc123 .ekwa-address-dropdown__trigger {
    background-color: #1e73be;
    color: #ffffff;
}
#ekwa-address-dropdown-abc123 .ekwa-address-dropdown__dropdown {
    background-color: #ffffff;
    color: #000000;
}
#ekwa-address-dropdown-abc123 .ekwa-address-dropdown__link {
    color: #1e73be;
}
</style>
```

## Behavior

- **Desktop:** Dropdown shows on hover
- **Mobile:** Dropdown shows on tap (sticky hover)
- **Keyboard:** Tab to trigger, Enter to activate
- **Screen Readers:** Proper ARIA labels for accessibility

## Optimization Features

1. **No JavaScript Required:** Pure CSS hover interaction
2. **CSS Consolidation:** Custom colors moved to `<head>`
3. **SVG Icons:** Lightweight, scalable map markers
4. **Auto-population:** No manual location entry needed
5. **Performance:** Single loop through locations
6. **Security:** All outputs properly escaped

## Browser Support

- Modern browsers (Chrome, Firefox, Safari, Edge)
- IE11+ (with minor style degradation)
- Mobile browsers (iOS Safari, Chrome Mobile)

## Version History

- **1.0.0** - Initial release (November 2025)
  - Auto-populated locations from Kirki
  - Hover dropdown with all locations
  - City headers with icons
  - Direction links for each location
  - Customizable colors via accordion fields
  - CSS consolidation for performance
