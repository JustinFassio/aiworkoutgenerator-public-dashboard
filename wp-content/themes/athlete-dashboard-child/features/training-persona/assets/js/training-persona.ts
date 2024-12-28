import { TrainingPersonaData } from './types/training-persona.types';
import { Events as DashboardEvents } from '@dashboard/js/events';
import { TrainingPersonaFormHandler } from './form-handler';

interface Tag {
    value: string;
    type: 'predefined' | 'custom';
    label?: string;
}

class TagInput {
    private container: HTMLElement;
    private wrapper: HTMLElement;
    private tagList: HTMLElement;
    private input: HTMLInputElement;
    private suggestions: HTMLElement;
    private hiddenInput: HTMLInputElement;
    private allSuggestions: HTMLElement[];
    private tags: Tag[];

    constructor(container: HTMLElement) {
        this.container = container;
        this.wrapper = container.querySelector('.tag-input-wrapper') as HTMLElement;
        this.tagList = container.querySelector('.tag-list') as HTMLElement;
        this.input = container.querySelector('.tag-input') as HTMLInputElement;
        this.suggestions = container.querySelector('.tag-suggestions') as HTMLElement;
        this.hiddenInput = container.querySelector('input[type="hidden"]') as HTMLInputElement;
        this.allSuggestions = Array.from(this.suggestions.querySelectorAll('.tag-suggestion')) as HTMLElement[];
        
        this.tags = [];
        this.initializeTags();
        this.setupEventListeners();
    }

    private initializeTags(): void {
        try {
            const savedTags = JSON.parse(this.hiddenInput.value || '[]');
            if (Array.isArray(savedTags)) {
                savedTags.forEach((tag: Tag) => this.addTag(tag.value, tag.type, tag.label));
            }
        } catch (e) {
            console.error('Error parsing saved tags:', e);
        }
    }

    private setupEventListeners(): void {
        // Focus input when clicking wrapper
        this.wrapper.addEventListener('click', () => this.input.focus());

        // Handle input focus and typing
        this.input.addEventListener('focus', () => {
            this.showSuggestions();
            this.wrapper.classList.add('focused');
        });

        this.input.addEventListener('input', () => {
            this.filterSuggestions(this.input.value.trim().toLowerCase());
        });

        // Handle input blur
        document.addEventListener('click', (e: MouseEvent) => {
            const target = e.target as HTMLElement;
            if (!this.container.contains(target)) {
                this.hideSuggestions();
                this.wrapper.classList.remove('focused');
            }
        });

        // Handle tag suggestion clicks
        this.suggestions.addEventListener('click', (e: MouseEvent) => {
            const target = e.target as HTMLElement;
            const suggestion = target.closest('.tag-suggestion') as HTMLElement;
            if (suggestion) {
                const value = suggestion.dataset.value || '';
                const type = suggestion.dataset.type as 'predefined' | 'custom';
                const label = suggestion.textContent?.trim();
                this.addTag(value, type, label);
                this.input.value = '';
                this.input.focus();
                this.filterSuggestions('');
            }
        });

        // Handle input for custom tags
        this.input.addEventListener('keydown', (e: KeyboardEvent) => {
            if (e.key === 'Enter' || e.key === ',') {
                e.preventDefault();
                const value = this.input.value.trim();
                if (value) {
                    this.addTag(value, 'custom', value);
                    this.input.value = '';
                    this.filterSuggestions('');
                }
            } else if (e.key === 'Backspace' && !this.input.value) {
                const lastTag = this.tagList.lastElementChild as HTMLElement;
                if (lastTag) {
                    this.removeTag(lastTag);
                }
            }
        });
    }

    private showSuggestions(): void {
        this.suggestions.style.display = 'block';
        this.filterSuggestions(this.input.value.trim().toLowerCase());
    }

    private hideSuggestions(): void {
        this.suggestions.style.display = 'none';
    }

    private filterSuggestions(query: string): void {
        let hasVisibleSuggestions = false;
        
        this.allSuggestions.forEach(suggestion => {
            const text = suggestion.textContent?.trim().toLowerCase() || '';
            const value = suggestion.dataset.value?.toLowerCase() || '';
            const isAlreadySelected = this.tags.some(tag => 
                tag.type === 'predefined' && tag.value === suggestion.dataset.value
            );
            
            if (!isAlreadySelected && (text.includes(query) || value.includes(query))) {
                suggestion.style.display = 'block';
                hasVisibleSuggestions = true;
            } else {
                suggestion.style.display = 'none';
            }
        });

        this.suggestions.style.display = hasVisibleSuggestions ? 'block' : 'none';
    }

