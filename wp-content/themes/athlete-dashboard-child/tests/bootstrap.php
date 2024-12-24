<?php
/**
 * PHPUnit bootstrap file
 */

// First, let's set up the base path
define('ATHLETE_DASHBOARD_TEST_DIR', __DIR__);
define('ATHLETE_DASHBOARD_THEME_DIR', dirname(__DIR__));

// Composer autoloader must be loaded before WP_MOCK
require_once dirname(__DIR__) . '/vendor/autoload.php';

// Load WP Mock
WP_Mock::bootstrap();

// Load Brain Monkey
require_once dirname(__DIR__) . '/vendor/brain/monkey/inc/patchwork-loader.php';

// Load test helpers and custom test case classes
require_once __DIR__ . '/TestCase.php';

// Set up mock functions that we'll use frequently
function __return_true() { return true; }
function __return_false() { return false; }
function __return_null() { return null; }
function __return_empty_array() { return []; }
function __return_empty_string() { return ''; }
 