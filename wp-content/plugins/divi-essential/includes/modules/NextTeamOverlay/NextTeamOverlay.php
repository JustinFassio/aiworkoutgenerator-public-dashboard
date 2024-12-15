<?php
include_once(DIVI_ESSENTIAL_PATH.'/includes/modules/base/Common.php');

class Next_Team_Overlay extends ET_Builder_Module
{

    public $slug = 'dnxte_team_overlay';
    public $vb_support = 'on';
    public $child_slug = 'dnxte_team_overlay_item';

    protected $module_credits = array(
        'module_uri' => 'https://www.diviessential.com/divi-team-member-overlay/',
        'author' => 'Divi Next',
        'author_uri' => 'www.divinext.com',
    );

    public function init()
    {
        $this->name        = esc_html__('Next Team Member Overlay', 'et_builder');
        $this->icon_path   = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->folder_name = 'et_pb_divi_essential';

        $this->settings_modal_toggles = array(
            'general' => array(
                'toggles' => array(
                    'dnext_team_img' => array(
                        'title' => esc_html__('Image', 'et_builder'),
                    ),
                    'teamsorev_img_ovl' => array(
                        'title' => esc_html__('Image Overlay Color', 'et_builder'),
                        'priority' => 80,
                    ),
                ),
            ),
            'advanced' => array(
                'toggles' => array(
                    'teamperson_effect' => array(
                        'title' => esc_html__('Style', 'et_builder'),
                    ),
                    'teamovl_image' => array(
                        'title' => esc_html__('Image', 'et_builder'),
                    ),
                    "teamovl_alignment" => array(
                        'title' => esc_html__('Social Aligment', 'et_builder'),
                    ),
                    'teamsovl_img_ovl_border' => array(
                        'title' => esc_html__('Image Overlay Border', 'et_builder'),
                        'priority' => 91,
                    ),
                    'teamperson_borders' => array(
                        'title' => esc_html__('Content Border', 'et_builder'),
                        'priority' => 91,
                    ),

                ),
            ),
            'custom_css' => array(
                'toggles' => array(),
            ),
        );

        $this->advanced_fields = array(
            'fonts' => array(
                'header' => array(
                    'label' => esc_html__('Title', 'et_builder'),
                    'css' => array(
                        'main' => "%%order_class%% h4.dnxte-teamovlay-name, %%order_class%% h1.dnxte-teamovlay-name, %%order_class%% h2.dnxte-teamovlay-name, %%order_class%% h3.dnxte-teamovlay-name, %%order_class%% h5.dnxte-teamovlay-name, %%order_class%% h6.dnxte-teamovlay-name",
                        'important' => 'plugin_only',
                    ),
                    'header_level' => array(
                        'default' => 'h4',
                    ),
                ),
                'position' => array(
                    'label' => esc_html__('Position', 'et_builder'),
                    'css' => array(
                        'main' => "%%order_class%% .dnxte-teamovlay-title .dnxte-teamovlay-pos",
                    ),
                    'line_height' => array(
                        'default' => '1.7em',
                    ),
                    'font_size' => array(
                        'default' => absint(et_get_option('body_font_size', '14')) . 'px',
                    ),
                    'letter_spacing' => array(
                        'default' => '0px',
                    ),
                ),
            ),
            'background' => array(
                'settings' => array(
                    'color' => 'alpha',
                ),
                'css' => array(
                    'main' => "%%order_class%% .dnxte-teamovlay-wrap",
                    'important' => true,
                ),
            ),
            'borders' => array(
                'default' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => "%%order_class%% .dnxte-teamovlay-wrap",
                            'border_styles' => "%%order_class%% .dnxte-teamovlay-wrap",
                        ),
                    ),
                ),
                'image' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => "%%order_class%% .dnxte-teamovlay-img img",
                            'border_styles' => "%%order_class%% .dnxte-teamovlay-img img",
                        ),
                    ),
                    'label_prefix' => esc_html__('Image', 'et_builder'),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'teamovl_image',
                ),
                'image_ovl' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii'  => "%%order_class%% .dnxte-teamovlay-info",
                            'border_styles' => "%%order_class%% .dnxte-teamovlay-info",
                        ),
                    ),
                    'label_prefix' => esc_html__('Image', 'et_builder'),
                    'tab_slug'     => 'advanced',
                    'toggle_slug'  => 'teamsovl_img_ovl_border',
                ),
                'content_border' => array(
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'teamperson_borders',
                    'css' => array(
                        'main' => array(
                            'border_radii' => "%%order_class%% .dnxte-teamovlay-info-inner",
                            'border_radii_hover' => '%%order_class%%:hover .dnxte-teamovlay-info-inner',
                            'border_styles' => "%%order_class%% .dnxte-teamovlay-info-inner",
                            'border_styles_hover' => '%%order_class%%:hover .dnxte-teamovlay-info-inner',
                        ),
                    ),
                    'defaults' => array(
                        'border_radii' => 'on|0px|0px|0px|0px',
                        'border_styles' => array(
                            'width' => '0px',
                            'color' => '#2857b6',
                            'style' => 'solid',
                        ),
                    ),
                ),
            ),
            'box_shadow' => array(
                'default' => array(
                    'css' => array(
                        'main' => "%%order_class%% .dnxte-teamovlay-wrap",
                        'hover' => '%%order_class%%:hover .dnxte-teamovlay-wrap',
                        'overlay' => 'inset',
                    ),
                ),
            ),
            'margin_padding' => array(
                'css' => array(
                    'main' => '%%order_class%% .dnxte-teamovlay-wrap',
                    'important' => 'all',
                ),
            ),
            'max_width' => array(
                'css' => array(
                    'module_alignment' => '%%order_class%%.dnxte_team_overlay',
                ),
            ),
            'filters' => array(
                'css' => array(
                    'main' => '%%order_class%%',
                ),
                'child_filters_target' => array(
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'image',
                ),
            ),
            'button' => false,
            'text' => false,
        );

        // Custom CSS Field
        $this->custom_css_fields = array(
            'teamovl_content' => array(
                'label' => esc_html__('Description', 'et_builder'),
                'selector' => '%%order_class%% .dnxte-teamovlay-title',
            ),
            'teamovl_title' => array(
                'label' => esc_html__('Title', 'et_builder'),
                'selector' => '%%order_class%% .dnxte-teamovlay-name',
            ),
            'teamovl_position' => array(
                'label' => esc_html__('Position', 'et_builder'),
                'selector' => '%%order_class%% .dnxte-teamovlay-pos',
            ),
        );
    }

    public function get_fields()
    {
        $fields = array(
            'teamoverlay_image' => array(
                'label'              => esc_html__('Image', 'et_builder'),
                'type'               => 'upload',
                'option_category'    => 'basic_option',
                'upload_button_text' => esc_attr__('Upload an image', 'et_builder'),
                'choose_text'        => esc_attr__('Choose an Image', 'et_builder'),
                'update_text'        => esc_attr__('Set As Image', 'et_builder'),
                'description'        => esc_html__('Upload an image to display at the top of your team overlay.', 'et_builder'),
                'toggle_slug'        => 'dnext_team_img',
                'dynamic_content'    => 'image',
                'mobile_options'     => true,
                'hover'              => 'tabs',
            ),
            'teamoverlay_name' => array(
                'label'           => esc_html__('Name', 'et_builder'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'description'     => esc_html__('Input the name of the person', 'et_builder'),
                'toggle_slug'     => 'main_content',
                'dynamic_content' => 'text',
                'mobile_options'  => true,
                'hover'           => 'tabs',
            ),
            'teamoverlay_position' => array(
                'label'           => esc_html__('Position', 'et_builder'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'description'     => esc_html__("Input the team's position.", 'et_builder'),
                'toggle_slug'     => 'main_content',
                'dynamic_content' => 'text',
                'mobile_options'  => true,
                'hover'           => 'tabs',
            ),
            'teamovl_alignment' => array(
                'label'           => esc_html__('Social Item Alignment', 'et_builder'),
                'description'     => esc_html__('Align social item to the left, right or center.', 'et_builder'),
                'type'            => 'align',
                'option_category' => 'layout',
                'options'         => et_builder_get_text_orientation_options(array('justified')),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'teamovl_alignment',
                'mobile_options'  => true,
            ),
            'teamovl_img_width' => array(
                'label'            => esc_html__('Image Width', 'et_builder'),
                'description'      => esc_html__('Adjust the width of the image within the team.', 'et_builder'),
                'type'             => 'range',
                'option_category'  => 'layout',
                'tab_slug'         => 'advanced',
                'toggle_slug'      => 'teamovl_image',
                'allowed_units'    => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'default'          => '100%',
                'default_unit'     => '%',
                'default_on_front' => '',
                'allow_empty'      => true,
                'range_settings'   => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1',
                ),
                'mobile_options' => true,
                'hover'          => 'tabs',
            ),
            // 'teamovl_hover_overlay' => array(
            //     'label'          => esc_html__('Select Overlay Color', 'et_builder'),
            //     'type'           => 'color-alpha',
            //     'toggle_slug'    => 'teamsorev_img_ovl',
            //     'default'        => '#772ADB',
            //     'mobile_options' => true,
            //     'responsive'     => true,
            // ),
            'teamovl_title_margin' => array(
                'label'           => esc_html__('Name Margin', 'et_builder'),
                'type'            => 'custom_margin',
                'mobile_options'  => true,
                'hover'           => 'tabs',
                'allowed_units'   => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'margin_padding',
            ),
            'teamovl_title_padding' => array(
                'label'           => esc_html__('Name Padding', 'et_builder'),
                'type'            => 'custom_padding',
                'mobile_options'  => true,
                'hover'           => 'tabs',
                'allowed_units'   => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'margin_padding',
            ),
            'teamovl_position_margin' => array(
                'label'           => esc_html__('Position Margin', 'et_builder'),
                'type'            => 'custom_margin',
                'mobile_options'  => true,
                'hover'           => 'tabs',
                'allowed_units'   => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'margin_padding',
            ),
            'teamovl_position_padding' => array(
                'label' => esc_html__('Position Padding', 'et_builder'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'teamovl_content_margin' => array(
                'label' => esc_html__('Content Margin', 'et_builder'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'teamovl_content_padding' => array(
                'label' => esc_html__('Content Padding', 'et_builder'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
        );

        // slug = teamovl_hover_overlay
        $teamovl_hover_overlay = Common::background_fields($this, "teamovl_hover_overlay_", "Select Overlay Color", "teamovl_image", "general", array(
            'hover'        => 'tabs'
        ));

        return array_merge($fields, $teamovl_hover_overlay);
    }

    /**
     * Get Social alignment.
     *
     * @since 3.23 Add responsive support by adding device parameter.
     *
     * @param  string $device Current device name.
     * @return string Alignment value, rtl or not.
     */

    public function get_social_item_alignment($device = 'desktop')
    {
        $suffix = 'desktop' !== $device ? "_{$device}" : '';
        $text_orientation = isset($this->props["teamovl_alignment{$suffix}"]) ? $this->props["teamovl_alignment{$suffix}"] : '';

        return et_pb_get_alignment($text_orientation);
    }

    public function render($attrs, $content, $render_slug)
    {

        $multi_view = et_pb_multi_view_options($this);

        // Social Item Alignment.
        $social_item_alignment = $this->get_social_item_alignment();
        $is_social_item_alignment_responsive = et_pb_responsive_options()->is_responsive_enabled($this->props, 'teamovl_alignment');
        $social_item_alignment_tablet = $is_social_item_alignment_responsive ? $this->get_social_item_alignment('tablet') : '';
        $social_item_alignment_phone = $is_social_item_alignment_responsive ? $this->get_social_item_alignment('phone') : '';

        $social_item_alignments = array();
        if (!empty($social_item_alignment)) {
            array_push($social_item_alignments, sprintf('dnext_teamovl_social_alignment_%1$s', esc_attr($social_item_alignment)));
        }

        if (!empty($social_item_alignment_tablet)) {
            array_push($social_item_alignments, sprintf('dnext_teamovl_social_alignment_tablet_%1$s', esc_attr($social_item_alignment_tablet)));
        }

        if (!empty($social_item_alignment_phone)) {
            array_push($social_item_alignments, sprintf('dnext_teamovl_social_alignment_phone_%1$s', esc_attr($social_item_alignment_phone)));
        }

        $social_item_alignment_classes = join(' ', $social_item_alignments);

        // Teamovl Image Width
        $teamovl_img_width = $this->props['teamovl_img_width'];
        $teamovl_img_width_hover = $this->get_hover_value('teamovl_img_width');
        $teamovl_img_width_tablet = $this->props['teamovl_img_width_tablet'];
        $teamovl_img_width_phone = $this->props['teamovl_img_width_phone'];
        $teamovl_img_width_last_edited = $this->props['teamovl_img_width_last_edited'];

        if ('' !== $teamovl_img_width) {
            $teamovl_img_width_responsive_active = et_pb_get_responsive_status($teamovl_img_width_last_edited);

            $teamovl_img_width_values = array(
                'desktop' => $teamovl_img_width,
                'tablet' => $teamovl_img_width_responsive_active ? $teamovl_img_width_tablet : '',
                'phone' => $teamovl_img_width_responsive_active ? $teamovl_img_width_phone : '',
            );
            $teamovl_img_width_selector = "%%order_class%% .dnxte-teamovlay-img img";
            et_pb_responsive_options()->generate_responsive_css($teamovl_img_width_values, $teamovl_img_width_selector, 'max-width', $render_slug);

            if (et_builder_is_hover_enabled('teamovl_img_width', $this->props)) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => $this->add_hover_to_order_class('%%order_class%% .dnxte-teamovlay-img img'),
                    'declaration' => sprintf(
                        'max-width: %1$s;',
                        esc_html($teamovl_img_width_hover)
                    ),
                ));
            }
        }

        // Normal Overlay background color
        $teamovl_hover_overlay_bg_color = array(
            'color_slug' => "teamovl_hover_overlay_bg_color"
        );
        $use_color_gradient = $this->props['teamovl_hover_overlay_bg_use_color_gradient'];

        $gradient = array(
            "gradient_type" => 'teamovl_hover_overlay_bg_color_gradient_type',
            "gradient_direction" => 'teamovl_hover_overlay_bg_color_gradient_direction',
            "radial" => 'teamovl_hover_overlay_bg_color_gradient_direction_radial',
            "gradient_start" => 'teamovl_hover_overlay_bg_color_gradient_start',
            "gradient_end" => 'teamovl_hover_overlay_bg_color_gradient_end',
            "gradient_start_position" => 'teamovl_hover_overlay_bg_color_gradient_start_position',
            "gradient_end_position" => 'teamovl_hover_overlay_bg_color_gradient_end_position',
            "gradient_overlays_image" => 'teamovl_hover_overlay_bg_color_gradient_overlays_image',
        );

        $css_property = array(
            "desktop" => "%%order_class%% .dnxte-teamovlay-info",
        );
        Common::apply_bg_css($render_slug, $this, $teamovl_hover_overlay_bg_color, $use_color_gradient, $gradient, $css_property);
        //Normal background color end

        // Overlay BG Color
        // $teamovl_hover_overlay_color = $this->props['teamovl_hover_overlay'];
        // $teamovl_hover_overlay_color_values = et_pb_responsive_options()->get_property_values($this->props, 'teamovl_hover_overlay');
        // $teamovl_hover_overlay_color_tablet = isset($teamovl_hover_overlay_color_values['tablet']) ? $teamovl_hover_overlay_color_values['tablet'] : '';
        // $teamovl_hover_overlay_color_phone = isset($teamovl_hover_overlay_color_values['phone']) ? $teamovl_hover_overlay_color_values['phone'] : '';

        // if ('' !== $this->props['teamovl_hover_overlay']) {
        //     $teamovl_hover_overlay_color_style = sprintf('background: %1$s;', esc_attr($teamovl_hover_overlay_color));
        //     $teamovl_hover_overlay_color_tablet_style = '' !== $teamovl_hover_overlay_color_tablet ? sprintf('background: %1$s;', esc_attr($teamovl_hover_overlay_color_tablet)) : '';
        //     $teamovl_hover_overlay_color_phone_style = '' !== $teamovl_hover_overlay_color_phone ? sprintf('background: %1$s;', esc_attr($teamovl_hover_overlay_color_phone)) : '';

        //     ET_Builder_Element::set_style($render_slug, array(
        //         'selector' => "%%order_class%% .dnxte-teamovlay-info",
        //         'declaration' => $teamovl_hover_overlay_color_style,
        //     ));

        //     ET_Builder_Element::set_style($render_slug, array(
        //         'selector' => "%%order_class%% .dnxte-teamovlay-info",
        //         'declaration' => $teamovl_hover_overlay_color_tablet_style,
        //         'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
        //     ));

        //     ET_Builder_Element::set_style($render_slug, array(
        //         'selector' => "%%order_class%% .dnxte-teamovlay-info",
        //         'declaration' => $teamovl_hover_overlay_color_phone_style,
        //         'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
        //     ));
        // }

        //Person Image
        $teamovl_image = "";
        if ($multi_view->has_value('teamoverlay_image')) {
            $teamovl_image_classes = array(
                'dnxte-teamovlay-img',
            );

            $teamovl_image = $multi_view->render_element(array(
                'tag' => 'div',
                'content' => $multi_view->render_element(array(
                    'tag' => 'img',
                    'attrs' => array(
                        'src' => '{{teamoverlay_image}}',
                        'alt' => '{{teamoverlay_name}}',
                    ),
                )),
                'attrs' => array(
                    'class' => implode(' ', $teamovl_image_classes),
                ),
                'classes' => array(
                    'et-svg' => array(
                        'teamovl_image' => true,
                    ),
                ),
            ));
        }
        //Team Overlay Name
        $teamovl_name = $multi_view->render_element(array(
            'tag' => et_pb_process_header_level($this->props['header_level'], 'h4'),
            'content' => '{{teamoverlay_name}}',
            'attrs' => array(
                'class' => 'dnxte-teamovlay-name',
            ),
        ));

        // Team Overlay Postion
        $teamovl_position = $multi_view->render_element(array(
            'tag' => 'p',
            'content' => '{{teamoverlay_position}}',
            'attrs' => array(
                'class' => 'dnxte-teamovlay-pos',
            ),
        ));

        $this->apply_css($render_slug);

        return sprintf(
            '<div class="dnxte-teamovlay-wrap">
				%2$s
				<div class="dnxte-teamovlay-info">
					<div class="dnxte-teamovlay-info-inner">
						<div class="dnxte-teamovlay-title">
							%3$s
							%4$s
						</div>
						<div class="dnxte-teamovlay-social">
							<ul class="dnxte-teamovlay-so-item %5$s">
								%1$s
							</ul>
						</div>
					</div>
				</div>
			</div>',
            et_core_sanitized_previously($this->content),
            et_core_esc_previously($teamovl_image),
            et_core_esc_previously($teamovl_name),
            et_core_esc_previously($teamovl_position),
            esc_attr($social_item_alignment_classes) // #5
        );
    }

    public function apply_css($render_slug)
    {
        /**
         * Custom Padding Margin Output
         *
         */

        Common::dnxt_set_style($render_slug, $this->props, "teamovl_title_margin", "%%order_class%% .dnxte-teamovlay-name", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "teamovl_title_padding", "%%order_class%% .dnxte-teamovlay-name", "padding");

        Common::dnxt_set_style($render_slug, $this->props, "teamovl_position_margin", "%%order_class%% .dnxte-teamovlay-pos", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "teamovl_position_padding", "%%order_class%% .dnxte-teamovlay-pos", "padding");
    
        Common::dnxt_set_style($render_slug, $this->props, "teamovl_content_margin", "%%order_class%% .dnxte-teamovlay-title", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "teamovl_content_padding", "%%order_class%% .dnxte-teamovlay-title", "padding");
    }

    /**
     * Check if image has svg extension
     *
     * @param string $teamsorev_image Image URL.
     *
     * @return bool
     */
    public function is_svg($teamovl_image)
    {
        if (!$teamovl_image) {
            return false;
        }

        $image_pathinfo = pathinfo($teamovl_image);

        return isset($image_pathinfo['extension']) ? 'svg' === $image_pathinfo['extension'] : false;
    }
}

new Next_Team_Overlay;