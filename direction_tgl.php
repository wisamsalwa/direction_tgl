<?php
/**
 * Plugin Name: Direction Toggle
 * Text Domain: direction_tgl
 * Plugin URI: https://github.com/wisamsalwa/direction_tgl
 * Description: Toggles the WordPress admin dashboard and website between RTL and LTR directions with a single click.
 * Version: 1.5
 * Author: Wisam Essalwa, DeepSeek-V3
 * Author URI: https://github.com/wisamsalwa
 * License: GPL-2.0+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: direction-tgl
 * Domain Path: /languages
 */
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Include the plugin updater
require_once plugin_dir_path(__FILE__) . 'plugin-updater.php';

new Plugin_Updater(
    'direction_tgl', // Plugin slug
    'direction_tgl/direction_tgl.php', // Plugin file
    'https://raw.githubusercontent.com/wisamsalwa/direction_tgl/refs/heads/main/update.json'
);


// Set the direction for the admin dashboard
function direction_tgl_set_direction()
{
    global $wp_locale, $wp_styles;

    // Get the current user ID
    $_user_id = get_current_user_id();

    // Check if the direction is being toggled
    if (isset($_GET['d'])) {
        // Sanitize the nonce
        $nonce = isset($_GET['nonce']) ? sanitize_key($_GET['nonce']) : '';

        // Verify the nonce
        if (empty($nonce) || !wp_verify_nonce($nonce, 'toggle_direction_nonce')) {
            wp_die('Security check failed.');
        }

        // Nonce verification succeeded; process the request
        $direction = sanitize_text_field(wp_unslash($_GET['d'])) == 'rtl' ? 'rtl' : 'ltr';
        update_user_meta($_user_id, 'rtladminbar', $direction);
    } else {
        // Get the saved direction preference for the current user
        $direction = get_user_meta($_user_id, 'rtladminbar', true);
        if (false === $direction) {
            // Default to the site's text direction
            $direction = isset($wp_locale->text_direction) ? $wp_locale->text_direction : 'ltr';
        }
    }

    // Set the text direction globally
    $wp_locale->text_direction = $direction;
    if (!is_a($wp_styles, 'WP_Styles')) {
        $wp_styles = new WP_Styles();
    }
    $wp_styles->text_direction = $direction;
}
add_action('init', 'direction_tgl_set_direction');

// Add toggle button to the admin bar
function direction_tgl_add_toggle_button($wp_admin_bar)
{
    if (!current_user_can('edit_posts')) {
        return;
    }

    // Get the current direction
    $current_direction = get_user_meta(get_current_user_id(), 'rtladminbar', true);
    $new_direction = $current_direction === 'rtl' ? 'ltr' : 'rtl';

    // Add the toggle button
    $args = array(
        'id' => 'direction_tgl_button',
        'title' => '<span class="ab-icon">⇄</span> Toggle Direction', // Add icon here
        'href' => add_query_arg('d', $new_direction),
        'meta' => array(
            'class' => 'direction-tgl-button'
        )
    );
    $wp_admin_bar->add_node($args);
}
add_action('admin_bar_menu', 'direction_tgl_add_toggle_button', 999);

// Enqueue CSS for the toggle button styling
function direction_tgl_enqueue_styles()
{
    wp_enqueue_style('direction-tgl-style',
    plugin_dir_url(__FILE__) . 'direction_tgl.css',
    array() ,
    '1.0');
}
add_action('admin_enqueue_scripts', 'direction_tgl_enqueue_styles'); // For admin
add_action('wp_enqueue_scripts', 'direction_tgl_enqueue_styles');    // For front-end

// Add plugin information to the "View details" popup
function direction_tgl_plugin_info($false, $action, $args)
{
    if ($args->slug === 'direction_tgl') {
        // Get the remote update.json file
        $remote = wp_remote_get('https://raw.githubusercontent.com/wisamsalwa/direction_tgl/refs/heads/main/update.json', array(
            'timeout' => 10,
            'headers' => array(
                'Accept' => 'application/json'
            )
        ));

        if (!is_wp_error($remote) && isset($remote['response']['code']) && $remote['response']['code'] == 200 && !empty($remote['body'])) {
            $remote_data = json_decode($remote['body']);
            return (object) array(
                'name' => 'Direction Toggle',
                'slug' => 'direction_tgl',
                'version' => $remote_data->version,
                'last_updated' => $remote_data->last_updated,
                'download_link' => $remote_data->download_url,
                'sections' => $remote_data->sections,
                'requires' => $remote_data->requires,
                'tested' => $remote_data->tested
            );
        }
    }

    return $false;
}
add_filter('plugins_api', 'direction_tgl_plugin_info', 10, 3);

function direction_tgl_load_textdomain()
{
    load_plugin_textdomain('direction_tgl', false, dirname(plugin_basename(__FILE__)) . '/languages/');
}
add_action('plugins_loaded', 'direction_tgl_load_textdomain');


