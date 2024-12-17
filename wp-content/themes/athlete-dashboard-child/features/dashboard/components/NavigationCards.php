<?php
/**
 * Navigation Cards Component
 * 
 * Handles the rendering of dashboard navigation cards.
 */

namespace AthleteDashboard\Features\Dashboard\Components;

use AthleteDashboard\Features\Dashboard\Models\NavigationCard;

if (!defined('ABSPATH')) {
    exit;
}

class NavigationCards {
    private array $cards = [];

    public function __construct() {
        $this->registerDefaultCards();
    }

    private function registerDefaultCards(): void {
        // Register Profile card
        $this->addCard(new NavigationCard([
            'id' => 'profile',
            'title' => __('Profile', 'athlete-dashboard-child'),
            'icon' => 'dashicons-admin-users',
            'modal_target' => 'profile-modal',
            'is_modal' => true
        ]));

        // Additional cards will be registered through hooks
        do_action('athlete_dashboard_register_navigation_cards', $this);
    }

    public function addCard(NavigationCard $card): void {
        $this->cards[$card->getId()] = $card;
    }

    public function render(): void {
        ?>
        <div class="dashboard-grid">
            <?php foreach ($this->cards as $card): ?>
                <?php $this->renderCard($card); ?>
            <?php endforeach; ?>
        </div>
        <?php
    }

    private function renderCard(NavigationCard $card): void {
        $attributes = $card->isModal() 
            ? sprintf('data-modal-target="%s"', esc_attr($card->getModalTarget()))
            : sprintf('href="%s"', esc_url($card->getLink()));

        $tag = $card->isModal() ? 'div' : 'a';
        ?>
        <<?php echo $tag; ?> 
            class="dashboard-card" 
            <?php echo $attributes; ?>
            id="<?php echo esc_attr($card->getId()); ?>-card"
        >
            <span class="card-icon dashicons <?php echo esc_attr($card->getIcon()); ?>"></span>
            <h3 class="card-title"><?php echo esc_html($card->getTitle()); ?></h3>
        </<?php echo $tag; ?>>
        <?php
    }

    public function getCards(): array {
        return $this->cards;
    }
} 