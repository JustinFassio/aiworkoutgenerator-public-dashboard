/**
 * AthleteGoals Module
 * Handles all goals-related functionality for the athlete dashboard
 */
const AthleteGoals = (function($) {
    'use strict';

    // Private variables
    let config = {
        selectors: {
            goalsContainer: '.athlete-goals',
            goalsList: '.goals-list',
            addGoalForm: '#add-goal-form',
            editGoalForm: '#edit-goal-form',
            goalModal: '#goal-modal',
            goalProgress: '.goal-progress'
        },
        updateInterval: 300000 // 5 minutes
    };

    /**
     * Initialize goals form
     */
    function initializeGoalsForm() {
        $(config.selectors.addGoalForm).on('submit', function(e) {
            e.preventDefault();
            submitGoal($(this));
        });

        $(config.selectors.editGoalForm).on('submit', function(e) {
            e.preventDefault();
            updateGoal($(this));
        });
    }

    /**
     * Submit new goal
     */
    function submitGoal($form) {
        const formData = $form.serialize();
        $.ajax({
            url: window.athleteDashboard.ajax_url,
            type: 'POST',
            data: formData + '&action=athlete_dashboard_add_goal&nonce=' + window.athleteDashboard.nonce,
            success: function(response) {
                if (response.success) {
                    $form[0].reset();
                    refreshGoalsList();
                    showNotification('Goal added successfully!', 'success');
                } else {
                    console.error('Error adding goal:', response.data.message);
                    showNotification('Error: ' + response.data.message, 'error');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error adding goal:', error);
                showNotification('An error occurred while adding the goal. Please try again.', 'error');
            }
        });
    }

    /**
     * Update existing goal
     */
    function updateGoal($form) {
        const formData = $form.serialize();
        $.ajax({
            url: window.athleteDashboard.ajax_url,
            type: 'POST',
            data: formData + '&action=athlete_dashboard_update_goal&nonce=' + window.athleteDashboard.nonce,
            success: function(response) {
                if (response.success) {
                    $(config.selectors.goalModal).modal('hide');
                    refreshGoalsList();
                    showNotification('Goal updated successfully!', 'success');
                } else {
                    console.error('Error updating goal:', response.data.message);
                    showNotification('Error: ' + response.data.message, 'error');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error updating goal:', error);
                showNotification('An error occurred while updating the goal. Please try again.', 'error');
            }
        });
    }

    /**
     * Delete goal
     */
    function deleteGoal(goalId) {
        if (!confirm('Are you sure you want to delete this goal?')) {
            return;
        }

        $.ajax({
            url: window.athleteDashboard.ajax_url,
            type: 'POST',
            data: {
                action: 'athlete_dashboard_delete_goal',
                goal_id: goalId,
                nonce: window.athleteDashboard.nonce
            },
            success: function(response) {
                if (response.success) {
                    refreshGoalsList();
                    showNotification('Goal deleted successfully!', 'success');
                } else {
                    console.error('Error deleting goal:', response.data.message);
                    showNotification('Error: ' + response.data.message, 'error');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error deleting goal:', error);
                showNotification('An error occurred while deleting the goal. Please try again.', 'error');
            }
        });
    }

    /**
     * Refresh goals list
     */
    function refreshGoalsList() {
        $.ajax({
            url: window.athleteDashboard.ajax_url,
            type: 'POST',
            data: {
                action: 'athlete_dashboard_get_goals',
                nonce: window.athleteDashboard.nonce
            },
            success: function(response) {
                if (response.success) {
                    $(config.selectors.goalsList).html(response.data.html);
                    updateGoalsProgress();
                } else {
                    console.error('Error refreshing goals:', response.data.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error refreshing goals:', error);
            }
        });
    }

    /**
     * Update goals progress
     */
    function updateGoalsProgress() {
        $.ajax({
            url: window.athleteDashboard.ajax_url,
            type: 'POST',
            data: {
                action: 'athlete_dashboard_get_goals_progress',
                nonce: window.athleteDashboard.nonce
            },
            success: function(response) {
                if (response.success) {
                    response.data.goals.forEach(function(goal) {
                        const $progress = $(config.selectors.goalProgress + '[data-goal-id="' + goal.id + '"]');
                        $progress.find('.progress-bar').css('width', goal.progress + '%');
                        $progress.find('.progress-text').text(goal.progress + '%');
                    });
                } else {
                    console.error('Error updating goals progress:', response.data.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error updating goals progress:', error);
            }
        });
    }

    /**
     * Show notification message
     */
    function showNotification(message, type) {
        if (typeof window.AthleteUI !== 'undefined' && window.AthleteUI.showNotification) {
            window.AthleteUI.showNotification(message, type);
        } else {
            alert(message);
        }
    }

    /**
     * Start periodic updates
     */
    function startPeriodicUpdates() {
        setInterval(function() {
            updateGoalsProgress();
        }, config.updateInterval);
    }

    /**
     * Initialize event listeners
     */
    function initializeEventListeners() {
        // Delete goal
        $(document).on('click', '.delete-goal', function(e) {
            e.preventDefault();
            const goalId = $(this).data('goal-id');
            deleteGoal(goalId);
        });

        // Edit goal modal
        $(document).on('click', '.edit-goal', function(e) {
            e.preventDefault();
            const goalId = $(this).data('goal-id');
            const $modal = $(config.selectors.goalModal);
            
            // Load goal data into modal
            $.ajax({
                url: window.athleteDashboard.ajax_url,
                type: 'POST',
                data: {
                    action: 'athlete_dashboard_get_goal',
                    goal_id: goalId,
                    nonce: window.athleteDashboard.nonce
                },
                success: function(response) {
                    if (response.success) {
                        // Populate form fields
                        const goal = response.data.goal;
                        const $form = $modal.find('form');
                        $form.find('[name="goal_id"]').val(goal.id);
                        $form.find('[name="title"]').val(goal.title);
                        $form.find('[name="description"]').val(goal.description);
                        $form.find('[name="target_value"]').val(goal.target_value);
                        $form.find('[name="target_date"]').val(goal.target_date);
                        $form.find('[name="category"]').val(goal.category);
                        
                        $modal.modal('show');
                    } else {
                        console.error('Error loading goal:', response.data.message);
                        showNotification('Error: ' + response.data.message, 'error');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error loading goal:', error);
                    showNotification('An error occurred while loading the goal. Please try again.', 'error');
                }
            });
        });
    }

    /**
     * Initialize all goals components
     */
    function initialize() {
        if ($(config.selectors.goalsContainer).length) {
            initializeGoalsForm();
            initializeEventListeners();
            refreshGoalsList();
            startPeriodicUpdates();
        }
    }

    // Public API
    return {
        initialize,
        refreshGoalsList,
        updateGoalsProgress
    };

})(jQuery);

// Initialize when document is ready
jQuery(document).ready(function() {
    AthleteGoals.initialize();
}); 