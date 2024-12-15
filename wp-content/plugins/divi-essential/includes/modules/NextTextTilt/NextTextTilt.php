<?php

class NextTextTilt extends ET_Builder_Module {

	public $slug       = 'dnxte_text_tilt';
	public $vb_support = 'on';

	protected $module_credits = array(
		'module_uri' => 'https://www.diviessential.com/divi-text-tilt/',
		'author'     => 'Divi Next',
		'author_uri' => 'www.divinext.com',
	);

	public function init() {
		$this->name 		= esc_html__( 'Next Text Tilt', 'et_builder' );
		$this->icon_path    = plugin_dir_path( __FILE__ ) . 'icon.svg';
		$this->folder_name 	= 'et_pb_divi_essential';

		$this->settings_modal_toggles = array(
			'general'	=> array(
				'toggles'		=>	array(
					'dnxt_tilt_content_background'	=> array(
						'title'		=>	esc_html__( 'Background Content', 'et_builder' ),
						'priority'	=>	78,
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
				'toggles'	=>	array(	
					'dnxt_tilt_text'	=> array(
						"title"		=>	esc_html__( 'Title Text', 'et_builder' ),
						'sub_toggles'       => array(
                            'sub_toggle_heading'   => array(
                                'name' => 'Heading',
                            ),
                            'sub_toggle_post' => array(
                                'name' => 'Body',
							),
                        ),
                        'tabbed_subtoggles' => true,
					),				
					'dnxt_tilt_effect'	=> array(
						"title"		=>	esc_html__( 'Tilt Effect', 'et_builder' ),
					),
					'dnxt_tilt_content_box_shadow'	=> array(
						"title"		=>	esc_html__( 'Content Box Shadow', 'et_builder' ),
						'priority'	=>	102,
					),
					'dnxt_tilt_content_border'	=> array(
						"title"		=>	esc_html__( 'Content Border', 'et_builder' ),
						'priority'	=>	100,
					),
					'dnxt_tilt_content_space'	=> array(
						"title"		=>	esc_html__( 'Content Spacing', 'et_builder' ),
						'priority'	=>	91,
					)
				), 
			),
		);

		// Custom CSS Field
		$this->custom_css_fields = array(
			'tilt_body'    => array(
				'label'    => esc_html__('Tilt', 'et_builder'),
				'selector' => '%%order_class%% .dnxt-txt-parallax-effect',
			),
			'heading'      => array(
				'label'    => esc_html__('Heading', 'et_builder'),
				'selector' => '%%order_class%% .dnxt-txt-parallax-effect-3d',
			),
			'tilt_heading' => array(
				'label'    => esc_html__('Tilt Heading', 'et_builder'),
				'selector' => '%%order_class%% .dnxt-txt-parallax-effect .dnxt-txt-parallax-mini-heading',
			),  
			'text_body'    => array(
				'label'    => esc_html__('Text Body', 'et_builder'),
				'selector' => '%%order_class%% .dnxt-txt-parallax-effect-3d p',
			),
		);
	}

	public function get_fields() {
		return array(
			// Tilt Text
			'tilt_text' => array(
				'label'           => esc_html__( 'Heading', 'et_builder' ),
				'type'            => 'text',
				'dynamic_content' => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Heading Text here will appear inside the module.', 'et_builder' ),
				'toggle_slug'     => 'main_content',
			),
			// Heading Tag
			'heading_tag'     => array(
                'label'           => esc_html__('Select Heading Tag', 'et_builder'),
                'type'            => 'select',
                'description'     => esc_html__('Select the heading tag, which you would like to use', 'et_builder'),
                'option_category' => 'basic_option',
                'toggle_slug'     => 'main_content',
                'options'         => array(
                    'h1'	  => esc_html__('H1', 'et_builder'),
                    'h2'	  => esc_html__('H2', 'et_builder'),
                    'h3'	  => esc_html__('H3', 'et_builder'),
                    'h4'	  => esc_html__('H4', 'et_builder'),
                    'h5'	  => esc_html__('H5', 'et_builder'),
                    'h6'	  => esc_html__('H6', 'et_builder'),
                    'p'	      => esc_html__('P', 'et_builder'),
                    'span'	  => esc_html__('Span', 'et_builder'),
                ),
				'default'         => 'h2',
			),
			// Body Switch
			'body_switch'  => array(
				'label'           => esc_html__('Body Enable', 'et_builder'),
				'type'            => 'yes_no_button',  
				'description'     => esc_html__('Enable body for the text tilt to add extra information to your text tilt heading', 'et_builder'),              
				'toggle_slug'     => 'main_content',
				'options'         => array(
					'off'     => esc_html__('Off', 'et_builder'),
					'on'      => esc_html__('On', 'et_builder'),
				),
				'affects'         => array(
					'tilt_body',
				),
				'default_on_front' => 'on',
			),
			'tilt_body' => array(
				'label'           => esc_html__( 'Body', 'et_builder' ),
				'type'            => 'tiny_mce',
				'dynamic_content' => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Description entered here will appear inside the module.', 'et_builder' ),
				'toggle_slug'     => 'main_content',
			),
			// Content Background 
			'tilt_content_bg_show_hide'  => array(
				'label'           => esc_html__( 'Background Content Color', 'et_builder'),
				'type'            => 'yes_no_button', 
				'description'     => esc_html__( 'Enable this to add background color to your text.', 'et_builder' ),               
				'toggle_slug'     => 'dnxt_tilt_content_background',
				'sub_toggle'	  => 'sub_toggle_color',
				'options'             => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'affects'         => array(
					'tilt_content_bg',
				),
				'default_on_front' => 'off',
			),
			// Content BG Color
			'tilt_content_bg'    => array(
				'label'          => esc_html__('Select Background Color', 'et_builder'),
				'type'           => 'color-alpha',
				'description'    => esc_html__( 'Select a suitable background color from color picker for the text.', 'et_builder' ),               
				'toggle_slug'    => 'dnxt_tilt_content_background',
				'sub_toggle'	 => 'sub_toggle_color',
				'hover'    		 => 'tabs',
				'default'        => '#0077FF',
				'depends_show_if'=> 'on',
			),
			// Background Content Gradient 
			'tilt_content_gradient_show_hide'  => array(
				'label'           => esc_html__( 'Gradient Description Color', 'et_builder'),
				'type'            => 'yes_no_button',
				'description'     => esc_html__( 'Enable this to add gradient background color to your tilt text.', 'et_builder' ),                
				'toggle_slug'     => 'dnxt_tilt_content_background',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'options'             => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'affects'         => array(
					'tilt_content_gradient_color_one',
					'tilt_content_gradient_color_two',
					'tilt_content_gradient_type',
					'tilt_content_gradient_start_position',
					'tilt_content_gradient_end_position'
				),
				'default_on_front' => 'off',
			),
			'tilt_content_gradient_color_one'	=> array(
				'label'          => esc_html__('Select Color One', 'et_builder'),
				'type'           => 'color-alpha',
				'description'     => esc_html__( 'Choose the first color to blend with the second color from the color picker that suits your tilt text.', 'et_builder' ),
				'toggle_slug'    => 'dnxt_tilt_content_background',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'default'        => '#0077FF',
				'depends_show_if'=> 'on',
			),
			'tilt_content_gradient_color_two'	=> array(
				'label'          => esc_html__('Select Color Two', 'et_builder'),
				'type'           => 'color-alpha',
				'description'     => esc_html__( 'Choose the second color to blend with the first color from the color picker that suits your tilt text.', 'et_builder' ),
				'toggle_slug'    => 'dnxt_tilt_content_background',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'default'        => '#772ADB',
				'depends_show_if'=> 'on',
			),
			'tilt_content_gradient_type'		=> array(
				'label'           => esc_html__('Select Gradient Type', 'et_builder'),
				'type'            => 'select',
				'description'     => esc_html__('Select a type for your gradient here.', 'et_builder'),
				'option_category' => 'basic_option',
				'toggle_slug'     => 'dnxt_tilt_content_background',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'options'         => array(
					'linear-gradient' => esc_html__('Linear', 'et_builder'),
					'radial-gradient' => esc_html__('Radial', 'et_builder'),
				),
				'default'         => 'linear-gradient',
				'depends_show_if' => 'on',
			),
			'tilt_content_gradient_type_linear_direction'   => array(
				'label'           => esc_html__('Linear direction', 'et_builder'),
				'type'            => 'range',
				'description'     => esc_html__( 'Adjust the direction of the gradient for the tilt text.', 'et_builder' ),
				'option_category'=> 'basic_option',
				'toggle_slug'    => 'dnxt_tilt_content_background',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'range_settings'  => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 360,
				),
				'default'         => '180deg',
				'fixed_unit'      => 'deg',
				'show_if' => array(
					'tilt_content_gradient_show_hide' => 'on',
					'tilt_content_gradient_type' => 'linear-gradient'
				),
			),
			'tilt_content_gradient_type_radial_direction'   => array(
				'label'           	=> esc_html__('Radial Direction', 'et_builder'),
				'type'            	=> 'select',
				'description'     	=> esc_html__('Adjust the direction of the gradient for the tilt text.', 'et_builder'),                
				'option_category'	=> 'basic_option',
				'toggle_slug'    	=> 'dnxt_tilt_content_background',
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
					'tilt_content_gradient_show_hide' 		=> 'on',
					'tilt_content_gradient_type'	=> 'radial-gradient'
				),
			),
			'tilt_content_gradient_start_position'           => array(
				'label'           => esc_html__('Start Position', 'et_builder'),
				'type'            => 'range',
				'description'     => esc_html__( 'Adjust the position for the beginning of the gradient color.', 'et_builder' ),
				'option_category' => 'basic_option',
				'toggle_slug'     => 'dnxt_tilt_content_background',
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
			'tilt_content_gradient_end_position'             => array(
				'label'           => esc_html__('End Position', 'et_builder'),
				'type'            => 'range',
				'description'     => esc_html__( 'Adjust the position for the ending of the gradient color.', 'et_builder' ),
				'option_category' => 'basic_option',
				'toggle_slug'     => 'dnxt_tilt_content_background',
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
			// Data Tilt Glare Enable
			'dnxt_tilt_text_glare'=> array(
				'label'           => esc_html__('Glare Enable', 'et_builder'),
				'type'            => 'yes_no_button',
				'description'     => esc_html__( 'Enable this to get a slightly lowered opacity effect above the tilt text when hovered upon with the cursor.', 'et_builder' ),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dnxt_tilt_effect',
				'options'   => array(
					'off'     => esc_html__('Off', 'et_builder'),
					'on'      => esc_html__('On', 'et_builder'),
				),
				'affects'         => array(
					'dnxt_tilt_text_max_glare'
				),
				'default_on_front'=> 'off',
			),
			// Data Tilt Max Glare
			'dnxt_tilt_text_max_glare' => array(
				'label'           => esc_html__('Max Glare', 'et_builder'),
				'type'            => 'range',
				'description'     => esc_html__( 'Adjust the glare to the tilt text; the higher the value the lower the opacity.', 'et_builder' ),
				'option_category' => 'configuration',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dnxt_tilt_effect',
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
			),
			// Data Tilt 3D Enable
			'dnxt_tilt_text_3d'   => array(
				'label'           => esc_html__('3D Enable', 'et_builder'),
				'type'            => 'yes_no_button',
				'description'     => esc_html__( 'Enable this to get a 3D effect on the tilt text.', 'et_builder' ),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dnxt_tilt_effect',
				'options'   => array(
					'off'     => esc_html__('Off', 'et_builder'),
					'on'      => esc_html__('On', 'et_builder'),
				),
				'affects'         => array(
					'dnxt_tilt_text_3d_transform'
				),
				'default_on_front'=> 'off',
			),
			// Data Tilt 3D Transform
			'dnxt_tilt_text_3d_transform' => array(
				'label'           => esc_html__('3D Transform', 'et_builder'),
				'type'            => 'range',
				'description'     => esc_html__( 'Adjust to control the 3D effect enabled using this tool.', 'et_builder' ),
				'option_category' => 'configuration',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dnxt_tilt_effect',
				'range_settings'  => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 100,
				),
				'default'         => '50px',				
                'fixed_unit'      => 'px',
				'validate_unit'   => true,
				'options'   => array(
					'off'     => esc_html__('Off', 'et_builder'),
					'on'      => esc_html__('On', 'et_builder'),
				),
			),
			// Data Tilt Reverse
			'dnxt_tilt_text_reverse' => array(
				'label'           => esc_html__('Tilt Reverse', 'et_builder'),
				'type'            => 'yes_no_button',
				'description'     => esc_html__( 'Enabling this helps the tilt effect to occur on the opposite direction.', 'et_builder' ),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dnxt_tilt_effect',
				'options'   => array(
					'off'     => esc_html__('Off', 'et_builder'),
					'on'      => esc_html__('On', 'et_builder'),
				),
				'default'           => 'off',
			),
			// Data Tilt Perspective
			'dnxt_tilt_text_perspective' => array(
				'label'           => esc_html__('Tilt Perspective', 'et_builder'),
				'type'            => 'range',
				'description'     => esc_html__( 'Adjust the perspective to the tilt text; the higher the value the lower the space taken.', 'et_builder' ),
				'option_category' => 'configuration',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dnxt_tilt_effect',
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
			),
			// Data Tilt Max
			'dnxt_tilt_text_max' => array(
				'label'           => esc_html__('Tilt Max', 'et_builder'),
				'type'            => 'range',
				'description'     => esc_html__( 'Adjust this to lessen the excessive movement; the higher the value the faster the tilt effect when hovered on with cursor.', 'et_builder' ),
				'option_category' => 'configuration',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dnxt_tilt_effect',
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
			),
			// Data Tilt Speed
			'dnxt_tilt_text_speed'=> array(
				'label'           => esc_html__('Tilt Speed', 'et_builder'),
				'type'            => 'range',
				'description'     => esc_html__( 'Adjust the tilt speed using this slider below; the higher the value the faster the motion.', 'et_builder' ),
				'option_category' => 'configuration',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dnxt_tilt_effect',
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
			),
			// Data Tilt StartX
			'dnxt_tilt_text_startx' => array(
				'label'           => esc_html__('Tilt StartX', 'et_builder'),
				'type'            => 'range',
				'description'     => esc_html__( 'Adjust the vertical angle to tilt text.', 'et_builder' ),
				'option_category' => 'configuration',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dnxt_tilt_effect',
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
			),
			// Data Tilt StartY
			'dnxt_tilt_text_starty' => array(
				'label'           => esc_html__('Tilt StartY', 'et_builder'),
				'type'            => 'range',
				'description'     => esc_html__( 'Adjust the horizontal angle to the tilt text.', 'et_builder' ),
				'option_category' => 'configuration',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dnxt_tilt_effect',
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
			),
			// Data Tilt Scale
			'dnxt_tilt_text_scale'=> array(
				'label'           => esc_html__('Tilt Scale', 'et_builder'),
				'type'            => 'range',
				'description'     => esc_html__( 'Increase or decrease the scale of the text using the slider below.', 'et_builder' ),
				'option_category' => 'configuration',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dnxt_tilt_effect',
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
			),
			'tilt_content_margin' =>	array(
				'label'           => esc_html__('Content Margin', 'et_builder'),
				'type'            => 'custom_margin',
				'description'     => esc_html__( 'Description entered here will appear inside the module.', 'et_builder' ),
                'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dnxt_tilt_content_space',
			),
			'tilt_content_padding'=>	array(
				'label'           => esc_html__('Content Padding', 'et_builder'),
				'type'            => 'custom_padding',
				'description'     => esc_html__( 'Description entered here will appear inside the module.', 'et_builder' ),
				'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' => 'layout',
				'tab_slug'        => 'advanced',				
				'toggle_slug'     => 'dnxt_tilt_content_space',
			),
		);
	}

	public function get_advanced_fields_config() {
		$advanced_fields = array();
		$advanced_fields = array(
			'fonts'         	=> array(
				'default' 		=> array(
					'label'     => esc_html__( 'Heading', 'et_builder' ),
					'css'       => array(
						'main'  => '%%order_class%% .dnxt-txt-parallax-mini-heading',
						'hover' => '%%order_class%%:hover .dnxt-txt-parallax-mini-heading',
					),
					'font_size'   => array(
						'default' => '26px',
					),
				),
				'tilt_body'   		 => array(
					'label'          => esc_html__( 'Body', 'et_builder' ),
					'css'            => array(
						'line_height'=> "%%order_class%% .dnxt-txt-parallax-effect-3d p",
						'text_align' => "%%order_class%% .dnxt-txt-parallax-effect-3d p",
						'text_shadow'=> "%%order_class%% .dnxt-txt-parallax-effect-3d p",
					),
					'block_elements' => array(
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
						'css'               => array(
							'main' => "%%order_class%% .dnxt-txt-parallax-effect-3d",
						),
					),
				)
			),
			'box_shadow'        => array(
				'default' 		=> array(
					'css'       => array(
						'main'  => '%%order_class%% .dnxt-txt-parallax-effect',
						'hover' => '%%order_class%%:hover .dnxt-txt-parallax-effect',
					),
				),
				'dnxt_content_boxshadow'   => array(
					'label'           => esc_html__( 'Content Box Shadow', 'et_builder' ),
					'option_category' => 'layout',
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'dnxt_tilt_content_box_shadow',
					'css'             => array(
						'main'        => '%%order_class%% .dnxt-txt-parallax-effect-3d',
						'hover'       => '%%order_class%%:hover .dnxt-txt-parallax-effect-3d',
						'overlay'     => 'inset',
					),
					'default_on_fronts'  => array(
						'color'    => '',
						'position' => '',
					),
				),
			),
			'borders'               => array(
				'default' => array(
					'css'          => array(
						'main'     => array(
							'border_radii'  		=> "%%order_class%% .dnxt-txt-parallax-effect",
							'border_radii_hover'  	=> '%%order_class%%:hover .dnxt-txt-parallax-effect',
							'border_styles' 		=> "%%order_class%% .dnxt-txt-parallax-effect",
							'border_styles_hover' 	=> '%%order_class%%:hover .dnxt-txt-parallax-effect',
						),
					),
				),
				'dnxt_content_borders'     => array(
					'tab_slug'     		=> 'advanced',
					'toggle_slug'  		=> 'dnxt_tilt_content_border',
					'css'          => array(
						'main'     => array(
							'border_radii'  		=> "%%order_class%% .dnxt-txt-parallax-effect-3d",
							'border_radii_hover'  	=> '%%order_class%%:hover .dnxt-txt-parallax-effect-3d',
							'border_styles' 		=> "%%order_class%% .dnxt-txt-parallax-effect-3d",
							'border_styles_hover' 	=> '%%order_class%%:hover .dnxt-txt-parallax-effect-3d',
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
			'background'            => array(
				'settings' => array(
					'color' => 'alpha',
				),
				'css'             => array(
					'main'        => '%%order_class%% .dnxt-text-parallax-effect-image',
					'important'   => true,
				),
			),
			'margin_padding' => array(
				'css' => array(
					'main'      => '%%order_class%% .dnxt-txt-parallax-effect',
					'important' => 'all',
				),	
			),
			'text'                  => true,
		);
		return $advanced_fields;
	}

	public function render( $attrs, $content, $render_slug ) {
		wp_enqueue_script( 'dnxtblrb_divinextblurb-public' );
		$tilt_text				=	$this->props['tilt_text'];
		$heading_tag			=	$this->props['heading_tag'];
		$body_switch			=	$this->props['body_switch'];
		$tilt_body				=	$this->props['tilt_body'];
		$tilt_text_max_glare	=	$this->props['dnxt_tilt_text_max_glare'];
		$tilt_text_reverse		=	'on' === $this->props['dnxt_tilt_text_reverse'] ? 'true' : 'false';
		$tilt_text_perspective	=	$this->props['dnxt_tilt_text_perspective'];
		$tilt_text_max			=	$this->props['dnxt_tilt_text_max'];
		$tilt_text_speed		=	$this->props['dnxt_tilt_text_speed'];
		$tilt_text_startx		=	$this->props['dnxt_tilt_text_startx'];
		$tilt_text_starty		=	$this->props['dnxt_tilt_text_starty'];
		$tilt_text_scale		=	$this->props['dnxt_tilt_text_scale'];

		// Heading text
		if('' !== $tilt_text ) {
			$tilt_text = sprintf(
				'<%2$s class="dnxt-txt-parallax-mini-heading">%1$s</%2$s>',
				esc_html($tilt_text),
				$heading_tag	
			);
		}
		// Body Text
		$tilt_body_text	= '';
		if('off' !== $body_switch ) {
			$tilt_body_text = sprintf(
				'<p>%1$s</p>',
				$tilt_body
			);
		}
		// Tilt Effect
		$tilt_text_enable = 'data-tilt';
		$tilt_text_glare_enable = "";
		$tilt_text_max_glare_value = "";
		if ('off' !== $this->props['dnxt_tilt_text_glare']){
			$tilt_text_glare_enable = "data-tilt-glare";
			$tilt_text_max_glare_value = 'data-tilt-max-glare="'.intval($tilt_text_max_glare).'"';
		}
		$tilt = 'data-tilt-reverse="'.$tilt_text_reverse.'" data-tilt-perspective="'.intval($tilt_text_perspective).'" data-tilt-max="'.intval($tilt_text_max).'" data-tilt-speed="'.intval($tilt_text_speed).'" data-tilt-startX="'.intval($tilt_text_startx).'" data-tilt-startY="'.intval($tilt_text_starty).'" data-tilt-scale="'.$tilt_text_scale.'" data-tilt-gyroscope="false"';

		$this->apply_css($render_slug);
		return sprintf( 
			'<div class="dnxt-txt-parallax-effect" %3$s %4$s %5$s %6$s>
				<div class ="dnxt-text-parallax-effect-image">
					<div class="dnxt-txt-parallax-effect-3d">
						%1$s 
						%2$s
					</div>
				</div>
			</div>',
			$tilt_text,
			wpautop($tilt_body_text),
			$tilt_text_enable,
			$tilt_text_glare_enable,
			$tilt_text_max_glare_value,
			$tilt
		);
	}

	public function apply_css($render_slug){
		/**
         * Custom Padding Margin Output
         *
         */

        Common::dnxt_set_style($render_slug, $this->props, "tilt_content_margin", "%%order_class%% .dnxt-txt-parallax-effect-3d", "margin");
		Common::dnxt_set_style($render_slug, $this->props, "tilt_content_padding", "%%order_class%% .dnxt-txt-parallax-effect-3d", "padding");
		
		if ( 'off' !== $this->props['dnxt_tilt_text_3d'] ) {
			$transform_value = $this->props['dnxt_tilt_text_3d_transform'];
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt-txt-parallax-effect-3d",
				'declaration' => "transform: translateZ($transform_value);"
			));
		}

		// Tilt Content Background Color & Gradient
		$tilt_content_bg             			= '';
		$tilt_content_gradient_apply        	= '';
		$tilt_content_gradient_color_one 		= '';
		$tilt_content_gradient_color_two 		= '';
		$tilt_content_gradient_type	   			= '';
		$tilt_content_gl             			= '';
		$tilt_content_gr             			= '';
		$tilt_content_gradient_start_position	= '';
		$tilt_content_gradient_end_position  	= '';

		// Content Background color
		if ('' !== $this->props['tilt_content_bg']) {
			$tilt_content_bg = $this->props['tilt_content_bg'];
		}
		// Checking Content Background Gradient Type
		if ('' !== $this->props['tilt_content_gradient_type']) {
			$tilt_content_gradient_type = $this->props['tilt_content_gradient_type'];
		}
		// Content Linear Gradient Direction
		if ('' !== $this->props['tilt_content_gradient_type_linear_direction']) {
			$tilt_content_gl = $this->props['tilt_content_gradient_type_linear_direction'];
		}

		// Content Radial Gradient Direction
		if ('' !== $this->props['tilt_content_gradient_type_radial_direction']) {
			$tilt_content_gr = $this->props['tilt_content_gradient_type_radial_direction'];
		}
			
		// Apply Content gradient direcion
		if ('radial-gradient' === $this->props['tilt_content_gradient_type']) {
			$tilt_content_gradient_apply = sprintf('%1$s', $tilt_content_gr);
		} else if ('linear-gradient' === $this->props['tilt_content_gradient_type']) {
			$tilt_content_gradient_apply = sprintf('%1$s', $tilt_content_gl);
		}

		// Content Gradient color one for content
		if ('' !== $this->props['tilt_content_gradient_color_one']) {
			$tilt_content_gradient_color_one = $this->props['tilt_content_gradient_color_one'];
		}

		// Content Gradient color two for content 
		if ('' !== $this->props['tilt_content_gradient_color_two']) {
			$tilt_content_gradient_color_two = $this->props['tilt_content_gradient_color_two'];
		}

		// Content Gradient color start position 
		if ('' !== $this->props['tilt_content_gradient_start_position']) {
			$tilt_content_gradient_start_position = $this->props['tilt_content_gradient_start_position'];
		}

		// Content Gradient color end position
		if ('' !== $this->props['tilt_content_gradient_end_position']) {
			$tilt_content_gradient_end_position = $this->props['tilt_content_gradient_end_position'];
		}
		// Content Color
		if ('off' !== $this->props['tilt_content_bg_show_hide']){
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt-txt-parallax-effect-3d",
				'declaration' => "background: $tilt_content_bg;",
			));
		}
		// Content Gradient setting up
		if ('off' !== $this->props['tilt_content_gradient_show_hide']){
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt-txt-parallax-effect-3d",
				'declaration' => "background: {$tilt_content_gradient_type}($tilt_content_gradient_apply, $tilt_content_gradient_color_one $tilt_content_gradient_start_position, $tilt_content_gradient_color_two $tilt_content_gradient_end_position);",
			));
		}
	}
}

new NextTextTilt;
