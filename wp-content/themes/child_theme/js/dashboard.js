/**
 * Main Dashboard Script
 * Coordinates the initialization and management of athlete dashboard components
 */
(function($) {
    'use strict';

    class AthleteDashboard {
        constructor() {
            this.components = {};
            this.init();
        }

        init() {
            // Initialize components when DOM is ready
            $(document).ready(() => {
                this.initializeComponents();
            });
        }

        initializeComponents() {
            // Components will be initialized by their individual scripts
            // They will attach themselves to window.athleteDashboard.components
            $(document).trigger('athleteDashboard.componentsReady');
        }
    }

    // Initialize the dashboard
    window.athleteDashboard = new AthleteDashboard();

})(jQuery); 