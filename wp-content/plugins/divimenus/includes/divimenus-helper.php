<?php if ( ! defined( 'ABSPATH' ) ) exit;

class DiviMenusHelper {

	public static $post_options = array();

	public static function get_alignment($selector, $main_axis, $cross_axis, $direction, $reverse) {
		if ( ($selector === 'justify' && $direction !== 'column') || ($selector === 'align' && $direction === 'column')) {
			switch ($main_axis) {
				case 'left':
				case 'top':
				case 'force_left': return $direction === 'column' ? 'flex-start' : ( $reverse ? 'flex-end' : 'flex-start' );
				case 'justified': return $direction === 'column' ? 'center' : 'space-between';
				case 'bottom':
				case 'right': return $direction === 'column' ? 'flex-end' : ( $reverse ? 'flex-start' : 'flex-end' );
				default:
				return 'center';
			} 
		} 
		if ($selector === 'align' && $direction !=='column')
			return $cross_axis;
		return 'center';
	}

	public static function get_alt_field( $depends_on, $depends_show_if, $label ) {
		$alt = array( 
			'label' 		=> esc_html__( $label, 'divimenus' ),
			'description'  	=> esc_html__( 'This defines the HTML ALT text. A short description of your image can be placed here.', 'et_builder' ),
			'type'         	=> 'text',
			'tab_slug'     	=> 'custom_css',
			'toggle_slug'  	=> 'attributes'
		);
		if ($depends_on !== '') $alt['show_if'] = array( $depends_on => $depends_show_if );
		return $alt;
	}

	public static function get_background_padding($props, $itemsc) {
		$bg_values = et_pb_responsive_options()-> get_property_values($props, 'background_padding', $props['background_padding'], true);
		return array(
			'desktop' => self::has_background($props) && !empty($itemsc['desktop']) ? self::get_value($bg_values['desktop']) :  0,
			'tablet' => self::has_background($props) && !empty($itemsc['tablet']) ? self::get_value($bg_values['tablet']) :  0,
			'phone' => self::has_background($props) && !empty($itemsc['phone']) ? self::get_value($bg_values['phone']) :  0,
		);
	}

	public static function get_cart_fields() {
		return array(
			'is_cart' => array(
				'label'             => esc_html__( 'Is Shopping Cart', 'divimenus' ),
				'type'            	=> 'yes_no_button',
				'options'         	=> self::get_yes_no_button_options(),
				'default'			=> 'off',
				'affects'			=> array('cart_provider', 'cart_items_count'),
				'show_if'			=> array('menu_item_content' => array('icon', 'image')),
				'toggle_slug'       => 'cart',			
			),
			'cart_provider' => array(
				'label'           	=> esc_html__( 'eCommerce Platform', 'divimenus' ),
				'type'            	=> 'select',
				'options'         	=> array(
					'wc' 	=> esc_html( 'WooCommerce' ),
					'edd'  	=> esc_html( 'Easy Digital Downloads' ),
				),
				'default'  			=> 'wc',
				'depends_show_if'	=> 'on',
				'toggle_slug'     	=> 'cart',
			),
			'cart_items_count' => array(
				'label'             => esc_html__( 'Show Item Count', 'divimenus' ),
				'type'            	=> 'yes_no_button',
				'options'         	=> self::get_yes_no_button_options(),
				'default'			=> 'off',
				'affects'			=> array('cart_items_empty', 'cart_background_color', 'cart_font', 'cart_text_color', 'cart_font_size'),
				'depends_show_if'	=> 'on',
				'toggle_slug'       => 'cart',			
			),
			'cart_items_empty' => array(
				'label'             => esc_html__( 'Show Zero Value', 'divimenus' ),
				'type'            	=> 'yes_no_button',
				'options'         	=> self::get_yes_no_button_options(),
				'default'			=> 'on',
				'depends_show_if'	=> 'on',
				'toggle_slug'       => 'cart',			
			),
			'cart_background_color' => array(
				'label'             => esc_html__( 'Cart Info Background', 'divimenus' ),
				'type'              => 'color-alpha',
				'default' 			=> '#ef5555',
				'depends_show_if'	=> 'on',
				'hover'				=> 'tabs',
				'sticky'			=> true,
				'mobile_options'	=> true,
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'cart',			
			),
		);
	}

	public static function get_char_width($font) {
		switch ($font) {
			case 'Rubik Mono One':
				return 0.863;
			case 'Overpass Mono':
				return 0.616;
			case 'Space Mono':
				return 0.6125;
			case 'Fira Mono':
			case 'PT Mono':
			case 'Source Code Pro':			
				return 0.6; 			  
			case 'Nova Mono':
				return 0.56; 
			case 'Anonymous Pro':
				return 0.545; 
			case 'Share Tech Mono':
				return 0.54;
			case 'Inconsolata':
			case 'Nanum Gothic Coding':
			case 'Ubuntu Mono':
				return 0.5; 
			default: 
				return 0.601;      
		}  		  
	}

	public static function get_description($url){
		return sprintf('%2$s <a href="%1$s" target="_blank">%3$s</a>.', esc_url( $url ), esc_html__( 'Learn more about this field in the', 'divimenus' ), esc_html__( 'documentation', 'divimenus' ));
	}

	public static function get_effect_options() {
		return array(
			'none' 			=> esc_html__('-- None --', 'divimenus'),
			'fade'			=> esc_html__('Fade', 'et_builder'),
			'slidedown' 	=> esc_html__('Slide Down', 'et_builder'),
			'slideup' 		=> esc_html__('Slide Up', 'et_builder'),
			'slideleft' 	=> esc_html__('Slide Left', 'et_builder'),
			'slideright' 	=> esc_html__('Slide Right', 'et_builder'),
		);
	}
	public static function get_effect_fields($popup) {
		return array(
			'effect_in' => array(
				'label'        	=> esc_html__( 'Enter Effect', 'divimenus' ),
				'description'   => self::get_description('https://dondivi.com/documentation/divimenus-custom-effects/#effects'),
				'type'         	=> 'select',
				'options'       => self::get_effect_options(),
				'default'		=> 'none',
				'show_if'		=> array('link_type' => array($popup, 'show', 'sub')),
				'tab_slug'		=> 'advanced',
				'toggle_slug'  	=> 'item_link',			
			),
			'effect_out' => array(
				'label'        	=> esc_html__( 'Exit Effect', 'divimenus' ),
				'description'   => self::get_description('https://dondivi.com/documentation/divimenus-custom-effects/#effects'),
				'type'        	=> 'select',
				'options'       => self::get_effect_options(),
				'default'		=> 'none',
				'show_if'		=> array('link_type' => array($popup, 'show', 'sub')),
				'tab_slug'		=> 'advanced',
				'toggle_slug'  	=> 'item_link',				
			),
			'effect_ms' => array(
				'label'         => esc_html__( 'Duration', 'divimenus' ),
				'description'   => self::get_description('https://dondivi.com/documentation/divimenus-custom-effects/#effects'),
				'type'          => 'range',
				'default'       => '1000ms',
				'show_if'		=> array('link_type' => array($popup, 'show', 'sub')),
				'default_unit'  => 'ms',
				'tab_slug'		=> 'advanced',
				'toggle_slug'   => 'item_link',				
			),
		);
	}
	public static function get_link_fields($default_link_type, $rel_values) {
		return array(
			'url' => array(
				'label'           	=> esc_html__( 'URL', 'divimenus' ),
				'description'     	=> esc_html__( 'Enter your destination URL here.', 'divimenus' ),
				'type'            	=> 'text',
				'toggle_slug'     	=> 'item_link',
				'dynamic_content' 	=> 'url',				
			),
			'url_new_window' => array(
				'label'           	=> esc_html__( 'URL Opens', 'divimenus' ),
				'description'     	=> esc_html__( 'Here you can choose whether or not your link opens in a new window', 'et_builder' ),
				'type'            	=> 'select',
				'options'         	=> array(
					'off' => esc_html__( 'In The Same Window', 'et_builder' ),
					'on'  => esc_html__( 'In The New Tab', 'et_builder' ),
				),
				'default'  			=> 'off',
				'toggle_slug'     	=> 'item_link',
			),	
			'active_url' => array(
				'label'           	=> esc_html__( 'Enable Active State', 'divimenus' ),
				'description'     	=> esc_html__( 'Here you can choose whether or not this menu item should be on hover state when the link URL matches the page URL', 'divimenus' ),
				'type'            	=> 'yes_no_button',
				'options'         	=> self::get_yes_no_button_options(),
				'default'  			=> 'off',
				'toggle_slug'     	=> 'item_link',
			),
			'close_dm' => array(
				'label'       		=> esc_html__( 'Close DiviMenu On Click', 'divimenus' ),
				'description'		=> esc_html__( 'Enable this option if you want to close the DiviMenu when clicking on this Menu Item'),
				'type'          	=> 'yes_no_button',
				'options'      		=> self::get_yes_no_button_options(),
				'default'			=> 'off',
				'mobile_options'	=> true,
				'toggle_slug'   	=> 'item_link',			
			),
			'link_type' => array (
				'label'  		=> esc_html__( 'Link Type', 'divimenus' ),
				'type'     		=> 'select',
				'options'  		=> array(
					'url' 	=> esc_html__( 'URL', 'divimenus' ),
				),
				'default'  		=> $default_link_type,
				'toggle_slug'   => 'item_link',
			),
			'link_rel'  => array(
				'label'           => esc_html__( 'Link Relationship', 'et_builder' ),
				'type'            => 'multiple_checkboxes',
				'options'         => $rel_values,
				'description'     => et_get_safe_localization( __( "Specify the value of your link's <em>rel</em> attribute. The <em>rel</em> attribute specifies the relationship between the current document and the linked document.<br><strong>Tip:</strong> Search engines can use this attribute to get more information about a link.", 'et_builder' ) ),
				'tab_slug'        => 'custom_css',
				'toggle_slug'     => 'attributes',
			),
		);
	}

	public static function get_content_alignment_css($alignment, $use_icon, $icon_pos) {
		$vertical = $use_icon === 'on' && ( $icon_pos === 'top' || $icon_pos === 'bottom');
		$reverse = $use_icon === 'on' && ( $icon_pos === 'right' || $icon_pos === 'bottom');
		return sprintf('justify-content:%1$s;align-items:%2$s;',
			self::get_alignment('justify', $alignment, 'center', $vertical ? 'column' : 'row', $reverse),
			self::get_alignment('align', $alignment, 'center', $vertical ? 'column' : 'row', $reverse));
	}

	public static function get_direction($pos) {
		return $pos === 'left' || $pos === 'right' ? 'row' : 'column';
	}

	public static function get_divi_layout( $args = array() ) {
		global $et_pb_rendering_column_content;
		
		$defaults = array(
			'internal' => true
		);
		$args = wp_parse_args( $args, $defaults );

		if ( !self::is_post($args['sub_layout'], 'et_pb_layout') ) {
			return '';
		}
		
		if ( $args['internal'] ) $et_pb_rendering_column_content = true;
		//ET_Builder_Element::clean_internal_modules_styles();
		 
		$rendered_layout = do_shortcode( get_the_content( null, false, $args['sub_layout'] ) );
		
		if ($args['internal']) {
			$rendered_layout .= '<style class="dd-layout-style"> ' . et_core_esc_previously( ET_Builder_Element::get_style() ) . ' </style>';
			$et_pb_rendering_column_content = false;
		}
		//ET_Builder_Element::clean_internal_modules_styles( false );

		return $rendered_layout;
	}

