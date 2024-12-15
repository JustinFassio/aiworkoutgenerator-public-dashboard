<?php
include_once(DIVI_ESSENTIAL_PATH.'/includes/modules/base/Common.php');

class Next_Dual_Button extends ET_Builder_Module {

	public $slug       = 'dnxte_dual_button';
	public $vb_support = 'on';

	protected $module_credits = array(
		'module_uri' => 'https://www.diviessential.com/divi-dual-button/',
		'author'     => 'Divi Next',
		'author_uri' => 'www.divinext.com',
	);

	public function init() {
		$this->name        = esc_html__( 'Next Dual Button', 'et_builder' );
		$this->icon_path   = plugin_dir_path( __FILE__ ) . 'icon.svg';
		$this->folder_name = 'et_pb_divi_essential';
		
		$this->settings_modal_toggles = array(
			'general'	=> array(
				'toggles'		=>	array(
					'dnxt_button_text_one'	=> esc_html__( 'Button One', 'et_builder' ),
					'dnxt_button_text_two'	=> esc_html__( 'Button Two', 'et_builder' ),
					'dnxt_button_one'		=> array(
                        'title'             => esc_html__('Background One', 'et_builder'),
                        'sub_toggles'       => array(
                            'sub_toggle_color'   => array(
								'name' => esc_html__('Color', 'et_builder')
							),
                            'sub_toggle_gradient'   => array(
								'name' => esc_html__('Gradient', 'et_builder')
							)
						),
                        'tabbed_subtoggles' => true,
					),
					'dnxt_button_two'		=> array(
                        'title'             => esc_html__('Background Two', 'et_builder'),
                        'sub_toggles'       => array(
                            'sub_toggle_color'   => array(
								'name' => esc_html__('Color', 'et_builder')
							),
                            'sub_toggle_gradient'   => array(
								'name' => esc_html__('Gradient', 'et_builder')
							)
						),
                        'tabbed_subtoggles' => true,
					),
				),
			),
			'advanced'	=> array(
				'toggles'		=>	array(
					'button_font'	=>	array(
						'title'		=>	esc_html__( 'Text', 'et_builder' ),
						'priority'	=>	1,
						'sub_toggles'       => array(
                            'sub_toggle_one'   => array(
                                'name' => 'Button One',
							),
                            'sub_toggle_two'   => array(
                                'name' => 'Button Two',
							),
						),
                        'tabbed_subtoggles' => true,
					),
					'button_alignment'	=>	array(
						'title'		=>	esc_html__( 'Alignment', 'et_builder' ),
						'priority'	=>	2,
					),
					'button_one_hover'      => array(
                        'title'             => esc_html__('Hover One', 'et_builder'),
                        'priority'          => 3,
                        'sub_toggles'       => array(
                            'sub_toggle_2d'   => array(
                                'name' => '2D ',
							),
                            'sub_toggle_bg'   => array(
                                'name' => 'BG',
							),
                            'sub_toggle_border' => array(
                                'name' => 'Stroke',
							),
							'sub_toggle_icons' => array(
                                'name' => 'Icon',
							),
						),

                        'tabbed_subtoggles' => true,
					),
					'button_two_hover'      => array(
                        'title'             => esc_html__('Hover Two', 'et_builder'),
                        'priority'          => 4,
                        'sub_toggles'       => array(
                            'sub_toggle_2d'   => array(
                                'name' => '2D ',
							),
                            'sub_toggle_bg'   => array(
                                'name' => 'BG',
							),
                            'sub_toggle_border' => array(
                                'name' => 'Stroke',
							),
							'sub_toggle_icons' => array(
                                'name' => 'Icon',
							),
						),

                        'tabbed_subtoggles' => true,
					),
					'button_icon'	=>	array(
						'title'		=>	esc_html__( 'Icon', 'et_builder' ),
						'priority'	=>	5,
						'sub_toggles'       => array(
                            'sub_toggle_one'   => array(
                                'name' => 'Button One',
							),
                            'sub_toggle_two'   => array(
                                'name' => 'Button Two',
							),
						),
                        'tabbed_subtoggles' => true,
							),
					'border_one'	=>	array(
						'title'		=>	esc_html__( 'Border One', 'et_builder' ),
						'priority'	=>	6,
					),
					'border_two'	=>	array(
						'title'		=>	esc_html__( 'Border Two', 'et_builder' ),
						'priority'	=>	7,
					),
					'button_spacing'	=>	array(
						'title'		=>	esc_html__( 'Spacing', 'et_builder' ),
						'priority'	=>	8,
						'sub_toggles'       => array(
                            'sub_toggle_one'   => array(
                                'name' => 'Button One',
                            ),
                            'sub_toggle_two'   => array(
                                'name' => 'Button Two',
                            ),
                        ),
                        'tabbed_subtoggles' => true,
					),
					'button_background'	=>	array(
						'title'		=>	esc_html__( 'Background', 'et_builder' ),
						'priority'	=>	9
					),
					'box_shadow'	=>	array(
						'title'		=>	esc_html__( 'Box Shadow', 'et_builder' ),
						'priority'	=>	100,
					),
				),
			),
			'custom_css'	=> array(
				'toggles'	=> array(
					'button_css_id'	=>	array(
						'title'		=>	esc_html__( 'Custom CSS ID & Class', 'et_builder' ),
						'priority'	=>	8,
						'sub_toggles'       => array(
                            'sub_toggle_one'   => array(
                                'name' => 'Button One',
                            ),
                            'sub_toggle_two'   => array(
                                'name' => 'Button Two',
                            ),
                        ),
                        'tabbed_subtoggles' => true,
					),
				)
			)
		);

		// Custom CSS Field
		$this->custom_css_fields = array(
			'button_wrapper' => array(
				'label'    => esc_html__('Button Wrapper', 'et_builder'),
				'selector' => '%%order_class%% .dnxt-button-wrapper',
			),
			'button_one_link'  => array(
				'label'    => esc_html__('Button One Link', 'et_builder'),
				'selector' => '%%order_class%% .dnxt-button-wrapper a.buttonOne',
			),
			'button_two_link'  => array(
				'label'    => esc_html__('Button Two Link', 'et_builder'),
				'selector' => '%%order_class%% .dnxt-button-wrapper a.buttonTwo',
			),
		);

		$this->help_videos = array(
			array(
				'id'   => esc_html( 'E4aftYwT0cE' ),
				'name' => esc_html__( 'Introducing Divi Next Dual Button module', 'et_builder' ),
			),
		);
	}

