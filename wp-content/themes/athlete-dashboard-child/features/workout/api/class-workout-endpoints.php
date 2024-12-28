<?php

namespace AthleteDashboard\Features\Workout\Api;

use WP_REST_Server;
use WP_REST_Request;
use WP_REST_Response;
use WP_Error;

class WorkoutEndpoints {
    private $namespace = 'athlete-dashboard/v1';
    private $base = 'workouts';

    public function register_routes(): void {
        register_rest_route($this->namespace, '/' . $this->base, [
            [
                'methods' => WP_REST_Server::READABLE,
                'callback' => [$this, 'get_workouts'],
                'permission_callback' => [$this, 'check_permission']
            ],
            [
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => [$this, 'create_workout'],
                'permission_callback' => [$this, 'check_permission']
            ]
        ]);

        register_rest_route($this->namespace, '/' . $this->base . '/(?P<id>[\d]+)', [
            [
                'methods' => WP_REST_Server::READABLE,
                'callback' => [$this, 'get_workout'],
                'permission_callback' => [$this, 'check_permission'],
                'args' => [
                    'id' => [
                        'validate_callback' => function($param) {
                            return is_numeric($param);
                        }
                    ]
                ]
            ],
            [
                'methods' => WP_REST_Server::EDITABLE,
                'callback' => [$this, 'update_workout'],
                'permission_callback' => [$this, 'check_permission'],
                'args' => [
                    'id' => [
                        'validate_callback' => function($param) {
                            return is_numeric($param);
                        }
                    ]
                ]
            ],
            [
                'methods' => WP_REST_Server::DELETABLE,
                'callback' => [$this, 'delete_workout'],
                'permission_callback' => [$this, 'check_permission'],
                'args' => [
                    'id' => [
                        'validate_callback' => function($param) {
                            return is_numeric($param);
                        }
                    ]
                ]
            ]
        ]);
    }

    public function check_permission(): bool {
        return current_user_can('edit_posts');
    }

    public function get_workouts(WP_REST_Request $request): WP_REST_Response {
        $args = [
            'post_type' => 'workout',
            'posts_per_page' => -1,
            'post_status' => 'publish'
        ];

        $posts = get_posts($args);
        $data = [];

        foreach ($posts as $post) {
            $data[] = $this->prepare_workout_response($post);
        }

        return new WP_REST_Response($data, 200);
    }

    public function get_workout(WP_REST_Request $request): WP_REST_Response|WP_Error {
        $post = get_post($request['id']);

        if (!$post || $post->post_type !== 'workout') {
            return new WP_Error('not_found', 'Workout not found', ['status' => 404]);
        }

        return new WP_REST_Response($this->prepare_workout_response($post), 200);
    }

    public function create_workout(WP_REST_Request $request): WP_REST_Response|WP_Error {
        $post_data = [
            'post_type' => 'workout',
            'post_status' => 'publish',
            'post_title' => sanitize_text_field($request->get_param('title')),
            'meta_input' => [
                'workout_data' => $request->get_param('workout_data')
            ]
        ];

        $post_id = wp_insert_post($post_data);

        if (is_wp_error($post_id)) {
            return new WP_Error('create_failed', 'Failed to create workout', ['status' => 500]);
        }

        return new WP_REST_Response([
            'id' => $post_id,
            'message' => 'Workout created successfully'
        ], 201);
    }

    public function update_workout(WP_REST_Request $request): WP_REST_Response|WP_Error {
        $post = get_post($request['id']);

        if (!$post || $post->post_type !== 'workout') {
            return new WP_Error('not_found', 'Workout not found', ['status' => 404]);
        }

        $post_data = [
            'ID' => $request['id'],
            'post_title' => sanitize_text_field($request->get_param('title')),
            'meta_input' => [
                'workout_data' => $request->get_param('workout_data')
            ]
        ];

        $updated = wp_update_post($post_data);

        if (is_wp_error($updated)) {
            return new WP_Error('update_failed', 'Failed to update workout', ['status' => 500]);
        }

        return new WP_REST_Response([
            'id' => $updated,
            'message' => 'Workout updated successfully'
        ], 200);
    }

    public function delete_workout(WP_REST_Request $request): WP_REST_Response|WP_Error {
        $post = get_post($request['id']);

        if (!$post || $post->post_type !== 'workout') {
            return new WP_Error('not_found', 'Workout not found', ['status' => 404]);
        }

        $deleted = wp_delete_post($request['id'], true);

        if (!$deleted) {
            return new WP_Error('delete_failed', 'Failed to delete workout', ['status' => 500]);
        }

        return new WP_REST_Response([
            'message' => 'Workout deleted successfully'
        ], 200);
    }

    private function prepare_workout_response($post): array {
        return [
            'id' => $post->ID,
            'title' => $post->post_title,
            'workout_data' => get_post_meta($post->ID, 'workout_data', true),
            'created_at' => $post->post_date,
            'updated_at' => $post->post_modified
        ];
    }
} 