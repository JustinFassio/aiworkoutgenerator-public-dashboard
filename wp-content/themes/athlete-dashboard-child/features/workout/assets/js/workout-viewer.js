jQuery(document).ready(function($) {
    const workoutViewer = {
        init: function() {
            this.viewer = $('.workout-viewer');
            if (this.viewer.length) {
                this.url = this.viewer.data('url');
                this.loadWorkout();
            }
        },

        loadWorkout: function() {
            const self = this;
            const data = {
                action: 'fetch_workout',
                url: this.url
            };

            $.ajax({
                url: ajaxurl,
                data: data,
                success: function(response) {
                    if (response.success) {
                        self.renderWorkout(response.data);
                    } else {
                        self.showError(response.data);
                    }
                },
                error: function(xhr, status, error) {
                    self.showError('Failed to load workout: ' + error);
                },
                complete: function() {
                    self.viewer.find('.workout-loading').hide();
                }
            });
        },

        renderWorkout: function(workout) {
            this.viewer.find('.workout-title').text(workout.title);
            
            // Render meta information
            const meta = [];
            if (workout.duration) meta.push(`Duration: ${workout.duration}`);
            if (workout.difficulty) meta.push(`Difficulty: ${workout.difficulty}`);
            if (workout.target) meta.push(`Target: ${workout.target}`);
            
            this.viewer.find('.workout-meta').html(meta.join(' | '));

            // Render exercises
            const exercises = workout.exercises.map(exercise => {
                return `
                    <div class="exercise-item">
                        <h3>${exercise.name}</h3>
                        <div class="exercise-details">
                            ${exercise.sets ? `<span>Sets: ${exercise.sets}</span>` : ''}
                            ${exercise.reps ? `<span>Reps: ${exercise.reps}</span>` : ''}
                            ${exercise.weight ? `<span>Weight: ${exercise.weight}</span>` : ''}
                            ${exercise.rest ? `<span>Rest: ${exercise.rest}</span>` : ''}
                        </div>
                        ${exercise.notes ? `<p class="exercise-notes">${exercise.notes}</p>` : ''}
                    </div>
                `;
            }).join('');

            this.viewer.find('.workout-exercises').html(exercises);
        },

        showError: function(message) {
            const error = this.viewer.find('.workout-error');
            error.html(message).show();
        }
    };

    workoutViewer.init();
}); 