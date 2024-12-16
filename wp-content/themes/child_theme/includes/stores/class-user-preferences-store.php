<?php
/**
 * User Preferences Store Class
 * Handles storage and retrieval of user-specific dashboard preferences
 */
class Athlete_Dashboard_User_Preferences_Store {
    /**
     * Get all preferences for a user
     */
    public function get_all($user_id = null) {
        if (!$user_id) {
            $user_id = get_current_user_id();
        }
        return get_user_meta($user_id, 'athlete_dashboard_preferences', true) ?: array();
    }

    /**
     * Get a specific preference
     */
    public function get($key, $default = null, $user_id = null) {
        $preferences = $this->get_all($user_id);
        return isset($preferences[$key]) ? $preferences[$key] : $default;
    }

    /**
     * Update a preference
     */
    public function update($key, $value, $user_id = null) {
        if (!$user_id) {
            $user_id = get_current_user_id();
        }
        $preferences = $this->get_all($user_id);
        $preferences[$key] = $value;
        return update_user_meta($user_id, 'athlete_dashboard_preferences', $preferences);
    }

    /**
     * Delete a preference
     */
    public function delete($key, $user_id = null) {
        if (!$user_id) {
            $user_id = get_current_user_id();
        }
        $preferences = $this->get_all($user_id);
        if (isset($preferences[$key])) {
            unset($preferences[$key]);
            return update_user_meta($user_id, 'athlete_dashboard_preferences', $preferences);
        }
        return false;
    }
} 