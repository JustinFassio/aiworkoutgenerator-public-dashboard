/**
 * Main initialization file for the Athlete Dashboard
 * Coordinates all modular components and provides global configuration
 */
(function($) {
    'use strict';

    // Global configuration object
    window.athleteDashboardConfig = {
        updateInterval: 300000, // 5 minutes
        ajaxUrl: window.athleteDashboard.ajax_url,
        nonce: window.athleteDashboard.nonce,
        exerciseTests: window.athleteDashboard.exerciseTests
    };

    // Event bus for component communication
    const EventBus = {
        events: {},
        subscribe: function(event, callback) {
            if (!this.events[event]) {
                this.events[event] = [];
            }
            this.events[event].push(callback);
        },
        publish: function(event, data) {
            if (!this.events[event]) {
                return;
            }
            this.events[event].forEach(callback => callback(data));
        }
    };

    // Make event bus globally available
    window.athleteDashboardEvents = EventBus;

    // Helper functions
    const Helpers = {
        debounce: function(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        },
        
        showNotification: function(message, type = 'info') {
            // Check if we have a custom notification system
            if (typeof window.AthleteUI !== 'undefined' && window.AthleteUI.showNotification) {
                window.AthleteUI.showNotification(message, type);
            } else {
                // Fallback to alert
                alert(message);
            }
        }
    };

    // Make helpers globally available
    window.athleteDashboardHelpers = Helpers;

    // Initialize all components when document is ready
    $(document).ready(function() {
        // Initialize UI components
        if (typeof window.AthleteUI !== 'undefined') {
            window.AthleteUI.initialize();
        }

        // Initialize Profile components
        if (typeof window.AthleteProfile !== 'undefined') {
            window.AthleteProfile.initialize();
        }

        // Initialize Forms
        if (typeof window.AthleteForms !== 'undefined') {
            window.AthleteForms.initialize();
        }

        // Initialize Nutrition components
        if (typeof window.AthleteNutrition !== 'undefined') {
            window.AthleteNutrition.initialize();
        }

        // Initialize Workout components
        if (typeof window.AthleteWorkout !== 'undefined') {
            window.AthleteWorkout.initialize();
        }

        // Initialize Charts
        if (typeof window.AthleteCharts !== 'undefined') {
            window.AthleteCharts.initialize();
        }

        // Initialize Goals
        if (typeof window.AthleteGoals !== 'undefined') {
            window.AthleteGoals.initialize();
        }

        // Initialize Attendance
        if (typeof window.AthleteAttendance !== 'undefined') {
            window.AthleteAttendance.initialize();
        }

        // Initialize Membership
        if (typeof window.AthleteMembership !== 'undefined') {
            window.AthleteMembership.initialize();
        }

        // Initialize Messaging
        if (typeof window.AthleteMessaging !== 'undefined') {
            window.AthleteMessaging.initialize();
        }

        // Set up window resize handler
        $(window).on('resize', Helpers.debounce(function() {
            EventBus.publish('window:resize');
        }, 250));

        // Log initialization complete
        console.log('Athlete Dashboard initialized');
    });

    // Handle errors globally
    window.onerror = function(msg, url, lineNo, columnNo, error) {
        console.error('Error: ' + msg + '\nURL: ' + url + '\nLine: ' + lineNo + '\nColumn: ' + columnNo + '\nError object: ' + JSON.stringify(error));
        return false;
    };

    // Handle unhandled promise rejections
    window.onunhandledrejection = function(event) {
        console.error('Unhandled promise rejection:', event.reason);
    };

})(jQuery);