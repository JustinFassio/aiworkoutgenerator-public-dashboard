/**
 * Goal Tracking JavaScript
 * 
 * Handles goal tracking functionality including form submission and tag input.
 */

(function($) {
    'use strict';

    class GoalTracking {
        constructor() {
            this.form = $('.goal-tracking-form');
            this.tagInput = this.form.find('.tag-input');
            this.tagList = this.form.find('.tag-list');
            this.tagSuggestions = this.form.find('.tag-suggestions');
            this.submitButton = this.form.find('.submit-button');
            this.messages = this.form.find('.form-messages');
            this.progressBars = this.form.find('.goal-progress');

            this.commonGoals = [
                'Increase Strength', 'Improve Endurance', 'Build Muscle',
                'Lose Weight', 'Enhance Flexibility', 'Better Balance',
                'Speed Development', 'Athletic Performance', 'General Fitness'
            ];

            this.init();
        }

        init() {
            this.initTagInput();
            this.initFormSubmission();
            this.initDeleteButtons();
            this.initProgressTracking();
        }

        initTagInput() {
            this.tagInput.on('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ',') {
                    e.preventDefault();
                    const value = this.tagInput.val().trim();
                    if (value) {
                        this.addTag(value);
                        this.tagInput.val('');
                        this.tagSuggestions.empty().hide();
                    }
                }
            });

            this.tagInput.on('input', (e) => {
                const value = e.target.value.trim().toLowerCase();
                if (value.length >= 2) {
                    const suggestions = this.commonGoals.filter(goal => 
                        goal.toLowerCase().includes(value)
                    );
                    this.showSuggestions(suggestions);
                } else {
                    this.tagSuggestions.empty().hide();
                }
            });

            this.tagSuggestions.on('click', 'div', (e) => {
                const value = $(e.target).text();
                this.addTag(value);
                this.tagInput.val('');
                this.tagSuggestions.empty().hide();
            });
        }

        showSuggestions(suggestions) {
            this.tagSuggestions.empty();
            if (suggestions.length) {
                suggestions.forEach(suggestion => {
                    this.tagSuggestions.append($('<div>').text(suggestion));
                });
                this.tagSuggestions.show();
            } else {
                this.tagSuggestions.hide();
            }
        }

        addTag(value) {
            const tag = $('<span>')
                .addClass('tag')
                .text(value)
                .append(
                    $('<button>')
                        .addClass('remove-tag')
                        .html('&times;')
                        .on('click', () => tag.remove())
                );
            this.tagList.append(tag);
            this.updateGoalDescription();
        }

        updateGoalDescription() {
            const tags = [];
            this.tagList.find('.tag').each((i, tag) => {
                tags.push({
                    label: $(tag).text().replace('×', '').trim(),
                    type: this.form.find('#goal_type').val(),
                    description: this.form.find('#goal_details').val()
                });
            });
            this.form.find('input[name="goals"]').val(JSON.stringify(tags));
        }

        initFormSubmission() {
            this.form.on('submit', (e) => {
                e.preventDefault();
                const goalType = this.form.find('#goal_type').val();
                const goalDetails = this.form.find('#goal_details').val();
                const tags = [];

                if (!goalType) {
                    this.showMessage('Please select a goal type', 'error');
                    return;
                }

                this.tagList.find('.tag').each((i, tag) => {
                    tags.push({
                        label: $(tag).text().replace('×', '').trim(),
                        type: goalType,
                        description: goalDetails
                    });
                });

                if (!tags.length) {
                    this.showMessage('Please add at least one goal', 'error');
                    return;
                }

                this.submitButton.prop('disabled', true)
                    .find('.button-text').hide()
                    .siblings('.button-loader').show();

                $.ajax({
                    url: goalData.ajaxurl,
                    method: 'POST',
                    data: {
                        action: 'track_goal',
                        nonce: goalData.nonce,
                        goal_data: JSON.stringify(tags[0])
                    },
                    success: (response) => {
                        if (response.success) {
                            this.showMessage('Goal tracked successfully', 'success');
                            this.form[0].reset();
                            this.tagList.empty();
                            location.reload();
                        } else {
                            this.showMessage(response.data.message || 'Failed to track goal', 'error');
                        }
                    },
                    error: () => {
                        this.showMessage('An error occurred while tracking goal', 'error');
                    },
                    complete: () => {
                        this.submitButton.prop('disabled', false)
                            .find('.button-text').show()
                            .siblings('.button-loader').hide();
                    }
                });
            });
        }

        initDeleteButtons() {
            this.form.on('click', '.delete-goal', (e) => {
                const goalItem = $(e.target).closest('.goal-item');
                const goalId = goalItem.data('id');

                if (confirm('Are you sure you want to delete this goal?')) {
                    $.ajax({
                        url: goalData.ajaxurl,
                        method: 'POST',
                        data: {
                            action: 'delete_goal_progress',
                            nonce: goalData.nonce,
                            goal_id: goalId
                        },
                        success: (response) => {
                            if (response.success) {
                                goalItem.fadeOut(() => goalItem.remove());
                                this.showMessage('Goal deleted successfully', 'success');
                            } else {
                                this.showMessage(response.data.message || 'Failed to delete goal', 'error');
                            }
                        },
                        error: () => {
                            this.showMessage('An error occurred while deleting goal', 'error');
                        }
                    });
                }
            });
        }

        initProgressTracking() {
            this.form.on('change', '.goal-progress-input', (e) => {
                const input = $(e.target);
                const goalItem = input.closest('.goal-item');
                const goalId = goalItem.data('id');
                const progress = parseFloat(input.val());

                if (isNaN(progress) || progress < 0 || progress > 100) {
                    this.showMessage('Progress must be between 0 and 100', 'error');
                    return;
                }

                $.ajax({
                    url: goalData.ajaxurl,
                    method: 'POST',
                    data: {
                        action: 'track_goal_progress',
                        nonce: goalData.nonce,
                        goal_id: goalId,
                        progress: progress
                    },
                    success: (response) => {
                        if (response.success) {
                            goalItem.find('.progress-bar').css('width', progress + '%');
                            goalItem.find('.progress-text').text(progress + '%');
                            this.showMessage('Progress updated successfully', 'success');
                        } else {
                            this.showMessage(response.data.message || 'Failed to update progress', 'error');
                        }
                    },
                    error: () => {
                        this.showMessage('An error occurred while updating progress', 'error');
                    }
                });
            });
        }

        showMessage(message, type) {
            this.messages
                .removeClass('error success')
                .addClass(type)
                .html(message)
                .show()
                .delay(3000)
                .fadeOut();
        }
    }

    // Initialize when document is ready
    $(document).ready(() => {
        new GoalTracking();
    });

})(jQuery); 