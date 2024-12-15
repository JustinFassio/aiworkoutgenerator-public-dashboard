<?php

defined( 'ABSPATH' ) || die();


function dnxte_svg_icon() {
    return 'data:image/svg+xml;base64,PHN2ZyBpZD0iTGF5ZXJfMSIgZGF0YS1uYW1lPSJMYXllciAxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAxNTAgMTUwIj48cGF0aCBkPSJNMTAyLjksMjIuMzhIMTcuNDJWLjE1SDEwMi45QTExLjExLDExLjExLDAsMCwxLDExNCwxMS4yNmgwQTExLjEyLDExLjEyLDAsMCwxLDEwMi45LDIyLjM4WiIgc3R5bGU9ImZpbGw6I2EwYTVhYSIvPjxwYXRoIGQ9Ik0xMDIuOSwxNDkuODVIMTcuNDJWMTI3LjYySDEwMi45QTExLjEyLDExLjEyLDAsMCwxLDExNCwxMzguNzRoMEExMS4xMSwxMS4xMSwwLDAsMSwxMDIuOSwxNDkuODVaIiBzdHlsZT0iZmlsbDojYTBhNWFhIi8+PHBhdGggZD0iTTc4LjQ5LDg2LjEySDE3LjQyVjYzLjg4SDc4LjQ5QTExLjEyLDExLjEyLDAsMCwxLDg5LjYxLDc1aDBBMTEuMTIsMTEuMTIsMCwwLDEsNzguNDksODYuMTJaIiBzdHlsZT0iZmlsbDojYTBhNWFhIi8+PHBhdGggZD0iTTg3LjY0LDMwLjA2SDQ0LjRWNTIuMjlIODcuNjRhMjIuNzEsMjIuNzEsMCwwLDEsMCw0NS40Mkg0NC40djIyLjIzSDg3LjY0YTQ0Ljk0LDQ0Ljk0LDAsMSwwLDAtODkuODhaIiBzdHlsZT0iZmlsbDojYTBhNWFhIi8+PC9zdmc+';
}

if(!has_filter('et_global_assets_list', 'dnxte__add_icons')) {
    add_filter( 'et_global_assets_list', 'dnxte__add_icons', 10 );
}

function dnxte__add_icons( $assets ) {
    if ( isset( $assets['et_icons_all'] ) && isset( $assets['et_icons_fa'] ) ) {
        return $assets;
    }

    $assets_prefix = et_get_dynamic_assets_path();

    $assets['et_icons_all'] = array(
        'css' => "{$assets_prefix}/css/icons_all.css",
    );

    $assets['et_icons_fa'] = array(
        'css' => "{$assets_prefix}/css/icons_fa_all.css",
    );

    return $assets;
}

// Masonry Gallary Image
add_action( 'init' , 'dnxte_categories_to_attachments' );
function dnxte_categories_to_attachments() {

    $labels = array(
        'name'              => esc_html__( 'Gallery Categories', 'et_builder' ),
        'singular_name'     => esc_html__( 'Gallery Categorey', 'et_builder' ),
        'search_items'      => esc_html__( 'Search Gallery Category', 'et_builder' ),
        'all_items'         =>  esc_html__('All Gallery Categories', 'et_builder' ),
        'parent_item'       => esc_html__( 'Parent Gallery Category', 'et_builder' ),
        'parent_item_colon' => esc_html__( 'Parent Category:', 'et_builder' ),
        'edit_item'         =>  esc_html__('Edit Category', 'et_builder' ),
        'update_item'       =>  esc_html__('Update Category', 'et_builder' ),
        'add_new_item'      =>  esc_html__('New Category Name', 'et_builder' ),
        'new_item_name'     =>  esc_html__('View Gallery Category', 'et_builder' ),
        'view_item'          => esc_html__( 'View Gallery Category', 'et_builder' ),        
        'menu_name'         => esc_html__( 'Gallery Categorey', 'et_builder' ),
        'not_found'         => esc_html__( "You currently don't have any project categories.", 'et_builder' ),
        
    );
    
    $args = array(
        'hierarchical'      => true,
        'public'            => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'show_in_rest'      => true,
    );

    register_taxonomy( 'gallery_categories', 'attachment', $args );
}

