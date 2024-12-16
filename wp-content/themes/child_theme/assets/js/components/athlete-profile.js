/**
 * AthleteProfile Module
 * Handles all profile-related functionality for the athlete dashboard
 */
const AthleteProfile = (function($) {
    'use strict';

    // Private variables
    let config = {
        selectors: {
            changeAvatarBtn: '#change-avatar',
            profilePictureUpload: '#profile-picture-upload',
            profilePicture: '.profile-picture img',
            accountForm: '#account-details-form',
            editProfileBtn: '#edit-profile',
            saveProfileBtn: '#save-profile',
            displayFields: '.profile-info',
            editFields: '.edit-profile-fields',
            displayNameText: '#display-name-text',
            emailText: '#email-text',
            bioText: '#bio-text'
        }
    };

    /**
     * Initialize profile picture upload functionality
     */
    function initializeProfilePictureUpload() {
        $(config.selectors.changeAvatarBtn).on('click', function(e) {
            e.preventDefault();
            $(config.selectors.profilePictureUpload).click();
        });

        $(config.selectors.profilePictureUpload).on('change', function() {
            const file = this.files[0];
            if (file) {
                uploadProfilePicture(file);
            }
        });
    }

    /**
     * Upload profile picture to server
     */
    function uploadProfilePicture(file) {
        const formData = new FormData();
        formData.append('action', 'athlete_dashboard_update_profile_picture');
        formData.append('nonce', window.athleteDashboard.nonce);
        formData.append('profile_picture', file);

        $.ajax({
            url: window.athleteDashboard.ajax_url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    $(config.selectors.profilePicture).attr('src', response.data.url);
                    showNotification('Profile picture updated successfully!', 'success');
                } else {
                    console.error('Error updating profile picture:', response.data.message);
                    showNotification('Error: ' + response.data.message, 'error');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error updating profile picture:', error);
                showNotification('An error occurred while updating the profile picture. Please try again.', 'error');
            }
        });
    }

    /**
     * Initialize profile edit functionality
     */
    function initializeProfileEdit() {
        const $form = $(config.selectors.accountForm);
        const $editBtn = $(config.selectors.editProfileBtn);
        const $saveBtn = $(config.selectors.saveProfileBtn);
        const $displayFields = $(config.selectors.displayFields);
        const $editFields = $(config.selectors.editFields);

        $editBtn.on('click', function() {
            $displayFields.hide();
            $editFields.show();
            $editBtn.hide();
            $saveBtn.show();
        });

        $form.on('submit', function(e) {
            e.preventDefault();
            submitProfileUpdate($(this));
        });
    }

    /**
     * Submit profile update to server
     */
    function submitProfileUpdate($form) {
        const formData = $form.serialize();
        $.ajax({
            url: window.athleteDashboard.ajax_url,
            type: 'POST',
            data: formData + '&action=athlete_dashboard_update_profile&nonce=' + window.athleteDashboard.nonce,
            success: function(response) {
                if (response.success) {
                    updateProfileDisplay(formData);
                    $(config.selectors.editFields).hide();
                    $(config.selectors.displayFields).show();
                    $(config.selectors.saveProfileBtn).hide();
                    $(config.selectors.editProfileBtn).show();
                    showNotification('Profile updated successfully!', 'success');
                } else {
                    console.error('Error updating profile:', response.data.message);
                    showNotification('Error: ' + response.data.message, 'error');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error updating profile:', error);
                showNotification('An error occurred while updating the profile. Please try again.', 'error');
            }
        });
    }

    /**
     * Update profile display with new data
     */
    function updateProfileDisplay(formData) {
        const data = new URLSearchParams(formData);
        $(config.selectors.displayNameText).text(data.get('display_name'));
        $(config.selectors.emailText).text(data.get('email'));
        $(config.selectors.bioText).text(data.get('bio'));
    }

    /**
     * Show notification message
     */
    function showNotification(message, type) {
        // Check if we have a notification system available
        if (typeof window.AthleteUI !== 'undefined' && window.AthleteUI.showNotification) {
            window.AthleteUI.showNotification(message, type);
        } else {
            // Fallback to alert if no notification system is available
            alert(message);
        }
    }

    /**
     * Initialize all profile components
     */
    function initialize() {
        initializeProfilePictureUpload();
        initializeProfileEdit();
    }

    // Public API
    return {
        initialize
    };

})(jQuery);

// Initialize when document is ready
jQuery(document).ready(function() {
    AthleteProfile.initialize();
}); 