<?php

/*
Plugin Name:  DiviMenus
Plugin URI:   https://dondivi.com/divimenus/
Description:  A powerful menu builder that brings the coolest designs and popups to Divi! 
Version:      2.20.0
Author:       DonDivi
Author URI:   https://dondivi.com/
Update URI:   https://elegantthemes.com/
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
*/

if ( ! defined( 'ABSPATH' ) ) exit;

define('DIVIMENUS_DD_ADMIN', '1.0.2');
define('DIVIMENUS_PLUGIN_DIR_PATH', plugin_dir_path(__FILE__));
define('DIVIMENUS_PLUGIN_DIR_URL', plugin_dir_url(__FILE__));
define('DIVIMENUS_PLUGIN_PATH', __FILE__);
define('DIVIMENUS_VERSION', '2.20.0');

require_once plugin_dir_path( __FILE__ ) . 'includes/core.php';

function ddmenus_initialize_divimenus() {	
	require_once plugin_dir_path( __FILE__ ) . 'includes/divimenus-helper.php';
	require_once plugin_dir_path( __FILE__ ) . 'includes/divimenus.php';	
}
add_action( 'divi_extensions_init', 'ddmenus_initialize_divimenus' );