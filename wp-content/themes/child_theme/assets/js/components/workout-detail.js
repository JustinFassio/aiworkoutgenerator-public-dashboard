/**
 * Workout Detail Component
 * Handles the display and interaction of workout details
 */
(function($) {
    'use strict';

    class WorkoutDetailComponent {
        constructor() {
            this.initializeComponent();
        }

        initializeComponent() {
            // Wait for DOM to be ready
            $(document).ready(() => {
                this.container = $('[data-component="workout-detail"]');
                this.detailContainer = this.container.find('.workout-detail-container');
                
                if (this.container.length === 0 || this.detailContainer.length === 0) {
                    console.warn('Workout detail component elements not found - will be initialized when content loads');
                    return;
                }

                this.bindEvents();
                this.initializeEventListeners();
            });
        }

        /**
         * Bind events for workout detail interactions
         */
        bindEvents() {
            // Close detail view when clicking outside
            $(document).on('click', (e) => {
                if (!$(e.target).closest(this.container).length) {
                    this.hideDetail();
                }
            });

            // Handle workout detail triggers
            $(document).on('click', '[data-workout-detail]', (e) => {
                e.preventDefault();
                const workoutId = $(e.currentTarget).data('workout-detail');
                this.loadWorkoutDetail(workoutId);
            });
        }

        /**
         * Initialize additional event listeners
         */
        initializeEventListeners() {
            // Custom events
            $(document).on('workoutSaved', () => this.refreshWorkoutList());
            $(document).on('workoutDeleted', () => this.refreshWorkoutList());
        }

        /**
         * Load workout detail
         */
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
                    } else {
                        console.error('Error loading workout detail:', response.data);
                    }
                },
                error: (xhr, status, error) => {
                    console.error('Ajax error:', error);
                }
            });
        }

        /**
         * Show workout detail
         */
        showDetail(content) {
            this.detailContainer.html(content).show();
            this.container.addClass('is-visible');
        }

        /**
         * Hide workout detail
         */
        hideDetail() {
            this.container.removeClass('is-visible');
            setTimeout(() => {
                this.detailContainer.empty().hide();
            }, 300);
        }

        /**
         * Refresh workout list
         */
        refreshWorkoutList() {
            // Trigger workout list refresh event
            $(document).trigger('refreshWorkoutList');
        }
    }

    // Initialize the component
    window.athleteWorkoutDetail = new WorkoutDetailComponent();

})(jQuery); 