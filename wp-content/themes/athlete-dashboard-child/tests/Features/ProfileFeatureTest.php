<?php
namespace AthleteWorkouts\Tests\Features;

use AthleteWorkouts\Tests\FeatureTestCase;
use AthleteWorkouts\Features\Profile\ProfileFeature;

class ProfileFeatureTest extends FeatureTestCase {
    protected function setUpFeature(): void {
        $this->featureIdentifier = 'profile';
        
        // Mock feature metadata
        $this->mockFunction('get_file_data', [
            'name' => 'Profile Feature',
            'description' => 'Manages athlete profile information',
            'version' => '1.0.0'
        ]);

        // Register feature
        ProfileFeature::register();
    }

    public function testFeatureRegistration(): void {
        $this->assertFeatureRegistered();
        $this->assertFeatureInitialized();
        $this->assertFeatureEnabled();
    }

    public function testAssetLoading(): void {
        // Mock asset loading
        $this->mockFunction('wp_enqueue_script', null, 1);
        $this->mockFunction('wp_enqueue_style', null, 1);

        // Initialize feature
        $feature = $this->registry->getFeature($this->featureIdentifier);
        $feature->init();

        // Assert assets are enqueued
        $this->assertAssetsEnqueued([
            'vite-features/profile',
            'vite-css-features/profile'
        ]);
    }

    public function testProfileUpdate(): void {
        // Mock profile update event
        $profileData = [
            'height' => 180,
            'weight' => 75,
            'goals' => ['strength', 'endurance']
        ];

        $this->assertFeatureEventEmitted('profile:update', $profileData);
    }

    public function testModalHandling(): void {
        // Mock modal events
        $this->assertFeatureEventEmitted('modal:open', ['id' => 'profile-edit']);
        $this->assertFeatureEventEmitted('modal:close', ['id' => 'profile-edit']);
    }

    public function testInjuryTracking(): void {
        // Mock injury tracking events
        $injury = [
            'type' => 'knee',
            'severity' => 'moderate',
            'notes' => 'Recovery in progress'
        ];

        $this->assertFeatureEventEmitted('injury:add', $injury);
        $this->assertFeatureEventEmitted('injury:update', $injury);
        $this->assertFeatureEventEmitted('injury:remove', ['type' => 'knee']);
    }

    public function testTemplateRendering(): void {
        // Mock template rendering
        $this->mockFunction('get_template_part', null, 1);
        
        // Get feature instance
        $feature = $this->registry->getFeature($this->featureIdentifier);
        
        // Render profile template
        $feature->renderTemplate();
        
        // Assert template was rendered
        $this->assertActionsCalled();
    }
} 