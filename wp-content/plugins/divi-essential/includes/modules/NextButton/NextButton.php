<?php
include_once(DIVI_ESSENTIAL_PATH.'/includes/modules/base/Common.php');

class Next_Button extends ET_Builder_Module {

	public $slug       = 'dnxte_button';
	public $vb_support = 'on';

	protected $module_credits = array(
		'module_uri' => 'https://www.diviessential.com/divi-next-button/',
		'author'     => 'Divi Next',
		'author_uri' => 'www.divinext.com',
	);

    public function init() {
        $this->name        = esc_html__('Next Button', 'et_builder');
        $this->icon_path   = plugin_dir_path( __FILE__ ) . 'icon.svg';
        $this->folder_name = 'et_pb_divi_essential';
        
        $this->settings_modal_toggles = array(
            'general'  => array(
                'toggles' => array(
                    'dnxt_button_text' => array(
                        'title'    => esc_html__('Text', 'et_builder'),
                        'priority' => 1,
                    ),
                    'dnxt_button_link' => array(
                        'title'    => esc_html__('Link', 'et_builder'),
                        'priority' => 3,
                    ),
                ),
            ),
            'advanced' => array(
                'toggles' => array(
                    'button_font'       => array(
                        'title'    => esc_html__('Text', 'et_builder'),
                        'priority' => 1,
                    ),
                    'button_alignment'  => array(
                        'title'    => esc_html__('Alignment', 'et_builder'),
                        'priority' => 2,
                    ),
                    'button_hover'      => array(
                        'title'             => esc_html__('Hover', 'et_builder'),
                        'priority'          => 3,
                        'sub_toggles'       => array(
                            'sub_toggle_2d'     => array(
                                'name' => '2D ',
                            ),
                            'sub_toggle_bg'     => array(
                                'name' => 'BG',
                            ),
                            'sub_toggle_border' => array(
                                'name' => 'Stroke',
                            ),
                            'sub_toggle_icons'  => array(
                                'name' => 'Icon',
                            ),
                        ),
                        'tabbed_subtoggles' => true,
                    ),
                    'button_icon'       => array(
                        'title'    => esc_html__('Icon', 'et_builder'),
                        'priority' => 4,
                    ),
                    'button_border'     => array(
                        'title'    => esc_html__('Border', 'et_builder'),
                        'priority' => 6,
                    ),
                    'button_background' => array(
                        'title'    => esc_html__('Background', 'et_builder'),
                        'priority' => 7,
                    ),
                ),
            ),
        );

        // Custom CSS Field
        $this->custom_css_fields = array(
            'button_wrapper' => array(
                'label'    => esc_html__('Button Wrapper', 'et_builder'),
                'selector' => '%%order_class%% .dnxt-button-wrapper',
            ),
            'button_link'    => array(
                'label'    => esc_html__('Button Link', 'et_builder'),
                'selector' => '%%order_class%% .dnxt-button-wrapper a',
            ),
        );
    }

