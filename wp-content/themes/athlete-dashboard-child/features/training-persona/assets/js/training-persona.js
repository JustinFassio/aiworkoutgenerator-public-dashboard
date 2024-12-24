jQuery(document).ready(function($) {
    // Initialize form handler
    const trainingPersonaForm = new TrainingPersonaFormHandler('training-persona-form', {
        endpoint: trainingPersona.ajaxurl,
        additionalData: {
            action: 'update_training_persona',
            training_persona_nonce: trainingPersona.nonce
        },
        customFields: {
            '#height_unit': setupHeightUnitHandler,
            '#weight_unit': setupWeightUnitHandler
        }
    });

    function setupHeightUnitHandler(element) {
        $(element).on('change', function() {
            const heightField = $('#height');
            const currentValue = parseFloat(heightField.val());
            const newUnit = $(this).val();
            
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

    function switchToMetricHeight(heightField, value = '') {
        const input = $('<input>', {
            type: 'number',
            name: 'height',
            id: 'height',
            class: 'measurement-value',
            min: '100',
            max: '250',
            required: heightField.prop('required'),
            value: value
        });

        heightField.replaceWith(input);
    }

    function switchToImperialHeight(heightField, totalInches = '') {
        const select = $('<select>', {
            name: 'height',
            id: 'height',
            class: 'measurement-value',
            required: heightField.prop('required')
        });

        // Add default option
        select.append($('<option>', {
            value: '',
            text: 'Select height'
        }));

        // Add height options from 4'0" to 7'0"
        for (let feet = 4; feet <= 7; feet++) {
            for (let inches = 0; inches <= 11; inches++) {
                const value = (feet * 12) + inches;
                const label = `${feet}'${inches}"`;
                const option = $('<option>', {
                    value: value,
                    text: label
                });
                
                if (value === totalInches) {
                    option.prop('selected', true);
                }
                
                select.append(option);
            }
        }

        heightField.replaceWith(select);
    }

    function setupWeightUnitHandler(element) {
        $(element).on('change', function() {
            const weightField = $('#weight');
            const currentValue = parseFloat(weightField.val());
            const newUnit = $(this).val();
            
            if (!currentValue) return;

            if (newUnit === 'metric') {
                // Convert from lbs to kg
                const kg = Math.round(currentValue * 0.453592 * 10) / 10;
                weightField.val(kg);
            } else {
                // Convert from kg to lbs
                const lbs = Math.round(currentValue * 2.20462 * 10) / 10;
                weightField.val(lbs);
            }
        });
    }

    class TagInput {
        constructor(container) {
            this.container = container;
            this.wrapper = container.querySelector('.tag-input-wrapper');
            this.tagList = container.querySelector('.tag-list');
            this.input = container.querySelector('.tag-input');
            this.suggestions = container.querySelector('.tag-suggestions');
            this.hiddenInput = container.querySelector('input[type="hidden"]');
            this.allSuggestions = Array.from(this.suggestions.querySelectorAll('.tag-suggestion'));
            
            this.tags = [];
            this.initializeTags();
            this.setupEventListeners();
        }

        initializeTags() {
            try {
                const savedTags = JSON.parse(this.hiddenInput.value || '[]');
                if (Array.isArray(savedTags)) {
                    savedTags.forEach(tag => this.addTag(tag.value, tag.type, tag.label));
                }
            } catch (e) {
                console.error('Error parsing saved tags:', e);
            }
        }

        setupEventListeners() {
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
            document.addEventListener('click', (e) => {
                if (!this.container.contains(e.target)) {
                    this.hideSuggestions();
                    this.wrapper.classList.remove('focused');
                }
            });

            // Handle tag suggestion clicks
            this.suggestions.addEventListener('click', (e) => {
                const suggestion = e.target.closest('.tag-suggestion');
                if (suggestion) {
                    const value = suggestion.dataset.value;
                    const type = suggestion.dataset.type;
                    const label = suggestion.textContent.trim();
                    this.addTag(value, type, label);
                    this.input.value = '';
                    this.input.focus();
                    this.filterSuggestions('');
                }
            });

            // Handle input for custom tags
            this.input.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ',') {
                    e.preventDefault();
                    const value = this.input.value.trim();
                    if (value) {
                        this.addTag(value, 'custom', value);
                        this.input.value = '';
                        this.filterSuggestions('');
                    }
                } else if (e.key === 'Backspace' && !this.input.value) {
                    const lastTag = this.tagList.lastElementChild;
                    if (lastTag) {
                        this.removeTag(lastTag);
                    }
                }
            });
        }

        showSuggestions() {
            this.suggestions.style.display = 'block';
            this.filterSuggestions(this.input.value.trim().toLowerCase());
        }

        hideSuggestions() {
            this.suggestions.style.display = 'none';
        }

        filterSuggestions(query) {
            let hasVisibleSuggestions = false;
            
            this.allSuggestions.forEach(suggestion => {
                const text = suggestion.textContent.trim().toLowerCase();
                const value = suggestion.dataset.value.toLowerCase();
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

        addTag(value, type, label = null) {
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
                    if (suggestion.dataset.value === value) {
                        label = suggestion.textContent.trim();
                        break;
                    }
                }
            }

            tag.innerHTML = `
                <span class="tag-text">${label || value}</span>
                <span class="remove-tag">×</span>
            `;

            tag.querySelector('.remove-tag').addEventListener('click', () => {
                this.removeTag(tag);
            });

            this.tagList.appendChild(tag);
            this.tags.push({ value, type, label: label || value });
            this.updateHiddenInput();
        }

        removeTag(tagElement) {
            const value = tagElement.dataset.value;
            const type = tagElement.dataset.type;
            this.tags = this.tags.filter(tag => !(tag.value === value && tag.type === type));
            tagElement.remove();
            this.updateHiddenInput();
        }

        updateHiddenInput() {
            this.hiddenInput.value = JSON.stringify(this.tags);
            // Check if this is the goals input and update the description
            if (this.container.closest('form').id === 'training-persona-form') {
                formatGoalsDescription(this.tags);
            }
        }
    }

    // Initialize all components
    function initializeComponents() {
        // Initialize tag inputs
        document.querySelectorAll('.tag-input-container').forEach(container => {
            new TagInput(container);
        });

        // Initialize textareas with auto-expand
        document.querySelectorAll('textarea.auto-expand').forEach(textarea => {
            setupTextareaHandler(textarea);
        });
    }

    // Setup textarea handler (simplified)
    function setupTextareaHandler(element) {
        const $textarea = $(element);
        const maxLength = $textarea.attr('maxlength');
        
        if (!maxLength) return;

        const $counter = $('<span>', {
            class: 'char-counter',
            text: `0/${maxLength}`
        });
        $textarea.parent().append($counter);
        
        $textarea.on('input', function() {
            const currentLength = $(this).val().length;
            $counter.text(`${currentLength}/${maxLength}`);
            
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
        
        $textarea.trigger('input');
    }

    // Initialize components when document is ready
    initializeComponents();

    // Re-initialize components when modal content is loaded
    $(document).on('modal:contentLoaded', function() {
        initializeComponents();
    });

    // Handle goals description formatting
    function formatGoalsDescription(goals) {
        const textarea = document.querySelector('textarea[name="goals_detail"]');
        if (!textarea) return;

        // Get existing text content and parse it into sections
        const existingContent = textarea.value;
        const sections = {};
        
        // Parse existing content into sections
        let currentSection = '';
        existingContent.split('\n').forEach(line => {
            if (line.endsWith(':')) {
                currentSection = line.slice(0, -1);
            } else if (currentSection && line.trim()) {
                sections[currentSection] = line.trim();
            }
        });

        // Create new formatted content
        let newContent = '';
        if (goals && goals.length > 0) {
            goals.forEach((goal) => {
                const goalLabel = goal.label.toUpperCase();
                // Add existing description if available, otherwise add placeholder
                const description = sections[goalLabel] || '[Add description here]';
                newContent += `${goalLabel}:\n${description}\n\n`;
            });
        }

        // Update textarea with new content
        textarea.value = newContent.trim();
        // Trigger input event to update character counter and auto-expand
        textarea.dispatchEvent(new Event('input'));
    }
}); 