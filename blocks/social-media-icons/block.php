<?php
/**
 * EKWA Social Media Icons Block Template
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

// Create id attribute allowing for custom "anchor" value.
$block_id = 'ekwa-social-media-' . $block['id'];
if (!empty($block['anchor'])) {
    $block_id = $block['anchor'];
}

// Create valid JavaScript function name (no dashes)
$js_function_name = 'shareToggle' . str_replace('-', '_', $block['id']);

// Create class attribute allowing for custom "className" and alignment
$class_name = 'ekwa-social-media-icons';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}

// Get alignment
$align = '';
if (!empty($block['align'])) {
    $align = 'align-' . $block['align'];
}

// Get ACF fields
$icon_size = get_field('size') ?: 20;
$icon_gap = get_field('gap') ?: 10;
$icon_color = get_field('color') ?: '#000000';
$hover_color = get_field('hover_color') ?: '#183153';
$hide_share_icon = get_field('hide_share_icon');

// Get social media links from Customizer
$sm_links = get_theme_mod('social_media_links', null);

// Collect custom CSS for consolidated output
if (!is_admin() && !$is_preview) {
    global $ekwa_section_head_styles;

    if (!isset($ekwa_section_head_styles)) {
        $ekwa_section_head_styles = [];
    }

    $sm_css = "/* Social Media Icons Styles for #" . $block_id . " */\n";
    $sm_css .= "#" . $block_id . " .social-media { display: flex; gap: " . intval($icon_gap) . "px; align-items: center; flex-wrap: wrap; }\n";
    $sm_css .= "#" . $block_id . " .sm-icons,\n";
    $sm_css .= "#" . $block_id . " .addthis { text-align: center; display: inline-block; border-radius: 0; position: relative; vertical-align: bottom; outline: none; border: none; background: none; padding: 0; font-size: " . intval($icon_size) . "px; color: " . esc_attr($icon_color) . "; transition: color 0.3s ease; }\n";
    $sm_css .= "#" . $block_id . " .sm-icons:hover,\n";
    $sm_css .= "#" . $block_id . " .addthis:hover { color: " . esc_attr($hover_color) . "; }\n";
    $sm_css .= "#" . $block_id . " .sm-icons img { width: " . intval($icon_size) . "px; height: " . intval($icon_size) . "px; display: block; }\n";
    $sm_css .= "#" . $block_id . ".align-left .social-media { justify-content: flex-start; }\n";
    $sm_css .= "#" . $block_id . ".align-center .social-media { justify-content: center; }\n";
    $sm_css .= "#" . $block_id . ".align-right .social-media { justify-content: flex-end; }\n";
    $sm_css .= "#" . $block_id . " .addthis { cursor: pointer; }\n";
    $sm_css .= "#" . $block_id . " .addthis span.hide { display: none; }\n";
    $sm_css .= "#" . $block_id . " .share-toggle { z-index: 99; visibility: hidden; opacity: 0; position: absolute; bottom: calc(100% + 12px); left: 50%; transform: translateX(-50%) translateY(10px); background: #fff; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.15); padding: 8px; transition: all 0.3s ease; }\n";
    $sm_css .= "#" . $block_id . " .share-toggle::after { content: ''; position: absolute; top: 100%; left: 50%; transform: translateX(-50%); width: 0; height: 0; border-left: 10px solid transparent; border-right: 10px solid transparent; border-top: 10px solid #fff; filter: drop-shadow(0 3px 2px rgba(0,0,0,0.1)); }\n";
    $sm_css .= "#" . $block_id . " .share-toggle.active { visibility: visible; opacity: 1; transform: translateX(-50%) translateY(0); }\n";
    $sm_css .= "#" . $block_id . " .share-toggle a { color: #fff; width: 44px; height: 44px; margin: 4px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; border-radius: 8px; transition: all 0.2s ease; }\n";
    $sm_css .= "#" . $block_id . " .share-toggle a:hover { transform: scale(1.1); box-shadow: 0 2px 8px rgba(0,0,0,0.2); }\n";
    $sm_css .= "#" . $block_id . " .share-toggle i { font-size: 20px; }\n";
    $sm_css .= "#" . $block_id . " .share-toggle .share-facebook { background: #3b5998; }\n";
    $sm_css .= "#" . $block_id . " .share-toggle .share-twit { background: #38A1F3; }\n";
    $sm_css .= "#" . $block_id . " .share-toggle .share-google { background: #C33; }\n";
    $sm_css .= "@media (max-width: 768px) { #" . $block_id . " .addthis.hide-from-mobile { display: none; } }\n";

    $ekwa_section_head_styles[$block_id] = $sm_css;
}
?>

