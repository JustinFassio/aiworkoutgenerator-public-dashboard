/**
 * Workout Detail Component
 * Handles the display and interaction of workout details
 */
class WorkoutDetailComponent {
    constructor() {
        // Singleton pattern
        if (WorkoutDetailComponent.instance) {
            return WorkoutDetailComponent.instance;
        }
        WorkoutDetailComponent.instance = this;

        this.container = document.querySelector('[data-component="workout-detail"]');
        this.detailContainer = this.container?.querySelector('.workout-detail-container');
        
        if (!this.container || !this.detailContainer) {
            console.error('Workout detail component elements not found');
            return;
        }

        this.bindEvents();
        this.initializeEventListeners();
    }

    /**
     * Bind events for workout detail interactions
     */
    bindEvents() {
        // Close detail view when clicking outside
        document.addEventListener('click', (e) => {
            if (this.container.classList.contains('active') && 
                !e.target.closest('.workout-detail') && 
                !e.target.closest('[data-action="view-workout"]')) {
                this.hide();
            }
        });

        // Handle escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.container.classList.contains('active')) {
                this.hide();
            }
        });

        // Delegate click events within the detail container
        this.detailContainer.addEventListener('click', (e) => {
            const closeBtn = e.target.closest('.close-detail');
            const printBtn = e.target.closest('.print-workout');

            if (closeBtn) {
                this.hide();
            } else if (printBtn) {
                this.printWorkout();
            }
        });
    }

    /**
     * Initialize event listeners for workout viewing
     */
    initializeEventListeners() {
        document.addEventListener('click', (e) => {
            const workoutTrigger = e.target.closest('[data-action="view-workout"]');
            if (workoutTrigger) {
                const workoutId = workoutTrigger.dataset.workoutId;
                if (workoutId) {
                    this.loadWorkout(workoutId);
                }
            }
        });
    }

    /**
     * Load workout details via AJAX
     * @param {string|number} workoutId 
     */
    async loadWorkout(workoutId) {
        try {
            this.showLoading();

            const formData = new FormData();
            formData.append('action', 'get_workout_detail');
            formData.append('workout_id', workoutId);
            formData.append('nonce', workoutDetailData.nonce);

            const response = await fetch(workoutDetailData.ajaxurl, {
                method: 'POST',
                credentials: 'same-origin',
                body: formData
            });

            const data = await response.json();

            if (!data.success) {
                throw new Error(data.data?.message || workoutDetailData.strings.error);
            }

            this.detailContainer.innerHTML = data.html;
            this.show();

        } catch (error) {
            console.error('Error loading workout:', error);
            this.showError(error.message);
        } finally {
            this.hideLoading();
        }
    }

    /**
     * Show the workout detail view
     */
    show() {
        this.container.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    /**
     * Hide the workout detail view
     */
    hide() {
        this.container.classList.remove('active');
        document.body.style.overflow = '';
    }

    /**
     * Show loading state
     */
    showLoading() {
        this.detailContainer.innerHTML = `
            <div class="workout-detail__loading">
                <p>${workoutDetailData.strings.loading}</p>
            </div>
        `;
        this.show();
    }

    /**
     * Hide loading state
     */
    hideLoading() {
        const loadingEl = this.detailContainer.querySelector('.workout-detail__loading');
        if (loadingEl) {
            loadingEl.remove();
        }
    }

    /**
     * Show error message
     * @param {string} message 
     */
    showError(message) {
        this.detailContainer.innerHTML = `
            <div class="workout-detail__error">
                <p>${message}</p>
                <button type="button" class="button close-detail">
                    ${workoutDetailData.strings.close}
                </button>
            </div>
        `;
    }

    /**
     * Print the current workout
     */
    printWorkout() {
        const printContent = this.detailContainer.cloneNode(true);
        const closeButton = printContent.querySelector('.close-detail');
        if (closeButton) {
            closeButton.remove();
        }

        const printWindow = window.open('', '_blank');
        printWindow.document.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <title>Print Workout</title>
                <link rel="stylesheet" href="${document.querySelector('link[rel="stylesheet"]').href}">
                <style>
                    body { padding: 20px; }
                    .workout-detail__actions { display: none; }
                </style>
            </head>
            <body>
                ${printContent.innerHTML}
            </body>
            </html>
        `);
        printWindow.document.close();
        printWindow.focus();
        printWindow.print();
        printWindow.close();
    }
}

// Initialize the component when the DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    new WorkoutDetailComponent();
}); 