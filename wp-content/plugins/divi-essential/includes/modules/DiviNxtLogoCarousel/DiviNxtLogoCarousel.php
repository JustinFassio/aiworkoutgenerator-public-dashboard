<?php
include_once(DIVI_ESSENTIAL_PATH.'/includes/modules/base/Common.php');

class Divi_NxtLogoCarousel extends ET_Builder_Module
{
    public $slug = 'dnxte_logo_carousel_parent';
    public $vb_support = 'on';
    public $child_slug = 'dnxte_logo_carousel_child';

    protected $module_credits = array(
        'module_uri' => 'https://www.diviessential.com/divi-logo-carousel/',
        'author' => 'Divi Next',
        'author_uri' => 'www.divinext.com',
    );

    public function init()
    {
        $this->name        = esc_html__('Next Logo Carousel', 'et_builder');
        $this->icon_path   = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->folder_name = 'et_pb_divi_essential';

        $this->settings_modal_toggles = array(
            'general' => array(
                'toggles' => array(
                    'dnxt_logo_carousel_settings' => esc_html__('Carousel Settings', 'et_builder'),
                    'dnxt_logo_carousel_navigation' => esc_html__('Navigation Settings', 'et_builder'),
                ),
            ),
            'advanced' => array(
                'toggles' => array(
                    'dnxt_logo_carousel_image_border' => array(
                        'title' => esc_html__('Image Border', 'et_builder'),
                    ),
                    'dnxt_logo_carousel_image_box_shadow' => array(
                        'title' => esc_html__('Image Box Shadow', 'et_builder'),
                    ),
                    'dnxt_logo_carousel_color_settings' => array(
                        'title' => esc_html__('Color Settings', 'et_builder'),
                    ),
                    'dnxt_logo_carousel_arrow_settings' => array(
                        'title' => esc_html__('Arrow Settings', 'et_builder'),
                    ),
                ),
            ),
        );

        $this->custom_css_fields = array(
            'image' => array(
                'label' => esc_html__('Image', 'et_builder'),
                'selector' => '%%order_class%% .img-fluid',
            ),
        );
    }