	public static function get_flex_css($dir, $hali, $vali, $pos) {
		return sprintf('flex-direction: %1$s; justify-content: %2$s; align-items: %3$s;',
			self::get_flex_dir($dir, $pos),
			self::get_alignment('justify', $hali, $vali, $dir, $pos === 'right' || $pos === 'last'),
			self::get_alignment('align', $hali, $vali, $dir, $pos === 'right' || $pos === 'last')
		);
	}

	public static function get_flex_dir($direction, $placement) {
		if ($placement === 'first' || $placement === 'left')
		  	return $direction;
		else if ($placement === 'top')
			return 'column'; 
		else if ($placement !== 'bottom' && $direction !== 'column')
		  return 'row-reverse';
		else return 'column-reverse';
	}

	public static function get_fonts() {
		return array(
			'Anonymous Pro' 		=> esc_html( 'Anonymous Pro' ),
			'Cousine' 				=> esc_html( 'Cousine' ),
			'Fira Mono' 			=> esc_html( 'Fira Mono' ),
			'Inconsolata' 			=> esc_html( 'Inconsolata' ),
			'Nanum Gothic Coding'	=> esc_html( 'Nanum Gothic Coding' ),
			'Nova Mono' 			=> esc_html( 'Nova Mono' ),
			'Overpass Mono' 		=> esc_html( 'Overpass Mono' ),
			'Oxygen Mono' 			=> esc_html( 'Oxygen Mono' ),
			'PT Mono' 				=> esc_html( 'PT Mono' ),
			'Roboto Mono' 			=> esc_html( 'Roboto Mono' ),
			'Rubik Mono One' 		=> esc_html( 'Rubik Mono One' ),
			'Share Tech Mono' 		=> esc_html( 'Share Tech Mono' ),
			'Space Mono' 			=> esc_html( 'Space Mono' ),
			'Source Code Pro' 		=> esc_html( 'Source Code Pro' ),
			'Ubuntu Mono' 			=> esc_html( 'Ubuntu Mono' ),
		);
	}

	public static function get_hover_click_field( $toggle_slug ) {
		return array(
			'label'        	=> esc_html__( 'Apply Hover Options', 'divimenus' ),
			'description'	=> esc_html__( 'Here you can choose whether the hover content and styles should only be applied when clicking.', 'divimenus' ),
			'type'         	=> 'select',
			'options'      	=> array(
				'hover'  => esc_html__( 'On Hover (Divi default)', 'divimenus' ),
				'click'  => esc_html__( 'On Click', 'divimenus' )
			),	
			'toggle_slug'  	=> $toggle_slug,
		);
	}

	public static function get_image_alt($props, $image_field, $alt_field) {
		$alt = $alt_field !== '' ? $props[$alt_field] : ''; 
		if ( empty( $alt ) && ! empty( $props[$image_field] )) {
			$image_id  = attachment_url_to_postid( esc_url( $props[$image_field] ) );
			$alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
		}
		return $alt;
	}

    public static function get_image_height($image, $image_width, $ratio) {
		$postid = attachment_url_to_postid($image);
		if ($postid && $ratio !== 'square') { // media library images
			$image_array = wp_get_attachment_image_src($postid, 'full'); // uses getimagesize
			if ($image_array[1])
				return ($image_array[2] * $image_width) / $image_array[1];
		} else {
			$image_array = @getimagesize($image); // other images
			if ($image_array && $ratio !== 'square' && $image_array[0]) 
				return ($image_array[1] * $image_width) / $image_array[0];
		}
		return $image_width;
	}

	public static function get_items_array($items) {
		return array(
			'desktop' => array_values(array_filter($items, function($item) { return !$item['hide_desktop']; })),
			'tablet' => array_values(array_filter($items, function($item) { return !$item['hide_tablet']; })),
			'phone' => array_values(array_filter($items, function($item) { return !$item['hide_phone']; })),
		);
	}

	public static function get_items_count($items) {
		return array(
			'desktop' => count($items['desktop']),
			'tablet' => count($items['tablet']),
			'phone' => count($items['phone'])
		);
	}

	public static function get_items_width($items, $menu_type, $device) {
		$total_width = 0;
		foreach ($items as $item) {
			if ($device === 'desktop') 			
				$total_width += ($menu_type === 'vertical' ? $item['size']['height'] : $item['size']['width']);
			if ($device === 'tablet') 			
				$total_width += ($menu_type === 'vertical' ? $item['size_t']['height'] : $item['size_t']['width']);
			if ($device === 'phone') 			
				$total_width += ($menu_type === 'vertical' ? $item['size_p']['height'] : $item['size_p']['width']);
		}
		return $total_width;
	}

    public static function get_menu_button_content_size( $type, $device, $props) {
		$width = $height = 0;
		if ($type === 'central_item_image_option') {
			$width_responsive = et_pb_responsive_options()-> is_responsive_enabled($props, 'central_item_image_size');
			$width_values = et_pb_responsive_options()-> get_property_values($props, 'central_item_image_size', $props['central_item_image_size'], true);
			switch ($device) {
				case 'tablet': 
					$width = self::get_value($width_values['tablet']);
					$height = self::get_value($props['central_item_image_height_t'], $width); break;		
				case 'phone':
					$width = self::get_value($width_values['phone']);
					$height = self::get_value($props['central_item_image_height_p'], $width); break;
				default:
					$width = self::get_value($width_values['desktop']);
					$height = self::get_value($props['central_item_image_height'], $width);
			}
        } else {
			if ($type === 'central_item_icon_option')
				$font_size = et_pb_responsive_options()-> get_property_values($props, 'central_item_icon_font_size', $props['central_item_icon_font_size'], true);
			else $font_size = et_pb_responsive_options()-> get_property_values($props, 'central_item_font_size', $props['central_item_font_size'], true);
			switch ($device) {
				case 'tablet': 
					$width = $height = self::get_value($font_size['tablet']); break;		
				case 'phone':
					$width = $height = self::get_value($font_size['phone']); break;
				default:
					$width = $height = self::get_value($font_size['desktop']);
			}
		}
        return array(
			'width' => $width,
			'height' => $height,
		);
    }
    
    public static function get_menu_button_padding($props, $text, $font, $content_size, $padding) {
		$padding_tb = $padding_lr = 0;
		if ( 'on' === $props['central_item_use_circle'] ) {
			$padding_tb = $padding_lr = $padding; 
			
			if ($props['central_item_select'] === 'central_item_text_option') { 
				$padding_lr = ceil($content_size['width'] * strlen(utf8_decode($text)) * self::get_char_width($font)) + ($padding * 2);
				$padding_tb = $props['central_item_fit_bg'] === 'on' ? $content_size['width'] + ($padding * 2) : $padding_lr;
				if (strlen(utf8_decode($text)) === 1 ) {
					$padding_lr = $padding_tb = ceil($content_size['width'] * strlen(utf8_decode($text))) + ($padding * 2); 
				} 
			}
        } else if ($props['central_item_select'] === 'central_item_text_option') {
			$padding_lr = $content_size['width'] * strlen(utf8_decode($text)) * self::get_char_width($font);
			$padding_tb = $content_size['height'];
		}
        return array(
			'TB' => $padding_tb,
			'LR' => $padding_lr
		);
	}

	public static function get_menu_button_size($props, $content_size, $padding, $border_size) {		
		$width = (int)$content_size['width'] + ( 'on' === $props['central_item_use_circle']  ? ((int)$padding['LR'] * 2) : 0);
		$height = (int)$content_size['height'] + ( 'on' === $props['central_item_use_circle']  ? ((int)$padding['TB'] * 2) : 0); 
		
		if ( $props['central_item_select'] === 'central_item_text_option' ) {
			$width = (int)$padding['LR'];
			$height = (int)$padding['TB'];
		}
		if ( 'on' === $props['central_item_use_circle'] && 'on' === $props['central_item_use_circle_border'] ) {
			$width +=  is_numeric(rtrim($border_size, 'px')) ? rtrim($border_size, 'px') * 2 : 2 * 2;
			$height += is_numeric(rtrim($border_size, 'px')) ? rtrim($border_size, 'px') * 2 : 2 * 2;
		}
		return array(
			'width' => $width,
			'height' => $height,
			'circular' => max($width, $height)
		);
	}

	public static function get_largest_item_size($items, $device) {
		$width = $height = 0;
		foreach ($items as $item) {		
			if ($device === 'desktop' && $item['size']['width'] > $width)
				$width = $item['size']['width']; 
			else if ($device === 'tablet' && $item['size_t']['width'] > $width)
				$width = $item['size_t']['width'];
			else if ($device === 'phone' && $item['size_p']['width'] > $width)
				$width = $item['size_p']['width'];		
			if ($device === 'desktop' && $item['size']['height'] > $height)
				$height = $item['size']['height']; 
			else if ($device === 'tablet' && $item['size_t']['height'] > $height)
				$height = $item['size_t']['height'];
			else if ($device === 'phone' && $item['size_p']['height'] > $height)
				$height = $item['size_p']['height'];		
		}
		return array(
			'width' => $width,
			'height'=> $height
		);
	}

	public static function get_largest_menu_size($mb_size, $item_size) {
		return array(
			'width' => max($mb_size['width'], $item_size['width']),
			'height' => max($mb_size['height'], $item_size['height']) 
		);
	}

	public static function get_largest_padding($items, $device) {
		$lr = $tb = 0;
		foreach ($items as $item) {		
			if ($device === 'desktop' && !$item['hide_desktop'] && $item['padding']['LR'] > $lr) {
				$lr = $item['padding']['LR'];
			} else if ($device === 'tablet' && !$item['hide_tablet'] && $item['padding_t']['LR'] > $lr) {
				$lr = $item['padding_t']['LR'];
			} else if ($device === 'phone' && !$item['hide_phone'] && $item['padding_p']['LR'] > $lr) {
				$lr = $item['padding_p']['LR'];
			}
			if ($device === 'desktop' && !$item['hide_desktop'] && $item['padding']['TB'] > $tb) {
				$tb = $item['padding']['TB'];
			} else if ($device === 'tablet' && !$item['hide_tablet'] && $item['padding_t']['TB'] > $tb) {
				$tb = $item['padding_t']['TB'];
			} else if ($device === 'phone' && !$item['hide_phone'] && $item['padding_p']['TB'] > $tb) {
				$tb = $item['padding_p']['TB'];
			}
		}
		return array(
			'TB' => $tb,
			'LR' => $lr
		);
	}

	public static function get_largest_border_item($items, $device = 'desktop') {
		if (isset($items) && count($items) > 0) { 
			switch ($device) {
				case 'tablet':
					return max($items[0]['size_t']['width'], $items[count($items)-1]['size_t']['width']);
				case 'phone':
					return max($items[0]['size_p']['width'], $items[count($items)-1]['size_p']['width']); 
				default:
					return max($items[0]['size']['width'], $items[count($items)-1]['size']['width']);
			}
		}
		return 0;
	}

