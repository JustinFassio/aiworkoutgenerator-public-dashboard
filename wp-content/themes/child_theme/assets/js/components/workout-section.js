/**
 * Workout Section Component
 * Handles individual sections of the workout (warmup, main, cooldown)
 */
class WorkoutSection {
    constructor(element) {
        this.element = element;
        this.exercises = [];
        this.events = {};
        this.state = {
            type: element.dataset.sectionType,
            title: element.dataset.sectionTitle,
            isVisible: true,
            isCompleted: false
        };

        this.initialize();
    }

    initialize() {
        // Parse exercises from the DOM
        this.element.querySelectorAll('.exercise-item').forEach(exerciseEl => {
            const exercise = {
                element: exerciseEl,
                name: exerciseEl.dataset.name,
                sets: parseInt(exerciseEl.dataset.sets, 10) || 1,
                reps: parseInt(exerciseEl.dataset.reps, 10) || 0,
                isCompleted: false,
                actualSets: []
            };

            // Initialize set tracking
            for (let i = 0; i < exercise.sets; i++) {
                exercise.actualSets.push({
                    reps: exercise.reps,
                    weight: 0,
                    isCompleted: false,
                    notes: ''
                });
            }

            this.exercises.push(exercise);
            this.initializeExerciseUI(exercise);
        });

        // Initialize raw HTML content if present
        const rawContent = this.element.querySelector('.raw-content');
        if (rawContent) {
            this.rawContent = rawContent.innerHTML;
        }

        // Set up visibility toggle
        const toggleButton = this.element.querySelector('.section-toggle');
        if (toggleButton) {
            toggleButton.addEventListener('click', () => this.toggleVisibility());
        }
    }

    initializeExerciseUI(exercise) {
        const exerciseEl = exercise.element;
        
        // Create set tracking UI
        const setsContainer = document.createElement('div');
        setsContainer.className = 'exercise-sets';
        
        exercise.actualSets.forEach((set, index) => {
            const setEl = this.createSetUI(exercise, set, index);
            setsContainer.appendChild(setEl);
        });
        
        exerciseEl.appendChild(setsContainer);

        // Add notes field
        const notesContainer = document.createElement('div');
        notesContainer.className = 'exercise-notes';
        notesContainer.innerHTML = `
            <textarea placeholder="Add notes for this exercise..."
                      class="exercise-note-input"></textarea>
        `;
        exerciseEl.appendChild(notesContainer);

        // Add complete button
        const completeButton = document.createElement('button');
        completeButton.className = 'exercise-complete-btn';
        completeButton.textContent = 'Complete Exercise';
        completeButton.addEventListener('click', () => this.completeExercise(exercise));
        exerciseEl.appendChild(completeButton);
    }

    createSetUI(exercise, set, index) {
        const setEl = document.createElement('div');
        setEl.className = 'exercise-set';
        setEl.innerHTML = `
            <span class="set-number">Set ${index + 1}</span>
            <input type="number" class="reps-input" 
                   value="${set.reps}" min="0" 
                   placeholder="Reps">
            <input type="number" class="weight-input" 
                   value="${set.weight}" min="0" step="0.5" 
                   placeholder="Weight">
            <button class="complete-set-btn">Complete Set</button>
        `;

        // Handle set completion
        const completeBtn = setEl.querySelector('.complete-set-btn');
        completeBtn.addEventListener('click', () => {
            const reps = parseInt(setEl.querySelector('.reps-input').value, 10);
            const weight = parseFloat(setEl.querySelector('.weight-input').value);
            
            exercise.actualSets[index] = {
                reps,
                weight,
                isCompleted: true,
                timestamp: new Date().toISOString()
            };

            completeBtn.disabled = true;
            setEl.classList.add('completed');
            
            this.checkExerciseCompletion(exercise);
            this.emit('exerciseModified', { exercise, setIndex: index });
        });

        return setEl;
    }

    completeExercise(exercise) {
        exercise.isCompleted = true;
        exercise.element.classList.add('completed');
        
        // Check if all exercises are completed
        this.checkSectionCompletion();
        this.emit('exerciseComplete', { exercise });
    }

    checkExerciseCompletion(exercise) {
        const allSetsCompleted = exercise.actualSets.every(set => set.isCompleted);
        if (allSetsCompleted && !exercise.isCompleted) {
            this.completeExercise(exercise);
        }
    }

    checkSectionCompletion() {
        const allExercisesCompleted = this.exercises.every(ex => ex.isCompleted);
        if (allExercisesCompleted && !this.state.isCompleted) {
            this.state.isCompleted = true;
            this.element.classList.add('section-completed');
            this.emit('sectionComplete', { section: this });
        }
    }

    toggleVisibility() {
        this.state.isVisible = !this.state.isVisible;
        this.element.classList.toggle('hidden', !this.state.isVisible);
    }

    setVisible(visible) {
        this.state.isVisible = visible;
        this.element.classList.toggle('hidden', !visible);
    }

    getExerciseCount() {
        return this.exercises.length;
    }

    getCompletedCount() {
        return this.exercises.filter(ex => ex.isCompleted).length;
    }

    isCompleted() {
        return this.state.isCompleted;
    }

    getState() {
        return {
            type: this.state.type,
            title: this.state.title,
            isCompleted: this.state.isCompleted,
            exercises: this.exercises.map(ex => ({
                name: ex.name,
                isCompleted: ex.isCompleted,
                sets: ex.actualSets,
                notes: ex.element.querySelector('.exercise-note-input').value
            })),
            rawContent: this.rawContent
        };
    }

    // Event handling
    on(event, callback) {
        if (!this.events[event]) {
            this.events[event] = [];
        }
        this.events[event].push(callback);
    }

    emit(event, data) {
        if (this.events[event]) {
            this.events[event].forEach(callback => callback(data));
        }
    }
} 