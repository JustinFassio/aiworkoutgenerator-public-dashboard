/**
 * AthleteMembership Module
 * Handles all membership-related functionality for the athlete dashboard
 */
const AthleteMembership = (function($) {
    'use strict';

    // Private variables
    let config = {
        selectors: {
            membershipContainer: '.athlete-membership',
            membershipStatus: '.membership-status',
            membershipDetails: '.membership-details',
            paymentHistory: '.payment-history',
            renewalForm: '#membership-renewal-form',
            upgradeForm: '#membership-upgrade-form',
            paymentModal: '#payment-modal'
        },
        updateInterval: 300000 // 5 minutes
    };

    /**
     * Initialize membership forms
     */
    function initializeMembershipForms() {
        // Renewal form
        $(config.selectors.renewalForm).on('submit', function(e) {
            e.preventDefault();
            submitRenewal($(this));
        });

        // Upgrade form
        $(config.selectors.upgradeForm).on('submit', function(e) {
            e.preventDefault();
            submitUpgrade($(this));
        });
    }

    /**
     * Submit membership renewal
     */
    function submitRenewal($form) {
        const formData = $form.serialize();
        $.ajax({
            url: window.athleteDashboard.ajax_url,
            type: 'POST',
            data: formData + '&action=athlete_dashboard_renew_membership&nonce=' + window.athleteDashboard.nonce,
            success: function(response) {
                if (response.success) {
                    $form[0].reset();
                    refreshMembershipData();
                    showNotification('Membership renewed successfully!', 'success');
                } else {
                    console.error('Error renewing membership:', response.data.message);
                    showNotification('Error: ' + response.data.message, 'error');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error renewing membership:', error);
                showNotification('An error occurred while renewing membership. Please try again.', 'error');
            }
        });
    }

    /**
     * Submit membership upgrade
     */
    function submitUpgrade($form) {
        const formData = $form.serialize();
        $.ajax({
            url: window.athleteDashboard.ajax_url,
            type: 'POST',
            data: formData + '&action=athlete_dashboard_upgrade_membership&nonce=' + window.athleteDashboard.nonce,
            success: function(response) {
                if (response.success) {
                    $form[0].reset();
                    refreshMembershipData();
                    showNotification('Membership upgraded successfully!', 'success');
                } else {
                    console.error('Error upgrading membership:', response.data.message);
                    showNotification('Error: ' + response.data.message, 'error');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error upgrading membership:', error);
                showNotification('An error occurred while upgrading membership. Please try again.', 'error');
            }
        });
    }

    /**
     * Refresh membership data
     */
    function refreshMembershipData() {
        // Update membership status
        updateMembershipStatus();

        // Update membership details
        updateMembershipDetails();

        // Update payment history
        updatePaymentHistory();
    }

    /**
     * Update membership status
     */
    function updateMembershipStatus() {
        $.ajax({
            url: window.athleteDashboard.ajax_url,
            type: 'POST',
            data: {
                action: 'athlete_dashboard_get_membership_status',
                nonce: window.athleteDashboard.nonce
            },
            success: function(response) {
                if (response.success) {
                    $(config.selectors.membershipStatus).html(response.data.html);
                } else {
                    console.error('Error updating membership status:', response.data.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error updating membership status:', error);
            }
        });
    }

    /**
     * Update membership details
     */
    function updateMembershipDetails() {
        $.ajax({
            url: window.athleteDashboard.ajax_url,
            type: 'POST',
            data: {
                action: 'athlete_dashboard_get_membership_details',
                nonce: window.athleteDashboard.nonce
            },
            success: function(response) {
                if (response.success) {
                    $(config.selectors.membershipDetails).html(response.data.html);
                } else {
                    console.error('Error updating membership details:', response.data.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error updating membership details:', error);
            }
        });
    }

    /**
     * Update payment history
     */
    function updatePaymentHistory() {
        $.ajax({
            url: window.athleteDashboard.ajax_url,
            type: 'POST',
            data: {
                action: 'athlete_dashboard_get_payment_history',
                nonce: window.athleteDashboard.nonce
            },
            success: function(response) {
                if (response.success) {
                    $(config.selectors.paymentHistory).html(response.data.html);
                } else {
                    console.error('Error updating payment history:', response.data.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error updating payment history:', error);
            }
        });
    }

    /**
     * Show notification message
     */
    function showNotification(message, type) {
        if (typeof window.AthleteUI !== 'undefined' && window.AthleteUI.showNotification) {
            window.AthleteUI.showNotification(message, type);
        } else {
            alert(message);
        }
    }

    /**
     * Start periodic updates
     */
    function startPeriodicUpdates() {
        setInterval(function() {
            refreshMembershipData();
        }, config.updateInterval);
    }

    /**
     * Initialize event listeners
     */
    function initializeEventListeners() {
        // Payment modal
        $(document).on('click', '.open-payment-modal', function(e) {
            e.preventDefault();
            const planId = $(this).data('plan-id');
            const planType = $(this).data('plan-type');
            const $modal = $(config.selectors.paymentModal);
            
            // Load payment form into modal
            $.ajax({
                url: window.athleteDashboard.ajax_url,
                type: 'POST',
                data: {
                    action: 'athlete_dashboard_get_payment_form',
                    plan_id: planId,
                    plan_type: planType,
                    nonce: window.athleteDashboard.nonce
                },
                success: function(response) {
                    if (response.success) {
                        $modal.find('.modal-content').html(response.data.html);
                        $modal.modal('show');
                    } else {
                        console.error('Error loading payment form:', response.data.message);
                        showNotification('Error: ' + response.data.message, 'error');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error loading payment form:', error);
                    showNotification('An error occurred while loading the payment form. Please try again.', 'error');
                }
            });
        });
    }

    /**
     * Initialize all membership components
     */
    function initialize() {
        if ($(config.selectors.membershipContainer).length) {
            initializeMembershipForms();
            initializeEventListeners();
            refreshMembershipData();
            startPeriodicUpdates();
        }
    }

    // Public API
    return {
        initialize,
        refreshMembershipData,
        updateMembershipStatus,
        updateMembershipDetails,
        updatePaymentHistory
    };

})(jQuery);

// Initialize when document is ready
jQuery(document).ready(function() {
    AthleteMembership.initialize();
}); 