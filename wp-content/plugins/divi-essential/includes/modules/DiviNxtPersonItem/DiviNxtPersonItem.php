<?php

class DNXT_Person_Item extends ET_Builder_Module
{

    public $slug = 'dnxte_person_item';
    public $vb_support = 'on';
    public $type = 'child';
    public $child_title_var = 'content';

    protected $module_credits = array(
        'module_uri' => 'https://www.diviessential.com/divi-next-person/',
        'author' => 'Divi Next',
        'author_uri' => 'www.divinext.com',
    );

    public function init()
    {
        $this->name = esc_html__('Social Network', 'et_builder');

        $this->settings_modal_toggles = array(
            'general' => array(
                'toggles' => array(
                    'main_content' => esc_html__('Network', 'et_builder'),
                    'link' => esc_html__('Link', 'et_builder'),
                    'link_window' => esc_html__('Link Window', 'et_builder'),
                ),
            ),
            'advanced' => array(
                'toggles' => array(
                    'icon' => esc_html__('Icon', 'et_builder'),
                ),
            ),
        );

        $this->advanced_setting_title_text = esc_html__('New Social Network', 'et_builder');
        $this->settings_text = esc_html__('Social Network Settings', 'et_builder');

        $this->custom_css_fields = array(
            'social_icon' => array(
                'label' => esc_html__('Social Icon', 'et_builder'),
                'selector' => 'li.dnxte-person-sn a span',
            ),
        );

        $this->advanced_fields = array(
            'background' => array(
                'css' => array(
                    'main' => '%%order_class%% .dnxte-person-sn a span::before',
                    'important' => 'all',
                ),
            ),
            'borders' => array(
                'default' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => "%%order_class%% li.dnxte-person-sn a",
                            'border_styles' => "%%order_class%% li.dnxte-person-sn a",
                        ),
                    ),
                    'defaults' => array(
                        'border_radii' => 'on|3px|3px|3px|3px',
                        'border_styles' => array(
                            'width' => '0px',
                            'color' => '#333333',
                            'style' => 'solid',
                        ),
                    ),
                ),
            ),
            'box_shadow' => array(
                'default' => array(
                    'css' => array(
                        'main' => '%%order_class%% li.dnxte-person-sn a',
                        'important' => true,
                    ),
                ),
            ),
            'margin_padding' => array(
                'css' => array(
                    'padding' => '%%order_class%% .dnxte-person-sn a span::before',
                    'main' => '%%order_class%% .dnxte-person-sn a',
                    'important' => array('custom_margin'), // needed to overwrite last module margin-bottom styling
                ),
            ),
            'fonts' => false,
            'text' => false,
            'max_width' => false,
            'height' => false,
            'link_options' => false,
        );

    }

    public function get_fields()
    {
        $fields = array(
            'person_social_network' => array(
                'label' => esc_html__('Social Network', 'et_builder'),
                'type' => 'select',
                'option_category' => 'basic_option',
                'description' => esc_html__('If you need more social icon Select Other Network', 'et_builder'),
                'toggle_slug' => 'main_content',
                'options' => array(
                    'facebook' => esc_html__('Facebook', 'et_builder'),
                    'twitter' => esc_html__('Twitter', 'et_builder'),
                    'pinterest' => esc_html__('Pinterest', 'et_builder'),
                    'linkedin' => esc_html__('Linkedin', 'et_builder'),
                    'tumblr' => esc_html__('tumblr', 'et_builder'),
                    'instagram' => esc_html__('Instagram', 'et_builder'),
                    'skype' => esc_html__('skype', 'et_builder'),
                    'flikr' => esc_html__('Flikr', 'et_builder'),
                    'dribbble' => esc_html__('dribbble', 'et_builder'),
                    'youtube' => esc_html__('Youtube', 'et_builder'),
                    'vimeo' => esc_html__('Vimeo', 'et_builder'),
                    'social-items' => esc_html__('Select Other Network', 'et_builder'),
                ),
                'default' => 'facebook',
            ),
            'person_social_icon' => array(
                'label' => esc_html__('Social Icon', 'et_builder'),
                'type' => 'select_icon',
                'option_category' => 'basic_option',
                'class' => array('et-pb-font-icon'),
                'toggle_slug' => 'main_content',
                'description' => esc_html__('Select Social Icon.', 'et_builder'),
                'hover' => 'tabs',
                'mobile_options' => true,
                'show_if' => array(
                    'person_social_network' => 'social-items',
                ),
            ),
            'url' => array(
                'label' => esc_html__('Account Link URL', 'et_builder'),
                'type' => 'text',
                'option_category' => 'basic_option',
                'description' => esc_html__('The URL for this social network link.', 'et_builder'),
                'depends_show_if_not' => 'skype',
                'depends_on' => array(
                    'person_social_network',
                ),
                'toggle_slug' => 'link',
                'default_on_front' => '#',
            ),
            'skype_url' => array(
                'label' => esc_html__('Account Name', 'et_builder'),
                'type' => 'text',
                'option_category' => 'basic_option',
                'description' => esc_html__('The Skype account name.', 'et_builder'),
                'toggle_slug' => 'main_content',
                'show_if' => array(
                    'person_social_network' => array('skype'),
                ),
            ),
            'skype_action' => array(
                'label' => esc_html__('Skype Button Action', 'et_builder'),
                'type' => 'select',
                'option_category' => 'basic_option',
                'options' => array(
                    'call' => esc_html__('Call', 'et_builder'),
                    'chat' => esc_html__('Chat', 'et_builder'),
                ),
                'show_if' => array(
                    'person_social_network' => array('skype'),
                ),
                'description' => esc_html__('Here you can choose which action to execute on button click', 'et_builder'),
                'toggle_slug' => 'main_content',
                'default_on_front' => 'call',
            ),
            'person_link_new_window' => array(
                'label' => esc_html__('Link Target', 'et_builder'),
                'type' => 'select',
                'option_category' => 'configuration',
                'options' => array(
                    'off' => esc_html__('In The Same Window', 'et_builder'),
                    'on' => esc_html__('In The New Tab', 'et_builder'),
                ),
                'toggle_slug' => 'link_window',
                'description' => esc_html__('Here you can choose whether or not your link opens in a new window', 'et_builder'),
            ),
            'person_icon_color' => array(
                'label' => esc_html__('Icon Color', 'et_builder'),
                'description' => esc_html__('Here you can define a custom color for the social network icon.', 'et_builder'),
                'type' => 'color-alpha',
                'default' => '#ffffff',
                'custom_color' => true,
                'tab_slug' => 'advanced',
                'toggle_slug' => 'icon',
                'hover' => 'tabs',
                'mobile_options' => true,
            ),
            'person_icon_font_size' => array(
                'label' => esc_html__('Icon Font Size', 'et_builder'),
                'description' => esc_html__('Control the size of the icon by increasing or decreasing the font size.', 'et_builder'),
                'type' => 'range',
                'option_category' => 'font_option',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'icon',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'default' => '16px',
                'default_unit' => 'px',
                'default_on_front' => '',
                'range_settings' => array(
                    'min' => '1',
                    'max' => '120',
                    'step' => '1',
                ),
                'mobile_options' => true,
                'responsive' => true,
                'hover' => 'tabs',
            ),
        );

        return $fields;
    }

    public function render($attrs, $content, $render_slug)
    {

        $multi_view = et_pb_multi_view_options($this);

        $person_social_network = $this->props['person_social_network'];
        $url = $this->props['url'];
        $skype_url = $this->props['skype_url'];
        $skype_action = $this->props['skype_action'];
        $person_link_new_window = $this->props['person_link_new_window'];

        // Social Icon Color
        $person_icon_color_hover = $this->get_hover_value('person_icon_color');
        $person_icon_color_values = et_pb_responsive_options()->get_property_values($this->props, 'person_icon_color');

        et_pb_responsive_options()->generate_responsive_css($person_icon_color_values, '%%order_class%% .dnxte-person-sn a', 'color', $render_slug, '', 'color');

        if (et_builder_is_hover_enabled('person_icon_color', $this->props)) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .dnxte-person-sn a:hover',
                'declaration' => sprintf(
                    'color: %1$s;',
                    esc_html($person_icon_color_hover)
                ),
            ));
        }

        // Social Icon Size
        $person_icon_font_size_hover = $this->get_hover_value('person_icon_font_size');
        $person_icon_font_size_values = et_pb_responsive_options()->get_property_values($this->props, 'person_icon_font_size');

        // Proccess for each devices.
        foreach ($person_icon_font_size_values as $person_icon_font_size_key => $person_icon_font_size_value) {
            if ('' === $person_icon_font_size_value) {
                continue;
            }

            $media_query = 'general';
            if ('tablet' === $person_icon_font_size_key) {
                $media_query = ET_Builder_Element::get_media_query('max_width_980');
            } elseif ('phone' === $person_icon_font_size_key) {
                $media_query = ET_Builder_Element::get_media_query('max_width_767');
            }

            $person_icon_font_size_value_int = (int) $person_icon_font_size_value;
            $person_icon_font_size_value_unit = str_replace($person_icon_font_size_value_int, '', $person_icon_font_size_value);
            $person_icon_font_size_value_double = 0 < $person_icon_font_size_value_int ? $person_icon_font_size_value_int * 2 : 0;
            $person_icon_font_size_value_double = (string) $person_icon_font_size_value_double . $person_icon_font_size_value_unit;

            // Icon.
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .dnxte-person-sn a span::before',
                'declaration' => sprintf(
                    'font-size:%1$s; line-height:%2$s; height:%2$s; width:%2$s;',
                    esc_html($person_icon_font_size_value),
                    esc_html($person_icon_font_size_value_double)
                ),
                'media_query' => $media_query,
            ));

            // Icon hover styles.
            if (et_builder_is_hover_enabled('person_icon_font_size', $this->props) && !empty($person_icon_font_size_hover)) {
                $person_icon_font_size_hover_int = (int) $person_icon_font_size_hover;
                $person_icon_font_size_hover_unit = str_replace($person_icon_font_size_hover_int, '', $person_icon_font_size_hover);

                $person_icon_font_size_hover_double = 0 < $person_icon_font_size_hover_int ? $person_icon_font_size_hover_int * 2 : 0;
                $person_icon_font_size_hover_double = (string) $person_icon_font_size_hover_double . $person_icon_font_size_hover_unit;

                // Icon.
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => '%%order_class%% .dnxte-person-sn a span:hover::before',
                    'declaration' => sprintf(
                        'font-size:%1$s; line-height:%2$s; height:%2$s; width:%2$s;',
                        esc_html($person_icon_font_size_hover),
                        esc_html($person_icon_font_size_hover_double)
                    ),
                ));
            }
        }

        if ('skype' === $person_social_network) {
            $skype_url = sprintf(
                'skype:%1$s?%2$s',
                sanitize_text_field($skype_url),
                sanitize_text_field($skype_action)
            );
        }

        $person_url = 'skype' === $person_social_network ? $skype_url : esc_url($url);

        $person_social_icon = $this->props['person_social_icon'];
        $social_icon = '<span class="" data-icon="' . esc_attr(et_pb_process_font_icon($person_social_icon)) . '"></span>';

        $social_bg_color = array(
            "facebook",
            "twitter",
            "pinterest",
            "linkedin",
            "tumblr",
            "instagram",
            "skype",
            "flikr",
            "dribbble",
            "youtube",
            "vimeo",
        );

        if (in_array($person_social_network, $social_bg_color, true)) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% {$this->props['person_social_network']} span::before",
                'declaration' => "background-color: {$this->props['background_color']} !important",
            ));
        }

        $person_target = 'on' === $person_link_new_window ? '_blank' : '';

        $output = "<li class='dnxte-person-sn'>
						<a href='{$person_url}' class='dnext-person-{$person_social_network}' target='{$person_target}'>
							{$social_icon}
						</a>
					</li>";

        return $output;
    }
}

new DNXT_Person_Item;
