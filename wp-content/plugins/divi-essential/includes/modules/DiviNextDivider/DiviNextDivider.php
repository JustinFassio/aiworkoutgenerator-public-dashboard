<?php

class DNEXT_Divider extends ET_Builder_Module {

	public $slug       = 'dnxte_divider';
	public $vb_support = 'on';

	protected $module_credits = array(
		'module_uri' => 'https://www.diviessential.com/divi-next-divider/',
		'author'     => 'Divi Next',
		'author_uri' => 'www.divinext.com',
	);

	public function init() {
		$this->name 		= esc_html__( 'Next Divider', 'et_builder' );
		$this->icon_path	= plugin_dir_path( __FILE__ ) . 'icon.svg';
		$this->folder_name = 'et_pb_divi_essential';

		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'dnext_sid_image'       	=> esc_html__( 'Image & Icon', 'et_builder' ),
					'dnext_divider_background'	=> array(
						'title'		=>	esc_html__( 'Background Color', 'et_builder' ),
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
					)
				),
			),
			'advanced' => array(
				'toggles' => array(
					'dnext_sid_icon_settings' 	=> esc_html__( 'Image & Icon', 'et_builder' ),
					'dnext_sid_divider_style'	=> esc_html__( 'Divider Style', 'et_builder' ),
				),
			),
			'custom_css' => array(
				'toggles' 						=> array(),
			),
		);
	}

	public function get_fields() {
		$et_accent_color = et_builder_accent_color();
		return array(
			'dnext_sid_use_icon'  => array(
				'label'           => esc_html__( 'Use Image', 'et_builder' ),
				'type'            => 'yes_no_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'et_builder' ),
					'on'  => esc_html__( 'Yes', 'et_builder' ),
				),
				'toggle_slug'     => 'dnext_sid_image',
				'affects'         => array(
					'dnext_sid_font_icon',
					'dnext_sid_icon_font_size',
					'dnext_sid_image_max_width',
					'dnext_sid_icon_color',
					'dnext_sid_img',
					'dnext_sid_alt',
				),
				'description' => esc_html__( 'Here you can choose whether icon set below should be used.', 'et_builder' ),
				'default_on_front'=> 'off',
			),
			'dnext_sid_font_icon' 	  => array(
				'label'               => esc_html__( 'Icon', 'et_builder' ),
				'type'                => 'select_icon',
				'default'			  => '7||divi',
				'option_category'     => 'basic_option',
				'class'               => array( 'et-pb-font-icon' ),
				'toggle_slug'         => 'dnext_sid_image',
				'description'         => esc_html__( 'Choose an icon to display with your blurb.', 'et_builder' ),
				'depends_show_if'     => 'off',
				'mobile_options'      => true,
				'hover'               => 'tabs',
			),
			'dnext_sid_icon_color' 	=> array(
				'default'           => $et_accent_color,
				'label'             => esc_html__( 'Icon Color', 'et_builder' ),
				'type'              => 'color-alpha',
				'description'       => esc_html__( 'Here you can define a custom color for your icon.', 'et_builder' ),
				'depends_show_if'   => 'off',
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'dnext_sid_icon_settings',
				'hover'             => 'tabs',
				'default'        	=> '#0077FF',
				'mobile_options'    => true,
			),
			'dnext_sid_icon_alignment' => array(
				'label'           => esc_html__( 'Image/Icon Alignment', 'et_builder' ),
				'description'     => esc_html__( 'Align image/icon to the left, right or center.', 'et_builder' ),
				'type'            => 'align',
				'option_category' => 'layout',
				'options'         => et_builder_get_text_orientation_options( array( 'justified' ) ),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dnext_sid_icon_settings',
				'default'         => 'center',
			),
			'dnext_sid_icon_font_size' => array(
				'label'           => esc_html__( 'Icon Font Size', 'et_builder' ),
				'description'     => esc_html__( 'Control the size of the icon by increasing or decreasing the font size.', 'et_builder' ),
				'type'            => 'range',
				'option_category' => 'font_option',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dnext_sid_icon_settings',
				'default'         => '30px',
				'default_unit'    => 'px',
				'default_on_front'=> '',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'range_settings' => array(
					'min'  => '1',
					'max'  => '120',
					'step' => '1',
				),
				'mobile_options'  => true,
				'depends_show_if' => 'off',
				'responsive'      => true,
				'hover'           => 'tabs',
			),
			'dnext_sid_img' => array(
				'label'              => esc_html__( 'Image', 'et_builder' ),
				'type'               => 'upload',
				'option_category'    => 'basic_option',
				'upload_button_text' => esc_attr__( 'Upload an image', 'et_builder' ),
				'choose_text'        => esc_attr__( 'Choose an Image', 'et_builder' ),
				'update_text'        => esc_attr__( 'Set As Image', 'et_builder' ),
				'depends_show_if'    => 'on',
				'description'        => esc_html__( 'Upload an image to display at the top of your blurb.', 'et_builder' ),
				'toggle_slug'        => 'dnext_sid_image',
				'dynamic_content'    => 'image',
				'mobile_options'     => true,
				'hover'              => 'tabs',
			),
			'dnext_sid_alt' => array(
				'label'           => esc_html__( 'Image Alt Text', 'et_builder' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Define the HTML ALT text for your image here.', 'et_builder' ),
				'depends_show_if' => 'off',
				'tab_slug'        => 'custom_css',
				'toggle_slug'     => 'attributes',
				'dynamic_content' => 'text',
			),
			'dnext_sid_image_max_width' => array(
				'label'           => esc_html__( 'Image Width', 'et_builder' ),
				'description'     => esc_html__( 'Adjust the width of the image within the blurb.', 'et_builder' ),
				'type'            => 'range',
				'option_category' => 'layout',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dnext_sid_icon_settings',
				'mobile_options'  => true,
				'validate_unit'   => true,
				'depends_show_if' => 'on',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'default'         => '100%',
				'default_unit'    => '%',
				'default_on_front'=> '',
				'allow_empty'     => true,
				'range_settings'  => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'responsive'      => true,
				'hover'      	  => 'tabs',
			),
			'dnext_sid_alt' => array(
				'label'           => esc_html__( 'Image Alt Text', 'et_builder' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Define the HTML ALT text for your image here.', 'et_builder' ),
				'depends_show_if' => 'off',
				'tab_slug'        => 'custom_css',
				'toggle_slug'     => 'attributes',
				'dynamic_content' => 'text',
			),
			// Divider Style
			'dnext_sid_divider_style' 	=> array(
				'label'             => esc_html__( 'Divider Style', 'et_builder' ),
				'type'              => 'select',
				'option_category'   => 'layout',
				'description' 		=> esc_html__( 'Divider support various different styles, each of which will change the shape of the divider element.', 'et_builder' ),
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'dnext_sid_divider_style',
				'options'           => et_builder_get_border_styles(),
			),
			// Divider Color
			'dnext_sid_divider_color'  => array(
				'label'           => esc_html__( 'Color', 'et_builder' ),
				'type'            => 'color-alpha',
				'description'     => esc_html__( 'This will adjust the color of the 1px divider line.', 'et_builder' ),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dnext_sid_divider_style',
				'default'         => et_builder_accent_color(),
				'default'		  => '#0077FF'
			),
			// Divider Width
			'dnext_sid_divider_width' 	=> array(
				'label'             => esc_html__( 'Divider Width', 'et_builder' ),
				'type'              => 'range',
				'option_category'   => 'layout',
				'depends_show_if'   => 'on',
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'dnext_sid_divider_style',
				'default_unit'      => 'px',
				'default'           => '1px',
			),
			// Divider Gap
			'dnext_sid_divider_gap' => array(
				'label'             => esc_html__( 'Divider Gap', 'et_builder' ),
				'type'              => 'range',
				'option_category'   => 'layout',
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'dnext_sid_divider_style',
				'default_unit'      => 'px',
				'default'           => '10px',
			),
			// Divider Image / Icon Background 
			'dnext_divider_bg_show_hide'   => array(
				'label'           => esc_html__( 'Background Color', 'et_builder'),
				'type'            => 'yes_no_button', 
				'toggle_slug'     => 'dnext_divider_background',
				'sub_toggle'	  => 'sub_toggle_color',
				'options'             => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'affects'         => array(
					'dnext_divider_bg',
				),
				'default_on_front' => 'off',
			),
			// Divider Image / Icon BG Color
			'dnext_divider_bg'        => array(
				'label'          => esc_html__('Background Color', 'et_builder'),
				'type'           => 'color-alpha',
				'toggle_slug'    => 'dnext_divider_background',
				'sub_toggle'	 => 'sub_toggle_color',
				'hover'    		 => 'tabs',
				'default'        => '#0077FF',
				'depends_show_if'=> 'on',
			),
			// Background Image / Icon Gradient 
			'dnext_divider_bg_gradient_show_hide'  => array(
				'label'           => esc_html__( 'Gradient Color', 'et_builder'),
				'type'            => 'yes_no_button',
				'toggle_slug'     => 'dnext_divider_background',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'options'             => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'affects'         => array(
					'dnext_divider_bg_gradient_color_one',
					'dnext_divider_bg_gradient_color_two',
					'dnext_divider_bg_gradient_type',
					'dnext_divider_bg_gradient_start_position',
					'dnext_divider_bg_gradient_end_position'
				),
				'default_on_front' => 'off',
			),
			'dnext_divider_bg_gradient_color_one'	=> array(
				'label'          => esc_html__('Select Color One', 'et_builder'),
				'type'           => 'color-alpha',
				'toggle_slug'    => 'dnext_divider_background',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'default'        => '#0077FF',
				'depends_show_if'=> 'on',
			),
			'dnext_divider_bg_gradient_color_two'	=> array(
				'label'          => esc_html__('Select Color Two', 'et_builder'),
				'type'           => 'color-alpha',
				'toggle_slug'    => 'dnext_divider_background',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'default'        => '#772ADB',
				'depends_show_if'=> 'on',
			),
			'dnext_divider_bg_gradient_type'  => array(
				'label'           => esc_html__('Select Gradient Type', 'et_builder'),
				'type'            => 'select',
				'description'     => esc_html__('Select the types of gradient', 'et_builder'),
				'option_category' => 'basic_option',
				'toggle_slug'     => 'dnext_divider_background',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'options'         => array(
					'linear-gradient' => esc_html__('Linear', 'et_builder'),
					'radial-gradient' => esc_html__('Radial', 'et_builder'),
				),
				'default'         => 'linear-gradient',
				'depends_show_if' => 'on',
			),
			'dnext_divider_bg_gradient_type_linear_direction'   => array(
				'label'           => esc_html__('Linear direction', 'et_builder'),
				'type'            => 'range',
				'option_category'=> 'basic_option',
				'toggle_slug'    => 'dnext_divider_background',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'range_settings'  => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 360,
				),
				'default'         => '180deg',
				'fixed_unit'      => 'deg',
				'validate_unit'   => true,
				'show_if' => array(
					'dnext_divider_bg_gradient_show_hide' => 'on',
					'dnext_divider_bg_gradient_type' 	  => 'linear-gradient'
				),
			),
			'dnext_divider_bg_gradient_type_radial_direction'   => array(
				'label'           	=> esc_html__('Radial Direction', 'et_builder'),
				'type'            	=> 'select',
				'description'     	=> esc_html__('Select the types of gradient', 'et_builder'),                
				'option_category'	=> 'basic_option',
				'toggle_slug'    	=> 'dnext_divider_background',
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
					'dnext_divider_bg_gradient_show_hide' 	=> 'on',
					'dnext_divider_bg_gradient_type'		=> 'radial-gradient',
				),
			),
			'dnext_divider_bg_gradient_start_position'          => array(
				'label'           => esc_html__('Start Position', 'et_builder'),
				'type'            => 'range',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'dnext_divider_background',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'range_settings'  => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 100,
				),
				'default'         => '0%',
				'fixed_unit'      => '%',
				'validate_unit'   => true,
				'depends_show_if' => 'on',
			),
			'dnext_divider_bg_gradient_end_position'            => array(
				'label'           => esc_html__('End Position', 'et_builder'),
				'type'            => 'range',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'dnext_divider_background',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'range_settings'  => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 100,
				),
				'default'         => '100%',
				'fixed_unit'      => '%',
				'validate_unit'   => true,
				'depends_show_if' => 'on',
			),
		);
	}

	public function get_advanced_fields_config() {
		$advanced_fields = array();

		$advanced_fields = array(
			'fonts'      => false,
			'background' => array(
				'settings'	=> array(
					'color' => 'alpha',
					'css'   => array(
						'main' => "%%order_class%% .dnext-sid-text-divider-img, %%order_class%% .dnext-sid-text-divider-icon",
						'important' => true,
					),
				),
			),
			'borders'	=> array(
				'default' => array(
					'css'	=> array(
						'main'	=> array(
							'border_radii'  => '%%order_class%% .dnext-sid-text-divider-img, %%order_class%% .dnext-sid-text-divider-icon',
							'border_styles' => '%%order_class%% .dnext-sid-text-divider-img, %%order_class%% .dnext-sid-text-divider-icon',
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
			),
			'text'       => false,
			'margin_padding' => array(
				'css' => array(
					'main' => "%%order_class%% .dnext-sid-text-divider-img, %%order_class%% .dnext-sid-text-divider-icon",
					'important' => 'all',
				),	
			),
			'box_shadow'            => array(
				'default' => array(
					'css'                 => array(
						'main'        => "%%order_class%% .dnext-sid-text-divider-img, %%order_class%% .dnext-sid-text-divider-icon",
						'hover'       => '%%order_class%%:hover .dnext-sid-text-divider-img, %%order_class%%:hover .dnext-sid-text-divider-icon',
						'overlay'     => 'inset',
					),
				),
			)
		);
		return $advanced_fields;
	}
	
	public function render( $attrs, $content, $render_slug ) {
		$multi_view							  = et_pb_multi_view_options( $this );
		$dnext_sid_use_icon	 				  = $this->props['dnext_sid_use_icon'];

		$dnext_sid_icon_font_size			  = $this->props['dnext_sid_icon_font_size'];
		$dnext_sid_icon_font_size_hover 	  = $this->get_hover_value( 'dnext_sid_icon_font_size' );
		$dnext_sid_icon_font_size_tablet      = $this->props['dnext_sid_icon_font_size_tablet'];
		$dnext_sid_icon_font_size_phone       = $this->props['dnext_sid_icon_font_size_phone'];
		$dnext_sid_icon_font_size_last_edited = $this->props['dnext_sid_icon_font_size_last_edited'];

		$dnext_sid_image_max_width			  	= $this->props['dnext_sid_image_max_width'];
		$dnext_sid_image_max_width_hover 	  	= $this->get_hover_value( 'dnext_sid_image_max_width' );
		$dnext_sid_image_max_width_tablet      	= $this->props['dnext_sid_image_max_width_tablet'];
		$dnext_sid_image_max_width_phone       	= $this->props['dnext_sid_image_max_width_phone'];
		$dnext_sid_image_max_width_last_edited 	= $this->props['dnext_sid_image_max_width_last_edited'];

		$dnext_sid_icon_color				  = $this->props['dnext_sid_icon_color'];
		$dnext_sid_icon_color_hover 		  = $this->get_hover_value( 'dnext_sid_icon_color' );
		$dnext_sid_icon_color_values		  = et_pb_responsive_options()->get_property_values( $this->props, 'dnext_sid_icon_color' );
		$dnext_sid_icon_color_tablet		  = isset( $dnext_sid_icon_color_values['tablet'] ) ? $dnext_sid_icon_color_values['tablet'] : '';
		$dnext_sid_icon_color_phone			  = isset( $dnext_sid_icon_color_values['phone'] ) ? $dnext_sid_icon_color_values['phone'] : '';

		$dnext_sid_img		 				  = $this->props['dnext_sid_img'];
		$dnext_sid_alt		 				  = $this->props['dnext_sid_alt'];

		$dnext_sid_icon_alignment			  = $this->props['dnext_sid_icon_alignment'];

		$dnext_sid_icon_selector 			  = "%%order_class%% .dnext-sid-text-divider-icon";
		$dnext_sid_icon_class 	 			  = "dnext-sid-text-divider-icon";

		$dnext_sid_icon_selector 			  = "%%order_class%% .dnext-sid-text-divider-icon";
		$dnext_sid_image_selector 			  = "%%order_class%% .dnext-sid-text-divider-img";
		$image_icon 			= '';
		$dnext_sid_icon_hover	= '';

		// Handle svg image behaviour
		$dnext_sid_img_pathinfo = pathinfo( $dnext_sid_img );
		$is_dnext_sid_img_svg 	= isset( $dnext_sid_img_pathinfo['extension'] ) ? 'svg' === $dnext_sid_img_pathinfo['extension'] : false;
		
		if ( 'off' !== $dnext_sid_use_icon ) {
			$image_icon = $multi_view->render_element( array(
				'tag'   => 'img',
				'attrs' => array(
					'src'   => '{{dnext_sid_img}}',
					'alt'   => '{{dnext_sid_alt}}',
					'class'	=> 'dnext-sid-text-divider-img et-waypoint et_pb_animation_top et-animated',
				),
				'required' => 'dnext_sid_img',
			) );

		
		} else {
			// Font Icon Styles.
			$icon_css_property = array(
				'selector'    => '%%order_class%% .dnext-sid-text-divider-icon',
				'class'       => 'dnext-sid-text-divider-icon'
			);
			$image_icon = Common::get_icon_html( 'dnext_sid_font_icon', $this, $render_slug, $multi_view, $icon_css_property );
		}

		if ( 'off' === $dnext_sid_use_icon ) {
			$dnext_sid_icon_style 		 = sprintf( 'color: %1$s;', esc_attr( $dnext_sid_icon_color ) );
			$dnext_sid_icon_tablet_style = '' !== $dnext_sid_icon_color_tablet ? sprintf( 'color: %1$s;', esc_attr( $dnext_sid_icon_color_tablet ) ) : '';
			$dnext_sid_icon_phone_style  = '' !== $dnext_sid_icon_color_phone ? sprintf( 'color: %1$s;', esc_attr( $dnext_sid_icon_color_phone ) ) : '';
			
			$dnext_sid_icon_style_hover  = '';

			if ( et_builder_is_hover_enabled( 'dnext_sid_icon_color', $this->props ) ) {
				$dnext_sid_icon_style_hover = sprintf( 'color: %1$s;', esc_attr( $dnext_sid_icon_color_hover ) );
			}

			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => $dnext_sid_icon_selector,
				'declaration' => $dnext_sid_icon_style,
			) );
			
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => $dnext_sid_icon_selector,
				'declaration' => $dnext_sid_icon_tablet_style,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
			) );

			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => $dnext_sid_icon_selector,
				'declaration' => $dnext_sid_icon_phone_style,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
			) );

			if ( '' !== $dnext_sid_icon_style_hover ) {
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => $this->add_hover_to_order_class( '%%order_class%% .dnext-sid-text-divider-icon-hover' ),
					'declaration' => $dnext_sid_icon_style_hover,
				) );
			}
		}

		if ( 'on' !== $this->props['dnext_sid_use_icon'] ) {
			$dnext_sid_font_size_responsive_active = et_pb_get_responsive_status( $dnext_sid_icon_font_size_last_edited );

			$dnext_sid_font_size_values = array(
				'desktop' => $dnext_sid_icon_font_size,
				'tablet'  => $dnext_sid_font_size_responsive_active ? $dnext_sid_icon_font_size_tablet : '',
				'phone'   => $dnext_sid_font_size_responsive_active ? $dnext_sid_icon_font_size_phone : '',
			);

			et_pb_responsive_options()->generate_responsive_css( $dnext_sid_font_size_values, $dnext_sid_icon_selector, 'font-size', $render_slug );

			if ( et_builder_is_hover_enabled( 'dnext_sid_icon_font_size', $this->props ) ) {
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => $this->add_hover_to_order_class( '%%order_class%% .dnext-sid-text-divider-icon-hover' ),
					'declaration' => sprintf(
						'font-size: %1$s;',
						esc_html( $dnext_sid_icon_font_size_hover )
					),
				) );
			}
		}
		if ( 'off' !== $this->props['dnext_sid_use_icon'] ) {
			$dnext_sid_image_max_width_responsive_active = et_pb_get_responsive_status( $dnext_sid_image_max_width_last_edited );

			$dnext_sid_image_max_width_values = array(
				'desktop' => $dnext_sid_image_max_width,
				'tablet'  => $dnext_sid_image_max_width_responsive_active ? $dnext_sid_image_max_width_tablet : '',
				'phone'   => $dnext_sid_image_max_width_responsive_active ? $dnext_sid_image_max_width_phone : '',
			);

			et_pb_responsive_options()->generate_responsive_css( $dnext_sid_image_max_width_values, $dnext_sid_image_selector, 'max-width', $render_slug );

			if ( et_builder_is_hover_enabled( 'dnext_sid_image_max_width', $this->props ) ) {
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => $this->add_hover_to_order_class( '%%order_class%% .dnext-sid-text-divider-img:hover' ),
					'declaration' => sprintf(
						'max-width: %1$s;',
						esc_html( $dnext_sid_image_max_width_hover )
					),
				) );
			}
		}

		$dnext_sid_icon_alignment = "";
				
		switch ( $this->props['dnext_sid_icon_alignment'] ) {
			case 'left':
				$dnext_sid_icon_alignment .="dnext-sid-text-divider-alignment-left";
				break;
			case 'right':
				$dnext_sid_icon_alignment .="dnext-sid-text-divider-alignment-right";				
				break;
			default:
			$dnext_sid_icon_alignment = '';
				break;
		}

		$this->apply_css( $render_slug );
		return sprintf( 
			'<div class="dnext-sid-text-divider-wrapper %3$s">
				<div class="dnext-sid-text-divider-before dnext-sid-text-divider"></div>
				%1$s
				%2$s
				<div class="dnext-sid-text-divider-after dnext-sid-text-divider"></div>
			</div>',
			$image_icon,
			$dnext_sid_icon_hover,
			$dnext_sid_icon_alignment
		);
	}

	public function apply_css( $render_slug ) {

		$dnext_sid_icon_font_icon_hover	= esc_attr( et_pb_process_font_icon($this->get_hover_value( 'dnext_sid_font_icon' )));

		if ( 'off' === $dnext_sid_icon_font_icon_hover ) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    	=> $this->add_hover_to_oder_class( '%%order_class%% .dnext-sid-text-divider-icon' ),
				'declaration'	=> "font-family: 'ETmodules';content: attr(data-icon);display: none;"
			) );

			ET_Builder_Element::set_style($render_slug, array(
				'selector'    	=> "%%order_class%%:hover .dnext-sid-text-divider-icon",
				'declaration'	=> "font-family: 'ETmodules';content: attr(data-icon);display: none;"
			) );
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    	=> "%%order_class%% .dnext-sid-text-divider-icon-hover",
				'declaration'	=> "display: none;"
			) );
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    	=> "%%order_class%%:hover .dnext-sid-text-divider-icon-hover",
				'declaration'	=> "font-family: 'ETmodules';content: attr(data-icon);display: block;"
			) );
		}

		// Icon / Image Background Color
		$dnext_sid_bg             				= '';
		$dnext_sid_bg_gradient_type	   		 	= '';
		$dnext_sid_bg_gl_direction             	= '';
		$dnext_sid_bg_gr_direction             	= '';
		$dnext_sid_bg_gradient_apply         	= '';
		$dnext_sid_bg_gradient_color_one 	 	= '';
		$dnext_sid_bg_gradient_color_two 	 	= '';
		$dnext_sid_bg_gradient_start_position	= '';
		$dnext_sid_bg_gradient_end_position  	= '';

		// Divider Icon / Img BG Color
		if ( '' !== $this->props['dnext_divider_bg'] ) {
			$dnext_sid_bg = $this->props['dnext_divider_bg'];
		}

		// checking gradient type
		if ( '' !== $this->props['dnext_divider_bg_gradient_type'] ) {
			$dnext_sid_bg_gradient_type = $this->props['dnext_divider_bg_gradient_type'];
		}

		// Button Linear Gradient Direction
		if ( '' !== $this->props['dnext_divider_bg_gradient_type_linear_direction'] ) {
			$dnext_sid_bg_gl_direction = $this->props['dnext_divider_bg_gradient_type_linear_direction'];
		}

		// Button Radial Gradient Direction
		if ( '' !== $this->props['dnext_divider_bg_gradient_type_radial_direction'] ) {
			$dnext_sid_bg_gr_direction = $this->props['dnext_divider_bg_gradient_type_radial_direction'];
		}

		// Apply gradient direcion
		if ( 'radial-gradient' === $this->props['dnext_divider_bg_gradient_type'] ) {
			$dnext_sid_bg_gradient_apply = sprintf('%1$s', $dnext_sid_bg_gr_direction);
		} else if ( 'linear-gradient' === $this->props['dnext_divider_bg_gradient_type'] ) {
			$dnext_sid_bg_gradient_apply = sprintf('%1$s', $dnext_sid_bg_gl_direction);
		}

		// Gradient color one Icon / Image BG Color
		if ( '' !== $this->props['dnext_divider_bg_gradient_color_one'] ) {
			$dnext_sid_bg_gradient_color_one = $this->props['dnext_divider_bg_gradient_color_one'];
		}

		// Gradient color two Icon / Image BG Color
		if ( '' !== $this->props['dnext_divider_bg_gradient_color_two'] ) {
			$dnext_sid_bg_gradient_color_two = $this->props['dnext_divider_bg_gradient_color_two'];
		}

		// Gradient color start position 
		if ( '' !== $this->props['dnext_divider_bg_gradient_start_position'] ) {
			$dnext_sid_bg_gradient_start_position = $this->props['dnext_divider_bg_gradient_start_position'];
		}

		// Gradient color end position
		if ( '' !== $this->props['dnext_divider_bg_gradient_end_position'] ) {
			$dnext_sid_bg_gradient_end_position = $this->props['dnext_divider_bg_gradient_end_position'];
		}

		// Divider Icon / Image BG Color
		if ( 'off' !== $this->props['dnext_divider_bg_show_hide'] ){
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnext-sid-text-divider-img, %%order_class%% .dnext-sid-text-divider-icon",
				'declaration' => "background: $dnext_sid_bg;",
			));
		}

		// Gradient setting up
		if ( 'off' !== $this->props['dnext_divider_bg_gradient_show_hide'] ){
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnext-sid-text-divider-img, %%order_class%% .dnext-sid-text-divider-icon",
				'declaration' => "background: {$dnext_sid_bg_gradient_type}($dnext_sid_bg_gradient_apply, $dnext_sid_bg_gradient_color_one $dnext_sid_bg_gradient_start_position, $dnext_sid_bg_gradient_color_two $dnext_sid_bg_gradient_end_position);",
			));
		}

		// Divider Style
		if ( '' !== $this->props['dnext_sid_divider_style'] ) {
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => '%%order_class%% .dnext-sid-text-divider',
				'declaration' => sprintf(
					'border-top-style: %1$s;',
					esc_attr( $this->props['dnext_sid_divider_style'] )
				),
			) );
		}
		
		// Divider Color
		if ( '' !== $this->props['dnext_sid_divider_color'] ) {
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => '%%order_class%% .dnext-sid-text-divider',
				'declaration' => sprintf(
					'border-top-color: %1$s;',
					esc_attr( $this->props['dnext_sid_divider_color'] )
				),
			) );
		}

		// Divider Color
		if ( '' !== $this->props['dnext_sid_divider_width'] ) {
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => '%%order_class%% .dnext-sid-text-divider',
				'declaration' => sprintf(
					'border-top-width: %1$s;',
					esc_attr( $this->props['dnext_sid_divider_width'] )
				),
			) );
		}

		// Divider Gap
		if ( '' !== $this->props['dnext_sid_divider_gap'] ) {
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => '%%order_class%% .dnext-sid-text-divider',
				'declaration' => sprintf(
					'margin: %1$s;',
					esc_attr( $this->props['dnext_sid_divider_gap'] )
				),
			) );
		}
	}

	public function multi_view_filter_value( $raw_value, $args, $multi_view ) {
		$name = isset( $args['name'] ) ? $args['name'] : '';
		$mode = isset( $args['mode'] ) ? $args['mode'] : '';

		if ( $raw_value && 'dnext_sid_font_icon' === $name ) {
			return et_pb_get_extended_font_icon_value( $raw_value, true );
		}
		return $raw_value;
	}
}

new DNEXT_Divider;
