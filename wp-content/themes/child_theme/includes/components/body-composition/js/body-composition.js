/**
 * Body Composition Component JavaScript
 */

(function($) {
    'use strict';

    // Chart instance
    let bodyCompositionChart = null;

    // Component initialization
    function initBodyComposition() {
        // Initialize chart
        const ctx = document.getElementById('body-composition-chart').getContext('2d');
        bodyCompositionChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: '',
                    data: [],
                    borderColor: '#2196F3',
                    backgroundColor: 'rgba(33, 150, 243, 0.1)',
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
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                const metric = $('#metric-selector').val();
                                return value + getMetricUnit(metric);
                            }
                        }
                    },
                    x: {
                        type: 'time',
                        time: {
                            unit: 'day',
                            displayFormats: {
                                day: 'MMM D'
                            }
                        }
                    }
                }
            }
        });

        // Load initial data
        loadData();

        // Event listeners
        $('#metric-selector, #period-selector').on('change', loadData);
        $('#add-entry-button').on('click', showEntryModal);
        $('#body-composition-form').on('submit', saveEntry);
        $('.modal .close-button, .modal .cancel-button').on('click', hideEntryModal);
        $(document).on('click', '.delete-entry', deleteEntry);
    }

    // Load data from the server
    function loadData() {
        const metric = $('#metric-selector').val();
        const period = $('#period-selector').val();

        $.ajax({
            url: athleteDashboardData.ajaxurl,
            type: 'GET',
            data: {
                action: 'get_body_composition_data',
                nonce: athleteDashboardData.nonce,
                metric: metric,
                period: period
            },
            success: function(response) {
                if (response.success) {
                    updateChart(response.data.data, metric);
                    updateStats(response.data.stats, metric);
                    updateEntriesTable(response.data.data);
                }
            },
            error: function() {
                showError('Failed to load data');
            }
        });
    }

    // Update chart with new data
    function updateChart(data, metric) {
        const chartData = {
            labels: data.map(entry => entry.date),
            datasets: [{
                label: getMetricLabel(metric),
                data: data.map(entry => ({
                    x: entry.date,
                    y: parseFloat(entry[metric])
                })),
                borderColor: '#2196F3',
                backgroundColor: 'rgba(33, 150, 243, 0.1)',
                tension: 0.4,
                fill: true
            }]
        };

        bodyCompositionChart.data = chartData;
        bodyCompositionChart.options.scales.y.ticks.callback = function(value) {
            return value + getMetricUnit(metric);
        };
        bodyCompositionChart.update();
    }

    // Update statistics display
    function updateStats(stats, metric) {
        const unit = getMetricUnit(metric);
        $('#current-value').text(formatValue(stats.current_value) + unit);
        $('#total-change').text(formatValue(stats.total_change) + unit)
            .removeClass('positive negative')
            .addClass(stats.total_change >= 0 ? 'positive' : 'negative');
        $('#average-value').text(formatValue(stats.avg_value) + unit);
    }

    // Update entries table
    function updateEntriesTable(data) {
        const tbody = $('#entries-table-body');
        tbody.empty();

        data.forEach(entry => {
            const row = $('<tr>').append(
                $('<td>').text(formatDate(entry.date)),
                $('<td>').text(formatValue(entry.weight) + ' kg'),
                $('<td>').text(formatValue(entry.body_fat) + ' %'),
                $('<td>').text(formatValue(entry.muscle_mass) + ' kg'),
                $('<td>').text(formatValue(entry.waist) + ' cm'),
                $('<td>').append(
                    $('<button>')
                        .addClass('delete-entry')
                        .attr('data-id', entry.id)
                        .text('Delete')
                )
            );
            tbody.append(row);
        });
    }

    // Save new entry
    function saveEntry(e) {
        e.preventDefault();

        const formData = new FormData(e.target);
        const data = {
            action: 'save_body_composition_data',
            nonce: athleteDashboardData.nonce
        };

        for (const [key, value] of formData.entries()) {
            data[key] = value;
        }

        $.ajax({
            url: athleteDashboardData.ajaxurl,
            type: 'POST',
            data: data,
            success: function(response) {
                if (response.success) {
                    hideEntryModal();
                    loadData();
                    showSuccess('Entry saved successfully');
                } else {
                    showError(response.data.message);
                }
            },
            error: function() {
                showError('Failed to save entry');
            }
        });
    }

    // Delete entry
    function deleteEntry(e) {
        if (!confirm('Are you sure you want to delete this entry?')) {
            return;
        }

        const entryId = $(e.target).data('id');

        $.ajax({
            url: athleteDashboardData.ajaxurl,
            type: 'POST',
            data: {
                action: 'delete_body_composition_entry',
                nonce: athleteDashboardData.nonce,
                entry_id: entryId
            },
            success: function(response) {
                if (response.success) {
                    loadData();
                    showSuccess('Entry deleted successfully');
                } else {
                    showError(response.data.message);
                }
            },
            error: function() {
                showError('Failed to delete entry');
            }
        });
    }

    // Helper functions
    function showEntryModal() {
        $('#entry-date').val(new Date().toISOString().split('T')[0]);
        $('#entry-modal').show();
    }

    function hideEntryModal() {
        $('#entry-modal').hide();
        $('#body-composition-form')[0].reset();
    }

    function getMetricLabel(metric) {
        return athleteDashboardData.i18n[metric] || metric;
    }

    function getMetricUnit(metric) {
        switch (metric) {
            case 'weight':
            case 'muscle_mass':
                return ' kg';
            case 'body_fat':
                return ' %';
            case 'waist':
                return ' cm';
            default:
                return '';
        }
    }

    function formatValue(value) {
        return value ? parseFloat(value).toFixed(1) : '-';
    }

    function formatDate(dateString) {
        return new Date(dateString).toLocaleDateString();
    }

    function showSuccess(message) {
        // Implement your success notification
        console.log('Success:', message);
    }

    function showError(message) {
        // Implement your error notification
        console.error('Error:', message);
    }

    // Initialize when document is ready
    $(document).ready(initBodyComposition);

})(jQuery); 