import { GoalTrackingData } from './types/training-persona.types';
import { Events as DashboardEvents } from '@dashboard/js/events';

interface Goal {
    label: string;
    type: string;
    description: string;
}

interface GoalData {
    ajaxurl: string;
    nonce: string;
}

declare global {
    interface Window {
        goalData: GoalData;
    }
}

class GoalTracking {
    private form: HTMLFormElement;
    private tagInput: HTMLInputElement;
    private tagList: HTMLElement;
    private tagSuggestions: HTMLElement;
    private submitButton: HTMLButtonElement;
    private messages: HTMLElement;
    private progressBars: NodeListOf<HTMLElement>;
    private readonly commonGoals: string[];

    constructor() {
        const form = document.querySelector('.goal-tracking-form');
        if (!(form instanceof HTMLFormElement)) {
            throw new Error('Goal tracking form not found');
        }
        this.form = form;
        
        const tagInput = form.querySelector('.tag-input');
        if (!(tagInput instanceof HTMLInputElement)) {
            throw new Error('Tag input not found');
        }
        this.tagInput = tagInput;

        const tagList = form.querySelector('.tag-list');
        if (!(tagList instanceof HTMLElement)) {
            throw new Error('Tag list not found');
        }
        this.tagList = tagList;

        const tagSuggestions = form.querySelector('.tag-suggestions');
        if (!(tagSuggestions instanceof HTMLElement)) {
            throw new Error('Tag suggestions not found');
        }
        this.tagSuggestions = tagSuggestions;

        const submitButton = form.querySelector('.submit-button');
        if (!(submitButton instanceof HTMLButtonElement)) {
            throw new Error('Submit button not found');
        }
        this.submitButton = submitButton;

        const messages = form.querySelector('.form-messages');
        if (!(messages instanceof HTMLElement)) {
            throw new Error('Messages container not found');
        }
        this.messages = messages;

        this.progressBars = form.querySelectorAll('.goal-progress');

        this.commonGoals = [
            'Increase Strength', 'Improve Endurance', 'Build Muscle',
            'Lose Weight', 'Enhance Flexibility', 'Better Balance',
            'Speed Development', 'Athletic Performance', 'General Fitness'
        ];

        this.init();
    }

    private init(): void {
        this.initTagInput();
        this.initFormSubmission();
        this.initDeleteButtons();
        this.initProgressTracking();
    }

    private initTagInput(): void {
        this.tagInput.addEventListener('keydown', (e: KeyboardEvent) => {
            if (e.key === 'Enter' || e.key === ',') {
                e.preventDefault();
                const value = this.tagInput.value.trim();
                if (value) {
                    this.addTag(value);
                    this.tagInput.value = '';
                    this.tagSuggestions.innerHTML = '';
                    this.tagSuggestions.style.display = 'none';
                }
            }
        });

        this.tagInput.addEventListener('input', (e: Event) => {
            const target = e.target as HTMLInputElement;
            const value = target.value.trim().toLowerCase();
            if (value.length >= 2) {
                const suggestions = this.commonGoals.filter(goal => 
                    goal.toLowerCase().includes(value)
                );
                this.showSuggestions(suggestions);
            } else {
                this.tagSuggestions.innerHTML = '';
                this.tagSuggestions.style.display = 'none';
            }
        });

        this.tagSuggestions.addEventListener('click', (e: MouseEvent) => {
            const target = e.target as HTMLElement;
            if (target.matches('div')) {
                const value = target.textContent || '';
                this.addTag(value);
                this.tagInput.value = '';
                this.tagSuggestions.innerHTML = '';
                this.tagSuggestions.style.display = 'none';
            }
        });
    }

    private showSuggestions(suggestions: string[]): void {
        this.tagSuggestions.innerHTML = '';
        if (suggestions.length) {
            suggestions.forEach(suggestion => {
                const div = document.createElement('div');
                div.textContent = suggestion;
                this.tagSuggestions.appendChild(div);
            });
            this.tagSuggestions.style.display = 'block';
        } else {
            this.tagSuggestions.style.display = 'none';
        }
    }

    private addTag(value: string): void {
        const tag = document.createElement('span');
        tag.className = 'tag';
        tag.textContent = value;

        const removeButton = document.createElement('button');
        removeButton.className = 'remove-tag';
        removeButton.innerHTML = '&times;';
        removeButton.addEventListener('click', () => tag.remove());

        tag.appendChild(removeButton);
        this.tagList.appendChild(tag);
        this.updateGoalDescription();
    }

    private updateGoalDescription(): void {
        const tags: Goal[] = [];
        const goalType = (this.form.querySelector('#goal_type') as HTMLSelectElement)?.value;
        const goalDetails = (this.form.querySelector('#goal_details') as HTMLTextAreaElement)?.value;

        this.tagList.querySelectorAll('.tag').forEach(tag => {
            tags.push({
                label: tag.textContent?.replace('×', '').trim() || '',
                type: goalType,
                description: goalDetails
            });
        });

        const goalsInput = this.form.querySelector('input[name="goals"]') as HTMLInputElement;
        if (goalsInput) {
            goalsInput.value = JSON.stringify(tags);
        }
    }

