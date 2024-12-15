<?php
/**
 * Nutrition Logger Component Class
 *
 * @package AthleteDashboard
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Athlete_Dashboard_Nutrition_Logger {
    /**
     * Initialize the component
     */
    public function __construct() {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('wp_ajax_save_meal_log', array($this, 'handle_meal_log'));
        add_action('wp_ajax_get_meal_history', array($this, 'get_meal_history'));
    }

    /**
     * Enqueue component-specific scripts
     */
    public function enqueue_scripts() {
        wp_enqueue_script(
            'nutrition-logger',
            ATHLETE_DASHBOARD_URI . '/assets/js/components/nutrition-logger.js',
            array('jquery'),
            filemtime(ATHLETE_DASHBOARD_PATH . '/assets/js/components/nutrition-logger.js'),
            true
        );

        wp_localize_script('nutrition-logger', 'nutritionLoggerData', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('nutrition_logger_nonce'),
            'strings' => array(
                'saveSuccess' => __('Meal logged successfully', 'athlete-dashboard'),
                'saveError' => __('Error logging meal', 'athlete-dashboard'),
                'confirmDelete' => __('Are you sure you want to delete this meal log?', 'athlete-dashboard')
            )
        ));
    }

    /**
     * Render the nutrition logger form
     */
    public function render() {
        include ATHLETE_DASHBOARD_PATH . '/templates/dashboard/sections/nutrition-logger.php';
    }

    /**
     * Handle meal log submission via AJAX
     */
    public function handle_meal_log() {
        check_ajax_referer('nutrition_logger_nonce', 'nonce');

        if (!is_user_logged_in()) {
            wp_send_json_error(__('You must be logged in to log meals', 'athlete-dashboard'));
        }

        $meal_data = $this->validate_meal_data($_POST);
        if (is_wp_error($meal_data)) {
            wp_send_json_error($meal_data->get_error_message());
        }

        $post_data = array(
            'post_title' => $meal_data['title'],
            'post_content' => $meal_data['notes'],
            'post_type' => 'meal_log',
            'post_status' => 'publish',
            'post_author' => get_current_user_id()
        );

        $post_id = wp_insert_post($post_data);
        if (is_wp_error($post_id)) {
            wp_send_json_error($post_id->get_error_message());
        }

        // Save meal meta data
        update_post_meta($post_id, '_meal_date', $meal_data['date']);
        update_post_meta($post_id, '_meal_type', $meal_data['type']);
        update_post_meta($post_id, '_calories', $meal_data['calories']);
        update_post_meta($post_id, '_protein', $meal_data['protein']);
        update_post_meta($post_id, '_carbs', $meal_data['carbs']);
        update_post_meta($post_id, '_fat', $meal_data['fat']);
        
        if (!empty($meal_data['foods'])) {
            update_post_meta($post_id, '_meal_foods', $meal_data['foods']);
        }

        wp_send_json_success(array(
            'message' => __('Meal logged successfully', 'athlete-dashboard'),
            'meal_id' => $post_id
        ));
    }

    /**
     * Get meal history via AJAX
     */
    public function get_meal_history() {
        check_ajax_referer('nutrition_logger_nonce', 'nonce');

        if (!is_user_logged_in()) {
            wp_send_json_error(__('You must be logged in to view meal history', 'athlete-dashboard'));
        }

        $args = array(
            'post_type' => 'meal_log',
            'posts_per_page' => 10,
            'author' => get_current_user_id(),
            'orderby' => 'meta_value',
            'meta_key' => '_meal_date',
            'order' => 'DESC'
        );

        $query = new WP_Query($args);
        $meals = array();

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $meals[] = array(
                    'id' => get_the_ID(),
                    'title' => get_the_title(),
                    'date' => get_post_meta(get_the_ID(), '_meal_date', true),
                    'type' => get_post_meta(get_the_ID(), '_meal_type', true),
                    'calories' => get_post_meta(get_the_ID(), '_calories', true),
                    'protein' => get_post_meta(get_the_ID(), '_protein', true),
                    'carbs' => get_post_meta(get_the_ID(), '_carbs', true),
                    'fat' => get_post_meta(get_the_ID(), '_fat', true),
                    'foods' => get_post_meta(get_the_ID(), '_meal_foods', true),
                    'notes' => get_the_content()
                );
            }
        }
        wp_reset_postdata();

        wp_send_json_success(array(
            'meals' => $meals
        ));
    }

    /**
     * Validate meal data
     *
     * @param array $data Raw meal data
     * @return array|WP_Error Validated data or error
     */
    private function validate_meal_data($data) {
        $required_fields = array(
            'title' => __('Meal Title', 'athlete-dashboard'),
            'date' => __('Date', 'athlete-dashboard'),
            'type' => __('Meal Type', 'athlete-dashboard'),
            'calories' => __('Calories', 'athlete-dashboard')
        );

        $meal_data = array();
        foreach ($required_fields as $field => $label) {
            if (empty($data[$field])) {
                return new WP_Error(
                    'missing_field',
                    sprintf(__('%s is required', 'athlete-dashboard'), $label)
                );
            }
            $meal_data[$field] = sanitize_text_field($data[$field]);
        }

        // Validate and sanitize macros
        $meal_data['protein'] = !empty($data['protein']) ? floatval($data['protein']) : 0;
        $meal_data['carbs'] = !empty($data['carbs']) ? floatval($data['carbs']) : 0;
        $meal_data['fat'] = !empty($data['fat']) ? floatval($data['fat']) : 0;

        // Validate and sanitize foods if present
        if (!empty($data['foods'])) {
            $meal_data['foods'] = array();
            foreach ($data['foods'] as $food) {
                if (!empty($food['name'])) {
                    $meal_data['foods'][] = array(
                        'name' => sanitize_text_field($food['name']),
                        'serving_size' => sanitize_text_field($food['serving_size']),
                        'calories' => floatval($food['calories']),
                        'protein' => floatval($food['protein']),
                        'carbs' => floatval($food['carbs']),
                        'fat' => floatval($food['fat'])
                    );
                }
            }
        }

        $meal_data['notes'] = !empty($data['notes']) ? 
            wp_kses_post($data['notes']) : '';

        return $meal_data;
    }
} 