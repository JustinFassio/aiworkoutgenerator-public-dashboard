<?php

namespace AthleteDashboard\Dashboard\Contracts;

interface FeatureInterface {
    public static function register(): void;
    public function init(): void;
    public function getIdentifier(): string;
    public function getMetadata(): array;
    public function isEnabled(): bool;
} 