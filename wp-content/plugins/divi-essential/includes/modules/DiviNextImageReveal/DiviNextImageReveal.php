<?php

class DNEXT_IMAGE_REVEAL extends ET_Builder_Module {

	public $slug       = 'dnxte_image_reveal';
	public $vb_support = 'on';

	protected $module_credits = array(
		'module_uri' => 'https://www.diviessential.com/divi-image-reveal/',
		'author'     => 'Divi Next',
		'author_uri' => 'www.divinext.com',
	);

	public function init() {
		$this->name 		= esc_html__( 'Next Image Reveal', 'et_builder' );
		$this->icon_path	= plugin_dir_path( __FILE__ ) . 'icon.svg';
		$this->folder_name 	= 'et_pb_divi_essential';

		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'dnext_image_reveal'       	=> esc_html__( 'Image', 'et_builder' ),
				),
			),
			'advanced' => array(
				'toggles' => array(
					//Text Reveal Effect
                    'dnext_image_reveal_effect' => array(
                        'title' =>	esc_html__( 'Reveal Color', 'et_builder' ),
                        'sub_toggles' => array(
                            'sub_toggle_color' => array(
                                'name' => esc_html__('Single Color', 'et_builder'),
                            ),
                            'sub_toggle_gradient' => array(
                                'name' => esc_html__('Gradient Color', 'et_builder')
                            ),
                        ),
                        'tabbed_subtoggles' => true,
                    ),
				),
			),
			'custom_css' => array(
				'toggles' 	=> array(),
			),
		);
	}
	

	public function get_fields() {
		return array(
			'dnext_img_reveal' => array(
				'label'              => esc_html__( 'Upload Image', 'et_builder' ),
				'type'               => 'upload',
				'option_category'    => 'basic_option',
				'upload_button_text' => esc_attr__( 'Upload an image', 'et_builder' ),
				'choose_text'        => esc_attr__( 'Choose an Image', 'et_builder' ),
				'update_text'        => esc_attr__( 'Set As Image', 'et_builder' ),
				'depends_show_if'    => 'off',
				'description'        => esc_html__( 'Upload an image to display your image reveal effect.', 'et_builder' ),
				'toggle_slug'        => 'dnext_image_reveal',
				'dynamic_content'    => 'image',
				'mobile_options'     => true,
				'hover'              => 'tabs',
			),
			'dnext_img_reveal_alt' => array(
				'label'           => esc_html__( 'Image Alt Text', 'et_builder' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Define the HTML ALT text for your image here.', 'et_builder' ),
				'tab_slug'        => 'custom_css',
				'toggle_slug'     => 'attributes',
				'dynamic_content' => 'text',
			),
			// reveal effects
			'dnext_image_color_switch'  => array(
				'label'           => esc_html__( 'Single Color', 'et_builder'),
				'type'            => 'yes_no_button', 
				'tab_slug'	  	  => 'advanced',               				
				'toggle_slug'     => 'dnext_image_reveal_effect',
				'sub_toggle'	  => 'sub_toggle_color',
				'options'         => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'affects'         => array(
					'dnext_single_color',
				),
				'default_on_front' => 'on',			
            ),
			// Single Color
			'dnext_single_color'   	=> array(
				'label'          	=> esc_html__('Single', 'et_builder'),
				'type'           	=> 'color-alpha',
				'description'     	=> esc_html__( 'Content entered here will appear inside the module.', 'et_builder' ),				
				'tab_slug'	  	  	=> 'advanced',
				'toggle_slug'     	=> 'dnext_image_reveal_effect',
				'sub_toggle'	  	=> 'sub_toggle_color',
				'hover'    		 	=> 'tabs',
				'default'        	=> '#0077FF',
				'depends_show_if'	=> 'on',
			),
			// Gradient Color tab Switch
			'dnext_gradient_color_switch'  => array(
				'label'           		=> esc_html__( 'Gradient', 'et_builder'),
				'type'            		=> 'yes_no_button',                
				'tab_slug'	  	  		=> 'advanced',
				'toggle_slug'     		=> 'dnext_image_reveal_effect',
				'sub_toggle'	  		=> 'sub_toggle_gradient',
				'options'             	=> array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'affects'         => array(
					'dnxt_color_tab_gradient_one',
					'dnxt_color_tab_gradient_two',
					'dnext_gradient_type_img_reveal',
					'dnext_gradient_type_linear_direction_img_reveal',
					'dnext_gradient_type_radial_direction_img_reveal',
					'dnext_gradient_start_position_img_reveal',
					'dnext_gradient_end_position_img_reveal',
				),
				'default_on_front' => 'off',				
			),
			// Gradient Color One Select One
			'dnxt_color_tab_gradient_one' => array(
				'label'          	=> esc_html__('Select Color One', 'et_builder'),
				'type'           	=> 'color-alpha',
				'tab_slug'       	=> 'advanced',
				'description'     	=> esc_html__( 'Choose the first color to blend with the second color from the color picker that suits your title text.', 'et_builder' ),
				'toggle_slug'    	=> 'dnext_image_reveal_effect',
				'sub_toggle'	  	=> 'sub_toggle_gradient',
				'default'        	=> '#0077FF',
				'depends_show_if'	=> 'on',
			),
			// Gradient Color Two Select Two
			'dnxt_color_tab_gradient_two' => array(
				'label'          => esc_html__('Select Color Two', 'et_builder'),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'description'     => esc_html__( 'Choose the second color to blend with the first color from the color picker that suits your title text.', 'et_builder' ),
				'toggle_slug'    => 'dnext_image_reveal_effect',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'default'        => '#772ADB',
				'depends_show_if'=> 'on',
			),
			// Gradient type text
			'dnext_gradient_type_img_reveal'  => array(
				'label'           => esc_html__('Select Gradient Type', 'et_builder'),
				'type'            => 'select',
				'description'     => esc_html__('Select a type of gradient for the Title Text.', 'et_builder'),
				'option_category' => 'basic_option',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dnext_image_reveal_effect',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'options'         => array(
					'linear-gradient' => esc_html__('Linear', 'et_builder'),
					'radial-gradient' => esc_html__('Radial', 'et_builder'),
				),
				'default'         => 'linear-gradient',
				'depends_show_if'=> 'on',
			),
			// Gradient Linear Type Direction
			'dnext_gradient_type_linear_direction_img_reveal' => array(
				'label'           => esc_html__('Linear direction', 'et_builder'),
				'type'            => 'range',
				'tab_slug'        => 'advanced',
				'description'     => esc_html__( 'Adjust the direction of the gradient for the title text.', 'et_builder' ),
				'toggle_slug'     => 'dnext_image_reveal_effect',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'range_settings'  => array(
							'step' => 1,
							'min'  => 1,
							'max'  => 360,
				),
				'default'         => '180deg',
				'fixed_unit'      => 'deg',
				'validate_unit'   => true,
				'show_if'         => array(
					'dnext_gradient_type_img_reveal' 	=> 'linear-gradient',
					'dnext_gradient_color_switch' 		=> 'on',
				),
			),
			// Gradient Radial Type Selection
			'dnext_gradient_type_radial_direction_img_reveal' => array(
				'label'           => esc_html__('Radial Direction', 'et_builder'),
				'type'            => 'select',
				'description'     => esc_html__( 'Adjust the direction of the gradient for the title text.', 'et_builder' ),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dnext_image_reveal_effect',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'options'         => array(
					'center center'       => esc_html__('Center', 'et_builder'),
					'top'          => esc_html__('Top', 'et_builder'),
					'top left'     => esc_html__('Top Left Corner', 'et_builder'),
					'top right'    => esc_html__('Top Right Corner', 'et_builder'),
					'right'        => esc_html__('Right', 'et_builder'),
					'bottom right' => esc_html__('Bottom Right', 'et_builder'),
					'bottom'       => esc_html__('Bottom', 'et_builder'),
					'bottom left'  => esc_html__('Bottom Left', 'et_builder'),
					'left'         => esc_html__('Left', 'et_builder'),

				),
				'default'         => 'center center',
				'show_if'         => array(
					'dnext_gradient_type_img_reveal'  	=> 'radial-gradient',
					'dnext_gradient_color_switch' 		=> 'on',
				),
			),
			// Gradient Start Position
			'dnext_gradient_start_position_img_reveal' => array(
				'label'           => esc_html__('Start Position', 'et_builder'),
				'type'            => 'range',
				'description'     => esc_html__( 'Adjust the position for the beginning of the gradient color.', 'et_builder' ),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dnext_image_reveal_effect',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'range_settings'  => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 100,
				),
				'default'         => '0%',
				'fixed_unit'      => '%',
				'validate_unit'   => true,
				'show_if'         => array(
					'dnext_gradient_color_switch' => 'on',
				),
			),
			// Gradient End Position
			'dnext_gradient_end_position_img_reveal' => array(
				'label'           => esc_html__('End Position', 'et_builder'),
				'type'            => 'range',
				'description'     => esc_html__( 'Adjust the position for the ending of the gradient color.', 'et_builder' ),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dnext_image_reveal_effect',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'range_settings'  => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 100,
				),
				'default'         => '100%',
				'fixed_unit'      => '%',
				'validate_unit'   => true,
				'show_if'         => array(
					'dnext_gradient_color_switch' => 'on',
				),
			),
		);
	}

	public function get_advanced_fields_config() {
		$advanced_fields = array();

		$advanced_fields = array(
			'width_height' => array(
				'css' => array(
					'main'     => "%%order_class%% .dnext-imr-reveal-effect",
					'important' => 'all',                
				),	
			),
			'margin_padding' => array(
				'css' => array(
					'main' => "%%order_class%% .dnext-imr-reveal-effect",
					'important' => 'all',
				),	
			),
			// change default Border settings
			'borders'	=> array(
				'default' => array(
					'css'	=> array(
						'main'	=> array(
							'border_radii'  => '%%order_class%% .dnext-imr-reveal-effect img',
							'border_styles' => '%%order_class%% .dnext-imr-reveal-effect img',
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
			'box_shadow'            => array(
				'default' => array(
					'css'                 => array(
						'main'        => '%%order_class%% .dnext-imr-reveal-effect',
						'overlay'     => 'inset',
					),
				),
			),
			'text'		=> false,
			'fonts'		=> false,			
		);
		
		return $advanced_fields;
	}
	
	public function render( $attrs, $content, $render_slug ) {
		wp_enqueue_script( 'dnext_wow-public' );
		wp_enqueue_script( 'dnext_wow-activation' );
		wp_enqueue_style( 'dnext_reveal_animation' );

		$multi_view				= et_pb_multi_view_options( $this );
		$dnext_img_reveal		= $this->props['dnext_img_reveal'];
		$dnext_img_reveal_alt	= $this->props['dnext_img_reveal_alt'];

		// Handle svg image behaviour
		$dnext_img_reveal_pathinfo = pathinfo( $dnext_img_reveal );
		$is_dnext_img_reveal_svg 	= isset( $dnext_img_reveal_pathinfo['extension'] ) ? 'svg' === $dnext_img_reveal_pathinfo['extension'] : false;
				
		$dnext_imr_image = $multi_view->render_element( array(
			'tag'   => 'img',
			'attrs' => array(
				'src'   => '{{dnext_img_reveal}}',
				'alt'   => '{{dnext_img_reveal_alt}}',
			),
			'required' => 'dnext_img_reveal',
		) );

		$this->apply_css($render_slug);

		return sprintf( 
			'<figure class="dnext-imr-reveal-effect dnext-imr-masker wow">
				%1$s
			</figure>',
			$dnext_imr_image
		);
	}
	
	public function apply_css( $render_slug ) {

		// Image Background Color
		$dnext_img_reveal_color 			= '';
		$dnext_imr_gradient_type 			= '';
		$dnext_imr_gradient_linear 			= '';
		$dnext_imr_gradient_radial 			= '';
		$dnext_imr_gradient_apply 			= '';
		$dnext_imr_gradient_color_one 		= '';
		$dnext_imr_gradient_color_two 		= '';
		$dnext_imr_gradient_start_position 	= '';
		$dnext_imr_gradient_end_position 	= '';

		// Image BG Color
		if ( '' !== $this->props['dnext_single_color'] ) {
			$dnext_img_reveal_color = $this->props['dnext_single_color'];
		}

		// checking gradient type
		if ( '' !== $this->props['dnext_gradient_type_img_reveal'] ) {
			$dnext_imr_gradient_type = $this->props['dnext_gradient_type_img_reveal'];
		}

		// Linear Gradient Direction
		if ( '' !== $this->props['dnext_gradient_type_linear_direction_img_reveal'] ) {
			$dnext_imr_gradient_linear = $this->props['dnext_gradient_type_linear_direction_img_reveal'];
		}

		// Radial Gradient Direction
		if ( '' !== $this->props['dnext_gradient_type_radial_direction_img_reveal'] ) {
			$dnext_imr_gradient_radial = $this->props['dnext_gradient_type_radial_direction_img_reveal'];
		}

		// Apply gradient direcion
		if ( 'radial-gradient' === $this->props['dnext_gradient_type_img_reveal'] ) {
			$dnext_imr_bg_gradient_apply = sprintf('%1$s', $dnext_imr_gradient_radial);
		} else if ( 'linear-gradient' === $this->props['dnext_gradient_type_img_reveal'] ) {
			$dnext_imr_bg_gradient_apply = sprintf('%1$s', $dnext_imr_gradient_linear);
		}

		// Gradient color one Image BG Color
		if ( '' !== $this->props['dnxt_color_tab_gradient_one'] ) {
			$dnext_imr_gradient_color_one = $this->props['dnxt_color_tab_gradient_one'];
		}

		// Gradient color two Image BG Color
		if ( '' !== $this->props['dnxt_color_tab_gradient_two'] ) {
			$dnext_imr_gradient_color_two = $this->props['dnxt_color_tab_gradient_two'];
		}

		// Gradient color start position 
		if ( '' !== $this->props['dnext_gradient_start_position_img_reveal'] ) {
			$dnext_imr_gradient_start_position = $this->props['dnext_gradient_start_position_img_reveal'];
		}

		// Gradient color end position
		if ( '' !== $this->props['dnext_gradient_end_position_img_reveal'] ) {
			$dnext_imr_gradient_end_position = $this->props['dnext_gradient_end_position_img_reveal'];
		}

		// Image BG Color
		if ( 'off' !== $this->props['dnext_image_color_switch'] ){
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnext-imr-reveal-effect.dnext-imr-masker::after",
				'declaration' => "background-color: $dnext_img_reveal_color;",
			));
		}

		// Gradient setting up
		if ( 'off' !== $this->props['dnext_gradient_color_switch'] ){
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnext-imr-reveal-effect.dnext-imr-masker::after",
				'declaration' => "background: {$dnext_imr_gradient_type}($dnext_imr_bg_gradient_apply, $dnext_imr_gradient_color_one $dnext_imr_gradient_start_position, $dnext_imr_gradient_color_two $dnext_imr_gradient_end_position);",
			));
		}
		
	}
}

new DNEXT_IMAGE_REVEAL;
