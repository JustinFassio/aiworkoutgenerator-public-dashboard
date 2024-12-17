jQuery(document).ready(function($) {
    const generator = {
        init: function() {
            this.bindEvents();
        },

        bindEvents: function() {
            $('#generate-workout').on('click', this.generateWorkout);
        },

        generateWorkout: function(e) {
            e.preventDefault();
            const $button = $(this);
            const $result = $('#workout-result');
            
            // Disable button and show loading state
            $button.prop('disabled', true).text('Generating...');
            
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'generate_workout',
                    nonce: $('#workout_generator_nonce').val()
                },
                success: function(response) {
                    if (response.success) {
                        // Format and display the workout
                        const workout = response.data.workout;
                        let workoutHtml = '<div class="generated-workout">';
                        
                        // Add workout title and metadata
                        workoutHtml += `<h4>${workout.title || 'Your Custom Workout'}</h4>`;
                        if (workout.description) {
                            workoutHtml += `<p class="workout-description">${workout.description}</p>`;
                        }

                        // Add exercises
                        if (workout.exercises && workout.exercises.length) {
                            workoutHtml += '<div class="exercise-list">';
                            workout.exercises.forEach((exercise, index) => {
                                workoutHtml += `
                                    <div class="exercise-item">
                                        <span class="exercise-number">${index + 1}</span>
                                        <div class="exercise-details">
                                            <h5>${exercise.name}</h5>
                                            <p>${exercise.sets} sets × ${exercise.reps} reps</p>
                                            ${exercise.notes ? `<p class="exercise-notes">${exercise.notes}</p>` : ''}
                                        </div>
                                    </div>
                                `;
                            });
                            workoutHtml += '</div>';
                        }

                        // Add notes and recommendations
                        if (workout.notes) {
                            workoutHtml += `
                                <div class="workout-notes">
                                    <h5>Additional Notes</h5>
                                    <p>${workout.notes}</p>
                                </div>
                            `;
                        }

                        workoutHtml += '</div>';
                        
                        // Display the workout
                        $result.html(workoutHtml).slideDown();
                        
                        // Scroll to result
                        $('html, body').animate({
                            scrollTop: $result.offset().top - 50
                        }, 500);
                    } else {
                        // Show error message
                        $result.html(`
                            <div class="error-message">
                                ${response.data || 'Failed to generate workout. Please try again.'}
                            </div>
                        `).slideDown();
                    }
                },
                error: function() {
                    $result.html(`
                        <div class="error-message">
                            An error occurred. Please try again later.
                        </div>
                    `).slideDown();
                },
                complete: function() {
                    // Reset button state
                    $button.prop('disabled', false).text('Generate Workout');
                }
            });
        }
    };

    // Initialize the generator
    generator.init();
}); 