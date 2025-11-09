<?php
/**
 * ACF Icon Picker Field
 *
 * Provides a searchable interface for selecting Font Awesome icons or pasting custom SVG
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class EKWA_ACF_Icon_Picker_Field extends acf_field {

    /**
     * Initialize the field type
     */
    public function __construct() {
        $this->name = 'ekwa_icon_svg';
        $this->label = __('EKWA Icon (SVG)', 'ekwa');
        $this->category = 'content';
        $this->defaults = array(
            'default_value' => '',
        );

        parent::__construct();
    }

    /**
     * Enqueue assets for the field
     */
    public function input_admin_enqueue_scripts() {
        $dir = get_template_directory_uri();

        // Enqueue Font Awesome for icon preview
        wp_enqueue_style('fontawesome', $dir . '/plugins/fontawesome/css/all.min.css', array(), '6.6.0');

        // Enqueue custom icon picker styles
        wp_enqueue_style('ekwa-icon-picker', $dir . '/settings/acf-icon-picker/icon-picker.css', array(), '2.0.5');

        // Enqueue custom icon picker script
        wp_enqueue_script('ekwa-icon-picker', $dir . '/settings/acf-icon-picker/icon-picker.js', array('jquery'), '2.0.5', true);

        // Localize script with icon data
        wp_localize_script('ekwa-icon-picker', 'ekwaIconData', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('ekwa_icon_picker'),
            'searchPlaceholder' => __('Search icons...', 'ekwa'),
            'selectIcon' => __('Select Icon', 'ekwa'),
            'customSVG' => __('Or paste custom SVG', 'ekwa'),
            'noResults' => __('No icons found', 'ekwa'),
        ));
    }

    /**
     * Render the field input
     */
    public function render_field($field) {
        $value = $field['value'];
        $icon_type = !empty($value['type']) ? $value['type'] : 'fontawesome';
        $icon_value = !empty($value['value']) ? $value['value'] : '';
        ?>

        <div class="ekwa-icon-picker-wrap">
            <input type="hidden"
                   name="<?php echo esc_attr($field['name']); ?>[type]"
                   value="<?php echo esc_attr($icon_type); ?>"
                   class="ekwa-icon-type" />

            <input type="hidden"
                   name="<?php echo esc_attr($field['name']); ?>[value]"
                   value="<?php echo esc_attr($icon_value); ?>"
                   class="ekwa-icon-value" />

            <div class="ekwa-icon-picker-content">
                <div class="ekwa-icon-preview">
                    <?php if ($icon_value): ?>
                        <?php if (strpos($icon_value, '<svg') !== false): ?>
                            <div class="ekwa-icon-svg-preview"><?php echo $icon_value; ?></div>
                            <span class="ekwa-icon-class">SVG Icon</span>
                        <?php else: ?>
                            <i class="fas fa-icons"></i>
                            <span class="ekwa-icon-class">No icon selected</span>
                        <?php endif; ?>
                    <?php else: ?>
                        <i class="fas fa-icons"></i>
                        <span class="ekwa-icon-class">No icon selected</span>
                    <?php endif; ?>
                </div>

                <button type="button" class="button ekwa-open-picker">
                    <i class="fas fa-search"></i> Search & Select Icon
                </button>

                <div class="ekwa-custom-svg-section" style="margin-top: 15px;">
                    <p class="description" style="margin-bottom: 8px;">
                        <strong>Or paste custom SVG code:</strong>
                    </p>
                    <textarea
                        class="ekwa-svg-input"
                        rows="6"
                        placeholder="<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; viewBox=&quot;0 0 24 24&quot;>...</svg>"><?php
                        echo esc_textarea($icon_value);
                    ?></textarea>
                    <p class="description" style="margin-top: 4px; font-size: 11px;">
                        Download SVG from
                        <a href="https://fontawesome.com/icons" target="_blank">FontAwesome</a>,
                        <a href="https://heroicons.com" target="_blank">Heroicons</a>,
                        or any SVG library
                    </p>
                </div>
            </div>
        </div>

        <?php
    }

    /**
     * Render modal (once per page)
     */
    public function input_admin_footer() {
        static $modal_rendered = false;

        if ($modal_rendered) {
            return;
        }

        $modal_rendered = true;
        ?>

        <!-- Icon Picker Modal -->
        <div class="ekwa-icon-modal" style="display: none;">
            <div class="ekwa-icon-modal-content">
                <div class="ekwa-icon-modal-header">
                    <input type="text"
                           class="ekwa-icon-search"
                           placeholder="Search icons (e.g., home, user, phone)..." />
                    <button type="button" class="ekwa-modal-close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="ekwa-icon-categories">
                    <button type="button" class="ekwa-cat-btn active" data-category="all">All</button>
                    <button type="button" class="ekwa-cat-btn" data-category="solid">Solid</button>
                    <button type="button" class="ekwa-cat-btn" data-category="regular">Regular</button>
                    <button type="button" class="ekwa-cat-btn" data-category="brands">Brands</button>
                </div>

                <div class="ekwa-icon-grid">
                    <!-- Icons will be loaded here via JavaScript -->
                    <div class="ekwa-loading">
                        <i class="fas fa-spinner fa-spin"></i> Loading icons...
                    </div>
                </div>
            </div>
        </div>

        <?php
    }

    /**
     * Format the value for saving
     */
    public function format_value($value, $post_id, $field) {
        if (empty($value)) {
            return array(
                'type' => 'svg',
                'value' => ''
            );
        }

        return $value;
    }

    /**
     * Load the value for display
     */
    public function load_value($value, $post_id, $field) {
        // Ensure value is always an array with type and value keys
        if (empty($value) || !is_array($value)) {
            return array(
                'type' => 'svg',
                'value' => ''
            );
        }

        // Legacy support: if value is a string (old format), assume it's SVG
        if (is_string($value)) {
            return array(
                'type' => strpos($value, '<svg') !== false ? 'svg' : 'fontawesome',
                'value' => $value
            );
        }

        return $value;
    }
}

// Register the field type
add_action('acf/include_field_types', function() {
    if (class_exists('acf_field')) {
        new EKWA_ACF_Icon_Picker_Field();
    }
});