    private async initFormSubmission(): Promise<void> {
        this.form.addEventListener('submit', async (e: Event) => {
            e.preventDefault();
            const goalType = (this.form.querySelector('#goal_type') as HTMLSelectElement)?.value;
            const goalDetails = (this.form.querySelector('#goal_details') as HTMLTextAreaElement)?.value;
            const tags: Goal[] = [];

            if (!goalType) {
                this.showMessage('Please select a goal type', 'error');
                return;
            }

            this.tagList.querySelectorAll('.tag').forEach(tag => {
                tags.push({
                    label: tag.textContent?.replace('×', '').trim() || '',
                    type: goalType,
                    description: goalDetails
                });
            });

            if (!tags.length) {
                this.showMessage('Please add at least one goal', 'error');
                return;
            }

            this.submitButton.disabled = true;
            const buttonText = this.submitButton.querySelector('.button-text');
            const buttonLoader = this.submitButton.querySelector('.button-loader');
            if (buttonText instanceof HTMLElement && buttonLoader instanceof HTMLElement) {
                buttonText.style.display = 'none';
                buttonLoader.style.display = 'block';
            }

            try {
                const response = await fetch(window.goalData.ajaxurl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams({
                        action: 'track_goal',
                        nonce: window.goalData.nonce,
                        goal_data: JSON.stringify(tags[0])
                    })
                });

                const data = await response.json();

                if (data.success) {
                    this.showMessage('Goal tracked successfully', 'success');
                    this.form.reset();
                    this.tagList.innerHTML = '';
                    location.reload();
                } else {
                    this.showMessage(data.data?.message || 'Failed to track goal', 'error');
                }
            } catch (error) {
                this.showMessage('An error occurred while tracking goal', 'error');
                console.error('Goal tracking error:', error);
            } finally {
                this.submitButton.disabled = false;
                const buttonText = this.submitButton.querySelector('.button-text');
                const buttonLoader = this.submitButton.querySelector('.button-loader');
                if (buttonText instanceof HTMLElement && buttonLoader instanceof HTMLElement) {
                    buttonText.style.display = 'block';
                    buttonLoader.style.display = 'none';
                }
            }
        });
    }

    private initDeleteButtons(): void {
        this.form.addEventListener('click', async (e: Event) => {
            const target = e.target as HTMLElement;
            if (target.matches('.delete-goal')) {
                const goalItem = target.closest('.goal-item');
                if (!(goalItem instanceof HTMLElement)) return;

                const goalId = goalItem.dataset.id;
                if (!goalId) return;

                if (confirm('Are you sure you want to delete this goal?')) {
                    try {
                        const response = await fetch(window.goalData.ajaxurl, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: new URLSearchParams({
                                action: 'delete_goal_progress',
                                nonce: window.goalData.nonce,
                                goal_id: goalId
                            })
                        });

                        const data = await response.json();

                        if (data.success) {
                            goalItem.style.opacity = '0';
                            setTimeout(() => goalItem.remove(), 300);
                            this.showMessage('Goal deleted successfully', 'success');
                        } else {
                            this.showMessage(data.data?.message || 'Failed to delete goal', 'error');
                        }
                    } catch (error) {
                        this.showMessage('An error occurred while deleting goal', 'error');
                        console.error('Goal deletion error:', error);
                    }
                }
            }
        });
    }

    private initProgressTracking(): void {
        this.form.addEventListener('change', async (e: Event) => {
            const target = e.target as HTMLInputElement;
            if (target.matches('.goal-progress-input')) {
                const goalItem = target.closest('.goal-item');
                if (!(goalItem instanceof HTMLElement)) return;

                const goalId = goalItem.dataset.id;
                if (!goalId) return;

                const progress = parseFloat(target.value);

                if (isNaN(progress) || progress < 0 || progress > 100) {
                    this.showMessage('Progress must be between 0 and 100', 'error');
                    return;
                }

                try {
                    const response = await fetch(window.goalData.ajaxurl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: new URLSearchParams({
                            action: 'track_goal_progress',
                            nonce: window.goalData.nonce,
                            goal_id: goalId,
                            progress: progress.toString()
                        })
                    });

                    const data = await response.json();

                    if (data.success) {
                        const progressBar = goalItem.querySelector('.progress-bar');
                        const progressText = goalItem.querySelector('.progress-text');
                        
                        if (progressBar instanceof HTMLElement) {
                            progressBar.style.width = `${progress}%`;
                        }
                        
                        if (progressText instanceof HTMLElement) {
                            progressText.textContent = `${progress}%`;
                        }

                        this.showMessage('Progress updated successfully', 'success');
                    } else {
                        this.showMessage(data.data?.message || 'Failed to update progress', 'error');
                    }
                } catch (error) {
                    this.showMessage('An error occurred while updating progress', 'error');
                    console.error('Progress update error:', error);
                }
            }
        });
    }

    private showMessage(message: string, type: 'success' | 'error'): void {
        this.messages.className = `form-messages ${type}`;
        this.messages.textContent = message;
        this.messages.style.display = 'block';

        setTimeout(() => {
            this.messages.style.opacity = '0';
            setTimeout(() => {
                this.messages.style.display = 'none';
                this.messages.style.opacity = '1';
            }, 300);
        }, 3000);
    }
}

// Initialize when document is ready
document.addEventListener('DOMContentLoaded', () => {
    new GoalTracking();
}); 