/**
 * AthleteWorkout Module
 * Handles all workout-related functionality for the athlete dashboard
 */
const AthleteWorkout = (function($) {
    'use strict';

    // Private variables
    let config = {
        selectors: {
            workoutLog: '#workout-log',
            workoutForm: '#workout-log-form',
            workoutList: '.workout-list',
            workoutStats: '.workout-stats',
            workoutDetail: '.workout-detail',
            exerciseList: '.exercise-list',
            workoutPreview: '.workout-preview'
        },
        updateInterval: 300000 // 5 minutes
    };

    /**
     * Initialize workout logging functionality
     */
    function initializeWorkoutLog() {
        $(config.selectors.workoutForm).on('submit', function(e) {
            e.preventDefault();
            submitWorkoutLog($(this));
        });
    }

    /**
     * Submit workout log
     */
    function submitWorkoutLog($form) {
        const formData = $form.serialize();
        $.ajax({
            url: window.athleteDashboard.ajax_url,
            type: 'POST',
            data: formData + '&action=athlete_dashboard_submit_workout_log&nonce=' + window.athleteDashboard.nonce,
            success: function(response) {
                if (response.success) {
                    $form[0].reset();
                    refreshWorkoutList();
                    showNotification('Workout logged successfully!', 'success');
                } else {
                    console.error('Error logging workout:', response.data.message);
                    showNotification('Error: ' + response.data.message, 'error');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error logging workout:', error);
                showNotification('An error occurred while logging the workout. Please try again.', 'error');
            }
        });
    }

    /**
     * Refresh workout list
     */
    function refreshWorkoutList() {
        $.ajax({
            url: window.athleteDashboard.ajax_url,
            type: 'POST',
            data: {
                action: 'athlete_dashboard_get_recent_workouts',
                nonce: window.athleteDashboard.nonce
            },
            success: function(response) {
                if (response.success) {
                    $(config.selectors.workoutList).html(response.data.html);
                    updateWorkoutStats();
                } else {
                    console.error('Error refreshing workout list:', response.data.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error refreshing workout list:', error);
            }
        });
    }

    /**
     * Update workout statistics
     */
    function updateWorkoutStats() {
        $.ajax({
            url: window.athleteDashboard.ajax_url,
            type: 'POST',
            data: {
                action: 'athlete_dashboard_get_workout_stats',
                nonce: window.athleteDashboard.nonce
            },
            success: function(response) {
                if (response.success) {
                    $(config.selectors.workoutStats).html(response.data.html);
                } else {
                    console.error('Error updating workout stats:', response.data.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error updating workout stats:', error);
            }
        });
    }

    /**
     * Load workout details
     */
    function loadWorkoutDetails(workoutId) {
        $.ajax({
            url: window.athleteDashboard.ajax_url,
            type: 'POST',
            data: {
                action: 'athlete_dashboard_get_workout_details',
                workout_id: workoutId,
                nonce: window.athleteDashboard.nonce
            },
            success: function(response) {
                if (response.success) {
                    $(config.selectors.workoutDetail).html(response.data.html);
                } else {
                    console.error('Error loading workout details:', response.data.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error loading workout details:', error);
            }
        });
    }

    /**
     * Preview workout
     */
    function previewWorkout(workoutId) {
        $.ajax({
            url: window.athleteDashboard.ajax_url,
            type: 'POST',
            data: {
                action: 'athlete_dashboard_preview_workout',
                workout_id: workoutId,
                nonce: window.athleteDashboard.nonce
            },
            success: function(response) {
                if (response.success) {
                    $(config.selectors.workoutPreview).html(response.data.html).show();
                } else {
                    console.error('Error previewing workout:', response.data.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error previewing workout:', error);
            }
        });
    }

    /**
     * Show notification message
     */
    function showNotification(message, type) {
        if (typeof window.AthleteUI !== 'undefined' && window.AthleteUI.showNotification) {
            window.AthleteUI.showNotification(message, type);
        } else {
            alert(message);
        }
    }

    /**
     * Start periodic updates
     */
    function startPeriodicUpdates() {
        setInterval(function() {
            refreshWorkoutList();
        }, config.updateInterval);
    }

    /**
     * Initialize event listeners
     */
    function initializeEventListeners() {
        // Workout detail view
        $(document).on('click', '.view-workout', function(e) {
            e.preventDefault();
            const workoutId = $(this).data('workout-id');
            loadWorkoutDetails(workoutId);
        });

        // Workout preview
        $(document).on('click', '.preview-workout', function(e) {
            e.preventDefault();
            const workoutId = $(this).data('workout-id');
            previewWorkout(workoutId);
        });
    }

    /**
     * Initialize all workout components
     */
    function initialize() {
        initializeWorkoutLog();
        initializeEventListeners();
        refreshWorkoutList();
        startPeriodicUpdates();
    }

    // Public API
    return {
        initialize,
        refreshWorkoutList,
        loadWorkoutDetails,
        previewWorkout
    };

})(jQuery);

// Initialize when document is ready
jQuery(document).ready(function() {
    AthleteWorkout.initialize();
}); 