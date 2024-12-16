/**
 * Athlete Dashboard Main Entry Point
 * Handles module initialization and error handling
 */

// Import all modules
import { UI } from './modules/ui.js';
import { Workout } from './modules/workout.js';
import { Goals } from './modules/goals.js';
import { Attendance } from './modules/attendance.js';
import { Membership } from './modules/membership.js';
import { Messaging } from './modules/messaging.js';
import { Charts } from './modules/charts.js';

class AthleteDashboard {
    constructor() {
        this.modules = new Map([
            ['ui', UI],
            ['workout', Workout],
            ['goals', Goals],
            ['attendance', Attendance],
            ['membership', Membership],
            ['messaging', Messaging],
            ['charts', Charts]
        ]);

        this.initialized = false;
    }

    async init() {
        if (this.initialized) return;

        try {
            // Initialize UI first as other modules depend on it
            await this.initializeModule('ui');

            // Initialize other modules in parallel
            const moduleInitPromises = Array.from(this.modules.entries())
                .filter(([name]) => name !== 'ui')
                .map(([name, module]) => this.initializeModule(name));

            await Promise.all(moduleInitPromises);

            this.initialized = true;
            console.log('Athlete Dashboard initialized successfully');
        } catch (error) {
            console.error('Error initializing Athlete Dashboard:', error);
            this.handleInitializationError(error);
        }
    }

    async initializeModule(moduleName) {
        const module = this.modules.get(moduleName);
        if (!module) {
            console.warn(`Module ${moduleName} not found`);
            return;
        }

        try {
            await module.init();
            console.log(`Module ${moduleName} initialized`);
        } catch (error) {
            console.error(`Error initializing ${moduleName} module:`, error);
            throw error;
        }
    }

    handleInitializationError(error) {
        // Show error message to user
        const container = document.querySelector('.athlete-dashboard-container');
        if (container) {
            UI.showError('Error initializing dashboard. Please refresh the page or contact support.', container);
        }

        // Log error details
        const errorDetails = {
            message: error.message,
            stack: error.stack,
            timestamp: new Date().toISOString(),
            url: window.location.href,
            userAgent: navigator.userAgent
        };

        // Send error to server for logging
        fetch(window.athleteDashboard.ajax_url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                action: 'log_dashboard_error',
                nonce: window.athleteDashboard.nonce,
                error: JSON.stringify(errorDetails)
            })
        }).catch(err => console.error('Error logging dashboard error:', err));
    }
}

// Create and export dashboard instance
export const dashboard = new AthleteDashboard();

// Initialize when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => dashboard.init());
} else {
    dashboard.init();
} 