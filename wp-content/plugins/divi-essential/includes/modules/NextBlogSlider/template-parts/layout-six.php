<div style="display:flex;flex-direction:column;">
<div class="dnxte-authovcard dnxte-author-avatar">
    <?php
    global $authordata;

    printf('<img src="%1$s"
        alt="">', esc_url(get_avatar_url($authordata->ID)));

    ?>
</div>
<div class="dnxte-content-wrapper">
    <<?php echo $header_element; ?> class="dnxte-entry-title">
        <a href="<?php esc_url(the_permalink());?>">
            <?php the_title(); ?>
        </a>
    </<?php echo $header_element; ?>>
    <div class="dnxte-blog-post-content">
    <?php 
	$content = '';
	if ('on' === $args['show_excerpt']) {
		global $post;

		if ( has_excerpt() ) {
	
			$content = apply_filters( 'the_excerpt', $post->post_excerpt );
            $content = rtrim( wp_trim_words( $content, $excerpt_length) );
	
		} else {
			$content = $post->post_content;
			$content = preg_replace( '@\[caption[^\]]*?\].*?\[\/caption]@si', '', $content );
			$content = preg_replace( '@\[et_pb_post_nav[^\]]*?\].*?\[\/et_pb_post_nav]@si', '', $content );
			$content = preg_replace( '@\[audio[^\]]*?\].*?\[\/audio]@si', '', $content );
			$content = preg_replace( '@\[embed[^\]]*?\].*?\[\/embed]@si', '', $content );
			$content = wp_strip_all_tags( $content );
			$content = et_strip_shortcodes( $content );
			$content = et_builder_strip_dynamic_content( $content );
			$content = apply_filters( 'et_truncate_post', $content, get_the_ID() );
			$content = rtrim( wp_trim_words( $content, $excerpt_length) );
		}

		echo et_core_intentionally_unescaped( $content, 'html' );
	}
    ?>
    </div>
    <div class="dnxte-post-meta <?php echo $args['meta_alignment_class'] ?>">
        <?php
            global $authordata;
            // Icon
            $dnxte_author_icon = $args['multi_view']->render_element(array(
                'tag' => 'span',
                'content' => '',
                'attrs' => array(
                    'class' => 'dnxte-blogslider-content-icon'
                )
            ));


            $author = 'off' !== $args['show_author'] 
            ? sprintf(
                '<div class="dnxte-authovcard">
                    <span class="author vcard">%3$s %2$s</span> 
                </div>',
                esc_url(get_avatar_url($authordata->ID)),
                et_pb_get_the_author_posts_link(),
                $dnxte_author_icon
            ) : '';

            $dnxte_clock_icon = $args['multi_view']->render_element(array(
                'tag' => 'span',
                'content' => et_pb_process_font_icon('}'),
                'attrs' => array(
                    'class' => 'dnxte-blogslider-content-icon'
                )
            ));

            $bottom_date = 'off' !== $args['show_date'] ? sprintf(
                '<span class="dnxte-blog-published">%4$s %1$s %2$s %3$s</span>',
                    get_the_date('d'),
                    get_the_date('M'),
                    get_the_date('Y'),
                    $dnxte_clock_icon
                ) : '';

            printf('%1$s %2$s',
            $author,
            $bottom_date
            );
        ?>
    </div>
</div>
<div class="dnxte-readmorewrapper">
    <?php echo et_core_esc_previously($more); ?>
</div>
</div>