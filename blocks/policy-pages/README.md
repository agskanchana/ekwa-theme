# EKWA Policy Pages Block

Display dynamically generated policy pages from the EKWA Policies API with automatic practice information insertion.

## Features

- **Dynamic Content Loading**: Fetches policy content from EKWA Policies API
- **Automatic Data Insertion**: Automatically replaces placeholders with your practice information
- **Call Tracking**: Supports AdWords call tracking number switching
- **Error Handling**: Graceful error messages with detailed logging
- **Loading States**: User-friendly loading indicators
- **Responsive**: Works on all device sizes

## ACF Fields

### policy_page_id (select)
- **Label**: Select Policy Page
- **Instructions**: Choose which policy page to display
- **Options**:
  - Privacy Policy
  - Terms of Service
  - Disclaimer
  - Cookie Policy
  - HIPAA Privacy Notice
  - Accessibility Statement
  - And more...
- **Required**: Yes

## Automatic Data Replacement

The block automatically fetches and replaces the following information from your site settings:

- **Practice Name**: From Customizer → `practise_name`
- **Phone Number**: From Customizer → `call_tracking_number` (or `adsense_number` if ads detected)
- **Address**: From location settings (street, city, state, zip)
- **Email**: From Customizer → `email_address`
- **Domain**: Automatically detected
- **Country**: From Customizer → `country`

## Call Tracking

The block automatically detects AdWords campaigns and switches to the appropriate tracking number:

```php
if (isset($_COOKIE['adward_number']) || isset($_GET['ads'])) {
    // Use AdWords tracking number
    $phone_num = get_theme_mod('adsense_number');
} else {
    // Use regular call tracking number
    $phone_num = get_theme_mod('call_tracking_number');
}
```

## API Integration

Connects to: `https://policies.ekwa.com/wp-json/ws/v1/policy_page`

**Parameters sent:**
- `id` - Policy page ID
- `bussiness_name` - Practice name
- `phone` - Phone number
- `country` - Country code
- `domain` - Site domain
- `address` - Street address
- `city` - City
- `state` - State
- `zip` - ZIP code
- `email` - Email address

## Error Handling

- **Loading State**: Shows "Loading policy content..." while fetching
- **Success**: Displays formatted policy content
- **Error**: Shows user-friendly error message with details
- **Missing Config**: Shows prompt to select policy page if not configured

## Usage

1. Add the block to your page
2. Select a policy page type from the dropdown
3. Content will be automatically loaded and personalized

## Styling

The block includes responsive typography with proper spacing:

- Headings with appropriate margins
- Line height of 1.8 for readability
- List indentation
- Error and loading state styling

## Browser Support

- Modern browsers (Chrome, Firefox, Safari, Edge)
- Uses ES5-compatible JavaScript
- Fetch API with error handling
- URLSearchParams for safe URL building

## Security

- All data is properly escaped using `esc_attr()` and `esc_html()`
- URL parameters are encoded
- JSON responses are parsed safely
- HTTPS enforced for API calls

## Notes

- Content is loaded client-side via JavaScript
- Requires internet connection to fetch policy content
- Policy content is cached by the browser
- Works with both preview and live modes
