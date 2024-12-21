<?php
/**
 * Asset Version Management
 * 
 * Handles versioning for feature assets to ensure proper cache busting
 */

namespace AthleteDashboard\Features\Shared;

if (!defined('ABSPATH')) {
    exit;
}

class AssetVersion {
    private static $instance = null;
    private $versions = [];
    private $version_file;

    private function __construct() {
        $this->version_file = get_stylesheet_directory() . '/features/shared/asset-versions.json';
        $this->loadVersions();
    }

    public static function getInstance(): self {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function loadVersions(): void {
        if (file_exists($this->version_file)) {
            $json = file_get_contents($this->version_file);
            $this->versions = json_decode($json, true) ?? [];
        }
    }

    private function saveVersions(): void {
        file_put_contents($this->version_file, json_encode($this->versions, JSON_PRETTY_PRINT));
    }

    public function getVersion(string $feature, string $asset): string {
        return $this->versions[$feature][$asset] ?? '1.0.0';
    }

    public function updateVersion(string $feature, string $asset): string {
        if (!isset($this->versions[$feature])) {
            $this->versions[$feature] = [];
        }

        $current = $this->versions[$feature][$asset] ?? '1.0.0';
        $parts = explode('.', $current);
        $parts[2] = isset($parts[2]) ? ((int)$parts[2] + 1) : 0;
        
        $this->versions[$feature][$asset] = implode('.', $parts);
        $this->saveVersions();
        
        return $this->versions[$feature][$asset];
    }

    public function registerAsset(string $feature, string $asset, string $version = '1.0.0'): void {
        if (!isset($this->versions[$feature])) {
            $this->versions[$feature] = [];
        }

        if (!isset($this->versions[$feature][$asset])) {
            $this->versions[$feature][$asset] = $version;
            $this->saveVersions();
        }
    }

    public function getAllVersions(): array {
        return $this->versions;
    }

    public function getFeatureVersions(string $feature): array {
        return $this->versions[$feature] ?? [];
    }
} 