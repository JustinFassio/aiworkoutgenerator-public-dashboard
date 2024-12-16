/**
 * Athlete Dashboard Membership Module
 */
import { UI } from './ui.js';

export class AthleteMembership {
    constructor() {
        this.initialized = false;
        this.stripeCard = null;
    }

    init() {
        if (this.initialized) return;
        this.bindEvents();
        this.loadMembershipDetails();
        this.initializeSubscriptionForms();
        this.initialized = true;
    }

    bindEvents() {
        document.addEventListener('click', (e) => {
            if (e.target.matches('.upgrade-plan-btn')) {
                this.handleUpgradePlan(e);
            }
            if (e.target.matches('.renew-membership-btn')) {
                this.handleRenewal(e);
            }
        });

        document.addEventListener('submit', (e) => {
            if (e.target.matches('.payment-form')) {
                this.handlePaymentSubmit(e);
            }
        });
    }

    async loadMembershipDetails() {
        const container = document.getElementById('membership-details-container');
        if (!container) return;

        const loader = UI.showLoading(container);

        try {
            const response = await fetch(window.athleteDashboard.ajax_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'get_membership',
                    nonce: window.athleteDashboard.nonce
                })
            });

            const data = await response.json();
            
            if (data.success) {
                this.updateMembershipUI(data.data);
            } else {
                this.showMessage('Error loading membership details. Please try again.', 'error', container);
            }
        } catch (error) {
            this.showMessage('Server error. Please try again later.', 'error', container);
            console.error('Membership details loading error:', error);
        } finally {
            UI.hideLoading(loader);
        }
    }

    initializeSubscriptionForms() {
        // Initialize Stripe if available
        if (typeof Stripe !== 'undefined') {
            this.initializeStripe();
        }

        // Initialize plan selection
        document.querySelectorAll('.plan-selector').forEach(selector => {
            selector.addEventListener('change', (e) => {
                const option = e.target.options[e.target.selectedIndex];
                const planDetails = JSON.parse(option.dataset.plan || '{}');
                this.updatePlanDetails(planDetails);
            });
        });
    }

    initializeStripe() {
        const cardElement = document.getElementById('card-element');
        if (!cardElement) return;

        const stripe = Stripe(window.athleteDashboard.stripe_key);
        const elements = stripe.elements();
        const card = elements.create('card');
        card.mount('#card-element');

        card.addEventListener('change', (event) => {
            const displayError = document.getElementById('card-errors');
            if (displayError) {
                displayError.textContent = event.error ? event.error.message : '';
            }
        });

        this.stripeCard = card;
    }

    async handleUpgradePlan(e) {
        e.preventDefault();
        const planId = e.target.dataset.planId;
        const container = document.getElementById('upgrade-form-container');
        
        if (!container) return;

        const loader = UI.showLoading(container);

        try {
            const response = await fetch(window.athleteDashboard.ajax_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'get_upgrade_form',
                    nonce: window.athleteDashboard.nonce,
                    plan_id: planId
                })
            });

            const data = await response.json();
            
            if (data.success) {
                container.innerHTML = data.data.form;
                this.initializeSubscriptionForms();
            } else {
                this.showMessage(data.data?.message || 'Error loading upgrade form.', 'error', container);
            }
        } catch (error) {
            this.showMessage('Server error. Please try again later.', 'error', container);
            console.error('Upgrade form loading error:', error);
        } finally {
            UI.hideLoading(loader);
        }
    }

    async handleRenewal(e) {
        e.preventDefault();
        const membershipId = e.target.dataset.membershipId;
        const container = e.target.closest('.membership-container');
        
        if (!container) return;

        const loader = UI.showLoading(container);

        try {
            const response = await fetch(window.athleteDashboard.ajax_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'process_renewal',
                    nonce: window.athleteDashboard.nonce,
                    membership_id: membershipId
                })
            });

            const data = await response.json();
            
            if (data.success) {
                this.showMessage('Membership renewed successfully!', 'success', container);
                await this.loadMembershipDetails();
            } else {
                this.showMessage(data.data?.message || 'Error renewing membership. Please try again.', 'error', container);
            }
        } catch (error) {
            this.showMessage('Server error. Please try again later.', 'error', container);
            console.error('Membership renewal error:', error);
        } finally {
            UI.hideLoading(loader);
        }
    }

    async handlePaymentSubmit(e) {
        e.preventDefault();
        const form = e.target;
        const submitButton = form.querySelector('button[type="submit"]');
        const container = form.closest('.membership-container');
        
        if (!container) return;
        
        submitButton.disabled = true;
        
        try {
            if (this.stripeCard) {
                await this.processStripePayment(form, container);
            } else {
                await this.processRegularPayment(form, container);
            }
        } catch (error) {
            this.showMessage('Payment processing error. Please try again.', 'error', container);
            console.error('Payment submission error:', error);
        } finally {
            submitButton.disabled = false;
        }
    }

    async processStripePayment(form, container) {
        const stripe = Stripe(window.athleteDashboard.stripe_key);
        
        try {
            const result = await stripe.createToken(this.stripeCard);
            if (result.error) {
                this.showMessage(result.error.message, 'error', container);
            } else {
                await this.submitPaymentForm(form, container, { stripe_token: result.token.id });
            }
        } catch (error) {
            this.showMessage('Stripe processing error. Please try again.', 'error', container);
            console.error('Stripe payment error:', error);
        }
    }

    async processRegularPayment(form, container) {
        await this.submitPaymentForm(form, container, {});
    }

    async submitPaymentForm(form, container, additionalData = {}) {
        const loader = UI.showLoading(container);
        const formData = new FormData(form);

        try {
            const response = await fetch(window.athleteDashboard.ajax_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'process_payment',
                    nonce: window.athleteDashboard.nonce,
                    payment_data: JSON.stringify({
                        ...Object.fromEntries(formData),
                        ...additionalData
                    })
                })
            });

            const data = await response.json();
            
            if (data.success) {
                this.showMessage('Payment processed successfully!', 'success', container);
                await this.loadMembershipDetails();
                form.reset();
            } else {
                this.showMessage(data.data?.message || 'Error processing payment. Please try again.', 'error', container);
            }
        } catch (error) {
            this.showMessage('Server error. Please try again later.', 'error', container);
            console.error('Payment submission error:', error);
        } finally {
            UI.hideLoading(loader);
        }
    }

    updateMembershipUI(data) {
        const elements = {
            status: document.getElementById('membership-status'),
            type: document.getElementById('membership-type'),
            expiry: document.getElementById('membership-expiry')
        };

        if (elements.status) elements.status.textContent = data.status;
        if (elements.type) elements.type.textContent = data.type;
        if (elements.expiry) elements.expiry.textContent = data.expiry_date;
        
        // Update feature access
        data.features.forEach(feature => {
            document.querySelectorAll(`.feature-${feature}`).forEach(el => {
                el.classList.remove('disabled');
                el.classList.add('active');
            });
        });
    }

    updatePlanDetails(planDetails) {
        const priceElement = document.getElementById('plan-price');
        const featuresElement = document.getElementById('plan-features');

        if (priceElement) priceElement.textContent = planDetails.price;
        if (featuresElement) {
            featuresElement.innerHTML = planDetails.features
                .map(feature => `<li>${feature}</li>`)
                .join('');
        }
    }

    showMessage(message, type, container) {
        const messageDiv = container.querySelector('.membership-message') || 
            UI.createElement('div', 'membership-message');
        
        messageDiv.className = `membership-message ${type}`;
        messageDiv.textContent = message;
        
        if (!messageDiv.parentNode) {
            container.insertBefore(messageDiv, container.firstChild);
        }

        // Auto-hide message
        setTimeout(() => {
            messageDiv.classList.add('fade-out');
            setTimeout(() => messageDiv.remove(), 300);
        }, 3000);
    }
}

// Export singleton instance
export const Membership = new AthleteMembership();

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => Membership.init()); 