<?php
/**
 * Athlete Dashboard Theme Functions
 */

if (!defined('ABSPATH')) {
    exit;
}

// Load Composer autoloader if it exists
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}

// Load dashboard framework core files in correct order
require_once __DIR__ . '/dashboard/contracts/FeatureInterface.php';
require_once __DIR__ . '/dashboard/abstracts/AbstractFeature.php';
require_once __DIR__ . '/dashboard/components/Form/Form.php';
require_once __DIR__ . '/dashboard/components/Dashboard.php';
require_once __DIR__ . '/dashboard/components/Header.php';
require_once __DIR__ . '/dashboard/components/Footer.php';
require_once __DIR__ . '/dashboard/components/Sidebar.php';
require_once __DIR__ . '/dashboard/core/FeatureRegistry.php';
require_once __DIR__ . '/dashboard/core/DependencyManager.php';
require_once __DIR__ . '/dashboard/core/AssetManager.php';
require_once __DIR__ . '/dashboard/core/EventManager.php';
require_once __DIR__ . '/dashboard/core/dashboard-bridge.php';
require_once __DIR__ . '/dashboard/core/init.php';

// Load features
$features_dir = __DIR__ . '/features';
if (is_dir($features_dir)) {
    foreach (scandir($features_dir) as $feature) {
        if ($feature === '.' || $feature === '..') {
            continue;
        }

        $feature_index = $features_dir . '/' . $feature . '/index.php';
        if (file_exists($feature_index)) {
            require_once $feature_index;
        }
    }
}

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

    // Only proceed with dashboard assets if we're on the dashboard template
    if (!is_page_template('dashboard.php')) {
        return;
    }

    // Define possible asset paths (in order of preference)
    $asset_paths = [
        'new' => [
            'css' => '/assets/dist/css/dashboard.css',
            'js' => '/assets/dist/js/dashboard.js'
        ],
        'legacy' => [
            'css' => '/dashboard/assets/css/dashboard.css',
            'js' => '/dashboard/assets/js/dashboard.js'
        ]
    ];

    // Find and enqueue CSS
    $css_file = '';
    foreach ($asset_paths as $path_set) {
        $temp_path = get_stylesheet_directory() . $path_set['css'];
        if (file_exists($temp_path)) {
            $css_file = $temp_path;
            wp_enqueue_style(
                'athlete-dashboard-core-styles',
                get_stylesheet_directory_uri() . $path_set['css'],
                ['athlete-dashboard-style'],
                filemtime($temp_path)
            );
            break;
        }
    }
    if (!$css_file) {
        error_log('Dashboard CSS file not found in any of the expected locations');
    }

    // Find and enqueue JS
    $js_file = '';
    foreach ($asset_paths as $path_set) {
        $temp_path = get_stylesheet_directory() . $path_set['js'];
        if (file_exists($temp_path)) {
            $js_file = $temp_path;
            wp_enqueue_script(
                'athlete-dashboard-core-scripts',
                get_stylesheet_directory_uri() . $path_set['js'],
                ['wp-api', 'wp-element'],
                filemtime($temp_path),
                true
            );
            wp_script_add_data('athlete-dashboard-core-scripts', 'type', 'module');
            break;
        }
    }
    if (!$js_file) {
        error_log('Dashboard JS file not found in any of the expected locations');
    }

    // If we found and enqueued the JS file, add the localized data
    if ($js_file) {
        $current_user = wp_get_current_user();
        wp_localize_script('athlete-dashboard-core-scripts', 'athleteDashboardData', [
            'user' => [
                'id' => $current_user->ID,
                'name' => $current_user->display_name,
                'email' => $current_user->user_email,
                'roles' => $current_user->roles,
            ],
            'restNonce' => wp_create_nonce('wp_rest'),
            'restUrl' => rest_url('athlete-dashboard/v1'),
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'features' => athlete_dashboard_get_active_features(),
        ]);
    }
}
add_action('wp_enqueue_scripts', 'athlete_dashboard_enqueue_assets');

/**
 * Get active features and their metadata
 */
function athlete_dashboard_get_active_features() {
    $features = ['profile', 'workout', 'training-persona'];
    $active_features = [];

    foreach ($features as $feature) {
        $feature_class = ucfirst($feature) . 'Feature';
        if (class_exists($feature_class)) {
            $feature_instance = new $feature_class();
            $active_features[$feature] = [
                'identifier' => $feature_instance->getIdentifier(),
                'metadata' => $feature_instance->getMetadata(),
                'enabled' => $feature_instance->isEnabled(),
            ];
        }
    }

    return $active_features;
}

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