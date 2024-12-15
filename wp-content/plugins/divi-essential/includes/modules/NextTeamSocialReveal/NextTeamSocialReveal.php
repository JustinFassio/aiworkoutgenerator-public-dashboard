<?php
include_once(DIVI_ESSENTIAL_PATH.'/includes/modules/base/Common.php');

class Next_Team_Social_Reveal extends ET_Builder_Module {

	public $slug    		= 'dnxte_team_social_reveal';
	public $vb_support 		= 'on';
	public $child_slug 		= 'dnxte_team_social_reveal_child';
	public $main_css_element= '%%order_class%%';
	


	protected $module_credits = array(
		'module_uri' => 'https://www.diviessential.com/divi-team-social-reveal/',
		'author'     => 'Divi Next',
		'author_uri' => 'www.divinext.com',
	);

	public function init() {
		$this->name 	  		= esc_html__( 'Next Team Social Reveal', 'et_builder' );
		$this->icon_path        =  plugin_dir_path( __FILE__ ) . 'icon.svg';
		$this->folder_name 		= 'et_pb_divi_essential';

		$this->settings_modal_toggles = array(
			'general'	=> array(
				'toggles'		=>	array(
					'dnext_team_img'	=> array(
						'title'		=> esc_html__( 'Image', 'et_builder' ),
					),
					'teamsorev_img_bgc'	=> array(
						'title'		=>	esc_html__( 'Image Background', 'et_builder' ),
						'priority'	=>	80,
						'sub_toggles'       => array(
                            'sub_toggle_color'   => array(
								'icon' => 'background-color',
                            ),
                            'sub_toggle_gradient'   => array(
								'icon' => 'background-gradient',
							),
							'sub_toggle_image'   => array(
								'icon' => 'background-image',
                            )
                        ),
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
					),
					'teamsorev_bgc'	=> array(
						'title'		=>	esc_html__( 'Content Background', 'et_builder' ),
						'priority'	=>	80,
						'sub_toggles'       => array(
                            'sub_toggle_color'   => array(
								'icon' => 'background-color',
                            ),
                            'sub_toggle_gradient'   => array(
								'icon' => 'background-gradient',
							),
                        ),
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
					),
				),
			),
			'advanced'	=> array(
				'toggles'	=>	array(
					'teamsorev_effect'	=> array(
						'title'		=>	esc_html__( 'Style', 'et_builder' ),
					),
					'teamsorev_image'	=> array(
						'title'		=> esc_html__( 'Image', 'et_builder' ),
					),
					'teamsorev_borders'	=> array(
						'title'		=>	esc_html__( 'Content Border', 'et_builder' ),
						'priority'	=>	91,
					),
				), 
			),			
			'custom_css' => array(
				'toggles' => array(),
			),
		);

		$this->advanced_fields = array(
			'fonts'                 => array(
				'header' => array(
					'label'    => esc_html__( 'Title', 'et_builder' ),
					'css'      => array(
						'main'      => "%%order_class%% h4.dnxte-teamsorev-team-header,%%order_class%% h1.dnxte-teamsorev-team-header,%%order_class%% h2.dnxte-teamsorev-team-header,%%order_class%% h3.dnxte-teamsorev-team-header,%%order_class%% h5.dnxte-teamsorev-team-header,%%order_class%% h6.dnxte-teamsorev-team-header",
						'important' => 'plugin_only',
					),
					'header_level' => array(
						'default' => 'h4',
					),
				),
				'body'     => array(
					'label'          => esc_html__( 'Body', 'et_builder' ),
					'css'            => array(
						'main'  => "%%order_class%% .dnxte-teamsorev-team-con-wrapper p:last-child",
					),
					'block_elements' => array(
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
					),
				),
				'position' => array(
					'label'          => esc_html__( 'Position', 'et_builder' ),
					'css'            => array(
						'main' => "%%order_class%% .dnxte-teamsorev-team-con-wrapper p.dnxte-teamsorev-team-pos",
					),
					'line_height'    => array(
						'default' => '1.7em',
					),
					'font_size'      => array(
						'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
					),
					'letter_spacing' => array(
						'default' => '0px',
					),
				),
			),
			'background'            => array(
				'settings' => array(
					'color' => 'alpha',
				),
				'css'   => array(
					'main' => "%%order_class%% .dnxte-teamsorev-team-wrapper",
					'important' => true,
				),
			),
			'borders'               => array(
				'default' => array(),
				'image' => array(
					'css'          => array(
						'main' => array(
							'border_radii'  => "%%order_class%% .dnxte-teamsorev-mem-img img",
							'border_styles' => "%%order_class%% .dnxte-teamsorev-mem-img img",
						),
					),
					'label_prefix' => esc_html__( 'Image', 'et_builder' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'teamsorev_image',
				),
				'content_border'     => array(
					'tab_slug'     	=> 'advanced',
					'toggle_slug'  	=> 'teamsorev_borders',
					'css'          => array(
						'main'     => array(
							'border_radii'  		=> "%%order_class%% .dnxte-teamsorev-team-con-wrapper",
							'border_radii_hover'  	=> '%%order_class%%:hover .dnxte-teamsorev-team-con-wrapper',
							'border_styles' 		=> "%%order_class%% .dnxte-teamsorev-team-con-wrapper",
							'border_styles_hover' 	=> '%%order_class%%:hover .dnxte-teamsorev-team-con-wrapper',
						),
					),
					'defaults'        => array(
						'border_radii'  => 'on|0px|0px|0px|0px',
						'border_styles' => array(
							'width' => '0px',
							'color' => '#2857b6',
							'style' => 'solid',
						),
					),
				),
			),
			'box_shadow'            => array(
				'default' => array(),
				'image'   => array(
					'label'           => esc_html__( 'Image Box Shadow', 'et_builder' ),
					'option_category' => 'layout',
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'teamsorev_image',
					'css'          => array(
						'main'         => '%%order_class%% .dnxte-teamsorev-mem-img img',
						'custom_style' => true,
					),
					'default_on_fronts'  => array(
						'color'    => '',
						'position' => '',
					),
				),
			),
			'margin_padding' => array(
				'css' => array(
					'important' => 'all',
				),
			),
			'max_width'             => array(
				'css' => array(
					'module_alignment' => '%%order_class%%.dnxte_team_social_reveal',
				),
			),
			'text'                  => array(
				'use_background_layout' => true,
				'options' => array(
					'background_layout' => array(
						'default' => 'light',
						'hover'   => 'tabs',
					),
				),
				'css' => array(
					'main' => implode(', ', array(
						'%%order_class%% .et_pb_module_header',
						'%%order_class%% .et_pb_member_position',
						'%%order_class%% .et_pb_team_member_description p',
					))
				)
			),
			'filters'               => array(
				'css' => array(
					'main' => '%%order_class%%',
				),
				'child_filters_target' => array(
					'tab_slug' => 'advanced',
					'toggle_slug' => 'image',
				),
			),
			'button'     => false,
			'text'       => false,
		);

		// Custom CSS Field
		$this->custom_css_fields = array(
			'teamsorev_image_wrapper'  => array(
				'label'    => esc_html__( 'Image', 'et_builder' ),
				'selector' => '%%order_class%% .dnxte-teamsorev-mem-img',
			),
			'teamsorev_content_wrapper'  => array(
				'label'    => esc_html__( 'Content Body', 'et_builder' ),
				'selector' => '%%order_class%% .dnxte-teamsorev-mem-des',
			),
			'teamsorev_title_wrapper'  => array(
				'label'    => esc_html__( 'Title', 'et_builder' ),
				'selector' => '%%order_class%% .dnxte-teamsorev-team-header',
			),
			'teamsorev_position_wrapper'  => array(
				'label'    => esc_html__( 'Position', 'et_builder' ),
				'selector' => '%%order_class%% .dnxte-teamsorev-team-pos',
			),
			'teamsorev_body_wrapper'  => array(
				'label'    => esc_html__( 'Body', 'et_builder' ),
				'selector' => '%%order_class%% .dnxte-teamsorev-team-detals p',
			),
		);
	}

	public function get_fields() {
		$fields = array(
			// Image
			'teamsorev_image'			=> array(
				'label'              	=> esc_html__( 'Image', 'et_builder' ),
				'type'               	=> 'upload',
				'option_category'    	=> 'basic_option',
				'upload_button_text' 	=> esc_attr__( 'Upload an image', 'et_builder' ),
				'choose_text'        	=> esc_attr__( 'Choose an Image', 'et_builder' ),
				'update_text'        	=> esc_attr__( 'Set As Image', 'et_builder' ),
				'description'        	=> esc_html__( 'Upload an image to display at the top of your team social reveal.', 'et_builder' ),
				'toggle_slug'        	=> 'dnext_team_img',
				'dynamic_content'    	=> 'image',
				'mobile_options'    	=> true,
				'hover'					=> 'tabs',
			),
			'teamsorev_name' 	  => array(
				'label'           => esc_html__( 'Name', 'et_builder' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Input the name of the person', 'et_builder' ),
				'toggle_slug'     => 'main_content',
				'dynamic_content' => 'text',
				'mobile_options'  => true,
				'hover'           => 'tabs',
			),
			'teamsorev_position'  => array(
				'label'           => esc_html__( 'Position', 'et_builder' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( "Input the person's position.", 'et_builder' ),
				'toggle_slug'     => 'main_content',
				'dynamic_content' => 'text',
				'mobile_options'  => true,
				'hover'           => 'tabs',
			),
			'teamsorev_content'   => array(
				'label'           => esc_html__( 'Body', 'et_builder' ),
				'type'            => 'tiny_mce',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Input the main text content for your module here.', 'et_builder' ),
				'toggle_slug'     => 'main_content',
				'dynamic_content' => 'text',
				'mobile_options'  => true,
				'hover'           => 'tabs',
			),
			'teamsorev_img_width'	=> array(
				'label'           	=> esc_html__( 'Image Width', 'et_builder' ),
				'description'     	=> esc_html__( 'Adjust the width of the image within the team.', 'et_builder' ),
				'type'            	=> 'range',
				'option_category' 	=> 'layout',
				'tab_slug'        	=> 'advanced',
				'toggle_slug'     	=> 'teamsorev_image',
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
				'hover'             => 'tabs',
			),
			'teamsorev_img_alignment'            => array(
                'label'           => esc_html__('Image Alignment', 'et_builder'),
                'type'            => 'align',
                'option_category' => 'configuration',
                'options'         => et_builder_get_text_orientation_options(array('justified')),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'teamsorev_image',
                'mobile_options'  => true,
                'description'     => esc_html__('Here you can define the alignment of Image', 'et_builder'),
			),			
			'teamsorev_style'		=> array(
				'label'				=> esc_html__( '', 'et_builder' ),
				'description'       => esc_html__( 'Choose where Team', 'et_builder' ),
				'type'              => 'select',
				'option_category'	=> 'layout',
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'teamsorev_effect',
				'options'           => array(
					'01'	=> esc_html__( 'Team 01', 'et_builder' ),
					'02'	=> esc_html__( 'Team 02', 'et_builder' ),
				),
				'default'            => '01',
			),
			'teamsorev_image_bgc_show_hide'  => array(
				'label'           => esc_html__( 'Background Color', 'et_builder'),
				'type'            => 'yes_no_button',                
				'toggle_slug'     => 'teamsorev_img_bgc',
				'sub_toggle'	  => 'sub_toggle_color',
				'options'             => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'affects'         => array(
					'teamsorev_img_bgc_color',
				),
				'default_on_front' => 'off',
			),
			'teamsorev_img_bgc_color'       => array(
				'label'          	=> esc_html__('Select Background Color', 'et_builder'),
				'type'           	=> 'color-alpha',
				'toggle_slug'     	=> 'teamsorev_img_bgc',
				'sub_toggle'	  	=> 'sub_toggle_color',
				'default'        	=> '#FFFFFF',
				'mobile_options'	=> true,
				'depends_show_if'	=> 'on',
			),
			'teamsorev_img_gradient_show_hide'  => array(
				'label'           => esc_html__( 'Background Gradient Color', 'et_builder'),
				'type'            => 'yes_no_button',                
				'toggle_slug'     => 'teamsorev_img_bgc',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'options'             => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'affects'         => array(
					'teamsorev_img_gradient_color_one',
					'teamsorev_img_gradient_color_two',
					'teamsorev_img_gradient_type',
					'teamsorev_img_gradient_start_position',
					'teamsorev_img_gradient_end_position'
				),
				'default_on_front' => 'off',
				'depends_show_if' 	=> 'on',
			),
			'teamsorev_img_gradient_color_one'	=> array(
				'label'          => esc_html__('Select Color One', 'et_builder'),
				'type'           => 'color-alpha',
				'toggle_slug'    => 'teamsorev_img_bgc',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'default'        => '#2b87da',
				'depends_show_if'=> 'on',
			),
			'teamsorev_img_gradient_color_two'	=> array(
				'label'          => esc_html__('Select Color Two', 'et_builder'),
				'type'           => 'color-alpha',
				'toggle_slug'    => 'teamsorev_img_bgc',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'default'        => '#29c4a9',
				'depends_show_if'=> 'on',
			),
			'teamsorev_img_gradient_type' => array(
				'label'           => esc_html__('Select Gradient Type', 'et_builder'),
				'type'            => 'select',
				'description'     => esc_html__('Select the types of gradient', 'et_builder'),
				'option_category' => 'basic_option',
				'toggle_slug'     => 'teamsorev_img_bgc',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'options'         => array(
					'linear-gradient' => esc_html__('Linear', 'et_builder'),
					'radial-gradient' => esc_html__('Radial', 'et_builder'),
				),
				'default'         => 'linear-gradient',
				'depends_show_if' => 'on',
			),
			'teamsorev_img_gradient_type_linear_direction'   => array(
				'label'           => esc_html__('Linear direction', 'et_builder'),
				'type'            => 'range',
				'option_category'=> 'basic_option',
				'toggle_slug'    => 'teamsorev_img_bgc',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'range_settings'  => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 360,
				),
				'default'         => '180deg',
				'fixed_unit'      => 'deg',
				'show_if' => array(
					'teamsorev_img_gradient_show_hide' => 'on',
					'teamsorev_img_gradient_type' => 'linear-gradient'
				),
			),
			'teamsorev_img_gradient_type_radial_direction'   => array(
				'label'           	=> esc_html__('Radial Direction', 'et_builder'),
				'type'            	=> 'select',
				'description'     	=> esc_html__('Select the types of gradient', 'et_builder'),                
				'option_category'	=> 'basic_option',
				'toggle_slug'    	=> 'teamsorev_img_bgc',
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
					'teamsorev_img_gradient_show_hide' 		=> 'on',
					'teamsorev_img_gradient_type'	=> 'radial-gradient'
				),
			),
			'teamsorev_img_gradient_start_position'           => array(
				'label'           => esc_html__('Start Position', 'et_builder'),
				'type'            => 'range',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'teamsorev_img_bgc',
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
			'teamsorev_img_gradient_end_position'             => array(
				'label'           => esc_html__('End Position', 'et_builder'),
				'type'            => 'range',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'teamsorev_img_bgc',
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
			'teamsorev_img_bgi_show_hide' => array(
				'label'           => esc_html__( 'Background Image', 'et_builder'),
				'type'            => 'yes_no_button',                
				'toggle_slug'     => 'teamsorev_img_bgc',
				'sub_toggle'	  => 'sub_toggle_image',
				'options'             => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'affects'         => array(
					'teamsorev_img_bgi_image',
				),
				'default_on_front' => 'off',
			),
			'teamsorev_img_bgi_image'    	 => array(
				'label'          	 => esc_html__('Upload Background Image', 'et_builder'),
				'type'           	 => 'upload',
				'upload_button_text' => esc_attr__( 'Upload an image', 'et_builder' ),
				'choose_text'        => esc_attr__( 'Choose an Image', 'et_builder' ),
				'update_text'        => esc_attr__( 'Set As Image', 'et_builder' ),
				'toggle_slug'    	 => 'teamsorev_img_bgc',
				'sub_toggle'	 	 => 'sub_toggle_image',
				'option_category'	 => 'basic_option',
				'mobile_options' 	 => true,
			),
			'teamsorev_bgc_show_hide'  => array(
				'label'           => esc_html__( 'Background Color', 'et_builder'),
				'type'            => 'yes_no_button',                
				'toggle_slug'     => 'teamsorev_bgc',
				'sub_toggle'	  => 'sub_toggle_color',
				'options'             => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'affects'         => array(
					'teamsorev_bgc_bgc_color',
				),
				'default_on_front' => 'on',
			),
			'teamsorev_bgc_bgc_color'       => array(
				'label'          	=> esc_html__('Select Background Color', 'et_builder'),
				'type'           	=> 'color-alpha',
				'toggle_slug'     	=> 'teamsorev_bgc',
				'sub_toggle'	  	=> 'sub_toggle_color',
				'default'        	=> '#FFFFFF',
				'mobile_options'	=> true,
				'depends_show_if'	=> 'on',
			),
			'teamsorev_gradient_show_hide'  => array(
				'label'           => esc_html__( 'Gradient Color', 'et_builder'),
				'type'            => 'yes_no_button',                
				'toggle_slug'     => 'teamsorev_bgc',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'options'             => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'affects'         => array(
					'teamsorev_gradient_color_one',
					'teamsorev_gradient_color_two',
					'teamsorev_gradient_type',
					'teamsorev_gradient_start_position',
					'teamsorev_gradient_end_position'
				),
				'default_on_front' => 'off',
				'depends_show_if' 	=> 'on',
			),
			'teamsorev_gradient_color_one'	=> array(
				'label'          => esc_html__('Select Color One', 'et_builder'),
				'type'           => 'color-alpha',
				'toggle_slug'    => 'teamsorev_bgc',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'default'        => '#2b87da',
				'depends_show_if'=> 'on',
			),
			'teamsorev_gradient_color_two'	=> array(
				'label'          => esc_html__('Select Color Two', 'et_builder'),
				'type'           => 'color-alpha',
				'toggle_slug'    => 'teamsorev_bgc',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'default'        => '#29c4a9',
				'depends_show_if'=> 'on',
			),
			'teamsorev_gradient_type' => array(
				'label'           => esc_html__('Select Gradient Type', 'et_builder'),
				'type'            => 'select',
				'description'     => esc_html__('Select the types of gradient', 'et_builder'),
				'option_category' => 'basic_option',
				'toggle_slug'     => 'teamsorev_bgc',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'options'         => array(
					'linear-gradient' => esc_html__('Linear', 'et_builder'),
					'radial-gradient' => esc_html__('Radial', 'et_builder'),
				),
				'default'         => 'linear-gradient',
				'depends_show_if' => 'on',
			),
			'teamsorev_gradient_type_linear_direction'   => array(
				'label'           => esc_html__('Linear direction', 'et_builder'),
				'type'            => 'range',
				'option_category'=> 'layout',
				'toggle_slug'    => 'teamsorev_bgc',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'range_settings'  => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 360,
				),
				'default'         => '180deg',
				'fixed_unit'      => 'deg',
				'show_if' => array(
					'teamsorev_gradient_show_hide' => 'on',
					'teamsorev_gradient_type' => 'linear-gradient'
				),
			),
			'teamsorev_gradient_type_radial_direction'   => array(
				'label'           	=> esc_html__('Radial Direction', 'et_builder'),
				'type'            	=> 'select',
				'description'     	=> esc_html__('Select the types of gradient', 'et_builder'),                
				'option_category'	=> 'basic_option',
				'toggle_slug'    	=> 'teamsorev_bgc',
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
					'teamsorev_gradient_show_hide' 		=> 'on',
					'teamsorev_gradient_type'	=> 'radial-gradient'
				),
			),
			'teamsorev_gradient_start_position'           => array(
				'label'           => esc_html__('Start Position', 'et_builder'),
				'type'            => 'range',
				'option_category' => 'layout',
				'toggle_slug'     => 'teamsorev_bgc',
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
			'teamsorev_gradient_end_position'             => array(
				'label'           => esc_html__('End Position', 'et_builder'),
				'type'            => 'range',
				'option_category' => 'layout',
				'toggle_slug'     => 'teamsorev_bgc',
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
			'teamsorev_image_margin'	  => array(
				'label'           => esc_html__('Image Margin', 'et_builder'),
                'type'            => 'custom_margin',
                'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
				'toggle_slug'     => 'margin_padding', 
			),
			'teamsorev_image_padding'  => array(
				'label'           => esc_html__('Image Padding', 'et_builder'),
				'type'            => 'custom_padding',
				'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' => 'layout',
				'tab_slug'        => 'advanced',				
				'toggle_slug'     => 'margin_padding',
			),
			'teamsorev_content_margin'	  => array(
				'label'           => esc_html__('Content Margin', 'et_builder'),
                'type'            => 'custom_margin',
                'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
				'toggle_slug'     => 'margin_padding', 
			),
			'teamsorev_content_padding'  => array(
				'label'           => esc_html__('Content Padding', 'et_builder'),
				'type'            => 'custom_padding',
				'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' => 'layout',
				'tab_slug'        => 'advanced',				
				'toggle_slug'     => 'margin_padding',
			),
			'teamsorev_title_margin'	  => array(
				'label'           => esc_html__('Title Margin', 'et_builder'),
                'type'            => 'custom_margin',
                'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
				'toggle_slug'     => 'margin_padding', 
			),
			'teamsorev_title_padding'  => array(
				'label'           => esc_html__('Title Padding', 'et_builder'),
				'type'            => 'custom_padding',
				'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' => 'layout',
				'tab_slug'        => 'advanced',				
				'toggle_slug'     => 'margin_padding',
			),
			'teamsorev_position_margin'	  => array(
				'label'           => esc_html__('Position Margin', 'et_builder'),
                'type'            => 'custom_margin',
                'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
				'toggle_slug'     => 'margin_padding', 
			),
			'teamsorev_position_padding'  => array(
				'label'           => esc_html__('Position Padding', 'et_builder'),
				'type'            => 'custom_padding',
				'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' => 'layout',
				'tab_slug'        => 'advanced',				
				'toggle_slug'     => 'margin_padding',
			),
			'teamsorev_body_margin'	  => array(
				'label'           => esc_html__('Body Margin', 'et_builder'),
                'type'            => 'custom_margin',
                'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
				'toggle_slug'     => 'margin_padding', 
			),
			'teamsorev_body_padding'  => array(
				'label'           => esc_html__('Body Padding', 'et_builder'),
				'type'            => 'custom_padding',
				'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' => 'layout',
				'tab_slug'        => 'advanced',				
				'toggle_slug'     => 'margin_padding',
			),
		);

		return $fields;
	}
	
	/**
    * Get Image alignment.
    *
    * @since 3.23 Add responsive support by adding device parameter.
    *
    * @param  string $device Current device name.
    * @return string         Alignment value, rtl or not.
	*/
	
	public function get_image_alignment( $device = 'desktop' ) {
		$suffix           = 'desktop' !== $device ? "_{$device}" : '';
		$text_orientation = isset( $this->props["teamsorev_img_alignment{$suffix}"] ) ? $this->props["teamsorev_img_alignment{$suffix}"] : '';

		return et_pb_get_alignment( $text_orientation );
	}
	
	public function render( $attrs, $content, $render_slug ) {
		$teamsorev_img_alignment      	= $this->get_image_alignment();
		$is_img_aligment_responsive   	= et_pb_responsive_options()->is_responsive_enabled( $this->props, 'teamsorev_img_alignment' );
        $teamsorev_img_alignment_tablet = $is_img_aligment_responsive ? $this->get_image_alignment( 'tablet' ) : '';
		$teamsorev_img_alignment_phone  = $is_img_aligment_responsive ? $this->get_image_alignment( 'phone' ) : '';

		// Image Alignment.
		$teamsorev_img_alignments = array();
		if ( ! empty( $teamsorev_img_alignment ) ) {
			array_push( $teamsorev_img_alignments, sprintf( 'teamsorev_img_alignment_%1$s', esc_attr( $teamsorev_img_alignment ) ) );
		}
		
		if ( ! empty( $teamsorev_img_alignment_tablet ) ) {
			array_push( $teamsorev_img_alignments, sprintf( 'teamsorev_img_alignment_tablet_%1$s', esc_attr( $teamsorev_img_alignment_tablet ) ) );
		}
		
		if ( ! empty( $teamsorev_img_alignment_phone ) ) {
			array_push( $teamsorev_img_alignments, sprintf( 'teamsorev_img_alignment_phone_%1$s', esc_attr( $teamsorev_img_alignment_phone ) ) );
		}

		$teamsorev_img_alignment_classes = join( ' ', $teamsorev_img_alignments );
		
		$multi_view			= et_pb_multi_view_options( $this );
		$socia_items 		= et_core_sanitized_previously( $this->content );

		$teamsorev_image	= $this->props['teamsorev_image'];
		$teamsorev_name		= $this->props['teamsorev_name'];
		$teamsorev_position	= $this->props['teamsorev_position'];
		$teamsorev_style	= $this->props['teamsorev_style'];

		$teamsorev_img_width 				= $this->props['teamsorev_img_width'];
		$teamsorev_img_width_hover 	  		= $this->get_hover_value( 'teamsorev_img_width' );
		$teamsorev_img_width_tablet   		= $this->props['teamsorev_img_width_tablet'];
		$teamsorev_img_width_phone  		= $this->props['teamsorev_img_width_phone'];
		$teamsorev_img_width_last_edited	= $this->props['teamsorev_img_width_last_edited'];

		if ( '' !== $teamsorev_img_width ) { 
			$teamsorev_img_width_responsive_active = et_pb_get_responsive_status( $teamsorev_img_width_last_edited );
		
			$teamsorev_img_width_values = array(
				'desktop' => $teamsorev_img_width,
				'tablet'  => $teamsorev_img_width_responsive_active ? $teamsorev_img_width_tablet : '',
				'phone'   => $teamsorev_img_width_responsive_active ? $teamsorev_img_width_phone : '',
			);
			$teamsorev_img_width_selector	= "%%order_class%% .dnxte-teamsorev-mem-img img";
			et_pb_responsive_options()->generate_responsive_css( $teamsorev_img_width_values, $teamsorev_img_width_selector, 'max-width', $render_slug );
			
			if ( et_builder_is_hover_enabled( 'teamsorev_img_width', $this->props ) ) {
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => $this->add_hover_to_order_class( '%%order_class%% .dnxte-teamsorev-mem-img img' ),
					'declaration' => sprintf(
						'max-width: %1$s;',
						esc_html( $teamsorev_img_width_hover )
					),
				) );
			}
		}

		// Image BG Color
		$teamsorev_img_bgc_color		 =	$this->props['teamsorev_img_bgc_color'];
		$teamsorev_img_bgc_color_values  =	et_pb_responsive_options()->get_property_values( $this->props, 'teamsorev_img_bgc_color' );
		$teamsorev_img_bgc_color_tablet  =	isset( $teamsorev_img_bgc_color_values['tablet'] ) ? $teamsorev_img_bgc_color_values['tablet'] : '';
		$teamsorev_img_bgc_color_phone   =	isset( $teamsorev_img_bgc_color_values['phone'] ) ? $teamsorev_img_bgc_color_values['phone'] : '';

		if ( 'off' !== $this->props['teamsorev_image_bgc_show_hide'] ) {
			$teamsorev_img_bgc_color_style 			= sprintf( 'background: %1$s;', esc_attr( $teamsorev_img_bgc_color ) );
			$teamsorev_img_bgc_color_tablet_style 	= '' !== $teamsorev_img_bgc_color_tablet ? sprintf( 'background: %1$s;', esc_attr( $teamsorev_img_bgc_color_tablet ) ) : '';
			$teamsorev_img_bgc_color_phone_style  	= '' !== $teamsorev_img_bgc_color_phone ? sprintf( 'background: %1$s;', esc_attr( $teamsorev_img_bgc_color_phone ) ) : '';
			
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnxte-teamsorev-mem-img",
				'declaration' => $teamsorev_img_bgc_color_style,
			) );
			
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnxte-teamsorev-mem-img",
				'declaration' => $teamsorev_img_bgc_color_tablet_style,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
			) );

			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnxte-teamsorev-mem-img",
				'declaration' => $teamsorev_img_bgc_color_phone_style,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
			) );
		}

		//Image GRADIENT COLOR 
		$teamsorev_img_gradient_color_one = $this->props['teamsorev_img_gradient_color_one'];
		$teamsorev_img_gradient_color_two = $this->props['teamsorev_img_gradient_color_two'];
			// Other gradient options
			$teamsorev_img_gradient_type 			= $this->props['teamsorev_img_gradient_type'];
			$teamsorev_img_gradient_start_position 	= $this->props['teamsorev_img_gradient_start_position'];
			$teamsorev_img_gradient_end_position 	= $this->props['teamsorev_img_gradient_end_position'];

			$teamsorev_img_gradient_direction = $teamsorev_img_gradient_type === 'linear-gradient' ? $this->props['teamsorev_img_gradient_type_linear_direction'] : $this->props['teamsorev_img_gradient_type_radial_direction'];
		
		if( 'off' !== $this->props['teamsorev_img_gradient_show_hide'] ) {
			$teamsorev_img_gradient = sprintf('background: %1$s(%2$s, %3$s %5$s, %4$s %6$s)', $teamsorev_img_gradient_type, $teamsorev_img_gradient_direction, esc_attr($teamsorev_img_gradient_color_one), esc_attr($teamsorev_img_gradient_color_two), $teamsorev_img_gradient_start_position, $teamsorev_img_gradient_end_position);
			
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnxte-teamsorev-mem-img",
				'declaration' => $teamsorev_img_gradient,
			) );
		}

		$teamsorev_img_bgi_image			 	= $this->props['teamsorev_img_bgi_image'];
		$teamsorev_img_bgi_image_tablet			= $this->props['teamsorev_img_bgi_image_tablet'];
		$teamsorev_img_bgi_image_phone			= $this->props['teamsorev_img_bgi_image_phone'];
		$teamsorev_img_bgi_image_last_edited	= $this->props['teamsorev_img_bgi_image_last_edited'];

		// Image Background
		if ( 'off' !== $this->props['teamsorev_img_bgi_show_hide'] ) { 
			$teamsorev_img_bgi_image_style 		 	= sprintf( 'background-image: url("%1$s");', esc_url( $teamsorev_img_bgi_image ) );
			$teamsorev_img_bgi_image_tablet_style 	= '' !== $teamsorev_img_bgi_image_tablet ? sprintf( 'background-image: url("%1$s")', esc_url( $teamsorev_img_bgi_image_tablet ) ) : '';
			$teamsorev_img_bgi_image_phone_style  	= '' !== $teamsorev_img_bgi_image_phone ? sprintf( 'background-image: url("%1$s")', esc_url( $teamsorev_img_bgi_image_phone ) ) : '';
			

			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnxte-teamsorev-mem-img",
				'declaration' => $teamsorev_img_bgi_image_style,
			) );
			
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnxte-teamsorev-mem-img",
				'declaration' => $teamsorev_img_bgi_image_tablet_style,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
			) );

			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnxte-teamsorev-mem-img",
				'declaration' => $teamsorev_img_bgi_image_phone_style,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
			) );
		}

		// Content BG Color
		$teamsorev_bgc_bgc_color		 =	$this->props['teamsorev_bgc_bgc_color'];
		$teamsorev_bgc_bgc_color_values  =	et_pb_responsive_options()->get_property_values( $this->props, 'teamsorev_bgc_bgc_color' );
		$teamsorev_bgc_bgc_color_tablet  =	isset( $teamsorev_bgc_bgc_color_values['tablet'] ) ? $teamsorev_bgc_bgc_color_values['tablet'] : '';
		$teamsorev_bgc_bgc_color_phone   =	isset( $teamsorev_bgc_bgc_color_values['phone'] ) ? $teamsorev_bgc_bgc_color_values['phone'] : '';

		if ( 'off' !== $this->props['teamsorev_bgc_show_hide'] ) {
			$teamsorev_bgc_bgc_color_style 			= sprintf( 'background: %1$s;', esc_attr( $teamsorev_bgc_bgc_color ) );
			$teamsorev_bgc_bgc_color_tablet_style 	= '' !== $teamsorev_bgc_bgc_color_tablet ? sprintf( 'background: %1$s;', esc_attr( $teamsorev_bgc_bgc_color_tablet ) ) : '';
			$teamsorev_bgc_bgc_color_phone_style  	= '' !== $teamsorev_bgc_bgc_color_phone ? sprintf( 'background: %1$s;', esc_attr( $teamsorev_bgc_bgc_color_phone ) ) : '';
			
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnxte-teamsorev-team-01 .dnxte-teamsorev-team-con-wrapper",
				'declaration' => $teamsorev_bgc_bgc_color_style,
			) );
			
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnxte-teamsorev-team-01 .dnxte-teamsorev-team-con-wrapper",
				'declaration' => $teamsorev_bgc_bgc_color_tablet_style,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
			) );

			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnxte-teamsorev-team-01 .dnxte-teamsorev-team-con-wrapper",
				'declaration' => $teamsorev_bgc_bgc_color_phone_style,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
			) );
		}

		//Content GRADIENT COLOR 
		$teamsorev_gradient_color_one = $this->props['teamsorev_gradient_color_one'];
		$teamsorev_gradient_color_two = $this->props['teamsorev_gradient_color_two'];
			// Other gradient options
			$teamsorev_gradient_type 			= $this->props['teamsorev_gradient_type'];
			$teamsorev_gradient_start_position 	= $this->props['teamsorev_gradient_start_position'];
			$teamsorev_gradient_end_position 	= $this->props['teamsorev_gradient_end_position'];

			$teamsorev_gradient_direction = $teamsorev_gradient_type === 'linear-gradient' ? $this->props['teamsorev_gradient_type_linear_direction'] : $this->props['teamsorev_gradient_type_radial_direction'];
		
		if( 'off' !== $this->props['teamsorev_gradient_show_hide'] ) {
			$teamsorev_gradient = sprintf('background: %1$s(%2$s, %3$s %5$s, %4$s %6$s)', $teamsorev_gradient_type, $teamsorev_gradient_direction, esc_attr($teamsorev_gradient_color_one), esc_attr($teamsorev_gradient_color_two), $teamsorev_gradient_start_position, $teamsorev_gradient_end_position);
			
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnxte-teamsorev-team-01 .dnxte-teamsorev-team-con-wrapper",
				'declaration' => $teamsorev_gradient,
			) );
		}

		$dnext_teamsorev_image = "";
		if ( $multi_view->has_value( 'teamsorev_image' ) ) {
			$dnext_member_image_classes = array(
				'dnxte-teamsorev-mem-img',
				esc_attr( $teamsorev_img_alignment_classes ),
			);

			$dnext_teamsorev_image = $multi_view->render_element( array(
				'tag'     => 'div',
				'content' => $multi_view->render_element( array(
					'tag'   => 'img',
					'attrs' => array(
						'src' => '{{teamsorev_image}}',
						'alt' => '{{teamsorev_name}}',
					),
				) ),
				'attrs'   => array(
					'class' => implode( ' ', $dnext_member_image_classes ),
				),
				'classes' => array(
					'et-svg' => array(
						'teamsorev_image' => true,
					),
				),
			) );
		}

		//Team Name
		$teamsorevName  = $multi_view->render_element( array(
			'tag'     => et_pb_process_header_level( $this->props['header_level'], 'h4' ),
			'content' => '{{teamsorev_name}}',
			'attrs'   => array(
				'class' => 'dnxte-teamsorev-team-header',
			),
		) );

		// Postion Player
		$teamsorev_position = $multi_view->render_element( array(
			'tag'     => 'p',
			'content' => '{{teamsorev_position}}',
			'attrs' => array(
				'class' => 'dnxte-teamsorev-team-pos',
			),
		) );

		// Description
		$teamsorev_content = $multi_view->render_element( array(
			'tag'     => 'p',
			'content' => '{{teamsorev_content}}',
		) );

		$this->apply_css($render_slug);

		return sprintf( 
			'<div class="dnxte-teamsorev-team-wrapper">
				<div class="dnxte-teamsorev-team-01 dnxte-teamsorev-anim-%6$s">
						%2$s
					<div class="dnxte-teamsorev-mem-des">
						<div class="dnxte-teamsorev-team-con-wrapper">
							%3$s
							%4$s
							%5$s
						</div> <!-- .dnxte-teamsorev-team-con-wrapper -->
						<ul class="dnxte-teamsorev-social-item">
							%1$s
						</ul>
					</div> <!-- .dnxte-teamsorev-mem-des -->
				</div> <!-- .dnxte-teamsorev-team-01 -->
			</div> <!-- .dnxte-teamsorev-team-wrapper -->', 
			$socia_items,
			et_core_esc_previously( $dnext_teamsorev_image ),
			et_core_esc_previously( $teamsorevName ),
			et_core_esc_previously( $teamsorev_position ),
			wpautop( $teamsorev_content ), // #5
			esc_attr( $teamsorev_style )
			
		);
	}

	public function apply_css($render_slug){
		/**
         * Custom Padding Margin Output
         *
        */

        Common::dnxt_set_style($render_slug, $this->props, "teamsorev_image_margin", "%%order_class%% .dnxte-teamsorev-mem-img", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "teamsorev_image_padding", "%%order_class%% .dnxte-teamsorev-mem-img", "padding");
		
        Common::dnxt_set_style($render_slug, $this->props, "teamsorev_content_margin", "%%order_class%% .dnxte-teamsorev-mem-des", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "teamsorev_content_padding", "%%order_class%% .dnxte-teamsorev-mem-des", "padding");
		
		Common::dnxt_set_style($render_slug, $this->props, "teamsorev_title_margin", "%%order_class%% .dnxte-teamsorev-team-header", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "teamsorev_title_padding", "%%order_class%% .dnxte-teamsorev-team-header", "padding");


		Common::dnxt_set_style($render_slug, $this->props, "teamsorev_position_margin", "%%order_class%% .dnxte-teamsorev-team-pos", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "teamsorev_position_padding", "%%order_class%% .dnxte-teamsorev-team-pos", "padding");

		Common::dnxt_set_style($render_slug, $this->props, "teamsorev_body_margin", "%%order_class%% .dnxte-teamsorev-team-detals p", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "teamsorev_body_padding", "%%order_class%% .dnxte-teamsorev-team-detals p", "padding");
	}

	/**
	 * Check if image has svg extension
	 *
	 * @param string $teamsorev_image Image URL.
	 *
	 * @return bool
	 */
	public function is_svg( $teamsorev_image ) {
		if ( ! $teamsorev_image ) {
			return false;
		}

		$image_pathinfo = pathinfo( $teamsorev_image );

		return isset( $image_pathinfo['extension'] ) ? 'svg' === $image_pathinfo['extension'] : false;
	}
}

new Next_Team_Social_Reveal;
