<?php

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'DD_LICENSING_STORE_URL', 'https://dondivi.com' );

function dondivi_license_page () {
    $plugins = dondivi_get_plugins();
    $licenses = get_option( 'dondivi_licenses' ); ?>
    
    <div class="dd-admin-page">
        <div class="dd-admin-row"> <?php
            if ( !dondivi_check_divi() ) { ?>
                <div class="notice notice-info is-dismissible"> 
                    <p><strong><?php esc_html_e('Divi is required. Please install and activate Divi in order to use this plugin', 'divimenus') ?></strong></p>
                </div>
                <div class="dd-admin-col-70 dd-admin-title-image" style="text-align:center; padding-top:50px;">
                    <img src="https://dondivi-public-images.s3.eu-west-3.amazonaws.com/DonDivi+Loves+Divi.png" alt="DonDivi LOVES Divi"/>
                </div></div></div><?php
                return;
            }
            
            foreach ($plugins as $plugin_key => $plugin_value) {
                if ( defined($plugin_key) ) {
                    // phpcs:ignore WordPress.Security.NonceVerification.Missing - nonce verification later
                    if (isset($_POST['dd-'.$plugin_value['slug'].'-license-activate']))
                        dondivi_activate_license($licenses, $plugin_value);
                    // phpcs:ignore WordPress.Security.NonceVerification.Missing - nonce verification later
                    else if (isset($_POST['dd-'.$plugin_value['slug'].'-license-deactivate']))
                        dondivi_deactivate_license($licenses, $plugin_value);
                    // phpcs:ignore WordPress.Security.NonceVerification.Missing - nonce verification later
                    else if (isset($_POST['dd-'.$plugin_value['slug'].'-license-check']))
                        dondivi_check_license($licenses, $plugin_value);
                }
            } ?>

            <div class="dd-admin-title">
                <div class="dd-admin-title-image">
                    <img src="https://dondivi-public-images.s3.eu-west-3.amazonaws.com/DonDivi.png" alt="DonDivi"/>
                </div>
            </div>
        </div>

        <?php foreach ($plugins as $plugin => $value): ?>
            <?php if ( defined($plugin) && $value['license_id']) : ?>
                <div class="dd-admin-row">  
                    <div class="dd-admin-col-70">
                        <div class="dd-admin-box">
                            <div class="dd-admin-box-header">
                                <h3 class="dd-admin-box-header-title"> <?php echo et_core_intentionally_unescaped($value['name'], 'fixed_string') ?> </h3>
                            </div> 
                            <div class="dd-admin-box-content">     
                                <form method="post" class="dd-license">
                                    <?php wp_nonce_field( 'dondivi_licenses_nonce' ); ?>
                                    <?php $key    = isset($licenses[$value['slug']]) ? $licenses[$value['slug']]['key'] : ''; ?>
                                    <?php $status = isset($licenses[$value['slug']]) ? $licenses[$value['slug']]['status'] : ''; ?> 
                                    <div class="dd-license-key">
                                        <p>
                                            <input id="<?php echo 'dd-'.et_core_intentionally_unescaped($value['slug'], 'fixed_string').'-license-key' ?>" 
                                            name="<?php echo et_core_intentionally_unescaped($value['slug'], 'fixed_string') ?>" type="password" 
                                            value="<?php esc_attr_e( $key); ?>" placeholder="<?php esc_attr_e('License key', 'divimenus');?>"/>
                                            <span class="dd-license-key-toggle dd-lock"></span>
                                        </p>
                                    </div>
                                    <div class="dd-license-button">
                                        <?php if( $status === 'valid' ) { ?>
                                            <input type="submit" name="dd-<?php echo et_core_intentionally_unescaped($value['slug'], 'fixed_string')?>-license-deactivate" class="button dd-submit dd-deactivate" value="<?php esc_attr_e('Deactivate', 'divimenus'); ?>"/>
                                        <?php } else { ?>
                                            <input type="submit" name="dd-<?php echo et_core_intentionally_unescaped($value['slug'], 'fixed_string')?>-license-activate" class="button dd-submit" value="<?php esc_attr_e('Activate', 'divimenus'); ?>"/>
                                        <?php } ?>
                                        <button type="submit" name="dd-<?php echo et_core_intentionally_unescaped($value['slug'], 'fixed_string')?>-license-check" class="button dd-submit dd-check" title="<?php esc_attr_e('Check license', 'divimenus'); ?>"><span></span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div style="clear: both;"></div>                        
                    </div>
                </div> 
            <?php endif; ?>
        <?php endforeach; ?>
        <div class="dd-admin-row-inner dd-admin-footer">
            <div class="dd-admin-col-70">
                <p> 
                    <strong><a href="https://dondivi.com" target="_blank">&copy; DonDivi</a> | <?php esc_html_e('From Spain with ', 'divimenus') ?><span style="color:#da404a">&hearts;</span></strong>  
                </p>                                      
            </div>
        </div>
    </div> <?php  
}

