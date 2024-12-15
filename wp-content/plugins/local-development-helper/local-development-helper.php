<?php
/**
 * Plugin Name: Local Development Helper
 * Description: Helps with local development by bypassing certain security features
 * Version: 1.0.0
 * Author: Your Name
 */

if (!defined('ABSPATH')) {
    exit;
}

// Only run this in local development
if (!in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1', 'localhost'])) {
    return;
}

// Completely disable reCAPTCHA in local environment
add_filter('pre_option_wpcaptcha_options', function($value) {
    if (!is_array($value)) {
        $value = array();
    }
    
    // Disable all protection features
    $value['captcha'] = 'disabled';
    $value['login_protection'] = 0;
    $value['firewall_block_bots'] = 0;
    $value['captcha_site_key'] = '';
    $value['captcha_secret_key'] = '';
    
    return $value;
});

// Remove reCAPTCHA scripts in local environment
add_action('wp_print_scripts', function() {
    wp_dequeue_script('google-recaptcha');
    wp_dequeue_script('wpcaptcha-recaptcha');
}, 100);

// Bypass any remaining reCAPTCHA checks
add_filter('wpcaptcha_verify_recaptcha', '__return_true');
  