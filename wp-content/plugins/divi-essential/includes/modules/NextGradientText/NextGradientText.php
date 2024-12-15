<?php

class Next_Gradient_Text extends ET_Builder_Module
{

    public $slug = 'dnxte_gradient_text';
    public $vb_support = 'on';

    protected $module_credits = array(
        'module_uri' => 'https://www.diviessential.com/divi-gradient-text/',
        'author'     => 'Divi Next',
        'author_uri' => 'www.divinext.com',
    );

    public function init()
    {
        $this->name        = esc_html__('Next Text Gradient', 'et_builder');
        $this->icon_path   = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->folder_name = 'et_pb_divi_essential';

        $this->settings_modal_toggles = array(
            'general' => array(
                'toggles' => array(
                    'dnxt_gradient_text' => esc_html__('Text', 'et_builder'),
                ),
            ),
            'advanced' => array(
                'toggles' => array(
                    'title_font' => array(
                        'title' => esc_html__('Fonts', 'et_builder'),
                        'priority' => 1,
                    ),
                    //Gradient Toggles
                    'gradient_text' => array(
                        'title' => esc_html__('Gradient Color', 'et_builder'),
                        'priority' => 2,
                    ),
                    //Text Reveal Effect
                    'text_reveal_effect' => array(
                        'title' => esc_html__('Reveal Effect', 'et_builder'),
                        'priority' => 3,
                    ),
                    // Hover Effect
                    'dnxt_text_hover_effect' => array(
                        'title' => esc_html__('Hover Effect', 'et_builder'),
                        'priority' => 4,
                    ),
                    // Border Toggles
                    'title_border' => array(
                        'title' => esc_html__('Border', 'et_builder'),
                        'priority' => 5,
                    ),
                ),
            ),
        );
        // Custom CSS Field
        $this->custom_css_fields = array(
            'gradient_title_css' => array(
                'label' => esc_html__('Title CSS', 'et_builder'),
                'selector' => '%%order_class%% .dnxt-gradient-text',
            ),
        );
    }

