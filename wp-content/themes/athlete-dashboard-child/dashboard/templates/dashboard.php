  <div class="nav-card" data-modal-trigger="training-persona-modal">
    <div class="card-icon">
      <span class="dashicons dashicons-universal-access"></span>
    </div>
    <div class="card-content">
      <h3>Training Persona</h3>
      <p>Customize your training experience and goals</p>
    </div>
  </div> 

  <!-- Profile Modal -->
  <div class="dashboard-modal" id="profile-modal">
    <div class="modal-backdrop"></div>
    <div class="modal-container" data-size="large">
      <div class="modal-header">
        <h2>Profile</h2>
        <button class="close-modal">
          <span class="dashicons dashicons-no-alt"></span>
        </button>
      </div>
      <div class="modal-body">
        <?php do_action('athlete_dashboard_profile_form'); ?>
      </div>
    </div>
  </div>

  <!-- Training Persona Modal -->
  <div class="dashboard-modal" id="training-persona-modal">
    <div class="modal-backdrop"></div>
    <div class="modal-container" data-size="large">
      <div class="modal-header">
        <h2>Training Persona</h2>
        <button class="close-modal">
          <span class="dashicons dashicons-no-alt"></span>
        </button>
      </div>
      <div class="modal-body">
        <?php do_action('athlete_dashboard_training_persona_form'); ?>
      </div>
    </div>
  </div> 