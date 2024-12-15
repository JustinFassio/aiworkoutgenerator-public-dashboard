<?php
include_once(DIVI_ESSENTIAL_PATH.'/includes/modules/base/Common.php');

class Divi_NxtePriceListChild extends ET_Builder_Module
{
    public $slug = 'dnxte_price_list_child';
    public $vb_support = 'on';
    public $type = 'child';
    public $child_title_var = 'admin_label_text';
    public $child_title_fallback_var = 'dnxte_pricelist_image_alt';

    protected $module_credits = array(
        'module_uri' => 'https://www.diviessential.com/divi-price-list/',
        'author' => 'Divi Next',
        'author_uri' => 'www.divinext.com',
    );

    public function init()
    {
        $this->name = esc_html__('Price List Item', 'et_builder');
        $this->icon_path = plugin_dir_path(__FILE__) . 'icon.svg';

        $this->settings_modal_toggles = array(
            'general' => array(
                'toggles' => array(
                    'dnxte_pricelist_image_settings' => array(
                        'title' => esc_html__('Image', 'et_builder'),
                        'priority' => 10,
                    ),
                    'admin_label' => array(
                        'title' => esc_html__("Admin Label", 'et_builder'),
                        'priority' => 100
                    )
                ),
            ),
            'advanced' => array(
                'toggles' => array(
                    'dnxte_pricelist_img' => esc_html__('Image', 'et_builder'),
                ),
            ),
        );

        $this->custom_css_fields = array(
            'title' => array(
                'label' => esc_html__('Title', 'et_builder'),
                'selector' => '%%order_class%% .dnxte-pricelist-title',
            ),
            'description' => array(
                'label' => esc_html__('Description', 'et_builder'),
                'selector' => '%%order_class%% .dnxte-pricelist-description',
            ),
            'image' => array(
                'label' => esc_html__('Image', 'et_builder'),
                'selector' => '%%order_class%% .dnxte-pricelist-image',
            ),
            'separator' => array(
                'label' => esc_html__('Separator', 'et_builder'),
                'selector' => '%%order_class%% .dnxte-pricelist-separator',
            ),
            'price' => array(
                'label' => esc_html__('Price', 'et_builder'),
                'selector' => '%%order_class%% .dnxte-pricelist-price',
            ),
        );
    }

