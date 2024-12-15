<?php
include_once(DIVI_ESSENTIAL_PATH.'/includes/modules/base/Common.php');

class Next_Ultimate_Image_Hover extends ET_Builder_Module {

	public $slug       = 'dnxte_ultimate_image_hover';
	public $vb_support = 'on';

	protected $module_credits = array(
		'module_uri' => 'https://www.diviessential.com/divi-ultimate-image-effect/',
		'author'     => 'Divi Next',
		'author_uri' => 'www.divinext.com',
	);

	public function init() {
		$this->name        = esc_html__( 'Next Ultimate Image Hover', 'et_builder' );
		$this->icon_path   = plugin_dir_path( __FILE__ ) . 'icon.svg';
		$this->folder_name = 'et_pb_divi_essential';

		$this->settings_modal_toggles = array(
			'general' => array(
				'toggles' => array(
					'dnxtiep_uih_img' => array(
						'title'		=> esc_html__( 'Image', 'et_builder' ),
						'priority'	=>	10,
					),
					'dnxtiep_uih_background'	=> array(
						'title'		=>	esc_html__( 'Content Background', 'et_builder' ),
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
					'background'              => array(
						'title'		=>	esc_html__( 'Background', 'et_builder' ),
						'priority'	=>	31,
						'sub_toggles'         => array(
							'sub_toggle_color'   => array(
								'name' => esc_html__( 'Color', 'et_builder' )
                            ),
                            'sub_toggle_gradient'   => array(
								'name' => esc_html__( 'Gradient', 'et_builder' )
                            )
						),
                        'tabbed_subtoggles' => true,
					)
				)
			),
			'advanced' => array(
				'toggles' => array(
					'dnxtiep_uih_hover_effect' => esc_html__( 'Hover Effect', 'et_builder' ),
					'dnxtiep_uih_fonts'	=> array(
						"title"		=>	esc_html__( 'Fonts', 'et_builder' ),
						'sub_toggles'       => array(
                            'sub_toggle_heading'   => array(
								'name' => esc_html__( 'Heading Text', 'et_builder' )
                            ),
                            'sub_toggle_focus'   => array(
								'name' => esc_html__( 'Focus Text', 'et_builder' )
                            )
                        ),
                        'tabbed_subtoggles' => true,
					),
					'dnxtiep_uih_heading_bold'	=> array(
						"title"		=>	esc_html__( 'Focus Text', 'et_builder' ),
					),
					'dnxtiep_uih_opacity'       => array(
						"title"     => esc_html__( 'Opacity', 'et_builder'),
					)
				)
			)
		);

		$this->custom_css_fields = array(
			'dnxtiep_uih_heading_text' => array(
				'label'    => esc_html__( 'Heading', 'et_builder' ),
				'selector' => '%%order_class%% .dnext-neip-uih-des-heading',
			),
			'dnxtiep_uih_heading_bold' => array(
				'label'    => esc_html__( 'Focus Text', 'et_builder' ),
				'selector' => '%%order_class%% .dnext-neip-uih-des-heading span',
			),
			'dnxtiep_uih_heading_hover' => array(
				'label'    => esc_html__( 'Heading Hover', 'et_builder' ),
				'selector' => '%%order_class%% .dnext-neip-uih-des-heading i',
			),
			'dnxtiep_uih_grid_figure' => array(
				'label'    => esc_html__( 'Main Wrapper', 'et_builder' ),
				'selector' => '%%order_class%% .dnext-neip-uih-grid figure',
			),
			'dnxtiep_uih_description' => array(
				'label'    => esc_html__( 'Description', 'et_builder' ),
				'selector' => '%%order_class%% .dnext-neip-uih-des-pra',
			),
		);
	}

	public function get_fields() {
		return array(
			// Heading Text
			'dnxtiep_uih_heading_text'	=> array(
				'label'           	=> esc_html__( 'Heading Text', 'et_builder' ),
				'type'            	=> 'text',
				'dynamic_content' 	=> 'text',
				'option_category' 	=> 'basic_option',
				'description'     	=> esc_html__( 'Heading Text entered here will appear inside the module.', 'et_builder' ),
				'toggle_slug'     	=> 'main_content',
			),
			// Heading Text
			'dnxtiep_uih_heading_bold'	=> array(
				'label'           	=> esc_html__( 'Focus Text', 'et_builder' ),
				'type'            	=> 'text',
				'dynamic_content' 	=> 'text',
				'option_category' 	=> 'basic_option',
				'description'     	=> esc_html__( 'Heading bold text entered here will appear inside the module after the heading text.', 'et_builder' ),
				'toggle_slug'     	=> 'main_content',
			),
			'dnxtiep_uih_heading_hover'	=> array(
				'label'           	=> esc_html__( 'Hover Text', 'et_builder' ),
				'type'            	=> 'text',
				'dynamic_content' 	=> 'text',
				'default'         	=> 'Hover Text',
				'option_category' 	=> 'basic_option',
				'description'     	=> esc_html__( 'Heading Text entered here will appear inside the module.', 'et_builder' ),
				'toggle_slug'     	=> 'main_content',
				'show_if'           => array(
					'dnxtiep_uih_image_hover_effect' => "effect-3"
				)
			),
			//Heading Tag
			'dnxtiep_uih_heading_tag'	=> array(
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
			'dnxtiep_uih_description' 	=> array(
				'label'           	=> esc_html__( 'Content', 'et_builder' ),
				'type'            	=> 'tiny_mce',
				'dynamic_content' 	=> 'text',
				'option_category' 	=> 'basic_option',
				'description'     	=> esc_html__( 'Content entered here will appear inside the module.', 'et_builder' ),
				'toggle_slug'     	=> 'main_content',
				'show_if_not'       => array(
					'dnxtiep_uih_image_hover_effect' => array('effect-3')
				)
			),
			// Image
			'dnxtiep_uih_image'			=> array(
				'label'              	=> esc_html__( 'Image', 'et_builder' ),
				'type'               	=> 'upload',
				'option_category'    	=> 'basic_option',
				'upload_button_text' 	=> esc_attr__( 'Upload an image', 'et_builder' ),
				'choose_text'        	=> esc_attr__( 'Choose an Image', 'et_builder' ),
				'update_text'        	=> esc_attr__( 'Set As Image', 'et_builder' ),
				'description'        	=> esc_html__( 'Upload an image to display at the top of your blurb.', 'et_builder' ),
				'toggle_slug'        	=> 'dnxtiep_uih_img',
				'dynamic_content'    	=> 'image',
				'mobile_options'        => true,
				'hover'					=> 'tabs',
			),
			// Image alt
			'dnxtiep_uih_alt'		=> array(
				'label'           	=> esc_html__( 'Image Alt Text', 'et_builder' ),
				'type'            	=> 'text',
				'option_category' 	=> 'basic_option',
				'description'     	=> esc_html__( 'Define the HTML ALT text for your image here.', 'et_builder' ),
				'toggle_slug'     	=> 'dnxtiep_uih_img',
				'dynamic_content' 	=> 'text',
				'mobile_options'    => true,
				'hover'             => 'tabs'
			),
			'dnxtiep_uih_image_hover_effect'=> array(
				'label'             	=> esc_html__( 'Select Image Hover', 'et_builder' ),
				'type'              	=> 'select',
				'option_category'   	=> 'configuration',
				'tab_slug'          	=> 'advanced',
				'toggle_slug'       	=> 'dnxtiep_uih_hover_effect',
				'description'           => esc_html__( 'Here you can adjust the hover effect.', 'et_builder' ),
				'options'               => array(
					'effect-1'   				=>  esc_html__( 'Effect 1', 'et_builder' ),
					'effect-2'   				=>  esc_html__( 'Effect 2', 'et_builder' ),
					'effect-3'   				=>  esc_html__( 'Effect 3', 'et_builder' ),
					'effect-4'   				=>  esc_html__( 'Effect 4', 'et_builder' ),
					'effect-5'   				=>  esc_html__( 'Effect 5', 'et_builder' ),
					'effect-6'   				=>  esc_html__( 'Effect 6', 'et_builder' ),
					'effect-7'   				=>  esc_html__( 'Effect 7', 'et_builder' ),
					'effect-8'   				=>  esc_html__( 'Effect 8', 'et_builder' ),
					'effect-9'   				=>  esc_html__( 'Effect 9', 'et_builder' ),
					'effect-10'   				=>  esc_html__( 'Effect 10', 'et_builder' ),
					'effect-11'   				=>  esc_html__( 'Effect 11', 'et_builder' ),
					'effect-12'   				=>  esc_html__( 'Effect 12', 'et_builder' ),
					'effect-13'   				=>  esc_html__( 'Effect 13', 'et_builder' ),
					'effect-14'   				=>  esc_html__( 'Effect 14', 'et_builder' ),
					'effect-15'   				=>  esc_html__( 'Effect 15', 'et_builder' ),
					'effect-16'   				=>  esc_html__( 'Effect 16', 'et_builder' ),
					'effect-17'   				=>  esc_html__( 'Effect 17', 'et_builder' ),
					'effect-18'   				=>  esc_html__( 'Effect 18', 'et_builder' ),
					'effect-19'   				=>  esc_html__( 'Effect 19', 'et_builder' ),
					'effect-20'   				=>  esc_html__( 'Effect 20', 'et_builder' ),
					'effect-21'   				=>  esc_html__( 'Effect 21', 'et_builder' ),
					'effect-22'   				=>  esc_html__( 'Effect 22', 'et_builder' ),
					'effect-23'   				=>  esc_html__( 'Effect 23', 'et_builder' ),
					'effect-24'   				=>  esc_html__( 'Effect 24', 'et_builder' ),
				),
				'default'               => 'effect-1'
			),

			'dnxtiep_uih_heading_margin'	=> array(
				'label'           		=> esc_html__('Heading Margin', 'et_builder'),
                'type'            		=> 'custom_margin',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding', 
			),
			'dnxtiep_uih_heading_padding'	=> array(
				'label'           		=> esc_html__('Heading Padding', 'et_builder'),
				'type'            		=> 'custom_padding',
				'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
				'tab_slug'        		=> 'advanced',				
				'toggle_slug'     		=> 'margin_padding',
			),
			'dnxtiep_uih_focus_padding'	=> array(
				'label'           		=> esc_html__('Focus Text Padding', 'et_builder'),
				'type'            		=> 'custom_padding',
				'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
				'tab_slug'        		=> 'advanced',				
				'toggle_slug'     		=> 'margin_padding',
			),
			'dnxtiep_uih_description_margin'	=> array(
				'label'           			=> esc_html__('Description Margin', 'et_builder'),
                'type'            			=> 'custom_margin',
                'mobile_options'  			=> true,
				'hover'           			=> 'tabs',
				'allowed_units'   			=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 			=> 'layout',
                'tab_slug'        			=> 'advanced',
				'toggle_slug'     			=> 'margin_padding', 
			),
			'dnxtiep_uih_description_padding'	=> array(
				'label'           			=> esc_html__('Description Padding', 'et_builder'),
				'type'            			=> 'custom_padding',
				'mobile_options'  			=> true,
				'hover'           			=> 'tabs',
				'allowed_units'   			=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 			=> 'layout',
				'tab_slug'        			=> 'advanced',				
				'toggle_slug'     			=> 'margin_padding',
			),
			'dnxtiep_uih_bottom_bg'	 => array(
				'label'          => esc_html__( 'Bottom Background Color', 'et_builder' ),
				'type'           => 'color-alpha',
				'toggle_slug'    => 'background',
				'sub_toggle'     => 'sub_toggle_color',
				'default'        => '#29c4a9',
				'mobile_options' => true,
				'responsive'	 => true,
				'show_if'        => array(
					'dnxtiep_uih_image_hover_effect' => "effect-3"
				)
			),
			'dnxtiep_uih_bg_overlay'	 => array(
				'label'          => esc_html__( 'Background Overlay', 'et_builder' ),
				'type'           => 'color-alpha',
				'toggle_slug'    => 'background',
				'sub_toggle'     => 'sub_toggle_color',
				'default'        => '#29c4a9',
				'mobile_options' => true,
				'responsive'	 => true,
			),
			//Background Overlay Gradient 
			'dnxtiep_uih_bg_overlay_gradient_show_hide'  => array(
				'label'           => esc_html__( 'Background Overlay Gradient', 'et_builder' ),
				'type'            => 'yes_no_button',                
				'toggle_slug'     => 'background',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'options'             => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'affects'         => array(
					'dnxtiep_uih_bg_overlay_gradient_color_one',
					'dnxtiep_uih_bg_overlay_gradient_color_two',
					'dnxtiep_uih_bg_overlay_gradient_type',
					'dnxtiep_uih_bg_overlay_gradient_start_position',
					'dnxtiep_uih_bg_overlay_gradient_end_position'
				),
				'default_on_front' => 'off'
			),

			'dnxtiep_uih_bg_overlay_gradient_color_one'	=> array(
				'label'          => esc_html__('Select Color One', 'et_builder' ),
				'type'           => 'color-alpha',
				'toggle_slug'    => 'background',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'default'        => '#2b87da',
				'depends_show_if'=> 'on',
				'show_if'        => array(
					'dnxtiep_uih_bg_overlay_gradient_show_hide' => 'on',
				)
			),
			'dnxtiep_uih_bg_overlay_gradient_color_two'	=> array(
				'label'          => esc_html__('Select Color Two', 'et_builder' ),
				'type'           => 'color-alpha',
				'toggle_slug'    => 'background',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'default'        => '#29c4a9',
				'depends_show_if'=> 'on',
				'show_if'        => array(
					'dnxtiep_uih_bg_overlay_gradient_show_hide' => 'on',
				)
			),
			'dnxtiep_uih_bg_overlay_gradient_type'		=> array(
				'label'           => esc_html__( 'Select Gradient Type', 'et_builder' ),
				'type'            => 'select',
				'description'     => esc_html__( 'Select the types of gradient', 'et_builder' ),
				'option_category' => 'basic_option',
				'toggle_slug'     => 'background',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'options'         => array(
					'linear-gradient' => esc_html__( 'Linear', 'et_builder' ),
					'radial-gradient' => esc_html__( 'Radial', 'et_builder' ),
				),
				'default'         => 'linear-gradient',
				'depends_show_if'=> 'on',
				'show_if'        => array(
					'dnxtiep_uih_bg_overlay_gradient_show_hide' => 'on',
				)
			),
			'dnxtiep_uih_bg_overlay_gradient_type_linear_direction'   => array(
				'label'           => esc_html__( 'Linear direction', 'et_builder' ),
				'type'            => 'range',
				'option_category'=> 'basic_option',
				'toggle_slug'    => 'background',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'range_settings'  => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 360,
				),
				'default'         => '180deg',
				'fixed_unit'      => 'deg',
				'show_if' => array(
					'dnxtiep_uih_bg_overlay_gradient_show_hide' => 'on',
					'dnxtiep_uih_bg_overlay_gradient_type' 		 => 'linear-gradient',
				),
			),
			'dnxtiep_uih_bg_overlay_gradient_type_radial_direction'   => array(
				'label'           	=> esc_html__( 'Radial Direction', 'et_builder'),
				'type'            	=> 'select',
				'description'     	=> esc_html__( 'Select the types of gradient', 'et_builder'),                
				'option_category'	=> 'basic_option',
				'toggle_slug'    	=> 'background',
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
					'dnxtiep_uih_bg_overlay_gradient_show_hide' => 'on',
					'dnxtiep_uih_bg_overlay_gradient_type'		=> 'radial-gradient',
				),
			),
			'dnxtiep_uih_bg_overlay_gradient_start_position'           => array(
				'label'           => esc_html__( 'Start Position', 'et_builder' ),
				'type'            => 'range',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'background',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'range_settings'  => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 100,
				),
				'default'         => '0%',
				'fixed_unit'      => '%',
				'depends_show_if'=> 'on',
				'show_if'        => array(
					'dnxtiep_uih_bg_overlay_gradient_show_hide' => 'on',
				)
			),
			'dnxtiep_uih_bg_overlay_gradient_end_position'             => array(
				'label'           => esc_html__( 'End Position', 'et_builder' ),
				'type'            => 'range',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'background',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'range_settings'  => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 100,
				),
				'default'         => '100%',
				'depends_show_if'=> 'on',
				'fixed_unit'      => '%',
				'show_if'        => array(
					'dnxtiep_uih_bg_overlay_gradient_show_hide' => 'on',
				)
			),
			// Content Background Color
			'dnxtiep_uih_content_bg_color'  => array(
				'label'          => esc_html__( 'Background Color', 'et_builder' ),
				'type'           => 'color-alpha',
				'toggle_slug'    => 'dnxtiep_uih_background',
				'sub_toggle'	  => 'sub_toggle_color',
				'default'        => '#29c4a9',
				'mobile_options' => true,
				'responsive'	 => true,
				'show_if'        => array(
					'dnxtiep_uih_image_hover_effect' => array(
						"effect-15",
						"effect-19"
					)
				)
			),
			// Content Background Gradient 
			'dnxtiep_uih_content_gradient_show_hide'  => array(
				'label'           => esc_html__( 'Content Gradient Color', 'et_builder' ),
				'type'            => 'yes_no_button',                
				'toggle_slug'     => 'dnxtiep_uih_background',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'options'             => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'affects'         => array(
					'dnxtiep_uih_content_gradient_color_one',
					'dnxtiep_uih_content_gradient_color_two',
					'dnxtiep_uih_content_gradient_type',
					'dnxtiep_uih_content_gradient_start_position',
					'dnxtiep_uih_content_gradient_end_position'
				),
				'default_on_front' => 'off',
				'show_if'        => array(
					'dnxtiep_uih_image_hover_effect' => array(
						"effect-15",
						"effect-19"
					)
				)
			),
			'dnxtiep_uih_content_gradient_color_one'	=> array(
				'label'          => esc_html__('Select Color One', 'et_builder' ),
				'type'           => 'color-alpha',
				'toggle_slug'    => 'dnxtiep_uih_background',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'default'        => '#2b87da',
				'depends_show_if'=> 'on',
				'show_if'        => array(
					'dnxtiep_uih_content_gradient_show_hide' => 'on',
					'dnxtiep_uih_image_hover_effect' => array(
						"effect-15",
						"effect-19"
					)
				)
			),
			'dnxtiep_uih_content_gradient_color_two'	=> array(
				'label'          => esc_html__('Select Color Two', 'et_builder' ),
				'type'           => 'color-alpha',
				'toggle_slug'    => 'dnxtiep_uih_background',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'default'        => '#29c4a9',
				'depends_show_if'=> 'on',
				'show_if'        => array(
					'dnxtiep_uih_content_gradient_show_hide' => 'on',
					'dnxtiep_uih_image_hover_effect' => array(
						"effect-15",
						"effect-19"
					)
				)
			),
			'dnxtiep_uih_content_gradient_type'		=> array(
				'label'           => esc_html__( 'Select Gradient Type', 'et_builder' ),
				'type'            => 'select',
				'description'     => esc_html__( 'Select the types of gradient', 'et_builder' ),
				'option_category' => 'basic_option',
				'toggle_slug'     => 'dnxtiep_uih_background',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'options'         => array(
					'linear-gradient' => esc_html__( 'Linear', 'et_builder' ),
					'radial-gradient' => esc_html__( 'Radial', 'et_builder' ),
				),
				'default'         => 'linear-gradient',
				'depends_show_if'=> 'on',
				'show_if'        => array(
					'dnxtiep_uih_content_gradient_show_hide' => 'on',
					'dnxtiep_uih_image_hover_effect' => array(
						"effect-15",
						"effect-19"
					)
				)
			),
			'dnxtiep_uih_content_gradient_type_linear_direction'   => array(
				'label'           => esc_html__( 'Linear direction', 'et_builder' ),
				'type'            => 'range',
				'option_category'=> 'basic_option',
				'toggle_slug'    => 'dnxtiep_uih_background',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'range_settings'  => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 360,
				),
				'default'         => '180deg',
				'fixed_unit'      => 'deg',
				'show_if' => array(
					'dnxtiep_uih_content_gradient_show_hide' => 'on',
					'dnxtiep_uih_content_gradient_type' 		 => 'linear-gradient',
					'dnxtiep_uih_image_hover_effect' => array(
						"effect-15",
						"effect-19"
					)
				),
			),
			'dnxtiep_uih_content_gradient_type_radial_direction'   => array(
				'label'           	=> esc_html__( 'Radial Direction', 'et_builder'),
				'type'            	=> 'select',
				'description'     	=> esc_html__( 'Select the types of gradient', 'et_builder'),                
				'option_category'	=> 'basic_option',
				'toggle_slug'    	=> 'dnxtiep_uih_background',
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
					'dnxtiep_uih_content_gradient_show_hide' => 'on',
					'dnxtiep_uih_content_gradient_type'		=> 'radial-gradient',
					'dnxtiep_uih_image_hover_effect' => array(
						"effect-15",
						"effect-19"
					)
				),
			),
			'dnxtiep_uih_content_gradient_start_position'           => array(
				'label'           => esc_html__( 'Start Position', 'et_builder' ),
				'type'            => 'range',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'dnxtiep_uih_background',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'range_settings'  => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 100,
				),
				'default'         => '0%',
				'fixed_unit'      => '%',
				'depends_show_if'=> 'on',
				'show_if'        => array(
					'dnxtiep_uih_content_gradient_show_hide' => 'on',
					'dnxtiep_uih_image_hover_effect' => array(
						"effect-15",
						"effect-19"
					)
				)
			),
			'dnxtiep_uih_content_gradient_end_position'             => array(
				'label'           => esc_html__( 'End Position', 'et_builder' ),
				'type'            => 'range',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'dnxtiep_uih_background',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'range_settings'  => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 100,
				),
				'default'         => '100%',
				'depends_show_if'=> 'on',
				'fixed_unit'      => '%',
				'show_if'        => array(
					'dnxtiep_uih_content_gradient_show_hide' => 'on',
					'dnxtiep_uih_image_hover_effect' => array(
						"effect-15",
						"effect-19"
					)
				)
			),
			'dnxtiep_uih_focus_bg'	=> array(
				'label'          => esc_html__('Background Color', 'et_builder' ),
				'type'           => 'color-alpha',
				'toggle_slug'    => 'dnxtiep_uih_fonts',
				'sub_toggle'	 => 'sub_toggle_focus',
				'tab_slug'       => 'advanced',
				'depends_show_if'=> 'on',
			),
			'dnxtiep_uih_image_opacity'             => array(
				'label'           => esc_html__( 'Image Opacity', 'et_builder' ),
				'type'            => 'range',
				'option_category' => 'basic_option',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dnxtiep_uih_opacity',
				'range_settings'  => array(
					'step' => 0.1,
					'min'  => 0,
					'max'  => 1,
				),
				'default'         => '0.8',
				'fixed_unit'      => ' ',
			),
		);
	}

	public function get_advanced_fields_config() {
		return array(
			'fonts' => array(
				'hover_text_fonts' => array(
					'label'    		=> esc_html__( 'Heading', 'et_builder' ),
					'toggle_slug'   => 'dnxtiep_uih_fonts',
					'sub_toggle'    => 'sub_toggle_heading',
					'tab_slug'		=> 'advanced',
					'css'      => array(
						'main' => "%%order_class%% .dnext-neip-uih-main-heading",
						'text_align' => "%%order_class%% .dnext-neip-uih-des-heading",
						'important' => 'all'
					),
				),
				'dnxtiep_uih_body'   => array(
					'label'          => esc_html__( 'Description', 'et_builder' ),
					'css'            => array(
						'main'     => "%%order_class%% .dnext-neip-uih-des-pra",
						'important' => 'all'
					)
				),
				'hover_text_heading_bold' => array(
					'label'    		=> esc_html__( 'Focus', 'et_builder' ),
					'toggle_slug'   => 'dnxtiep_uih_fonts',
					'sub_toggle'    => 'sub_toggle_focus',
					'tab_slug'		=> 'advanced',
					'css'      => array(
						'main' => "%%order_class%% .dnext-neip-uih-focus-heading",
						'important' => 'all'
					),
				),
			),
			'text'  => false,
			'margin_padding' => array(
				'css' => array(
					'margin' => "%%order_class%% .dnext-neip-uih-grid figure",
					'padding' => "%%order_class%% .dnext-neip-uih-grid figure",
					'important' => 'all',
				),
			),
			'borders'               => array(
				'default' => array(
					'css'	=> array(
						'main'	=> array(
							'border_radii'  => "%%order_class%% .dnext-neip-uih-grid figure",
							'border_styles' => "%%order_class%% .dnext-neip-uih-grid figure",
						),
						'important' => 'all'
					)
				)
			),
			'box_shadow'	=> array(
				'default' => array(
					'css'             => array(
						'main'        => "%%order_class%% .dnext-neip-uih-grid figure",
					),
				),
			),
			'background'        => false
		);		
	}

	public function render( $attrs, $content, $render_slug ) {
		$multi_view 						= et_pb_multi_view_options( $this );
		$dnxtiep_uih_image					=	$this->props['dnxtiep_uih_image'];
		$dnxtiep_uih_alt					=	$this->props['dnxtiep_uih_alt'];

		$dnxtiep_uih_heading_text			=	$this->props['dnxtiep_uih_heading_text'];
		$dnxtiep_uih_heading_bold			=	$this->props['dnxtiep_uih_heading_bold'];
		$dnxtiep_uih_heading_hover			=	$this->props['dnxtiep_uih_heading_hover'];
		$dnxtiep_uih_heading_tag			=	$this->props['dnxtiep_uih_heading_tag'];
		$dnxtiep_uih_description			=	$this->props['dnxtiep_uih_description'];

		$dnxtiep_uih_hover_effect       	=   $this->props['dnxtiep_uih_image_hover_effect'];




		$diff_hover_effect = array(
			'effect-1',
			'effect-15'
		);

		$content_background = array(
			'effect-15',
			'effect-19',
		);

		$image_html = $multi_view->render_element( array(
			'tag'   => 'img',
			'attrs' => array(
				'src'   => '{{dnxtiep_uih_image}}',
				'alt'   => '{{dnxtiep_uih_alt}}',
			),
			'required' => 'dnxtiep_uih_image',
		) );


		// Image
		$dnxtiep_uih_img = sprintf(
			'%1$s',
			$image_html
		);

		// Heading Text
		$dnxtiepheadingtext = '';
		if ( '' !== $dnxtiep_uih_heading_text ){
			if($dnxtiep_uih_hover_effect === "effect-3"){
				$dnxtiepheadingtext = sprintf(
					'<%1$s class="dnext-neip-uih-des-heading"><span class="dnext-neip-uih-main-heading">%2$s</span> <span class="dnext-neip-uih-focus-heading">%3$s</span> <i class="dnext-neip-uih-main-heading">%4$s</i></%1$s>',
					et_pb_process_header_level( $dnxtiep_uih_heading_tag, 'span' ),
					et_core_esc_previously( $dnxtiep_uih_heading_text ),
					et_core_esc_previously( $dnxtiep_uih_heading_bold ),
					et_core_esc_previously( $dnxtiep_uih_heading_hover )
				);
			}else{
				$dnxtiepheadingtext = sprintf(
					'<%1$s class="dnext-neip-uih-des-heading"><span class="dnext-neip-uih-main-heading">%2$s</span> <span class="dnext-neip-uih-focus-heading">%3$s</span></%1$s>',
					et_pb_process_header_level( $dnxtiep_uih_heading_tag, 'span' ),
					et_core_esc_previously( $dnxtiep_uih_heading_text ),
					et_core_esc_previously( $dnxtiep_uih_heading_bold )
				);
			}
		}


		$desc = $multi_view->render_element( array(
			'tag'		=>	'div',
			'content'	=>	'{{dnxtiep_uih_description}}',
			'attrs'		=>	array(
				'class'	=> "effect-15" === $dnxtiep_uih_hover_effect ? 'dnext-neip-uih-descwrap' : 'dnext-neip-uih-des-pra',
			)
		));

		$final_desc = "";

		if("effect-15" === $dnxtiep_uih_hover_effect) {
			
			$final_desc = explode("<p>", $desc);
			$final_desc = implode("<p class='dnext-neip-uih-des-pra'>", $final_desc);

		}else {
			$final_desc = $desc;
		}

		// Content 
		$content = "";

		if( $dnxtiep_uih_hover_effect === "effect-1" ) {
			$content = sprintf(
				'<figcaption>
                	<div class="dnext-neip-uih-descwrap">
                        %1$s
                        %2$s
                    </div>
                </figcaption>',
                $dnxtiepheadingtext,
                $final_desc
			);
		}elseif($dnxtiep_uih_hover_effect === "effect-3"){
			$content = sprintf(
				'<figcaption>
                	<div class="dnext-neip-uih-descwrap">
                        %1$s
                    </div>
                </figcaption>',
                $dnxtiepheadingtext
			);
		}else {
			$content = sprintf(
				'<figcaption>
                        %1$s
                        %2$s
                </figcaption>',
                $dnxtiepheadingtext,
                $final_desc
			);
		}

		// EFFECT 4 DOWN BACKGROUND
		$dnxtiep_uih_bottom_bg = $this->props['dnxtiep_uih_bottom_bg'];

		if($dnxtiep_uih_hover_effect === "effect-3") {
			$dnxtiep_uih_bottom_bg_style = sprintf('background: %1$s', esc_attr__( $dnxtiep_uih_bottom_bg ));
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% figure.dnext-neip-uih-effect-3 figcaption::before",
				'declaration' => $dnxtiep_uih_bottom_bg_style,
			) );
		}
		// EFFECT 4 DOWN BACKGROUND END

		// BACKGROUND OVERLAY COLOR START
		$dnxtiep_uih_bg_overlay = $this->props['dnxtiep_uih_bg_overlay'];
		$dnxtiep_uih_bg_overlay_values = et_pb_responsive_options()->get_property_values( $this->props, 'dnxtiep_uih_bg_overlay' );
		$dnxtiep_uih_bg_overlay_tablet = isset( $dnxtiep_uih_bg_overlay_values['tablet']) ? $dnxtiep_uih_bg_overlay_values['tablet'] : '';
		$dnxtiep_uih_bg_overlay_phone = isset( $dnxtiep_uih_bg_overlay_values['phone']) ? $dnxtiep_uih_bg_overlay_values['phone'] : '';

		$dnxtiep_uih_bg_overlay_style = sprintf( 'background: %1$s !important;' , esc_attr( $dnxtiep_uih_bg_overlay ) );
		$dnxtiep_uih_bg_overlay_tablet_style = '' !== $dnxtiep_uih_bg_overlay_tablet ? sprintf( 'background: %1$s !important;' , esc_attr( $dnxtiep_uih_bg_overlay_tablet ) ) : '';
		$dnxtiep_uih_bg_overlay_phone_style = '' !== $dnxtiep_uih_bg_overlay_phone ? sprintf( 'background: %1$s !important;' , esc_attr( $dnxtiep_uih_bg_overlay_phone ) ) : '';
		
		ET_Builder_Element::set_style( $render_slug, array(
			'selector'    => "%%order_class%% .dnext-neip-uih-grid figure",
			'declaration' => $dnxtiep_uih_bg_overlay_style,
		) );

		ET_Builder_Element::set_style( $render_slug, array(
			'selector'    => "%%order_class%% .dnext-neip-uih-grid figure",
			'declaration' => $dnxtiep_uih_bg_overlay_tablet_style,
			'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
		) );

		ET_Builder_Element::set_style( $render_slug, array(
			'selector'    => "%%order_class%% .dnext-neip-uih-grid figure",
			'declaration' => $dnxtiep_uih_bg_overlay_phone_style,
			'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
		) );
		// BACKGROUND OVERLAY COLOR END



		// CONTENT BACKGROUND COLOR START
		$dnxtiep_uih_content_bg_color = $this->props['dnxtiep_uih_content_bg_color'];
		$dnxtiep_uih_content_bg_color_values = et_pb_responsive_options()->get_property_values( $this->props, 'dnxtiep_uih_content_bg_color' );
		$dnxtiep_uih_content_bg_color_tablet = isset( $dnxtiep_uih_content_bg_color_values['tablet']) ? $dnxtiep_uih_content_bg_color_values['tablet'] : '';
		$dnxtiep_uih_content_bg_color_phone = isset( $dnxtiep_uih_content_bg_color_values['phone'] ) ?  $dnxtiep_uih_content_bg_color_values['phone'] : '';

		$dnxtiep_uih_content_bg_color_style        = sprintf( 'background: %1$s !important;' , esc_attr( $dnxtiep_uih_content_bg_color ) );
		$dnxtiep_uih_content_bg_color_tablet_style = '' !== $dnxtiep_uih_content_bg_color_tablet ? sprintf( 'background: %1$s !important;' , esc_attr( $dnxtiep_uih_content_bg_color_tablet ) ) : '';
		$dnxtiep_uih_content_bg_color_phone_style = '' !== $dnxtiep_uih_content_bg_color_phone ? sprintf( 'background: %1$s !important;' , esc_attr( $dnxtiep_uih_content_bg_color_phone ) ) : '';

		if( in_array($dnxtiep_uih_hover_effect, $content_background) ){
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% figure.dnext-neip-uih-effect-19 .dnext-neip-uih-des-heading, figure.dnext-neip-uih-{$dnxtiep_uih_hover_effect} .dnext-neip-uih-des-pra",
				'declaration' => $dnxtiep_uih_content_bg_color_style,
			) );

			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% figure.dnext-neip-uih-effect-19 .dnext-neip-uih-des-heading, figure.dnext-neip-uih-{$dnxtiep_uih_hover_effect} .dnext-neip-uih-des-pra",
				'declaration' => $dnxtiep_uih_content_bg_color_tablet_style,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
			) );

			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% figure.dnext-neip-uih-effect-19 .dnext-neip-uih-des-heading, figure.dnext-neip-uih-{$dnxtiep_uih_hover_effect} .dnext-neip-uih-des-pra",
				'declaration' => $dnxtiep_uih_content_bg_color_phone_style,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
			) );
		}
		// CONTENT BACKGROUND COLOR END

		// CONTENT GRADIENT COLOR START 
		$dnxtiep_uih_content_gradient_color_one = $this->props['dnxtiep_uih_content_gradient_color_one'];
		$dnxtiep_uih_content_gradient_color_two = $this->props['dnxtiep_uih_content_gradient_color_two'];

		$dnxtiep_uih_content_gradient_type      = $this->props['dnxtiep_uih_content_gradient_type'];
		$dnxtiep_uih_content_gradient_start     = $this->props['dnxtiep_uih_content_gradient_start_position'];
		$dnxtiep_uih_content_gradient_end     	= $this->props['dnxtiep_uih_content_gradient_end_position'];

		$dnxtiep_uih_content_gradient_direction = $dnxtiep_uih_content_gradient_type === 'linear-gradient' ? $this->props['dnxtiep_uih_content_gradient_type_linear_direction'] : $this->props['dnxtiep_uih_content_gradient_type_radial_direction'];

		if( 'off' !== $this->props['dnxtiep_uih_content_gradient_show_hide'] ) {
				$dnxtiep_uih_content_gradient = sprintf('background: %1$s(%2$s, %3$s %5$s, %4$s %6$s) !important;',$dnxtiep_uih_content_gradient_type, $dnxtiep_uih_content_gradient_direction, esc_attr($dnxtiep_uih_content_gradient_color_one), esc_attr($dnxtiep_uih_content_gradient_color_two), $dnxtiep_uih_content_gradient_start, $dnxtiep_uih_content_gradient_end);

				if( in_array($dnxtiep_uih_hover_effect, $content_background) ){
					ET_Builder_Element::set_style( $render_slug, array(
						'selector'    => "%%order_class%% figure.dnext-neip-uih-effect-19 .dnext-neip-uih-des-heading, figure.dnext-neip-uih-{$dnxtiep_uih_hover_effect} .dnext-neip-uih-des-pra",
						'declaration' => $dnxtiep_uih_content_gradient,
					) );
				}
		}
		// CONTENT GRADIENT COLOR END

		// FOCUS TEXT BACKGROUND COLOR
		
		$dnxtiep_uih_focus_bg = $this->props['dnxtiep_uih_focus_bg'];
		$dnxtiep_uih_focus_bg_values = et_pb_responsive_options()->get_property_values( $this->props, 'dnxtiep_uih_focus_bg' );
		$dnxtiep_uih_focus_bg_tablet = isset( $dnxtiep_uih_focus_bg_values['tablet']) ? $dnxtiep_uih_focus_bg_values['tablet'] : '';
		$dnxtiep_uih_focus_bg_phone = isset( $dnxtiep_uih_focus_bg_values['phone'] ) ?  $dnxtiep_uih_focus_bg_values['phone'] : '';

		$dnxtiep_uih_focus_bg_style = sprintf( 'background: %1$s' , esc_attr( $dnxtiep_uih_focus_bg ) );
		$dnxtiep_uih_focus_bg_tablet_style = '' !== $dnxtiep_uih_bg_overlay_tablet ? sprintf( 'background: %1$s' , esc_attr( $dnxtiep_uih_focus_bg_tablet ) ) : '';
		$dnxtiep_uih_focus_bg_phone_style = '' !== $dnxtiep_uih_focus_bg_phone ? sprintf( 'background: %1$s' , esc_attr( $dnxtiep_uih_focus_bg_phone ) ) : '';

		ET_Builder_Element::set_style( $render_slug, array(
			'selector'    => "%%order_class%% .dnext-neip-uih-grid figure .dnext-neip-uih-focus-heading",
			'declaration' => $dnxtiep_uih_focus_bg_style,
		) );

		ET_Builder_Element::set_style( $render_slug, array(
			'selector'    => "%%order_class%% .dnext-neip-uih-grid figure .dnext-neip-uih-focus-heading",
			'declaration' => $dnxtiep_uih_focus_bg_tablet_style,
			'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
		) );

		ET_Builder_Element::set_style( $render_slug, array(
			'selector'    => "%%order_class%% .dnext-neip-uih-grid figure .dnext-neip-uih-focus-heading",
			'declaration' => $dnxtiep_uih_focus_bg_phone_style,
			'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
		) );
		// FOCUS TEXT BACKGROUND COLOR


		// BACKGROUND OVERLAY GRADIENT COLOR START 
		$dnxtiep_uih_bg_overlay_gradient_color_one = $this->props['dnxtiep_uih_bg_overlay_gradient_color_one'];
		$dnxtiep_uih_bg_overlay_gradient_color_two = $this->props['dnxtiep_uih_bg_overlay_gradient_color_two'];

		$dnxtiep_uih_bg_overlay_gradient_type      = $this->props['dnxtiep_uih_bg_overlay_gradient_type'];
		$dnxtiep_uih_bg_overlay_gradient_start     = $this->props['dnxtiep_uih_bg_overlay_gradient_start_position'];
		$dnxtiep_uih_bg_overlay_gradient_end     	= $this->props['dnxtiep_uih_bg_overlay_gradient_end_position'];

		$dnxtiep_uih_bg_overlay_gradient_direction = $dnxtiep_uih_bg_overlay_gradient_type === 'linear-gradient' ? $this->props['dnxtiep_uih_bg_overlay_gradient_type_linear_direction'] : $this->props['dnxtiep_uih_bg_overlay_gradient_type_radial_direction'];

		if( 'off' !== $this->props['dnxtiep_uih_bg_overlay_gradient_show_hide'] ) {
				$dnxtiep_uih_bg_overlay_gradient = sprintf('background: %1$s(%2$s, %3$s %5$s, %4$s %6$s) !important;',$dnxtiep_uih_bg_overlay_gradient_type, $dnxtiep_uih_bg_overlay_gradient_direction, esc_attr($dnxtiep_uih_bg_overlay_gradient_color_one), esc_attr($dnxtiep_uih_bg_overlay_gradient_color_two), $dnxtiep_uih_bg_overlay_gradient_start, $dnxtiep_uih_bg_overlay_gradient_end);

				if($dnxtiep_uih_hover_effect === "effect-2"){

					ET_Builder_Element::set_style( $render_slug, array(
						'selector'    => "%%order_class%% figure.dnext-neip-uih-effect-2 figcaption::before",
						'declaration' => $dnxtiep_uih_bg_overlay_gradient,
					) );
				}else{
					ET_Builder_Element::set_style( $render_slug, array(
						'selector'    => "%%order_class%% .dnext-neip-uih-grid figure",
						'declaration' => $dnxtiep_uih_bg_overlay_gradient,
					) );
				}
		}
		// BACKGROUND OVERLAY GRADIENT COLOR END


		// OPACITY MANAGE START
		$dnxtiep_uih_image_opacity = $this->props['dnxtiep_uih_image_opacity'];
		$dnxtiep_uih_image_opacity_style = sprintf('opacity: %1$s !important;', $dnxtiep_uih_image_opacity);

		ET_Builder_Element::set_style( $render_slug, array(
			'selector'    => "%%order_class%% .dnext-neip-uih-grid figure:hover img",
			'declaration' => $dnxtiep_uih_image_opacity_style,
		) );


		// OPACITY MANAGE END

		$this->apply_css($render_slug);
		return sprintf(
			'<div class="dnext-neip-uih-grid">
                <figure class="dnext-neip-uih-%3$s">
                    %1$s			
                    %2$s			
                </figure>
            </div>',
            $dnxtiep_uih_img,
            $content,
            $dnxtiep_uih_hover_effect
		);
	}


	public function apply_css($render_slug){

		/**
		 * Custom Padding Margin Output
		 *
		*/
		Common::dnxt_set_style($render_slug, $this->props, "dnxtiep_uih_heading_margin", "%%order_class%% .dnext-neip-uih-des-heading", "margin");
		Common::dnxt_set_style($render_slug, $this->props, "dnxtiep_uih_heading_padding", "%%order_class%% .dnext-neip-uih-des-heading", "padding");
		Common::dnxt_set_style($render_slug, $this->props, "dnxtiep_uih_focus_padding", "%%order_class%% .dnext-neip-uih-focus-heading", "padding");

		Common::dnxt_set_style($render_slug, $this->props, "dnxtiep_uih_description_margin", "%%order_class%% .dnext-neip-uih-des-pra", "margin");
		Common::dnxt_set_style($render_slug, $this->props, "dnxtiep_uih_description_padding", "%%order_class%% .dnext-neip-uih-des-pra", "padding");
	}
}

new Next_Ultimate_Image_Hover;
