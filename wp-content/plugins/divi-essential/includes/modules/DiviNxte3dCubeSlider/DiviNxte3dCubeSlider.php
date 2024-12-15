<?php
include_once(DIVI_ESSENTIAL_PATH.'/includes/modules/base/Common.php');

class Divi_Nxte3dCubeSlider extends ET_Builder_Module
{
    public $slug = 'dnxte_3dcubeslider_parent';
    public $vb_support = 'on';
    public $child_slug = 'dnxte_3dcubeslider_child';

    protected $module_credits = array(
        'module_uri' => 'https://www.diviessential.com/divi-3d-cube-slider/',
        'author' => 'Divi Next',
        'author_uri' => 'www.divinext.com',
    );

    public function init()
    {
        $this->name        = esc_html__('Next 3d Cube Slider', 'et_builder');
        $this->icon_path   = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->folder_name = 'et_pb_divi_essential';

        $this->settings_modal_toggles = array(
            'general' => array(
                'toggles' => array(
                    'dnxte_cubeslider_settings' => esc_html__('Slider Settings', 'et_builder'),
                    'dnxte_cubeslider_navigation' => esc_html__('Navigation Settings', 'et_builder'),
                    'dnxte_cubeslider_effect' => esc_html__('Effect Settings', 'et_builder'),

                ),
            ),
            'advanced' => array(
                'toggles' => array(
                    'dnxte_cubeslider_image_settings' => array(
                        'title' => esc_html__('Image Settings', 'et_builder'),
                    ),
                    'dnxte_cubeslider_heading_settings' => array(
                        'title' => esc_html__('Heading Settings')
                    ),
                    'dnxte_cubeslider_content_settings' => array(
                        'title' => esc_html__('Content Settings')
                    ),
                    'dnxte_cubeslider_color_settings' => array(
                        'title' => esc_html__('Color Settings', 'et_builder'),
                    ),
                    'dnxte_cubeslider_arrow_settings' => array(
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
            'heading' => array(
                'label' => esc_html__('Heading', 'et_builder'),
                'selector' => '%%order_class%% .dnxte-3dcubeslider-heading',
            ),
            'content' => array(
                'label' => esc_html__('Content', 'et_builder'),
                'selector' => '%%order_class%% .dnxte-3dcubeslider-pra',
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
            'fonts' => array(
                'header' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnxte-3dcubeslider-heading',
                    ),
                    'toggle_slug' => 'dnxte_cubeslider_heading_settings'
                ),
                'desc' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnxte-3dcubeslider-pra',
                    ),
                    'toggle_slug' => 'dnxte_cubeslider_content_settings'
                )
            ),
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
                    'toggle_slug' => 'dnxte_cubeslider_image_settings',
                ),
                'heading' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => '%%order_class%% .dnxte-3dcubeslider-heading',
                            'border_styles' => '%%order_class%% .dnxte-3dcubeslider-heading',
                        ),
                    ),
                    'label_prefix' => esc_html__('Heading', 'et_builder'),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxte_cubeslider_heading_settings',
                ),
                'content' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => '%%order_class%% .dnxte-3dcubeslider-pra',
                            'border_styles' => '%%order_class%% .dnxte-3dcubeslider-pra',
                        ),
                    ),
                    'label_prefix' => esc_html__('Content', 'et_builder'),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxte_cubeslider_content_settings',
                ),
            ),
            'box_shadow' => array(
                'default' => array(
                    'css' => array(
                        'main' => '%%order_class%% .swiper-container',
                        'important' => 'all',
                    ),
                ),
                'image_box_shadow' => array(
                    'css' => array(
                        'main' => '%%order_class%% .img-fluid',
                        'important' => 'all',
                    ),
                    'label_prefix' => esc_html__('Image', 'et_builder'),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxte_cubeslider_image_settings',
                ),
                'heading' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnxte-3dcubeslider-heading',
                    ),
                    'label_prefix' => esc_html__('Heading', 'et_builder'),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxte_cubeslider_heading_settings',
                ),
                'content' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnxte-3dcubeslider-content',
                    ),
                    'label_prefix' => esc_html__('Content', 'et_builder'),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxte_cubeslider_content_settings',
                ),
            ),
            'margin_padding' => array(
                'css' => array(
                    'margin' => '%%order_class%% .swiper-container',
                    'padding' => '%%order_class%% .img-fluid',
                ),
                'important' => 'all',
            ),
        );
    }

    public function get_fields()
    {
        return array(
            'dnxte_cubeslider_autoplay_show_hide' => array(
                'label' => esc_html__('Autoplay', 'et_builder'),
                'type' => 'yes_no_button',
                'description' => esc_html__('Content entered here will appear inside the module.', 'et_builder'),
                'options' => array(
                    'on' => esc_html__('Yes', 'et_builder'),
                    'off' => esc_html__('No', 'et_builder'),
                ),
                'affects' => array(
                    'dnxte_cubeslider_autoplay_delay',
                ),
                'default' => 'on',
                'default_on_front' => 'on',
                'toggle_slug' => 'dnxte_cubeslider_settings',
            ),
            'dnxte_cubeslider_autoplay_delay' => array(
                'label' => esc_html__('Autoplay Delay', 'et_builder'),
                'type' => 'text',
                'option_category' => 'basic_option',
                'description' => esc_html__('Adjust the autoplay delay in milliseconds (ms)', 'et_builder'),
                'default' => '2000',
                'depends_show_if' => 'on',
                'toggle_slug' => 'dnxte_cubeslider_settings',
            ),
            'dnxte_cubeslider_loop' => array(
                'label' => esc_html__('Loop', 'et_builder'),
                'type' => 'yes_no_button',
                'description' => esc_html__('Content entered here will appear inside the module.', 'et_builder'),
                'options' => array(
                    'on' => esc_html__('Yes', 'et_builder'),
                    'off' => esc_html__('No', 'et_builder'),
                ),
                'default' => 'off',
                'default_on_front' => 'off',
                'toggle_slug' => 'dnxte_cubeslider_settings',
            ),
            'dnxte_cubeslider_grab' => array(
                'label' => esc_html__('Use Grab Cursor', 'et_builder'),
                'type' => 'yes_no_button',
                'description' => esc_html__('Content entered here will appear inside the module.', 'et_builder'),
                'options' => array(
                    'on' => esc_html__('Yes', 'et_builder'),
                    'off' => esc_html__('No', 'et_builder'),
                ),
                'default' => 'off',
                'default_on_front' => 'off',
                'toggle_slug' => 'dnxte_cubeslider_navigation',
            ),
            'dnxte_cubeslider_speed' => array(
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
                'toggle_slug' => 'dnxte_cubeslider_settings',
            ),
            'dnxte_cubeslider_arrows' => array(
                'label' => esc_html__('Use Arrow Navigation', 'et_builder'),
                'type' => 'yes_no_button',
                'description' => esc_html__('Content entered here will appear inside the module.', 'et_builder'),
                'options' => array(
                    'on' => esc_html__('Yes', 'et_builder'),
                    'off' => esc_html__('No', 'et_builder'),
                ),
                'default' => 'off',
                'default_on_front' => 'off',
                'toggle_slug' => 'dnxte_cubeslider_navigation',
            ),
            'dnxte_cubeslider_keyboard_enable' => array(
                'label' => esc_html__('Keyboard Navigation', 'et_builder'),
                'type' => 'yes_no_button',
                'description' => esc_html__('Select on or off to control keyboard navigation.', 'et_builder'),
                'options' => array(
                    'on' => esc_html__('Yes', 'et_builder'),
                    'off' => esc_html__('No', 'et_builder'),
                ),
                'default' => 'on',
                'default_on_front' => 'on',
                'toggle_slug' => 'dnxte_cubeslider_navigation',
            ),
            'dnxte_cubeslider_mousewheel_enable' => array(
                'label' => esc_html__('Mousewheel Navigation', 'et_builder'),
                'type' => 'yes_no_button',
                'description' => esc_html__('Select on or off to control slide useing mousewheel.', 'et_builder'),
                'options' => array(
                    'on' => esc_html__('Yes', 'et_builder'),
                    'off' => esc_html__('No', 'et_builder'),
                ),
                'default' => 'on',
                'default_on_front' => 'on',
                'toggle_slug' => 'dnxte_cubeslider_navigation',
            ),
            'dnxte_cubeslider_pagination_type' => array(
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
                'toggle_slug' => 'dnxte_cubeslider_navigation',
            ),
            'dnxte_cubeslider_pagination_bullets' => array(
                'label' => esc_html__('Dynamic Bullets', 'et_builder'),
                'type' => 'yes_no_button',
                'description' => esc_html__('Content entered here will appear inside the module.', 'et_builder'),
                'options' => array(
                    'on' => esc_html__('Yes', 'et_builder'),
                    'off' => esc_html__('No', 'et_builder'),
                ),
                'default_on_front' => 'on',
                'toggle_slug' => 'dnxte_cubeslider_navigation',
                'show_if' => array(
                    'dnxte_cubeslider_pagination_type' => 'bullets',
                ),
                'show_if_not' => array(
                    'dnxte_cubeslider_pagination_type' => 'none',
                ),
            ),
            'dnxte_cubeslider_arrow_color' => array(
                'label' => esc_html__('Arrow Color', 'et_builder'),
                'type' => 'color-alpha',
                'custom_color' => true,
                'default' => '#0c71c3',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxte_cubeslider_color_settings',
            ),
            'dnxte_cubeslider_arrow_background_color' => array(
                'label' => esc_html__('Arrow Background Color', 'et_builder'),
                'type' => 'color-alpha',
                'custom_color' => true,
                'default' => '#fff',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxte_cubeslider_color_settings',
            ),
            'dnxte_cubeslider_dots_color' => array(
                'label' => esc_html__('Dots Color', 'et_builder'),
                'type' => 'color-alpha',
                'custom_color' => true,
                'default' => '#000',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxte_cubeslider_color_settings',
                'show_if' => array(
                    'dnxte_cubeslider_pagination_type' => 'bullets',
                ),
            ),
            'dnxte_cubeslider_dots_active_color' => array(
                'label' => esc_html__('Dots Active Color', 'et_builder'),
                'type' => 'color-alpha',
                'custom_color' => true,
                'default' => '#0c71c3',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxte_cubeslider_color_settings',
                'show_if' => array(
                    'dnxte_cubeslider_pagination_type' => 'bullets',
                ),
            ),
            'dnxte_cubeslider_progressbar_fill_color' => array(
                'label' => esc_html__('Progressbar Fill Color', 'et_builder'),
                'type' => 'color-alpha',
                'custom_color' => true,
                'default' => '#0c71c3',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxte_cubeslider_color_settings',
                'show_if' => array(
                    'dnxte_cubeslider_pagination_type' => 'progressbar',
                ),
            ),
            'dnxte_cubeslider_shadow_color' => array(
                'label' => esc_html__('Shadow color', 'et_builder'),
                'type' => 'color-alpha',
                'custom_color' => true,
                'default' => '#000',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxte_cubeslider_color_settings',
            ),
            'dnxte_cubeslider_arrow_size' => array(
                'label' => esc_html__('Font Size', 'et_builder'),
                'type' => 'range',
                'option_category' => 'basic_option',
                'range_settings' => array(
                    'step' => 1,
                    'min' => 1,
                    'max' => 100,
                ),
                'default' => '45',
                'fixed_unit' => '',
                'validate_unit' => false,
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxte_cubeslider_arrow_settings',
            ),
            'dnxte_cubeslider_arrow_position' => array(
                'label' => esc_html__('Arrow Position', 'et_builder'),
                'type' => 'select',
                'description' => esc_html__('Select the types of arrow position', 'et_builder'),
                'option_category' => 'basic_option',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxte_cubeslider_arrow_settings',
                'options' => array(
                    'default' => esc_html__('Default', 'et_builder'),
                    'inner' => esc_html__('Inner', 'et_builder'),
                    'outer' => esc_html__('Outer', 'et_builder'),

                ),
                'default' => 'default',
            ),
            'dnxte_cubeslider_arrow_margin' => array(
                'label' => esc_html__('Arrow Margin', 'et_builder'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
                'show_if' => array(
                    'dnxte_cubeslider_arrows' => 'on',
                ),
            ),
            'dnxte_cubeslider_arrow_padding' => array(
                'label' => esc_html__('Arrow Padding', 'et_builder'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
                'show_if' => array(
                    'dnxte_cubeslider_arrows' => 'on',
                ),
            ),
            'dnxte_cubeslider_pause_on_hover' => array(
                'label' => esc_html__('Pause On Hover', 'et_builder'),
                'type' => 'yes_no_button',
                'description' => esc_html__('Content entered here will appear inside the module.', 'et_builder'),
                'options' => array(
                    'on' => esc_html__('Yes', 'et_builder'),
                    'off' => esc_html__('No', 'et_builder'),
                ),
                'default' => 'off',
                'default_on_front' => 'off',
                'toggle_slug' => 'dnxte_cubeslider_settings',
            ),
            'dnxte_cubeslider_slide_shadows' => array(
                'label' => esc_html__('Slide Shadows', 'et_builder'),
                'type' => 'yes_no_button',
                'description' => esc_html__('Content entered here will appear inside the module.', 'et_builder'),
                'options' => array(
                    'on' => esc_html__('Yes', 'et_builder'),
                    'off' => esc_html__('No', 'et_builder'),
                ),
                'default' => 'off',
                'toggle_slug' => 'dnxte_cubeslider_effect',
            ),
            'dnxte_cubeslider_shadow' => array(
                'label' => esc_html__('Shadow', 'et_builder'),
                'type' => 'yes_no_button',
                'description' => esc_html__('Content entered here will appear inside the module.', 'et_builder'),
                'options' => array(
                    'on' => esc_html__('Yes', 'et_builder'),
                    'off' => esc_html__('No', 'et_builder'),
                ),
                'default' => 'off',
                'toggle_slug' => 'dnxte_cubeslider_effect',
            ),
            'dnxte_cubeslider_shadow_offset' => array(
                'label' => esc_html__('Shadow Offset', 'et_builder'),
                'type' => 'range',
                'option_category' => 'basic_option',
                'range_settings' => array(
                    'step' => 1,
                    'min' => 1,
                    'max' => 100,
                ),
                'default' => '20',
                'fixed_unit' => '',
                'validate_unit' => false,
                'toggle_slug' => 'dnxte_cubeslider_effect',
                'show_if' => array(
                    'dnxte_cubeslider_shadow' => 'on',
                ),
            ),
            'dnxte_cubeslider_shadow_scale' => array(
                'label' => esc_html__('Shadow Scale', 'et_builder'),
                'type' => 'range',
                'option_category' => 'basic_option',
                'range_settings' => array(
                    'step' => 0.01,
                    'min' => 0,
                    'max' => 1,
                ),
                'default' => '0',
                'fixed_unit' => '',
                'validate_unit' => false,
                'toggle_slug' => 'dnxte_cubeslider_effect',
                'show_if' => array(
                    'dnxte_cubeslider_shadow' => 'on',
                ),
            ),
        );
    }

    public function render($attrs, $content, $render_slug){
        wp_enqueue_script( 'dnext_swiper_frontend' );
        wp_enqueue_script( 'dnext_3dcube_slider' );
        wp_enqueue_style( 'dnext_swiper-min-css' );
        $content = $this->content;
        $dnxte_cubeslider_autplay_show_hide = "on" === $this->props['dnxte_cubeslider_autoplay_show_hide'];
        $dnxte_cubeslider_autoplay_delay = $this->props['dnxte_cubeslider_autoplay_delay'];
        $dnxte_cubeslider_loop = $this->props['dnxte_cubeslider_loop'];
        $dnxte_cubeslider_speed = $this->props['dnxte_cubeslider_speed'];
        $dnxte_cubeslider_direction = "horizontal";
        $dnxte_cubeslider_pagination_type = $this->props['dnxte_cubeslider_pagination_type'];
        $dnxte_cubeslider_pagination_bullets = $dnxte_cubeslider_pagination_type === 'bullets' ? $this->props['dnxte_cubeslider_pagination_bullets'] : "off";
        $grab_cursor = $this->props['dnxte_cubeslider_grab'];
        $pause_on_hover = "on" === $this->props['dnxte_cubeslider_pause_on_hover'];
        $dnxte_cubeslider_slide_shadows = "on" === $this->props['dnxte_cubeslider_slide_shadows'];
        $dnxte_cubeslider_shadow = "on" === $this->props['dnxte_cubeslider_shadow'];
        $dnxte_cubeslider_shadow_offset = $this->props['dnxte_cubeslider_shadow_offset'];
        $dnxte_cubeslider_shadow_scale = $this->props['dnxte_cubeslider_shadow_scale'];
        $keyboard_enable = $this->props['dnxte_cubeslider_keyboard_enable'];
        $mouse_enable = $this->props['dnxte_cubeslider_mousewheel_enable'];
        $pagination_class = Common::pagination($dnxte_cubeslider_pagination_type, $dnxte_cubeslider_pagination_bullets);
        
        // USE ARROW CLASSES
        $arrowsClass = "";
        if ("off" !== $this->props['dnxte_cubeslider_arrows']) {
            if ($this->props['dnxte_cubeslider_arrow_position'] === 'inner') {
                $arrowsClass = sprintf(
                    '<div class="swiper-button-prev dnexte_cubeslider_arrows_inner_left" data-icon="4"></div>
                     <div class="swiper-button-next dnexte_cubeslider_arrows_inner_right" data-icon="5"></div>'
                );
            } else if ($this->props['dnxte_cubeslider_arrow_position'] === 'outer') {
                $arrowsClass = sprintf(
                    '<div class="swiper-button-prev dnexte_cubeslider_arrows_outer_left" data-icon="4"></div>
                     <div class="swiper-button-next dnexte_cubeslider_arrows_outer_right" data-icon="5"></div>'
                );
            } else {
                $arrowsClass = sprintf(
                    '<div class="swiper-button-prev dnexte_cubeslider_arrows_default_left" data-icon="4"></div>
                   <div class="swiper-button-next dnexte_cubeslider_arrows_default_right" data-icon="5"></div>'
                );
            }
        }

        // ARROW COLOR
        $dnxte_cubeslider_arrow_color = $this->props['dnxte_cubeslider_arrow_color'];
        $dnxte_cubeslider_arrow_background_color = $this->props['dnxte_cubeslider_arrow_background_color'];

        $dnxte_cubeslider_arrow_color_style = sprintf('color: %1$s !important; background-color: %2$s !important;', esc_attr($dnxte_cubeslider_arrow_color), esc_attr($dnxte_cubeslider_arrow_background_color));

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .swiper-button-prev,.swiper-button-next",
            'declaration' => $dnxte_cubeslider_arrow_color_style,
        ));

        // ARROW COLOR END

        // DOTS COLOR START

        $dnxte_cubeslider_dots_color = $this->props['dnxte_cubeslider_dots_color'];
        $dnxte_cubeslider_dots_active_color = $this->props['dnxte_cubeslider_dots_active_color'];

        $dnxte_cubeslider_dots_color_style = sprintf('background-color: %1$s !important;', esc_attr($dnxte_cubeslider_dots_color));
        $dnxte_cubeslider_dots_active_color_style = sprintf('background-color: %1$s !important;', esc_attr($dnxte_cubeslider_dots_active_color));

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .swiper-pagination .swiper-pagination-bullet",
            'declaration' => $dnxte_cubeslider_dots_color_style,
        ));

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .swiper-pagination .swiper-pagination-bullet-active",
            'declaration' => $dnxte_cubeslider_dots_active_color_style,
        ));

        // PROGRESSBAR FILL COLOR START

        $dnxte_cubeslider_progressbar_color = $this->props['dnxte_cubeslider_progressbar_fill_color'];
        $dnxte_cubeslider_progressbar_color_style = sprintf('background-color: %1$s !important;', esc_attr($dnxte_cubeslider_progressbar_color));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .swiper-pagination-progressbar .swiper-pagination-progressbar-fill",
            'declaration' => $dnxte_cubeslider_progressbar_color_style,
        ));

        $dnxte_cubeslider_arrow_size = (int) $this->props['dnxte_cubeslider_arrow_size'];
        $arrow_width = $dnxte_cubeslider_arrow_size + 5;
        $dnxte_cubeslider_arrow_size_style = sprintf('font-size: %1$spx', esc_attr($dnxte_cubeslider_arrow_size));
        $dnxte_cubeslider_arrow_background_width_height = sprintf('width: %1$spx !important;height:%1$spx !important', esc_attr($arrow_width));

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .swiper-button-prev:after,.swiper-button-next:after",
            'declaration' => $dnxte_cubeslider_arrow_size_style,
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .swiper-button-prev,%%order_class%% .swiper-button-next",
            'declaration' => $dnxte_cubeslider_arrow_background_width_height,
        ));

        // Shadow color
        $dnxte_cubeslider_shadow_background_color_style = sprintf('background: %1$s !important;', $this->props['dnxte_cubeslider_shadow_color']);
        if ("on" === $this->props['dnxte_cubeslider_shadow']) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .swiper-cube-shadow",
                'declaration' => $dnxte_cubeslider_shadow_background_color_style,
            ));
        }

        $output = sprintf(
            '<div class="swiper-container dnxte-3dcubeslider-active swiper-container-initialized swiper-container-horizontal" data-autoplay="%2$s" data-delay="%3$s" data-direction="%6$s" data-speed="%5$s" data-loop="%4$s" data-pagination-type="%7$s" data-pagination-bullets="%8$s" data-grab="%11$s" data-pauseonhover="%12$s" data-slideshadows="%13$s" data-shadow="%14$s" data-shadowoffset="%15$s" data-shadowscale="%16$s" data-keyboardenable="%17$s" data-mouse="%18$s">
                <div class="swiper-wrapper">
                    %1$s
                </div>
                <div class="%10$s"></div>
            </div>
            %9$s',
            $content,
            esc_attr($dnxte_cubeslider_autplay_show_hide),
            esc_attr($dnxte_cubeslider_autoplay_delay),
            esc_attr($dnxte_cubeslider_loop),
            esc_attr($dnxte_cubeslider_speed), // #5
            esc_attr($dnxte_cubeslider_direction),
            esc_attr($dnxte_cubeslider_pagination_type),
            esc_attr($dnxte_cubeslider_pagination_bullets),
            $arrowsClass,
            esc_attr($pagination_class), // #10
            esc_attr($grab_cursor),
            esc_attr($pause_on_hover),
            esc_attr($dnxte_cubeslider_slide_shadows),
            esc_attr($dnxte_cubeslider_shadow),
            esc_attr($dnxte_cubeslider_shadow_offset), // #15
            esc_attr($dnxte_cubeslider_shadow_scale),
            esc_attr($keyboard_enable),
            esc_attr($mouse_enable)
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
        Common::dnxt_set_style($render_slug, $this->props, "dnxte_cubeslider_arrow_margin", "%%order_class%% .swiper-button-next,%%order_class%% .swiper-button-prev", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "dnxte_cubeslider_arrow_padding", "%%order_class%% .swiper-button-next, %%order_class%% .swiper-button-prev", "padding");
    }
}

new Divi_Nxte3dCubeSlider;
