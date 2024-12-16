/**
 * Athlete Dashboard Goals Module
 */
(function($) {
    'use strict';

    const AthleteGoals = {
        init: function() {
            this.bindEvents();
            this.initializeGoalForms();
            this.loadActiveGoals();
        },

        bindEvents: function() {
            $(document).on('submit', '.goal-form', this.handleGoalSubmit.bind(this));
            $(document).on('click', '.update-progress-btn', this.handleProgressUpdate.bind(this));
            $(document).on('click', '.delete-goal-btn', this.handleGoalDelete.bind(this));
        },

        initializeGoalForms: function() {
            // Initialize date pickers
            $('.goal-deadline').datepicker({
                dateFormat: 'yy-mm-dd',
                minDate: new Date()
            });

            // Initialize progress sliders
            $('.progress-slider').each(function() {
                $(this).slider({
                    min: 0,
                    max: 100,
                    value: $(this).data('progress') || 0,
                    slide: function(event, ui) {
                        $(this).siblings('.progress-value').text(ui.value + '%');
                    }
                });
            });
        },

        loadActiveGoals: function() {
            $.ajax({
                url: athleteDashboard.ajax_url,
                type: 'POST',
                data: {
                    action: 'get_active_goals',
                    nonce: athleteDashboard.nonce
                },
                success: function(response) {
                    if (response.success) {
                        $('#active-goals-container').html(response.data.goals);
                        this.initializeGoalForms();
                    }
                }.bind(this)
            });
        },

        handleGoalSubmit: function(e) {
            e.preventDefault();
            const $form = $(e.target);
            const formData = new FormData($form[0]);

            $.ajax({
                url: athleteDashboard.ajax_url,
                type: 'POST',
                data: {
                    action: 'save_goal',
                    nonce: athleteDashboard.nonce,
                    goal_data: Object.fromEntries(formData)
                },
                success: function(response) {
                    if (response.success) {
                        this.showMessage('Goal saved successfully!', 'success');
                        this.loadActiveGoals();
                        $form[0].reset();
                    } else {
                        this.showMessage('Error saving goal. Please try again.', 'error');
                    }
                }.bind(this),
                error: function() {
                    this.showMessage('Server error. Please try again later.', 'error');
                }.bind(this)
            });
        },

        handleProgressUpdate: function(e) {
            e.preventDefault();
            const goalId = $(e.target).data('goal-id');
            const progress = $(e.target).closest('.goal-item').find('.progress-slider').slider('value');

            $.ajax({
                url: athleteDashboard.ajax_url,
                type: 'POST',
                data: {
                    action: 'update_goal_progress',
                    nonce: athleteDashboard.nonce,
                    goal_id: goalId,
                    progress: progress
                },
                success: function(response) {
                    if (response.success) {
                        this.showMessage('Progress updated successfully!', 'success');
                        this.loadActiveGoals();
                    } else {
                        this.showMessage('Error updating progress. Please try again.', 'error');
                    }
                }.bind(this)
            });
        },

        handleGoalDelete: function(e) {
            e.preventDefault();
            if (!confirm('Are you sure you want to delete this goal?')) {
                return;
            }

            const goalId = $(e.target).data('goal-id');

            $.ajax({
                url: athleteDashboard.ajax_url,
                type: 'POST',
                data: {
                    action: 'delete_goal',
                    nonce: athleteDashboard.nonce,
                    goal_id: goalId
                },
                success: function(response) {
                    if (response.success) {
                        this.showMessage('Goal deleted successfully!', 'success');
                        this.loadActiveGoals();
                    } else {
                        this.showMessage('Error deleting goal. Please try again.', 'error');
                    }
                }.bind(this)
            });
        },

        showMessage: function(message, type) {
            const $messageDiv = $('.goals-message');
            $messageDiv
                .removeClass('success error')
                .addClass(type)
                .text(message)
                .fadeIn()
                .delay(3000)
                .fadeOut();
        }
    };

    // Initialize on document ready
    $(document).ready(function() {
        AthleteGoals.init();
    });

})(jQuery); 