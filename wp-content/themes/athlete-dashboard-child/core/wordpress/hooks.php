<?php

namespace AthleteDashboard\Core\WordPress;

class Hooks {
    public static function init() {
        // Register post type
        add_action('init', [self::class, 'register_post_types']);
        
        // Register REST API endpoints
        add_action('rest_api_init', [self::class, 'register_rest_routes']);
    }

    /**
     * Register custom post types
     */
    public static function register_post_types() {
        register_post_type('workout', [
            'labels' => [
                'name' => 'Workouts',
                'singular_name' => 'Workout'
            ],
            'public' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'capability_type' => 'post',
            'has_archive' => false,
            'supports' => ['title', 'author'],
            'show_in_rest' => true
        ]);
    }

    /**
     * Register REST API routes
     */
    public static function register_rest_routes() {
        // Initialize workout endpoints
        $workout_endpoints = new \AthleteDashboard\Features\Workout\Api\WorkoutEndpoints();
        $workout_endpoints->register_routes();
    }

    /**
     * Register scripts and styles
     */
    public static function register_assets() {
        // Register and enqueue assets here
    }
} 