	public static function get_largest_opposite_items_width($items, $device) { 
		$diameter['total'] = 0;
		if (isset($items)) {
			$items_count = count($items);
			for ($i=0; $i < $items_count; $i++) {
				$item_1_angle = 360 / $items_count * $i;
				if ($item_1_angle > 0 && $item_1_angle < 180) { 
					for ($j=0; $j < $items_count; $j++) {
						$item_2_angle = 360 / $items_count * $j;
						if ($item_2_angle > 180 && $item_2_angle < 360) {						
							if ($device === 'desktop' && $items[$i]['size']['width'] + $items[$j]['size']['width'] > $diameter['total']) {
								$diameter['total'] = $items[$i]['size']['width'] + $items[$j]['size']['width'];
								$diameter['item1'] = max($items[$i]['size']['width'], $items[$j]['size']['width']);
								$diameter['item2'] = min($items[$i]['size']['width'], $items[$j]['size']['width']);
							} else if ($device === 'tablet' && $items[$i]['size_t']['width'] + $items[$j]['size_t']['width'] > $diameter['total']) {
								$diameter['total'] = $items[$i]['size_t']['width'] + $items[$j]['size_t']['width'];
								$diameter['item1'] = max($items[$i]['size_t']['width'], $items[$j]['size_t']['width']);
								$diameter['item2'] = min($items[$i]['size_t']['width'], $items[$j]['size_t']['width']);
							} else if ($device === 'phone' && $items[$i]['size_p']['width'] + $items[$j]['size_p']['width'] > $diameter['total']) {
								$diameter['total'] = $items[$i]['size_p']['width'] + $items[$j]['size_p']['width'];
								$diameter['item1'] = max($items[$i]['size_p']['width'], $items[$j]['size_p']['width']);
								$diameter['item2'] = min($items[$i]['size_p']['width'], $items[$j]['size_p']['width']);
							}
						}
					}
				}				
			}
			for ($i=0; $i < $items_count; $i++) {
				$item_1_angle = 360 / $items_count * $i;
				if ($item_1_angle === 0) { 
					for ($j=0; $j < $items_count; $j++) {
						$item_2_angle = 360 / $items_count * $j;
						if ($item_2_angle > 90 && $item_2_angle < 270) {						
							if ($device === 'desktop' && $items[$i]['size']['width'] + $items[$j]['size']['width'] > $diameter['total']) {
								$diameter['total'] = $items[$i]['size']['width'] + $items[$j]['size']['width'];
								$diameter['item1'] = max($items[$i]['size']['width'], $items[$j]['size']['width']);
								$diameter['item2'] = min($items[$i]['size']['width'], $items[$j]['size']['width']);
							} else if ($device === 'tablet' && $items[$i]['size_t']['width'] + $items[$j]['size_t']['width'] > $diameter['total']) {
								$diameter['total'] = $items[$i]['size_t']['width'] + $items[$j]['size_t']['width'];
								$diameter['item1'] = max($items[$i]['size_t']['width'], $items[$j]['size_t']['width']);
								$diameter['item2'] = min($items[$i]['size_t']['width'], $items[$j]['size_t']['width']);
							} else if ($device === 'phone' && $items[$i]['size_p']['width'] + $items[$j]['size_p']['width'] > $diameter['total']) {
								$diameter['total'] = $items[$i]['size_p']['width'] + $items[$j]['size_p']['width'];
								$diameter['item1'] = max($items[$i]['size_p']['width'], $items[$j]['size_p']['width']);
								$diameter['item2'] = min($items[$i]['size_p']['width'], $items[$j]['size_p']['width']);
							}
						}
					}
				}				
			}
		}
		return $diameter;
	}

	public static function get_location_options() {
		return array(
			'top_left'      => esc_html__( 'Top Left', 'et_builder' ),
			'top_center'    => esc_html__( 'Top Center', 'et_builder' ),
			'top_right'     => esc_html__( 'Top Right', 'et_builder' ),
			'center_left'   => esc_html__( 'Center Left', 'et_builder' ),
			'center'        => esc_html__( 'Center', 'et_builder' ),
			'center_right'  => esc_html__( 'Center Right', 'et_builder' ),
			'bottom_left'   => esc_html__( 'Bottom Left', 'et_builder' ),
			'bottom_center' => esc_html__( 'Bottom Center', 'et_builder' ),
			'bottom_right'  => esc_html__( 'Bottom Right', 'et_builder' ),
		);
	}

	public static function get_logo_fields() {
		$logo_fields = array (
			'logo' => array(
				'label'             => esc_html__( 'Logo', 'et_builder' ),
				'description'       => esc_html__( 'Upload an image to display beside your menu.', 'et_builder' ),
				'type'              => 'upload',
				'upload_button_text'=> esc_attr__( 'Upload an image', 'et_builder' ),
				'choose_text'       => esc_attr__( 'Choose an Image', 'et_builder' ),
				'update_text'       => esc_attr__( 'Set As Logo', 'et_builder' ),
				'dynamic_content'   => 'image',
				'hover'            	=> 'tabs',
				'mobile_options'	=> true,
				'sticky'			=> true,
				'toggle_slug'       => 'logo',
			),
			'logo_url' => array(
				'label'  			=> esc_html__( 'Logo Link URL', 'et_builder' ),
				'description'     	=> esc_html__( 'If you would like to make your logo a link, input your destination URL here.', 'et_builder' ),
				'type'            	=> 'text',				
				'toggle_slug'     	=> 'logo',
				'dynamic_content' 	=> 'url',
			),
			'logo_url_new_window' => array(
				'label'            	=> esc_html__( 'URL Opens', 'divimenus' ),
				'description'      	=> esc_html__( 'Here you can choose whether or not your link opens in a new window', 'et_builder' ),
				'type'             	=> 'select',
				'option_category'  	=> 'configuration',
				'options'          	=> array(
					'off' => esc_html__( 'In The Same Window', 'et_builder' ),
					'on'  => esc_html__( 'In The New Tab', 'et_builder' ),
				),
				'toggle_slug'      	=> 'logo',
				'default' 			=> 'off',
			),
			'logo_pos' => array(
				'label'             => esc_html__( 'Placement', 'divimenus' ),
				'type'            	=> 'select',
				'options'         	=> self::get_positions(false),
				'default'			=> 'left',
				'mobile_options'	=> true,
				'tab_slug'        	=> 'advanced',
				'toggle_slug'     	=> 'logo',							
			),
			'logo_alignment' => array(
				'label'           	=> esc_html__( 'Horizontal Alignment', 'divimenus' ),
				'type'            	=> 'text_align',
				'options'         	=> et_builder_get_text_orientation_options( array( 'justified' ) ),
				'options_icon'    	=> 'module_align',
				'default'			=> 'left',
				'mobile_options'	=> true,
				'tab_slug'        	=> 'advanced',
				'toggle_slug'     	=> 'logo',
			),	
			'logo_ca_alignment' => array( 
				'label'           	=> esc_html__( 'Vertical Alignment', 'divimenus' ),
				'type'            	=> 'select',
				'options'         	=> array('flex-start' => esc_html__( 'Top', 'divimenus' ), 'center' => esc_html__( 'Middle', 'divimenus' ), 'flex-end' => esc_html__( 'Bottom', 'divimenus' )),
				'options_icon'    	=> 'module_align',
				'default'			=> 'flex-start',
				'mobile_options'	=> true,
				'tab_slug'        	=> 'advanced',
				'toggle_slug'     	=> 'logo',
			),
			'logo_width' => array(
				'label'           => esc_html__( 'Logo Width', 'et_builder' ),
				'type'            => 'range',
				'allowed_values'  => et_builder_get_acceptable_css_string_values( 'width' ),
				'default'         => '150px',
				'default_unit'    => 'px',
				'mobile_options'  => true,
				'hover'           => 'tabs',
				'sticky'          => true,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'logo',
			),
			'logo_absolute' => array(
				'label'				=> esc_html__( 'Absolute Position', 'divimenus' ),
				'type'            		=> 'yes_no_button',
				'options'         		=> self::get_yes_no_button_options(),
				'description'      	=> sprintf('%2$s. <a href="%1$s" target="_blank">%3$s</a>.',
					esc_url( 'https://dondivi.com/documentation/divimenus-flex-doc/#logo' ), 
					esc_html__( 'Enable this option if you want the DiviMenu to take up all the available space. Useful for mobile menus', 'divimenus' ), 
					esc_html__( 'Learn more here', 'divimenus' )),
				'default'			=> 'off',
				'mobile_options'  => true,
				'tab_slug'        	=> 'advanced',
				'toggle_slug'     	=> 'logo',
			),
			'logo_margin' => array(
				'label'           	=> esc_html__( 'Logo Margin', 'divimenus' ),
				'type'            	=> 'custom_padding',
				'fixed_unit'     	=> 'px',
				'mobile_options'  	=> true,
				'sticky'			=> true,
				'tab_slug'       	=> 'advanced',
				'toggle_slug'     	=> 'margin_padding',					
			),
		);
		$logo_fields['logo_alt'] = self::get_alt_field( '', '', 'Logo Alt Text' );
 		return $logo_fields;
	}

	public static function get_margin_selector($direction, $mb_pos) {
		if ($direction !== 'column')
		  return $mb_pos !== 'last' ? 'margin-left' : 'margin-right'; 
		else
		  return $mb_pos !== 'last' ? 'margin-top' : 'margin-bottom';  
	}

	public static function get_menu_item_attrs($module, $popup_name, $sub, $show, $popup_css_id) {
		$attrs = array('tabindex="-1"');
		$classes = array(); 
		if (self::is_cart($module->props)) $classes []= 'dd-cart';
		if ($module->props['link_type'] === $popup_name || $module->props['link_type'] === 'show' || $module->props['link_type'] === 'sub') {
			$effect_in = $module->props['effect_in'] !== 'none';
			$effect_out = $module->props['effect_out'] !== 'none';
			if ( $effect_in ) $attrs[] = sprintf('data-effect-in="%s"', esc_attr($module->props['effect_in']));
			if ( $effect_out ) $attrs[] = sprintf('data-effect-out="%s"', esc_attr($module->props['effect_out']));	
			if ( $effect_in || $effect_out ) $attrs[] = sprintf('data-effect-ms="%s"', esc_attr(trim($module->props['effect_ms'], 'ms')));
		}
		if ($module->props['link_type'] === $popup_name && self::is_post($module->props['divi_layout'], 'et_pb_layout')) {
			$attrs[]= 'aria-haspopup="true"';
			$attrs[]= sprintf('data-popup-id="%s"', $popup_css_id);
			$classes []= 'dd-modal';
			if ($module->props['popup_hover'] === 'on') $classes[]= 'dd-show-hover';
			if ($module->props['popup_disable_page_scroll'] === 'on') $classes[]= 'dd-disable-page-scroll';
		} else if ($sub) {
			$attrs[] = 'aria-haspopup="true" aria-expanded="false"';
			$classes []= 'dd-sub'; 
			if ($module->props['sub_open_url'] === 'on') $classes[]= 'dd-open-url';
		} else if ($show) {
			$attrs[] = 'aria-haspopup="true"';
			if ($module->props['element_id'] || $module->props['element_class'])
				$attrs[] = sprintf(' data-selector="%s"', esc_attr(self::get_show_selector($module->props['element_id'], $module->props['element_class'])));
			
			$classes []= 'dd-show';  
			if ($module->props['show_close'] === 'on') $classes[]= 'dd-show-close';
			if ($module->props['show_mb_close'] !== 'off') $classes[]= 'dd-show-mb-close';
			if ($module->props['show_hover'] !== 'on' && $module->props['show_toggle'] === 'on') $classes[]='dd-toggle'; 
			if ($module->props['show_hover'] !== 'on' && $module->props['show_always'] === 'on') $classes[]='dd-keep';
			if ($module->props['show_hover'] === 'on') $classes[]= 'dd-show-hover';
			if ($module->props['show_open_url'] === 'on') $classes[]= 'dd-open-url';			
		}
		$attrs []= et_core_esc_previously( $module->get_rel_attributes( $module->props['link_rel'] ) );
		if ( $module->props['url_new_window'] === 'on' ) {
			$attrs []= 'target="_blank"'; 
		}
		return sprintf(' %1$s %2$s', implode( ' ', $attrs ), !empty($classes) ? sprintf('class="%s"', implode( ' ', $classes )) : '');
	}

