<?php if ( ! defined( 'ABSPATH' ) ) exit;

define('DIVIMENUS_PLACEHOLDER_IMAGE_DATA', 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNTQwIiBoZWlnaHQ9IjU0MCIgdmlld0JveD0iMCAwIDU0MCA1NDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CiAgICA8ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPgogICAgICAgIDxwYXRoIGZpbGw9IiNFQkVCRUIiIGQ9Ik0wIDBoMTA4MHY1NDBIMHoiLz4KICAgICAgICA8cGF0aCBkPSJNNDQ1LjY0OSA1NDBoLTk4Ljk5NUwxNDQuNjQ5IDMzNy45OTUgMCA0ODIuNjQ0di05OC45OTVsMTE2LjM2NS0xMTYuMzY1YzE1LjYyLTE1LjYyIDQwLjk0Ny0xNS42MiA1Ni41NjggMEw0NDUuNjUgNTQweiIgZmlsbC1vcGFjaXR5PSIuMSIgZmlsbD0iIzAwMCIgZmlsbC1ydWxlPSJub256ZXJvIi8+CiAgICAgICAgPGNpcmNsZSBmaWxsLW9wYWNpdHk9Ii4wNSIgZmlsbD0iIzAwMCIgY3g9IjMzMSIgY3k9IjE0OCIgcj0iNzAiLz4KICAgICAgICA8cGF0aCBkPSJNMTA4MCAzNzl2MTEzLjEzN0w3MjguMTYyIDE0MC4zIDMyOC40NjIgNTQwSDIxNS4zMjRMNjk5Ljg3OCA1NS40NDZjMTUuNjItMTUuNjIgNDAuOTQ4LTE1LjYyIDU2LjU2OCAwTDEwODAgMzc5eiIgZmlsbC1vcGFjaXR5PSIuMiIgZmlsbD0iIzAwMCIgZmlsbC1ydWxlPSJub256ZXJvIi8+CiAgICA8L2c+Cjwvc3ZnPgo=');

function ddmenus_plugins_loaded() {
    require_once(DIVIMENUS_PLUGIN_DIR_PATH . 'dondivi/dondivi-functions.php');
    dondivi_add_plugin('DIVIMENUS_DD_ADMIN', 'DiviMenus', 'divimenus' , DIVIMENUS_VERSION, DIVIMENUS_PLUGIN_PATH, true, 'divimenus', 0);
}
add_action( 'plugins_loaded', 'ddmenus_plugins_loaded' );

function ddmenus_init() {
    if ( is_admin() && constant('DIVIMENUS_DD_ADMIN') === dondivi_latest_version() && !function_exists( 'dondivi_main_page' ) ) {
        require_once(DIVIMENUS_PLUGIN_DIR_PATH . 'dondivi/dondivi-admin.php');       
    }
}
add_action( 'init', 'ddmenus_init' );

function ddmenus_admin_init() {
    if (!term_exists( 'DiviMenus', 'layout_category' ) ){
        wp_insert_term( 'DiviMenus', 'layout_category' );
    }
}
add_action( 'admin_init', 'ddmenus_admin_init');

function ddmenus_admin_head() { ?>
    <style>    
        .et_fb_divimenus .et-fb-icon--svg, .et_fb_divimenus_flex .et-fb-icon--svg {
            height: auto!important;
            margin: 0px 0px 5px !important; 
        }
        .et_fb_divimenus.et-fb-has-svg-icon.et_fb_global .et-fb-icon--svg path {
            stroke: #FFF !important;
        }
    </style> <?php
}
add_action( 'admin_head-divi_page_et_theme_builder', 'ddmenus_admin_head');