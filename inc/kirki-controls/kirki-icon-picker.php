<?php
/**
 * Kirki FontAwesome Icon Picker Control
 *
 * @package EKWA
 * @since 1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Check if Kirki exists
if (!class_exists('Kirki')) {
    return;
}

/**
 * Custom Kirki Control for FontAwesome Icon Picker
 */
class Kirki_Control_Icon_Picker extends WP_Customize_Control {

    /**
     * The control type
     *
     * @var string
     */
    public $type = 'icon-picker';

    /**
     * Enqueue control related scripts/styles
     */
    public function enqueue() {
        // Ensure jQuery is loaded
        wp_enqueue_script('jquery');
        
        // FontAwesome
        wp_enqueue_style('fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css', array(), '6.5.1');

        // Custom styles
        wp_enqueue_style(
            'kirki-icon-picker',
            get_template_directory_uri() . '/inc/kirki-controls/icon-picker.css',
            array(),
            '1.0.1'
        );

        // Custom script
        wp_enqueue_script(
            'kirki-icon-picker',
            get_template_directory_uri() . '/inc/kirki-controls/icon-picker.js',
            array('jquery', 'customize-controls', 'customize-base'),
            '1.0.1',
            true
        );
    }

    /**
     * Render the control's content
     */
    public function render_content() {
        ?>
        <label>
            <?php if (!empty($this->label)): ?>
                <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
            <?php endif; ?>
            <?php if (!empty($this->description)): ?>
                <span class="description customize-control-description"><?php echo esc_html($this->description); ?></span>
            <?php endif; ?>
            
            <div class="kirki-icon-picker-wrapper">
                <div class="kirki-icon-preview">
                    <?php if (!empty($this->value())): ?>
                        <i class="<?php echo esc_attr($this->value()); ?> fa-2x"></i>
                    <?php else: ?>
                        <i class="fa-regular fa-icons fa-2x" style="opacity: 0.3;"></i>
                    <?php endif; ?>
                </div>
                <div class="kirki-icon-controls">
                    <input 
                        type="text" 
                        class="kirki-icon-search" 
                        placeholder="Search icons or enter class..." 
                        value="<?php echo esc_attr($this->value()); ?>"
                        <?php $this->link(); ?>
                    />
                    <button type="button" class="button kirki-icon-browse">Browse Icons</button>
                    <?php if (!empty($this->value())): ?>
                        <button type="button" class="button kirki-icon-clear">Clear</button>
                    <?php endif; ?>
                </div>
                <div class="kirki-icon-selected-text">
                    <?php if (!empty($this->value())): ?>
                        <code><?php echo esc_html($this->value()); ?></code>
                    <?php else: ?>
                        <span style="opacity: 0.5;">No icon selected</span>
                    <?php endif; ?>
                </div>
            </div>
        </label>

        <!-- Icon Picker Modal -->
        <div class="kirki-icon-modal" style="display: none;">
            <div class="kirki-icon-modal-overlay"></div>
            <div class="kirki-icon-modal-content">
                <div class="kirki-icon-modal-header">
                    <h2>Select Icon</h2>
                    <input type="text" class="kirki-icon-modal-search" placeholder="Search icons..." />
                    <button type="button" class="kirki-icon-modal-close">&times;</button>
                </div>
                <div class="kirki-icon-modal-body">
                    <div class="kirki-icon-style-tabs">
                        <button class="kirki-icon-tab active" data-style="solid">Solid</button>
                        <button class="kirki-icon-tab" data-style="regular">Regular</button>
                        <button class="kirki-icon-tab" data-style="brands">Brands</button>
                    </div>
                    <div class="kirki-icon-grid"></div>
                    <div class="kirki-icon-loading">Loading icons...</div>
                </div>
            </div>
        </div>
        <?php
    }
}

// Register the control type with Kirki - must be done in customize_register
add_action('customize_register', function($wp_customize) {
    if (!class_exists('Kirki_Control_Icon_Picker')) {
        return;
    }
    $wp_customize->register_control_type('Kirki_Control_Icon_Picker');
}, 20);

// Register the control type with Kirki
add_filter('kirki_control_types', function($controls) {
    $controls['icon-picker'] = 'Kirki_Control_Icon_Picker';
    return $controls;
});
