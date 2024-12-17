jQuery(document).ready(function($) {
    const profile = {
        init: function() {
            this.form = $('#profile-form');
            this.bindEvents();
        },

        bindEvents: function() {
            this.form.on('submit', this.saveProfile.bind(this));
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

            // Handle multiselect fields
            const multiselects = $form.find('select[multiple]');
            multiselects.each(function() {
                const values = $(this).val();
                if (values) {
                    formData.set($(this).attr('name'), values.join(','));
                }
            });

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