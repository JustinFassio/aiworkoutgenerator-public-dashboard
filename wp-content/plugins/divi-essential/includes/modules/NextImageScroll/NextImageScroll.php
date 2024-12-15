<?php
include_once(DIVI_ESSENTIAL_PATH.'/includes/modules/base/Common.php');

class Next_Image_Scroll extends ET_Builder_Module {

	public $slug       = 'dnxte_image_scroll';
	public $vb_support = 'on';

	protected $module_credits = array(
		'module_uri' => 'https://www.diviessential.com/divi-image-scroll-effect/',
		'author'     => 'Divi Next',
		'author_uri' => 'https://www.divinext.com',
	);

	public function init() {
		$this->name        = esc_html__( 'Next Image Scroll', 'et_builder' );
		$this->icon_path   = plugin_dir_path( __FILE__ ) . 'icon.svg';
		$this->folder_name = 'et_pb_divi_essential';

		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'dnxtiep_image'	=> array(
						'title'    => esc_html__( 'Image', 'et_builder' ),
						'priority' => 10,
					),
					'button'	=> array(
						'title'    => esc_html__( 'Button', 'et_builder' ),
						'priority' => 20,
					),
					'button_background'	=> array(
						'title'		=>	esc_html__( 'Background Button', 'et_builder' ),
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
					'link'      => esc_html__( 'Link', 'et_builder' ),
				),
			),
			'advanced' => array(
				'toggles' => array(
					'overlay'    => array(
						'title'		=>	esc_html__( 'Overlay', 'et_builder' ),
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
					'background_position'  	=> esc_html__( 'Background Position', 'et_builder' ),
					'button_font'	=> array(
						"title"		=>	esc_html__( 'Button Text', 'et_builder' ),
						'priority'	=>	60,
					),
					'button_space'	=> array(
						"title"		=>	esc_html__( 'Button', 'et_builder' ),
						'priority'	=>	80,
					),
					'alignment'  			=> esc_html__( 'Alignment', 'et_builder' ),
				),
			),
			'custom_css' => array(
				'toggles' => array(
					'animation' => array(
						'title'    => esc_html__( 'Animation', 'et_builder' ),
						'priority' => 90,
					),
					'attributes' => array(
						'title'    => esc_html__( 'Attributes', 'et_builder' ),
						'priority' => 95,
					),
				),
			),
		);

		$this->advanced_fields = array(
			'fonts' => array(
				'dnxt_btn_text' => array(
					'label'    			=> esc_html__( '', 'et_builder' ),
					'toggle_slug'   	=> 'button_font',
					'tab_slug'			=> 'advanced',
					'hide_text_align' 	=> true,
					'css'      => array(
						'main' => "%%order_class%% .dnext-neip-ise-button-item",
						'text_align'  => "%%order_class%% .dnext-neip-ise-button-item",
					),
				),
			),
			'margin_padding' => array(
				'css' => array(
					'important' => array( 'custom_margin' ),
				),
			),
			'borders'               => array(
				'default' => array(
					'css' => array(
						'main' => array(
							'border_radii'  => "%%order_class%% .dnext-neip-ise-wrapper",
							'border_styles' => "%%order_class%% .dnext-neip-ise-wrapper",
						),
					),
				),
				'button_border'     => array(
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'button_space',
					'css'          => array(
						'main'     => array(
							'border_radii'  		=> "%%order_class%% .dnext-neip-ise-bg-image a",
							'border_radii_hover'  	=> '%%order_class%% .dnext-neip-ise-bg-image a:hover',
							'border_styles' 		=> "%%order_class%% .dnext-neip-ise-bg-image a",
							'border_styles_hover' 	=> '%%order_class%% .dnext-neip-ise-bg-image a:hover',
						),
					),
				),
			),
			'box_shadow'            => array(
				'default' => array(
					'css' => array(
						'main'    => '%%order_class%% .dnext-neip-ise-wrapper',
						'overlay' => 'inset',
					),
				),
			),
			'max_width'             => array(
				'options' => array(
					'width'     => array(
						'depends_show_if' => 'off',
					),
					'max_width' => array(
						'depends_show_if' => 'off',
					),
				),
			),
			'height'                => array(
				'css' => array(
					'main' => '%%order_class%% .dnext-neip-ise-wrapper .dnext-neip-ise-bg-image',
				),
			),
			'text'                  => false,
			'button'                => false,
			'link_options'          => false,
		);

