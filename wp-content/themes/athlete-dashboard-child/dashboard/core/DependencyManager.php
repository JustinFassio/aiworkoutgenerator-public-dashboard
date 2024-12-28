<?php
namespace AthleteWorkouts\Dashboard\Core;

use AthleteWorkouts\Dashboard\Contracts\FeatureInterface;
use AthleteWorkouts\Dashboard\Exceptions\DependencyException;

class DependencyManager {
    private array $dependencyGraph = [];
    private array $resolvedDependencies = [];

    /**
     * Check if all dependencies for a feature are met
     *
     * @param FeatureInterface $feature
     * @return bool
     * @throws DependencyException
     */
    public function checkDependencies(FeatureInterface $feature): bool {
        $metadata = $feature->getMetadata();
        $identifier = $feature->getIdentifier();
        
        if (!isset($metadata['dependencies'])) {
            return true;
        }

        // Build dependency graph if not already built
        if (!isset($this->dependencyGraph[$identifier])) {
            $this->buildDependencyGraph($feature);
        }

        // Check for circular dependencies
        if ($this->hasCircularDependencies($identifier)) {
            throw new DependencyException("Circular dependency detected for feature '{$identifier}'");
        }

        // Check if all dependencies are available and initialized
        foreach ($metadata['dependencies'] as $dependency => $version) {
            if (!$this->isDependencyMet($dependency, $version)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Build dependency graph for a feature
     *
     * @param FeatureInterface $feature
     */
    private function buildDependencyGraph(FeatureInterface $feature): void {
        $metadata = $feature->getMetadata();
        $identifier = $feature->getIdentifier();
        
        if (!isset($metadata['dependencies'])) {
            $this->dependencyGraph[$identifier] = [];
            return;
        }

        $this->dependencyGraph[$identifier] = array_keys($metadata['dependencies']);
    }

    /**
     * Check if feature has circular dependencies
     *
     * @param string $identifier
     * @param array $visited
     * @return bool
     */
    private function hasCircularDependencies(string $identifier, array $visited = []): bool {
        if (in_array($identifier, $visited)) {
            return true;
        }

        $visited[] = $identifier;

        foreach ($this->dependencyGraph[$identifier] as $dependency) {
            if ($this->hasCircularDependencies($dependency, $visited)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if a dependency is met
     *
     * @param string $dependency
     * @param string $requiredVersion
     * @return bool
     */
    private function isDependencyMet(string $dependency, string $requiredVersion): bool {
        $registry = FeatureRegistry::getInstance();
        
        if (!$registry->hasFeature($dependency)) {
            return false;
        }

        $feature = $registry->getFeature($dependency);
        $metadata = $feature->getMetadata();
        
        // Compare versions
        return version_compare($metadata['version'], $requiredVersion, '>=');
    }

    /**
     * Mark a dependency as resolved
     *
     * @param string $identifier
     */
    public function markResolved(string $identifier): void {
        $this->resolvedDependencies[$identifier] = true;
    }

    /**
     * Check if a dependency is resolved
     *
     * @param string $identifier
     * @return bool
     */
    public function isResolved(string $identifier): bool {
        return isset($this->resolvedDependencies[$identifier]);
    }
} 