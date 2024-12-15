<?php

class DiviMenus_Module extends ET_Builder_Module {

	public $slug       = 'et_pb_divimenus';
	public $vb_support = 'on';

	protected $module_credits = array(
		'module_uri' => 'https://dondivi.com/',
		'author'     => 'DonDivi',
		'author_uri' => 'https://dondivi.com/',
	);

	public function init() {
		$this->name = esc_html__( 'DiviMenus', 'divimenus' );

		$this->icon_path        =  plugin_dir_path( __FILE__ ) . 'icon.svg';

		$this->child_slug      	= 'et_pb_divimenus_item';
		$this->child_item_text 	= esc_html__( 'Menu Item', 'divimenus' );	

		$this->main_css_element = '%%order_class%%';

		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content' 		=> esc_html__( 'DiviMenu', 'divimenus' ),
					'menu_button'  		=> esc_html__( 'Menu Button', 'divimenus' ),
					'mb_title'			=> esc_html__( 'Menu Button Title', 'divimenus' ),
					'menu_items' 		=> esc_html__( 'Menu Items', 'divimenus' ),						
					'mi_title'			=> esc_html__( 'Menu Items Title', 'divimenus' ),
				),
			),
			'advanced' => array(
				'toggles' => array(
					'menu_button_bg' 		=> 	esc_html__( 'Menu Button', 'divimenus' ),
					'menu_button_text' 		=> 	esc_html__( 'Menu Button TEXT', 'divimenus' ),
					'menu_button_icon' 		=> 	esc_html__( 'Menu Button ICON', 'divimenus' ),
					'menu_button_image' 	=> 	esc_html__( 'Menu Button IMAGE', 'divimenus' ),
					'mb_title' 				=> 	esc_html__( 'Menu Button Title', 'divimenus' ),
					'menu_item_bg' 			=> 	esc_html__( 'Menu Items', 'divimenus' ),
					'menu_item_text' 		=> 	esc_html__( 'Menu Items TEXT', 'divimenus' ),
					'menu_item_icon' 		=> 	esc_html__( 'Menu Items ICON', 'divimenus' ),
					'menu_item_image' 		=> 	esc_html__( 'Menu Items IMAGE', 'divimenus' ),
					'mi_title' 				=> 	esc_html__( 'Menu Items Title', 'divimenus' ),
					'alignment' 			=> 	esc_html__( 'DiviMenu Alignment', 'divimenus' ),	
					'paddings'    			=> 	esc_html__( 'Spacing', 'et_builder' ),	
				),
			),
		);

		$this->help_videos = array(
			array( 'id' => esc_html( 'tbHIQmp_RrA' ), 'name' => esc_html__( 'DiviMenus', 'divimenus' ) ),
			array( 'id' => esc_html( 'APuxo_6b7cM' ), 'name' => esc_html__( 'Introducing DiviMenus: Define the ELEMENTS', 'divimenus' ) ),
			array( 'id' => esc_html( 'gghPuSppeak' ), 'name' => esc_html__( 'Introducing DiviMenus: Define the STYLE', 'divimenus' ) ),
			array( 'id' => esc_html( '21UN7ZuS3QM' ), 'name' => esc_html__( 'Introducing DiviMenus: Define the LINKS', 'divimenus' ) ),
			array( 'id' => esc_html( 'jz-tnmLaqok' ), 'name' => esc_html__( 'Introducing DiviMenus: Define the POSITION', 'divimenus' ) ),
			array( 'id' => esc_html( 'WdfuV4d4GJ0' ), 'name' => esc_html__( 'DonDivi Extra Tool: Layouts Shortcodes', 'divimenus' ) ),			
		);		
	}

	public function get_advanced_fields_config() {
		return array(
			'background' 	=> array(
				'css'      	=> array(
					'main' 	=> "{$this->main_css_element} .dd-menu-bg",
				),
				'options' => array(
					'background_color' => array(
						'hover'    	=> false,
						'sticky' 	=> false,
					),
				),
				'use_background_mask' 		=> false,
				'use_background_pattern'	=> false,			
				'use_background_video' 		=> false		
			),
			'borders' => array(
				'default' => array(
					'depends_on'      => array( 'menu_type' ),
					'depends_show_if' => 'none',
				),
				'mb_title' => array(
					'css'      => array(
						'main' => array(
							'border_radii' =>  "{$this->main_css_element} .dd-mb-title-bg",
							'border_styles' => "{$this->main_css_element} .dd-mb-title-bg",
						),
					),
					'defaults' => array(
						'border_radii'  => 'on||||',
						'border_styles' => array( 'width' => '0px', 'color' => '#666', 'style' => 'solid' ),
					),
					'hover' 			=> false,
					'label_prefix' 		=> esc_html__('Background', 'divimenus'),
					'depends_on'    	=> array( 'mb_title_use_background' ),
					'depends_show_if' 	=> 'on',
					'toggle_slug'  		=> 'mb_title',
				),
				'title' => array(
					'css'      => array(
						'main' => array(
							'border_radii' =>  "{$this->main_css_element} .dd-title-bg",
							'border_styles' => "{$this->main_css_element} .dd-title-bg",
						),
					),
					'defaults' => array(
						'border_radii'  => 'on||||',
						'border_styles' => array( 'width' => '0px', 'color' => '#666', 'style' => 'solid' ),
					),
					'hover' 			=> false,
					'label_prefix' 		=> esc_html__('Background', 'divimenus'),
					'depends_on'    	=> array( 'tooltip_use_background' ),
					'depends_show_if' 	=> 'on',
					'toggle_slug'  		=> 'mi_title',
				),
			),
			'box_shadow' => array(		
				'default' => array(
					'label'    				=> esc_html__( 'DiviMenu Background', 'divimenus' ),
					'css' => array(
						'main' => "{$this->main_css_element} .dd-divimenu-open .dd-menu-bg",						
					),										
				),
				'central_item' => array (
					'label'    				=> esc_html__( 'Menu Button Background', 'divimenus' ),
					'css' => array( 
						'main' 	=> "{$this->main_css_element} .dd-menu-button-content",
						'hover' => "{$this->main_css_element} .dd-menu-button-content.hover, {$this->main_css_element} .dd-divimenu-open .dd-menu-button-content"											
					),
					'show_if' =>array( 'central_item_use_circle' => 'on' )
				),
				'central_item_image' => array (
					'label'    				=> esc_html__( 'Menu Button Image', 'divimenus' ),
					'css' => array(
						'main' => "{$this->main_css_element} .dd-menu-button-content img" 														
					),	
					'depends_on'    	=> array( 'central_item_select' ),
					'depends_show_if' 	=> 'central_item_image_option',				
				),
				'menu_item' => array (
					'label'    				=> esc_html__( 'Menu Items Background', 'divimenus' ),
					'css' => array(
						'main' 	=> "{$this->main_css_element} .dd-menu-item-content",
						'hover' => "{$this->main_css_element} .dd-menu-item-content.hover, {$this->main_css_element} .dd-menu-item-content.active" 														
					),				
				),
				'menu_item_image' => array (
					'label'    				=> esc_html__( 'Menu Items Image', 'divimenus' ),
					'css' => array(
						'main' => "{$this->main_css_element} .dd-menu-item-content img" 														
					),
					'depends_on'    	=> array( 'menu_item_select' ),
					'depends_show_if' 	=> 'image_option',			
				),
				'menu_button_title' => array (
					'label'    				=> esc_html__( 'Menu Button Title Background', 'divimenus' ),
					'css' => array(
						'main' => "{$this->main_css_element} .dd-mb-title-bg"													
					),	
					'depends_on'    	=> array( 'mb_title_use_background' ),
					'depends_show_if' 	=> 'on',			
				),
				'menu_item_title' => array (
					'label'    				=> esc_html__( 'Menu Items Title Background', 'divimenus' ),
					'css' => array(
						'main' => "{$this->main_css_element} .dd-title-bg"													
					),	
					'depends_on'    	=> array( 'tooltip_use_background' ),
					'depends_show_if' 	=> 'on',			
				),
			),
			'margin_padding' => array(
				'toggle_slug' 	=> 'paddings',
				'css' => array(
					'important' => 'all',
				),
			),
			'fonts' => array(
				'central_item' => array(
					'css'      				=> array(
						'main' 	=> "{$this->main_css_element} .dd-menu-button-content.dd-item .dd-text", // WA for sticky
						'hover' => "{$this->main_css_element} .dd-menu-button-content.hover .dd-text, {$this->main_css_element} .dd-divimenu-open .dd-menu-button .dd-text"
					), 
					'font_size' => array(
						'default' => '14px',
						'hover'  => false,
						'range_settings' => array(
							'min'  => '10',
							'min_limit'  => '0',
							'max'  => '32',
							'step' => '1',
						),
					),
					'text_color' => array (
						'default' => '#ffffff',
					),
					'hide_font'				=> true,
					'hide_letter_spacing'	=> true,
					'hide_line_height'		=> true,
					'hide_text_align' 		=> true,
					'hide_text_shadow'		=> true,
					'depends_show_if'     	=> 'central_item_text_option',
					'toggle_slug'     		=> 'menu_button_text',
				),
				'mb_title' => array(
					'css'      => array(
						'main' => "{$this->main_css_element} .dd-menu-button .dd-title",
						'hover' => "{$this->main_css_element} .dd-menu-button .dd-title.hover, {$this->main_css_element} .dd-divimenu-open > .dd-menu-button .dd-title", 
						'important' => 'all'
					), 
					'font_size' => array(
						'default' => '14px', 
						'hover' => false,
						'range_settings' => array(
							'min'  => '8',
							'min_limit'  => '0',
							'max'  => '24',
							'step' => '1',
						),
					),
					'line_height' => array(
						'default' 	=> '1.3em',
					),
					'hide_letter_spacing'	=> true,
					'hide_text_align' 		=> true,
					'depends_show_if'   	=> 'on',
					'toggle_slug'     		=> 'mb_title',
				),
				'menu_item' => array(
					'css'      				=> array(
						'main' 	=> "{$this->main_css_element} .dd-menu-item-content:not(.dd-custom) .dd-text",
						'hover' => "{$this->main_css_element} .dd-mi .dd-item:not(.dd-custom).hover .dd-text, {$this->main_css_element} .dd-mi .dd-item:not(.dd-custom).active .dd-text",
					), 
					'font_size' => array(
						'default' => '15px',
						'hover'  => false,
						'sticky' => false,
						'range_settings' => array(
							'min'  => '10',
							'min_limit'  => '0',
							'max'  => '32',
							'step' => '1',
						),
					),
					'text_color' => array (
						'default' => '#666666',
					),
					'hide_font'				=> true,
					'hide_letter_spacing'	=> true,
					'hide_line_height'		=> true,
					'hide_text_align' 		=> true,
					'hide_text_shadow'		=> true,
					'depends_show_if'     	=> 'text_option',
					'toggle_slug'     		=> 'menu_item_text',
				),
				'tooltip' => array(
					'css'      => array(
						'main' => "{$this->main_css_element} .dd-menu-items .dd-title",
						'hover' => "{$this->main_css_element} .dd-menu-items .dd-title.hover, {$this->main_css_element} .dd-menu-items .dd-tooltip.active .dd-title",
						'color' => "{$this->main_css_element} .dd-menu-items .dd-title, {$this->main_css_element} .dd-menu-items .dd-title a",
						'color_hover' => "{$this->main_css_element} .dd-menu-items .dd-title.hover, {$this->main_css_element} .dd-menu-items .dd-title.hover a,
							{$this->main_css_element} .dd-menu-items .dd-tooltip.active .dd-title, {$this->main_css_element} .dd-menu-items .dd-tooltip.active a",					
						'important' => 'all'
					),	
					'font_size' => array(
						'default' => '14px',
						'hover' => false,
						'range_settings' => array(
							'min'  => '8',
							'min_limit'  => '0',
							'max'  => '24',
							'step' => '1',
						),
					),
					'line_height' => array(
						'default' 	=> '1.3em',
					),
					'hide_letter_spacing'	=> true,
					'hide_text_align' 		=> true,
					'depends_show_if'   	=> 'on',
					'toggle_slug'     		=> 'mi_title',
				),				
			),
			'max_width' => false,
			'link_options' => false,
			'text' => false,
			'transform' 	=> array(
				'css'      	=> array(
					'main' 	=> "{$this->main_css_element} .dd-divimenu"
				),	
			),
		);
	}

	public function get_fields() {		
		$fonts = DiviMenusHelper::get_fonts();
		$yes_no_button_options = DiviMenusHelper::get_yes_no_button_options();
		$fields = array(
			'menu_type' => array(
				'label'           	=> esc_html__( 'DiviMenu Shape', 'divimenus' ),
				'type'            	=> 'select',
				'options'         	=> array(
					'circular' 		=> esc_html__( 'Circular', 'divimenus' ),
					'horizontal'  	=> esc_html__( 'Horizontal', 'divimenus' ),
					'vertical'  	=> esc_html__( 'Vertical', 'divimenus' )
				),
				'default' 			=> 'horizontal',
				'toggle_slug'     	=> 'main_content',
			),
			'circle_menu_items_alignment' => array(
				'label'           	=> esc_html__( 'Menu Items alignment', 'divimenus' ),
				'description'     	=> esc_html__( 'Here you can define how the Menu Items are distributed around the Menu Button.', 'divimenus' ),
				'type'            	=> 'select',
				'options'         	=> array(
					'circle' 			=> esc_html__( 'Circle', 'divimenus' ),
					'semicircle_top'  	=> esc_html__( 'Semicircle - top', 'divimenus' ),
					'semicircle_bottom' => esc_html__( 'Semicircle - bottom', 'divimenus' ),
					'semicircle_left'  	=> esc_html__( 'Semicircle - left', 'divimenus' ),
					'semicircle_right'  => esc_html__( 'Semicircle - right', 'divimenus' )
				),
				'default'			=> 'circle',
				'show_if' 			=> array( 'menu_type' => 'circular'),
				'toggle_slug'     	=> 'main_content',
			),
			'show_open' => array(
				'label'           		=> esc_html__( 'Show Opened', 'divimenus' ),
				'description'     		=> esc_html__('Here you can choose whether the DiviMenu should be open at first.', 'divimenus' ),
				'type'            		=> 'yes_no_button',
				'options'         		=> $yes_no_button_options,
				'affects' => array (
					'hide_button',
				),
				'default'				=> 'on',			
				'toggle_slug'       	=> 'main_content',			
			),
			'inside_container' => array(
				'label'           		=> esc_html__( 'Display Inline', 'divimenus' ),
				'description'     		=> esc_html__('Here you can choose whether your DiviMenu should be placed "inline" with your page content, or "over" your page content.', 'divimenus' ),
				'type'            		=> 'yes_no_button',
				'options'         		=> $yes_no_button_options,
				'default'				=> 'on',			
				'toggle_slug'       	=> 'main_content',
			),
			'adjust_container' => array(
				'label'           		=> esc_html__( 'Equal Height Open/Closed', 'divimenus' ),
				'description'     		=> DiviMenusHelper::get_description('https://dondivi.com/documentation/divimenus-doc/#dm-behavior'),
				'type'            		=> 'yes_no_button',
				'options'         		=> $yes_no_button_options,
				'default'				=> 'on',			
				'show_if'               => array ('inside_container' => 'on'),
				'toggle_slug'       	=> 'main_content',
			),
			'make_principal' => array(
				'label'           		=> esc_html__( 'Bring to Front', 'divimenus' ),
				'description'     		=> esc_html__('Check to display this DiviMenu over other columns content (DiviMenus in those other columns must have this option uncheked)', 'divimenus' ),
				'type'            		=> 'yes_no_button',
				'options'         		=> $yes_no_button_options,
				'default'				=> 'off',			
				'toggle_slug'       	=> 'main_content',
			),
			'central_item_inline_menu_position' => array(
				'label'           	=> esc_html__( 'Position', 'divimenus' ),
				'type'            	=> 'select',
				'options'         	=> array(
					'middle' 	=> esc_html__( 'Middle', 'divimenus' ),
					'first'  	=> esc_html__( 'First', 'divimenus' ),
					'last'  	=> esc_html__( 'Last', 'divimenus' )
				),
				'default'		 	=> 'first',
				'show_if_not' 		=> array( 'menu_type' => 'circular'),	
				'toggle_slug'     	=> 'menu_button',
			),
			'central_item_select' 	=> array(
				'label'           	=> esc_html__( 'Type', 'divimenus' ),
				'type'            	=> 'select',
				'options'         	=> array(
					'central_item_icon_option' 	=> esc_html__( 'Icon', 'divimenus' ),
					'central_item_image_option' => esc_html__( 'Image', 'divimenus' ),
					'central_item_text_option'  => esc_html__( 'Text', 'divimenus' )
				),
				'default'		 	=> 'central_item_icon_option',
				'affects' => array (
					'central_item_opacity',
					'central_item_image_size',
					'central_item_image_ratio',
					'central_item_icon_color',
					'central_item_icon_font_size',
					'central_item_font_family',		
					'central_item_font_options',
					'central_item_text_color',
					'central_item_font_size',
				),
				'toggle_slug'     	=> 'menu_button',
			),		
			'central_item_font_icon' 	=> array(
				'label'              	=> esc_html__( 'Icon', 'divimenus' ),
				'type'               	=> 'select_icon',
				'class'               	=> array( 'et-pb-font-icon' ),
				'show_if'     			=> array ('central_item_select' => 'central_item_icon_option' ),			
				'toggle_slug'         	=> 'menu_button',
				'hover'					=> 'tabs',
			),
			'central_item_image' => array(
				'label'              	=> esc_html__( 'Image', 'divimenus' ),
				'type'               	=> 'upload',
				'upload_button_text' 	=> esc_attr__( 'Upload an Image', 'et_builder' ),
				'choose_text'        	=> esc_attr__( 'Choose an Image', 'et_builder' ),
				'update_text'        	=> esc_attr__( 'Set As Image', 'et_builder' ),
				'hide_metadata'      	=> true,
				'default'				=> DIVIMENUS_PLACEHOLDER_IMAGE_DATA,
				'show_if'     			=> array ('central_item_select' => 'central_item_image_option' ),				
				'toggle_slug'        	=> 'menu_button',
				'description'        	=> esc_html__( 'Upload a single Image for the Menu Button. The Image will be displayed 1:1 (square) by default. You can keep the original aspect ratio from the Design tab', 'divimenus' ),
				'hover'					=> 'tabs',
			),
			'central_item_text' => array(
				'label'           	=> esc_html__( 'Text', 'divimenus' ),
				'type'            	=> 'text',
				'default'			=> 'Menu',
				'show_if'     		=> array ('central_item_select' => 'central_item_text_option' ),
				'toggle_slug'     	=> 'menu_button',
			),
			'hide_button' => array(
				'label'           		=> esc_html__( 'Hide', 'divimenus' ),
				'description'     		=> esc_html__('Here you can choose whether this DiviMenu should display only the Menu Items.', 'divimenus' ),
				'type'            		=> 'yes_no_button',
				'options'         		=> $yes_no_button_options,
				'affects' 				=> array (
					'disable_button',
				),
				'default'				=> 'off',			
				'toggle_slug'       	=> 'menu_button',
			),
			'disable_button' => array(
				'label'           		=> esc_html__( 'Disable', 'divimenus' ),
				'description'     		=> esc_html__('Here you can choose whether disable the click event on the Menu Button.', 'divimenus' ),
				'type'            		=> 'yes_no_button',
				'options'         		=> $yes_no_button_options,
				'default'				=> 'off',
				'depends_show_if' 		=> 'off',			
				'toggle_slug'       	=> 'menu_button',			
			),
			'menu_button_show_title' => array(
				'label'           		=> esc_html__( 'Show Title', 'divimenus' ),
				'description'       	=> esc_html__( 'Here you can choose whether a Title should be displayed beside the Menu Button.', 'divimenus' ),
				'type'            		=> 'yes_no_button',
				'options'         		=> $yes_no_button_options,
				'affects' 				=> array( 'mb_title_font', 'mb_title_text_color', 'mb_title_font_size', 'mb_title_line_height', 'mb_title_text_shadow' ),
				'default'				=> 'off',
				'toggle_slug'       	=> 'mb_title',
			),
			'mb_title' => array(
				'label'       		=> esc_html__( 'Menu Button Title', 'divimenus' ),
				'description' 		=> esc_html__( 'Define the Title for your Menu Button.', 'divimenus' ),
				'type'        		=> 'text',
				'default'  			=> 'Menu',
				'show_if' 			=> array ( 'menu_button_show_title' => 'on'),
				'toggle_slug' 		=> 'mb_title',
			),
			'mb_title_behavior' => array(
				'label'           	=> esc_html__( 'Display', 'divimenus' ),
				'type'            	=> 'select',
				'options'         	=> array(
					'always' => esc_html__( 'Always', 'divimenus' ),
					'hover'  => esc_html__( 'Hover', 'divimenus' ),
				),
				'default'			=> 'hover',
				'show_if' 			=> array ( 'menu_button_show_title' => 'on'),				
				'toggle_slug'       => 'mb_title',
			),
			'mb_title_clickable' => array(
				'label'           		=> esc_html__( 'Make Clickable', 'divimenus' ),
				'description'       	=> esc_html__( 'Here you can choose whether your Title should open/close the DiviMenu as well.', 'divimenus' ),
				'type'            		=> 'yes_no_button',
				'options'         		=> $yes_no_button_options,
				'default'				=> 'off',
				'show_if' 				=> array ( 'menu_button_show_title' => 'on', 'mb_title_behavior' => 'always'),
				'toggle_slug'       	=> 'mb_title',
			),
			'mb_title_display_phone' => array(
				'label'           		=> esc_html__( 'Always on Tablet / Phone', 'divimenus' ),
				'description'       	=> esc_html__( 'This will always display the Title on tablet and phones', 'divimenus' ),
				'type'            		=> 'yes_no_button',
				'options'         		=> $yes_no_button_options,
				'default'				=> 'off',
				'show_if' 				=> array ( 'menu_button_show_title' => 'on', 'mb_title_behavior' => 'hover', 'mb_title_disable_phone' => 'off'),
				'toggle_slug'       	=> 'mb_title',
			),
			'mb_title_disable_phone' => array(
				'label'           		=> esc_html__( 'Hide Title on Phone', 'divimenus' ),
				'type'            		=> 'yes_no_button',
				'options'         		=> $yes_no_button_options,
				'default'				=> 'off',
				'show_if' 				=> array ( 'menu_button_show_title' => 'on'),
				'toggle_slug'       	=> 'mb_title',
			),
			'menu_item_select' => array(
				'label' 		=> esc_html__( 'Type', 'divimenus' ),
				'type'          => 'select',
				'options'       => array(
					'icon_option' 	=> esc_html__( 'Icon', 'divimenus' ),
					'image_option'  => esc_html__( 'Image', 'divimenus' ),
					'text_option'  	=> esc_html__( 'Text', 'divimenus' )
				),
				'affects'      	=> array(
					'menu_item_opacity',
					'menu_item_image_size',
					'menu_item_icon_color',
					'menu_item_icon_font_size',

					'menu_item_font_family',
					'menu_item_font_options',
					'menu_item_text_color',
					'menu_item_font_size',
				),
				'default'		=> 'icon_option',
				'toggle_slug'   => 'menu_items',
			),
			'menu_item_font_icon' 	=> array(
				'label'              	=> esc_html__( 'Icon', 'divimenus' ),
				'type'               	=> 'select_icon',
				'class'               	=> array( 'et-pb-font-icon' ),
				'default'				=> '%%43%%', 
				'show_if'     			=> array ('menu_item_select' => 'icon_option' ),			
				'toggle_slug'         	=> 'menu_items',
			),
			'menu_item_image' => array(
				'label'             => esc_html__( 'Image', 'divimenus' ),
				'description'       => esc_html__( 'Upload a single 1:1 Image (square) for all your Menu Items.', 'divimenus' ),
				'type'              => 'upload',
				'upload_button_text'=> esc_attr__( 'Upload an image', 'et_builder' ),
				'choose_text'       => esc_attr__( 'Choose an Image', 'et_builder' ),
				'update_text'       => esc_attr__( 'Set As Image', 'et_builder' ),
				'default'  			=> DIVIMENUS_PLACEHOLDER_IMAGE_DATA,
				'show_if'   		=> array( 'menu_item_select' => 'image_option'),
				'toggle_slug'       => 'menu_items',		
			),
			'disable_items' => array(
				'label'           		=> esc_html__( 'Disable', 'divimenus' ),
				'description'     		=> esc_html__('Here you can choose whether disable the click event on the Menu Items.', 'divimenus' ),
				'type'            		=> 'yes_no_button',
				'options'         		=> $yes_no_button_options,
				'default'				=> 'off',			
				'toggle_slug'       	=> 'menu_items',
			),
			'menu_item_show_title' => array(
				'label'           		=> esc_html__( 'Show Titles', 'divimenus' ),
				'description'       	=> esc_html__( 'Here you can choose whether the Title should be displayed beside each Menu Item.', 'divimenus' ),
				'type'            		=> 'yes_no_button',
				'options'         		=> $yes_no_button_options,
				'affects' => array (
					'tooltip_disable_phone',
					'tooltip_font',
					'tooltip_text_color',
					'tooltip_font_size',
					'tooltip_line_height',
					'tooltip_text_shadow',

					'tooltip_position',
					'tooltip_padding',
					'tooltip_width',
					'tooltip_use_background',
				),
				'default'				=> 'on',
				'toggle_slug'       	=> 'mi_title',				
			),
			'tooltip_behavior' => array(
				'label'           	=> esc_html__( 'Display', 'divimenus' ),
				'type'            	=> 'select',
				'options'         	=> array(
					'always' => esc_html__( 'Always', 'divimenus' ),
					'hover'  => esc_html__( 'Hover', 'divimenus' ),
				),
				'default'			=> 'hover',
				'show_if' 			=> array ( 'menu_item_show_title' => 'on'), 				
				'toggle_slug'       => 'mi_title',
			),
			'title_clickable' => array(
				'label'           		=> esc_html__( 'Make Clickable', 'divimenus' ),
				'description'       	=> esc_html__( 'Here you can choose if your Titles should also be a link.', 'divimenus' ),
				'type'            		=> 'yes_no_button',
				'options'         		=> $yes_no_button_options,
				'default'				=> 'off',
				'show_if' 				=> array ( 'menu_item_show_title' => 'on', 'tooltip_behavior' => 'always'),
				'toggle_slug'       	=> 'mi_title',
			),
			'tooltip_display_phone' => array(
				'label'           		=> esc_html__( 'Always on Tablet / Phone', 'divimenus' ),
				'description'       	=> esc_html__( 'This will always display the titles on tablet and phones', 'divimenus' ),
				'type'            		=> 'yes_no_button',
				'options'         		=> $yes_no_button_options,
				'default'				=> 'off',
				'show_if' 				=> array ( 'menu_item_show_title' => 'on', 'tooltip_behavior' => 'hover'),
				'toggle_slug'       	=> 'mi_title',
			),
			'tooltip_disable_phone' => array(
				'label'           		=> esc_html__( 'Hide Titles on Phone', 'divimenus' ),
				'type'            		=> 'yes_no_button',
				'options'         		=> $yes_no_button_options,
				'default'				=> 'off',
				'depends_show_if' 		=> 'on', 
				'toggle_slug'       	=> 'mi_title',
			),
			'square_corners' => array(
				'label'           	=> esc_html__( 'Square Corners', 'divimenus' ),
				'description'       => esc_html__( 'Here you can choose whether the DiviMenu background edges should be square instead of rounded.', 'divimenus' ),
				'type'            	=> 'yes_no_button',
				'options'           => $yes_no_button_options,				
				'default'			=> 'off',
				'toggle_slug'          => 'background',
			),
			'central_item_use_circle' => array(
				'label'           	=> esc_html__( 'Use Background', 'divimenus' ),
				'description'      	=> esc_html__( 'Here you can choose whether the Menu Button should display within a background.', 'divimenus' ),
				'type'            	=> 'yes_no_button',
				'options'         	=> $yes_no_button_options,
				'default' 			=> 'on',
				'tab_slug'         	=> 'advanced',
				'toggle_slug'      	=> 'menu_button_bg',				
			),
			'central_item_circle_color' => array(
				'label'           	=> esc_html__( 'Background Color', 'divimenus' ),
				'type'            	=> 'color-alpha',	
				'default'			=> '#888888',
				'hover'				=> 'tabs',	
				'mobile_options'	=> true,
				'sticky'			=> true,					
				'show_if' 			=> array ( 'central_item_use_circle' => 'on'),
				'tab_slug'        	=> 'advanced',
				'toggle_slug'     	=> 'menu_button_bg',
			),
			'central_item_circle_radii' => array(
				'label'           	=> esc_html__( 'Rounded Corners', 'et_builder' ),
				'description' 		=> esc_html__('Here you can control the corner radius of this element. Enable the link icon to control all four corners at once, or disable to define custom values for each. You can use either percentages (%) or pixels (px).', 'divimenus'),
				'type'            	=> 'border-radius',
				'default'         	=> 'on|50%|50%|50%|50%',
				'show_if' 			=> array ( 'central_item_use_circle' => 'on'),
				'tab_slug'    		=> 'advanced',
				'toggle_slug'     	=> 'menu_button_bg',			
			),
			'central_item_use_circle_border' => array(
				'label'           	=> esc_html__( 'Show Border', 'divimenus' ),
				'description'       => esc_html__( 'Here you can choose whether if the Menu Button background border should display.', 'divimenus' ),
				'type'            	=> 'yes_no_button',
				'options'           => $yes_no_button_options,				
				'default'			=> 'off',
				'show_if' 			=> array ( 'central_item_use_circle' => 'on'),
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'menu_button_bg',
			),
			'central_item_circle_border_color' => array(
				'label'           	=> esc_html__( 'Border Color', 'divimenus' ),
				'type'            	=> 'color-alpha',
				'default'			=> '#666666',
				'hover'				=> 'tabs',
				'mobile_options'	=> true,
				'sticky'			=> true,
				'show_if' 			=> array ( 'central_item_use_circle' => 'on', 'central_item_use_circle_border' => 'on'),
				'tab_slug'        	=> 'advanced',
				'toggle_slug'     	=> 'menu_button_bg',
			),
			'central_item_circle_border_size' => array(
				'label'           	=> esc_html__( 'Border Width', 'et_builder' ),
				'type'            	=> 'range',
				'default'         	=> '2px',
				'fixed_unit'		=> 'px',
				'range_settings' => array(
					'min'  => '0',
					'min_limit'  => '0',
					'max'  => '30',
					'step' => '1',
				), 
				'show_if' 			=> array ( 'central_item_use_circle' => 'on', 'central_item_use_circle_border' => 'on'),
				'tab_slug'        	=> 'advanced',
				'toggle_slug'     	=> 'menu_button_bg',			
			),
			'central_item_fit_bg' => array(
				'label'           	=> esc_html__( 'Fit to Content', 'divimenus' ),
				'type'            	=> 'yes_no_button',
				'description'     	=> esc_html__( 'Here you can choose whether or not the Menu Button background should be adjusted to the text.', 'divimenus' ),
				'options'         	=> $yes_no_button_options,	
				'default'			=> 'off',
				'show_if' 			=> array ( 'central_item_select' => 'central_item_text_option', 'central_item_use_circle' => 'on'),							
				'tab_slug'        	=> 'advanced',
				'toggle_slug'     	=> 'menu_button_bg',
			),						
			'central_item_scale' => array(
				'label'           	=> esc_html__( 'Resizing Effect', 'divimenus' ),
				'description'      	=> esc_html__( 'Here you can choose whether the Menu Button should scale down when the DiviMenu is open.', 'divimenus' ),
				'type'            	=> 'yes_no_button',
				'options'         	=> $yes_no_button_options,
				'default_on_front' 	=> 'on',
				'tab_slug'         	=> 'advanced',
				'toggle_slug'      	=> 'menu_button_bg',				
			),
			'central_item_font_family' => array(
				'label'           	=> esc_html__( 'Font', 'divimenus' ),
				'type'            	=> 'select',
				'options'         	=> $fonts, 
				'default' 			=> 'Roboto Mono',
				'depends_show_if' 	=> 'central_item_text_option',
				'tab_slug'       	=> 'advanced',
				'toggle_slug'     	=> 'menu_button_text',
			),
			'central_item_font_options' => array(
				'label'             => esc_html__( 'Font Options', 'divimenus' ),
				'type'            	=> 'multiple_checkboxes',
				'options'         	=> array(
					'bold'   	=> esc_html__( 'Bold', 'divimenus' ),
					'italics'  	=> esc_html__( 'Italic', 'divimenus' ),
				),
				'depends_show_if' 	=> 'central_item_text_option',
				'tab_slug'        	=> 'advanced',
				'toggle_slug'     	=> 'menu_button_text',
			),		
			'central_item_icon_color' => array(
				'label'             => esc_html__( 'Icon Color', 'divimenus' ),
				'type'              => 'color-alpha',
				'default'			=> '#ffffff',
				'depends_show_if' 	=> 'central_item_icon_option',
				'mobile_options'	=> true,
				'hover'				=> 'tabs',
				'sticky'			=> true,
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'menu_button_icon',
			),	
			'central_item_icon_font_size' => array(
				'label'           	=> esc_html__( 'Icon Font Size', 'divimenus' ),
				'type'            	=> 'range',
				'default'         	=> '33px',
				'fixed_unit'		=> 'px',
				'mobile_options'  	=> true,
				'range_settings' => array(
					'min'  => '14',
					'min_limit'  => '0',
					'max'  => '72',
					'step' => '1',
				),	
				'depends_show_if' 	=> 'central_item_icon_option',
				'tab_slug'        	=> 'advanced',
				'toggle_slug'     	=> 'menu_button_icon',
			),
			'central_item_image_size' => array(
				'label'           	=> esc_html__( 'Image Width (px)', 'divimenus' ),
				'type'            	=> 'range',
				'range_settings' 	=> array(
					'min'  => '16',
					'min_limit'  => '0',
					'max'  => '720',
					'step' => '1',
				),
				'default'         	=> '57px',
				'fixed_unit'		=> 'px',
				'depends_show_if' 	=> 'central_item_image_option',
				'mobile_options'  	=> true,
				'tab_slug'    		=> 'advanced',
				'toggle_slug'     	=> 'menu_button_image',
			),
			'central_item_image_ratio' => array(
				'label'           	=> esc_html__( 'Aspect Ratio', 'divimenus' ),
				'type'            	=> 'select',
				'options'         	=> array(
					'square'  	=> esc_html__( 'Square (1:1)', 'divimenus' ),
					'original'	=> esc_html__( 'Original', 'divimenus' ),
				),
				'default' 			=> 'square',
				'depends_show_if' 	=> 'central_item_image_option',
				'tab_slug'       	=> 'advanced',
				'toggle_slug'     	=> 'menu_button_image',
			),
			'central_item_image_radii' => array(
				'label'           	=> esc_html__( 'Rounded Corners', 'et_builder' ),
				'type'            	=> 'border-radius',
				'default'         	=> 'on|50%|50%|50%|50%',
				'show_if' 			=> array('central_item_select' => 'central_item_image_option', 'central_item_use_circle' => 'off'),
				'tab_slug'    		=> 'advanced',
				'toggle_slug'     	=> 'menu_button_image',
			),
			'mb_title_position' => array(
				'label'           	=> esc_html__( 'Position', 'divimenus' ),
				'type'            	=> 'select',
				'options'         	=> DiviMenusHelper::get_positions(false),
				'default'           => 'bottom',
				'mobile_options'	=> true,
				'show_if' 				=> array ( 'menu_button_show_title' => 'on'),
				'toggle_slug'       => 'mb_title',
				'tab_slug'    		=> 'advanced',
			),
			'mb_title_offset' => array(
				'label'           	=> esc_html__( 'Offset', 'divimenus' ),
				'description'		=> esc_html__( 'Define the distance between the Menu Button and the Title', 'divimenus' ),
				'type'            	=> 'range',
				'default'         	=> '10px',
				'range_settings' 	=> array(
					'min'  => '0',
					'min_limit'  => '0',
					'max'  => '200',
					'step' => '1',
				),
				'fixed_unit'		=> 'px',
				'mobile_options'  	=> true,
				'show_if' 			=> array ( 'menu_button_show_title' => 'on'),
				'tab_slug'    		=> 'advanced',
				'toggle_slug'     	=> 'mb_title',
			),			
			'mb_title_width' => array(
				'label'           	=> esc_html__( 'Max Width', 'divimenus' ),
				'description'     	=> esc_html__( 'Here you can determine where the text overflows and continues on a new line.', 'divimenus' ),
				'type'            	=> 'range',	
				'default'         	=> '200px',
				'range_settings' 	=> array(
					'min'  => '20',
					'min_limit'  => '0',
					'max'  => '720',
					'step' => '1',
				),
				'fixed_unit'		=> 'px',
				'mobile_options'  	=> true,
				'show_if' 			=> array ( 'menu_button_show_title' => 'on'),
				'tab_slug'    		=> 'advanced',
				'toggle_slug'     	=> 'mb_title',				
			),
			'mb_title_use_background' => array(
				'label'           	=> esc_html__( 'Use Background', 'divimenus' ),
				'description'       => esc_html__( 'Here you can choose whether the Menu Button Title background should display.', 'divimenus' ),
				'type'            	=> 'yes_no_button',
				'options'           => $yes_no_button_options,		
				'affects' 			=> array(
					'mb_title_background',
					'mb_title_padding',
				),		
				'default'			=> 'off',
				'show_if' 			=> array ( 'menu_button_show_title' => 'on'),
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'mb_title',
			),
			'mb_title_background' => array(
				'label'             => esc_html__( 'Background Color', 'divimenus' ),
				'type'              => 'color-alpha',
				'default'			=> '#fff',
				'hover'				=> 'tabs',
				'mobile_options'	=> true,
				'sticky'			=> true,
				'depends_show_if' 	=> 'on',
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'mb_title',
			),
			'mb_title_padding' => array(
				'label'             => esc_html__( 'Background Padding', 'divimenus' ),
				'type'            	=> 'custom_padding',
				'default'         	=> '0px|0px|0px|0px',
				'mobile_options'    => true,
				'sticky'			=> true, 
				'depends_show_if' 	=> 'on',
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'mb_title',
			),
			'central_item_opacity' => array(
				'label'           	=> esc_html__( 'Opacity Effect', 'divimenus' ),
				'description'      	=> esc_html__( 'Here you can choose whether the Menu Button image should be lighter when either hovered or the DiviMenu is open.', 'divimenus' ),
				'type'            	=> 'yes_no_button',
				'options'         	=> $yes_no_button_options,
				'default_on_front' 	=> 'on',
				'depends_show_if' 	=> 'central_item_image_option',
				'tab_slug'         	=> 'advanced',
				'toggle_slug'      	=> 'menu_button_image',				
			),
			'menu_item_circle_color' => array(
				'label'           	=> esc_html__( 'Background Color', 'divimenus' ),
				'type'            	=> 'color-alpha',	
				'default'			=> '#dfdfdf',
				'hover'				=> 'tabs',
				'mobile_options'	=> true,
				'sticky'			=> true,							
				'tab_slug'        	=> 'advanced',
				'toggle_slug'     	=> 'menu_item_bg',
			),
			'menu_item_circle_radii' => array(
				'label'           	=> esc_html__( 'Rounded Corners', 'et_builder' ),
				'description' 		=> esc_html__('Here you can control the corner radius of this element. Enable the link icon to control all four corners at once, or disable to define custom values for each. You can use either percentages (%) or pixels (px).', 'divimenus'),
				'type'            	=> 'border-radius',
				'default'  			=> 'on|50%|50%|50%|50%',
				'tab_slug'    		=> 'advanced',
				'toggle_slug'     	=> 'menu_item_bg',			
			),
			'menu_item_use_circle_border' => array(
				'label'           	=> esc_html__( 'Show Border', 'divimenus' ),
				'description'       => esc_html__( 'Here you can choose whether if the Menu Items border should display.', 'divimenus' ),
				'type'            	=> 'yes_no_button',
				'options'           => $yes_no_button_options,
				'default'			=> 'off',
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'menu_item_bg',				
			),
			'menu_item_circle_border_color' => array(
				'label'           	=> esc_html__( 'Border Color', 'divimenus' ),
				'type'            	=> 'color-alpha',
				'default'			=> '#666666',
				'show_if' 			=> array ( 'menu_item_use_circle_border' => 'on'),
				'hover'				=> 'tabs',
				'mobile_options'	=> true,
				'sticky'			=> true,
				'tab_slug'        	=> 'advanced',
				'toggle_slug'     	=> 'menu_item_bg',
			),
			'menu_item_circle_border_size' => array(
				'label'           	=> esc_html__( 'Border Width', 'divimenus' ),
				'type'            	=> 'range',
				'default'         	=> '2px',
				'fixed_unit'		=> 'px',
				'range_settings' => array(
					'min'  => '0',
					'min_limit'  => '0',
					'max'  => '30',
					'step' => '1',
				),
				'hover'				=> 'tabs',
				'show_if' 			=> array ( 'menu_item_use_circle_border' => 'on'),
				'tab_slug'        	=> 'advanced',
				'toggle_slug'     	=> 'menu_item_bg',			
			),
			'menu_item_equal_size' => array(
				'label'           		=> esc_html__( 'Equal Backgrounds', 'divimenus' ),
				'description'     		=> esc_html__('Here you can choose whether all the text Menu Items background should be equal.', 'divimenus' ),
				'type'            		=> 'yes_no_button',
				'options'         		=> $yes_no_button_options,
				'default'				=> 'on',
				'show_if'				=>  array ('menu_item_select' => 'text_option' ),
				'tab_slug'    			=> 'advanced',			
				'toggle_slug'       	=> 'menu_item_bg',
			),
			'menu_item_fit_bg' => array(
				'label'           	=> esc_html__( 'Fit to Content', 'divimenus' ),
				'type'            	=> 'yes_no_button',
				'description'     	=> esc_html__( 'Here you can choose whether or not the Menu Item background should be adjusted to the text.', 'divimenus' ),
				'options'         	=> $yes_no_button_options,	
				'default'			=> 'off',
				'show_if'			=> array('menu_item_select' => 'text_option'),	
				'show_if_not'		=> array('menu_type' => 'circular'),					
				'tab_slug'        	=> 'advanced',
				'toggle_slug'     	=> 'menu_item_bg',
			),
			'menu_item_font_family' => array(
				'label'           	=> esc_html__( 'Font', 'divimenus' ),
				'type'            	=> 'select',
				'options'         	=> $fonts,
				'default' 			=> 'Roboto Mono',
				'depends_show_if' 	=> 'text_option',
				'tab_slug'       	=> 'advanced',
				'toggle_slug'     	=> 'menu_item_text',
			),
			'menu_item_font_options' => array(
				'label'             => esc_html__( 'Font Options', 'divimenus' ),
				'type'            	=> 'multiple_checkboxes',
				'options'         	=> array(
					'bold'   	=> esc_html__( 'Bold', 'divimenus' ),
					'italics'  	=> esc_html__( 'Italic', 'divimenus' ),
				),
				'depends_show_if' 	=> 'text_option',
				'tab_slug'        	=> 'advanced',
				'toggle_slug'     	=> 'menu_item_text',
			),
			'menu_item_icon_color' => array(
				'label'             => esc_html__( 'Icon Color', 'divimenus' ),
				'type'              => 'color-alpha',
				'default'			=> '#666666',
				'depends_show_if' 	=> 'icon_option',
				'hover'				=> 'tabs',
				'mobile_options'	=> true,
				'sticky'			=> true,
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'menu_item_icon',
			),	
			'menu_item_icon_font_size' => array(
				'label'           	=> esc_html__( 'Icon Font Size', 'divimenus' ),
				'type'            	=> 'range',
				'default'         	=> '33px',
				'fixed_unit'  		=> 'px',
				'mobile_options'  	=> true,
				'range_settings' => array(
					'min'  => '14',
					'min_limit'  => '0',
					'max'  => '72',
					'step' => '1',
				),
				'depends_show_if' 	=> 'icon_option',
				'tab_slug'        	=> 'advanced',
				'toggle_slug'     	=> 'menu_item_icon',
			),
			'menu_item_image_size' => array(
				'label'           	=> esc_html__( 'Image Width (px)', 'divimenus' ),
				'type'            	=> 'range',
				'default_on_front'  => '57px',
				'fixed_unit'  		=> 'px',
				'mobile_options'  	=> true,
				'range_settings' 	=> array(
					'min'  => 16,
					'min_limit'  => 0,
					'max'  => 720,
					'step' => 1,
				),
				'depends_show_if' 	=> 'image_option',
				'tab_slug'    		=> 'advanced',
				'toggle_slug'     	=> 'menu_item_image',
			),
			'menu_item_opacity' => array(
				'label'           	=> esc_html__( 'Opacity Effect', 'divimenus' ),
				'description'      	=> esc_html__( 'Here you can choose whether the Menu Item image should be lighter when hovered.', 'divimenus' ),
				'type'            	=> 'yes_no_button',
				'options'         	=> $yes_no_button_options,
				'default_on_front' 	=> 'off',
				'depends_show_if' 	=> 'image_option',
				'tab_slug'         	=> 'advanced',
				'toggle_slug'      	=> 'menu_item_image',				
			),
			'tooltip_position' => array(
				'label'           	=> esc_html__( 'Position', 'divimenus' ),
				'type'            	=> 'select',
				'options'         	=> DiviMenusHelper::get_positions(false),
				'default'           => 'bottom',
				'mobile_options'	=> true,
				'depends_show_if' 	=> 'on', 
				'toggle_slug'       => 'mi_title',
				'tab_slug'    		=> 'advanced',
			),
			'tooltip_padding' => array(
				'label'           	=> esc_html__( 'Offset', 'divimenus' ),
				'description'		=> esc_html__( 'Define the distance between the Menu Item and the Title', 'divimenus' ),
				'type'            	=> 'range',
				'default'         	=> '10px',
				'range_settings' 	=> array(
					'min'  => '0',
					'min_limit'  => '0',
					'max'  => '200',
					'step' => '1',
				),
				'fixed_unit'		=> 'px',
				'mobile_options'  	=> true,
				'depends_show_if' 	=> 'on',
				'tab_slug'    		=> 'advanced',
				'toggle_slug'     	=> 'mi_title',
			),			
			'tooltip_width' => array(
				'label'           	=> esc_html__( 'Max Width', 'divimenus' ),
				'description'     	=> esc_html__( 'Here you can determine where the text overflows and continues on a new line.', 'divimenus' ),
				'type'            	=> 'range',	
				'default'         	=> '200px',
				'range_settings' 	=> array(
					'min'  => '20',
					'min_limit'  => '0',
					'max'  => '720',
					'step' => '1',
				),
				'fixed_unit'		=> 'px',
				'mobile_options'  	=> true,
				'depends_show_if' 	=> 'on',
				'tab_slug'    		=> 'advanced',
				'toggle_slug'     	=> 'mi_title',			
			),
			'tooltip_use_background' => array(
				'label'           	=> esc_html__( 'Use Background', 'divimenus' ),
				'description'       => esc_html__( 'Here you can choose whether the Menu Item Title background should display.', 'divimenus' ),
				'type'            	=> 'yes_no_button',
				'options'           => $yes_no_button_options,		
				'affects' 			=> array(
					'tooltip_background',
					'title_padding',
				),		
				'default'			=> 'off',
				'depends_show_if' 	=> 'on',
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'mi_title',
			),
			'tooltip_background' => array(
				'label'             => esc_html__( 'Background Color', 'divimenus' ),
				'type'              => 'color-alpha',
				'default'			=> '#fff',
				'hover'				=> 'tabs',
				'mobile_options'	=> true,
				'sticky'			=> true,
				'depends_show_if' 	=> 'on',
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'mi_title',
			),
			'title_padding' => array(
				'label'             => esc_html__( 'Background Padding', 'divimenus' ),
				'type'            	=> 'custom_padding',
				'default'         	=> '0px|0px|0px|0px',
				'mobile_options'    => true,
				'sticky'			=> true, 
				'depends_show_if' 	=> 'on',
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'mi_title',
			),
			'menu_alignment' => array(
				'label'           	=> esc_html__( 'DiviMenu Alignment', 'divimenus' ),
				'description'     	=> esc_html__( 'Choose the DiviMenu alignment (Please note that the Menu Button position (First, Middle or Last) affects the horizontal DiviMenus alignment)', 'divimenus' ),
				'type'            	=> 'text_align',
				'options'         	=> et_builder_get_text_orientation_options(),
				'default'			=> 'justified',
				'tab_slug'        	=> 'advanced',
				'toggle_slug'     	=> 'alignment',
				'options_icon'    	=> 'module_align',
			),
			'center_menu_button' => array(
				'label'           		=> esc_html__( 'Justify Closed DiviMenu', 'divimenus' ),
				'description'     		=> esc_html__( 'Here you can choose whether the Menu Button should be centered when the DiviMenu is closed.', 'divimenus' ),
				'type'            		=> 'yes_no_button',
				'options'         		=> $yes_no_button_options,
				'default'				=> 'off',
				'show_if'				=>  array ('menu_alignment' => 'justified' ),
				'tab_slug'    			=> 'advanced',			
				'toggle_slug'       	=> 'alignment',			
			),			
			'menu_item_distance' => array(
				'label'           	=> esc_html__( 'DiviMenu Opening', 'divimenus' ),
				'description'     	=> esc_html__( 'Here you can define the distance between the Menu Button and the Menu Items.', 'divimenus' ),	
				'type'            	=> 'range',
				'default'         	=> 25, 
				'fixed_unit'		=> 'px',
				'range_settings' 	=> array(
					'min'  	=> '0',
					'min_limit' => '0',
					'max'  	=> '100',
					'step' 	=> '1',
				),
				'mobile_options'  	=> true,
				'tab_slug'       	=> 'advanced',
				'toggle_slug'     	=> 'paddings',						
			),			
			'central_item_bg_padding' => array(
				'label'           	=> esc_html__( 'Menu Button Background', 'divimenus' ),
				'description'     	=> esc_html__( 'Here you can define the Menu Button background padding.', 'divimenus' ),
				'type'            	=> 'range',
				'default'         	=> '15px',
				'range_settings' 	=> array(
					'min'  	=> '0',
					'min_limit' => '0',
					'max'  	=> '100',
					'step' 	=> '1',
				),
				'fixed_unit'     	=> 'px',
				'mobile_options'  	=> true,
				'tab_slug'       	=> 'advanced',
				'toggle_slug'     	=> 'paddings',			
			),
			'item_padding' => array(
				'label'           	=> esc_html__( 'Menu Item Background', 'divimenus' ),
				'description'     	=> esc_html__( 'Here you can define the Menu Item background padding.', 'divimenus' ),
				'type'            	=> 'range',
				'default'         	=> '15px',
				'range_settings' 	=> array(
					'min'  => '0',
					'min_limit'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'fixed_unit'     	=> 'px',
				'mobile_options'  	=> true,
				'tab_slug'       	=> 'advanced',
				'toggle_slug'     	=> 'paddings',
			),
			'background_padding' => array(
				'label'           	=> esc_html__( 'DiviMenu Background', 'divimenus' ),
				'description'     	=> esc_html__( 'Here you can define the background padding.', 'divimenus' ),
				'type'            	=> 'range',
				'default'         	=> '10px',
				'range_settings' 	=> array(
					'min'  => '0',
					'min_limit'  => '0',
					'max'  => '50',
					'step' => '1',
				),
				'fixed_unit'		=> 'px',
				'depends_on'		=> array('background_color', 'background_image', 'use_background_color_gradient' ),
				'depends_show_if_not'	=> array('', 'off'),
				'mobile_options'  	=> true,
				'tab_slug'       	=> 'advanced',
				'toggle_slug'     	=> 'paddings'						
			)
		);
		$fields['hover_click'] = DiviMenusHelper::get_hover_click_field('menu_button');
		$fields['mb_alt'] = DiviMenusHelper::get_alt_field('central_item_select', 'central_item_image_option', esc_html__('Menu Button Image Alt Text') ); 
		return $fields;
	}

	private function get_border_radii($radii) {
		$radii = str_replace(array('on|', 'off|'), '', $radii);
		$output = '50%';
		if ($radii !== '' && strpos($radii, '|') !== false) {
			$values = explode('|', $radii);
			$output = sprintf('%1$s %2$s %3$s %4$s;', 
				$values[0] !== '' ? $values[0] : '50%', 
				count($values) > 1 && $values[1] !== '' ? $values[1] : '50%', 
				count($values) > 2 && $values[2] !== '' ? $values[2] : '50%', 
				count($values) > 3 && $values[3] !== '' ? $values[3] : '50%');		
		} 
		return $output;
	}

	private function titles_hover_enabled($elem) {
		return ($elem === 'mi' ? 
			et_builder_is_hover_enabled( 'tooltip_text_color', $this->props ) || et_builder_is_hover_enabled( 'tooltip_line_height', $this->props ) || et_builder_is_hover_enabled( 'tooltip_background', $this->props ) :
			et_builder_is_hover_enabled( 'mb_title_text_color', $this->props ) || et_builder_is_hover_enabled( 'mb_title_line_height', $this->props ) || et_builder_is_hover_enabled( 'mb_title_background', $this->props ));
	}

	public function before_render() {
		DiviMenusHelper::set_values($this->props);

		global $et_pb_divimenus_items, $et_pb_divimenus_item_num;

		$et_pb_divimenus_items = array();
		$et_pb_divimenus_item_num = 0;

		global $et_pb_divimenus_render_on_tablet, $et_pb_divimenus_render_on_phone;
		$et_pb_divimenus_render_on_tablet	= true;
		$et_pb_divimenus_render_on_phone	= true;
		if (!empty($this->props['disabled_on'])) {
			$disabled_on = explode('|', $this->props['disabled_on']);
			if (count($disabled_on) === 3) {
				$et_pb_divimenus_render_on_tablet 	= !($disabled_on[1] === 'on');
				$et_pb_divimenus_render_on_phone 	= !($disabled_on[0] === 'on'); 
			}
		}
	
		global $et_pb_divimenus;

		$items_icon_font_size_responsive = et_pb_get_responsive_status( $this->props['menu_item_icon_font_size_last_edited'] );
		$items_font_size_responsive = et_pb_get_responsive_status( $this->props['menu_item_font_size_last_edited'] );
		$items_image_width_responsive = et_pb_get_responsive_status( $this->props['menu_item_image_size_last_edited'] );
		$items_padding_responsive = et_pb_get_responsive_status( $this->props['item_padding_last_edited'] );

		$et_pb_divimenus = array(
			'disable_items' 					=> $this->props['disable_items'],
			'item_padding' 						=> $this->props['item_padding'],
			'item_padding_tablet' 				=> $items_padding_responsive ? $this->props['item_padding_tablet'] : $this->props['item_padding'],
			'item_padding_phone' 				=> $items_padding_responsive ? $this->props['item_padding_phone'] : $this->props['item_padding'],
			'menu_item_border_size'				=> $this->props['menu_item_circle_border_size'],
			'menu_item_fit_bg'					=> $this->props['menu_item_fit_bg'],
			'menu_item_font_icon'				=> $this->props['menu_item_font_icon'],
			'menu_item_font_size' 				=> $this->props['menu_item_font_size'],
			'menu_item_font_size_tablet' 		=> $items_font_size_responsive ? $this->props['menu_item_font_size_tablet'] : $this->props['menu_item_font_size'],
			'menu_item_font_size_phone' 		=> $items_font_size_responsive ? $this->props['menu_item_font_size_phone'] : $this->props['menu_item_font_size'],
			'menu_item_font_family' 	    	=> $this->props['menu_item_font_family'],
			'menu_item_icon_font_size' 			=> $this->props['menu_item_icon_font_size'],
			'menu_item_icon_font_size_tablet' 	=> $items_icon_font_size_responsive ? $this->props['menu_item_icon_font_size_tablet'] : $this->props['menu_item_icon_font_size'],
			'menu_item_icon_font_size_phone' 	=> $items_icon_font_size_responsive ? $this->props['menu_item_icon_font_size_phone'] : $this->props['menu_item_icon_font_size'],		
			'menu_item_image'					=> $this->props['menu_item_image'],
			'menu_item_image_size'				=> $this->props['menu_item_image_size'],
			'menu_item_image_size_tablet'		=> $items_image_width_responsive ? $this->props['menu_item_image_size_tablet'] : $this->props['menu_item_image_size'],
			'menu_item_image_size_phone'		=> $items_image_width_responsive ? $this->props['menu_item_image_size_phone'] : $this->props['menu_item_image_size'],
			'menu_item_select' 					=> $this->props['menu_item_select'],
			'menu_item_show_title' 				=> $this->props['menu_item_show_title'],
			'menu_type' 						=> $this->props['menu_type'],
			'title_clickable'					=> $this->props['title_clickable'],
			'titles_hover_enabled'				=> $this->titles_hover_enabled('mi'),
			'tooltip_behavior' 					=> $this->props['tooltip_behavior'],
			'tooltip_use_background' 			=> $this->props['tooltip_use_background'],
			'use_circle_border'					=> $this->props['menu_item_use_circle_border'],
		);
	}

	public function get_transition_fields_css_props() {
		$fields = parent::get_transition_fields_css_props();
	
		$fields['tooltip_background'] = array(
			'background-color' => '%%order_class%% .dd-title',
		);	
		$fields['mb_title_background'] = array(
			'background-color' => '%%order_class%% .dd-title',
		);

		return $fields;
	}

	public function render( $attrs, $content, $render_slug ) {

		wp_enqueue_script( 'divimenus' );
		
		$mb_text			= '' === trim($this->props['central_item_text']) ? 'Menu' : trim($this->props['central_item_text']);
		$circular_type		= $this->props['circle_menu_items_alignment'];
		$menu_ali 			= $this->props['menu_alignment'];
		$menu_type			= $this->props['menu_type'];
		$menu_item_type		= $this->props['menu_item_select'];
		$transition 		= apply_filters('dd_divimenu_transition', 'on' === $this->props['show_open'] && ('on' === $this->props['hide_button'] || 'on' === $this->props['disable_button']) ? 0 : 300, $this->props);

		global $et_pb_divimenus, $et_pb_divimenus_items, $et_pb_divimenus_item_num, $et_pb_divimenus_render_on_phone, $et_pb_divimenus_render_on_tablet;

		if ( $menu_item_type === 'text_option' && $this->props['menu_item_equal_size'] === 'on') {
			$largest_padding = DiviMenusHelper::get_largest_padding($et_pb_divimenus_items, 'desktop');
			$largest_padding_t = DiviMenusHelper::get_largest_padding($et_pb_divimenus_items, 'tablet');
			$largest_padding_p = DiviMenusHelper::get_largest_padding($et_pb_divimenus_items, 'phone');
			if ($largest_padding)
				DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-menu-item .dd-circle', sprintf('width: %1$spx!important;height: %2$spx!important;', $largest_padding['LR'], $largest_padding['TB']) );	
			if ($largest_padding_t && $et_pb_divimenus_render_on_tablet)
				DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-menu-item .dd-circle', sprintf('width: %1$spx!important;height: %2$spx!important;', $largest_padding_t['LR'], $largest_padding_t['TB'] ), 't' );
			if ($largest_padding_p && $et_pb_divimenus_render_on_phone) 
				DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-menu-item .dd-circle', sprintf('width: %1$spx!important;height: %2$spx!important;', $largest_padding_p['LR'], $largest_padding_p['TB'] ), 'p' );
			foreach ($et_pb_divimenus_items as &$item) {
				$item['size'] = DiviMenusHelper::get_menu_item_size('text_option', null, $largest_padding, $item['use_custom'], $item['use_border'], $item['border_size']);
				$item['size_t'] = DiviMenusHelper::get_menu_item_size('text_option', null, $largest_padding_t, $item['use_custom'], $item['use_border'], $item['border_size']);
				$item['size_p'] = DiviMenusHelper::get_menu_item_size('text_option', null, $largest_padding_p, $item['use_custom'], $item['use_border'], $item['border_size']);
			}
			unset($item);
		}
		
		$itemsa = DiviMenusHelper::get_items_array($et_pb_divimenus_items);
		$itemsc = DiviMenusHelper::get_items_count($itemsa);
		
		if ($this->props['central_item_select'] === 'central_item_icon_option' ) {
			
			$this->generate_styles(
				array(
					'base_attr_name' => 'central_item_icon_font_size',
					'selector'       => '%%order_class%% .dd-menu-button .dd-icon-content',
					'css_property'   => 'font-size',
					'sticky'         => false,
					'render_slug'    => $render_slug,
				)
			);
			$this->generate_styles(
				array(
					'base_attr_name' => 'central_item_icon_color',
					'selector'       => '%%order_class%% .dd-menu-button .dd-icon-content',
					'hover_selector' => '%%order_class%% .dd-divimenu-open .dd-menu-button .dd-icon-content, %%order_class%% .dd-menu-button .dd-icon-content.hover',
					'css_property'   => 'color',
					'render_slug'    => $render_slug,
					'type'           => 'color',
				)
			);
		}
		if ($this->props['central_item_select'] === 'central_item_image_option' ) {
			$width_values = et_pb_responsive_options()->get_property_values( $this->props, 'central_item_image_size' );	 
			$width_responsive_active = et_pb_get_responsive_status( $this->props['central_item_image_size_last_edited'] );

			$height_values = array(
				'desktop' => $this->props['central_item_image_height'] === '0' ? '0px' : $this->props['central_item_image_height'],
				'tablet'  => $width_responsive_active ? ( $this->props['central_item_image_height_t'] === '0' ? '0px' : $this->props['central_item_image_height_t'] ) : '',
				'phone'   => $width_responsive_active ? ( $this->props['central_item_image_height_p'] === '0' ? '0px' : $this->props['central_item_image_height_p'] ) : '',
			);
			et_pb_responsive_options()->generate_responsive_css( $width_values, '%%order_class%% .dd-menu-button-content img', 'width', $render_slug );
			et_pb_responsive_options()->generate_responsive_css( $height_values, '%%order_class%% .dd-menu-button-content img', 'height', $render_slug );
		}
		if ($this->props['central_item_select'] === 'central_item_text_option' ) {
			$bold = ''; $italics = '';
			if (!empty($this->props['central_item_font_options'])) {
				$font_options = explode('|', $this->props['central_item_font_options']);
				if ($font_options[0] === 'on') $bold = 'font-weight: bold;';
				if ($font_options[1] === 'on') $italics ='font-style: italic;';
			}
			et_builder_enqueue_font( $this->props['central_item_font_family'] );
			
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => sprintf('%%order_class%% .dd-menu-button .dd-text'), 
				'declaration' => sprintf('font-family: \'%1$s\', monospace;%2$s%3$s', esc_html( $this->props['central_item_font_family']), $bold, $italics),
			) );
		}
		
		$mb_content_size = DiviMenusHelper::get_menu_button_content_size( $this->props['central_item_select'], 'desktop', $this->props); 
		$mb_content_size_t = DiviMenusHelper::get_menu_button_content_size( $this->props['central_item_select'], 'tablet', $this->props); 
		$mb_content_size_p = DiviMenusHelper::get_menu_button_content_size( $this->props['central_item_select'], 'phone', $this->props);

		$padding_responsive = et_pb_get_responsive_status( $this->props['central_item_bg_padding_last_edited'] );	
		$padding = DiviMenusHelper::get_value($this->props['central_item_bg_padding'], 15); 
		$padding_t = DiviMenusHelper::get_value($padding_responsive ? $this->props['central_item_bg_padding_tablet'] : $padding, $padding); 
		$padding_p = DiviMenusHelper::get_value($padding_responsive ? $this->props['central_item_bg_padding_phone'] : $padding, $padding_t); 
	
		$mb_padding = DiviMenusHelper::get_menu_button_padding($this->props, $mb_text, $this->props['central_item_font_family'], $mb_content_size, $padding);
		$mb_padding_t = DiviMenusHelper::get_menu_button_padding($this->props, $mb_text, $this->props['central_item_font_family'], $mb_content_size_t, $padding_t);
		$mb_padding_p = DiviMenusHelper::get_menu_button_padding($this->props, $mb_text, $this->props['central_item_font_family'], $mb_content_size_p, $padding_p);			

		if ('on' === $this->props['central_item_use_circle']) {
			DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-menu-button-content, %%order_class%% .dd-menu-button-content img', sprintf('border-radius: %1$s;', $this->get_border_radii($this->props['central_item_circle_radii'])) );
			
			$this->generate_styles(
				array(
					'base_attr_name' => 'central_item_circle_color',
					'selector'       => '%%order_class%% .dd-menu-button-content',
					'hover_selector' => '%%order_class%% .dd-divimenu-open .dd-menu-button-content, %%order_class%% .dd-menu-button-content.hover',
					'css_property'   => 'background-color',
					'render_slug'    => $render_slug,
					'type'           => 'color',
				)
			);
		} else if ($this->props['central_item_select'] === 'central_item_image_option') {
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => '%%order_class%% .dd-menu-button-content, %%order_class%% .dd-menu-button-content img', 
				'declaration' => sprintf('border-radius: %1$s;', $this->get_border_radii($this->props['central_item_image_radii']) )	 
			) );
		}

		if ('on' === $this->props['central_item_use_circle'] && $this->props['central_item_select'] !== 'central_item_text_option') {
			DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-menu-button-content', sprintf('padding: %1$spx;', $mb_padding['LR'] ) ); 
			if ($et_pb_divimenus_render_on_tablet)
				DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-menu-button-content', sprintf('padding: %1$spx;', $mb_padding_t['LR'] ), 't'); 
			if ($et_pb_divimenus_render_on_phone)
				DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-menu-button-content', sprintf('padding: %1$spx;', $mb_padding_p['LR'] ), 'p'); 
		}

		if ('on' === $this->props['central_item_use_circle'] && $this->props['central_item_select'] === 'central_item_text_option') {
			DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-menu-button .dd-circle', sprintf('width: %1$spx; height: %2$spx;', $mb_padding['LR'], $mb_padding['TB'] ));
			if ($et_pb_divimenus_render_on_tablet)
				DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-menu-button .dd-circle', sprintf(' width: %1$spx; height: %2$spx;', $mb_padding_t['LR'], $mb_padding_t['TB'] ), 't');
			if ($et_pb_divimenus_render_on_phone)
				DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-menu-button .dd-circle', sprintf(' width: %1$spx; height: %2$spx;', $mb_padding_p['LR'], $mb_padding_p['TB'] ), 'p');	 
		}

		if ('on' === $this->props['central_item_use_circle'] && 'on' === $this->props['central_item_use_circle_border']) {
			$this->generate_styles(
				array(
					'base_attr_name' => 'central_item_circle_border_color',
					'selector'       => '%%order_class%% .dd-menu-button-content',
					'hover_selector' => '%%order_class%% .dd-divimenu-open .dd-menu-button-content, %%order_class%% .dd-menu-button-content.hover',
					'css_property'   => 'border-color',
					'render_slug'    => $render_slug,
					'type'           => 'color',
				)
			);
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => '%%order_class%% .dd-menu-button-content',
				'declaration' => sprintf('border-width: %1$s; border-radius: %2$s', 
					esc_html( $this->props['central_item_circle_border_size'] ) , $this->get_border_radii($this->props['central_item_circle_radii'])
				),
			) );
		}

		ET_Builder_Element::set_style( $render_slug, array(
			'selector'    => '%%order_class%% .dd-divimenu-open .dd-menu-item',
			'declaration' => 'visibility: visible; opacity: 1;'
			)
		);
		if ($menu_item_type === 'icon_option' ) {
			$font_size_values = et_pb_responsive_options()->get_property_values( $this->props, 'menu_item_icon_font_size' );	 
			et_pb_responsive_options()->generate_responsive_css( $font_size_values, '%%order_class%% .dd-menu-item-content.dd-icon-content', 'font-size', $render_slug );
			$this->generate_styles(
				array(
					'base_attr_name' => 'menu_item_icon_color',
					'selector'       => '%%order_class%% .dd-menu-item-content.dd-icon-content:not(.dd-custom)',
					'hover_selector' => '%%order_class%% .dd-mi .dd-item.dd-icon-content.hover:not(.dd-custom), %%order_class%% .dd-mi .dd-item.dd-icon-content.active:not(.dd-custom)',
					'css_property'   => 'color',
					'render_slug'    => $render_slug,
					'type'           => 'color',
				)
			);
		}
		if ($menu_item_type === 'image_option' ) {
			$width_values = et_pb_responsive_options()->get_property_values( $this->props, 'menu_item_image_size' );
			et_pb_responsive_options()->generate_responsive_css( $width_values, '%%order_class%% .dd-menu-item-content:not(.dd-custom) img', 'width', $render_slug );
			et_pb_responsive_options()->generate_responsive_css( $width_values, '%%order_class%% .dd-menu-item-content:not(.dd-custom) img', 'height', $render_slug );
		}		
		if ($menu_item_type === 'text_option' ) {
			$bold = ''; $italics = '';
			if (!empty($this->props['menu_item_font_options'])) {
				$font_options = explode('|', $this->props['menu_item_font_options']);
				if ($font_options[0] === 'on') $bold ='font-weight: bold;';
				if ($font_options[1] === 'on') $italics = 'font-style: italic;';
			}
			et_builder_enqueue_font( $this->props['menu_item_font_family'] );

			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => sprintf('%%order_class%% .dd-menu-item:not(.dd-custom) .dd-text'), 
				'declaration' => sprintf('font-family: \'%1$s\', monospace;%2$s%3$s', esc_html( $this->props['menu_item_font_family']), $bold, $italics),
			) );
		}
		
		ET_Builder_Element::set_style( $render_slug, array(
			'selector'    => '%%order_class%% .dd-menu-item-content', 
			'declaration' => sprintf('transition: transform %1$dms cubic-bezier(0.935, 0.000, 0.340, 1.330), background-color %2$s %3$s %4$s, border %2$s %3$s %4$s, color %2$s %3$s %4$s;', 
				$transition,
				esc_html($this->props['hover_transition_duration']),
				esc_html($this->props['hover_transition_speed_curve']),
				esc_html($this->props['hover_transition_delay']) 
			),
		) );	

		$this->generate_styles(
			array(
				'base_attr_name' => 'menu_item_circle_color',
				'selector'       => '%%order_class%% .dd-menu-item-content:not(.dd-custom)',
				'hover_selector' => '%%order_class%% .dd-mi .dd-item:not(.dd-custom).hover, %%order_class%% .dd-mi .dd-item:not(.dd-custom).active',
				'css_property'   => 'background-color',
				'render_slug'    => $render_slug,
				'type'           => 'color',
			)
		);
		
		DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-menu-item-content, %%order_class%% .dd-menu-item-content img', sprintf('border-radius: %1$s;', $this->get_border_radii($this->props['menu_item_circle_radii'])));

		if ($this->props['menu_item_use_circle_border'] === 'on') {
			$this->generate_styles(
				array(
					'base_attr_name' => 'menu_item_circle_border_color',
					'selector'       => '%%order_class%% .dd-menu-item-content:not(.dd-custom)',
					'hover_selector' => '%%order_class%% .dd-mi .dd-item:not(.dd-custom).hover, %%order_class%% .dd-mi .dd-item:not(.dd-custom).active',
					'css_property'   => 'border-color',
					'render_slug'    => $render_slug,
					'type'           => 'color',
				)
			);
			$this->generate_styles(
				array(
					'base_attr_name' => 'menu_item_circle_border_size',
					'selector'       => '%%order_class%% .dd-menu-item-content:not(.dd-custom)',
					'hover_selector' => '%%order_class%% .dd-menu-item-content:not(.dd-custom).hover, %%order_class%% .dd-menu-item-content:not(.dd-custom).active',
					'css_property'   => 'border-width',
					'sticky'		 => false,
					'render_slug'    => $render_slug,
				)
			);
		}
		
		if ($this->props['menu_item_show_title'] === 'on') {
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => '%%order_class%% .dd-divimenu-open .dd-menu-items .dd-tooltip:not(.dd-hover)',
				'declaration' => sprintf('transition-property: opacity; transition-duration:0ms; transition-delay:%1$dms;', $transition)
				)
			);
			if ($this->props['tooltip_use_background'] === 'on') {
				$this->generate_styles(
					array(
						'base_attr_name' => 'tooltip_background',
						'selector'       => '%%order_class%% .dd-title-bg',
						'hover_selector' => '%%order_class%% .dd-title-bg.hover, %%order_class%% .dd-tooltip.active .dd-title-bg',
						'css_property'   => 'background-color',
						'render_slug'    => $render_slug,
						'type'           => 'color',
					)
				);
				DiviMenusHelper::set_responsive_padding_css($this->props, 'title_padding', '%%order_class%% .dd-title-bg', 'padding', $render_slug,  $this->is_sticky_module);
			}  
		}
				
		$bg = DiviMenusHelper::has_background($this->props);
		$bg_padding = DiviMenusHelper::get_background_padding($this->props, $itemsc);

		$items_distance_responsive = et_pb_get_responsive_status( $this->props['menu_item_distance_last_edited'] );
		$items_distance = DiviMenusHelper::get_value($this->props['menu_item_distance'], 25);
		$items_distance_tablet = DiviMenusHelper::get_value($items_distance_responsive ? $this->props['menu_item_distance_tablet'] : $this->props['menu_item_distance'], $items_distance);
		$items_distance_phone = DiviMenusHelper::get_value($items_distance_responsive ? $this->props['menu_item_distance_phone'] : $this->props['menu_item_distance'], $items_distance_tablet);		  

		$mb_size = DiviMenusHelper::get_menu_button_size($this->props, $mb_content_size, $mb_padding, $this->props['central_item_circle_border_size']);
		$mb_size_t = DiviMenusHelper::get_menu_button_size($this->props, $mb_content_size_t, $mb_padding_t, $this->props['central_item_circle_border_size']);
		$mb_size_p = DiviMenusHelper::get_menu_button_size($this->props, $mb_content_size_p, $mb_padding_p,  $this->props['central_item_circle_border_size']);

		$item_size = DiviMenusHelper::get_largest_item_size($itemsa['desktop'], 'desktop' );
		$item_size_t = DiviMenusHelper::get_largest_item_size($itemsa['tablet'], 'tablet' );
		$item_size_p = DiviMenusHelper::get_largest_item_size($itemsa['phone'], 'phone' );
		
		$largest_size = DiviMenusHelper::get_largest_menu_size( $mb_size, $item_size );
		$largest_size_t = DiviMenusHelper::get_largest_menu_size($mb_size_t, $item_size_t );
		$largest_size_p = DiviMenusHelper::get_largest_menu_size($mb_size_p, $item_size_p );

		$menu_width = $this->get_menu_width($itemsa['desktop'], $mb_size, $item_size, $largest_size, $bg_padding['desktop'], $items_distance, 'desktop');
		$menu_width_t = $this->get_menu_width($itemsa['tablet'], $mb_size_t, $item_size_t, $largest_size_t, $bg_padding['tablet'], $items_distance_tablet, 'tablet');
		$menu_width_p = $this->get_menu_width($itemsa['phone'], $mb_size_p, $item_size_p, $largest_size_p, $bg_padding['phone'], $items_distance_phone, 'phone');

		if ($this->props['show_open'] === 'on' && $this->props['hide_button'] === 'on' && $this->props['central_item_inline_menu_position'] === 'middle')
			$this->props['central_item_inline_menu_position'] = 'first';

		$m_left = 50;	  
		if ($menu_ali === 'left')
			$m_left  = 0;
		else if ($menu_ali === 'right')
			$m_left = 100;

		$m_left_offset = $this->get_menu_position($itemsa['desktop'], $menu_width['dm'], $mb_size, $item_size, $largest_size, $bg_padding['desktop'], $items_distance, 'desktop');
		$m_left_offset_t = $this->get_menu_position($itemsa['tablet'], $menu_width_t['dm'], $mb_size_t, $item_size_t, $largest_size_t, $bg_padding['tablet'], $items_distance_tablet, 'tablet');
		$m_left_offset_p = $this->get_menu_position($itemsa['phone'], $menu_width_p['dm'], $mb_size_p, $item_size_p, $largest_size_p, $bg_padding['phone'], $items_distance_phone, 'phone');
	
		$menu_bg = $this->get_menu_background($itemsa['desktop'], $menu_width['dm'], $mb_size, $mb_content_size, $bg_padding['desktop'], $m_left, 'desktop');
		$menu_bg_t = $this->get_menu_background($itemsa['tablet'], $menu_width_t['dm'], $mb_size_t, $mb_content_size_t, $bg_padding['tablet'], $m_left, 'tablet');
		$menu_bg_p = $this->get_menu_background($itemsa['phone'], $menu_width_p['dm'], $mb_size_p, $mb_content_size_p, $bg_padding['phone'], $m_left, 'phone');

		ET_Builder_Element::set_style( $render_slug, array(
			'selector'    => '%%order_class%% .dd-menu-button-content',
			'declaration' => sprintf('position: absolute; left: calc(%1$d%% + %2$spx); transform: translateX(-50%%); z-index:21;', $m_left, $m_left_offset )
		) );
		if ($et_pb_divimenus_render_on_tablet)
			DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-menu-button-content', sprintf('left: calc(%1$d%% + %2$spx);', $m_left, $m_left_offset_t), 't');
		if ($et_pb_divimenus_render_on_phone)
			DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-menu-button-content', sprintf('left: calc(%1$d%% + %2$spx);', $m_left, $m_left_offset_p), 'p');
		
		ET_Builder_Element::set_style( $render_slug, array(
			'selector'    => '%%order_class%% .dd-divimenu:not(.dd-divimenu-open) .dd-menu-button-content',
			'declaration' => sprintf('transition: background-color %1$s %2$s %3$s, border-color %1$s %2$s %3$s, color %1$s %2$s %3$s, transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);',
				esc_html($this->props['hover_transition_duration']),
				esc_html($this->props['hover_transition_speed_curve']),
				esc_html($this->props['hover_transition_delay'])
			) 
		) );

		if ($menu_ali === 'justified' && $this->props['center_menu_button'] === 'on') { 
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => '%%order_class%% .dd-divimenu:not(.dd-divimenu-open) .dd-menu-button-content',
				'declaration' => 'left: 50%;'
			) );
		}
		if ( $this->props['central_item_scale'] == 'on') {
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => '%%order_class%% .dd-divimenu-open .dd-menu-button-content',
				'declaration' => 'transform: translateX(-50%) scale(0.8); transition-duration:0ms'		
			) );			
		}

		ET_Builder_Element::set_style( $render_slug, array(
			'selector'    => '%%order_class%% .dd-menu-item-wrapper, %%order_class%% .dd-divimenu > .dd-menu-button > .dd-tooltip',
			'declaration' => sprintf('position: absolute; top:50%%; left: calc(%1$d%% + %2$spx);', $m_left, $m_left_offset)
		) );
		if ($et_pb_divimenus_render_on_tablet)
			DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-menu-item-wrapper, %%order_class%% .dd-divimenu > .dd-menu-button > .dd-tooltip', sprintf('left: calc(%1$d%% + %2$spx);', $m_left, $m_left_offset_t), 't');
		if ($et_pb_divimenus_render_on_phone)
			DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-menu-item-wrapper, %%order_class%% .dd-divimenu > .dd-menu-button > .dd-tooltip', sprintf('left: calc(%1$d%% + %2$spx);', $m_left, $m_left_offset_p), 'p');

		if ($this->props['menu_button_show_title'] === 'on') {
			$this->set_tooltip(0, 0, $mb_size, $mb_size_t, $mb_size_p, $et_pb_divimenus_render_on_tablet, $et_pb_divimenus_render_on_phone, $render_slug);

			if ($this->props['mb_title_use_background'] === 'on') {
				$this->generate_styles(
					array(
						'base_attr_name' => 'mb_title_background',
						'selector'       => '%%order_class%% .dd-mb-title-bg',
						'hover_selector' => '%%order_class%% .dd-mb-title-bg.hover, %%order_class%% .dd-divimenu-open .dd-mb-title-bg',
						'css_property'   => 'background-color',
						'render_slug'    => $render_slug,
						'type'           => 'color',
					)
				);
				DiviMenusHelper::set_responsive_padding_css($this->props, 'mb_title_padding', '%%order_class%% .dd-mb-title-bg', 'padding', $render_slug, $this->is_sticky_module);
			}
		}
		
		if ($menu_type === 'circular') { // circular DMs	
			$reverse = $circular_type === 'semicircle_left' || $circular_type === 'semicircle_right' || $circular_type === 'semicircle_bottom';

			$degrees = $circular_type === "circle" ? 360 : ($itemsc['desktop'] == 1 ? 180 : 180 + (180 / ($itemsc['desktop']-1)));
			$item_tX = ($mb_size['circular'] / 2) + $items_distance + $item_size['width'] / 2;
			$itemc = 0;
			for ($i = 0; $i < count($et_pb_divimenus_items); $i++) {
				
				if ($et_pb_divimenus_items[$i]['hide_desktop']) continue;
				if (!$bg && $itemsc['desktop'] == 1 && $this->props['show_open'] === 'on' && $this->props['hide_button'] === 'on' && $menu_ali === 'justified') break;
				
				$circle = $this->get_circle_position($degrees, $itemsc['desktop'], $itemc);
				$itemc++;					 

				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => sprintf('%%order_class%% .dd-divimenu-open .dd-menu-items>div:nth-child(%1$d) .dd-menu-item-content, 
											%%order_class%% .dd-divimenu-open .dd-menu-items>div:nth-child(%1$d) .dd-tooltip', $i+1),
					'declaration' => sprintf('transform: translate(%1$spx, %2$spx);', 
						$reverse ? $circle['cos'] * $item_tX : - ($circle['cos'] * $item_tX), $reverse ? $circle['sin'] * $item_tX : - ($circle['sin'] * $item_tX) )
				) );
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => sprintf('%%order_class%% .dd-divimenu-open .dd-menu-items>div:nth-child(%1$d) .dd-menu-item-wrapper', $i+1),
					'declaration' => sprintf('transform-origin: %1$spx %2$spx;', 
						$reverse ? $circle['cos'] * $item_tX : - ($circle['cos'] * $item_tX), $reverse ? $circle['sin'] * $item_tX : - ($circle['sin'] * $item_tX) )
				) );
			} // end desktop

			if ($et_pb_divimenus_render_on_tablet) {
				$degrees = $circular_type === "circle" ? 360 : ($itemsc['tablet'] == 1 ? 180 : 180 + (180 / ($itemsc['tablet']-1)));
				$item_tX_t = ($mb_size_t['circular'] / 2) + $items_distance_tablet + $item_size_t['width'] / 2;
				$itemc = 0;
				for ($i = 0; $i < count($et_pb_divimenus_items); $i++) {
					
					if ($et_pb_divimenus_items[$i]['hide_tablet']) continue;
					if (!$bg && $itemsc['tablet'] == 1 && $this->props['show_open'] === 'on' && $this->props['hide_button'] === 'on' && $menu_ali === 'justified') break;
					
					$circle = $this->get_circle_position($degrees, $itemsc['tablet'], $itemc);
					$itemc++;

					ET_Builder_Element::set_style( $render_slug, array(
						'selector'    => sprintf('%%order_class%% .dd-divimenu-open .dd-menu-items>div:nth-child(%1$d) .dd-menu-item-content, 
											%%order_class%% .dd-divimenu-open .dd-menu-items>div:nth-child(%1$d) .dd-tooltip', $i+1),
						'declaration' => sprintf('transform: translate(%1$spx, %2$spx);', 
							$reverse ? $circle['cos'] * $item_tX_t : - ($circle['cos'] * $item_tX_t), $reverse ? $circle['sin'] * $item_tX_t : - ($circle['sin'] * $item_tX_t) ),
						'media_query' => ET_Builder_Element::get_media_query( '768_980' )
					));
					ET_Builder_Element::set_style( $render_slug, array(
						'selector'    => sprintf('%%order_class%% .dd-divimenu-open .dd-menu-items>div:nth-child(%1$d) .dd-menu-item-wrapper', $i+1),
						'declaration' => sprintf('transform-origin: %1$spx %2$spx;', 
							$reverse ? $circle['cos'] * $item_tX_t : - ($circle['cos'] * $item_tX_t), $reverse ? $circle['sin'] * $item_tX_t : - ($circle['sin'] * $item_tX_t) ),
						'media_query' => ET_Builder_Element::get_media_query( '768_980' )
					)  );			
				} 
			} // end tablet

			if ($et_pb_divimenus_render_on_phone) {
				$degrees = $circular_type === "circle" ? 360 : ($itemsc['phone'] == 1 ? 180 : 180 + (180 / ($itemsc['phone']-1)));
				$item_tX_p = ($mb_size_p['circular'] / 2) + $items_distance_phone + $item_size_p['width'] / 2;
				$itemc = 0;
				for ($i = 0; $i < count($et_pb_divimenus_items); $i++) {

					if ($et_pb_divimenus_items[$i]['hide_phone']) continue;
					if (!$bg && $itemsc['phone'] == 1 && $this->props['show_open'] === 'on' && $this->props['hide_button'] === 'on' && $menu_ali === 'justified') break;
					
					$circle = $this->get_circle_position($degrees, $itemsc['phone'], $itemc);
					$itemc++;
		
					ET_Builder_Element::set_style( $render_slug, array(
						'selector'    => sprintf('%%order_class%% .dd-divimenu-open .dd-menu-items>div:nth-child(%1$d) .dd-menu-item-content, 
											%%order_class%% .dd-divimenu-open .dd-menu-items>div:nth-child(%1$d) .dd-tooltip', $i+1),
						'declaration' => sprintf('transform: translate(%1$spx, %2$spx);', 
							$reverse ? $circle['cos'] * $item_tX_p : - ($circle['cos'] * $item_tX_p), $reverse ? $circle['sin'] * $item_tX_p : - ($circle['sin'] * $item_tX_p) ),
						'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' )
					));
					ET_Builder_Element::set_style( $render_slug, array(
						'selector'    => sprintf('%%order_class%% .dd-divimenu-open .dd-menu-items>div:nth-child(%1$d) .dd-menu-item-wrapper', $i+1),
						'declaration' => sprintf('transform-origin: %1$spx %2$spx;', 
							$reverse ? $circle['cos'] * $item_tX_p : - ($circle['cos'] * $item_tX_p), $reverse ? $circle['sin'] * $item_tX_p : - ($circle['sin'] * $item_tX_p) ),
						'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' )
					)  );
				}
			} // end phone

			for ($i = 0; $i < count($et_pb_divimenus_items); $i++) {
				if ($this->props['menu_item_show_title'] === 'on' && $et_pb_divimenus_items[$i]['title_disable'] !== 'on') {
					$this->set_tooltip($et_pb_divimenus_items, $i, 0, 0, 0, $et_pb_divimenus_render_on_tablet, $et_pb_divimenus_render_on_phone, $render_slug);
				}
			}				

			if ($bg) {
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => '%%order_class%% .dd-divimenu-open .dd-menu-bg', 
					'declaration' => sprintf('position:absolute; width: calc(%3$spx - %1$spx); height: calc(%3$spx - %2$spx); top: %13$s; bottom: %14$s; left: %10$d%%; 
							transform: translate(calc(-%4$d%% + %11$spx), calc(-%5$d%% + %12$spx)); border-radius: %6$spx %7$spx %8$spx %9$spx; z-index: 15;',
						$menu_bg['width_offset'],
						$menu_bg['height_offset'], 
						$menu_width['dm'],
						$menu_bg['tX'],
						$menu_bg['tY'], 
						$menu_bg['BRTL'], 
						$menu_bg['BRTR'],  
						$menu_bg['BRBR'], 
						$menu_bg['BRBL'],
						$m_left, 
						$menu_bg['tX_offset'],
						$menu_bg['tY_offset'],
						$circular_type === 'semicircle_bottom' ? '0px': ($circular_type === 'semicircle_top' ? 'auto' : '50%'),
						$circular_type === 'semicircle_top' ?  '0px' : ($circular_type === 'semicircle_bottom' ? 'auto' : '-50%'))
				) );
				if ($et_pb_divimenus_render_on_tablet)	
					ET_Builder_Element::set_style( $render_slug, array(
						'selector'    => '%%order_class%% .dd-divimenu-open .dd-menu-bg', 
						'declaration' => sprintf('width: calc(%3$spx - %1$spx); height: calc(%3$spx - %2$spx); transform: translate(calc(-%4$d%% + %6$spx), calc(-%5$d%% + %7$spx));
											border-radius: %8$spx %9$spx %10$spx %11$spx;',
							$menu_bg_t['width_offset'],
							$menu_bg_t['height_offset'],
							$menu_width_t['dm'],
							$menu_bg_t['tX'],
							$menu_bg_t['tY'], 
							$menu_bg_t['tX_offset'],
							$menu_bg_t['tY_offset'],
							$menu_bg_t['BRTL'],
							$menu_bg_t['BRTR'],  
							$menu_bg_t['BRBR'], 
							$menu_bg_t['BRBL']), 
						'media_query' => ET_Builder_Element::get_media_query( '768_980' ),
					) );
				if ($et_pb_divimenus_render_on_phone)		
					ET_Builder_Element::set_style( $render_slug, array(
						'selector'    => '%%order_class%% .dd-divimenu-open .dd-menu-bg', 
						'declaration' => sprintf('width: calc(%3$spx - %1$spx); height: calc(%3$spx - %2$spx); transform: translate(calc(-%4$d%% + %6$spx), calc(-%5$d%% + %7$spx));
											border-radius: %8$spx %9$spx %10$spx %11$spx;',
							$menu_bg_p['width_offset'], 
							$menu_bg_p['height_offset'], 
							$menu_width_p['dm'],
							$menu_bg_p['tX'],
							$menu_bg_p['tY'],
							$menu_bg_p['tX_offset'],
							$menu_bg_p['tY_offset'],
							$menu_bg_p['BRTL'], 
							$menu_bg_p['BRTR'],  
							$menu_bg_p['BRBR'], 
							$menu_bg_p['BRBL']),
						'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
					) );
			}

			$mb_top = $mi_top = 0;
			$module_height = $this->get_module_height($itemsa['desktop'], $itemsc['desktop'], $menu_width, $mb_size, $items_distance, $bg_padding['desktop'], $menu_bg['height_offset'], $item_size, $mb_top, $mi_top, 'desktop' );
			DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-divimenu', sprintf('min-height:%1$spx;', $module_height));
			DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-menu-button-content', sprintf('top:%1$spx;', $mb_top));
			if ($this->props['inside_container'] === 'on' && $this->props['adjust_container'] === 'off' && !($this->props['show_open'] === 'on' && $this->props['hide_button'] === 'on')) {
				DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-divimenu:not(.dd-divimenu-open)', sprintf('min-height:%1$spx;', $mb_size['height']));
				DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-divimenu:not(.dd-divimenu-open) .dd-menu-button-content', sprintf('top:%1$spx;', 0));
			}  
			if ($mi_top !== 0)
				DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-menu-items .dd-menu-item-wrapper', sprintf('top:%1$spx;', $mi_top));
			
			if ($et_pb_divimenus_render_on_tablet) {
				$mb_top = $mi_top = 0;
				$module_height = $this->get_module_height($itemsa['tablet'], $itemsc['tablet'], $menu_width_t, $mb_size_t, $items_distance_tablet, $bg_padding['tablet'], $menu_bg_t['height_offset'], $item_size_t, $mb_top, $mi_top, 'tablet' );
				DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-divimenu', sprintf('min-height:%1$spx ', $module_height), 't');
				DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-menu-button-content', sprintf('top:%1$spx;', $mb_top), 't');
				if ($this->props['inside_container'] === 'on' && $this->props['adjust_container'] === 'off' && !($this->props['show_open'] === 'on' && $this->props['hide_button'] === 'on')) 
					DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-divimenu:not(.dd-divimenu-open)', sprintf('min-height:%1$spx ', $mb_size_t['height']), 't'); 
				if ($mi_top !== 0) 
					DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-menu-items .dd-menu-item-wrapper', sprintf('top:%1$spx ', $mi_top), 't'); 
			}

			if ($et_pb_divimenus_render_on_phone) {
				$mb_top = $mi_top = 0;
				$module_height = $this->get_module_height($itemsa['phone'], $itemsc['phone'], $menu_width_p, $mb_size_p, $items_distance_phone, $bg_padding['phone'], $menu_bg_p['height_offset'], $item_size_p, $mb_top, $mi_top, 'phone' );
				DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-divimenu', sprintf('min-height:%1$spx ', $module_height), 'p');
				DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-menu-button-content', sprintf('top:%1$spx;', $mb_top), 'p');
				if ($this->props['inside_container'] === 'on' && $this->props['adjust_container'] === 'off' && !($this->props['show_open'] === 'on' && $this->props['hide_button'] === 'on'))
					DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-divimenu:not(.dd-divimenu-open)', sprintf('min-height:%1$spx ',$mb_size_p['height']), 'p'); 
				if ($mi_top !== 0)
					DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-menu-items .dd-menu-item-wrapper', sprintf('top:%1$spx ', $mi_top), 'p');
			}
		} else { // horizontal and vertical DMs
			$bg_pos = $bg_pos_t = $bg_pos_p = array('tX_offset' => 0, 'tY_offset' => 0); // calculates the later bg translation offset  
	
			$mb_middle = false;
			if (($menu_type === 'horizontal' && $this->props['central_item_inline_menu_position'] === 'middle') || ($menu_type === 'vertical' && $this->props['central_item_inline_menu_position'] === 'middle')) {
				$mb_middle = true;
				if ($menu_ali === 'justified') {
					$bg_pos['tX_offset'] -= ((DiviMenusHelper::get_menu_width_after($menu_type, $itemsa['desktop'], $items_distance, $mb_size, 'desktop') + $bg_padding['desktop']) /2 -
					(DiviMenusHelper::get_menu_width_before($menu_type, $itemsa['desktop'], $items_distance, $mb_size, 'desktop') + $bg_padding['desktop']) /2);
					$bg_pos_t['tX_offset'] -= ((DiviMenusHelper::get_menu_width_after($menu_type, $itemsa['tablet'], $items_distance_tablet, $mb_size_t, 'tablet') + $bg_padding['tablet']) /2 -
					(DiviMenusHelper::get_menu_width_before($menu_type, $itemsa['tablet'], $items_distance_tablet, $mb_size_t, 'tablet') + $bg_padding['tablet']) /2);
					$bg_pos_p['tX_offset'] -= ((DiviMenusHelper::get_menu_width_after($menu_type, $itemsa['phone'], $items_distance_phone, $mb_size_p, 'phone') + $bg_padding['phone']) /2 -
					(DiviMenusHelper::get_menu_width_before($menu_type, $itemsa['phone'], $items_distance_phone, $mb_size_p, 'phone') + $bg_padding['phone']) /2);
				}
				if ($this->props['hide_button'] === 'on') {
					$mb_middle = false;
				}
			}			 

			$item_pos = $item_pos_t = $item_pos_p = array('tX' => 0, 'tY' => 0, 'tX_side1' => 0, 'tX_side2' => 0, 'tY_side1' => 0, 'tY_side2' => 0);
			$first_item = true;
			$itemc = 0;
			$offset_index = 1; 
			for ($i = 0; $i < count($et_pb_divimenus_items); $i++) {
				if ($et_pb_divimenus_items[$i]['hide_desktop']) continue;
				$current_item_size = $itemsa['desktop'][$itemc]['size'];
				if ($mb_middle) {	
					$previous_item_size = $itemc < 2 ? $mb_size : $itemsa['desktop'][$itemc-2]['size'];
					$this->get_menu_item_position(false, $mb_middle, $menu_width['dm'], $bg_padding['desktop'], $items_distance, $mb_size['width'], $previous_item_size, $current_item_size, $item_pos, $bg_pos, $itemc, $offset_index );
					$offset_index *= -1;
				}
				else {
					$firstNB = ($first_item && $this->props['show_open'] === 'on' && $this->props['hide_button'] === 'on');
					$previous_item_size = $firstNB || $itemc < 1 ? $mb_size  : $itemsa['desktop'][$itemc-1]['size'];
					if ($firstNB) { 
						$menu_width['dm'] -= $items_distance;
						if ($menu_type === 'horizontal') {								 
							if (!($menu_ali === 'left' && $this->props['central_item_inline_menu_position'] === 'last') && !($menu_ali === 'right' && $this->props['central_item_inline_menu_position'] === 'first')) { 
								$bg_pos['tX_offset'] = -$bg_padding['desktop'] - $current_item_size['width']/2;
							}
						}
					}
					$this->get_menu_item_position($firstNB, false, $menu_width['dm'], $bg_padding['desktop'], $items_distance, $mb_size['width'], $previous_item_size, $current_item_size, $item_pos, $bg_pos, $itemc, 0 );
					$first_item = false;					
				}

				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => sprintf('%%order_class%% .dd-divimenu-open .dd-menu-items>div:nth-child(%1$d) .dd-menu-item-content,
										%%order_class%% .dd-divimenu-open .dd-menu-items>div:nth-child(%1$d) .dd-tooltip', $i+1),
					'declaration' => sprintf('transform: translate(%1$spx, %2$spx);', 
						$mb_middle && ($itemc % 2 === 0) ? $item_pos['tX_side1'] : ($mb_middle ? $item_pos['tX_side2'] : $item_pos['tX']), 
						$mb_middle && ($itemc % 2 === 0) ? $item_pos['tY_side1'] : ($mb_middle ? $item_pos['tY_side2'] : $item_pos['tY']) )
					)
				);
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => sprintf('%%order_class%% .dd-divimenu-open .dd-menu-items>div:nth-child(%1$d) .dd-menu-item-wrapper', $i+1),
					'declaration' => sprintf('transform-origin: %1$spx %2$spx;', 
						$mb_middle && ($itemc % 2 === 0) ? $item_pos['tX_side1'] : ($mb_middle ? $item_pos['tX_side2'] : $item_pos['tX']), 
						$mb_middle && ($itemc % 2 === 0) ? $item_pos['tY_side1'] : ($mb_middle ? $item_pos['tY_side2'] : $item_pos['tY']) )
					)
				);
				$itemc++;
			}
			if ($et_pb_divimenus_render_on_tablet) {
				$first_item = true;
				$itemc = 0;
				$offset_index = 1;
				for ($i = 0; $i < count($et_pb_divimenus_items); $i++) {
					if ($et_pb_divimenus_items[$i]['hide_tablet']) continue;
					$current_item_size = $itemsa['tablet'][$itemc]['size_t'];
					if ($mb_middle) {	
						$previous_item_size = $itemc < 2 ? $mb_size_t : $itemsa['tablet'][$itemc-2]['size_t'];
						$this->get_menu_item_position(false, $mb_middle, $menu_width_t['dm'], $bg_padding['tablet'], $items_distance_tablet, $mb_size_t['width'], $previous_item_size, $current_item_size, $item_pos_t, $bg_pos_t, $itemc, $offset_index);
						$offset_index *= -1;
					} else {
						$firstNB = ($first_item && $this->props['show_open'] === 'on' && $this->props['hide_button'] === 'on');
						$previous_item_size = $firstNB || $itemc < 1 ? $mb_size_t  : $itemsa['tablet'][$itemc-1]['size_t'];
						if ($firstNB) { 
							$menu_width_t['dm'] -= $items_distance_tablet;	
							if ($menu_type === 'horizontal') {								 
								if (!($menu_ali === 'left' && $this->props['central_item_inline_menu_position'] === 'last') && !($menu_ali === 'right' && $this->props['central_item_inline_menu_position'] === 'first')) 
									$bg_pos_t['tX_offset'] = -$bg_padding['tablet'] - $current_item_size['width']/2;
							}
						}
						$this->get_menu_item_position($firstNB, false, $menu_width_t['dm'], $bg_padding['tablet'], $items_distance_tablet, $mb_size_t['width'], $previous_item_size, $current_item_size, $item_pos_t, $bg_pos_t, $itemc, 0);
						$first_item = false;					
					}
					ET_Builder_Element::set_style( $render_slug, array(
						'selector'    => sprintf('%%order_class%% .dd-divimenu-open .dd-menu-items>div:nth-child(%1$d) .dd-menu-item-content,
												%%order_class%% .dd-divimenu-open .dd-menu-items>div:nth-child(%1$d) .dd-tooltip', $i+1),
						'declaration' => sprintf('transform: translate(%1$spx, %2$spx);', 
							$mb_middle && ($itemc % 2 === 0) ? $item_pos_t['tX_side1'] : ($mb_middle ? $item_pos_t['tX_side2'] : $item_pos_t['tX']), 
							$mb_middle && ($itemc % 2 === 0) ? $item_pos_t['tY_side1'] : ($mb_middle ? $item_pos_t['tY_side2'] : $item_pos_t['tY']) ),
						'media_query' => ET_Builder_Element::get_media_query( '768_980' ),
					));
					ET_Builder_Element::set_style( $render_slug, array(
						'selector'    => sprintf('%%order_class%% .dd-divimenu-open .dd-menu-items>div:nth-child(%1$d) .dd-menu-item-wrapper', $i+1),
						'declaration' => sprintf('transform-origin: %1$spx %2$spx;', 
							$mb_middle && ($itemc % 2 === 0) ? $item_pos_t['tX_side1'] : ($mb_middle ? $item_pos_t['tX_side2'] : $item_pos_t['tX']), 
							$mb_middle && ($itemc % 2 === 0) ? $item_pos_t['tY_side1'] : ($mb_middle ? $item_pos_t['tY_side2'] : $item_pos_t['tY']) ),
						'media_query' => ET_Builder_Element::get_media_query( '768_980' ),
					));
					$itemc++;
				}
			}
			if ($et_pb_divimenus_render_on_phone) {
				$first_item = true;
				$itemc = 0;
				$offset_index = 1;
				for ($i = 0; $i < count($et_pb_divimenus_items); $i++) {
					if ($et_pb_divimenus_items[$i]['hide_phone']) continue;
					$current_item_size = $itemsa['phone'][$itemc]['size_p'];
					if ($mb_middle) {	
						$previous_item_size = $itemc < 2 ? $mb_size_p : $itemsa['phone'][$itemc-2]['size_p'];
						$this->get_menu_item_position(false, $mb_middle, $menu_width_p['dm'], $bg_padding['phone'], $items_distance_phone, $mb_size_p['width'], $previous_item_size, $current_item_size, $item_pos_p, $bg_pos_p, $itemc, $offset_index);
						$offset_index *= -1;
					} else {
						$firstNB = ($first_item && $this->props['show_open'] === 'on' && $this->props['hide_button'] === 'on');
						$previous_item_size = $firstNB || $itemc < 1 ? $mb_size_p  : $itemsa['phone'][$itemc-1]['size_p'];
						if ($firstNB) { 
							$menu_width_p['dm'] -= $items_distance_phone;
							
							if ($menu_type === 'horizontal') {								 
								if (!($menu_ali === 'left' && $this->props['central_item_inline_menu_position'] === 'last') && !($menu_ali === 'right' && $this->props['central_item_inline_menu_position'] === 'first')) 
									$bg_pos_p['tX_offset'] = -$bg_padding['phone'] - $current_item_size['width']/2;
							}
						}
						$this->get_menu_item_position($firstNB, false, $menu_width_p['dm'], $bg_padding['phone'], $items_distance_phone, $mb_size_p['width'], $previous_item_size, $current_item_size, $item_pos_p, $bg_pos_p, $itemc, 0);
						$first_item = false;							
					}
					ET_Builder_Element::set_style( $render_slug, array(
						'selector'    => sprintf('%%order_class%% .dd-divimenu-open .dd-menu-items>div:nth-child(%1$d) .dd-menu-item-content,
												%%order_class%% .dd-divimenu-open .dd-menu-items>div:nth-child(%1$d) .dd-tooltip', $i+1),
						'declaration' => sprintf('transform: translate(%1$spx, %2$spx);', 
							$mb_middle && ($itemc % 2 === 0) ? $item_pos_p['tX_side1'] : ($mb_middle ? $item_pos_p['tX_side2'] : $item_pos_p['tX']), 
							$mb_middle && ($itemc % 2 === 0) ? $item_pos_p['tY_side1'] : ($mb_middle ? $item_pos_p['tY_side2'] : $item_pos_p['tY']) ),						
						'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
					));
					ET_Builder_Element::set_style( $render_slug, array(
						'selector'    => sprintf('%%order_class%% .dd-divimenu-open .dd-menu-items>div:nth-child(%1$d) .dd-menu-item-wrapper', $i+1),
						'declaration' => sprintf('transform-origin: %1$spx %2$spx;', 
							$mb_middle && ($itemc % 2 === 0) ? $item_pos_p['tX_side1'] : ($mb_middle ? $item_pos_p['tX_side2'] : $item_pos_p['tX']), 
							$mb_middle && ($itemc % 2 === 0) ? $item_pos_p['tY_side1'] : ($mb_middle ? $item_pos_p['tY_side2'] : $item_pos_p['tY']) ),						
						'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
					));					
					$itemc++;	
				}
			}
			for ($i = 0; $i < count($et_pb_divimenus_items); $i++) {
				if ($this->props['menu_item_show_title'] === 'on' && $et_pb_divimenus_items[$i]['title_disable'] !== 'on') {
					$this->set_tooltip($et_pb_divimenus_items, $i, 0, 0, 0, $et_pb_divimenus_render_on_tablet, $et_pb_divimenus_render_on_phone, $render_slug);
				}
			}				

			if ($bg) {
				$bg_top = ($menu_type === 'vertical' && $this->props['central_item_inline_menu_position'] === 'first') ? 0 : ($menu_type === 'vertical' && $this->props['central_item_inline_menu_position'] === 'last' ? 100 : 50);
				$bg_tX = $menu_ali === 'right' ? 100: ((($menu_type === 'horizontal' && $this->props['central_item_inline_menu_position'] !== 'middle') || ($menu_ali === 'left')) ? 0 : 50 );
				$bg_tY = ($menu_type === 'vertical' && $this->props['central_item_inline_menu_position'] === 'first') ? 0 : ($menu_type === 'vertical' && $this->props['central_item_inline_menu_position'] === 'last' ? 100 : 50); 

				if ($mb_middle && $itemsc['desktop'] % 2 !== 0) {
					if ($menu_type === 'horizontal')
						$bg_pos['tX_offset'] += ($mb_size['width']/2 + $items_distance/2);
					else if ($menu_type === 'vertical')
						$bg_pos['tY_offset'] += ($mb_size['height']/2 + $items_distance/2);
				}
				if ($mb_middle && $itemsc['tablet'] % 2 !== 0) {
					if ($menu_type === 'horizontal')
						$bg_pos_t['tX_offset'] += ($mb_size_t['width']/2 + $items_distance_tablet/2);
					else if ($menu_type === 'vertical')
						$bg_pos_t['tY_offset'] += ($mb_size_t['height']/2 + $items_distance_tablet/2);			
				}
				if ($mb_middle && $itemsc['phone'] % 2 !== 0) {
					if ($menu_type === 'horizontal')
						$bg_pos_p['tX_offset'] += ($mb_size_p['width']/2 + $items_distance_phone/2);
					else if ($menu_type === 'vertical')
						$bg_pos_p['tY_offset'] += ($mb_size_p['height']/2 + $items_distance_phone/2);			
				}
				if (($menu_ali === 'left' || $menu_ali === 'right') || ($menu_type === 'vertical' && $menu_ali === 'justified')) {
					$bg_pos['tX_offset'] = $bg_pos_t['tX_offset'] = $bg_pos_p['tX_offset'] = 0;
				}
				if ($menu_type === 'horizontal' || $this->props['inside_container'] === 'on') { 
					$bg_pos['tY_offset'] = $bg_pos_t['tY_offset'] = $bg_pos_p['tY_offset'] = 0;
				}

				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => '%%order_class%% .dd-divimenu-open .dd-menu-bg',
					'declaration' => sprintf('position:absolute; width: calc(%1$spx - 0px); height: calc(%2$spx - 0px); top: %5$d%%; left: %6$d%%; 
							transform: translate(calc(-%3$d%% + %7$spx), calc(-%4$d%% + %8$spx)); border-radius: %9$spx %10$spx %11$spx %12$spx; z-index: 15;', 
						$menu_type === 'horizontal' ? $menu_width['dm'] : $menu_width['vertical'],
						$menu_type === 'horizontal' ? $menu_width['vertical'] : $menu_width['dm'],
						$bg_tX,
						$bg_tY, 
						$bg_top, #5
						$m_left,
						$bg_pos['tX_offset'],
						$bg_pos['tY_offset'],	
						$menu_bg['BRTL'],  #9
						$menu_bg['BRTR'],  
						$menu_bg['BRBR'], 
						$menu_bg['BRBL'])
				) );
				if ($et_pb_divimenus_render_on_tablet)
					ET_Builder_Element::set_style( $render_slug, array(
						'selector'    => '%%order_class%% .dd-divimenu-open .dd-menu-bg',
						'declaration' => sprintf('position:absolute; width: calc(%1$spx - 0px); height: calc(%2$spx - 0px); top: %5$d%%; left: %6$d%%; 
								transform: translate(calc(-%3$d%% + %7$spx), calc(-%4$d%% + %8$spx));border-radius: %9$spx %10$spx %11$spx %12$spx;', 
							$menu_type === 'horizontal' ? $menu_width_t['dm'] : $menu_width_t['vertical'],
							$menu_type === 'horizontal' ? $menu_width_t['vertical'] : $menu_width_t['dm'],
							$bg_tX,
							$bg_tY, 
							$bg_top,
							$m_left,
							$bg_pos_t['tX_offset'],
							$bg_pos_t['tY_offset'],
							$menu_bg_t['BRTL'],  #9
							$menu_bg_t['BRTR'],  
							$menu_bg_t['BRBR'], 
							$menu_bg_t['BRBL']),
						'media_query' => ET_Builder_Element::get_media_query( '768_980' ),
					) );
				if ($et_pb_divimenus_render_on_phone)
					ET_Builder_Element::set_style( $render_slug, array(
						'selector'    => '%%order_class%% .dd-divimenu-open .dd-menu-bg',
						'declaration' => sprintf('position:absolute; width: calc(%1$spx - 0px); height: calc(%2$spx - 0px); top: %5$d%%; left: %6$d%%; 
								transform: translate(calc(-%3$d%% + %7$spx), calc(-%4$d%% + %8$spx));border-radius: %9$spx %10$spx %11$spx %12$spx;', 
							$menu_type === 'horizontal' ? $menu_width_p['dm'] : $menu_width_p['vertical'],
							$menu_type === 'horizontal' ? $menu_width_p['vertical'] : $menu_width_p['dm'],
							$bg_tX,
							$bg_tY, 
							$bg_top,
							$m_left,
							$bg_pos_p['tX_offset'],
							$bg_pos_p['tY_offset'],
							$menu_bg_p['BRTL'],  #9
							$menu_bg_p['BRTR'],  
							$menu_bg_p['BRBR'], 
							$menu_bg_p['BRBL']),
						'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
					) );
			}

			$mb_top = $mi_top = 0; 
			$module_height = $this->get_module_height($itemsa['desktop'], $itemsc['desktop'], $menu_width, $mb_size, $items_distance, $bg_padding['desktop'], 0, $item_size, $mb_top, $mi_top, 'desktop' );
			DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-divimenu', sprintf('min-height:%1$spx;', $module_height));
			DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-menu-button-content', sprintf('top:%1$spx;', $mb_top));
			DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-divimenu > .dd-menu-button > .dd-tooltip', sprintf('top:%1$spx;', $mb_top + $mb_size['height'] / 2));
			if ($this->props['inside_container'] === 'on' && $this->props['adjust_container'] === 'off' && !($this->props['show_open'] === 'on' && $this->props['hide_button'] === 'on')) {
				DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-divimenu:not(.dd-divimenu-open)', sprintf('min-height:%1$spx;', $mb_size['height']));
				DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-divimenu:not(.dd-divimenu-open) .dd-menu-button-content', sprintf('top:%1$spx;', 0));
				DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-divimenu:not(.dd-divimenu-open) > .dd-tooltip', sprintf('top:%1$spx;', $mb_size['height'] / 2));  
			}
			if ($menu_type === 'vertical')
				DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-menu-items .dd-menu-item-wrapper', sprintf('top:%1$spx;', $mi_top));  
			
			if ($et_pb_divimenus_render_on_tablet) {
				$mb_top = $mi_top = 0; 
				$module_height = $this->get_module_height($itemsa['tablet'], $itemsc['tablet'], $menu_width_t, $mb_size_t, $items_distance_tablet, $bg_padding['tablet'], 0, $item_size_t, $mb_top, $mi_top, 'tablet' ); 
				DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-divimenu', sprintf('min-height:%1$spx;', $module_height), 't');
				DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-menu-button-content', sprintf('top:%1$spx;', $mb_top), 't');
				DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-divimenu > .dd-tooltip', sprintf('top:%1$spx;', $mb_top + $mb_size_t['height'] / 2), 't');
				if ($this->props['inside_container'] === 'on' && $this->props['adjust_container'] === 'off' && !($this->props['show_open'] === 'on' && $this->props['hide_button'] === 'on')) {
					DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-divimenu:not(.dd-divimenu-open)', sprintf('min-height:%1$spx ',$mb_size_t['height']), 't');
					DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-divimenu:not(.dd-divimenu-open) > .dd-tooltip', sprintf('top:%1$spx ', $mb_size_t['height'] / 2), 't');
				}			
				if ($menu_type === 'vertical')
					DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-menu-items .dd-menu-item-wrapper', sprintf('top:%1$spx ', $mi_top), 't');
			}
			if ($et_pb_divimenus_render_on_phone) {
				$mb_top = $mi_top = 0; 
				$module_height = $this->get_module_height($itemsa['phone'], $itemsc['phone'], $menu_width_p, $mb_size_p, $items_distance_phone, $bg_padding['phone'], 0, $item_size_p, $mb_top, $mi_top, 'phone' );			
				DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-divimenu', sprintf('min-height:%1$spx;', $module_height), 'p');
				DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-menu-button-content', sprintf('top:%1$spx;', $mb_top), 'p');
				DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-divimenu > .dd-menu-button > .dd-tooltip', sprintf('top:%1$spx;', $mb_top + $mb_size_p['height'] / 2), 'p');
				if ($this->props['inside_container'] === 'on' && $this->props['adjust_container'] === 'off' && !($this->props['show_open'] === 'on' && $this->props['hide_button'] === 'on')) {
					DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-divimenu:not(.dd-divimenu-open)', sprintf('min-height:%1$spx ', $mb_size_p['height']), 'p'); 
					DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-divimenu:not(.dd-divimenu-open) > .dd-tooltip', sprintf('top:%1$spx ', $mb_size_p['height'] / 2), 'p');
				}
				if ($menu_type === 'vertical') 
					DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-menu-items .dd-menu-item-wrapper', sprintf('top:%1$spx ', $mi_top), 'p');
			}	
		}

		$menu_button_classes = array( 'dd-item dd-menu-button-content');
		$menu_button_content = '';

		if ( 'central_item_icon_option' === $this->props['central_item_select'] )   {			
			if (empty($this->props['central_item_font_icon'])) 
				$this->props['central_item_font_icon'] = "%%64%%";

			$menu_button_classes[] = 'dd-icon-content notranslate';
			$menu_button_content = DiviMenusHelper::render_icon($this->props, $render_slug, 'central_item_font_icon', $menu_button_classes, false, true, 'on' === $this->props['show_open'], '%%order_class%% .dd-menu-button .dd-icon-content', '%%order_class%% .dd-divimenu-open .dd-menu-button .dd-icon-content, %%order_class%% .dd-menu-button .dd-icon-content.hover');

		} else if ('central_item_text_option' === $this->props['central_item_select']) {
			$menu_button_content = sprintf(
				'<div class="dd-item dd-menu-button-content" role="button" aria-pressed="%3$s"><span class="dd-text%2$s" tabindex="0">%1$s</span></div>',
				esc_html( $mb_text ),				
				'on' === $this->props['central_item_use_circle'] ? ' dd-circle' : '',
				'on' === $this->props['show_open'] ? 'true' : 'false'
			); 
		} else if ('central_item_image_option' === $this->props['central_item_select']) {
			$image_alt = DiviMenusHelper::get_image_alt($this->props, 'central_item_image', 'mb_alt');
			$image = DiviMenusHelper::render_image($this->props, 'central_item_image', $this->props['central_item_opacity'] === 'on' ? 'dd-mb-image-opacity' : '', $image_alt, '');
			$menu_button_content = sprintf('<div class="%2$s" role="button" aria-label="Image" aria-pressed="%3$s" tabindex="0">%1$s</div>', $image, implode( ' ', $menu_button_classes ), 'on' === $this->props['show_open'] ? 'true' : 'false');
		}

		$menu_button_title = '';
		if ($this->props['menu_button_show_title'] === 'on' && $this->props['hide_button'] === 'off') {
			$menu_button_title = sprintf('<div class="dd-tooltip%2$s%3$s%4$s"><div class="dd-title%6$s"><span%5$s>%1$s</span></div></div>',
				'' === trim($this->props['mb_title']) ? '' : trim($this->props['mb_title']),
				$this->props['mb_title_behavior'] === 'hover' ? ' dd-hover': '',
				$this->titles_hover_enabled('mb') ? ' dd-hover-enabled': '',
				$this->props['mb_title_clickable'] === 'on' && 'off' === $this->props['disable_button'] ? ' dd-title-clickable': '',
				$this->props['mb_title_clickable'] === 'on' && 'off' === $this->props['disable_button'] ? ' tabindex="0"' : '',
				$this->props['mb_title_use_background'] === 'on' ? ' dd-mb-title-bg': ''			
			);
		}

		$output = sprintf(
			'<nav class="dd-divimenu dd-dm%5$s%6$s%7$s%8$s" aria-label="DiviMenu">
				<div class="dd-menu-button%9$s%10$s%11$s" aria-label="Menu Button">
					%1$s
					%2$s
				</div>	
				%3$s
				<div class="dd-menu-items" role="menu" aria-label="Menu Items">
					%4$s
				</div>				
			</nav>',
			$menu_button_content,
			$menu_button_title,		
			$bg && !empty($et_pb_divimenus_items) ? '<div class="dd-menu-bg"></div>' : '',
			$this->content,		
			'on' === $this->props['make_principal'] ? ' dd-main' : '', #5
			'on' === $this->props['show_open'] ? ' dd-divimenu-open' : '',
			$this->props['positioning'] === 'fixed' ? ' dd-fixed' : '',
			'on' === $this->props['menu_item_opacity'] ? ' dd-image-opacity' : '', 
			'on' === $this->props['show_open'] && 'on' === $this->props['disable_button'] ? ' dd-disabled' : '',
			'on' === $this->props['show_open'] && 'on' === $this->props['hide_button'] ? ' dd-hide' : '',
			'click' === $this->props['hover_click'] ? ' dd-click' : ''	
					
		);

		return $output;
	}

	function get_circle_position($degrees, $n, $i) {
		$item_angle = ( $degrees / $n ) * $i;
		$item_angle_offset = 0;
		if ($this->props['circle_menu_items_alignment'] === 'semicircle_left' && $n === 1 ) $item_angle_offset = -180;
		else if ($this->props['circle_menu_items_alignment'] === 'semicircle_left') $item_angle_offset = 90; 
		else if ($this->props['circle_menu_items_alignment'] === 'semicircle_right' && $n > 1 ) $item_angle_offset = -90;
		$radians = ( pi() / 180 ) * ( $item_angle_offset + $item_angle );
		return array(
			'cos' => cos($radians),
			'sin' => sin($radians),
		);
	}

	function get_menu_item_position($firstNB, $middle, $width, $bg_padding, $distance, $mb_width, $previous_size, $current_size, &$item_pos, &$bg_pos, $i, $offset_index) {
		if ($middle) {
			if ($i % 2 == 0) {
				if ($this->props['menu_type'] === 'horizontal') {
					$bg_pos['tX_offset'] += (($current_size['width']-$mb_width)/2);
					$item_pos['tX_side1'] += ($previous_size['width'] - ($previous_size['width']-$current_size['width'])/2 + $distance) * $offset_index;
				} 
				else if ($this->props['menu_type'] === 'vertical') {
					$bg_pos['tY_offset'] += (($current_size['height']-$mb_width)/2);					
					$item_pos['tY_side1'] += ($previous_size['height'] - ($previous_size['height']-$current_size['height'])/2 + $distance) * $offset_index;								
				}
			} else {
				if ($this->props['menu_type'] === 'horizontal') {
					$bg_pos['tX_offset'] -= (($current_size['width']-$mb_width)/2);
					$item_pos['tX_side2'] += ($previous_size['width'] - ($previous_size['width']-$current_size['width'])/2 + $distance) * $offset_index;
				}
				else if ($this->props['menu_type'] === 'vertical') {
					$bg_pos['tY_offset'] -= (($current_size['height']-$mb_width)/2);	
					$item_pos['tY_side2'] += ($previous_size['height'] - ($previous_size['height']-$current_size['height'])/2 + $distance) * $offset_index;
				}												
			}
		} else if ($this->props['menu_type'] === 'vertical' && $this->props['central_item_inline_menu_position'] === 'first')  {							
			$item_pos['tY'] += ($firstNB ? $current_size['height']/2 : ($previous_size['height'] - ($previous_size['height']-$current_size['height'])/2) + $distance);
			$bg_pos['tY_offset'] = -$bg_padding; 
		} else if ($this->props['menu_type'] === 'vertical' && $this->props['central_item_inline_menu_position'] === 'last') {
			$item_pos['tY'] -= ($firstNB ? $current_size['height']/2 : ($previous_size['height'] - ($previous_size['height']-$current_size['height'])/2) + $distance);
			$bg_pos['tY_offset'] = $bg_padding;
		} else if ($this->props['menu_type'] === 'horizontal' && $this->props['central_item_inline_menu_position'] === 'first') {
			if ($firstNB && $this->props['menu_alignment'] === 'left')
				$item_pos['tX'] = ($current_size['width']/2 - $previous_size['width']/2);
			else if ($firstNB && $this->props['menu_alignment'] === 'right')
				$item_pos['tX'] = ($current_size['width']/2 - $previous_size['width']/2) + $distance;
			else if ($firstNB && $this->props['menu_alignment'] === 'justified')
				$item_pos['tX'] = ($current_size['width']/2 - $previous_size['width']/2) + $distance/2;
			else if (!$firstNB) { 
				$item_pos['tX'] += ($previous_size['width'] - ($previous_size['width']-$current_size['width'])/2) + $distance;						
				$bg_pos['tX_offset'] = -$bg_padding - $current_size['width']/2; 
				if ($this->props['menu_alignment'] === 'center' && $this->props['hide_button'] === 'off') 
					$bg_pos['tX_offset'] = -$bg_padding - $mb_width/2; 
				if ($this->props['menu_alignment'] === 'justified')
					$bg_pos['tX_offset'] -= ($width /2 - ($current_size['width']/2) - $bg_padding); 
			} 
		} else if ($this->props['menu_type'] === 'horizontal' && $this->props['central_item_inline_menu_position'] === 'last') {
			if ($firstNB && $this->props['menu_alignment'] === 'left')
				$item_pos['tX'] = -($current_size['width']/2 - $previous_size['width']/2) - $distance;  
			else if ($firstNB && $this->props['menu_alignment'] === 'right')
				$item_pos['tX'] = -($current_size['width']/2 - $previous_size['width']/2);
			else if ($firstNB && $this->props['menu_alignment'] === 'justified')
				$item_pos['tX'] =   -($current_size['width']/2-$previous_size['width']/2) - $distance/2;
			else if (!$firstNB) {
				$item_pos['tX'] -= ($previous_size['width'] - ($previous_size['width']-$current_size['width'])/2) + $distance;
				$bg_pos['tX_offset'] = -$width + $bg_padding + $current_size['width']/2; 	
				if ($this->props['menu_alignment'] === 'center' && $this->props['hide_button'] === 'off') 
					$bg_pos['tX_offset'] = -$width + $bg_padding + $mb_width/2;
				if ($this->props['menu_alignment'] === 'justified')
					$bg_pos['tX_offset'] += ($width /2 - ($current_size['width']/2) - $bg_padding); 
			}
		}
	}
	
	function get_menu_position($items, $menu_width, $mb_size, $item_size, $largest_size, $bg_padding, $distance, $device) {
		$m_left_offset = 0; 
		if ($this->props['menu_type'] === 'circular') {
			$circular_type = $this->props['circle_menu_items_alignment'];
			$item_border_size = DiviMenusHelper::get_largest_border_item($items, $device);
			if ($this->props['menu_alignment'] === 'left' && $circular_type === 'semicircle_right')
				$m_left_offset = $bg_padding + ($item_border_size > $mb_size['width'] ? $item_border_size/2 : $mb_size['width']/2);
			else if ($this->props['menu_alignment'] === 'left')
				$m_left_offset = $menu_width / 2; 
			else if ($this->props['menu_alignment'] === 'right' && $circular_type === "semicircle_left")
				$m_left_offset = -$bg_padding - ($item_border_size > $mb_size['width'] ? $item_border_size/2 : $mb_size['width']/2);
			else if ($this->props['menu_alignment'] === 'right')
				$m_left_offset = - $menu_width / 2;
			else if ($this->props['menu_alignment'] === 'justified' && ($circular_type === "circle" || $circular_type === "semicircle_top" || $circular_type === "semicircle_bottom")) {
				if (!DiviMenusHelper::has_background($this->props) && count($items) === 1)
					$m_left_offset = $menu_width / 4 - $mb_size['width'] / 4;
			} else if ($this->props['menu_alignment'] === 'justified' && ($circular_type === "semicircle_left" || $circular_type === "semicircle_right")) {
				if (count($items) > 0) {
					$degrees = count($items) > 2 ? (90 / (count($items)-1)): 0;
					$width_calc = ( $menu_width / 4) - (DiviMenusHelper::has_background($this->props) ? $bg_padding /2 : 0);
					if ($circular_type === 'semicircle_left') {
						$m_left_offset += $width_calc;
						if (!DiviMenusHelper::has_background($this->props))
							$m_left_offset -= ($width_calc - ($width_calc*cos($degrees * pi() / 180)));
						if (count($items) > 1) {
							if (!($this->props['show_open'] === 'on' && $this->props['hide_button'] === 'on') && ($mb_size['width'] > $item_border_size))
								$m_left_offset -= $mb_size['width'] / 4;
							if (($this->props['show_open'] === 'on' && $this->props['hide_button'] === 'on') || ($mb_size['width'] <= $item_border_size))
								$m_left_offset -= $item_border_size/4; 
						} else // else if (isset($items))
							$m_left_offset -= $mb_size['width'] / 4;
					} else { // semicircle right
						$m_left_offset -= $width_calc; 
						if (!DiviMenusHelper::has_background($this->props))
							$m_left_offset += ($width_calc - ($width_calc * cos($degrees * pi() / 180))); 
						if (count($items) > 1) {
							if (!($this->props['show_open'] === 'on' && $this->props['hide_button'] === 'on') && ($mb_size['width'] > $item_border_size))
								$m_left_offset += $mb_size['width'] / 4;
							if (($this->props['show_open'] === 'on' && $this->props['hide_button'] === 'on') || ($mb_size['width'] <= $item_border_size)) 
								$m_left_offset += $item_border_size/4;
						} else // else if (isset($items)) 
							$m_left_offset += $mb_size['width'] / 4;
					}
					if (!DiviMenusHelper::has_background($this->props) && count($items) === 2) 
						$m_left_offset = 0; 
				}
			}
			if (DiviMenusHelper::has_background($this->props) && $this->props['show_open'] === 'on' && $this->props['hide_button'] === 'on' && $this->props['menu_alignment'] !== 'justified') {
				if ($circular_type === "semicircle_left" && $this->props['menu_alignment'] !== 'left')
				  $m_left_offset += $mb_size['width'] > $item_border_size ? $mb_size['width']/2-$item_border_size/2 : 0;
				else if ($circular_type === "semicircle_right" && $this->props['menu_alignment'] !== 'right')
				  $m_left_offset -= $mb_size['width'] > $item_border_size ? $mb_size['width']/2-$item_border_size/2 : 0;
			}
			if ($this->props['menu_alignment'] === 'justified' && !DiviMenusHelper::has_background($this->props) && $this->props['show_open'] === 'on' && $this->props['hide_button'] === 'on' && count($items) === 1)
				$m_left_offset = 0;
		} else { // horizontal and vertical DiviMenus
			$cip = $this->props['central_item_inline_menu_position'];
			if ($this->props['menu_alignment'] === 'left' && $this->props['menu_type'] === 'horizontal' && $cip === 'first')
				$m_left_offset += ($mb_size['width']/2) + $bg_padding;	
			else if ($this->props['menu_alignment'] === 'left' && $this->props['menu_type'] === 'horizontal' && $cip === 'middle')
				$m_left_offset += DiviMenusHelper::get_menu_width_before($this->props['menu_type'], $items, $distance, $mb_size, $device) + $bg_padding;
			else if ($this->props['menu_alignment'] === 'left' && $this->props['menu_type'] === 'horizontal' && $cip === 'last')
				$m_left_offset += $menu_width - ($mb_size['width']/2) - $bg_padding;
			else if ($this->props['menu_alignment'] === 'left' && $this->props['menu_type'] === 'vertical')	
				$m_left_offset += ($this->props['show_open'] === 'on' && $this->props['hide_button'] === 'on' ? $item_size['width']/2 : $largest_size['width']/2) + $bg_padding;
			else if ($this->props['menu_alignment'] === 'right' && $this->props['menu_type'] === 'horizontal' && $cip === 'first')
				$m_left_offset -= $menu_width - ($mb_size['width']/2) - $bg_padding;
			else if ($this->props['menu_alignment'] === 'right' && $this->props['menu_type'] === 'horizontal' && $cip === 'middle')
				$m_left_offset -= (DiviMenusHelper::get_menu_width_after($this->props['menu_type'], $items, $distance, $mb_size, $device) + $bg_padding);
			else if ($this->props['menu_alignment'] === 'right' && $this->props['menu_type'] === 'horizontal' && $cip === 'last')
				$m_left_offset -=   ($mb_size['width']/2) + $bg_padding;		
			else if ($this->props['menu_alignment'] === 'right' && $this->props['menu_type'] === 'vertical')	
				$m_left_offset -= ($this->props['show_open'] === 'on' && $this->props['hide_button'] === 'on' ? $item_size['width']/2 : $largest_size['width']/2) + $bg_padding;
			else if ($this->props['menu_alignment'] === 'justified' && $this->props['menu_type'] === 'horizontal' && $cip === 'middle') 
				$m_left_offset -= ((DiviMenusHelper::get_menu_width_after($this->props['menu_type'], $items, $distance, $mb_size, $device) + $bg_padding) /2 - (DiviMenusHelper::get_menu_width_before($this->props['menu_type'], $items, $distance, $mb_size, $device) + $bg_padding) /2);
			else if ($this->props['menu_alignment'] === 'justified' && $this->props['menu_type'] === 'horizontal' && $cip === 'first') 
				$m_left_offset -= ($menu_width /2 - ($mb_size['width']/2) - $bg_padding);
			else if ($this->props['menu_alignment'] === 'justified' && $this->props['menu_type'] === 'horizontal' && $cip === 'last') 
				$m_left_offset += ($menu_width /2 - ($mb_size['width']/2) - $bg_padding);
		}
		return $m_left_offset;
	}

	function get_menu_background($items, $width, $mb_size, $mb_content_size, $bg_padding, $menu_left, $device) {
		$circular_type = $this->props['circle_menu_items_alignment'];
		$item_border_size = DiviMenusHelper::get_largest_border_item($items, $device);
		
		$width_offset = $height_offset = 0;		
		$tX = $tY = $tX_offset = $tY_offset = 0;
		if ($this->props['menu_type'] === 'circular') {
			if ($circular_type === 'semicircle_left' || $circular_type === 'semicircle_right') {
				$width_offset = ($width *  0.50) -  $bg_padding - $mb_size['width'] / 2;
				if (count($items) > 1 && $item_border_size > $mb_size['width']) {
					$width_offset -= ($item_border_size-$mb_size['width']) / 2;
				} else if (count($items) > 1 && $this->props['show_open'] === 'on' && $this->props['hide_button'] === 'on') 
					$width_offset += ($mb_size['width']-$item_border_size)/2;
			}
			if ($circular_type === "semicircle_top" || $circular_type === "semicircle_bottom") {
				if ($this->props['central_item_select'] === 'central_item_text_option' && $this->props['central_item_use_circle'] === 'off') {
					$height_offset = ($width *  0.50) - $bg_padding - $mb_content_size['height']/2;
					if ($item_border_size > $mb_content_size['height']) 
						$height_offset -= ($item_border_size - $mb_content_size['height'])/2;
					else if ($this->props['show_open'] === 'on' && $this->props['hide_button'] === 'on') 
						$height_offset += ($mb_content_size['height'] - $item_border_size)/2;	
				} else {
					$height_offset = ($width *  0.50)  - $bg_padding - $mb_size['height']/2;
					if ( $item_border_size > $mb_size['height'])  
						$height_offset -= ($item_border_size-$mb_size['height'])/2;
					else if ($this->props['show_open'] === 'on' && $this->props['hide_button'] === 'on') 
						$height_offset += ($mb_size['height'] - $item_border_size)/2; 
				}			
			}

			if ($this->props['menu_alignment'] !== 'left' ) { 
				$tX = $circular_type === 'semicircle_left' && $this->props['menu_alignment'] !== 'right' ? $menu_left + 50 : ($circular_type === 'semicircle_right' && $this->props['menu_alignment'] !== 'right' ? $menu_left - 50 : $menu_left);
			}
	
			$tY = $circular_type === 'semicircle_top' || $circular_type === 'semicircle_bottom' ? 0 :  50;	
	
			if ($circular_type === "semicircle_left") {
				$tX_offset = ($mb_size['width'] / 2) + $bg_padding;				
				if (count($items) > 1 && $item_border_size > $mb_size['width'])  
					$tX_offset +=(($item_border_size - $mb_size['width']))/2;
				if ($this->props['menu_alignment'] === 'justified') {
					$tX = 50;
					$tX_offset = 0;
				}    
			} else if ($circular_type === "semicircle_right") {
				$tX_offset = - $bg_padding - ($mb_size['width'] / 2);
				if ($item_border_size > $mb_size['width'])
					$tX_offset -=(($item_border_size - $mb_size['width']))/2;
				if ($this->props['menu_alignment']=== 'justified') {
					$tX = 50;
					$tX_offset = 0; 
				}
			} 
			if ($this->props['menu_alignment'] === 'left' || $this->props['menu_alignment'] === "right") {
				$tX_offset = 0;
			}

			if ($circular_type === 'semicircle_top') {
				$tY_offset = $this->props['inside_container'] !== 'on' ? $bg_padding : 0;
				if ($this->props['central_item_select'] === 'central_item_text_option' && $this->props['central_item_use_circle'] === 'off' && $this->props['inside_container'] !== 'on') {
					if ($item_border_size >= $mb_content_size['height'])  				
						$tY_offset += ($item_border_size-$mb_content_size['height'])/2;				 								
					if ($mb_content_size['height'] > $item_border_size)				
						$tY_offset += ($mb_content_size['height'] - $item_border_size)/2;									
				}
				if ($this->props['inside_container'] !== 'on') {	
					if ($item_border_size >= $mb_size['height']) 
						$tY_offset += ($item_border_size-$mb_size['height'])/2;				
				}

			} else if ($circular_type === 'semicircle_bottom') {
				$tY_offset = $this->props['inside_container'] !== 'on' ? - $bg_padding : 0;
				if ($this->props['central_item_select'] === 'central_item_text_option' && $this->props['central_item_use_circle'] === 'off' &&  $this->props['inside_container'] !== 'on') {	
					if ($item_border_size >= $mb_content_size['height'])
						$tY_offset-=($item_border_size - $mb_content_size['height'])/2;
					if ($mb_content_size['height'] > $item_border_size) 					
						$tY_offset -= ($mb_content_size['height']-$item_border_size)/2;							
				} else if ($this->props['inside_container'] !== 'on') {
					if ($item_border_size >= $mb_size['height'])
						$tY_offset-=($item_border_size-$mb_size['height'])/2;
				}
			}
		}

		$border_radius_top_left = $border_radius_top_right = $border_radius_bottom_right = $border_radius_bottom_left = $width * 2;
		if ($this->props['menu_type'] === 'circular' && ($circular_type === 'semicircle_bottom' || $circular_type === 'semicircle_right'))
			$border_radius_top_left = 0;
		if ($this->props['menu_type'] === 'circular' && ($circular_type === 'semicircle_bottom' || $circular_type === 'semicircle_left'))
			$border_radius_top_right = 0;
		if ($this->props['menu_type'] === 'circular' && ($circular_type === 'semicircle_top' || $circular_type === 'semicircle_left'))
			$border_radius_bottom_right = 0;
		if ($this->props['menu_type'] === 'circular' && ($circular_type === 'semicircle_top' || $circular_type === 'semicircle_right'))
			$border_radius_bottom_left = 0; 
		if ($this->props['menu_type'] === 'vertical' && $this->props['central_item_select'] === "central_item_text_option" && $this->props['central_item_use_circle'] === 'off' && $this->props['central_item_inline_menu_position'] === 'first') {
			$border_radius_top_left = 0;
			$border_radius_top_right = 0;
		}
		if ($this->props['menu_type'] === 'vertical' && $this->props['central_item_select'] === "central_item_text_option" && $this->props['central_item_use_circle'] ==="off" && $this->props['central_item_inline_menu_position'] === 'last') {
			$border_radius_bottom_right = 0;
			$border_radius_bottom_left = 0;
		}
		return array(
			'width_offset' => $width_offset,
			'height_offset' => $height_offset,
			'tX' => $tX,
			'tY' => $tY,
			'tX_offset' => $tX_offset,
			'tY_offset' => $tY_offset,
			'BRTL' => $this->props['square_corners'] === 'on' ? 0 : $border_radius_top_left,
			'BRTR' => $this->props['square_corners'] === 'on' ? 0 : $border_radius_top_right,
			'BRBR' => $this->props['square_corners'] === 'on' ? 0 : $border_radius_bottom_right,
			'BRBL' => $this->props['square_corners'] === 'on' ? 0 : $border_radius_bottom_left,
		);
	}
	
	function get_menu_width($items, $mb_size, $item_size, $largest_size, $bg_padding, $distance, $device) {	
		$menu_width = ($this->props['menu_type'] === 'circular' ? $mb_size['circular'] : 
			($this->props['show_open'] === 'on' && $this->props['hide_button'] === 'on' ? 0 : ( $this->props['menu_type'] === 'vertical' ? $mb_size['height'] : $mb_size['width'])) ) + ($bg_padding * 2);
		$vertical = 0;

		if ($this->props['menu_type'] === 'circular') {
			if (!empty($items))	{ 
				$menu_width += ($distance * 2);
				if ($this->props['circle_menu_items_alignment'] === 'circle' && count($items) > 1) {
					$largest_opposite_items_width = DiviMenusHelper::get_largest_opposite_items_width($items, $device);
					$menu_width += $largest_opposite_items_width['total'];
	
					if ($mb_size['circular'] <= $largest_opposite_items_width['item1'])  			
						$menu_width += (($largest_opposite_items_width['item1'] - $largest_opposite_items_width['item2']));
					if ($mb_size['circular'] > $largest_opposite_items_width['item1'])
						$menu_width -= ($mb_size['circular'] - $largest_opposite_items_width['item1']) - ($mb_size['circular'] - $largest_opposite_items_width['item2']); 			
				} else {		 
					$menu_width += ($item_size['width'] * 2);
				}
			}
		} else { // horizontal and vertical DMs
			if (!empty($items)) { 
				$menu_width += ( DiviMenusHelper::get_items_width($items, $this->props['menu_type'], $device) + ($distance * count($items)) );
				$vertical = ($bg_padding * 2) + ($this->props['show_open'] === 'on' && $this->props['hide_button'] === 'on' ? ($this->props['menu_type'] === 'vertical' ? $item_size['width'] : $item_size['height']) :
					( $this->props['menu_type'] === 'vertical' ? $largest_size['width'] : $largest_size['height']) );
			}
		}
		return array(
			'dm' => $menu_width,
			'vertical' => $vertical
		);
	}

	function get_module_height($items, $n, $menu, $mb, $distance, $bg_padding, $bg_offset, $item_size, &$mb_top, &$mi_top, $device) {
		$module_height = ($this->props['show_open'] === 'on' && $this->props['hide_button'] === 'on') ? 0 : $mb['height'];
		$item_border_size = DiviMenusHelper::get_largest_border_item($items, $device);
		if ($n > 0 && $this->props['menu_type'] === 'circular' && $this->props['inside_container'] === 'on') {
			$module_height = $menu['dm'];
			$mb_top = $module_height/2 - $mb['height']/2;
			if (!DiviMenusHelper::has_background($this->props) && (($n === 1 && ($this->props['circle_menu_items_alignment'] === 'semicircle_left' || $this->props['circle_menu_items_alignment'] === 'semicircle_right')) 
				|| ($n < 3 && ($this->props['circle_menu_items_alignment'] === 'circle' || $this->props['circle_menu_items_alignment'] === 'semicircle_top' || $this->props['circle_menu_items_alignment'] === 'semicircle_bottom')))  ) {
				$module_height = $this->props['show_open'] === 'on' && $this->props['hide_button'] === 'on' ? $item_size['height'] : max($mb['height'], $item_size['height']); 
				$mb_top = $module_height/2 - $mb['height']/2;
			} else if ($this->props['circle_menu_items_alignment'] === 'semicircle_top' || $this->props['circle_menu_items_alignment'] === 'semicircle_bottom') { 
				$module_height = $module_height - $bg_offset;
				if ($this->props['circle_menu_items_alignment'] === 'semicircle_top') {
					$mb_top = $mi_top = $module_height - $bg_padding;
					$mb_top -=  $item_border_size > $mb['height'] ? ($item_border_size/2 + $mb['height']/2) : $mb['height'];
					$mi_top -= $item_border_size > $mb['height'] || ($this->props['show_open'] === 'on' && $this->props['hide_button'] === 'on') ? $item_border_size/2 : $mb['height']/2;
				} else if ($this->props['circle_menu_items_alignment'] === 'semicircle_bottom') {
					$mb_top = $mi_top = $bg_padding;
					$mb_top +=  $item_border_size > $mb['height'] ? ($item_border_size/2 - $mb['height']/2) : 0;
					$mi_top += $item_border_size > $mb['height'] || ($this->props['show_open'] === 'on' && $this->props['hide_button'] === 'on') ? $item_border_size/2 : $mb['height']/2;
				}
			}			  
		} else if ($n > 0 && $this->props['menu_type'] === 'circular') {
			if ($this->props['circle_menu_items_alignment'] === 'semicircle_top') 
				$mi_top = $this->props['show_open'] === 'on' && $this->props['hide_button'] === 'on' && $mb['height'] > $item_border_size ? $module_height - $item_border_size/2 : $mb['height']/2;         
			else if ($this->props['circle_menu_items_alignment'] === 'semicircle_bottom')
				$mi_top = $this->props['show_open'] === 'on' && $this->props['hide_button'] === 'on' && $mb['height'] > $item_border_size ? $item_border_size/2 : $mb['height']/2;         
		}
		if ($n > 0 && $this->props['menu_type'] === 'horizontal') {
			$module_height = DiviMenusHelper::has_background($this->props) ? $menu['vertical'] : ($this->props['show_open'] === 'on' && $this->props['hide_button'] === 'on' ? $item_size['height'] : max($mb['height'], $item_size['height']));
			$mb_top = $module_height/2 - $mb['height']/2;
		}
		if ($n > 0 && $this->props['menu_type'] === 'vertical' && $this->props['inside_container'] === 'on') {
			$module_height = $menu['dm'];
			$maybe_padding = DiviMenusHelper::has_background($this->props) ? $bg_padding : 0;
			if ($this->props['central_item_inline_menu_position'] === 'first') {
				$mb_top = $maybe_padding;
				$mi_top = $this->props['show_open'] === 'on' && $this->props['hide_button'] === 'on' ? $maybe_padding : $mb['height']/2 + $maybe_padding;
			} else if ($this->props['central_item_inline_menu_position'] === 'last') {
				$mb_top = $menu['dm'] - $mb['height'] - $maybe_padding;
				$mi_top = $this->props['show_open'] === 'on' && $this->props['hide_button'] === 'on' ? $menu['dm'] - $maybe_padding : $menu['dm'] - $mb['height']/2 - $maybe_padding;
			} else {
				$mb_top = DiviMenusHelper::get_menu_width_before($this->props['menu_type'], $items, $distance, $mb, $device) - $mb['height']/2 + $maybe_padding;
				$mi_top = DiviMenusHelper::get_menu_width_before($this->props['menu_type'], $items, $distance, $mb, $device) + $maybe_padding;
			}
		} else if ($n > 0 && $this->props['menu_type'] === 'vertical') {
			if ($this->props['central_item_inline_menu_position'] === 'first')
				$mi_top = $this->props['show_open'] === 'on' && $this->props['hide_button'] === 'on' ? 0: $mb['height']/2;
			else if ($this->props['central_item_inline_menu_position'] === 'last') {  
				$mb_top = $module_height - $mb['height'];
				$mi_top = $this->props['show_open'] === 'on' && $this->props['hide_button'] === 'on' ? $module_height : $module_height - $mb['height']/2;
			} else
				$mi_top = $mb['height']/2;
		}
		return $module_height;
	}

	function set_tooltip($items, $i, $mb_size, $mb_size_t, $mb_size_p, $et_pb_divimenus_render_on_tablet, $et_pb_divimenus_render_on_phone, $render_slug) {
		$tooltip_top = $tooltip_bottom = $tooltip_left = $tooltip_right = 'auto';
		$tooltip_top_t = $tooltip_bottom_t = $tooltip_left_t = $tooltip_right_t = 'auto';
		$tooltip_top_p = $tooltip_bottom_p = $tooltip_left_p = $tooltip_right_p = 'auto';
		$tooltip_tX = $tooltip_tX_t = $tooltip_tX_p = -50;
		$tooltip_tY = $tooltip_tY_t = $tooltip_tY_p = 0;
		
		$title_selector = $items ? sprintf('%%order_class%% .dd-divimenu-open .dd-menu-items>div:nth-child(%1$d) .dd-title', $i+1) : '%%order_class%% .dd-menu-button .dd-title';
		$tooltip_selector = $items ? sprintf('%%order_class%% .dd-divimenu-open .dd-menu-items>div:nth-child(%1$d) .dd-tooltip', $i+1) : '%%order_class%% .dd-menu-button .dd-tooltip';
		$title_behavior = $items ? $this->props['tooltip_behavior'] : $this->props['mb_title_behavior'];
		$title_display_phone = $items ? $this->props['tooltip_display_phone'] : $this->props['mb_title_display_phone'];
		$title_disable_phone = $items ? $this->props['tooltip_disable_phone'] : $this->props['mb_title_disable_phone'];

		$elem_size = $items ? $items[$i]['size'] : $mb_size;
		$elem_size_t = $items ? $items[$i]['size_t'] : $mb_size_t;
		$elem_size_p = $items ? $items[$i]['size_p'] : $mb_size_p;

		$mb_title_position = et_pb_responsive_options()-> get_property_values($this->props, 'mb_title_position', $this->props['mb_title_position'], true);
		$mi_title_position = et_pb_responsive_options()-> get_property_values($this->props, 'tooltip_position', $this->props['tooltip_position'], true);

		$tooltip_position = $items && $items[$i]['title_position'] !== 'inherit' ? $items[$i]['title_position'] : ($items ? $mi_title_position['desktop'] : $mb_title_position['desktop']);
		$tooltip_position_tablet = $items && $items[$i]['title_t'] !== 'inherit' ? $items[$i]['title_t'] : ($items ? $mi_title_position['tablet'] : $mb_title_position['tablet']);
		$tooltip_position_phone = $items && $items[$i]['title_p'] !== 'inherit' ? $items[$i]['title_p'] : ($items ? $mi_title_position['phone'] :  $mb_title_position['phone']);
		
		if ($tooltip_position === 'top') {
			$tooltip_bottom = ($elem_size['height']/2).'px';
		} else if ($tooltip_position === 'bottom') {
			$tooltip_top = ($elem_size['height']/2).'px';
		} else if ($tooltip_position === 'left') {
			$tooltip_right = ($elem_size['width']/2).'px';
			$tooltip_tX = 0;
			$tooltip_tY = -50;
		} else if ($tooltip_position === 'right') {
			$tooltip_left = ($elem_size['width']/2).'px';
			$tooltip_tX = 0;
			$tooltip_tY = -50;
		}			
		if ($tooltip_position_tablet === 'top') {
			$tooltip_bottom_t = ($elem_size_t['height']/2).'px';
		} else if ($tooltip_position_tablet === 'bottom') {
			$tooltip_top_t = ($elem_size_t['height']/2).'px';
		} else if ($tooltip_position_tablet === 'left') {
			$tooltip_right_t = ($elem_size_t['width']/2).'px';
			$tooltip_tX_t = 0;
			$tooltip_tY_t = -50;
		} else if ($tooltip_position_tablet === 'right') {
			$tooltip_left_t = ($elem_size_t['width']/2).'px';
			$tooltip_tX_t = 0;
			$tooltip_tY_t = -50;
		}
		if ($tooltip_position_phone === 'top') {
			$tooltip_bottom_p = ($elem_size_p['height']/2).'px';
		} else if ($tooltip_position_phone === 'bottom') {
			$tooltip_top_p = ($elem_size_p['height']/2).'px';
		} else if ($tooltip_position_phone === 'left') {
			$tooltip_right_p = ($elem_size_p['width']/2).'px';
			$tooltip_tX_p = 0;
			$tooltip_tY_p = -50;
		} else if ($tooltip_position_phone === 'right') {
			$tooltip_left_p = ($elem_size_p['width']/2).'px';
			$tooltip_tX_p = 0;
			$tooltip_tY_p = -50;
		}

		$mb_title_offset = et_pb_responsive_options()-> get_property_values($this->props, 'mb_title_offset', $this->props['mb_title_offset'], true);
		$mi_title_offset = et_pb_responsive_options()-> get_property_values($this->props, 'tooltip_padding', $this->props['tooltip_padding'], true);

		$title_offset = $items ? $mi_title_offset['desktop'] : $mb_title_offset['desktop'];
		$title_offset_t = $items ? $mi_title_offset['tablet'] : $mb_title_offset['tablet'];
		$title_offset_p = $items ? $mi_title_offset['phone'] : $mb_title_offset['phone'];

		$margin = $margin_t = $margin_p = '0px 0px 0px 0px';
		if ($tooltip_position === 'right') {
			$margin = "0px 0px 0px $title_offset";
		} else if ($tooltip_position === 'top') {
			$margin = "0px 0px $title_offset 0px";
		} else if ($tooltip_position === 'left') {
			$margin = "0px $title_offset 0px 0px";
		} else if ($tooltip_position === 'bottom') {
			$margin = "$title_offset 0px 0px 0px";
		}
		if ($tooltip_position_tablet === 'right') {
			$margin_t = "0px 0px 0px $title_offset_t";
		} else if ($tooltip_position_tablet === 'top') {
			$margin_t = "0px 0px $title_offset_t 0px";
		} else if ($tooltip_position_tablet === 'left') {
			$margin_t = "0px $title_offset_t 0px 0px";
		} else if ($tooltip_position_tablet === 'bottom') {
			$margin_t = "$title_offset_t 0px 0px 0px";
		}
		if ($tooltip_position_phone === 'right') {
			$margin_p = "0px 0px 0px $title_offset_p";
		} else if ($tooltip_position_phone === 'top') {
			$margin_p = "0px 0px $title_offset_p 0px";
		} else if ($tooltip_position_phone === 'left') {
			$margin_p = "0px $title_offset_p 0px 0px";
		} else if ($tooltip_position_phone === 'bottom') {
			$margin_p = "$title_offset_p 0px 0px 0px";
		}

		$tooltip_text_align = $tooltip_text_align_t = $tooltip_text_align_p = 'center';
		if ($tooltip_position === 'right')  
			$tooltip_text_align = 'left';
		else if ($tooltip_position === 'left') 
			$tooltip_text_align = 'right';
		if ($tooltip_position_tablet === 'right' ) 
			$tooltip_text_align_t = 'left';
		else if ($tooltip_position_tablet === 'left') 
			$tooltip_text_align_t = 'right';
		if ($tooltip_position_phone === 'right' ) 
			$tooltip_text_align_p = 'left';
		else if ($tooltip_position_phone === 'left') 
			$tooltip_text_align_p = 'right';

		if (substr($this->props['tooltip_width'], -2) !== 'px') $this->props['tooltip_width'] .= 'px';  // backward compatibility
		if (!empty($this->props['tooltip_width_tablet']) && substr($this->props['tooltip_width_tablet'], -2) !== 'px') $this->props['tooltip_width_tablet'] .= 'px';
		if (!empty($this->props['tooltip_width_phone']) && substr($this->props['tooltip_width_phone'], -2) !== 'px') $this->props['tooltip_width_phone'] .= 'px';
		if (substr($this->props['mb_title_width'], -2) !== 'px') $this->props['mb_title_width'] .= 'px';  // backward compatibility
		
		$mb_title_width = et_pb_responsive_options()-> get_property_values($this->props, 'mb_title_width', $this->props['mb_title_width'], true);
		$mi_title_width = et_pb_responsive_options()-> get_property_values($this->props, 'tooltip_width', $this->props['tooltip_width'], true);
		
		ET_Builder_Element::set_style( $render_slug, array(
			'selector'    => $title_selector,
			'declaration' => sprintf('position: absolute; text-align:%8$s; top: %1$s; bottom: %2$s; left: %3$s; right: %4$s; 
				transform: translate(%5$d%%, %6$d%%); max-width: %9$s; line-height: %7$s; margin: %10$s;',
				$tooltip_top,
				$tooltip_bottom,
				$tooltip_left,
				$tooltip_right,
				$tooltip_tX, #5
				$tooltip_tY,
				$items? $this->props['tooltip_line_height'] : $this->props['mb_title_line_height'], // the advanced field takes care of the responsive values
				$tooltip_text_align,
				$items ? $mi_title_width['desktop'] : $mb_title_width['desktop'],
				$margin )
			)
		);
		if ($et_pb_divimenus_render_on_tablet) {
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => $title_selector,
				'declaration' => sprintf('top: %1$s; bottom: %2$s; left: %3$s; right: %4$s; text-align: %9$s; transform: translate(%7$d%%, %8$d%%); max-width: %5$s; margin: %6$s;',			
					$tooltip_top_t,
					$tooltip_bottom_t,
					$tooltip_left_t,
					$tooltip_right_t,
					$items ? $mi_title_width['tablet'] : $mb_title_width['tablet'],
					$margin_t,
					$tooltip_tX_t,
					$tooltip_tY_t,
					$tooltip_text_align_t
					), 						
				'media_query' => ET_Builder_Element::get_media_query( '768_980' ),
				)
			);
			if ($title_display_phone === 'on') {
				DiviMenusHelper::set_style( $render_slug, $tooltip_selector, 'opacity: 1;', 't');
			}
		}
		if ($et_pb_divimenus_render_on_phone) {
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => $title_selector,
				'declaration' => sprintf('top: %1$s; bottom: %2$s; left: %3$s; right: %4$s; text-align: %9$s; transform: translate(%7$d%%, %8$d%%); max-width: %5$s; margin: %6$s;',			
					$tooltip_top_p,
					$tooltip_bottom_p,
					$tooltip_left_p,
					$tooltip_right_p,
					$items ? $mi_title_width['phone'] : $mb_title_width['phone'],
					$margin_p,
					$tooltip_tX_p,
					$tooltip_tY_p,
					$tooltip_text_align_p  ),						
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				)
			);
			if ($title_display_phone === 'on') {
				DiviMenusHelper::set_style( $render_slug, $tooltip_selector, 'opacity: 1 !important;', 'p');
			}
			if ($title_disable_phone === 'on') {
				DiviMenusHelper::set_style( $render_slug, $title_selector, 'display: none;', 'p');
			}
		}
		if ($title_behavior === 'always') {
			DiviMenusHelper::set_style( $render_slug, $tooltip_selector, 'opacity: 1;');
		} 
	}
	
}

new DiviMenus_Module;