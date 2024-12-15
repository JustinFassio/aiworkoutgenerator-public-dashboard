<?php
include_once(DIVI_ESSENTIAL_PATH.'/includes/modules/base/Common.php');

class Next_Mega_Image_Effect extends ET_Builder_Module {

	public $slug       = 'dnxte_mega_image_effect';
	public $vb_support = 'on';

	protected $module_credits = array(
		'module_uri' => 'https://www.diviessential.com/divi-mega-image-effect/',
		'author'     => 'Divi Next',
		'author_uri' => 'www.divinext.com',
	);

	public function init() {
		$this->name 		= esc_html__( 'Next Mega Image Effect', 'et_builder' );
		$this->icon_path 	= plugin_dir_path( __FILE__ ) . 'icon.svg';
		$this->folder_name = 'et_pb_divi_essential';

		$this->settings_modal_toggles = array(
			'general'	=> array(
				'toggles'		=>	array(
					'dnxtiep_img'	=> array(
						'title'		=> esc_html__( 'Image', 'et_builder' ),
						'priority'	=>	10,
					),
					'dnxtiep_btn'	=> array(
						'title'		=> esc_html__( 'Button', 'et_builder' ),
						'priority'	=>	20,
					),
					'dnxtiep_background'	=> array(
						'title'		=>	esc_html__( 'Hover Background', 'et_builder' ),
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
					'dnxtiep_btn_bg'	=> array(
						'title'		=>	esc_html__( 'Button Background', 'et_builder' ),
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
			'advanced'	=> array(
				'toggles'	=>	array(
					'dnxtiep_hover_effect'	=> esc_html__( 'Hover Effect', 'et_builder' ),
					'dnxtiep_button_icon'	=> array(
						"title"		=>	esc_html__( 'Button Icon', 'et_builder' ),
						'priority'	=>	61,
					),
					'dnxtiep_btn_border'	=> array(
						'title'		=> esc_html__( 'Button Border', 'et_builder' ),
						'priority'	=> 61,
					),
					'dnxtiep_fonts'	=> array(
						"title"		=>	esc_html__( 'Heading Fonts', 'et_builder' ),
					),
					'dnxtiep_btn_font'	=> array(
						"title"		=>	esc_html__( 'Button Text', 'et_builder' ),
						'priority'	=>	60,
					),
					'dnxtiep_btn_alingment'	=> array(
						"title"		=>	esc_html__( 'Button Alignment', 'et_builder' ),
						'priority'	=>	60,
					),
				), 
			),			
			'custom_css' => array(
				'toggles' => array(),
			),
		);

		// Custom CSS Field
		$this->custom_css_fields = array(
			'dnxtiep_image' => array(
				'label'    => esc_html__( 'Image', 'et_builder' ),
				'selector' => '%%order_class%% .dnxtiep-imghvr-wrapper img',
			),
			'dnxtiep_caption' => array(
				'label'    => esc_html__( 'Hover Content', 'et_builder' ),
				'selector' => '%%order_class%% [class^="imghvr-"] figcaption',
			),
			'dnxtiep_heading' => array(
				'label'    => esc_html__( 'Heading', 'et_builder' ),
				'selector' => '%%order_class%% .dnxtiep-heading',
			),
			'dnxtiep_description' => array(
				'label'    => esc_html__( 'Description', 'et_builder' ),
				'selector' => '%%order_class%% [class^="imghvr-"] figcaption p',
			),
			'dnxtiep_hover_btn' => array(
				'label'    => esc_html__( 'Button', 'et_builder' ),
				'selector' => '%%order_class%% .dnxt-nie-uih-btn',
			),
		);
	}

	public function get_advanced_fields_config() {
		$advanced_fields = array();
		$advanced_fields = array(
			'fonts' => array(
				'hover_text_fonts' => array(
					'label'    		=> esc_html__( '', 'et_builder' ),
					'toggle_slug'   => 'dnxtiep_fonts',
					'tab_slug'		=> 'advanced',
					'css'      => array(
						'main' => "%%order_class%% .dnxtiep-heading",
					),
				),
				'dnxtiep_body'   => array(
					'label'          => esc_html__( 'Description', 'et_builder' ),
					'css'            => array(
						'line_height' => "%%order_class%% .dnxtiep-description p",
						'text_align'  => "%%order_class%% .dnxtiep-description",
						'text_shadow' => "%%order_class%% .dnxtiep-description p",
					),
					'block_elements' => array(
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
						'css'               => array(
							'main' => "%%order_class%% .dnxtiep-description p",
						),
					),
				),
				'dnxtiep_btn_text' => array(
					'label'    			=> esc_html__( '', 'et_builder' ),
					'toggle_slug'   	=> 'dnxtiep_btn_font',
					'hide_text_align'	=> 'true',
					'tab_slug'			=> 'advanced',
					'css'      => array(
						'main' => "%%order_class%% .dnxtiep-imghvr-content .dnxt-nie-uih-btn",
						'text_align'  => "%%order_class%% .dnxtiep-button",
					),
				),
			),
			'text'	=> false,
			'margin_padding' => array(
				'css' => array(
					'main' => "%%order_class%% .dnxtiep-imghvr-wrapper",
					'important' => 'all',
				),	
			),
			'borders'               => array(
				'default' => array(
					'css'	=> array(
						'main'	=> array(
							'border_radii'  => '%%order_class%% .dnxtiep-imghvr-wrapper',
							'border_styles' => '%%order_class%% .dnxtiep-imghvr-wrapper',
						),
					),
					'defaults'        => array(
						'border_radii'  => 'on|3px|3px|3px|3px',
						'border_styles' => array(
							'width' => '2px',
							'color' => '#0077FF',
							'style' => 'solid',
						),
					),
				),
				'button_border'     => array(
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'dnxtiep_btn_border',
					'css'          => array(
						'main'     => array(
							'border_radii'  		=> "%%order_class%% .dnxt-nie-uih-btn",
							'border_radii_hover'  	=> '%%order_class%%:hover .dnxt-nie-uih-btn',
							'border_styles' 		=> "%%order_class%% .dnxt-nie-uih-btn",
							'border_styles_hover' 	=> '%%order_class%%:hover .dnxt-nie-uih-btn',
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
				'css'   => array(
					'main' => "%%order_class%% .dnxtiep-imghvr-wrapper",
					'important' => true,
				),
			),
			'box_shadow'	=> array(
				'default' => array(
					'css'                 => array(
						'main'        => "%%order_class%% .dnxtiep-imghvr-wrapper",
						'hover'       => '%%order_class%%:hover .dnxtiep-imghvr-wrapper',
						'overlay'     => 'inset',
					),
				),
			),
			'height' => array(
				'css' => array(
					'main'     => "%%order_class%% .dnxtiep-imghvr-wrapper",
					'important' => 'all',                
				),	
			),

		);

		return $advanced_fields;
	}

	public function get_fields() {
		return array(
			// Image
			'dnxtiep_image'				=> array(
				'label'              	=> esc_html__( 'Image', 'et_builder' ),
				'type'               	=> 'upload',
				'option_category'    	=> 'basic_option',
				'upload_button_text' 	=> esc_attr__( 'Upload an image', 'et_builder' ),
				'choose_text'        	=> esc_attr__( 'Choose an Image', 'et_builder' ),
				'update_text'        	=> esc_attr__( 'Set As Image', 'et_builder' ),
				'description'        	=> esc_html__( 'Upload an image to display at the top of your blurb.', 'et_builder' ),
				'toggle_slug'        	=> 'dnxtiep_img',
				'dynamic_content'    	=> 'image',
				'mobile_options'    	=> true,
				'hover'					=> 'tabs',
			),
			// Image alt
			'dnxtiep_alt'			=> array(
				'label'           	=> esc_html__( 'Image Alt Text', 'et_builder' ),
				'type'            	=> 'text',
				'option_category' 	=> 'basic_option',
				'description'     	=> esc_html__( 'Define the HTML ALT text for your image here.', 'et_builder' ),
				'toggle_slug'     	=> 'dnxtiep_img',
				'dynamic_content' 	=> 'text',
			),
			// Heading Text
			'dnxtiep_heading_text'	=> array(
				'label'           	=> esc_html__( 'Heading Text', 'et_builder' ),
				'type'            	=> 'text',
				'dynamic_content' 	=> 'text',
				'option_category' 	=> 'basic_option',
				'description'     	=> esc_html__( 'Heading Text entered here will appear inside the module.', 'et_builder' ),
				'toggle_slug'     	=> 'main_content',
			),
			//Heading Tag
			'dnxtiep_heading_tag'	=> array(
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
			'dnxtiep_description' 	=> array(
				'label'           	=> esc_html__( 'Content', 'et_builder' ),
				'type'            	=> 'tiny_mce',
				'dynamic_content' 	=> 'text',
				'option_category' 	=> 'basic_option',
				'description'     	=> esc_html__( 'Content entered here will appear inside the module.', 'et_builder' ),
				'toggle_slug'     	=> 'main_content',
			),
			'dnxtiep_btn_show_hide' => array(
				'label'           	=> esc_html__( 'Button Show Hide', 'et_builder' ),
				'type'            	=> 'yes_no_button',
				'options'         	=> array(
					'off' => esc_html__( 'No', 'et_builder' ),
					'on'  => esc_html__( 'Yes', 'et_builder' ),
				),
				'toggle_slug'     	=> 'dnxtiep_btn',
				'affects'         	=> array(
					'dnxtiep_button_text',
					'dnxtiep_button_link',
					'dnxtiep_button_link_new_window',
					'dnxtiep_btn_switch',
					'dnxtiep_btn_bg_show_hide',
					'dnxtiep_btn_gradient_show_hide',
					'dnxtiep_btn_margin',
					'dnxtiep_btn_padding',
					'dnxtiep_btn_align'
				),
				'default_on_front'	=> 'off',
			),
			// Button Title Field
			'dnxtiep_button_text'      		=> array(
				'label'           	=> esc_html__( 'Button Text', 'et_builder' ),
				'type'            	=> 'text',
				'dynamic_content' 	=> 'text',
				'default'         	=> 'Button Text',
				'option_category' 	=> 'basic_option',
				'toggle_slug'     	=> 'dnxtiep_btn',
				'depends_show_if' 	=> 'on',
			),
			// Button Link Field
			'dnxtiep_button_link'   => array(
				'label'           	=> esc_html__( 'Button Link', 'et_builder' ),
				'description'     	=> esc_html__( 'When clicked the module will link to this URL.', 'et_builder' ),
				'type'            	=> 'text',
				'option_category' 	=> 'configuration',
				'toggle_slug'     	=> 'dnxtiep_btn',
				'dynamic_content' 	=> 'url',
				'depends_show_if' 	=> 'on',
			),
			// Button Link Target Field
			'dnxtiep_button_link_new_window'=> array(
				'label'						=> esc_html__( 'Button Link Target', 'et_builder' ),
				'description'      			=> esc_html__( 'Here you can choose whether or not your link opens in a new window', 'et_builder' ),
				'type'             			=> 'select',
				'option_category'  			=> 'configuration',
				'options'         			=> array(
					'off' => esc_html__( 'In The Same Window', 'et_builder' ),
					'on'  => esc_html__( 'In The New Tab', 'et_builder' ),
				),
				'toggle_slug'      			=> 'dnxtiep_btn',
				'default_on_front' 			=> 'off',
				'depends_show_if'  			=> 'on',
			),
			// Button Show & Hide
			'dnxtiep_btn_switch'	=> array(
				'label'           	=> esc_html__( 'Show Icon', 'et_builder' ),
				'description'     	=> esc_html__( 'When enabled, this will add a custom icon within the button.', 'et_builder' ),
				'type'            	=> 'yes_no_button',
				'tab_slug'        	=> 'advanced',
				'toggle_slug'     	=> 'dnxtiep_button_icon',
				'default'         	=> 'on',
				'options'         	=> array(
					'on'      => esc_html__( 'Yes', 'et_builder' ),
					'off'     => esc_html__( 'No', 'et_builder' ),
				),
				'affects'         	=> array(
					"dnxtiep_btn_icon",
					"dnxtiep_btn_icon_color",
					"dnxtiep_btn_icon_placement",
					"dnxtiep_btn_on_hover",
				),
				'depends_show_if' => 'on',
			),
			// Button Icon
			'dnxtiep_btn_icon'			=> array(
				'label'               	=> esc_html__( 'Button Icon', 'et_builder' ),
				'description'         	=> esc_html__( 'Pick a color to be used for the button icon.', 'et_builder' ),
				'type'                	=> 'select_icon',
				'tab_slug'            	=> 'advanced',
				'toggle_slug'         	=> 'dnxtiep_button_icon',
				'class'               	=> array( 'et-pb-font-icon' ),
				'default'             	=> '$',
				'mobile_options'    	=> true,
				'depends_show_if_not' 	=> 'off',
				'responsive'			=> true,
				'mobile_options' 		=> true
			),
			// Button Icon Color
			'dnxtiep_btn_icon_color'	=>	array(
				'label'               	=> esc_html__( 'Button Icon Color', 'et_builder' ),
				'description'         	=> esc_html__( 'Here you can define a custom color for the button icon.', 'et_builder' ),
				'type'                	=> 'color-alpha',
				'tab_slug'            	=> 'advanced',
				'toggle_slug'         	=> 'dnxtiep_button_icon',
				'custom_color'        	=> true,
				'default'			  	=> '#2857b6',
				'hover'             	=> 'tabs',
				'mobile_options'    	=> true,
				'depends_show_if_not' 	=> 'off',
			),
			// Button Icon Placement
			'dnxtiep_btn_icon_placement'	=>	array(
				'label'               => esc_html__( 'Button Icon Placement', 'et_builder' ),
				'description'         => esc_html__( 'Choose where the button icon should be displayed within the button.', 'et_builder' ),
				'type'                => 'select',
				'tab_slug'            => 'advanced',
				'toggle_slug'         => 'dnxtiep_button_icon',
				'options'             => array(
					'right' => esc_html__( 'Right', 'et_builder' ),
					'left'  => esc_html__( 'Left', 'et_builder' ),
				),
				'default'             => 'right',
				'depends_show_if_not' => 'off',
			),
			// Button Icon On Hover
			'dnxtiep_btn_on_hover'	=>	array(
				'label'               => esc_html__( 'Only Show Icon On Hover for Button', 'et_builder' ),
				'description'         => esc_html__( 'By default, button icons are displayed on hover. If you would like button icons to always be displayed, then you can enable this option.', 'et_builder' ),
				'type'                => 'yes_no_button',
				'tab_slug'            => 'advanced',
				'toggle_slug'         => 'dnxtiep_button_icon',
				'default'             => 'on',
				'options'             => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'depends_show_if_not' => 'off',
			),
			// Image Hover Effect
			'dnxtiep_image_hover_effect'=> array(
				'label'             	=> esc_html__( 'Select Image Hover', 'et_builder' ),
				'type'              	=> 'select',
				'option_category'   	=> 'configuration',
				'tab_slug'          	=> 'advanced',
				'toggle_slug'       	=> 'dnxtiep_hover_effect',
				'default'           	=> 'push-up',
				'description'       	=> esc_html__( 'Here you can adjust the hover effect.', 'et_builder' ),
				'options'           	=> array(
					'push-up'   				=>  esc_html__( 'Push Up', 'et_builder' ),
					'push-down'					=>  esc_html__( 'Push Down', 'et_builder' ),
					'push-left'   				=>  esc_html__( 'Push Left', 'et_builder' ),
					'push-right'   				=>  esc_html__( 'Push Right', 'et_builder' ),
					'slide-up'   				=>  esc_html__( 'Slide Up', 'et_builder' ),
					'slide-down'   				=>  esc_html__( 'Slide Down', 'et_builder' ),
					'slide-left'   				=>  esc_html__( 'Slide Left', 'et_builder' ),
					'slide-right'   			=>  esc_html__( 'Slide Right', 'et_builder' ),
					'slide-top-left'   			=>  esc_html__( 'Slide Top Left', 'et_builder' ),
					'slide-top-right'   		=>  esc_html__( 'Slide Top Right', 'et_builder' ),
					'slide-bottom-left' 		=>  esc_html__( 'Slide Bottom Left', 'et_builder' ),
					'slide-bottom-right'		=>  esc_html__( 'Slide Bottom Right', 'et_builder' ),
					'reveal-up'   				=>  esc_html__( 'Reveal Up', 'et_builder' ),
					'reveal-down'   			=>  esc_html__( 'Reveal Down', 'et_builder' ),
					'reveal-left'   			=>  esc_html__( 'Reveal Left', 'et_builder' ),
					'reveal-right'   			=>  esc_html__( 'Reveal Right', 'et_builder' ),
					'reveal-top-left'   		=>  esc_html__( 'Reveal Top Left', 'et_builder' ),
					'reveal-top-right'  		=>  esc_html__( 'Reveal Top Right', 'et_builder' ),
					'reveal-bottom-left'		=>  esc_html__( 'Reveal Bottom Left', 'et_builder' ),
					'reveal-bottom-right'		=>  esc_html__( 'Reveal Bottom Right', 'et_builder' ),
					'fade'   					=>  esc_html__( 'Fade', 'et_builder' ),
					'fade-in-up'   				=>  esc_html__( 'Fade In Up', 'et_builder' ),
					'fade-in-down'   			=>  esc_html__( 'Fade In Down', 'et_builder' ),
					'fade-in-left'   			=>  esc_html__( 'Fade In Left', 'et_builder' ),
					'fade-in-right'   			=>  esc_html__( 'Fade In Right', 'et_builder' ),
					'hinge-up'   				=>  esc_html__( 'Hinge Up', 'et_builder' ),
					'hinge-down'   				=>  esc_html__( 'Hinge Down', 'et_builder' ),
					'hinge-left'   				=>  esc_html__( 'Hinge Left', 'et_builder' ),
					'hinge-right'   			=>  esc_html__( 'Hinge Right', 'et_builder' ),
					'flip-horiz'   				=>  esc_html__( 'Flip Horizontal', 'et_builder' ),
					'flip-vert'   				=>  esc_html__( 'Flip Vertical', 'et_builder' ),
					'flip-diag-1'   			=>  esc_html__( 'Flip Diag 1', 'et_builder' ),
					'flip-diag-2'   			=>  esc_html__( 'Flip Diag 2', 'et_builder' ),
					'shutter-out-horiz'   		=>  esc_html__( 'Shutter Out Horizontal', 'et_builder' ),
					'shutter-out-vert'   		=>  esc_html__( 'Shutter Out Vertical', 'et_builder' ),
					'shutter-out-diag-1'   		=>  esc_html__( 'Shutter Out Diag 1', 'et_builder' ),
					'shutter-out-diag-2'   		=>  esc_html__( 'Shutter Out Diag 2', 'et_builder' ),
					'shutter-in-horiz'   		=>  esc_html__( 'Shutter In Horizontal', 'et_builder' ),
					'shutter-in-vert'   		=>  esc_html__( 'Shutter In Vertical', 'et_builder' ),
					'shutter-in-out-horiz'   	=>  esc_html__( 'Shutter In Out Horizontal', 'et_builder' ),
					'shutter-in-out-vert'   	=>  esc_html__( 'Shutter In Out Vertical', 'et_builder' ),
					'shutter-in-out-diag-1'   	=>  esc_html__( 'Shutter In Out Diag 1', 'et_builder' ),
					'shutter-in-out-diag-2'   	=>  esc_html__( 'Shutter In Out Diag 2', 'et_builder' ),
					'fold-up'   				=>  esc_html__( 'Fold Up', 'et_builder' ),
					'fold-down'   				=>  esc_html__( 'Fold Down', 'et_builder' ),
					'fold-left'   				=>  esc_html__( 'Fold Left', 'et_builder' ),
					'fold-right'   				=>  esc_html__( 'Fold Right', 'et_builder' ),
					'zoom-in'   				=>  esc_html__( 'Zoom In', 'et_builder' ),
					'zoom-out'   				=>  esc_html__( 'Zoom Out', 'et_builder' ),
					'zoom-out-up'   			=>  esc_html__( 'Zoom Out Up', 'et_builder' ),
					'zoom-out-down'   			=>  esc_html__( 'Zoom Out Down', 'et_builder' ),
					'zoom-out-left'   			=>  esc_html__( 'Zoom Out Left', 'et_builder' ),
					'zoom-out-right'   			=>  esc_html__( 'Zoom Out Right', 'et_builder' ),
					'zoom-out-flip-horiz'   	=>  esc_html__( 'Zoom Out Flip Horizontal', 'et_builder' ),
					'zoom-out-flip-vert'   		=>  esc_html__( 'Zoom Out Flip Vertical', 'et_builder' ),
					'blur'   					=>  esc_html__( 'Blur', 'et_builder' ),
					'blocks-rotate-left'   		=>  esc_html__( 'Blocks Rotate Left', 'et_builder' ),
					'blocks-rotate-right'   	=>  esc_html__( 'Blocks Rotate Right', 'et_builder' ),
					'blocks-rotate-in-left'   	=>  esc_html__( 'Blocks Rotate  In Left', 'et_builder' ),
					'blocks-rotate-in-right'   	=>  esc_html__( 'Blocks Rotate  In Right', 'et_builder' ),
					'blocks-in'   				=>  esc_html__( 'Blocks In', 'et_builder' ),
					'blocks-out'   				=>  esc_html__( 'Blocks Out', 'et_builder' ),
					'blocks-float-up'   		=>  esc_html__( 'Blocks Float Up', 'et_builder' ),
					'blocks-float-down'   		=>  esc_html__( 'Blocks Float Down', 'et_builder' ),
					'blocks-float-left'   		=>  esc_html__( 'Blocks Float Left', 'et_builder' ),
					'blocks-float-right'   		=>  esc_html__( 'Blocks Float Right', 'et_builder' ),
					'blocks-zoom-top-left'   	=>  esc_html__( 'Blocks Zoom Top Left', 'et_builder' ),
					'blocks-zoom-top-right'   	=>  esc_html__( 'Blocks Zoom Top Right', 'et_builder' ),
					'blocks-zoom-bottom-left'   =>  esc_html__( 'Blocks Zoom Bottom Left', 'et_builder' ),
					'blocks-zoom-bottom-right'  =>  esc_html__( 'Blocks Zoom Bottom Right', 'et_builder' ),
					'strip-shutter-up'   		=>  esc_html__( 'Strip Shutter Up', 'et_builder' ),
					'strip-shutter-down'   		=>  esc_html__( 'Strip Shutter Down', 'et_builder' ),
					'strip-shutter-left'   		=>  esc_html__( 'Strip Shutter Left', 'et_builder' ),
					'strip-shutter-right'   	=>  esc_html__( 'Strip Shutter Right', 'et_builder' ),
					'strip-horiz-up'   			=>  esc_html__( 'Strip Horizontal Up', 'et_builder' ),
					'strip-horiz-down'   		=>  esc_html__( 'Strip Horizontal Down', 'et_builder' ),
					'strip-horiz-top-left'   	=>  esc_html__( 'Strip Horizontal Top Left', 'et_builder' ),
					'strip-horiz-top-right'   	=>  esc_html__( 'Strip Horizontal Top Right', 'et_builder' ),
					'strip-horiz-bottom-left'   =>  esc_html__( 'Strip Horizontal Bottom Left', 'et_builder' ),
					'strip-horiz-bottom-right'  =>  esc_html__( 'Strip Horizontal Bottom Right', 'et_builder' ),
					'strip-vert-left'   		=>  esc_html__( 'Strip Vertical Left', 'et_builder' ),
					'strip-vert-right'   		=>  esc_html__( 'Strip Vertical Right', 'et_builder' ),
					'strip-vert-top-left'   	=>  esc_html__( 'Strip Vertical Top Left', 'et_builder' ),
					'strip-vert-top-right'   	=>  esc_html__( 'Strip Vertical Top Right', 'et_builder' ),
					'strip-vert-bottom-left'   	=>  esc_html__( 'Strip Vertical Bottom Left', 'et_builder' ),
					'strip-vert-bottom-right'   =>  esc_html__( 'Strip Vertical Bottom Right', 'et_builder' ),
					'pixel-up'   				=>  esc_html__( 'Pixel Up', 'et_builder' ),
					'pixel-down'   				=>  esc_html__( 'Pixel Down', 'et_builder' ),
					'pixel-left'   				=>  esc_html__( 'Pixel Left', 'et_builder' ),
					'pixel-right'   			=>  esc_html__( 'Pixel Right', 'et_builder' ),
					'pixel-top-left'   			=>  esc_html__( 'Pixel Top Left', 'et_builder' ),
					'pixel-top-right'   		=>  esc_html__( 'Pixel Top Right', 'et_builder' ),
					'pixel-bottom-left'   		=>  esc_html__( 'Pixel Bottom Left', 'et_builder' ),
					'pixel-bottom-right'   		=>  esc_html__( 'Pixel Bottom Right', 'et_builder' ),
					'pivot-in-top-left'   		=>  esc_html__( 'Pivot In Top Left', 'et_builder' ),
					'pivot-in-top-right'   		=>  esc_html__( 'Pivot In Top Right', 'et_builder' ),
					'pivot-in-bottom-left'   	=>  esc_html__( 'Pivot In Bottom Left', 'et_builder' ),
					'pivot-in-bottom-right'   	=>  esc_html__( 'Pivot In Bottom Right', 'et_builder' ),
					'pivot-out-top-left'   		=>  esc_html__( 'Pivot Out Top Left', 'et_builder' ),
					'pivot-out-top-right'   	=>  esc_html__( 'Pivot Out Top Right', 'et_builder' ),
					'pivot-out-bottom-left'   	=>  esc_html__( 'Pivot Out Bottom Left', 'et_builder' ),
					'pivot-out-bottom-right'   	=>  esc_html__( 'Pivot Out Bottom Right', 'et_builder' ),
					'throw-in-up'   			=>  esc_html__( 'Throw In Up', 'et_builder' ),
					'throw-in-down'   			=>  esc_html__( 'Throw In Down', 'et_builder' ),
					'throw-in-left'   			=>  esc_html__( 'Throw In Left', 'et_builder' ),
					'throw-in-right'   			=>  esc_html__( 'Throw In Right', 'et_builder' ),
					'throw-out-up'   			=>  esc_html__( 'Throw Out Up', 'et_builder' ),
					'throw-out-down'   			=>  esc_html__( 'Throw Out Down', 'et_builder' ),
					'throw-out-left'   			=>  esc_html__( 'Throw Out Left', 'et_builder' ),
					'throw-out-right'   		=>  esc_html__( 'Throw Out Right', 'et_builder' ),
					'blinds-horiz'   			=>  esc_html__( 'Blinds Horizontal', 'et_builder' ),
					'blinds-vert'   			=>  esc_html__( 'Blinds Vertical', 'et_builder' ),
					'blinds-up'   				=>  esc_html__( 'Blinds Up', 'et_builder' ),
					'blinds-down'   			=>  esc_html__( 'Blinds Down', 'et_builder' ),
					'blinds-left'   			=>  esc_html__( 'Blinds Left', 'et_builder' ),
					'blinds-right'   			=>  esc_html__( 'Blinds Right', 'et_builder' ),
					'border-reveal'   			=>  esc_html__( 'Border Reveal', 'et_builder' ),
					'border-reveal-vert'   		=>  esc_html__( 'Border Reveal Vertical', 'et_builder' ),
					'border-reveal-horiz'   	=>  esc_html__( 'Border Reveal Horizontal', 'et_builder' ),
					'border-reveal-corners-1'   =>  esc_html__( 'Border Reveal Corners 1', 'et_builder' ),
					'border-reveal-corners-2'   =>  esc_html__( 'Border Reveal Corners 2', 'et_builder' ),
					'border-reveal-top-left'   	=>  esc_html__( 'Border Reveal Top Left', 'et_builder' ),
					'border-reveal-top-right'   =>  esc_html__( 'Border Reveal Top Right', 'et_builder' ),
					'border-reveal-bottom-left' =>  esc_html__( 'Border Reveal Bottom Left', 'et_builder' ),
					'border-reveal-bottom-right'=>  esc_html__( 'Border Reveal Bottom Right', 'et_builder' ),
					'border-reveal-cc-1'   		=>  esc_html__( 'Border Reveal Corner 1', 'et_builder' ),
					'border-reveal-ccc-1'   	=>  esc_html__( 'Border Reveal Corner 2', 'et_builder' ),
					'border-reveal-cc-2'   		=>  esc_html__( 'Border Reveal Corner 3', 'et_builder' ),
					'border-reveal-ccc-2'   	=>  esc_html__( 'Border Reveal Corner 4', 'et_builder' ),
					'border-reveal-cc-3'   		=>  esc_html__( 'Border Reveal Corner 5', 'et_builder' ),
					'border-reveal-ccc-3'   	=>  esc_html__( 'Border Reveal Corner 6', 'et_builder' ),
					'image-zoom-center'   		=>  esc_html__( 'Image Zoom Center', 'et_builder' ),
					'image-zoom-out'   			=>  esc_html__( 'Image Zoom Out', 'et_builder' ),
					'image-rotate-left'   		=>  esc_html__( 'Image Rotate Left', 'et_builder' ),
					'image-rotate-right'   		=>  esc_html__( 'Image Rotate Right', 'et_builder' ),
					'book-open-horiz'   		=>  esc_html__( 'Book Open Horizontal', 'et_builder' ),
					'book-open-vert'   			=>  esc_html__( 'Book Open Vertical', 'et_builder' ),
					'book-open-up'   			=>  esc_html__( 'Book Open Up', 'et_builder' ),
					'book-open-down'   			=>  esc_html__( 'Book Open Down', 'et_builder' ),
					'book-open-left'   			=>  esc_html__( 'Book Open Left', 'et_builder' ),
					'book-open-right'   		=>  esc_html__( 'Book Open Right', 'et_builder' ),
					'circle-up'   				=>  esc_html__( 'Circle Up', 'et_builder' ),
					'circle-down'   			=>  esc_html__( 'Circle Down', 'et_builder' ),
					'circle-left'   			=>  esc_html__( 'Circle Left', 'et_builder' ),
					'circle-right'   			=>  esc_html__( 'Circle Right', 'et_builder' ),
					'circle-top-left'   		=>  esc_html__( 'Circle Top Left', 'et_builder' ),
					'circle-top-right'   		=>  esc_html__( 'Circle Top Right', 'et_builder' ),
					'circle-bottom-left'   		=>  esc_html__( 'Circle Bottom Left', 'et_builder' ),
					'circle-bottom-right'   	=>  esc_html__( 'Circle Bottom Right', 'et_builder' ),
					'shift-top-left'   			=>  esc_html__( 'Shift Top Left', 'et_builder' ),
					'shift-top-right'   		=>  esc_html__( 'Shift Top Right', 'et_builder' ),
					'shift-bottom-left'   		=>  esc_html__( 'Shift Bottom Left', 'et_builder' ),
					'shift-bottom-right'   		=>  esc_html__( 'Shift Bottom Right', 'et_builder' ),
					'bounce-in'   				=>  esc_html__( 'Bounce In', 'et_builder' ),
					'bounce-in-up'   			=>  esc_html__( 'Bounce In Up', 'et_builder' ),
					'bounce-in-down'   			=>  esc_html__( 'Bounce In Down', 'et_builder' ),
					'bounce-in-left'   			=>  esc_html__( 'Bounce In Left', 'et_builder' ),
					'bounce-in-right'   		=>  esc_html__( 'Bounce In Right', 'et_builder' ),
					'bounce-out'   				=>  esc_html__( 'Bounce Out', 'et_builder' ),
					'bounce-out-up'   			=>  esc_html__( 'Bounce Out Up', 'et_builder' ),
					'bounce-out-down'   		=>  esc_html__( 'Bounce Out Down', 'et_builder' ),
					'bounce-out-left'   		=>  esc_html__( 'Bounce Out Left', 'et_builder' ),
					'bounce-out-right'   		=>  esc_html__( 'Bounce Out Right', 'et_builder' ),
					'fall-away-horiz'   		=>  esc_html__( 'Fall Away Horizontal', 'et_builder' ),
					'fall-away-vert'   			=>  esc_html__( 'Fall Away Vertical', 'et_builder' ),
					'fall-away-cc'   			=>  esc_html__( 'Fall Away Corner 1', 'et_builder' ),
					'fall-away-ccc'   			=>  esc_html__( 'Fall Away Corner 2', 'et_builder' ),
					'modal-slide-up'   			=>  esc_html__( 'Modal Slide Up', 'et_builder' ),
					'modal-slide-down'   		=>  esc_html__( 'Modal Slide Down', 'et_builder' ),
					'modal-slide-left'   		=>  esc_html__( 'Modal Slide Left', 'et_builder' ),
					'modal-slide-right'   		=>  esc_html__( 'Modal Slide Right', 'et_builder' ),
					'modal-hinge-up'   			=>  esc_html__( 'Modal Hinge Up', 'et_builder' ),
					'modal-hinge-down'   		=>  esc_html__( 'Modal Hinge Down', 'et_builder' ),
					'modal-hinge-left'   		=>  esc_html__( 'Modal Hinge Left', 'et_builder' ),
					'modal-hinge-right'   		=>  esc_html__( 'Modal Hinge Right', 'et_builder' ),
					'lightspeed-in-left'   		=>  esc_html__( 'Lightspeed In Left', 'et_builder' ),
					'lightspeed-in-right'   	=>  esc_html__( 'Lightspeed In Right', 'et_builder' ),
					'lightspeed-out-left'   	=>  esc_html__( 'Lightspeed Out Left', 'et_builder' ),
					'lightspeed-out-right'   	=>  esc_html__( 'Lightspeed Out Right', 'et_builder' ),
					'grad-radial-in'   			=>  esc_html__( 'Grad Radial In', 'et_builder' ),
					'grad-radial-out'   		=>  esc_html__( 'Grad Radial Out', 'et_builder' ),
					'grad-up'   				=>  esc_html__( 'Grad Up', 'et_builder' ),
					'grad-down'   				=>  esc_html__( 'Grad Down', 'et_builder' ),
					'grad-left'   				=>  esc_html__( 'Grad Left', 'et_builder' ),
					'grad-right'   				=>  esc_html__( 'Grad Right', 'et_builder' ),
					'grad-top-left'   			=>  esc_html__( 'Grad Top Left', 'et_builder' ),
					'grad-top-right'   			=>  esc_html__( 'Grad Top Right', 'et_builder' ),
					'grad-bottom-left'   		=>  esc_html__( 'Grad Bottom Left', 'et_builder' ),
					'grad-bottom-right'   		=>  esc_html__( 'Grad Bottom Right', 'et_builder' ),
					'parallax-up'   			=>  esc_html__( 'Parallax Up', 'et_builder' ),
					'parallax-down'   			=>  esc_html__( 'Parallax Down', 'et_builder' ),
					'parallax-left'   			=>  esc_html__( 'Parallax Left', 'et_builder' ),
					'parallax-right'   			=>  esc_html__( 'Parallax Right', 'et_builder' ),
					'stack-up'   				=>  esc_html__( 'Stack Up', 'et_builder' ),
					'stack-down'   				=>  esc_html__( 'Stack Down', 'et_builder' ),
					'stack-left'   				=>  esc_html__( 'Stack Left', 'et_builder' ),
					'stack-right'   			=>  esc_html__( 'Stack Right', 'et_builder' ),
					'cube-up'   				=>  esc_html__( 'Cube Up', 'et_builder' ),
					'cube-down'   				=>  esc_html__( 'Cube Down', 'et_builder' ),
					'cube-left'   				=>  esc_html__( 'Cube Left', 'et_builder' ),
					'cube-right'   				=>  esc_html__( 'Cube Right', 'et_builder' ),
					'dive'   					=>  esc_html__( 'Dive', 'et_builder' ),
					'dive-cc'   				=>  esc_html__( 'Dive Corner 1', 'et_builder' ),
					'dive-ccc'   				=>  esc_html__( 'Dive Corner 2', 'et_builder' ),
					'flash-top-left'   			=>  esc_html__( 'Flash Top Left', 'et_builder' ),
					'flash-top-right'   		=>  esc_html__( 'Flash Top Right', 'et_builder' ),
					'flash-bottom-left'   		=>  esc_html__( 'Flash Bottom Left', 'et_builder' ),
					'flash-bottom-right'   		=>  esc_html__( 'Flash Bottom Right', 'et_builder' ),
				),
			),
			// Hover Border Effect Color
			'dnxtiep_border_effect_color'	 => array(
				'label'          => esc_html__( 'Select Border Color', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'dnxtiep_hover_effect',
				'default'        => '#29c4a9',
				'mobile_options' => true,
				'responsive'	 => true,
				'show_if'		 => array(
					'dnxtiep_image_hover_effect'	=> array(
						"border-reveal",
						"border-reveal-vert",
						"border-reveal-horiz",
						"border-reveal-corners-1",
						"border-reveal-corners-2",
						"border-reveal-top-left",
						"border-reveal-top-right",
						"border-reveal-bottom-left",
						"border-reveal-bottom-right",
						"border-reveal-cc-1",
						"border-reveal-ccc-1",
						"border-reveal-cc-2",
						"border-reveal-ccc-2",
						"border-reveal-cc-3",
						"border-reveal-ccc-3",
					)
				)
			),
			// Text Effect
			'dnxtiep_text_effect'     	=> array(
				'label'             	=> esc_html__( 'Select Text Effect', 'et_builder' ),
				'type'              	=> 'select',
				'option_category'   	=> 'configuration',
				'tab_slug'          	=> 'advanced',
				'toggle_slug'       	=> 'dnxtiep_hover_effect',
				'default'           	=> '',
				'description'       	=> esc_html__( 'Here you can adjust the hover effect.', 'et_builder' ),
				'options'           	=> array(
					''   				=>  esc_html__( 'Select', 'et_builder' ),
					'ih-fade'   		=>  esc_html__( 'Fade', 'et_builder' ),
					'ih-fade-up'   		=>  esc_html__( 'Fade Up', 'et_builder' ),
					'ih-fade-down'   	=>  esc_html__( 'Fade Down', 'et_builder' ),
					'ih-fade-left'   	=>  esc_html__( 'Fade Left', 'et_builder' ),
					'ih-fade-right'   	=>  esc_html__( 'Fade Right', 'et_builder' ),
					'ih-fade-up-big'   	=>  esc_html__( 'Fade Up Big', 'et_builder' ),
					'ih-fade-down-big'  =>  esc_html__( 'Fade Down Big', 'et_builder' ),
					'ih-fade-left-big'  =>  esc_html__( 'Fade Left Big', 'et_builder' ),
					'ih-fade-right-big' =>  esc_html__( 'Fade Right Big', 'et_builder' ),
					'ih-zoom-in' 		=>  esc_html__( 'Zoom In', 'et_builder' ),
					'ih-zoom-out' 		=>  esc_html__( 'Zoom Out', 'et_builder' ),
					'ih-flip-x' 		=>  esc_html__( 'Flip X', 'et_builder' ),
					'ih-flip-y' 		=>  esc_html__( 'Flip Y', 'et_builder' ),
				
				),
			),
			// Text Delay Effect
			'dnxtiep_text_delay'     	=> array(
				'label'             	=> esc_html__( 'Select Text Delay', 'et_builder' ),
				'type'              	=> 'select',
				'option_category'   	=> 'configuration',
				'tab_slug'          	=> 'advanced',
				'toggle_slug'       	=> 'dnxtiep_hover_effect',
				'default'           	=> '',
				'description'       	=> esc_html__( 'Here you can adjust the hover effect.', 'et_builder' ),
				'options'           	=> array(
					''   				=>  esc_html__( 'Select', 'et_builder' ),
					'ih-delay-xs'   	=>  esc_html__( 'X Small', 'et_builder' ),
					'ih-delay-sm'   	=>  esc_html__( 'Small', 'et_builder' ),
					'ih-delay-md'   	=>  esc_html__( 'Medium', 'et_builder' ),
					'ih-delay-lg'   	=>  esc_html__( 'Large', 'et_builder' ),
					'ih-delay-xl'   	=>  esc_html__( 'X Large', 'et_builder' ),
					'ih-delay-xxl'   	=>  esc_html__( 'XX Large', 'et_builder' ),
				
				),
			),
			// Hover Background 
			'dnxtiep_hover_bg_show_hide'  => array(
				'label'           => esc_html__( 'Hover Background Color', 'et_builder' ),
				'type'            => 'yes_no_button',                
				'toggle_slug'     => 'dnxtiep_background',
				'sub_toggle'	  => 'sub_toggle_color',
				'options'         =>  array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'affects'         => array(
					'dnxtiep_hover_bg',
				),
				'default_on_front' => 'off',
			),
			// Hover BG Color
			'dnxtiep_hover_bg'	 => array(
				'label'          => esc_html__( 'Select Background Color', 'et_builder' ),
				'type'           => 'color-alpha',
				'toggle_slug'    => 'dnxtiep_background',
				'sub_toggle'	 => 'sub_toggle_color',
				'default'        => '#29c4a9',
				'depends_show_if'=> 'on',
				'mobile_options' => true,
				'responsive'	 => true,
			),
			// Hover Background Gradient 
			'dnxtiep_hover_gradient_show_hide'  => array(
				'label'           => esc_html__( 'Gradient Hover Color', 'et_builder' ),
				'type'            => 'yes_no_button',                
				'toggle_slug'     => 'dnxtiep_background',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'options'             => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'affects'         => array(
					'dnxtiep_hover_gradient_color_one',
					'dnxtiep_hover_gradient_color_two',
					'dnxtiep_hover_gradient_type',
					'dnxtiep_hover_gradient_start_position',
					'dnxtiep_hover_gradient_end_position'
				),
				'default_on_front' => 'off',
			),
			'dnxtiep_hover_gradient_color_one'	=> array(
				'label'          => esc_html__('Select Color One', 'et_builder' ),
				'type'           => 'color-alpha',
				'toggle_slug'    => 'dnxtiep_background',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'default'        => '#2b87da',
				'depends_show_if'=> 'on',
			),
			'dnxtiep_hover_gradient_color_two'	=> array(
				'label'          => esc_html__('Select Color Two', 'et_builder' ),
				'type'           => 'color-alpha',
				'toggle_slug'    => 'dnxtiep_background',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'default'        => '#29c4a9',
				'depends_show_if'=> 'on',
			),
			'dnxtiep_hover_gradient_type'		=> array(
				'label'           => esc_html__( 'Select Gradient Type', 'et_builder' ),
				'type'            => 'select',
				'description'     => esc_html__( 'Select the types of gradient', 'et_builder' ),
				'option_category' => 'basic_option',
				'toggle_slug'     => 'dnxtiep_background',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'options'         => array(
					'linear-gradient' => esc_html__( 'Linear', 'et_builder' ),
					'radial-gradient' => esc_html__( 'Radial', 'et_builder' ),
				),
				'default'         => 'linear-gradient',
				'depends_show_if' => 'on',
			),
			'dnxtiep_hover_gradient_type_linear_direction'   => array(
				'label'           => esc_html__( 'Linear direction', 'et_builder' ),
				'type'            => 'range',
				'option_category'=> 'basic_option',
				'toggle_slug'    => 'dnxtiep_background',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'range_settings'  => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 360,
				),
				'default'         => '180deg',
				'fixed_unit'      => 'deg',
				'show_if' => array(
					'dnxtiep_hover_gradient_show_hide'	=> 'on',
					'dnxtiep_hover_gradient_type' 		=> 'linear-gradient'
				),
			),
			'dnxtiep_hover_gradient_type_radial_direction'   => array(
				'label'           	=> esc_html__( 'Radial Direction', 'et_builder'),
				'type'            	=> 'select',
				'description'     	=> esc_html__( 'Select the types of gradient', 'et_builder'),                
				'option_category'	=> 'basic_option',
				'toggle_slug'    	=> 'dnxtiep_background',
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
					'dnxtiep_hover_gradient_show_hide'	=> 'on',
					'dnxtiep_hover_gradient_type'		=> 'radial-gradient'
				),
			),
			'dnxtiep_hover_gradient_start_position'           => array(
				'label'           => esc_html__( 'Start Position', 'et_builder' ),
				'type'            => 'range',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'dnxtiep_background',
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
			'dnxtiep_hover_gradient_end_position'             => array(
				'label'           => esc_html__( 'End Position', 'et_builder' ),
				'type'            => 'range',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'dnxtiep_background',
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
			// Button Background 
			'dnxtiep_btn_bg_show_hide'  => array(
				'label'           => esc_html__( 'Button Background Color', 'et_builder' ),
				'type'            => 'yes_no_button',                
				'toggle_slug'     => 'dnxtiep_btn_bg',
				'sub_toggle'	  => 'sub_toggle_color',
				'options'         =>  array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'affects'         => array(
					'dnxtiep_btn_bg_color',
				),
				'default_on_front' => 'off',
			),
			// Button BG Color
			'dnxtiep_btn_bg_color'	 => array(
				'label'          => esc_html__( 'Select Background Color', 'et_builder' ),
				'type'           => 'color-alpha',
				'toggle_slug'    => 'dnxtiep_btn_bg',
				'sub_toggle'	 => 'sub_toggle_color',
				'default'        => '#29c4a9',
				'depends_show_if'=> 'on',
				'hover'			 => 'tabs',
				'mobile_options' => true,
				'responsive'	 => true,
			),
			// Button Background Gradient 
			'dnxtiep_btn_gradient_show_hide'  => array(
				'label'           => esc_html__( 'Gradient Button Color', 'et_builder' ),
				'type'            => 'yes_no_button',                
				'toggle_slug'     => 'dnxtiep_btn_bg',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'options'             => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'affects'         => array(
					'dnxtiep_btn_gradient_color_one',
					'dnxtiep_btn_gradient_color_two',
					'dnxtiep_btn_gradient_type',
					'dnxtiep_btn_gradient_start_position',
					'dnxtiep_btn_gradient_end_position'
				),
				'default_on_front' => 'off',
			),
			'dnxtiep_btn_gradient_color_one'	=> array(
				'label'          => esc_html__('Select Color One', 'et_builder' ),
				'type'           => 'color-alpha',
				'toggle_slug'    => 'dnxtiep_btn_bg',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'default'        => '#2b87da',
				'depends_show_if'=> 'on',
			),
			'dnxtiep_btn_gradient_color_two'	=> array(
				'label'          => esc_html__('Select Color Two', 'et_builder' ),
				'type'           => 'color-alpha',
				'toggle_slug'    => 'dnxtiep_btn_bg',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'default'        => '#29c4a9',
				'depends_show_if'=> 'on',
			),
			'dnxtiep_btn_gradient_type'		=> array(
				'label'           => esc_html__( 'Select Gradient Type', 'et_builder' ),
				'type'            => 'select',
				'description'     => esc_html__( 'Select the types of gradient', 'et_builder' ),
				'option_category' => 'basic_option',
				'toggle_slug'     => 'dnxtiep_btn_bg',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'options'         => array(
					'linear-gradient' => esc_html__( 'Linear', 'et_builder' ),
					'radial-gradient' => esc_html__( 'Radial', 'et_builder' ),
				),
				'default'         => 'linear-gradient',
				'depends_show_if' => 'on',
			),
			'dnxtiep_btn_gradient_type_linear_direction'   => array(
				'label'           => esc_html__( 'Linear direction', 'et_builder' ),
				'type'            => 'range',
				'option_category'=> 'basic_option',
				'toggle_slug'    => 'dnxtiep_btn_bg',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'range_settings'  => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 360,
				),
				'default'         => '180deg',
				'fixed_unit'      => 'deg',
				'show_if' => array(
					'dnxtiep_btn_gradient_show_hide'	=> 'on',
					'dnxtiep_btn_gradient_type' 		=> 'linear-gradient'
				),
			),
			'dnxtiep_btn_gradient_type_radial_direction'   => array(
				'label'           	=> esc_html__( 'Radial Direction', 'et_builder'),
				'type'            	=> 'select',
				'description'     	=> esc_html__( 'Select the types of gradient', 'et_builder'),                
				'option_category'	=> 'basic_option',
				'toggle_slug'    	=> 'dnxtiep_btn_bg',
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
					'dnxtiep_btn_gradient_show_hide'	=> 'on',
					'dnxtiep_btn_gradient_type'		=> 'radial-gradient'
				),
			),
			'dnxtiep_btn_gradient_start_position'           => array(
				'label'           => esc_html__( 'Start Position', 'et_builder' ),
				'type'            => 'range',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'dnxtiep_btn_bg',
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
			'dnxtiep_btn_gradient_end_position'             => array(
				'label'           => esc_html__( 'End Position', 'et_builder' ),
				'type'            => 'range',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'dnxtiep_btn_bg',
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
			'dnxtiep_caption_margin'	=> array(
				'label'           		=> esc_html__('Content Margin', 'et_builder'),
                'type'            		=> 'custom_margin',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding', 
			),
			'dnxtiep_caption_padding'	=> array(
				'label'           		=> esc_html__('Content Padding', 'et_builder'),
				'type'            		=> 'custom_padding',
				'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
				'tab_slug'        		=> 'advanced',				
				'toggle_slug'     		=> 'margin_padding',
			),
			'dnxtiep_heading_margin'	=> array(
				'label'           		=> esc_html__('Heading Margin', 'et_builder'),
                'type'            		=> 'custom_margin',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding', 
			),
			'dnxtiep_heading_padding'	=> array(
				'label'           		=> esc_html__('Heading Padding', 'et_builder'),
				'type'            		=> 'custom_padding',
				'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
				'tab_slug'        		=> 'advanced',				
				'toggle_slug'     		=> 'margin_padding',
			),
			'dnxtiep_description_margin'	=> array(
				'label'           			=> esc_html__('Description Margin', 'et_builder'),
                'type'            			=> 'custom_margin',
                'mobile_options'  			=> true,
				'hover'           			=> 'tabs',
				'allowed_units'   			=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 			=> 'layout',
                'tab_slug'        			=> 'advanced',
				'toggle_slug'     			=> 'margin_padding', 
			),
			'dnxtiep_description_padding'	=> array(
				'label'           			=> esc_html__('Description Padding', 'et_builder'),
				'type'            			=> 'custom_padding',
				'mobile_options'  			=> true,
				'hover'           			=> 'tabs',
				'allowed_units'   			=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 			=> 'layout',
				'tab_slug'        			=> 'advanced',				
				'toggle_slug'     			=> 'margin_padding',
			),
			'dnxtiep_btn_margin'			=> array(
				'label'           			=> esc_html__('Button Margin', 'et_builder'),
                'type'            			=> 'custom_margin',
                'mobile_options'  			=> true,
				'hover'           			=> 'tabs',
				'allowed_units'   			=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 			=> 'layout',
                'tab_slug'        			=> 'advanced',
				'toggle_slug'     			=> 'margin_padding', 
			),
			'dnxtiep_btn_padding'			=> array(
				'label'           			=> esc_html__('Button Padding', 'et_builder'),
				'type'            			=> 'custom_padding',
				'mobile_options'  			=> true,
				'hover'           			=> 'tabs',
				'allowed_units'   			=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 			=> 'layout',
				'tab_slug'        			=> 'advanced',				
				'toggle_slug'     			=> 'margin_padding',
			),
			'dnxtiep_btn_align'		=> array(
				'label'           	=> esc_html__( 'Button Alignment', 'et_builder' ),
				'description'     	=> esc_html__( 'Align Button to the left, right or center.', 'et_builder' ),
				'type'            	=> 'align',
				'option_category' 	=> 'layout',
				'options'         	=> et_builder_get_text_orientation_options( array( 'justified' ) ),
				'tab_slug'        	=> 'advanced',
				'mobile_options'  	=> true,
				'toggle_slug'     	=> 'dnxtiep_btn_alingment',
				'default'         	=> 'left',
			),
		);
	}

	public function render( $attrs, $content, $render_slug ) {

		$multi_view              		= 	et_pb_multi_view_options( $this );
		$dnxtiep_image					=	$this->props['dnxtiep_image'];
		$dnxtiep_alt					=	$this->props['dnxtiep_alt'];

		$dnxtiep_heading_text			=	$this->props['dnxtiep_heading_text'];
		$dnxtiep_heading_tag			=	$this->props['dnxtiep_heading_tag'];
		$dnxtiep_description			=	$this->props['dnxtiep_description'];

		$dnxtiep_btn_show_hide			=	$this->props['dnxtiep_btn_show_hide'];
		$dnxtiep_button_text			=	$this->props['dnxtiep_button_text'];
		$dnxtiep_button_link			=	$this->props['dnxtiep_button_link'];
		$dnxtiep_button_link_new_window	=	$this->props['dnxtiep_button_link_new_window'];

		$dnxtiep_btn_switch				=	$this->props['dnxtiep_btn_switch'];
		$dnxtiep_btn_icon				=	$this->props['dnxtiep_btn_icon'];

		$dnxtiep_image_hover_effect		=	$this->props['dnxtiep_image_hover_effect'];
		$dnxtiep_text_effect			=	$this->props['dnxtiep_text_effect'];
		$dnxtiep_text_delay				=	$this->props['dnxtiep_text_delay'];


		$blocks_effects = array(
			"blocks-rotate-left",
			"blocks-rotate-right",
			"blocks-rotate-in-left",
			"blocks-rotate-in-right",
			"blocks-in",
			"blocks-out",
			"blocks-float-up",
			"blocks-float-down",
			"blocks-float-left",
			"blocks-float-right",
			"blocks-zoom-top-left",
			"blocks-zoom-top-right",
			"blocks-zoom-bottom-left",
			"blocks-zoom-bottom-right",
		);

		$strip_effects = array(
			"strip-shutter-up",   		
			"strip-shutter-down",  		
			"strip-shutter-left",   		
			"strip-shutter-right",   	 
			"strip-horiz-up",   			 
			"strip-horiz-down",   		
			"strip-horiz-top-left",   	
			"strip-horiz-top-right",   	
			"strip-horiz-bottom-left",   
			"strip-horiz-bottom-right", 
			"strip-vert-left",   		 
			"strip-vert-right",   		
			"strip-vert-top-left",   	
			"strip-vert-top-right",   	
			"strip-vert-bottom-left",   	
			"strip-vert-bottom-right",
		);

		$pixel_effects = array(
			"pixel-up",   				
			"pixel-down",   				
			"pixel-left",   				
			"pixel-right",   			
			"pixel-top-left",   			
			"pixel-top-right",   		
			"pixel-bottom-left",   		
			"pixel-bottom-right",
		);

		$border_effects = array(
			"border-reveal",
			"border-reveal-vert",
			"border-reveal-horiz",
			"border-reveal-corners-1",
			"border-reveal-corners-2",
			"border-reveal-top-left",
			"border-reveal-top-right",
			"border-reveal-bottom-left",
			"border-reveal-bottom-right",
			"border-reveal-cc-1",
			"border-reveal-ccc-1",
			"border-reveal-cc-2",
			"border-reveal-ccc-2",
			"border-reveal-cc-3",
			"border-reveal-ccc-3",
		);

		$blind_effects = array(
			"blinds-horiz",
			"blinds-vert",
			"blinds-up",
			"blinds-down",
			"blinds-left",
			"blinds-right",
		);

		$book_effects = array(
			"book-open-horiz",
			"book-open-vert",
			"book-open-up",
			"book-open-down",
			"book-open-left",
			"book-open-right",
		);

		$circle_effects = array(
			"circle-up",
			"circle-down",
			"circle-left",
			"circle-right",
			"circle-top-left",
			"circle-top-right",
			"circle-bottom-left",
			"circle-bottom-right",
		);

		$grad_effects = array(
			"grad-radial-in",
			"grad-radial-out",
			"grad-up",
			"grad-down",
			"grad-left",
			"grad-right",
			"grad-top-left",
			"grad-top-right",
			"grad-bottom-left",
			"grad-bottom-right",
		);

		$flash_effects = array(
			"flash-top-left",
			"flash-top-right",
			"flash-bottom-left",
			"flash-bottom-right",
		);

		$dnxtiep_image_hover_effects = array();
		if ( ! empty( $dnxtiep_image_hover_effect ) ) {
			array_push( $dnxtiep_image_hover_effects, sprintf( 'imghvr-%1$s', esc_attr( $dnxtiep_image_hover_effect ) ) );
        }
		$dnxtiep_image_hover_effect_classes = join( ' ', $dnxtiep_image_hover_effects );

		$dnxtiep_image_pathinfo = pathinfo( $dnxtiep_image );
		$is_dnxtiep_image_svg 	= isset( $dnxtiep_image_pathinfo['extension'] ) ? 'svg' === $dnxtiep_image_pathinfo['extension'] : false;
		

		$image_html = $multi_view->render_element( array(
			'tag'   => 'img',
			'attrs' => array(
				'src'   => '{{dnxtiep_image}}',
				'alt'   => '{{dnxtiep_alt}}',
			),
			'required' 	=> 'dnxtiep_image',
		) );

		$dnxtiep_img = "";
		if ( "" !== $dnxtiep_image ) {
			$dnxtiep_img = sprintf(
				'%1$s',
				$image_html
			);
		}


		//Heading Text
		$dnxtiepheadingtext = '';
		if ( '' !== $dnxtiep_heading_text ){
			$dnxtiepheadingtext = sprintf(
				'<%1$s class="dnxtiep-heading">%2$s</%1$s>',
				et_pb_process_header_level( $dnxtiep_heading_tag, 'span' ),
				et_core_esc_previously( $dnxtiep_heading_text )
			);
		}

		
		// Description
		$description = "";
		if ( '' !== $dnxtiep_description ) {
			$description = sprintf(
				'<div class="dnxtiep-description">%1$s</div>',
				et_core_esc_previously( $dnxtiep_description )
			);
		}

		$button 		= "";
		$button_target	= "";
		$icon_fontawesome = explode('||', $this->props['dnxtiep_btn_icon']);
		$icon_fontawesome_values = et_pb_responsive_options()->get_property_values($this->props, 'dnxtiep_btn_icon');
		$icon_fontawesome_tablet = isset($icon_fontawesome_values['tablet']) ? explode( '||', $icon_fontawesome_values['tablet'] ) : '';
		$icon_fontawesome_phone = isset($icon_fontawesome_values['phone']) ? explode( '||', $icon_fontawesome_values['phone'] ) : '';

		if ( 'off' !== $dnxtiep_btn_show_hide ) {

			$button_target 	= 'on' === $dnxtiep_button_link_new_window ? '_blank' : '_self';

			$button_icon = isset($icon_fontawesome[0]) && 'off' !== $dnxtiep_btn_switch ? $icon_fontawesome[0] : '';
			$button_icon_weight = isset($icon_fontawesome[2]) && 'off' !== $dnxtiep_btn_switch ? $icon_fontawesome[2] : '';
			$button_icon_tablet = isset($icon_fontawesome_tablet[0]) && 'off' !== $dnxtiep_btn_switch ? $icon_fontawesome_tablet[0] : $button_icon;
			$button_icon_weight_tablet = isset($icon_fontawesome_tablet[2]) && 'off' !== $dnxtiep_btn_switch ? $icon_fontawesome_tablet[2] : $button_icon_weight;
			$button_icon_phone = isset($icon_fontawesome_phone[0]) && 'off' !== $dnxtiep_btn_switch ? $icon_fontawesome_phone[0] : $button_icon_tablet;
			$button_icon_weight_phone = isset($icon_fontawesome_phone[2]) && 'off' !== $dnxtiep_btn_switch ? $icon_fontawesome_phone[2] : $button_icon_weight_tablet;

			//Button On Hover class inner
			$btnIconOnHover = 'on' === $this->props['dnxtiep_btn_on_hover'] ? "dnxtiep-btn-icon-on-hover" : "";

			$button = sprintf(
				'<div class="dnxtiep-button">
					<a href="%1$s" class="dnxt-nie-uih-btn ih-fade-up ih-delay-lg %2$s" data-icon="%3$s" data-icon-tablet="%5$s" data-icon-phone="%6$s">
						%4$s
					</a>
				</div>',
				esc_url( $dnxtiep_button_link),
				esc_attr($btnIconOnHover),
				esc_attr( et_pb_process_font_icon( $button_icon )),
				et_core_esc_previously( $dnxtiep_button_text ),
				esc_attr( et_pb_process_font_icon( $button_icon_tablet ) ),
				esc_attr( et_pb_process_font_icon( $button_icon_phone ) )
			);
		}

		$font_name = array('fa' => 'FontAwesome', 'divi' => 'ETmodules');
		$font_styles = isset($icon_fontawesome[1]) && array_key_exists($icon_fontawesome[1], $font_name) ? sprintf('font-family: %1$s !important;font-weight: %2$s !important;', $font_name[$icon_fontawesome[1]], $button_icon_weight) : "font-family: ETmodules !important;";
		$font_styles_tablet = isset($icon_fontawesome_tablet[1]) && array_key_exists($icon_fontawesome_tablet[1], $font_name) ? sprintf('font-family: %1$s !important;font-weight: %2$s !important;', $font_name[$icon_fontawesome_tablet[1]], $button_icon_weight_tablet) : "font-family: ETmodules !important;";
		$font_styles_phone = isset($icon_fontawesome_phone[1]) && array_key_exists($icon_fontawesome_phone[1], $font_name) ? sprintf('font-family: %1$s !important;font-weight: %2$s !important;', $font_name[$icon_fontawesome_phone[1]], $button_icon_weight_phone) : "font-family: ETmodules !important;";
		


		if ( 'right' === $this->props['dnxtiep_btn_icon_placement'] ) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    	=> "%%order_class%% .dnxt-nie-uih-btn::after",
				'declaration'	=> $font_styles
			) );

			ET_Builder_Element::set_style($render_slug, array(
				'selector'    	=> "%%order_class%% .dnxt-nie-uih-btn::after",
				'declaration'	=> $font_styles_tablet,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
			) );
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    	=> "%%order_class%% .dnxt-nie-uih-btn::after",
				'declaration'	=> $font_styles_phone,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
			) );
		}else if ('left' === $this->props['dnxtiep_btn_icon_placement']){
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    	=> "%%order_class%% .dnxt-nie-uih-btn::before",
				'declaration'	=> $font_styles
			) );
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    	=> "%%order_class%% .dnxt-nie-uih-btn::before",
				'declaration'	=> $font_styles_tablet,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
			) );
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    	=> "%%order_class%% .dnxt-nie-uih-btn::before",
				'declaration'	=> $font_styles_phone,
				'media_query' 	=> 	ET_Builder_Element::get_media_query( 'max_width_767' ),
			) );
		}



		$dnxtiep_btn_icon_color			=	$this->props['dnxtiep_btn_icon_color'];
		$dnxtiep_btn_icon_color_hover   =	$this->get_hover_value( 'dnxtiep_btn_icon_color' );
		$dnxtiep_btn_icon_color_values  =	et_pb_responsive_options()->get_property_values( $this->props, 'dnxtiep_btn_icon_color' );
		$dnxtiep_btn_icon_color_tablet  =	isset( $dnxtiep_btn_icon_color_values['tablet'] ) ? $dnxtiep_btn_icon_color_values['tablet'] : '';
		$dnxtiep_btn_icon_color_phone   =	isset( $dnxtiep_btn_icon_color_values['phone'] ) ? $dnxtiep_btn_icon_color_values['phone'] : '';
		// Button Icon Color
		if ( '' !== $dnxtiep_btn_icon_color ) {
			$dnxtiep_btn_icon_color_style 			= sprintf( 'color: %1$s;', esc_attr( $dnxtiep_btn_icon_color ) );
			$dnxtiep_btn_icon_color_tablet_style 	= '' !== $dnxtiep_btn_icon_color_tablet ? sprintf( 'color: %1$s;', esc_attr( $dnxtiep_btn_icon_color_tablet ) ) : '';
			$dnxtiep_btn_icon_color_phone_style  	= '' !== $dnxtiep_btn_icon_color_phone ? sprintf( 'color: %1$s;', esc_attr( $dnxtiep_btn_icon_color_phone ) ) : '';
			
			$dnxtiep_btn_icon_color_style_hover  = '';

			if ( et_builder_is_hover_enabled( 'dnxtiep_btn_icon_color', $this->props ) ) {
				$dnxtiep_btn_icon_color_style_hover = sprintf( 'color: %1$s;', esc_attr( $dnxtiep_btn_icon_color_hover ) );
			}

			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnxt-nie-uih-btn::after, %%order_class%% .dnxt-nie-uih-btn::before",
				'declaration' => $dnxtiep_btn_icon_color_style,
			) );
			
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnxt-nie-uih-btn::after, %%order_class%% .dnxt-nie-uih-btn::before",
				'declaration' => $dnxtiep_btn_icon_color_tablet_style,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
			) );

			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnxt-nie-uih-btn::after, %%order_class%% .dnxt-nie-uih-btn::before",
				'declaration' => $dnxtiep_btn_icon_color_phone_style,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
			) );

			if ( "" !== $dnxtiep_btn_icon_color_style_hover ) {
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => $this->add_hover_to_order_class( "%%order_class%% .dnxt-nie-uih-btn:hover:before,%%order_class%% .dnxt-nie-uih-btn:hover:after" ),
					'declaration' => $dnxtiep_btn_icon_color_style_hover ,
				) );
			}
		}

		// Hover BG Color
		$dnxtiep_hover_bg_color			= $this->props['dnxtiep_hover_bg'];
		$dnxtiep_hover_bg_color_values	= et_pb_responsive_options()->get_property_values( $this->props, 'dnxtiep_hover_bg' );
		$dnxtiep_hover_bg_color_tablet	= isset( $dnxtiep_hover_bg_color_values['tablet'] ) ? $dnxtiep_hover_bg_color_values['tablet'] : '';
		$dnxtiep_hover_bg_color_phone	= isset( $dnxtiep_hover_bg_color_values['phone'] ) ? $dnxtiep_hover_bg_color_values['phone'] : '';
		
		$dnxtiep_border_effect_color		= $this->props['dnxtiep_border_effect_color'];
		$dnxtiep_border_effect_color_values	= et_pb_responsive_options()->get_property_values( $this->props, 'dnxtiep_border_effect_color' );
		$dnxtiep_border_effect_color_tablet	= isset( $dnxtiep_border_effect_color_values['tablet'] ) ? $dnxtiep_border_effect_color_values['tablet'] : '';
		$dnxtiep_border_effect_color_phone	= isset( $dnxtiep_border_effect_color_values['phone'] ) ? $dnxtiep_border_effect_color_values['phone'] : '';

		if ( 'off' !== $this->props['dnxtiep_hover_bg_show_hide'] ) {
			$dnxtiep_hover_bg_color_style 		 = sprintf( 'background-color: %1$s;', esc_attr( $dnxtiep_hover_bg_color ) );
			$dnxtiep_hover_bg_color_tablet_style = '' !== $dnxtiep_hover_bg_color_tablet ? sprintf( 'background-color: %1$s;', esc_attr( $dnxtiep_hover_bg_color_tablet ) ) : '';
			$dnxtiep_hover_bg_color_phone_style  = '' !== $dnxtiep_hover_bg_color_phone ? sprintf( 'background-color: %1$s;', esc_attr( $dnxtiep_hover_bg_color_phone ) ) : '';
			
			if ( in_array( $dnxtiep_image_hover_effect, $blocks_effects, true ) ) {
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => "%%order_class%% [class^='imghvr-'], %%order_class%% [class^='imghvr-blocks']:before, %%order_class%% [class^='imghvr-blocks']:after, %%order_class%% [class^='imghvr-blocks'] figcaption:before, %%order_class%% [class^='imghvr-blocks'] figcaption:after",
					'declaration' => $dnxtiep_hover_bg_color_style,
				) );
	
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => "%%order_class%% [class^='imghvr-'], %%order_class%% [class^='imghvr-blocks']:before, %%order_class%% [class^='imghvr-blocks']:after, %%order_class%% [class^='imghvr-blocks'] figcaption:before, %%order_class%% [class^='imghvr-blocks'] figcaption:after",
					'declaration' => $dnxtiep_hover_bg_color_tablet_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
				) );
	
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => "%%order_class%% [class^='imghvr-'], %%order_class%% [class^='imghvr-blocks']:before, %%order_class%% [class^='imghvr-blocks']:after, %%order_class%% [class^='imghvr-blocks'] figcaption:before, %%order_class%% [class^='imghvr-blocks'] figcaption:after",
					'declaration' => $dnxtiep_hover_bg_color_phone_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				) );

			} else if ( in_array( $dnxtiep_image_hover_effect, $strip_effects, true ) ) {
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => "%%order_class%% [class^='imghvr-'], %%order_class%% [class^='imghvr-strip']:before, %%order_class%% [class^='imghvr-strip']:after, %%order_class%% [class^='imghvr-strip'] figcaption:before, %%order_class%% [class^='imghvr-strip'] figcaption:after",
					'declaration' => $dnxtiep_hover_bg_color_style,
				) );
	
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => "%%order_class%% [class^='imghvr-'], %%order_class%% [class^='imghvr-strip']:before, %%order_class%% [class^='imghvr-strip']:after, %%order_class%% [class^='imghvr-strip'] figcaption:before, %%order_class%% [class^='imghvr-strip'] figcaption:after",
					'declaration' => $dnxtiep_hover_bg_color_tablet_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
				) );
	
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => "%%order_class%% [class^='imghvr-'], %%order_class%% [class^='imghvr-strip']:before, %%order_class%% [class^='imghvr-strip']:after, %%order_class%% [class^='imghvr-strip'] figcaption:before, %%order_class%% [class^='imghvr-strip'] figcaption:after",
					'declaration' => $dnxtiep_hover_bg_color_phone_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				) );
			} else if ( in_array( $dnxtiep_image_hover_effect, $pixel_effects, true ) ) {
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => "%%order_class%% [class^='imghvr-'], %%order_class%% [class^='imghvr-pixel']:before, %%order_class%% [class^='imghvr-pixel']:after, %%order_class%% [class^='imghvr-pixel'] figcaption:before, %%order_class%% [class^='imghvr-pixel'] figcaption:after",
					'declaration' => $dnxtiep_hover_bg_color_style,
				) );
	
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => "%%order_class%% [class^='imghvr-'], %%order_class%% [class^='imghvr-pixel']:before, %%order_class%% [class^='imghvr-pixel']:after, %%order_class%% [class^='imghvr-pixel'] figcaption:before, %%order_class%% [class^='imghvr-pixel'] figcaption:after",
					'declaration' => $dnxtiep_hover_bg_color_tablet_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
				) );
	
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => "%%order_class%% [class^='imghvr-'], %%order_class%% [class^='imghvr-pixel']:before, %%order_class%% [class^='imghvr-pixel']:after, %%order_class%% [class^='imghvr-pixel'] figcaption:before, %%order_class%% [class^='imghvr-pixel'] figcaption:after",
					'declaration' => $dnxtiep_hover_bg_color_phone_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				) );
			} else if ( in_array( $dnxtiep_image_hover_effect, $border_effects, true ) ) {
				$dnxtiep_border_effect_color_style 		  = sprintf( 'background-color: %1$s;', esc_attr( $dnxtiep_border_effect_color ) );
				$dnxtiep_border_effect_color_tablet_style = '' !== $dnxtiep_border_effect_color_tablet ? sprintf( 'background-color: %1$s;', esc_attr( $dnxtiep_border_effect_color_tablet ) ) : '';
				$dnxtiep_border_effect_color_phone_style  = '' !== $dnxtiep_border_effect_color_phone ? sprintf( 'background-color: %1$s;', esc_attr( $dnxtiep_border_effect_color_phone ) ) : '';
				
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => "%%order_class%% [class^='imghvr-']",
					'declaration' => $dnxtiep_hover_bg_color_style,
				) );
	
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => "%%order_class%% [class^='imghvr-']",
					'declaration' => $dnxtiep_hover_bg_color_tablet_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
				) );
	
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => "%%order_class%% [class^='imghvr-']",
					'declaration' => $dnxtiep_hover_bg_color_phone_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				) );

				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => "%%order_class%% [class^='imghvr-border']:before, %%order_class%% [class^='imghvr-border']:after, %%order_class%% [class^='imghvr-border'] figcaption:before, %%order_class%% [class^='imghvr-border'] figcaption:after",
					'declaration' => $dnxtiep_border_effect_color_style,
				) );
	
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => "%%order_class%% [class^='imghvr-border']:before, %%order_class%% [class^='imghvr-border']:after, %%order_class%% [class^='imghvr-border'] figcaption:before, %%order_class%% [class^='imghvr-border'] figcaption:after",
					'declaration' => $dnxtiep_border_effect_color_tablet_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
				) );
	
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => "%%order_class%% [class^='imghvr-border']:before, %%order_class%% [class^='imghvr-border']:after, %%order_class%% [class^='imghvr-border'] figcaption:before, %%order_class%% [class^='imghvr-border'] figcaption:after",
					'declaration' => $dnxtiep_border_effect_color_phone_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				) );

			} else if ( in_array( $dnxtiep_image_hover_effect, $blind_effects, true ) ) {
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => "%%order_class%% [class^='imghvr-'], %%order_class%% [class^='imghvr-blinds']:before, %%order_class%% [class^='imghvr-blinds']:after, %%order_class%% [class^='imghvr-blinds'] figcaption:before, %%order_class%% [class^='imghvr-blinds'] figcaption:after",
					'declaration' => $dnxtiep_hover_bg_color_style,
				) );
	
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => "%%order_class%% [class^='imghvr-'], %%order_class%% [class^='imghvr-blinds']:before, %%order_class%% [class^='imghvr-blinds']:after, %%order_class%% [class^='imghvr-blinds'] figcaption:before, %%order_class%% [class^='imghvr-blinds'] figcaption:after",
					'declaration' => $dnxtiep_hover_bg_color_tablet_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
				) );
	
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => "%%order_class%% [class^='imghvr-'], %%order_class%% [class^='imghvr-blinds']:before, %%order_class%% [class^='imghvr-blinds']:after, %%order_class%% [class^='imghvr-blinds'] figcaption:before, %%order_class%% [class^='imghvr-blinds'] figcaption:after",
					'declaration' => $dnxtiep_hover_bg_color_phone_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				) );
			} else if ( in_array( $dnxtiep_image_hover_effect, $book_effects, true ) ) {
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => "%%order_class%% [class^='imghvr-'], %%order_class%% [class^='imghvr-book']:before, %%order_class%% [class^='imghvr-book']:after, %%order_class%% [class^='imghvr-book'] figcaption:before, %%order_class%% [class^='imghvr-book'] figcaption:after",
					'declaration' => $dnxtiep_hover_bg_color_style,
				) );
	
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => "%%order_class%% [class^='imghvr-'], %%order_class%% [class^='imghvr-book']:before, %%order_class%% [class^='imghvr-book']:after, %%order_class%% [class^='imghvr-book'] figcaption:before, %%order_class%% [class^='imghvr-book'] figcaption:after",
					'declaration' => $dnxtiep_hover_bg_color_tablet_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
				) );
	
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => "%%order_class%% [class^='imghvr-'], %%order_class%% [class^='imghvr-book']:before, %%order_class%% [class^='imghvr-book']:after, %%order_class%% [class^='imghvr-book'] figcaption:before, %%order_class%% [class^='imghvr-book'] figcaption:after",
					'declaration' => $dnxtiep_hover_bg_color_phone_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				) );
			}  else if ( in_array( $dnxtiep_image_hover_effect, $circle_effects, true ) ) {
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => "%%order_class%% [class^='imghvr-'], %%order_class%% [class^='imghvr-circle']:before, %%order_class%% [class^='imghvr-circle']:after, %%order_class%% [class^='imghvr-circle'] figcaption:before, %%order_class%% [class^='imghvr-circle'] figcaption:after",
					'declaration' => $dnxtiep_hover_bg_color_style,
				) );
	
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => "%%order_class%% [class^='imghvr-'], %%order_class%% [class^='imghvr-circle']:before, %%order_class%% [class^='imghvr-circle']:after, %%order_class%% [class^='imghvr-circle'] figcaption:before, %%order_class%% [class^='imghvr-circle'] figcaption:after",
					'declaration' => $dnxtiep_hover_bg_color_tablet_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
				) );
	
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => "%%order_class%% [class^='imghvr-'], %%order_class%% [class^='imghvr-circle']:before, %%order_class%% [class^='imghvr-circle']:after, %%order_class%% [class^='imghvr-circle'] figcaption:before, %%order_class%% [class^='imghvr-circle'] figcaption:after",
					'declaration' => $dnxtiep_hover_bg_color_phone_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				) );
			} else if ( in_array( $dnxtiep_image_hover_effect, $grad_effects, true ) ) {
				$dnxtiep_hover_bg_gradient_style 		 = sprintf( 'background: %1$s;', esc_attr( $dnxtiep_hover_bg_color ) );
				$dnxtiep_hover_bg_gradient_tablet_style	 = '' !== $dnxtiep_hover_bg_color_tablet ? sprintf( 'background: %1$s;', esc_attr( $dnxtiep_hover_bg_color_tablet ) ) : '';
				$dnxtiep_hover_bg_gradient_phone_style   = '' !== $dnxtiep_hover_bg_color_phone ? sprintf( 'background: %1$s;', esc_attr( $dnxtiep_hover_bg_color_phone ) ) : '';
				
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => "%%order_class%% [class^='imghvr-'], %%order_class%% [class^='imghvr-grad']:before, %%order_class%% [class^='imghvr-grad']:after, %%order_class%% [class^='imghvr-grad'] figcaption:before, %%order_class%% [class^='imghvr-grad'] figcaption:after",
					'declaration' => $dnxtiep_hover_bg_gradient_style,
				) );
	
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => "%%order_class%% [class^='imghvr-'], %%order_class%% [class^='imghvr-grad']:before, %%order_class%% [class^='imghvr-grad']:after, %%order_class%% [class^='imghvr-grad'] figcaption:before, %%order_class%% [class^='imghvr-grad'] figcaption:after",
					'declaration' => $dnxtiep_hover_bg_gradient_tablet_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
				) );
	
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => "%%order_class%% [class^='imghvr-'], %%order_class%% [class^='imghvr-grad']:before, %%order_class%% [class^='imghvr-grad']:after, %%order_class%% [class^='imghvr-grad'] figcaption:before, %%order_class%% [class^='imghvr-grad'] figcaption:after",
					'declaration' => $dnxtiep_hover_bg_gradient_phone_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				) );
			} else {

				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => "%%order_class%% [class^='imghvr-'] figcaption, %%order_class%% [class^='imghvr-reveal-']:before, %%order_class%% [class^='imghvr-shutter-out-']:before, %%order_class%% [class^='imghvr-shutter-in-']:before, %%order_class%% [class^='imghvr-shutter-in-']:after, %%order_class%% [class^='imghvr-flash-']:before, %%order_class%% [class^='imghvr-flash-']:after",
					'declaration' => $dnxtiep_hover_bg_color_style,
				) );
	
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => "%%order_class%% [class^='imghvr-'] figcaption, %%order_class%% [class^='imghvr-reveal-']:before, %%order_class%% [class^='imghvr-shutter-out-']:before, %%order_class%% [class^='imghvr-shutter-in-']:before, %%order_class%% [class^='imghvr-shutter-in-']:after, %%order_class%% [class^='imghvr-flash-']:before, %%order_class%% [class^='imghvr-flash-']:after",
					'declaration' => $dnxtiep_hover_bg_color_tablet_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
				) );
	
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => "%%order_class%% [class^='imghvr-'] figcaption, %%order_class%% [class^='imghvr-reveal-']:before, %%order_class%% [class^='imghvr-shutter-out-']:before, %%order_class%% [class^='imghvr-shutter-in-']:before, %%order_class%% [class^='imghvr-shutter-in-']:after, %%order_class%% [class^='imghvr-flash-']:before, %%order_class%% [class^='imghvr-flash-']:after",
					'declaration' => $dnxtiep_hover_bg_color_phone_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				) );
			}
		}

		// Hover Background Icon Gradient
		$dnxtiep_hover_gradient_apply      		= '';
		$dnxtiep_hover_gradient_color_one 		= '';
		$dnxtiep_hover_gradient_color_two 		= '';
		$dnxtiep_hover_gradient_type	   		= '';
		$dnxtiep_hover_gl             			= '';
		$dnxtiep_hover_gr             			= '';
		$dnxtiep_hover_gradient_start_position	= '';
		$dnxtiep_hover_gradient_end_position  	= '';

		// checking gradient type
		if ( '' !== $this->props['dnxtiep_hover_gradient_type'] ) {
			$dnxtiep_hover_gradient_type = $this->props['dnxtiep_hover_gradient_type'];
		}
		// Hover Image Linear Gradient Direction
		if ( '' !== $this->props['dnxtiep_hover_gradient_type_linear_direction'] ) {
			$dnxtiep_hover_gl = $this->props['dnxtiep_hover_gradient_type_linear_direction'];
		}
		// Hover Image Radial Gradient Direction
		if ( '' !== $this->props['dnxtiep_hover_gradient_type_radial_direction'] ) {
			$dnxtiep_hover_gr = $this->props['dnxtiep_hover_gradient_type_radial_direction'];
		}	
		// Apply gradient direcion
		if ( 'radial-gradient' === $this->props['dnxtiep_hover_gradient_type'] ) {
			$dnxtiep_hover_gradient_apply = sprintf('%1$s', $dnxtiep_hover_gr);
		} else if ( 'linear-gradient' === $this->props['dnxtiep_hover_gradient_type'] ) {
			$dnxtiep_hover_gradient_apply = sprintf('%1$s', $dnxtiep_hover_gl);
		}
		// Gradient color one for Hover Background Image
		if ( '' !== $this->props['dnxtiep_hover_gradient_color_one'] ) {
			$dnxtiep_hover_gradient_color_one = $this->props['dnxtiep_hover_gradient_color_one'];
		}
		// Gradient color two for Hover Background Image
		if ( '' !== $this->props['dnxtiep_hover_gradient_color_two'] ) {
			$dnxtiep_hover_gradient_color_two = $this->props['dnxtiep_hover_gradient_color_two'];
		}
		// Hover Background Image Gradient color start position 
		if ( '' !== $this->props['dnxtiep_hover_gradient_start_position'] ) {
			$dnxtiep_hover_gradient_start_position = $this->props['dnxtiep_hover_gradient_start_position'];
		}
		// Hover Background Image Gradient color end position
		if ( '' !== $this->props['dnxtiep_hover_gradient_end_position'] ) {
			$dnxtiep_hover_gradient_end_position = $this->props['dnxtiep_hover_gradient_end_position'];
		}
		// Hover Background Image Gradient setting up
		if ( 'off' !== $this->props['dnxtiep_hover_gradient_show_hide'] ) {
			if ( in_array( $dnxtiep_image_hover_effect, $blocks_effects, true ) ) {
				ET_Builder_Element::set_style($render_slug, array(
					'selector'    => "%%order_class%% [class^='imghvr-'], %%order_class%% [class^='imghvr-blocks']:before, %%order_class%% [class^='imghvr-blocks']:after, %%order_class%% [class^='imghvr-blocks'] figcaption:before, %%order_class%% [class^='imghvr-blocks'] figcaption:after",
					'declaration' => "background: {$dnxtiep_hover_gradient_type}($dnxtiep_hover_gradient_apply, $dnxtiep_hover_gradient_color_one $dnxtiep_hover_gradient_start_position, $dnxtiep_hover_gradient_color_two $dnxtiep_hover_gradient_end_position);",
				) );
			} else if ( in_array( $dnxtiep_image_hover_effect, $strip_effects, true ) ) {
				ET_Builder_Element::set_style($render_slug, array(
					'selector'    => "%%order_class%% [class^='imghvr-'], %%order_class%% [class^='imghvr-strip']:before, %%order_class%% [class^='imghvr-strip']:after, %%order_class%% [class^='imghvr-strip'] figcaption:before, %%order_class%% [class^='imghvr-strip'] figcaption:after",
					'declaration' => "background: {$dnxtiep_hover_gradient_type}($dnxtiep_hover_gradient_apply, $dnxtiep_hover_gradient_color_one $dnxtiep_hover_gradient_start_position, $dnxtiep_hover_gradient_color_two $dnxtiep_hover_gradient_end_position);",
				) );
			} else if ( in_array( $dnxtiep_image_hover_effect, $pixel_effects, true ) ) {
				ET_Builder_Element::set_style($render_slug, array(
					'selector'    => "%%order_class%% [class^='imghvr-'], %%order_class%% [class^='imghvr-pixel']:before, %%order_class%% [class^='imghvr-pixel']:after, %%order_class%% [class^='imghvr-pixel'] figcaption:before, %%order_class%% [class^='imghvr-pixel'] figcaption:after",
					'declaration' => "background: {$dnxtiep_hover_gradient_type}($dnxtiep_hover_gradient_apply, $dnxtiep_hover_gradient_color_one $dnxtiep_hover_gradient_start_position, $dnxtiep_hover_gradient_color_two $dnxtiep_hover_gradient_end_position);",
				) );
			} else if ( in_array( $dnxtiep_image_hover_effect, $border_effects, true ) ) {
				$dnxtiep_border_effect_color_style 		  = sprintf( 'background-color: %1$s;', esc_attr( $dnxtiep_border_effect_color ) );
				$dnxtiep_border_effect_color_tablet_style = '' !== $dnxtiep_border_effect_color_tablet ? sprintf( 'background-color: %1$s;', esc_attr( $dnxtiep_border_effect_color_tablet ) ) : '';
				$dnxtiep_border_effect_color_phone_style  = '' !== $dnxtiep_border_effect_color_phone ? sprintf( 'background-color: %1$s;', esc_attr( $dnxtiep_border_effect_color_phone ) ) : '';

				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => "%%order_class%% [class^='imghvr-border']:before, %%order_class%% [class^='imghvr-border']:after, %%order_class%% [class^='imghvr-border'] figcaption:before, %%order_class%% [class^='imghvr-border'] figcaption:after",
					'declaration' => $dnxtiep_border_effect_color_style,
				) );
	
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => "%%order_class%% [class^='imghvr-border']:before, %%order_class%% [class^='imghvr-border']:after, %%order_class%% [class^='imghvr-border'] figcaption:before, %%order_class%% [class^='imghvr-border'] figcaption:after",
					'declaration' => $dnxtiep_border_effect_color_tablet_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
				) );
	
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => "%%order_class%% [class^='imghvr-border']:before, %%order_class%% [class^='imghvr-border']:after, %%order_class%% [class^='imghvr-border'] figcaption:before, %%order_class%% [class^='imghvr-border'] figcaption:after",
					'declaration' => $dnxtiep_border_effect_color_phone_style,
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				) );

				ET_Builder_Element::set_style($render_slug, array(
					'selector'    => "%%order_class%% [class^='imghvr-']",
					'declaration' => "background: {$dnxtiep_hover_gradient_type}($dnxtiep_hover_gradient_apply, $dnxtiep_hover_gradient_color_one $dnxtiep_hover_gradient_start_position, $dnxtiep_hover_gradient_color_two $dnxtiep_hover_gradient_end_position);",
				) );

			} else if ( in_array( $dnxtiep_image_hover_effect, $blind_effects, true ) ) {
				ET_Builder_Element::set_style($render_slug, array(
					'selector'    => "%%order_class%% [class^='imghvr-'], %%order_class%% [class^='imghvr-blinds']:before, %%order_class%% [class^='imghvr-blinds']:after, %%order_class%% [class^='imghvr-blinds'] figcaption:before, %%order_class%% [class^='imghvr-blinds'] figcaption:after",
					'declaration' => "background: {$dnxtiep_hover_gradient_type}($dnxtiep_hover_gradient_apply, $dnxtiep_hover_gradient_color_one $dnxtiep_hover_gradient_start_position, $dnxtiep_hover_gradient_color_two $dnxtiep_hover_gradient_end_position);",
				) );
			} else if ( in_array( $dnxtiep_image_hover_effect, $book_effects, true ) ) {
				ET_Builder_Element::set_style($render_slug, array(
					'selector'    => "%%order_class%% [class^='imghvr-'], %%order_class%% [class^='imghvr-book']:before, %%order_class%% [class^='imghvr-book']:after, %%order_class%% [class^='imghvr-book'] figcaption:before, %%order_class%% [class^='imghvr-book'] figcaption:after",
					'declaration' => "background: {$dnxtiep_hover_gradient_type}($dnxtiep_hover_gradient_apply, $dnxtiep_hover_gradient_color_one $dnxtiep_hover_gradient_start_position, $dnxtiep_hover_gradient_color_two $dnxtiep_hover_gradient_end_position);",
				) );
			} else if ( in_array( $dnxtiep_image_hover_effect, $circle_effects, true ) ) {
				ET_Builder_Element::set_style($render_slug, array(
					'selector'    => "%%order_class%% [class^='imghvr-'], %%order_class%% [class^='imghvr-circle']:before, %%order_class%% [class^='imghvr-circle']:after, %%order_class%% [class^='imghvr-circle'] figcaption:before, %%order_class%% [class^='imghvr-circle'] figcaption:after",
					'declaration' => "background: {$dnxtiep_hover_gradient_type}($dnxtiep_hover_gradient_apply, $dnxtiep_hover_gradient_color_one $dnxtiep_hover_gradient_start_position, $dnxtiep_hover_gradient_color_two $dnxtiep_hover_gradient_end_position);",
				) );
			} else if ( in_array( $dnxtiep_image_hover_effect, $grad_effects, true ) ) {
				ET_Builder_Element::set_style($render_slug, array(
					'selector'    => "%%order_class%% [class^='imghvr-'], %%order_class%% [class^='imghvr-grad']:before, %%order_class%% [class^='imghvr-grad']:after, %%order_class%% [class^='imghvr-grad'] figcaption:before, %%order_class%% [class^='imghvr-grad'] figcaption:after",
					'declaration' => "background: {$dnxtiep_hover_gradient_type}($dnxtiep_hover_gradient_apply, $dnxtiep_hover_gradient_color_one $dnxtiep_hover_gradient_start_position, $dnxtiep_hover_gradient_color_two $dnxtiep_hover_gradient_end_position);",
				) );
			} else {
				ET_Builder_Element::set_style($render_slug, array(
					'selector'    => "%%order_class%% [class^='imghvr-'] figcaption",
					'declaration' => "background: {$dnxtiep_hover_gradient_type}($dnxtiep_hover_gradient_apply, $dnxtiep_hover_gradient_color_one $dnxtiep_hover_gradient_start_position, $dnxtiep_hover_gradient_color_two $dnxtiep_hover_gradient_end_position);",
				) );
			}
		}

		// Button BG Color
		$dnxtiep_btn_bg_color			= $this->props['dnxtiep_btn_bg_color'];
		$dnxtiep_btn_bg_color_hover   	= $this->get_hover_value( 'dnxtiep_btn_bg_color' );
		$dnxtiep_btn_bg_color_values	= et_pb_responsive_options()->get_property_values( $this->props, 'dnxtiep_btn_bg_color' );
		$dnxtiep_btn_bg_color_tablet	= isset( $dnxtiep_btn_bg_color_values['tablet'] ) ? $dnxtiep_btn_bg_color_values['tablet'] : '';
		$dnxtiep_btn_bg_color_phone		= isset( $dnxtiep_btn_bg_color_values['phone'] ) ? $dnxtiep_btn_bg_color_values['phone'] : '';

		if ( 'off' !== $this->props['dnxtiep_btn_bg_show_hide'] ) {
			$dnxtiep_btn_bg_color_style 		 = sprintf( 'background-color: %1$s;', esc_attr( $dnxtiep_btn_bg_color ) );
			$dnxtiep_btn_bg_color_tablet_style = '' !== $dnxtiep_btn_bg_color_tablet ? sprintf( 'background-color: %1$s;', esc_attr( $dnxtiep_btn_bg_color_tablet ) ) : '';
			$dnxtiep_btn_bg_color_phone_style  = '' !== $dnxtiep_btn_bg_color_phone ? sprintf( 'background-color: %1$s;', esc_attr( $dnxtiep_btn_bg_color_phone ) ) : '';
			
			$dnxtiep_btn_bg_color_style_hover  = '';

			if ( et_builder_is_hover_enabled( 'dnxtiep_btn_bg_color', $this->props ) ) {
				$dnxtiep_btn_bg_color_style_hover = sprintf( 'background-color: %1$s;', esc_attr( $dnxtiep_btn_bg_color_hover ) );
			}
			
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnxt-nie-uih-btn",
				'declaration' => $dnxtiep_btn_bg_color_style,
			) );
			
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnxt-nie-uih-btn",
				'declaration' => $dnxtiep_btn_bg_color_tablet_style,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
			) );

			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnxt-nie-uih-btn",
				'declaration' => $dnxtiep_btn_bg_color_phone_style,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
			) );

			if ( "" !== $dnxtiep_btn_bg_color_style_hover ) {
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => $this->add_hover_to_order_class( "%%order_class%% .dnxt-nie-uih-btn:hover" ),
					'declaration' => $dnxtiep_btn_bg_color_style_hover ,
				) );
			}
		}

		$this->apply_css($render_slug);
		return sprintf( 
			'<figure class="%5$s dnxtiep-imghvr-wrapper">
				%1$s
				<figcaption class="%6$s %7$s dnxtiep-imghvr-content">
					%2$s
					%3$s
					%4$s
				</figcaption>
			</figure>',
			$dnxtiep_img, 
			$dnxtiepheadingtext,
			wpautop( $description ),
			et_core_sanitized_previously( $button ),
			esc_attr( $dnxtiep_image_hover_effect_classes ), //5
			esc_attr( $dnxtiep_text_effect ),
			esc_attr( $dnxtiep_text_delay )
		);
	}

	public function apply_css($render_slug){


		/**
         * Custom Padding Margin Output
         *
        */

        Common::dnxt_set_style($render_slug, $this->props, "dnxtiep_caption_margin", "%%order_class%% [class^='imghvr-'] figcaption", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "dnxtiep_caption_padding", "%%order_class%% [class^='imghvr-'] figcaption", "padding");
		
		Common::dnxt_set_style($render_slug, $this->props, "dnxtiep_heading_margin", "%%order_class%% .dnxtiep-heading", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "dnxtiep_heading_padding", "%%order_class%% .dnxtiep-heading", "padding");

		Common::dnxt_set_style($render_slug, $this->props, "dnxtiep_description_margin", "%%order_class%% .dnxtiep-description", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "dnxtiep_description_padding", "%%order_class%% .dnxtiep-description", "padding");
		
		Common::dnxt_set_style($render_slug, $this->props, "dnxtiep_btn_margin", "%%order_class%% .dnxt-nie-uih-btn", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "dnxtiep_btn_padding", "%%order_class%% .dnxt-nie-uih-btn", "padding");



		if( "off" !== $this->props['dnxtiep_btn_icon'] && 'off' !== $this->props['dnxtiep_btn_switch'] ) {
			// Button Icon Placement
			if ( 'right' === $this->props['dnxtiep_btn_icon_placement'] ) {
				ET_Builder_Element::set_style($render_slug, array(
					'selector'    	=> "%%order_class%% .dnxt-nie-uih-btn::after",
					'declaration'	=> 'content: attr(data-icon);opacity: 1;'
				) );
			}else if( 'left' === $this->props['dnxtiep_btn_icon_placement'] ) {
				ET_Builder_Element::set_style($render_slug, array(
					'selector'    	=> "%%order_class%% .dnxt-nie-uih-btn::before",
					'declaration'	=> 'content: attr(data-icon);opacity: 1;'
				) );
			}

			if( 'on' === $this->props['dnxtiep_btn_on_hover'] && 'right' === $this->props['dnxtiep_btn_icon_placement']) {
				ET_Builder_Element::set_style($render_slug, array(
					'selector'    	=> "%%order_class%% .dnxtiep-btn-icon-on-hover:hover:after",
					'declaration'	=> 'left: auto;margin-left: .3em;opacity: 1 !important;'
				) );
			} else if ( 'on' === $this->props['dnxtiep_btn_on_hover'] && 'left' === $this->props['dnxtiep_btn_icon_placement'] ) {
				ET_Builder_Element::set_style($render_slug, array(
					'selector'    	=> "%%order_class%% .dnxtiep-btn-icon-on-hover:hover:before",
					'declaration'	=> 'right: auto;margin-right: .3em;opacity: 1 !important;'
				) );
			}
		}


		// Button Gradient
		$dnxtiep_btn_bg_gradient_apply      	= '';
		$dnxtiep_btn_bg_gradient_color_one 		= '';
		$dnxtiep_btn_bg_gradient_color_two 		= '';
		$dnxtiep_btn_bg_gradient_type	   		= '';
		$dnxtiep_btn_bg_gl             			= '';
		$dnxtiep_btn_bg_gr             			= '';
		$dnxtiep_btn_bg_gradient_start_position	= '';
		$dnxtiep_btn_bg_gradient_end_position  	= '';

		// checking gradient type
		if ( '' !== $this->props['dnxtiep_btn_gradient_type'] ) {
			$dnxtiep_btn_bg_gradient_type = $this->props['dnxtiep_btn_gradient_type'];
		}
		// Button Linear Gradient Direction
		if ( '' !== $this->props['dnxtiep_btn_gradient_type_linear_direction'] ) {
			$dnxtiep_btn_bg_gl = $this->props['dnxtiep_btn_gradient_type_linear_direction'];
		}

		// Button Radial Gradient Direction
		if ( '' !== $this->props['dnxtiep_btn_gradient_type_radial_direction'] ) {
			$dnxtiep_btn_bg_gr = $this->props['dnxtiep_btn_gradient_type_radial_direction'];
		}	
		// Button Apply gradient direcion
		if ( 'radial-gradient' === $this->props['dnxtiep_btn_gradient_type'] ) {
			$dnxtiep_btn_bg_gradient_apply = sprintf('%1$s', $dnxtiep_btn_bg_gr);
		} else if ( 'linear-gradient' === $this->props['dnxtiep_btn_gradient_type'] ) {
			$dnxtiep_btn_bg_gradient_apply = sprintf('%1$s', $dnxtiep_btn_bg_gl);
		}

		// Gradient color one for Button
		if ( '' !== $this->props['dnxtiep_btn_gradient_color_one'] ) {
			$dnxtiep_btn_bg_gradient_color_one = $this->props['dnxtiep_btn_gradient_color_one'];
		}
		// Gradient color two for Button
		if ( '' !== $this->props['dnxtiep_btn_gradient_color_two'] ) {
			$dnxtiep_btn_bg_gradient_color_two = $this->props['dnxtiep_btn_gradient_color_two'];
		}
		// Button Gradient color start position 
		if ( '' !== $this->props['dnxtiep_btn_gradient_start_position'] ) {
			$dnxtiep_btn_bg_gradient_start_position = $this->props['dnxtiep_btn_gradient_start_position'];
		}
		// Button Gradient color end position
		if ( '' !== $this->props['dnxtiep_btn_gradient_end_position'] ) {
			$dnxtiep_btn_bg_gradient_end_position = $this->props['dnxtiep_btn_gradient_end_position'];
		}
		// Button Gradient setting up
		if ( 'off' !== $this->props['dnxtiep_btn_gradient_show_hide'] ) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt-nie-uih-btn",
				'declaration' => "background: {$dnxtiep_btn_bg_gradient_type}($dnxtiep_btn_bg_gradient_apply, $dnxtiep_btn_bg_gradient_color_one $dnxtiep_btn_bg_gradient_start_position, $dnxtiep_btn_bg_gradient_color_two $dnxtiep_btn_bg_gradient_end_position);",
			) );
		}


		if ( 'center' === $this->props['dnxtiep_btn_align_tablet'] ) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxtiep-button",
				'declaration' => "justify-content: center;",
			) );
		} else if ( 'right'=== $this->props['dnxtiep_btn_align_tablet'] ) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxtiep-button",
				'declaration' => "justify-content: flex-end;",
			) );
		} else if ( 'left'=== $this->props['dnxtiep_btn_align_tablet'] ) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxtiep-button",
				'declaration' => "justify-content: flex-start;",
			) );
		}

		if ( 'center' === $this->props['dnxtiep_btn_align_phone'] ) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxtiep-button",
				'declaration' => "justify-content: center;",
			) );
		} else if ( 'right' === $this->props['dnxtiep_btn_align_phone'] ) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxtiep-button",
				'declaration' => "justify-content: flex-end;",
			) );
		} else if ( 'left' === $this->props['dnxtiep_btn_align_phone'] ) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxtiep-button",
				'declaration' => "justify-content: flex-start;",
			) );
		} 


		if ( 'center'=== $this->props['dnxtiep_btn_align'] ) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxtiep-button",
				'declaration' => "justify-content: center;",
			) );
		} else if ( 'right'=== $this->props['dnxtiep_btn_align'] ) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxtiep-button",
				'declaration' => "justify-content: flex-end;",
			) );
		} else if ( 'on|tablet' === $this->props['dnxtiep_btn_align_last_edited'] ) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxtiep-button",
				'declaration' => "{$this->props['dnxtiep_btn_align_tablet']}",
			) );
		} else if ( 'on|phone' === $this->props['dnxtiep_btn_align_last_edited'] ) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxtiep-button",
				'declaration' => "{$this->props['dnxtiep_btn_align_phone']}",
			) );
		} else {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxtiep-button",
				'declaration' => "justify-content: flex-start;",
			) );
		}
	}
}

new Next_Mega_Image_Effect;
