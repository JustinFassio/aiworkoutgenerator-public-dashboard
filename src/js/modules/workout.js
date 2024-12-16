/**
 * Athlete Dashboard Workout Module
 */
import { UI } from './ui.js';

export class AthleteWorkout {
    constructor() {
        this.initialized = false;
        this.exerciseList = window.athleteDashboard?.exerciseTests || [];
    }

    init() {
        if (this.initialized) return;
        this.bindEvents();
        this.initializeWorkoutForms();
        this.initialized = true;
    }

    bindEvents() {
        document.addEventListener('submit', (e) => {
            if (e.target.matches('.workout-form')) {
                this.handleWorkoutSubmit(e);
            }
        });

        document.addEventListener('click', (e) => {
            if (e.target.matches('.log-workout-btn')) {
                this.handleLogWorkout(e);
            }
        });
    }

    initializeWorkoutForms() {
        // Initialize date inputs
        document.querySelectorAll('.workout-date').forEach(dateInput => {
            dateInput.type = 'date';
            dateInput.max = new Date().toISOString().split('T')[0];
        });

        // Initialize exercise selectors
        this.initializeExerciseSelectors();
    }

    initializeExerciseSelectors() {
        document.querySelectorAll('.exercise-selector').forEach(selector => {
            // Create datalist for autocomplete
            const datalistId = `exercise-list-${Math.random().toString(36).substr(2, 9)}`;
            const datalist = document.createElement('datalist');
            datalist.id = datalistId;
            
            this.exerciseList.forEach(exercise => {
                const option = document.createElement('option');
                option.value = exercise;
                datalist.appendChild(option);
            });

            selector.setAttribute('list', datalistId);
            selector.after(datalist);
        });
    }

    async handleWorkoutSubmit(e) {
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);
        const container = form.closest('.workout-container');
        
        // Show loading state
        const loader = UI.showLoading(container);

        try {
            const response = await fetch(window.athleteDashboard.ajax_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'log_workout',
                    nonce: window.athleteDashboard.nonce,
                    workout_data: JSON.stringify(Object.fromEntries(formData))
                })
            });

            const data = await response.json();
            
            if (data.success) {
                this.showMessage('Workout logged successfully!', 'success', container);
                form.reset();
            } else {
                this.showMessage(data.data?.message || 'Error logging workout. Please try again.', 'error', container);
            }
        } catch (error) {
            this.showMessage('Server error. Please try again later.', 'error', container);
            console.error('Workout submission error:', error);
        } finally {
            UI.hideLoading(loader);
        }
    }

    async handleLogWorkout(e) {
        e.preventDefault();
        const workoutId = e.target.dataset.workoutId;
        const container = document.getElementById('workout-form-container');
        
        if (!container) return;

        const loader = UI.showLoading(container);

        try {
            const response = await fetch(window.athleteDashboard.ajax_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'get_workout_form',
                    nonce: window.athleteDashboard.nonce,
                    workout_id: workoutId
                })
            });

            const data = await response.json();
            
            if (data.success) {
                container.innerHTML = data.data.form;
                this.initializeWorkoutForms();
            } else {
                this.showMessage(data.data?.message || 'Error loading workout form.', 'error', container);
            }
        } catch (error) {
            this.showMessage('Server error. Please try again later.', 'error', container);
            console.error('Workout form load error:', error);
        } finally {
            UI.hideLoading(loader);
        }
    }

    showMessage(message, type, container) {
        const messageDiv = container.querySelector('.workout-message') || 
            UI.createElement('div', 'workout-message');
        
        messageDiv.className = `workout-message ${type}`;
        messageDiv.textContent = message;
        
        if (!messageDiv.parentNode) {
            container.insertBefore(messageDiv, container.firstChild);
        }

        // Auto-hide message
        setTimeout(() => {
            messageDiv.classList.add('fade-out');
            setTimeout(() => messageDiv.remove(), 300);
        }, 3000);
    }
}

// Export singleton instance
export const Workout = new AthleteWorkout();

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => Workout.init()); 