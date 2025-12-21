# EKWA WebP Image Block

A modern, performance-optimized image block that displays WebP images with automatic fallback to traditional image formats. Uses lazysizes library for intelligent lazy loading.

## Features

- **WebP Format Support**: Uses modern WebP format for optimal file size and quality
- **Automatic Fallback**: Provides fallback image for browsers that don't support WebP
- **Intelligent Lazy Loading**: Uses lazysizes library for high-performance, SEO-friendly lazy loading
- **LQIP Blur-Up Effect**: Optional Low Quality Image Placeholder with smooth blur-up transition
- **Responsive**: Fully responsive with object-fit control
- **Optional Link**: Can wrap image in a link (internal or external)
- **Custom Dimensions**: Override image dimensions
- **Multiple Alignments**: Supports left, center, right, wide, and full alignments
- **SEO Optimized**: lazysizes doesn't hide images from search engines
- **Performance Focused**: CSS consolidated in head to prevent CLS, automatic viewport detection

## ACF Fields Required

Create an ACF field group with the following fields:

### 1. Fallback Image (Required)
- **Field Name**: `fallback_image`
- **Field Type**: Image
- **Return Format**: Array
- **Preview Size**: Medium
- **Instructions**: Select the standard format image (JPG/PNG) - used as fallback

### 2. WebP Image (Optional)
- **Field Name**: `webp_image`
- **Field Type**: Image
- **Return Format**: Array
- **MIME Types**: webp only
- **Instructions**: Upload the WebP version of the image for better performance

### 3. Link (Optional)
- **Field Name**: `link`
- **Field Type**: Link
- **Instructions**: Optional link to wrap the image

### 4. Use LQIP (Optional)
- **Field Name**: `use_lqip`
- **Field Type**: True/False
- **Default**: Off (false)
- **Instructions**: Enable blur-up effect with low quality placeholder

### 5. LQIP Image (Conditional)
- **Field Name**: `lqip_image`
- **Field Type**: Image
- **Return Format**: Array
- **Conditional Logic**: Show only if `use_lqip` is true
- **Instructions**: Upload a low quality, small file size version of the image

### 6. Lazy Load (Optional)
- **Field Name**: `lazy_load`
- **Field Type**: True/False
- **Default**: On (true)
- **Instructions**: Enable lazy loading with lazysizes for better performance

### 7. Image Fit (Optional)
- **Field Name**: `image_fit`
- **Field Type**: Select
- **Choices**:
  - cover: Cover entire area (default)
  - contain: Fit within area
  - fill: Stretch to fill
  - none: Original size
- **Default**: cover

### 8. Custom Width (Optional)
- **Field Name**: `custom_width`
- **Field Type**: Text
- **Instructions**: Custom width (e.g., 500px, 50%, auto)

### 9. Custom Height (Optional)
- **Field Name**: `custom_height`
- **Field Type**: Text
- **Instructions**: Custom height (e.g., 300px, 50vh, auto)

## Usage

1. Add the "EKWA WebP Image" block to your content
2. Select a fallback image (required)
3. Optionally add WebP URL for better performance
4. Enable LQIP for blur-up effect (optional but recommended)
5. Upload a low quality placeholder if using LQIP
6. Configure display options (lazy load, image fit, dimensions)
7. Optionally add a link
8. Choose alignment from block toolbar

## Lazy Loading with lazysizes

This block uses the lazysizes library which provides:

- **Automatic Detection**: Detects visibility changes automatically
- **SEO Friendly**: Images are not hidden from search engines
- **High Performance**: Efficient, jank-free loading at 60fps
- **Smart Preloading**: Loads near-viewport images while browser is idle
- **No Configuration**: Works automatically with class-based markup
lazysizes library for intelligent lazy loading
- `lazyload` class triggers automatic loading
- `blur-up` class adds smooth transition effect for LQIP
- CSS consolidated in head to prevent Cumulative Layout Shift (CLS)
- Proper semantic markup with alt text
- External links automatically get rel="noopener noreferrer"
- lazysizes adds `lazyloading` class during load and `lazyloaded` when complete

## Performance Benefits

- **WebP Format**: 25-35% smaller file sizes compared to JPEG/PNG
- **Lazy Loading**: Images load only when needed, saves bandwidth
- **LQIP**: Instant visual feedback with minimal data transfer
- **Smart Preloading**: lazysizes preloads near-viewport images during idle time
- **Object-fit**: Prevents layout shifts during image load
- **Consolidated CSS**: Reduces render-blocking resources
- **SEO Friendly**: Search engines can discover all images

## Dependencies

**Required**: lazysizes library must be loaded on the page. The EKWA theme includes lazysizes at:
- `js/lazysizes.js` (minified version)
- Already enqueued in theme functions

lazysizes is loaded with `async` attribute and self-initializes automatically.
The Low Quality Image Placeholder technique:

1. Upload a tiny, compressed version of your image (< 5KB recommended)
2. Enable "Use LQIP" option
3. Select the low quality image
4. The block will:
   - Show the blurred low quality image immediately
   - Load the high quality image in background
   - Smoothly transition from blurred to sharp when loaded

Benefits:
- Instant visual feedback (no blank space)
- Perceived performance improvement
- Smooth, professional loading experience
- Minimal initial page weight

## Block Alignment

- **Left**: Image aligned to the left
- **Center**: Image centered
- **Right**: Image aligned to the right
- **Wide**: 1200px max-width, centered
- **Full**: Full width of container

## Technical Details

- Uses HTML5 `<picture>` element for optimal browser support
- Implements native lazy loading attribute
- CSS consolidated in head to prevent Cumulative Layout Shift (CLS)
- Proper semantic markup with alt text
- External links automatically get rel="noopener noreferrer"

## Performance Benefits

- **WebP Format**: 25-35% smaller file sizes compared to JPEG/PNG
- **Lazy Loading**: Images load only when needed
- **Object-fit**: Prevents layout shifts during image load
- **Consolidated CSS**: Reduces render-blocking resources

## Browser Support

- Modern browsers automatically use WebP
- Older browsers gracefully fallback to standard formats
- 100% browser compatibility through progressive enhancement
