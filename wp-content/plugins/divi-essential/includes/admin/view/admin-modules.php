<?php

defined( 'ABSPATH' ) || die();

$modules             = self::get_modules_map();
$inactive_modules    = self::get_inactive_modules();
$total_modules_count = count( $modules );
?>

<div class="dnxte-admin-panel">
	<div class="dnxte-modules-body">
        <form class="dnxte-modules-admin" id="dnxte-admin-modules-form">
            <div class="dnxte-row dnxte-pad-30">
                <div class="dnxte-col">
                    <div class="dnxte-admin-button-panel top-button">
                        <button disabled class="dnxte-btn dnxte-btn-save dnxte-btn-lg dnxte-ext-switch" type="submit">
                            <?php esc_html_e( 'Save Settings', 'dnxte-divi-essential' ); ?>
                        </button>
                    </div>
                </div>
            </div>
            <div class="dnxte-row dnxte-pad-30">
                <div class="dnxte-col">
                    <div class="dnxte-modules-filter-search">
                        <input id="dnxte-modules-filter-search-input" type="text" placeholder="<?php echo esc_attr__('Search Modules', 'dnxte-divi-essential') ?>">
                        <div class="dnxte-modules-filter-search-icon">
                            <svg width="19" height="19" viewBox="0 0 19 19" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3.075 3.075a7.5 7.5 0 0110.95 10.241l3.9 3.902a.5.5 0 01-.707.707l-3.9-3.901A7.5 7.5 0 013.074 3.075zm.707.707a6.5 6.5 0 109.193 9.193 6.5 6.5 0 00-9.193-9.193z" fill="#46D39A" fill-rule="nonzero"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dnxte-col">
				<div class="dnxte-admin-modules">
                    <?php foreach ( $modules as $module_key => $module_data ) : 
                        $titles     = isset( $module_data['title'] ) ? $module_data['title'] : '';
                        $icon       = isset( $module_data['icon'] ) ? $module_data['icon'] : '';
                        $is_pro     = isset( $module_data['is_pro'] ) && $module_data['is_pro'] ? true : false;
                        $demo_url   = isset( $module_data['demo'] ) && $module_data['demo'] ? $module_data['demo'] : '';
                        
                        $class_attr = 'dnxte-admin-modules-item'; 
                        
                        $class_attr = 'dnxte-admin-modules-item';
                        
                        if ( $is_pro ) {
                            $class_attr .= ' dnxte-module-is-pro';
                        }

                        $checked = '';
                        
                        if ( ! in_array( $module_key, $inactive_modules ) ) {
                            $checked = 'checked="checked"';
                        }

                        $is_placeholder = $is_pro;

                        if ( $is_placeholder ) {
                            $class_attr .= ' dnxte-module-is-placeholder';
                            $checked     = 'disabled="disabled"';
                        }
                    ?>
                        <div class="<?php echo $class_attr; ?>">
                            <?php if ( $is_pro ) : ?>
								<span class="dnxte-admin-modules-item-badge badge-pro">pro</span>
							<?php endif; ?>
                            <span class="dnxte-admin-modules-item-icon">
                                <img src="<?php echo esc_url( $icon ); ?>" alt="">
                            </span>
                            <h3 class="dnxte-admin-modules-item-title">
                                <label for="dnxte-module-<?php echo esc_attr( $module_key ); ?>"><?php echo esc_html( $titles ); ?></label>
                                <?php if ( $demo_url ) : ?>
                                    <a href="<?php echo esc_url( $demo_url ); ?>"
										target="_blank"
										rel="noopener"
										data-tooltip="<?php echo esc_attr_e( 'Click and view demo', 'dnxte-divi-essential' ); ?>"
										class="dnxte-admin-modules-item-preview">
										<img class="dnxte-img-fluid dnxte-item-icon-size" src="<?php echo  DIVI_ESSENTIAL_ASSETS . 'images/admin/desktop.svg'; ?>" alt="demo-link">
									</a>
                                <?php endif; ?>
                            </h3>
                            <div class="dnxte-admin-modules-item-toggle dnxte-toggle">
                                <input id="dnxte-module-<?php echo $module_key; ?>" <?php echo $checked; ?>
                                    type="checkbox"
                                    class="dnxte-toggle-check"
                                    name="modules[]"
                                    value="<?php echo  $module_key ; ?>"
                                >
                                <b class="dnxte-toggle-switch"></b>
                                <b class="dnxte-toggle-track"></b>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="dnxte-row dnxte-admin-button-panel">
                <div class="dnxte-col">
                    <button disabled class="dnxte-btn dnxte-btn-save dnxte-btn-lg dnxte-ext-switch" type="submit">
                        <?php esc_html_e( 'Save Settings', 'dnxte-divi-essential' ); ?>
                    </button>
                </div>
            </div>
            <div class="dnxte-action-list">
                <label class="dnxte-toggle-all-wrap">
                    <?php if( ! $checked ) : ?>
                        <input type="checkbox" <?php echo esc_attr( $checked ); ?> >
                        <span class="dnxte-toggle-all"><?php esc_html_e( 'Disable All', 'dnxte-divi-essential' ); ?></span>
                    <?php else: ?>
                        <input type="checkbox" <?php echo esc_attr( $checked ); ?> >
                        <span class="dnxte-toggle-all"><?php esc_html_e( 'Enable All', 'dnxte-divi-essential' ); ?></span>
                    <?php endif; ?>
                </label>
            </div>
        </form>
    </div>
</div>