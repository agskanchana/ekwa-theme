<?php
/**
 * ACF CodeMirror Field
 *
 * A custom ACF field that adds CodeMirror editor support
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

class ACF_Field_CodeMirror extends acf_field {

    /**
     * Initialize the field type
     */
    public function __construct() {
        // Field type name (must not contain hyphens)
        $this->name = 'codemirror';

        // Field type label
        $this->label = __('CodeMirror', 'acf');

        // Field type category
        $this->category = 'content';

        // Default settings
        $this->defaults = array(
            'mode'          => 'css',
            'theme'         => 'default',
            'line_numbers'  => 1,
            'line_wrapping' => 1,
            'height'        => '300px',
        );

        // Do not delete!
        parent::__construct();
    }

    /**
     * Render field settings
     */
    public function render_field_settings($field) {
        // Mode
        acf_render_field_setting($field, array(
            'label'         => __('Mode', 'acf'),
            'instructions'  => __('Select the language mode', 'acf'),
            'type'          => 'select',
            'name'          => 'mode',
            'choices'       => array(
                'css'           => 'CSS',
                'javascript'    => 'JavaScript',
                'htmlmixed'     => 'HTML',
                'php'           => 'PHP',
                'sql'           => 'SQL',
                'xml'           => 'XML',
                'yaml'          => 'YAML',
                'markdown'      => 'Markdown',
            ),
        ));

        // Theme
        acf_render_field_setting($field, array(
            'label'         => __('Theme', 'acf'),
            'instructions'  => __('Select the editor theme', 'acf'),
            'type'          => 'select',
            'name'          => 'theme',
            'choices'       => array(
                'default'       => 'Default',
                'monokai'       => 'Monokai',
                'dracula'       => 'Dracula',
                'material'      => 'Material',
                'eclipse'       => 'Eclipse',
                'midnight'      => 'Midnight',
            ),
        ));

        // Line Numbers
        acf_render_field_setting($field, array(
            'label'         => __('Line Numbers', 'acf'),
            'instructions'  => __('Show line numbers', 'acf'),
            'type'          => 'true_false',
            'name'          => 'line_numbers',
            'ui'            => 1,
        ));

        // Line Wrapping
        acf_render_field_setting($field, array(
            'label'         => __('Line Wrapping', 'acf'),
            'instructions'  => __('Enable line wrapping', 'acf'),
            'type'          => 'true_false',
            'name'          => 'line_wrapping',
            'ui'            => 1,
        ));

        // Height
        acf_render_field_setting($field, array(
            'label'         => __('Height', 'acf'),
            'instructions'  => __('Editor height (e.g., 300px, 20em)', 'acf'),
            'type'          => 'text',
            'name'          => 'height',
            'placeholder'   => '300px',
        ));
    }

    /**
     * Render the field (admin interface)
     */
    public function render_field($field) {
        // Sanitize field values
        $field['value'] = esc_textarea($field['value']);
        $field_id = esc_attr($field['id']);
        $field_name = esc_attr($field['name']);

        // Output textarea
        ?>
        <textarea
            id="<?php echo $field_id; ?>"
            name="<?php echo $field_name; ?>"
            class="acf-codemirror-field"
            data-mode="<?php echo esc_attr($field['mode']); ?>"
            data-theme="<?php echo esc_attr($field['theme']); ?>"
            data-line-numbers="<?php echo $field['line_numbers'] ? 'true' : 'false'; ?>"
            data-line-wrapping="<?php echo $field['line_wrapping'] ? 'true' : 'false'; ?>"
            data-height="<?php echo esc_attr($field['height']); ?>"
            style="display: none;"
        ><?php echo $field['value']; ?></textarea>
        <div id="<?php echo $field_id; ?>-editor" class="acf-codemirror-editor" style="height: <?php echo esc_attr($field['height']); ?>; border: 1px solid #ddd; border-radius: 4px;"></div>
        <?php
    }

    /**
     * Enqueue scripts and styles for the field
     */
    public function input_admin_enqueue_scripts() {
        $version = '5.65.2'; // CodeMirror version

        // CodeMirror core
        wp_enqueue_style('codemirror', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/' . $version . '/codemirror.min.css', array(), $version);
        wp_enqueue_script('codemirror', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/' . $version . '/codemirror.min.js', array(), $version, true);

        // Autocomplete addons
        wp_enqueue_style('codemirror-addon-hint', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/' . $version . '/addon/hint/show-hint.min.css', array('codemirror'), $version);
        wp_enqueue_script('codemirror-addon-show-hint', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/' . $version . '/addon/hint/show-hint.min.js', array('codemirror'), $version, true);
        wp_enqueue_script('codemirror-addon-css-hint', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/' . $version . '/addon/hint/css-hint.min.js', array('codemirror-addon-show-hint'), $version, true);
        wp_enqueue_script('codemirror-addon-html-hint', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/' . $version . '/addon/hint/html-hint.min.js', array('codemirror-addon-show-hint'), $version, true);
        wp_enqueue_script('codemirror-addon-javascript-hint', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/' . $version . '/addon/hint/javascript-hint.min.js', array('codemirror-addon-show-hint'), $version, true);
        wp_enqueue_script('codemirror-addon-anyword-hint', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/' . $version . '/addon/hint/anyword-hint.min.js', array('codemirror-addon-show-hint'), $version, true);
        wp_enqueue_script('codemirror-addon-sql-hint', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/' . $version . '/addon/hint/sql-hint.min.js', array('codemirror-addon-show-hint'), $version, true);

        // Edit addons
        wp_enqueue_script('codemirror-addon-closebrackets', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/' . $version . '/addon/edit/closebrackets.min.js', array('codemirror'), $version, true);
        wp_enqueue_script('codemirror-addon-matchbrackets', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/' . $version . '/addon/edit/matchbrackets.min.js', array('codemirror'), $version, true);
        wp_enqueue_script('codemirror-addon-closetag', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/' . $version . '/addon/edit/closetag.min.js', array('codemirror'), $version, true);

        // Comment addon
        wp_enqueue_script('codemirror-addon-comment', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/' . $version . '/addon/comment/comment.min.js', array('codemirror'), $version, true);

        // Selection addons
        wp_enqueue_script('codemirror-addon-active-line', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/' . $version . '/addon/selection/active-line.min.js', array('codemirror'), $version, true);

        // Modes
        wp_enqueue_script('codemirror-mode-css', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/' . $version . '/mode/css/css.min.js', array('codemirror'), $version, true);
        wp_enqueue_script('codemirror-mode-javascript', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/' . $version . '/mode/javascript/javascript.min.js', array('codemirror'), $version, true);
        wp_enqueue_script('codemirror-mode-htmlmixed', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/' . $version . '/mode/htmlmixed/htmlmixed.min.js', array('codemirror'), $version, true);
        wp_enqueue_script('codemirror-mode-xml', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/' . $version . '/mode/xml/xml.min.js', array('codemirror'), $version, true);
        wp_enqueue_script('codemirror-mode-php', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/' . $version . '/mode/php/php.min.js', array('codemirror'), $version, true);
        wp_enqueue_script('codemirror-mode-sql', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/' . $version . '/mode/sql/sql.min.js', array('codemirror'), $version, true);
        wp_enqueue_script('codemirror-mode-yaml', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/' . $version . '/mode/yaml/yaml.min.js', array('codemirror'), $version, true);
        wp_enqueue_script('codemirror-mode-markdown', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/' . $version . '/mode/markdown/markdown.min.js', array('codemirror'), $version, true);

        // Themes
        wp_enqueue_style('codemirror-theme-monokai', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/' . $version . '/theme/monokai.min.css', array('codemirror'), $version);
        wp_enqueue_style('codemirror-theme-dracula', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/' . $version . '/theme/dracula.min.css', array('codemirror'), $version);
        wp_enqueue_style('codemirror-theme-material', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/' . $version . '/theme/material.min.css', array('codemirror'), $version);
        wp_enqueue_style('codemirror-theme-eclipse', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/' . $version . '/theme/eclipse.min.css', array('codemirror'), $version);
        wp_enqueue_style('codemirror-theme-midnight', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/' . $version . '/theme/midnight.min.css', array('codemirror'), $version);

        // Custom script
        wp_enqueue_script('acf-codemirror-field', get_template_directory_uri() . '/acf-fields/acf-codemirror/acf-codemirror-field.js', array('codemirror'), '1.0.0', true);
    }

    /**
     * Format value for display
     */
    public function format_value($value, $post_id, $field) {
        return $value;
    }
}

// Initialize the field
function register_acf_field_codemirror() {
    new ACF_Field_CodeMirror();
}
add_action('acf/include_field_types', 'register_acf_field_codemirror');
