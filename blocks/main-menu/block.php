<?php
/**
 * EKWA Main Menu Block Template
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

// Create id attribute allowing for custom "anchor" value.
$block_id = 'ekwa-main-menu-' . $block['id'];
if (!empty($block['anchor'])) {
    $block_id = $block['anchor'];
}

// Create class attribute allowing for custom "className"
$class_name = 'ekwa-main-menu';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}

// Get ACF fields with defaults
$breakpoint = get_field('breakpoint') ?: 1154;
$show_icons = get_field('show_icons') !== false;
$two_columns = get_field('two_columns') ?: false;
$sub_menu_class = get_field('sub_menu_class') ?: '';

// Desktop styling
$link_bg = get_field('background') ?: 'none';
$text_color = get_field('text_color') ?: 'inherit';
$link_bg_hover = get_field('hover_background') ?: 'none';
$hover_text_color = get_field('hover_text_color') ?: 'inherit';
$link_padding_x = get_field('padding') ?: 0;
$link_padding_y = get_field('padding_y') ?: 0;
$gap = get_field('gap') ?: 0;

// Submenu styling
$sub_menu_width = get_field('width') ?: 200;
$sub_menu_background = get_field('sub_menu_background') ?: '#fff';
$sub_menu_link_background = get_field('sub_menu_link_background') ?: 'none';
$sub_menu_link_text_color = get_field('sub_menu_link_text_color') ?: 'inherit';
$sub_menu_link_background_hover = get_field('sub_menu_link_background_hover') ?: 'none';
$submenu_link_text_color_hover = get_field('submenu_link_text_color_hover') ?: 'inherit';
$separator = get_field('separator') ?: 'rgba(0, 0, 0, 0.2)';

// Mobile menu styling
$mobile_trigger_bg = get_field('mobile_trigger_bg') ?: '#1e73be';
$mobile_trigger_color = get_field('mobile_trigger_color') ?: '#000000';

$two_cols_menu_class = $two_columns ? 'two-columns-menu' : '';
$show_icons_class = $show_icons ? 'show-icons' : '';
$two_cols_menu_width = $sub_menu_width * 2;

// Generate unique menu ID for mmenu
$menu_id = 'menu-' . $block['id'];

// Collect custom CSS for consolidated output
if (!is_admin() && !$is_preview) {
    global $ekwa_section_head_styles;

    if (!isset($ekwa_section_head_styles)) {
        $ekwa_section_head_styles = [];
    }

    $menu_css = "/* Main Menu Block Styles for #" . $block_id . " */\n";
    
    // Base styles
    $menu_css .= "#" . $block_id . " {\n";
    $menu_css .= "  display: block;\n";
    $menu_css .= "}\n\n";
    
    // Mobile trigger buttons
    $menu_css .= "#" . $block_id . " .mobile-menu-triggers {\n";
    $menu_css .= "  display: flex;\n";
    $menu_css .= "  gap: 15px;\n";
    $menu_css .= "  align-items: center;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "@media (min-width: " . (intval($breakpoint) + 1) . "px) {\n";
    $menu_css .= "  #" . $block_id . " .mobile-menu-triggers { display: none; }\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "#" . $block_id . " .mobile-menu-trigger,\n";
    $menu_css .= "#" . $block_id . " .search-icon {\n";
    $menu_css .= "  background: none;\n";
    $menu_css .= "  border: none;\n";
    $menu_css .= "  padding: 0;\n";
    $menu_css .= "  cursor: pointer;\n";
    $menu_css .= "  width: 30px;\n";
    $menu_css .= "  height: 30px;\n";
    $menu_css .= "  display: flex;\n";
    $menu_css .= "  align-items: center;\n";
    $menu_css .= "  justify-content: center;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "#" . $block_id . " .mobile-menu-trigger svg,\n";
    $menu_css .= "#" . $block_id . " .search-icon svg {\n";
    $menu_css .= "  width: 25px;\n";
    $menu_css .= "  height: 25px;\n";
    $menu_css .= "  fill: " . esc_attr($mobile_trigger_color) . " !important;\n";
    $menu_css .= "  display: block;\n";
    $menu_css .= "}\n\n";
    
    // Desktop menu wrapper
    $menu_css .= "#" . $block_id . " .main-menu-wrapper {\n";
    $menu_css .= "  display: flex;\n";
    $menu_css .= "  gap: 0.5em;\n";
    $menu_css .= "  flex-wrap: wrap;\n";
    $menu_css .= "  align-items: center;\n";
    $menu_css .= "  position: relative;\n";
    if ($text_color) {
        $menu_css .= "  color: " . esc_attr($text_color) . ";\n";
    }
    $menu_css .= "}\n\n";
    
    $menu_css .= "#" . $block_id . " .main-menu-wrapper .menu:only-child { flex-grow: 1; }\n\n";
    
    $menu_css .= "#" . $block_id . " .main-menu-wrapper .menu {\n";
    $menu_css .= "  display: flex;\n";
    $menu_css .= "  flex-wrap: wrap;\n";
    $menu_css .= "  flex-direction: row;\n";
    $menu_css .= "  justify-content: flex-start;\n";
    $menu_css .= "  align-items: center;\n";
    $menu_css .= "  gap: " . intval($gap) . "px;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "#" . $block_id . " .main-menu-wrapper ul { list-style: none; padding: 0; margin: 0; }\n";
    $menu_css .= "#" . $block_id . " .main-menu-wrapper ul li { display: flex; align-items: center; position: relative; }\n";
    $menu_css .= "#" . $block_id . " .main-menu-wrapper ul li a:hover,\n";
    $menu_css .= "#" . $block_id . " .main-menu-wrapper ul li a { text-decoration: none; }\n\n";
    
    // Submenu styles
    $menu_css .= "#" . $block_id . " .main-menu-wrapper ul li ul {\n";
    $menu_css .= "  background-color: " . esc_attr($sub_menu_background) . ";\n";
    $menu_css .= "  border: 1px solid rgba(0,0,0,.15);\n";
    $menu_css .= "  position: absolute;\n";
    $menu_css .= "  z-index: 2;\n";
    $menu_css .= "  display: flex;\n";
    $menu_css .= "  flex-direction: column;\n";
    $menu_css .= "  align-items: normal;\n";
    $menu_css .= "  opacity: 0;\n";
    $menu_css .= "  transition: opacity .1s linear;\n";
    $menu_css .= "  visibility: hidden;\n";
    $menu_css .= "  width: 0;\n";
    $menu_css .= "  height: 0;\n";
    $menu_css .= "  overflow: hidden;\n";
    $menu_css .= "  left: -1px;\n";
    $menu_css .= "  top: 100%;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "#" . $block_id . " .main-menu-wrapper ul li ul li { border-bottom: 1px solid " . esc_attr($separator) . "; }\n\n";
    
    $menu_css .= "#" . $block_id . " .main-menu-wrapper ul li:hover > ul {\n";
    $menu_css .= "  visibility: visible;\n";
    $menu_css .= "  overflow: visible;\n";
    $menu_css .= "  opacity: 1;\n";
    $menu_css .= "  width: auto;\n";
    $menu_css .= "  height: auto;\n";
    $menu_css .= "  min-width: " . intval($sub_menu_width) . "px;\n";
    $menu_css .= "}\n\n";
    
    // Two column submenu
    if ($two_columns) {
        $submenu_selector = $sub_menu_class ? 
            "#" . $block_id . " .main-menu-wrapper.two-columns-menu > ul > li." . esc_attr($sub_menu_class) . " > ul" :
            "#" . $block_id . " .main-menu-wrapper.two-columns-menu > ul > li > ul";
            
        $menu_css .= $submenu_selector . " { flex-direction: row; flex-wrap: wrap; }\n";
        $menu_css .= $submenu_selector . " > li { max-width: 50%; flex: 0 0 50%; }\n";
        
        $hover_selector = $sub_menu_class ?
            "#" . $block_id . " .main-menu-wrapper.two-columns-menu > ul > li." . esc_attr($sub_menu_class) . ":hover > ul" :
            "#" . $block_id . " .main-menu-wrapper.two-columns-menu > ul > li:hover > ul";
            
        $menu_css .= $hover_selector . " { min-width: " . intval($two_cols_menu_width) . "px; }\n\n";
    }
    
    // Submenu links
    $menu_css .= "#" . $block_id . " .main-menu-wrapper ul li ul li a {\n";
    $menu_css .= "  display: flex;\n";
    $menu_css .= "  flex-grow: 1;\n";
    $menu_css .= "  padding: .5em 1em;\n";
    $menu_css .= "  align-items: center;\n";
    $menu_css .= "  background: " . esc_attr($sub_menu_link_background) . ";\n";
    $menu_css .= "  color: " . esc_attr($sub_menu_link_text_color) . ";\n";
    $menu_css .= "  transition: all 300ms;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "#" . $block_id . " .main-menu-wrapper ul li ul li a:hover,\n";
    $menu_css .= "#" . $block_id . " .main-menu-wrapper ul li ul li.current_page_item > a,\n";
    $menu_css .= "#" . $block_id . " .main-menu-wrapper ul li ul li.current_page_ancestor > a {\n";
    $menu_css .= "  background: " . esc_attr($sub_menu_link_background_hover) . ";\n";
    $menu_css .= "  color: " . esc_attr($submenu_link_text_color_hover) . ";\n";
    $menu_css .= "}\n\n";
    
    // Dropdown icons
    if ($show_icons) {
        $menu_css .= "#" . $block_id . " .main-menu-wrapper.show-icons > ul > li.menu-item-has-children > a::after {\n";
        $menu_css .= "  content: \"\\f107\";\n";
        $menu_css .= "  font-family: \"Font Awesome 5 Free\";\n";
        $menu_css .= "  font-weight: 900;\n";
        $menu_css .= "  margin-left: 2px;\n";
        $menu_css .= "}\n\n";
        
        $menu_css .= "#" . $block_id . " .main-menu-wrapper.show-icons > ul > li > ul > li.menu-item-has-children > a::after {\n";
        $menu_css .= "  content: \"\\f105\";\n";
        $menu_css .= "  font-family: \"Font Awesome 5 Free\";\n";
        $menu_css .= "  font-weight: 900;\n";
        $menu_css .= "  margin-left: 2px;\n";
        $menu_css .= "}\n\n";
    }
    
    // Third level submenu
    $menu_css .= "#" . $block_id . " .main-menu-wrapper ul li ul li ul { left: 100%; top: -1px; }\n\n";
    
    // Top level links
    $menu_css .= "#" . $block_id . " .main-menu-wrapper > ul > li > a {\n";
    $menu_css .= "  background: " . esc_attr($link_bg) . ";\n";
    $menu_css .= "  color: " . esc_attr($text_color) . ";\n";
    $menu_css .= "  padding-left: " . intval($link_padding_x) . "px;\n";
    $menu_css .= "  padding-right: " . intval($link_padding_x) . "px;\n";
    $menu_css .= "  padding-top: " . intval($link_padding_y) . "px;\n";
    $menu_css .= "  padding-bottom: " . intval($link_padding_y) . "px;\n";
    $menu_css .= "  transition: all 200ms;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "#" . $block_id . " .main-menu-wrapper > ul > li > a:hover,\n";
    $menu_css .= "#" . $block_id . " .main-menu-wrapper > ul > li.current_page_item > a,\n";
    $menu_css .= "#" . $block_id . " .main-menu-wrapper > ul > li.current-menu-ancestor > a {\n";
    $menu_css .= "  background: " . esc_attr($link_bg_hover) . ";\n";
    $menu_css .= "  color: " . esc_attr($hover_text_color) . ";\n";
    $menu_css .= "}\n\n";
    
    // Responsive breakpoint
    $menu_css .= "@media (max-width: " . intval($breakpoint) . "px) {\n";
    $menu_css .= "  #" . $block_id . " .main-menu-wrapper { display: none; }\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "@media (min-width: " . (intval($breakpoint) + 1) . "px) {\n";
    $menu_css .= "  #" . $block_id . " #" . $menu_id . " { display: block !important; }\n";
    $menu_css .= "  #" . $block_id . " .desktop-only { display: flex !important; }\n";
    $menu_css .= "  #" . $block_id . " .mobile-only { display: none !important; }\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "@media (max-width: " . intval($breakpoint) . "px) {\n";
    $menu_css .= "  #" . $block_id . " .desktop-only { display: none !important; }\n";
    $menu_css .= "  #" . $block_id . " .mobile-only { display: flex !important; }\n";
    $menu_css .= "}\n\n";
    
    // Mobile menu drawer styles
    $menu_css .= "#" . $block_id . " .mobile-menu-overlay {\n";
    $menu_css .= "  position: fixed;\n";
    $menu_css .= "  top: 0;\n";
    $menu_css .= "  left: 0;\n";
    $menu_css .= "  width: 100%;\n";
    $menu_css .= "  height: 100%;\n";
    $menu_css .= "  background: rgba(0, 0, 0, 0.5);\n";
    $menu_css .= "  z-index: 9999;\n";
    $menu_css .= "  opacity: 0;\n";
    $menu_css .= "  visibility: hidden;\n";
    $menu_css .= "  transition: opacity 0.3s ease, visibility 0.3s ease;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "#" . $block_id . " .mobile-menu-overlay.active {\n";
    $menu_css .= "  opacity: 1;\n";
    $menu_css .= "  visibility: visible;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "#" . $block_id . " .mobile-menu-drawer {\n";
    $menu_css .= "  position: fixed;\n";
    $menu_css .= "  top: 0;\n";
    $menu_css .= "  left: -300px;\n";
    $menu_css .= "  width: 300px;\n";
    $menu_css .= "  height: 100%;\n";
    $menu_css .= "  background: #fff;\n";
    $menu_css .= "  box-shadow: 2px 0 10px rgba(0,0,0,0.1);\n";
    $menu_css .= "  transition: left 0.3s ease;\n";
    $menu_css .= "  overflow: hidden;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "#" . $block_id . " .mobile-menu-overlay.active .mobile-menu-drawer {\n";
    $menu_css .= "  left: 0;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "#" . $block_id . " .mobile-menu-header {\n";
    $menu_css .= "  display: flex;\n";
    $menu_css .= "  justify-content: space-between;\n";
    $menu_css .= "  align-items: center;\n";
    $menu_css .= "  padding: 20px;\n";
    $menu_css .= "  border-bottom: 1px solid #e0e0e0;\n";
    $menu_css .= "  background: #f5f5f5;\n";
    $menu_css .= "  min-height: 60px;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "#" . $block_id . " .mobile-menu-back {\n";
    $menu_css .= "  background: none;\n";
    $menu_css .= "  border: none;\n";
    $menu_css .= "  padding: 0;\n";
    $menu_css .= "  cursor: pointer;\n";
    $menu_css .= "  display: flex;\n";
    $menu_css .= "  align-items: center;\n";
    $menu_css .= "  gap: 5px;\n";
    $menu_css .= "  color: #333;\n";
    $menu_css .= "  font-size: 14px;\n";
    $menu_css .= "  opacity: 0;\n";
    $menu_css .= "  visibility: hidden;\n";
    $menu_css .= "  transition: opacity 0.3s ease;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "#" . $block_id . " .mobile-menu-back.visible {\n";
    $menu_css .= "  opacity: 1;\n";
    $menu_css .= "  visibility: visible;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "#" . $block_id . " .mobile-menu-back svg {\n";
    $menu_css .= "  width: 16px;\n";
    $menu_css .= "  height: 16px;\n";
    $menu_css .= "  fill: #333;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "#" . $block_id . " .mobile-menu-title {\n";
    $menu_css .= "  font-size: 18px;\n";
    $menu_css .= "  font-weight: bold;\n";
    $menu_css .= "  color: #333;\n";
    $menu_css .= "  flex: 1;\n";
    $menu_css .= "  text-align: center;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "#" . $block_id . " .mobile-menu-close {\n";
    $menu_css .= "  background: none;\n";
    $menu_css .= "  border: none;\n";
    $menu_css .= "  padding: 0;\n";
    $menu_css .= "  cursor: pointer;\n";
    $menu_css .= "  width: 24px;\n";
    $menu_css .= "  height: 24px;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "#" . $block_id . " .mobile-menu-close svg {\n";
    $menu_css .= "  width: 24px;\n";
    $menu_css .= "  height: 24px;\n";
    $menu_css .= "  fill: #333;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "#" . $block_id . " .mobile-menu-content {\n";
    $menu_css .= "  position: relative;\n";
    $menu_css .= "  height: calc(100% - 60px);\n";
    $menu_css .= "  overflow: hidden;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "#" . $block_id . " .mobile-menu-panels {\n";
    $menu_css .= "  display: flex;\n";
    $menu_css .= "  height: 100%;\n";
    $menu_css .= "  transition: transform 0.3s ease;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "#" . $block_id . " .mobile-menu-panel {\n";
    $menu_css .= "  min-width: 100%;\n";
    $menu_css .= "  width: 100%;\n";
    $menu_css .= "  overflow-y: auto;\n";
    $menu_css .= "  padding: 20px;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "#" . $block_id . " .mobile-nav-menu {\n";
    $menu_css .= "  list-style: none;\n";
    $menu_css .= "  padding: 0;\n";
    $menu_css .= "  margin: 0;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "#" . $block_id . " .mobile-nav-menu > li {\n";
    $menu_css .= "  display: block;\n";
    $menu_css .= "  border-bottom: 1px solid #e0e0e0;\n";
    $menu_css .= "  position: relative;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "#" . $block_id . " .mobile-nav-menu > li > .menu-item-wrapper {\n";
    $menu_css .= "  display: flex;\n";
    $menu_css .= "  align-items: center;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "#" . $block_id . " .mobile-nav-menu li a {\n";
    $menu_css .= "  display: block;\n";
    $menu_css .= "  padding: 12px 0;\n";
    $menu_css .= "  color: #333;\n";
    $menu_css .= "  text-decoration: none;\n";
    $menu_css .= "  font-size: 16px;\n";
    $menu_css .= "  flex: 1;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "#" . $block_id . " .mobile-nav-menu li a:hover {\n";
    $menu_css .= "  color: #1e73be;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "#" . $block_id . " .submenu-arrow {\n";
    $menu_css .= "  background: none;\n";
    $menu_css .= "  border: none;\n";
    $menu_css .= "  padding: 12px 15px;\n";
    $menu_css .= "  cursor: pointer;\n";
    $menu_css .= "  display: flex;\n";
    $menu_css .= "  align-items: center;\n";
    $menu_css .= "  justify-content: center;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "#" . $block_id . " .submenu-arrow svg {\n";
    $menu_css .= "  width: 16px;\n";
    $menu_css .= "  height: 16px;\n";
    $menu_css .= "  fill: #666;\n";
    $menu_css .= "}\n\n";
    
    $menu_css .= "#" . $block_id . " .mobile-nav-menu ul,\n";
    $menu_css .= "#" . $block_id . " .mobile-menu-panel ul ul {\n";
    $menu_css .= "  display: none !important;\n";
    $menu_css .= "}\n\n";
    
    // Hide menu icons on desktop
    $menu_css .= "@media (min-width: " . (intval($breakpoint) + 1) . "px) {\n";
    $menu_css .= "  #" . $block_id . " .main-menu-wrapper .menu-icon { display: none; }\n";
    $menu_css .= "}\n\n";
    
    // Show menu icons on mobile
    $menu_css .= "@media (max-width: " . intval($breakpoint) . "px) {\n";
    $menu_css .= "  #" . $block_id . " .mobile-nav-menu .menu-icon {\n";
    $menu_css .= "    display: inline-block;\n";
    $menu_css .= "    margin-right: 10px;\n";
    $menu_css .= "  }\n";
    $menu_css .= "  #" . $block_id . " .mobile-nav-menu .menu-icon i {\n";
    $menu_css .= "    font-size: 18px;\n";
    $menu_css .= "    width: 20px;\n";
    $menu_css .= "    text-align: center;\n";
    $menu_css .= "  }\n";
    $menu_css .= "}\n";

    $ekwa_section_head_styles[$block_id] = $menu_css;
}

// Custom walker to add menu item fields
if (!class_exists('EKWA_Menu_Walker')) {
    class EKWA_Menu_Walker extends Walker_Nav_Menu {
        function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        
        // Add visibility classes
        $visibility = get_field('menu_visibility', $item);
        if ($visibility === 'desktop') {
            $classes[] = 'desktop-only';
        } elseif ($visibility === 'mobile') {
            $classes[] = 'mobile-only';
        }
        
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
        
        $output .= '<li' . $class_names . '>';
        
        $atts = array();
        $atts['href'] = !empty($item->url) ? $item->url : '';
        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);
        
        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $attributes .= ' ' . $attr . '="' . esc_attr($value) . '"';
            }
        }
        
        $title = apply_filters('the_title', $item->title, $item->ID);
        
        // Add icon if set (FontAwesome Icon Picker field)
        $icon = get_field('menu_icon', $item);
        $icon_html = '';
        if ($icon) {
            // Check if it's an array (from FontAwesome picker)
            if (is_array($icon) && !empty($icon['html'])) {
                $icon_html = '<span class="menu-icon">' . $icon['html'] . '</span> ';
            } elseif (is_array($icon) && !empty($icon['class'])) {
                $icon_html = '<span class="menu-icon"><i class="' . esc_attr($icon['class']) . '"></i></span> ';
            } elseif (is_string($icon) && !empty($icon)) {
                // Fallback for old text field format
                $icon_html = '<span class="menu-icon"><i class="fas fa-' . esc_attr($icon) . '"></i></span> ';
            }
        }
        
        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . $icon_html . $title . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;
        
        $output .= $item_output;
        }
    }
}
?>

