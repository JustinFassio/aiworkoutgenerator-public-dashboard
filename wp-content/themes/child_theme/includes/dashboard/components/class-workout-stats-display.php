<?php
/**
 * Workout Stats Display Component Class
 * 
 * Handles the presentation and rendering of workout statistics in the dashboard
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Athlete_Dashboard_Workout_Stats_Display {
    /**
     * The stats manager instance
     *
     * @var Athlete_Dashboard_Workout_Stats_Manager
     */
    private $stats_manager;

    /**
     * Initialize the component
     */
    public function __construct() {
        $this->stats_manager = new Athlete_Dashboard_Workout_Stats_Manager();
        $this->init_hooks();
    }

    /**
     * Initialize WordPress hooks
     */
    private function init_hooks() {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_assets'));
        add_action('athlete_dashboard_workout_stats', array($this, 'render_stats_section'));
    }

    /**
     * Enqueue necessary assets
     */
    public function enqueue_assets() {
        if (!is_page('dashboard')) {
            return;
        }

        wp_enqueue_style(
            'workout-stats-display',
            get_stylesheet_directory_uri() . '/assets/css/components/workout-stats-display.css',
            array(),
            ATHLETE_DASHBOARD_VERSION
        );

        wp_enqueue_script(
            'workout-stats-display',
            get_stylesheet_directory_uri() . '/assets/js/components/workout-stats-display.js',
            array('jquery', 'chart-js'),
            ATHLETE_DASHBOARD_VERSION,
            true
        );

        wp_localize_script('workout-stats-display', 'workoutStatsData', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('workout_stats_nonce'),
            'i18n' => array(
                'noData' => __('No workout data available', 'athlete-dashboard'),
                'loading' => __('Loading stats...', 'athlete-dashboard')
            )
        ));
    }

    /**
     * Render the stats section
     *
     * @param array $args Optional display arguments
     */
    public function render_stats_section($args = array()) {
        $default_args = array(
            'show_charts' => true,
            'show_summary' => true,
            'time_period' => '30_days'
        );

        $args = wp_parse_args($args, $default_args);
        $user_id = get_current_user_id();

        // Get stats based on time period
        $date_range = $this->get_date_range($args['time_period']);
        $stats = $this->stats_manager->get_workout_stats($user_id, $date_range);

        $this->render_stats_summary($stats);

        if ($args['show_charts']) {
            $this->render_stats_charts($stats);
        }
    }

    /**
     * Render the stats summary section
     *
     * @param array $stats Workout statistics
     */
    private function render_stats_summary($stats) {
        ?>
        <div class="workout-stats-summary">
            <div class="stat-card total-workouts">
                <h3><?php esc_html_e('Total Workouts', 'athlete-dashboard'); ?></h3>
                <div class="stat-value"><?php echo esc_html($stats['total_workouts']); ?></div>
            </div>

            <div class="stat-card workout-streak">
                <h3><?php esc_html_e('Current Streak', 'athlete-dashboard'); ?></h3>
                <div class="stat-value">
                    <?php 
                    /* translators: %d: number of days */
                    printf(esc_html(_n('%d day', '%d days', $stats['workout_frequency']['streak'], 'athlete-dashboard')), 
                        $stats['workout_frequency']['streak']); 
                    ?>
                </div>
            </div>

            <div class="stat-card completion-rate">
                <h3><?php esc_html_e('Completion Rate', 'athlete-dashboard'); ?></h3>
                <div class="stat-value"><?php echo esc_html(round($stats['workout_frequency']['consistency_score'])); ?>%</div>
            </div>

            <div class="stat-card average-intensity">
                <h3><?php esc_html_e('Avg. Intensity', 'athlete-dashboard'); ?></h3>
                <div class="stat-value"><?php echo esc_html(round($stats['average_intensity'], 1)); ?>/10</div>
            </div>
        </div>
        <?php
    }

    /**
     * Render the stats charts section
     *
     * @param array $stats Workout statistics
     */
    private function render_stats_charts($stats) {
        ?>
        <div class="workout-stats-charts">
            <!-- Workout Frequency Chart -->
            <div class="chart-container">
                <h3><?php esc_html_e('Workout Frequency', 'athlete-dashboard'); ?></h3>
                <canvas id="workoutFrequencyChart"></canvas>
            </div>

            <!-- Progress Trends Chart -->
            <div class="chart-container">
                <h3><?php esc_html_e('Progress Trends', 'athlete-dashboard'); ?></h3>
                <canvas id="progressTrendsChart"></canvas>
            </div>

            <!-- Workout Types Distribution -->
            <div class="chart-container">
                <h3><?php esc_html_e('Workout Types', 'athlete-dashboard'); ?></h3>
                <canvas id="workoutTypesChart"></canvas>
            </div>

            <!-- Top Exercises -->
            <div class="chart-container">
                <h3><?php esc_html_e('Most Used Exercises', 'athlete-dashboard'); ?></h3>
                <canvas id="topExercisesChart"></canvas>
            </div>
        </div>

        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function() {
                const statsData = <?php echo wp_json_encode($this->prepare_chart_data($stats)); ?>;
                initializeWorkoutCharts(statsData);
            });
        </script>
        <?php
    }

    /**
     * Get date range based on time period
     *
     * @param string $period Time period identifier
     * @return array Date range array
     */
    private function get_date_range($period) {
        $end_date = date('Y-m-d');
        
        switch ($period) {
            case '7_days':
                $start_date = date('Y-m-d', strtotime('-7 days'));
                break;
            case '30_days':
                $start_date = date('Y-m-d', strtotime('-30 days'));
                break;
            case '90_days':
                $start_date = date('Y-m-d', strtotime('-90 days'));
                break;
            case 'year':
                $start_date = date('Y-m-d', strtotime('-1 year'));
                break;
            default:
                $start_date = date('Y-m-d', strtotime('-30 days'));
        }

        return array(
            'start_date' => $start_date,
            'end_date' => $end_date
        );
    }

    /**
     * Prepare chart data from stats
     *
     * @param array $stats Workout statistics
     * @return array Prepared chart data
     */
    private function prepare_chart_data($stats) {
        return array(
            'frequency' => array(
                'labels' => array_keys($stats['workout_frequency']),
                'data' => array_values($stats['workout_frequency'])
            ),
            'trends' => array(
                'labels' => array_keys($stats['progress_trends']['intensity']),
                'intensity' => array_values($stats['progress_trends']['intensity']),
                'duration' => array_values($stats['progress_trends']['duration']),
                'volume' => array_values($stats['progress_trends']['volume'])
            ),
            'types' => array(
                'labels' => array_keys($stats['workout_types']),
                'data' => array_values($stats['workout_types'])
            ),
            'exercises' => array(
                'labels' => array_keys($stats['favorite_exercises']),
                'data' => array_values($stats['favorite_exercises'])
            )
        );
    }

    /**
     * Get formatted date for display
     *
     * @param string $date Date string
     * @return string Formatted date
     */
    private function get_formatted_date($date) {
        return date_i18n(get_option('date_format'), strtotime($date));
    }
} 