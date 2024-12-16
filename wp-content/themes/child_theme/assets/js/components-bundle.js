/**
 * Athlete Dashboard Components Bundle
 * All dashboard components bundled into a single file
 */
(function($) {
    'use strict';

    // Component namespace
    window.AthleteDashboard = window.AthleteDashboard || {};
    window.AthleteDashboard.Components = {};

    // Base component class
    class BaseComponent {
        constructor(options = {}) {
            this.options = options;
            this.initialized = false;
        }

        initialize() {
            if (this.initialized) return;
            this.initialized = true;
        }
    }

    // Workout Detail Component
    class WorkoutDetail extends BaseComponent {
        constructor(options) {
            super(options);
            this.container = $('[data-component="workout-detail"]');
            this.detailContainer = this.container.find('.workout-detail-container');
            this.initialize();
        }

        initialize() {
            super.initialize();
            this.bindEvents();
        }

        bindEvents() {
            $(document).on('click', '[data-workout-detail]', (e) => {
                e.preventDefault();
                const workoutId = $(e.currentTarget).data('workout-detail');
                this.loadWorkoutDetail(workoutId);
            });
        }

        loadWorkoutDetail(workoutId) {
            $.ajax({
                url: athleteDashboardData.ajaxurl,
                type: 'POST',
                data: {
                    action: 'get_workout_detail',
                    workout_id: workoutId,
                    nonce: athleteDashboardData.nonce
                },
                success: (response) => {
                    if (response.success) {
                        this.showDetail(response.data);
                    }
                }
            });
        }

        showDetail(content) {
            this.detailContainer.html(content).show();
            this.container.addClass('is-visible');
        }
    }

    // Stats Component
    class WorkoutStats extends BaseComponent {
        constructor(options) {
            super(options);
            this.container = $('#workout-stats-section');
            this.initialize();
        }

        initialize() {
            super.initialize();
            this.initializeCharts();
        }

        initializeCharts() {
            // Chart initialization code here
        }
    }

    // Initialize components
    $(document).ready(() => {
        window.AthleteDashboard.Components = {
            workoutDetail: new WorkoutDetail(),
            workoutStats: new WorkoutStats()
        };
    });

})(jQuery); 