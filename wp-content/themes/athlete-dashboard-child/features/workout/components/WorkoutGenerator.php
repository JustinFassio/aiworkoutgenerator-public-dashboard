<?php
/**
 * Workout Generator Component
 */

if (!defined('ABSPATH')) {
    exit;
}

class WorkoutGenerator {
    private $api_endpoint = 'https://aiworkoutgenerator.com/api/v1/generate'; // Replace with actual API endpoint
    private $api_key; // Store this securely in WordPress options

    public function __construct() {
        $this->api_key = get_option('workout_generator_api_key');
        add_action('wp_ajax_generate_workout', array($this, 'generate_workout'));
    }

    public function generate_workout() {
        check_ajax_referer('workout_generator_nonce', 'nonce');

        if (!is_user_logged_in()) {
            wp_send_json_error('User not logged in');
            return;
        }

        // Get user profile data
        $profile = new Profile();
        $profile_data = $profile->get_profile_data();

        // Validate profile completeness
        if (!$this->validate_profile($profile_data)) {
            wp_send_json_error('Please complete your profile before generating a workout');
            return;
        }

        // Build the prompt template
        $prompt = $this->build_prompt($profile_data);

        // Make API request
        $response = $this->make_api_request($prompt);

        if (is_wp_error($response)) {
            wp_send_json_error('Failed to generate workout: ' . $response->get_error_message());
            return;
        }

        // Save the generated workout
        $workout_id = $this->save_workout($response['workout']);

        wp_send_json_success(array(
            'workout_id' => $workout_id,
            'workout' => $response['workout']
        ));
    }

    private function validate_profile($profile_data) {
        $required_fields = array('age', 'gender', 'height', 'weight', 'primary_goal', 
                               'activity_level', 'preferred_intensity', 'equipment_access');
        
        foreach ($required_fields as $field) {
            if (empty($profile_data[$field])) {
                return false;
            }
        }
        return true;
    }

    private function build_prompt($profile_data) {
        return array(
            'user_profile' => array(
                'age' => intval($profile_data['age']),
                'gender' => $profile_data['gender'],
                'height_cm' => intval($profile_data['height']),
                'weight_kg' => intval($profile_data['weight']),
                'goal' => $profile_data['primary_goal'],
                'activity_level' => $profile_data['activity_level'],
                'intensity' => $profile_data['preferred_intensity'],
                'equipment' => explode(',', $profile_data['equipment_access'])
            ),
            'workout_preferences' => array(
                'duration_minutes' => 60, // Default duration
                'days_per_week' => 3,     // Default frequency
                'format' => 'structured'   // Default format
            )
        );
    }

    private function make_api_request($prompt) {
        if (empty($this->api_key)) {
            return new WP_Error('api_key_missing', 'API key is not configured');
        }

        $response = wp_remote_post($this->api_endpoint, array(
            'headers' => array(
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->api_key
            ),
            'body' => json_encode($prompt),
            'timeout' => 30
        ));

        if (is_wp_error($response)) {
            return $response;
        }

        $body = json_decode(wp_remote_retrieve_body($response), true);

        if (!$body || isset($body['error'])) {
            return new WP_Error(
                'api_error',
                isset($body['error']) ? $body['error'] : 'Unknown API error'
            );
        }

        return $body;
    }

    private function save_workout($workout_data) {
        // Create a new post for the workout
        $workout_post = array(
            'post_title'   => 'Generated Workout - ' . current_time('mysql'),
            'post_content' => wp_json_encode($workout_data),
            'post_status'  => 'publish',
            'post_type'    => 'workout',
            'post_author'  => get_current_user_id()
        );

        $post_id = wp_insert_post($workout_post);

        if (is_wp_error($post_id)) {
            return false;
        }

        // Save additional workout metadata
        update_post_meta($post_id, '_workout_generated_date', current_time('mysql'));
        update_post_meta($post_id, '_workout_type', 'ai_generated');

        return $post_id;
    }

    public function render_generator_form() {
        ob_start();
        ?>
        <div class="workout-generator">
            <h3><?php echo esc_html__('Generate Custom Workout', 'athlete-dashboard-child'); ?></h3>
            <p><?php echo esc_html__('Click below to generate a personalized workout based on your profile.', 'athlete-dashboard-child'); ?></p>
            
            <?php wp_nonce_field('workout_generator_nonce', 'workout_generator_nonce'); ?>
            
            <button id="generate-workout" class="generate-workout-btn">
                <?php echo esc_html__('Generate Workout', 'athlete-dashboard-child'); ?>
            </button>
            
            <div id="workout-result" class="workout-result" style="display: none;">
                <!-- Generated workout will be displayed here -->
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
} 