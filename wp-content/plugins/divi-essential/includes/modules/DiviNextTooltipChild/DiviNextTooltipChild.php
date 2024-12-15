<?php
include_once(DIVI_ESSENTIAL_PATH.'/includes/modules/base/Common.php');

class DiviNextTooltipChild extends ET_Builder_Module {

	public $slug                     = 'dnxte_tooltip_child';
	public $vb_support               = 'on';
	public $type                     = 'child';
	public $child_title_var          = 'admin_label_text';
	public $child_title_fallback_var = 'tooltip_hotspot_text';

	protected $module_credits = array(
		'module_uri' => 'https://www.diviessential.com/divi-hotspot/',
		'author'     => 'Divi Next',
		'author_uri' => 'www.divinext.com',
	);

	public function init() {
		$this->name = esc_html__( 'Hotspot Item', 'et_builder' );

		$this->settings_modal_toggles = array(
			'general' => array(
				'toggles' => array(
					'dnxte_hotspot_elements' => esc_html__('Hotspot', 'et_builder'),
					'dnxte_tooltip_elements' => esc_html__('Tooltip', 'et_builder'),
                    'admin_label' => array(
                        'title' => esc_html__("Admin Label", 'et_builder'),
                        'priority' => 100
                    )
				)
                ),
            'advanced' => array(
                'toggles' => array(
                    'dnxte_hotspot_settings' => esc_html__('Hotspot Settings', 'et_builder'),
                    'dnxte_tooltip_settings' => esc_html__('Tooltip Settings', 'et_builder'),
                    'dnxte_tooltip_text'     => esc_html__('Tooltip Text', 'et_builder'),
                    'dnxte_tooltip_desc'     => esc_html__('Tooltip Description', 'et_builder'),
                    'dnxte_tooltip_image'    => esc_html__('Tooltip Image', 'et_builder')
                )
            ),
            'custom_css'	=> array(
				'toggles'	=> array(
					'custom_css_id'	=>	esc_html__( 'CSS ID & Classes', 'et_builder' )
				)
			)
        );

        $this->custom_css_fields = array(
            'hotspot_text' => array(
                'label' => esc_html__('Hotspot Text', 'et_builder'),
                'selector' => '%%order_class%% .dnxte-hostpot-hotspot__text',
            ),
            'hotspot_icon' => array(
                'label' => esc_html__('Hotspot Icon', 'et_builder'),
                'selector' => '%%order_class%% .dnxte-hotspot_icon',
            ),
            'tooltip_text' => array(
                'label' => esc_html__('Tooltip Text', 'et_builder'),
                'selector' => '%%order_class%% .dnxte_tooltip_text',
            ),
            'tooltip_desc' => array(
                'label' => esc_html__('Tooltip Description', 'et_builder'),
                'selector' => '%%order_class%% .dnxte-tooltip-content',
            ),
            'tooltip_image' => array(
                'label' => esc_html__('Tooltip Image', 'et_builder'),
                'selector' => '%%order_class%% .dnxte-tooltip-image-container',
            ),
        );
    }

