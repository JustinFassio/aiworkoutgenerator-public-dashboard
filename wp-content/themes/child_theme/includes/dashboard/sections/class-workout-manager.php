<?php
/**
 * Workout Manager Section Class
 *
 * @package AthleteDashboard
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Athlete_Dashboard_Workout_Manager {
    /**
     * Data manager instance
     */
    private $data_manager;

    /**
     * Component instances
     */
    private $detail;
    private $logger;

    /**
     * Initialize the section
     */
    public function __construct() {
        // Initialize data manager
        $this->data_manager = new Athlete_Dashboard_Workout_Data_Manager();

        // Initialize components
        $this->detail = new Athlete_Dashboard_Workout_Detail();
        $this->logger = new Athlete_Dashboard_Workout_Logger();

        // Add action hooks
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('athlete_dashboard_render_section_workout', array($this, 'render'));
        
        // Component hooks
        add_action('athlete_dashboard_workout_logger', array($this->logger, 'render'));
        add_action('athlete_dashboard_current_workout', array($this, 'render_current_workout'));
        add_action('athlete_dashboard_upcoming_workouts', array($this, 'render_upcoming_workouts'));
        add_action('athlete_dashboard_recent_workouts', array($this, 'render_recent_workouts'));
        add_action('athlete_dashboard_workout_stats', array($this, 'render_workout_stats'));
    }

    /**
     * Enqueue section-specific scripts and styles
     */
    public function enqueue_scripts() {
        // Enqueue section styles
        wp_enqueue_style(
            'athlete-dashboard-workout-manager',
            get_stylesheet_directory_uri() . '/assets/css/sections/workout-manager.css',
            array(),
            filemtime(get_stylesheet_directory() . '/assets/css/sections/workout-manager.css')
        );

        // Enqueue section script
        wp_enqueue_script(
            'athlete-dashboard-workout-manager',
            get_stylesheet_directory_uri() . '/assets/js/sections/workout-manager.js',
            array('jquery'),
            filemtime(get_stylesheet_directory() . '/assets/js/sections/workout-manager.js'),
            true
        );

        // Localize script data
        wp_localize_script('athlete-dashboard-workout-manager', 'workoutManagerData', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('workout_manager_nonce'),
            'strings' => array(
                'noWorkouts' => __('No workouts found', 'athlete-dashboard'),
                'loading' => __('Loading...', 'athlete-dashboard'),
                'error' => __('Error loading data', 'athlete-dashboard')
            )
        ));

        // Enqueue component scripts
        $this->detail->enqueue_scripts();
        $this->logger->enqueue_scripts();
    }

    /**
     * Render the section
     */
    public function render() {
        $template_path = get_stylesheet_directory() . '/templates/dashboard/sections/workout-manager.php';
        if (!file_exists($template_path)) {
            error_log('Workout manager template not found: ' . $template_path);
            return;
        }
        include $template_path;
    }

    /**
     * Render current workout
     */
    public function render_current_workout() {
        $current_workout = $this->data_manager->get_current_workout(get_current_user_id());
        if ($current_workout) {
            include get_stylesheet_directory() . '/templates/dashboard/components/current-workout.php';
        } else {
            echo '<p class="no-workout-message">' . esc_html__('No current workout assigned', 'athlete-dashboard') . '</p>';
        }
    }

    /**
     * Render upcoming workouts
     */
    public function render_upcoming_workouts() {
        $upcoming_workouts = $this->data_manager->get_upcoming_workouts(get_current_user_id());
        if (!empty($upcoming_workouts)) {
            include get_stylesheet_directory() . '/templates/dashboard/components/upcoming-workouts.php';
        } else {
            echo '<p class="no-workout-message">' . esc_html__('No upcoming workouts scheduled', 'athlete-dashboard') . '</p>';
        }
    }

    /**
     * Render recent workouts
     */
    public function render_recent_workouts() {
        $recent_workouts = $this->data_manager->get_recent_workouts(get_current_user_id());
        if (!empty($recent_workouts)) {
            include get_stylesheet_directory() . '/templates/dashboard/components/recent-workouts.php';
        } else {
            echo '<p class="no-workout-message">' . esc_html__('No recent workouts found', 'athlete-dashboard') . '</p>';
        }
    }

    /**
     * Render workout statistics
     */
    public function render_workout_stats() {
        $stats = $this->data_manager->get_workout_stats(get_current_user_id());
        include get_stylesheet_directory() . '/templates/dashboard/components/workout-stats.php';
    }
} 