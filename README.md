
EKWA THEME
===

## Description

EKWA is a professional WordPress theme featuring a comprehensive plugin installation wizard that guides you through setting up all required dependencies.

## Installation

1. Upload the theme to your WordPress installation
2. Activate the theme from Appearance → Themes
3. You will be automatically redirected to the Plugin Installation Wizard
4. Follow the wizard steps to install required plugins:
   - Advanced Custom Fields PRO (bundled)
   - Kirki Customizer Framework (from WordPress.org)
5. Optionally install recommended plugins
6. Complete the wizard and start building your site!

## Required Plugins

These plugins are essential for the theme to work properly:

1. **Advanced Custom Fields PRO** (bundled in theme)
   - Provides custom fields functionality
   - Included in `mu-plugins` folder

2. **Kirki Customizer Framework** (WordPress.org)
   - Powers the theme customizer options
   - Installed automatically from WordPress plugin repository

## Optional Plugins

The wizard also offers these optional plugins:

- **EKWA Related Articles** - Display related content
- **Load Scripts from SW** - Service worker support
- **Wufoo Form Builder** - Form integration
- **Yoast SEO** - SEO optimization
- **Duplicate Post** - Clone posts and pages
- **Rename wp-login.php** - Security enhancement
- **Limit Login Attempts** - Brute force protection
- **Duplicate Menu** - Clone navigation menus
- **Wordfence Security** - Security & firewall

## Features

- 🧙‍♂️ **Setup Wizard** - Automated plugin installation
- 🎨 **Customizer Options** - Powered by Kirki
- 📱 **Responsive Design** - Mobile-first approach
- ⚡ **Performance Optimized** - Clean, efficient code
- 🔒 **Security Ready** - Built with WordPress best practices
- ♿ **Accessible** - WCAG compliant markup

## Running the Wizard Again

You can access the plugin setup wizard anytime from:
**Appearance → Plugin Setup**

To reset and see the wizard from scratch, see `inc/WIZARD-README.md` for instructions.

## Customization

### Color Variables

The theme uses CSS custom properties for easy color customization. Edit from:
**Appearance → Customize → Colors**

### Advanced Customization

For detailed wizard customization and development information, see:
`inc/WIZARD-README.md`

## File Structure

```
ekwa/
├── inc/                          # Theme includes
│   ├── class-ekwa-plugin-wizard.php
│   ├── wizard-assets/
│   └── WIZARD-README.md
├── mu-plugins/                   # Bundled plugins
├── settings/                     # Theme settings
├── css/                         # Stylesheets
├── js/                          # JavaScript files
└── functions.php                # Theme functions
```

## Support

For issues with:
- **Plugin Installation**: Check `inc/WIZARD-README.md`
- **Theme Customization**: Check WordPress Customizer
- **ACF Fields**: Ensure ACF Pro is activated

## Developer Information

### Theme Hooks

The theme provides filters for customizing the plugin wizard:

```php
// Modify WordPress.org plugins list
add_filter( 'ekwa_wp_org_plugins', 'my_custom_plugins' );

// Modify bundled plugins list
add_filter( 'ekwa_bundled_plugins', 'my_bundled_plugins' );
```

### Requirements

- WordPress 5.0 or higher
- PHP 7.4 or higher
- MySQL 5.6 or higher

## Changelog

### Version 2.0.0
- ✨ Added comprehensive plugin installation wizard
- 🔄 Replaced old plugin manager with modern wizard interface
- 📦 Support for both WordPress.org and bundled plugins
- 🎯 Step-by-step guided installation process
- ✅ Automatic plugin detection and activation

### Version 1.0.0
- Initial release

## Credits

- Theme by EKWA
- Powered by WordPress
- Uses Kirki Customizer Framework
- Includes Advanced Custom Fields PRO

## License

This theme is licensed under the GPL v2 or later.

---

**Need Help?** See the detailed documentation in `inc/WIZARD-README.md`

