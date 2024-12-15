<?php
class DiviNextImageMagnifier extends ET_Builder_Module {
    public $slug = 'dnxte_image_magnifier';
    public $vb_support = 'on';

    protected $module_credits = array(
        'module_uri' => 'https://www.diviessential.com/divi-image-magnifier/',
        'author' => 'Divi Next',
        'author_uri' => 'www.divinext.com',
    );


    public function init(){
        $this->name        = esc_html__('Next Image Magnifier', 'et_builder');
        $this->icon_path   = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->folder_name = 'et_pb_divi_essential';

        $this->settings_modal_toggles = array(
            'general' => array(
                'toggles' => array(
                    'magnifier_elements' => esc_html__('Image', 'et_builder'),
                    'magnifier_settings' => esc_html__('Magnifier Settings', 'et_builder'),
                )
                ),
            'advanced' => array(
                'toggles' => array(
                    'lens_settings' => esc_html__('Lens Settings', 'et_builder'),
                    'image_settings' => esc_html__('Image Settings', 'et_builder')
                )
            )
        );

        $this->custom_css_fields = array(
            'image' => array(
                'label' => esc_html__('Image', 'et_builder'),
                'selector' => '%%order_class%% .dnxte-magnifier-zoom',
            ),
            'lens' => array(
                'label' => esc_html__('Lens', 'et_builder'),
                'selector' => '%%order_class%% .magnify-lens',
            ),
        );
    }

