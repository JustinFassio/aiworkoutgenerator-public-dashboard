/**
 * Athlete Dashboard Charts Module
 */
import { UI } from './ui.js';

export class AthleteCharts {
    constructor() {
        this.initialized = false;
        this.charts = {};
    }

    init() {
        if (this.initialized) return;
        this.bindEvents();
        this.initializeCharts();
        this.initialized = true;
    }

    bindEvents() {
        document.addEventListener('change', (e) => {
            if (e.target.matches('.chart-period-selector')) {
                this.handlePeriodChange(e);
            }
            if (e.target.matches('.metric-selector')) {
                this.handleMetricChange(e);
            }
        });
    }

    initializeCharts() {
        // Initialize all charts
        this.initializeWorkoutChart();
        this.initializeAttendanceChart();
        this.initializeGoalsChart();
        this.initializeProgressChart();
    }

    initializeWorkoutChart() {
        const ctx = document.getElementById('workout-chart');
        if (!ctx) return;

        this.charts.workout = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Workouts',
                    data: [],
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        this.loadWorkoutData();
    }

    initializeAttendanceChart() {
        const ctx = document.getElementById('attendance-chart');
        if (!ctx) return;

        this.charts.attendance = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [],
                datasets: [{
                    label: 'Attendance',
                    data: [],
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgb(54, 162, 235)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 1,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        this.loadAttendanceData();
    }

    initializeGoalsChart() {
        const ctx = document.getElementById('goals-chart');
        if (!ctx) return;

        this.charts.goals = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Completed', 'In Progress', 'Not Started'],
                datasets: [{
                    data: [],
                    backgroundColor: [
                        'rgb(75, 192, 192)',
                        'rgb(255, 205, 86)',
                        'rgb(201, 203, 207)'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        this.loadGoalsData();
    }

    initializeProgressChart() {
        const ctx = document.getElementById('progress-chart');
        if (!ctx) return;

        this.charts.progress = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Progress',
                    data: [],
                    borderColor: 'rgb(153, 102, 255)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        this.loadProgressData();
    }

    async loadWorkoutData(period = '30days') {
        const container = document.getElementById('workout-chart-container');
        if (!container) return;

        const loader = UI.showLoading(container);

        try {
            const response = await fetch(window.athleteDashboard.ajax_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'get_workout_stats',
                    nonce: window.athleteDashboard.nonce,
                    period: period
                })
            });

            const data = await response.json();
            
            if (data.success) {
                this.updateWorkoutChart(data.data);
            } else {
                this.showMessage('Error loading workout data. Please try again.', 'error', container);
            }
        } catch (error) {
            this.showMessage('Server error. Please try again later.', 'error', container);
            console.error('Workout data loading error:', error);
        } finally {
            UI.hideLoading(loader);
        }
    }

    async loadAttendanceData(period = '30days') {
        const container = document.getElementById('attendance-chart-container');
        if (!container) return;

        const loader = UI.showLoading(container);

        try {
            const response = await fetch(window.athleteDashboard.ajax_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'get_attendance_data',
                    nonce: window.athleteDashboard.nonce,
                    period: period
                })
            });

            const data = await response.json();
            
            if (data.success) {
                this.updateAttendanceChart(data.data);
            } else {
                this.showMessage('Error loading attendance data. Please try again.', 'error', container);
            }
        } catch (error) {
            this.showMessage('Server error. Please try again later.', 'error', container);
            console.error('Attendance data loading error:', error);
        } finally {
            UI.hideLoading(loader);
        }
    }

    async loadGoalsData() {
        const container = document.getElementById('goals-chart-container');
        if (!container) return;

        const loader = UI.showLoading(container);

        try {
            const response = await fetch(window.athleteDashboard.ajax_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'get_goals_data',
                    nonce: window.athleteDashboard.nonce
                })
            });

            const data = await response.json();
            
            if (data.success) {
                this.updateGoalsChart(data.data);
            } else {
                this.showMessage('Error loading goals data. Please try again.', 'error', container);
            }
        } catch (error) {
            this.showMessage('Server error. Please try again later.', 'error', container);
            console.error('Goals data loading error:', error);
        } finally {
            UI.hideLoading(loader);
        }
    }

    async loadProgressData(metric = 'weight') {
        const container = document.getElementById('progress-chart-container');
        if (!container) return;

        const loader = UI.showLoading(container);

        try {
            const response = await fetch(window.athleteDashboard.ajax_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'get_progress_metrics',
                    nonce: window.athleteDashboard.nonce,
                    metric: metric
                })
            });

            const data = await response.json();
            
            if (data.success) {
                this.updateProgressChart(data.data);
            } else {
                this.showMessage('Error loading progress data. Please try again.', 'error', container);
            }
        } catch (error) {
            this.showMessage('Server error. Please try again later.', 'error', container);
            console.error('Progress data loading error:', error);
        } finally {
            UI.hideLoading(loader);
        }
    }

    updateWorkoutChart(data) {
        if (!this.charts.workout) return;

        this.charts.workout.data.labels = data.labels;
        this.charts.workout.data.datasets[0].data = data.datasets[0].data;
        this.charts.workout.update();

        // Update stats
        const elements = {
            totalWorkouts: document.getElementById('total-workouts'),
            avgDuration: document.getElementById('avg-duration'),
            totalCalories: document.getElementById('total-calories')
        };

        if (elements.totalWorkouts) elements.totalWorkouts.textContent = data.total_workouts;
        if (elements.avgDuration) elements.avgDuration.textContent = `${data.avg_duration} min`;
        if (elements.totalCalories) elements.totalCalories.textContent = `${data.total_calories} kcal`;
    }

    updateAttendanceChart(data) {
        if (!this.charts.attendance) return;

        this.charts.attendance.data.labels = data.labels;
        this.charts.attendance.data.datasets[0].data = data.datasets[0].data;
        this.charts.attendance.update();

        // Update stats
        const elements = {
            rate: document.getElementById('attendance-rate'),
            currentStreak: document.getElementById('current-streak'),
            bestStreak: document.getElementById('best-streak')
        };

        if (elements.rate) elements.rate.textContent = `${data.attendance_rate}%`;
        if (elements.currentStreak) elements.currentStreak.textContent = `${data.current_streak} days`;
        if (elements.bestStreak) elements.bestStreak.textContent = `${data.best_streak} days`;
    }

    updateGoalsChart(data) {
        if (!this.charts.goals) return;

        this.charts.goals.data.datasets[0].data = [
            data.completed,
            data.in_progress,
            data.not_started
        ];
        this.charts.goals.update();

        // Update completion rate
        const completionRate = document.getElementById('goals-completion-rate');
        if (completionRate) {
            const total = data.completed + data.in_progress + data.not_started;
            const rate = total > 0 ? Math.round((data.completed / total) * 100) : 0;
            completionRate.textContent = `${rate}%`;
        }
    }

    updateProgressChart(data) {
        if (!this.charts.progress) return;

        this.charts.progress.data.labels = data.labels;
        this.charts.progress.data.datasets[0].data = data.datasets[0].data;
        this.charts.progress.data.datasets[0].label = data.metric_label;
        this.charts.progress.options.scales.y.title = {
            display: true,
            text: data.metric_unit
        };
        this.charts.progress.update();

        // Update progress stats
        const elements = {
            current: document.getElementById('current-value'),
            change: document.getElementById('total-change'),
            trend: document.getElementById('trend-indicator')
        };

        if (elements.current) elements.current.textContent = `${data.current_value} ${data.metric_unit}`;
        if (elements.change) {
            const changeValue = data.total_change;
            const prefix = changeValue > 0 ? '+' : '';
            elements.change.textContent = `${prefix}${changeValue} ${data.metric_unit}`;
            elements.change.className = `change-value ${changeValue > 0 ? 'positive' : 'negative'}`;
        }
        if (elements.trend) {
            elements.trend.className = `trend-indicator ${data.trend}`;
            elements.trend.setAttribute('aria-label', `Trend: ${data.trend}`);
        }
    }

    handlePeriodChange(e) {
        const period = e.target.value;
        const chartType = e.target.dataset.chartType;

        switch (chartType) {
            case 'workout':
                this.loadWorkoutData(period);
                break;
            case 'attendance':
                this.loadAttendanceData(period);
                break;
            default:
                console.warn('Unknown chart type:', chartType);
        }
    }

    handleMetricChange(e) {
        const metric = e.target.value;
        this.loadProgressData(metric);
    }

    showMessage(message, type, container) {
        const messageDiv = container.querySelector('.chart-message') || 
            UI.createElement('div', 'chart-message');
        
        messageDiv.className = `chart-message ${type}`;
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

    // Cleanup method to destroy chart instances
    destroy() {
        Object.values(this.charts).forEach(chart => {
            if (chart && typeof chart.destroy === 'function') {
                chart.destroy();
            }
        });
        this.charts = {};
    }
}

// Export singleton instance
export const Charts = new AthleteCharts();

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => Charts.init()); 