/**
 * AthleteCharts Module
 * Handles all chart-related functionality for the athlete dashboard
 */
const AthleteCharts = (function($) {
    'use strict';

    // Private variables
    let config = {
        selectors: {
            progressCharts: '.athlete-dashboard-progress',
            exerciseCharts: '.exercise-chart',
            bodyWeightChart: '#body-weight-chart',
            strengthCharts: '.strength-chart',
            distributionCharts: '.distribution-chart'
        },
        charts: {},
        updateInterval: 300000 // 5 minutes
    };

    /**
     * Initialize chart instances
     */
    function initializeCharts() {
        // Initialize progress charts if they exist
        if ($(config.selectors.progressCharts).length) {
            initializeProgressCharts();
        }

        // Initialize exercise charts if they exist
        if ($(config.selectors.exerciseCharts).length) {
            initializeExerciseCharts();
        }

        // Start periodic updates
        startPeriodicUpdates();
    }

    /**
     * Initialize progress charts
     */
    function initializeProgressCharts() {
        config.charts.progress = new Chart($(config.selectors.bodyWeightChart), {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Progress',
                    data: [],
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        // Initialize distribution charts
        initializeDistributionCharts();
    }

    /**
     * Initialize exercise charts
     */
    function initializeExerciseCharts() {
        Object.keys(window.athleteDashboard.exerciseTests).forEach(exerciseKey => {
            if (!chartExists(exerciseKey)) {
                initializeExerciseChart(exerciseKey);
            }
        });
    }

    /**
     * Initialize a specific exercise chart
     */
    function initializeExerciseChart(exerciseKey) {
        const chartCanvas = document.querySelector(`#${exerciseKey}-chart`);
        if (!chartCanvas) return;

        config.charts[exerciseKey] = new Chart(chartCanvas, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: window.athleteDashboard.exerciseTests[exerciseKey].name,
                    data: [],
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }

    /**
     * Initialize distribution charts
     */
    function initializeDistributionCharts() {
        // Initialize workout type distribution chart
        config.charts.typeDistribution = new Chart($('#workout-type-distribution'), {
            type: 'doughnut',
            data: {
                labels: [],
                datasets: [{
                    data: [],
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 206, 86)',
                        'rgb(75, 192, 192)'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        // Initialize muscle group distribution chart
        config.charts.muscleGroupDistribution = new Chart($('#muscle-group-distribution'), {
            type: 'doughnut',
            data: {
                labels: [],
                datasets: [{
                    data: [],
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 206, 86)',
                        'rgb(75, 192, 192)'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }

    /**
     * Update exercise chart data
     */
    function updateExerciseChart(exerciseKey) {
        $.ajax({
            url: window.athleteDashboard.ajax_url,
            type: 'POST',
            data: {
                action: 'athlete_dashboard_get_exercise_progress',
                exercise_key: exerciseKey,
                nonce: window.athleteDashboard.nonce
            },
            success: function(response) {
                if (response.success && config.charts[exerciseKey]) {
                    const chart = config.charts[exerciseKey];
                    chart.data.labels = response.data.labels;
                    chart.data.datasets[0].data = response.data.values;
                    chart.update();
                }
            },
            error: function(xhr, status, error) {
                console.error('Error updating exercise chart:', error);
            }
        });
    }

    /**
     * Update body weight progress chart
     */
    function updateBodyWeightProgressChart() {
        $.ajax({
            url: window.athleteDashboard.ajax_url,
            type: 'POST',
            data: {
                action: 'athlete_dashboard_get_body_weight_progress',
                nonce: window.athleteDashboard.nonce
            },
            success: function(response) {
                if (response.success && config.charts.progress) {
                    const chart = config.charts.progress;
                    chart.data.labels = response.data.labels;
                    chart.data.datasets[0].data = response.data.values;
                    chart.update();
                }
            },
            error: function(xhr, status, error) {
                console.error('Error updating body weight progress chart:', error);
            }
        });
    }

    /**
     * Update distribution charts
     */
    function updateDistributionCharts() {
        $.ajax({
            url: window.athleteDashboard.ajax_url,
            type: 'POST',
            data: {
                action: 'athlete_dashboard_get_workout_distribution',
                nonce: window.athleteDashboard.nonce
            },
            success: function(response) {
                if (response.success) {
                    // Update workout type distribution
                    if (config.charts.typeDistribution) {
                        config.charts.typeDistribution.data.labels = response.data.types.labels;
                        config.charts.typeDistribution.data.datasets[0].data = response.data.types.values;
                        config.charts.typeDistribution.update();
                    }

                    // Update muscle group distribution
                    if (config.charts.muscleGroupDistribution) {
                        config.charts.muscleGroupDistribution.data.labels = response.data.muscle_groups.labels;
                        config.charts.muscleGroupDistribution.data.datasets[0].data = response.data.muscle_groups.values;
                        config.charts.muscleGroupDistribution.update();
                    }
                }
            },
            error: function(xhr, status, error) {
                console.error('Error updating distribution charts:', error);
            }
        });
    }

    /**
     * Check if a chart exists
     */
    function chartExists(chartKey) {
        return config.charts.hasOwnProperty(chartKey) && config.charts[chartKey] !== null;
    }

    /**
     * Start periodic updates
     */
    function startPeriodicUpdates() {
        setInterval(function() {
            Object.keys(config.charts).forEach(function(chartKey) {
                if (chartKey === 'progress') {
                    updateBodyWeightProgressChart();
                } else if (chartKey === 'typeDistribution' || chartKey === 'muscleGroupDistribution') {
                    updateDistributionCharts();
                } else {
                    updateExerciseChart(chartKey);
                }
            });
        }, config.updateInterval);
    }

    /**
     * Initialize all chart components
     */
    function initialize() {
        initializeCharts();
    }

    // Public API
    return {
        initialize,
        initializeExerciseChart,
        updateExerciseChart,
        updateBodyWeightProgressChart,
        updateDistributionCharts,
        chartExists
    };

})(jQuery);

// Initialize when document is ready
jQuery(document).ready(function() {
    AthleteCharts.initialize();
}); 