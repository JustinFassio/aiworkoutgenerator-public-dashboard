<?php
/**
 * Dashboard Component
 */

namespace AthleteDashboard\Features\Dashboard\Components;

use AthleteDashboard\Features\Profile\Components\Profile;

if (!defined('ABSPATH')) {
    exit;
}

require_once dirname(__FILE__) . '/NavigationCards.php';
require_once get_stylesheet_directory() . '/features/profile/components/Profile.php';

class Dashboard {
    private $navigation;
    private $version = '1.0.0';

    public function __construct() {
        $this->navigation = new NavigationCards();
        add_action('wp_enqueue_scripts', array($this, 'enqueue_assets'));
    }

    public function enqueue_assets() {
        // Navigation styles and scripts
        wp_enqueue_style(
            'dashboard-navigation',
            get_stylesheet_directory_uri() . '/features/dashboard/assets/css/navigation-cards.css',
            array(),
            $this->version
        );

        wp_enqueue_script(
            'dashboard-navigation',
            get_stylesheet_directory_uri() . '/features/dashboard/assets/js/navigation.js',
            array('jquery'),
            $this->version,
            true
        );

        wp_localize_script('dashboard-navigation', 'navigationData', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('dashboard_nonce')
        ));
    }
} 