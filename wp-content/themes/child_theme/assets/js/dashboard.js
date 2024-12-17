/**
 * Dashboard functionality
 * Handles dashboard interactions and data management
 */
class Dashboard {
    constructor() {
        this.initialize();
    }

    initialize() {
        this.bindEvents();
        this.restoreCardStates();
    }

    bindEvents() {
        // Card header click events
        document.addEventListener('click', (e) => {
            const header = e.target.closest('.card-header');
            if (header) {
                e.preventDefault();
                this.toggleCard(header);
            }

            // Handle refresh button clicks
            if (e.target.matches('.refresh-card')) {
                e.stopPropagation(); // Prevent card toggle
                const cardId = e.target.closest('.dashboard-card').id;
                this.refreshCardContent(cardId);
            }

            // Handle action button clicks
            if (e.target.matches('.add-entry-button')) {
                e.stopPropagation(); // Prevent card toggle
            }
        });

        // Keyboard accessibility
        document.addEventListener('keydown', (e) => {
            const header = e.target.closest('.card-header');
            if (header && (e.key === 'Enter' || e.key === ' ')) {
                e.preventDefault();
                this.toggleCard(header);
            }
        });
    }

    toggleCard(header) {
        const isExpanded = header.getAttribute('aria-expanded') === 'true';
        const content = document.getElementById(header.getAttribute('aria-controls'));
        const cardId = header.closest('.dashboard-card').id;

        if (isExpanded) {
            this.closeCard(header, content);
        } else {
            this.openCard(header, content);
        }

        // Save state
        localStorage.setItem(`card_${cardId}`, isExpanded ? 'closed' : 'open');
    }

    openCard(header, content) {
        header.setAttribute('aria-expanded', 'true');
        content.setAttribute('aria-hidden', 'false');
        content.style.display = 'block';
        
        // Trigger custom event for components to reinitialize if needed
        content.dispatchEvent(new CustomEvent('card:opened'));
    }

    closeCard(header, content) {
        header.setAttribute('aria-expanded', 'false');
        content.setAttribute('aria-hidden', 'true');
        content.style.display = 'none';
    }

    restoreCardStates() {
        document.querySelectorAll('.dashboard-card').forEach(card => {
            const cardId = card.id;
            const state = localStorage.getItem(`card_${cardId}`);
            const header = card.querySelector('.card-header');
            const content = card.querySelector('.card-content');

            if (state === 'open') {
                this.openCard(header, content);
            }
        });
    }

    async refreshCardContent(cardId) {
        try {
            const response = await fetch(athleteDashboardData.ajaxurl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'refresh_card_content',
                    card: cardId,
                    nonce: athleteDashboardData.nonce
                })
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const data = await response.json();
            if (data.success) {
                const card = document.getElementById(cardId);
                if (card) {
                    const content = card.querySelector('.card-content');
                    if (content) {
                        content.innerHTML = data.content;
                        // Trigger custom event for components to reinitialize
                        content.dispatchEvent(new CustomEvent('card:refreshed'));
                    }
                }
            } else {
                this.showError(data.message || 'Failed to refresh content');
            }
        } catch (error) {
            console.error('Error refreshing card content:', error);
            this.showError('An error occurred while refreshing the content');
        }
    }

    showError(message) {
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-message';
        errorDiv.textContent = message;
        
        document.querySelector('.athlete-dashboard').insertAdjacentElement('afterbegin', errorDiv);
        
        setTimeout(() => {
            errorDiv.remove();
        }, 5000);
    }
}

// Initialize when document is ready
document.addEventListener('DOMContentLoaded', () => {
    new Dashboard();
});
