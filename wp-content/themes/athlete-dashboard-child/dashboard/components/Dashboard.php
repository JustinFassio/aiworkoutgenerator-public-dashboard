<?php
/**
 * Dashboard Component
 * 
 * Manages the dashboard's modal system and coordinates feature integration.
 */

namespace AthleteDashboard\Dashboard\Components;

use AthleteDashboard\Dashboard\Contracts\ModalInterface;

if (!defined('ABSPATH')) {
    exit;
}

class Dashboard {
    /**
     * @var array<string, ModalInterface>
     */
    private array $modals = [];

    /**
     * @var Dashboard|null
     */
    private static ?Dashboard $instance = null;

    /**
     * Get the Dashboard instance
     */
    public static function getInstance(): Dashboard {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Initialize the dashboard
     */
    private function __construct() {
        add_action('wp_enqueue_scripts', [$this, 'enqueueAssets']);
        add_action('wp_footer', [$this, 'renderModals']);
    }

    /**
     * Register a modal with the dashboard
     */
    public function registerModal(ModalInterface $modal): void {
        $this->modals[$modal->getId()] = $modal;
    }

    /**
     * Get a registered modal by ID
     */
    public function getModal(string $id): ?ModalInterface {
        return $this->modals[$id] ?? null;
    }

    /**
     * Enqueue dashboard assets
     */
    public function enqueueAssets(): void {
        if (!is_page_template('dashboard.php')) {
            return;
        }

        // Enqueue dashboard styles
        wp_enqueue_style(
            'dashboard-styles',
            get_stylesheet_directory_uri() . '/assets/dist/css/dashboard/dashboard-styles.css',
            [],
            '1.0.0'
        );

        // Enqueue dashboard scripts
        wp_enqueue_script(
            'dashboard-scripts',
            get_stylesheet_directory_uri() . '/assets/dist/js/dashboard/dashboard.js',
            ['jquery'],
            '1.0.0',
            [
                'strategy' => 'defer',
                'in_footer' => true,
                'module' => true
            ]
        );

        // Enqueue modal assets
        foreach ($this->modals as $modal) {
            foreach ($modal->getDependencies()['styles'] ?? [] as $style) {
                wp_enqueue_style($style);
            }
            foreach ($modal->getDependencies()['scripts'] ?? [] as $script) {
                wp_enqueue_script($script);
            }
        }

        // Localize script
        wp_localize_script('dashboard-scripts', 'dashboardConfig', [
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('dashboard_nonce')
        ]);
    }

    /**
     * Render all registered modals
     */
    public function renderModals(): void {
        if (!is_page_template('dashboard.php')) {
            return;
        }

        foreach ($this->modals as $modal) {
            $id = $modal->getId();
            $title = $modal->getTitle();
            $attributes = $modal->getAttributes();
            $renderContent = [$modal, 'renderContent'];

            require get_stylesheet_directory() . '/dashboard/partials/modal.php';
        }
    }
} 