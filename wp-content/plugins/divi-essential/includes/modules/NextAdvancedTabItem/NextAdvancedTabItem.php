<?php
include_once DIVI_ESSENTIAL_PATH . '/includes/modules/base/Common.php';

class NextAdvancedTabItem extends ET_Builder_Module
{

    public $slug = 'dnxte_advanced_tab_item';
    public $vb_support = 'on';
    public $type = 'child';
    public $child_title_var = 'admin_label_text';
    public $child_title_fallback_var = 'tab_title';
    public $module_order_class = "%%order_class%%";

    protected $module_credits = array(
        'module_uri' => 'https://www.diviessential.com/divi-next-advanced-tab/',
        'author' => 'Divi Next',
        'author_uri' => 'www.divinext.com',
    );

    public function init()
    {
        $this->name = esc_html__('Next Advanced Tab Item', 'et_builder');

        $this->settings_modal_toggles = array(
            'general' => array(
                'toggles' => array(
                    'tab_content' => array(
                        'title' => esc_html__('Tab Content', 'et_builder'),
                    ),
                    'body_content' => array(
                        'title' => esc_html__('Body Content', 'et_builder'),
                    ),
                    'tab_bg' => array(
                        'title' => esc_html__('Tab Background', 'et_builder'),
                    ),
                    'content_bg' => array(
                        'title' => esc_html__('Content Background', 'et_builder'),
                    ),
                ),
            ),
            'advanced' => array(
                'toggles' => array(
                    'tab_settings' => array(
                        'title' => esc_html__('Tab Settings  ', 'et_builder'),
                        'sub_toggles' => array(
                            'title' => array(
                                'name' => esc_html__('Title', 'et_builder'),
                            ),
                            'subtitle' => array(
                                'name' => esc_html__('Subtitle', 'et_builder'),
                            ),
                        ),
                        'tabbed_subtoggles' => true,
                    ),
                    'body_settings' => array(
                        'title' => esc_html__('Body Settings  ', 'et_builder'),
                        'sub_toggles' => array(
                            'title' => array(
                                'name' => esc_html__('Title', 'et_builder'),
                            ),
                            'description' => array(
                                'name' => esc_html__('Description', 'et_builder'),
                            ),
                        ),
                        'tabbed_subtoggles' => true,
                    ),
                    'image_settings' => esc_html__('Image Settings', 'et_builder'),
                    'tab_icon_settings' => array(
                        'title' =>esc_html__('Tab Icon/Image Settings', 'et_builder'),
                        'sub_toggles' => array(
                            'normal' => array(
                                'name' => esc_html__('Normal', 'et_builder'),
                            ),
                            'active' => array(
                                'name' => esc_html__('Active', 'et_builder'),
                            ),
                        ),
                        'tabbed_subtoggles' => true,
                    ),
                    'body_icon_settings' => esc_html__('Body Icon Settings', 'et_builder'),
                    'tab_spacing' => esc_html__('Tab Spacing', 'et_builder'),
                    'body_spacing' => esc_html__('Body Spacing', 'et_builder'),
                    'border' => array(
                        'title' => esc_html__('Border', 'et_builder'),
                        'sub_toggles' => array(
                            'tab' => array(
                                'name' => esc_html__('Tab', 'et_builder'),
                            ),
                            'body' => array(
                                'name' => esc_html__('Body', 'et_builder'),
                            ),
                        ),
                        'tabbed_subtoggles' => true,
                    ),
                    'box_shadows' => array(
                        'title' => esc_html__('Box Shadow', 'et_builder'),
                        'sub_toggles' => array(
                            'tab' => array(
                                'name' => esc_html__('Tab', 'et_builder'),
                            ),
                            'body' => array(
                                'name' => esc_html__('Body', 'et_builder'),
                            ),
                        ),
                        'tabbed_subtoggles' => true,
                    ),
                ),
            ),
        );

        $this->custom_css_fields = array(
            'tab_title' => array(
                'label' => esc_html__('Tab Title', 'et_builder'),
                'selector' => '%%order_class%% .dnxte_tab_nav_title',
            ),
            'tab_subtitle' => array(
                'label' => esc_html__('Tab Subtitle', 'et_builder'),
                'selector' => '%%order_class%% .dnxte_tab_nav_pra',
            ),
            'tab_icon' => array(
                'label' => esc_html__('Tab Icon/Image', 'et_builder'),
                'selector' => '%%order_class%% span.dnxte_tab_nav_icon,%%order_class%% .dnxte_tab_nav_image',
            ),
            'tab_active_icon' => array(
                'label' => esc_html__('Active Tab Icon/Image', 'et_builder'),
                'selector' => '%%order_class%% span.dnxte_tab_nav_icon_active,%%order_class%% .dnxte_tab_nav_image_active',
            ),
            'body_title' => array(
                'label' => esc_html__('Body Title', 'et_builder'),
                'selector' => '%%order_class%% .dnxte_tab_content_slidebar_two .dnxte_tab_content_title',
            ),
            'body_description' => array(
                'label' => esc_html__('Body Description', 'et_builder'),
                'selector' => '%%order_class%% .dnxte_tab_content_slidebar_two .dnxte_tab_content_pra',
            ),
            'body_icon' => array(
                'label' => esc_html__('Body Icon', 'et_builder'),
                'selector' => '%%order_class%% .dnxte_tab_content_slidebar_one .dnxte_tab_content_icon',
            ),
            'body_image' => array(
                'label' => esc_html__('Body Image', 'et_builder'),
                'selector' => '%%order_class%% .dnxte_tab_content_slidebar_one img',
            ),
        );
    }

