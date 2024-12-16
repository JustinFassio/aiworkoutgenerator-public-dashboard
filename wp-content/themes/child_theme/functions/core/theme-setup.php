<?php
/**
 * Theme Setup Functions
 * 
 * Handles core WordPress theme setup including:
 * - Theme support features
 * - Navigation menus
 * - Custom image sizes
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Add theme support for various WordPress features
 */
function athlete_dashboard_theme_setup() {
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
}
add_action('after_setup_theme', 'athlete_dashboard_theme_setup');

/**
 * Register navigation menus
 */
function athlete_dashboard_register_menus() {
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'athlete-dashboard'),
        'footer' => __('Footer Menu', 'athlete-dashboard'),
    ));
}
add_action('init', 'athlete_dashboard_register_menus');

/**
 * Add custom image sizes
 */
function athlete_dashboard_add_image_sizes() {
    add_image_size('profile-picture', 150, 150, true);
    add_image_size('workout-thumbnail', 300, 200, true);
}
add_action('after_setup_theme', 'athlete_dashboard_add_image_sizes'); 