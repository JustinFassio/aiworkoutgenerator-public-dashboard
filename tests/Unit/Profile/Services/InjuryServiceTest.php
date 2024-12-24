<?php

namespace Tests\Unit\Profile\Services;

use PHPUnit\Framework\TestCase;
use WP_Mock;
use Mockery;
use AthleteDashboard\Features\Profile\Services\InjuryService;
use AthleteDashboard\Features\Profile\Models\Injury;

class InjuryServiceTest extends TestCase
{
    protected $injuryService;

    protected function setUp(): void
    {
        parent::setUp();
        WP_Mock::setUp();
        $this->injuryService = new InjuryService();
    }

    protected function tearDown(): void
    {
        WP_Mock::tearDown();
        Mockery::close();
        parent::tearDown();
    }

    public function testTrackInjuryAddsNewInjury()
    {
        $injuryData = [
            'label' => 'Knee Pain',
            'type' => 'Chronic',
            'description' => 'Recurring knee pain during squats',
            'updated_at' => '2024-01-20'
        ];

        $existingInjuries = [];

        WP_Mock::userFunction('get_user_meta', [
            'times' => 1,
            'args' => [Mockery::any(), 'injury_progress', true],
            'return' => $existingInjuries
        ]);

        WP_Mock::userFunction('update_user_meta', [
            'times' => 1,
            'return' => true
        ]);

        $result = $this->injuryService->trackInjury($injuryData);
        $this->assertTrue($result);
    }

    public function testGetInjuryProgressReturnsExpectedData()
    {
        $expectedProgress = [
            [
                'id' => 1,
                'label' => 'Knee Pain',
                'type' => 'Chronic',
                'description' => 'Recurring knee pain during squats',
                'updated_at' => '2024-01-20'
            ]
        ];

        WP_Mock::userFunction('get_user_meta', [
            'times' => 1,
            'args' => [Mockery::any(), 'injury_progress', true],
            'return' => $expectedProgress
        ]);

        $result = $this->injuryService->getInjuryProgress();
        $this->assertEquals($expectedProgress, $result);
    }

    public function testDeleteInjuryProgressRemovesInjury()
    {
        $injuryId = 1;
        $existingInjuries = [
            [
                'id' => 1,
                'label' => 'Knee Pain',
                'type' => 'Chronic',
                'description' => 'Recurring knee pain during squats',
                'updated_at' => '2024-01-20'
            ]
        ];

        WP_Mock::userFunction('get_user_meta', [
            'times' => 1,
            'args' => [Mockery::any(), 'injury_progress', true],
            'return' => $existingInjuries
        ]);

        WP_Mock::userFunction('update_user_meta', [
            'times' => 1,
            'return' => true
        ]);

        $result = $this->injuryService->deleteInjuryProgress($injuryId);
        $this->assertTrue($result);
    }

    public function testGetInjuryProgressReturnsEmptyArrayWhenNoData()
    {
        WP_Mock::userFunction('get_user_meta', [
            'times' => 1,
            'args' => [Mockery::any(), 'injury_progress', true],
            'return' => false
        ]);

        $result = $this->injuryService->getInjuryProgress();
        $this->assertEquals([], $result);
    }

    public function testTrackInjuryUpdatesExistingInjury()
    {
        $injuryData = [
            'id' => 1,
            'label' => 'Knee Pain',
            'type' => 'Chronic',
            'description' => 'Updated description',
            'updated_at' => '2024-01-21'
        ];

        $existingInjuries = [
            [
                'id' => 1,
                'label' => 'Knee Pain',
                'type' => 'Chronic',
                'description' => 'Original description',
                'updated_at' => '2024-01-20'
            ]
        ];

        WP_Mock::userFunction('get_user_meta', [
            'times' => 1,
            'args' => [Mockery::any(), 'injury_progress', true],
            'return' => $existingInjuries
        ]);

        WP_Mock::userFunction('update_user_meta', [
            'times' => 1,
            'return' => true
        ]);

        $result = $this->injuryService->trackInjury($injuryData);
        $this->assertTrue($result);
    }

    public function testDeleteInjuryProgressHandlesInvalidId()
    {
        $injuryId = 999;
        $existingInjuries = [
            [
                'id' => 1,
                'label' => 'Knee Pain',
                'type' => 'Chronic',
                'description' => 'Recurring knee pain during squats',
                'updated_at' => '2024-01-20'
            ]
        ];

        WP_Mock::userFunction('get_user_meta', [
            'times' => 1,
            'args' => [Mockery::any(), 'injury_progress', true],
            'return' => $existingInjuries
        ]);

        $result = $this->injuryService->deleteInjuryProgress($injuryId);
        $this->assertFalse($result);
    }
} 