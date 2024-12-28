<?php
/**
 * Overview Feature Registration
 * 
 * Registers the Overview feature with the dashboard system.
 */

namespace AthleteDashboard\Dashboard\Features;

if (!defined('ABSPATH')) {
    exit;
}

class Overview {
    public function __construct() {
        add_filter('athlete_dashboard_features', [$this, 'registerFeature']);
    }

    /**
     * Register the Overview feature
     */
    public function registerFeature(array $features): array {
        $current_user = wp_get_current_user();
        
        // Get all available features
        $available_features = $this->getAvailableFeatures();

        // Add overview feature
        $features[] = [
            'id' => 'overview',
            'title' => __('Overview', 'athlete-dashboard'),
            'description' => __('Dashboard overview and quick access to features.', 'athlete-dashboard'),
            'icon' => 'dashicons-dashboard',
            'react_component' => 'Overview',
            'props' => [
                'features' => $available_features,
                'currentUser' => [
                    'id' => $current_user->ID,
                    'name' => $current_user->display_name,
                    'role' => $current_user->roles[0] ?? 'subscriber'
                ]
            ]
        ];

        return $features;
    }

    /**
     * Get all available features with their status and permissions
     */
    private function getAvailableFeatures(): array {
        $features_dir = get_stylesheet_directory() . '/dashboard/features';
        $available_features = [];

        if (!is_dir($features_dir)) {
            return $available_features;
        }

        foreach (scandir($features_dir) as $feature) {
            if ($feature === '.' || $feature === '..' || $feature === 'overview') {
                continue;
            }

            $feature_file = $features_dir . '/' . $feature . '/' . $feature . '.php';
            if (!file_exists($feature_file)) {
                continue;
            }

            // Get feature metadata
            $feature_data = get_file_data($feature_file, [
                'title' => 'Feature Name',
                'description' => 'Description',
                'icon' => 'Icon',
                'permissions' => 'Permissions',
                'enabled' => 'Enabled'
            ]);

            if (empty($feature_data['title'])) {
                continue;
            }

            // Parse permissions
            $permissions = !empty($feature_data['permissions']) 
                ? array_map('trim', explode(',', $feature_data['permissions']))
                : [];

            // Check if feature is enabled
            $is_enabled = $feature_data['enabled'] !== 'false';

            $available_features[] = [
                'id' => $feature,
                'title' => $feature_data['title'],
                'description' => $feature_data['description'],
                'icon' => $feature_data['icon'],
                'route' => add_query_arg('dashboard_feature', $feature, get_permalink()),
                'isEnabled' => $is_enabled,
                'permissions' => $permissions
            ];
        }

        return $available_features;
    }
}

// Initialize the feature
new Overview(); 