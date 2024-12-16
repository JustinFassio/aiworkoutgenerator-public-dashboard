/**
 * AthleteAttendance Module
 * Handles all attendance-related functionality for the athlete dashboard
 */
const AthleteAttendance = (function($) {
    'use strict';

    // Private variables
    let config = {
        selectors: {
            attendanceContainer: '.athlete-attendance',
            attendanceCalendar: '#attendance-calendar',
            checkInForm: '#check-in-form',
            attendanceStats: '.attendance-stats',
            attendanceHistory: '.attendance-history'
        },
        updateInterval: 300000 // 5 minutes
    };

    /**
     * Initialize attendance calendar
     */
    function initializeAttendanceCalendar() {
        if (!$(config.selectors.attendanceCalendar).length) return;

        $(config.selectors.attendanceCalendar).fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            defaultView: 'month',
            editable: false,
            eventLimit: true,
            events: function(start, end, timezone, callback) {
                loadAttendanceEvents(start, end, callback);
            }
        });
    }

    /**
     * Load attendance events
     */
    function loadAttendanceEvents(start, end, callback) {
        $.ajax({
            url: window.athleteDashboard.ajax_url,
            type: 'POST',
            data: {
                action: 'athlete_dashboard_get_attendance_events',
                start: start.format(),
                end: end.format(),
                nonce: window.athleteDashboard.nonce
            },
            success: function(response) {
                if (response.success) {
                    callback(response.data.events);
                } else {
                    console.error('Error loading attendance events:', response.data.message);
                    callback([]);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error loading attendance events:', error);
                callback([]);
            }
        });
    }

    /**
     * Initialize check-in form
     */
    function initializeCheckInForm() {
        $(config.selectors.checkInForm).on('submit', function(e) {
            e.preventDefault();
            submitCheckIn($(this));
        });
    }

    /**
     * Submit check-in
     */
    function submitCheckIn($form) {
        const formData = $form.serialize();
        $.ajax({
            url: window.athleteDashboard.ajax_url,
            type: 'POST',
            data: formData + '&action=athlete_dashboard_check_in&nonce=' + window.athleteDashboard.nonce,
            success: function(response) {
                if (response.success) {
                    $form[0].reset();
                    refreshAttendanceData();
                    showNotification('Check-in successful!', 'success');
                } else {
                    console.error('Error checking in:', response.data.message);
                    showNotification('Error: ' + response.data.message, 'error');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error checking in:', error);
                showNotification('An error occurred while checking in. Please try again.', 'error');
            }
        });
    }

    /**
     * Refresh attendance data
     */
    function refreshAttendanceData() {
        // Refresh calendar
        $(config.selectors.attendanceCalendar).fullCalendar('refetchEvents');

        // Refresh stats
        updateAttendanceStats();

        // Refresh history
        updateAttendanceHistory();
    }

    /**
     * Update attendance statistics
     */
    function updateAttendanceStats() {
        $.ajax({
            url: window.athleteDashboard.ajax_url,
            type: 'POST',
            data: {
                action: 'athlete_dashboard_get_attendance_stats',
                nonce: window.athleteDashboard.nonce
            },
            success: function(response) {
                if (response.success) {
                    $(config.selectors.attendanceStats).html(response.data.html);
                } else {
                    console.error('Error updating attendance stats:', response.data.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error updating attendance stats:', error);
            }
        });
    }

    /**
     * Update attendance history
     */
    function updateAttendanceHistory() {
        $.ajax({
            url: window.athleteDashboard.ajax_url,
            type: 'POST',
            data: {
                action: 'athlete_dashboard_get_attendance_history',
                nonce: window.athleteDashboard.nonce
            },
            success: function(response) {
                if (response.success) {
                    $(config.selectors.attendanceHistory).html(response.data.html);
                } else {
                    console.error('Error updating attendance history:', response.data.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error updating attendance history:', error);
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
            refreshAttendanceData();
        }, config.updateInterval);
    }

    /**
     * Initialize event listeners
     */
    function initializeEventListeners() {
        // Calendar view change
        $(config.selectors.attendanceCalendar).on('viewRender', function(view, element) {
            updateAttendanceStats();
        });
    }

    /**
     * Initialize all attendance components
     */
    function initialize() {
        if ($(config.selectors.attendanceContainer).length) {
            initializeAttendanceCalendar();
            initializeCheckInForm();
            initializeEventListeners();
            refreshAttendanceData();
            startPeriodicUpdates();
        }
    }

    // Public API
    return {
        initialize,
        refreshAttendanceData,
        updateAttendanceStats,
        updateAttendanceHistory
    };

})(jQuery);

// Initialize when document is ready
jQuery(document).ready(function() {
    AthleteAttendance.initialize();
}); 