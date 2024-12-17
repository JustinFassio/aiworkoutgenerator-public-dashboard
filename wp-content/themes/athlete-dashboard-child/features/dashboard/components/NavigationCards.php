<?php
/**
 * Navigation Cards Component
 */

namespace AthleteDashboard\Features\Dashboard\Components;

if (!defined('ABSPATH')) {
    exit;
}

class NavigationCards {
    public function __construct() {
        // Initialize navigation cards
    }

    public function render() {
        // Render navigation cards
        $cards = $this->get_navigation_cards();
        
        ob_start();
        ?>
        <div class="navigation-cards">
            <?php foreach ($cards as $card): ?>
                <div class="nav-card">
                    <h3><?php echo esc_html($card['title']); ?></h3>
                    <p><?php echo esc_html($card['description']); ?></p>
                    <a href="<?php echo esc_url($card['link']); ?>" class="nav-card-link">
                        <?php echo esc_html($card['cta']); ?>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
        <?php
        return ob_get_clean();
    }

    private function get_navigation_cards() {
        return [
            [
                'title' => 'Profile',
                'description' => 'Manage your profile and preferences',
                'link' => home_url('/profile'),
                'cta' => 'Edit Profile'
            ],
        ];
    }
} 