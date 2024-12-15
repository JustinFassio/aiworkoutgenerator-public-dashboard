/**
 * Progress Charts JavaScript
 * 
 * Handles chart rendering and data updates using Chart.js
 */

(function($) {
    'use strict';

    class ProgressCharts {
        constructor() {
            this.container = $('.athlete-dashboard-progress');
            this.progressChart = null;
            this.typeChart = null;
            this.muscleGroupChart = null;

            this.initializeCharts();
            this.bindEvents();
        }

        initializeCharts() {
            // Initialize progress chart
            const progressCtx = document.getElementById('progressChart').getContext('2d');
            this.progressChart = new Chart(progressCtx, {
                type: 'line',
                data: {
                    labels: [],
                    datasets: [{
                        label: athleteDashboardCharts.i18n.volume,
                        data: [],
                        borderColor: '#4CAF50',
                        backgroundColor: 'rgba(76, 175, 80, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Initialize type distribution chart
            const typeCtx = document.getElementById('typeChart').getContext('2d');
            this.typeChart = new Chart(typeCtx, {
                type: 'doughnut',
                data: {
                    labels: [],
                    datasets: [{
                        data: [],
                        backgroundColor: [
                            '#FF6384',
                            '#36A2EB',
                            '#FFCE56',
                            '#4BC0C0',
                            '#9966FF'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right'
                        }
                    }
                }
            });

            // Initialize muscle group distribution chart
            const muscleGroupCtx = document.getElementById('muscleGroupChart').getContext('2d');
            this.muscleGroupChart = new Chart(muscleGroupCtx, {
                type: 'doughnut',
                data: {
                    labels: [],
                    datasets: [{
                        data: [],
                        backgroundColor: [
                            '#FF6384',
                            '#36A2EB',
                            '#FFCE56',
                            '#4BC0C0',
                            '#9966FF',
                            '#FF9F40',
                            '#4CAF50'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right'
                        }
                    }
                }
            });

            // Load initial data
            this.loadProgressData('volume', 'month');
            this.loadDistributionData();
        }

        bindEvents() {
            // Handle metric selection change
            this.container.on('change', '.metric-selector', (e) => {
                const metric = $(e.currentTarget).val();
                const period = this.container.find('.period-selector').val();
                this.loadProgressData(metric, period);
            });

            // Handle period selection change
            this.container.on('change', '.period-selector', (e) => {
                const period = $(e.currentTarget).val();
                const metric = this.container.find('.metric-selector').val();
                this.loadProgressData(metric, period);
            });
        }

        loadProgressData(metric, period) {
            $.ajax({
                url: athleteDashboardCharts.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'get_progress_data',
                    nonce: athleteDashboardCharts.nonce,
                    metric: metric,
                    period: period
                },
                success: (response) => {
                    if (response.success) {
                        this.updateProgressChart(response.data, metric);
                    }
                }
            });
        }

        loadDistributionData() {
            $.ajax({
                url: athleteDashboardCharts.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'get_workout_distribution',
                    nonce: athleteDashboardCharts.nonce
                },
                success: (response) => {
                    if (response.success) {
                        this.updateDistributionCharts(response.data);
                    }
                }
            });
        }

        updateProgressChart(data, metric) {
            this.progressChart.data.labels = data.labels;
            this.progressChart.data.datasets[0].label = athleteDashboardCharts.i18n[metric];
            this.progressChart.data.datasets[0].data = data.values;
            this.progressChart.update();
        }

        updateDistributionCharts(data) {
            // Update workout type distribution
            this.typeChart.data.labels = data.types.labels;
            this.typeChart.data.datasets[0].data = data.types.values;
            this.typeChart.update();

            // Update muscle group distribution
            this.muscleGroupChart.data.labels = data.muscle_groups.labels;
            this.muscleGroupChart.data.datasets[0].data = data.muscle_groups.values;
            this.muscleGroupChart.update();
        }
    }

    // Initialize charts when document is ready
    $(document).ready(() => {
        if ($('.athlete-dashboard-progress').length) {
            new ProgressCharts();
        }
    });

})(jQuery); 