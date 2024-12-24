<?php
/**
 * Dashboard Component
 * 
 * Handles the main dashboard functionality and asset loading.
 */

namespace AthleteDashboard\Dashboard\Components;

if (!defined('ABSPATH')) {
    exit;
}

class Dashboard {
    public function __construct() {
        $this->init();
    }

    private function init(): void {
        add_action('wp_enqueue_scripts', [$this, 'enqueueAssets']);
    }

    public function enqueueAssets(): void {
        // Enqueue modal styles
        wp_enqueue_style(
            'dashboard-modal',
            get_stylesheet_directory_uri() . '/dashboard/assets/css/modal.css',
            [],
            filemtime(get_stylesheet_directory() . '/dashboard/assets/css/modal.css')
        );

        // Enqueue modal scripts
        wp_enqueue_script(
            'dashboard-modal',
            get_stylesheet_directory_uri() . '/dashboard/assets/js/modal.js',
            ['jquery'],
            filemtime(get_stylesheet_directory() . '/dashboard/assets/js/modal.js'),
            true
        );
    }

    public function render(): void {
        include get_stylesheet_directory() . '/dashboard/templates/dashboard.php';
    }
} 