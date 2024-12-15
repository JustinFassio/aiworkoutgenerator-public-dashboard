<?php
include_once(DIVI_ESSENTIAL_PATH.'/includes/modules/base/Common.php');

class Next_Team_Creative extends ET_Builder_Module
{

    public $slug = 'dnxte_team_creative';
    public $vb_support = 'on';
    public $child_slug = 'dnxte_team_creative_item';

    protected $module_credits = array(
        'module_uri' => 'https://www.diviessential.com/divi-creative-team/',
        'author' => 'Divi Next',
        'author_uri' => 'www.divinext.com',
    );

    public function init() {
        $this->name        = esc_html__('Next Team Creative', 'et_builder');
        $this->icon_path   = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->folder_name = 'et_pb_divi_essential';

        $this->settings_modal_toggles = array(
            'general' => array(
                'toggles' => array(
                    'team_creativ_img' => array(
                        'title' => esc_html__('Image', 'et_builder'),
                    ),
                    'teamsorev_img_ovl' => array(
                        'title' => esc_html__('Image Overlay Color', 'et_builder'),
                        'priority' => 80,
                    ),
                    'team_creative_button' => array(
                        'title' => esc_html__('Button', 'et_builder'),
                        'priority' => 40,
                    ),

                ),
            ),
            'advanced' => array(
                'toggles' => array(
                    'team_creative_image' => array(
                        'title' => esc_html__('Image', 'et_builder'),
                        'priority' => 1,
                    ),
                    'button_settings' => array(
                        'title' => esc_html__('Button', 'et_builder'),
                        'priority' => 2,
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
                        'main' => "%%order_class%% h4.dnxte-cratve-tm-name, %%order_class%% h1.dnxte-cratve-tm-name, %%order_class%% h2.dnxte-cratve-tm-name, %%order_class%% h3.dnxte-cratve-tm-name, %%order_class%% h5.dnxte-cratve-tm-name, %%order_class%% h6.dnxte-cratve-tm-name",
                        'important' => 'plugin_only',
                    ),
                    'header_level' => array(
                        'default' => 'h4',
                    ),
                ),
                'position' => array(
                    'label' => esc_html__('Position', 'et_builder'),
                    'css' => array(
                        'main' => "%%order_class%% .dnxte-cratve-tm-intro .dnxte-cratve-tm-pos",
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
                'button' => array(
                    'label' => esc_html__('Button', 'et_builder'),
                    'hide_text_align' => true,
                    'css' => array(
                        'main' => "%%order_class%% .dnxte-cratve-tm-info a",
                    ),
                    'line_height' => array(
                        'default' => '1.7em',
                    ),
                    'font_size' => array(
                        'default' => '20px',
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
                    'main' => "%%order_class%% .dnxte-cratve-tm-inner",
                    'important' => true,
                ),
            ),
            'borders' => array(
                'default' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => "%%order_class%% .dnxte-cratve-tm-inner",
                            'border_styles' => "%%order_class%% .dnxte-cratve-tm-inner",
                        ),
                    ),
                ),
                'image' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => "%%order_class%% .dnxte-cratve-tm .dnxte-cratve-tm-imge a .dnxte-cratve-tm-imframe",
                            'border_styles' => "%%order_class%% .dnxte-cratve-tm .dnxte-cratve-tm-imge a .dnxte-cratve-tm-imframe",
                        ),
                    ),
                    'defaults' => array(
                        'border_radii' => 'on|0px|0px|0px|0px',
                        'border_styles' => array(
                            'width' => '20px',
                            'color' => '#0077FF',
                            'style' => 'solid',
                        ),
                    ),
                    'label_prefix' => esc_html__('', 'et_builder'),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'team_creative_image',
                ),
            ),
            'box_shadow' => array(
                'default' => array(
                    'css' => array(
                        'main' => "%%order_class%% .dnxte-cratve-tm-inner",
                        'hover' => '%%order_class%%:hover .dnxte-cratve-tm-inner',
                        'overlay' => 'inset',
                    ),
                ),
            ),
            'margin_padding' => array(
                'css' => array(
                    'main' => '%%order_class%% .dnxte-cratve-tm-inner',
                    'important' => 'all',
                ),
            ),
            'max_width' => array(
                'css' => array(
                    'module_alignment' => '%%order_class%%.dnxte_team_creative',
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
            'team_creative_title' => array(
                'label' => esc_html__('Title', 'et_builder'),
                'selector' => '%%order_class%% .dnxte-cratve-tm-name',
            ),
            'team_creative_position' => array(
                'label' => esc_html__('Position', 'et_builder'),
                'selector' => '%%order_class%% .dnxte-cratve-tm-pos',
            ),
            'team_creative_btn' => array(
                'label' => esc_html__('Button', 'et_builder'),
                'selector' => '%%order_class%% .dnext-creative-btn',
            ),
        );
    }

    public function get_fields() {
        $fields = array(
            'team_creative_image' => array(
                'label'              => esc_html__('Image', 'et_builder'),
                'type'               => 'upload',
                'option_category'    => 'basic_option',
                'upload_button_text' => esc_attr__('Upload an image', 'et_builder'),
                'choose_text'        => esc_attr__('Choose an Image', 'et_builder'),
                'update_text'        => esc_attr__('Set As Image', 'et_builder'),
                'description'        => esc_html__('Upload an image to display at the top of your team overlay.', 'et_builder'),
                'toggle_slug'        => 'team_creative_image',
                'dynamic_content'    => 'image',
                'mobile_options'     => true,
                'hover'              => 'tabs',
            ),
            'team_creative_name' => array(
                'label'           => esc_html__('Name', 'et_builder'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'description'     => esc_html__('Input the name of the person', 'et_builder'),
                'toggle_slug'     => 'main_content',
                'dynamic_content' => 'text',
                'mobile_options'  => true,
                'hover'           => 'tabs',
            ),
            'team_creative_position' => array(
                'label'           => esc_html__('Position', 'et_builder'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'description'     => esc_html__("Input the team's position.", 'et_builder'),
                'toggle_slug'     => 'main_content',
                'dynamic_content' => 'text',
                'mobile_options'  => true,
                'hover'           => 'tabs',
            ),
            'dnxt_btn_show_hide' => array(
                'label'   => esc_html__('Button Show Hide', 'et_builder'),
                'type'    => 'yes_no_button',
                'options' => array(
                    'off' => esc_html__('No', 'et_builder'),
                    'on'  => esc_html__('Yes', 'et_builder'),
                ),
                'toggle_slug' => 'team_creative_button',
                'affects'     => array(
                    'button_text',
                    'button_link',
                    'button_link_new_window',
                ),
                'default_on_front' => 'on',
            ),
            // Button Title Field
            'button_text' => array(
                'label'           => esc_html__('Button Text', 'et_builder'),
                'type'            => 'text',
                'dynamic_content' => 'text',
                'default'         => 'Button Text',
                'option_category' => 'basic_option',
                'toggle_slug'     => 'team_creative_button',
                'depends_show_if' => 'on',
            ),
            // Button Link Field
            'button_link' => array(
                'label'           => esc_html__('Button Link', 'et_builder'),
                'description'     => esc_html__('When clicked the module will link to this URL.', 'et_builder'),
                'type'            => 'text',
                'option_category' => 'configuration',
                'toggle_slug'     => 'team_creative_button',
                'dynamic_content' => 'url',
                'depends_show_if' => 'on',
            ),
            // Button Link Target Field
            'button_link_new_window' => array(
                'label'           => esc_html__('Button Link Target', 'et_builder'),
                'description'     => esc_html__('Here you can choose whether or not your link opens in a new window', 'et_builder'),
                'type'            => 'select',
                'option_category' => 'configuration',
                'options'         => array(
                    'off' => esc_html__('In The Same Window', 'et_builder'),
                    'on'  => esc_html__('In The New Tab', 'et_builder'),
                ),
                'toggle_slug'      => 'team_creative_button',
                'default_on_front' => 'off',
                'depends_show_if'  => 'on',
            ),
            'btn_alignment' => array(
                'label'           => esc_html__('Button Alignment', 'et_builder'),
                'description'     => esc_html__('Align button item to the left, right or center.', 'et_builder'),
                'type'            => 'align',
                'option_category' => 'layout',
                'options'         => et_builder_get_text_orientation_options(array('justified')),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'button_settings',
                'mobile_options'  => true,
            ),
            'btn_bg_color' => array(
                'label'          => esc_html__('Button Hover Line Color', 'et_builder'),
                'description'    => esc_html__('Here you can define a custom color for the Button Background.', 'et_builder'),
                'type'           => 'color-alpha',
                'default'        => '#0077FF',
                'custom_color'   => true,
                'tab_slug'       => 'advanced',
                'toggle_slug'    => 'button_settings',
                'mobile_options' => true,
            ),
            'team_title_margin' => array(
                'label'           => esc_html__('Title Margin', 'et_builder'),
                'type'            => 'custom_margin',
                'mobile_options'  => true,
                'hover'           => 'tabs',
                'allowed_units'   => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'margin_padding',
            ),
            'team_title_padding' => array(
                'label'           => esc_html__('Title Padding', 'et_builder'),
                'type'            => 'custom_padding',
                'mobile_options'  => true,
                'hover'           => 'tabs',
                'allowed_units'   => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'margin_padding',
            ),
            'team_position_margin' => array(
                'label'           => esc_html__('Position Margin', 'et_builder'),
                'type'            => 'custom_margin',
                'mobile_options'  => true,
                'hover'           => 'tabs',
                'allowed_units'   => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'margin_padding',
            ),
            'team_position_padding' => array(
                'label'           => esc_html__('Position Padding', 'et_builder'),
                'type'            => 'custom_padding',
                'mobile_options'  => true,
                'hover'           => 'tabs',
                'allowed_units'   => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'margin_padding',
            ),
            'team_btn_margin' => array(
                'label'           => esc_html__('Button Margin', 'et_builder'),
                'type'            => 'custom_margin',
                'mobile_options'  => true,
                'hover'           => 'tabs',
                'allowed_units'   => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'margin_padding',
            ),
            'team_btn_padding' => array(
                'label'           => esc_html__('Button Padding', 'et_builder'),
                'type'            => 'custom_padding',
                'mobile_options'  => true,
                'hover'           => 'tabs',
                'allowed_units'   => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'margin_padding',
            ),
        );

        return $fields;
    }

    /**
     * Get Button Alignment.
     *
     * @since 3.23 Add responsive support by adding device parameter.
     *
     * @param  string $device Current device name.
     * @return string Alignment value, rtl or not.
     */

    public function get_button_alignment($device = 'desktop')
    {
        $suffix = 'desktop' !== $device ? "_{$device}" : '';
        $text_orientation = isset($this->props["btn_alignment{$suffix}"]) ? $this->props["btn_alignment{$suffix}"] : '';

        return et_pb_get_alignment($text_orientation);
    }

    public function render($attrs, $content, $render_slug)
    {

        $multi_view = et_pb_multi_view_options($this);
        $team_creative_image = $this->props['team_creative_image'];

        // Button Alignment.
        $button_alignment = $this->get_button_alignment();
        $is_button_alignment_responsive = et_pb_responsive_options()->is_responsive_enabled($this->props, 'btn_alignment');
        $button_alignment_tablet = $is_button_alignment_responsive ? $this->get_button_alignment('tablet') : '';
        $button_alignment_phone = $is_button_alignment_responsive ? $this->get_button_alignment('phone') : '';

        $button_alignments = array();
        if (!empty($button_alignment)) {
            array_push($button_alignments, sprintf('dnext_btn_alignment_%1$s', esc_attr($button_alignment)));
        }

        if (!empty($button_alignment_tablet)) {
            array_push($button_alignments, sprintf('dnext_btn_alignment_tablet_%1$s', esc_attr($button_alignment_tablet)));
        }

        if (!empty($button_alignment_phone)) {
            array_push($button_alignments, sprintf('dnext_btn_alignment_phone_%1$s', esc_attr($button_alignment_phone)));
        }

        $button_alignment_classes = join(' ', $button_alignments);

        // Button BG
        $btn_bg_color_hover = $this->get_hover_value('btn_bg_color');
        $btn_bg_color_values = et_pb_responsive_options()->get_property_values($this->props, 'btn_bg_color');

        et_pb_responsive_options()->generate_responsive_css($btn_bg_color_values, '%%order_class%% .dnxte-cratve-tm-btn .dnxte-cratve-tm-btn-txt:before', 'background-color', $render_slug, '', 'background-color');

        // Handle svg image behaviour
        $team_creative_image_pathinfo = pathinfo($team_creative_image);
        $is_team_creative_image_svg = isset($team_creative_image_pathinfo['extension']) ? 'svg' === $team_creative_image_pathinfo['extension'] : false;

        $image_html = $multi_view->render_element(array(
            'tag' => 'img',
            'attrs' => array(
                'src' => '{{team_creative_image}}',
                'alt' => '{{team_creative_name}}',
            ),
            'required' => 'team_creative_image',
        ));

        //Image
        $team_creative_image = sprintf(
            '<div class="dnxte-cratve-tm-imge">
				<a>
					%1$s
					<div class="dnxte-cratve-tm-imframe"></div>
				</a>
			</div>',
            $image_html
        );

        //Team Name
        $team_creative_name = $multi_view->render_element(array(
            'tag' => et_pb_process_header_level($this->props['header_level'], 'h4'),
            'content' => '{{team_creative_name}}',
            'attrs' => array(
                'class' => 'dnxte-cratve-tm-name',
            ),
        ));

        // Team Postion
        $team_creative_position = $multi_view->render_element(array(
            'tag' => 'p',
            'content' => '{{team_creative_position}}',
            'attrs' => array(
                'class' => 'dnxte-cratve-tm-pos',
            ),
        ));

        //Button
        $button = '';
        if ("off" !== $this->props['dnxt_btn_show_hide']) {
            $button_text = $this->props['button_text'];
            $buttonTarget = 'on' === $this->props['button_link_new_window'] ? '_blank' : '';
            $button_link = $this->props['button_link'];

            $button = '<a href="' . esc_url($button_link) . '" class="dnxte-cratve-tm-btn" target="' . esc_attr($buttonTarget) . '"><span class="dnxte-cratve-tm-btn-txt">' . $button_text . '</span> </a>';
        }

        $this->apply_css($render_slug);

        return sprintf(
            '<div class="dnxte-cratve-tm dnxte-cratve-tm-social-aside">
				<div class="dnxte-cratve-tm-inner">
					<div class="dnxte-cratve-tm-img-wrap">
						<div class="dnxte-cratve-tm-sswrap">
							<div class="dnxte-cratve-tm-social">
								<ul class="dnxte-cratve-tm-soitem">
									%1$s
								</ul>
							</div>
						</div>
						%2$s
					</div>
					<div class="dnxte-cratve-tm-info">
						<div class="dnxte-cratve-tm-intro">
							%3$s
							%4$s
                        </div>
                        <div class="dnext-creative-btn %6$s">
                            %5$s
                        </div>
					</div>
				</div>
			</div>',
            et_core_sanitized_previously($this->content),
            $team_creative_image,
            $team_creative_name,
            $team_creative_position,
            $button, // #5
            $button_alignment_classes
        );
    }

    public function apply_css($render_slug)
    {
        /**
         * Custom Padding Margin Output
         *
         */

        Common::dnxt_set_style($render_slug, $this->props, "team_title_margin", "%%order_class%% .dnxte-cratve-tm-name", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "team_title_padding", "%%order_class%% .dnxte-cratve-tm-name", "padding");

        Common::dnxt_set_style($render_slug, $this->props, "team_position_margin", "%%order_class%% .dnxte-cratve-tm-pos", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "team_position_padding", "%%order_class%% .dnxte-cratve-tm-pos", "padding");

        Common::dnxt_set_style($render_slug, $this->props, "team_btn_margin", "%%order_class%% .dnext-creative-btn", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "team_btn_padding", "%%order_class%% .dnxte-cratve-tm-btn .dnxte-cratve-tm-btn-txt", "padding");
    }
}

new Next_Team_Creative;
