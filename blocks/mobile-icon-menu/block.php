<?php
/**
 * EKWA Mobile Icon Menu Block Template
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

// Create id attribute allowing for custom "anchor" value.
$block_id = 'ekwa-mobile-icon-menu-' . $block['id'];
if (!empty($block['anchor'])) {
    $block_id = $block['anchor'];
}

// Create class attribute allowing for custom "className"
$class_name = 'ekwa-mobile-icon-menu';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}

// Get ACF fields
$breakpoint = get_field('breakpoint') ?: 1024;
$menu_bg = get_field('menu_background') ?: '#ffffff';
$icon_color = get_field('icon_color') ?: '#333333';
$text_color = get_field('text_color') ?: '#333333';
$active_color = get_field('active_color') ?: '#1e73be';

// Get appointment link from theme function
$appointment_link = get_appointment_link() ?: '#';
$appointment_type = get_theme_mod('appointment_page_type', 'page');
$appointment_target = ($appointment_type === 'external') ? ' target="_blank"' : '';

// Get location data from Customizer
$location_info = get_theme_mod('location_info', array());
$has_multiple_locations = is_array($location_info) && count($location_info) > 1;

// Prepare phone numbers data
$phone_data = array();
foreach ($location_info as $index => $location) {
    $city = isset($location['city']) ? $location['city'] : 'Location ' . ($index + 1);
    $existing_phone = isset($location['phone_ex']) ? $location['phone_ex'] : '';
    $new_phone = isset($location['phone']) ? $location['phone'] : '';
    $direction_link = isset($location['direction']) ? $location['direction'] : '';
    $address = '';
    
    if (isset($location['street_address'])) {
        $address .= $location['street_address'];
    }
    if (isset($location['city'])) {
        $address .= $address ? ', ' . $location['city'] : $location['city'];
    }
    if (isset($location['state'])) {
        $address .= $address ? ', ' . $location['state'] : $location['state'];
    }
    if (isset($location['zip'])) {
        $address .= $address ? ' ' . $location['zip'] : $location['zip'];
    }
    
    $phone_data[] = array(
        'city' => $city,
        'existing_phone' => $existing_phone,
        'new_phone' => $new_phone,
        'direction_link' => $direction_link,
        'address' => $address
    );
}

// Check for ad tracking cookie or parameter
$is_ad_tracking = (isset($_COOKIE['adward_number']) || isset($_GET['ads']));

// Determine if we need a popup for call
$total_phones = 0;
$has_both_phone_types = false;
foreach ($phone_data as $data) {
    if (!empty($data['existing_phone'])) $total_phones++;
    if (!empty($data['new_phone'])) $total_phones++;
    // Check if this location has both phone types
    if (!empty($data['existing_phone']) && !empty($data['new_phone'])) {
        $has_both_phone_types = true;
    }
}

// Ad tracking override - always show single ad number
if ($is_ad_tracking) {
    $needs_call_popup = false;
    $ad_phone_number = get_theme_mod('adsense_number', '');
    if (function_exists('mobile_number')) {
        $single_phone = mobile_number($ad_phone_number);
    } else {
        $single_phone = preg_replace('/[^0-9]/', '', $ad_phone_number);
    }
} else {
    // Show popup if multiple locations OR one location with both phone types
    $needs_call_popup = (count($phone_data) > 1) || (count($phone_data) === 1 && $has_both_phone_types);
    
    // Get single phone number if applicable
    $single_phone = '';
    if (!$needs_call_popup && $total_phones === 1) {
        foreach ($phone_data as $data) {
            if (!empty($data['existing_phone'])) {
                $single_phone = mobile_number($data['existing_phone']);
                break;
            }
            if (!empty($data['new_phone'])) {
                $single_phone = mobile_number($data['new_phone']);
                break;
            }
        }
    }
}

// Determine if we need a popup for find us
$needs_location_popup = count($phone_data) > 1;
$single_direction_link = '';
if (!$needs_location_popup && count($phone_data) === 1) {
    $single_direction_link = $phone_data[0]['direction_link'];
}

// Collect custom CSS for consolidated output
if (!is_admin() && !$is_preview) {
    global $ekwa_section_head_styles;

    if (!isset($ekwa_section_head_styles)) {
        $ekwa_section_head_styles = [];
    }

    $menu_css = "/* Mobile Icon Menu Block Styles for #" . $block_id . " */\n";
    
    // Main container - floating dock style
    $menu_css .= "#" . $block_id . " {\n";
    $menu_css .= "  display: none;\n";
    $menu_css .= "  position: fixed;\n";
    $menu_css .= "  bottom: 20px;\n";
    $menu_css .= "  left: 50%;\n";
    $menu_css .= "  transform: translateX(-50%);\n";
    $menu_css .= "  z-index: 9998;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "@media (max-width: " . intval($breakpoint) . "px) {\n";
    $menu_css .= "  #" . $block_id . " { display: block; }\n";
    $menu_css .= "}\n\n";
    
    // Safe area for iOS devices
    $menu_css .= "@supports (padding-bottom: env(safe-area-inset-bottom)) {\n";
    $menu_css .= "  #" . $block_id . " {\n";
    $menu_css .= "    bottom: calc(16px + env(safe-area-inset-bottom));\n";
    $menu_css .= "  }\n";
    $menu_css .= "}\n\n";
    
    // Wrapper - glassmorphism container
    $menu_css .= "#" . $block_id . " .mobile-icon-menu-wrapper {\n";
    $menu_css .= "  display: flex;\n";
    $menu_css .= "  align-items: center;\n";
    $menu_css .= "  gap: 6px;\n";
    $menu_css .= "  padding: 10px 16px;\n";
    $menu_css .= "  background: " . esc_attr($menu_bg) . "d9;\n"; // Adding transparency
    $menu_css .= "  backdrop-filter: blur(20px) saturate(180%);\n";
    $menu_css .= "  -webkit-backdrop-filter: blur(20px) saturate(180%);\n";
    $menu_css .= "  border-radius: 24px;\n";
    $menu_css .= "  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12),\n";
    $menu_css .= "              0 2px 8px rgba(0, 0, 0, 0.08),\n";
    $menu_css .= "              inset 0 0 0 1px rgba(255, 255, 255, 0.5);\n";
    $menu_css .= "  border: 1px solid rgba(0, 0, 0, 0.06);\n";
    $menu_css .= "}\n\n";
    
    // Menu items
    $menu_css .= "#" . $block_id . " .menu-item {\n";
    $menu_css .= "  display: flex;\n";
    $menu_css .= "  flex-direction: column;\n";
    $menu_css .= "  align-items: center;\n";
    $menu_css .= "  justify-content: center;\n";
    $menu_css .= "  gap: 4px;\n";
    $menu_css .= "  text-decoration: none;\n";
    $menu_css .= "  color: " . esc_attr($text_color) . ";\n";
    $menu_css .= "  padding: 10px 14px;\n";
    $menu_css .= "  border-radius: 16px;\n";
    $menu_css .= "  position: relative;\n";
    $menu_css .= "  transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);\n";
    $menu_css .= "  overflow: hidden;\n";
    $menu_css .= "  cursor: pointer;\n";
    $menu_css .= "  border: none;\n";
    $menu_css .= "  background: none;\n";
    $menu_css .= "}\n\n";
    
    // Gradient background on hover
    $menu_css .= "#" . $block_id . " .menu-item::before {\n";
    $menu_css .= "  content: '';\n";
    $menu_css .= "  position: absolute;\n";
    $menu_css .= "  inset: 0;\n";
    $menu_css .= "  background: linear-gradient(135deg, " . esc_attr($active_color) . " 0%, " . esc_attr($active_color) . "cc 100%);\n";
    $menu_css .= "  opacity: 0;\n";
    $menu_css .= "  border-radius: 16px;\n";
    $menu_css .= "  transition: opacity 0.3s ease;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "#" . $block_id . " .menu-item:hover::before,\n";
    $menu_css .= "#" . $block_id . " .menu-item:focus::before {\n";
    $menu_css .= "  opacity: 1;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "#" . $block_id . " .menu-item:hover {\n";
    $menu_css .= "  transform: translateY(-8px) scale(1.1);\n";
    $menu_css .= "  color: #fff;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "#" . $block_id . " .menu-item:active {\n";
    $menu_css .= "  transform: translateY(-4px) scale(1.05);\n";
    $menu_css .= "}\n\n";
    
    // Different gradient colors for each item type
    $menu_css .= "#" . $block_id . " .menu-item.call-item::before {\n";
    $menu_css .= "  background: linear-gradient(135deg, #10b981 0%, #059669 100%);\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "#" . $block_id . " .menu-item.appointment-item::before {\n";
    $menu_css .= "  background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "#" . $block_id . " .menu-item.treatments-item::before {\n";
    $menu_css .= "  background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "#" . $block_id . " .menu-item.findus-item::before {\n";
    $menu_css .= "  background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%);\n";
    $menu_css .= "}\n\n";
    
    // SVG icons
    $menu_css .= "#" . $block_id . " .menu-item svg {\n";
    $menu_css .= "  width: 22px;\n";
    $menu_css .= "  height: 22px;\n";
    $menu_css .= "  stroke: " . esc_attr($icon_color) . ";\n";
    $menu_css .= "  stroke-width: 1.8;\n";
    $menu_css .= "  fill: none;\n";
    $menu_css .= "  position: relative;\n";
    $menu_css .= "  z-index: 1;\n";
    $menu_css .= "  transition: all 0.3s ease;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "#" . $block_id . " .menu-item:hover svg {\n";
    $menu_css .= "  stroke: #fff;\n";
    $menu_css .= "  filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));\n";
    $menu_css .= "}\n\n";
    
    // Labels
    $menu_css .= "#" . $block_id . " .menu-item span.label {\n";
    $menu_css .= "  font-size: 9px;\n";
    $menu_css .= "  font-weight: 600;\n";
    $menu_css .= "  letter-spacing: 0.3px;\n";
    $menu_css .= "  text-transform: uppercase;\n";
    $menu_css .= "  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;\n";
    $menu_css .= "  position: relative;\n";
    $menu_css .= "  z-index: 1;\n";
    $menu_css .= "  transition: all 0.3s ease;\n";
    $menu_css .= "  white-space: nowrap;\n";
    $menu_css .= "}\n\n";
    
    // Tooltip
    $menu_css .= "#" . $block_id . " .menu-item .tooltip {\n";
    $menu_css .= "  position: absolute;\n";
    $menu_css .= "  top: -36px;\n";
    $menu_css .= "  left: 50%;\n";
    $menu_css .= "  transform: translateX(-50%) scale(0.8);\n";
    $menu_css .= "  background: #1f2937;\n";
    $menu_css .= "  color: #fff;\n";
    $menu_css .= "  padding: 6px 12px;\n";
    $menu_css .= "  border-radius: 8px;\n";
    $menu_css .= "  font-size: 11px;\n";
    $menu_css .= "  font-weight: 500;\n";
    $menu_css .= "  letter-spacing: 0.3px;\n";
    $menu_css .= "  white-space: nowrap;\n";
    $menu_css .= "  opacity: 0;\n";
    $menu_css .= "  pointer-events: none;\n";
    $menu_css .= "  transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);\n";
    $menu_css .= "  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "#" . $block_id . " .menu-item .tooltip::after {\n";
    $menu_css .= "  content: '';\n";
    $menu_css .= "  position: absolute;\n";
    $menu_css .= "  bottom: -5px;\n";
    $menu_css .= "  left: 50%;\n";
    $menu_css .= "  transform: translateX(-50%);\n";
    $menu_css .= "  border-width: 5px 5px 0;\n";
    $menu_css .= "  border-style: solid;\n";
    $menu_css .= "  border-color: #1f2937 transparent transparent;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "#" . $block_id . " .menu-item:hover .tooltip {\n";
    $menu_css .= "  opacity: 1;\n";
    $menu_css .= "  transform: translateX(-50%) scale(1);\n";
    $menu_css .= "}\n\n";
    
    // Divider
    $menu_css .= "#" . $block_id . " .nav-divider {\n";
    $menu_css .= "  width: 1px;\n";
    $menu_css .= "  height: 32px;\n";
    $menu_css .= "  background: linear-gradient(to bottom, transparent, rgba(0, 0, 0, 0.15), transparent);\n";
    $menu_css .= "  margin: 0 4px;\n";
    $menu_css .= "}\n\n";
    
    // FAB Center Button (Scroll Up)
    $menu_css .= "#" . $block_id . " .menu-item.scroll-up {\n";
    $menu_css .= "  background: linear-gradient(135deg, " . esc_attr($active_color) . " 0%, " . esc_attr($active_color) . "cc 100%);\n";
    $menu_css .= "  color: #fff;\n";
    $menu_css .= "  width: 52px;\n";
    $menu_css .= "  height: 52px;\n";
    $menu_css .= "  border-radius: 50%;\n";
    $menu_css .= "  padding: 0;\n";
    $menu_css .= "  margin: -10px 4px;\n";
    $menu_css .= "  box-shadow: 0 4px 16px " . esc_attr($active_color) . "66,\n";
    $menu_css .= "              0 2px 6px rgba(0, 0, 0, 0.1);\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "#" . $block_id . " .menu-item.scroll-up::before {\n";
    $menu_css .= "  display: none;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "#" . $block_id . " .menu-item.scroll-up:hover {\n";
    $menu_css .= "  transform: translateY(-12px) scale(1.15) rotate(180deg);\n";
    $menu_css .= "  box-shadow: 0 12px 28px " . esc_attr($active_color) . "80,\n";
    $menu_css .= "              0 4px 10px rgba(0, 0, 0, 0.15);\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "#" . $block_id . " .menu-item.scroll-up svg {\n";
    $menu_css .= "  width: 24px;\n";
    $menu_css .= "  height: 24px;\n";
    $menu_css .= "  stroke: #fff;\n";
    $menu_css .= "  stroke-width: 2.5;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "#" . $block_id . " .menu-item.scroll-up:hover svg {\n";
    $menu_css .= "  stroke: #fff;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "#" . $block_id . " .menu-item.scroll-up span.label { display: none; }\n\n";
    
    // Pulse animation for FAB
    $menu_css .= "#" . $block_id . " .menu-item.scroll-up::after {\n";
    $menu_css .= "  content: '';\n";
    $menu_css .= "  position: absolute;\n";
    $menu_css .= "  inset: -4px;\n";
    $menu_css .= "  border-radius: 50%;\n";
    $menu_css .= "  background: linear-gradient(135deg, " . esc_attr($active_color) . " 0%, " . esc_attr($active_color) . "cc 100%);\n";
    $menu_css .= "  opacity: 0;\n";
    $menu_css .= "  z-index: -1;\n";
    $menu_css .= "  animation: pulse-ring-" . $block_id . " 2s ease-out infinite;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "@keyframes pulse-ring-" . $block_id . " {\n";
    $menu_css .= "  0% {\n";
    $menu_css .= "    transform: scale(1);\n";
    $menu_css .= "    opacity: 0.4;\n";
    $menu_css .= "  }\n";
    $menu_css .= "  100% {\n";
    $menu_css .= "    transform: scale(1.4);\n";
    $menu_css .= "    opacity: 0;\n";
    $menu_css .= "  }\n";
    $menu_css .= "}\n\n";
    
    // Responsive adjustments
    $menu_css .= "@media (max-width: 400px) {\n";
    $menu_css .= "  #" . $block_id . " .mobile-icon-menu-wrapper {\n";
    $menu_css .= "    gap: 2px;\n";
    $menu_css .= "    padding: 8px 10px;\n";
    $menu_css .= "  }\n";
    $menu_css .= "  #" . $block_id . " .menu-item {\n";
    $menu_css .= "    padding: 8px 10px;\n";
    $menu_css .= "  }\n";
    $menu_css .= "  #" . $block_id . " .menu-item span.label {\n";
    $menu_css .= "    font-size: 8px;\n";
    $menu_css .= "  }\n";
    $menu_css .= "}\n\n";
    
    // Popup styles - now as siblings, not children
    $menu_css .= ".mobile-icon-popup#call-popup-" . $block_id . ",\n";
    $menu_css .= ".mobile-icon-popup#location-popup-" . $block_id . " {\n";
    $menu_css .= "  position: fixed;\n";
    $menu_css .= "  top: 0;\n";
    $menu_css .= "  left: 0;\n";
    $menu_css .= "  right: 0;\n";
    $menu_css .= "  bottom: 0;\n";
    $menu_css .= "  width: 100%;\n";
    $menu_css .= "  height: 100%;\n";
    $menu_css .= "  background: rgba(0,0,0,0.5);\n";
    $menu_css .= "  z-index: 9999;\n";
    $menu_css .= "  display: none;\n";
    $menu_css .= "  align-items: center;\n";
    $menu_css .= "  justify-content: center;\n";
    $menu_css .= "  padding: 20px;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= ".mobile-icon-popup#call-popup-" . $block_id . ".active,\n";
    $menu_css .= ".mobile-icon-popup#location-popup-" . $block_id . ".active {\n";
    $menu_css .= "  display: flex;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= ".mobile-icon-popup#call-popup-" . $block_id . " .popup-content,\n";
    $menu_css .= ".mobile-icon-popup#location-popup-" . $block_id . " .popup-content {\n";
    $menu_css .= "  background: #fff;\n";
    $menu_css .= "  border-radius: 16px;\n";
    $menu_css .= "  padding: 0;\n";
    $menu_css .= "  max-width: 420px;\n";
    $menu_css .= "  width: 100%;\n";
    $menu_css .= "  max-height: 85vh;\n";
    $menu_css .= "  overflow: hidden;\n";
    $menu_css .= "  position: relative;\n";
    $menu_css .= "  box-shadow: 0 20px 60px rgba(0,0,0,0.3);\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= ".mobile-icon-popup#call-popup-" . $block_id . " .popup-header,\n";
    $menu_css .= ".mobile-icon-popup#location-popup-" . $block_id . " .popup-header {\n";
    $menu_css .= "  padding: 24px 60px 24px 24px;\n";
    $menu_css .= "  border-bottom: 1px solid #f0f0f0;\n";
    $menu_css .= "  background: #fafafa;\n";
    $menu_css .= "  position: relative;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= ".mobile-icon-popup#call-popup-" . $block_id . " .popup-body,\n";
    $menu_css .= ".mobile-icon-popup#location-popup-" . $block_id . " .popup-body {\n";
    $menu_css .= "  padding: 8px;\n";
    $menu_css .= "  max-height: calc(85vh - 80px);\n";
    $menu_css .= "  overflow-y: auto;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= ".mobile-icon-popup#call-popup-" . $block_id . " .popup-close,\n";
    $menu_css .= ".mobile-icon-popup#location-popup-" . $block_id . " .popup-close {\n";
    $menu_css .= "  position: absolute;\n";
    $menu_css .= "  top: 20px;\n";
    $menu_css .= "  right: 20px;\n";
    $menu_css .= "  background: rgba(0,0,0,0.05);\n";
    $menu_css .= "  border: none;\n";
    $menu_css .= "  font-size: 20px;\n";
    $menu_css .= "  cursor: pointer;\n";
    $menu_css .= "  width: 36px;\n";
    $menu_css .= "  height: 36px;\n";
    $menu_css .= "  display: flex;\n";
    $menu_css .= "  align-items: center;\n";
    $menu_css .= "  justify-content: center;\n";
    $menu_css .= "  color: #666;\n";
    $menu_css .= "  border-radius: 50%;\n";
    $menu_css .= "  transition: all 0.2s ease;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= ".mobile-icon-popup#call-popup-" . $block_id . " .popup-close:hover,\n";
    $menu_css .= ".mobile-icon-popup#location-popup-" . $block_id . " .popup-close:hover {\n";
    $menu_css .= "  background: rgba(0,0,0,0.1);\n";
    $menu_css .= "  transform: rotate(90deg);\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= ".mobile-icon-popup#call-popup-" . $block_id . " .popup-title,\n";
    $menu_css .= ".mobile-icon-popup#location-popup-" . $block_id . " .popup-title {\n";
    $menu_css .= "  font-size: 22px;\n";
    $menu_css .= "  font-weight: 700;\n";
    $menu_css .= "  margin: 0;\n";
    $menu_css .= "  color: #1a1a1a;\n";
    $menu_css .= "}\n\n";
    
    // Accordion styles
    $menu_css .= ".mobile-icon-popup#call-popup-" . $block_id . " .location-accordion,\n";
    $menu_css .= ".mobile-icon-popup#location-popup-" . $block_id . " .location-accordion {\n";
    $menu_css .= "  border-bottom: 1px solid #e8e8e8;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= ".mobile-icon-popup#call-popup-" . $block_id . " .location-accordion:last-child,\n";
    $menu_css .= ".mobile-icon-popup#location-popup-" . $block_id . " .location-accordion:last-child {\n";
    $menu_css .= "  border-bottom: none;\n";
    $menu_css .= "}\n\n";
    
    // Single location - no accordion header, show content directly
    $menu_css .= ".mobile-icon-popup#call-popup-" . $block_id . " .location-accordion .accordion-body:first-child,\n";
    $menu_css .= ".mobile-icon-popup#location-popup-" . $block_id . " .location-accordion .accordion-body:first-child {\n";
    $menu_css .= "  border-bottom: none;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= ".mobile-icon-popup#call-popup-" . $block_id . " .accordion-header,\n";
    $menu_css .= ".mobile-icon-popup#location-popup-" . $block_id . " .accordion-header {\n";
    $menu_css .= "  display: flex;\n";
    $menu_css .= "  align-items: center;\n";
    $menu_css .= "  justify-content: space-between;\n";
    $menu_css .= "  padding: 16px;\n";
    $menu_css .= "  background: #fff;\n";
    $menu_css .= "  cursor: pointer;\n";
    $menu_css .= "  border: none;\n";
    $menu_css .= "  width: 100%;\n";
    $menu_css .= "  text-align: left;\n";
    $menu_css .= "  transition: background 0.2s ease;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= ".mobile-icon-popup#call-popup-" . $block_id . " .accordion-header:hover,\n";
    $menu_css .= ".mobile-icon-popup#location-popup-" . $block_id . " .accordion-header:hover {\n";
    $menu_css .= "  background: #f9f9f9;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= ".mobile-icon-popup#call-popup-" . $block_id . " .accordion-header.active,\n";
    $menu_css .= ".mobile-icon-popup#location-popup-" . $block_id . " .accordion-header.active {\n";
    $menu_css .= "  background: #f5f5f5;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= ".mobile-icon-popup#call-popup-" . $block_id . " .accordion-icon,\n";
    $menu_css .= ".mobile-icon-popup#location-popup-" . $block_id . " .accordion-icon {\n";
    $menu_css .= "  width: 20px;\n";
    $menu_css .= "  height: 20px;\n";
    $menu_css .= "  transition: transform 0.3s ease;\n";
    $menu_css .= "  flex-shrink: 0;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= ".mobile-icon-popup#call-popup-" . $block_id . " .accordion-header.active .accordion-icon,\n";
    $menu_css .= ".mobile-icon-popup#location-popup-" . $block_id . " .accordion-header.active .accordion-icon {\n";
    $menu_css .= "  transform: rotate(180deg);\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= ".mobile-icon-popup#call-popup-" . $block_id . " .accordion-body,\n";
    $menu_css .= ".mobile-icon-popup#location-popup-" . $block_id . " .accordion-body {\n";
    $menu_css .= "  max-height: 0;\n";
    $menu_css .= "  overflow: hidden;\n";
    $menu_css .= "  transition: max-height 0.3s ease;\n";
    $menu_css .= "  background: #fafafa;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= ".mobile-icon-popup#call-popup-" . $block_id . " .accordion-body.active,\n";
    $menu_css .= ".mobile-icon-popup#location-popup-" . $block_id . " .accordion-body.active {\n";
    $menu_css .= "  max-height: 500px;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= ".mobile-icon-popup#call-popup-" . $block_id . " .accordion-content,\n";
    $menu_css .= ".mobile-icon-popup#location-popup-" . $block_id . " .accordion-content {\n";
    $menu_css .= "  padding: 16px;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= ".mobile-icon-popup#call-popup-" . $block_id . " .location-name,\n";
    $menu_css .= ".mobile-icon-popup#location-popup-" . $block_id . " .location-name {\n";
    $menu_css .= "  font-size: 16px;\n";
    $menu_css .= "  font-weight: 600;\n";
    $menu_css .= "  margin: 0;\n";
    $menu_css .= "  color: #1a1a1a;\n";
    $menu_css .= "  flex: 1;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= ".mobile-icon-popup#call-popup-" . $block_id . " .phone-item,\n";
    $menu_css .= ".mobile-icon-popup#location-popup-" . $block_id . " .address-item {\n";
    $menu_css .= "  margin-bottom: 12px;\n";
    $menu_css .= "  padding: 12px;\n";
    $menu_css .= "  background: #fff;\n";
    $menu_css .= "  border-radius: 8px;\n";
    $menu_css .= "  border: 1px solid #e8e8e8;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= ".mobile-icon-popup#call-popup-" . $block_id . " .phone-item:last-child,\n";
    $menu_css .= ".mobile-icon-popup#location-popup-" . $block_id . " .address-item:last-child {\n";
    $menu_css .= "  margin-bottom: 0;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= ".mobile-icon-popup#call-popup-" . $block_id . " .phone-label {\n";
    $menu_css .= "  display: block;\n";
    $menu_css .= "  font-size: 11px;\n";
    $menu_css .= "  font-weight: 600;\n";
    $menu_css .= "  text-transform: uppercase;\n";
    $menu_css .= "  letter-spacing: 0.5px;\n";
    $menu_css .= "  color: #666;\n";
    $menu_css .= "  margin-bottom: 6px;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= ".mobile-icon-popup#call-popup-" . $block_id . " .phone-link {\n";
    $menu_css .= "  display: inline-flex;\n";
    $menu_css .= "  align-items: center;\n";
    $menu_css .= "  gap: 8px;\n";
    $menu_css .= "  color: " . esc_attr($active_color) . ";\n";
    $menu_css .= "  text-decoration: none;\n";
    $menu_css .= "  font-size: 16px;\n";
    $menu_css .= "  font-weight: 600;\n";
    $menu_css .= "  padding: 8px 16px;\n";
    $menu_css .= "  background: " . esc_attr($active_color) . "10;\n";
    $menu_css .= "  border-radius: 6px;\n";
    $menu_css .= "  transition: all 0.2s ease;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= ".mobile-icon-popup#call-popup-" . $block_id . " .phone-link:hover {\n";
    $menu_css .= "  background: " . esc_attr($active_color) . "20;\n";
    $menu_css .= "  transform: translateX(2px);\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= ".mobile-icon-popup#call-popup-" . $block_id . " .phone-link svg {\n";
    $menu_css .= "  width: 16px;\n";
    $menu_css .= "  height: 16px;\n";
    $menu_css .= "  stroke: currentColor;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= ".mobile-icon-popup#location-popup-" . $block_id . " .address-link {\n";
    $menu_css .= "  display: inline-flex;\n";
    $menu_css .= "  align-items: flex-start;\n";
    $menu_css .= "  gap: 8px;\n";
    $menu_css .= "  color: " . esc_attr($active_color) . ";\n";
    $menu_css .= "  text-decoration: none;\n";
    $menu_css .= "  font-size: 14px;\n";
    $menu_css .= "  line-height: 1.5;\n";
    $menu_css .= "  padding: 8px 16px;\n";
    $menu_css .= "  background: " . esc_attr($active_color) . "10;\n";
    $menu_css .= "  border-radius: 6px;\n";
    $menu_css .= "  transition: all 0.2s ease;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= ".mobile-icon-popup#location-popup-" . $block_id . " .address-link:hover {\n";
    $menu_css .= "  background: " . esc_attr($active_color) . "20;\n";
    $menu_css .= "  transform: translateX(2px);\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= ".mobile-icon-popup#location-popup-" . $block_id . " .address-link svg {\n";
    $menu_css .= "  width: 16px;\n";
    $menu_css .= "  height: 16px;\n";
    $menu_css .= "  stroke: currentColor;\n";
    $menu_css .= "  flex-shrink: 0;\n";
    $menu_css .= "  margin-top: 2px;\n";
    $menu_css .= "}\n";

    $ekwa_section_head_styles[$block_id] = $menu_css;
}
?>

<div id="<?php echo esc_attr($block_id); ?>" class="<?php echo esc_attr($class_name); ?>">
    <div class="mobile-icon-menu-wrapper">
        <!-- Call -->
        <?php if ($needs_call_popup): ?>
            <button class="menu-item call-item" data-action="show-call-popup" aria-label="Call">
        <?php else: ?>
            <a href="tel:<?php echo esc_attr($single_phone); ?>" class="menu-item call-item" aria-label="Call">
        <?php endif; ?>
            <span class="tooltip">Call Us</span>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
            </svg>
            <span class="label">Call</span>
        <?php if ($needs_call_popup): ?>
            </button>
        <?php else: ?>
            </a>
        <?php endif; ?>
        
        <!-- Appointment -->
        <a href="<?php echo esc_url($appointment_link); ?>" class="menu-item appointment-item" aria-label="Appointment"<?php echo $appointment_target; ?>>
            <span class="tooltip">Book Now</span>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                <line x1="16" y1="2" x2="16" y2="6"/>
                <line x1="8" y1="2" x2="8" y2="6"/>
                <line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
            <span class="label">Book</span>
        </a>
        
        <div class="nav-divider"></div>
        
        <!-- Scroll Up (FAB Center) -->
        <button class="menu-item scroll-up" data-action="scroll-up" aria-label="Scroll to Top">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M12 19V5M5 12l7-7 7 7"/>
            </svg>
            <span class="label">Up</span>
        </button>
        
        <div class="nav-divider"></div>
        
        <!-- Treatments -->
        <button class="menu-item treatments-item" data-action="show-treatments" aria-label="Treatments">
            <span class="tooltip">Services</span>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M19 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2z"/>
                <path d="M12 8v8M8 12h8"/>
            </svg>
            <span class="label">Services</span>
        </button>
        
        <!-- Find Us -->
        <?php if ($needs_location_popup): ?>
            <button class="menu-item findus-item" data-action="show-location-popup" aria-label="Find Us">
        <?php else: ?>
            <a href="<?php echo esc_url($single_direction_link); ?>" class="menu-item findus-item" target="_blank" aria-label="Find Us">
        <?php endif; ?>
            <span class="tooltip">Directions</span>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                <circle cx="12" cy="10" r="3"/>
            </svg>
            <span class="label">Find Us</span>
        <?php if ($needs_location_popup): ?>
            </button>
        <?php else: ?>
            </a>
        <?php endif; ?>
    </div>
</div>

<!-- Call Popup -->
<?php if ($needs_call_popup): ?>
<div class="mobile-icon-popup call-popup" id="call-popup-<?php echo esc_attr($block_id); ?>">
    <div class="popup-content">
        <div class="popup-header">
            <div class="popup-title">Call Us</div>
            <button class="popup-close" aria-label="Close">&times;</button>
        </div>
        <div class="popup-body">
            <?php 
            $location_index = 0;
            foreach ($phone_data as $location): 
                if (!empty($location['existing_phone']) || !empty($location['new_phone'])):
                    $is_first = ($location_index === 0);
                    $accordion_id = 'call-accordion-' . $location_index;
            ?>
            <div class="location-accordion">
                <?php if (count($phone_data) > 1): ?>
                <button class="accordion-header<?php echo $is_first ? ' active' : ''; ?>" data-accordion="<?php echo esc_attr($accordion_id); ?>">
                    <div class="location-name"><?php echo esc_html($location['city']); ?></div>
                    <svg class="accordion-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>
                <div class="accordion-body<?php echo $is_first ? ' active' : ''; ?>" id="<?php echo esc_attr($accordion_id); ?>">
                <?php else: ?>
                <div class="accordion-body active" id="<?php echo esc_attr($accordion_id); ?>">
                <?php endif; ?>
                    <div class="accordion-content">
                        <?php if (!empty($location['existing_phone'])): ?>
                        <div class="phone-item">
                            <span class="phone-label">Existing Patient</span>
                            <a href="tel:<?php echo esc_attr(mobile_number($location['existing_phone'])); ?>" class="phone-link">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                                </svg>
                                <?php echo esc_html($location['existing_phone']); ?>
                            </a>
                        </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($location['new_phone'])): ?>
                        <div class="phone-item">
                            <span class="phone-label">New Patient</span>
                            <a href="tel:<?php echo esc_attr(mobile_number($location['new_phone'])); ?>" class="phone-link">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                                </svg>
                                <?php echo esc_html($location['new_phone']); ?>
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php 
                $location_index++;
                endif;
            endforeach; 
            ?>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Location Popup -->
