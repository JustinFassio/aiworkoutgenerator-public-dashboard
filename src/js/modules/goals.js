/**
 * Athlete Dashboard Goals Module
 */
import { UI } from './ui.js';

export class AthleteGoals {
    constructor() {
        this.initialized = false;
    }

    init() {
        if (this.initialized) return;
        this.bindEvents();
        this.initializeGoalForms();
        this.loadActiveGoals();
        this.initialized = true;
    }

    bindEvents() {
        document.addEventListener('submit', (e) => {
            if (e.target.matches('.goal-form')) {
                this.handleGoalSubmit(e);
            }
        });

        document.addEventListener('click', (e) => {
            if (e.target.matches('.update-progress-btn')) {
                this.handleProgressUpdate(e);
            }
            if (e.target.matches('.delete-goal-btn')) {
                this.handleGoalDelete(e);
            }
        });

        // Listen for range input changes
        document.addEventListener('input', (e) => {
            if (e.target.matches('.progress-range')) {
                this.updateProgressDisplay(e.target);
            }
        });
    }

    initializeGoalForms() {
        // Initialize date inputs
        document.querySelectorAll('.goal-deadline').forEach(dateInput => {
            dateInput.type = 'date';
            const today = new Date().toISOString().split('T')[0];
            dateInput.min = today;
        });

        // Initialize progress ranges
        document.querySelectorAll('.progress-range').forEach(range => {
            range.type = 'range';
            range.min = 0;
            range.max = 100;
            range.value = range.dataset.progress || 0;
            this.updateProgressDisplay(range);
        });
    }

    updateProgressDisplay(range) {
        const display = range.nextElementSibling;
        if (display && display.classList.contains('progress-value')) {
            display.textContent = `${range.value}%`;
        }
    }

    async loadActiveGoals() {
        const container = document.getElementById('active-goals-container');
        if (!container) return;

        const loader = UI.showLoading(container);

        try {
            const response = await fetch(window.athleteDashboard.ajax_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'get_active_goals',
                    nonce: window.athleteDashboard.nonce
                })
            });

            const data = await response.json();
            
            if (data.success) {
                container.innerHTML = data.data.goals;
                this.initializeGoalForms();
            } else {
                this.showMessage('Error loading goals. Please try again.', 'error', container);
            }
        } catch (error) {
            this.showMessage('Server error. Please try again later.', 'error', container);
            console.error('Goals loading error:', error);
        } finally {
            UI.hideLoading(loader);
        }
    }

    async handleGoalSubmit(e) {
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);
        const container = form.closest('.goals-container');
        
        const loader = UI.showLoading(container);

        try {
            const response = await fetch(window.athleteDashboard.ajax_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'save_goal',
                    nonce: window.athleteDashboard.nonce,
                    goal_data: JSON.stringify(Object.fromEntries(formData))
                })
            });

            const data = await response.json();
            
            if (data.success) {
                this.showMessage('Goal saved successfully!', 'success', container);
                await this.loadActiveGoals();
                form.reset();
            } else {
                this.showMessage(data.data?.message || 'Error saving goal. Please try again.', 'error', container);
            }
        } catch (error) {
            this.showMessage('Server error. Please try again later.', 'error', container);
            console.error('Goal submission error:', error);
        } finally {
            UI.hideLoading(loader);
        }
    }

    async handleProgressUpdate(e) {
        e.preventDefault();
        const goalId = e.target.dataset.goalId;
        const container = e.target.closest('.goal-item');
        const progressRange = container.querySelector('.progress-range');
        
        if (!container || !progressRange) return;

        const loader = UI.showLoading(container);

        try {
            const response = await fetch(window.athleteDashboard.ajax_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'update_goal_progress',
                    nonce: window.athleteDashboard.nonce,
                    goal_id: goalId,
                    progress: progressRange.value
                })
            });

            const data = await response.json();
            
            if (data.success) {
                this.showMessage('Progress updated successfully!', 'success', container);
                await this.loadActiveGoals();
            } else {
                this.showMessage(data.data?.message || 'Error updating progress. Please try again.', 'error', container);
            }
        } catch (error) {
            this.showMessage('Server error. Please try again later.', 'error', container);
            console.error('Progress update error:', error);
        } finally {
            UI.hideLoading(loader);
        }
    }

    async handleGoalDelete(e) {
        e.preventDefault();
        if (!confirm('Are you sure you want to delete this goal?')) {
            return;
        }

        const goalId = e.target.dataset.goalId;
        const container = e.target.closest('.goal-item');
        
        if (!container) return;

        const loader = UI.showLoading(container);

        try {
            const response = await fetch(window.athleteDashboard.ajax_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'delete_goal',
                    nonce: window.athleteDashboard.nonce,
                    goal_id: goalId
                })
            });

            const data = await response.json();
            
            if (data.success) {
                this.showMessage('Goal deleted successfully!', 'success', container);
                await this.loadActiveGoals();
            } else {
                this.showMessage(data.data?.message || 'Error deleting goal. Please try again.', 'error', container);
            }
        } catch (error) {
            this.showMessage('Server error. Please try again later.', 'error', container);
            console.error('Goal deletion error:', error);
        } finally {
            UI.hideLoading(loader);
        }
    }

    showMessage(message, type, container) {
        const messageDiv = container.querySelector('.goals-message') || 
            UI.createElement('div', 'goals-message');
        
        messageDiv.className = `goals-message ${type}`;
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
export const Goals = new AthleteGoals();

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => Goals.init()); 