<?php
/**
 * Dashboard Header Component
 */

namespace AthleteDashboard\Dashboard\Components;

if (!defined('ABSPATH')) {
    exit;
}

class Header {
    public function render(): void {
        ?>
        <header class="dashboard-header">
            <div class="header-brand">
                <h1><?php echo esc_html(get_bloginfo('name')); ?></h1>
            </div>

            <nav class="header-nav">
                <?php
                wp_nav_menu([
                    'theme_location' => 'dashboard-header-menu',
                    'container' => false,
                    'menu_class' => 'header-menu',
                    'fallback_cb' => false
                ]);
                ?>
            </nav>

            <div class="header-actions">
                <?php
                if (is_user_logged_in()) {
                    $current_user = wp_get_current_user();
                    ?>
                    <div class="user-menu">
                        <button class="user-menu-toggle" aria-expanded="false">
                            <span class="user-name"><?php echo esc_html($current_user->display_name); ?></span>
                            <span class="dashicons dashicons-arrow-down-alt2"></span>
                        </button>
                        <div class="user-menu-dropdown" hidden>
                            <a href="<?php echo esc_url(wp_logout_url(home_url())); ?>">
                                <?php _e('Log Out', 'athlete-dashboard-child'); ?>
                            </a>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </header>
        <?php
    }
} 