    public function get_advanced_fields_config()
    {
        return array(
            'text' => false,
            'link_options' => false,
            'fonts' => array(
                'default' => array(
                    'label' => esc_html__('Body Title', 'et_builder'),
                    'css' => array(
                        'main' => "%%order_class%% .dnxte_tab_content_slidebar_two .dnxte_tab_content_title",
                        'important' => 'plugin-only',
                    ),
                    'header_level' => array(
                        'default' => 'h3',
                    ),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'body_settings',
                    'sub_toggle' => 'title',
                ),
                'description' => array(
                    'label' => esc_html__('Body Description', 'et_builder'),
                    'css' => array(
                        'main' => "%%order_class%% .dnxte_tab_content_slidebar_two .dnxte_tab_content_pra",
                        'important' => 'plugin-only',
                    ),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'body_settings',
                    'sub_toggle' => 'description',
                ),
                'tab_title' => array(
                    'label' => esc_html__('Tab Title', 'et_builder'),
                    'css' => array(
                        'main' => "%%order_class%% .dnxte_tab_nav_title",
                        'hover' => "%%order_class%%:hover .dnxte_tab_nav_title",
                        'important' => 'plugin-only',
                    ),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'tab_settings',
                    'sub_toggle' => 'title',
                ),
                'tab_subtitle' => array(
                    'label' => esc_html__('Tab Subtitle', 'et_builder'),
                    'css' => array(
                        'main' => "%%order_class%% .dnxte_tab_nav_pra",
                        'hover' => "%%order_class%%:hover .dnxte_tab_nav_pra",
                        'important' => 'plugin-only',
                    ),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'tab_settings',
                    'sub_toggle' => 'subtitle',
                ),
            ),
            'button' => array(
                'button' => array(
                    'label' => esc_html__('Button', 'et_builder'),
                    'css' => array(
                        'main' => "%%order_class%% .dnxte_tab_content_btn",
                        'important' => true,
                    ),
                    'use_alignment' => true,
                    'custom_button' => true,
                    'box_shadow' => array(
                        'css' => array(
                            'main' => '%%order_class%% .dnxte_tab_content_btn',
                        ),
                    ),
                    'tab_slug' => 'advanced',
                ),
            ),
            'borders' => array(
                'default' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => "%%order_class%%.dnxte-ad-tab,%%order_class%% .dnxte_tab_a",
                            'border_styles' => "%%order_class%%.dnxte-ad-tab,%%order_class%% .dnxte_tab_a",
                        ),
                        // 'important' => 'all',
                    ),
                    'toggle_slug' => 'border',
                    'sub_toggle' => 'tab',
                    'tab_slug' => 'advanced',
                ),
                'body' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => "%%order_class%%.dnxte-ad-panel, %%order_class%% .dnxte_tab_content",
                            'border_styles' => "%%order_class%%.dnxte-ad-panel, %%order_class%% .dnxte_tab_content",
                        ),
                        'important' => 'all',
                    ),
                    'toggle_slug' => 'border',
                    'sub_toggle' => 'body',
                    'tab_slug' => 'advanced',
                ),
                'body_image' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => "%%order_class%% .dnxte_tab_content_slidebar_one img",
                            'border_styles' => "%%order_class%% .dnxte_tab_content_slidebar_one img",
                        ),
                        'important' => 'all',
                    ),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'image_settings',
                ),
                'tab_image' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => "%%order_class%% .dnxte_tab_nav_image img",
                            'border_styles' => "%%order_class%% .dnxte_tab_nav_image img",
                        ),
                        'important' => 'all',
                    ),
                    'label_prefix' => esc_html__('Tab image', 'et_builder'),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'tab_icon_settings',
                    'sub_toggle'    => 'normal'
                ),
                'tab_image_active' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => "%%order_class%% .dnxte_tab_nav_image_active img",
                            'border_styles' => "%%order_class%% .dnxte_tab_nav_image_active img",
                        ),
                        'important' => 'all',
                    ),
                    'label_prefix' => esc_html__('Tab image', 'et_builder'),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'tab_icon_settings',
                    'sub_toggle'    => 'active'
                ),
                'tab_title' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => "%%order_class%% .dnxte_tab_nav_title",
                            'border_styles' => "%%order_class%% .dnxte_tab_nav_title",
                        ),
                        'important' => 'all',
                    ),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'tab_settings',
                    'sub_toggle' => 'title',
                ),
                'tab_subtitle' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => "%%order_class%% .dnxte_tab_nav_pra",
                            'border_styles' => "%%order_class%% .dnxte_tab_nav_pra",
                        ),
                        'important' => 'all',
                    ),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'tab_settings',
                    'sub_toggle' => 'subtitle',
                ),
                'body_title' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => "%%order_class%% .dnxte_tab_content_slidebar_two .dnxte_tab_content_title",
                            'border_styles' => "%%order_class%% .dnxte_tab_content_slidebar_two .dnxte_tab_content_title",
                        ),
                        'important' => 'all',
                    ),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'body_settings',
                    'sub_toggle' => 'title',
                ),
                'body_description' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => "%%order_class%% .dnxte_tab_content_slidebar_two .dnxte_tab_content_pra",
                            'border_styles' => "%%order_class%% .dnxte_tab_content_slidebar_two .dnxte_tab_content_pra",
                        ),
                        'important' => 'all',
                    ),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'body_settings',
                    'sub_toggle' => 'description',
                ),
            ),
            'box_shadow' => array(
                'default' => array(
                    'css' => array(
                        'main' => '%%order_class%%.dnxte-ad-tab, %%order_class%% .dnxte_tab_a',
                        'custom_style' => true,
                    ),
                    'default_on_fronts' => array(
                        'color' => '',
                        'position' => '',
                    ),
                    'toggle_slug' => 'box_shadows',
                    'sub_toggle' => 'tab',
                    'tab_slug' => 'advanced',
                ),
                'body' => array(
                    'css' => array(
                        'main' => '%%order_class%%.dnxte-ad-panel, %%order_class%% .dnxte_tab_content',
                        'custom_style' => true,
                    ),
                    'default_on_fronts' => array(
                        'color' => '',
                        'position' => '',
                    ),
                    'toggle_slug' => 'box_shadows',
                    'sub_toggle' => 'body',
                    'tab_slug' => 'advanced',
                ),
                'body_image' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnxte_tab_content_slidebar_one img',
                        'custom_style' => true,
                    ),
                    'default_on_fronts' => array(
                        'color' => '',
                        'position' => '',
                    ),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'image_settings',
                ),
                'tab_image' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnxte_tab_nav_image img',
                    ),
                    'label_prefix'  => esc_html__('Tab Image', 'et_builder'),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'tab_icon_settings',
                    'sub_toggle' => 'normal',
                ),
                'tab_image_active' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnxte_tab_nav_image_active img',
                    ),
                    'label_prefix'  => esc_html__('Tab Image Active', 'et_builder'),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'tab_icon_settings',
                    'sub_toggle' => 'active',
                ),
                'tab_title' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnxte_tab_nav_title',
                        'custom_style' => true,
                    ),
                    'default_on_fronts' => array(
                        'color' => '',
                        'position' => '',
                    ),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'tab_settings',
                    'sub_toggle' => 'title',
                ),
                'tab_subtitle' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnxte_tab_nav_pra',
                        'custom_style' => true,
                    ),
                    'default_on_fronts' => array(
                        'color' => '',
                        'position' => '',
                    ),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'tab_settings',
                    'sub_toggle' => 'subtitle',
                ),
                'body_title' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnxte_tab_content_slidebar_two .dnxte_tab_content_title',
                        'custom_style' => true,
                    ),
                    'default_on_fronts' => array(
                        'color' => '',
                        'position' => '',
                    ),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'body_settings',
                    'sub_toggle' => 'title',
                ),
                'body_description' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnxte_tab_content_slidebar_two .dnxte_tab_content_pra',
                        'custom_style' => true,
                    ),
                    'default_on_fronts' => array(
                        'color' => '',
                        'position' => '',
                    ),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'body_settings',
                    'sub_toggle' => 'description',
                ),
            ),
            'filters' => array(
                'child_filters_target' => array(
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'image_settings',
                ),
            ),
            'margin_padding' => false,
            'background' => false,
        );
    }

    public function get_fields()
    {
        $admin_label = array(
            'admin_label_text' => array(
                'label' => esc_html__('Admin Label', 'et_builder'),
                'type' => 'text',
                'option_category' => 'basic_option',
                'description' => esc_html__('This will change the label of the module in the builder for easy identification.', 'et_builder'),
                'toggle_slug' => 'admin_label',
                'default' => 'Tab Item',
            ),
        );

        $tab_settings = array(
            'tab_title' => array(
                'label' => esc_html__('Title', 'et_builder'),
                'type' => 'text',
                'option_category' => 'basic_option',
                'description' => esc_html__('Input the title of the tab', 'et_builder'),
                'toggle_slug' => 'tab_content',
                'dynamic_content' => 'text',
            ),
            'tab_subtitle' => array(
                'label' => esc_html__('Subtitle', 'et_builder'),
                'type' => 'text',
                'option_category' => 'basic_option',
                'description' => esc_html__('Input the subtitle or a short description of the tab.', 'et_builder'),
                'toggle_slug' => 'tab_content',
                'dynamic_content' => 'text',
            ),
            'tab_use_icon_or_image' => array(
                'label' => esc_html__('Use Icon/Image', 'et_builder'),
                'type' => 'select',
                'description' => esc_html__('Choose an Icon you want to use in the tab.', 'et_builder'),
                'option_category' => 'basic_option',
                'options' => array(
                    'none' => esc_html__('None', 'et_builder'),
                    'image'             => esc_html__('Image', 'et_builder'),
                    'icon' => esc_html__('Icon', 'et_builder'),
                ),
                'default' => 'none',
                'toggle_slug' => 'tab_content',
                'affects' => array(
                    'tab_icon',
                    'tab_image'
                ),
            ),
            // 'tab_icon' => array(
            //     'label' => esc_html__('Icon', 'et_builder'),
            //     'type' => 'select_icon',
            //     'option_category' => 'basic_option',
            //     'class' => array('et-pb-font-icon'),
            //     'toggle_slug' => 'tab_content',
            //     'description' => esc_html__('Choose an icon to display in the tab.', 'et_builder'),
            //     'show_if' => array(
            //         'tab_use_icon_or_image' => 'icon',
            //     ),
            // ),
            // 'tab_image'            => array(
            //     'label'             => esc_html__('Image', 'et_builder'),
            //     'type'              => 'upload',
            //     'option_category'   => 'basic_option',
            //     'upload_button_text' => esc_attr__('Upload an image', 'et_builder'),
            //     'choose_text'       => esc_attr__('Choose an Image', 'et_builder'),
            //     'update_text'       => esc_attr__('Set As Image', 'et_builder'),
            //     'description'       => esc_html__('Upload an image to display in the tab.', 'et_builder'),
            //     'toggle_slug'       => 'tab_content',
            //     'dynamic_content'   => 'image',
            //     'mobile_options'    => true,
            //     'hover'             => 'tabs',
            //     'show_if'           => array(
            //         'tab_use_icon_or_image' => 'image'
            //     )
            // ),
            'active_on_load' => array(
                'label' => esc_html__('Active On Load', 'et_builder'),
                'type' => 'yes_no_button',
                'description' => esc_html__('Keep the Tab active on load.', 'et_builder'),
                'option_category' => 'basic_option',
                'options' => array(
                    'off' => esc_html__('No', 'et_builder'),
                    'on' => esc_html__('Yes', 'et_builder'),
                ),
                'default' => 'off',
                'toggle_slug' => 'tab_content',
            ),
        );

        $tab_settings['tabs_image_icon'] = array(
            'label' => esc_html__('Tab Icon/Image', 'et_builder'),
            'type' => 'composite',
            'description' => esc_html__('Use different Icon/Image on tab normal and active mode.','et_builder'),
            'toggle_slug' => 'tab_content',
            'composite_type' => 'default',
            'composite_structure'   => array(
                'normal' => array(
                    'label' => esc_html__("Normal", 'et_builder'),

                    'controls'  => array(
                        'tab_icon' => array(
                            'label' => esc_html__('Icon', 'et_builder'),
                            'type' => 'select_icon',
                            'option_category' => 'basic_option',
                            'class' => array('et-pb-font-icon'),
                            // 'toggle_slug' => 'tab_content',
                            'description' => esc_html__('Choose an icon to display in the tab.', 'et_builder'),
                            'show_if' => array(
                                'tab_use_icon_or_image' => 'icon',
                            ),
                        ),
                        'tab_image'            => array(
                            'label'             => esc_html__('Image', 'et_builder'),
                            'type'              => 'upload',
                            'option_category'   => 'basic_option',
                            'upload_button_text' => esc_attr__('Upload an image', 'et_builder'),
                            'choose_text'       => esc_attr__('Choose an Image', 'et_builder'),
                            'update_text'       => esc_attr__('Set As Image', 'et_builder'),
                            'description'       => esc_html__('Upload an image to display in the tab.', 'et_builder'),
                            // 'toggle_slug'       => 'tab_content',
                            'dynamic_content'   => 'image',
                            'mobile_options'    => true,
                            'hover'             => 'tabs',
                            'show_if'           => array(
                                'tab_use_icon_or_image' => 'image'
                            )
                        ),
                    )
                ),
                'active' => array(
                    'label' => esc_html__("Active", 'et_builder'),
                    'controls'  => array(
                        'use_different_icon_image' => array(
                            'label' => esc_html__('Use Different Icon/Image', 'et_builder'),
                            'type' => 'yes_no_button',
                            'description' => esc_html__('Switch to change the active icon or image in the tab.', 'et_builder'),
                            'option_category' => 'basic_option',
                            'options' => array(
                                'off' => esc_html__('No', 'et_builder'),
                                'on' => esc_html__('Yes', 'et_builder'),
                            ),
                            'default' => 'off',
                        ),
                        'tab_icon_active' => array(
                            'label' => esc_html__('Icon', 'et_builder'),
                            'type' => 'select_icon',
                            'option_category' => 'basic_option',
                            'class' => array('et-pb-font-icon'),
                            // 'toggle_slug' => 'tab_content',
                            'description' => esc_html__('Choose an icon to display in the tab.', 'et_builder'),
                            'show_if' => array(
                                'tab_use_icon_or_image' => 'icon',
                                'use_different_icon_image' => 'on'
                            ),
                        ),
                        'tab_image_active'            => array(
                            'label'             => esc_html__('Image', 'et_builder'),
                            'type'              => 'upload',
                            'option_category'   => 'basic_option',
                            'upload_button_text' => esc_attr__('Upload an image', 'et_builder'),
                            'choose_text'       => esc_attr__('Choose an Image', 'et_builder'),
                            'update_text'       => esc_attr__('Set As Image', 'et_builder'),
                            'description'       => esc_html__('Upload an image to display in the tab.', 'et_builder'),
                            // 'toggle_slug'       => 'tab_content',
                            'dynamic_content'   => 'image',
                            'mobile_options'    => true,
                            'hover'             => 'tabs',
                            'show_if'           => array(
                                'tab_use_icon_or_image' => 'image',
                                'use_different_icon_image' => 'on'
                            )
                        ),
                    )
                ),
            ),
            'show_if_not'   => array(
                'tab_use_icon_or_image' => 'none'
            )
        );

        $warning_msg = esc_html__('The settings below will only work on the tab images.', 'et_builder');
        $tab_icon_settings = array(
            'tab_icon_placement' => array(
                'label' => esc_html__('Tab Icon/Image Placement', 'et_builder'),
                'type' => 'select',
                'description' => esc_html__('Choose where you want to show the Icon/Image in the tab panel.', 'et_builder'),
                'option_category' => 'basic_option',
                'options' => array(
                    'center' => esc_html__('Top', 'et_builder'),
                    'bottom' => esc_html__('Bottom', 'et_builder'),
                    'left' => esc_html__('Left', 'et_builder'),
                    'right' => esc_html__('Right', 'et_builder'),
                ),
                'default' => 'center',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'tab_icon_settings',
                'sub_toggle' => 'normal',
                'mobile_options' => true,
                'responsive' => true,
                'show_if' => array(
                    'tab_use_icon_or_image' => array('icon', 'image'),
                ),
            ),
            'tabs_icon_alignment' => array(
                'label' => esc_html__('Icon/Image Alignment', 'et_builder'),
                'description' => esc_html__('Align image/icon to the left, right or center.', 'et_builder'),
                'type' => 'align',
                'option_category' => 'layout',
                'options' => et_builder_get_text_orientation_options(array('justified')),
                'tab_slug' => 'advanced',
                'toggle_slug' => 'tab_icon_settings',
                'sub_toggle' => 'normal',
                'default' => 'center',
                'mobile_options' => true,
                'responsive' => true,
                'show_if' => array(
                    'tab_use_icon_or_image' => array('icon', 'image')
                    // "tab_icon_placement"   => array('center', 'bottom')
                ),
            ),
            'tabs_icon_width' => array(
                'label' => esc_html__('Tabs Icon/Image Size', 'et_builder'),
                'type' => 'range',
                'description' => esc_html__('Adjust the size of the tab icon/image.','et_builder'),
                // 'default' => '20px',
                'default_unit' => 'px',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'tab_icon_settings',
                'sub_toggle' => 'normal',
                'range_settings' => array(
                    'min' => '1',
                    'max' => '300',
                    'step' => '1',
                ),
                'show_if' => array(
                    'tab_use_icon_or_image' => array('icon', 'image'),
                ),
            ),
            'tab_icon_color' => array(
                'label' => esc_html__('Icon Color', 'et_builder'),
                'type' => 'color-alpha',
                'description' => esc_html__('Select a color fot the tab icon using the pointer or you can use a hex code to get the exact color required for your design.','et_builder'),
                'toggle_slug' => 'tab_icon_settings',
                'sub_toggle' => 'normal',
                'tab_slug' => 'advanced',
                // 'default' => '#000',
                'mobile_options' => true,
                'hover' => 'tabs',
                'depends_show_if' => 'on',
                'show_if' => array(
                    'tab_use_icon_or_image' => 'icon',
                ),
            ),
            'tab_image_setting_warning'=> array(
				'type'       => 'warning',
				'value'      => true,
				'display_if' => true,
				'show_if'          => array(
					'tab_use_icon_or_image' => 'icon',
				),
				'message'    => $warning_msg,
				'toggle_slug' => 'tab_icon_settings',
                'sub_toggle' => 'normal',
                'tab_slug' => 'advanced',
			),
            'tab_image_active_setting_warning'=> array(
				'type'       => 'warning',
				'value'      => true,
				'display_if' => true,
				'show_if'          => array(
					'tab_use_icon_or_image' => 'icon',
				),
				'message'    => $warning_msg,
				'toggle_slug' => 'tab_icon_settings',
                'sub_toggle' => 'active',
                'tab_slug' => 'advanced',
			),
        );

        $body_settings = array(
            'use_divi_library' => array(
                'label' => esc_html__('Use Library Layouts', 'et_builder'),
                'type' => 'yes_no_button',
                'description' => esc_html__('Switch to use the divi library layouts.', 'et_builder'),
                'option_category' => 'basic_option',
                'options' => array(
                    'off' => esc_html__('No', 'et_builder'),
                    'on' => esc_html__('Yes', 'et_builder'),
                ),
                'computed_affects' => array(
                    '__libraryLayouts',
                ),
                'default' => 'off',
                'toggle_slug' => 'body_content',
                'affects' => array(
                    'body_title',
                    'body_description',
                    'body_use_image_or_icon',
                ),
            ),
            'divi_library' => array(
                'label' => esc_html__('Divi Library', 'et_builder'),
                'description' => esc_html__('Select a divi layout. This field won\'t change on the builder. But will show on the frontend.', 'et_builder'),
                'options' => Common::get_divi_library_options(),
                'type' => 'select',
                'computed_affects' => array(
                    '__libraryLayouts',
                ),
                'toggle_slug' => 'body_content',
                'show_if' => array(
                    'use_divi_library' => 'on',
                ),
            ),
            'body_title' => array(
                'label' => esc_html__('Title', 'et_builder'),
                'type' => 'text',
                'option_category' => 'basic_option',
                'description' => esc_html__('Input the title of the tab body', 'et_builder'),
                'toggle_slug' => 'body_content',
                'dynamic_content' => 'text',
                'mobile_options' => true,
                'hover' => 'tabs',
                'show_if' => array(
                    'use_divi_library' => 'off',
                ),
            ),
            'body_description' => array(
                'label' => esc_html__('Description', 'et_builder'),
                'type' => 'tiny_mce',
                'option_category' => 'basic_option',
                'description' => esc_html__('Input the description of the tab body.', 'et_builder'),
                'toggle_slug' => 'body_content',
                'dynamic_content' => 'text',
                'mobile_options' => true,
                'hover' => 'tabs',
                'show_if' => array(
                    'use_divi_library' => 'off',
                ),
            ),
            'body_use_image_or_icon' => array(
                'label' => esc_html__('Use Image/Icon', 'et_builder'),
                'type' => 'select',
                'description' => esc_html__('Choose Image or Icon you want to use in the tab body.', 'et_builder'),
                'option_category' => 'basic_option',
                'options' => array(
                    'none' => esc_html__('None', 'et_builder'),
                    'image' => esc_html__('Image', 'et_builder'),
                    'icon' => esc_html__('Icon', 'et_builder'),
                ),
                'default' => 'none',
                'toggle_slug' => 'body_content',
                'affects' => array(
                    'body_icon',
                    'body_image',
                ),
                'show_if' => array(
                    'use_divi_library' => 'off',
                ),
            ),
            'body_icon' => array(
                'label' => esc_html__('Icon', 'et_builder'),
                'type' => 'select_icon',
                'option_category' => 'basic_option',
                'class' => array('et-pb-font-icon'),
                'toggle_slug' => 'body_content',
                'description' => esc_html__('Choose an icon to display in the tab.', 'et_builder'),
                'default' => '#',
                'mobile_options' => true,
                'hover' => 'tabs',
                'show_if' => array(
                    'body_use_image_or_icon' => 'icon',
                ),
            ),
            'body_image' => array(
                'label' => esc_html__('Image', 'et_builder'),
                'type' => 'upload',
                'option_category' => 'basic_option',
                'upload_button_text' => esc_attr__('Upload an image', 'et_builder'),
                'choose_text' => esc_attr__('Choose an Image', 'et_builder'),
                'update_text' => esc_attr__('Set As Image', 'et_builder'),
                'description' => esc_html__('Upload an image to display at the top of your team person.', 'et_builder'),
                'toggle_slug' => 'body_content',
                'dynamic_content' => 'image',
                'mobile_options' => true,
                'hover' => 'tabs',
                'show_if' => array(
                    'body_use_image_or_icon' => 'image',
                ),
            ),
            'button_text' => array(
                'label' => esc_html__('Button Text', 'et_builder'),
                'type' => 'text',
                'option_category' => 'basic_option',
                'description' => esc_html__('Input button text', 'et_builder'),
                'toggle_slug' => 'body_content',
                'dynamic_content' => 'text',
                'default' => '',
                'mobile_options' => true,
                'hover' => 'tabs',
                'show_if' => array(
                    'use_divi_library' => 'off',
                ),
            ),
            'button_link' => array(
                'label' => esc_html__('Button Link', 'et_builder'),
                'type' => 'text',
                'option_category' => 'basic_option',
                'default' => '#',
                'description' => esc_html__('When clicked the module will link to this URL.', 'et_builder'),
                'toggle_slug' => 'body_content',
                'show_if' => array(
                    'use_divi_library' => 'off',
                ),
            ),
            'button_target' => array(
                'label' => esc_html__('Button Link Target', 'et_builder'),
                'type' => 'select',
                'description' => esc_html__('Select the link target', 'et_builder'),
                'option_category' => 'basic_option',
                'toggle_slug' => 'body_content',
                'options' => array(
                    '_self' => esc_html__('In The Same Window', 'et_builder'),
                    '_blank' => esc_html__('In The New Tab', 'et_builder'),

                ),
                'default' => '_self',
                'show_if' => array(
                    'use_divi_library' => 'off',
                ),
            ),
            '__libraryLayouts' => array(
                'type' => 'computed',
                'computed_callback' => array('NextAdvancedTabItem', 'get_library_content'),
                'computed_depends_on' => array(
                    'use_divi_library',
                    'divi_library',
                ),
            ),
        );

        $body_icon_settings = array(
            'body_icon_alignment' => array(
                'label' => esc_html__('Icon Alignment', 'et_builder'),
                'description' => esc_html__('Align image/icon to the left, right or center.', 'et_builder'),
                'type' => 'align',
                'option_category' => 'layout',
                'options' => et_builder_get_text_orientation_options(array('justified')),
                'tab_slug' => 'advanced',
                'toggle_slug' => 'body_icon_settings',
                'default' => 'center',
                'mobile_options' => true,
                'responsive' => true,
                'show_if' => array(
                    'body_use_image_or_icon' => 'icon',
                ),
            ),
            'body_icon_size' => array(
                'label' => esc_html__('Tabs Icon Size', 'et_builder'),
                'type' => 'range',
                // 'default' => '20px',
                'default_unit' => 'px',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'body_icon_settings',
                'range_settings' => array(
                    'min' => '1',
                    'max' => '300',
                    'step' => '1',
                ),
                'show_if' => array(
                    'body_use_image_or_icon' => 'icon',
                ),
            ),
            'body_icon_color' => array(
                'label' => esc_html__('Icon Color', 'et_builder'),
                'type' => 'color-alpha',
                'toggle_slug' => 'body_icon_settings',
                'tab_slug' => 'advanced',
                'mobile_options' => true,
                'depends_show_if' => 'on',
                'show_if' => array(
                    'body_use_image_or_icon' => 'icon',
                ),
            ),
        );

        $image_settings = array(
            'body_image_width' => array(
                'label' => esc_html__('Image Width', 'et_builder'),
                'type' => 'range',
                'default' => '50%',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm'),
                'default_unit' => '%',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'image_settings',
                'mobile_options' => true,
                'responsive' => true,
                'range_settings' => array(
                    'min' => '1',
                    'max' => '100',
                    'step' => '1',
                ),
                'show_if' => array(
                    'body_use_image_or_icon' => 'image',
                ),
            ),
            'body_image_max_width' => array(
                'label' => esc_html__('Image Max Width', 'et_builder'),
                'type' => 'range',
                'default' => '100%',
                'default_unit' => '%',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'image_settings',
                'mobile_options' => true,
                'responsive' => true,
                'range_settings' => array(
                    'min' => '1',
                    'max' => '100',
                    'step' => '1',
                ),
                'show_if' => array(
                    'body_use_image_or_icon' => 'image',
                ),
            ),
            'body_image_placement' => array(
                'label' => esc_html__('Image Placement', 'et_builder'),
                'type' => 'select',
                'description' => esc_html__('Choose where you want to show the Icon in the tab panel.', 'et_builder'),
                'option_category' => 'basic_option',
                'options' => array(
                    'center' => esc_html__('Top', 'et_builder'),
                    'bottom' => esc_html__('Bottom', 'et_builder'),
                    'left' => esc_html__('Left', 'et_builder'),
                    'right' => esc_html__('Right', 'et_builder'),
                ),
                'default' => 'center',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'image_settings',
                'mobile_options' => true,
                'responsive' => true,
                'show_if' => array(
                    'body_use_image_or_icon' => 'image',
                ),
            ),
            'body_image_alignment' => array(
                'label' => esc_html__('Image Alignment', 'et_builder'),
                'description' => esc_html__('Align image/icon to the left, right or center.', 'et_builder'),
                'type' => 'align',
                'option_category' => 'layout',
                'options' => et_builder_get_text_orientation_options(array('justified')),
                'tab_slug' => 'advanced',
                'toggle_slug' => 'image_settings',
                'default' => 'center',
                'mobile_options' => true,
                'responsive' => true,
                'show_if' => array(
                    'body_use_image_or_icon' => 'image',
                ),
            ),
        );

        $tab_margin_padding = array(
            'tab_item_margin' => array(
                'label' => esc_html__('Tab Item Margin', 'et_builder'),
                'type' => 'custom_margin',
                'description' => esc_html__('Adjust the outer space/margin of the tab item element.','et_builder'),
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'tab_spacing',
            ),
            'tab_item_padding' => array(
                'label' => esc_html__('Tab Item Padding', 'et_builder'),
                'type' => 'custom_padding',
                'description' => esc_html__('Adjust the inner space/padding of the tab item element.','et_builder'),
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'tab_spacing',
            ),
            'tab_title_margin' => array(
                'label' => esc_html__('Tab Title Margin', 'et_builder'),
                'type' => 'custom_margin',
                'description' => esc_html__('Adjust the outer space of the tab title element.','et_builder'),
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'tab_spacing',
            ),
            'tab_title_padding' => array(
                'label' => esc_html__('Tab Title Padding', 'et_builder'),
                'type' => 'custom_padding',
                'description' => esc_html__('Adjust the inner space of the tab title element.','et_builder'),
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'tab_spacing',
            ),
            'tab_subtitle_margin' => array(
                'label' => esc_html__('Tab Subtitle Margin', 'et_builder'),
                'type' => 'custom_margin',
                'description' => esc_html__('Adjust the outer space of the tab subtitle element.','et_builder'),
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'tab_spacing',
            ),
            'tab_subtitle_padding' => array(
                'label' => esc_html__('Tab Subtitle Padding', 'et_builder'),
                'type' => 'custom_padding',
                'description' => esc_html__('Adjust the inner space of the tab subtitle element.','et_builder'),
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'tab_spacing',
            ),
            'tab_icon_margin' => array(
                'label' => esc_html__('Tab Icon/Image Margin', 'et_builder'),
                'type' => 'custom_margin',
                'description' => esc_html__('Adjust the outer space of the tab icon/image element.','et_builder'),
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'tab_spacing',
            ),
            'tab_icon_padding' => array(
                'label' => esc_html__('Tab Icon/Image Padding', 'et_builder'),
                'type' => 'custom_padding',
                'description' => esc_html__('Adjust the inner space of the tab icon/image element.','et_builder'),
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'tab_spacing',
            ),
            'tab_icon_active_margin' => array(
                'label' => esc_html__('Active Tab Icon/Image Margin', 'et_builder'),
                'type' => 'custom_margin',
                'description' => esc_html__('Adjust the outer space of the active tab icon/image element.','et_builder'),
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'tab_spacing',
            ),
            'tab_icon_active_padding' => array(
                'label' => esc_html__('Active Tab Icon/Image Padding', 'et_builder'),
                'type' => 'custom_padding',
                'description' => esc_html__('Adjust the inner space of the active tab icon/image element.','et_builder'),
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'tab_spacing',
            ),
        );

        $body_margin_padding = array(
            'body_item_margin' => array(
                'label' => esc_html__('Body Item Margin', 'et_builder'),
                'type' => 'custom_margin',
                'description' => esc_html__('Adjust the outer space of the body item element.','et_builder'),
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'body_spacing',
                'show_if' => array(
                    'use_divi_library' => 'off',
                ),
            ),
            'body_item_padding' => array(
                'label' => esc_html__('Body Item Padding', 'et_builder'),
                'type' => 'custom_padding',
                'description' => esc_html__('Adjust the inner space of the body item element.','et_builder'),
                'mobile_options' => true,
                'hover' => 'tabs',
                
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'body_spacing',
                'show_if' => array(
                    'use_divi_library' => 'off',
                ),
            ),
            'body_title_margin' => array(
                'label' => esc_html__('Body Title Margin', 'et_builder'),
                'type' => 'custom_margin',
                'description' => esc_html__('Adjust the outer space of the body title element.','et_builder'),'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'body_spacing',
                'show_if' => array(
                    'use_divi_library' => 'off',
                ),
            ),
            'body_title_padding' => array(
                'label' => esc_html__('Body Title Padding', 'et_builder'),
                'type' => 'custom_padding',
                'description' => esc_html__('Adjust the inner space of the body title element.','et_builder'),
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'body_spacing',
                'show_if' => array(
                    'use_divi_library' => 'off',
                ),
            ),
            'body_description_margin' => array(
                'label' => esc_html__('Body Description Margin', 'et_builder'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'hover' => 'tabs',
                'default' => '0|0|20px|0',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'body_spacing',
                'show_if' => array(
                    'use_divi_library' => 'off',
                ),
            ),
            'body_description_padding' => array(
                'label' => esc_html__('Body Description Padding', 'et_builder'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'body_spacing',
                'show_if' => array(
                    'use_divi_library' => 'off',
                ),
            ),
            'body_image_padding' => array(
                'label' => esc_html__('Body Image Padding', 'et_builder'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'body_spacing',
                'show_if' => array(
                    'use_divi_library' => 'off',
                    'body_use_image_or_icon' => 'image',
                ),
            ),
            'body_icon_margin' => array(
                'label' => esc_html__('Body Icon Margin', 'et_builder'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'body_spacing',
                'show_if' => array(
                    'use_divi_library' => 'off',
                    'body_use_image_or_icon' => 'icon',
                ),
            ),
            'body_icon_padding' => array(
                'label' => esc_html__('Body Icon Padding', 'et_builder'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'body_spacing',
                'show_if' => array(
                    'use_divi_library' => 'off',
                    'body_use_image_or_icon' => 'icon',
                ),
            ),
        );

        $background_opt = array(
            'hover' => 'tabs',
            'description' => esc_html__('Add a background fill color or gradient for the area.', 'et_builder'),
        );

        $tab_bg = Common::background_fields($this, "tab_", "Background Color", "tab_bg", "general", $background_opt);
        $content_bg = Common::background_fields($this, "content_", "Background Color", "content_bg", "general", $background_opt);

        return array_merge($admin_label, $tab_settings, $tab_icon_settings, $body_settings, $body_icon_settings, $image_settings, $tab_margin_padding, $body_margin_padding, $tab_bg, $content_bg);
    }

    public static function get_library_content($args = array())
    {
        $defaults = array();
        $args = wp_parse_args($args, $defaults);

        if (empty($args['divi_library'])) {
            return;
        }

        ob_start();

        ET_Builder_Element::clean_internal_modules_styles();

        echo do_shortcode(
            sprintf(
                '[et_pb_section global_module="%1$s" template_type="section" fullwidth="on"][/et_pb_section]',
                $args['divi_library']
            )
        );

        $internal_style = ET_Builder_Element::get_style();
        ET_Builder_Element::clean_internal_modules_styles(false);

        if ($internal_style) {
            $modules_style = sprintf(
                '<style id="dnxte_advanced_tab_styles-%2$s" type="text/css" class="dnxte_advanced_tab_styles-%2$s">
					%1$s
				</style>',
                $internal_style,
                $args['divi_library']
            );
        }

        if (function_exists('et_core_is_fb_enabled') && et_core_is_fb_enabled()) {
            echo et_core_esc_previously($modules_style);
        }

        $render_shortcode = ob_get_clean();

        return $render_shortcode;
    }

    protected function render_content($render_slug)
    {
        $module_order_class = self::get_module_order_class($render_slug);
        $content_type = $this->props['use_divi_library'];
        $divi_library = $this->props['divi_library'];
        $custom_content = $this->render_custom_content($render_slug);
        $args = array('divi_library' => $divi_library);

        return 'on' === $content_type ? sprintf('<div class="dnxte_tab_content dnxte_tab_content_layout" data-id="%2$s">%1$s</div>', $this->get_library_content($args), $module_order_class) : $custom_content;
    }

    private function render_tab_icon($multi_view, $render_slug)
    {
        $image_or_icon = "";
        if ('icon' === $this->props['tab_use_icon_or_image'] && '' !== $this->props['tab_icon']) {
            $icon_css_property = array(
                'selector' => '%%order_class%% .dnxte_tab_a span.dnxte_tab_nav_icon',
                'class' => 'dnxte_tab_nav_icon',
            );
            $image_or_icon = Common::get_icon_html('tab_icon', $this, $render_slug, $multi_view, $icon_css_property, 'span');
        }elseif('image' === $this->props['tab_use_icon_or_image'] && '' !== $this->props['tab_image']) {
            $image_or_icon .= '<div class="dnxte_tab_nav_image">';
            if ($multi_view->has_value('tab_image')) {
                $image_or_icon .= $multi_view->render_element(array(
                    'tag' => 'img',
                    'attrs' => array(
                        'src' => '{{tab_image}}',
                        'alt' => '',
                    ),
                ));
            }
            $image_or_icon .= '</div>';
        }
        return $image_or_icon;
    }
    private function render_active_tab_icon($multi_view, $render_slug)
    {
        $image_or_icon = "";
        if ('icon' === $this->props['tab_use_icon_or_image']) {
            $slug = ('on' == $this->props['use_different_icon_image'] && '' != $this->props['tab_icon_active']) ? 'tab_icon_active' : 'tab_icon';
            $icon_css_property = array(
                'selector' => '%%order_class%% .dnxte_tab_a span.dnxte_tab_nav_icon_active',
                'class' => 'dnxte_tab_nav_icon_active',
            );
            $image_or_icon = Common::get_icon_html($slug, $this, $render_slug, $multi_view, $icon_css_property, 'span');
        }elseif('image' === $this->props['tab_use_icon_or_image']) {
            $slug = ('on' == $this->props['use_different_icon_image'] && '' != $this->props['tab_image_active']) ? 'tab_image_active' : 'tab_image';
            $image_or_icon .= '<div class="dnxte_tab_nav_image_active">';

            if ($multi_view->has_value($slug)) {
                $image_or_icon .= $multi_view->render_element(array(
                    'tag' => 'img',
                    'attrs' => array(
                        'src' => '{{' . $slug. '}}',
                        'alt' => '',
                    ),
                ));
            }
            $image_or_icon .= '</div>';
        }
        return $image_or_icon;
    }


    public function render_tab($render_slug)
    {
        global $dnxte_ad_tabs;
        $multi_view = et_pb_multi_view_options($this);
        $module_order_class = self::get_module_order_class($render_slug);
        $dnxte_ad_tabs[$module_order_class]['title'] = isset($this->props['tab_title']) ? $this->props['tab_title'] : '';
        $dnxte_ad_tabs[$module_order_class]['subtitle'] = isset($this->props['tab_subtitle']) ? $this->props['tab_subtitle'] : '';
        $dnxte_ad_tabs[$module_order_class]['use_icon'] = isset($this->props['tab_use_icon']) ? $this->props['tab_use_icon'] : '';
        $dnxte_ad_tabs[$module_order_class]['icon'] = isset($this->props['tab_icon']) ? $this->props['tab_icon'] : '';
        $dnxte_ad_tabs[$module_order_class]['icon_html'] = $this->render_tab_icon($multi_view, $render_slug);
        $dnxte_ad_tabs[$module_order_class]['active_icon_html'] = $this->render_active_tab_icon($multi_view, $render_slug);
        $dnxte_ad_tabs[$module_order_class]['active_on_load'] = isset($this->props['active_on_load']) ? $this->props['active_on_load'] : 'off';

        return;
    }

    private function render_body_image_icon($multi_view, $render_slug)
    {
        $image_or_icon = "";
        if ('image' === $this->props['body_use_image_or_icon'] && $this->props['body_image'] !== "") {
            $image_or_icon .= '<div class="dnxte_tab_content_slidebar_one">';
            if ($multi_view->has_value('body_image')) {
                $image_or_icon .= $multi_view->render_element(array(
                    'tag' => 'img',
                    'attrs' => array(
                        'src' => '{{body_image}}',
                        'alt' => '{{body_title}}',
                    ),
                ));
            }
            $image_or_icon .= '</div>';
        } elseif ('icon' === $this->props['body_use_image_or_icon'] && $this->props['body_icon'] !== "") {
            $icon_css_property = array(
                'selector' => '%%order_class%% .dnxte_tab_content_slidebar_one span.dnxte_tab_content_icon',
                'class' => 'dnxte_tab_content_icon',
            );
            $image_or_icon .= '<div class="dnxte_tab_content_slidebar_one dnxte_tab_content_icon_wrapper">';
            $image_or_icon .= Common::get_icon_html('body_icon', $this, $render_slug, $multi_view, $icon_css_property, 'span');
            $image_or_icon .= '</div>';
        }
        return $image_or_icon;
    }

    public function render_button_html($render_slug, $multi_view)
    {
        $button_target = $this->props['button_target'];
        $button_link = $this->props['button_link'];

        $button_alignment_classes = Common::get_alignment("button_alignment", $this, "dnxte_body");

        $icon_css_property = array(
            'selector' => '%%order_class%% .dnxte_tab_content_button_wrap .dnxte_tab_content_btn span',
            'class' => '',
        );
        $rightItag = '';
        $lefItag = '';

        if ('right' === $this->props['button_icon_placement']) {
            $rightItag = Common::get_icon_html('button_icon', $this, $render_slug, $multi_view, $icon_css_property, 'span');
        } else if ('left' === $this->props['button_icon_placement']) {
            $lefItag = Common::get_icon_html('button_icon', $this, $render_slug, $multi_view, $icon_css_property, 'span');
        }

        $button_html = "";
        if ('' !== $this->props['button_text']) {
            $button_html = $multi_view->render_element(array(
                'tag' => 'a',
                'content' => $lefItag . '{{button_text}}' . $rightItag,
                'attrs' => array(
                    'href' => $button_link,
                    'target' => $button_target,
                    'class' => 'et_pb_button dnxte_tab_content_btn',
                ),
            ));

            return sprintf('<div class="dnxte_tab_content_button_wrap %2$s">%1$s</div>', $button_html, $button_alignment_classes);
        }
        return '';
    }

    private function render_custom_content($render_slug)
    {
        $multi_view = et_pb_multi_view_options($this);
        $module_order_class = self::get_module_order_class($render_slug);

        $image_or_icon = $this->render_body_image_icon($multi_view, $render_slug);

        $body_heading = "";
        if ($multi_view->has_value('body_title')) {
            $body_heading = $multi_view->render_element(array(
                'tag' => 'div',
                'content' => '{{body_title}}',
                'attrs' => array(
                    'class' => 'dnxte_tab_content_title',
                ),
            ));
        }

        $body_description = "";
        if ($multi_view->has_value('body_description')) {
            $body_description = $multi_view->render_element(array(
                'tag' => 'div',
                'content' => '{{body_description}}',
                'attrs' => array(
                    'class' => 'dnxte_tab_content_pra',
                ),
            ));
        }

        // $button_alignment_classes = Common::get_alignment("coverflowslider_button_alignment", $this);
        $body_button = $this->render_button_html($render_slug, $multi_view);

        $body_content = ('' != $body_heading || '' != $body_description || '' != $body_button) ? sprintf('<div class="dnxte_tab_content_slidebar_two">
                            %1$s
                            %2$s
                            %3$s
                        </div>',
            $body_heading,
            $body_description,
            $body_button) : '';

        return sprintf('<div class="dnxte_tab_content" data-id="%3$s">
                %1$s
                %2$s
            </div>',
            $image_or_icon,
            $body_content,
            $module_order_class
        );
    }

    public function render($attrs, $content, $render_slug)
    {
        $icon_placement_selector = '%%order_class%% .dnxte_tab_a';
        $icon_alignment_selector = '%%order_class%% .dnxte_tab_a span.dnxte_tab_nav_icon,%%order_class%% .dnxte_tab_a .dnxte_tab_nav_image,%%order_class%% .dnxte_tab_a span.dnxte_tab_nav_icon_active,%%order_class%% .dnxte_tab_a .dnxte_tab_nav_image_active';
        $body_icon_alignment_selector = '%%order_class%% .dnxte_tab_content_slidebar_one.dnxte_tab_content_icon_wrapper';
        $body_image_placement_selector = '%%order_class%% .dnxte_tab_content';
        $body_image_alignment_selector = '%%order_class%% .dnxte_tab_content .dnxte_tab_content_slidebar_one';

        $this->render_tab($render_slug);
        $this->apply_background_css($render_slug);
        $this->apply_css($render_slug);
        $this->apply_spacing_css($render_slug);
        $this->apply_tab_icon_placement_css('tab_icon_placement', $icon_placement_selector, $render_slug);
        $this->apply_placement_css('body_image_placement', $body_image_placement_selector, $render_slug);
        $this->apply_alignment_css('tabs_icon_alignment', $icon_alignment_selector, $render_slug);
        $this->apply_alignment_css('body_image_alignment', $body_image_alignment_selector, $render_slug);
        $this->apply_body_icon_alignment_css('body_icon_alignment', $body_icon_alignment_selector, $render_slug);

        return $this->render_content($render_slug);
    }
    protected function item_justify_content($placement)
    {
        if ('right' == $placement) {
            return 'flex-start';
        }

        return 'left' == $placement ? 'initial' : 'space-between';
    }
    protected function icon_justify_content($placement)
    {
        return in_array($placement, array('bottom', 'right')) ? 'flex-end' : 'initial';
    }
    protected function apply_alignment_css($slug, $selector, $render_slug)
    {
        $value = '' !== $this->props[$slug] ? $this->props[$slug] : 'center';
        $responsive_values = et_pb_responsive_options()->get_property_values($this->props, $slug);

        $value_tablet = (isset($responsive_values['tablet']) && '' !== $this->props[$slug . '_tablet']) ? $this->props[$slug . '_tablet'] : 'center';
        $value_phone = (isset($responsive_values['phone']) && '' !== $this->props[$slug . '_phone']) ? $this->props[$slug . '_phone'] : 'center';

        $icon_alignment = array(
            'left' => 'flex-start',
            'center' => 'center',
            'right' => 'flex-end',
        );

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $selector,
            'declaration' => sprintf('align-self: %1$s;', $icon_alignment[$value]),
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $selector,
            'declaration' => sprintf('align-self: %1$s;', $icon_alignment[$value_tablet]),
            'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $selector,
            'declaration' => sprintf('align-self: %1$s;', $icon_alignment[$value_phone]),
            'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
        ));
    }
    protected function apply_body_icon_alignment_css($slug, $selector, $render_slug)
    {
        $value = '' !== $this->props[$slug] ? $this->props[$slug] : 'center';
        $value_tablet = '' !== $this->props[$slug . '_tablet'] ? $this->props[$slug . '_tablet'] : 'center';
        $value_phone = '' !== $this->props[$slug . '_phone'] ? $this->props[$slug . '_phone'] : 'center';

        $icon_alignment = array(
            'left' => 'flex-start',
            'center' => 'center',
            'right' => 'flex-end',
        );

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $selector,
            'declaration' => sprintf('justify-content: %1$s;width:100%%;', $icon_alignment[$value]),
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $selector,
            'declaration' => sprintf('justify-content: %1$s;width:100%%;', $icon_alignment[$value_tablet]),
            'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $selector,
            'declaration' => sprintf('justify-content: %1$s;width:100%%;', $icon_alignment[$value_phone]),
            'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
        ));
    }
    protected function apply_tab_icon_placement_css($slug, $selector, $render_slug)
    {
        $value = '' !== $this->props[$slug] ? $this->props[$slug] : 'center';
        $value_tablet = '' !== $this->props[$slug . '_tablet'] ? $this->props[$slug . '_tablet'] : 'center';
        $value_phone = '' !== $this->props[$slug . '_phone'] ? $this->props[$slug . '_phone'] : 'center';

        $flex_direction_arr = array(
            'center' => 'column',
            'bottom' => 'column-reverse',
            'left' => 'row',
            'right' => 'row-reverse',
        );

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $selector,
            'declaration' => sprintf('flex-direction: %1$s;justify-content: %2$s;', $flex_direction_arr[$value], $this->icon_justify_content($value)),
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $selector,
            'declaration' => sprintf('flex-direction: %1$s;justify-content: %2$s;', $flex_direction_arr[$value_tablet], $this->icon_justify_content($value_tablet)),
            'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $selector,
            'declaration' => sprintf('flex-direction: %1$s;justify-content: %2$s;', $flex_direction_arr[$value_phone], $this->icon_justify_content($value_phone)),
            'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
        ));
    }
    protected function apply_placement_css($slug, $selector, $render_slug)
    {
        $value = '' !== $this->props[$slug] ? $this->props[$slug] : 'center';
        $value_tablet = '' !== $this->props[$slug . '_tablet'] ? $this->props[$slug . '_tablet'] : 'center';
        $value_phone = '' !== $this->props[$slug . '_phone'] ? $this->props[$slug . '_phone'] : 'center';

        $flex_direction_arr = array(
            'center' => 'column',
            'bottom' => 'column-reverse',
            'left' => 'row',
            'right' => 'row-reverse',
        );

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $selector,
            'declaration' => sprintf('flex-direction: %1$s;justify-content: %2$s;', $flex_direction_arr[$value], $this->item_justify_content($value)),
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $selector,
            'declaration' => sprintf('flex-direction: %1$s;justify-content: %2$s;', $flex_direction_arr[$value_tablet], $this->item_justify_content($value_tablet)),
            'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $selector,
            'declaration' => sprintf('flex-direction: %1$s;justify-content: %2$s;', $flex_direction_arr[$value_phone], $this->item_justify_content($value_phone)),
            'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
        ));
    }
    public function multi_view_filter_value($raw_value, $args, $multi_view)
    {
        $name = isset($args['name']) ? $args['name'] : '';
        $mode = isset($args['mode']) ? $args['mode'] : '';

        if ($raw_value && in_array($name, array('tab_icon','tab_icon_active', 'body_icon', 'button_icon'))) {
            return et_pb_get_extended_font_icon_value($raw_value, true);
        }
        return $raw_value;
    }
    protected function apply_css($render_slug)
    {
        $css_settings = array(
            'tabs_icon_width' => array(
                'css' => 'icon' == $this->props['tab_use_icon_or_image'] ? 'font-size: %1$s !important;' : 'width: %1$s!important;',
                'selector' => array(
                    'desktop' => '%%order_class%% span.dnxte_tab_nav_icon,%%order_class%% .dnxte_tab_nav_image img,%%order_class%% span.dnxte_tab_nav_icon_active,%%order_class%% .dnxte_tab_nav_image_active img',
                ),
            ),
            'tab_icon_color' => array(
                'css' => 'color: %1$s !important;',
                'selector' => array(
                    'desktop' => '%%order_class%% span.dnxte_tab_nav_icon',
                    'hover' => '%%order_class%%:hover span.dnxte_tab_nav_icon',
                ),
            ),
            'body_icon_color' => array(
                'css' => 'color: %1$s !important;',
                'selector' => array(
                    'desktop' => '%%order_class%% .dnxte_tab_content_slidebar_one .dnxte_tab_content_icon',
                ),
            ),
            'button_icon_color' => array(
                'css' => 'color: %1$s;',
                'selector' => array(
                    'desktop' => '%%order_class%% .dnxte_tab_content .dnxte_tab_content_btn span',
                ),
            ),
            'body_icon_size' => array(
                'css' => 'font-size: %1$s !important;',
                'selector' => array(
                    'desktop' => '%%order_class%% .dnxte_tab_content_slidebar_one .dnxte_tab_content_icon',
                ),
            ),
            'body_image_width' => array(
                'css' => 'width: %1$s;flex:0 0 %1$s;',
                'selector' => array(
                    'desktop' => '%%order_class%% .dnxte_tab_content_slidebar_one',
                ),
            ),
            'body_image_max_width' => array(
                'css' => 'max-width: %1$s;',
                'selector' => array(
                    'desktop' => '%%order_class%% .dnxte_tab_content_slidebar_one',
                ),
            ),
        );

        foreach ($css_settings as $key => $value) {
            Common::set_css($key, $value['css'], $value['selector'], $render_slug, $this);
        }

        // when body image placement is set to top or bottom then ...
        $body_image_placement_arr = array('center', 'bottom');
        $bd_img_plce_sl = 'body_image_placement';

        $responsive_values = et_pb_responsive_options()->get_property_values($this->props, $bd_img_plce_sl);
        $body_image_placement = $this->props[$bd_img_plce_sl];
        $body_image_placement_tablet = (isset($responsive_values['tablet']) && '' !== $this->props[$bd_img_plce_sl . '_tablet']) ? $this->props[$bd_img_plce_sl . '_tablet'] : '';
        $body_image_placement_phone = (isset($responsive_values['phone']) && '' !== $this->props[$bd_img_plce_sl . '_phone']) ? $this->props[$bd_img_plce_sl . '_phone'] : '';

        $body_image_width_css = 'display: flex; justify-content:center;';

        if (in_array($body_image_placement, $body_image_placement_arr)) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte_tab_content_slidebar_one",
                'declaration' => $body_image_width_css,
            ));
        }
        if (in_array($body_image_placement_tablet, $body_image_placement_arr)) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte_tab_content_slidebar_one",
                'declaration' => $body_image_width_css,
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));
        }
        if (in_array($body_image_placement_phone, $body_image_placement_arr)) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte_tab_content_slidebar_one",
                'declaration' => $body_image_width_css,
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));
        }
        // end

        // button icon on hover
        if ('on' === $this->props['button_on_hover']) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte_tab_content_btn span",
                'declaration' => 'opacity: 0;visibility: hidden;',
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte_tab_content_btn:hover span",
                'declaration' => 'opacity: 1 !important;visibility: visible !important;',
            ));
        }
        if (isset($this->props['button_on_hover_tablet']) && 'on' === $this->props['button_on_hover_tablet']) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte_tab_content_btn span",
                'declaration' => 'opacity: 0;visibility: hidden;',
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte_tab_content_btn:hover span",
                'declaration' => 'opacity: 1 !important;visibility: visible !important;',
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));
        }
        if (isset($this->props['button_on_hover_phone']) && 'on' === $this->props['button_on_hover_phone']) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte_tab_content_btn span",
                'declaration' => 'opacity: 0;visibility: hidden;',
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte_tab_content_btn:hover span",
                'declaration' => 'opacity: 1 !important;visibility: visible !important;',
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));
        }
        // Image filter
        // Image filter variables
        $child_hue_rotate = esc_attr__($this->props['child_filter_hue_rotate'], 'et_builder');
        $child_saturate = esc_attr__($this->props['child_filter_saturate'], 'et_builder');
        $child_brightness = esc_attr__($this->props['child_filter_brightness'], 'et_builder');
        $child_contrast = esc_attr__($this->props['child_filter_contrast'], 'et_builder');
        $child_invert = esc_attr__($this->props['child_filter_invert'], 'et_builder');
        $child_sepia = esc_attr__($this->props['child_filter_sepia'], 'et_builder');
        $child_opacity = esc_attr__($this->props['child_filter_opacity'], 'et_builder');
        $child_blur = esc_attr__($this->props['child_filter_blur'], 'et_builder');
        $child_mix_blend_mode = esc_attr__($this->props['child_mix_blend_mode'], 'et_builder');

        $image_filter_style = sprintf('filter: hue-rotate(%1$s) saturate(%2$s) brightness(%3$s) contrast(%4$s) invert(%5$s) sepia(%6$s) opacity(%7$s) blur(%8$s);mix-blend-mode: %9$s;', $child_hue_rotate, $child_saturate, $child_brightness, $child_contrast, $child_invert, $child_sepia, $child_opacity, $child_blur, $child_mix_blend_mode);

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .dnxte_tab_content_slidebar_one img",
            'declaration' => $image_filter_style,
        ));
        // Image filter end

        // remove image right margin when, image placement is top or bottom
        $body_image_placement = isset($this->props['body_image_placement']) ? $this->props['body_image_placement'] : '';
        $body_image_placement_tablet = isset($this->props['body_image_placement_tablet']) ? $this->props['body_image_placement_tablet'] : '';
        $body_image_placement_phone = isset($this->props['body_image_placement_phone']) ? $this->props['body_image_placement_phone'] : '';

        if (in_array($body_image_placement, array('center', 'bottom'))) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte_tab_content_slidebar_one",
                'declaration' => 'margin-right: 0;',
            ));
        }
        if (in_array($body_image_placement_tablet, array('center', 'bottom'))) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte_tab_content_slidebar_one",
                'declaration' => 'margin-right: 0;',
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));
        }
        if (in_array($body_image_placement_phone, array('center', 'bottom'))) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte_tab_content_slidebar_one",
                'declaration' => 'margin-right: 0;',
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));
        }

    }
    public function apply_background_css($render_slug)
    {
        $gradient_opt = array(
            'tab_' => array(
                "desktop" => "%%order_class%% .dnxte_tab_a",
                "hover" => "%%order_class%% .dnxte_tab_a:hover",
            ),
            'content_' => array(
                "desktop" => "%%order_class%% .et_pb_module_inner .dnxte_tab_content",
                "hover" => "%%order_class%% .et_pb_module_inner .dnxte_tab_content:hover",
            ),
        );

        Common::apply_all_bg_css($gradient_opt, $render_slug, $this);
    }

    protected function apply_spacing_css($render_slug)
    {
        $customMarginPadding = array(
            // No need to add "_margin" or "_padding" in the key
            'tab_item' => array(
                'selector' => 'ul li%%order_class%% .dnxte_tab_a',
                'type' => array('margin', 'padding'), //
            ),
            'tab_title' => array(
                'selector' => '%%order_class%% .dnxte_tab_nav_title',
                'type' => array('margin', 'padding'), //
            ),
            'tab_subtitle' => array(
                'selector' => '%%order_class%% .dnxte_tab_nav_pra',
                'type' => array('margin', 'padding'), //
            ),
            'tab_icon' => array(
                'selector' => '%%order_class%% .dnxte_tab_nav_icon,%%order_class%% .dnxte_tab_nav_image',
                'type' => array('margin', 'padding'), //
            ),
            'tab_icon_active' => array(
                'selector' => '%%order_class%% .dnxte_tab_nav_icon_active,%%order_class%% .dnxte_tab_nav_image_active',
                'type' => array('margin', 'padding'), //
            ),
            // 'body_item' => array(
            //     'selector' => '%%order_class%% .dnxte_tab_content.dnxte_tab_content_active',
            //     'type' => array('margin', 'padding'), //
            // ),
            'body_title' => array(
                'selector' => '%%order_class%% .dnxte_tab_content_slidebar_two .dnxte_tab_content_title',
                'type' => array('margin', 'padding'), //
            ),
            'body_description' => array(
                'selector' => '%%order_class%% .dnxte_tab_content_slidebar_two .dnxte_tab_content_pra',
                'type' => array('margin', 'padding'), //
            ),
            'body_image' => array(
                'selector' => '%%order_class%% .dnxte_tab_content_slidebar_one img',
                'type' => 'padding', //
            ),
            'body_icon' => array(
                'selector' => '%%order_class%% .dnxte_tab_content_slidebar_one span.dnxte_tab_content_icon',
                'type' => array('margin', 'padding'), //
            ),
        );

        Common::apply_spacing($customMarginPadding, $render_slug, $this->props);

        if( 'off' == $this->props['use_divi_library'] ) {
            Common::dnxt_set_style($render_slug, $this->props, "body_item_padding", "%%order_class%% .dnxte_tab_content.dnxte_tab_content_active", "padding");
            Common::dnxt_set_style($render_slug, $this->props, "body_item_margin", "%%order_class%% .dnxte_tab_content.dnxte_tab_content_active", "margin");

        }
    }

}
new NextAdvancedTabItem;