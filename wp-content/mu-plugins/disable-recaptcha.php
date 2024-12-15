<?php
/**
 * Plugin Name: Disable reCAPTCHA (Local Development)
 * Description: Forces reCAPTCHA to be disabled in local development
 * Version: 1.0
 */

if (!defined('ABSPATH')) {
    exit;
}

// Force disable reCAPTCHA
add_filter('option_wpcaptcha_options', function($value) {
    return array(
        'captcha' => 'disabled',
        'login_protection' => 0,
        'firewall_block_bots' => 0
    );
}, 1);

// Remove reCAPTCHA scripts
add_action('wp_print_scripts', function() {
    wp_dequeue_script('google-recaptcha');
    wp_dequeue_script('wpcaptcha-recaptcha');
}, 100);

// Force successful verification
add_filter('wpcaptcha_verify_recaptcha', '__return_true', 1);
 