/**
 * Progress Tracker Component
 */
if (typeof ProgressTrackerComponent === 'undefined') {
    class ProgressTrackerComponent {
        constructor() {
            this.container = document.querySelector('.progress-tracker');
            this.charts = new Map();
            this.init();
        }

        init() {
            if (!this.container) return;

            this.initializeCharts();
            this.initializeEventListeners();
        }

        initializeCharts() {
            const chartContainers = this.container.querySelectorAll('.progress-chart');
            chartContainers.forEach(container => {
                const canvas = container.querySelector('canvas');
                if (!canvas) return;

                const type = container.dataset.type;
                const data = JSON.parse(container.dataset.progress || '[]');
                
                this.charts.set(type, this.createChart(canvas, data));
            });
        }

        createChart(canvas, data) {
            return new Chart(canvas, {
                type: 'line',
                data: {
                    datasets: [{
                        label: 'Progress',
                        data: data,
                        borderColor: '#4CAF50',
                        backgroundColor: 'rgba(76, 175, 80, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            type: 'time',
                            time: {
                                unit: 'day'
                            },
                            title: {
                                display: true,
                                text: 'Date'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Value'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `${context.parsed.y} ${context.dataset.unit || ''}`;
                                }
                            }
                        }
                    }
                }
            });
        }

        initializeEventListeners() {
            const forms = this.container.querySelectorAll('.progress-form');
            forms.forEach(form => {
                form.addEventListener('submit', (e) => this.handleSubmit(e));
            });
        }

        handleSubmit(e) {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);
            formData.append('action', 'log_progress');
            formData.append('nonce', athleteDashboardData.nonce);

            form.classList.add('loading');

            fetch(athleteDashboardData.ajaxurl, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.athleteDashboard.showNotification(data.data.message, 'success');
                    this.updateChart(data.data.type, data.data.progress);
                    form.reset();
                } else {
                    window.athleteDashboard.showNotification(data.data, 'error');
                }
            })
            .catch(error => {
                window.athleteDashboard.showNotification('Error logging progress', 'error');
            })
            .finally(() => {
                form.classList.remove('loading');
            });
        }

        updateChart(type, newData) {
            const chart = this.charts.get(type);
            if (!chart) return;

            chart.data.datasets[0].data = newData;
            chart.update();
        }
    }
} 