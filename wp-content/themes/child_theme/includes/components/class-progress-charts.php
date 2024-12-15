<?php
/**
 * Progress Charts Component Class
 * 
 * Handles the visualization of workout statistics and progress data
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Athlete_Dashboard_Progress_Charts {
    /**
     * Stats manager instance
     *
     * @var Athlete_Dashboard_Workout_Stats_Manager
     */
    private $stats_manager;

    /**
     * Progress manager instance
     *
     * @var Athlete_Dashboard_Workout_Progress_Manager
     */
    private $progress_manager;

    /**
     * Initialize the component
     */
    public function __construct() {
        $this->stats_manager = new Athlete_Dashboard_Workout_Stats_Manager();
        $this->progress_manager = new Athlete_Dashboard_Workout_Progress_Manager();

        // Add AJAX handlers
        add_action('wp_ajax_get_progress_data', array($this, 'get_progress_data'));
        add_action('wp_ajax_get_personal_records', array($this, 'get_personal_records'));
    }

    /**
     * Render the progress charts component
     */
    public function render() {
        // Enqueue necessary scripts and styles
        wp_enqueue_script('chart-js',
            'https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js',
            array(),
            '3.7.0',
            true
        );
        
        wp_enqueue_script('athlete-dashboard-charts', 
            get_stylesheet_directory_uri() . '/assets/js/progress-charts.js',
            array('jquery', 'chart-js', 'wp-util'),
            ATHLETE_DASHBOARD_VERSION,
            true
        );

        wp_localize_script('athlete-dashboard-charts', 'athleteDashboardCharts', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('athlete-dashboard-charts'),
            'i18n' => array(
                'loading' => __('Loading...', 'athlete-dashboard'),
                'noData' => __('No data available', 'athlete-dashboard'),
                'volume' => __('Volume', 'athlete-dashboard'),
                'intensity' => __('Intensity', 'athlete-dashboard'),
                'duration' => __('Duration', 'athlete-dashboard')
            )
        ));

        // Get initial data
        $user_id = get_current_user_id();
        $summary = $this->stats_manager->get_summary_stats($user_id, 'month');
        $records = $this->stats_manager->get_personal_records($user_id);

        ?>
        <div class="athlete-dashboard-progress">
            <div class="progress-summary">
                <div class="summary-card total-workouts">
                    <h4><?php _e('Total Workouts', 'athlete-dashboard'); ?></h4>
                    <div class="value"><?php echo esc_html($summary['total_workouts']); ?></div>
                </div>
                <div class="summary-card avg-duration">
                    <h4><?php _e('Average Duration', 'athlete-dashboard'); ?></h4>
                    <div class="value">
                        <?php printf(
                            /* translators: %d: number of minutes */
                            __('%d min', 'athlete-dashboard'),
                            round($summary['avg_duration'])
                        ); ?>
                    </div>
                </div>
                <div class="summary-card avg-intensity">
                    <h4><?php _e('Average Intensity', 'athlete-dashboard'); ?></h4>
                    <div class="value">
                        <?php echo esc_html(number_format($summary['avg_intensity'], 1)); ?>/10
                    </div>
                </div>
                <div class="summary-card total-volume">
                    <h4><?php _e('Total Volume', 'athlete-dashboard'); ?></h4>
                    <div class="value">
                        <?php echo esc_html(number_format($summary['total_volume'])); ?>
                    </div>
                </div>
            </div>

            <div class="progress-charts">
                <div class="chart-container">
                    <h3><?php _e('Progress Over Time', 'athlete-dashboard'); ?></h3>
                    <div class="chart-controls">
                        <select class="metric-selector">
                            <option value="volume"><?php _e('Volume', 'athlete-dashboard'); ?></option>
                            <option value="intensity"><?php _e('Intensity', 'athlete-dashboard'); ?></option>
                            <option value="duration"><?php _e('Duration', 'athlete-dashboard'); ?></option>
                        </select>
                        <select class="period-selector">
                            <option value="week"><?php _e('Last Week', 'athlete-dashboard'); ?></option>
                            <option value="month" selected><?php _e('Last Month', 'athlete-dashboard'); ?></option>
                            <option value="year"><?php _e('Last Year', 'athlete-dashboard'); ?></option>
                        </select>
                    </div>
                    <canvas id="progressChart"></canvas>
                </div>

                <div class="chart-container">
                    <h3><?php _e('Workout Distribution', 'athlete-dashboard'); ?></h3>
                    <div class="distribution-charts">
                        <div class="pie-chart">
                            <h4><?php _e('By Type', 'athlete-dashboard'); ?></h4>
                            <canvas id="typeChart"></canvas>
                        </div>
                        <div class="pie-chart">
                            <h4><?php _e('By Muscle Group', 'athlete-dashboard'); ?></h4>
                            <canvas id="muscleGroupChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="personal-records">
                <h3><?php _e('Personal Records', 'athlete-dashboard'); ?></h3>
                <div class="records-grid">
                    <?php $this->render_personal_records($records); ?>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * AJAX handler for getting progress data
     */
    public function get_progress_data() {
        check_ajax_referer('athlete-dashboard-charts', 'nonce');

        $metric = isset($_POST['metric']) ? sanitize_key($_POST['metric']) : 'volume';
        $period = isset($_POST['period']) ? sanitize_key($_POST['period']) : 'month';
        
        $user_id = get_current_user_id();
        $trends = $this->stats_manager->get_workout_trends($user_id, $metric, $period);
        
        // Format data for Chart.js
        $labels = array();
        $values = array();
        
        foreach ($trends as $date => $data) {
            $labels[] = $date;
            $values[] = $data['value'];
        }

        wp_send_json_success(array(
            'labels' => $labels,
            'values' => $values
        ));
    }

    /**
     * AJAX handler for getting personal records
     */
    public function get_personal_records() {
        check_ajax_referer('athlete-dashboard-charts', 'nonce');

        $user_id = get_current_user_id();
        $records = $this->stats_manager->get_personal_records($user_id);

        ob_start();
        $this->render_personal_records($records);
        $html = ob_get_clean();

        wp_send_json_success(array(
            'html' => $html
        ));
    }

    /**
     * Render personal records
     *
     * @param array $records Personal records data
     */
    private function render_personal_records($records) {
        if (empty($records['max_weights']) && empty($records['max_reps']) && empty($records['max_volume'])) {
            echo '<p class="no-records">' . esc_html__('No personal records yet.', 'athlete-dashboard') . '</p>';
            return;
        }

        // Display max weights
        if (!empty($records['max_weights'])) {
            ?>
            <div class="record-category">
                <h4><?php _e('Max Weights', 'athlete-dashboard'); ?></h4>
                <ul>
                    <?php foreach (array_slice($records['max_weights'], 0, 5) as $exercise => $data) : ?>
                        <li>
                            <span class="exercise"><?php echo esc_html($exercise); ?></span>
                            <span class="value">
                                <?php printf(
                                    /* translators: %s: weight in kg */
                                    __('%s kg', 'athlete-dashboard'),
                                    number_format_i18n($data['value'], 1)
                                ); ?>
                            </span>
                            <span class="date">
                                <?php echo esc_html(date_i18n(get_option('date_format'), strtotime($data['date']))); ?>
                            </span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php
        }

        // Display max reps
        if (!empty($records['max_reps'])) {
            ?>
            <div class="record-category">
                <h4><?php _e('Max Reps', 'athlete-dashboard'); ?></h4>
                <ul>
                    <?php foreach (array_slice($records['max_reps'], 0, 5) as $exercise => $data) : ?>
                        <li>
                            <span class="exercise"><?php echo esc_html($exercise); ?></span>
                            <span class="value">
                                <?php printf(
                                    /* translators: %d: number of reps */
                                    __('%d reps', 'athlete-dashboard'),
                                    $data['value']
                                ); ?>
                            </span>
                            <span class="date">
                                <?php echo esc_html(date_i18n(get_option('date_format'), strtotime($data['date']))); ?>
                            </span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php
        }

        // Display max volume
        if (!empty($records['max_volume'])) {
            ?>
            <div class="record-category">
                <h4><?php _e('Max Volume', 'athlete-dashboard'); ?></h4>
                <ul>
                    <?php foreach (array_slice($records['max_volume'], 0, 5) as $exercise => $data) : ?>
                        <li>
                            <span class="exercise"><?php echo esc_html($exercise); ?></span>
                            <span class="value">
                                <?php echo esc_html(number_format($data['value'])); ?>
                            </span>
                            <span class="date">
                                <?php echo esc_html(date_i18n(get_option('date_format'), strtotime($data['date']))); ?>
                            </span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php
        }
    }
} 