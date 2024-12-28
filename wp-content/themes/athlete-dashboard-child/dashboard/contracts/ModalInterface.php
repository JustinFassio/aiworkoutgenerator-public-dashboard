<?php
/**
 * Modal Interface Contract
 * 
 * Defines the contract that all feature modals must implement to integrate
 * with the dashboard's modal system.
 */

namespace AthleteDashboard\Dashboard\Contracts;

interface ModalInterface {
    /**
     * Get the unique identifier for this modal
     */
    public function getId(): string;

    /**
     * Get the modal title
     */
    public function getTitle(): string;

    /**
     * Render the modal content
     */
    public function renderContent(): void;

    /**
     * Get modal attributes (size, classes, buttons, etc.)
     * 
     * @return array{
     *   size: string,
     *   class: string,
     *   buttons?: array<array{
     *     text: string,
     *     class: string,
     *     attrs?: string
     *   }>
     * }
     */
    public function getAttributes(): array;

    /**
     * Get modal dependencies (styles and scripts)
     * 
     * @return array{
     *   styles?: array<string>,
     *   scripts?: array<string>
     * }
     */
    public function getDependencies(): array;

    /**
     * Render the complete modal
     */
    public function render(): void;

    /**
     * Enqueue modal assets
     */
    public function enqueueAssets(): void;
} 