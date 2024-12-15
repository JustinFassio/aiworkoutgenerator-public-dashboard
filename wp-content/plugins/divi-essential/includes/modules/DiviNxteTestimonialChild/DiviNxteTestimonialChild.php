<?php
include_once(DIVI_ESSENTIAL_PATH.'/includes/modules/base/Common.php');

class Divi_NxteTestimonialChild extends ET_Builder_Module
{
    public $slug = 'dnxte_testimonial_child';
    public $vb_support = 'on';
    public $type = 'child';
    public $child_title_var = 'admin_label_text';
    public $child_title_fallback_var = 'dnxte_testimonial_logo_alt';

    protected $module_credits = array(
        'module_uri' => 'https://www.diviessential.com/divi-testimonial-carousel/',
        'author' => 'Divi Next',
        'author_uri' => 'www.divinext.com',
    );

    public function init()
    {
        $this->name = esc_html__('Testimonial Slider Item', 'et_builder');

        $this->settings_modal_toggles = array(
            'general' => array(
                'toggles' => array(
                    'dnxte_testimonial_logo_settings' => array(
                        'title' => esc_html__('Image', 'et_builder'),
                        'priority' => 10,
                    ),
                    'dnxte_testimonial_rating_settings' => array(
                        'title' => esc_html__('Rating', 'et_builder'),
                    ),
                    'admin_label' => array(
                        'title' => esc_html__("Admin Label", 'et_builder'),
                        'priority' => 100
                    )
                ),
            ),
            'advanced' => array(
                'toggles' => array(
                    'dnxte_testimonial_name_settings' => esc_html__('Name Text', 'et_builder'),
                    'dnxte_testimonial_position_settings' => esc_html__('Position Text', 'et_builder'),
                    'dnxte_testimonial_company_settings' => esc_html__('Company Name Text', 'et_builder'),
                    'dnxte_testimonial_description_settings' => esc_html__('Description Text', 'et_builder'),
                    'dnxte_testimonial_description_background' => esc_html__('Description Background', 'et_builder'),
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
            'testimonialcompany_wrapper' => array(
                'label' => esc_html__('Company Name', 'et_builder'),
                'selector' => '%%order_class%% .dnxte-testimonial-company-name',
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
            'text' => false,
            'fonts' => array(
                'header' => array(
                    'label_prefix' => esc_html__('Name', 'et_builder'),
                    'css' => array(
                        'main' => "%%order_class%% h4.dnxte-tstprfle-nam, %%order_class%% h1.dnxte-tstprfle-nam, %%order_class%% h2.dnxte-tstprfle-nam, %%order_class%% h3.dnxte-tstprfle-nam, %%order_class%% h5.dnxte-tstprfle-nam, %%order_class%% h6.dnxte-tstprfle-nam",
                        'important' => 'plugin-only',
                    ),
                    'header_level' => array(
                        'default' => 'h4',
                    ),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxte_testimonial_name_settings',
                ),
                'position' => array(
                    'css' => array(
                        'main' => "%%order_class%% .dnxte-tstimonial-prfledeg",
                    ),
                    'label_prefix' => esc_html__('Position', 'et_builder'),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxte_testimonial_position_settings',
                ),
                'company_name' => array(
                    'css' => array(
                        'main' => "%%order_class%% .dnxte-testimonial-company-name",
                    ),
                    'label_prefix' => esc_html__('Company Name', 'et_builder'),
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxte_testimonial_company_settings',
                ),
                'description' => array(
                    'label' => esc_html__('Description', 'et_builder'),
                    'css' => array(
                        'main' => "%%order_class%% .dnxte-itcont-des",
                        'important' => 'all'
                    ),
                    'block_elements' => array(
                        'tabbed_subtoggles' => true,
                        'bb_icons_support' => true,
                    ),
                ),
            ),
            'borders' => array(
                'default' => array(),
                'desc' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => "%%order_class%% .dnxte-itcont-des",
                            'border_styles' => "%%order_class%% .dnxte-itcont-des",
                        ),
                        'important' => 'all'
                    ),
                    'label_prefix' => esc_html__('Description', 'et_builder'),
                    'toggle_slug' => 'dnxte_testimonial_description',
                ),
            ),
            'box_shadow' => array(
                'default' => array(),
                'name' => array(
                    'label' => esc_html__('Name Box Shadow', 'et_builder'),
                    'option_category' => 'layout',
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxte_testimonial_name_settings',
                    'css' => array(
                        'main' => '%%order_class%% .dnxte-tstprfle-nam',
                    ),
                    'default_on_fronts' => array(
                        'color' => '',
                        'position' => '',
                    ),
                ),
                'position' => array(
                    'label' => esc_html__('Position Box Shadow', 'et_builder'),
                    'option_category' => 'layout',
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxte_testimonial_position_settings',
                    'css' => array(
                        'main' => '%%order_class%% .dnxte-tstimonial-prfledeg',
                    ),
                    'default_on_fronts' => array(
                        'color' => '',
                        'position' => '',
                    ),
                ),
                'company_name' => array(
                    'label' => esc_html__('Company Name Box Shadow', 'et_builder'),
                    'option_category' => 'layout',
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxte_testimonial_company_settings',
                    'css' => array(
                        'main' => '%%order_class%% .dnxte-testimonial-company-name',
                    ),
                    'default_on_fronts' => array(
                        'color' => '',
                        'position' => '',
                    ),
                ),
                'desc' => array(
                    'label' => esc_html__('Desc Box Shadow', 'et_builder'),
                    'option_category' => 'layout',
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnxte_testimonial_description',
                    'css' => array(
                        'main' => '%%order_class%% .dnxte-itcont-des',
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
        $field = array(
            // Admin Label
            'admin_label_text' => array(
                'label' => esc_html__('Admin Label', 'et_builder'),
                'type' => 'text',
                'option_category' => 'basic_option',
                'description'     => esc_html__('This will change the label of the module in the builder for easy identification.', 'et_builder'),
                'toggle_slug' => 'admin_label',
            ),
            // Title Text
            'dnxte_testimonial_name' => array(
                'label' => esc_html__('Name', 'et_builder'),
                'type' => 'text',
                'dynamic_content' => 'text',
                'option_category' => 'basic_option',
                'description' => esc_html__('Title Text entered here will appear inside the module.', 'et_builder'),
                'toggle_slug' => 'main_content',
            ),
            'dnxte_testimonial_position' => array(
                'label' => esc_html__('Position', 'et_builder'),
                'type' => 'text',
                'dynamic_content' => 'text',
                'option_category' => 'basic_option',
                'description' => esc_html__('Title Text entered here will appear inside the module.', 'et_builder'),
                'toggle_slug' => 'main_content',
            ),
            'company_name'      	  => array(
				'label'           => esc_html__( 'Company Name', 'et_builder' ),
				'type'            => 'text',
				'dynamic_content' => 'text',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'main_content',
			),
			'company_link'      => array(
				'label'           => esc_html__( 'Company Website Link', 'et_builder' ),
				'description'     => esc_html__( 'When clicked the module will link to this URL.', 'et_builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'toggle_slug'     => 'main_content',
				'dynamic_content' => 'url',
			),
			'company_link_new_window'		=> array(
				'label'				=> esc_html__( 'Website Link Target', 'et_builder' ),
				'description'      	=> esc_html__( 'Here you can choose whether or not your link opens in a new window', 'et_builder' ),
				'type'             	=> 'select',
				'option_category'  	=> 'configuration',
				'options'         	=> array(
					'off' => esc_html__( 'In The Same Window', 'et_builder' ),
					'on'  => esc_html__( 'In The New Tab', 'et_builder' ),
				),
				'toggle_slug'      => 'main_content',
				'default_on_front' => 'off',
			),
            // Content
            'dnxte_testimonial_description' => array(
                'label' => esc_html__('Description', 'et_builder'),
                'type' => 'tiny_mce',
                'dynamic_content' => 'text',
                'option_category' => 'basic_option',
                'description' => esc_html__('Content entered here will appear inside the module.', 'et_builder'),
                'toggle_slug' => 'main_content',
            ),
            // Image
            'dnxte_testimonial_logo' => array(
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
                'toggle_slug' => 'dnxte_testimonial_logo_settings',
            ),
            // Image alt
            'dnxte_testimonial_logo_alt' => array(
                'label' => esc_html__('Image Alt Text', 'et_builder'),
                'type' => 'text',
                'default' => 'Testimonial Item',
                'option_category' => 'basic_option',
                'description' => esc_html__(
                    'Define the HTML ALT text for your image here.',
                    'et_builder'
                ),
                'toggle_slug' => 'dnxte_testimonial_logo_settings',
            ),
            // Rating
            'dnxte_testimonial_rating_position' => array(
                'label' => esc_html__('Rating Position', 'et_builder'),
                'description' => esc_html__('Choose rating Style', 'et_builder'),
                'type' => 'select',
                'option_category' => 'layout',
                'toggle_slug' => 'dnxte_testimonial_rating_settings',
                'options' => array(
                    'none' => esc_html__('None', 'et_builder'),
                    'top' => esc_html__('Top of Description', 'et_builder'),
                    'bottom' => esc_html__('Bottom of Description', 'et_builder'),
                ),
                'default' => 'bottom',
                'default_on_front' => 'bottom',
            ),
            'dnxte_testimonial_star_rating' => array(
                'label' => esc_html__('Rating', 'et_builder'),
                'description' => esc_html__('Adjust the rating of the review.', 'et_builder'),
                'type' => 'range',
                'option_category' => 'basic_option',
                'toggle_slug' => 'dnxte_testimonial_rating_settings',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'default' => '5',
                'fixed_unit' => '',
                'validate_unit' => false,
                'unitless' => true,
                'default_on_front' => '5',
                'allow_empty' => true,
                'range_settings' => array(
                    'min' => '0',
                    'max' => '10',
                    'step' => '0.1',
                ),
                'mobile_options' => true,
                'hover' => 'tabs',
            ),
            'dnxte_testimonial_star_scale' => array(
                'label' => esc_html__('Rating Scale', 'et_builder'),
                'description' => esc_html__('Choose your rating scale', 'et_builder'),
                'type' => 'select',
                'option_category' => 'layout',
                'toggle_slug' => 'dnxte_testimonial_rating_settings',
                'options' => array(
                    '5' => esc_html__('0 - 5', 'et_builder'),
                    '10' => esc_html__('0 - 10', 'et_builder'),
                ),
                'default' => '5',
            ),
            'dnxte_testimonial_description_padding' => array(
                'label' => esc_html__('Description Padding', 'et_builder'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'dnxte_testimonial_image_margin' => array(
                'label' => esc_html__('Image Margin', 'et_builder'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'default' => '0|15px|0|0',
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'dnxte_testimonial_image_padding' => array(
                'label' => esc_html__('Image Padding', 'et_builder'),
                'type' => 'custom_padding',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
        );

        $additional = array();


        $additional = array(
            'description_bg_color' => array(
                'label' => esc_html__('Description Background', 'et_builder'),
                'type' => 'background-field',
                'base_name' => "description_bg",
                'context' => "description_bg",
                'option_category' => 'layout',
                'custom_color' => true,
                'default' => ET_Global_Settings::get_value('all_buttons_bg_color'),
                'depends_show_if' => 'on',
                'tab_slug' => 'advanced',
                'toggle_slug' => "dnxte_testimonial_description_background",
                'background_fields' => array_merge(
                    ET_Builder_Element::generate_background_options(
                        'description_bg',
                        'gradient',
                        "advanced",
                        "dnxte_testimonial_description_background",
                        "description_bg_gradient"
                    ),
                    ET_Builder_Element::generate_background_options(
                        "description_bg",
                        "color",
                        "advanced",
                        "dnxte_testimonial_description_background",
                        "description_bg_color"
                    )
                    ),
                'mobile_options' => true,
                'hover' => 'tabs'
            )
        );

        $additional = array_merge(
            $additional,
            $this->generate_background_options(
                'description_bg',
                'skip',
                "advanced",
                "dnxte_testimonial_description_background",
                "description_bg_gradient"
            ),
            $this->generate_background_options(
                'description_bg',
                'skip',
                "advanced",
                "dnxte_testimonial_description_background",
                "description_bg_color"
            )
        );

        return array_merge($field, $additional);
    }

    public function render($attrs, $content, $render_slug)
    {
        $multi_view = et_pb_multi_view_options($this);
        $dnxt_logo = $this->props['dnxte_testimonial_logo'];
        $dnxt_logo_alt = $this->props['dnxte_testimonial_logo_alt'];
        $dnxt_name = $this->props['dnxte_testimonial_name'];
        $dnxt_position = $this->props['dnxte_testimonial_position'];
        $dnxt_description = $this->props['dnxte_testimonial_description'];
        // Rendering Star
        $rating_scale = (int) $this->props['dnxte_testimonial_star_scale'];
        $rating = (float) $this->props['dnxte_testimonial_star_rating'] > $rating_scale ? $rating_scale : $this->props['dnxte_testimonial_star_rating'];
        $render_stars = Common::render_stars($rating,$rating_scale);

        $company_name = $this->props['company_name'];
        $company_link = $this->props['company_link'];
        $company_link_target = 'on' == $this->props['company_link_new_window'] ? '_blank' : '';
        
        // Name
        $name = $multi_view->render_element(array(
            'tag' => et_pb_process_header_level($this->props['header_level'], 'h4'),
            'content' => '{{dnxte_testimonial_name}}',
            'attrs' => array(
                'class' => 'dnxte-tstprfle-nam',
            ),
        ));

        // Render Button
        $button = '';
        if('' != $company_link) {
            $button = sprintf('<span><a href="%1$s" class="dnxte-testimonial-company-name" target="%2$s">%3$s</a></span>', esc_attr($company_link), esc_attr($company_link_target), esc_html($company_name));
        }else {
            $button = sprintf('<span><span class="dnxte-testimonial-company-name">%1$s<span></span>', esc_html($company_name));
        }


        // Position
        $position = "";
        if ('' !== $dnxt_position) {
            $position = sprintf('<div class="dnxte-tstimonial-prfledeg">
            <span class="dnxte-tst-prfledeg-des">%1$s</span> %2$s
            </div>', esc_attr($dnxt_position), $button);
        }


        // Render Description
        $description = $multi_view->render_element( array(
            'tag' => 'div',
            'content' => '{{dnxte_testimonial_description}}',
            'attrs' => array(
            'class' => 'dnxte-itcont-des',
            )
            ));

        // Image
        $image = "";
        if ('' !== $dnxt_logo) {
            $image = sprintf('<div class="dnxte-tstimonial-prfle-review">
                    <img class="img-fluid" src="%1$s" alt="%2$s">
                 </div>', $dnxt_logo, esc_attr($dnxt_logo_alt));
        }

        $stars_output_top = "";
        $starts_output = "";
        if ($this->props['dnxte_testimonial_rating_position'] === "top") {
            $stars_output_top = sprintf('<div class="dnxte-rating-revstar dnext-star-rating">%1$s</div>', $render_stars);
        } elseif($this->props['dnxte_testimonial_rating_position'] === "bottom") {
            $starts_output = sprintf('<div class="dnxte-rating-revstar dnext-star-rating">%1$s</div>', $render_stars);
        }

        // Timeline background color
        $description_bg_color = array(
            'color_slug' => "description_bg_color"
        );
        $use_color_gradient = $this->props['description_bg_use_color_gradient'];
        $gradient = array(
            "gradient_type" => 'description_bg_color_gradient_type',
            "gradient_direction" => 'description_bg_color_gradient_direction',
            "radial" => 'description_bg_color_gradient_direction_radial',
            "gradient_start" => 'description_bg_color_gradient_start',
            "gradient_end" => 'description_bg_color_gradient_end',
            "gradient_start_position" => 'description_bg_color_gradient_start_position',
            "gradient_end_position" => 'description_bg_color_gradient_end_position',
            "gradient_overlays_image" => 'description_bg_color_gradient_overlays_image',
        );

        $css_property = array(
            "desktop" => "%%order_class%% .dnxte-itcont-des",
            "hover" => "%%order_class%% .dnxte-itcont-des:hover"
        );
        Common::apply_bg_css($render_slug, $this, $description_bg_color, $use_color_gradient, $gradient, $css_property);
        //Timeline background color end

        $this->apply_css($render_slug);
        $output = sprintf(
            '<div class="dnxte-tstimonial-item-con">
            <div class="dnxte-quote-icon2">
                <span aria-hidden="true" class="icon_quotations2"></span>
            </div>
            %6$s
            %1$s
            %5$s
            <div class="dnxte-tstimonial-item-prfle">
                %2$s
                <div class="dnxte-tstimonial-prfle-des">
                    <div class="dnxte-tstimonial-prfle-des-name">
                        %3$s
                        </div>
                    %4$s
                    </div>
            </div>
        </div>',
            $description,
            $image,
            et_core_esc_previously($name),
            $position,
            $starts_output,
            $stars_output_top
        );
        return $output;
    }

    public function apply_css($render_slug)
    {

        /**
         * Custom Padding Margin Output
         *
         */
        Common::dnxt_set_style($render_slug, $this->props, "dnxte_testimonial_description_padding", "%%order_class%% .dnxte-itcont-des", "padding");
        Common::dnxt_set_style($render_slug, $this->props, "dnxte_testimonial_image_margin", "%%order_class%% .dnxte-tstimonial-prfle-review", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "dnxte_testimonial_image_padding", "%%order_class%% .dnxte-tstimonial-prfle-review", "padding");
    }
}

new Divi_NxteTestimonialChild;
