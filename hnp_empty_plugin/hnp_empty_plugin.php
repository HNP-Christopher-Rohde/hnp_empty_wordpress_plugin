<?php
/*
  Plugin Name: HNP Empty Plugin
  Description: Creates a Demo Plugin in Wordpress
  Version: 2.0
  Author: Christopher Rohde 
  Author URI: https://homepage-nach-preis.de/
  License: GPLv3
  License URI: https://www.gnu.org/licenses/gpl-3.0.html
 */

// Security check to prevent direct access to the plugin file
defined('ABSPATH') or die('No script kiddies please!');

// Function to enqueue the Frontend CSS and JS
function hnp_empty_plugin_frontend_scripts() {
    // Define a version number
    $version = '2.0';

    // Check if CSS is not already enqueued
    if (!wp_style_is('hnp_empty_plugin_frontend-css')) {
        // Enqueue CSS with the defined version
        wp_enqueue_style('hnp_empty_plugin_frontend-css', plugin_dir_url(__FILE__) . '/frontend/css/hnp_empty_plugin_frontend.css', array(), $version);
    }

    // Check if JavaScript is not already enqueued
    if (!wp_script_is('hnp_empty_plugin_frontend-js')) {
        // Enqueue JavaScript with the defined version
        wp_enqueue_script('hnp_empty_plugin_frontend-js', plugin_dir_url(__FILE__) . '/frontend/js/hnp_empty_plugin_frontend.js', array(), $version, true);
    }
}
add_action('wp_enqueue_scripts', 'hnp_empty_plugin_frontend_scripts');

// Function to enqueue Backend CSS and JS
function hnp_empty_plugin_backend_scripts() {
    // Define a version number
    $version = '2.0';

    // Check if CSS is not already enqueued
    if (!wp_style_is('hnp_empty_plugin_backend-css')) {
        // Enqueue CSS with the defined version
        wp_enqueue_style('hnp_empty_plugin_backend-css', plugin_dir_url(__FILE__) . '/backend/css/hnp_empty_plugin_backend.css', array(), $version);
    }

    // Check if JavaScript is not already enqueued
    if (!wp_script_is('hnp_empty_plugin_backend-js')) {
        // Enqueue JavaScript with the defined version
        wp_enqueue_script('hnp_empty_plugin_backend-js', plugin_dir_url(__FILE__) . '/backend/js/hnp_empty_plugin_backend.js', array(), $version, true);
    }
}
add_action('admin_enqueue_scripts', 'hnp_empty_plugin_backend_scripts');

// Function for Test - with load Options and Fallback
function hnp_empty_plugin_echo_func() {
    // Get option values
    $name = get_option('hnp_empty_plugin_name_field', 'Name');
    $number = get_option('hnp_empty_plugin_number_field', '12');
    $color = get_option('hnp_empty_plugin_color_field', '#ff0000');
    $description = get_option('hnp_empty_plugin_description_field', 'Im a Desc Field');
    $dropdown = get_option('hnp_empty_plugin_dropdown_field', 'option1');
    $checkbox = get_option('hnp_empty_plugin_checkbox_field', 0);

    // Echo option values
    echo '<p>Name Field: ' . esc_html($name) . '</p>';
    echo '<p>Number Field: ' . esc_html($number) . '</p>';
    echo '<p>Color Field: ' . esc_html($color) . '</p>';
    echo '<p>Description Field: ' . esc_html($description) . '</p>';
    echo '<p>Dropdown Field: ' . esc_html($dropdown) . '</p>';
    echo '<p>Checkbox Field: ' . ($checkbox ? 'Enabled' : 'Disabled') . '</p>';
}
add_shortcode('hnp_empty_plugin_echo_func', 'hnp_empty_plugin_echo_func');


