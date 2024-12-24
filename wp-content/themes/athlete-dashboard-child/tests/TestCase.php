<?php

namespace AthleteDashboard\Tests;

use PHPUnit\Framework\TestCase as PHPUnit_TestCase;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Brain\Monkey;

class TestCase extends PHPUnit_TestCase {
    use MockeryPHPUnitIntegration;

    /**
     * Sets up the environment before each test.
     */
    protected function setUp(): void {
        parent::setUp();
        Monkey\setUp();
        
        // Common WordPress functions we need to mock
        Monkey\Functions\when('wp_parse_args')->justReturn([]);
        Monkey\Functions\when('get_current_user_id')->justReturn(1);
        Monkey\Functions\when('wp_create_nonce')->justReturn('test_nonce');
        Monkey\Functions\when('check_ajax_referer')->justReturn(true);
        Monkey\Functions\when('sanitize_text_field')->returnArg();
        Monkey\Functions\when('esc_html')->returnArg();
        Monkey\Functions\when('esc_attr')->returnArg();
        Monkey\Functions\when('wp_send_json_success')->justReturn(true);
        Monkey\Functions\when('wp_send_json_error')->justReturn(false);
    }

    /**
     * Tears down the environment after each test.
     */
    protected function tearDown(): void {
        Monkey\tearDown();
        parent::tearDown();
    }

    /**
     * Helper function to create a mock user meta value
     */
    protected function mockUserMeta($key, $value) {
        Monkey\Functions\when('get_user_meta')
            ->justReturn($value)
            ->when(function($user_id, $meta_key) use ($key) {
                return $meta_key === $key;
            });
    }

    /**
     * Helper function to create a mock update user meta
     */
    protected function mockUpdateUserMeta($key) {
        Monkey\Functions\when('update_user_meta')
            ->justReturn(true)
            ->when(function($user_id, $meta_key) use ($key) {
                return $meta_key === $key;
            });
    }

    /**
     * Helper function to create test profile data
     */
    protected function getTestProfileData() {
        return [
            'height' => '180',
            'height_unit' => 'metric',
            'weight' => '80',
            'weight_unit' => 'metric',
            'injuries' => [
                ['value' => 'knee', 'type' => 'predefined', 'label' => 'Knee Injury'],
                ['value' => 'back', 'type' => 'predefined', 'label' => 'Back Pain']
            ],
            'injuries_other' => "KNEE INJURY:\nRecovering from surgery\n\nBACK PAIN:\nChronic lower back pain"
        ];
    }
} 