<?php

class Next_Minimal_Image_Hover extends ET_Builder_Module
{

    public $slug = 'dnxte_minimal_image_hover';
    public $vb_support = 'on';

    protected $module_credits = array(
        'module_uri' => 'https://www.diviessential.com/divi-minimal-image-hover-effect/',
        'author' => 'Divi Next',
        'author_uri' => 'www.divinext.com',
    );

    public function init()
    {
        $this->name        = esc_html__('Next Minimal Image', 'et_builder');
        $this->icon_path   = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->folder_name = 'et_pb_divi_essential';

        $this->settings_modal_toggles = array(
            'general' => array(
                'toggles' => array(
                    'main_content' => esc_html__('Image', 'et_builder'),
                    'link' => esc_html__('Link', 'et_builder'),
                ),
            ),
            'advanced' => array(
                'toggles' => array(
                    'dnxtmih_hover_effect' => esc_html__('Hover Effect', 'et_builder'),
                ),
            ),
            'custom_css' => array(
                'toggles' => array(
                    'animation' => array(
                        'title' => esc_html__('Animation', 'et_builder'),
                        'priority' => 90,
                    ),
                    'attributes' => array(
                        'title' => esc_html__('Attributes', 'et_builder'),
                        'priority' => 95,
                    ),
                ),
            ),
        );

        $this->advanced_fields = array(
            'margin_padding' => array(
                'css' => array(
                    'main' => "%%order_class%% figure",
                ),
            ),
            'borders' => array(
                'default' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => "%%order_class%% figure",
                            'border_styles' => "%%order_class%% figure",
                        ),
                    ),
                ),
            ),
            'background' => array(
                'settings' => array(
                    'color' => 'alpha',
                ),
                'css' => array(
                    'main' => "%%order_class%% figure",
                    'important' => true,
                ),
            ),
            'box_shadow' => array(
                'default' => array(
                    'css' => array(
                        'main' => '%%order_class%% figure',
                        'overlay' => 'inset',
                    ),
                ),
            ),
            'max_width' => array(
                'options' => array(
                    'width' => array(
                        'depends_show_if' => 'off',
                    ),
                    'max_width' => array(
                        'depends_show_if' => 'off',
                    ),
                ),
            ),
            'height' => array(
                'css' => array(
                    'main' => '%%order_class%% figure',
                ),
            ),
            'fonts' => false,
            'text' => false,
            'button' => false,
        );
    }

    public function get_fields()
    {
        return array(
            'image' => array(
                'label' => esc_html__('Image', 'et_builder'),
                'type' => 'upload',
                'option_category' => 'basic_option',
                'upload_button_text' => esc_attr__('Upload an image', 'et_builder'),
                'choose_text' => esc_attr__('Choose an Image', 'et_builder'),
                'update_text' => esc_attr__('Set As Image', 'et_builder'),
                'hide_metadata' => true,
                'description' => esc_html__('Upload your desired image, or type in the URL to the image you would like to display.', 'et_builder'),
                'toggle_slug' => 'main_content',
                'dynamic_content' => 'image',
                'mobile_options' => true,
                'hover' => 'tabs',
            ),
            'alt' => array(
                'label' => esc_html__('Image Alternative Text', 'et_builder'),
                'type' => 'text',
                'option_category' => 'basic_option',
                'depends_show_if' => 'on',
                'depends_on' => array(
                    'hello_src',
                ),
                'description' => esc_html__('This defines the HTML ALT text. A short description of your image can be placed here.', 'et_builder'),
                'tab_slug' => 'custom_css',
                'toggle_slug' => 'attributes',
                'dynamic_content' => 'text',
            ),
            // Image Hover Effect
            'dnxtmih_image_hover_effect' => array(
                'label' => esc_html__('Select Image Hover', 'et_builder'),
                'type' => 'select',
                'option_category' => 'configuration',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxtmih_hover_effect',
                'default' => 'push-up',
                'description' => esc_html__('Here you can adjust the hover effect.', 'et_builder'),
                'options' => array(
                    'effect1' => esc_html__('Zoom In', 'et_builder'),
                    'effect2' => esc_html__('Zoom Out', 'et_builder'),
                    'effect3' => esc_html__('Zoom Out In', 'et_builder'),
                    'effect4' => esc_html__('Scale Out Rotate', 'et_builder'),
                    'effect5' => esc_html__('Slide', 'et_builder'),
                    'effect6' => esc_html__('Rotate Zoom Out', 'et_builder'),
                    'effect7' => esc_html__('Blur', 'et_builder'),
                    'effect8' => esc_html__('Flashing', 'et_builder'),
                    'effect9' => esc_html__('Shine', 'et_builder'),
                    'effect10' => esc_html__('Circle', 'et_builder'),
                ),
            ),
        );
    }

    public function render($attrs, $content, $render_slug)
    {

        $multi_view = et_pb_multi_view_options($this);
        $image = $this->props['image'];

        $dnxtmih_image_hover_effect = $this->props['dnxtmih_image_hover_effect'];

        // Handle svg image behaviour
        $image_pathinfo = pathinfo($image);
        $is_image_svg = isset($image_pathinfo['extension']) ? 'svg' === $image_pathinfo['extension'] : true;

        $image_html = $multi_view->render_element(array(
            'tag' => 'img',
            'attrs' => array(
                'class' => 'img-fluid',
                'src' => '{{image}}',
                'alt' => '{{alt}}',
            ),
            'required' => 'image',
        ));

        $dnxtmih_img = "";
        if ("" !== $image) {
            $dnxtmih_img = sprintf(
                '<figure>%1$s</figure>',
                $image_html
            );
        }

        return sprintf(
            '<div class="dnext-neip-mih-hover-effect dnext-neip-mih-%2$s">
				%1$s
			</div>',
            $dnxtmih_img,
            $dnxtmih_image_hover_effect
        );
    }
}

new Next_Minimal_Image_Hover;
