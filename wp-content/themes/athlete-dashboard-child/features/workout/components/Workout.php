<?php
/**
 * Main Workout Component
 */

if (!defined('ABSPATH')) {
    exit;
}

class Workout {
    private $api_url;

    public function __construct() {
        $this->api_url = 'https://aiworkoutgenerator.com/api/v1/workouts'; // Replace with actual API URL
        $this->init();
    }

    private function init() {
        add_action('wp_ajax_fetch_workout', array($this, 'fetch_workout'));
        add_action('wp_ajax_nopriv_fetch_workout', array($this, 'fetch_workout'));
    }

    /**
     * Fetch workout data from external API
     */
    public function fetch_workout() {
        $workout_id = isset($_GET['workout_id']) ? sanitize_text_field($_GET['workout_id']) : '';
        $url = isset($_GET['url']) ? esc_url_raw($_GET['url']) : '';

        if (empty($workout_id) && empty($url)) {
            wp_send_json_error('No workout ID or URL provided');
            return;
        }

        // If URL is provided, use that instead of workout ID
        $request_url = !empty($url) ? $url : $this->api_url . '/' . $workout_id;

        $response = wp_remote_get($request_url);

        if (is_wp_error($response)) {
            wp_send_json_error('Failed to fetch workout: ' . $response->get_error_message());
            return;
        }

        $body = wp_remote_retrieve_body($response);
        $workout = json_decode($body);

        if (empty($workout)) {
            wp_send_json_error('Invalid workout data received');
            return;
        }

        wp_send_json_success($workout);
    }

    /**
     * Render workout viewer
     */
    public function render_viewer($url = '') {
        ob_start();
        ?>
        <div class="workout-viewer" data-url="<?php echo esc_attr($url); ?>">
            <div class="workout-header">
                <h2 class="workout-title"></h2>
                <div class="workout-meta"></div>
            </div>
            <div class="workout-content">
                <div class="workout-exercises"></div>
            </div>
            <div class="workout-loading">Loading workout...</div>
            <div class="workout-error" style="display: none;"></div>
        </div>
        <?php
        return ob_get_clean();
    }

    /**
     * Register shortcode
     */
    public function register_shortcode() {
        add_shortcode('workout_viewer', array($this, 'shortcode_callback'));
    }

    /**
     * Shortcode callback
     */
    public function shortcode_callback($atts) {
        $atts = shortcode_atts(array(
            'url' => '',
        ), $atts);

        return $this->render_viewer($atts['url']);
    }
} 