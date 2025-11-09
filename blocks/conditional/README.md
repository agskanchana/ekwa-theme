# EKWA Conditional Block

A powerful WordPress block that allows you to show or hide content based on multiple conditions.

## Features

### 1. **Page Visibility Control**
- **Show Everywhere** - Default behavior, content visible on all pages
- **Show Only on Selected Pages** - Whitelist specific pages
- **Hide on Selected Pages** - Blacklist specific pages

### 2. **Content Type Control**
- **Show on Posts & Pages** - Default, visible everywhere
- **Show Only on Posts** - Blog posts only
- **Show Only on Pages** - Static pages only
- **Hide on Posts** - Hide content on blog posts
- **Hide on Pages** - Hide content on static pages

### 3. **Device Type Control**
- **All Devices** - Default, visible on all devices
- **Mobile Only** - Only visible on mobile devices
- **Desktop Only** - Only visible on desktop/tablet devices

### 4. **SEO Integration**
- **Yoast Cornerstone Content** - Show only on pages/posts marked as cornerstone content in Yoast SEO plugin
- Automatically detects if Yoast SEO is installed
- Won't hide content if Yoast is not active

## Usage

### Basic Example
```
1. Add "EKWA Conditional Block" to your page
2. Add any content inside it (text, images, other blocks)
3. Configure visibility conditions in the block settings
4. Content will show/hide based on your conditions
```

### Use Cases

#### Example 1: Show Banner Only on Homepage
```
Display Mode: Show Only on Selected Pages
Select Pages: [Home]
Content Type: Show on Posts & Pages
Device: All Devices
```

#### Example 2: Mobile-Only Call Button
```
Display Mode: Show Everywhere
Content Type: Show on Posts & Pages
Device: Mobile Only
```

#### Example 3: Desktop Sidebar Widget
```
Display Mode: Show Everywhere
Content Type: Pages Only
Device: Desktop Only
```

#### Example 4: Cornerstone Content CTA
```
Display Mode: Show Everywhere
Content Type: Show Only on Posts
Device: All Devices
Yoast Cornerstone: Yes
```

#### Example 5: Hide Promo on Specific Pages
```
Display Mode: Hide on Selected Pages
Select Pages: [Thank You, Contact]
Content Type: Show on Posts & Pages
Device: All Devices
```

## Condition Logic

All conditions work with **AND** logic:
- Page condition AND Content Type AND Device Type AND Yoast setting
- All conditions must be true for content to display

## Editor Preview

In the WordPress editor, the block displays with a blue border showing:
- Current active conditions
- Content preview (always visible in editor)

## Technical Details

### Files
- `block.json` - Block configuration
- `block.php` - Template with conditional logic
- `README.md` - This documentation

### Functions
- `ekwa_check_conditional_display()` - Main condition checking function
- Uses WordPress conditional tags: `is_page()`, `is_single()`, `is_singular()`
- Uses `wp_is_mobile()` for device detection
- Integrates with Yoast SEO meta fields

### Device Detection
- Uses WordPress native `wp_is_mobile()` function
- Mobile: Phones and small tablets
- Desktop: Tablets (landscape) and computers

### Yoast Integration
- Checks for `WPSEO_Meta` class to detect Yoast SEO
- Reads `_yoast_wpseo_is_cornerstone` post meta
- Gracefully handles when Yoast is not installed

## Performance

- **Zero overhead** when conditions don't match - block doesn't render
- No JavaScript required - pure PHP server-side rendering
- No additional database queries (uses existing WordPress functions)
- CSS only loads in block editor preview

## Browser Support

Works in all modern browsers:
- Chrome, Firefox, Safari, Edge
- Mobile browsers: iOS Safari, Chrome Mobile

## Future Enhancements

Potential features for future versions:
- Date range conditions
- User role conditions
- Category/tag conditions
- URL parameter conditions
- Custom post type support

## Changelog

### Version 1.0.0
- Initial release
- Page show/hide conditions
- Content type filtering (posts/pages)
- Device type detection
- Yoast cornerstone integration