add_action('wp_ajax_dnxte_get_images', 'dnxte_get_images');

function dnxte_get_images() {

    if ( isset( $_POST['dnxte_get_images'] ) && ! wp_verify_nonce( sanitize_text_field( $_POST['dnxte_get_images'] ), 'dnxte_get_images' ) ) {
		wp_send_json_error();
	}

    if ( ! current_user_can( 'edit_posts' ) ) {
		die( -1 );
	}

    $images_id = isset($_POST['images_id']) ? sanitize_text_field(wp_unslash( $_POST['images_id'] )) : '';
    
    $array_of_images_id = explode(",", $images_id);

    $array = array();

    $array['images'] = array();

    $terms = get_terms(array(
        'taxonomy' => 'gallery_categories',
        'hide_empty' => false,
    ));

    for ($i = 0; $i < count($array_of_images_id); $i++) {
        $array_chunk = array(
            wp_get_attachment_url($array_of_images_id[$i]), 
            get_the_title( $array_of_images_id[$i] ), 
            get_the_excerpt( $array_of_images_id[$i] ),
            get_the_terms($array_of_images_id[$i], 'gallery_categories'),
            get_post_meta($array_of_images_id[$i], 'dnxte_link_url', true),
            get_post_meta($array_of_images_id[$i], 'dnxte-image-url-target', true)
        );

        array_push($array['images'], $array_chunk);
    }

    $array['gallery_categories'] = $terms;
    wp_send_json($array);
}

add_action('wp_ajax_get_all_posts', 'get_all_posts');

function get_excerpt($content, $length){
    // $content = $post->post_content;
			$content = preg_replace( '@\[caption[^\]]*?\].*?\[\/caption]@si', '', $content );
			$content = preg_replace( '@\[et_pb_post_nav[^\]]*?\].*?\[\/et_pb_post_nav]@si', '', $content );
			$content = preg_replace( '@\[audio[^\]]*?\].*?\[\/audio]@si', '', $content );
			$content = preg_replace( '@\[embed[^\]]*?\].*?\[\/embed]@si', '', $content );
			$content = wp_strip_all_tags( $content );
            $content = rtrim( wp_trim_words( $content, $length) );
            return $content;
}

