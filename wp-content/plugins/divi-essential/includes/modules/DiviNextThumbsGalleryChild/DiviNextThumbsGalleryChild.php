<?php

class Divi_NextThumbsGalleryChild extends ET_Builder_Module
{
    public $slug = 'dnxte_thumbs_gallery_child';
    public $vb_support = 'on';
    public $type = 'child';
    public $child_title_var = 'title';
    public $child_title_fallback_var = 'thumbs_gallery_top_alt';

    protected $module_credits = array(
        'module_uri' => 'https://www.diviessential.com/divi-gallery-slider/',
        'author' => 'Divi Next',
        'author_uri' => 'www.divinext.com',
    );

    public function init()
    {
        $this->name = esc_html__('Gallery Slider Item', 'et_builder');
        $this->settings_modal_toggles = array(
            'general' => array(
                'toggles' => array(
                    'thumbs_gallery_image_toggle' => array(
                        'title' => esc_html__('Image', 'et_builder'),
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
            'max_width' => false,
        );
    }

    public function get_fields()
    {
        return array(
            'thumbs_gallery_top_image' => array(
                'label' => esc_html__('Image', 'et_builder'),
                'type' => 'upload',
                'option_category' => 'basic_option',
                'upload_button_text' => esc_attr__('Upload an image', 'et_builder'),
                'choose_text' => esc_attr__('Choose an Image', 'et_builder'),
                'update_text' => esc_attr__('Set As Image', 'et_builder'),
                'description' => esc_html__('Upload an image to display at the top of your blurb.', 'et_builder'),
                'toggle_slug' => 'thumbs_gallery_image_toggle',
                'dynamic_content' => 'image',
                'data_type' => 'image',
                'mobile_options' => true,
            ),
            'thumbs_gallery_top_alt' => array(
                'label' => esc_html__('Image Alt', 'et_builder'),
                'type' => 'text',
                'dynamic_content' => 'text',
                'default' => 'Logo Item',
                'option_category' => 'basic_option',
                'description' => esc_html__('Text entered here will appear as title.', 'et_builder'),
                'toggle_slug' => 'thumbs_gallery_image_toggle',
            ),

        );
    }

    private function render_bottom_slider($render_slug) {
        global $thumbs_gallery_bottom;
        $module_order_class = self::get_module_order_class( $render_slug );
        $bottom_slider = sprintf(
            '<div href="%1$s" class="dnext-thumbs-gallery-top-image-link" data-title="%2$s"><img class="img-fluid" alt="%2$s" src="%1$s"/></div>',
            $this->props['thumbs_gallery_top_image'],
            $this->props['thumbs_gallery_top_alt']
        );
        
        $thumbs_gallery_bottom[$module_order_class] = $this->_render_module_wrapper($bottom_slider);
        
        return;
    }

    public function render($attrs, $content, $render_slug)
    {
        $this->render_bottom_slider($render_slug);

        $output = sprintf(
            '<a href="%1$s" class="dnext-thumbs-gallery-top-image-link" data-title="%2$s"><img class="img-fluid" alt="%2$s" src="%1$s"/></a>',
            $this->props['thumbs_gallery_top_image'],
            $this->props['thumbs_gallery_top_alt']
        );
        return $output;
    }
}

new Divi_NextThumbsGalleryChild;
