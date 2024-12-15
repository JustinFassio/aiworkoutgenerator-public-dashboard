/**
 * Workout Progress Component
 * Handles progress tracking and visualization during workout
 */
class WorkoutProgress {
    constructor(element) {
        this.element = element;
        this.state = {
            completedExercises: 0,
            totalExercises: 0,
            completedSections: 0,
            totalSections: 0,
            elapsedTime: 0
        };

        this.initialize();
    }

    initialize() {
        this.element.innerHTML = `
            <div class="workout-progress-container">
                <div class="progress-stats">
                    <div class="stat-item">
                        <span class="stat-label">Time</span>
                        <span class="stat-value time-display">00:00</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Progress</span>
                        <div class="progress-bar">
                            <div class="progress-fill"></div>
                        </div>
                        <span class="stat-value progress-text">0%</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Sections</span>
                        <span class="stat-value sections-display">0/0</span>
                    </div>
                </div>
                <div class="quick-actions">
                    <button class="timer-toggle">
                        <span class="timer-icon">⏸</span>
                    </button>
                    <button class="skip-rest">Skip Rest</button>
                </div>
            </div>
        `;

        // Initialize UI references
        this.timeDisplay = this.element.querySelector('.time-display');
        this.progressBar = this.element.querySelector('.progress-fill');
        this.progressText = this.element.querySelector('.progress-text');
        this.sectionsDisplay = this.element.querySelector('.sections-display');
        
        // Set up event listeners
        this.setupEventListeners();
    }

    setupEventListeners() {
        const timerToggle = this.element.querySelector('.timer-toggle');
        timerToggle.addEventListener('click', () => {
            const event = new CustomEvent('timerToggle');
            this.element.dispatchEvent(event);
            this.toggleTimerButton(timerToggle);
        });

        const skipRest = this.element.querySelector('.skip-rest');
        skipRest.addEventListener('click', () => {
            const event = new CustomEvent('skipRest');
            this.element.dispatchEvent(event);
        });
    }

    toggleTimerButton(button) {
        const icon = button.querySelector('.timer-icon');
        if (icon.textContent === '⏸') {
            icon.textContent = '▶';
            button.setAttribute('title', 'Resume Workout');
        } else {
            icon.textContent = '⏸';
            button.setAttribute('title', 'Pause Workout');
        }
    }

    update(progress) {
        // Update state
        Object.assign(this.state, progress);

        // Update time display
        this.timeDisplay.textContent = this.formatTime(this.state.elapsedTime);

        // Calculate and update progress percentage
        const progressPercent = Math.round(
            (this.state.completedExercises / this.state.totalExercises) * 100
        );
        this.progressBar.style.width = `${progressPercent}%`;
        this.progressText.textContent = `${progressPercent}%`;

        // Update sections display
        this.sectionsDisplay.textContent = 
            `${this.state.completedSections}/${this.state.totalSections}`;

        // Update visual state based on progress
        this.updateVisualState(progressPercent);
    }

    updateVisualState(progressPercent) {
        // Remove existing state classes
        this.progressBar.classList.remove('progress-low', 'progress-medium', 'progress-high');

        // Add appropriate state class
        if (progressPercent < 33) {
            this.progressBar.classList.add('progress-low');
        } else if (progressPercent < 66) {
            this.progressBar.classList.add('progress-medium');
        } else {
            this.progressBar.classList.add('progress-high');
        }

        // Update container state for completed workout
        this.element.classList.toggle('workout-completed', progressPercent === 100);
    }

    formatTime(seconds) {
        const minutes = Math.floor(seconds / 60);
        const remainingSeconds = seconds % 60;
        return `${minutes.toString().padStart(2, '0')}:${remainingSeconds.toString().padStart(2, '0')}`;
    }

    showRestTimer(duration) {
        const restTimer = document.createElement('div');
        restTimer.className = 'rest-timer';
        restTimer.innerHTML = `
            <span class="rest-timer-label">Rest</span>
            <span class="rest-timer-display">${duration}</span>
        `;
        
        this.element.querySelector('.progress-stats').appendChild(restTimer);
        
        return {
            update: (remaining) => {
                restTimer.querySelector('.rest-timer-display').textContent = remaining;
            },
            remove: () => {
                restTimer.remove();
            }
        };
    }
} 