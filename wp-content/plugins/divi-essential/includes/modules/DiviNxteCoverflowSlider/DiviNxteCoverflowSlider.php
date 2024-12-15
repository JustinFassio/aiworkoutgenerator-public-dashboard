<?php
include_once(DIVI_ESSENTIAL_PATH.'/includes/modules/base/Common.php');

class Divi_NxteCoverflowSlider extends ET_Builder_Module {

	public $slug       = 'dnxte_coverflowslider_parent';
	public $vb_support = 'on';
	public $child_slug = 'dnxte_coverflowslider_child';

    protected $module_credits = array(
        'module_uri' => 'https://www.diviessential.com/divi-coverflow-slider/',
        'author' => 'Divi Next',
        'author_uri' => 'www.divinext.com',
    );

	public function init() {
        $this->name        = esc_html__( 'Next Divi Carousel', 'et_builder' );
        $this->icon_path   = plugin_dir_path( __FILE__ ) . 'icon.svg';
        $this->folder_name = 'et_pb_divi_essential';

		$this->settings_modal_toggles = array(
            'general' => array(
                'toggles' => array(
                    'dnxte_coverflow_carousel_settings' => esc_html__( 'Carousel Settings', 'et_builder'),
                    'dnxte_coverflow_carousel_navigation' => esc_html__( 'Navigation Settings', 'et_builder'),
                    'dnxte_coverflow_carousel_effect'    => esc_html__( 'Effect Settings', 'et_builder'),
                    'dnxte_coverflow_carousel_lightbox'    => esc_html__( 'Lightbox Settings', 'et_builder'),
                )
            ),
            'advanced' => array(
                'toggles' => array(
                    'dnxte_coverflow_carousel_text_settings' => esc_html__( 'Text Settings', 'et_builder'),
                    'dnxte_coverflow_carousel_content_settings' => esc_html__( 'Content Settings', 'et_builder'),
                    'dnxte_coverflow_carousel_image_settings' => array(
                        'title' => esc_html__( 'Image Settings', 'et_builder'),
                    ),
                    'dnxte_coverflow_carousel_color_settings' => array(
                        'title' => esc_html__( 'Color Settings', 'et_builder')
                    ),
                    'dnxte_coverflow_carousel_arrow_settings' => array(
                        'title' => esc_html__( 'Arrow Settings', 'et_builder')
                    ),
                )
            )
        );

        $this->custom_css_fields =  array(
            'image'              => array(
                'label'          => esc_html__( 'Image', 'et_builder'),
                'selector'       => '%%order_class%% .img-fluid'
            ),
            'text'              => array(
                'label'          => esc_html__( 'Heading', 'et_builder'),
                'selector'       => '%%order_class%% .dnxte-coverflow-heading'
            ),
            'content'              => array(
                'label'          => esc_html__( 'Content', 'et_builder'),
                'selector'       => '%%order_class%% .dnxte-coverflow-pra'
            ),
        );
    }

