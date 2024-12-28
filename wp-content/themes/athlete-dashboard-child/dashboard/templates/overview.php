<?php
/**
 * Overview Template
 * 
 * Default dashboard view showing available features and quick actions.
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="dashboard-overview">
    <header class="overview-header">
        <h1><?php _e('Dashboard Overview', 'athlete-dashboard-child'); ?></h1>
        <p class="overview-description">
            <?php _e('Welcome to your athlete dashboard. Access your features and manage your training from here.', 'athlete-dashboard-child'); ?>
        </p>
    </header>

    <div class="feature-grid">
        <?php
        // Get available features
        $features_dir = get_stylesheet_directory() . '/features';
        if (is_dir($features_dir)) {
            foreach (scandir($features_dir) as $feature) {
                if ($feature === '.' || $feature === '..') {
                    continue;
                }

                // Get feature info
                $feature_info = get_file_data($features_dir . '/' . $feature . '/index.php', [
                    'title' => 'Feature Name',
                    'description' => 'Description',
                    'icon' => 'Icon'
                ]);

                if (!empty($feature_info['title'])) {
                    ?>
                    <div class="feature-card" data-feature="<?php echo esc_attr($feature); ?>">
                        <?php if (!empty($feature_info['icon'])): ?>
                            <div class="feature-icon">
                                <span class="dashicons <?php echo esc_attr($feature_info['icon']); ?>"></span>
                            </div>
                        <?php endif; ?>

                        <div class="feature-content">
                            <h2><?php echo esc_html($feature_info['title']); ?></h2>
                            <?php if (!empty($feature_info['description'])): ?>
                                <p><?php echo esc_html($feature_info['description']); ?></p>
                            <?php endif; ?>
                        </div>

                        <a href="<?php echo esc_url(add_query_arg('feature', $feature)); ?>" 
                           class="feature-link">
                            <?php _e('Open', 'athlete-dashboard-child'); ?>
                            <span class="dashicons dashicons-arrow-right-alt"></span>
                        </a>
                    </div>
                    <?php
                }
            }
        }
        ?>
    </div>
</div> 