function get_all_posts() {
    $category_id = isset($_POST['cat_ids']) ? sanitize_text_field(wp_unslash( $_POST['cat_ids'] )) : '';

    if(strpos($category_id, 'all')) {
        $category_id = '';
    }

    $post_count           = isset($_POST['post_count']) ? sanitize_text_field(wp_unslash( $_POST['post_count'] )) : '-1';
    $posts_offset         = isset($_POST['posts_offset']) ? sanitize_text_field(wp_unslash( $_POST['posts_offset'] )) : 0;
    $excerpt_length       = isset($_POST['excerpt_length']) ? sanitize_text_field(wp_unslash( $_POST['excerpt_length'] )) : 70;
    $order_by             = isset($_POST['order_by']) ? sanitize_text_field(wp_unslash( $_POST['order_by'])) : "date";
    $sorted_by            = isset($_POST['sorted_by']) ? sanitize_text_field( wp_unslash( $_POST['sorted_by'])) : "ASC";
    $post_type            = isset($_POST['post_type']) ? sanitize_text_field( wp_unslash( $_POST['post_type'])) : "post";
    $image_size           = isset($_POST['image_size_type']) ? $_POST['image_size_type'] : 'full';
    $image_height         = isset($_POST['image_height']) ? $_POST['image_height'] : '';
    $image_width          = isset($_POST['image_width']) ? $_POST['image_width'] : '';

    if('custom' === $image_size && $image_height && $image_width) {
        $image_size = array(intval($image_height), intval($image_width));
    }

    $paged = get_query_var( "paged" ) ? get_query_var( "paged" ) : 3;
    $args = array(
        'post_type'      => $post_type,
        'orderby'        => $order_by,
        'post_status'    => 'publish',
        'order'          => $sorted_by,
        'posts_per_page' => $post_count,
        'offset'         => (int)$posts_offset,
        'cat'            => $category_id, // category id
        'paged'          => $paged
    );
    


    
    $user = new WP_User_Query(array(
        'id'
    ));

    $post_query = new WP_Query( $args );

    $all_posts = $post_query->posts;

    $userArr = $user->get_results();

    for ($i = 0; $i < count($all_posts); $i++) {
        $all_posts[$i]->thumbnail = get_the_post_thumbnail($all_posts[$i]->ID, $size = $image_size, array('class' => 'dnxte-blog-featured-image'));
        $category = get_the_category($all_posts[$i]->ID);
        $tags = get_the_tags($all_posts[$i]->ID);
        // $all_posts[$i]->tags = get_the_tags($all_posts[$i]->ID);  
        $all_posts[$i]->category  = $category;
        $all_posts[$i]->excerpt_length  = $excerpt_length;

        if('' == $all_posts[$i]->post_excerpt) {
            $all_posts[$i]->post_excerpt = get_excerpt($all_posts[$i]->post_content, (int)$excerpt_length);
        }else {
            $all_posts[$i]->post_excerpt = get_excerpt($all_posts[$i]->post_excerpt, (int)$excerpt_length);
        }


        $catArr = array();
        
        if( is_array($category) ){
            foreach($category as $item) {
                array_push($catArr, array(
                    'cat_ID' => $item->cat_ID,
                    'cat_name' => $item->cat_name,
                    'cat_url' => get_site_url() . '/index.php/category/' . $item->slug,
                ));
            }
        }

        $tagsArr = array();
        if( is_array($tags) ){
            foreach($tags as $it) {
                array_push($tagsArr, array(
                    'tag_ID'    => $it->term_id,
                    'tag_name'  => $it->name,
                    'tag_url'   => get_site_url() . '/index.php/tag/' . $it->slug
                ));
            }
        }


        for ($j=0; $j < count($userArr); $j++) { 
            if($userArr[$j]->data->ID == $all_posts[$i]->post_author){
                $user_data = get_avatar_data($userArr[$j]->data->user_email, null);
                $all_posts[$i]->user = array(
                    'display_name' => $userArr[$j]->data->display_name,
                    'avatar_url'   => $user_data['url'],
                    'author_url'    => get_site_url() . '/index.php/author/' . $userArr[$j]->data->user_login
                );
            }
        }

        $all_posts[$i]->category = $catArr;
        $all_posts[$i]->tags = $tagsArr;
    }

    $page_navi = function_exists('wp_pagenavi') ? wp_pagenavi( array( 'query' => $post_query, 'echo' => false ) ) : '';

    $result = array(
        'all_posts' => $all_posts,
        'page_navi'  => $page_navi
    );

    wp_send_json($result);
}



function dnxte_attachment_field_add( $form_fields, $post ) {

    $form_fields['dnxte-gallery-fields-title'] = array(
        'label' => __( 'For Divi Essential Modules only', 'et_builder' ),
        'input' => 'html',
        'html'  => __( ' ', 'et_builder' ),
    );

	$form_fields['dnxte-link-url'] = array(
		'label' => 'Link URL',
		'input' => 'text',
		'value' => get_post_meta( $post->ID, 'dnxte_link_url', true ),
		'helps' => '',
	);

    $target_value   = get_post_meta( $post->ID, 'dnxte-image-url-target', true );
	$form_fields['dnxte-image-url-target'] = array(
		'label' => 'Link Target',
		'input' => 'html',
		'html'  => '<select class="widefat" name="attachments[' . $post->ID . '][dnxte-image-url-target]" id="attachments[' . $post->ID . '][dnxte-image-url-target]">
                        <option value="_self"' . ( '_self' === $target_value ? ' selected="selected"' : '' ) . '>' .
                            __( 'In The Same Window', 'et_builder' ) .
                        '</option>
                        <option value="_blank"' . ( '_blank' === $target_value ? ' selected="selected"' : '' ) . '>' .
                            __( 'In The New Tab', 'et_builder' ) .
                        '</option>
				    </select>',
		
	);
	
	return $form_fields;
}
add_filter( 'attachment_fields_to_edit', 'dnxte_attachment_field_add', 10, 2 );

