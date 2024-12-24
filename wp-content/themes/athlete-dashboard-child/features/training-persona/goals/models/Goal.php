<?php
/**
 * Goal Model
 * 
 * Represents a goal and its progress data.
 */

namespace AthleteDashboard\Features\TrainingPersona\Goals\Models;

if (!defined('ABSPATH')) {
    exit;
}

class Goal {
    private string $id;
    private string $label;
    private string $type;
    private float $progress;
    private ?string $description;
    private ?string $updated_at;

    public function __construct(
        string $id,
        string $label,
        string $type,
        float $progress = 0,
        ?string $description = null,
        ?string $updated_at = null
    ) {
        $this->id = $id;
        $this->label = $label;
        $this->type = $type;
        $this->progress = $progress;
        $this->description = $description;
        $this->updated_at = $updated_at;
    }

    public function getId(): string {
        return $this->id;
    }

    public function getLabel(): string {
        return $this->label;
    }

    public function getType(): string {
        return $this->type;
    }

    public function getProgress(): float {
        return $this->progress;
    }

    public function getDescription(): ?string {
        return $this->description;
    }

    public function getUpdatedAt(): ?string {
        return $this->updated_at;
    }

    public function setProgress(float $progress): void {
        $this->progress = min(100, max(0, $progress));
    }

    public function setDescription(?string $description): void {
        $this->description = $description;
    }

    public function setUpdatedAt(string $updated_at): void {
        $this->updated_at = $updated_at;
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'label' => $this->label,
            'type' => $this->type,
            'progress' => $this->progress,
            'description' => $this->description,
            'updated_at' => $this->updated_at
        ];
    }

    public static function fromArray(array $data): self {
        return new self(
            $data['id'],
            $data['label'],
            $data['type'],
            $data['progress'] ?? 0,
            $data['description'] ?? null,
            $data['updated_at'] ?? null
        );
    }
} 