<?php 
    $excerpt_length               = isset($args['excerpt_length']) ? intval($args['excerpt_length']) : 70;
    $thumb_width                  = 'off' !== $args['show_thumbnail'] ? intval($args['thumb_width']) : 100;
    $thumb_height                 = 'off' !== $args['show_thumbnail'] ? intval($args['thumb_height']) : 100;
    $dnxte_feaimage_thumb_size    = isset($args['dnxte_feaimage_thumb_size']) ? $args['dnxte_feaimage_thumb_size'] : ''; 
    $blogslider_layouts           = isset($args['blogslider_layout']) ? $args['blogslider_layout'] : 'one';
    
    if ( 'custom' === $dnxte_feaimage_thumb_size ) {
        if ( function_exists( 'add_theme_support' ) ) {
            add_theme_support( 'dnxte_custom_image_size' );
            set_post_thumbnail_size( $thumb_width, $thumb_height, true ); // default Post Thumbnail dimensions   
        }
        add_image_size( 'dnxte_custom_image_size', $thumb_width, $thumb_height );
        $blog_thumbnail = get_the_post_thumbnail(get_the_ID(), 'dnxte_custom_image_size', array('class' => 'dnxte-blog-featured-image'));
    }else{
        $blog_thumbnail = get_the_post_thumbnail(get_the_ID(), $dnxte_feaimage_thumb_size, array('class' => 'dnxte-blog-featured-image'));
    }

    global $authordata;

    $top_date = 'top' === $args['date_position'] ?
    sprintf(
        '<div class="dnxte-blog-post-date">
            <span class="dnxte-month">%1$s</span>
            <span class="dnxte-day">%2$s</span>
            <span class="dnxte-year">%3$s</span>
        </div>',
        get_the_date('M'),
        get_the_date('d'),
        get_the_date('Y')
    ) : '';
    
    $button_use_icon           = $args['button_use_icon'];
    $button_icon               = $args['button_icon'];

    $data_icon       = 'none';
    $data_icon_class = '';

    if( 'on' === $button_use_icon ){
        $data_icon       = $button_icon ? et_pb_process_font_icon($button_icon) : 'none';
        $data_icon_class = 'et_pb_custom_button_icon';
    }

    $custom_button_class = (isset($args['custom_button']) && "on" == $args['custom_button']) ? sprintf('et_pb_button %1$s', $data_icon_class) : '';

    $more = "on" === $args['show_more'] ? sprintf(
        '<a href="%1$s" class="%4$s dnxte-readmore-link" data-icon="%3$s">%2$s</a>',
        esc_url(get_permalink()),
        $args['show_more_text'],
        esc_attr($data_icon),
        esc_attr($custom_button_class)
    ) : "";

    $header_element = et_core_esc_previously($processed_header_level);
?>
<div class="swiper-slide">
<div class="dnxte-blog-carousel-wrap">
<?php
    if( 'on' === $args['show_thumbnail']){
        if ( has_post_thumbnail() ) {
            include dirname(__FILE__) . '/blog-featured-image-url.php';
        }else{
            ?>
            <div class="blog-wrap-no-image"></div>
            <?php
        }
        printf('%1$s', et_core_esc_wp($top_date));
        
    }

    ET_Builder_Element::clean_internal_modules_styles();
    
    $layout_array = array(
        'six',
    );

    $same_layout = array(
        'seven', 'eight'
    );

    if(in_array($blogslider_layouts, $same_layout)) {
        include dirname(__FILE__) . '/layout-seven.php';
    }elseif("six" == $blogslider_layouts) {
        include dirname(__FILE__) . '/layout-six.php';
    }else {
        include dirname(__FILE__) . '/blog-post-content.php';
    }
?>
</div>
</div>