<?php
/**
 * Progress Tracker Component Class
 *
 * @package AthleteDashboard
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Athlete_Dashboard_Progress_Tracker {
    /**
     * The type of progress being tracked
     *
     * @var string
     */
    private $type;

    /**
     * Initialize the component
     *
     * @param string $type The type of progress (e.g., 'body_weight', 'squat', 'bench_press')
     */
    public function __construct($type) {
        $this->type = $type;
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('wp_ajax_get_progress_data', array($this, 'get_progress_data'));
        add_action('wp_ajax_save_progress_entry', array($this, 'save_progress_entry'));
        add_action('wp_ajax_delete_progress_entry', array($this, 'delete_progress_entry'));
    }

    /**
     * Enqueue component-specific scripts
     */
    public function enqueue_scripts() {
        wp_enqueue_script(
            'progress-tracker',
            ATHLETE_DASHBOARD_URI . '/assets/js/components/progress-tracker.js',
            array('jquery', 'chartjs'),
            filemtime(ATHLETE_DASHBOARD_PATH . '/assets/js/components/progress-tracker.js'),
            true
        );

        wp_localize_script('progress-tracker', 'progressTrackerData', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('progress_tracker_nonce'),
            'type' => $this->type,
            'strings' => array(
                'saveSuccess' => __('Progress entry saved successfully', 'athlete-dashboard'),
                'saveError' => __('Error saving progress entry', 'athlete-dashboard'),
                'deleteSuccess' => __('Progress entry deleted successfully', 'athlete-dashboard'),
                'deleteError' => __('Error deleting progress entry', 'athlete-dashboard'),
                'confirmDelete' => __('Are you sure you want to delete this entry?', 'athlete-dashboard')
            )
        ));
    }

    /**
     * Render the progress tracker
     */
    public function render() {
        $template_data = array(
            'title' => $this->get_title(),
            'chart_id' => $this->type . '_chart',
            'form_id' => $this->type . '_form',
            'weight_field_name' => $this->type . '_weight',
            'weight_unit_field_name' => $this->type . '_unit',
            'nonce_name' => $this->type . '_nonce'
        );

        // Extract template data to make variables available in template
        extract($template_data);

        include ATHLETE_DASHBOARD_PATH . '/templates/dashboard/sections/progress-tracker.php';
    }

    /**
     * Get progress data via AJAX
     */
    public function get_progress_data() {
        check_ajax_referer('progress_tracker_nonce', 'nonce');

        if (!is_user_logged_in()) {
            wp_send_json_error(__('You must be logged in to view progress', 'athlete-dashboard'));
        }

        $user_id = get_current_user_id();
        $entries = $this->get_progress_entries($user_id);

        wp_send_json_success(array(
            'entries' => $entries,
            'chart_data' => $this->format_chart_data($entries)
        ));
    }

    /**
     * Save progress entry via AJAX
     */
    public function save_progress_entry() {
        check_ajax_referer('progress_tracker_nonce', 'nonce');

        if (!is_user_logged_in()) {
            wp_send_json_error(__('You must be logged in to save progress', 'athlete-dashboard'));
        }

        $entry_data = $this->validate_entry_data($_POST);
        if (is_wp_error($entry_data)) {
            wp_send_json_error($entry_data->get_error_message());
        }

        $user_id = get_current_user_id();
        $result = $this->save_entry($user_id, $entry_data);

        if (is_wp_error($result)) {
            wp_send_json_error($result->get_error_message());
        }

        wp_send_json_success(array(
            'message' => __('Progress entry saved successfully', 'athlete-dashboard'),
            'entry' => $result
        ));
    }

    /**
     * Delete progress entry via AJAX
     */
    public function delete_progress_entry() {
        check_ajax_referer('progress_tracker_nonce', 'nonce');

        if (!is_user_logged_in()) {
            wp_send_json_error(__('You must be logged in to delete progress entries', 'athlete-dashboard'));
        }

        $entry_id = isset($_POST['entry_id']) ? intval($_POST['entry_id']) : 0;
        if (!$entry_id) {
            wp_send_json_error(__('Invalid entry ID', 'athlete-dashboard'));
        }

        $user_id = get_current_user_id();
        $result = $this->delete_entry($user_id, $entry_id);

        if (is_wp_error($result)) {
            wp_send_json_error($result->get_error_message());
        }

        wp_send_json_success(__('Progress entry deleted successfully', 'athlete-dashboard'));
    }

    /**
     * Get the title for this progress type
     *
     * @return string
     */
    private function get_title() {
        $titles = array(
            'body_weight' => __('Body Weight', 'athlete-dashboard'),
            'squat' => __('Squat', 'athlete-dashboard'),
            'bench_press' => __('Bench Press', 'athlete-dashboard'),
            'deadlift' => __('Deadlift', 'athlete-dashboard')
        );

        return isset($titles[$this->type]) ? $titles[$this->type] : $this->type;
    }

    /**
     * Get progress entries for a user
     *
     * @param int $user_id User ID
     * @return array Progress entries
     */
    private function get_progress_entries($user_id) {
        return get_user_meta($user_id, '_athlete_' . $this->type . '_progress', true) ?: array();
    }

    /**
     * Format entries for chart display
     *
     * @param array $entries Progress entries
     * @return array Formatted chart data
     */
    private function format_chart_data($entries) {
        $data = array(
            'labels' => array(),
            'datasets' => array(
                array(
                    'label' => $this->get_title(),
                    'data' => array(),
                    'borderColor' => '#2196F3',
                    'backgroundColor' => 'rgba(33, 150, 243, 0.1)',
                    'tension' => 0.4
                )
            )
        );

        foreach ($entries as $entry) {
            $data['labels'][] = $entry['date'];
            $data['datasets'][0]['data'][] = $entry['weight'];
        }

        return $data;
    }

    /**
     * Validate entry data
     *
     * @param array $data Raw entry data
     * @return array|WP_Error Validated data or error
     */
    private function validate_entry_data($data) {
        $required_fields = array(
            $this->type . '_weight' => 'weight',
            $this->type . '_unit' => 'unit',
            'date' => 'date'
        );

        $entry = array();
        foreach ($required_fields as $field => $key) {
            if (empty($data[$field])) {
                return new WP_Error(
                    'missing_field',
                    sprintf(__('Missing required field: %s', 'athlete-dashboard'), $key)
                );
            }
            $entry[$key] = sanitize_text_field($data[$field]);
        }

        $entry['notes'] = !empty($data['notes']) ? wp_kses_post($data['notes']) : '';
        return $entry;
    }

    /**
     * Save a progress entry
     *
     * @param int $user_id User ID
     * @param array $entry_data Entry data
     * @return array|WP_Error Saved entry or error
     */
    private function save_entry($user_id, $entry_data) {
        $entries = $this->get_progress_entries($user_id);
        $entry_data['id'] = time(); // Use timestamp as ID
        $entries[] = $entry_data;

        // Sort entries by date
        usort($entries, function($a, $b) {
            return strtotime($a['date']) - strtotime($b['date']);
        });

        $updated = update_user_meta($user_id, '_athlete_' . $this->type . '_progress', $entries);
        if ($updated === false) {
            return new WP_Error('save_failed', __('Failed to save progress entry', 'athlete-dashboard'));
        }

        return $entry_data;
    }

    /**
     * Delete a progress entry
     *
     * @param int $user_id User ID
     * @param int $entry_id Entry ID
     * @return bool|WP_Error True on success, error object on failure
     */
    private function delete_entry($user_id, $entry_id) {
        $entries = $this->get_progress_entries($user_id);
        $found = false;

        foreach ($entries as $key => $entry) {
            if (isset($entry['id']) && $entry['id'] === $entry_id) {
                unset($entries[$key]);
                $found = true;
                break;
            }
        }

        if (!$found) {
            return new WP_Error('not_found', __('Progress entry not found', 'athlete-dashboard'));
        }

        $updated = update_user_meta($user_id, '_athlete_' . $this->type . '_progress', array_values($entries));
        if ($updated === false) {
            return new WP_Error('delete_failed', __('Failed to delete progress entry', 'athlete-dashboard'));
        }

        return true;
    }
} 