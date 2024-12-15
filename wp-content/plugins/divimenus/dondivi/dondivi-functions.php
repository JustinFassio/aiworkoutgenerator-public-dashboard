<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! function_exists( 'dondivi_layout_shortcode' ) ){
    function dondivi_layout_shortcode( $atts, $content='' ) {

        $atts = shortcode_atts( array('id' => ''), $atts);
        return do_shortcode('[et_pb_section global_module="'.$atts['id'].'"][/et_pb_section]');
    }
    add_shortcode('dondivi_layout', 'dondivi_layout_shortcode');
}

if ( !function_exists( 'dondivi_get_plugins' ) ) {
    function dondivi_get_plugins() {
        $db_option = get_option( 'dondivi_plugins');
        if (!$db_option) return array();
        else return $db_option;
    }

    function dondivi_add_plugin($plugin, $name, $slug, $version, $file, $activation, $license, $license_ID) {
        $plugins = dondivi_get_plugins();
        if (!array_key_exists($plugin, $plugins) || 
        (array_key_exists($plugin, $plugins) && $plugins[$plugin]['license'] !== $license) || 
        (array_key_exists($plugin, $plugins) && $plugins[$plugin]['version'] !== $version)) {
            $plugins[$plugin] = array('name' => $name, 'slug' => $slug, 'version' => $version, 'file' => $file, 'activation' => $activation, 'license' => $license, 'license_id' => $license_ID);
            update_option('dondivi_plugins', $plugins);
        }
    } 

    function dondivi_latest_version () {

        $dondivi_version = '0.0.0';
        $plugins = dondivi_get_plugins();

        foreach ($plugins as $plugin => $value) {
            if ( defined($plugin) && version_compare(constant($plugin), $dondivi_version) >=0 ) {
                $dondivi_version = constant($plugin);
            }
        }
        return $dondivi_version;
    }

    function dondivi_include_edd_licenses_page() {
        $plugins = dondivi_get_plugins();
        foreach ($plugins as $plugin => $value) {
            if ( defined($plugin) && $value['license_id'])
                return true;
        }
        return false; // all plugins have been purchased on the Divi Marketplace
    }
}