<?php

namespace Tests\Unit\Profile\Services;

use PHPUnit\Framework\TestCase;
use WP_Mock;
use Mockery;
use AthleteDashboard\Features\Profile\Services\ProfileService;

class ProfileServiceTest extends TestCase
{
    protected $profileService;

    protected function setUp(): void
    {
        parent::setUp();
        WP_Mock::setUp();
        $this->profileService = new ProfileService();
    }

    protected function tearDown(): void
    {
        WP_Mock::tearDown();
        Mockery::close();
        parent::tearDown();
    }

    public function testGetProfileDataReturnsExpectedData()
    {
        $expectedData = [
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

        WP_Mock::userFunction('get_user_meta', [
            'times' => 1,
            'args' => [Mockery::any(), 'profile_data', true],
            'return' => $expectedData
        ]);

        $result = $this->profileService->getProfileData();
        $this->assertEquals($expectedData, $result);
    }

    public function testUpdateProfileUpdatesUserMeta()
    {
        $profileData = [
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'height' => '165',
            'weight' => '60',
            'injuries' => ['Ankle'],
            'measurements' => [
                'chest' => '90',
                'waist' => '70',
                'hips' => '85'
            ]
        ];

        WP_Mock::userFunction('update_user_meta', [
            'times' => 1,
            'args' => [Mockery::any(), 'profile_data', $profileData],
            'return' => true
        ]);

        $result = $this->profileService->updateProfile($profileData);
        $this->assertTrue($result);
    }

    public function testGetProfileDataReturnsEmptyArrayWhenNoData()
    {
        WP_Mock::userFunction('get_user_meta', [
            'times' => 1,
            'args' => [Mockery::any(), 'profile_data', true],
            'return' => false
        ]);

        $result = $this->profileService->getProfileData();
        $this->assertEquals([], $result);
    }

    public function testUpdateProfileHandlesInvalidData()
    {
        $invalidData = null;

        $result = $this->profileService->updateProfile($invalidData);
        $this->assertFalse($result);
    }
} 