<?php
/**
 * Template Name: Dashboard
 * 
 * Main dashboard template that provides the layout structure and coordinates
 * feature integration through React components.
 */

if (!defined('ABSPATH')) {
    exit;
}

use AthleteDashboard\Dashboard\Core\DashboardBridge;

// Initialize dashboard bridge
DashboardBridge::init();

// Get header with minimal wrapper
get_header('minimal');

// Render React dashboard container
DashboardBridge::render();

// Get current feature from URL
$current_feature = get_query_var('dashboard_feature', 'overview');

// Load feature content into a hidden container that React will mount
?>
<div id="dashboard-feature-content" style="display: none;">
    <?php
    // Load feature content
    get_template_part('dashboard/templates/feature-router', null, [
        'feature' => $current_feature
    ]);
    ?>
</div>

<script>
    // Initialize feature content
    document.addEventListener('DOMContentLoaded', function() {
        const featureContent = document.getElementById('dashboard-feature-content');
        const dashboardContent = document.querySelector('.dashboard-content');
        
        if (featureContent && dashboardContent) {
            // Move feature content into React dashboard
            dashboardContent.innerHTML = featureContent.innerHTML;
            featureContent.remove();
        }
    });
</script>

<?php
// Get footer with minimal wrapper
get_footer('minimal'); 