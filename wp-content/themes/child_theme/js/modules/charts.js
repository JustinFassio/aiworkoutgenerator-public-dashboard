/**
 * Athlete Dashboard Charts Module
 */
(function($) {
    'use strict';

    const AthleteCharts = {
        charts: {},

        init: function() {
            this.bindEvents();
            this.initializeCharts();
        },

        bindEvents: function() {
            $(document).on('change', '.chart-period-selector', this.handlePeriodChange.bind(this));
            $(document).on('change', '.metric-selector', this.handleMetricChange.bind(this));
        },

        initializeCharts: function() {
            // Initialize workout progress chart
            this.initializeWorkoutChart();
            
            // Initialize attendance chart
            this.initializeAttendanceChart();
            
            // Initialize goals chart
            this.initializeGoalsChart();
            
            // Initialize progress metrics chart
            this.initializeProgressChart();
        },

        initializeWorkoutChart: function() {
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
        },

        initializeAttendanceChart: function() {
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
        },

        initializeGoalsChart: function() {
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
        },

        initializeProgressChart: function() {
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
        },

        loadWorkoutData: function(period = '30days') {
            $.ajax({
                url: athleteDashboard.ajax_url,
                type: 'POST',
                data: {
                    action: 'get_workout_stats',
                    nonce: athleteDashboard.nonce,
                    period: period
                },
                success: function(response) {
                    if (response.success) {
                        this.updateWorkoutChart(response.data);
                    }
                }.bind(this)
            });
        },

        loadAttendanceData: function(period = '30days') {
            $.ajax({
                url: athleteDashboard.ajax_url,
                type: 'POST',
                data: {
                    action: 'get_attendance_data',
                    nonce: athleteDashboard.nonce,
                    period: period
                },
                success: function(response) {
                    if (response.success) {
                        this.updateAttendanceChart(response.data);
                    }
                }.bind(this)
            });
        },

        loadGoalsData: function() {
            $.ajax({
                url: athleteDashboard.ajax_url,
                type: 'POST',
                data: {
                    action: 'get_goals_data',
                    nonce: athleteDashboard.nonce
                },
                success: function(response) {
                    if (response.success) {
                        this.updateGoalsChart(response.data);
                    }
                }.bind(this)
            });
        },

        loadProgressData: function(metric = 'weight') {
            $.ajax({
                url: athleteDashboard.ajax_url,
                type: 'POST',
                data: {
                    action: 'get_progress_metrics',
                    nonce: athleteDashboard.nonce,
                    metric: metric
                },
                success: function(response) {
                    if (response.success) {
                        this.updateProgressChart(response.data);
                    }
                }.bind(this)
            });
        },

        updateWorkoutChart: function(data) {
            if (!this.charts.workout) return;

            this.charts.workout.data.labels = data.labels;
            this.charts.workout.data.datasets[0].data = data.datasets[0].data;
            this.charts.workout.update();

            // Update stats
            $('#total-workouts').text(data.total_workouts);
            $('#avg-duration').text(data.avg_duration + ' min');
            $('#total-calories').text(data.total_calories + ' kcal');
        },

        updateAttendanceChart: function(data) {
            if (!this.charts.attendance) return;

            this.charts.attendance.data.labels = data.labels;
            this.charts.attendance.data.datasets[0].data = data.datasets[0].data;
            this.charts.attendance.update();

            // Update stats
            $('#attendance-rate').text(data.attendance_rate + '%');
            $('#current-streak').text(data.current_streak + ' days');
            $('#best-streak').text(data.best_streak + ' days');
        },

        updateGoalsChart: function(data) {
            if (!this.charts.goals) return;

            this.charts.goals.data.datasets[0].data = [
                data.completed,
                data.in_progress,
                data.not_started
            ];
            this.charts.goals.update();

            // Update stats
            $('#goals-completed').text(data.completed);
            $('#goals-in-progress').text(data.in_progress);
            $('#completion-rate').text(data.completion_rate + '%');
        },

        updateProgressChart: function(data) {
            if (!this.charts.progress) return;

            this.charts.progress.data.labels = data.labels;
            this.charts.progress.data.datasets[0].data = data.datasets[0].data;
            this.charts.progress.update();

            // Update stats
            $('#starting-value').text(data.starting + ' ' + data.unit);
            $('#current-value').text(data.current + ' ' + data.unit);
            $('#total-change').text((data.change >= 0 ? '+' : '') + data.change + ' ' + data.unit);
        },

        handlePeriodChange: function(e) {
            const period = $(e.target).val();
            const chartType = $(e.target).data('chart-type');

            switch (chartType) {
                case 'workout':
                    this.loadWorkoutData(period);
                    break;
                case 'attendance':
                    this.loadAttendanceData(period);
                    break;
            }
        },

        handleMetricChange: function(e) {
            const metric = $(e.target).val();
            this.loadProgressData(metric);
        }
    };

    // Initialize on document ready
    $(document).ready(function() {
        AthleteCharts.init();
    });

})(jQuery); 