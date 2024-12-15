<?php

class Next_Text_Color_Motion extends ET_Builder_Module {

	public $slug       = 'dnxte_text_color_motion';
	public $vb_support = 'on';

	protected $module_credits = array(
		'module_uri' => 'https://www.diviessential.com/divi-text-color-motion/',
		'author'     => 'Divi Next',
		'author_uri' => 'www.divinext.com',
	);

	public function init() {
		$this->name 		= esc_html__( 'Next Text Color Motion', 'et_builder' );
		$this->icon_path    = plugin_dir_path( __FILE__ ) . 'icon.svg';
		$this->folder_name 	= 'et_pb_divi_essential';
		
		$this->settings_modal_toggles = array(
			'general'	=> array(
				'toggles'		=>	array(
					'dnxt_blurb_heading'	=> esc_html__( 'Text', 'et_builder' ),					
				),
			),
			'advanced'	=> array(
				'toggles'	=>	array(					
					'dnxt_text_font'	=> array(
						"title"		=>	esc_html__( 'Text', 'et_builder' ),						
					),			
					'dnxt_color_motion_styles'	=> array(
						'title'		=>	esc_html__( 'Color Motion Style', 'et_builder' ),												                                                
					),	
					'dnxt_color_motion_color'	=> array(
						'title'		=>	esc_html__( 'Colors', 'et_builder' ),	
					),
				), 
			),			
		);
	}

