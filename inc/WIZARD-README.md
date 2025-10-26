# EKWA Theme Plugin Installation Wizard

## Overview

The EKWA Theme now includes a comprehensive plugin installation wizard that automatically guides users through installing required and optional plugins when the theme is first activated.

## Features

- **Automatic Redirect**: Users are automatically redirected to the wizard upon theme activation
- **Two-Type Plugin Support**:
  - **WordPress.org Plugins**: Downloaded directly from the WordPress plugin repository
  - **Bundled Plugins**: Included in the theme's `mu-plugins` folder (like ACF Pro)
- **Step-by-Step Interface**: Clean, modern 3-step wizard
- **Smart Detection**: Automatically detects already installed/activated plugins
- **AJAX Installation**: Installs and activates plugins without page reloads
- **Required vs Optional**: Clearly distinguishes between required and optional plugins
- **Skip Option**: Users can skip the wizard and run it later

## Installation Steps

The wizard has 3 steps:

### Step 1: Required Plugins
- Advanced Custom Fields PRO (bundled)
- Kirki Customizer Framework (WordPress.org)

These plugins are essential for theme functionality and must be installed.

### Step 2: Optional Plugins
Users can choose which optional plugins to install:
- EKWA Related Articles (bundled)
- Load Scripts from SW (bundled)
- Wufoo Form Builder (bundled)
- Yoast SEO (WordPress.org)
- Duplicate Post Page Menu & Custom Post Type (WordPress.org)
- Rename wp-login.php (WordPress.org)
- Limit Login Attempts Reloaded (WordPress.org)
- Duplicate Menu (WordPress.org)
- Wordfence Security (WordPress.org)

### Step 3: Complete
Success screen with link to dashboard.

## File Structure

```
ekwa/
├── inc/
│   ├── class-ekwa-plugin-wizard.php    # Main wizard class
│   └── wizard-assets/
│       ├── wizard.css                   # Wizard styling
│       └── wizard.js                    # Wizard JavaScript
├── mu-plugins/                          # Bundled plugins
│   ├── advanced-custom-fields-pro.zip
│   ├── ekwa-related-articles-main.zip
│   ├── load-scripts-from-sw-master.zip
│   └── wufoo-form-builder-main.zip
└── functions.php                        # Wizard initialization
```

## How It Works

1. **Theme Activation**: When theme is activated, a transient is set
2. **Redirect**: On next admin page load, user is redirected to wizard
3. **Plugin Detection**: Wizard checks which plugins are already installed
4. **Installation**: User clicks install buttons
5. **AJAX Processing**: Plugins are installed and activated via AJAX
6. **Completion**: Wizard marked as complete, user redirected to dashboard

## Adding New Plugins

### WordPress.org Plugins

Edit `inc/class-ekwa-plugin-wizard.php` and add to the `$this->wp_org_plugins` array:

```php
array(
    'name'     => 'Plugin Name',
    'slug'     => 'plugin-slug',      // Must match WordPress.org slug
    'required' => false,               // true for required, false for optional
    'version'  => '1.0.0',
),
```

### Bundled Plugins

1. Add the plugin ZIP file to the `mu-plugins` folder
2. Edit `inc/class-ekwa-plugin-wizard.php` and add to the `$this->bundled_plugins` array:

```php
array(
    'name'     => 'Plugin Name',
    'slug'     => 'plugin-folder-name',  // Folder name when unzipped
    'file'     => 'plugin-file.zip',     // ZIP filename in mu-plugins folder
    'required' => false,                 // true for required, false for optional
),
```

## Testing the Wizard

### Reset Wizard for Testing

To see the wizard again after completing it, run this in your database or use a plugin like WP-CLI:

```sql
DELETE FROM wp_options WHERE option_name IN ('ekwa_wizard_completed', 'ekwa_wizard_skipped');
```

Or using WP-CLI:
```bash
wp option delete ekwa_wizard_completed
wp option delete ekwa_wizard_skipped
```

### Manual Access

Users can always access the wizard manually from:
**Appearance → Plugin Setup**

## Admin Notices

If required plugins are not installed, an admin notice appears on all admin pages (except the wizard itself) with a link to run the setup wizard.

## Filters Available

### Modify WordPress.org Plugins List
```php
add_filter( 'ekwa_wp_org_plugins', function( $plugins ) {
    // Add or modify plugins
    return $plugins;
});
```

### Modify Bundled Plugins List
```php
add_filter( 'ekwa_bundled_plugins', function( $plugins ) {
    // Add or modify plugins
    return $plugins;
});
```

## Customization

### Change Wizard Appearance

Edit `inc/wizard-assets/wizard.css` to customize colors, spacing, etc.

Key CSS classes:
- `.ekwa-wizard-wrap` - Main wrapper
- `.ekwa-wizard-header` - Header with gradient
- `.ekwa-wizard-steps` - Step indicators
- `.ekwa-plugin-item` - Individual plugin item
- `.required-badge` - "Required" badge styling

### Modify Wizard Behavior

Edit `inc/wizard-assets/wizard.js` to change:
- Installation order
- Error handling
- Success messages
- Progress tracking

## Troubleshooting

### Wizard Not Appearing

1. Check if plugins are already installed
2. Verify options: `ekwa_wizard_completed` and `ekwa_wizard_skipped` are not set
3. Ensure theme was just activated (check `ekwa_activation_redirect` transient)

### Plugin Installation Fails

1. Check file permissions on `wp-content/plugins` folder
2. Verify bundled ZIP files exist in `mu-plugins` folder
3. Check WordPress error logs
4. Ensure WordPress.org plugin slugs are correct

### Bundled Plugins Not Installing

1. Verify ZIP files are in `mu-plugins` folder
2. Check ZIP file structure - plugin folder should be at root of ZIP
3. Ensure file names match in the wizard configuration

## Security

- All AJAX requests are nonce-protected
- Capability checks ensure only users with `install_plugins` permission can run wizard
- File operations use WordPress core functions (Plugin_Upgrader)

## Browser Compatibility

The wizard is tested and works in:
- Chrome/Edge (latest)
- Firefox (latest)
- Safari (latest)
- Mobile browsers

## Accessibility

- Keyboard navigation supported
- Screen reader friendly
- Proper ARIA labels
- High contrast mode compatible

## Support

For issues or questions:
1. Check WordPress error logs
2. Verify plugin requirements
3. Test with default WordPress theme
4. Check for plugin conflicts

## Credits

- Built for EKWA Theme
- Uses WordPress Plugin Upgrader API
- Modern responsive design
- AJAX-powered installation
