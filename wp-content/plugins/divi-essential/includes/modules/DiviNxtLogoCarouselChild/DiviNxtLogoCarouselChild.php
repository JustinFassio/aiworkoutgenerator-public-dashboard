<?php

class Divi_NxtLogoCarouselChild extends ET_Builder_Module
{
    public $slug = 'dnxte_logo_carousel_child';
    public $vb_support = 'on';
    public $type = 'child';
    public $child_title_var = 'title';
    public $child_title_fallback_var = 'logo_carousel_alt';

    protected $module_credits = array(
        'module_uri' => 'https://www.diviessential.com/divi-logo-carousel/',
        'author' => 'Divi Next',
        'author_uri' => 'www.divinext.com',
    );

    public function init()
    {
        $this->name = esc_html__('Logo Carousel Item', 'et_builder');

        $this->settings_modal_toggles = array(
            'general' => array(
                'toggles' => array(
                    'logo_carousel_image_toggle' => esc_html__('Logo', 'et_builder'),
                ),
            ),
            'advanced' => array(
                'toggles' => array(
                    'logo_carousel_image_settings' => esc_html__('Logo Settings', 'et_builder')
                )
            )
        );

        $this->custom_css_fields = array(
            'image' => array(
                'label' => esc_html__('Image', 'et_builder'),
                'selector' => '%%order_class%% .img-fluid',
            ),
        );
    }
    public function get_advanced_fields_config(){
        return array(
            'fonts' => false,
            'text' => false,
            'borders' => array(
                'default' => array(
                    'css' => array(
                        'main' => array(
                            "border_radii" => "%%order_class%% .img-fluid",
                            'border_styles' => '%%order_class%% .img-fluid',
                        ),
                        'important' => 'all',
                    ),
                ),
            ),
            'box_shadow' => array(
                'default' => array(
                    'css' => array(
                        'main' => '%%order_class%% .img-fluid',
                        'important' => 'all',
                    ),
                ),
            ),
            'margin_padding' => array(
                'css' => array(
                    'main' => '%%order_class%% .img-fluid',
                ),
                'important' => 'all',
            ),
            'background' => array(
                'settings' => array(
                    'color' => 'alpha',
                ),
                'css' => array(
                    'main' => "%%order_class%% .img-fluid",
                    'important' => 'all',
                ),
            ),
            'max_width' => false
        );
    }

    public function get_fields()
    {
        return array(
            'logo_carousel_image' => array(
                'label' => esc_html__('Image', 'et_builder'),
                'type' => 'upload',
                'option_category' => 'basic_option',
                'upload_button_text' => esc_attr__('Upload an image', 'et_builder'),
                'choose_text' => esc_attr__('Choose an Image', 'et_builder'),
                'update_text' => esc_attr__('Set As Image', 'et_builder'),
                'description' => esc_html__('Upload an image to display at the top of your blurb.', 'et_builder'),
                'toggle_slug' => 'logo_carousel_image_toggle',
                'dynamic_content' => 'image',
                'data_type' => 'image',
                'mobile_options' => true,
            ),
            'logo_carousel_alt' => array(
                'label' => esc_html__('Image Alt', 'et_builder'),
                'type' => 'text',
                'dynamic_content' => 'text',
                'default' => 'Logo Item',
                'option_category' => 'basic_option',
                'description' => esc_html__('Text entered here will appear as title.', 'et_builder'),
                'toggle_slug' => 'logo_carousel_image_toggle',
            ),
            'logo_carousel_width' => array(
                'label' => esc_html__('Logo Width', 'et_builder'),
                'description' => esc_html__('Adjust the width of the logo.', 'et_builder'),
                'type' => 'range',
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'logo_carousel_image_settings',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'default_unit' => '%',
                'allow_empty' => true,
                'range_settings' => array(
                    'min' => '0',
                    'max' => '100',
                    'step' => '1',
                ),
                'mobile_options' => true,
                'hover' => 'tabs',
            )
        );
    }

    public function render($attrs, $content, $render_slug){
        // image width
        $logo_carousel_width = $this->props['logo_carousel_width'];
        $logo_carousel_width_values = et_pb_responsive_options()->get_property_values($this->props, 'logo_carousel_width');
        $logo_carousel_width_tablet = isset($logo_carousel_width_values['tablet']) ? $logo_carousel_width_values['tablet'] : '';
        $logo_carousel_width_phone = isset($logo_carousel_width_values['phone']) ? $logo_carousel_width_values['phone'] : '';
        $logo_carousel_width_hover = $this->get_hover_value('logo_carousel_width');

        if ("" !== $logo_carousel_width) {
            $logo_carousel_width_style = sprintf('width: %1$s;', esc_attr__($logo_carousel_width, 'et_builder'));
            $logo_carousel_width_style_tablet = sprintf('width: %1$s;', esc_attr__($logo_carousel_width_tablet, 'et_builder'));
            $logo_carousel_width_style_phone = sprintf('width: %1$s;', esc_attr__($logo_carousel_width_phone, 'et_builder'));
            $logo_carousel_width_style_hover = "";

            if (et_builder_is_hover_enabled('logo_carousel_width', $this->props)) {
                $logo_carousel_width_style_hover = sprintf('width: %1$s;', esc_attr__($logo_carousel_width_hover, 'et_builder'));
            }

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .img-fluid",
                'declaration' => $logo_carousel_width_style,
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .img-fluid",
                'declaration' => $logo_carousel_width_style_tablet,
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .img-fluid",
                'declaration' => $logo_carousel_width_style_phone,
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));

            if ("" !== $logo_carousel_width_style_hover) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => $this->add_hover_to_order_class("%%order_class%% .img-fluid:hover"),
                    'declaration' => $logo_carousel_width_style_hover,
                ));
            }
        }
        // image width end
        $output = sprintf(
            '<img class="img-fluid" alt="%2$s" src="%1$s"/>',
            $this->props['logo_carousel_image'],
            esc_attr($this->props['logo_carousel_alt'])
        );
        return $output;
    }
}

new Divi_NxtLogoCarouselChild;
