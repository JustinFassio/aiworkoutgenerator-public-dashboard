<?php
include_once(DIVI_ESSENTIAL_PATH.'/includes/modules/base/Common.php');

class Divi_NxtePriceList extends ET_Builder_Module
{
    public $slug = 'dnxte_price_list_parent';
    public $vb_support = 'on';
    public $child_slug = 'dnxte_price_list_child';

    protected $module_credits = array(
        'module_uri' => 'https://www.diviessential.com/divi-price-list/',
        'author' => 'Divi Next',
        'author_uri' => 'www.divinext.com',
    );

    public function init()
    {
        $this->name        = esc_html__('Next Price List', 'et_builder');
        $this->icon_path   = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->folder_name = 'et_pb_divi_essential';

        $this->settings_modal_toggles = array(
            'advanced' => array(
                'toggles' => array(
                    'dnxte_pricelist_separator' => array(
                        'title' => esc_html__('Separator', 'et_builder'),
                        'priority' => 70,
                    ),
                    'dnxte_pricelist_divider' => array(
                        'title' => esc_html__('Divider', 'et_builder'),
                        'priority' => 70,
                    ),
                    'dnxte_pricelist_image' => array(
                        'title' => esc_html__('Image', 'et_builder'),
                        'priority' => 69,
                    ),
                ),
            ),
        );
    }

