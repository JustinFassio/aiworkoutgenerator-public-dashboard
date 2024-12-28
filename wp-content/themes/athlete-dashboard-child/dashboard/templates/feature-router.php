<?php
/**
 * Feature Router Template
 * 
 * Routes dashboard features and handles integration with React components.
 */

if (!defined('ABSPATH')) {
    exit;
}

// Get feature from args
$feature = $args['feature'] ?? 'overview';

// Get registered features
$features = apply_filters('athlete_dashboard_features', []);

// Find current feature
$current_feature = null;
foreach ($features as $registered_feature) {
    if ($registered_feature['id'] === $feature) {
        $current_feature = $registered_feature;
        break;
    }
}

// If feature not found, show overview
if (!$current_feature) {
    $feature = 'overview';
    get_template_part('dashboard/templates/overview');
    return;
}

// Check if feature has a React component
$has_react = !empty($current_feature['react_component']);

if ($has_react) {
    // Render React component container
    $component_name = esc_attr($current_feature['react_component']);
    $component_props = wp_json_encode($current_feature['props'] ?? []);
    ?>
    <div id="react-feature-<?php echo esc_attr($feature); ?>"></div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const featureRoot = document.getElementById('react-feature-<?php echo esc_js($feature); ?>');
            if (featureRoot && window.athleteDashboard?.<?php echo esc_js($component_name); ?>) {
                ReactDOM.render(
                    React.createElement(
                        athleteDashboard.<?php echo esc_js($component_name); ?>,
                        <?php echo $component_props; ?>
                    ),
                    featureRoot
                );
            }
        });
    </script>
    <?php
} else {
    // Load PHP template
    $template = $current_feature['template'] ?? "dashboard/templates/{$feature}";
    get_template_part($template, null, $current_feature['props'] ?? []);
} 