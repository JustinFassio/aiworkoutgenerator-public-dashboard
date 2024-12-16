/**
 * AthleteUI Module
 * Handles all UI-related functionality for the athlete dashboard
 */
const AthleteUI = (function($) {
    'use strict';

    // Private variables
    let config = {
        selectors: {
            exerciseTabs: '#exercise-tabs',
            dashboardGroup: '.dashboard-group',
            groupHeader: '.group-header',
            groupContent: '.group-content',
            toggleGroup: '.toggle-group',
            dashboardSection: '.dashboard-section',
            toggleBtn: '.toggle-btn',
            sectionContent: '.section-content'
        }
    };

    /**
     * Initialize exercise tabs functionality
     */
    function initializeExerciseTabs() {
        try {
            $(config.selectors.exerciseTabs).tabs({
                create: function(event, ui) {
                    const firstExerciseKey = Object.keys(window.athleteDashboard.exerciseTests)[0];
                    if (typeof window.AthleteCharts !== 'undefined') {
                        window.AthleteCharts.initializeExerciseChart(firstExerciseKey);
                        window.AthleteCharts.updateExerciseChart(firstExerciseKey);
                    }
                },
                activate: function(event, ui) {
                    const exerciseKey = ui.newPanel.attr('id');
                    if (typeof window.AthleteCharts !== 'undefined') {
                        if (!window.AthleteCharts.chartExists(exerciseKey)) {
                            window.AthleteCharts.initializeExerciseChart(exerciseKey);
                        }
                        window.AthleteCharts.updateExerciseChart(exerciseKey);
                    }
                }
            });
        } catch (error) {
            console.error('Error initializing exercise tabs:', error);
        }
    }

    /**
     * Initialize group toggle functionality
     */
    function initializeGroupToggles() {
        $(config.selectors.dashboardGroup).each(function() {
            const $group = $(this);
            const $header = $group.find(config.selectors.groupHeader);
            const $content = $group.find(config.selectors.groupContent);
            const $toggleBtn = $group.find(config.selectors.toggleGroup);

            $header.on('click', function() {
                toggleGroup($group, $content, $toggleBtn);
            });

            $toggleBtn.on('click', function(e) {
                e.stopPropagation();
                toggleGroup($group, $content, $toggleBtn);
            });

            // Restore group states on page load
            const groupName = $group.data('group-name');
            const savedState = localStorage.getItem('groupState_' + groupName);

            if (savedState === 'collapsed') {
                collapseGroup($group, $content, $toggleBtn);
            }
        });
    }

    /**
     * Toggle group expand/collapse state
     */
    function toggleGroup($group, $content, $toggleBtn) {
        const isExpanded = $toggleBtn.attr('aria-expanded') === 'true';

        if (isExpanded) {
            collapseGroup($group, $content, $toggleBtn);
        } else {
            expandGroup($group, $content, $toggleBtn);
        }

        // Save the state to localStorage
        const groupName = $group.data('group-name');
        localStorage.setItem('groupState_' + groupName, isExpanded ? 'collapsed' : 'expanded');
    }

    /**
     * Collapse a group
     */
    function collapseGroup($group, $content, $toggleBtn) {
        $group.addClass('collapsed');
        $toggleBtn.attr('aria-expanded', 'false');
        $content.slideUp(300);
        $toggleBtn.find('.fa-chevron-up').hide();
        $toggleBtn.find('.fa-chevron-down').show();
    }

    /**
     * Expand a group
     */
    function expandGroup($group, $content, $toggleBtn) {
        $group.removeClass('collapsed');
        $toggleBtn.attr('aria-expanded', 'true');
        $content.slideDown(300);
        $toggleBtn.find('.fa-chevron-up').show();
        $toggleBtn.find('.fa-chevron-down').hide();
    }

    /**
     * Restore section states from localStorage
     */
    function restoreSectionStates() {
        $(config.selectors.dashboardSection).each(function() {
            const sectionId = $(this).attr('id');
            const isExpanded = localStorage.getItem(sectionId) === 'expanded';
            if (isExpanded) {
                openSection($(this), false);
            } else {
                closeSection($(this), false);
            }
        });
    }

    /**
     * Toggle section visibility
     */
    function toggleSection(button) {
        const $button = $(button);
        const $section = $button.closest(config.selectors.dashboardSection);
        const isExpanded = $button.attr('aria-expanded') === 'true';

        // Close all other sections
        $(config.selectors.dashboardSection).not($section).each(function() {
            closeSection($(this), true);
        });

        if (isExpanded) {
            closeSection($section, true);
        } else {
            openSection($section, true);
        }
    }

    /**
     * Open a section
     */
    function openSection($section, shouldAnimate) {
        const $button = $section.find(config.selectors.toggleBtn);
        const $content = $section.find(config.selectors.sectionContent);
        const sectionId = $section.attr('id');

        $button.attr('aria-expanded', 'true');
        $button.find('span[aria-hidden]').text('-');
        
        if (shouldAnimate) {
            $content.slideDown(300, function() {
                $content.attr('aria-hidden', 'false');
                makeSticky($section);
            });
        } else {
            $content.show().attr('aria-hidden', 'false');
            makeSticky($section);
        }

        $section.addClass('active');
        localStorage.setItem(sectionId, 'expanded');
    }

    /**
     * Close a section
     */
    function closeSection($section, shouldAnimate) {
        const $button = $section.find(config.selectors.toggleBtn);
        const $content = $section.find(config.selectors.sectionContent);
        const sectionId = $section.attr('id');

        $button.attr('aria-expanded', 'false');
        $button.find('span[aria-hidden]').text('+');
        
        if (shouldAnimate) {
            $content.slideUp(300, function() {
                $content.attr('aria-hidden', 'true');
                removeSticky($section);
            });
        } else {
            $content.hide().attr('aria-hidden', 'true');
            removeSticky($section);
        }

        $section.removeClass('active');
        localStorage.setItem(sectionId, 'collapsed');
    }

    /**
     * Make a section sticky
     */
    function makeSticky($section) {
        const $button = $section.find(config.selectors.toggleBtn);
        const buttonOffset = $button.offset().top;
        
        $('html, body').animate({
            scrollTop: buttonOffset - 20
        }, 300);

        $section.css({
            position: 'sticky',
            top: '20px',
            zIndex: 100
        });
    }

    /**
     * Remove sticky positioning from a section
     */
    function removeSticky($section) {
        $section.css({
            position: '',
            top: '',
            zIndex: ''
        });
    }

    /**
     * Initialize all UI components
     */
    function initialize() {
        initializeExerciseTabs();
        initializeGroupToggles();
        restoreSectionStates();

        // Set up event listeners
        $(document).on('click', config.selectors.toggleBtn, function(event) {
            event.preventDefault();
            toggleSection(this);
        });
    }

    // Public API
    return {
        initialize,
        toggleSection,
        restoreSectionStates
    };

})(jQuery);

// Initialize when document is ready
jQuery(document).ready(function() {
    AthleteUI.initialize();
}); 