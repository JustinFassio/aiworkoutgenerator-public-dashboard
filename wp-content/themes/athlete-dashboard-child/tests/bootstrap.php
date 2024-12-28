<?php
/**
 * PHPUnit bootstrap file for WordPress theme testing
 */

// First, load Composer's autoloader
require_once dirname(__DIR__) . '/vendor/autoload.php';

// Define WordPress test constants
define('ABSPATH', dirname(__DIR__) . '/wp-content/');
define('WP_DEBUG', true);
define('WP_CONTENT_DIR', ABSPATH . 'wp-content');
define('WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins');
define('WPMU_PLUGIN_DIR', WP_CONTENT_DIR . '/mu-plugins');

// Load WordPress test environment
require_once dirname(__DIR__) . '/vendor/wordpress/wordpress-mock/src/WP_Mock.php';

// Initialize WP_Mock
WP_Mock::setUsePatchwork(true);
WP_Mock::bootstrap();

// Load test helpers
require_once __DIR__ . '/TestCase.php';
require_once __DIR__ . '/FeatureTestCase.php';
require_once __DIR__ . '/IntegrationTestCase.php';
 