<?php if ($needs_location_popup): ?>
<div class="mobile-icon-popup location-popup" id="location-popup-<?php echo esc_attr($block_id); ?>">
    <div class="popup-content">
        <div class="popup-header">
            <div class="popup-title">Find Us</div>
            <button class="popup-close" aria-label="Close">&times;</button>
        </div>
        <div class="popup-body">
            <?php 
            $location_index = 0;
            foreach ($phone_data as $location): 
                if (!empty($location['direction_link']) && !empty($location['address'])):
                    $is_first = ($location_index === 0);
                    $accordion_id = 'location-accordion-' . $location_index;
            ?>
            <div class="location-accordion">
                <button class="accordion-header<?php echo $is_first ? ' active' : ''; ?>" data-accordion="<?php echo esc_attr($accordion_id); ?>">
                    <div class="location-name"><?php echo esc_html($location['city']); ?></div>
                    <svg class="accordion-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>
                <div class="accordion-body<?php echo $is_first ? ' active' : ''; ?>" id="<?php echo esc_attr($accordion_id); ?>">
                    <div class="accordion-content">
                        <div class="address-item">
                            <a href="<?php echo esc_url($location['direction_link']); ?>" class="address-link" target="_blank">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                    <circle cx="12" cy="10" r="3"/>
                                </svg>
                                <span><?php echo esc_html($location['address']); ?></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
                $location_index++;
                endif;
            endforeach; 
            ?>
        </div>
    </div>
