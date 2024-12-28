<?php
namespace AthleteDashboard\Dashboard\Core;

class DashboardInitializer {
    private static ?self $instance = null;
    private FeatureRegistry $registry;
    private EventManager $events;

    public static function getInstance(): self {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        $this->registry = FeatureRegistry::getInstance();
        $this->events = EventManager::getInstance();

        add_action('init', [$this, 'initialize'], 5);
        add_filter('template_include', [$this, 'loadTemplate']);
        add_filter('body_class', [$this, 'addFeatureBodyClasses']);
        add_action('rest_api_init', [$this, 'registerRestRoutes']);
    }

    public function initialize(): void {
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
    }

    public function loadTemplate($template): string {
        if (is_page('dashboard')) {
            $dashboardTemplate = get_stylesheet_directory() . '/dashboard/templates/dashboard.php';
            if (file_exists($dashboardTemplate)) {
                return $dashboardTemplate;
            }
        }
        return $template;
    }

    public function addFeatureBodyClasses(array $classes): array {
        if (!is_page('dashboard')) {
            return $classes;
        }

        foreach ($this->registry->getFeatures() as $identifier => $feature) {
            if ($feature->isEnabled()) {
                $classes[] = "feature-{$identifier}-active";
            }
        }

        return $classes;
    }

    public function registerRestRoutes(): void {
        register_rest_route('dashboard/v1', '/features', [
            'methods' => 'GET',
            'callback' => [$this, 'getFeatures'],
            'permission_callback' => function() {
                return current_user_can('read');
            }
        ]);
    }

    public function getFeatures(): \WP_REST_Response {
        $features = [];

        foreach ($this->registry->getFeatures() as $identifier => $feature) {
            $features[$identifier] = [
                'metadata' => $feature->getMetadata(),
                'enabled' => $feature->isEnabled(),
                'initialized' => $this->registry->isInitialized($identifier)
            ];
        }

        return rest_ensure_response([
            'namespace' => 'dashboard/v1',
            'features' => $features
        ]);
    }
}

// Initialize the dashboard
DashboardInitializer::getInstance(); 