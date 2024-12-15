<?php
include_once(DIVI_ESSENTIAL_PATH.'/includes/modules/base/Common.php');

class Next_Image_Hover_Box extends ET_Builder_Module {

	public $slug       = 'dnxte_image_hover_box';
	public $vb_support = 'on';

	protected $module_credits = array(
		'module_uri' => 'https://www.diviessential.com/divi-image-hover-box-effect/',
		'author'     => 'Divi Next',
		'author_uri' => 'www.divinext.com',
	);

	public function init() {
		$this->name 		= esc_html__( 'Next Image Hover Box', 'et_builder' );
		$this->icon_path 	= plugin_dir_path( __FILE__ ) . 'icon.svg';
		$this->folder_name 	= 'et_pb_divi_essential';

		$this->settings_modal_toggles = array(
			'general'	=> array(
				'toggles'		=>	array(
					'dnxtiep_ihb_img'	=> array(
						'title'		=> esc_html__( 'Image', 'et_builder' ),
						'priority'	=>	10,
					),
					'dnxtiep_ihb_background'	=> array(
						'title'		=>	esc_html__( 'Overlay Background', 'et_builder' ),
						'priority'	=>	30,
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
					'dnxtiep_ihb_heading_background'	=> array(
						'title'		=>	esc_html__( 'Heading Background', 'et_builder' ),
						'priority'	=>	31,
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
					'dnxtiep_ihb_caption_height'	=> array(
						'title'		=>	esc_html__( 'Caption Height', 'et_builder' ),
						'priority'	=>	32,
					),
				),
			),
			'advanced' => array(
				'toggles'     => array(
					'dnxtiep_ihb_hover_effect' => esc_html__( 'Hover Effect', 'et_builder' ),
					'dnxtiep_ihb_fonts'	=> array(
						"title"		=>	esc_html__( 'Heading Text', 'et_builder' ),
					),
					'dnxtiep_ihb_image_design' => esc_html__( 'Image Round Edge', 'et_builder')
 				)
			),
		);

		// Custom CSS Field
		$this->custom_css_fields = array(
			'dnxtiep_ihb_heading' => array(
				'label'    => esc_html__( 'Heading', 'et_builder' ),
				'selector' => '%%order_class%% .neip-ihb-heading',
			),
			'dnxtiep_ihb_description' => array(
				'label'    => esc_html__( 'Description', 'et_builder' ),
				'selector' => '%%order_class%% .neip-ihb-desc',
			)
		);
	}

	public function get_fields() {
		return array(
			// Heading Text
			'dnxtiep_ihb_heading_text'	=> array(
				'label'           	=> esc_html__( 'Heading Text', 'et_builder' ),
				'type'            	=> 'text',
				'dynamic_content' 	=> 'text',
				'option_category' 	=> 'basic_option',
				'description'     	=> esc_html__( 'Heading Text entered here will appear inside the module.', 'et_builder' ),
				'toggle_slug'     	=> 'main_content',
			),
			//Heading Tag
			'dnxtiep_ihb_heading_tag'	=> array(
				'label'           		=> esc_html__( 'Select Heading Tag', 'et_builder' ),
				'type'            		=> 'select',
				'description'     		=> esc_html__( 'Select heading tag, which you would like to use', 'et_builder' ),
				'option_category' 		=> 'basic_option',
				'toggle_slug'     		=> 'main_content',
				'options'         		=> array(
					'h1'	  	  		=> esc_html__( 'H1', 'et_builder' ),
					'h2'	  	  		=> esc_html__( 'H2', 'et_builder' ),
					'h3'	  	  		=> esc_html__( 'H3', 'et_builder' ),
					'h4'	  	  		=> esc_html__( 'H4', 'et_builder' ),
					'h5'	  	  		=> esc_html__( 'H5', 'et_builder' ),
					'h6'	  	  		=> esc_html__( 'H6', 'et_builder' ),
					'p'	      	  		=> esc_html__( 'P', 'et_builder' ),
					'span'	  	  		=> esc_html__( 'Span', 'et_builder' ),
				),
				'default'         => 'h2',
			),
			// Content
			'dnxtiep_ihb_description' 	=> array(
				'label'           	=> esc_html__( 'Content', 'et_builder' ),
				'type'            	=> 'tiny_mce',
				'dynamic_content' 	=> 'text',
				'option_category' 	=> 'basic_option',
				'description'     	=> esc_html__( 'Content entered here will appear inside the module.', 'et_builder' ),
				'toggle_slug'     	=> 'main_content',
			),
			// Image
			'dnxtiep_ihb_image'			=> array(
				'label'              	=> esc_html__( 'Image', 'et_builder' ),
				'type'               	=> 'upload',
				'option_category'    	=> 'basic_option',
				'upload_button_text' 	=> esc_attr__( 'Upload an image', 'et_builder' ),
				'choose_text'        	=> esc_attr__( 'Choose an Image', 'et_builder' ),
				'update_text'        	=> esc_attr__( 'Set As Image', 'et_builder' ),
				'description'        	=> esc_html__( 'Upload an image to display at the top of your blurb.', 'et_builder' ),
				'toggle_slug'        	=> 'dnxtiep_ihb_img',
				'dynamic_content'    	=> 'image',
				'mobile_options'	 	=> true,
				'hover'					=> 'tabs',
			),
			// Image alt
			'dnxtiep_ihb_alt'		=> array(
				'label'           	=> esc_html__( 'Image Alt Text', 'et_builder' ),
				'type'            	=> 'text',
				'option_category' 	=> 'basic_option',
				'description'     	=> esc_html__( 'Define the HTML ALT text for your image here.', 'et_builder' ),
				'toggle_slug'     	=> 'dnxtiep_ihb_img',
				'dynamic_content' 	=> 'text',
			),
			// Hover Background 
			'dnxtiep_ihb_hover_bg_show_hide'  => array(
				'label'           => esc_html__( 'Overlay Background', 'et_builder' ),
				'type'            => 'yes_no_button',                
				'toggle_slug'     => 'dnxtiep_ihb_background',
				'sub_toggle'	  => 'sub_toggle_color',
				'options'         =>  array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'affects'         => array(
					'dnxtiep_ihb_hover_bg',
				),
				'default_on_front' => 'on',
			),
			// Hover BG Color
			'dnxtiep_ihb_hover_bg'	 => array(
				'label'          => esc_html__( 'Select Background Color', 'et_builder' ),
				'type'           => 'color-alpha',
				'toggle_slug'    => 'dnxtiep_ihb_background',
				'sub_toggle'	 => 'sub_toggle_color',
				'default'        => '#a537d7',
				'depends_show_if'=> 'on',
				'mobile_options' => true,
				'responsive'	 => true,
			),
			// Heading Background 
			'dnxtiep_ihb_heading_bg_show_hide'  => array(
				'label'           => esc_html__( 'Heading Background Color', 'et_builder' ),
				'type'            => 'yes_no_button',                
				'toggle_slug'     => 'dnxtiep_ihb_heading_background',
				'sub_toggle'	  => 'sub_toggle_color',
				'options'         =>  array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'affects'         => array(
					'dnxtiep_ihb_heading_bg',
				),
				'default_on_front' => 'on',
				'show_if_not'      => array(
					'dnxtiep_ihb_image_hover_effect'  => 'effect2'
				)
			),
			// Heading BG Color
			'dnxtiep_ihb_heading_bg'	 => array(
				'label'          => esc_html__( 'Select Background Color', 'et_builder' ),
				'type'           => 'color-alpha',
				'toggle_slug'    => 'dnxtiep_ihb_heading_background',
				'sub_toggle'	 => 'sub_toggle_color',
				'default'        => '#030303',
				'depends_show_if'=> 'on',
				'mobile_options' => true,
				'responsive'	 => true,
				'show_if_not'      => array(
					'dnxtiep_ihb_image_hover_effect'  => 'effect2'
				)
			),
			// Hover Background Gradient 
			'dnxtiep_ihb_hover_gradient_show_hide'  => array(
				'label'           => esc_html__( 'Overlay Gradient Color', 'et_builder' ),
				'type'            => 'yes_no_button',                
				'toggle_slug'     => 'dnxtiep_ihb_background',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'options'             => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'affects'         => array(
					'dnxtiep_ihb_hover_gradient_color_one',
					'dnxtiep_ihb_hover_gradient_color_two',
					'dnxtiep_ihb_hover_gradient_type',
					'dnxtiep_ihb_hover_gradient_start_position',
					'dnxtiep_ihb_hover_gradient_end_position'
				),
				'default_on_front' => 'off',
			),
			'dnxtiep_ihb_hover_gradient_color_one'	=> array(
				'label'          => esc_html__('Select Color One', 'et_builder' ),
				'type'           => 'color-alpha',
				'toggle_slug'    => 'dnxtiep_ihb_background',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'default'        => '#2b87da',
				'depends_show_if'=> 'on',
			),
			'dnxtiep_ihb_hover_gradient_color_two'	=> array(
				'label'          => esc_html__('Select Color Two', 'et_builder' ),
				'type'           => 'color-alpha',
				'toggle_slug'    => 'dnxtiep_ihb_background',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'default'        => '#29c4a9',
				'depends_show_if'=> 'on',
			),
			'dnxtiep_ihb_hover_gradient_type'		=> array(
				'label'           => esc_html__( 'Select Gradient Type', 'et_builder' ),
				'type'            => 'select',
				'description'     => esc_html__( 'Select the types of gradient', 'et_builder' ),
				'option_category' => 'basic_option',
				'toggle_slug'     => 'dnxtiep_ihb_background',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'options'         => array(
					'linear-gradient' => esc_html__( 'Linear', 'et_builder' ),
					'radial-gradient' => esc_html__( 'Radial', 'et_builder' ),
				),
				'default'         => 'linear-gradient',
				'depends_show_if' => 'on',
			),
			'dnxtiep_ihb_hover_gradient_type_linear_direction'   => array(
				'label'           => esc_html__( 'Linear direction', 'et_builder' ),
				'type'            => 'range',
				'option_category'=> 'basic_option',
				'toggle_slug'    => 'dnxtiep_ihb_background',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'range_settings'  => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 360,
				),
				'default'         => '180deg',
				'fixed_unit'      => 'deg',
				'show_if' => array(
					'dnxtiep_ihb_hover_gradient_show_hide'	=> 'on',
					'dnxtiep_ihb_hover_gradient_type' 		=> 'linear-gradient'
				),
			),
			'dnxtiep_ihb_hover_gradient_type_radial_direction'   => array(
				'label'           	=> esc_html__( 'Radial Direction', 'et_builder'),
				'type'            	=> 'select',
				'description'     	=> esc_html__( 'Select the types of gradient', 'et_builder'),                
				'option_category'	=> 'basic_option',
				'toggle_slug'    	=> 'dnxtiep_ihb_background',
				'sub_toggle'	 	=> 'sub_toggle_gradient',
				'options'       	=> array(
					'circle at center'       => esc_html__(	'Center', 'et_builder' ),
					'circle at left'         => esc_html__(	'Top Left', 'et_builder' ),
					'circle at top'          => esc_html__(	'Top',	'et_builder' ),
					'circle at top right'    => esc_html__(	'Top Right', 'et_builder' ),
					'circle at right'        => esc_html__(	'Right', 'et_builder' ),
					'circle at bottom right' => esc_html__(	'Bottom Right', 'et_builder' ),
					'circle at bottom'       => esc_html__(	'Bottom', 'et_builder' ),
					'circle at bottom left'  => esc_html__(	'Bottom Left', 'et_builder' ),
					'circle at left'         => esc_html__(	'Left', 'et_builder' ),

				),
				'default'         => 'circle at center',
				'show_if'         => array(
					'dnxtiep_ihb_hover_gradient_show_hide'	=> 'on',
					'dnxtiep_ihb_hover_gradient_type'		=> 'radial-gradient'
				),
			),
			'dnxtiep_ihb_hover_gradient_start_position'           => array(
				'label'           => esc_html__( 'Start Position', 'et_builder' ),
				'type'            => 'range',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'dnxtiep_ihb_background',
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
			'dnxtiep_ihb_hover_gradient_end_position'             => array(
				'label'           => esc_html__( 'End Position', 'et_builder' ),
				'type'            => 'range',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'dnxtiep_ihb_background',
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
			// heading Background Gradient 
			'dnxtiep_ihb_heading_gradient_show_hide'  => array(
				'label'           => esc_html__( 'Heading Gradient Color', 'et_builder' ),
				'type'            => 'yes_no_button',                
				'toggle_slug'     => 'dnxtiep_ihb_heading_background',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'options'             => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'affects'         => array(
					'dnxtiep_ihb_heading_gradient_color_one',
					'dnxtiep_ihb_heading_gradient_color_two',
					'dnxtiep_ihb_heading_gradient_type',
					'dnxtiep_ihb_heading_gradient_start_position',
					'dnxtiep_ihb_heading_gradient_end_position'
				),
				'default_on_front' => 'off',
				'show_if_not'      => array(
					'dnxtiep_ihb_image_hover_effect'  => 'effect2'
				)
			),
			'dnxtiep_ihb_heading_gradient_color_one'	=> array(
				'label'          => esc_html__('Select Color One', 'et_builder' ),
				'type'           => 'color-alpha',
				'toggle_slug'    => 'dnxtiep_ihb_heading_background',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'default'        => '#2b87da',
				'depends_show_if'=> 'on',
				'show_if_not'      => array(
					'dnxtiep_ihb_image_hover_effect'  => 'effect2'
				)
			),
			'dnxtiep_ihb_heading_gradient_color_two'	=> array(
				'label'          => esc_html__('Select Color Two', 'et_builder' ),
				'type'           => 'color-alpha',
				'toggle_slug'    => 'dnxtiep_ihb_heading_background',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'default'        => '#29c4a9',
				'depends_show_if'=> 'on',
				'show_if_not'      => array(
					'dnxtiep_ihb_image_hover_effect'  => 'effect2'
				)
			),
			'dnxtiep_ihb_heading_gradient_type'		=> array(
				'label'           => esc_html__( 'Select Gradient Type', 'et_builder' ),
				'type'            => 'select',
				'description'     => esc_html__( 'Select the types of gradient', 'et_builder' ),
				'option_category' => 'basic_option',
				'toggle_slug'     => 'dnxtiep_ihb_heading_background',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'options'         => array(
					'linear-gradient' => esc_html__( 'Linear', 'et_builder' ),
					'radial-gradient' => esc_html__( 'Radial', 'et_builder' ),
				),
				'default'         => 'linear-gradient',
				'depends_show_if' => 'on',
				'show_if_not'      => array(
					'dnxtiep_ihb_image_hover_effect'  => 'effect2'
				)
			),
			'dnxtiep_ihb_heading_gradient_type_linear_direction'   => array(
				'label'           => esc_html__( 'Linear direction', 'et_builder' ),
				'type'            => 'range',
				'option_category'=> 'basic_option',
				'toggle_slug'    => 'dnxtiep_ihb_heading_background',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'range_settings'  => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 360,
				),
				'default'         => '180deg',
				'fixed_unit'      => 'deg',
				'show_if' => array(
					'dnxtiep_ihb_heading_gradient_show_hide'	=> 'on',
					'dnxtiep_ihb_heading_gradient_type' 		=> 'linear-gradient'
				),
				'show_if_not'      => array(
					'dnxtiep_ihb_image_hover_effect'  => 'effect2'
				)
			),
			'dnxtiep_ihb_heading_gradient_type_radial_direction'   => array(
				'label'           	=> esc_html__( 'Radial Direction', 'et_builder'),
				'type'            	=> 'select',
				'description'     	=> esc_html__( 'Select the types of gradient', 'et_builder'),                
				'option_category'	=> 'basic_option',
				'toggle_slug'    	=> 'dnxtiep_ihb_heading_background',
				'sub_toggle'	 	=> 'sub_toggle_gradient',
				'options'       	=> array(
					'circle at center'       => esc_html__(	'Center', 'et_builder' ),
					'circle at left'         => esc_html__(	'Top Left', 'et_builder' ),
					'circle at top'          => esc_html__(	'Top',	'et_builder' ),
					'circle at top right'    => esc_html__(	'Top Right', 'et_builder' ),
					'circle at right'        => esc_html__(	'Right', 'et_builder' ),
					'circle at bottom right' => esc_html__(	'Bottom Right', 'et_builder' ),
					'circle at bottom'       => esc_html__(	'Bottom', 'et_builder' ),
					'circle at bottom left'  => esc_html__(	'Bottom Left', 'et_builder' ),
					'circle at left'         => esc_html__(	'Left', 'et_builder' ),

				),
				'default'         => 'circle at center',
				'show_if'         => array(
					'dnxtiep_ihb_heading_gradient_show_hide'	=> 'on',
					'dnxtiep_ihb_heading_gradient_type'		=> 'radial-gradient'
				),
				'show_if_not'      => array(
					'dnxtiep_ihb_image_hover_effect'  => 'effect2'
				)
			),
			'dnxtiep_ihb_heading_gradient_start_position'           => array(
				'label'           => esc_html__( 'Start Position', 'et_builder' ),
				'type'            => 'range',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'dnxtiep_ihb_heading_background',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'range_settings'  => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 100,
				),
				'default'         => '0%',
				'fixed_unit'      => '%',
				'depends_show_if' => 'on',
				'show_if_not'      => array(
					'dnxtiep_ihb_image_hover_effect'  => 'effect2'
				)
			),
			'dnxtiep_ihb_heading_gradient_end_position'             => array(
				'label'           => esc_html__( 'End Position', 'et_builder' ),
				'type'            => 'range',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'dnxtiep_ihb_heading_background',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'range_settings'  => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 100,
				),
				'default'         => '100%',
				'fixed_unit'      => '%',
				'depends_show_if' => 'on',
				'show_if_not'      => array(
					'dnxtiep_ihb_image_hover_effect'  => 'effect2'
				)
			),
			'dnxtiep_ihb_image_hover_effect'=> array(
				'label'             	=> esc_html__( 'Select Image Hover', 'et_builder' ),
				'type'              	=> 'select',
				'option_category'   	=> 'configuration',
				'tab_slug'          	=> 'advanced',
				'toggle_slug'       	=> 'dnxtiep_ihb_hover_effect',
				'description'           => esc_html__( 'Here you can adjust the hover effect.', 'et_builder' ),
				'options'               => array(
					'effect1'   				=>  esc_html__( 'Effect 1', 'et_builder' ),
					'effect2'   				=>  esc_html__( 'Effect 2', 'et_builder' ),
					'effect3'   				=>  esc_html__( 'Effect 3', 'et_builder' ),
					'effect4'   				=>  esc_html__( 'Effect 4', 'et_builder' ),
					'effect5'   				=>  esc_html__( 'Effect 5', 'et_builder' ),
					'effect6'   				=>  esc_html__( 'Effect 6', 'et_builder' ),
					'effect7'   				=>  esc_html__( 'Effect 7', 'et_builder' ),
					'effect8'   				=>  esc_html__( 'Effect 8', 'et_builder' ),
					'effect9'   				=>  esc_html__( 'Effect 9', 'et_builder' ),
					'effect10'   				=>  esc_html__( 'Effect 10', 'et_builder' ),
					'effect11'   				=>  esc_html__( 'Effect 11', 'et_builder' ),
					'effect12'   				=>  esc_html__( 'Effect 12', 'et_builder' ),
					'effect13'   				=>  esc_html__( 'Effect 13', 'et_builder' ),
				),
				'default'               => 'effect1'
			),
			'dnxtiep_ihb_image_hover_direction1'  => array(
				'label'             	=> esc_html__( 'Select Image Hover Direction', 'et_builder' ),
				'type'              	=> 'select',
				'option_category'   	=> 'configuration',
				'tab_slug'          	=> 'advanced',
				'toggle_slug'       	=> 'dnxtiep_ihb_hover_effect',
				'description'           => esc_html__( 'Here you can adjust the hover effect direction.', 'et_builder' ),
				'show_if'               => array(
					'dnxtiep_ihb_image_hover_effect' => array('effect2'),
				),
				'options'               => array(
					'top_to_bottom'   	 			=>  esc_html__( 'Top to Bottom', 'et_builder' ),
					'bottom_to_top'   				=>  esc_html__( 'Bottom to Top', 'et_builder' ),
				),
				'default' => 'top_to_bottom'
			),
			'dnxtiep_ihb_image_hover_direction2'  => array(
				'label'             	=> esc_html__( 'Select Image Hover Direction', 'et_builder' ),
				'type'              	=> 'select',
				'option_category'   	=> 'configuration',
				'tab_slug'          	=> 'advanced',
				'toggle_slug'       	=> 'dnxtiep_ihb_hover_effect',
				'description'           => esc_html__( 'Here you can adjust the hover effect direction.', 'et_builder' ),
				'show_if'               => array(
					'dnxtiep_ihb_image_hover_effect' => array('effect3'),
				),
				'options'               => array(
					'left_to_right'   	 			=>  esc_html__( 'Left to Right', 'et_builder' ),
					'right_to_left'   	 			=>  esc_html__( 'Right to Left', 'et_builder' ),
				),
				'default' => 'left_to_right'
			),
			'dnxtiep_ihb_image_hover_direction3'  => array(
				'label'             	=> esc_html__( 'Select Image Hover Direction', 'et_builder' ),
				'type'              	=> 'select',
				'option_category'   	=> 'configuration',
				'tab_slug'          	=> 'advanced',
				'toggle_slug'       	=> 'dnxtiep_ihb_hover_effect',
				'description'           => esc_html__( 'Here you can adjust the hover effect direction.', 'et_builder' ),
				'show_if'               => array(
					'dnxtiep_ihb_image_hover_effect' => array('effect4'),
				),
				'options'               => array(
					'from_top_and_bottom'   	 			=>  esc_html__( 'From Top and Bottom', 'et_builder' ),
					'from_left_and_right'   	 			=>  esc_html__( 'From Left and Right', 'et_builder' ),
					'top_to_bottom'   	 			=>  esc_html__( 'Top to Bottom', 'et_builder' ),
					'bottom_to_top'   	 			=>  esc_html__( 'Bottom to Top', 'et_builder' ),
				),
				'default' => 'from_top_and_bottom'
			),
			'dnxtiep_ihb_image_hover_direction4'  => array(
				'label'             	=> esc_html__( 'Select Image Hover Direction', 'et_builder' ),
				'type'              	=> 'select',
				'option_category'   	=> 'configuration',
				'tab_slug'          	=> 'advanced',
				'toggle_slug'       	=> 'dnxtiep_ihb_hover_effect',
				'description'           => esc_html__( 'Here you can adjust the hover effect direction.', 'et_builder' ),
				'show_if'               => array(
					'dnxtiep_ihb_image_hover_effect' => array('effect6'),
				),
				'options'               => array(
					'scale_up'   		=>  esc_html__( 'Scale Up', 'et_builder' ),
					'scale_down'   		=>  esc_html__( 'Scale Down', 'et_builder' ),
					'scale_down_up'   	=>  esc_html__( 'Scale Down Up', 'et_builder' )
				),
				'default' => 'scale_up'
			),
			'dnxtiep_ihb_image_hover_direction5'  => array(
				'label'             	=> esc_html__( 'Select Image Hover Direction', 'et_builder' ),
				'type'              	=> 'select',
				'option_category'   	=> 'configuration',
				'tab_slug'          	=> 'advanced',
				'toggle_slug'       	=> 'dnxtiep_ihb_hover_effect',
				'description'           => esc_html__( 'Here you can adjust the hover effect direction.', 'et_builder' ),
				'show_if'               => array(
					'dnxtiep_ihb_image_hover_effect' => array(
						'effect7',
						'effect8',
						'effect9',
						'effect10',
						'effect11',
						'effect12',
						'effect13',
					),
				),
				'options'               => array(
					'left_to_right'   	 			=>  esc_html__( 'Left to Right', 'et_builder' ),
					'right_to_left'   	 			=>  esc_html__( 'Right to Left', 'et_builder' ),
					'top_to_bottom'   	 			=>  esc_html__( 'Top to Bottom', 'et_builder' ),
					'bottom_to_top'   				=>  esc_html__( 'Bottom to Top', 'et_builder' ),
				),
				'default' => 'left_to_right'
			),

			'dnxtiep_ihb_heading_margin'	=> array(
				'label'           		=> esc_html__('Heading Margin', 'et_builder'),
                'type'            		=> 'custom_margin',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding', 
			),
			'dnxtiep_ihb_heading_padding'	=> array(
				'label'           		=> esc_html__('Heading Padding', 'et_builder'),
				'type'            		=> 'custom_padding',
				'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
				'tab_slug'        		=> 'advanced',				
				'toggle_slug'     		=> 'margin_padding',
			),
			'dnxtiep_ihb_description_margin'	=> array(
				'label'           			=> esc_html__('Description Margin', 'et_builder'),
                'type'            			=> 'custom_margin',
                'mobile_options'  			=> true,
				'hover'           			=> 'tabs',
				'allowed_units'   			=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 			=> 'layout',
                'tab_slug'        			=> 'advanced',
				'toggle_slug'     			=> 'margin_padding', 
			),
			'dnxtiep_ihb_description_padding'	=> array(
				'label'           			=> esc_html__('Description Padding', 'et_builder'),
				'type'            			=> 'custom_padding',
				'mobile_options'  			=> true,
				'hover'           			=> 'tabs',
				'allowed_units'   			=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 			=> 'layout',
				'tab_slug'        			=> 'advanced',				
				'toggle_slug'     			=> 'margin_padding',
			),
			'dnxtiep_ihb_cap_height'           => array(
				'label'           => esc_html__( 'Caption height', 'et_builder' ),
				'type'            => 'range',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'dnxtiep_ihb_caption_height',
				'range_settings'  => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 1000,
				),
				'default'         => '65px',
				'fixed_unit'      => 'px',
				'show_if'         => array(
					'dnxtiep_ihb_image_hover_effect' => "effect2"
				),
				'mobile_options'  => true,
			),
		);
	}


	public function get_advanced_fields_config() {
		return array(
			'background' => array(
				'css' => array(
					'main' => '%%order_class%% .dnext-neip-ihb'
				)
			),
			'fonts' => array(
				'hover_text_fonts' => array(
					'label'    		=> esc_html__( '', 'et_builder' ),
					'toggle_slug'   => 'dnxtiep_ihb_fonts',
					'tab_slug'		=> 'advanced',
					'css'      => array(
						'main' => "%%order_class%% .neip-ihb-heading",
						'important' => 'all'
					),
				),
				'dnxtiep_ihb_body'   => array(
					'label'          => esc_html__( 'Description', 'et_builder' ),
					'css'            => array(
						'main'     => "%%order_class%% .neip-ihb-desc",
						'important' => 'all'
					)
				)
			),
			'text' => false,
			'margin_padding' => array(
				'css' => array(
					'margin' => "%%order_class%% .dnext-neip-ihb",
					'padding' => "%%order_class%% .dnext-neip-ihb",
					'important' => 'all',
				),
			),
			'borders'               => array(
				'default' => array(
					'css'	=> array(
						'main'	=> array(
							'border_radii'  => "%%order_class%% .dnext-neip-ihb",
							'border_styles' => "%%order_class%% .dnext-neip-ihb",
						),
						'important' => 'all'
					),
					'defaults'        => array(
						'border_radii'  => 'on|3px|3px|3px|3px',
						'border_styles' => array(
							'width' => '0px',
							'color' => '#0077FF',
							'style' => 'solid',
						),
					),
				)
			),
			'box_shadow'	=> array(
				'default' => array(
					'css'             => array(
						'main'        => "%%order_class%% .dnext-neip-ihb",
					),
				),
			),
			'height'	=> false
		);		
	}

	public function render( $attrs, $content, $render_slug ) {

		$multi_view 						= et_pb_multi_view_options( $this );
		$dnxtiep_ihb_image					=	$this->props['dnxtiep_ihb_image'];
		$dnxtiep_ihb_alt					=	$this->props['dnxtiep_ihb_alt'];

		$dnxtiep_ihb_heading_text			=	$this->props['dnxtiep_ihb_heading_text'];
		$dnxtiep_ihb_heading_tag			=	$this->props['dnxtiep_ihb_heading_tag'];
		$dnxtiep_ihb_description			=	$this->props['dnxtiep_ihb_description'];

		$dnxtiep_ihb_hover_effect       	=   $this->props['dnxtiep_ihb_image_hover_effect'];

		$dnxtiep_ihb_direction_class = "";

		$dnxtiep_ihb_effect1 = 'effect2';
		$dnxtiep_ihb_effect2 = 'effect3';
		$dnxtiep_ihb_effect3 = 'effect4';
		$dnxtiep_ihb_effect4 = 'effect6';
		$dnxtiep_ihb_effect5 = array(
			'effect7',
			'effect8',
			'effect9',
			'effect10',
			'effect11',
			'effect12',
			'effect13',
		);	
		if( $dnxtiep_ihb_effect1 === $dnxtiep_ihb_hover_effect ) {
			$dnxtiep_ihb_direction_class = "neip-ihb-".$this->props['dnxtiep_ihb_image_hover_direction1'];
		}
		if( $dnxtiep_ihb_effect2 === $dnxtiep_ihb_hover_effect ) {
			$dnxtiep_ihb_direction_class = "neip-ihb-".$this->props['dnxtiep_ihb_image_hover_direction2'];
		}
		if( $dnxtiep_ihb_effect3 === $dnxtiep_ihb_hover_effect ) {
			$dnxtiep_ihb_direction_class = "neip-ihb-".$this->props['dnxtiep_ihb_image_hover_direction3'];
		}
		if( $dnxtiep_ihb_effect4 === $dnxtiep_ihb_hover_effect ) {
			$dnxtiep_ihb_direction_class = "neip-ihb-".$this->props['dnxtiep_ihb_image_hover_direction4'];
		}
		if( in_array($dnxtiep_ihb_hover_effect, $dnxtiep_ihb_effect5) ) {
			$dnxtiep_ihb_direction_class = "neip-ihb-".$this->props['dnxtiep_ihb_image_hover_direction5'];
		}


		$dnxtiep_ihb_img_pathinfo 	= pathinfo( $dnxtiep_ihb_image );
		$is_dnxtiep_ihb_img_svg 	= isset( $dnxtiep_ihb_img_pathinfo['extension'] ) ? 'svg' === $dnxtiep_ihb_img_pathinfo['extension'] : false;
		
		$image_html = $multi_view->render_element( array(
			'tag'   => 'img',
			'attrs' => array(
				'src'   => '{{dnxtiep_ihb_image}}',
				'alt'   => '{{dnxtiep_ihb_alt}}',
			),
			'required' => 'dnxtiep_ihb_image',
		) );

		// Image
		$dnxtiep_ihb_img = sprintf(
			'<div class="neip-ihb-img">%1$s</div>',
			$image_html
		);
		

		// Heading Text
		$dnxtiepheadingtext = '';
		if ( '' !== $dnxtiep_ihb_heading_text ){
			$dnxtiepheadingtext = sprintf(
				'<%1$s class="neip-ihb-heading">%2$s</%1$s>',
				et_pb_process_header_level( $dnxtiep_ihb_heading_tag, 'span' ),
				et_core_esc_previously( $dnxtiep_ihb_heading_text )
			);
		}

		$description = $multi_view->render_element( array(
			'tag' => 'div',
			'content' => '{{dnxtiep_ihb_description}}',
			'attrs' => array(
			'class' => 'neip-ihb-desc',
			)
			));

		$content = "";

		if( $dnxtiep_ihb_hover_effect == "effect7" ) {
			$content = sprintf(
				'<div class="neip-ihb-info">
	                <div class="neip-ihb-info-back">
	                    %1$s
	                    %2$s
	                </div>
	            </div>',
	            $dnxtiepheadingtext,
	            $description
			);
		}else{
			$content = sprintf(
				'<div class="neip-ihb-info">
	                %1$s
	                %2$s
	            </div>',
	            $dnxtiepheadingtext,
	            $description
			);
		}


		// Hover BG Color
		$dnxtiep_ihb_hover_bg_color			= $this->props['dnxtiep_ihb_hover_bg'];
		$dnxtiep_ihb_hover_bg_color_values	= et_pb_responsive_options()->get_property_values( $this->props, 'dnxtiep_ihb_hover_bg' );
		$dnxtiep_ihb_hover_bg_color_tablet	= isset( $dnxtiep_ihb_hover_bg_color_values['tablet'] ) ? $dnxtiep_ihb_hover_bg_color_values['tablet'] : '';
		$dnxtiep_ihb_hover_bg_color_phone	= isset( $dnxtiep_ihb_hover_bg_color_values['phone'] ) ? $dnxtiep_ihb_hover_bg_color_values['phone'] : '';

		// Ovelay background color
		if ( 'off' !== $this->props['dnxtiep_ihb_hover_bg_show_hide'] ) {
			$dnxtiep_ihb_hover_bg_color_style 		 = sprintf( 'background: %1$s;', esc_attr( $dnxtiep_ihb_hover_bg_color ) );
			$dnxtiep_ihb_hover_bg_color_tablet_style = '' !== $dnxtiep_ihb_hover_bg_color_tablet ? sprintf( 'background: %1$s;', esc_attr( $dnxtiep_ihb_hover_bg_color_tablet ) ) : '';
			$dnxtiep_ihb_hover_bg_color_phone_style  = '' !== $dnxtiep_ihb_hover_bg_color_phone ? sprintf( 'background: %1$s;', esc_attr( $dnxtiep_ihb_hover_bg_color_phone ) ) : '';
			

				if( $dnxtiep_ihb_hover_effect === "effect7" ){
					ET_Builder_Element::set_style( $render_slug, array(
						'selector'    => "%%order_class%% .dnext-neip-ihb.neip-ihb-{$dnxtiep_ihb_hover_effect} .neip-ihb-info .neip-ihb-info-back",
						'declaration' => $dnxtiep_ihb_hover_bg_color_style,
					) );

					ET_Builder_Element::set_style( $render_slug, array(
						'selector'    => "%%order_class%% .dnext-neip-ihb.neip-ihb-{$dnxtiep_ihb_hover_effect} .neip-ihb-info .neip-ihb-info-back",
						'declaration' => $dnxtiep_ihb_hover_bg_color_tablet_style,
						'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
					) );

					ET_Builder_Element::set_style( $render_slug, array(
						'selector'    => "%%order_class%% .dnext-neip-ihb.neip-ihb-{$dnxtiep_ihb_hover_effect} .neip-ihb-info .neip-ihb-info-back",
						'declaration' => $dnxtiep_ihb_hover_bg_color_phone_style,
						'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
					) );
				}else{
					ET_Builder_Element::set_style( $render_slug, array(
						'selector'    => "%%order_class%% .dnext-neip-ihb.neip-ihb-{$dnxtiep_ihb_hover_effect} .neip-ihb-info",
						'declaration' => $dnxtiep_ihb_hover_bg_color_style,
					) );

					ET_Builder_Element::set_style( $render_slug, array(
						'selector'    => "%%order_class%% .dnext-neip-ihb.neip-ihb-{$dnxtiep_ihb_hover_effect} .neip-ihb-info",
						'declaration' => $dnxtiep_ihb_hover_bg_color_tablet_style,
						'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
					) );

					ET_Builder_Element::set_style( $render_slug, array(
						'selector'    => "%%order_class%% .dnext-neip-ihb.neip-ihb-{$dnxtiep_ihb_hover_effect} .neip-ihb-info",
						'declaration' => $dnxtiep_ihb_hover_bg_color_phone_style,
						'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
					) );
				}

		}

		// Heading BG Color
		$dnxtiep_ihb_heading_bg_color			= $this->props['dnxtiep_ihb_heading_bg'];
		$dnxtiep_ihb_heading_bg_color_values	= et_pb_responsive_options()->get_property_values( $this->props, 'dnxtiep_ihb_heading_bg' );
		$dnxtiep_ihb_heading_bg_color_tablet	= isset( $dnxtiep_ihb_heading_bg_color_values['tablet'] ) ? $dnxtiep_ihb_heading_bg_color_values['tablet'] : '';
		$dnxtiep_ihb_heading_bg_color_phone	= isset( $dnxtiep_ihb_heading_bg_color_values['phone'] ) ? $dnxtiep_ihb_heading_bg_color_values['phone'] : '';


		if( 'off' !== $this->props['dnxtiep_ihb_heading_bg_show_hide'] ) {
			$dnxtiep_ihb_heading_bg_color_style 		 = sprintf( 'background: %1$s;', esc_attr( $dnxtiep_ihb_heading_bg_color ) );
			$dnxtiep_ihb_heading_bg_color_tablet_style = '' !== $dnxtiep_ihb_heading_bg_color_tablet ? sprintf( 'background: %1$s;', esc_attr( $dnxtiep_ihb_heading_bg_color_tablet ) ) : '';
			$dnxtiep_ihb_heading_bg_color_phone_style  = '' !== $dnxtiep_ihb_heading_bg_color_phone ? sprintf( 'background: %1$s;', esc_attr( $dnxtiep_ihb_heading_bg_color_phone ) ) : '';


			if( $dnxtiep_ihb_hover_effect !== 'effect2' ) {
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => "%%order_class%% .dnext-neip-ihb.neip-ihb-{$dnxtiep_ihb_hover_effect} .neip-ihb-info .neip-ihb-heading",
					'declaration' => $dnxtiep_ihb_heading_bg_color_style,
				) );

				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => "%%order_class%% .dnext-neip-ihb.neip-ihb-{$dnxtiep_ihb_hover_effect} .neip-ihb-info .neip-ihb-heading",
					'declaration' => $dnxtiep_ihb_heading_bg_color_tablet_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
				) );

				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => "%%order_class%% .dnext-neip-ihb.neip-ihb-{$dnxtiep_ihb_hover_effect} .neip-ihb-info .neip-ihb-heading",
					'declaration' => $dnxtiep_ihb_heading_bg_color_phone_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				) );
			}
		}

		//GRADIENT COLOR 
			$dnxtiep_ihb_hover_gradient_color_one = $this->props['dnxtiep_ihb_hover_gradient_color_one'];
			$dnxtiep_ihb_hover_gradient_color_two = $this->props['dnxtiep_ihb_hover_gradient_color_two'];
			// Other gradient options
			$dnxtiep_ihb_hover_gradient_type = $this->props['dnxtiep_ihb_hover_gradient_type'];
			$dnxtiep_ihb_hover_gradient_start = $this->props['dnxtiep_ihb_hover_gradient_start_position'];
			$dnxtiep_ihb_hover_gradient_end = $this->props['dnxtiep_ihb_hover_gradient_end_position'];

			$dnxtiep_ihb_hover_gradient_direction = $dnxtiep_ihb_hover_gradient_type === 'linear-gradient' ? $this->props['dnxtiep_ihb_hover_gradient_type_linear_direction'] : $this->props['dnxtiep_ihb_hover_gradient_type_radial_direction'];


			if('off' !== $this->props['dnxtiep_ihb_hover_gradient_show_hide']) {
				$dnxtiep_ihb_hover_bg_gradient = sprintf('background: %1$s(%2$s, %3$s %5$s, %4$s %6$s);', $dnxtiep_ihb_hover_gradient_type, $dnxtiep_ihb_hover_gradient_direction, esc_attr($dnxtiep_ihb_hover_gradient_color_one), esc_attr($dnxtiep_ihb_hover_gradient_color_two), $dnxtiep_ihb_hover_gradient_start, $dnxtiep_ihb_hover_gradient_end);

				if( $dnxtiep_ihb_hover_effect === "effect7" ) {
					ET_Builder_Element::set_style( $render_slug, array(
						'selector'    => "%%order_class%% .dnext-neip-ihb.neip-ihb-{$dnxtiep_ihb_hover_effect} .neip-ihb-info .neip-ihb-info-back",
						'declaration' => $dnxtiep_ihb_hover_bg_gradient,
					) );
				} else {
					ET_Builder_Element::set_style( $render_slug, array(
						'selector'    => "%%order_class%% .dnext-neip-ihb.neip-ihb-{$dnxtiep_ihb_hover_effect} .neip-ihb-info",
						'declaration' => $dnxtiep_ihb_hover_bg_gradient,
					) );
				}
			}
			// Gradient hover bg end


			// Heading gradient color
			$dnxtiep_ihb_heading_gradient_color_one = $this->props['dnxtiep_ihb_heading_gradient_color_one'];
			$dnxtiep_ihb_heading_gradient_color_two = $this->props['dnxtiep_ihb_heading_gradient_color_two'];
			// Other gradient options
			$dnxtiep_ihb_heading_gradient_type = $this->props['dnxtiep_ihb_heading_gradient_type'];
			$dnxtiep_ihb_heading_gradient_start = $this->props['dnxtiep_ihb_heading_gradient_start_position'];
			$dnxtiep_ihb_heading_gradient_end = $this->props['dnxtiep_ihb_heading_gradient_end_position'];

			$dnxtiep_ihb_heading_gradient_direction = $dnxtiep_ihb_heading_gradient_type === 'linear-gradient' ? $this->props['dnxtiep_ihb_heading_gradient_type_linear_direction'] : $this->props['dnxtiep_ihb_heading_gradient_type_radial_direction'];


			if('off' !== $this->props['dnxtiep_ihb_heading_gradient_show_hide']) {
				$dnxtiep_ihb_heading_bg_gradient = sprintf('background: %1$s(%2$s, %3$s %5$s, %4$s %6$s)', $dnxtiep_ihb_heading_gradient_type, $dnxtiep_ihb_heading_gradient_direction, esc_attr($dnxtiep_ihb_heading_gradient_color_one), esc_attr($dnxtiep_ihb_heading_gradient_color_two), $dnxtiep_ihb_heading_gradient_start, $dnxtiep_ihb_heading_gradient_end);

				if( $dnxtiep_ihb_hover_effect !== "effect2" ) {
					ET_Builder_Element::set_style( $render_slug, array(
						'selector'    => "%%order_class%% .dnext-neip-ihb.neip-ihb-{$dnxtiep_ihb_hover_effect} .neip-ihb-info .neip-ihb-heading",
						'declaration' => $dnxtiep_ihb_heading_bg_gradient,
					) );
				}
			}

			// Caption height 
			$dnxtiep_ihb_caption_height = $this->props['dnxtiep_ihb_cap_height'];
			$dnxtiep_ihb_caption_height_values	= et_pb_responsive_options()->get_property_values( $this->props, 'dnxtiep_ihb_cap_height' );

			$dnxtiep_ihb_caption_height_tablet 	     = isset( $dnxtiep_ihb_caption_height_values['tablet'] ) ? $dnxtiep_ihb_caption_height_values['tablet'] : '';
			$dnxtiep_ihb_caption_height_phone	= isset( $dnxtiep_ihb_caption_height_values['phone'] ) ? $dnxtiep_ihb_caption_height_values['phone'] : '';

			$dnxtiep_ihb_caption_height_style		 = sprintf( 'height: %1$s', $dnxtiep_ihb_caption_height );

			$dnxtiep_ihb_caption_height_tablet_style = '' !== $dnxtiep_ihb_caption_height_tablet ? sprintf( 'height: %1$s;', esc_attr( $dnxtiep_ihb_caption_height_tablet ) ) : '';
			$dnxtiep_ihb_caption_height_phone_style  = '' !== $dnxtiep_ihb_caption_height_phone ? sprintf( 'height: %1$s;', esc_attr( $dnxtiep_ihb_caption_height_phone ) ) : '';

			if( $dnxtiep_ihb_hover_effect === 'effect2' ){
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => "%%order_class%% .dnext-neip-ihb.neip-ihb-effect2 .neip-ihb-info",
					'declaration' => $dnxtiep_ihb_caption_height_style,
				) );

				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => "%%order_class%% .dnext-neip-ihb.neip-ihb-effect2 .neip-ihb-info",
					'declaration' => $dnxtiep_ihb_caption_height_tablet_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
				) );

				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => "%%order_class%% .dnext-neip-ihb.neip-ihb-effect2 .neip-ihb-info",
					'declaration' => $dnxtiep_ihb_caption_height_phone_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				) );
			}

		$this->apply_css($render_slug);
		return sprintf(
			'<div class="dnext-neip-ihb neip-ihb-%3$s %4$s">
		        <div class="dnext-neip-ihb-hvr">
		          %1$s
		          %2$s
		        </div>
		     </div>',
		     $dnxtiep_ihb_img,
		     $content,
		     $dnxtiep_ihb_hover_effect,
		     $dnxtiep_ihb_direction_class
		);
	}

	public function apply_css($render_slug){


			/**
	         * Custom Padding Margin Output
	         *
	        */
			Common::dnxt_set_style($render_slug, $this->props, "dnxtiep_ihb_heading_margin", "%%order_class%% .neip-ihb-info .neip-ihb-heading", "margin");
	        Common::dnxt_set_style($render_slug, $this->props, "dnxtiep_ihb_heading_padding", "%%order_class%% .neip-ihb-info .neip-ihb-heading", "padding");

			Common::dnxt_set_style($render_slug, $this->props, "dnxtiep_ihb_description_margin", "%%order_class%% .neip-ihb-desc", "margin");
	        Common::dnxt_set_style($render_slug, $this->props, "dnxtiep_ihb_description_padding", "%%order_class%% .neip-ihb-desc", "padding");
	}
}

new Next_Image_Hover_Box;