</div>
<?php endif; ?>

<?php
// Output JavaScript using base64 to completely bypass WordPress filters
$block_id_json = json_encode($block_id);

$script_js = "(function() {
    var blockId = {$block_id_json};
    var menuWrapper = document.getElementById(blockId);
    if (!menuWrapper) return;
    
    // Scroll up functionality
    var scrollUpBtn = menuWrapper.querySelector('[data-action=\"scroll-up\"]');
    if (scrollUpBtn) {
        scrollUpBtn.addEventListener('click', function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }
    
    // Treatments functionality
    var treatmentsBtn = menuWrapper.querySelector('[data-action=\"show-treatments\"]');
    if (treatmentsBtn) {
        treatmentsBtn.addEventListener('click', function() {
            // Find the main menu block
            var mainMenuBlock = document.querySelector('.ekwa-main-menu');
            if (!mainMenuBlock) {
                alert('Main Menu block not found.\\n\\nTo set up Treatments menu:\\n1. Add the EKWA Main Menu block to your header\\n2. Go to Appearance > Menus\\n3. Add a CSS class \"treatments\" to your Treatments menu item\\n   (Enable CSS Classes in Screen Options if not visible)');
                return;
            }
            
            // Check if treatments menu item exists
            var treatmentsItem = mainMenuBlock.querySelector('.treatments');
            if (!treatmentsItem) {
                alert('No menu item with \"treatments\" class found.\\n\\nTo assign treatments menu:\\n1. Go to Appearance > Menus\\n2. Click \"Screen Options\" at the top right\\n3. Check \"CSS Classes\" checkbox\\n4. Find your Treatments menu item\\n5. Add \"treatments\" in the CSS Classes field\\n6. Save Menu');
                return;
            }
            
            // Check if it has a submenu
            var submenu = treatmentsItem.querySelector('ul');
            if (!submenu || submenu.children.length === 0) {
                alert('The treatments menu item has no submenu items.\\n\\nTo add submenu items:\\n1. Go to Appearance > Menus\\n2. Add child pages under your Treatments menu item\\n3. Save Menu');
                return;
            }
            
            // Get the breakpoint from main menu
            var breakpoint = parseInt(mainMenuBlock.getAttribute('data-breakpoint')) || 1154;
            var isMobile = window.innerWidth <= breakpoint;
            
            if (isMobile) {
                // Mobile: Find and trigger the mobile menu drawer
                var menuId = mainMenuBlock.querySelector('.main-menu-wrapper');
                if (menuId) {
                    var menuIdAttr = menuId.getAttribute('id');
                    var trigger = document.getElementById('trigger-' + menuIdAttr);
                    var overlay = document.getElementById('overlay-' + menuIdAttr);
                    
                    if (trigger && overlay) {
                        // Open the mobile menu
                        overlay.classList.add('active');
                        document.body.style.overflow = 'hidden';
                        
                        // Find and click the treatments panel arrow after a short delay
                        setTimeout(function() {
                            var panelsContainer = document.getElementById('panels-' + menuIdAttr);
                            if (panelsContainer) {
                                // Find the treatments item in mobile menu and click its arrow
                                var mobileMenuItems = panelsContainer.querySelectorAll('.mobile-nav-menu > li');
                                mobileMenuItems.forEach(function(item) {
                                    if (item.classList.contains('treatments')) {
                                        var arrowBtn = item.querySelector('.submenu-arrow');
                                        if (arrowBtn) {
                                            arrowBtn.click();
                                        }
                                    }
                                });
                            }
                        }, 100);
                    }
                }
            } else {
                // Desktop: Show submenu with hover effect
                treatmentsItem.classList.add('active');
                submenu.style.visibility = 'visible';
                submenu.style.opacity = '1';
                submenu.style.width = 'auto';
                submenu.style.height = 'auto';
                submenu.style.overflow = 'visible';
                
                // Scroll to the menu
                treatmentsItem.scrollIntoView({ behavior: 'smooth', block: 'center' });
                
                // Close after 5 seconds
                setTimeout(function() {
                    treatmentsItem.classList.remove('active');
                    submenu.style.visibility = '';
                    submenu.style.opacity = '';
                    submenu.style.width = '';
                    submenu.style.height = '';
                    submenu.style.overflow = '';
                }, 5000);
            }
        });
    }
    
    // Popup functionality
    var callPopupBtn = menuWrapper.querySelector('[data-action=\"show-call-popup\"]');
    var locationPopupBtn = menuWrapper.querySelector('[data-action=\"show-location-popup\"]');
    var callPopup = document.getElementById('call-popup-' + blockId);
    var locationPopup = document.getElementById('location-popup-' + blockId);
    
    function closePopup(popup) {
        if (popup) {
            popup.classList.remove('active');
            document.body.style.overflow = '';
        }
    }
    
    function openPopup(popup) {
        if (popup) {
            popup.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    }
    
    if (callPopupBtn && callPopup) {
        callPopupBtn.addEventListener('click', function() {
            openPopup(callPopup);
        });
        
        var callCloseBtn = callPopup.querySelector('.popup-close');
        if (callCloseBtn) {
            callCloseBtn.addEventListener('click', function() {
                closePopup(callPopup);
            });
        }
        
        callPopup.addEventListener('click', function(e) {
            if (e.target === callPopup) {
                closePopup(callPopup);
            }
        });
    }
    
    if (locationPopupBtn && locationPopup) {
        locationPopupBtn.addEventListener('click', function() {
            openPopup(locationPopup);
        });
        
        var locationCloseBtn = locationPopup.querySelector('.popup-close');
        if (locationCloseBtn) {
            locationCloseBtn.addEventListener('click', function() {
                closePopup(locationPopup);
            });
        }
        
        locationPopup.addEventListener('click', function(e) {
            if (e.target === locationPopup) {
                closePopup(locationPopup);
            }
        });
    }
    
    // Accordion functionality for both popups
    function setupAccordions(popup) {
        if (!popup) return;
        
        var accordionHeaders = popup.querySelectorAll('.accordion-header');
        accordionHeaders.forEach(function(header) {
            header.addEventListener('click', function() {
                var targetId = this.getAttribute('data-accordion');
                var targetBody = document.getElementById(targetId);
                var isActive = this.classList.contains('active');
                
                // Close all accordions in this popup
                var allHeaders = popup.querySelectorAll('.accordion-header');
                var allBodies = popup.querySelectorAll('.accordion-body');
                allHeaders.forEach(function(h) { h.classList.remove('active'); });
                allBodies.forEach(function(b) { b.classList.remove('active'); });
                
                // Open clicked accordion if it wasn't active
                if (!isActive) {
                    this.classList.add('active');
                    if (targetBody) {
                        targetBody.classList.add('active');
                    }
                }
            });
        });
    }
    
    setupAccordions(callPopup);
    setupAccordions(locationPopup);
})();";

