<?php
namespace AthleteWorkouts\Tests\Integration;

use AthleteWorkouts\Tests\IntegrationTestCase;

class ProfileTrainingIntegrationTest extends IntegrationTestCase {
    protected function setUpIntegration(): void {
        // Mock common WordPress functions
        $this->mockFunction('get_stylesheet_directory', '/path/to/athlete-dashboard-child');
        $this->mockFunction('get_stylesheet_directory_uri', 'http://example.com/wp-content/themes/athlete-dashboard-child');
    }

    public function testProfileTrainingInteraction(): void {
        // Test that training feature responds to profile updates
        $profileData = [
            'height' => 180,
            'weight' => 75,
            'fitness_level' => 'intermediate',
            'goals' => ['strength', 'endurance']
        ];

        $this->assertFeatureInteraction(
            'profile',
            'training',
            'profile:update',
            $profileData
        );
    }

    public function testTrainingRecommendations(): void {
        // Test that training recommendations are updated based on profile
        $this->loadFeature('profile');
        $this->loadFeature('training');

        // Mock profile update
        $this->mockAction('dashboard_feature_training_update_recommendations', [
            'fitness_level' => 'intermediate',
            'goals' => ['strength', 'endurance']
        ]);

        // Emit profile update event
        $this->events->emit('profile:update', [
            'fitness_level' => 'intermediate',
            'goals' => ['strength', 'endurance']
        ]);

        // Assert training feature responded
        $this->assertActionsCalled();
    }

    public function testInjuryAwareWorkouts(): void {
        // Test that workouts are adjusted based on injuries
        $this->loadFeature('profile');
        $this->loadFeature('training');

        // Mock injury update
        $this->mockAction('dashboard_feature_training_adjust_workouts', [
            'injury' => [
                'type' => 'knee',
                'severity' => 'moderate'
            ]
        ]);

        // Emit injury update event
        $this->events->emit('profile:injury:update', [
            'type' => 'knee',
            'severity' => 'moderate'
        ]);

        // Assert training feature adjusted workouts
        $this->assertActionsCalled();
    }

    public function testFeatureDependencyChain(): void {
        // Test that features load in correct order
        $this->assertFeatureDependencies('training', [
            'profile' => '1.0.0',
            'core' => '1.0.0'
        ]);
    }

    public function testAssetDependencies(): void {
        // Test that assets are loaded in correct order
        $this->assertFeatureAssetDependencies('training', [
            ['type' => 'script', 'handle' => 'profile-core'],
            ['type' => 'script', 'handle' => 'training-core'],
            ['type' => 'style', 'handle' => 'training-styles']
        ]);
    }

    public function testTemplateIntegration(): void {
        // Test that templates are properly integrated
        $this->assertFeatureTemplateIntegration(
            'training',
            get_stylesheet_directory() . '/features/training/templates/workout.php'
        );
    }

    public function testEventPropagation(): void {
        $this->loadFeature('profile');
        $this->loadFeature('training');

        // Test event chain: profile update -> training update -> UI refresh
        $this->mockAction('dashboard_feature_training_handle_profile_update', [
            'fitness_level' => 'advanced'
        ]);

        $this->mockAction('dashboard_feature_training_refresh_ui', [
            'workout_plan' => 'advanced_strength'
        ]);

        // Emit initial profile update
        $this->events->emit('profile:update', [
            'fitness_level' => 'advanced'
        ]);

        // Assert both actions were called in sequence
        $this->assertActionsCalled();
    }
} 