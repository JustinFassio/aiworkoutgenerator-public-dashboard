/**
 * Workout Manager Section
 */
class WorkoutManagerSection {
    constructor() {
        if (WorkoutManagerSection.instance) {
            return WorkoutManagerSection.instance;
        }
        WorkoutManagerSection.instance = this;

        // Initialize when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => this.initialize());
        } else {
            this.initialize();
        }
    }

    initialize() {
        // Initialize event listeners
        this.initializeEventListeners();

        // Initialize components
        this.initializeComponents();

        // Load initial data
        this.loadWorkoutStats();
    }

    initializeEventListeners() {
        document.addEventListener('click', (e) => {
            // View workout button
            if (e.target.closest('.view-workout-button')) {
                const button = e.target.closest('.view-workout-button');
                const workoutId = button.dataset.workoutId;
                if (workoutId && window.workoutLightbox) {
                    window.workoutLightbox.loadWorkout(workoutId);
                }
            }

            // Start workout button
            if (e.target.closest('.start-workout-button')) {
                const button = e.target.closest('.start-workout-button');
                const workoutId = button.dataset.workoutId;
                if (workoutId) {
                    this.startWorkout(workoutId);
                }
            }

            // Log workout button
            if (e.target.closest('.log-workout-button')) {
                const button = e.target.closest('.log-workout-button');
                const workoutId = button.dataset.workoutId;
                if (workoutId && window.workoutLogger) {
                    window.workoutLogger.openLogger(workoutId);
                }
            }

            // Reschedule workout button
            if (e.target.closest('.reschedule-workout-button')) {
                const button = e.target.closest('.reschedule-workout-button');
                const workoutId = button.dataset.workoutId;
                if (workoutId) {
                    this.openRescheduleDialog(workoutId);
                }
            }
        });

        // Listen for workout completion
        document.addEventListener('workoutCompleted', () => {
            this.refreshWorkoutData();
        });
    }

    initializeComponents() {
        // Initialize any section-specific components here
    }

    startWorkout(workoutId) {
        // Show confirmation dialog
        if (confirm(workoutManagerData.strings.startWorkoutConfirm)) {
            const formData = new FormData();
            formData.append('action', 'start_workout');
            formData.append('nonce', workoutManagerData.nonce);
            formData.append('workout_id', workoutId);

            fetch(workoutManagerData.ajaxurl, {
                method: 'POST',
                body: formData,
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = data.data.redirect_url;
                } else {
                    throw new Error(data.data.message);
                }
            })
            .catch(error => {
                console.error('Error starting workout:', error);
                alert(workoutManagerData.strings.error);
            });
        }
    }

    openRescheduleDialog(workoutId) {
        // Implementation for rescheduling dialog
        // This could be a modal or redirect to a scheduling page
    }

    loadWorkoutStats() {
        const statsContainer = document.querySelector('.workout-stats-content');
        if (!statsContainer) return;

        statsContainer.classList.add('loading');

        const formData = new FormData();
        formData.append('action', 'get_workout_stats');
        formData.append('nonce', workoutManagerData.nonce);

        fetch(workoutManagerData.ajaxurl, {
            method: 'POST',
            body: formData,
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                this.updateStatsDisplay(data.data);
            } else {
                throw new Error(data.data.message);
            }
        })
        .catch(error => {
            console.error('Error loading workout stats:', error);
            statsContainer.innerHTML = `
                <div class="error-message">
                    ${workoutManagerData.strings.error}
                </div>
            `;
        })
        .finally(() => {
            statsContainer.classList.remove('loading');
        });
    }

    updateStatsDisplay(stats) {
        // Update statistics display
        // This will be called when new stats are loaded
    }

    refreshWorkoutData() {
        // Refresh all workout-related data
        this.loadWorkoutStats();
        
        // Trigger refresh events for child components
        document.dispatchEvent(new CustomEvent('refreshWorkouts'));
    }
}

// Initialize the section when the script loads
const initWorkoutManager = () => {
    if (typeof window.workoutManager === 'undefined') {
        window.workoutManager = new WorkoutManagerSection();
    }
};

// Initialize on DOMContentLoaded or immediately if already loaded
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initWorkoutManager);
} else {
    initWorkoutManager();
} 