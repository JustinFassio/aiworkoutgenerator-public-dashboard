<?php

class Next_Text_Stroke extends ET_Builder_Module {

	public $slug       = 'dnxte_text_stroke';
	public $vb_support = 'on';

	protected $module_credits = array(
		'module_uri' => 'https://www.diviessential.com/divi-text-stroke/',
		'author'     => 'Divi Next',
		'author_uri' => 'www.divinext.com',
	);

	public function init() {
		$this->name 		= esc_html__( 'Next Text Stroke', 'et_builder' );
		$this->icon_path    = plugin_dir_path( __FILE__ ) . 'icon.svg';
		$this->folder_name 	= 'et_pb_divi_essential';

        $this->settings_modal_toggles = array(
            'general'	=> array(
				'toggles'		=>	array(
				'dnxt_next_text_stroke_general' => esc_html__( 'Text', 'et_builder' ),
				),
            ),
            'advanced'	=> array(
                'toggles'	=>array(
                    // Stroke Settings:
                    'dnxt_text_stroke_settings' => array(
                        "title" =>	esc_html__( 'Stroke Settings', 'et_builder' ),
                        'priority'	=>	1,					
                    ),
                    // Hover Color for single and fill both
                    'dnxt_text_stroke_color' => array(
                        'title' =>	esc_html__( 'Stroke Hover Color', 'et_builder' ),
                        'priority'          => 2,					
                        'sub_toggles' => array(
                            'sub_toggle_color' => array(
                                'name' => esc_html__('Single', 'et_builder'),
                            ),
                            'sub_toggle_gradient' => array(
                                'name' => esc_html__('Gradient', 'et_builder')
                            ),
                        ),
                        'tabbed_subtoggles' => true,
                    ),
                    // default font settings
                    'dnxt_text_stroke_fonts' => array(
                        "title" =>	esc_html__( 'Fonts', 'et_builder' ),
                        'priority'	=>	3,						
                    ),
                ),
			),
		);
		// Custom CSS Field
        $this->custom_css_fields = array(
            'dnxt_text_stroke_wrapper' => array(
                'label'    => esc_html__('Text Stroke Wrapper', 'et_builder'),
                'selector' => '%%order_class%% .dnxt-text-stroke-fill-wrapper',
			),
			'dnxt_text_stroke_fill' => array(
                'label'    => esc_html__('Text Stroke Fill', 'et_builder'),
                'selector' => '%%order_class%% .dnxt-text-stroke-fill-main',
			),
        );
	}

