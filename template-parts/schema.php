<?php
/**
 * Schema.org JSON-LD Output
 * Generates valid JSON-LD structured data for single or multiple locations
 */

// Prevent function redeclaration
if (!function_exists('ekwa_format_schema_time')) {
	/**
	 * Format time for schema.org (convert 12-hour to 24-hour format)
	 * Schema.org accepts both formats, but 24-hour is preferred
	 */
	function ekwa_format_schema_time($time_string) {
		if (empty($time_string)) return '';

		$time_string = trim($time_string);
		$parts = explode(' ', $time_string);

		if (count($parts) === 2) {
			list($time, $period) = $parts;
			$time_parts = explode(':', $time);
			if (count($time_parts) === 2) {
				list($hour, $minute) = $time_parts;
				$hour = intval($hour);

				if (strtoupper($period) === 'PM' && $hour !== 12) {
					$hour += 12;
				} elseif (strtoupper($period) === 'AM' && $hour === 12) {
					$hour = 0;
				}

				return sprintf('%02d:%02d', $hour, $minute);
			}
		}

		return $time_string;
	}
}

if (!function_exists('ekwa_get_opening_hours')) {
	/**
	 * Get opening hours specification for a location
	 */
	function ekwa_get_opening_hours($location_number) {
		$working_hours = get_location_working_hours($location_number);

		if (!$working_hours || !is_array($working_hours)) {
			return array();
		}

		$hours_spec = array();

		foreach ($working_hours as $day_hours) {
			// Skip closed days
			if (!empty($day_hours['closed']) && ($day_hours['closed'] === true || $day_hours['closed'] === '1' || $day_hours['closed'] === 1)) {
				continue;
			}

			// Only add if we have valid opening/closing times
			if (!empty($day_hours['opening']) && !empty($day_hours['closing'])) {
				$hours_spec[] = array(
					'@type' => 'OpeningHoursSpecification',
					'dayOfWeek' => $day_hours['day'],
					'opens' => ekwa_format_schema_time($day_hours['opening']),
					'closes' => ekwa_format_schema_time($day_hours['closing'])
				);
			}
		}

		return $hours_spec;
	}
}

if (!function_exists('ekwa_build_schema_location')) {
	/**
	 * Build schema for a single location
	 */
	function ekwa_build_schema_location($location_data, $location_number, $schema_country, $logo_url, $is_department = false) {
		$schema = array();

		// Type and name
		$schema['@type'] = get_theme_mod('organization_type', 'LocalBusiness');
		$schema['name'] = get_theme_mod('practise_name', get_bloginfo('name'));

		// Add URL only for main organization (not departments)
		if (!$is_department) {
			$schema['url'] = get_option('siteurl');
		}

		// Add logo/image
		if ($logo_url) {
			if (!$is_department) {
				$schema['logo'] = $logo_url;
			}
			$schema['image'] = $logo_url;
		}

		// Price range
		$schema['priceRange'] = '$$';

		// Map link
		if (!empty($location_data['direction'])) {
			$schema['hasMap'] = $location_data['direction'];
		}

		// Address
		$address = array('@type' => 'PostalAddress');
		if (!empty($location_data['street_address'])) {
			$address['streetAddress'] = $location_data['street_address'];
		}
		if (!empty($location_data['city'])) {
			$address['addressLocality'] = $location_data['city'];
		}
		if (!empty($location_data['state'])) {
			$address['addressRegion'] = $location_data['state'];
		}
		if (!empty($location_data['zip'])) {
			$address['postalCode'] = $location_data['zip'];
		}
		if ($schema_country) {
			$address['addressCountry'] = $schema_country;
		}

		if (count($address) > 1) {
			$schema['address'] = $address;
		}

		// Telephone
		if (!empty($location_data['phone'])) {
			$schema['telephone'] = $location_data['phone'];
		}

		// Opening hours
		$opening_hours = ekwa_get_opening_hours($location_number);
		if (!empty($opening_hours)) {
			$schema['openingHoursSpecification'] = $opening_hours;
		}

		// Geo coordinates
		if (!empty($location_data['latitude']) && !empty($location_data['longitude'])) {
			$schema['geo'] = array(
				'@type' => 'GeoCoordinates',
				'latitude' => $location_data['latitude'],
				'longitude' => $location_data['longitude']
			);
		}

		return $schema;
	}
}

// Get logo
$custom_logo_id = get_theme_mod('custom_logo');
$image_logo = wp_get_attachment_image_src($custom_logo_id, 'full');
$logo_url = ($image_logo && isset($image_logo[0])) ? $image_logo[0] : '';

// Get country code
$country = get_theme_mod('country', 'United States');
$country_codes = array(
	'United States' => 'US',
	'Canada' => 'CA',
	'Australia' => 'AU',
	'England' => 'GB',
	'United Kingdom' => 'GB'
);
$schema_country = isset($country_codes[$country]) ? $country_codes[$country] : 'US';

// Get all locations
$departments = get_theme_mod('location_info', array());
$dept_count = (is_array($departments) && !empty($departments)) ? count($departments) : 0;

// Build the schema data structure
$schema_data = array();

// SINGLE LOCATION
if ($dept_count <= 1) {
	$location_data = ($dept_count === 1 && isset($departments[0])) ? $departments[0] : array();

	// Build single location schema
	$schema_data = ekwa_build_schema_location($location_data, 1, $schema_country, $logo_url, false);

	// Add context
	$schema_data = array_merge(array('@context' => 'https://schema.org'), $schema_data);

	// Add email
	$email_address = get_theme_mod('email_address');
	if ($email_address) {
		$schema_data['email'] = $email_address;
	}

	// Add social media links
	$social_media_links = get_theme_mod('social_media_links', array());
	$social_urls = array();
	if ($social_media_links && is_array($social_media_links)) {
		foreach ($social_media_links as $link) {
			if (isset($link['social_media_link']) && !empty($link['social_media_link'])) {
				$social_urls[] = $link['social_media_link'];
			}
		}
	}
	if (!empty($social_urls)) {
		$schema_data['sameAs'] = $social_urls;
	}
}

// MULTIPLE LOCATIONS
if ($dept_count > 1) {
	$schema_data['@context'] = 'https://schema.org';
	$schema_data['@type'] = 'Organization';
	$schema_data['name'] = get_theme_mod('practise_name', get_bloginfo('name'));
	$schema_data['url'] = get_option('siteurl');

	// Add logo
	if ($logo_url) {
		$schema_data['logo'] = $logo_url;
		$schema_data['image'] = $logo_url;
	}

	// Add email
	$email_address = get_theme_mod('email_address');
	if ($email_address) {
		$schema_data['email'] = $email_address;
	}

	// Build department list
	$department_list = array();

	foreach ($departments as $dept_key => $dept_value) {
		$location_number = $dept_key + 1;
		$dept_schema = ekwa_build_schema_location($dept_value, $location_number, $schema_country, $logo_url, true);
		$department_list[] = $dept_schema;
	}

	$schema_data['department'] = $department_list;

	// Add social media links
	$social_media_links = get_theme_mod('social_media_links', array());
	$social_urls = array();
	if ($social_media_links && is_array($social_media_links)) {
		foreach ($social_media_links as $link) {
			if (isset($link['social_media_link']) && !empty($link['social_media_link'])) {
				$social_urls[] = $link['social_media_link'];
			}
		}
	}
	if (!empty($social_urls)) {
		$schema_data['sameAs'] = $social_urls;
	}
}

// Output as valid JSON-LD
echo '<script type="application/ld+json">' . "\n";
echo wp_json_encode($schema_data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
echo "\n" . '</script>';
?>

