/**
 * Main Dashboard Script
 */
class AthleteDashboard {
    constructor() {
        this.components = {};
        this.init();
    }

    init() {
        // Initialize notification system
        this.initNotifications();

        // Initialize components when DOM is ready
        document.addEventListener('DOMContentLoaded', () => {
            this.initializeComponents();
        });
    }

    initNotifications() {
        this.notificationContainer = document.createElement('div');
        this.notificationContainer.className = 'notification-container';
        document.body.appendChild(this.notificationContainer);
    }

    showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.textContent = message;

        this.notificationContainer.appendChild(notification);

        // Remove notification after 3 seconds
        setTimeout(() => {
            notification.classList.add('fade-out');
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 3000);
    }

    initializeComponents() {
        // Initialize components only if their elements exist
        if (document.querySelector('.account-details')) {
            this.components.accountDetails = new AccountDetailsComponent();
        }

        if (document.querySelector('.progress-tracker')) {
            this.components.progressTracker = new ProgressTrackerComponent();
        }

        if (document.querySelector('.workout-lightbox')) {
            this.components.workoutLightbox = new WorkoutLightboxComponent();
        }

        if (document.querySelector('.workout-logger')) {
            this.components.workoutLogger = new WorkoutLoggerComponent();
        }

        if (document.querySelector('.nutrition-logger')) {
            this.components.nutritionLogger = new NutritionLoggerComponent();
        }

        if (document.querySelector('.nutrition-tracker')) {
            this.components.nutritionTracker = new NutritionTrackerComponent();
        }

        if (document.querySelector('.food-manager')) {
            this.components.foodManager = new FoodManagerComponent();
        }
    }
}

// Initialize the dashboard
window.athleteDashboard = new AthleteDashboard(); 