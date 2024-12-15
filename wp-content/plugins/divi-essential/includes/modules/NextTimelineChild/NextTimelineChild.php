<?php
include_once(DIVI_ESSENTIAL_PATH.'/includes/modules/base/Common.php');

class Divi_NxteTimelineChild extends ET_Builder_Module {
    public $slug = 'dnxte_timeline_child';
    public $vb_support = 'on';
    public $type = 'child';
    public $child_title_var = 'timeline_date';
    public $child_title_fallback_var = 'timeline_date';

    protected $module_credits = array(
        'module_uri' => 'https://www.diviessential.com/divi-timeline/',
        'author' => 'Divi Next',
        'author_uri' => 'www.divinext.com',
    );

    public function init(){
        $this->name = esc_html__('Next Timeline Item', 'et_builder');

        $this->settings_modal_toggles = array(
            'general' => array(
                'toggles' => array(
                    'dnxte_timeline_elements' => esc_html__( 'Timeline Elements', 'et_builder')
                )
                ),
                'advanced' => array(
                    'toggles' => array(
                        'dnxte_timeline_settings' => esc_html__( 'Timeline', 'et_builder'),
                        'dnxte_title_settings' => esc_html__( 'Title', 'et_builder'),
                        'dnxte_desc_settings' => esc_html__( 'Description', 'et_builder'),
                        'dnxte_image_settings' => esc_html__( 'Image', 'et_builder'),
                        'dnxte_btn_settings' => esc_html__( 'Button', 'et_builder'),
                        'dnxte_icon_settings' => esc_html__( 'Icon', 'et_builder'),
                        'dnxte_identifier_settings' => esc_html__( 'Identifier', 'et_builder'),
                    )
                ),
                'custom_css' => array(
                    'toggles' => array(
                        'custom_class_id'	=>	esc_html__( 'CSS ID & Classes', 'et_builder' )
                    ),
                ),
        );

        $this->custom_css_fields = array(
            'title' => array(
                'label' => esc_html__('Title', 'et_builder'),
                'selector' => '%%order_class%% .dnxte-timline-heading',
            ),
            'description' => array(
                'label' => esc_html__('Description', 'et_builder'),
                'selector' => '%%order_class%% .dnxte-timline-pra',
            ),
            'button' => array(
                'label' => esc_html__('Button', 'et_builder'),
                'selector' => '%%order_class%% .dnxte-timline-btn-more',
            ),
            'icon' => array(
                'label' => esc_html__('Icon/Image', 'et_builder'),
                'selector' => '%%order_class%% .dnxte-timline-img',
            ),
            'identifier' => array(
                'label' => esc_html__('Identifier', 'et_builder'),
                'selector' => '%%order_class%% .dnxte-timline-date',
            ),
        );
    }