	public static function get_menu_width_before($menu_type, $items, $items_distance, $central_item_size, $device) {
		$total_size = 0;
		if (isset($items)) {
			for ( $i=0; $i < count($items); $i++ ) {
				if ( $i % 2 !== 0 ) {
					if ($device === 'desktop') 			
						$total_size += ($menu_type === 'horizontal' ? $items[$i]['size']['width'] : $items[$i]['size']['height']) + $items_distance;
					if ($device === 'tablet') 			
						$total_size += ($menu_type === 'horizontal' ? $items[$i]['size_t']['width'] : $items[$i]['size_t']['height']) + $items_distance;
					if ($device === 'phone') 			
						$total_size += ($menu_type === 'horizontal' ? $items[$i]['size_p']['width'] : $items[$i]['size_p']['height']) + $items_distance;
				}
			}
		}
		return $total_size + (($menu_type === 'horizontal' ? $central_item_size['width'] : $central_item_size['height'])/2);
	}

	public static function get_menu_width_after($menu_type, $items, $items_distance, $central_item_size, $device) {
		$total_size = 0;
		if (isset($items)) {
			for ( $i=0; $i< count($items); $i++ ) {			
				if ($i % 2 === 0) {			
					if ($device === 'desktop') 			
						$total_size += ($menu_type === 'horizontal' ? $items[$i]['size']['width'] : $items[$i]['size']['height']) + $items_distance;
					if ($device === 'tablet') 			
						$total_size += ($menu_type === 'horizontal' ? $items[$i]['size_t']['width'] : $items[$i]['size_t']['height']) + $items_distance;
					if ($device === 'phone') 			
						$total_size += ($menu_type === 'horizontal' ? $items[$i]['size_p']['width'] : $items[$i]['size_p']['height']) + $items_distance;
				}
			}
		}
		return $total_size + (($menu_type === 'horizontal' ? $central_item_size['width'] : $central_item_size['height']) /2);
	}

	public static function get_menu_item_content_size($type, $text_size, $icon_size, $image, $image_width, $image_height) {
		$width = $height = 0;
		if ($type === 'icon_option') {
			$width = $height = is_numeric(rtrim($icon_size, 'px')) ? rtrim($icon_size, 'px') : 33; 
		} else if ($type === 'text_option' && isset($text_size)) {
			$width = $height = is_numeric(rtrim($text_size, 'px')) ? rtrim($text_size, 'px') : 15;
		} else if ($type === 'image_option') {
			$width = is_numeric(rtrim($image_width, 'px')) ? rtrim($image_width, 'px') : 57;
			$height = is_numeric(rtrim($image_height, 'px')) ? rtrim($image_height, 'px') : 57; 
		}
		return array(
			'width' => $width,
			'height' => $height
		);
	}

	public static function get_menu_item_padding($props, $text, $font, $content_size, $padding) {	
		global $et_pb_divimenus;
		$padding_lr = $padding_tb = $padding;
		$fit_bg = $et_pb_divimenus['menu_type'] !== 'circular' && (($et_pb_divimenus['menu_item_fit_bg'] === 'on' && $props['item_use_custom'] === 'off') || ($props['item_fit_bg'] === 'on' && $props['item_use_custom'] === 'on'));
		if ($et_pb_divimenus['menu_item_select'] === 'text_option') { 	
			$padding_lr = ceil($content_size['width'] * self::get_char_width($font) * strlen(utf8_decode($text)) ) + ($padding * 2);
			$padding_tb = $fit_bg ? $content_size['width'] + ($padding * 2) : $padding_lr;
			if (strlen(utf8_decode($text)) === 1 ) {
				$padding_lr = $padding_tb = $content_size['width'] + ($padding * 2);  
			} 		
		}
		return array(
			'TB' => $padding_tb,
			'LR' => $padding_lr
		);
	}

	public static function get_menu_item_size($type, $content_size, $padding, $custom, $use_border, $border_size) {
		global $et_pb_divimenus;

		$width = $height = 0;
		if (isset($content_size)) {
			$width =  (int)$content_size['width'] + ((int)$padding['LR'] * 2);
			$height = (int)$content_size['height'] + ((int)$padding['TB'] * 2);
		}

		if ($type === 'text_option') {
			$width = (int)$padding['LR'];
			$height = (int)$padding['TB'];
		}
		
		if (($custom && $use_border) || (!$custom && 'on' === $et_pb_divimenus['use_circle_border'])) {
			$menu_item_border = is_numeric(rtrim($et_pb_divimenus['menu_item_border_size'], 'px')) ? rtrim($et_pb_divimenus['menu_item_border_size'], 'px') : 2;  
			if ($custom) {
				$width +=  DiviMenusHelper::get_value($border_size, 2) * 2;
				$height +=  DiviMenusHelper::get_value($border_size, 2) * 2;  
			} else {
				$width += $menu_item_border * 2;
				$height += $menu_item_border * 2;	
			}
		}
		return array(
			'width' => $width,
			'height' => $height
		);
	}

	public static function get_padding_property($placement) {
		switch ($placement) {
		  case 'top' : return 'padding-bottom';
		  case 'right': return 'padding-left';
		  case 'bottom' : return 'padding-top';  
		  default: return 'padding-right';
		}
	}

	public static function get_popup_fields($toggle_slug, $adv_toggle_slug, $popup_slug) {
		$post_options = self::get_posts_options('et_pb_layout');	
		return array (
			'divi_layout' => array(
				'label'           	=> esc_html__( 'Divi Layout', 'divimenus' ),
				'description'     	=> esc_html__( 'Here you can choose the Divi Library saved layout.', 'divimenus' ),
				'type'            	=> 'select',
				'options'			=> $post_options,
				'default'  			=> key($post_options),
				'show_if' 			=> array('link_type' => $popup_slug),
				'searchable'       	=> true,
				'displayRecent'    	=> false,
				'toggle_slug'     	=> $toggle_slug,				
			),
			'popup_hover' => array(
				'label'         => esc_html__( 'Show On Hover', 'divimenus' ),
				'description'   => esc_html__( 'Here you can choose whether this link type should be triggered on hover as well.', 'divimenus' ),
				'type'          => 'yes_no_button',
				'options'      	=> self::get_yes_no_button_options(),
				'default'		=> 'off',
				'show_if' 		=> array('link_type' => $popup_slug),
				'toggle_slug'   => $toggle_slug,				
			),
			'popup_close' => array(
				'label'       	=> esc_html__( 'Show Close Icon', 'divimenus' ),
				'description' 	=> esc_html__( 'Here can you choose whether or not a close icon should be also used to dismiss the popup.', 'divimenus' ),
				'type'          => 'yes_no_button',
				'options'      	=> self::get_yes_no_button_options(),
				'default'		=> 'off',
				'show_if' 		=> array('link_type' => $popup_slug),
				'toggle_slug'   => $toggle_slug,				
			),
			'popup_close_font_icon' => array(
				'label'        	=> esc_html__( 'Close Icon', 'divimenus' ),
				'type'         	=> 'select_icon',
				'class'         => array( 'et-pb-font-icon' ),
				'default'		=> '%%44%%',
				'show_if' 		=> array('link_type' => $popup_slug, 'popup_close' => 'on'),
				'toggle_slug'  	=> $toggle_slug,
				'hover'			=> 'tabs',				
			),
			'popup_disable_page_scroll' => array(
				'label'       	=> esc_html__( 'Disable Page Scroll', 'divimenus' ),
				'description' 	=> esc_html__( 'Here can you choose whether or not the page scroll should be disabled when the popup is open.', 'divimenus' ),
				'type'          => 'yes_no_button',
				'options'      	=> self::get_yes_no_button_options(),
				'default'		=> 'off',
				'show_if' 		=> array('link_type' => $popup_slug),
				'toggle_slug'   => $toggle_slug,				
			),
			'popup_alignment' => array( 
				'label'        	=> esc_html__( 'Location', 'et_builder' ),
				'type'         	=> 'select',
				'options'       => function_exists( 'et_pb_get_background_position_options' ) ? et_pb_get_background_position_options() : self::get_location_options(),
				'default' 		=> 'center',
				'show_if' 		=> array('link_type' => $popup_slug),
				'tab_slug'      => 'advanced',
				'toggle_slug'   => $adv_toggle_slug,					
			),
			'popup_max_width' => array( 
				'label'       	=> esc_html__( 'Popup Max Width', 'divimenus' ),
				'type'         	=> 'range',
				'default'		=> '80%',				
				'range_settings' => array(
					'min'  => 50,
					'min_limit'  => 50,
					'max'  => 100,
					'step' => 1,
				),	
				'fixed_unit'	=> '%',
				'show_if' 		=> array('link_type' => $popup_slug),
				'tab_slug'     	=> 'advanced',
				'toggle_slug'   => $adv_toggle_slug,				
			),
			'popup_limit' => array(
				'label'       	=> esc_html__( 'Limit Width on Large Screens', 'divimenus' ),
				'description' 	=> esc_html__( 'Here you can choose whether or not the popup width should be limited on screen sizes greater than 1080 pixels.', 'divimenus' ),
				'type'          => 'yes_no_button',
				'options'      	=> self::get_yes_no_button_options(),
				'default'		=> 'on',
				'show_if' 		=> array('link_type' => $popup_slug),
				'tab_slug'      => 'advanced',
				'toggle_slug'   => $adv_toggle_slug,			
			),
			'popup_max_height' => array( 
				'label'        	=> esc_html__( 'Popup Max Height', 'divimenus' ),
				'type'         	=> 'range',
				'default'		=> '80%',				
				'range_settings' => array(
					'min'  =>  50,
					'min_limit'  => 50,
					'max'  => 100,
					'step' => 1,
				),	
				'fixed_unit'	=> '%',
				'show_if' 		=> array('link_type' => $popup_slug),
				'tab_slug'      => 'advanced',
				'toggle_slug'   => $adv_toggle_slug,					
			),
			'overlay_color' => array(
				'label'           	=> esc_html__( 'Overlay Color', 'divimenus' ),
				'type'            	=> 'color-alpha',	
				'default'			=> 'rgba(0,0,0,0.4)',
				'show_if'			=> array( 'link_type' => $popup_slug),
				'tab_slug'        	=> 'advanced',
				'toggle_slug'     	=> $adv_toggle_slug,
			),
			'popup_close_text_color' => array(
				'label'           	=> esc_html__( 'Close Icon Color', 'divimenus' ),
				'type'            	=> 'color-alpha',
				'default'			=> '#666666',	
				'show_if'			=> array('link_type' => $popup_slug, 'popup_close' => 'on'),
				'tab_slug'        	=> 'advanced',
				'toggle_slug'     	=> $adv_toggle_slug,
			),	
			'popup_close_font_size' => array(
				'label'           	=> esc_html__( 'Close Icon Font Size', 'divimenus' ),
				'type'            	=> 'range',			
				'default'  			=> '40px',
				'fixed_unit'		=> 'px',
				'show_if'			=> array('link_type' => $popup_slug, 'popup_close' => 'on'),
				'tab_slug'        	=> 'advanced',
				'toggle_slug'     	=> $adv_toggle_slug,
			),
		);
	}
		
	public static function get_positions($inherit) {
		$positions = array(
			'top' 		=> esc_html__( 'Top', 'divimenus' ),
			'right'  	=> esc_html__( 'Right', 'divimenus' ),
			'bottom'  	=> esc_html__( 'Bottom', 'divimenus' ),
			'left'  	=> esc_html__( 'Left', 'divimenus' ),					
		);
		if ($inherit) $positions = array_merge(array('inherit' 	=> esc_html__( 'Inherited', 'divimenus' )), $positions);
		return $positions;
	}

