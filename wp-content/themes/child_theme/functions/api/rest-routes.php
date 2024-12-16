<?php
/**
 * REST API Routes
 * 
 * Registers REST API endpoints for the Athlete Dashboard.
 * Includes endpoint registration and permission callbacks.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Register REST API endpoints for modular components
 */
function athlete_dashboard_register_rest_routes() {
    // Core endpoints
    register_rest_route('athlete-dashboard/v1', '/workouts', array(
        'methods' => 'GET',
        'callback' => 'athlete_dashboard_get_workouts',
        'permission_callback' => 'athlete_dashboard_rest_permission'
    ));
    
    // Module-specific endpoints
    register_rest_route('athlete-dashboard/v1', '/goals', array(
        'methods' => 'GET',
        'callback' => 'athlete_dashboard_get_goals',
        'permission_callback' => 'athlete_dashboard_rest_permission'
    ));
    
    register_rest_route('athlete-dashboard/v1', '/attendance', array(
        'methods' => 'GET',
        'callback' => 'athlete_dashboard_get_attendance',
        'permission_callback' => 'athlete_dashboard_rest_permission'
    ));
    
    register_rest_route('athlete-dashboard/v1', '/membership', array(
        'methods' => 'GET',
        'callback' => 'athlete_dashboard_get_membership',
        'permission_callback' => 'athlete_dashboard_rest_permission'
    ));
}

/**
 * REST API permission callback
 */
function athlete_dashboard_rest_permission() {
    return is_user_logged_in();
}

// Register REST API routes
add_action('rest_api_init', 'athlete_dashboard_register_rest_routes'); 