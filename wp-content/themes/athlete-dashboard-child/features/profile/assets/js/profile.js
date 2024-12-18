jQuery(document).ready(function($) {
    // Initialize form handler
    const profileForm = new FormHandler('profile-form', {
        endpoint: profileData.ajaxurl,
        additionalData: {
            action: 'update_profile',
            profile_nonce: profileData.nonce
        },
        customFields: {
            '#height_unit': setupHeightUnitHandler,
            '#weight_unit': setupWeightUnitHandler
        }
    });

    function setupHeightUnitHandler(element) {
        $(element).on('change', function() {
            const heightField = $('#height');
            const currentUnit = $(this).val();
            
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
    }

    function setupWeightUnitHandler(element) {
        $(element).on('change', function() {
            const weightField = $('#weight');
            const currentValue = parseFloat(weightField.val());
            const newUnit = $(this).val();
            
            if (!currentValue) return;

            if (newUnit === 'metric') {
                // Convert from lbs to kg
                const kg = Math.round(currentValue * 0.453592 * 10) / 10;
                weightField.val(kg);
            } else {
                // Convert from kg to lbs
                const lbs = Math.round(currentValue * 2.20462 * 10) / 10;
                weightField.val(lbs);
            }
        });
    }
}); 