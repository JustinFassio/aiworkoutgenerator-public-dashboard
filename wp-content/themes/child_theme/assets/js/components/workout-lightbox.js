/**
 * Workout Lightbox Component
 */
class WorkoutLightboxComponent {
    constructor() {
        if (WorkoutLightboxComponent.instance) {
            return WorkoutLightboxComponent.instance;
        }
        WorkoutLightboxComponent.instance = this;
        this.isEditing = false;
        this.hasUnsavedChanges = false;

        // Initialize when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => this.initialize());
        } else {
            setTimeout(() => this.initialize(), 100);
        }
    }

    initialize() {
        console.log('Initializing WorkoutLightboxComponent');
        
        // Try to find the lightbox element
        this.lightbox = document.querySelector('.workout-lightbox-overlay');
        
        // If not found, create it dynamically
        if (!this.lightbox) {
            console.log('Creating workout lightbox element');
            this.createLightbox();
        }

        console.log('Found workout lightbox overlay, initializing events');
        this.initEvents();
        this.initializeEditMode();
    }

    createLightbox() {
        // Create the lightbox structure
        this.lightbox = document.createElement('div');
        this.lightbox.className = 'workout-lightbox-overlay';
        
        const content = document.createElement('div');
        content.className = 'workout-lightbox-content';
        
        const loading = document.createElement('div');
        loading.className = 'workout-lightbox-loading';
        loading.innerHTML = '<div class="loading-spinner"></div>';
        
        content.appendChild(loading);
        this.lightbox.appendChild(content);
        
        // Append to body
        document.body.appendChild(this.lightbox);
    }

    initEvents() {
        if (!this.lightbox) {
            console.error('Cannot initialize events: lightbox element not found');
            return;
        }

        // Initialize close button - create if doesn't exist
        let closeButton = this.lightbox.querySelector('.workout-lightbox-close');
        if (!closeButton) {
            closeButton = document.createElement('button');
            closeButton.className = 'workout-lightbox-close';
            closeButton.textContent = workoutLightboxData.strings.close;
            this.lightbox.querySelector('.workout-lightbox-content').appendChild(closeButton);
        }
        
        closeButton.addEventListener('click', () => this.hide());

        // Close on background click
        this.lightbox.addEventListener('click', (e) => {
            if (e.target === this.lightbox) {
                this.hide();
            }
        });

        // Initialize workout buttons
        document.addEventListener('click', (e) => {
            const button = e.target.closest('.view-workout-button');
            if (button) {
                e.preventDefault();
                const workoutId = button.dataset.workoutId;
                if (workoutId) {
                    console.log('Loading workout ID:', workoutId);
                    this.loadWorkout(workoutId);
                } else {
                    console.error('No workout ID found on button');
                }
            }
        });

        // Initialize print button functionality
        document.addEventListener('click', (e) => {
            const printButton = e.target.closest('.print-workout');
            if (printButton) {
                e.preventDefault();
                this.printWorkout();
            }
        });

        // Add keyboard event listener for ESC key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.lightbox.classList.contains('active')) {
                this.hide();
            }
        });
    }

    show() {
        console.log('Showing workout lightbox');
        this.lightbox.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    hide() {
        console.log('Hiding workout lightbox');
        this.lightbox.classList.remove('active');
        document.body.style.overflow = '';
    }

    loadWorkout(workoutId) {
        if (!workoutId) {
            console.error('No workout ID provided');
            return;
        }

        this.currentWorkoutId = workoutId;
        console.log('Loading workout data for ID:', workoutId);
        const formData = new FormData();
        formData.append('action', 'get_full_workout');
        formData.append('nonce', workoutLightboxData.nonce);
        formData.append('workout_id', workoutId);

        this.lightbox.classList.add('loading');
        const content = this.lightbox.querySelector('.workout-lightbox-content');
        
        if (content) {
            content.innerHTML = `
                <div class="workout-lightbox-loading">
                    <div class="loading-spinner"></div>
                    <p>${workoutLightboxData.strings.loading}</p>
                </div>
            `;
        }

        this.show();

        fetch(workoutLightboxData.ajaxurl, {
            method: 'POST',
            body: formData,
            credentials: 'same-origin'
        })
        .then(response => response.json().then(data => ({ response, data })))
        .then(({ response, data }) => {
            if (!response.ok) {
                // Handle specific error cases
                switch (data.data?.code) {
                    case 'invalid_nonce':
                        return this.refreshNonce().then(() => {
                            formData.set('nonce', workoutLightboxData.nonce);
                            return fetch(workoutLightboxData.ajaxurl, {
                                method: 'POST',
                                body: formData,
                                credentials: 'same-origin'
                            }).then(response => response.json());
                        });
                    case 'unauthorized':
                        if (workoutLightboxData.loginUrl) {
                            window.location.href = workoutLightboxData.loginUrl;
                        }
                        throw new Error(data.data.message);
                    case 'insufficient_permissions':
                        throw new Error(data.data.message);
                    default:
                        throw new Error(data.data?.message || workoutLightboxData.strings.error);
                }
            }
            return data;
        })
        .then(data => {
            console.log('Processed workout data:', data);
            if (data.success && content) {
                const workout = data.data;
                
                // Store the workout data
                this.currentWorkout = workout;
                
                // Build the workout content
                const workoutHtml = this.buildWorkoutContent(workout);
                content.innerHTML = workoutHtml;
                
                this.initializePrintButton();
                this.initializeEditButtons();
                
                const closeButton = this.lightbox.querySelector('.workout-lightbox-close');
                if (closeButton) {
                    closeButton.addEventListener('click', () => this.hide());
                }
            } else {
                throw new Error(data.data?.message || workoutLightboxData.strings.error);
            }
        })
        .catch(error => {
            console.error('Error loading workout:', error);
            if (content) {
                content.innerHTML = `
                    <div class="workout-lightbox-error">
                        <p>${error.message || workoutLightboxData.strings.error}</p>
                        <button class="workout-lightbox-close">${workoutLightboxData.strings.close}</button>
                    </div>
                `;
                const closeButton = this.lightbox.querySelector('.workout-lightbox-close');
                if (closeButton) {
                    closeButton.addEventListener('click', () => this.hide());
                }
            }
        })
        .finally(() => {
            this.lightbox.classList.remove('loading');
        });
    }

    refreshNonce() {
        return fetch(workoutLightboxData.ajaxurl, {
            method: 'POST',
            body: new URLSearchParams({
                'action': 'refresh_workout_nonce',
                'nonce': workoutLightboxData.nonce
            }),
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                workoutLightboxData.nonce = data.data.nonce;
                return true;
            }
            throw new Error('Failed to refresh security token');
        });
    }

    buildWorkoutContent(workout) {
        return `
            <button class="workout-lightbox-close">${workoutLightboxData.strings.close}</button>
            <div class="workout-lightbox-header">
                <h2 class="workout-lightbox-title">${workout.title}</h2>
                <p class="workout-lightbox-date">${workout.date}</p>
            </div>
            <div class="workout-lightbox-details">
                <div class="workout-lightbox-detail">
                    <span class="workout-lightbox-detail-label">Type</span>
                    <p class="workout-lightbox-detail-value">${workout.type || 'Standard'}</p>
                </div>
            </div>
            ${workout.exercises && workout.exercises.length > 0 ? `
                <div class="workout-lightbox-exercises">
                    <h3 class="workout-lightbox-subtitle">Exercises</h3>
                    <div class="exercise-list">
                        ${workout.exercises.map(exercise => this.buildExerciseHtml(exercise)).join('')}
                    </div>
                </div>
            ` : ''}
            <div class="workout-content">
                ${workout.content || ''}
            </div>
            <div class="modal-button-container">
                <button class="edit-workout">
                    <span class="dashicons dashicons-edit"></span> Edit
                </button>
                <button class="save-workout hidden">
                    <span class="dashicons dashicons-saved"></span> Save
                </button>
                <button class="add-exercise hidden">
                    <span class="dashicons dashicons-plus"></span> Add Exercise
                </button>
                <button class="print-workout">
                    <span class="dashicons dashicons-printer"></span> Print
                </button>
            </div>
        `;
    }

    buildExerciseHtml(exercise) {
        return `
            <div class="exercise-item">
                <div class="exercise-icons">
                    <span class="edit-icon hidden dashicons dashicons-edit"></span>
                    <span class="delete-icon hidden dashicons dashicons-trash"></span>
                </div>
                <div class="exercise-name">${exercise.name}</div>
                <div class="exercise-details">
                    <span class="exercise-sets">${exercise.sets} sets</span>
                    <span class="exercise-reps">${exercise.reps} reps</span>
                    ${exercise.weight ? `<span class="exercise-weight">${exercise.weight} lbs</span>` : ''}
                </div>
                ${exercise.notes ? `<div class="exercise-notes">${exercise.notes}</div>` : ''}
            </div>
        `;
    }

    initializePrintButton() {
        const printButton = this.lightbox.querySelector('.print-workout');
        if (printButton) {
            printButton.addEventListener('click', () => this.printWorkout());
        }
    }

    printWorkout() {
        const content = this.lightbox.querySelector('.workout-lightbox-content');
        if (!content) return;

        const printWindow = window.open('', '_blank');
        const printContent = content.cloneNode(true);
        
        // Remove elements that shouldn't be printed
        const buttonContainer = printContent.querySelector('.modal-button-container');
        if (buttonContainer) {
            buttonContainer.remove();
        }

        printWindow.document.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <title>Print Workout</title>
                <style>
                    body { 
                        font-family: Arial, sans-serif; 
                        line-height: 1.6; 
                        color: #333;
                        padding: 20px;
                        margin: 0;
                    }
                    h2 { 
                        color: #2c3e50; 
                        margin-top: 0;
                    }
                    .exercise-item { 
                        margin-bottom: 10px;
                        break-inside: avoid;
                        page-break-inside: avoid;
                    }
                    @media print {
                        body { 
                            print-color-adjust: exact; 
                            -webkit-print-color-adjust: exact;
                        }
                    }
                </style>
            </head>
            <body>
                ${printContent.innerHTML}
            </body>
            </html>
        `);

        printWindow.document.close();
        printWindow.focus();

        setTimeout(() => {
            printWindow.print();
            printWindow.close();
        }, 250);
    }

    initializeEditButtons() {
        // Add edit button to the button container
        const buttonContainer = this.lightbox.querySelector('.modal-button-container');
        if (!buttonContainer) return;

        const editButton = document.createElement('button');
        editButton.className = 'edit-workout';
        editButton.innerHTML = '<span class="dashicons dashicons-edit"></span> Edit';
        editButton.addEventListener('click', () => this.toggleEditMode());

        const saveButton = document.createElement('button');
        saveButton.className = 'save-workout hidden';
        saveButton.innerHTML = '<span class="dashicons dashicons-saved"></span> Save';
        saveButton.addEventListener('click', () => this.saveWorkout());

        buttonContainer.insertBefore(saveButton, buttonContainer.firstChild);
        buttonContainer.insertBefore(editButton, buttonContainer.firstChild);

        // Add edit buttons to individual sections
        this.addSectionEditButtons();
    }

    addSectionEditButtons() {
        // Add edit buttons to title
        const title = this.lightbox.querySelector('.workout-lightbox-title');
        if (title) {
            this.makeEditable(title);
        }

        // Add edit buttons to exercises
        const exercises = this.lightbox.querySelectorAll('.exercise-item');
        exercises.forEach(exercise => {
            this.makeExerciseEditable(exercise);
        });

        // Add "Add Exercise" button
        const exerciseList = this.lightbox.querySelector('.exercise-list');
        if (exerciseList) {
            const addButton = document.createElement('button');
            addButton.className = 'add-exercise hidden';
            addButton.innerHTML = '<span class="dashicons dashicons-plus"></span> Add Exercise';
            addButton.addEventListener('click', () => this.addNewExercise());
            exerciseList.parentNode.insertBefore(addButton, exerciseList.nextSibling);
        }
    }

    makeEditable(element) {
        const editIcon = document.createElement('span');
        editIcon.className = 'edit-icon hidden dashicons dashicons-edit';
        editIcon.addEventListener('click', () => {
            const input = document.createElement('input');
            input.type = 'text';
            input.value = element.textContent;
            input.className = 'edit-input';
            element.parentNode.replaceChild(input, element);
            input.focus();

            input.addEventListener('blur', () => {
                element.textContent = input.value;
                input.parentNode.replaceChild(element, input);
            });
        });

        element.parentNode.insertBefore(editIcon, element.nextSibling);
    }

    makeExerciseEditable(exercise) {
        const editIcon = document.createElement('span');
        editIcon.className = 'edit-icon hidden dashicons dashicons-edit';
        
        const deleteIcon = document.createElement('span');
        deleteIcon.className = 'delete-icon hidden dashicons dashicons-trash';

        const iconContainer = document.createElement('div');
        iconContainer.className = 'exercise-icons';
        iconContainer.appendChild(editIcon);
        iconContainer.appendChild(deleteIcon);

        exercise.insertBefore(iconContainer, exercise.firstChild);

        editIcon.addEventListener('click', () => this.editExercise(exercise));
        deleteIcon.addEventListener('click', () => this.deleteExercise(exercise));
    }

    toggleEditMode() {
        this.isEditing = !this.isEditing;
        const content = this.lightbox.querySelector('.workout-lightbox-content');
        const editButton = this.lightbox.querySelector('.edit-workout');
        const saveButton = this.lightbox.querySelector('.save-workout');
        const addExerciseButton = this.lightbox.querySelector('.add-exercise');
        const editIcons = this.lightbox.querySelectorAll('.edit-icon, .delete-icon');
        const indicator = this.lightbox.querySelector('.edit-mode-indicator');

        if (this.isEditing) {
            // Enter edit mode
            editButton.classList.add('hidden');
            saveButton.classList.remove('hidden');
            addExerciseButton?.classList.remove('hidden');
            editIcons.forEach(icon => icon.classList.remove('hidden'));
            content.classList.add('editing');
            indicator.classList.remove('hidden');

            // Store original content for potential cancellation
            const editableElements = content.querySelectorAll('.workout-lightbox-title, .workout-lightbox-subtitle, .exercise-item');
            editableElements.forEach(element => {
                if (!element.dataset.originalContent) {
                    element.dataset.originalContent = element.innerHTML;
                }
            });

            // Add edit mode specific event listeners
            this.addEditModeListeners();
        } else {
            // Exit edit mode
            editButton.classList.remove('hidden');
            saveButton.classList.add('hidden');
            addExerciseButton?.classList.add('hidden');
            editIcons.forEach(icon => icon.classList.add('hidden'));
            content.classList.remove('editing');
            indicator.classList.add('hidden');

            // Clean up edit mode
            this.removeEditModeListeners();
            if (!this.hasUnsavedChanges) {
                this.clearOriginalContent();
            }
        }
    }

    addEditModeListeners() {
        // Store listeners for later removal
        this.editModeListeners = {
            contentClick: (e) => {
                const editableElement = e.target.closest('.workout-lightbox-title, .workout-lightbox-subtitle, .exercise-item');
                if (editableElement && !editableElement.querySelector('input, textarea')) {
                    this.makeElementEditable(editableElement);
                }
            }
        };

        this.lightbox.addEventListener('click', this.editModeListeners.contentClick);
    }

    removeEditModeListeners() {
        if (this.editModeListeners) {
            this.lightbox.removeEventListener('click', this.editModeListeners.contentClick);
        }
    }

    clearOriginalContent() {
        const elements = this.lightbox.querySelectorAll('[data-original-content]');
        elements.forEach(element => {
            delete element.dataset.originalContent;
        });
    }

    makeElementEditable(element) {
        const isTitle = element.classList.contains('workout-lightbox-title');
        const isSubtitle = element.classList.contains('workout-lightbox-subtitle');
        
        // Create input/textarea based on element type
        const input = document.createElement(isTitle || isSubtitle ? 'input' : 'textarea');
        input.value = element.textContent.trim();
        input.className = 'inline-editor';
        
        if (isTitle) {
            input.classList.add('title-editor');
        } else if (isSubtitle) {
            input.classList.add('subtitle-editor');
        }

        // Replace element with input
        element.innerHTML = '';
        element.appendChild(input);
        input.focus();

        // Handle input events
        input.addEventListener('blur', () => this.handleEditComplete(element, input));
        input.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                input.blur();
            } else if (e.key === 'Escape') {
                input.value = element.dataset.originalContent;
                input.blur();
            }
        });
    }

    handleEditComplete(element, input) {
        const newContent = input.value.trim();
        const originalContent = element.dataset.originalContent;
        
        element.innerHTML = newContent;
        
        if (newContent !== originalContent) {
            this.hasUnsavedChanges = true;
            this.lightbox.querySelector('.workout-lightbox-content').classList.add('has-unsaved-changes');
        }
    }

    editExercise(exercise) {
        const name = exercise.querySelector('.exercise-name');
        const details = exercise.querySelector('.exercise-details');
        const notes = exercise.querySelector('.exercise-notes');

        // Create edit form
        const form = document.createElement('form');
        form.className = 'exercise-edit-form';
        form.innerHTML = `
            <div class="form-group">
                <label>Exercise Name</label>
                <input type="text" class="exercise-name-input" value="${name.textContent}">
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Sets</label>
                    <input type="number" class="exercise-sets-input" value="${this.extractNumber(details, 'sets')}">
                </div>
                <div class="form-group">
                    <label>Reps</label>
                    <input type="number" class="exercise-reps-input" value="${this.extractNumber(details, 'reps')}">
                </div>
                <div class="form-group">
                    <label>Weight (lbs)</label>
                    <input type="number" class="exercise-weight-input" value="${this.extractNumber(details, 'weight')}">
                </div>
            </div>
            <div class="form-group">
                <label>Notes</label>
                <textarea class="exercise-notes-input">${notes ? notes.textContent : ''}</textarea>
            </div>
            <div class="form-actions">
                <button type="button" class="save-exercise">Save</button>
                <button type="button" class="cancel-edit">Cancel</button>
            </div>
        `;

        const originalContent = exercise.innerHTML;
        exercise.innerHTML = '';
        exercise.appendChild(form);

        form.querySelector('.save-exercise').addEventListener('click', () => {
            this.saveExerciseEdit(exercise, form);
        });

        form.querySelector('.cancel-edit').addEventListener('click', () => {
            exercise.innerHTML = originalContent;
            this.makeExerciseEditable(exercise);
        });
    }

    extractNumber(details, type) {
        const regex = new RegExp(`(\\d+)\\s*${type}`);
        const match = details.textContent.match(regex);
        return match ? match[1] : '';
    }

    saveExerciseEdit(exercise, form) {
        const name = form.querySelector('.exercise-name-input').value;
        const sets = form.querySelector('.exercise-sets-input').value;
        const reps = form.querySelector('.exercise-reps-input').value;
        const weight = form.querySelector('.exercise-weight-input').value;
        const notes = form.querySelector('.exercise-notes-input').value;

        exercise.innerHTML = `
            <div class="exercise-icons">
                <span class="edit-icon hidden dashicons dashicons-edit"></span>
                <span class="delete-icon hidden dashicons dashicons-trash"></span>
            </div>
            <div class="exercise-name">${name}</div>
            <div class="exercise-details">
                <span class="exercise-sets">${sets} sets</span>
                <span class="exercise-reps">${reps} reps</span>
                ${weight ? `<span class="exercise-weight">${weight} lbs</span>` : ''}
            </div>
            ${notes ? `<div class="exercise-notes">${notes}</div>` : ''}
        `;

        this.makeExerciseEditable(exercise);
    }

    deleteExercise(exercise) {
        if (confirm('Are you sure you want to delete this exercise?')) {
            exercise.remove();
        }
    }

    addNewExercise() {
        const exerciseList = this.lightbox.querySelector('.exercise-list');
        const newExercise = document.createElement('div');
        newExercise.className = 'exercise-item';
        newExercise.innerHTML = `
            <div class="exercise-name">New Exercise</div>
            <div class="exercise-details">
                <span class="exercise-sets">0 sets</span>
                <span class="exercise-reps">0 reps</span>
            </div>
        `;

        exerciseList.appendChild(newExercise);
        this.makeExerciseEditable(newExercise);
        this.editExercise(newExercise);
    }

    saveWorkout() {
        if (!this.currentWorkoutId) {
            console.error('No workout ID found');
            alert('Error: Could not save workout. No workout ID found.');
            return;
        }

        const content = this.lightbox.querySelector('.workout-lightbox-content');
        if (!content) {
            console.error('No workout content found');
            alert('Error: Could not save workout. No content found.');
            return;
        }

        // Show loading state
        content.classList.add('saving');
        const loadingIndicator = document.createElement('div');
        loadingIndicator.className = 'save-loading-indicator';
        loadingIndicator.innerHTML = '<div class="loading-spinner"></div><p>Saving workout...</p>';
        content.appendChild(loadingIndicator);

        const formData = new FormData();
        formData.append('action', 'save_workout');
        formData.append('nonce', workoutLightboxData.nonce);
        formData.append('workout_id', this.currentWorkoutId);

        try {
            // Gather workout data
            const title = this.lightbox.querySelector('.workout-lightbox-title')?.textContent?.trim();
            if (!title) {
                throw new Error('Workout title is required');
            }

            // Gather exercise data with validation
            const exercises = Array.from(this.lightbox.querySelectorAll('.exercise-item')).map(exercise => {
                const name = exercise.querySelector('.exercise-name')?.textContent?.trim();
                const details = exercise.querySelector('.exercise-details');
                const notes = exercise.querySelector('.exercise-notes')?.textContent?.trim() || '';

                if (!name || !details) {
                    throw new Error('Invalid exercise data found');
                }

                return {
                    name: name,
                    sets: this.extractNumber(details, 'sets') || 0,
                    reps: this.extractNumber(details, 'reps') || 0,
                    weight: this.extractNumber(details, 'weight') || 0,
                    notes: notes
                };
            });

            formData.append('title', title);
            formData.append('exercises', JSON.stringify(exercises));

            // Add debug information
            console.log('Saving workout with data:', {
                title: title,
                exercises: exercises,
                workout_id: this.currentWorkoutId
            });

            fetch(workoutLightboxData.ajaxurl, {
                method: 'POST',
                body: formData,
                credentials: 'same-origin'
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Save response:', data);
                if (data.success) {
                    this.hasUnsavedChanges = false;
                    content.classList.remove('has-unsaved-changes');
                    
                    // Store the updated workout data
                    this.currentWorkout = data.data.workout;
                    
                    // Show success message
                    const successMessage = document.createElement('div');
                    successMessage.className = 'save-success-message';
                    successMessage.textContent = data.data.message;
                    content.appendChild(successMessage);
                    setTimeout(() => successMessage.remove(), 3000);

                    // Exit edit mode
                    this.toggleEditMode();

                    // Update the content with the saved data
                    content.innerHTML = this.buildWorkoutContent(data.data.workout);
                    this.initializePrintButton();
                    this.initializeEditButtons();
                } else {
                    throw new Error(data.data?.message || 'Error saving workout');
                }
            })
            .catch(error => {
                console.error('Error saving workout:', error);
                const errorMessage = document.createElement('div');
                errorMessage.className = 'save-error-message';
                errorMessage.textContent = `Error: ${error.message}. Please try again.`;
                content.appendChild(errorMessage);
                setTimeout(() => errorMessage.remove(), 5000);
            })
            .finally(() => {
                // Remove loading state
                content.classList.remove('saving');
                const loadingIndicator = content.querySelector('.save-loading-indicator');
                if (loadingIndicator) {
                    loadingIndicator.remove();
                }
            });
        } catch (error) {
            console.error('Error preparing workout data:', error);
            content.classList.remove('saving');
            const loadingIndicator = content.querySelector('.save-loading-indicator');
            if (loadingIndicator) {
                loadingIndicator.remove();
            }
            
            const errorMessage = document.createElement('div');
            errorMessage.className = 'save-error-message';
            errorMessage.textContent = `Error: ${error.message}. Please check your workout data.`;
            content.appendChild(errorMessage);
            setTimeout(() => errorMessage.remove(), 5000);
        }
    }

    initializeEditMode() {
        const content = this.lightbox.querySelector('.workout-lightbox-content');
        
        // Add edit mode indicator
        const editModeIndicator = document.createElement('div');
        editModeIndicator.className = 'edit-mode-indicator hidden';
        editModeIndicator.innerHTML = '<span class="dashicons dashicons-edit"></span> Edit Mode';
        content.insertBefore(editModeIndicator, content.firstChild);
        
        // Add keyboard shortcuts
        document.addEventListener('keydown', (e) => {
            if (this.isEditing) {
                if (e.key === 'Escape') {
                    e.preventDefault();
                    if (this.hasUnsavedChanges) {
                        if (confirm('You have unsaved changes. Are you sure you want to exit edit mode?')) {
                            this.cancelEdit();
                        }
                    } else {
                        this.cancelEdit();
                    }
                } else if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                    e.preventDefault();
                    this.saveWorkout();
                }
            }
        });

        // Update the toggleEditMode method to handle the indicator
        const originalToggleEditMode = this.toggleEditMode.bind(this);
        this.toggleEditMode = () => {
            originalToggleEditMode();
            const indicator = this.lightbox.querySelector('.edit-mode-indicator');
            if (this.isEditing) {
                indicator.classList.remove('hidden');
            } else {
                indicator.classList.add('hidden');
            }
        };
    }

    cancelEdit() {
        if (this.isEditing) {
            // Reset all editable content to original state
            const editableBlocks = this.lightbox.querySelectorAll('[data-original-content]');
            editableBlocks.forEach(block => {
                block.innerHTML = block.dataset.originalContent;
                delete block.dataset.originalContent;
            });
            
            this.hasUnsavedChanges = false;
            this.toggleEditMode();
        }
    }
}

// Initialize the component when the script loads
const initWorkoutLightbox = () => {
    if (typeof window.workoutLightbox === 'undefined') {
        window.workoutLightbox = new WorkoutLightboxComponent();
    }
};

// Initialize on DOMContentLoaded or immediately if already loaded
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initWorkoutLightbox);
} else {
    initWorkoutLightbox();
} 