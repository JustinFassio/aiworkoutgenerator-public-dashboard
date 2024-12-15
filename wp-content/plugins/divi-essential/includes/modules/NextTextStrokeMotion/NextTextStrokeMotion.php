<?php

class Next_Text_Stroke_Motion extends ET_Builder_Module
{

    public $slug = 'dnxte_text_stroke_motion';
    public $vb_support = 'on';

    protected $module_credits = array(
        'module_uri' => 'https://www.diviessential.com/divi-text-stroke-motion/',
        'author' => 'Divi Next',
        'author_uri' => 'www.divinext.com',
    );

    public function init()
    {
        $this->name        = esc_html__('Next Text Stroke Motion', 'et_builder');
        $this->icon_path   = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->folder_name = 'et_pb_divi_essential';

        $this->settings_modal_toggles = array(
            'advanced' => array(
                'toggles' => array(
                    'dnxt_text_font' => array(
                        "title" => esc_html__('Fonts', 'et_builder'),
                    ),
                    'dnxt_text_color' => array(
                        'title' => esc_html__('Colors', 'et_builder'),
                        'sub_toggles' => array(
                            'sub_toggle_color' => array(
                                'name' => esc_html__('Single', 'et_builder'),
                            ),
                            'sub_toggle_multi' => array(
                                'name' => esc_html__('Multi', 'et_builder'),
                            ),
                            'sub_toggle_fill' => array(
                                'name' => esc_html__('Fill', 'et_builder'),
                            ),
                        ),
                        'tabbed_subtoggles' => true,
                    ),
                    'dnxt_stroke_settings' => array(
                        'title' => esc_html__('Stroke Settings', 'et_builder'),
                    ),
                    'custom_spacing' => array(
                        'title' => esc_html__('Stroke Spacing', 'et_builder'),
                    ),
                ),
            ),
        );
    }

