# EKWA Icon Picker - Custom ACF Field

A powerful, searchable icon picker field for ACF that allows users to:
- Search and select from 100+ popular Font Awesome icons
- Paste custom SVG code from any icon library
- Visual icon grid with categories
- Real-time search filtering

## Features

### 🔍 **Searchable Icon Library**
- 100+ most popular Font Awesome icons pre-loaded
- Real-time search as you type
- Filter by category (Solid, Regular, Brands)
- Visual grid layout for easy browsing

### 📁 **Categories**
- **All**: All icons across categories
- **Solid**: Filled solid icons (house, user, phone, etc.)
- **Regular**: Outlined regular icons (heart, star, etc.)
- **Brands**: Brand/social media icons (Facebook, Twitter, etc.)

### 🎨 **Dual Input Methods**

#### 1. Font Awesome Tab
- Click "Search & Select Icon" button
- Modal opens with searchable grid
- Click any icon to select it
- Icon class automatically populated

#### 2. Custom SVG Tab
- Paste SVG code directly
- Download SVGs from:
  - [FontAwesome.com](https://fontawesome.com) (Pro SVG downloads)
  - [Heroicons.com](https://heroicons.com)
  - [Bootstrap Icons](https://icons.getbootstrap.com)
  - Any SVG library

## Usage

### In ACF Field Groups

This field type is registered automatically and can be used in any ACF field group:

```php
'fields' => array(
    array(
        'key' => 'field_icon',
        'label' => 'Icon',
        'name' => 'icon',
        'type' => 'icon_picker',
    )
)
```

### In Templates

Access the icon data:

```php
$icon = get_field('icon');

if ($icon) {
    $type = $icon['type'];  // 'fontawesome' or 'svg'
    $value = $icon['value']; // Icon class or SVG code

    if ($type === 'fontawesome') {
        echo '<i class="' . esc_attr($value) . '"></i>';
    } else {
        echo $value; // SVG code (already sanitized by ACF)
    }
}
```

## Popular Icons Included

### Medical/Dental Icons
- hospital, tooth, user-doctor, stethoscope
- pills, syringe, bed, wheelchair

### Business Icons
- building, store, warehouse, briefcase
- chart-line, chart-bar, money-bill, credit-card

### Communication Icons
- phone, envelope, comment, message
- bell, inbox, paper-plane

### Social Media Icons
- facebook, twitter, instagram, linkedin
- youtube, tiktok, pinterest, whatsapp

### General Icons
- house, user, search, heart, star
- calendar, clock, location-dot
- camera, image, video, music

...and 70+ more!

## Files Structure

```
settings/acf-icon-picker/
├── acf-icon-picker-field.php   # ACF field type class
├── icon-picker.js              # JavaScript functionality
└── icon-picker.css             # Styling
```

## How It Works

1. **Field Registration**: ACF field type registered via `acf/include_field_types` hook
2. **Asset Enqueueing**: CSS/JS loaded only on admin pages with ACF fields
3. **Icon Database**: Popular icons stored in JavaScript array
4. **Search**: Client-side filtering for instant results
5. **Selection**: Clicked icon class stored in hidden input
6. **Save**: Data stored as array with `type` and `value` keys

## Customization

### Add More Icons

Edit `icon-picker.js` and add to the `popularIcons` object:

```javascript
const popularIcons = {
    solid: [
        'fa-solid fa-house',
        'fa-solid fa-your-icon', // Add here
        ...
    ]
};
```

### Change Modal Size

Edit `icon-picker.css`:

```css
.ekwa-icon-modal-content {
    max-width: 1200px; /* Change from 900px */
}
```

### Add More Categories

1. Add category button in `acf-icon-picker-field.php`
2. Add icon array in `icon-picker.js`
3. Update loadIcons() function

## Browser Support

- Chrome, Firefox, Safari, Edge (modern versions)
- IE11+ (with some style degradation)
- Works in Gutenberg editor
- Works in ACF Classic editor

## Performance

- **No API calls** - Icons pre-loaded in JavaScript
- **Client-side search** - Instant filtering
- **Lazy loading** - Icons rendered only when modal opens
- **Optimized grid** - CSS Grid for efficient layout

## Integration with Icon Block

This icon picker is designed to work with the EKWA Icon Block but can be used with any ACF field group. Simply set the field type to `icon_picker`.

## Troubleshooting

### Icons not showing in modal
- Check Font Awesome is loaded: `plugins/fontawesome/css/all.min.css`
- Clear browser cache
- Check console for JavaScript errors

### SVG code not saving
- Ensure SVG code is valid
- Check for special characters
- ACF textarea field sanitizes automatically

### Modal not opening
- Check jQuery is loaded
- Check for JavaScript conflicts
- Ensure ACF is active

## Future Enhancements

Possible additions:
- Icon color preview in picker
- Recent icons list
- Favorite icons
- Upload custom SVG files
- Integration with icon APIs (Iconify, etc.)
- Icon size preview

## Version History

- **1.0.0** - Initial release (November 2025)
  - Font Awesome icon grid with search
  - Custom SVG code input
  - Category filtering
  - Dual tab interface
  - Modal popup picker