function dnxte_attachment_field_save( $post, $attachment ) {

	if( isset( $attachment['dnxte-link-url'] ) )
		update_post_meta( $post['ID'], 'dnxte_link_url', $attachment['dnxte-link-url'] );

	if( isset( $attachment['dnxte-image-url-target'] ) )
		update_post_meta( $post['ID'], 'dnxte-image-url-target', $attachment['dnxte-image-url-target'] );
	
	return $post;
}
add_filter( 'attachment_fields_to_save', 'dnxte_attachment_field_save', 10, 2 );

add_filter( 'et_builder_load_actions', function( $builder_load_requests ) {
	$builder_load_requests[] = 'dnxte_get_divi_library_options';
	return $builder_load_requests;
});

add_action('wp_ajax_dnxte_get_divi_library_options', 'dnxte_get_divi_library');
add_action('wp_ajax_nopriv_dnxte_get_divi_library_options', 'dnxte_get_divi_library');


function dnxte_get_divi_library() {

    if ( isset( $_POST['dnxte_get_divi_library_options'] ) && ! wp_verify_nonce( sanitize_text_field( $_POST['dnxte_get_divi_library_options'] ), 'dnxte_get_divi_library_options' ) ) {
		wp_send_json_error();
	}

    if ( ! current_user_can( 'edit_posts' ) ) {
		die( -1 );
	}

    $layout_id = isset( $_POST['layoutId'] ) ? $_POST['layoutId'] : '';

    
    $_layouts = get_posts(
        array(
            'post_type'      => 'et_pb_layout',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'orderby'        => 'title',
        )
    );

    $this_layout = array();
    // // $lol 
    foreach ($_layouts as $_layout ) {

        if($_layout->ID == $layout_id) {
            $_layout->post_content_html = do_shortcode($_layout->post_content);
            
            // ET_Builder_Element::clean_internal_modules_styles();
            $internal_style = ET_Builder_Element::get_style();
            // $_layout->post_content_html  .= '<style type="text/css">' . ET_Builder_Element::get_style() . '</style>';
            // ET_Builder_Element::clean_internal_modules_styles( false );

            // if ( $internal_style ) {
            //     $modules_style = sprintf(
            //         '<style type="text/css">
            //             .et-db #et-boc .et-l #et-fb-app .et_pb_column.et_pb_column_empty {
            //                 min-height: 1px;
            //             }
            //             %1$s
            //         </style>',
            //         $internal_style
            //     );
            // }
    
            $_layout->internal_style = et_core_esc_previously( $internal_style );

            $this_layout = $_layout;
            break;
        }
    }

    wp_send_json($this_layout);
}


// Json File Uploading Permission
add_filter('image_downsize', 'dnxte_image_downsize', 10, 3);

function dnxte_image_downsize($out, $id) {
    $image_url = wp_get_attachment_url($id);
    $file_ext = pathinfo($image_url, PATHINFO_EXTENSION);

    if (!is_admin() || 'svg' !== $file_ext) {
        return false;
    }

    return array($image_url, null, null, false);
}

add_filter('upload_mimes', 'dnxte_upload_mimes');

function dnxte_upload_mimes($mimes){
    return allow_svg_types($mimes);
}

function allow_svg_types($mimes){
    
    $mimes['svg'] = 'image/svg+xml';

    $mimes['json'] = 'application/json';

    return $mimes;
}


add_filter('wp_check_filetype_and_ext', 'dnxte_check_filetype_and_ext', 10, 4);

function dnxte_check_filetype_and_ext($checked, $file, $filename, $mimes){
    if (!$checked['type']) {
        $wp_filetype = wp_check_filetype($filename, $mimes);
        $ext = $wp_filetype['ext'];
        $type = $wp_filetype['type'];
        $proper_filename = $filename;

        if ($type && 0 === strpos($type, 'image/') && $ext !== 'svg') {
            $ext = $type = false;
        }

        $checked = compact('ext', 'type', 'proper_filename');
    }
    
    if (true && !$checked['type']) {
        $wp_filetype = wp_check_filetype($filename, $mimes);
        $ext = $wp_filetype['ext'];
        $type = $wp_filetype['type'];
        $proper_filename = $filename;

        if ($type && $ext !== 'json') {
            $ext = $type = false;
        }

        $checked = compact('ext', 'type', 'proper_filename');
    }

    return $checked;
}