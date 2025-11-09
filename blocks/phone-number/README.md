# EKWA Phone Number Block

Optimized clickable phone number block with icon, custom text, and ad tracking support.

## Features

### 1. **Phone Type Selection**
- **New Patients** - Primary phone number
- **Existing Patients** - Secondary phone number
- **Ad Tracking Support** - Automatic number swapping for ad campaigns

### 2. **Multi-Location Support**
- **Location ID** - Support for practices with multiple locations
- **Dynamic Number Retrieval** - Uses `get_location()` function
- **Flexible Configuration** - Easy location switching

### 3. **Icon Customization**
- **Show/Hide Icon** - Toggle phone icon display
- **Multiple Icon Styles** - 5 Font Awesome icon options
  - Phone Alt (Default)
  - Phone
  - Mobile
  - Phone Volume
  - Phone Square
- **Custom Icon Color** - Full color control

### 4. **Text Customization**
- **Prefix Text** - Custom text before number (e.g., "Call Us:")
- **Auto Prefix** - Smart defaults based on phone type
- **Text Color** - Customizable text color
- **Flexible Layout** - Aligns left, center, or right

### 5. **Ad Tracking Integration**
- **Cookie Detection** - Checks for `adward_number` cookie
- **URL Parameter** - Responds to `?ads` parameter
- **Number Swapping** - Shows ad tracking number automatically
- **Smart Hiding** - Hides existing patients number during ad campaigns

### 6. **Performance Optimization**
- **Consolidated CSS** - Styles output in `<head>` to prevent CLS
- **BEM Naming** - Clean CSS class structure
- **Proper Escaping** - Security-first approach
- **Semantic HTML** - Accessible markup with ARIA labels

## Usage

### Basic Phone Number
```
Phone Type: New Patients
Location: 1
Prefix Text: (leave empty for auto)
Show Icon: Yes
```

### Custom Styled Number
```
Phone Type: Existing Patients
Prefix Text: "Current Patients:"
Icon Style: Mobile
Icon Color: #1e73be
Text Color: #333333
Align: Center
```

### Ad Tracking Setup
The block automatically detects ad tracking:
- When `$_COOKIE['adward_number']` is set
- When `?ads` parameter is in URL
- Shows ad tracking number (from theme mod)
- Hides prefix text during tracking

## ACF Fields

### Phone Settings (Open by default)
- **Phone Type** (select) - New Patients | Existing Patients
- **Location** (number) - Location ID (default: 1)
- **Prefix Text** (text) - Optional text before number

### Icon Settings
- **Show Icon** (true/false) - Toggle icon display
- **Icon Style** (select) - Choose from 5 icon styles
- **Icon Color** (color_picker) - Icon color

### Text Color
- **Text Color** (color_picker) - Phone number and prefix color

## Required Theme Functions

### `get_location($type, $location_id)`
Retrieves phone number for specific type and location.
```php
// Example
$phone = get_location('phone', 1); // Returns new patient number for location 1
```

### `mobile_number($phone_string)`
Formats phone number for `tel:` links by removing non-numeric characters.
```php
// Example
$tel = mobile_number('(555) 123-4567'); // Returns 5551234567
```

### Ad Tracking Theme Mod
```php
get_theme_mod('adsense_number', ''); // Ad tracking phone number
```

## CSS Classes

### Block Classes
- `.ekwa-phone-number` - Main wrapper
- `.ekwa-phone-number__link` - Clickable phone link
- `.ekwa-phone-number__icon` - Phone icon
- `.ekwa-phone-number__text` - Text wrapper
- `.ekwa-phone-number__prefix` - Prefix text span
- `.ekwa-phone-number__number` - Phone number span

### Alignment
- `.alignleft` - Left aligned
- `.aligncenter` - Center aligned
- `.alignright` - Right aligned

## Ad Tracking Logic

### When Ad Tracking is Active:
**New Patients (`phone`)**:
- Shows ad tracking number
- Hides prefix text
- Maintains clickability

**Existing Patients (`phone_ex`)**:
- Block hidden completely
- Returns early from render
- Shows placeholder in editor only

### When Ad Tracking is Inactive:
- Shows normal phone numbers
- Shows prefix text
- Full functionality

## HTML Output Example

```html
<div id="ekwa-phone-abc123" class="ekwa-phone-number aligncenter">
    <a href="tel:5551234567"
       class="ekwa-phone-number__link"
       aria-label="Call (555) 123-4567">

        <i class="ekwa-phone-number__icon fas fa-phone-alt" aria-hidden="true"></i>

        <span class="ekwa-phone-number__text">
            <span class="ekwa-phone-number__prefix">New Patients: </span>
            <span class="ekwa-phone-number__number">(555) 123-4567</span>
        </span>
    </a>
</div>
```

## Accessibility

- **`aria-label`** on link with full phone number
- **`aria-hidden="true"`** on decorative icon
- **Semantic HTML** with proper link structure
- **Focus States** with hover transitions
- **Screen Reader Friendly** text structure

## Performance

- **CSS Consolidation** - All custom CSS in `<head>`
- **No Inline Styles** - Clean HTML output
- **Efficient Rendering** - Early exit for hidden blocks
- **Minimal DOM** - Simple HTML structure

## Browser Support

- Modern browsers (Chrome, Firefox, Safari, Edge)
- IE 11+ (with polyfills)
- Mobile browsers (iOS Safari, Chrome Android)
- Click-to-call on mobile devices

## Common Use Cases

### Header Phone Number
```
Phone Type: New Patients
Show Icon: Yes
Icon Style: Phone Alt
Align: Right
Text Color: #ffffff (for dark header)
```

### Footer Contact
```
Phone Type: Both (use 2 blocks)
Show Icon: Yes
Prefix Text: Custom per block
Align: Center
```

### Inline in Content
```
Phone Type: New Patients
Show Icon: No
Text Color: Match content
Align: None (inline)
```

## Migration from Old Block

All functionality preserved:
- ✅ Phone type selection
- ✅ Location support
- ✅ Ad tracking
- ✅ Custom text
- ✅ Icon and text colors
- ✅ Alignment options

New features added:
- ✅ Show/hide icon toggle
- ✅ Multiple icon styles
- ✅ Accordion organization
- ✅ Better instructions
- ✅ Consolidated CSS
- ✅ BEM naming
- ✅ Preview placeholders

## Version History

- **1.0.0** - Initial optimized release
  - Accordion field organization
  - Icon style selection
  - Show/hide icon toggle
  - Consolidated CSS output
  - BEM CSS classes
  - Improved accessibility
  - Better error handling
  - Preview placeholders