    public function get_fields() {
        $fields = array(
            // Title Field
            'button_text'         => array(
                'label'           => esc_html__('Button Text', 'et_builder'),
                'type'            => 'text',
                'dynamic_content' => 'text',
                'default'         => esc_html__('Button Text', 'et_builder'),
                'option_category' => 'basic_option',
                'description'     => esc_html__('Title entered here will appear inside the module.', 'et_builder'),
                'toggle_slug'     => 'dnxt_button_text',
            ),
            // Link Field
            'button_link'                      => array(
                'label'           => esc_html__('Button Link', 'et_builder'),
                'type'            => 'text',
                'option_category' => 'configuration',
                'toggle_slug'     => 'dnxt_button_link',
                'description'     => esc_html__('When clicked the module will link to this URL.', 'et_builder'),
                'dynamic_content' => 'url',
            ),
            // Link Target Field
            'button_link_new_window'           => array(
                'label'            => esc_html__('Button Link Target', 'et_builder'),
                'type'             => 'select',
                'option_category'  => 'configuration',
                'options'          => array(
                    'off' => esc_html__('In The Same Window', 'et_builder'),
                    'on'  => esc_html__('In The New Tab', 'et_builder'),
                ),
                'toggle_slug'      => 'dnxt_button_link',
                'description'      => esc_html__('Here you can choose whether or not your link opens in a new window', 'et_builder'),
                'default_on_front' => 'off',
            ),
            // Button Alignment
            'dnxt_button_alignment'            => array(
                'label'           => esc_html__('Button Alignment', 'et_builder'),
                'type'            => 'align',
                'option_category' => 'configuration',
                'options'         => et_builder_get_text_orientation_options(array('justified')),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'button_alignment',
                'mobile_options'  => true,
                'description'     => esc_html__('Here you can define the alignment of Button', 'et_builder'),
            ),
            // Button Show & Hide
            'btn_show_hide'                    => array(
                'label'           => esc_html__('Show Icon', 'et_builder'),
                'description'     => esc_html__('When enabled, this will add a custom icon within the button.', 'et_builder'),
                'type'            => 'yes_no_button',
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'button_icon',
                'default'         => 'on',
                'options'         => array(
                    'on'  => esc_html__('Yes', 'et_builder'),
                    'off' => esc_html__('No', 'et_builder'),
                ),
                'affects'         => array(
                    "btn_icon_color",
                    "btn_icon_placement",
                    "btn_on_hover",
                    "btn_icon",
                ),
                'depends_show_if' => 'on',
            ),
            // Button Icon
            'btn_icon'                         => array(
                'label'               => esc_html__('Button Icon', 'et_builder'),
                'description'         => esc_html__('Pick a color to be used for the button icon.', 'et_builder'),
                'type'                => 'select_icon',
                'tab_slug'            => 'advanced',
                'toggle_slug'         => 'button_icon',
                'option_category'     => 'button',
                'class'               => array('et-pb-font-icon'),
                'default'             => '$',
                'mobile_options'      => true,
                'depends_show_if_not' => 'off',
            ),
            // Button Icon Color
            'btn_icon_color'          => array(
                'label'               => esc_html__('Button Icon Color', 'et_builder'),
                'description'         => esc_html__('Here you can define a custom color for the button icon.', 'et_builder'),
                'type'                => 'color-alpha',
                'tab_slug'            => 'advanced',
                'toggle_slug'         => 'button_icon',
                'custom_color'        => true,
                'default'             => '#2857b6',
                'hover'               => 'tabs',
                'mobile_options'      => true,
                'depends_show_if_not' => 'off',
            ),
            // Button Icon Placement
            'btn_icon_placement'               => array(
                'label'               => esc_html__('Button Icon Placement', 'et_builder'),
                'description'         => esc_html__('Choose where the button icon should be displayed within the button.', 'et_builder'),
                'type'                => 'select',
                'tab_slug'            => 'advanced',
                'toggle_slug'         => 'button_icon',
                'option_category'     => 'button',
                'options'             => array(
                    'right' => esc_html__('Right', 'et_builder'),
                    'left'  => esc_html__('Left', 'et_builder'),
                ),
                'default'             => 'right',
                'depends_show_if_not' => 'off',
            ),
            // Button Icon On Hover
            'btn_on_hover'                     => array(
                'label'               => esc_html__('Only Show Icon On Hover for Button', 'et_builder'),
                'description'         => esc_html__('By default, button icons are displayed on hover. If you would like button icons to always be displayed, then you can enable this option.', 'et_builder'),
                'type'                => 'yes_no_button',
                'tab_slug'            => 'advanced',
                'toggle_slug'         => 'button_icon',
                'default'             => 'on',
                'options'             => array(
                    'on'  => esc_html__('Yes', 'et_builder'),
                    'off' => esc_html__('No', 'et_builder'),
                ),
                'depends_show_if_not' => 'off',
            ),
            // Button Hover 2D
            'dnxt_hover_2d'                    => array(
                'label'           => esc_html__('Select 2D Hover Effect', 'et_builder'),
                'type'            => 'select',
                'option_category' => 'configuration',
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'button_hover',
                'sub_toggle'      => 'sub_toggle_2d',
                'default'         => '',
                'description'     => esc_html__('Here you can adjust the hover effect.', 'et_builder'),
                'options'         => array(
                    ''                                  => esc_html__('Select', 'et_builder'),
                    'dnxt-hover-backward'               => esc_html__('Backward', 'et_builder'),
                    'dnxt-hover-bob'                    => esc_html__('Bob', 'et_builder'),
                    'dnxt-hover-bounce-in'              => esc_html__('Bounce In', 'et_builder'),
                    'dnxt-hover-bounce-out'             => esc_html__('Bounce Out', 'et_builder'),
                    'dnxt-hover-buzz'                   => esc_html__('Buzz', 'et_builder'),
                    'dnxt-hover-buzz-out'               => esc_html__('Buzz Out', 'et_builder'),
                    'dnxt-hover-float'                  => esc_html__('Float', 'et_builder'),
                    'dnxt-hover-forward'                => esc_html__('Forward', 'et_builder'),
                    'dnxt-hover-grow'                   => esc_html__('Grow', 'et_builder'),
                    'dnxt-hover-grow-rotate'            => esc_html__('Grow Rotate', 'et_builder'),
                    'dnxt-hover-hang'                   => esc_html__('Hang', 'et_builder'),
                    'dnxt-hover-pop'                    => esc_html__('Pop', 'et_builder'),
                    'dnxt-hover-pulse'                  => esc_html__('Pulse', 'et_builder'),
                    'dnxt-hover-pulse-grow'             => esc_html__('Pulse Grow', 'et_builder'),
                    'dnxt-hover-pulse-shrink'           => esc_html__('Pulse Shrink', 'et_builder'),
                    'dnxt-hover-push'                   => esc_html__('Push', 'et_builder'),
                    'dnxt-hover-rotate'                 => esc_html__('Rotate', 'et_builder'),
                    'dnxt-hover-shrink'                 => esc_html__('Shrink', 'et_builder'),
                    'dnxt-hover-sink'                   => esc_html__('Sink', 'et_builder'),
                    'dnxt-hover-skew'                   => esc_html__('Skew', 'et_builder'),
                    'dnxt-hover-skew-backward'          => esc_html__('Skew Backward', 'et_builder'),
                    'dnxt-hover-skew-forward'           => esc_html__('Skew Forward', 'et_builder'),
                    'dnxt-hover-wobble-bottom'          => esc_html__('Wobble Bottom', 'et_builder'),
                    'dnxt-hover-wobble-horizontal'      => esc_html__('Wobble Horizontal', 'et_builder'),
                    'dnxt-hover-wobble-skew'            => esc_html__('Wobble Skew', 'et_builder'),
                    'dnxt-hover-wobble-top'             => esc_html__('Wobble Top', 'et_builder'),
                    'dnxt-hover-wobble-to-bottom-right' => esc_html__('Wobble To Bottom Right', 'et_builder'),
                    'dnxt-hover-wobble-to-top-right'    => esc_html__('Wobble To Top Right', 'et_builder'),
                    'dnxt-hover-wobble-vertical'        => esc_html__('Wobble Vertical', 'et_builder'),
                ),
            ),
            // Button Hover Effect
            'dnxt_hover_bg'                    => array(
                'label'           => esc_html__('Select Background Hover Effect', 'et_builder'),
                'type'            => 'select',
                'option_category' => 'configuration',
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'button_hover',
                'sub_toggle'      => 'sub_toggle_bg',
                'default'         => '',
                'description'     => esc_html__('Here you can adjust the hover effect.', 'et_builder'),
                'options'         => array(
                    ''                                  => esc_html__('Select', 'et_builder'),
                    'dnxt-hover-fade'                   => esc_html__('Fade', 'et_builder'),
                    'dnxt-hover-sweep-to-right'         => esc_html__('Sweep To Right', 'et_builder'),
                    'dnxt-hover-sweep-to-left'          => esc_html__('Sweep To Left', 'et_builder'),
                    'dnxt-hover-sweep-to-bottom'        => esc_html__('Sweep To Bottom', 'et_builder'),
                    'dnxt-hover-sweep-to-top'           => esc_html__('Sweep To Top', 'et_builder'),
                    'dnxt-hover-bounce-to-right'        => esc_html__('Bounce To Right', 'et_builder'),
                    'dnxt-hover-bounce-to-left'         => esc_html__('Bounce To Left', 'et_builder'),
                    'dnxt-hover-bounce-to-bottom'       => esc_html__('Bounce To Bottom', 'et_builder'),
                    'dnxt-hover-bounce-to-top'          => esc_html__('Bounce To Top', 'et_builder'),
                    'dnxt-hover-radial-out'             => esc_html__('Radial Out', 'et_builder'),
                    'dnxt-hover-radial-in'              => esc_html__('Radial In', 'et_builder'),
                    'dnxt-hover-rectangle-in'           => esc_html__('Rectangle In', 'et_builder'),
                    'dnxt-hover-rectangle-out'          => esc_html__('Rectangle Out', 'et_builder'),
                    'dnxt-hover-shutter-in-horizontal'  => esc_html__('Shutter In Horizontal', 'et_builder'),
                    'dnxt-hover-shutter-out-horizontal' => esc_html__('Shutter Out Horizontal', 'et_builder'),
                    'dnxt-hover-shutter-in-vertical'    => esc_html__('Shutter In Vertical', 'et_builder'),
                    'dnxt-hover-shutter-out-vertical'   => esc_html__('Shutter Out Vertical', 'et_builder'),
                ),
            ),
            // Button BG Color
            'dnxt_radial_out_bg_color'         => array(
                'label'       => esc_html__('Background Color', 'et_builder'),
                'description' => esc_html__('The color of the Background.', 'et_builder'),
                'type'        => 'color-alpha',
                'tab_slug'    => 'advanced',
                'toggle_slug' => 'button_hover',
                'sub_toggle'  => 'sub_toggle_bg',
                'default'     => 'rgba(0,0,0,0.3)',
                'show_if'     => array(
                    'dnxt_hover_bg' => 'dnxt-hover-radial-out',
                ),
            ),
            'dnxt_radial_in_bg_color'          => array(
                'label'       => esc_html__('Background Color', 'et_builder'),
                'description' => esc_html__('The color of the Background.', 'et_builder'),
                'type'        => 'color-alpha',
                'tab_slug'    => 'advanced',
                'toggle_slug' => 'button_hover',
                'sub_toggle'  => 'sub_toggle_bg',
                'default'     => 'rgba(0,0,0,0.3)',
                'show_if'     => array(
                    'dnxt_hover_bg' => 'dnxt-hover-radial-in',
                ),
            ),
            'dnxt_rectangle_in_bg_color'       => array(
                'label'       => esc_html__('Background Color', 'et_builder'),
                'description' => esc_html__('The color of the Background.', 'et_builder'),
                'type'        => 'color-alpha',
                'tab_slug'    => 'advanced',
                'toggle_slug' => 'button_hover',
                'sub_toggle'  => 'sub_toggle_bg',
                'default'     => 'rgba(0,0,0,0.3)',
                'show_if'     => array(
                    'dnxt_hover_bg' => 'dnxt-hover-rectangle-in',
                ),
            ),
            'dnxt_rectangle_out_bg_color'      => array(
                'label'       => esc_html__('Background Color', 'et_builder'),
                'description' => esc_html__('The color of the Background.', 'et_builder'),
                'type'        => 'color-alpha',
                'tab_slug'    => 'advanced',
                'toggle_slug' => 'button_hover',
                'sub_toggle'  => 'sub_toggle_bg',
                'default'     => 'rgba(0,0,0,0.3)',
                'show_if'     => array(
                    'dnxt_hover_bg' => 'dnxt-hover-rectangle-out',
                ),
            ),
            'dnxt_shutter_in_bg_color'         => array(
                'label'       => esc_html__('Background Color', 'et_builder'),
                'description' => esc_html__('The color of the Background.', 'et_builder'),
                'type'        => 'color-alpha',
                'tab_slug'    => 'advanced',
                'toggle_slug' => 'button_hover',
                'sub_toggle'  => 'sub_toggle_bg',
                'default'     => 'rgba(0,0,0,0.3)',
                'show_if'     => array(
                    'dnxt_hover_bg' => 'dnxt-hover-shutter-in-horizontal',
                ),
            ),
            'dnxt_shutter_out_bg_color'        => array(
                'label'       => esc_html__('Background Color', 'et_builder'),
                'description' => esc_html__('The color of the Background.', 'et_builder'),
                'type'        => 'color-alpha',
                'tab_slug'    => 'advanced',
                'toggle_slug' => 'button_hover',
                'sub_toggle'  => 'sub_toggle_bg',
                'default'     => 'rgba(0,0,0,0.3)',
                'show_if'     => array(
                    'dnxt_hover_bg' => 'dnxt-hover-shutter-out-horizontal',
                ),
            ),
            'dnxt_shutter_in_v_bg_color'       => array(
                'label'       => esc_html__('Background Color', 'et_builder'),
                'description' => esc_html__('The color of the Background.', 'et_builder'),
                'type'        => 'color-alpha',
                'tab_slug'    => 'advanced',
                'toggle_slug' => 'button_hover',
                'sub_toggle'  => 'sub_toggle_bg',
                'default'     => 'rgba(0,0,0,0.3)',
                'show_if'     => array(
                    'dnxt_hover_bg' => 'dnxt-hover-shutter-in-vertical',
                ),
            ),
            'dnxt_shutter_out_v_bg_color'      => array(
                'label'       => esc_html__('Background Color', 'et_builder'),
                'description' => esc_html__('The color of the Background.', 'et_builder'),
                'type'        => 'color-alpha',
                'tab_slug'    => 'advanced',
                'toggle_slug' => 'button_hover',
                'sub_toggle'  => 'sub_toggle_bg',
                'default'     => 'rgba(0,0,0,0.3)',
                'show_if'     => array(
                    'dnxt_hover_bg' => 'dnxt-hover-shutter-out-vertical',
                ),
            ),
            // Button Hover BG Color
            'dnxt_hover_bg_color'              => array(
                'label'       => esc_html__('Select Background Hover Color', 'et_builder'),
                'type'        => 'color-alpha',
                'tab_slug'    => 'advanced',
                'toggle_slug' => 'button_hover',
                'sub_toggle'  => 'sub_toggle_bg',
                'default'     => '#29c4a9',
            ),
            // Button Hover Strock
            'dnxt_hover_border'                => array(
                'label'           => esc_html__('Select Stroke Hover Effect', 'et_builder'),
                'type'            => 'select',
                'option_category' => 'configuration',
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'button_hover',
                'sub_toggle'      => 'sub_toggle_border',
                'default'         => '',
                'description'     => esc_html__('Here you can adjust the hover effect.', 'et_builder'),
                'options'         => array(
                    ''                                 => esc_html__('Select', 'et_builder'),
                    'dnxt-hover-trim'                  => esc_html__('Trim', 'et_builder'),
                    'dnxt-hover-ripple-out'            => esc_html__('Ripple Out', 'et_builder'),
                    'dnxt-hover-ripple-in'             => esc_html__('Ripple In', 'et_builder'),
                    'dnxt-hover-underline-from-left'   => esc_html__('Underline From Left', 'et_builder'),
                    'dnxt-hover-underline-from-center' => esc_html__('Underline From Center', 'et_builder'),
                    'dnxt-hover-underline-from-right'  => esc_html__('Underline From Right', 'et_builder'),
                    'dnxt-hover-reveal'                => esc_html__('Reveal', 'et_builder'),
                    'dnxt-hover-underline-reveal'      => esc_html__('Underline Reveal', 'et_builder'),
                    'dnxt-hover-overline-reveal'       => esc_html__('Overline Reveal', 'et_builder'),
                    'dnxt-hover-overline-from-left'    => esc_html__('Overline From Left', 'et_builder'),
                    'dnxt-hover-overline-from-center'  => esc_html__('Overline From Center', 'et_builder'),
                    'dnxt-hover-overline-from-right'   => esc_html__('Overline From Right', 'et_builder'),
                ),
            ),
            // Button Trim Border Color
            'dnxt_trim_border_color'           => array(
                'label'       => esc_html__('Border Color', 'et_builder'),
                'description' => esc_html__('The color of the Border.', 'et_builder'),
                'type'        => 'color-alpha',
                'tab_slug'    => 'advanced',
                'toggle_slug' => 'button_hover',
                'sub_toggle'  => 'sub_toggle_border',
                'default'     => 'rgba(0,0,0,0.3)',
                'show_if'     => array(
                    'dnxt_hover_border' => 'dnxt-hover-trim',
                ),
            ),
            // Button Hover Ripple Out Border Color
            'dnxt_ripple_out_color'            => array(
                'label'       => esc_html__('Border Color', 'et_builder'),
                'description' => esc_html__('The color of the Border.', 'et_builder'),
                'type'        => 'color-alpha',
                'tab_slug'    => 'advanced',
                'toggle_slug' => 'button_hover',
                'sub_toggle'  => 'sub_toggle_border',
                'default'     => 'rgba(0,0,0,0.3)',
                'show_if'     => array(
                    'dnxt_hover_border' => 'dnxt-hover-ripple-out',
                ),
            ),
            // Button Hover Ripple In Border Color
            'dnxt_ripple_in_color'             => array(
                'label'       => esc_html__('Border Color', 'et_builder'),
                'description' => esc_html__('The color of the Border.', 'et_builder'),
                'type'        => 'color-alpha',
                'tab_slug'    => 'advanced',
                'toggle_slug' => 'button_hover',
                'sub_toggle'  => 'sub_toggle_border',
                'default'     => 'rgba(0,0,0,0.3)',
                'show_if'     => array(
                    'dnxt_hover_border' => 'dnxt-hover-ripple-in',
                ),
            ),
            // Button Hover Underline From Left Border Color
            'dnxt_underline_from_left_color'   => array(
                'label'       => esc_html__('Border Color', 'et_builder'),
                'description' => esc_html__('The color of the Border.', 'et_builder'),
                'type'        => 'color-alpha',
                'tab_slug'    => 'advanced',
                'toggle_slug' => 'button_hover',
                'sub_toggle'  => 'sub_toggle_border',
                'default'     => 'rgba(0,0,0,0.3)',
                'show_if'     => array(
                    'dnxt_hover_border' => 'dnxt-hover-underline-from-left',
                ),
            ),
            // Button Hover Underline From Center Border Color
            'dnxt_underline_from_center_color' => array(
                'label'       => esc_html__('Border Color', 'et_builder'),
                'description' => esc_html__('The color of the Border.', 'et_builder'),
                'type'        => 'color-alpha',
                'tab_slug'    => 'advanced',
                'toggle_slug' => 'button_hover',
                'sub_toggle'  => 'sub_toggle_border',
                'default'     => 'rgba(0,0,0,0.3)',
                'show_if'     => array(
                    'dnxt_hover_border' => 'dnxt-hover-underline-from-center',
                ),
            ),
            // Button Hover Underline From Right Border Color
            'dnxt_underline_from_right_color'  => array(
                'label'       => esc_html__('Border Color', 'et_builder'),
                'description' => esc_html__('The color of the Border.', 'et_builder'),
                'type'        => 'color-alpha',
                'tab_slug'    => 'advanced',
                'toggle_slug' => 'button_hover',
                'sub_toggle'  => 'sub_toggle_border',
                'default'     => 'rgba(0,0,0,0.3)',
                'show_if'     => array(
                    'dnxt_hover_border' => 'dnxt-hover-underline-from-right',
                ),
            ),
            // Button Hover Overline From Left Border Color
            'dnxt_overline_left_color'         => array(
                'label'       => esc_html__('Border Color', 'et_builder'),
                'description' => esc_html__('The color of the Border.', 'et_builder'),
                'type'        => 'color-alpha',
                'tab_slug'    => 'advanced',
                'toggle_slug' => 'button_hover',
                'sub_toggle'  => 'sub_toggle_border',
                'default'     => 'rgba(0,0,0,0.3)',
                'show_if'     => array(
                    'dnxt_hover_border' => 'dnxt-hover-overline-from-left',
                ),
            ),
            // Button Hover Overline From Center Border Color
            'dnxt_overline_center_color'       => array(
                'label'       => esc_html__('Border Color', 'et_builder'),
                'description' => esc_html__('The color of the Border.', 'et_builder'),
                'type'        => 'color-alpha',
                'tab_slug'    => 'advanced',
                'toggle_slug' => 'button_hover',
                'sub_toggle'  => 'sub_toggle_border',
                'default'     => 'rgba(0,0,0,0.3)',
                'show_if'     => array(
                    'dnxt_hover_border' => 'dnxt-hover-overline-from-center',
                ),
            ),
            // Button Hover Overline From Right Border Color
            'dnxt_overline_right_color'        => array(
                'label'       => esc_html__('Border Color', 'et_builder'),
                'description' => esc_html__('The color of the Border.', 'et_builder'),
                'type'        => 'color-alpha',
                'tab_slug'    => 'advanced',
                'toggle_slug' => 'button_hover',
                'sub_toggle'  => 'sub_toggle_border',
                'default'     => 'rgba(0,0,0,0.3)',
                'show_if'     => array(
                    'dnxt_hover_border' => 'dnxt-hover-overline-from-right',
                ),
            ),
            // Button Hover Reveal Border Color
            'dnxt_reveal_color'                => array(
                'label'       => esc_html__('Border Color', 'et_builder'),
                'description' => esc_html__('The color of the Border.', 'et_builder'),
                'type'        => 'color-alpha',
                'tab_slug'    => 'advanced',
                'toggle_slug' => 'button_hover',
                'sub_toggle'  => 'sub_toggle_border',
                'default'     => 'rgba(0,0,0,0.3)',
                'show_if'     => array(
                    'dnxt_hover_border' => 'dnxt-hover-reveal',
                ),
            ),
            // Button Hover Underline Reveal Border Color
            'dnxt_underline_reveal_color'      => array(
                'label'       => esc_html__('Border Color', 'et_builder'),
                'description' => esc_html__('The color of the Border.', 'et_builder'),
                'type'        => 'color-alpha',
                'tab_slug'    => 'advanced',
                'toggle_slug' => 'button_hover',
                'sub_toggle'  => 'sub_toggle_border',
                'default'     => 'rgba(0,0,0,0.3)',
                'show_if'     => array(
                    'dnxt_hover_border' => 'dnxt-hover-underline-reveal',
                ),
            ),
            // Button Hover Overline Reveal Border Color
            'dnxt_overline_reveal_color'       => array(
                'label'       => esc_html__('Border Color', 'et_builder'),
                'description' => esc_html__('The color of the Border.', 'et_builder'),
                'type'        => 'color-alpha',
                'tab_slug'    => 'advanced',
                'toggle_slug' => 'button_hover',
                'sub_toggle'  => 'sub_toggle_border',
                'default'     => 'rgba(0,0,0,0.3)',
                'show_if'     => array(
                    'dnxt_hover_border' => 'dnxt-hover-overline-reveal',
                ),
            ),
            // Button Icons Hover Effect
            'dnxt_hover_icons'                 => array(
                'label'           => esc_html__('Select Icons Hover Effect', 'et_builder'),
                'type'            => 'select',
                'option_category' => 'configuration',
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'button_hover',
                'sub_toggle'      => 'sub_toggle_icons',
                'default'         => '',
                'description'     => esc_html__('Here you can adjust the hover effect.', 'et_builder'),
                'options'         => array(
                    ''                                  => esc_html__('Select', 'et_builder'),
                    'dnxt-hover-icon-back'              => esc_html__('Icon Back', 'et_builder'),
                    'dnxt-hover-icon-forward'           => esc_html__('Icon Forward', 'et_builder'),
                    'dnxt-hover-icon-down'              => esc_html__('Icon Down', 'et_builder'),
                    'dnxt-hover-icon-up'                => esc_html__('Icon Up', 'et_builder'),
                    'dnxt-hover-icon-drop'              => esc_html__('Icon Drop', 'et_builder'),
                    'dnxt-hover-icon-float-away'        => esc_html__('Icon Float Away', 'et_builder'),
                    'dnxt-hover-icon-sink-away'         => esc_html__('Icon Sink Away', 'et_builder'),
                    'dnxt-hover-icon-grow'              => esc_html__('Icon Grow', 'et_builder'),
                    'dnxt-hover-icon-shrink'            => esc_html__('Icon Shrink', 'et_builder'),
                    'dnxt-hover-icon-pulse'             => esc_html__('Icon pulse', 'et_builder'),
                    'dnxt-hover-icon-pulse-grow'        => esc_html__('Icon Pulse Grow', 'et_builder'),
                    'dnxt-hover-icon-pulse-shrink'      => esc_html__('Icon Pulse Shrink', 'et_builder'),
                    'dnxt-hover-icon-push'              => esc_html__('Icon Push', 'et_builder'),
                    'dnxt-hover-icon-pop'               => esc_html__('Icon Pop', 'et_builder'),
                    'dnxt-hover-icon-bounce'            => esc_html__('Icon Bounce', 'et_builder'),
                    'dnxt-hover-icon-rotate'            => esc_html__('Icon Rotate', 'et_builder'),
                    'dnxt-hover-icon-grow-rotate'       => esc_html__('Icon Grow Rotate', 'et_builder'),
                    'dnxt-hover-icon-float'             => esc_html__('Icon Float', 'et_builder'),
                    'dnxt-hover-icon-sink'              => esc_html__('Icon Sink', 'et_builder'),
                    'dnxt-hover-icon-bob'               => esc_html__('Icon Bob', 'et_builder'),
                    'dnxt-hover-icon-hang'              => esc_html__('Icon Hang', 'et_builder'),
                    'dnxt-hover-icon-wobble-horizontal' => esc_html__('Icon Wobble Horizontal', 'et_builder'),
                    'dnxt-hover-icon-wobble-vertical'   => esc_html__('Icon Wobble Vertical', 'et_builder'),
                    'dnxt-hover-icon-buzz'              => esc_html__('Icon Buzz', 'et_builder'),
                    'dnxt-hover-icon-buzz-out'          => esc_html__('Icon Buzz Out', 'et_builder'),
                ),
            ),
		);
		
		return $fields;
    }