    public function get_fields(){
        return array(
            // Title Field
			'dnxt_text_stroke_title'   => array(
				'label'           => esc_html__( 'Text to Stroke', 'et_builder' ),
                'type'            => 'text',
                'dynamic_content' => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Title entered here will appear with text stroke.', 'et_builder' ),
                'toggle_slug'     => 'dnxt_next_text_stroke_general',
			),
			// Heading Tag Option
			'dnxt_text_heading_tag'         => array(
                'label'           => esc_html__('Select Heading Tag', 'et_builder'),
                'type'            => 'select',
                'description'     => esc_html__('Select the heading tag, which you would like to use', 'et_builder'),
                'option_category' => 'basic_option',
                'toggle_slug'     => 'dnxt_next_text_stroke_general',
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
			// Stroke Color
			'dnxt_stroke_text_color'	=> array(
                'label'           		=> esc_html__(' Stroke Color', 'et_builder'),
				'type'            		=> 'color-alpha',
				'description'     		=> esc_html__( 'Adjust the color of the stroke applied to the text.','et_builder' ),				
				'tab_slug'	  	  		=> 'advanced',
				'toggle_slug'     		=> 'dnxt_text_stroke_settings',
                'default'         		=> '#0077FF',
			),
            // Stroke Width
			'dnxt_stroke_text_width'             => array(
                'label'           	=> esc_html__(' Stroke Width', 'et_builder'),
				'type'            	=> 'range',
				'description'     	=> esc_html__( 'Adjust the width of the stroke applied to the text.','et_builder' ),				
				'tab_slug'	  	  	=> 'advanced',
				'toggle_slug'     	=> 'dnxt_text_stroke_settings',
                'range_settings'  	=> array(
                    'step' 		=> 1,
                    'min'  		=> 1,
                    'max'  		=> 100,
                ),
                'default'         	=> '2px',
                'fixed_unit'      	=> 'px',
				'validate_unit'   	=> true,
			),
            // Select Hover Effect
			'dnxt_text_hover_effect_select' => array(
				'label'             => esc_html__( 'Select Hover Effect', 'et_builder' ),
				'type'              => 'select',
				'description'       => esc_html__( 'Here you can adjust the hover effect.' ),
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'dnxt_text_stroke_settings',
				'options'           => array(
                    'dnxt-text-fill-to-stroke'	  => esc_html__('Stroke to Fill Animation', 'et_builder'),
					'dnxt-text-stroke-to-fill'	  => esc_html__('Fill to Stroke Animation', 'et_builder'),
                    'dnxt-text-stroke-none'	  => esc_html__('None', 'et_builder'),
                ),
                'default'           => 'dnxt-text-fill-to-stroke'
				
            ),
            // Color Tab Single Switch
			'dnxt_single_text_color'  => array(
				'label'           => esc_html__( 'Single', 'et_builder'),
				'type'            => 'yes_no_button', 
				'tab_slug'	  	  => 'advanced',               				
				'toggle_slug'     => 'dnxt_text_stroke_color',
				'sub_toggle'	  => 'sub_toggle_color',
				'options'         => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'affects'         => array(
					'color_tab_single',
					'dnxt_text_select_hover_direction',
				),
				'default_on_front' => 'on',			
            ),
            // Single Color
			'color_tab_single'   	=> array(
				'label'          	=> esc_html__('Select Single Color', 'et_builder'),
				'type'           	=> 'color-alpha',
				'description'     	=> esc_html__( 'Content entered here will appear inside the module.', 'et_builder' ),				
				'tab_slug'	  	  	=> 'advanced',
				'toggle_slug'     	=> 'dnxt_text_stroke_color',
				'sub_toggle'	  	=> 'sub_toggle_color',
				'hover'    		 	=> 'tabs',
				'default'        	=> '#0077FF',
				'depends_show_if'	=> 'on',
            ),
            // Gradient Color tab Switch
			'dnxt_gradient_text_color'  => array(
				'label'           		=> esc_html__( 'Gradient', 'et_builder'),
				'type'            		=> 'yes_no_button',                
				'tab_slug'	  	  		=> 'advanced',
				'toggle_slug'     		=> 'dnxt_text_stroke_color',
				'sub_toggle'	  		=> 'sub_toggle_gradient',
				'options'             	=> array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'affects'         => array(
					'dnxt_color_tab_gradient_one',
					'dnxt_color_tab_gradient_two',
					'dnxt_gradient_type_text',
					'dnxt_gradient_type_linear_direction_text',
					'dnxt_gradient_type_radial_direction_text',
					'dnxt_gradient_start_position_text',
					'dnxt_gradient_end_position_text',
					'dnxt_text_select_hover_direction',

				),
				'default_on_front' => 'off',				
			),
			// Gradient Color One Select One
			'dnxt_color_tab_gradient_one' => array(
				'label'          	=> esc_html__('Select Color One', 'et_builder'),
				'type'           	=> 'color-alpha',
				'tab_slug'       	=> 'advanced',
				'description'     	=> esc_html__( 'Choose the first color to blend with the second color from the color picker that suits your title text.', 'et_builder' ),
				'toggle_slug'    	=> 'dnxt_text_stroke_color',
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
				'toggle_slug'    => 'dnxt_text_stroke_color',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'default'        => '#772ADB',
				'depends_show_if'=> 'on',
			),
			// Gradient type text
			'dnxt_gradient_type_text'  => array(
				'label'           => esc_html__('Select Gradient Type', 'et_builder'),
				'type'            => 'select',
				'description'     => esc_html__('Select a type of gradient for the Title Text.', 'et_builder'),
				'option_category' => 'basic_option',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dnxt_text_stroke_color',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'options'         => array(
					'linear-gradient' => esc_html__('Linear', 'et_builder'),
					'radial-gradient' => esc_html__('Radial', 'et_builder'),
				),
				'default'         => 'linear-gradient',
				'depends_show_if'=> 'on',
			),
			// Gradient Linear Type Direction
			'dnxt_gradient_type_linear_direction_text' => array(
				'label'           => esc_html__('Linear direction', 'et_builder'),
				'type'            => 'range',
				'tab_slug'        => 'advanced',
				'description'     => esc_html__( 'Adjust the direction of the gradient for the title text.', 'et_builder' ),
				'toggle_slug'     => 'dnxt_text_stroke_color',
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
					'dnxt_gradient_type_text'  => 'linear-gradient',
					'dnxt_gradient_text_color' => 'on',
				),
			),
			// Gradient Radial Type Selection
			'dnxt_gradient_type_radial_direction_text' => array(
				'label'           => esc_html__('Radial Direction', 'et_builder'),
				'type'            => 'select',
				'description'     => esc_html__( 'Adjust the direction of the gradient for the title text.', 'et_builder' ),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dnxt_text_stroke_color',
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
					'dnxt_gradient_type_text'  => 'radial-gradient',
					'dnxt_gradient_text_color' => 'on',
				),
			),
			// Gradient Start Position
			'dnxt_gradient_start_position_text' => array(
				'label'           => esc_html__('Start Position', 'et_builder'),
				'type'            => 'range',
				'description'     => esc_html__( 'Adjust the position for the beginning of the gradient color.', 'et_builder' ),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dnxt_text_stroke_color',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'range_settings'  => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 100,
				),
				'default'         => '0%',
				'fixed_unit'      => '%',
				'validate_unit'   => true,
				'depends_show_if'=> 'on',
			),
			// Gradient End Position
			'dnxt_gradient_end_position_text' => array(
				'label'           => esc_html__('End Position', 'et_builder'),
				'type'            => 'range',
				'description'     => esc_html__( 'Adjust the position for the ending of the gradient color.', 'et_builder' ),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dnxt_text_stroke_color',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'range_settings'  => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 100,
				),
				'default'         => '100%',
				'fixed_unit'      => '%',
				'validate_unit'   => true,
			),
			// Select Hover Direction
            'dnxt_text_select_hover_direction'           => array(
                'label'             => esc_html__( 'Select Hover Direction', 'et_builder' ),
                'type'              => 'select',
                'option_category'   => 'configuration',
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'dnxt_text_stroke_settings',
                'description'       => esc_html__( 'Here you can adjust the hover effect.' ),
                'options'           => array(
					'dnxt-hover-top-animation'    =>  esc_html__( 'Top Animation', 'et_builder' ),
					'dnxt-hover-right-animation'  =>  esc_html__( 'Right Animation', 'et_builder' ),
					'dnxt-hover-bottom-animation' =>  esc_html__( 'Bottom Animation', 'et_builder' ),
					'dnxt-hover-left-animation'   =>  esc_html__( 'Left Animation', 'et_builder' ),
					'dnxt-hover-angle-animation'  =>  esc_html__( 'Angle Animation', 'et_builder' ),
					'dnxt-hover-radial-animation' =>  esc_html__( 'Radial Animation', 'et_builder' ),
				),
				'show_if' => array(
					'dnxt_text_hover_effect_select' => 'dnxt-text-stroke-to-fill',
					'dnxt_text_hover_effect_select' => 'dnxt-text-fill-to-stroke',
				),
				'default'           => 'dnxt-hover-left-animation',
			),
			// Hover Motion Duration 
			'dnxt_hover_motion_duration' => array(
				'label'           => esc_html__('Hover Motion Duration', 'et_builder'),
				'type'            => 'range',
				'description'     => esc_html__( 'Adjust color two to the right of the text you have entered and see how it looks.', 'et_builder' ),
				'tab_slug'	  	  => 'advanced',
				'toggle_slug'     => 'dnxt_text_stroke_settings',
				'range_settings'  => array(
					'step' => 0.1,
					'min'  => 0.1,
					'max'  => 0.9,
				),
				'default'         => '0.9',
				'fixed_unit'      => 's',
				'validate_unit'   => true,
				'show_if' => array(
					'dnxt_text_hover_effect_select' => 'dnxt-text-fill-to-stroke',
				)               
			),
		);
    }

    public function get_advanced_fields_config() {
		$advanced_fields = array();

		$advanced_fields['fonts'] = false;			
		$advanced_fields = array(
			// change default Font settings
			'fonts'               => array(
				'dnxt_stroke_fonts' => array(
					'label'		  => esc_html__( '', 'et_builder' ),					
					'toggle_slug' => 'dnxt_text_stroke_fonts',
					'tab_slug'	  => 'advanced',
					'hide_text_color' => true,
					'css'      	  => array(
						'main' => "%%order_class%% .dnxt-text-stroke-fill-main",
					),
					'font_size'   => array(
						'default' => '100px',
					),
					'text_align' => array(
						'mobile_options'  => false,
					)
				)
			),
			// change default Spacing settings
			'margin_padding' => array(
				'css' => array(
					'main' => "%%order_class%% .dnxt-text-stroke-fill-main",
					'important' => 'all',
				),	
			),
			// change default Border settings
			'borders'    => array(
				'default' 	=> array(
					'css'             => array(
						'main' => array(
							'border_radii'        => '%%order_class%% .dnxt-text-stroke-fill-main',
							'border_radii_hover'  => '%%order_class%%:hover .dnxt-text-stroke-fill-main',
							'border_styles'       => '%%order_class%% .dnxt-text-stroke-fill-main',
							'border_styles_hover' => '%%order_class%%:hover .dnxt-text-stroke-fill-main',
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
			// change default Box_shadow settings
			'box_shadow'            => array(
				'default' => array(
					'css'                 => array(
						'main'        => '%%order_class%% .dnxt-text-stroke-fill-main',
						'hover'       => '%%order_class%%:hover .dnxt-text-stroke-fill-main',
						'overlay'     => 'inset',
					),
				),
			),		
			'text' => false,
		);
		
		return $advanced_fields;
	}

    public function render( $attrs, $content, $render_slug ){
		$headingTag  = $this->props['dnxt_text_heading_tag'];
		$this->apply_css($render_slug);

        $strokeFillNone 		= ""; // without hover
		$hoverDirection 		= "";
		$strokeToFill 			= ""; // with hover
		$dnxt_text_hover_effect = "";
		
		// set hover effects
        switch ($this->props['dnxt_text_hover_effect_select']) {
            // Fill to Stroke: 1
            case 'dnxt-text-fill-to-stroke': {
                $strokeFillNone = "";
                $strokeToFill 	= "";
                $hoverDirection = "dnxt-text-stroke-top";
                break;
            }
            // Stroke to Fill: 2
            case 'dnxt-text-stroke-to-fill': {
                $strokeFillNone = "";
                $strokeToFill 	= "dnxt-text-stroke-to-fill-hover";
                $hoverDirection = "";
                break;
            }
            // none: 3
            case 'dnxt-text-stroke-none': {
                $strokeFillNone = "dnxt-text-stroke-fill-without-hover";
                $hoverDirection = "";
                $strokeToFill 	= "";
                break;
            }
            default: {
                $hoverDirection = "dnxt-text-stroke-top";
                $strokeFillNone = "";
                $strokeToFill 	= "";
                break;
            }
		}
		// set hover directions
		switch ($this->props['dnxt_text_select_hover_direction']) {
            case 'dnxt-hover-top-animation': {
                $hoverDirection = "dnxt-text-stroke-top";
                break;
            }
            case 'dnxt-hover-right-animation': {
                $hoverDirection = "dnxt-text-stroke-right";
                break;
            }
            case 'dnxt-hover-bottom-animation': {
                $hoverDirection = "dnxt-text-stroke-bottom";
                break;
            }
            case 'dnxt-hover-left-animation': {
                $hoverDirection = "dnxt-text-stroke-left";
                break;
            }
            case 'dnxt-hover-angle-animation': {
                $hoverDirection = "dnxt-text-stroke-angle";
                break;
            }
            case 'dnxt-hover-radial-animation': {
                $hoverDirection = "dnxt-text-stroke-radial";
                break;
            }
            default: {
                $hoverDirection = "dnxt-text-stroke-top";
                break;
            }
		}
		
		// selecting dynamic class
		$dnxt_text_hover_effect = 'dnxt-text-stroke-none' === $this->props['dnxt_text_hover_effect_select'] ? $strokeFillNone : ('dnxt-text-stroke-to-fill' === $this->props['dnxt_text_hover_effect_select'] ? $strokeToFill : $hoverDirection);

		return sprintf(
			'<div class="dnxt-text-stroke-fill-wrapper">
				<%1$s class="dnxt-text-stroke-fill-main %3$s">
				%2$s</%1$s>
			</div>',
            $headingTag,
			$this->props['dnxt_text_stroke_title'],
			$dnxt_text_hover_effect
        );
	}
	
	public function apply_css($render_slug) {
		// define radial gradient direcion text
		$gradient_radial_direction_text = "";

		// Apply radial gradient direcion text
        if ("" !== $this->props['dnxt_gradient_type_radial_direction_text']) {
            $gradient_radial_direction_text = "{$this->props['dnxt_gradient_type_radial_direction_text']}";
        }

		// Hover from Fill to Stroke: 1
        if ('dnxt-text-fill-to-stroke' === $this->props['dnxt_text_hover_effect_select'] &&
            'dnxt-text-stroke-to-fill' !== $this->props['dnxt_text_hover_effect_select'] &&
            'dnxt-text-stroke-none' !== $this->props ['dnxt_text_hover_effect_select']
        ) {
			// stroke width, color and motion duration
			ET_Builder_Element::set_style($render_slug, array(
				"selector" => "%%order_class%% .dnxt-text-stroke-fill-main",
				"declaration" => "
					-webkit-text-stroke-width: {$this->props['dnxt_stroke_text_width']};
					-webkit-text-stroke-color: {$this->props['dnxt_stroke_text_color']};
					transition: {$this->props['dnxt_hover_motion_duration']};
				"
			));
			// Hover Motion duration
            $hoverMotionDuration = '';
            if ("" !== $this->props['dnxt_single_text_color']) {
                $hoverMotionDuration = $this->props['dnxt_single_text_color'];
            }

			// if gradient switch is 'on'
			if (('off' === $this->props['dnxt_single_text_color']) &&
				('on' === $this->props['dnxt_gradient_text_color'])){
				// if there's something on gradient one or two
                if (('' !== $this->props['dnxt_color_tab_gradient_one']) || 
                    ('' !== $this->props['dnxt_color_tab_gradient_two'])){
					// for linear gradient
					if (('linear-gradient' === $this->props['dnxt_gradient_type_text']) || 'radial-gradient' === $this->props['dnxt_gradient_type_text']){
						ET_Builder_Element::set_style($render_slug, array(
							"selector"    => "%%order_class%% .dnxt-text-stroke-fill-main",
							"declaration" => "
								transition: background-size {$hoverMotionDuration} cubic-bezier(0.67, 0.01, 0.15, 0.98);
							"
						));
						
					}

					// WITH HOVER: (from Fill to Stroke)
					// for top-animation-hover
					if ('dnxt-hover-top-animation' === $this->props['dnxt_text_select_hover_direction']){
						if ('linear-gradient' === $this->props['dnxt_gradient_type_text']){
							ET_Builder_Element::set_style($render_slug, array(
								"selector" => "%%order_class%% .dnxt-text-stroke-top",
								"declaration" => "
									background-image: linear-gradient(
										{$this->props['dnxt_gradient_type_linear_direction_text']},
										{$this->props['dnxt_color_tab_gradient_one']} 
										{$this->props['dnxt_gradient_start_position_text']},
										{$this->props['dnxt_color_tab_gradient_two']} 
										{$this->props['dnxt_gradient_end_position_text']});
								"
							));
						}
						if ('radial-gradient' === $this->props['dnxt_gradient_type_text']){
							ET_Builder_Element::set_style($render_slug, array(
								"selector" => "%%order_class%% .dnxt-text-stroke-top",
								"declaration" => "background-image: radial-gradient(circle at 
								{$gradient_radial_direction_text},
								{$this->props['dnxt_color_tab_gradient_one']} 
								{$this->props['dnxt_gradient_start_position_text']}, 
								{$this->props['dnxt_color_tab_gradient_two']} 
								{$this->props['dnxt_gradient_end_position_text']},
								transparent 50.1%);"
							));
						}
					}
					// for right-animation-hover:
					if ('dnxt-hover-right-animation' === $this->props['dnxt_text_select_hover_direction']){
						if ('linear-gradient' === $this->props['dnxt_gradient_type_text']){
							ET_Builder_Element::set_style($render_slug, array(
								"selector"    => "%%order_class%% .dnxt-text-stroke-right",
								"declaration" => "
									background-image: linear-gradient(
										{$this->props['dnxt_gradient_type_linear_direction_text']},
										{$this->props['dnxt_color_tab_gradient_one']} 
										{$this->props['dnxt_gradient_start_position_text']},
										{$this->props['dnxt_color_tab_gradient_two']} 
										{$this->props['dnxt_gradient_end_position_text']});
								"
							));
						}
						if ('radial-gradient' === $this->props['dnxt_gradient_type_text']){
							ET_Builder_Element::set_style($render_slug, array(
								"selector" => "%%order_class%% .dnxt-text-stroke-right",
								"declaration" => "background-image: radial-gradient(circle at 
								{$gradient_radial_direction_text},
								{$this->props['dnxt_color_tab_gradient_one']} 
								{$this->props['dnxt_gradient_start_position_text']}, 
								{$this->props['dnxt_color_tab_gradient_two']} 
								{$this->props['dnxt_gradient_end_position_text']},
								transparent 50.1%);"
							));
						}
					}
					// for bottom-animation-hover
                    if ('dnxt-hover-bottom-animation' === $this->props['dnxt_text_select_hover_direction']){
						if ('linear-gradient' === $this->props['dnxt_gradient_type_text']){
							ET_Builder_Element::set_style($render_slug, array(
								"selector"    => "%%order_class%% .dnxt-text-stroke-bottom",
								"declaration" => "
									background-image: linear-gradient(
													{$this->props['dnxt_gradient_type_linear_direction_text']},
													{$this->props['dnxt_color_tab_gradient_one']} 
													{$this->props['dnxt_gradient_start_position_text']},
													{$this->props['dnxt_color_tab_gradient_two']} 
													{$this->props['dnxt_gradient_end_position_text']});
								"
							));
						}
						if ('radial-gradient' === $this->props['dnxt_gradient_type_text']){
							ET_Builder_Element::set_style($render_slug, array(
								"selector" => "%%order_class%% .dnxt-text-stroke-bottom",
								"declaration" => "background-image: radial-gradient(circle at 
								{$gradient_radial_direction_text},
								{$this->props['dnxt_color_tab_gradient_one']} 
								{$this->props['dnxt_gradient_start_position_text']}, 
								{$this->props['dnxt_color_tab_gradient_two']} 
								{$this->props['dnxt_gradient_end_position_text']},
								transparent 50.1%);"
							));
						}
					}
					// for left-animation-hover
                    if ('dnxt-hover-left-animation' === $this->props['dnxt_text_select_hover_direction']){
						if ('linear-gradient' === $this->props['dnxt_gradient_type_text']){
							ET_Builder_Element::set_style($render_slug, array(
								"selector"    => "%%order_class%% .dnxt-text-stroke-left",
								"declaration" => "
									background-image: linear-gradient(
										{$this->props['dnxt_gradient_type_linear_direction_text']}, 
										{$this->props['dnxt_color_tab_gradient_one']} 
										{$this->props['dnxt_gradient_start_position_text']}, 
										{$this->props['dnxt_color_tab_gradient_two']} 
										{$this->props['dnxt_gradient_end_position_text']}, transparent 50.1%);
								"
							));
						}
						if ('radial-gradient' === $this->props['dnxt_gradient_type_text']){
							ET_Builder_Element::set_style($render_slug, array(
								"selector" => "%%order_class%% .dnxt-text-stroke-left",
								"declaration" => "background-image: radial-gradient(circle at 
								{$gradient_radial_direction_text},
								{$this->props['dnxt_color_tab_gradient_one']} 
								{$this->props['dnxt_gradient_start_position_text']}, 
								{$this->props['dnxt_color_tab_gradient_two']} 
								{$this->props['dnxt_gradient_end_position_text']},
								transparent 50.1%);"
							));
						}
					}
					//for angle animation
                    if ('dnxt-hover-angle-animation' === $this->props['dnxt_text_select_hover_direction']){
						// without hover
						ET_Builder_Element::set_style($render_slug, array(
							"selector"    => "%%order_class%% .dnxt-text-stroke-angle",
							"declaration" => "
								background-image: linear-gradient(135deg, 
								{$this->props['dnxt_color_tab_gradient_one']} 0%, 
								{$this->props['dnxt_color_tab_gradient_two']} 50%, transparent 50.1%);
							"
						));
					}
					// for radial-hover
                    if ('dnxt-hover-radial-animation' === $this->props['dnxt_text_select_hover_direction']){
						// without hover
						ET_Builder_Element::set_style($render_slug, array(
							"selector"    => "%%order_class%% .dnxt-text-stroke-radial",
							"declaration" => "
								background-image:
								radial-gradient(circle farthest-corner at center center,
									{$this->props['dnxt_color_tab_gradient_one']} 
									{$this->props['dnxt_gradient_start_position_text']}, 
									{$this->props['dnxt_color_tab_gradient_two']} 
									{$this->props['dnxt_gradient_end_position_text']},
										transparent 50.1%);
							"
						));
					}
				}
			}
			// if Single switch is on
            if (('on' === $this->props['dnxt_single_text_color']) || ('off' === $this->props['dnxt_gradient_text_color'])){
				if ('' !== $this->props['color_tab_single']){
					ET_Builder_Element::set_style($render_slug, array(
						"selector"    => "%%order_class%% .dnxt-text-stroke-fill-main",
						"declaration" => "
							transition: background-size {$this->props['dnxt_hover_motion_duration']} cubic-bezier(0.67, 0.01, 0.15, 0.98);
						"
					));
					// WITH HOVER: (from Fill to Stroke)
                    // for top-animation-hover
                    if ('dnxt-hover-top-animation' === $this->props['dnxt_text_select_hover_direction']){
						// without hover
						ET_Builder_Element::set_style($render_slug, array(
							"selector"    => "%%order_class%% .dnxt-text-stroke-top",
							"declaration" => "
								background-image: linear-gradient(180deg, 
									{$this->props['color_tab_single']} 0%, 
									{$this->props['color_tab_single']} 50%, transparent 50.1%);
							"
						));
					}
					// for right-animation-hover:
					if ('dnxt-hover-right-animation' === $this->props['dnxt_text_select_hover_direction']){
						// without hover
						ET_Builder_Element::set_style($render_slug, array(
							"selector"    => "%%order_class%% .dnxt-text-stroke-right",
							"declaration" => "
								background-image: linear-gradient({$this->props['color_tab_single']}, {$this->props['color_tab_single']});
							"
						));
					}
					// for bottom-animation-hover
                    if ('dnxt-hover-bottom-animation' === $this->props['dnxt_text_select_hover_direction']){
						// without hover
						ET_Builder_Element::set_style($render_slug, array(
							"selector"    => "%%order_class%% .dnxt-text-stroke-bottom",
							"declaration" => "
								background-image: linear-gradient(
									{$this->props['color_tab_single']}, 
									{$this->props['color_tab_single']});
							"
						));
					}
					// for left-animation-hover
                    if ('dnxt-hover-left-animation' === $this->props['dnxt_text_select_hover_direction']) {
						// without hover
						ET_Builder_Element::set_style($render_slug, array(
							"selector"    => "%%order_class%% .dnxt-text-stroke-left",
							"declaration" => "
								background-image: linear-gradient(
									{$this->props['color_tab_single']}, 
									{$this->props['color_tab_single']});
							"
						));
					}
					//for angle animation
                    if ('dnxt-hover-angle-animation' === $this->props['dnxt_text_select_hover_direction']) {
						// without hover
						ET_Builder_Element::set_style($render_slug, array(
							"selector"    => "%%order_class%% .dnxt-text-stroke-angle",
							"declaration" => "
								background-image: linear-gradient(135deg, {$this->props['color_tab_single']} 0%, {$this->props['color_tab_single']} 50%, transparent 50.1%);
							"
						));
					}
					// for radial-hover
                    if ('dnxt-hover-radial-animation' === $this->props['dnxt_text_select_hover_direction']) {
						// without hover
						ET_Builder_Element::set_style($render_slug, array(
							"selector"    => "%%order_class%% .dnxt-text-stroke-radial",
							"declaration" => "background-image: radial-gradient(circle at center center,
									{$this->props['color_tab_single']} 0%, 
									{$this->props['color_tab_single']} 40%, transparent 50.1%);
							"
						));
					}
				}
			}
		}

		// Hover from Fill to Stroke: 2
		if (('dnxt-text-stroke-to-fill' === $this->props['dnxt_text_hover_effect_select']) &&
            ('dnxt-text-fill-to-stroke' !== $this->props['dnxt_text_hover_effect_select'])
        ) {
			// Stroke Width:
			ET_Builder_Element::set_style($render_slug, array(
				"selector"    => "%%order_class%% .dnxt-text-stroke-fill-main",
                "declaration" => "-webkit-text-stroke-width: {$this->props['dnxt_stroke_text_width']};"
			));
			// Stroke Color:
			ET_Builder_Element::set_style($render_slug, array(
				"selector"    => "%%order_class%% .dnxt-text-stroke-fill-main:hover",
                "declaration" => "-webkit-text-stroke-color: {$this->props['dnxt_stroke_text_color']};"
			));

			// if gradient switch is 'on':
			if ('off' === $this->props['dnxt_single_text_color'] && 
				'on' === $this->props['dnxt_gradient_text_color']) {
				// hover effect:
				ET_Builder_Element::set_style($render_slug, array(
					"selector"    => "%%order_class%% .dnxt-text-stroke-to-fill-hover",
					"declaration" => "-webkit-background-clip: text;
						background-position: 100% 0%;
						-webkit-text-fill-color: transparent;"
				));
				ET_Builder_Element::set_style($render_slug, array(
						"selector"    => "%%order_class%% .dnxt-text-stroke-to-fill-hover:hover",
						"declaration" => "background: transparent;
                        -webkit-text-stroke-color: {$this->props['dnxt_stroke_text_color']};
                        background-size: 100% 200%;"
				));
				
				// if there's something on gradient one or two:
				if (('' !== $this->props['dnxt_color_tab_gradient_one']) || 
					('' !== $this->props['dnxt_color_tab_gradient_two']) || 
                    ('' !== $this->props['dnxt_gradient_start_position_text']) ||
                    ('' !== $this->props['dnxt_gradient_end_position_text'])) {
					// for linear gradient:
					if ('linear-gradient' === $this->props['dnxt_gradient_type_text']){
						ET_Builder_Element::set_style($render_slug, array(
							"selector"    => "%%order_class%% .dnxt-text-stroke-fill-main",
							"declaration" => "
								background: linear-gradient(
									{$this->props['dnxt_gradient_type_linear_direction_text']},
									{$this->props['dnxt_color_tab_gradient_one']} 
									{$this->props['dnxt_gradient_start_position_text']},
									{$this->props['dnxt_color_tab_gradient_two']} 
									{$this->props['dnxt_gradient_end_position_text']});
								-webkit-text-stroke-color: transparent;
								-webkit-text-fill-color: transparent;
								transition: background-size {$this->props['dnxt_hover_motion_duration']} cubic-bezier(0.67, 0.01, 0.15, 0.98);
							"
						));
					}
					// for radial gradient:
					if ('radial-gradient' === $this->props['dnxt_gradient_type_text']){
						ET_Builder_Element::set_style($render_slug, array(
							"selector" => '%%order_class%% .dnxt-text-stroke-fill-main',
							"declaration" => "
								background: radial-gradient(circle at 
									{$gradient_radial_direction_text}, 
									{$this->props['dnxt_color_tab_gradient_one']} 
									{$this->props['dnxt_gradient_start_position_text']}, 
									{$this->props['dnxt_color_tab_gradient_two']} 
									{$this->props['dnxt_gradient_end_position_text']},
									transparent 50.1%);
								-webkit-text-stroke-color: transparent;
								transition: background-size {$this->props['dnxt_hover_motion_duration']} cubic-bezier(0.67, 0.01, 0.15, 0.98);
							"
						));
					}
				}
			}

			// if Single switch is on
			if (('on' === $this->props['dnxt_single_text_color']) && 
			('off' === $this->props['dnxt_gradient_text_color'])) {
				if ('' !== $this->props['color_tab_single']) {
					ET_Builder_Element::set_style($render_slug, array(
							"selector" 	  => "%%order_class%% .dnxt-text-stroke-fill-main",
							"declaration" => "
								-webkit-text-fill-color: {$this->props['color_tab_single']};
								transition: {$this->props['dnxt_hover_motion_duration']};
								",
					));
					ET_Builder_Element::set_style($render_slug, array(
						"selector" 	  => "%%order_class%% .dnxt-text-stroke-to-fill-hover",
						"declaration" => "
							-webkit-background-clip: text;
							background-position: 100% 0%;
							color: {$this->props['color_tab_single']};
							-webkit-text-stroke: {$this->props['dnxt_stroke_text_width']};
							-webkit-text-fill-color: {$this->props['color_tab_single']};
							",
					));
					ET_Builder_Element::set_style($render_slug, array(
						"selector" 	  => "%%order_class%% .dnxt-text-stroke-to-fill-hover:hover",
						"declaration" => "
							-webkit-text-fill-color: transparent;
							background-size: 100% 200%;
							",
					));
				}
			}
		}

		// No hover Effect: 3
        if (('dnxt-text-stroke-none' === $this->props['dnxt_text_hover_effect_select']) && 
            ('dnxt-text-stroke-to-fill' !== $this->props['dnxt_text_hover_effect_select']) && 
            ('dnxt-text-fill-to-stroke' !== $this->props['dnxt_text_hover_effect_select'])){
				// stroke width
				ET_Builder_Element::set_style($render_slug, array(
					"selector"    => "%%order_class%% .dnxt-text-stroke-fill-main",
					"declaration" => "-webkit-text-stroke-width: {$this->props['dnxt_stroke_text_width']};"
				));
				// if gradient switch is 'on'
				if (('off' === $this->props['dnxt_single_text_color']) && 
                ('on' === $this->props['dnxt_gradient_text_color'])){
					// if there's something on gradient one or two
					if (('' !== $this->props['dnxt_color_tab_gradient_one']) || 
                    ('' !== $this->props['dnxt_color_tab_gradient_two'])) {
						// for linear gradient
						if ('linear-gradient' === $this->props['dnxt_gradient_type_text']){
							ET_Builder_Element::set_style($render_slug, array(
								"selector"    => "%%order_class%% .dnxt-text-stroke-fill-without-hover",
                                "declaration" => "
                                    cursor: pointer;
									background: -webkit-linear-gradient(180deg, 
										{$this->props['dnxt_color_tab_gradient_one']} 0%, 
										{$this->props['dnxt_color_tab_gradient_two']} 100%);
                                    -webkit-background-clip: text;
                                    -webkit-text-stroke-color: transparent;
                                    -webkit-text-fill-color: #fff;
                                "
							));
						}
						//for radial gradient (from Fill to Stroke)
						if ('radial-gradient' === $this->props['dnxt_gradient_type_text']){
							ET_Builder_Element::set_style($render_slug, array(
								"selector"    => "%%order_class%% .dnxt-text-stroke-fill-main",
                                "declaration" => "
								background: radial-gradient(circle at 
									{$gradient_radial_direction_text}, 
									{$this->props['dnxt_color_tab_gradient_one']} 
									{$this->props['dnxt_gradient_start_position_text']}, 
									{$this->props['dnxt_color_tab_gradient_two']} 
									{$this->props['dnxt_gradient_end_position_text']},
									transparent 50.1%);
									-webkit-text-fill-color: transparent;
                                    -webkit-background-clip: text;
                                    -webkit-text-fill-color: #fff;
								"
							));
						}
					}
				}
				// if Single switch is on
				if ($this->props['dnxt_single_text_color'] === 'on' || $this->props['dnxt_gradient_text_color'] === 'off') {
					if ($this->props['color_tab_single'] !== '') {
						ET_Builder_Element::set_style($render_slug, array(
							"selector" => "%%order_class%% .dnxt-text-stroke-fill-main",
							"declaration" => "-webkit-text-stroke-color: {$this->props['color_tab_single']};"
						));
						
					};
				};
		}

		// Text Alignment: left
		if ('left' === $this->props['dnxt_stroke_fonts_text_align']) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'   => "%%order_class%% .dnxt-text-stroke-fill-wrapper",
				'declaration'=>	"text-align: {$this->props['dnxt_stroke_fonts_text_align']} !important;"
			));
		}
		// Text Alignment: center
		if ('center' === $this->props['dnxt_stroke_fonts_text_align']) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'   => "%%order_class%% .dnxt-text-stroke-fill-wrapper",
				'declaration'=>	"text-align: {$this->props['dnxt_stroke_fonts_text_align']} !important;"
			));
		}
		// Text Alignment: right
		if ('right' === $this->props['dnxt_stroke_fonts_text_align']) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'   => "%%order_class%% .dnxt-text-stroke-fill-wrapper",
				'declaration'=>	"text-align: {$this->props['dnxt_stroke_fonts_text_align']} !important;"
			));
		}
		// Text Alignment: justify
		if ('justify' === $this->props['dnxt_stroke_fonts_text_align']) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'   => "%%order_class%% .dnxt-text-stroke-fill-wrapper",
				'declaration'=>	"text-align: {$this->props['dnxt_stroke_fonts_text_align']} !important;"
			));
		}
	}
}

new Next_Text_Stroke;
