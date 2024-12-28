<?php
namespace AthleteDashboard\Dashboard\Core;

use AthleteDashboard\Dashboard\Contracts\FeatureInterface;
use AthleteDashboard\Dashboard\Exceptions\FeatureException;

class FeatureRegistry {
    private static ?self $instance = null;
    private array $features = [];
    private array $initialized = [];
    private DependencyManager $dependencyManager;

    private function __construct() {
        $this->dependencyManager = new DependencyManager();
    }

    public static function getInstance(): self {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Register a new feature
     *
     * @param FeatureInterface $feature
     * @throws FeatureException
     */
    public function register(FeatureInterface $feature): void {
        $identifier = $feature->getIdentifier();
        
        if (isset($this->features[$identifier])) {
            throw new FeatureException("Feature '{$identifier}' is already registered.");
        }

        $this->features[$identifier] = $feature;
        
        // Check dependencies before initialization
        if ($this->dependencyManager->checkDependencies($feature)) {
            $this->initializeFeature($feature);
        }
    }

    /**
     * Initialize a feature
     *
     * @param FeatureInterface $feature
     */
    private function initializeFeature(FeatureInterface $feature): void {
        $identifier = $feature->getIdentifier();
        
        if (isset($this->initialized[$identifier])) {
            return;
        }

        try {
            $feature->init();
            $this->initialized[$identifier] = true;
            
            // Emit feature initialized event
            do_action('dashboard_feature_initialized', [
                'feature' => $identifier,
                'metadata' => $feature->getMetadata()
            ]);
            
            do_action("dashboard_feature_{$identifier}_initialized");
        } catch (\Exception $e) {
            // Log error but don't break the dashboard
            error_log("Failed to initialize feature '{$identifier}': " . $e->getMessage());
        }
    }

    /**
     * Get registered feature by identifier
     *
     * @param string $identifier
     * @return FeatureInterface|null
     */
    public function getFeature(string $identifier): ?FeatureInterface {
        return $this->features[$identifier] ?? null;
    }

    /**
     * Get all registered features
     *
     * @return array<string, FeatureInterface>
     */
    public function getFeatures(): array {
        return $this->features;
    }

    /**
     * Check if a feature is registered
     *
     * @param string $identifier
     * @return bool
     */
    public function hasFeature(string $identifier): bool {
        return isset($this->features[$identifier]);
    }

    /**
     * Check if a feature is initialized
     *
     * @param string $identifier
     * @return bool
     */
    public function isInitialized(string $identifier): bool {
        return isset($this->initialized[$identifier]);
    }
} 