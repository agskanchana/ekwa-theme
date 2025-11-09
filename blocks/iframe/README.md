# EKWA Iframe Block

Enhanced iframe embed block for WordPress Gutenberg with responsive sizing, lazy loading, and accessibility features.

## Features

### 1. **Flexible Sizing Options**
- **Responsive width** (100% - default)
- **Custom width** with specific values (px, %, rem, etc.)
- **Aspect ratio** based height (16:9, 4:3, 1:1, custom)
- **Custom height** with specific values

### 2. **Performance Optimization**
- **Lazy loading** - iframe loads only when visible
- **Loading placeholders** - spinner, text, or none
- **LazySizes integration** - uses existing theme lazy loading library
- **Consolidated CSS** - styles output in head to prevent CLS

### 3. **Accessibility**
- **Custom title attribute** - descriptive text for screen readers
- **ARIA labels** - proper semantic markup
- **Keyboard navigation** - full keyboard support
- **No-referrer policy** - privacy protection

### 4. **Customization**
- **Border control** - show/hide iframe border
- **Fullscreen support** - allow/disallow fullscreen mode
- **Alignment options** - normal, wide, full width
- **Custom CSS classes** - additional styling hooks
- **Custom anchor ID** - deep linking support

## Usage

### Basic Map Embed
```
Iframe Source: https://www.google.com/maps/embed?...
Title: Office location map
Aspect Ratio: 16:9
```

### Video Embed
```
Iframe Source: https://www.youtube.com/embed/VIDEO_ID
Title: Product demonstration video
Aspect Ratio: 16:9
Allow Fullscreen: Yes
```

### Form Embed
```
Iframe Source: https://forms.example.com/contact
Title: Contact form
Height Type: Custom
Custom Height: 600px
```

## ACF Fields

### Required Fields
- **Iframe Source** (text) - The URL of the content to embed

### Optional Fields
- **Iframe Title** (text) - Descriptive title for accessibility
- **Width Type** (select) - responsive | custom
- **Custom Width** (text) - e.g., 800px, 80%, 50rem
- **Height Type** (select) - aspect_ratio | custom
- **Aspect Ratio** (select) - 16:9 | 4:3 | 1:1 | custom
- **Custom Height** (text) - e.g., 450px, 30vh
- **Lazy Load** (true/false) - Enable lazy loading
- **Border** (true/false) - Show iframe border
- **Allow Fullscreen** (true/false) - Enable fullscreen mode
- **Loading Placeholder** (select) - default | spinner | text | none

## Common Use Cases

### Google Maps
```
Source: https://www.google.com/maps/embed?pb=...
Aspect Ratio: 16:9 or 4:3
Lazy Load: Yes
```

### YouTube/Vimeo Videos
```
Source: https://www.youtube.com/embed/VIDEO_ID
Aspect Ratio: 16:9
Allow Fullscreen: Yes
```

### Forms (Google Forms, Typeform, etc.)
```
Source: Form embed URL
Height: Custom (adjust as needed)
Border: No
```

### Calendar Embeds
```
Source: Calendar embed URL
Aspect Ratio: 4:3 or custom height
```

## CSS Classes

### Block Classes
- `.ekwa-iframe-wrapper` - Main wrapper
- `.ekwa-iframe-container` - Aspect ratio container (when using aspect ratio)
- `.alignwide` - Wide alignment
- `.alignfull` - Full width alignment

### Loading States
- `.ekwa-iframe-loading` - Loading placeholder
- `.ekwa-iframe-spinner` - Spinner animation
- `.lazyload` - Before iframe loads
- `.lazyloaded` - After iframe loads

## Performance Tips

1. **Always use lazy loading** for iframes below the fold
2. **Choose aspect ratio** over fixed height for responsive designs
3. **Use loading placeholders** to indicate content is loading
4. **Minimize number of iframes** on a single page

## Accessibility Tips

1. **Always provide a descriptive title** for screen readers
2. **Use meaningful anchor IDs** for deep linking
3. **Test keyboard navigation** to ensure all controls work
4. **Consider providing text alternatives** for critical content

## Browser Support

- Modern browsers (Chrome, Firefox, Safari, Edge)
- IE 11+ (with polyfills)
- Mobile browsers (iOS Safari, Chrome Android)

## Version History

- **1.0.0** - Initial release with enhanced features
  - Aspect ratio support
  - Lazy loading
  - Loading placeholders
  - Accessibility improvements
  - Performance optimizations
