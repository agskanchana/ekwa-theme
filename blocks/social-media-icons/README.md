# EKWA Social Media Icons Block

Display social media icons with optional share functionality.

## Features

- **Customizable Icons**: Font icons or custom images
- **Share Buttons**: Facebook, Twitter, Pinterest sharing
- **Flexible Styling**: Custom size, color, gap, and hover effects
- **Alignment Options**: Left, center, right, wide, full
- **Responsive**: Mobile-friendly with optional mobile hide for share button
- **Smooth Transitions**: Animated hover and toggle effects

## ACF Fields

### size (number)
- **Label**: Icon Size
- **Instructions**: Size of icons in pixels
- **Default**: 20
- **Min**: 10
- **Max**: 100

### gap (number)
- **Label**: Gap Between Icons
- **Instructions**: Space between icons in pixels
- **Default**: 10
- **Min**: 0
- **Max**: 50

### color (color_picker)
- **Label**: Icon Color
- **Instructions**: Default color for icons
- **Default**: #000000
- **Enable Opacity**: Yes

### hover_color (color_picker)
- **Label**: Hover Color
- **Instructions**: Color when hovering over icons
- **Default**: #183153
- **Enable Opacity**: Yes

### hide_share_icon (true_false)
- **Label**: Hide Share Button
- **Instructions**: Hide the share button functionality
- **Default**: No

## Social Media Configuration

Social media links are configured in the WordPress Customizer under **Social Media Settings**.

Each social media link can have:
- **Profile Name**: For accessibility
- **Link URL**: The social profile URL
- **Icon Font**: FontAwesome class (e.g., `fab fa-facebook-f`)
- **Icon Image**: Custom image upload option

## Share Functionality

The share button provides quick sharing to:
- **Facebook**: Opens sharer dialog
- **Twitter (X)**: Opens tweet composer
- **Pinterest**: Opens pin creation

Share links include:
- Current page URL
- Page title
- Opens in popup window (600x300)

## Alignment

Supports WordPress block alignment:
- **Left**: Icons aligned to the left
- **Center**: Icons centered
- **Right**: Icons aligned to the right
- **Wide**: Full container width
- **Full**: Full viewport width

## Usage

1. Add the block to your page
2. Configure icon size, gap, and colors
3. Choose alignment
4. Toggle share button if needed
5. Icons will automatically display from Customizer settings

## Styling Options

- **Icon Size**: 10-100px
- **Icon Gap**: 0-50px
- **Icon Color**: Any color with opacity
- **Hover Color**: Any color with opacity
- **Custom Classes**: Add via block settings

## Mobile Behavior

- Share button hides on mobile devices (max-width: 768px)
- Icons remain visible and functional
- Touch-friendly spacing maintained

## Security

- All URLs properly escaped
- noopener noreferrer on external links
- Popup window restrictions applied
- Aria labels for accessibility

## Browser Support

- Modern browsers (Chrome, Firefox, Safari, Edge)
- Font Awesome 5+ required for icons
- CSS transitions for smooth animations
- Progressive enhancement for older browsers

## Notes

- Requires social media links configured in Customizer
- Works with Font Awesome icons
- Supports custom image icons
- Share button uses JavaScript popup windows
- Mobile-responsive with hide options
