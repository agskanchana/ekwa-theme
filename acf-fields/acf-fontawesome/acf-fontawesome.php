<?php
/**
 * ACF FontAwesome Icon Picker Field
 *
 * A custom ACF field that adds FontAwesome icon picker with HTML or SVG output options
 *
 * @package EKWA
 * @since 1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Exit if ACF is not available
if (!class_exists('acf_field')) {
    return;
}

class ACF_Field_FontAwesome extends acf_field {

    /**
     * Initialize the field type
     */
    public function __construct() {
        // Field type name (must not contain hyphens)
        $this->name = 'fontawesome';

        // Field type label
        $this->label = __('FontAwesome Icon Picker', 'acf');

        // Field type category
        $this->category = 'content';

        // Default settings
        $this->defaults = array(
            'output_format' => 'html',
            'icon_style'    => 'solid',
            'allow_styles'  => array('solid', 'regular', 'light', 'brands'),
            'return_format' => 'array',
        );

        // Do not delete!
        parent::__construct();
    }

    /**
     * Render field settings
     */
    public function render_field_settings($field) {
        // Output Format
        acf_render_field_setting($field, array(
            'label'         => __('Output Format', 'acf'),
            'instructions'  => __('Choose how the icon should be rendered', 'acf'),
            'type'          => 'select',
            'name'          => 'output_format',
            'choices'       => array(
                'html'  => 'HTML <i> tag',
                'svg'   => 'SVG code',
            ),
        ));

        // Default Icon Style
        acf_render_field_setting($field, array(
            'label'         => __('Default Icon Style', 'acf'),
            'instructions'  => __('Default style for selected icons', 'acf'),
            'type'          => 'select',
            'name'          => 'icon_style',
            'choices'       => array(
                'solid'     => 'Solid (fas)',
                'regular'   => 'Regular (far)',
                'light'     => 'Light (fal)',
                'brands'    => 'Brands (fab)',
            ),
        ));

        // Allow Icon Styles
        acf_render_field_setting($field, array(
            'label'         => __('Allowed Icon Styles', 'acf'),
            'instructions'  => __('Select which icon styles users can choose from', 'acf'),
            'type'          => 'checkbox',
            'name'          => 'allow_styles',
            'choices'       => array(
                'solid'     => 'Solid (fas)',
                'regular'   => 'Regular (far)',
                'light'     => 'Light (fal)',
                'brands'    => 'Brands (fab)',
            ),
            'layout'        => 'horizontal',
        ));

        // Return Format
        acf_render_field_setting($field, array(
            'label'         => __('Return Format', 'acf'),
            'instructions'  => __('Format of the returned value', 'acf'),
            'type'          => 'select',
            'name'          => 'return_format',
            'choices'       => array(
                'array'     => 'Array (icon, style, html/svg)',
                'html'      => 'HTML/SVG only',
                'class'     => 'Class name only',
            ),
        ));
    }

    /**
     * Render the field (admin interface)
     */
    public function render_field($field) {
        // Decode value if it's JSON
        if (is_string($field['value'])) {
            $value = json_decode($field['value'], true);
        } else {
            $value = $field['value'];
        }

        // Default value structure
        if (!is_array($value)) {
            $value = array(
                'icon'  => '',
                'style' => $field['icon_style'],
            );
        }

        $field_id = esc_attr($field['id']);
        $field_name = esc_attr($field['name']);
        $selected_icon = isset($value['icon']) ? esc_attr($value['icon']) : '';
        $selected_style = isset($value['style']) ? esc_attr($value['style']) : $field['icon_style'];
        $output_format = esc_attr($field['output_format']);

        // Ensure allow_styles is an array
        $allow_styles = is_array($field['allow_styles']) ? $field['allow_styles'] : array('solid', 'regular', 'light', 'brands');
        
        ?>
        <div class="acf-fontawesome-picker" data-field-id="<?php echo $field_id; ?>">
            <div class="acf-fa-controls">
                <div class="acf-fa-selected-preview">
                    <?php if ($selected_icon): ?>
                        <i class="fa-<?php echo $selected_style; ?> fa-<?php echo $selected_icon; ?> fa-2x"></i>
                    <?php else: ?>
                        <i class="fa-regular fa-icons fa-2x" style="opacity: 0.3;"></i>
                    <?php endif; ?>
                </div>
                <div class="acf-fa-info">
                    <input 
                        type="text" 
                        class="acf-fa-search" 
                        placeholder="Search icons..." 
                        value="<?php echo $selected_icon; ?>"
                    />
                    <div class="acf-fa-selected-text">
                        <?php if ($selected_icon): ?>
                            <strong><?php echo $selected_icon; ?></strong>
                        <?php else: ?>
                            <span style="opacity: 0.5;">No icon selected</span>
                        <?php endif; ?>
                    </div>
                </div>
                <button type="button" class="button acf-fa-browse-btn">Browse Icons</button>
                <?php if ($selected_icon): ?>
                    <button type="button" class="button acf-fa-clear-btn">Clear</button>
                <?php endif; ?>
            </div>

            <div class="acf-fa-style-selector" <?php echo count($allow_styles) <= 1 ? 'style="display:none;"' : ''; ?>>
                <label>Icon Style:</label>
                <?php foreach ($allow_styles as $style): ?>
                    <?php
                    $style_labels = array(
                        'solid'   => 'Solid',
                        'regular' => 'Regular',
                        'light'   => 'Light',
                        'brands'  => 'Brands',
                    );
                    ?>
                    <label class="acf-fa-style-option">
                        <input 
                            type="radio" 
                            name="<?php echo $field_name; ?>[style]" 
                            value="<?php echo esc_attr($style); ?>"
                            <?php checked($selected_style, $style); ?>
                        />
                        <?php echo $style_labels[$style]; ?>
                    </label>
                <?php endforeach; ?>
            </div>

            <!-- Hidden input to store icon name -->
            <input 
                type="hidden" 
                name="<?php echo $field_name; ?>[icon]" 
                value="<?php echo $selected_icon; ?>" 
                class="acf-fa-icon-input"
            />

            <!-- Hidden input to store output format -->
            <input 
                type="hidden" 
                name="<?php echo $field_name; ?>[output_format]" 
                value="<?php echo $output_format; ?>"
            />
        </div>

        <!-- Icon Picker Modal -->
        <div class="acf-fa-modal" id="<?php echo $field_id; ?>-modal" style="display: none;">
            <div class="acf-fa-modal-overlay"></div>
            <div class="acf-fa-modal-content">
                <div class="acf-fa-modal-header">
                    <h2>Select Icon</h2>
                    <input type="text" class="acf-fa-modal-search" placeholder="Search icons..." />
                    <button type="button" class="acf-fa-modal-close">&times;</button>
                </div>
                <div class="acf-fa-modal-body">
                    <div class="acf-fa-icons-grid"></div>
                    <div class="acf-fa-loading">Loading icons...</div>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Enqueue scripts and styles for the field
     */
    public function input_admin_enqueue_scripts() {
        // FontAwesome 6
        wp_enqueue_style('fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css', array(), '6.5.1');

        // Custom styles
        wp_enqueue_style('acf-fontawesome-field', get_template_directory_uri() . '/acf-fields/acf-fontawesome/acf-fontawesome-field.css', array(), '1.0.0');

        // Custom script
        wp_enqueue_script('acf-fontawesome-field', get_template_directory_uri() . '/acf-fields/acf-fontawesome/acf-fontawesome-field.js', array('jquery'), '1.0.0', true);
    }

    /**
     * Format value for display
     */
    public function format_value($value, $post_id, $field) {
        // If value is empty, return empty
        if (empty($value) || (is_array($value) && empty($value['icon']))) {
            return '';
        }

        // Decode if JSON string
        if (is_string($value)) {
            $value = json_decode($value, true);
        }

        // Ensure we have required data
        if (!is_array($value) || empty($value['icon'])) {
            return '';
        }

        $icon = $value['icon'];
        $style = isset($value['style']) ? $value['style'] : $field['icon_style'];
        $output_format = isset($value['output_format']) ? $value['output_format'] : $field['output_format'];

        // Style prefix mapping
        $style_prefix = array(
            'solid'   => 'fas',
            'regular' => 'far',
            'light'   => 'fal',
            'brands'  => 'fab',
        );

        $prefix = isset($style_prefix[$style]) ? $style_prefix[$style] : 'far';
        $class_name = $prefix . ' fa-' . $icon;

        // Return based on return format
        $return_format = isset($field['return_format']) ? $field['return_format'] : 'array';

        if ($return_format === 'class') {
            return $class_name;
        }

        if ($output_format === 'svg') {
            // For SVG output, we'll return a placeholder since actual SVG requires FontAwesome JS
            // In real usage, you'd need FontAwesome's JS library to convert to SVG
            $svg_html = '<i class="' . esc_attr($class_name) . '" data-fa-transform="svg"></i>';
            
            if ($return_format === 'html') {
                return $svg_html;
            }

            return array(
                'icon'   => $icon,
                'style'  => $style,
                'class'  => $class_name,
                'html'   => $svg_html,
                'format' => 'svg',
            );
        } else {
            // HTML format
            $html = '<i class="' . esc_attr($class_name) . '"></i>';
            
            if ($return_format === 'html') {
                return $html;
            }

            return array(
                'icon'   => $icon,
                'style'  => $style,
                'class'  => $class_name,
                'html'   => $html,
                'format' => 'html',
            );
        }
    }

    /**
     * Update value before saving
     */
    public function update_value($value, $post_id, $field) {
        // If it's already a JSON string, return as is
        if (is_string($value) && json_decode($value)) {
            return $value;
        }

        // If it's an array, encode it
        if (is_array($value)) {
            return json_encode($value);
        }

        return $value;
    }

    /**
     * Load value from database
     */
    public function load_value($value, $post_id, $field) {
        // Decode JSON if it's a string
        if (is_string($value) && !empty($value)) {
            $decoded = json_decode($value, true);
            if ($decoded !== null) {
                return $decoded;
            }
        }

        return $value;
    }
}

// Initialize the field
function register_acf_field_fontawesome() {
    new ACF_Field_FontAwesome();
}
add_action('acf/include_field_types', 'register_acf_field_fontawesome');
