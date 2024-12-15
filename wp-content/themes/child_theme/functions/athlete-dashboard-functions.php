<?php
// functions/athlete-dashboard-functions.php

/**
 * Handle user registration form submission
 */
function handle_registration_form() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register_nonce']) && wp_verify_nonce($_POST['register_nonce'], 'custom_register_nonce')) {
        $recaptcha_token = isset($_POST['recaptcha_token']) ? $_POST['recaptcha_token'] : '';
        
        if (empty($recaptcha_token)) {
            wp_die('reCAPTCHA verification failed. Token is missing.');
        }
        
        if (!verify_recaptcha_v3($recaptcha_token)) {
            wp_die('reCAPTCHA verification failed. Please try again.');
        }
        
        // Proceed with user registration
        $username = sanitize_user($_POST['username']);
        $email = sanitize_email($_POST['email']);
        $password = $_POST['password'];
        $first_name = sanitize_text_field($_POST['first_name']);
        $last_name = sanitize_text_field($_POST['last_name']);

        $user_id = wp_create_user($username, $password, $email);

        if (is_wp_error($user_id)) {
            // Handle registration error
            wp_die($user_id->get_error_message());
        } else {
            // Update user meta
            wp_update_user(array(
                'ID' => $user_id,
                'first_name' => $first_name,
                'last_name' => $last_name
            ));

            // Log the user in
            wp_set_current_user($user_id);
            wp_set_auth_cookie($user_id);

            // Redirect to dashboard
            wp_redirect(home_url('/athlete-dashboard'));
            exit;
        }
    }
}

// Hook the registration form handler to WordPress init
add_action('init', 'handle_registration_form');

/**
 * Verify reCAPTCHA v3 response
 *
 * @param string $token The reCAPTCHA v3 token to verify
 * @return boolean True if verification succeeds, false otherwise
 */
function verify_recaptcha_v3($token) {
    $secret_key = '6Lc1Ly0qAAAAAONPgobQXpe4duibuganLcCJFnjs';
    $verify_url = 'https://www.google.com/recaptcha/api/siteverify';

    $response = wp_remote_post($verify_url, array(
        'body' => array(
            'secret' => $secret_key,
            'response' => $token
        )
    ));

    if (is_wp_error($response)) {
        return false;
    }

    $result = json_decode(wp_remote_retrieve_body($response));
    return ($result->success && $result->score >= 0.5);
}

// Enqueue reCAPTCHA script
function enqueue_recaptcha_script() {
    wp_enqueue_script('recaptcha', 'https://www.google.com/recaptcha/api.js?render=6Lc1Ly0qAAAAAF37K-Y8vkcCJQsiPrGADWD4T137', array(), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_recaptcha_script');

// Handle AJAX login
function custom_ajax_login() {
    check_ajax_referer('custom_login_nonce', 'login_nonce');

    $username = sanitize_user($_POST['username']);
    $password = $_POST['password'];
    $remember = isset($_POST['remember']) ? true : false;
    $recaptcha_token = $_POST['recaptcha_token'];

    if (empty($recaptcha_token) || !verify_recaptcha_v3($recaptcha_token)) {
        wp_send_json_error('reCAPTCHA verification failed. Please try again.');
    }

    $user = wp_signon(
        array(
            'user_login' => $username,
            'user_password' => $password,
            'remember' => $remember
        ),
        is_ssl()
    );

    if (is_wp_error($user)) {
        wp_send_json_error($user->get_error_message());
    } else {
        wp_send_json_success('Login successful');
    }
}
add_action('wp_ajax_nopriv_custom_ajax_login', 'custom_ajax_login');

// Add any other functions related to the athlete dashboard below this line