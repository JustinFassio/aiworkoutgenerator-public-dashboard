<?php
/**
 * Dashboard Controller Class
 *
 * @package AthleteDashboard
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Athlete_Dashboard_Controller {
    /**
     * Component instances
     *
     * @var array
     */
    private $components = array();

    /**
     * Handler instances
     *
     * @var array
     */
    private $handlers = array();

    /**
     * Initialize the controller
     */
    public function __construct() {
        $this->init_components();
        $this->init_handlers();
        add_action('wp_enqueue_scripts', array($this, 'enqueue_dashboard_scripts'));
    }

    /**
     * Initialize dashboard components
     */
    private function init_components() {
        // Define component dependencies
        $component_dependencies = array(
            'Athlete_Dashboard_Nutrition_Tracker' => array('Athlete_Dashboard_Nutrition_Data_Manager'),
            'Athlete_Dashboard_Food_Manager' => array('Athlete_Dashboard_Food_Data_Manager'),
            'Athlete_Dashboard_Workout_Detail' => array('Athlete_Dashboard_Workout_Data_Manager'),
            'Athlete_Dashboard_Progress_Tracker' => array('Athlete_Dashboard_Goals_Data_Manager')
        );

        // Initialize core components first
        $core_components = array(
            'welcome_banner' => 'Athlete_Dashboard_Welcome_Banner',
            'account_details' => 'Athlete_Dashboard_Account_Details'
        );

        foreach ($core_components as $key => $class) {
            if (class_exists($class)) {
                $this->components[$key] = new $class();
            } else {
                error_log("Core component not found: {$class}");
            }
        }

        // Initialize components with dependency checks
        $dependent_components = array(
            'workout_detail' => 'Athlete_Dashboard_Workout_Detail',
            'workout_logger' => 'Athlete_Dashboard_Workout_Logger',
            'nutrition_logger' => 'Athlete_Dashboard_Nutrition_Logger',
            'nutrition_tracker' => 'Athlete_Dashboard_Nutrition_Tracker',
            'food_manager' => 'Athlete_Dashboard_Food_Manager',
            'progress_tracker' => 'Athlete_Dashboard_Progress_Tracker'
        );

        foreach ($dependent_components as $key => $class) {
            // Check dependencies first
            if (isset($component_dependencies[$class])) {
                $dependencies_met = true;
                foreach ($component_dependencies[$class] as $dependency) {
                    if (!class_exists($dependency)) {
                        error_log("Dependency not found for {$class}: {$dependency}");
                        $dependencies_met = false;
                        break;
                    }
                }
                if (!$dependencies_met) {
                    continue;
                }
            }

            // Initialize component if dependencies are met
            if (class_exists($class)) {
                $this->components[$key] = new $class();
            } else {
                error_log("Component not found: {$class}");
            }
        }

        // Initialize workout dashboard components last
        if (class_exists('Athlete_Dashboard_Workout_Dashboard_Controller')) {
            $this->components['workout_dashboard'] = new Athlete_Dashboard_Workout_Dashboard_Controller();
        }
        if (class_exists('Athlete_Dashboard_Workout_Stats_Display')) {
            $this->components['workout_stats'] = new Athlete_Dashboard_Workout_Stats_Display();
        }
    }

    /**
     * Initialize dashboard handlers
     */
    private function init_handlers() {
        $this->handlers['workout'] = new Athlete_Dashboard_Workout_Handler();
        $this->handlers['account'] = new Athlete_Dashboard_Account_Handler();
    }

    /**
     * Enqueue dashboard-specific scripts and styles
     */
    public function enqueue_dashboard_scripts() {
        // Core dependencies
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script('jquery-ui-autocomplete');
        wp_enqueue_style('jquery-ui', 'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');

        // Chart.js
        wp_enqueue_script(
            'chart-js',
            'https://cdn.jsdelivr.net/npm/chart.js',
            array('jquery'),
            '3.7.0',
            true
        );

        // Dashboard Components Bundle
        wp_enqueue_script(
            'athlete-dashboard-components',
            ATHLETE_DASHBOARD_URI . '/assets/js/components-bundle.js',
            array('jquery', 'jquery-ui-core', 'jquery-ui-autocomplete', 'chart-js'),
            filemtime(ATHLETE_DASHBOARD_PATH . '/assets/js/components-bundle.js'),
            true
        );

        // Main dashboard script
        wp_enqueue_script(
            'athlete-dashboard-main',
            ATHLETE_DASHBOARD_URI . '/assets/js/dashboard.js',
            array('jquery', 'athlete-dashboard-components'),
            filemtime(ATHLETE_DASHBOARD_PATH . '/assets/js/dashboard.js'),
            true
        );

        // Dashboard styles
        wp_enqueue_style(
            'athlete-dashboard',
            ATHLETE_DASHBOARD_URI . '/assets/css/dashboard.css',
            array(),
            filemtime(ATHLETE_DASHBOARD_PATH . '/assets/css/dashboard.css')
        );

        // Localize script data
        wp_localize_script('athlete-dashboard-components', 'athleteDashboardData', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('athlete_dashboard_nonce'),
            'user_id' => get_current_user_id(),
            'strings' => $this->get_localized_strings()
        ));
    }

    /**
     * Render the dashboard
     */
    public function render() {
        if (!is_user_logged_in()) {
            return $this->render_login_message();
        }

        $current_user = wp_get_current_user();
        ob_start();
        ?>
        <div class="athlete-dashboard-container">
            <?php
            // Render welcome banner
            $this->components['welcome_banner']->render($current_user);
            ?>

            <div class="athlete-dashboard">
                <!-- Account Section -->
                <section class="dashboard-section" id="account-section">
                    <?php $this->components['account_details']->render($current_user); ?>
                </section>

                <!-- Workout Stats Section -->
                <section class="dashboard-section" id="workout-stats-section">
                    <h2><?php esc_html_e('Workout Statistics', 'athlete-dashboard'); ?></h2>
                    <?php $this->components['workout_stats']->render_stats_section(); ?>
                </section>

                <!-- Workout Progress Section -->
                <section class="dashboard-section" id="workout-progress-section">
                    <h2><?php esc_html_e('Workout Progress', 'athlete-dashboard'); ?></h2>
                    <?php $this->components['progress_tracker']->render_progress_tracker(); ?>
                </section>

                <!-- Workout Logging Section -->
                <section class="dashboard-section" id="workout-section">
                    <h2><?php esc_html_e('Workout Tracking', 'athlete-dashboard'); ?></h2>
                    <?php $this->components['workout_logger']->render(); ?>
                </section>

                <!-- Nutrition Logging Section -->
                <section class="dashboard-section" id="nutrition-section">
                    <h2><?php esc_html_e('Nutrition Tracking', 'athlete-dashboard'); ?></h2>
                    <?php $this->components['nutrition_logger']->render(); ?>
                </section>

                <!-- Nutrition Progress Section -->
                <section class="dashboard-section" id="nutrition-progress-section">
                    <h2><?php esc_html_e('Nutrition Progress', 'athlete-dashboard'); ?></h2>
                    <?php $this->components['nutrition_tracker']->render(); ?>
                </section>

                <!-- Workout Detail Component -->
                <?php $this->components['workout_detail']->render(); ?>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }

    /**
     * Render login message for non-logged-in users
     *
     * @return string
     */
    private function render_login_message() {
        ob_start();
        ?>
        <div class="athlete-dashboard-login-message">
            <p>
                <?php
                printf(
                    /* translators: %s: login URL */
                    wp_kses(
                        __('Please <a href="%s">log in</a> to view your dashboard.', 'athlete-dashboard'),
                        array('a' => array('href' => array()))
                    ),
                    esc_url(wp_login_url(get_permalink()))
                );
                ?>
            </p>
        </div>
        <?php
        return ob_get_clean();
    }

    /**
     * Get localized strings for JavaScript
     *
     * @return array
     */
    private function get_localized_strings() {
        return array(
            'loading' => __('Loading...', 'athlete-dashboard'),
            'error' => __('An error occurred', 'athlete-dashboard'),
            'success' => __('Success!', 'athlete-dashboard'),
            'confirm' => __('Are you sure?', 'athlete-dashboard'),
            'save' => __('Save', 'athlete-dashboard'),
            'cancel' => __('Cancel', 'athlete-dashboard')
        );
    }
} 