	public function get_advanced_fields_config() {
        $advanced_fields = array();

        $advanced_fields['link_options'] = false;
        $advanced_fields['text']         = false;
        $advanced_fields['fonts']        = false;
        $advanced_fields['borders']      = false;
        //Button Text
        $advanced_fields['fonts'] = array(
            'btn_fonts' => array(
                'toggle_slug'     => 'button_font',
                'tab_slug'        => 'advanced',
                'hide_text_align' => true,
                'css'             => array(
                    'main' => "%%order_class%% .dnxt-button-wrapper a",

                ),
                'line_height'     => array(
                    'default' => '1em',
                ),
                'font_size'       => array(
                    'default' => '20px',
                ),
            ),
        );
        //Button Boxshadow
        $advanced_fields['box_shadow']['default'] = array(
            'css' => array(
                'main' => "%%order_class%% .dnxt-button-wrapper a",
            ),
        );
        //Button Background
        $advanced_fields['background'] = array(
            'toggle_slug' => 'button_background',
            'tab_slug'    => 'basic_option',
            'hover'       => 'tabs',
            'css'         => array(
                'main' => "%%order_class%% .dnxt-button-wrapper a",
                "hover" => "%%order_class%% .dnxt-button-wrapper a:hover"
            ), 
            'options'     => array(
                'background_color_gradient_start' => array(
                    'default' => et_builder_accent_color(),
                ),
                'background_color_gradient_end'   => array(
                    'default' => '#fff',
                ),
                'background_color_gradient_type'  => array(
                    'default' => 'radial',
                ),
            ),
        );
        //Button Borders
        $advanced_fields['borders'] = array(
            'btn_border' => array(
                'tab_slug'    => 'advanced',
                'toggle_slug' => 'button_border',
                'css'         => array(
                    'main' => array(
                        'border_radii'  => "%%order_class%% .dnxt-button-wrapper a",
                        'border_styles' => "%%order_class%% .dnxt-button-wrapper a",
                    ),
                ),
                'defaults'    => array(
                    'border_radii'  => 'on|3px|3px|3px|3px',
                    'border_styles' => array(
                        'width' => '2px',
                        'color' => '#2857b6',
                        'style' => 'solid',
                    ),
                ),
            ),
        );
        //Button Margin Padding
        $advanced_fields['margin_padding'] = array(
            'css'       => array(
                'margin'  => "%%order_class%% .dnxt-button-wrapper a",
                'padding' => "%%order_class%% .dnxt-button-wrapper a",
            ),
            'important' => 'all',
        );

        return $advanced_fields;
	}
	
