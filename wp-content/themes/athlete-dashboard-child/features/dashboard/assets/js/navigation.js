jQuery(document).ready(function($) {
    // Modal handling
    const modals = {
        profile: $('#profile-modal'),
        'training-persona': $('#training-persona-modal')
    };

    // Open modal
    $('.action-button').on('click', function() {
        const modalType = $(this).data('modal');
        if (modals[modalType]) {
            modals[modalType].fadeIn(200);
            $('body').addClass('modal-open');
        }
    });

    // Close modal
    $('.close-modal').on('click', function() {
        $(this).closest('.modal').fadeOut(200);
        $('body').removeClass('modal-open');
    });

    // Close modal on outside click
    $('.modal').on('click', function(e) {
        if ($(e.target).hasClass('modal')) {
            $(this).fadeOut(200);
            $('body').removeClass('modal-open');
        }
    });

    // Handle ESC key
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape') {
            $('.modal').fadeOut(200);
            $('body').removeClass('modal-open');
        }
    });

    // Refresh dashboard data after form submission
    $(document).on('form:success', function(e, response) {
        if (response.success) {
            refreshDashboardData();
        }
    });

    function refreshDashboardData() {
        $.ajax({
            url: navigationData.ajaxurl,
            method: 'POST',
            data: {
                action: 'get_dashboard_data',
                nonce: navigationData.nonce
            },
            success: function(response) {
                if (response.success) {
                    updateDashboardUI(response.data);
                }
            }
        });
    }

    function updateDashboardUI(data) {
        // Update Profile Summary
        if (data.profile) {
            updateProfileSummary(data.profile);
        }

        // Update Training Persona Summary
        if (data.training_persona) {
            updateTrainingPersonaSummary(data.training_persona);
        }
    }

    function updateProfileSummary(profile) {
        // Update age
        $('.profile-summary .summary-item:nth-child(1) .value').text(profile.age || '--');

        // Update height
        let heightText = '--';
        if (profile.height) {
            const unit = profile.height_unit || 'imperial';
            if (unit === 'imperial') {
                const feet = Math.floor(profile.height / 12);
                const inches = profile.height % 12;
                heightText = `${feet}'${inches}"`;
            } else {
                heightText = `${profile.height} cm`;
            }
        }
        $('.profile-summary .summary-item:nth-child(2) .value').text(heightText);

        // Update weight
        let weightText = '--';
        if (profile.weight) {
            const unit = profile.weight_unit || 'imperial';
            weightText = `${profile.weight} ${unit === 'imperial' ? 'lbs' : 'kg'}`;
        }
        $('.profile-summary .summary-item:nth-child(3) .value').text(weightText);
    }

    function updateTrainingPersonaSummary(persona) {
        // Update experience level
        $('.training-persona-summary .summary-item:nth-child(1) .value').text(
            formatPersonaField(persona.experience_level, experienceLevels) || '--'
        );

        // Update activity level
        $('.training-persona-summary .summary-item:nth-child(2) .value').text(
            formatPersonaField(persona.current_activity_level, activityLevels) || '--'
        );

        // Update goals
        const $goalsList = $('.training-persona-summary .goals-list');
        $goalsList.empty();

        if (persona.goals && persona.goals.length > 0) {
            persona.goals.forEach(goal => {
                $goalsList.append(
                    $('<span>', {
                        class: 'goal-tag',
                        text: formatPersonaField(goal, goals)
                    })
                );
            });
        } else {
            $goalsList.append(
                $('<span>', {
                    class: 'empty',
                    text: 'No goals set'
                })
            );
        }
    }

    function formatPersonaField(value, options) {
        if (!value) return null;
        return options[value] || value;
    }

    // Field option mappings
    const experienceLevels = {
        beginner: 'Beginner',
        intermediate: 'Intermediate',
        advanced: 'Advanced'
    };

    const activityLevels = {
        sedentary: 'Sedentary',
        lightly_active: 'Lightly Active',
        moderately_active: 'Moderately Active',
        very_active: 'Very Active',
        extremely_active: 'Extremely Active'
    };

    const goals = {
        build_strength: 'Build Strength',
        increase_flexibility: 'Increase Flexibility',
        weight_management: 'Weight Management'
    };

    // Initial data load
    refreshDashboardData();
});
