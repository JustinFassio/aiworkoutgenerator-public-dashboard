<?php

class Divi_NxteFloatingElement extends ET_Builder_Module
{
    public $slug = 'dnxte_floating_element';
    public $vb_support = 'on';
    public $child_slug = 'dnxte_floating_element_child';

    protected $module_credits = array(
        'module_uri' => 'https://www.diviessential.com/divi-floating-elements/',
        'author' => 'Divi Next',
        'author_uri' => 'www.divinext.com',
    );

    public function init()
    {
        $this->name        = esc_html__('Next Floating Element', 'et_builder');
        $this->icon_path   = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->folder_name = 'et_pb_divi_essential';

        $this->settings_modal_toggles = array(
            'advanced' => array(
                'toggles' => array(
                    'dnxte_floting_shape_image_settings' => esc_html__('Image Settings', 'et_builder'),
                    'dnxte_floting_shape_title_settings' => esc_html__('Title Settings', 'et_builder'),
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
            'link_options' => false,
            'text' => false,
            'fonts' => array(
                'title' => array(
                    'label' => esc_html__('Title', 'et_builder'),
                    'hide_text_align' => true,
                    'css' => array(
                        'main' => '%%order_class%% .dnxte-floting-text',
                    ),
                    'toggle_slug' => 'dnxte_floting_shape_title_settings',
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
                    ),
                    'toggle_slug' => 'dnxte_floting_shape_image_settings',
                ),
                'title' => array(
                    'label_prefix' => esc_html__('Title', 'et_builder'),
                    'css' => array(
                        'main' => array(
                            'border_radii' => "%%order_class%% .dnxte-floting-text",
                            'border_styles' => "%%order_class%% .dnxte-floting-text",
                        ),
                    ),
                    'toggle_slug' => 'dnxte_floting_shape_title_settings',
                ),
            ),
            'box_shadow' => array(
                'image' => array(
                    'label_prefix' => esc_html__('Image', 'et_builder'),
                    'option_category' => 'layout',
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxte_floting_shape_image_settings',
                    'css' => array(
                        'main' => '%%order_class%% .dnxte-floting-image',
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
                        'custom_style' => true,
                    ),
                    'default_on_fronts' => array(
                        'color' => '',
                        'position' => '',
                    ),
                ),
            ),
            'height'	=> array(
				'css'	=> array(
					'main'	=> "%%order_class%%.dnxte_floating_element"
                ),
			),
            'max_width' => array(
				'css' => array(
					'main' => "%%order_class%%.dnxte_floating_element",
					'module_alignment' => '%%order_class%%.dnxte_floating_element.et_pb_module',
				),
			),
        );
    }

    public function get_fields()
    {
        return array();
    }

    public function render($attrs, $content, $render_slug)
    {
        $content = $this->content;

        return sprintf('<div class="dnxte-floatimg-wrapper">%1$s</div>', $content);
    }
}

new Divi_NxteFloatingElement;
