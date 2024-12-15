/**
 * Workout Logger Component
 */
if (typeof WorkoutLoggerComponent === 'undefined') {
    class WorkoutLoggerComponent {
        constructor() {
            this.container = document.querySelector('.workout-logger');
            this.init();
        }

        init() {
            if (!this.container) return;

            this.form = this.container.querySelector('.workout-log-form');
            this.exerciseList = this.container.querySelector('.exercise-list');
            this.historyList = this.container.querySelector('.workout-history');

            if (this.form) {
                this.form.addEventListener('submit', (e) => this.handleSubmit(e));
            }

            this.initializeExerciseButtons();
            this.loadWorkoutHistory();
        }

        initializeExerciseButtons() {
            // Add exercise button
            const addButton = this.container.querySelector('.add-exercise');
            if (addButton) {
                addButton.addEventListener('click', () => this.addExercise());
            }

            // Exercise list event delegation
            if (this.exerciseList) {
                this.exerciseList.addEventListener('click', (e) => {
                    const removeButton = e.target.closest('.remove-exercise');
                    if (removeButton) {
                        e.preventDefault();
                        removeButton.closest('.exercise-item').remove();
                    }
                });
            }
        }

        addExercise() {
            const index = this.exerciseList.children.length;
            const exerciseHtml = `
                <div class="exercise-item">
                    <div class="exercise-header">
                        <input type="text" name="exercises[${index}][name]" placeholder="Exercise Name" required>
                        <button type="button" class="remove-exercise danger-button">
                            <span class="dashicons dashicons-trash"></span>
                        </button>
                    </div>
                    <div class="exercise-details">
                        <div class="form-group">
                            <label>Sets</label>
                            <input type="number" name="exercises[${index}][sets]" min="1" required>
                        </div>
                        <div class="form-group">
                            <label>Reps</label>
                            <input type="number" name="exercises[${index}][reps]" min="1" required>
                        </div>
                        <div class="form-group">
                            <label>Weight (lbs)</label>
                            <input type="number" name="exercises[${index}][weight]" min="0" step="0.5" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Notes</label>
                        <textarea name="exercises[${index}][notes]" rows="2"></textarea>
                    </div>
                </div>
            `;
            this.exerciseList.insertAdjacentHTML('beforeend', exerciseHtml);
        }

        handleSubmit(e) {
            e.preventDefault();

            if (!this.exerciseList.children.length) {
                window.athleteDashboard.showNotification('Please add at least one exercise', 'error');
                return;
            }

            const formData = new FormData(this.form);
            formData.append('action', 'log_workout');
            formData.append('nonce', athleteDashboardData.nonce);

            this.form.classList.add('loading');

            fetch(athleteDashboardData.ajaxurl, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.athleteDashboard.showNotification(data.data.message, 'success');
                    this.form.reset();
                    this.exerciseList.innerHTML = '';
                    this.loadWorkoutHistory();
                } else {
                    window.athleteDashboard.showNotification(data.data, 'error');
                }
            })
            .catch(error => {
                window.athleteDashboard.showNotification('Error logging workout', 'error');
            })
            .finally(() => {
                this.form.classList.remove('loading');
            });
        }

        loadWorkoutHistory() {
            if (!this.historyList) return;

            fetch(`${athleteDashboardData.ajaxurl}?action=get_workout_history&nonce=${athleteDashboardData.nonce}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.historyList.innerHTML = data.data.html;
                    } else {
                        window.athleteDashboard.showNotification(data.data, 'error');
                    }
                })
                .catch(error => {
                    window.athleteDashboard.showNotification('Error loading workout history', 'error');
                });
        }
    }
} 