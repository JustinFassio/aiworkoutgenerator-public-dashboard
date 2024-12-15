<?php

if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

$dondivi_plugins = get_option( 'dondivi_plugins');

if (array_key_exists('DIVIMENUS_DD_ADMIN', $dondivi_plugins)) {
    unset($dondivi_plugins['DIVIMENUS_DD_ADMIN']);
    update_option('dondivi_plugins', $dondivi_plugins);
}

if (empty($dondivi_plugins)) {
    delete_option('dondivi_plugins');
    delete_option('dondivi_licenses');
}