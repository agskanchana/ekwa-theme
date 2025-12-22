# EKWA Mobile Icon Menu Block

A sticky bottom navigation menu optimized for mobile devices that provides quick access to key actions.

## Features

- **Sticky Bottom Positioning**: Fixed at the bottom of the screen on mobile devices
- **Responsive Breakpoint**: Configurable breakpoint (default: 1024px)
- **Smart Phone Handling**: Automatically adapts based on location count and phone numbers
- **Location-Aware**: Integrates with theme Customizer location data
- **Popup Modals**: Displays popups for multiple locations or phone numbers

## Menu Items

### 1. Call
- **Single Phone**: Direct tel: link when only one phone number exists
- **Multiple Options**: Shows popup with location names, existing patient and new patient numbers
- Reads from Customizer location data

### 2. Appointment
- Configurable link via ACF field
- Direct navigation to appointment page

### 3. Scroll Up
- Smooth scroll to top of page
- Icon-only display (no text label)

### 4. Treatments
- Opens the treatments submenu from main-menu block
- Targets menu items with class "treatments"
- Auto-closes after 5 seconds

### 5. Find Us
- **Single Location**: Direct link to Google Maps directions
- **Multiple Locations**: Shows popup with all location addresses and direction links
- Reads from Customizer location data

## ACF Fields

- **Breakpoint**: Maximum screen width to show menu (default: 1024px)
- **Appointment Link**: URL for appointment button
- **Menu Background Color**: Background color for the menu bar
- **Icon Color**: Fill color for SVG icons
- **Text Color**: Color for menu item labels
- **Active Color**: Color for active state and links in popups

## Usage

1. Add the block to your footer or template
2. Configure the breakpoint and colors in block settings
3. Set appointment page link
4. Ensure location data is configured in Customizer (Appearance > Customize > Site Settings)

## Location Data Requirements

The block reads from `location_info` theme mod which should contain:
- `city`: Location name
- `existing_patient_number`: Phone number for existing patients
- `new_patient_number`: Phone number for new patients
- `direction_link`: Google Maps URL
- `street_address`, `state`, `zip`: Address components

## Styling

All styles are consolidated and output in the `<head>` to prevent CLS (Cumulative Layout Shift). Custom CSS is automatically generated based on ACF field values.

## Browser Support

- Modern browsers with CSS transforms
- Mobile Safari
- Chrome/Android
- Requires JavaScript enabled
