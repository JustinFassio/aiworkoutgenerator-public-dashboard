<?php
/**
 * Modal Template
 * 
 * @var string $id Modal ID
 * @var string $title Modal title
 * @var array $attributes Modal attributes
 * @var callable $renderContent Content render callback
 */

if (!defined('ABSPATH')) {
    exit;
}

$size = $attributes['size'] ?? 'medium';
$classes = $attributes['class'] ?? '';
$buttons = $attributes['buttons'] ?? [];
?>

<div id="<?php echo esc_attr($id); ?>" class="dashboard-modal <?php echo esc_attr($classes); ?>">
    <div class="dashboard-modal__content dashboard-modal__content--<?php echo esc_attr($size); ?>">
        <div class="dashboard-modal__header">
            <h2><?php echo esc_html($title); ?></h2>
            <button type="button" class="dashboard-modal__close" data-modal-close>
                <span class="dashicons dashicons-no-alt"></span>
            </button>
        </div>
        
        <div class="dashboard-modal__body">
            <?php $renderContent(); ?>
        </div>
        
        <?php if (!empty($buttons)): ?>
        <div class="dashboard-modal__footer">
            <?php foreach ($buttons as $button): ?>
                <button type="button" 
                        class="<?php echo esc_attr($button['class']); ?>"
                        <?php echo $button['attrs'] ?? ''; ?>>
                    <?php echo esc_html($button['text']); ?>
                </button>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</div> 