<?php
/**
 * Modal Component
 * 
 * Handles the rendering and functionality of modals.
 */

namespace AthleteDashboard\Features\Dashboard\Components;

if (!defined('ABSPATH')) {
    exit;
}

class Modal {
    private string $id;
    private string $title;
    /** @var string|callable */
    private $content;
    private array $options;

    /**
     * @param string $id Modal identifier
     * @param string $title Modal title
     * @param string|callable $content Modal content or callback that renders content
     * @param array $options Modal options
     */
    public function __construct(string $id, string $title = '', $content = '', array $options = []) {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->options = array_merge([
            'size' => 'medium', // small, medium, large
            'closeOnEscape' => true,
            'closeOnBackdropClick' => true,
            'showCloseButton' => true,
            'classes' => []
        ], $options);
    }

    public function render(): void {
        $classes = array_merge(['dashboard-modal'], $this->options['classes']);
        if ($this->options['size']) {
            $classes[] = 'modal-' . $this->options['size'];
        }
        ?>
        <div id="<?php echo esc_attr($this->id); ?>" 
             class="<?php echo esc_attr(implode(' ', $classes)); ?>"
             role="dialog"
             aria-labelledby="<?php echo esc_attr($this->id); ?>-title"
             aria-modal="true"
             data-close-on-escape="<?php echo $this->options['closeOnEscape'] ? 'true' : 'false'; ?>"
             data-close-on-backdrop="<?php echo $this->options['closeOnBackdropClick'] ? 'true' : 'false'; ?>"
        >
            <div class="modal-backdrop"></div>
            <div class="modal-container">
                <div class="modal-content">
                    <?php if ($this->title || $this->options['showCloseButton']): ?>
                        <div class="modal-header">
                            <?php if ($this->title): ?>
                                <h2 id="<?php echo esc_attr($this->id); ?>-title" class="modal-title">
                                    <?php echo esc_html($this->title); ?>
                                </h2>
                            <?php endif; ?>

                            <?php if ($this->options['showCloseButton']): ?>
                                <button type="button" 
                                        class="modal-close" 
                                        aria-label="<?php esc_attr_e('Close modal', 'athlete-dashboard-child'); ?>"
                                >
                                    <span class="dashicons dashicons-no-alt"></span>
                                </button>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <div class="modal-body">
                        <?php 
                        if (is_callable($this->content)) {
                            call_user_func($this->content);
                        } else {
                            echo wp_kses_post($this->content);
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Static helper to quickly render a modal container
     * 
     * @param string $id Modal identifier
     * @param string|callable $content Content or callback
     * @param array $options Modal options
     */
    public static function renderContainer(string $id, $content, array $options = []): void {
        $title = $options['title'] ?? '';
        unset($options['title']);
        
        $modal = new self($id, $title, $content, $options);
        $modal->render();
    }
} 