	public function render( $attrs, $content, $render_slug ) {
        wp_enqueue_style('dnext_hvr_common_css');

        $multi_view 						= et_pb_multi_view_options( $this );
        $dnxt_button_alignment_classes = Common::get_alignment( "dnxt_button_alignment" , $this);

        $buttonTarget = 'on' === $this->props['button_link_new_window'] ? '_blank' : '_self';

        //Button On Hover class inner
        $btnIconOnHover = 'off' === $this->props['btn_on_hover'] ? "dnxt-btn-icon-on-hover" : "";

        // Button Hover 2d
        $btnHover2d = '';
        if ('' !== $this->props['dnxt_hover_2d']) {
            $btnHover2d = $this->props['dnxt_hover_2d'];
        }

        // Button Hover Background
        $btnHoverBg = '';
        if ('' !== $this->props['dnxt_hover_bg']) {
            $btnHoverBg = $this->props['dnxt_hover_bg'];
        }

        // Button Hover Stock
        $btnHoverBorder = '';
        if ('' !== $this->props['dnxt_hover_border']) {
            $btnHoverBorder = $this->props['dnxt_hover_border'];
        }

        // Button Hover Icons
        $btnHoverIcons = '';
        if ('' !== $this->props['dnxt_hover_icons']) {
            $btnHoverIcons = $this->props['dnxt_hover_icons'];
        }

        $rightItag = '';
        $lefItag   = '';
        
        $icon_css_property = array(
            'selector'    => '%%order_class%% .dnxt-btn-icon i',
            'class'       => ''
        );

        if ('right' === $this->props['btn_icon_placement']) {
            $rightItag = Common::get_icon_html( 'btn_icon', $this, $render_slug, $multi_view, $icon_css_property, 'i' );
        } else if ('left' === $this->props['btn_icon_placement']) {
            $lefItag = Common::get_icon_html( 'btn_icon', $this, $render_slug, $multi_view, $icon_css_property, 'i' );
        }

        $this->apply_css($render_slug);
        return sprintf(
            '<div class="dnxt-button-wrapper %11$s">
				<a class="dnxt-btn-icon %5$s %6$s %7$s %8$s %4$s" href="%9$s" target="%10$s">%2$s%1$s%3$s</a>
			</div>',
            esc_html__($this->props['button_text'], 'et_builder'),
            $lefItag,
            $rightItag,
            $btnIconOnHover,
            $btnHover2d, //5
            $btnHoverBg,
            $btnHoverBorder,
            $btnHoverIcons,
            $this->props['button_link'],
            $buttonTarget, //10
            esc_attr( $dnxt_button_alignment_classes )
        );
	}
	
