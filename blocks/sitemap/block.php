<?php
/**
 * EKWA Sitemap Block Template
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

// Create id attribute allowing for custom "anchor" value.
$block_id = 'ekwa-sitemap-' . $block['id'];
if (!empty($block['anchor'])) {
    $block_id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and alignment
$class_name = 'ekwa-sitemap';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $class_name .= ' align' . $block['align'];
}

// Get ACF field
$menu_slug = get_field('menu_slug');
if (empty($menu_slug)) {
    $menu_slug = 'site-map';
}

// Enqueue scripts and styles
$block_dir_url = get_template_directory_uri() . '/blocks/sitemap';
wp_enqueue_script('ekwa-treeview-js', $block_dir_url . '/treeview.js', array('jquery'), '1.0.0', true);
wp_enqueue_style('ekwa-treeview-css', $block_dir_url . '/treeview.css', array(), '1.0.0', 'all');

// Collect custom CSS for consolidated output
if (!is_admin() && !$is_preview) {
    global $ekwa_section_head_styles;

    if (!isset($ekwa_section_head_styles)) {
        $ekwa_section_head_styles = [];
    }

    $sitemap_css = "/* Sitemap Styles for #" . $block_id . " */\n";
    $sitemap_css .= "#" . $block_id . " { position: relative; }\n";
    $sitemap_css .= "#" . $block_id . " #sidetreecontrol { margin-bottom: 15px; }\n";
    $sitemap_css .= "#" . $block_id . " #sidetreecontrol a { color: #1e73be; cursor: pointer; text-decoration: none; margin: 0 5px; }\n";
    $sitemap_css .= "#" . $block_id . " #sidetreecontrol a:hover { text-decoration: underline; }\n";
    $sitemap_css .= "#" . $block_id . " .sitemap { padding: 20px 0; }\n";
    $sitemap_css .= "#" . $block_id . " #tree a { color: #333; text-decoration: none; }\n";
    $sitemap_css .= "#" . $block_id . " #tree a:hover { color: #1e73be; text-decoration: underline; }\n";

    $ekwa_section_head_styles[$block_id] = $sitemap_css;
}
?>

<div id="<?php echo esc_attr($block_id); ?>" class="<?php echo esc_attr($class_name); ?>">
    <div class="sitemap">
        <?php if (has_nav_menu($menu_slug)): ?>
            <div id="sidetreecontrol">
                <a href="javascript:void(0);">Collapse All</a> | <a href="javascript:void(0);">Expand All</a>
            </div>
            <?php
            wp_nav_menu(array(
                'theme_location' => $menu_slug,
                'container' => false,
                'menu_id' => 'tree'
            ));
            ?>
        <?php else: ?>
            <div class="sitemap-notice">
                <p><strong>No menu assigned</strong> to the location "<?php echo esc_html($menu_slug); ?>". Please create a menu and assign it to this location in <a href="<?php echo admin_url('nav-menus.php'); ?>">Appearance → Menus</a>.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
// Output styles only in editor preview
if ($is_preview): ?>
<style>
    /* Editor preview styles */
    #<?php echo esc_attr($block_id); ?> {
        position: relative;
        padding: 20px;
        background: #fff;
        border: 1px dashed #e0e0e0;
    }

    #<?php echo esc_attr($block_id); ?> #sidetreecontrol {
        margin-bottom: 15px;
        padding: 10px;
        background: #f5f5f5;
        border-radius: 4px;
    }

    #<?php echo esc_attr($block_id); ?> #sidetreecontrol a {
        color: #1e73be;
        cursor: pointer;
        text-decoration: none;
        margin: 0 5px;
        font-weight: bold;
    }

    #<?php echo esc_attr($block_id); ?> #sidetreecontrol a:hover {
        text-decoration: underline;
    }

    #<?php echo esc_attr($block_id); ?> .sitemap {
        padding: 20px 0;
    }

    #<?php echo esc_attr($block_id); ?> #tree {
        line-height: 1.8;
    }

    #<?php echo esc_attr($block_id); ?> #tree a {
        color: #333;
        text-decoration: none;
    }

    #<?php echo esc_attr($block_id); ?> #tree a:hover {
        color: #1e73be;
        text-decoration: underline;
    }

    #<?php echo esc_attr($block_id); ?> .sitemap-notice {
        padding: 20px;
        background: #fff3cd;
        border: 1px solid #ffc107;
        border-radius: 4px;
        color: #856404;
    }

    #<?php echo esc_attr($block_id); ?> .sitemap-notice p {
        margin: 0;
    }

    #<?php echo esc_attr($block_id); ?> .sitemap-notice a {
        color: #856404;
        text-decoration: underline;
    }
</style>
<?php endif; ?>
