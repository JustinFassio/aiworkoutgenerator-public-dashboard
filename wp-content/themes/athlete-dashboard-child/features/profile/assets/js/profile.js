jQuery(document).ready(function($) {
    const profile = {
        init: function() {
            this.form = $('#profile-form');
            this.bindEvents();
            this.setupMeasurementFields();
        },

        bindEvents: function() {
            this.form.on('submit', this.saveProfile.bind(this));
            this.form.on('change', '.unit-selector', this.handleUnitChange.bind(this));
            this.form.on('input', '[data-field="weight"] .measurement-value', this.handleWeightInput.bind(this));
        },

        setupMeasurementFields: function() {
            // Initialize any measurement fields that need setup
            this.form.find('.unit-selector').each((i, selector) => {
                const $selector = $(selector);
                const $group = $selector.closest('.measurement-group');
                const $value = $group.find('.measurement-value');
                
                // Store initial values
                $group.data('lastValue', $value.val());
                $group.data('lastUnit', $selector.val());
            });
        },

        handleUnitChange: function(e) {
            const $selector = $(e.target);
            const $group = $selector.closest('.measurement-group');
            const $field = $group.closest('.form-group');
            const fieldType = $field.data('field');
            const newUnit = $selector.val();
            const oldUnit = $group.data('lastUnit');
            const currentValue = $group.find('.measurement-value').val();

            if (currentValue && oldUnit !== newUnit) {
                if (fieldType === 'height') {
                    this.convertHeight($group, currentValue, oldUnit, newUnit);
                } else if (fieldType === 'weight') {
                    this.convertWeight($group, currentValue, oldUnit, newUnit);
                }
            }

            // Update last unit
            $group.data('lastUnit', newUnit);
        },

        convertHeight: function($group, value, fromUnit, toUnit) {
            const $input = $group.find('.measurement-value');
            
            if (fromUnit === 'imperial' && toUnit === 'metric') {
                // Convert from inches to cm
                const cm = Math.round(value * 2.54);
                this.updateHeightField($group, cm, 'metric');
            } else if (fromUnit === 'metric' && toUnit === 'imperial') {
                // Convert from cm to inches
                const inches = Math.round(value / 2.54);
                this.updateHeightField($group, inches, 'imperial');
            }
        },

        updateHeightField: function($group, value, unit) {
            const $container = $group.find('.measurement-value').parent();
            let $input;

            if (unit === 'imperial') {
                // Create select for imperial
                $input = $('<select>', {
                    class: 'measurement-value',
                    name: $group.closest('.form-group').data('field'),
                    required: true
                }).append($('<option>', {
                    value: '',
                    text: 'Select height'
                }));

                // Add height options
                for (let feet = 4; feet <= 8; feet++) {
                    for (let inches = 0; inches < (feet === 8 ? 1 : 12); inches++) {
                        const totalInches = (feet * 12) + inches;
                        $input.append($('<option>', {
                            value: totalInches,
                            text: `${feet}'${inches}"`,
                            selected: totalInches === value
                        }));
                    }
                }
            } else {
                // Create number input for metric
                $input = $('<input>', {
                    type: 'number',
                    class: 'measurement-value',
                    name: $group.closest('.form-group').data('field'),
                    value: value,
                    min: 120,
                    max: 244,
                    required: true
                });
            }

            // Replace the existing input/select
            $group.find('.measurement-value').replaceWith($input);
        },

        convertWeight: function($group, value, fromUnit, toUnit) {
            const $input = $group.find('.measurement-value');
            
            if (fromUnit === 'imperial' && toUnit === 'metric') {
                // Convert from lbs to kg
                const kg = Math.round(value * 0.453592 * 10) / 10;
                $input.val(kg);
            } else if (fromUnit === 'metric' && toUnit === 'imperial') {
                // Convert from kg to lbs
                const lbs = Math.round(value * 2.20462 * 10) / 10;
                $input.val(lbs);
            }
        },

        handleWeightInput: function(e) {
            const $input = $(e.target);
            const value = parseFloat($input.val());
            
            if (isNaN(value)) return;
            
            // Store the last valid value
            $input.closest('.measurement-group').data('lastValue', value);
        },

        saveProfile: function(e) {
            e.preventDefault();
            const $form = $(e.currentTarget);
            const $submitButton = $form.find('button[type="submit"]');
            
            // Disable submit button
            $submitButton.prop('disabled', true).text('Saving...');
            
            // Prepare form data
            const formData = new FormData($form[0]);
            formData.append('action', 'update_profile');
            formData.append('profile_nonce', profileData.nonce);

            $.ajax({
                url: profileData.ajaxurl,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        // Show success message
                        const message = $('<div class="success-message">Profile updated successfully</div>');
                        $form.prepend(message);
                        setTimeout(() => message.fadeOut(500, function() { $(this).remove(); }), 3000);
                    } else {
                        // Show error message
                        const message = $('<div class="error-message">' + (response.data || 'Failed to update profile') + '</div>');
                        $form.prepend(message);
                        setTimeout(() => message.fadeOut(500, function() { $(this).remove(); }), 3000);
                    }
                },
                error: function() {
                    // Show error message
                    const message = $('<div class="error-message">An error occurred. Please try again.</div>');
                    $form.prepend(message);
                    setTimeout(() => message.fadeOut(500, function() { $(this).remove(); }), 3000);
                },
                complete: function() {
                    // Re-enable submit button
                    $submitButton.prop('disabled', false).text('Save Profile');
                }
            });
        }
    };

    // Initialize profile
    profile.init();
}); 