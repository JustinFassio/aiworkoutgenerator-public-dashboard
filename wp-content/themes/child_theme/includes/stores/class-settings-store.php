<?php
/**
 * Settings Store Class
 * Handles storage and retrieval of dashboard settings
 */
class Athlete_Dashboard_Settings_Store {
    /**
     * Get all settings
     */
    public function get_all() {
        return get_option('athlete_dashboard_settings', array());
    }

    /**
     * Get a specific setting
     */
    public function get($key, $default = null) {
        $settings = $this->get_all();
        return isset($settings[$key]) ? $settings[$key] : $default;
    }

    /**
     * Update a setting
     */
    public function update($key, $value) {
        $settings = $this->get_all();
        $settings[$key] = $value;
        return update_option('athlete_dashboard_settings', $settings);
    }

    /**
     * Delete a setting
     */
    public function delete($key) {
        $settings = $this->get_all();
        if (isset($settings[$key])) {
            unset($settings[$key]);
            return update_option('athlete_dashboard_settings', $settings);
        }
        return false;
    }
} 