// Encode to base64 to bypass all WordPress filters
$encoded = base64_encode($script_js);
?>
<script id="<?php echo esc_attr($block_id); ?>-script">
eval(atob('<?php echo $encoded; ?>'));
</script>

<?php if ($is_preview): ?>
<style>
    #<?php echo esc_attr($block_id); ?> {
        display: block !important;
        position: relative !important;
        margin: 20px auto;
        width: fit-content;
    }
    
    #<?php echo esc_attr($block_id); ?> .mobile-icon-menu-wrapper {
        display: flex !important;
        align-items: center;
        gap: 6px;
        padding: 10px 16px;
        background: <?php echo esc_attr($menu_bg); ?>d9;
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
        border-radius: 24px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12),
                    0 2px 8px rgba(0, 0, 0, 0.08),
                    inset 0 0 0 1px rgba(255, 255, 255, 0.5);
        border: 1px solid rgba(0, 0, 0, 0.06);
    }
    
    #<?php echo esc_attr($block_id); ?> .menu-item {
        display: flex !important;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 4px;
        text-decoration: none;
        color: <?php echo esc_attr($text_color); ?> !important;
        padding: 10px 14px;
        border-radius: 16px;
        position: relative;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        overflow: hidden;
        cursor: pointer;
        border: none;
        background: none;
    }
    
    #<?php echo esc_attr($block_id); ?> .menu-item::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, <?php echo esc_attr($active_color); ?> 0%, <?php echo esc_attr($active_color); ?>cc 100%);
        opacity: 0;
        border-radius: 16px;
        transition: opacity 0.3s ease;
    }
    
    #<?php echo esc_attr($block_id); ?> .menu-item:hover::before {
        opacity: 1;
    }
    
    #<?php echo esc_attr($block_id); ?> .menu-item:hover {
        transform: translateY(-8px) scale(1.1);
        color: #fff !important;
    }
    
    #<?php echo esc_attr($block_id); ?> .menu-item.call-item::before {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }
    
    #<?php echo esc_attr($block_id); ?> .menu-item.appointment-item::before {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    }
    
    #<?php echo esc_attr($block_id); ?> .menu-item.treatments-item::before {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
    }
    
    #<?php echo esc_attr($block_id); ?> .menu-item.findus-item::before {
        background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%);
    }
    
    #<?php echo esc_attr($block_id); ?> .menu-item svg {
        width: 22px;
        height: 22px;
        stroke: <?php echo esc_attr($icon_color); ?> !important;
        stroke-width: 1.8;
        fill: none !important;
        position: relative;
        z-index: 1;
        transition: all 0.3s ease;
    }
    
    #<?php echo esc_attr($block_id); ?> .menu-item:hover svg {
        stroke: #fff !important;
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
    }
    
    #<?php echo esc_attr($block_id); ?> .menu-item span.label {
        font-size: 9px;
        font-weight: 600;
        letter-spacing: 0.3px;
        text-transform: uppercase;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        position: relative;
        z-index: 1;
        transition: all 0.3s ease;
        white-space: nowrap;
    }
    
    #<?php echo esc_attr($block_id); ?> .menu-item .tooltip {
        position: absolute;
        top: -36px;
        left: 50%;
        transform: translateX(-50%) scale(0.8);
        background: #1f2937;
        color: #fff;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 500;
        letter-spacing: 0.3px;
        white-space: nowrap;
        opacity: 0;
        pointer-events: none;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    
    #<?php echo esc_attr($block_id); ?> .menu-item .tooltip::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 50%;
        transform: translateX(-50%);
        border-width: 5px 5px 0;
        border-style: solid;
        border-color: #1f2937 transparent transparent;
    }
    
    #<?php echo esc_attr($block_id); ?> .menu-item:hover .tooltip {
        opacity: 1;
        transform: translateX(-50%) scale(1);
    }
    
    #<?php echo esc_attr($block_id); ?> .nav-divider {
        width: 1px;
        height: 32px;
        background: linear-gradient(to bottom, transparent, rgba(0, 0, 0, 0.15), transparent);
        margin: 0 4px;
    }
    
    #<?php echo esc_attr($block_id); ?> .menu-item.scroll-up {
        background: linear-gradient(135deg, <?php echo esc_attr($active_color); ?> 0%, <?php echo esc_attr($active_color); ?>cc 100%);
        color: #fff;
        width: 52px;
        height: 52px;
        border-radius: 50%;
        padding: 0;
        margin: -10px 4px;
        box-shadow: 0 4px 16px <?php echo esc_attr($active_color); ?>66,
                    0 2px 6px rgba(0, 0, 0, 0.1);
    }
    
    #<?php echo esc_attr($block_id); ?> .menu-item.scroll-up::before {
        display: none;
    }
    
    #<?php echo esc_attr($block_id); ?> .menu-item.scroll-up:hover {
        transform: translateY(-12px) scale(1.15) rotate(180deg);
        box-shadow: 0 12px 28px <?php echo esc_attr($active_color); ?>80,
                    0 4px 10px rgba(0, 0, 0, 0.15);
    }
    
    #<?php echo esc_attr($block_id); ?> .menu-item.scroll-up svg {
        width: 24px;
        height: 24px;
        stroke: #fff !important;
        stroke-width: 2.5;
    }
    
    #<?php echo esc_attr($block_id); ?> .menu-item.scroll-up span.label {
        display: none;
    }
    
    @media (max-width: 400px) {
        #<?php echo esc_attr($block_id); ?> .mobile-icon-menu-wrapper {
            gap: 2px;
            padding: 8px 10px;
        }
        #<?php echo esc_attr($block_id); ?> .menu-item {
            padding: 8px 10px;
        }
        #<?php echo esc_attr($block_id); ?> .menu-item span.label {
            font-size: 8px;
        }
    }
    
    #<?php echo esc_attr($block_id); ?> .mobile-icon-popup {
        display: none !important;
    }
</style>
<?php endif; ?>
