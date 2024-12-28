<?php
/**
 * Dashboard Bridge
 * 
 * Provides functionality to bridge PHP dashboard system with React dashboard
 */

namespace AthleteDashboard\Dashboard\Core;

use AthleteDashboard\Dashboard\Components\Dashboard;

if (!defined('ABSPATH')) {
    exit;
}

class DashboardBridge {
    /**
     * Register dashboard scripts and styles
     */
    public static function init(): void {
        add_action('wp_enqueue_scripts', [self::class, 'enqueueAssets']);
        add_action('template_redirect', [self::class, 'initDashboard']);
    }

    /**
     * Initialize dashboard on the correct template
     */
    public static function initDashboard(): void {
        if (!is_page_template('dashboard.php')) {
            return;
        }

        // Get dashboard instance
        $dashboard = Dashboard::getInstance();

        // Get current user data
        $current_user = wp_get_current_user();
        $user_data = [
            'id' => $current_user->ID,
            'name' => $current_user->display_name,
            'email' => $current_user->user_email,
            'avatar' => get_avatar_url($current_user->ID),
            'role' => $current_user->roles[0] ?? 'subscriber'
        ];

        // Get registered features
        $features = apply_filters('athlete_dashboard_features', []);
        $current_feature = get_query_var('dashboard_feature', 'overview');

        $formatted_features = array_map(function($feature) use ($current_feature) {
            return [
                'id' => $feature['id'],
                'title' => $feature['title'],
                'description' => $feature['description'],
                'icon' => $feature['icon'] ?? null,
                'route' => add_query_arg('dashboard_feature', $feature['id'], get_permalink()),
                'isActive' => $feature['id'] === $current_feature
            ];
        }, $features);

        // Get registered modals
        $modals = [];
        foreach ($dashboard->getModals() as $id => $modal) {
            $modals[$id] = [
                'id' => $modal->getId(),
                'title' => $modal->getTitle(),
                'size' => $modal->getAttributes()['size'] ?? 'medium',
                'className' => $modal->getAttributes()['class'] ?? '',
                'buttons' => $modal->getAttributes()['buttons'] ?? [],
                'children' => $modal->renderContent()
            ];
        }

        // Prepare dashboard config
        $dashboard_config = [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('dashboard_nonce'),
            'features' => $formatted_features,
            'currentUser' => $user_data,
            'modals' => $modals
        ];

        // Localize the dashboard config
        wp_localize_script(
            'athlete-dashboard',
            'athleteDashboardConfig',
            $dashboard_config
        );
    }

    /**
     * Enqueue dashboard assets
     */
    public static function enqueueAssets(): void {
        if (!is_page_template('dashboard.php')) {
            return;
        }

        // Enqueue React and ReactDOM
        wp_enqueue_script('react');
        wp_enqueue_script('react-dom');

        // Enqueue dashboard
        wp_enqueue_script(
            'athlete-dashboard',
            get_stylesheet_directory_uri() . '/assets/dist/dashboard/js/components/Dashboard/index.js',
            ['react', 'react-dom', 'athlete-dashboard-modal'],
            filemtime(get_stylesheet_directory() . '/assets/dist/dashboard/js/components/Dashboard/index.js'),
            true
        );

        // Enqueue dashboard styles
        wp_enqueue_style(
            'athlete-dashboard-styles',
            get_stylesheet_directory_uri() . '/assets/dist/dashboard/scss/dashboard.css',
            [],
            filemtime(get_stylesheet_directory() . '/assets/dist/dashboard/scss/dashboard.css')
        );

        // Enqueue Dashicons
        wp_enqueue_style('dashicons');
    }

    /**
     * Render dashboard container
     */
    public static function render(): void {
        ?>
        <div id="athlete-dashboard-root"></div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const dashboardRoot = document.getElementById('athlete-dashboard-root');
                if (dashboardRoot && window.athleteDashboard?.Dashboard) {
                    ReactDOM.render(
                        React.createElement(athleteDashboard.Dashboard, {
                            config: window.athleteDashboardConfig
                        }),
                        dashboardRoot
                    );
                }
            });
        </script>
        <?php
    }
} 