    private addTag(value: string, type: 'predefined' | 'custom', label: string | null = null): void {
        // Check if tag already exists
        if (this.tags.some(tag => tag.value === value && tag.type === type)) {
            return;
        }

        const tag = document.createElement('div');
        tag.className = `tag-item ${type}`;
        tag.dataset.value = value;
        tag.dataset.type = type;

        if (type === 'predefined') {
            const suggestions = this.container.querySelectorAll('.tag-suggestion');
            for (const suggestion of suggestions) {
                if (suggestion instanceof HTMLElement && suggestion.dataset.value === value) {
                    label = suggestion.textContent?.trim() || value;
                    break;
                }
            }
        }

        tag.innerHTML = `
            <span class="tag-text">${label || value}</span>
            <span class="remove-tag">×</span>
        `;

        tag.querySelector('.remove-tag')?.addEventListener('click', () => {
            this.removeTag(tag);
        });

        this.tagList.appendChild(tag);
        this.tags.push({ value, type, label: label || value });
        this.updateHiddenInput();
    }

    private removeTag(tagElement: HTMLElement): void {
        const value = tagElement.dataset.value;
        const type = tagElement.dataset.type as 'predefined' | 'custom';
        this.tags = this.tags.filter(tag => !(tag.value === value && tag.type === type));
        tagElement.remove();
        this.updateHiddenInput();
    }

    private updateHiddenInput(): void {
        this.hiddenInput.value = JSON.stringify(this.tags);
    }
}

function setupHeightUnitHandler(element: HTMLElement): void {
    element.addEventListener('change', (e) => {
        const target = e.target as HTMLSelectElement;
        const heightField = document.getElementById('height') as HTMLInputElement;
        const currentValue = parseFloat(heightField.value);
        const newUnit = target.value;
        
        if (!currentValue) {
            // If no value, just switch the input type
            if (newUnit === 'imperial') {
                switchToImperialHeight(heightField);
            } else {
                switchToMetricHeight(heightField);
            }
            return;
        }

        if (newUnit === 'metric') {
            // Convert from inches to cm
            const cm = Math.round(currentValue * 2.54);
            switchToMetricHeight(heightField, cm);
        } else {
            // Convert from cm to inches
            const inches = Math.round(currentValue / 2.54);
            switchToImperialHeight(heightField, inches);
        }
    });
}

function switchToMetricHeight(heightField: HTMLElement, value: number | string = ''): void {
    const input = document.createElement('input');
    input.type = 'number';
    input.name = 'height';
    input.id = 'height';
    input.className = 'measurement-value';
    input.min = '100';
    input.max = '250';
    input.required = heightField instanceof HTMLInputElement ? heightField.required : false;
    input.value = value.toString();

    heightField.replaceWith(input);
}

function switchToImperialHeight(heightField: HTMLElement, totalInches: number | string = ''): void {
    const select = document.createElement('select');
    select.name = 'height';
    select.id = 'height';
    select.className = 'measurement-value';
    select.required = heightField instanceof HTMLInputElement ? heightField.required : false;

    // Add default option
    const defaultOption = document.createElement('option');
    defaultOption.value = '';
    defaultOption.text = 'Select height';
    select.appendChild(defaultOption);

    // Add height options from 4'0" to 7'0"
    for (let feet = 4; feet <= 7; feet++) {
        for (let inches = 0; inches <= 11; inches++) {
            const value = (feet * 12) + inches;
            const label = `${feet}'${inches}"`;
            const option = document.createElement('option');
            option.value = value.toString();
            option.text = label;
            
            if (value === Number(totalInches)) {
                option.selected = true;
            }
            
            select.appendChild(option);
        }
    }

    heightField.replaceWith(select);
}

function setupWeightUnitHandler(element: HTMLElement): void {
    element.addEventListener('change', (e) => {
        const target = e.target as HTMLSelectElement;
        const weightField = document.getElementById('weight') as HTMLInputElement;
        const currentValue = parseFloat(weightField.value);
        const newUnit = target.value;
        
        if (!currentValue) return;

        if (newUnit === 'metric') {
            // Convert from lbs to kg
            const kg = Math.round(currentValue * 0.453592 * 10) / 10;
            weightField.value = kg.toString();
        } else {
            // Convert from kg to lbs
            const lbs = Math.round(currentValue * 2.20462 * 10) / 10;
            weightField.value = lbs.toString();
        }
    });
}

function initializeComponents(): void {
    // Initialize tag inputs
    const tagContainers = document.querySelectorAll('.tag-input-container');
    tagContainers.forEach(container => {
        if (container instanceof HTMLElement) {
            new TagInput(container);
        }
    });

    // Initialize unit handlers
    const heightUnit = document.getElementById('height_unit');
    const weightUnit = document.getElementById('weight_unit');

    if (heightUnit) setupHeightUnitHandler(heightUnit);
    if (weightUnit) setupWeightUnitHandler(weightUnit);
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    // Initialize form handler
    const form = document.getElementById('training-persona-form');
    if (form) {
        new TrainingPersonaFormHandler('training-persona-form', {
            endpoint: window.trainingPersonaConfig.ajaxurl,
            additionalData: {
                action: 'update_training_persona',
                training_persona_nonce: window.trainingPersonaConfig.nonce
            }
        });
    }

    // Initialize components
    initializeComponents();

    // Emit ready event
    DashboardEvents.emit('training-persona:ready');
}); 