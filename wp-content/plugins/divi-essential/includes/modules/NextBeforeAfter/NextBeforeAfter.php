<?php

class Next_Before_After extends ET_Builder_Module {

    public $slug = 'dnxte_before_after';
    public $vb_support = 'on';

    protected $module_credits = array(
        'module_uri' => 'https://www.diviessential.com/divi-before-after-module/',
        'author'     => 'Divi Next',
        'author_uri' => 'www.divinext.com',
    );

    public function init() {
        $this->name        = esc_html__('Next Before After', 'et_builder');
        $this->icon_path   = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->folder_name = 'et_pb_divi_essential';
        
        $this->settings_modal_toggles = array(
            'general'    => array(
                'toggles' => array(
                    'dnxte_image' => array(
                        'title'             => esc_html__('Image', 'et_builder'),
                        'sub_toggles'       => array(
                            'sub_toggle_before' => array(
                                'name' => esc_html__('Before', 'et_builder'),
                            ),
                            'sub_toggle_after'  => array(
                                'name' => esc_html__('After', 'et_builder'),
                            ),
                        ),
                        'tabbed_subtoggles' => true,
                    ),
                ),
            ),
            'advanced'   => array(
                'toggles' => array(
                    'dnxte_slider'  => esc_html__('Slider', 'et_builder'),
                    'dnxte_labels'  => esc_html__('Labels', 'et_builder'),
                    'dnxte_overlay' => esc_html__('Overlay', 'et_builder'),

                ),
            ),
            'custom_css' => array(
                'toggles' => array(),
            ),
        );
    }

    public function get_advanced_fields_config() {
        return array(
            'text'  => false,
            'fonts' => false
        );
    }

