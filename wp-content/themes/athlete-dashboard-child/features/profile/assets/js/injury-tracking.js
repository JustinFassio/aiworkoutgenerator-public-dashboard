/**
 * Injury Tracking JavaScript
 * 
 * Handles injury tracking functionality including form submission and tag input.
 */

(function($) {
    'use strict';

    class InjuryTracking {
        constructor() {
            this.form = $('.injury-tracking-form');
            this.tagInput = this.form.find('.tag-input');
            this.tagList = this.form.find('.tag-list');
            this.tagSuggestions = this.form.find('.tag-suggestions');
            this.submitButton = this.form.find('.submit-button');
            this.messages = this.form.find('.form-messages');

            this.commonInjuries = [
                'Ankle Sprain', 'Knee Pain', 'Lower Back Pain', 'Shoulder Strain',
                'Hamstring Pull', 'Tennis Elbow', 'Shin Splints', 'Plantar Fasciitis',
                'Hip Flexor Strain', 'Rotator Cuff Injury'
            ];

            this.init();
        }

        init() {
            this.initTagInput();
            this.initFormSubmission();
            this.initDeleteButtons();
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
                    const suggestions = this.commonInjuries.filter(injury => 
                        injury.toLowerCase().includes(value)
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
            this.updateInjuryDescription();
        }

        updateInjuryDescription() {
            const tags = [];
            this.tagList.find('.tag').each((i, tag) => {
                tags.push({
                    label: $(tag).text().replace('×', '').trim(),
                    type: this.form.find('#injury_type').val(),
                    description: this.form.find('#injury_details').val()
                });
            });
            this.form.find('input[name="injuries"]').val(JSON.stringify(tags));
        }

        initFormSubmission() {
            this.form.on('submit', (e) => {
                e.preventDefault();
                const injuryType = this.form.find('#injury_type').val();
                const injuryDetails = this.form.find('#injury_details').val();
                const tags = [];

                if (!injuryType) {
                    this.showMessage('Please select an injury type', 'error');
                    return;
                }

                this.tagList.find('.tag').each((i, tag) => {
                    tags.push({
                        label: $(tag).text().replace('×', '').trim(),
                        type: injuryType,
                        description: injuryDetails
                    });
                });

                if (!tags.length) {
                    this.showMessage('Please add at least one injury description', 'error');
                    return;
                }

                this.submitButton.prop('disabled', true)
                    .find('.button-text').hide()
                    .siblings('.button-loader').show();

                $.ajax({
                    url: injuryData.ajaxurl,
                    method: 'POST',
                    data: {
                        action: 'track_injury',
                        nonce: injuryData.nonce,
                        injury_data: JSON.stringify(tags[0])
                    },
                    success: (response) => {
                        if (response.success) {
                            this.showMessage('Injury tracked successfully', 'success');
                            this.form[0].reset();
                            this.tagList.empty();
                            location.reload();
                        } else {
                            this.showMessage(response.data.message || 'Failed to track injury', 'error');
                        }
                    },
                    error: () => {
                        this.showMessage('An error occurred while tracking injury', 'error');
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
            this.form.on('click', '.delete-injury', (e) => {
                const injuryItem = $(e.target).closest('.injury-item');
                const injuryId = injuryItem.data('id');

                if (confirm('Are you sure you want to delete this injury?')) {
                    $.ajax({
                        url: injuryData.ajaxurl,
                        method: 'POST',
                        data: {
                            action: 'delete_injury_progress',
                            nonce: injuryData.nonce,
                            injury_id: injuryId
                        },
                        success: (response) => {
                            if (response.success) {
                                injuryItem.fadeOut(() => injuryItem.remove());
                                this.showMessage('Injury deleted successfully', 'success');
                            } else {
                                this.showMessage(response.data.message || 'Failed to delete injury', 'error');
                            }
                        },
                        error: () => {
                            this.showMessage('An error occurred while deleting injury', 'error');
                        }
                    });
                }
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
        new InjuryTracking();
    });

})(jQuery); 