/**
 * Workout Recommendations JavaScript
 * 
 * Handles recommendation interactions and workout previews
 */

(function($) {
    'use strict';

    class WorkoutRecommendations {
        constructor() {
            this.container = $('.athlete-dashboard-recommendations');
            this.modal = this.container.find('.workout-preview-modal');
            this.workoutContainer = this.container.find('.recommended-workouts');
            this.exerciseContainer = this.container.find('.recommended-exercises');

            this.bindEvents();
            this.refreshRecommendations();
        }

        bindEvents() {
            // Preview workout
            this.container.on('click', '.preview-workout', (e) => {
                const workoutId = $(e.currentTarget).data('workout-id');
                this.showWorkoutPreview(workoutId);
            });

            // Modal close events
            this.modal.on('click', '.close-modal', () => this.hideModal());
            this.modal.on('click', (e) => {
                if ($(e.target).is(this.modal)) {
                    this.hideModal();
                }
            });
            $(document).on('keyup', (e) => {
                if (e.key === 'Escape') this.hideModal();
            });

            // Refresh recommendations periodically
            setInterval(() => this.refreshRecommendations(), 300000); // Every 5 minutes
        }

        showWorkoutPreview(workoutId) {
            this.modal.find('.workout-preview-content').empty().append(
                $('<div>', { class: 'loading-spinner', text: athleteDashboardRecommendations.i18n.loading })
            );
            
            this.modal.fadeIn();

            $.ajax({
                url: athleteDashboardRecommendations.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'get_workout_preview',
                    nonce: athleteDashboardRecommendations.nonce,
                    workout_id: workoutId
                },
                success: (response) => {
                    if (response.success) {
                        this.modal.find('.workout-preview-content').html(response.data.html);
                    }
                }
            });
        }

        hideModal() {
            this.modal.fadeOut();
        }

        refreshRecommendations() {
            // Refresh workout recommendations
            $.ajax({
                url: athleteDashboardRecommendations.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'get_workout_recommendations',
                    nonce: athleteDashboardRecommendations.nonce
                },
                success: (response) => {
                    if (response.success) {
                        this.workoutContainer.find('.workout-recommendations').replaceWith(response.data.html);
                    }
                }
            });

            // Refresh exercise recommendations
            $.ajax({
                url: athleteDashboardRecommendations.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'get_exercise_recommendations',
                    nonce: athleteDashboardRecommendations.nonce
                },
                success: (response) => {
                    if (response.success) {
                        this.exerciseContainer.find('.exercise-recommendations').replaceWith(response.data.html);
                    }
                }
            });
        }

        // Helper method to animate recommendation cards
        animateCard(card) {
            card.addClass('highlight');
            setTimeout(() => card.removeClass('highlight'), 1000);
        }
    }

    // Initialize recommendations when document is ready
    $(document).ready(() => {
        if ($('.athlete-dashboard-recommendations').length) {
            new WorkoutRecommendations();
        }
    });

})(jQuery); 