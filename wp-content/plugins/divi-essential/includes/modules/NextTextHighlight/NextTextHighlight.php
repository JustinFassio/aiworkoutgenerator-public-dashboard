<?php

class Next_Text_Highlight extends ET_Builder_Module {

	public $slug       = 'dnxte_text_highlight';
	public $vb_support = 'on';

	protected $module_credits = array(
		'module_uri' => 'https://www.diviessential.com/divi-text-highlight/',
		'author'     => 'Divi Next',
		'author_uri' => 'www.divinext.com',
	);

	public function init() {
		$this->name 		= esc_html__( 'Next Text Highlight', 'et_builder' );
		$this->icon_path    = plugin_dir_path( __FILE__ ) . 'icon.svg';
		$this->folder_name 	= 'et_pb_divi_essential';

		$this->settings_modal_toggles = array(
			'general'	=> array(
				'toggles'		=>	array(
					'dnxt_highlight_text'	=> esc_html__( 'Text', 'et_builder' ),
				),
			),
			'advanced'	=> array(
				'toggles'		=>	array(
					//Highlight color
					'dnxt_highlight_stroke_toggle'	=>	array(
						'title'		=>	esc_html__( 'Highlight', 'et_builder' ),
						'priority'	=>	1,
					),
					// Highlight font
					'dnxt_highlight_toggle' => array(
						'title'             => esc_html__('Fonts', 'et_builder'),
						'priority'          => 2,
						'sub_toggles'       => array(
							'sub_toogle_heading_font'   => array(
								'name' => 'Heading Text',
							),
							'sub_toogle_highlight_font'   => array(
								'name' => 'Highlight Text',
							),
						),
						'tabbed_subtoggles' => true,			
					),
					// Hover Effect
					'dnxt_text_hover_effect'=> array(
						'title'             => esc_html__('Hover Effect', 'et_builder'),
						'priority'          => 4,
					),
					// Text Alignment
					'dnxt_text_alignment'=> array(
						'title'             => esc_html__('Text Alignment', 'et_builder'),
						'priority'          => 5,
					),
				),
			),
		);

        // Custom CSS Field
        $this->custom_css_fields = array(
            'before_css' => array(
                'label'    => esc_html__('Before Text', 'et_builder'),
                'selector' => '%%order_class%% .dnxt-highlight-Btext',
            ),
            'highlight_css'  => array(
                'label'    => esc_html__('Highlight Text', 'et_builder'),
                'selector' => '%%order_class%% .dnxt-text-highlight',
            ),  
            'after_css'  => array(
                'label'    => esc_html__('After Text', 'et_builder'),
                'selector' => '%%order_class%% .dnxt-highlight-Atext',
            ),
        );
	}

