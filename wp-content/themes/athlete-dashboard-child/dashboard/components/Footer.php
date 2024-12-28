<?php
/**
 * Dashboard Footer Component
 */

namespace AthleteDashboard\Dashboard\Components;

if (!defined('ABSPATH')) {
    exit;
}

class Footer {
    public function render(): void {
        ?>
        <footer class="dashboard-footer">
            <div class="footer-content">
                <div class="footer-copyright">
                    <p>
                        &copy; <?php echo date('Y'); ?> <?php echo esc_html(get_bloginfo('name')); ?>.
                        <?php _e('All rights reserved.', 'athlete-dashboard-child'); ?>
                    </p>
                </div>

                <nav class="footer-nav">
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'dashboard-footer-menu',
                        'container' => false,
                        'menu_class' => 'footer-menu',
                        'fallback_cb' => false
                    ]);
                    ?>
                </nav>
            </div>
        </footer>
        <?php
    }
} 