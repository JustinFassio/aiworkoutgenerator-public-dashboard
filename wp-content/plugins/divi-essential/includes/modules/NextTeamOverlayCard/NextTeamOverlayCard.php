<?php
include_once(DIVI_ESSENTIAL_PATH.'/includes/modules/base/Common.php');

class Next_Team_Overlay_Card extends ET_Builder_Module
{

    public $slug = 'dnxte_team_overlay_card';
    public $vb_support = 'on';
    public $child_slug = 'dnxte_team_overlay_card_item';

    protected $module_credits = array(
        'module_uri' => 'https://www.diviessential.com/divi-team-overlay-card/',
        'author' => 'Divi Next',
        'author_uri' => 'www.divinext.com',
    );

    public function init()
    {
        $this->name        = esc_html__('Next Team Overlay Card', 'et_builder');
        $this->icon_path   = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->folder_name = 'et_pb_divi_essential';

        $this->settings_modal_toggles = array(
            'general' => array(
                'toggles' => array(
                    'dnext_team_img' => array(
                        'title' => esc_html__('Image', 'et_builder'),
                    ),
                    'teamovlcard_img_ovl' => array(
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
                    "teamovl_card_alignment" => array(
                        'title' => esc_html__('Social Aligment', 'et_builder'),
                    ),
                    'dnxte_tocimg_border'	=> array(
						"title"		=>	esc_html__( 'Image Border', 'et_builder' ),
						'priority'	=>	100,
					),
                ),
            ),
            'custom_css' => array(
                'toggles' => array(),
            ),
        );

        $this->advanced_fields = array(
            'fonts' => array(
                'body' => array(
                    'label' => esc_html__('Body', 'et_builder'),
                    'css' => array(
                        'main' => "%%order_class%% .dnxte-ovlycard-title p",
                    ),
                    'block_elements' => array(
                        'tabbed_subtoggles' => true,
                        'bb_icons_support' => true,
                    ),
                ),
                'header' => array(
                    'label' => esc_html__('Title', 'et_builder'),
                    'css' => array(
                        'main' => "%%order_class%% h4.dnxte-ovlyintro-name, %%order_class%% h1.dnxte-ovlyintro-name, %%order_class%% h2.dnxte-ovlyintro-name, %%order_class%% h3.dnxte-ovlyintro-name, %%order_class%% h5.dnxte-ovlyintro-name, %%order_class%% h6.dnxte-ovlyintro-name",
                        'important' => 'plugin_only',
                    ),
                    'header_level' => array(
                        'default' => 'h4',
                    ),
                ),
                'position' => array(
                    'label' => esc_html__('Position', 'et_builder'),
                    'css' => array(
                        'main' => "%%order_class%% .dnxte-ovlyintro .dnxte-ovlyintro-pos",
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
                    'main' => "%%order_class%% .dnxte-ovlycard-wrapper",
                    'important' => true,
                ),
            ),
            'borders' => array(
                'default' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => "%%order_class%% .dnxte-ovlycard-wrapper",
                            'border_styles' => "%%order_class%% .dnxte-ovlycard-wrapper",
                        ),
                    ),
                ),
                'img_border'     => array(
					'tab_slug'     		=> 'advanced',
					'toggle_slug'  		=> 'dnxte_tocimg_border',
					'css'          => array(
						'main'     => array(
							'border_radii'  		=> "%%order_class%% .dnxte-ovlycard-img",
							'border_radii_hover'  	=> '%%order_class%%:hover .dnxte-ovlycard-img',
							'border_styles' 		=> "%%order_class%% .dnxte-ovlycard-img",
							'border_styles_hover' 	=> '%%order_class%%:hover .dnxte-ovlycard-img',
						),
					),
					'defaults'        => array(
						'border_radii'  => 'on|0px|0px|0px|0px',
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
                        'main' => "%%order_class%% .dnxte-ovlycard-wrapper",
                        'hover' => '%%order_class%%:hover .dnxte-ovlycard-wrapper',
                        'overlay' => 'inset',
                    ),
                ),
            ),
            'margin_padding' => array(
                'css' => array(
                    'main' => '%%order_class%% .dnxte-ovlycard-wrapper',
                    'important' => 'all',
                ),
            ),
            'max_width' => array(
                'css' => array(
                    'module_alignment' => '%%order_class%%.dnxte_team_overlay_card',
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
            'teamovl_image_wrapper' => array(
                'label'    => esc_html__('Image', 'et_builder'),
                'selector' => '%%order_class%% .dnxte-ovlycard-img',
            ),
            'teamovl_content' => array(
                'label'    => esc_html__('Text', 'et_builder'),
                'selector' => '%%order_class%% .dnxte-ovlycard-title',
            ),
            'teamovl_title' => array(
                'label'    => esc_html__('Title', 'et_builder'),
                'selector' => '%%order_class%% .dnxte-ovlyintro-name',
            ),
            'teamovl_position' => array(
                'label'    => esc_html__('Position', 'et_builder'),
                'selector' => '%%order_class%% .dnxte-ovlyintro-pos',
            ),
        );

    }

    public function get_fields()
    {
        $fields = array(
            'teamoverlay_card_image'    => array(
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
            'teamovelay_card_content' => array(
                'label'           => esc_html__('Body', 'et_builder'),
                'type'            => 'tiny_mce',
                'option_category' => 'basic_option',
                'description'     => esc_html__('Input the main text content for your module here.', 'et_builder'),
                'toggle_slug'     => 'main_content',
                'dynamic_content' => 'text',
                'mobile_options'  => true,
                'hover'           => 'tabs',
            ),
            'teamoverlay_card_name' => array(
                'label'           => esc_html__('Name', 'et_builder'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'description'     => esc_html__('Input the name of the person', 'et_builder'),
                'toggle_slug'     => 'main_content',
                'dynamic_content' => 'text',
                'mobile_options'  => true,
                'hover'           => 'tabs',
            ),
            'teamoverlay_card_position' => array(
                'label'           => esc_html__('Position', 'et_builder'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'description'     => esc_html__("Input the team's position.", 'et_builder'),
                'toggle_slug'     => 'main_content',
                'dynamic_content' => 'text',
                'mobile_options'  => true,
                'hover'           => 'tabs',
            ),
            'teamovlcard_alignment' => array(
                'label'           => esc_html__('Social Item Alignment', 'et_builder'),
                'description'     => esc_html__('Align social item to the left, right or center.', 'et_builder'),
                'type'            => 'align',
                'option_category' => 'layout',
                'options'         => et_builder_get_text_orientation_options(array('justified')),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'teamovl_card_alignment',
                'mobile_options'  => true,
            ),
            'teamovlcard_hover_overlay' => array(
                'label'          => esc_html__('Select Overlay Color', 'et_builder'),
                'type'           => 'color-alpha',
                'toggle_slug'    => 'teamovlcard_img_ovl',
                'default'        => 'rgba(25, 25, 25, .65)',
                'mobile_options' => true,
                'responsive'     => true,
            ),
            'teamovl_card_img_margin' => array(
                'label'           => esc_html__('Image Margin', 'et_builder'),
                'type'            => 'custom_margin',
                'mobile_options'  => true,
                'hover'           => 'tabs',
                'allowed_units'   => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'margin_padding',
            ),
            'teamovl_card_img_padding' => array(
                'label'           => esc_html__('Image Padding', 'et_builder'),
                'type'            => 'custom_padding',
                'mobile_options'  => true,
                'hover'           => 'tabs',
                'allowed_units'   => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'margin_padding',
            ),
            'teamovl_card_desc_margin' => array(
                'label'           => esc_html__('Description Margin', 'et_builder'),
                'type'            => 'custom_margin',
                'mobile_options'  => true,
                'hover'           => 'tabs',
                'default'         => '0|0|10px|0',
                'allowed_units'   => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'margin_padding',
            ),
            'teamovl_card_desc_padding' => array(
                'label'           => esc_html__('Description Padding', 'et_builder'),
                'type'            => 'custom_padding',
                'mobile_options'  => true,
                'hover'           => 'tabs',
                'allowed_units'   => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'margin_padding',
            ),
            'teamovl_card_title_margin' => array(
                'label'           => esc_html__('Title Margin', 'et_builder'),
                'type'            => 'custom_margin',
                'mobile_options'  => true,
                'hover'           => 'tabs',
                'allowed_units'   => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'margin_padding',
            ),
            'teamovl_card_title_padding' => array(
                'label'           => esc_html__('Title Padding', 'et_builder'),
                'type'            => 'custom_padding',
                'mobile_options'  => true,
                'hover'           => 'tabs',
                'allowed_units'   => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'margin_padding',
            ),
            'teamovl_card_position_margin' => array(
                'label'           => esc_html__('Position Margin', 'et_builder'),
                'type'            => 'custom_margin',
                'mobile_options'  => true,
                'hover'           => 'tabs',
                'allowed_units'   => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'margin_padding',
            ),
            'teamovl_card_position_padding' => array(
                'label'           => esc_html__('Position Padding', 'et_builder'),
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
        $text_orientation = isset($this->props["teamovlcard_alignment{$suffix}"]) ? $this->props["teamovlcard_alignment{$suffix}"] : '';

        return et_pb_get_alignment($text_orientation);
    }

    public function render($attrs, $content, $render_slug)
    {

        $multi_view = et_pb_multi_view_options($this);

        // Social Item Alignment.
        $social_item_alignment = $this->get_social_item_alignment();
        $is_social_item_alignment_responsive = et_pb_responsive_options()->is_responsive_enabled($this->props, 'teamovlcard_alignment');
        $social_item_alignment_tablet = $is_social_item_alignment_responsive ? $this->get_social_item_alignment('tablet') : '';
        $social_item_alignment_phone = $is_social_item_alignment_responsive ? $this->get_social_item_alignment('phone') : '';

        $social_item_alignments = array();
        if (!empty($social_item_alignment)) {
            array_push($social_item_alignments, sprintf('dnext_teamovl_card_social_alignment_%1$s', esc_attr($social_item_alignment)));
        }

        if (!empty($social_item_alignment_tablet)) {
            array_push($social_item_alignments, sprintf('dnext_teamovl_card_social_alignment_tablet_%1$s', esc_attr($social_item_alignment_tablet)));
        }

        if (!empty($social_item_alignment_phone)) {
            array_push($social_item_alignments, sprintf('dnext_teamovl_card_social_alignment_phone_%1$s', esc_attr($social_item_alignment_phone)));
        }

        $social_item_alignment_classes = join(' ', $social_item_alignments);

        // Overlay BG Color
        $teamovlcard_hover_overlay_color = $this->props['teamovlcard_hover_overlay'];
        $teamovlcard_hover_overlay_color_values = et_pb_responsive_options()->get_property_values($this->props, 'teamovlcard_hover_overlay');
        $teamovlcard_hover_overlay_color_tablet = isset($teamovlcard_hover_overlay_color_values['tablet']) ? $teamovlcard_hover_overlay_color_values['tablet'] : '';
        $teamovlcard_hover_overlay_color_phone = isset($teamovlcard_hover_overlay_color_values['phone']) ? $teamovlcard_hover_overlay_color_values['phone'] : '';

        if ('' !== $this->props['teamovlcard_hover_overlay']) {
            $teamovlcard_hover_overlay_color_style = sprintf('background: %1$s;', esc_attr($teamovlcard_hover_overlay_color));
            $teamovlcard_hover_overlay_color_tablet_style = '' !== $teamovlcard_hover_overlay_color_tablet ? sprintf('background: %1$s;', esc_attr($teamovlcard_hover_overlay_color_tablet)) : '';
            $teamovlcard_hover_overlay_color_phone_style = '' !== $teamovlcard_hover_overlay_color_phone ? sprintf('background: %1$s;', esc_attr($teamovlcard_hover_overlay_color_phone)) : '';

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte-ovlycard-info",
                'declaration' => $teamovlcard_hover_overlay_color_style,
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte-ovlycard-info",
                'declaration' => $teamovlcard_hover_overlay_color_tablet_style,
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte-ovlycard-info",
                'declaration' => $teamovlcard_hover_overlay_color_phone_style,
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));
        }

        //Team Image
        $teamovl_card_image = "";
        if ($multi_view->has_value('teamoverlay_card_image')) {
            $teamovl_card_image_classes = array(
                'dnxte-ovlycard-img',
            );

            $teamovl_card_image = $multi_view->render_element(array(
                'tag' => 'div',
                'content' => $multi_view->render_element(array(
                    'tag' => 'img',
                    'attrs' => array(
                        'src' => '{{teamoverlay_card_image}}',
                        'alt' => '{{teamoverlay_card_name}}',
                    ),
                )),
                'attrs' => array(
                    'class' => implode(' ', $teamovl_card_image_classes),
                ),
                'classes' => array(
                    'et-svg' => array(
                        'teamoverlay_card_image' => true,
                    ),
                ),
            ));
        }

        //Team Overlay Name
        $teamovl_card_name = $multi_view->render_element(array(
            'tag' => et_pb_process_header_level($this->props['header_level'], 'h4'),
            'content' => '{{teamoverlay_card_name}}',
            'attrs' => array(
                'class' => 'dnxte-ovlyintro-name',
            ),
        ));

        // Team Overlay Postion
        $teamovl_card_position = $multi_view->render_element(array(
            'tag' => 'p',
            'content' => '{{teamoverlay_card_position}}',
            'attrs' => array(
                'class' => 'dnxte-ovlyintro-pos',
            ),
        ));

        // Team Overlay Description
        $teamovelay_card_content = $multi_view->render_element(array(
            'tag' => 'p',
            'content' => '{{teamovelay_card_content}}',
        ));

        $this->apply_css($render_slug);

        return sprintf(
            '<div class="dnxte-ovlycard-wrapper">
				<div class="dnxte-ovlycard-wrap">
						%2$s
					<div class="dnxte-ovlycard-info">
						<div class="dnxte-ovlycard-info-inner">
							<div class="dnxte-ovlycard-title">
								%5$s
							</div>
							<div class="dnxte-ovlycard-social">
								<ul class="dnxte-ovlycard-so-item %6$s">
									%1$s
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="dnxte-ovlyintro">
					%3$s
					%4$s
				</div>
			</div>',
            et_core_sanitized_previously($this->content),
            et_core_esc_previously($teamovl_card_image),
            et_core_esc_previously($teamovl_card_name),
            et_core_esc_previously($teamovl_card_position),
            et_core_esc_previously($teamovelay_card_content), // #5
            esc_attr($social_item_alignment_classes)
        );
    }

    public function apply_css($render_slug)
    {
        /**
         * Custom Padding Margin Output
         *
         */

        Common::dnxt_set_style($render_slug, $this->props, "teamovl_card_img_margin", "%%order_class%% .dnxte-ovlycard-wrap", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "teamovl_card_img_padding", "%%order_class%% .dnxte-ovlycard-wrap", "padding");
        
        Common::dnxt_set_style($render_slug, $this->props, "teamovl_card_desc_margin", "%%order_class%% .dnxte-ovlycard-title", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "teamovl_card_desc_padding", "%%order_class%% .dnxte-ovlycard-title", "padding");

        Common::dnxt_set_style($render_slug, $this->props, "teamovl_card_title_margin", "%%order_class%% .dnxte-ovlyintro-name", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "teamovl_card_title_padding", "%%order_class%% .dnxte-ovlyintro-name", "padding");

        Common::dnxt_set_style($render_slug, $this->props, "teamovl_card_position_margin", "%%order_class%% .dnxte-ovlyintro-pos", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "teamovl_card_position_padding", "%%order_class%% .dnxte-ovlyintro-pos", "padding");
    }
    /**
     * Check if image has svg extension
     *
     * @param string $teamoverlay_card_image Image URL.
     *
     * @return bool
     */
    public function is_svg($teamoverlay_card_image)
    {
        if (!$teamoverlay_card_image) {
            return false;
        }

        $image_pathinfo = pathinfo($teamoverlay_card_image);

        return isset($image_pathinfo['extension']) ? 'svg' === $image_pathinfo['extension'] : false;
    }
}

new Next_Team_Overlay_Card;
