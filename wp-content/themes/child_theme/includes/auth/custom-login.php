<?php
/*
Template Name: Custom Login
*/

// Redirect if user is already logged in
if (is_user_logged_in()) {
    wp_redirect(home_url('/athlete-dashboard'));
    exit;
}

get_header();

// Define reCAPTCHA v3 site key
$recaptcha_site_key = '6Lc1Ly0qAAAAAF37K-Y8vkcCJQsiPrGADWD4T137';
?>

<div class="athlete-dashboard login-page">
    <div class="auth-form login-form">
        <h2><?php echo esc_html__('Login', 'athlete-dashboard'); ?></h2>
        <form id="login-form">
            <div class="form-group">
                <label for="username"><?php echo esc_html__('Username or Email', 'athlete-dashboard'); ?></label>
                <input type="text" name="username" id="username" required>
            </div>
            <div class="form-group">
                <label for="password"><?php echo esc_html__('Password', 'athlete-dashboard'); ?></label>
                <input type="password" name="password" id="password" required>
            </div>
            <div class="form-group">
                <label>
                    <input type="checkbox" name="remember" id="remember">
                    <?php echo esc_html__('Remember Me', 'athlete-dashboard'); ?>
                </label>
            </div>
            <?php wp_nonce_field('custom_login_nonce', 'login_nonce'); ?>
            <div class="form-group">
                <input type="submit" value="<?php echo esc_attr__('Login', 'athlete-dashboard'); ?>" class="custom-button">
            </div>
        </form>
        <div id="login-message"></div>
        <p class="register-link">
            <?php echo esc_html__('Don\'t have an account?', 'athlete-dashboard'); ?> 
            <a href="<?php echo esc_url(home_url('/register')); ?>"><?php echo esc_html__('Register here', 'athlete-dashboard'); ?></a>
        </p>
    </div>
</div>

<script>
jQuery(document).ready(function($) {
    $('#login-form').on('submit', function(e) {
        e.preventDefault();
        grecaptcha.ready(function() {
            grecaptcha.execute('<?php echo esc_js($recaptcha_site_key); ?>', {action: 'login'}).then(function(token) {
                var formData = $('#login-form').serialize() + '&action=custom_ajax_login&recaptcha_token=' + token;
                $.ajax({
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            window.location.href = '<?php echo home_url('/athlete-dashboard'); ?>';
                        } else {
                            $('#login-message').html('<p class="error">' + response.data + '</p>');
                        }
                    }
                });
            });
        });
    });
});
</script>

<?php get_footer(); ?>
