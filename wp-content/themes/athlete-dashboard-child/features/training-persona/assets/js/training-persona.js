jQuery(document).ready(function($) {
    // Initialize form handler
    const trainingPersonaForm = new FormHandler('training-persona-form', {
        endpoint: trainingPersonaData.ajaxurl,
        additionalData: {
            action: 'update_training_persona',
            training_persona_nonce: trainingPersonaData.nonce
        }
    });

    function handleGoalsChange(event) {
        const selectedGoals = Array.from(event.target.selectedOptions).map(option => option.value);
        const goalsDetailTextarea = document.querySelector('textarea[name="goals_detail"]');
        
        if (!goalsDetailTextarea) return;
        
        let currentText = goalsDetailTextarea.value;
        let sections = {};
        
        // Parse existing sections
        if (currentText) {
            const lines = currentText.split('\n');
            let currentSection = '';
            lines.forEach(line => {
                if (line.startsWith('>> ')) {
                    currentSection = line.substring(3);
                    sections[currentSection] = '';
                } else if (currentSection && line.trim()) {
                    sections[currentSection] += (sections[currentSection] ? '\n' : '') + line;
                }
            });
        }
        
        // Create or update sections for selected goals
        selectedGoals.forEach(goal => {
            if (!sections[goal]) {
                sections[goal] = '';
            }
        });
        
        // Remove sections for unselected goals
        Object.keys(sections).forEach(section => {
            if (!selectedGoals.includes(section)) {
                delete sections[section];
            }
        });
        
        // Build new text
        let newText = '';
        Object.entries(sections).forEach(([goal, description]) => {
            newText += `>> ${goal}\n${description.trim()}\n\n`;
        });
        
        goalsDetailTextarea.value = newText.trim();
    }

    function initTrainingPersonaForm() {
        const form = document.getElementById('training-persona-form');
        if (!form) return;

        const goalsSelect = form.querySelector('select[name="goals"]');
        if (goalsSelect) {
            goalsSelect.addEventListener('change', handleGoalsChange);
            
            // Initialize textarea with existing goals
            const event = new Event('change');
            goalsSelect.dispatchEvent(event);
        }

        // Character counter for goals detail
        const goalsDetailTextarea = form.querySelector('textarea[name="goals_detail"]');
        if (goalsDetailTextarea) {
            const charCounter = document.createElement('div');
            charCounter.className = 'char-counter';
            goalsDetailTextarea.parentNode.appendChild(charCounter);

            function updateCharCount() {
                const count = goalsDetailTextarea.value.length;
                charCounter.textContent = `${count}/1000`;
            }

            goalsDetailTextarea.addEventListener('input', updateCharCount);
            updateCharCount();
        }
    }

    // Initialize components when modal content is loaded
    $(document).on('modal:contentLoaded', function() {
        // Initialize tag inputs
        document.querySelectorAll('.tag-input-container').forEach(container => {
            const tagInput = new TagInput(container);
            
            // Add goals formatting for training persona form
            if (container.closest('form').id === 'training-persona-form' && 
                container.querySelector('input[name="goals"]')) {
                tagInput.onTagsUpdate = function(tags) {
                    formatGoalsDescription(tags);
                };
            }
        });

        // Initialize character counters
        document.querySelectorAll('textarea[maxlength]').forEach(textarea => {
            const counter = document.createElement('div');
            counter.className = 'char-counter';
            textarea.parentNode.appendChild(counter);

            function updateCounter() {
                const remaining = parseInt(textarea.getAttribute('maxlength')) - textarea.value.length;
                counter.textContent = remaining;
            }

            textarea.addEventListener('input', updateCounter);
            updateCounter();
        });
    });

    // Initialize when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        initTrainingPersonaForm();
    });
}); 