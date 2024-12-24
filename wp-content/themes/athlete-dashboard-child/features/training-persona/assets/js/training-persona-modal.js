(function($) {
    'use strict';

    class TrainingPersonaForm {
        constructor() {
            this.init();
        }

        init() {
            // Initialize form submission
            $('#training-persona-form').on('submit', (e) => {
                e.preventDefault();
                this.handleSubmit($(e.currentTarget));
            });

            // Initialize form field handlers
            this.initializeFormFields();
            this.initializeTagInputs();
        }

        initializeFormFields() {
            // Auto-expand textareas
            const $textareas = $('#training-persona-form textarea.auto-expand');
            $textareas.each((_, textarea) => {
                textarea.style.height = 'auto';
                textarea.style.height = (textarea.scrollHeight) + 'px';
            });

            $textareas.on('input', (e) => {
                const textarea = e.target;
                textarea.style.height = 'auto';
                textarea.style.height = (textarea.scrollHeight) + 'px';
            });

            // Handle unit toggles if present
            $('.unit-selector').on('change', (e) => {
                const $select = $(e.target);
                const field = $select.attr('id').replace('_unit', '');
                const $input = $(`#${field}`);
                
                // Trigger a custom event that the feature can listen to
                $(document).trigger('training_persona_unit_changed', [field, $select.val()]);
            });
        }

        initializeTagInputs() {
            const $containers = $('.tag-input-container');
            
            $containers.each((_, container) => {
                const $container = $(container);
                const $input = $container.find('.tag-input');
                const $hiddenInput = $container.find('input[type="hidden"]');
                const $tagList = $container.find('.tag-list');
                const $suggestions = $container.find('.tag-suggestions');

                // Handle tag input focus
                $input.on('focus', () => {
                    $suggestions.show();
                });

                // Handle clicking outside
                $(document).on('click', (e) => {
                    if (!$container.is(e.target) && $container.has(e.target).length === 0) {
                        $suggestions.hide();
                    }
                });

                // Handle suggestion clicks
                $suggestions.on('click', '.tag-suggestion', (e) => {
                    const $suggestion = $(e.currentTarget);
                    this.addTag($container, {
                        type: $suggestion.data('type'),
                        value: $suggestion.data('value'),
                        label: $suggestion.text().trim()
                    });
                    $input.val('').focus();
                });

                // Handle custom tag input
                $input.on('keydown', (e) => {
                    if (e.key === 'Enter' || e.key === ',') {
                        e.preventDefault();
                        const value = $input.val().trim();
                        if (value) {
                            this.addTag($container, {
                                type: 'custom',
                                value: value,
                                label: value
                            });
                            $input.val('');
                        }
                    }
                });

                // Handle tag removal
                $tagList.on('click', '.remove-tag', (e) => {
                    $(e.target).closest('.tag-item').remove();
                    this.updateHiddenInput($container);
                });
            });
        }

        addTag($container, tagData) {
            const $tagList = $container.find('.tag-list');
            const $tagItem = $(`
                <div class="tag-item" data-value='${JSON.stringify(tagData)}'>
                    <span class="tag-text">${tagData.label}</span>
                    <button type="button" class="remove-tag" aria-label="Remove ${tagData.label}">×</button>
                </div>
            `);
            $tagList.append($tagItem);
            this.updateHiddenInput($container);
        }

        updateHiddenInput($container) {
            const tags = [];
            $container.find('.tag-item').each((_, item) => {
                const tagData = $(item).data('value');
                if (tagData) {
                    tags.push(tagData);
                }
            });
            $container.find('input[type="hidden"]').val(JSON.stringify(tags));
        }

        handleSubmit($form) {
            const $submitButton = $form.find('.submit-button');
            const $loader = $submitButton.find('.button-loader');
            const $text = $submitButton.find('.button-text');
            const $messages = $form.find('.form-messages');

            // Show loading state
            $text.hide();
            $loader.show();
            $submitButton.prop('disabled', true);

            // Collect form data
            const formData = new FormData($form[0]);
            formData.append('action', 'update_training_persona');

            // Submit form via AJAX
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: (response) => {
                    if (response.success) {
                        $messages.html('<div class="success">' + response.data.message + '</div>');
                        
                        // Trigger update event
                        $(document).trigger('training_persona_updated', [response.data]);
                        
                        // Let the dashboard handle modal closing
                        $(document).trigger('dashboard_modal_close', ['training-persona-modal']);
                    } else {
                        $messages.html('<div class="error">' + response.data.message + '</div>');
                    }
                },
                error: () => {
                    $messages.html('<div class="error">An error occurred. Please try again.</div>');
                },
                complete: () => {
                    // Reset button state
                    $text.show();
                    $loader.hide();
                    $submitButton.prop('disabled', false);
                }
            });
        }
    }

    // Initialize when document is ready
    $(document).ready(() => {
        new TrainingPersonaForm();
    });
})(jQuery); 