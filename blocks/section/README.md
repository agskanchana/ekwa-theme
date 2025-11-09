# EKWA Section Block

Modern ACF-powered section block with background options and InnerBlocks support.

## Features

✅ **InnerBlocks Support** - Nest any blocks inside the section
✅ **Background Options** - Color and image backgrounds
✅ **Lazy Loading** - Optional lazy loading for background images
✅ **Responsive Control** - Desktop-only background option
✅ **Semantic HTML** - Choose between section, aside, main, or article elements
✅ **Custom CSS** - Add custom styles per section
✅ **Full-Width Support** - Automatically spans full viewport width

## File Structure

```
blocks/
└── section/
    ├── block.json      # Block configuration
    └── block.php       # Block template
acf-json/
└── group_ekwa_section_block.json  # ACF field group
```

## Fields

### Background Tab

| Field | Type | Options | Description |
|-------|------|---------|-------------|
| Background Color | Color Picker | - | Background color with opacity support |
| Background Image | Image | - | Upload/select background image |
| Background Size | Select | auto, cover, contain, initial, inherit | How image should be sized |
| Background Attachment | Select | scroll, fixed, local, initial, inherit | Scroll behavior |
| Lazyload | Switch | On/Off | Enable lazy loading (default: Off) |
| Desktop Only | Switch | On/Off | Show background only on 767px+ (default: Off) |

### Other Settings Tab

| Field | Type | Options | Description |
|-------|------|---------|-------------|
| HTML Element | Select | section, aside, main, article | Semantic HTML element (default: section) |
| Custom CSS | Textarea | - | Custom CSS for this section |

## How It Works

### Background Rendering Logic

**Normal Mode (Desktop + Mobile):**
```php
if (!lazyload && !desktop_only) {
    // Apply background inline
}
```

**Lazyload Mode:**
```php
if (lazyload) {
    // Add data-bg attribute
    // lazysizes.js applies background on scroll
}
```

**Desktop Only Mode:**
```css
@media screen and (min-width: 767px) {
    /* Background only loads on desktop */
}
```

**Desktop Only + Lazyload:**
```css
@media screen and (min-width: 767px) {
    .lazyloaded {
        /* Background applied after lazy load on desktop */
    }
}
```

### Full-Width Implementation

The section automatically breaks out of the content container:

```css
.ekwa-body #section-id {
    position: relative;
    width: 100vw;
    left: 50%;
    right: 50%;
    margin-left: -50vw;
    margin-right: -50vw;
}
```

## Usage Examples

### Basic Section with Color

```html
<!-- EKWA Section Block -->
<section id="ekwa-section-123" class="ekwa-section" style="background-color: #f5f5f5;">
    <div class="ekwa-section__inner">
        <!-- Inner blocks here -->
    </div>
</section>
```

### Section with Lazy-Loaded Background

```html
<section id="ekwa-section-123" class="ekwa-section lazyload" data-bg="image.jpg">
    <div class="ekwa-section__inner">
        <!-- Inner blocks here -->
    </div>
</section>
```

### Desktop-Only Background

```html
<section id="ekwa-section-123" class="ekwa-section">
    <div class="ekwa-section__inner">
        <!-- Inner blocks here -->
    </div>
</section>

<style>
@media screen and (min-width: 767px) {
    #ekwa-section-123 {
        background-image: url(image.jpg);
        background-size: cover;
    }
}
</style>
```

## Performance Benefits

1. **Lazy Loading**: Images load only when section is visible
2. **Desktop Only**: Mobile devices don't download large background images
3. **Conditional CSS**: Styles only output when needed
4. **No Wrapper Bloat**: Clean HTML structure

## Browser Support

- ✅ All modern browsers
- ✅ IE11 (with lazysizes.js polyfill)
- ✅ Mobile Safari
- ✅ Chrome, Firefox, Edge

## Dependencies

- **ACF Pro 6.0+**: Required for block registration
- **lazysizes.js**: Required for lazy loading (already included in theme)

## Migration from Old Section Block

The new block maintains backward compatibility. Old sections will continue to work, but new sections get:
- Better performance
- Cleaner code
- More options
- Better editor experience

## Customization

### Add New Field

1. Edit `acf-json/group_ekwa_section_block.json`
2. Add new field object
3. Update `block.php` to use the field

### Modify Styles

Edit the `<style>` section in `block.php`:

```php
<style>
    #<?php echo esc_attr($block_id); ?> {
        /* Your custom styles */
    }
</style>
```

## Troubleshooting

**Block not appearing?**
- Ensure ACF Pro is activated
- Check that `ekwa-blocks.php` is included in `theme-functions.php`

**Lazy loading not working?**
- Verify lazysizes.js is loaded
- Check browser console for errors

**Desktop-only not working?**
- Clear browser cache
- Verify media query: min-width 767px

## Future Enhancements

- [ ] Video background support
- [ ] Parallax scrolling option
- [ ] Gradient background builder
- [ ] Animation on scroll
- [ ] Padding/margin controls
