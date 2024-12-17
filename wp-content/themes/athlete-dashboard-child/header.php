<?php
/**
 * The header template
 */

if (!defined('ABSPATH')) {
    exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <header class="site-header">
        <nav class="main-navigation">
            <div class="site-branding">
                <h1 class="site-title">
                    <a href="<?php echo esc_url(home_url('/')); ?>">
                        <?php bloginfo('name'); ?>
                    </a>
                </h1>
            </div>

            <?php
            wp_nav_menu([
                'theme_location' => 'primary-menu',
                'container' => false,
                'menu_class' => 'primary-menu',
                'fallback_cb' => false,
            ]);
            ?>
        </nav>
    </header>

    <div id="content" class="site-content">
        <div class="container"><?php 