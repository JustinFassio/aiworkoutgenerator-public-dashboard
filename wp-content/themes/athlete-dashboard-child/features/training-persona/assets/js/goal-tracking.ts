import { Events } from '@dashboard/events';

interface Goal {
    id: string;
    title: string;
    target: number;
    current: number;
    unit: string;
}

export class GoalTracker {
    private goals: Goal[];
    private container: HTMLElement;

    constructor(container: HTMLElement, goals: Goal[]) {
        this.container = container;
        this.goals = goals;
        this.init();
    }

    private init(): void {
        this.render();
        this.bindEvents();
    }

    private render(): void {
        this.container.innerHTML = `
            <div class="goal-tracker">
                ${this.goals.map(goal => this.renderGoal(goal)).join('')}
            </div>
        `;
    }

    private renderGoal(goal: Goal): string {
        const progress = Math.min(100, (goal.current / goal.target) * 100);
        return `
            <div class="goal-item" data-goal-id="${goal.id}">
                <div class="goal-header">
                    <h3>${goal.title}</h3>
                    <span class="goal-progress">${Math.round(progress)}%</span>
                </div>
                <div class="goal-progress-bar">
                    <div class="progress-fill" style="width: ${progress}%"></div>
                </div>
                <div class="goal-details">
                    <span class="current">${goal.current}</span>
                    <span class="separator">/</span>
                    <span class="target">${goal.target}</span>
                    <span class="unit">${goal.unit}</span>
                </div>
            </div>
        `;
    }

    private bindEvents(): void {
        Events.on('goal:update', (data: { goalId: string; current: number }) => {
            this.updateGoal(data.goalId, data.current);
        });
    }

    private updateGoal(goalId: string, current: number): void {
        const goal = this.goals.find(g => g.id === goalId);
        if (goal) {
            goal.current = current;
            this.render();
            Events.emit('goal:updated', { goalId, current });
        }
    }
} 