	public static function get_posts_options($post_type) {
		if (empty(self::$post_options)) {
			$posts = get_posts(array('post_type' => 'et_pb_layout', 'numberposts' => -1)); 
			self::$post_options[] = __('-- Select --', 'divimenus');
			foreach ($posts as $post) {
				if (strpos($post->post_content, 'et_pb_divimenus') !== false || strpos($post->post_content, 'use_divimenu_overlay="on"') !== false )
					continue;		
				self::$post_options[$post->ID] = $post->post_title;		
			}
		}
		return self::$post_options;
	}

	public static function get_responsive_classnames($field_values, $responsive, $base_class, $value) {
		$classes = array();
		if ( !$responsive) {
			if ($field_values['desktop'] === $value)  $classes []= $base_class;
		} else {
			if ($field_values['desktop'] === $value)  $classes []= "$base_class-d";
			if ($field_values['tablet'] === $value)  $classes []= "$base_class-t";
			if ($field_values['phone'] === $value)  $classes []= "$base_class-p";
		}		
		return implode(' ', $classes);
	}

	public static function get_show_fields($toggle_slug) {
		return array(
			'element_id' => array(
				'label'        	=> esc_html__( 'Element CSS ID', 'divimenus' ),
				'description'  	=> esc_html__( 'Here you can enter the CSS ID of the element you want to show. You can also enter multiple CSS IDs separated by commas.', 'divimenus' ),
				'type'         	=> 'text',
				'show_if' 		=> array('link_type' => 'show'),
				'toggle_slug'  	=> $toggle_slug,				
			),
			'element_class' => array(
				'label'        	=> esc_html__( 'Element CSS Class', 'divimenus' ),
				'description'  	=> esc_html__( 'Here you can enter the CSS class of the element(s) you want to show. You can also enter multiple CSS classes separated by commas.', 'divimenus' ),
				'type'         	=> 'text',
				'show_if' 		=> array('link_type' => 'show'),
				'toggle_slug'  	=> $toggle_slug,				
			),
			'show_toggle' => array(
				'label'       	=> esc_html__( 'Toggle Visibility', 'divimenus' ),
				'description' 	=> esc_html__( 'Here you choose whether or not the element should toggle from visible to hidden.', 'divimenus' ),
				'type'          => 'yes_no_button',
				'options'      	=> self::get_yes_no_button_options(),
				'default'		=> 'on',
				'show_if' 		=> array('link_type' => 'show', 'show_hover' => 'off'), 
				'toggle_slug'   => $toggle_slug,				
			),
			'show_always' => array(
				'label'       	=> esc_html__( 'Keep Visible', 'divimenus' ),
				'description' 	=> esc_html__( 'Here you choose whether or not to keep this element visible once displayed.', 'divimenus' ),
				'type'          => 'yes_no_button',
				'options'      	=> self::get_yes_no_button_options(),
				'show_if' 		=> array('link_type' => 'show', 'show_hover' => 'off'),
				'toggle_slug'   => $toggle_slug,				
			),
			'show_hover' => array(
				'label'         => esc_html__( 'Show On Hover', 'divimenus' ),
				'description'   => esc_html__( 'Here you can choose whether this link type should be triggered on hover as well.', 'divimenus' ),
				'type'          => 'yes_no_button',
				'options'      	=> self::get_yes_no_button_options(),
				'default'		=> 'off',
				'show_if' 		=> array('link_type' => 'show'),
				'toggle_slug'   => $toggle_slug,				
			),
			'show_mb_close' => array(
				'label'       	=> esc_html__( 'Hide On Menu Button Click', 'divimenus' ),
				'description' 	=> esc_html__( 'Here you choose whether or not to hide the element when closing the DiviMenu.', 'divimenus' ),
				'type'          => 'yes_no_button',
				'options'      	=> self::get_yes_no_button_options(),
				'default'		=> 'on',
				'show_if' 		=> array('link_type' => 'show'),
				'toggle_slug'   => $toggle_slug,				
			),
			'show_close' => array(
				'label'       	=> esc_html__( 'Hide On Page Click', 'divimenus' ),
				'description' 	=> esc_html__( 'Here you choose whether or not to hide the element by clicking outside.', 'divimenus' ),
				'type'          => 'yes_no_button',
				'options'      	=> self::get_yes_no_button_options(),
				'default'		=> 'off',
				'show_if' 		=> array('link_type' => 'show'),
				'toggle_slug'   => $toggle_slug,				
			),
			'show_visible' => array(
				'label'         => esc_html__( 'Initial State', 'divimenus' ),
				'description'   => esc_html__( 'Choose whether the element should start as visible or not.', 'divimenus' ),
				'type'          => 'select',
				'options'       => array(
					'off' => esc_html__( 'Hidden', 'divimenus' ),
					'on'  => esc_html__( 'Visible', 'divimenus' ),
				),
				'show_if' 		=> array('link_type' => 'show'),
				'toggle_slug'   => $toggle_slug,		
			),
			'show_open_url' => array(
				'label'       	=> esc_html__( 'Open URL', 'divimenus' ),
				'description'   => esc_html__( 'If enabled, the destination URL introduced in the URL field will be opened on Menu Item Click', 'divimenus' ),
				'type'          => 'yes_no_button',
				'options'       => self::get_yes_no_button_options(),
				'default'	    => 'off',		
				'show_if' 		=> array('link_type' => 'show', 'show_hover' => 'on'),
				'toggle_slug'   => $toggle_slug,
			),
		);
	}

	public static function get_show_selector( $ids, $classes ) {
		$selector = array(); 
		if ($ids) {
			$ids = preg_replace('/,\s*$/', '', trim($ids));
			$selector[]= '#' . preg_replace('/,\s*/', ',#', $ids);
		}
		if ($classes) {
			$classes = preg_replace('/,\s*$/', '', trim($classes));
			$selector[]= '.' . preg_replace('/,\s*/', ',.', $classes);
		}
		return implode(',', $selector);
	}

	public static function get_sub_css($alignment, $arrow) {
		$css = 'position: absolute;';
		if ($alignment !== 'justified') {
			if (!$arrow) $css .= 'min-width:100%;'; 
			$css .= $alignment === 'right' ? 'right:0;' : ($alignment === 'left' ? 'left:0;' : 'left:50%;transform:translateX(-50%);');
		}
		return $css;
	}

	public static function get_sub_element_css($alignment) {
		$css = '';
		if ($alignment === 'justified') $css .= 'width:100%;';
		$css .= $alignment === 'right' ? 'margin-left:auto;' : ($alignment === 'left' ? 'margin-right:auto;' : 'margin-left:auto;margin-right:auto;'); 
		return $css;
	}