    public function get_advanced_fields_config(){
        return array(
            'text' => false,
            'max_width' => false,
            'fonts' => array(
                'header' => array(
                    'label' => esc_html__('Title', 'et_builder'),
                    'css' => array(
                        'main' => "%%order_class%% h4.dnxte-timline-heading, %%order_class%% h1.dnxte-timline-heading, %%order_class%% h2.dnxte-timline-heading, %%order_class%% h3.dnxte-timline-heading, %%order_class%% h5.dnxte-timline-heading, %%order_class%% h6.dnxte-timline-heading",
                        'important' => 'plugin-only',
                    ),
                    'header_level' => array(
                        'default' => 'h2',
                    ),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxte_title_settings',
                ),
                'content' => array(
                    'label' => esc_html__('Content', 'et_builder'),
                    'css' => array(
                        'main' => "%%order_class%% .dnxte-timline-pra",
                        'important' => 'plugin-only',
                    ),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxte_desc_settings',
                ),
                'button' => array(
                    'label' => esc_html__('Button', 'et_builder'),
                    'hide_text_align' => true,
                    'css' => array(
                        'main' => "%%order_class%% .dnxte-timline-btn-more",
                        'important' => 'plugin-only',
                    ),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxte_btn_settings',
                ),
                'identifier' => array(
                    'label' => esc_html__('Identifier', 'et_builder'),
                    'css' => array(
                        'main' => "%%order_class%% .dnxte-timline-date",
                        'important' => 'plugin-only',
                    ),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxte_identifier_settings',
                ),
            ),
            'borders' => array(
                'timeline' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => "%%order_class%% .dnxte-timline-content",
                            'border_styles' => "%%order_class%% .dnxte-timline-content",
                        ),
                        'important' => 'all'
                    ),
                    'label_prefix' => esc_html__('Timeline', 'et_builder'),
                    'toggle_slug' => 'dnxte_timeline_settings',
                ),
                'title' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => "%%order_class%% .dnxte-timline-heading",
                            'border_styles' => "%%order_class%% .dnxte-timline-heading",
                        ),
                        'important' => 'all'
                    ),
                    'label_prefix' => esc_html__('Title', 'et_builder'),
                    'toggle_slug' => 'dnxte_title_settings',
                ),
                'content' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => "%%order_class%% .dnxte-timline-pra",
                            'border_styles' => "%%order_class%% .dnxte-timline-pra",
                        ),
                        'important' => 'all'
                    ),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxte_desc_settings',
                ),
                'image' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => "%%order_class%% .dnxte-timline-image-section img",
                            'border_styles' => "%%order_class%% .dnxte-timline-image-section img",
                        ),
                        'important' => 'all'
                    ),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxte_image_settings',
                ),
                'button' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => "%%order_class%% .dnxte-timline-btn-more",
                            'border_styles' => "%%order_class%% .dnxte-timline-btn-more",
                        ),
                        'important' => 'all'
                    ),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxte_btn_settings',
                ),
                'identifier' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => "%%order_class%% .dnxte-timline-date",
                            'border_styles' => "%%order_class%% .dnxte-timline-date",
                        ),
                        'important' => 'all'
                    ),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxte_identifier_settings',
                ),
                'icon' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => "%%order_class%% .dnxte-timline-img",
                            'border_styles' => "%%order_class%% .dnxte-timline-img",
                        ),
                        'important' => 'all'
                    ),
                    'defaults'        => array(
						'border_radii'  => 'on|50%|50%|50%|50%',
					),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxte_icon_settings',
                ),
            ),
            'box_shadow' => array(
                'default' => array(),
                'timeline' => array(
                    'label' => esc_html__('Timeline Box Shadow', 'et_builder'),
                    'option_category' => 'layout',
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxte_timeline_settings',
                    'css' => array(
                        'main' => '%%order_class%% .dnxte-timline-content',
                        'important' => 'all',
                        'custom_style' => true,
                    ),
                    'default_on_fronts' => array(
                        'color' => '',
                        'position' => '',
                    ),
                ),
                'title' => array(
                    'label' => esc_html__('Title Box Shadow', 'et_builder'),
                    'option_category' => 'layout',
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxte_title_settings',
                    'css' => array(
                        'main' => '%%order_class%% .dnxte-timline-heading',
                        'important' => 'all',
                        'custom_style' => true,
                    ),
                    'default_on_fronts' => array(
                        'color' => '',
                        'position' => '',
                    ),
                ),
                'content' => array(
                    'label' => esc_html__('Content Box Shadow', 'et_builder'),
                    'option_category' => 'layout',
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxte_desc_settings',
                    'css' => array(
                        'main' => '%%order_class%% .dnxte-timline-pra',
                        'important' => 'all',
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
                    'toggle_slug' => 'dnxte_image_settings',
                    'css' => array(
                        'main' => '%%order_class%% .dnxte-timline-image-section img',
                        'important' => 'all',
                        'custom_style' => true,
                    ),
                    'default_on_fronts' => array(
                        'color' => '',
                        'position' => '',
                    ),
                ),
                'button' => array(
                    'label' => esc_html__('Button Box Shadow', 'et_builder'),
                    'option_category' => 'layout',
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxte_btn_settings',
                    'css' => array(
                        'main' => '%%order_class%% .dnxte-timline-btn-more',
                        'important' => 'all',
                        'custom_style' => true,
                    ),
                    'default_on_fronts' => array(
                        'color' => '',
                        'position' => '',
                    ),
                ),
                'identifer' => array(
                    'label' => esc_html__('Identifier Box Shadow', 'et_builder'),
                    'option_category' => 'layout',
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxte_identifier_settings',
                    'css' => array(
                        'main' => '%%order_class%% .dnxte-timline-date',
                        'important' => 'all',
                        'custom_style' => true,
                    ),
                    'default_on_fronts' => array(
                        'color' => '',
                        'position' => '',
                    ),
                ),
                'icon' => array(
                    'label' => esc_html__('Image/Icon Box Shadow', 'et_builder'),
                    'option_category' => 'layout',
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxte_icon_settings',
                    'css' => array(
                        'main' => '%%order_class%% .dnxte-timline-img',
                        'important' => 'all',
                        'custom_style' => true,
                    ),
                    'default_on_fronts' => array(
                        'color' => '',
                        'position' => '',
                    ),
                ),
            )
        );
    }

    public function get_fields() {
        $field =  array(
            'timeline_title' => array(
                'label'           => esc_html__('Title', 'et_builder'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'description'     => esc_html__('Input Pre Heading text', 'et_builder'),
                'toggle_slug'     => 'dnxte_timeline_elements',
                'dynamic_content' => 'text',
            ),
            'timeline_content' => array(
                'label'           => esc_html__('Content', 'et_builder'),
                'type'            => 'tiny_mce',
                'option_category' => 'basic_option',
                'description'     => esc_html__('Input the main text content for your module here.', 'et_builder'),
                'toggle_slug'     => 'dnxte_timeline_elements',
                'dynamic_content' => 'text',
            ),
            'timeline_use_image' => array(
                'label'       => esc_html__('Use Image', 'et_builder'),
                'type'        => 'yes_no_button',
                'toggle_slug' => 'dnxte_timeline_elements',
                'options'     => array(
                    'on'  => esc_html__('Yes', 'et_builder'),
                    'off' => esc_html__('No', 'et_builder'),
                ),
                'affects' => array(
                    'timeline_main_image',
                    'timeline_main_image_alt'
                ),
                'default_on_front' => 'on',
            ),
            'timeline_main_image' => array(
                'label'              => esc_html__('Timeline Content Image', 'et_builder'),
                'type'               => 'upload',
                'option_category'    => 'basic_option',
                'upload_button_text' => esc_attr__('Upload an image', 'et_builder'),
                'choose_text'        => esc_attr__('Choose an Image', 'et_builder'),
                'update_text'        => esc_attr__('Set As Image', 'et_builder'),
                'description'        => esc_html__('Upload an image to display at timeline section.', 'et_builder'),
                'toggle_slug'        => 'dnxte_timeline_elements',
                'dynamic_content'    => 'image',
                'mobile_options'     => true,
                'hover'              => 'tabs',
                'show_if'            => array(
                    'timeline_use_image' => 'on'
                )
            ),
            'timeline_main_image_alt' => array(
                'label'           => esc_html__('Content Image Alt', 'et_builder'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'description'     => esc_html__('Input Pre Heading text', 'et_builder'),
                'default'         => "Timeline main image",
                'toggle_slug'     => 'dnxte_timeline_elements',
                'dynamic_content' => 'text',
                'show_if'         => array(
                    'timeline_use_image' => 'on'
                )
            ),
            'timeline_use_icon' => array(
                'label' => esc_html__('Use Icon', 'et_builder'),
                'type' => 'yes_no_button',
                'toggle_slug' => 'dnxte_timeline_elements',
                'options' => array(
                    'on' => esc_html__('Yes', 'et_builder'),
                    'off' => esc_html__('No', 'et_builder'),
                ),
                'affects' => array(
                    'timeline_icon'
                ),
                'default_on_front' => 'on',
            ),
            'timeline_icon' => array(
                'label'           => esc_html__('Icon', 'et_builder'),
                'type'            => 'select_icon',
                'class'           => array('et-pb-font-icon'),
                'default'         => 'N',
                'toggle_slug'     => 'dnxte_timeline_elements',
                'option_category' => 'basic_option',
                'show_if'         => array(
                    'timeline_use_icon' => 'on',
                ),
            ),
            'timeline_image' => array(
                'label'              => esc_html__('Timeline Icon/Image', 'et_builder'),
                'type'               => 'upload',
                'option_category'    => 'basic_option',
                'upload_button_text' => esc_attr__('Upload an image', 'et_builder'),
                'choose_text'        => esc_attr__('Choose an Image', 'et_builder'),
                'update_text'        => esc_attr__('Set As Image', 'et_builder'),
                'description'        => esc_html__('Upload an image to display at icon section.', 'et_builder'),
                'toggle_slug'        => 'dnxte_timeline_elements',
                'dynamic_content'    => 'image',
                'mobile_options'     => true,
                'hover'              => 'tabs',
                'show_if'            => array(
                    'timeline_use_icon' => 'off'
                )
            ),
            'timeline_date' => array(
                'label'           => esc_html__('Identifier', 'et_builder'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'description'     => esc_html__('Input Timeline date', 'et_builder'),
                'toggle_slug'     => 'dnxte_timeline_elements',
                'dynamic_content' => 'text',
            ),
            'timeline_use_button' => array(
                'label'       => esc_html__('Use Button', 'et_builder'),
                'type'        => 'yes_no_button',
                'toggle_slug' => 'dnxte_timeline_elements',
                'options'     => array(
                    'on'  => esc_html__('Yes', 'et_builder'),
                    'off' => esc_html__('No', 'et_builder'),
                ),
                'affects' => array(
                    'timeline_button_text',
                    'timeline_button_link',
                    'timeline_button_target',
                ),
                'default_on_front' => 'on',
            ),
            'timeline_button_text' => array(
                'label'           => esc_html__('Button Text', 'et_builder'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'description'     => esc_html__('Input button text', 'et_builder'),
                'toggle_slug'     => 'dnxte_timeline_elements',
                'dynamic_content' => 'text',
                'mobile_options'  => true,
                'hover'           => 'tabs',
                'show_if'         => array(
                    'timeline_use_button' => 'on',
                ),
            ),
            'timeline_button_link' => array(
                'label' => esc_html__('Link', 'et_builder'),
                'type' => 'text',
                'option_category' => 'basic_option',
                'default' => '#',
                'description' => esc_html__('When clicked the module will link to this URL.', 'et_builder'),
                'toggle_slug' => 'dnxte_timeline_elements',
                'show_if' => array(
                    'timeline_use_button' => 'on',
                ),
            ),
            'timeline_button_target' => array(
                'label' => esc_html__('Link Target', 'et_builder'),
                'type' => 'select',
                'description' => esc_html__('Select the link target', 'et_builder'),
                'option_category' => 'basic_option',
                'toggle_slug' => 'dnxte_timeline_elements',
                'options' => array(
                    '_self' => esc_html__('In The Same Window', 'et_builder'),
                    '_blank' => esc_html__('In The New Tab', 'et_builder'),

                ),
                'default' => '_self',
                'show_if' => array(
                    'timeline_use_button' => 'on',
                ),
            ),
            'timeline_button_alignment'=> array(
				'label'            => esc_html__( 'Button Alignment', 'et_builder' ),
				'description'      => esc_html__( 'Align your button to the left, right or center of the module.', 'et_builder' ),
				'type'             => 'text_align',
				'option_category'  => 'configuration',
				'options'          => et_builder_get_text_orientation_options( array('justified') ),
				'tab_slug'         => 'advanced',
				'toggle_slug'      => 'dnxte_btn_settings',
				'mobile_options'   => true,
				'description'      => esc_html__( 'Here you can define the alignment of Button', 'et_builder' ),
            ),
            'timeline_icon_position' => array(
                'label' => esc_html__('Icon Position', 'et_builder'),
                'description' => esc_html__('Adjust the position of the icon within.', 'et_builder'),
                'type' => 'range',
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxte_icon_settings',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'default' => '0px',
                'default_unit' => 'px',
                'default_on_front' => '0px',
                'allow_empty' => true,
                'range_settings' => array(
                    'min' => '0',
                    'max' => '100',
                    'step' => '1',
                ),
                'mobile_options' => true,
                'hover' => 'tabs',
            ),
            'timeline_icon_color' => array(
                'label' => esc_html__('Icon Color', 'et_builder'),
                'type' => 'color-alpha',
                'custom_color' => true,
                'default' => '#545454',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxte_icon_settings',
                'mobile_options' => true,
                'hover' => 'tabs',
                'show_if' => array(
                    'timeline_use_icon' => 'on'
                )
            ),
            'timeline_icon_size' => array(
                'label' => esc_html__('Icon Size', 'et_builder'),
                'description' => esc_html__('Adjust the size of the icon within.', 'et_builder'),
                'type' => 'range',
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxte_icon_settings',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'default' => '16px',
                'default_unit' => 'px',
                'default_on_front' => '16px',
                'allow_empty' => true,
                'range_settings' => array(
                    'min' => '0',
                    'max' => '100',
                    'step' => '1',
                ),
                'mobile_options' => true,
                'hover' => 'tabs',
            ),
            'timeline_title_margin' => array(
                'label' => esc_html__('Title Margin', 'et_builder'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'timeline_title_padding' => array(
                'label' => esc_html__('Title Padding', 'et_builder'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'timeline_desc_margin' => array(
                'label' => esc_html__('Description Margin', 'et_builder'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'timeline_desc_padding' => array(
                'label' => esc_html__('Description Padding', 'et_builder'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'timeline_main_image_margin' => array(
                'label' => esc_html__('Image Margin', 'et_builder'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'timeline_main_image_padding' => array(
                'label' => esc_html__('Image Padding', 'et_builder'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'timeline_btn_margin' => array(
                'label' => esc_html__('Button Margin', 'et_builder'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'timeline_btn_padding' => array(
                'label' => esc_html__('Button Padding', 'et_builder'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'timeline_icon_padding' => array(
                'label' => esc_html__('Icon/Image Padding', 'et_builder'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'timeline_identifier_margin' => array(
                'label' => esc_html__('Identifier Margin', 'et_builder'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'timeline_identifier_padding' => array(
                'label' => esc_html__('Identifier Padding', 'et_builder'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'timeline_main_image_width' => array(
                'label' => esc_html__('Image Width', 'et_builder'),
                'description' => esc_html__('Adjust the position of the image within.', 'et_builder'),
                'type' => 'range',
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxte_image_settings',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'default' => '100%',
                'default_unit' => '%',
                'default_on_front' => '100%',
                'allow_empty' => true,
                'range_settings' => array(
                    'min' => '0',
                    'max' => '100',
                    'step' => '1',
                ),
                'mobile_options' => true,
                'hover' => 'tabs',
            ),
            'timeline_main_image_alignment' => array(
				'label'           => esc_html__( 'Image Alignment', 'et_builder' ),
				'description'     => esc_html__( 'Align image to the left, right or center.', 'et_builder' ),
				'type'            => 'align',
				'option_category' => 'layout',
				'options'         => et_builder_get_text_orientation_options( array( 'justified' ) ),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dnxte_image_settings',
				'mobile_options'  => true,
            ),
            'timeline_css_id' => array(
                'label' => esc_html__('CSS ID', 'et_builder'),
                'type' => 'text',
                'option_category' => 'basic_option',
                'description' => esc_html__('Assign a unique CSS ID to the element which can be used to assign custom CSS styles from within your child theme or from within Divi\'s custom CSS inputs.', 'et_builder'),
                'tab_slug' => 'custom_css',
                'toggle_slug' => 'custom_class_id',
            ),
            'timeline_css_classes' => array(
                'label' => esc_html__('CSS Class', 'et_builder'),
                'type' => 'text',
                'option_category' => 'basic_option',
                'description' => esc_html__('Assign any number of CSS Classes to the element, Separated by spaces, which can be used to assign custom CSS styles from within your child theme or from within Divi\'s custom CSS inputs.', 'et_builder'),
                'tab_slug' => 'custom_css',
                'toggle_slug' => 'custom_class_id',
            ),
        );

        $additional = array(
            'timeline_bg_color' => array(
                'label' => esc_html__('Timeline Background', 'et_builder'),
                'type' => 'background-field',
                'base_name' => "timeline_bg",
                'context' => "timeline_bg",
                'option_category' => 'layout',
                'custom_color' => true,
                'default' => ET_Global_Settings::get_value('all_buttons_bg_color'),
                'depends_show_if' => 'on',
                'tab_slug' => 'advanced',
                'toggle_slug' => "dnxte_timeline_settings",
                'background_fields' => array_merge(
                    ET_Builder_Element::generate_background_options(
                        'timeline_bg',
                        'gradient',
                        "advanced",
                        "dnxte_timeline_settings",
                        "timeline_bg_gradient"
                    ),
                    ET_Builder_Element::generate_background_options(
                        "timeline_bg",
                        "color",
                        "advanced",
                        "dnxte_timeline_settings",
                        "timeline_bg_color"
                    )
                    ),
                'mobile_options' => true,
                'hover' => 'tabs'
            ),
            'button_bg_color' => array(
                'label' => esc_html__('Button Background', 'et_builder'),
                'type' => 'background-field',
                'base_name' => "button_bg",
                'context' => "button_bg",
                'option_category' => 'layout',
                'custom_color' => true,
                'default' => ET_Global_Settings::get_value('all_buttons_bg_color'),
                'depends_show_if' => 'on',
                'tab_slug' => 'advanced',
                'toggle_slug' => "dnxte_btn_settings",
                'background_fields' => array_merge(
                    ET_Builder_Element::generate_background_options(
                        'button_bg',
                        'gradient',
                        "advanced",
                        "dnxte_btn_settings",
                        "button_bg_gradient"
                    ),
                    ET_Builder_Element::generate_background_options(
                        "button_bg",
                        "color",
                        "advanced",
                        "dnxte_btn_settings",
                        "button_bg_color"
                    )
                    ),
                'mobile_options' => true,
                'hover' => 'tabs'
            ),
            'icon_bg_color' => array(
                'label' => esc_html__('Icon Background', 'et_builder'),
                'type' => 'background-field',
                'base_name' => "icon_bg",
                'context' => "icon_bg",
                'option_category' => 'layout',
                'custom_color' => true,
                'default' => ET_Global_Settings::get_value('all_buttons_bg_color'),
                'depends_show_if' => 'on',
                'tab_slug' => 'advanced',
                'toggle_slug' => "dnxte_icon_settings",
                'background_fields' => array_merge(
                    ET_Builder_Element::generate_background_options(
                        'icon_bg',
                        'gradient',
                        "advanced",
                        "dnxte_icon_settings",
                        "icon_bg_gradient"
                    ),
                    ET_Builder_Element::generate_background_options(
                        "icon_bg",
                        "color",
                        "advanced",
                        "dnxte_icon_settings",
                        "icon_bg_color"
                    )
                    ),
                'mobile_options' => true,
                'hover' => 'tabs'
            )
        );

        $additional = array_merge(
            $additional,
            $this->generate_background_options(
                'timeline_bg',
                'skip',
                "advanced",
                "dnxte_timeline_settings",
                "timeline_bg_gradient"
            ),
            $this->generate_background_options(
                'button_bg',
                'skip',
                "advanced",
                "dnxte_btn_settings",
                "button_bg_gradient"
            ),
            $this->generate_background_options(
                'icon_bg',
                'skip',
                "advanced",
                "dnxte_icon_settings",
                "icon_bg_gradient"
            )
        );

        $additional = array_merge(
            $additional,
            $this->generate_background_options(
                'timeline_bg',
                'skip',
                "advanced",
                "dnxte_timeline_settings",
                "timeline_bg_color"
            ),
            $this->generate_background_options(
                'button_bg',
                'skip',
                "advanced",
                "dnxte_btn_settings",
                "button_bg_color"
            ),
            $this->generate_background_options(
                'icon_bg',
                'skip',
                "advanced",
                "dnxte_icon_settings",
                "icon_bg_color"
            )
        );

        return array_merge($field,$additional);
    }

    public function render($attrs, $content, $render_slug){
        $multi_view        = et_pb_multi_view_options($this);
        $button_link       = $this->props['timeline_button_link'];
        $button_target     = $this->props['timeline_button_target'];
        $timeline_use_icon = $this->props['timeline_use_icon'];

        $timeline_css_id = "" !== $this->props['timeline_css_id'] ? sprintf('id="%1$s"', $this->props['timeline_css_id']) : "";
        $timeline_css_classes = "" !== $this->props['timeline_css_classes'] ? $this->props['timeline_css_classes'] : "";

        // Image
        $dnxte_timeline_img = "";
        if ($this->props['timeline_use_icon'] === "off" && $multi_view->has_value('timeline_image')) {
            $dnxte_timeline_img = $multi_view->render_element(array(
                'tag' => 'img',
                'attrs' => array(
                    'src' => '{{timeline_image}}',
                    'alt' => 'timeline',
                ),
            ));
        }

        // Content Image
        $image_alignment_classes = Common::get_alignment("timeline_main_image_alignment", $this);
        $dnxte_timeline_main_image_html = "";
        $dnxte_timeline_main_image = "";
        if($this->props['timeline_use_image'] === "on" && $multi_view->has_value('timeline_main_image')) {
            $dnxte_timeline_main_image = $multi_view->render_element(array(
                'tag' => 'img',
                'attrs' => array(
                    'src' => '{{timeline_main_image}}',
                    'alt' => '{{timeline_main_image_alt}}',
                ),
            ));

            $dnxte_timeline_main_image_html = sprintf('<div class="dnxte-timline-image-section '.$image_alignment_classes.'">%1$s</div>', $dnxte_timeline_main_image);
        }

        // Icon
        $timelineicon = "";

        

        if( 'off' !== $timeline_use_icon ) {
            
			// Font Icon
            $icon_css_property = array(
                'selector'    => '%%order_class%% .dnxte-timline-icon',
                'class'       => 'dnxte-timline-icon'
            );
            $timelineicon = Common::get_icon_html('timeline_icon', $this, $render_slug, $multi_view, $icon_css_property);
        }
        

        // Title
        $dnxte_timeline_title = "";
        if ($multi_view->has_value('timeline_title')) {
            $dnxte_timeline_title = $multi_view->render_element(array(
                'tag' => et_pb_process_header_level($this->props['header_level'], 'h2'),
                'content' => '{{timeline_title}}',
                'attrs' => array(
                    'class' => 'dnxte-timline-heading',
                ),
            ));
        }

        // Description
        $dnxte_timeline_description = $multi_view->render_element( array(
            'tag' => 'div',
            'content' => '{{timeline_content}}',
            'attrs' => array(
                'class' => 'dnxte-timline-pra',
            )
        ));

        // Button
        $dnxte_timeline_button = "";
        $dnxte_timeline_button = $multi_view->render_element(array(
            'tag' => 'a',
            'content' => '{{timeline_button_text}}',
            'attrs' => array(
                'href' => $button_link,
                'target' => $button_target,
                'class' => 'dnxte-timline-btn-more',
            ),
        ));
        // Button Alignments
        $button_alignment_classes = Common::get_alignment("timeline_button_alignment", $this);
        $dnxte_timeline_btn_container = "";
        if($this->props['timeline_use_button'] === "on") {
            $dnxte_timeline_btn_container = sprintf('<div class="dnxte-timline-btn-container '. $button_alignment_classes .'">
                        %1$s
                    </div>', $dnxte_timeline_button);
        } 

        // Identifier Text
        $dnxte_timeline_identifier = "";
        if ($multi_view->has_value('timeline_date')) {
            $dnxte_timeline_identifier = $multi_view->render_element(array(
                'tag' => 'span',
                'content' => '{{timeline_date}}',
                'attrs' => array(
                    'class' => 'dnxte-timline-date',
                ),
            ));
        }

        // icon/image background color
        $icon_bg_color = array(
            'color_slug' => "icon_bg_color"
        );
        $use_color_gradient = $this->props['icon_bg_use_color_gradient'];
        $gradient = array(
            "gradient_type"           => 'icon_bg_color_gradient_type',
            "gradient_direction"      => 'icon_bg_color_gradient_direction',
            "radial"                  => 'icon_bg_color_gradient_direction_radial',
            "gradient_start"          => 'icon_bg_color_gradient_start',
            "gradient_end"            => 'icon_bg_color_gradient_end',
            "gradient_start_position" => 'icon_bg_color_gradient_start_position',
            "gradient_end_position"   => 'icon_bg_color_gradient_end_position',
            "gradient_overlays_image" => 'icon_bg_color_gradient_overlays_image',
        );

        $css_property = array(
            "desktop" => "%%order_class%% .dnxte-timline-img",
            "hover" => "%%order_class%% .dnxte-timline-img:hover"
        );
        Common::apply_bg_css($render_slug, $this, $icon_bg_color, $use_color_gradient, $gradient, $css_property);
        //icon/image background color end

        // Timeline background color
        $timeline_bg_color = array(
            'color_slug' => "timeline_bg_color"
        );
        $use_color_gradient = $this->props['timeline_bg_use_color_gradient'];
        $gradient = array(
            "gradient_type" => 'timeline_bg_color_gradient_type',
            "gradient_direction" => 'timeline_bg_color_gradient_direction',
            "radial" => 'timeline_bg_color_gradient_direction_radial',
            "gradient_start" => 'timeline_bg_color_gradient_start',
            "gradient_end" => 'timeline_bg_color_gradient_end',
            "gradient_start_position" => 'timeline_bg_color_gradient_start_position',
            "gradient_end_position" => 'timeline_bg_color_gradient_end_position',
            "gradient_overlays_image" => 'timeline_bg_color_gradient_overlays_image',
        );

        $css_property = array(
            "desktop" => "%%order_class%% .dnxte-timline-content",
            "hover" => "%%order_class%% .dnxte-timline-content:hover"
        );
        Common::apply_bg_css($render_slug, $this, $timeline_bg_color, $use_color_gradient, $gradient, $css_property);
        //Timeline background color end

        $icon_color_css_property = 'color: %1$s !important;';
        $icon_color_css_selector = array(
            'desktop' => "%%order_class%% .dnxte-timline-icon",
            'hover'   => "%%order_class%% .dnxte-timline-icon:hover"
        );
        Common::set_css("timeline_icon_color", $icon_color_css_property, $icon_color_css_selector, $render_slug, $this);

        $icon_size_css_property = 'font-size: %1$s !important;';
        $icon_size_css_selector = array(
            'desktop' => "%%order_class%% .dnxte-timline-icon",
            'hover'   => "%%order_class%% .dnxte-timline-icon:hover"
        );
        Common::set_css("timeline_icon_size", $icon_size_css_property, $icon_size_css_selector, $render_slug, $this);

        // Button background color
        $timeline_button_bg = array(
            'color_slug' => "button_bg_color"
        );
        $use_color_gradient = $this->props['button_bg_use_color_gradient'];
        $gradient = array(
            "gradient_type" => 'button_bg_color_gradient_type',
            "gradient_direction" => 'button_bg_color_gradient_direction',
            "radial" => 'button_bg_color_gradient_direction_radial',
            "gradient_start" => 'button_bg_color_gradient_start',
            "gradient_end" => 'button_bg_color_gradient_end',
            "gradient_start_position" => 'button_bg_color_gradient_start_position',
            "gradient_end_position" => 'button_bg_color_gradient_end_position',
            "gradient_overlays_image" => 'button_bg_color_gradient_overlays_image',
        );

        $css_property = array(
            "desktop" => "%%order_class%% .dnxte-timline-btn-more",
            "hover" => "%%order_class%% .dnxte-timline-btn-more:hover"
        );
        Common::apply_bg_css($render_slug, $this, $timeline_button_bg, $use_color_gradient, $gradient, $css_property);
        //Button background color end

        $icon_position_css_property = 'margin-top: %1$s;';
        $icon_position_css_selector = array(
            'desktop' => "%%order_class%% .dnxte-timline-img",
            'hover'   => "%%order_class%% .dnxte-timline-img:hover"
        );
        Common::set_css("timeline_icon_position", $icon_position_css_property, $icon_position_css_selector, $render_slug, $this);
        
        $image_width_css_property = 'width: %1$s;';
        $image_width_css_selector = array(
            'desktop' => "%%order_class%% .dnxte-timline-image-section img",
            'hover'   => "%%order_class%% .dnxte-timline-image-section img:hover"
        );
        Common::set_css("timeline_main_image_width", $image_width_css_property, $image_width_css_selector, $render_slug, $this);

        $this->apply_css( $render_slug );

        return sprintf('
            <div %7$s class="dnxte-timline-block %8$s">
                <div class="dnxte-timline-img dnxte-timeline-pic">
                    %1$s
                    %9$s
                </div>
                <div class="dnxte-timline-content">
                    %6$s
                    %2$s
                    %3$s
                    %4$s
                    %5$s
                </div>
            </div>',
            et_core_esc_previously($dnxte_timeline_img),
            $dnxte_timeline_title,
            $dnxte_timeline_description,
            $dnxte_timeline_btn_container,
            $dnxte_timeline_identifier,
            $dnxte_timeline_main_image_html,
            $timeline_css_id,
            $timeline_css_classes,
            $timelineicon
        );
    }

    public function apply_css( $render_slug ) {
        /**
         * Custom Padding Margin Output
         *
         */
        Common::dnxt_set_style($render_slug, $this->props, "timeline_title_margin", "%%order_class%% .dnxte-timline-heading", "margin", true);
        Common::dnxt_set_style($render_slug, $this->props, "timeline_title_padding", "%%order_class%% .dnxte-timline-heading", "padding", true);

        Common::dnxt_set_style($render_slug, $this->props, "timeline_desc_margin", "%%order_class%% .dnxte-timline-pra", "margin", true);
        Common::dnxt_set_style($render_slug, $this->props, "timeline_desc_padding", "%%order_class%% .dnxte-timline-pra", "padding", true);

        Common::dnxt_set_style($render_slug, $this->props, "timeline_btn_margin", "%%order_class%% .dnxte-timline-btn-more", "margin", true);
        Common::dnxt_set_style($render_slug, $this->props, "timeline_btn_padding", "%%order_class%% .dnxte-timline-btn-more", "padding", true);

        Common::dnxt_set_style($render_slug, $this->props, "timeline_icon_padding", "%%order_class%% .dnxte-timline-img", "padding", true);

        Common::dnxt_set_style($render_slug, $this->props, "timeline_identifier_margin", "%%order_class%% .dnxte-timline-date", "margin", true);
        Common::dnxt_set_style($render_slug, $this->props, "timeline_identifier_padding", "%%order_class%% .dnxte-timline-date", "padding", true);

        Common::dnxt_set_style($render_slug, $this->props, "timeline_main_image_margin", "%%order_class%% .dnxte-timline-image-section img", "margin", true);
        Common::dnxt_set_style($render_slug, $this->props, "timeline_main_image_padding", "%%order_class%% .dnxte-timline-image-section img", "padding", true);
    }

    public function multi_view_filter_value( $raw_value, $args, $multi_view ) {
		$name = isset( $args['name'] ) ? $args['name'] : '';

		if ( $raw_value && in_array( $name, array('timeline_icon')) ) {
			return et_pb_get_extended_font_icon_value( $raw_value, true );
		}
		return $raw_value;
	}

}

new Divi_NxteTimelineChild;