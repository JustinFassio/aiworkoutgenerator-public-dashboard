jQuery(document).ready(function($) {
    // Initialize form handler
    const trainingPersonaForm = new TrainingPersonaFormHandler('training-persona-form', {
        endpoint: trainingPersonaData.ajaxurl,
        additionalData: {
            action: 'update_training_persona',
            training_persona_nonce: trainingPersonaData.nonce
        }
    });

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
                const savedTags = JSON.parse(this.hiddenInput.value);
                if (Array.isArray(savedTags)) {
                    savedTags.forEach(tag => this.addTag(tag.value, tag.type));
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
            // Trigger goals description update when tags change
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

        // Update textarea
        textarea.value = newContent.trim();
        
        // Trigger auto-expand
        textarea.dispatchEvent(new Event('input'));
    }
}); 