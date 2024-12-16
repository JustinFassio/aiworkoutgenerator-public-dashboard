/**
 * Athlete Dashboard Attendance Module
 */
(function($) {
    'use strict';

    const AthleteAttendance = {
        init: function() {
            this.bindEvents();
            this.initializeAttendanceCalendar();
            this.loadAttendanceStats();
        },

        bindEvents: function() {
            $(document).on('click', '.record-attendance-btn', this.handleRecordAttendance.bind(this));
            $(document).on('change', '.attendance-period-selector', this.handlePeriodChange.bind(this));
        },

        initializeAttendanceCalendar: function() {
            const today = new Date();
            const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
            const lastDay = new Date(today.getFullYear(), today.getMonth() + 1, 0);

            this.loadAttendanceData(firstDay, lastDay);
        },

        loadAttendanceData: function(startDate, endDate) {
            $.ajax({
                url: athleteDashboard.ajax_url,
                type: 'POST',
                data: {
                    action: 'get_attendance',
                    nonce: athleteDashboard.nonce,
                    start_date: this.formatDate(startDate),
                    end_date: this.formatDate(endDate)
                },
                success: function(response) {
                    if (response.success) {
                        this.renderAttendanceCalendar(response.data);
                    }
                }.bind(this)
            });
        },

        loadAttendanceStats: function() {
            $.ajax({
                url: athleteDashboard.ajax_url,
                type: 'POST',
                data: {
                    action: 'get_attendance_stats',
                    nonce: athleteDashboard.nonce
                },
                success: function(response) {
                    if (response.success) {
                        this.updateAttendanceStats(response.data);
                    }
                }.bind(this)
            });
        },

        handleRecordAttendance: function(e) {
            e.preventDefault();
            const date = $(e.target).data('date');

            $.ajax({
                url: athleteDashboard.ajax_url,
                type: 'POST',
                data: {
                    action: 'record_attendance',
                    nonce: athleteDashboard.nonce,
                    date: date
                },
                success: function(response) {
                    if (response.success) {
                        this.showMessage('Attendance recorded successfully!', 'success');
                        this.initializeAttendanceCalendar();
                        this.loadAttendanceStats();
                    } else {
                        this.showMessage('Error recording attendance. Please try again.', 'error');
                    }
                }.bind(this)
            });
        },

        handlePeriodChange: function(e) {
            const period = $(e.target).val();
            const dates = this.getPeriodDates(period);
            this.loadAttendanceData(dates.start, dates.end);
        },

        getPeriodDates: function(period) {
            const today = new Date();
            let startDate, endDate;

            switch (period) {
                case 'week':
                    startDate = new Date(today.setDate(today.getDate() - today.getDay()));
                    endDate = new Date(today.setDate(today.getDate() + 6));
                    break;
                case 'month':
                    startDate = new Date(today.getFullYear(), today.getMonth(), 1);
                    endDate = new Date(today.getFullYear(), today.getMonth() + 1, 0);
                    break;
                case 'year':
                    startDate = new Date(today.getFullYear(), 0, 1);
                    endDate = new Date(today.getFullYear(), 11, 31);
                    break;
                default:
                    startDate = new Date(today.getFullYear(), today.getMonth(), 1);
                    endDate = new Date(today.getFullYear(), today.getMonth() + 1, 0);
            }

            return { start: startDate, end: endDate };
        },

        renderAttendanceCalendar: function(data) {
            // Implementation will depend on your calendar UI structure
            const $calendar = $('#attendance-calendar');
            $calendar.html(data.calendar);
            
            // Highlight attended days
            data.attended_dates.forEach(function(date) {
                $calendar.find(`[data-date="${date}"]`).addClass('attended');
            });
        },

        updateAttendanceStats: function(stats) {
            $('#attendance-rate').text(stats.attendance_rate + '%');
            $('#current-streak').text(stats.current_streak + ' days');
            $('#best-streak').text(stats.best_streak + ' days');
        },

        formatDate: function(date) {
            return date.toISOString().split('T')[0];
        },

        showMessage: function(message, type) {
            const $messageDiv = $('.attendance-message');
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
        AthleteAttendance.init();
    });

})(jQuery); 