<?php
/**
 * Minimal Header Template
 * 
 * Provides a clean wrapper for the React dashboard without unnecessary WordPress elements.
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
<body <?php body_class('athlete-dashboard-page'); ?>>
    <?php wp_body_open(); ?>
    <div id="page" class="site">
        <div id="content" class="site-content"><?php 