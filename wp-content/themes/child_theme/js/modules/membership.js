/**
 * Athlete Dashboard Membership Module
 */
(function($) {
    'use strict';

    const AthleteMembership = {
        init: function() {
            this.bindEvents();
            this.loadMembershipDetails();
            this.initializeSubscriptionForms();
        },

        bindEvents: function() {
            $(document).on('click', '.upgrade-plan-btn', this.handleUpgradePlan.bind(this));
            $(document).on('click', '.renew-membership-btn', this.handleRenewal.bind(this));
            $(document).on('submit', '.payment-form', this.handlePaymentSubmit.bind(this));
        },

        loadMembershipDetails: function() {
            $.ajax({
                url: athleteDashboard.ajax_url,
                type: 'POST',
                data: {
                    action: 'get_membership',
                    nonce: athleteDashboard.nonce
                },
                success: function(response) {
                    if (response.success) {
                        this.updateMembershipUI(response.data);
                    }
                }.bind(this)
            });
        },

        initializeSubscriptionForms: function() {
            // Initialize payment form elements
            if (typeof Stripe !== 'undefined') {
                this.initializeStripe();
            }

            // Initialize plan selection
            $('.plan-selector').on('change', function() {
                const planId = $(this).val();
                const planDetails = $(this).find(`option[value="${planId}"]`).data('plan');
                this.updatePlanDetails(planDetails);
            }.bind(this));
        },

        initializeStripe: function() {
            // Initialize Stripe elements if using Stripe
            if ($('#card-element').length) {
                const stripe = Stripe(athleteDashboard.stripe_key);
                const elements = stripe.elements();
                const card = elements.create('card');
                card.mount('#card-element');

                card.addEventListener('change', function(event) {
                    const displayError = document.getElementById('card-errors');
                    if (event.error) {
                        displayError.textContent = event.error.message;
                    } else {
                        displayError.textContent = '';
                    }
                });

                this.stripeCard = card;
            }
        },

        handleUpgradePlan: function(e) {
            e.preventDefault();
            const planId = $(e.target).data('plan-id');
            
            $.ajax({
                url: athleteDashboard.ajax_url,
                type: 'POST',
                data: {
                    action: 'get_upgrade_form',
                    nonce: athleteDashboard.nonce,
                    plan_id: planId
                },
                success: function(response) {
                    if (response.success) {
                        $('#upgrade-form-container').html(response.data.form);
                        this.initializeSubscriptionForms();
                    }
                }.bind(this)
            });
        },

        handleRenewal: function(e) {
            e.preventDefault();
            const membershipId = $(e.target).data('membership-id');

            $.ajax({
                url: athleteDashboard.ajax_url,
                type: 'POST',
                data: {
                    action: 'process_renewal',
                    nonce: athleteDashboard.nonce,
                    membership_id: membershipId
                },
                success: function(response) {
                    if (response.success) {
                        this.showMessage('Membership renewed successfully!', 'success');
                        this.loadMembershipDetails();
                    } else {
                        this.showMessage('Error renewing membership. Please try again.', 'error');
                    }
                }.bind(this)
            });
        },

        handlePaymentSubmit: function(e) {
            e.preventDefault();
            const $form = $(e.target);
            const $submitButton = $form.find('button[type="submit"]');
            
            $submitButton.prop('disabled', true);
            
            if (this.stripeCard) {
                // Handle Stripe payment
                this.processStripePayment($form);
            } else {
                // Handle other payment methods
                this.processRegularPayment($form);
            }
        },

        processStripePayment: function($form) {
            const stripe = Stripe(athleteDashboard.stripe_key);
            
            stripe.createToken(this.stripeCard).then(function(result) {
                if (result.error) {
                    this.showMessage(result.error.message, 'error');
                    $form.find('button[type="submit"]').prop('disabled', false);
                } else {
                    this.submitPaymentForm($form, { stripe_token: result.token.id });
                }
            }.bind(this));
        },

        processRegularPayment: function($form) {
            this.submitPaymentForm($form, {});
        },

        submitPaymentForm: function($form, additionalData) {
            const formData = new FormData($form[0]);
            const data = {
                action: 'process_payment',
                nonce: athleteDashboard.nonce,
                payment_data: Object.fromEntries(formData),
                ...additionalData
            };

            $.ajax({
                url: athleteDashboard.ajax_url,
                type: 'POST',
                data: data,
                success: function(response) {
                    if (response.success) {
                        this.showMessage('Payment processed successfully!', 'success');
                        this.loadMembershipDetails();
                        $form[0].reset();
                    } else {
                        this.showMessage('Error processing payment. Please try again.', 'error');
                    }
                    $form.find('button[type="submit"]').prop('disabled', false);
                }.bind(this),
                error: function() {
                    this.showMessage('Server error. Please try again later.', 'error');
                    $form.find('button[type="submit"]').prop('disabled', false);
                }.bind(this)
            });
        },

        updateMembershipUI: function(data) {
            $('#membership-status').text(data.status);
            $('#membership-type').text(data.type);
            $('#membership-expiry').text(data.expiry_date);
            
            // Update feature access
            data.features.forEach(function(feature) {
                $(`.feature-${feature}`).removeClass('disabled').addClass('active');
            });
        },

        updatePlanDetails: function(planDetails) {
            $('#plan-price').text(planDetails.price);
            $('#plan-features').html(planDetails.features.map(function(feature) {
                return `<li>${feature}</li>`;
            }).join(''));
        },

        showMessage: function(message, type) {
            const $messageDiv = $('.membership-message');
            $messageDiv
                .removeClass('success error')
                .addClass(type)
                .text(message)
                .fadeIn()
                .delay(3000)
                .fadeOut();
        }
    };

    // Initialize on document ready
    $(document).ready(function() {
        AthleteMembership.init();
    });

})(jQuery); 