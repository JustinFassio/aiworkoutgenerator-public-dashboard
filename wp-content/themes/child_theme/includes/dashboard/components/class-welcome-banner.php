<?php
/**
 * Welcome Banner Component Class
 *
 * @package AthleteDashboard
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Athlete_Dashboard_Welcome_Banner {
    /**
     * Initialize the component
     */
    public function __construct() {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
    }

    /**
     * Enqueue component-specific scripts
     */
    public function enqueue_scripts() {
        // Add any specific scripts for the welcome banner
    }

    /**
     * Render the welcome banner
     *
     * @param WP_User $current_user The current user object.
     */
    public function render($current_user) {
        if (!$current_user instanceof WP_User) {
            return;
        }

        include ATHLETE_DASHBOARD_PATH . '/templates/dashboard/sections/welcome-banner.php';
    }

    /**
     * Get the welcome message
     *
     * @param string $display_name The user's display name
     * @return string The formatted welcome message
     */
    public function get_welcome_message($display_name) {
        $hour = current_time('G');
        $greeting = '';

        if ($hour < 12) {
            $greeting = __('Good morning', 'athlete-dashboard');
        } elseif ($hour < 18) {
            $greeting = __('Good afternoon', 'athlete-dashboard');
        } else {
            $greeting = __('Good evening', 'athlete-dashboard');
        }

        return sprintf(
            /* translators: 1: greeting 2: user display name */
            _x('%1$s, %2$s', 'greeting', 'athlete-dashboard'),
            $greeting,
            $display_name
        );
    }
} 