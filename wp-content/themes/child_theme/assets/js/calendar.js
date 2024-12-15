/**
 * Workout Calendar JavaScript
 * 
 * Handles calendar interactions and AJAX functionality
 */

(function($) {
    'use strict';

    // Calendar class
    class WorkoutCalendar {
        constructor() {
            this.currentDate = new Date();
            this.container = $('.athlete-dashboard-calendar');
            this.daysContainer = this.container.find('.calendar-days');
            this.monthDisplay = this.container.find('.current-month');
            this.modal = this.container.find('.workout-details-modal');
            
            this.initializeCalendar();
            this.bindEvents();
        }

        initializeCalendar() {
            this.renderCalendar();
            this.loadCalendarData();
        }

        bindEvents() {
            // Navigation events
            this.container.on('click', '.prev-month', () => this.navigateMonth(-1));
            this.container.on('click', '.next-month', () => this.navigateMonth(1));

            // Day click events
            this.daysContainer.on('click', '.calendar-day[data-log-id]', (e) => {
                const logId = $(e.currentTarget).data('log-id');
                this.showWorkoutDetails(logId);
            });

            // Modal events
            this.modal.on('click', '.close-modal', () => this.hideModal());
            $(document).on('keyup', (e) => {
                if (e.key === 'Escape') this.hideModal();
            });
        }

        renderCalendar() {
            const year = this.currentDate.getFullYear();
            const month = this.currentDate.getMonth();
            
            // Update month display
            const monthName = new Intl.DateTimeFormat('default', { month: 'long' }).format(this.currentDate);
            this.monthDisplay.text(`${monthName} ${year}`);

            // Clear existing days
            this.daysContainer.empty();

            // Get first day of month and total days
            const firstDay = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();

            // Add empty cells for days before first of month
            for (let i = 0; i < firstDay; i++) {
                this.daysContainer.append('<div class="calendar-day empty"></div>');
            }

            // Add days of month
            for (let day = 1; day <= daysInMonth; day++) {
                const dayElement = $('<div>', {
                    class: 'calendar-day',
                    'data-date': `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`,
                    text: day
                });
                this.daysContainer.append(dayElement);
            }
        }

        loadCalendarData() {
            const year = this.currentDate.getFullYear();
            const month = this.currentDate.getMonth() + 1;

            this.daysContainer.addClass('loading');

            $.ajax({
                url: athleteDashboardCalendar.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'get_calendar_data',
                    nonce: athleteDashboardCalendar.nonce,
                    year: year,
                    month: month
                },
                success: (response) => {
                    if (response.success) {
                        this.updateCalendarDays(response.data);
                    }
                },
                complete: () => {
                    this.daysContainer.removeClass('loading');
                }
            });
        }

        updateCalendarDays(data) {
            // Reset all days
            this.daysContainer.find('.calendar-day').removeClass('has-workout completed');

            // Update days with workout data
            Object.entries(data).forEach(([date, workout]) => {
                const dayElement = this.daysContainer.find(`[data-date="${date}"]`);
                if (dayElement.length) {
                    dayElement
                        .addClass('has-workout')
                        .toggleClass('completed', workout.completed)
                        .attr('data-log-id', workout.id)
                        .append($('<div>', {
                            class: 'workout-title',
                            text: workout.title
                        }));
                }
            });
        }

        showWorkoutDetails(logId) {
            this.modal.find('.workout-details-content').empty().append(
                $('<div>', { class: 'loading-spinner', text: athleteDashboardCalendar.i18n.loading })
            );
            
            this.modal.fadeIn();

            $.ajax({
                url: athleteDashboardCalendar.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'get_day_details',
                    nonce: athleteDashboardCalendar.nonce,
                    log_id: logId
                },
                success: (response) => {
                    if (response.success) {
                        this.modal.find('.workout-details-content').html(response.data.html);
                    }
                }
            });
        }

        hideModal() {
            this.modal.fadeOut();
        }

        navigateMonth(delta) {
            this.currentDate.setMonth(this.currentDate.getMonth() + delta);
            this.renderCalendar();
            this.loadCalendarData();
        }
    }

    // Initialize calendar when document is ready
    $(document).ready(() => {
        if ($('.athlete-dashboard-calendar').length) {
            new WorkoutCalendar();
        }
    });

})(jQuery); 