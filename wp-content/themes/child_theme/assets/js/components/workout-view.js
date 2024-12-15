/**
 * Workout View Component
 * Manages the overall workout interaction and state
 */
class WorkoutView {
    constructor() {
        this.state = {
            workoutId: null,
            sections: [],
            currentSection: 0,
            isActive: false,
            startTime: null,
            elapsedTime: 0,
            progress: {
                completedExercises: 0,
                totalExercises: 0,
                completedSections: 0
            }
        };

        this.components = {
            header: null,
            sections: [],
            progress: null,
            logger: null
        };

        this.initialize();
    }

    initialize() {
        // Initialize when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => this.initializeComponents());
        } else {
            this.initializeComponents();
        }
    }

    initializeComponents() {
        const container = document.querySelector('.workout-view');
        if (!container) return;

        this.state.workoutId = container.dataset.workoutId;

        // Initialize sub-components
        this.components.header = new WorkoutHeader(
            container.querySelector('.workout-header')
        );

        this.components.progress = new WorkoutProgress(
            container.querySelector('.workout-progress')
        );

        this.components.logger = new WorkoutLogger(
            container.querySelector('.workout-logger')
        );

        // Initialize section components
        container.querySelectorAll('.workout-section').forEach(sectionEl => {
            const section = new WorkoutSection(sectionEl);
            this.components.sections.push(section);
            
            // Listen for exercise completion
            section.on('exerciseComplete', () => this.updateProgress());
            section.on('exerciseModified', () => this.handleExerciseModification());
        });

        // Set up navigation
        this.setupNavigation();
        
        // Set up keyboard shortcuts
        this.setupKeyboardShortcuts();
        
        // Initialize progress tracking
        this.initializeProgress();
        
        // Set up auto-save
        this.setupAutoSave();
    }

    setupNavigation() {
        const nav = document.createElement('div');
        nav.className = 'workout-navigation';
        
        // Previous section button
        const prevButton = document.createElement('button');
        prevButton.textContent = 'Previous';
        prevButton.addEventListener('click', () => this.previousSection());
        
        // Next section button
        const nextButton = document.createElement('button');
        nextButton.textContent = 'Next';
        nextButton.addEventListener('click', () => this.nextSection());
        
        nav.appendChild(prevButton);
        nav.appendChild(nextButton);
        
        // Add to DOM
        document.querySelector('.workout-view').appendChild(nav);
    }

    setupKeyboardShortcuts() {
        document.addEventListener('keydown', (e) => {
            if (!this.state.isActive) return;
            
            switch(e.key) {
                case 'ArrowLeft':
                    this.previousSection();
                    break;
                case 'ArrowRight':
                    this.nextSection();
                    break;
                case 'Space':
                    if (e.ctrlKey || e.metaKey) {
                        this.toggleTimer();
                    }
                    break;
            }
        });
    }

    initializeProgress() {
        // Count total exercises
        this.state.progress.totalExercises = this.components.sections.reduce(
            (total, section) => total + section.getExerciseCount(),
            0
        );
        
        // Start timer if auto-start is enabled
        if (workoutViewData.autoStartTimer) {
            this.startTimer();
        }
        
        this.updateProgress();
    }

    setupAutoSave() {
        // Auto-save progress every minute
        setInterval(() => this.saveProgress(), 60000);
        
        // Save on page unload
        window.addEventListener('beforeunload', () => {
            this.saveProgress();
            return null;
        });
    }

    updateProgress() {
        // Calculate completed exercises
        this.state.progress.completedExercises = this.components.sections.reduce(
            (total, section) => total + section.getCompletedCount(),
            0
        );
        
        // Calculate completed sections
        this.state.progress.completedSections = this.components.sections.reduce(
            (total, section) => total + (section.isCompleted() ? 1 : 0),
            0
        );
        
        // Update progress component
        this.components.progress.update({
            completedExercises: this.state.progress.completedExercises,
            totalExercises: this.state.progress.totalExercises,
            completedSections: this.state.progress.completedSections,
            totalSections: this.components.sections.length,
            elapsedTime: this.state.elapsedTime
        });
        
        // Check if workout is complete
        if (this.isWorkoutComplete()) {
            this.handleWorkoutComplete();
        }
    }

    saveProgress() {
        const progress = {
            workoutId: this.state.workoutId,
            sections: this.components.sections.map(section => section.getState()),
            elapsedTime: this.state.elapsedTime,
            timestamp: new Date().toISOString()
        };

        // Save to server
        fetch(workoutViewData.ajaxurl, {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                action: 'save_workout_progress',
                nonce: workoutViewData.nonce,
                progress: JSON.stringify(progress)
            })
        })
        .catch(error => console.error('Error saving progress:', error));
    }

    startTimer() {
        if (!this.state.startTime) {
            this.state.startTime = Date.now() - (this.state.elapsedTime * 1000);
            this.timerInterval = setInterval(() => {
                this.state.elapsedTime = Math.floor((Date.now() - this.state.startTime) / 1000);
                this.updateProgress();
            }, 1000);
        }
    }

    pauseTimer() {
        if (this.timerInterval) {
            clearInterval(this.timerInterval);
            this.timerInterval = null;
        }
    }

    toggleTimer() {
        if (this.timerInterval) {
            this.pauseTimer();
        } else {
            this.startTimer();
        }
    }

    previousSection() {
        if (this.state.currentSection > 0) {
            this.state.currentSection--;
            this.showCurrentSection();
        }
    }

    nextSection() {
        if (this.state.currentSection < this.components.sections.length - 1) {
            this.state.currentSection++;
            this.showCurrentSection();
        }
    }

    showCurrentSection() {
        this.components.sections.forEach((section, index) => {
            section.setVisible(index === this.state.currentSection);
        });
    }

    isWorkoutComplete() {
        return this.state.progress.completedExercises === this.state.progress.totalExercises;
    }

    handleWorkoutComplete() {
        this.pauseTimer();
        this.components.logger.show({
            duration: this.state.elapsedTime,
            sections: this.components.sections.map(section => section.getState())
        });
    }

    handleExerciseModification() {
        // Track that changes have been made
        this.state.hasChanges = true;
        
        // Trigger auto-save
        this.saveProgress();
    }
}

// Initialize when the script loads
if (typeof window.workoutView === 'undefined') {
    window.workoutView = new WorkoutView();
} 