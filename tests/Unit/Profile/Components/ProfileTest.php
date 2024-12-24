<?php

namespace Tests\Unit\Profile\Components;

use PHPUnit\Framework\TestCase;
use WP_Mock;
use Mockery;
use AthleteDashboard\Features\Profile\Components\Profile;
use AthleteDashboard\Features\Profile\Services\ProfileService;

class ProfileTest extends TestCase
{
    protected $profile;
    protected $profileService;

    protected function setUp(): void
    {
        parent::setUp();
        WP_Mock::setUp();
        
        $this->profileService = Mockery::mock(ProfileService::class);
        $this->profile = new Profile($this->profileService);
    }

    protected function tearDown(): void
    {
        WP_Mock::tearDown();
        Mockery::close();
        parent::tearDown();
    }

    public function testRenderFormOutputsExpectedHtml()
    {
        $profileData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'height' => '180',
            'weight' => '75',
            'injuries' => ['Knee', 'Shoulder'],
            'measurements' => [
                'chest' => '100',
                'waist' => '80',
                'hips' => '95'
            ]
        ];

        $this->profileService->shouldReceive('getProfileData')
            ->once()
            ->andReturn($profileData);

        WP_Mock::userFunction('wp_nonce_field', [
            'times' => 1,
            'return' => ''
        ]);

        ob_start();
        $this->profile->render_form();
        $output = ob_get_clean();

        $this->assertStringContainsString('profile-form', $output);
        $this->assertStringContainsString('John', $output);
        $this->assertStringContainsString('Doe', $output);
    }

    public function testHandleProfileUpdateValidatesNonce()
    {
        WP_Mock::userFunction('wp_verify_nonce', [
            'times' => 1,
            'return' => false
        ]);

        $result = $this->profile->handleProfileUpdate([]);
        $this->assertFalse($result);
    }

    public function testHandleProfileUpdateCallsService()
    {
        $profileData = [
            'first_name' => 'Jane',
            'last_name' => 'Smith'
        ];

        WP_Mock::userFunction('wp_verify_nonce', [
            'times' => 1,
            'return' => true
        ]);

        $this->profileService->shouldReceive('updateProfile')
            ->once()
            ->with($profileData)
            ->andReturn(true);

        $result = $this->profile->handleProfileUpdate($profileData);
        $this->assertTrue($result);
    }

    public function testRenderAdminFieldsOutputsExpectedHtml()
    {
        $profileData = [
            'first_name' => 'John',
            'last_name' => 'Doe'
        ];

        $this->profileService->shouldReceive('getProfileData')
            ->once()
            ->andReturn($profileData);

        ob_start();
        $this->profile->render_admin_fields();
        $output = ob_get_clean();

        $this->assertStringContainsString('admin-profile-fields', $output);
        $this->assertStringContainsString('John', $output);
        $this->assertStringContainsString('Doe', $output);
    }
} 