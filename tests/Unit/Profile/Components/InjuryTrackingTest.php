<?php

namespace Tests\Unit\Profile\Components;

use PHPUnit\Framework\TestCase;
use WP_Mock;
use Mockery;
use AthleteDashboard\Features\Profile\Components\InjuryTracking;
use AthleteDashboard\Features\Profile\Services\InjuryService;

class InjuryTrackingTest extends TestCase
{
    protected $injuryTracking;
    protected $injuryService;

    protected function setUp(): void
    {
        parent::setUp();
        WP_Mock::setUp();
        
        $this->injuryService = Mockery::mock(InjuryService::class);
        $this->injuryTracking = new InjuryTracking($this->injuryService);
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

        $this->injuryService->shouldReceive('trackInjury')
            ->once()
            ->with($injuryData)
            ->andReturn(true);

        $result = $this->injuryTracking->trackInjury($injuryData);
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

        $this->injuryService->shouldReceive('getInjuryProgress')
            ->once()
            ->andReturn($expectedProgress);

        $result = $this->injuryTracking->getInjuryProgress();
        $this->assertEquals($expectedProgress, $result);
    }

    public function testDeleteInjuryProgressRemovesInjury()
    {
        $injuryId = 1;

        $this->injuryService->shouldReceive('deleteInjuryProgress')
            ->once()
            ->with($injuryId)
            ->andReturn(true);

        $result = $this->injuryTracking->deleteInjuryProgress($injuryId);
        $this->assertTrue($result);
    }

    public function testRenderInjuryTrackingFormOutputsExpectedHtml()
    {
        $injuries = [
            [
                'id' => 1,
                'label' => 'Knee Pain',
                'type' => 'Chronic',
                'description' => 'Recurring knee pain during squats',
                'updated_at' => '2024-01-20'
            ]
        ];

        $this->injuryService->shouldReceive('getInjuryProgress')
            ->once()
            ->andReturn($injuries);

        WP_Mock::userFunction('wp_nonce_field', [
            'times' => 1,
            'return' => ''
        ]);

        ob_start();
        $this->injuryTracking->render_form();
        $output = ob_get_clean();

        $this->assertStringContainsString('injury-tracking-form', $output);
        $this->assertStringContainsString('Knee Pain', $output);
        $this->assertStringContainsString('Chronic', $output);
    }

    public function testHandleAjaxTrackInjuryValidatesNonce()
    {
        WP_Mock::userFunction('wp_verify_nonce', [
            'times' => 1,
            'return' => false
        ]);

        WP_Mock::userFunction('wp_send_json_error', [
            'times' => 1,
            'args' => ['Invalid nonce']
        ]);

        $this->injuryTracking->handleAjaxTrackInjury();
    }

    public function testHandleAjaxGetInjuryProgressReturnsJson()
    {
        $injuries = [
            [
                'id' => 1,
                'label' => 'Knee Pain',
                'type' => 'Chronic',
                'description' => 'Recurring knee pain during squats',
                'updated_at' => '2024-01-20'
            ]
        ];

        $this->injuryService->shouldReceive('getInjuryProgress')
            ->once()
            ->andReturn($injuries);

        WP_Mock::userFunction('wp_send_json_success', [
            'times' => 1,
            'args' => [$injuries]
        ]);

        $this->injuryTracking->handleAjaxGetInjuryProgress();
    }

    public function testHandleAjaxTrackInjuryWithInvalidData()
    {
        WP_Mock::userFunction('wp_verify_nonce', [
            'times' => 1,
            'return' => true
        ]);

        WP_Mock::userFunction('wp_send_json_error', [
            'times' => 1,
            'args' => ['Invalid injury data']
        ]);

        $_POST['injury_data'] = 'invalid_data';
        $this->injuryTracking->handleAjaxTrackInjury();
    }

    public function testHandleAjaxTrackInjuryWithValidData()
    {
        $injuryData = [
            'label' => 'Knee Pain',
            'type' => 'Chronic',
            'description' => 'Recurring knee pain during squats'
        ];

        WP_Mock::userFunction('wp_verify_nonce', [
            'times' => 1,
            'return' => true
        ]);

        WP_Mock::userFunction('current_time', [
            'times' => 1,
            'return' => '2024-01-20'
        ]);

        $this->injuryService->shouldReceive('trackInjury')
            ->once()
            ->with(Mockery::type('array'))
            ->andReturn(true);

        WP_Mock::userFunction('wp_send_json_success', [
            'times' => 1,
            'args' => [['message' => 'Injury tracked successfully']]
        ]);

        $_POST['injury_data'] = json_encode($injuryData);
        $this->injuryTracking->handleAjaxTrackInjury();
    }

    public function testFormatInjuryDescription()
    {
        $injuries = [
            [
                'label' => 'Knee Pain',
                'type' => 'Chronic',
                'description' => 'Recurring knee pain during squats'
            ],
            [
                'label' => 'Back Pain',
                'type' => 'Acute',
                'description' => 'Lower back strain'
            ]
        ];

        $expectedDescription = "KNEE PAIN:\nRecurring knee pain during squats\n\nBACK PAIN:\nLower back strain";

        $result = $this->injuryTracking->formatInjuryDescription($injuries);
        $this->assertEquals($expectedDescription, $result);
    }

    public function testFormatInjuryDescriptionWithEmptyInjuries()
    {
        $result = $this->injuryTracking->formatInjuryDescription([]);
        $this->assertEquals('', $result);
    }
} 