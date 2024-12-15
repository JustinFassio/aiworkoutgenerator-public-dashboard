<?php
include_once(DIVI_ESSENTIAL_PATH . '/includes/modules/base/Common.php');

class Next_Blurb extends ET_Builder_Module {

	public $slug       = 'dnxte_blurb';
	public $vb_support = 'on';

	protected $module_credits = array(
		'module_uri' => 'https://www.diviessential.com/divi-next-blurb/',
		'author'     => 'Divi Next',
		'author_uri' => 'www.divinext.com',
	);

	public function init() {
		$this->name        = esc_html__( 'Next Blurb', 'et_builder' );
		$this->icon_path   = plugin_dir_path( __FILE__ ) . 'icon.svg';
		$this->folder_name = 'et_pb_divi_essential';

		$this->settings_modal_toggles = array(
			'general'	=> array(
				'toggles'		=>	array(
					'dnxt_blurb_heading'			=> esc_html__( 'Text', 'et_builder' ),
					'dnxt_blurb_image_icon'		 	=> esc_html__( 'Image & Icon', 'et_builder' ),
					'dnxt_blurb_button_text'	  	=> esc_html__( 'Button', 'et_builder' ),
					'dnxt_blurb_heading_background'	=> array(
						'title'		=>	esc_html__( 'Background Heading', 'et_builder' ),
						'priority'	=>	78,
						'sub_toggles'       => array(
                            'sub_toggle_color'   => array(
								'name' => esc_html__( 'Color', 'et_builder' )
                            ),
                            'sub_toggle_gradient'   => array(
								'name' => esc_html__( 'Gradient', 'et_builder' )
                            )
                        ),
                        'tabbed_subtoggles' => true,
					),
					'dnxt_blurb_content_background'	=> array(
						'title'		=>	esc_html__( 'Background Description', 'et_builder' ),
						'priority'	=>	78,
						'sub_toggles'       => array(
                            'sub_toggle_color'   => array(
								'name' => esc_html__( 'Color', 'et_builder' )
                            ),
                            'sub_toggle_gradient'   => array(
								'name' => esc_html__( 'Gradient', 'et_builder' )
                            )
                        ),
                        'tabbed_subtoggles' => true,
					),
					'dnxt_blurb_background_image_icon'	=> array(
						'title'		=>	esc_html__( 'Background Image & Icon', 'et_builder' ),
						'priority'	=>	78,
						'sub_toggles'       => array(
                            'sub_toggle_image'   => array(
								'name' => esc_html__( 'Image', 'et_builder' )
                            ),
                            'sub_toggle_icon'   => array(
								'name' => esc_html__( 'Icon', 'et_builder' )
                            )
                        ),
                        'tabbed_subtoggles' => true,
					),
					'dnxt_blurb_image_background'	=> array(
						'title'		=>	esc_html__( 'Background Image', 'et_builder' ),
						'priority'	=>	79,
						'sub_toggles'       => array(
                            'sub_toggle_color'   => array(
								'name' => esc_html__( 'Color', 'et_builder' )
                            ),
                            'sub_toggle_gradient'   => array(
								'name' => esc_html__( 'Gradient', 'et_builder' )
                            )
                        ),
                        'tabbed_subtoggles' => true,
					),
					'dnxt_blurb_icon_background'	=> array(
						'title'		=>	esc_html__( 'Background Icon', 'et_builder' ),
						'priority'	=>	79,
						'sub_toggles'       => array(
                            'sub_toggle_color'   => array(
								'name' => esc_html__( 'Color', 'et_builder' )
                            ),
                            'sub_toggle_gradient'   => array(
								'name' => esc_html__( 'Gradient', 'et_builder' )
                            )
                        ),
                        'tabbed_subtoggles' => true,
					),
					'dnxt_blurb_button_background'	=> array(
						'title'		=>	esc_html__( 'Background Button', 'et_builder' ),
						'priority'	=>	79,
						'sub_toggles'       => array(
                            'sub_toggle_color'   => array(
								'name' => esc_html__( 'Color', 'et_builder' )
                            ),
                            'sub_toggle_gradient'   => array(
								'name' => esc_html__( 'Gradient', 'et_builder' )
                            )
                        ),
                        'tabbed_subtoggles' => true,
					),
					'dnxt_blurb_image_mask' => esc_html__('Image Mask', 'et_builder')
				),
			),
			'advanced'	=> array(
				'toggles'	=>	array(					
					'dnxt_blurb_image_design'	=> esc_html__( 'Image', 'et_builder' ),
					'dnxt_blurb_icon_design'	=> esc_html__( 'Icon', 'et_builder' ),
					'dnxt_blurb_hover_effect'	=> array(
						"title"		=>	esc_html__( 'Hover Effect', 'et_builder' ),
						'sub_toggles'       => array(
                            'sub_toggle_2d_effect'   => array(
                                'name' => esc_html__( '2d Effect', 'et_builder' ),
							),
							'sub_toggle_tilt_effect'   => array(
                                'name' => esc_html__( "Tilt Effect", 'et_builder' ),
							),
						),
						'tabbed_subtoggles' => true,
					),
					'dnxt_blurb_title_design'	=> array(
						"title"		=>	esc_html__( 'Title Text', 'et_builder' ),
						'sub_toggles'       => array(
                            'sub_toggle_pre'   => array(
                                'name' => esc_html__( "Pre", 'et_builder' )
                            ),
                            'sub_toggle_heading'   => array(
                                'name' => esc_html__( "Heading", 'et_builder' ),
                            ),
                            'sub_toggle_post' => array(
                                'name' => esc_html__( 'Post', 'et_builder' ),
							),
                        ),
                        'tabbed_subtoggles' => true,
					),
					'dnxt_blurb_image_icon_space'	=> array(
						"title"		=>	esc_html__( 'Image/Icon Spacing', 'et_builder' ),
						'priority'	=>	91,
						'sub_toggles'       => array(
                            'sub_toggle_image_space'   => array(
                                'name' => esc_html__( 'Image', 'et_builder' ),
                            ),
                            'sub_toggle_icon_space'   => array(
                                'name' => esc_html__( 'Icon', 'et_builder' ),
                            ),
                        ),
                        'tabbed_subtoggles' => true,
					),
					'dnxt_blurb_header_space'	=> array(
						"title"		=>	esc_html__( 'Header Spacing', 'et_builder' ),
						'priority'	=>	92,
						'sub_toggles'       => array(
                            'sub_toggle_pre_space'   => array(
                                'name' => esc_html__( 'Pre', 'et_builder' ),
                            ),
                            'sub_toggle_header_space'   => array(
                                'name' => esc_html__( 'Header', 'et_builder' ),
                            ),
                            'sub_toggle_post_space'   => array(
                                'name' => esc_html__( 'Post', 'et_builder' ),
                            ),
                        ),
                        'tabbed_subtoggles' => true,
					),
					'dnxt_blurb_body_content_space'	=> array(
						"title"		=>	esc_html__( 'Body/Description Spacing', 'et_builder' ),
						'priority'	=>	93,
						'sub_toggles'       => array(
                            'sub_toggle_body_space'   => array(
                                'name' => esc_html__( 'Body', 'et_builder' ),
                            ),
                            'sub_toggle_content_space'   => array(
                                'name' => esc_html__( 'Content', 'et_builder' ),
                            ),
                        ),
                        'tabbed_subtoggles' => true,
					), 
					'dnxt_blurb_button_space'	=> array(
						"title"		=>	esc_html__( 'Button Spacing', 'et_builder' ),
						'priority'	=>	94,
					),
					'dnxt_blurb_post_border'	=> array(
						"title"		=>	esc_html__( 'Post Heading Border', 'et_builder' ),
						'priority'	=>	100,
					), 
					'dnxt_blurb_header_border'	=> array(
						"title"		=>	esc_html__( 'Heading Border', 'et_builder' ),
						'priority'	=>	100,
					), 
					'dnxt_blurb_pre_border'	=> array(
						"title"		=>	esc_html__( 'Pre Heading Border', 'et_builder' ),
						'priority'	=>	100,
					),
					'dnxt_blurb_body_border'	=> array(
						"title"		=>	esc_html__( 'Body Border', 'et_builder' ),
						'priority'	=>	100,
					), 
					'dnxt_blurb_content_border'	=> array(
						"title"		=>	esc_html__( 'Description Border', 'et_builder' ),
						'priority'	=>	100,
					), 
					'dnxt_blurb_button_border'	=> array(
						"title"		=>	esc_html__( 'Button Border', 'et_builder' ),
						'priority'	=>	100,
					),
					'dnxt_blurb_button_font'	=> array(
						"title"		=>	esc_html__( 'Button Text', 'et_builder' ),
						'priority'	=>	60,
					),
					'dnxt_blurb_button_icon'	=> array(
						"title"		=>	esc_html__( 'Button Icon', 'et_builder' ),
						'priority'	=>	61,
					),
					'button_hover'      => array(
                        'title'             => esc_html__( 'Button Hover', 'et_builder' ),
                        'priority'          => 62,
                        'sub_toggles'       => array(
                            'sub_toggle_2d'   => array(
                                'name' => esc_html__( '2D', 'et_builder' ),
                            ),
                            'sub_toggle_bg'   => array(
                                'name' => esc_html__( 'BG', 'et_builder' ),
                            ),
                            'sub_toggle_border' => array(
                                'name' => esc_html__( 'Stroke', 'et_builder' ),
							),
							'sub_toggle_icons' => array(
                                'name' => esc_html__( 'Icon', 'et_builder' ),
                            ),
                        ),

                        'tabbed_subtoggles' => true,
					),
					'dnxt_blurb_button_box_shadow'	=> array(
						"title"		=>	esc_html__( 'Button Box Shadow', 'et_builder' ),
						'priority'	=>	102,
					),
					'dnxt_blurb_description_box_shadow'	=> array(
						"title"		=>	esc_html__( 'Body Box Shadow', 'et_builder' ),
						'priority'	=>	102,
					),
				), 
			),			
			'custom_css' => array(
				'toggles' => array(
					'dnxt_blurb_attributes' => array(
						'title'    => esc_html__( 'Attributes', 'et_builder' ),
						'priority' => 95,
					),
					'dnxt_blurb_zindex' => array(
						'title'    => esc_html__( 'Zindex', 'et_builder' ),
						'priority' => 100,
					),
				),
			),
		);

		// Custom CSS Field
		$this->custom_css_fields = array(
			'image_wrapper' => array(
				'label'    => esc_html__( 'Image', 'et_builder' ),
				'selector' => '%%order_class%% .dnxt-blurb-image .img-fluid',
			),
			'icon_wrapper'  => array(
				'label'    => esc_html__( 'Icon', 'et_builder' ),
				'selector' => '%%order_class%% .dnxt-blurb-icon span',
			),
			'pre_heading_wrapper'  => array(
				'label'    => esc_html__( 'Pre Heading', 'et_builder' ),
				'selector' => '%%order_class%% .dnxt-blurb-pre-heading',
			),
			'heading_wrapper'  => array(
				'label'    => esc_html__( 'Heading', 'et_builder' ),
				'selector' => '%%order_class%% .dnxt-blurb-heading',
			),
			'post_heading_wrapper'  => array(
				'label'    => esc_html__( 'Post Heading', 'et_builder' ),
				'selector' => '%%order_class%% .dnxt-blurb-post-heading',
			),
			'body_wrapper'  => array(
				'label'    => esc_html__( 'Description', 'et_builder' ),
				'selector' => '%%order_class%% .dnxt-blurb-container',
			),
			'button_wrapper'  => array(
				'label'    => esc_html__( 'Button', 'et_builder' ),
				'selector' => '%%order_class%% .dnxt-button-wrapper .dnxt-blurb-btn',
			),
		);
	}

