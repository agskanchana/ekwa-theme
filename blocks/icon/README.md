# EKWA Icon Block

A modern, flexible icon block that supports both Font Awesome and custom SVG icons with optional linking capabilities.

## Features

- **Dual Icon Sources:**
  - Font Awesome classes (fa-solid, fa-brands, etc.)
  - Custom SVG code (paste from any SVG library)

- **Flexible Linking:**
  - No link (static icon)
  - Custom URL with target options
  - Phone number (calls tracking number)

- **Full Customization:**
  - Icon size (16-200px)
  - Icon color picker
  - Alignment support (left, center, right)

- **Performance Optimized:**
  - CSS consolidation (moves to `<head>`)
  - Hover effects
  - Clean semantic HTML

## Usage

### Basic Setup
1. Add "EKWA Icon Block" in the WordPress editor
2. Choose icon source (Font Awesome or SVG)
3. Configure size and color
4. Optionally add a link

### Icon Type Examples

#### Font Awesome
```
Icon Source: Font Awesome
FA Class: fa-solid fa-star
         fa-brands fa-facebook
         fa-regular fa-heart
```

#### Custom SVG
```
Icon Source: Custom SVG
SVG Code: Paste SVG from:
  - FontAwesome.com (download SVG)
  - Heroicons.com
  - Bootstrap Icons
  - Material Icons
  - Any SVG library
```

### Link Type Examples

#### No Link
```
Link Type: No Link
Result: Static icon (no interaction)
```

#### Custom Link
```
Link Type: Custom Link
URL: https://example.com
Target: _blank
Title: Visit our website
```

#### Phone Number
```
Link Type: Phone Number
Result: Links to call tracking number from theme settings
Format: tel:+1234567890
```

## ACF Field Structure

### 1. Icon Type Accordion (open by default)
- **Icon Source** (button_group): Font Awesome | Custom SVG
- **Font Awesome Class** (text): Shows when FA selected
  - Example: `fa-solid fa-star`
- **SVG Code** (textarea): Shows when SVG selected
  - Paste complete SVG markup

### 2. Icon Style Accordion
- **Icon Size** (number): 16-200px (default: 48)
- **Icon Color** (color picker): Default #1e73be

### 3. Link Settings Accordion
- **Link Type** (button_group): No Link | Custom Link | Phone Number
- **Custom Link** (link field): Shows when Custom Link selected
  - URL, title, target options

## How to Get SVG Icons

