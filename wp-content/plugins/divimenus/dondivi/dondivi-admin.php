<?php

if ( ! defined( 'ABSPATH' ) ) exit;

function dondivi_check_divi() {
    $dd_themes = array('Divi', 'Extra');
    return in_array(wp_get_theme()->Name, $dd_themes) || in_array(wp_get_theme()->Template, $dd_themes) || in_array( apply_filters('divi_ghoster_ghosted_theme', null), $dd_themes);
}

function dondivi_get_options() {
    $output = array();
    try {
        $options= get_option( 'dondivi_options');        
        $output = array(
            'vb_quick_link' => isset($options['vb_quick_link']) ? $options['vb_quick_link'] : 1,
            'dl_shortcodes' => isset($options['dl_shortcodes']) ? $options['dl_shortcodes'] : 1,
        );   
    } catch( Exception $e ) {}
    return $output;
}

require_once(plugin_dir_path(__FILE__) . 'dondivi-license.php');

function dondivi_add_settings_submenu() {
    global $admin_page_hooks;
    
    if ( empty ( $admin_page_hooks['dondivi_main_menu'] ) ) {  
        add_menu_page(
            'DonDivi',
            'DonDivi',
            'manage_options',
            'dondivi_main_menu',
            'dondivi_main_page',
            plugin_dir_url(__FILE__) . 'assets/dondivi-icon.png',
            199 
        );
        if (dondivi_include_edd_licenses_page())
            add_submenu_page( 
                'dondivi_main_menu',
                __('DonDivi Licensing Page', 'divimenus'),
                __('Licenses', 'divimenus'),
                'manage_options', 'dondivi_license', 'dondivi_license_page');
    }         
}
add_action( 'admin_menu', 'dondivi_add_settings_submenu');

function dondivi_admin_enqueue_scripts($hook) {
    // phpcs:ignore WordPress.Security.NonceVerification.Recommended
    if ($hook ==='dondivi_page_dondivi_license' || ( isset($_GET['post_type']) && $_GET['post_type'] === 'et_pb_layout' ) )
        wp_enqueue_script( 'dondivi-admin', plugin_dir_url(__FILE__) . 'assets/dondivi-admin.min.js', array( 'jquery' ), false, true);
    if ($hook !== 'toplevel_page_dondivi_main_menu' && $hook !== 'dondivi_page_dondivi_license') {
        return;
    } 
    wp_enqueue_style( 'dondivi-admin', plugin_dir_url(__FILE__) . 'assets/dondivi-admin.css' );
}
add_action( 'admin_enqueue_scripts', 'dondivi_admin_enqueue_scripts' );

