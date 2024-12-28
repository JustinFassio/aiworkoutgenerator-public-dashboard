<?php
namespace AthleteDashboard\Dashboard\Core;

class EventManager {
    private static ?self $instance = null;
    private array $listeners = [];

    private function __construct() {
        add_action('wp_enqueue_scripts', [$this, 'enqueueScripts']);
    }

    public static function getInstance(): self {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Enqueue event system scripts
     */
    public function enqueueScripts(): void {
        wp_enqueue_script(
            'dashboard-events',
            get_stylesheet_directory_uri() . '/dashboard/assets/js/events.js',
            [],
            '1.0.0',
            true
        );

        // Pass event configuration to JavaScript
        wp_localize_script('dashboard-events', 'dashboardEvents', [
            'debug' => WP_DEBUG,
            'features' => $this->getRegisteredFeatures()
        ]);
    }

    /**
     * Register an event listener
     *
     * @param string $event
     * @param callable $callback
     * @param int $priority
     */
    public function on(string $event, callable $callback, int $priority = 10): void {
        if (!isset($this->listeners[$event])) {
            $this->listeners[$event] = [];
        }

        $this->listeners[$event][] = [
            'callback' => $callback,
            'priority' => $priority
        ];

        // Sort listeners by priority
        usort($this->listeners[$event], function($a, $b) {
            return $b['priority'] - $a['priority'];
        });
    }

    /**
     * Emit an event
     *
     * @param string $event
     * @param array $data
     */
    public function emit(string $event, array $data = []): void {
        // WordPress action for PHP listeners
        do_action("dashboard_event_{$event}", $data);

        // Emit to JavaScript via wp_localize_script
        add_filter('dashboard_events_data', function($events) use ($event, $data) {
            if (!isset($events['emitted'])) {
                $events['emitted'] = [];
            }
            $events['emitted'][] = [
                'event' => $event,
                'data' => $data,
                'timestamp' => time()
            ];
            return $events;
        });
    }

    /**
     * Get registered features for event system
     *
     * @return array
     */
    private function getRegisteredFeatures(): array {
        $registry = FeatureRegistry::getInstance();
        $features = [];

        foreach ($registry->getFeatures() as $identifier => $feature) {
            $features[$identifier] = [
                'metadata' => $feature->getMetadata(),
                'initialized' => $registry->isInitialized($identifier)
            ];
        }

        return $features;
    }
} 