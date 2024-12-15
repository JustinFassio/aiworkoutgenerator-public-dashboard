<?php
/**
 * Flip Box Module class
 *
 * @package Divi Next
 */
include_once(DIVI_ESSENTIAL_PATH.'/includes/modules/base/Common.php');

class DNEXT_FlipBox extends ET_Builder_Module {

	public $slug       = 'dnxte_flip_box';
	public $vb_support = 'on';

	protected $module_credits = array(
		'module_uri' => 'https://www.diviessential.com/divi-flip-box/',
		'author'     => 'Divi Next',
		'author_uri' => 'www.divinext.com',
	);


	public function init() {
		$this->name        = esc_html__( 'Next Flip Box', 'et_builder' );
		$this->icon_path   = plugin_dir_path( __FILE__ ) . 'icon.svg';
		$this->folder_name = 'et_pb_divi_essential';

		$this->settings_modal_toggles = array(
			'general'	=> array(
				'toggles'		=>	array(
					'dnext_flipbox'	=> array(
						'title'		=>	esc_html__( 'Flip Elements', 'et_builder' ),
						'priority'	=>	1,
						'sub_toggles'       => array(
                            'sub_toggle_frontend'   => array(
								'name' => esc_html__( "Front", 'et_builder' )
                            ),
                            'sub_toggle_backend'   => array(
								'name' => esc_html__( 'Back', 'et_builder' )
                            )
                        ),
                        'tabbed_subtoggles' => true,
					),
					'button'	  	=> esc_html__( 'Button', 'et_builder' ),
					'bgc_front'	=> array(
						'title'		=>	esc_html__( 'Flipbox Front Background', 'et_builder' ),
						'priority'	=>	70,
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
					'bgc_back'	=> array(
						'title'		=>	esc_html__( 'Flipbox Back Background', 'et_builder' ),
						'priority'	=>	70,
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
					'button_bg'	  	=> array(
						'title'		=>	esc_html__( 'Button Background', 'et_builder' ),
						'priority'	=>	70,
					),
					'dnext_flipbox_image_mask'	=> array(
						'title'		=>	esc_html__( 'Image Mask', 'et_builder' ),
						'priority'	=>	70,
						'sub_toggles'       => array(
                            'sub_toggle_frontend'   => array(
								'name' => esc_html__( "Front", 'et_builder' )
                            ),
                            'sub_toggle_backend'   => array(
								'name' => esc_html__( 'Back', 'et_builder' )
                            )
                        ),
                        'tabbed_subtoggles' => true,
					),
				),
			),
			'advanced'	=> array(
				'toggles'	=>	array(
					'flipbox_effect'	=> array(
						'title'		=>	esc_html__( 'Flipbox Effect', 'et_builder' ),
					),
					'icon'	=> array(
						'title'		=>	esc_html__( 'Icon', 'et_builder' ),
						'priority'	=>	40,
						'sub_toggles'       => array(
                            'sub_toggle_frontend'   => array(
								'name' => esc_html__( "Front", 'et_builder' )
                            ),
                            'sub_toggle_backend'   => array(
								'name' => esc_html__( 'Back', 'et_builder' )
                            )
                        ),
                        'tabbed_subtoggles' => true,
					),
					'front_icon_settings' => esc_html__('Front Icon Settings', 'et_builder'),
					'back_icon_settings' => esc_html__('Back Icon Settings', 'et_builder'),
					'image'	=> array(
						'title'		=>	esc_html__( 'Image', 'et_builder' ),
						'priority'	=>	40,
						'sub_toggles'       => array(
                            'sub_toggle_frontend'   => array(
								'name' => esc_html__( "Front", 'et_builder' )
                            ),
                            'sub_toggle_backend'   => array(
								'name' => esc_html__( 'Back', 'et_builder' )
                            )
                        ),
                        'tabbed_subtoggles' => true,
					),
					'dnext_flipbox_text'	=> array(
						'title'		=>	esc_html__( 'Title Text', 'et_builder' ),
						'priority'	=>	50,
						'sub_toggles'       => array(
                            'sub_toggle_frontend'   => array(
								'name' => esc_html__( "Front", 'et_builder' )
                            ),
                            'sub_toggle_backend'   => array(
								'name' => esc_html__( 'Back', 'et_builder' )
                            )
                        ),
                        'tabbed_subtoggles' => true,
					),
					'dnext_btn_settings'	=> array(
						'title'		=>	esc_html__( 'Button Settings', 'et_builder' ),
						'priority'	=>	70,
					),
					'dnext_flipbox_body'	=> array(
						'title'		  => esc_html__( 'Body', 'et_builder' ),
						'priority'	  => 50,
						'sub_toggles' => array(
							'sub_toggle_frontend' => array(
								'name'=> esc_html__('Front', 'et_builder')
							),
							'sub_toggle_backend'  => array(
								'name'=> esc_html__('Back', 'et_builder')
							)
						),
						'tabbed_subtoggles' => true
 					),
					'space'	=> array(
						"title"		=>	esc_html__( 'Flipbox Spacing', 'et_builder' ),
						'priority'	=>	81,
						'sub_toggles'       => array(
                            'sub_toggle_frontend'   => array(
                                'name' => esc_html__( 'Front', 'et_builder' ),
                            ),
                            'sub_toggle_backend'   => array(
                                'name' => esc_html__( 'Back', 'et_builder' ),
                            ),
                        ),
                        'tabbed_subtoggles' => true,
					),
					'front_border'	=> array(
						'title'		=>	esc_html__( 'Front Borders', 'et_builder' ),
						'priority'	=>	91,
					),
					'back_border'	=> array(
						'title'		=>	esc_html__( 'Back Borders', 'et_builder' ),
						'priority'	=>	91,
					),
					'front_boxshadow'	=> array(
						'title'		=>	esc_html__( 'Front Boxshadow', 'et_builder' ),
						'priority'	=>	100,
					),
					'back_boxshadow'	=> array(
						'title'		=>	esc_html__( 'Back Boxshadow', 'et_builder' ),
						'priority'	=>	100,
					),
				), 
			),			
			'custom_css' => array(
				'toggles' => array(
				),
			),
		);

		$this->advanced_fields = array(
			'fonts'                 => array(
				'front_flip_text' => array(
					'label'    		=> esc_html__( '', 'et_builder' ),
					'toggle_slug'   => 'dnext_flipbox_text',
					'sub_toggle'	=> 'sub_toggle_frontend',
					'tab_slug'		=> 'advanced',
					'css'      => array(
						'main' => "%%order_class%% .dnext-flpb-flibbox-heading-font",
						'text_align' => '%%order_class%% .dnext-flpb-flibbox-heading-font',
					),
					'font_size' => array(
						'default' => '19px',
					),
					'font'           => array(
						'default' => '|600|||||||',
					),
					'line_height' => array(
						'default' => '1em',
					),
				),
				'back_flip_text' => array(
					'label'    		=> esc_html__( '', 'et_builder' ),
					'toggle_slug'   => 'dnext_flipbox_text',
					'sub_toggle'	=> 'sub_toggle_backend',
					'tab_slug'		=> 'advanced',
					'css'      => array(
						'main' => "%%order_class%% .dnext-flpb-flibbox-heading-back",
					),
					'font'           => array(
						'default' => '|600|||||||',
					),
					'font_size' => array(
						'default' => '19px',
					),
					'line_height' => array(
						'default' => '1em',
					),
				),
				'btn_flip_text' => array(
					'label'    		=> esc_html__( '', 'et_builder' ),
					'toggle_slug'   => 'dnext_btn_settings',
					'tab_slug'		=> 'advanced',
					'css'      => array(
						'main' 			=> "%%order_class%% .dnext-flpb-flibbox-readmore",
						'text_align'  	=> "%%order_class%% .dnext-flpb-flibbox-flip-button",
					),
					'font_size' => array(
						'default' => '16px',
					),
				),
				'front_body'   => array(
					'toggle_slug'   => 'dnext_flipbox_body',
					'sub_toggle'    => 'sub_toggle_frontend',
					'tab_slug'		=> 'advanced',
					'css'            => array(
						'main' => "%%order_class%% .dnext-flpb-flibbox-front .dnext-flipbox-front-pra",
					),
					'font_size' => array(
						'default' => '16px',
					),
					'font_color' => array(
						'default' => '#FFFFFF',
					),
					'line_height' => array(
						'default' => '1.3em',
					),
				),
				'back_body'   => array(
					'toggle_slug'   => 'dnext_flipbox_body',
					'sub_toggle'    => 'sub_toggle_backend',
					'tab_slug'		=> 'advanced',
					'css'            => array(
						'main' => "%%order_class%% .dnext-flpb-flibbox-back .dnext-flipbox-back-pra",
					),
					'font_size' => array(
						'default' => '16px',
					),
					'font_color' => array(
						'default' => '#FFFFFF',
					),
					'line_height' => array(
						'default' => '1.3em',
					),
				),
			),
			'background'            => array(
				'settings' => array(
					'color' => 'alpha',
				),
			),
			'borders'               => array(
				'front_borders'     => array(
					'tab_slug'     	=> 'advanced',
					'toggle_slug'  	=> 'front_border',
					'css'          => array(
						'main'     => array(
							'border_radii'  		=> "%%order_class%% .dnext-flpb-flibbox-front",
							'border_radii_hover'  	=> '%%order_class%%:hover .dnext-flpb-flibbox-front',
							'border_styles' 		=> "%%order_class%% .dnext-flpb-flibbox-front",
							'border_styles_hover' 	=> '%%order_class%%:hover .dnext-flpb-flibbox-front',
						),
					),
				),
				'back_borders'     	=> array(
					'tab_slug'     	=> 'advanced',
					'toggle_slug'  	=> 'back_border',
					'css'          => array(
						'main'     => array(
							'border_radii'  		=> "%%order_class%% .dnext-flpb-flibbox-back",
							'border_radii_hover'  	=> '%%order_class%%:hover .dnext-flpb-flibbox-back',
							'border_styles' 		=> "%%order_class%% .dnext-flpb-flibbox-back",
							'border_styles_hover' 	=> '%%order_class%%:hover .dnext-flpb-flibbox-back',
						),
					),
				),
				'btn_borders'     	=> array(
					'tab_slug'     	=> 'advanced',
					'toggle_slug'  	=> 'dnext_btn_settings',
					'css'          => array(
						'main'     => array(
							'border_radii'  		=> "%%order_class%% .dnext-flpb-flibbox-readmore",
							'border_radii_hover'  	=> '%%order_class%%:hover .dnext-flpb-flibbox-readmore',
							'border_styles' 		=> "%%order_class%% .dnext-flpb-flibbox-readmore",
							'border_styles_hover' 	=> '%%order_class%%:hover .dnext-flpb-flibbox-readmore',
						),
					),
				),
				'front_icon_borders'     	=> array(
					'tab_slug'     	=> 'advanced',
					'toggle_slug'  	=> 'front_icon_settings',
					'css'          => array(
						'main'     => array(
							'border_radii'  		=> "%%order_class%% .dnext-flpb-flibbox-front span::before",
							'border_radii_hover'  	=> '%%order_class%%:hover .dnext-flpb-flibbox-front span::before',
							'border_styles' 		=> "%%order_class%% .dnext-flpb-flibbox-front span::before",
							'border_styles_hover' 	=> '%%order_class%%:hover .dnext-flpb-flibbox-front span::before',
						),
					),
				),
				'back_icon_borders'     	=> array(
					'tab_slug'     	=> 'advanced',
					'toggle_slug'  	=> 'back_icon_settings',
					'css'          => array(
						'main'     => array(
							'border_radii'  		=> "%%order_class%% .dnext-flpb-flibbox-back span::before",
							'border_radii_hover'  	=> '%%order_class%%:hover .dnext-flpb-flibbox-back span::before',
							'border_styles' 		=> "%%order_class%% .dnext-flpb-flibbox-back span::before",
							'border_styles_hover' 	=> '%%order_class%%:hover .dnext-flpb-flibbox-back span::before',
						),
					),
				),
			),
			'box_shadow'            => array(
				'front_box_shadow'   => array(
					'label'               => esc_html__( 'Front Box Shadow', 'et_builder' ),
					'option_category'     => 'layout',
					'tab_slug'            => 'advanced',
					'toggle_slug'         => 'front_boxshadow',
					'css'                 => array(
						'main'        => '%%order_class%% .dnext-flpb-flibbox-front',
						'hover'       => '%%order_class%%:hover .dnext-flpb-flibbox-front',
						'overlay'     => 'inset',
					),
					'default_on_fronts'  => array(
						'color'    => '',
						'position' => '',
					),
				),
				'back_box_shadow'   => array(
					'label'               => esc_html__( 'Back Box Shadow', 'et_builder' ),
					'option_category'     => 'layout',
					'tab_slug'            => 'advanced',
					'toggle_slug'         => 'back_boxshadow',
					'css'                 => array(
						'main'        => '%%order_class%% .dnext-flpb-flibbox-back',
						'hover'       => '%%order_class%%:hover .dnext-flpb-flibbox-back',
						'overlay'     => 'inset',
					),
					'default_on_fronts'  => array(
						'color'    => '',
						'position' => '',
					),
				),
				'btn_box_shadow'   => array(
					'label'               => esc_html__( 'Button Box Shadow', 'et_builder' ),
					'option_category'     => 'layout',
					'tab_slug'            => 'advanced',
					'toggle_slug'         => 'dnext_btn_settings',
					'css'                 => array(
						'main'        => '%%order_class%% .dnext-flpb-flibbox-readmore',
						'hover'       => '%%order_class%%:hover .dnext-flpb-flibbox-readmore',
						'overlay'     => 'inset',
					),
					'default_on_fronts'  => array(
						'color'    => '',
						'position' => '',
					),
				),
				'front_icon_shadow'   => array(
					'label'               => esc_html__( 'Front Icon Box Shadow', 'et_builder' ),
					'option_category'     => 'layout',
					'tab_slug'            => 'advanced',
					'toggle_slug'         => 'front_icon_settings',
					'css'                 => array(
						'main'        => '%%order_class%% .dnext-flpb-flibbox-front span::before',
						'hover'       => '%%order_class%%:hover .dnext-flpb-flibbox-front span::before',
						'overlay'     => 'inset',
					),
					'default_on_fronts'  => array(
						'color'    => '',
						'position' => '',
					),
				),
				'back_icon_shadow'   => array(
					'label'               => esc_html__( 'Back Icon Box Shadow', 'et_builder' ),
					'option_category'     => 'layout',
					'tab_slug'            => 'advanced',
					'toggle_slug'         => 'back_icon_settings',
					'css'                 => array(
						'main'        => '%%order_class%% .dnext-flpb-flibbox-back span::before',
						'hover'       => '%%order_class%%:hover .dnext-flpb-flibbox-back span::before',
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
					'important' => 'all',
				),
			),
			'max_width'             => array(
				'use_max_width'        => true,
				'use_module_alignment' => true,
			),
			'height'                => array(
				'css' => array(
					'main' 		=> '%%order_class%% .dnext-flpb-flibbox-card',
				),
				'options' => array(
					'height'	=> array(
						'default' 	=> '300px',
					),
				),
			),
			'min-height'                => array(
				'css' => array(
					'main' 		=> '%%order_class%% .dnext-flpb-flibbox-card',
				),
			),
			'max-height'                => array(
				'css' => array(
					'main' 		=> '%%order_class%% .dnext-flpb-flibbox-card',
				),
			),
			'text'                  => array(
				'use_background_layout' => true,
				'css'              => array(
					'text_shadow' => "{$this->main_css_element} .et_pb_blurb_container",
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
			'filters'               => array(
				'child_filters_target' => array(
					'tab_slug' => 'advanced',
					'toggle_slug' => 'icon_settings',
					'depends_show_if' => 'off',
					'css'                 => array(
						'main'  => '%%order_class%% .et_pb_main_blurb_image',
						'hover' => '%%order_class%%:hover .et_pb_main_blurb_image',
					),
				),
			),
			'icon_settings'         => array(
				'css' => array(
					'main' => '%%order_class%% .et_pb_main_blurb_image',
				),
			),
			'button'                => false,
			'text'                	=> false,
		);

		// Custom CSS Field
		$this->custom_css_fields = array(
			'front_icon_wrapper'  => array(
				'label'    => esc_html__( 'Front Icon', 'et_builder' ),
				'selector' => '%%order_class%% .dnext-flpb-flibbox-front span',
			),
			'front_image_wrapper'  => array(
				'label'    => esc_html__( 'Front Image', 'et_builder' ),
				'selector' => '%%order_class%% .dnext-flipbox-image .dnext-flpb-flipbox-front-image',
			),
			'front_heading_wrapper'  => array(
				'label'    => esc_html__( 'Front Heading', 'et_builder' ),
				'selector' => '%%order_class%% .dnext-flpb-flibbox-heading-font',
			),
			'front_body_wrapper'  => array(
				'label'    => esc_html__( 'Front Description', 'et_builder' ),
				'selector' => '%%order_class%% .dnext-flpb-flibbox-front .dnext-flipbox-front-pra',
			),
			'back_icon_wrapper'  => array(
				'label'    => esc_html__( 'Back Icon', 'et_builder' ),
				'selector' => '%%order_class%% .dnext-flpb-flibbox-back span',
			),
			'back_image_wrapper'  => array(
				'label'    => esc_html__( 'Back Image', 'et_builder' ),
				'selector' => '%%order_class%% .dnext-flipbox-image .dnext-flpb-flipbox-back-image',
			),
			'back_heading_wrapper'  => array(
				'label'    => esc_html__( 'Back Heading', 'et_builder' ),
				'selector' => '%%order_class%% .dnext-flpb-flibbox-heading-back',
			),
			'back_body_wrapper'  => array(
				'label'    => esc_html__( 'Back Description', 'et_builder' ),
				'selector' => '%%order_class%% .dnext-flpb-flibbox-back .dnext-flipbox-back-pra',
			),
			'button_wrapper'  => array(
				'label'    => esc_html__( 'Button', 'et_builder' ),
				'selector' => '%%order_class%% .dnext-flpb-flibbox-flip-button .dnext-flpb-flibbox-readmore',
			),
		);
	}


	public function get_fields() {
		$frontend_fields = array(
			'front_icon_switch'	  => array(
				'label'           => esc_html__( 'Icon Enable', 'et_builder' ),
				'type'            => 'yes_no_button',
				'toggle_slug'     => 'dnext_flipbox',
				'sub_toggle'	  => 'sub_toggle_frontend',
				'options'   => array(
					'off'     => esc_html__( 'Off', 'et_builder' ),
					'on'      => esc_html__( 'On', 'et_builder' ),
				),
				'affects'         => array(
					'front_icon',
				),
				'default_on_front'=> 'on',
			),
			'front_icon' 		  => array(
				'label'               => esc_html__( 'Icon', 'et_builder' ),
				'type'                => 'select_icon',
				'option_category'     => 'basic_option',
				'class'               => array( 'et-pb-font-icon' ),
				'toggle_slug'     	  => 'dnext_flipbox',
				'sub_toggle'	  	  => 'sub_toggle_frontend',
				'description'         => esc_html__( 'Choose an icon to display with your blurb.', 'et_builder' ),
				'default'             => '#',
				'depends_show_if'     => 'on',
				'mobile_options'      => true,
			),
			'front_image_switch'	  => array(
				'label'           => esc_html__( 'Image Enable', 'et_builder' ),
				'type'            => 'yes_no_button',
				'toggle_slug'     => 'dnext_flipbox',
				'sub_toggle'	  => 'sub_toggle_frontend',
				'options'   => array(
					'off'     => esc_html__( 'Off', 'et_builder' ),
					'on'      => esc_html__( 'On', 'et_builder' ),
				),
				'affects'         => array(
					'front_image',
					'front_image_alt'
				),
				'default_on_front'=> 'off',
			),
			'front_image' 		  => array(
				'label' => esc_html__('Image', 'et_builder'),
                'type' => 'upload',
                'option_category' => 'basic_option',
                'upload_button_text' => esc_attr__('Upload an image', 'et_builder'),
                'choose_text' => esc_attr__('Choose an Image', 'et_builder'),
                'update_text' => esc_attr__('Set As Image', 'et_builder'),
                'description' => esc_html__('Upload an image to display at the top of your team person.', 'et_builder'),
                'toggle_slug'     => 'dnext_flipbox',
				'sub_toggle'	  => 'sub_toggle_frontend',
                'dynamic_content' => 'image',
                'mobile_options' => true,
                'hover' => 'tabs',
			),
			'front_image_alt' => array(
                'label' => esc_html__('Image Alt', 'et_builder'),
                'type' => 'text',
                'option_category' => 'basic_option',
                'description' => esc_html__('Input image alt text', 'et_builder'),
                'toggle_slug'     => 'dnext_flipbox',
				'sub_toggle'	  => 'sub_toggle_frontend',
                'dynamic_content' => 'text',
                'mobile_options' => true,
				'hover' => 'tabs',
				'default' => 'default'
            ),
			'front_heading'  		=> array(
				'label'           	=> esc_html__( 'Heading Text', 'et_builder' ),
				'type'            	=> 'text',
				'dynamic_content' 	=> 'text',
				'option_category' 	=> 'basic_option',
				'description'     	=> esc_html__( 'Heading Text entered here will appear inside the module.', 'et_builder' ),
				'toggle_slug'     	=> 'dnext_flipbox',
				'sub_toggle'	  	=> 'sub_toggle_frontend',
				'depends_show_if' 	=> 'on',
			),
			'front_heading_tag'    	=> array(
				'label'           	=> esc_html__('Select Heading Tag', 'et_builder'),
				'type'            	=> 'select',
				'description'     	=> esc_html__('Select the heading tag, which you would like to use', 'et_builder'),
				'option_category' 	=> 'basic_option',
				'toggle_slug'     	=> 'dnext_flipbox',
				'sub_toggle'	  	=> 'sub_toggle_frontend',
				'options'         => array(
					'h1'	  	  => esc_html__('H1', 'et_builder'),
					'h2'	  	  => esc_html__('H2', 'et_builder'),
					'h3'	  	  => esc_html__('H3', 'et_builder'),
					'h4'	  	  => esc_html__('H4', 'et_builder'),
					'h5'	  	  => esc_html__('H5', 'et_builder'),
					'h6'	  	  => esc_html__('H6', 'et_builder'),
				),
				'default'         => 'h4',
			),
			'front_content' => array(
				'label'           => esc_html__( 'Content', 'et_builder' ),
				'type'            => 'tiny_mce',
				'dynamic_content' => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Content entered here will appear inside the module.', 'et_builder' ),
				'toggle_slug'     => 'dnext_flipbox',
				'sub_toggle'	  => 'sub_toggle_frontend',
			),
			'front_bgc_show_hide' => array(
				'label'           => esc_html__( 'Background Color', 'et_builder'),
				'type'            => 'yes_no_button',
				'toggle_slug'     => 'bgc_front',
				'sub_toggle'	  => 'sub_toggle_color',
				'options'             => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'affects'         => array(
					'front_bgc_color',
				),
				'default_on_front' => 'on',
			),
			'front_bgc_color'    => array(
				'label'          => esc_html__('Select Background Color', 'et_builder'),
				'type'           => 'color-alpha',
				'toggle_slug'    => 'bgc_front',
				'sub_toggle'	 => 'sub_toggle_color',
				'mobile_options' => true,
				'default'        => '#4a42ec',
				'depends_show_if'=> 'on',
			),
			'front_gradient_show_hide'  => array(
				'label'           => esc_html__( 'Gradient Color', 'et_builder'),
				'type'            => 'yes_no_button',
				'toggle_slug'     => 'bgc_front',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'options'             => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'affects'         => array(
					'front_gradient_color_one',
					'front_gradient_color_two',
					'front_gradient_type',
					'front_gradient_start_position',
					'front_gradient_end_position'
				),
				'default_on_front' => 'off',
				'depends_show_if' 	=> 'on',
			),
			'front_gradient_color_one'	=> array(
				'label'          => esc_html__('Select Color One', 'et_builder'),
				'type'           => 'color-alpha',
				'toggle_slug'    => 'bgc_front',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'default'        => '#2b87da',
				'depends_show_if'=> 'on',
			),
			'front_gradient_color_two'	=> array(
				'label'          => esc_html__('Select Color Two', 'et_builder'),
				'type'           => 'color-alpha',
				'toggle_slug'    => 'bgc_front',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'default'        => '#29c4a9',
				'depends_show_if'=> 'on',
			),
			'front_gradient_type' => array(
				'label'           => esc_html__('Select Gradient Type', 'et_builder'),
				'type'            => 'select',
				'description'     => esc_html__('Select the types of gradient', 'et_builder'),
				'option_category' => 'basic_option',
				'toggle_slug'     => 'bgc_front',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'options'         => array(
					'linear-gradient' => esc_html__('Linear', 'et_builder'),
					'radial-gradient' => esc_html__('Radial', 'et_builder'),
				),
				'default'         => 'linear-gradient',
				'depends_show_if' => 'on',
			),
			'front_gradient_type_linear_direction'   => array(
				'label'           => esc_html__('Gradient direction', 'et_builder'),
				'type'            => 'range',
				'option_category'=> 'basic_option',
				'toggle_slug'    => 'bgc_front',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'range_settings'  => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 360,
				),
				'default'         => '180deg',
				'fixed_unit'      => 'deg',
				'show_if' => array(
					'front_gradient_show_hide' => 'on',
					'front_gradient_type' => 'linear-gradient'
				),
			),
			'front_gradient_type_radial_direction'   => array(
				'label'           	=> esc_html__('Radial Direction', 'et_builder'),
				'type'            	=> 'select',
				'description'     	=> esc_html__('Select the types of gradient', 'et_builder'),                
				'option_category'	=> 'basic_option',
				'toggle_slug'    	=> 'bgc_front',
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
					'front_gradient_show_hide' 		=> 'on',
					'front_gradient_type'	=> 'radial-gradient'
				),
			),
			'front_gradient_start_position'           => array(
				'label'           => esc_html__('Start Position', 'et_builder'),
				'type'            => 'range',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'bgc_front',
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
			'front_gradient_end_position'             => array(
				'label'           => esc_html__('End Position', 'et_builder'),
				'type'            => 'range',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'bgc_front',
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
			'front_bgi_show_hide' => array(
				'label'           => esc_html__( 'Image', 'et_builder'),
				'type'            => 'yes_no_button',
				'toggle_slug'     => 'bgc_front',
				'sub_toggle'	  => 'sub_toggle_image',
				'options'             => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'affects'         => array(
					'front_bg_image',
				),
				'default_on_front' => 'off',
			),
			'front_bg_image'    	 => array(
				'label'          	 => esc_html__('Upload Background Image', 'et_builder'),
				'type'           	 => 'upload',
				'upload_button_text' => esc_attr__( 'Upload an image', 'et_builder' ),
				'choose_text'        => esc_attr__( 'Choose an Image', 'et_builder' ),
				'update_text'        => esc_attr__( 'Set As Image', 'et_builder' ),
				'toggle_slug'    	 => 'bgc_front',
				'sub_toggle'	 	 => 'sub_toggle_image',
				'option_category'	 => 'basic_option',
				'mobile_options' 	 => true,
			),
			'front_icon_color' 		=> array(
				'label'             => esc_html__( 'Icon Color', 'et_builder' ),
				'type'              => 'color-alpha',
				'description'       => esc_html__( 'Here you can define a custom color for your icon.', 'et_builder' ),
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'icon',
				'sub_toggle'	  	=> 'sub_toggle_frontend',
				'mobile_options'	=> true,
				'responsive'		=> true,
				'hover'             => 'tabs',
			),
			'front_icon_size' 	  => array(
				'label'           => esc_html__( 'Icon Font Size', 'et_builder' ),
				'description'     => esc_html__( 'Control the size of the icon by increasing or decreasing the font size.', 'et_builder' ),
				'type'            => 'range',
				'option_category' => 'layout',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'icon',
				'sub_toggle'	  => 'sub_toggle_frontend',
				'default'         => '40px',
				'default_unit'    => 'px',
				'default_on_front'=> '',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'range_settings'  => array(
					'min'  		  => '1',
					'max'  		  => '200',
					'step' 		  => '1',
				),
				'mobile_options'  => true,
				'responsive'	  => true,
			),
			'front_icon_alignment' => array(
				'label'           => esc_html__( 'Icon Alignment', 'et_builder' ),
				'description'     => esc_html__( 'Align icon to the left, right or center.', 'et_builder' ),
				'type'            => 'align',
				'option_category' => 'layout',
				'options'         => et_builder_get_text_orientation_options( array( 'justified' ) ),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'icon',
				'sub_toggle'	  => 'sub_toggle_frontend',
				'mobile_options'  => true,
				'responsive'	  => true,
			),
			'front_icon_margin'	  => array(
				'label'           => esc_html__('Icon Margin', 'et_builder'),
                'type'            => 'custom_margin',
                'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'default'			=> '0|0|8px|0',
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
				'toggle_slug'     => 'space', 
				'sub_toggle'	  => 'sub_toggle_frontend',
				'show_if'         => array(
					'front_icon_switch' => 'on'
				)
			),
			'front_icon_padding'  => array(
				'label'           => esc_html__('Icon Padding', 'et_builder'),
				'type'            => 'custom_padding',
				'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' => 'layout',
				'tab_slug'        => 'advanced',				
				'toggle_slug'     => 'space', 
				'sub_toggle'	  => 'sub_toggle_frontend',
				'show_if'         => array(
					'front_icon_switch' => 'on'
				)
			),
			'front_image_margin'	  => array(
				'label'           => esc_html__('Image Margin', 'et_builder'),
                'type'            => 'custom_margin',
                'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'default'			=> '0|15px|0|15px',
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
				'toggle_slug'     => 'space', 
				'sub_toggle'	  => 'sub_toggle_frontend',
				'show_if'         => array(
					'front_image_switch' => 'on'
				)
			),
			'front_image_padding'  => array(
				'label'           => esc_html__('Image Padding', 'et_builder'),
				'type'            => 'custom_padding',
				'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' => 'layout',
				'tab_slug'        => 'advanced',				
				'toggle_slug'     => 'space', 
				'sub_toggle'	  => 'sub_toggle_frontend',
				'show_if'         => array(
					'front_image_switch' => 'on'
				)
			),
			'front_image_color' 		=> array(
				'label'             => esc_html__( 'Image Background Color', 'et_builder' ),
				'type'              => 'color-alpha',
				'default'        	=> '',
				'description'       => esc_html__( 'Here you can define a custom background color for your image.', 'et_builder' ),
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'image',
				'sub_toggle'	  	=> 'sub_toggle_frontend',
				'mobile_options'	=> true,
				'responsive'		=> true,
				'hover'             => 'tabs',
			),
			'front_image_size' 	  => array(
				'label'           => esc_html__( 'Image Size', 'et_builder' ),
				'description'     => esc_html__( 'Control the size of the image by increasing or decreasing the range.', 'et_builder' ),
				'type'            => 'range',
				'option_category' => 'layout',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'image',
				'sub_toggle'	  => 'sub_toggle_frontend',
				'default'         => '40px',
				'default_unit'    => 'px',
				'default_on_front'=> '',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'range_settings'  => array(
					'min'  		  => '1',
					'max'  		  => '200',
					'step' 		  => '1',
				),
				'mobile_options'  => true,
				'responsive'	  => true,
			),
			'front_image_alignment' => array(
				'label'           => esc_html__( 'Image Alignment', 'et_builder' ),
				'description'     => esc_html__( 'Align image to the left, right or center.', 'et_builder' ),
				'type'            => 'align',
				'option_category' => 'layout',
				'options'         => et_builder_get_text_orientation_options( array( 'justified' ) ),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'image',
				'sub_toggle'	  => 'sub_toggle_frontend',
				'mobile_options'  => true,
				'responsive'	  => true,
			),
			'front_heading_margin'	  => array(
				'label'           => esc_html__('Heading Margin', 'et_builder'),
                'type'            => 'custom_margin',
                'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'default'		=> '0|0|0|0',
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
				'toggle_slug'     => 'space', 
				'sub_toggle'	  => 'sub_toggle_frontend'
			),
			'front_heading_padding'  => array(
				'label'           => esc_html__('Heading Padding', 'et_builder'),
				'type'            => 'custom_padding',
				'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' => 'layout',
				'tab_slug'        => 'advanced',				
				'toggle_slug'     => 'space', 
				'sub_toggle'	  => 'sub_toggle_frontend'
			),
			'front_content_margin'	  => array(
				'label'           => esc_html__('Description Margin', 'et_builder'),
                'type'            => 'custom_margin',
                'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'default'			=> '0|0|0|0',
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
				'toggle_slug'     => 'space', 
				'sub_toggle'	  => 'sub_toggle_frontend'
			),
			'front_content_padding'  => array(
				'label'           => esc_html__('Description Padding', 'et_builder'),
				'type'            => 'custom_padding',
				'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' => 'layout',
				'tab_slug'        => 'advanced',				
				'toggle_slug'     => 'space', 
				'sub_toggle'	  => 'sub_toggle_frontend'
			),
			'front_content_desc_padding'  => array(
				'label'           => esc_html__('Content Padding', 'et_builder'),
				'type'            => 'custom_padding',
				'default'		  => '30px|15px|30px|15px',
				'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' => 'layout',
				'tab_slug'        => 'advanced',				
				'toggle_slug'     => 'space', 
				'sub_toggle'	  => 'sub_toggle_frontend'
			),
			'flipbox_placement'	=> array(
				'label'				=> esc_html__( '', 'et_builder' ),
				'description'       => esc_html__( 'Choose where Flipbox Effect', 'et_builder' ),
				'type'              => 'select',
				'option_category'	=> 'layout',
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'flipbox_effect',
				'option_category'   => 'layout',
				'options'           => array(
					'right'						=> esc_html__( 'Flip Right', 'et_builder' ),
					'left'						=> esc_html__( 'Flip Left', 'et_builder' ),
					'up'						=> esc_html__( 'Flip Up', 'et_builder' ),
					'down'						=> esc_html__( 'Flip Down', 'et_builder' ),
					'diagonal-right'			=> esc_html__( 'Flip Diagonal Right', 'et_builder' ),
					'diagonal-left'				=> esc_html__( 'Flip Diagonal Left', 'et_builder' ),
					'inverted-diagonal-right'	=> esc_html__( 'Flip Inverted Diagonal Right', 'et_builder' ),
					'inverted-diagonal-left'	=> esc_html__( 'Flip Inverted Ddiagonal Left', 'et_builder' ),
				),
				'default'             => 'right',
			),
			'btn_bg_color' => array(
				'label'             => esc_html__( 'Button Background', 'et_builder' ),
				'type'              => 'color-alpha',
				'description'       => esc_html__( 'Here you can define a custom background color for your Button.', 'et_builder' ),
				'toggle_slug'       => 'button_bg',
				'default'        	=> '#FFFFFF',
				'hover'             => 'tabs',
				'mobile_options'	=> true,
				'responsive'		=> true,
			),
			'front_dnext_flipbox_use_mask' => array(
                'label' => esc_html__('Use Image Mask', 'et_builder'),
                'type' => 'yes_no_button',
                'toggle_slug' => 'dnext_flipbox_image_mask',
                'sub_toggle'	  => 'sub_toggle_frontend',
                'options' => array(
                    'on' => esc_html__('Yes', 'et_builder'),
                    'off' => esc_html__('No', 'et_builder'),
                ),
                'affects' => array(
                    'front_dnext_flipbox_mask_shape',
                    'front_dnext_flipbox_mask_size',
                    'front_dnext_flipbox_image_horizontal',
                    'front_dnext_flipbox_image_vertical'
                ),
                'default_on_front' => 'off',
            ),
            'front_dnext_flipbox_mask_shape' => array(
                'label' => esc_html__('Select Shape', 'et_builder'),
                'type' => 'select',
                'description' => esc_html__('Select the shape.', 'et_builder'),
                'option_category' => 'basic_option',
                'toggle_slug' => 'dnext_flipbox_image_mask',
                'sub_toggle'	  => 'sub_toggle_frontend',
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
            'front_dnext_flipbox_use_mask_upload' => array(
                'label' => esc_html__('Use Upload Mask', 'et_builder'),
                'type' => 'yes_no_button',
                'toggle_slug' => 'dnext_flipbox_image_mask',
                'sub_toggle'	  => 'sub_toggle_frontend',
                'options' => array(
                    'on' => esc_html__('Yes', 'et_builder'),
                    'off' => esc_html__('No', 'et_builder'),
                ),
                'affects' => array(
                    'front_dnext_flipbox_upload_mask',
                    'front_dnext_flipbox_mask_size',
                    'front_dnext_flipbox_image_horizontal',
                    'front_dnext_flipbox_image_vertical'
                ),
                'default_on_front' => 'off',
                'show_if' => array(
                    'front_dnext_flipbox_use_mask' => 'off'
                )
            ),
            'front_dnext_flipbox_upload_mask' => array(
                'label' => esc_html__("Upload Mask", 'et_builder'),
                'type' => 'upload',
                'toggle_slug' => 'dnext_flipbox_image_mask',
                'sub_toggle'	  => 'sub_toggle_frontend',
                'option_category' => 'basic_option',
                'upload_button_text' => esc_html__('Upload a file', 'et_builder'),
                'choose_text' => esc_attr__('Choose a file', 'et_builder'),
                'update_text' => esc_attr__('Update file', 'et_builder'),
                'depends_show_if' => 'on'
            ),
            'front_dnext_flipbox_mask_size' => array(
                'label' => esc_html__('Select Mask Size', 'et_builder'),
                'type' => 'select',
                'description' => esc_html__('Select the mask size.', 'et_builder'),
                'option_category' => 'basic_option',
                'toggle_slug' => 'dnext_flipbox_image_mask',
                'sub_toggle'	  => 'sub_toggle_frontend',
                'options' => array(
                    'contain' => esc_html__('Contain', 'et_builder'),
                    'cover' => esc_html__('Cover', 'et_builder'),
                ),
                'default' => 'contain',
                'depends_show_if' => 'on',
            ),
            'front_dnext_flipbox_image_horizontal' => array(
                'label' => esc_html__('Image Horizontal Position', 'et_builder'),
                'description' => esc_html__('Adjust the position of the image.', 'et_builder'),
                'type' => 'range',
                'option_category' => 'layout',
                'toggle_slug' => 'dnext_flipbox_image_mask',
                'sub_toggle'	  => 'sub_toggle_frontend',
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
            'front_dnext_flipbox_image_vertical' => array(
                'label' => esc_html__('Image Vertical Position', 'et_builder'),
                'description' => esc_html__('Adjust the position of the image.', 'et_builder'),
                'type' => 'range',
                'option_category' => 'layout',
                'toggle_slug' => 'dnext_flipbox_image_mask',
                'sub_toggle'	  => 'sub_toggle_frontend',
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

		$backend_fields = array(
			'back_icon_switch'	  => array(
				'label'           => esc_html__( 'Icon Enable', 'et_builder' ),
				'type'            => 'yes_no_button',
				'toggle_slug'     => 'dnext_flipbox',
				'sub_toggle'	  => 'sub_toggle_backend',
				'options'   => array(
					'off'     => esc_html__( 'Off', 'et_builder' ),
					'on'      => esc_html__( 'On', 'et_builder' ),
				),
				'affects'         => array(
					'back_icon',
				),
				'default_on_front'=> 'on',
			),
			'back_icon' 		  => array(
				'label'               => esc_html__( 'Icon', 'et_builder' ),
				'type'                => 'select_icon',
				'option_category'     => 'basic_option',
				'class'               => array( 'et-pb-font-icon' ),
				'toggle_slug'     	  => 'dnext_flipbox',
				'sub_toggle'	  	  => 'sub_toggle_backend',
				'description'         => esc_html__( 'Choose an icon to display with your blurb.', 'et_builder' ),
				'default'             => '$',
				'depends_show_if'     => 'on',
				'mobile_options'      => true,
			),
			'back_image_switch'	  => array(
				'label'           => esc_html__( 'Image Enable', 'et_builder' ),
				'type'            => 'yes_no_button',
				'toggle_slug'     => 'dnext_flipbox',
				'sub_toggle'	  => 'sub_toggle_backend',
				'options'   => array(
					'off'     => esc_html__( 'Off', 'et_builder' ),
					'on'      => esc_html__( 'On', 'et_builder' ),
				),
				'affects'         => array(
					'back_image',
					'back_image_alt'
				),
				'default_on_front'=> 'off',
			),
			'back_image' 		  => array(
				'label' => esc_html__('Image', 'et_builder'),
                'type' => 'upload',
                'option_category' => 'basic_option',
                'upload_button_text' => esc_attr__('Upload an image', 'et_builder'),
                'choose_text' => esc_attr__('Choose an Image', 'et_builder'),
                'update_text' => esc_attr__('Set As Image', 'et_builder'),
                'description' => esc_html__('Upload an image to display at the top of your team person.', 'et_builder'),
                'toggle_slug'     => 'dnext_flipbox',
				'sub_toggle'	  => 'sub_toggle_backend',
                'dynamic_content' => 'image',
                'mobile_options' => true,
                'hover' => 'tabs',
			),
			'back_image_alt' => array(
                'label' => esc_html__('Image Alt', 'et_builder'),
                'type' => 'text',
                'option_category' => 'basic_option',
                'description' => esc_html__('Input image alt text', 'et_builder'),
                'toggle_slug'     => 'dnext_flipbox',
				'sub_toggle'	  => 'sub_toggle_backend',
				'default'         => 'default',
                'dynamic_content' => 'text',
                'mobile_options' => true,
				'hover' => 'tabs',
            ),
			'back_heading'  		=> array(
				'label'           	=> esc_html__( 'Heading Text', 'et_builder' ),
				'type'            	=> 'text',
				'dynamic_content' 	=> 'text',
				'option_category' 	=> 'basic_option',
				'description'     	=> esc_html__( 'Heading Text entered here will appear inside the module.', 'et_builder' ),
				'toggle_slug'     	=> 'dnext_flipbox',
				'sub_toggle'	  	  => 'sub_toggle_backend',
			),
			'back_heading_tag'    	=> array(
				'label'           	=> esc_html__('Select Heading Tag', 'et_builder'),
				'type'            	=> 'select',
				'description'     	=> esc_html__('Select heading tag, which you would like to use', 'et_builder'),
				'option_category' 	=> 'basic_option',
				'toggle_slug'     	=> 'dnext_flipbox',
				'sub_toggle'	  	=> 'sub_toggle_backend',
				'options'         => array(
					'h1'	  	  => esc_html__('H1', 'et_builder'),
					'h2'	  	  => esc_html__('H2', 'et_builder'),
					'h3'	  	  => esc_html__('H3', 'et_builder'),
					'h4'	  	  => esc_html__('H4', 'et_builder'),
					'h5'	  	  => esc_html__('H5', 'et_builder'),
					'h6'	  	  => esc_html__('H6', 'et_builder'),
				),
				'default'         => 'h4',
			), 
			'back_content' 		  => array(
				'label'           => esc_html__( 'Content', 'et_builder' ),
				'type'            => 'tiny_mce',
				'dynamic_content' => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Content entered here will appear inside the module.', 'et_builder' ),
				'toggle_slug'     => 'dnext_flipbox',
				'sub_toggle'	  => 'sub_toggle_backend',
			),
			'back_bgc_show_hide' => array(
				'label'           => esc_html__( 'Background Color', 'et_builder'),
				'type'            => 'yes_no_button',
				'toggle_slug'     => 'bgc_back',
				'sub_toggle'	  => 'sub_toggle_color',
				'options'             => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'affects'         => array(
					'back_bgc_color',
				),
				'default_on_front' => 'on',
			),
			'back_bgc_color'    => array(
				'label'          => esc_html__('Select Background Color', 'et_builder'),
				'type'           => 'color-alpha',
				'toggle_slug'    => 'bgc_back',
				'sub_toggle'	 => 'sub_toggle_color',
				'mobile_options' => true,
				'default'        => '#f91942',
				'depends_show_if'=> 'on',
			),
			'back_gradient_show_hide'  => array(
				'label'           => esc_html__( 'Gradient Color', 'et_builder'),
				'type'            => 'yes_no_button',
				'toggle_slug'     => 'bgc_back',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'options'             => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'affects'         => array(
					'back_gradient_color_one',
					'back_gradient_color_two',
					'back_gradient_type',
					'back_gradient_start_position',
					'back_gradient_end_position'
				),
				'default_on_front' => 'off',
				'depends_show_if' 	=> 'on',
			),
			'back_gradient_color_one'	=> array(
				'label'          => esc_html__('Select Color One', 'et_builder'),
				'type'           => 'color-alpha',
				'toggle_slug'    => 'bgc_back',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'default'        => '#2b87da',
				'depends_show_if'=> 'on',
			),
			'back_gradient_color_two'	=> array(
				'label'          => esc_html__('Select Color Two', 'et_builder'),
				'type'           => 'color-alpha',
				'toggle_slug'    => 'bgc_back',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'default'        => '#29c4a9',
				'depends_show_if'=> 'on',
			),
			'back_gradient_type' => array(
				'label'           => esc_html__('Select Gradient Type', 'et_builder'),
				'type'            => 'select',
				'description'     => esc_html__('Select the types of gradient', 'et_builder'),
				'option_category' => 'basic_option',
				'toggle_slug'     => 'bgc_back',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'options'         => array(
					'linear-gradient' => esc_html__('Linear', 'et_builder'),
					'radial-gradient' => esc_html__('Radial', 'et_builder'),
				),
				'default'         => 'linear-gradient',
				'depends_show_if' => 'on',
			),
			'back_gradient_type_linear_direction'   => array(
				'label'           => esc_html__('Gradient direction', 'et_builder'),
				'type'            => 'range',
				'option_category'=> 'basic_option',
				'toggle_slug'    => 'bgc_back',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'range_settings'  => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 360,
				),
				'default'         => '180deg',
				'fixed_unit'      => 'deg',
				'show_if' => array(
					'back_gradient_show_hide' => 'on',
					'back_gradient_type' => 'linear-gradient'
				),
			),
			'back_gradient_type_radial_direction'   => array(
				'label'           	=> esc_html__('Radial Direction', 'et_builder'),
				'type'            	=> 'select',
				'description'     	=> esc_html__('Select the types of gradient', 'et_builder'),                
				'option_category'	=> 'basic_option',
				'toggle_slug'    	=> 'bgc_back',
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
					'back_gradient_show_hide' 		=> 'on',
					'back_gradient_type'	=> 'radial-gradient'
				),
			),
			'back_gradient_start_position'           => array(
				'label'           => esc_html__('Start Position', 'et_builder'),
				'type'            => 'range',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'bgc_back',
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
			'back_gradient_end_position'             => array(
				'label'           => esc_html__('End Position', 'et_builder'),
				'type'            => 'range',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'bgc_back',
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
			'back_bgi_show_hide' => array(
				'label'           => esc_html__( 'Image', 'et_builder'),
				'type'            => 'yes_no_button',
				'toggle_slug'     => 'bgc_back',
				'sub_toggle'	  => 'sub_toggle_image',
				'options'             => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'affects'         => array(
					'back_bg_image',
				),
				'default_on_front' => 'off',
			),
			'back_bg_image'    	 => array(
				'label'          	 => esc_html__('Upload Background Image', 'et_builder'),
				'type'           	 => 'upload',
				'upload_button_text' => esc_attr__( 'Upload an image', 'et_builder' ),
				'choose_text'        => esc_attr__( 'Choose an Image', 'et_builder' ),
				'update_text'        => esc_attr__( 'Set As Image', 'et_builder' ),
				'toggle_slug'    	 => 'bgc_back',
				'sub_toggle'	 	 => 'sub_toggle_image',
				'option_category'	 => 'basic_option',
				'mobile_options' 	 => true,
			),
			'btn_show_hide' => array(
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
					'button_link_new_window',
				),
				'default_on_front'=> 'on',
			),
			'button_text'      	  => array(
				'label'           => esc_html__( 'Button Text', 'et_builder' ),
				'type'            => 'text',
				'dynamic_content' => 'text',
                'default'         => 'Button Text',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'button',
			),
			'button_link'      => array(
				'label'           => esc_html__( 'Button Link', 'et_builder' ),
				'description'     => esc_html__( 'When clicked the module will link to this URL.', 'et_builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'toggle_slug'     => 'button',
				'dynamic_content' => 'url',
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
			),
			'back_icon_color' 		=> array(
				'label'             => esc_html__( 'Icon Color', 'et_builder' ),
				'type'              => 'color-alpha',
				'description'       => esc_html__( 'Here you can define a custom color for your icon.', 'et_builder' ),
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'icon',
				'sub_toggle'	  	=> 'sub_toggle_backend',
				'mobile_options'	=> true,
				'responsive'		=> true,
				'hover'             => 'tabs',
			),
			'back_icon_size' 	  => array(
				'label'           => esc_html__( 'Icon Font Size', 'et_builder' ),
				'description'     => esc_html__( 'Control the size of the icon by increasing or decreasing the font size.', 'et_builder' ),
				'type'            => 'range',
				'option_category' => 'layout',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'icon',
				'sub_toggle'	  => 'sub_toggle_backend',
				'default'         => '40px',
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
			),
			'back_icon_alignment' => array(
				'label'           => esc_html__( 'Icon Alignment', 'et_builder' ),
				'description'     => esc_html__( 'Align icon to the left, right or center.', 'et_builder' ),
				'type'            => 'align',
				'option_category' => 'layout',
				'options'         => et_builder_get_text_orientation_options( array( 'justified' ) ),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'icon',
				'sub_toggle'	  => 'sub_toggle_backend',
				'mobile_options'  => true,
				'responsive'	  => true,

			),
			'back_icon_margin'	  => array(
				'label'           => esc_html__('Icon Margin', 'et_builder'),
                'type'            => 'custom_margin',
                'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'default'			=> '0|0|8px|0',
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
				'toggle_slug'     => 'space', 
				'sub_toggle'	  => 'sub_toggle_backend',
				'show_if'         => array(
					'back_icon_switch' => 'on'
				)
			),
			'back_icon_padding'	  => array(
				'label'           => esc_html__('Icon Padding', 'et_builder'),
				'type'            => 'custom_padding',
				'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' => 'layout',
				'tab_slug'        => 'advanced',				
				'toggle_slug'     => 'space', 
				'sub_toggle'	  => 'sub_toggle_backend',
				'show_if'         => array(
					'back_icon_switch' => 'on'
				)
			),
			'back_image_margin'	  => array(
				'label'           => esc_html__('Image Margin', 'et_builder'),
                'type'            => 'custom_margin',
                'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'default'			=> '0|15px|0|15px',
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
				'toggle_slug'     => 'space', 
				'sub_toggle'	  => 'sub_toggle_backend',
				'show_if'         => array(
					'back_image_switch' => 'on'
				)
			),
			'back_image_padding'  => array(
				'label'           => esc_html__('Image Padding', 'et_builder'),
				'type'            => 'custom_padding',
				'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' => 'layout',
				'tab_slug'        => 'advanced',				
				'toggle_slug'     => 'space', 
				'sub_toggle'	  => 'sub_toggle_backend',
				'show_if'         => array(
					'back_image_switch' => 'on'
				)
			),
			'back_image_color' 		=> array(
				'label'             => esc_html__( 'Image Background Color', 'et_builder' ),
				'type'              => 'color-alpha',
				'default'        	=> '',
				'description'       => esc_html__( 'Here you can define a custom background color for your image.', 'et_builder' ),
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'image',
				'sub_toggle'	  	=> 'sub_toggle_backend',
				'mobile_options'	=> true,
				'responsive'		=> true,
				'hover'             => 'tabs',
			),
			'back_image_size' 	  => array(
				'label'           => esc_html__( 'Image Size', 'et_builder' ),
				'description'     => esc_html__( 'Control the size of the image by increasing or decreasing the range.', 'et_builder' ),
				'type'            => 'range',
				'option_category' => 'layout',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'image',
				'sub_toggle'	  => 'sub_toggle_backend',
				'default'         => '40px',
				'default_unit'    => 'px',
				'default_on_front'=> '',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'range_settings'  => array(
					'min'  		  => '1',
					'max'  		  => '200',
					'step' 		  => '1',
				),
				'mobile_options'  => true,
				'responsive'	  => true,
			),
			'back_image_alignment' => array(
				'label'           => esc_html__( 'Image Alignment', 'et_builder' ),
				'description'     => esc_html__( 'Align image to the left, right or center.', 'et_builder' ),
				'type'            => 'align',
				'option_category' => 'layout',
				'options'         => et_builder_get_text_orientation_options( array( 'justified' ) ),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'image',
				'sub_toggle'	  => 'sub_toggle_backend',
				'mobile_options'  => true,
				'responsive'	  => true,
			),
			'back_heading_margin' => array(
				'label'           => esc_html__('Heading Margin', 'et_builder'),
                'type'            => 'custom_margin',
				'default'         => '0|0|0|0',
                'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
				'toggle_slug'     => 'space', 
				'sub_toggle'	  => 'sub_toggle_backend'
			),
			'back_heading_padding'=> array(
				'label'           => esc_html__('Heading Padding', 'et_builder'),
				'type'            => 'custom_padding',
				'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' => 'layout',
				'tab_slug'        => 'advanced',				
				'toggle_slug'     => 'space', 
				'sub_toggle'	  => 'sub_toggle_backend'
			),
			'back_content_margin' => array(
				'label'           => esc_html__('Description Margin', 'et_builder'),
                'type'            => 'custom_margin',
                'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'default'		  => '0|0|20px|0',
				'option_category' => 'layout',
                'tab_slug'        => 'advanced',
				'toggle_slug'     => 'space', 
				'sub_toggle'	  => 'sub_toggle_backend'
			),
			'back_content_padding'=> array(
				'label'           => esc_html__('Description Padding', 'et_builder'),
				'type'            => 'custom_padding',
				'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' => 'layout',
				'tab_slug'        => 'advanced',				
				'toggle_slug'     => 'space', 
				'sub_toggle'	  => 'sub_toggle_backend'
			),
			'back_content_desc_padding'=> array(
				'label'           => esc_html__('Content Padding', 'et_builder'),
				'type'            => 'custom_padding',
				'default'		  => '30px|15px|30px|15px',
				'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' => 'layout',
				'tab_slug'        => 'advanced',				
				'toggle_slug'     => 'space', 
				'sub_toggle'	  => 'sub_toggle_backend'
			),
			'back_btn_margin_outer' => array(
				'label'           => esc_html__('Button Margin Outer', 'et_builder'),
                'type'            => 'custom_margin',
                'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'default'			=> '0|0|0|0',
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
				'toggle_slug'     => 'space', 
				'sub_toggle'	  => 'sub_toggle_backend'
			),
			'back_btn_padding_outer'=> array(
				'label'           => esc_html__('Button Padding Outer', 'et_builder'),
				'type'            => 'custom_padding',
				'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' => 'layout',
				'tab_slug'        => 'advanced',				
				'toggle_slug'     => 'space', 
				'sub_toggle'	  => 'sub_toggle_backend'
			),
			'back_btn_margin_inner' => array(
				'label'           => esc_html__('Button Margin Inner', 'et_builder'),
                'type'            => 'custom_margin',
                'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
				'toggle_slug'     => 'space', 
				'sub_toggle'	  => 'sub_toggle_backend'
			),
			'back_btn_padding_inner'=> array(
				'label'           => esc_html__('Button Padding Inner', 'et_builder'),
				'type'            => 'custom_padding',
				'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' => 'layout',
				'tab_slug'        => 'advanced',				
				'toggle_slug'     => 'space', 
				'sub_toggle'	  => 'sub_toggle_backend'
			),
			'back_dnext_flipbox_use_mask' => array(
                'label' => esc_html__('Use Image Mask', 'et_builder'),
                'type' => 'yes_no_button',
                'toggle_slug' => 'dnext_flipbox_image_mask',
                'sub_toggle'	  => 'sub_toggle_backend',
                'options' => array(
                    'on' => esc_html__('Yes', 'et_builder'),
                    'off' => esc_html__('No', 'et_builder'),
                ),
                'affects' => array(
                    'back_dnext_flipbox_mask_shape',
                    'back_dnext_flipbox_mask_size',
                    'back_dnext_flipbox_image_horizontal',
                    'back_dnext_flipbox_image_vertical'
                ),
                'default_on_front' => 'off',
            ),
            'back_dnext_flipbox_mask_shape' => array(
                'label' => esc_html__('Select Shape', 'et_builder'),
                'type' => 'select',
                'description' => esc_html__('Select the shape.', 'et_builder'),
                'option_category' => 'basic_option',
                'toggle_slug' => 'dnext_flipbox_image_mask',
                'sub_toggle'	  => 'sub_toggle_backend',
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
            'back_dnext_flipbox_use_mask_upload' => array(
                'label' => esc_html__('Use Upload Mask', 'et_builder'),
                'type' => 'yes_no_button',
                'toggle_slug' => 'dnext_flipbox_image_mask',
                'sub_toggle'	  => 'sub_toggle_backend',
                'options' => array(
                    'on' => esc_html__('Yes', 'et_builder'),
                    'off' => esc_html__('No', 'et_builder'),
                ),
                'affects' => array(
                    'back_dnext_flipbox_upload_mask',
                    'back_dnext_flipbox_mask_size',
                    'back_dnext_flipbox_image_horizontal',
                    'back_dnext_flipbox_image_vertical'
                ),
                'default_on_front' => 'off',
                'show_if' => array(
                    'back_dnext_flipbox_use_mask' => 'off'
                )
            ),
            'back_dnext_flipbox_upload_mask' => array(
                'label' => esc_html__("Upload Mask", 'et_builder'),
                'type' => 'upload',
                'toggle_slug' => 'dnext_flipbox_image_mask',
                'sub_toggle'	  => 'sub_toggle_backend',
                'option_category' => 'basic_option',
                'upload_button_text' => esc_html__('Upload a file', 'et_builder'),
                'choose_text' => esc_attr__('Choose a file', 'et_builder'),
                'update_text' => esc_attr__('Update file', 'et_builder'),
                'depends_show_if' => 'on'
            ),
            'back_dnext_flipbox_mask_size' => array(
                'label' => esc_html__('Select Mask Size', 'et_builder'),
                'type' => 'select',
                'description' => esc_html__('Select the mask size.', 'et_builder'),
                'option_category' => 'basic_option',
                'toggle_slug' => 'dnext_flipbox_image_mask',
                'sub_toggle'	  => 'sub_toggle_backend',
                'options' => array(
                    'contain' => esc_html__('Contain', 'et_builder'),
                    'cover' => esc_html__('Cover', 'et_builder'),
                ),
                'default' => 'contain',
                'depends_show_if' => 'on',
            ),
            'back_dnext_flipbox_image_horizontal' => array(
                'label' => esc_html__('Image Horizontal Position', 'et_builder'),
                'description' => esc_html__('Adjust the position of the image.', 'et_builder'),
                'type' => 'range',
                'option_category' => 'layout',
                'toggle_slug' => 'dnext_flipbox_image_mask',
                'sub_toggle'	  => 'sub_toggle_backend',
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
            'back_dnext_flipbox_image_vertical' => array(
                'label' => esc_html__('Image Vertical Position', 'et_builder'),
                'description' => esc_html__('Adjust the position of the image.', 'et_builder'),
                'type' => 'range',
                'option_category' => 'layout',
                'toggle_slug' => 'dnext_flipbox_image_mask',
                'sub_toggle'	  => 'sub_toggle_backend',
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

		$additional = array(
            'front_icon_bg_color' => array(
                'label' => esc_html__('Front Icon Background', 'et_builder'),
                'type' => 'background-field',
                'base_name' => "front_icon_bg",
                'context' => "front_icon_bg",
                'option_category' => 'layout',
                'custom_color' => true,
                'default' => ET_Global_Settings::get_value('all_buttons_bg_color'),
                'depends_show_if' => 'on',
                'tab_slug' => 'advanced',
				'toggle_slug' => "icon",
				"sub_toggle"  => 'sub_toggle_frontend',
                'background_fields' => array_merge(
                    ET_Builder_Element::generate_background_options(
                        'front_icon_bg',
                        'gradient',
                        "advanced",
						"icon",
                        "front_icon_bg_gradient"
                    ),
                    ET_Builder_Element::generate_background_options(
                        "front_icon_bg",
                        "color",
                        "advanced",
                        "icon",
                        "front_icon_bg_color"
                    )
                    ),
                'mobile_options' => true,
                'hover' => 'tabs'
			),
			'back_icon_bg_color' => array(
                'label' => esc_html__('Front Icon Background', 'et_builder'),
                'type' => 'background-field',
                'base_name' => "back_icon_bg",
                'context' => "back_icon_bg",
                'option_category' => 'layout',
                'custom_color' => true,
                'default' => ET_Global_Settings::get_value('all_buttons_bg_color'),
                'depends_show_if' => 'on',
                'tab_slug' => 'advanced',
				'toggle_slug' => "icon",
				"sub_toggle"  => 'sub_toggle_backend',
                'background_fields' => array_merge(
                    ET_Builder_Element::generate_background_options(
                        'back_icon_bg',
                        'gradient',
                        "advanced",
						"icon",
                        "back_icon_bg_gradient"
                    ),
                    ET_Builder_Element::generate_background_options(
                        "back_icon_bg",
                        "color",
                        "advanced",
                        "icon",
                        "back_icon_bg_color"
                    )
                    ),
                'mobile_options' => true,
                'hover' => 'tabs'
            )
        );

        $additional = array_merge(
            $additional,
            $this->generate_background_options(
                'front_icon_bg',
                'skip',
                "advanced",
                "icon",
                "front_icon_bg_gradient"
            ),
            $this->generate_background_options(
                'front_icon_bg',
                'skip',
                "advanced",
                "icon",
                "front_icon_bg_color"
			),
			$this->generate_background_options(
                'back_icon_bg',
                'skip',
                "advanced",
                "icon",
                "back_icon_bg_gradient"
            ),
            $this->generate_background_options(
                'back_icon_bg',
                'skip',
                "advanced",
                "icon",
                "back_icon_bg_color"
            )
        );

		return array_merge( $frontend_fields, $backend_fields, $additional );
	}

	public function render( $attrs, $content, $render_slug ) {
		wp_enqueue_script( 'dnext_svg_shape_frontend' );
		$multi_view 			= et_pb_multi_view_options( $this );
		$flipbox_placement		= $this->props['flipbox_placement'];

		$front_use_shape = $this->props['front_dnext_flipbox_use_mask'];
        $front_use_mask_upload = $this->props['front_dnext_flipbox_use_mask_upload'];
        
        $front_shape_name = "on" == $front_use_shape && "none" != $this->props['front_dnext_flipbox_mask_shape'] ? $this->props['front_dnext_flipbox_mask_shape'] : "";
        $front_shape_size = $this->props['front_dnext_flipbox_mask_size'];
		$front_uploaded_mask = "on" == $front_use_mask_upload ? $this->props['front_dnext_flipbox_upload_mask'] : "";
		
		$back_use_shape = $this->props['back_dnext_flipbox_use_mask'];
        $back_use_mask_upload = $this->props['back_dnext_flipbox_use_mask_upload'];
        
        $back_shape_name = "on" == $back_use_shape && "none" != $this->props['back_dnext_flipbox_mask_shape'] ? $this->props['back_dnext_flipbox_mask_shape'] : "";
        $back_shape_size = $this->props['back_dnext_flipbox_mask_size'];
        $back_uploaded_mask = "on" == $back_use_mask_upload ? $this->props['back_dnext_flipbox_upload_mask'] : "";

		$front_heading		= $this->props['front_heading'];
		$front_heading_tag	= $this->props['front_heading_tag'];
		$front_content		= $this->props['front_content'];
		$front_icon_switch	= $this->props['front_icon_switch'];
		$front_image_switch = $this->props['front_image_switch'];
		$front_icon			= $this->props['front_icon'];
		$front_image = $this->props['front_image'];
		$front_image_alt = $this->props['front_image_alt'];

		// Front Icon Alignment.
		$front_icon_alignment_classes = Common::get_alignment("front_icon_alignment", $this, "dnext");
		
		// Back Icon Alignment.
		$back_icon_alignment_classes = Common::get_alignment("back_icon_alignment", $this, "dnext");

		// Front Image Alignment.
		$front_image_alignment_classes = Common::get_alignment("front_image_alignment", $this);

		// Back Image Alignment.
		$back_image_alignment_classes = Common::get_alignment("back_image_alignment", $this);


		$back_heading		= $this->props['back_heading'];
		$back_heading_tag	= $this->props['back_heading_tag'];
		$back_content		= $this->props['back_content'];
		$back_icon_switch	= $this->props['back_icon_switch'];
		$back_icon			= $this->props['back_icon'];
		$back_image_switch  = $this->props['back_image_switch'];
		$back_image         = $this->props['back_image'];
		$back_image_alt     = $this->props['back_image_alt'];

		$button_text				= $this->props['button_text'];
		$button_link				= $this->props['button_link'];
		$button_link_new_window		= $this->props['button_link_new_window'];
		$buttonTarget 				= 'on' === $this->props['button_link_new_window'] ? '_blank' : '_self';

		// Front Icon Color
		$front_icon_color			= $this->props['front_icon_color'];
		$front_icon_color_hover 	= $this->get_hover_value( 'front_icon_color' );
		$front_icon_color_values	= et_pb_responsive_options()->get_property_values( $this->props, 'front_icon_color' );
		$front_icon_color_tablet	= isset( $front_icon_color_values['tablet'] ) ? $front_icon_color_values['tablet'] : '';
		$front_icon_color_phone		= isset( $front_icon_color_values['phone'] ) ? $front_icon_color_values['phone'] : '';

		if ( '' !== $front_icon_color ) {
			$front_icon_color_style 		 	= sprintf( 'color: %1$s;', esc_attr( $front_icon_color ) );
			$front_icon_color_tablet_style 	= '' !== $front_icon_color_tablet ? sprintf( 'color: %1$s;', esc_attr( $front_icon_color_tablet ) ) : '';
			$front_icon_color_phone_style  	= '' !== $front_icon_color_phone ? sprintf( 'color: %1$s;', esc_attr( $front_icon_color_phone ) ) : '';
			
			$front_icon_color_style_hover  = '';

			if ( et_builder_is_hover_enabled( 'front_icon_color', $this->props ) ) {
				$front_icon_color_style_hover = sprintf( 'color: %1$s;', esc_attr( $front_icon_color_hover ) );
			}

			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnext-flpb-flibbox-front span::before",
				'declaration' => $front_icon_color_style,
			) );
			
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnext-flpb-flibbox-front span::before",
				'declaration' => $front_icon_color_tablet_style,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
			) );

			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnext-flpb-flibbox-front span::before",
				'declaration' => $front_icon_color_phone_style,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
			) );

			if ( "" !== $front_icon_color_style_hover ) {
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => $this->add_hover_to_order_class( "%%order_class%% .dnext-flpb-flibbox-front span:hover" ),
					'declaration' => $front_icon_color_style_hover,
				) );
			}
		}

		// Back Icon Color
		$back_icon_color			= $this->props['back_icon_color'];
		$back_icon_color_hover 		= $this->get_hover_value( 'back_icon_color' );
		$back_icon_color_values		= et_pb_responsive_options()->get_property_values( $this->props, 'back_icon_color' );
		$back_icon_color_tablet		= isset( $back_icon_color_values['tablet'] ) ? $back_icon_color_values['tablet'] : '';
		$back_icon_color_phone		= isset( $back_icon_color_values['phone'] ) ? $back_icon_color_values['phone'] : '';

		if ( '' !== $back_icon_color ) {
			$back_icon_color_style 		 	= sprintf( 'color: %1$s;', esc_attr( $back_icon_color ) );
			$back_icon_color_tablet_style 	= '' !== $back_icon_color_tablet ? sprintf( 'color: %1$s;', esc_attr( $back_icon_color_tablet ) ) : '';
			$back_icon_color_phone_style  	= '' !== $back_icon_color_phone ? sprintf( 'color: %1$s;', esc_attr( $back_icon_color_phone ) ) : '';
			
			$back_icon_color_style_hover  = '';

			if ( et_builder_is_hover_enabled( 'back_icon_color', $this->props ) ) {
				$back_icon_color_style_hover = sprintf( 'color: %1$s;', esc_attr( $back_icon_color_hover ) );
			}

			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnext-flpb-flibbox-back span",
				'declaration' => $back_icon_color_style,
			) );
			
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnext-flpb-flibbox-back span",
				'declaration' => $back_icon_color_tablet_style,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
			) );

			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnext-flpb-flibbox-back span",
				'declaration' => $back_icon_color_phone_style,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
			) );

			if ( "" !== $back_icon_color_style_hover ) {
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => $this->add_hover_to_order_class( "%%order_class%% .dnext-flpb-flibbox-back span:hover" ),
					'declaration' => $back_icon_color_style_hover,
				) );
			}
		}

		// Front Icon Size
		$front_icon_size 					= $this->props['front_icon_size'];
		$front_icon_size_hover				= $this->get_hover_value('front_icon_size');
		$front_icon_size_tablet 			= $this->props['front_icon_size_tablet'];
		$front_icon_size_phone 				= $this->props['front_icon_size_phone'];
		$front_icon_size_last_edited 		= $this->props['front_icon_size_last_edited'];

		if ( '' !== $front_icon_size ) {

			$front_icon_size_responsive_active = et_pb_get_responsive_status( $front_icon_size_last_edited );
			$front_icon_size_values = array(
				'desktop' => $front_icon_size,
				'tablet'  => $front_icon_size_responsive_active ? $front_icon_size_tablet : '',
				'phone'   => $front_icon_size_responsive_active ? $front_icon_size_phone : '',
			);

			$front_icon_size_selector = "%%order_class%% .dnext-flpb-flibbox-front span::before";
			et_pb_responsive_options()->generate_responsive_css( $front_icon_size_values, $front_icon_size_selector, 'font-size', $render_slug );
		}
		
		// Back Icon Size
		$back_icon_size 					= $this->props['back_icon_size'];
		$back_icon_size_hover				= $this->get_hover_value('back_icon_size');
		$back_icon_size_tablet 				= $this->props['back_icon_size_tablet'];
		$back_icon_size_phone 				= $this->props['back_icon_size_phone'];
		$back_icon_size_last_edited 		= $this->props['back_icon_size_last_edited'];

		if ( '' !== $back_icon_size ) {

			$back_icon_size_responsive_active = et_pb_get_responsive_status( $back_icon_size_last_edited );
			$back_icon_size_values = array(
				'desktop' => $back_icon_size,
				'tablet'  => $back_icon_size_responsive_active ? $back_icon_size_tablet : '',
				'phone'   => $back_icon_size_responsive_active ? $back_icon_size_phone : '',
			);

			$back_icon_size_selector = "%%order_class%% .dnext-flpb-flibbox-back span::before";
			et_pb_responsive_options()->generate_responsive_css( $back_icon_size_values, $back_icon_size_selector, 'font-size', $render_slug );
		}

		// Front BG Color
		$front_bgc_color		 =	$this->props['front_bgc_color'];
		$front_bgc_color_values  =	et_pb_responsive_options()->get_property_values( $this->props, 'front_bgc_color' );
		$front_bgc_color_tablet  =	isset( $front_bgc_color_values['tablet'] ) ? $front_bgc_color_values['tablet'] : '';
		$front_bgc_color_phone   =	isset( $front_bgc_color_values['phone'] ) ? $front_bgc_color_values['phone'] : '';

		if ( 'off' !== $this->props['front_bgc_show_hide'] ) {
			$front_bgc_color_style 			= sprintf( 'background: %1$s;', esc_attr( $front_bgc_color ) );
			$front_bgc_color_tablet_style 	= '' !== $front_bgc_color_tablet ? sprintf( 'background: %1$s;', esc_attr( $front_bgc_color_tablet ) ) : '';
			$front_bgc_color_phone_style  	= '' !== $front_bgc_color_phone ? sprintf( 'background: %1$s;', esc_attr( $front_bgc_color_phone ) ) : '';
			
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnext-flpb-flibbox-card .dnext-flpb-flibbox-front",
				'declaration' => $front_bgc_color_style,
			) );
			
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnext-flpb-flibbox-card .dnext-flpb-flibbox-front",
				'declaration' => $front_bgc_color_tablet_style,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
			) );

			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnext-flpb-flibbox-card .dnext-flpb-flibbox-front",
				'declaration' => $front_bgc_color_phone_style,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
			) );
		}

		//FRONT GRADIENT COLOR 
		$front_gradient_color_one = $this->props['front_gradient_color_one'];
		$front_gradient_color_two = $this->props['front_gradient_color_two'];
			// Other gradient options
			$front_gradient_type 			= $this->props['front_gradient_type'];
			$front_gradient_start_position 	= $this->props['front_gradient_start_position'];
			$front_gradient_end_position 	= $this->props['front_gradient_end_position'];

			$front_gradient_direction = $front_gradient_type === 'linear-gradient' ? $this->props['front_gradient_type_linear_direction'] : $this->props['front_gradient_type_radial_direction'];
		
		if( 'off' !== $this->props['front_gradient_show_hide'] ) {
			$front_gradient = sprintf('background: %1$s(%2$s, %3$s %5$s, %4$s %6$s)', $front_gradient_type, $front_gradient_direction, esc_attr($front_gradient_color_one), esc_attr($front_gradient_color_two), $front_gradient_start_position, $front_gradient_end_position);
			
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnext-flpb-flibbox-card .dnext-flpb-flibbox-front",
				'declaration' => $front_gradient,
			) );
		}

		$front_bg_image			 	= $this->props['front_bg_image'];
		$front_bg_image_tablet		= $this->props['front_bg_image_tablet'];
		$front_bg_image_phone		= $this->props['front_bg_image_phone'];
		$front_bg_image_last_edited	= $this->props['front_bg_image_last_edited'];

		// Front Image
		if ( 'off' !== $this->props['front_bgi_show_hide'] ) { 
			$front_bg_image_style 		 	= sprintf( 'background-image: url("%1$s");', esc_url( $front_bg_image ) );
			$front_bg_image_tablet_style 	= '' !== $front_bg_image_tablet ? sprintf( 'background-image: url("%1$s")', esc_url( $front_bg_image_tablet ) ) : '';
			$front_bg_image_phone_style  	= '' !== $front_bg_image_phone ? sprintf( 'background-image: url("%1$s")', esc_url( $front_bg_image_phone ) ) : '';
			

			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnext-flpb-flibbox-card .dnext-flpb-flibbox-front",
				'declaration' => $front_bg_image_style,
			) );
			
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnext-flpb-flibbox-card .dnext-flpb-flibbox-front",
				'declaration' => $front_bg_image_tablet_style,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
			) );

			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnext-flpb-flibbox-card .dnext-flpb-flibbox-front",
				'declaration' => $front_bg_image_phone_style,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
			) );
		}

		// Back BG Color
		$back_bgc_color		 	=	$this->props['back_bgc_color'];
		$back_bgc_color_values  =	et_pb_responsive_options()->get_property_values( $this->props, 'back_bgc_color' );
		$back_bgc_color_tablet  =	isset( $back_bgc_color_values['tablet'] ) ? $back_bgc_color_values['tablet'] : '';
		$back_bgc_color_phone   =	isset( $back_bgc_color_values['phone'] ) ? $back_bgc_color_values['phone'] : '';

		if ( 'off' !== $this->props['back_bgc_show_hide'] ) {
			$back_bgc_color_style 			= sprintf( 'background: %1$s;', esc_attr( $back_bgc_color ) );
			$back_bgc_color_tablet_style 	= '' !== $back_bgc_color_tablet ? sprintf( 'background: %1$s;', esc_attr( $back_bgc_color_tablet ) ) : '';
			$back_bgc_color_phone_style  	= '' !== $back_bgc_color_phone ? sprintf( 'background: %1$s;', esc_attr( $back_bgc_color_phone ) ) : '';
			
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnext-flpb-flibbox-card .dnext-flpb-flibbox-back",
				'declaration' => $back_bgc_color_style,
			) );
			
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnext-flpb-flibbox-card .dnext-flpb-flibbox-back",
				'declaration' => $back_bgc_color_tablet_style,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
			) );

			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnext-flpb-flibbox-card .dnext-flpb-flibbox-back",
				'declaration' => $back_bgc_color_phone_style,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
			) );
		}

		//BACK GRADIENT COLOR 
		$back_gradient_color_one = $this->props['back_gradient_color_one'];
		$back_gradient_color_two = $this->props['back_gradient_color_two'];
			// Other gradient options
			$back_gradient_type 			= $this->props['back_gradient_type'];
			$back_gradient_start_position 	= $this->props['back_gradient_start_position'];
			$back_gradient_end_position 	= $this->props['back_gradient_end_position'];

			$back_gradient_direction = $back_gradient_type === 'linear-gradient' ? $this->props['back_gradient_type_linear_direction'] : $this->props['back_gradient_type_radial_direction'];
		
		if( 'off' !== $this->props['back_gradient_show_hide'] ) {
			$back_gradient = sprintf('background: %1$s(%2$s, %3$s %5$s, %4$s %6$s)', $back_gradient_type, $back_gradient_direction, esc_attr($back_gradient_color_one), esc_attr($back_gradient_color_two), $back_gradient_start_position, $back_gradient_end_position);
			
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnext-flpb-flibbox-card .dnext-flpb-flibbox-back",
				'declaration' => $back_gradient,
			) );
		}

		$back_bg_image			 	= $this->props['back_bg_image'];
		$back_bg_image_tablet		= $this->props['back_bg_image_tablet'];
		$back_bg_image_phone		= $this->props['back_bg_image_phone'];
		$back_bg_image_last_edited	= $this->props['back_bg_image_last_edited'];

		// Back Image
		if ( 'off' !== $this->props['back_bgi_show_hide'] ) { 
			$back_bg_image_style 		 	= sprintf( 'background-image: url("%1$s");', esc_url( $back_bg_image ) );
			$back_bg_image_tablet_style 	= '' !== $back_bg_image_tablet ? sprintf( 'background-image: url("%1$s")', esc_url( $back_bg_image_tablet ) ) : '';
			$back_bg_image_phone_style  	= '' !== $back_bg_image_phone ? sprintf( 'background-image: url("%1$s")', esc_url( $back_bg_image_phone ) ) : '';
			

			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnext-flpb-flibbox-card .dnext-flpb-flibbox-back",
				'declaration' => $back_bg_image_style,
			) );
			
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnext-flpb-flibbox-card .dnext-flpb-flibbox-back",
				'declaration' => $back_bg_image_tablet_style,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
			) );

			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnext-flpb-flibbox-card .dnext-flpb-flibbox-back",
				'declaration' => $back_bg_image_phone_style,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
			) );
		}

		// Button BG Color
		$btn_bg_color			= $this->props['btn_bg_color'];
		$btn_bg_color_hover 	= $this->get_hover_value( 'btn_bg_color' );
		$btn_bg_color_values	= et_pb_responsive_options()->get_property_values( $this->props, 'btn_bg_color' );
		$btn_bg_color_tablet	= isset( $btn_bg_color_values['tablet'] ) ? $btn_bg_color_values['tablet'] : '';
		$btn_bg_color_phone		= isset( $btn_bg_color_values['phone'] ) ? $btn_bg_color_values['phone'] : '';

		if ( "" !== $btn_bg_color ) {
			$btn_bg_color_style 		    = sprintf( 'background-color: %1$s;', esc_attr( $btn_bg_color ) );
			$btn_bg_color_tablet_style 	= '' !== $btn_bg_color_tablet ? sprintf( 'background-color: %1$s;', esc_attr( $btn_bg_color_tablet ) ) : '';
			$btn_bg_color_phone_style  	= '' !== $btn_bg_color_phone ? sprintf( 'background-color: %1$s;', esc_attr( $btn_bg_color_phone ) ) : '';
			
			$btn_bg_color_style_hover  = '';
	
			if ( et_builder_is_hover_enabled( 'btn_bg_color', $this->props ) ) {
				$btn_bg_color_style_hover = sprintf( 'background-color: %1$s;',  esc_attr( $btn_bg_color_hover ) );
			}
	
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnext-flpb-flibbox-readmore",
				'declaration' => $btn_bg_color_style,
			) );
			
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnext-flpb-flibbox-readmore",
				'declaration' => $btn_bg_color_tablet_style,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
			) );
	
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnext-flpb-flibbox-readmore",
				'declaration' => $btn_bg_color_phone_style,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
			) );
	
			if ( "" !== $btn_bg_color_style_hover ) {
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => $this->add_hover_to_order_class( "%%order_class%% .dnext-flpb-flibbox-readmore:hover" ),
					'declaration' => $btn_bg_color_style_hover,
				) );
			}
		}


		// Render button
		$button = '';
		if ( "off" !== $this->props['btn_show_hide'] ) {
			$button = '<div class="dnext-flpb-flibbox-flip-button"><a href="'.esc_url( $button_link ).'" class="dnext-flpb-flibbox-readmore" target="'.esc_attr( $buttonTarget ).'">'.$button_text.'</a></div>';
		}


		// Front Icon
		$fronticon = "";

		if ( 'off' !== $front_icon_switch ) {
			$front_css_property = array(
				'selector'    	=> "%%order_class%% .dnext-flpb-flibbox-icon-font::before",
				'class' 		=> sprintf('dnext-flpb-flibbox-icon-font %1$s', $front_icon_alignment_classes)
			);

			$fronticon = Common::get_icon_html_using_psuedo('front_icon', $this, $render_slug, $front_css_property);
		} 
		if( "off" !== $front_image_switch) {
			$fronticon .= sprintf('<div class="dnext-flipbox-image dnext-flipbox-front-image %3$s" data-svg-shape="%4$s" data-shape-size="%5$s" data-use-upload="%6$s" data-uploaded-mask="%7$s"><img src="%1$s" alt="%2$s" class="dnext-flpb-flipbox-front-image"/></div>', esc_attr__($front_image, 'et_builder'), esc_attr__($front_image_alt, 'et_builder'), esc_attr__($front_image_alignment_classes, 'et_builder'), $front_shape_name, $front_shape_size, $front_use_mask_upload, $front_uploaded_mask);
		}

		$front_desc = "";
		if($front_content !== "") {
			$front_desc = sprintf('<div class="dnext-flipbox-front-pra">%1$s</div>', $front_content);
		}

		//Front Flipbox Fields
		$frontend_fields = sprintf(
			'<div class="dnext-flpb-flibbox-front">
				%4$s
				<%2$s class="dnext-flpb-flibbox-heading-font">%3$s</%2$s>
				%1$s
			</div>',
			wpautop( et_core_esc_previously($front_desc) ),
			et_pb_process_header_level( $front_heading_tag, 'h4' ),
			et_core_esc_previously( $front_heading ),
			$fronticon
		);

		// Back Font
		$backicon = "";

		if ( 'off' !== $back_icon_switch ) {

			$back_css_property = array(
				'selector'    	=> "%%order_class%% .dnext-flpb-flibbox-icon-back::before",
				'class' 		=> sprintf('dnext-flpb-flibbox-icon-back %1$s', $back_icon_alignment_classes)
			);

			$backicon = Common::get_icon_html_using_psuedo('back_icon', $this, $render_slug, $back_css_property);

		}
		if( 'off' !== $back_image_switch) {
			$backicon .= sprintf('<div class="dnext-flipbox-image dnext-flipbox-back-image %3$s" data-svg-shape="%4$s" data-shape-size="%5$s" data-use-upload="%6$s" data-uploaded-mask="%7$s"><img src="%1$s" alt="%2$s" class="dnext-flpb-flipbox-back-image"/></div>', esc_attr__($back_image, 'et_builder'), esc_attr__($back_image_alt, 'et_builder'), esc_attr__($back_image_alignment_classes, 'et_builder'), $back_shape_name, $back_shape_size, $back_use_mask_upload, $back_uploaded_mask);
		}

		// Front Image background color & width
		$front_image_bg_color = $this->props['front_image_color'];
		$front_image_bg_color_values = et_pb_responsive_options()->get_property_values($this->props, 'front_image_color');
		$front_image_bg_color_tablet = isset($front_image_bg_color_values['tablet']) ? $front_image_bg_color_values['tablet'] : '';
		$front_image_bg_color_phone = isset($front_image_bg_color_values['phone']) ? $front_image_bg_color_values['phone'] : '';
		$front_image_bg_color_hover = $this->get_hover_value('front_image_color');


		$front_image_width = $this->props['front_image_size'];
		$front_image_width_values = et_pb_responsive_options()->get_property_values($this->props, 'front_image_size');
		$front_image_width_tablet = isset($front_image_width_values['tablet']) ? $front_image_width_values['tablet'] : '';
		$front_image_width_phone = isset($front_image_width_values['phone']) ? $front_image_width_values['phone'] : '';



		if ("" !== $front_image_bg_color || "" !== $front_image_width) {
			$front_image_bg_color_style = sprintf('background-color: %1$s;width: %2$s;', $front_image_bg_color, $front_image_width);
			$front_image_bg_color_style_tablet = sprintf('backgrond-color: %1$s;width: %2$s;', esc_attr($front_image_bg_color_tablet), $front_image_width_tablet);

			$front_image_bg_color_style_phone = sprintf('backgrond-color: %1$s;width: %2$s;', $front_image_bg_color_phone, $front_image_width_phone);
			$front_image_bg_color_style_hover = "";

			if (et_builder_is_hover_enabled('front_image_bg_color', $this->props)) {
				$front_image_bg_color_style_hover = sprintf('background-color: %1$s;', $front_image_bg_color_hover);
			}

			ET_Builder_Element::set_style($render_slug, array(
				'selector' => "%%order_class%% .dnext-flipbox-image img.dnext-flpb-flipbox-front-image",
				'declaration' => $front_image_bg_color_style,
			));

			ET_Builder_Element::set_style($render_slug, array(
				'selector' => "%%order_class%% .dnext-flipbox-image img.dnext-flpb-flipbox-front-image",
				'declaration' => $front_image_bg_color_style_tablet,
				'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
			));

			ET_Builder_Element::set_style($render_slug, array(
				'selector' => "%%order_class%% .dnext-flipbox-image img.dnext-flpb-flipbox-front-image",
				'declaration' => $front_image_bg_color_style_phone,
				'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
			));

			if ("" !== $front_image_bg_color_style_hover) {
				ET_Builder_Element::set_style($render_slug, array(
					'selector' => $this->add_hover_to_order_class("%%order_class%% .dnext-flipbox-image img.dnext-flpb-flipbox-front-image:hover"),
					'declaration' => $front_image_bg_color_style_hover,
				));
			}
		}
		// Front Image background color & width end

		// Back Image background color & width
		$back_image_bg_color = $this->props['back_image_color'];
		$back_image_bg_color_values = et_pb_responsive_options()->get_property_values($this->props, 'back_image_color');
		$back_image_bg_color_tablet = isset($back_image_bg_color_values['tablet']) ? $back_image_bg_color_values['tablet'] : '';
		$back_image_bg_color_phone = isset($back_image_bg_color_values['phone']) ? $back_image_bg_color_values['phone'] : '';
		$back_image_bg_color_hover = $this->get_hover_value('back_image_color');


		$back_image_width = $this->props['back_image_size'];
		$back_image_width_values = et_pb_responsive_options()->get_property_values($this->props, 'back_image_size');
		$back_image_width_tablet = isset($back_image_width_values['tablet']) ? $back_image_width_values['tablet'] : '';
		$back_image_width_phone = isset($back_image_width_values['phone']) ? $back_image_width_values['phone'] : '';



		if ("" !== $back_image_bg_color || "" !== $back_image_width) {
			$back_image_bg_color_style = sprintf('background-color: %1$s;width: %2$s;', $back_image_bg_color, $back_image_width);
			$back_image_bg_color_style_tablet = sprintf('backgrond-color: %1$s;width: %2$s;', esc_attr($back_image_bg_color_tablet), $back_image_width_tablet);

			$back_image_bg_color_style_phone = sprintf('backgrond-color: %1$s;width: %2$s;', $back_image_bg_color_phone, $back_image_width_phone);
			$back_image_bg_color_style_hover = "";

			if (et_builder_is_hover_enabled('back_image_bg_color', $this->props)) {
				$back_image_bg_color_style_hover = sprintf('background-color: %1$s;', $back_image_bg_color_hover);
			}

			ET_Builder_Element::set_style($render_slug, array(
				'selector' => "%%order_class%% .dnext-flipbox-image img.dnext-flpb-flipbox-back-image",
				'declaration' => $back_image_bg_color_style,
			));

			ET_Builder_Element::set_style($render_slug, array(
				'selector' => "%%order_class%% .dnext-flipbox-image img.dnext-flpb-flipbox-back-image",
				'declaration' => $back_image_bg_color_style_tablet,
				'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
			));

			ET_Builder_Element::set_style($render_slug, array(
				'selector' => "%%order_class%% .dnext-flipbox-image img.dnext-flpb-flipbox-back-image",
				'declaration' => $back_image_bg_color_style_phone,
				'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
			));

			if ("" !== $back_image_bg_color_style_hover) {
				ET_Builder_Element::set_style($render_slug, array(
					'selector' => $this->add_hover_to_order_class("%%order_class%% .dnext-flipbox-image img.dnext-flpb-flipbox-back-image:hover"),
					'declaration' => $back_image_bg_color_style_hover,
				));
			}
		}
		// Back Image background color & width end

		$back_desc  = "";
		if($back_content !== "") {
			$back_desc = sprintf('<div class="dnext-flipbox-back-pra">%1$s</div>', $back_content);
		}

		//Back Flipbox Fields
		$backend_fields = sprintf(
			'<div class="dnext-flpb-flibbox-back">
				%4$s
				<%2$s class="dnext-flpb-flibbox-heading-back">%3$s</%2$s>
				%1$s
				%5$s
			</div>',
			wpautop( et_core_esc_previously($back_desc) ),
			et_pb_process_header_level( $back_heading_tag, 'h4' ),
			et_core_esc_previously( $back_heading ),
			$backicon,
			et_core_sanitized_previously( $button )
		);

		// Flipbox Icon background color
        $front_icon_bg_color = array(
            'color_slug' => "front_icon_bg_color"
        );
        $use_color_gradient = $this->props['front_icon_bg_use_color_gradient'];
        $gradient = array(
            "gradient_type" => 'front_icon_bg_color_gradient_type',
            "gradient_direction" => 'front_icon_bg_color_gradient_direction',
            "radial" => 'front_icon_bg_color_gradient_direction_radial',
            "gradient_start" => 'front_icon_bg_color_gradient_start',
            "gradient_end" => 'front_icon_bg_color_gradient_end',
            "gradient_start_position" => 'front_icon_bg_color_gradient_start_position',
            "gradient_end_position" => 'front_icon_bg_color_gradient_end_position',
            "gradient_overlays_image" => 'front_icon_bg_color_gradient_overlays_image',
        );

        $css_property = array(
            "desktop" => "%%order_class%% .dnext-flpb-flibbox-front span:before",
            "hover" => "%%order_class%% .dnext-flpb-flibbox-front span::before:hover"
        );
        Common::apply_bg_css($render_slug, $this, $front_icon_bg_color, $use_color_gradient, $gradient, $css_property);
		//Flipbox Icon background color end
		
		// Flipbox Icon background color
        $back_icon_bg_color = array(
            'color_slug' => "back_icon_bg_color"
        );
        $use_color_gradient = $this->props['back_icon_bg_use_color_gradient'];
        $gradient = array(
            "gradient_type" => 'back_icon_bg_color_gradient_type',
            "gradient_direction" => 'back_icon_bg_color_gradient_direction',
            "radial" => 'back_icon_bg_color_gradient_direction_radial',
            "gradient_start" => 'back_icon_bg_color_gradient_start',
            "gradient_end" => 'back_icon_bg_color_gradient_end',
            "gradient_start_position" => 'back_icon_bg_color_gradient_start_position',
            "gradient_end_position" => 'back_icon_bg_color_gradient_end_position',
            "gradient_overlays_image" => 'back_icon_bg_color_gradient_overlays_image',
        );

        $css_property = array(
            "desktop" => "%%order_class%% .dnext-flpb-flibbox-back span:before",
            "hover" => "%%order_class%% .dnext-flpb-flibbox-back span::before:hover"
        );
        Common::apply_bg_css($render_slug, $this, $back_icon_bg_color, $use_color_gradient, $gradient, $css_property);
        //Flipbox Icon background color end 

		$this->apply_css($render_slug);
		$output = sprintf( 
			'<div class="dnext-flpb-flibbox-card-wrapper dnext-flpb-flibbox-flip-%3$s">
				<div class="dnext-flpb-flibbox-card">
					%1$s
					%2$s
				</div>
			</div>',
			$frontend_fields,
			$backend_fields,
			$flipbox_placement
		);
		
		return $output;
	}


	public function apply_css($render_slug){
		/**
         * Custom Padding Margin Output
         *
        */

        Common::dnxt_set_style($render_slug, $this->props, "front_content_desc_padding", "%%order_class%% .dnext-flpb-flibbox-front", "padding");
		Common::dnxt_set_style($render_slug, $this->props, "back_content_desc_padding", "%%order_class%% .dnext-flpb-flibbox-back", "padding");
		
        Common::dnxt_set_style($render_slug, $this->props, "front_icon_margin", "%%order_class%% .dnext-flpb-flibbox-front span", "margin");
		Common::dnxt_set_style($render_slug, $this->props, "front_icon_padding", "%%order_class%% .dnext-flpb-flibbox-front span:before", "padding");
		
		Common::dnxt_set_style($render_slug, $this->props, "front_image_margin", "%%order_class%% .dnext-flipbox-image .dnext-flpb-flipbox-front-image", "margin");
		Common::dnxt_set_style($render_slug, $this->props, "front_image_padding", "%%order_class%% .dnext-flipbox-image .dnext-flpb-flipbox-front-image", "padding");
		
		Common::dnxt_set_style($render_slug, $this->props, "back_image_margin", "%%order_class%% .dnext-flipbox-image .dnext-flpb-flipbox-back-image", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "back_image_padding", "%%order_class%% .dnext-flipbox-image .dnext-flpb-flipbox-back-image", "padding");
		
		
        Common::dnxt_set_style($render_slug, $this->props, "front_heading_margin", "%%order_class%% .dnext-flpb-flibbox-heading-font", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "front_heading_padding", "%%order_class%% .dnext-flpb-flibbox-heading-font", "padding");
		
		Common::dnxt_set_style($render_slug, $this->props, "front_content_margin", "%%order_class%% .dnext-flpb-flibbox-front .dnext-flipbox-front-pra", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "front_content_padding", "%%order_class%% .dnext-flpb-flibbox-front .dnext-flipbox-front-pra", "padding");


		Common::dnxt_set_style($render_slug, $this->props, "back_icon_margin", "%%order_class%% .dnext-flpb-flibbox-back span", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "back_icon_padding", "%%order_class%% .dnext-flpb-flibbox-back span:before", "padding");

		Common::dnxt_set_style($render_slug, $this->props, "back_heading_margin", "%%order_class%% .dnext-flpb-flibbox-heading-back", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "back_heading_padding", "%%order_class%% .dnext-flpb-flibbox-heading-back", "padding");

		Common::dnxt_set_style($render_slug, $this->props, "back_content_margin", "%%order_class%% .dnext-flpb-flibbox-back .dnext-flipbox-back-pra", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "back_content_padding", "%%order_class%% .dnext-flpb-flibbox-back .dnext-flipbox-back-pra", "padding");

		Common::dnxt_set_style($render_slug, $this->props, "back_btn_margin_outer", "%%order_class%% .dnext-flpb-flibbox-flip-button", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "back_btn_padding_outer", "%%order_class%% .dnext-flpb-flibbox-flip-button", "padding");
		
		Common::dnxt_set_style($render_slug, $this->props, "back_btn_margin_inner", "%%order_class%% .dnext-flpb-flibbox-readmore", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "back_btn_padding_inner", "%%order_class%% .dnext-flpb-flibbox-readmore", "padding");

	}
}

new DNEXT_FlipBox;
