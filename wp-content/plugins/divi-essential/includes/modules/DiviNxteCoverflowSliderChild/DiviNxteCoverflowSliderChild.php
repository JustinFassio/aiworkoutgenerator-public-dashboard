<?php
include_once(DIVI_ESSENTIAL_PATH.'/includes/modules/base/Common.php');

class Divi_NxteCoverflowSliderChild extends ET_Builder_Module
{
    public $slug = 'dnxte_coverflowslider_child';
    public $vb_support = 'on';
    public $type = 'child';
    public $child_title_var = 'admin_label_text';
    public $child_title_fallback_var = 'coverflowslider_alt';

    protected $module_credits = array(
        'module_uri' => 'https://www.diviessential.com/divi-coverflow-slider/',
        'author' => 'Divi Next',
        'author_uri' => 'www.divinext.com',
    );

    public function init()
    {
        $this->name = esc_html__('Next Carousel Item', 'et_builder');
        $this->main_css_element = "%%order_class%%";

        $this->settings_modal_toggles = array(
            'general' => array(
                'toggles' => array(
                    'coverflowslider_content_toggle' => esc_html__('Slider Elements', 'et_builder'),
                    'admin_label' => array(
                        'title'         => esc_html__('Admin Label', 'et_builder'),
                        'priority'      => 100
                     )
                ),
            ),
            'advanced' => array(
                'toggles' => array(
                    'coverflowslider_text_settings' => esc_html__('Heading Settings', 'et_builder'),
                    'coverflowslider_content_settings' => esc_html__('Content Settings', 'et_builder'),
                    'dnxte_coverflow_overlay' 	=> array(
                        'title'  => esc_html__('Overlay Color', 'et_builder'),
                        'sub_toggles'   => array(
                            'desktop'  => array(
                                'name' => esc_html__('Desktop', 'et_builder')
                            ),
                            'hover'  => array(
                                'name' => esc_html__('Hover', 'et_builder')
                            ),
                        ),
                        'tabbed_subtoggles' => true,
                    ),
                    'coverflowslider_button_settings'    => esc_html__('Button', 'et_builder')
                )
            )
        );

        $this->custom_css_fields = array(
            'image' => array(
                'label' => esc_html__('Image', 'et_builder'),
                'selector' => '%%order_class%% .img-fluid',
            ),
            'text'              => array(
                'label'          => esc_html__( 'Heading', 'et_builder'),
                'selector'       => '%%order_class%% .dnxte-coverflow-heading'
            ),
            'content'              => array(
                'label'          => esc_html__( 'Content', 'et_builder'),
                'selector'       => '%%order_class%% .dnxte-coverflow-pra'
            ),
            'button'              => array(
                'label'          => esc_html__( 'Button', 'et_builder'),
                'selector'       => '%%order_class%% .dnxte-coverflow-button'
            ),
        );



        $this->advanced_fields = array(
            'text' => false,
            'fonts' => array(
                'header' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnxte-coverflow-heading',
                        'important' => 'all'
                    ),
                    'header_level' => array(
                        'default' => 'h3'
                    ),
                    'font'=> array(
                        'description' => esc_html__('Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'et_builder'),
                    ),
                    'letter_spacing'=> array(
                        'description' => esc_html__('Adjust the spacing between the letters of the text. You can upload a custom font as well.', 'et_builder'),
                    ),
                    'toggle_slug' => 'coverflowslider_text_settings',
                    'tab_slug' => 'advanced'
                ),
                'content' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnxte-coverflow-pra',
                        'important' => 'all'
                    ),
                    'font'=> array(
                        'description' => esc_html__('Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'et_builder'),
                    ),
                    'letter_spacing'=> array(
                        'description' => esc_html__('Adjust the spacing between the letters of the text. You can upload a custom font as well.', 'et_builder'),
                    ),
                    'toggle_slug' => 'coverflowslider_content_settings',
                    'tab_slug' => 'advanced'
                ),
                'button' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnxte-coverflow-button',
                        'important' => 'all'
                    ),
                    'hide_text_align' => true,
                    'toggle_slug' => 'coverflowslider_button_settings',
                    'tab_slug' => 'advanced'
                ),
            ),
            'max_width' => false,
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
                'text' => array(
                    'css' => array(
                        'main' => array(
                            "border_radii" => "%%order_class%% .dnxte-coverflow-heading",
                            'border_styles' => '%%order_class%% .dnxte-coverflow-heading',
                        ),
                        'important' => 'all',
                    ),
                    'toggle_slug' => 'coverflowslider_text_settings'
                ),
                'content' => array(
                    'css' => array(
                        'main' => array(
                            "border_radii" => "%%order_class%% .dnxte-coverflow-pra",
                            'border_styles' => '%%order_class%% .dnxte-coverflow-pra',
                        ),
                        'important' => 'all',
                    ),
                    'toggle_slug' => 'coverflowslider_content_settings'
                ),
                'button' => array(
                    'css' => array(
                        'main' => array(
                            "border_radii" => "%%order_class%% .dnxte-coverflow-button",
                            'border_styles' => '%%order_class%% .dnxte-coverflow-button',
                        ),
                        'important' => 'all',
                    ),
                    'defaults'        => array(
						'border_radii'  => 'on|3px|3px|3px|3px',
						'border_styles' => array(
							'width' => '2px',
							// 'color' => '#2857b6',
							'style' => 'solid',
						),
					),
                    'toggle_slug' => 'coverflowslider_button_settings'
                )
            ),
            'box_shadow' => array(
                'default' => array(
                    'css' => array(
                        'main' => '%%order_class%% .img-fluid',
                        'important' => 'all',
                    ),
                ),
                'text' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnxte-coverflow-heading',
                        'important' => 'all',
                    ),
                    'toggle_slug' => 'coverflowslider_text_settings'
                ),
                'content' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnxte-coverflow-pra',
                        'important' => 'all',
                    ),
                    'toggle_slug' => 'coverflowslider_content_settings'
                ),
                'button' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnxte-coverflow-button',
                        'important' => 'all',
                    ),
                    'toggle_slug' => 'coverflowslider_button_settings'
                ),
            ),
            'margin_padding' => array(
                'css' => array(
                    'main' => '%%order_class%% .dnxte-coverflowslider-item',
                ),
                'important' => 'all',
            ),
            'background' => array(
                'settings' => array(
                    'color' => 'alpha',
                ),
                'css' => array(
                    'main' => "%%order_class%% .dnxte-coverflowslider-item",
                    'important' => 'all',
                )
            )
        );
    }

    public function get_fields()
    {
        $fields = array(
            'admin_label_text'  => array(
                'label'           => esc_html__('Admin Label', 'et_builder'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'description'     => esc_html__('This will change the label of the module in the builder for easy identification.', 'et_builder'),
                'toggle_slug'     => 'admin_label',
            ),
            'coverflowslider_layouts' => array(
                'label'           => esc_html__('Select Layout', 'et_builder'),
                'type'            => 'select',
                'description'     => esc_html__('Select the layouts', 'et_builder'),
                'option_category' => 'basic_option',
                'toggle_slug'     => 'coverflowslider_content_toggle',
                'options'         => array(
                    'image'        => esc_html__('Image', 'et_builder'),
                    'text'         => esc_html__('Text', 'et_builder'),
                    'inside-image' => esc_html__('Text Inside The Image', 'et_builder'),
                    'below-image'  => esc_html__('Text Below The Image', 'et_builder'),
                    'left-image'  => esc_html__('Left Image, Right Content', 'et_builder'),
                    'right-image'  => esc_html__('Right Image, Left Content', 'et_builder'),
                ),
                'default' => 'image',
            ),
            'coverflowslider_text' => array(
                'label'           => esc_html__('Heading', 'et_builder'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'description'     => esc_html__('Text entered here will appear as title.', 'et_builder'),
                'toggle_slug'     => 'coverflowslider_content_toggle',
                'show_if_not'     => array(
                    'coverflowslider_layouts' => 'image'
                )
            ),
            'coverflowslider_content' => array(
                'label'           => esc_html__('Content', 'et_builder'),
                'type'            => 'tiny_mce',
                'option_category' => 'basic_option',
                'description'     => esc_html__('Input the main text content for your module here.', 'et_builder'),
                'toggle_slug'     => 'coverflowslider_content_toggle',
                'show_if_not'     => array(
                    'coverflowslider_layouts' => 'image'
                )
            ),
            'coverflowslider_image' => array(
                'label'              => esc_html__('Image', 'et_builder'),
                'type'               => 'upload',
                'description'        => esc_html__('Upload Image here (when enabling the responsive image feature in the Visual Builder it may sometimes not show the updated image but on the front end it will load the correct image)', 'et_builder'),
                'option_category'    => 'basic_option',
                'upload_button_text' => esc_attr__('Upload an image', 'et_builder'),
                'choose_text'        => esc_attr__('Choose an Image', 'et_builder'),
                'update_text'        => esc_attr__('Set As Image', 'et_builder'),
                'toggle_slug'        => 'coverflowslider_content_toggle',
                'data_type'          => 'image',
                'mobile_options'     => true,
                'choose_text' => esc_attr__('Choose an Image', 'et_builder'),
                'update_text' => esc_attr__('Set As Image', 'et_builder'),
                'toggle_slug' => 'coverflowslider_content_toggle',
                'data_type' => 'image',
                'mobile_options' => true,
                'show_if_not'           		=> array(
                    'coverflowslider_layouts'   => 'text'
                )
            ),
            'coverflowslider_alt' => array(
                'label'           => esc_html__('Image Alt', 'et_builder'),
                'type'            => 'text',
                'default'         => 'Image Item',
                'option_category' => 'basic_option',
                'description' => esc_html__('Text entered here will appear as title.', 'et_builder'),
                'toggle_slug' => 'coverflowslider_content_toggle',
                'show_if_not'           		=> array(
                    'coverflowslider_layouts'   => 'text'
                )
            ),
            'dnxte_coverflow_button_text' => array(
                'label'           => esc_html__('Button Text', 'et_builder'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'description'     => esc_html__('Input button text', 'et_builder'),
                'toggle_slug'     => 'coverflowslider_content_toggle',
                'dynamic_content' => 'text',
                'mobile_options'  => true,
                'hover'           => 'tabs',
            ),
            'dnxte_coverflow_button_link' => array(
                'label'           => esc_html__('Button Link', 'et_builder'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'default'         => '#',
                'description'     => esc_html__('When clicked the module will link to this URL.', 'et_builder'),
                'toggle_slug'     => 'coverflowslider_content_toggle',
            ),
            'dnxte_coverflow_button_target' => array(
                'label'           => esc_html__('Button Link Target', 'et_builder'),
                'type'            => 'select',
                'description'     => esc_html__('Select the link target', 'et_builder'),
                'option_category' => 'basic_option',
                'toggle_slug'     => 'coverflowslider_content_toggle',
                'options'         => array(
                    '_self'  => esc_html__('In The Same Window', 'et_builder'),
                    '_blank' => esc_html__('In The New Tab', 'et_builder'),

                ),
                'default' => '_self',
            ),
            'coverflowslider_content_horizontal' => array(
                'label'            => esc_html__('Horizontal Position', 'et_builder'),
                'description'      => esc_html__('Adjust the position of the offer.', 'et_builder'),
                'type'             => 'range',
                'option_category'  => 'layout',
                'tab_slug'         => 'advanced',
                'toggle_slug'      => 'coverflowslider_content_settings',
                'allowed_units'    => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'default'          => '0%',
                'default_unit'     => '%',
                'default_on_front' => '0%',
                'allow_empty'      => true,
                'range_settings'   => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1',
                ),
                'mobile_options' => true,
                'show_if'        => array(
                    'coverflowslider_layouts' => 'inside-image'
                )
            ),
            'coverflowslider_content_vertical' => array(
                'label'            => esc_html__('Vertical Position', 'et_builder'),
                'description'      => esc_html__('Adjust the position of the offer.', 'et_builder'),
                'type'             => 'range',
                'option_category'  => 'layout',
                'tab_slug'         => 'advanced',
                'toggle_slug'      => 'coverflowslider_content_settings',
                'allowed_units'    => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'default'          => '0%',
                'default_unit'     => '%',
                'default_on_front' => '0%',
                'allow_empty'      => true,
                'range_settings'   => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1',
                ),
                'mobile_options' => true,
                'show_if'        => array(
                    'coverflowslider_layouts' => 'inside-image'
                )
            ),
            'coverflowslider_text_margin'	=> array(
				'label'           		=> esc_html__('Heading Margin', 'et_builder'),
                'type'            		=> 'custom_margin',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'coverflowslider_text_padding'	=> array(
				'label'           		=> esc_html__('Heading Padding', 'et_builder'),
                'type'            		=> 'custom_padding',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'coverflowslider_content_margin'	=> array(
				'label'           		=> esc_html__('Content Margin', 'et_builder'),
                'type'            		=> 'custom_margin',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'coverflowslider_content_padding'	=> array(
				'label'           		=> esc_html__('Content Padding', 'et_builder'),
                'type'            		=> 'custom_padding',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'coverflowslider_content_wrapper_margin'	=> array(
				'label'           		=> esc_html__('Content Wrapper Margin', 'et_builder'),
                'type'            		=> 'custom_margin',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'coverflowslider_content_wrapper_padding'	=> array(
				'label'           		=> esc_html__('Content Wrapper Padding', 'et_builder'),
                'type'            		=> 'custom_padding',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'default'               => '15px|15px|15px|15px',
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'coverflowslider_image_margin'	=> array(
				'label'           		=> esc_html__('Image Margin', 'et_builder'),
                'type'            		=> 'custom_margin',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'coverflowslider_image_padding'	=> array(
				'label'           		=> esc_html__('Image Padding', 'et_builder'),
                'type'            		=> 'custom_padding',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'coverflowslider_button_alignment'=> array(
				'label'            => esc_html__( 'Button Alignment', 'et_builder' ),
				'description'      => esc_html__( 'Align your button to the left, right or center of the module.', 'et_builder' ),
				'type'             => 'text_align',
				'option_category'  => 'configuration',
				'options'          => et_builder_get_text_orientation_options( array('justified') ),
				'tab_slug'         => 'advanced',
				'toggle_slug'      => 'coverflowslider_button_settings',
				'mobile_options'   => true,
				'description'      => esc_html__( 'Here you can define the alignment of Button', 'et_builder' ),
            ),
            'coverflowslider_button_margin'	=> array(
				'label'           		=> esc_html__('Button Margin', 'et_builder'),
                'type'            		=> 'custom_margin',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'coverflowslider_button_padding'	=> array(
				'label'           		=> esc_html__('Button Padding', 'et_builder'),
                'type'            		=> 'custom_padding',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
        );

        $additional_fields = array(
            'coverflow_overlay_color' => array(
                'label' => esc_html__('Overlay Color', 'et_builder'),
                'type' => 'background-field',
                'description'      => esc_html__( 'Add either fill color or gradient as an overlay color', 'et_builder' ),
				'base_name' => "coverflow_overlay",
                'context' => "coverflow_overlay",
                'option_category' => 'layout',
                'custom_color' => true,
                'default' => ET_Global_Settings::get_value('all_buttons_bg_color'),
                'depends_show_if' => 'on',
                'tab_slug' => 'advanced',
                'toggle_slug' => "dnxte_coverflow_overlay",
				'sub_toggle'	=> 'desktop',
                'background_fields' => array_merge(
                    ET_Builder_Element::generate_background_options(
                        'coverflow_overlay',
                        'gradient',
                        "advanced",
                        "dnxte_coverflow_overlay",
                        "coverflow_overlay_gradient"
                    ),
                    ET_Builder_Element::generate_background_options(
                        "coverflow_overlay",
                        "color",
                        "advanced",
                        "dnxte_coverflow_overlay",
                        "coverflow_overlay_color"
                    )
                    ),
                'mobile_options' => true,
            ),
            'coverflow_hover_overlay_color' => array(
                'label' => esc_html__('Hover Overlay Color', 'et_builder'),
                'type' => 'background-field',
                'description'      => esc_html__( 'add either fill color or gradient as an overlay color which will appear when the cursor hovers on it', 'et_builder' ),
				'base_name' => "coverflow_hover_overlay",
                'context' => "coverflow_hover_overlay",
                'option_category' => 'layout',
                'custom_color' => true,
                'default' => ET_Global_Settings::get_value('all_buttons_bg_color'),
                'depends_show_if' => 'on',
                'tab_slug' => 'advanced',
                'toggle_slug' => "dnxte_coverflow_overlay",
				'sub_toggle'	=> 'hover',
                'background_fields' => array_merge(
                    ET_Builder_Element::generate_background_options(
                        'coverflow_hover_overlay',
                        'gradient',
                        "advanced",
                        "dnxte_coverflow_overlay",
                        "coverflow_hover_overlay_gradient"
                    ),
                    ET_Builder_Element::generate_background_options(
                        "coverflow_hover_overlay",
                        "color",
                        "advanced",
                        "dnxte_coverflow_overlay",
                        "coverflow_hover_overlay_color"
                    )
                    ),
                'mobile_options' => true,
            ),
        );

        $additional_fields = array_merge(
            $additional_fields,
            $this->generate_background_options(
                'coverflow_overlay',
                'skip',
                "advanced",
                "dnxte_coverflow_overlay",
                "coverflow_overlay_gradient"
            ),
            $this->generate_background_options(
                'coverflow_hover_overlay',
                'skip',
                "advanced",
                "dnxte_coverflow_overlay",
                "coverflow_hover_overlay_gradient"
            ),
            $this->generate_background_options(
                'coverflow_overlay',
                'skip',
                "advanced",
                "dnxte_coverflow_overlay",
                "coverflow_overlay_color"
            ),
            $this->generate_background_options(
                'coverflow_hover_overlay',
                'skip',
                "advanced",
                "dnxte_coverflow_overlay",
                "coverflow_hover_overlay_color"
            )
        );

        // slug = coverflow_button_bg_color
        $button_bg = Common::background_fields($this, "coverflow_button_", "Button Background", "coverflowslider_button_settings", "general", array(
            'hover'        => 'tabs'
        )); 

        return array_merge($fields, $additional_fields, $button_bg);
    }

    public function imageContentPosition() {
        $layout = $this->props['coverflowslider_layouts'];
        return in_array($layout, array( 'left-image', 'right-image' )) ? $layout : '';
    }

    public function render($attrs, $content, $render_slug)
    {
        $multi_view = et_pb_multi_view_options($this);
        $coverflowslider_content = $this->props['coverflowslider_content'];

        $button_text = $this->props['dnxte_coverflow_button_text'];
        $button_link = $this->props['dnxte_coverflow_button_link'];
        $button_target = $this->props['dnxte_coverflow_button_target'];

        $multitext_class ="";

        if($this->props['coverflowslider_layouts'] === "inside-image") {
            $multitext_class = "dnxte-coverflow-inside-image";
        }
        $title = "";
        if($multi_view->has_value('coverflowslider_text')) {
            $title = $multi_view->render_element(array(
                'tag' => et_pb_process_header_level($this->props['header_level'], 'h3'),
                'content' => '{{coverflowslider_text}}',
                'attrs' => array(
                    'class' => 'dnxte-coverflow-heading'
                )
            ));
        }

        $image = "";
        if($this->props['coverflowslider_image'] !== "" && $this->props['coverflowslider_layouts'] !== 'text') {
            if ($multi_view->has_value('coverflowslider_image')) {
                $image = $multi_view->render_element(array(
                    'tag' => 'img',
                    'attrs' => array(
                        'src' => '{{coverflowslider_image}}',
                        'alt' => '{{coverflowslider_alt}}',
                        'class' => 'img-fluid',
                    ),
                ));
            }
        }

        $description = $multi_view->render_element( array(
            'tag' => 'div',
            'content' => '{{coverflowslider_content}}',
            'attrs' => array(
            'class' => 'dnxte-coverflow-pra',
            )
        ));

        $button_alignment_classes = Common::get_alignment("coverflowslider_button_alignment", $this);

        $button = "" != $button_text ?
            sprintf('<div class="dnxte-coverflow-button-wrapper '.$button_alignment_classes.'">
                        <a class="dnxte-coverflow-button" href="%1$s" target="%2$s">%3$s</a>
                    </div>', $button_link, $button_target, $button_text) :
            "";



        if($this->props['coverflowslider_layouts'] === 'inside-image' || $this->props['coverflowslider_layouts'] === 'text') {
            // Content Position
            $content_horizontal = $this->props['coverflowslider_content_horizontal'];
            $content_horizontal_values = et_pb_responsive_options()->get_property_values($this->props, 'coverflowslider_content_horizontal');
            $content_horizontal_tablet = isset($content_horizontal_values['tablet']) ? $content_horizontal_values['tablet'] : '';
            $content_horizontal_phone = isset($content_horizontal_values['phone']) ? $content_horizontal_values['phone'] : '';

            $content_vertical = $this->props['coverflowslider_content_vertical'];
            $content_vertical_values = et_pb_responsive_options()->get_property_values($this->props, 'coverflowslider_content_vertical');
            $content_vertical_tablet = isset($content_vertical_values['tablet']) ? $content_vertical_values['tablet'] : '';
            $content_vertical_phone = isset($content_vertical_values['phone']) ? $content_vertical_values['phone'] : '';

            if ("" !== $content_horizontal || "" !== $content_vertical) {
                $content_position_style = sprintf('left: %1$s;top: %2$s;', $content_horizontal, $content_vertical);
                $content_position_style_tablet = sprintf('left: %1$s;top: %2$s;', esc_attr($content_horizontal_tablet), $content_vertical_tablet);

                $content_position_style_phone = sprintf('left: %1$s;top: %2$s;', $content_horizontal_phone, $content_vertical_phone);
                $content_position_style_hover = "";

                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => "%%order_class%% .dnxte-coverflow-inside-image",
                    'declaration' => $content_position_style,
                ));

                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => "%%order_class%% .dnxte-coverflow-inside-image",
                    'declaration' => $content_position_style_tablet,
                    'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
                ));

                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => "%%order_class%% .dnxte-coverflow-inside-image",
                    'declaration' => $content_position_style_phone,
                    'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
                ));
            }
            // Content position end
        }

        $slide_link_obj = array(
            "url"   => $this->props['link_option_url'],
            "target"    => 'on' === $this->props['link_option_url_new_window'] ? '_blank' : '_self',
        );

        $output = sprintf(
            '<div class="dnxte-coverflow-image-container" data-image-position="%6$s">
                <a href="%7$s" class="dnxte-coverflow-image-link" data-title="%8$s" data-link="%9$s,%10$s">
                    <div class="dnxte-coverflow-overlay-color"></div>
                    <div class="dnxte-coverflow-overlay-color-hover"></div>
                    %1$s
                </a>
            </div>
            <div class="dnxte-coverflow-multitext %4$s">
                %2$s
                %3$s
                %5$s
            </div>',
            $image,
            $title,
            $description,
            $multitext_class,
            $button, #5
            $this->imageContentPosition(),
            $this->props['coverflowslider_image'],
            $this->props['coverflowslider_text'],
            $this->props['link_option_url'],
            'on' === $this->props['link_option_url_new_window'] ? '_blank' : '_self'
        );

        $this->apply_css($render_slug);
        $this->apply_bg_styles($render_slug );
        return $output;
    }

    public function apply_bg_styles($render_slug) {
        // Normal Overlay background color
        $coverflow_overlay_color = array(
            'color_slug' => "coverflow_overlay_color"
        );
        $use_color_gradient = $this->props['coverflow_overlay_use_color_gradient'];

        $gradient = array(
            "gradient_type" => 'coverflow_overlay_color_gradient_type',
            "gradient_direction" => 'coverflow_overlay_color_gradient_direction',
            "radial" => 'coverflow_overlay_color_gradient_direction_radial',
            "gradient_start" => 'coverflow_overlay_color_gradient_start',
            "gradient_end" => 'coverflow_overlay_color_gradient_end',
            "gradient_start_position" => 'coverflow_overlay_color_gradient_start_position',
            "gradient_end_position" => 'coverflow_overlay_color_gradient_end_position',
            "gradient_overlays_image" => 'coverflow_overlay_color_gradient_overlays_image',
        );

        $css_property = array(
            "desktop" => "%%order_class%% .dnxte-coverflow-overlay-color",
        );
        Common::apply_bg_css($render_slug, $this, $coverflow_overlay_color, $use_color_gradient, $gradient, $css_property);
        //Normal background color end
        // Hover Overlay background color
        $coverflow_hover_overlay_color = array(
            'color_slug' => "coverflow_hover_overlay_color"
        );
        $use_color_gradient = $this->props['coverflow_hover_overlay_use_color_gradient'];

        $gradient = array(
            "gradient_type" => 'coverflow_hover_overlay_color_gradient_type',
            "gradient_direction" => 'coverflow_hover_overlay_color_gradient_direction',
            "radial" => 'coverflow_hover_overlay_color_gradient_direction_radial',
            "gradient_start" => 'coverflow_hover_overlay_color_gradient_start',
            "gradient_end" => 'coverflow_hover_overlay_color_gradient_end',
            "gradient_start_position" => 'coverflow_hover_overlay_color_gradient_start_position',
            "gradient_end_position" => 'coverflow_hover_overlay_color_gradient_end_position',
            "gradient_overlays_image" => 'coverflow_hover_overlay_color_gradient_overlays_image',
        );

        $css_property = array(
            "desktop" => "%%order_class%% .dnxte-coverflow-overlay-color-hover",
        );
        Common::apply_bg_css($render_slug, $this, $coverflow_hover_overlay_color, $use_color_gradient, $gradient, $css_property);
        //Hover background color end

        // 3d Flipbox Icon background color
        $coverflow_button_bg_color = array(
            'color_slug' => "coverflow_button_bg_color"
        );
        $use_color_gradient = $this->props['coverflow_button_bg_use_color_gradient'];
        $gradient = array(
            "gradient_type" => 'coverflow_button_bg_color_gradient_type',
            "gradient_direction" => 'coverflow_button_bg_color_gradient_direction',
            "radial" => 'coverflow_button_bg_color_gradient_direction_radial',
            "gradient_start" => 'coverflow_button_bg_color_gradient_start',
            "gradient_end" => 'coverflow_button_bg_color_gradient_end',
            "gradient_start_position" => 'coverflow_button_bg_color_gradient_start_position',
            "gradient_end_position" => 'coverflow_button_bg_color_gradient_end_position',
            "gradient_overlays_image" => 'coverflow_button_bg_color_gradient_overlays_image',
        );

        $css_property = array(
            "desktop" => "%%order_class%% .dnxte-coverflow-button",
            "hover" => "%%order_class%% .dnxte-coverflow-button:hover"
        );
        Common::apply_bg_css($render_slug, $this, $coverflow_button_bg_color, $use_color_gradient, $gradient, $css_property);
        //3d Flipbox Icon background color end
    }

    public function apply_css($render_slug){

        /**
         * Custom Padding Margin Output
         *
        */
        Common::dnxt_set_style($render_slug, $this->props, "coverflowslider_text_margin", "%%order_class%% .dnxte-coverflow-heading", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "coverflowslider_text_padding", "%%order_class%% .dnxte-coverflow-heading", "padding");

        Common::dnxt_set_style($render_slug, $this->props, "coverflowslider_content_margin", "%%order_class%% .dnxte-coverflow-pra", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "coverflowslider_content_padding", "%%order_class%% .dnxte-coverflow-pra", "padding");

        Common::dnxt_set_style($render_slug, $this->props, "coverflowslider_image_margin", "%%order_class%% .img-fluid", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "coverflowslider_image_padding", "%%order_class%% .img-fluid", "padding");

        Common::dnxt_set_style($render_slug, $this->props, "coverflowslider_button_margin", "%%order_class%% .dnxte-coverflow-button", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "coverflowslider_button_padding", "%%order_class%% .dnxte-coverflow-button", "padding");

        Common::dnxt_set_style($render_slug, $this->props, "coverflowslider_content_wrapper_margin", "%%order_class%% .dnxte-coverflow-multitext", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "coverflowslider_content_wrapper_padding", "%%order_class%% .dnxte-coverflow-multitext", "padding");

    }
}

new Divi_NxteCoverflowSliderChild;