<div id="<?php echo esc_attr($block_id); ?>" class="<?php echo esc_attr($class_name); ?>" data-breakpoint="<?php echo esc_attr($breakpoint); ?>">
    <!-- Mobile Menu Triggers -->
    <div class="mobile-menu-triggers">
        <button class="search-icon" aria-label="Search">
            <svg width="25" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"></path></svg>
        </button>
        <button class="mobile-menu-trigger" id="trigger-<?php echo esc_attr($menu_id); ?>" aria-label="Open Menu">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M0 96C0 78.3 14.3 64 32 64l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 128C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 288c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32L32 448c-17.7 0-32-14.3-32-32s14.3-32 32-32l384 0c17.7 0 32 14.3 32 32z"/></svg>
        </button>
    </div>
    
    <!-- Desktop Menu Wrapper -->
    <nav class="main-menu-wrapper <?php echo esc_attr($show_icons_class . ' ' . $two_cols_menu_class); ?>" id="<?php echo esc_attr($menu_id); ?>">
        <?php
        wp_nav_menu(array(
            'theme_location' => 'main-menu',
            'container' => false,
            'walker' => new EKWA_Menu_Walker()
        ));
        ?>
    </nav>
    
    <!-- Mobile Menu Drawer -->
    <div class="mobile-menu-overlay" id="overlay-<?php echo esc_attr($menu_id); ?>">
        <div class="mobile-menu-drawer">
            <div class="mobile-menu-header">
                <button class="mobile-menu-back" id="back-<?php echo esc_attr($menu_id); ?>" aria-label="Back">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l192 192c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L77.3 256 246.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-192 192z"/></svg>
                    <span>Back</span>
                </button>
                <span class="mobile-menu-title" id="title-<?php echo esc_attr($menu_id); ?>">Menu</span>
                <button class="mobile-menu-close" id="close-<?php echo esc_attr($menu_id); ?>" aria-label="Close Menu">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg>
                </button>
            </div>
            <div class="mobile-menu-content">
                <div class="mobile-menu-panels" id="panels-<?php echo esc_attr($menu_id); ?>">
                    <div class="mobile-menu-panel" data-panel="main">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'main-menu',
                            'container' => false,
                            'walker' => new EKWA_Menu_Walker(),
                            'menu_class' => 'mobile-nav-menu'
                        ));
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Output JavaScript using base64 to completely bypass WordPress filters
$menu_id_json = json_encode($menu_id);

