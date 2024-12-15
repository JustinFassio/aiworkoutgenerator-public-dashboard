<?php

class Divi_NxteTimeline extends ET_Builder_Module
{
    public $slug = 'dnxte_timeline';
    public $vb_support = 'on';
    public $child_slug = 'dnxte_timeline_child';


    protected $module_credits = array(
        'module_uri' => 'https://www.diviessential.com/divi-timeline/',
        'author' => 'Divi Next',
        'author_uri' => 'www.divinext.com',
    );

    public function init(){
        $this->name        = esc_html__('Next Timeline', 'et_builder');
        $this->icon_path   = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->folder_name = 'et_pb_divi_essential';

        $this->settings_modal_toggles = array(
            'advanced' => array(
                'toggles' => array(
                    'dnxte_title_settings'      => esc_html__( 'Title', 'et_builder'),
                    'dnxte_desc_settings'       => esc_html__( 'Description', 'et_builder'),
                    'dnxte_btn_settings'        => esc_html__( 'Button', 'et_builder'),
                    'dnxte_other_settings'      => esc_html__( 'Other Settings', 'et_builder'),
                    'dnxte_bar_settings'        => esc_html__( 'Timeline Bar', 'et_builder'),
                    'dnxte_identifier_settings' => esc_html__( 'Identifier', 'et_builder'),
                )
            )
        );

        $this->custom_css_fields = array(
            'title' => array(
                'label' => esc_html__('Title', 'et_builder'),
                'selector' => '%%order_class%% .dnxte-timline-heading',
            ),
            'description' => array(
                'label' => esc_html__('Description', 'et_builder'),
                'selector' => '%%order_class%% .dnxte-timline-pra',
            ),
            'button' => array(
                'label' => esc_html__('Button', 'et_builder'),
                'selector' => '%%order_class%% .dnxte-timline-btn-more',
            ),
            'icon' => array(
                'label' => esc_html__('Icon/Image', 'et_builder'),
                'selector' => '%%order_class%% .dnxte-timline-img',
            ),
            'identifier' => array(
                'label' => esc_html__('Identifier', 'et_builder'),
                'selector' => '%%order_class%% .dnxte-timline-date',
            ),
        );
    }

