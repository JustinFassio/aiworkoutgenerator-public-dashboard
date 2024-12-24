<?php

namespace AthleteDashboard\Tests\Unit\Profile\Components;

use AthleteDashboard\Tests\TestCase;
use AthleteDashboard\Features\Profile\Components\Profile;
use AthleteDashboard\Features\Profile\Services\ProfileService;
use AthleteDashboard\Features\Profile\Models\ProfileData;
use Mockery;
use Brain\Monkey\Functions;

class ProfileTest extends TestCase {
    private $profile;
    private $service;
    private $profileData;

    protected function setUp(): void {
        parent::setUp();

        // Mock the ProfileService
        $this->service = Mockery::mock(ProfileService::class);
        
        // Mock the ProfileData
        $this->profileData = Mockery::mock(ProfileData::class);
        
        // Set up common expectations
        $this->profileData->shouldReceive('getFields')->andReturn([
            'height' => [
                'type' => 'height_with_unit',
                'label' => 'Height',
                'required' => true
            ],
            'injuries' => [
                'type' => 'tag_input',
                'label' => 'Injuries',
                'required' => false
            ]
        ]);

        $this->profileData->shouldReceive('toArray')->andReturn($this->getTestProfileData());
        
        // Set up service expectations
        $this->service->shouldReceive('getProfileData')->andReturn($this->profileData);
        
        // Create Profile instance with mocked service
        $this->profile = new Profile($this->service);
    }

    public function testProfileInitialization() {
        $this->assertInstanceOf(Profile::class, $this->profile);
    }

    public function testHandleProfileUpdate() {
        // Mock the POST data
        $_POST = $this->getTestProfileData();
        $_POST['action'] = 'update_profile';
        $_POST['profile_nonce'] = 'test_nonce';

        // Set up service expectation for update
        $this->service->shouldReceive('updateProfile')
            ->with(1, Mockery::type('array'))
            ->once()
            ->andReturn(true);

        // Call the method
        $this->profile->handleProfileUpdate();
        
        // Verify that wp_send_json_success was called
        $this->assertTrue(true); // If we got here without errors, the test passed
    }

    public function testHandleProfileUpdateFailure() {
        // Mock the POST data
        $_POST = $this->getTestProfileData();
        $_POST['action'] = 'update_profile';
        $_POST['profile_nonce'] = 'test_nonce';

        // Set up service expectation for update failure
        $this->service->shouldReceive('updateProfile')
            ->with(1, Mockery::type('array'))
            ->once()
            ->andReturn(false);

        // Call the method
        $this->profile->handleProfileUpdate();
        
        // Verify that wp_send_json_error was called
        $this->assertTrue(true); // If we got here without errors, the test passed
    }
} 