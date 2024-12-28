<?php

namespace AthleteDashboard\Features\TrainingPersona\Api;

use WP_REST_Controller;
use WP_REST_Server;
use WP_REST_Request;
use WP_REST_Response;
use WP_Error;

/**
 * REST API Controller for Training Persona feature.
 * 
 * Handles REST API endpoints for managing training persona data.
 */
class TrainingPersonaController extends WP_REST_Controller {
    /**
     * Constructor.
     */
    public function __construct() {
        $this->namespace = 'athlete-dashboard/v1';
        $this->rest_base = 'training-persona';
    }

    /**
     * Register routes.
     */
    public function register_routes(): void {
        register_rest_route($this->namespace, '/' . $this->rest_base, [
            [
                'methods' => WP_REST_Server::READABLE,
                'callback' => [$this, 'get_training_persona'],
                'permission_callback' => [$this, 'get_item_permissions_check'],
            ],
            [
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => [$this, 'update_training_persona'],
                'permission_callback' => [$this, 'update_item_permissions_check'],
                'args' => $this->get_endpoint_args_for_item_schema(WP_REST_Server::CREATABLE),
            ],
        ]);
    }

    /**
     * Check if the current user can view their training persona.
     */
    public function get_item_permissions_check(WP_REST_Request $request): bool {
        return is_user_logged_in();
    }

    /**
     * Check if the current user can update their training persona.
     */
    public function update_item_permissions_check(WP_REST_Request $request): bool {
        return is_user_logged_in();
    }

    /**
     * Get training persona data for the current user.
     */
    public function get_training_persona(WP_REST_Request $request): WP_REST_Response|WP_Error {
        $user_id = get_current_user_id();
        $data = $this->get_user_data($user_id);

        return new WP_REST_Response($data, 200);
    }

    /**
     * Update training persona data for the current user.
     */
    public function update_training_persona(WP_REST_Request $request): WP_REST_Response|WP_Error {
        $user_id = get_current_user_id();
        $data = $this->sanitize_data($request->get_json_params());

        if (is_wp_error($data)) {
            return $data;
        }

        $updated = update_user_meta($user_id, 'training_persona', $data);

        if (false === $updated) {
            return new WP_Error(
                'training_persona_update_failed',
                'Failed to update training persona data',
                ['status' => 500]
            );
        }

        return new WP_REST_Response([
            'message' => 'Training persona updated successfully',
            'data' => $data
        ], 200);
    }

    /**
     * Get the schema for the REST API endpoints.
     */
    public function get_item_schema(): array {
        return [
            '$schema' => 'http://json-schema.org/draft-04/schema#',
            'title' => 'training_persona',
            'type' => 'object',
            'properties' => [
                'level' => [
                    'type' => 'string',
                    'enum' => ['beginner', 'intermediate', 'advanced'],
                    'required' => true,
                ],
                'goals' => [
                    'type' => 'array',
                    'items' => ['type' => 'string'],
                    'required' => true,
                ],
                'preferences' => [
                    'type' => 'object',
                    'properties' => [
                        'workoutDuration' => [
                            'type' => 'integer',
                            'minimum' => 15,
                            'maximum' => 180,
                            'required' => true,
                        ],
                        'workoutFrequency' => [
                            'type' => 'integer',
                            'minimum' => 1,
                            'maximum' => 7,
                            'required' => true,
                        ],
                        'preferredTypes' => [
                            'type' => 'array',
                            'items' => ['type' => 'string'],
                            'required' => true,
                        ],
                    ],
                    'required' => true,
                ],
            ],
        ];
    }

    /**
     * Get default training persona data for a user.
     */
    private function get_user_data(int $user_id): array {
        $default_data = [
            'level' => 'beginner',
            'goals' => [],
            'preferences' => [
                'workoutDuration' => 60,
                'workoutFrequency' => 3,
                'preferredTypes' => []
            ]
        ];

        $saved_data = get_user_meta($user_id, 'training_persona', true);
        return is_array($saved_data) ? array_merge($default_data, $saved_data) : $default_data;
    }

    /**
     * Sanitize and validate training persona data.
     */
    private function sanitize_data(array $data): array|WP_Error {
        $schema = $this->get_item_schema();
        $sanitized = [];

        // Validate level
        if (!isset($data['level']) || !in_array($data['level'], $schema['properties']['level']['enum'])) {
            return new WP_Error(
                'invalid_level',
                'Invalid training level specified',
                ['status' => 400]
            );
        }
        $sanitized['level'] = sanitize_text_field($data['level']);

        // Validate goals
        if (!isset($data['goals']) || !is_array($data['goals'])) {
            return new WP_Error(
                'invalid_goals',
                'Goals must be an array',
                ['status' => 400]
            );
        }
        $sanitized['goals'] = array_map('sanitize_text_field', $data['goals']);

        // Validate preferences
        if (!isset($data['preferences']) || !is_array($data['preferences'])) {
            return new WP_Error(
                'invalid_preferences',
                'Preferences must be an object',
                ['status' => 400]
            );
        }

        $preferences = $data['preferences'];
        $sanitized['preferences'] = [
            'workoutDuration' => isset($preferences['workoutDuration'])
                ? max(15, min(180, absint($preferences['workoutDuration'])))
                : 60,
            'workoutFrequency' => isset($preferences['workoutFrequency'])
                ? max(1, min(7, absint($preferences['workoutFrequency'])))
                : 3,
            'preferredTypes' => isset($preferences['preferredTypes']) && is_array($preferences['preferredTypes'])
                ? array_map('sanitize_text_field', $preferences['preferredTypes'])
                : []
        ];

        return $sanitized;
    }
} 