<div id="<?php echo esc_attr($block_id); ?>" class="<?php echo esc_attr($class_name . ' ' . $align); ?>">
    <?php if (!empty($sm_links) && is_array($sm_links)): ?>
        <div class="social-media">
            <?php foreach ($sm_links as $sm_link): ?>
                <a class="sm-icons" 
                   aria-label="<?php echo esc_attr($sm_link['profile_name'] ?? 'Social Media'); ?>" 
                   rel="noopener noreferrer" 
                   target="_blank" 
                   href="<?php echo esc_url($sm_link['social_media_link'] ?? '#'); ?>">
                    
                    <?php if (!empty($sm_link['social_media_icon_font'])): ?>
                        <i class="<?php echo esc_attr($sm_link['social_media_icon_font']); ?>"></i>
                    <?php endif; ?>
                    
                    <?php if (!empty($sm_link['social_media_icon_image'])): ?>
                        <?php
                        if (!wp_attachment_is_image($sm_link['social_media_icon_image'])) {
                            $img_url = $sm_link['social_media_icon_image'];
                        } else {
                            $img_url = wp_get_attachment_url($sm_link['social_media_icon_image']);
                        }
                        ?>
                        <img src="<?php echo esc_url($img_url); ?>" 
                             alt="<?php echo esc_attr($sm_link['profile_name'] ?? 'Social Media Icon'); ?>">
                    <?php endif; ?>
                </a>
            <?php endforeach; ?>
            
            <?php if (!$hide_share_icon): ?>
                <button class="addthis" 
                        aria-label="Toggle Share" 
                        onclick="<?php echo esc_js($js_function_name); ?>()" 
                        type="button">
                    <i class="fas fa-share-alt"></i>
                    <span class="hide">Share</span>
                    
                    <label id="share-toggle-<?php echo esc_attr($block_id); ?>" class="share-toggle">
                        <a aria-label="Share on Facebook" 
                           class="share-facebook" 
                           rel="noopener noreferrer" 
                           href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>&t=<?php echo urlencode(get_the_title()); ?>" 
                           onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" 
                           target="_blank" 
                           title="Share on Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a aria-label="Share on Twitter" 
                           class="share-twit" 
                           rel="noopener noreferrer" 
                           href="https://twitter.com/share?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>" 
                           onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" 
                           target="_blank" 
                           title="Share on Twitter">
                            <i class="fa-brands fa-x-twitter"></i>
                        </a>
                        <a aria-label="Share on Pinterest" 
                           class="share-google pin-share-link" 
                           data-pin-do="buttonPin" 
                           href="https://www.pinterest.com/pin/create/button/?url=<?php echo urlencode(get_permalink()); ?>" 
                           data-pin-custom="true"
                           target="_blank"
                           title="Share on Pinterest">
                            <i class="fab fa-pinterest-p"></i>
                        </a>
                    </label>
                </button>
                
                <script>
                function <?php echo esc_js($js_function_name); ?>() {
                    var element = document.getElementById('share-toggle-<?php echo esc_js($block_id); ?>');
                    if (element) {
                        element.classList.toggle('active');
                    }
                }
                </script>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="social-media-notice">
            <p><strong>No social media links configured.</strong> Please add social media links in <a href="<?php echo admin_url('customize.php'); ?>">Customizer → Social Media</a>.</p>
        </div>
    <?php endif; ?>
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

    #<?php echo esc_attr($block_id); ?> .social-media {
        display: flex;
        gap: <?php echo intval($icon_gap); ?>px;
        align-items: center;
        flex-wrap: wrap;
    }

    #<?php echo esc_attr($block_id); ?> .sm-icons,
    #<?php echo esc_attr($block_id); ?> .addthis {
        text-align: center;
        display: inline-block;
        border-radius: 0;
        position: relative;
        vertical-align: bottom;
        outline: none;
        border: none;
        background: none;
        padding: 0;
        font-size: <?php echo intval($icon_size); ?>px;
        color: <?php echo esc_attr($icon_color); ?>;
        transition: color 0.3s ease;
        cursor: pointer;
    }

    #<?php echo esc_attr($block_id); ?> .sm-icons:hover,
    #<?php echo esc_attr($block_id); ?> .addthis:hover {
        color: <?php echo esc_attr($hover_color); ?>;
    }

    #<?php echo esc_attr($block_id); ?> .sm-icons img {
        width: <?php echo intval($icon_size); ?>px;
        height: <?php echo intval($icon_size); ?>px;
        display: block;
    }

    #<?php echo esc_attr($block_id); ?>.align-left .social-media {
        justify-content: flex-start;
    }

    #<?php echo esc_attr($block_id); ?>.align-center .social-media {
        justify-content: center;
    }

    #<?php echo esc_attr($block_id); ?>.align-right .social-media {
        justify-content: flex-end;
    }

    #<?php echo esc_attr($block_id); ?> .addthis span.hide {
        display: none;
    }

    #<?php echo esc_attr($block_id); ?> .share-toggle {
        z-index: 99;
        visibility: hidden;
        opacity: 0;
        position: absolute;
        bottom: calc(100% + 12px);
        left: 50%;
        transform: translateX(-50%) translateY(10px);
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        padding: 8px;
        transition: all 0.3s ease;
    }

    #<?php echo esc_attr($block_id); ?> .share-toggle::after {
        content: '';
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%);
        width: 0;
        height: 0;
        border-left: 10px solid transparent;
        border-right: 10px solid transparent;
        border-top: 10px solid #fff;
        filter: drop-shadow(0 3px 2px rgba(0,0,0,0.1));
    }

    #<?php echo esc_attr($block_id); ?> .share-toggle.active {
        visibility: visible;
        opacity: 1;
        transform: translateX(-50%) translateY(0);
    }

    #<?php echo esc_attr($block_id); ?> .share-toggle a {
        color: #fff;
        width: 44px;
        height: 44px;
        margin: 4px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        border-radius: 8px;
        transition: all 0.2s ease;
    }

    #<?php echo esc_attr($block_id); ?> .share-toggle a:hover {
        transform: scale(1.1);
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }

    #<?php echo esc_attr($block_id); ?> .share-toggle i {
        font-size: 20px;
    }

    #<?php echo esc_attr($block_id); ?> .share-toggle .share-facebook {
        background: #3b5998;
    }

    #<?php echo esc_attr($block_id); ?> .share-toggle .share-twit {
        background: #38A1F3;
    }

    #<?php echo esc_attr($block_id); ?> .share-toggle .share-google {
        background: #C33;
    }

    #<?php echo esc_attr($block_id); ?> .social-media-notice {
        padding: 20px;
        background: #fff3cd;
        border: 1px solid #ffc107;
        border-radius: 4px;
        color: #856404;
    }

    #<?php echo esc_attr($block_id); ?> .social-media-notice p {
        margin: 0;
    }

    #<?php echo esc_attr($block_id); ?> .social-media-notice a {
        color: #856404;
        text-decoration: underline;
    }
</style>
<?php endif; ?>
