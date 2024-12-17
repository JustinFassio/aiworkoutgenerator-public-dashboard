<?php
/**
 * Navigation Card Model
 * 
 * Defines the structure and validation for dashboard navigation cards.
 */

namespace AthleteDashboard\Features\Dashboard\Models;

if (!defined('ABSPATH')) {
    exit;
}

class NavigationCard {
    private string $id;
    private string $title;
    private string $icon;
    private string $modalTarget;
    private bool $isModal;
    private ?string $link;

    public function __construct(array $data) {
        $this->id = $data['id'] ?? '';
        $this->title = $data['title'] ?? '';
        $this->icon = $data['icon'] ?? '';
        $this->modalTarget = $data['modal_target'] ?? '';
        $this->isModal = $data['is_modal'] ?? true;
        $this->link = $data['link'] ?? null;

        $this->validate();
    }

    private function validate(): void {
        if (empty($this->id)) {
            throw new \InvalidArgumentException('Card ID is required');
        }

        if (empty($this->title)) {
            throw new \InvalidArgumentException('Card title is required');
        }

        if (empty($this->icon)) {
            throw new \InvalidArgumentException('Card icon is required');
        }

        if ($this->isModal && empty($this->modalTarget)) {
            throw new \InvalidArgumentException('Modal target is required for modal cards');
        }

        if (!$this->isModal && empty($this->link)) {
            throw new \InvalidArgumentException('Link is required for non-modal cards');
        }
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'icon' => $this->icon,
            'modal_target' => $this->modalTarget,
            'is_modal' => $this->isModal,
            'link' => $this->link,
        ];
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

    public function getModalTarget(): string {
        return $this->modalTarget;
    }

    public function isModal(): bool {
        return $this->isModal;
    }

    public function getLink(): ?string {
        return $this->link;
    }
} 