	public static function get_sub_fields($content_slug, $advanced_slug) {
		$post_options = self::get_posts_options('et_pb_layout');	
		return array(
			'sub_source' => array(
				'label'         	=> esc_html__( 'Sub Source', 'divimenus' ),
				'type'            	=> 'select',
                'options'          	=>  array(
                    'layout' 	=>  esc_html__('Divi Library', 'et_builder'),
                    'menu' 		=>  esc_html__('WordPress Menu', 'divimenus'),
                ),
				'affects' 			=> array('sub_font', 'sub_text_align', 'sub_text_color', 'sub_font_size', 'sub_letter_spacing', 'sub_line_height'),
				'default'           => 'layout',
				'show_if'			=> array('link_type' => 'sub'),
                'toggle_slug'     	=> $content_slug,
			),
			'sub_layout' => array(
				'label'           	=> esc_html__( 'Divi Layout', 'divimenus' ),
				'description'     	=> esc_html__( 'Here you can choose the Divi Library saved layout.', 'divimenus' ),
				'type'            	=> 'select',
				'options'			=> $post_options,
				'show_if' 			=> array('link_type' => 'sub', 'sub_source' => 'layout'),
				'searchable'       	=> true,
				'displayRecent'    	=> false,
				'toggle_slug'     	=> $content_slug,
				'computed_affects' => array(
					'__sub_element',
				),				
			),
			'sub_menu_id' 	=> array(
				'label'            	=> esc_html__( 'WordPress Menu', 'divimenus' ),
				'description'      	=> sprintf('<p class="description">%2$s. <a href="%1$s" target="_blank">%3$s</a>.</p>',
					esc_url( admin_url( 'nav-menus.php' ) ), 
					esc_html__( 'Select a menu that should be used as the dropdown menu', 'divimenus' ), 
					esc_html__( 'Click here to create a new menu', 'et_builder' )
				),
				'type'             	=> 'select',
				'options'          	=> et_builder_get_nav_menus_options(),
				'default'			=> 'none',
				'show_if' 			=> array('link_type' => 'sub', 'sub_source' => 'menu'),
				'toggle_slug'      	=> $content_slug,
				'computed_affects' => array(
					'__menu',
				),
			),
			'sub_preview' 	=> array(
				'label'            	=> esc_html__( 'Preview in the Builder', 'divimenus' ),
				'description'		=> esc_html__( 'Toggle this field to temporarily preview the sub element while editing this Menu Item.', 'divimenus' ),
				'type'          => 'yes_no_button',
				'options'      	=> self::get_yes_no_button_options(),
				'default'	=> 'off',
				'show_if' 			=> array('link_type' => 'sub'),
				'toggle_slug'      	=> $content_slug,
			),
			'__menu'                          => array(
				'type'                => 'computed',
				'computed_callback'   => array( 'DiviMenusHelper', 'get_wp_menu' ),
				'computed_depends_on' => array(
					'sub_menu_id',
					'sub_collapse',
					'sub_icon',
					'sub_accordion',
				),
				'computed_minimum' => array(
					'sub_menu_id',
				),
			),
			'__sub_element'	=> array(
				'type'                => 'computed',
				'computed_callback'   => array( 'DiviMenusHelper', 'get_divi_layout' ),
				'computed_depends_on' => array(
					'sub_layout',
				),
				'computed_minimum' => array(
					'sub_layout',
				),
			),
			'sub_custom' => array(
				'label'         => esc_html__( 'Use Custom Display', 'divimenus' ),
				'description'   => sprintf('%2$s. <a href="%1$s" target="_blank">%3$s</a>.',
					esc_url( 'https://dondivi.com/documentation/sub-link-type/#sub-display' ), 
					esc_html__( 'Enable this option if you want to manually set how the Sub should be displayed', 'divimenus' ), 
					esc_html__( 'Learn more about the default display behavior', 'divimenus' )),
				'type'          => 'yes_no_button',
				'options'      	=> self::get_yes_no_button_options(),
				'default'		=> 'off',
				'show_if' 		=> array('link_type' => 'sub'),
				'toggle_slug'   => $content_slug,				
			),
			'sub_display' => array(
				'label'         	=> esc_html__( 'Custom Display', 'divimenus' ),
				'type'            	=> 'select',
                'options'          	=>  array(
					'absolute' 	=>  esc_html__('Over the page elements when hovering', 'divimenus'),
					'click' 	=>  esc_html__('Over the page elements when clicking', 'divimenus'),
                    'inline' 	=>  esc_html__('Inline when clicking', 'divimenus'),
                ),
				'default'           => 'absolute',
				'show_if'			=> array('link_type' => 'sub', 'sub_custom' => 'on'),
				'mobile_options'  	=> true,
                'toggle_slug'     	=> $content_slug,
			),
			'sub_width' => array(
				'label'           	=> esc_html__( 'Sub Width', 'divimenus' ),
				'description'		=> esc_html__( 'You can set a width here. If using Divi Layouts, remember that you can set the width in the Layout itself.', 'divimenus' ),
				'type'            	=> 'range',
				'range_settings' 	=> array(
					'max'  => 500,
					'step' => 1,
				),
				'show_if' 			=> array('link_type' => 'sub'),
				'allowed_values' 	=> et_builder_get_acceptable_css_string_values( 'width' ),
				'default_unit'		=> 'px',
				'validate_unit'		=> true,
				'mobile_options'  	=> true,
				'toggle_slug'     	=> $content_slug
			),
			'arrow_offset' => array(
				'label'         => esc_html__( 'Sub Offset', 'divimenus' ),
				'type'         	=> 'range',
				'default'  		=> '10px',
				'show_if' 		=> array('link_type' => 'sub'),
				'fixed_unit'	=> 'px',
				'mobile_options'=> true,
				'toggle_slug'   => $content_slug
			),
			'sub_collapse' => array(
				'label'         => esc_html__( 'Collapsible', 'divimenus' ),
				'type'          => 'yes_no_button',
				'options'      	=> self::get_yes_no_button_options(),
				'default'		=> 'off',
				'show_if' 		=> array('link_type' => 'sub', 'sub_source' => 'menu'),
				'toggle_slug'   => $content_slug,	
				'computed_affects' => array(
					'__menu',
				),			
			),
			'sub_icon' => array(
				'label'        	=> esc_html__( 'Collapse Icon', 'divimenus' ),
				'type'         	=> 'select_icon',
				'class'         => array( 'et-pb-font-icon' ),
				'default'		=> '%%34%%',
				'show_if' 		=> array('link_type' => 'sub', 'sub_source' => 'menu', 'sub_collapse' => 'on'),
				'toggle_slug'  	=> $content_slug,
				'hover'			=> 'tabs',
				'computed_affects' => array(
					'__menu',
				),					
			),
			'sub_accordion' => array(
				'label'         => esc_html__( 'Accordion', 'divimenus' ),
				'type'          => 'yes_no_button',
				'options'      	=> self::get_yes_no_button_options(),
				'default'		=> 'off',
				'show_if' 		=> array('link_type' => 'sub', 'sub_source' => 'menu', 'sub_collapse' => 'on'),
				'toggle_slug'   => $content_slug,
				'computed_affects' => array(
					'__menu',
				),	
			),
			'sub_arrow' => array(
				'label'         => esc_html__( 'Show Arrow', 'divimenus' ),
				'type'          => 'yes_no_button',
				'options'      	=> self::get_yes_no_button_options(),
				'default'		=> 'off',
				'show_if' 		=> array('link_type' => 'sub'),
				'toggle_slug'   => $content_slug,				
			),
			'arrow_direction'   =>  array(
				'label'         	=> esc_html__( 'Arrow Direction', 'divimenus' ),
				'description'		=> esc_html__( 'Flip the arrow upwards or downwards to change its direction', 'divimenus' ),
                'type'            	=> 'multiple_buttons',
                'options'          	=>  array(
                    'upwards' 	=>  array( 'title' 	=>  esc_html__('Upwards', 'et_builder'), 'icon'  => 'caret-up' ),
                    'downwards' =>  array( 'title'  =>  esc_html__('Downwards', 'et_builder'), 'icon'  => 'caret-down'),
                ),
				'default'           => 'upwards',
				'show_if'			=> array('link_type' => 'sub', 'sub_arrow' => 'on'),
                'toggle_slug'     	=> $content_slug,
            ),
			'sub_open_url' => array(
				'label'       	=> esc_html__( 'Open URL', 'divimenus' ),
				'description'   => esc_html__( 'If enabled, the destination URL introduced in the URL field will be opened on Menu Item Click', 'divimenus' ),
				'type'          => 'yes_no_button',
				'options'       => self::get_yes_no_button_options(),
				'default'	    => 'off',		
				'show_if' 		=> array('link_type' => 'sub'),
				'toggle_slug'   => $content_slug,
			),
			'sub_alignment' 		=> array(
				'label'         	=> esc_html__( 'Alignment', 'divimenus' ),
				'type'            	=> 'text_align',
				'options'         	=> et_builder_get_text_orientation_options(),
				'options_icon'    	=> 'module_align',
				'default'			=> 'center',
				'show_if' 			=> array('link_type' => 'sub'),
				'tab_slug'          => 'advanced',
				'toggle_slug'       => $advanced_slug,			
			),
			'sub_background_color' => array(
				'label'             => esc_html__( 'Menu Item Background', 'divimenus' ),
				'description'       => esc_html__( 'Here you can define a custom color for the menu items.', 'divimenus' ),
				'type'              => 'color-alpha',
				'show_if' 			=> array('link_type' => 'sub', 'sub_source' => 'menu'),
				'hover'				=> 'tabs',
				'sticky'			=> true,
				'mobile_options'	=> true,
				'tab_slug'          => 'advanced',
				'toggle_slug'       => $advanced_slug,
			),
			'sub_padding' => array(
				'label'           	=> esc_html__( 'Menu Item Padding', 'divimenus' ),
				'description'     	=> esc_html__( 'Here you can define the menu items padding.', 'divimenus' ),
				'type'            	=> 'custom_padding',
				'mobile_options'  	=> true,
				'sticky'			=> true,
				'show_if' 			=> array('link_type' => 'sub', 'sub_source' => 'menu'),
				'tab_slug'       	=> 'advanced',
				'toggle_slug'       => $advanced_slug,						
			),
			'sub_i_padding' => array(
				'label'           	=> esc_html__( 'Sub Menu Item Padding', 'divimenus' ),
				'description'     	=> esc_html__( 'Here you can define the sub menu items padding.', 'divimenus' ),
				'type'            	=> 'custom_padding',
				'mobile_options'  	=> true,
				'sticky'			=> true,
				'show_if' 			=> array('link_type' => 'sub', 'sub_source' => 'menu'),
				'tab_slug'       	=> 'advanced',
				'toggle_slug'       => $advanced_slug,					
			),
			'arrow_color' => array(
				'label'             => esc_html__( 'Arrow Color', 'divimenus' ),
				'type'              => 'color-alpha',
				'default' 			=> '#ffffff',
				'sticky'			=> true,
				'show_if'			=> array('link_type' => 'sub', 'sub_arrow' => 'on'),
				'tab_slug'          => 'advanced',
				'toggle_slug'       => $advanced_slug,
			),
		);
	}

	public static function get_text_icon_fields($content_toggle_slug, $show_key) {
		return array(
			'text_use_icon' => array(
				'label'             => esc_html__( 'Show Icon / Image', 'divimenus' ),
				'type'            	=> 'yes_no_button',
				'options'         	=> self::get_yes_no_button_options(),
				'default'			=> 'off',
				'show_if'			=> array($show_key => 'text'),
				'toggle_slug'       => $content_toggle_slug,			
			),
			'icon_type'       =>  array(
                'type'            	=> 'multiple_buttons',
                'options'          	=>  array(
                    'icon' 	=>  array( 'title' 	=>  esc_html__('Icon', 'et_builder') ),
                    'image' =>  array( 'title'  =>  esc_html__('Image', 'et_builder') ),
                ),
				'default'           => 'icon',
				'show_if'			=> array($show_key => 'text', 'text_use_icon' => 'on'),
                'toggle_slug'     	=> $content_toggle_slug,
            ),
			'text_font_icon' => array(
				'label'             => esc_html__( 'Icon', 'et_builder' ),
				'type'              => 'select_icon',
				'class'             => array( 'et-pb-font-icon' ),
				'show_if'			=> array($show_key => 'text', 'text_use_icon' => 'on', 'icon_type' => 'icon'),
				'hover'				=> 'tabs',
				'toggle_slug'       => $content_toggle_slug,			
			),
			'text_image' => array(
				'label'             => esc_html__( 'Image', 'divimenus' ),
				'type'              => 'upload',
				'upload_button_text'=> esc_attr__( 'Upload an image', 'et_builder' ),
				'choose_text'       => esc_attr__( 'Choose an Image', 'et_builder' ),
				'update_text'       => esc_attr__( 'Set As Image', 'et_builder' ),
				'show_if'			=> array($show_key => 'text', 'text_use_icon' => 'on', 'icon_type' => 'image'),
				'hover'				=> 'tabs',
				'toggle_slug'       => $content_toggle_slug,
			),
			'text_icon_pos' => array(
				'label'             => esc_html__( 'Placement', 'divimenus' ),
				'type'            	=> 'select',
				'options'         	=> self::get_positions(false),
				'default'			=> 'left',
				'show_if'			=> array($show_key => 'text', 'text_use_icon' => 'on'),
				'toggle_slug'       => $content_toggle_slug,			
			),
			'text_icon_padding' => array(
				'label'             => esc_html__( 'Padding', 'divimenus' ),
				'type'            	=> 'range',
				'default'         	=> '0.3em',
				'default_unit'		=> 'em',
				'validate_unit'		=> true,
				'hover'  			=> 'tabs',
				'sticky'			=> true,
				'show_if'			=> array($show_key => 'text', 'text_use_icon' => 'on'),
				'toggle_slug'       => $content_toggle_slug,
			),
			'text_disable' => array(
				'label'           	=> esc_html__( 'Hide Text On', 'divimenus' ),
				'type'            	=> 'multiple_checkboxes',
				'options'         	=> array(
					'phone'   => esc_html__( 'Phone', 'et_builder' ),
					'tablet'  => esc_html__( 'Tablet', 'et_builder' ),
					'desktop' => esc_html__( 'Desktop', 'et_builder' ),
				),
				'show_if'			=> array($show_key => 'text', 'text_use_icon' => 'on'),
				'toggle_slug'     	=> $content_toggle_slug,
			),
			'text_icon_disable' => array(
				'label'           	=> esc_html__( 'Hide Icon / Image On', 'divimenus' ),
				'type'            	=> 'multiple_checkboxes',
				'options'         	=> array(
					'phone'   => esc_html__( 'Phone', 'et_builder' ),
					'tablet'  => esc_html__( 'Tablet', 'et_builder' ),
					'desktop' => esc_html__( 'Desktop', 'et_builder' ),
				),
				'show_if'			=> array($show_key => 'text', 'text_use_icon' => 'on'),
				'toggle_slug'     	=> $content_toggle_slug,
			),
			'text_icon_color' => array(
				'label'             => esc_html__( 'Icon Color', 'divimenus' ),
				'type'              => 'color-alpha',
				'hover'				=> 'tabs',
				'mobile_options'	=> true,
				'sticky'			=> true,
				'show_if'			=> array($show_key => 'text', 'text_use_icon' => 'on', 'icon_type' => 'icon'),
				'tab_slug'        	=> 'advanced',
				'toggle_slug'       => 'icon_settings',			
			),
			'text_icon_font_size' => array(
				'label'             => esc_html__( 'Icon Font Size', 'divimenus' ),
				'type'            	=> 'range',
				'default'			=> '23px',
				'default_unit'		=> 'px',
				'validate_unit'		=> true,
				'mobile_options'	=> true,
				'sticky'			=> true,
				'show_if'			=> array($show_key => 'text', 'text_use_icon' => 'on', 'icon_type' => 'icon'),
				'tab_slug'        	=> 'advanced',
				'toggle_slug'       => 'icon_settings',			
			),
			'text_image_size' => array(
				'label'           	=> esc_html__( 'Image Width', 'divimenus' ),
				'type'            	=> 'range',
				'allowed_values'    => et_builder_get_acceptable_css_string_values( 'width' ),
				'default'  			=> '57px',
				'default_unit'  	=> 'px',
				'validate_unit'		=> true,
				'mobile_options'  	=> true,
				'sticky'			=> true,
				'show_if'			=> array($show_key => 'text', 'text_use_icon' => 'on', 'icon_type' => 'image'),
				'tab_slug'    		=> 'advanced',
				'toggle_slug'     	=> 'image_settings',
			),	
		);
	}

