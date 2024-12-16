/**
 * AthleteForms Module
 * Handles all form-related functionality for the athlete dashboard
 */
const AthleteForms = (function($) {
    'use strict';

    // Private variables
    let config = {
        selectors: {
            bodyWeightForm: '#body-weight-progress-form',
            squatForm: '#squat-progress-form',
            benchPressForm: '#bench-press-progress-form',
            deadliftForm: '#deadlift-progress-form',
            exerciseForm: '.exercise-progress-form',
            bodyCompositionForm: '#comprehensive-body-composition-form',
            workoutLogForm: '#workout-log-form',
            mealLogForm: '#meal-log-form'
        },
        submitting: false
    };

    /**
     * Initialize body weight progress form
     */
    function initializeBodyWeightProgressForm() {
        $(config.selectors.bodyWeightForm).on('submit', function(e) {
            e.preventDefault();
            submitProgressForm($(this), {
                action: 'athlete_dashboard_handle_progress_submission',
                successCallback: function() {
                    if (typeof window.AthleteCharts !== 'undefined') {
                        window.AthleteCharts.updateBodyWeightProgressChart();
                    }
                }
            });
        });
    }

    /**
     * Initialize squat progress form
     */
    function initializeSquatProgressForm() {
        $(config.selectors.squatForm).on('submit', function(e) {
            e.preventDefault();
            submitProgressForm($(this), {
                action: 'athlete_dashboard_handle_squat_progress_submission',
                successCallback: function() {
                    if (typeof window.AthleteCharts !== 'undefined') {
                        window.AthleteCharts.updateSquatProgressChart();
                    }
                }
            });
        });
    }

    /**
     * Initialize bench press progress form
     */
    function initializeBenchPressProgressForm() {
        $(config.selectors.benchPressForm).on('submit', function(e) {
            e.preventDefault();
            submitProgressForm($(this), {
                action: 'athlete_dashboard_handle_bench_press_progress_submission',
                successCallback: function() {
                    if (typeof window.AthleteCharts !== 'undefined') {
                        window.AthleteCharts.updateBenchPressProgressChart();
                    }
                }
            });
        });
    }

    /**
     * Initialize deadlift progress form
     */
    function initializeDeadliftProgressForm() {
        $(config.selectors.deadliftForm).on('submit', function(e) {
            e.preventDefault();
            submitProgressForm($(this), {
                action: 'athlete_dashboard_handle_deadlift_progress_submission',
                successCallback: function() {
                    if (typeof window.AthleteCharts !== 'undefined') {
                        window.AthleteCharts.updateDeadliftProgressChart();
                    }
                }
            });
        });
    }

    /**
     * Initialize exercise progress form
     */
    function initializeExerciseProgressForm() {
        $(config.selectors.exerciseForm).on('submit', function(e) {
            e.preventDefault();
            const $form = $(this);
            const exerciseKey = $form.find('input[name="exercise_key"]').val();
            const date = $form.find('input[name="date"]').val();
            const isBilateral = $form.closest('[data-bilateral]').data('bilateral');

            let formData = {
                action: 'athlete_dashboard_handle_exercise_progress_submission',
                nonce: window.athleteDashboard.nonce,
                exercise_key: exerciseKey,
                date: date
            };

            if (isBilateral) {
                formData.left_value = $form.find('input[name="left_value"]').val();
                formData.right_value = $form.find('input[name="right_value"]').val();
            } else {
                formData.value = $form.find('input[name="value"]').val();
            }

            submitAjaxRequest(formData, {
                successCallback: function() {
                    if (typeof window.AthleteCharts !== 'undefined') {
                        window.AthleteCharts.updateExerciseChart(exerciseKey);
                    }
                    $form[0].reset();
                }
            });
        });
    }

    /**
     * Initialize comprehensive body composition form
     */
    function initializeComprehensiveBodyCompositionForm() {
        $(config.selectors.bodyCompositionForm).on('submit', function(e) {
            e.preventDefault();
            submitProgressForm($(this), {
                action: 'athlete_dashboard_store_comprehensive_body_composition_progress',
                successCallback: function() {
                    if (typeof window.AthleteCharts !== 'undefined') {
                        window.AthleteCharts.updateComprehensiveBodyCompositionChart();
                    }
                }
            });
        });
    }

    /**
     * Initialize workout log form
     */
    function initializeWorkoutLogForm() {
        $(config.selectors.workoutLogForm).on('submit', function(e) {
            e.preventDefault();
            submitProgressForm($(this), {
                action: 'athlete_dashboard_submit_workout_log',
                successCallback: function() {
                    if (typeof window.AthleteWorkoutLog !== 'undefined') {
                        window.AthleteWorkoutLog.refreshRecentWorkouts();
                    }
                }
            });
        });
    }

    /**
     * Initialize meal log form
     */
    function initializeMealLogForm() {
        $(config.selectors.mealLogForm).off('submit').on('submit', function(e) {
            e.preventDefault();
            if (config.submitting) return;

            const $form = $(this);
            const $submitButton = $form.find('button[type="submit"]');
            
            submitProgressForm($form, {
                action: 'athlete_dashboard_submit_meal_log',
                beforeSubmit: function() {
                    config.submitting = true;
                    $submitButton.prop('disabled', true);
                },
                successCallback: function() {
                    if (typeof window.AthleteMealLog !== 'undefined') {
                        window.AthleteMealLog.refreshRecentMeals();
                    }
                },
                completeCallback: function() {
                    config.submitting = false;
                    $submitButton.prop('disabled', false);
                }
            });
        });
    }

    /**
     * Submit a progress form
     */
    function submitProgressForm($form, options) {
        const formData = $form.serialize();
        const ajaxData = formData + '&action=' + options.action + '&nonce=' + window.athleteDashboard.nonce;

        if (options.beforeSubmit) {
            options.beforeSubmit();
        }

        submitAjaxRequest(ajaxData, {
            successCallback: function(response) {
                $form[0].reset();
                if (options.successCallback) {
                    options.successCallback(response);
                }
            },
            completeCallback: options.completeCallback
        });
    }

    /**
     * Submit an AJAX request
     */
    function submitAjaxRequest(data, options) {
        $.ajax({
            url: window.athleteDashboard.ajax_url,
            type: 'POST',
            data: data,
            success: function(response) {
                if (response.success) {
                    showNotification(response.data.message || 'Data submitted successfully!', 'success');
                    if (options.successCallback) {
                        options.successCallback(response);
                    }
                } else {
                    console.error('Error submitting data:', response.data.message);
                    showNotification('Error: ' + response.data.message, 'error');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', error);
                showNotification('An error occurred. Please try again.', 'error');
            },
            complete: function() {
                if (options.completeCallback) {
                    options.completeCallback();
                }
            }
        });
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
     * Initialize all form components
     */
    function initialize() {
        initializeBodyWeightProgressForm();
        initializeSquatProgressForm();
        initializeBenchPressProgressForm();
        initializeDeadliftProgressForm();
        initializeExerciseProgressForm();
        initializeComprehensiveBodyCompositionForm();
        initializeWorkoutLogForm();
        initializeMealLogForm();
    }

    // Public API
    return {
        initialize
    };

})(jQuery);

// Initialize when document is ready
jQuery(document).ready(function() {
    AthleteForms.initialize();
}); 