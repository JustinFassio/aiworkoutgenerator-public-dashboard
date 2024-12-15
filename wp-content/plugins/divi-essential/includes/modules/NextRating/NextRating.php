<?php
include_once(DIVI_ESSENTIAL_PATH.'/includes/modules/base/Common.php');

class Next_Rating extends ET_Builder_Module
{

    public $slug = 'dnxte_rating';
    public $vb_support = 'on';

    protected $module_credits = array(
        'module_uri' => 'https://www.diviessential.com/divi-rating/',
        'author' => 'Divi Next',
        'author_uri' => 'www.divinext.com',
    );

    public function init()
    {
        $this->name        = esc_html__('Next Rating', 'et_builder');
        $this->icon_path   = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->folder_name = 'et_pb_divi_essential';

        $this->settings_modal_toggles = array(
            'general' => array(
                'toggles' => array(
                    'next_rating' => array(
                        'title' => esc_html__('Rating', 'et_builder'),
                    ),
                ),
            ),
            'advanced' => array(
                'toggles' => array(
                    'rating_settings' => array(
                        'title' => esc_html__('Rating Settings', 'et_builder'),
                    ),
                ),
            ),
            'custom_css' => array(
                'toggles' => array(),
            ),
        );

        $this->advanced_fields = array(
            'fonts' => false,
            'text' => false,
        );

        // Custom CSS Field
        $this->custom_css_fields = array(

            'review_rating_wrapper' => array(
                'label' => esc_html__('Rating', 'et_builder'),
                'selector' => '%%order_class%% .dnxte-review-social',
            ),
        );
    }

    public function get_fields()
    {
        $fields = array(
            'star_rating' => array(
                'label' => esc_html__('Rating', 'et_builder'),
                'description' => esc_html__('Adjust the rating of the review.', 'et_builder'),
                'type' => 'range',
                'option_category' => 'basic_option',
                'toggle_slug' => 'next_rating',
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
            'star_scale' => array(
                'label' => esc_html__('Rating Scale', 'et_builder'),
                'description' => esc_html__('Choose your rating scale', 'et_builder'),
                'type' => 'select',
                'option_category' => 'layout',
                'toggle_slug' => 'next_rating',
                'options' => array(
                    '5' => esc_html__('0 - 5', 'et_builder'),
                    '10' => esc_html__('0 - 10', 'et_builder'),
                ),
                'default' => '5',
            ),
            'star_rating_alignment'    => array(
                'label'           => esc_html__('Rating Alignment', 'et_builder'),
                'description'     => esc_html__('Align rating to the left, right or center.', 'et_builder'),
                'type'            => 'align',
                'option_category' => 'layout',
                'options'         => et_builder_get_text_orientation_options(array('justified')),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'rating_settings',
                'mobile_options'  => true,
            ),
            'rating_color' => array(
                'label' => esc_html__('Select Star Color', 'et_builder'),
                'type' => 'color-alpha',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'rating_settings',
                'hover' => 'tabs',
                'default' => '#ffbf36',
            ),
            'star_size' => array(
                'label' => esc_html__('Size', 'et_builder'),
                'description' => esc_html__('Control the size of the star by increasing or decreasing the font size.', 'et_builder'),
                'type' => 'range',
                'option_category' => 'layout',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'rating_settings',
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
        );

        return $fields;
    }

    public function render($attrs, $content, $render_slug)
    {

        $multi_view = et_pb_multi_view_options($this);
        // Rendering star
        $rating_scale = (int) $this->props['star_scale'];
        $rating = (float) $this->props['star_rating'] > $rating_scale ? $rating_scale : $this->props['star_rating'];
        $render_stars = Common::render_stars($rating, $rating_scale);

        // Star Rating Alignment.
        $star_rating_alignment_classes = Common::get_alignment("star_rating_alignment", $this, "dnext");

        $stars_output = '<div class="dnxte-review-social dnext-star-rating">' . $render_stars . '</div> ';

        // Number Star Size
        $star_size = $this->props['star_size'];
        $star_size_values = et_pb_responsive_options()->get_property_values($this->props, 'star_size');
        $star_size_tablet = isset($star_size_values['tablet']) ? $star_size_values['tablet'] : '';
        $star_size_phone = isset($star_size_values['phone']) ? $star_size_values['phone'] : '';

        // Size
        if ('' !== $star_size) {
            $star_size_style = sprintf('font-size: %1$s !important;', esc_attr($star_size));
            $star_size_tablet_style = '' !== $star_size_tablet ? sprintf('font-size: %1$s !important;', esc_attr($star_size_tablet)) : '';
            $star_size_phone_style = '' !== $star_size_phone ? sprintf('font-size: %1$s !important;', esc_attr($star_size_phone)) : '';

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnext-star-rating .et-pb-icon",
                'declaration' => $star_size_style,
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnext-star-rating .et-pb-icon",
                'declaration' => $star_size_tablet_style,
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnext-star-rating .et-pb-icon",
                'declaration' => $star_size_phone_style,
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));
        }

        $oder_class = '%%order_class%% .dnext-star-rating i.divinext-star-full::before, %%order_class%% .dnext-star-rating i.divinext-star-1:before, %%order_class%% .dnext-star-rating i.divinext-star-2:before, %%order_class%% .dnext-star-rating i.divinext-star-3:before, %%order_class%% .dnext-star-rating i.divinext-star-4:before, %%order_class%% .dnext-star-rating i.divinext-star-5:before, %%order_class%% .dnext-star-rating i.divinext-star-6:before, %%order_class%% .dnext-star-rating i.divinext-star-7:before, %%order_class%% .dnext-star-rating i.divinext-star-8:before, %%order_class%% .dnext-star-rating i.divinext-star-9:before, %%order_class%% .dnext-star-rating i.divinext-star-10:before';
        // Star Color
        $rating_color_values = et_pb_responsive_options()->get_property_values($this->props, 'rating_color');
        et_pb_responsive_options()->generate_responsive_css($rating_color_values, $oder_class, 'color', $render_slug, '', 'color');

        return sprintf(
            '<div class="dnxte-star-wrapper %2$s">
				%1$s
			</div>',
            $stars_output,
            esc_attr( $star_rating_alignment_classes )
        );
    }
}

new Next_Rating;
