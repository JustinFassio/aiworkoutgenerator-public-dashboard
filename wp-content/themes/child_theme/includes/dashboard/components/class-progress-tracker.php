<?php
/**
 * Progress Tracker Component Class
 * 
 * Handles workout progress tracking and visualization in the dashboard
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Athlete_Dashboard_Progress_Tracker {
    /**
     * The progress manager instance
     *
     * @var Athlete_Dashboard_Workout_Progress_Manager
     */
    private $progress_manager;

    /**
     * The workout manager instance
     *
     * @var Athlete_Dashboard_Workout_Data_Manager
     */
    private $workout_manager;

    /**
     * Initialize the component
     */
    public function __construct() {
        $this->progress_manager = new Athlete_Dashboard_Workout_Progress_Manager();
        $this->workout_manager = new Athlete_Dashboard_Workout_Data_Manager();
        $this->init_hooks();
    }

    /**
     * Initialize WordPress hooks
     */
    private function init_hooks() {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_assets'));
        add_action('athlete_dashboard_progress_tracker', array($this, 'render_progress_tracker'));
        add_action('wp_ajax_update_workout_progress', array($this, 'handle_progress_update'));
    }

    /**
     * Enqueue necessary assets
     */
    public function enqueue_assets() {
        if (!is_page('dashboard')) {
            return;
        }

        wp_enqueue_style(
            'progress-tracker',
            get_stylesheet_directory_uri() . '/assets/css/components/progress-tracker.css',
            array(),
            ATHLETE_DASHBOARD_VERSION
        );

        wp_enqueue_script(
            'progress-tracker',
            get_stylesheet_directory_uri() . '/assets/js/components/progress-tracker.js',
            array('jquery'),
            ATHLETE_DASHBOARD_VERSION,
            true
        );

        wp_localize_script('progress-tracker', 'progressTrackerData', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('workout_progress_nonce'),
            'i18n' => array(
                'saved' => __('Progress saved successfully', 'athlete-dashboard'),
                'error' => __('Error saving progress', 'athlete-dashboard'),
                'confirm' => __('Are you sure you want to clear this progress?', 'athlete-dashboard')
            )
        ));
    }

    /**
     * Render the progress tracker
     *
     * @param array $args Optional display arguments
     */
    public function render_progress_tracker($args = array()) {
        $default_args = array(
            'workout_id' => 0,
            'show_history' => true
        );

        $args = wp_parse_args($args, $default_args);
        $user_id = get_current_user_id();

        if (!$args['workout_id']) {
            return;
        }

        $workout = $this->workout_manager->get_workout($args['workout_id']);
        if (!$workout) {
            return;
        }

        $progress = $this->progress_manager->get_workout_progress($user_id, $args['workout_id']);
        if (is_wp_error($progress)) {
            $progress = array();
        }

        $this->render_progress_form($workout, $progress);

        if ($args['show_history']) {
            $this->render_progress_history($user_id, $args['workout_id']);
        }
    }

    /**
     * Render the progress tracking form
     *
     * @param array $workout Workout data
     * @param array $progress Current progress data
     */
    private function render_progress_form($workout, $progress) {
        ?>
        <div class="progress-tracker" data-workout-id="<?php echo esc_attr($workout['id']); ?>">
            <h3><?php esc_html_e('Track Your Progress', 'athlete-dashboard'); ?></h3>
            
            <form class="progress-form" id="workout-progress-form">
                <?php wp_nonce_field('workout_progress_nonce'); ?>
                <input type="hidden" name="workout_id" value="<?php echo esc_attr($workout['id']); ?>">

                <!-- Exercise Progress Section -->
                <div class="exercise-progress-section">
                    <h4><?php esc_html_e('Exercises', 'athlete-dashboard'); ?></h4>
                    <?php foreach ($workout['exercises'] as $exercise): ?>
                        <div class="exercise-progress" data-exercise-id="<?php echo esc_attr($exercise['id']); ?>">
                            <h5><?php echo esc_html($exercise['name']); ?></h5>
                            
                            <div class="exercise-inputs">
                                <div class="input-group">
                                    <label><?php esc_html_e('Sets', 'athlete-dashboard'); ?></label>
                                    <input type="number" 
                                           name="exercises[<?php echo esc_attr($exercise['id']); ?>][sets_completed]" 
                                           value="<?php echo esc_attr($this->get_exercise_progress_value($progress, $exercise['id'], 'sets_completed')); ?>"
                                           min="0"
                                           class="small-input">
                                    <span class="target">/ <?php echo esc_html($exercise['sets']); ?></span>
                                </div>

                                <div class="input-group">
                                    <label><?php esc_html_e('Reps', 'athlete-dashboard'); ?></label>
                                    <input type="number" 
                                           name="exercises[<?php echo esc_attr($exercise['id']); ?>][reps_completed]" 
                                           value="<?php echo esc_attr($this->get_exercise_progress_value($progress, $exercise['id'], 'reps_completed')); ?>"
                                           min="0"
                                           class="small-input">
                                    <span class="target">/ <?php echo esc_html($exercise['reps']); ?></span>
                                </div>

                                <div class="input-group">
                                    <label><?php esc_html_e('Weight (kg)', 'athlete-dashboard'); ?></label>
                                    <input type="number" 
                                           name="exercises[<?php echo esc_attr($exercise['id']); ?>][weight_used]" 
                                           value="<?php echo esc_attr($this->get_exercise_progress_value($progress, $exercise['id'], 'weight_used')); ?>"
                                           min="0"
                                           step="0.5"
                                           class="small-input">
                                </div>
                            </div>

                            <div class="notes-input">
                                <label><?php esc_html_e('Notes', 'athlete-dashboard'); ?></label>
                                <textarea name="exercises[<?php echo esc_attr($exercise['id']); ?>][notes]"
                                          rows="2"><?php echo esc_textarea($this->get_exercise_progress_value($progress, $exercise['id'], 'notes')); ?></textarea>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Overall Progress Section -->
                <div class="overall-progress-section">
                    <h4><?php esc_html_e('Overall Progress', 'athlete-dashboard'); ?></h4>
                    
                    <div class="input-group">
                        <label><?php esc_html_e('Duration (minutes)', 'athlete-dashboard'); ?></label>
                        <input type="number" 
                               name="duration" 
                               value="<?php echo esc_attr($progress['duration'] ?? ''); ?>"
                               min="0"
                               class="medium-input">
                    </div>

                    <div class="input-group">
                        <label><?php esc_html_e('Intensity (1-10)', 'athlete-dashboard'); ?></label>
                        <input type="range" 
                               name="intensity" 
                               value="<?php echo esc_attr($progress['intensity'] ?? 5); ?>"
                               min="1"
                               max="10"
                               class="intensity-slider">
                        <span class="intensity-value"></span>
                    </div>

                    <div class="notes-input">
                        <label><?php esc_html_e('Workout Notes', 'athlete-dashboard'); ?></label>
                        <textarea name="notes" rows="3"><?php echo esc_textarea($progress['notes'] ?? ''); ?></textarea>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="button button-primary save-progress">
                        <?php esc_html_e('Save Progress', 'athlete-dashboard'); ?>
                    </button>
                    
                    <?php if (!empty($progress)): ?>
                        <button type="button" class="button clear-progress">
                            <?php esc_html_e('Clear Progress', 'athlete-dashboard'); ?>
                        </button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
        <?php
    }

    /**
     * Render the progress history section
     *
     * @param int $user_id User ID
     * @param int $workout_id Workout ID
     */
    private function render_progress_history($user_id, $workout_id) {
        $history = $this->progress_manager->get_workout_progress_history($user_id, array(
            'workout_id' => $workout_id,
            'limit' => 5
        ));

        if (empty($history)) {
            return;
        }
        ?>
        <div class="progress-history">
            <h3><?php esc_html_e('Recent Progress', 'athlete-dashboard'); ?></h3>
            
            <div class="history-entries">
                <?php foreach ($history as $entry): ?>
                    <div class="history-entry">
                        <div class="entry-date">
                            <?php echo esc_html($this->get_formatted_date($entry['last_updated'])); ?>
                        </div>
                        
                        <div class="entry-stats">
                            <span class="duration">
                                <?php 
                                /* translators: %d: number of minutes */
                                printf(esc_html__('%d min', 'athlete-dashboard'), $entry['duration']); 
                                ?>
                            </span>
                            <span class="intensity">
                                <?php 
                                /* translators: %d: intensity value */
                                printf(esc_html__('Intensity: %d/10', 'athlete-dashboard'), $entry['intensity']); 
                                ?>
                            </span>
                        </div>

                        <?php if (!empty($entry['notes'])): ?>
                            <div class="entry-notes">
                                <?php echo esc_html($entry['notes']); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
    }

    /**
     * Handle progress update AJAX request
     */
    public function handle_progress_update() {
        check_ajax_referer('workout_progress_nonce');
        
        if (!is_user_logged_in()) {
            wp_send_json_error(__('User not logged in', 'athlete-dashboard'));
            return;
        }

        $user_id = get_current_user_id();
        $workout_id = isset($_POST['workout_id']) ? absint($_POST['workout_id']) : 0;

        if (!$workout_id) {
            wp_send_json_error(__('Invalid workout ID', 'athlete-dashboard'));
            return;
        }

        // Build progress data from form submission
        $progress_data = array(
            'workout_id' => $workout_id,
            'duration' => isset($_POST['duration']) ? absint($_POST['duration']) : 0,
            'intensity' => isset($_POST['intensity']) ? absint($_POST['intensity']) : 5,
            'notes' => isset($_POST['notes']) ? sanitize_textarea_field($_POST['notes']) : '',
            'completed_exercises' => array()
        );

        // Process exercise data
        if (isset($_POST['exercises']) && is_array($_POST['exercises'])) {
            foreach ($_POST['exercises'] as $exercise_id => $exercise_data) {
                $progress_data['completed_exercises'][] = array(
                    'id' => absint($exercise_id),
                    'sets_completed' => isset($exercise_data['sets_completed']) ? absint($exercise_data['sets_completed']) : 0,
                    'reps_completed' => isset($exercise_data['reps_completed']) ? absint($exercise_data['reps_completed']) : 0,
                    'weight_used' => isset($exercise_data['weight_used']) ? floatval($exercise_data['weight_used']) : 0,
                    'notes' => isset($exercise_data['notes']) ? sanitize_textarea_field($exercise_data['notes']) : ''
                );
            }
        }

        $result = $this->progress_manager->save_workout_progress($user_id, $progress_data);
        
        if (is_wp_error($result)) {
            wp_send_json_error($result->get_error_message());
        } else {
            wp_send_json_success($result);
        }
    }

    /**
     * Get a specific value from exercise progress data
     *
     * @param array $progress Progress data
     * @param int $exercise_id Exercise ID
     * @param string $field Field name
     * @return mixed Field value or empty string if not found
     */
    private function get_exercise_progress_value($progress, $exercise_id, $field) {
        if (empty($progress['completed_exercises'])) {
            return '';
        }

        foreach ($progress['completed_exercises'] as $exercise) {
            if ($exercise['id'] == $exercise_id && isset($exercise[$field])) {
                return $exercise[$field];
            }
        }

        return '';
    }

    /**
     * Get formatted date for display
     *
     * @param string $date Date string
     * @return string Formatted date
     */
    private function get_formatted_date($date) {
        return date_i18n(get_option('date_format') . ' ' . get_option('time_format'), strtotime($date));
    }
} 