	public static function get_url($props) {
		$url = '#'; 
		if (self::is_cart($props) && $props['cart_provider'] === 'wc' && self::wc_active())
			$url = function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : WC()->cart->get_cart_url();
		else if (self::is_cart($props) && function_exists( 'edd_get_checkout_uri' ))
			$url = edd_get_checkout_uri();
		else if ( !empty($props['url']) )
			$url = esc_url($props['url']);
		return $url;
	}
	
	public static function get_value($value, $default = 0) {
		return is_numeric(rtrim($value, 'px')) && rtrim($value, 'px') >= 0 ? rtrim($value, 'px') : $default;
	}

	public static function get_wp_menu( $args = array(), $conditional_tags = array(), $current_page = array()) {
		$defaults     = array(
			'frontend' 			=> false,
			'sub_menu_id'    	=> '',
			'sub_collapse'     	=> 'off',
			'sub_accordion'     => 'off', //
		);
		$args      = wp_parse_args( $args, $defaults );
		$menu_args = array(
			'container'    	=> '',
			'link_after'	=> '</span>',
			'link_before'	=> '<span style="flex:1">',
			'link_class'	=> 'dd-menu-item-content dd-text',
			'menu'			=> (int) $args['sub_menu_id'],
			'menu_class'	=> '',
			'echo'        	=> false,
		);
		
		if ($args['sub_collapse'] === 'on') {
			$menu_args['li_collapse_class'] = $args['sub_accordion'] === 'on' ? 'dd-collapsible dd-accordion' : 'dd-collapsible';
			$menu_args['link_collapse_class'] = 'dd-menu-item-content dd-text dd-collapse';
			if ($args['frontend'])
				$menu_args['link_after'] = '</span>' . DiviMenusHelper::render_icon( $args['props'], 'et_pb_divimenus_flex_item', 'sub_icon', array('dd-icon-content dd-collapse notranslate'), false, false, false, '%%order_class%% span.dd-collapse', '%%order_class%% a.active > .dd-collapse');
			else	
			    $menu_args['link_after'] = sprintf('</span><span class="dd-icon-content dd-collapse notranslate">%1$s</span>', esc_html( self::process_font_icon( $args['sub_icon'] )));
		}

		return wp_nav_menu( apply_filters( 'dd_sub_args', $menu_args ) );
	}

	public static function get_yes_no_button_options() {
		return array(
			'off' => esc_html__( 'No', 'et_builder' ),
			'on'  => esc_html__( 'Yes', 'et_builder' ),
		);
	}

	public static function has_background($props) {
		return (!empty($props['background_color']) || $props['use_background_color_gradient'] ==='on' || !empty($props['background_image'])); 
	}

	public static function is_cart($props) {
		return isset($props['is_cart']) && $props['is_cart'] === 'on'; 
	}

	public static function maybe_render_text_icon( $props, $render_slug, $selector, $hover_selector ) {
		$text_icon = '';
		if ($props['text_use_icon'] === 'on') {
			if ($props['icon_type'] !== 'image')
				$text_icon = self::render_icon($props, $render_slug, 'text_font_icon', array('dd-text-icon dd-icon-content notranslate'), true, false, false, $selector, $hover_selector);
			else {
				$image_alt = DiviMenusHelper::get_image_alt($props, 'text_image', '');
				$image = self::render_image($props, 'text_image', '', $image_alt, 'data:,');
				$text_icon = sprintf('<div class="%2$s">%1$s</div>', $image, 'dd-text-image');
			}
		}
		return $text_icon;
	}

	public static function is_post( $post_id, $post_type ) {
		if (!empty($post_id)) {
			$post = get_post( $post_id );
			if ( $post ) return $post->post_type === $post_type && $post->post_status === 'publish';	  
		}
		return false;
	}

	public static function process_font_icon($icon) {
		if (function_exists('et_pb_extended_process_font_icon'))
			return et_pb_extended_process_font_icon($icon);
		else return html_entity_decode(et_pb_process_font_icon($icon));
	}

	public static function render_icon( $props, $render_slug, $icon_attr, $elem_class_array, $skip_tab, $mb, $opened, $selector, $hover_selector) {
		$icon = $props[$icon_attr] ? self::process_font_icon( $props[$icon_attr]) : ' ';
		self::set_icon_style($props[$icon_attr], $render_slug, $selector);	
		$icon_attrs = array( sprintf('aria-label="%s Icon Font"', esc_attr( $icon )) );
		if ($mb) {
			$icon_attrs[]= sprintf('role="button" aria-pressed="%s"', $opened ? 'true' : 'false');
		}
		if (!$skip_tab) $icon_attrs[]= 'tabindex="0"';
		if ( et_pb_hover_options()->is_enabled( $icon_attr, $props ) ) {			
			$hover_value = self::process_font_icon(et_pb_hover_options()->get_value( $icon_attr, $props));
			if (!empty($hover_value) && $hover_value !== $icon) {
				$icon_attrs []= sprintf('data-desktop="%1$s" data-hover="%2$s"', esc_attr( $icon ), esc_attr( $hover_value ));
				$elem_class_array[] = 'dd-multi-value';
				self::set_icon_style(et_pb_hover_options()->get_value( $icon_attr, $props), $render_slug, $hover_selector );
			}
		}
		return sprintf('<span class="%2$s"%3$s>%1$s</span>', 
			apply_filters('dd_icon_output', esc_html( $icon ), $props), 
			implode( ' ', $elem_class_array), 
			implode( ' ', $icon_attrs)
		);
	}

	public static function render_image ( $props, $image_attr, $image_class, $image_alt, $default_image ) {
		$image = !empty($props[$image_attr]) ? $props[$image_attr] : $default_image;
		$image_classes = $image_class ? array($image_class) : array();
		$multi_value_attrs = '';	
		if ( et_pb_hover_options()->is_enabled( $image_attr, $props ) ) {			
			$hover_value = et_pb_hover_options()->get_value( $image_attr, $props);	
			if (!empty($hover_value) && $hover_value !== $image) {
				$multi_value_attrs = sprintf(' data-desktop="%1$s" data-hover="%2$s"', esc_attr( $image ), esc_attr( $hover_value ));
				$image_classes[] = 'dd-multi-value';
			}
		}
		$image_attachment_class = et_pb_media_options()->get_image_attachment_class( $props, $image_attr );

		if ( ! empty( $image_attachment_class ) ) {
			$image_classes []= esc_attr( $image_attachment_class );
		}
		return sprintf('<img src="%1$s" class="%3$s"%4$s alt="%2$s" aria-label="Image"/>', 
			esc_attr($image), esc_attr(trim($image_alt)), implode( ' ', $image_classes ), $multi_value_attrs); 
	}

	public static function render_popup( $builder_element, $render_slug, $popup_id, $popup_css_id) {
		$popup_close = '';
		if ($builder_element->props['popup_close'] === 'on') { 
			$multi_view = et_pb_multi_view_options( $builder_element );
			$popup_close = $multi_view->render_element(
				array(
					'content' => '{{popup_close_font_icon}}',
					'hover_selector' => '.dd-close-icon', 
					'attrs'   => array(
						'class' => 'dd-close-icon dd-icon-content notranslate',
						'tabindex' => '0',
						'role'	=> 'button',
						'aria-label' => 'Close Popup',
					),
					'styles' => array(
						'color' 	=> esc_attr( $builder_element->props['popup_close_text_color'] ),
						'font-size' => esc_attr( $builder_element->props['popup_close_font_size'] ),
					),
				)
			);
			if (function_exists('et_pb_extended_process_font_icon')) 
				$builder_element->generate_styles(
					array(
						'utility_arg'    => 'icon_font_family',
						'render_slug'    => $render_slug,
						'base_attr_name' => 'popup_close_font_icon',
						'important'      => true,
						'selector'       => "#{$popup_css_id} .dd-close-icon",
						'hover_selector' => "#{$popup_css_id} .dd-close-icon:hover",
						'processor'      => array(
							'ET_Builder_Module_Helper_Style_Processor',
							'process_extended_icon',
						),
					)
				);
		}
		$popup_content = self::get_divi_layout( array('internal' => false, 'sub_layout' => $popup_id) );

		if ( $builder_element->props['popup_alignment'] === 'left' ) $builder_element->props['popup_alignment'] = 'center_left'; // backwards compatibility
		if ( $builder_element->props['popup_alignment'] === 'right' ) $builder_element->props['popup_alignment'] = 'center_right'; // backwards compatibility 
		$location_array          = explode( '_', $builder_element->props['popup_alignment'] );
		$location_y = isset( $location_array[0] ) ? $location_array[0] : 'center';
		$location_x = isset( $location_array[1] ) ? $location_array[1] : 'center'; 
		return sprintf(
			'<div id="%3$s" class="dd-popup-c et_pb_section et_pb_column_4_4" style="background-color:%4$s;justify-content:%5$s;align-items:%6$s;">
				<div class="dd-menu-item-modal%9$s" style="max-width:%7$s;max-height:%8$s;" data-width="%7$s">
					%1$s
					%2$s									
				</div> 
			</div>', 
			$popup_close,
			$popup_content,
			$popup_css_id,
			esc_attr($builder_element->props['overlay_color']),
			self::get_alignment('justify', $location_x, 'center', 'row', false ),
			self::get_alignment('align', $location_y, 'center', 'column', false ),
			esc_attr($builder_element->props['popup_max_width']),
			esc_attr($builder_element->props['popup_max_height']),
			$builder_element->props['popup_limit'] === 'on' ? ' dd-modal-width' :''
		);
	}
	
	public static function render_text( $builder_element, $text_attr, $text_class, $default_text ) {
		$text = trim($builder_element->props[$text_attr]) ? trim($builder_element->props[$text_attr]) : $default_text;
		$text_attrs = array();
		$text_classes = $text_class ? array($text_class) : array();
		if ( et_pb_hover_options()->is_enabled( $text_attr, $builder_element->props ) ) {			
			$hover_value = et_pb_hover_options()->get_value( $text_attr, $builder_element->props);
			if (!empty($hover_value) && $hover_value !== $text) {
				$text_attrs['data-desktop'] = esc_attr( $text );
				$text_attrs['data-hover'] = esc_attr( $hover_value );
				$text_classes[] = 'dd-multi-value';
			}
		}
		$text_attrs['class'] = implode( ' ', $text_classes );
		$multi_view = et_pb_multi_view_options( $builder_element );
		return $multi_view->render_element(
			array(
				'content' => $text,
				'attrs'   => $text_attrs,
			)
		);
	}

	public static function set_icon_style($icon, $render_slug, $selector) {
		if (function_exists('et_pb_get_icon_font_family') && function_exists('et_pb_get_icon_font_weight') ) {
			$icon_font_content = ' font-family: ' . et_pb_get_icon_font_family( $icon ) . ';'; //' !important;';
			$icon_font_content .= ' font-weight: ' . et_pb_get_icon_font_weight( $icon ) . ';'; // ' !important;';

			self::set_style($render_slug, $selector, $icon_font_content);
		}
	}

	public static function set_fullwidth_style($render_slug, $fullwidth_responsive_values, $selector, $direction) {
		if ($fullwidth_responsive_values['desktop'] === 'on')
			self::set_style($render_slug, $selector, $direction['desktop'] === 'row' ? 'flex: 1;' : 'width:100%;');
		
		self::set_style($render_slug, $selector, $fullwidth_responsive_values['tablet'] === 'on' ? ( $direction['tablet'] === 'row' ? 'flex: 1;' : 'width:100%;' ) : 'flex: initial; width: auto;', 't');
		self::set_style($render_slug, $selector, $fullwidth_responsive_values['phone'] === 'on' ? ( $direction['phone'] === 'row' ? 'flex: 1;' : 'width:100%;' ) : 'flex: initial; width: auto;', 'p');	
	}

