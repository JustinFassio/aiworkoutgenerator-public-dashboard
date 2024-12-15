<?php
include_once(DIVI_ESSENTIAL_PATH.'/includes/modules/base/Common.php');

class Divi_NxteTestimonial extends ET_Builder_Module
{
    public $slug = 'dnxte_testimonial_parent';
    public $vb_support = 'on';
    public $child_slug = 'dnxte_testimonial_child';

    protected $module_credits = array(
        'module_uri' => 'https://www.diviessential.com/divi-testimonial-carousel/',
        'author' => 'Divi Next',
        'author_uri' => 'www.divinext.com',
    );

    public function init()
    {
        $this->name        = esc_html__('Next Testimonial Slider', 'et_builder');
        $this->icon_path   = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->folder_name = 'et_pb_divi_essential';

        $this->settings_modal_toggles = array(
            'general' => array(
                'toggles' => array(
                    'dnxt_testimonial_quote_icon' => esc_html__("Quote", "dnext-divi-next"),
                    'dnxt_testimonial_carousel_settings' => esc_html__("Carousel Settings", "dnext-divi-next"),
                    'dnxt_testimonial_carousel_navigation' => esc_html__("Navigation Settings", "dnext-divi-next"),
                ),
            ),
            'advanced' => array(
                'toggles' => array(
                    'dnxt_testimonial_icon_settings' => esc_html__("Quote Settings", "dnext-divi-next"),
                    'dnxt_testimonial_image_settings' => esc_html__("Image Settings", "dnext-divi-next"),
                    'dnxt_testimonial_rating_settings' => esc_html__("Rating Settings", "dnext-divi-next"),
                    'dnxt_testimonial_title_settings' => esc_html__("Title Text", "dnext-divi-next"),
                    'dnxt_testimonial_position_settings' => esc_html__("Position Text", "dnext-divi-next"),
                    'dnxt_testimonial_description_settings' => esc_html__("Description Text", "dnext-divi-next"),
                    'dnxt_testimonial_color_settings' => esc_html__("Color Settings", "dnext-divi-next"),
                    'dnxt_testimonial_arrow_settings' => esc_html__("Arrow Settings", "dnext-divi-next"),
                ),
            ),
        );

        // Custom CSS Field
        $this->custom_css_fields = array(
            'testimonialimage_wrapper' => array(
                'label' => esc_html__('Image', 'et_builder'),
                'selector' => '%%order_class%% .dnxte-tstimonial-prfle-review img',
            ),
            'testimonialtitle_wrapper' => array(
                'label' => esc_html__('Title', 'et_builder'),
                'selector' => '%%order_class%% .dnxte-tstprfle-nam',
            ),
            'testimonialposition_wrapper' => array(
                'label' => esc_html__('Position', 'et_builder'),
                'selector' => '%%order_class%% .dnxte-tst-prfledeg-des',
            ),
            'testimonialrating_wrapper' => array(
                'label' => esc_html__('Rating', 'et_builder'),
                'selector' => '%%order_class%% .dnext-star-rating',
            ),
            'testimonialcontent_wrapper' => array(
                'label' => esc_html__('Content', 'et_builder'),
                'selector' => '%%order_class%% .dnxte-itcont-des',
            ),
        );
    }