    public function get_advanced_fields_config()
    {
        return array(
            'background' => array(
                'settings' => array(
                    'color' => 'alpha',
                ),
                'css' => array(
                    'main' => "%%order_class%% .swiper-container",
                    'important' => true,
                ),
            ),
            'fonts' => false,
            'text' => false,
            'borders' => array(
                'default' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => '%%order_class%% .swiper-container',
                            'border_styles' => '%%order_class%% .swiper-container',
                        ),
                        'important' => 'all',
                    ),
                ),
                'image_border' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => '%%order_class%% .img-fluid',
                            'border_styles' => '%%order_class%% .img-fluid',
                        ),
                        'important' => 'all',
                    ),
                    'label_prefix' => esc_html__('Image', 'et_builder'),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxt_logo_carousel_image_border',
                ),
            ),
            'box_shadow' => array(
                'default' => array(),
                'image_box_shadow' => array(
                    'css' => array(
                        'main' => '%%order_class%% .img-fluid',
                        'important' => 'all',
                    ),
                    'label_prefix' => esc_html__('Image', 'et_builder'),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxt_logo_carousel_image_box_shadow',
                ),
            ),
            'margin_padding' => array(
                'css' => array(
                    'main' => '%%order_class%% .swiper-container',
                ),
                'important' => 'all',
            ),
            'max_width' => false,
        );
    }

    public function get_fields()
    {
        return array(
            'dnxt_carousel_autoplay_show_hide' => array(
                'label' => esc_html__('Autoplay', 'et_builder'),
                'type' => 'yes_no_button',
                'description' => esc_html__('Content entered here will appear inside the module.', 'et_builder'),
                'options' => array(
                    'on' => esc_html__('Yes', 'et_builder'),
                    'off' => esc_html__('No', 'et_builder'),
                ),
                'affects' => array(
                    'dnxt_carousel_autoplay_delay',
                ),
                'default' => 'on',
                'default_on_front' => 'on',
                'toggle_slug' => 'dnxt_logo_carousel_settings',
            ),
            'dnxt_carousel_autoplay_delay' => array(
                'label' => esc_html__('Autoplay Delay', 'et_builder'),
                'type' => 'text',
                'option_category' => 'basic_option',
                'description' => esc_html__('Adjust the autoplay delay in milliseconds (ms)', 'et_builder'),
                'default' => '2000',
                'depends_show_if' => 'on',
                'toggle_slug' => 'dnxt_logo_carousel_settings',
            ),
            'dnxt_carousel_loop' => array(
                'label' => esc_html__('Loop', 'et_builder'),
                'type' => 'yes_no_button',
                'description' => esc_html__('Content entered here will appear inside the module.', 'et_builder'),
                'options' => array(
                    'on' => esc_html__('Yes', 'et_builder'),
                    'off' => esc_html__('No', 'et_builder'),
                ),
                'default' => 'off',
                'default_on_front' => 'off',
                'toggle_slug' => 'dnxt_logo_carousel_settings',
            ),
            'dnxt_carousel_centered_slides' => array(
                'label' => esc_html__('Center Slide', 'et_builder'),
                'type' => 'yes_no_button',
                'description' => esc_html__('Content entered here will appear inside the module.', 'et_builder'),
                'options' => array(
                    'on' => esc_html__('Yes', 'et_builder'),
                    'off' => esc_html__('No', 'et_builder'),
                ),
                'default' => 'off',
                'default_on_front' => 'off',
                'toggle_slug' => 'dnxt_logo_carousel_settings',
            ),
            'dnxt_carousel_grab' => array(
                'label' => esc_html__('Use Grab Cursor', 'et_builder'),
                'type' => 'yes_no_button',
                'description' => esc_html__('Content entered here will appear inside the module.', 'et_builder'),
                'options' => array(
                    'on' => esc_html__('Yes', 'et_builder'),
                    'off' => esc_html__('No', 'et_builder'),
                ),
                'default' => 'off',
                'default_on_front' => 'off',
                'toggle_slug' => 'dnxt_logo_carousel_navigation',
            ),
            'dnxt_carousel_speed' => array(
                'label' => esc_html__('Speed', 'et_builder'),
                'type' => 'range',
                'option_category' => 'basic_option',
                'range_settings' => array(
                    'step' => 1,
                    'min' => 1,
                    'max' => 1000,
                ),
                'default' => '400',
                'fixed_unit' => '',
                'validate_unit' => false,
                'unitless' => true,
                'toggle_slug' => 'dnxt_logo_carousel_settings',
            ),
            'dnxt_carousel_spacebetween' => array(
                'label' => esc_html__('Space Between', 'et_builder'),
                'type' => 'range',
                'option_category' => 'basic_option',
                'range_settings' => array(
                    'step' => 1,
                    'min' => 1,
                    'max' => 300,
                ),
                'default' => '15',
                'fixed_unit' => '',
                'validate_unit' => false,
                'unitless' => true,
                'toggle_slug' => 'dnxt_logo_carousel_settings',
            ),
            'dnxt_carousel_arrows' => array(
                'label' => esc_html__('Use Arrow Navigation', 'et_builder'),
                'type' => 'yes_no_button',
                'description' => esc_html__('Content entered here will appear inside the module.', 'et_builder'),
                'options' => array(
                    'on' => esc_html__('Yes', 'et_builder'),
                    'off' => esc_html__('No', 'et_builder'),
                ),
                'default' => 'off',
                'default_on_front' => 'off',
                'toggle_slug' => 'dnxt_logo_carousel_navigation',
            ),
            'dnxt_carousel_keyboard_enable' => array(
                'label'           => esc_html__( 'Keyboard Navigation', 'et_builder'),
                'type'            => 'yes_no_button',
                'description'     => esc_html__( 'Select on or off to control keyboard navigation.', 'et_builder' ),                                                
                'options'               => array(
                    'on'  => esc_html__( 'Yes', 'et_builder' ),
                    'off' => esc_html__( 'No', 'et_builder' ),
                ),
                'default'          => 'on',
                'default_on_front' => 'on',
                'toggle_slug'      => 'dnxt_logo_carousel_navigation'
            ),
            'dnxt_carousel_mousewheel_enable' => array(
                'label'           => esc_html__( 'Mousewheel Navigation', 'et_builder'),
                'type'            => 'yes_no_button',
                'description'     => esc_html__( 'Select on or off to control slide using mousewheel.', 'et_builder' ),                                                
                'options'               => array(
                    'on'  => esc_html__( 'Yes', 'et_builder' ),
                    'off' => esc_html__( 'No', 'et_builder' ),
                ),
                'default'          => 'on',
                'default_on_front' => 'on',
                'toggle_slug'      => 'dnxt_logo_carousel_navigation'
            ),
            'dnxt_carousel_pagination_type' => array(
                'label' => esc_html__('Type', 'et_builder'),
                'type' => 'select',
                'option_category' => 'basic_option',
                'options' => array(
                    'none' => esc_html__('None', 'et_builder'),
                    'bullets' => esc_html__('Bullets', 'et_builder'),
                    'fraction' => esc_html__('Fraction', 'et_builder'),
                    'progressbar' => esc_html__('Progress Bar', 'et_builder'),
                ),
                'default' => 'bullets',
                'toggle_slug' => 'dnxt_logo_carousel_navigation',
            ),
            'dnxt_carousel_pagination_bullets' => array(
                'label' => esc_html__('Dynamic Bullets', 'et_builder'),
                'type' => 'yes_no_button',
                'description' => esc_html__('Content entered here will appear inside the module.', 'et_builder'),
                'options' => array(
                    'on' => esc_html__('Yes', 'et_builder'),
                    'off' => esc_html__('No', 'et_builder'),
                ),
                'default_on_front' => 'on',
                'toggle_slug' => 'dnxt_logo_carousel_navigation',
                'show_if' => array(
                    'dnxt_carousel_pagination_type' => 'bullets',
                ),
                'show_if_not' => array(
                    'dnxt_carousel_pagination_type' => 'none',
                ),
            ),
            'dnxt_carousel_rtl' => array(
                'label' => esc_html__('Rtl Direction', 'et_builder'),
                'type' => 'yes_no_button',
                // 'description' => esc_html__('Content entered here will appear inside the module.', 'et_builder'),
                'options' => array(
                    'on' => esc_html__('Yes', 'et_builder'),
                    'off' => esc_html__('No', 'et_builder'),
                ),
                'default_on_front' => 'off',
                'toggle_slug' => 'dnxt_logo_carousel_navigation',
            ),
            'dnxt_carousel_breakpoint_desktop' => array(
                'label' => esc_html__('Slides Per View', 'et_builder'),
                'type' => 'text',
                'option_category' => 'basic_option',
                'description' => esc_html__('Content entered here will appear inside the module.', 'et_builder'),
                'default' => '4',
                'default_on_front' => '4',
                'mobile_options' => true,
                'responsive' => true,
                'toggle_slug' => 'dnxt_logo_carousel_settings',
            ),
            'dnxt_carousel_arrow_color' => array(
                'label' => esc_html__('Arrow Color', 'et_builder'),
                'type' => 'color-alpha',
                'custom_color' => true,
                'default' => '#0c71c3',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxt_logo_carousel_color_settings',
            ),
            'dnxt_carousel_arrow_background_color' => array(
                'label' => esc_html__('Arrow Background Color', 'et_builder'),
                'type' => 'color-alpha',
                'custom_color' => true,
                'default' => '#fff',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxt_logo_carousel_color_settings',
            ),
            'dnxt_carousel_dots_color' => array(
                'label' => esc_html__('Dots Color', 'et_builder'),
                'type' => 'color-alpha',
                'custom_color' => true,
                'default' => '#000',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxt_logo_carousel_color_settings',
                'show_if' => array(
                    'dnxt_carousel_pagination_type' => 'bullets',
                ),
            ),
            'dnxt_carousel_dots_active_color' => array(
                'label' => esc_html__('Dots Active Color', 'et_builder'),
                'type' => 'color-alpha',
                'custom_color' => true,
                'default' => '#0c71c3',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxt_logo_carousel_color_settings',
                'show_if' => array(
                    'dnxt_carousel_pagination_type' => 'bullets',
                ),
            ),
            'dnxt_carousel_progressbar_fill_color' => array(
                'label' => esc_html__('Progressbar Fill Color', 'et_builder'),
                'type' => 'color-alpha',
                'custom_color' => true,
                'default' => '#0c71c3',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxt_logo_carousel_color_settings',
                'show_if' => array(
                    'dnxt_carousel_pagination_type' => 'progressbar',
                ),
            ),
            'dnxt_carousel_arrow_size' => array(
                'label' => esc_html__('Font Size', 'et_builder'),
                'type' => 'range',
                'option_category' => 'basic_option',
                'range_settings' => array(
                    'step' => 1,
                    'min' => 1,
                    'max' => 100,
                ),
                'default' => '60',
                'fixed_unit' => '',
                'validate_unit' => false,
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxt_logo_carousel_arrow_settings',
            ),
            'dnxt_carousel_arrow_position' => array(
                'label' => esc_html__('Arrow Position', 'et_builder'),
                'type' => 'select',
                'description' => esc_html__('Select the types of arrow position', 'et_builder'),
                'option_category' => 'basic_option',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxt_logo_carousel_arrow_settings',
                'options' => array(
                    'default' => esc_html__('Default', 'et_builder'),
                    'inner' => esc_html__('Inner', 'et_builder'),
                    'outer' => esc_html__('Outer', 'et_builder'),

                ),
                'default' => 'default',
            ),
            'dnxt_carousel_arrow_margin' => array(
                'label' => esc_html__('Arrow Margin', 'et_builder'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'dnxt_carousel_arrow_padding' => array(
                'label' => esc_html__('Arrow Padding', 'et_builder'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'dnxt_carousel_pause_on_hover' => array(
                'label' => esc_html__('Pause On Hover', 'et_builder'),
                'type' => 'yes_no_button',
                'description' => esc_html__('Content entered here will appear inside the module.', 'et_builder'),
                'options' => array(
                    'on' => esc_html__('Yes', 'et_builder'),
                    'off' => esc_html__('No', 'et_builder'),
                ),
                'default' => 'off',
                'default_on_front' => 'off',
                'toggle_slug' => 'dnxt_logo_carousel_settings',
            ),
        );
    }

    public function render($attrs, $content, $render_slug)
    {
        wp_enqueue_script( 'dnext_swiper_frontend' );
        wp_enqueue_script( 'dnext_logo_carousel' );
        wp_enqueue_style( 'dnext_swiper-min-css' );
        $content = $this->content;
        $dnxt_autplay_show_hide = "on" === $this->props['dnxt_carousel_autoplay_show_hide'];
        $dnxt_autoplay_delay = $this->props['dnxt_carousel_autoplay_delay'];
        $dnxt_carousel_loop = $this->props['dnxt_carousel_loop'];
        $dnxt_carousel_speed = $this->props['dnxt_carousel_speed'];
        $keyboard_enable = $this->props['dnxt_carousel_keyboard_enable'];
        $mousewheel_enable = $this->props['dnxt_carousel_mousewheel_enable'];
        $dnxt_carousel_slides_perview_desktop = $this->props['dnxt_carousel_breakpoint_desktop'];
        $dnxt_carousel_slides_perview_desktop_tablet = $this->props['dnxt_carousel_breakpoint_desktop_tablet'];
        $dnxt_carousel_slides_perview_desktop_phone = $this->props['dnxt_carousel_breakpoint_desktop_phone'];
        $dnxt_carousel_slides_perview_desktop_last_edited = $this->props['dnxt_carousel_breakpoint_desktop_last_edited'];

        $dnxt_carousel_direction = "horizontal";
        $dnxt_carousel_pagination_type = $this->props['dnxt_carousel_pagination_type'];
        $dnxt_carousel_pagination_bullets = $dnxt_carousel_pagination_type === 'bullets' ? $this->props['dnxt_carousel_pagination_bullets'] : "off";
        $space_between = $this->props['dnxt_carousel_spacebetween'];
        $grab_cursor = $this->props['dnxt_carousel_grab'];
        $center_slide = $this->props['dnxt_carousel_centered_slides'];
        $pause_on_hover = "on" === $this->props['dnxt_carousel_pause_on_hover'];
        $pagination_class = Common::pagination($dnxt_carousel_pagination_type, $dnxt_carousel_pagination_bullets);

        $rtl = "on" == $this->props['dnxt_carousel_rtl'] ? "dir='rtl'" : "";


        if ('' !== $dnxt_carousel_slides_perview_desktop_tablet || '' !== $dnxt_carousel_slides_perview_desktop_phone || '' !== $dnxt_carousel_slides_perview_desktop) {
            $is_responsive = et_pb_get_responsive_status($dnxt_carousel_slides_perview_desktop_last_edited);

            $slide_to_show_values = array(
                'desktop' => $dnxt_carousel_slides_perview_desktop,
                'tablet' => $is_responsive ? $dnxt_carousel_slides_perview_desktop_tablet : '',
                'phone' => $is_responsive ? $dnxt_carousel_slides_perview_desktop_phone : '',
            );
        }

        // USE ARROW CLASSES
        $arrowsClass = "";
        if ("off" !== $this->props['dnxt_carousel_arrows']) {
            if ($this->props['dnxt_carousel_arrow_position'] === 'inner') {
                $arrowsClass = sprintf(
                    '<div class="swiper-button-prev dnext_logo_carousel_arrows_inner_left" data-icon="4"></div>
                    <div class="swiper-button-next dnext_logo_carousel_arrows_inner_right" data-icon="5"></div>'
                );
            } else if ($this->props['dnxt_carousel_arrow_position'] === 'outer') {
                $arrowsClass = sprintf(
                    '<div class="swiper-button-prev dnext_logo_carousel_arrows_outer_left" data-icon="4"></div>
                    <div class="swiper-button-next dnext_logo_carousel_arrows_outer_right" data-icon="5"></div>'
                );
            } else {
                $arrowsClass = sprintf(
                    '<div class="swiper-button-prev dnext_logo_carousel_arrows_default_left" data-icon="4"></div>
                  <div class="swiper-button-next dnext_logo_carousel_arrows_default_right" data-icon="5"></div>'
                );
            }
        }

        // ARROW COLOR

        $dnxt_logo_arrow_color = $this->props['dnxt_carousel_arrow_color'];
        $dnxt_logo_arrow_background_color = $this->props['dnxt_carousel_arrow_background_color'];

        $dnxt_logo_arrow_color_style = sprintf('color: %1$s !important; background-color: %2$s !important;', esc_attr($dnxt_logo_arrow_color), esc_attr($dnxt_logo_arrow_background_color));

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .swiper-button-prev, %%order_class%% .swiper-button-next",
            'declaration' => $dnxt_logo_arrow_color_style,
        ));

        // ARROW COLOR END

        // DOTS COLOR START

        $dnxt_logo_dots_color = $this->props['dnxt_carousel_dots_color'];
        $dnxt_logo_dots_active_color = $this->props['dnxt_carousel_dots_active_color'];

        $dnxt_logo_dots_color_style = sprintf('background-color: %1$s !important;', esc_attr($dnxt_logo_dots_color));
        $dnxt_logo_dots_active_color_style = sprintf('background-color: %1$s !important;', esc_attr($dnxt_logo_dots_active_color));

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .swiper-pagination .swiper-pagination-bullet",
            'declaration' => $dnxt_logo_dots_color_style,
        ));

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .swiper-pagination .swiper-pagination-bullet-active",
            'declaration' => $dnxt_logo_dots_active_color_style,
        ));

        // PROGRESSBAR FILL COLOR START

        $dnxt_logo_progressbar_color = $this->props['dnxt_carousel_progressbar_fill_color'];
        $dnxt_logo_progressbar_color_style = sprintf('background-color: %1$s !important;', esc_attr($dnxt_logo_progressbar_color));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .swiper-pagination-progressbar .swiper-pagination-progressbar-fill",
            'declaration' => $dnxt_logo_progressbar_color_style,
        ));

        $dnxt_logo_arrow_size = (int) $this->props['dnxt_carousel_arrow_size'];
        $arrow_width = $dnxt_logo_arrow_size - 15;
        $dnxt_logo_arrow_size_style = sprintf('font-size: %1$spx', esc_attr($dnxt_logo_arrow_size));
        $dnxt_logo_arrow_background_width_height = sprintf('width: %1$spx !important;height:%1$spx !important', esc_attr($arrow_width));

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .swiper-button-prev:after, %%order_class%% .swiper-button-next:after",
            'declaration' => $dnxt_logo_arrow_size_style,
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .swiper-button-prev,%%order_class%% .swiper-button-next",
            'declaration' => $dnxt_logo_arrow_background_width_height,
        ));

        $output = sprintf(
            '<div %20$s class="swiper-container dnext-logo-carosuel-active swiper-container-initialized swiper-container-horizontal" data-autoplay="%2$s" data-delay="%3$s" data-direction="%9$s" data-speed="%5$s" data-loop="%4$s" data-pagination-type="%10$s" data-pagination-bullets="%11$s" data-breakpoints="%6$s|%7$s|%8$s" data-spacing="%14$s" data-grab="%15$s" data-center="%16$s" data-pauseonhover="%17$s" data-keyboard="%18$s" data-mouse="%19$s">
                <div class="swiper-wrapper">
                    %1$s
                </div>
                <div class="%13$s"></div>
            </div>
            %12$s',
            $content,
            esc_attr($dnxt_autplay_show_hide),
            esc_attr($dnxt_autoplay_delay),
            esc_attr($dnxt_carousel_loop),
            esc_attr($dnxt_carousel_speed), // #5
            esc_attr($dnxt_carousel_slides_perview_desktop),
            '' !== $slide_to_show_values['tablet'] ? esc_attr($slide_to_show_values['tablet']) : 1,
            '' !== $slide_to_show_values['phone'] ? esc_attr($slide_to_show_values['phone']) : '1',
            esc_attr($dnxt_carousel_direction),
            esc_attr($dnxt_carousel_pagination_type), // #10
            esc_attr($dnxt_carousel_pagination_bullets),
            $arrowsClass,
            esc_attr($pagination_class),
            esc_attr($space_between),
            esc_attr($grab_cursor), // #15
            esc_attr($center_slide),
            esc_attr($pause_on_hover),
            esc_attr($keyboard_enable),
            esc_attr($mousewheel_enable),
            $rtl
        );

        $this->apply_css($render_slug);
        return $this->_render_module_wrapper($output, $render_slug);
    }

    public function apply_css($render_slug)
    {

        /**
         * Custom Padding Margin Output
         *
         */
        Common::dnxt_set_style($render_slug, $this->props, "dnxt_carousel_arrow_margin", "%%order_class%% .swiper-button-next,%%order_class%% .swiper-button-prev", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "dnxt_carousel_arrow_padding", "%%order_class%% .swiper-button-next, %%order_class%% .swiper-button-prev", "padding");
    }
}

new Divi_NxtLogoCarousel;