	public function get_fields() {
		$fields = array(
            // Title Field
			'button_text_one'      => array(
				'label'           => esc_html__( 'Button Text', 'et_builder' ),
				'type'            => 'text',
				'dynamic_content' => 'text',
                'default'         => 'Button Text One',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Input your desired button text.', 'et_builder' ),
                'toggle_slug'     => 'dnxt_button_text_one',
			),
			// Link Field
			'button_link_one'      => array(
				'label'           => esc_html__( 'Button Link', 'et_builder' ),
				'type'            => 'text',
				'dynamic_content' => 'url',
				'default'         => '#',
				'option_category' => 'configuration',
				'toggle_slug'     => 'dnxt_button_text_one',
				'description'     => esc_html__( 'Input the destination URL for your button.', 'et_builder' ),
			),
			// Link Target Field
			'button_link_one_new_window'		=> array(
				'label'				=> esc_html__( 'Button Link Target', 'et_builder' ),
				'type'             => 'select',
				'option_category'  => 'configuration',
				'options'          => array(
					'off' => esc_html__( 'In The Same Window', 'et_builder' ),
					'on'  => esc_html__( 'In The New Tab', 'et_builder' ),
				),
				'toggle_slug'      => 'dnxt_button_text_one',
				'description'      => esc_html__( 'Here you can choose whether or not your link opens in a new window', 'et_builder' ),
				'default_on_front' => 'off',
			),
            // Title Field
			'button_text_two'      => array(
				'label'           => esc_html__( 'Button Text', 'et_builder' ),
				'type'            => 'text',
				'dynamic_content' => 'text',
                'default'         => 'Button Text Two',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Input your desired button text.', 'et_builder' ),
                'toggle_slug'     => 'dnxt_button_text_two',
			),
			// Link Field
			'button_link_two'      => array(
				'label'           => esc_html__( 'Button Link', 'et_builder' ),
				'type'            => 'text',
				'dynamic_content' => 'url',
				'default'         => '#',
				'option_category' => 'configuration',
				'toggle_slug'     => 'dnxt_button_text_two',
				'description'     => esc_html__( 'Input the destination URL for your button.', 'et_builder' ),
			),
			// Link Target Field
			'button_link_two_new_window'		=> array(
				'label'				=> esc_html__( 'Button Link Target', 'et_builder' ),
				'type'             => 'select',
				'option_category'  => 'configuration',
				'options'          => array(
					'off' => esc_html__( 'In The Same Window', 'et_builder' ),
					'on'  => esc_html__( 'In The New Tab', 'et_builder' ),
				),
				'toggle_slug'      => 'dnxt_button_text_two',
				'description'      => esc_html__( 'Here you can choose whether or not your link opens in a new window', 'et_builder' ),
				'default_on_front' => 'off',
			),
			// Button Alignment
			'dnxt_dual_button_alignment'=> array(
				'label'            => esc_html__( 'Button Alignment', 'et_builder' ),
				'description'      => esc_html__( 'Align your button to the left, right or center of the module.', 'et_builder' ),
				'type'             => 'text_align',
				'option_category'  => 'configuration',
				'options'          => et_builder_get_text_orientation_options( array('justified') ),
				'tab_slug'         => 'advanced',
				'toggle_slug'      => 'button_alignment',
				'mobile_options'   => true,
				'description'      => esc_html__( 'Here you can define the alignment of Button', 'et_builder' ),
			),
			// Button One Show & Hide
			'btn_one_icon_show_hide'		=> array(
				'label'           => esc_html__( 'Show Icon', 'et_builder' ),
				'description'     => esc_html__( 'When enabled, this will add a custom icon within the button.', 'et_builder' ),
				'type'            => 'yes_no_button',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'button_icon',
				'sub_toggle'	  => 'sub_toggle_one',
				'default'         => 'on',
				'options'         => array(
					'on'      => esc_html__( 'Yes', 'et_builder' ),
					'off'     => esc_html__( 'No', 'et_builder' ),
				),
				'affects'         => array(
					"btn_one_icon",
					"btn_one_icon_color",
					"btn_one_icon_placement",
					"btn_one_on_hover",
				),
				'depends_show_if' => 'on',
			),
			// Button Icon
			'btn_one_icon'	=> array(
				'label'               => esc_html__( 'Button Icon', 'et_builder' ),
				'description'         => esc_html__( 'Pick an icon to be used for the button.', 'et_builder' ),
				'type'                => 'select_icon',
				'tab_slug'            => 'advanced',
				'toggle_slug'         => 'button_icon',
				'sub_toggle'	  	  => 'sub_toggle_one',
				'option_category'     => 'button',
				'class'               => array('et-pb-font-icon'),
				'default'             => '$',
				'depends_show_if_not' => 'off',
				'mobile_options'      => true,
			),
			// Button Icon Color
			'btn_one_icon_color'	=>	array(
				'label'               => esc_html__( 'Button Icon Color', 'et_builder'),
				'description'         => esc_html__( 'Here you can define a custom color for the button icon.', 'et_builder' ),
				'type'                => 'color-alpha',
				'tab_slug'            => 'advanced',
				'toggle_slug'         => 'button_icon',
				'sub_toggle'	  	  => 'sub_toggle_one',
				'custom_color'        => true,
				'default'			  => '#2857b6',
				'hover'               => 'tabs',
				'depends_show_if_not' => 'off',
				'mobile_options'      => true,
			),
			// Button Two Icon Placement
			'btn_one_icon_placement'	=>	array(
				'label'               => esc_html__( 'Button Icon Placement', 'et_builder' ),
				'description'         => esc_html__( 'Choose where the button icon should be displayed within the button.', 'et_builder' ),
				'type'                => 'select',
				'tab_slug'            => 'advanced',
				'toggle_slug'         => 'button_icon',
				'sub_toggle'	  	  => 'sub_toggle_one',
				'option_category'     => 'button',
				'options'             => array(
					'right' => esc_html__( 'Right', 'et_builder' ),
					'left'  => esc_html__( 'Left', 'et_builder' ),
				),
				'default'             => 'right',
				'depends_show_if_not' => 'off',
			),
			// Button One Icon On Hover
			'btn_one_on_hover'	=>	array(
				'label'               => esc_html__( 'Only Show Icon On Hover for Button', 'et_builder' ),
				'description'         => esc_html__( 'By default, button icons are displayed on hover. If you would like button icons to always be displayed, then you can enable this option.', 'et_builder' ),
				'type'                => 'yes_no_button',
				'tab_slug'            => 'advanced',
				'toggle_slug'         => 'button_icon',
				'sub_toggle'	  	  => 'sub_toggle_one',
				'default'             => 'on',
				'options'             => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'depends_show_if_not' => 'off',
				'mobile_options'      => true,
			),
			// Button Two Show & Hide
			'btn_two_icon_show_hide'		=> array(
				'label'           => esc_html__( 'Show Icon', 'et_builder' ),
				'description'     => esc_html__( 'When enabled, this will add a custom icon within the button.', 'et_builder' ),
				'type'            => 'yes_no_button',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'button_icon',
				'sub_toggle'	  => 'sub_toggle_two',
				'default'         => 'on',
				'options'         => array(
					'on'      => esc_html__( 'Yes', 'et_builder' ),
					'off'     => esc_html__( 'No', 'et_builder' ),
				),
				'affects'         => array(
					"btn_two_icon",
					"btn_two_icon_color",
					"btn_two_icon_placement",
					"btn_two_on_hover",
				),
				'depends_show_if' => 'on',
			),
			// Button Icon
			'btn_two_icon'	=> array(
				'label'               => esc_html__( 'Button Icon', 'et_builder' ),
				'description'         => esc_html__( 'Pick an icon to be used for the button.', 'et_builder' ),
				'type'                => 'select_icon',
				'tab_slug'            => 'advanced',
				'toggle_slug'         => 'button_icon',
				'sub_toggle'	  	  => 'sub_toggle_two',
				'option_category'     => 'button',
				'class'               => array( 'et-pb-font-icon' ),
				'default'             => '$',
				'depends_show_if_not' => 'off',
				'mobile_options'      => true,
			),
			// Button Icon Color
			'btn_two_icon_color'	=>	array(
				'label'               => esc_html__( 'Button Icon Color', 'et_builder'),
				'description'         => esc_html__( 'Here you can define a custom color for the button icon.', 'et_builder' ),
				'type'                => 'color-alpha',
				'tab_slug'            => 'advanced',
				'toggle_slug'         => 'button_icon',
				'sub_toggle'	  	  => 'sub_toggle_two',
				'custom_color'        => true,
				'default'			  => '#2857b6',
				'hover'               => 'tabs',
				'depends_show_if_not' => 'off',
				'mobile_options'      => true,
			),
			// Button Two Icon Placement
			'btn_two_icon_placement'	=>	array(
				'label'               => esc_html__( 'Button Icon Placement', 'et_builder' ),
				'description'         => esc_html__( 'Choose where the button icon should be displayed within the button.', 'et_builder' ),
				'type'                => 'select',
				'tab_slug'            => 'advanced',
				'toggle_slug'         => 'button_icon',
				'sub_toggle'	  	  => 'sub_toggle_two',
				'option_category'     => 'button',
				'options'             => array(
					'right' => esc_html__( 'Right', 'et_builder' ),
					'left'  => esc_html__( 'Left', 'et_builder' ),
				),
				'default'             => 'right',
				'depends_show_if_not' => 'off',
			),
			// Button Two Icon On Hover
			'btn_two_on_hover'	=>	array(
				'label'               => esc_html__( 'Only Show Icon On Hover for Button', 'et_builder' ),
				'description'         => esc_html__( 'By default, button icons are displayed on hover. If you would like button icons to always be displayed, then you can enable this option.', 'et_builder' ),
				'type'                => 'yes_no_button',
				'tab_slug'            => 'advanced',
				'toggle_slug'         => 'button_icon',
				'sub_toggle'	  	  => 'sub_toggle_two',
				'default'             => 'on',
				'options'             => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'depends_show_if_not' => 'off',
				'mobile_options'      => true,
			),
			// Button Background One
			'btn_one_show_hide'	=>	array(
				'label'          => esc_html__( 'Enable Background Color', 'et_builder' ),
				'type'           => 'yes_no_button',
				'toggle_slug'    => 'dnxt_button_one',
				'sub_toggle'	 => 'sub_toggle_color',
				'options'        => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'default'        => 'off',
			),
			'button_bg_one'		 => array(
				'label'          => esc_html__('Background Color', 'et_builder'),
				'description'	 => esc_html__('Pick a color to use for the button background.', 'et_builder' ),
                'type'           => 'color-alpha',
				'toggle_slug'    => 'dnxt_button_one',
				'sub_toggle'	 => 'sub_toggle_color',
				'default'        => '#29c4a9',
				'mobile_options' => true,
				'hover'			 =>	'tabs',
				'show_if'        => array(
                    'btn_one_show_hide' => 'on',
                ),
			),
			'btn_one_gradient_show_hide'	=>	array(
				'label'          => esc_html__( 'Enable Gradient Color', 'et_builder' ),
				'type'           => 'yes_no_button',
				'toggle_slug'    => 'dnxt_button_one',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'default'        => 'off',
				'options'        => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
			),
			'bg_one_gradient_color_one'        => array(
				'label'          => esc_html__( 'Select Color One', 'et_builder' ),
				'type'           => 'color-alpha',
				'toggle_slug'    => 'dnxt_button_one',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'default'        => '#2b87da',
				'show_if'        => array(
                    'btn_one_gradient_show_hide' => 'on',
                ),
			),
			'bg_one_gradient_color_two'        => array(
                'label'          => esc_html__( 'Select Color Two', 'et_builder' ),
                'type'           => 'color-alpha',
				'toggle_slug'    => 'dnxt_button_one',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'default'        => '#29c4a9',
				'show_if'        => array(
                    'btn_one_gradient_show_hide' => 'on',
                ),
			),
			'bg_one_gradient_type'             => array(
                'label'           => esc_html__('Select Gradient Type', 'et_builder'),
                'type'            => 'select',
				'description'     => esc_html__('Select the types of gradient', 'et_builder'),
                'option_category'=> 'basic_option',
				'toggle_slug'    => 'dnxt_button_one',
				'sub_toggle'	 => 'sub_toggle_gradient',
                'options'         => array(
                    'linear-gradient' => esc_html__('Linear', 'et_builder'),
                    'radial-gradient' => esc_html__('Radial', 'et_builder'),
                ),
				'default'         => 'linear-gradient',
				'show_if'        => array(
                    'btn_one_gradient_show_hide' => 'on',
                ),
			),
            'bg_one_gradient_type_linear_direction'   => array(
                'label'           => esc_html__('Gradient direction', 'et_builder'),
                'type'            => 'range',
                'option_category'=> 'basic_option',
				'toggle_slug'    => 'dnxt_button_one',
				'sub_toggle'	 => 'sub_toggle_gradient',
                'range_settings'  => array(
                            'step' => 1,
                            'min'  => 1,
                            'max'  => 360,
				),
                'default'         => '180deg',
                'fixed_unit'      => 'deg',
                'validate_unit'   => true,
				'show_if'        => array(
					'btn_one_gradient_show_hide' => 'on',
					'bg_one_gradient_type' => 'linear-gradient'
                ),
			),
			'bg_one_gradient_type_radial_direction'   => array(
                'label'           => esc_html__('Radial Direction', 'et_builder'),
                'type'            => 'select',
				'description'     => esc_html__('Select the types of gradient', 'et_builder'),                
                'option_category'=> 'basic_option',
				'toggle_slug'    => 'dnxt_button_one',
				'sub_toggle'	 => 'sub_toggle_gradient',
                'options'         => array(
                    'circle at center'       => esc_html__('Center', 'et_builder'),
                    'circle at left'         => esc_html__('Top Left', 'et_builder'),
                    'circle at top'          => esc_html__('Top', 'et_builder'),
                    'circle at top right'    => esc_html__('Top Right', 'et_builder'),
                    'circle at right'        => esc_html__('Right', 'et_builder'),
                    'circle at bottom right' => esc_html__('Bottom Right', 'et_builder'),
                    'circle at bottom'       => esc_html__('Bottom', 'et_builder'),
                    'circle at bottom left'  => esc_html__('Bottom Left', 'et_builder'),
                    'circle at left'         => esc_html__('Left', 'et_builder'),

                ),
                'default'         => 'circle at center',
				'show_if'        => array(
					'btn_one_gradient_show_hide' => 'on',
					'bg_one_gradient_type' => 'radial-gradient'
                ),
				
			),
			'bg_one_gradient_start_position'           => array(
                'label'           => esc_html__('Start Position', 'et_builder'),
                'type'            => 'range',
                'option_category' => 'basic_option',
				'toggle_slug'     => 'dnxt_button_one',
				'sub_toggle'	  => 'sub_toggle_gradient',
                'range_settings'  => array(
                    'step' => 1,
                    'min'  => 1,
                    'max'  => 100,
                ),
                'default'         => '0%',
                'fixed_unit'      => '%',
				'validate_unit'   => true,
				'show_if'        => array(
                    'btn_one_gradient_show_hide' => 'on',
                ),
			),
			'bg_one_gradient_end_position'             => array(
                'label'           => esc_html__('End Position', 'et_builder'),
                'type'            => 'range',
                'option_category' => 'basic_option',
				'toggle_slug'     => 'dnxt_button_one',
				'sub_toggle'	  => 'sub_toggle_gradient',
                'range_settings'  => array(
                        'step' => 1,
                        'min'  => 1,
                        'max'  => 100,
				),
                'default'         => '100%',
                'fixed_unit'      => '%',
				'validate_unit'   => true,
				'show_if'        => array(
                    'btn_one_gradient_show_hide' => 'on',
                ),
            ),
			// Button Background Two
			'btn_two_color_show_hide'	=>	array(
				'label'               => esc_html__( 'Enable Background Color', 'et_builder' ),
				'type'                => 'yes_no_button',
				'toggle_slug'    => 'dnxt_button_two',
				'sub_toggle'	 => 'sub_toggle_color',
				'options'        => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'default'        => 'off',
			),
			'button_bg_two'		=> array(
				'label'          => esc_html__('Background Color', 'et_builder'),
				'description'    => esc_html__( 'Pick a color to use for the button background.', 'et_builder' ),
                'type'           => 'color-alpha',
				'toggle_slug'    => 'dnxt_button_two',
				'sub_toggle'	 => 'sub_toggle_color',
				'hover'			 =>	'tabs',
				'default'        => '#29c4a9',
				'mobile_options' => true,
				'hover'			 =>	'tabs',
				'show_if'        => array(
                    'btn_two_color_show_hide' => 'on',
                ),
			),
			'btn_two_gradient_show_hide'	=>	array(
				'label'          => esc_html__( 'Enable Gradient Color', 'et_builder' ),
				'type'           => 'yes_no_button',
				'toggle_slug'    => 'dnxt_button_two',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'options'        => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'default'        => 'off',
			),
			'bg_two_gradient_color_one'        => array(
                'label'          => esc_html__('Select Color One', 'et_builder'),
                'type'           => 'color-alpha',
				'toggle_slug'    => 'dnxt_button_two',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'default'        => '#2b87da',
				'show_if'        => array(
                    'btn_two_gradient_show_hide' => 'on',
                ),
			),
			'bg_two_gradient_color_two'        => array(
                'label'          => esc_html__('Select Color Two', 'et_builder'),
                'type'           => 'color-alpha',
				'toggle_slug'    => 'dnxt_button_two',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'default'        => '#29c4a9',
				'show_if'        => array(
                    'btn_two_gradient_show_hide' => 'on',
                ),
			),
			'bg_two_gradient_type'                => array(
                'label'           => esc_html__('Select Gradient Type', 'et_builder'),
                'type'            => 'select',
				'description'     => esc_html__('Select the types of gradient', 'et_builder'),
                'option_category'=> 'basic_option',
				'toggle_slug'    => 'dnxt_button_two',
				'sub_toggle'	 => 'sub_toggle_gradient',
                'options'        => array(
                    'linear-gradient' => esc_html__('Linear', 'et_builder'),
                    'radial-gradient' => esc_html__('Radial', 'et_builder'),
                ),
				'default'         => 'linear-gradient',
				'show_if'        => array(
                    'btn_two_gradient_show_hide' => 'on',
                ),
			),
            'bg_two_gradient_type_linear_direction'   => array(
                'label'           => esc_html__('Gradient direction', 'et_builder'),
                'type'            => 'range',
                'option_category'=> 'basic_option',
				'toggle_slug'    => 'dnxt_button_two',
				'sub_toggle'	 => 'sub_toggle_gradient',
                'range_settings'  => array(
                    'step' => 1,
                    'min'  => 1,
                    'max'  => 360,
                ),
                'default'         => '180deg',
                'fixed_unit'      => 'deg',
                'validate_unit'   => true,
				'show_if'        => array(
					'btn_two_gradient_show_hide' => 'on',
					'bg_two_gradient_type'  => 'linear-gradient',
                ),
			),
			'bg_two_gradient_type_radial_direction'   => array(
                'label'           => esc_html__('Radial Direction', 'et_builder'),
                'type'            => 'select',
				'description'     => esc_html__('Select the types of gradient', 'et_builder'),                
				'option_category'=> 'basic_option',
				'toggle_slug'    => 'dnxt_button_two',
				'sub_toggle'	 => 'sub_toggle_gradient',
                'options'         => array(
                    'circle at center'       => esc_html__('Center', 'et_builder'),
                    'circle at left'         => esc_html__('Top Left', 'et_builder'),
                    'circle at top'          => esc_html__('Top', 'et_builder'),
                    'circle at top right'    => esc_html__('Top Right', 'et_builder'),
                    'circle at right'        => esc_html__('Right', 'et_builder'),
                    'circle at bottom right' => esc_html__('Bottom Right', 'et_builder'),
                    'circle at bottom'       => esc_html__('Bottom', 'et_builder'),
                    'circle at bottom left'  => esc_html__('Bottom Left', 'et_builder'),
                    'circle at left'         => esc_html__('Left', 'et_builder'),
                ),
                'default'         => 'circle at center',
				'show_if'        => array(
					'btn_two_gradient_show_hide' => 'on',
					'bg_two_gradient_type'  => 'radial-gradient',
                ),
            ),
			'bg_two_gradient_start_position'           => array(
                'label'           => esc_html__('Start Position', 'et_builder'),
                'type'            => 'range',
				'option_category'=> 'basic_option',
				'toggle_slug'    => 'dnxt_button_two',
				'sub_toggle'	 => 'sub_toggle_gradient',
                'range_settings'  => array(
                    'step' => 1,
                    'min'  => 1,
                    'max'  => 100,
                ),
                'default'         => '0%',
                'fixed_unit'      => '%',
				'validate_unit'   => true,
				'show_if'        => array(
					'btn_two_gradient_show_hide' => 'on',
                ),
			),
			'bg_two_gradient_end_position'             => array(
                'label'           => esc_html__('End Position', 'et_builder'),
                'type'            => 'range',
				'option_category'=> 'basic_option',
				'toggle_slug'    => 'dnxt_button_two',
				'sub_toggle'	 => 'sub_toggle_gradient',
                'range_settings'  => array(
                        'step' => 1,
                        'min'  => 1,
                        'max'  => 100,
				),
                'default'         => '100%',
                'fixed_unit'      => '%',
				'validate_unit'   => true,
				'show_if'        => array(
					'btn_two_gradient_show_hide' => 'on',
                ),
			),
			//Button One Margin
			'button_one_margin'		=> array(
                'label'           => esc_html__('Button Margin', 'et_builder'),
                'description'     => esc_html__('This margin adds extra space to the outside of the button one, increasing the distance between the other button and other items on the page.', 'et_builder'),
                'type'            => 'custom_margin',
                'mobile_options'  => true,
                'responsive'      => true,
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'button_spacing',
                'sub_toggle'      => 'sub_toggle_one',
            ),
			//Button One Padding
			'button_one_padding'		=> array(
				'label'           => esc_html__('Button Padding', 'et_builder'),
				'description'     => esc_html__('Padding adds extra space to the inside of the button one, increasing the distance between the edge of the button and its inner contents.', 'et_builder'),
                'type'            => 'custom_margin',
                'mobile_options'  => true,
                'responsive'      => true,
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'button_spacing',
                'sub_toggle'      => 'sub_toggle_one',
            ),
			//Button Two Margin
			'button_two_margin'		=> array(
				'label'           => esc_html__('Button Margin', 'et_builder'),
				'description'     => esc_html__('This margin adds extra space to the outside of the button two, increasing the distance between the other button and other items on the page.', 'et_builder'),
                'type'            => 'custom_margin',
                'mobile_options'  => true,
                'responsive'      => true,
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'button_spacing',
                'sub_toggle'      => 'sub_toggle_two',
            ),
			//Button Two Padding
			'button_two_padding'		=> array(
				'label'           => esc_html__('Button Padding', 'et_builder'),
				'description'     => esc_html__('Padding adds extra space to the inside of the button two, increasing the distance between the edge of the button and its inner contents.', 'et_builder'),
                'type'            => 'custom_margin',
                'mobile_options'  => true,
                'responsive'      => true,
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'button_spacing',
                'sub_toggle'      => 'sub_toggle_two',
			),
			// Button One Hover 2D
			'dnxt_dual_one_hover_2d'     => array(
				'label'             => esc_html__( 'Select 2D Hover Effect', 'et_builder' ),
				'type'              => 'select',
				'option_category'   => 'configuration',
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'button_one_hover',
				'sub_toggle'		=> 'sub_toggle_2d',
				'default'           => '',
				'description'       => esc_html__( 'Here you can adjust the hover effect.', 'et_builder' ),
				'options'           => array(
					''               		 =>  esc_html__( 'Select', 'et_builder' ),
					'dnxt-hover-backward'               =>  esc_html__( 'Backward', 'et_builder' ),
					'dnxt-hover-bob'                    =>  esc_html__( 'Bob', 'et_builder' ),
					'dnxt-hover-bounce-in'              =>  esc_html__( 'Bounce In', 'et_builder' ),
					'dnxt-hover-bounce-out'             =>  esc_html__( 'Bounce Out', 'et_builder' ),
					'dnxt-hover-buzz'                   =>  esc_html__( 'Buzz', 'et_builder' ),
					'dnxt-hover-buzz-out'               =>  esc_html__( 'Buzz Out', 'et_builder' ),
					'dnxt-hover-float'                  =>  esc_html__( 'Float', 'et_builder' ),
					'dnxt-hover-forward'                =>  esc_html__( 'Forward', 'et_builder' ),
					'dnxt-hover-grow'                   =>  esc_html__( 'Grow', 'et_builder' ),
					'dnxt-hover-grow-rotate'            =>  esc_html__( 'Grow Rotate', 'et_builder' ),
					'dnxt-hover-hang'                   =>  esc_html__( 'Hang', 'et_builder' ),
					'dnxt-hover-pop'                    =>  esc_html__( 'Pop', 'et_builder' ),
					'dnxt-hover-pulse'                  =>  esc_html__( 'Pulse', 'et_builder' ),
					'dnxt-hover-pulse-grow'             =>  esc_html__( 'Pulse Grow', 'et_builder' ),
					'dnxt-hover-pulse-shrink'           =>  esc_html__( 'Pulse Shrink', 'et_builder' ),
					'dnxt-hover-push'                   =>  esc_html__( 'Push', 'et_builder' ),
					'dnxt-hover-rotate'                 =>  esc_html__( 'Rotate', 'et_builder' ),
					'dnxt-hover-shrink'                 =>  esc_html__( 'Shrink', 'et_builder' ),
					'dnxt-hover-sink'                   =>  esc_html__( 'Sink', 'et_builder' ),
					'dnxt-hover-skew'                   =>  esc_html__( 'Skew', 'et_builder' ),
					'dnxt-hover-skew-backward'          =>  esc_html__( 'Skew Backward', 'et_builder' ),
					'dnxt-hover-skew-forward'           =>  esc_html__( 'Skew Forward', 'et_builder' ),
					'dnxt-hover-wobble-bottom'          =>  esc_html__( 'Wobble Bottom', 'et_builder' ),
					'dnxt-hover-wobble-horizontal'      =>  esc_html__( 'Wobble Horizontal', 'et_builder' ),
					'dnxt-hover-wobble-skew'            =>  esc_html__( 'Wobble Skew', 'et_builder' ),
					'dnxt-hover-wobble-top'             =>  esc_html__( 'Wobble Top', 'et_builder' ),
					'dnxt-hover-wobble-to-bottom-right' =>  esc_html__( 'Wobble To Bottom Right', 'et_builder' ),
					'dnxt-hover-wobble-to-top-right'    =>  esc_html__( 'Wobble To Top Right', 'et_builder' ),
					'dnxt-hover-wobble-vertical'        =>  esc_html__( 'Wobble Vertical', 'et_builder' ),
				),
				'mobile_options'      => true,
			),
			// Button Two Hover 2D
			'dnxt_dual_two_hover_2d'     => array(
				'label'             => esc_html__( 'Select 2D Hover Effect', 'et_builder' ),
				'type'              => 'select',
				'option_category'   => 'configuration',
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'button_two_hover',
				'sub_toggle'		=> 'sub_toggle_2d',
				'default'           => '',
				'description'       => esc_html__( 'Here you can adjust the hover effect.', 'et_builder' ),
				'options'           => array(
					''               		 =>  esc_html__( 'Select', 'et_builder' ),
					'dnxt-hover-backward'               =>  esc_html__( 'Backward', 'et_builder' ),
					'dnxt-hover-bob'                    =>  esc_html__( 'Bob', 'et_builder' ),
					'dnxt-hover-bounce-in'              =>  esc_html__( 'Bounce In', 'et_builder' ),
					'dnxt-hover-bounce-out'             =>  esc_html__( 'Bounce Out', 'et_builder' ),
					'dnxt-hover-buzz'                   =>  esc_html__( 'Buzz', 'et_builder' ),
					'dnxt-hover-buzz-out'               =>  esc_html__( 'Buzz Out', 'et_builder' ),
					'dnxt-hover-float'                  =>  esc_html__( 'Float', 'et_builder' ),
					'dnxt-hover-forward'                =>  esc_html__( 'Forward', 'et_builder' ),
					'dnxt-hover-grow'                   =>  esc_html__( 'Grow', 'et_builder' ),
					'dnxt-hover-grow-rotate'            =>  esc_html__( 'Grow Rotate', 'et_builder' ),
					'dnxt-hover-hang'                   =>  esc_html__( 'Hang', 'et_builder' ),
					'dnxt-hover-pop'                    =>  esc_html__( 'Pop', 'et_builder' ),
					'dnxt-hover-pulse'                  =>  esc_html__( 'Pulse', 'et_builder' ),
					'dnxt-hover-pulse-grow'             =>  esc_html__( 'Pulse Grow', 'et_builder' ),
					'dnxt-hover-pulse-shrink'           =>  esc_html__( 'Pulse Shrink', 'et_builder' ),
					'dnxt-hover-push'                   =>  esc_html__( 'Push', 'et_builder' ),
					'dnxt-hover-rotate'                 =>  esc_html__( 'Rotate', 'et_builder' ),
					'dnxt-hover-shrink'                 =>  esc_html__( 'Shrink', 'et_builder' ),
					'dnxt-hover-sink'                   =>  esc_html__( 'Sink', 'et_builder' ),
					'dnxt-hover-skew'                   =>  esc_html__( 'Skew', 'et_builder' ),
					'dnxt-hover-skew-backward'          =>  esc_html__( 'Skew Backward', 'et_builder' ),
					'dnxt-hover-skew-forward'           =>  esc_html__( 'Skew Forward', 'et_builder' ),
					'dnxt-hover-wobble-bottom'          =>  esc_html__( 'Wobble Bottom', 'et_builder' ),
					'dnxt-hover-wobble-horizontal'      =>  esc_html__( 'Wobble Horizontal', 'et_builder' ),
					'dnxt-hover-wobble-skew'            =>  esc_html__( 'Wobble Skew', 'et_builder' ),
					'dnxt-hover-wobble-top'             =>  esc_html__( 'Wobble Top', 'et_builder' ),
					'dnxt-hover-wobble-to-bottom-right' =>  esc_html__( 'Wobble To Bottom Right', 'et_builder' ),
					'dnxt-hover-wobble-to-top-right'    =>  esc_html__( 'Wobble To Top Right', 'et_builder' ),
					'dnxt-hover-wobble-vertical'        =>  esc_html__( 'Wobble Vertical', 'et_builder' ),
				),
				'mobile_options'      => true,
			),
			// Button One Hover Effect
			'dnxt_dual_one_hover_bg'     => array(
				'label'             => esc_html__( 'Select Background Hover Effect', 'et_builder' ),
				'type'              => 'select',
				'option_category'   => 'configuration',
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'button_one_hover',
				'sub_toggle'		=> 'sub_toggle_bg',
				'default'           => '',
				'description'       => esc_html__( 'Here you can adjust the hover effect.', 'et_builder' ),
				'options'           => array(
					''						 =>  esc_html__( 'Select', 'et_builder' ),
					'dnxt-hover-fade'					 =>  esc_html__( 'Fade', 'et_builder' ),
					'dnxt-hover-sweep-to-right'         =>  esc_html__( 'Sweep To Right', 'et_builder' ),
					'dnxt-hover-sweep-to-left'          =>  esc_html__( 'Sweep To Left', 'et_builder' ),
					'dnxt-hover-sweep-to-bottom'        =>  esc_html__( 'Sweep To Bottom', 'et_builder' ),
					'dnxt-hover-sweep-to-top'           =>  esc_html__( 'Sweep To Top', 'et_builder' ),
					'dnxt-hover-bounce-to-right'        =>  esc_html__( 'Bounce To Right', 'et_builder' ),
					'dnxt-hover-bounce-to-left'         =>  esc_html__( 'Bounce To Left', 'et_builder' ),
					'dnxt-hover-bounce-to-bottom'       =>  esc_html__( 'Bounce To Bottom', 'et_builder' ),
					'dnxt-hover-bounce-to-top'          =>  esc_html__( 'Bounce To Top', 'et_builder' ),
					'dnxt-hover-radial-out'             =>  esc_html__( 'Radial Out', 'et_builder' ),
					'dnxt-hover-radial-in'              =>  esc_html__( 'Radial In', 'et_builder' ),
					'dnxt-hover-rectangle-in'           =>  esc_html__( 'Rectangle In', 'et_builder' ),
					'dnxt-hover-rectangle-out'          =>  esc_html__( 'Rectangle Out', 'et_builder' ),
					'dnxt-hover-shutter-in-horizontal'  =>  esc_html__( 'Shutter In Horizontal', 'et_builder' ),
					'dnxt-hover-shutter-out-horizontal' =>  esc_html__( 'Shutter Out Horizontal', 'et_builder' ),
					'dnxt-hover-shutter-in-vertical'    =>  esc_html__( 'Shutter In Vertical', 'et_builder' ),
					'dnxt-hover-shutter-out-vertical'   =>  esc_html__( 'Shutter Out Vertical', 'et_builder' ),
				),
				'mobile_options'      => true,
			),			
			'dnxt_dual_one_radial_out_bg_color'        => array(
				'label'          => esc_html__( 'Background Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Background.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_one_hover',
				'sub_toggle'	 => 'sub_toggle_bg',
				'default'        => 'rgba(0,0,0,0.3)',
				'mobile_options' => true,
				'show_if'         => array(
					'dnxt_dual_one_hover_bg' => 'dnxt-hover-radial-out',
				),
			),
			'dnxt_dual_one_radial_in_bg_color'        => array(
				'label'          => esc_html__( 'Background Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Background.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_one_hover',
				'sub_toggle'	 => 'sub_toggle_bg',
				'default'        => 'rgba(0,0,0,0.3)',
				'mobile_options' => true,
				'show_if'         => array(
					'dnxt_dual_one_hover_bg' => 'dnxt-hover-radial-in',
				),
			),
			'dnxt_dual_one_rectangle_in_bg_color'        => array(
				'label'          => esc_html__( 'Background Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Background.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_one_hover',
				'sub_toggle'	 => 'sub_toggle_bg',
				'default'        => 'rgba(0,0,0,0.3)',
				'mobile_options' => true,
				'show_if'         => array(
					'dnxt_dual_one_hover_bg' => 'dnxt-hover-rectangle-in',
				),
			),
			'dnxt_dual_one_rectangle_out_bg_color'        => array(
				'label'          => esc_html__( 'Background Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Background.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_one_hover',
				'sub_toggle'	 => 'sub_toggle_bg',
				'default'        => 'rgba(0,0,0,0.3)',
				'mobile_options' => true,
				'show_if'         => array(
					'dnxt_dual_one_hover_bg' => 'dnxt-hover-rectangle-out',
				),
			),
			'dnxt_dual_one_shutter_in_bg_color'        => array(
				'label'          => esc_html__( 'Background Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Background.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_one_hover',
				'sub_toggle'	 => 'sub_toggle_bg',
				'default'        => 'rgba(0,0,0,0.3)',
				'mobile_options' => true,
				'show_if'         => array(
					'dnxt_dual_one_hover_bg' => 'dnxt-hover-shutter-in-horizontal',
				),
			),
			'dnxt_dual_one_shutter_out_bg_color'        => array(
				'label'          => esc_html__( 'Background Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Background.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_one_hover',
				'sub_toggle'	 => 'sub_toggle_bg',
				'default'        => 'rgba(0,0,0,0.3)',
				'mobile_options' => true,
				'show_if'         => array(
					'dnxt_dual_one_hover_bg' => 'dnxt-hover-shutter-out-horizontal',
				),
			),
			'dnxt_dual_one_shutter_in_v_bg_color'        => array(
				'label'          => esc_html__( 'Background Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Background.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_one_hover',
				'sub_toggle'	 => 'sub_toggle_bg',
				'default'        => 'rgba(0,0,0,0.3)',
				'mobile_options' => true,
				'show_if'         => array(
					'dnxt_dual_one_hover_bg' => 'dnxt-hover-shutter-in-vertical',
				),
			),
			'dnxt_dual_one_shutter_out_v_bg_color'        => array(
				'label'          => esc_html__( 'Background Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Background.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_one_hover',
				'sub_toggle'	 => 'sub_toggle_bg',
				'default'        => 'rgba(0,0,0,0.3)',
				'mobile_options' => true,
				'show_if'         => array(
					'dnxt_dual_one_hover_bg' => 'dnxt-hover-shutter-out-vertical',
				),
			),
			// Button Hover BG Color
			'dnxt_dual_one_hover_bg_color'        => array(
				'label'          => esc_html__('Select Background Hover Color', 'et_builder'),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_one_hover',
				'sub_toggle'	 => 'sub_toggle_bg',
				'default'        => '#29c4a9',
			),
			// Button Two Hover Effect
			'dnxt_dual_two_hover_bg'     => array(
				'label'             => esc_html__( 'Select Background Hover Effect', 'et_builder' ),
				'type'              => 'select',
				'option_category'   => 'configuration',
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'button_two_hover',
				'sub_toggle'		=> 'sub_toggle_bg',
				'default'           => '',
				'description'       => esc_html__( 'Here you can adjust the hover effect.', 'et_builder' ),
				'options'           => array(
					''						 =>  esc_html__( 'Select', 'et_builder' ),
					'dnxt-hover-fade'					 =>  esc_html__( 'Fade', 'et_builder' ),
					'dnxt-hover-sweep-to-right'         =>  esc_html__( 'Sweep To Right', 'et_builder' ),
					'dnxt-hover-sweep-to-left'          =>  esc_html__( 'Sweep To Left', 'et_builder' ),
					'dnxt-hover-sweep-to-bottom'        =>  esc_html__( 'Sweep To Bottom', 'et_builder' ),
					'dnxt-hover-sweep-to-top'           =>  esc_html__( 'Sweep To Top', 'et_builder' ),
					'dnxt-hover-bounce-to-right'        =>  esc_html__( 'Bounce To Right', 'et_builder' ),
					'dnxt-hover-bounce-to-left'         =>  esc_html__( 'Bounce To Left', 'et_builder' ),
					'dnxt-hover-bounce-to-bottom'       =>  esc_html__( 'Bounce To Bottom', 'et_builder' ),
					'dnxt-hover-bounce-to-top'          =>  esc_html__( 'Bounce To Top', 'et_builder' ),
					'dnxt-hover-radial-out'             =>  esc_html__( 'Radial Out', 'et_builder' ),
					'dnxt-hover-radial-in'              =>  esc_html__( 'Radial In', 'et_builder' ),
					'dnxt-hover-rectangle-in'           =>  esc_html__( 'Rectangle In', 'et_builder' ),
					'dnxt-hover-rectangle-out'          =>  esc_html__( 'Rectangle Out', 'et_builder' ),
					'dnxt-hover-shutter-in-horizontal'  =>  esc_html__( 'Shutter In Horizontal', 'et_builder' ),
					'dnxt-hover-shutter-out-horizontal' =>  esc_html__( 'Shutter Out Horizontal', 'et_builder' ),
					'dnxt-hover-shutter-in-vertical'    =>  esc_html__( 'Shutter In Vertical', 'et_builder' ),
					'dnxt-hover-shutter-out-vertical'   =>  esc_html__( 'Shutter Out Vertical', 'et_builder' ),
				),
				'mobile_options'      => true,
			),
			'dnxt_dual_two_radial_out_bg_color'        => array(
				'label'          => esc_html__( 'Background Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Background.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_two_hover',
				'sub_toggle'	 => 'sub_toggle_bg',
				'default'        => 'rgba(0,0,0,0.3)',
				'mobile_options' => true,
				'show_if'         => array(
					'dnxt_dual_two_hover_bg' => 'dnxt-hover-radial-out',
				),
			),
			'dnxt_dual_two_radial_in_bg_color'        => array(
				'label'          => esc_html__( 'Background Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Background.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_two_hover',
				'sub_toggle'	 => 'sub_toggle_bg',
				'default'        => 'rgba(0,0,0,0.3)',
				'mobile_options' => true,
				'show_if'         => array(
					'dnxt_dual_two_hover_bg' => 'dnxt-hover-radial-in',
				),
			),
			'dnxt_dual_two_rectangle_in_bg_color'        => array(
				'label'          => esc_html__( 'Background Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Background.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_two_hover',
				'sub_toggle'	 => 'sub_toggle_bg',
				'default'        => 'rgba(0,0,0,0.3)',
				'mobile_options' => true,
				'show_if'         => array(
					'dnxt_dual_two_hover_bg' => 'dnxt-hover-rectangle-in',
				),
			),
			'dnxt_dual_two_rectangle_out_bg_color'        => array(
				'label'          => esc_html__( 'Background Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Background.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_two_hover',
				'sub_toggle'	 => 'sub_toggle_bg',
				'default'        => 'rgba(0,0,0,0.3)',
				'mobile_options' => true,
				'show_if'         => array(
					'dnxt_dual_two_hover_bg' => 'dnxt-hover-rectangle-out',
				),
			),
			'dnxt_dual_two_shutter_in_bg_color'        => array(
				'label'          => esc_html__( 'Background Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Background.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_two_hover',
				'sub_toggle'	 => 'sub_toggle_bg',
				'default'        => 'rgba(0,0,0,0.3)',
				'mobile_options' => true,
				'show_if'         => array(
					'dnxt_dual_two_hover_bg' => 'dnxt-hover-shutter-in-horizontal',
				),
			),
			'dnxt_dual_two_shutter_out_bg_color'        => array(
				'label'          => esc_html__( 'Background Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Background.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_two_hover',
				'sub_toggle'	 => 'sub_toggle_bg',
				'default'        => 'rgba(0,0,0,0.3)',
				'mobile_options' => true,
				'show_if'         => array(
					'dnxt_dual_two_hover_bg' => 'dnxt-hover-shutter-out-horizontal',
				),
			),
			'dnxt_dual_two_shutter_in_v_bg_color'	=> array(
				'label'          => esc_html__( 'Background Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Background.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_two_hover',
				'sub_toggle'	 => 'sub_toggle_bg',
				'default'        => 'rgba(0,0,0,0.3)',
				'mobile_options' => true,
				'show_if'         => array(
					'dnxt_dual_two_hover_bg' => 'dnxt-hover-shutter-in-vertical',
				),
			),
			'dnxt_dual_two_shutter_out_v_bg_color'	=> array(
				'label'          => esc_html__( 'Background Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Background.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_two_hover',
				'sub_toggle'	 => 'sub_toggle_bg',
				'default'        => 'rgba(0,0,0,0.3)',
				'mobile_options' => true,
				'show_if'         => array(
					'dnxt_dual_two_hover_bg' => 'dnxt-hover-shutter-out-vertical',
				),
			),
			// Button Two Hover BG Color
			'dnxt_dual_two_hover_bg_color'        => array(
				'label'          => esc_html__('Select Background Hover Color', 'et_builder'),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_two_hover',
				'sub_toggle'	 => 'sub_toggle_bg',
				'default'        => '#29c4a9',
			),
			// Button Hover Strock
			'dnxt_dual_one_hover_border'     => array(
				'label'             => esc_html__( 'Select Stroke Hover Effect', 'et_builder' ),
				'type'              => 'select',
				'option_category'   => 'configuration',
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'button_one_hover',
				'sub_toggle'		=> 'sub_toggle_border',
				'default'           => '',
				'description'       => esc_html__( 'Here you can adjust the hover effect.', 'et_builder' ),
				'options'           => array(
					''									=>  esc_html__( 'Select', 'et_builder' ),
					'dnxt-hover-trim'         			=>  esc_html__( 'Trim', 'et_builder' ),
					'dnxt-hover-ripple-out'         	=>  esc_html__( 'Ripple Out', 'et_builder' ),
					'dnxt-hover-ripple-in'        		=>  esc_html__( 'Ripple In', 'et_builder' ),
					'dnxt-hover-underline-from-left'   	=>  esc_html__( 'Underline From Left', 'et_builder' ),
					'dnxt-hover-underline-from-center' 	=>  esc_html__( 'Underline From Center', 'et_builder' ),
					'dnxt-hover-underline-from-right'  	=>  esc_html__( 'Underline From Right', 'et_builder' ),
					'dnxt-hover-reveal'              	=>  esc_html__( 'Reveal', 'et_builder' ),
					'dnxt-hover-underline-reveal'      	=>  esc_html__( 'Underline Reveal', 'et_builder' ),
					'dnxt-hover-overline-reveal'       	=>  esc_html__( 'Overline Reveal', 'et_builder' ),
					'dnxt-hover-overline-from-left'  	=>  esc_html__( 'Overline From Left', 'et_builder' ),
					'dnxt-hover-overline-from-center' 	=>  esc_html__( 'Overline From Center', 'et_builder' ),
					'dnxt-hover-overline-from-right'   	=>  esc_html__( 'Overline From Right', 'et_builder' ),
				),
				'mobile_options'      => true,
			),
			// Button Trim Border Color
			'dnxt_dual_one_trim_border_color'        => array(
				'label'          => esc_html__( 'Border Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Border.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_one_hover',
				'sub_toggle'	 => 'sub_toggle_border',
				'default'        => 'rgba(0,0,0,0.3)',
				'mobile_options' => true,
				'show_if'         => array(
					'dnxt_dual_one_hover_border' => 'dnxt-hover-trim',
				),
			),
			// Button Hover Ripple Out Border Color
			'dnxt_dual_one_ripple_out_color'        => array(
				'label'          => esc_html__( 'Border Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Border.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_one_hover',
				'sub_toggle'	 => 'sub_toggle_border',
				'default'        => 'rgba(0,0,0,0.3)',
				'mobile_options' => true,
				'show_if'         => array(
					'dnxt_dual_one_hover_border' => 'dnxt-hover-ripple-out',
				),
			),
			// Button Hover Ripple In Border Color
			'dnxt_dual_one_ripple_in_color'        => array(
				'label'          => esc_html__( 'Border Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Border.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_one_hover',
				'sub_toggle'	 => 'sub_toggle_border',
				'default'        => 'rgba(0,0,0,0.3)',
				'mobile_options' => true,
				'show_if'        => array(
					'dnxt_dual_one_hover_border' => 'dnxt-hover-ripple-in',
				),
			),
			// Button Hover Underline From Left Border Color
			'dnxt_dual_one_underline_from_left_color'        => array(
				'label'          => esc_html__( 'Border Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Border.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_one_hover',
				'sub_toggle'	 => 'sub_toggle_border',
				'default'        => 'rgba(0,0,0,0.3)',
				'mobile_options' => true,
				'show_if'         => array(
					'dnxt_dual_one_hover_border' => 'dnxt-hover-underline-from-left',
				),
			),
			// Button Hover Underline From Center Border Color
			'dnxt_dual_one_underline_from_center_color'        => array(
				'label'          => esc_html__( 'Border Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Border.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_one_hover',
				'sub_toggle'	 => 'sub_toggle_border',
				'default'        => 'rgba(0,0,0,0.3)',
				'mobile_options' => true,
				'show_if'        => array(
					'dnxt_dual_one_hover_border' => 'dnxt-hover-underline-from-center',
				),
			),
			// Button Hover Underline From Right Border Color
			'dnxt_dual_one_underline_from_right_color'        => array(
				'label'          => esc_html__( 'Border Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Border.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_one_hover',
				'sub_toggle'	 => 'sub_toggle_border',
				'default'        => 'rgba(0,0,0,0.3)',
				'mobile_options' => true,
				'show_if'         => array(
					'dnxt_dual_one_hover_border' => 'dnxt-hover-underline-from-right',
				),
			),
			// Button Hover Overline From Left Border Color
			'dnxt_dual_one_overline_left_color'        => array(
				'label'          => esc_html__( 'Border Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Border.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_one_hover',
				'sub_toggle'	 => 'sub_toggle_border',
				'default'        => 'rgba(0,0,0,0.3)',
				'mobile_options' => true,
				'show_if'         => array(
					'dnxt_dual_one_hover_border' => 'dnxt-hover-overline-from-left',
				),
			),
			// Button Hover Overline From Center Border Color
			'dnxt_dual_one_overline_center_color'        => array(
				'label'          => esc_html__( 'Border Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Border.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_one_hover',
				'sub_toggle'	 => 'sub_toggle_border',
				'default'        => 'rgba(0,0,0,0.3)',
				'mobile_options' => true,
				'show_if'         => array(
					'dnxt_dual_one_hover_border' => 'dnxt-hover-overline-from-center',
				),
			),
			// Button Hover Overline From Right Border Color
			'dnxt_dual_one_overline_right_color'        => array(
				'label'          => esc_html__( 'Border Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Border.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_one_hover',
				'sub_toggle'	 => 'sub_toggle_border',
				'default'        => 'rgba(0,0,0,0.3)',
				'mobile_options' => true,
				'show_if'         => array(
					'dnxt_dual_one_hover_border' => 'dnxt-hover-overline-from-right',
				),
			),
			// Button Hover Reveal Border Color
			'dnxt_dual_one_reveal_color'        => array(
				'label'          => esc_html__( 'Border Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Border.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_one_hover',
				'sub_toggle'	 => 'sub_toggle_border',
				'default'        => 'rgba(0,0,0,0.3)',
				'mobile_options' => true,
				'show_if'         => array(
					'dnxt_dual_one_hover_border' => 'dnxt-hover-reveal',
				),
			),
			// Button Hover Underline Reveal Border Color
			'dnxt_dual_one_underline_reveal_color'        => array(
				'label'          => esc_html__( 'Border Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Border.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_one_hover',
				'sub_toggle'	 => 'sub_toggle_border',
				'default'        => 'rgba(0,0,0,0.3)',
				'mobile_options' => true,
				'show_if'         => array(
					'dnxt_dual_one_hover_border' => 'dnxt-hover-underline-reveal',
				),
			),
			// Button Hover Overline Reveal Border Color
			'dnxt_dual_one_overline_reveal_color'        => array(
				'label'          => esc_html__( 'Border Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Border.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_one_hover',
				'sub_toggle'	 => 'sub_toggle_border',
				'default'        => 'rgba(0,0,0,0.3)',
				'mobile_options' => true,
				'show_if'         => array(
					'dnxt_dual_one_hover_border' => 'dnxt-hover-overline-reveal',
				),
			),
			// Button Hover Overline Reveal Border Color
			'dnxt_dual_one_overline_reveal_color'        => array(
				'label'          => esc_html__( 'Border Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Border.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_one_hover',
				'sub_toggle'	 => 'sub_toggle_border',
				'default'        => 'rgba(0,0,0,0.3)',
				'mobile_options' => true,
				'show_if'         => array(
					'dnxt_dual_one_hover_border' => 'dnxt-hover-overline-reveal',
				),
			),
			// Button Hover Strock
			'dnxt_dual_two_hover_border'     => array(
				'label'             => esc_html__( 'Select Stroke Hover Effect', 'et_builder' ),
				'type'              => 'select',
				'option_category'   => 'configuration',
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'button_two_hover',
				'sub_toggle'		=> 'sub_toggle_border',
				'default'           => '',
				'description'       => esc_html__( 'Here you can adjust the hover effect.', 'et_builder' ),
				'options'           => array(
					''									=>  esc_html__( 'Select', 'et_builder' ),
					'dnxt-hover-trim'         			=>  esc_html__( 'Trim', 'dnxt-divi-next-button' ),
					'dnxt-hover-ripple-out'         	=>  esc_html__( 'Ripple Out', 'dnxt-divi-next-button' ),
					'dnxt-hover-ripple-in'        		=>  esc_html__( 'Ripple In', 'dnxt-divi-next-button' ),
					'dnxt-hover-underline-from-left'    =>  esc_html__( 'Underline From Left', 'dnxt-divi-next-button' ),
					'dnxt-hover-underline-from-center'  =>  esc_html__( 'Underline From Center', 'dnxt-divi-next-button' ),
					'dnxt-hover-underline-from-right'   =>  esc_html__( 'Underline From Right', 'dnxt-divi-next-button' ),
					'dnxt-hover-reveal'              	=>  esc_html__( 'Reveal', 'dnxt-divi-next-button' ),
					'dnxt-hover-underline-reveal'       =>  esc_html__( 'Underline Reveal', 'dnxt-divi-next-button' ),
					'dnxt-hover-overline-reveal'        =>  esc_html__( 'Overline Reveal', 'dnxt-divi-next-button' ),
					'dnxt-hover-overline-from-left'  	=>  esc_html__( 'Overline From Left', 'dnxt-divi-next-button' ),
					'dnxt-hover-overline-from-center' 	=>  esc_html__( 'Overline From Center', 'dnxt-divi-next-button' ),
					'dnxt-hover-overline-from-right'    =>  esc_html__( 'Overline From Right', 'dnxt-divi-next-button' ),
				),
				'mobile_options'      => true,
			),
			// Button Trim Border Color
			'dnxt_dual_two_trim_border_color'        => array(
				'label'          => esc_html__( 'Border Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Border.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_two_hover',
				'sub_toggle'	 => 'sub_toggle_border',
				'default'        => 'rgba(0,0,0,0.3)',
				'mobile_options' => true,
				'show_if'         => array(
					'dnxt_dual_two_hover_border' => 'dnxt-hover-trim',
				),
			),
			// Button Hover Ripple Out Border Color
			'dnxt_dual_two_ripple_out_color'        => array(
				'label'          => esc_html__( 'Border Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Border.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_two_hover',
				'sub_toggle'	 => 'sub_toggle_border',
				'default'        => 'rgba(0,0,0,0.3)',
				'mobile_options' => true,
				'show_if'         => array(
					'dnxt_dual_two_hover_border' => 'dnxt-hover-ripple-out',
				),
			),
			// Button Hover Ripple In Border Color
			'dnxt_dual_two_ripple_in_color'        => array(
				'label'          => esc_html__( 'Border Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Border.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_two_hover',
				'sub_toggle'	 => 'sub_toggle_border',
				'default'        => 'rgba(0,0,0,0.3)',
				'mobile_options' => true,
				'show_if'         => array(
					'dnxt_dual_two_hover_border' => 'dnxt-hover-ripple-in',
				),
			),
			// Button Hover Underline From Left Border Color
			'dnxt_dual_two_underline_from_left_color'        => array(
				'label'          => esc_html__( 'Border Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Border.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_two_hover',
				'sub_toggle'	 => 'sub_toggle_border',
				'default'        => 'rgba(0,0,0,0.3)',
				'mobile_options' => true,
				'show_if'         => array(
					'dnxt_dual_two_hover_border' => 'dnxt-hover-underline-from-left',
				),
			),
			// Button Hover Underline From Center Border Color
			'dnxt_dual_two_underline_from_center_color'        => array(
				'label'          => esc_html__( 'Border Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Border.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_two_hover',
				'sub_toggle'	 => 'sub_toggle_border',
				'default'        => 'rgba(0,0,0,0.3)',
				'mobile_options' => true,
				'show_if'         => array(
					'dnxt_dual_two_hover_border' => 'dnxt-hover-underline-from-center',
				),
			),
			// Button Hover Underline From Right Border Color
			'dnxt_dual_two_underline_from_right_color'        => array(
				'label'          => esc_html__( 'Border Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Border.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_two_hover',
				'sub_toggle'	 => 'sub_toggle_border',
				'default'        => 'rgba(0,0,0,0.3)',
				'mobile_options' => true,
				'show_if'         => array(
					'dnxt_dual_two_hover_border' => 'dnxt-hover-underline-from-right',
				),
			),
			// Button Hover Overline From Left Border Color
			'dnxt_dual_two_overline_left_color'        => array(
				'label'          => esc_html__( 'Border Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Border.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_two_hover',
				'sub_toggle'	 => 'sub_toggle_border',
				'default'        => 'rgba(0,0,0,0.3)',
				'mobile_options' => true,
				'show_if'         => array(
					'dnxt_dual_two_hover_border' => 'dnxt-hover-overline-from-left',
				),
			),
			// Button Hover Overline From Center Border Color
			'dnxt_dual_two_overline_center_color'        => array(
				'label'          => esc_html__( 'Border Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Border.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_two_hover',
				'sub_toggle'	 => 'sub_toggle_border',
				'default'        => 'rgba(0,0,0,0.3)',
				'mobile_options' => true,
				'show_if'         => array(
					'dnxt_dual_two_hover_border' => 'dnxt-hover-overline-from-center',
				),
			),
			// Button Hover Overline From Right Border Color
			'dnxt_dual_two_overline_right_color'        => array(
				'label'          => esc_html__( 'Border Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Border.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_two_hover',
				'sub_toggle'	 => 'sub_toggle_border',
				'default'        => 'rgba(0,0,0,0.3)',
				'mobile_options' => true,
				'show_if'         => array(
					'dnxt_dual_two_hover_border' => 'dnxt-hover-overline-from-right',
				),
			),
			// Button Hover Reveal Border Color
			'dnxt_dual_two_reveal_color'        => array(
				'label'          => esc_html__( 'Border Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Border.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_two_hover',
				'sub_toggle'	 => 'sub_toggle_border',
				'default'        => 'rgba(0,0,0,0.3)',
				'mobile_options' => true,
				'show_if'         => array(
					'dnxt_dual_two_hover_border' => 'dnxt-hover-reveal',
				),
			),
			// Button Hover Underline Reveal Border Color
			'dnxt_dual_two_underline_reveal_color'        => array(
				'label'          => esc_html__( 'Border Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Border.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_two_hover',
				'sub_toggle'	 => 'sub_toggle_border',
				'default'        => 'rgba(0,0,0,0.3)',
				'mobile_options' => true,
				'show_if'         => array(
					'dnxt_dual_two_hover_border' => 'dnxt-hover-underline-reveal',
				),
			),
			// Button Hover Overline Reveal Border Color
			'dnxt_dual_two_overline_reveal_color'        => array(
				'label'          => esc_html__( 'Border Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Border.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_two_hover',
				'sub_toggle'	 => 'sub_toggle_border',
				'default'        => 'rgba(0,0,0,0.3)',
				'mobile_options' => true,
				'show_if'         => array(
					'dnxt_dual_two_hover_border' => 'dnxt-hover-overline-reveal',
				),
			),
			// Button Hover Overline Reveal Border Color
			'dnxt_dual_two_overline_reveal_color'        => array(
				'label'          => esc_html__( 'Border Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Border.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_two_hover',
				'sub_toggle'	 => 'sub_toggle_border',
				'default'        => 'rgba(0,0,0,0.3)',
				'mobile_options' => true,
				'show_if'         => array(
					'dnxt_dual_two_hover_border' => 'dnxt-hover-overline-reveal',
				),
			),
			// Button One Icons Hover Effect
			'dnxt_dual_one_hover_icons'     => array(
				'label'             => esc_html__( 'Select Icons Hover Effect', 'et_builder' ),
				'type'              => 'select',
				'option_category'   => 'configuration',
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'button_one_hover',
				'sub_toggle'		=> 'sub_toggle_icons',
				'default'           => '',
				'description'       => esc_html__( 'Here you can adjust the hover effect.', 'et_builder' ),
				'options'           => array(
					''									=>  esc_html__( 'Select', 'et_builder' ),
					'dnxt-hover-icon-back'				=>  esc_html__( 'Icon Back', 'dnxt-divi-next-button' ),
					'dnxt-hover-icon-forward'       	=>  esc_html__( 'Icon Forward', 'dnxt-divi-next-button' ),
					'dnxt-hover-icon-down'         		=>  esc_html__( 'Icon Down', 'dnxt-divi-next-button' ),
					'dnxt-hover-icon-up'         		=>  esc_html__( 'Icon Up', 'dnxt-divi-next-button' ),
					'dnxt-hover-icon-drop'        		=>  esc_html__( 'Icon Drop', 'dnxt-divi-next-button' ),
					'dnxt-hover-icon-float-away'    	=>  esc_html__( 'Icon Float Away', 'dnxt-divi-next-button' ),
					'dnxt-hover-icon-sink-away'    		=>  esc_html__( 'Icon Sink Away', 'dnxt-divi-next-button' ),
					'dnxt-hover-icon-grow'  			=>  esc_html__( 'Icon Grow', 'dnxt-divi-next-button' ),
					'dnxt-hover-icon-shrink'   			=>  esc_html__( 'Icon Shrink', 'dnxt-divi-next-button' ),
					'dnxt-hover-icon-pulse'         	=>  esc_html__( 'Icon pulse', 'dnxt-divi-next-button' ),
					'dnxt-hover-icon-pulse-grow'    	=>  esc_html__( 'Icon Pulse Grow', 'dnxt-divi-next-button' ),
					'dnxt-hover-icon-pulse-shrink'  	=>  esc_html__( 'Icon Pulse Shrink', 'dnxt-divi-next-button' ),
					'dnxt-hover-icon-push'  			=>  esc_html__( 'Icon Push', 'dnxt-divi-next-button' ),
					'dnxt-hover-icon-pop' 				=>  esc_html__( 'Icon Pop', 'dnxt-divi-next-button' ),
					'dnxt-hover-icon-bounce'    		=>  esc_html__( 'Icon Bounce', 'dnxt-divi-next-button' ),
					'dnxt-hover-icon-rotate'    		=>  esc_html__( 'Icon Rotate', 'dnxt-divi-next-button' ),
					'dnxt-hover-icon-grow-rotate'   	=>  esc_html__( 'Icon Grow Rotate', 'dnxt-divi-next-button' ),
					'dnxt-hover-icon-float'    			=>  esc_html__( 'Icon Float', 'dnxt-divi-next-button' ),
					'dnxt-hover-icon-sink'    			=>  esc_html__( 'Icon Sink', 'dnxt-divi-next-button' ),
					'dnxt-hover-icon-bob'    			=>  esc_html__( 'Icon Bob', 'dnxt-divi-next-button' ),
					'dnxt-hover-icon-hang'    			=>  esc_html__( 'Icon Hang', 'dnxt-divi-next-button' ),
					'dnxt-hover-icon-wobble-horizontal' =>  esc_html__( 'Icon Wobble Horizontal', 'dnxt-divi-next-button' ),
					'dnxt-hover-icon-wobble-vertical'   =>  esc_html__( 'Icon Wobble Vertical', 'dnxt-divi-next-button' ),
					'dnxt-hover-icon-buzz'    			=>  esc_html__( 'Icon Buzz', 'dnxt-divi-next-button' ),
					'dnxt-hover-icon-buzz-out'    		=>  esc_html__( 'Icon Buzz Out', 'dnxt-divi-next-button' ),
				),
				'mobile_options'      => true,
			),
			// Button Two Icons Hover Effect
			'dnxt_dual_two_hover_icons'     => array(
				'label'             => esc_html__( 'Select Icons Hover Effect', 'et_builder' ),
				'type'              => 'select',
				'option_category'   => 'configuration',
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'button_two_hover',
				'sub_toggle'		=> 'sub_toggle_icons',
				'default'           => '',
				'description'       => esc_html__( 'Here you can adjust the hover effect.', 'et_builder' ),
				'options'           => array(
					''									=>  esc_html__( 'Select', 'et_builder' ),
					'dnxt-hover-icon-back'				=>  esc_html__( 'Icon Back', 'dnxt-divi-next-button' ),
					'dnxt-hover-icon-forward'       	=>  esc_html__( 'Icon Forward', 'dnxt-divi-next-button' ),
					'dnxt-hover-icon-down'         		=>  esc_html__( 'Icon Down', 'dnxt-divi-next-button' ),
					'dnxt-hover-icon-up'         		=>  esc_html__( 'Icon Up', 'dnxt-divi-next-button' ),
					'dnxt-hover-icon-drop'        		=>  esc_html__( 'Icon Drop', 'dnxt-divi-next-button' ),
					'dnxt-hover-icon-float-away'    	=>  esc_html__( 'Icon Float Away', 'dnxt-divi-next-button' ),
					'dnxt-hover-icon-sink-away'    		=>  esc_html__( 'Icon Sink Away', 'dnxt-divi-next-button' ),
					'dnxt-hover-icon-grow'  			=>  esc_html__( 'Icon Grow', 'dnxt-divi-next-button' ),
					'dnxt-hover-icon-shrink'   			=>  esc_html__( 'Icon Shrink', 'dnxt-divi-next-button' ),
					'dnxt-hover-icon-pulse'         	=>  esc_html__( 'Icon pulse', 'dnxt-divi-next-button' ),
					'dnxt-hover-icon-pulse-grow'    	=>  esc_html__( 'Icon Pulse Grow', 'dnxt-divi-next-button' ),
					'dnxt-hover-icon-pulse-shrink'  	=>  esc_html__( 'Icon Pulse Shrink', 'dnxt-divi-next-button' ),
					'dnxt-hover-icon-push'  			=>  esc_html__( 'Icon Push', 'dnxt-divi-next-button' ),
					'dnxt-hover-icon-pop' 				=>  esc_html__( 'Icon Pop', 'dnxt-divi-next-button' ),
					'dnxt-hover-icon-bounce'    		=>  esc_html__( 'Icon Bounce', 'dnxt-divi-next-button' ),
					'dnxt-hover-icon-rotate'    		=>  esc_html__( 'Icon Rotate', 'dnxt-divi-next-button' ),
					'dnxt-hover-icon-grow-rotate'   	=>  esc_html__( 'Icon Grow Rotate', 'dnxt-divi-next-button' ),
					'dnxt-hover-icon-float'    			=>  esc_html__( 'Icon Float', 'dnxt-divi-next-button' ),
					'dnxt-hover-icon-sink'    			=>  esc_html__( 'Icon Sink', 'dnxt-divi-next-button' ),
					'dnxt-hover-icon-bob'    			=>  esc_html__( 'Icon Bob', 'dnxt-divi-next-button' ),
					'dnxt-hover-icon-hang'    			=>  esc_html__( 'Icon Hang', 'dnxt-divi-next-button' ),
					'dnxt-hover-icon-wobble-horizontal' =>  esc_html__( 'Icon Wobble Horizontal', 'dnxt-divi-next-button' ),
					'dnxt-hover-icon-wobble-vertical'   =>  esc_html__( 'Icon Wobble Vertical', 'dnxt-divi-next-button' ),
					'dnxt-hover-icon-buzz'    			=>  esc_html__( 'Icon Buzz', 'dnxt-divi-next-button' ),
					'dnxt-hover-icon-buzz-out'    		=>  esc_html__( 'Icon Buzz Out', 'dnxt-divi-next-button' ),
				),
				'mobile_options'      => true,
			),
			'button_one_css_id' => array(
                'label' => esc_html__('CSS ID', 'et_builder'),
                'type' => 'text',
                'option_category' => 'basic_option',
                'description' => esc_html__('Assign a unique CSS ID to the element which can be used to assign custom CSS styles from within your child theme or from within Divi\'s custom CSS inputs.', 'et_builder'),
                'tab_slug' => 'custom_css',
                'toggle_slug' => 'button_css_id',
                'sub_toggle' => 'sub_toggle_one',
            ),
            'button_one_css_classes' => array(
                'label' => esc_html__('CSS Class', 'et_builder'),
                'type' => 'text',
                'option_category' => 'basic_option',
                'description' => esc_html__('Assign any number of CSS Classes to the element, Separated by spaces, which can be used to assign custom CSS styles from within your child theme or from within Divi\'s custom CSS inputs.', 'et_builder'),
                'tab_slug' => 'custom_css',
				'toggle_slug' => 'button_css_id',
				'sub_toggle' => 'sub_toggle_one',
			),
			'button_two_css_id' => array(
                'label' => esc_html__('CSS ID', 'et_builder'),
                'type' => 'text',
                'option_category' => 'basic_option',
                'description' => esc_html__('Assign a unique CSS ID to the element which can be used to assign custom CSS styles from within your child theme or from within Divi\'s custom CSS inputs.', 'et_builder'),
                'tab_slug' => 'custom_css',
                'toggle_slug' => 'button_css_id',
                'sub_toggle' => 'sub_toggle_two',
            ),
            'button_two_css_classes' => array(
                'label' => esc_html__('CSS Class', 'et_builder'),
                'type' => 'text',
                'option_category' => 'basic_option',
                'description' => esc_html__('Assign any number of CSS Classes to the element, Separated by spaces, which can be used to assign custom CSS styles from within your child theme or from within Divi\'s custom CSS inputs.', 'et_builder'),
                'tab_slug' => 'custom_css',
				'toggle_slug' => 'button_css_id',
				'sub_toggle' => 'sub_toggle_two',
            ),
		);

		return $fields;
	}

    public function get_advanced_fields_config() {
		$advanced_fields = array();

		$advanced_fields['link_options'] = false;
		$advanced_fields['margin_padding'] = false;
		$advanced_fields['text'] = false;
		$advanced_fields['fonts'] = false;
		$advanced_fields['fonts'] = array(
			// Button One Fonts
            'btn_one_fonts'   => array(
                'toggle_slug'       => 'button_font',
				'tab_slug'          => 'advanced',
				'sub_toggle'	 	=> 'sub_toggle_one',
				'hide_text_align'   => true,
				'css'               => array(
					'main'          => "%%order_class%% .dnxt-button-wrapper .buttonOne",
					
                ),
                'line_height'       => array(
                    'default'   	=> '1em',
                ),
                'font_size'         => array(
                    'default'       => '20px',
                ),
			),
			// Button Two Fonts
			'btn_two_fonts'   => array(
                'toggle_slug'       => 'button_font',
				'tab_slug'          => 'advanced',
				'sub_toggle'	 	=> 'sub_toggle_two',
				'hide_text_align'   => true,
				'css'               => array(
					'main'          => "%%order_class%% .dnxt-button-wrapper .buttonTwo",
					
                ),
                'line_height'       => array(
                    'default'   	=> '1em',
                ),
                'font_size'         => array(
                    'default'       => '20px',
                ),
			),
		);
		//Button Borders
		$advanced_fields['borders'] = array(
			'one_border'	=> array(
				'label'			=>	esc_html__('Button One', 'et_builder'),
				'tab_slug'     => 'advanced',
                'toggle_slug'  => 'border_one',
				'css'          => array(
					'main'     => array(
						'border_radii'  => "%%order_class%% .dnxt-button-wrapper .buttonOne",
						'border_styles' => "%%order_class%% .dnxt-button-wrapper .buttonOne",
					),
				),
				'defaults'        => array(
					'border_radii'  => 'on|3px|3px|3px|3px',
					'border_styles' => array(
						'width' => '2px',
						'color' => '#2857b6',
						'style' => 'solid',
					),
				),
			),
			'two_border'	=> array(
				'label'			=>	esc_html__('Button Two', 'et_builder'),
				'tab_slug'     => 'advanced',
                'toggle_slug'  => 'border_two',
				'css'			=> array(
					'main'     	=> array(
						'border_radii'  => "%%order_class%% .dnxt-button-wrapper .buttonTwo",
						'border_styles' => "%%order_class%% .dnxt-button-wrapper .buttonTwo",
					),
				),
				'defaults'        => array(
					'border_radii'  => 'on|3px|3px|3px|3px',
					'border_styles' => array(
						'width' => '2px',
						'color' => '#2857b6',
						'style' => 'solid',
					),
				),
			)
		);
		//Button Boxshadow
		$advanced_fields['box_shadow']['one'] = array(
			'label'				=>	esc_html__('Button One', 'et_builder'),
			'css'               => array(
				'main'          => "%%order_class%% .dnxt-button-wrapper .buttonOne",
			)
		);
		$advanced_fields['box_shadow']['two'] = array(
			'label'				=>	esc_html__('Button Two', 'et_builder'),
			'css'               => array(
				'main'          => "%%order_class%% .dnxt-button-wrapper .buttonTwo",
			)
		);
		//Button Background
		$advanced_fields['background'] = false;
		$advanced_fields['background'] = array(
			'btn_bg_one'	=> array(
				'toggle_slug'       => 'dnxt_button_bg_one',
				'tab_slug'          => 'basic_option',
				'hover'           	=> 'tabs',
				'css'               => array(
					'main'          => "%%order_class%% .dnxt-button-wrapper .buttonOne",
				),
				'options'			=> array(
					'background_color_gradient_start'	=>	array(
						'default'	=>	et_builder_accent_color(),
					),
					'background_color_gradient_end'	=> array(
						'default'	=>	'#fff',
					),
					'background_color_gradient_type'	=> array(
						'default'	=>	'radial',
					)
				),
			),
			'btn_bg_two'	=> array(
				'toggle_slug'       => 'dnxt_button_bg_two',
				'tab_slug'          => 'basic_option',
				'hover'           	=> 'tabs',
				'css'               => array(
					'main'          => "{$this->main_css_element} %%order_class%% .dnxt-button-wrapper .buttonTwo",
				),
				'options'			=> array(
					'background_color_gradient_start'	=>	array(
						'default'	=>	et_builder_accent_color(),
					),
					'background_color_gradient_end'	=> array(
						'default'	=>	'#fff',
					),
					'background_color_gradient_type'	=> array(
						'default'	=>	'radial',
					)
				),
			)
		);
		return $advanced_fields;
	}

	/**
    * Get Dual button alignment.
    *
    * @since 3.23 Add responsive support by adding device parameter.
    *
    * @param  string $device Current device name.
    * @return string         Alignment value, rtl or not.
    */
	public function get_dual_button_alignment( $device = 'desktop' ) {
		$suffix           = 'desktop' !== $device ? "_{$device}" : '';
		$text_orientation = isset( $this->props["dnxt_dual_button_alignment{$suffix}"] ) ? $this->props["dnxt_dual_button_alignment{$suffix}"] : '';

		return et_pb_get_alignment( $text_orientation );
	}

	public function render( $attrs, $content, $render_slug ) {
		wp_enqueue_style('dnext_hvr_common_css');
		$multi_view							= et_pb_multi_view_options( $this );
		$dnxt_dual_button_alignment   		= $this->get_dual_button_alignment();
		$is_dual_btn_aligment_responsive   	= et_pb_responsive_options()->is_responsive_enabled( $this->props, 'dnxt_dual_button_alignment' );
        $dnxt_dual_button_alignment_tablet 	= $is_dual_btn_aligment_responsive ? $this->get_dual_button_alignment( 'tablet' ) : '';
		$dnxt_dual_button_alignment_phone  	= $is_dual_btn_aligment_responsive ? $this->get_dual_button_alignment( 'phone' ) : '';
		
		
		$button_one_css_id = "" !== $this->props['button_one_css_id'] ? sprintf('id="%1$s"', $this->props['button_one_css_id']) : "";
		$button_one_css_classes = "" !== $this->props['button_one_css_classes'] ? $this->props['button_one_css_classes'] : "";
		
		$button_two_css_id = "" !== $this->props['button_two_css_id'] ? sprintf('id="%1$s"', $this->props['button_two_css_id']) : "";
        $button_two_css_classes = "" !== $this->props['button_two_css_classes'] ? $this->props['button_two_css_classes'] : "";

        // Dual Button Alignment.
		$dnxt_dual_button_alignments = array();
		if ( ! empty( $dnxt_dual_button_alignment ) ) {
			array_push( $dnxt_dual_button_alignments, sprintf( 'dnxt_dual_button_alignment_%1$s', esc_attr( $dnxt_dual_button_alignment ) ) );
        }
        
		if ( ! empty( $dnxt_dual_button_alignment_tablet ) ) {
			array_push( $dnxt_dual_button_alignments, sprintf( 'dnxt_dual_button_alignment_tablet_%1$s', esc_attr( $dnxt_dual_button_alignment_tablet ) ) );
        }
        
        if ( ! empty( $dnxt_dual_button_alignment_phone ) ) {
			array_push( $dnxt_dual_button_alignments, sprintf( 'dnxt_dual_button_alignment_phone_%1$s', esc_attr( $dnxt_dual_button_alignment_phone ) ) );
		}

		$dnxt_dual_button_alignment_classes = join( ' ', $dnxt_dual_button_alignments );

		$button_text_one	=	$this->props['button_text_one'];
		$button_link_one	=	$this->props['button_link_one'];
		$button_text_two	=	$this->props['button_text_two'];
		$button_link_two	=	$this->props['button_link_two'];

		$buttonTargetOne = 'on' === $this->props['button_link_one_new_window'] ? '_blank' : '_self';
		$buttonTargetTwo = 'on' === $this->props['button_link_two_new_window'] ? '_blank' : '_self';

		// Button One Hover 2d
		$btnOneHover2d = '';
		if ( '' !== $this->props['dnxt_dual_one_hover_2d'] ) {
			$btnOneHover2d = $this->props['dnxt_dual_one_hover_2d'];
		}
		// Button Two Hover 2d
		$btnTwoHover2d = '';
		if ( '' !== $this->props['dnxt_dual_two_hover_2d'] ) {
			$btnTwoHover2d = $this->props['dnxt_dual_two_hover_2d'];
		}

		// Button One Hover Background
		$btnOneHoverBg = '';
		if ( '' !== $this->props['dnxt_dual_one_hover_bg'] ) {
			$btnOneHoverBg = $this->props['dnxt_dual_one_hover_bg'];
		}
		// Button Two Hover Background
		$btnTwoHoverBg = '';
		if ( '' !== $this->props['dnxt_dual_two_hover_bg'] ) {
			$btnTwoHoverBg = $this->props['dnxt_dual_two_hover_bg'];
		}

		// Button One Hover Stock Effect
		$btnOneHoverBorder = '';
		if ( '' !== $this->props['dnxt_dual_one_hover_border'] ) {
			$btnOneHoverBorder = $this->props['dnxt_dual_one_hover_border'];
		}

		// Button Two Hover Stock Effect
		$btnTwoHoverBorder = '';
		if ( '' !== $this->props['dnxt_dual_two_hover_border'] ) {
			$btnTwoHoverBorder = $this->props['dnxt_dual_two_hover_border'];
		}

		// Button One Hover Icons
		$btnOneHoverIcons = '';
		if ( '' !== $this->props['dnxt_dual_one_hover_icons'] ) {
			$btnOneHoverIcons = $this->props['dnxt_dual_one_hover_icons'];
		}
		// Button Two Hover Icons
		$btnTwoHoverIcons = '';
		if ( '' !== $this->props['dnxt_dual_two_hover_icons'] ) {
			$btnTwoHoverIcons = $this->props['dnxt_dual_two_hover_icons'];
		}

		// Button BG One
			$button_bg_one		    = $this->props['button_bg_one'];
			$button_bg_one_hover 	= $this->get_hover_value( 'button_bg_one' );
			$button_bg_one_values	= et_pb_responsive_options()->get_property_values( $this->props, 'button_bg_one' );
			$button_bg_one_tablet	= isset( $button_bg_one_values['tablet'] ) ? $button_bg_one_values['tablet'] : '';
			$button_bg_one_phone	= isset( $button_bg_one_values['phone'] ) ? $button_bg_one_values['phone'] : '';
	
		// Button BG One
		if ( 'off' !== $this->props['btn_one_show_hide'] ) {
			$button_bg_one_style 		 	= sprintf( 'background: %1$s;', esc_attr( $button_bg_one ) );
			$button_bg_one_tablet_style 	= '' !== $button_bg_one_tablet ? sprintf( 'background: %1$s;', esc_attr( $button_bg_one_tablet ) ) : '';
			$button_bg_one_phone_style  	= '' !== $button_bg_one_phone ? sprintf( 'background: %1$s;', esc_attr( $button_bg_one_phone ) ) : '';
			
			$button_bg_one_style_hover  = '';

			if ( et_builder_is_hover_enabled( 'button_bg_one', $this->props ) ) {
				$button_bg_one_style_hover = sprintf( 'background: %1$s;', esc_attr( $button_bg_one_hover ) );
			}

			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnxt-button-wrapper .buttonOne",
				'declaration' => $button_bg_one_style,
			) );
			
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnxt-button-wrapper .buttonOne",
				'declaration' => $button_bg_one_tablet_style,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
			) );

			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnxt-button-wrapper .buttonOne",
				'declaration' => $button_bg_one_phone_style,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
			) );

			if ( "" !== $button_bg_one_style_hover ) {
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => $this->add_hover_to_order_class( "%%order_class%% .dnxt-button-wrapper .buttonOne" ),
					'declaration' => $button_bg_one_style_hover,
				) );
			}
		}

		// Button Background Gradient One
		$bg_one_gradient_color_one = $this->props['bg_one_gradient_color_one'];
		$bg_one_gradient_color_two = $this->props['bg_one_gradient_color_two'];
			// Other gradient options
			$bg_one_gradient_type 			= $this->props['bg_one_gradient_type'];
			$bg_one_gradient_start_position = $this->props['bg_one_gradient_start_position'];
			$bg_one_gradient_end_position 	= $this->props['bg_one_gradient_end_position'];

			$bg_one_gradient_direction = $bg_one_gradient_type === 'linear-gradient' ? $this->props['bg_one_gradient_type_linear_direction'] : $this->props['bg_one_gradient_type_radial_direction'];
		
		if( 'off' !== $this->props['btn_one_gradient_show_hide'] ) {
			$bg_one_gradient = sprintf('background: %1$s(%2$s, %3$s %5$s, %4$s %6$s);', $bg_one_gradient_type, $bg_one_gradient_direction, esc_attr( $bg_one_gradient_color_one ), esc_attr( $bg_one_gradient_color_two ), $bg_one_gradient_start_position, $bg_one_gradient_end_position);
			
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnxt-button-wrapper .buttonOne",
				'declaration' => $bg_one_gradient,
			) );
		}

		// Button BG Two
		$button_bg_two		    = $this->props['button_bg_two'];
		$button_bg_two_hover 	= $this->get_hover_value( 'button_bg_two' );
		$button_bg_two_values	= et_pb_responsive_options()->get_property_values( $this->props, 'button_bg_two' );
		$button_bg_two_tablet	= isset( $button_bg_two_values['tablet'] ) ? $button_bg_two_values['tablet'] : '';
		$button_bg_two_phone	= isset( $button_bg_two_values['phone'] ) ? $button_bg_two_values['phone'] : '';
	
		// Button BG Two
		if ( 'off' !== $this->props['btn_two_color_show_hide'] ) {
			$button_bg_two_style 		 	= sprintf( 'background: %1$s;', esc_attr( $button_bg_two ) );
			$button_bg_two_tablet_style 	= '' !== $button_bg_two_tablet ? sprintf( 'background: %1$s;', esc_attr( $button_bg_two_tablet ) ) : '';
			$button_bg_two_phone_style  	= '' !== $button_bg_two_phone ? sprintf( 'background: %1$s;', esc_attr( $button_bg_two_phone ) ) : '';
			
			$button_bg_two_style_hover  = '';

			if ( et_builder_is_hover_enabled( 'button_bg_two', $this->props ) ) {
				$button_bg_two_style_hover = sprintf( 'background: %1$s;', esc_attr( $button_bg_two_hover ) );
			}

			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnxt-button-wrapper .buttonTwo",
				'declaration' => $button_bg_two_style,
			) );
			
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnxt-button-wrapper .buttonTwo",
				'declaration' => $button_bg_two_tablet_style,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
			) );

			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnxt-button-wrapper .buttonTwo",
				'declaration' => $button_bg_two_phone_style,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
			) );

			if ( "" !== $button_bg_two_style_hover ) {
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => $this->add_hover_to_order_class( "%%order_class%% .dnxt-button-wrapper .buttonTwo" ),
					'declaration' => $button_bg_two_style_hover,
				) );
			}
		}

		// Button Background Gradient One
		$bg_two_gradient_color_one = $this->props['bg_two_gradient_color_one'];
		$bg_two_gradient_color_two = $this->props['bg_two_gradient_color_two'];
			// Other gradient options
			$bg_two_gradient_type 			= $this->props['bg_two_gradient_type'];
			$bg_two_gradient_start_position = $this->props['bg_two_gradient_start_position'];
			$bg_two_gradient_end_position 	= $this->props['bg_two_gradient_end_position'];

			$bg_two_gradient_direction = $bg_two_gradient_type === 'linear-gradient' ? $this->props['bg_two_gradient_type_linear_direction'] : $this->props['bg_two_gradient_type_radial_direction'];
		
		if( 'off' !== $this->props['btn_two_gradient_show_hide'] ) {
			$bg_two_gradient = sprintf('background: %1$s(%2$s, %3$s %5$s, %4$s %6$s);', $bg_two_gradient_type, $bg_two_gradient_direction, esc_attr( $bg_two_gradient_color_one ), esc_attr( $bg_two_gradient_color_two ), $bg_two_gradient_start_position, $bg_two_gradient_end_position);
			
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnxt-button-wrapper .buttonTwo",
				'declaration' => $bg_two_gradient,
			) );
		}
		$this->apply_css($render_slug);

		//Button On Hover class inner
		$btnIconOneOnHover = 'off' === $this->props['btn_one_on_hover'] ? "dnxt-btn-icon-one-on-hover" : "";
		
		$btnIconTwoOnHover = 'off' === $this->props['btn_two_on_hover'] ? "dnxt-btn-icon-two-on-hover" : "";

		$rightOneItag = '';
		$leftOneItag = '';
		$icon_one_css_property = array(
			'selector'    => '%%order_class%% .dnxt-one-btn-icon i',
			'class'       => ''
		);
		if('right' === $this->props['btn_one_icon_placement']){
			$rightOneItag = Common::get_icon_html( 'btn_one_icon', $this, $render_slug, $multi_view, $icon_one_css_property, 'i' );
		}else if('left' === $this->props['btn_one_icon_placement']){
			$leftOneItag = Common::get_icon_html( 'btn_one_icon', $this, $render_slug, $multi_view, $icon_one_css_property, 'i' );
		}
		

		$rightTwoItag = '';
		$leftTwoItag = '';
		$icon_two_css_property = array(
			'selector'    => '%%order_class%% .dnxt-two-btn-icon i',
			'class'       => ''
		);
		
		if('right' === $this->props['btn_two_icon_placement']){
			$rightTwoItag = Common::get_icon_html( 'btn_two_icon', $this, $render_slug, $multi_view, $icon_two_css_property, 'i' );
		}else if('left' === $this->props['btn_two_icon_placement']){
			$leftTwoItag = Common::get_icon_html( 'btn_two_icon', $this, $render_slug, $multi_view, $icon_two_css_property, 'i' );
		}

		return sprintf( 
			'<div class="dnxt-button-wrapper %21$s">
				<a %22$s class="buttonOne dnxt-one-btn-icon %11$s %13$s %15$s %17$s %19$s %23$s" href="%2$s" target="%3$s">%8$s%1$s%7$s</a><a %24$s class="buttonTwo dnxt-two-btn-icon %12$s %14$s %16$s %18$s %20$s %25$s" href="%5$s" target="%6$s">%10$s%4$s%9$s</a>
			</div>', 
			esc_html($button_text_one),
			$button_link_one,
			$buttonTargetOne,
			esc_html($button_text_two),
			$button_link_two, // #5
			$buttonTargetTwo,
			$rightOneItag,
			$leftOneItag,
			$rightTwoItag,
			$leftTwoItag, // #10
			$btnIconOneOnHover,
			$btnIconTwoOnHover,
			esc_attr( $btnOneHover2d ),
			esc_attr( $btnTwoHover2d ),
			esc_attr( $btnOneHoverBg ), // #15
			esc_attr( $btnTwoHoverBg ),
			esc_attr( $btnOneHoverIcons ),
			esc_attr( $btnTwoHoverIcons ),
			esc_attr( $btnOneHoverBorder ),
			esc_attr( $btnTwoHoverBorder ), // #20
			esc_attr( $dnxt_dual_button_alignment_classes ),
			esc_attr( $button_one_css_id ),
			esc_attr( $button_one_css_classes ),
			esc_attr( $button_two_css_id ),
			esc_attr( $button_two_css_classes ) // #25
		);
	}

	public function apply_css($render_slug){

		/**
         * Button Padding Margin Output
         *
         */

        Common::dnxt_set_style($render_slug, $this->props, "button_one_margin", "%%order_class%% .dnxt-button-wrapper .buttonOne", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "button_one_padding", "%%order_class%% .dnxt-button-wrapper .buttonOne", "padding");

        Common::dnxt_set_style($render_slug, $this->props, "button_two_margin", "%%order_class%% .dnxt-button-wrapper .buttonTwo", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "button_two_padding", "%%order_class%% .dnxt-button-wrapper .buttonTwo", "padding");

		// Button One Icon Setup
		if("on" === $this->props['btn_one_icon_show_hide']){
			// Button Icon Color
			if ('' !== $this->props['btn_one_icon_color']) {
				ET_Builder_Element::set_style($render_slug, array(
					'selector'    => "%%order_class%% .dnxt-one-btn-icon i",
					'declaration' => "color: {$this->props['btn_one_icon_color']};"
				));
			}
			// Button Icon Color Hover
			$btn_one_ich_enabled = isset($this->props['btn_one_icon_color__hover_enabled']) ? "on|hover" : "off|hover";
			if ( "on|hover" === $btn_one_ich_enabled ) {
				ET_Builder_Element::set_style($render_slug, array(
					'selector'    => "%%order_class%% .dnxt-one-btn-icon:hover i",
					'declaration' => "color: {$this->props['btn_one_icon_color__hover']};"
				));
			}
			// Button Icon Show On Hover
			if ('on' === $this->props['btn_one_on_hover'] && 'right' === $this->props['btn_one_icon_placement']) {
				ET_Builder_Element::set_style($render_slug, array(
					'selector'    => "%%order_class%% .dnxt-one-btn-icon:hover i",
					'declaration' => "opacity: 1;visibility: visible;margin-left: 0;padding-left: 0.4em;"
				));
			}else if('on' === $this->props['btn_one_on_hover']){
				ET_Builder_Element::set_style($render_slug, array(
					'selector'    => "%%order_class%% .dnxt-one-btn-icon:hover i",
					'declaration' => "opacity: 1;visibility: visible;"
				));
			}
			if ('on' === $this->props['btn_one_on_hover'] && 'left' === $this->props['btn_one_icon_placement']) {
				ET_Builder_Element::set_style($render_slug, array(
					'selector'    => "%%order_class%% .dnxt-one-btn-icon:hover i",
					'declaration' => "opacity: 1;visibility: visible;padding-right: 0.4em;margin-left: 0;"
				));
			}else if('on' === $this->props['btn_one_on_hover']){
				ET_Builder_Element::set_style($render_slug, array(
					'selector'    => "%%order_class%% .dnxt-one-btn-icon:hover i",
					'declaration' => "opacity: 1;visibility: visible;"
				));
			}
			// Button Icon Placement
			if('off' === $this->props['btn_one_on_hover'] && 'left' === $this->props['btn_one_icon_placement']){
				ET_Builder_Element::set_style($render_slug, array(
					'selector'    => "%%order_class%% .dnxt-one-btn-icon.dnxt-btn-icon-one-on-hover i",
					'declaration' => "opacity: 1;visibility: visible;margin-left: 0;padding-right: 0.4em;"
				));
			}else if('off' === $this->props['btn_one_on_hover'] && 'right' === $this->props['btn_one_icon_placement']){
				ET_Builder_Element::set_style($render_slug, array(
					'selector'    => "%%order_class%% .dnxt-one-btn-icon.dnxt-btn-icon-one-on-hover i",
					'declaration' => "opacity: 1;visibility: visible;margin-left: 0;padding-left: 0.4em;"
				));
			}
		}

		// Button Two Icon Setup
		if("on" === $this->props['btn_two_icon_show_hide']){
			// Button Icon
			if ('right' === $this->props['btn_two_icon_placement']) {
				ET_Builder_Element::set_style($render_slug, array(
					'selector'    	=> "%%order_class%% .dnxt-two-btn-icon i",
					'declaration'	=> 'content: attr(data-icon);'
				));
			}else if('left' === $this->props['btn_two_icon_placement']){
				ET_Builder_Element::set_style($render_slug, array(
					'selector'    	=> "%%order_class%% .dnxt-two-btn-icon i",
					'declaration'	=> 'content: attr(data-icon);'
				));
			}
			// Button Icon Color
			if ('' !== $this->props['btn_two_icon_color']) {
				ET_Builder_Element::set_style($render_slug, array(
					'selector'    => "%%order_class%% .dnxt-two-btn-icon i",
					'declaration' => "color: {$this->props['btn_two_icon_color']};"
				));
			}
			// Button Icon Color Hover
			$btn_two_ich_enabled = isset($this->props['btn_two_icon_color__hover_enabled']) ? "on|hover" : "off|hover";
			if ( "on|hover" === $btn_two_ich_enabled ) {
				ET_Builder_Element::set_style($render_slug, array(
					'selector'    => "%%order_class%% .dnxt-two-btn-icon:hover i",
					'declaration' => "color: {$this->props['btn_two_icon_color__hover']};"
				));
			}
			// Button Icon Show On Hover
			if ('on' === $this->props['btn_two_on_hover'] && 'right' === $this->props['btn_two_icon_placement']) {
				ET_Builder_Element::set_style($render_slug, array(
					'selector'    => "%%order_class%% .dnxt-two-btn-icon:hover i",
					'declaration' => "opacity: 1;visibility: visible;margin-left: 0;padding-left: 0.4em;"
				));
			}else if('on' === $this->props['btn_two_on_hover']){
				ET_Builder_Element::set_style($render_slug, array(
					'selector'    => "%%order_class%% .dnxt-two-btn-icon:hover i",
					'declaration' => "opacity: 1;visibility: visible;"
				));
			}
			if ('on' === $this->props['btn_two_on_hover'] && 'left' === $this->props['btn_two_icon_placement']) {
				ET_Builder_Element::set_style($render_slug, array(
					'selector'    => "%%order_class%% .dnxt-two-btn-icon:hover i",
					'declaration' => "opacity: 1;visibility: visible;padding-right: 0.4em;margin-left: 0;"
				));
			}else if('on' === $this->props['btn_two_on_hover']){
				ET_Builder_Element::set_style($render_slug, array(
					'selector'    => "%%order_class%% .dnxt-two-btn-icon:hover i",
					'declaration' => "opacity: 1;visibility: visible;"
				));
			}
			// Button Icon Placement
			if('off' === $this->props['btn_two_on_hover'] && 'left' === $this->props['btn_two_icon_placement']){
				ET_Builder_Element::set_style($render_slug, array(
					'selector'    => "%%order_class%% .dnxt-two-btn-icon.dnxt-btn-icon-two-on-hover i",
					'declaration' => "opacity: 1;visibility: visible;margin-left: 0;padding-right: 0.4em;"
				));
			}else if('off' === $this->props['btn_two_on_hover'] && 'right' === $this->props['btn_two_icon_placement']){
				ET_Builder_Element::set_style($render_slug, array(
					'selector'    => "%%order_class%% .dnxt-two-btn-icon.dnxt-btn-icon-two-on-hover i",
					'declaration' => "opacity: 1;visibility: visible;margin-left: 0;padding-left: 0.4em;"
				));
			}
		}

		// Button Dual One Hover Background Color
		if ('' !== $this->props['dnxt_dual_one_hover_bg_color']) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonOne.{$this->props['dnxt_dual_one_hover_bg']}:before",
				'declaration' => "background: {$this->props['dnxt_dual_one_hover_bg_color']}!important;"
			));
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .{$this->props['dnxt_dual_one_hover_bg']}:hover:before",
				'declaration' => "transform: scaleX(1)!important;"
			));
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonOne.dnxt-hover-fade:hover",
				'declaration' => "background: {$this->props['dnxt_dual_one_hover_bg_color']}!important;"
			));
		}
		// Button Dual Two Hover Background Color
		if ('' !== $this->props['dnxt_dual_two_hover_bg_color']) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonTwo.{$this->props['dnxt_dual_two_hover_bg']}:before",
				'declaration' => "background: {$this->props['dnxt_dual_two_hover_bg_color']}!important;"
			));
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .{$this->props['dnxt_dual_two_hover_bg']}:hover:before",
				'declaration' => "transform: scaleX(1)!important;"
			));
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonTwo.dnxt-hover-fade:hover",
				'declaration' => "background: {$this->props['dnxt_dual_two_hover_bg_color']}!important;"
			));
		}
		// Button One & Two Hover Background Color Radial Out
		if ('dnxt-hover-radial-out' === $this->props['dnxt_dual_one_hover_bg']) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonOne.dnxt-hover-radial-out",
				'declaration' => "background: {$this->props['dnxt_dual_one_radial_out_bg_color']}!important;"
			));
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonOne.dnxt-hover-radial-out:before",
				'declaration' => "background: {$this->props['dnxt_dual_one_hover_bg_color']}!important;"
			));
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonOne.dnxt-hover-radial-out:hover:before",
				'declaration' => "transform: scale(2)!important;"
			));
		}
		if ('dnxt-hover-radial-out' === $this->props['dnxt_dual_two_hover_bg']) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonTwo.dnxt-hover-radial-out",
				'declaration' => "background: {$this->props['dnxt_dual_two_radial_out_bg_color']}!important;"
			));
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonTwo.dnxt-hover-radial-out:before",
				'declaration' => "background: {$this->props['dnxt_dual_two_hover_bg_color']}!important;"
			));
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonTwo.dnxt-hover-radial-out:hover:before",
				'declaration' => "transform: scale(2)!important;"
			));
		}
		// Button One & Two Hover Background Color Radial In
		if ('dnxt-hover-radial-in' === $this->props['dnxt_dual_one_hover_bg']) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonOne.dnxt-hover-radial-in",
				'declaration' => "background: {$this->props['dnxt_dual_one_hover_bg_color']}!important;"
			));
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonOne.dnxt-hover-radial-in:before",
				'declaration' => "background: {$this->props['dnxt_dual_one_radial_in_bg_color']}!important;"
			));
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonOne.dnxt-hover-radial-in:hover:before",
				'declaration' => "transform: scale(0)!important;"
			));
		}
		if ('dnxt-hover-radial-in' === $this->props['dnxt_dual_two_hover_bg']) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonTwo.dnxt-hover-radial-in",
				'declaration' => "background: {$this->props['dnxt_dual_two_hover_bg_color']}!important;"
			));
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonTwo.dnxt-hover-radial-in:before",
				'declaration' => "background: {$this->props['dnxt_dual_two_radial_in_bg_color']}!important;"
			));
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonTwo.dnxt-hover-radial-in:hover:before",
				'declaration' => "transform: scale(0)!important;"
			));
		}
		// Button One & Two Hover Background Color Rectangle In
		if ('dnxt-hover-rectangle-in' === $this->props['dnxt_dual_one_hover_bg']) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonOne.dnxt-hover-rectangle-in",
				'declaration' => "background: {$this->props['dnxt_dual_one_hover_bg_color']}!important;"
			));
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonOne.dnxt-hover-rectangle-in:before",
				'declaration' => "background: {$this->props['dnxt_dual_one_rectangle_in_bg_color']}!important;"
			));
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonOne.dnxt-hover-rectangle-in:hover:before",
				'declaration' => "transform: scale(0)!important;"
			));
		}
		if ('dnxt-hover-rectangle-in' === $this->props['dnxt_dual_two_hover_bg']) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonTwo.dnxt-hover-rectangle-in",
				'declaration' => "background: {$this->props['dnxt_dual_two_hover_bg_color']}!important;"
			));
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonTwo.dnxt-hover-rectangle-in:before",
				'declaration' => "background: {$this->props['dnxt_dual_two_rectangle_in_bg_color']}!important;"
			));
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonTwo.dnxt-hover-rectangle-in:hover:before",
				'declaration' => "transform: scale(0)!important;"
			));
		}
		// Button One & Two Hover Background Color Rectangle Out
		if ('dnxt-hover-rectangle-out' === $this->props['dnxt_dual_one_hover_bg']) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonOne.dnxt-hover-rectangle-out",
				'declaration' => "background: {$this->props['dnxt_dual_one_rectangle_out_bg_color']}!important;"
			));
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonOne.dnxt-hover-rectangle-out:before",
				'declaration' => "background: {$this->props['dnxt_dual_one_hover_bg_color']}!important;"
			));
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonOne.dnxt-hover-rectangle-out:hover:before",
				'declaration' => "transform: scale(1)!important;"
			));
		}
		if ('dnxt-hover-rectangle-out' === $this->props['dnxt_dual_two_hover_bg']) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonTwo.dnxt-hover-rectangle-out",
				'declaration' => "background: {$this->props['dnxt_dual_two_rectangle_out_bg_color']}!important;"
			));
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonTwo.dnxt-hover-rectangle-out:before",
				'declaration' => "background: {$this->props['dnxt_dual_two_hover_bg_color']}!important;"
			));
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonTwo.dnxt-hover-rectangle-out:hover:before",
				'declaration' => "transform: scale(1)!important;"
			));
		}
		// Button One & Two Hover Background Color Shutter In
		if ('dnxt-hover-shutter-in-horizontal' === $this->props['dnxt_dual_one_hover_bg']) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonOne.dnxt-hover-shutter-in-horizontal",
				'declaration' => "background: {$this->props['dnxt_dual_one_hover_bg_color']}!important;"
			));
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonOne.dnxt-hover-shutter-in-horizontal:before",
				'declaration' => "background: {$this->props['dnxt_dual_one_shutter_in_bg_color']}!important;"
			));
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonOne.dnxt-hover-shutter-in-horizontal:hover:before",
				'declaration' => "transform: scaleX(0)!important;"
			));
		} 
		if ('dnxt-hover-shutter-in-horizontal' === $this->props['dnxt_dual_two_hover_bg']) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonTwo.dnxt-hover-shutter-in-horizontal",
				'declaration' => "background: {$this->props['dnxt_dual_two_hover_bg_color']}!important;"
			));
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonTwo.dnxt-hover-shutter-in-horizontal:before",
				'declaration' => "background: {$this->props['dnxt_dual_two_shutter_in_bg_color']}!important;"
			));
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonTwo.dnxt-hover-shutter-in-horizontal:hover:before",
				'declaration' => "transform: scaleX(0)!important;"
			));
		}
		// Button One & Two Hover Background Color Shutter Out
		if ('dnxt-hover-shutter-out-horizontal' === $this->props['dnxt_dual_one_hover_bg']) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonOne.dnxt-hover-shutter-out-horizontal",
				'declaration' => "background: {$this->props['dnxt_dual_one_shutter_out_bg_color']}!important;"
			));
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonOne.dnxt-hover-shutter-out-horizontal:before",
				'declaration' => "background: {$this->props['dnxt_dual_one_hover_bg_color']}!important;"
			));
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonOne.dnxt-hover-shutter-out-horizontal:hover:before",
				'declaration' => "transform: scaleX(1)!important;"
			));
		}
		if ('dnxt-hover-shutter-out-horizontal' === $this->props['dnxt_dual_two_hover_bg']) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonTwo.dnxt-hover-shutter-out-horizontal",
				'declaration' => "background: {$this->props['dnxt_dual_two_shutter_out_bg_color']}!important;"
			));
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonTwo.dnxt-hover-shutter-out-horizontal:before",
				'declaration' => "background: {$this->props['dnxt_dual_two_hover_bg_color']}!important;"
			));
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonTwo.dnxt-hover-shutter-out-horizontal:hover:before",
				'declaration' => "transform: scaleX(1)!important;"
			));
		}
		// Button One & Two Hover Background Color Shutter In Vertical
		if ('dnxt-hover-shutter-in-vertical' === $this->props['dnxt_dual_one_hover_bg']) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonOne.dnxt-hover-shutter-in-vertical",
				'declaration' => "background: {$this->props['dnxt_dual_one_hover_bg_color']}!important;"
			));
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonOne.dnxt-hover-shutter-in-vertical:before",
				'declaration' => "background: {$this->props['dnxt_dual_one_shutter_in_v_bg_color']}!important;"
			));
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonOne.dnxt-hover-shutter-in-vertical:hover:before",
				'declaration' => "transform: scaleY(0)!important;"
			));
		}
		if ('dnxt-hover-shutter-in-vertical' === $this->props['dnxt_dual_two_hover_bg']) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonTwo.dnxt-hover-shutter-in-vertical",
				'declaration' => "background: {$this->props['dnxt_dual_two_hover_bg_color']}!important;"
			));
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonTwo.dnxt-hover-shutter-in-vertical:before",
				'declaration' => "background: {$this->props['dnxt_dual_two_shutter_in_v_bg_color']}!important;"
			));
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonTwo.dnxt-hover-shutter-in-vertical:hover:before",
				'declaration' => "transform: scaleY(0)!important;"
			));
		}
		// Button One & Two Hover Background Color Shutter Out Vertical
		if ('dnxt-hover-shutter-out-vertical' === $this->props['dnxt_dual_one_hover_bg']) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonOne.dnxt-hover-shutter-out-vertical",
				'declaration' => "background: {$this->props['dnxt_dual_one_shutter_out_v_bg_color']}!important;"
			));
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonOne.dnxt-hover-shutter-out-vertical:before",
				'declaration' => "background: {$this->props['dnxt_dual_one_hover_bg_color']}!important;"
			));
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonOne.dnxt-hover-shutter-out-vertical:hover:before",
				'declaration' => "transform: scaleY(1)!important;"
			));
		}
		if ('dnxt-hover-shutter-out-vertical' === $this->props['dnxt_dual_two_hover_bg']) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonTwo.dnxt-hover-shutter-out-vertical",
				'declaration' => "background: {$this->props['dnxt_dual_two_shutter_out_v_bg_color']}!important;"
			));
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonTwo.dnxt-hover-shutter-out-vertical:before",
				'declaration' => "background: {$this->props['dnxt_dual_two_hover_bg_color']}!important;"
			));
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonTwo.dnxt-hover-shutter-out-vertical:hover:before",
				'declaration' => "transform: scaleY(1)!important;"
			));
		}
		// Hover One & Two Trim Border Color
		if('dnxt-hover-trim' === $this->props['dnxt_dual_one_hover_border']){
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonOne.dnxt-hover-trim:before",
				'declaration' => "border: {$this->props['dnxt_dual_one_trim_border_color']} solid 4px;"
			));
		}
		if('dnxt-hover-trim' === $this->props['dnxt_dual_two_hover_border']){
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonTwo.dnxt-hover-trim:before",
				'declaration' => "border: {$this->props['dnxt_dual_two_trim_border_color']} solid 4px;"
			));
		}
		// Hover One & Two Ripple In Border Color
		if('dnxt-hover-ripple-out' === $this->props['dnxt_dual_one_hover_border']){
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonOne.dnxt-hover-ripple-out:before",
				'declaration' => "border: {$this->props['dnxt_dual_one_ripple_out_color']} solid 6px;"
			));
		}
		if('dnxt-hover-ripple-out' === $this->props['dnxt_dual_two_hover_border']){
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonTwo.dnxt-hover-ripple-out:before",
				'declaration' => "border: {$this->props['dnxt_dual_two_ripple_out_color']} solid 6px;"
			));
		}
		// Hover One & Two Ripple Out Border Color
		if('dnxt-hover-ripple-in' === $this->props['dnxt_dual_one_hover_border']){
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonOne.dnxt-hover-ripple-in:before",
				'declaration' => "border: {$this->props['dnxt_dual_one_ripple_in_color']} solid 6px;"
			));
		}
		if('dnxt-hover-ripple-in' === $this->props['dnxt_dual_two_hover_border']){
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonTwo.dnxt-hover-ripple-in:before",
				'declaration' => "border: {$this->props['dnxt_dual_two_ripple_in_color']} solid 6px;"
			));
		}
		// Hover One & Two Underline From Left Color
		if('dnxt-hover-underline-from-left' === $this->props['dnxt_dual_one_hover_border']){
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonOne.dnxt-hover-underline-from-left:before",
				'declaration' => "background: {$this->props['dnxt_dual_one_underline_from_left_color']};"
			));
		}
		if('dnxt-hover-underline-from-left' === $this->props['dnxt_dual_two_hover_border']){
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonTwo.dnxt-hover-underline-from-left:before",
				'declaration' => "background: {$this->props['dnxt_dual_two_underline_from_left_color']};"
			));
		}
		// Hover One & Two Underline From Center Color
		if('dnxt-hover-underline-from-center' === $this->props['dnxt_dual_one_hover_border']){
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonOne.dnxt-hover-underline-from-center:before",
				'declaration' => "background: {$this->props['dnxt_dual_one_underline_from_center_color']};"
			));
		}
		if('dnxt-hover-underline-from-center' === $this->props['dnxt_dual_two_hover_border']){
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonTwo.dnxt-hover-underline-from-center:before",
				'declaration' => "background: {$this->props['dnxt_dual_two_underline_from_center_color']};"
			));
		}
		// Hover One & Two Underline From Right Color
		if('dnxt-hover-underline-from-right' === $this->props['dnxt_dual_one_hover_border']){
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonOne.dnxt-hover-underline-from-right:before",
				'declaration' => "background: {$this->props['dnxt_dual_one_underline_from_right_color']};"
			));
		}
		if('dnxt-hover-underline-from-right' === $this->props['dnxt_dual_two_hover_border']){
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonTwo.dnxt-hover-underline-from-right:before",
				'declaration' => "background: {$this->props['dnxt_dual_two_underline_from_right_color']};"
			));
		}
		// Hover One & Two Overline From Left Color
		if('dnxt-hover-overline-from-left' === $this->props['dnxt_dual_one_hover_border']){
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonOne.dnxt-hover-overline-from-left:before",
				'declaration' => "background: {$this->props['dnxt_dual_one_overline_left_color']};"
			));
		}
		if('dnxt-hover-overline-from-left' === $this->props['dnxt_dual_two_hover_border']){
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonTwo.dnxt-hover-overline-from-left:before",
				'declaration' => "background: {$this->props['dnxt_dual_two_overline_left_color']};"
			));
		}
		// Hover One & Two Overline From Center Color
		if('dnxt-hover-overline-from-center' === $this->props['dnxt_dual_one_hover_border']){
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonOne.dnxt-hover-overline-from-center:before",
				'declaration' => "background: {$this->props['dnxt_dual_one_overline_center_color']};"
			));
		}
		if('dnxt-hover-overline-from-center' === $this->props['dnxt_dual_two_hover_border']){
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonTwo.dnxt-hover-overline-from-center:before",
				'declaration' => "background: {$this->props['dnxt_dual_two_overline_center_color']};"
			));
		}
		// Hover One & Two Overline From Right Color
		if('dnxt-hover-overline-from-right' === $this->props['dnxt_dual_one_hover_border']){
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonOne.dnxt-hover-overline-from-right:before",
				'declaration' => "background: {$this->props['dnxt_dual_one_overline_right_color']};"
			));
		}
		if('dnxt-hover-overline-from-right' === $this->props['dnxt_dual_two_hover_border']){
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonTwo.dnxt-hover-overline-from-right:before",
				'declaration' => "background: {$this->props['dnxt_dual_two_overline_right_color']};"
			));
		}
		// Hover One & Two Reveal Color
		if('dnxt-hover-reveal' === $this->props['dnxt_dual_one_hover_border']){
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonOne.dnxt-hover-reveal:before",
				'declaration' => "border-color: {$this->props['dnxt_dual_one_reveal_color']};"
			));
		}
		if('dnxt-hover-reveal' === $this->props['dnxt_dual_two_hover_border']){
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonTwo.dnxt-hover-reveal:before",
				'declaration' => "border-color: {$this->props['dnxt_dual_two_reveal_color']};"
			));
		}
		// Hover One & Two Underline Reveal Color
		if('dnxt-hover-underline-reveal' === $this->props['dnxt_dual_one_hover_border']){
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonOne.dnxt-hover-underline-reveal:before",
				'declaration' => "background: {$this->props['dnxt_dual_one_underline_reveal_color']};"
			));
		}
		if('dnxt-hover-underline-reveal' === $this->props['dnxt_dual_two_hover_border']){
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonTwo.dnxt-hover-underline-reveal:before",
				'declaration' => "background: {$this->props['dnxt_dual_two_underline_reveal_color']};"
			));
		}
		// Hover One & Two Underline overline Color
		if('dnxt-hover-overline-reveal' === $this->props['dnxt_dual_one_hover_border']){
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonOne.dnxt-hover-overline-reveal:before",
				'declaration' => "background: {$this->props['dnxt_dual_one_overline_reveal_color']};"
			));
		}
		if('dnxt-hover-overline-reveal' === $this->props['dnxt_dual_two_hover_border']){
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% a.buttonTwo.dnxt-hover-overline-reveal:before",
				'declaration' => "background: {$this->props['dnxt_dual_two_overline_reveal_color']};"
			));
		}


	}
	public function multi_view_filter_value( $raw_value, $args, $multi_view ) {
		$name = isset( $args['name'] ) ? $args['name'] : '';

		if ( $raw_value && in_array( $name, array('btn_one_icon', 'btn_two_icon') )){
			return et_pb_get_extended_font_icon_value( $raw_value, true );
		}
		return $raw_value;
	}
}

new Next_Dual_Button;
