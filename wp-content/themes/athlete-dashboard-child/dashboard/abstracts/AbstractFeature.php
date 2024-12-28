<?php
namespace AthleteWorkouts\Dashboard\Abstracts;

use AthleteWorkouts\Dashboard\Contracts\FeatureInterface;
use AthleteWorkouts\Dashboard\Core\AssetManager;

abstract class AbstractFeature implements FeatureInterface {
    protected static ?self $instance = null;
    protected string $identifier;
    protected array $metadata;

    public static function register(): void {
        static::getInstance()->init();
    }

    public static function getInstance(): static {
        if (static::$instance === null) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    public function getIdentifier(): string {
        return $this->identifier;
    }

    public function getMetadata(): array {
        if (!isset($this->metadata)) {
            $metadataFile = dirname($this->getFeatureFile()) . '/feature.json';
            
            if (file_exists($metadataFile)) {
                $this->metadata = json_decode(file_get_contents($metadataFile), true);
            } else {
                // Fallback to file metadata
                $this->metadata = get_file_data(
                    $this->getFeatureFile(),
                    [
                        'name' => 'Feature Name',
                        'description' => 'Description',
                        'version' => 'Version',
                        'dependencies' => 'Dependencies'
                    ]
                );

                // Parse dependencies if they exist
                if (!empty($this->metadata['dependencies'])) {
                    $this->metadata['dependencies'] = json_decode($this->metadata['dependencies'], true) ?? [];
                }
            }
        }
        return $this->metadata;
    }

    public function isEnabled(): bool {
        return true; // Override in feature class if needed
    }

    protected function enqueueAssets(): void {
        if (!$this->isEnabled()) {
            return;
        }

        $assetManager = AssetManager::getInstance();
        $metadata = $this->getMetadata();

        // Enqueue feature assets
        if (isset($metadata['assets']['entry_points'])) {
            foreach ($metadata['assets']['entry_points'] as $type => $entry) {
                $assetManager->enqueueEntry("features/{$this->identifier}/{$entry}");
            }
        } else {
            // Default to main entry point
            $assetManager->enqueueEntry("features/{$this->identifier}");
        }
    }

    abstract protected function getFeatureFile(): string;
} 