$script_js = "(function() {
    var menuId = {$menu_id_json};
    var trigger = document.getElementById('trigger-' + menuId);
    var overlay = document.getElementById('overlay-' + menuId);
    var closeBtn = document.getElementById('close-' + menuId);
    var backBtn = document.getElementById('back-' + menuId);
    var panelsContainer = document.getElementById('panels-' + menuId);
    var titleElement = document.getElementById('title-' + menuId);
    var currentPanelIndex = 0;
    var panelHistoryStack = [];
    
    if (!trigger || !overlay || !closeBtn || !backBtn || !panelsContainer) return;
    
    trigger.addEventListener('click', function(e) {
        e.preventDefault();
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    });
    
    function closeMenu() {
        overlay.classList.remove('active');
        document.body.style.overflow = '';
        setTimeout(function() {
            currentPanelIndex = 0;
            panelHistoryStack = [];
            panelsContainer.style.transform = 'translateX(0)';
            backBtn.classList.remove('visible');
            titleElement.textContent = 'Menu';
        }, 300);
    }
    
    closeBtn.addEventListener('click', closeMenu);
    overlay.addEventListener('click', function(e) {
        if (e.target === overlay) closeMenu();
    });
    
    var mainPanel = panelsContainer.querySelector('.mobile-menu-panel[data-panel=main]');
    var originalMenu = mainPanel ? mainPanel.querySelector('.mobile-nav-menu') : null;
    
    if (!originalMenu) return;
    
    var menuItems = [];
    var itemIdCounter = 0;
    
    function buildMenuData(ulElement, parentId) {
        var items = [];
        var lis = ulElement.children;
        
        for (var i = 0; i < lis.length; i++) {
            var li = lis[i];
            if (li.tagName !== 'LI') continue;
            
            var link = null;
            var submenu = null;
            
            for (var j = 0; j < li.children.length; j++) {
                var child = li.children[j];
                if (child.tagName === 'A' && !link) {
                    link = child;
                } else if (child.tagName === 'UL' && !submenu) {
                    submenu = child;
                }
            }
            
            var itemId = itemIdCounter++;
            
            // Extract title and icon HTML separately
            var titleText = '';
            var iconHTML = '';
            if (link) {
                var iconSpan = link.querySelector('.menu-icon');
                if (iconSpan) {
                    iconHTML = iconSpan.outerHTML;
                    titleText = link.textContent.trim();
                } else {
                    titleText = link.textContent.trim();
                }
            }
            
            var item = {
                id: itemId,
                parentId: parentId,
                title: titleText,
                iconHTML: iconHTML,
                href: link ? link.getAttribute('href') : '#',
                classes: li.className,
                hasChildren: !!submenu,
                children: []
            };
            
            if (submenu) {
                item.children = buildMenuData(submenu, itemId);
            }
            
            items.push(item);
            menuItems.push(item);
        }
        
        return items;
    }
    
    var rootItems = buildMenuData(originalMenu, null);
    
    if (rootItems.length === 0) return;
    
    mainPanel.remove();
    
    var panelMap = {};
    var allPanels = [];
    var panelQueue = [{items: rootItems, title: 'Menu', sourceId: 'root'}];
    
    menuItems.forEach(function(item) {
        if (item.hasChildren && item.children.length > 0) {
            panelQueue.push({
                items: item.children,
                title: item.title,
                sourceId: item.id
            });
        }
    });
    
    panelQueue.forEach(function(panelData, idx) {
        panelMap[panelData.sourceId] = idx;
    });
    
    panelQueue.forEach(function(panelData, panelIdx) {
        var panel = document.createElement('div');
        panel.className = 'mobile-menu-panel';
        panel.dataset.panel = 'panel-' + panelIdx;
        
        var ul = document.createElement('ul');
        ul.className = 'mobile-nav-menu';
        
        panelData.items.forEach(function(item) {
            var li = document.createElement('li');
            li.className = item.classes;
            
            if (item.hasChildren) {
                var wrapper = document.createElement('div');
                wrapper.className = 'menu-item-wrapper';
                
                var link = document.createElement('a');
                link.href = item.href;
                if (item.iconHTML) {
                    link.innerHTML = item.iconHTML + ' ' + item.title;
                } else {
                    link.textContent = item.title;
                }
                
                var targetPanelIdx = panelMap[item.id];
                var targetTitle = item.title;
                
                // If link is just #, make the link itself open submenu
                if (item.href === '#' || item.href === '' || !item.href) {
                    link.href = '#';
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        
                        panelHistoryStack.push({
                            index: currentPanelIndex,
                            title: titleElement.textContent
                        });
                        
                        currentPanelIndex = targetPanelIdx;
                        panelsContainer.style.transform = 'translateX(-' + (targetPanelIdx * 100) + '%)';
                        backBtn.classList.add('visible');
                        titleElement.textContent = targetTitle;
                    });
                }
                
                wrapper.appendChild(link);
                
                var arrowBtn = document.createElement('button');
                arrowBtn.className = 'submenu-arrow';
                arrowBtn.setAttribute('aria-label', 'Open submenu');
                
                var svgNS = 'http://www.w3.org/2000/svg';
                var svg = document.createElementNS(svgNS, 'svg');
                svg.setAttribute('xmlns', svgNS);
                svg.setAttribute('viewBox', '0 0 320 512');
                var path = document.createElementNS(svgNS, 'path');
                path.setAttribute('d', 'M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z');
                svg.appendChild(path);
                arrowBtn.appendChild(svg);
                
                arrowBtn.dataset.targetPanel = targetPanelIdx;
                arrowBtn.dataset.title = targetTitle;
                
                arrowBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    var targetIdx = parseInt(this.dataset.targetPanel);
                    var targetTitle = this.dataset.title;
                    
                    panelHistoryStack.push({
                        index: currentPanelIndex,
                        title: titleElement.textContent
                    });
                    
                    currentPanelIndex = targetIdx;
                    panelsContainer.style.transform = 'translateX(-' + (targetIdx * 100) + '%)';
                    backBtn.classList.add('visible');
                    titleElement.textContent = targetTitle;
                });
                
                wrapper.appendChild(arrowBtn);
                li.appendChild(wrapper);
            } else {
                var link = document.createElement('a');
                link.href = item.href;
                if (item.iconHTML) {
                    link.innerHTML = item.iconHTML + ' ' + item.title;
                } else {
                    link.textContent = item.title;
                }
                li.appendChild(link);
            }
            
            ul.appendChild(li);
        });
        
        panel.appendChild(ul);
        allPanels.push(panel);
        panelsContainer.appendChild(panel);
    });
    
    backBtn.addEventListener('click', function() {
        if (panelHistoryStack.length > 0) {
            var previous = panelHistoryStack.pop();
            currentPanelIndex = previous.index;
            
            panelsContainer.style.transform = 'translateX(-' + (currentPanelIndex * 100) + '%)';
            titleElement.textContent = previous.title;
            
            if (panelHistoryStack.length === 0) {
                backBtn.classList.remove('visible');
            }
        }
    });
})();";