    public function get_advanced_fields_config()
    {
        return array(
            'text'  => false,
            'fonts' => false,
            'borders' => array(
                'default' => array(),
                'image' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => "%%order_class%% .dnxte-pricelist-image img",
                            'border_styles' => "%%order_class%% .dnxte-pricelist-image img",
                        ),
                    ),
                    'label_prefix' => esc_html__('Image', 'et_builder'),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxte_pricelist_img',
                ),
            ),
            'box_shadow' => array(
                'default' => array(),
                'image' => array(
                    'label' => esc_html__('Image Box Shadow', 'et_builder'),
                    'option_category' => 'layout',
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxte_pricelist_img',
                    'css' => array(
                        'main' => '%%order_class%% .dnxte-pricelist-image img',
                    ),
                    'default_on_fronts' => array(
                        'color' => '',
                        'position' => '',
                    ),
                ),
            ),
            'filters' => array(
                'css' => array(
                    'main' => '%%order_class%% .dnxte-pricelist-image img',
                ),
            ),
        );
    }

    public function get_fields()
    {
        return array(
            // Admin Label
            'admin_label_text' => array(
                'label' => esc_html__('Admin Label', 'et_builder'),
                'type' => 'text',
                'option_category' => 'basic_option',
                'description'     => esc_html__('This will change the label of the module in the builder for easy identification.', 'et_builder'),
                'toggle_slug' => 'admin_label',
            ),
            // Image
            'dnxte_pricelist_image' => array(
                'label' => esc_html__('Image', 'et_builder'),
                'type' => 'upload',
                'option_category' => 'basic_option',
                'upload_button_text' => esc_attr__(
                    'Upload an image',
                    'et_builder'
                ),
                'choose_text' => esc_attr__('Choose an Image', 'et_builder'),
                'update_text' => esc_attr__('Set As Image', 'et_builder'),
                'description' => esc_html__(
                    'Upload an image to display at the top of your blurb.',
                    'et_builder'
                ),
                'toggle_slug' => 'dnxte_pricelist_image_settings',
                'dynamic_content' => 'image',
                'mobile_options' => true,
                'hover' => 'tabs',
            ),
            // Image alt
            'dnxte_pricelist_image_alt' => array(
                'label' => esc_html__('Image Alt Text', 'et_builder'),
                'type' => 'text',
                'default' => 'Price List Item',
                'option_category' => 'basic_option',
                'description' => esc_html__(
                    'Define the HTML ALT text for your image here.',
                    'et_builder'
                ),
                'toggle_slug' => 'dnxte_pricelist_image_settings',
                'dynamic_content' => 'text',
            ),
            // Heading Text
            'dnxte_pricelist_heading_text' => array(
                'label' => esc_html__('Heading Text', 'et_builder'),
                'type' => 'text',
                'dynamic_content' => 'text',
                'option_category' => 'basic_option',
                'description' => esc_html__('Heading Text entered here will appear inside the module.', 'et_builder'),
                'toggle_slug' => 'main_content',
            ),
            // Price
            'dnxte_pricelist_price' => array(
                'label'           => esc_html__( 'Price', 'et_builder' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Price of the item', 'et_builder' ),
				'toggle_slug'     => 'main_content',
				'default' => '0$',
				'default_on_front' => '0$',
            ),
            // Content
            'dnxte_pricelist_description' => array(
                'label' => esc_html__('Content', 'et_builder'),
                'type' => 'tiny_mce',
                'dynamic_content' => 'text',
                'option_category' => 'basic_option',
                'description' => esc_html__('Content entered here will appear inside the module.', 'et_builder'),
                'toggle_slug' => 'main_content',
            ),
            'dnxte_pricelist_image_width' => array(
                'label' => esc_html__('Image Width', 'et_builder'),
                'type' => 'range',
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxte_pricelist_img',
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
                'toggle_slug' => 'dnxte_pricelist_img',
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
            'dnxte_pricelist_title_margin' => array(
                'label' => esc_html__('Title Margin', 'et_builder'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'option_category' => 'layout',
                'description' => esc_html__('Adjust padding to specific values, or leave blank to use the default margin.', 'et_builder'),
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
            ),
            'dnxte_pricelist_title_padding' => array(
                'label' => esc_html__('Title Padding', 'et_builder'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'option_category' => 'layout',
                'description' => esc_html__('Adjust padding to specific values, or leave blank to use the default padding.', 'et_builder'),
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
            ),
            'dnxte_pricelist_desc_margin' => array(
                'label' => esc_html__('Description Margin', 'et_builder'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'option_category' => 'layout',
                'description' => esc_html__('Adjust padding to specific values, or leave blank to use the default margin.', 'et_builder'),
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
            ),
            'dnxte_pricelist_desc_padding' => array(
                'label' => esc_html__('Description Padding', 'et_builder'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'option_category' => 'layout',
                'description' => esc_html__('Adjust padding to specific values, or leave blank to use the default padding.', 'et_builder'),
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
            ),
            'dnxte_pricelist_image_margin' => array(
                'label' => esc_html__('Image Margin', 'et_builder'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'option_category' => 'layout',
                'description' => esc_html__('Adjust padding to specific values, or leave blank to use the default margin.', 'et_builder'),
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
            ),
            'dnxte_pricelist_image_padding' => array(
                'label' => esc_html__('Image Padding', 'et_builder'),
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

        $multi_view = et_pb_multi_view_options($this);
        $dnext_image = $this->props['dnxte_pricelist_image'];
        $dnext_image_alt = $this->props['dnxte_pricelist_image_alt'];
        $dnext_title_text = $this->props['dnxte_pricelist_heading_text'];
        $dnext_price_text = $this->props['dnxte_pricelist_price'];
        $dnext_desc_text = $this->props['dnxte_pricelist_description'];

        $image_html = $multi_view->render_element(array(
            'tag' => 'img',
            'attrs' => array(
                'src' => '{{dnxte_pricelist_image}}',
                'alt' => '{{dnxte_pricelist_image_alt}}',
            ),
            'required' => 'dnxte_pricelist_image',
        ));

        // Image
        $dnext_img = sprintf(
            '%1$s',
            $image_html
        );

        // Title Text
        $dnext_title = '';
        if ('' !== $dnext_title_text) {
            $dnext_title = sprintf('<div class="dnxte-pricelist-title">%1$s</div>', et_core_esc_previously($dnext_title_text));
        }

        /* // Description Text
        $dnext_desc = "";
        if ('' !== $dnext_desc_text) {
            $dnext_desc = sprintf('<div class="dnxte-pricelist-description">%1$s</div>', wpautop($dnext_desc_text));
        } */

        $dnext_desc = $multi_view->render_element( array(
            'tag' => 'div',
            'content' => '{{dnxte_pricelist_description}}',
            'attrs' => array(
                'class' => 'dnxte-pricelist-description',
            )
            ));

        // Price Text
        $dnext_price = "";
        if ('' !== $dnext_price_text) {
            $dnext_price = sprintf('<div class="dnxte-pricelist-price">%1$s</div>', et_core_esc_previously($dnext_price_text));
        }

        // Image Width Style
        $image_style = sprintf('max-width: %1$s !important; margin-right: %2$s !important;', esc_attr($this->props['dnxte_pricelist_image_width']), esc_attr($this->props['dnxte_pricelist_image_spacing']));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .dnxte-pricelist-image",
            'declaration' => $image_style,
        ));

        $this->apply_css( $render_slug );

        return sprintf(
            '<div class="dnxte-pricelist-wrapper">
                <div class="dnxte-pricelist-image">
                %1$s
                </div>
                <div class="dnxte-pricelist-item-wrapper">
                <div class="dnxte-pricelist-header">
                %2$s
                    <div class="dnxte-pricelist-separator"></div>
                    %4$s
                </div>
                %3$s
                </div>
            </div>',
            $dnext_img,
            $dnext_title,
            $dnext_desc,
            $dnext_price
        );
    }

    public function apply_css( $render_slug ) {
        Common::dnxt_set_style($render_slug, $this->props, "dnxte_pricelist_title_margin", "%%order_class%% .dnxte-pricelist-title", "margin", true);
        Common::dnxt_set_style($render_slug, $this->props, "dnxte_pricelist_title_padding", "%%order_class%% .dnxte-pricelist-title", "padding", true);

        Common::dnxt_set_style($render_slug, $this->props, "dnxte_pricelist_desc_margin", "%%order_class%% .dnxte-pricelist-description", "margin", true);
        Common::dnxt_set_style($render_slug, $this->props, "dnxte_pricelist_desc_padding", "%%order_class%% .dnxte-pricelist-description", "padding", true);

        Common::dnxt_set_style($render_slug, $this->props, "dnxte_pricelist_image_margin", "%%order_class%% .dnxte-pricelist-image", "margin", true);
        Common::dnxt_set_style($render_slug, $this->props, "dnxte_pricelist_image_padding", "%%order_class%% .dnxte-pricelist-image", "padding", true);
    }
}

new Divi_NxtePriceListChild;
