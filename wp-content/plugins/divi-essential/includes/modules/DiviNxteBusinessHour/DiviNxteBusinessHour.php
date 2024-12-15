<?php
include_once(DIVI_ESSENTIAL_PATH.'/includes/modules/base/Common.php');

class Divi_NxteBusinessHour extends ET_Builder_Module
{
    public $slug = 'dnxte_business_hour_parent';
    public $vb_support = 'on';
    public $child_slug = 'dnxte_business_hour_child';

    protected $module_credits = array(
        'module_uri' => 'https://www.diviessential.com/divi-business-hour/',
        'author' => 'Divi Next',
        'author_uri' => 'www.divinext.com',
    );

    public function init()
    {
        $this->name        = esc_html__('Next Business Hour', 'et_builder');
        $this->icon_path   = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->folder_name = 'et_pb_divi_essential';

        $this->settings_modal_toggles = array(
            'general' => array(),
            'advanced' => array(
                'toggles' => array(
                    'separator' => array(
                        'title' => esc_html__('Separator', 'et_builder'),
                        'priority' => 70,
                    ),
                    'divider' => array(
                        'title' => esc_html__('Divider', 'et_builder'),
                        'priority' => 70,
                    ),
                ),
            ),
        );
    }

    public function get_advanced_fields_config()
    {
        return array(
            'fonts' => array(
                'text' => array(
                    'label' => esc_html__('', 'et_builder'),
                    'css' => array(
                        'main' => '%%order_class%% .dnxte_business_hour_child .dnxte-Busihr-wekname',
                    ),
                    'font_size' => array(
                        'default' => '14px',
                    ),
                    'line_height' => array(
                        'default' => '1.7em',
                    ),
                    'letter_spacing' => array(
                        'default' => '0px',
                    ),
                    'hide_header_level' => true,
                    'hide_text_align' => true,
                    'hide_text_shadow' => true,
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'text',
                ),
                'header' => array(
                    'label' => esc_html__('Day', 'et_builder'),
                    'css' => array(
                        'main' => '%%order_class%% .dnxte-Busihr-dtday',
                    ),
                    'font_size' => array(
                        'default' => '14px',
                    ),
                    'line_height' => array(
                        'default' => '1.7em',
                    ),
                    'letter_spacing' => array(
                        'default' => '0px',
                    ),
                    'hide_header_level' => true,
                    'hide_text_align' => true,
                ),
                'time' => array(
                    'label' => esc_html__('Time', 'et_builder'),
                    'css' => array(
                        'main' => '%%order_class%% .dnxte-Busihr-dttime',
                    ),
                    'font_size' => array(
                        'default' => '14px',
                    ),
                    'line_height' => array(
                        'default' => '1.7em',
                    ),
                    'letter_spacing' => array(
                        'default' => '0px',
                    ),
                    'hide_text_align' => true,
                ),
            ),
        );
    }

