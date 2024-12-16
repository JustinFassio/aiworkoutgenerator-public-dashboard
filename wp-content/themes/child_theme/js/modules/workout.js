/**
 * Athlete Dashboard Workout Module
 */
(function($) {
    'use strict';

    const AthleteWorkout = {
        init: function() {
            this.bindEvents();
            this.initializeWorkoutForms();
        },

        bindEvents: function() {
            $(document).on('submit', '.workout-form', this.handleWorkoutSubmit.bind(this));
            $(document).on('click', '.log-workout-btn', this.handleLogWorkout.bind(this));
        },

        initializeWorkoutForms: function() {
            // Initialize date pickers
            $('.workout-date').datepicker({
                dateFormat: 'yy-mm-dd',
                maxDate: new Date()
            });

            // Initialize exercise selectors
            this.initializeExerciseSelectors();
        },

        initializeExerciseSelectors: function() {
            $('.exercise-selector').each(function() {
                $(this).autocomplete({
                    source: athleteDashboard.exerciseTests || [],
                    minLength: 2
                });
            });
        },

        handleWorkoutSubmit: function(e) {
            e.preventDefault();
            const $form = $(e.target);
            const formData = new FormData($form[0]);

            $.ajax({
                url: athleteDashboard.ajax_url,
                type: 'POST',
                data: {
                    action: 'log_workout',
                    nonce: athleteDashboard.nonce,
                    workout_data: Object.fromEntries(formData)
                },
                success: function(response) {
                    if (response.success) {
                        this.showMessage('Workout logged successfully!', 'success');
                        $form[0].reset();
                    } else {
                        this.showMessage('Error logging workout. Please try again.', 'error');
                    }
                }.bind(this),
                error: function() {
                    this.showMessage('Server error. Please try again later.', 'error');
                }.bind(this)
            });
        },

        handleLogWorkout: function(e) {
            e.preventDefault();
            const workoutId = $(e.target).data('workout-id');
            
            $.ajax({
                url: athleteDashboard.ajax_url,
                type: 'POST',
                data: {
                    action: 'get_workout_form',
                    nonce: athleteDashboard.nonce,
                    workout_id: workoutId
                },
                success: function(response) {
                    if (response.success) {
                        $('#workout-form-container').html(response.data.form);
                        this.initializeWorkoutForms();
                    }
                }.bind(this)
            });
        },

        showMessage: function(message, type) {
            const $messageDiv = $('.workout-message');
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
        AthleteWorkout.init();
    });

})(jQuery); 