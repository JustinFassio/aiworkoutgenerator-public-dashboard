<?php
if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="dashboard-card squat-progress-card" id="squat-progress">
    <!-- Card Header -->
    <div class="card-header">
        <h2 class="card-title">Squat Progress</h2>
        <div class="card-actions">
            <button type="button" class="add-entry-button" aria-label="Add new squat progress entry">
                <span class="button-icon">+</span>
                <span class="button-text">Add Entry</span>
            </button>
        </div>
    </div>

    <!-- Card Content -->
    <div class="card-content">
        <!-- Progress Chart -->
        <div class="chart-section">
            <canvas id="squatProgressChart"></canvas>
        </div>

        <!-- Recent Entries Table -->
        <div class="entries-section">
            <h3 class="section-title">Recent Entries</h3>
            <div class="table-container">
                <table class="progress-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Weight (kg)</th>
                            <th>Reps</th>
                            <th>Notes</th>
                            <th><span class="screen-reader-text">Actions</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data will be populated via JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Entry Dialog (Hidden by default) -->
    <dialog id="squatEntryDialog" class="entry-dialog" aria-labelledby="dialogTitle">
        <div class="dialog-content">
            <div class="dialog-header">
                <h3 id="dialogTitle">Add Squat Progress Entry</h3>
                <button type="button" class="close-dialog" aria-label="Close dialog">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form id="squatProgressForm" class="entry-form">
                <div class="form-group">
                    <label for="squatDate">Date</label>
                    <input type="date" id="squatDate" name="date" required>
                </div>
                
                <div class="form-group">
                    <label for="squatWeight">Weight (kg)</label>
                    <input type="number" id="squatWeight" name="weight" step="0.5" min="0" required>
                </div>
                
                <div class="form-group">
                    <label for="squatReps">Reps</label>
                    <input type="number" id="squatReps" name="reps" min="1" required>
                </div>
                
                <div class="form-group">
                    <label for="squatNotes">Notes</label>
                    <textarea id="squatNotes" name="notes" rows="3"></textarea>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="save-button">Save Entry</button>
                    <button type="button" class="cancel-button">Cancel</button>
                </div>
            </form>
        </div>
    </dialog>
</div> 