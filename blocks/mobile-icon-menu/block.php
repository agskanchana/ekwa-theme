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

// Determine if we need a popup for call
$total_phones = 0;
foreach ($phone_data as $data) {
    if (!empty($data['existing_phone'])) $total_phones++;
    if (!empty($data['new_phone'])) $total_phones++;
}
$needs_call_popup = $total_phones > 1;

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
    
    $menu_css .= "#" . $block_id . " {\n";
    $menu_css .= "  display: none;\n";
    $menu_css .= "  position: fixed;\n";
    $menu_css .= "  bottom: 0;\n";
    $menu_css .= "  left: 0;\n";
    $menu_css .= "  right: 0;\n";
    $menu_css .= "  background: " . esc_attr($menu_bg) . ";\n";
    $menu_css .= "  box-shadow: 0 -2px 10px rgba(0,0,0,0.1);\n";
    $menu_css .= "  z-index: 9998;\n";
    $menu_css .= "  padding: 10px 0;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "@media (max-width: " . intval($breakpoint) . "px) {\n";
    $menu_css .= "  #" . $block_id . " { display: block; }\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "#" . $block_id . " .mobile-icon-menu-wrapper {\n";
    $menu_css .= "  display: flex;\n";
    $menu_css .= "  justify-content: space-around;\n";
    $menu_css .= "  align-items: center;\n";
    $menu_css .= "  max-width: 100%;\n";
    $menu_css .= "  margin: 0 auto;\n";
    $menu_css .= "  padding: 0 10px;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "#" . $block_id . " .menu-item {\n";
    $menu_css .= "  display: flex;\n";
    $menu_css .= "  flex-direction: column;\n";
    $menu_css .= "  align-items: center;\n";
    $menu_css .= "  justify-content: center;\n";
    $menu_css .= "  text-decoration: none;\n";
    $menu_css .= "  color: " . esc_attr($text_color) . ";\n";
    $menu_css .= "  font-size: 10px;\n";
    $menu_css .= "  font-weight: 500;\n";
    $menu_css .= "  letter-spacing: 0.3px;\n";
    $menu_css .= "  cursor: pointer;\n";
    $menu_css .= "  padding: 8px 6px;\n";
    $menu_css .= "  border: none;\n";
    $menu_css .= "  background: none;\n";
    $menu_css .= "  transition: all 0.25s ease;\n";
    $menu_css .= "  position: relative;\n";
    $menu_css .= "  flex: 1;\n";
    $menu_css .= "  min-width: 0;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "#" . $block_id . " .menu-item:active,\n";
    $menu_css .= "#" . $block_id . " .menu-item.active {\n";
    $menu_css .= "  color: " . esc_attr($active_color) . ";\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "#" . $block_id . " .menu-item::before {\n";
    $menu_css .= "  content: '';\n";
    $menu_css .= "  position: absolute;\n";
    $menu_css .= "  top: 0;\n";
    $menu_css .= "  left: 50%;\n";
    $menu_css .= "  transform: translateX(-50%) scaleX(0);\n";
    $menu_css .= "  width: 80%;\n";
    $menu_css .= "  height: 3px;\n";
    $menu_css .= "  background: " . esc_attr($active_color) . ";\n";
    $menu_css .= "  border-radius: 0 0 3px 3px;\n";
    $menu_css .= "  transition: transform 0.25s ease;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "#" . $block_id . " .menu-item:active::before,\n";
    $menu_css .= "#" . $block_id . " .menu-item.active::before {\n";
    $menu_css .= "  transform: translateX(-50%) scaleX(1);\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "#" . $block_id . " .menu-item svg {\n";
    $menu_css .= "  width: 26px;\n";
    $menu_css .= "  height: 26px;\n";
    $menu_css .= "  stroke: " . esc_attr($icon_color) . ";\n";
    $menu_css .= "  fill: none;\n";
    $menu_css .= "  stroke-width: 1.5;\n";
    $menu_css .= "  stroke-linecap: round;\n";
    $menu_css .= "  stroke-linejoin: round;\n";
    $menu_css .= "  margin-bottom: 6px;\n";
    $menu_css .= "  transition: all 0.25s ease;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "#" . $block_id . " .menu-item:active svg,\n";
    $menu_css .= "#" . $block_id . " .menu-item.active svg {\n";
    $menu_css .= "  stroke: " . esc_attr($active_color) . ";\n";
    $menu_css .= "  transform: scale(1.1);\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "#" . $block_id . " .menu-item span {\n";
    $menu_css .= "  display: block;\n";
    $menu_css .= "  text-transform: uppercase;\n";
    $menu_css .= "  white-space: nowrap;\n";
    $menu_css .= "  overflow: hidden;\n";
    $menu_css .= "  text-overflow: ellipsis;\n";
    $menu_css .= "  max-width: 100%;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "#" . $block_id . " .menu-item.scroll-up span { display: none; }\n\n";
    
    // Popup styles
    $menu_css .= "#" . $block_id . " .mobile-icon-popup {\n";
    $menu_css .= "  position: fixed;\n";
    $menu_css .= "  top: 0;\n";
    $menu_css .= "  left: 0;\n";
    $menu_css .= "  right: 0;\n";
    $menu_css .= "  bottom: 0;\n";
    $menu_css .= "  background: rgba(0,0,0,0.5);\n";
    $menu_css .= "  z-index: 9999;\n";
    $menu_css .= "  display: none;\n";
    $menu_css .= "  align-items: center;\n";
    $menu_css .= "  justify-content: center;\n";
    $menu_css .= "  padding: 20px;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "#" . $block_id . " .mobile-icon-popup.active {\n";
    $menu_css .= "  display: flex;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "#" . $block_id . " .popup-content {\n";
    $menu_css .= "  background: #fff;\n";
    $menu_css .= "  border-radius: 10px;\n";
    $menu_css .= "  padding: 20px;\n";
    $menu_css .= "  max-width: 400px;\n";
    $menu_css .= "  width: 100%;\n";
    $menu_css .= "  max-height: 80vh;\n";
    $menu_css .= "  overflow-y: auto;\n";
    $menu_css .= "  position: relative;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "#" . $block_id . " .popup-close {\n";
    $menu_css .= "  position: absolute;\n";
    $menu_css .= "  top: 10px;\n";
    $menu_css .= "  right: 10px;\n";
    $menu_css .= "  background: none;\n";
    $menu_css .= "  border: none;\n";
    $menu_css .= "  font-size: 24px;\n";
    $menu_css .= "  cursor: pointer;\n";
    $menu_css .= "  width: 30px;\n";
    $menu_css .= "  height: 30px;\n";
    $menu_css .= "  display: flex;\n";
    $menu_css .= "  align-items: center;\n";
    $menu_css .= "  justify-content: center;\n";
    $menu_css .= "  color: #666;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "#" . $block_id . " .popup-title {\n";
    $menu_css .= "  font-size: 20px;\n";
    $menu_css .= "  font-weight: bold;\n";
    $menu_css .= "  margin-bottom: 20px;\n";
    $menu_css .= "  padding-right: 30px;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "#" . $block_id . " .location-group {\n";
    $menu_css .= "  margin-bottom: 20px;\n";
    $menu_css .= "  padding-bottom: 20px;\n";
    $menu_css .= "  border-bottom: 1px solid #e0e0e0;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "#" . $block_id . " .location-group:last-child {\n";
    $menu_css .= "  border-bottom: none;\n";
    $menu_css .= "  margin-bottom: 0;\n";
    $menu_css .= "  padding-bottom: 0;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "#" . $block_id . " .location-name {\n";
    $menu_css .= "  font-size: 16px;\n";
    $menu_css .= "  font-weight: bold;\n";
    $menu_css .= "  margin-bottom: 10px;\n";
    $menu_css .= "  color: #333;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "#" . $block_id . " .phone-item,\n";
    $menu_css .= "#" . $block_id . " .address-item {\n";
    $menu_css .= "  margin-bottom: 8px;\n";
    $menu_css .= "  display: flex;\n";
    $menu_css .= "  align-items: center;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "#" . $block_id . " .phone-label,\n";
    $menu_css .= "#" . $block_id . " .address-label {\n";
    $menu_css .= "  font-weight: 600;\n";
    $menu_css .= "  margin-right: 8px;\n";
    $menu_css .= "  color: #666;\n";
    $menu_css .= "  min-width: 110px;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "#" . $block_id . " .phone-link,\n";
    $menu_css .= "#" . $block_id . " .address-link {\n";
    $menu_css .= "  color: " . esc_attr($active_color) . ";\n";
    $menu_css .= "  text-decoration: none;\n";
    $menu_css .= "  word-break: break-word;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "#" . $block_id . " .phone-link:hover,\n";
    $menu_css .= "#" . $block_id . " .address-link:hover {\n";
    $menu_css .= "  text-decoration: underline;\n";
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
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
            </svg>
            <span>Call</span>
        <?php if ($needs_call_popup): ?>
            </button>
        <?php else: ?>
            </a>
        <?php endif; ?>
        
        <!-- Appointment -->
        <a href="<?php echo esc_url($appointment_link); ?>" class="menu-item appointment-item" aria-label="Appointment"<?php echo $appointment_target; ?>>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                <line x1="16" y1="2" x2="16" y2="6"/>
                <line x1="8" y1="2" x2="8" y2="6"/>
                <line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
            <span>Appointments</span>
        </a>
        
        <!-- Scroll Up -->
        <button class="menu-item scroll-up" data-action="scroll-up" aria-label="Scroll to Top">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/>
                <polyline points="16 12 12 8 8 12"/>
                <line x1="12" y1="16" x2="12" y2="8"/>
            </svg>
            <span>Up</span>
        </button>
        
        <!-- Treatments -->
        <button class="menu-item treatments-item" data-action="show-treatments" aria-label="Treatments">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
            </svg>
            <span>Services</span>
        </button>
        
        <!-- Find Us -->
        <?php if ($needs_location_popup): ?>
            <button class="menu-item findus-item" data-action="show-location-popup" aria-label="Find Us">
        <?php else: ?>
            <a href="<?php echo esc_url($single_direction_link); ?>" class="menu-item findus-item" target="_blank" aria-label="Find Us">
        <?php endif; ?>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                <circle cx="12" cy="10" r="3"/>
            </svg>
            <span>Find Us</span>
        <?php if ($needs_location_popup): ?>
            </button>
        <?php else: ?>
            </a>
        <?php endif; ?>
    </div>
    
    <!-- Call Popup -->
    <?php if ($needs_call_popup): ?>
    <div class="mobile-icon-popup call-popup" id="call-popup-<?php echo esc_attr($block_id); ?>">
        <div class="popup-content">
            <button class="popup-close" aria-label="Close">&times;</button>
            <div class="popup-title">Call Us</div>
            <?php foreach ($phone_data as $location): ?>
                <?php if (!empty($location['existing_phone']) || !empty($location['new_phone'])): ?>
                <div class="location-group">
                    <?php if ($has_multiple_locations): ?>
                        <div class="location-name"><?php echo esc_html($location['city']); ?></div>
                    <?php endif; ?>
                    
                    <?php if (!empty($location['existing_phone'])): ?>
                    <div class="phone-item">
                        <span class="phone-label">Existing Patient:</span>
                        <a href="tel:<?php echo esc_attr(mobile_number($location['existing_phone'])); ?>" class="phone-link">
                            <?php echo esc_html($location['existing_phone']); ?>
                        </a>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($location['new_phone'])): ?>
                    <div class="phone-item">
                        <span class="phone-label">New Patient:</span>
                        <a href="tel:<?php echo esc_attr(mobile_number($location['new_phone'])); ?>" class="phone-link">
                            <?php echo esc_html($location['new_phone']); ?>
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- Location Popup -->
    <?php if ($needs_location_popup): ?>
    <div class="mobile-icon-popup location-popup" id="location-popup-<?php echo esc_attr($block_id); ?>">
        <div class="popup-content">
            <button class="popup-close" aria-label="Close">&times;</button>
            <div class="popup-title">Find Us</div>
            <?php foreach ($phone_data as $location): ?>
                <?php if (!empty($location['direction_link']) && !empty($location['address'])): ?>
                <div class="location-group">
                    <div class="location-name"><?php echo esc_html($location['city']); ?></div>
                    <div class="address-item">
                        <a href="<?php echo esc_url($location['direction_link']); ?>" class="address-link" target="_blank">
                            <?php echo esc_html($location['address']); ?>
                        </a>
                    </div>
                </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

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
        margin: 20px 0;
        border: 2px dashed #ccc;
        border-radius: 5px;
        background: <?php echo esc_attr($menu_bg); ?> !important;
        box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
        padding: 10px 0 !important;
    }
    
    #<?php echo esc_attr($block_id); ?> .mobile-icon-menu-wrapper {
        display: flex !important;
        justify-content: space-around;
        align-items: center;
        /* padding: 0 10px; */
    }
    
    #<?php echo esc_attr($block_id); ?> .menu-item {
        display: flex !important;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        color: <?php echo esc_attr($text_color); ?> !important;
        font-size: 10px;
        font-weight: 500;
        letter-spacing: 0.3px;
        cursor: pointer;
        padding: 8px 6px;
        border: none;
        background: none;
        transition: all 0.25s ease;
        position: relative;
        flex: 1;
        min-width: 0;
    }
    
    #<?php echo esc_attr($block_id); ?> .menu-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 80%;
        height: 3px;
        background: <?php echo esc_attr($active_color); ?>;
        border-radius: 0 0 3px 3px;
        opacity: 0;
    }
    
    #<?php echo esc_attr($block_id); ?> .menu-item:hover::before {
        opacity: 1;
    }
    
    #<?php echo esc_attr($block_id); ?> .menu-item svg {
        width: 26px;
        height: 26px;
        stroke: <?php echo esc_attr($icon_color); ?> !important;
        fill: none !important;
        stroke-width: 1.5;
        stroke-linecap: round;
        stroke-linejoin: round;
        margin-bottom: 6px;
        transition: all 0.25s ease;
    }
    
    #<?php echo esc_attr($block_id); ?> .menu-item:hover {
        color: <?php echo esc_attr($active_color); ?> !important;
    }
    
    #<?php echo esc_attr($block_id); ?> .menu-item:hover svg {
        stroke: <?php echo esc_attr($active_color); ?> !important;
        transform: scale(1.1);
    }
    
    #<?php echo esc_attr($block_id); ?> .menu-item span {
        display: block;
        text-transform: uppercase;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 100%;
    }
    
    #<?php echo esc_attr($block_id); ?> .menu-item.scroll-up span {
        display: none;
    }
    
    #<?php echo esc_attr($block_id); ?> .mobile-icon-popup {
        display: none !important;
    }
</style>
<?php endif; ?>