    public function get_advanced_fields_config()
    {
        return array(
            'background' => array(
                'settings' => array(
                    'color' => 'alpha',
                ),
                'css' => array(
                    'main' => "%%order_class%% .swiper-container",
                    'important' => true,
                ),
            ),
            'fonts' => array(
                'header' => array(
                    'label' => esc_html__('Title', 'et_builder'),
                    'hide_text_color' => true,
                    'css' => array(
                        'main' => "{$this->main_css_element} .dnxte-tstprfle-nam",
                    ),
                ),
                'body' => array(
                    'label' => esc_html__('Description', 'et_builder'),
                    'hide_text_color' => true,
                    'css' => array(
                        'main' => "%%order_class%% .dnxte-itcont-des",
                    ),
                ),
                'position' => array(
                    'label' => esc_html__('Position', 'et_builder'),
                    'hide_text_color' => true,
                    'css' => array(
                        'main' => "%%order_class%% .dnxte-tstimonial-prfledeg span",
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
            'text' => false,
            'borders' => array(
                'default' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => '%%order_class%% .swiper-container',
                            'border_styles' => '%%order_class%% .swiper-container',
                        ),
                        'important' => 'all',
                    ),
                ),
                'image_border' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => '%%order_class%% .img-fluid',
                            'border_styles' => '%%order_class%% .img-fluid',
                        ),
                        'important' => 'all',
                    ),
                    'label_prefix' => esc_html__('Image', 'et_builder'),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxt_testimonial_image_settings',
                ),
                'rating_star' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => "%%order_class%% .dnext-star-rating",
                            'border_styles' => "%%order_class%% .dnext-star-rating",
                        ),
                    ),
                    'defaults' => array(
                        'border_radii' => 'on|20px|20px|20px|20px',
                        'border_styles' => array(
                            'width' => '0px',
                            'color' => '#030303',
                            'style' => 'solid',
                        ),
                    ),
                    'label_prefix' => esc_html__('Review'),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxt_testimonial_rating_settings',
                ),
            ),
            'box_shadow' => array(
                'default' => array(),
                'image_box_shadow' => array(
                    'css' => array(
                        'main' => '%%order_class%% .img-fluid',
                        'important' => 'all',
                    ),
                    'label_prefix' => esc_html__('Image', 'et_builder'),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxt_testimonial_image_settings',
                ),
                'rating_box_shadow' => array(
                    'css' => array(
                        'main' => '%%order_class%% .dnext-star-rating',
                        'important' => 'all',
                    ),
                    'label_prefix' => esc_html__('Rating', 'et_builder'),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxt_testimonial_rating_settings',
                ),
            ),
            'margin_padding' => array(
                'css' => array(
                    'margin' => '%%order_class%% .swiper-container',
                    'padding' => '%%order_class%% .dnxte_testimonial_child',
                ),
                'important' => 'all',
            ),
            'max_width' => false,
        );
    }

    public function get_fields()
    {
        return array(
            'dnxte_testimonial_use_icon' => array(
                'label' => esc_html__('Use Image', 'et_builder'),
                'type' => 'yes_no_button',
                'toggle_slug' => 'dnxt_testimonial_quote_icon',
                'options' => array(
                    'on' => esc_html__('Yes', 'et_builder'),
                    'off' => esc_html__('No', 'et_builder'),
                ),
                'affects' => array(
                    'dnxte_testimonial_quote_icon',
                ),
                'default_on_front' => 'off',
            ),
            'dnxte_testimonial_quote_icon' => array(
                'label' => esc_html__('Image', 'et_builder'),
                'type' => 'upload',
                'option_category' => 'basic_option',
                'upload_button_text' => esc_attr__('Upload an image', 'et_builder'),
                'choose_text' => esc_attr__('Choose an Image', 'et_builder'),
                'update_text' => esc_attr__('Set As Image', 'et_builder'),
                'description' => esc_html__('Upload an image to display at the top of your team person.', 'et_builder'),
                'toggle_slug' => 'dnxt_testimonial_quote_icon',
                'dynamic_content' => 'image',
                'mobile_options' => true,
                'hover' => 'tabs',
                'show_if' => array(
                    'dnxte_testimonial_use_icon' => 'on'
                )
            ),
            'dnxt_testimonial_autoplay_show_hide' => array(
                'label' => esc_html__('Autoplay', 'et_builder'),
                'type' => 'yes_no_button',
                'description' => esc_html__('Content entered here will appear inside the module.', 'et_builder'),
                'options' => array(
                    'on' => esc_html__('Yes', 'et_builder'),
                    'off' => esc_html__('No', 'et_builder'),
                ),
                'affects' => array(
                    'dnxt_testimonial_autoplay_delay',
                ),
                'default' => 'on',
                'default_on_front' => 'on',
                'toggle_slug' => 'dnxt_testimonial_carousel_settings',
            ),
            'dnxt_testimonial_autoplay_delay' => array(
                'label' => esc_html__('Autoplay Delay', 'et_builder'),
                'type' => 'text',
                'option_category' => 'basic_option',
                'description' => esc_html__('Adjust the autoplay delay in milliseconds (ms)', 'et_builder'),
                'default' => '2000',
                'depends_show_if' => 'on',
                'toggle_slug' => 'dnxt_testimonial_carousel_settings',
            ),
            'dnxt_testimonial_loop' => array(
                'label' => esc_html__('Loop', 'et_builder'),
                'type' => 'yes_no_button',
                'description' => esc_html__('Content entered here will appear inside the module.', 'et_builder'),
                'options' => array(
                    'on' => esc_html__('Yes', 'et_builder'),
                    'off' => esc_html__('No', 'et_builder'),
                ),
                'default' => 'off',
                'default_on_front' => 'off',
                'toggle_slug' => 'dnxt_testimonial_carousel_settings',
            ),
            'dnxt_testimonial_grab' => array(
                'label' => esc_html__('Use Grab Cursor', 'et_builder'),
                'type' => 'yes_no_button',
                'description' => esc_html__('Content entered here will appear inside the module.', 'et_builder'),
                'options' => array(
                    'on' => esc_html__('Yes', 'et_builder'),
                    'off' => esc_html__('No', 'et_builder'),
                ),
                'default' => 'off',
                'default_on_front' => 'off',
                'toggle_slug' => 'dnxt_testimonial_carousel_navigation',
            ),
            'dnxt_testimonial_speed' => array(
                'label' => esc_html__('Speed', 'et_builder'),
                'type' => 'range',
                'option_category' => 'basic_option',
                'range_settings' => array(
                    'step' => 1,
                    'min' => 1,
                    'max' => 1000,
                ),
                'default' => '400',
                'fixed_unit' => '',
                'validate_unit' => false,
                'unitless' => true,
                'toggle_slug' => 'dnxt_testimonial_carousel_settings',
            ),
            'dnxt_testimonial_arrows' => array(
                'label' => esc_html__('Use Arrow Navigation', 'et_builder'),
                'type' => 'yes_no_button',
                'description' => esc_html__('Choose Yes or No to use arrow navigation.', 'et_builder'),
                'options' => array(
                    'on' => esc_html__('Yes', 'et_builder'),
                    'off' => esc_html__('No', 'et_builder'),
                ),
                'default' => 'off',
                'default_on_front' => 'off',
                'toggle_slug' => 'dnxt_testimonial_carousel_navigation',
            ),
            'dnxt_testimonial_mousewheel' => array(
                'label' => esc_html__('Use Mouse Wheel Navigation', 'et_builder'),
                'type' => 'yes_no_button',
                'description' => esc_html__('Choose enable to change the slide with mouse scroll.', 'et_builder'),
                'options' => array(
                    'on' => esc_html__('Yes', 'et_builder'),
                    'off' => esc_html__('No', 'et_builder'),
                ),
                'default' => 'off',
                'default_on_front' => 'off',
                'toggle_slug' => 'dnxt_testimonial_carousel_navigation',
            ),
            'dnxt_testimonial_keyboard' => array(
                'label' => esc_html__('Use Keyboard Navigation', 'et_builder'),
                'type' => 'yes_no_button',
                'description' => esc_html__('Choose Enable to use keyboard navigation.To use keyboard navigation, use left and right arrow key to change the slide.', 'et_builder'),
                'options' => array(
                    'on' => esc_html__('Yes', 'et_builder'),
                    'off' => esc_html__('No', 'et_builder'),
                ),
                'default' => 'off',
                'default_on_front' => 'off',
                'toggle_slug' => 'dnxt_testimonial_carousel_navigation',
            ),
            'dnxt_testimonial_pagination_type' => array(
                'label' => esc_html__('Type', 'et_builder'),
                'type' => 'select',
                'option_category' => 'basic_option',
                'options' => array(
                    'none' => esc_html__('None', 'et_builder'),
                    'bullets' => esc_html__('Bullets', 'et_builder'),
                    'fraction' => esc_html__('Fraction', 'et_builder'),
                    'progressbar' => esc_html__('Progress Bar', 'et_builder'),
                ),
                'default' => 'bullets',
                'toggle_slug' => 'dnxt_testimonial_carousel_navigation',
            ),
            'dnxt_testimonial_pagination_bullets' => array(
                'label' => esc_html__('Dynamic Bullets', 'et_builder'),
                'type' => 'yes_no_button',
                'description' => esc_html__('Content entered here will appear inside the module.', 'et_builder'),
                'options' => array(
                    'on' => esc_html__('Yes', 'et_builder'),
                    'off' => esc_html__('No', 'et_builder'),
                ),
                'default_on_front' => 'on',
                'toggle_slug' => 'dnxt_testimonial_carousel_navigation',
                'show_if' => array(
                    'dnxt_testimonial_pagination_type' => 'bullets',
                ),
                'show_if_not' => array(
                    'dnxt_testimonial_pagination_type' => 'none',
                ),
            ),
            'dnxt_testimonial_arrow_color' => array(
                'label' => esc_html__('Arrow Color', 'et_builder'),
                'type' => 'color-alpha',
                'custom_color' => true,
                'default' => '#0c71c3',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxt_testimonial_color_settings',
            ),
            'dnxt_testimonial_arrow_background_color' => array(
                'label' => esc_html__('Arrow Background Color', 'et_builder'),
                'type' => 'color-alpha',
                'custom_color' => true,
                'default' => '#fff',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxt_testimonial_color_settings',
            ),
            'dnxt_testimonial_dots_color' => array(
                'label' => esc_html__('Dots Color', 'et_builder'),
                'type' => 'color-alpha',
                'custom_color' => true,
                'default' => '#000',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxt_testimonial_color_settings',
                'show_if' => array(
                    'dnxt_testimonial_pagination_type' => 'bullets',
                ),
            ),
            'dnxt_testimonial_dots_active_color' => array(
                'label' => esc_html__('Dots Active Color', 'et_builder'),
                'type' => 'color-alpha',
                'custom_color' => true,
                'default' => '#0c71c3',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxt_testimonial_color_settings',
                'show_if' => array(
                    'dnxt_testimonial_pagination_type' => 'bullets',
                ),
            ),
            'dnxt_testimonial_progressbar_fill_color' => array(
                'label' => esc_html__('Progressbar Fill Color', 'et_builder'),
                'type' => 'color-alpha',
                'custom_color' => true,
                'default' => '#0c71c3',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxt_testimonial_color_settings',
                'show_if' => array(
                    'dnxt_testimonial_pagination_type' => 'progressbar',
                ),
            ),
            'dnxt_testimonial_arrow_size' => array(
                'label' => esc_html__('Font Size', 'et_builder'),
                'type' => 'range',
                'option_category' => 'basic_option',
                'range_settings' => array(
                    'step' => 1,
                    'min' => 1,
                    'max' => 100,
                ),
                'default' => '60',
                'fixed_unit' => '',
                'validate_unit' => false,
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxt_testimonial_arrow_settings',
            ),
            'dnxt_testimonial_arrow_position' => array(
                'label' => esc_html__('Arrow Position', 'et_builder'),
                'type' => 'select',
                'description' => esc_html__('Select the types of arrow position', 'et_builder'),
                'option_category' => 'basic_option',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxt_testimonial_arrow_settings',
                'options' => array(
                    'default' => esc_html__('Default', 'et_builder'),
                    'inner' => esc_html__('Inner', 'et_builder'),
                    'outer' => esc_html__('Outer', 'et_builder'),

                ),
                'default' => 'default',
            ),
            'dnxt_testimonial_arrow_margin' => array(
                'label' => esc_html__('Arrow Margin', 'et_builder'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'dnxt_testimonial_arrow_padding' => array(
                'label' => esc_html__('Arrow Padding', 'et_builder'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'dnxt_testimonial_pause_on_hover' => array(
                'label' => esc_html__('Pause On Hover', 'et_builder'),
                'type' => 'yes_no_button',
                'description' => esc_html__('Content entered here will appear inside the module.', 'et_builder'),
                'options' => array(
                    'on' => esc_html__('Yes', 'et_builder'),
                    'off' => esc_html__('No', 'et_builder'),
                ),
                'default' => 'off',
                'default_on_front' => 'off',
                'toggle_slug' => 'dnxt_testimonial_carousel_settings',
            ),
            'dnxt_testimonial_rating_bg_color' => array(
                'label' => esc_html__('Select Background Color', 'et_builder'),
                'type' => 'color-alpha',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxt_testimonial_rating_settings',
                'option_category' => 'basic_option',
                'hover' => 'tabs',
                'default' => 'rgba(0,0,0,0)',
            ),
            'dnxt_testimonial_rating_bg_color_width' => array(
                'label' => esc_html__('Background Width', 'et_builder'),
                'description' => esc_html__('Adjust the width of the background width.', 'et_builder'),
                'type' => 'range',
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxt_testimonial_rating_settings',
                'option_category' => 'basic_option',
                'default' => '100%',
                'default_unit' => '%',
                'default_on_front' => '',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'allow_empty' => true,
                'range_settings' => array(
                    'min' => '0',
                    'max' => '100',
                    'step' => '1',
                ),
                'mobile_options' => true,
                'responsive' => true,
                'hover' => 'tabs',
            ),
            'dnxt_testimonial_rating_color' => array(
                'label' => esc_html__('Select Star Color', 'et_builder'),
                'type' => 'color-alpha',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxt_testimonial_rating_settings',
                'option_category' => 'basic_option',
                'hover' => 'tabs',
                'default' => '#ffbf36',
            ),
            'dnxt_testimonial_star_size' => array(
                'label' => esc_html__('Size', 'et_builder'),
                'description' => esc_html__('Control the size of the star by increasing or decreasing the font size.', 'et_builder'),
                'type' => 'range',
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxt_testimonial_rating_settings',
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
                'hover' => 'tabs',
            ),
            'dnxt_testimonial_breakpoint_desktop' => array(
                'label' => esc_html__('Slides Per View', 'et_builder'),
                'type' => 'text',
                'option_category' => 'basic_option',
                'description' => esc_html__('Content entered here will appear inside the module.', 'et_builder'),
                'default' => '1',
                'default_on_front' => '1',
                'mobile_options' => true,
                'responsive' => true,
                'toggle_slug' => 'dnxt_testimonial_carousel_settings',
            ),
            'dnxt_testimonial_centered_slides' => array(
                'label' => esc_html__('Center Slide', 'et_builder'),
                'type' => 'yes_no_button',
                'description' => esc_html__('Content entered here will appear inside the module.', 'et_builder'),
                'options' => array(
                    'on' => esc_html__('Yes', 'et_builder'),
                    'off' => esc_html__('No', 'et_builder'),
                ),
                'default' => 'off',
                'default_on_front' => 'off',
                'toggle_slug' => 'dnxt_testimonial_carousel_settings',
            ),
            'dnxt_testimonial_spacebetween' => array(
                'label' => esc_html__('Space Between', 'et_builder'),
                'type' => 'range',
                'option_category' => 'basic_option',
                'range_settings' => array(
                    'step' => 1,
                    'min' => 1,
                    'max' => 300,
                ),
                'default' => '15',
                'fixed_unit' => '',
                'validate_unit' => false,
                'unitless' => true,
                'toggle_slug' => 'dnxt_testimonial_carousel_settings',
            ),
            'dnxt_testimonial_image_width' => array(
                'label' => esc_html__('Image Width', 'et_builder'),
                'description' => esc_html__('Adjust the width of the image width.', 'et_builder'),
                'type' => 'range',
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxt_testimonial_image_settings',
                'option_category' => 'basic_option',
                'default' => '70px',
                'default_unit' => 'px',
                'default_on_front' => '',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'allow_empty' => true,
                'range_settings' => array(
                    'min' => '0',
                    'max' => '100',
                    'step' => '1',
                ),
                'mobile_options' => true,
                'responsive' => true,
            ),
            'dnxt_testimonial_icon_opacity' => array(
                'label' => esc_html__('Icon/Image Opacity', 'et_builder'),
                'type' => 'range',
                'option_category' => 'basic_option',
                'range_settings' => array(
                    'step' => 0.1,
                    'min' => 0.1,
                    'max' => 1,
                ),
                'default' => '0.3',
                'fixed_unit' => '',
                'validate_unit' => false,
                'unitless' => true,
                'toggle_slug' => 'dnxt_testimonial_icon_settings',
                'tab_slug' => 'advanced',
            ),
            'dnxt_testimonial_icon_width' => array(
                'label' => esc_html__('Image Width', 'et_builder'),
                'type' => 'range',
                'option_category' => 'basic_option',
                'range_settings' => array(
                    'step' => 0.1,
                    'min' => 0.1,
                    'max' => 1,
                ),
                'default' => '0.3',
                'fixed_unit' => '',
                'validate_unit' => false,
                'unitless' => true,
                'toggle_slug' => 'dnxt_testimonial_icon_settings',
                'tab_slug' => 'advanced',
                'show_if' => array(
                    'dnxte_testimonial_use_icon' => 'on'
                )
            ),
            'dnxt_testimonial_icon_size' => array(
                'label' => esc_html__('Icon Font Size', 'et_builder'),
                'description' => esc_html__('Adjust the font size of the icon.', 'et_builder'),
                'type' => 'range',
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxt_testimonial_icon_settings',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'default' => '130px',
                'default_unit' => 'px',
                'default_on_front' => '',
                'allow_empty' => true,
                'range_settings' => array(
                    'min' => '0',
                    'max' => '100',
                    'step' => '1',
                ),
                'show_if' => array(
                    'dnxte_testimonial_use_icon' => 'off'
                )
            ),
            'dnxt_testimonial_icon_horizontal' => array(
                'label' => esc_html__('Horizontal Position', 'et_builder'),
                'type' => 'range',
                'option_category' => 'basic_option',
                'range_settings' => array(
                    'step' => 1,
                    'min' => -100,
                    'max' => 100,
                ),
                'default' => '0',
                'fixed_unit' => '',
                'validate_unit' => false,
                'unitless' => true,
                'toggle_slug' => 'dnxt_testimonial_icon_settings',
                'tab_slug' => 'advanced',
            ),
            'dnxt_testimonial_icon_vertical' => array(
                'label' => esc_html__('Vertical Position', 'et_builder'),
                'type' => 'range',
                'option_category' => 'basic_option',
                'range_settings' => array(
                    'step' => 1,
                    'min' => -100,
                    'max' => 100,
                ),
                'default' => '12',
                'fixed_unit' => '',
                'validate_unit' => false,
                'unitless' => true,
                'toggle_slug' => 'dnxt_testimonial_icon_settings',
                'tab_slug' => 'advanced',
            ),
        );
    }

    public function render($attrs, $content, $render_slug)
    {
        wp_enqueue_script( 'dnext_swiper_frontend' );
        wp_enqueue_script( 'dnext_testimonial_slider' );
        wp_enqueue_style( 'dnext_swiper-min-css' );
        $content                                                = $this->content;
        $dnxt_autplay_show_hide                                 = "on" === $this->props['dnxt_testimonial_autoplay_show_hide'];
        $dnxt_autoplay_delay                                    = $this->props['dnxt_testimonial_autoplay_delay'];
        $dnxt_testimonial_loop                                  = $this->props['dnxt_testimonial_loop'];
        $dnxt_testimonial_speed                                 = $this->props['dnxt_testimonial_speed'];
        $dnxt_testimonial_slides_perview_desktop                = $this->props['dnxt_testimonial_breakpoint_desktop'];
        $dnxt_testimonial_slides_perview_desktop_tablet         = $this->props['dnxt_testimonial_breakpoint_desktop_tablet'];
        $dnxt_testimonial_slides_perview_desktop_phone          = $this->props['dnxt_testimonial_breakpoint_desktop_phone'];
        $dnxt_testimonial_slides_perview_desktop_last_edited    = $this->props['dnxt_testimonial_breakpoint_desktop_last_edited'];
        $space_between                                          = $this->props['dnxt_testimonial_spacebetween'];
        $center_slide                                           = $this->props['dnxt_testimonial_centered_slides'];
        $mouse_wheel                                           = $this->props['dnxt_testimonial_mousewheel'];
        $keyboard                                           = $this->props['dnxt_testimonial_keyboard'];

        $dnxt_testimonial_direction                             = "horizontal";
        $dnxt_testimonial_pagination_type                       = $this->props['dnxt_testimonial_pagination_type'];
        $dnxt_testimonial_pagination_bullets                    = $dnxt_testimonial_pagination_type === 'bullets' ? $this->props['dnxt_testimonial_pagination_bullets'] : "off";

        $grab_cursor                                            = $this->props['dnxt_testimonial_grab'];
        $pause_on_hover                                         = "on" === $this->props['dnxt_testimonial_pause_on_hover'];
        $pagination_class = Common::pagination($dnxt_testimonial_pagination_type, $dnxt_testimonial_pagination_bullets);


        if ('' !== $dnxt_testimonial_slides_perview_desktop_tablet || '' !== $dnxt_testimonial_slides_perview_desktop_phone || '' !== $dnxt_testimonial_slides_perview_desktop) {
            $is_responsive = et_pb_get_responsive_status($dnxt_testimonial_slides_perview_desktop_last_edited);

            $slide_to_show_values = array(
                'desktop' => $dnxt_testimonial_slides_perview_desktop,
                'tablet' => $is_responsive ? $dnxt_testimonial_slides_perview_desktop_tablet : '',
                'phone' => $is_responsive ? $dnxt_testimonial_slides_perview_desktop_phone : '',
            );
        }

        // USE ARROW CLASSES
        $arrowsClass = "";
        if ("off" !== $this->props['dnxt_testimonial_arrows']) {
            if ($this->props['dnxt_testimonial_arrow_position'] === 'inner') {
                $arrowsClass = sprintf(
                    '<div class="swiper-button-prev dnxt_testimonial_arrows_inner_left" data-icon="4"></div>
                    <div class="swiper-button-next dnxt_testimonial_arrows_inner_right" data-icon="5"></div>'
                );
            } else if ($this->props['dnxt_testimonial_arrow_position'] === 'outer') {
                $arrowsClass = sprintf(
                    '<div class="swiper-button-prev dnxt_testimonial_arrows_outer_left" data-icon="4"></div>
                    <div class="swiper-button-next dnxt_testimonial_arrows_outer_right" data-icon="5"></div>'
                );
            } else {
                $arrowsClass = sprintf(
                    '<div class="swiper-button-prev dnxt_testimonial_arrows_default_left" data-icon="4"></div>
                  <div class="swiper-button-next dnxt_testimonial_arrows_default_right" data-icon="5"></div>'
                );
            }
        }

        // ARROW COLOR
        $dnxt_testimonial_arrow_color = $this->props['dnxt_testimonial_arrow_color'];
        $dnxt_testimonial_arrow_background_color = $this->props['dnxt_testimonial_arrow_background_color'];

        $dnxt_testimonial_arrow_color_style = sprintf('color: %1$s !important; background-color: %2$s !important;', esc_attr($dnxt_testimonial_arrow_color), esc_attr($dnxt_testimonial_arrow_background_color));

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .swiper-button-prev,%%order_class%% .swiper-button-next",
            'declaration' => $dnxt_testimonial_arrow_color_style,
        ));

        // DOTS COLOR START

        $dnxt_testimonial_dots_color = $this->props['dnxt_testimonial_dots_color'];
        $dnxt_testimonial_dots_active_color = $this->props['dnxt_testimonial_dots_active_color'];

        $dnxt_testimonial_dots_color_style = sprintf('background-color: %1$s !important;', esc_attr($dnxt_testimonial_dots_color));
        $dnxt_testimonial_dots_active_color_style = sprintf('background-color: %1$s !important;', esc_attr($dnxt_testimonial_dots_active_color));

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .swiper-pagination .swiper-pagination-bullet",
            'declaration' => $dnxt_testimonial_dots_color_style,
        ));

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .swiper-pagination .swiper-pagination-bullet-active",
            'declaration' => $dnxt_testimonial_dots_active_color_style,
        ));

        // PROGRESSBAR FILL COLOR START

        $dnxt_testimonial_progressbar_color = $this->props['dnxt_testimonial_progressbar_fill_color'];
        $dnxt_testimonial_progressbar_color_style = sprintf('background-color: %1$s !important;', esc_attr($dnxt_testimonial_progressbar_color));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .swiper-pagination-progressbar .swiper-pagination-progressbar-fill",
            'declaration' => $dnxt_testimonial_progressbar_color_style,
        ));

        $dnxt_testimonial_arrow_size = (int) $this->props['dnxt_testimonial_arrow_size'];
        $arrow_width = $dnxt_testimonial_arrow_size + 5;
        $dnxt_testimonial_arrow_size_style = sprintf('font-size: %1$spx', esc_attr($dnxt_testimonial_arrow_size));
        $dnxt_testimonial_arrow_background_width_height = sprintf('width: %1$spx !important;height:%1$spx !important', esc_attr($arrow_width));

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .swiper-button-prev:after,%%order_class%% .swiper-button-next:after",
            'declaration' => $dnxt_testimonial_arrow_size_style,
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .swiper-button-prev,%%order_class%% .swiper-button-next",
            'declaration' => $dnxt_testimonial_arrow_background_width_height,
        ));

        // Rating
        $dnxt_testimonial_rating_style = sprintf('background-color: %1$s; width: %2$s;', esc_attr($this->props['dnxt_testimonial_rating_bg_color']), $this->props['dnxt_testimonial_rating_bg_color_width']);

        $dnxt_testimonial_rating_color = sprintf('color: %1$s;', esc_attr($this->props['dnxt_testimonial_rating_color']));

        $dnxt_testimonial_star_size = sprintf('font-size: %1$s;', esc_attr($this->props['dnxt_testimonial_star_size']));

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .dnext-star-rating",
            'declaration' => $dnxt_testimonial_rating_style,
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .dnext-star-rating i.divinext-star-full::before, %%order_class%% .dnext-star-rating i.divinext-star-1:before, %%order_class%% .dnext-star-rating i.divinext-star-2:before, %%order_class%% .dnext-star-rating i.divinext-star-3:before, %%order_class%% .dnext-star-rating i.divinext-star-4:before, %%order_class%% .dnext-star-rating i.divinext-star-5:before, %%order_class%% .dnext-star-rating i.divinext-star-6:before, %%order_class%% .dnext-star-rating i.divinext-star-7:before, %%order_class%% .dnext-star-rating i.divinext-star-8:before, %%order_class%% .dnext-star-rating i.divinext-star-9:before, %%order_class%% .dnext-star-rating i.divinext-star-10:before",
            'declaration' => $dnxt_testimonial_rating_color,
        ));

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .dnext-star-rating .et-pb-icon",
            'declaration' => $dnxt_testimonial_star_size,
        ));

        // Image Width

        $dnxt_testimonial_image_width = $this->props['dnxt_testimonial_image_width'];
        $dnxt_testimonial_image_width_values = et_pb_responsive_options()->get_property_values($this->props, 'dnxt_testimonial_image_width');
        $dnxt_testimonial_image_width_tablet = isset($dnxt_testimonial_image_width_values['tablet']) ? $dnxt_testimonial_image_width_values['tablet'] : '';
        $dnxt_testimonial_image_width_phone = isset($dnxt_testimonial_image_width_values['phone']) ? $dnxt_testimonial_image_width_values['phone'] : '';

        $dnxt_testimonial_image_width_style = sprintf('width: %1$s', esc_attr($dnxt_testimonial_image_width));
        $dnxt_testimonial_image_width_tablet_style = '' !== $dnxt_testimonial_image_width_tablet ? sprintf('width: %1$s', esc_attr($dnxt_testimonial_image_width_tablet)) : '';
        $dnxt_testimonial_image_width_phone_style = '' !== $dnxt_testimonial_image_width_phone ? sprintf('width: %1$s', esc_attr($dnxt_testimonial_image_width_phone)) : '';

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .dnxte-tstimonial-prfle-review",
            'declaration' => $dnxt_testimonial_image_width_style,
        ));

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .dnxte-tstimonial-prfle-review",
            'declaration' => $dnxt_testimonial_image_width_tablet_style,
            'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
        ));

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .dnxte-tstimonial-prfle-review",
            'declaration' => $dnxt_testimonial_image_width_phone_style,
            'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
        ));

        if($this->props['dnxte_testimonial_use_icon'] !== "off"){
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxte-tstimonial-item:before",
                'declaration' => sprintf('content: url(%1$s);transform: rotate(0deg);transform: scale(%2$s);', $this->props['dnxte_testimonial_quote_icon'],$this->props['dnxt_testimonial_icon_width']),
            ));
        }

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .dnxte-tstimonial-item:before",
            'declaration' => sprintf('left: %1$s%%;top: %2$s%%;font-size:%3$s;opacity: %4$s;',$this->props['dnxt_testimonial_icon_horizontal'], $this->props['dnxt_testimonial_icon_vertical'], $this->props['dnxt_testimonial_icon_size'], $this->props['dnxt_testimonial_icon_opacity'])
        ));

        $output = sprintf(
            '<div class="swiper-container dnxte-tstimonial-wrap swiper-container-initialized swiper-container-horizontal" data-autoplay="%2$s" data-delay="%3$s" data-direction="%6$s" data-speed="%5$s" data-loop="%4$s" data-pagination-type="%7$s" data-pagination-bullets="%8$s" data-grab="%11$s" data-pauseonhover="%12$s" data-breakpoints="%13$s|%14$s|%15$s" data-spacing="%16$s" data-center="%17$s" data-keyboard="%18$s" data-mousewheel="%19$s">
                <div class="swiper-wrapper">
                    %1$s
                </div>
                <div class="%10$s"></div>
            </div>
            %9$s',
            $content,
            esc_attr($dnxt_autplay_show_hide),
            $dnxt_autoplay_delay,
            $dnxt_testimonial_loop,
            $dnxt_testimonial_speed,
            $dnxt_testimonial_direction,
            $dnxt_testimonial_pagination_type,
            $dnxt_testimonial_pagination_bullets,
            $arrowsClass,
            esc_attr($pagination_class),
            esc_attr($grab_cursor),
            $pause_on_hover,
            esc_attr($dnxt_testimonial_slides_perview_desktop),
            '' !== $slide_to_show_values['tablet'] ? esc_attr($slide_to_show_values['tablet']) : 1,
            '' !== $slide_to_show_values['phone'] ? esc_attr($slide_to_show_values['phone']) : '1',
            esc_attr($space_between),
            esc_attr($center_slide),
            esc_attr($keyboard),
            esc_attr($mouse_wheel)
        );

        $this->apply_css($render_slug);
        return $this->_render_module_wrapper($output, $render_slug);

    }

    public function apply_css($render_slug)
    {

        /**
         * Custom Padding Margin Output
         *
         */
        Common::dnxt_set_style($render_slug, $this->props, "dnxt_testimonial_arrow_margin", "%%order_class%% .swiper-button-next,%%order_class%% .swiper-button-prev", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "dnxt_testimonial_arrow_padding", "%%order_class%% .swiper-button-next,%%order_class%% .swiper-button-prev", "padding");
    }
}

new Divi_NxteTestimonial;
