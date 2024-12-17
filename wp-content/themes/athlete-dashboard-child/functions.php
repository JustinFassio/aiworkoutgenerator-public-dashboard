<?php
/**
 * Athlete Dashboard Theme Functions
 */

if (!defined('ABSPATH')) {
    exit;
}

// Load features
require_once get_stylesheet_directory() . '/features/dashboard/index.php';
require_once get_stylesheet_directory() . '/features/profile/index.php';

/**
 * Theme Setup
 */
function athlete_dashboard_setup() {
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script'
    ));

    // Register navigation menus
    register_nav_menus(array(
        'primary-menu' => __('Primary Menu', 'athlete-dashboard-child'),
    ));
}
add_action('after_setup_theme', 'athlete_dashboard_setup');

/**
 * Enqueue theme styles and scripts
 */
function athlete_dashboard_enqueue_assets() {
    // Main theme style
    wp_enqueue_style(
        'athlete-dashboard-style',
        get_stylesheet_uri(),
        array(),
        wp_get_theme()->get('Version')
    );

    // jQuery (ensure it's loaded)
    wp_enqueue_script('jquery');

    // Dashboard specific assets
    if (is_page_template('features/dashboard/templates/dashboard.php')) {
        // Dashboard styles
        wp_enqueue_style(
            'athlete-dashboard-feature',
            get_stylesheet_directory_uri() . '/features/dashboard/styles/dashboard.css',
            array('athlete-dashboard-style'),
            wp_get_theme()->get('Version')
        );

        // Profile styles
        wp_enqueue_style(
            'athlete-profile',
            get_stylesheet_directory_uri() . '/features/profile/assets/css/profile.css',
            array('athlete-dashboard-style'),
            wp_get_theme()->get('Version')
        );

        // Profile scripts
        wp_enqueue_script(
            'athlete-profile',
            get_stylesheet_directory_uri() . '/features/profile/assets/js/profile.js',
            array('jquery'),
            wp_get_theme()->get('Version'),
            true
        );

        // Localize scripts
        wp_localize_script('athlete-profile', 'athleteDashboard', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('profile_nonce')
        ));
    }
}
add_action('wp_enqueue_scripts', 'athlete_dashboard_enqueue_assets');

/**
 * Add API key settings to WordPress admin
 */
function athlete_dashboard_add_settings() {
    add_options_page(
        __('Athlete Dashboard Settings', 'athlete-dashboard-child'),
        __('Athlete Dashboard', 'athlete-dashboard-child'),
        'manage_options',
        'athlete-dashboard-settings',
        'athlete_dashboard_settings_page'
    );

    register_setting('athlete_dashboard_settings', 'workout_generator_api_key');
}
add_action('admin_menu', 'athlete_dashboard_add_settings');

/**
 * Render settings page
 */
function athlete_dashboard_settings_page() {
    ?>
    <div class="wrap">
        <h1><?php echo esc_html__('Athlete Dashboard Settings', 'athlete-dashboard-child'); ?></h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('athlete_dashboard_settings');
            do_settings_sections('athlete_dashboard_settings');
            ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">
                        <?php echo esc_html__('Workout Generator API Key', 'athlete-dashboard-child'); ?>
                    </th>
                    <td>
                        <input type="text" 
                               name="workout_generator_api_key" 
                               value="<?php echo esc_attr(get_option('workout_generator_api_key')); ?>" 
                               class="regular-text" />
                        <p class="description">
                            <?php echo esc_html__('Enter your AI Workout Generator API key here.', 'athlete-dashboard-child'); ?>
                        </p>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}