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
        // Initialize core components
        $this->components['welcome_banner'] = new Athlete_Dashboard_Welcome_Banner();
        $this->components['account_details'] = new Athlete_Dashboard_Account_Details();
        $this->components['workout_detail'] = new Athlete_Dashboard_Workout_Detail();
        $this->components['workout_logger'] = new Athlete_Dashboard_Workout_Logger();
        $this->components['nutrition_logger'] = new Athlete_Dashboard_Nutrition_Logger();
        $this->components['nutrition_tracker'] = new Athlete_Dashboard_Nutrition_Tracker();
        $this->components['food_manager'] = new Athlete_Dashboard_Food_Manager();

        // Initialize workout components
        $this->components['workout_dashboard'] = new Athlete_Dashboard_Workout_Dashboard_Controller();
        $this->components['workout_stats'] = new Athlete_Dashboard_Workout_Stats_Display();
        $this->components['progress_tracker'] = new Athlete_Dashboard_Progress_Tracker();
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
        // jQuery UI for autocomplete
        wp_enqueue_style('jquery-ui', 'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');
        wp_enqueue_script('jquery-ui-autocomplete');

        // Chart.js for statistics
        wp_enqueue_script(
            'chart-js',
            'https://cdn.jsdelivr.net/npm/chart.js',
            array(),
            '3.7.0',
            true
        );

        // Component scripts - ensure proper loading order
        $component_scripts = array(
            'athlete-dashboard-workout-lightbox' => array(
                'path' => '/assets/js/components/workout-lightbox.js',
                'deps' => array('jquery')
            ),
            'athlete-dashboard-workout-logger' => array(
                'path' => '/assets/js/components/workout-logger.js',
                'deps' => array('jquery', 'athlete-dashboard-workout-lightbox')
            ),
            'athlete-dashboard-nutrition-logger' => array(
                'path' => '/assets/js/components/nutrition-logger.js',
                'deps' => array('jquery')
            ),
            'athlete-dashboard-nutrition-tracker' => array(
                'path' => '/assets/js/components/nutrition-tracker.js',
                'deps' => array('jquery', 'chart-js')
            ),
            'athlete-dashboard-food-manager' => array(
                'path' => '/assets/js/components/food-manager.js',
                'deps' => array('jquery', 'jquery-ui-autocomplete')
            ),
            'athlete-dashboard-workout-stats' => array(
                'path' => '/assets/js/components/workout-stats-display.js',
                'deps' => array('jquery', 'chart-js')
            ),
            'athlete-dashboard-progress-tracker' => array(
                'path' => '/assets/js/components/progress-tracker.js',
                'deps' => array('jquery')
            )
        );

        // Enqueue component scripts
        foreach ($component_scripts as $handle => $script) {
            $file_path = ATHLETE_DASHBOARD_PATH . $script['path'];
            $file_uri = ATHLETE_DASHBOARD_URI . $script['path'];
            
            if (file_exists($file_path)) {
                wp_enqueue_script(
                    $handle,
                    $file_uri,
                    $script['deps'],
                    filemtime($file_path),
                    true
                );
            }
        }

        // Main dashboard script - load after all components
        wp_enqueue_script(
            'athlete-dashboard',
            ATHLETE_DASHBOARD_URI . '/assets/js/dashboard.js',
            array_merge(
                array('jquery'),
                array_keys($component_scripts)
            ),
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

        // Localize scripts for each component
        $this->localize_component_scripts();
    }

    /**
     * Localize scripts for components
     */
    private function localize_component_scripts() {
        // Main dashboard data
        wp_localize_script('athlete-dashboard', 'athleteDashboardData', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('athlete_dashboard_nonce'),
            'user_id' => get_current_user_id(),
            'strings' => $this->get_localized_strings()
        ));

        // Workout lightbox data
        wp_localize_script('athlete-dashboard-workout-lightbox', 'workoutLightboxData', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('athlete_dashboard_nonce'),
            'strings' => array(
                'loading' => __('Loading workout details...', 'athlete-dashboard'),
                'error' => __('Error loading workout', 'athlete-dashboard'),
                'close' => __('Close', 'athlete-dashboard'),
                'print' => __('Print Workout', 'athlete-dashboard')
            )
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