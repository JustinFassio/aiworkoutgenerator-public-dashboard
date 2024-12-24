<?php
/**
 * Injury Model
 * 
 * Represents an injury and its associated data.
 */

namespace AthleteDashboard\Features\Profile\Injuries\Models;

if (!defined('ABSPATH')) {
    exit;
}

class Injury {
    private ?int $id = null;
    private ?string $label = null;
    private ?string $type = null;
    private ?string $description = null;
    private ?string $updated_at = null;

    public static function createFromArray(array $data): self {
        $injury = new self();
        $injury->setId($data['id'] ?? null);
        $injury->setLabel($data['label'] ?? null);
        $injury->setType($data['type'] ?? null);
        $injury->setDescription($data['description'] ?? null);
        $injury->setUpdatedAt($data['updated_at'] ?? null);
        return $injury;
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'label' => $this->label,
            'type' => $this->type,
            'description' => $this->description,
            'updated_at' => $this->updated_at
        ];
    }

    // Getters
    public function getId(): ?int {
        return $this->id;
    }

    public function getLabel(): ?string {
        return $this->label;
    }

    public function getType(): ?string {
        return $this->type;
    }

    public function getDescription(): ?string {
        return $this->description;
    }

    public function getUpdatedAt(): ?string {
        return $this->updated_at;
    }

    // Setters
    public function setId(?int $id): void {
        $this->id = $id;
    }

    public function setLabel(?string $label): void {
        $this->label = $label;
    }

    public function setType(?string $type): void {
        $this->type = $type;
    }

    public function setDescription(?string $description): void {
        $this->description = $description;
    }

    public function setUpdatedAt(?string $updated_at): void {
        $this->updated_at = $updated_at;
    }
} 