    public function get_fields() {
        $fields = array(
            'dnxte_before_image'     => array(
                'label'              => esc_html__('Before Image', 'et_builder'),
                'type'               => 'upload',
                'option_category'    => 'basic_option',
                'upload_button_text' => esc_attr__('Upload an image', 'et_builder'),
                'choose_text'        => esc_attr__('Choose an Image', 'et_builder'),
                'update_text'        => esc_attr__('Set As Image', 'et_builder'),
                'description'        => esc_html__('Upload an image to display in the module.', 'et_builder'),
                'toggle_slug'        => 'dnxte_image',
                'sub_toggle'         => 'sub_toggle_before',
				'dynamic_content'    => 'image',
                'mobile_options'     => true,
                'hover'              => 'tabs',
            ),
            'dnxte_before_image_alt' => array(
                'label'       		 => esc_html__('Before Image Alt Text', 'et_builder'),
				'type'        		 => 'text',
				'dynamic_content'    => 'text',
                'description' 		 => esc_html__('Define the HTML ALT text for the image.', 'et_builder'),
                'toggle_slug' 		 => 'dnxte_image',
                'sub_toggle'  		 => 'sub_toggle_before',
                'dynamic_content'    => 'text'
            ),
            'dnxte_after_image'      => array(
                'label'              => esc_html__('After Image', 'et_builder'),
                'type'               => 'upload',
                'option_category'    => 'basic_option',
                'upload_button_text' => esc_attr__('Upload an image', 'et_builder'),
                'choose_text'        => esc_attr__('Choose an Image', 'et_builder'),
                'update_text'        => esc_attr__('Set As Image', 'et_builder'),
                'description'        => esc_html__('Upload an image to display in the module.', 'et_builder'),
                'toggle_slug'        => 'dnxte_image',
                'sub_toggle'         => 'sub_toggle_after',
                'dynamic_content'    => 'image',
                'mobile_options'     => true,
                'hover'              => 'tabs',
            ),
            'dnxte_after_image_alt'  => array(
                'label'       		 => esc_html__('Before Image Alt Text', 'et_builder'),
                'description' 		 => esc_html__('Define the HTML ALT text for the image.', 'et_builder'),
				'type'        		 => 'text',
				'dynamic_content'    => 'text',
                'toggle_slug' 		 => 'dnxte_image',
                'sub_toggle'  		 => 'sub_toggle_after',
                'dynamic_content'    => 'text'
            ),
            'dnxte_before_label'    => array(
                'label'             => esc_html__('Before Label', 'et_builder'),
                'description'       => esc_html__('The label for the before image.', 'et_builder'),
                'default'           => esc_html__('Before', 'et_builder'),
                'type'              => 'text',
                'option_category'   => 'basic_option',
                'toggle_slug'       => 'dnxte_labels',
            ),
            'dnxte_after_label'    => array(
                'label'            => esc_html__('After Label', 'et_builder'),
                'description'      => esc_html__('The label for the after image.', 'et_builder'),
                'default'          => esc_html__('After', 'et_builder'),
                'type'             => 'text',
                'option_category'  => 'basic_option',
                'toggle_slug'      => 'dnxte_labels',
            ),
            'dnxte_show_labels'   => array(
                'label'           => esc_html__('Always Show Label', 'et_builder'),
                'description'     => esc_html__('Whether to always show the labels or only show them on hover.', 'et_builder'),
                'type'            => 'yes_no_button',
                'option_category' => 'basic_option',
                'toggle_slug'     => 'dnxte_labels',
                'tab_slug'        => 'advanced',
                'default'         => 'off',
                'options'         => array(
                    'off' => esc_html__('Off', 'et_builder'),
                    'on'  => esc_html__('On', 'et_builder'),
                ),
            ),
            'dnxte_before_label_bg_color'    => array(
                'label'         => esc_html__('Before Label Bg Color', 'et_builder'),
                'type'          => 'color-alpha',
                'default'       => "rgba(255, 255, 255, 0.2)",
                'toggle_slug'   => 'dnxte_labels',
                'tab_slug'      => 'advanced',
                'mobile_options'=> true,
                'hover'         => 'tabs',
            ),
            'dnxte_after_label_bg_color'     => array(
                'label'              => esc_html__('After Label Bg Color', 'et_builder'),
                'type'               => 'color-alpha',
                'default'            => "rgba(255, 255, 255, 0.2)",
                'toggle_slug'        => 'dnxte_labels',
                'tab_slug'           => 'advanced',
                'mobile_options'     => true,
                'hover'              => 'tabs',
            ),
            /* Slider Settings Overlay */
            'dnxte_enable_overlay'  => array(
                'label'       => esc_html__('Enable Overlay', 'et_builder'),
                'description' => esc_html__('Whether or not to show the overlay on hover.', 'et_builder'),
                'type'        => 'yes_no_button',
                'toggle_slug' => 'dnxte_overlay',
                'tab_slug'    => 'advanced',
                'default'     => 'on',
                'options'     => array(
                    'off' => esc_html__('Off', 'et_builder'),
                    'on'  => esc_html__('On', 'et_builder'),
                ),
                'affects'         => array(
					'dnxte_overlay_color'
				),
				'default_on_front' => 'on',
            ),
            'dnxte_overlay_color'=> array(
                'label'          => esc_html__('Overlay  Color', 'et_builder'),
                'type'           => 'color-alpha',
                'default'        => "rgba(0, 0, 0, 0.5)",
                'toggle_slug'    => 'dnxte_overlay',
                'tab_slug'       => 'advanced',
                'mobile_options' => true,
                'hover'          => 'tabs',
                'depends_show_if'=> 'on',
            ),
            'dnxte_orientation'     => array(
                'label'           => esc_html__('Slider Direction', 'et_builder'),
                'description'     => esc_html__('The direction of the slider.', 'et_builder'),
                'type'            => 'select',
                'option_category' => 'basic_option',
                'options'         => array(
                    'horizontal'  => 'Horizontal',
                    'vertical'    => 'Vertical',
                ),
                'toggle_slug'     => 'dnxte_slider',
                'tab_slug'        => 'advanced',
                'default'         => 'horizontal',
            ),
            'dnxte_offset'        => array(
                'label'           => esc_html__('Slider Start Offset', 'et_builder'),
                'description'     => esc_html__('The initial offset of the slider in percent.', 'et_builder'),
                'type'            => 'range',
                'option_category' => 'layout',
                'default'         => '0.7',
                'toggle_slug'     => 'dnxte_slider',
                'tab_slug'        => 'advanced',
                'unitless'        => true,
                'range_settings'  => array(
                    'min'  => '0',
                    'max'  => '1',
                    'step' => '0.1',
                ),
            ),
            'dnxte_move_hover'  => array(
                'label'       => esc_html__('Move on Hover', 'et_builder'),
                'description' => esc_html__('Whether or not to enable move on hover.', 'et_builder'),
                'type'        => 'yes_no_button',
                'toggle_slug' => 'dnxte_slider',
                'tab_slug'    => 'advanced',
                'options'     => array(
                    'on'  => esc_html__('On', 'et_builder'),
                    'off' => esc_html__('Off', 'et_builder'),
                ),
				'default_on_front' => 'off',
            ),
            'dnxte_move_with_handle'  => array(
                'label'       => esc_html__('Move with Handle', 'et_builder'),
                'description' => esc_html__('Whether or not to enable move with handle only.', 'et_builder'),
                'type'        => 'yes_no_button',
                'toggle_slug' => 'dnxte_slider',
                'tab_slug'    => 'advanced',
                'options'     => array(
                    'on'  => esc_html__('On', 'et_builder'),
                    'off' => esc_html__('Off', 'et_builder'),
                ),
				'default_on_front' => 'on',
            ),
            'dnxte_move_with_click'  => array(
                'label'       => esc_html__('Click to Move', 'et_builder'),
                'description' => esc_html__('Whether or not to enable click to move.', 'et_builder'),
                'type'        => 'yes_no_button',
                'toggle_slug' => 'dnxte_slider',
                'tab_slug'    => 'advanced',
                'options'     => array(
                    'on'  => esc_html__('On', 'et_builder'),
                    'off' => esc_html__('Off', 'et_builder'),
                ),
				'default_on_front' => 'on',
            ),
            'dnxte_slider_color' => array(
                'label'          => esc_html__('Slider Color', 'et_builder'),
                'type'           => 'color-alpha',
                'default'        => "#ffffff",
                'toggle_slug'    => 'dnxte_slider',
                'tab_slug'       => 'advanced',
                'mobile_options' => true,
                'hover'          => 'tabs',
            ),
            'dnxte_slider_handle_color'=> array(
                'label'          => esc_html__('Handle Color', 'et_builder'),
                'type'           => 'color-alpha',
                'default'        => "#ffffff",
                'toggle_slug'    => 'dnxte_slider',
                'tab_slug'       => 'advanced',
                'mobile_options' => true,
                'hover'          => 'tabs',
            ),
            'dnxte_slider_handle_bg_color'=> array(
                'label'             => esc_html__('Handle BG Color', 'et_builder'),
                'type'              => 'color-alpha',
                'toggle_slug'       => 'dnxte_slider',
                'tab_slug'          => 'advanced',
                'mobile_options'    => true,
                'hover'             => 'tabs',
            ),
            'dnxte_slider_handle_icon_color' => array(
                'label'                => esc_html__('Handle Icon Color', 'et_builder'),
                'type'                 => 'color-alpha',
                'toggle_slug'          => 'dnxte_slider',
                'tab_slug'             => 'advanced',
                'default'              => "#ffffff",
                'mobile_options'       => true,
                'hover'                => 'tabs',
            ),
        );

        return $fields;
    }

