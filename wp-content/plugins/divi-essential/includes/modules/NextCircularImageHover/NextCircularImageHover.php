<?php
include_once(DIVI_ESSENTIAL_PATH.'/includes/modules/base/Common.php');

class Next_Circular_Image_Hover extends ET_Builder_Module {

	public $slug       = 'dnxte_circular_image_hover';
	public $vb_support = 'on';

	protected $module_credits = array(
		'module_uri' => 'https://www.diviessential.com/divi-circular-image-effect/',
		'author'     => 'Divi Next',
		'author_uri' => 'www.divinext.com',
	);

	public function init() {
		$this->name        = esc_html__( 'Next Circular Image Hover', 'et_builder' );
		$this->icon_path   = plugin_dir_path( __FILE__ ) . 'icon.svg';
		$this->folder_name = 'et_pb_divi_essential';

		$this->settings_modal_toggles = array(
			'general'	=> array(
				'toggles'		=>	array(
					'dnxtiep_cih_img'	=> array(
						'title'		=> esc_html__( 'Image', 'et_builder' ),
						'priority'	=>	10,
					),
					'dnxtiep_cih_background'	=> array(
						'title'		=>	esc_html__( 'Caption Background', 'et_builder' ),
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
				),
			),
			'advanced' => array(
				'toggles'     => array(
					'dnxtiep_cih_hover_effect' => esc_html__( 'Hover Effect', 'et_builder' ),
					'dnxtiep_cih_fonts'	=> array(
						"title"		=>	esc_html__( 'Heading Text', 'et_builder' ),
					),
					'dnxtiep_cih_image_design' => esc_html__( 'Image Round Edge', 'et_builder')
 				)
			),
		);

		// Custom CSS Field
		$this->custom_css_fields = array(
			'dnxtiep_cih_heading_text' => array(
				'label'    => esc_html__( 'Heading', 'et_builder' ),
				'selector' => '%%order_class%% .neip-cih-heading',
			),
			'dnxtiep_cih_description' => array(
				'label'    => esc_html__( 'Description', 'et_builder' ),
				'selector' => '%%order_class%% .neip-cih-desc',
			)
		);
	}

	public function get_advanced_fields_config() {
		return array(
			'fonts' => array(
				'hover_text_fonts' => array(
					'label'    		=> esc_html__( '', 'et_builder' ),
					'toggle_slug'   => 'dnxtiep_cih_fonts',
					'tab_slug'		=> 'advanced',
					'css'      => array(
						'main' => "%%order_class%% .neip-cih-heading",
						'important' => 'all'
					),
				),
				'dnxtiep_cih_body'   => array(
					'label'          => esc_html__( 'Description', 'et_builder' ),
					'css'            => array(
						'main'     => "%%order_class%% .neip-cih-desc",
						'important' => 'all'
					)
				)
			),
			'text' => false,
			'margin_padding' => array(
				'css' => array(
					'main' => "%%order_class%% .dnext-neip-cih-item",
					'important' => 'all',
				),
			),
			'box_shadow'	=> array(
				'default' => array(
					'css'             => array(
						'main'        => "%%order_class%% .dnext-neip-cih-item .neip-cih-img",
					),
				),
			),
			'borders'               => array(
				'default' => array(
					'css'	=> array(
						'main'	=> array(
							'border_radii'  => "%%order_class%% .dnext-neip-cih-item .neip-cih-img",
							'border_styles' => "%%order_class%% .dnext-neip-cih-item .neip-cih-img",
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
			'background'           => array(
				'css'     => array(
					'main'   => "%%order_class%% .dnext-neip-cih-item"
				)
			)
		);
	}

	public function get_fields() {
		return array(
			'dnxtiep_cih_image'			=> array(
				'label'              	=> esc_html__( 'Image', 'et_builder' ),
				'type'               	=> 'upload',
				'option_category'    	=> 'basic_option',
				'upload_button_text' 	=> esc_attr__( 'Upload an image', 'et_builder' ),
				'choose_text'        	=> esc_attr__( 'Choose an Image', 'et_builder' ),
				'update_text'        	=> esc_attr__( 'Set As Image', 'et_builder' ),
				'description'        	=> esc_html__( 'Upload an image to display at the top of your blurb.', 'et_builder' ),
				'toggle_slug'        	=> 'dnxtiep_cih_img',
				'dynamic_content'    	=> 'image',
				'mobile_options'	 	=> true,
				'hover'					=> 'tabs',
			),
			// Image alt
			'dnxtiep_cih_alt'		=> array(
				'label'           	=> esc_html__( 'Image Alt Text', 'et_builder' ),
				'type'            	=> 'text',
				'option_category' 	=> 'basic_option',
				'description'     	=> esc_html__( 'Define the HTML ALT text for your image here.', 'et_builder' ),
				'toggle_slug'     	=> 'dnxtiep_cih_img',
				'dynamic_content' 	=> 'text',
			),
			// Heading Text
			'dnxtiep_cih_heading_text'	=> array(
				'label'           	=> esc_html__( 'Heading Text', 'et_builder' ),
				'type'            	=> 'text',
				'dynamic_content' 	=> 'text',
				'option_category' 	=> 'basic_option',
				'description'     	=> esc_html__( 'Heading Text entered here will appear inside the module.', 'et_builder' ),
				'toggle_slug'     	=> 'main_content',
			),
			//Heading Tag
			'dnxtiep_cih_heading_tag'	=> array(
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
			'dnxtiep_cih_description' 	=> array(
				'label'           	=> esc_html__( 'Content', 'et_builder' ),
				'type'            	=> 'tiny_mce',
				'dynamic_content' 	=> 'text',
				'option_category' 	=> 'basic_option',
				'description'     	=> esc_html__( 'Content entered here will appear inside the module.', 'et_builder' ),
				'toggle_slug'     	=> 'main_content',
			),
			'dnxtiep_cih_image_hover_effect'=> array(
				'label'             	=> esc_html__( 'Select Image Hover', 'et_builder' ),
				'type'              	=> 'select',
				'option_category'   	=> 'configuration',
				'tab_slug'          	=> 'advanced',
				'toggle_slug'       	=> 'dnxtiep_cih_hover_effect',
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
					'effect14'   				=>  esc_html__( 'Effect 14', 'et_builder' ),
					'effect15'   				=>  esc_html__( 'Effect 15', 'et_builder' ),
					'effect16'   				=>  esc_html__( 'Effect 16', 'et_builder' ),
					'effect17'   				=>  esc_html__( 'Effect 17', 'et_builder' ),
					'effect18'   				=>  esc_html__( 'Effect 18', 'et_builder' ),
					'effect19'   				=>  esc_html__( 'Effect 19', 'et_builder' ),
				),
				'default'               => 'effect1'
			),
			'dnxtiep_cih_image_hover_direction1'  => array(
				'label'             	=> esc_html__( 'Select Image Hover Direction', 'et_builder' ),
				'type'              	=> 'select',
				'option_category'   	=> 'configuration',
				'tab_slug'          	=> 'advanced',
				'toggle_slug'       	=> 'dnxtiep_cih_hover_effect',
				'description'           => esc_html__( 'Here you can adjust the hover effect direction.', 'et_builder' ),
				'show_if'               => array(
					'dnxtiep_cih_image_hover_effect' => array(
						'effect1',
						'effect2',
						'effect3',
						'effect6',
						'effect7',
						'effect8',
						'effect10',
						'effect11',
						'effect13',
						'effect17',
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
			'dnxtiep_cih_image_hover_direction2'  => array(
				'label'             	=> esc_html__( 'Select Image Hover Direction', 'et_builder' ),
				'type'              	=> 'select',
				'option_category'   	=> 'configuration',
				'tab_slug'          	=> 'advanced',
				'toggle_slug'       	=> 'dnxtiep_cih_hover_effect',
				'description'           => esc_html__( 'Here you can adjust the hover effect direction.', 'et_builder' ),
				'show_if'               => array(
					'dnxtiep_cih_image_hover_effect' => array('effect5')
				),
				'options'               => array(
					'scale_up'   		=>  esc_html__( 'Scale Up', 'et_builder' ),
					'scale_down'   		=>  esc_html__( 'Scale Down', 'et_builder' ),
					'scale_down_up'   	=>  esc_html__( 'Scale Down Up', 'et_builder' )
				),
				'default' => 'scale_up'
			),
			'dnxtiep_cih_image_hover_direction3'  => array(
				'label'             	=> esc_html__( 'Select Image Hover Direction', 'et_builder' ),
				'type'              	=> 'select',
				'option_category'   	=> 'configuration',
				'tab_slug'          	=> 'advanced',
				'toggle_slug'       	=> 'dnxtiep_cih_hover_effect',
				'description'           => esc_html__( 'Here you can adjust the hover effect direction.', 'et_builder' ),
				'show_if'               => array(
					'dnxtiep_cih_image_hover_effect' => array('effect15')
				),
				'options'               => array(
					'left_to_right'   	 			=>  esc_html__( 'Left to Right', 'et_builder' ),
					'right_to_left'   	 			=>  esc_html__( 'Right to Left', 'et_builder' ),
				),
				'default' => 'left_to_right'
			),
			'dnxtiep_cih_image_hover_direction4'  => array(
				'label'             	=> esc_html__( 'Select Image Hover Direction', 'et_builder' ),
				'type'              	=> 'select',
				'option_category'   	=> 'configuration',
				'tab_slug'          	=> 'advanced',
				'toggle_slug'       	=> 'dnxtiep_cih_hover_effect',
				'description'           => esc_html__( 'Here you can adjust the hover effect direction.', 'et_builder' ),
				'show_if'               => array(
					'dnxtiep_cih_image_hover_effect' => array('effect9','effect19')
				),
				'options'               => array(
					'top_to_bottom'   	 			=>  esc_html__( 'Top to Bottom', 'et_builder' ),
					'bottom_to_top'   				=>  esc_html__( 'Bottom to Top', 'et_builder' ),
				),
				'default' => 'top_to_bottom'
			),
			'dnxtiep_cih_image_hover_direction5'  => array(
				'label'             	=> esc_html__( 'Select Image Hover Direction', 'et_builder' ),
				'type'              	=> 'select',
				'option_category'   	=> 'configuration',
				'tab_slug'          	=> 'advanced',
				'toggle_slug'       	=> 'dnxtiep_cih_hover_effect',
				'description'           => esc_html__( 'Here you can adjust the hover effect direction.', 'et_builder' ),
				'show_if'               => array(
					'dnxtiep_cih_image_hover_effect' => array('effect12')
				),
				'options'               => array(
					'from_left_and_right'   	 			=>  esc_html__( 'From Left and Right', 'et_builder' ),
					'top_to_bottom'   				=>  esc_html__( 'Top to Bottom', 'et_builder' ),
					'bottom_to_top'   				=>  esc_html__( 'Bottom to Top', 'et_builder' ),
				),
				'default' => 'from_left_and_right'
			),
			'dnxtiep_cih_image_hover_direction6'  => array(
				'label'             	=> esc_html__( 'Select Image Hover Direction', 'et_builder' ),
				'type'              	=> 'select',
				'option_category'   	=> 'configuration',
				'tab_slug'          	=> 'advanced',
				'toggle_slug'       	=> 'dnxtiep_cih_hover_effect',
				'description'           => esc_html__( 'Here you can adjust the hover effect direction.', 'et_builder' ),
				'show_if'               => array(
					'dnxtiep_cih_image_hover_effect' => array('effect14')
				),
				'options'               => array(
					'left_to_right'   	 			=>  esc_html__( 'Left to Right', 'et_builder' ),
				),
				'default' => 'left_to_right'
			),
			// Hover Background 
			'dnxtiep_cih_hover_bg_show_hide'  => array(
				'label'           => esc_html__( 'Caption Background Color', 'et_builder' ),
				'type'            => 'yes_no_button',
				'toggle_slug'     => 'dnxtiep_cih_background',
				'sub_toggle'	  => 'sub_toggle_color',
				'options'         =>  array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'affects'         => array(
					'dnxtiep_cih_hover_bg',
				),
				'default_on_front' => 'off',
			),
			// Hover BG Color
			'dnxtiep_cih_hover_bg'	 => array(
				'label'          => esc_html__( 'Select Background Color', 'et_builder' ),
				'type'           => 'color-alpha',
				'toggle_slug'    => 'dnxtiep_cih_background',
				'sub_toggle'	 => 'sub_toggle_color',
				'default'        => '#29c4a9',
				'depends_show_if'=> 'on',
				'mobile_options' => true,
				'responsive'	 => true,
			),
			// Hover Background Gradient 
			'dnxtiep_cih_hover_gradient_show_hide'  => array(
				'label'           => esc_html__( 'Caption Gradient Color', 'et_builder' ),
				'type'            => 'yes_no_button',
				'toggle_slug'     => 'dnxtiep_cih_background',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'options'             => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'affects'         => array(
					'dnxtiep_cih_hover_gradient_color_one',
					'dnxtiep_cih_hover_gradient_color_two',
					'dnxtiep_cih_hover_gradient_type',
					'dnxtiep_cih_hover_gradient_start_position',
					'dnxtiep_cih_hover_gradient_end_position'
				),
				'default_on_front' => 'off',
			),
			'dnxtiep_cih_hover_gradient_color_one'	=> array(
				'label'          => esc_html__('Select Color One', 'et_builder' ),
				'type'           => 'color-alpha',
				'toggle_slug'    => 'dnxtiep_cih_background',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'default'        => '#2b87da',
				'depends_show_if'=> 'on',
			),
			'dnxtiep_cih_hover_gradient_color_two'	=> array(
				'label'          => esc_html__('Select Color Two', 'et_builder' ),
				'type'           => 'color-alpha',
				'toggle_slug'    => 'dnxtiep_cih_background',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'default'        => '#29c4a9',
				'depends_show_if'=> 'on',
			),
			'dnxtiep_cih_hover_gradient_type'		=> array(
				'label'           => esc_html__( 'Select Gradient Type', 'et_builder' ),
				'type'            => 'select',
				'description'     => esc_html__( 'Select the types of gradient', 'et_builder' ),
				'option_category' => 'basic_option',
				'toggle_slug'     => 'dnxtiep_cih_background',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'options'         => array(
					'linear-gradient' => esc_html__( 'Linear', 'et_builder' ),
					'radial-gradient' => esc_html__( 'Radial', 'et_builder' ),
				),
				'default'         => 'linear-gradient',
				'depends_show_if' => 'on',
			),
			'dnxtiep_cih_hover_gradient_type_linear_direction'   => array(
				'label'           => esc_html__( 'Linear direction', 'et_builder' ),
				'type'            => 'range',
				'option_category'=> 'basic_option',
				'toggle_slug'    => 'dnxtiep_cih_background',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'range_settings'  => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 360,
				),
				'default'         => '180deg',
				'fixed_unit'      => 'deg',
				'show_if' => array(
					'dnxtiep_cih_hover_gradient_show_hide'	=> 'on',
					'dnxtiep_cih_hover_gradient_type' 		=> 'linear-gradient'
				),
			),
			'dnxtiep_cih_hover_gradient_type_radial_direction'   => array(
				'label'           	=> esc_html__( 'Radial Direction', 'et_builder'),
				'type'            	=> 'select',
				'description'     	=> esc_html__( 'Select the types of gradient', 'et_builder'),                
				'option_category'	=> 'basic_option',
				'toggle_slug'    	=> 'dnxtiep_cih_background',
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
					'dnxtiep_cih_hover_gradient_show_hide'	=> 'on',
					'dnxtiep_cih_hover_gradient_type'		=> 'radial-gradient'
				),
			),
			'dnxtiep_cih_hover_gradient_start_position'           => array(
				'label'           => esc_html__( 'Start Position', 'et_builder' ),
				'type'            => 'range',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'dnxtiep_cih_background',
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
			'dnxtiep_cih_hover_gradient_end_position'             => array(
				'label'           => esc_html__( 'End Position', 'et_builder' ),
				'type'            => 'range',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'dnxtiep_cih_background',
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
			'dnxtiep_cih_heading_margin'	=> array(
				'label'           		=> esc_html__('Heading Margin', 'et_builder'),
                'type'            		=> 'custom_margin',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding', 
			),
			'dnxtiep_cih_heading_padding'	=> array(
				'label'           		=> esc_html__('Heading Padding', 'et_builder'),
				'type'            		=> 'custom_padding',
				'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
				'tab_slug'        		=> 'advanced',				
				'toggle_slug'     		=> 'margin_padding',
			),
			'dnxtiep_cih_description_margin'	=> array(
				'label'           			=> esc_html__('Description Margin', 'et_builder'),
                'type'            			=> 'custom_margin',
                'mobile_options'  			=> true,
				'hover'           			=> 'tabs',
				'allowed_units'   			=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 			=> 'layout',
                'tab_slug'        			=> 'advanced',
				'toggle_slug'     			=> 'margin_padding', 
			),
			'dnxtiep_cih_description_padding'	=> array(
				'label'           			=> esc_html__('Description Padding', 'et_builder'),
				'type'            			=> 'custom_padding',
				'mobile_options'  			=> true,
				'hover'           			=> 'tabs',
				'allowed_units'   			=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 			=> 'layout',
				'tab_slug'        			=> 'advanced',				
				'toggle_slug'     			=> 'margin_padding',
			),
			'dnxtiep_cih_box_shadow_horizontal'        => array(
				'label'                     => esc_html__('Box Shadow Horizontal Position', 'et_builder'),
				'type'            => 'range',
				'option_category'=> 'layout',
				'tab_slug'     => 'advanced',
				'toggle_slug'    => 'dnxtiep_cih_image_design',
				'range_settings'  => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 80,
				),
				'default'         => '0px',
				'fixed_unit'      => 'px',
			),
			'dnxtiep_cih_box_shadow_vertical'        => array(
				'label'                     => esc_html__('Box Shadow Vertical Position', 'et_builder'),
				'type'            => 'range',
				'option_category'=> 'layout',
				'tab_slug'     => 'advanced',
				'toggle_slug'    => 'dnxtiep_cih_image_design',
				'range_settings'  => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 80,
				),
				'default'         => '0px',
				'fixed_unit'      => 'px',
			),
			'dnxtiep_cih_box_shadow_blur_strength'        => array(
				'label'                     => esc_html__('Box Shadow Blur Strength', 'et_builder'),
				'type'            => 'range',
				'option_category'=> 'layout',
				'tab_slug'     => 'advanced',
				'toggle_slug'    => 'dnxtiep_cih_image_design',
				'range_settings'  => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 80,
				),
				'default'         => '0px',
				'fixed_unit'      => 'px',
			),
			'dnxtiep_cih_box_shadow_spread_strength'        => array(
				'label'                     => esc_html__('Box Shadow Spread Strength', 'et_builder'),
				'type'            => 'range',
				'option_category'=> 'layout',
				'tab_slug'     => 'advanced',
				'toggle_slug'    => 'dnxtiep_cih_image_design',
				'range_settings'  => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 80,
				),
				'default'         => '0px',
				'fixed_unit'      => 'px',
			),
			'dnxtiep_cih_box_shadow_color'	 => array(
				'label'          => esc_html__( 'Shadow Color', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'     => 'advanced',
				'toggle_slug'    => 'dnxtiep_cih_image_design',
				'default'        => '#29c4a9',
				'mobile_options' => true,
				'responsive'	 => true,
			)
		);
	}
	
	public function render( $attrs, $content, $render_slug ) {
		$multi_view 						=   et_pb_multi_view_options( $this );
		$dnxtiep_cih_image					=	$this->props['dnxtiep_cih_image'];
		$dnxtiep_cih_alt					=	$this->props['dnxtiep_cih_alt'];

		$dnxtiep_cih_heading_text			=	$this->props['dnxtiep_cih_heading_text'];
		$dnxtiep_cih_heading_tag			=	$this->props['dnxtiep_cih_heading_tag'];
		$dnxtiep_cih_description			=	$this->props['dnxtiep_cih_description'];

		$dnxtiep_cih_hover_effect       	=   $this->props['dnxtiep_cih_image_hover_effect'];



		$dnxtiep_cih_hover_direction_class       = "";

		$dnxtiep_cih_effect1 = array(
			'effect1',
			'effect2',
			'effect3',
			'effect6',
			'effect7',
			'effect8',
			'effect10',
			'effect11',
			'effect13',
			'effect17'
		);
		$dnxtiep_cih_info_back = array(
			'effect4',
			'effect17',
			'effect19'
		);
		$dnxtiep_cih_effect2 = 'effect5';
		$dnxtiep_cih_effect3 = 'effect15';
		$dnxtiep_cih_effect4 = array(
			'effect9',
			'effect19'
		);
		$dnxtiep_cih_effect5 = 'effect12';
		$dnxtiep_cih_effect6 = 'effect14';


		if ( in_array($dnxtiep_cih_hover_effect, $dnxtiep_cih_effect1) ) {
			$dnxtiep_cih_hover_direction_class = "neip-cih-".$this->props['dnxtiep_cih_image_hover_direction1'];
		}
		if( $dnxtiep_cih_effect2 === $dnxtiep_cih_hover_effect ) {
			$dnxtiep_cih_hover_direction_class = "neip-cih-".$this->props['dnxtiep_cih_image_hover_direction2'];
		}
		if( $dnxtiep_cih_effect5 === $dnxtiep_cih_hover_effect ) {
			$dnxtiep_cih_hover_direction_class = "neip-cih-".$this->props['dnxtiep_cih_image_hover_direction5'];
		}
		if( $dnxtiep_cih_effect3 === $dnxtiep_cih_hover_effect ) {
			$dnxtiep_cih_hover_direction_class = "neip-cih-".$this->props['dnxtiep_cih_image_hover_direction3'];
		}
		if( in_array($dnxtiep_cih_hover_effect, $dnxtiep_cih_effect4) ) {
			$dnxtiep_cih_hover_direction_class = "neip-cih-".$this->props['dnxtiep_cih_image_hover_direction4'];
		}
		if( $dnxtiep_cih_effect6 === $dnxtiep_cih_hover_effect ) {
			$dnxtiep_cih_hover_direction_class = "neip-cih-".$this->props['dnxtiep_cih_image_hover_direction6'];
		}


		$image_html = $multi_view->render_element( array(
			'tag'   => 'img',
			'attrs' => array(
				'src'   => '{{dnxtiep_cih_image}}',
				'alt'   => '{{dnxtiep_cih_alt}}',
			),
			'required' => 'dnxtiep_cih_image',
		) );

		// Image 
		if( $dnxtiep_cih_hover_effect === 'effect7' ) {
			$dnxtiep_cih_img = sprintf(
				'<div class="neip-cih-img-container"><div class="neip-cih-img">%1$s</div></div>',
				$image_html
			);
		}else{
			$dnxtiep_cih_img = sprintf(
				'<div class="neip-cih-img">%1$s</div>',
				$image_html
			);
		}

		// Heading Text
		$dnxtiepheadingtext = '';
		if ( '' !== $dnxtiep_cih_heading_text ){
			$dnxtiepheadingtext = sprintf(
				'<%1$s class="neip-cih-heading">%2$s</%1$s>',
				et_pb_process_header_level( $dnxtiep_cih_heading_tag, 'span' ),
				et_core_esc_previously( $dnxtiep_cih_heading_text )
			);
		}

		$description = $multi_view->render_element( array(
			'tag' => 'div',
			'content' => '{{dnxtiep_cih_description}}',
			'attrs' => array(
			'class' => 'neip-cih-desc',
			)
			));

		// Content section
		$content = "";
			if( in_array($dnxtiep_cih_hover_effect, $dnxtiep_cih_info_back) ) {
				$content = sprintf(
					'<div class="neip-cih-info">
		                <div class="neip-cih-info-back">
		                    %1$s
		                    %2$s
		                </div>
		            </div>',
		            $dnxtiepheadingtext,
		            wpautop( $description )
				);
			} elseif( $dnxtiep_cih_hover_effect == 'effect7' ) {
				$content = sprintf(
		             '<div class="neip-cih-info-container">
						<div class="neip-cih-info">
		                    %1$s
		                    %2$s
		                </div>
		            </div>',
		            $dnxtiepheadingtext,
		            wpautop( $description )
				);
			}else{
				$content = sprintf(
		             '<div class="neip-cih-info">
		                    %1$s
		                    %2$s
		                </div>',
		            $dnxtiepheadingtext,
		            wpautop( $description )
				);
			}


		// Hover BG Color
		$dnxtiep_cih_hover_bg_color			= $this->props['dnxtiep_cih_hover_bg'];
		$dnxtiep_cih_hover_bg_color_values	= et_pb_responsive_options()->get_property_values( $this->props, 'dnxtiep_cih_hover_bg' );
		$dnxtiep_cih_hover_bg_color_tablet	= isset( $dnxtiep_cih_hover_bg_color_values['tablet'] ) ? $dnxtiep_cih_hover_bg_color_values['tablet'] : '';
		$dnxtiep_cih_hover_bg_color_phone	= isset( $dnxtiep_cih_hover_bg_color_values['phone'] ) ? $dnxtiep_cih_hover_bg_color_values['phone'] : '';

		if ( 'off' !== $this->props['dnxtiep_cih_hover_bg_show_hide'] ) {
			$dnxtiep_cih_hover_bg_color_style = sprintf( 'background: %1$s;', esc_attr( $dnxtiep_cih_hover_bg_color ) );
			$dnxtiep_cih_hover_bg_color_tablet_style = '' !== $dnxtiep_cih_hover_bg_color_tablet ? sprintf( 'background: %1$s;', esc_attr( $dnxtiep_cih_hover_bg_color_tablet ) ) : '';
			$dnxtiep_cih_hover_bg_color_phone_style  = '' !== $dnxtiep_cih_hover_bg_color_phone ? sprintf( 'background: %1$s;', esc_attr( $dnxtiep_cih_hover_bg_color_phone ) ) : '';
			
			if( in_array($dnxtiep_cih_hover_effect, $dnxtiep_cih_info_back ) ) {
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => "%%order_class%% .dnext-neip-cih-item.neip-cih-{$dnxtiep_cih_hover_effect} .neip-cih-info .neip-cih-info-back",
					'declaration' => $dnxtiep_cih_hover_bg_color_style,
				) );

				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => "%%order_class%% .dnext-neip-cih-item.neip-cih-{$dnxtiep_cih_hover_effect} .neip-cih-info .neip-cih-info-back",
					'declaration' => $dnxtiep_cih_hover_bg_color_tablet_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
				) );

				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => "%%order_class%% .dnext-neip-cih-item.neip-cih-{$dnxtiep_cih_hover_effect} .neip-cih-info .neip-cih-info-back",
					'declaration' => $dnxtiep_cih_hover_bg_color_phone_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				) );
			} else {
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => "%%order_class%% .dnext-neip-cih-item.neip-cih-{$dnxtiep_cih_hover_effect} .neip-cih-info",
					'declaration' => $dnxtiep_cih_hover_bg_color_style,
				) );

				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => "%%order_class%% .dnext-neip-cih-item.neip-cih-{$dnxtiep_cih_hover_effect} .neip-cih-info",
					'declaration' => $dnxtiep_cih_hover_bg_color_tablet_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
				) );

				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => "%%order_class%% .dnext-neip-cih-item.neip-cih-{$dnxtiep_cih_hover_effect} .neip-cih-info",
					'declaration' => $dnxtiep_cih_hover_bg_color_phone_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				) );
			}
		}

		//GRADIENT COLOR 
			$dnxtiep_cih_hover_gradient_color_one = $this->props['dnxtiep_cih_hover_gradient_color_one'];
			$dnxtiep_cih_hover_gradient_color_two = $this->props['dnxtiep_cih_hover_gradient_color_two'];
			// Other gradient options
			$dnxtiep_cih_hover_gradient_type = $this->props['dnxtiep_cih_hover_gradient_type'];
			$dnxtiep_cih_hover_gradient_start = $this->props['dnxtiep_cih_hover_gradient_start_position'];
			$dnxtiep_cih_hover_gradient_end = $this->props['dnxtiep_cih_hover_gradient_end_position'];

			$dnxtiep_cih_hover_gradient_direction = $dnxtiep_cih_hover_gradient_type === 'linear-gradient' ? $this->props['dnxtiep_cih_hover_gradient_type_linear_direction'] : $this->props['dnxtiep_cih_hover_gradient_type_radial_direction'];

			if('off' !== $this->props['dnxtiep_cih_hover_gradient_show_hide']) {
				$dnxtiep_cih_hover_bg_gradient = sprintf('background: %1$s(%2$s, %3$s %5$s, %4$s %6$s)', $dnxtiep_cih_hover_gradient_type, $dnxtiep_cih_hover_gradient_direction, esc_attr($dnxtiep_cih_hover_gradient_color_one), esc_attr($dnxtiep_cih_hover_gradient_color_two), $dnxtiep_cih_hover_gradient_start, $dnxtiep_cih_hover_gradient_end);

				if( in_array($dnxtiep_cih_hover_effect, $dnxtiep_cih_info_back ) ) {
					ET_Builder_Element::set_style( $render_slug, array(
						'selector'    => "%%order_class%% .dnext-neip-cih-item.neip-cih-{$dnxtiep_cih_hover_effect} .neip-cih-info .neip-cih-info-back",
						'declaration' => $dnxtiep_cih_hover_bg_gradient,
					) );
				}else{
					ET_Builder_Element::set_style( $render_slug, array(
						'selector'    => "%%order_class%% .dnext-neip-cih-item.neip-cih-{$dnxtiep_cih_hover_effect} .neip-cih-info",
						'declaration' => $dnxtiep_cih_hover_bg_gradient,
					) );
				}
			}
			// Gradient hover bg end



			// Image round edge
			$dnxtiep_cih_box_shadow_horizontal 		= $this->props['dnxtiep_cih_box_shadow_horizontal'];
			$dnxtiep_cih_box_shadow_vertical 		= $this->props['dnxtiep_cih_box_shadow_vertical'];
			$dnxtiep_cih_box_shadow_blur_strength 	= $this->props['dnxtiep_cih_box_shadow_blur_strength'];
			$dnxtiep_cih_box_shadow_spread_strength = $this->props['dnxtiep_cih_box_shadow_spread_strength'];


			$dnxtiep_cih_box_shadow_color_values = et_pb_responsive_options()->get_property_values( $this->props, 'dnxtiep_cih_box_shadow_color' );
			$dnxtiep_cih_box_shadow_color_tablet = isset( $dnxtiep_cih_box_shadow_color_values['tablet'] ) ? $dnxtiep_cih_box_shadow_color_values['tablet'] : '';
			$dnxtiep_cih_box_shadow_color_phone	= isset( $dnxtiep_cih_box_shadow_color_values['phone'] ) ? $dnxtiep_cih_box_shadow_color_values['phone'] : '';


			$dnxtiep_cih_box_shadow_color 	= $this->props['dnxtiep_cih_box_shadow_color'];

			$dnxtiep_cih_box_shadow = sprintf(
				'box-shadow: inset %1$s %2$s %3$s %4$s %5$s,0 1px 2px rgba(0, 0, 0, 0.3) !important;', 
				$dnxtiep_cih_box_shadow_horizontal, 
				$dnxtiep_cih_box_shadow_vertical, 
				$dnxtiep_cih_box_shadow_blur_strength, 
				$dnxtiep_cih_box_shadow_spread_strength, 
				$dnxtiep_cih_box_shadow_color
			);

			$dnxtiep_cih_box_shadow_tablet_style = '' !== $dnxtiep_cih_box_shadow_color_tablet ? sprintf(
				'box-shadow: inset %1$s %2$s %3$s %4$s %5$s,0 1px 2px rgba(0, 0, 0, 0.3) !important;', $dnxtiep_cih_box_shadow_horizontal, 
					$dnxtiep_cih_box_shadow_vertical, 
					$dnxtiep_cih_box_shadow_blur_strength, 
					$dnxtiep_cih_box_shadow_spread_strength, 
					$dnxtiep_cih_box_shadow_color_tablet) : '';

			$dnxtiep_cih_box_shadow_phone_style = '' !== $dnxtiep_cih_box_shadow_color_phone ? 
				sprintf('box-shadow: inset %1$s %2$s %3$s %4$s %5$s,0 1px 2px rgba(0, 0, 0, 0.3) !important;', 
					$dnxtiep_cih_box_shadow_horizontal, 
					$dnxtiep_cih_box_shadow_vertical, 
					$dnxtiep_cih_box_shadow_blur_strength, 
					$dnxtiep_cih_box_shadow_spread_strength, 
					$dnxtiep_cih_box_shadow_color_phone) : '';

			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnext-neip-cih-item .neip-cih-img::before",
				'declaration' => $dnxtiep_cih_box_shadow,
			) );

			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnext-neip-cih-item .neip-cih-img::before",
				'declaration' => $dnxtiep_cih_box_shadow_tablet_style,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
			) );

			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnext-neip-cih-item .neip-cih-img::before",
				'declaration' => $dnxtiep_cih_box_shadow_phone_style,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
			) );

			// Image round edge end

		$this->apply_css($render_slug);
		return sprintf(
			'<div class="dnext-neip-cih-item neip-cih-%3$s %4$s"><div class="dnext-neip-cih-hvr">
		            %1$s
		            %2$s
		        </div>
		    </div>',
		    $dnxtiep_cih_img,
		    $content,
		    $dnxtiep_cih_hover_effect,
		    $dnxtiep_cih_hover_direction_class
		);
	}

	public function apply_css($render_slug){


			/**
	         * Custom Padding Margin Output
	         *
	        */
			Common::dnxt_set_style($render_slug, $this->props, "dnxtiep_cih_heading_margin", "%%order_class%% .neip-cih-heading", "margin");
	        Common::dnxt_set_style($render_slug, $this->props, "dnxtiep_cih_heading_padding", "%%order_class%% .neip-cih-heading", "padding");

			Common::dnxt_set_style($render_slug, $this->props, "dnxtiep_cih_description_margin", "%%order_class%% .neip-cih-desc", "margin");
	        Common::dnxt_set_style($render_slug, $this->props, "dnxtiep_cih_description_padding", "%%order_class%% .neip-cih-desc", "padding");
	}
}

new Next_Circular_Image_Hover;
