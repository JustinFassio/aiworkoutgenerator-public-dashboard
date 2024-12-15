<?php

class Divi_NxteFloatingElementChild extends ET_Builder_Module
{
    public $slug = 'dnxte_floating_element_child';
    public $vb_support = 'on';
    public $type = 'child';
    public $child_title_var = 'floting_shape_alt';
    public $child_title_fallback_var = 'floting_shape_alt';

    protected $module_credits = array(
        'module_uri' => 'https://www.diviessential.com/divi-floating-elements/',
        'author' => 'Divi Next',
        'author_uri' => 'www.divinext.com',
    );

    public function init()
    {
        $this->name = esc_html__('Floating Item', 'et_builder');

        $this->settings_modal_toggles = array(
            'general' => array(
                'toggles' => array(
                    'floting_shape_content_toggle' => esc_html__('Content', 'et_builder'),
                ),
            ),
            'advanced' => array(
                'toggles' => array(
                    'floting_shape_animation_settings' => esc_html__('Animation Settings', 'et_builder'),
                    'floting_shape_image_settings' => esc_html__('Image Settings', 'et_builder'),
                    'floting_shape_title_settings' => esc_html__('Title Settings', 'et_builder'),
                ),
            ),
        );

        $this->custom_css_fields = array(
            'image' => array(
                'label' => esc_html__('Image', 'et_builder'),
                'selector' => '%%order_class%% .dnxte-floting-image',
            ),
            'title' => array(
                'label' => esc_html__('Text', 'et_builder'),
                'selector' => '%%order_class%% .dnxte-floting-text',
            ),
        );
    }

    public function get_advanced_fields_config()
    {
        return array(
            'text' => false,
            'fonts' => array(
                'text' => array(
                    'label' => esc_html__('Title', 'et_builder'),
                    'hide_text_align' => true,
                    'css' => array(
                        'main' => '%%order_class%% .dnxte-floting-text',
                        'important' => 'all',
                    ),
                    'toggle_slug' => 'floting_shape_title_settings',
                ),
            ),
            'borders' => array(
                'image' => array(
                    'label_prefix' => esc_html__('Image', 'et_builder'),
                    'css' => array(
                        'main' => array(
                            'border_radii' => "%%order_class%% .dnxte-floting-image",
                            'border_styles' => "%%order_class%% .dnxte-floting-image",
                        ),
                        'important' => 'all',
                    ),
                    'toggle_slug' => 'floting_shape_image_settings',
                ),
                'title' => array(
                    'label_prefix' => esc_html__('Title', 'et_builder'),
                    'css' => array(
                        'main' => array(
                            'border_radii' => "%%order_class%% .dnxte-floting-text",
                            'border_styles' => "%%order_class%% .dnxte-floting-text",
                        ),
                        'important' => 'all',
                    ),
                    'toggle_slug' => 'floting_shape_title_settings',
                ),
            ),
            'box_shadow' => array(
                'image' => array(
                    'label_prefix' => esc_html__('Image', 'et_builder'),
                    'option_category' => 'layout',
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'floting_shape_image_settings',
                    'css' => array(
                        'main' => '%%order_class%% .dnxte-floting-image',
                        'important' => true,
                        'custom_style' => true,
                    ),
                    'default_on_fronts' => array(
                        'color' => '',
                        'position' => '',
                    ),
                ),
                'title' => array(
                    'label_prefix' => esc_html__('Title', 'et_builder'),
                    'option_category' => 'layout',
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'floting_shape_title_settings',
                    'css' => array(
                        'main' => '%%order_class%% .dnxte-floting-text',
                        'important' => true,
                        'custom_style' => true,
                    ),
                    'default_on_fronts' => array(
                        'color' => '',
                        'position' => '',
                    ),
                ),
            ),
            'background' => false,
            'max_width' => array(
                'options' => array(
                    'max_width' => array(
                        'default' => '50%',
                    ),
                ),
            ),
            'height' => array(
                'css' => array(
                    'main' => '%%order_class%% img',
                    'important' => true,
                ),
            ), 
            'margin_padding' => false,
        );
    }

