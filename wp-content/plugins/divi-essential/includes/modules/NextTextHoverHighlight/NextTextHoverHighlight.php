<?php
include_once(DIVI_ESSENTIAL_PATH.'/includes/modules/base/Common.php');

class NextTextHoverHighlight extends ET_Builder_Module {

	public $slug       = 'dnxte_text_hover_highlight';
	public $vb_support = 'on';

	protected $module_credits = array(
		'module_uri' => 'https://www.diviessential.com/divi-text-hover-highlight/',
		'author'     => 'Divi Next',
		'author_uri' => 'www.divinext.com',
	);

	public function init() {
		$this->name 		= esc_html__( 'Next Text Hover Highlight', 'et_builder' );
		$this->icon_path    = plugin_dir_path( __FILE__ ) . 'icon.svg';
		$this->folder_name 	= 'et_pb_divi_essential';
		
		$this->settings_modal_toggles = array(
			'general'	=> array(
				'toggles'		=>	array(
					'thh_hht_color_gradient'	=> array(
						'title'		=>	esc_html__( 'Text Background', 'et_builder' ),
						'priority'	=>	90,
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
				),
			),
			'advanced'	=> array(
				'toggles'		=>	array(
					'thh_highlight_color_gradient'	=> array(
						'title'		=>	esc_html__( 'Highlight', 'et_builder' ),
						'priority'	=>	1,
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
					'thh_highlight_fonts'	=> array(
						"title"		=>	esc_html__( 'Fonts', 'et_builder' ),
						'sub_toggles'       => array(
                            'sub_toggle_plain_text'   => array(
                                'name' => 'Plain Text',
                            ),
                            'sub_toggle_highlight_text' => array(
                                'name' => 'Highlight Text',
							),
                        ),
                        'tabbed_subtoggles' => true,
					),
					'thh_hht_border'=> array(
						"title"		=>	esc_html__( 'Text Border', 'et_builder' ),
						'priority'	=>	100,
					),
					'thh_hht_box_shadow'	=> array(
						"title"		=>	esc_html__( 'Text Shadow', 'et_builder' ),
						'priority'	=>	102,
					),
					'thh_hht_space'	=> array(
						"title"		=>	esc_html__( 'Text Spacing', 'et_builder' ),
						'priority'	=>	91,
					),
				),
			),
		);

		// Custom CSS Field
		$this->custom_css_fields = array(
			'thh_hht_wrapper' => array(
				'label'    => esc_html__('Hover Highlight Text Wrapper', 'et_builder'),
				'selector' => '%%order_class%% .dnxt-thh-wrapper',
			),
			'thh_before_css' => array(
				'label'    => esc_html__('Before Text', 'et_builder'),
				'selector' => '%%order_class%% .dnxt-underline-hover-before-text',
			),
			'thh_highlight_css'  => array(
				'label'    => esc_html__('Highlight Text', 'et_builder'),
				'selector' => '%%order_class%% .dnxt-thh-highlight-text',
			),  
			'thh_after_css'  => array(
				'label'    => esc_html__('After Text', 'et_builder'),
				'selector' => '%%order_class%% .dnxt-underline-hover-after-text',
			),
		);
	}

	public function get_fields() {
		return array(
			// Before Text Switch
			'thh_before_text_switch'  => array(
				'label'           => esc_html__('Before Text Enable', 'et_builder'),
				'type'            => 'yes_no_button',                
				'toggle_slug'     => 'main_content',
				'options'   => array(
					'off'     => esc_html__('Off', 'et_builder'),
					'on'      => esc_html__('On', 'et_builder'),
				),
				'affects'         => array(
					'thh_before_text'
				),
				'default_on_front'=> 'off',
			),
			// Before Text
			'thh_before_text' 	  => array(
				'label'           => esc_html__( 'Before Text', 'et_builder' ),
				'type'            => 'text',
				'dynamic_content' => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Before Text entered here will appear inside the module.', 'et_builder' ),
				'toggle_slug'     => 'main_content',
			),
			// Highlight Text
			'thh_highlight_text'  => array(
				'label'           => esc_html__( 'Hover Highlight Text', 'et_builder' ),
				'type'            => 'text',
				'dynamic_content' => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Hightlight Text entered here will appear inside the module.', 'et_builder' ),
				'toggle_slug'     => 'main_content',
			),
			// Aftert Text Switch
			'thh_after_text_switch'=> array(
				'label'           => esc_html__('After Text Enable', 'et_builder'),
				'type'            => 'yes_no_button',                
				'toggle_slug'     => 'main_content',
				'options'   => array(
					'off'     => esc_html__('Off', 'et_builder'),
					'on'      => esc_html__('On', 'et_builder'),
				),
				'affects'         => array(
					'thh_after_text'
				),
				'default_on_front'=> 'off',
			),
			// After Text
			'thh_after_text'      => array(
				'label'           => esc_html__( 'After Text', 'et_builder' ),
				'type'            => 'text',
				'dynamic_content' => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'After Text entered here will appear inside the module.', 'et_builder' ),
				'toggle_slug'     => 'main_content',
				
			),
			// Heading Tag
			'thh_heading_tag'     => array(
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
			// Highlight Hover Effect
			'thh_hover_effect' 		=> array(
				'label'             => esc_html__( 'Select Hover Effect', 'et_builder' ),
				'type'              => 'select',
				'description'       => esc_html__( 'Here you can adjust the hover effect.', 'et_builder' ),
				'option_category' 	=> 'basic_option',
				'toggle_slug'       => 'main_content',
				'options'           => array(
					'dnxt-thh-underline-right'  			=>  esc_html__( 'Underline Right', 'et_builder' ),
					'dnxt-thh-underline-closing'			=>  esc_html__( 'Underline Closing', 'et_builder' ),
					'dnxt-thh-underline-opening'			=>  esc_html__( 'Underline Opening', 'et_builder' ),
					'dnxt-thh-double-underline-left'		=>  esc_html__( 'Double Underline Left', 'et_builder' ),
					'dnxt-thh-double-underline-right'		=>  esc_html__( 'Double Underline Right', 'et_builder' ),
					'dnxt-thh-double-underline-opening'		=>  esc_html__( 'Double Underline Opening', 'et_builder' ),
					'dnxt-thh-double-underline-left-right'	=>  esc_html__( 'Double Underline Left Right', 'et_builder' ),
					'dnxt-thh-overline-left'        		=>  esc_html__( 'Overline Left', 'et_builder' ),
					'dnxt-thh-overline-right'        		=>  esc_html__( 'Overline Right', 'et_builder' ),
					'dnxt-thh-overline-closing'        		=>  esc_html__( 'Overline Closing', 'et_builder' ),
					'dnxt-thh-overline-opening'        		=>  esc_html__( 'Overline Opening', 'et_builder' ),
					'dnxt-thh-left-down'        			=>  esc_html__( 'Left Down', 'et_builder' ),
					'dnxt-thh-left-up'        				=>  esc_html__( 'Left Up', 'et_builder' ),
					'dnxt-thh-right-down'        			=>  esc_html__( 'Right Down', 'et_builder' ),
					'dnxt-thh-right-up'        				=>  esc_html__( 'Right Up', 'et_builder' ),
					'dnxt-thh-move-down'        			=>  esc_html__( 'Move Down', 'et_builder' ),
					'dnxt-thh-move-up'        				=>  esc_html__( 'Move Up', 'et_builder' ),
					'dnxt-thh-move-right'        			=>  esc_html__( 'Move Right', 'et_builder' ),
					'dnxt-thh-move-left'        			=>  esc_html__( 'Move Left', 'et_builder' ),
					'dnxt-thh-move-vertical'        		=>  esc_html__( 'Move Vertical', 'et_builder' ),
					'dnxt-thh-move-horizontal'        		=>  esc_html__( 'Move Horizontal', 'et_builder' ),
					'dnxt-thh-both-down'        			=>  esc_html__( 'Both Down', 'et_builder' ),
					'dnxt-thh-both-up'        				=>  esc_html__( 'Both Up', 'et_builder' ),
					'dnxt-thh-both-right'        			=>  esc_html__( 'Both Right', 'et_builder' ),
					'dnxt-thh-both-left'        			=>  esc_html__( 'Both left', 'et_builder' ),
					'dnxt-thh-left-up-right-down'			=>  esc_html__( 'Left Up Right Down', 'et_builder' ),
					'dnxt-thh-left-down-right-up'        	=>  esc_html__( 'Left Down Right Up', 'et_builder' ),
					'dnxt-thh-both-opening-horizontal'      =>  esc_html__( 'Both Opening Horizontal', 'et_builder' ),
					'dnxt-thh-overline-left-underline-right'=>  esc_html__( 'Overline Left Underline Right', 'et_builder' ),
					'dnxt-thh-overline-right-underline-left'=>  esc_html__( 'Overline Right Underline Left', 'et_builder' ),
					'dnxt-thh-fill-left'        			=>  esc_html__( 'Fill Left', 'et_builder' ),
					'dnxt-thh-fill-right'        			=>  esc_html__( 'Fill Right', 'et_builder' ),
					'dnxt-thh-fill-down'        			=>  esc_html__( 'Fill Down', 'et_builder' ),
					'dnxt-thh-fill-up'        				=>  esc_html__( 'Fill Up', 'et_builder' ),
					'dnxt-thh-fill-closing-vertical' 		=>  esc_html__( 'Fill Closing Vertical', 'et_builder' ),
					'dnxt-thh-fill-closing-horizontal'      =>  esc_html__( 'Fill Closing Horizontal', 'et_builder' ),
					'dnxt-thh-fill-opening-horizontal'      =>  esc_html__( 'Fill Opening Horizontal', 'et_builder' ),
					'dnxt-thh-fill-top-left'        		=>  esc_html__( 'Fill Top Left', 'et_builder' ),
					'dnxt-thh-fill-top-right'        		=>  esc_html__( 'Fill Top Right', 'et_builder' ),
					'dnxt-thh-fill-bottom-left'        		=>  esc_html__( 'Fill Bottom Left', 'et_builder' ),
					'dnxt-thh-fill-bottom-right'        	=>  esc_html__( 'Fill Bottom Right', 'et_builder' ),
					'dnxt-thh-underline-left-bottom'        =>  esc_html__( 'Left Bottom', 'et_builder' ),
					'dnxt-thh-underline-left-top'        	=>  esc_html__( 'Left Top', 'et_builder' ),
					'dnxt-thh-underline-right-top'        	=>  esc_html__( 'Right Top', 'et_builder' ),
					'dnxt-thh-underline-right-bottom'       =>  esc_html__( 'Right Bottom', 'et_builder' ),
					'dnxt-thh-underline-bottom-right'       =>  esc_html__( 'Bottom Right', 'et_builder' ),
					'dnxt-thh-underline-bottom-left'        =>  esc_html__( 'Bottom Left', 'et_builder' ),
					'dnxt-thh-underline-top-left'        	=>  esc_html__( 'Top Left', 'et_builder' ),
					'dnxt-thh-underline-top-right'        	=>  esc_html__( 'Top Right', 'et_builder' ),
					'dnxt-thh-linethrough-left'        		=>  esc_html__( 'Linethrough Left', 'et_builder' ),
					'dnxt-thh-linethrough-right'        	=>  esc_html__( 'Linethrough Right', 'et_builder' ),
					'dnxt-thh-linethrough-opening'        	=>  esc_html__( 'Linethrough Opening', 'et_builder' ),
					'dnxt-thh-linethrough-closing'        	=>  esc_html__( 'Linethrough Closing', 'et_builder' ),
					'dnxt-thh-double-linethrough-left'      =>  esc_html__( 'Double Linethrough Left', 'et_builder' ),
					'dnxt-thh-double-linethrough-right'     =>  esc_html__( 'Double Linethrough Right', 'et_builder' ),
					'dnxt-thh-double-linethrough-left-right'=>  esc_html__( 'Double Linethrough Left right', 'et_builder' ),
					'dnxt-thh-double-linethrough-right-left'=>  esc_html__( 'Double Linethrough Right Left', 'et_builder' ),
					'dnxt-thh-double-linethrough-opening'   =>  esc_html__( 'Double Linethrough Opening', 'et_builder' ),
					'dnxt-thh-double-underline-right-delayed'=> esc_html__( 'Double Underline Right Delayed', 'et_builder' ),
				),
				'default'         => 'dnxt-thh-underline-right',
			),
			// Highlight Hight
			'thh_highlight_hight' => array(
				'label'           => esc_html__( 'Highlight Hight', 'et_builder' ),
				'description'     => esc_html__( 'Adjust the height of the line within the Highlight Text.', 'et_builder' ),
				'type'            => 'range',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'main_content',
				'default_on_front'=> '',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'allow_empty'     => true,
				'range_settings'  => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'default'         	=> '3px',
                'fixed_unit'      	=> 'px',
				'validate_unit'   	=> true,
			),
			// Highlight Link 
			'thh_link_url'      => array(
				'label'           => esc_html__( 'Highlight Link', 'et_builder' ),
				'type'            => 'text',
				'dynamic_content' => 'url',
				'description'     => esc_html__( 'Input the destination URL for your button.', 'et_builder' ),
				'option_category' => 'configuration',
				'toggle_slug'     => 'link_options',
			),
			// Hightlight Link Target
			'thh_link_target'=> array(
				'label'				 => esc_html__( 'Highlight Link Target', 'et_builder' ),
				'type'               => 'select',
				'description'      	 => esc_html__( 'Here you can choose whether or not your link opens in a new window', 'et_builder' ),
				'option_category'  	 => 'configuration',
				'options'          	 => array(
					'off' => esc_html__( 'In The Same Window', 'et_builder' ),
					'on'  => esc_html__( 'In The New Tab', 'et_builder' ),
				),
				'toggle_slug'      	 => 'link_options',
				'default_on_front' 	 => 'off',
			),
			'thh_highlight_color_enable' => array(
				'label'           => esc_html__( 'Highlight Color Enable', 'et_builder' ),
				'type'            => 'yes_no_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'et_builder' ),
					'on'  => esc_html__( 'Yes', 'et_builder' ),
				),
				'affects'     => array(
					'thh_highlight_color',
				),
				'tab_slug'        	=> 'advanced',
				'toggle_slug'      	=> 'thh_highlight_color_gradient',
				'sub_toggle'	  	=> 'sub_toggle_color',
				'default_on_front' 	=> 'on',
			),
			'thh_highlight_color' 	=> array(
				'label'             => esc_html__( 'Highlight Color', 'et_builder' ),
				'type'              => 'color-alpha',
				'description'       => esc_html__( 'Here you can define a custom background color for your Highlight text.', 'et_builder' ),
				'tab_slug'        	=> 'advanced',
				'toggle_slug'       => 'thh_highlight_color_gradient',
				'sub_toggle'	  	=> 'sub_toggle_color',
				'hover'             => 'tabs',
				'default'        	=> '#0077FF',
				'depends_show_if' 	=> 'on',
			),
			'thh_highlight_gradient_enable'  => array(
				'label'           => esc_html__( 'Highlight Gradient Color', 'et_builder'),
				'type'            => 'yes_no_button',
				'tab_slug'        => 'advanced', 
				'toggle_slug'     => 'thh_highlight_color_gradient',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'options'             => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'affects'         => array(
					'thh_gradient_color_one',
					'thh_gradient_color_two',
					'thh_gradient_type',
					'thh_gradient_start_position',
					'thh_gradient_end_position'
				),
				'default_on_front' => 'off',
				'depends_show_if' 	=> 'on',
			),
			'thh_gradient_color_one'	=> array(
				'label'          => esc_html__('Select Color One', 'et_builder'),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'thh_highlight_color_gradient',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'default'        => '#0077FF',
				'depends_show_if'=> 'on',
			),
			'thh_gradient_color_two'	=> array(
				'label'          => esc_html__('Select Color Two', 'et_builder'),
				'type'           => 'color-alpha',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'thh_highlight_color_gradient',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'default'        => '#772ADB',
				'depends_show_if'=> 'on',
			),
			'thh_gradient_type'	  => array(
				'label'           => esc_html__('Select Gradient Type', 'et_builder'),
				'type'            => 'select',
				'description'     => esc_html__('Select the types of gradient', 'et_builder'),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'thh_highlight_color_gradient',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'options'         => array(
					'linear-gradient' => esc_html__('Linear', 'et_builder'),
					'radial-gradient' => esc_html__('Radial', 'et_builder'),
				),
				'default'         => 'linear-gradient',
				'depends_show_if' => 'on',
			),
			'thh_gradient_type_linear_direction'   => array(
				'label'           => esc_html__('Linear direction', 'et_builder'),
				'type'            => 'range',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'thh_highlight_color_gradient',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'range_settings'  => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 360,
				),
				'default'         => '180deg',
				'fixed_unit'      => 'deg',
				'show_if' => array(
					'thh_highlight_gradient_enable' => 'on',
					'thh_gradient_type' 			=> 'linear-gradient'
				),
			),
			'thh_gradient_type_radial_direction'   => array(
				'label'           	=> esc_html__('Radial Direction', 'et_builder'),
				'type'            	=> 'select',
				'description'     	=> esc_html__('Select the types of gradient', 'et_builder'),                
				'tab_slug'        	=> 'advanced',
				'toggle_slug'    	=> 'thh_highlight_color_gradient',
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
					'thh_highlight_gradient_enable' => 'on',
					'thh_gradient_type'				=> 'radial-gradient'
				),
			),
			'thh_gradient_start_position'           => array(
				'label'           => esc_html__('Start Position', 'et_builder'),
				'type'            => 'range',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'thh_highlight_color_gradient',
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
			'thh_gradient_end_position'             => array(
				'label'           => esc_html__('End Position', 'et_builder'),
				'type'            => 'range',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'thh_highlight_color_gradient',
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
			// Highlight Text Aligment
			'thh_text_alignment'	=> array(
				'label'           	=> esc_html__( 'Text Alignment', 'et_builder' ),
				'type'            	=> 'text_align',
				'option_category' 	=> 'layout',
				'description'     	=> esc_html__( 'This controls how your text is aligned within the module.', 'et_builder' ),
				'options'          => et_builder_get_text_orientation_options( array( 'justified' ), array( 'justify' => 'Justified' ) ),
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'text',
			),
			//Hover Highlight Text Background
			'thh_hht_bg_color_enable' => array(
				'label'           => esc_html__( 'Text Color Enable', 'et_builder' ),
				'type'            => 'yes_no_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'et_builder' ),
					'on'  => esc_html__( 'Yes', 'et_builder' ),
				),
				'affects'     => array(
					'thh_hht_color',
				),
				'depends_show_if'  	=> 'on',
				'toggle_slug'      	=> 'thh_hht_color_gradient',
				'sub_toggle'	  	=> 'sub_toggle_color',
				'default_on_front' 	=> 'on',
			),
			'thh_hht_color' 		=> array(
				'label'             => esc_html__( 'Text BG Color', 'et_builder' ),
				'type'              => 'color-alpha',
				'description'       => esc_html__( 'Here you can define a custom background color for your Highlight text.', 'et_builder' ),
				'toggle_slug'       => 'thh_hht_color_gradient',
				'sub_toggle'	  	=> 'sub_toggle_color',
				'hover'             => 'tabs',
				'default'        	=> '#0077FF',
				'depends_show_if' 	=> 'on',
			),
			'thh_hht_gradient_enable'  => array(
				'label'           => esc_html__( 'Text Gradient Color', 'et_builder'),
				'type'            => 'yes_no_button',
				'toggle_slug'     => 'thh_hht_color_gradient',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'options'             => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'affects'         => array(
					'thh_hht_gradient_color_one',
					'thh_hht_gradient_color_two',
					'thh_hht_gradient_type',
					'thh_hht_gradient_start_position',
					'thh_hht_gradient_end_position'
				),
				'default_on_front' => 'off',
				'depends_show_if' 	=> 'on',
			),
			'thh_hht_gradient_color_one'	=> array(
				'label'          => esc_html__('Select Color One', 'et_builder'),
				'type'           => 'color-alpha',
				'toggle_slug'    => 'thh_hht_color_gradient',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'default'        => '#0077FF',
				'depends_show_if'=> 'on',
			),
			'thh_hht_gradient_color_two'	=> array(
				'label'          => esc_html__('Select Color Two', 'et_builder'),
				'type'           => 'color-alpha',
				'toggle_slug'    => 'thh_hht_color_gradient',
				'sub_toggle'	 => 'sub_toggle_gradient',
				'default'        => '#772ADB',
				'depends_show_if'=> 'on',
			),
			'thh_hht_gradient_type'	  => array(
				'label'           => esc_html__('Select Gradient Type', 'et_builder'),
				'type'            => 'select',
				'description'     => esc_html__('Select the types of gradient', 'et_builder'),
				'option_category' => 'basic_option',
				'toggle_slug'     => 'thh_hht_color_gradient',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'options'         => array(
					'linear-gradient' => esc_html__('Linear', 'et_builder'),
					'radial-gradient' => esc_html__('Radial', 'et_builder'),
				),
				'default'         => 'linear-gradient',
				'depends_show_if' => 'on',
			),
			'thh_hht_gradient_type_linear_direction'   => array(
				'label'           => esc_html__('Linear direction', 'et_builder'),
				'type'            => 'range',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'thh_hht_color_gradient',
				'sub_toggle'	  => 'sub_toggle_gradient',
				'range_settings'  => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 360,
				),
				'default'         => '180deg',
				'fixed_unit'      => 'deg',
				'show_if' => array(
					'thh_hht_gradient_enable' => 'on',
					'thh_hht_gradient_type'	  => 'linear-gradient'
				),
			),
			'thh_hht_gradient_type_radial_direction'   => array(
				'label'           	=> esc_html__('Radial Direction', 'et_builder'),
				'type'            	=> 'select',
				'description'     	=> esc_html__('Select the types of gradient', 'et_builder'),                
				'option_category' 	=> 'basic_option',
				'toggle_slug'    	=> 'thh_hht_color_gradient',
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
					'thh_hht_gradient_enable' => 'on',
					'thh_hht_gradient_type'	  => 'radial-gradient'
				),
			),
			'thh_hht_gradient_start_position'           => array(
				'label'           => esc_html__('Start Position', 'et_builder'),
				'type'            => 'range',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'thh_hht_color_gradient',
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
			'thh_hht_gradient_end_position'             => array(
				'label'           => esc_html__('End Position', 'et_builder'),
				'type'            => 'range',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'thh_hht_color_gradient',
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
			'thh_hht_margin'	  => array(
				'label'           => esc_html__('Text Margin', 'et_builder'),
                'type'            => 'custom_margin',
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
				'toggle_slug'     => 'thh_hht_space',
				'mobile_options'  => true,
			),
			'thh_hht_padding'	  => array(
				'label'           => esc_html__('Text Padding', 'et_builder'),
				'type'            => 'custom_padding',
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' => 'layout',
				'tab_slug'        => 'advanced',				
				'toggle_slug'     => 'thh_hht_space',
				'mobile_options'  => true,
			),
		);
	}

