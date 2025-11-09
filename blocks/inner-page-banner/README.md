# EKWA Inner Page Banner Block

Optimized page header block for WordPress Gutenberg with title, breadcrumbs, and responsive banner images.

## Features

### 1. **Flexible Content Display**
- **Automatic Page Title** - Uses page title by default
- **Custom Heading** - Override with custom text
- **Breadcrumbs** - Yoast SEO breadcrumbs integration
- **Toggle Breadcrumbs** - Show/hide breadcrumbs option

### 2. **Smart Image Handling**
- **Priority System** - Featured Image > Custom Banner > Text-Only
- **Responsive Images** - Mobile-optimized images on small screens
- **Custom Banner Upload** - Override featured image with custom banner
- **Text-Only Mode** - Automatic fallback when no image exists

### 3. **Background Customization**
- **Overlay Color** - Customizable overlay background color
- **Opacity Control** - 1-9 scale for overlay darkness
- **Text-Only Padding** - Adjustable padding when no image (100-300px)
- **Custom CSS** - Add custom styles per banner

### 4. **Text Color Controls**
- **Heading Color** - Independent heading color control
- **Breadcrumb Color** - Separate breadcrumb color setting
- **Contrast Optimization** - Ensure readability over images

### 5. **Performance Optimization**
- **Consolidated CSS** - Styles output in `<head>` to prevent CLS
- **Responsive Images** - Automatic mobile image selection
- **Clean HTML** - Semantic markup with proper BEM classes
- **No Inline Styles** - CSS moved to head for better caching

## Usage

### Basic Setup
1. Add the block to a page
2. Set heading and breadcrumb colors
3. Upload banner image or use featured image
4. Adjust overlay opacity for readability

### With Featured Image
```
Featured Image: Set on the page
Overlay Color: #000000
Overlay Opacity: 5
Heading Color: #ffffff
```

### With Custom Banner
```
Banner Image: Upload custom image
Overlay Color: #1a1a1a
Overlay Opacity: 6
Show Breadcrumbs: Yes
```

### Text-Only Banner
```
No Featured Image or Banner: Auto text-only mode
Padding: 180px
Background Color: #000000 (shown via overlay)
Heading Color: #ffffff
```

## ACF Fields

### Content Settings (Open by default)
- **Custom Heading** (text) - Override page title
- **Show Breadcrumbs** (true/false) - Toggle breadcrumb display

### Background Settings
- **Banner Image** (image) - Custom banner (overrides featured image)
- **Overlay Background Color** (color_picker) - Overlay color
- **Overlay Opacity** (range 1-9) - Darkness of overlay
- **Padding** (range 100-300) - Padding for text-only banners

### Text Colors
- **Heading Color** (color_picker) - Page title color
- **Breadcrumb Color** (color_picker) - Breadcrumb text color

### Advanced
- **Custom CSS** (codemirror) - Additional custom styles with syntax highlighting

## Image Priority Logic

1. **Check Featured Image** → Use if exists (responsive selection)
2. **Check Custom Banner** → Use if featured image doesn't exist
3. **No Image** → Display text-only banner with padding

## Responsive Behavior

### Desktop (>767px)
- Full-size featured image or custom banner
- Centered text overlay
- Absolute positioning for content

### Mobile (<767px)
- Uses `featured_mobile` image size if available
- Maintains overlay and text positioning
- Optimized image dimensions for faster loading

## CSS Classes

### Main Classes
- `.ekwa-inner-page-banner` - Main wrapper
- `.ekwa-banner--has-image` - When image exists
- `.ekwa-banner--text-only` - When no image
- `.ekwa-banner__container` - Content container
- `.ekwa-banner__title` - Heading element
- `.ekwa-banner__breadcrumbs` - Breadcrumb wrapper
- `.ekwa-banner__image` - Banner image element

### Layout Modifiers
- `.alignwide` - Wide alignment
- `.alignfull` - Full width alignment

## Integration with Theme Functions

### Required Functions
- `inner_page_heading($post_id)` - Generates heading HTML
- `yoast_breadcrumb()` - Outputs breadcrumbs (Yoast SEO)
- `is_mobile()` - Detects mobile devices (optional)
- `is_tab()` - Detects tablets (optional)

### Recommended Image Sizes
```php
add_image_size('featured_mobile', 768, 400, true);
```

## Accessibility

- **Semantic HTML** - Proper `<section>` wrapper
- **Alt Text** - Automatic alt text from image or page title
- **Breadcrumb Schema** - Yoast SEO breadcrumb markup
- **Proper Heading Hierarchy** - Uses `<h1>` for page title

## Performance Tips

1. **Use Featured Images** - Better integrated with WordPress media
2. **Optimize Images** - Compress before upload (WebP recommended)
3. **Set Overlay Properly** - Ensure text readability without excessive darkness
4. **Minimal Custom CSS** - Use built-in options when possible

## Common Use Cases

### Homepage Banner
```
Align: Full Width
Banner Image: Hero image
Overlay: 40% opacity
Heading: Custom "Welcome"
Breadcrumbs: Hidden
```

### Service Page Header
```
Featured Image: Service-specific image
Overlay Color: Brand color
Overlay Opacity: 5-6
Breadcrumbs: Visible
```

### Text-Only Landing Page
```
No Image: Text-only mode activates
Padding: 200px
Background: Dark overlay color
Heading: Bold white text
```

## Browser Support

- Modern browsers (Chrome, Firefox, Safari, Edge)
- IE 11+ (with graceful degradation)
- Mobile browsers (iOS Safari, Chrome Android)

## Version History

- **1.0.0** - Initial optimized release
  - Consolidated CSS output
  - Responsive image handling
  - Organized accordion fields
  - Performance optimizations
  - Clean BEM naming convention
