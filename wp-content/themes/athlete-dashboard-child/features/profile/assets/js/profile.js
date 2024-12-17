jQuery(document).ready(function($) {
    const profile = {
        init: function() {
            this.form = $('#profile-form');
            this.bindEvents();
            this.setupUnitPreference();
            this.setupEquipmentSelector();
        },

        bindEvents: function() {
            this.form.on('submit', this.saveProfile.bind(this));
            this.form.on('change', '#unit_preference', this.handleUnitChange.bind(this));
            this.form.on('input', '#weight_lbs, #weight_kg', this.handleWeightInput.bind(this));
            this.form.on('change', '#height_feet, #height_inches, #height_cm', this.handleHeightInput.bind(this));
        },

        setupEquipmentSelector: function() {
            const $selector = $('.equipment-selector');
            if (!$selector.length) return;

            const $select = $selector.find('.equipment-select');
            const $textarea = $selector.find('.equipment-list');
            const $addButton = $selector.find('.add-equipment');

            // Add selected equipment
            $addButton.on('click', function() {
                const selected = $select.val();
                if (!selected || !selected.length) return;

                let current = $textarea.val().split('\n').filter(item => item.trim());
                const newItems = selected.filter(item => !current.includes(item));
                
                if (newItems.length) {
                    current = current.concat(newItems);
                    $textarea.val(current.join('\n'));
                }
                
                $select.val([]);
            });

            // Handle manual entry with Enter key
            $textarea.on('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const value = $(this).val();
                    const lines = value.split('\n');
                    const lastLine = lines[lines.length - 1];

                    if (lastLine.trim()) {
                        $(this).val(value + '\n');
                    }
                }
            });
        },

        setupUnitPreference: function() {
            const preference = this.form.data('unit-preference');
            this.toggleUnitFields(preference);
        },

        handleUnitChange: function(e) {
            const preference = $(e.target).val();
            this.toggleUnitFields(preference);
        },

        toggleUnitFields: function(preference) {
            const heightImperial = this.form.find('[data-field="height_feet"], [data-field="height_inches"]');
            const heightMetric = this.form.find('[data-field="height_cm"]');
            const weightImperial = this.form.find('[data-field="weight_lbs"]');
            const weightMetric = this.form.find('[data-field="weight_kg"]');

            if (preference === 'imperial') {
                heightImperial.show();
                heightMetric.hide();
                weightImperial.show();
                weightMetric.hide();
            } else {
                heightImperial.hide();
                heightMetric.show();
                weightImperial.hide();
                weightMetric.show();
            }
        },

        handleWeightInput: function(e) {
            const $input = $(e.target);
            const value = parseFloat($input.val());
            
            if (isNaN(value)) return;

            if ($input.attr('id') === 'weight_lbs') {
                const kg = Math.round(value * 0.453592);
                $('#weight_kg').val(kg);
            } else {
                const lbs = Math.round(value * 2.20462);
                $('#weight_lbs').val(lbs);
            }
        },

        handleHeightInput: function(e) {
            const $input = $(e.target);
            
            if ($input.attr('id') === 'height_cm') {
                const cm = parseInt($input.val());
                if (isNaN(cm)) return;
                
                const totalInches = Math.round(cm / 2.54);
                const feet = Math.floor(totalInches / 12);
                const inches = totalInches % 12;
                
                $('#height_feet').val(feet);
                $('#height_inches').val(inches);
            } else {
                const feet = parseInt($('#height_feet').val()) || 0;
                const inches = parseInt($('#height_inches').val()) || 0;
                const cm = Math.round((feet * 30.48) + (inches * 2.54));
                
                $('#height_cm').val(cm);
            }
        },

        saveProfile: function(e) {
            e.preventDefault();
            const $form = $(e.currentTarget);
            const $submitButton = $form.find('button[type="submit"]');
            
            // Disable submit button
            $submitButton.prop('disabled', true).text('Saving...');
            
            // Prepare form data
            const formData = new FormData($form[0]);
            formData.append('action', 'save_profile');
            formData.append('nonce', profileData.nonce);

            // Clean up equipment list
            const $equipmentList = $form.find('.equipment-list');
            if ($equipmentList.length) {
                const equipment = $equipmentList.val()
                    .split('\n')
                    .map(item => item.trim())
                    .filter(item => item)
                    .join('\n');
                formData.set('equipment_access', equipment);
            }

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