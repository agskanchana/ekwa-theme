# EKWA Button Block

A modern, customizable button block for the EKWA WordPress theme with icon support and phone number integration.

## Features

✅ **Modern Block Structure** - Uses block.json for proper WordPress block registration
✅ **Icon Support** - Add FontAwesome icons to buttons
✅ **Phone Integration** - Automatically use tracking phone numbers
✅ **Alignment Options** - Left, center, right, wide, full
✅ **Custom Attributes** - Add custom HTML attributes
✅ **Performance Optimized** - Base CSS in critical.css, cached by browser
✅ **Accessibility** - Proper ARIA labels, rel attributes for external links
✅ **Clean HTML** - Semantic, escaped output

## Block Settings

### Basic Settings
- **Text** - Button label text
- **Link** - URL for the button (supports internal/external links)
- **Icon** - FontAwesome class (e.g., `fas fa-arrow-right`)

### Phone Number Settings
- **Phone Number** - Toggle to use tracking phone number instead of link
- **Show Phone Number in Desktop** - Display the phone number text on desktop

### Advanced Settings
- **Custom Attribute** - Add custom HTML attributes
  - **Attribute Name** - Custom attribute name
  - **Attribute Value** - Custom attribute value

## Usage

### Basic Button
```
1. Add "EKWA Button" block
2. Set Text: "Get Started"
3. Set Link: /contact-us/
4. Done!
```

### Button with Icon
```
1. Add button
2. Set Text: "Learn More"
3. Set Icon: "fas fa-arrow-right"
```

### Phone Button
```
1. Add button
2. Set Text: "Call Us"
3. Enable "Phone Number"
4. Enable "Show Phone Number in Desktop"
```

### Custom Tracking Attribute
```
1. Add button
2. Enable "Custom attribute"
3. Attribute Name: "data-track"
4. Attribute Value: "cta-hero"
```

## Phone Number Logic

The button automatically switches between:
- **AdSense Number** - When user has `adward_number` cookie or `?ads` parameter
- **Call Tracking Number** - Default tracking number from Customizer

This is configured in: `Customizer → Contact Information`

## Alignment

Supports all WordPress alignments:
- **Left** - Button aligned left
- **Center** - Button centered
- **Right** - Button aligned right
- **Wide** - Button container goes wide
- **Full** - Button container goes full width

## CSS Structure

### Base Styles (critical.css)
```css
.ekwa-button-wrapper { /* Container */ }
.ekwa-button { /* Button itself */ }
.ekwa-button i { /* Icon spacing */ }
```

### Alignment Classes
```css
.ekwa-button-wrapper.align-left
.ekwa-button-wrapper.align-center
.ekwa-button-wrapper.align-right
```

## File Structure
```
blocks/button/
├── block.json          - Block configuration
├── block.php           - Block template
└── README.md           - This file
```

## ACF Fields
Located in: `acf-json/group_624317d319508.json`

## Customization

### Styling
Base button styles come from `critical.css`:
```css
.btn { /* Your existing button styles */ }
.ekwa-button { /* New block-specific styles */ }
```

### Adding New Fields
1. Edit `acf-json/group_624317d319508.json`
2. Add field definition
3. Update `block.php` to use the new field
4. Resync ACF fields in WordPress admin

## Performance

✅ **Base CSS cached** - Loads once, applies to all buttons
✅ **No inline styles** - Clean HTML output
✅ **Minimal JavaScript** - No JS needed for basic buttons
✅ **Lazy loading friendly** - Works with lazy load scripts

## Accessibility

- ✅ `rel="noopener noreferrer"` for external links
- ✅ `aria-hidden="true"` on decorative icons
- ✅ Proper link text for screen readers
- ✅ Keyboard navigable

## Migration from Old Button Block

Old block: `acf/btn`
New block: `acf/ekwa-button`

The ACF field group has been updated to use the new block name. Existing buttons will continue to work with the old template until you update them.

## Examples

### CTA Button with Arrow
```
Text: "Schedule Appointment"
Link: /appointment/
Icon: fas fa-calendar-check
Align: center
```

### Phone Button with Number Display
```
Text: "Call Now: "
Phone Number: Enabled
Show Phone Number in Desktop: Enabled
Icon: fas fa-phone
Align: center
```

### External Link with Tracking
```
Text: "View on Google Maps"
Link: https://maps.google.com/...
Custom Attribute: data-track="footer-map"
Icon: fas fa-external-link-alt
Target: _blank (opens in new tab)
```

## Support

For issues or questions:
- Check ACF field group is active
- Verify block is registered in `ekwa-blocks.php`
- Check browser console for JavaScript errors
- Clear WordPress cache and browser cache
