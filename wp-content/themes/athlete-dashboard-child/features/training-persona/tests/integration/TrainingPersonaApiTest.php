<?php

namespace AthleteDashboard\Features\TrainingPersona\Tests\Integration;

use WP_UnitTestCase;
use WP_REST_Request;
use WP_REST_Response;
use WP_Error;

class TrainingPersonaApiTest extends WP_UnitTestCase {
    private $user_id;
    private $server;
    private $namespace = 'athlete-dashboard/v1';
    private $route = '/training-persona';

    public function setUp(): void {
        parent::setUp();

        // Create test user
        $this->user_id = $this->factory->user->create([
            'role' => 'subscriber'
        ]);

        // Set up REST server
        global $wp_rest_server;
        $this->server = $wp_rest_server = new \WP_REST_Server;
        do_action('rest_api_init');
    }

    public function tearDown(): void {
        parent::tearDown();
        wp_delete_user($this->user_id);
    }

    public function test_register_routes(): void {
        $routes = $this->server->get_routes();
        $this->assertArrayHasKey($this->namespace . $this->route, $routes);
    }

    public function test_get_training_persona_requires_authentication(): void {
        $request = new WP_REST_Request('GET', $this->namespace . $this->route);
        $response = $this->server->dispatch($request);

        $this->assertEquals(401, $response->get_status());
    }

    public function test_update_training_persona_requires_authentication(): void {
        $request = new WP_REST_Request('POST', $this->namespace . $this->route);
        $response = $this->server->dispatch($request);

        $this->assertEquals(401, $response->get_status());
    }

    public function test_get_training_persona_returns_default_data(): void {
        wp_set_current_user($this->user_id);

        $request = new WP_REST_Request('GET', $this->namespace . $this->route);
        $response = $this->server->dispatch($request);

        $this->assertEquals(200, $response->get_status());

        $data = $response->get_data();
        $this->assertIsArray($data);
        $this->assertArrayHasKey('level', $data);
        $this->assertArrayHasKey('goals', $data);
        $this->assertArrayHasKey('preferences', $data);

        $this->assertEquals('beginner', $data['level']);
        $this->assertIsArray($data['goals']);
        $this->assertIsArray($data['preferences']);
    }

    public function test_update_training_persona_with_valid_data(): void {
        wp_set_current_user($this->user_id);

        $test_data = [
            'level' => 'intermediate',
            'goals' => ['Improve strength', 'Increase endurance'],
            'preferences' => [
                'workoutDuration' => 45,
                'workoutFrequency' => 4,
                'preferredTypes' => ['Strength', 'HIIT']
            ]
        ];

        $request = new WP_REST_Request('POST', $this->namespace . $this->route);
        $request->set_header('Content-Type', 'application/json');
        $request->set_body(json_encode($test_data));

        $response = $this->server->dispatch($request);

        $this->assertEquals(200, $response->get_status());

        $data = $response->get_data();
        $this->assertTrue($data['success']);
        $this->assertArrayHasKey('data', $data);

        // Verify data was saved correctly
        $saved_data = get_user_meta($this->user_id, 'training_persona', true);
        $this->assertEquals($test_data['level'], $saved_data['level']);
        $this->assertEquals($test_data['goals'], $saved_data['goals']);
        $this->assertEquals($test_data['preferences'], $saved_data['preferences']);
    }

    public function test_update_training_persona_validates_level(): void {
        wp_set_current_user($this->user_id);

        $test_data = [
            'level' => 'invalid_level',
            'goals' => [],
            'preferences' => [
                'workoutDuration' => 60,
                'workoutFrequency' => 3,
                'preferredTypes' => []
            ]
        ];

        $request = new WP_REST_Request('POST', $this->namespace . $this->route);
        $request->set_header('Content-Type', 'application/json');
        $request->set_body(json_encode($test_data));

        $response = $this->server->dispatch($request);

        $this->assertEquals(400, $response->get_status());
    }

    public function test_update_training_persona_validates_preferences(): void {
        wp_set_current_user($this->user_id);

        $test_data = [
            'level' => 'intermediate',
            'goals' => ['Test goal'],
            'preferences' => [
                'workoutDuration' => 300, // Invalid duration
                'workoutFrequency' => 10, // Invalid frequency
                'preferredTypes' => []
            ]
        ];

        $request = new WP_REST_Request('POST', $this->namespace . $this->route);
        $request->set_header('Content-Type', 'application/json');
        $request->set_body(json_encode($test_data));

        $response = $this->server->dispatch($request);
        $data = $response->get_data();

        // Should succeed but sanitize the values
        $this->assertEquals(200, $response->get_status());
        $this->assertEquals(180, $data['data']['preferences']['workoutDuration']);
        $this->assertEquals(7, $data['data']['preferences']['workoutFrequency']);
    }

    public function test_update_training_persona_sanitizes_input(): void {
        wp_set_current_user($this->user_id);

        $test_data = [
            'level' => 'intermediate',
            'goals' => ['<script>alert("xss")</script>Test goal'],
            'preferences' => [
                'workoutDuration' => 60,
                'workoutFrequency' => 3,
                'preferredTypes' => ['<script>alert("xss")</script>Strength']
            ]
        ];

        $request = new WP_REST_Request('POST', $this->namespace . $this->route);
        $request->set_header('Content-Type', 'application/json');
        $request->set_body(json_encode($test_data));

        $response = $this->server->dispatch($request);
        $data = $response->get_data();

        $this->assertEquals(200, $response->get_status());
        $this->assertStringNotContainsString('<script>', $data['data']['goals'][0]);
        $this->assertStringNotContainsString('<script>', $data['data']['preferences']['preferredTypes'][0]);
    }
} 