	public static function set_responsive_padding_css($props, $field, $selector, $property, $render_slug, $is_sticky_module) {
		$responsive_enabled = et_pb_responsive_options()-> is_responsive_enabled($props, $field);
		$values = array(
			'desktop' => rtrim( et_builder_get_element_style_css( $props[$field], $property, false ) ) ,
			'tablet'  => $responsive_enabled ? rtrim( et_builder_get_element_style_css( $props[$field . '_tablet'], $property, false ) ) : '',
			'phone'   => $responsive_enabled ? rtrim( et_builder_get_element_style_css( $props[$field . '_phone'], $property, false ) ) : ''
		);
		et_pb_responsive_options()->declare_responsive_css( $values, $selector, $render_slug, 10 );
		$sticky = et_pb_sticky_options();
		$sticky_value = $sticky->get_value( $field, $props, '' );
		if ($sticky_value !== '' && $sticky->is_enabled( $field, $props )) {
			// $is_sticky_module = $sticky->is_sticky_module( $module->props );
			self::set_style($render_slug, $sticky->add_sticky_to_order_class($selector, $is_sticky_module), et_builder_get_element_style_css($sticky_value, $property, false));
		}
	}

	public static function show_cart_info($module){
		$cart_info = '';
		if ( !self::is_cart($module->props)) return $cart_info;
		if ( $module->props['cart_provider'] === 'wc' && !self::wc_active() ) return $cart_info;
		if ( $module->props['cart_provider'] === 'edd' && !function_exists('edd_get_cart_quantity') ) return $cart_info;
		
		if ($module->props['cart_items_count'] === 'on') {

			$items_count = $module->props['cart_provider'] === 'wc' ? WC()->cart->get_cart_contents_count() : edd_get_cart_quantity();
			if ( $module->props['cart_items_empty'] === 'off' && $items_count === 0 ) return $cart_info;
			
			$cart_info = $module->props['cart_provider'] === 'wc' ? 
				sprintf('<span class="dd-cart-info dd-cart-count">%1$s</span>', $items_count) : sprintf('<span class="dd-cart-info edd-cart-quantity">%1$s</span>', $items_count);
			$module->generate_styles(
				array(
					'base_attr_name' => 'cart_background_color',
					'selector'       => '%%order_class%% .dd-cart-info',
					'hover_selector' => '%%order_class%% .dd-item.hover .dd-cart-info, %%order_class%% .dd-item.active .dd-cart-info',
					'css_property'   => 'background-color',
					'render_slug'    => 'et_pb_divimenus_flex_item',
				)
			);
		}
		return $cart_info;
	}

	public static function set_style($render_slug, $selector, $declaration, $device = 'all') {
		$style = array( 'selector' => $selector, 'declaration' => $declaration);
		if ( $device === 'd' )
			$style['media_query'] = ET_Builder_Element::get_media_query( 'min_width_981' );
		else if ( $device === 't' )
			$style['media_query'] = ET_Builder_Element::get_media_query( '768_980' );
		else if ( $device === 'p' )
			$style['media_query'] = ET_Builder_Element::get_media_query( 'max_width_767' );
		ET_Builder_Element::set_style( $render_slug, $style);
	}

	public static function set_text_icon_style($render_slug, $module, $text_selector, $icon_selector, $image_selector, $icon_hover_selector, $image_hover_selector) {
		$display_style = '';
		if ($module->props['text_icon_pos'] === 'top' || $module->props['text_icon_pos'] === 'bottom') $display_style= 'display:block;';

		self::set_style($render_slug, $text_selector, sprintf('flex-direction:%s;', self::get_flex_dir('row', $module->props['text_icon_pos'])));
		self::set_style($render_slug, $image_selector . '> img', $display_style);
		
		$module->generate_styles(
			array(
				'base_attr_name' => 'text_icon_padding',
				'selector'       => $icon_selector . ',' . $image_selector,
				'hover_selector' => $icon_hover_selector . ',' . $image_hover_selector,
				'css_property'   => self::get_padding_property($module->props['text_icon_pos']),
				'render_slug'    => $render_slug,
			)
		);
		self::set_visibility($render_slug, $module->props, 'text_disable', $text_selector, false);
		self::set_visibility($render_slug, $module->props, 'text_icon_disable', $icon_selector . ',' . $image_selector, false);
		
		if ($module->props['icon_type'] !== 'image') {   
			$module->generate_styles(
				array(
					'base_attr_name' => 'text_icon_color',
					'selector'       => $icon_selector,
					'hover_selector' => $icon_hover_selector,
					'css_property'   => 'color',
					'render_slug'    => $render_slug,
					'type'           => 'color',
				)
			);
			$module->generate_styles(
				array(
					'base_attr_name' => 'text_icon_font_size',
					'selector'       => $icon_selector,
					'css_property'   => 'font-size',
					'render_slug'    => $render_slug,
				)
			);
		} else {
			$module->generate_styles(
				array(
					'base_attr_name' => 'text_image_size',
					'selector'       => $image_selector . '> img',
					'css_property'   => 'width',
					'render_slug'    => $render_slug,
				)
			);
		}
	}

	public static function set_item_values(&$props, $parent) {
		if (empty($props['item_image'])) $props['item_image'] = $parent['menu_item_image'];
		if ('on' === $props['item_use_custom'] ) { 
			if (empty($props['item_text_color'])) $props['item_text_color'] = '#666666';
		} 

		if ('on' === $props['item_use_padding'] ) {   
			$is_responsive = et_pb_get_responsive_status( $props['menu_item_padding_last_edited']);			  
			$props['menu_item_padding'] = self::get_value($props['menu_item_padding'], 15);
			$props['menu_item_padding_tablet'] = self::get_value($is_responsive ? $props['menu_item_padding_tablet'] : $props['menu_item_padding'], $props['menu_item_padding']);
			$props['menu_item_padding_phone'] = self::get_value($is_responsive ? $props['menu_item_padding_phone'] : $props['menu_item_padding'], $props['menu_item_padding_tablet']);
		} else {
			$props['menu_item_padding'] = self::get_value($parent['item_padding'], 15); 
			$props['menu_item_padding_tablet'] = self::get_value($parent['item_padding_tablet'], $props['menu_item_padding']);
			$props['menu_item_padding_phone'] = self::get_value($parent['item_padding_phone'], $props['menu_item_padding_tablet']);
		}
		
		$title_responsive_status = et_pb_get_responsive_status( $props['title_position_last_edited'] );
		$props['title_position_tablet'] = $title_responsive_status ? (!empty($props['title_position_tablet']) ? $props['title_position_tablet'] : $props['title_position']) : $props['title_position'];
		$props['title_position_phone'] = $title_responsive_status ? (!empty($props['title_position_phone']) ? $props['title_position_phone'] : $props['ttitle_position_tablet']) : $props['title_position'];
	}

	public static function set_sub_hover_style($render_slug, $hali, $sub_selector, $sub_hover_selector, $device) {
		self::set_style($render_slug, $sub_selector, DiviMenusHelper::get_sub_css($hali, false), $device);
		self::set_style($render_slug, $sub_hover_selector, 'display: block; border-width: 15px;', $device);
	}

	public static function set_values(&$props) {
		$is_responsive = et_pb_get_responsive_status( $props['central_item_image_size_last_edited'] );			
		$props['central_item_image_size'] = self::get_value($props['central_item_image_size'], 57); 
		$props['central_item_image_size_tablet'] = self::get_value($is_responsive ? $props['central_item_image_size_tablet'] : $props['central_item_image_size'], $props['central_item_image_size']); 
		$props['central_item_image_size_phone'] = self::get_value($is_responsive ? $props['central_item_image_size_phone'] : $props['central_item_image_size'], $props['central_item_image_size_tablet']);
		$props['central_item_image_height'] = self::get_image_height($props['central_item_image'], $props['central_item_image_size'], $props['central_item_image_ratio']); 
		$props['central_item_image_height_t'] = self::get_image_height($props['central_item_image'], $props['central_item_image_size_tablet'], $props['central_item_image_ratio']); 
		$props['central_item_image_height_p'] = self::get_image_height($props['central_item_image'], $props['central_item_image_size_phone'], $props['central_item_image_ratio']);
	}

	public static function set_visibility( $render_slug, $props, $attr, $selector, $visible) {
		global $mi_fullwidth, $dm_direction;
		$disabled_on_array   = explode( '|', $props[$attr] );
		$i                   = 0;
		$current_device = 'p';
		$breakpoint = 'phone';
		$force_visible = false;
		$positioning = et_pb_responsive_options()->get_property_values($props, 'positioning', $props['positioning'], true); 
		foreach ( $disabled_on_array as $value ) {
			if ( 'on' === $value ) {
				$declaration = 'display:none!important;';
				if ( $visible ) $declaration = esc_html(
					sprintf('position:%s!important;width:auto;height:auto!important;visibility:visible;opacity:1;overflow:visible;', $positioning[$breakpoint] === 'none' ? 'relative' : $positioning[$breakpoint] )
				);
				self::set_style( $render_slug, $attr === 'text_disable' ? $selector .' > .dd-text-content' : $selector, $declaration, $current_device );
				if ($attr === 'text_disable') self::set_style( $render_slug, $selector . ' > *:not(.dd-text-content)', 'padding: 0;', $current_device );
				$force_visible = true;
			}
			$i++;
			$current_device = 1 === $i ? 't' : 'd';
			$breakpoint = 1 === $i ? 'tablet' : 'desktop';
		}
		if ($visible && $force_visible) self::set_fullwidth_style($render_slug, $mi_fullwidth, '%%parent_class%% .dd-divimenu ' . $selector, $dm_direction);
		else if ($visible) self::set_fullwidth_style($render_slug, $mi_fullwidth, '%%parent_class%% .dd-divimenu-open ' . $selector, $dm_direction);
	}

	public static function set_wp_menu_style( $render_slug, $module ) {
		self::set_style( $render_slug, '%%order_class%% .dd-menu-flex-sub ul', 'list-style:none!important; padding: 0!important;');
		self::set_style( $render_slug, '%%order_class%% .dd-menu-flex-sub ul a', 'display:flex;flex-direction:row;align-items:center;color:inherit;padding:10px 15px;line-height:1.3em;');
		
		$module->generate_styles(
			array(
				'base_attr_name' => 'sub_background_color',
				'selector'       => '%%order_class%% .dd-mi .dd-menu-flex-sub a',
				'hover_selector' => '%%order_class%% .dd-mi-w .dd-mi .dd-menu-flex-sub .dd-menu-item-content:hover, %%order_class%% .dd-mi-w .dd-mi .dd-menu-flex-sub .dd-menu-item-content.active',
				'css_property'   => 'background',
				'render_slug'    => $render_slug,
				'type'           => 'color',
			)
		);

		self::set_responsive_padding_css($module->props, 'sub_padding', '%%order_class%% .dd-menu-flex-sub > ul a', 'padding', $render_slug, false);

		self::set_style( $render_slug, '%%order_class%% .dd-menu-flex-sub ul ul a', 'padding-left: 30px;');

		self::set_responsive_padding_css($module->props, 'sub_i_padding', '%%order_class%% .dd-menu-flex-sub ul ul a', 'padding', $render_slug, false);

		if ($module->props['sub_collapse'] === 'on') {
			self::set_style( $render_slug, '%%order_class%% .dd-collapsible ul, %%order_class%% .menu-item:not(.dd-collapsible) span.dd-collapse', 'display:none;' );
			self::set_style( $render_slug, '%%order_class%% .dd-menu-flex-sub span.dd-collapse', 'font-size:inherit;' );
		}
	}

	public static function wc_active() {
		return class_exists( 'woocommerce' ) && WC()->cart;
	}
}