// Encode to base64 to bypass all WordPress filters
$encoded = base64_encode($script_js);
?>
<script id="<?php echo esc_attr($menu_id); ?>-script">
eval(atob('<?php echo $encoded; ?>'));
</script>

<?php
// Output styles only in editor preview
if ($is_preview): ?>
<style>
    /* Editor preview styles */
    #<?php echo esc_attr($block_id); ?> {
        padding: 20px;
        border: 1px dashed #e0e0e0;
        background: #fafafa;
    }
    
    /* Hide mobile menu elements in editor */
    #<?php echo esc_attr($block_id); ?> .mobile-menu-overlay {
        display: none !important;
    }
    
    #<?php echo esc_attr($block_id); ?> .mobile-menu-triggers {
        display: flex;
        gap: 15px;
        align-items: center;
        margin-bottom: 15px;
    }
    
    #<?php echo esc_attr($block_id); ?> .mobile-menu-trigger,
    #<?php echo esc_attr($block_id); ?> .search-icon {
        background: none;
        border: none;
        padding: 0;
        cursor: pointer;
        width: 30px;
        height: 30px;
    }
    
    #<?php echo esc_attr($block_id); ?> .mobile-menu-trigger svg,
    #<?php echo esc_attr($block_id); ?> .search-icon svg {
        width: 25px;
        height: 25px;
        fill: <?php echo esc_attr($mobile_trigger_color ?: '#000000'); ?>;
    }
    
    #<?php echo esc_attr($block_id); ?> .main-menu-wrapper {
        display: flex !important;
        gap: 0.5em;
        flex-wrap: wrap;
        align-items: center;
        <?php if ($text_color): ?>
        color: <?php echo esc_attr($text_color); ?>;
        <?php endif; ?>
    }
    
    #<?php echo esc_attr($block_id); ?> .main-menu-wrapper > ul {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        gap: <?php echo intval($gap); ?>px;
    }
    
    #<?php echo esc_attr($block_id); ?> .main-menu-wrapper ul li {
        position: relative;
        display: flex;
        align-items: center;
    }
    
    #<?php echo esc_attr($block_id); ?> .main-menu-wrapper > ul > li > a {
        background: <?php echo esc_attr($link_bg); ?>;
        color: <?php echo esc_attr($text_color); ?>;
        padding: <?php echo intval($link_padding_y); ?>px <?php echo intval($link_padding_x); ?>px;
        text-decoration: none;
        display: block;
    }
    
    /* Submenu styles for editor preview */
    #<?php echo esc_attr($block_id); ?> .main-menu-wrapper ul li ul {
        background-color: <?php echo esc_attr($sub_menu_background); ?>;
        border: 1px solid rgba(0,0,0,.15);
        position: absolute;
        z-index: 2;
        display: flex;
        flex-direction: column;
        opacity: 0;
        visibility: hidden;
        transition: opacity .1s linear;
        left: -1px;
        top: 100%;
        min-width: <?php echo intval($sub_menu_width); ?>px;
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    #<?php echo esc_attr($block_id); ?> .main-menu-wrapper ul li:hover > ul {
        visibility: visible;
        opacity: 1;
    }
    
    #<?php echo esc_attr($block_id); ?> .main-menu-wrapper ul li ul li {
        border-bottom: 1px solid <?php echo esc_attr($separator); ?>;
        display: block;
        width: 100%;
    }
    
    #<?php echo esc_attr($block_id); ?> .main-menu-wrapper ul li ul li a {
        display: block;
        padding: .5em 1em;
        background: <?php echo esc_attr($sub_menu_link_background); ?>;
        color: <?php echo esc_attr($sub_menu_link_text_color); ?>;
        text-decoration: none;
        transition: all 300ms;
        width: 100%;
    }
    
    #<?php echo esc_attr($block_id); ?> .main-menu-wrapper ul li ul li a:hover {
        background: <?php echo esc_attr($sub_menu_link_background_hover); ?>;
        color: <?php echo esc_attr($submenu_link_text_color_hover); ?>;
    }
    
    /* Third level submenu */
    #<?php echo esc_attr($block_id); ?> .main-menu-wrapper ul li ul li ul {
        left: 100%;
        top: -1px;
    }
    
    /* Hide icons on desktop */
    #<?php echo esc_attr($block_id); ?> .main-menu-wrapper .menu-icon {
        display: none;
    }
</style>
<?php endif; ?>