// Function to add plugin options to the main menu
function hnp_empty_plugin_add_plugin_options_page() {
    // Check permission
    if (current_user_can('manage_options')) {
        add_menu_page(
            'HNP Empty Plugin Settings',
            'HNP Empty Plugin',
            'manage_options',
            'hnp-empty-plugin-settings',
            'hnp_empty_plugin_render_plugin_options_page',
            plugin_dir_url(__FILE__) . 'img/hnp-favi.png' 
        );
    }
}
add_action('admin_menu', 'hnp_empty_plugin_add_plugin_options_page');


// Function to render plugin options page
function hnp_empty_plugin_render_plugin_options_page() {
    ?>
    <div class="wrap hnp-empty-plugin-settings">
        <h1>HNP Empty Plugin Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields('hnp_empty_plugin_settings_group'); ?>
            <?php do_settings_sections('hnp-empty-plugin-settings'); ?>
            
            <?php 
                // Add nonce
                wp_nonce_field('hnp_empty_plugin_settings_nonce', 'hnp_empty_plugin_settings_nonce'); 
            ?>
            
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Function to register plugin options
function hnp_empty_plugin_register_plugin_options() {
    // Name
    add_settings_section(
        'hnp_empty_plugin_name_section',
        'Demo',
        'hnp_empty_plugin_demo_section_callback',
        'hnp-empty-plugin-settings'
    );

    // Name
    add_settings_field(
        'hnp_empty_plugin_name_field', 
        'Name Field', 
        'hnp_empty_plugin_name_field_callback', 
        'hnp-empty-plugin-settings', 
        'hnp_empty_plugin_name_section' 
    );

    // Number
    add_settings_field(
        'hnp_empty_plugin_number_field',
        'Number Field',
        'hnp_empty_plugin_number_field_callback',
        'hnp-empty-plugin-settings',
        'hnp_empty_plugin_name_section'
    );

    // Color
    add_settings_field(
        'hnp_empty_plugin_color_field',
        'Color Field',
        'hnp_empty_plugin_color_field_callback',
        'hnp-empty-plugin-settings',
        'hnp_empty_plugin_name_section'
    );

    // Description
    add_settings_field(
        'hnp_empty_plugin_description_field',
        'Description Field',
        'hnp_empty_plugin_description_field_callback',
        'hnp-empty-plugin-settings',
        'hnp_empty_plugin_name_section'
    );

    // Dropdown
    add_settings_field(
        'hnp_empty_plugin_dropdown_field',
        'Dropdown Field',
        'hnp_empty_plugin_dropdown_field_callback',
        'hnp-empty-plugin-settings',
        'hnp_empty_plugin_name_section'
    );

    // Checkbox
    add_settings_field(
        'hnp_empty_plugin_checkbox_field',
        'Checkbox Field',
        'hnp_empty_plugin_checkbox_field_callback',
        'hnp-empty-plugin-settings',
        'hnp_empty_plugin_name_section'
    );
}
add_action('admin_init', 'hnp_empty_plugin_register_plugin_options');

// Callback function for demo section
function hnp_empty_plugin_demo_section_callback() {
    echo 'This a Demo Plugin. Frontend-Shortcode: &#x5B;hnp_empty_plugin_echo_func]</p>';
}

// Callback function for name field
function hnp_empty_plugin_name_field_callback() {
    $value = get_option('hnp_empty_plugin_name_field', 'Name'); // Fallback value is 'Name'
    echo '<input type="text" name="hnp_empty_plugin_name_field" value="' . esc_attr($value) . '" />';
}

// Callback functions for number fields
function hnp_empty_plugin_number_field_callback() {
    $value = get_option('hnp_empty_plugin_number_field', '12'); // Fallback value is '12'
    echo '<input type="number" name="hnp_empty_plugin_number_field" value="' . esc_attr($value) . '" />';
}

// Callback function for Color Field
function hnp_empty_plugin_color_field_callback() {
    $value = get_option('hnp_empty_plugin_color_field', '#ff0000'); // Fallback value is red color
    echo '<input type="color" name="hnp_empty_plugin_color_field" value="' . esc_attr($value) . '" />';
}

// Callback function for Description Field
function hnp_empty_plugin_description_field_callback() {
    $value = get_option('hnp_empty_plugin_description_field', 'Im a Desc Field'); // Fallback value is 'Im a Desc Field'
    echo '<textarea name="hnp_empty_plugin_description_field">' . esc_html($value) . '</textarea>';
}

// Callback function for dropdown field
function hnp_empty_plugin_dropdown_field_callback() {
    $value = get_option('hnp_empty_plugin_dropdown_field', 'option1'); // Fallback value is 'option1'
    ?>
    <select name="hnp_empty_plugin_dropdown_field">
        <option value="option1" <?php selected($value, 'option1'); ?>>Option 1</option>
        <option value="option2" <?php selected($value, 'option2'); ?>>Option 2</option>
        <option value="option3" <?php selected($value, 'option3'); ?>>Option 3</option>
    </select>
    <?php
}

// Callback function for checkbox field
function hnp_empty_plugin_checkbox_field_callback() {
    $value = get_option('hnp_empty_plugin_checkbox_field', 0); // Fallback value is 0 (not checked)
    ?>
    <label for="hnp_empty_plugin_checkbox_field">
        <input type="checkbox" name="hnp_empty_plugin_checkbox_field" id="hnp_empty_plugin_checkbox_field" value="1" <?php checked($value, 1); ?>>
        Enable Checkbox
    </label>
    <?php
}

// Security measures: Nonce verification and save options
function hnp_empty_plugin_register_security_options() {
    // Check if the current page is our plugin options page
    if (isset($_POST['option_page']) && $_POST['option_page'] == 'hnp_empty_plugin_settings_group') {
        // Check if the nonce is set and valid
        if (!isset($_POST['hnp_empty_plugin_settings_nonce']) || !wp_verify_nonce($_POST['hnp_empty_plugin_settings_nonce'], 'hnp_empty_plugin_settings_nonce')) {
            // Unauthorized request, do not save options
            wp_die('Unauthorized request.'); // Output error message for unauthorized requests
        }

        // Save options
        update_option('hnp_empty_plugin_name_field', $_POST['hnp_empty_plugin_name_field']);
        update_option('hnp_empty_plugin_number_field', sanitize_text_field($_POST['hnp_empty_plugin_number_field']));
        update_option('hnp_empty_plugin_color_field', sanitize_text_field($_POST['hnp_empty_plugin_color_field']));
        update_option('hnp_empty_plugin_description_field', sanitize_textarea_field($_POST['hnp_empty_plugin_description_field']));
        update_option('hnp_empty_plugin_dropdown_field', sanitize_text_field($_POST['hnp_empty_plugin_dropdown_field']));
        update_option('hnp_empty_plugin_checkbox_field', isset($_POST['hnp_empty_plugin_checkbox_field']) ? 1 : 0);
    }
}
add_action('admin_init', 'hnp_empty_plugin_register_security_options');

// Register plugin options and security measures
function hnp_empty_plugin_register_settings() {
    // Register setting and sanitize callback
    register_setting('hnp_empty_plugin_settings_group', 'hnp_empty_plugin_name_field');
    register_setting('hnp_empty_plugin_settings_group', 'hnp_empty_plugin_number_field');
    register_setting('hnp_empty_plugin_settings_group', 'hnp_empty_plugin_color_field');
    register_setting('hnp_empty_plugin_settings_group', 'hnp_empty_plugin_description_field');
    register_setting('hnp_empty_plugin_settings_group', 'hnp_empty_plugin_dropdown_field');
    register_setting('hnp_empty_plugin_settings_group', 'hnp_empty_plugin_checkbox_field');
}
add_action('admin_init', 'hnp_empty_plugin_register_settings');


// Security measures: Nonce verification for options update
function hnp_empty_plugin_validate_settings($input) {
    return $input; // Simply return the input, no further validation here
}
