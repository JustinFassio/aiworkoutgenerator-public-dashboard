jQuery(document).ready(function($) {
    const profile = {
        init: function() {
            this.form = $('#profile-form');
            this.submitButton = this.form.find('.submit-button');
            this.messageContainer = this.form.find('.form-messages');
            
            this.bindEvents();
            this.setupUnitHandlers();
        },

        bindEvents: function() {
            this.form.on('submit', this.handleSubmit.bind(this));
        },

        setupUnitHandlers: function() {
            // Handle unit changes for height
            $('#height_unit').on('change', function() {
                const heightField = $('#height');
                const currentUnit = $(this).val();
                const heightGroup = heightField.closest('.form-group');
                
                if (currentUnit === 'imperial') {
                    // Switch to select for imperial
                    const select = $('<select>', {
                        name: 'height',
                        id: 'height',
                        class: 'measurement-value',
                        required: heightField.prop('required')
                    });

                    // Add options
                    select.append($('<option>', {
                        value: '',
                        text: 'Select height'
                    }));

                    // Add height options from 4'0" to 7'0"
                    for (let feet = 4; feet <= 7; feet++) {
                        for (let inches = 0; inches <= 11; inches++) {
                            const value = (feet * 12) + inches;
                            const label = `${feet}'${inches}"`;
                            select.append($('<option>', {
                                value: value,
                                text: label
                            }));
                        }
                    }

                    heightField.replaceWith(select);
                } else {
                    // Switch to number input for metric
                    const input = $('<input>', {
                        type: 'number',
                        name: 'height',
                        id: 'height',
                        class: 'measurement-value',
                        min: '100',
                        max: '250',
                        required: heightField.prop('required')
                    });

                    heightField.replaceWith(input);
                }
            });
        },

        handleSubmit: function(e) {
            e.preventDefault();
            
            // Show loading state
            this.submitButton.prop('disabled', true)
                .find('.button-text').hide();
            this.submitButton.find('.button-loader').show();
            
            // Clear previous messages
            this.messageContainer.empty();

            // Collect form data
            const formData = new FormData(this.form[0]);
            formData.append('action', 'update_profile');
            formData.append('profile_nonce', profileData.nonce);

            // Send AJAX request
            $.ajax({
                url: profileData.ajaxurl,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: this.handleSuccess.bind(this),
                error: this.handleError.bind(this)
            });
        },

        handleSuccess: function(response) {
            // Reset button state
            this.submitButton.prop('disabled', false)
                .find('.button-text').show();
            this.submitButton.find('.button-loader').hide();

            if (response.success) {
                // Show success message
                this.messageContainer.html(
                    $('<div>', {
                        class: 'success-message',
                        text: response.data.message
                    })
                );

                // If in modal context, close after delay
                if (this.form.data('form-context') === 'modal') {
                    setTimeout(() => {
                        const $modal = this.form.closest('.dashboard-modal');
                        if ($modal.length) {
                            $modal.removeClass('is-active');
                            // Remove aria-hidden when closing
                            $modal.removeAttr('aria-hidden');
                        }
                    }, 1500);
                }
            } else {
                this.handleError(response);
            }
        },

        handleError: function(response) {
            // Reset button state
            this.submitButton.prop('disabled', false)
                .find('.button-text').show();
            this.submitButton.find('.button-loader').hide();

            // Show error message
            const message = response.data?.message || 'An error occurred while saving your profile.';
            this.messageContainer.html(
                $('<div>', {
                    class: 'error-message',
                    text: message
                })
            );
        }
    };

    // Initialize profile functionality
    profile.init();
}); 