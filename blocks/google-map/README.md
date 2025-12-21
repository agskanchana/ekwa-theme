# EKWA Google Map Block

Display a Google Map with lazy loading support.

## Features

- **Flexible Input**: Accept either full iframe code or just the src URL
- **Lazy Loading**: Automatically uses `data-src` and `lazyload` class for optimal performance
- **Responsive**: Width is always 100%, adapts to container
- **Customizable Height**: Set custom height in pixels
- **Accessible**: Includes title attribute for screen readers

## ACF Fields

### iframe_input (textarea)
- **Label**: Google Map Iframe or URL
- **Instructions**: Paste the full iframe code from Google Maps, or just the src URL
- **Required**: Yes

### map_height (number)
- **Label**: Map Height
- **Instructions**: Height in pixels
- **Default**: 450
- **Required**: Yes

### map_title (text)
- **Label**: Map Title
- **Instructions**: Descriptive title for accessibility (e.g., "Map of Wyckoff Ophthalmology")
- **Default**: Google Map
- **Required**: Yes

## Usage

### Input Full Iframe
```html
<iframe src="https://www.google.com/maps/embed?pb=..." width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
```

### Input Just URL
```
https://www.google.com/maps/embed?pb=...
```

## Output

The block will output:
```html
<iframe
    data-src="[extracted-url]"
    class="lazyload"
    width="100%"
    height="[custom-height]"
    style="border:0;"
    allowfullscreen=""
    loading="lazy"
    referrerpolicy="no-referrer-when-downgrade"
    title="[custom-title]">
</iframe>
```

## Notes

- Width is always 100% regardless of input
- Uses `data-src` for lazy loading (works with theme's lazy loading implementation)
- Automatically extracts src from full iframe code
- Supports block alignment (wide, full)
- Includes custom anchor and className support
