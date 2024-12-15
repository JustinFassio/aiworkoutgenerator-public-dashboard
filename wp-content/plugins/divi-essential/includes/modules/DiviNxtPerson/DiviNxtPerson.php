<?php
include_once(DIVI_ESSENTIAL_PATH.'/includes/modules/base/Common.php');

class DNXT_Person extends ET_Builder_Module {

    public $slug = 'dnxte_person';
    public $vb_support = 'on';
    public $child_slug = 'dnxte_person_item';
    public $main_css_element = '%%order_class%%';

    protected $module_credits = array(
        'module_uri' => 'https://www.diviessential.com/divi-next-person/',
        'author'     => 'Divi Next',
        'author_uri' => 'www.divinext.com',
    );

    public function init() {
        $this->name        = esc_html__('Next Person', 'et_builder');
        $this->icon_path   = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->folder_name = 'et_pb_divi_essential';

        $this->settings_modal_toggles = array(
            'general' => array(
                'toggles' => array(
                    'dnext_team_img' => array(
                        'title' => esc_html__('Image', 'et_builder'),
                    ),
                    'teamsorev_img_bgc' => array(
                        'title' => esc_html__('Image Background', 'et_builder'),
                        'priority' => 80,
                        'sub_toggles' => array(
                            'sub_toggle_color' => array(
                                'icon' => 'background-color',
                            ),
                            'sub_toggle_gradient' => array(
                                'icon' => 'background-gradient',
                            ),
                            'sub_toggle_image' => array(
                                'icon' => 'background-image',
                            ),
                        ),
                        'tabbed_subtoggles' => true,
                        'bb_icons_support' => true,
                    ),
                    'person_bgc' => array(
                        'title' => esc_html__('Content Background', 'et_builder'),
                        'priority' => 80,
                        'sub_toggles' => array(
                            'sub_toggle_color' => array(
                                'icon' => 'background-color',
                            ),
                            'sub_toggle_gradient' => array(
                                'icon' => 'background-gradient',
                            ),
                        ),
                        'tabbed_subtoggles' => true,
                        'bb_icons_support' => true,
                    ),
                ),
            ),
            'advanced' => array(
                'toggles' => array(
                    'teamperson_effect' => array(
                        'title' => esc_html__('Style', 'et_builder'),
                    ),
                    'teamperson_image' => array(
                        'title' => esc_html__('Image', 'et_builder'),
                    ),
                    "person_alignment" => array(
                        'title' => esc_html__('Social Aligment', 'et_builder'),
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
                        'main' => "%%order_class%% h4.dnxte-nextperson-header, %%order_class%% h1.dnxte-nextperson-header, %%order_class%% h2.dnxte-nextperson-header, %%order_class%% h3.dnxte-nextperson-header, %%order_class%% h5.dnxte-nextperson-header, %%order_class%% h6.dnxte-nextperson-header",
                        'important' => 'plugin_only',
                    ),
                    'header_level' => array(
                        'default' => 'h4',
                    ),
                ),
                'body' => array(
                    'label' => esc_html__('Body', 'et_builder'),
                    'css' => array(
                        'main' => "%%order_class%% .dnxte-nextperson-wrapper .dnxte-nextperson-pra",
                    ),
                    'block_elements' => array(
                        'tabbed_subtoggles' => true,
                        'bb_icons_support' => true,
                    ),
                ),
                'position' => array(
                    'label' => esc_html__('Position', 'et_builder'),
                    'css' => array(
                        'main' => "%%order_class%% .dnxte-nextperson-wrapper p.dnxte-nextperson-pos",
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
                    'main' => "%%order_class%% .dnxte-nextperson-team-wrap",
                    'important' => true,
                ),
            ),
            'borders' => array(
                'default' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => "%%order_class%% .dnxte-nextperson-team-wrap",
                            'border_styles' => "%%order_class%% .dnxte-nextperson-team-wrap",
                        ),
                    ),
                ),
                'image' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => "%%order_class%% .dnxte-nextperson-img img",
                            'border_styles' => "%%order_class%% .dnxte-nextperson-img img",
                        ),
                    ),
                    'label_prefix' => esc_html__('Image'),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'teamperson_image',
                ),
                'content_border' => array(
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'teamperson_borders',
                    'css' => array(
                        'main' => array(
                            'border_radii' => "%%order_class%% .dnxte-nextperson-wrapper",
                            'border_radii_hover' => '%%order_class%%:hover .dnxte-nextperson-wrapper',
                            'border_styles' => "%%order_class%% .dnxte-nextperson-wrapper",
                            'border_styles_hover' => '%%order_class%%:hover .dnxte-nextperson-wrapper',
                        ),
                    ),
                    'defaults' => array(
                        'border_radii' => 'on|3px|3px|3px|3px',
                        'border_styles' => array(
                            'width' => '2px',
                            'color' => '#2857b6',
                            'style' => 'solid',
                        ),
                    ),
                ),
            ),
            'box_shadow' => array(
                'default' => array(
                    'css' => array(
                        'main' => "%%order_class%% .dnxte-nextperson-team-wrap",
                        'hover' => '%%order_class%%:hover .dnxte-nextperson-team-wrap',
                        'overlay' => 'inset',
                    ),
                ),
                'image' => array(
                    'label' => esc_html__('Image Box Shadow', 'et_builder'),
                    'option_category' => 'layout',
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'teamperson_image',
                    'css' => array(
                        'main' => '%%order_class%% .dnxte-nextperson-img img',
                        'custom_style' => true,
                    ),
                    'default_on_fronts' => array(
                        'color' => '',
                        'position' => '',
                    ),
                ),
            ),
            'margin_padding' => array(
                'css' => array(
                    'important' => 'all',
                ),
            ),
            'max_width' => array(
                'css' => array(
                    'module_alignment' => '%%order_class%%.dnxt_person',
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
            'person_image_wrapper' => array(
                'label' => esc_html__('Image', 'et_builder'),
                'selector' => '%%order_class%% .dnxte-nextperson-img',
            ),
            'person_content_wrapper' => array(
                'label' => esc_html__('Content Body', 'et_builder'),
                'selector' => '%%order_class%% .dnxte-nextperson-wrapper',
            ),
            'person_title_wrapper' => array(
                'label' => esc_html__('Title', 'et_builder'),
                'selector' => '%%order_class%% .dnxte-nextperson-header',
            ),
            'person_position_wrapper' => array(
                'label' => esc_html__('Position', 'et_builder'),
                'selector' => '%%order_class%% .dnxte-nextperson-pos',
            ),
            'person_body_wrapper' => array(
                'label' => esc_html__('Body', 'et_builder'),
                'selector' => '%%order_class%% .dnxte-teamsorev-team-detals p',
            ),
        );
    }

    public function get_fields() {
        $fields = array(
            'teamperson_image' => array(
                'label' => esc_html__('Image', 'et_builder'),
                'type' => 'upload',
                'option_category' => 'basic_option',
                'upload_button_text' => esc_attr__('Upload an image', 'et_builder'),
                'choose_text' => esc_attr__('Choose an Image', 'et_builder'),
                'update_text' => esc_attr__('Set As Image', 'et_builder'),
                'description' => esc_html__('Upload an image to display at the top of your team person.', 'et_builder'),
                'toggle_slug' => 'dnext_team_img',
                'dynamic_content' => 'image',
                'mobile_options' => true,
                'hover' => 'tabs',
            ),
            'teamperson_name' => array(
                'label' => esc_html__('Name', 'et_builder'),
                'type' => 'text',
                'option_category' => 'basic_option',
                'description' => esc_html__('Input the name of the person', 'et_builder'),
                'toggle_slug' => 'main_content',
                'dynamic_content' => 'text',
                'mobile_options' => true,
                'hover' => 'tabs',
            ),
            'teamperson_position' => array(
                'label' => esc_html__('Position', 'et_builder'),
                'type' => 'text',
                'option_category' => 'basic_option',
                'description' => esc_html__("Input the person's position.", 'et_builder'),
                'toggle_slug' => 'main_content',
                'dynamic_content' => 'text',
                'mobile_options' => true,
                'hover' => 'tabs',
            ),
            'teamperson_content' => array(
                'label' => esc_html__('Body', 'et_builder'),
                'type' => 'tiny_mce',
                'option_category' => 'basic_option',
                'description' => esc_html__('Input the main text content for your module here.', 'et_builder'),
                'toggle_slug' => 'main_content',
                'dynamic_content' => 'text',
                'mobile_options' => true,
                'hover' => 'tabs',
            ),
            'person_alignment' => array(
                'label' => esc_html__('Social Item Alignment', 'et_builder'),
                'description' => esc_html__('Align social item to the left, right or center.', 'et_builder'),
                'type' => 'align',
                'option_category' => 'layout',
                'options' => et_builder_get_text_orientation_options(array('justified')),
                'tab_slug' => 'advanced',
                'toggle_slug' => 'person_alignment',
                'mobile_options' => true,
            ),
            'person_image_position' => array(
                'label' => esc_html__('Select Image Postion', 'et_builder'),
                'type' => 'select',
                'description' => esc_html__('Select the types of image position', 'et_builder'),
                'tab_slug' => 'advanced',
                'option_category' => 'layout',
                'toggle_slug' => 'teamperson_image',
                'options' => array(
                    'person-left' => esc_html__('Left', 'et_builder'),
                    'person-top' => esc_html__('Top', 'et_builder'),
                ),
                'default' => 'person-top',
                'depends_show_if' => 'on',
            ),
            'person_left' => array(
                'label' => esc_html__('Select Image Left Position', 'et_builder'),
                'description' => esc_html__('Choose where Image', 'et_builder'),
                'type' => 'select',
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'teamperson_image',
                'option_category' => 'layout',
                'options' => array(
                    'left-top' => esc_html__('Left Top', 'et_builder'),
                    'left-center' => esc_html__('Left Center', 'et_builder'),
                    'left-bottom' => esc_html__('Left Bottom', 'et_builder'),
                ),
                'default' => 'left-top',
                'show_if' => array(
                    'person_image_position' => 'person-left',
                ),
                'mobile_options' => true,
            ),
            'person_top' => array(
                'label' => esc_html__('Select Image Top Position', 'et_builder'),
                'description' => esc_html__('Choose where Image', 'et_builder'),
                'type' => 'select',
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'teamperson_image',
                'options' => array(
                    'top-left' => esc_html__('Top Left', 'et_builder'),
                    'top-center' => esc_html__('Top Center', 'et_builder'),
                    'top-right' => esc_html__('Top Right', 'et_builder'),
                ),
                'default' => 'top-left',
                'show_if' => array(
                    'person_image_position' => 'person-top',
                ),
                'mobile_options' => true,
            ),
            'person_img_width' => array(
                'label' => esc_html__('Image Width', 'et_builder'),
                'description' => esc_html__('Adjust the width of the image within the team.', 'et_builder'),
                'type' => 'range',
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'teamperson_image',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'default' => '100%',
                'default_unit' => '%',
                'default_on_front' => '',
                'allow_empty' => true,
                'range_settings' => array(
                    'min' => '0',
                    'max' => '100',
                    'step' => '1',
                ),
                'mobile_options' => true,
                'hover' => 'tabs',
            ),
            'person_bgc_show_hide' => array(
                'label' => esc_html__('Background Color', 'et_builder'),
                'type' => 'yes_no_button',
                'toggle_slug' => 'person_bgc',
                'sub_toggle' => 'sub_toggle_color',
                'options' => array(
                    'on' => esc_html__('Yes', 'et_builder'),
                    'off' => esc_html__('No', 'et_builder'),
                ),
                'affects' => array(
                    'person_bgc_color',
                ),
                'default_on_front' => 'on',
            ),
            'person_bgc_color' => array(
                'label' => esc_html__('Select Background Color', 'et_builder'),
                'type' => 'color-alpha',
                'toggle_slug' => 'person_bgc',
                'sub_toggle' => 'sub_toggle_color',
                'default' => '#FFFFFF',
                'mobile_options' => true,
                'depends_show_if' => 'on',
            ),
            'person_gradient_show_hide' => array(
                'label' => esc_html__('Gradient Color', 'et_builder'),
                'type' => 'yes_no_button',
                'toggle_slug' => 'person_bgc',
                'sub_toggle' => 'sub_toggle_gradient',
                'options' => array(
                    'on' => esc_html__('Yes', 'et_builder'),
                    'off' => esc_html__('No', 'et_builder'),
                ),
                'affects' => array(
                    'person_gradient_color_one',
                    'person_gradient_color_two',
                    'person_gradient_type',
                    'person_gradient_start_position',
                    'person_gradient_end_position',
                ),
                'default_on_front' => 'off',
                'depends_show_if' => 'on',
            ),
            'person_gradient_color_one' => array(
                'label' => esc_html__('Select Color One', 'et_builder'),
                'type' => 'color-alpha',
                'toggle_slug' => 'person_bgc',
                'sub_toggle' => 'sub_toggle_gradient',
                'default' => '#2b87da',
                'depends_show_if' => 'on',
            ),
            'person_gradient_color_two' => array(
                'label' => esc_html__('Select Color Two', 'et_builder'),
                'type' => 'color-alpha',
                'toggle_slug' => 'person_bgc',
                'sub_toggle' => 'sub_toggle_gradient',
                'default' => '#29c4a9',
                'depends_show_if' => 'on',
            ),
            'person_gradient_type' => array(
                'label' => esc_html__('Select Gradient Type', 'et_builder'),
                'type' => 'select',
                'description' => esc_html__('Select the types of gradient', 'et_builder'),
                'option_category' => 'basic_option',
                'toggle_slug' => 'person_bgc',
                'sub_toggle' => 'sub_toggle_gradient',
                'options' => array(
                    'linear-gradient' => esc_html__('Linear', 'et_builder'),
                    'radial-gradient' => esc_html__('Radial', 'et_builder'),
                ),
                'default' => 'linear-gradient',
                'depends_show_if' => 'on',
            ),
            'person_gradient_type_linear_direction' => array(
                'label' => esc_html__('Linear direction', 'et_builder'),
                'type' => 'range',
                'option_category' => 'basic_option',
                'toggle_slug' => 'person_bgc',
                'sub_toggle' => 'sub_toggle_gradient',
                'range_settings' => array(
                    'step' => 1,
                    'min' => 1,
                    'max' => 360,
                ),
                'default' => '180deg',
                'fixed_unit' => 'deg',
                'show_if' => array(
                    'person_gradient_show_hide' => 'on',
                    'person_gradient_type' => 'linear-gradient',
                ),
            ),
            'person_gradient_type_radial_direction' => array(
                'label' => esc_html__('Radial Direction', 'et_builder'),
                'type' => 'select',
                'description' => esc_html__('Select the types of gradient', 'et_builder'),
                'option_category' => 'basic_option',
                'toggle_slug' => 'person_bgc',
                'sub_toggle' => 'sub_toggle_gradient',
                'options' => array(
                    'circle at center' => esc_html__('Center', 'et_builder'),
                    'circle at left' => esc_html__('Top Left', 'et_builder'),
                    'circle at top' => esc_html__('Top', 'et_builder'),
                    'circle at top right' => esc_html__('Top Right', 'et_builder'),
                    'circle at right' => esc_html__('Right', 'et_builder'),
                    'circle at bottom right' => esc_html__('Bottom Right', 'et_builder'),
                    'circle at bottom' => esc_html__('Bottom', 'et_builder'),
                    'circle at bottom left' => esc_html__('Bottom Left', 'et_builder'),
                    'circle at left' => esc_html__('Left', 'et_builder'),
                ),
                'default' => 'circle at center',
                'show_if' => array(
                    'person_gradient_show_hide' => 'on',
                    'person_gradient_type' => 'radial-gradient',
                ),
            ),
            'person_gradient_start_position' => array(
                'label' => esc_html__('Start Position', 'et_builder'),
                'type' => 'range',
                'option_category' => 'basic_option',
                'toggle_slug' => 'person_bgc',
                'sub_toggle' => 'sub_toggle_gradient',
                'range_settings' => array(
                    'step' => 1,
                    'min' => 1,
                    'max' => 100,
                ),
                'default' => '0%',
                'fixed_unit' => '%',
                'depends_show_if' => 'on',
            ),
            'person_gradient_end_position' => array(
                'label' => esc_html__('End Position', 'et_builder'),
                'type' => 'range',
                'option_category' => 'basic_option',
                'toggle_slug' => 'person_bgc',
                'sub_toggle' => 'sub_toggle_gradient',
                'range_settings' => array(
                    'step' => 1,
                    'min' => 1,
                    'max' => 100,
                ),
                'default' => '100%',
                'fixed_unit' => '%',
                'depends_show_if' => 'on',
            ),
            'person_image_margin' => array(
                'label' => esc_html__('Image Margin', 'et_builder'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'person_image_padding' => array(
                'label' => esc_html__('Image Padding', 'et_builder'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'person_content_margin' => array(
                'label' => esc_html__('Content Margin', 'et_builder'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'person_content_padding' => array(
                'label' => esc_html__('Content Padding', 'et_builder'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'person_title_margin' => array(
                'label' => esc_html__('Title Margin', 'et_builder'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'person_title_padding' => array(
                'label' => esc_html__('Title Padding', 'et_builder'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'person_position_margin' => array(
                'label' => esc_html__('Position Margin', 'et_builder'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'person_position_padding' => array(
                'label' => esc_html__('Position Padding', 'et_builder'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'person_body_margin' => array(
                'label' => esc_html__('Body Margin', 'et_builder'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'person_body_padding' => array(
                'label' => esc_html__('Body Padding', 'et_builder'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
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

    public function get_social_item_alignment($device = 'desktop') {
        $suffix = 'desktop' !== $device ? "_{$device}" : '';
        $text_orientation = isset($this->props["person_alignment{$suffix}"]) ? $this->props["person_alignment{$suffix}"] : '';

        return et_pb_get_alignment($text_orientation);
    }

    public function render($attrs, $content, $render_slug) {

        $multi_view = et_pb_multi_view_options($this);

        // Social Item Alignment.
        $social_item_alignment = $this->get_social_item_alignment();
        $is_social_item_alignment_responsive = et_pb_responsive_options()->is_responsive_enabled($this->props, 'person_alignment');
        $social_item_alignment_tablet = $is_social_item_alignment_responsive ? $this->get_social_item_alignment('tablet') : '';
        $social_item_alignment_phone = $is_social_item_alignment_responsive ? $this->get_social_item_alignment('phone') : '';

        $social_item_alignments = array();
        if (!empty($social_item_alignment)) {
            array_push($social_item_alignments, sprintf('dnext_person_social_alignment_%1$s', esc_attr($social_item_alignment)));
        }

        if (!empty($social_item_alignment_tablet)) {
            array_push($social_item_alignments, sprintf('dnext_person_social_alignment_tablet_%1$s', esc_attr($social_item_alignment_tablet)));
        }

        if (!empty($social_item_alignment_phone)) {
            array_push($social_item_alignments, sprintf('dnext_person_social_alignment_phone_%1$s', esc_attr($social_item_alignment_phone)));
        }

        $social_item_alignment_classes = join(' ', $social_item_alignments);

        $person_top = '';
        $person_left = '';

        if ('person-left' === $this->props['person_image_position']) {
            $person_left = $this->props['person_left'];

        } else {
            $person_top = $this->props['person_top'];
        }

        // Content BG Color
        $person_bgc_color = $this->props['person_bgc_color'];
        $person_bgc_color_values = et_pb_responsive_options()->get_property_values($this->props, 'person_bgc_color');
        $person_bgc_color_tablet = isset($person_bgc_color_values['tablet']) ? $person_bgc_color_values['tablet'] : '';
        $person_bgc_color_phone = isset($person_bgc_color_values['phone']) ? $person_bgc_color_values['phone'] : '';

        if ('off' !== $this->props['person_bgc_show_hide']) {
            $person_bgc_color_style = sprintf('background: %1$s;', esc_attr($person_bgc_color));
            $person_bgc_color_tablet_style = '' !== $person_bgc_color_tablet ? sprintf('background: %1$s;', esc_attr($person_bgc_color_tablet)) : '';
            $person_bgc_color_phone_style = '' !== $person_bgc_color_phone ? sprintf('background: %1$s;', esc_attr($person_bgc_color_phone)) : '';

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte-nextperson-wrapper",
                'declaration' => $person_bgc_color_style,
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte-nextperson-wrapper",
                'declaration' => $person_bgc_color_tablet_style,
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte-nextperson-wrapper",
                'declaration' => $person_bgc_color_phone_style,
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));
        }

        //Content GRADIENT COLOR
        $person_gradient_color_one = $this->props['person_gradient_color_one'];
        $person_gradient_color_two = $this->props['person_gradient_color_two'];
        // Other gradient options
        $person_gradient_type = $this->props['person_gradient_type'];
        $person_gradient_start_position = $this->props['person_gradient_start_position'];
        $person_gradient_end_position = $this->props['person_gradient_end_position'];

        $person_gradient_direction = $person_gradient_type === 'linear-gradient' ? $this->props['person_gradient_type_linear_direction'] : $this->props['person_gradient_type_radial_direction'];

        if ('off' !== $this->props['person_gradient_show_hide']) {
            $person_gradient = sprintf('background: %1$s(%2$s, %3$s %5$s, %4$s %6$s);', $person_gradient_type, $person_gradient_direction, esc_attr($person_gradient_color_one), esc_attr($person_gradient_color_two), $person_gradient_start_position, $person_gradient_end_position);

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte-nextperson-wrapper",
                'declaration' => $person_gradient,
            ));
        }

        // Person Image Width
        $person_img_width = $this->props['person_img_width'];
        $person_img_width_hover = $this->get_hover_value('person_img_width');
        $person_img_width_tablet = $this->props['person_img_width_tablet'];
        $person_img_width_phone = $this->props['person_img_width_phone'];
        $person_img_width_last_edited = $this->props['person_img_width_last_edited'];

        if ('' !== $person_img_width) {
            $person_img_width_responsive_active = et_pb_get_responsive_status($person_img_width_last_edited);

            $person_img_width_values = array(
                'desktop' => $person_img_width,
                'tablet' => $person_img_width_responsive_active ? $person_img_width_tablet : '',
                'phone' => $person_img_width_responsive_active ? $person_img_width_phone : '',
            );
            $person_img_width_selector = "%%order_class%% .dnxte-nextperson-img img";
            et_pb_responsive_options()->generate_responsive_css($person_img_width_values, $person_img_width_selector, 'max-width', $render_slug);

            if (et_builder_is_hover_enabled('person_img_width', $this->props)) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => $this->add_hover_to_order_class('%%order_class%% .dnxte-nextperson-img img'),
                    'declaration' => sprintf(
                        'max-width: %1$s;',
                        esc_html($person_img_width_hover)
                    ),
                ));
            }
        }

        //Person Image
        $dnext_teamperson_image = "";
        if ($multi_view->has_value('teamperson_image')) {
            $dnext_person_image_classes = array(
                'dnxte-nextperson-img',
                'dnxte-nextperson-' . esc_attr($person_top),
            );

            $dnext_teamperson_image = $multi_view->render_element(array(
                'tag' => 'div',
                'content' => $multi_view->render_element(array(
                    'tag' => 'img',
                    'attrs' => array(
                        'src' => '{{teamperson_image}}',
                        'alt' => '{{teamperson_name}}',
                    ),
                )),
                'attrs' => array(
                    'class' => implode(' ', $dnext_person_image_classes),
                ),
                'classes' => array(
                    'et-svg' => array(
                        'teamperson_image' => true,
                    ),
                ),
            ));
        }

        //Person Name
        $teampersonName = $multi_view->render_element(array(
            'tag' => et_pb_process_header_level($this->props['header_level'], 'h4'),
            'content' => '{{teamperson_name}}',
            'attrs' => array(
                'class' => 'dnxte-nextperson-header',
            ),
        ));

        // Person Postion
        $teamperson_position = $multi_view->render_element(array(
            'tag' => 'p',
            'content' => '{{teamperson_position}}',
            'attrs' => array(
                'class' => 'dnxte-nextperson-pos',
            ),
        ));

        $teamperson_desc = "";
        if($this->props['teamperson_content'] !== "") {
            $teamperson_desc = sprintf('<div class="dnxte-nextperson-pra">%1$s</div>', $this->props['teamperson_content']);
        }

        $this->apply_css($render_slug);

        return sprintf(
            '<div class="dnxte-nextperson-team-wrap dnxte-nextperson-%7$s">
					%2$s
				<div class="dnxte-nextperson-des">
					<div class="dnxte-nextperson-wrapper">
						%3$s
						%4$s
						%5$s
					</div>
					<ul class="dnxte-nextperson-social %6$s">
						%1$s
					</ul>
				</div>
			</div>',
            et_core_sanitized_previously($this->content),
            et_core_esc_previously($dnext_teamperson_image),
            et_core_esc_previously($teampersonName),
            et_core_esc_previously($teamperson_position),
            wpautop( et_core_esc_previously($teamperson_desc) ), // #5
            esc_attr($social_item_alignment_classes),
            esc_attr($person_left)
        );
    }

    public function apply_css($render_slug)
    {
        /**
         * Custom Padding Margin Output
         *
         */

        Common::dnxt_set_style($render_slug, $this->props, "person_image_margin", "%%order_class%% .dnxte-nextperson-img", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "person_image_padding", "%%order_class%% .dnxte-nextperson-img", "padding");

        Common::dnxt_set_style($render_slug, $this->props, "person_content_margin", "%%order_class%% .dnxte-nextperson-wrapper", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "person_content_padding", "%%order_class%% .dnxte-nextperson-wrapper", "padding");

        Common::dnxt_set_style($render_slug, $this->props, "person_title_margin", "%%order_class%% .dnxte-nextperson-header", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "person_title_padding", "%%order_class%% .dnxte-nextperson-header", "padding");

        Common::dnxt_set_style($render_slug, $this->props, "person_position_margin", "%%order_class%% .dnxte-nextperson-pos", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "person_position_padding", "%%order_class%% .dnxte-nextperson-pos", "padding");

        Common::dnxt_set_style($render_slug, $this->props, "person_body_margin", "%%order_class%% .dnxte-nextperson-wrapper p:last-of-type", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "person_body_padding", "%%order_class%% .dnxte-nextperson-wrapper p:last-of-type", "padding");
    }

    /**
     * Check if image has svg extension
     *
     * @param string $dnext_teamperson_image Image URL.
     *
     * @return bool
     */
    public function is_svg($dnext_teamperson_image)
    {
        if (!$dnext_teamperson_image) {
            return false;
        }

        $image_pathinfo = pathinfo($dnext_teamperson_image);

        return isset($image_pathinfo['extension']) ? 'svg' === $image_pathinfo['extension'] : false;
    }
}

new DNXT_Person;
