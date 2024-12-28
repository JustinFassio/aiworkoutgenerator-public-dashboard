<?php
namespace AthleteWorkouts\Dashboard\Core;

// Bootstrap feature system
add_action('init', function() {
    // Initialize managers
    $registry = FeatureRegistry::getInstance();
    $events = EventManager::getInstance();

    // Auto-discover and register features
    $featuresDir = get_stylesheet_directory() . '/features';
    if (is_dir($featuresDir)) {
        foreach (new \DirectoryIterator($featuresDir) as $item) {
            if ($item->isDot() || !$item->isDir()) {
                continue;
            }

            $featureDir = $item->getPathname();
            $indexFile = $featureDir . '/index.php';
            
            if (file_exists($indexFile)) {
                require_once $indexFile;
            }
        }
    }

    // Hook into template loading
    add_filter('template_include', function($template) {
        if (is_page('dashboard')) {
            $dashboardTemplate = get_stylesheet_directory() . '/dashboard/templates/dashboard.php';
            if (file_exists($dashboardTemplate)) {
                return $dashboardTemplate;
            }
        }
        return $template;
    });

    // Add body classes for active features
    add_filter('body_class', function($classes) {
        if (!is_page('dashboard')) {
            return $classes;
        }

        foreach ($registry->getFeatures() as $identifier => $feature) {
            if ($feature->isEnabled()) {
                $classes[] = "feature-{$identifier}-active";
            }
        }

        return $classes;
    });

    // Register REST API namespace
    add_action('rest_api_init', function() {
        register_rest_namespace('dashboard/v1');
    });
}, 5);

// Helper function to register REST API namespace
function register_rest_namespace(string $namespace): void {
    register_rest_route($namespace, '/features', [
        'methods' => 'GET',
        'callback' => function() use ($namespace) {
            $registry = FeatureRegistry::getInstance();
            $features = [];

            foreach ($registry->getFeatures() as $identifier => $feature) {
                $features[$identifier] = [
                    'metadata' => $feature->getMetadata(),
                    'enabled' => $feature->isEnabled(),
                    'initialized' => $registry->isInitialized($identifier)
                ];
            }

            return rest_ensure_response([
                'namespace' => $namespace,
                'features' => $features
            ]);
        },
        'permission_callback' => function() {
            return current_user_can('read');
        }
    ]);
} 