	public function get_fields() {
		return array(
			//Text Field
			'text_color_motion' => array(
				'label'           => esc_html__( 'Color Motion Text', 'et_builder' ),
				'type'            => 'text',
				'dynamic_content' => 'text',
				//'default'         => 'Heading',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Content entered here will appear inside the module.', 'et_builder' ),
				'toggle_slug'     => 'main_content',

			),
			//Heading Tag
			'heading_tag'         => array(
				'label'           => esc_html__('Select Heading Tag', 'et_builder'),
				'type'            => 'select',
				'description'     => esc_html__('Select the heading tag, which you would like to use', 'et_builder'),
				'option_category' => 'basic_option',
				'toggle_slug'     => 'main_content',
				'options'         => array(
					'h1'	  => esc_html__('H1', 'et_builder'),
					'h2'	  => esc_html__('H2', 'et_builder'),
					'h3'	  => esc_html__('H3', 'et_builder'),
					'h4'	  => esc_html__('H4', 'et_builder'),
					'h5'	  => esc_html__('H5', 'et_builder'),
					'h6'	  => esc_html__('H6', 'et_builder'),
					'p'	      => esc_html__('P', 'et_builder'),
					'span'	  => esc_html__('Span', 'et_builder'),
				),
				'default'         => 'h2',
			),
			//Color Motion Styles
			'text_color_motion_style'         => array(
				'label'           => esc_html__('Color Motion Style', 'et_builder'),
				'type'            => 'select',
				'description'     => esc_html__( 'Choose a Gradient animated style from the list below.', 'et_builder' ),
				'tab_slug'	  	  => 'advanced',
				'toggle_slug'     => 'dnxt_color_motion_styles',
				'options'         => array(
					'dnxt-grdnt-text-animation'	  => esc_html__('Style1', 'et_builder'),
					'dnxt-grdnt-text-animation-2'	  => esc_html__('Style2', 'et_builder')				
				),
				'default'         => 'dnxt-grdnt-text-animation',
			),
			// Color Motion Duration 
			'color_motion_text_duration' => array(
                'label'           => esc_html__('Motion Duration', 'et_builder'),
				'type'            => 'range',
				'description'     => esc_html__( 'Adjust color two to the right of the text you have entered and see how it looks.', 'et_builder' ),
                'tab_slug'	  	  => 'advanced',
				'toggle_slug'     => 'dnxt_color_motion_styles',
                'range_settings'  => array(
                    'step' => 0.5,
                    'min'  => 1,
                    'max'  => 100,
                ),
                'default'         => '0',
                'fixed_unit'      => 's',
				'validate_unit'   => true                
			),
			//Color Motion Color
			'color_motion_color_one'	=> array(
				'label'          	=> esc_html__('Select Color One', 'et_builder'),
				'type'           	=> 'color-alpha',
				'description'     	=> esc_html__( 'Content entered here will appear inside the module.', 'et_builder' ),
				'tab_slug'          => 'advanced',
				'toggle_slug'    	=> 'dnxt_color_motion_color',				
				'default'        	=> '#0077FF',
			),
			'color_motion_color_two'	=> array(
				'label'          	=> esc_html__('Select Color Two', 'et_builder'),
				'type'           	=> 'color-alpha',
				'description'     	=> esc_html__( 'Content entered here will appear inside the module.', 'et_builder' ),
				'tab_slug'          => 'advanced',
				'toggle_slug'    	=> 'dnxt_color_motion_color',			
				'default'        	=> '#772ADB',
			),
			'color_motion_color_three'	=> array(
				'label'          	=> esc_html__('Select Color Three', 'et_builder'),
				'type'           	=> 'color-alpha',
				'option_category'	=> 'layout',
				'description'     	=> esc_html__( 'Content entered here will appear inside the module.', 'et_builder' ),
				'tab_slug'          => 'advanced',
				'toggle_slug'    	=> 'dnxt_color_motion_color',				
				'default'        	=> '#00e1ff',
			),
			'color_motion_color_four'	=> array(
				'label'          	=> esc_html__('Select Color Four', 'et_builder'),
				'type'           	=> 'color-alpha',
				'description'    	=> esc_html__( 'Content entered here will appear inside the module.', 'et_builder' ),
				'tab_slug'          => 'advanced',
				'toggle_slug'    	=> 'dnxt_color_motion_color',			
				'default'        	=> '#ff23da',
			),
			'color_motion_type'		=> array(
                'label'           	=> esc_html__('Select Gradient Type', 'et_builder'),
                'type'            	=> 'select',
				'description'     	=> esc_html__('Select the types of gradient', 'et_builder'),
				'option_category' 	=> 'layout',				
				'tab_slug'        	=> 'advanced',
				'toggle_slug'     	=> 'dnxt_color_motion_color',		
                'options'         	=> array(
                    'linear-gradient' => esc_html__('Linear', 'et_builder'),
                    'radial-gradient' => esc_html__('Radial', 'et_builder'),
                ),
				'default'         	=> 'linear-gradient'				
			),
			'color_motion_type_linear_direction'   => array(
                'label'          	=> esc_html__('Linear direction', 'et_builder'),
                'type'           	=> 'range',
				'option_category'	=> 'layout',
				'description'     => esc_html__( 'Content entered here will appear inside the module.', 'et_builder' ),
				'tab_slug'          => 'advanced',
				'toggle_slug'    	=> 'dnxt_color_motion_color',			
                'range_settings'  	=> array(
							'step' 	=> 1,
							'min'  	=> 1,
							'max'  	=> 90,
                ),
                'default'         	=> '45deg',
                'fixed_unit'      	=> 'deg',
                'validate_unit'   	=> true,
				'show_if' 			=> array(				
				'color_motion_type' => 'linear-gradient'
				),
			),
			'color_motion_type_radial_direction'   => array(
                'label'           	=> esc_html__('Radial Direction', 'et_builder'),
                'type'            	=> 'select',
				'description'     	=> esc_html__('Select the types of gradient', 'et_builder'),                                
				'option_category'	=> 'layout',
				'tab_slug'          => 'advanced',
				'toggle_slug'    	=> 'dnxt_color_motion_color',
                'options'       	=>  array(
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
					'color_motion_type'	=> 'radial-gradient'
                ),
			),

			'color_motion_color_one_position'           => array(
                'label'           => esc_html__('Color One Position', 'et_builder'),
                'type'            => 'range',                
				'option_category' => 'layout',
				'description'     => esc_html__( 'Content entered here will appear inside the module.', 'et_builder' ),
				'tab_slug'     	  => 'advanced',
				'toggle_slug'     => 'dnxt_color_motion_color',		
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

			'color_motion_color_two_position'           => array(
                'label'           => esc_html__('Color Two Position', 'et_builder'),
                'type'            => 'range',                
				'option_category' => 'layout',
				'description'     => esc_html__( 'Content entered here will appear inside the module.', 'et_builder' ),
				'tab_slug'     	  => 'advanced',
				'toggle_slug'     => 'dnxt_color_motion_color',		
                'range_settings'  => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 100,
                ),
                'default'         => '30%',
                'fixed_unit'      => '%',
				'validate_unit'   => true,
				'depends_show_if' => 'on',
			),

			'color_motion_color_three_position'           => array(
                'label'           => esc_html__('Color Three Position', 'et_builder'),
                'type'            => 'range',                
				'option_category' => 'layout',
				'description'     => esc_html__( 'Content entered here will appear inside the module.', 'et_builder' ),
				'tab_slug'     	  => 'advanced',
				'toggle_slug'     => 'dnxt_color_motion_color',		
                'range_settings'  => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 100,
                ),
                'default'         => '50%',
                'fixed_unit'      => '%',
				'validate_unit'   => true,
				'depends_show_if' => 'on',
			),
			'color_motion_color_four_position'           => array(
                'label'           => esc_html__('Color Four Position', 'et_builder'),
                'type'            => 'range',                
				'option_category' => 'layout',
				'description'     => esc_html__( 'Content entered here will appear inside the module.', 'et_builder' ),
				'tab_slug'     	  => 'advanced',
				'toggle_slug'     => 'dnxt_color_motion_color',		
                'range_settings'  => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 100,
                ),
                'default'         => '90%',
                'fixed_unit'      => '%',
				'validate_unit'   => true,
				'depends_show_if' => 'on',
			),
		);
	}

	public function get_advanced_fields_config() {
		$advanced_fields = array();
		$advanced_fields['fonts'] = false;		
		$advanced_fields = array(
			'fonts'               		 => array(
				'dnxt_color_motion_fonts'=> array(
					'label'		  		 => esc_html__( '', 'et_builder' ),
					'toggle_slug' 		 => 'dnxt_text_font',
					'hide_text_color' 	 => true,
					'tab_slug'	  		 => 'advanced',
					'css'      	  		 => array(
						'main' => "%%order_class%% .dnxt-grdnt-text-animation_font",
						'text_align'  => "%%order_class%% .dnxt-grdnt-text-animation_font",
					),
					'font_size'   => array(
						'default' => '100px',
					),
				)
			),
			'text' => false,
		);
		return $advanced_fields;
	}

	public function render( $attrs, $content, $render_slug ) {

		$this->apply_css($render_slug);

		$headingTag  = $this->props['heading_tag'];
		$gradientAnimText = $this->props['text_color_motion'];
		$gradientAnimTextClass = $this->props['text_color_motion_style'];

		return sprintf( 
			'<div>
				<%1$s class="%2$s dnxt-grdnt-text-animation_font">
					%3$s
				</%1$s>
			</div>',
			$headingTag,
			$gradientAnimTextClass,
			$gradientAnimText
		);
	}

	public function apply_css($render_slug){		
		switch ($this->props['text_color_motion_style']) {
			case 'dnxt-grdnt-text-animation':
				// Gradient Animation Color
				if ('linear-gradient' === $this->props['color_motion_type']) {
					if (
						'' !== $this->props['color_motion_color_one'] ||
						'' !== $this->props['color_motion_color_two'] ||
						'' !== $this->props['color_motion_color_three'] ||
						'' !== $this->props['color_motion_color_four']
					) {
						
					ET_Builder_Element::set_style( $render_slug, array(
						'selector'    => '%%order_class%% .dnxt-grdnt-text-animation',
						'declaration' => "background: linear-gradient({$this->props['color_motion_type_linear_direction']},{$this->props['color_motion_color_one']} {$this->props['color_motion_color_one_position']},{$this->props['color_motion_color_two']} {$this->props['color_motion_color_two_position']},{$this->props['color_motion_color_three']} {$this->props['color_motion_color_three_position']},{$this->props['color_motion_color_four']} {$this->props['color_motion_color_four_position']});
										background-size: 300% 300%;
										color: transparent;
										background-clip: text;
										-webkit-background-clip: text;
										-webkit-text-fill-color: transparent;
										animation: dnxtgradient {$this->props['color_motion_text_duration']} ease-in-out infinite;
										-webkit-animation: dnxtgradient {$this->props['color_motion_text_duration']} ease-in-out infinite;",
					) );
						
			}
		}
		if ('radial-gradient' === $this->props['color_motion_type']) {
			if (
				'' !== $this->props['color_motion_color_one'] ||
				'' !== $this->props['color_motion_color_two'] ||
				'' !== $this->props['color_motion_color_three'] ||
				'' !== $this->props['color_motion_color_four']
			) {				
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => '%%order_class%% .dnxt-grdnt-text-animation',
				'declaration' => "background: radial-gradient({$this->props['color_motion_type_radial_direction']},{$this->props['color_motion_color_one']} {$this->props['color_motion_color_one_position']},{$this->props['color_motion_color_two']} {$this->props['color_motion_color_two_position']},{$this->props['color_motion_color_three']} {$this->props['color_motion_color_three_position']},{$this->props['color_motion_color_four']} {$this->props['color_motion_color_four_position']});
				 			background-size: 300% 300%;
				 			color: transparent;
				 			background-clip: text;
				 			-webkit-background-clip: text;
							 -webkit-text-fill-color: transparent;
							 animation: dnxtgradient {$this->props['color_motion_text_duration']} ease-in-out infinite;
							-webkit-animation: dnxtgradient {$this->props['color_motion_text_duration']} ease-in-out infinite;",
			) );				
	}
}				
				break;
			case 'dnxt-grdnt-text-animation-2':			

				if ('linear-gradient' === $this->props['color_motion_type']) {
					if (
						'' !== $this->props['color_motion_color_one'] ||
						'' !== $this->props['color_motion_color_two'] ||
						'' !== $this->props['color_motion_color_three'] ||
						'' !== $this->props['color_motion_color_four']
					) {						
					ET_Builder_Element::set_style( $render_slug, array(
						'selector'    => '%%order_class%% .dnxt-grdnt-text-animation-2',
						'declaration' => "background: linear-gradient({$this->props['color_motion_type_linear_direction']},{$this->props['color_motion_color_one']} {$this->props['color_motion_color_one_position']},{$this->props['color_motion_color_two']} {$this->props['color_motion_color_two_position']},{$this->props['color_motion_color_three']} {$this->props['color_motion_color_three_position']},{$this->props['color_motion_color_four']} {$this->props['color_motion_color_four_position']});
						color: transparent;
						background-size: 200% auto;
						background-clip: text;
						-webkit-background-clip: text;
						-webkit-text-fill-color: transparent;
						-webkit-animation: textclip {$this->props['color_motion_text_duration']} linear infinite;
 						 animation: textclip {$this->props['color_motion_text_duration']} linear infinite;",
					) );
						
			}
		}
		if ('radial-gradient' === $this->props['color_motion_type']) {
			if (
				'' !== $this->props['color_motion_color_one'] ||
				'' !== $this->props['color_motion_color_two'] ||
				'' !== $this->props['color_motion_color_three'] ||
				'' !== $this->props['color_motion_color_four']
			) {				
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => '%%order_class%% .dnxt-grdnt-text-animation-2',
				'declaration' => "background: radial-gradient({$this->props['color_motion_type_radial_direction']},{$this->props['color_motion_color_one']} {$this->props['color_motion_color_one_position']},{$this->props['color_motion_color_two']} {$this->props['color_motion_color_two_position']},{$this->props['color_motion_color_three']} {$this->props['color_motion_color_three_position']},{$this->props['color_motion_color_four']} {$this->props['color_motion_color_four_position']});
				color: transparent;
				background-size: 200% auto;
				background-clip: text;
				-webkit-background-clip: text;
				-webkit-text-fill-color: transparent;
				-webkit-animation: textclip {$this->props['color_motion_text_duration']} linear infinite;
				animation: textclip {$this->props['color_motion_text_duration']} linear infinite;",
			) );				
			}
			}				
				break;
			default:
			if (
				'' !== $this->props['color_motion_color_one'] ||
				'' !== $this->props['color_motion_color_two'] ||
				'' !== $this->props['color_motion_color_three'] ||
				'' !== $this->props['color_motion_color_four']
			) {
				
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => '%%order_class%% .dnxt-grdnt-text-animation',
				'declaration' => "background: linear-gradient({$this->props['color_motion_type_linear_direction']},{$this->props['color_motion_color_one']} {$this->props['color_motion_color_one_position']},{$this->props['color_motion_color_two']} {$this->props['color_motion_color_two_position']},{$this->props['color_motion_color_three']} {$this->props['color_motion_color_three_position']},{$this->props['color_motion_color_four']} {$this->props['color_motion_color_four_position']});
								background-size: 300% 300%;
								color: transparent;
								background-clip: text;
								-webkit-background-clip: text;
								-webkit-text-fill-color: transparent;
								animation: dnxtgradient {$this->props['color_motion_text_duration']} ease-in-out infinite;
								-webkit-animation: dnxtgradient {$this->props['color_motion_text_duration']} ease-in-out infinite;",
			) );
				
	}
				break;
		}
		
		
	}
}

new Next_Text_Color_Motion;