    public function get_advanced_fields_config()
    {
        $advanced_fields = array();
        $advanced_fields['fonts'] = false;
        $advanced_fields = array(
            'fonts' => array(
                'dnxt_stroke_motion_fonts' => array(
                    'label' => esc_html__('', 'et_builder'),
                    'toggle_slug' => 'dnxt_text_font',
                    'tab_slug' => 'advanced',
                    'css' => array(
                        'main' => "%%order_class%% .dnxt-text-stroke-animation-text",
                    ),
                    'font_size' => array(
                        'default' => '100px',
                    ),
                    'text_align' => array(
                        'mobile_options' => false,
                    ),
                ),
            ),
            'text' => false,

        );
        return $advanced_fields;
    }
    public function get_fields()
    {
        return array(
            //Text Field
            'stroke_text' => array(
                'label' => esc_html__('Animation Text', 'et_builder'),
                'type' => 'text',
                'dynamic_content' => 'text',
                'option_category' => 'basic_option',
                'description' => esc_html__('Animation text entered here will appear inside the module.', 'et_builder'),
                'toggle_slug' => 'main_content',
            ),
            // Color Tab Single Show Hide
            'btn_single_show_hide' => array(
                'label' => esc_html__('Single Color', 'et_builder'),
                'type' => 'yes_no_button',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxt_text_color',
                'sub_toggle' => 'sub_toggle_color',
                'options' => array(
                    'on' => esc_html__('Yes', 'et_builder'),
                    'off' => esc_html__('No', 'et_builder'),
                ),
                'affects' => array(
                    'color_tab_single',
                ),
                'default_on_front' => 'off',
            ),
            // Button Single Color
            'color_tab_single' => array(
                'label' => esc_html__('Select Single Color', 'et_builder'),
                'type' => 'color-alpha',
                'description' => esc_html__('Content entered here will appear inside the module.', 'et_builder'),
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxt_text_color',
                'sub_toggle' => 'sub_toggle_color',
                'hover' => 'tabs',
                'default' => '#0077FF',
                'depends_show_if' => 'on',
            ),
            // Button Multi Color
            'btn_multi_show_hide' => array(
                'label' => esc_html__('Multi Color', 'et_builder'),
                'type' => 'yes_no_button',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxt_text_color',
                'sub_toggle' => 'sub_toggle_multi',
                'options' => array(
                    'on' => esc_html__('Yes', 'et_builder'),
                    'off' => esc_html__('No', 'et_builder'),
                ),
                'affects' => array(
                    'color_tab_multi_one',
                    'color_tab_multi_two',
                    'color_tab_multi_three',
                    'color_tab_multi_four',
                    'color_tab_multi_five',
                ),
                'default_on_front' => 'on',
            ),

            // Select Color  Multi One
            'color_tab_multi_one' => array(
                'label' => esc_html__('Select Color One', 'et_builder'),
                'type' => 'color-alpha',
                'description' => esc_html__('Content entered here will appear inside the module.', 'et_builder'),
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxt_text_color',
                'sub_toggle' => 'sub_toggle_multi',
                'hover' => 'tabs',
                'default' => '#0077FF',
            ),

            // Select Color Multi Two
            'color_tab_multi_two' => array(
                'label' => esc_html__('Select Color Two', 'et_builder'),
                'type' => 'color-alpha',
                'description' => esc_html__('Content entered here will appear inside the module.', 'et_builder'),
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxt_text_color',
                'sub_toggle' => 'sub_toggle_multi',
                'hover' => 'tabs',
                'default' => '#772ADB',
            ),
            // Select Color Multi Three
            'color_tab_multi_three' => array(
                'label' => esc_html__('Select Color Three', 'et_builder'),
                'type' => 'color-alpha',
                'description' => esc_html__('Content entered here will appear inside the module.', 'et_builder'),
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxt_text_color',
                'sub_toggle' => 'sub_toggle_multi',
                'hover' => 'tabs',
                'default' => '#00e1ff',
            ),
            // Select Color Multi Four
            'color_tab_multi_four' => array(
                'label' => esc_html__('Select Color Four', 'et_builder'),
                'type' => 'color-alpha',
                'description' => esc_html__('Content entered here will appear inside the module.', 'et_builder'),
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxt_text_color',
                'sub_toggle' => 'sub_toggle_multi',
                'hover' => 'tabs',
                'default' => '#ff23da',
            ),
            // Select Color Multi Five
            'color_tab_multi_five' => array(
                'label' => esc_html__('Select Color Five', 'et_builder'),
                'type' => 'color-alpha',
                'description' => esc_html__('Content entered here will appear inside the module.', 'et_builder'),
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxt_text_color',
                'sub_toggle' => 'sub_toggle_multi',
                'hover' => 'tabs',
                'default' => '#FDB731',
            ),
            // Color Tab Fill
            'color_tab_fill' => array(
                'label' => esc_html__('Select Fill Color', 'et_builder'),
                'type' => 'color-alpha',
                'description' => esc_html__('Content entered here will appear inside the module.', 'et_builder'),
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxt_text_color',
                'sub_toggle' => 'sub_toggle_fill',
                'hover' => 'tabs',
                'default' => 'none',
            ),
            // Stroke Width
            'dnxt_stroke_width' => array(
                'label' => esc_html__('Stroke Width', 'et_builder'),
                'type' => 'range',
                'description' => esc_html__('Adjust the width of the stroke applied to the text.', 'et_builder'),
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxt_stroke_settings',
                'range_settings' => array(
                    'step' => 1,
                    'min' => 1,
                    'max' => 100,
                ),
                'default' => '6px',
                'fixed_unit' => 'px',
                'validate_unit' => true,
            ),
            // Stroke Dash
            'dnxt_stroke_dash' => array(
                'label' => esc_html__('Stroke Dash', 'et_builder'),
                'type' => 'range',
                'tab_slug' => 'advanced',
                'description' => esc_html__('Adjust the shape of each line for the animated stroke text.', 'et_builder'),
                'toggle_slug' => 'dnxt_stroke_settings',
                'range_settings' => array(
                    'step' => 1,
                    'min' => 1,
                    'max' => 100,
                ),
                'default' => '5%',
                'fixed_unit' => '%',
                'validate_unit' => true,
            ),
            // Stroke Gap
            'dnxt_stroke_gap' => array(
                'label' => esc_html__('Stroke Gap', 'et_builder'),
                'type' => 'range',
                'description' => esc_html__('Adjust the space between each line of the animated stroke text.', 'et_builder'),
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxt_stroke_settings',
                'range_settings' => array(
                    'step' => 1,
                    'min' => 1,
                    'max' => 100,
                ),
                'default' => '27%',
                'fixed_unit' => '%',
                'validate_unit' => true,
            ),
            // Stroke Dashoffset
            'dnxt_stroke_dashoffset' => array(
                'label' => esc_html__('Stroke Dashoffset', 'et_builder'),
                'type' => 'range',
                'description' => esc_html__('Adjust the speed of the animated stroke text.', 'et_builder'),
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxt_stroke_settings',
                'range_settings' => array(
                    'step' => 1,
                    'min' => 0,
                    'max' => 100,
                ),
                'default' => '0%',
                'fixed_unit' => '%',
                'validate_unit' => true,
            ),

        );
    }

