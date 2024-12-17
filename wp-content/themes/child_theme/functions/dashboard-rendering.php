<?php
/**
 * Dashboard Rendering Functions for Athlete Dashboard
 *
 * This file contains the main rendering function and shortcode registration
 * for the Athlete Dashboard plugin.
 *
 * @package AthleteDashboard
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Render the welcome banner for the athlete dashboard.
 *
 * @param WP_User $current_user The current user object.
 * @return void
 */
function athlete_dashboard_render_welcome_banner($current_user) {
    if (!$current_user instanceof WP_User) {
        return;
    }
    
    require_once get_stylesheet_directory() . '/templates/dashboard/sections/welcome-banner.php';
}

/**
 * Render the login message for non-logged-in users.
 *
 * @return string The HTML content of the login message.
 */
function athlete_dashboard_render_login_message() {
    return '<div class="athlete-dashboard-login-message">' .
           '<p>' . esc_html__('Please log in to access your dashboard.', 'athlete-dashboard') . '</p>' .
           '<p><a href="' . esc_url(wp_login_url()) . '" class="button">' . 
           esc_html__('Log In', 'athlete-dashboard') . '</a></p>' .
           '</div>';
}

/**
 * Render the Athlete Dashboard.
 *
 * @return string The HTML content of the dashboard.
 */
function athlete_dashboard_render_dashboard() {
    if (!is_user_logged_in()) {
        return athlete_dashboard_render_login_message();
    }
    
    $current_user = wp_get_current_user();
    ob_start();
    ?>
    <div class="athlete-dashboard-container">
        <?php athlete_dashboard_render_welcome_banner($current_user); ?>
        <div class="athlete-dashboard">
            <?php echo athlete_dashboard_render_all_cards(); ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

// Register the shortcode
add_shortcode('athlete_dashboard', 'athlete_dashboard_render_dashboard');

/**
 * Render a single dashboard card.
 *
 * @param string $id The card ID.
 * @param string $title The card title.
 * @param string $content The card content (can be shortcode or callback function name).
 * @param array $actions Optional array of action buttons for the card header.
 * @return void
 */
function athlete_dashboard_render_card($id, $title, $content, $actions = []) {
    ?>
    <div class="dashboard-card" id="<?php echo esc_attr($id); ?>">
        <div class="card-header" role="button" tabindex="0" aria-expanded="false" aria-controls="<?php echo esc_attr($id); ?>-content">
            <h3 class="card-title"><?php echo esc_html($title); ?></h3>
            <div class="card-actions">
                <?php if (!empty($actions)): ?>
                    <?php foreach ($actions as $action): ?>
                        <button type="button" 
                                class="<?php echo esc_attr($action['class']); ?>"
                                <?php echo isset($action['attrs']) ? $action['attrs'] : ''; ?>>
                            <?php echo esc_html($action['text']); ?>
                        </button>
                    <?php endforeach; ?>
                <?php endif; ?>
                <button type="button" class="btn btn-icon toggle-card">
                    <span class="toggle-icon" aria-hidden="true">+</span>
                    <span class="screen-reader-text"><?php 
                        printf(
                            /* translators: %s: Card title */
                            esc_html__('Toggle %s', 'athlete-dashboard'), 
                            esc_html($title)
                        ); 
                    ?></span>
                </button>
            </div>
        </div>
        <div class="card-content" id="<?php echo esc_attr($id); ?>-content" aria-hidden="true" style="display: none;">
            <?php
            if (substr($content, 0, 1) === '[' && substr($content, -1) === ']') {
                echo do_shortcode($content);
            } elseif (function_exists($content)) {
                call_user_func($content);
            } else {
                echo wp_kses_post($content);
            }
            ?>
        </div>
    </div>
    <?php
}

/**
 * Render all dashboard cards.
 *
 * @return string The HTML content of all dashboard cards.
 */
function athlete_dashboard_render_all_cards() {
    ob_start();
    ?>
    <div class="dashboard-content">
        <div class="card-grid">
            <?php
            // Overview Cards
            athlete_dashboard_render_card(
                'overview',
                __('Trailhead', 'athlete-dashboard'),
                '[user_overview]'
            );
            
            athlete_dashboard_render_card(
                'current-workout',
                __('Current Workout', 'athlete-dashboard'),
                '[user_workouts]',
                [
                    [
                        'class' => 'btn btn-secondary refresh-card',
                        'text' => __('Refresh', 'athlete-dashboard'),
                        'attrs' => 'data-card="current-workout"'
                    ]
                ]
            );

            // Progress Cards
            athlete_dashboard_render_card(
                'squat-progress',
                __('Squat Progress', 'athlete-dashboard'),
                'athlete_dashboard_squat_progress',
                [
                    [
                        'class' => 'btn btn-primary add-entry-button',
                        'text' => __('Add Entry', 'athlete-dashboard')
                    ]
                ]
            );

            athlete_dashboard_render_card(
                'bench-press-progress',
                __('Bench Press Progress', 'athlete-dashboard'),
                'athlete_dashboard_bench_press_progress_content',
                [
                    [
                        'class' => 'btn btn-primary add-entry-button',
                        'text' => __('Add Entry', 'athlete-dashboard')
                    ]
                ]
            );

            athlete_dashboard_render_card(
                'deadlift-progress',
                __('Deadlift Progress', 'athlete-dashboard'),
                'athlete_dashboard_deadlift_progress_content',
                [
                    [
                        'class' => 'btn btn-primary add-entry-button',
                        'text' => __('Add Entry', 'athlete-dashboard')
                    ]
                ]
            );

            // Body Composition Cards
            athlete_dashboard_render_card(
                'body-weight',
                __('Body Weight Progress', 'athlete-dashboard'),
                'athlete_dashboard_body_weight_progress_content',
                [
                    [
                        'class' => 'btn btn-primary add-entry-button',
                        'text' => __('Add Entry', 'athlete-dashboard')
                    ]
                ]
            );

            athlete_dashboard_render_card(
                'body-composition',
                __('Body Composition', 'athlete-dashboard'),
                'athlete_dashboard_comprehensive_body_composition_content',
                [
                    [
                        'class' => 'btn btn-primary add-entry-button',
                        'text' => __('Add Entry', 'athlete-dashboard')
                    ]
                ]
            );

            // Nutrition Cards
            athlete_dashboard_render_card(
                'log-meal',
                __('Log Meal', 'athlete-dashboard'),
                'athlete_dashboard_meal_log_content'
            );

            athlete_dashboard_render_card(
                'nutrition',
                __('Nutrition Overview', 'athlete-dashboard'),
                '[user_nutrition]'
            );

            // Training Cards
            athlete_dashboard_render_card(
                'personal-training',
                __('Personal Training', 'athlete-dashboard'),
                'athlete_dashboard_personal_training_sessions_content'
            );

            athlete_dashboard_render_card(
                'class-bookings',
                __('Class Bookings', 'athlete-dashboard'),
                'athlete_dashboard_class_bookings_content'
            );

            // Additional Cards
            athlete_dashboard_render_card(
                'messaging',
                __('Messages', 'athlete-dashboard'),
                'athlete_dashboard_render_messaging_preview'
            );

            athlete_dashboard_render_card(
                'account',
                __('Account Details', 'athlete-dashboard'),
                'athlete_dashboard_account_details_content'
            );
            ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * Render the squat progress card content
 */
function athlete_dashboard_squat_progress() {
    // Initialize the squat progress component
    $squat_progress = new Athlete_Dashboard_Squat_Progress_Component();
    
    // Render the component
    echo $squat_progress->render();
}
