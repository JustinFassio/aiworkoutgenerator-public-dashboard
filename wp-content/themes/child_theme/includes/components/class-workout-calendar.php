<?php
/**
 * Workout Calendar Component Class
 * 
 * Handles the display and interaction of workout schedules and logs
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Athlete_Dashboard_Workout_Calendar {
    /**
     * Progress manager instance
     *
     * @var Athlete_Dashboard_Workout_Progress_Manager
     */
    private $progress_manager;

    /**
     * Stats manager instance
     *
     * @var Athlete_Dashboard_Workout_Stats_Manager
     */
    private $stats_manager;

    /**
     * Initialize the component
     */
    public function __construct() {
        $this->progress_manager = new Athlete_Dashboard_Workout_Progress_Manager();
        $this->stats_manager = new Athlete_Dashboard_Workout_Stats_Manager();

        // Add AJAX handlers
        add_action('wp_ajax_get_calendar_data', array($this, 'get_calendar_data'));
        add_action('wp_ajax_get_day_details', array($this, 'get_day_details'));
    }

    /**
     * Render the calendar component
     */
    public function render() {
        // Enqueue necessary scripts and styles
        wp_enqueue_script('athlete-dashboard-calendar', 
            get_stylesheet_directory_uri() . '/assets/js/calendar.js',
            array('jquery', 'wp-util'),
            ATHLETE_DASHBOARD_VERSION,
            true
        );

        wp_localize_script('athlete-dashboard-calendar', 'athleteDashboardCalendar', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('athlete-dashboard-calendar'),
            'i18n' => array(
                'loading' => __('Loading...', 'athlete-dashboard'),
                'noWorkouts' => __('No workouts scheduled', 'athlete-dashboard'),
                'viewDetails' => __('View Details', 'athlete-dashboard')
            )
        ));

        // Get initial data
        $user_id = get_current_user_id();
        $streaks = $this->progress_manager->get_workout_streaks($user_id);
        $frequency = $this->stats_manager->get_workout_frequency($user_id, 'month');

        // Render calendar container
        ?>
        <div class="athlete-dashboard-calendar">
            <div class="calendar-header">
                <div class="streak-info">
                    <span class="current-streak">
                        <?php printf(
                            /* translators: %d: number of days */
                            __('Current Streak: %d days', 'athlete-dashboard'),
                            $streaks['current_streak']
                        ); ?>
                    </span>
                    <span class="longest-streak">
                        <?php printf(
                            /* translators: %d: number of days */
                            __('Longest Streak: %d days', 'athlete-dashboard'),
                            $streaks['longest_streak']
                        ); ?>
                    </span>
                </div>
                <div class="calendar-navigation">
                    <button class="prev-month" aria-label="<?php esc_attr_e('Previous month', 'athlete-dashboard'); ?>">
                        &larr;
                    </button>
                    <span class="current-month"></span>
                    <button class="next-month" aria-label="<?php esc_attr_e('Next month', 'athlete-dashboard'); ?>">
                        &rarr;
                    </button>
                </div>
            </div>

            <div class="calendar-grid">
                <div class="calendar-weekdays">
                    <?php
                    $weekdays = array(
                        __('Sun', 'athlete-dashboard'),
                        __('Mon', 'athlete-dashboard'),
                        __('Tue', 'athlete-dashboard'),
                        __('Wed', 'athlete-dashboard'),
                        __('Thu', 'athlete-dashboard'),
                        __('Fri', 'athlete-dashboard'),
                        __('Sat', 'athlete-dashboard')
                    );
                    foreach ($weekdays as $day) {
                        echo '<div class="weekday">' . esc_html($day) . '</div>';
                    }
                    ?>
                </div>
                <div class="calendar-days"></div>
            </div>

            <div class="workout-details-modal" style="display: none;">
                <div class="modal-content">
                    <button class="close-modal" aria-label="<?php esc_attr_e('Close', 'athlete-dashboard'); ?>">&times;</button>
                    <div class="workout-details-content"></div>
                </div>
            </div>

            <div class="calendar-stats">
                <h3><?php _e('Workout Frequency', 'athlete-dashboard'); ?></h3>
                <div class="frequency-chart">
                    <?php $this->render_frequency_chart($frequency); ?>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * AJAX handler for getting calendar data
     */
    public function get_calendar_data() {
        check_ajax_referer('athlete-dashboard-calendar', 'nonce');

        $year = isset($_POST['year']) ? intval($_POST['year']) : date('Y');
        $month = isset($_POST['month']) ? intval($_POST['month']) : date('n');

        $user_id = get_current_user_id();
        $logs = $this->progress_manager->get_workout_logs($user_id, array(
            'date_query' => array(
                array(
                    'year' => $year,
                    'month' => $month
                )
            )
        ));

        $calendar_data = array();
        foreach ($logs as $log) {
            $date = get_post_meta($log->ID, '_workout_date', true);
            $workout_id = get_post_meta($log->ID, '_workout_id', true);
            $workout = get_post($workout_id);

            $calendar_data[date('Y-m-d', strtotime($date))] = array(
                'id' => $log->ID,
                'title' => $workout ? $workout->post_title : __('Unknown Workout', 'athlete-dashboard'),
                'completed' => true
            );
        }

        wp_send_json_success($calendar_data);
    }

    /**
     * AJAX handler for getting day details
     */
    public function get_day_details() {
        check_ajax_referer('athlete-dashboard-calendar', 'nonce');

        $log_id = isset($_POST['log_id']) ? intval($_POST['log_id']) : 0;
        if (!$log_id) {
            wp_send_json_error(__('Invalid workout log ID', 'athlete-dashboard'));
        }

        $log_details = $this->progress_manager->get_log_details($log_id);
        if (is_wp_error($log_details)) {
            wp_send_json_error($log_details->get_error_message());
        }

        ob_start();
        $this->render_workout_details($log_details);
        $html = ob_get_clean();

        wp_send_json_success(array(
            'html' => $html
        ));
    }

    /**
     * Render workout frequency chart
     *
     * @param array $frequency Frequency data
     */
    private function render_frequency_chart($frequency) {
        $max_weekday = max($frequency['weekday']);
        $weekdays = array(
            __('Sun', 'athlete-dashboard'),
            __('Mon', 'athlete-dashboard'),
            __('Tue', 'athlete-dashboard'),
            __('Wed', 'athlete-dashboard'),
            __('Thu', 'athlete-dashboard'),
            __('Fri', 'athlete-dashboard'),
            __('Sat', 'athlete-dashboard')
        );

        echo '<div class="weekday-frequency">';
        foreach ($frequency['weekday'] as $day => $count) {
            $height = $max_weekday > 0 ? ($count / $max_weekday) * 100 : 0;
            echo '<div class="frequency-bar">';
            echo '<div class="bar" style="height: ' . esc_attr($height) . '%"></div>';
            echo '<div class="label">' . esc_html($weekdays[$day]) . '</div>';
            echo '</div>';
        }
        echo '</div>';
    }

    /**
     * Render workout details
     *
     * @param array $log_details Workout log details
     */
    private function render_workout_details($log_details) {
        $workout = get_post($log_details['workout_id']);
        if (!$workout) {
            return;
        }

        ?>
        <div class="workout-log-details">
            <h3><?php echo esc_html($workout->post_title); ?></h3>
            <div class="workout-meta">
                <p>
                    <strong><?php _e('Date:', 'athlete-dashboard'); ?></strong>
                    <?php echo esc_html(date_i18n(get_option('date_format'), strtotime($log_details['date']))); ?>
                </p>
                <p>
                    <strong><?php _e('Duration:', 'athlete-dashboard'); ?></strong>
                    <?php printf(
                        /* translators: %d: number of minutes */
                        __('%d minutes', 'athlete-dashboard'),
                        $log_details['duration']
                    ); ?>
                </p>
                <p>
                    <strong><?php _e('Intensity:', 'athlete-dashboard'); ?></strong>
                    <?php echo esc_html($log_details['intensity']); ?>/10
                </p>
            </div>

            <?php if (!empty($log_details['completed_exercises'])) : ?>
                <div class="completed-exercises">
                    <h4><?php _e('Completed Exercises', 'athlete-dashboard'); ?></h4>
                    <ul>
                        <?php foreach ($log_details['completed_exercises'] as $exercise) : ?>
                            <li>
                                <strong><?php echo esc_html($exercise['name']); ?></strong>
                                <span class="exercise-details">
                                    <?php printf(
                                        /* translators: 1: sets, 2: reps, 3: weight */
                                        __('%1$d sets × %2$d reps @ %3$s kg', 'athlete-dashboard'),
                                        $exercise['sets_completed'],
                                        $exercise['reps_completed'],
                                        number_format_i18n($exercise['weight_used'], 1)
                                    ); ?>
                                </span>
                                <?php if (!empty($exercise['notes'])) : ?>
                                    <div class="exercise-notes">
                                        <?php echo esc_html($exercise['notes']); ?>
                                    </div>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if (!empty($log_details['notes'])) : ?>
                <div class="workout-notes">
                    <h4><?php _e('Workout Notes', 'athlete-dashboard'); ?></h4>
                    <p><?php echo esc_html($log_details['notes']); ?></p>
                </div>
            <?php endif; ?>
        </div>
        <?php
    }
} 