    public function get_fields()
    {
        return array(
            'floting_shape_use_image' => array(
                'label' => esc_html__('Use Image', 'et_builder'),
                'type' => 'yes_no_button',
                'toggle_slug' => 'floting_shape_content_toggle',
                'options' => array(
                    'on' => esc_html__('Yes', 'et_builder'),
                    'off' => esc_html__('No', 'et_builder'),
                ),
                'affects' => array(
                    'floting_shape_image',
                    'floting_shape_alt',
                    'dnxte_floting_shape_image_margin',
                    'dnxte_floting_shape_image_padding',
                ),
                'default' => 'on',
                'default_on_front' => 'on',
            ),
            'floting_shape_image' => array(
                'label' => esc_html__('Image', 'et_builder'),
                'type' => 'upload',
                'option_category' => 'basic_option',
                'upload_button_text' => esc_attr__('Upload an image', 'et_builder'),
                'choose_text' => esc_attr__('Choose an Image', 'et_builder'),
                'update_text' => esc_attr__('Set As Image', 'et_builder'),
                'description' => esc_html__('Upload an image to display at the top of your blurb.', 'et_builder'),
                'toggle_slug' => 'floting_shape_content_toggle',
                'dynamic_content' => 'image',
                'data_type' => 'image',
                'mobile_options' => true,

            ),
            'floting_shape_alt' => array(
                'label' => esc_html__('Image Alt', 'et_builder'),
                'type' => 'text',
                'dynamic_content' => 'text',
                'default' => 'Floating Item',
                'option_category' => 'basic_option',
                'description' => esc_html__('Text entered here will appear as title.', 'et_builder'),
                'toggle_slug' => 'floting_shape_content_toggle',

            ),
            'floting_shape_use_text' => array(
                'label' => esc_html__('Use Text', 'et_builder'),
                'type' => 'yes_no_button',
                'toggle_slug' => 'floting_shape_content_toggle',
                'options' => array(
                    'on' => esc_html__('Yes', 'et_builder'),
                    'off' => esc_html__('No', 'et_builder'),
                ),
                'affects' => array(
                    'floting_shape_text',
                    'dnxte_floting_shape_title_margin',
                    'dnxte_floting_shape_title_padding',
                ),
                'default' => 'off',
                'default_on_front' => 'off',
                'show_if' => array(
                    'floting_shape_use_image' => 'off',
                ),
            ),
            'floting_shape_text' => array(
                'label' => esc_html__('Text', 'et_builder'),
                'type' => 'text',
                'option_category' => 'basic_option',
                'description' => esc_html__('Input text', 'et_builder'),
                'toggle_slug' => 'floting_shape_content_toggle',
                'dynamic_content' => 'text',
            ),
            'dnxte_floting_shape_default_effects' => array(
                'label' => esc_html__('Use Default Animation', 'et_builder'),
                'type' => 'select',
                'description' => esc_html__('Select the floting shape effect', 'et_builder'),
                'option_category' => 'basic_option',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'floting_shape_animation_settings',
                'options' => array(
                    'one' => esc_html__('Effect 1', 'et_builder'),
                    'two' => esc_html__('Effect 2', 'et_builder'),
                    'three' => esc_html__('Up Down', 'et_builder'),
                    'four' => esc_html__('Move Left/Right', 'et_builder'),
                    'five' => esc_html__('Pulse', 'et_builder'),
                    'six' => esc_html__('Left/Right', 'et_builder'),
                    'seven' => esc_html__('Rotate', 'et_builder'),
                    'custom' => esc_html__('Custom', 'et_builder'),
                ),
                'default' => 'three',
            ),
            'dnxte_floting_shape_effects' => array(
                'label' => esc_html__('Floting Effect', 'et_builder'),
                'type' => 'select',
                'description' => esc_html__('Select the floting shape effect', 'et_builder'),
                'option_category' => 'basic_option',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'floting_shape_animation_settings',
                'options' => array(
                    'dnxtefltmoveone' => esc_html__('Effect 1', 'et_builder'),
                    'dnxtefltmovetwo' => esc_html__('Effect 2', 'et_builder'),
                    'dnxtefltmoveupdown' => esc_html__('Up Down', 'et_builder'),
                    'dnxtefltmovelftright' => esc_html__('Move Left/Right', 'et_builder'),
                    'dnxtefltpulse' => esc_html__('Pulse', 'et_builder'),
                    'dnxtefltleftright' => esc_html__('Left/Right', 'et_builder'),
                    'dnxtefltrotate' => esc_html__('Rotate', 'et_builder'),
                ),
                'default' => 'dnxtefltmoveone',
                'show_if' => array(
                    'dnxte_floting_shape_default_effects' => 'custom',
                ),
            ),
            'dnxte_floting_shape_effects_count_number' => array(
                'label' => esc_html__('Iteration Count Number', 'et_builder'),
                'description' => esc_html__('Adjust the iteration count number of the animation', 'et_builder'),
                'type' => 'range',
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'floting_shape_animation_settings',
                'unitless' => true,
                'fixed_unit' => '',
                'validate_unit' => false,
                'default' => '10',
                'default_on_front' => '',
                'allow_empty' => false,
                'range_settings' => array(
                    'min' => '0',
                    'max' => '100',
                    'step' => '1',
                ),
                'mobile_options' => true,
                'hover' => 'tabs',
                'show_if' => array(
                    'dnxte_floting_shape_effects_count' => 'number',
                ),
            ),
            'dnxte_floting_shape_effects_horizontal' => array(
                'label' => esc_html__('Horizontal Position', 'et_builder'),
                'description' => esc_html__('Adjust the horizontal position of animation item.', 'et_builder'),
                'type' => 'range',
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'floting_shape_animation_settings',
                'allowed_units' => array('em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'default' => '0rem',
                'default_unit' => 'rem',
                'default_on_front' => '0rem',
                'allow_empty' => true,
                'range_settings' => array(
                    'min' => '0',
                    'max' => '100',
                    'step' => '1',
                ),
                'mobile_options' => true,
                'hover' => 'tabs',
            ),
            'dnxte_floting_shape_effects_vertical' => array(
                'label' => esc_html__('Vertical Position', 'et_builder'),
                'description' => esc_html__('Adjust the vertical position of animation item.', 'et_builder'),
                'type' => 'range',
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'floting_shape_animation_settings',
                'allowed_units' => array('em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'default' => '0rem',
                'default_unit' => 'rem',
                'default_on_front' => '0rem',
                'allow_empty' => true,
                'range_settings' => array(
                    'min' => '0',
                    'max' => '100',
                    'step' => '1',
                ),
                'mobile_options' => true,
                'hover' => 'tabs',
            ),
            'dnxte_floting_shape_effects_duration' => array(
                'label' => esc_html__('Animation Duration', 'et_builder'),
                'description' => esc_html__('Adjust the duration of the animation', 'et_builder'),
                'type' => 'range',
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'floting_shape_animation_settings',
                'allowed_units' => array('s', 'ms'),
                'default' => '30s',
                'default_unit' => 's',
                'default_on_front' => '30s',
                'allow_empty' => true,
                'range_settings' => array(
                    'min' => '0',
                    'max' => '100',
                    'step' => '1',
                ),
                'mobile_options' => true,
                'hover' => 'tabs',
                'show_if' => array(
                    'dnxte_floting_shape_default_effects' => 'custom',
                ),
            ),
            'dnxte_floting_shape_effects_direction' => array(
                'label' => esc_html__('Animation Direction', 'et_builder'),
                'type' => 'select',
                'description' => esc_html__('Select direction of the floting shape effect', 'et_builder'),
                'option_category' => 'basic_option',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'floting_shape_animation_settings',
                'options' => array(
                    'normal' => esc_html__('Normal', 'et_builder'),
                    'reverse' => esc_html__('Reverse', 'et_builder'),
                    'alternate' => esc_html__('Alternate', 'et_builder'),
                    'alternate-reverse' => esc_html__('Alternate Reverse', 'et_builder'),
                    'initial' => esc_html__('Initial', 'et_builder'),
                    'inherit' => esc_html__('Inherit', 'et_builder'),
                ),
                'default' => 'alternate',
                'show_if' => array(
                    'dnxte_floting_shape_default_effects' => 'custom',
                ),
            ),
            'dnxte_floting_shape_effects_count' => array(
                'label' => esc_html__('Animation Iteration Count', 'et_builder'),
                'type' => 'select',
                'description' => esc_html__('Select direction of the floting shape effect', 'et_builder'),
                'option_category' => 'basic_option',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'floting_shape_animation_settings',
                'options' => array(
                    'number' => esc_html__('Number', 'et_builder'),
                    'infinite' => esc_html__('Infinite', 'et_builder'),
                    'initial' => esc_html__('Initial', 'et_builder'),
                    'inherit' => esc_html__('Inherit', 'et_builder'),
                ),
                'default' => 'infinite',
                'show_if' => array(
                    'dnxte_floting_shape_default_effects' => 'custom',
                ),
            ),
            'dnxte_floting_shape_effects_count_number' => array(
                'label' => esc_html__('Iteration Count Number', 'et_builder'),
                'description' => esc_html__('Adjust the iteration count number of the animation', 'et_builder'),
                'type' => 'range',
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'floting_shape_animation_settings',
                'unitless' => true,
                'fixed_unit' => '',
                'validate_unit' => false,
                'default' => '10',
                'default_on_front' => '',
                'allow_empty' => false,
                'range_settings' => array(
                    'min' => '0',
                    'max' => '100',
                    'step' => '1',
                ),
                'mobile_options' => true,
                'hover' => 'tabs',
                'show_if' => array(
                    'dnxte_floting_shape_effects_count' => 'number',
                ),
            ),
            'dnxte_floting_shape_effects_timing' => array(
                'label' => esc_html__('Animation Timing Effect', 'et_builder'),
                'type' => 'select',
                'description' => esc_html__('Select direction of the floting shape effect', 'et_builder'),
                'option_category' => 'basic_option',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'floting_shape_animation_settings',
                'options' => array(
                    'ease' => esc_html__('Ease', 'et_builder'),
                    'ease-in' => esc_html__('Ease In', 'et_builder'),
                    'ease-out' => esc_html__('Ease Out', 'et_builder'),
                    'ease-in-out' => esc_html__('Ease In Out', 'et_builder'),
                    'linear' => esc_html__('Linear', 'et_builder'),
                ),
                'default' => 'linear',
                'show_if' => array(
                    'dnxte_floting_shape_default_effects' => 'custom',
                ),
            ),
        );
    }

    public function render($attrs, $content, $render_slug)
    {
        $dnxte_floting_shape_use_image = $this->props['floting_shape_use_image'];
        $dnxte_floting_shape_use_text = $this->props['floting_shape_use_text'];
        $dnxte_floting_shape_default_animation = $this->props['dnxte_floting_shape_default_effects'];

        $dnxte_floting_shape_image = $this->props['floting_shape_image'];
        $dnxte_floting_shape_image_alt = $this->props['floting_shape_alt'];
        $dnxte_floting_shape_text = $this->props['floting_shape_text'];

        // Animation settings
        $dnxte_floting_shape_effect = $this->props['dnxte_floting_shape_effects'];
        $dnxte_floting_shape_effect_duration = $this->props['dnxte_floting_shape_effects_duration'];
        $dnxte_floting_shape_effect_direction = $this->props['dnxte_floting_shape_effects_direction'];
        $dnxte_floting_shape_effect_timing = $this->props['dnxte_floting_shape_effects_timing'];
        $dnxte_floting_shape_effect_count = "";

        if ($this->props['dnxte_floting_shape_effects_count'] === "number") {
            $dnxte_floting_shape_effect_count = (int) $this->props['dnxte_floting_shape_effects_count_number'];
        } else {
            $dnxte_floting_shape_effect_count = $this->props['dnxte_floting_shape_effects_count'];
        }

        $dnxte_floting_shape_animation_style = sprintf('-webkit-animation: %1$s %2$s %3$s %4$s %5$s;
          animation: %1$s %2$s %3$s %4$s %5$s;', esc_attr__($dnxte_floting_shape_effect, 'et_builder'), esc_attr__($dnxte_floting_shape_effect_duration, 'et_builder'), esc_attr__($dnxte_floting_shape_effect_direction, 'et_builder'), $dnxte_floting_shape_effect_count, esc_attr__($dnxte_floting_shape_effect_timing, 'et_builder'));

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .dnxte-fltshape",
            'declaration' => $dnxte_floting_shape_animation_style,
        ));
        // Animation settings end

        $handle_classes = "dnxte-fltshape";

        if ($dnxte_floting_shape_default_animation !== "custom") {
            $handle_classes .= "-" . $dnxte_floting_shape_default_animation;
        }

        if ($dnxte_floting_shape_use_image === "on") {
            $handle_classes .= " dnxte-floting-image";
        } else {
            $handle_classes .= " dnxte-floting-text";
        }

        $floting_item = "";
        if ($dnxte_floting_shape_use_image === "on") {
            $floting_item = sprintf('<img class="%3$s" src="%1$s" alt="%2$s" />', esc_attr__($dnxte_floting_shape_image, 'et_builder'), esc_attr__($dnxte_floting_shape_image_alt, 'et_builder'), esc_attr__($handle_classes, 'et_builder'));
        } elseif ($dnxte_floting_shape_use_text === "on") {
            $floting_item = sprintf('<div class="%2$s">%1$s</div>', esc_attr__($dnxte_floting_shape_text, 'et_builder'), esc_attr__($handle_classes, 'et_builder'));
        }

        // Animation Item Position
        $floating_item_horizontal = $this->props['dnxte_floting_shape_effects_horizontal'];
        $floating_item_horizontal_values = et_pb_responsive_options()->get_property_values($this->props, 'dnxte_floting_shape_effects_horizontal');
        $floating_item_horizontal_tablet = isset($floating_item_horizontal_values['tablet']) ? $floating_item_horizontal_values['tablet'] : '';
        $floating_item_horizontal_phone = isset($floating_item_horizontal_values['phone']) ? $floating_item_horizontal_values['phone'] : '';
        $floating_item_horizontal_hover = $this->get_hover_value('dnxte_floting_shape_effects_horizontal');

        $floating_item_vertical = $this->props['dnxte_floting_shape_effects_vertical'];
        $floating_item_vertical_values = et_pb_responsive_options()->get_property_values($this->props, 'dnxte_floting_shape_effects_vertical');
        $floating_item_vertical_tablet = isset($floating_item_vertical_values['tablet']) ? $floating_item_vertical_values['tablet'] : '';
        $floating_item_vertical_phone = isset($floating_item_vertical_values['phone']) ? $floating_item_vertical_values['phone'] : '';
        $floating_item_vertical_hover = $this->get_hover_value('dnxte_floting_shape_effects_vertical');

        if ("" !== $floating_item_horizontal || "" !== $floating_item_vertical) {
            $floating_item_position_style = sprintf('left: %1$s;top: %2$s;', $floating_item_horizontal, $floating_item_vertical);
            $floating_item_position_style_tablet = sprintf('left: %1$s;top: %2$s;', esc_attr($floating_item_horizontal_tablet), $floating_item_vertical_tablet);

            $floating_item_position_style_phone = sprintf('left: %1$s;top: %2$s;', $floating_item_horizontal_phone, $floating_item_vertical_phone);
            $floating_item_position_style_hover = "";

            if (et_builder_is_hover_enabled('dnxte_floting_shape_effects_horizontal', $this->props) || et_builder_is_hover_enabled('dnxte_floting_shape_effects_vertical', $this->props)) {
                $floating_item_position_style_hover = sprintf('left: %1$s;top: %2$s;', $floating_item_horizontal_hover, $floating_item_vertical_hover);
            }

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte-fltshape,%%order_class%% .dnxte-fltshape-one,%%order_class%% .dnxte-fltshape-two,%%order_class%% .dnxte-fltshape-three,%%order_class%% .dnxte-fltshape-four,%%order_class%% .dnxte-fltshape-five,%%order_class%% .dnxte-fltshape-six,%%order_class%% .dnxte-fltshape-seven",
                'declaration' => $floating_item_position_style,
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte-fltshape,%%order_class%% .dnxte-fltshape-one,%%order_class%% .dnxte-fltshape-two,%%order_class%% .dnxte-fltshape-three,%%order_class%% .dnxte-fltshape-four,%%order_class%% .dnxte-fltshape-five,%%order_class%% .dnxte-fltshape-six,%%order_class%% .dnxte-fltshape-seven",
                'declaration' => $floating_item_position_style_tablet,
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte-fltshape,%%order_class%% .dnxte-fltshape-one,%%order_class%% .dnxte-fltshape-two,%%order_class%% .dnxte-fltshape-three,%%order_class%% .dnxte-fltshape-four,%%order_class%% .dnxte-fltshape-five,%%order_class%% .dnxte-fltshape-six,%%order_class%% .dnxte-fltshape-seven",
                'declaration' => $floating_item_position_style_phone,
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));

            if ("" !== $floating_item_position_style_hover) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => $this->add_hover_to_order_class("%%order_class%% .dnxte-fltshape:hover,%%order_class%% .dnxte-fltshape-one:hover,%%order_class%% .dnxte-fltshape-two:hover,%%order_class%% .dnxte-fltshape-three:hover,%%order_class%% .dnxte-fltshape-four:hover,%%order_class%% .dnxte-fltshape-five:hover,%%order_class%% .dnxte-fltshape-six:hover,%%order_class%% .dnxte-fltshape-seven:hover"),
                    'declaration' => $floating_item_position_style_hover,
                ));
            }
        }
        // Animation Item position end

        return sprintf('%1$s', $floting_item);
    }
}

new Divi_NxteFloatingElementChild;
