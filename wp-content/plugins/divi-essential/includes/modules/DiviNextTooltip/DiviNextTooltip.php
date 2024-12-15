<?php
include_once(DIVI_ESSENTIAL_PATH.'/includes/modules/base/Common.php');

class DiviNextTooltip extends ET_Builder_Module {

	public $slug       = 'dnxte_tooltip';
	public $vb_support = 'on';
	public $child_slug = 'dnxte_tooltip_child';

	protected $module_credits = array(
		'module_uri' => 'https://www.diviessential.com/divi-hotspot/',
		'author'     => 'Divi Next',
		'author_uri' => 'www.divinext.com',
	);

	public function init() {
		$this->name        = esc_html__( 'Next Image Hotspot', 'et_builder' );
		$this->icon_path   = plugin_dir_path( __FILE__ ) . 'icon.svg';
		$this->folder_name = 'et_pb_divi_essential';

		$this->settings_modal_toggles = array(
			'general' => array(
				'toggles' => array(
					'dnxte_tooltip_image' => esc_html__('Image', 'et_builder')
				)
			),
			'advanced' => array(
				'toggles' => array(
					'dnxte_hotspot_settings' => esc_html__('Hotspot Settings', 'et_builder'), 
					'dnxte_tooltip_settings' => esc_html__('Tooltip Settings', 'et_builder'),
					'dnxte_tooltip_text' => esc_html__('Tooltip Text', 'et_builder'),
					'dnxte_tooltip_desc' => esc_html__('Tooltip Description', 'et_builder'),
					'dnxte_tooltip_image' => esc_html__('Tooltip Image', 'et_builder') 
				)
			)
        );
        
        $this->custom_css_fields = array(
            'hotspot_text' => array(
                'label' => esc_html__('Hotspot Text', 'et_builder'),
                'selector' => '%%order_class%% .dnxte-hostpot-hotspot__text',
            ),
            'hotspot_icon' => array(
                'label' => esc_html__('Hotspot Icon', 'et_builder'),
                'selector' => '%%order_class%% .dnxte-hotspot_icon',
            ),
            'tooltip_text' => array(
                'label' => esc_html__('Tooltip Text', 'et_builder'),
                'selector' => '%%order_class%% .dnxte_tooltip_text',
            ),
            'tooltip_desc' => array(
                'label' => esc_html__('Tooltip Description', 'et_builder'),
                'selector' => '%%order_class%% .dnxte-tooltip-content',
            ),
            'tooltip_image' => array(
                'label' => esc_html__('Tooltip Image', 'et_builder'),
                'selector' => '%%order_class%% .dnxte-tooltip-image-container',
            ),
        );
	}

