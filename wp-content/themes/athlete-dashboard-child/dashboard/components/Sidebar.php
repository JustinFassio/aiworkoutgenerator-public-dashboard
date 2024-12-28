<?php
/**
 * Dashboard Sidebar Component
 */

namespace AthleteDashboard\Dashboard\Components;

if (!defined('ABSPATH')) {
    exit;
}

class Sidebar {
    public function render(): void {
        ?>
        <aside class="dashboard-sidebar">
            <nav class="sidebar-nav">
                <?php
                wp_nav_menu([
                    'theme_location' => 'dashboard-sidebar-menu',
                    'container' => false,
                    'menu_class' => 'sidebar-menu',
                    'fallback_cb' => false
                ]);
                ?>
            </nav>

            <div class="sidebar-features">
                <h2><?php _e('Features', 'athlete-dashboard-child'); ?></h2>
                <?php
                // Get available features
                $features_dir = get_stylesheet_directory() . '/features';
                if (is_dir($features_dir)) {
                    echo '<ul class="feature-menu">';
                    foreach (scandir($features_dir) as $feature) {
                        if ($feature === '.' || $feature === '..') {
                            continue;
                        }

                        // Get feature info
                        $feature_info = get_file_data($features_dir . '/' . $feature . '/index.php', [
                            'title' => 'Feature Name',
                            'icon' => 'Icon'
                        ]);

                        if (!empty($feature_info['title'])) {
                            $current = get_query_var('feature') === $feature ? ' class="current"' : '';
                            ?>
                            <li<?php echo $current; ?>>
                                <a href="<?php echo esc_url(add_query_arg('feature', $feature)); ?>">
                                    <?php if (!empty($feature_info['icon'])): ?>
                                        <span class="dashicons <?php echo esc_attr($feature_info['icon']); ?>"></span>
                                    <?php endif; ?>
                                    <?php echo esc_html($feature_info['title']); ?>
                                </a>
                            </li>
                            <?php
                        }
                    }
                    echo '</ul>';
                }
                ?>
            </div>
        </aside>
        <?php
    }
} 