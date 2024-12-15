<?php

class Common {
    public static function dnxt_set_style($render_slug, $props, $property, $css_selector, $css_property, $important = true)
    {

        $responsive_active = !empty($props[$property . "_last_edited"]) && et_pb_get_responsive_status($props[$property . "_last_edited"]);
        $is_hover_enabled = isset($props[$property . "__hover_enabled"]) ? explode('|', $props[$property . "__hover_enabled"]) : array();

        $declaration_desktop = "";
        $declaration_tablet = "";
        $declaration_phone = "";

        $is_important = $important ? '!important' : '';

        switch ($css_property) {
            case "margin":
            case "padding":
                if (!empty($props[$property])) {
                    $values = explode("|", $props[$property]);
                    // if (empty($values[3])) {
                    //     return $values[3] = 0;
                    // }
                    $declaration_desktop = "{$css_property}-top: {$values[0]} {$is_important};
                                        {$css_property}-right: {$values[1]} {$is_important};
                                        {$css_property}-bottom: {$values[2]} {$is_important};
                                        {$css_property}-left: {$values[3]} {$is_important};";
                }

                if ($responsive_active && !empty($props[$property . "_tablet"])) {
                    $values = explode("|", $props[$property . "_tablet"]);
                    $declaration_tablet = "{$css_property}-top: {$values[0]} {$is_important};
                                        {$css_property}-right: {$values[1]} {$is_important};
                                        {$css_property}-bottom: {$values[2]} {$is_important};
                                        {$css_property}-left: {$values[3]} {$is_important};";
                }

                if ($responsive_active && !empty($props[$property . "_phone"])) {
                    $values = explode("|", $props[$property . "_phone"]);
                    $declaration_phone = "{$css_property}-top: {$values[0]} {$is_important};
                                        {$css_property}-right: {$values[1]} {$is_important};
                                        {$css_property}-bottom: {$values[2]} {$is_important};
                                        {$css_property}-left: {$values[3]} {$is_important};";
                }

                if ($is_hover_enabled && !empty($props[$property . "__hover"])) {
                    $values = explode("|", $props[$property . "__hover"]);
                    $declaration_hover = "{$css_property}-top: {$values[0]} {$is_important};
                                        {$css_property}-right: {$values[1]} {$is_important};
                                        {$css_property}-bottom: {$values[2]} {$is_important};
                                        {$css_property}-left: {$values[3]} {$is_important};";
                }

                break;
            default: //Default is applied for values like height, color etc.
                if (!empty($props[$property])) {
                    $declaration_desktop = "{$css_property}: {$props[$property]};";
                }
                if ($responsive_active && !empty($props[$property . "_tablet"])) {
                    $declaration_tablet = "{$css_property}: {$props[$property . "_tablet"]};";
                }
                if ($responsive_active && !empty($props[$property . "_phone"])) {
                    $declaration_phone = "{$css_property}: {$props[$property . "_phone"]};";
                }
        }

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $css_selector,
            'declaration' => $declaration_desktop,
        ));

        if (!empty($props[$property . "_tablet"]) && $responsive_active) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $css_selector,
                'declaration' => $declaration_tablet,
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));
        }

        if (!empty($props[$property . "_phone"]) && $responsive_active) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $css_selector,
                'declaration' => $declaration_phone,
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));
        }

        if (!empty($props[$property . "__hover"]) && $is_hover_enabled) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $css_selector . ':hover',
                'declaration' => $declaration_hover,
            ));
        }
    }

    public static function apply_bg_css( $render_slug, $context, $color, $use_color_gradient, $gradient, $css_property ) {
        $bg_image = array();
        $bg_style = "";
        $bg_style_tablet = "";
        $bg_style_phone = "";
        $bg_style_hover = "";

        $bg_type = $context->props[$gradient["gradient_type"]];
        $bg_direction = $context->props[$gradient["gradient_direction"]];
        $bg_direction_radial = $context->props[$gradient["radial"]];
        $bg_start = $context->props[$gradient["gradient_start"]];
        $bg_start_tablet = $context->props[$gradient["gradient_start"]."_tablet"];
        $bg_start_phone = $context->props[$gradient["gradient_start"]."_phone"];
        $bg_start_hover = $use_color_gradient == "on" && isset($context->props[$gradient["gradient_start"]."__hover"]) && $context->props[$gradient["gradient_start"]."__hover"] !== "" ? $context->props[$gradient["gradient_start"]."__hover"] : "";
        $bg_end = $context->props[$gradient["gradient_end"]];
        $bg_end_tablet = $context->props[$gradient["gradient_end"]."_tablet"];
        $bg_end_phone = $context->props[$gradient["gradient_end"]."_phone"];
        $bg_end_hover = $use_color_gradient == "on" && isset($context->props[$gradient["gradient_end"]."__hover"]) &&  $context->props[$gradient["gradient_end"]."__hover"] !== "" ? $context->props[$gradient["gradient_end"]."__hover"] : "";
        $bg_start_position = $context->props[$gradient["gradient_start_position"]];
        $bg_end_position = $context->props[$gradient["gradient_end_position"]];
        $bg_overlays_image = $context->props[$gradient["gradient_overlays_image"]];


        $is_hover_enabled = isset($context->props[$color['color_slug']."__hover_enabled"]) ? explode('|', $context->props[$color['color_slug']."__hover_enabled"]) : array();


        $bg_stops = isset($context->props[$color['color_slug']."_gradient_stops"]) ? $context->props[$color['color_slug']."_gradient_stops"] : '';
        $bg_stops = implode(",",explode("|",$bg_stops));
        $bg_stops_tablet = isset($context->props[$color['color_slug']."_gradient_stops_tablet"]) ? $context->props[$color['color_slug']."_gradient_stops_tablet"] : '';
        $bg_stops_tablet = implode(",",explode("|",$bg_stops_tablet));
        $bg_stops_phone = isset($context->props[$color['color_slug']."_gradient_stops_phone"]) ? $context->props[$color['color_slug']."_gradient_stops_phone"] : '';
        $bg_stops_phone = implode(",",explode("|",$bg_stops_phone));
        $bg_stops_hover = isset($context->props[$color['color_slug']."_gradient_stops__hover"]) ? $context->props[$color['color_slug']."_gradient_stops__hover"] : '';
        $bg_stops_hover = implode(",",explode("|",$bg_stops_hover));
        
        if ('on' === $use_color_gradient) {
            $direction = $bg_type === 'linear' ? $bg_direction : "circle at ". $bg_direction_radial." ";
            $start_position = et_sanitize_input_unit($bg_start_position, false, '%');
            $end_position = et_sanitize_input_unit($bg_end_position, false, '%');

            $gradient_bg = "{$bg_type}-gradient( {$direction}, {$bg_stops} )";
            $gradient_bg_tablet = "{$bg_type}-gradient( {$direction}, {$bg_stops_tablet} )";
            $gradient_bg_phone = "{$bg_type}-gradient( {$direction}, {$bg_stops_phone} )";
            $gradient_bg_hover = (array_key_exists("0", $is_hover_enabled) && "on" == $is_hover_enabled["0"]) ? "{$bg_type}-gradient( {$direction}, {$bg_stops_hover} )" : '';
    
            if (!empty($gradient_bg) || !empty($gradient_bg_tablet) || !empty($gradient_bg_phone) || !empty($gradient_bg_hover)) {
                $bg_image[] = $gradient_bg;
                $bg_image_tablet[] = $gradient_bg_tablet;
                $bg_image_phone[] = $gradient_bg_phone;
                $bg_image_hover[] = $gradient_bg_hover;
            }
            $has_bg_gradient = true;
        } else {
            $has_bg_gradient = false;
        }
    
    
        if (!empty($bg_image)) {
            if ('on' !== $bg_overlays_image) {
                $bg_image = array_reverse($bg_image);
                $bg_image_tablet = array_reverse($bg_image_tablet);
                $bg_image_phone = array_reverse($bg_image_phone);
                $bg_image_hover = array_reverse($bg_image_hover);
            }
    
            $bg_style .= sprintf('background-image: %1$s !important;', esc_html(join(', ', $bg_image)));
            $bg_style_tablet .= sprintf('background-image: %1$s !important;', esc_html(join(', ', $bg_image_tablet)));
            $bg_style_phone .= sprintf('background-image: %1$s !important;', esc_html(join(', ', $bg_image_phone)));
            $bg_style_hover .= sprintf('background-image: %1$s !important;', esc_html(join(', ', $bg_image_hover)));

        }
        
        
        if (!$has_bg_gradient) {
            $bg_color = $context->props[$color['color_slug']];
            $bg_color_values = et_pb_responsive_options()->get_property_values($context->props, $color['color_slug']);


            $bg_color_tablet = isset($bg_color_values['tablet']) ? $bg_color_values['tablet'] : '';
            $bg_color_phone = isset($bg_color_values['phone']) ? $bg_color_values['phone'] : '';
            $bg_color_hover = isset($context->props[$color['color_slug']."__hover"]) && $context->props[$color['color_slug']."__hover"] !== "" ? $context->props[$color['color_slug']."__hover"] : "";
            
            
            if ('' !== $bg_color) {
                $bg_style .= sprintf('background-color: %1$s !important; ', esc_html($bg_color));
                $bg_style_tablet .= sprintf('background-color: %1$s !important; ', esc_html($bg_color_tablet));
                $bg_style_phone .= sprintf('background-color: %1$s !important; ', esc_html($bg_color_phone));


                if (et_builder_is_hover_enabled($color['color_slug'], $context->props)) {
                    $bg_style_hover = sprintf('background-color: %1$s !important;', $bg_color_hover);
                }

            }
        }
    
        if ('' !== $bg_style) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $css_property['desktop'],
                'declaration' => rtrim($bg_style),
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $css_property['desktop'],
                'declaration' => rtrim($bg_style_tablet),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $css_property['desktop'],
                'declaration' => rtrim($bg_style_phone),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));

            if ("" !== $bg_style_hover && array_key_exists("hover", $css_property)) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => $context->add_hover_to_order_class($css_property['hover']),
                    'declaration' => rtrim($bg_style_hover),
                ));
            }            
        }
    }

    public static function apply_all_bg_css($options, $render_slug, $context)
    {
        foreach ($options as $key => $value) {
            # code...
            self::apply_bg_css($render_slug, $context, array(
                'color_slug' => $key . 'bg_color',
            ),
                $context->props[$key . 'bg_use_color_gradient'],
                array(
                    "gradient_type" => $key . 'bg_color_gradient_type',
                    "gradient_direction" => $key . 'bg_color_gradient_direction',
                    "radial" => $key . 'bg_color_gradient_direction_radial',
                    "gradient_start" => $key . 'bg_color_gradient_start',
                    "gradient_end" => $key . 'bg_color_gradient_end',
                    "gradient_start_position" => $key . 'bg_color_gradient_start_position',
                    "gradient_end_position" => $key . 'bg_color_gradient_end_position',
                    "gradient_overlays_image" => $key . 'bg_color_gradient_overlays_image',
                ), $value);
        }
    }

    public static function get_alignment( $slug, $context,$prefix="" ) {
        $is_button_alignment_responsive  = et_pb_responsive_options()->is_responsive_enabled( $context->props, $slug );

        $text_orientation = isset( $context->props[$slug] ) ? $context->props[$slug] : '';

        $alignment_array = array();

        if($is_button_alignment_responsive) {
            
            
            $text_orientation_tablet = isset( $context->props[$slug."_tablet"] ) ? $context->props[$slug."_tablet"] : '';
            $text_orientation_phone = isset( $context->props[$slug."_phone"] ) ? $context->props[$slug."_phone"] : '';
            

            if("" === $prefix) {
                if( !empty($text_orientation) ){
                    array_push($alignment_array, sprintf('%1$s_%2$s', $slug, et_pb_get_alignment($text_orientation)));
                }
    
                if( !empty($text_orientation_tablet) ) {    
                    array_push($alignment_array, sprintf('%1$s_tablet_%2$s', $slug, et_pb_get_alignment($text_orientation_tablet)));
                }
                
                if( !empty($text_orientation_phone) ) {    
                    array_push($alignment_array, sprintf('%1$s_phone_%2$s', $slug, et_pb_get_alignment($text_orientation_phone)));
                }
            }else{
                if( !empty($text_orientation) ){
                    array_push($alignment_array, sprintf('%3$s_%1$s_%2$s', $slug, et_pb_get_alignment($text_orientation), $prefix));
                }
    
                if( !empty($text_orientation_tablet) ) {    
                    array_push($alignment_array, sprintf('%3$s_%1$s_tablet_%2$s', $slug, et_pb_get_alignment($text_orientation_tablet), $prefix));
                }
                
                if( !empty($text_orientation_phone) ) {    
                    array_push($alignment_array, sprintf('%3$s_%1$s_phone_%2$s', $slug, et_pb_get_alignment($text_orientation_phone), $prefix));
                }
            }

            return join(' ', $alignment_array);
        }else{
            if( !empty($text_orientation) ){
                if("" === $prefix) {
                    array_push($alignment_array, sprintf('%1$s_%2$s', $slug, et_pb_get_alignment($text_orientation)));
                }else {
                    array_push($alignment_array, sprintf('%3$s_%1$s_%2$s', $slug, et_pb_get_alignment($text_orientation), $prefix));
                }
            };

            return join(' ', $alignment_array);
        }
    }
    
	public static function render_stars($rating, $scale) {
		$rating 		= (float) $rating;
		$floored_rating = floor( $rating );
		$star_html 		= '';

			for ( $stars = 1.0; $stars <= $scale; $stars++ ) {
				if ( $stars <= $floored_rating ) {
					$star_html .= '<i class="divinext-star-full et-pb-icon"></i>';
				} else if ( $floored_rating + 1 === $stars && $rating !== $floored_rating ) {
					$star_html .= '<i class="divinext-star-' . ( $rating - $floored_rating ) * 10 . ' et-pb-icon"></i>';
				} else {
					$star_html .= '<i class="divinext-star-empty et-pb-icon"></i>';
				}
			}

		return $star_html;
    }

    public static function pagination($pagination_type, $is_bullet_on){
        if ($pagination_type === "none") {
            return "swiper-pagination swiper-pagination-none";
        }
        if ($pagination_type === "bullets" && $is_bullet_on === "on") {
            return "swiper-pagination swiper-pagination-clickable swiper-pagination-bullets swiper-pagination-bullets-dynamic mt-10";
        }

        if ($pagination_type === "bullets") {
            return "swiper-pagination swiper-pagination-clickable swiper-pagination-bullets mt-10";
        }

        if ($pagination_type === "fraction") {
            return "swiper-pagination swiper-pagination-fraction";
        }
        if ($pagination_type === "progressbar") {
            return "swiper-pagination swiper-pagination-progressbar";
        }
    }

    public static function set_css($slug, $css_property, $css_selector, $render_slug, $context) {
        $slug_css = $context->props[$slug];
        $slug_css_values = et_pb_responsive_options()->get_property_values($context->props, $slug);
        $slug_css_tablet = "" !== $slug_css_values['tablet'] ? $slug_css_values['tablet'] : '';
        $slug_css_phone = "" !== $slug_css_values['phone'] ? $slug_css_values['phone'] : $slug_css_values['tablet'];
        $slug_css_hover = (isset($context->props[$slug."__hover_enabled"]) && isset($context->props[$slug."__hover"])) ? $context->props[$slug."__hover"] : '';

        if ("" !== $slug_css) {
            $slug_css_style = sprintf($css_property, esc_attr__($slug_css, 'dnxte-divi-essential'));
            $slug_css_style_tablet = sprintf($css_property, esc_attr__($slug_css_tablet, 'dnxte-divi-essential'));
            $slug_css_style_phone = sprintf($css_property, esc_attr__($slug_css_phone, 'dnxte-divi-essential'));
            $slug_css_style_hover = "";

            
            if (et_builder_is_hover_enabled($slug, $context->props)) {
                $slug_css_style_hover = sprintf($css_property, esc_attr__($slug_css_hover, 'dnxte-divi-essential'));
            }

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $css_selector['desktop'],
                'declaration' => $slug_css_style,
            ));

            if($slug_css_values['tablet']){
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => $css_selector['desktop'],
                    'declaration' => $slug_css_style_tablet,
                    'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
                ));
            }

            if($slug_css_values['phone']) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => $css_selector['desktop'],
                    'declaration' => $slug_css_style_phone,
                    'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
                ));
            }

            if ("" !== $slug_css_style_hover && array_key_exists('hover', $css_selector)) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => $context->add_hover_to_order_class($css_selector['hover']),
                    'declaration' => $slug_css_style_hover,
                ));
            }
        }
    }

    public static function shape_image_position($positionArr, $render_slug, $context) {
        $horizontal_slug = $positionArr['horizontal_slug'];
        $vertical_slug = $positionArr['vertical_slug'];
        $css_selector = $positionArr['css_selector'];
        $use_shape = $positionArr['use_shape'];
        $use_mask_upload = $positionArr['use_mask_upload'];
        // Position image start
        $image_horizontal = ("on" == $use_shape || "on" == $use_mask_upload) && isset($context->props[$horizontal_slug]) ? $context->props[$horizontal_slug] : '';

        $image_horizontal_values = et_pb_responsive_options()->get_property_values($context->props, $horizontal_slug);

        

        $image_horizontal_tablet = isset($image_horizontal_values['tablet']) && "" != $image_horizontal_values['tablet'] ? $image_horizontal_values['tablet'] : $image_horizontal_values['desktop'];
        $image_horizontal_phone =isset($image_horizontal_values['phone']) && "" != $image_horizontal_values['phone'] ? $image_horizontal_values['phone'] : $image_horizontal_values['desktop'];
        $image_horizontal_hover = (("on" == $use_shape || "on" == $use_mask_upload) && ( isset($context->props[$horizontal_slug."__hover_enabled"]) && "on|hover" == $context->props[$horizontal_slug."__hover_enabled"])) ? $context->props[$horizontal_slug."__hover"] : ''; 

        $image_vertical = ("on" == $use_shape || "on" == $use_mask_upload) && isset($context->props[$vertical_slug]) ? $context->props[$vertical_slug] : '';

        $image_vertical_values = et_pb_responsive_options()->get_property_values($context->props, $vertical_slug);
        $image_vertical_tablet = isset($image_vertical_values['tablet']) && "" != $image_vertical_values['tablet'] ? $image_vertical_values['tablet'] : $image_vertical_values['desktop'];
        $image_vertical_phone =isset($image_vertical_values['phone']) && "" != $image_vertical_values['phone'] ? $image_vertical_values['phone'] : $image_vertical_values['tablet'];
        $image_vertical_hover =(("on" == $use_shape || "on" == $use_mask_upload) && (isset($context->props[$vertical_slug."__hover_enabled"])  && "on|hover" == $context->props[$vertical_slug."__hover_enabled"])) ? $context->props[$vertical_slug."__hover"] : '';


        if ("" !== $image_horizontal || "" !== $image_vertical) {
            $image_position_style = sprintf('transform: matrix(1, 0, 0, 1, %1$s, %2$s);', $image_horizontal, $image_vertical);
            $image_position_style_tablet = sprintf('transform: matrix(1, 0, 0, 1, %1$s, %2$s);', esc_attr($image_horizontal_tablet), $image_vertical_tablet);

            $image_position_style_phone = sprintf('transform: matrix(1, 0, 0, 1, %1$s, %2$s);', $image_horizontal_phone, $image_vertical_phone);
            $image_position_style_hover = "";

            if (et_builder_is_hover_enabled($horizontal_slug, $context->props) || et_builder_is_hover_enabled($vertical_slug, $context->props)) {
                $image_position_style_hover = sprintf('transform: matrix(1, 0, 0, 1, %1$s, %2$s);', $image_horizontal_hover, $image_vertical_hover);
            }

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $css_selector['desktop'],
                'declaration' => $image_position_style,
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $css_selector['desktop'],
                'declaration' => $image_position_style_tablet,
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $css_selector['desktop'],
                'declaration' => $image_position_style_phone,
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));

            if ("" !== $image_position_style_hover && isset($css_selector['hover'])) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => $context->add_hover_to_order_class($css_selector['hover']),
                    'declaration' => $image_position_style_hover,
                ));
            }
        }
        // Position image end
    }


    public static function blurb_get_alignment($slug, $context, $class_name, $prefix="") {

        $arr = array(
            'dnxt-blurb-wrapper-one-top-left'		=> 'top-left',
            'dnxt-blurb-wrapper-one-top-center'		=> 'top-center',
            'dnxt-blurb-wrapper-one-top-right'		=> 'top-right',
            'dnxt-blurb-wrapper-one-left-top'		=> 'left-top',
            'dnxt-blurb-wrapper-one-left-center'	=> 'left-center',
            'dnxt-blurb-wrapper-one-left-bottom'	=> 'left-bottom',
            'dnxt-blurb-wrapper-one-bottom-left'	=> 'bottom-left',
            'dnxt-blurb-wrapper-one-bottom-center'	=> 'bottom-center',
            'dnxt-blurb-wrapper-one-bottom-right'	=> 'bottom-right',
            'dnxt-blurb-wrapper-one-right-top'		=> 'right-top',
            'dnxt-blurb-wrapper-one-right-center'	=> 'right-center',
            'dnxt-blurb-wrapper-one-right-bottom'	=> 'right-bottom',
        );


        $is_button_alignment_responsive  = et_pb_responsive_options()->is_responsive_enabled( $context->props, $slug );

        $text_orientation = isset( $context->props[$slug] ) ? $arr[$context->props[$slug]] : '';

        $alignment_array = array();

        if($is_button_alignment_responsive) {
            
            
            $text_orientation_tablet = isset( $context->props[$slug."_tablet"] ) ? $arr[$context->props[$slug."_tablet"]] : '';
            $text_orientation_phone = isset( $context->props[$slug."_phone"] ) ? $arr[$context->props[$slug."_phone"]] : '';
            

            if("" === $prefix) {
                if( !empty($text_orientation) ){
                    array_push($alignment_array, sprintf('%1$s%2$s', $class_name, et_pb_get_alignment($text_orientation)));
                }
    
                if( !empty($text_orientation_tablet) ) {    
                    array_push($alignment_array, sprintf('%1$s%2$s_tablet', $class_name, et_pb_get_alignment($text_orientation_tablet)));
                }
                
                if( !empty($text_orientation_phone) ) {    
                    array_push($alignment_array, sprintf('%1$s%2$s_phone', $class_name, et_pb_get_alignment($text_orientation_phone)));
                }
            }else{
                if( !empty($text_orientation) ){
                    array_push($alignment_array, sprintf('%3$s_%1$s%2$s', $class_name, et_pb_get_alignment($text_orientation), $prefix));
                }
    
                if( !empty($text_orientation_tablet) ) {    
                    array_push($alignment_array, sprintf('%3$s_%1$s%2$s', $class_name, et_pb_get_alignment($text_orientation_tablet), $prefix));
                }
                
                if( !empty($text_orientation_phone) ) {    
                    array_push($alignment_array, sprintf('%3$s_%1$s%2$s', $class_name, et_pb_get_alignment($text_orientation_phone), $prefix));
                }
            }

            return join(' ', $alignment_array);
        }else{
            if( !empty($text_orientation) ){
                if("" === $prefix) {
                    array_push($alignment_array, sprintf('%1$s%2$s', $class_name, et_pb_get_alignment($text_orientation)));
                }else {
                    array_push($alignment_array, sprintf('%3$s_%1$s%2$s', $class_name, et_pb_get_alignment($text_orientation), $prefix));
                }
            };

            return join(' ', $alignment_array);
        }
    }

     public static function background_fields($context, $prefix, $label, $slug, $tab_slug, $other = array())
    {
        // front_icon_bg_color
        $additional[$prefix . "bg_color"] = array(
            'label' => esc_html__($label, 'et-builder'),
            'type' => 'background-field',
            'base_name' => $prefix . "bg",
            'context' => $prefix . "bg",
            'option_category' => 'layout',
            'custom_color' => true,
            // 'default'         => ET_Global_Settings::get_value('all_buttons_bg_color'),
            'depends_show_if' => 'on',
            'tab_slug' => $tab_slug,
            'toggle_slug' => $slug,
            // "sub_toggle"  => 'sub_toggle_frontend',
            'background_fields' => array_merge(
                $context->generate_background_options(
                    $prefix . "bg",
                    'gradient',
                    $tab_slug,
                    $slug,
                    $prefix . "bg_gradient"
                ),
                $context->generate_background_options(
                    $prefix . "bg",
                    "color",
                    $tab_slug,
                    $slug,
                    $prefix . "bg_color"
                )
            ),
            'mobile_options' => true,
        );

        $additional = array_merge(
            $additional,
            $context->generate_background_options(
                $prefix . 'bg',
                'skip',
                $tab_slug,
                $slug,
                $prefix . "bg_gradient"
            ),
            $context->generate_background_options(
                $prefix . 'bg',
                'skip',
                $tab_slug,
                $slug,
                $prefix . "bg_color"
            )
        );

        if (!empty($other)) {
            foreach ($other as $key => $value) {
                # code...
                $additional[$prefix . "bg_color"][$key] = $value;
            }
        }

        return $additional;
    }

    public static function get_icon_html($slug, $context, $render_slug, $multi_view, $css_property = array(), $tag="span") {
        $icon_fontawesome = explode('||', $context->props[$slug]);
		$icon = "";	
        $class = isset($css_property['class']) ? $css_property['class'] : '';
        if( function_exists( 'et_pb_get_extended_font_icon_value' ) && array_key_exists('1', $icon_fontawesome) && in_array($icon_fontawesome['1'], array('fa', 'divi')) ) {

            $context->generate_styles(
                array(
                    'utility_arg'    => 'icon_font_family',
                    'render_slug'    => $render_slug,
                    'base_attr_name' => $slug,
                    'important'      => true,
                    'selector'       => isset($css_property['selector']) ? $css_property['selector'] : '',
                    'processor'      => array(
                        'ET_Builder_Module_Helper_Style_Processor',
                        'process_extended_icon',
                    ),
                )
            );
            $icon = $multi_view->render_element(
                array(
                    'tag'       => $tag,
                    'content'   => '{{' . $slug . '}}',
                    'attrs'     => array(
                        'class' => $class,
                    ),
                )
            );
        }else {
            $old_icon = count($icon_fontawesome) > 1 ? $icon_fontawesome['0'] : $context->props[$slug];
            $processed_icon        = esc_attr( html_entity_decode(et_pb_process_font_icon($old_icon)));
            $icon 	= sprintf( '<%2$s class="%3$s">%1$s</%2$s>', esc_attr( $processed_icon ), $tag, $class );
        }
        return $icon;
    }

    public static function get_icon_html_using_psuedo($slug, $context, $render_slug, $css_property = array(), $tag = "span") {
        $icon_fontawesome = explode('||', $context->props[$slug]);
        $icon_fontawesome_values = et_pb_responsive_options()->get_property_values($context->props, $slug);
		$icon_fontawesome_tablet = (isset($icon_fontawesome_values['tablet']) && "" != $icon_fontawesome_values['tablet'])? explode( '||', $icon_fontawesome_values['tablet'] ) : '';
		$icon_fontawesome_phone = (isset($icon_fontawesome_values['phone']) && "" != $icon_fontawesome_values['phone']) ? explode( '||', $icon_fontawesome_values['phone'] ) : '';

        // html
        $icon = isset($icon_fontawesome[0]) ? $icon_fontawesome[0] : '';
			$icon_weight = isset($icon_fontawesome[2]) ? $icon_fontawesome[2] : '';
			$icon_tablet = isset($icon_fontawesome_tablet[0]) ? $icon_fontawesome_tablet[0] : $icon;
			$icon_weight_tablet = isset($icon_fontawesome_tablet[2]) ? $icon_fontawesome_tablet[2] : $icon_weight;
			$icon_phone = isset($icon_fontawesome_phone[0]) ? $icon_fontawesome_phone[0] : $icon_tablet;
			$icon_weight_phone = isset($icon_fontawesome_phone[2]) ? $icon_fontawesome_phone[2] : $icon_weight_tablet;

			$icon_html = sprintf(
				'<%5$s class="%4$s" data-icon="%1$s" data-icon-tablet="%2$s" data-icon-phone="%3$s"></%5$s>',
				esc_attr( et_pb_process_font_icon( $icon )),
				esc_attr( et_pb_process_font_icon( $icon_tablet )),
				esc_attr( et_pb_process_font_icon( $icon_phone )),
                isset($css_property['class']) ? $css_property['class'] : '',
                $tag
			);

            $font_name = array('fa' => 'FontAwesome', 'divi' => 'ETmodules');
		$font_styles = isset($icon_fontawesome[1]) && array_key_exists($icon_fontawesome[1], $font_name) ? sprintf('font-family: %1$s !important;font-weight: %2$s !important;content: attr(data-icon);', $font_name[$icon_fontawesome[1]], $icon_weight) : "font-family: ETmodules !important;";
        $font_styles_tablet = isset($icon_fontawesome_tablet[1]) && array_key_exists($icon_fontawesome_tablet[1], $font_name) ? sprintf('font-family: %1$s !important;font-weight: %2$s !important;content:attr(data-icon-tablet) !important;', $font_name[$icon_fontawesome_tablet[1]], $icon_weight_tablet) : $font_styles;
        $font_styles_phone = isset($icon_fontawesome_phone[1]) && array_key_exists($icon_fontawesome_phone[1], $font_name) ? sprintf('font-family: %1$s !important;font-weight: %2$s !important;content: attr(data-icon-phone) !important;', $font_name[$icon_fontawesome_phone[1]], $icon_weight_phone) : $font_styles_tablet;
        
        $selector = isset($css_property['selector']) ? $css_property['selector'] : '';

        ET_Builder_Element::set_style($render_slug, array(
            'selector'    	=> $selector,
            'declaration'	=> $font_styles
        ) );
        ET_Builder_Element::set_style($render_slug, array(
            'selector'    	=> $selector,
            'declaration'	=> $font_styles_tablet,
            'media_query'   => ET_Builder_Element::get_media_query('max_width_980')
        ) );
        ET_Builder_Element::set_style($render_slug, array(
            'selector'    	=> $selector,
            'declaration'	=> $font_styles_phone,
            'media_query'   => ET_Builder_Element::get_media_query('max_width_767')
        ) );

        return $icon_html;
    }
    
    public static function get_divi_library_options() {

		$layouts = array();

		$_layouts = get_posts(
			array(
				'post_type'      => 'et_pb_layout',
				'post_status'    => 'publish',
				'posts_per_page' => -1,
				'orderby'        => 'title',
			)
		);

		$layouts[0] = esc_html__( '-- Select Layout --', 'et_builder' );

		if ( ! empty( $_layouts ) ) {

			foreach ( $_layouts as $layout ) {
				$layouts[ $layout->ID ] = $layout->post_title;
			}
		}
		

		return $layouts;
	}

    public static function apply_spacing($customMarginPadding, $render_slug, $props)
    {
        if (!is_array($customMarginPadding)) {
            return;
        }

        foreach ($customMarginPadding as $key => $value) {
            if (is_array($value['type'])) {
                foreach ($value['type'] as $type) {
                    $is_important = array_key_exists('important', $value) && !$value['important'] ? false : true;
                    self::dnxt_set_style($render_slug, $props, $key . "_" . $type, $value['selector'], $type, $is_important);
                }
            } else {
                $is_important = array_key_exists('important', $value) && !$value['important'] ? false : true;
                self::dnxt_set_style($render_slug, $props, $key . "_" . $value['type'], $value['selector'], $value['type'], $is_important);
            }
        }
    }
}

new Common;