function dondivi_check_license(&$licenses, $plugin) {
    check_admin_referer( 'dondivi_licenses_nonce' );
    
    if (isset($_POST[$plugin['slug']])) {
        // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.MissingUnslash
        $license = sanitize_text_field($_POST[$plugin['slug']]); // license key

        $api_params = array(
            'edd_action' => 'check_license',
            'license'   => $license,
            'item_name' => $plugin['license'],
            'url'       => home_url()
        );

        $response = wp_remote_post( DD_LICENSING_STORE_URL, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );

        if ( is_wp_error( $response ) )
            return;

        $license_data = json_decode( wp_remote_retrieve_body( $response ) );

        if( $license_data->license === 'valid' ) {
            $message = __( 'This license is active for this URL.', 'divimenus' );
        } else {
            $message = __( 'This license is not active for this URL.', 'divimenus' );
        }
        if ( ! empty( $message ) ) {
            printf('<div id="message" class="updated fade notice is-dismissible"><p><strong>%s</strong></p></div>', esc_html($message));
        }

        if ( $license_data->license === 'invalid' ) {
            $licenses[$plugin['slug']] = array( 'key' => $license, 'status' => $license_data->license);
            update_option( 'dondivi_licenses', $licenses );
        }
    }
}

function dondivi_activate_license(&$licenses, $plugin) { 
    check_admin_referer( 'dondivi_licenses_nonce' );

    if (isset($_POST[$plugin['slug']])) {
        // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.MissingUnslash
        $license = sanitize_text_field($_POST[$plugin['slug']]); // license key

        // data to send in our API request
        $api_params = array(
            'edd_action' => 'activate_license',
            'license'    => $license,
            'item_name'  => $plugin['license'],
            'url'        => home_url()
        );

        // Call the custom API.
        $response = wp_remote_post( DD_LICENSING_STORE_URL, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );

        // make sure the response came back okay
        if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {

            if ( is_wp_error( $response ) ) {
                $message = $response->get_error_message();
            } else {
                $message = __( 'An error occurred, please try again.', 'divimenus' );
            }

        } else {

            $license_data = json_decode( wp_remote_retrieve_body( $response ) );

            if ( false === $license_data->success ) {
                switch( $license_data->error ) {
                    case 'expired' :
                        $message = sprintf(
                            __( 'Your license key expired on %s.', 'divimenus' ),
                            date_i18n( get_option( 'date_format' ), strtotime( $license_data->expires, current_time( 'timestamp' ) ) )
                        );
                        break;
                    case 'disabled' :
                    case 'revoked' :
                        $message = __( 'Your license key has been disabled.', 'divimenus' );
                        break;
                    case 'missing' :
                        $message = __( 'Invalid license.', 'divimenus' );
                        break;
                    case 'invalid' :
                    case 'site_inactive' :
                        $message = __( 'Your license is not active for this URL.', 'divimenus' );
                        break;
                    case 'item_name_mismatch' :
                        $message = sprintf( __( 'This appears to be an invalid license key', 'divimenus' ));
                        break;
                    case 'no_activations_left':
                        $message = __( 'Your license key has reached its activation limit.', 'divimenus' );
                        break;
                    default :
                        $message = __( 'An error occurred, please try again.', 'divimenus' );
                        break;
                }
            }
        }
    
        if ( ! empty( $message ) ) {
            printf('<div id="message" class="updated fade notice is-dismissible"><p><strong>%s</strong></p></div>', esc_html($message));
            return;
        } else { // license activated successfully
            $message = __( 'You have activated your license.', 'divimenus');
            printf('<div id="message" class="updated fade notice is-dismissible"><p><strong>%s</strong></p></div>', esc_html($message));
        }

        // $license_data->license will be either "valid" or "invalid"
        $licenses[$plugin['slug']] = array( 'key' => $license, 'status' => $license_data->license);
        update_option( 'dondivi_licenses', $licenses );
    }
}

function dondivi_deactivate_license(&$licenses, $plugin) {
    check_admin_referer( 'dondivi_licenses_nonce' );

    if (isset($_POST[$plugin['slug']])) {
        // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.MissingUnslash
        $license = sanitize_text_field($_POST[$plugin['slug']]); // license key

        $api_params = array(
            'edd_action' => 'deactivate_license',
            'license'    => $license,
            'item_name'  => $plugin['license'],
            'url'        => home_url()
        );

        $response = wp_remote_post( DD_LICENSING_STORE_URL, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );

        if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {

            if ( is_wp_error( $response ) ) {
                $message = $response->get_error_message();
            } else {
                $message = __( 'An error occurred, please try again.' );
            }
            printf('<div id="message" class="updated fade notice is-dismissible"><p><strong>%s</strong></p></div>', esc_html($message));
            return;
        }

        $message = __('You have deactivated your license. Remember that you need an active license to get automatic upgrades and support.', 'divimenus');
        printf('<div id="message" class="updated fade notice is-dismissible"><p><strong>%s</strong></p></div>', esc_html($message));

        $license_data = json_decode( wp_remote_retrieve_body( $response ) );

        // $license_data->license will be either "deactivated" or "failed"
        $licenses[$plugin['slug']] = array( 'key' => $license, 'status' => $license_data->license);
        update_option( 'dondivi_licenses', $licenses );
    }
}