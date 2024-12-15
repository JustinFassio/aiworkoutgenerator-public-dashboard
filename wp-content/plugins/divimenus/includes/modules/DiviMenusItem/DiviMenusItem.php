<?php

class DiviMenus_Item_Module extends ET_Builder_Module {

	public $slug       = 'et_pb_divimenus_item';
	public $vb_support = 'on';

	public function init() {
		$this->name = esc_html__( 'Menu Item', 'divimenus' );

        $this->type                        = 'child';
		$this->child_title_var             = 'title';
		$this->advanced_setting_title_text = esc_html__( 'New Menu Item', 'divimenus' );
		$this->settings_text               = esc_html__( 'Menu Item Settings', 'divimenus' );

		$this->main_css_element = '%%order_class%%';

		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content' 	=> esc_html__( 'Menu Item', 'divimenus' ),
					'item_link'     => esc_html__( 'Link', 'et_builder' ),
				),
			),
			'advanced' => array(
				'toggles' => array(
					'menu_item'  		=> esc_html__( 'Menu Item', 'divimenus' ), 
					'icon_settings'  	=> esc_html__( 'Menu Item ICON', 'divimenus' ),	
					'image_settings' 	=> esc_html__( 'Menu Item IMAGE', 'divimenus' ),
					'text_settings'  	=> esc_html__( 'Menu Item TEXT', 'divimenus' ),	
					'title' 			=> esc_html__( 'Menu Item TITLE', 'divimenus' ),
					'popup' 			=> esc_html__( 'Popup', 'divimenus' ),
					'item_link' 		=> esc_html__( 'Link', 'et_builder' ),													
				),
			),
		);	
	}
	
	public function get_advanced_fields_config() {
		return array (
			'background' => false,
			'borders' 	=> false,
			'box_shadow' => array(		
				'default' => array(
					'label'    				=> esc_html__( 'Background', 'divimenus' ),
					'css' => array(
						'main' => "{$this->main_css_element} .dd-item",
						'hover' => "{$this->main_css_element} .dd-item.hover, {$this->main_css_element} .dd-item.active",
						'important' => 'all'						
					),											
				),
				'image' => array (
					'label'    				=> esc_html__( 'Menu Items Image', 'divimenus' ),
					'css' => array(
						'main' => "{$this->main_css_element} .dd-item img",
						'important' => 'all' 														
					),					
				),
			),
			'filters' => false,
			'fonts' => false,
			'margin_padding' => false,
			'max_width' => false,
			'link_options' => false,
			'text' => false,
			'transform' 	=> array(
				'css'      	=> array(
					'main' 	=> "{$this->main_css_element} .dd-menu-item-wrapper"
				),	
			),			
		);
	}

	public function get_fields() {

		$fonts = DiviMenusHelper::get_fonts();
		$title_positions = DiviMenusHelper::get_positions(true);
		$yes_no_button_options = DiviMenusHelper::get_yes_no_button_options();	

		$fields = array(
			'text_title' => array(
				'label'       		=> esc_html__( 'Title', 'et_builder' ),
				'description' 		=> esc_html__( 'Define the Title for your Menu Item.', 'divimenus' ),
				'type'        		=> 'text',
				'default'  			=> 'Item',
				'toggle_slug' 		=> 'main_content',
			),
			'title' => array(
				'label'       		=> esc_html__( 'Title', 'et_builder' ),
				'description' 		=> esc_html__( 'Define the Title for your Menu Item.', 'divimenus' ),
				'type'        		=> 'text',
				'default'  			=> 'Item',
				'toggle_slug' 		=> 'main_content',
			),
			'item_font_icon' => array(
				'label'             => esc_html__( 'Icon', 'et_builder' ),
				'type'              => 'select_icon',
				'class'             => array( 'et-pb-font-icon' ),
				'toggle_slug'       => 'main_content',
				'hover'				=> 'tabs'
			),	
			'item_image' => array(
				'label'             => esc_html__( 'Image', 'divimenus' ),
				'description'       => esc_html__( 'Upload an 1:1 Image (square) specifically for this Menu Item. This overwrites the "Menu Items Image" field.', 'divimenus' ),
				'type'              => 'upload',
				'upload_button_text'=> esc_attr__( 'Upload an image', 'et_builder' ),
				'choose_text'       => esc_attr__( 'Choose an Image', 'et_builder' ),
				'update_text'       => esc_attr__( 'Set As Image', 'et_builder' ),
				'toggle_slug'       => 'main_content',
				'hover'				=> 'tabs'
			),
			'item_hide' => array(
				'label'       		=> esc_html__( 'Hide', 'divimenus' ),
				'description' 		=> esc_html__( 'Here you can choose whether or not to display this Menu Item.', 'divimenus' ),
				'type'       		=> 'yes_no_button',
				'options'      		=> $yes_no_button_options,
				'affects'          	=> array( 'item_preserve' ),
				'default' 			=> 'off',
				'mobile_options'	=> true,
				'toggle_slug' 		=> 'main_content',
			),
			'item_preserve' => array(
				'label'       		=> esc_html__( 'Preserve Space', 'divimenus' ),
				'description' 		=> esc_html__( 'Here you can choose whether or not the Menu Item space should be preserved.', 'divimenus' ),
				'type'       		=> 'yes_no_button',
				'options'      		=> $yes_no_button_options,
				'default' 			=> 'off',
				'toggle_slug' 		=> 'main_content',
			),
			'disable_item' => array(
				'label'           		=> esc_html__( 'Disable', 'divimenus' ),
				'description'     		=> esc_html__( 'Here you can choose whether to disable the click event on this Menu Item.', 'divimenus' ),
				'type'            		=> 'yes_no_button',
				'options'         		=> $yes_no_button_options,
				'default'				=> 'off',
				'show_if' 				=> array( 'item_hide' => 'off'),			
				'toggle_slug'       	=> 'main_content',
			),
			'item_use_custom' => array(
				'label'           	=>  esc_html__('Use Custom Styles for this Menu Item?', 'divimenus' ),
				'type'            	=> 'yes_no_button',
				'options'         	=> $yes_no_button_options,
				'default_on_front'  => 'off', 
				'affects'         	=> array(
					'item_circle_color', 
					'item_use_circle_border',
				),
				'tab_slug'      	=> 'advanced',
				'toggle_slug' 	    => 'menu_item',			
			),
			'item_circle_color' => array(
				'label'           	=> esc_html__( 'Background Color', 'divimenus' ),
				'type'            	=> 'color-alpha',	
				'default'			=> '#dfdfdf',
				'hover'				=> 'tabs',
				'mobile_options'	=> true,
				'sticky'			=> true,
				'tab_slug'        	=> 'advanced',
				'toggle_slug'     	=> 'menu_item',
			),
			'item_use_circle_border' => array(
				'label'           	=> esc_html__( 'Show Border', 'divimenus' ),
				'description'       => esc_html__( 'Here you can choose whether if the Menu Item background border should display.', 'divimenus' ),
				'type'            	=> 'yes_no_button',
				'options'         	=> $yes_no_button_options,
				'default_on_front'  => 'off',
				'affects' => array (
					'item_circle_border_color',
					'item_circle_border_size'
				),
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'menu_item',
			),
			'item_circle_border_color' => array(
				'label'           	=> esc_html__( 'Border Color', 'divimenus' ),
				'type'            	=> 'color-alpha',
				'default'			=> '#666666',
				'hover'				=> 'tabs',
				'mobile_options'	=> true,
				'sticky'			=> true,
				'tab_slug'        	=> 'advanced',
				'toggle_slug'     	=> 'menu_item',
			),	
			'item_circle_border_size' => array(
				'label'           	=> esc_html__( 'Border Width', 'et_builder' ),
				'type'            	=> 'range',
				'default_on_front'  => '2px',
				'fixed_unit'		=> 'px',
				'range_settings' 	=> array(
					'min'  => '0',
					'min_limit'  => '0',
					'max'  => '30',
					'step' => '1',
				),
				'hover'				=> 'tabs',
				'sticky'			=> true,
				'tab_slug'        	=> 'advanced',
				'toggle_slug'     	=> 'menu_item',
			),
			'item_fit_bg' => array(
				'label'           	=> esc_html__( 'Fit to Content', 'divimenus' ),
				'description'     	=> esc_html__( 'Here you can choose whether or not the Menu Item background should be adjusted to the text.', 'divimenus' ),
				'type'            	=> 'yes_no_button',
				'options'         	=> $yes_no_button_options,	
				'default'			=> 'off',							
				'tab_slug'        	=> 'advanced',
				'toggle_slug'     	=> 'menu_item',
			),
			'item_icon_color' => array(
				'label'             => esc_html__( 'Icon Color', 'divimenus' ),
				'type'              => 'color-alpha',
				'default'  			=> '#666666',
				'hover' 			=> 'tabs',
				'mobile_options'	=> true,
				'sticky'			=> true,
				'show_if'			=> array('item_use_custom' => 'on'),
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'icon_settings',
			),			
			'item_icon_font_size' => array(
				'label'           	=> esc_html__( 'Icon Font Size', 'divimenus' ),
				'type'            	=> 'range',			
				'default_on_front'  => '33px',
				'range_settings' 	=> array(
					'min'  => '14',
					'min_limit'  => '0',
					'max'  => '72',
					'step' => '1',
				),
				'fixed_unit'		=> 'px',
				'mobile_options'  	=> true,
				'show_if'			=> array('item_use_custom' => 'on'),
				'tab_slug'        	=> 'advanced',
				'toggle_slug'     	=> 'icon_settings',
			),	
			'item_image_size' => array(
				'label'           	=> esc_html__( 'Image Width (px)', 'divimenus' ),
				'type'            	=> 'range',
				'default_on_front'  => '57px',
				'range_settings' 	=> array(
					'min'  => '16',
					'min_limit'  => '0',
					'max'  => '720',
					'step' => '1',
				),
				'fixed_unit'		=> 'px',			
				'show_if'			=> array('item_use_custom' => 'on'),
				'mobile_options'  	=> true,
				'tab_slug'       	=> 'advanced',
				'toggle_slug'     	=> 'image_settings',
			),
			'item_font_family' => array(
				'label'           	=> esc_html__( 'Font', 'divimenus' ),
				'type'            	=> 'select',
				'options'         	=> $fonts,
				'default_on_front'  => 'Roboto Mono',
				'show_if'			=> array('item_use_custom' => 'on'),
				'tab_slug'       	=> 'advanced',
				'toggle_slug'     	=> 'text_settings',
			),
			'item_font_options' => array(
				'label'             => esc_html__( 'Font Options', 'divimenus' ),
				'type'            	=> 'multiple_checkboxes',
				'options'         	=> array(
					'bold'   	=> esc_html__( 'Bold', 'divimenus' ),
					'italics'  	=> esc_html__( 'Italic', 'divimenus' ),
				),
				'show_if'			=> array('item_use_custom' => 'on'),
				'tab_slug'        	=> 'advanced',
				'toggle_slug'     	=> 'text_settings',
			),
			'item_text_color' => array(
				'label'           	=> esc_html__( 'Text Color', 'et_builder' ),
				'type'              => 'color-alpha',
				'default' 			=> '#666666',
				'hover'				=> 'tabs',
				'mobile_options'	=> true,
				'sticky'			=> true,
				'show_if'			=> array('item_use_custom' => 'on'),
				'tab_slug'        	=> 'advanced',
				'toggle_slug'     	=> 'text_settings',
			),
			'item_font_size' => array( 
				'label'           	=> esc_html__( 'Text Size', 'et_builder' ),
				'type'            	=> 'range',
				'default'			=> '15px',				
				'range_settings' => array(
					'min'  => '10',
					'min_limit'  => '0',
					'max'  => '32',
					'step' => '1',
				),	
				'fixed_unit'		=> 'px',
				'mobile_options'  	=> true,
				'show_if'			=> array('item_use_custom' => 'on'),
				'tab_slug'        	=> 'advanced',
				'toggle_slug'     	=> 'text_settings',					
			),		
			'title_position' => array(
				'label'           	=> esc_html__( 'Position', 'divimenus' ),
				'description'       => esc_html__( 'Here you can change the Title position for this Menu Item.', 'divimenus' ),
				'type'            	=> 'select',
				'options'         	=> $title_positions,
				'default_on_front'  => 'inherit',
				'mobile_options'	=> true,
				'tab_slug'        	=> 'advanced',	
				'toggle_slug'       => 'title',
			),
			'title_disable' => array(
				'label'           	=> esc_html__( 'Hide Title', 'divimenus' ),
				'description'       => esc_html__( 'Here you can hide the Title for this Menu Item.', 'divimenus' ),
				'type'            	=> 'yes_no_button',
				'options'         	=> $yes_no_button_options,
				'tab_slug'        	=> 'advanced',	
				'toggle_slug'       => 'title',
			),
			'item_use_padding' => array(
				'label'           	=>  esc_html__('Use Custom Background for this Menu Item?', 'divimenus' ),
				'type'            	=> 'yes_no_button',
				'options'         	=> $yes_no_button_options,
				'default_on_front'  => 'off', 
				'affects'         	=> array(
					'menu_item_padding',
				),
				'tab_slug'      	=> 'advanced',
				'toggle_slug' 	    => 'paddings',			
			),
			'menu_item_padding' => array(
				'label'           	=> esc_html__( 'Menu Item Background', 'divimenus' ),
				'description'     	=> esc_html__( 'Here you can define the Menu Item background padding.', 'divimenus' ),
				'type'            	=> 'range',
				'default'         	=> '15px',
				'default_on_child'  => true,
				'range_settings' 	=> array(
					'min'  => '10',
					'min_limit'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'fixed_unit'		=> 'px',
				'mobile_options'  	=> true,
				'tab_slug'       	=> 'advanced',
				'toggle_slug'     	=> 'paddings'
			),
			'module_class' => array(
				'label'           => esc_html__( 'CSS Class', 'et_builder' ),
				'description'     => esc_html__( "Assign any number of CSS Classes to the element, separated by spaces, which can be used to assign custom CSS styles from within your child theme or from within Divi's custom CSS inputs.", 'et_builder' ),
				'type'            => 'text',
				'tab_slug'        => 'custom_css',
				'toggle_slug'     => 'classes',
				'option_class'    => 'et_pb_custom_css_regular',
			),
		);

		$fields = array_merge($fields, DiviMenusHelper::get_link_fields('url_option', $this->get_rel_values()));	

		$fields['link_type']['options']['divi_library'] = esc_html__( 'Popup', 'divimenus' );
		$fields = array_merge($fields, DiviMenusHelper::get_popup_fields('item_link', 'popup', 'divi_library'));	

		$fields['link_type']['options']['show'] = esc_html__( 'Show', 'divimenus' );
		$fields = array_merge($fields, DiviMenusHelper::get_show_fields('item_link'));
		
		$fields['hover_click'] = DiviMenusHelper::get_hover_click_field('main_content');
		$fields = array_merge($fields, DiviMenusHelper::get_effect_fields('divi_library'));
		$fields['alt'] = DiviMenusHelper::get_alt_field( '', '', esc_html__('Image Alternative Text') );

		if (et_builder_bfb_enabled() || et_get_option('et_enable_classic_editor', 'off') !== 'on') {
			$fields['item_font_icon']['show_if_not'] = array( 'parentModule:menu_item_select' => array('image_option', 'text_option'));  
			$fields['item_image']['show_if_not'] = array( 'parentModule:menu_item_select' => array('icon_option', 'text_option') );
			$fields['text_title']['show_if_not'] = array( 'parentModule:menu_item_select' => array('image_option', 'icon_option') );
			$fields['item_icon_color']['show_if_not'] = array( 'item_use_custom' => 'off', 'parentModule:menu_item_select' => array('image_option', 'text_option'));
			$fields['item_icon_font_size']['show_if_not'] = array( 'item_use_custom' => 'off', 'parentModule:menu_item_select' => array('image_option', 'text_option'));
			$fields['item_image_size']['show_if_not'] = array( 'item_use_custom' => 'off', 'parentModule:menu_item_select' => array('icon_option', 'text_option'));
			$fields['item_fit_bg']['show_if'] = array( 'item_use_custom' => 'on', 'parentModule:menu_item_select' => 'text_option');
			$fields['item_fit_bg']['show_if_not'] = array( 'parentModule:menu_type' => array('circular'));
			$fields['item_font_family']['show_if_not'] = array( 'item_use_custom' => 'off', 'parentModule:menu_item_select' => array('image_option', 'icon_option'));
			$fields['item_font_options']['show_if_not'] = array( 'item_use_custom' => 'off', 'parentModule:menu_item_select' => array('image_option', 'icon_option'));
			$fields['item_text_color']['show_if_not'] = array( 'item_use_custom' => 'off', 'parentModule:menu_item_select' => array('image_option', 'icon_option'));
			$fields['item_font_size']['show_if_not'] = array( 'item_use_custom' => 'off', 'parentModule:menu_item_select' => array('image_option', 'icon_option'));
			$fields['title_position']['show_if_not'] = array( 'parentModule:menu_item_show_title' => 'off');
			$fields['title_disable']['show_if_not'] = array( 'parentModule:menu_item_show_title' => 'off');
			$fields['alt']['show_if_not'] = array( 'parentModule:menu_item_select' => array('icon_option', 'text_option'));			
		}
		return $fields;
	}

	public function render( $attrs, $content, $render_slug ) {

		global $et_pb_divimenus, $et_pb_divimenus_render_on_tablet, $et_pb_divimenus_render_on_phone;

		$custom     	= $this->props['item_use_custom'] === 'on';
		$disabled 		= $et_pb_divimenus['disable_items'] === 'on' || $this->props['disable_item'] === 'on';
		$item_content 	= $et_pb_divimenus['menu_item_select'];
		$text_title     = '' === trim($this->props['text_title']) ? 'Item' : trim($this->props['text_title']);
		$title          = '' === trim($this->props['title']) ? 'Item' : trim($this->props['title']);
		$use_border 	= $this->props['item_use_circle_border'] === 'on';

		$url = apply_filters('dd_menu_item_url', DiviMenusHelper::get_url($this->props), $this->props);

		global $et_pb_divimenus_items, $et_pb_divimenus_item_num;

		$et_pb_divimenus_item_num++;

		DiviMenusHelper::set_item_values($this->props, $et_pb_divimenus);

		if ( $custom && $item_content === 'icon_option') {
			$icon_size_values = et_pb_responsive_options()->get_property_values( $this->props, 'item_icon_font_size' );
			et_pb_responsive_options()->generate_responsive_css( $icon_size_values, '%%order_class%% .dd-menu-item .dd-icon-content.dd-menu-item-content', 'font-size', $render_slug );
		
			$this->generate_styles(
				array(
					'base_attr_name' => 'item_icon_color',
					'selector'       => '%%order_class%% .dd-item.dd-icon-content',
					'hover_selector' => '%%order_class%% .dd-mi .dd-item.dd-icon-content.hover, %%order_class%% .dd-mi .dd-item.dd-icon-content.active',
					'css_property'   => 'color',
					'render_slug'    => $render_slug,
					'type'           => 'color',
				)
			);
		}
	 
		if ($custom && $item_content === 'image_option') {
			$image_width_values = et_pb_responsive_options()->get_property_values( $this->props, 'item_image_size' );
			et_pb_responsive_options()->generate_responsive_css( $image_width_values, '%%order_class%% .dd-item img', 'width', $render_slug );
			et_pb_responsive_options()->generate_responsive_css( $image_width_values, '%%order_class%% .dd-item img', 'height', $render_slug );
		}
		
		if ($custom && $item_content === 'text_option') {
			$bold = ''; $italics = '';
			if (!empty($this->props['item_font_options'])) {
				$font_options = explode('|', $this->props['item_font_options']);
				if ($font_options[0] === 'on') $bold = 'font-weight: bold;'; 
				if ($font_options[1] === 'on') $italics = 'font-style: italic;';
			}
			DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-mi .dd-menu-item-content .dd-text', sprintf('font-family: "%1$s", monospace;%2$s%3$s', esc_html( $this->props['item_font_family'] ), $bold, $italics));
			$this->generate_styles(
				array(
					'base_attr_name' => 'item_text_color',
					'selector'       => '%%order_class%% .dd-item .dd-text',
					'hover_selector' => '%%order_class%% .dd-mi .dd-item.hover .dd-text, %%order_class%% .dd-mi .dd-item.active .dd-text',
					'css_property'   => 'color',
					'important'		 => true,
					'render_slug'    => $render_slug,
					'type'           => 'color',
				)
			);
			$text_size_values = et_pb_responsive_options()->get_property_values( $this->props, 'item_font_size' );
			et_pb_responsive_options()->generate_responsive_css( $text_size_values, '%%order_class%% .dd-menu-item .dd-menu-item-content .dd-text', 'font-size', $render_slug );
			
			et_builder_enqueue_font( $this->props['item_font_family'] );
		}

		// item size	
		$responsive_enabled = et_pb_responsive_options()-> is_responsive_enabled($this->props, 'item_icon_font_size');
		$icon_size  = DiviMenusHelper::get_value(!$custom ? $et_pb_divimenus['menu_item_icon_font_size'] : $this->props['item_icon_font_size'], 33);
		$icon_size_t  = DiviMenusHelper::get_value(!$custom ? $et_pb_divimenus['menu_item_icon_font_size_tablet'] : 
			($responsive_enabled ? $this->props['item_icon_font_size_tablet'] : $icon_size), $icon_size);
		$icon_size_p  = DiviMenusHelper::get_value(!$custom ? $et_pb_divimenus['menu_item_icon_font_size_phone'] : 
			($responsive_enabled ? $this->props['item_icon_font_size_phone'] : $icon_size), $icon_size_t);

		$responsive_enabled = et_pb_responsive_options()-> is_responsive_enabled($this->props, 'item_font_size');
		$text_size = DiviMenusHelper::get_value(!$custom ? $et_pb_divimenus['menu_item_font_size'] : $this->props['item_font_size'], 15);
		$text_size_t = DiviMenusHelper::get_value(!$custom ? $et_pb_divimenus['menu_item_font_size_tablet'] :  
			($responsive_enabled ? $this->props['item_font_size_tablet'] : $text_size), $text_size);
		$text_size_p = DiviMenusHelper::get_value(!$custom ? $et_pb_divimenus['menu_item_font_size_phone'] : 
			($responsive_enabled ? $this->props['item_font_size_phone'] : $text_size), $text_size_t); 

		$responsive_enabled = et_pb_responsive_options()-> is_responsive_enabled($this->props, 'item_image_size');
		$image_width = DiviMenusHelper::get_value(!$custom ? $et_pb_divimenus['menu_item_image_size'] : $this->props['item_image_size'], 57);
		$image_width_t = DiviMenusHelper::get_value(!$custom ? $et_pb_divimenus['menu_item_image_size_tablet'] :
			($responsive_enabled ? $this->props['item_image_size_tablet'] : $image_width), $image_width); 
		$image_width_p = DiviMenusHelper::get_value(!$custom ? $et_pb_divimenus['menu_item_image_size_phone'] :
			($responsive_enabled ? $this->props['item_image_size_phone'] : $image_width), $image_width_t);

		$image_height = $custom ? $this->props['item_image_size'] : $image_width;
		$image_height_t = $custom ? $this->props['item_image_size_tablet'] : $image_width_t;
		$image_height_p = $custom ? $this->props['item_image_size_phone'] : $image_width_p ;

		$content_size = DiviMenusHelper::get_menu_item_content_size($item_content, $text_size, $icon_size, $this->props['item_image'], $image_width, $image_height);
		$content_size_t = DiviMenusHelper::get_menu_item_content_size($item_content, $text_size_t, $icon_size_t, $this->props['item_image'], $image_width_t, $image_height_t);
		$content_size_p = DiviMenusHelper::get_menu_item_content_size($item_content, $text_size_p, $icon_size_p, $this->props['item_image'], $image_width_p, $image_height_p); 

		$font_family = $custom ? $this->props['item_font_family'] : $et_pb_divimenus['menu_item_font_family'];

		$item_padding = DiviMenusHelper::get_menu_item_padding($this->props, $title, $font_family, $content_size, $this->props['menu_item_padding']);
		$item_padding_t = DiviMenusHelper::get_menu_item_padding($this->props, $title, $font_family, $content_size_t, $this->props['menu_item_padding_tablet']);
		$item_padding_p = DiviMenusHelper::get_menu_item_padding($this->props, $title, $font_family, $content_size_p, $this->props['menu_item_padding_phone']);

		$item_size = DiviMenusHelper::get_menu_item_size($item_content, $content_size, $item_padding, $custom, $use_border, $this->props['item_circle_border_size']);
		$item_size_t = DiviMenusHelper::get_menu_item_size($item_content, $content_size_t, $item_padding_t, $custom, $use_border, $this->props['item_circle_border_size']);
		$item_size_p = DiviMenusHelper::get_menu_item_size($item_content, $content_size_p, $item_padding_p, $custom, $use_border, $this->props['item_circle_border_size']);

		$item_hide_responsive = et_pb_get_responsive_status( $this->props['item_hide_last_edited']);
		$hide_desktop = $this->props['item_hide'] === 'on' && $this->props['item_preserve'] !== 'on';
		$hide_tablet = !$item_hide_responsive ? $hide_desktop : $this->props['item_hide_tablet'] === 'on' && $this->props['item_preserve'] !== 'on';
		$hide_phone = !$item_hide_responsive ? $hide_desktop : $this->props['item_hide_phone'] === 'on' && $this->props['item_preserve'] !== 'on';

		$et_pb_divimenus_items[]  = ['title' => $title, 'content_size' => $content_size, 'content_size_t' => $content_size_t, 'content_size_p' => $content_size_p, 
			'use_custom' => $custom, 'use_border' => $use_border, 'border_size' => $this->props['item_circle_border_size'], 'title_disable' => $this->props['title_disable'],
			'title_position' => $this->props['title_position'], 'title_t' => $this->props['title_position_tablet'], 'title_p' => $this->props['title_position_phone'], 
			'padding' => $item_padding, 'padding_t' => $item_padding_t, 'padding_p' => $item_padding_p, 'size' => $item_size, 'size_t' => $item_size_t, 'size_p' => $item_size_p,
			'hide_desktop' => $hide_desktop, 'hide_tablet' => $hide_tablet, 'hide_phone' => $hide_phone];

		// MI padding (inherited and custom)
		$padding_lr_values = array( 'desktop' => et_builder_process_range_value($item_padding['LR']), 'tablet' => et_builder_process_range_value($item_padding_t['LR']), 'phone' => et_builder_process_range_value($item_padding_p['LR']) );
		if ($item_content !== 'text_option') {	
			et_pb_responsive_options()->generate_responsive_css( $padding_lr_values, '%%order_class%% .dd-menu-item .dd-menu-item-content', 'padding', $render_slug, '!important;' );
		}
		if ($item_content === 'text_option') {
			$padding_tb_values = array( 'desktop' => et_builder_process_range_value($item_padding['TB']), 'tablet' => et_builder_process_range_value($item_padding_t['TB']), 'phone' => et_builder_process_range_value($item_padding_p['TB']) );
			et_pb_responsive_options()->generate_responsive_css( $padding_lr_values, '%%order_class%% .dd-menu-item .dd-circle', 'width', $render_slug );
			et_pb_responsive_options()->generate_responsive_css( $padding_tb_values, '%%order_class%% .dd-menu-item .dd-circle', 'height', $render_slug ); 
		}

		if ( $custom ) {
			$this->generate_styles(
				array(
					'base_attr_name' => 'item_circle_color',
					'selector'       => '%%order_class%% .dd-item',
					'hover_selector' => '%%order_class%% .dd-mi .dd-item.hover, %%order_class%% .dd-mi .dd-item.active',
					'css_property'   => 'background-color',
					'render_slug'    => $render_slug,
					'type'           => 'color',
				)
			);
			if ( $use_border ) {
				$this->generate_styles(
					array(
						'base_attr_name' => 'item_circle_border_color',
						'selector'       => '%%order_class%% .dd-item',
						'hover_selector' => '%%order_class%% .dd-mi .dd-item.hover, %%order_class%% .dd-mi .dd-item.active',
						'css_property'   => 'border-color',
						'render_slug'    => $render_slug,
						'type'           => 'color',
					)
				);
				$this->generate_styles(
					array(
						'base_attr_name' => 'item_circle_border_size',
						'selector'       => '%%order_class%% .dd-item',
						'hover_selector' => '%%order_class%% .dd-mi .dd-item.hover, %%order_class%% .dd-mi .dd-item.active',
						'css_property'   => 'border-width',
						'render_slug'    => $render_slug,
					)
				);
			}
		}  

		// module output
		$menu_item_content = '';
		$show = $this->props['link_type'] === 'show' && (!empty($this->props['element_id']) || !empty($this->props['element_class']));
		$item_classes = array( 'dd-item dd-menu-item-content');
		if ( $show && $this->props['show_visible'] === 'on' ) $item_classes[] = 'active dd-item-open';
		if ( $custom ) $item_classes[] = 'dd-custom';
				
		if ($item_content === 'icon_option' )   {
			$item_classes[] = 'notranslate dd-icon-content';
			if (empty($this->props['item_font_icon'])) $this->props['item_font_icon'] = $et_pb_divimenus['menu_item_font_icon'];	
			$menu_item_content = DiviMenusHelper::render_icon($this->props, $render_slug, 'item_font_icon', $item_classes, false, false, false, '%%order_class%% .dd-menu-item .dd-menu-item-content.dd-icon-content', '%%order_class%% .dd-menu-item .dd-menu-item-content.dd-icon-content.hover, %%order_class%% .dd-menu-item .dd-menu-item-content.dd-icon-content.active');
		
		} else if ($item_content === 'text_option') {
			$menu_item_content = sprintf('<div class="%2$s"><span class="dd-text dd-circle" tabindex="0">%1$s</span></div>', esc_html( $title ), implode( ' ', $item_classes)); 

		} else if ($item_content === 'image_option') {
			$image_alt = DiviMenusHelper::get_image_alt($this->props, 'item_image', 'alt');
			$image = DiviMenusHelper::render_image($this->props, 'item_image', '', $image_alt, DIVIMENUS_PLACEHOLDER_IMAGE_DATA);
			$menu_item_content = sprintf('<div class="%2$s" tabindex="0">%1$s</div>', $image, implode( ' ', $item_classes)); 
		}

		$mi_uniqid = uniqid().rand(1,999);
		$menu_item_attrs = DiviMenusHelper::get_menu_item_attrs($this, 'divi_library', false, $show, $mi_uniqid);
		$menu_item = $disabled ? $menu_item_content : sprintf('<a href="%2$s"%3$s>%1$s</a>', $menu_item_content, $url, $menu_item_attrs);
		
		$mi_classes = array('dd-mi dd-menu-item');
		if ($this->props['active_url'] === 'on') $mi_classes []= 'dd-active-url';
		if ($this->props['hover_click'] === 'click') $mi_classes []= 'dd-click';
		if ($disabled) $mi_classes []= 'dd-disabled';
		$cdm_responsive = et_pb_responsive_options()-> is_responsive_enabled($this->props, 'close_dm');
		$cdm_values = et_pb_responsive_options()->get_property_values($this->props, 'close_dm', $this->props['close_dm'], true);
		$cdm_classes = DiviMenusHelper::get_responsive_classnames($cdm_values, $cdm_responsive, 'dd-c', 'on' );
		$mi_classes []= $cdm_classes;

		$title_output = ''; 
		if ($et_pb_divimenus['menu_item_show_title'] === 'on' && $this->props['title_disable'] !== 'on') {
			if ($et_pb_divimenus['menu_item_select'] === 'text_option') $title = $text_title;
			$title_classes = array('dd-title', $cdm_classes);
			if ($et_pb_divimenus['tooltip_use_background'] === 'on') $title_classes[]= 'dd-title-bg';
			
			$title_output = sprintf('<div class="dd-tooltip%2$s%3$s%4$s%5$s%6$s"><div class="%7$s"><span>%1$s</span></div></div>', 
				$et_pb_divimenus['title_clickable'] === 'on' && !$disabled ? 
				sprintf('<a href="%2$s" %3$s>%1$s</a>', esc_html( $title ), $url, 'on' === $this->props['url_new_window'] ? ' target="_blank"' : '' ) : esc_html( $title ), 
				$et_pb_divimenus['tooltip_behavior'] === 'hover' ? ' dd-hover': '',
				$et_pb_divimenus['titles_hover_enabled']  && !$disabled ? ' dd-hover-enabled': '',
				$et_pb_divimenus['title_clickable'] === 'on' && !$disabled ? ' dd-title-clickable': '',
				$this->props['link_type'] === 'show' && (!empty($this->props['element_id']) || !empty($this->props['element_class']) ) && $this->props['show_visible'] === 'on' ? ' active dd-item-open' : '', #5
				$this->props['hover_click'] === 'click' ? ' dd-click' : '',
				implode(' ', $title_classes)
			);
		}

		$menu_item_output = sprintf(
			'<div class="%2$s"%3$s>		
				%1$s	
			</div>
			%4$s
			%5$s
			%6$s',			
			$menu_item,
			implode(' ', $mi_classes),
			$disabled ? ' role="menuitem"' : '',
			$title_output,	
			apply_filters('dd_menu_item_after', $this->props['link_type'] === 'divi_library' && DiviMenusHelper::is_post($this->props['divi_layout'], 'et_pb_layout') ? DiviMenusHelper::render_popup($this, $render_slug, $this->props['divi_layout'], $mi_uniqid) : '', $this->props),
			$show && $this->props['show_visible'] !== 'on' ? sprintf('<style type="text/css">%s{display:none;}</style>', DiviMenusHelper::get_show_selector(esc_html($this->props['element_id']), esc_html($this->props['element_class']))) : ''
		);

		$this->remove_classname( array( 'et_pb_module' ) );

		$output = '';
		if ($item_hide_responsive) {
			$multi_view = et_pb_multi_view_options( $this );
			$output .= $multi_view->render_element(
				array(
					'tag'     => 'div',
					'content' => $menu_item_output,
					'attrs'   => array(
						'class' => 'dd-mi-w dd-menu-item-wrapper'
					),
					'visibility' => array(
						'item_hide' => 'off',
					),
				)
			);
		} else if ($this->props['item_hide'] !== 'on') {
			$output .= '<div class="dd-mi-w dd-menu-item-wrapper">'.$menu_item_output.'</div>';
		}
		return $output;				
	}

	public function multi_view_filter_value( $raw_value, $args, $multi_view ) {
		$name = isset( $args['name'] ) ? $args['name'] : '';

		if ( $raw_value && 'popup_close_font_icon' === $name && function_exists('et_pb_extended_process_font_icon'))
			return et_pb_extended_process_font_icon( $raw_value );
		else if ( $raw_value && 'popup_close_font_icon' === $name )
			return html_entity_decode( et_pb_process_font_icon( $raw_value ) );
		
		return $raw_value;
	}

	public function get_rel_values() {
		return array( 'bookmark', 'external', 'nofollow', 'noreferrer', 'noopener', 'sponsored' );
	}
}

new DiviMenus_Item_Module;