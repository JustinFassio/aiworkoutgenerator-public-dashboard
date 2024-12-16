/**
 * Athlete Dashboard UI Module
 */
export class AthleteUI {
    constructor() {
        this.initialized = false;
    }

    init() {
        if (this.initialized) return;
        this.initializeComponents();
        this.bindEvents();
        this.initialized = true;
    }

    initializeComponents() {
        this.initializeTabs();
        this.initializeTooltips();
        this.initializeModals();
    }

    bindEvents() {
        // Use event delegation for dynamic elements
        document.addEventListener('click', (e) => {
            if (e.target.matches('.athlete-dashboard-toggle')) {
                this.handleToggle(e);
            }
            if (e.target.matches('.athlete-dashboard-modal-trigger')) {
                this.handleModalTrigger(e);
            }
        });
    }

    initializeTabs() {
        document.querySelectorAll('.athlete-dashboard-tabs').forEach(tabContainer => {
            const tabs = tabContainer.querySelectorAll('[role="tab"]');
            const panels = tabContainer.querySelectorAll('[role="tabpanel"]');

            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    // Deactivate all tabs
                    tabs.forEach(t => t.setAttribute('aria-selected', 'false'));
                    panels.forEach(p => p.hidden = true);

                    // Activate clicked tab
                    tab.setAttribute('aria-selected', 'true');
                    const panel = tabContainer.querySelector(`#${tab.getAttribute('aria-controls')}`);
                    if (panel) panel.hidden = false;
                });
            });

            // Activate first tab by default
            if (tabs[0]) tabs[0].click();
        });
    }

    initializeTooltips() {
        document.querySelectorAll('.athlete-dashboard-tooltip').forEach(tooltip => {
            const content = tooltip.getAttribute('data-tooltip');
            if (!content) return;

            tooltip.addEventListener('mouseenter', (e) => {
                const tip = document.createElement('div');
                tip.className = 'athlete-tooltip';
                tip.textContent = content;
                document.body.appendChild(tip);

                const rect = tooltip.getBoundingClientRect();
                tip.style.left = `${rect.right + 5}px`;
                tip.style.top = `${rect.top + (rect.height / 2) - (tip.offsetHeight / 2)}px`;
            });

            tooltip.addEventListener('mouseleave', () => {
                document.querySelectorAll('.athlete-tooltip').forEach(t => t.remove());
            });
        });
    }

    initializeModals() {
        document.querySelectorAll('.athlete-dashboard-modal').forEach(modal => {
            // Create modal backdrop
            const backdrop = document.createElement('div');
            backdrop.className = 'athlete-modal-backdrop';
            modal.before(backdrop);

            // Add close button
            const closeBtn = document.createElement('button');
            closeBtn.className = 'athlete-modal-close';
            closeBtn.innerHTML = '×';
            closeBtn.addEventListener('click', () => this.closeModal(modal));
            modal.appendChild(closeBtn);

            // Hide initially
            this.closeModal(modal);
        });
    }

    handleToggle(e) {
        e.preventDefault();
        const target = document.querySelector(e.target.dataset.target);
        if (target) {
            const isHidden = target.style.display === 'none';
            target.style.display = isHidden ? 'block' : 'none';
            target.style.height = isHidden ? `${target.scrollHeight}px` : '0';
        }
    }

    handleModalTrigger(e) {
        e.preventDefault();
        const modalId = e.target.dataset.modal;
        const modal = document.getElementById(modalId);
        if (modal) this.openModal(modal);
    }

    openModal(modal) {
        modal.style.display = 'block';
        modal.previousElementSibling?.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    closeModal(modal) {
        modal.style.display = 'none';
        modal.previousElementSibling?.classList.remove('active');
        document.body.style.overflow = '';
    }

    // Utility methods that can be used by other modules
    static createElement(tag, className, content = '') {
        const element = document.createElement(tag);
        if (className) element.className = className;
        if (content) element.textContent = content;
        return element;
    }

    static showLoading(container) {
        const loader = AthleteUI.createElement('div', 'athlete-loading');
        container.appendChild(loader);
        return loader;
    }

    static hideLoading(loader) {
        loader?.remove();
    }

    static showError(message, container) {
        const error = AthleteUI.createElement('div', 'athlete-error', message);
        container.appendChild(error);
        setTimeout(() => error.remove(), 5000);
    }
}

// Export singleton instance
export const UI = new AthleteUI();

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => UI.init()); 