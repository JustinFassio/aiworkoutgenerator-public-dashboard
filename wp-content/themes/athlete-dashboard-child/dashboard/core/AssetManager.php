<?php
namespace AthleteDashboard\Dashboard\Core;

class AssetManager {
    private static ?self $instance = null;
    private bool $isDev;
    private ?array $manifest = null;
    private string $devServer = 'http://localhost:5173';

    private function __construct() {
        $this->isDev = defined('WP_DEBUG') && WP_DEBUG;
        add_action('wp_enqueue_scripts', [$this, 'enqueueViteRuntime']);
    }

    public static function getInstance(): self {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Enqueue Vite client for HMR in development
     */
    public function enqueueViteRuntime(): void {
        if ($this->isDev) {
            wp_enqueue_script(
                'vite-client',
                $this->devServer . '/@vite/client',
                [],
                null,
                ['strategy' => 'defer']
            );
        }
    }

    /**
     * Enqueue an entry point
     *
     * @param string $entry Entry point name (e.g., 'dashboard', 'features/profile')
     * @param array $deps Dependencies
     */
    public function enqueueEntry(string $entry, array $deps = []): void {
        if ($this->isDev) {
            $this->enqueueDevEntry($entry, $deps);
        } else {
            $this->enqueueProdEntry($entry, $deps);
        }
    }

    /**
     * Get the URL for an asset
     *
     * @param string $path Asset path
     * @return string Asset URL
     */
    public function getAssetUrl(string $path): string {
        if ($this->isDev) {
            return $this->devServer . '/' . $path;
        }

        $manifest = $this->getManifest();
        $manifestPath = $manifest[$path]['file'] ?? $path;
        
        return get_stylesheet_directory_uri() . '/dist/' . $manifestPath;
    }

    /**
     * Enqueue development entry point
     *
     * @param string $entry
     * @param array $deps
     */
    private function enqueueDevEntry(string $entry, array $deps): void {
        $url = $this->devServer . '/' . $entry;
        
        wp_enqueue_script(
            "vite-{$entry}",
            $url,
            $deps,
            null,
            ['strategy' => 'defer']
        );
    }

    /**
     * Enqueue production entry point
     *
     * @param string $entry
     * @param array $deps
     */
    private function enqueueProdEntry(string $entry, array $deps): void {
        $manifest = $this->getManifest();
        
        if (!isset($manifest[$entry])) {
            return;
        }

        $manifestEntry = $manifest[$entry];
        
        // Enqueue CSS
        if (isset($manifestEntry['css'])) {
            foreach ($manifestEntry['css'] as $css) {
                wp_enqueue_style(
                    "vite-css-{$entry}-" . basename($css),
                    get_stylesheet_directory_uri() . '/dist/' . $css,
                    [],
                    null
                );
            }
        }

        // Enqueue JS
        wp_enqueue_script(
            "vite-{$entry}",
            get_stylesheet_directory_uri() . '/dist/' . $manifestEntry['file'],
            $deps,
            null,
            ['strategy' => 'defer']
        );
    }

    /**
     * Get the Vite manifest
     *
     * @return array
     */
    private function getManifest(): array {
        if ($this->manifest === null) {
            $manifestPath = get_stylesheet_directory() . '/dist/manifest.json';
            
            if (file_exists($manifestPath)) {
                $this->manifest = json_decode(file_get_contents($manifestPath), true);
            } else {
                $this->manifest = [];
            }
        }

        return $this->manifest;
    }
} 