    public function apply_css($render_slug) {
        if ("on" === $this->props['btn_show_hide']) {

            // Button Icon Placement
            if ('right' === $this->props['btn_icon_placement']) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector'    => "%%order_class%% .dnxt-btn-icon i",
                    'declaration' => 'content: attr(data-icon);',
                ));
            } else if ('left' === $this->props['btn_icon_placement']) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector'    => "%%order_class%% .dnxt-btn-icon i",
                    'declaration' => 'content: attr(data-icon);',
                ));
            }

  		// Button Icon Color
          $btn_icon_color		    = $this->props['btn_icon_color'];
          $btn_icon_color_hover 	= $this->get_hover_value( 'btn_icon_color' );
          $btn_icon_color_values	= et_pb_responsive_options()->get_property_values( $this->props, 'btn_icon_color' );
          $btn_icon_color_tablet	= isset( $btn_icon_color_values['tablet'] ) ? $btn_icon_color_values['tablet'] : '';
          $btn_icon_color_phone	    = isset( $btn_icon_color_values['phone'] ) ? $btn_icon_color_values['phone'] : '';

		if ( '' !== $btn_icon_color ) {
			$btn_icon_color_style 		 	= sprintf( 'color: %1$s;', esc_attr( $btn_icon_color ) );
			$btn_icon_color_tablet_style 	= '' !== $btn_icon_color_tablet ? sprintf( 'color: %1$s;', esc_attr( $btn_icon_color_tablet ) ) : '';
			$btn_icon_color_phone_style  	= '' !== $btn_icon_color_phone ? sprintf( 'color: %1$s;', esc_attr( $btn_icon_color_phone ) ) : '';
			
			$btn_icon_color_style_hover  = '';

			if ( et_builder_is_hover_enabled( 'btn_icon_color', $this->props ) ) {
				$btn_icon_color_style_hover = sprintf( 'color: %1$s;', esc_attr( $btn_icon_color_hover ) );
			}

			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnxt-btn-icon i",
				'declaration' => $btn_icon_color_style,
			) );
			
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnxt-btn-icon i",
				'declaration' => $btn_icon_color_tablet_style,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
			) );

			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnxt-btn-icon i",
				'declaration' => $btn_icon_color_phone_style,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
			) );

			if ( "" !== $btn_icon_color_style_hover ) {
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => $this->add_hover_to_order_class( "%%order_class%% .dnxt-btn-icon:hover i" ),
					'declaration' => $btn_icon_color_style_hover,
				) );
			}
		}

            // Button Icon On Hover
            if ('on' === $this->props['btn_on_hover'] && 'right' === $this->props['btn_icon_placement']) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector'    => "%%order_class%% .dnxt-btn-icon:hover i",
                    'declaration' => "opacity: 1;visibility: visible;margin-left: 0;padding-left: 0.4em;",
                ));
            } else if ('on' === $this->props['btn_on_hover']) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector'    => "%%order_class%% .dnxt-btn-icon:hover i",
                    'declaration' => "opacity: 1;visibility: visible;",
                ));
            }

            if ('on' === $this->props['btn_on_hover'] && 'left' === $this->props['btn_icon_placement']) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector'    => "%%order_class%% .dnxt-btn-icon:hover i",
                    'declaration' => "opacity: 1;visibility: visible;padding-right: 0.4em;margin-left: 0;",
                ));
            } else if ('on' === $this->props['btn_on_hover']) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector'    => "%%order_class%% .dnxt-btn-icon:hover i",
                    'declaration' => "opacity: 1;visibility: visible;",
                ));
            }

            // Button Icon Placement
            if ('off' === $this->props['btn_on_hover'] && 'left' === $this->props['btn_icon_placement']) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector'    => "%%order_class%% .dnxt-btn-icon.dnxt-btn-icon-on-hover i",
                    'declaration' => "opacity: 1;visibility: visible;margin-left: 0;padding-right: 0.4em;",
                ));
            } else if ('off' === $this->props['btn_on_hover'] && 'right' === $this->props['btn_icon_placement']) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector'    => "%%order_class%% .dnxt-btn-icon.dnxt-btn-icon-on-hover i",
                    'declaration' => "opacity: 1;visibility: visible;margin-left: 0;padding-left: 0.4em;",
                ));
            }
        }

        // Button Hover Background Color
        if ('' !== $this->props['dnxt_hover_bg_color']) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "%%order_class%% .{$this->props['dnxt_hover_bg']}:before",
                'declaration' => "background: {$this->props['dnxt_hover_bg_color']}!important;",
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "%%order_class%% .{$this->props['dnxt_hover_bg']}:hover:before",
                'declaration' => "transform: scaleX(1)!important;",
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "%%order_class%% .dnxt-hover-fade:hover",
                'declaration' => "background: {$this->props['dnxt_hover_bg_color']}!important;",
            ));
        }

        // Button Hover Background Color Radial Out
        if ('dnxt-hover-radial-out' === $this->props['dnxt_hover_bg']) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "%%order_class%% .dnxt-hover-radial-out",
                'declaration' => "background: {$this->props['dnxt_radial_out_bg_color']}!important;",
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "%%order_class%% .dnxt-hover-radial-out:before",
                'declaration' => "background: {$this->props['dnxt_hover_bg_color']}!important;",
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "%%order_class%% .dnxt-hover-radial-out:hover:before",
                'declaration' => "transform: scale(2)!important;",
            ));
        }

        // Button Hover Background Color Radial In
        if ('dnxt-hover-radial-in' === $this->props['dnxt_hover_bg']) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "%%order_class%% .dnxt-hover-radial-in",
                'declaration' => "background: {$this->props['dnxt_hover_bg_color']}!important;",
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "%%order_class%% .dnxt-hover-radial-in:before",
                'declaration' => "background: {$this->props['dnxt_radial_in_bg_color']}!important;",
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "%%order_class%% .dnxt-hover-radial-in:hover:before",
                'declaration' => "transform: scale(0)!important;",
            ));
        }

        // Button Hover Background Color Rectangle In
        if ('dnxt-hover-rectangle-in' === $this->props['dnxt_hover_bg']) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "%%order_class%% .dnxt-hover-rectangle-in",
                'declaration' => "background: {$this->props['dnxt_hover_bg_color']}!important;",
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "%%order_class%% .dnxt-hover-rectangle-in:before",
                'declaration' => "background: {$this->props['dnxt_rectangle_in_bg_color']}!important;",
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "%%order_class%% .dnxt-hover-rectangle-in:hover:before",
                'declaration' => "transform: scale(0)!important;",
            ));
        }

        // Button Hover Background Color Rectangle Out
        if ('dnxt-hover-rectangle-out' === $this->props['dnxt_hover_bg']) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "%%order_class%% .dnxt-hover-rectangle-out",
                'declaration' => "background: {$this->props['dnxt_rectangle_out_bg_color']}!important;",
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "%%order_class%% .dnxt-hover-rectangle-out:before",
                'declaration' => "background: {$this->props['dnxt_hover_bg_color']}!important;",
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "%%order_class%% .dnxt-hover-rectangle-out:hover:before",
                'declaration' => "transform: scale(1)!important;",
            ));
        }

        // Button Hover Background Color Shutter In
        if ('dnxt-hover-shutter-in-horizontal' === $this->props['dnxt_hover_bg']) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "%%order_class%% .dnxt-hover-shutter-in-horizontal",
                'declaration' => "background: {$this->props['dnxt_hover_bg_color']}!important;",
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "%%order_class%% .dnxt-hover-shutter-in-horizontal:before",
                'declaration' => "background: {$this->props['dnxt_shutter_in_bg_color']}!important;",
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "%%order_class%% .dnxt-hover-shutter-in-horizontal:hover:before",
                'declaration' => "transform: scaleX(0)!important;",
            ));
        }

        // Button Hover Background Color Shutter Out
        if ('dnxt-hover-shutter-out-horizontal' === $this->props['dnxt_hover_bg']) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "%%order_class%% .dnxt-hover-shutter-out-horizontal",
                'declaration' => "background: {$this->props['dnxt_shutter_out_bg_color']}!important;",
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "%%order_class%% .dnxt-hover-shutter-out-horizontal:before",
                'declaration' => "background: {$this->props['dnxt_hover_bg_color']}!important;",
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "%%order_class%% .dnxt-hover-shutter-out-horizontal:hover:before",
                'declaration' => "transform: scaleX(1)!important;",
            ));
        }

        // Button Hover Background Color Shutter In Vertical
        if ('dnxt-hover-shutter-in-vertical' === $this->props['dnxt_hover_bg']) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "%%order_class%% .dnxt-hover-shutter-in-vertical",
                'declaration' => "background: {$this->props['dnxt_hover_bg_color']}!important;",
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "%%order_class%% .dnxt-hover-shutter-in-vertical:before",
                'declaration' => "background: {$this->props['dnxt_shutter_in_v_bg_color']}!important;",
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "%%order_class%% .dnxt-hover-shutter-in-vertical:hover:before",
                'declaration' => "transform: scaleY(0)!important;",
            ));
        }

        // Button Hover Background Color Shutter Out Vertical
        if ('dnxt-hover-shutter-out-vertical' === $this->props['dnxt_hover_bg']) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "%%order_class%% .dnxt-hover-shutter-out-vertical",
                'declaration' => "background: {$this->props['dnxt_shutter_out_v_bg_color']}!important;",
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "%%order_class%% .dnxt-hover-shutter-out-vertical:before",
                'declaration' => "background: {$this->props['dnxt_hover_bg_color']}!important;",
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "%%order_class%% .dnxt-hover-shutter-out-vertical:hover:before",
                'declaration' => "transform: scaleY(1)!important;",
            ));
        }

        // Hover Trim Border Color
        if ('dnxt-hover-trim' === $this->props['dnxt_hover_border']) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "%%order_class%% .dnxt-hover-trim:before",
                'declaration' => "border: {$this->props['dnxt_trim_border_color']} solid 4px;",
            ));
        }

        // Hover Ripple In Border Color
        if ('dnxt-hover-ripple-out' === $this->props['dnxt_hover_border']) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "%%order_class%% .dnxt-hover-ripple-out:before",
                'declaration' => "border: {$this->props['dnxt_ripple_out_color']} solid 6px;",
            ));
        }

        // Hover Ripple Out Border Color
        if ('dnxt-hover-ripple-in' === $this->props['dnxt_hover_border']) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "%%order_class%% .dnxt-hover-ripple-in:before",
                'declaration' => "border: {$this->props['dnxt_ripple_in_color']} solid 6px;",
            ));
        }

        // Hover Underline From Left Color
        if ('dnxt-hover-underline-from-left' === $this->props['dnxt_hover_border']) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "%%order_class%% .dnxt-hover-underline-from-left:before",
                'declaration' => "background: {$this->props['dnxt_underline_from_left_color']};",
            ));
        }

        // Hover Underline From Center Color
        if ('dnxt-hover-underline-from-center' === $this->props['dnxt_hover_border']) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "%%order_class%% .dnxt-hover-underline-from-center:before",
                'declaration' => "background: {$this->props['dnxt_underline_from_center_color']};",
            ));
        }

        // Hover Underline From Right Color
        if ('dnxt-hover-underline-from-right' === $this->props['dnxt_hover_border']) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "%%order_class%% .dnxt-hover-underline-from-right:before",
                'declaration' => "background: {$this->props['dnxt_underline_from_right_color']};",
            ));
        }

        // Hover Overline From Left Color
        if ('dnxt-hover-overline-from-left' === $this->props['dnxt_hover_border']) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "%%order_class%% .dnxt-hover-overline-from-left:before",
                'declaration' => "background: {$this->props['dnxt_overline_left_color']};",
            ));
        }

        // Hover Overline From Center Color
        if ('dnxt-hover-overline-from-center' === $this->props['dnxt_hover_border']) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "%%order_class%% .dnxt-hover-overline-from-center:before",
                'declaration' => "background: {$this->props['dnxt_overline_center_color']};",
            ));
        }

        // Hover Overline From Center Color
        if ('dnxt-hover-overline-from-right' === $this->props['dnxt_hover_border']) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "%%order_class%% .dnxt-hover-overline-from-right:before",
                'declaration' => "background: {$this->props['dnxt_overline_right_color']};",
            ));
        }

        // Hover Reveal Color
        if ('dnxt-hover-reveal' === $this->props['dnxt_hover_border']) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "%%order_class%% .dnxt-hover-reveal:before",
                'declaration' => "border-color: {$this->props['dnxt_reveal_color']};",
            ));
        }

        // Hover Underline Reveal Color
        if ('dnxt-hover-underline-reveal' === $this->props['dnxt_hover_border']) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "%%order_class%% .dnxt-hover-underline-reveal:before",
                'declaration' => "background: {$this->props['dnxt_underline_reveal_color']};",
            ));
        }

        // Hover Underline overline Color
        if ('dnxt-hover-overline-reveal' === $this->props['dnxt_hover_border']) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "%%order_class%% .dnxt-hover-overline-reveal:before",
                'declaration' => "background: {$this->props['dnxt_overline_reveal_color']};",
            ));
        }
    }
    public function multi_view_filter_value( $raw_value, $args, $multi_view ) {
		$name = isset( $args['name'] ) ? $args['name'] : '';
		$mode = isset( $args['mode'] ) ? $args['mode'] : '';

		if ( $raw_value && 'btn_icon' === $name ) {
			return et_pb_get_extended_font_icon_value( $raw_value, true );
		}
		return $raw_value;
	}
}

new Next_Button;
