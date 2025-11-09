# EKWA Direction Button Block

A modern, optimized direction button block that links to Google Maps for location directions.

## Features

- **Three Display Modes:**
  - Icon only (round button)
  - Icon + "Directions" text
  - Icon + Full address

- **Multi-location Support:** Select which location (1, 2, 3, etc.)
- **Customizable Colors:** Text and icon color controls
- **CSS Consolidation:** Moves styles to `<head>` for better performance
- **Accessibility:** Includes ARIA labels
- **Block Editor Support:** Live preview with mode-specific styling

## Usage

1. Add "EKWA Direction Button" block in the WordPress editor
2. Configure in the Settings accordion:
   - **Mode:** Choose how to display (icon/text/address)
   - **Location:** Enter location number (default: 1)
3. If text or address mode, customize colors in the Colors accordion

## Display Modes

### Icon Only (Default)
```
[📍] ← Round button with map marker icon
```

### Icon + Text
```
📍 Directions
```

### Icon + Address
```
📍 123 Main Street
   City, State ZIP
```

## Technical Details

### Files
- `block.json` - Block registration (17 lines)
- `block.php` - Template logic (119 lines)
- ACF field group: `group_620dbd7aa3632.json`
- Base CSS: `critical.css` lines 458-508

### ACF Fields
1. **Settings Accordion** (open by default)
   - Mode (select): icon | text | address
   - Location (number): 1-∞

2. **Colors Accordion** (conditional - only shows for text/address modes)
   - Text Color (color picker): Default #000000
   - Icon Color (color picker): Default #1e73be

### Dependencies
- **Theme Functions:**
  - `get_location('direction', $location)` - Returns Google Maps URL
  - `get_address($location)` - Returns formatted address string
- **Font Awesome:** Uses `fa-map-marker-alt` icon
- **ACF Pro:** Required for block registration

### Block Properties
```json
{
  "name": "acf/ekwa-direction",
  "title": "EKWA Direction Button",
  "icon": "location-alt",
  "category": "ekwa-blocks",
  "supports": {
    "align": ["left", "center", "right"],
    "anchor": true,
    "className": true
  }
}
```

## Optimization Features

1. **Conditional CSS:** Only outputs custom colors for text/address modes (icon mode uses default CSS)
2. **CSS Consolidation:** Moves inline styles to `<head>` via `$ekwa_section_head_styles`
3. **Security:** All outputs escaped with `esc_attr()`, `esc_url()`, `esc_html()`
4. **Performance:** Single database query per block (ACF field caching)
5. **Accessibility:** ARIA labels for screen readers

## CSS Classes

- `.ekwa-direction` - Base class (all modes)
- `.ekwa-direction--icon` - Icon only mode
- `.ekwa-direction--text` - Text mode
- `.ekwa-direction--address` - Address mode

## Example Output

### Icon Mode
```html
<a href="https://maps.google.com/..."
   class="ekwa-direction ekwa-direction--icon"
   target="_blank"
   rel="noopener noreferrer"
   aria-label="Get directions to our location">
    <i class="fas fa-map-marker-alt"></i>
</a>
```

### Text Mode
```html
<a href="https://maps.google.com/..."
   id="block_abc123"
   class="ekwa-direction ekwa-direction--text">
    <i class="fas fa-map-marker-alt"></i>
    <span>Directions</span>
</a>
<!-- CSS in <head> -->
<style>
#block_abc123 { color: #000000; }
#block_abc123 i { color: #1e73be; }
</style>
```

### Address Mode
```html
<a href="https://maps.google.com/..."
   id="block_def456"
   class="ekwa-direction ekwa-direction--address">
    <i class="fas fa-map-marker-alt"></i>
    <span>123 Main Street, City, State 12345</span>
</a>
<!-- CSS in <head> -->
<style>
#block_def456 { color: #000000; }
#block_def456 i { color: #1e73be; }
</style>
```

## Migration from Old Block

If migrating from the old `direction-btn` block:

1. Old block used nested `color` group field → New uses direct `text_color` and `icon_color` fields
2. Old block always used inline styles → New uses CSS consolidation for better performance
3. Old location: `template-parts/default-blocks/direction-btn/` → New: `blocks/direction/`
4. Old block name: `acf/direction-btn` → New: `acf/ekwa-direction`

ACF will automatically migrate the field data when you sync the field group.

## Browser Support

- Modern browsers (Chrome, Firefox, Safari, Edge)
- IE11+ (with Font Awesome polyfill)

## Version History

- **1.0.0** - Initial optimized version (March 2024)
  - Modern block.json structure
  - CSS consolidation
  - Accordion field layout
  - Improved security and accessibility