    public function render($attrs, $content, $render_slug) {
        wp_enqueue_script( 'dnext_event_move' );
        wp_enqueue_script( 'dnext_twentytwenty_js' );
        wp_enqueue_script( 'dnext_comparison_slide' );
        wp_enqueue_style( 'dnext_twentytwenty_css' );
		$multi_view             = et_pb_multi_view_options($this);
        $dnxte_before_label	    = $this->props['dnxte_before_label'];
        $dnxte_after_label	    = $this->props['dnxte_after_label'];
        $dnxte_orientation	    = $this->props['dnxte_orientation'];
        $dnxte_offset	        = $this->props['dnxte_offset'];
        $dnxte_enable_overlay   = $this->props["dnxte_enable_overlay"];
        $dnxte_move_on_hover    = $this->props["dnxte_move_hover"];
        $dnxte_move_with_handle = $this->props["dnxte_move_with_handle"];
        $dnxte_move_with_click  = $this->props["dnxte_move_with_click"];

		// Before Background Color
		$dnxte_before_label_bg_color_values = et_pb_responsive_options()->get_property_values($this->props, 'dnxte_before_label_bg_color');
		et_pb_responsive_options()->generate_responsive_css($dnxte_before_label_bg_color_values, '%%order_class%% .twentytwenty-before-label:before, .twentytwenty-before-label:before', 'background', $render_slug, '', 'background');
        
        // After Background Color
		$dnxte_after_label_bg_color_values = et_pb_responsive_options()->get_property_values($this->props, 'dnxte_after_label_bg_color');
		et_pb_responsive_options()->generate_responsive_css($dnxte_after_label_bg_color_values, '%%order_class%% .twentytwenty-after-label:before, .twentytwenty-after-label:before', 'background', $render_slug, '', 'background');
        
        // Slider Background Color
		$dnxte_slider_color_values = et_pb_responsive_options()->get_property_values($this->props, 'dnxte_slider_color');
		et_pb_responsive_options()->generate_responsive_css($dnxte_slider_color_values, '%%order_class%% .twentytwenty-handle:before, %%order_class%% .twentytwenty-handle:after', 'background', $render_slug, '!important', 'background');

        //Before Image
        $dnxte_before_image = "";
        if ($multi_view->has_value('dnxte_before_image')) {
            $dnxte_before_image = $multi_view->render_element(array(
                'tag' => 'div',
                'content' => $multi_view->render_element(array(
                    'tag' => 'img',
                    'attrs' => array(
                        'src' => '{{dnxte_before_image}}',
                        'alt' => '{{dnxte_before_image_alt}}',
                    ),
                )),
                'attrs' => array(
                    'class' => 'dnxte_bf_img',
                ),
                'classes' => array(
                    'et-svg' => array(
                        'dnxte_before_image' => true,
                    ),
                ),
            ));
		}

        //After Image
        $dnxte_after_image = "";
        if ($multi_view->has_value('dnxte_after_image')) {
            $dnxte_after_image = $multi_view->render_element(array(
                'tag' => 'div',
                'content' => $multi_view->render_element(array(
                    'tag' => 'img',
                    'attrs' => array(
                        'src' => '{{dnxte_after_image}}',
                        'alt' => '{{dnxte_after_image_alt}}',
                    ),
                )),
                'attrs' => array(
                    'class' => 'dnxte_af_img',
                ),
                'classes' => array(
                    'et-svg' => array(
                        'dnxte_after_image' => true,
                    ),
                ),
            ));
        }

        $this->render_css($render_slug);
        
        return sprintf(
            '<div class="dnxtecomparisonslide" data-offset="%6$s" data-orientation="%5$s" data-before-label="%3$s" data-after-label="%4$s" data-overlay="%7$s" data-moveslideronhover="%8$s" data-movewithhandleonly="%9$s" data-clicktomove="%10$s">
				%1$s
				%2$s
			</div>',
			$dnxte_before_image,
            $dnxte_after_image,
            $dnxte_before_label,
            $dnxte_after_label,
            $dnxte_orientation, // #5
            $dnxte_offset,
            $dnxte_enable_overlay,
            $dnxte_move_on_hover,
            $dnxte_move_with_handle,
            $dnxte_move_with_click
        );
    }

