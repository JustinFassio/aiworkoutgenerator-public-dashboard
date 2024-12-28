import { Events } from '@dashboard/events';
import type { TrainingPersonaData } from '../types/training-persona.types';

export class TrainingPersona {
    private data: TrainingPersonaData;
    private container: HTMLElement;

    constructor(container: HTMLElement, data: TrainingPersonaData) {
        this.container = container;
        this.data = data;
        this.init();
    }

    private init(): void {
        this.render();
        this.bindEvents();
    }

    private render(): void {
        this.container.innerHTML = `
            <div class="training-persona">
                <h2>${this.data.title}</h2>
                <div class="training-persona__content">
                    ${this.renderGoals()}
                    ${this.renderProgress()}
                </div>
            </div>
        `;
    }

    private renderGoals(): string {
        return `
            <div class="training-persona__goals">
                <h3>Goals</h3>
                <ul>
                    ${this.data.goals.map(goal => `
                        <li>
                            <span class="goal-title">${goal.title}</span>
                            <span class="goal-progress">${goal.progress}%</span>
                        </li>
                    `).join('')}
                </ul>
            </div>
        `;
    }

    private renderProgress(): string {
        return `
            <div class="training-persona__progress">
                <h3>Progress</h3>
                <div class="progress-chart">
                    ${this.data.progress.map(item => `
                        <div class="progress-item">
                            <span class="progress-label">${item.label}</span>
                            <div class="progress-bar" style="width: ${item.value}%"></div>
                        </div>
                    `).join('')}
                </div>
            </div>
        `;
    }

    private bindEvents(): void {
        Events.on<{ goalId: string; progress: number }>('training-persona:goal:update', (data) => {
            this.updateGoal(data.goalId, data.progress);
        });

        Events.on<{ label: string; value: number }>('training-persona:progress:update', (data) => {
            this.updateProgress(data.label, data.value);
        });
    }

    private updateGoal(goalId: string, progress: number): void {
        const goal = this.data.goals.find(g => g.id === goalId);
        if (goal) {
            goal.progress = progress;
            this.render();
            Events.emit('training-persona:goal:updated', { goalId, progress });
        }
    }

    private updateProgress(label: string, value: number): void {
        const progressItem = this.data.progress.find(p => p.label === label);
        if (progressItem) {
            progressItem.value = value;
            this.render();
            Events.emit('training-persona:progress:updated', { label, value });
        }
    }
} 