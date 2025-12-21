# EKWA Sitemap Block

Display an interactive sitemap with collapsible tree view navigation.

## Features

- **Collapsible Tree View**: Interactive menu display with expand/collapse functionality
- **Collapse/Expand All Controls**: Quick controls to collapse or expand all menu items
- **WordPress Menu Integration**: Uses WordPress nav menu system
- **Persistent State**: Remembers expanded/collapsed state based on location
- **Animated Transitions**: Smooth expand/collapse animations
- **Responsive Design**: Works on all device sizes

## ACF Fields

### menu_slug (text)
- **Label**: Menu Location Slug
- **Instructions**: Enter the menu location slug (e.g., "site-map", "footer-menu")
- **Default**: site-map
- **Required**: Yes

## Usage

1. Create a menu in WordPress (**Appearance → Menus**)
2. Assign the menu to a menu location (or create a custom location)
3. Add the Sitemap block to your page
4. Enter the menu location slug in the block settings
5. The menu will display as an interactive tree view

## Menu Setup

To create a sitemap menu location:

```php
// In functions.php
register_nav_menus(array(
    'site-map' => __('Sitemap', 'ekwa')
));
```

Then assign your sitemap menu to this location in **Appearance → Menus**.

## Tree View Controls

- **Collapse All**: Collapses all expanded menu items
- **Expand All**: Expands all collapsed menu items
- **Click Item**: Toggle expand/collapse for individual items
- **Location Persistence**: Automatically expands items leading to current page

## Styling

The block includes:
- Tree view icons for expand/collapse indicators
- Line graphics showing hierarchy
- Hover states for interactive elements
- Proper spacing and indentation for nested items

## JavaScript Features

- jQuery cookie support for state persistence
- Animated expand/collapse transitions
- Automatic current page highlighting
- Dynamic class management for tree states

## Files Included

- `treeview.js` - Tree view functionality
- `treeview.css` - Tree view styles
- `treeview-default.gif` - Icon sprites
- `treeview-default-line.gif` - Line graphics

## Browser Support

- Modern browsers (Chrome, Firefox, Safari, Edge)
- Requires jQuery (included with WordPress)
- CSS3 for styling
- Progressive enhancement for older browsers

## Notes

- Uses WordPress nav menu walker
- Supports unlimited nesting levels
- Compatible with custom menu item classes
- Works with any menu location
- Automatic detection of menu availability

## Example Menu Locations

Common sitemap menu locations:
- `site-map` - Main sitemap
- `footer-menu` - Footer navigation
- `header-menu` - Header navigation
- `sidebar-menu` - Sidebar navigation