    public function get_fields()
    {
        return array(
            'dnxte_busihr_bg_striped' => array(
                'label' => esc_html__('Use Striped Background', 'et_builder'),
                'type' => 'yes_no_button',
                'description' => esc_html__('Content entered here will appear inside the module.', 'et_builder'),
                'options' => array(
                    'on' => esc_html__('Yes', 'et_builder'),
                    'off' => esc_html__('No', 'et_builder'),
                ),
                'default' => 'off',
                'default_on_front' => 'off',
                'toggle_slug' => 'background',
            ),
            'dnxte_busihr_odd_background' => array(
                'label' => esc_html__('Striped Odd Background Color', 'et_builder'),
                'type' => 'color-alpha',
                'custom_color' => true,
                'default' => '#f9f9f9',
                'toggle_slug' => 'background',
                'responsive' => true,
                'mobile_options' => true,
                'show_if' => array(
                    'dnxte_busihr_bg_striped' => 'on',
                ),
            ),
            'dnxte_busihr_even_background' => array(
                'label' => esc_html__('Striped Even Background Color', 'et_builder'),
                'type' => 'color-alpha',
                'custom_color' => true,
                'default' => '#fff',
                'toggle_slug' => 'background',
                'responsive' => true,
                'mobile_options' => true,
                'show_if' => array(
                    'dnxte_busihr_bg_striped' => 'on',
                ),
            ),
            'dnxte_busihr_separator_style' => array(
                'label' => esc_html__('Style', 'et_builder'),
                'type' => 'select',
                'option_category' => 'configuration',
                'options' => array(
                    'none' => esc_html__('None', 'et_builder'),
                    'solid' => esc_html__('Solid', 'et_builder'),
                    'dotted' => esc_html__('Dotted', 'et_builder'),
                    'dashed' => esc_html__('Dashed', 'et_builder'),
                    'double' => esc_html__('Double', 'et_builder'),
                    'groove' => esc_html__('Groove', 'et_builder'),
                    'ridge' => esc_html__('Ridge', 'et_builder'),
                    'inset' => esc_html__('Inset', 'et_builder'),
                    'outset' => esc_html__('Outset', 'et_builder'),
                ),
                'default' => 'none',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'separator',
            ),
            'dnxte_busihr_separator_width' => array(
                'label' => esc_html__('Width', 'et_builder'),
                'type' => 'range',
                'option_category' => 'configuration',
                'default' => '2px',
                'default_on_front' => '2px',
                'default_unit' => 'px',
                'range_settings' => array(
                    'min' => '0',
                    'max' => '10',
                    'step' => '1',
                ),
                'tab_slug' => 'advanced',
                'toggle_slug' => 'separator',
                'show_if_not' => array(
                    'dnxte_busihr_separator_style' => 'none',
                ),
            ),
            'dnxte_busihr_separator_color' => array(
                'default' => '#333',
                'label' => esc_html__('Color', 'et_builder'),
                'type' => 'color-alpha',
                'description' => esc_html__('Here you can define a custom color for your separator.', 'et_builder'),
                'tab_slug' => 'advanced',
                'toggle_slug' => 'separator',
                'show_if_not' => array(
                    'dnxte_busihr_separator_style' => 'none',
                ),
            ),
            'dnxte_busihr_separator_gap' => array(
                'label' => esc_html__('Gap Spacing', 'et_builder'),
                'type' => 'range',
                'option_category' => 'configuration',
                'default' => '10px',
                'default_on_front' => '10px',
                'default_unit' => 'px',
                'range_settings' => array(
                    'min' => '0',
                    'max' => '40',
                    'step' => '1',
                ),
                'tab_slug' => 'advanced',
                'toggle_slug' => 'separator',
            ),
            'dnxte_busihr_divider_style' => array(
                'label' => esc_html__('Style', 'et_builder'),
                'type' => 'select',
                'option_category' => 'configuration',
                'options' => array(
                    'none' => esc_html__('None', 'et_builder'),
                    'solid' => esc_html__('Solid', 'et_builder'),
                    'dotted' => esc_html__('Dotted', 'et_builder'),
                    'dashed' => esc_html__('Dashed', 'et_builder'),
                    'double' => esc_html__('Double', 'et_builder'),
                    'groove' => esc_html__('Groove', 'et_builder'),
                    'ridge' => esc_html__('Ridge', 'et_builder'),
                    'inset' => esc_html__('Inset', 'et_builder'),
                    'outset' => esc_html__('Outset', 'et_builder'),
                ),
                'default' => 'solid',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'divider',
            ),
            'dnxte_busihr_divider_width' => array(
                'label' => esc_html__('Width', 'et_builder'),
                'type' => 'range',
                'option_category' => 'configuration',
                'default' => '1px',
                'default_on_front' => '1px',
                'default_unit' => 'px',
                'range_settings' => array(
                    'min' => '0',
                    'max' => '20',
                    'step' => '1',
                ),
                'tab_slug' => 'advanced',
                'toggle_slug' => 'divider',
                'show_if_not' => array(
                    'dnxte_busihr_divider_style' => 'none',
                ),
            ),
            'dnxte_busihr_divider_color' => array(
                'default' => 'rgba(0,0,0,0.12)',
                'label' => esc_html__('Color', 'et_builder'),
                'type' => 'color-alpha',
                'description' => esc_html__('Here you can define a custom color for your divider.', 'et_builder'),
                'tab_slug' => 'advanced',
                'toggle_slug' => 'divider',
                'show_if_not' => array(
                    'dnxte_busihr_divider_style' => 'none',
                ),
            ),
            'dnxte_busihr_item_padding' => array(
                'label' => esc_html__('Item Padding', 'et_builder'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'option_category' => 'layout',
                'description' => esc_html__('Adjust padding to specific values, or leave blank to use the default padding.', 'et_builder'),
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
            ),
        );
    }

    public function render($attrs, $content, $render_slug)
    {
        if ("off" !== $this->props['dnxte_busihr_bg_striped']) {
            $striped_background_color_odd = sprintf('background-color: %1$s;', $this->props['dnxte_busihr_odd_background']);
            $striped_background_color_even = sprintf('background-color: %1$s;', $this->props['dnxte_busihr_even_background']);

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte_business_hour_child:nth-child(odd)",
                'declaration' => $striped_background_color_odd,
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte_business_hour_child:nth-child(even)",
                'declaration' => $striped_background_color_even,
            ));
        }

        if ("none" !== $this->props['dnxte_busihr_separator_style']) {
            $separator_style = sprintf('border-bottom-style: %1$s;border-bottom-width: %2$s; border-bottom-color: %3$s; margin-left: %4$s; margin-right: %4$s;', $this->props['dnxte_busihr_separator_style'], $this->props['dnxte_busihr_separator_width'], $this->props['dnxte_busihr_separator_color'], $this->props['dnxte_busihr_separator_gap']);

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte-Busihr-separator",
                'declaration' => $separator_style,
            ));
        }

        if ("none" === $this->props['dnxte_busihr_separator_style']) {
            $separator_style = sprintf('border-bottom-style: none');
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte-Busihr-separator",
                'declaration' => $separator_style,
            ));
        }

        if ("none" !== $this->props['dnxte_busihr_divider_style']) {
            $divider_style = sprintf('border-bottom-style: %1$s;border-bottom-width: %2$s; border-bottom-color: %3$s;', $this->props['dnxte_busihr_divider_style'], $this->props['dnxte_busihr_divider_width'], $this->props['dnxte_busihr_divider_color']);

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte_business_hour_child:not(:last-child)",
                'declaration' => $divider_style,
            ));
        }

        if ("none" === $this->props['dnxte_busihr_divider_style']) {
            $divider_style = sprintf('border-bottom-style: none');

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte_business_hour_child:not(:last-child)",
                'declaration' => $divider_style,
            ));
        }

        $this->apply_css($render_slug);
        return sprintf('<div class="dnxte-Busihr-wrapper">%1$s</div>', $this->content);
    }

    public function apply_css($render_slug)
    {

        /**
         * Custom Padding Margin Output
         *
         */
        Common::dnxt_set_style($render_slug, $this->props, "dnxte_busihr_item_padding", "%%order_class%% .dnxte-Busihr-wekname", "padding");
    }
}

new Divi_NxteBusinessHour;
