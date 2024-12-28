<?php
/**
 * Asset Version Management for Profile Feature
 * 
 * Handles versioning for profile feature assets to ensure proper cache busting
 */

namespace AthleteDashboard\Features\Profile\Utils;

if (!defined('ABSPATH')) {
    exit;
}

class AssetVersion {
    private static $instance = null;
    private $versions = [];
    private $version_file;

    private function __construct() {
        $this->version_file = get_stylesheet_directory() . '/features/profile/asset-versions.json';
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

    public function getVersion(string $asset): string {
        return $this->versions[$asset] ?? '1.0.0';
    }

    public function updateVersion(string $asset): string {
        $current = $this->versions[$asset] ?? '1.0.0';
        $parts = explode('.', $current);
        $parts[2] = isset($parts[2]) ? ((int)$parts[2] + 1) : 0;
        
        $this->versions[$asset] = implode('.', $parts);
        $this->saveVersions();
        
        return $this->versions[$asset];
    }

    public function registerAsset(string $asset, string $version = '1.0.0'): void {
        if (!isset($this->versions[$asset])) {
            $this->versions[$asset] = $version;
            $this->saveVersions();
        }
    }

    public function getAllVersions(): array {
        return $this->versions;
    }
} 