	public function get_fields() {
		return array(
            // Before Text Field
			'before_text'     	  => array(
				'label'           => esc_html__( 'Before Text', 'et_builder' ),
				'type'            => 'text',
				'dynamic_content' => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Before Text entered here will appear inside the module.', 'et_builder' ),
                'toggle_slug'     => 'dnxt_highlight_text',
			),
			// Highlight Text
			'highlight_text'      => array(
				'label'           => esc_html__( 'Highlight Text', 'et_builder' ),
				'type'            => 'text',
				'dynamic_content' => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Hightlight Text entered here will appear inside the module.', 'et_builder' ),
				'toggle_slug'     => 'dnxt_highlight_text',
				
			),
			// After Text Field
			'after_text'      => array(
				'label'           => esc_html__( 'After Text', 'et_builder' ),
				'type'            => 'text',
				'dynamic_content' => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'After Text entered here will appear inside the module.', 'et_builder' ),
				'toggle_slug'     => 'dnxt_highlight_text',
			),
			// Heading Tag Option
			'heading_tag'         => array(
				'label'           => esc_html__('Select Heading Tag', 'et_builder'),
				'type'            => 'select',
				'description'     => esc_html__('Select the heading tag, which you would like to use', 'et_builder'),
				'option_category' => 'basic_option',
				'toggle_slug'     => 'dnxt_highlight_text',
				'default'         => 'h2',
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
			),
			'highlight_alignment' => array(
                'label'           => esc_html__('Text Alignment', 'et_builder'),
                'description'     => esc_html__('Align social item to the left, right or center.', 'et_builder'),
                'type'            => 'align',
                'option_category' => 'layout',
                'options'         => et_builder_get_text_orientation_options(array('justified')),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'dnxt_text_alignment',
                'mobile_options'  => true,
            ),
			// Highlight Color
			'stroke_color'       => array(
				'label'          => esc_html__('Select Color', 'et_builder'),
				'type'           => 'color-alpha',
				'description'     => esc_html__( 'Select a suitable color to use as highlight for the text.', 'et_builder' ),
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'dnxt_highlight_stroke_toggle',
				'default'        => '#0077FF',
				'hover'			 => 'tabs',
				'mobile_options' => true,
				'responsive'	 => true,
			),
			// Highlight Width
			'stroke_width'		=> array(
				'label'         => esc_html__('Stroke Width', 'et_builder'),
				'type'			=> 'range',
				'description'     => esc_html__( 'Adjust the width of the stroke added for the highlighted text.', 'et_builder' ),
				'tab_slug'		=> 'advanced',
				'toggle_slug'	=> 'dnxt_highlight_stroke_toggle',
				'default'		=> '9px',
				'mobile_options'=>	true,
				'responsive'	=>	true,
				'hover'			=>	'tabs',
				'range_settings'  => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
				),
				'fixed_unit'      => 'px',
				'validate_unit'   => true,
			),
			// Animation Delay
			'highlight_animation_delay'           => array(
				'label'           => esc_html__( 'Animation Delay', 'et_builder' ),
				'type'            => 'range',
				'tab_slug'            => 'advanced',
				'toggle_slug'         => 'dnxt_highlight_stroke_toggle',
				'range_settings'  => array(
					'min'  => 0,
					'max'  => 3000,
					'step' => 50,
				),
				'default'             => '1000ms',
				'description'         => esc_html__( 'If you would like to add a delay before your animation runs you can designate that delay here in milliseconds. This can be useful when using multiple animated modules together.' ),
				'validate_unit'       => true,
				'fixed_unit'          => 'ms',
				'fixed_range'         => true,
				'reset_animation'     => true,
				'mobile_options'      => true,
			),
			// Select SVG
			'dnxt_svg_select'           => array(
				'label'             => esc_html__( 'Select Highlight Style', 'et_builder' ),
				'type'              => 'select',
				'option_category'   => 'basic_option',
				'toggle_slug'       => 'dnxt_highlight_text',
				'default'           => 'underline',
				'description'       => esc_html__( 'Here you can adjust the hover effect.' ),
				'options'           => array(
					'underline'     => esc_html__( 'Underline', 'et_builder' ),
					'curly-line'    => esc_html__( 'Curly Line', 'et_builder' ),
					'delete'        => esc_html__( 'Delete', 'et_builder' ),
					'circle'        => esc_html__( 'Circle', 'et_builder' ),
					'diagonal'      => esc_html__( 'Diagonal', 'et_builder' ),
					'double'      	=> esc_html__( 'Double', 'et_builder' ),
					'double'      	=> esc_html__( 'Double', 'et_builder' ),
					'double-line'   => esc_html__( 'Double Line', 'et_builder' ),
					'strikethrough' => esc_html__( 'Strikethrough', 'et_builder' ),
					'zigzag' 		=> esc_html__( 'Zigzag', 'et_builder' ),
					'wave' 			=> esc_html__( 'Wave', 'et_builder' ),
					'spiral' 		=> esc_html__( 'Spiral', 'et_builder' ),
					'brush' 		=> esc_html__( 'Brush', 'et_builder' ),
					'splash' 		=> esc_html__( 'Splash', 'et_builder' ),
					'brick-wall' 	=> esc_html__( 'Brick Wall', 'et_builder' )
				),				
			),
			// Text Hover Switch
			'dnxt_text_hover_effect_switch' => array(
				'label'           => esc_html__('Text Hover Effect', 'et_builder'),
				'type'            => 'yes_no_button',                
				'description'     => esc_html__('Select if you would like to use text hover effect', 'et_builder'),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dnxt_text_hover_effect',
				'options'         => array(
						'off'     => esc_html__('Off', 'et_builder'),
						'on'      => esc_html__('On', 'et_builder'),
				),
				'default'         => 'off',
				
			),
			// Select Hover Effect
			'dnxt_text_hover_effect_select'           => array(
				'label'             => esc_html__( 'Select Hover Effect', 'et_builder' ),
				'type'              => 'select',
				'option_category'   => 'configuration',
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'dnxt_text_hover_effect',
				'default'           => 'dnxt-hover-grow',
				'description'       => esc_html__( 'Here you can adjust the hover effect.' ),
				'options'           => array(
					'dnxt-hover-backward'               =>  esc_html__( 'Backward', 'et_builder' ),
					'dnxt-hover-bob'                    =>  esc_html__( 'Bob', 'et_builder' ),
					'dnxt-hover-bounce-in'              =>  esc_html__( 'Bounce In', 'et_builder' ),
					'dnxt-hover-bounce-out'             =>  esc_html__( 'Bounce Out', 'et_builder' ),
					'dnxt-hover-buzz'                   =>  esc_html__( 'Buzz', 'et_builder' ),
					'dnxt-hover-buzz-out'               =>  esc_html__( 'Buzz Out', 'et_builder' ),
					'dnxt-hover-float'                  =>  esc_html__( 'Float', 'et_builder' ),
					'dnxt-hover-forward'                =>  esc_html__( 'Forward', 'et_builder' ),
					'dnxt-hover-grow'                   =>  esc_html__( 'Grow', 'et_builder' ),
					'dnxt-hover-grow-rotate'            =>  esc_html__( 'Grow Rotate', 'et_builder' ),
					'dnxt-hover-hang'                   =>  esc_html__( 'Hang', 'et_builder' ),
					'dnxt-hover-pop'                    =>  esc_html__( 'Pop', 'et_builder' ),
					'dnxt-hover-pulse'                  =>  esc_html__( 'Pulse', 'et_builder' ),
					'dnxt-hover-pulse-grow'             =>  esc_html__( 'Pulse Grow', 'et_builder' ),
					'dnxt-hover-pulse-shrink'           =>  esc_html__( 'Pulse Shrink', 'et_builder' ),
					'dnxt-hover-push'                   =>  esc_html__( 'Push', 'et_builder' ),
					'dnxt-hover-rotate'                 =>  esc_html__( 'Rotate', 'et_builder' ),
					'dnxt-hover-shrink'                 =>  esc_html__( 'Shrink', 'et_builder' ),
					'dnxt-hover-sink'                   =>  esc_html__( 'Sink', 'et_builder' ),
					'dnxt-hover-skew'                   =>  esc_html__( 'Skew', 'et_builder' ),
					'dnxt-hover-skew-backward'          =>  esc_html__( 'Skew Backward', 'et_builder' ),
					'dnxt-hover-skew-forward'           =>  esc_html__( 'Skew Forward', 'et_builder' ),
					'dnxt-hover-wobble-bottom'          =>  esc_html__( 'Wobble Bottom', 'et_builder' ),
					'dnxt-hover-wobble-horizontal'      =>  esc_html__( 'Wobble Horizontal', 'et_builder' ),
					'dnxt-hover-wobble-skew'            =>  esc_html__( 'Wobble Skew', 'et_builder' ),
					'dnxt-hover-wobble-top'             =>  esc_html__( 'Wobble Top', 'et_builder' ),
					'dnxt-hover-wobble-to-bottom-right' =>  esc_html__( 'Wobble To Bottom Right', 'et_builder' ),
					'dnxt-hover-wobble-to-top-right'    =>  esc_html__( 'Wobble To Top Right', 'et_builder' ),
					'dnxt-hover-wobble-vertical'        =>  esc_html__( 'Wobble Vertical', 'et_builder' ),
				),
				'mobile_options'      => true,
				'show_if'             => array(
					'dnxt_text_hover_effect_switch' => 'on',
				)
			),
			// Display Stack
			'display_type_select' => array(
				'label'           => esc_html__('Display Stacked', 'et_builder'),
				'type'            => 'yes_no_button',
				'description'     => esc_html__('Select how you would like to display the heading. Either inline or stacked.', 'et_builder'),
				'toggle_slug'     => 'dnxt_highlight_text',
				'options'         => array(
					'off'		  => esc_html__('Inline', 'et_builder'),
					'on'		  => esc_html__('Stack', 'et_builder'),
				),
				'default'         => 'off',
			),
		);
	}


    public function get_advanced_fields_config() {
		$advanced_fields = array();
		$advanced_fields['fonts'] 	= false;
		$advanced_fields['text'] 	= false;

		$advanced_fields['fonts'] = array(
            // Before After Fonts
            'heading_fonts'   => array(
                'label'       => esc_html__('', 'et_builder'),
                'toggle_slug' => 'dnxt_highlight_toggle',
				'tab_slug'    => 'advanced',
				'hide_text_align' => true,
				'sub_toggle'  => 'sub_toogle_heading_font',
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size'   => array(
                    'default' => '26px',
                ),
                'css'         => array(
                    'main' => "%%order_class%% .dnxt-text-heading",
                ),
			),
			// Highlight Text
			'animation_fonts'   => array(
				'label'       => esc_html__('', 'et_builder'),
				'toggle_slug' => 'dnxt_highlight_toggle',
				'tab_slug'    => 'advanced',
				'hide_text_align' => true,
				'sub_toggle'  => 'sub_toogle_highlight_font',
				'line_height' => array(
					'default' => '1em',
				),
				'font_size'   => array(
					'default' => '26px',
				),
				'css'         => array(
					'main' => "%%order_class%% .dnxt-text-highlight",
				),
			),
		);

		return $advanced_fields;
	}

	/**
     * Get Social alignment.
     *
     * @since 3.23 Add responsive support by adding device parameter.
     *
     * @param  string $device Current device name.
     * @return string Alignment value, rtl or not.
     */

    public function get_highlight_alignment($device = 'desktop') {
        $suffix = 'desktop' !== $device ? "_{$device}" : '';
        $text_orientation = isset($this->props["highlight_alignment{$suffix}"]) ? $this->props["highlight_alignment{$suffix}"] : '';

        return et_pb_get_alignment($text_orientation);
	}
	
	public function render( $attrs, $content, $render_slug ) {
		$multi_view 	= et_pb_multi_view_options($this);
		$headingTag  	= 	$this->props['heading_tag'];
		$before_text 	= 	$this->props['before_text'];
		$after_text		=	$this->props['after_text'];
		$highlight_text	=	$this->props['highlight_text'];

        // Highlight Alignment.
        $highlight_alignment = $this->get_highlight_alignment();
        $is_highlight_alignment_responsive = et_pb_responsive_options()->is_responsive_enabled($this->props, 'highlight_alignment');
        $highlight_alignment_tablet = $is_highlight_alignment_responsive ? $this->get_highlight_alignment('tablet') : '';
        $highlight_alignment_phone = $is_highlight_alignment_responsive ? $this->get_highlight_alignment('phone') : '';

        $highlight_alignments = array();
        if (!empty($highlight_alignment)) {
            array_push($highlight_alignments, sprintf('dnext_highlight_alignment_%1$s', esc_attr($highlight_alignment)));
        }

        if (!empty($highlight_alignment_tablet)) {
            array_push($highlight_alignments, sprintf('dnext_highlight_alignment_tablet_%1$s', esc_attr($highlight_alignment_tablet)));
        }

        if (!empty($highlight_alignment_phone)) {
            array_push($highlight_alignments, sprintf('dnext_highlight_alignment_phone_%1$s', esc_attr($highlight_alignment_phone)));
        }

		$highlight_alignment_classes = join(' ', $highlight_alignments);
		
		// Before Text
		$text_before = "";
		if ( "" !== $before_text ) {
			$text_before = sprintf(
				'<span class="dnxt-highlight-Btext dnxt-text-heading">%1$s</span>',
				esc_html__( $before_text )
			);
		}

		// Highlight Text
		$text_highlight = "";
		if ( "" !== $highlight_text ) {
			$text_highlight = sprintf(
				'<span class="dnxt-text-highlight dnxt-text-highlight-animated-text">%1$s</span>',
				esc_html__( $highlight_text )
			);
		}

		// After Text
		$text_after = "";
		if ( "" !== $after_text ) {
			$text_after = sprintf(
				'<span class="dnxt-highlight-Atext dnxt-text-heading">%1$s</span>',
				esc_html__( $after_text )
			);
		}

		$svgprint = "";
		switch ($this->props['dnxt_svg_select']) {
			case 'delete':
				$svgprint =
					'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path d="M497.4,23.9C301.6,40,155.9,80.6,4,144.4"></path><path d="M14.1,27.6c204.5,20.3,393.8,74,467.3,111.7"></path></svg>';
				break;
			case 'curly-line':
				$svgprint =
					'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path d="M3,146.1c17.1-8.8,33.5-17.8,51.4-17.8c15.6,0,17.1,18.1,30.2,18.1c22.9,0,36-18.6,53.9-18.6 c17.1,0,21.3,18.5,37.5,18.5c21.3,0,31.8-18.6,49-18.6c22.1,0,18.8,18.8,36.8,18.8c18.8,0,37.5-18.6,49-18.6c20.4,0,17.1,19,36.8,19 c22.9,0,36.8-20.6,54.7-18.6c17.7,1.4,7.1,19.5,33.5,18.8c17.1,0,47.2-6.5,61.1-15.6"></path></svg>';
				break;
			case 'circle':
				$svgprint =
					'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path d="M325,18C228.7-8.3,118.5,8.3,78,21C22.4,38.4,4.6,54.6,5.6,77.6c1.4,32.4,52.2,54,142.6,63.7 c66.2,7.1,212.2,7.5,273.5-8.3c64.4-16.6,104.3-57.6,33.8-98.2C386.7-4.9,179.4-1.4,126.3,20.7"></path></svg>';
				break;
			case 'diagonal':
				$svgprint =
					'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path d="M13.5,15.5c131,13.7,289.3,55.5,475,125.5"></path></svg>';
				break;
			case 'double':
				$svgprint =
					'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path d="M8.4,143.1c14.2-8,97.6-8.8,200.6-9.2c122.3-0.4,287.5,7.2,287.5,7.2"></path><path d="M8,19.4c72.3-5.3,162-7.8,216-7.8c54,0,136.2,0,267,7.8"></path></svg>';
				break;
			case 'double-line':
				$svgprint =
					'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path d="M5,125.4c30.5-3.8,137.9-7.6,177.3-7.6c117.2,0,252.2,4.7,312.7,7.6"></path><path d="M26.9,143.8c55.1-6.1,126-6.3,162.2-6.1c46.5,0.2,203.9,3.2,268.9,6.4"></path></svg>';
				break;
			case 'strikethrough':
				$svgprint =
					'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path d="M3,75h493.5"></path></svg>';
				break;
			case 'zigzag':
				$svgprint =
					'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path d="M9.3,127.3c49.3-3,150.7-7.6,199.7-7.4c121.9,0.4,189.9,0.4,282.3,7.2C380.1,129.6,181.2,130.6,70,139 c82.6-2.9,254.2-1,335.9,1.3c-56,1.4-137.2-0.3-197.1,9"></path></svg>';
				break;
			case 'wave':
				$svgprint =
					'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 466.33 50.26"><defs><style>.cls-1{fill:red;}</style></defs><title>Asset 4</title><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><path class="cls-1" d="M0,40.46S116.21-9.15,131.26,9.53a6.89,6.89,0,0,1,1.3,5.28c-1.17,8.33-5.06,46.64,24.79,32.25,0,0,86.54-42.66,93.38-45.08,0,0,20.18-12,19.55,23.17a15.72,15.72,0,0,0,14.78,16.07c13.44.76,38.11-3.54,82.8-24.34,0,0,19-8.57,13.76,12.7a8.55,8.55,0,0,0,9.57,10.47c12.95-1.94,36.34-7.28,75.14-21.66"/></g></g></svg>';
				break;
			case 'spiral':
				$svgprint =
					'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 430.38 67.12"><defs><style>.cls-1{fill:#00828c;}</style></defs><title>Asset 6</title><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><path class="cls-1" d="M0,50.34s42-.2,51.8-34.16c9-31.13-62.37,5.62-12.62,42.42A31,31,0,0,0,88.29,39.52a71.59,71.59,0,0,0,1.13-14.69C88.6-21,29.72,70.55,103.51,67c0,0,25.16-2.33,33.33-46.43S66.37,70.33,146,66.42c0,0,19.42-.55,31.31-42,10-34.76-46,2.39-14.18,27.27,20.15,15.76,50.17,9.74,62.52-12.68a62.5,62.5,0,0,0,5.48-13.71c7.45-27.17-30.26-8.58-15.54,17.6,11.71,20.84,41.15,21.5,55.42,2.32a47.54,47.54,0,0,0,9.64-28.76c.11-33.22-38,39.48,1.09,44.6a31.7,31.7,0,0,0,18.79-3.62c11-5.82,30.24-19.6,32.22-45.73,2.3-30.22-39,4.93-17.08,26.71,14,13.94,38,10.31,47.58-7a42.23,42.23,0,0,0,5.08-18.55c1.39-26.53-35.11-3.51-11.12,25.88a20.43,20.43,0,0,0,34.41-4.09c2.54-5.34,4.4-12.51,4.89-22.14,2-39.37-54.24,26.19,2.09,40.83,0,0,27.71,6.33,31.8-5.86"/></g></g></svg>';
				break;
			case 'brush':
				$svgprint =
					'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 495.5 24.47"><title>Asset 10</title><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><path d="M0,3.26c227.45-3.42,228.55-5.19,495.5,0L0,20.31s398.26,6.42,495.5,3.32"/></g></g></svg>';
				break;
			case 'splash':
				$svgprint =
					'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 479.14 73.08"><title>Asset 3</title><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><path d="M.53,23.05S-7,58,34.51,69C120.17,91.75,198.87,12,215.66,7c102.8-30.83,248.87,50.48,263.48,54.77"/></g></g></svg>';
				break;
			case 'brick-wall':
				$svgprint =
					'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 470.31 23.83"><title>Asset 1</title><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><g id="Layer_1-2-2" data-name="Layer 1-2"><path d="M470.31,0V23.83l-58.82-1.21V0H356.72V23.23H293.47L292.74,0H230.22l.49,23.23H164.79L164.55,0H99V23.23H37.2L37.56,0H0V23.23"/></g></g></g></svg>';
				break;
			default:
				$svgprint =
					'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path d="M7.7,145.6C109,125,299.9,116.2,401,121.3c42.1,2.2,87.6,11.8,87.3,25.7"></path></svg>';
				break;
		}

		$text_hover_effect_enable = '';
        if ('off' !== $this->props['dnxt_text_hover_effect_switch']) {
            $text_hover_effect_enable = $this->props['dnxt_text_hover_effect_select'];
		}

		$stroke_width				=	$this->props['stroke_width'];
		$stroke_width_hover			=	$this->get_hover_value( 'stroke_width' );
		$stroke_width_tablet		= 	$this->props['stroke_width_tablet'];
		$stroke_width_phone			= 	$this->props['stroke_width_phone'];
		$stroke_width_last_edited	= 	$this->props['stroke_width_last_edited'];

		if ( '' !== $stroke_width ) { 
			$stroke_width_responsive_active = et_pb_get_responsive_status( $stroke_width_last_edited );
		
			$stroke_width_values = array(
				'desktop' => $stroke_width,
				'tablet'  => $stroke_width_responsive_active ? $stroke_width_tablet : '',
				'phone'   => $stroke_width_responsive_active ? $stroke_width_phone : '',
			);
			$stroke_width_selector	= "%%order_class%% .dnxt-text-highlight-animated-wrapper svg path";
			et_pb_responsive_options()->generate_responsive_css( $stroke_width_values, $stroke_width_selector, 'stroke-width', $render_slug );
			
			if ( et_builder_is_hover_enabled( 'stroke_width', $this->props ) ) {
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => $this->add_hover_to_order_class( "%%order_class%% .dnxt-text-highlight-animated-wrapper svg:hover path" ),
					'declaration' => sprintf(
						'stroke-width: %1$s;',
						esc_html( $stroke_width_hover )
					),
				) );
			}
		}

		// Stroke Color
		$stroke_color			= $this->props['stroke_color'];
		$stroke_color_hover 	= $this->get_hover_value( 'stroke_color' );
		$stroke_color_values	= et_pb_responsive_options()->get_property_values( $this->props, 'stroke_color' );
		$stroke_color_tablet	= isset( $stroke_color_values['tablet'] ) ? $stroke_color_values['tablet'] : '';
		$stroke_color_phone		= isset( $stroke_color_values['phone'] ) ? $stroke_color_values['phone'] : '';

		if ( '' !== $stroke_color ) {
			$stroke_color_style 		 	= sprintf( 'stroke: %1$s;', esc_attr( $stroke_color ) );
			$stroke_color_tablet_style 	= '' !== $stroke_color_tablet ? sprintf( 'stroke: %1$s;', esc_attr( $stroke_color_tablet ) ) : '';
			$stroke_color_phone_style  	= '' !== $stroke_color_phone ? sprintf( 'stroke: %1$s;', esc_attr( $stroke_color_phone ) ) : '';
			
			$stroke_color_style_hover  = '';

			if ( et_builder_is_hover_enabled( 'stroke_color', $this->props ) ) {
				$stroke_color_style_hover = sprintf( 'storke: %1$s;', esc_attr( $stroke_color_hover ) );
			}

			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnxt-text-highlight-animated-wrapper svg path",
				'declaration' => $stroke_color_style,
			) );
			
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnxt-text-highlight-animated-wrapper svg path",
				'declaration' => $stroke_color_tablet_style,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
			) );

			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnxt-text-highlight-animated-wrapper svg path",
				'declaration' => $stroke_color_phone_style,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
			) );

			if ( "" !== $stroke_color_style_hover ) {
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => $this->add_hover_to_order_class( "%%order_class%% .dnxt-text-highlight-animated-wrapper svg path:hover" ),
					'declaration' => $stroke_color_style_hover,
				) );
			}
		}

		$this->apply_css($render_slug);

		return sprintf( 
			'<%4$s class="dnxt-highlight-intro %6$s %7$s">
					%1$s
					<span class="dnxt-text-highlight-animated-wrapper">
						%3$s
						<span>%5$s</span>
					</span>
					%2$s
			</%4$s>', 
			$text_before,
			$text_after,
			$text_highlight,
			$headingTag,
			$svgprint, // #5
			$text_hover_effect_enable,
			$highlight_alignment_classes
		);
	}

	public function apply_css($render_slug){

		// Stroke Animation Delay Setting
		if ('' !== $this->props['highlight_animation_delay']) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt-text-highlight-animated-wrapper svg path",
				'declaration' => "-webkit-animation-delay: {$this->props['highlight_animation_delay']};animation-delay: {$this->props['highlight_animation_delay']};",
			));
		}
		/**
         * Dispaly Inline or Stacked
         *
         */
        if (('on' === $this->props['display_type_select'])) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "%%order_class%% .dnxt-text-heading",
                'declaration' => "display: block;",
            ));
        }
	}
}

new Next_Text_Highlight;