    public function get_fields()
    {

        return array(
            // Title Field
            'gradient_title' => array(
                'label' => esc_html__('Gradient Title', 'et_builder'),
                'type' => 'text',
                'dynamic_content' => 'text',
                //'default'         => 'Gradient Heading Text',
                'option_category' => 'basic_option',
                'description' => esc_html__('Title entered here will appear with gradient color.', 'et_builder'),
                'toggle_slug' => 'dnxt_gradient_text',
            ),
            // Heading Tag Option
            'heading_tag' => array(
                'label' => esc_html__('Select Heading Tag', 'et_builder'),
                'type' => 'select',
                'description' => esc_html__('Select the heading tag, which you would like to use', 'et_builder'),
                'option_category' => 'basic_option',
                'toggle_slug' => 'dnxt_gradient_text',
                'options' => array(
                    'h1' => esc_html__('H1', 'et_builder'),
                    'h2' => esc_html__('H2', 'et_builder'),
                    'h3' => esc_html__('H3', 'et_builder'),
                    'h4' => esc_html__('H4', 'et_builder'),
                    'h5' => esc_html__('H5', 'et_builder'),
                    'h6' => esc_html__('H6', 'et_builder'),
                    'p' => esc_html__('P', 'et_builder'),
                    'span' => esc_html__('Span', 'et_builder'),
                ),
                'default' => 'h2',
            ),
            // Gradient Color One Select One
            'gradient_color_one_select_text' => array(
                'label' => esc_html__('Select Color One', 'et_builder'),
                'type' => 'color-alpha',
                'tab_slug' => 'advanced',
                'description' => esc_html__('Choose the first color to blend with the second color from the color picker that suits your title text.', 'et_builder'),
                'toggle_slug' => 'gradient_text',
                'default' => '#0077FF',
            ),
            // Gradient Color Two Select Two
            'gradient_color_two_select_text' => array(
                'label' => esc_html__('Select Color Two', 'et_builder'),
                'type' => 'color-alpha',
                'tab_slug' => 'advanced',
                'description' => esc_html__('Choose the second color to blend with the first color from the color picker that suits your title text.', 'et_builder'),
                'toggle_slug' => 'gradient_text',
                'default' => '#772ADB',
            ),
            // Gradient type text
            'gradient_type_text' => array(
                'label' => esc_html__('Select Gradient Type', 'et_builder'),
                'type' => 'select',
                'description' => esc_html__('Select a type of gradient for the Title Text.', 'et_builder'), 'option_category' => 'basic_option',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'gradient_text',
                'options' => array(
                    'linear-gradient' => esc_html__('Linear', 'et_builder'),
                    'radial-gradient' => esc_html__('Radial', 'et_builder'),
                ),
                'default' => 'linear-gradient',
            ),
            // Gradient Linear Type Direction
            'gradient_type_linear_direction_text' => array(
                'label' => esc_html__('Gradient direction', 'et_builder'),
                'type' => 'range',
                'option_category' => 'basic_option',
                'tab_slug' => 'advanced',
                'description' => esc_html__('Adjust the direction of the gradient for the title text.', 'et_builder'),
                'toggle_slug' => 'gradient_text',
                'range_settings' => array(
                    'step' => 1,
                    'min' => 1,
                    'max' => 360,
                ),
                'default' => '180deg',
                'fixed_unit' => 'deg',
                'validate_unit' => true,
                'show_if' => array(
                    'gradient_type_text' => 'linear-gradient',
                ),
            ),
            // Gradient Radial Type Selection
            'gradient_type_radial_direction_text' => array(
                'label' => esc_html__('Radial Direction', 'et_builder'),
                'type' => 'select',
                'description' => esc_html__('Adjust the direction of the gradient for the title text.', 'et_builder'),
                'tab_slug' => 'advanced',
                'toggle_slug' => 'gradient_text',
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
                    'gradient_type_text' => 'radial-gradient',
                ),
            ),
            // Gradient Start Position
            'gradient_start_position_text' => array(
                'label' => esc_html__('Start Position', 'et_builder'),
                'type' => 'range',
                'description' => esc_html__('Adjust the position for the beginning of the gradient color.', 'et_builder'),
                'option_category' => 'basic_option',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'gradient_text',
                'range_settings' => array(
                    'step' => 1,
                    'min' => 1,
                    'max' => 100,
                ),
                'default' => '0%',
                'fixed_unit' => '%',
                'validate_unit' => true,
            ),
            // Gradient End Position
            'gradient_end_position_text' => array(
                'label' => esc_html__('End Position', 'et_builder'),
                'type' => 'range',
                'description' => esc_html__('Adjust the position for the ending of the gradient color.', 'et_builder'),
                'option_category' => 'basic_option',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'gradient_text',
                'range_settings' => array(
                    'step' => 1,
                    'min' => 1,
                    'max' => 100,
                ),
                'default' => '100%',
                'fixed_unit' => '%',
                'validate_unit' => true,
            ),
            // Text Reveal Effect Switch
            'text_reveal_effect' => array(
                'label' => esc_html__('Enable Reveal Effect', 'et_builder'),
                'type' => 'yes_no_button',
                'description' => esc_html__('Select to turn Reveal Effect on.', 'et_builder'),
                'tab_slug' => 'advanced',
                'toggle_slug' => 'text_reveal_effect',
                'options' => array(
                    'off' => esc_html__('Off', 'et_builder'),
                    'on' => esc_html__('On', 'et_builder'),
                ),
                'default' => 'off',
            ),
            // Text Reveal Color Before
            'text_reveal_color_before' => array(
                'label' => esc_html__('Reveal Effect Color', 'et_builder'),
                'type' => 'color-alpha',
                'description' => esc_html__('Choose a custom color to reveal your text with the function of reveal effect.', 'et_builder'),
                'tab_slug' => 'advanced',
                'toggle_slug' => 'text_reveal_effect',
                'default' => '#0077FF',
                'show_if' => array(
                    'text_reveal_effect' => 'on',
                ),
            ),
            // Text Hover Switch
            'dnxt_text_hover_effect_switch' => array(
                'label' => esc_html__('Text Hover Effect', 'et_builder'),
                'type' => 'yes_no_button',
                'description' => esc_html__('Select if you would like to use text hover effect', 'et_builder'),
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxt_text_hover_effect',
                'options' => array(
                    'off' => esc_html__('Off', 'et_builder'),
                    'on' => esc_html__('On', 'et_builder'),
                ),
                'default' => 'off',

            ),
            // Select Hover Effect
            'dnxt_text_hover_effect_select' => array(
                'label' => esc_html__('Select Hover Effect', 'et_builder'),
                'type' => 'select',
                'option_category' => 'configuration',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnxt_text_hover_effect',
                'default' => 'dnxt-hover-grow',
                'description' => esc_html__('Here you can adjust the hover effect.'),
                'options' => array(
                    'dnxt-hover-backward' => esc_html__('Backward', 'et_builder'),
                    'dnxt-hover-bob' => esc_html__('Bob', 'et_builder'),
                    'dnxt-hover-bounce-in' => esc_html__('Bounce In', 'et_builder'),
                    'dnxt-hover-bounce-out' => esc_html__('Bounce Out', 'et_builder'),
                    'dnxt-hover-buzz' => esc_html__('Buzz', 'et_builder'),
                    'dnxt-hover-buzz-out' => esc_html__('Buzz Out', 'et_builder'),
                    'dnxt-hover-float' => esc_html__('Float', 'et_builder'),
                    'dnxt-hover-forward' => esc_html__('Forward', 'et_builder'),
                    'dnxt-hover-grow' => esc_html__('Grow', 'et_builder'),
                    'dnxt-hover-grow-rotate' => esc_html__('Grow Rotate', 'et_builder'),
                    'dnxt-hover-hang' => esc_html__('Hang', 'et_builder'),
                    'dnxt-hover-pop' => esc_html__('Pop', 'et_builder'),
                    'dnxt-hover-pulse' => esc_html__('Pulse', 'et_builder'),
                    'dnxt-hover-pulse-grow' => esc_html__('Pulse Grow', 'et_builder'),
                    'dnxt-hover-pulse-shrink' => esc_html__('Pulse Shrink', 'et_builder'),
                    'dnxt-hover-push' => esc_html__('Push', 'et_builder'),
                    'dnxt-hover-rotate' => esc_html__('Rotate', 'et_builder'),
                    'dnxt-hover-shrink' => esc_html__('Shrink', 'et_builder'),
                    'dnxt-hover-sink' => esc_html__('Sink', 'et_builder'),
                    'dnxt-hover-skew' => esc_html__('Skew', 'et_builder'),
                    'dnxt-hover-skew-backward' => esc_html__('Skew Backward', 'et_builder'),
                    'dnxt-hover-skew-forward' => esc_html__('Skew Forward', 'et_builder'),
                    'dnxt-hover-wobble-bottom' => esc_html__('Wobble Bottom', 'et_builder'),
                    'dnxt-hover-wobble-horizontal' => esc_html__('Wobble Horizontal', 'et_builder'),
                    'dnxt-hover-wobble-skew' => esc_html__('Wobble Skew', 'et_builder'),
                    'dnxt-hover-wobble-top' => esc_html__('Wobble Top', 'et_builder'),
                    'dnxt-hover-wobble-to-bottom-right' => esc_html__('Wobble To Bottom Right', 'et_builder'),
                    'dnxt-hover-wobble-to-top-right' => esc_html__('Wobble To Top Right', 'et_builder'),
                    'dnxt-hover-wobble-vertical' => esc_html__('Wobble Vertical', 'et_builder'),
                ),
                'show_if' => array(
                    'dnxt_text_hover_effect_switch' => 'on',
                ),
            ),
        );
    }

    public function get_advanced_fields_config()
    {
        $advanced_fields = array();

        $advanced_fields['fonts'] = false;

        $advanced_fields['fonts'] = array(
            //Font Title
            'gradient_fonts' => array(
                'label' => esc_html__('Title', 'et_builder'),
                'toggle_slug' => 'title_font',
                'tab_slug' => 'advanced',
                'hide_text_color' => true,
                'hide_text_align' => true,
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '26px',
                ),
                'css' => array(
                    'main' => "%%order_class%% .dnxt-gradient-text",
                ),
            ),
        );
        $advanced_fields['borders'] = array(
            'title_border' => array(
                'label_prefix' => esc_html__("Text", 'et_builder'),
                'tab_slug' => 'advanced',
                'toggle_slug' => 'title_border',
                'css' => array(
                    'main' => array(
                        'border_radii' => "%%order_class%% .dnxt-gradient-text",
                        'border_styles' => "%%order_class%% .dnxt-gradient-text",
                    ),
                ),
            ),
        );
        $advanced_fields['margin_padding'] = array(
            'css' => array(
                'main' => "%%order_class%% .dnxt-reveal-text-container",
                'important' => 'all',
            ),
        );
        $advanced_fields['background'] = array(
            'settings' => array(
                'color' => 'alpha',
            ),
            'css' => array(
                'main' => "%%order_class%% .dnxt-reveal-text-container",
                'important' => 'all',
            ),
        );
        return $advanced_fields;
    }

    public function render($attrs, $content, $render_slug)
    {   
        wp_enqueue_script( 'dnext_wow-public' );
        wp_enqueue_script( 'dnext_wow-activation' );
        wp_enqueue_style('dnext_hvr_common_css');
        wp_enqueue_style( 'dnext_reveal_animation' );

        $headingTag = $this->props['heading_tag'];

        $this->apply_css($render_slug);

        $text_reveal_enable = '';
        if ('on' === $this->props['text_reveal_effect']) {
            $text_reveal_enable = "reveal-effect masker wow";
        } else {
            $text_reveal_enable = "";
        }

        $text_hover_effect_enable = '';
        if ('on' === $this->props['dnxt_text_hover_effect_switch']) {
            $text_hover_effect_enable = $this->props['dnxt_text_hover_effect_select'];
        } else {
            $text_hover_effect_enable = "";
        }

        return sprintf(
            '<div class="dnxt-text-reveal">
            <div class="dnxt-reveal-text-container">
                <div class="%2$s">
                    <%1$s class="dnxt-gradient-text dnxt-gradient-text-color %4$s ">%3$s</%1$s>
                </div>
            </div>
        </div>',
            $headingTag,
            $text_reveal_enable,
            $this->props['gradient_title'],
            $text_hover_effect_enable
        );
    }

    public function apply_css($render_slug)
    {

        //Gradient Text Color CSS T1 Start
        $gradient_type_text = '';
        $gradient_type_direction_apply_text = '';
        $gradient_linear_direction_text = '';
        $gradient_radial_diretion_text = '';
        $gradient_color_one_select_text = '';
        $gradient_color_two_select_text = '';
        $gradient_start_position_text = '';
        $gradient_end_position_text = '';

        // checking gradient type
        if ('' !== $this->props['gradient_type_text']) {
            $gradient_type_text = $this->props['gradient_type_text'];
        }

        // Linear gradient direction
        if ('' !== $this->props['gradient_type_linear_direction_text']) {
            $gradient_linear_direction_text = $this->props['gradient_type_linear_direction_text'];
        }

        // Gradient Radial Direction text
        if ('' !== $this->props['gradient_type_radial_direction_text']) {
            $gradient_radial_diretion_text = $this->props['gradient_type_radial_direction_text'];
        }

        // Apply gradient direcion
        if ('radial-gradient' === $this->props['gradient_type_text']) {
            $gradient_type_direction_apply_text = sprintf('%1$s', $gradient_radial_diretion_text);
        } elseif ('linear-gradient' === $this->props['gradient_type_text']) {
            $gradient_type_direction_apply_text = sprintf('%1$s', $gradient_linear_direction_text);
        }

        // Gradient color one for text
        if ('' !== $this->props['gradient_color_one_select_text']) {
            $gradient_color_one_select_text = $this->props['gradient_color_one_select_text'];
        }

        // Gradient color two for text
        if ('' !== $this->props['gradient_color_two_select_text']) {
            $gradient_color_two_select_text = $this->props['gradient_color_two_select_text'];
        }

        // Gradient color start position text
        if ('' !== $this->props['gradient_start_position_text']) {
            $gradient_start_position_text = $this->props['gradient_start_position_text'];
        }

        // Gradient color end position t1
        if ('' !== $this->props['gradient_end_position_text']) {
            $gradient_end_position_text = $this->props['gradient_end_position_text'];
        }

        // Gradient setting up
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .dnxt-gradient-text.dnxt-gradient-text-color",
            'declaration' => "background: {$gradient_type_text}($gradient_type_direction_apply_text, $gradient_color_one_select_text $gradient_start_position_text, $gradient_color_two_select_text $gradient_end_position_text);-webkit-background-clip: text;-webkit-text-fill-color: transparent;",
        ));

        //Text Reveal Effect CSS Start
        $text_reveal_effect = '';
        $text_reveal_color_before = '';

        // Reveal Effect for color before
        if ('' !== $this->props['text_reveal_color_before']) {
            $text_reveal_color_before = $this->props['text_reveal_color_before'];
        }

        // Text Reveal Effect setting up
        if ('on' === $this->props['text_reveal_effect']) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .reveal-effect.masker:after",
                'declaration' => "background: {$this->props['text_reveal_color_before']};",
            ));
        }

        /**
         * Border one default color
         *
         */
        if (('' === $this->props['border_color_top_title_border']) && ('' === $this->props['border_color_all_title_border'])) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxt-gradient-text",
                'declaration' => "border-top-color: #333333;",
            ));
        }

        if (('' === $this->props['border_color_bottom_title_border']) && ('' === $this->props['border_color_all_title_border'])) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxt-gradient-text",
                'declaration' => "border-bottom-color: #333333;",
            ));
        }

        if (('' === $this->props['border_color_left_title_border']) && ('' === $this->props['border_color_all_title_border'])) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxt-gradient-text",
                'declaration' => "border-left-color: #333333;",
            ));
        }

        if (('' === $this->props['border_color_right_title_border']) && ('' === $this->props['border_color_all_title_border'])) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxt-gradient-text",
                'declaration' => "border-right-color: #333333;",
            ));
        }

        //  Border one default style
        if (('' === $this->props['border_style_top_title_border']) && ('' === $this->props['border_style_all_title_border'])) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxt-gradient-text",
                'declaration' => "border-top-style: solid;",
            ));
        }

        if (('' === $this->props['border_style_bottom_title_border']) && ('' === $this->props['border_style_all_title_border'])) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxt-gradient-text",
                'declaration' => "border-bottom-style: solid;",
            ));
        }

        if (('' === $this->props['border_style_left_title_border']) && ('' === $this->props['border_style_all_title_border'])) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxt-gradient-text",
                'declaration' => "border-left-style: solid;",
            ));
        }

        if (('' === $this->props['border_style_right_title_border']) && ('' === $this->props['border_style_all_title_border'])) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxt-gradient-text",
                'declaration' => "border-right-style: solid;",
            ));
        }

        // Text Alignment
        $this->props['text_orientation_last_edited'] = "";
        if ('' !== $this->props['text_orientation']) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxt-text-reveal",
                'declaration' => "text-align: {$this->props['text_orientation']};",
            ));
        }
        if ('on|tablet' === $this->props['text_orientation_last_edited']) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxt-text-reveal",
                'declaration' => "text-align: {$this->props['text_orientation_tablet']} !important;",
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));
        }
        if ('on|phone' === $this->props['text_orientation_last_edited']) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dnxt-text-reveal",
                'declaration' => "text-align: {$this->props['text_orientation_phone']} !important;",
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));
        }
    }
}

new Next_Gradient_Text;
