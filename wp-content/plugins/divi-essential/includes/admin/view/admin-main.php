<?php 

$logo = DIVI_ESSENTIAL_ASSETS . "images/admin/logo.png";
?>

<div class="dnxte-admin wrapper">
	<div class="dnxte-admin-header">
		<div class="dnxte-admin-logo-inline">
			<img class="dnxte-logo-icon-size" src="<?php echo esc_attr($logo); ?>" alt="">
        </div>
        <div class="dnxte-nav" role="tablist">
			<nav class="dnxte-tabs-nav">
                <?php 
                    $tab_count = 1;

                    foreach( self::get_tabs() as $slug => $item ) :

                        $slug = esc_attr( strtolower( $slug ) );

                        $class = ' dnxte-admin-nav-item-link';

                        if ( $tab_count === 1 ) {
                            $class .= ' active-tab';
                        }

                        if ( ! empty( $item['href'] ) ) {
                            $href = esc_url( $item['href'] );
                        } else {
                            $href = '#' . $slug;
                        }

                        printf(
                            '<a href="%1$s" aria-controls="tab-content-%2$s" id="tab-nav-%2$s" class="%3$s" role="tab">
                                %5$s
                            </a>
                            <style type="text/css"> #tab-nav-%2$s { dnxteckground-image: url(%4$s); } </style>
                            ',
                            esc_url( $href ),
                            esc_attr( $slug ),
                            esc_attr( $class ),
                            esc_url( $item['icon'] ),
                            esc_html( $item['title'] )
    
                        );
                        ++$tab_count;

                    endforeach;
                ?>
            </nav>
        </div>
    </div>
    <div class="dnxte-admin-tabs">
        <div class="dnxte-admin-tabs-content">
        <?php
				$tab_count = 1;

			    foreach ( self::get_tabs() as $slug => $item ) :
                    $class = 'dnxte-admin-tabs-content-item';
                    if ( $tab_count === 1 ) {
                        $class .= ' active-tab';
                    }
                    $slug = esc_attr( strtolower( $slug ) );

                    ?>

                        <div class="<?php echo esc_attr( $class ); ?>" id="tab-content-<?php echo esc_attr( $slug ); ?>" role="tabpanel" aria-labelledby="tab-nav-<?php echo esc_attr( $slug ); ?>">
                        <?php call_user_func( $item['renderer'], $slug, $item ); ?>
                        </div>

                    <?php

                ++$tab_count;
				endforeach;
			?>
        </div>
    </div>
</div>