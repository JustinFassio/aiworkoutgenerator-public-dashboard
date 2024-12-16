/**
 * Athlete Dashboard UI Module
 */
(function($) {
    'use strict';

    const AthleteUI = {
        init: function() {
            this.initializeComponents();
            this.bindEvents();
        },

        initializeComponents: function() {
            // Initialize UI components
            $('.athlete-dashboard-tabs').tabs();
            this.initializeTooltips();
            this.initializeModals();
        },

        bindEvents: function() {
            // Bind UI event handlers
            $(document).on('click', '.athlete-dashboard-toggle', this.handleToggle);
            $(document).on('click', '.athlete-dashboard-modal-trigger', this.handleModalTrigger);
        },

        initializeTooltips: function() {
            $('.athlete-dashboard-tooltip').each(function() {
                $(this).tooltip({
                    position: { my: 'left+5 center', at: 'right center' }
                });
            });
        },

        initializeModals: function() {
            $('.athlete-dashboard-modal').dialog({
                autoOpen: false,
                modal: true,
                width: 'auto',
                closeText: ''
            });
        },

        handleToggle: function(e) {
            e.preventDefault();
            const target = $(this).data('target');
            $(target).slideToggle();
        },

        handleModalTrigger: function(e) {
            e.preventDefault();
            const modalId = $(this).data('modal');
            $(`#${modalId}`).dialog('open');
        }
    };

    // Initialize on document ready
    $(document).ready(function() {
        AthleteUI.init();
    });

})(jQuery); 