	public function get_advanced_fields_config() {
		$advanced_fields = array();
		$advanced_fields['fonts'] 	= false;
		$advanced_fields = array(
			'fonts'					=> array(
				'thh_plain_text' 	=> array(
					'label'    		=> esc_html__( '', 'et_builder' ),
					'toggle_slug'   => 'thh_highlight_fonts',
					'sub_toggle'	=> 'sub_toggle_plain_text',
					'tab_slug'		=> 'advanced',
					'hide_text_align'=> 'true',
					'css'      => array(
						'main' => "%%order_class%% .dnxt-thh-plain-text",
					),
					'font_size'   => array(
						'default' => '26px',
					),
				),
				'thh_highlight_text'=> array(
					'label'    		=> esc_html__( '', 'et_builder' ),
					'toggle_slug'   => 'thh_highlight_fonts',
					'sub_toggle'	=> 'sub_toggle_highlight_text',
					'tab_slug'		=> 'advanced',
					'hide_text_align'=> 'true',
					'css'      => array(
						'main' => "%%order_class%% .dnxt-thh-highlight-text",
					),
					'font_size'   => array(
						'default' => '26px',
					),
				),
			),
			'text'       => array(
				'use_text_orientation'  => false,
				'css'              => array(
					'text_shadow' => "%%order_class%% .et_pb_module_inner",
					'text_align' => "%%order_class%% .et_pb_module_inner",
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
			'borders'		=> array(
				'default' => array(),
				'thh_hht_border'   => array(
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'thh_hht_border',
					'css'          => array(
						'main'     => array(
							'border_radii'  		=> "%%order_class%% .dnxt-thh-wrapper",
							'border_radii_hover'  	=> '%%order_class%%:hover .dnxt-thh-wrapper',
							'border_styles' 		=> "%%order_class%% .dnxt-thh-wrapper",
							'border_styles_hover' 	=> '%%order_class%%:hover .dnxt-thh-wrapper',
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
				'default' => array(),
				'thh_hht_box_shadow'   => array(
					'label'               => esc_html__( 'Text Box Shadow', 'et_builder' ),
					'option_category'     => 'layout',
					'tab_slug'            => 'advanced',
					'toggle_slug'         => 'thh_hht_box_shadow',
					'css'                 => array(
						'main'        => '%%order_class%% .dnxt-thh-wrapper',
						'hover'       => '%%order_class%%:hover .dnxt-thh-wrapper',
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
		);

		return $advanced_fields;
	}

	public function render( $attrs, $content, $render_slug ) {
		$thh_before_text_switch  	= $this->props['thh_before_text_switch'];
		$thh_before_text  	 		= $this->props['thh_before_text'];
		$thh_highlight_text  		= $this->props['thh_highlight_text'];
		$thh_after_text_switch  	= $this->props['thh_after_text_switch'];
		$thh_after_text  	 		= $this->props['thh_after_text'];
		$thh_heading_tag  	 		= $this->props['thh_heading_tag'];
		$thh_link_url  	 			= $this->props['thh_link_url'];
		$thh_link_target  	 		= $this->props['thh_link_target'];


		// Before Text Dynamic
		if( 'off' !== $thh_before_text_switch ){
			$thh_before_text = sprintf(
				'<span class="dnxt-thh-plain-text dnxt-underline-hover-before-text">%1$s</span>',
				et_core_esc_previously( $thh_before_text )
			);
		}else {
			$thh_before_text = "";
		}
		// Text Hover Effect
		$thh_hover_effect = '';
		if ( '' !== $this->props['thh_hover_effect'] ) {
			$thh_hover_effect = $this->props['thh_hover_effect'];
		}
		$highlight_target = 'off' !== $thh_link_target ? '_blank' : '_self';
		
		// Highlight Text Dynamic
		if ( "" !== $thh_link_url){
			$thh_highlight_text = sprintf(
				'<a href="%3$s" target="%4$s" class="dnxt-thh-highlight-text %2$s">%1$s</a>',
				et_core_esc_previously( $thh_highlight_text ),
				$thh_hover_effect,
				$thh_link_url,
				$highlight_target
			);
		}else {
			$thh_highlight_text = sprintf(
				'<span class="dnxt-thh-highlight-text %2$s">%1$s</span>',
				et_core_esc_previously( $thh_highlight_text ),
				$thh_hover_effect
			);
		}
		// After Text Dynamic
		if( 'off' !== $thh_after_text_switch ){
			$thh_after_text = sprintf(
				'<span class="dnxt-thh-plain-text dnxt-underline-hover-after-text">%1$s</span>',
				et_core_esc_previously( $thh_after_text )
			);
		}else {
			$thh_after_text = "";
		}


		$this->apply_css($render_slug);
		return sprintf( 
			'<div class="dnxt-thh-wrapper-inner">
				<%4$s class="dnxt-thh-wrapper">
					%1$s 
					%2$s 
					%3$s
				</%4$s>
			</div>', 
			$thh_before_text,
			$thh_highlight_text,
			$thh_after_text,
			$thh_heading_tag
		);
	}

	public function apply_css($render_slug){

		/**
         * Custom Padding Margin Output
         *
         */

        Common::dnxt_set_style($render_slug, $this->props, "thh_hht_margin", "%%order_class%% .dnxt-thh-wrapper", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "thh_hht_padding", "%%order_class%% .dnxt-thh-wrapper", "padding");

		// Highlight Background Color & Gradient
		$thh_highlight_color  			= '';
		$thh_gradient_apply         	= '';
		$thh_gradient_color_one 	 	= '';
		$thh_gradient_color_two 	 	= '';
		$thh_gradient_type	   		 	= '';
		$thh_gl             		 	= '';
		$thh_gr             		 	= '';
		$thh_gradient_start_position	= '';
		$thh_gradient_end_position  	= '';

		// Highlight BG Color
		if ('' !== $this->props['thh_highlight_color']) {
			$thh_highlight_color = $this->props['thh_highlight_color'];
		}
		if ('off' !== $this->props['thh_highlight_color_enable']){
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt-thh-highlight-text:hover:after, %%order_class%% .dnxt-thh-highlight-text:hover:before",
				'declaration' => "background-color: $thh_highlight_color;",
			));
		}

		// Gradient Type
		if ('' !== $this->props['thh_gradient_type']) {
			$thh_gradient_type = $this->props['thh_gradient_type'];
		}
		// Linear Gradient Direction
		if ('' !== $this->props['thh_gradient_type_linear_direction']) {
			$thh_gl = $this->props['thh_gradient_type_linear_direction'];
		}
		// Radial Gradient Direction
		if ('' !== $this->props['thh_gradient_type_radial_direction']) {
			$thh_gr = $this->props['thh_gradient_type_radial_direction'];
		}
		// Apply gradient direcion
		if ('radial-gradient' === $this->props['thh_gradient_type']) {
			$thh_gradient_apply = sprintf('%1$s', $thh_gr);
		} else if ('linear-gradient' === $this->props['thh_gradient_type']) {
			$thh_gradient_apply = sprintf('%1$s', $thh_gl);
		}
		// Gradient color one for content
		if ('' !== $this->props['thh_gradient_color_one']) {
			$thh_gradient_color_one = $this->props['thh_gradient_color_one'];
		}
		// Gradient color two for content 
		if ('' !== $this->props['thh_gradient_color_two']) {
			$thh_gradient_color_two = $this->props['thh_gradient_color_two'];
		}

		// Gradient color start position 
		if ('' !== $this->props['thh_gradient_start_position']) {
			$thh_gradient_start_position = $this->props['thh_gradient_start_position'];
		}

		// Gradient color end position
		if ('' !== $this->props['thh_gradient_end_position']) {
			$thh_gradient_end_position = $this->props['thh_gradient_end_position'];
		}
		// Gradient setting up
		if ('off' !== $this->props['thh_highlight_gradient_enable']){
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt-thh-highlight-text:hover:after, %%order_class%% .dnxt-thh-highlight-text:hover:before",
				'declaration' => "background: {$thh_gradient_type}($thh_gradient_apply, $thh_gradient_color_one $thh_gradient_start_position, $thh_gradient_color_two $thh_gradient_end_position);",
			));
		}
		// Highlight Height
		if ('' !== $this->props['thh_highlight_hight']){
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt-thh-highlight-text:hover:after, %%order_class%% .dnxt-thh-highlight-text:hover:before",
				'declaration' => "height: {$this->props['thh_highlight_hight']}; z-index: -1;",
			));
		}

		// Highlight Text Alignment
		$thh_text_alignment = "";
		
		if ('' !== $this->props['thh_text_alignment']) {
			$thh_text_alignment = $this->props['thh_text_alignment'];
		}		
		switch ($this->props['thh_text_alignment']) {
			case 'left':
				ET_Builder_Element::set_style($render_slug, array(
					'selector'    => "%%order_class%% .dnxt-thh-wrapper-inner",
					'declaration' => "text-align: {$thh_text_alignment};",
				));
				break;
			case 'center':
				ET_Builder_Element::set_style($render_slug, array(
					'selector'    => "%%order_class%% .dnxt-thh-wrapper-inner",
					'declaration' => "text-align: {$thh_text_alignment};",
				));				
				break;
			case 'right':
				ET_Builder_Element::set_style($render_slug, array(
					'selector'    => "%%order_class%% .dnxt-thh-wrapper-inner",
					'declaration' => "text-align: {$thh_text_alignment};",
				));				
				break;
			case 'justify':
				ET_Builder_Element::set_style($render_slug, array(
					'selector'    => "%%order_class%% .dnxt-thh-wrapper-inner",
					'declaration' => "text-align: {$thh_text_alignment};",
				));				
				break;
			default:
				break;
		}

		// Hover Highlight Text Background Color & Gradient
		$thh_hht_color  					= '';
		$thh_hht_gradient_apply         	= '';
		$thh_hht_gradient_color_one 	 	= '';
		$thh_hht_gradient_color_two 	 	= '';
		$thh_hht_gradient_type	   		 	= '';
		$thh_hht_gl             		 	= '';
		$thh_hht_gr             		 	= '';
		$thh_hht_gradient_start_position	= '';
		$thh_hht_gradient_end_position  	= '';

		// BG Color
		if ('' !== $this->props['thh_hht_color']) {
			$thh_hht_color = $this->props['thh_hht_color'];
		}
		if ('off' !== $this->props['thh_hht_bg_color_enable']){
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt-thh-wrapper",
				'declaration' => "background-color: $thh_hht_color;",
			));
		}
		// Gradient Type
		if ('' !== $this->props['thh_hht_gradient_type']) {
			$thh_hht_gradient_type = $this->props['thh_hht_gradient_type'];
		}
		// Linear Gradient Direction
		if ('' !== $this->props['thh_hht_gradient_type_linear_direction']) {
			$thh_hht_gl = $this->props['thh_gradient_type_linear_direction'];
		}
		// Radial Gradient Direction
		if ('' !== $this->props['thh_hht_gradient_type_radial_direction']) {
			$thh_hht_gr = $this->props['thh_hht_gradient_type_radial_direction'];
		}
		// Apply gradient direcion
		if ('radial-gradient' === $this->props['thh_hht_gradient_type']) {
			$thh_hht_gradient_apply = sprintf('%1$s', $thh_hht_gr);
		} else if ('linear-gradient' === $this->props['thh_gradient_type']) {
			$thh_hht_gradient_apply = sprintf('%1$s', $thh_hht_gl);
		}
		// Gradient color one for content
		if ('' !== $this->props['thh_hht_gradient_color_one']) {
			$thh_hht_gradient_color_one = $this->props['thh_hht_gradient_color_one'];
		}
		// Gradient color two for content 
		if ('' !== $this->props['thh_hht_gradient_color_two']) {
			$thh_hht_gradient_color_two = $this->props['thh_hht_gradient_color_two'];
		}

		// Gradient color start position 
		if ('' !== $this->props['thh_hht_gradient_start_position']) {
			$thh_hht_gradient_start_position = $this->props['thh_hht_gradient_start_position'];
		}

		// Gradient color end position
		if ('' !== $this->props['thh_hht_gradient_end_position']) {
			$thh_hht_gradient_end_position = $this->props['thh_hht_gradient_end_position'];
		}
		// Gradient setting up
		if ('off' !== $this->props['thh_hht_gradient_enable']){
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt-thh-wrapper",
				'declaration' => "background: {$thh_hht_gradient_type}($thh_hht_gradient_apply, $thh_hht_gradient_color_one $thh_hht_gradient_start_position, $thh_hht_gradient_color_two $thh_hht_gradient_end_position);",
			));
		}
	}
}

new NextTextHoverHighlight;
