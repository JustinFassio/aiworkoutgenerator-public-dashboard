<?php
namespace AthleteWorkouts\Tests;

use AthleteWorkouts\Dashboard\Core\FeatureRegistry;
use AthleteWorkouts\Dashboard\Core\EventManager;
use AthleteWorkouts\Dashboard\Core\AssetManager;

abstract class FeatureTestCase extends TestCase {
    protected FeatureRegistry $registry;
    protected EventManager $events;
    protected AssetManager $assets;
    protected string $featureIdentifier;

    protected function setUp(): void {
        parent::setUp();

        // Mock WordPress functions commonly used in features
        $this->mockWordPressFunctions();

        // Initialize managers
        $this->registry = FeatureRegistry::getInstance();
        $this->events = EventManager::getInstance();
        $this->assets = AssetManager::getInstance();

        // Set up feature
        $this->setUpFeature();
    }

    protected function tearDown(): void {
        // Clean up feature
        $this->tearDownFeature();

        parent::tearDown();
    }

    abstract protected function setUpFeature(): void;

    protected function tearDownFeature(): void {
        // Override in feature test if needed
    }

    protected function mockWordPressFunctions(): void {
        // Common WordPress functions
        $this->mockFunction('wp_enqueue_script');
        $this->mockFunction('wp_enqueue_style');
        $this->mockFunction('wp_localize_script');
        $this->mockFunction('get_stylesheet_directory_uri', 'http://example.com/wp-content/themes/athlete-dashboard-child');
        $this->mockFunction('get_stylesheet_directory', '/path/to/athlete-dashboard-child');
        $this->mockFunction('plugin_dir_url', 'http://example.com/wp-content/plugins/');
        $this->mockFunction('is_admin', false);
        $this->mockFunction('is_user_logged_in', true);
        $this->mockFunction('current_user_can', true);
        $this->mockFunction('wp_create_nonce', 'test_nonce');
    }

    protected function assertFeatureRegistered(): void {
        $this->assertTrue(
            $this->registry->hasFeature($this->featureIdentifier),
            "Feature '{$this->featureIdentifier}' should be registered"
        );
    }

    protected function assertFeatureInitialized(): void {
        $this->assertTrue(
            $this->registry->isInitialized($this->featureIdentifier),
            "Feature '{$this->featureIdentifier}' should be initialized"
        );
    }

    protected function assertFeatureEnabled(): void {
        $feature = $this->registry->getFeature($this->featureIdentifier);
        $this->assertTrue(
            $feature->isEnabled(),
            "Feature '{$this->featureIdentifier}' should be enabled"
        );
    }

    protected function assertAssetsEnqueued(array $assets): void {
        foreach ($assets as $asset) {
            $this->assertTrue(
                wp_script_is($asset) || wp_style_is($asset),
                "Asset '{$asset}' should be enqueued"
            );
        }
    }

    protected function assertEventEmitted(string $event, array $data = []): void {
        $this->mockAction("dashboard_event_{$event}", [$data]);
        $this->events->emit($event, $data);
        $this->assertActionsCalled();
    }

    protected function assertFeatureEventEmitted(string $event, array $data = []): void {
        $this->mockAction(
            "dashboard_feature_{$this->featureIdentifier}_{$event}",
            [$data]
        );
        $this->events->emit("{$this->featureIdentifier}:{$event}", $data);
        $this->assertActionsCalled();
    }
} 