    public function get_advanced_fields_config(){
        return array(
            'text' => false,
            'max_width' => false,
            'fonts' => array(
                'hotspot_text' => array(
                    'label' => esc_html__('Hotspot', 'et_builder'),
                    'css'   => array(
                        'main'      => "%%order_class%% .dnxte-hostpot-hotspot__text",
                        'important' => 'plugin-only',
                    ),
                    'tab_slug'    => 'advanced',
                    'toggle_slug' => 'dnxte_hotspot_settings',
                ),
                'tooltip_text' => array(
                    'label' => esc_html__('Tooltip', 'et_builder'),
                    'css'   => array(
                        'main'      => "%%order_class%% .dnxte-hostpot-tooltip-text .dnxte_tooltip_text",
                        'important' => 'plugin-only',
                    ),
                    'tab_slug'    => 'advanced',
                    'toggle_slug' => 'dnxte_tooltip_text',
                ),
                'tooltip_desc' => array(
                    'label' => esc_html__('Description', 'et_builder'),
                    'css'   => array(
                        'main'      => "%%order_class%% .dnxte-hostpot-tooltip-text .dnxte-tooltip-content",
                        'important' => 'plugin-only',
                    ),
                    'tab_slug'    => 'advanced',
                    'toggle_slug' => 'dnxte_tooltip_desc',
                ),
            ),
            'borders' => array(
                'default' => array(
					'css' => array(
						'main'     => array(
							'border_radii'  		=> "%%order_class%% .dnxte-hotspot_icon",
							'border_radii_hover'  	=> '%%order_class%%:hover .dnxte-hotspot_icon',
							'border_styles' 		=> "%%order_class%% .dnxte-hotspot_icon",
							'border_styles_hover' 	=> '%%order_class%%:hover .dnxte-hotspot_icon',
						),
					)
				),
                'hotspot_child' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii'  => "%%order_class%% .dnxte-hostpot-hotspots__wrapper,%%order_class%% .dnxte-hostpot-hotspots__wrapper:before",
                            'border_styles' => "%%order_class%% .dnxte-hostpot-hotspots__wrapper",
                        ),
                        'important' => 'all'
                    ),
                    'defaults'    => array(
                        'border_radii' => 'on|50%|50%|50%|50%',
                    ),
                    'label_prefix' => esc_html__('Hotspot', 'et_builder'),
                    'toggle_slug'  => 'dnxte_hotspot_settings',
                ),
                'tooltip_text' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii'  => "%%order_class%% .dnxte-hostpot-tooltip-text .dnxte_tooltip_text",
                            'border_styles' => "%%order_class%% .dnxte-hostpot-tooltip-text .dnxte_tooltip_text",
                        ),
                        'important' => 'all'
                    ),
                    'label_prefix' => esc_html__('Text', 'et_builder'),
                    'toggle_slug'  => 'dnxte_tooltip_text',
                ),
                'tooltip_desc' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii'  => "%%order_class%% .dnxte-hostpot-tooltip-text .dnxte-tooltip-content",
                            'border_styles' => "%%order_class%% .dnxte-hostpot-tooltip-text .dnxte-tooltip-content",
                        ),
                        'important' => 'all'
                    ),
                    'toggle_slug' => 'dnxte_tooltip_desc',
                ),
                'tooltip_img' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii'  => "%%order_class%% .dnxte-hostpot-tooltip-text img",
                            'border_styles' => "%%order_class%% .dnxte-hostpot-tooltip-text img",
                        ),
                        'important' => 'all'
                    ),
                    'toggle_slug' => 'dnxte_tooltip_image',
                ),
            ),
            'box_shadow' => array(
                'default' => array(
					'css' 	=> array(
						'main' => "%%order_class%% .dnxte-hostpot-hotspots__wrapper"
					)
				),
                'hotspot' => array(
                    'label'           => esc_html__('Hotspot Box Shadow', 'et_builder'),
                    'option_category' => 'layout',
                    'tab_slug'        => 'advanced',
                    'toggle_slug'     => 'dnxte_hotspot_settings',
                    'css'             => array(
                        'main'         => '%%order_class%% .dnxte-hostpot-hotspots__wrapper',
                        'custom_style' => true,
                        'important'    => 'all'
                    ),
                    'default_on_fronts' => array(
                        'color'    => '',
                        'position' => '',
                    ),
                ),
                'tooltip_text' => array(
                    'label'           => esc_html__('Text Box Shadow', 'et_builder'),
                    'option_category' => 'layout',
                    'tab_slug'        => 'advanced',
                    'toggle_slug'     => 'dnxte_tooltip_text',
                    'css'             => array(
                        'main'         => '%%order_class%% .dnxte-hostpot-tooltip-text .dnxte_tooltip_text',
                        'custom_style' => true,
                        'important'    => 'all'
                    ),
                    'default_on_fronts' => array(
                        'color'    => '',
                        'position' => '',
                    ),
                ),
                'tooltip_desc' => array(
                    'label'           => esc_html__('Box Shadow', 'et_builder'),
                    'option_category' => 'layout',
                    'tab_slug'        => 'advanced',
                    'toggle_slug'     => 'dnxte_tooltip_desc',
                    'css'             => array(
                        'main'         => '%%order_class%% .dnxte-hostpot-tooltip-text .dnxte-tooltip-content',
                        'custom_style' => true,
                        'important'    => 'all'
                    ),
                    'default_on_fronts' => array(
                        'color'    => '',
                        'position' => '',
                    ),
                ),
                'tooltip_img' => array(
                    'label'           => esc_html__('Box Shadow', 'et_builder'),
                    'option_category' => 'layout',
                    'tab_slug'        => 'advanced',
                    'toggle_slug'     => 'dnxte_tooltip_image',
                    'css'             => array(
                        'main'         => '%%order_class%% .dnxte-hostpot-tooltip-text img',
                        'custom_style' => true,
                        'important'    => 'all'
                    ),
                    'default_on_fronts' => array(
                        'color'    => '',
                        'position' => '',
                    ),
                ),
            )
        );
    }

	public function get_fields() {
		return array(
            'admin_label_text' => array(
                'label' => esc_html__('Admin Label', 'et_builder'),
                'type' => 'text',
                'option_category' => 'basic_option',
                'description'     => esc_html__('This will change the label of the module in the builder for easy identification.', 'et_builder'),
                'toggle_slug' => 'admin_label',
            ),
			'tooltip_hotspot_text' => array(
                'label' => esc_html__('Hotspot Text', 'et_builder'),
                'type' => 'text',
                'option_category' => 'basic_option',
                'description' => esc_html__('Input Hotspot text', 'et_builder'),
                'toggle_slug' => 'dnxte_hotspot_elements',
                'dynamic_content' => 'text',
            ),
            'tooltip_use_hotspot_icon' => array(
                'label' => esc_html__('Use Icon', 'et_builder'),
                'type' => 'yes_no_button',
                'toggle_slug' => 'dnxte_hotspot_elements',
                'options' => array(
                    'on' => esc_html__('Yes', 'et_builder'),
                    'off' => esc_html__('No', 'et_builder'),
                ),
                'affects' => array(
                    'tooltip_hotspot_icon',
                    'hotspot_icon_color',
                    'hotspot_icon_size'
                ),
                'default_on_front' => 'on',
            ),
            'tooltip_hotspot_icon' => array(
                'label' => esc_html__('Icon', 'et_builder'),
                'type' => 'select_icon',
                'class' => array('et-pb-font-icon'),
                'default' => 'N',
                'toggle_slug' => 'dnxte_hotspot_elements',
                'mobile_options' => true,
                'option_category' => 'basic_option',
            ),
            'tooltip_bg' => array(
                'label' => esc_html__('Background Color', 'et_builder'),
                'type' => 'color-alpha',
                'custom_color' => true,
                'default' => '',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxte_tooltip_settings',
                'mobile_options' => true,
                'hover' => 'tabs',
            ),
            'tooltip_position' => array(
                'label' => esc_html__('Tooltip Position', 'et_builder'),
                'type' => 'select',
                'description' => esc_html__('Select the position of the tooltip', 'et_builder'),
                'option_category' => 'basic_option',
                'tab_slug'  => 'advanced',
                'toggle_slug' => 'dnxte_tooltip_settings',
                'options' => array(
                    'top' => esc_html__('Top', 'et_builder'),
                    'right' => esc_html__('Right', 'et_builder'),
                    'bottom' => esc_html__('Bottom', 'et_builder'),
                    'left' => esc_html__('Left', 'et_builder'),
                ),
                'default' => 'top',
            ),
            'tooltip_layout' => array(
                'label' => esc_html__('Tooltip Layout', 'et_builder'),
                'type' => 'select',
                'description' => esc_html__('Select the layout of the tooltip', 'et_builder'),
                'option_category' => 'basic_option',
                'tab_slug'  => 'advanced',
                'toggle_slug' => 'dnxte_tooltip_settings',
                'options' => array(
                    'column' => esc_html__('Top Image, Bottom Content', 'et_builder'),
                    'column-reverse' => esc_html__('Top Content, Bottom Image', 'et_builder'),
                    'row' => esc_html__('Left Image, Right Content', 'et_builder'),
                    'row-reverse' => esc_html__('Left Content, Right Image', 'et_builder'),
                ),
                'default' => 'column',
            ),
            'tooltip_text' => array(
                'label' => esc_html__('Tooltip Text', 'et_builder'),
                'type' => 'text',
                'option_category' => 'basic_option',
                'description' => esc_html__('Input Tooltip text', 'et_builder'),
                'toggle_slug' => 'dnxte_tooltip_elements',
                'dynamic_content' => 'text',
            ),
            'tooltip_content' => array(
                'label' => esc_html__('Tooltip Content', 'et_builder'),
                'type'  => 'tiny_mce',
                'option_category' => 'basic_option',
                'description' => esc_html__('Tooltip Description goes here', 'et_builder'),
                'toggle_slug' => 'dnxte_tooltip_elements',
                'dynamic_content' => 'text'
            ),
			'tooltip_use_image' => array(
                'label' => esc_html__('Use Image', 'et_builder'),
                'type' => 'yes_no_button',
                'toggle_slug' => 'dnxte_tooltip_elements',
                'options' => array(
                    'on' => esc_html__('Yes', 'et_builder'),
                    'off' => esc_html__('No', 'et_builder'),
                ),
                'affects' => array(
					'tooltip_image',
					'tooltip_image_alt'
                ),
                'default_on_front' => 'off',
			),
			'tooltip_image' => array(
                'label' => esc_html__('Image', 'et_builder'),
                'type' => 'upload',
                'option_category' => 'basic_option',
                'upload_button_text' => esc_attr__('Upload an image', 'et_builder'),
                'choose_text' => esc_attr__('Choose an Image', 'et_builder'),
                'update_text' => esc_attr__('Set As Image', 'et_builder'),
                'description' => esc_html__('Upload an image to display at the top of your team person.', 'et_builder'),
                'toggle_slug' => 'dnxte_tooltip_elements',
                'dynamic_content' => 'image',
                'mobile_options' => true,
                'hover' => 'tabs',
            ),
            'tooltip_image_alt' => array(
                'label' => esc_html__('Image Alt', 'et_builder'),
				'type' => 'text',
				'default' => 'tooltip text',
                'option_category' => 'basic_option',
                'description' => esc_html__('Input image alt text', 'et_builder'),
                'toggle_slug' => 'dnxte_tooltip_elements',
                'dynamic_content' => 'text',
                'mobile_options' => true,
                'hover' => 'tabs',
            ),
            'hotspot_horizontal' => array(
                'label' => esc_html__('Horizontal Position', 'et_builder'),
                'description' => esc_html__('Adjust the position of hotspot.', 'et_builder'),
                'type' => 'range',
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxte_hotspot_settings',
                'allowed_units' => array('%','em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'default' => '50%',
                'default_unit' => '%',
                'default_on_front' => '50%',
                'allow_empty' => true,
                'range_settings' => array(
                    'min' => '0',
                    'max' => '100',
                    'step' => '1',
                ),
                'mobile_options' => true,
                'hover' => 'tabs',
            ),
            'hotspot_vertical' => array(
                'label' => esc_html__('Vertical Position', 'et_builder'),
                'description' => esc_html__('Adjust the position of hotspot.', 'et_builder'),
                'type' => 'range',
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxte_hotspot_settings',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'default' => '20%',
                'default_unit' => '%',
                'default_on_front' => '20%',
                'allow_empty' => true,
                'range_settings' => array(
                    'min' => '0',
                    'max' => '100',
                    'step' => '1',
                ),
                'mobile_options' => true,
                'hover' => 'tabs',
            ),
            'hotspot_sizing' => array(
                'label' => esc_html__('Circle Width', 'et_builder'),
                'description' => esc_html__('Adjust the width of hotspot circle.', 'et_builder'),
                'type' => 'range',
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxte_hotspot_settings',
                'default' => '30',
                'default_on_front' => '30',
                'fixed_unit' => '',
                'validate_unit' => false,
                'unitless' => true,
                'allow_empty' => false,
                'range_settings' => array(
                    'min' => '0',
                    'max' => '1000',
                    'step' => '1',
                ),
                'mobile_options' => true,
            ),
            'hotspot_bg' => array(
                'label' => esc_html__('Background Color', 'et_builder'),
                'type' => 'color-alpha',
                'custom_color' => true,
                'default' => '',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxte_hotspot_settings',
                'mobile_options' => true,
                'hover' => 'tabs',
            ),
            'hotspot_wave_color' => array(
                'label' => esc_html__('Wave Color', 'et_builder'),
                'type' => 'color-alpha',
                'custom_color' => true,
                'default' => '',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxte_hotspot_settings',
                'mobile_options' => true,
                'hover' => 'tabs',
            ),
            'hotspot_icon_color' => array(
                'label' => esc_html__('Icon Color', 'et_builder'),
                'type' => 'color-alpha',
                'custom_color' => true,
                'default' => '#fff',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxte_hotspot_settings',
                'mobile_options' => true,
                'hover' => 'tabs',
                'show_if' => array(
                    'tooltip_use_hotspot_icon' => 'on',
                ),
            ),
            'hotspot_icon_size' => array(
                'label' => esc_html__('Icon Size', 'et_builder'),
                'description' => esc_html__('Adjust the size of the icon.', 'et_builder'),
                'type' => 'range',
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxte_hotspot_settings',
                'allowed_units' => array('em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'default' => '22px',
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
                'show_if' => array(
                    'tooltip_use_hotspot_icon' => 'on',
                ),
            ),
            'tooltip_width' => array(
                'label' => esc_html__('Tooltip Width', 'et_builder'),
                'description' => esc_html__('Adjust the width of tooltip.', 'et_builder'),
                'type' => 'range',
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxte_tooltip_settings',
                'allowed_units' => array('%','em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'default' => '200px',
                'default_unit' => 'px',
                'default_on_front' => '200px',
                'allow_empty' => true,
                'range_settings' => array(
                    'min' => '0',
                    'max' => '1000',
                    'step' => '1',
                ),
                'mobile_options' => true,
                'hover' => 'tabs',
            ),
            'tooltip_image_width' => array(
                'label' => esc_html__('Image Width', 'et_builder'),
                'description' => esc_html__('Adjust the width of image.', 'et_builder'),
                'type' => 'range',
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxte_tooltip_image',
                'allowed_units' => array('%','em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
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
            'tooltip_image_vertical' => array(
                'label' => esc_html__('Image Position', 'et_builder'),
                'type' => 'select',
                'description' => esc_html__('Select the position of the Image', 'et_builder'),
                'option_category' => 'basic_option',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxte_tooltip_image',
                'options' => array(
                    'flex-start' => esc_html__('Top/Left', 'et_builder'),
                    'center' => esc_html__('Center', 'et_builder'),
                    'flex-end' => esc_html__('Bottom/Right', 'et_builder'),
                ),
                'default' => 'center',
            ),
            'hotspot_padding' => array(
                'label' => esc_html__('Hotspot', 'et_builder'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'default' => '',
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'tooltip_padding' => array(
                'label' => esc_html__('Tooltip', 'et_builder'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'tooltip_text_margin' => array(
                'label' => esc_html__('Tooltip Text Margin', 'et_builder'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'tooltip_text_padding' => array(
                'label' => esc_html__('Tooltip Text Padding', 'et_builder'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'tooltip_desc_margin' => array(
                'label' => esc_html__('Description Margin', 'et_builder'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'tooltip_desc_padding' => array(
                'label' => esc_html__('Description Padding', 'et_builder'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'tooltip_image_margin' => array(
                'label' => esc_html__('Tooltip Image Margin', 'et_builder'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'tooltip_image_padding' => array(
                'label' => esc_html__('Tooltip Image Padding', 'et_builder'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'css_id' => array(
                'label' => esc_html__('CSS ID', 'et_builder'),
                'type' => 'text',
                'option_category' => 'basic_option',
                'description' => esc_html__('Assign a unique CSS ID to the element which can be used to assign custom CSS styles from within your child theme or from within Divi\'s custom CSS inputs.', 'et_builder'),
                'tab_slug' => 'custom_css',
                'toggle_slug' => 'custom_css_id',
            ),
            'css_classes' => array(
                'label' => esc_html__('CSS Class', 'et_builder'),
                'type' => 'text',
                'option_category' => 'basic_option',
                'description' => esc_html__('Assign any number of CSS Classes to the element, Separated by spaces, which can be used to assign custom CSS styles from within your child theme or from within Divi\'s custom CSS inputs.', 'et_builder'),
                'tab_slug' => 'custom_css',
				'toggle_slug' => 'custom_css_id',
            ),
		);
	}

	public function render( $attrs, $content, $render_slug ) {
        $multi_view = et_pb_multi_view_options($this);
        $tooltip_position = esc_attr__( $this->props['tooltip_position'], 'et_builder');
        $hotspot_custom_id = isset( $this->props['css_id'] ) ? sprintf('id=%1$s', $this->props['css_id']) : "";
        $hotspot_custom_classes = isset( $this->props['css_classes'] ) ? $this->props['css_classes'] : "";

        $hotspot_text = "";
        if($multi_view->has_value('tooltip_hotspot_text')) {
            $hotspot_text = $multi_view->render_element(array(
                'tag' => 'span',
                'content' => '{{tooltip_hotspot_text}}',
                'attrs' => array(
                    'class' => 'dnxte-hostpot-hotspot__text'
                )
            ));
        }

        $hotspot_icon = "";
        if($this->props['tooltip_use_hotspot_icon'] === "on" && $multi_view->has_value('tooltip_hotspot_icon')) {
            $icon_css_property = array(
				'selector'    => '%%order_class%% .et-pb-icon.dnxte-hotspot_icon',
				'class'       => 'et-pb-icon dnxte-hotspot_icon',
			);
			$hotspot_icon = Common::get_icon_html( 'tooltip_hotspot_icon', $this, $render_slug, $multi_view, $icon_css_property );
        }

        $tooltip_text = "";
        if($multi_view->has_value('tooltip_text')) {
            $tooltip_text = $multi_view->render_element(array(
                'tag' => 'p',
                'content' => '{{tooltip_text}}',
                'attrs' => array(
                    'class' => 'dnxte_tooltip_text'
                )
            ));
        }

        $image = "";
        if($this->props['tooltip_use_image'] === 'on' && $multi_view->has_value('tooltip_image')) {
            $image = $multi_view->render_element(array(
                'tag' => 'img',
                'attrs' => array(
                    'src' => '{{tooltip_image}}',
                    'alt' => '{{tooltip_image_alt}}'
                ),
            ));

            $image = sprintf('<div class="dnxte-tooltip-image-container">%1$s</div>', $image);
        }

        $tooltip_content = "";
        if($multi_view->has_value('tooltip_content')) {
            $tooltip_content = $multi_view->render_element(array(
                'tag' => 'div',
                'content' => '{{tooltip_content}}',
                'attrs'   => array(
                    'class' => 'dnxte-tooltip-content'
                )
            ));
        }


        // Hotspot Position
        $hotspot_horizontal = $this->props['hotspot_horizontal'];
        $hotspot_horizontal_values = et_pb_responsive_options()->get_property_values($this->props, 'hotspot_horizontal');
        $hotspot_horizontal_tablet = isset($hotspot_horizontal_values['tablet']) ? $hotspot_horizontal_values['tablet'] : '';
        $hotspot_horizontal_phone = isset($hotspot_horizontal_values['phone']) ? $hotspot_horizontal_values['phone'] : '';
        $hotspot_horizontal_hover = $this->get_hover_value('hotspot_horizontal');

        $hotspot_vertical = $this->props['hotspot_vertical'];
        $hotspot_vertical_values = et_pb_responsive_options()->get_property_values($this->props, 'hotspot_vertical');
        $hotspot_vertical_tablet = isset($hotspot_vertical_values['tablet']) ? $hotspot_vertical_values['tablet'] : '';
        $hotspot_vertical_phone = isset($hotspot_vertical_values['phone']) ? $hotspot_vertical_values['phone'] : '';
        $hotspot_vertical_hover = $this->get_hover_value('hotspot_vertical');

        if ("" !== $hotspot_horizontal || "" !== $hotspot_vertical) {
            $hotspot_position_style = sprintf('left: %1$s;top: %2$s;', $hotspot_horizontal, $hotspot_vertical);
            $hotspot_position_style_tablet = sprintf('left: %1$s;top: %2$s;', esc_attr($hotspot_horizontal_tablet), $hotspot_vertical_tablet);

            $hotspot_position_style_phone = sprintf('left: %1$s;top: %2$s;', $hotspot_horizontal_phone, $hotspot_vertical_phone);
            $hotspot_position_style_hover = "";

            if (et_builder_is_hover_enabled('hotspot_horizontal', $this->props) || et_builder_is_hover_enabled('hotspot_vertical', $this->props)) {
                $hotspot_position_style_hover = sprintf('left: %1$s;top: %2$s;', $hotspot_horizontal_hover, $hotspot_vertical_hover);
            }

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%%.et_pb_module",
                'declaration' => $hotspot_position_style,
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%%.et_pb_module",
                'declaration' => $hotspot_position_style_tablet,
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%%.et_pb_module",
                'declaration' => $hotspot_position_style_phone,
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));

            if ("" !== $hotspot_position_style_hover) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => $this->add_hover_to_order_class("%%order_class%%.et_pb_module:hover"),
                    'declaration' => $hotspot_position_style_hover,
                ));
            }
        }
        // Hotspot position end
         // Icon Settings
        $icon_color = $this->props['hotspot_icon_color'];
        $icon_color_values = et_pb_responsive_options()->get_property_values($this->props, 'hotspot_icon_color');
        $icon_color_tablet = isset($icon_color_values['tablet']) ? $icon_color_values['tablet'] : '';
        $icon_color_phone = isset($icon_color_values['phone']) ? $icon_color_values['phone'] : '';
        $icon_color_hover = $this->get_hover_value('hotspot_icon_color');

        $icon_size = $this->props['hotspot_icon_size'] ? $this->props['hotspot_icon_size'] : esc_attr('22px');
        $icon_size_values = et_pb_responsive_options()->get_property_values($this->props, 'hotspot_icon_size');
        $icon_size_tablet = isset($icon_size_values['tablet']) ? $icon_size_values['tablet'] : '';
        $icon_size_phone = isset($icon_size_values['phone']) ? $icon_size_values['phone'] : '';
        $icon_size_hover = $this->get_hover_value('hotspot_icon_size');

        if ("" !== $icon_color || "" !== $icon_size ) {
            $icon_style = sprintf('color: %1$s !important;font-size:%2$s !important;', $icon_color, $icon_size);
            $icon_style_tablet = sprintf('color: %1$s !important;font-size: %2$s !important;', $icon_color_tablet, $icon_size_tablet);
            $icon_style_phone = sprintf('color: %1$s !important;font-size: %2$s !important;', $icon_color_phone, $icon_size_phone);
            $icon_style_hover = "";

            if (et_builder_is_hover_enabled('hotspot_icon_color', $this->props)) {
                $icon_style_hover = sprintf('color: %1$s !important;font-size: %2$s !important;', $icon_color_hover, $icon_size_hover);
            }

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte-hotspot_icon",
                'declaration' => $icon_style,
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte-hotspot_icon",
                'declaration' => $icon_style_tablet,
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte-hotspot_icon",
                'declaration' => $icon_style_phone,
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));

            if ("" !== $icon_style_hover) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => $this->add_hover_to_order_class("%%order_class%% .dnxte-hotspot_icon:hover"),
                    'declaration' => $icon_style_hover,
                ));
            }
        }
        // Icon Settings

        // Hotspot background color
        $hotspot_bg = $this->props['hotspot_bg'];
        $hotspot_bg_values = et_pb_responsive_options()->get_property_values($this->props, 'hotspot_bg');
        $hotspot_bg_tablet = isset($hotspot_bg_values['tablet']) ? $hotspot_bg_values['tablet'] : '';
        $hotspot_bg_phone = isset($hotspot_bg_values['phone']) ? $hotspot_bg_values['phone'] : '';
        $hotspot_bg_hover = $this->get_hover_value('hotspot_bg');

        if ("" !== $hotspot_bg) {
            $hotspot_bg_style = sprintf('background-color: %1$s !important;', esc_attr__($hotspot_bg, 'et_builder'));
            $hotspot_bg_style_tablet = sprintf('background-color: %1$s !important;', esc_attr__($hotspot_bg_tablet, 'et_builder'));
            $hotspot_bg_style_phone = sprintf('background-color: %1$s !important;', esc_attr__($hotspot_bg_phone, 'et_builder'));
            $hotspot_bg_style_hover = "";

            if (et_builder_is_hover_enabled('hotspot_bg', $this->props)) {
                $hotspot_bg_style_hover = sprintf('background-color: %1$s !important;', esc_attr__($hotspot_bg_hover, 'et_builder'));
            }

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte-hostpot-hotspots__wrapper",
                'declaration' => $hotspot_bg_style,
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte-hostpot-hotspots__wrapper",
                'declaration' => $hotspot_bg_style_tablet,
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte-hostpot-hotspots__wrapper",
                'declaration' => $hotspot_bg_style_phone,
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));

            if ("" !== $hotspot_bg_style_hover) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => $this->add_hover_to_order_class("%%order_class%% .dnxte-hostpot-hotspots__wrapper:hover"),
                    'declaration' => $hotspot_bg_style_hover,
                ));
            }
        }
        // Hotspot background color end

        // Hotspot background color
        $hotspot_wave_color = $this->props['hotspot_wave_color'];
        $hotspot_wave_color_values = et_pb_responsive_options()->get_property_values($this->props, 'hotspot_wave_color');
        $hotspot_wave_color_tablet = isset($hotspot_wave_color_values['tablet']) ? $hotspot_wave_color_values['tablet'] : '';
        $hotspot_wave_color_phone = isset($hotspot_wave_color_values['phone']) ? $hotspot_wave_color_values['phone'] : '';
        $hotspot_wave_color_hover = $this->get_hover_value('hotspot_wave_color');

        if ("" !== $hotspot_wave_color) {
            $hotspot_wave_color_style = sprintf('background-color: %1$s !important;', esc_attr__($hotspot_wave_color, 'et_builder'));
            $hotspot_wave_color_style_tablet = sprintf('background-color: %1$s !important;', esc_attr__($hotspot_wave_color_tablet, 'et_builder'));
            $hotspot_wave_color_style_phone = sprintf('background-color: %1$s !important;', esc_attr__($hotspot_wave_color_phone, 'et_builder'));
            $hotspot_wave_color_style_hover = "";

            if (et_builder_is_hover_enabled('hotspot_wave_color', $this->props)) {
                $hotspot_wave_color_style_hover = sprintf('background-color: %1$s !important;', esc_attr__($hotspot_wave_color_hover, 'et_builder'));
            }

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte-hostpot-hotspots__wrapper:before",
                'declaration' => $hotspot_wave_color_style,
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte-hostpot-hotspots__wrapper:before",
                'declaration' => $hotspot_wave_color_style_tablet,
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte-hostpot-hotspots__wrapper:before",
                'declaration' => $hotspot_wave_color_style_phone,
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));

            if ("" !== $hotspot_wave_color_style_hover) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => $this->add_hover_to_order_class("%%order_class%% .dnxte-hostpot-hotspots__wrapper:hover::before"),
                    'declaration' => $hotspot_wave_color_style_hover,
                ));
            }
        }
        // Hotspot background color end

        // Tooltip background color


        $tooltip_bg_css_property = 'background-color: %1$s !important;';
        $tooltip_bg_css_selector = array(
            'desktop' => "%%order_class%% .dnxte-hostpot-tooltip-text",
            'hover'   => "%%order_class%% .dnxte-hostpot-tooltip-text:hover"
        );
        Common::set_css("tooltip_bg", $tooltip_bg_css_property, $tooltip_bg_css_selector, $render_slug, $this);



        // Tooltip background color end

        // Tooltip triangle background color

        $tooltip_bg_css_property = 'border-color: transparent !important; border-'.$this->props['tooltip_position'].'-color: %1$s !important;';
        $tooltip_bg_css_selector = array(
            'desktop' => "%%order_class%% .dnxte-hostpot-tooltip-text:after",
            'hover'   => "%%order_class%% .dnxte-hostpot-tooltip-text:hover::after"
        );
        Common::set_css("tooltip_bg", $tooltip_bg_css_property, $tooltip_bg_css_selector, $render_slug, $this);




        // Tooltip triangle background color end

        // Tooltip Width
        $tooltip_width = $this->props['tooltip_width'];
        $tooltip_width_values = et_pb_responsive_options()->get_property_values($this->props, 'tooltip_width');
        $tooltip_width_tablet = isset($tooltip_width_values['tablet']) ? $tooltip_width_values['tablet'] : '';
        $tooltip_width_phone = isset($tooltip_width_values['phone']) ? $tooltip_width_values['phone'] : '';
        $tooltip_width_hover = $this->get_hover_value('tooltip_width');

        if ("" !== $tooltip_width) {
            $tooltip_width_style = sprintf('width: %1$s;', esc_attr__($tooltip_width, 'et_builder'));
            $tooltip_width_style_tablet = sprintf('width: %1$s;', esc_attr__($tooltip_width_tablet, 'et_builder'));

            $tooltip_width_style_phone = sprintf('width: %1$s;', esc_attr__($tooltip_width_phone, 'et_builder'));
            $tooltip_width_style_hover = "";

            if (et_builder_is_hover_enabled('tooltip_width', $this->props)) {
                $tooltip_width_style_hover = sprintf('width: %1$s;', esc_attr__($tooltip_width_hover, 'et_builder'));
            }

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte-hostpot-tooltip-text",
                'declaration' => $tooltip_width_style,
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte-hostpot-tooltip-text",
                'declaration' => $tooltip_width_style_tablet,
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte-hostpot-tooltip-text",
                'declaration' => $tooltip_width_style_phone,
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));

            if ("" !== $tooltip_width_style_hover) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => $this->add_hover_to_order_class("%%order_class%% .dnxte-hostpot-tooltip-text:hover"),
                    'declaration' => $tooltip_width_style_hover,
                ));
            }
        }
        // Tooltip width end

        // Tooltip Layout
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .dnxte-hostpot-tooltip-text",
            'declaration' => sprintf('flex-direction: %1$s;', $this->props['tooltip_layout']),
        ));
        // Tooltip Layout end

        // Image Position
        if(in_array($this->props['tooltip_layout'], array("row", "row-reverse"))) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte-tooltip-image-container",
                'declaration' => sprintf('align-self: %1$s;', $this->props['tooltip_image_vertical']),
            ));
        }else{
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte-tooltip-image-container",
                'declaration' => sprintf('justify-content: %1$s;', $this->props['tooltip_image_vertical']),
            ));
        }
        // Image Position end

        // Image Width
        $tooltip_image_width = $this->props['tooltip_image_width'];
        $tooltip_image_width_hover = $this->get_hover_value('tooltip_image_width');
        $tooltip_image_width_tablet = $this->props['tooltip_image_width_tablet'];
        $tooltip_image_width_phone = $this->props['tooltip_image_width_phone'];
        $tooltip_image_width_last_edited = $this->props['tooltip_image_width_last_edited'];

        if ('' !== $tooltip_image_width) {
            $tooltip_image_width_responsive_active = et_pb_get_responsive_status($tooltip_image_width_last_edited);

            $tooltip_image_width_values = array(
                'desktop' => $tooltip_image_width,
                'tablet' => $tooltip_image_width_responsive_active ? $tooltip_image_width_tablet : '',
                'phone' => $tooltip_image_width_responsive_active ? $tooltip_image_width_phone : '',
            );
            $tooltip_image_width_selector = "%%order_class%% .dnxte-tooltip-image-container";
            et_pb_responsive_options()->generate_responsive_css($tooltip_image_width_values, $tooltip_image_width_selector, 'width', $render_slug);

            if (et_builder_is_hover_enabled('tooltip_image_width', $this->props)) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => $this->add_hover_to_order_class('%%order_class%% .dnxte-tooltip-image-container'),
                    'declaration' => sprintf(
                        'width: %1$s;',
                        esc_html__($tooltip_image_width_hover, 'et_builder')
                    ),
                ));
            }
        }
        // Image width end

        // Tooltip Position
        if($this->props['tooltip_position'] === "bottom") {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte-hostpot-tooltip-text",
                'declaration' => sprintf('position: relative !important;'),
            ));
        }

        if($this->props['tooltip_position'] !== "bottom") {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte-hostpot-tooltip-text",
                'declaration' => sprintf('position: absolute !important;'),
            ));
        }


        $this->apply_css( $render_slug );
        return sprintf('
            <div %7$s class="dnxte-hostpot-hotspot %8$s">
                <div class="dnxte-hostpot-tooltip">
                <div class="dnxte-hostpot-tooltip-item tooltip-%5$s">
                    <div class="dnxte-hostpot-tooltip-content">
                    <div class="dnxte-hostpot-hotspots__wrapper">
                        %1$s
                        %4$s
                    </div>
                    </div>
                    <div class="dnxte-hostpot-tooltip-text">
                    %2$s
                    <div class="dnxte-tooltip-content-container">
                        %3$s
                        %6$s
                    </div>
                    </div>
                </div>
                </div>
            </div>
        ',
        $hotspot_text,
        $image,
        $tooltip_text,
        $hotspot_icon,
        $tooltip_position,
        $tooltip_content,
        esc_attr( $hotspot_custom_id ),
        esc_attr( $hotspot_custom_classes )
    );
    }

    public function apply_css( $render_slug ) {
        Common::dnxt_set_style($render_slug, $this->props, "hotspot_padding", "%%order_class%% .dnxte-hostpot-hotspots__wrapper", "padding", true);
        Common::dnxt_set_style($render_slug, $this->props, "tooltip_padding", "%%order_class%% .dnxte-hostpot-tooltip-text", "padding", true);

        Common::dnxt_set_style($render_slug, $this->props, "tooltip_text_margin", "%%order_class%% .dnxte_tooltip_text", "margin", true);
        Common::dnxt_set_style($render_slug, $this->props, "tooltip_text_padding", "%%order_class%% .dnxte_tooltip_text", "padding", true);

        Common::dnxt_set_style($render_slug, $this->props, "tooltip_desc_margin", "%%order_class%% .dnxte-tooltip-content", "margin", true);
        Common::dnxt_set_style($render_slug, $this->props, "tooltip_desc_padding", "%%order_class%% .dnxte-tooltip-content", "padding", true);

        Common::dnxt_set_style($render_slug, $this->props, "tooltip_image_margin", "%%order_class%% .dnxte-tooltip-image-container", "margin", true);
        Common::dnxt_set_style($render_slug, $this->props, "tooltip_image_padding", "%%order_class%% .dnxte-tooltip-image-container", "padding", true);




        $hotspot_width_css_property = 'min-width: %1$spx !important;min-height: %1$spx !important;';
        $hotspot_width_css_selector = array(
            'desktop' => "%%order_class%% .dnxte-hostpot-hotspots__wrapper,%%order_class%% .dnxte-hostpot-hotspots__wrapper:before"
        );
        Common::set_css("hotspot_sizing", $hotspot_width_css_property, $hotspot_width_css_selector, $render_slug, $this);

        if('bottom' == $this->props['tooltip_position']) {
            $hotspot_size = (int) $this->props['hotspot_sizing'] / 2 . "px";
            $hotspot_size_values = et_pb_responsive_options()->get_property_values($this->props, "hotspot_sizing");
            $hotspot_size_tablet = "" !== $hotspot_size_values['tablet'] ? (int) $hotspot_size_values['tablet'] / 2 . "px" : '';
            $hotspot_size_phone = "" !== $hotspot_size_values['phone'] ? (int)$hotspot_size_values['phone'] / 2 . "px" : $hotspot_size_values['tablet'];

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte-hostpot-tooltip .dnxte-hostpot-tooltip-item.tooltip-bottom .dnxte-hostpot-tooltip-content ~ .dnxte-hostpot-tooltip-text",
                'declaration' => sprintf('transform: translateX(-50%%) translate3d(%1$s, 0px, 0px) !important;', $hotspot_size),
            ));

            if($hotspot_size_values['tablet']){
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => "%%order_class%% .dnxte-hostpot-tooltip .dnxte-hostpot-tooltip-item.tooltip-bottom .dnxte-hostpot-tooltip-content ~ .dnxte-hostpot-tooltip-text",
                    'declaration' => sprintf('transform: translateX(-50%%) translate3d(%1$s, 0px, 0px) !important;', $hotspot_size_tablet),
                    'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
                ));
            }

            if($hotspot_size_values['phone']){
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => "%%order_class%% .dnxte-hostpot-tooltip .dnxte-hostpot-tooltip-item.tooltip-bottom .dnxte-hostpot-tooltip-content ~ .dnxte-hostpot-tooltip-text",
                    'declaration' => sprintf('transform: translateX(-50%%) translate3d(%1$s, 0px, 0px) !important;', $hotspot_size_phone),
                    'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
                ));
            }
        }
    }
    public function multi_view_filter_value( $raw_value, $args, $multi_view ) {
		$name = isset( $args['name'] ) ? $args['name'] : '';

		if ( $raw_value && 'tooltip_hotspot_icon' === $name ) {
			return et_pb_get_extended_font_icon_value( $raw_value, true );
		}
		return $raw_value;
	}
}

new DiviNextTooltipChild;
