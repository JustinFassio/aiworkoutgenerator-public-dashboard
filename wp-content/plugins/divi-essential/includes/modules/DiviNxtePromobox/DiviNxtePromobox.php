<?php
include_once(DIVI_ESSENTIAL_PATH.'/includes/modules/base/Common.php');

class Divi_NxtePromobox extends ET_Builder_Module
{
    public $slug = 'dnxte_promobox';
    public $vb_support = 'on';

    protected $module_credits = array(
        'module_uri' => 'https://www.diviessential.com/next-promo-box/',
        'author' => 'Divi Next',
        'author_uri' => 'www.divinext.com',
    );
    

    public function init()
    {
        $this->name        = esc_html__('Next Promo Box', 'et_builder');
        $this->icon_path   = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->folder_name = 'et_pb_divi_essential';

        $this->settings_modal_toggles = array(
            'general' => array(
                'toggles' => array(
                    'dnxte_promobox_img' => esc_html__('Image', 'et_builder'),
                    'dnxte_promobox_btn' => esc_html__('Button', 'et_builder'),
                    'dnxte_promobox_off' => esc_html__('Offer', 'et_builder'),
                    'dnxte_promobox_image_mask' => esc_html__('Image Mask', 'et_builder'),
                ),
            ),
            'advanced' => array(
                'toggles' => array(
                    'dnxte_promobox_title_one_settings' => esc_html__('Pre Heading Settings', 'et_builder'),
                    'dnxte_promobox_title_two_settings' => esc_html__('Heading Settings', 'et_builder'),
                    'dnxte_promobox_title_three_settings' => esc_html__('Post Heading Settings', 'et_builder'),
                    'dnxte_promobox_content_settings' => esc_html__('Content Settings', 'et_builder'),
                    'dnxte_promobox_image_settings' => esc_html__('Image Settings', 'et_builder'),
                    'dnxte_promobox_button_settings' => esc_html__('Button Settings', 'et_builder'),
                    'dnxte_promobox_offer_settings' => esc_html__('Offer Settings', 'et_builder'),
                ),
            ),
        );
        $this->custom_css_fields = array(
            'dnxte_promobox_title_one' => array(
                'label' => esc_html__('Pre Heading', 'et_builder'),
                'selector' => '%%order_class%% .dnxte-promobx-before-title',
            ),
            'dnxte_promobox_title_two' => array(
                'label' => esc_html__('Heading', 'et_builder'),
                'selector' => '%%order_class%% .dnxte-promobx-main-title',
            ),
            'dnxte_promobox_title_three' => array(
                'label' => esc_html__('Post Heading', 'et_builder'),
                'selector' => '%%order_class%% .dnxte-promobx-after-title',
            ),
            'dnxte_promobox_content' => array(
                'label' => esc_html__('Content', 'et_builder'),
                'selector' => '%%order_class%% .dnxte-promobx-description',
            ),
            'dnxte_promobox_image' => array(
                'label' => esc_html__('Image', 'et_builder'),
                'selector' => '%%order_class%% .dnxte-promobx-thumb img',
            ),
            'dnxte_promobox_button' => array(
                'label' => esc_html__('Button', 'et_builder'),
                'selector' => '%%order_class%% .dnxte-promobx-btn',
            ),
            'dnxte_promobox_offer' => array(
                'label' => esc_html__('Offer', 'et_builder'),
                'selector' => '%%order_class%% .dnxte-promo-box-badge',
            ),
        );
    }