function dondivi_main_page () { 

    $options = dondivi_get_options(); ?>
    
    <div class="dd-admin-page"> 

        <div class="dd-admin-row"> <?php
            if ( !dondivi_check_divi() ) { ?>
                <div class="notice notice-info is-dismissible"> 
                    <p><strong><?php esc_attr_e('Divi is required. Please install and activate the Divi theme in order to use this plugin', 'divimenus') ?></strong></p>
                </div>
                <div class="dd-admin-col-70 dd-admin-title-image" style="text-align:center; padding-top:50px;">
                    <img src="https://dondivi-public-images.s3.eu-west-3.amazonaws.com/DonDivi+Loves+Divi.png" alt="DonDivi LOVES Divi"/>
                </div></div></div><?php
                return;
            }

            if (isset($_POST['submit_add_ons'])) {

                check_admin_referer( 'dondivi_add_ons' );
        
                $options['vb_quick_link'] = isset( $_POST['vb_quick_link']) ? 1 : 0; 
                $options['dl_shortcodes'] = isset( $_POST['dl_shortcodes']) ? 1 : 0;
                
                update_option( 'dondivi_options', $options ); 
        
                printf('<div id="message" class="updated fade notice is-dismissible"><p><strong>%s</strong></p></div>',
                    esc_attr__('Settings saved', 'divimenus'));
            } ?>

            <div class="dd-admin-title">
                <div class="dd-admin-title-image">
                    <img src="https://dondivi-public-images.s3.eu-west-3.amazonaws.com/DonDivi.png" alt="DonDivi"/>
                </div>
            </div> 
        </div>    

        <div class="dd-admin-row"> 
              
            <div class="dd-admin-col-2 dd-admin-col-first">
                <form method="post">
                    <?php wp_nonce_field( 'dondivi_add_ons' ); ?>
                    <div id="dd-add-ons" class="dd-admin-box">
                        <div class="dd-admin-box-header">
                            <h3 class="dd-admin-box-header-title"> <?php esc_html_e('DonDivi Extra Tools', 'divimenus') ?> </h3>
                        </div> 
                        <div class="dd-admin-box-content">  
                            <div class="dd-switch-container">                  
                                <label class="dd-switch">
                                    <input type="checkbox" name="vb_quick_link" <?php checked( $options['vb_quick_link'] ); ?>>
                                    <span class="dd-slider"></span>
                                </label>
                                <span class="dd-switch-option">Visual Builder quick-link</span>
                                <div class="dd-admin-tooltip">
                                    <span data-tooltip="<?php esc_attr_e('Inserts a quick link to the Visual Builder below the titles of your pages, posts and layouts.', 'divimenus')?>">
                                </div>
                            </div>   
                            <p>     
                                <div class="dd-switch-container">                  
                                    <label class="dd-switch">
                                        <input type="checkbox" name="dl_shortcodes" <?php checked( $options['dl_shortcodes'] ); ?>> 
                                        <span class="dd-slider"></span>
                                    </label>
                                    <span class="dd-switch-option">Layouts Shortcodes</span>
                                    <div class="dd-admin-tooltip">
                                        <span data-tooltip="<?php esc_attr_e('This tool provides you a shortcode for each Divi Library layout so that you can use it in your modules.', 'divimenus')?>"></span>
                                    </div>
                                </div>
                            </p>                    
                        </div>
                    </div>
                    <?php submit_button(__('Save changes', 'divimenus'), 'dd-submit', 'submit_add_ons'); ?>
                </form>
            </div>

            <?php $license_page = dondivi_include_edd_licenses_page() ?>
            <div class="dd-admin-col-2 dd-admin-col">
                <div id ="dd-links" class="dd-admin-box">
                    <div class="dd-admin-box-header">
                        <h3 class="dd-admin-box-header-title"> <?php esc_html_e('Help Center', 'divimenus') ?> </h3>
                    </div> 
                    <div class="dd-admin-box-content<?php echo $license_page ? ' dd-license-page' : ''?>"> 
                        <ul>
                            <li id="dd-documentation"><a href="https://dondivi.com/documentation" target="_blank"><?php esc_html_e('Documentation', 'divimenus') ?></a></li>
                            <li id="dd-support"><a href="https://dondivi.com/support" target="_blank"><?php esc_html_e('Support', 'divimenus') ?></a></li>
                            <li id="dd-layouts"><a href="https://dondivi.com/download-layouts/" target="_blank"><?php esc_html_e('DonDivi Layouts', 'divimenus') ?></a></li>
                            <?php if ($license_page) : ?>
                                <li id="dd-licenses"><a href="<?php menu_page_url( 'dondivi_license' );?>"><?php esc_html_e('Licenses', 'divimenus') ?></a></li>
                            <?php endif; ?>
                        </ul>               
                    </div>
                </div>
            </div>
        </div>

        <div style="clear: both;"></div>

        <div class="dd-admin-row-inner dd-admin-footer">
            <p> 
                <strong><a href="https://dondivi.com" target="_blank">&copy; DonDivi</a> | <?php esc_html_e('From Spain with ', 'divimenus') ?><span style="color:#da404a">&hearts;</span></strong>  
            </p>
        </div>
    </div> <!--  dd-admin-page --> <?php
}

