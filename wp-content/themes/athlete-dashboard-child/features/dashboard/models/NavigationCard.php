<?php
/**
 * Navigation Card Model
 * 
 * Defines the structure for dashboard navigation cards.
 */

namespace AthleteDashboard\Features\Dashboard\Models;

if (!defined('ABSPATH')) {
    exit;
}

class NavigationCard {
    private string $id;
    private string $title;
    private string $icon;
    private ?string $link;
    private bool $is_modal;
    private ?string $modal_target;

    public function __construct(array $data) {
        $this->id = $data['id'];
        $this->title = $data['title'];
        $this->icon = $data['icon'];
        $this->link = $data['link'] ?? null;
        $this->is_modal = $data['is_modal'] ?? false;
        $this->modal_target = $data['modal_target'] ?? null;
    }

    public function getId(): string {
        return $this->id;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function getIcon(): string {
        return $this->icon;
    }

    public function getLink(): ?string {
        return $this->link;
    }

    public function isModal(): bool {
        return $this->is_modal;
    }

    public function getModalTarget(): ?string {
        return $this->modal_target;
    }
} 