### Method 1: Font Awesome
1. Go to [FontAwesome.com](https://fontawesome.com)
2. Search for an icon
3. Click "Download" → "SVG"
4. Open the SVG file and copy the code
5. Paste into "SVG Code" field

### Method 2: Heroicons
1. Go to [Heroicons.com](https://heroicons.com)
2. Click on any icon
3. Copy the SVG code
4. Paste into "SVG Code" field

### Method 3: Other Libraries
- [Bootstrap Icons](https://icons.getbootstrap.com)
- [Material Icons](https://fonts.google.com/icons)
- [Feather Icons](https://feathericons.com)
- [Ionicons](https://ionic.io/ionicons)

## Technical Details

### Files
- `block.json` - Block registration (17 lines)
- `block.php` - Template logic (183 lines)
- ACF field group: `group_ekwa_icon_block.json`
- Base CSS: `critical.css` lines 603-641

### Block Properties
```json
{
  "name": "acf/ekwa-icon",
  "title": "EKWA Icon Block",
  "icon": "star-filled",
  "category": "ekwa-blocks",
  "supports": {
    "align": ["left", "center", "right"],
    "anchor": true,
    "className": true
  }
}
```

### CSS Classes
- `.ekwa-icon` - Base wrapper (div or a tag)
- `.ekwa-icon i` - Font Awesome icon
- `.ekwa-icon__svg` - SVG wrapper
- `.ekwa-icon.alignleft` - Left aligned
- `.ekwa-icon.aligncenter` - Center aligned
- `.ekwa-icon.alignright` - Right aligned

## Example Output

### Font Awesome Icon (No Link)
```html
<div id="ekwa-icon-abc123" class="ekwa-icon aligncenter">
    <i class="fa-solid fa-star" aria-hidden="true"></i>
</div>

<style>
#ekwa-icon-abc123 i {
    font-size: 48px;
    color: #1e73be;
}
</style>
```

### SVG Icon with Link
```html
<a id="ekwa-icon-def456"
   class="ekwa-icon"
   href="https://example.com"
   target="_blank"
   rel="noopener noreferrer"
   aria-label="Visit our website">
    <div class="ekwa-icon__svg" aria-hidden="true">
        <svg width="24" height="24" viewBox="0 0 24 24">
            <path d="M12 2L2 7l10 5 10-5-10-5z"/>
        </svg>
    </div>
</a>

<style>
#ekwa-icon-def456 .ekwa-icon__svg {
    width: 64px;
    height: 64px;
}
#ekwa-icon-def456 .ekwa-icon__svg svg {
    fill: #ff6600;
}
</style>
```

### Phone Number Link
```html
<a id="ekwa-icon-ghi789"
   class="ekwa-icon"
   href="tel:+1234567890"
   aria-label="Call us at +1234567890">
    <i class="fa-solid fa-phone" aria-hidden="true"></i>
</a>
```

## CSS Consolidation

Custom colors are automatically moved to `<head>` for better performance:

```html
<!-- EKWA Section Styles (Consolidated) -->
<style id='ekwa-sections-custom'>
/* Icon Block Styles for #ekwa-icon-abc123 */
#ekwa-icon-abc123 i { font-size: 48px; color: #1e73be; }

/* Icon Block Styles for #ekwa-icon-def456 */
#ekwa-icon-def456 .ekwa-icon__svg { width: 64px; height: 64px; }
#ekwa-icon-def456 .ekwa-icon__svg svg { fill: #ff6600; }
</style>
```

## Advantages Over Old Block

| Feature | Old (fa-icon) | New (ekwa-icon) |
|---------|---------------|-----------------|
| Icon Source | Font Awesome only | FA + Custom SVG |
| SVG Support | ❌ No | ✅ Yes |
| Icon Size Control | ❌ No | ✅ Yes (slider) |
| Color Control | ❌ No | ✅ Yes (picker) |
| Link Options | Link or Phone | None/Link/Phone |
| CSS Location | Inline only | Consolidated in `<head>` |
| Accordion UI | ❌ No | ✅ Yes |
| Security | Basic | Enhanced (escaping) |
| Accessibility | Basic | ARIA labels |
| Editor Preview | Basic | Styled preview |

## Migration from Old Block

The old `acf/fa-icon` block is still functional. To migrate:

1. **Keep existing blocks working** - Old block continues to function
2. **Use new block for new content** - Better features and performance
3. **Optional migration** - Edit old blocks and recreate with new block

### Field Mapping
- Old: `fa_class` → New: `fa_class` (same field name)
- Old: `link` → New: Set `link_type` to "Custom Link" + `custom_link`
- Old: `phone_number` (true/false) → New: Set `link_type` to "Phone Number"

## Browser Support

- Modern browsers (Chrome, Firefox, Safari, Edge)
- IE11+ (Font Awesome icons only)
- SVG support in all modern browsers

## Performance

- ✅ CSS consolidation reduces render blocking
- ✅ Inline SVG (no external file requests)
- ✅ Font Awesome icons loaded globally (if theme uses FA)
- ✅ Hover effects use CSS transitions (GPU accelerated)

## Accessibility

- ✅ ARIA labels on links
- ✅ `aria-hidden="true"` on decorative icons
- ✅ Proper semantic HTML (a vs div)
- ✅ Color contrast considerations
- ✅ Keyboard navigation support

## Version History

- **1.0.0** - Initial release (November 2025)
  - Font Awesome class support
  - Custom SVG code support
  - Size and color controls
  - Three link types (none, custom, phone)
  - CSS consolidation
  - Accordion field layout
  - Enhanced security and accessibility