		// Custom CSS Field
		$this->custom_css_fields = array(
			'image_wrapper' => array(
				'label'    => esc_html__( 'Image', 'et_builder' ),
				'selector' => '%%order_class%% .dnext-neip-ise-bg-image',
			),
			'button_wrapper'  => array(
				'label'    => esc_html__( 'Button', 'et_builder' ),
				'selector' => '%%order_class%% .dnext-neip-ise-button-item',
			),
		);
	}

	public function get_fields() {
		return array(
			'dnxtnis_image' => array(
				'label'              => esc_html__( 'Image', 'et_builder' ),
				'type'               => 'upload',
				'option_category'    => 'basic_option',
				'upload_button_text' => esc_attr__( 'Upload an image', 'et_builder' ),
				'choose_text'        => esc_attr__( 'Choose an Image', 'et_builder' ),
				'update_text'        => esc_attr__( 'Set As Image', 'et_builder' ),
				'hide_metadata'      => true,
				'description'        => esc_html__( 'Upload your desired image, or type in the URL to the image you would like to display.', 'et_builder' ),
				'toggle_slug'        => 'dnxtiep_image',
				'dynamic_content'    => 'image',
				'mobile_options'     => true,
				'hover'				 => 'tabs',
			),
			'use_overlay' => array(
				'label'             => esc_html__( 'Image Overlay', 'et_builder' ),
				'type'              => 'yes_no_button',
				'options'           => array(
					'off' => esc_html__( 'Off', 'et_builder' ),
					'on'  => esc_html__( 'On', 'et_builder' ),
				),
				'default_on_front' => 'on',
				'affects'           => array(
					'dnxtnis_overlay_color',
				),
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'overlay',
				'sub_toggle'	 	=> 'sub_toggle_color',
				'description'       => esc_html__( 'If enabled, an overlay color and icon will be displayed when a visitors hovers over the image', 'et_builder' ),
			),
			'dnxtnis_overlay_color' => array(
				'label'             => esc_html__( 'Hover Overlay Color', 'et_builder' ),
				'type'              => 'color-alpha',
				'custom_color'      => true,
				'depends_show_if'   => 'on',
				'default'			=> '#0077FF',
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'overlay',
				'sub_toggle'	 	=> 'sub_toggle_color',
				'description'       => esc_html__( 'Here you can define a custom color for the overlay', 'et_builder' ),
				'mobile_options'	=> true,
				'responsive'      	=> true,
			),
			'dnxtnis_gradient_show_hide'	=>	array(
				'label'          => esc_html__( 'Image Gradient', 'et_builder' ),
				'type'           => 'yes_no_button',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'overlay',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'default'        => 'off',
				'options'        => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
			),
			'dnxtnis_gradient_color_one'        => array(
				'label'          => esc_html__( 'Select Color One', 'et_builder' ),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'overlay',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'default'        => '#2b87da',
				'show_if'        => array(
                    'dnxtnis_gradient_show_hide' => 'on',
                ),
			),
			'dnxtnis_gradient_color_two'        => array(
                'label'          => esc_html__( 'Select Color Two', 'et_builder' ),
                'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'overlay',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'default'        => '#29c4a9',
				'show_if'        => array(
                    'dnxtnis_gradient_show_hide' => 'on',
                ),
			),
			'dnxtnis_gradient_type'             => array(
                'label'           => esc_html__('Select Gradient Type', 'et_builder'),
                'type'            => 'select',
				'description'     => esc_html__('Select the types of gradient', 'et_builder'),
                'option_category'=> 'layout',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'overlay',
				'sub_toggle'	 => 'sub_toggle_gradient',
                'options'         => array(
                    'linear-gradient' => esc_html__('Linear', 'et_builder'),
                    'radial-gradient' => esc_html__('Radial', 'et_builder'),
                ),
				'default'         => 'linear-gradient',
				'show_if'        => array(
                    'dnxtnis_gradient_show_hide' => 'on',
                ),
			),
            'dnxtnis_gradient_type_linear_direction'   => array(
                'label'           => esc_html__('Gradient direction', 'et_builder'),
                'type'            => 'range',
				'option_category'=> 'layout',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'overlay',
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
					'dnxtnis_gradient_show_hide' => 'on',
					'dnxtnis_gradient_type' => 'linear-gradient'
                ),
			),
			'dnxtnis_gradient_type_radial_direction'   => array(
                'label'           => esc_html__('Radial Direction', 'et_builder'),
                'type'            => 'select',
				'description'     => esc_html__('Select the types of gradient', 'et_builder'),                
                'option_category'=> 'layout',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'overlay',
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
					'dnxtnis_gradient_show_hide' => 'on',
					'dnxtnis_gradient_type' => 'radial-gradient'
                ),
				
			),
			'dnxtnis_gradient_start_position'           => array(
                'label'          => esc_html__('Start Position', 'et_builder'),
                'type'           => 'range',
				'option_category'=> 'layout',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'overlay',
				'sub_toggle'	 => 'sub_toggle_gradient',
                'range_settings' => array(
                    'step' => 1,
                    'min'  => 1,
                    'max'  => 100,
                ),
                'default'        => '0%',
                'fixed_unit'     => '%',
				'validate_unit'  => true,
				'show_if'        => array(
                    'dnxtnis_gradient_show_hide' => 'on',
                ),
			),
			'dnxtnis_gradient_end_position'             => array(
                'label'           => esc_html__('End Position', 'et_builder'),
                'type'            => 'range',
				'option_category' => 'layout',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'overlay',
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
                    'dnxtnis_gradient_show_hide' => 'on',
                ),
            ),
			'dnxtnis_image_max_width'	=> array(
				'label'           	=> esc_html__( 'Image Width', 'et_builder' ),
				'description'     	=> esc_html__( 'Adjust the width of the image within the Scroll Image.', 'et_builder' ),
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
			),
			'dnxtnis_background_position'   => array(
                'type'            => 'select',
				'description'     => esc_html__('Select the types of background position', 'et_builder'),                
                'option_category' => 'layout',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'background_position',
                'options'         => array(
                    'top-to-bottom'       => esc_html__('Top Bottom', 'et_builder'),
                    'bottom-to-top'       => esc_html__('Bottom Top', 'et_builder'),

                ),
                'default'         => 'top-to-bottom',
			),
			'image_animation_duration'		=>	array(
				'label'            => esc_html__( 'Animation Duration', 'et_builder' ),
				'type'             => 'range',
				'range_settings'   => array(
					'min'  => 1,
					'max'  => 10,
					'step' => 0.1,
				),
                'fixed_unit'     	=> false,
                'unitless'          => true,
                'default'           => 3,
                'option_category' 	=> 'layout',
				'tab_slug'        	=> 'advanced',
				'toggle_slug'      => 'background_position',
				'hover'            => 'tabs',
				'description'      => esc_html__( 'Here you can control image animation duration control.', 'et_builder' ),
				'mobile_options'	=> true,
				'responsive'      	=> true,
			),
			'dnxtnis_btn_position'   => array(
				'label'            => esc_html__( 'Button Position', 'et_builder' ),
                'type'            => 'select',
				'description'     => esc_html__('Select the types of button position', 'et_builder'),                
                'option_category' => 'layout',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'button_space',
                'options'         => array(
                    'left-to-top'     => esc_html__('Left Top', 'et_builder'),
                    'left-to-bottom'  => esc_html__('Left Bottom', 'et_builder'),
                    'right-to-top'    => esc_html__('Right Top', 'et_builder'),
                    'right-to-bottom' => esc_html__('Right Bottom', 'et_builder'),
                    'center-center'   => esc_html__('Center Center', 'et_builder'),

                ),
                'default'         => 'right-to-top',
			),
			'dnxtnis_btn_show_hide' => array(
				'label'           => esc_html__( 'Button Show Hide', 'et_builder' ),
				'type'            => 'yes_no_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'et_builder' ),
					'on'  => esc_html__( 'Yes', 'et_builder' ),
				),
				'toggle_slug'     => 'button',
				'affects'         => array(
					'button_text',
					'button_link',
					'button_link_new_window'
				),
				'default_on_front'=> 'on',
			),
			'button_text'      => array(
				'label'           => esc_html__( 'Button Text', 'et_builder' ),
				'type'            => 'text',
				'dynamic_content' => 'text',
				'default'         => 'Button Text',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'button',
				'depends_show_if' 	=> 'on',
			),
			'button_link'      => array(
				'label'           => esc_html__( 'Button Link', 'et_builder' ),
				'description'     => esc_html__( 'When clicked the module will link to this URL.', 'et_builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'toggle_slug'     => 'button',
				'dynamic_content' => 'url',
				'depends_show_if' 	=> 'on',
			),
			'button_link_new_window'		=> array(
				'label'				=> esc_html__( 'Button Link Target', 'et_builder' ),
				'description'      	=> esc_html__( 'Here you can choose whether or not your link opens in a new window', 'et_builder' ),
				'type'             	=> 'select',
				'option_category'  	=> 'configuration',
				'options'         	=> array(
					'off' => esc_html__( 'In The Same Window', 'et_builder' ),
					'on'  => esc_html__( 'In The New Tab', 'et_builder' ),
				),
				'toggle_slug'      => 'button',
				'default_on_front' => 'off',
				'depends_show_if' 	=> 'on',
			),
			'btn_show_hide'  => array(
				'label'           => esc_html__( 'Button Background Color', 'et_builder'),
				'type'            => 'yes_no_button',                
				'toggle_slug'     => 'button_background',
				'sub_toggle'	  => 'sub_toggle_color',
				'options'             => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'affects'         => array(
					'button_bg',
				),
				'default_on_front' => 'on',
			),
			'button_bg'        => array(
				'label'          => esc_html__('Select Background Color', 'et_builder'),
				'type'           => 'color-alpha',
				'toggle_slug'    => 'button_background',
				'sub_toggle'	 => 'sub_toggle_color',
				'hover'    		 => 'tabs',
				'default'        => '#0077FF',
				'depends_show_if'=> 'on',
			),
			'btn_gradient_show_hide'  => array(
				'label'           => esc_html__( 'Button Gradient Color', 'et_builder'),
				'type'            => 'yes_no_button',                
				'toggle_slug'     => 'button_background',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'options'             => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'affects'         => array(
					'btn_gradient_color_one',
					'btn_gradient_color_two',
					'btn_gradient_type',
					'btn_gradient_start_position',
					'btn_gradient_end_position'
				),
				'default_on_front' => 'off',
				'depends_show_if' 	=> 'on',
			),
			'btn_gradient_color_one'	=> array(
				'label'          => esc_html__('Select Color One', 'et_builder'),
				'type'           => 'color-alpha',
				'toggle_slug'    => 'button_background',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'default'        => '#2b87da',
				'depends_show_if'=> 'on',
			),
			'btn_gradient_color_two'	=> array(
				'label'          => esc_html__('Select Color Two', 'et_builder'),
				'type'           => 'color-alpha',
				'toggle_slug'    => 'button_background',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'default'        => '#29c4a9',
				'depends_show_if'=> 'on',
			),
			'btn_gradient_type'		=> array(
				'label'           => esc_html__('Select Gradient Type', 'et_builder'),
				'type'            => 'select',
				'description'     => esc_html__('Select the types of gradient', 'et_builder'),
				'option_category' => 'basic_option',
				'toggle_slug'     => 'button_background',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'options'         => array(
					'linear-gradient' => esc_html__('Linear', 'et_builder'),
					'radial-gradient' => esc_html__('Radial', 'et_builder'),
				),
				'default'         => 'linear-gradient',
				'depends_show_if' => 'on',
			),
			'btn_gradient_type_linear_direction'   => array(
				'label'           => esc_html__('Gradient direction', 'et_builder'),
				'type'            => 'range',
				'option_category'=> 'basic_option',
				'toggle_slug'    => 'button_background',
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
			'btn_gradient_type_radial_direction'   => array(
				'label'           	=> esc_html__('Radial Direction', 'et_builder'),
				'type'            	=> 'select',
				'description'     	=> esc_html__('Select the types of gradient', 'et_builder'),                
				'option_category'	=> 'basic_option',
				'toggle_slug'    	=> 'button_background',
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
			'btn_gradient_start_position'           => array(
				'label'           => esc_html__('Start Position', 'et_builder'),
				'type'            => 'range',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'button_background',
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
			'btn_gradient_end_position'             => array(
				'label'           => esc_html__('End Position', 'et_builder'),
				'type'            => 'range',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'button_background',
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
			'dnxt_button_margin' =>		array(
				'label'           => esc_html__('Button Margin', 'et_builder'),
                'type'            => 'custom_margin',
                'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
				'toggle_slug'     => 'button_space',
			),
			'dnxt_button_padding' =>	array(
				'label'           => esc_html__('Button Padding', 'et_builder'),
                'type'            => 'custom_padding',
                'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
				'toggle_slug'     => 'button_space',
			),
		);
	}

	public function render( $attrs, $content, $render_slug ) {

		$multi_view 	 			= et_pb_multi_view_options( $this );
		$use_overlay             	= $this->props['use_overlay'];
		$dnxtnis_image			 	= $this->props['dnxtnis_image'];
		$dnxtnis_image_hover 		= $this->get_hover_value( 'dnxtnis_image' );
		$dnxtnis_image_tablet		= $this->props['dnxtnis_image_tablet'];
		$dnxtnis_image_phone		= $this->props['dnxtnis_image_phone'];
		$dnxtnis_image_last_edited	= $this->props['dnxtnis_image_last_edited'];


		// Image
		if ( '' !== $dnxtnis_image ) { 
			$dnxtnis_image_style 		 	= sprintf( 'background-image: url("%1$s");', esc_url( $dnxtnis_image ) );
			$dnxtnis_image_tablet_style 	= '' !== $dnxtnis_image_tablet ? sprintf( 'background-image: url("%1$s")', esc_url( $dnxtnis_image_tablet ) ) : '';
			$dnxtnis_image_phone_style  	= '' !== $dnxtnis_image_phone ? sprintf( 'background-image: url("%1$s")', esc_url( $dnxtnis_image_phone ) ) : '';
			
			$dnxtnis_image_style_hover  = '';

			if ( et_builder_is_hover_enabled( 'dnxtnis_image', $this->props ) ) {
				$dnxtnis_image_style_hover = sprintf( 'background-image: url("%1$s")', esc_url( $dnxtnis_image_hover ) );
			}


			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnext-neip-ise-wrapper .dnext-neip-ise-bg-image",
				'declaration' => $dnxtnis_image_style,
			) );
			
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnext-neip-ise-wrapper .dnext-neip-ise-bg-image",
				'declaration' => $dnxtnis_image_tablet_style,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
			) );

			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnext-neip-ise-wrapper .dnext-neip-ise-bg-image",
				'declaration' => $dnxtnis_image_phone_style,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
			) );

			if ( "" !== $dnxtnis_image_style_hover ) {
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => $this->add_hover_to_order_class( "%%order_class%% .dnext-neip-ise-bg-image:hover" ),
					'declaration' => $dnxtnis_image_style_hover,
				) );
			}
		}

		$dnxtnis_image_max_width    			= $this->props['dnxtnis_image_max_width'];
		$dnxtnis_image_max_width_tablet   		= $this->props['dnxtnis_image_max_width_tablet'];
		$dnxtnis_image_max_width_phone  		= $this->props['dnxtnis_image_max_width_phone'];
		$dnxtnis_image_max_width_last_edited  	= $this->props['dnxtnis_image_max_width_last_edited'];



		if ( '' !== $dnxtnis_image_max_width ) { 
			$dnxtnis_image_max_width_responsive_active = et_pb_get_responsive_status( $dnxtnis_image_max_width_last_edited );
		
			$dnxtnis_image_max_width_values = array(
				'desktop' => $dnxtnis_image_max_width,
				'tablet'  => $dnxtnis_image_max_width_responsive_active ? $dnxtnis_image_max_width_tablet : '',
				'phone'   => $dnxtnis_image_max_width_responsive_active ? $dnxtnis_image_max_width_phone : '',
			);
			$dnxtnis_image_max_width_selector	= "%%order_class%% .dnext-neip-ise-wrapper";
			et_pb_responsive_options()->generate_responsive_css( $dnxtnis_image_max_width_values, $dnxtnis_image_max_width_selector, 'width', $render_slug );
			
		}

	$image_animation_duration        = $this->props['image_animation_duration'];
	$image_animation_duration_tablet = $this->props['image_animation_duration_tablet'];
	$image_animation_duration_phone  = $this->props['image_animation_duration_phone'];

	if ( '' !== $image_animation_duration ) { 
		$image_animation_duration_style 		 	= sprintf( 'transition: background-position %1$ss ease-in-out 0ms;', esc_attr( $image_animation_duration ) );
		$image_animation_duration_tablet_style 	= '' !== $image_animation_duration_tablet ? sprintf( 'transition: background-position %1$ss ease-in-out 0ms;', esc_attr( $image_animation_duration_tablet ) ) : '';
		$image_animation_duration_phone_style  	= '' !== $image_animation_duration_phone ? sprintf( 'transition: background-position %1$ss ease-in-out 0ms;', esc_attr( $image_animation_duration_phone ) ) : '';
		
		$image_animation_duration_style_hover  = '';

		if ( et_builder_is_hover_enabled( 'image_animation_duration', $this->props ) ) {
			$image_animation_duration_style_hover = sprintf( 'transition: background-position %1$ss ease-in-out 0ms;', esc_attr( $image_animation_duration_hover ) );
		}

		ET_Builder_Element::set_style( $render_slug, array(
			'selector'    => "%%order_class%% .dnext-neip-ise-wrapper .dnext-neip-ise-bg-image",
			'declaration' => $image_animation_duration_style,
		) );
		
		ET_Builder_Element::set_style( $render_slug, array(
			'selector'    => "%%order_class%% .dnext-neip-ise-wrapper .dnext-neip-ise-bg-image",
			'declaration' => $image_animation_duration_tablet_style,
			'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
		) );

		ET_Builder_Element::set_style( $render_slug, array(
			'selector'    => "%%order_class%% .dnext-neip-ise-wrapper .dnext-neip-ise-bg-image",
			'declaration' => $image_animation_duration_phone_style,
			'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
		) );

		if ( '' !== $image_animation_duration_style_hover ) {
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => $this->add_hover_to_order_class( '%%order_class%% .dnext-neip-ise-wrapper .dnext-neip-ise-bg-image' ),
				'declaration' => $image_animation_duration_style_hover,
			) );
		}
	}

		// Overlay Color
		$dnxtnis_overlay_color			= $this->props['dnxtnis_overlay_color'];
		$dnxtnis_overlay_color_values	= et_pb_responsive_options()->get_property_values( $this->props, 'dnxtnis_overlay_color' );
		$dnxtnis_overlay_color_tablet	= isset( $dnxtnis_overlay_color_values['tablet'] ) ? $dnxtnis_overlay_color_values['tablet'] : '';
		$dnxtnis_overlay_color_phone	= isset( $dnxtnis_overlay_color_values['phone'] ) ? $dnxtnis_overlay_color_values['phone'] : '';

		if ( 'off' !== $use_overlay ) {
			$dnxtnis_overlay_color_style 		 	= sprintf( 'background: %1$s;', esc_attr( $dnxtnis_overlay_color ) );
			$dnxtnis_overlay_color_tablet_style 	= '' !== $dnxtnis_overlay_color_tablet ? sprintf( 'background: %1$s;', esc_attr( $dnxtnis_overlay_color_tablet ) ) : '';
			$dnxtnis_overlay_color_phone_style  	= '' !== $dnxtnis_overlay_color_phone ? sprintf( 'background: %1$s;', esc_attr( $dnxtnis_overlay_color_phone ) ) : '';
			
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnext-neip-ise-overlay",
				'declaration' => $dnxtnis_overlay_color_style,
			) );
			
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnext-neip-ise-overlay",
				'declaration' => $dnxtnis_overlay_color_tablet_style,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
			) );

			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnext-neip-ise-overlay",
				'declaration' => $dnxtnis_overlay_color_phone_style,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
			) );
		}

		//GRADIENT COLOR 
		$dnxtnis_gradient_color_one = $this->props['dnxtnis_gradient_color_one'];
		$dnxtnis_gradient_color_two = $this->props['dnxtnis_gradient_color_two'];
			// Other gradient options
			$dnxtnis_gradient_type 				= $this->props['dnxtnis_gradient_type'];
			$dnxtnis_gradient_start_position 	= $this->props['dnxtnis_gradient_start_position'];
			$dnxtnis_gradient_end_position 		= $this->props['dnxtnis_gradient_end_position'];

			$dnxtnis_gradient_direction = $dnxtnis_gradient_type === 'linear-gradient' ? $this->props['dnxtnis_gradient_type_linear_direction'] : $this->props['dnxtnis_gradient_type_radial_direction'];
		
			if( 'off' !== $this->props['dnxtnis_gradient_show_hide'] ) {
				$dnxtnis_overlay_gradient = sprintf('background: %1$s(%2$s, %3$s %5$s, %4$s %6$s)', $dnxtnis_gradient_type, $dnxtnis_gradient_direction, esc_attr($dnxtnis_gradient_color_one), esc_attr($dnxtnis_gradient_color_two), $dnxtnis_gradient_start_position, $dnxtnis_gradient_end_position);
				
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => "%%order_class%% .dnext-neip-ise-overlay",
					'declaration' => $dnxtnis_overlay_gradient,
				) );
			}
		
		$dnxtnis_background_position	= $this->props['dnxtnis_background_position'];
		if ( 'bottom-to-top' == $dnxtnis_background_position ) {
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnext-neip-ise-wrapper .dnext-neip-ise-bg-image",
				'declaration' => "background-position: center 100%;",
			) );
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnext-neip-ise-wrapper .dnext-neip-ise-bg-image:hover",
				'declaration' => "background-position: center 0 !important;",
			) );
		} else {
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnext-neip-ise-wrapper .dnext-neip-ise-bg-image",
				'declaration' => "background-position: center 0;",
			) );
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnext-neip-ise-wrapper .dnext-neip-ise-bg-image:hover",
				'declaration' => "background-position: center 100%;",
			) );
		}

		$button = "";
		if ( 'off' !== $this->props['dnxtnis_btn_show_hide'] ) {
			$button_text          = $this->props['button_text'];
			$button_link          = $this->props['button_link'];
			$dnxtnis_btn_position = $this->props['dnxtnis_btn_position'];

			$button_target = 'on' === $this->props['button_link_new_window'] ? '_blank' : '_self';


			$button = sprintf(
				'<a href="%1$s" class="dnext-neip-ise-button-item dnext_neip_ise_button_%4$s" target="%2$s">%3$s</a>',
				$button_link,
				$button_target,
				$button_text,
				$dnxtnis_btn_position
			);
		}
		
		// Button Color
		$button_bg = $this->props['button_bg'];

		if ('on' === $this->props['btn_show_hide']){
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnext-neip-ise-button-item",
				'declaration' => "background: $button_bg;",
			) );
		}

		//Button GRADIENT COLOR 
		$btn_gradient_color_one = $this->props['btn_gradient_color_one'];
		$btn_gradient_color_two = $this->props['btn_gradient_color_two'];
			// Other gradient options
			$btn_gradient_type 				= $this->props['btn_gradient_type'];
			$btn_gradient_start_position 	= $this->props['btn_gradient_start_position'];
			$btn_gradient_end_position 		= $this->props['btn_gradient_end_position'];

			$btn_gradient_direction = $btn_gradient_type === 'linear-gradient' ? $this->props['btn_gradient_type_linear_direction'] : $this->props['btn_gradient_type_radial_direction'];
		
			if( 'off' !== $this->props['btn_gradient_show_hide'] ) {
				$btn_gradient = sprintf('background: %1$s(%2$s, %3$s %5$s, %4$s %6$s)', $btn_gradient_type, $btn_gradient_direction, esc_attr($btn_gradient_color_one), esc_attr($btn_gradient_color_two), $btn_gradient_start_position, $btn_gradient_end_position);
				
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => "%%order_class%% .dnext-neip-ise-button-item",
					'declaration' => $btn_gradient,
				) );
			}
		
		$this->apply_css($render_slug);

		return sprintf( 
			'<div class="dnext-neip-ise-wrapper">
				<div class="dnext-neip-ise-bg-image">
					<div class="dnext-neip-ise-overlay"></div>
					%1$s
				</div>
			</div>',
			$button
		);
	}

	public function apply_css($render_slug){
		/**
         * Custom Padding Margin Output
         *
        */

        Common::dnxt_set_style($render_slug, $this->props, "dnxt_button_margin", "%%order_class%% .dnext-neip-ise-button-item", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "dnxt_button_padding", "%%order_class%% .dnext-neip-ise-button-item", "padding");
	}
}

new Next_Image_Scroll;
