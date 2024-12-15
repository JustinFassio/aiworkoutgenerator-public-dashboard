<?php

class DiviMenusFlex_Item_Module extends ET_Builder_Module {

	public $slug       = 'et_pb_divimenus_flex_item';
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
					'cart'			=> esc_html__( 'Shopping Cart', 'divimenus' ),
					'item_link'     => esc_html__( 'Link', 'et_builder' ),
				),
			),
			'advanced' => array(
				'toggles' => array(
					'alignment'			=> esc_html__( 'Alignment', 'et_builder' ),
					'text_settings'  	=> esc_html__( 'Menu Item TEXT', 'divimenus' ),	
					'icon_settings'  	=> esc_html__( 'Menu Item ICON', 'divimenus' ),	
					'image_settings' 	=> esc_html__( 'Menu Item IMAGE', 'divimenus' ),
					'cart'				=> esc_html__( 'Shopping Cart', 'divimenus' ),
					'popup' 			=> esc_html__( 'Popup', 'divimenus' ),
					'sub' 				=> esc_html__( 'Sub', 'divimenus' ),
					'item_link' 		=> esc_html__( 'Link', 'et_builder' ),
				),
			),
		);

		$this->custom_css_fields = array(
			'menu_item_background' => array(
				'label'    => esc_html__( 'DiviMenu Menu Item', 'divimenus' ),
				'selector' => '%%order_class%% .dd-item',
			),
			'text_icon_image' => array(
				'label'    => esc_html__( 'Text Icon / Image', 'divimenus' ),
				'selector' => '%%order_class%% .dd-text-icon, %%order_class%% .dd-text-image > img',
				'show_if' => array('text_use_icon' => 'on')
			),
			'cart_info' => array(
				'label'    => esc_html__( 'Cart Info', 'divimenus' ),
				'selector' => '%%order_class%% .dd-mi .dd-item .dd-cart-info',
				'show_if' => array('is_cart' => 'on', 'cart_items_count' => 'on')
			),
			'sub_wp' => array(
				'label'    => esc_html__( 'WordPress Menu', 'divimenus' ),
				'selector' => '%%order_class%% .dd-mi-w .dd-mi .dd-menu-flex-sub > ul',
				'show_if' => array('link_type' => 'sub', 'sub_source' => 'menu')
			),
			'sub_wp_links' => array(
				'label'    => esc_html__( 'WordPress Menu Item', 'divimenus' ),
				'selector' => '%%order_class%% .dd-mi-w .dd-mi .dd-menu-flex-sub a',
				'show_if' => array('link_type' => 'sub', 'sub_source' => 'menu')
			),
			'sub_wp_dropdowns' => array(
				'label'    => esc_html__( 'WordPress Sub Menu Item', 'divimenus' ),
				'selector' => '%%order_class%% .dd-mi-w .dd-mi .dd-menu-flex-sub ul ul a',
				'show_if' => array('link_type' => 'sub', 'sub_source' => 'menu')
			),
			'sub_wp_collapse' => array(
				'label'    => esc_html__( 'Collapse Icon', 'divimenus' ),
				'selector' => '%%order_class%% .dd-mi-w .dd-mi .dd-menu-flex-sub span.dd-collapse',
				'show_if' => array('link_type' => 'sub', 'sub_source' => 'menu', 'sub_collapse' => 'on')
			),
		);
		
		add_filter('nav_menu_link_attributes', array($this, 'nav_menu_link_attrs'), 1, 3);	
		add_filter('nav_menu_css_class', array($this, 'nav_menu_css_class'), 1, 3);
	}
	
	public function get_advanced_fields_config() {
		$advanced_fields = array(
			'background' 	=> array(
				'css'      	=> array(
					'main' 	=> "{$this->main_css_element} .dd-mi .dd-menu-item-content",
					'hover' => "{$this->main_css_element} .dd-mi-w .dd-mi .dd-menu-item-content.hover, {$this->main_css_element} .dd-mi-w .dd-mi .dd-menu-item-content.active,
						body {$this->main_css_element} .dd-menu-flex-sub .dd-menu-item-content:hover, {$this->main_css_element} .dd-mi-w .dd-mi-fb .dd-menu-item-content",
				),
				'use_background_mask' 		=> false,
				'use_background_pattern'	=> false,
				'use_background_video' 		=> false	
			),
			'borders' => false,
			'box_shadow' => array(		
				'default' => array(
					'label' 	=> esc_html__( 'Background', 'divimenus' ),
					'css' => array(
						'main' 	=> "{$this->main_css_element} .dd-mi .dd-item",
						'hover' => "{$this->main_css_element} .dd-mi .dd-item.hover, {$this->main_css_element} .dd-mi .dd-item.active",					
					),											
				),
				'image' => array (
					'label' 	=> esc_html__( 'Image', 'divimenus' ),
					'css' => array(
						'main' 	=> "{$this->main_css_element} .dd-mi .dd-item-inner > img",														
					),	
					'depends_on' 		=> array('menu_item_content'),
					'depends_show_if'	=> 'image'				
				),
				'sub' => array (
					'label'   	=> esc_html__( 'WordPress Menu', 'divimenus' ),
					'css' => array(
						'main' 	=> "{$this->main_css_element} .dd-mi .dd-menu-flex-sub > ul",														
					),	
					'show_if'	=> array('link_type' => 'sub', 'sub_source' => 'menu'),
				)
			),
			'fonts' => array(
				'item' => array(
					'css'      	=> array(
						'main' 	=> "{$this->main_css_element} .dd-mi .dd-menu-item-content.dd-text",
						'hover' => "{$this->main_css_element} .dd-mi-w .dd-mi .dd-menu-item-content.dd-text.hover, {$this->main_css_element} .dd-mi-w .dd-mi .dd-menu-item-content.dd-text.active, 
							{$this->main_css_element} .dd-menu-flex-sub .dd-menu-item-content.dd-text:hover",
					),
					'hide_text_shadow' => true,	
					'depends_show_if' => 'text',
					'toggle_slug' => 'text_settings'
				),
				'sub' => array(
					'label' 	=> esc_html__( 'Menu Item' ),
					'css'      	=> array(
						'main' 	=> "{$this->main_css_element} .dd-mi .dd-menu-flex-sub .dd-menu-item-content",
						'hover' => "{$this->main_css_element} .dd-mi-w .dd-mi .dd-menu-flex-sub .dd-menu-item-content.dd-text:hover, {$this->main_css_element} .dd-mi-w .dd-mi .dd-menu-flex-sub .dd-menu-item-content.dd-text.active",
					),
					'line_height' 	=> array(
						'default_on_child' => true,
						'default' => '1.3em',
					),
					'text_align' 		=> array( 'show_if' => array( 'link_type' => 'sub', 'sub_source' => 'menu' ) ),
					'hide_text_shadow' 	=> true,
					'depends_show_if' 	=> 'menu',
					'toggle_slug' 		=> 'sub'
				),	
			),
			'height' => false,
			'margin_padding' => array(
				'toggle_slug' 	=> 'paddings',
				'css' => array( 
					'main'	=> "{$this->main_css_element} .dd-menu-flex-item-wrapper",
					'padding' => "{$this->main_css_element} .dd-item",
					'important' => 'all',
				),
			),
			'max_width' => array(
				'css' => array(
					'module_alignment' => ".et_pb_divimenus_flex {$this->main_css_element}",
				),
				'options' => array(
					'module_alignment' => array(
						'label' 		=> esc_html__( 'Menu Item', 'divimenus' ),
						'description' 	=> esc_html__( 'Align this Menu Item to the left, right or center', 'divimenus' ),
						'toggle_slug' 	=> 'alignment',
					),
				),
				'use_width'	=> false,
				'use_max_width' => false,
				'use_min_height' => false
			),
			'link_options' => false,
			'position_fields' => array(
				'default' => 'relative',
			),
			'text' => false,
			'transform' 	=> array(
				'css'      	=> array(
					'main' 	=> "{$this->main_css_element} .dd-item"
				),	
			),
		);
		if (DiviMenusHelper::wc_active())
			$advanced_fields['fonts']['cart'] = array(
				'label' 	=> esc_html__( 'Cart Info' ),
				'css'      	=> array(
					'main' 	=> "{$this->main_css_element} .dd-cart-info",
					'hover' => "{$this->main_css_element} .dd-item.hover .dd-cart-info, {$this->main_css_element} .dd-item.active .dd-cart-info",
				),
				'font_size' => array(
					'default_on_child' => true,
					'default'  => '14px',
				),
				'color' => array(
					'default_on_child' => true,
					'default'  => '#fff',
				),
				'hide_letter_spacing' => true,
				'hide_line_height' 	=> true,
				'hide_text_align'	=> true,
				'hide_text_shadow' 	=> true,	
				'depends_show_if' 	=> 'on',
				'toggle_slug' => 'cart'
			);
		return $advanced_fields;
	}

	public function get_fields() {
		$yes_no_button_options = DiviMenusHelper::get_yes_no_button_options();
		$fields = array(
			'title' => array(
				'label'       		=> esc_html__( 'Title', 'et_builder' ),
				'description' 		=> esc_html__( 'Define the Title for your Menu Item.', 'divimenus' ),
				'type'        		=> 'text',
				'default'  			=> 'Item',				
				'hover'				=> 'tabs',
				'toggle_slug' 		=> 'main_content',
				'dynamic_content' 	=> 'text',	
			),
			'menu_item_content' 	=> array(
				'label' 			=> esc_html__( 'Content', 'divimenus' ),
				'type'          	=> 'select',
				'options'       => array(
					'icon' 		=> esc_html__( 'Icon', 'divimenus' ),
					'image'  	=> esc_html__( 'Image', 'divimenus' ),
					'text'  	=> esc_html__( 'Text', 'divimenus' )
				),
				'default'	=> 'text',
				'affects' => array (
					'item_font',
					'item_text_color',
					'item_font_size',
					'item_text_align',
					'item_letter_spacing',
					'item_line_height',
				),
				'toggle_slug'       => 'main_content',
			),			
			'item_font_icon' => array(
				'label'             => esc_html__( 'Icon', 'et_builder' ),
				'type'              => 'select_icon',
				'class'             => array( 'et-pb-font-icon' ),
				'default'			=> '%%43%%',
				'show_if'			=> array('menu_item_content' => 'icon'),
				'hover'				=> 'tabs',
				'toggle_slug'       => 'main_content',			
			),
			'item_image' => array(
				'label'             => esc_html__( 'Image', 'divimenus' ),
				'type'              => 'upload',
				'upload_button_text'=> esc_attr__( 'Upload an image', 'et_builder' ),
				'choose_text'       => esc_attr__( 'Choose an Image', 'et_builder' ),
				'update_text'       => esc_attr__( 'Set As Image', 'et_builder' ),
				'show_if'			=> array('menu_item_content' => 'image'),
				'hover'				=> 'tabs',
				'toggle_slug'       => 'main_content',
				'dynamic_content' 	=> 'image',		
			),
			'disable_item' => array(
				'label'           	=> esc_html__( 'Disable', 'divimenus' ),
				'description'     	=> esc_html__( 'Here you can choose whether to disable the click event on this Menu Item.', 'divimenus' ),
				'type'            	=> 'yes_no_button',
				'options'         	=> $yes_no_button_options,
				'default'			=> 'off',		
				'toggle_slug'       => 'main_content',
			),
			'alignment' => array(
				'label'           	=> esc_html__( 'Menu Item Content', 'divimenus' ),
				'description'     	=> esc_html__( 'Here you can control the content alignment of this Menu Item.', 'divimenus' ),
				'type'            	=> 'text_align',
				'options'         	=> et_builder_get_text_orientation_options(),
				'options_icon'    	=> 'module_align',
				'tab_slug'        	=> 'advanced',
				'toggle_slug'     	=> 'alignment',
			),			
			'item_icon_color' => array(
				'label'             => esc_html__( 'Icon Color', 'divimenus' ),
				'type'              => 'color-alpha',
				'hover' 			=> 'tabs',
				'mobile_options'  	=> true,
				'sticky'			=> true,
				'show_if'			=> array('menu_item_content' => 'icon'),
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'icon_settings',
			),			
			'item_icon_font_size' => array(
				'label'           	=> esc_html__( 'Icon Font Size', 'divimenus' ),
				'type'            	=> 'range',			
				'default_unit'		=> 'px',
				'validate_unit'		=> true,
				'show_if'			=> array('menu_item_content' => 'icon'),
				'mobile_options'  	=> true,
				'sticky'			=> true,
				'tab_slug'        	=> 'advanced',
				'toggle_slug'     	=> 'icon_settings',
			),	
			'item_image_size' => array(
				'label'           	=> esc_html__( 'Image Width', 'divimenus' ),
				'type'            	=> 'range',
				'range_settings' 	=> array(
					'max'  	=> 550,
					'step'	=> 1
				),
				'allowed_values' 	=> et_builder_get_acceptable_css_string_values( 'width' ),
				'default_unit'		=> 'px',
				'validate_unit'		=> true,			
				'show_if'			=> array('menu_item_content' => 'image'),
				'mobile_options'  	=> true,
				'sticky'			=> true,
				'tab_slug'       	=> 'advanced',
				'toggle_slug'     	=> 'image_settings',
			),	
			'module_class' => array(
				'label'           => esc_html__( 'CSS Class', 'et_builder' ),
				'description'     => esc_html__( "Assign any number of CSS Classes to the element, separated by spaces, which can be used to assign custom CSS styles from within your child theme or from within Divi's custom CSS inputs.", 'et_builder' ),
				'type'            => 'text',
				'tab_slug'        => 'custom_css',
				'toggle_slug'     => 'classes',
				'option_class'    => 'et_pb_custom_css_regular',
			),
			'disabled_on' => array(
				'label'           => esc_html__( 'Hide On', 'divimenus' ),
				'description'     => esc_html__( 'This will hide the Menu Item on selected devices', 'divimenus' ),
				'type'            => 'multiple_checkboxes',
				'options'         => array(
					'phone'   => esc_html__( 'Phone', 'et_builder' ),
					'tablet'  => esc_html__( 'Tablet', 'et_builder' ),
					'desktop' => esc_html__( 'Desktop', 'et_builder' ),
				),
				'tab_slug'        => 'custom_css',
				'toggle_slug'     => 'visibility',
			),
			'visible_on' => array(
				'label'           => esc_html__( 'Force Visible On', 'divimenus' ),
				'description'     => esc_html__( 'This will keep the Menu Item visible on selected devices', 'divimenus' ),
				'type'            => 'multiple_checkboxes',
				'options'         => array(
					'phone'   => esc_html__( 'Phone', 'et_builder' ),
					'tablet'  => esc_html__( 'Tablet', 'et_builder' ),
					'desktop' => esc_html__( 'Desktop', 'et_builder' ),
				),
				'tab_slug'        => 'custom_css',
				'toggle_slug'     => 'visibility',
			),
			
		);
		$fields = array_merge($fields, DiviMenusHelper::get_text_icon_fields('main_content', 'menu_item_content'));
		if (DiviMenusHelper::wc_active() || function_exists('edd_get_checkout_uri')) $fields = array_merge($fields, DiviMenusHelper::get_cart_fields());
		$fields = array_merge($fields, DiviMenusHelper::get_link_fields('url', $this->get_rel_values()));
		
		$fields['link_type']['options']['popup'] = esc_html__( 'Popup', 'divimenus' );		
		$fields = array_merge($fields, DiviMenusHelper::get_popup_fields('item_link', 'popup',  'popup'));

		$fields['link_type']['options']['sub'] = esc_html__( 'Sub', 'divimenus' );
		$fields = array_merge($fields, DiviMenusHelper::get_sub_fields('item_link', 'sub'));

		$fields['link_type']['options']['show'] = esc_html__( 'Show', 'divimenus' );
		$fields = array_merge($fields, DiviMenusHelper::get_show_fields('item_link'));
		
		$fields['hover_click'] = DiviMenusHelper::get_hover_click_field('main_content');
		$fields = array_merge($fields, DiviMenusHelper::get_effect_fields('popup'));
		$fields['alt'] = DiviMenusHelper::get_alt_field( '', '', esc_html__('Image Alternative Text') );
		return $fields;		
	}

	public function get_transition_fields_css_props() {
		$fields = parent::get_transition_fields_css_props();

		$fields['item_icon_color'] = array(
			'color' => '%%order_class%% .dd-mi .dd-icon .dd-icon-content',
		);	

		return $fields;
	}

	public function render( $attrs, $content, $render_slug ) {
		
		global $dm_direction, $mi_fullwidth, $et_pb_divimenus_render_on_tablet, $et_pb_divimenus_render_on_phone;
		
		$multi_view 	= et_pb_multi_view_options( $this );
		$show 			= $this->props['link_type'] === 'show' && (!empty($this->props['element_id']) || !empty($this->props['element_class']));	
		
		$url = apply_filters('dd_menu_item_url', DiviMenusHelper::get_url($this->props), $this->props);

		// module style
		$this->generate_styles(
			array(
				'base_attr_name' => 'positioning',
				'selector'       => '.dd-divimenu-open %%order_class%%',
				'css_property'   => 'position',
				'important'		 => true,
				'render_slug'    => $render_slug,
			)
		);
		DiviMenusHelper::set_visibility($render_slug, $this->props, 'visible_on', '%%order_class%%', true);

		if (!empty($this->props['alignment']) ) {
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => '%%order_class%% .dd-menu-item-content',
				'declaration' => DiviMenusHelper::get_content_alignment_css($this->props['alignment'], $this->props['text_use_icon'], $this->props['text_icon_pos']),
			));
		}
		if ($this->props['menu_item_content'] === 'icon') {
			$this->generate_styles(
				array(
					'base_attr_name' => 'item_icon_color',
					'selector'       => '%%order_class%% .dd-mi .dd-icon .dd-icon-content',
					'hover_selector' => '%%order_class%% .dd-mi-w .dd-mi .dd-icon.hover .dd-icon-content, %%order_class%% .dd-mi-w .dd-mi .dd-icon.active .dd-icon-content',
					'css_property'   => 'color',
					'render_slug'    => $render_slug,
					'type'           => 'color',
				)
			);
			$this->generate_styles(
				array(
					'base_attr_name' => 'item_icon_font_size',
					'selector'       => '%%order_class%% .dd-mi .dd-icon .dd-icon-content',
					'css_property'   => 'font-size',
					'render_slug'    => $render_slug,
				)
			);
		} else if ($this->props['menu_item_content'] === 'image') {
			$this->generate_styles(
				array(
					'base_attr_name' => 'item_image_size',
					'selector'       => '%%order_class%% .dd-mi .dd-item-inner > img',
					'css_property'   => 'width',
					'render_slug'    => $render_slug,
				)
			);
		} else {
			if ($this->props['text_use_icon'] === 'on') {
				DiviMenusHelper::set_text_icon_style($render_slug, $this, '%%order_class%% .dd-text', '%%order_class%% .dd-text-icon', '%%order_class%% .dd-text-image',
				'%%order_class%% .dd-item.hover .dd-text-icon, %%order_class%% .dd-item.active .dd-text-icon', '%%order_class%% .dd-item.hover .dd-text-image, %%order_class%% .dd-item.active .dd-text-image');    
			}
		}

		// module output
		$menu_item_classes = array('dd-item dd-menu-item-content');
		if ( $show && $this->props['show_visible'] === 'on' )
			$menu_item_classes[] = 'active dd-item-open';
		
		$menu_item_content = '';
		if ($this->props['menu_item_content'] === 'icon' ) {
			$menu_item_classes[] = 'dd-icon'; // to Menu Items only

			$menu_item_content = sprintf('<div class="%3$s" tabindex="0"><div class="dd-item-inner">%1$s%2$s</div></div>',
				DiviMenusHelper::render_icon($this->props, $render_slug, 'item_font_icon', array('dd-icon-content notranslate'), true, false, false, '%%order_class%% .dd-mi .dd-icon .dd-icon-content', '%%order_class%% .dd-mi .dd-icon.hover .dd-icon-content, %%order_class%% .dd-mi .dd-icon.active .dd-icon-content'),
				apply_filters('dd_cart_output', DiviMenusHelper::show_cart_info($this), $this->props), 
				implode( ' ', $menu_item_classes )
			);
		} else if ($this->props['menu_item_content'] === 'image' ) {	
			$image_alt = DiviMenusHelper::get_image_alt($this->props, 'item_image', 'alt');		
			$image = DiviMenusHelper::render_image ($this->props, 'item_image', '', $image_alt, ET_BUILDER_PLACEHOLDER_LANDSCAPE_IMAGE_DATA);
			$menu_item_content = sprintf('<div class="%3$s" tabindex="0"><div class="dd-item-inner">%1$s%2$s</div></div>', $image, apply_filters('dd_cart_output', DiviMenusHelper::show_cart_info($this), $this->props), implode( ' ', $menu_item_classes ) );	
		} else {
			$menu_item_classes[] = 'dd-text';
			
			$text = DiviMenusHelper::render_text( $this, 'title', 'dd-text-content', 'Item' );
			$text_icon = DiviMenusHelper::maybe_render_text_icon($this->props, $render_slug, '%%order_class%% .dd-menu-item-content .dd-text-icon', '%%order_class%% .dd-menu-item-content.hover .dd-text-icon, %%order_class%% .dd-menu-item-content.active .dd-text-icon');
			$menu_item_content = sprintf('<div class="%3$s" tabindex="0">%1$s%2$s</div>', $text_icon, $text, implode( ' ', $menu_item_classes ));
		} 

		$sub = $menu_sub_item = '';
		$mi_classes = array('dd-mi dd-menu-flex-item');
		if ($this->props['disable_item'] === 'on') $mi_classes []= 'dd-disabled';
		if ($this->props['active_url'] === 'on') $mi_classes []= 'dd-active-url';
		if ($this->props['hover_click'] === 'click') $mi_classes []= 'dd-click';
		
		if ($this->props['link_type'] === 'sub') {
			if ($this->props['sub_alignment'] === 'justified') $mi_classes []= 'dd-sub-fw';

			if ($this->props['sub_source'] === 'layout')
				$sub = DiviMenusHelper::get_divi_layout( array('internal' => false, 'sub_layout' => $this->props['sub_layout']) );
			else if ($this->props['sub_source'] === 'menu' && $this->props['sub_menu_id'] !== 'none') {
				$sub = DiviMenusHelper::get_wp_menu(array( 'props'=> $this->props, 'frontend' => true, 'sub_menu_id' => $this->props['sub_menu_id'], 'sub_collapse' => $this->props['sub_collapse'], 'sub_icon' => $this->props['sub_icon'], 'sub_accordion' => $this->props['sub_accordion']) );
				DiviMenusHelper::set_wp_menu_style($render_slug, $this);
			}
			if ($sub) {
				$menu_sub_item = sprintf('<div class="dd-menu-flex-sub">%1$s</div>', $sub );
				$is_absolute = array('all' => false, 'desktop' => false, 'tablet' => false, 'phone' => false);
				
				if ( $this->props['sub_custom'] === 'on' ) { // custom display
					$subd_responsive = et_pb_responsive_options()-> is_responsive_enabled($this->props, 'sub_display');
					$sub_display = et_pb_responsive_options()->get_property_values($this->props, 'sub_display', $this->props['sub_display'], true);
					if (!$subd_responsive) {
						if ($sub_display['desktop'] !== 'inline')
							$is_absolute['all'] = true;	
					} else {
						foreach ( et_pb_responsive_options()->get_modes() as $device ) {
							if ($sub_display[$device] !== 'inline')
								$is_absolute[$device] = true;	
						}
					}
					$mi_classes [] = DiviMenusHelper::get_responsive_classnames($sub_display, $subd_responsive, 'dd-h', 'absolute');
					$mi_classes [] = DiviMenusHelper::get_responsive_classnames($sub_display, $subd_responsive, 'dd-h-c', 'click');
				} else { // default display
					if (!$dm_direction['responsive_enabled']) {
						if ($dm_direction['desktop'] === 'row')
							$is_absolute['all'] = true;
					} else {
						foreach ( et_pb_responsive_options()->get_modes() as $device ) {
							if ($dm_direction[$device] === 'row')
								$is_absolute[$device] = true;	
						}
					}
					$mi_classes [] = DiviMenusHelper::get_responsive_classnames($dm_direction, true, 'dd-h', 'row');
				}
				if ( $is_absolute['all'] ) DiviMenusHelper::set_sub_hover_style($render_slug, $this->props['sub_alignment'], '%%order_class%% .dd-menu-flex-sub', '%%order_class%% .dd-sub-hover .dd-menu-flex-sub, %%order_class%% .dd-sub-hover .dd-item:after', 'all');
				if ( $is_absolute['desktop'] ) DiviMenusHelper::set_sub_hover_style($render_slug, $this->props['sub_alignment'], '%%order_class%% .dd-menu-flex-sub', '%%order_class%% .dd-sub-hover .dd-menu-flex-sub, %%order_class%% .dd-sub-hover .dd-item:after', 'd');
				if ( $is_absolute['tablet'] ) DiviMenusHelper::set_sub_hover_style($render_slug, $this->props['sub_alignment'], '%%order_class%% .dd-menu-flex-sub', '%%order_class%% .dd-sub-hover.dd-h-t .dd-menu-flex-sub, %%order_class%% .dd-sub-hover.dd-h-t .dd-item:after', 't');
				if ( $is_absolute['phone'] ) DiviMenusHelper::set_sub_hover_style($render_slug, $this->props['sub_alignment'], '%%order_class%% .dd-menu-flex-sub', '%%order_class%% .dd-sub-hover.dd-h-p .dd-menu-flex-sub, %%order_class%% .dd-sub-hover.dd-h-p .dd-item:after', 'p');				
				DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-menu-flex-sub > *', DiviMenusHelper::get_sub_element_css($this->props['sub_alignment']));

				$offset_responsive = et_pb_responsive_options()-> is_responsive_enabled($this->props, 'arrow_offset');
				$offset_values = et_pb_responsive_options()->get_property_values($this->props, 'arrow_offset', $this->props['arrow_offset'], true);
				et_pb_responsive_options()->generate_responsive_css( $offset_values, '%%order_class%% .dd-menu-flex-sub', 'padding-top', $render_slug );
				if ($this->props['sub_arrow'] === 'on') {
					ET_Builder_Element::set_style( $render_slug, array(
						'selector'    => '%%order_class%% .dd-item:after',
						'declaration' => sprintf('content:"";border:0px solid transparent;z-index:100003;%1$s%2$s%3$s',
							DiviMenusHelper::get_sub_css('center', true),
							$this->props['arrow_direction'] === 'downwards' ? 'top:100%;' : '',
							$this->props['arrow_direction'] !== 'downwards' ? sprintf('bottom:-%s;',$offset_values['desktop']) : '')
					) );
					$this->generate_styles(
						array(
							'base_attr_name' => 'arrow_color',
							'selector'       => '%%order_class%% .dd-item:after',
							'css_property'   => $this->props['arrow_direction'] !== 'downwards' ? 'border-bottom-color' : 'border-top-color',
							'render_slug'    => $render_slug,
							'type'           => 'color',
						)
					);
					if ($offset_responsive && $this->props['arrow_direction'] !== 'downwards') {
						DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-item:after', sprintf('bottom:-%s', $offset_values['tablet']), 't');
						DiviMenusHelper::set_style($render_slug, '%%order_class%% .dd-item:after', sprintf('bottom:-%s', $offset_values['phone']), 'p');
					}		
				}
				$sub_width_values = et_pb_responsive_options()->get_property_values($this->props, 'sub_width');
				et_pb_responsive_options()->generate_responsive_css( $sub_width_values, '%%order_class%% .dd-mi .dd-menu-flex-sub > *', 'width', $render_slug );
			}
		}
		$mi_uniqid = uniqid().rand(1,999);
		$menu_item_attrs = DiviMenusHelper::get_menu_item_attrs($this, 'popup', $sub, $show, $mi_uniqid);
		$menu_item = $this->props['disable_item'] === 'on' ? $menu_item_content : sprintf('<a href="%2$s"%3$s>%1$s</a>', $menu_item_content, $url, $menu_item_attrs);
			
		$this->remove_classname( array( 'et_pb_module') );

		$cdm_responsive = et_pb_responsive_options()-> is_responsive_enabled($this->props, 'close_dm');
		$cdm_values = et_pb_responsive_options()->get_property_values($this->props, 'close_dm', $this->props['close_dm'], true);
		$mi_classes []= DiviMenusHelper::get_responsive_classnames($cdm_values, $cdm_responsive, 'dd-c', 'on' );
		
		return sprintf('<div class="dd-mi-w dd-menu-flex-item-wrapper"><div class="%3$s">%1$s%2$s</div>%4$s%5$s</div>',
			apply_filters('dd_menu_item', $menu_item, $this->props),
			$menu_sub_item,
			implode( ' ', $mi_classes ),
			apply_filters('dd_menu_item_after', $this->props['link_type'] === 'popup' && DiviMenusHelper::is_post($this->props['divi_layout'], 'et_pb_layout') ? DiviMenusHelper::render_popup($this, $render_slug, $this->props['divi_layout'], $mi_uniqid) : '', $this->props),
			$show && $this->props['show_visible'] !== 'on' ? sprintf('<style type="text/css">%s{display:none;}</style>', DiviMenusHelper::get_show_selector(esc_html($this->props['element_id']), esc_html($this->props['element_class']))) : ''
		);			
	}
	
	public function multi_view_filter_value( $raw_value, $args, $multi_view ) {
		$name = isset( $args['name'] ) ? $args['name'] : '';

		if ( $raw_value && 'popup_close_font_icon' === $name && function_exists('et_pb_extended_process_font_icon')) {			
			return et_pb_extended_process_font_icon( $raw_value );
		}
		else if ( $raw_value && 'popup_close_font_icon' === $name )
			return html_entity_decode( et_pb_process_font_icon( $raw_value ) );

		return $raw_value;
	}

	public function get_rel_values() {
		return array( 'bookmark', 'external', 'nofollow', 'noreferrer', 'noopener', 'sponsored' );
	}

	public function nav_menu_link_attrs( $classes, $item, $args ) {
		if (empty($classes['href'])) $classes['href'] = '#';
		if (isset($args->li_collapse_class) && in_array('menu-item-has-children', $item->classes) && $classes['href'] === '#')
			$classes['class'] = $args->link_collapse_class;
		else if ( isset($args->link_class) )
		  	$classes['class'] = $args->link_class;
		return $classes;
	}

	public function nav_menu_css_class( $classes, $item, $args ) {
		if ( isset($args->li_collapse_class) && in_array('menu-item-has-children', $classes) )
			$classes[] = $args->li_collapse_class;		
	
		return $classes;
	}
}

new DiviMenusFlex_Item_Module;