    public function render($attrs, $content, $render_slug)
    {
        $text_value = $this->props['stroke_text'];

        $text_anchor = '';
        $dominant_baseline = '';

        $text_anchor_x = '';
        $text_anchor_y = '';
        $_index = uniqid();

        // $this->props['dnxt_stroke_fonts_text_align'] = "";
        // Text Alignment Value
        switch ($this->props['dnxt_stroke_motion_fonts_text_align']) {
            case 'left':{
                    $text_anchor = 'before-edge';
                    $text_anchor_x = '0%';
                    $text_anchor_y = '0%';
                    $dominant_baseline = 'text-before-edge';
                    break;
                }
            case 'right':{
                    $text_anchor = 'end';
                    $text_anchor_x = '100%';
                    $text_anchor_y = '100%';
                    $dominant_baseline = 'text-after-edge';

                    break;
                }
            case 'center':{
                    $text_anchor = 'middle';
                    $text_anchor_x = '50%';
                    $text_anchor_y = '50%';
                    $dominant_baseline = 'middle';
                    break;
                }
            default:{
                    $text_anchor = 'middle';
                    $text_anchor_x = '50%';
                    $text_anchor_y = '50%';
                    $dominant_baseline = 'middle';
                    break;
                }
        }

        $this->apply_css($render_slug);

        return sprintf(
            '<div class="text_stroke_svg_selector">
			<svg>
			<symbol id="%5$s">
				<text text-anchor="%1$s" dominant-baseline="%6$s" x="%2$s" y="%3$s">
				%4$s
				</text>
			</symbol>
			<g>
				<use href="#%5$s" class="dnxt-text-stroke-animation-text"></use>
				<use href="#%5$s" class="dnxt-text-stroke-animation-text"></use>
				<use href="#%5$s" class="dnxt-text-stroke-animation-text"></use>
				<use href="#%5$s" class="dnxt-text-stroke-animation-text"></use>
				<use href="#%5$s" class="dnxt-text-stroke-animation-text"></use>
			</g>
		</svg>
		</div>',
            $text_anchor,
            $text_anchor_x,
            $text_anchor_y,
            $text_value,
            $_index,
            $dominant_baseline
        );
    }

    public function apply_css($render_slug)
    {

        //Single Color Tab
        if ('off' !== $this->props['btn_single_show_hide'] || 'off' === $this->props['btn_multi_show_hide']) {

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .dnxt-text-stroke-animation-text',
                'declaration' => "stroke: {$this->props['color_tab_single']} !important;",
            ));
        } else {

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .dnxt-text-stroke-animation-text',
                'declaration' => "stroke: {$this->props['color_tab_single']};",
            ));

        }

        //Multi Color Tab
        if ('off' !== $this->props['btn_multi_show_hide'] || 'off' === $this->props['btn_single_show_hide']) {

            if ('' !== $this->props['color_tab_multi_one']) {

                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => '%%order_class%% .dnxt-text-stroke-animation-text:nth-child(1)',
                    'declaration' => "stroke:{$this->props['color_tab_multi_one']}; animation-delay: -1s;",
                ));
            }
            if ('' !== $this->props['color_tab_multi_two']) {

                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => '%%order_class%% .dnxt-text-stroke-animation-text:nth-child(2)',
                    'declaration' => "stroke:{$this->props['color_tab_multi_two']}; animation-delay: -2s;",
                ));
            }
            if ('' !== $this->props['color_tab_multi_three']) {

                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => '%%order_class%% .dnxt-text-stroke-animation-text:nth-child(3)',
                    'declaration' => "stroke:{$this->props['color_tab_multi_three']}; animation-delay: -3s;",
                ));
            }

            if ('' !== $this->props['color_tab_multi_four']) {

                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => '%%order_class%% .dnxt-text-stroke-animation-text:nth-child(4)',
                    'declaration' => "stroke:{$this->props['color_tab_multi_four']}; animation-delay: -4s;",
                ));
            }

            if ('' !== $this->props['color_tab_multi_five']) {

                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => '%%order_class%% .dnxt-text-stroke-animation-text:nth-child(5)',
                    'declaration' => "stroke:{$this->props['color_tab_multi_five']}; animation-delay: -5s;",
                ));
            }
        }

        // Fill Color Tab
        if ('' !== $this->props['color_tab_fill']) {

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .dnxt-text-stroke-animation-text',
                'declaration' => "fill:{$this->props['color_tab_fill']};",
            ));
        }
        //Stroke Settings
        if (
            '' !== $this->props['dnxt_stroke_width'] ||
            '' !== $this->props['dnxt_stroke_dash'] ||
            '' !== $this->props['dnxt_stroke_gap'] ||
            '' !== $this->props['dnxt_stroke_dashoffset']
        ) {
            ET_Builder_Element::set_style($render_slug, array(

                'selector' => '%%order_class%% .dnxt-text-stroke-animation-text',
                'declaration' => "stroke-width: {$this->props['dnxt_stroke_width']};
									  stroke-dasharray: {$this->props['dnxt_stroke_dash']} {$this->props['dnxt_stroke_gap']};
									  stroke-dashoffset: {$this->props['dnxt_stroke_dashoffset']};
									",
            ));
        }
        $this->props['dnxt_stroke_fonts_line_height'] = "";
        //SVG height
        if ('' !== $this->props['dnxt_stroke_fonts_line_height']) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .text_stroke_svg_selector svg',
                'declaration' => "height: {$this->props['dnxt_stroke_fonts_line_height']};",
            ));
        }
    }
}

new Next_Text_Stroke_Motion;
