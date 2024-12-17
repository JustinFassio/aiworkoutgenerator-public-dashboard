/**
 * Squat Progress Component
 * Handles squat progress tracking functionality
 */
class SquatProgress {
    constructor() {
        // Elements
        this.dialog = document.getElementById('squatEntryDialog');
        this.form = document.getElementById('squatProgressForm');
        this.chartCanvas = document.getElementById('squatProgressChart');
        this.addButton = document.querySelector('.add-entry-button');
        this.closeButton = document.querySelector('.close-dialog');
        this.cancelButton = document.querySelector('.cancel-button');
        
        // Chart instance
        this.chart = null;
        
        // Initialize if all required elements are present
        if (this.dialog && this.form && this.chartCanvas) {
            this.initialize();
        } else {
            console.error('Required elements not found for Squat Progress component');
        }
    }

    initialize() {
        // Initialize chart
        this.initializeChart();
        
        // Load initial data
        this.loadData();
        
        // Bind event listeners
        this.bindEvents();
    }

    initializeChart() {
        // Destroy existing chart instance if it exists
        if (this.chart) {
            this.chart.destroy();
        }

        const ctx = this.chartCanvas.getContext('2d');
        if (!ctx) return;

        this.chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Weight (kg)',
                    data: [],
                    borderColor: '#2196F3',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: false,
                        title: {
                            display: true,
                            text: 'Weight (kg)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    }
                }
            }
        });
    }

    bindEvents() {
        // Dialog management
        this.addButton.addEventListener('click', () => this.openDialog());
        this.closeButton.addEventListener('click', () => this.closeDialog());
        this.cancelButton.addEventListener('click', () => this.closeDialog());
        
        // Form submission
        this.form.addEventListener('submit', (e) => this.handleSubmit(e));
        
        // Delete entry handling
        document.addEventListener('click', (e) => {
            if (e.target.matches('.delete-entry')) {
                this.handleDelete(e.target.dataset.id);
            }
        });

        // Cleanup on page unload
        window.addEventListener('unload', () => {
            if (this.chart) {
                this.chart.destroy();
            }
        });
    }

    openDialog() {
        // Set today's date as default
        const today = new Date().toISOString().split('T')[0];
        this.form.querySelector('#squatDate').value = today;
        
        // Show dialog
        this.dialog.showModal();
        
        // Focus first input
        this.form.querySelector('#squatWeight').focus();
    }

    closeDialog() {
        this.dialog.close();
        this.form.reset();
    }

    handleSubmit(e) {
        e.preventDefault();
        const formData = new FormData(this.form);

        jQuery.ajax({
            url: athleteSquatProgress.ajaxurl,
            type: 'POST',
            data: {
                action: 'save_squat_progress_data',
                nonce: athleteSquatProgress.nonce,
                date: formData.get('date'),
                weight: formData.get('weight'),
                reps: formData.get('reps'),
                notes: formData.get('notes')
            },
            success: (response) => {
                if (response.success) {
                    this.closeDialog();
                    this.loadData();
                } else {
                    this.showError(response.data.message);
                }
            },
            error: (xhr, status, error) => {
                this.showError('Failed to save entry. Please try again.');
                console.error('AJAX Error:', error);
            }
        });
    }

    handleDelete(entryId) {
        if (!confirm('Are you sure you want to delete this entry?')) {
            return;
        }

        jQuery.ajax({
            url: athleteSquatProgress.ajaxurl,
            type: 'POST',
            data: {
                action: 'delete_squat_progress_entry',
                nonce: athleteSquatProgress.nonce,
                entry_id: entryId
            },
            success: (response) => {
                if (response.success) {
                    this.loadData();
                } else {
                    this.showError(response.data.message);
                }
            },
            error: (xhr, status, error) => {
                this.showError('Failed to delete entry. Please try again.');
                console.error('AJAX Error:', error);
            }
        });
    }

    loadData() {
        jQuery.ajax({
            url: athleteSquatProgress.ajaxurl,
            type: 'POST',
            data: {
                action: 'get_squat_progress_data',
                nonce: athleteSquatProgress.nonce
            },
            success: (response) => {
                if (response.success && response.data) {
                    this.updateChart(response.data);
                    this.updateTable(response.data);
                } else {
                    this.showError('Failed to load progress data.');
                }
            },
            error: (xhr, status, error) => {
                this.showError('Failed to load progress data.');
                console.error('AJAX Error:', error);
            }
        });
    }

    updateChart(data) {
        if (!this.chart) return;

        this.chart.data.labels = data.map(entry => entry.date);
        this.chart.data.datasets[0].data = data.map(entry => entry.weight);
        this.chart.update();
    }

    updateTable(data) {
        const tbody = document.querySelector('.progress-table tbody');
        if (!tbody) return;

        tbody.innerHTML = data.map(entry => `
            <tr>
                <td>${entry.date}</td>
                <td>${entry.weight}</td>
                <td>${entry.reps}</td>
                <td>${entry.notes || ''}</td>
                <td>
                    <button type="button" class="delete-entry" data-id="${entry.id}" aria-label="Delete entry from ${entry.date}">
                        Delete
                    </button>
                </td>
            </tr>
        `).join('');
    }

    showError(message) {
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-message';
        errorDiv.textContent = message;

        const container = this.chartCanvas.parentElement;
        container.insertBefore(errorDiv, container.firstChild);

        setTimeout(() => {
            errorDiv.remove();
        }, 5000);
    }
}

// Initialize when document is ready
document.addEventListener('DOMContentLoaded', () => {
    new SquatProgress();
}); 