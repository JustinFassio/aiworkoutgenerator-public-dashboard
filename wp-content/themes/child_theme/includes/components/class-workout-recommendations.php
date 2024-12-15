<?php
/**
 * Workout Recommendations Component Class
 * 
 * Provides personalized workout suggestions based on user data and preferences
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Athlete_Dashboard_Workout_Recommendations {
    /**
     * Workout data manager instance
     *
     * @var Athlete_Dashboard_Workout_Data_Manager
     */
    private $workout_manager;

    /**
     * Exercise data manager instance
     *
     * @var Athlete_Dashboard_Exercise_Data_Manager
     */
    private $exercise_manager;

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
        $this->workout_manager = new Athlete_Dashboard_Workout_Data_Manager();
        $this->exercise_manager = new Athlete_Dashboard_Exercise_Data_Manager();
        $this->stats_manager = new Athlete_Dashboard_Workout_Stats_Manager();

        // Add AJAX handlers
        add_action('wp_ajax_get_workout_recommendations', array($this, 'get_workout_recommendations'));
        add_action('wp_ajax_get_exercise_recommendations', array($this, 'get_exercise_recommendations'));
    }

    /**
     * Render the recommendations component
     */
    public function render() {
        // Enqueue necessary scripts and styles
        wp_enqueue_script('athlete-dashboard-recommendations', 
            get_stylesheet_directory_uri() . '/assets/js/recommendations.js',
            array('jquery', 'wp-util'),
            ATHLETE_DASHBOARD_VERSION,
            true
        );

        wp_localize_script('athlete-dashboard-recommendations', 'athleteDashboardRecommendations', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('athlete-dashboard-recommendations'),
            'i18n' => array(
                'loading' => __('Loading recommendations...', 'athlete-dashboard'),
                'noRecommendations' => __('No recommendations available', 'athlete-dashboard'),
                'tryWorkout' => __('Try this workout', 'athlete-dashboard')
            )
        ));

        // Get initial recommendations
        $user_id = get_current_user_id();
        $workout_recommendations = $this->workout_manager->get_recommended_workouts($user_id);
        $exercise_recommendations = $this->exercise_manager->get_exercise_recommendations($user_id);
        $summary = $this->stats_manager->get_summary_stats($user_id, 'month');

        ?>
        <div class="athlete-dashboard-recommendations">
            <div class="recommendations-header">
                <h3><?php _e('Personalized Recommendations', 'athlete-dashboard'); ?></h3>
                <p class="recommendation-intro">
                    <?php
                    if ($summary['total_workouts'] > 0) {
                        printf(
                            /* translators: %d: number of workouts */
                            __('Based on your %d workouts this month, here are some recommendations to help you progress:', 'athlete-dashboard'),
                            $summary['total_workouts']
                        );
                    } else {
                        _e('Get started with these recommended workouts:', 'athlete-dashboard');
                    }
                    ?>
                </p>
            </div>

            <div class="recommendations-grid">
                <div class="recommended-workouts">
                    <h4><?php _e('Recommended Workouts', 'athlete-dashboard'); ?></h4>
                    <?php $this->render_workout_recommendations($workout_recommendations); ?>
                </div>

                <div class="recommended-exercises">
                    <h4><?php _e('Exercises to Try', 'athlete-dashboard'); ?></h4>
                    <?php $this->render_exercise_recommendations($exercise_recommendations); ?>
                </div>
            </div>

            <div class="workout-preview-modal" style="display: none;">
                <div class="modal-content">
                    <button class="close-modal" aria-label="<?php esc_attr_e('Close', 'athlete-dashboard'); ?>">&times;</button>
                    <div class="workout-preview-content"></div>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * AJAX handler for getting workout recommendations
     */
    public function get_workout_recommendations() {
        check_ajax_referer('athlete-dashboard-recommendations', 'nonce');

        $user_id = get_current_user_id();
        $recommendations = $this->workout_manager->get_recommended_workouts($user_id);

        ob_start();
        $this->render_workout_recommendations($recommendations);
        $html = ob_get_clean();

        wp_send_json_success(array(
            'html' => $html
        ));
    }

    /**
     * AJAX handler for getting exercise recommendations
     */
    public function get_exercise_recommendations() {
        check_ajax_referer('athlete-dashboard-recommendations', 'nonce');

        $user_id = get_current_user_id();
        $recommendations = $this->exercise_manager->get_exercise_recommendations($user_id);

        ob_start();
        $this->render_exercise_recommendations($recommendations);
        $html = ob_get_clean();

        wp_send_json_success(array(
            'html' => $html
        ));
    }

    /**
     * Render workout recommendations
     *
     * @param array $recommendations Array of recommended workouts
     */
    private function render_workout_recommendations($recommendations) {
        if (empty($recommendations)) {
            echo '<p class="no-recommendations">' . esc_html__('No workout recommendations available yet.', 'athlete-dashboard') . '</p>';
            return;
        }

        echo '<div class="workout-recommendations">';
        foreach ($recommendations as $workout) {
            $categories = wp_get_post_terms($workout->ID, 'exercise_category', array('fields' => 'names'));
            $muscle_groups = wp_get_post_terms($workout->ID, 'exercise_muscle_group', array('fields' => 'names'));
            $difficulty = wp_get_post_terms($workout->ID, 'exercise_difficulty', array('fields' => 'names'));
            
            ?>
            <div class="workout-card" data-workout-id="<?php echo esc_attr($workout->ID); ?>">
                <h5 class="workout-title"><?php echo esc_html($workout->post_title); ?></h5>
                
                <div class="workout-meta">
                    <?php if (!empty($categories)) : ?>
                        <span class="workout-category">
                            <?php echo esc_html(implode(', ', $categories)); ?>
                        </span>
                    <?php endif; ?>
                    
                    <?php if (!empty($difficulty)) : ?>
                        <span class="workout-difficulty">
                            <?php echo esc_html($difficulty[0]); ?>
                        </span>
                    <?php endif; ?>
                </div>

                <div class="workout-details">
                    <p class="workout-description">
                        <?php echo wp_trim_words($workout->post_content, 20); ?>
                    </p>
                    
                    <?php if (!empty($muscle_groups)) : ?>
                        <div class="workout-muscle-groups">
                            <strong><?php _e('Target Areas:', 'athlete-dashboard'); ?></strong>
                            <?php echo esc_html(implode(', ', $muscle_groups)); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="workout-actions">
                    <button class="preview-workout" data-workout-id="<?php echo esc_attr($workout->ID); ?>">
                        <?php _e('Preview', 'athlete-dashboard'); ?>
                    </button>
                    <a href="<?php echo esc_url(get_permalink($workout->ID)); ?>" class="start-workout">
                        <?php _e('Start Workout', 'athlete-dashboard'); ?>
                    </a>
                </div>
            </div>
            <?php
        }
        echo '</div>';
    }

    /**
     * Render exercise recommendations
     *
     * @param array $recommendations Array of recommended exercises
     */
    private function render_exercise_recommendations($recommendations) {
        if (empty($recommendations)) {
            echo '<p class="no-recommendations">' . esc_html__('No exercise recommendations available yet.', 'athlete-dashboard') . '</p>';
            return;
        }

        echo '<div class="exercise-recommendations">';
        foreach ($recommendations as $exercise) {
            ?>
            <div class="exercise-card">
                <h5 class="exercise-name"><?php echo esc_html($exercise['name']); ?></h5>
                
                <div class="exercise-meta">
                    <?php if (!empty($exercise['muscle_groups'])) : ?>
                        <span class="muscle-groups">
                            <?php echo esc_html(implode(', ', $exercise['muscle_groups'])); ?>
                        </span>
                    <?php endif; ?>
                    
                    <?php if (!empty($exercise['equipment'])) : ?>
                        <span class="equipment">
                            <?php echo esc_html(implode(', ', $exercise['equipment'])); ?>
                        </span>
                    <?php endif; ?>
                </div>

                <div class="exercise-details">
                    <?php if (!empty($exercise['description'])) : ?>
                        <p class="exercise-description">
                            <?php echo wp_trim_words($exercise['description'], 15); ?>
                        </p>
                    <?php endif; ?>

                    <div class="recommended-routine">
                        <strong><?php _e('Suggested:', 'athlete-dashboard'); ?></strong>
                        <?php
                        printf(
                            /* translators: 1: sets, 2: reps */
                            __('%1$d sets × %2$d reps', 'athlete-dashboard'),
                            $exercise['suggested_sets'],
                            $exercise['suggested_reps']
                        );
                        ?>
                    </div>
                </div>

                <?php if (!empty($exercise['tips'])) : ?>
                    <div class="exercise-tips">
                        <strong><?php _e('Tips:', 'athlete-dashboard'); ?></strong>
                        <ul>
                            <?php foreach ($exercise['tips'] as $tip) : ?>
                                <li><?php echo esc_html($tip); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
            <?php
        }
        echo '</div>';
    }
} 