	public function get_advanced_fields_config() {
		return array(
			'text' => false,
			'fonts' => array(
				'hotspot_text' => array(
                    'label' => esc_html__('Hotspot', 'et_builder'),
                    'css' => array(
                        'main' => "%%order_class%% .dnxte-hostpot-hotspot__text",
                        'important' => 'plugin-only',
                    ),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxte_hotspot_settings',
                ),
                'tooltip_text' => array(
                    'label' => esc_html__('Tooltip', 'et_builder'),
                    'css' => array(
                        'main' => "%%order_class%% .dnxte-hostpot-tooltip-text .dnxte_tooltip_text",
                        'important' => 'plugin-only',
                    ),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxte_tooltip_text',
                ),
                'tooltip_desc' => array(
                    'label' => esc_html__('Description', 'et_builder'),
                    'css' => array(
                        'main' => "%%order_class%% .dnxte-hostpot-tooltip-text .dnxte-tooltip-content",
                        'important' => 'plugin-only',
                    ),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxte_tooltip_desc',
                ),
			),
			'borders' => array(
                'default' => array(
					'css' => array(
						'main'     => array(
							'border_radii'  		=> "%%order_class%% .dnxte-hostpot-hotspots-wrapper img",
							'border_radii_hover'  	=> '%%order_class%%:hover .dnxte-hostpot-hotspots-wrapper img',
							'border_styles' 		=> "%%order_class%% .dnxte-hostpot-hotspots-wrapper img",
							'border_styles_hover' 	=> '%%order_class%%:hover .dnxte-hostpot-hotspots-wrapper img',
						),
					)
				),
                'hotspot' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => "%%order_class%% .dnxte-hostpot-hotspots__wrapper,%%order_class%% .dnxte-hostpot-hotspots__wrapper:before",
                            'border_styles' => "%%order_class%% .dnxte-hostpot-hotspots__wrapper",
                        ),
                    ),
                    'label_prefix' => esc_html__('Hotspot', 'et_builder'),
                    'toggle_slug' => 'dnxte_hotspot_settings',
                ),
                'tooltip_text' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => "%%order_class%% .dnxte-hostpot-tooltip-text .dnxte_tooltip_text",
                            'border_styles' => "%%order_class%% .dnxte-hostpot-tooltip-text .dnxte_tooltip_text",
                        ),
                    ),
                    'label_prefix' => esc_html__('Text', 'et_builder'),
                    'toggle_slug' => 'dnxte_tooltip_text',
                ),
                'tooltip_desc' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => "%%order_class%% .dnxte-hostpot-tooltip-text .dnxte-tooltip-content",
                            'border_styles' => "%%order_class%% .dnxte-hostpot-tooltip-text .dnxte-tooltip-content",
                        ),
                    ),
                    'toggle_slug' => 'dnxte_tooltip_desc',
                ),
                'tooltip_img' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => "%%order_class%% .dnxte-hostpot-tooltip-text img",
                            'border_styles' => "%%order_class%% .dnxte-hostpot-tooltip-text img",
                        ),
                    ),
                    'toggle_slug' => 'dnxte_tooltip_image',
                ),
            ),
            'box_shadow' => array(
                'default' => array(
					'css' 	=> array(
						'main'	=> "%%order_class%% .dnxte-hostpot-hotspots-wrapper img"
					)
				),
                'hotspot' => array(
                    'label' => esc_html__('Hotspot Box Shadow', 'et_builder'),
                    'option_category' => 'layout',
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxte_hotspot_settings',
                    'css' => array(
                        'main' => '%%order_class%% .dnxte-hostpot-hotspots__wrapper',
                        'custom_style' => true,
                    ),
                    'default_on_fronts' => array(
                        'color' => '',
                        'position' => '',
                    ),
                ),
                'tooltip_text' => array(
                    'label' => esc_html__('Text Box Shadow', 'et_builder'),
                    'option_category' => 'layout',
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxte_tooltip_text',
                    'css' => array(
                        'main' => '%%order_class%% .dnxte-hostpot-tooltip-text .dnxte_tooltip_text',
                        'custom_style' => true,
                    ),
                    'default_on_fronts' => array(
                        'color' => '',
                        'position' => '',
                    ),
                ),
                'tooltip_desc' => array(
                    'label' => esc_html__('Box Shadow', 'et_builder'),
                    'option_category' => 'layout',
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxte_tooltip_desc',
                    'css' => array(
                        'main' => '%%order_class%% .dnxte-hostpot-tooltip-text .dnxte-tooltip-content',
                        'custom_style' => true,
                    ),
                    'default_on_fronts' => array(
                        'color' => '',
                        'position' => '',
                    ),
                ),
                'tooltip_img' => array(
                    'label' => esc_html__('Box Shadow', 'et_builder'),
                    'option_category' => 'layout',
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxte_tooltip_image',
                    'css' => array(
                        'main' => '%%order_class%% .dnxte-hostpot-tooltip-text img',
                        'custom_style' => true,
                    ),
                    'default_on_fronts' => array(
                        'color' => '',
                        'position' => '',
                    ),
                ),
            )
		);
	}

	public function get_fields() {
		return array(
			'tooltip_image' => array(
                'label' => esc_html__('Image', 'et_builder'),
                'type' => 'upload',
                'option_category' => 'basic_option',
                'upload_button_text' => esc_attr__('Upload an image', 'et_builder'),
                'choose_text' => esc_attr__('Choose an Image', 'et_builder'),
                'update_text' => esc_attr__('Set As Image', 'et_builder'),
                'description' => esc_html__('Upload an image to display at the top of your team person.', 'et_builder'),
                'toggle_slug' => 'dnxte_tooltip_image',
                'dynamic_content' => 'image',
                'mobile_options' => true,
                'hover' => 'tabs',
            ),
            'tooltip_image_alt' => array(
                'label' => esc_html__('Image Alt', 'et_builder'),
				'type' => 'text',
				'default' => 'tooltip text',
                'option_category' => 'basic_option',
                'description' => esc_html__('Input image alt text', 'et_builder'),
                'toggle_slug' => 'dnxte_tooltip_image',
                'dynamic_content' => 'text',
                'mobile_options' => true,
                'hover' => 'tabs',
			),
			'hotspot_bg' => array(
                'label' => esc_html__('Background Color', 'et_builder'),
                'type' => 'color-alpha',
                'custom_color' => true,
                'default' => '#4b00e7',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxte_hotspot_settings',
                'mobile_options' => true,
                'hover' => 'tabs',
            ),
            'hotspot_wave_color' => array(
                'label' => esc_html__('Wave Color', 'et_builder'),
                'type' => 'color-alpha',
                'custom_color' => true,
                'default' => '#000',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxte_hotspot_settings',
                'mobile_options' => true,
                'hover' => 'tabs',
            ),
            'hotspot_icon_color' => array(
                'label' => esc_html__('Icon Color', 'et_builder'),
                'type' => 'color-alpha',
                'custom_color' => true,
                'default' => '#fff',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxte_hotspot_settings',
                'mobile_options' => true,
                'hover' => 'tabs',
                'show_if' => array(
                    'tooltip_use_hotspot_icon' => 'on',
                ),
            ),
            'hotspot_icon_size' => array(
                'label' => esc_html__('Icon Size', 'et_builder'),
                'description' => esc_html__('Adjust the size of the icon.', 'et_builder'),
                'type' => 'range',
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxte_hotspot_settings',
                'allowed_units' => array('em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'default' => '22px',
                'default_unit' => 'px',
                'default_on_front' => '',
                'allow_empty' => true,
                'range_settings' => array(
                    'min' => '0',
                    'max' => '100',
                    'step' => '1',
                ),
                'mobile_options' => true,
                'hover' => 'tabs',
                'show_if' => array(
                    'tooltip_use_hotspot_icon' => 'on',
                ),
            ),
            'hotspot_padding' => array(
                'label' => esc_html__('Hotspot', 'et_builder'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'tooltip_padding' => array(
                'label' => esc_html__('Tooltip', 'et_builder'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'tooltip_text_margin' => array(
                'label' => esc_html__('Tooltip Text Margin', 'et_builder'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'tooltip_text_padding' => array(
                'label' => esc_html__('Tooltip Text Padding', 'et_builder'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'tooltip_desc_margin' => array(
                'label' => esc_html__('Description Margin', 'et_builder'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'tooltip_desc_padding' => array(
                'label' => esc_html__('Description Padding', 'et_builder'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'tooltip_image_margin' => array(
                'label' => esc_html__('Tooltip Image Margin', 'et_builder'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'tooltip_image_padding' => array(
                'label' => esc_html__('Tooltip Image Padding', 'et_builder'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
		);
	}

	public function render( $attrs, $content, $render_slug ) {
		
		$multi_view = et_pb_multi_view_options($this);
		$content = $this->content;

		$image = "";
        if($multi_view->has_value('tooltip_image')) {
            $image = $multi_view->render_element(array(
                'tag' => 'img',
                'attrs' => array(
                    'src' => '{{tooltip_image}}',
					'alt' => '{{tooltip_image_alt}}',
					'class' => 'dnxte-hostpot-hotspots-minimage'
                ),
            ));
		}

		// Icon Settings
        $icon_color = $this->props['hotspot_icon_color'];
        $icon_color_values = et_pb_responsive_options()->get_property_values($this->props, 'hotspot_icon_color');
        $icon_color_tablet = isset($icon_color_values['tablet']) ? $icon_color_values['tablet'] : '';
        $icon_color_phone = isset($icon_color_values['phone']) ? $icon_color_values['phone'] : '';
        $icon_color_hover = $this->get_hover_value('hotspot_icon_color');
        
        $icon_size = $this->props['hotspot_icon_size'] ? $this->props['hotspot_icon_size'] : esc_attr('22px');
        $icon_size_values = et_pb_responsive_options()->get_property_values($this->props, 'hotspot_icon_size');
        $icon_size_tablet = isset($icon_size_values['tablet']) ? $icon_size_values['tablet'] : '';
        $icon_size_phone = isset($icon_size_values['phone']) ? $icon_size_values['phone'] : '';
        $icon_size_hover = $this->get_hover_value('hotspot_icon_size');

        if ("" !== $icon_color || "" !== $icon_size) {
            $icon_style = sprintf('color: %1$s;font-size:%2$s;', $icon_color, $icon_size);
            $icon_style_tablet = sprintf('color: %1$s;font-size: %2$s;', $icon_color_tablet, $icon_size_tablet);
            $icon_style_phone = sprintf('color: %1$s;font-size: %2$s;', $icon_color_phone, $icon_size_phone);
            $icon_style_hover = "";

            if (et_builder_is_hover_enabled('hotspot_icon_color', $this->props)) {
                $icon_style_hover = sprintf('color: %1$s;font-size: %2$s;', $icon_color_hover, $icon_size_hover);
            }

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte-hotspot_icon",
                'declaration' => $icon_style,
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte-hotspot_icon",
                'declaration' => $icon_style_tablet,
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte-hotspot_icon",
                'declaration' => $icon_style_phone,
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));

            if ("" !== $icon_style_hover) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => $this->add_hover_to_order_class("%%order_class%% .dnxte-hotspot_icon:hover"),
                    'declaration' => $icon_style_hover,
                ));
            }
        }
        // Icon Settings
		
		// Hotspot background color
        $hotspot_bg = $this->props['hotspot_bg'];
        $hotspot_bg_values = et_pb_responsive_options()->get_property_values($this->props, 'hotspot_bg');
        $hotspot_bg_tablet = isset($hotspot_bg_values['tablet']) ? $hotspot_bg_values['tablet'] : '';
        $hotspot_bg_phone = isset($hotspot_bg_values['phone']) ? $hotspot_bg_values['phone'] : '';
        $hotspot_bg_hover = $this->get_hover_value('hotspot_bg');

        if ("" !== $hotspot_bg) {
            $hotspot_bg_style = sprintf('background-color: %1$s;', esc_attr__($hotspot_bg, 'et_builder'));
            $hotspot_bg_style_tablet = sprintf('background-color: %1$s', esc_attr__($hotspot_bg_tablet, 'et_builder'));
            $hotspot_bg_style_phone = sprintf('background-color: %1$s', esc_attr__($hotspot_bg_phone, 'et_builder'));
            $hotspot_bg_style_hover = "";

            if (et_builder_is_hover_enabled('hotspot_bg', $this->props)) {
                $hotspot_bg_style_hover = sprintf('background-color: %1$s;', esc_attr__($hotspot_bg_hover, 'et_builder'));
            }

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte-hostpot-hotspots__wrapper",
                'declaration' => $hotspot_bg_style,
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte-hostpot-hotspots__wrapper",
                'declaration' => $hotspot_bg_style_tablet,
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte-hostpot-hotspots__wrapper",
                'declaration' => $hotspot_bg_style_phone,
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));

            if ("" !== $hotspot_bg_style_hover) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => $this->add_hover_to_order_class("%%order_class%% .dnxte-hostpot-hotspots__wrapper:hover"),
                    'declaration' => $hotspot_bg_style_hover,
                ));
            }
        }
        // Hotspot background color end

        // Hotspot background color
        $hotspot_wave_color = $this->props['hotspot_wave_color'];
        $hotspot_wave_color_values = et_pb_responsive_options()->get_property_values($this->props, 'hotspot_wave_color');
        $hotspot_wave_color_tablet = isset($hotspot_wave_color_values['tablet']) ? $hotspot_wave_color_values['tablet'] : '';
        $hotspot_wave_color_phone = isset($hotspot_wave_color_values['phone']) ? $hotspot_wave_color_values['phone'] : '';
        $hotspot_wave_color_hover = $this->get_hover_value('hotspot_wave_color');

        if ("" !== $hotspot_wave_color) {
            $hotspot_wave_color_style = sprintf('background-color: %1$s;', esc_attr__($hotspot_wave_color, 'et_builder'));
            $hotspot_wave_color_style_tablet = sprintf('background-color: %1$s', esc_attr__($hotspot_wave_color_tablet, 'et_builder'));
            $hotspot_wave_color_style_phone = sprintf('background-color: %1$s', esc_attr__($hotspot_wave_color_phone, 'et_builder'));
            $hotspot_wave_color_style_hover = "";

            if (et_builder_is_hover_enabled('hotspot_wave_color', $this->props)) {
                $hotspot_wave_color_style_hover = sprintf('background-color: %1$s;', esc_attr__($hotspot_wave_color_hover, 'et_builder'));
            }

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte-hostpot-hotspots__wrapper:before",
                'declaration' => $hotspot_wave_color_style,
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte-hostpot-hotspots__wrapper:before",
                'declaration' => $hotspot_wave_color_style_tablet,
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte-hostpot-hotspots__wrapper:before",
                'declaration' => $hotspot_wave_color_style_phone,
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));

            if ("" !== $hotspot_wave_color_style_hover) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => $this->add_hover_to_order_class("%%order_class%% .dnxte-hostpot-hotspots__wrapper:hover::before"),
                    'declaration' => $hotspot_wave_color_style_hover,
                ));
            }
        }
        // Hotspot background color end
        $this->apply_css( $render_slug );
		return sprintf(
			'<div class="dnxte-hostpot-hotspots-wrapper">
			%2$s
				<div class="dnxte-hostpot-hotspots-container">
					%1$s
				</div>
			</div>
			',$content,
			  $image
		);
    }
    
    public function apply_css( $render_slug ) {
        Common::dnxt_set_style($render_slug, $this->props, "hotspot_padding", "%%order_class%% .dnxte-hostpot-hotspots__wrapper", "padding", true);
        Common::dnxt_set_style($render_slug, $this->props, "tooltip_padding", "%%order_class%% .dnxte-hostpot-tooltip-text", "padding", true);

        Common::dnxt_set_style($render_slug, $this->props, "tooltip_text_margin", "%%order_class%% .dnxte_tooltip_text", "margin", false);
        Common::dnxt_set_style($render_slug, $this->props, "tooltip_text_padding", "%%order_class%% .dnxte_tooltip_text", "padding", false);

        Common::dnxt_set_style($render_slug, $this->props, "tooltip_desc_margin", "%%order_class%% .dnxte-tooltip-content", "margin", false);
        Common::dnxt_set_style($render_slug, $this->props, "tooltip_desc_padding", "%%order_class%% .dnxte-tooltip-content", "padding", false);

        Common::dnxt_set_style($render_slug, $this->props, "tooltip_image_margin", "%%order_class%% .dnxte-tooltip-image-container", "margin", false);
        Common::dnxt_set_style($render_slug, $this->props, "tooltip_image_padding", "%%order_class%% .dnxte-tooltip-image-container", "padding", false);
        
    }
}

new DiviNextTooltip;