    public function get_advanced_fields_config()
    {
        return array(
            'fonts' => array(
                'header' => array(
                    'label' => esc_html__('Title', 'et_builder'),
                    'css' => array(
                        'main' => '%%order_class%% .dnxte-pricelist-title',
                    ),
                    'font_size' => array(
                        'default' => '26px',
                    ),
                    'line_height' => array(
                        'default' => '1em',
                    ),
                    'letter_spacing' => array(
                        'default' => '0px',
                    ),
                    'hide_header_level' => true,
                    'hide_text_align' => true,
                ),
                'content' => array(
                    'label' => esc_html__('Description', 'et_builder'),
                    'css' => array(
                        'main' => '%%order_class%% .dnxte-pricelist-description',
                    ),
                    'font_size' => array(
                        'default' => '14px',
                    ),
                    'line_height' => array(
                        'default' => '1em',
                    ),
                    'letter_spacing' => array(
                        'default' => '0px',
                    ),
                    'hide_text_align' => true,
                ),
                'price' => array(
                    'label' => esc_html__('Price', 'et_builder'),
                    'css' => array(
                        'main' => '%%order_class%% .dnxte-pricelist-price',
                    ),
                    'font_size' => array(
                        'default' => '18px',
                    ),
                    'line_height' => array(
                        'default' => '1em',
                    ),
                    'letter_spacing' => array(
                        'default' => '0px',
                    ),
                    'hide_text_align' => true,
                ),
            ),
            'text' => array(
                'use_text_orientation' => false,
                'use_background_layout' => false,
                'css' => array(
                    'text_shadow' => '%%order_class%% .dnxte_price_list_child',
                ),
            ),
            'borders' => array(
                'default' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => "%%order_class%%",
                            'border_styles' => "%%order_class%%",
                        ),
                    ),
                ),
                'image' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => "%%order_class%% .dnxte-pricelist-image img",
                            'border_styles' => "%%order_class%% .dnxte-pricelist-image img",
                        ),
                    ),
                    'label_prefix' => esc_html__('Image', 'et_builder'),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'image',
                ),
                'image_price' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => "%%order_class%% .dnxte-pricelist-price",
                            'border_styles' => "%%order_class%% .dnxte-pricelist-price",
                        ),
                    ),
                    'label_prefix' => esc_html__('Price', 'et_builder'),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'price',
                ),
            ),
            'box_shadow' => array(
                'default' => array(
                    'css' => array(
                        'main' => '%%order_class%%',
                    ),
                ),
                'image' => array(
                    'label' => esc_html__('Image Box Shadow', 'et_builder'),
                    'option_category' => 'layout',
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'image',
                    'css' => array(
                        'main' => '%%order_class%% .dnxte-pricelist-image img',
                    ),
                    'default_on_fronts' => array(
                        'color' => '',
                        'position' => '',
                    ),
                ),
                'image_price' => array(
                    'label' => esc_html__('Price Box Shadow', 'et_builder'),
                    'option_category' => 'layout',
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'price',
                    'css' => array(
                        'main' => '%%order_class%% .dnxte-pricelist-price',
                    ),
                    'default_on_fronts' => array(
                        'color' => '',
                        'position' => '',
                    ),
                ),
            ),
        );
    }

    public function get_fields()
    {
        return array(
            'dnxte_pricelist_image_width' => array(
                'label' => esc_html__('Image Width', 'et_builder'),
                'type' => 'range',
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'image',
                'validate_unit' => true,
                'depends_show_if' => 'off',
                'default' => '50%',
                'default_unit' => '%',
                'default_on_front' => '',
                'allow_empty' => true,
                'range_settings' => array(
                    'min' => '0',
                    'max' => '50',
                    'step' => '1',
                ),
                'mobile_options' => true,
                'responsive' => true,
                'hover' => 'tabs',
            ),
            'dnxte_pricelist_image_spacing' => array(
                'label' => esc_html__('Image Gap Spacing', 'et_builder'),
                'type' => 'range',
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'image',
                'validate_unit' => true,
                'default' => '25px',
                'default_unit' => 'px',
                'default_on_front' => '',
                'allow_empty' => true,
                'range_settings' => array(
                    'min' => '0',
                    'max' => '50',
                    'step' => '1',
                ),
                'mobile_options' => true,
                'responsive' => true,
                'hover' => 'tabs',
            ),
            'dnxte_pricelist_separator_style' => array(
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
                'toggle_slug' => 'dnxte_pricelist_separator',
            ),
            'dnxte_pricelist_separator_width' => array(
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
                'toggle_slug' => 'dnxte_pricelist_separator',
                'show_if_not' => array(
                    'dnxte_pricelist_separator_style' => 'none',
                ),
            ),
            'dnxte_pricelist_separator_color' => array(
                'label' => esc_html__('Color', 'et_builder'),
                'type' => 'color-alpha',
                'default' => '#333',
                'description' => esc_html__('Here you can define a custom color for your separator.', 'et_builder'),
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxte_pricelist_separator',
                'show_if_not' => array(
                    'dnxte_pricelist_separator_style' => 'none',
                ),
            ),
            'dnxte_pricelist_separator_gap' => array(
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
                'toggle_slug' => 'dnxte_pricelist_separator',
                'mobile_options' => true,
                'responsive' => true,
                'hover' => 'tabs',
                'show_if_not' => array(
                    'dnxte_pricelist_separator_style' => 'none',
                ),
            ),
            'dnxte_pricelist_divider_style' => array(
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
                'toggle_slug' => 'dnxte_pricelist_divider',
            ),
            'dnxte_pricelist_divider_width' => array(
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
                'toggle_slug' => 'dnxte_pricelist_divider',
                'show_if_not' => array(
                    'dnxte_pricelist_divider_style' => 'none',
                ),
            ),
            'dnxte_pricelist_divider_color' => array(
                'default' => 'rgba(0,0,0,0.12)',
                'label' => esc_html__('Color', 'et_builder'),
                'type' => 'color-alpha',
                'description' => esc_html__('Here you can define a custom color for your divider.', 'et_builder'),
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxte_pricelist_divider',
                'show_if_not' => array(
                    'dnxte_pricelist_divider_style' => 'none',
                ),
            ),
            'dnxte_pricelist_item_padding' => array(
                'label' => esc_html__('Item Padding', 'et_builder'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'option_category' => 'layout',
                'description' => esc_html__('Adjust padding to specific values, or leave blank to use the default padding.', 'et_builder'),
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
            ),
            'dnxte_pricelist_vertical_alignment' => array(
                'label' => esc_html__('Vertical Alignment', 'et_builder'),
                'type' => 'select',
                'option_category' => 'layout',
                'options' => array(
                    'flex-start' => esc_html__('Top', 'et_builder'),
                    'center' => esc_html__('Center', 'et_builder'),
                    'flex-end' => esc_html__('Bottom', 'et_builder'),
                ),
                'default' => 'flex-start',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'text',
                'description' => esc_html__('This setting determines the vertical alignment of your content. Your content can either be align to the top, vertically centered, or aligned to the bottom.', 'et_builder'),
            ),
        );
    }

    public function render($attrs, $content, $render_slug)
    {
        $border_bottom_style = $this->props['dnxte_pricelist_separator_style'];
        $border_bottom_width = $this->props['dnxte_pricelist_separator_width'];
        $border_bottom_color = $this->props['dnxte_pricelist_separator_color'];
        $separator_gap = $this->props['dnxte_pricelist_separator_gap'];
        $divider_border_style = $this->props['dnxte_pricelist_divider_style'];
        $divider_border_width = $this->props['dnxte_pricelist_divider_width'];
        $divider_border_color = $this->props['dnxte_pricelist_divider_color'];

        if ("none" !== $border_bottom_style) {
            $separator_style = sprintf('border-bottom-style: %1$s;border-bottom-width: %2$s; border-bottom-color: %3$s; margin-left: %4$s; margin-right: %4$s;', esc_attr($border_bottom_style), esc_attr($border_bottom_width), esc_attr($border_bottom_color), esc_attr($separator_gap));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte-pricelist-separator",
                'declaration' => $separator_style,
            ));
        } elseif ("none" === $border_bottom_style) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte-pricelist-separator",
                'declaration' => sprintf('border-bottom-style: none'),
            ));
        }

        if ("none" !== $divider_border_style) {
            $divider_style = sprintf('border-bottom-style: %1$s;border-bottom-width: %2$s; border-bottom-color: %3$s;', esc_attr($divider_border_style), esc_attr($divider_border_width), esc_attr($divider_border_color));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte_price_list_child:not(:last-child)",
                'declaration' => $divider_style,
            ));
        } elseif ("none" === $divider_border_style) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte_price_list_child:not(:last-child)",
                'declaration' => sprintf('border-bottom-style: none'),
            ));
        }

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .dnxte-pricelist-wrapper",
            'declaration' => sprintf('align-items: %1$s', esc_attr($this->props['dnxte_pricelist_vertical_alignment'])),
        ));

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .dnxte-pricelist-image",
            'declaration' => sprintf('max-width: %1$s;margin-right: %2$s;', esc_attr($this->props['dnxte_pricelist_image_width']), esc_attr($this->props['dnxte_pricelist_image_spacing'])),
        ));

        $this->apply_css($render_slug);
        return sprintf('%1$s', $this->props['content']);
    }

    public function apply_css($render_slug)
    {

        /**
         * Custom Padding Margin Output
         *
         */
        Common::dnxt_set_style($render_slug, $this->props, "dnxte_pricelist_item_padding", "%%order_class%% .dnxte_price_list_child", "padding");
    }

}

new Divi_NxtePriceList;
