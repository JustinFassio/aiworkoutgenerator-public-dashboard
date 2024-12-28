<?php
namespace AthleteWorkouts\Tests;

use AthleteWorkouts\Dashboard\Core\FeatureRegistry;
use AthleteWorkouts\Dashboard\Core\EventManager;
use AthleteWorkouts\Dashboard\Core\AssetManager;

abstract class IntegrationTestCase extends TestCase {
    protected FeatureRegistry $registry;
    protected EventManager $events;
    protected AssetManager $assets;

    protected function setUp(): void {
        parent::setUp();

        // Initialize managers
        $this->registry = FeatureRegistry::getInstance();
        $this->events = EventManager::getInstance();
        $this->assets = AssetManager::getInstance();

        // Set up integration test
        $this->setUpIntegration();
    }

    protected function tearDown(): void {
        // Clean up integration test
        $this->tearDownIntegration();

        parent::tearDown();
    }

    abstract protected function setUpIntegration(): void;

    protected function tearDownIntegration(): void {
        // Override in integration test if needed
    }

    protected function loadFeature(string $identifier): void {
        $featureDir = get_stylesheet_directory() . "/features/{$identifier}";
        $indexFile = "{$featureDir}/index.php";

        if (file_exists($indexFile)) {
            require_once $indexFile;
        }
    }

    protected function assertFeatureInteraction(string $feature1, string $feature2, string $event, array $data = []): void {
        // Load features
        $this->loadFeature($feature1);
        $this->loadFeature($feature2);

        // Mock event interaction
        $this->mockAction("dashboard_feature_{$feature2}_handle_{$event}", [$data]);

        // Emit event from feature1
        $this->events->emit("{$feature1}:{$event}", $data);

        // Assert interaction
        $this->assertActionsCalled();
    }

    protected function assertFeatureDependencies(string $feature, array $dependencies): void {
        // Load feature
        $this->loadFeature($feature);

        // Get feature instance
        $instance = $this->registry->getFeature($feature);
        $metadata = $instance->getMetadata();

        // Assert dependencies
        $this->assertArrayHasKey('dependencies', $metadata);
        foreach ($dependencies as $dep => $version) {
            $this->assertArrayHasKey($dep, $metadata['dependencies']);
            $this->assertEquals($version, $metadata['dependencies'][$dep]);
        }
    }

    protected function assertFeatureAssetDependencies(string $feature, array $assets): void {
        // Load feature
        $this->loadFeature($feature);

        // Get feature instance
        $instance = $this->registry->getFeature($feature);

        // Mock asset loading
        foreach ($assets as $asset) {
            $this->mockFunction("wp_enqueue_{$asset['type']}", null, 1);
        }

        // Initialize feature
        $instance->init();

        // Assert asset dependencies
        $this->assertActionsCalled();
    }

    protected function assertFeatureTemplateIntegration(string $feature, string $template): void {
        // Load feature
        $this->loadFeature($feature);

        // Mock template loading
        $this->mockFilter('template_include', $template, [$template]);

        // Assert template integration
        $this->assertFiltersCalled();
    }
} 