    public function get_advanced_fields_config()
    {
        return array(
            'text' => false,
            'fonts' => array(
                'title_one' => array(
                    'label' => esc_html__('Pre Heading', 'et_builder'),
                    'css' => array(
                        'main' => "%%order_class%% .dnxte-promobx-before-title",
                        'hover' => "%%order_class%% .dnxte-promobx-container:hover .dnxte-promobx-before-title",
                        'important' => 'plugin-only',
                    ),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxte_promobox_title_one_settings',
                ),
                'header' => array(
                    'label' => esc_html__('Heading', 'et_builder'),
                    'css' => array(
                        'main' => "%%order_class%% h4.dnxte-promobx-main-title, %%order_class%% h1.dnxte-promobx-main-title, %%order_class%% h2.dnxte-promobx-main-title, %%order_class%% h3.dnxte-promobx-main-title, %%order_class%% h5.dnxte-promobx-main-title, %%order_class%% h6.dnxte-promobx-main-title",
                        'hover' => "%%order_class%% .dnxte-promobx-container:hover .dnxte-promobx-main-title",
                        'important' => 'plugin-only',
                    ),
                    'header_level' => array(
                        'default' => 'h4',
                    ),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxte_promobox_title_two_settings',
                ),
                'title_three' => array(
                    'label' => esc_html__('Post Heading', 'et_builder'),
                    'css' => array(
                        'main' => "%%order_class%% .dnxte-promobx-after-title",
                        'hover' => "%%order_class%% .dnxte-promobx-container:hover .dnxte-promobx-after-title",
                        'important' => 'plugin-only',
                    ),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxte_promobox_title_three_settings',
                ),
                'content' => array(
                    'label' => esc_html__('Content', 'et_builder'),
                    'css' => array(
                        'main' => "%%order_class%% .dnxte-promobx-description",
                        'hover' => "%%order_class%% .dnxte-promobx-container:hover .dnxte-promobx-description",
                        'important' => 'plugin-only',
                    ),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxte_promobox_content_settings',
                ),
                'button' => array(
                    'label' => esc_html__('Button', 'et_builder'),
                    'hide_text_align' => true,
                    'css' => array(
                        'main' => "%%order_class%% .dnxte-promobx-btn",
                        'hover' => "%%order_class%% .dnxte-promobx-container:hover .dnxte-promobx-btn",
                        'important' => 'plugin-only',
                    ),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxte_promobox_button_settings',
                ),
                'offer' => array(
                    'label' => esc_html__('Offer', 'et_builder'),
                    'hide_text_align' => true,
                    'css' => array(
                        'main' => "%%order_class%% .dnxte-promo-box-badge span",
                        'hover' => "%%order_class%% .dnxte-promobx-container:hover .dnxte-promo-box-badge span",
                        'important' => 'plugin-only',
                    ),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxte_promobox_offer_settings',
                ),
            ),
            'background' => array(
                'css' => array(
                    'main' => '%%order_class%% .dnxte-promobx-container',
                ),
            ),
            'borders' => array(
                'default' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => "%%order_class%%",
                            'border_styles' => "%%order_class%%",
                        ),
                    ),
                ),
                'title_one' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => "%%order_class%% .dnxte-promobx-before-title",
                            'border_radii_hover' => "%%order_class%% .dnxte-promobx-container:hover .dnxte-promobx-before-title",
                            'border_styles' => "%%order_class%% .dnxte-promobx-before-title",
                            'border_styles_hover' => "%%order_class%% .dnxte-promobx-container:hover .dnxte-promobx-before-title",
                        ),
                    ),
                    'label_prefix' => esc_html__('Pre Heading', 'et_builder'),
                    'toggle_slug' => 'dnxte_promobox_title_one_settings',
                ),
                'title_two' => array(
                    'label' => esc_html__('Heading', 'et_builder'),
                    'css' => array(
                        'main' => array(
                            'border_radii' => "%%order_class%% .dnxte-promobx-main-title",
                            'border_radii_hover'  	=> "%%order_class%% .dnxte-promobx-container:hover .dnxte-promobx-main-title",
                            'border_styles' => "%%order_class%% .dnxte-promobx-main-title",
                            'border_styles_hover' => "%%order_class%% .dnxte-promobx-container:hover .dnxte-promobx-main-title",
                        )
                    ),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxte_promobox_title_two_settings',
                ),
                'title_three' => array(
                    'label' => esc_html__('Post Heading', 'et_builder'),
                    'css' => array(
                        'main' => array(
                            'border_radii' => "%%order_class%% .dnxte-promobx-after-title",
                            'border_radii_hover'  	=> "%%order_class%% .dnxte-promobx-container:hover .dnxte-promobx-after-title",
                            'border_styles' => "%%order_class%% .dnxte-promobx-after-title",
                            'border_styles_hover' => "%%order_class%% .dnxte-promobx-container:hover .dnxte-promobx-after-title",
                        ),
                    ),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxte_promobox_title_three_settings',
                ),
                'content' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => "%%order_class%% .dnxte-promobx-description",
                            'border_radii_hover' => "%%order_class%% .dnxte-promobx-container:hover .dnxte-promobx-description",
                            'border_styles' => "%%order_class%% .dnxte-promobx-description",
                            'border_styles_hover' => "%%order_class%% .dnxte-promobx-container:hover .dnxte-promobx-description",
                        ),
                    ),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxte_promobox_content_settings',
                ),
                'image' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => "%%order_class%% .dnxte-promobx-thumb img",
                            'border_radii_hover'  	=> "%%order_class%% .dnxte-promobx-container:hover .dnxte-promobx-thumb img",
                            'border_styles' => "%%order_class%% .dnxte-promobx-thumb img",
                            'border_styles_hover' => "%%order_class%% .dnxte-promobx-container:hover .dnxte-promobx-thumb img",
                        ),
                    ),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxte_promobox_image_settings',
                ),
                'button' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => "%%order_class%% .dnxte-promobx-btn",
                            'border_radii_hover'  	=> "%%order_class%% .dnxte-promobx-container:hover .dnxte-promobx-btn",
                            'border_styles' => "%%order_class%% .dnxte-promobx-btn",
                            'border_styles_hover' => "%%order_class%% .dnxte-promobx-container:hover .dnxte-promobx-btn",
                        ),
                    ),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxte_promobox_button_settings',
                ),
                'offer' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => "%%order_class%% .dnxte-promo-box-badge",
                            'border_radii_hover'  	=> "%%order_class%% .dnxte-promobx-container:hover .dnxte-promo-box-badge",
                            'border_styles' => "%%order_class%% .dnxte-promo-box-badge",
                            'border_styles_hover' => "%%order_class%% .dnxte-promobx-container:hover .dnxte-promo-box-badge",
                        ),
                    ),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxte_promobox_offer_settings',
                ),
            ),
            'box_shadow' => array(
                'default' => array(
                    'css' => array(
                        'main' => '%%order_class%%',
                        'custom_style' => true,
                    ),
                    'default_on_fronts' => array(
                        'color' => '',
                        'position' => '',
                    ),
                ),
                'title_one' => array(
                    'label' => esc_html__('Title One Box Shadow', 'et_builder'),
                    'option_category' => 'layout',
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxte_promobox_title_one_settings',
                    'css' => array(
                        'main' => '%%order_class%% .dnxte-promobx-before-title',
                        'hover' => '%%order_class%% .dnxte-promobx-container:hover .dnxte-promobx-before-title',
                        'custom_style' => true,
                    ),
                    'default_on_fronts' => array(
                        'color' => '',
                        'position' => '',
                    ),
                ),
                'title_two' => array(
                    'label' => esc_html__('Title Two Box Shadow', 'et_builder'),
                    'option_category' => 'layout',
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxte_promobox_title_two_settings',
                    'css' => array(
                        'main' => '%%order_class%% .dnxte-promobx-main-title',
                        'hover' => '%%order_class%% .dnxte-promobx-container:hover .dnxte-promobx-main-title',
                        'custom_style' => true,
                    ),
                    'default_on_fronts' => array(
                        'color' => '',
                        'position' => '',
                    ),
                ),
                'title_three' => array(
                    'label' => esc_html__('Title Three Box Shadow', 'et_builder'),
                    'option_category' => 'layout',
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxte_promobox_title_three_settings',
                    'css' => array(
                        'main' => '%%order_class%% .dnxte-promobx-after-title',
                        'hover' => '%%order_class%% .dnxte-promobx-container:hover .dnxte-promobx-after-title',
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
                    'toggle_slug' => 'dnxte_promobox_content_settings',
                    'css' => array(
                        'main' => '%%order_class%% .dnxte-promobx-description',
                        'hover' => '%%order_class%% .dnxte-promobx-container:hover .dnxte-promobx-description',
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
                    'toggle_slug' => 'dnxte_promobox_image_settings',
                    'css' => array(
                        'main' => '%%order_class%% .dnxte-promobx-thumb img',
                        'hover' => '%%order_class%% .dnxte-promobx-container:hover .dnxte-promobx-thumb img',
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
                    'toggle_slug' => 'dnxte_promobox_button_settings',
                    'css' => array(
                        'main' => '%%order_class%% .dnxte-promobx-btn',
                        'hover' => '%%order_class%% .dnxte-promobx-container:hover .dnxte-promobx-btn',
                        'custom_style' => true,
                    ),
                    'default_on_fronts' => array(
                        'color' => '',
                        'position' => '',
                    ),
                ),
                'offer' => array(
                    'label' => esc_html__('Offer Box Shadow', 'et_builder'),
                    'option_category' => 'layout',
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxte_promobox_offer_settings',
                    'css' => array(
                        'main' => '%%order_class%% .dnxte-promo-box-badge',
                        'hover' => '%%order_class%% .dnxte-promobx-container:hover .dnxte-promo-box-badge',
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
                    'margin' => '%%order_class%% .dnxte-promobx-container',
                    'padding' => '%%order_class%% .dnxte-promobx-container',
                ),
            ),
        );
    }

    public function get_fields()
    {
        return array(
            'dnxte_promobox_title_one' => array(
                'label' => esc_html__('Pre Heading', 'et_builder'),
                'type' => 'text',
                'option_category' => 'basic_option',
                'description' => esc_html__('Input Pre Heading text', 'et_builder'),
                'toggle_slug' => 'main_content',
                'dynamic_content' => 'text',
            ),
            'dnxte_promobox_title_two' => array(
                'label' => esc_html__('Heading', 'et_builder'),
                'type' => 'text',
                'option_category' => 'basic_option',
                'description' => esc_html__('Input Heading text', 'et_builder'),
                'toggle_slug' => 'main_content',
                'dynamic_content' => 'text',
            ),
            'dnxte_promobox_title_three' => array(
                'label' => esc_html__('Post Heading', 'et_builder'),
                'type' => 'text',
                'option_category' => 'basic_option',
                'description' => esc_html__('Input Post Heading text', 'et_builder'),
                'toggle_slug' => 'main_content',
                'dynamic_content' => 'text',
            ),
            'dnxte_promobox_content' => array(
                'label' => esc_html__('Content', 'et_builder'),
                'type' => 'tiny_mce',
                'option_category' => 'basic_option',
                'description' => esc_html__('Input the main text content for your module here.', 'et_builder'),
                'toggle_slug' => 'main_content',
                'dynamic_content' => 'text',
            ),
            'dnxte_promobox_image' => array(
                'label' => esc_html__('Image', 'et_builder'),
                'type' => 'upload',
                'option_category' => 'basic_option',
                'upload_button_text' => esc_attr__('Upload an image', 'et_builder'),
                'choose_text' => esc_attr__('Choose an Image', 'et_builder'),
                'update_text' => esc_attr__('Set As Image', 'et_builder'),
                'description' => esc_html__('Upload an image to display at the top of your team person.', 'et_builder'),
                'toggle_slug' => 'dnxte_promobox_img',
                'dynamic_content' => 'image',
                'mobile_options' => true,
                'hover' => 'tabs',
            ),
            'dnxte_promobox_image_alt' => array(
                'label' => esc_html__('Image Alt', 'et_builder'),
                'type' => 'text',
                'option_category' => 'basic_option',
                'description' => esc_html__('Input image alt text', 'et_builder'),
                'toggle_slug' => 'dnxte_promobox_img',
                'dynamic_content' => 'text',
                'mobile_options' => true,
                'hover' => 'tabs',
            ),
            'dnxte_promobox_use_button' => array(
                'label' => esc_html__('Use Button', 'et_builder'),
                'type' => 'yes_no_button',
                'toggle_slug' => 'dnxte_promobox_btn',
                'options' => array(
                    'on' => esc_html__('Yes', 'et_builder'),
                    'off' => esc_html__('No', 'et_builder'),
                ),
                'affects' => array(
                    'dnxte_promobox_button_text',
                    'dnxte_promobox_button_link',
                    'dnxte_promobox_button_target',
                    'dnxte_promobox_button_bg_color',
                ),
                'default_on_front' => 'on',
            ),
            'dnxte_promobox_button_text' => array(
                'label' => esc_html__('Button Text', 'et_builder'),
                'type' => 'text',
                'option_category' => 'basic_option',
                'description' => esc_html__('Input button text', 'et_builder'),
                'toggle_slug' => 'dnxte_promobox_btn',
                'dynamic_content' => 'text',
                'mobile_options' => true,
                'hover' => 'tabs',
                'show_if' => array(
                    'dnxte_promobox_use_button' => 'on',
                ),
            ),
            'dnxte_promobox_button_link' => array(
                'label' => esc_html__('Link', 'et_builder'),
                'type' => 'text',
                'option_category' => 'basic_option',
                'default' => '#',
                'description' => esc_html__('When clicked the module will link to this URL.', 'et_builder'),
                'toggle_slug' => 'dnxte_promobox_btn',
                'show_if' => array(
                    'dnxte_promobox_use_button' => 'on',
                ),
            ),
            'dnxte_promobox_button_target' => array(
                'label' => esc_html__('Link Target', 'et_builder'),
                'type' => 'select',
                'description' => esc_html__('Select the link target', 'et_builder'),
                'option_category' => 'basic_option',
                'toggle_slug' => 'dnxte_promobox_btn',
                'options' => array(
                    '_self' => esc_html__('In The Same Window', 'et_builder'),
                    '_blank' => esc_html__('In The New Tab', 'et_builder'),

                ),
                'default' => '_self',
                'show_if' => array(
                    'dnxte_promobox_use_button' => 'on',
                ),
            ),
            'dnxte_promobox_use_offer' => array(
                'label' => esc_html__('Use Offer', 'et_builder'),
                'type' => 'yes_no_button',
                'toggle_slug' => 'dnxte_promobox_off',
                'options' => array(
                    'on' => esc_html__('Yes', 'et_builder'),
                    'off' => esc_html__('No', 'et_builder'),
                ),
                'affects' => array(
                    'dnxte_promobox_offer_text',
                    'dnxte_promobox_offer_bg_color',
                ),
                'default_on_front' => 'on',
            ),
            'dnxte_promobox_offer_text' => array(
                'label' => esc_html__('Offer Text', 'et_builder'),
                'type' => 'text',
                'option_category' => 'basic_option',
                'description' => esc_html__('Input Offer Text', 'et_builder'),
                'toggle_slug' => 'dnxte_promobox_off',
                'dynamic_content' => 'text',
                'mobile_options' => true,
                'hover' => 'tabs',
                'show_if' => array(
                    'dnxte_promobox_use_offer' => 'on',
                ),
            ),
            'dnxte_promobox_button_bg_color' => array(
                'label' => esc_html__('Button Background', 'et_builder'),
                'type' => 'color-alpha',
                'custom_color' => true,
                'default' => '#545454',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxte_promobox_button_settings',
                'mobile_options' => true,
                'hover' => 'tabs',
                'show_if' => array(
                    'dnxte_promobox_use_button' => 'on',
                ),
            ),
            'dnxte_promobox_offer_bg_color' => array(
                'label' => esc_html__('Offer Background', 'et_builder'),
                'type' => 'color-alpha',
                'custom_color' => true,
                'default' => '#0c71c3',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxte_promobox_offer_settings',
                'mobile_options' => true,
                'hover' => 'tabs',
                'show_if' => array(
                    'dnxte_promobox_use_offer' => 'on',
                ),
            ),
            'dnxte_promobox_title_one_margin' => array(
                'label' => esc_html__('Pre Heading Margin', 'et_builder'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'dnxte_promobox_title_one_padding' => array(
                'label' => esc_html__('Pre Heading Padding', 'et_builder'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'dnxte_promobox_title_two_margin' => array(
                'label' => esc_html__('Heading Margin', 'et_builder'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'dnxte_promobox_title_two_padding' => array(
                'label' => esc_html__('Heading Padding', 'et_builder'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'dnxte_promobox_title_three_margin' => array(
                'label' => esc_html__('Post Heading Margin', 'et_builder'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'dnxte_promobox_title_three_padding' => array(
                'label' => esc_html__('Post Heading Padding', 'et_builder'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'dnxte_promobox_content_margin' => array(
                'label' => esc_html__('Content Margin', 'et_builder'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'dnxte_promobox_content_padding' => array(
                'label' => esc_html__('Content Padding', 'et_builder'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'dnxte_promobox_image_margin' => array(
                'label' => esc_html__('Image Margin', 'et_builder'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'dnxte_promobox_image_padding' => array(
                'label' => esc_html__('Image Padding', 'et_builder'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'dnxte_promobox_button_margin' => array(
                'label' => esc_html__('Button Margin', 'et_builder'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'dnxte_promobox_button_padding' => array(
                'label' => esc_html__('Button Padding', 'et_builder'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'dnxte_promobox_offer_margin' => array(
                'label' => esc_html__('Offer Margin', 'et_builder'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'dnxte_promobox_offer_padding' => array(
                'label' => esc_html__('Offer Padding', 'et_builder'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'dnxte_promobox_image_width' => array(
                'label' => esc_html__('Image Width', 'et_builder'),
                'description' => esc_html__('Adjust the width of the image within the team.', 'et_builder'),
                'type' => 'range',
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxte_promobox_image_settings',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'default' => '100%',
                'default_unit' => '%',
                'default_on_front' => '',
                'allow_empty' => true,
                'range_settings' => array(
                    'min' => '0',
                    'max' => '100',
                    'step' => '1',
                ),
                'mobile_options' => true,
                'hover' => 'tabs',
            ),
            'dnxte_promobox_offer_width' => array(
                'label' => esc_html__('Offer Width', 'et_builder'),
                'description' => esc_html__('Adjust the width of the offer within the team.', 'et_builder'),
                'type' => 'range',
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxte_promobox_offer_settings',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'default' => '70px',
                'default_unit' => 'px',
                'default_on_front' => '',
                'allow_empty' => true,
                'range_settings' => array(
                    'min' => '0',
                    'max' => '100',
                    'step' => '1',
                ),
                'mobile_options' => true,
                'hover' => 'tabs',
            ),
            'dnxte_promobox_offer_height' => array(
                'label' => esc_html__('Offer Height', 'et_builder'),
                'description' => esc_html__('Adjust the height of the offer within the team.', 'et_builder'),
                'type' => 'range',
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxte_promobox_offer_settings',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'default' => '70px',
                'default_unit' => 'px',
                'default_on_front' => '',
                'allow_empty' => true,
                'range_settings' => array(
                    'min' => '0',
                    'max' => '100',
                    'step' => '1',
                ),
                'mobile_options' => true,
                'hover' => 'tabs',
            ),
            'dnxte_promobox_offer_horizontal' => array(
                'label' => esc_html__('Horizontal Position', 'et_builder'),
                'description' => esc_html__('Adjust the position of the offer.', 'et_builder'),
                'type' => 'range',
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxte_promobox_offer_settings',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'default' => '3%',
                'default_unit' => '%',
                'default_on_front' => '3%',
                'allow_empty' => true,
                'range_settings' => array(
                    'min' => '0',
                    'max' => '100',
                    'step' => '1',
                ),
                'mobile_options' => true,
                'hover' => 'tabs',
            ),
            'dnxte_promobox_offer_vertical' => array(
                'label' => esc_html__('Vertical Position', 'et_builder'),
                'description' => esc_html__('Adjust the position of the offer.', 'et_builder'),
                'type' => 'range',
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxte_promobox_offer_settings',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'default' => '3%',
                'default_unit' => '%',
                'default_on_front' => '3%',
                'allow_empty' => true,
                'range_settings' => array(
                    'min' => '0',
                    'max' => '100',
                    'step' => '1',
                ),
                'mobile_options' => true,
                'hover' => 'tabs',
            ),
            'dnxte_promobox_button_alignment' => array(
                'label' => esc_html__('Button Alignment', 'et_builder'),
                'type' => 'multiple_buttons',
                'options' => array(
                    'flex-start' => array('title' => 'Left'),
                    'center' => array('title' => 'Center'),
                    'flex-end' => array('title' => 'Right'),
                ),
                'default' => 'center',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxte_promobox_button_settings',
            ),
            'dnxte_promobox_use_mask' => array(
                'label' => esc_html__('Use Image Mask', 'et_builder'),
                'type' => 'yes_no_button',
                'toggle_slug' => 'dnxte_promobox_image_mask',
                'options' => array(
                    'on' => esc_html__('Yes', 'et_builder'),
                    'off' => esc_html__('No', 'et_builder'),
                ),
                'affects' => array(
                    'dnxte_promobox_mask_shape',
                    'dnxte_promobox_mask_size',
                    'dnxte_promobox_image_horizontal',
                    'dnxte_promobox_image_vertical'
                ),
                'default_on_front' => 'off',
            ),
            'dnxte_promobox_mask_shape' => array(
                'label' => esc_html__('Select Shape', 'et_builder'),
                'type' => 'select',
                'description' => esc_html__('Select the shape.', 'et_builder'),
                'option_category' => 'basic_option',
                'toggle_slug' => 'dnxte_promobox_image_mask',
                'options' => array(
                    'none' => esc_html__('None', 'et_builder'),
                    'shape1' => esc_html__('Shape 1', 'et_builder'),
                    'shape2' => esc_html__('Shape 2', 'et_builder'),
                    'shape3' => esc_html__('Shape 3', 'et_builder'),
                    'shape4' => esc_html__('Shape 4', 'et_builder'),
                    'shape5' => esc_html__('Shape 5', 'et_builder'),
                    'shape6' => esc_html__('Shape 6', 'et_builder'),
                    'shape7' => esc_html__('Shape 7', 'et_builder'),
                    'shape8' => esc_html__('Shape 8', 'et_builder'),
                    'shape9' => esc_html__('Shape 9', 'et_builder'),
                    'shape10' => esc_html__('Shape 10', 'et_builder'),
                    'shape11' => esc_html__('Shape 11', 'et_builder'),
                    'shape12' => esc_html__('Shape 12', 'et_builder'),
                    'shape13' => esc_html__('Shape 13', 'et_builder'),
                    'shape14' => esc_html__('Shape 14', 'et_builder'),
                    'shape15' => esc_html__('Shape 15', 'et_builder'),
                ),
                'default' => 'none',
                'depends_show_if' => 'on'
            ),
            'dnxte_promobox_use_mask_upload' => array(
                'label' => esc_html__('Use Upload Mask', 'et_builder'),
                'type' => 'yes_no_button',
                'toggle_slug' => 'dnxte_promobox_image_mask',
                'options' => array(
                    'on' => esc_html__('Yes', 'et_builder'),
                    'off' => esc_html__('No', 'et_builder'),
                ),
                'affects' => array(
                    'dnxte_promobox_upload_mask',
                    'dnxte_promobox_mask_size',
                    'dnxte_promobox_image_horizontal',
                    'dnxte_promobox_image_vertical'
                ),
                'default_on_front' => 'off',
                'show_if' => array(
                    'dnxte_promobox_use_mask' => 'off'
                )
            ),
            'dnxte_promobox_upload_mask' => array(
                'label' => esc_html__("Upload Mask", 'et_builder'),
                'type' => 'upload',
                'toggle_slug' => 'dnxte_promobox_image_mask',
                'option_category' => 'basic_option',
                'upload_button_text' => esc_html__('Upload a file', 'et_builder'),
                'choose_text' => esc_attr__('Choose a file', 'et_builder'),
                'update_text' => esc_attr__('Update file', 'et_builder'),
                'depends_show_if' => 'on'
            ),
            'dnxte_promobox_mask_size' => array(
                'label' => esc_html__('Select Mask Size', 'et_builder'),
                'type' => 'select',
                'description' => esc_html__('Select the mask size.', 'et_builder'),
                'option_category' => 'basic_option',
                'toggle_slug' => 'dnxte_promobox_image_mask',
                'options' => array(
                    'contain' => esc_html__('Contain', 'et_builder'),
                    'cover' => esc_html__('Cover', 'et_builder'),
                ),
                'default' => 'contain',
                'depends_show_if' => 'on',
            ),
            'dnxte_promobox_image_horizontal' => array(
                'label' => esc_html__('Image Horizontal Position', 'et_builder'),
                'description' => esc_html__('Adjust the position of the image.', 'et_builder'),
                'type' => 'range',
                'option_category' => 'layout',
                'toggle_slug' => 'dnxte_promobox_image_mask',
                'default' => '0',
                'default_on_front' => '0',
                'validate_unit' => false,
                'unitless'  => true,
                'allow_empty' => true,
                'range_settings' => array(
                    'min' => '-50',
                    'max' => '100',
                    'step' => '1',
                ),
                'mobile_options' => true,
                'hover' => 'tabs',
                'depends_show_if' => 'on'
            ),
            'dnxte_promobox_image_vertical' => array(
                'label' => esc_html__('Image Vertical Position', 'et_builder'),
                'description' => esc_html__('Adjust the position of the image.', 'et_builder'),
                'type' => 'range',
                'option_category' => 'layout',
                'toggle_slug' => 'dnxte_promobox_image_mask',
                'default' => '0',
                'default_on_front' => '0',
                'allow_empty' => true,
                'validate_unit' => false,
                'unitless' => true,
                'range_settings' => array(
                    'min' => '-50',
                    'max' => '100',
                    'step' => '1',
                ),
                'mobile_options' => true,
                'hover' => 'tabs',
                'depends_show_if' => 'on'
            ),
        );
    }

    public function render($attrs, $content, $render_slug)
    {
        $multi_view = et_pb_multi_view_options($this);
        $title_one = $this->props['dnxte_promobox_title_one'];
        $title_two = $this->props['dnxte_promobox_title_two'];
        $title_three = $this->props['dnxte_promobox_title_three'];
        $content = $this->props['dnxte_promobox_content'];
        $button_link = esc_url($this->props['dnxte_promobox_button_link']);
        $button_text = $this->props['dnxte_promobox_button_text'];
        $button_target = $this->props['dnxte_promobox_button_target'];
        $use_shape = $this->props['dnxte_promobox_use_mask'];

        $use_mask_upload = $this->props['dnxte_promobox_use_mask_upload'];
        
        $shape_name = "on" == $use_shape && "none" != $this->props['dnxte_promobox_mask_shape'] ? $this->props['dnxte_promobox_mask_shape'] : "";
        $shape_size = $this->props['dnxte_promobox_mask_size'];
        $uploaded_mask = "on" == $use_mask_upload ? $this->props['dnxte_promobox_upload_mask'] : "";
        


        if( 'on' == $use_shape ) {
            wp_enqueue_script( 'dnext_svg_shape_frontend' );
        }


        // Image
        $dnxte_promobox_img = "";
        if ($multi_view->has_value('dnxte_promobox_image')) {
            $dnxte_promobox_img = $multi_view->render_element(array(
                'tag' => 'img',
                'attrs' => array(
                    'src' => '{{dnxte_promobox_image}}',
                    'alt' => '{{dnxte_promobox_image_alt}}',
                    'class' => 'img-fluid',
                ),
            ));
        }

        // Pre Heading
        $dnxte_promobox_title1 = "";
        $dnxte_promobox_title2 = "";
        $dnxte_promobox_title3 = "";

        if ($multi_view->has_value('dnxte_promobox_title_one')) {
            $dnxte_promobox_title1 = $multi_view->render_element(array(
                'tag' => 'div',
                'content' => '{{dnxte_promobox_title_one}}',
                'attrs' => array(
                    'class' => 'dnxte-promobx-before-title',
                ),
            ));
        }

        if ($multi_view->has_value('dnxte_promobox_title_two')) {
            $dnxte_promobox_title2 = $multi_view->render_element(array(
                'tag' => et_pb_process_header_level($this->props['header_level'], 'h2'),
                'content' => '{{dnxte_promobox_title_two}}',
                'attrs' => array(
                    'class' => 'dnxte-promobx-main-title',
                ),
            ));
        }

        if ($multi_view->has_value('dnxte_promobox_title_three')) {
            $dnxte_promobox_title3 = $multi_view->render_element(array(
                'tag' => 'div',
                'content' => '{{dnxte_promobox_title_three}}',
                'attrs' => array(
                    'class' => 'dnxte-promobx-after-title',
                ),
            ));
        }

        $dnxte_promobox_description = $multi_view->render_element( array(
            'tag' => 'div',
            'content' => '{{dnxte_promobox_content}}',
            'attrs' => array(
            'class' => 'dnxte-promobx-description',
            )
        ));

        // Button
        $dnxte_promobox_button = "";
        $dnxte_promobox_button = $multi_view->render_element(array(
            'tag' => 'a',
            'content' => '{{dnxte_promobox_button_text}}',
            'attrs' => array(
                'href' => $button_link,
                'target' => $button_target,
                'class' => 'dnxte-promobx-btn',
            ),
        ));

        $dnxte_promobox_button_container = "";
        if($this->props['dnxte_promobox_use_button'] === "on") {
            $dnxte_promobox_button_container = sprintf('<div class="dnxte-promobx-button">
                        %1$s
                    </div>', $dnxte_promobox_button);
        } 

        // Offer
        $dnxte_promobox_offer = "";
        $dnxte_promobox_offer = $multi_view->render_element(array(
            'tag' => 'span',
            'content' => '{{dnxte_promobox_offer_text}}',
        ));

        $dnxte_promobox_offer_container = "";
        if ($this->props['dnxte_promobox_use_offer'] === "on") {
            $dnxte_promobox_offer_container = sprintf('<div class="dnxte-promo-box-badge">
                <div class="dnxte-promobx-badge">
                    %1$s
                    </div>
                </div>', $dnxte_promobox_offer);
        }

        // Button background color
        $button_bg = $this->props['dnxte_promobox_button_bg_color'];
        $button_bg_values = et_pb_responsive_options()->get_property_values($this->props, 'dnxte_promobox_button_bg_color');
        $button_bg_tablet = isset($button_bg_values['tablet']) ? $button_bg_values['tablet'] : '';
        $button_bg_phone = isset($button_bg_values['phone']) ? $button_bg_values['phone'] : '';
        $button_bg_hover = $this->get_hover_value('dnxte_promobox_button_bg_color');

        if ("" !== $button_bg) {
            $button_bg_style = sprintf('background-color: %1$s;', esc_attr__($button_bg, 'et_builder'));
            $button_bg_style_tablet = sprintf('background-color: %1$s', esc_attr__($button_bg_tablet, 'et_builder'));
            $button_bg_style_phone = sprintf('background-color: %1$s', esc_attr__($button_bg_phone, 'et_builder'));
            $button_bg_style_hover = "";

            if (et_builder_is_hover_enabled('dnxte_promobox_button_bg_color', $this->props)) {
                $button_bg_style_hover = sprintf('background-color: %1$s;', esc_attr__($button_bg_hover, 'et_builder'));
            }

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte-promobx-btn",
                'declaration' => $button_bg_style,
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte-promobx-btn",
                'declaration' => $button_bg_style_tablet,
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte-promobx-btn",
                'declaration' => $button_bg_style_phone,
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));

            if ("" !== $button_bg_style_hover) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => $this->add_hover_to_order_class("%%order_class%% .dnxte-promobx-container:hover .dnxte-promobx-btn"),
                    'declaration' => $button_bg_style_hover,
                ));
            }
        }
        // Button background color end

        // Offer background color
        $offer_bg = $this->props['dnxte_promobox_offer_bg_color'];
        $offer_bg_values = et_pb_responsive_options()->get_property_values($this->props, 'dnxte_promobox_offer_bg_color');
        $offer_bg_tablet = isset($offer_bg_values['tablet']) ? $offer_bg_values['tablet'] : '';
        $offer_bg_phone = isset($offer_bg_values['phone']) ? $offer_bg_values['phone'] : '';
        $offer_bg_hover = $this->get_hover_value('dnxte_promobox_offer_bg_color');

        if ("" !== $offer_bg) {
            $offer_bg_style = sprintf('background-color: %1$s;', $offer_bg);
            $offer_bg_style_tablet = sprintf('background-color: %1$s;', $offer_bg_tablet);
            $offer_bg_style_phone = sprintf('background-color: %1$s;', $offer_bg_phone);
            $offer_bg_style_hover = "";

            if (et_builder_is_hover_enabled('dnxte_promobox_offer_bg_color', $this->props)) {
                $offer_bg_style_hover = sprintf('background-color: %1$s;', $offer_bg_hover);
            }

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte-promo-box-badge",
                'declaration' => $offer_bg_style,
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte-promo-box-badge",
                'declaration' => $offer_bg_style_tablet,
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte-promo-box-badge",
                'declaration' => $offer_bg_style_phone,
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));

            if ("" !== $offer_bg_style_hover) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => $this->add_hover_to_order_class("%%order_class%% .dnxte-promobx-container:hover .dnxte-promo-box-badge"),
                    'declaration' => $offer_bg_style_hover,
                ));
            }
        }
        // Offer background color end

        // Image Width
        $dnxte_promobox_image_width = $this->props['dnxte_promobox_image_width'];
        $dnxte_promobox_image_width_hover = $this->get_hover_value('dnxte_promobox_image_width');
        $dnxte_promobox_image_width_tablet = $this->props['dnxte_promobox_image_width_tablet'];
        $dnxte_promobox_image_width_phone = $this->props['dnxte_promobox_image_width_phone'];
        $dnxte_promobox_image_width_last_edited = $this->props['dnxte_promobox_image_width_last_edited'];

        if ('' !== $dnxte_promobox_image_width) {
            $dnxte_promobox_image_width_responsive_active = et_pb_get_responsive_status($dnxte_promobox_image_width_last_edited);

            $dnxte_promobox_image_width_values = array(
                'desktop' => $dnxte_promobox_image_width,
                'tablet' => $dnxte_promobox_image_width_responsive_active ? $dnxte_promobox_image_width_tablet : '',
                'phone' => $dnxte_promobox_image_width_responsive_active ? $dnxte_promobox_image_width_phone : '',
            );
            $dnxte_promobox_image_width_selector = "%%order_class%% .dnxte-promobx-thumb img";
            et_pb_responsive_options()->generate_responsive_css($dnxte_promobox_image_width_values, $dnxte_promobox_image_width_selector, 'max-width', $render_slug);

            if (et_builder_is_hover_enabled('dnxte_promobox_image_width', $this->props)) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => $this->add_hover_to_order_class('%%order_class%% .dnxte-promobx-thumb img'),
                    'declaration' => sprintf(
                        'max-width: %1$s;',
                        esc_html($dnxte_promobox_image_width_hover)
                    ),
                ));
            }
        }
        // Image width end

        // Offer width height
        $offer_width = isset( $this->props['dnxte_promobox_offer_width'] ) ? $this->props['dnxte_promobox_offer_width'] : '70px';
        $offer_width_values = et_pb_responsive_options()->get_property_values($this->props, 'dnxte_promobox_offer_width');
        $offer_width_tablet = isset($offer_width_values['tablet']) ? $offer_width_values['tablet'] : '';
        $offer_width_phone = isset($offer_width_values['phone']) ? $offer_width_values['phone'] : '';
        $offer_width_hover = $this->get_hover_value('dnxte_promobox_offer_width');

        $offer_height = isset( $this->props['dnxte_promobox_offer_height'] ) ? $this->props['dnxte_promobox_offer_height'] : '70px';
        $offer_height_values = et_pb_responsive_options()->get_property_values($this->props, 'dnxte_promobox_offer_height');
        $offer_height_tablet = isset($offer_height_values['tablet']) ? $offer_height_values['tablet'] : '';
        $offer_height_phone = isset($offer_height_values['phone']) ? $offer_height_values['phone'] : '';
        $offer_height_hover = $this->get_hover_value('dnxte_promobox_offer_height');


        if ("" !== $offer_width || "" !== $offer_height) {
            $offer_size_style = sprintf('width: %1$s;height: %2$s;', esc_attr__($offer_width, 'et_builder'), esc_attr__($offer_height, 'et_builder'));
            $offer_size_style_tablet = sprintf('width: %1$s;height: %2$s;', esc_attr__($offer_width_tablet, 'et_builder'), esc_attr__($offer_height_tablet, 'et_builder'));

            $offer_size_style_phone = sprintf('width: %1$s;height: %2$s;', esc_attr__($offer_width_phone, 'et_builder'), esc_attr__($offer_height_phone, 'et_builder'));
            $offer_size_style_hover = "";

            if (et_builder_is_hover_enabled('dnxte_promobox_offer_width', $this->props) || et_builder_is_hover_enabled('dnxte_promobox_offer_height', $this->props)) {
                $offer_size_style_hover = sprintf('width: %1$s;height: %2$s;', esc_attr__($offer_width_hover, 'et_builder'), esc_attr__($offer_height_hover, 'et_builder'));
            }


            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte-promo-box-badge",
                'declaration' => $offer_size_style,
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte-promo-box-badge",
                'declaration' => $offer_size_style_tablet,
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte-promo-box-badge",
                'declaration' => $offer_size_style_phone,
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));

            if ("" !== $offer_size_style_hover) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => $this->add_hover_to_order_class("%%order_class%% .dnxte-promo-box-badge"),
                    'declaration' => $offer_size_style_hover,
                ));
            }
        }
        // Offer width height end

        // Offer Position
        $offer_horizontal = $this->props['dnxte_promobox_offer_horizontal'];
        $offer_horizontal_values = et_pb_responsive_options()->get_property_values($this->props, 'dnxte_promobox_offer_horizontal');
        $offer_horizontal_tablet = isset($offer_horizontal_values['tablet']) ? $offer_horizontal_values['tablet'] : '';
        $offer_horizontal_phone = isset($offer_horizontal_values['phone']) ? $offer_horizontal_values['phone'] : '';
        $offer_horizontal_hover = $this->get_hover_value('dnxte_promobox_offer_horizontal');

        $offer_vertical = $this->props['dnxte_promobox_offer_vertical'];
        $offer_vertical_values = et_pb_responsive_options()->get_property_values($this->props, 'dnxte_promobox_offer_vertical');
        $offer_vertical_tablet = isset($offer_vertical_values['tablet']) ? $offer_vertical_values['tablet'] : '';
        $offer_vertical_phone = isset($offer_vertical_values['phone']) ? $offer_vertical_values['phone'] : '';
        $offer_vertical_hover = $this->get_hover_value('dnxte_promobox_offer_vertical');

        if ("" !== $offer_horizontal || "" !== $offer_vertical) {
            $offer_position_style = sprintf('right: %1$s;bottom: %2$s;', $offer_horizontal, $offer_vertical);
            $offer_position_style_tablet = sprintf('right: %1$s;bottom: %2$s;', esc_attr($offer_horizontal_tablet), $offer_vertical_tablet);

            $offer_position_style_phone = sprintf('right: %1$s;bottom: %2$s;', $offer_horizontal_phone, $offer_vertical_phone);
            $offer_position_style_hover = "";

            if (et_builder_is_hover_enabled('dnxte_promobox_offer_horizontal', $this->props) || et_builder_is_hover_enabled('dnxte_promobox_offer_vertical', $this->props)) {
                $offer_position_style_hover = sprintf('right: %1$s;bottom: %2$s;', $offer_horizontal_hover, $offer_vertical_hover);
            }

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte-promo-box-badge",
                'declaration' => $offer_position_style,
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte-promo-box-badge",
                'declaration' => $offer_position_style_tablet,
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte-promo-box-badge",
                'declaration' => $offer_position_style_phone,
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));

            if ("" !== $offer_position_style_hover) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => $this->add_hover_to_order_class("%%order_class%% .dnxte-promo-box-badge"),
                    'declaration' => $offer_position_style_hover,
                ));
            }
        }
        // Offer position end

        // Button alignment
        $button_alignment = $this->props['dnxte_promobox_button_alignment'];
        $button_alignment_style = sprintf('justify-content: %1$s;', esc_attr__($button_alignment, 'et_builder'));

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .dnxte-promobx-button",
            'declaration' => $button_alignment_style,
        ));
        // Button alignment style

        $positionArr = array(
            "horizontal_slug" => "dnxte_promobox_image_horizontal",
            "vertical_slug"=> "dnxte_promobox_image_vertical",
            "css_selector" => array(
                "desktop" => '%%order_class%% .dnxte-promobx-thumb img',
                "hover" => '%%order_class%% .dnxte-promobx-thumb img:hover'
            ),
            "use_shape" => $use_shape,
            "use_mask_upload" => $use_mask_upload,
        );
        Common::shape_image_position($positionArr, $render_slug, $this);

        $this->apply_css($render_slug);
        return sprintf(
            '<div class="dnxte-promobx-container">
            <div class="dnxte-promobx-inner-wrap">
                <div class="dnxte-promobx-header">
                    <div class="dnxte-promobx-title-wrap">
                        %2$s
                        %3$s
                        %4$s
                    </div>
                    <div class="dnxte-promobx-thumb" data-svg-shape="%8$s" data-shape-size="%9$s" data-use-upload="%10$s" data-uploaded-mask="%11$s">
                       %1$s
                    </div>
                </div>
                <div class="dnxte-promobx-footer">
                    %5$s
                    %6$s
                </div>
            </div>
            %7$s
        </div>',
            et_core_esc_previously($dnxte_promobox_img),
            et_core_esc_previously($dnxte_promobox_title1),
            et_core_esc_previously($dnxte_promobox_title2),
            et_core_esc_previously($dnxte_promobox_title3),
            $dnxte_promobox_description,
            et_core_esc_previously($dnxte_promobox_button_container),
            et_core_esc_previously($dnxte_promobox_offer_container),
            $shape_name,
            $shape_size,
            $use_mask_upload,
            $uploaded_mask
        );
    }

    public function apply_css($render_slug)
    {

        /**
         * Custom Padding Margin Output
         *
         */
        Common::dnxt_set_style($render_slug, $this->props, "dnxte_promobox_title_one_margin", "%%order_class%% .dnxte-promobx-before-title", "margin", true);
        Common::dnxt_set_style($render_slug, $this->props, "dnxte_promobox_title_one_padding", "%%order_class%% .dnxte-promobx-before-title", "padding", true);

        Common::dnxt_set_style($render_slug, $this->props, "dnxte_promobox_title_two_margin", "%%order_class%% .dnxte-promobx-main-title", "margin", true);
        Common::dnxt_set_style($render_slug, $this->props, "dnxte_promobox_title_two_padding", "%%order_class%% .dnxte-promobx-main-title", "padding", true);

        Common::dnxt_set_style($render_slug, $this->props, "dnxte_promobox_title_three_margin", "%%order_class%% .dnxte-promobx-after-title", "margin", true);
        Common::dnxt_set_style($render_slug, $this->props, "dnxte_promobox_title_three_padding", "%%order_class%% .dnxte-promobx-after-title", "padding", true);

        Common::dnxt_set_style($render_slug, $this->props, "dnxte_promobox_content_margin", "%%order_class%% .dnxte-promobx-description", "margin", true);
        Common::dnxt_set_style($render_slug, $this->props, "dnxte_promobox_content_padding", "%%order_class%% .dnxte-promobx-description", "padding", true);

        Common::dnxt_set_style($render_slug, $this->props, "dnxte_promobox_image_margin", "%%order_class%% .dnxte-promobx-thumb img", "margin", true);
        Common::dnxt_set_style($render_slug, $this->props, "dnxte_promobox_image_padding", "%%order_class%% .dnxte-promobx-thumb img", "padding", true);

        Common::dnxt_set_style($render_slug, $this->props, "dnxte_promobox_button_margin", "%%order_class%% .dnxte-promobx-btn", "margin", true);
        Common::dnxt_set_style($render_slug, $this->props, "dnxte_promobox_button_padding", "%%order_class%% .dnxte-promobx-btn", "padding", true);

        Common::dnxt_set_style($render_slug, $this->props, "dnxte_promobox_offer_margin", "%%order_class%% .dnxte-promo-box-badge", "margin", true);
        Common::dnxt_set_style($render_slug, $this->props, "dnxte_promobox_offer_padding", "%%order_class%% .dnxte-promo-box-badge", "padding", true);
    }
}

new Divi_NxtePromobox;