    public function get_advanced_fields_config() {
        return array(
            'text'  => false,
            'fonts' => array(
                'text' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnxte-coverflow-heading'
                    ),
                    'toggle_slug' => 'dnxte_coverflow_carousel_text_settings'
                ),
                'content' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnxte-coverflow-pra'
                    ),
                    'toggle_slug' => 'dnxte_coverflow_carousel_content_settings'
                )
            ),
            'background'            => array(
                'settings' => array(
                    'color' => 'alpha',
                ),
                'css'   => array(
                    'main' => "%%order_class%% .swiper-container",
                    'important' => true,
                ),
            ),
            'max_width' => false,
            'borders' => array(
                'default' => array(
                    'css'          => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .swiper-container .dnxte-coverflowslider-item',
							'border_styles' => '%%order_class%% .swiper-container .dnxte-coverflowslider-item',
                        ),
                    ),
                ),
                'image_border'   => array(
					'css'          => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .img-fluid',
							'border_styles' => '%%order_class%% .img-fluid',
                        ),
                    ),
					'label_prefix' => esc_html__( 'Image', 'et_builder' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'dnxte_coverflow_carousel_image_settings',
                ),
                'text_border'   => array(
					'css'          => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .dnxte-coverflow-heading',
							'border_styles' => '%%order_class%% .dnxte-coverflow-heading',
                        ),
                    ),
					'label_prefix' => esc_html__( 'Text', 'et_builder' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'dnxte_coverflow_carousel_text_settings',
                ),
                'content_border'   => array(
					'css'          => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .dnxte-coverflow-pra',
							'border_styles' => '%%order_class%% .dnxte-coverflow-pra',
                        ),
                    ),
					'label_prefix' => esc_html__( 'Content', 'et_builder' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'dnxte_coverflow_carousel_content_settings',
				),
            ),
            'box_shadow' => array(
                'default' => array(
                    'css'          => array(
                        'main' => '%%order_class%% .swiper-container .dnxte-coverflowslider-item',
                        'important' => 'all'
                    ),
                ),
                'image_box_shadow' => array(
                    'css'          => array(
                        'main' => '%%order_class%% .img-fluid',
                        'important' => 'all'
                    ),
					'label_prefix' => esc_html__( 'Image', 'et_builder' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'dnxte_coverflow_carousel_image_settings',
                ),
                'text_box_shadow' => array(
                    'css'          => array(
                        'main' => '%%order_class%% .dnxte-coverflow-heading',
                        'important' => 'all'
                    ),
					'label_prefix' => esc_html__( 'Text', 'et_builder' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'dnxte_coverflow_carousel_text_settings',
                ),
                'content_box_shadow' => array(
                    'css'          => array(
                        'main' => '%%order_class%% .dnxte-coverflow-pra',
                        'important' => 'all'
                    ),
					'label_prefix' => esc_html__( 'Conent', 'et_builder' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'dnxte_coverflow_carousel_content_settings',
                ),
            ),
            'filters' => array(
                'css' => array(
                    'main' => '%%order_class%%',
                ),
                'child_filters_target' => array(
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxte_coverflow_carousel_image_settings',
                ),
                'image' => array(
                    'css' => array(
                        'main' => '%%order_class%% .img-fluid',
                    ),
                ),
            )
        );
    }

	public function get_fields() {
		$fields = array(
			'dnxte_coverflow_autoplay_show_hide' => array(
                'label'           => esc_html__( 'Autoplay', 'et_builder'),
                'type'            => 'yes_no_button',
                'description'     => esc_html__( 'Enable to get the autoplay feature', 'et_builder' ),
                'options'               => array(
                    'on'  => esc_html__( 'Yes', 'et_builder' ),
                    'off' => esc_html__( 'No', 'et_builder' ),
                ),
                'affects'         => array(
                    'dnxte_coverflow_autoplay_delay',
                ),
                'default'          => 'on',
                'default_on_front' => 'on',
                'toggle_slug'      => 'dnxte_coverflow_carousel_settings'
            ),
            'dnxte_coverflow_autoplay_delay' => array(
                'label'           => esc_html__('Autoplay Delay', 'et_builder'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'description'     => esc_html__( 'Adjust the autoplay delay in milliseconds (ms)', 'et_builder' ),
                'default'         =>'2000',
                'depends_show_if' => 'on',
                'toggle_slug'      => 'dnxte_coverflow_carousel_settings'
            ),
            'dnxte_coverflow_loop' => array(
                'label'           => esc_html__( 'Loop', 'et_builder'),
                'type'            => 'yes_no_button',
                'description'     => esc_html__( 'Enable to have the slider slide continuously in a loop.', 'et_builder' ),
                'options'               => array(
                    'on'  => esc_html__( 'Yes', 'et_builder' ),
                    'off' => esc_html__( 'No', 'et_builder' ),
                ),
                'default'          => 'off',
                'default_on_front' => 'off',
                'toggle_slug'      => 'dnxte_coverflow_carousel_settings'
            ),
            'dnxte_coverflow_centered_slides' => array(
                'label'           => esc_html__( 'Center slide', 'et_builder'),
                'type'            => 'yes_no_button',
                'description'     => esc_html__( 'Enable this to have the active image centered.', 'et_builder' ),
                'options'               => array(
                    'on'  => esc_html__( 'Yes', 'et_builder' ),
                    'off' => esc_html__( 'No', 'et_builder' ),
                ),
                'default'          => 'off',
                'toggle_slug'      => 'dnxte_coverflow_carousel_settings'
            ),
            'dnxte_coverflow_auto_height' => array(
                'label'           => esc_html__( 'Auto Height', 'et_builder'),
                'type'            => 'yes_no_button',
                'description'     => esc_html__( 'Enable this to automatically adjust the height of the images.', 'et_builder' ),
                'options'               => array(
                    'on'  => esc_html__( 'Yes', 'et_builder' ),
                    'off' => esc_html__( 'No', 'et_builder' ),
                ),
                'default'          => 'off',
                'default_on_front' => 'off',
                'toggle_slug'      => 'dnxte_coverflow_carousel_settings'
            ),
            'dnxte_coverflow_equal_height' => array(
                'label'           => esc_html__( 'Equal Height', 'et_builder'),
                'type'            => 'yes_no_button',
                'description'     => esc_html__( 'Content entered here will appear inside the module.', 'et_builder' ),
                'options'               => array(
                    'on'  => esc_html__( 'Yes', 'et_builder' ),
                    'off' => esc_html__( 'No', 'et_builder' ),
                ),
                'default'          => 'on',
                'default_on_front' => 'on',
                'toggle_slug'      => 'dnxte_coverflow_carousel_settings'
            ),
            'dnxte_coverflow_grab' => array(
                'label'           => esc_html__( 'Use Grab Cursor', 'et_builder'),
                'type'            => 'yes_no_button',
                'description'     => esc_html__( 'Select on or off to control grab cursor', 'et_builder' ),
                'options'               => array(
                    'on'  => esc_html__( 'Yes', 'et_builder' ),
                    'off' => esc_html__( 'No', 'et_builder' ),
                ),
                'default'          => 'off',
                'default_on_front' => 'off',
                'toggle_slug'      => 'dnxte_coverflow_carousel_navigation'
            ),
            'dnxte_coverflow_keyboard_enable' => array(
                'label'           => esc_html__( 'Keyboard Navigation', 'et_builder'),
                'type'            => 'yes_no_button',
                'description'     => esc_html__( 'Select on or off to control keyboard navigation.', 'et_builder' ),
                'options'               => array(
                    'on'  => esc_html__( 'Yes', 'et_builder' ),
                    'off' => esc_html__( 'No', 'et_builder' ),
                ),
                'default'          => 'on',
                'default_on_front' => 'on',
                'toggle_slug'      => 'dnxte_coverflow_carousel_navigation'
            ),
            'dnxte_coverflow_mousewheel_enable' => array(
                'label'           => esc_html__( 'Mousewheel Navigation', 'et_builder'),
                'type'            => 'yes_no_button',
                'description'     => esc_html__( 'Select on or off to control slide using mousewheel.', 'et_builder' ),
                'options'               => array(
                    'on'  => esc_html__( 'Yes', 'et_builder' ),
                    'off' => esc_html__( 'No', 'et_builder' ),
                ),
                'default'          => 'on',
                'default_on_front' => 'on',
                'toggle_slug'      => 'dnxte_coverflow_carousel_navigation'
            ),
            'dnxte_coverflow_speed'   => array(
                'label'           => esc_html__( 'Speed', 'et_builder' ),
                'type'            => 'range',
                'description'     => esc_html__( 'Adjust the speed of the carousel using the slider below (higher the value, the slider will go slowly and lower the value, the slider will go faster)', 'et_builder' ),
                'option_category'=> 'basic_option',
                'range_settings'  => array(
                    'step' => 1,
                    'min'  => 1,
                    'max'  => 1000,
                ),
                'default'         => '400',
                'fixed_unit'      => '',
                'validate_unit'   => false,
                'unitless'        => true,
                'toggle_slug'      => 'dnxte_coverflow_carousel_settings'
            ),
            'dnxte_coverflow_spacebetween'   => array(
                'label'           => esc_html__( 'Space Between', 'et_builder' ),
                'type'            => 'range',
                'description'     => esc_html__( 'Adjust the space between the images', 'et_builder' ),
                'option_category'=> 'basic_option',
                'range_settings'  => array(
                    'step' => 1,
                    'min'  => 1,
                    'max'  => 300,
                ),
                'default'         => '15',
                'fixed_unit'      => '',
                'validate_unit'   => false,
                'unitless'        => true,
                'toggle_slug'      => 'dnxte_coverflow_carousel_settings'
            ),
            'dnxte_coverflow_arrows' => array(
                'label'           => esc_html__( 'Use Arrow Navigation', 'et_builder'),
                'type'            => 'yes_no_button',
                'description'     => esc_html__( 'Select on or off to control the slide using arrows', 'et_builder' ),
                'options'               => array(
                    'on'  => esc_html__( 'Yes', 'et_builder' ),
                    'off' => esc_html__( 'No', 'et_builder' ),
                ),
                'default'          => 'off',
                'default_on_front' => 'off',
                'toggle_slug'      => 'dnxte_coverflow_carousel_navigation',
            ),
            'dnxte_coverflow_pagination_type'    => array(
                'label'          => esc_html__('Type', 'et_builder'),
                'type'           => 'select',
                'description'     => esc_html__( 'select types for the slider like a bullet, fraction, or progress bar', 'et_builder' ),
                'option_category'=> 'basic_option',
                'options'        => array(
                    "none"    => esc_html__( 'None',  'et_builder' ),
                    'bullets' => esc_html__( 'Bullets',  'et_builder' ),
                    'fraction'   => esc_html__( 'Fraction', 'et_builder' ),
                    'progressbar'   => esc_html__( 'Progress Bar', 'et_builder' ),
                ),
                'default'        => 'bullets',
                'toggle_slug'      => 'dnxte_coverflow_carousel_navigation'
            ),
            'dnxte_coverflow_pagination_bullets' => array(
                'label'           => esc_html__( 'Dynamic Bullets', 'et_builder'),
                'type'            => 'yes_no_button',
                'description'     => esc_html__( 'Enable to highlight the bullet for the active image', 'et_builder' ),
                'options'               => array(
                    'on'  => esc_html__( 'Yes', 'et_builder' ),
                    'off' => esc_html__( 'No', 'et_builder' ),
                ),
                'default_on_front' => 'on',
                'toggle_slug'      => 'dnxte_coverflow_carousel_navigation',
                'show_if'          => array(
                    'dnxte_coverflow_pagination_type' => 'bullets'
                ),
            ),
            'dnxte_coverflow_breakpoint_desktop' => array(
                'label'           => esc_html__('Slides Per View', 'et_builder'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'description'     => esc_html__( 'Place the number of slides you want to view', 'et_builder' ),
                'default'         => '3',
                'default_on_front' => '3',
                'mobile_options'   => true,
				'responsive'       => true,
                'toggle_slug'      => 'dnxte_coverflow_carousel_settings'
            ),
            'dnxte_coverflow_pause_on_hover' => array(
                'label'           => esc_html__( 'Pause On Hover', 'et_builder'),
                'type'            => 'yes_no_button',
                'description'     => esc_html__( 'Enable this to have the slider pause when the cursor hovers on top.', 'et_builder' ),
                'options'               => array(
                    'on'  => esc_html__( 'Yes', 'et_builder' ),
                    'off' => esc_html__( 'No', 'et_builder' ),
                ),
                'default'          => 'on',
                'default_on_front' => 'on',
                'toggle_slug'      => 'dnxte_coverflow_carousel_settings'
            ),
            'dnxte_coverflow_slide_shadows' => array(
                'label'           => esc_html__( 'Use Slide Shadows', 'et_builder'),
                'type'            => 'yes_no_button',
                'description'     => esc_html__( 'When enabled, it adds a shadow to the back of the images in the slide', 'et_builder' ),
                'options'               => array(
                    'on'  => esc_html__( 'Yes', 'et_builder' ),
                    'off' => esc_html__( 'No', 'et_builder' ),
                ),
                'default'         => 'off',
                'default_on_front' => 'off',
                'toggle_slug'      => 'dnxte_coverflow_carousel_effect',
            ),
            'dnxte_coverflow_slide_rotate'   => array(
                'label'           => esc_html__( 'Slide Rotate', 'et_builder' ),
                'type'            => 'range',
                'description'     => esc_html__( 'Use the slider to add a rotation effect', 'et_builder' ),
                'option_category'=> 'basic_option',
                'range_settings'  => array(
                    'step' => 1,
                    'min'  => 1,
                    'max'  => 1000,
                ),
                'default'         => '0',
                'fixed_unit'      => '',
                'validate_unit'   => false,
                'unitless'        => true,
                'toggle_slug'      => 'dnxte_coverflow_carousel_effect'
            ),
            'dnxte_coverflow_slide_stretch'   => array(
                'label'           => esc_html__( 'Slide Stretch', 'et_builder' ),
                'type'            => 'range',
                'description'     => esc_html__( 'Adjust the slide stretch using the slider below', 'et_builder' ),
                'option_category'=> 'basic_option',
                'range_settings'  => array(
                    'step' => 1,
                    'min'  => 1,
                    'max'  => 1000,
                ),
                'default'         => '0',
                'fixed_unit'      => '',
                'validate_unit'   => false,
                'unitless'        => true,
                'toggle_slug'      => 'dnxte_coverflow_carousel_effect'
            ),
            'dnxte_coverflow_slide_depth'   => array(
                'label'           => esc_html__( 'Slide Depth', 'et_builder' ),
                'type'            => 'range',
                'description'     => esc_html__( 'Adjust the distance of the images from the center to the surface to the bottom of the slider
                ', 'et_builder' ),
                'option_category'=> 'basic_option',
                'range_settings'  => array(
                    'step' => 1,
                    'min'  => 1,
                    'max'  => 1000,
                ),
                'default'         => '0',
                'fixed_unit'      => '',
                'validate_unit'   => false,
                'unitless'        => true,
                'toggle_slug'      => 'dnxte_coverflow_carousel_effect'
            ),
            'dnxte_coverflow_image_background' => array(
                'label'        => esc_html__( 'Background', 'et_builder' ),
				'type'         => 'color-alpha',
				'custom_color' => true,
				'default'      => 'transparent',
                'toggle_slug'  => 'dnxte_coverflow_carousel_image_background',
                'sub_toggle'   => 'sub_toggle_color',
                'responsive'   => true,
                'mobile_options' => true
            ),
            'dnxte_coverflow_image_background_gradient_show_hide' => array(
                'label'           => esc_html__( 'Image Background Gradient', 'et_builder' ),
				'type'            => 'yes_no_button',
				'toggle_slug'     => 'dnxte_coverflow_carousel_image_background',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'options'             => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'affects'         => array(
					'dnxte_coverflow_image_background_gradient_color_one',
					'dnxte_coverflow_image_background_gradient_color_two',
					'dnxte_coverflow_image_background_gradient_type',
					'dnxte_coverflow_image_background_gradient_start_position',
					'dnxte_coverflow_image_background_gradient_end_position'
				),
				'default_on_front' => 'off',
            ),
            'dnxte_coverflow_image_background_gradient_color_one'	=> array(
				'label'          => esc_html__('Select Color One', 'et_builder' ),
				'type'           => 'color-alpha',
				'toggle_slug'    => 'dnxte_coverflow_carousel_image_background',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'default'        => '#2b87da',
				'depends_show_if'=> 'on',
				'show_if'        => array(
					'dnxte_coverflow_image_background_gradient_show_hide' => 'on',
				)
			),
			'dnxte_coverflow_image_background_gradient_color_two'	=> array(
				'label'          => esc_html__('Select Color Two', 'et_builder' ),
				'type'           => 'color-alpha',
				'toggle_slug'    => 'dnxte_coverflow_carousel_image_background',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'default'        => '#29c4a9',
				'depends_show_if'=> 'on',
				'show_if'        => array(
					'dnxte_coverflow_image_background_gradient_show_hide' => 'on',
				)
			),
			'dnxte_coverflow_image_background_gradient_type'		=> array(
				'label'           => esc_html__( 'Select Gradient Type', 'et_builder' ),
				'type'            => 'select',
				'description'     => esc_html__( 'Select the types of gradient', 'et_builder' ),
				'option_category' => 'basic_option',
				'toggle_slug'     => 'dnxte_coverflow_carousel_image_background',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'options'         => array(
					'linear-gradient' => esc_html__( 'Linear', 'et_builder' ),
					'radial-gradient' => esc_html__( 'Radial', 'et_builder' ),
				),
				'default'         => 'linear-gradient',
				'depends_show_if'=> 'on',
				'show_if'        => array(
					'dnxte_coverflow_image_background_gradient_show_hide' => 'on',
				)
			),
			'dnxte_coverflow_image_background_gradient_type_linear_direction'   => array(
				'label'           => esc_html__( 'Linear direction', 'et_builder' ),
				'type'            => 'range',
				'option_category'=> 'basic_option',
				'toggle_slug'    => 'dnxte_coverflow_carousel_image_background',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'range_settings'  => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 360,
				),
				'default'         => '180deg',
				'fixed_unit'      => 'deg',
				'show_if' => array(
					'dnxte_coverflow_image_background_gradient_show_hide' => 'on',
					'dnxte_coverflow_image_background_gradient_type' 		 => 'linear-gradient',
				),
			),
			'dnxte_coverflow_image_background_gradient_type_radial_direction'   => array(
				'label'           	=> esc_html__( 'Radial Direction', 'et_builder'),
				'type'            	=> 'select',
				'description'     	=> esc_html__( 'Select the types of gradient', 'et_builder'),
				'option_category'	=> 'basic_option',
				'toggle_slug'    	=> 'dnxte_coverflow_carousel_image_background',
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
					'dnxte_coverflow_image_background_gradient_show_hide' => 'on',
					'dnxte_coverflow_image_background_gradient_type'		=> 'radial-gradient',
				),
			),
			'dnxte_coverflow_image_background_gradient_start_position'           => array(
				'label'           => esc_html__( 'Start Position', 'et_builder' ),
				'type'            => 'range',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'dnxte_coverflow_carousel_image_background',
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
					'dnxte_coverflow_image_background_gradient_show_hide' => 'on',
				)
			),
			'dnxte_coverflow_image_background_gradient_end_position'             => array(
				'label'           => esc_html__( 'End Position', 'et_builder' ),
				'type'            => 'range',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'dnxte_coverflow_carousel_image_background',
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
					'dnxte_coverflow_image_background_gradient_show_hide' => 'on',
				)
            ),
            'dnxte_coverflow_arrow_color' => array(
                'label'        => esc_html__( 'Arrow Color', 'et_builder' ),
				'type'         => 'color-alpha',
				'custom_color' => true,
                'default'      => '#0c71c3',
                'tab_slug'     => 'advanced',
                'toggle_slug'  => 'dnxte_coverflow_carousel_color_settings',
            ),
            'dnxte_coverflow_arrow_background_color' => array(
                'label'        => esc_html__( 'Arrow Background Color', 'et_builder' ),
				'type'         => 'color-alpha',
				'custom_color' => true,
                'default'      => '#fff',
                'tab_slug'     => 'advanced',
                'toggle_slug'  => 'dnxte_coverflow_carousel_color_settings',
            ),
            'dnxte_coverflow_dots_color' => array(
                'label'        => esc_html__( 'Dots Color', 'et_builder' ),
				'type'         => 'color-alpha',
				'custom_color' => true,
                'default'      => '#000',
                'tab_slug'     => 'advanced',
                'toggle_slug'  => 'dnxte_coverflow_carousel_color_settings',
                'show_if'      => array(
                    'dnxte_coverflow_pagination_type' => 'bullets'
                )
            ),
            'dnxte_coverflow_dots_active_color' => array(
                'label'        => esc_html__( 'Dots Active Color', 'et_builder' ),
				'type'         => 'color-alpha',
				'custom_color' => true,
                'default'      => '#0c71c3',
                'tab_slug'     => 'advanced',
                'toggle_slug'  => 'dnxte_coverflow_carousel_color_settings',
                'show_if'      => array(
                    'dnxte_coverflow_pagination_type' => 'bullets'
                )
            ),
            'dnxte_coverflow_progressbar_fill_color' => array(
                'label'        => esc_html__( 'Progressbar Fill Color', 'et_builder' ),
				'type'         => 'color-alpha',
				'custom_color' => true,
                'default'      => '#0c71c3',
                'tab_slug'     => 'advanced',
                'toggle_slug'  => 'dnxte_coverflow_carousel_color_settings',
                'show_if'      => array(
                    'dnxte_coverflow_pagination_type' => 'progressbar'
                )
            ),
            'dnxte_coverflow_arrow_size'   => array(
                'label'           => esc_html__( 'Font Size', 'et_builder' ),
                'type'            => 'range',
                'option_category'=> 'basic_option',
                'range_settings'  => array(
                    'step' => 1,
                    'min'  => 1,
                    'max'  => 100,
                ),
                'default'         => '60',
                'fixed_unit'      => '',
                'validate_unit'   => false,
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'dnxte_coverflow_carousel_arrow_settings'
            ),
            'dnxte_coverflow_arrow_position'    => array(
				'label'           	            => esc_html__( 'Arrow Position', 'et_builder'),
				'type'            	            => 'select',
				'description'     	            => esc_html__( 'Select the types of arrow position', 'et_builder'),
                'option_category'	            => 'basic_option',
                'tab_slug'                      => 'advanced',
				'toggle_slug'    	            => 'dnxte_coverflow_carousel_arrow_settings',
				'options'       	            => array(
                    'default'                   => esc_html__(	'Default', 'et_builder' ),
					'inner'                     => esc_html__(	'Inner', 'et_builder' ),
					'outer'                     => esc_html__(	'Outer', 'et_builder' ),
					'top-left'                  => esc_html__(	'Top Left', 'et_builder' ),
					'top-center'                => esc_html__(	'Top Center', 'et_builder' ),
					'top-right'                 => esc_html__(	'Top Right', 'et_builder' ),
					'bottom-left'               => esc_html__(	'Bottom Left', 'et_builder' ),
					'bottom-center'             => esc_html__(	'Bottom Center', 'et_builder' ),
					'bottom-right'              => esc_html__(	'Bottom Right', 'et_builder' )

				),
				'default'         => 'default',
            ),
            'dnxte_coverflow_arrow_margin'	=> array(
				'label'           		=> esc_html__('Arrow Margin', 'et_builder'),
                'type'            		=> 'custom_margin',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
            'dnxte_coverflow_arrow_padding'	=> array(
				'label'           		=> esc_html__('Arrow Padding', 'et_builder'),
                'type'            		=> 'custom_padding',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding',
            ),
		);

        $lightbox = array(
            'lightbox_showhide' => array(
                'label'           => esc_html__( 'Use Lightbox', 'et_builder'),
                'type'            => 'yes_no_button',
                'description'     => esc_html__( "Enable to view carousel images in a lightbox. Don't worry if it doesn't work the first time. This is for script optimization. By saving and reloading the visual builder, it will work. This works fine on the front end.", 'et_builder' ),
                'options'               => array(
                    'on'  => esc_html__( 'Yes', 'et_builder' ),
                    'off' => esc_html__( 'No', 'et_builder' ),
                ),
                'affects'         => array(
                    'lightbox_arrow_color',
                    'lightbox_close_btn_color',
                    'lightbox_overlay_color',
                ),
                'default'          => 'off',
                'default_on_front' => 'off',
                'toggle_slug'      => 'dnxte_coverflow_carousel_lightbox'
            ),
            'lightbox_arrow_color' => array(
                'label'        => esc_html__( 'Arrow Color', 'et_builder' ),
                'description' => esc_html__( 'Choose color for lightbox arrows.', 'et_builder' ),
				'type'         => 'color-alpha',
				'custom_color' => true,
                'toggle_slug'  => 'dnxte_coverflow_carousel_lightbox',
                'depends_show_if' => 'on',
                'show_if'      => array(
                    'lightbox_showhide' => 'on',
                )
            ),
            'lightbox_close_btn_color' => array(
                'label'        => esc_html__( 'Close Button Color', 'et_builder' ),
                'description' => esc_html__( 'Choose color for lightbox close button.', 'et_builder' ),
				'type'         => 'color-alpha',
				'custom_color' => true,
                'toggle_slug'  => 'dnxte_coverflow_carousel_lightbox',
                'depends_show_if' => 'on',
                'show_if'      => array(
                    'lightbox_showhide' => 'on',
                )
            ),
            'lightbox_overlay_color' => array(
                'label'        => esc_html__( 'Overlay Color', 'et_builder' ),
                'description' => esc_html__( 'Choose color for lightbox overlay background color.', 'et_builder' ),
				'type'         => 'color-alpha',
				'custom_color' => true,
                'toggle_slug'  => 'dnxte_coverflow_carousel_lightbox',
                'depends_show_if' => 'on',
                'show_if'      => array(
                    'lightbox_showhide' => 'on',
                )
            ),  
        );

        return array_merge( $fields, $lightbox );
	}

    public function callingScriptAndStyles() {
        wp_enqueue_script( 'dnext_swiper_frontend' );
        wp_enqueue_script( 'dnext_coverflow_slider' );
        wp_enqueue_style( 'dnext_swiper-min-css' );

        if( 'on' === $this->props['lightbox_showhide'] ) {
            wp_enqueue_script( 'dnext_scripts-public' );
            wp_script_is( 'magnific-popup', 'enqueued' ) ? wp_enqueue_script( 'magnific-popup' ) : wp_enqueue_script( 'dnext_magnific_popup');
            wp_enqueue_style( 'dnext_magnific_popup' );
        }
        wp_enqueue_script( 'dnext_coverflow_lightbox' );
    }

	public function render( $attrs, $content, $render_slug ) {
        $this->callingScriptAndStyles();

        $content = $this->content;
        $dnxte_autoplay_show_hide = "on" === $this->props['dnxte_coverflow_autoplay_show_hide'];
        $dnxte_autoplay_delay = $this->props['dnxte_coverflow_autoplay_delay'];
        $dnxte_coverflow_loop = $this->props['dnxte_coverflow_loop'];
        $dnxte_coverflow_speed = $this->props['dnxte_coverflow_speed'];
        $dnxte_coverflow_slides_perview_desktop = $this->props['dnxte_coverflow_breakpoint_desktop'];
        $dnxte_coverflow_slides_perview_desktop_tablet = $this->props['dnxte_coverflow_breakpoint_desktop_tablet'];
        $dnxte_coverflow_slides_perview_desktop_phone = $this->props['dnxte_coverflow_breakpoint_desktop_phone'];
        $dnxte_coverflow_slides_perview_desktop_last_edited = $this->props['dnxte_coverflow_breakpoint_desktop_last_edited'];
        $mb30 = $this->props['dnxte_coverflow_pagination_type'] == "none" ? "mb-30" : "";


        $dnxte_coverflow_direction = "horizontal";
        $dnxte_coverflow_pagination_type = $this->props['dnxte_coverflow_pagination_type'];
        $dnxte_coverflow_pagination_bullets = $dnxte_coverflow_pagination_type === 'bullets' ? $this->props['dnxte_coverflow_pagination_bullets'] : "off";
        $space_between = $this->props['dnxte_coverflow_spacebetween'];
        $grab_cursor = $this->props['dnxte_coverflow_grab'];
        $slides_center = "on" === $this->props['dnxte_coverflow_centered_slides'];
        $keyboard_nav = $this->props['dnxte_coverflow_keyboard_enable'];
        $mousewheel_nav = $this->props['dnxte_coverflow_mousewheel_enable'];
        $slide_shadow = $this->props['dnxte_coverflow_slide_shadows'];
        $slide_rotate = $this->props['dnxte_coverflow_slide_rotate'];
        $slide_stretch = $this->props['dnxte_coverflow_slide_stretch'];
        $slide_depth = $this->props['dnxte_coverflow_slide_depth'];
        $auto_height = $this->props['dnxte_coverflow_auto_height'];
        $pause_on_hover = "on" === $this->props['dnxte_coverflow_pause_on_hover'];


        // Image filter variables
        $child_hue_rotate = esc_attr__($this->props['child_filter_hue_rotate'], 'et_builder');
        $child_saturate = esc_attr__($this->props['child_filter_saturate'], 'et_builder');
        $child_brightness = esc_attr__($this->props['child_filter_brightness'], 'et_builder');
        $child_contrast = esc_attr__($this->props['child_filter_contrast'], 'et_builder');
        $child_invert = esc_attr__($this->props['child_filter_invert'], 'et_builder');
        $child_sepia = esc_attr__($this->props['child_filter_sepia'], 'et_builder');
        $child_opacity = esc_attr__($this->props['child_filter_opacity'], 'et_builder');
        $child_blur = esc_attr__($this->props['child_filter_blur'], 'et_builder');
        $child_mix_blend_mode = esc_attr__($this->props['child_mix_blend_mode'], 'et_builder');

        if ( '' !== $dnxte_coverflow_slides_perview_desktop_tablet || '' !== $dnxte_coverflow_slides_perview_desktop_phone || '' !== $dnxte_coverflow_slides_perview_desktop ) {
			$is_responsive = et_pb_get_responsive_status( $dnxte_coverflow_slides_perview_desktop_last_edited );

			$slide_to_show_values = array(
				'desktop' => $dnxte_coverflow_slides_perview_desktop,
				'tablet'  => $is_responsive ? $dnxte_coverflow_slides_perview_desktop_tablet : '',
				'phone'   => $is_responsive ? $dnxte_coverflow_slides_perview_desktop_phone : '',
			);
        }

        // USE ARROW CLASSES
        $arrowsClass = "";
        $position_container = "";
        $arrow_top_bottom = "";
        $arrow_left_right_center = "";
        $arrow_position_string = $this->props['dnxte_coverflow_arrow_position'];
        $arrow_position = array(
            'top-left',
            'top-center',
            'top-right',
            'bottom-left',
            'bottom-center',
            'bottom-right'
        );

        if(in_array($arrow_position_string, $arrow_position)) {
            $position_container = "multi-position-container";
        }

        $arrow_top_bottom = substr($arrow_position_string, 0 , 3) === "top" ? "arrow-position-top"
        : "arrow-position-bottom";

        if(substr($arrow_position_string, -strlen("left")) === "left") {
            $arrow_left_right_center =  "multi-position-button-left";
        }elseif(substr($arrow_position_string, -strlen("center")) === "center") {
            $arrow_left_right_center =  "multi-position-button-center";
        }elseif(substr($arrow_position_string, -strlen("right")) === "right") {
            $arrow_left_right_center =  "multi-position-button-right";
        }


        if("off" !== $this->props['dnxte_coverflow_arrows']) {
            if($this->props['dnxte_coverflow_arrow_position'] === 'inner'){
                $arrowsClass = sprintf(
                    '<div class="swiper-button-prev dnxte_coverflow_arrows_inner_left" data-icon="4"></div>
                    <div class="swiper-button-next dnxte_coverflow_arrows_inner_right" data-icon="5"></div>'
                );
            }else if($this->props['dnxte_coverflow_arrow_position'] === 'outer') {
                $arrowsClass = sprintf(
                    '<div class="swiper-button-prev dnxte_coverflow_arrows_outer_left" data-icon="4"></div>
                    <div class="swiper-button-next dnxte_coverflow_arrows_outer_right" data-icon="5"></div>'
                );
            }else if($this->props['dnxte_coverflow_arrow_position'] === 'default'){
                $arrowsClass = sprintf(
                  '<div class="swiper-button-prev dnxte_coverflow_arrows_default_left" data-icon="4"></div>
                  <div class="swiper-button-next dnxte_coverflow_arrows_default_right" data-icon="5"></div>'
              );
            }else if(in_array($this->props['dnxte_coverflow_arrow_position'], $arrow_position)) {
                $arrowsClass = sprintf(
                    '<div class="swiper-button-container multi-position-button-container %1$s">
                        <div class="swiper-button-prev multi-position-button" data-icon="4"></div>
                        <div class="swiper-button-next multi-position-button" data-icon="5"></div>
                    </div>', $arrow_left_right_center
                );
            }
        }

        // PAGINATION CLASSES
        $pagination_class = "swiper-pagination ";
        if( $dnxte_coverflow_pagination_type === "bullets" && $dnxte_coverflow_pagination_bullets === "on"){
            $pagination_class .= "swiper-pagination-clickable swiper-pagination-bullets swiper-pagination-bullets-dynamic mt-10";
        }else if($dnxte_coverflow_pagination_type === "bullets") {
            $pagination_class .= "swiper-pagination-clickable swiper-pagination-bullets mt-10";
        }else if($dnxte_coverflow_pagination_type === "fraction") {
            $pagination_class .= "swiper-pagination-fraction";
        }else if($dnxte_coverflow_pagination_type === "progressbar") {
            $pagination_class .= "swiper-pagination-progressbar";
        }


        // IMAGE BACKGROUND COLOR START

        $dnxte_coverflow_bg = $this->props['dnxte_coverflow_image_background'];
        $dnxte_coverflow_bg_values = et_pb_responsive_options()->get_property_values( $this->props, 'dnxte_coverflow_image_background' );
        $dnxte_coverflow_bg_tablet = isset($dnxte_coverflow_bg_values['tablet']) ? $dnxte_coverflow_bg_values['tablet'] : '';
        $dnxte_coverflow_bg_phone = isset($dnxte_coverflow_bg_values['phone']) ? $dnxte_coverflow_bg_values['phone'] : '';


        $dnxte_coverflow_bg_style = sprintf('background: %1$s !important;', esc_attr__($dnxte_coverflow_bg));
        $dnxte_coverflow_bg_tablet_style = sprintf('background: %1$s !important;', esc_attr__($dnxte_coverflow_bg_tablet));
        $dnxte_coverflow_bg_phone_style = sprintf('background: %1$s !important;', esc_attr__($dnxte_coverflow_bg_phone));

        ET_Builder_Element::set_style( $render_slug, array(
            'selector'    => "%%order_class%% .img-fluid",
            'declaration' => $dnxte_coverflow_bg_style,
        ) );
        ET_Builder_Element::set_style( $render_slug, array(
            'selector'    => "%%order_class%% .img-fluid",
            'declaration' => $dnxte_coverflow_bg_tablet_style,
            'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
        ) );
        ET_Builder_Element::set_style( $render_slug, array(
            'selector'    => "%%order_class%% .img-fluid",
            'declaration' => $dnxte_coverflow_bg_phone_style,
            'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
        ) );

        // IMAGE BACKGROUND COLOR END

        // IMAGE BACKGROUND  GRADIENT COLOR START
		$dnxte_coverflow_image_bg_gradient_color_one = $this->props['dnxte_coverflow_image_background_gradient_color_one'];
		$dnxte_coverflow_image_bg_gradient_color_two = $this->props['dnxte_coverflow_image_background_gradient_color_two'];

		$dnxte_coverflow_image_bg_gradient_type      = $this->props['dnxte_coverflow_image_background_gradient_type'];
		$dnxte_coverflow_image_bg_gradient_start     = $this->props['dnxte_coverflow_image_background_gradient_start_position'];
		$dnxte_coverflow_image_bg_gradient_end     	= $this->props['dnxte_coverflow_image_background_gradient_end_position'];

		$dnxte_coverflow_image_bg_gradient_direction = $dnxte_coverflow_image_bg_gradient_type === 'linear-gradient' ? $this->props['dnxte_coverflow_image_background_gradient_type_linear_direction'] : $this->props['dnxte_coverflow_image_background_gradient_type_radial_direction'];

       if("off" !== $this->props['dnxte_coverflow_image_background_gradient_show_hide']){
        $dnxte_coverflow_image_bg_gradient = sprintf('background: %1$s(%2$s, %3$s %5$s, %4$s %6$s) !important;',$dnxte_coverflow_image_bg_gradient_type, $dnxte_coverflow_image_bg_gradient_direction, esc_attr($dnxte_coverflow_image_bg_gradient_color_one), esc_attr($dnxte_coverflow_image_bg_gradient_color_two), $dnxte_coverflow_image_bg_gradient_start, $dnxte_coverflow_image_bg_gradient_end);

        ET_Builder_Element::set_style( $render_slug, array(
            'selector'    => "%%order_class%% .img-fluid",
            'declaration' => $dnxte_coverflow_image_bg_gradient,
        ) );
       }

		// IMAGE BACKGROUND GRADIENT COLOR END

         // ARROW COLOR

       $dnxte_coverflow_arrow_color = $this->props['dnxte_coverflow_arrow_color'];
       $dnxte_coverflow_arrow_background_color = $this->props['dnxte_coverflow_arrow_background_color'];

       $dnxte_coverflow_arrow_color_style = sprintf('color: %1$s !important; background-color: %2$s !important;', esc_attr($dnxte_coverflow_arrow_color), esc_attr($dnxte_coverflow_arrow_background_color));

       ET_Builder_Element::set_style( $render_slug, array(
        'selector'    => "%%order_class%% .swiper-button-prev,%%order_class%% .swiper-button-next",
        'declaration' => $dnxte_coverflow_arrow_color_style,
        ) );

        // ARROW COLOR END

        // ARROW SIZE START
        $dnxte_coverflow_arrow_size = (int) $this->props['dnxte_coverflow_arrow_size'];
        $arrow_width = $dnxte_coverflow_arrow_size-15;
        $dnxte_coverflow_arrow_size_style = sprintf('font-size: %1$spx', esc_attr($dnxte_coverflow_arrow_size));
        $dnxte_coverflow_arrow_background_width_height = sprintf('width: %1$spx !important;height:%1$spx !important', esc_attr($arrow_width));

        ET_Builder_Element::set_style( $render_slug, array(
            'selector'    => "%%order_class%% .swiper-button-prev:after,%%order_class%%  .swiper-button-next:after",
            'declaration' => $dnxte_coverflow_arrow_size_style,
        ) );
        ET_Builder_Element::set_style( $render_slug, array(
            'selector'    => "%%order_class%% .swiper-button-prev,%%order_class%% .swiper-button-next",
            'declaration' => $dnxte_coverflow_arrow_background_width_height,
        ) );
        // ARROW SIZE END

        // DOTS COLOR START

        $dnxte_coverflow_dots_color = $this->props['dnxte_coverflow_dots_color'];
        $dnxte_coverflow_dots_active_color = $this->props['dnxte_coverflow_dots_active_color'];

        $dnxte_coverflow_dots_color_style = sprintf('background-color: %1$s !important;', esc_attr($dnxte_coverflow_dots_color));
        $dnxte_coverflow_dots_active_color_style = sprintf('background-color: %1$s !important;', esc_attr($dnxte_coverflow_dots_active_color));


        ET_Builder_Element::set_style( $render_slug, array(
        'selector'    => "%%order_class%% .swiper-pagination .swiper-pagination-bullet",
        'declaration' => $dnxte_coverflow_dots_color_style,
        ) );

        ET_Builder_Element::set_style( $render_slug, array(
        'selector'    => "%%order_class%% .swiper-pagination .swiper-pagination-bullet-active",
        'declaration' => $dnxte_coverflow_dots_active_color_style,
        ) );

        // PROGRESSBAR FILL COLOR START

        $dnxte_coverflow_progressbar_color = $this->props['dnxte_coverflow_progressbar_fill_color'];
        $dnxte_coverflow_progressbar_color_style = sprintf('background-color: %1$s !important;', esc_attr($dnxte_coverflow_progressbar_color));
        ET_Builder_Element::set_style( $render_slug, array(
            'selector'    => "%%order_class%% .swiper-pagination-progressbar .swiper-pagination-progressbar-fill",
            'declaration' => $dnxte_coverflow_progressbar_color_style,
        ) );

        // Progressbar fill color end

        // Image filter
        $image_filter_style = sprintf('filter: hue-rotate(%1$s) saturate(%2$s) brightness(%3$s) contrast(%4$s) invert(%5$s) sepia(%6$s) opacity(%7$s) blur(%8$s);mix-blend-mode: %9$s;', $child_hue_rotate, $child_saturate, $child_brightness, $child_contrast, $child_invert, $child_sepia, $child_opacity, $child_blur, $child_mix_blend_mode);

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .img-fluid",
            'declaration' => $image_filter_style,
        ));
        // Image filter end

        // Equal Height Start
        if("off" !== $this->props['dnxte_coverflow_equal_height']) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte_coverflowslider_child",
                'declaration' => 'height: auto !important;',
            ));
        }
        // Equal Height End

        // Arrow position

        $arrow_position_top_css_property = 'left: %1$spx !important;';
        $arrow_position_top_css_selector = array(
            'desktop' => sprintf('%%order_class%% .coverflow-%1$s > .swiper-button-prev', $arrow_position_string),
        );
        $arrow_position_bottom_css_property = 'right: %1$spx !important;';
        $arrow_position_bottom_css_selector = array(
            'desktop' => sprintf('%%order_class%% .coverflow-%1$s > .swiper-button-next', $arrow_position_string),
        );

        // Lightbox Settings
        $lightbox_showhide = isset( $this->props['lightbox_showhide'] ) ? $this->props['lightbox_showhide'] : 'off';

        $output = sprintf(
            '<div class="coverflow-container %25$s %26$s">
                <div class="swiper-container dnxte-coverflowslider-active swiper-container-initialized swiper-container-horizontal %27$s" data-autoplay="%2$s" data-delay="%3$s" data-direction="%9$s" data-speed="%5$s" data-loop="%4$s" data-pagination-type="%10$s" data-pagination-bullets="%11$s"   data-breakpoints="%6$s|%7$s|%8$s" data-spacing="%14$s" data-grab="%15$s" data-center="%16$s" data-keyboardenable="%17$s"  data-covershadow="%18$s" data-coverrotate="%19$s" data-coverstretch="%20$s" data-coverdepth="%21$s" data-autoheight="%22$s" data-pauseonhover="%23$s" data-mouse="%24$s">
                    <div class="swiper-wrapper" data-lightbox="%28$s" data-orderclass="%29$s">
                        %1$s
                    </div>
                    <div class="%13$s"></div>
                </div>
                %12$s
            </div>',
            $content,
            esc_attr( $dnxte_autoplay_show_hide ),
            esc_attr( $dnxte_autoplay_delay ),
            esc_attr( $dnxte_coverflow_loop ),
            esc_attr( $dnxte_coverflow_speed ), // #5
            esc_attr($dnxte_coverflow_slides_perview_desktop),
            '' !== $slide_to_show_values['tablet'] ? esc_attr( $slide_to_show_values['tablet'] ) : 1,
			'' !== $slide_to_show_values['phone'] ? esc_attr( $slide_to_show_values['phone'] ) : 1,
            esc_attr( $dnxte_coverflow_direction ),
            esc_attr( $dnxte_coverflow_pagination_type ), // #10
            esc_attr( $dnxte_coverflow_pagination_bullets ),
            $arrowsClass,
            esc_attr( $pagination_class ),
            esc_attr( $space_between ),
            esc_attr( $grab_cursor ), // #15
            esc_attr( $slides_center ),
            esc_attr( $keyboard_nav ),
            esc_attr( $slide_shadow ),
            esc_attr( $slide_rotate ),
            esc_attr( $slide_stretch ), // #20
            esc_attr( $slide_depth ),
            esc_attr( $auto_height ),
            esc_attr( $pause_on_hover ),
            esc_attr( $mousewheel_nav ),
            $position_container, #25
            $arrow_top_bottom,
            $mb30,
            $lightbox_showhide,
            self::get_module_order_class(  $this->slug )
        );

        $this->apply_css($render_slug);
        if( 'on' === $lightbox_showhide ) {
            $this->lightbox__css( $render_slug );
        }
        return $this->_render_module_wrapper($output, $render_slug);
    }


    public function lightbox__css( $render_slug ) {
        $settings = array( 
            "lightbox_arrow_color" => array( // Ekhane ei key ta holo option slug, same option slug ta use korte hobe
                'css_property' => 'color: %1$s !important;',
                'css_selector'  => array(
                    'desktop' => ".mfp-arrow",
                )
            ),
            "lightbox_close_btn_color" => array( 
                'css_property' => 'color: %1$s !important;',
                'css_selector'  => array(
                    'desktop' => "%%order_class%% .mfp-close",
                )
            ),
            "lightbox_overlay_color" => array( 
                'css_property' => 'background: %1$s !important;',
                'css_selector'  => array(
                    'desktop' => ".mfp-ready.mfp-bg",
                )
            ),
         );

        foreach ($settings as $key => $value) {
            Common::set_css($key, $value['css_property'], $value['css_selector'], $render_slug, $this);
        }
    }

    public function apply_css($render_slug){

        /**
         * Custom Padding Margin Output
         *
        */
        Common::dnxt_set_style($render_slug, $this->props, "dnxte_coverflow_arrow_margin", "%%order_class%% .swiper-button-next,%%order_class%% .swiper-button-prev", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "dnxte_coverflow_arrow_padding", "%%order_class%% .swiper-button-next, %%order_class%% .swiper-button-prev", "padding");
}

}

new Divi_NxteCoverflowSlider;