    public function render_css($render_slug) {

        if ("on" === $this->props["dnxte_show_labels"]) {
            ET_Builder_Element::set_style($render_slug, [
                'selector'    => "%%order_class%% .dnxtecomparisonslide .twentytwenty-overlay .twentytwenty-before-label, %%order_class%% .dnxtecomparisonslide .twentytwenty-overlay .twentytwenty-after-label",
                'declaration' => "opacity: 1 !important;",
            ]);
        }

        if ("on" === $this->props["dnxte_enable_overlay"]) {
            ET_Builder_Element::set_style($render_slug, [
                'selector'    => "%%order_class%% .twentytwenty-overlay:hover",
                'declaration' => "background: {$this->props['dnxte_overlay_color']};",
            ]);
        }

        ET_Builder_Element::set_style($render_slug, [
            'selector'    => "%%order_class%% .twentytwenty-horizontal .twentytwenty-handle:before",
            'declaration' => "-webkit-box-shadow: 0 3px 0 {$this->props['dnxte_slider_handle_color']}, 0px 0px 12px rgba(51, 51, 51, 0.5);
                            -moz-box-shadow: 0 3px 0 {$this->props['dnxte_slider_handle_color']}, 0px 0px 12px rgba(51, 51, 51, 0.5);
                            box-shadow: 0 3px 0 {$this->props['dnxte_slider_handle_color']}, 0px 0px 12px rgba(51, 51, 51, 0.5);",
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector'    => "%%order_class%% .twentytwenty-horizontal .twentytwenty-handle:after",
            'declaration' => "-webkit-box-shadow: 0 -3px 0 {$this->props['dnxte_slider_handle_color']}, 0px 0px 12px rgba(51, 51, 51, 0.5);
                            -moz-box-shadow: 0 -3px 0 {$this->props['dnxte_slider_handle_color']}, 0px 0px 12px rgba(51, 51, 51, 0.5);
                            box-shadow: 0 -3px 0 {$this->props['dnxte_slider_handle_color']}, 0px 0px 12px rgba(51, 51, 51, 0.5);",
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector'    => "%%order_class%% .twentytwenty-vertical .twentytwenty-handle:before",
            'declaration' => "-webkit-box-shadow: 3px 0 0 {$this->props['dnxte_slider_handle_color']}, 0px 0px 12px rgba(51, 51, 51, 0.5);
                            -moz-box-shadow: 3px 0 0 {$this->props['dnxte_slider_handle_color']}, 0px 0px 12px rgba(51, 51, 51, 0.5);
                            box-shadow: 3px 0 0 {$this->props['dnxte_slider_handle_color']}, 0px 0px 12px rgba(51, 51, 51, 0.5);",
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector'    => "%%order_class%% .twentytwenty-vertical .twentytwenty-handle:after",
            'declaration' => "-webkit-box-shadow: -3px 0 0 {$this->props['dnxte_slider_handle_color']}, 0px 0px 12px rgba(51, 51, 51, 0.5);
                            -moz-box-shadow: -3px 0 0 {$this->props['dnxte_slider_handle_color']}, 0px 0px 12px rgba(51, 51, 51, 0.5);
                            box-shadow: -3px 0 0 {$this->props['dnxte_slider_handle_color']}, 0px 0px 12px rgba(51, 51, 51, 0.5);",
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector'    => "%%order_class%% .twentytwenty-handle",
            'declaration' => "border-color: {$this->props['dnxte_slider_handle_color']};",
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector'    => "%%order_class%% .twentytwenty-handle",
            'declaration' => "background: {$this->props['dnxte_slider_handle_bg_color']};",
        ]);

        //Arrow of handle
        ET_Builder_Element::set_style($render_slug, [
            'selector'    => "%%order_class%% .twentytwenty-left-arrow",
            'declaration' => "border-right-color: {$this->props['dnxte_slider_handle_icon_color']};",
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector'    => "%%order_class%% .twentytwenty-right-arrow",
            'declaration' => "border-left-color: {$this->props['dnxte_slider_handle_icon_color']};",
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector'    => "%%order_class%% .twentytwenty-down-arrow",
            'declaration' => "border-top: 6px solid {$this->props['dnxte_slider_handle_icon_color']};",
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector'    => "%%order_class%% .twentytwenty-up-arrow",
            'declaration' => "border-bottom: 6px solid {$this->props['dnxte_slider_handle_icon_color']};",
        ]);
    }
}

new Next_Before_After;