    public function get_advanced_fields_config(){
        return array(
            'text' => false,
            'fonts' => false,
            'background' => array(
                'css' => array(
                    'main' => '%%order_class%% .dnxte-magnifier-zoom'
                )
            ),
            'borders' => array(
                'lens' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => "%%order_class%% .magnify-lens",
                            'border_styles' => "%%order_class%% .magnify-lens",
                        ),
                        'important' => "all"
                    ),
                    'label_prefix' => esc_html__('Lens', 'et_builder'),
                    'toggle_slug' => 'lens_settings',
                ),
                'image' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => "%%order_class%% .dnxte-magnifier-zoom",
                            'border_styles' => "%%order_class%% .dnxte-magnifier-zoom",
                        ),
                        'important' => 'all'
                    ),
                    'label_prefix' => esc_html__('Image', 'et_builder'),
                    'toggle_slug' => 'image_settings',
                ),
            ),
            'box_shadow' => array(
                'lens' => array(
                    'label' => esc_html__('Lens Box Shadow', 'et_builder'),
                    'option_category' => 'layout',
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'lens_settings',
                    'css' => array(
                        'main' => '%%order_class%% .magnify-lens',
                        'important' => true,
                        'custom_style' => true,
                    ),
                    'default_on_fronts' => array(
                        'color' => '',
                        'position' => '',
                    ),
                ),
                'image' => array(
                    'label' => esc_html__('Image Box Shadow', 'et_builder'),
                    'option_category' => 'layout',
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'image_settings',
                    'css' => array(
                        'main' => '%%order_class%% .dnxte-magnifier-zoom',
                        'custom_style' => true,
                    ),
                    'default_on_fronts' => array(
                        'color' => '',
                        'position' => '',
                    ),
                ),
            ),
            'margin_padding' => array(
                'css' => array(
                    'margin' => '%%order_class%% .dnxte-magnifier-zoom',
                    'padding' => '%%order_class%% .dnxte-magnifier-zoom',
                ),
            )
        );
    }

    public function get_fields() {
        return array(
            'magnifier_upload' => array(
                'label' => esc_html__("Image Upload", 'et_builder'),
                'type' => 'upload',
                'toggle_slug' => 'magnifier_elements',
                'option_category' => 'basic_option',
                'upload_button_text' => esc_html__('Upload a image', 'et_builder'),
                'choose_text' => esc_attr__('Choose a image', 'et_builder'),
                'update_text' => esc_attr__('Update image', 'et_builder'),
                'data_type' => 'image',
            ),
            'image_alt' => array(
                'label' => esc_html__('Image Alt', 'et_builder'),
                'type' => 'text',
                'option_category' => 'basic_option',
                'description' => esc_html__('Input image alt text', 'et_builder'),
                'toggle_slug' => 'magnifier_elements',
            ),
            'magnifier_speed' => array(
                'label' => esc_html__('Speed', 'et_builder'),
                'description' => esc_html__('Adjust the speed of the magnifying glass.', 'et_builder'),
                'type' => 'range',
                'option_category' => 'layout',
                'toggle_slug' => 'magnifier_settings',
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
            ),
            'magnifier_limit_boundary' => array(
                'label' => esc_html__('User Boundary Limit', 'et_builder'),
                'type' => 'yes_no_button',
                'toggle_slug' => 'magnifier_settings',
                'options' => array(
                    'on' => esc_html__('Yes', 'et_builder'),
                    'off' => esc_html__('No', 'et_builder'),
                ),
                'default_on_front' => 'on',
            ),
            'magnifier_lens_width' => array(
                'label' => esc_html__('Lens Width', 'et_builder'),
                'description' => esc_html__('Adjust the width of the lens.', 'et_builder'),
                'type' => 'range',
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'lens_settings',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'default' => '100px',
                'default_unit' => 'px',
                'default_on_front' => '100px',
                'allow_empty' => true,
                'range_settings' => array(
                    'min' => '0',
                    'max' => '1000',
                    'step' => '1',
                ),
                'mobile_options' => true,
            ),
        );
    }

    public function render($attrs, $content, $render_slug) {
        wp_enqueue_style( 'dnext_magnify_css' );
        wp_enqueue_script( 'dnext_magnifier' );
        wp_enqueue_script( 'dnext_scripts-public' );
        // Lens width height
        $magnifier_lens_width = $this->props['magnifier_lens_width'];
        $magnifier_lens_width_values = et_pb_responsive_options()->get_property_values($this->props, 'magnifier_lens_width');
        $magnifier_lens_width_tablet = isset($magnifier_lens_width_values['tablet']) ? $magnifier_lens_width_values['tablet'] : '';
        $magnifier_lens_width_phone = isset($magnifier_lens_width_values['phone']) ? $magnifier_lens_width_values['phone'] : '';
        $magnifier_lens_width_hover = $this->get_hover_value('magnifier_lens_width');


        if ("" !== $magnifier_lens_width) {
            $lens_size_style = sprintf('width: %1$s !important;height: %1$s !important', esc_attr__($magnifier_lens_width, 'et_builder'));
            $lens_size_style_tablet = sprintf('width: %1$s !important;height: %1$s !important;', esc_attr__($magnifier_lens_width_tablet, 'et_builder'));

            $lens_size_style_phone = sprintf('width: %1$s !important;height: %1$s !important;', esc_attr__($magnifier_lens_width_phone, 'et_builder'));
            $lens_size_style_hover = "";

            if (et_builder_is_hover_enabled('magnifier_lens_width', $this->props)) {
                $lens_size_style_hover = sprintf('width: %1$s !important;height: %1$s !important;', esc_attr__($magnifier_lens_width_hover, 'et_builder'));
            }

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .magnify-lens",
                'declaration' => $lens_size_style,
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .magnify-lens",
                'declaration' => $lens_size_style_tablet,
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .magnify-lens",
                'declaration' => $lens_size_style_phone,
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));

            if ("" !== $lens_size_style_hover) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => $this->add_hover_to_order_class("%%order_class%% .magnify-lens:hover"),
                    'declaration' => $lens_size_style_hover,
                ));
            }
        }
        // Lens width height end

        return sprintf('
        <div class="dnxte-magnifier">
            <img src="%1$s" class="dnxte-magnifier-zoom" data-magnify-src="%1$s" data-speed="%2$s" data-boundary="%3$s"> 
        </div>',
        $this->props['magnifier_upload'],
        $this->props['magnifier_speed'],
        $this->props['magnifier_limit_boundary']
    );
    }
}

new DiviNextImageMagnifier;