if ( ! function_exists( 'dondivi_admin_init' ) ) {
    function dondivi_admin_init() {

        $options= dondivi_get_options();
        if ($options['vb_quick_link']) {

            function dondivi_gutenberg( $post ) {
                if ( function_exists( 'gutenberg_can_edit_post' ) ) {
                    return gutenberg_can_edit_post( $post );
                }
                if ( ! function_exists( 'use_block_editor_for_post' ) ) {
                    return false;
                }
                return  use_block_editor_for_post( $post );
            }
            
            function dondivi_row_actions_add_divi_builder( $actions, $post ) {
                
                $post_id = $post->ID;
                $is_divi_library = 'et_pb_layout' === get_post_type( $post_id );               
                
                if ((function_exists( 'et_builder_enabled_for_post_type') && et_builder_enabled_for_post_type( $post->post_type )) || $is_divi_library) { 
                    
                    $edit_url = get_permalink( $post_id );
                    
                    if ( et_pb_is_pagebuilder_used( $post_id ) ) {
                        $edit_url = add_query_arg( 'et_fb', '1', et_fb_prepare_ssl_link( $edit_url ) );
                    } else {
                        if ( ! et_pb_is_allowed( 'divi_builder_control' ) ) {
                            return $actions;
                        }
                        $edit_url = add_query_arg(
                            array(
                                'et_fb_activation_nonce' => wp_create_nonce( 'et_fb_activation_nonce_' . $post_id ),
                            ),
                            $edit_url
                        );
                    }

                    $use_divi_builder = sprintf('<span id="dd_fb_cta" style="background-color: #ba4cff"><a style="color: #fff" href="%1$s">&nbsp;&nbsp;%2$s&nbsp;&nbsp;</a></span>%3$s',
                    esc_url( $edit_url ),
                    esc_html__( 'Use Visual Builder', 'et_builder' ),
                    '<style> #dd_fb_cta:hover { opacity: 0.9;} </style>');
                    
                    $actions = array('use_divi_builder' => $use_divi_builder) + $actions;
                    
                    if (dondivi_gutenberg($post)) {
                       unset($actions['divi']);
                    }
                } 
                return $actions;
            }
            add_filter( 'post_row_actions', 'dondivi_row_actions_add_divi_builder', 999, 2);
            add_filter( 'page_row_actions', 'dondivi_row_actions_add_divi_builder', 999, 2);
        }
        
        if ($options['dl_shortcodes']) {

            function dondivi_add_divi_library_shortcode_column($columns) {
                $columns['dondivi_shortcode'] = __('DonDivi shortcode', 'divimenus');
                return $columns;
            }
            add_filter( 'manage_et_pb_layout_posts_columns', 'dondivi_add_divi_library_shortcode_column', 5 );
        
            function dondivi_add_divi_library_shortcode_column_content($column, $post_id) {
                if ($column === 'dondivi_shortcode') {
                    printf('<span class="dd-copy"></span><span>[dondivi_layout id="%s"]</span><span class="dd-success"></span>', esc_attr($post_id));
                }
            }
            add_action( 'manage_et_pb_layout_posts_custom_column', 'dondivi_add_divi_library_shortcode_column_content', 5, 2 );
        }        
    }
}
add_action( 'admin_init', 'dondivi_admin_init' );

function dondivi_admin_head() {
    // phpcs:ignore WordPress.Security.NonceVerification.Recommended
    if (isset($_GET['post_type']) && $_GET['post_type'] === 'et_pb_layout') { ?>
        <style>
            #dondivi_shortcode, .dondivi_shortcode { text-align: center; }
            .dd-copy:before {
                font-family: 'ETModules';
                content: "\e016";
                cursor: pointer;
                display: block;
                font-size: 145%;
                font-weight: bolder;
                color: #96D000;
            }
            .dd-copy:hover:before { opacity: 0.5 }
            .dd-success {
                display: none;
                position: fixed;
                top: 50%;
                left: 50%;
                width: 50px;
                height: 50px;
                border-radius: 50px;
                background-color: rgb(169, 233, 0);
                /* z-index: 999999; opacity: 1; */
            }
            .dd-success:before {
                font-family: 'etbuilder';
                content: '\2713';
                color: rgb(255, 255, 255);
                font-size: 22px;
                line-height: 50px;
            }
        </style> <?php
    }
}
add_action( 'admin_head', 'dondivi_admin_head' );