    public function get_advanced_fields_config(){
        return array(
            'text' => false,
            'fonts' => array(
                'title' => array(
                    'label' => esc_html__('Title', 'et_builder'),
                    'css' => array(
                        'main' => "%%order_class%% .dnxte-timline-heading",
                    ),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxte_title_settings',
                ),
                'content' => array(
                    'label' => esc_html__('Content', 'et_builder'),
                    'css' => array(
                        'main' => "%%order_class%% .dnxte-timline-pra",
                    ),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxte_desc_settings',
                ),
                'button' => array(
                    'label' => esc_html__('Button', 'et_builder'),
                    'css' => array(
                        'main' => "%%order_class%% .dnxte-timline-btn-more",
                    ),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxte_btn_settings',
                ),
                'identifier' => array(
                    'label' => esc_html__('Identifier', 'et_builder'),
                    'css' => array(
                        'main' => "%%order_class%% .dnxte-timline-date",
                    ),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxte_identifier_settings',
                ),
            ),
            'borders' => array(
                'title' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => "%%order_class%% .dnxte-timline-heading",
                            'border_styles' => "%%order_class%% .dnxte-timline-heading",
                        ),
                    ),
                    'label_prefix' => esc_html__('Title', 'et_builder'),
                    'toggle_slug' => 'dnxte_title_settings',
                ),
                'description' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => "%%order_class%% .dnxte-timline-pra",
                            'border_styles' => "%%order_class%% .dnxte-timline-pra",
                        ),
                    ),
                    'label_prefix' => esc_html__('Description', 'et_builder'),
                    'toggle_slug' => 'dnxte_desc_settings',
                ),
                'button' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => "%%order_class%% .dnxte-timline-btn-more",
                            'border_styles' => "%%order_class%% .dnxte-timline-btn-more",
                        ),
                    ),
                    'label_prefix' => esc_html__('Button', 'et_builder'),
                    'toggle_slug' => 'dnxte_btn_settings',
                ),
                'identifier' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => "%%order_class%% .dnxte-timline-date",
                            'border_styles' => "%%order_class%% .dnxte-timline-date",
                        ),
                    ),
                    'label_prefix' => esc_html__('Identifier', 'et_builder'),
                    'toggle_slug' => 'dnxte_identifier_settings',
                ),
            ),
            'box_shadow' => array(
                'default' => array(),
                'title' => array(
                    'label' => esc_html__('Title Box Shadow', 'et_builder'),
                    'option_category' => 'layout',
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxte_title_settings',
                    'css' => array(
                        'main' => '%%order_class%% .dnxte-timline-heading',
                        'custom_style' => true,
                    ),
                    'default_on_fronts' => array(
                        'color' => '',
                        'position' => '',
                    ),
                ),
                'description' => array(
                    'label' => esc_html__('Description Box Shadow', 'et_builder'),
                    'option_category' => 'layout',
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxte_desc_settings',
                    'css' => array(
                        'main' => '%%order_class%% .dnxte-timline-pra',
                        'custom_style' => true,
                    ),
                    'default_on_fronts' => array(
                        'color' => '',
                        'position' => '',
                    ),
                ),
                'button' => array(
                    'label' => esc_html__('Button Box Shadow', 'et_builder'),
                    'option_category' => 'layout',
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxte_btn_settings',
                    'css' => array(
                        'main' => '%%order_class%% .dnxte-timline-btn-more',
                        'custom_style' => true,
                    ),
                    'default_on_fronts' => array(
                        'color' => '',
                        'position' => '',
                    ),
                ),
                'identifier' => array(
                    'label' => esc_html__('Identifier Box Shadow', 'et_builder'),
                    'option_category' => 'layout',
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxte_identifier_settings',
                    'css' => array(
                        'main' => '%%order_class%% .dnxte-timline-date',
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
        $fields = array(
            'dnxte_circle_width'    => array(
                'label'             => esc_html__('Icon Circle Width', 'et_builder'),
                'type'              => 'range',
                'option_category'   => 'basic_option',
                'range_settings'    => array(
                    'step'          => 1,
                    'min'           => 1,
                    'max'           => 300,
                ),
                'default'           => '15',
                'fixed_unit'        => '',
                'validate_unit'     => false,
                'unitless'          => true, 
                'toggle_slug'       => 'dnxte_other_settings',
                'tab_slug'          => 'advanced'
            ),
            'dnxte_use_triangle'    => array(
                'label'             => esc_html__('Use Triangle', 'et_builder'),
                'type'              => 'yes_no_button',
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'dnxte_other_settings',
                'options'           => array(
                    'on'  => esc_html__('Yes', 'et_builder'),
                    'off' => esc_html__('No', 'et_builder'),
                ),
                'affects' => array(
                    'dnxte_traingle_color',
                ),
                'default_on_front' => 'on',
            ),
            'dnxte_triangle_color' => array(
                'label'            => esc_html__('Triangle Color', 'et_builder'),
                'type'             => 'color-alpha',
                'custom_color'     => true,
                'default'          => '#fff',
                'default_on_front' => '#fff',
                'tab_slug'         => 'advanced',
                'toggle_slug'      => 'dnxte_other_settings',
                'mobile_options'   => true,
                'show_if'          => array(
                    'dnxte_use_triangle' => 'on'
                )
            ),
        );

        $additional = array(
            'timeline_bar_color' => array(
                'label'           => esc_html__('Timeline Bar Color', 'et_builder'),
                'type'            => 'background-field',
                'base_name'       => "timeline_bar",
                'context'         => "timeline_bar",
                'option_category' => 'layout',
                'custom_color'    => true,
                'default'         => ET_Global_Settings::get_value('all_buttons_bg_color'),
                'depends_show_if' => 'on',
                'tab_slug'        => 'advanced',
                'toggle_slug'     => "dnxte_bar_settings",
                'background_fields' => array_merge(
                    ET_Builder_Element::generate_background_options(
                        'timeline_bar',
                        'gradient',
                        "advanced",
                        "dnxte_bar_settings",
                        "timeline_bar_gradient"
                    ),
                    ET_Builder_Element::generate_background_options(
                        "timeline_bar",
                        "color",
                        "advanced",
                        "dnxte_bar_settings",
                        "timeline_bar_color"
                    )
                    ),
                'mobile_options' => true,
                'hover' => 'tabs'
            ),
        );

        $additional = array_merge(
            $additional,
            $this->generate_background_options(
                'timeline_bar',
                'skip',
                "advanced",
                "dnxte_bar_settings",
                "timeline_bar_gradient"
            )
        );

        return array_merge($fields, $additional);
    }

    public function render($attrs, $content, $render_slug){

        $circle_width_height = sprintf('%1$spx', $this->props['dnxte_circle_width']*2);
        $circle_margin_left  = sprintf('-%1$spx', $this->props['dnxte_circle_width']);

        // Timeline background color
        $timeline_bar_color = array(
            'color_slug' => "timeline_bar_color"
        );
        $use_color_gradient = $this->props['timeline_bar_use_color_gradient'];
        $gradient = array(
            "gradient_type"           => 'timeline_bar_color_gradient_type',
            "gradient_direction"      => 'timeline_bar_color_gradient_direction',
            "radial"                  => 'timeline_bar_color_gradient_direction_radial',
            "gradient_start"          => 'timeline_bar_color_gradient_start',
            "gradient_end"            => 'timeline_bar_color_gradient_end',
            "gradient_start_position" => 'timeline_bar_color_gradient_start_position',
            "gradient_end_position"   => 'timeline_bar_color_gradient_end_position',
            "gradient_overlays_image" => 'timeline_bar_color_gradient_overlays_image',
        );

        $css_property = array(
            "desktop" => "%%order_class%% #dnxte-timline::before",
            "hover"   => "%%order_class%% #dnxte-timline::before:hover"
        );
        Common::apply_bg_css($render_slug, $this, $timeline_bar_color, $use_color_gradient, $gradient, $css_property);
        //Timeline background color end


        // On Off Triangle
        if( "off" === $this->props['dnxte_use_triangle']) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte-timline-content::before",
                'declaration' => sprintf('border-right-color: transparent !important;border-left-color: transparent !important;')
            ));
        }

        if("off" !== $this->props['dnxte_use_triangle']) {
            // RESPONSIVE TRAINGLE COLOR
            $triangle_color = isset( $this->props['dnxte_triangle_color'] ) ? $this->props['dnxte_triangle_color'] : '';
            $triangle_color_right = sprintf('border-right: 7px solid %1$s;', $triangle_color);
            $triangle_color_left = sprintf('border-left: 7px solid %1$s;', $triangle_color);
            $responsive_traingle = sprintf('right: 100%%;border-right: 7px solid %1$s;left:auto;border-left:0;', $triangle_color);

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte_timeline_child:nth-child(odd) .dnxte-timline-content::before",
                'declaration' => $triangle_color_left,
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte_timeline_child:nth-child(even) .dnxte-timline-content::before",
                'declaration' => $triangle_color_right,
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte_timeline_child:nth-child(odd) .dnxte-timline-content::before,%%order_class%% .dnxte_timeline_child:nth-child(even) .dnxte-timline-content::before",
                'declaration' => $responsive_traingle,
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte_timeline_child:nth-child(odd) .dnxte-timline-content::before,%%order_class%% .dnxte_timeline_child:nth-child(even) .dnxte-timline-content::before",
                'declaration' => $responsive_traingle,
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));
            // RESPONSIVE TRAINGLE COLOR END
        }

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .dnxte-timline-img",
            'declaration' => sprintf('width: %1$s; height:%1$s;margin-left: %2$s', $circle_width_height, $circle_margin_left)
        ));

        return sprintf('<section id="dnxte-timline">%1$s</section>', $this->content);
    }

}

new Divi_NxteTimeline;