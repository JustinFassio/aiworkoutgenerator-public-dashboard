<?php

class DiviMenusFlex_Module extends ET_Builder_Module {

	public $slug       = 'et_pb_divimenus_flex';
	public $vb_support = 'on';

	protected $module_credits = array(
		'module_uri' => 'https://dondivi.com/',
		'author'     => 'DonDivi',
		'author_uri' => 'https://dondivi.com/',
	);

	public function init() {
		$this->name = esc_html__( 'DiviMenus Flex', 'divimenus' );

		$this->icon_path        =  plugin_dir_path( __FILE__ ) . 'icon.svg';

		$this->child_slug      	= 'et_pb_divimenus_flex_item';
		$this->child_item_text 	= esc_html__( 'Menu Item', 'divimenus' );	

		$this->main_css_element = '%%order_class%%';

		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content' 	=> esc_html__( 'DiviMenu', 'divimenus' ),
					'logo'        	=> esc_html__( 'Logo', 'et_builder' ),
					'menu_button'  	=> esc_html__( 'Menu Button', 'divimenus' ),
					'menu_items' 	=> esc_html__( 'Menu Items', 'divimenus' ),						
				),
			),
			'advanced' => array(
				'toggles' => array(
					'divimenu'			=> 	esc_html__( 'DiviMenu', 'divimenus' ),
					'logo'        		=> esc_html__( 'Logo', 'et_builder' ),
					'menu_button_bg' 	=> 	esc_html__( 'Menu Button', 'divimenus' ),
					'text_settings' 	=> 	esc_html__( 'Menu Button TEXT', 'divimenus' ),
					'icon_settings' 	=> 	esc_html__( 'Menu Button ICON', 'divimenus' ),
					'image_settings' 	=> 	esc_html__( 'Menu Button IMAGE', 'divimenus' ),
					'menu_items' 		=> 	esc_html__( 'Menu Items', 'divimenus' ),
					'menu_item_text' 	=> 	esc_html__( 'Menu Items TEXT', 'divimenus' ),
					'menu_item_icon' 	=> 	esc_html__( 'Menu Items ICON', 'divimenus' ),
					'menu_item_image' 	=> 	esc_html__( 'Menu Items IMAGE', 'divimenus' ),
				),
			),
		);
		
		$this->advanced_fields = array(
			'borders' => array(
				'default' => array(),
				'menu_button' => array(
					'css' => array(
						'main' => array(
							'border_radii' =>  "{$this->main_css_element} .dd-menu-button-content, {$this->main_css_element} .dd-menu-button-content > img",
							'border_styles' => "{$this->main_css_element} .dd-menu-button-content",
							'border_radii_hover' =>  "{$this->main_css_element} .dd-menu-button-content.hover, {$this->main_css_element} .dd-divimenu-open .dd-menu-button-content,
									{$this->main_css_element} .dd-menu-button-content.hover > img, {$this->main_css_element} .dd-divimenu-open .dd-menu-button-content > img",
							'border_styles_hover' => "{$this->main_css_element} .dd-menu-button-content.hover, {$this->main_css_element} .dd-divimenu-open .dd-menu-button-content",
						),
					),
					'toggle_slug' 	=> 'menu_button_bg',
				),
				'menu_item' => array(
					'css' => array(
						'main' => array(
							'border_radii' =>  "{$this->main_css_element} .dd-menu-item-content, {$this->main_css_element} .dd-item-inner > img",
							'border_styles' => "{$this->main_css_element} .dd-menu-item-content",
							'border_radii_hover' =>  "{$this->main_css_element} .dd-menu-item-content.hover, {$this->main_css_element} .dd-menu-item-content.active,
													{$this->main_css_element} .dd-menu-item-content.hover > .dd-item-inner > img, {$this->main_css_element} .dd-menu-item-content.active > .dd-item-inner > img",
							'border_styles_hover' => "{$this->main_css_element} .dd-menu-flex-sub .dd-menu-item-content:hover, {$this->main_css_element} .dd-menu-item-content.hover, {$this->main_css_element} .dd-menu-item-content.active",
						),
					),
					'toggle_slug' 	=> 'menu_items',
				),
			),
			'box_shadow' => array(		
				'default' => array(),
				'menu_button' => array (
					'label'    				=> esc_html__( 'Menu Button', 'divimenus' ),
					'css' => array( 
						'main' => "{$this->main_css_element} .dd-menu-button-content",
						'hover' => "{$this->main_css_element} .dd-menu-button-content.hover, {$this->main_css_element} .dd-divimenu-open .dd-menu-button-content",												
					),			
				),
				'menu_button_image' => array (
					'label'    				=> esc_html__( 'Menu Button Image', 'divimenus' ),
					'css' => array(
						'main' => "{$this->main_css_element} .dd-menu-button-content > img" 														
					),	
					'depends_on'    	=> array( 'menu_button_content' ),
					'depends_show_if' 	=> 'image',				
				),
				'menu_item' => array (
					'label'    				=> esc_html__( 'Menu Items', 'divimenus' ),
					'css' => array(
						'main' => "{$this->main_css_element} .dd-menu-item-content",
						'hover' => "{$this->main_css_element} .dd-menu-item-content.hover, {$this->main_css_element} .dd-menu-item-content.active", 														
					),				
				),
				'menu_item_image' => array (
					'label'    				=> esc_html__( 'Menu Items Image', 'divimenus' ),
					'css' => array(
						'main' => "{$this->main_css_element} .dd-item-inner > img" 														
					),			
				),
			),
			'fonts' => array(
				'menu_button' => array(
					'css'      				=> array(
						'main' 	=> "{$this->main_css_element} .dd-menu-button-content.dd-item.dd-text", // WA for sticky
						'hover' => "{$this->main_css_element} .dd-menu-button-content.dd-text.hover, {$this->main_css_element} .dd-divimenu-open .dd-menu-button-content.dd-text"
					),
					'font_size' => array(
						'default'  => '14px',
					),
					'text_color' => array (
						'default' => '#ffffff',
					),
					'hide_text_align' 	=> true,
					'hide_text_shadow'	=> true,
					'depends_show_if'  	=> 'text',
					'toggle_slug'     	=> 'text_settings',
				),
				'menu_item' => array(
					'css'      				=> array(
						'main' 	=> "{$this->main_css_element} .dd-menu-item-content.dd-text", 
						'hover' => "{$this->main_css_element} .dd-mi .dd-menu-item-content.dd-text.hover, {$this->main_css_element} .dd-mi .dd-menu-item-content.dd-text.active, 
							{$this->main_css_element} .dd-menu-flex-sub .dd-menu-item-content.dd-text:hover",
					), 
					'font_size' => array(
						'default' 	=> '15px',
						'sticky' => false,
					),
					'text_color' => array (
						'default' 	=> '#666666',
					),
				    'letter_spacing' => array(
						'sticky' => false,
					),
					'line_height' => array (
						'sticky' => false,
					),
					'hide_text_align' 	=> true,
					'toggle_slug'   	=> 'menu_item_text',
				),				
			),
			'link_options' => false,
			'margin_padding' => array(
				'css' => array(
					'important' => 'all',
				),
			),
			'text' => false,
		);

		$this->custom_css_fields = array(
			'divimenu' => array(
				'label'    => esc_html__( 'DiviMenu', 'et_builder' ),
				'selector' => '%%order_class%% .dd-divimenu'
			),
			'logo' => array(
				'label'    => esc_html__( 'Logo', 'et_builder' ),
				'selector' => '%%order_class%% .dd-logo'
			),
			'logo_image' => array(
				'label'    => esc_html__( 'Logo Image', 'divimenus' ),
				'selector' => '%%order_class%% .dd-logo img'
			),
			'text_icon_image' => array(
				'label'    => esc_html__( 'Text Icon / Image', 'divimenus' ),
				'selector' => '%%order_class%% .dd-menu-button .dd-text-icon, %%order_class%% .dd-menu-button .dd-text-image > img',
				'show_if' => array('text_use_icon' => 'on')
			),
		);
	}

	public function get_fields() {
		$yes_no_button_options = DiviMenusHelper::get_yes_no_button_options();	
		$fields = array(
			'direction' => array(
				'label'           	=> esc_html__( 'Direction', 'divimenus' ),
				'type'            	=> 'select',
				'options'         	=> array(
					'row'  		=> esc_html__( 'Horizontal', 'divimenus' ),
					'column'  	=> esc_html__( 'Vertical', 'divimenus' )
				),
				'default' 			=> 'row',
				'mobile_options'	=> true,
				'toggle_slug'     	=> 'main_content',
			),
			'show_open' => array(
				'label'           	=> esc_html__( 'Show Opened', 'divimenus' ),
				'description'     	=> esc_html__( 'Here you can choose whether the DiviMenu should be open at first.' , 'divimenus' ),
				'type'            	=> 'yes_no_button',
				'options'         	=> $yes_no_button_options,
				'default'			=> 'on',
				'mobile_options'	=> true,			
				'toggle_slug'       => 'main_content',
			),
			'menu_button_position' => array(
				'label'           	=> esc_html__( 'Position', 'divimenus' ),
				'type'            	=> 'select',
				'options'         	=> array(
					'first'  	=> esc_html__( 'First', 'divimenus' ),
					'last'  	=> esc_html__( 'Last', 'divimenus' )
				),
				'default'		 	=> 'first',
				'mobile_options'	=> true,
				'toggle_slug'     	=> 'menu_button',
			),
			'menu_button_content' 	=> array(
				'label'           	=> esc_html__( 'Content', 'divimenus' ),
				'type'            	=> 'select',
				'options'         	=> array(
					'icon' 	=> esc_html__( 'Icon', 'divimenus' ),
					'image' => esc_html__( 'Image', 'divimenus' ),
					'text'  => esc_html__( 'Text', 'divimenus' )
				),
				'default'		 	=> 'icon',
				'affects' => array (
					'menu_button_font',
					'menu_button_text_color',
					'menu_button_font_size',
					'menu_button_letter_spacing',
					'menu_button_line_height',
					'menu_button_icon_color',
					'menu_button_icon_font_size',
					'menu_button_image_size',
					'menu_button_opacity',
				),
				'toggle_slug'     	=> 'menu_button',
			),		
			'menu_button_font_icon' 	=> array(
				'label'              	=> esc_html__( 'Icon', 'divimenus' ),
				'type'               	=> 'select_icon',
				'class'               	=> array( 'et-pb-font-icon' ),
				'default'				=> '%%64%%',
				'show_if'     			=> array ('menu_button_content' => 'icon' ),			
				'toggle_slug'         	=> 'menu_button',
				'hover'					=> 'tabs',
			),
			'menu_button_image' => array(
				'label'              	=> esc_html__( 'Image', 'divimenus' ),
				'type'               	=> 'upload',
				'upload_button_text' 	=> esc_attr__( 'Upload an Image', 'et_builder' ),
				'choose_text'        	=> esc_attr__( 'Choose an Image', 'et_builder' ),
				'update_text'        	=> esc_attr__( 'Set As Image', 'et_builder' ),
				'hide_metadata'      	=> true,
				'default'				=> ET_BUILDER_PLACEHOLDER_LANDSCAPE_IMAGE_DATA,
				'show_if'     			=> array ('menu_button_content' => 'image' ),				
				'toggle_slug'        	=> 'menu_button',	
				'hover'					=> 'tabs',
				'dynamic_content'		=> 'image',
			),
			'menu_button_text' => array(
				'label'           	=> esc_html__( 'Text', 'divimenus' ),
				'type'            	=> 'text',
				'default'			=> 'Menu',
				'show_if'     		=> array ('menu_button_content' => 'text' ),
				'dynamic_content' 	=> 'text',
				'toggle_slug'     	=> 'menu_button',
				'hover'				=> 'tabs',
			),
			'hide_button' => array(
				'label'           		=> esc_html__( 'Hide', 'divimenus' ),
				'description'     		=> esc_html__('Here you can choose whether this DiviMenu should display only the Menu Items.', 'divimenus' ),
				'type'            		=> 'yes_no_button',
				'options'         		=> $yes_no_button_options,
				'affects' 				=> array ( 'disable_button' ),
				'default'				=> 'off',
				'mobile_options'  		=> true,			
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
			'alignment' => array(
				'label'           	=> esc_html__( 'Horizontal Alignment', 'divimenus' ),
				'description'     	=> esc_html__( 'Here you can control the alignment of the Menu Items on the main axis.', 'divimenus' ),
				'type'            	=> 'text_align',
				'options'         	=> et_builder_get_text_orientation_options(),
				'options_icon'    	=> 'module_align',
				'default'			=> 'left',
				'mobile_options'	=> true,
				'tab_slug'        	=> 'advanced',
				'toggle_slug'     	=> 'divimenu',
			),	
			'cross_axis_alignment' => array( 
				'label'           	=> esc_html__( 'Vertical Alignment', 'divimenus' ),
				'description'     	=> esc_html__( 'Here you can control the alignment of the Menu Items on the cross axis.', 'divimenus' ),
				'type'            	=> 'select',
				'options'         	=> array('flex-start' => esc_html__( 'Top', 'divimenus' ), 'center' => esc_html__( 'Middle', 'divimenus' ), 'flex-end' => esc_html__( 'Bottom', 'divimenus' )),
				'options_icon'    	=> 'module_align',
				'default'			=> 'center',
				'show_if'			=> array('direction' => 'row'),
				'tab_slug'        	=> 'advanced',
				'toggle_slug'     	=> 'divimenu',
			),
			'force_fullwidth' => array(
				'label'           	=> esc_html__( 'Fullwidth Menu Items', 'divimenus' ),
				'type'            	=> 'yes_no_button',
				'options'         	=> $yes_no_button_options,	
				'default'			=> 'off',
				'mobile_options'	=> true,
				'tab_slug'        	=> 'advanced',
				'toggle_slug'     	=> 'divimenu',	
			),
			'mb_fullwidth' => array(
				'label'           	=> esc_html__( 'Fullwidth Menu Button', 'divimenus' ),
				'type'            	=> 'yes_no_button',
				'options'         	=> $yes_no_button_options,	
				'default'			=> 'off',
				'mobile_options'	=> true,
				'tab_slug'        	=> 'advanced',
				'toggle_slug'     	=> 'divimenu',	
			),
			'mb_alignment' => array(
				'label'           	=> esc_html__( 'Content Alignment', 'divimenus' ),
				'description'     	=> esc_html__( 'Here you can control the content alignment of the Menu Button.', 'divimenus' ),
				'type'            	=> 'text_align',
				'options'         	=> et_builder_get_text_orientation_options(),
				'options_icon'    	=> 'module_align',
				'tab_slug'        	=> 'advanced',
				'toggle_slug'     	=> 'menu_button_bg',
			),
			'menu_button_scale' => array(
				'label'           	=> esc_html__( 'Resizing Effect', 'divimenus' ),
				'description'      	=> esc_html__( 'Here you can choose whether the Menu Button should scale down when the DiviMenu is open.', 'divimenus' ),
				'type'            	=> 'yes_no_button',
				'options'         	=> $yes_no_button_options,
				'default_on_front' 	=> 'on',
				'tab_slug'         	=> 'advanced',
				'toggle_slug'      	=> 'menu_button_bg',				
			),		
			'menu_button_background_color' => array(
				'label'           	=> esc_html__( 'Background Color', 'divimenus' ),
				'type'            	=> 'color-alpha',	
				'default'			=> '#888888',
				'hover'				=> 'tabs',
				'mobile_options'	=> true,	
				'sticky'			=> true,					
				'tab_slug'        	=> 'advanced',
				'toggle_slug'     	=> 'menu_button_bg',				
			),
			'menu_button_icon_color' => array(
				'label'             => esc_html__( 'Icon Color', 'divimenus' ),
				'type'              => 'color-alpha',
				'default'			=> '#ffffff',
				'depends_show_if' 	=> 'icon',
				'hover'				=> 'tabs',
				'mobile_options'	=> true,
				'sticky'			=> true,
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'icon_settings',
			),	
			'menu_button_icon_font_size' => array(
				'label'           	=> esc_html__( 'Icon Font Size', 'divimenus' ),
				'type'            	=> 'range',
				'default'         	=> '33px',
				'fixed_unit'		=> 'px',
				'mobile_options'  	=> true,
				'sticky'			=> true,
				'depends_show_if' 	=> 'icon',
				'tab_slug'        	=> 'advanced',
				'toggle_slug'     	=> 'icon_settings',
			),
			'menu_button_image_size' => array(
				'label'           	=> esc_html__( 'Image Width', 'divimenus' ),
				'type'            	=> 'range',
				'range_settings' 	=> array(
					'max'  => 550,
					'step' => 1,
				),
				'allowed_values'    => et_builder_get_acceptable_css_string_values( 'width' ),
				'default'         	=> '57px',
				'default_unit'		=> 'px',
				'validate_unit'		=> true,
				'mobile_options'  	=> true,
				'sticky'			=> true,
				'depends_show_if' 	=> 'image',
				'tab_slug'    		=> 'advanced',
				'toggle_slug'     	=> 'image_settings',
			),		
			'menu_button_opacity' => array(
				'label'           	=> esc_html__( 'Opacity Effect', 'divimenus' ),
				'description'      	=> esc_html__( 'Here you can choose whether the Menu Button image should be lighter when either hovered or the DiviMenu is open.', 'divimenus' ),
				'type'            	=> 'yes_no_button',
				'options'			=> $yes_no_button_options,
				'default' 			=> 'on',
				'depends_show_if' 	=> 'image',
				'tab_slug'         	=> 'advanced',
				'toggle_slug'      	=> 'image_settings',				
			),
			'menu_item_background_color' => array(
				'label'           	=> esc_html__( 'Background Color', 'divimenus' ),
				'type'            	=> 'color-alpha',	
				'default'			=> '#dfdfdf',
				'hover'				=> 'tabs',
				'mobile_options'	=> true,
				'tab_slug'        	=> 'advanced',
				'toggle_slug'     	=> 'menu_items',
			),
			'menu_item_icon_color' => array(
				'label'             => esc_html__( 'Icon Color', 'divimenus' ),
				'type'              => 'color-alpha',
				'default'			=> '#666666',
				'hover'				=> 'tabs',
				'mobile_options'  	=> true,
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'menu_item_icon',
			),	
			'menu_item_icon_font_size' => array(
				'label'           	=> esc_html__( 'Icon Font Size', 'divimenus' ),
				'type'            	=> 'range',
				'default'         	=> '23px',
				'fixed_unit'  		=> 'px',
				'mobile_options'  	=> true,
				'tab_slug'        	=> 'advanced',
				'toggle_slug'     	=> 'menu_item_icon',
			),
			'menu_item_image_size' => array(
				'label'           	=> esc_html__( 'Image Width', 'divimenus' ),
				'type'            	=> 'range',
				'range_settings' 	=> array(
					'max'  => 550,
					'step' => 1,
				),
				'allowed_values'    => et_builder_get_acceptable_css_string_values( 'width' ),
				'default'  			=> '57px',
				'default_unit'  	=> 'px',
				'validate_unit'		=> true,
				'mobile_options'  	=> true,
				'tab_slug'    		=> 'advanced',
				'toggle_slug'     	=> 'menu_item_image',
			),	
			'menu_item_opacity' => array(
				'label'           	=> esc_html__( 'Opacity Effect', 'divimenus' ),
				'description'      	=> esc_html__( 'Here you can choose whether the Menu Item image should be lighter when hovered.', 'divimenus' ),
				'type'            	=> 'yes_no_button',
				'options'         	=> $yes_no_button_options,
				'default_on_front' 	=> 'off',
				'tab_slug'         	=> 'advanced',
				'toggle_slug'      	=> 'menu_item_image',				
			),				
			'h_gap' => array(
				'label'           	=> esc_html__( 'DiviMenu Opening', 'divimenus' ),
				'type'            	=> 'range',
				'default'         	=> '25px', 
				'fixed_unit'		=> 'px',
				'mobile_options'  	=> true,
				'tab_slug'       	=> 'advanced',
				'toggle_slug'     	=> 'margin_padding',			
			),					
			'doc_ready' => array(
				'label'           	=> esc_html__( 'Show After Page Load', 'divimenus' ),
				'description'      	=> esc_html__( 'Here you can choose whether the DiviMenu should be displayed after the page is completely loaded.', 'divimenus' ),
				'type'            	=> 'yes_no_button',
				'options'         	=> $yes_no_button_options,
				'default' 			=> 'off',
				'tab_slug'         	=> 'custom_css',
				'toggle_slug'      	=> 'visibility',				
			),
		);
		$fields = array_merge($fields, DiviMenusHelper::get_logo_fields());
		$fields = array_merge($fields, DiviMenusHelper::get_text_icon_fields('menu_button', 'menu_button_content'));
		$fields['menu_button_margin'] = array(
			'label'           	=> esc_html__( 'Menu Button Margin', 'divimenus' ),
			'type'            	=> 'custom_padding',
			'fixed_unit'     	=> 'px',
			'mobile_options'  	=> true,
			'sticky'			=> true,
			'tab_slug'       	=> 'advanced',
			'toggle_slug'     	=> 'margin_padding',					
		);
		$fields['menu_button_padding'] = array(
			'label'           	=> esc_html__( 'Menu Button Padding', 'divimenus' ),
			'type'            	=> 'custom_padding',
			'fixed_unit'     	=> 'px',
			'mobile_options'  	=> true,
			'sticky'			=> true,
			'tab_slug'       	=> 'advanced',
			'toggle_slug'     	=> 'margin_padding',					
		);
		$fields['menu_item_padding'] = array(
			'label'           	=> esc_html__( 'Menu Item Padding', 'divimenus' ),
			'type'            	=> 'custom_padding',
			'fixed_unit'     	=> 'px',
			'mobile_options'  	=> true,
			'sticky'			=> true,
			'tab_slug'       	=> 'advanced',
			'toggle_slug'     	=> 'margin_padding',			
		);
		$fields['hover_click'] = DiviMenusHelper::get_hover_click_field('menu_button');
		$fields['mb_alt'] = DiviMenusHelper::get_alt_field( 'menu_button_content', 'image', esc_html__('Menu Button Image Alt Text') );
		return $fields;
	}

	public function before_render() {
		global $dm_direction, $mi_fullwidth;
		$dm_direction_values = et_pb_responsive_options()-> get_property_values($this->props, 'direction', $this->props['direction'], true);
		$dm_direction = array(
			'responsive_enabled'	=> et_pb_responsive_options()-> is_responsive_enabled($this->props, 'direction'),
			'desktop' 				=> $this->props['direction'],
			'tablet'  				=> $dm_direction_values['tablet'],
			'phone' 				=> $dm_direction_values['phone'],
		);
		$mi_fullwidth = et_pb_responsive_options()-> get_property_values($this->props, 'force_fullwidth', $this->props['force_fullwidth'], true);
	}
	
	public function get_transition_fields_css_props() {
		$fields = parent::get_transition_fields_css_props();

		$fields['logo_width'] = array(
			'width' => '%%order_class%% .dd-logo img',
		);
		$fields['menu_button_background_color'] = array(
			'background-color' => '%%order_class%% .dd-divimenu:not(.dd-divimenu-open) .dd-menu-button-content',
		);
		$fields['menu_button_icon_color'] = array(
			'background-color' => '%%order_class%% .dd-divimenu:not(.dd-divimenu-open) .dd-menu-button-content.dd-icon-content',
		);
		$fields['menu_item_background_color'] = array(
			'background-color' => '%%order_class%% .dd-menu-item-content',
		);
		$fields['menu_item_icon_color'] = array(
			'color' => '%%order_class%% .dd-icon .dd-icon-content',
		);

		return $fields;
	}

	public function render( $attrs, $content, $render_slug ) {
		
		global $dm_direction;

		$ali 	= et_pb_responsive_options()-> get_property_values($this->props, 'alignment', $this->props['alignment'], true);
		$mb_pos = et_pb_responsive_options()-> get_property_values($this->props, 'menu_button_position', $this->props['menu_button_position'], true);

		ET_Builder_Element::set_style( $render_slug, array(
			'selector'    => '%%order_class%% .dd-flex',
			'declaration' => DiviMenusHelper::get_flex_css($dm_direction['desktop'], $ali['desktop'], $this->props['cross_axis_alignment'], $mb_pos['desktop'])
		));
		ET_Builder_Element::set_style( $render_slug, array(
			'selector'    => '%%order_class%% .dd-flex',
			'declaration' => DiviMenusHelper::get_flex_css($dm_direction['tablet'], $ali['tablet'], $this->props['cross_axis_alignment'], $mb_pos['tablet']),
			'media_query' => ET_Builder_Element::get_media_query( '768_980' )
		));
		ET_Builder_Element::set_style( $render_slug, array(
			'selector'    => '%%order_class%% .dd-flex',
			'declaration' => DiviMenusHelper::get_flex_css($dm_direction['phone'], $ali['phone'], $this->props['cross_axis_alignment'], $mb_pos['phone']), 
			'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' )
		));

		$this->generate_styles(
			array(
				'base_attr_name' => 'h_gap',
				'selector'       => '%%order_class%% .dd-flex',
				'css_property'   => 'gap',
				'render_slug'    => $render_slug,
			)
		);
		
		$mb_fullwidth = et_pb_responsive_options()-> get_property_values($this->props, 'mb_fullwidth', $this->props['mb_fullwidth'], true);
		DiviMenusHelper::set_fullwidth_style($render_slug, $mb_fullwidth, '%%order_class%% .dd-menu-button', $dm_direction);
		
		$hide = et_pb_responsive_options()-> get_property_values($this->props, 'hide_button', $this->props['hide_button'], true);
		DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-menu-button', sprintf('display: %1$s!important;', $hide['desktop'] !== 'on' ? 'block' : 'none'));
		if ($hide_responsive_enabled = et_pb_responsive_options()-> is_responsive_enabled($this->props, 'hide_button')) {
			DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-menu-button', sprintf('display: %1$s!important;', $hide['tablet'] !== 'on' ? 'block' : 'none'), 't');
			DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-menu-button', sprintf('display: %1$s!important;', $hide['phone'] !== 'on' ? 'block' : 'none'), 'p');
		}

		if (!empty($this->props['mb_alignment']) ) {
		  ET_Builder_Element::set_style( $render_slug, array(
			  'selector'    => '%%order_class%% .dd-menu-button-content',
			  'declaration' => DiviMenusHelper::get_content_alignment_css($this->props['mb_alignment'], $this->props['text_use_icon'], $this->props['text_icon_pos']),
		  ));
	  	}

		if ($this->props['menu_button_content'] === 'icon') {
			$this->generate_styles(
				array(
					'base_attr_name' => 'menu_button_icon_color',
					'selector'       => '%%order_class%% .dd-menu-button-content.dd-icon-content',
					'hover_selector' => '%%order_class%% .dd-menu-button-content.dd-icon-content.hover, %%order_class%% .dd-divimenu-open .dd-menu-button-content.dd-icon-content',
					'css_property'   => 'color',
					'render_slug'    => $render_slug,
					'type'           => 'color',
				)
			);
			$this->generate_styles(
				array(
					'base_attr_name' => 'menu_button_icon_font_size',
					'selector'       => '%%order_class%% .dd-menu-button-content.dd-icon-content',
					'css_property'   => 'font-size',
					'render_slug'    => $render_slug,
				)
			);		 
		} else if ($this->props['menu_button_content'] === 'image') {
			$this->generate_styles(
				array(
					'base_attr_name' => 'menu_button_image_size',
					'selector'       => '%%order_class%% .dd-menu-button-content > img',
					'css_property'   => 'width',
					'render_slug'    => $render_slug,
				)
			);
		} else {
			if ($this->props['text_use_icon'] === 'on') {
				DiviMenusHelper::set_text_icon_style($render_slug, $this, '%%order_class%% .dd-menu-button-content.dd-text', '%%order_class%% .dd-menu-button-content .dd-text-icon', 
				'%%order_class%% .dd-menu-button-content .dd-text-image', '%%order_class%% .dd-menu-button-content.hover .dd-text-icon, %%order_class%% .dd-divimenu-open .dd-menu-button-content .dd-text-icon',
				'%%order_class%% .dd-menu-button-content.hover .dd-text-image, %%order_class%% .dd-divimenu-open .dd-menu-button-content .dd-text-image');
			}
		}

		$this->generate_styles(
			array(
				'base_attr_name' => 'menu_button_background_color',
				'selector'       => '%%order_class%% .dd-menu-button-content',
				'hover_selector' => '%%order_class%% .dd-divimenu-open .dd-menu-button-content, %%order_class%% .dd-menu-button-content.hover',
				'css_property'   => 'background-color',
				'render_slug'    => $render_slug,
				'type'           => 'color',
			)
		);

		DiviMenusHelper::set_responsive_padding_css($this->props, 'menu_button_margin', '%%order_class%% .dd-menu-button-content', 'margin', $render_slug, $this->is_sticky_module);
		DiviMenusHelper::set_responsive_padding_css($this->props, 'menu_button_padding', '%%order_class%% .dd-menu-button-content', 'padding', $render_slug, $this->is_sticky_module);		
			
		if ( $this->props['menu_button_scale'] === 'on') 
			DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-divimenu-open .dd-menu-button-content', 'transform: scale(0.8);');
	
		$this->generate_styles(
			array(
				'base_attr_name' => 'menu_item_background_color',
				'selector'       => '%%order_class%% .dd-menu-item-content',
				'hover_selector' => '%%order_class%% .dd-menu-flex-sub .dd-menu-item-content:hover, %%order_class%% .dd-mi .dd-menu-item-content.hover, %%order_class%% .dd-mi .dd-menu-item-content.active',
				'css_property'   => 'background-color',
				'render_slug'    => $render_slug,
				'sticky'		 => false,
				'type'           => 'color',
			)
		);
		
		DiviMenusHelper::set_responsive_padding_css($this->props, 'menu_item_padding', '%%order_class%% .dd-menu-item-content', 'padding', $render_slug, $this->is_sticky_module);

		$this->generate_styles(
			array(
				'base_attr_name' => 'menu_item_icon_color',
				'selector'       => '%%order_class%% .dd-icon .dd-icon-content',
				'hover_selector' => '%%order_class%% .dd-mi .dd-icon.hover .dd-icon-content, %%order_class%% .dd-mi .dd-icon.active .dd-icon-content',
				'css_property'   => 'color',
				'render_slug'    => $render_slug,
				'type'           => 'color',
			)
		);
		$this->generate_styles(
			array(
				'base_attr_name' => 'menu_item_icon_font_size',
				'selector'       => '%%order_class%% .dd-icon .dd-icon-content',
				'css_property'   => 'font-size',
				'render_slug'    => $render_slug,
			)
		);
		
		$this->generate_styles(
			array(
				'base_attr_name' => 'menu_item_image_size',
				'selector'       => '%%order_class%% .dd-item-inner > img',
				'css_property'   => 'width',
				'render_slug'    => $render_slug,
			)
		);

		// module output
		$opened_values = et_pb_responsive_options()-> get_property_values($this->props, 'show_open', $this->props['show_open'], true);
		$opened = $opened_values['desktop'] !== 'off' || $opened_values['tablet'] !== 'off' || $opened_values['phone'] !== 'off';

		$menu_button_content = '';
		$menu_button_classes = array('dd-item dd-menu-button-content');

		if ( $this->props['menu_button_content'] === 'icon' )   {
			$menu_button_classes[] = 'dd-icon-content notranslate';
			$menu_button_content = DiviMenusHelper::render_icon($this->props, $render_slug, 'menu_button_font_icon', $menu_button_classes, false, true, $opened, '%%order_class%% .dd-menu-button-content.dd-icon-content', '%%order_class%% .dd-menu-button-content.dd-icon-content.hover, %%order_class%% .dd-divimenu-open .dd-menu-button-content.dd-icon-content');
		} else if ( $this->props['menu_button_content'] === 'image' ) {
			$image_alt = DiviMenusHelper::get_image_alt($this->props, 'menu_button_image', 'mb_alt');
			$image = DiviMenusHelper::render_image($this->props, 'menu_button_image', $this->props['menu_button_opacity'] === 'on' ? 'dd-mb-image-opacity' : '', $image_alt, '');
			$menu_button_content = sprintf('<div class="%2$s" role="button" aria-label="Image" aria-pressed="%3$s" tabindex="0">%1$s</div>', 
				$image, implode( ' ', $menu_button_classes ), $opened ? 'true' : 'false'
			);
		} else {
			$menu_button_classes[] = 'dd-text';

			$text = DiviMenusHelper::render_text( $this, 'menu_button_text', 'dd-text-content', 'Menu' );
			$text_icon = DiviMenusHelper::maybe_render_text_icon($this->props, $render_slug, '%%order_class%% .dd-menu-button-content .dd-text-icon', '%%order_class%% .dd-menu-button-content.hover .dd-text-icon, %%order_class%% .dd-divimenu-open .dd-menu-button-content .dd-text-icon');

			$menu_button_content = sprintf(
				'<div class="%3$s" role="button" aria-pressed="%4$s" tabindex="0">%1$s%2$s</div>',
				$text_icon,
				$text,
				implode( ' ', $menu_button_classes ),
				$opened ? 'true' : 'false'
			);
		}

		$menu_button = sprintf('<div class="dd-menu-button%2$s%3$s" role="menuitem">%1$s</div>', 
			apply_filters('dd_menu_button_content_output', $menu_button_content, $this->props), 
			$this->props['disable_button'] === 'on' ? ' dd-disabled' : '',
			$this->props['hover_click'] === 'click' ? ' dd-click' : ''
		);

		$divimenu_classes = array('dd-divimenu dd-flex');
		if ( $opened ) $divimenu_classes[] = 'dd-divimenu-open';
		if ( $opened_values['desktop'] === 'off' ) $divimenu_classes[] = 'dd-closed-desktop';
		if ( $opened_values['tablet']  === 'off' ) $divimenu_classes[] = 'dd-closed-tablet';
		if ( $opened_values['phone']   === 'off' ) $divimenu_classes[] = 'dd-closed-phone';
		if ( 'on' === $this->props['menu_item_opacity'] ) $divimenu_classes[] = 'dd-image-opacity';

		$divimenu = sprintf('<nav class="%3$s" role="menu" aria-label="DiviMenu">%1$s%2$s</nav>',
			apply_filters('dd_menu_button_output', $menu_button, $this->props),
			apply_filters('dd_menu_items_output', $this->content, $this->props),
			implode(' ', $divimenu_classes)
		);

		$output = sprintf('<div class="dd-wrapper"%3$s>%1$s%2$s</div>',
			apply_filters('dd_divimenu_before', $this->render_logo($render_slug), $this->props),
			apply_filters('dd_divimenu_output', $divimenu, $this->props), 
			$this->props['doc_ready'] !== 'on' ? '' : ' style="display:none;"' 
		);
		return $output;
	}

	protected function render_logo($render_slug) {
		$logo_alt = DiviMenusHelper::get_image_alt($this->props, 'logo', 'logo_alt');
		$logo_attrs = array( 'src' => '{{logo}}', 'alt' => $logo_alt );
		
		$sticky = et_pb_sticky_options();
		$sticky_value = $sticky->get_value( 'logo', $this->props, '' );
		if ( $sticky_value !== '' && $sticky->is_enabled( 'logo', $this->props ) ) {
			$logo_values = et_pb_responsive_options()-> get_property_values($this->props, 'logo', $this->props['logo'], true);
			$logo_attrs['data-sticky'] = esc_attr( $sticky_value );
			$logo_attrs['data-src'] = $logo_values['desktop'];
			$logo_attrs['data-src-t'] = $logo_values['tablet'];
			$logo_attrs['data-src-p'] = $logo_values['phone'];
		}
		
		$image_attachment_class = et_pb_media_options()->get_image_attachment_class( $this->props, 'logo' );

		if ( ! empty( $image_attachment_class ) ) {
			$logo_attrs['class'] = esc_attr( $image_attachment_class );
		}

		$multi_view = et_pb_multi_view_options( $this );
		$logo = $multi_view->render_element(
			array(
				'tag'            => 'img',
				'attrs'          => $logo_attrs,
				'required'       => 'logo',
				'hover_selector' => '%%order_class%% .dd-logo img',
			)
		);
		if ( ! empty( $logo ) ) {
			$pos = et_pb_responsive_options()-> get_property_values($this->props, 'logo_pos', $this->props['logo_pos'], true);
			$pos_enabled = et_pb_responsive_options()-> is_responsive_enabled($this->props, 'logo_pos');

			$hali = et_pb_responsive_options()-> get_property_values($this->props, 'logo_alignment', $this->props['logo_alignment'], true);
			$hali_enabled = et_pb_responsive_options()-> is_responsive_enabled($this->props, 'logo_alignment');
			$vali = et_pb_responsive_options()-> get_property_values($this->props, 'logo_ca_alignment', $this->props['logo_ca_alignment'], true);
			$vali_enabled = et_pb_responsive_options()-> is_responsive_enabled($this->props, 'logo_ca_alignment');
			$labs = et_pb_responsive_options()-> get_property_values($this->props, 'logo_absolute', $this->props['logo_absolute'], true);
			$labs_enabled = et_pb_responsive_options()-> is_responsive_enabled($this->props, 'logo_absolute');

			DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-wrapper', sprintf('display:flex;%s', DiviMenusHelper::get_flex_css(DiviMenusHelper::get_direction($pos['desktop']), $hali['desktop'], $vali['desktop'], $pos['desktop'])));
			DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-wrapper', DiviMenusHelper::get_flex_css(DiviMenusHelper::get_direction($pos['tablet']), $hali['tablet'], $vali['tablet'], $pos['tablet']), 't');
			DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-wrapper', DiviMenusHelper::get_flex_css(DiviMenusHelper::get_direction($pos['phone']), $hali['phone'], $vali['phone'], $pos['phone']), 'p');

			DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-divimenu', DiviMenusHelper::get_direction($pos['desktop']) === 'row' ? 'flex:1;' : 'width:100%;');
			if ($pos_enabled) {
				DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-divimenu', DiviMenusHelper::get_direction($pos['tablet']) === 'row' ? 'flex:1;' : 'width:100%;', 't');
				DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-divimenu', DiviMenusHelper::get_direction($pos['phone']) === 'row' ? 'flex:1;' : 'width:100%;', 'p');
			}		
			DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-logo', sprintf('position:%s;', $labs['desktop'] === 'on' ? 'absolute' : 'relative'));
			if ($labs_enabled) {
				DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-logo', sprintf('position:%s;', $labs['tablet'] === 'on' ? 'absolute' : 'relative'), 't');
				DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-logo', sprintf('position:%s;', $labs['phone'] === 'on' ? 'absolute' : 'relative'), 'p');
			}
			$this->generate_styles(
				array(
					'base_attr_name'                  => 'logo_width',
					'selector'                        => '%%order_class%% .dd-logo img',
					'hover_pseudo_selector_location'  => 'suffix',
					'css_property'                    => 'width',
					'render_slug'                     => $render_slug,
					'type'                            => 'range',
				)
			);
			DiviMenusHelper::set_responsive_padding_css($this->props, 'logo_margin', '%%order_class%% .dd-logo', 'margin', $render_slug, $this->is_sticky_module);
			
			if ( ! empty( $this->props['logo_url'] ) ) {
				$logo = sprintf(
					'<a href="%1$s" %2$s>%3$s</a>',
					esc_url( $this->props['logo_url'] ),
					'on' === $this->props['logo_url_new_window'] ? 'target="_blank"' : '',
					et_core_esc_previously( $logo )
				);
			}
			return sprintf( '<div class="dd-logo">%1$s</div>', $logo );
		}
		return '';
	}
	
}

new DiviMenusFlex_Module;