	public function get_fields() {
		return array(
			// Pre Heading Switch
			'blurb_pre_switch'	  => array(
				'label'           => esc_html__( 'Pre Heading Enable', 'et_builder' ),
				'type'            => 'yes_no_button',
				'toggle_slug'     => 'dnxt_blurb_heading',
				'options'   => array(
					'off'     => esc_html__( 'Off', 'et_builder' ),
					'on'      => esc_html__( 'On', 'et_builder' ),
				),
				'affects'         => array(
					'blurb_pre_heading',
					'pre_heading_tag'
				),
				'default_on_front'=> 'off',
			),
			// Pre Heading Text Field
			'blurb_pre_heading'   => array(
				'label'           => esc_html__( 'Pre Heading Text', 'et_builder' ),
				'type'            => 'text',
				'dynamic_content' => 'text',
				//'default'         => 'Pre Heading',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Pre Heading Text entered here will appear inside the module.', 'et_builder' ),
				'toggle_slug'     => 'dnxt_blurb_heading',
				'depends_show_if' => 'on',
			),
			// Pre Heading Tag
			'pre_heading_tag'     => array(
                'label'           => esc_html__( 'Select Pre Heading Tag', 'et_builder' ),
                'type'            => 'select',
                'description'     => esc_html__( 'Select the Pre heading tag, which you would like to use', 'et_builder' ),
                'option_category' => 'basic_option',
                'toggle_slug'     => 'dnxt_blurb_heading',
                'options'         => array(
                    'h1'	  => esc_html__( 'H1', 'et_builder' ),
                    'h2'	  => esc_html__( 'H2', 'et_builder' ),
                    'h3'	  => esc_html__( 'H3', 'et_builder' ),
                    'h4'	  => esc_html__( 'H4', 'et_builder' ),
                    'h5'	  => esc_html__( 'H5', 'et_builder' ),
                    'h6'	  => esc_html__( 'H6', 'et_builder' ),
                    'p'	      => esc_html__( 'P', 'et_builder' ),
                    'span'	  => esc_html__( 'Span', 'et_builder' ),
                ),
				'default'         => 'span',
				'depends_show_if' => 'on',
			),
			// Main Heading Text Field
			'blurb_heading'      	=> array(
				'label'           	=> esc_html__( 'Heading Text', 'et_builder' ),
				'type'            	=> 'text',
				'dynamic_content' 	=> 'text',
				//'default'         	=> 'Heading',
				'option_category' 	=> 'basic_option',
				'description'     	=> esc_html__( 'Main Heading entered here will appear inside the module.', 'et_builder' ),
				'toggle_slug'     	=> 'dnxt_blurb_heading',
			),
			//Heading Tag
			'heading_tag'         => array(
				'label'           => esc_html__( 'Select Heading Tag', 'et_builder' ),
				'type'            => 'select',
				'description'     => esc_html__( 'Select the heading tag, which you would like to use', 'et_builder' ),
				'option_category' => 'basic_option',
				'toggle_slug'     => 'dnxt_blurb_heading',
				'options'         => array(
					'h1'	  => esc_html__( 'H1', 'et_builder' ),
					'h2'	  => esc_html__( 'H2', 'et_builder' ),
					'h3'	  => esc_html__( 'H3', 'et_builder' ),
					'h4'	  => esc_html__( 'H4', 'et_builder' ),
					'h5'	  => esc_html__( 'H5', 'et_builder' ),
					'h6'	  => esc_html__( 'H6', 'et_builder' ),
					'p'	      => esc_html__( 'P', 'et_builder' ),
					'span'	  => esc_html__( 'Span', 'et_builder' ),
				),
				'default'         => 'h2',
			),
			// Post Heading Switch
			'blurb_post_switch'		=> array(
				'label'           	=> esc_html__( 'Post Heading Enable', 'et_builder' ),
				'type'            	=> 'yes_no_button',  
				'toggle_slug'     	=> 'dnxt_blurb_heading',
				'options'         	=> array(
					'off'     		=> esc_html__('Off', 'et_builder'),
					'on'      		=> esc_html__('On', 'et_builder'),
				),
				'affects'         	=> array(
					'blurb_post_heading',
					'post_heading_tag'
				),
				'default_on_front' => 'off',
			),
			// Post Heading Text Field
			'blurb_post_heading'  => array(
				'label'           => esc_html__( 'Post Heading Text', 'et_builder' ),
				'type'            => 'text',
				'dynamic_content' => 'text',
				//'default'         => 'Post Heading',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Post Heading Text entered here will appear inside the module.', 'et_builder' ),
				'toggle_slug'     => 'dnxt_blurb_heading',
				'depends_show_if' => 'on',
			),
			//Post Heading Tag
			'post_heading_tag'    => array(
				'label'           => esc_html__('Select Post Heading Tag', 'et_builder'),
				'type'            => 'select',
				'description'     => esc_html__('Select the Post heading tag, which you would like to use', 'et_builder'),
				'option_category' => 'basic_option',
				'toggle_slug'     => 'dnxt_blurb_heading',
				'options'         => array(
					'h1'	  	  => esc_html__('H1', 'et_builder'),
					'h2'	  	  => esc_html__('H2', 'et_builder'),
					'h3'	  	  => esc_html__('H3', 'et_builder'),
					'h4'	  	  => esc_html__('H4', 'et_builder'),
					'h5'	  	  => esc_html__('H5', 'et_builder'),
					'h6'	  	  => esc_html__('H6', 'et_builder'),
					'p'	      	  => esc_html__('P', 'et_builder'),
					'span'	  	  => esc_html__('Span', 'et_builder'),
				),
				'default'         => 'span',
				'depends_show_if' => 'on',
			),
			'blurb_description' 	=> array(
				'label'           	=> esc_html__( 'Description', 'et_builder' ),
				'type'            	=> 'tiny_mce',
				'dynamic_content' 	=> 'text',
				'option_category' 	=> 'basic_option',
				//'description'     	=> esc_html__( 'Description entered here will appear inside the module.', 'et_builder' ),
				'toggle_slug'     	=> 'dnxt_blurb_heading',
			),
			'dnxt_use_icon' 	  => array(
				'label'           => esc_html__( 'Use Icon', 'et_builder' ),
				'type'            => 'yes_no_button',
				'options'         => array(
					'off' 		  => esc_html__( 'No', 'et_builder' ),
					'on'  		  => esc_html__( 'Yes', 'et_builder' ),
				),
				'toggle_slug'     => 'dnxt_blurb_image_icon',
				'description' 	  => esc_html__( 'Here you can choose whether icon set below should be used.', 'et_builder' ),
				'default_on_front'=> 'off',
				'affects'         => array(
					'border_radii_image',
					'border_styles_image',
					'dnxt_font_icon',
					'font_icon_placement',
					'image_max_width',
					'use_icon_font_size',
					'use_circle',
					'icon_color',
				),
			),
			// Button Icon
			'dnxt_font_icon' 		  =>	array(
				'label'               => esc_html__( 'Icon', 'et_builder' ),
				'type'                => 'select_icon',
				'option_category'     => 'basic_option',
				'class'               => array( 'et-pb-font-icon' ),
				'toggle_slug'         => 'dnxt_blurb_image_icon',
				'description'         => esc_html__( 'Choose an icon to display with your blurb.', 'et_builder' ),
				'default'             => '!||divi',
				'depends_show_if'     => 'on',
				'mobile_options'      => true,
				'hover'               => 'tabs',
			),
			// Button Icon Placement
			'font_icon_placement'	=> array(
				'label'				=> esc_html__( 'Button Icon Placement', 'et_builder' ),
				'description'       => esc_html__( 'Choose where the button icon should be displayed within the button.', 'et_builder' ),
				'type'              => 'select',
				'option_category'	=> 'layout',
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'dnxt_blurb_icon_design',
				'option_category'   => 'layout',
				'options'           => array(
					'dnxt-blurb-wrapper-two-top-left'		=> esc_html__( 'Top Left', 'et_builder' ),
					'dnxt-blurb-wrapper-two-top-center'		=> esc_html__( 'Top Center', 'et_builder' ),
					'dnxt-blurb-wrapper-two-top-right'		=> esc_html__( 'Top Right', 'et_builder' ),
					'dnxt-blurb-wrapper-two-left-top'		=> esc_html__( 'Left Top', 'et_builder' ),
					'dnxt-blurb-wrapper-two-left-center'	=> esc_html__( 'Left Center', 'et_builder' ),
					'dnxt-blurb-wrapper-two-left-bottom'	=> esc_html__( 'Left Bottom', 'et_builder' ),
					'dnxt-blurb-wrapper-two-bottom-left'	=> esc_html__( 'Bottom Left', 'et_builder' ),
					'dnxt-blurb-wrapper-two-bottom-center'	=> esc_html__( 'Bottom Center', 'et_builder' ),
					'dnxt-blurb-wrapper-two-bottom-right'	=> esc_html__( 'Bottom Right', 'et_builder' ),
					'dnxt-blurb-wrapper-two-right-top'		=> esc_html__( 'Right Top', 'et_builder' ),
					'dnxt-blurb-wrapper-two-right-center'	=> esc_html__( 'Right Center', 'et_builder' ),
					'dnxt-blurb-wrapper-two-right-bottom'	=> esc_html__( 'Right Bottom', 'et_builder' ),
				),
				'default'             => 'right',
			),
			'font_icon_color' 		=> array(
				'label'             => esc_html__( 'Icon Color', 'et_builder' ),
				'type'              => 'color-alpha',
				'description'       => esc_html__( 'Here you can define a custom color for your icon.', 'et_builder' ),
				'tab_slug'          => 'advanced',
				'default'			=> '#666',
				'toggle_slug'       => 'dnxt_blurb_icon_design',
				'mobile_options'	=> true,
				'responsive'		=> true,
				'hover'             => 'tabs',
			),
			'font_icon_size' 	  => array(
				'label'           => esc_html__( 'Icon Font Size', 'et_builder' ),
				'description'     => esc_html__( 'Control the size of the icon by increasing or decreasing the font size.', 'et_builder' ),
				'type'            => 'range',
				'option_category' => 'layout',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dnxt_blurb_icon_design',
				'default'         => '96px',
				'default_unit'    => 'px',
				'default_on_front'=> '',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'range_settings'  => array(
					'min'  		  => '1',
					'max'  		  => '120',
					'step' 		  => '1',
				),
				'mobile_options'  => true,
				'responsive'	  => true,
				'hover'           => 'tabs',
			),
			'use_font_icon_bg_color' => array(
				'label'           	 => esc_html__( 'Use Icon Font Background Color', 'et_builder' ),
				'description'        => esc_html__( 'If you would like to control the background color of the icon, you must first enable this option.', 'et_builder' ),
				'type'            	 => 'yes_no_button',
				'options'         	 => array(
					'off' 			 => esc_html__( 'No', 'et_builder' ),
					'on'  			 => esc_html__( 'Yes', 'et_builder' ),
				),
				'depends_show_if'  	 => 'on',
				'toggle_slug'      	 => 'dnxt_blurb_icon_background',
				'sub_toggle'	  	 => 'sub_toggle_color',
				'default_on_front' 	 => 'off',
				'affects'     		 => array(
					'font_icon_bg_color',
				),
			),
			'font_icon_bg_color' 	=> array(
				'label'             => esc_html__( 'Icon Background Color', 'et_builder' ),
				'type'              => 'color-alpha',
				'description'       => esc_html__( 'Here you can define a custom color for your icon.', 'et_builder' ),
				'toggle_slug'       => 'dnxt_blurb_icon_background',
				'sub_toggle'	  	=> 'sub_toggle_color',
				'hover'             => 'tabs',
				'mobile_options'	=> true,
				'responsive'		=> true,
				'depends_show_if' 	=> 'on',
			),
			'use_font_icon_gradient_show_hide'  => array(
				'label'           => esc_html__( 'Background Gradient Color', 'et_builder'),
				'type'            => 'yes_no_button', 
				'toggle_slug'     => 'dnxt_blurb_icon_background',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'options'             => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'affects'         => array(
					'font_icon_gradient_color_one',
					'font_icon_gradient_color_two',
					'font_icon_gradient_type',
					'font_icon_gradient_start_position',
					'font_icon_gradient_end_position'
				),
				'default_on_front' => 'off',
				'depends_show_if' 	=> 'on',
			),
			'font_icon_gradient_color_one'	=> array(
                'label'          => esc_html__('Select Color One', 'et_builder'),
                'type'           => 'color-alpha',
				'toggle_slug'    => 'dnxt_blurb_icon_background',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'default'        => '#2b87da',
				'depends_show_if'=> 'on',
			),
			'font_icon_gradient_color_two'	=> array(
                'label'          => esc_html__('Select Color Two', 'et_builder'),
                'type'           => 'color-alpha',
				'toggle_slug'    => 'dnxt_blurb_icon_background',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'default'        => '#29c4a9',
				'depends_show_if'=> 'on',
			),
			'font_icon_gradient_type'		=> array(
                'label'           => esc_html__('Select Gradient Type', 'et_builder'),
                'type'            => 'select',
				'description'     => esc_html__('Select the types of gradient', 'et_builder'),
                'option_category' => 'basic_option',
				'toggle_slug'     => 'dnxt_blurb_icon_background',
				'sub_toggle'	  => 'sub_toggle_gradient',
                'options'         => array(
                    'linear-gradient' => esc_html__('Linear', 'et_builder'),
                    'radial-gradient' => esc_html__('Radial', 'et_builder'),
                ),
				'default'         => 'linear-gradient',
				'depends_show_if' => 'on',
			),
			'font_icon_gradient_type_linear_direction'   => array(
                'label'           => esc_html__('Gradient direction', 'et_builder'),
                'type'            => 'range',
                'option_category'=> 'basic_option',
				'toggle_slug'    => 'dnxt_blurb_icon_background',
				'sub_toggle'	 => 'sub_toggle_gradient',
                'range_settings'  => array(
                    'step' => 1,
                    'min'  => 1,
                    'max'  => 360,
                ),
                'default'         => '180deg',
                'fixed_unit'      => 'deg',
				'show_if' => array(
					'use_font_icon_gradient_show_hide' => 'on',
					'font_icon_gradient_type' => 'linear-gradient'
				),
			),
			'font_icon_gradient_type_radial_direction'   => array(
                'label'           	=> esc_html__('Radial Direction', 'et_builder'),
                'type'            	=> 'select',
				'description'     	=> esc_html__('Select the types of gradient', 'et_builder'),                
                'option_category'	=> 'basic_option',
				'toggle_slug'    	=> 'dnxt_blurb_icon_background',
				'sub_toggle'	 	=> 'sub_toggle_gradient',
                'options'       	=> array(
                    'circle at center'       => esc_html__(	'Center', 'et_builder'),
                    'circle at left'         => esc_html__(	'Top Left', 'et_builder'),
                    'circle at top'          => esc_html__(	'Top',	'et_builder'),
                    'circle at top right'    => esc_html__(	'Top Right', 'et_builder'),
                    'circle at right'        => esc_html__(	'Right', 'et_builder'),
                    'circle at bottom right' => esc_html__(	'Bottom Right', 'et_builder'),
                    'circle at bottom'       => esc_html__(	'Bottom', 'et_builder'),
                    'circle at bottom left'  => esc_html__(	'Bottom Left', 'et_builder'),
                    'circle at left'         => esc_html__(	'Left', 'et_builder'),

                ),
                'default'         => 'circle at center',
				'show_if'         => array(
					'use_font_icon_gradient_show_hide' => 'on',
					'font_icon_gradient_type'		=> 'radial-gradient'
                ),
			),
			'font_icon_gradient_start_position'           => array(
                'label'           => esc_html__('Start Position', 'et_builder'),
                'type'            => 'range',
                'option_category' => 'basic_option',
				'toggle_slug'     => 'dnxt_blurb_icon_background',
				'sub_toggle'	  => 'sub_toggle_gradient',
                'range_settings'  => array(
                    'step' => 1,
                    'min'  => 1,
                    'max'  => 100,
                ),
                'default'         => '0%',
                'fixed_unit'      => '%',
				'depends_show_if' => 'on',
			),
			'font_icon_gradient_end_position'             => array(
                'label'           => esc_html__('End Position', 'et_builder'),
                'type'            => 'range',
                'option_category' => 'basic_option',
				'toggle_slug'     => 'dnxt_blurb_icon_background',
				'sub_toggle'	  => 'sub_toggle_gradient',
                'range_settings'  => array(
                    'step' => 1,
                    'min'  => 1,
                    'max'  => 100,
                ),
                'default'         => '100%',
                'fixed_unit'      => '%',
				'depends_show_if' => 'on',
			),
			'use_image_bg_color' => array(
				'label'           => esc_html__( 'Use Image Background Color', 'et_builder' ),
				'description'     => esc_html__( 'If you would like to control the background color of the icon, you must first enable this option.', 'et_builder' ),
				'type'            => 'yes_no_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'et_builder' ),
					'on'  => esc_html__( 'Yes', 'et_builder' ),
				),
				'affects'     => array(
					'image_bg_color',
				),
				'depends_show_if'  	=> 'on',
				'toggle_slug'      	=> 'dnxt_blurb_image_background',
				'sub_toggle'	  	=> 'sub_toggle_color',
				'default_on_front' 	=> 'off',
			),
			'image_bg_color' => array(
				'label'             => esc_html__( 'Image Background Color', 'et_builder' ),
				'type'              => 'color-alpha',
				'description'       => esc_html__( 'Here you can define a custom background color for your image.', 'et_builder' ),
				'toggle_slug'       => 'dnxt_blurb_image_background',
				'sub_toggle'	  	=> 'sub_toggle_color',
				'hover'             => 'tabs',
				'mobile_options'	=> true,
				'responsive'		=> true,
				'depends_show_if' 	=> 'on',
			),
			'bg_img_gradient_show_hide'  => array(
				'label'           => esc_html__( 'Background Gradient Color', 'et_builder'),
				'type'            => 'yes_no_button', 
				'toggle_slug'     => 'dnxt_blurb_image_background',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'options'             => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'affects'         => array(
					'bg_img_gradient_color_one',
					'bg_img_gradient_color_two',
					'bg_img_gradient_type',
					'bg_img_gradient_start_position',
					'bg_img_gradient_end_position'
				),
				'default_on_front' => 'off',
				'depends_show_if' 	=> 'on',
			),
			'bg_img_gradient_color_one'	=> array(
                'label'          => esc_html__('Select Color One', 'et_builder'),
                'type'           => 'color-alpha',
				'toggle_slug'    => 'dnxt_blurb_image_background',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'default'        => '#2b87da',
				'depends_show_if'=> 'on',
			),
			'bg_img_gradient_color_two'	=> array(
                'label'          => esc_html__('Select Color Two', 'et_builder'),
                'type'           => 'color-alpha',
				'toggle_slug'    => 'dnxt_blurb_image_background',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'default'        => '#29c4a9',
				'depends_show_if'=> 'on',
			),
			'bg_img_gradient_type'=> array(
                'label'           => esc_html__('Select Gradient Type', 'et_builder'),
                'type'            => 'select',
				'description'     => esc_html__('Select the types of gradient', 'et_builder'),
                'option_category' => 'basic_option',
				'toggle_slug'     => 'dnxt_blurb_image_background',
				'sub_toggle'	  => 'sub_toggle_gradient',
                'options'         => array(
                    'linear-gradient' => esc_html__('Linear', 'et_builder'),
                    'radial-gradient' => esc_html__('Radial', 'et_builder'),
                ),
				'default'         => 'linear-gradient',
				'depends_show_if' => 'on',
			),
			'bg_img_gradient_type_linear_direction'   => array(
                'label'           => esc_html__('Gradient direction', 'et_builder'),
                'type'            => 'range',
                'option_category'=> 'basic_option',
				'toggle_slug'    => 'dnxt_blurb_image_background',
				'sub_toggle'	 => 'sub_toggle_gradient',
                'range_settings'  => array(
                    'step' => 1,
                    'min'  => 1,
                    'max'  => 360,
                ),
                'default'         => '180deg',
                'fixed_unit'      => 'deg',
				'show_if' => array(
					'bg_img_gradient_show_hide' => 'on',
					'bg_img_gradient_type' => 'linear-gradient'
				),
			),
			'bg_img_gradient_type_radial_direction'   => array(
                'label'           	=> esc_html__('Radial Direction', 'et_builder'),
                'type'            	=> 'select',
				'description'     	=> esc_html__('Select the types of gradient', 'et_builder'),                
                'option_category'	=> 'basic_option',
				'toggle_slug'    	=> 'dnxt_blurb_image_background',
				'sub_toggle'	 	=> 'sub_toggle_gradient',
                'options'       	=> array(
                    'circle at center'       => esc_html__(	'Center', 'et_builder'),
                    'circle at left'         => esc_html__(	'Top Left', 'et_builder'),
                    'circle at top'          => esc_html__(	'Top',	'et_builder'),
                    'circle at top right'    => esc_html__(	'Top Right', 'et_builder'),
                    'circle at right'        => esc_html__(	'Right', 'et_builder'),
                    'circle at bottom right' => esc_html__(	'Bottom Right', 'et_builder'),
                    'circle at bottom'       => esc_html__(	'Bottom', 'et_builder'),
                    'circle at bottom left'  => esc_html__(	'Bottom Left', 'et_builder'),
                    'circle at left'         => esc_html__(	'Left', 'et_builder'),

                ),
                'default'         => 'circle at center',
				'show_if'         => array(
					'bg_img_gradient_show_hide' => 'on',
					'bg_img_gradient_type'		=> 'radial-gradient'
                ),
			),
			'bg_img_gradient_start_position'	=> array(
                'label'           => esc_html__('Start Position', 'et_builder'),
                'type'            => 'range',
                'option_category' => 'basic_option',
				'toggle_slug'     => 'dnxt_blurb_image_background',
				'sub_toggle'	  => 'sub_toggle_gradient',
                'range_settings'  => array(
                    'step' => 1,
                    'min'  => 1,
                    'max'  => 100,
                ),
                'default'         => '0%',
                'fixed_unit'      => '%',
				'depends_show_if' => 'on',
			),
			'bg_img_gradient_end_position'	=> array(
                'label'           => esc_html__('End Position', 'et_builder'),
                'type'            => 'range',
                'option_category' => 'basic_option',
				'toggle_slug'     => 'dnxt_blurb_image_background',
				'sub_toggle'	  => 'sub_toggle_gradient',
                'range_settings'  => array(
                    'step' => 1,
                    'min'  => 1,
                    'max'  => 100,
                ),
                'default'         => '100%',
                'fixed_unit'      => '%',
				'depends_show_if' => 'on',
			),
			// Image
			'dnxt_image' 			 =>	array(
				'label'              => esc_html__( 'Image', 'et_builder' ),
				'type'               => 'upload',
				'option_category'    => 'basic_option',
				'upload_button_text' => esc_attr__( 'Upload an image', 'et_builder' ),
				'choose_text'        => esc_attr__( 'Choose an Image', 'et_builder' ),
				'update_text'        => esc_attr__( 'Set As Image', 'et_builder' ),
				'description'        => esc_html__( 'Upload an image to display at the top of your blurb.', 'et_builder' ),
				'toggle_slug'        => 'dnxt_blurb_image_icon',
				'dynamic_content'    => 'image',
				'hover'              => 'tabs',
				'mobile_options'	 => true,
			),
			// Image alt
			'dnxt_alt' 			  => array(
				'label'           => esc_html__( 'Image Alt Text', 'et_builder' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Define the HTML ALT text for your image here.', 'et_builder' ),
				'tab_slug'        => 'custom_css',
				'toggle_slug'     => 'dnxt_blurb_attributes',
				'dynamic_content' => 'text',
			),
			// Image Placement 
			'image_placement'		=>	array(
				'label'				=> esc_html__( 'Image Placement', 'et_builder' ),
				'description'       => esc_html__( 'Choose where the image should be displayed within the button.', 'et_builder' ),
				'type'              => 'select',
				'option_category'	=> 'layout',
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'dnxt_blurb_image_design',
				'options'           => array(
					'top-left'		=> esc_html__( 'Top Left', 'et_builder' ),
					'top-center'	=> esc_html__( 'Top Center', 'et_builder' ),
					'top-right'		=> esc_html__( 'Top Right', 'et_builder' ),
					'left-top'		=> esc_html__( 'Left Top', 'et_builder' ),
					'left-center'	=> esc_html__( 'Left Center', 'et_builder' ),
					'left-bottom'	=> esc_html__( 'Left Bottom', 'et_builder' ),
					'bottom-left'	=> esc_html__( 'Bottom Left', 'et_builder' ),
					'bottom-center'	=> esc_html__( 'Bottom Center', 'et_builder' ),
					'bottom-right'	=> esc_html__( 'Bottom Right', 'et_builder' ),
					'right-top'		=> esc_html__( 'Right Top', 'et_builder' ),
					'right-center'	=> esc_html__( 'Right Center', 'et_builder' ),
					'right-bottom'	=> esc_html__( 'Right Bottom', 'et_builder' ),
				),
				'default'            => 'top-left',
				'mobile_options'	 => true,
			),
			'dnxt_image_max_width'	=> array(
				'label'           	=> esc_html__( 'Image Width', 'et_builder' ),
				'description'     	=> esc_html__( 'Adjust the width of the image within the blurb.', 'et_builder' ),
				'type'            	=> 'range',
				'option_category' 	=> 'layout',
				'tab_slug'        	=> 'advanced',
				'toggle_slug'     	=> 'width',
				'allowed_units'   	=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'default'         	=> '100%',
				'default_unit'    	=> '%',
				'default_on_front'	=> '',
				'allow_empty'     	=> true,
				'range_settings'  	=> array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'mobile_options'	=> true,
				'responsive'      	=> true,
				'hover'             => 'tabs',
			),
			'dnxt_content_max_width' 	=> array(
				'label'           		=> esc_html__( 'Text Container Width', 'et_builder' ),
				'description'     		=> esc_html__( 'Adjust the width of the text container width within the blurb.', 'et_builder' ),
				'type'            		=> 'range',
				'option_category' 		=> 'layout',
				'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'width',
				'default'         		=> '100%',
				'default_unit'    		=> '%',
				'default_on_front'		=> '',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'allow_empty'     		=> true,
				'range_settings'  		=> array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'mobile_options'		=> true,
				'responsive'      		=> true,
				'hover'             	=> 'tabs',
			),
			'dnxt_img_margin'	  => array(
				'label'           => esc_html__('Image Margin', 'et_builder'),
                'type'            => 'custom_margin',
                'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dnxt_blurb_image_icon_space', 
				'sub_toggle'	  => 'sub_toggle_image_space'
			),
			'dnxt_img_padding'	  => array(
				'label'           => esc_html__('Image Padding', 'et_builder'),
				'type'            => 'custom_padding',
				'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' => 'layout',
				'tab_slug'        => 'advanced',				
				'toggle_slug'     => 'dnxt_blurb_image_icon_space', 
				'sub_toggle'	  => 'sub_toggle_image_space'
			),
			'dnxt_icon_margin'	  => array(
				'label'           => esc_html__('Icon Margin', 'et_builder'),
				'type'            => 'custom_margin',
				'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' => 'layout',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dnxt_blurb_image_icon_space', 
				'sub_toggle'	  => 'sub_toggle_icon_space'
			),
			'dnxt_icon_padding'	  => array(
				'label'           => esc_html__('Icon Padding', 'et_builder'),
				'type'            => 'custom_padding',
				'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' => 'layout',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dnxt_blurb_image_icon_space', 
				'sub_toggle'	  => 'sub_toggle_icon_space'
			),
			'dnxt_pre_margin'	  =>	array(
				'label'           => esc_html__('Pre Heading Margin', 'et_builder'),
                'type'            => 'custom_margin',
                'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dnxt_blurb_header_space', 
				'sub_toggle'	  => 'sub_toggle_pre_space'
			),
			'dnxt_pre_padding'	  =>	array(
				'label'           => esc_html__('Pre Heading Padding', 'et_builder'),
                'type'            => 'custom_padding',
                'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dnxt_blurb_header_space', 
				'sub_toggle'	  => 'sub_toggle_pre_space'
			),
			'dnxt_header_margin'  =>	array(
				'label'           => esc_html__('Header Margin', 'et_builder'),
                'type'            => 'custom_margin',
                'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dnxt_blurb_header_space', 
				'sub_toggle'	  => 'sub_toggle_header_space'
			),
			'dnxt_header_padding' =>	array(
				'label'           => esc_html__('Header Padding', 'et_builder'),
                'type'            => 'custom_padding',
                'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dnxt_blurb_header_space', 
				'sub_toggle'	  => 'sub_toggle_header_space'
			),
			'dnxt_post_margin' 	  =>	array(
				'label'           => esc_html__('Post Header Margin', 'et_builder'),
                'type'            => 'custom_margin',
                'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dnxt_blurb_header_space', 
				'sub_toggle'	  => 'sub_toggle_post_space'
			),
			'dnxt_post_padding'   =>	array(
				'label'           => esc_html__('Post Header Padding', 'et_builder'),
                'type'            => 'custom_padding',
                'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dnxt_blurb_header_space', 
				'sub_toggle'	  => 'sub_toggle_post_space'
			),
			'dnxt_body_margin' 	  =>	array(
				'label'           => esc_html__('Body Margin', 'et_builder'),
                'type'            => 'custom_margin',
                'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dnxt_blurb_body_content_space', 
				'sub_toggle'	  => 'sub_toggle_body_space'
			),
			'dnxt_body_padding' =>		array(
				'label'           => esc_html__('Body Padding', 'et_builder'),
                'type'            => 'custom_padding',
                'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dnxt_blurb_body_content_space', 
				'sub_toggle'	  => 'sub_toggle_body_space'
			),
			'dnxt_content_margin' =>	array(
				'label'           => esc_html__('Description Margin', 'et_builder'),
                'type'            => 'custom_margin',
                'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dnxt_blurb_body_content_space', 
				'sub_toggle'	  => 'sub_toggle_content_space'
			),
			'dnxt_content_padding' =>	array(
				'label'           => esc_html__('Description Padding', 'et_builder'),
                'type'            => 'custom_padding',
                'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dnxt_blurb_body_content_space', 
				'sub_toggle'	  => 'sub_toggle_content_space'
			),
			'dnxt_button_margin' =>		array(
				'label'           => esc_html__('Button Margin', 'et_builder'),
                'type'            => 'custom_margin',
                'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dnxt_blurb_button_space',
				'depends_show_if'  	=> 'on', 
			),
			'dnxt_button_padding' =>	array(
				'label'           => esc_html__('Button Padding', 'et_builder'),
                'type'            => 'custom_padding',
                'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dnxt_blurb_button_space',
				'depends_show_if'  	=> 'on', 
			),
			'dnxt_btn_show_hide' => array(
				'label'           => esc_html__( 'Button Show Hide', 'et_builder' ),
				'type'            => 'yes_no_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'et_builder' ),
					'on'  => esc_html__( 'Yes', 'et_builder' ),
				),
				'toggle_slug'     => 'dnxt_blurb_button_text',
				'affects'         => array(
					'button_text',
					'button_link',
					'button_link_new_window',
					'btn_one_show_hide',
					'btn_one_gradient_show_hide',
					'dnxt_btn_text',
					'btn_show_hide',
					'dnxt_hover_2d',
					'dnxt_hover_bg',
					'dnxt_hover_border',
					'dnxt_hover_icons',
					'dnxt_radial_out_bg_color',
					'dnxt_hover_bg_color',
					'dnxt_hover_border_bg_color',
					'dnxt_button_margin',
					'dnxt_button_padding',
				),
				'default_on_front'=> 'off',
			),
            // Button Title Field
			'button_text'      => array(
				'label'           => esc_html__( 'Button Text', 'et_builder' ),
				'type'            => 'text',
				'dynamic_content' => 'text',
                'default'         => 'Button Text',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'dnxt_blurb_button_text',
				'depends_show_if' 	=> 'on',
			),
			// Button Link Field
			'button_link'      => array(
				'label'           => esc_html__( 'Button Link', 'et_builder' ),
				'description'     => esc_html__( 'When clicked the module will link to this URL.', 'et_builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'toggle_slug'     => 'dnxt_blurb_button_text',
				'dynamic_content' => 'url',
				'depends_show_if' 	=> 'on',
			),
			// Button Link Target Field
			'button_link_new_window'		=> array(
				'label'				=> esc_html__( 'Button Link Target', 'et_builder' ),
				'description'      	=> esc_html__( 'Here you can choose whether or not your link opens in a new window', 'et_builder' ),
				'type'             	=> 'select',
				'option_category'  	=> 'configuration',
				'options'         	=> array(
					'off' => esc_html__( 'In The Same Window', 'et_builder' ),
					'on'  => esc_html__( 'In The New Tab', 'et_builder' ),
				),
				'toggle_slug'      => 'dnxt_blurb_button_text',
				'default_on_front' => 'off',
				'depends_show_if' 	=> 'on',
			),
			// Button Background 
			'btn_one_show_hide'  => array(
				'label'           => esc_html__( 'Button Background Color', 'et_builder'),
				'type'            => 'yes_no_button',  
				'toggle_slug'     => 'dnxt_blurb_button_background',
				'sub_toggle'	  => 'sub_toggle_color',
				'options'             => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'affects'         => array(
					'button_bg_one',
				),
				'default_on_front' => 'off',
				'depends_show_if' 	=> 'on',
			),
			// Button BG Color
			'button_bg_one'        => array(
				'label'          => esc_html__('Select Background Color', 'et_builder'),
				'type'           => 'color-alpha',
				'toggle_slug'    => 'dnxt_blurb_button_background',
				'sub_toggle'	 => 'sub_toggle_color',
				'hover'    		 => 'tabs',
				'default'        => '#29c4a9',
				'depends_show_if'=> 'on',
			),
			// Button Background
			'btn_one_gradient_show_hide'  => array(
				'label'           => esc_html__( 'Button Gradient Color', 'et_builder'),
				'type'            => 'yes_no_button', 
				'toggle_slug'     => 'dnxt_blurb_button_background',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'options'             => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'affects'         => array(
					'bg_one_gradient_color_one',
					'bg_one_gradient_color_two',
					'bg_one_gradient_type',
					'bg_one_gradient_start_position',
					'bg_one_gradient_end_position'
				),
				'default_on_front' => 'off',
				'depends_show_if' 	=> 'on',
			),
			'bg_one_gradient_color_one'	=> array(
                'label'          => esc_html__('Select Color One', 'et_builder'),
                'type'           => 'color-alpha',
				'toggle_slug'    => 'dnxt_blurb_button_background',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'default'        => '#2b87da',
				'depends_show_if'=> 'on',
			),
			'bg_one_gradient_color_two'	=> array(
                'label'          => esc_html__('Select Color Two', 'et_builder'),
                'type'           => 'color-alpha',
				'toggle_slug'    => 'dnxt_blurb_button_background',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'default'        => '#29c4a9',
				'depends_show_if'=> 'on',
			),
			'bg_one_gradient_type'		=> array(
                'label'           => esc_html__('Select Gradient Type', 'et_builder'),
                'type'            => 'select',
				'description'     => esc_html__('Select the types of gradient', 'et_builder'),
                'option_category' => 'basic_option',
				'toggle_slug'     => 'dnxt_blurb_button_background',
				'sub_toggle'	  => 'sub_toggle_gradient',
                'options'         => array(
                    'linear-gradient' => esc_html__('Linear', 'et_builder'),
                    'radial-gradient' => esc_html__('Radial', 'et_builder'),
                ),
				'default'         => 'linear-gradient',
				'depends_show_if' => 'on',
			),
			'bg_one_gradient_type_linear_direction'   => array(
                'label'           => esc_html__('Gradient direction', 'et_builder'),
                'type'            => 'range',
                'option_category'=> 'basic_option',
				'toggle_slug'    => 'dnxt_blurb_button_background',
				'sub_toggle'	 => 'sub_toggle_gradient',
                'range_settings'  => array(
                    'step' => 1,
                    'min'  => 1,
                    'max'  => 360,
                ),
                'default'         => '180deg',
				'fixed_unit'      => 'deg',
				'show_if' => array(
					'btn_one_gradient_show_hide' => 'on',
					'bg_one_gradient_type' => 'linear-gradient'
				),
			),
			'bg_one_gradient_type_radial_direction'   => array(
                'label'           	=> esc_html__('Radial Direction', 'et_builder'),
                'type'            	=> 'select',
				'description'     	=> esc_html__('Select the types of gradient', 'et_builder'),                
                'option_category'	=> 'basic_option',
				'toggle_slug'    	=> 'dnxt_blurb_button_background',
				'sub_toggle'	 	=> 'sub_toggle_gradient',
                'options'       	=> array(
                    'circle at center'       => esc_html__(	'Center', 'et_builder'),
                    'circle at left'         => esc_html__(	'Top Left', 'et_builder'),
                    'circle at top'          => esc_html__(	'Top',	'et_builder'),
                    'circle at top right'    => esc_html__(	'Top Right', 'et_builder'),
                    'circle at right'        => esc_html__(	'Right', 'et_builder'),
                    'circle at bottom right' => esc_html__(	'Bottom Right', 'et_builder'),
                    'circle at bottom'       => esc_html__(	'Bottom', 'et_builder'),
                    'circle at bottom left'  => esc_html__(	'Bottom Left', 'et_builder'),
                    'circle at left'         => esc_html__(	'Left', 'et_builder'),

                ),
                'default'         => 'circle at center',
				'show_if'         => array(
					'btn_one_gradient_show_hide' 		=> 'on',
					'bg_one_gradient_type'	=> 'radial-gradient'
                ),
			),
			'bg_one_gradient_start_position'           => array(
                'label'           => esc_html__('Start Position', 'et_builder'),
                'type'            => 'range',
                'option_category' => 'basic_option',
				'toggle_slug'     => 'dnxt_blurb_button_background',
				'sub_toggle'	  => 'sub_toggle_gradient',
                'range_settings'  => array(
                    'step' => 1,
                    'min'  => 1,
                    'max'  => 100,
                ),
                'default'         => '0%',
				'fixed_unit'      => '%',
				'depends_show_if' => 'on',
			),
			'bg_one_gradient_end_position'             => array(
                'label'           => esc_html__('End Position', 'et_builder'),
                'type'            => 'range',
                'option_category' => 'basic_option',
				'toggle_slug'     => 'dnxt_blurb_button_background',
				'sub_toggle'	  => 'sub_toggle_gradient',
                'range_settings'  => array(
                    'step' => 1,
                    'min'  => 1,
                    'max'  => 100,
                ),
                'default'         => '100%',
				'fixed_unit'      => '%',
				'depends_show_if' => 'on',
			),
			// Heading Background 
			'heading_bg_show_hide'  => array(
				'label'           => esc_html__( 'Background Heading Color', 'et_builder'),
				'type'            => 'yes_no_button',  
				'toggle_slug'     => 'dnxt_blurb_heading_background',
				'sub_toggle'	  => 'sub_toggle_color',
				'options'             => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'affects'         => array(
					'heading_bg',
				),
				'default_on_front' => 'off',
			),
			// Heading BG Color
			'heading_bg'		 => array(
				'label'          => esc_html__('Select Background Color', 'et_builder'),
				'type'           => 'color-alpha',
				'custom_color'   => true,
				'toggle_slug'    => 'dnxt_blurb_heading_background',
				'sub_toggle'	 => 'sub_toggle_color',
				'hover'    		 => 'tabs',
				'default'        => '#29c4a9',
				'depends_show_if'=> 'on',
				'mobile_options' => true,
				'responsive'	 => true,
			),
			// Background Heading Gradient 
			'heading_gradient_show_hide'  => array(
				'label'           => esc_html__( 'Gradient Heading Color', 'et_builder'),
				'type'            => 'yes_no_button',  
				'toggle_slug'     => 'dnxt_blurb_heading_background',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'options'             => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'affects'         => array(
					'heading_gradient_color_one',
					'heading_gradient_color_two',
					'heading_gradient_type',
					'heading_gradient_start_position',
					'heading_gradient_end_position'
				),
				'default_on_front' => 'off',
			),
			'heading_gradient_color_one'	=> array(
				'label'          => esc_html__('Select Color One', 'et_builder'),
				'type'           => 'color-alpha',
				'toggle_slug'    => 'dnxt_blurb_heading_background',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'default'        => '#2b87da',
				'depends_show_if'=> 'on',
			),
			'heading_gradient_color_two'	=> array(
				'label'          => esc_html__('Select Color Two', 'et_builder'),
				'type'           => 'color-alpha',
				'toggle_slug'    => 'dnxt_blurb_heading_background',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'default'        => '#29c4a9',
				'depends_show_if'=> 'on',
			),
			'heading_gradient_type'		=> array(
				'label'           => esc_html__('Select Gradient Type', 'et_builder'),
				'type'            => 'select',
				'description'     => esc_html__('Select the types of gradient', 'et_builder'),
				'option_category' => 'basic_option',
				'toggle_slug'     => 'dnxt_blurb_heading_background',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'options'         => array(
					'linear-gradient' => esc_html__('Linear', 'et_builder'),
					'radial-gradient' => esc_html__('Radial', 'et_builder'),
				),
				'default'         => 'linear-gradient',
				'depends_show_if' => 'on',
			),
			'heading_gradient_type_linear_direction'   => array(
				'label'           => esc_html__('Linear direction', 'et_builder'),
				'type'            => 'range',
				'option_category'=> 'basic_option',
				'toggle_slug'    => 'dnxt_blurb_heading_background',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'range_settings'  => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 360,
				),
				'default'         => '180deg',
				'fixed_unit'      => 'deg',
				'show_if' => array(
					'heading_gradient_show_hide' => 'on',
					'heading_gradient_type' => 'linear-gradient'
				),
			),
			'heading_gradient_type_radial_direction'   => array(
				'label'           	=> esc_html__('Radial Direction', 'et_builder'),
				'type'            	=> 'select',
				'description'     	=> esc_html__('Select the types of gradient', 'et_builder'),                
				'option_category'	=> 'basic_option',
				'toggle_slug'    	=> 'dnxt_blurb_heading_background',
				'sub_toggle'	 	=> 'sub_toggle_gradient',
				'options'       	=> array(
					'circle at center'       => esc_html__(	'Center', 'et_builder'),
					'circle at left'         => esc_html__(	'Top Left', 'et_builder'),
					'circle at top'          => esc_html__(	'Top',	'et_builder'),
					'circle at top right'    => esc_html__(	'Top Right', 'et_builder'),
					'circle at right'        => esc_html__(	'Right', 'et_builder'),
					'circle at bottom right' => esc_html__(	'Bottom Right', 'et_builder'),
					'circle at bottom'       => esc_html__(	'Bottom', 'et_builder'),
					'circle at bottom left'  => esc_html__(	'Bottom Left', 'et_builder'),
					'circle at left'         => esc_html__(	'Left', 'et_builder'),

				),
				'default'         => 'circle at center',
				'show_if'         => array(
					'heading_gradient_show_hide'	=> 'on',
					'heading_gradient_type'			=> 'radial-gradient'
				),
			),
			'heading_gradient_start_position'           => array(
				'label'           => esc_html__('Start Position', 'et_builder'),
				'type'            => 'range',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'dnxt_blurb_heading_background',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'range_settings'  => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 100,
				),
				'default'         => '0%',
				'fixed_unit'      => '%',
				'depends_show_if' => 'on',
			),
			'heading_gradient_end_position'             => array(
				'label'           => esc_html__('End Position', 'et_builder'),
				'type'            => 'range',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'dnxt_blurb_heading_background',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'range_settings'  => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 100,
				),
				'default'         => '100%',
				'fixed_unit'      => '%',
				'depends_show_if' => 'on',
			),
			// Content Background 
			'content_bg_show_hide'  => array(
				'label'           => esc_html__( 'Background Description Color', 'et_builder'),
				'type'            => 'yes_no_button',
				'toggle_slug'     => 'dnxt_blurb_content_background',
				'sub_toggle'	  => 'sub_toggle_color',
				'options'             => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'affects'         => array(
					'content_bg',
				),
				'default_on_front' => 'off',
			),
			// Content BG Color
			'content_bg'        => array(
				'label'          => esc_html__('Select Background Color', 'et_builder'),
				'type'           => 'color-alpha',
				'toggle_slug'    => 'dnxt_blurb_content_background',
				'sub_toggle'	 => 'sub_toggle_color',
				'hover'    		 => 'tabs',
				'default'        => '#29c4a9',
				'depends_show_if'=> 'on',
				'mobile_options' => true,
				'responsive'	 => true,
			),
			// Background Content Gradient 
			'content_gradient_show_hide'  => array(
				'label'           => esc_html__( 'Gradient Description Color', 'et_builder'),
				'type'            => 'yes_no_button',  
				'toggle_slug'     => 'dnxt_blurb_content_background',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'options'             => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'affects'         => array(
					'content_gradient_color_one',
					'content_gradient_color_two',
					'content_gradient_type',
					'content_gradient_start_position',
					'content_gradient_end_position'
				),
				'default_on_front' => 'off',
			),
			'content_gradient_color_one'	=> array(
				'label'          => esc_html__('Select Color One', 'et_builder'),
				'type'           => 'color-alpha',
				'toggle_slug'    => 'dnxt_blurb_content_background',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'default'        => '#2b87da',
				'depends_show_if'=> 'on',
			),
			'content_gradient_color_two'	=> array(
				'label'          => esc_html__('Select Color Two', 'et_builder'),
				'type'           => 'color-alpha',
				'toggle_slug'    => 'dnxt_blurb_content_background',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'default'        => '#29c4a9',
				'depends_show_if'=> 'on',
			),
			'content_gradient_type'		=> array(
				'label'           => esc_html__('Select Gradient Type', 'et_builder'),
				'type'            => 'select',
				'description'     => esc_html__('Select the types of gradient', 'et_builder'),
				'option_category' => 'basic_option',
				'toggle_slug'     => 'dnxt_blurb_content_background',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'options'         => array(
					'linear-gradient' => esc_html__('Linear', 'et_builder'),
					'radial-gradient' => esc_html__('Radial', 'et_builder'),
				),
				'default'         => 'linear-gradient',
				'depends_show_if' => 'on',
			),
			'content_gradient_type_linear_direction'   => array(
				'label'           => esc_html__('Gradient direction', 'et_builder'),
				'type'            => 'range',
				'option_category'=> 'basic_option',
				'toggle_slug'    => 'dnxt_blurb_content_background',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'range_settings'  => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 360,
				),
				'default'         => '180deg',
				'fixed_unit'      => 'deg',
				'show_if' => array(
					'content_gradient_show_hide' => 'on',
					'content_gradient_type' => 'linear-gradient'
				),
			),
			'content_gradient_type_radial_direction'   => array(
				'label'           	=> esc_html__('Radial Direction', 'et_builder'),
				'type'            	=> 'select',
				'description'     	=> esc_html__('Select the types of gradient', 'et_builder'),                
				'option_category'	=> 'basic_option',
				'toggle_slug'    	=> 'dnxt_blurb_content_background',
				'sub_toggle'	 	=> 'sub_toggle_gradient',
				'options'       	=> array(
					'circle at center'       => esc_html__(	'Center', 'et_builder'),
					'circle at left'         => esc_html__(	'Top Left', 'et_builder'),
					'circle at top'          => esc_html__(	'Top',	'et_builder'),
					'circle at top right'    => esc_html__(	'Top Right', 'et_builder'),
					'circle at right'        => esc_html__(	'Right', 'et_builder'),
					'circle at bottom right' => esc_html__(	'Bottom Right', 'et_builder'),
					'circle at bottom'       => esc_html__(	'Bottom', 'et_builder'),
					'circle at bottom left'  => esc_html__(	'Bottom Left', 'et_builder'),
					'circle at left'         => esc_html__(	'Left', 'et_builder'),

				),
				'default'         => 'circle at center',
				'show_if'         => array(
					'content_gradient_show_hide' 		=> 'on',
					'content_gradient_type'	=> 'radial-gradient'
				),
			),
			'content_gradient_start_position'           => array(
				'label'           => esc_html__('Start Position', 'et_builder'),
				'type'            => 'range',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'dnxt_blurb_content_background',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'range_settings'  => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 100,
				),
				'default'         => '0%',
				'fixed_unit'      => '%',
				'depends_show_if' => 'on',
			),
			'content_gradient_end_position'             => array(
				'label'           => esc_html__('End Position', 'et_builder'),
				'type'            => 'range',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'dnxt_blurb_content_background',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'range_settings'  => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 100,
				),
				'default'         => '100%',
				'fixed_unit'      => '%',
				'depends_show_if' => 'on',
			),
			// Button Show & Hide
			'btn_show_hide'		=> array(
				'label'           => esc_html__( 'Show Icon', 'et_builder' ),
				'description'     => esc_html__( 'When enabled, this will add a custom icon within the button.', 'et_builder' ),
				'type'            => 'yes_no_button',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dnxt_blurb_button_icon',
				'default'         => 'on',
				'options'         => array(
					'on'      => esc_html__( 'Yes', 'et_builder' ),
					'off'     => esc_html__( 'No', 'et_builder' ),
				),
				'affects'         => array(
					"btn_icon_color",
					"btn_icon_placement",
					"btn_on_hover",
					"btn_icon",
				),
				'depends_show_if' => 'on',
			),
			// Button Icon
			'btn_icon'	=> array(
				'label'               => esc_html__( 'Button Icon', 'et_builder' ),
				'description'         => esc_html__( 'Pick a color to be used for the button icon.', 'et_builder' ),
				'type'                => 'select_icon',
				'tab_slug'            => 'advanced',
				'toggle_slug'         => 'dnxt_blurb_button_icon',
				'class'               => array( 'et-pb-font-icon' ),
				'default'             => '$',
				'mobile_options'      => true,
				'depends_show_if_not' => 'off',
			),
			// Button Icon Color
			'btn_icon_color'	=>	array(
				'label'               => esc_html__( 'Button Icon Color', 'et_builder'),
				'description'         => esc_html__( 'Here you can define a custom color for the button icon.', 'et_builder' ),
				'type'                => 'color-alpha',
				'tab_slug'            => 'advanced',
				'toggle_slug'         => 'dnxt_blurb_button_icon',
				'custom_color'        => true,
				'default'			  => '#2857b6',
				'hover'               => 'tabs',
				'depends_show_if_not' => 'off',
			),
			// Button Icon Placement
			'btn_icon_placement'	=>	array(
				'label'               => esc_html__( 'Button Icon Placement', 'et_builder' ),
				'description'         => esc_html__( 'Choose where the button icon should be displayed within the button.', 'et_builder' ),
				'type'                => 'select',
				'tab_slug'            => 'advanced',
				'toggle_slug'         => 'dnxt_blurb_button_icon',
				'options'             => array(
					'right' => esc_html__( 'Right', 'et_builder' ),
					'left'  => esc_html__( 'Left', 'et_builder' ),
				),
				'default'             => 'right',
				'depends_show_if_not' => 'off',
			),
			// Button Icon On Hover
			'btn_on_hover'	=>	array(
				'label'               => esc_html__( 'Only Show Icon On Hover for Button', 'et_builder' ),
				'description'         => esc_html__( 'By default, button icons are displayed on hover. If you would like button icons to always be displayed, then you can enable this option.', 'et_builder' ),
				'type'                => 'yes_no_button',
				'tab_slug'            => 'advanced',
				'toggle_slug'         => 'dnxt_blurb_button_icon',
				'default'             => 'on',
				'options'             => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'depends_show_if_not' => 'off',
			),
			// Hover Effect Switch
			'blurb_hover_switch'  => array(
				'label'           => esc_html__('Hover Effect Enable', 'et_builder'),
				'type'            => 'yes_no_button',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dnxt_blurb_hover_effect',
				'sub_toggle'      => 'sub_toggle_2d_effect',
				'options'   => array(
					'off'     => esc_html__('Off', 'et_builder'),
					'on'      => esc_html__('On', 'et_builder'),
				),
				'affects'         => array(
					'dnxt_hover_effect',
				),
				'default_on_front'=> 'off',
			),
			// 2D Hover Effect
			'dnxt_hover_effect'     => array(
				'label'             => esc_html__( 'Select 2D Hover Effect', 'et_builder' ),
				'type'              => 'select',
				'option_category'   => 'configuration',
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'dnxt_blurb_hover_effect',
				'sub_toggle'        => 'sub_toggle_2d_effect',
				'default'           => '',
				'description'       => esc_html__( 'Here you can adjust the hover effect.', 'et_builder' ),
				'options'           => array(
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
				'depends_show_if' => 'on',
			),
			// Tilt Effect Enable
			'dnxt_blurb_tilt_switch'  => array(
				'label'           => esc_html__('Tilt Effect Enable', 'et_builder'),
				'type'            => 'yes_no_button',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dnxt_blurb_hover_effect',
				'sub_toggle'      => 'sub_toggle_tilt_effect',
				'options'   => array(
					'off'     => esc_html__('Off', 'et_builder'),
					'on'      => esc_html__('On', 'et_builder'),
				),
				'affects'         => array(
					'dnxt_tilt_hover_effect',
					'dnxt_blurb_tilt_glare',
					'dnxt_tilt_reverse',
					'dnxt_tilt_perspective',
					'dnxt_tilt_max',
					'dnxt_tilt_speed',
					'dnxt_tilt_startx',
					'dnxt_tilt_starty',
					'dnxt_tilt_scale',
				),
				'default_on_front'=> 'off',
			),
			// Data Tilt Glare Enable
			'dnxt_blurb_tilt_glare'  => array(
				'label'           => esc_html__('Glare Enable', 'et_builder'),
				'type'            => 'yes_no_button',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dnxt_blurb_hover_effect',
				'sub_toggle'      => 'sub_toggle_tilt_effect',
				'options'   => array(
					'off'     => esc_html__('Off', 'et_builder'),
					'on'      => esc_html__('On', 'et_builder'),
				),
				'affects'         => array(
					'dnxt_tilt_max_glare'
				),
				'depends_show_if_not' => 'off',
				'default_on_front'=> 'off',
			),
			// Data Tilt Max Glare
			'dnxt_tilt_max_glare' => array(
				'label'           => esc_html__('Max Glare', 'et_builder'),
				'type'            => 'range',
				'option_category' => 'configuration',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dnxt_blurb_hover_effect',
				'sub_toggle'      => 'sub_toggle_tilt_effect',
				'range_settings'  => array(
					'step' => .5,
					'min'  => 0.5,
					'max'  => 100,
				),
				'default'         => '0.8',
				'options'   => array(
					'off'     => esc_html__('Off', 'et_builder'),
					'on'      => esc_html__('On', 'et_builder'),
				),
				'depends_show_if_not' => 'off',
			),
			// Data Tilt Reverse
			'dnxt_tilt_reverse' => array(
				'label'           => esc_html__('Tilt Reverse', 'et_builder'),
				'type'            => 'yes_no_button',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dnxt_blurb_hover_effect',
				'sub_toggle'      => 'sub_toggle_tilt_effect',
				'options'   => array(
					'off'     => esc_html__('False', 'et_builder'),
					'on'      => esc_html__('True', 'et_builder'),
				),
				'default'           => 'off',
				'depends_show_if_not' => 'off',
			),
			// Data Tilt Perspective
			'dnxt_tilt_perspective' => array(
				'label'           => esc_html__('Tilt Perspective', 'et_builder'),
				'type'            => 'range',
				'option_category' => 'configuration',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dnxt_blurb_hover_effect',
				'sub_toggle'      => 'sub_toggle_tilt_effect',
				'options'   => array(
					'off'     => esc_html__('Off', 'et_builder'),
					'on'      => esc_html__('On', 'et_builder'),
				),
				'range_settings'  => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 1000,
				),
				'default'         => '1000',
				'depends_show_if_not' => 'off',
			),
			// Data Tilt Max
			'dnxt_tilt_max' => array(
				'label'           => esc_html__('Tilt Max', 'et_builder'),
				'type'            => 'range',
				'option_category' => 'configuration',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dnxt_blurb_hover_effect',
				'sub_toggle'      => 'sub_toggle_tilt_effect',
				'default_unit'    => '',
				'options'   => array(
					'off'     => esc_html__('Off', 'et_builder'),
					'on'      => esc_html__('On', 'et_builder'),
				),
				'range_settings'  => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 100,
				),
				'default'         => '35',
				'depends_show_if_not' => 'off',
			),
			// Data Tilt Speed
			'dnxt_tilt_speed' => array(
				'label'           => esc_html__('Tilt Speed', 'et_builder'),
				'type'            => 'range',
				'option_category' => 'configuration',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dnxt_blurb_hover_effect',
				'sub_toggle'      => 'sub_toggle_tilt_effect',
				'options'   => array(
					'off'     => esc_html__('Off', 'et_builder'),
					'on'      => esc_html__('On', 'et_builder'),
				),
				'range_settings'  => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 500,
				),
				'default'         => '300',
				'depends_show_if_not' => 'off',
			),
			// Data Tilt StartX
			'dnxt_tilt_startx' => array(
				'label'           => esc_html__('Tilt StartX', 'et_builder'),
				'type'            => 'range',
				'option_category' => 'configuration',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dnxt_blurb_hover_effect',
				'sub_toggle'      => 'sub_toggle_tilt_effect',
				'options'   => array(
					'off'     => esc_html__('Off', 'et_builder'),
					'on'      => esc_html__('On', 'et_builder'),
				),
				'range_settings'  => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 500,
				),
				'default'         => '0',
				'depends_show_if_not' => 'off',
			),
			// Data Tilt StartY
			'dnxt_tilt_starty' => array(
				'label'           => esc_html__('Tilt StartY', 'et_builder'),
				'type'            => 'range',
				'option_category' => 'configuration',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dnxt_blurb_hover_effect',
				'sub_toggle'      => 'sub_toggle_tilt_effect',
				'options'   => array(
					'off'     => esc_html__('Off', 'et_builder'),
					'on'      => esc_html__('On', 'et_builder'),
				),
				'range_settings'  => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 500,
				),
				'default'         => '0',
				'depends_show_if_not' => 'off',
			),
			// Data Tilt Scale
			'dnxt_tilt_scale' => array(
				'label'           => esc_html__('Tilt Scale', 'et_builder'),
				'type'            => 'range',
				'option_category' => 'configuration',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dnxt_blurb_hover_effect',
				'sub_toggle'      => 'sub_toggle_tilt_effect',
				'options'   => array(
					'off'     => esc_html__('Off', 'et_builder'),
					'on'      => esc_html__('On', 'et_builder'),
				),
				'range_settings'  => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 500,
				),
				'default'         => '1',
				'depends_show_if_not' => 'off',
			),
			// Button Hover 2D
			'dnxt_hover_2d'     => array(
				'label'             => esc_html__( 'Select 2D Hover Effect', 'et_builder' ),
				'type'              => 'select',
				'option_category'   => 'configuration',
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'button_hover',
				'sub_toggle'		=> 'sub_toggle_2d',
				'default'           => '',
				'description'       => esc_html__( 'Here you can adjust the hover effect.', 'et_builder' ),
				'options'           => array(
					''               					=>  esc_html__( 'Select', 'et_builder' ),
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
				'depends_show_if' 	=> 'on',
			),
			// Button Hover Effect
			'dnxt_hover_bg'     => array(
				'label'             => esc_html__( 'Select Background Hover Effect', 'et_builder' ),
				'type'              => 'select',
				'option_category'   => 'configuration',
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'button_hover',
				'sub_toggle'		=> 'sub_toggle_bg',
				'default'           => '',
				'description'       => esc_html__( 'Here you can adjust the hover effect.', 'et_builder' ),
				'options'           => array(
					''									=>  esc_html__( 'Select', 'et_builder' ),
					'dnxt-hover-fade'					=>  esc_html__( 'Fade', 'et_builder' ),
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
					'dnxt-hover-shutter-out-vertical'  =>  esc_html__( 'Shutter Out Vertical', 'et_builder' ),
				),
				'depends_show_if' 	=> 'on',
			),
			// Button BG Color
			'dnxt_radial_out_bg_color'        => array(
				'label'          => esc_html__( 'Background Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Background.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_hover',
				'sub_toggle'	 => 'sub_toggle_bg',
				'default'        => 'rgba(0,0,0,0.3)',
				'show_if'         => array(
					'dnxt_hover_bg' => 'dnxt-hover-radial-out',
				),
				'depends_show_if' 	=> 'on',
			),
			'dnxt_radial_in_bg_color'        => array(
				'label'          => esc_html__( 'Background Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Background.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_hover',
				'sub_toggle'	 => 'sub_toggle_bg',
				'default'        => 'rgba(0,0,0,0.3)',
				'show_if'         => array(
					'dnxt_hover_bg' => 'dnxt-hover-radial-in',
				),
			),
			'dnxt_rectangle_in_bg_color'        => array(
				'label'          => esc_html__( 'Background Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Background.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_hover',
				'sub_toggle'	 => 'sub_toggle_bg',
				'default'        => 'rgba(0,0,0,0.3)',
				'show_if'         => array(
					'dnxt_hover_bg' => 'dnxt-hover-rectangle-in',
				),
			),
			'dnxt_rectangle_out_bg_color'        => array(
				'label'          => esc_html__( 'Background Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Background.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_hover',
				'sub_toggle'	 => 'sub_toggle_bg',
				'default'        => 'rgba(0,0,0,0.3)',
				'show_if'         => array(
					'dnxt_hover_bg' => 'dnxt-hover-rectangle-out',
				),
			),
			'dnxt_shutter_in_bg_color'        => array(
				'label'          => esc_html__( 'Background Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Background.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_hover',
				'sub_toggle'	 => 'sub_toggle_bg',
				'default'        => 'rgba(0,0,0,0.3)',
				'show_if'         => array(
					'dnxt_hover_bg' => 'dnxt-hover-shutter-in-horizontal',
				),
			),
			'dnxt_shutter_out_bg_color'        => array(
				'label'          => esc_html__( 'Background Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Background.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_hover',
				'sub_toggle'	 => 'sub_toggle_bg',
				'default'        => 'rgba(0,0,0,0.3)',
				'show_if'         => array(
					'dnxt_hover_bg' => 'dnxt-hover-shutter-out-horizontal',
				),
			),
			'dnxt_shutter_in_v_bg_color'        => array(
				'label'          => esc_html__( 'Background Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Background.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_hover',
				'sub_toggle'	 => 'sub_toggle_bg',
				'default'        => 'rgba(0,0,0,0.3)',
				'show_if'         => array(
					'dnxt_hover_bg' => 'dnxt-hover-shutter-in-vertical',
				),
			),
			'dnxt_shutter_out_v_bg_color'        => array(
				'label'          => esc_html__( 'Background Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Background.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_hover',
				'sub_toggle'	 => 'sub_toggle_bg',
				'default'        => 'rgba(0,0,0,0.3)',
				'show_if'         => array(
					'dnxt_hover_bg' => 'dnxt-hover-shutter-out-vertical',
				),
			),
			// Button Hover BG Color
			'dnxt_hover_bg_color'        => array(
				'label'          => esc_html__('Select Background Hover Color', 'et_builder'),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_hover',
				'sub_toggle'	 => 'sub_toggle_bg',
				'default'        => '#29c4a9',
				'depends_show_if' 	=> 'on',
			),
			// Button Hover Strock
			'dnxt_hover_border'     => array(
				'label'             => esc_html__( 'Select Stroke Hover Effect', 'et_builder' ),
				'type'              => 'select',
				'option_category'   => 'configuration',
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'button_hover',
				'sub_toggle'		=> 'sub_toggle_border',
				'default'           => '',
				'description'       => esc_html__( 'Here you can adjust the hover effect.', 'et_builder' ),
				'options'           => array(
					''									=>  esc_html__( 'Select', 'et_builder' ),
					'dnxt-hover-trim'         			=>  esc_html__( 'Trim', 'et_builder' ),
					'dnxt-hover-ripple-out'         	=>  esc_html__( 'Ripple Out', 'et_builder' ),
					'dnxt-hover-ripple-in'        		=>  esc_html__( 'Ripple In', 'et_builder' ),
					'dnxt-hover-underline-from-left'    =>  esc_html__( 'Underline From Left', 'et_builder' ),
					'dnxt-hover-underline-from-center'  =>  esc_html__( 'Underline From Center', 'et_builder' ),
					'dnxt-hover-underline-from-right'   =>  esc_html__( 'Underline From Right', 'et_builder' ),
					'dnxt-hover-reveal'              	=>  esc_html__( 'Reveal', 'et_builder' ),
					'dnxt-hover-underline-reveal'       =>  esc_html__( 'Underline Reveal', 'et_builder' ),
					'dnxt-hover-overline-reveal'        =>  esc_html__( 'Overline Reveal', 'et_builder' ),
					'dnxt-hover-overline-from-left'  	=>  esc_html__( 'Overline From Left', 'et_builder' ),
					'dnxt-hover-overline-from-center' 	=>  esc_html__( 'Overline From Center', 'et_builder' ),
					'dnxt-hover-overline-from-right'    =>  esc_html__( 'Overline From Right', 'et_builder' ),
				),
				'depends_show_if' 	=> 'on',
			),
			'dnxt_hover_border_bg_color'        => array(
				'label'          => esc_html__('Select Background Hover Color', 'et_builder'),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_hover',
				'sub_toggle'	 => 'sub_toggle_border',
				'default'        => '#29c4a9',
				'depends_show_if' 	=> 'on',
			),
			// Button Trim Border Color
			'dnxt_trim_border_color'        => array(
				'label'          => esc_html__( 'Border Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Border.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_hover',
				'sub_toggle'	 => 'sub_toggle_border',
				'default'        => 'rgba(0,0,0,0.3)',
				'show_if'         => array(
					'dnxt_hover_border' => 'dnxt-hover-trim',
				),
			),
			// Button Hover Ripple Out Border Color
			'dnxt_ripple_out_color'        => array(
				'label'          => esc_html__( 'Border Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Border.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_hover',
				'sub_toggle'	 => 'sub_toggle_border',
				'default'        => 'rgba(0,0,0,0.3)',
				'show_if'         => array(
					'dnxt_hover_border' => 'dnxt-hover-ripple-out',
				),
			),
			// Button Hover Ripple In Border Color
			'dnxt_ripple_in_color'        => array(
				'label'          => esc_html__( 'Border Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Border.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_hover',
				'sub_toggle'	 => 'sub_toggle_border',
				'default'        => 'rgba(0,0,0,0.3)',
				'show_if'         => array(
					'dnxt_hover_border' => 'dnxt-hover-ripple-in',
				),
			),
			// Button Hover Underline From Left Border Color
			'dnxt_underline_from_left_color'        => array(
				'label'          => esc_html__( 'Border Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Border.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_hover',
				'sub_toggle'	 => 'sub_toggle_border',
				'default'        => 'rgba(0,0,0,0.3)',
				'show_if'         => array(
					'dnxt_hover_border' => 'dnxt-hover-underline-from-left',
				),
			),
			// Button Hover Underline From Center Border Color
			'dnxt_underline_from_center_color'        => array(
				'label'          => esc_html__( 'Border Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Border.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_hover',
				'sub_toggle'	 => 'sub_toggle_border',
				'default'        => 'rgba(0,0,0,0.3)',
				'show_if'         => array(
					'dnxt_hover_border' => 'dnxt-hover-underline-from-center',
				),
			),
			// Button Hover Underline From Right Border Color
			'dnxt_underline_from_right_color'        => array(
				'label'          => esc_html__( 'Border Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Border.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_hover',
				'sub_toggle'	 => 'sub_toggle_border',
				'default'        => 'rgba(0,0,0,0.3)',
				'show_if'         => array(
					'dnxt_hover_border' => 'dnxt-hover-underline-from-right',
				),
			),
			// Button Hover Overline From Left Border Color
			'dnxt_overline_left_color'        => array(
				'label'          => esc_html__( 'Border Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Border.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_hover',
				'sub_toggle'	 => 'sub_toggle_border',
				'default'        => 'rgba(0,0,0,0.3)',
				'show_if'         => array(
					'dnxt_hover_border' => 'dnxt-hover-overline-from-left',
				),
			),
			// Button Hover Overline From Center Border Color
			'dnxt_overline_center_color'        => array(
				'label'          => esc_html__( 'Border Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Border.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_hover',
				'sub_toggle'	 => 'sub_toggle_border',
				'default'        => 'rgba(0,0,0,0.3)',
				'show_if'         => array(
					'dnxt_hover_border' => 'dnxt-hover-overline-from-center',
				),
			),
			// Button Hover Overline From Right Border Color
			'dnxt_overline_right_color'        => array(
				'label'          => esc_html__( 'Border Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Border.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_hover',
				'sub_toggle'	 => 'sub_toggle_border',
				'default'        => 'rgba(0,0,0,0.3)',
				'show_if'         => array(
					'dnxt_hover_border' => 'dnxt-hover-overline-from-right',
				),
			),
			// Button Hover Reveal Border Color
			'dnxt_reveal_color'        => array(
				'label'          => esc_html__( 'Border Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Border.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_hover',
				'sub_toggle'	 => 'sub_toggle_border',
				'default'        => 'rgba(0,0,0,0.3)',
				'show_if'         => array(
					'dnxt_hover_border' => 'dnxt-hover-reveal',
				),
			),
			// Button Hover Underline Reveal Border Color
			'dnxt_underline_reveal_color'        => array(
				'label'          => esc_html__( 'Border Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Border.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_hover',
				'sub_toggle'	 => 'sub_toggle_border',
				'default'        => 'rgba(0,0,0,0.3)',
				'show_if'         => array(
					'dnxt_hover_border' => 'dnxt-hover-underline-reveal',
				),
			),
			// Button Hover Overline Reveal Border Color
			'dnxt_overline_reveal_color'        => array(
				'label'          => esc_html__( 'Border Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Border.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_hover',
				'sub_toggle'	 => 'sub_toggle_border',
				'default'        => 'rgba(0,0,0,0.3)',
				'show_if'         => array(
					'dnxt_hover_border' => 'dnxt-hover-overline-reveal',
				),
			),
			// Button Hover Overline Reveal Border Color
			'dnxt_overline_reveal_color'        => array(
				'label'          => esc_html__( 'Border Color', 'et_builder'),
				'description'    => esc_html__( 'The color of the Border.', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'button_hover',
				'sub_toggle'	 => 'sub_toggle_border',
				'default'        => 'rgba(0,0,0,0.3)',
				'show_if'        => array(
					'dnxt_hover_border' => 'dnxt-hover-overline-reveal',
				),
			),
			// Button Icons Hover Effect
			'dnxt_hover_icons'     => array(
				'label'             => esc_html__( 'Select Icons Hover Effect', 'et_builder' ),
				'type'              => 'select',
				'option_category'   => 'configuration',
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'button_hover',
				'sub_toggle'		=> 'sub_toggle_icons',
				'default'           => '',
				'description'       => esc_html__( 'Here you can adjust the hover effect.', 'et_builder' ),
				'options'           => array(
					''									=>  esc_html__( 'Select', 'et_builder' ),
					'dnxt-hover-icon-back'				=>  esc_html__( 'Icon Back', 'et_builder' ),
					'dnxt-hover-icon-forward'       	=>  esc_html__( 'Icon Forward', 'et_builder' ),
					'dnxt-hover-icon-down'         		=>  esc_html__( 'Icon Down', 'et_builder' ),
					'dnxt-hover-icon-up'         		=>  esc_html__( 'Icon Up', 'et_builder' ),
					'dnxt-hover-icon-drop'        		=>  esc_html__( 'Icon Drop', 'et_builder' ),
					'dnxt-hover-icon-float-away'    	=>  esc_html__( 'Icon Float Away', 'et_builder' ),
					'dnxt-hover-icon-sink-away'    		=>  esc_html__( 'Icon Sink Away', 'et_builder' ),
					'dnxt-hover-icon-grow'  			=>  esc_html__( 'Icon Grow', 'et_builder' ),
					'dnxt-hover-icon-shrink'   			=>  esc_html__( 'Icon Shrink', 'et_builder' ),
					'dnxt-hover-icon-pulse'         	=>  esc_html__( 'Icon pulse', 'et_builder' ),
					'dnxt-hover-icon-pulse-grow'    	=>  esc_html__( 'Icon Pulse Grow', 'et_builder' ),
					'dnxt-hover-icon-pulse-shrink'  	=>  esc_html__( 'Icon Pulse Shrink', 'et_builder' ),
					'dnxt-hover-icon-push'  			=>  esc_html__( 'Icon Push', 'et_builder' ),
					'dnxt-hover-icon-pop' 				=>  esc_html__( 'Icon Pop', 'et_builder' ),
					'dnxt-hover-icon-bounce'    		=>  esc_html__( 'Icon Bounce', 'et_builder' ),
					'dnxt-hover-icon-rotate'    		=>  esc_html__( 'Icon Rotate', 'et_builder' ),
					'dnxt-hover-icon-grow-rotate'   	=>  esc_html__( 'Icon Grow Rotate', 'et_builder' ),
					'dnxt-hover-icon-float'    			=>  esc_html__( 'Icon Float', 'et_builder' ),
					'dnxt-hover-icon-sink'    			=>  esc_html__( 'Icon Sink', 'et_builder' ),
					'dnxt-hover-icon-bob'    			=>  esc_html__( 'Icon Bob', 'et_builder' ),
					'dnxt-hover-icon-hang'    			=>  esc_html__( 'Icon Hang', 'et_builder' ),
					'dnxt-hover-icon-wobble-horizontal' =>  esc_html__( 'Icon Wobble Horizontal', 'et_builder' ),
					'dnxt-hover-icon-wobble-vertical'   =>  esc_html__( 'Icon Wobble Vertical', 'et_builder' ),
					'dnxt-hover-icon-buzz'    			=>  esc_html__( 'Icon Buzz', 'et_builder' ),
					'dnxt-hover-icon-buzz-out'    		=>  esc_html__( 'Icon Buzz Out', 'et_builder' ),
				),
				'mobile_options'    => true,
				'depends_show_if' 	=> 'on',
			),
			// Img Zindex
			'img_zindex'		=>	array(
				'label'            => esc_html__( 'Image Z Index', 'et_builder' ),
				'type'             => 'range',
				'range_settings'   => array(
					'min'  => 0,
					'max'  => 999,
					'step' => 1,
				),
				'option_category'  => 'layout',
				'tab_slug'         => 'custom_css',
				'toggle_slug'      => 'dnxt_blurb_zindex',
				'hover'            => 'tabs',
				'description'      => esc_html__( 'Here you can control element position on the z axis. Elements with higher z-index values will sit atop elements with lower z-index values.', 'et_builder' ),
			),	
			// Icon Zindex
			'icon_zindex'		=>	array(
				'label'            => esc_html__( 'Icon Z Index', 'et_builder' ),
				'type'             => 'range',
				'range_settings'   => array(
					'min'  => 0,
					'max'  => 999,
					'step' => 1,
				),
				'option_category'  => 'layout',
				'tab_slug'         => 'custom_css',
				'toggle_slug'      => 'dnxt_blurb_zindex',
				'hover'            => 'tabs',
				'description'      => esc_html__( 'Here you can control element position on the z axis. Elements with higher z-index values will sit atop elements with lower z-index values.', 'et_builder' ),
			),
			// Heading Zindex
			'heading_zindex'		=>	array(
				'label'            => esc_html__( 'Heading Z Index', 'et_builder' ),
				'type'             => 'range',
				'range_settings'   => array(
					'min'  => 0,
					'max'  => 999,
					'step' => 1,
				),
				'option_category'  => 'layout',
				'tab_slug'         => 'custom_css',
				'toggle_slug'      => 'dnxt_blurb_zindex',
				'hover'            => 'tabs',
				'description'      => esc_html__( 'Here you can control element position on the z axis. Elements with higher z-index values will sit atop elements with lower z-index values.', 'et_builder' ),
			),
			// Button Zindex
			'button_zindex'		=>	array(
				'label'            => esc_html__( 'Button Z Index', 'et_builder' ),
				'type'             => 'range',
				'range_settings'   => array(
					'min'  => 0,
					'max'  => 999,
					'step' => 1,
				),
				'option_category'  => 'layout',
				'tab_slug'         => 'custom_css',
				'toggle_slug'      => 'dnxt_blurb_zindex',
				'hover'            => 'tabs',
				'description'      => esc_html__( 'Here you can control element position on the z axis. Elements with higher z-index values will sit atop elements with lower z-index values.', 'et_builder' ),
			),
			'dnxt_blurb_use_mask' => array(
                'label' => esc_html__('Use Image Mask', 'et_builder'),
                'type' => 'yes_no_button',
                'toggle_slug' => 'dnxt_blurb_image_mask',
                'options' => array(
                    'on' => esc_html__('Yes', 'et_builder'),
                    'off' => esc_html__('No', 'et_builder'),
                ),
                'affects' => array(
                    'dnxt_blurb_mask_shape',
                    'dnxt_blurb_mask_size',
                    'dnxt_blurb_image_horizontal',
                    'dnxt_blurb_image_vertical'
                ),
                'default_on_front' => 'off',
            ),
            'dnxt_blurb_mask_shape' => array(
                'label' => esc_html__('Select Shape', 'et_builder'),
                'type' => 'select',
                'description' => esc_html__('Select the shape.', 'et_builder'),
                'option_category' => 'basic_option',
                'toggle_slug' => 'dnxt_blurb_image_mask',
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
            'dnxt_blurb_use_mask_upload' => array(
                'label' => esc_html__('Use Upload Mask', 'et_builder'),
                'type' => 'yes_no_button',
                'toggle_slug' => 'dnxt_blurb_image_mask',
                'options' => array(
                    'on' => esc_html__('Yes', 'et_builder'),
                    'off' => esc_html__('No', 'et_builder'),
                ),
                'affects' => array(
                    'dnxt_blurb_upload_mask',
                    'dnxt_blurb_mask_size',
                    'dnxt_blurb_image_horizontal',
                    'dnxt_blurb_image_vertical'
                ),
                'default_on_front' => 'off',
                'show_if' => array(
                    'dnxt_blurb_use_mask' => 'off'
                )
            ),
            'dnxt_blurb_upload_mask' => array(
                'label' => esc_html__("Upload Mask", 'et_builder'),
                'type' => 'upload',
                'toggle_slug' => 'dnxt_blurb_image_mask',
                'option_category' => 'basic_option',
                'upload_button_text' => esc_html__('Upload a file', 'et_builder'),
                'choose_text' => esc_attr__('Choose a file', 'et_builder'),
                'update_text' => esc_attr__('Update file', 'et_builder'),
                'depends_show_if' => 'on'
            ),
            'dnxt_blurb_mask_size' => array(
                'label' => esc_html__('Select Mask Size', 'et_builder'),
                'type' => 'select',
                'description' => esc_html__('Select the mask size.', 'et_builder'),
                'option_category' => 'basic_option',
                'toggle_slug' => 'dnxt_blurb_image_mask',
                'options' => array(
                    'contain' => esc_html__('Contain', 'et_builder'),
                    'cover' => esc_html__('Cover', 'et_builder'),
                ),
                'default' => 'contain',
                'depends_show_if' => 'on',
            ),
            'dnxt_blurb_image_horizontal' => array(
                'label' => esc_html__('Image Horizontal Position', 'et_builder'),
                'description' => esc_html__('Adjust the position of the image.', 'et_builder'),
                'type' => 'range',
                'option_category' => 'layout',
                'toggle_slug' => 'dnxt_blurb_image_mask',
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
            'dnxt_blurb_image_vertical' => array(
                'label' => esc_html__('Image Vertical Position', 'et_builder'),
                'description' => esc_html__('Adjust the position of the image.', 'et_builder'),
                'type' => 'range',
                'option_category' => 'layout',
                'toggle_slug' => 'dnxt_blurb_image_mask',
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

	public function get_advanced_fields_config() {
		$advanced_fields = array();
		$advanced_fields['fonts'] 	   = false;
		$advanced_fields = array(
			'fonts'                 => array(
				'dnxt_pre_header' => array(
					'label'    		=> esc_html__( '', 'et_builder' ),
					'toggle_slug'   => 'dnxt_blurb_title_design',
					'sub_toggle'	=> 'sub_toggle_pre',
					'tab_slug'		=> 'advanced',
					'css'      => array(
						'main' => "%%order_class%% .dnxt-blurb-pre-heading",
						'hover' => "%%order_class%% .dnxt-blurb-wrapper-outer:hover .dnxt-blurb-pre-heading",
					),
				),
				'dnxt_heading' => array(
					'label'    		=> esc_html__( '', 'et_builder' ),
					'toggle_slug'   => 'dnxt_blurb_title_design',
					'sub_toggle'	=> 'sub_toggle_heading',
					'tab_slug'		=> 'advanced',
					'css'      => array(
						'main' => "%%order_class%% .dnxt-blurb-heading",
						'hover' => "%%order_class%% .dnxt-blurb-wrapper-outer:hover .dnxt-blurb-heading",
					),
				),
				'dnxt_post_heading' => array(
					'label'    		=> esc_html__( '', 'et_builder' ),
					'toggle_slug'   => 'dnxt_blurb_title_design',
					'sub_toggle'	=> 'sub_toggle_post',
					'tab_slug'		=> 'advanced',
					'css'      => array(
						'main' => "%%order_class%% .dnxt-blurb-post-heading",
						'hover' => "%%order_class%% .dnxt-blurb-wrapper-outer:hover .dnxt-blurb-post-heading",
					),
				),
				'dnxt_body'   => array(
					'label'          => esc_html__( 'Description', 'et_builder' ),
					'css'            => array(
						'main' => "%%order_class%% .dnxt-blurb-description",
						'hover' => "%%order_class%% .dnxt-blurb-wrapper-outer:hover .dnxt-blurb-description",
					),
					'block_elements' => array(
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
						'css'               => array(
							'main' => "%%order_class%% .dnxt-blurb-description",
							'hover' => "%%order_class%% .dnxt-blurb-wrapper-outer:hover .dnxt-blurb-description",
						),
					),
				),
				'dnxt_btn_text' => array(
					'label'    			=> esc_html__( '', 'et_builder' ),
					'toggle_slug'   	=> 'dnxt_blurb_button_font',
					'tab_slug'			=> 'advanced',
					'css'      => array(
						'main' => "%%order_class%% .dnxt-button-wrapper .dnxt-blurb-btn",
						'hover' => "%%order_class%% .dnxt-blurb-wrapper-outer:hover .dnxt-button-wrapper .dnxt-blurb-btn",
						'text_align'  => "%%order_class%% .dnxt-button-wrapper",
					),
				),
			),
			'background'            => array(
				'css' => array(
					'main' => '%%order_class%% .dnxt-blurb-wrapper-outer'
				),
			),
			'borders'               => array(
				'default' => array(
					'css' => array(
						'main'     => array(
							'border_radii'  		=> "%%order_class%% .dnxt-blurb-wrapper-outer",
							'border_radii_hover'  	=> '%%order_class%% .dnxt-blurb-wrapper-outer:hover .dnxt-blurb-wrapper-outer',
							'border_styles' 		=> "%%order_class%% .dnxt-blurb-wrapper-outer",
							'border_styles_hover' 	=> '%%order_class%% .dnxt-blurb-wrapper-outer:hover .dnxt-blurb-wrapper-outer',
						),
					)
				),
				'font_icon_border'     => array(
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'dnxt_blurb_icon_design',
					'css'          => array(
						'main'     => array(
							'border_radii'  		=> "%%order_class%% .dnxt-blurb-icon span",
							'border_radii_hover'  	=> '%%order_class%% .dnxt-blurb-wrapper-outer:hover .dnxt-blurb-icon span',
							'border_styles' 		=> "%%order_class%% .dnxt-blurb-icon span",
							'border_styles_hover' 	=> '%%order_class%% .dnxt-blurb-wrapper-outer:hover .dnxt-blurb-icon span',
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
				'dnxt_img_borders'     => array(
					'tab_slug'     		=> 'advanced',
					'toggle_slug'  		=> 'dnxt_blurb_image_design',
					'css'          => array(
						'main'     => array(
							'border_radii'  		=> "%%order_class%% .dnxt-blurb-image img",
							'border_radii_hover'  	=> '%%order_class%% .dnxt-blurb-wrapper-outer:hover .dnxt-blurb-image img',
							'border_styles' 		=> "%%order_class%% .dnxt-blurb-image img",
							'border_styles_hover' 	=> '%%order_class%% .dnxt-blurb-wrapper-outer:hover .dnxt-blurb-image img',
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
				'dnxt_pre_borders'     => array(
					'tab_slug'     		=> 'advanced',
					'toggle_slug'  		=> 'dnxt_blurb_pre_border',
					'css'          => array(
						'main'     => array(
							'border_radii'  		=> "%%order_class%% .dnxt-blurb-pre-heading",
							'border_radii_hover'  	=> '%%order_class%% .dnxt-blurb-wrapper-outer:hover .dnxt-blurb-pre-heading',
							'border_styles' 		=> "%%order_class%% .dnxt-blurb-pre-heading",
							'border_styles_hover' 	=> '%%order_class%% .dnxt-blurb-wrapper-outer:hover .dnxt-blurb-pre-heading',
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
				'dnxt_header_borders'     => array(
					'tab_slug'     		=> 'advanced',
					'toggle_slug'  		=> 'dnxt_blurb_header_border',
					'css'          => array(
						'main'     => array(
							'border_radii'  		=> "%%order_class%% .dnxt-blurb-heading",
							'border_radii_hover'  	=> '%%order_class%% .dnxt-blurb-wrapper-outer:hover .dnxt-blurb-heading',
							'border_styles' 		=> "%%order_class%% .dnxt-blurb-heading",
							'border_styles_hover' 	=> '%%order_class%% .dnxt-blurb-wrapper-outer:hover .dnxt-blurb-heading',
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
				'dnxt_post_borders'     => array(
					'tab_slug'     		=> 'advanced',
					'toggle_slug'  		=> 'dnxt_blurb_post_border',
					'css'          => array(
						'main'     => array(
							'border_radii'  		=> "%%order_class%% .dnxt-blurb-post-heading",
							'border_radii_hover'  	=> '%%order_class%% .dnxt-blurb-wrapper-outer:hover .dnxt-blurb-post-heading',
							'border_styles' 		=> "%%order_class%% .dnxt-blurb-post-heading",
							'border_styles_hover' 	=> '%%order_class%% .dnxt-blurb-wrapper-outer:hover .dnxt-blurb-post-heading',
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
				'dnxt_body_borders'     => array(
					'tab_slug'     		=> 'advanced',
					'toggle_slug'  		=> 'dnxt_blurb_body_border',
					'css'          => array(
						'main'     => array(
							'border_radii'  		=> "%%order_class%% .dnxt-blurb-container",
							'border_radii_hover'  	=> '%%order_class%% .dnxt-blurb-wrapper-outer:hover .dnxt-blurb-container',
							'border_styles' 		=> "%%order_class%% .dnxt-blurb-container",
							'border_styles_hover' 	=> '%%order_class%% .dnxt-blurb-wrapper-outer:hover .dnxt-blurb-container',
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
				'dnxt_content_borders'     => array(
					'tab_slug'     		=> 'advanced',
					'toggle_slug'  		=> 'dnxt_blurb_content_border',
					'css'          => array(
						'main'     => array(
							'border_radii'  		=> "%%order_class%% .dnxt-blurb-description",
							'border_radii_hover'  	=> '%%order_class%% .dnxt-blurb-wrapper-outer:hover .dnxt-blurb-description',
							'border_styles' 		=> "%%order_class%% .dnxt-blurb-description",
							'border_styles_hover' 	=> '%%order_class%% .dnxt-blurb-wrapper-outer:hover .dnxt-blurb-description',
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
				'dnxt_button_borders'   => array(
					'tab_slug'     		=> 'advanced',
					'depends_on'      	=> array( 'dnxt_btn_show_hide' ),
					'depends_show_if' 	=> 'on',
					'toggle_slug'  		=> 'dnxt_blurb_button_border',
					'css'          => array(
						'main'     => array(
							'border_radii'  		=> "%%order_class%% .dnxt-blurb-btn",
							'border_radii_hover'  	=> '%%order_class%% .dnxt-blurb-wrapper-outer:hover .dnxt-blurb-btn',
							'border_styles' 		=> "%%order_class%% .dnxt-blurb-btn",
							'border_styles_hover' 	=> '%%order_class%% .dnxt-blurb-wrapper-outer:hover .dnxt-blurb-btn',
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
			),
			'box_shadow'            => array(
				'default' => array(
					'css' 	=> array(
						'main'	=> "%%order_class%% .dnxt-blurb-wrapper-outer"
					)
				),
				'dnxt_image_shadow'   => array(
					'label'               => esc_html__( 'Image Box Shadow', 'et_builder' ),
					'option_category'     => 'layout',
					'tab_slug'            => 'advanced',
					'toggle_slug'         => 'dnxt_blurb_image_design',
					'css'                 => array(
						'main'        => '%%order_class%% .dnxt-blurb-image img',
						'hover'       => '%%order_class%% .dnxt-blurb-wrapper-outer:hover:hover .dnxt-blurb-image img',
						'overlay'     => 'inset',
					),
					'default_on_fronts'  => array(
						'color'    => '',
						'position' => '',
					),
				),
				'dnxt_icon'   => array(
					'label'               => esc_html__( 'Icon Box Shadow', 'et_builder' ),
					'option_category'     => 'layout',
					'tab_slug'            => 'advanced',
					'toggle_slug'         => 'dnxt_blurb_icon_design',
					'css'                 => array(
						'main'        => '%%order_class%% .dnxt-blurb-icon span',
						'hover'       => '%%order_class%% .dnxt-blurb-wrapper-outer:hover:hover .dnxt-blurb-icon span',
						'overlay'     => 'inset',
					),
					'default_on_fronts'  => array(
						'color'    => '',
						'position' => '',
					),
				),
				'dnxt_description_boxshadow'   => array(
					'label'           => esc_html__( 'Description Box Shadow', 'et_builder' ),
					'option_category' => 'layout',
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'dnxt_blurb_description_box_shadow',
					'css'             => array(
						'main'        => '%%order_class%% .dnxt-blurb-container',
						'hover'       => '%%order_class%% .dnxt-blurb-wrapper-outer:hover:hover .dnxt-blurb-container',
						'overlay'     => 'inset',
					),
					'default_on_fronts'  => array(
						'color'    => '',
						'position' => '',
					),
				),
				'dnxt_button_boxshadow'   => array(
					'label'               => esc_html__( 'Button Box Shadow', 'et_builder' ),
					'option_category'     => 'layout',
					'tab_slug'            => 'advanced',
					'toggle_slug'         => 'dnxt_blurb_button_box_shadow',
					'css'                 => array(
						'main'        => '%%order_class%% .dnxt-button-wrapper .dnxt-blurb-btn',
						'hover'       => '%%order_class%% .dnxt-blurb-wrapper-outer:hover:hover .dnxt-button-wrapper .dnxt-blurb-btn',
						'overlay'     => 'inset',
					),
					'default_on_fronts'  => array(
						'color'    => '',
						'position' => '',
					),
				),
			),
			'margin_padding' => array(
				'css' => array(
					'main' => "%%order_class%% .dnxt-blurb-wrapper-outer",
					'important' => 'all',
				),
					
			),
			'height'	=> array(
				'css'	=> array(
					'main'	=> "%%order_class%% .dnxt-blurb-wrapper-outer"
				)
			),
			'text'                  => array(
				'use_background_layout' => true,
				'css'              => array(
					'text_shadow' => "%%order_class%% .et_pb_blurb_container",
				),
				'options' => array(
					'background_layout' => array(
						'default_on_front' => 'light',
						'hover' => 'tabs',
					),
					'text_orientation' => array(
						'default_on_front' => 'left',
					),
				),
			),
			'filters'              => array(
				'css'              => array(
					'main'  => '%%order_class%%',
				),
			),
			'button'              => false,
			'text'                => false,
		);

		return $advanced_fields;
	}

	public function render( $attrs, $content, $render_slug ) {
		wp_enqueue_style('dnext_hvr_common_css');
		wp_enqueue_script( 'dnext_svg_shape_frontend' );
		wp_enqueue_script('dnxtblrb_divinextblurb-public');
		$multi_view 						= et_pb_multi_view_options( $this );
		$blurb_pre_switch					= $this->props['blurb_pre_switch'];
		$blurbpreheading  					= $this->props['blurb_pre_heading'];
		$blurb_post_switch					= $this->props['blurb_post_switch'];
		$blurbpostheading 					= $this->props['blurb_post_heading'];
		$blurbheading 						= $this->props['blurb_heading'];
		$blurb_description					= $this->props['blurb_description'];
		
		$dnxt_blurb_image					= $this->props['dnxt_image'];
		$dnxt_blurb_alt						= $this->props['dnxt_alt'];

		$dnxt_image_max_width    			= $this->props['dnxt_image_max_width'];
		$dnxt_image_max_width_hover 	  	= $this->get_hover_value( 'dnxt_image_max_width' );
		$dnxt_image_max_width_tablet   		= $this->props['dnxt_image_max_width_tablet'];
		$dnxt_image_max_width_phone  		= $this->props['dnxt_image_max_width_phone'];
		$dnxt_image_max_width_last_edited  	= $this->props['dnxt_image_max_width_last_edited'];

		$dnxt_content_max_width				= $this->props['dnxt_content_max_width'];
		$dnxt_content_max_width_hover		= $this->get_hover_value('dnxt_content_max_width');
		$dnxt_content_max_width_tablet		= $this->props['dnxt_content_max_width_tablet'];
		$dnxt_content_max_width_phone		= $this->props['dnxt_content_max_width_phone'];
		$dnxt_content_max_width_last_edited	= $this->props['dnxt_content_max_width_last_edited'];

		$font_icon_size 					= $this->props['font_icon_size'];
		$font_icon_size_hover				= $this->get_hover_value('font_icon_size');
		$font_icon_size_tablet 				= $this->props['font_icon_size_tablet'];
		$font_icon_size_phone 				= $this->props['font_icon_size_phone'];
		$font_icon_size_last_edited 		= $this->props['font_icon_size_last_edited'];

		$dnxt_use_icon						= $this->props['dnxt_use_icon'];
		$pre_heading_tag					= $this->props['pre_heading_tag'];
		$heading_tag						= $this->props['heading_tag'];
		$post_heading_tag					= $this->props['post_heading_tag'];
		$button_link						= $this->props['button_link'];

		$use_shape = $this->props['dnxt_blurb_use_mask'];
        $use_mask_upload = $this->props['dnxt_blurb_use_mask_upload'];
        
        $shape_name = "on" == $use_shape && "none" != $this->props['dnxt_blurb_mask_shape'] ? $this->props['dnxt_blurb_mask_shape'] : "";
        $shape_size = $this->props['dnxt_blurb_mask_size'];
        $uploaded_mask = "on" == $use_mask_upload ? $this->props['dnxt_blurb_upload_mask'] : "";


		if ( '' !== $dnxt_image_max_width ) { 
			$dnxt_image_max_width_responsive_active = et_pb_get_responsive_status( $dnxt_image_max_width_last_edited );
		
			$dnxt_image_max_width_values = array(
				'desktop' => $dnxt_image_max_width,
				'tablet'  => $dnxt_image_max_width_responsive_active ? $dnxt_image_max_width_tablet : '',
				'phone'   => $dnxt_image_max_width_responsive_active ? $dnxt_image_max_width_phone : '',
			);
			$dnxt_image_max_width_selector	= "%%order_class%% .dnxt-blurb-image";
			et_pb_responsive_options()->generate_responsive_css( $dnxt_image_max_width_values, $dnxt_image_max_width_selector, 'max-width', $render_slug );
			
			if ( et_builder_is_hover_enabled( 'dnxt_image_max_width', $this->props ) ) {
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => $this->add_hover_to_order_class( '%%order_class%% .dnxt-blurb-image:hover' ),
					'declaration' => sprintf(
						'max-width: %1$s;',
						esc_html( $dnxt_image_max_width_hover )
					),
				) );
			}
		}

		// Pre Heading
		if ( 'on' === $blurb_pre_switch ){
			$blurbpreheading = sprintf(
				'<%1$s class="dnxt-blurb-pre-heading">%2$s</%1$s>',
				esc_attr( $pre_heading_tag ),
				et_core_esc_previously( $blurbpreheading )
			);
		} else {
			$blurbpreheading = "";
		}

		// Post Heading
		if ( 'on' === $blurb_post_switch ) {
			$blurbpostheading = sprintf(
				'<%1$s class="dnxt-blurb-post-heading">%2$s</%1$s>',
				esc_attr( $post_heading_tag ),
				et_core_esc_previously( $blurbpostheading )
			);
		} else {
			$blurbpostheading = "";
		}

		// Heading
		if ( '' !== $blurbheading ){
			$blurbheading = sprintf(
				'<%1$s class="dnxt-blurb-heading">%2$s</%1$s>',
				esc_attr( $heading_tag ),
				et_core_esc_previously( $blurbheading )
			);
		}
		
		$description = "";
		if ( '' !== $blurb_description ) {
			$description = sprintf(
				'<div class="dnxt-blurb-description">%1$s</div>',
				et_core_esc_previously($blurb_description)
			);
		}

		// Description
		if ( '' !== $dnxt_content_max_width ) { 
			$dnxt_content_max_width_style 		 	= sprintf( 'max-width: %1$s;', esc_attr( $dnxt_content_max_width ) );
			$dnxt_content_max_width_tablet_style 	= '' !== $dnxt_content_max_width_tablet ? sprintf( 'max-width: %1$s;', esc_attr( $dnxt_content_max_width_tablet ) ) : '';
			$dnxt_content_max_width_phone_style  	= '' !== $dnxt_content_max_width_phone ? sprintf( 'max-width: %1$s;', esc_attr( $dnxt_content_max_width_phone ) ) : '';
			
			$dnxt_content_max_width_style_hover  = '';

			if ( et_builder_is_hover_enabled( 'dnxt_content_max_width', $this->props ) ) {
				$dnxt_content_max_width_style_hover = sprintf( 'max-width: %1$s;', esc_attr( $dnxt_content_max_width_hover ) );
			}

			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnxt-blurb-container",
				'declaration' => $dnxt_content_max_width_style,
			) );
			
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnxt-blurb-container",
				'declaration' => $dnxt_content_max_width_tablet_style,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
			) );

			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnxt-blurb-container",
				'declaration' => $dnxt_content_max_width_phone_style,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
			) );

			if ( '' !== $dnxt_content_max_width_style_hover ) {
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => $this->add_hover_to_order_class( '%%order_class%% .dnxt-blurb-container' ),
					'declaration' => $dnxt_content_max_width_style_hover,
				) );
			}
		}



		if ( '' !== $font_icon_size ) {

			$font_icon_size_responsive_active = et_pb_get_responsive_status( $font_icon_size_last_edited );
			$font_icon_size_values = array(
				'desktop' => $font_icon_size,
				'tablet'  => $font_icon_size_responsive_active ? $font_icon_size_tablet : '',
				'phone'   => $font_icon_size_responsive_active ? $font_icon_size_phone : '',
			);

			$font_icon_size_selector = "%%order_class%% .dnxt-blurb-icon span";
			et_pb_responsive_options()->generate_responsive_css( $font_icon_size_values, $font_icon_size_selector, 'font-size', $render_slug );

			if ( et_builder_is_hover_enabled( 'font_icon_size', $this->props ) ) {
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => $this->add_hover_to_order_class( '%%order_class%% .dnxt-blurb-icon span' ),
					'declaration' => sprintf(
						'font-size: %1$s;',
						esc_html( $font_icon_size_hover )
					),
				) );
			}
		}
  		// Font Icon Color
		$font_icon_color		= $this->props['font_icon_color'];
		$font_icon_color_hover 	= $this->get_hover_value( 'font_icon_color' );
		$font_icon_color_values	= et_pb_responsive_options()->get_property_values( $this->props, 'font_icon_color' );
		$font_icon_color_tablet	= isset( $font_icon_color_values['tablet'] ) ? $font_icon_color_values['tablet'] : '';
		$font_icon_color_phone	= isset( $font_icon_color_values['phone'] ) ? $font_icon_color_values['phone'] : '';

		// Font Icon Color
		if ( '' !== $font_icon_color ) {
			$font_icon_color_style 		 	= sprintf( 'color: %1$s;', esc_attr( $font_icon_color ) );
			$font_icon_color_tablet_style 	= '' !== $font_icon_color_tablet ? sprintf( 'color: %1$s;', esc_attr( $font_icon_color_tablet ) ) : '';
			$font_icon_color_phone_style  	= '' !== $font_icon_color_phone ? sprintf( 'color: %1$s;', esc_attr( $font_icon_color_phone ) ) : '';
			
			$font_icon_color_style_hover  = '';

			if ( et_builder_is_hover_enabled( 'font_icon_color', $this->props ) ) {
				$font_icon_color_style_hover = sprintf( 'color: %1$s;', esc_attr( $font_icon_color_hover ) );
			}

			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnxt-blurb-icon span",
				'declaration' => $font_icon_color_style,
			) );
			
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnxt-blurb-icon span",
				'declaration' => $font_icon_color_tablet_style,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
			) );

			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnxt-blurb-icon span",
				'declaration' => $font_icon_color_phone_style,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
			) );

			if ( "" !== $font_icon_color_style_hover ) {
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => $this->add_hover_to_order_class( "%%order_class%% .dnxt-blurb-icon span" ),
					'declaration' => $font_icon_color_style_hover,
				) );
			}
		}

		// Font Icon BG Color
		$font_icon_bg_color			= $this->props['font_icon_bg_color'];
		$font_icon_bg_color_hover 	= $this->get_hover_value( 'font_icon_bg_color' );
		$font_icon_bg_color_values	= et_pb_responsive_options()->get_property_values( $this->props, 'font_icon_bg_color' );
		$font_icon_bg_color_tablet	= isset( $font_icon_bg_color_values['tablet'] ) ? $font_icon_bg_color_values['tablet'] : '';
		$font_icon_bg_color_phone	= isset( $font_icon_bg_color_values['phone'] ) ? $font_icon_bg_color_values['phone'] : '';

		if ( 'off' !== $this->props['use_font_icon_bg_color'] && 'off' !== $this->props['dnxt_use_icon'] ) {
			$font_icon_bg_color_style 		 	= sprintf( 'background-color: %1$s;', esc_attr( $font_icon_bg_color ) );
			$font_icon_bg_color_tablet_style 	= '' !== $font_icon_bg_color_tablet ? sprintf( 'background-color: %1$s;', esc_attr( $font_icon_bg_color_tablet ) ) : '';
			$font_icon_bg_color_phone_style  	= '' !== $font_icon_bg_color_phone ? sprintf( 'background-color: %1$s;', esc_attr( $font_icon_bg_color_phone ) ) : '';
			
			$font_icon_bg_color_style_hover  = '';

			if ( et_builder_is_hover_enabled( 'font_icon_bg_color', $this->props ) ) {
				$font_icon_bg_color_style_hover = sprintf( 'background-color: %1$s;', esc_attr( $font_icon_bg_color_hover ) );
			}

			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnxt-blurb-icon span",
				'declaration' => $font_icon_bg_color_style,
			) );
			
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnxt-blurb-icon span",
				'declaration' => $font_icon_bg_color_tablet_style,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
			) );

			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnxt-blurb-icon span",
				'declaration' => $font_icon_bg_color_phone_style,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
			) );

			if ( "" !== $font_icon_bg_color_style_hover ) {
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => $this->add_hover_to_order_class( "%%order_class%% .dnxt-blurb-icon span" ),
					'declaration' => $font_icon_bg_color_style_hover,
				) );
			}
		}

		// Icon Placement Setup
		$fonticonplace = '';
		$fontclass = '';
		if ( 'dnxt-blurb-wrapper-two-top-left' === $this->props['font_icon_placement'] ) {
			$fonticonplace = 'dnxt-blurb-wrapper-two-top-left';
			$fontclass = 'dnxt-blurb-icon-top-left';
		}else if ( 'dnxt-blurb-wrapper-two-top-center' === $this->props['font_icon_placement'] ) {
			$fonticonplace = 'dnxt-blurb-wrapper-two-top-center';
			$fontclass = 'dnxt-blurb-icon-top-center';
		}else if (  'dnxt-blurb-wrapper-two-top-right' === $this->props['font_icon_placement']  ) {
			$fonticonplace = 'dnxt-blurb-wrapper-two-top-right';
			$fontclass = 'dnxt-blurb-icon-top-right';
		}else if( 'dnxt-blurb-wrapper-two-left-top' === $this->props['font_icon_placement'] ) {
			$fonticonplace = 'dnxt-blurb-wrapper-two-left-top';
		}else if ( 'dnxt-blurb-wrapper-two-left-center' === $this->props['font_icon_placement'] ) {
			$fonticonplace = 'dnxt-blurb-wrapper-two-left-center';
		}else if ( 'dnxt-blurb-wrapper-two-left-bottom' === $this->props['font_icon_placement'] ) {
			$fonticonplace = 'dnxt-blurb-wrapper-two-left-bottom';
		}else if ( 'dnxt-blurb-wrapper-two-bottom-left' === $this->props['font_icon_placement'] ) {
			$fonticonplace = 'dnxt-blurb-wrapper-two-bottom-left';
			$fontclass = 'dnxt-blurb-icon-bottom-left';
		}else if ( 'dnxt-blurb-wrapper-two-bottom-center' === $this->props['font_icon_placement'] ) {
			$fonticonplace = 'dnxt-blurb-wrapper-two-bottom-center';
			$fontclass = 'dnxt-blurb-icon-bottom-center';
		}else if ( 'dnxt-blurb-wrapper-two-bottom-right' === $this->props['font_icon_placement'] ) {
			$fonticonplace = 'dnxt-blurb-wrapper-two-bottom-right';
			$fontclass = 'dnxt-blurb-icon-bottom-right';
		}else if ( 'dnxt-blurb-wrapper-two-right-top' === $this->props['font_icon_placement'] ) {
			$fonticonplace = 'dnxt-blurb-wrapper-two-right-top';
		}else if ( 'dnxt-blurb-wrapper-two-right-center' === $this->props['font_icon_placement'] ) {
			$fonticonplace = 'dnxt-blurb-wrapper-two-right-center';
		}else if ( 'dnxt-blurb-wrapper-two-right-bottom' === $this->props['font_icon_placement'] ) {
			$fonticonplace = 'dnxt-blurb-wrapper-two-right-bottom';
		}

		
		if(substr($this->props['image_placement'], 0 , strlen("right")) === "right" || substr($this->props['image_placement'], 0 , strlen("left")) === "left") {
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnxt-blurb-image",
				'declaration' => 'width: auto;',
			) );
		}

		$image_placement = Common::get_alignment("image_placement",$this, "dnxt-blurb-wrapper-one");
		$img_class = Common::get_alignment("image_placement", $this, "dnxt-blurb-image");
		// Font Icon Styles.
		$icon_css_property = array(
			'selector'    => '%%order_class%% .dnxt-blurb-icon span',
			'class'       => 'et-pb-icon'
		);
		$font = Common::get_icon_html( 'dnxt_font_icon', $this, $render_slug, $multi_view, $icon_css_property );
		// Icon Font Size
		if ( 'off' !== $dnxt_use_icon ) {
			$fonticon = sprintf('<div class="dnxt-blurb-icon %1$s">%2$s</div>',
			$fontclass,
			$font
		);
		} else {
			$fonticon = "";
		}
		
		$dnxt_hover_effect = '';
		if ( 'off' !== $this->props['blurb_hover_switch'] ) {
			$dnxt_hover_effect = $this->props['dnxt_hover_effect'];
		}

		$button_text	= "";
		$rightItag		= '';
		$leftItag 		= '';
		$button 		= '';
		$icon_two_css_property = array(
			'selector'    => '%%order_class%% .dnxt-btn-icon i',
			'class'       => 'et-pb-icon'
		);
		
		if ( 'off' !== $this->props['dnxt_btn_show_hide'] ) {
			$button_text = $this->props['button_text'];

			if ( 'right' === $this->props['btn_icon_placement'] ) {
				$rightItag = Common::get_icon_html( 'btn_icon', $this, $render_slug, $multi_view, $icon_two_css_property, 'i' );
			}else if ( 'left' === $this->props['btn_icon_placement'] ) {
				$leftItag = Common::get_icon_html( 'btn_icon', $this, $render_slug, $multi_view, $icon_two_css_property, 'i' );
			}

			// Button Hover 2d
			$btnHover2d = '';
			if ( '' !== $this->props['dnxt_hover_2d'] ) {
				$btnHover2d = $this->props['dnxt_hover_2d'];
			}

			// Button Hover Background
			$btnHoverBg = '';
			if ( '' !== $this->props['dnxt_hover_bg'] ) {
				$btnHoverBg = $this->props['dnxt_hover_bg'];
			}

			// Button Hover Stock
			$btnHoverBorder = '';
			if ( '' !== $this->props['dnxt_hover_border'] ) {
				$btnHoverBorder = $this->props['dnxt_hover_border'];
			}

			// Button Hover Icons
			$btnHoverIcons = '';
			if ( '' !== $this->props['dnxt_hover_icons'] ) {
				$btnHoverIcons = $this->props['dnxt_hover_icons'];
			}
			
			//Button On Hover class inner
			$btnIconOnHover = 'off' === $this->props['btn_on_hover'] ? "dnxt-btn-icon-on-hover" : "";
			
			$buttonTarget = 'on' === $this->props['button_link_new_window'] ? '_blank' : '';

			$button = '<div class="dnxt-button-wrapper"><a href="'.esc_url($button_link).'" class="dnxt-blurb-btn dnxt-btn-icon '.esc_attr($btnIconOnHover).'  '.esc_attr($btnHover2d).' '.esc_attr($btnHoverBg).' '.esc_attr($btnHoverBorder).' '.esc_attr($btnHoverIcons).' '.esc_attr($dnxt_hover_effect) .'" target="'.esc_attr($buttonTarget).'">'.$leftItag.$button_text.$rightItag.'</a></div>';
		}

		// Tilt Effect
		$max_glare_value 	= $this->props['dnxt_tilt_max_glare'];
		$tilt_reverse		= $this->props['dnxt_tilt_reverse'];
		$tilt_perspective	= $this->props['dnxt_tilt_perspective'];
		$tilt_max			= $this->props['dnxt_tilt_max'];
		$tilt_speed			= $this->props['dnxt_tilt_speed'];
		$tilt_startx		= $this->props['dnxt_tilt_startx'];
		$tilt_starty		= $this->props['dnxt_tilt_starty'];
		$tilt_scale			= $this->props['dnxt_tilt_scale'];

		$tilt_enable = "";
		$tilt_glare_enable = "";
		$tilt_max_glare_value = "";
		$tilt = "";

		if ( 'off' !== $this->props['dnxt_blurb_tilt_switch'] ) {
			$tilt_enable = 'data-tilt';
			if ('off' !== $this->props['dnxt_blurb_tilt_glare']){
				$tilt_glare_enable = "data-tilt-glare";
				$tilt_max_glare_value = 'data-tilt-max-glare="'.intval($max_glare_value).'"';
			}

			if ('off' !== $tilt_reverse) {
				$tilt_reverse_value = 'true';
			}else if('on' !== $tilt_reverse) {
				$tilt_reverse_value = 'false';
			}

			$tilt = 'data-tilt-reverse="'.$tilt_reverse_value.'" data-tilt-perspective="'.intval($tilt_perspective).'" data-tilt-max="'.intval($tilt_max).'" data-tilt-speed="'.intval($tilt_speed).'" data-tilt-startX="'.intval($tilt_startx).'" data-tilt-startY="'.intval($tilt_starty).'" data-tilt-scale="'.intval($tilt_scale).'"';
		}

		// Handle svg image behaviour
		$dnxt_blurb_image_pathinfo 	= pathinfo( $dnxt_blurb_image );
		$is_dnxt_blurb_image_svg 	= isset( $dnxt_blurb_image_pathinfo['extension'] ) ? 'svg' === $dnxt_blurb_image_pathinfo['extension'] : false;
		
		$image_html = $multi_view->render_element( array(
			'tag'   => 'img',
			'attrs' => array(
				'src'   => '{{dnxt_image}}',
				'alt'   => '{{dnxt_alt}}',
				'class'	=> 'img-fluid'
			),
			'required' => 'dnxt_image',
		) );

		// Blurb Image
		$dnxt_image = sprintf(
			'<div class="dnxt-blurb-image %2$s" data-svg-shape="%3$s" data-shape-size="%4$s" data-use-upload="%5$s" data-uploaded-mask="%6$s">%1$s</div>',
			$image_html,
			$img_class,
			$shape_name,
			$shape_size,
			$use_mask_upload,
			$uploaded_mask
		);
		
		$positionArr = array(
            "horizontal_slug" => "dnxt_blurb_image_horizontal",
            "vertical_slug"=> "dnxt_blurb_image_vertical",
            "css_selector" => array(
                "desktop" => '%%order_class%% .dnxt-blurb-image img',
                "hover" => '%%order_class%% .dnxt-blurb-image img:hover'
            ),
            "use_shape" => $use_shape,
            "use_mask_upload" => $use_mask_upload,
        );
		
        Common::shape_image_position($positionArr, $render_slug, $this);

		$this->apply_css($render_slug);
		
		return sprintf( 
			'<div class="dnxt-blurb-wrapper-outer %14$s" %10$s %11$s %12$s %13$s>
				<div class="dnxt-blurb-wrapper %7$s">
					%5$s
					<div class="%6$s">
						%8$s
						<div class="dnxt-blurb-container">
							<div class="dnxt-blurb-heading-wrapper">
								%2$s
								%1$s
								%3$s
							</div>
							%4$s
							%9$s
						</div>
					</div>
				</div>
			</div>', 
			$blurbheading,
			$blurbpreheading,
			$blurbpostheading,
			wpautop($description),
			$dnxt_image, // #5
			$fonticonplace,
			$image_placement,
			$fonticon,
			$button, // #9
			$tilt_enable,
			$tilt_glare_enable,
			$tilt_max_glare_value,
			$tilt,
			$dnxt_hover_effect
		);
	}

	public function apply_css($render_slug){

		/**
         * Custom Padding Margin Output
         *
        */

        Common::dnxt_set_style($render_slug, $this->props, "dnxt_img_margin", "%%order_class%% .dnxt-blurb-image", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "dnxt_img_padding", "%%order_class%% .dnxt-blurb-image", "padding");

        Common::dnxt_set_style($render_slug, $this->props, "dnxt_icon_margin", "%%order_class%% .dnxt-blurb-icon", "margin");
		Common::dnxt_set_style($render_slug, $this->props, "dnxt_icon_padding", "%%order_class%% .dnxt-blurb-icon span", "padding");
		
		Common::dnxt_set_style($render_slug, $this->props, "dnxt_pre_margin", "%%order_class%% .dnxt-blurb-pre-heading", "margin");
		Common::dnxt_set_style($render_slug, $this->props, "dnxt_pre_padding", "%%order_class%% .dnxt-blurb-pre-heading", "padding");
		
		Common::dnxt_set_style($render_slug, $this->props, "dnxt_header_margin", "%%order_class%% .dnxt-blurb-heading", "margin");
		Common::dnxt_set_style($render_slug, $this->props, "dnxt_header_padding", "%%order_class%% .dnxt-blurb-heading", "padding");
		
		Common::dnxt_set_style($render_slug, $this->props, "dnxt_post_margin", "%%order_class%% .dnxt-blurb-post-heading", "margin");
		Common::dnxt_set_style($render_slug, $this->props, "dnxt_post_padding", "%%order_class%% .dnxt-blurb-post-heading", "padding");
		
		Common::dnxt_set_style($render_slug, $this->props, "dnxt_body_margin", "%%order_class%% .dnxt-blurb-container", "margin");
		Common::dnxt_set_style($render_slug, $this->props, "dnxt_body_padding", "%%order_class%% .dnxt-blurb-container", "padding");
		
		Common::dnxt_set_style($render_slug, $this->props, "dnxt_content_margin", "%%order_class%% .dnxt-blurb-description", "margin");
		Common::dnxt_set_style($render_slug, $this->props, "dnxt_content_padding", "%%order_class%% .dnxt-blurb-description", "padding");
		
		Common::dnxt_set_style($render_slug, $this->props, "dnxt_button_margin", "%%order_class%% .dnxt-blurb-btn", "margin");
		Common::dnxt_set_style($render_slug, $this->props, "dnxt_button_padding", "%%order_class%% .dnxt-blurb-btn", "padding");
		
		// Button Background One
		$button_bg_one             		= '';
		$bg_one_gradient_apply          = '';
		$bg_one_gradient_color_one 		= '';
		$bg_one_gradient_color_two 		= '';
		$bg_one_gradient_type	   		= '';
		$btn_bg_one_gl             		= '';
		$btn_bg_one_gr             		= '';
		$bg_one_gradient_start_position = '';
		$bg_one_gradient_end_position   = '';

		// Button color
		if ('' !== $this->props['button_bg_one']) {
			$button_bg_one = $this->props['button_bg_one'];
		}

		// checking gradient type
		if ('' !== $this->props['bg_one_gradient_type']) {
			$bg_one_gradient_type = $this->props['bg_one_gradient_type'];
		}

		// Button Linear Gradient Direction
		if ('' !== $this->props['bg_one_gradient_type_linear_direction']) {
			$btn_bg_one_gl = $this->props['bg_one_gradient_type_linear_direction'];
		}

		// Button Radial Gradient Direction
		if ('' !== $this->props['bg_one_gradient_type_radial_direction']) {
			$btn_bg_one_gr = $this->props['bg_one_gradient_type_radial_direction'];
		}
			
		// Apply gradient direcion
		if ('radial-gradient' === $this->props['bg_one_gradient_type']) {
			$bg_one_gradient_apply = sprintf('%1$s', $btn_bg_one_gr);
		} else if ('linear-gradient' === $this->props['bg_one_gradient_type']) {
			$bg_one_gradient_apply = sprintf('%1$s', $btn_bg_one_gl);
		}

		// Gradient color one for button
		if ('' !== $this->props['bg_one_gradient_color_one']) {
			$bg_one_gradient_color_one = $this->props['bg_one_gradient_color_one'];
		}

		// Gradient color two for button 
		if ('' !== $this->props['bg_one_gradient_color_two']) {
			$bg_one_gradient_color_two = $this->props['bg_one_gradient_color_two'];
		}

		// Button Gradient color start position 
		if ('' !== $this->props['bg_one_gradient_start_position']) {
			$bg_one_gradient_start_position = $this->props['bg_one_gradient_start_position'];
		}

		// Button Gradient color end position
		if ('' !== $this->props['bg_one_gradient_end_position']) {
			$bg_one_gradient_end_position = $this->props['bg_one_gradient_end_position'];
		}
		// Button Color
		if ('on' === $this->props['btn_one_show_hide']){
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt-button-wrapper .dnxt-blurb-btn",
				'declaration' => "background-color: $button_bg_one;",
			) );
		}
		// Button Gradient setting up
		if ('on' === $this->props['btn_one_gradient_show_hide']){
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt-button-wrapper .dnxt-blurb-btn",
				'declaration' => "background: {$bg_one_gradient_type}($bg_one_gradient_apply, $bg_one_gradient_color_one $bg_one_gradient_start_position, $bg_one_gradient_color_two $bg_one_gradient_end_position);",
			) );
		}

		// Heading Background
		$heading_gradient_apply         = '';
		$heading_gradient_color_one 	= '';
		$heading_gradient_color_two 	= '';
		$heading_gradient_type	   		= '';
		$heading_gl             		= '';
		$heading_gr             		= '';
		$heading_gradient_start_position= '';
		$heading_gradient_end_position  = '';

		// Checking Heading Background Gradient Type
		if ('' !== $this->props['heading_gradient_type']) {
			$heading_gradient_type = $this->props['heading_gradient_type'];
		}
		// Heading Linear Gradient Direction
		if ('' !== $this->props['heading_gradient_type_linear_direction']) {
			$heading_gl = $this->props['heading_gradient_type_linear_direction'];
		}

		// Heading Radial Gradient Direction
		if ('' !== $this->props['heading_gradient_type_radial_direction']) {
			$heading_gr = $this->props['heading_gradient_type_radial_direction'];
		}
			
		// Apply Heading gradient direcion
		if ( 'radial-gradient' === $this->props['heading_gradient_type'] ) {
			$heading_gradient_apply = sprintf('%1$s', $heading_gr);
		} else if ( 'linear-gradient' === $this->props['heading_gradient_type'] ) {
			$heading_gradient_apply = sprintf('%1$s', $heading_gl);
		}

		// Heading Gradient color one for content
		if ( '' !== $this->props['heading_gradient_color_one'] ) {
			$heading_gradient_color_one = $this->props['heading_gradient_color_one'];
		}

		// Heading Gradient color two for content 
		if ( '' !== $this->props['heading_gradient_color_two'] ) {
			$heading_gradient_color_two = $this->props['heading_gradient_color_two'];
		}

		// Heading Gradient color start position 
		if ( '' !== $this->props['heading_gradient_start_position'] ) {
			$heading_gradient_start_position = $this->props['heading_gradient_start_position'];
		}

		// Heading Gradient color end position
		if ( '' !== $this->props['heading_gradient_end_position'] ) {
			$heading_gradient_end_position = $this->props['heading_gradient_end_position'];
		}

		// Heading Gradient setting up
		if ( 'off' !== $this->props['heading_gradient_show_hide'] ) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt-blurb-heading-wrapper",
				'declaration' => "background: {$heading_gradient_type}($heading_gradient_apply, $heading_gradient_color_one $heading_gradient_start_position, $heading_gradient_color_two $heading_gradient_end_position);",
			) );
		}

		// Heading BG Color
		$heading_bg_color			= $this->props['heading_bg'];
		$heading_bg_color_hover 	= $this->get_hover_value( 'heading_bg' );
		$heading_bg_color_values	= et_pb_responsive_options()->get_property_values( $this->props, 'heading_bg' );
		$heading_bg_color_tablet	= isset( $heading_bg_color_values['tablet'] ) ? $heading_bg_color_values['tablet'] : '';
		$heading_bg_color_phone		= isset( $heading_bg_color_values['phone'] ) ? $heading_bg_color_values['phone'] : '';

		if ( 'off' !== $this->props['heading_bg_show_hide'] ) {
			$heading_bg_color_style 		= sprintf( 'background-color: %1$s;', esc_attr__( $heading_bg_color, 'et_builder' ) );
			$heading_bg_color_tablet_style 	= '' !== $heading_bg_color_tablet ? sprintf( 'background-color: %1$s;', esc_attr__( $heading_bg_color_tablet, 'et_builder' ) ) : '';
			$heading_bg_color_phone_style  	= '' !== $heading_bg_color_phone ? sprintf( 'background-color: %1$s;', esc_attr__( $heading_bg_color_phone, 'et_builder' ) ) : '';
			
			$heading_bg_color_style_hover  = '';

			if ( et_builder_is_hover_enabled( 'heading_bg', $this->props ) ) {
				$heading_bg_color_style_hover = sprintf( 'background-color: %1$s;', esc_attr__( $heading_bg_color_hover, 'et_builder' ) );
			}

			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnxt-blurb-heading-wrapper",
				'declaration' => $heading_bg_color_style,
			) );
			
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnxt-blurb-heading-wrapper",
				'declaration' => $heading_bg_color_tablet_style,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
			) );

			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnxt-blurb-heading-wrapper",
				'declaration' => $heading_bg_color_phone_style,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
			) );

			if ( "" !== $heading_bg_color_style_hover ) {
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => $this->add_hover_to_order_class( "%%order_class%% .dnxt-blurb-heading-wrapper:hover" ),
					'declaration' => $heading_bg_color_style_hover,
				) );
			}
		}

		// Content Background
		$content_gradient_apply         = '';
		$content_gradient_color_one 	= '';
		$content_gradient_color_two 	= '';
		$content_gradient_type	   		= '';
		$content_gl             		= '';
		$content_gr             		= '';
		$content_gradient_start_position= '';
		$content_gradient_end_position  = '';

		// Checking Content Background Gradient Type
		if ('' !== $this->props['content_gradient_type']) {
			$content_gradient_type = $this->props['content_gradient_type'];
		}
		// Content Linear Gradient Direction
		if ('' !== $this->props['content_gradient_type_linear_direction']) {
			$content_gl = $this->props['content_gradient_type_linear_direction'];
		}

		// Content Radial Gradient Direction
		if ('' !== $this->props['content_gradient_type_radial_direction']) {
			$content_gr = $this->props['content_gradient_type_radial_direction'];
		}
			
		// Apply Content gradient direcion
		if ( 'radial-gradient' === $this->props['content_gradient_type'] ) {
			$content_gradient_apply = sprintf('%1$s', $content_gr);
		} else if ( 'linear-gradient' === $this->props['content_gradient_type'] ) {
			$content_gradient_apply = sprintf('%1$s', $content_gl);
		}

		// Content Gradient color one for content
		if ( '' !== $this->props['content_gradient_color_one'] ) {
			$content_gradient_color_one = $this->props['content_gradient_color_one'];
		}

		// Content Gradient color two for content 
		if ( '' !== $this->props['content_gradient_color_two'] ) {
			$content_gradient_color_two = $this->props['content_gradient_color_two'];
		}

		// Content Gradient color start position 
		if ( '' !== $this->props['content_gradient_start_position'] ) {
			$content_gradient_start_position = $this->props['content_gradient_start_position'];
		}

		// Content Gradient color end position
		if ( '' !== $this->props['content_gradient_end_position'] ) {
			$content_gradient_end_position = $this->props['content_gradient_end_position'];
		}

		// Content Gradient setting up
		if ( 'off' !== $this->props['content_gradient_show_hide'] ) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt-blurb-container",
				'declaration' => "background: {$content_gradient_type}($content_gradient_apply, $content_gradient_color_one $content_gradient_start_position, $content_gradient_color_two $content_gradient_end_position);",
			) );
		}

		// Content BG Color
		$content_bg_color			= $this->props['content_bg'];
		$content_bg_color_hover 	= $this->get_hover_value( 'content_bg' );
		$content_bg_color_values	= et_pb_responsive_options()->get_property_values( $this->props, 'content_bg' );
		$content_bg_color_tablet	= isset( $content_bg_color_values['tablet'] ) ? $content_bg_color_values['tablet'] : '';
		$content_bg_color_phone		= isset( $content_bg_color_values['phone'] ) ? $content_bg_color_values['phone'] : '';

		if ( 'off' !== $this->props['content_bg_show_hide'] ) {
			$content_bg_color_style 		= sprintf( 'background-color: %1$s;', esc_attr( $content_bg_color ) );
			$content_bg_color_tablet_style 	= '' !== $content_bg_color_tablet ? sprintf( 'background-color: %1$s;', esc_attr( $content_bg_color_tablet ) ) : '';
			$content_bg_color_phone_style  	= '' !== $content_bg_color_phone ? sprintf( 'background-color: %1$s;', esc_attr( $content_bg_color_phone ) ) : '';
			
			$content_bg_color_style_hover  = '';

			if ( et_builder_is_hover_enabled( 'content_bg', $this->props ) ) {
				$content_bg_color_style_hover = sprintf( 'background-color: %1$s;', esc_attr( $content_bg_color_hover ) );
			}

			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnxt-blurb-container",
				'declaration' => $content_bg_color_style,
			) );
			
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnxt-blurb-container",
				'declaration' => $content_bg_color_tablet_style,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
			) );

			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnxt-blurb-container",
				'declaration' => $content_bg_color_phone_style,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
			) );

			if ( "" !== $content_bg_color_style_hover ) {
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => $this->add_hover_to_order_class( "%%order_class%% .dnxt-blurb-container:hover" ),
					'declaration' => $content_bg_color_style_hover,
				) );
			}
		}

		// Background Image Background
		$bg_img_gradient_apply      	= '';
		$bg_img_gradient_color_one 		= '';
		$bg_img_gradient_color_two 		= '';
		$bg_img_gradient_type	   		= '';
		$bg_img_gl             			= '';
		$bg_img_gr             			= '';
		$bg_img_gradient_start_position	= '';
		$bg_img_gradient_end_position  	= '';

		// checking gradient type
		if ( '' !== $this->props['bg_img_gradient_type'] ) {
			$bg_img_gradient_type = $this->props['bg_img_gradient_type'];
		}

		// Background Image Linear Gradient Direction
		if ( '' !== $this->props['bg_img_gradient_type_linear_direction'] ) {
			$bg_img_gl = $this->props['bg_img_gradient_type_linear_direction'];
		}

		// Background Image Radial Gradient Direction
		if ( '' !== $this->props['bg_img_gradient_type_radial_direction'] ) {
			$bg_img_gr = $this->props['bg_img_gradient_type_radial_direction'];
		}
			
		// Apply gradient direcion
		if ( 'radial-gradient' === $this->props['bg_img_gradient_type'] ) {
			$bg_img_gradient_apply = sprintf('%1$s', $bg_img_gr);
		} else if ('linear-gradient' === $this->props['bg_img_gradient_type']) {
			$bg_img_gradient_apply = sprintf('%1$s', $bg_img_gl);
		}

		// Gradient color one for Background Image
		if ( '' !== $this->props['bg_img_gradient_color_one'] ) {
			$bg_img_gradient_color_one = $this->props['bg_img_gradient_color_one'];
		}
		// Gradient color two for Background Image
		if ( '' !== $this->props['bg_img_gradient_color_two'] ) {
			$bg_img_gradient_color_two = $this->props['bg_img_gradient_color_two'];
		}
		// Background Image Gradient color start position 
		if ( '' !== $this->props['bg_img_gradient_start_position'] ) {
			$bg_img_gradient_start_position = $this->props['bg_img_gradient_start_position'];
		}
		// Background Image Gradient color end position
		if ( '' !== $this->props['bg_img_gradient_end_position'] ) {
			$bg_img_gradient_end_position = $this->props['bg_img_gradient_end_position'];
		}

		// Background Image Gradient setting up
		if ( 'on' === $this->props['bg_img_gradient_show_hide'] ) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt-blurb-image",
				'declaration' => "background: {$bg_img_gradient_type}($bg_img_gradient_apply, $bg_img_gradient_color_one $bg_img_gradient_start_position, $bg_img_gradient_color_two $bg_img_gradient_end_position);",
			) );
		}

	 // Image BG Color
	$image_bg_color			= $this->props['image_bg_color'];
	$image_bg_color_hover 	= $this->get_hover_value( 'image_bg_color' );
	$image_bg_color_values	= et_pb_responsive_options()->get_property_values( $this->props, 'image_bg_color' );
	$image_bg_color_tablet	= isset( $image_bg_color_values['tablet'] ) ? $image_bg_color_values['tablet'] : '';
	$image_bg_color_phone	= isset( $image_bg_color_values['phone'] ) ? $image_bg_color_values['phone'] : '';

	if ( 'off' !== $this->props['use_image_bg_color'] ) {
		$image_bg_color_style 		    = sprintf( 'background-color: %1$s;', esc_attr( $image_bg_color ) );
		$image_bg_color_tablet_style 	= '' !== $image_bg_color_tablet ? sprintf( 'background-color: %1$s;', esc_attr( $image_bg_color_tablet ) ) : '';
		$image_bg_color_phone_style  	= '' !== $image_bg_color_phone ? sprintf( 'background-color: %1$s;', esc_attr( $image_bg_color_phone ) ) : '';
		
		$image_bg_color_style_hover  = '';

		if ( et_builder_is_hover_enabled( 'image_bg_color', $this->props ) ) {
			$image_bg_color_style_hover = sprintf( 'background-color: %1$s;', esc_attr( $image_bg_color_hover ) );
		}

		ET_Builder_Element::set_style( $render_slug, array(
			'selector'    => "%%order_class%% .dnxt-blurb-image",
			'declaration' => $image_bg_color_style,
		) );
		
		ET_Builder_Element::set_style( $render_slug, array(
			'selector'    => "%%order_class%% .dnxt-blurb-image",
			'declaration' => $image_bg_color_tablet_style,
			'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
		) );

		ET_Builder_Element::set_style( $render_slug, array(
			'selector'    => "%%order_class%% .dnxt-blurb-image",
			'declaration' => $image_bg_color_phone_style,
			'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
		) );

		if ( "" !== $image_bg_color_style_hover ) {
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => $this->add_hover_to_order_class( "%%order_class%% .dnxt-blurb-image" ),
				'declaration' => $image_bg_color_style_hover,
			) );
		}
	}

		// Background Icon Gradient
		$font_icon_gradient_apply      		= '';
		$font_icon_gradient_color_one 		= '';
		$font_icon_gradient_color_two 		= '';
		$font_icon_gradient_type	   		= '';
		$font_icon_gl             			= '';
		$font_icon_gr             			= '';
		$font_icon_gradient_start_position	= '';
		$font_icon_gradient_end_position  	= '';

		// checking gradient type
		if ( '' !== $this->props['font_icon_gradient_type'] ) {
			$font_icon_gradient_type = $this->props['font_icon_gradient_type'];
		}
		// Background Image Linear Gradient Direction
		if ( '' !== $this->props['font_icon_gradient_type_linear_direction'] ) {
			$font_icon_gl = $this->props['font_icon_gradient_type_linear_direction'];
		}

		// Background Image Radial Gradient Direction
		if ( '' !== $this->props['font_icon_gradient_type_radial_direction'] ) {
			$font_icon_gr = $this->props['font_icon_gradient_type_radial_direction'];
		}	
		// Apply gradient direcion
		if ( 'radial-gradient' === $this->props['font_icon_gradient_type'] ) {
			$font_icon_gradient_apply = sprintf('%1$s', $font_icon_gr);
		} else if ( 'linear-gradient' === $this->props['font_icon_gradient_type'] ) {
			$font_icon_gradient_apply = sprintf('%1$s', $font_icon_gl);
		}

		// Gradient color one for Background Image
		if ( '' !== $this->props['font_icon_gradient_color_one'] ) {
			$font_icon_gradient_color_one = $this->props['font_icon_gradient_color_one'];
		}
		// Gradient color two for Background Image
		if ( '' !== $this->props['font_icon_gradient_color_two'] ) {
			$font_icon_gradient_color_two = $this->props['font_icon_gradient_color_two'];
		}
		// Background Image Gradient color start position 
		if ( '' !== $this->props['font_icon_gradient_start_position'] ) {
			$font_icon_gradient_start_position = $this->props['font_icon_gradient_start_position'];
		}
		// Background Image Gradient color end position
		if ( '' !== $this->props['font_icon_gradient_end_position'] ) {
			$font_icon_gradient_end_position = $this->props['font_icon_gradient_end_position'];
		}
		// Background Image Gradient setting up
		if ( 'off' !== $this->props['use_font_icon_gradient_show_hide'] ) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt-blurb-icon span",
				'declaration' => "background: {$font_icon_gradient_type}($font_icon_gradient_apply, $font_icon_gradient_color_one $font_icon_gradient_start_position, $font_icon_gradient_color_two $font_icon_gradient_end_position);",
			) );
		}

		// Icon Placement
		if ( 'right' === $this->props['font_icon_placement'] ) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    	=> "%%order_class%% .dnxt-blurb-icon span",
				'declaration'	=> 'align-self: flex-end;'
			) );
		}else if( 'center' === $this->props['font_icon_placement'] ) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    	=> "%%order_class%% .dnxt-blurb-icon span",
				'declaration'	=> 'align-self: center;'
			) );
		}else if( 'left' === $this->props['font_icon_placement'] ) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    	=> "%%order_class%% .dnxt-blurb-icon span",
				'declaration'	=> 'align-self: flex-start;'
			) );
		}

		if( "on" === $this->props['btn_show_hide'] ) {
			
			// Button Icon Color
			if ( '' !== $this->props['btn_icon_color'] ) {
				ET_Builder_Element::set_style($render_slug, array(
					'selector'    => "%%order_class%% .dnxt-btn-icon i",
					'declaration' => "color: {$this->props['btn_icon_color']};"
				) );
			}
			// Button Icon Color Hover
			$btn_icon_color_hover = isset($this->props['btn_icon_color__hover_enabled']) ? "on|hover" : "off|hover";

			if ( "on|hover" === $btn_icon_color_hover ) {
				ET_Builder_Element::set_style($render_slug, array(
					'selector'    => "%%order_class%% .dnxt-btn-icon:hover i",
					'declaration' => "color: {$this->props['btn_icon_color__hover']};"
				) );
			}

			// Button Icon On Hover
			if ( 'on' === $this->props['btn_on_hover'] && 'right' === $this->props['btn_icon_placement'] ) {
				ET_Builder_Element::set_style($render_slug, array(
					'selector'    => "%%order_class%% .dnxt-btn-icon:hover i",
					'declaration' => "opacity: 1;visibility: visible;margin-left: 0;padding-left: 0.4em;"
				) );
			}else if( 'on' === $this->props['btn_on_hover'] ) {
				ET_Builder_Element::set_style($render_slug, array(
					'selector'    => "%%order_class%% .dnxt-btn-icon:hover i",
					'declaration' => "opacity: 1;visibility: visible;"
				) );
			}
			if ( 'on' === $this->props['btn_on_hover'] && 'left' === $this->props['btn_icon_placement'] ) {
				ET_Builder_Element::set_style($render_slug, array(
					'selector'    => "%%order_class%% .dnxt-btn-icon:hover i",
					'declaration' => "opacity: 1;visibility: visible;padding-right: 0.4em;margin-left: 0;"
				) );
			}else if( 'on' === $this->props['btn_on_hover'] ) {
				ET_Builder_Element::set_style($render_slug, array(
					'selector'    => "%%order_class%% .dnxt-btn-icon:hover i",
					'declaration' => "opacity: 1;visibility: visible;"
				) );
			}
			// Button Icon Placement
			if ( 'off' === $this->props['btn_on_hover'] && 'left' === $this->props['btn_icon_placement'] ) {
				ET_Builder_Element::set_style($render_slug, array(
					'selector'    => "%%order_class%% .dnxt-btn-icon.dnxt-btn-icon-on-hover i",
					'declaration' => "opacity: 1;visibility: visible;margin-left: 0;padding-right: 0.4em;"
				) );
			}else if( 'off' === $this->props['btn_on_hover'] && 'right' === $this->props['btn_icon_placement'] ) {
				ET_Builder_Element::set_style($render_slug, array(
					'selector'    => "%%order_class%% .dnxt-btn-icon.dnxt-btn-icon-on-hover i",
					'declaration' => "opacity: 1;visibility: visible;margin-left: 0;padding-left: 0.4em;"
				) );
			}
		}

		// Button Hover Background Color dnxt_hover_border_bg_color
		if ( '' !== $this->props['dnxt_hover_bg_color'] ) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .{$this->props['dnxt_hover_bg']}:before",
				'declaration' => "background: {$this->props['dnxt_hover_bg_color']}!important;"
			) );
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .{$this->props['dnxt_hover_bg']}:hover:before",
				'declaration' => "transform: scaleX(1)!important;"
			) );
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt-hover-fade:hover",
				'declaration' => "background: {$this->props['dnxt_hover_bg_color']}!important;"
			) );
		}
		// Button Hover Background Color Radial Out
		if ( 'dnxt-hover-radial-out' === $this->props['dnxt_hover_bg'] ) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt-hover-radial-out",
				'declaration' => "background: {$this->props['dnxt_radial_out_bg_color']}!important;"
			) );
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt-hover-radial-out:before",
				'declaration' => "background: {$this->props['dnxt_hover_bg_color']}!important;"
			) );
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt-hover-radial-out:hover:before",
				'declaration' => "transform: scale(2)!important;"
			) );
		}
		// Button Hover Background Color Radial In
		if ( 'dnxt-hover-radial-in' === $this->props['dnxt_hover_bg'] ) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt-hover-radial-in",
				'declaration' => "background: {$this->props['dnxt_hover_bg_color']}!important;"
			) );
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt-hover-radial-in:before",
				'declaration' => "background: {$this->props['dnxt_radial_in_bg_color']}!important;"
			) );
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt-hover-radial-in:hover:before",
				'declaration' => "transform: scale(0)!important;"
			) );
		}
		// Button Hover Background Color Rectangle In
		if ( 'dnxt-hover-rectangle-in' === $this->props['dnxt_hover_bg'] ) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt-hover-rectangle-in",
				'declaration' => "background: {$this->props['dnxt_hover_bg_color']}!important;"
			) );
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt-hover-rectangle-in:before",
				'declaration' => "background: {$this->props['dnxt_rectangle_in_bg_color']}!important;"
			) );
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt-hover-rectangle-in:hover:before",
				'declaration' => "transform: scale(0)!important;"
			) );
		}
		// Button Hover Background Color Rectangle Out
		if ( 'dnxt-hover-rectangle-out' === $this->props['dnxt_hover_bg'] ) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt-hover-rectangle-out",
				'declaration' => "background: {$this->props['dnxt_rectangle_out_bg_color']}!important;"
			) );
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt-hover-rectangle-out:before",
				'declaration' => "background: {$this->props['dnxt_hover_bg_color']}!important;"
			) );
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt-hover-rectangle-out:hover:before",
				'declaration' => "transform: scale(1)!important;"
			) );
		}
		// Button Hover Background Color Shutter In
		if ( 'dnxt-hover-shutter-in-horizontal' === $this->props['dnxt_hover_bg'] ) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt-hover-shutter-in-horizontal",
				'declaration' => "background: {$this->props['dnxt_hover_bg_color']}!important;"
			) );
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt-hover-shutter-in-horizontal:before",
				'declaration' => "background: {$this->props['dnxt_shutter_in_bg_color']}!important;"
			) );
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt-hover-shutter-in-horizontal:hover:before",
				'declaration' => "transform: scaleX(0)!important;"
			) );
		}
		// Button Hover Background Color Shutter Out
		if ( 'dnxt-hover-shutter-out-horizontal' === $this->props['dnxt_hover_bg'] ) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt-hover-shutter-out-horizontal",
				'declaration' => "background: {$this->props['dnxt_shutter_out_bg_color']}!important;"
			) );
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt-hover-shutter-out-horizontal:before",
				'declaration' => "background: {$this->props['dnxt_hover_bg_color']}!important;"
			) );
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt-hover-shutter-out-horizontal:hover:before",
				'declaration' => "transform: scaleX(1)!important;"
			) );
		}
		// Button Hover Background Color Shutter In Vertical
		if ( 'dnxt-hover-shutter-in-vertical' === $this->props['dnxt_hover_bg'] ) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt-hover-shutter-in-vertical",
				'declaration' => "background: {$this->props['dnxt_hover_bg_color']}!important;"
			) );
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt-hover-shutter-in-vertical:before",
				'declaration' => "background: {$this->props['dnxt_shutter_in_v_bg_color']}!important;"
			) );
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt-hover-shutter-in-vertical:hover:before",
				'declaration' => "transform: scaleY(0)!important;"
			) );
		}
		// Button Hover Background Color Shutter Out Vertical
		if ( 'dnxt-hover-shutter-out-vertical' === $this->props['dnxt_hover_bg'] ) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt-hover-shutter-out-vertical",
				'declaration' => "background: {$this->props['dnxt_shutter_out_v_bg_color']}!important;"
			) );
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt-hover-shutter-out-vertical:before",
				'declaration' => "background: {$this->props['dnxt_hover_bg_color']}!important;"
			) );
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt-hover-shutter-out-vertical:hover:before",
				'declaration' => "transform: scaleY(1)!important;"
			) );
		}
		// Button Hover Background Color
		if ( '' !== $this->props['dnxt_hover_border_bg_color'] ) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .{$this->props['dnxt_hover_border']}",
				'declaration' => "background: {$this->props['dnxt_hover_border_bg_color']}!important;"
			) );
		}
		// Hover Trim Border Color
		if ( 'dnxt-hover-trim' === $this->props['dnxt_hover_border'] ) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt-hover-trim:before",
				'declaration' => "border: {$this->props['dnxt_trim_border_color']} solid 4px;"
			) );
		}
		// Hover Ripple In Border Color
		if ( 'dnxt-hover-ripple-out' === $this->props['dnxt_hover_border'] ) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt-hover-ripple-out:before",
				'declaration' => "border: {$this->props['dnxt_ripple_out_color']} solid 6px;"
			) );
		}
		// Hover Ripple Out Border Color
		if ( 'dnxt-hover-ripple-in' === $this->props['dnxt_hover_border'] ) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt-hover-ripple-in:before",
				'declaration' => "border: {$this->props['dnxt_ripple_in_color']} solid 6px;"
			) );
		}
		// Hover Underline From Left Color
		if ( 'dnxt-hover-underline-from-left' === $this->props['dnxt_hover_border'] ) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt-hover-underline-from-left:before",
				'declaration' => "background: {$this->props['dnxt_underline_from_left_color']};"
			) );
		}
		// Hover Underline From Center Color
		if ( 'dnxt-hover-underline-from-center' === $this->props['dnxt_hover_border'] ) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt-hover-underline-from-center:before",
				'declaration' => "background: {$this->props['dnxt_underline_from_center_color']};"
			) );
		}
		// Hover Underline From Right Color
		if ('dnxt-hover-underline-from-right' === $this->props['dnxt_hover_border'] ) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt-hover-underline-from-right:before",
				'declaration' => "background: {$this->props['dnxt_underline_from_right_color']};"
			) );
		}
		// Hover Overline From Left Color
		if ( 'dnxt-hover-overline-from-left' === $this->props['dnxt_hover_border'] ) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt-hover-overline-from-left:before",
				'declaration' => "background: {$this->props['dnxt_overline_left_color']};"
			) );
		}
		// Hover Overline From Center Color
		if ( 'dnxt-hover-overline-from-center' === $this->props['dnxt_hover_border'] ) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt-hover-overline-from-center:before",
				'declaration' => "background: {$this->props['dnxt_overline_center_color']};"
			) );
		}
		// Hover Overline From Center Color
		if ('dnxt-hover-overline-from-right' === $this->props['dnxt_hover_border']){
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt-hover-overline-from-right:before",
				'declaration' => "background: {$this->props['dnxt_overline_right_color']};"
			) );
		}
		// Hover Reveal Color
		if ( 'dnxt-hover-reveal' === $this->props['dnxt_hover_border'] ) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt-hover-reveal:before",
				'declaration' => "border-color: {$this->props['dnxt_reveal_color']};"
			) );
		}
		// Hover Underline Reveal Color
		if ( 'dnxt-hover-underline-reveal' === $this->props['dnxt_hover_border'] ) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt-hover-underline-reveal:before",
				'declaration' => "background: {$this->props['dnxt_underline_reveal_color']};"
			) );
		}
		// Hover Underline overline Color
		if ( 'dnxt-hover-overline-reveal' === $this->props['dnxt_hover_border'] ) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt-hover-overline-reveal:before",
				'declaration' => "background: {$this->props['dnxt_overline_reveal_color']};"
			) );
		}

		// Image Zindex
		$img_zindex = intval($this->props['img_zindex']);
		if ( '' !== $img_zindex ) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt-blurb-image img",
				'declaration' => "position: relative; z-index: {$img_zindex}"
			) );
		}
		// Icon Zindex
		$icon_zindex = intval($this->props['icon_zindex']);
		if( '' !== $icon_zindex ) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt-blurb-icon span",
				'declaration' => "position: relative; z-index: {$icon_zindex}"
			) );
		}
		// Heading Zindex
		$heading_zindex = intval($this->props['heading_zindex']);
		if ( '' !== $heading_zindex ) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt-blurb-heading-wrapper",
				'declaration' => "position: relative; z-index: {$heading_zindex}"
			) );
		}
		// Button Zindex
		$button_zindex = intval($this->props['button_zindex']);
		if ( '' !== $button_zindex ) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt-button-wrapper .dnxt-blurb-btn",
				'declaration' => "position: relative; z-index: {$button_zindex}"
			));
		}
	}
	/**
	 * Filter multi view value.
	 *
	 * @since 3.27.1
	 *
	 * @see ET_Builder_Module_Helper_MultiViewOptions::filter_value
	 *
	 * @param mixed                                     $raw_value Props raw value.
	 * @param array                                     $args {
	 *                                         Context data.
	 *
	 *     @type string $context      Context param: content, attrs, visibility, classes.
	 *     @type string $name         Module options props name.
	 *     @type string $mode         Current data mode: desktop, hover, tablet, phone.
	 *     @type string $attr_key     Attribute key for attrs context data. Example: src, class, etc.
	 *     @type string $attr_sub_key Attribute sub key that availabe when passing attrs value as array such as styes. Example: padding-top, margin-botton, etc.
	 * }
	 * @param ET_Builder_Module_Helper_MultiViewOptions $multi_view Multiview object instance.
	 *
	 * @return mixed
	 */
	public function multi_view_filter_value( $raw_value, $args, $multi_view ) {
		$name = isset( $args['name'] ) ? $args['name'] : '';

		if ( $raw_value && in_array( $name, array('dnxt_font_icon', 'btn_icon') )){
			return et_pb_get_extended_font_icon_value( $raw_value, true );
		}
		return $raw_value;
	}
}

new Next_Blurb;
