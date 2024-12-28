<?php

namespace AthleteDashboard\Features\Workout;

use AthleteDashboard\Dashboard\Contracts\FeatureInterface;

class WorkoutFeature implements FeatureInterface {
    private static $instance = null;
    
    public static function register(): void {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        self::$instance->init();
    }

    public function init(): void {
        // Register post type
        add_action('init', [$this, 'registerPostTypes']);
        
        // Register REST API endpoints
        add_action('rest_api_init', [$this, 'registerRestRoutes']);
    }

    public function getIdentifier(): string {
        return 'workout';
    }

    public function getMetadata(): array {
        return [
            'name' => 'Workout Management',
            'description' => 'Handles workout creation, management, and tracking',
            'version' => '1.0.0'
        ];
    }

    public function isEnabled(): bool {
        return true;
    }

    public function registerPostTypes(): void {
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

    public function registerRestRoutes(): void {
        $endpoints = new Api\WorkoutEndpoints();
        $endpoints->register_routes();
    }
} 