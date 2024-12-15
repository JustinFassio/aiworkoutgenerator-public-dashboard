/**
 * Workout Logger Component
 * Handles logging completed workouts and sections
 */
class WorkoutLogger {
    constructor(element) {
        this.element = element;
        this.state = {
            isVisible: false,
            selectedSections: new Set(),
            workoutData: null,
            notes: '',
            rating: 0
        };

        this.initialize();
    }

    initialize() {
        // Create logger UI
        this.element.innerHTML = `
            <div class="workout-logger-content">
                <h3>Log Workout</h3>
                <div class="sections-selection"></div>
                <div class="workout-summary"></div>
                <div class="workout-rating">
                    <label>How was this workout?</label>
                    <div class="rating-stars"></div>
                </div>
                <div class="workout-notes">
                    <label>Workout Notes</label>
                    <textarea placeholder="Add any notes about this workout..."></textarea>
                </div>
                <div class="logger-actions">
                    <button class="log-workout-btn">Log Workout</button>
                    <button class="cancel-logging-btn">Cancel</button>
                </div>
            </div>
        `;

        // Initialize rating UI
        this.initializeRatingUI();
        
        // Set up event listeners
        this.element.querySelector('.log-workout-btn')
            .addEventListener('click', () => this.logWorkout());
        
        this.element.querySelector('.cancel-logging-btn')
            .addEventListener('click', () => this.hide());
        
        this.element.querySelector('textarea')
            .addEventListener('input', (e) => this.state.notes = e.target.value);
    }

    initializeRatingUI() {
        const container = this.element.querySelector('.rating-stars');
        for (let i = 1; i <= 5; i++) {
            const star = document.createElement('span');
            star.className = 'rating-star';
            star.innerHTML = '★';
            star.dataset.rating = i;
            
            star.addEventListener('click', () => {
                this.state.rating = i;
                this.updateRatingUI();
            });
            
            container.appendChild(star);
        }
    }

    updateRatingUI() {
        const stars = this.element.querySelectorAll('.rating-star');
        stars.forEach(star => {
            const rating = parseInt(star.dataset.rating, 10);
            star.classList.toggle('active', rating <= this.state.rating);
        });
    }

    show(workoutData) {
        this.state.workoutData = workoutData;
        this.state.isVisible = true;
        this.element.classList.add('visible');
        
        // Create section checkboxes
        const sectionsContainer = this.element.querySelector('.sections-selection');
        sectionsContainer.innerHTML = '<h4>Select sections to log:</h4>';
        
        workoutData.sections.forEach(section => {
            const checkbox = document.createElement('label');
            checkbox.className = 'section-checkbox';
            checkbox.innerHTML = `
                <input type="checkbox" value="${section.type}"
                       ${section.isCompleted ? 'checked' : ''}>
                <span>${section.title}</span>
                <span class="completion-status">
                    ${this.getCompletionStatus(section)}
                </span>
            `;
            
            const input = checkbox.querySelector('input');
            input.addEventListener('change', () => {
                if (input.checked) {
                    this.state.selectedSections.add(section.type);
                } else {
                    this.state.selectedSections.delete(section.type);
                }
                this.updateSummary();
            });
            
            if (section.isCompleted) {
                this.state.selectedSections.add(section.type);
            }
            
            sectionsContainer.appendChild(checkbox);
        });
        
        this.updateSummary();
    }

    hide() {
        this.state.isVisible = false;
        this.element.classList.remove('visible');
        this.resetState();
    }

    resetState() {
        this.state.selectedSections.clear();
        this.state.notes = '';
        this.state.rating = 0;
        this.state.workoutData = null;
        
        // Reset UI
        this.element.querySelector('textarea').value = '';
        this.updateRatingUI();
    }

    getCompletionStatus(section) {
        const completed = section.exercises.filter(ex => ex.isCompleted).length;
        const total = section.exercises.length;
        return `${completed}/${total} exercises completed`;
    }

    updateSummary() {
        const summaryContainer = this.element.querySelector('.workout-summary');
        const selectedSections = this.state.workoutData.sections
            .filter(section => this.state.selectedSections.has(section.type));
        
        let summary = '<h4>Workout Summary:</h4>';
        let totalExercises = 0;
        let completedExercises = 0;
        
        selectedSections.forEach(section => {
            const sectionExercises = section.exercises;
            const completed = sectionExercises.filter(ex => ex.isCompleted).length;
            
            totalExercises += sectionExercises.length;
            completedExercises += completed;
            
            summary += `
                <div class="section-summary">
                    <h5>${section.title}</h5>
                    <ul>
                        ${sectionExercises.map(ex => `
                            <li class="${ex.isCompleted ? 'completed' : ''}">
                                ${ex.name}
                                ${this.formatSets(ex.sets)}
                            </li>
                        `).join('')}
                    </ul>
                </div>
            `;
        });
        
        summary += `
            <div class="workout-stats">
                <p>Total Time: ${this.formatDuration(this.state.workoutData.duration)}</p>
                <p>Completion: ${completedExercises}/${totalExercises} exercises</p>
            </div>
        `;
        
        summaryContainer.innerHTML = summary;
    }

    formatSets(sets) {
        return sets.filter(set => set.isCompleted)
            .map(set => `${set.reps}x${set.weight}lbs`)
            .join(', ');
    }

    formatDuration(seconds) {
        const minutes = Math.floor(seconds / 60);
        const remainingSeconds = seconds % 60;
        return `${minutes}:${remainingSeconds.toString().padStart(2, '0')}`;
    }

    async logWorkout() {
        if (this.state.selectedSections.size === 0) {
            alert('Please select at least one section to log');
            return;
        }

        const logData = {
            sections: this.state.workoutData.sections
                .filter(section => this.state.selectedSections.has(section.type)),
            duration: this.state.workoutData.duration,
            rating: this.state.rating,
            notes: this.state.notes,
            timestamp: new Date().toISOString()
        };

        try {
            const response = await fetch(workoutViewData.ajaxurl, {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'log_workout',
                    nonce: workoutViewData.nonce,
                    log_data: JSON.stringify(logData)
                })
            });

            const result = await response.json();
            
            if (result.success) {
                this.hide();
                // Notify parent component
                this.element.dispatchEvent(new CustomEvent('workoutLogged', {
                    detail: logData
                }));
            } else {
                throw new Error(result.data.message);
            }
        } catch (error) {
            console.error('Error logging workout:', error);
            alert('Failed to log workout. Please try again.');
        }
    }
} 