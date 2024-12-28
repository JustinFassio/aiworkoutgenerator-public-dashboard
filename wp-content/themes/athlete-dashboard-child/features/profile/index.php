<?php
/**
 * Profile Feature
 * 
 * Initializes the profile feature and sets up necessary hooks.
 */

namespace AthleteDashboard\Features\Profile;

use AthleteDashboard\Features\Profile\Components\Profile;

if (!defined('ABSPATH')) {
    exit;
}

// Load the Profile class
require_once __DIR__ . '/components/Profile.php';

// Initialize the feature
Profile::register(); 