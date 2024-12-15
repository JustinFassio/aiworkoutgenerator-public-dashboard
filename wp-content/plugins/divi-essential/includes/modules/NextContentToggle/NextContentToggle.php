<?php
include_once(DIVI_ESSENTIAL_PATH.'/includes/modules/base/Common.php');

class Next_Content_Toggle extends ET_Builder_Module {

	public $slug       = 'dnxte_content_toggle';
	public $vb_support = 'on';

	protected $module_credits = array(
		'module_uri' => 'https://www.diviessential.com/divi-content-toggle',
		'author'     => 'Divi Next',
		'author_uri' => 'www.divinext.com',
	);

	public function init() {
		$this->name             = esc_html__( 'Next Content Toggle', 'et_builder' );
		$this->icon_path        = plugin_dir_path(__FILE__) . 'icon.svg';
		$this->folder_name      = 'et_pb_divi_essential';
		$this->main_css_element = '%%order_class%%';

		$this->settings_modal_toggles = array(
            'general' => array(
                'toggles' => array(
                    'dnxte_content_left' => array(
                        'title' => esc_html__('Content Left', 'et_builder'),
                    ),
                    'dnxte_content_right' => array(
                        'title' => esc_html__('Content Right', 'et_builder'),
                    ),
                ),
            ),
            'advanced' => array(
                'toggles' => array(
                    'dnxte_switcher' => array(
                        'title' => esc_html__('Switch', 'et_builder'),
                    ),
                    'heading_left' => array(
                        'title' => esc_html__('Heading Left', 'et_builder'),
                    ),
                    'heading_right' => array(
                        'title' => esc_html__('Heading Right', 'et_builder'),
                    ),
					'dnxte_content_left' => array(
                        'title' => esc_html__('Content Left', 'et_builder'),
                    ),
                    'dnxte_content_right' => array(
                        'title' => esc_html__('Content Right', 'et_builder'),
                    ),

                ),
            ),
            'custom_css' => array(
                'toggles' => array(),
            ),
        );

		$this->advanced_fields = array(
			'fonts'		=>  array(
				'heding_left'   => array(
					'toggle_slug'   => 'heading_left',
					'tab_slug'		=> 'advanced',
					'css'            => array(
						'main'       => " %%order_class%% .dnxte-toggle-head-one label",
					),
					
					'hide_text_align' => true,
					'font_size' => array(
						'default' => '18px',
					),
					'font_color' => array(
						'default' => '#FFFFFF',
					),
					'line_height' => array(
						'default' => '1.3em',
					),
				),
				'heding_right'   => array(
					'toggle_slug'   => 'heading_right',
					'tab_slug'		=> 'advanced',
					'css'            => array(
						'main' => " %%order_class%% .dnxte-toggle-head-two label",
					),
					'hide_text_align' => true,
					'font_size' => array(
						'default' => '18px',
					),
					'font_color' => array(
						'default' => '#FFFFFF',
					),
					'line_height' => array(
						'default' => '1.3em',
					),
				),
				'content_left'   => array(
					'toggle_slug'   => 'dnxte_content_left',
					'sub_toggle'   => 'sub_toggle_font',
					'tab_slug'		=> 'advanced',
					'css'            => array(
						'main' => " %%order_class%% .dnxte-content-toggle-front",
					),
					'font_size' => array(
						'default' => '18px',
					),
					'font_color' => array(
						'default' => '#FFFFFF',
					),
					'line_height' => array(
						'default' => '1.3em',
					),
				),
				'content_right'   => array(
					'toggle_slug'   => 'dnxte_content_right',
					'sub_toggle'   => 'sub_toggle_font',
					'tab_slug'		=> 'advanced',
					'css'            => array(
						'main' => " %%order_class%% .dnxte-content-toggle-back",
					),
					'font_size' => array(
						'default' => '18px',
					),
					'font_color' => array(
						'default' => '#FFFFFF',
					),
					'line_height' => array(
						'default' => '1.3em',
					),
				),
			),
			'background'            => array(
				'settings' => array(
					'color' => 'alpha',
				),
			),
			'borders'               => array(
				'default' => array(),
				'switcher_borders'     	=> array(
					'tab_slug'     	=> 'advanced',
					'toggle_slug'  	=> 'dnxte_switcher',
					'css'          => array(
						'main'     => array(
							'border_radii'        => "%%order_class%% .dnxte-switch-inner, %%order_class%% .dnxte-switch-inner::before",
							'border_radii_hover'  => '%%order_class%%:hover .dnxte-switch-inner, %%order_class%% .dnxte-switch-inner::before',
							'border_styles'       => "%%order_class%% .dnxte-switch-inner, %%order_class%% .dnxte-switch-inner::before",
							'border_styles_hover' => '%%order_class%%:hover .dnxte-switch-inner, %%order_class%% .dnxte-switch-inner::before',
						),
					),
					'defaults'        => array(
						'border_radii'  => 'on|20px|20px|20px|20px',
						'border_styles' => array(
							'width' => '0px',
							'color' => '#2857b6',
							'style' => 'solid',
						),
					),
				),
				'content_left_borders'     	=> array(
					'tab_slug'     	=> 'advanced',
					'toggle_slug'  	=> 'dnxte_content_left',
					'css'          => array(
						'main'     => array(
							'border_radii'        => "%%order_class%% .dnxte-content-toggle-front",
							'border_radii_hover'  => '%%order_class%%:hover .dnxte-content-toggle-front',
							'border_styles'       => "%%order_class%% .dnxte-content-toggle-front",
							'border_styles_hover' => '%%order_class%%:hover .dnxte-content-toggle-front',
						),
					),
					'defaults'        => array(
						'border_radii'  => 'on|0px|0px|0px|0px',
						'border_styles' => array(
							'width' => '0px',
							'color' => '#2857b6',
							'style' => 'solid',
						),
					),
				),
				'content_right_borders'     	=> array(
					'tab_slug'     	=> 'advanced',
					'toggle_slug'  	=> 'dnxte_content_right',
					'css'          => array(
						'main'     => array(
							'border_radii'        => "%%order_class%% .dnxte-content-toggle-back",
							'border_radii_hover'  => '%%order_class%%:hover .dnxte-content-toggle-back',
							'border_styles'       => "%%order_class%% .dnxte-content-toggle-back",
							'border_styles_hover' => '%%order_class%%:hover .dnxte-content-toggle-back',
						),
					),
					'defaults'        => array(
						'border_radii'  => 'on|0px|0px|0px|0px',
						'border_styles' => array(
							'width' => '0px',
							'color' => '#2857b6',
							'style' => 'solid',
						),
					),
				),
			),
			'box_shadow'            => array(
				'default' => array(),
				'content_left_shadow'   => array(
					'label'               => esc_html__( 'Content Left Box Shadow', 'dnxte-divi-essential' ),
					'toggle_slug'         => 'dnxte_content_left',
					'tab_slug'            => 'advanced',
					'option_category'     => 'layout',
					'css'                 => array(
						'main'        => '%%order_class%% .dnxte-content-toggle-front',
						'hover'       => '%%order_class%%:hover .dnxte-content-toggle-front',
						'overlay'     => 'inset',
					),
					'default_on_fronts'  => array(
						'color'    => '',
						'position' => '',
					),
				),
				'content_right_shadow'   => array(
					'label'               => esc_html__( 'Content Right Box Shadow', 'dnxte-divi-essential' ),
					'toggle_slug'         => 'dnxte_content_right',
					'tab_slug'            => 'advanced',
					'option_category'     => 'layout',
					'css'                 => array(
						'main'        => '%%order_class%% .dnxte-content-toggle-back',
						'hover'       => '%%order_class%%:hover .dnxte-content-toggle-back',
						'overlay'     => 'inset',
					),
					'default_on_fronts'  => array(
						'color'    => '',
						'position' => '',
					),
				),
			),
			'margin_padding' => array(
				'css' => array(
					'important' => 'all',
				),
			),			
			'text'                  => array(
				'use_background_layout' => true,
				'css'              => array(
					'text_shadow' => "{$this->main_css_element} .et_pb_blurb_container",
				),
				'options' => array(
					'background_layout' => array(
						'default_on_front' => 'light',
						'hover' => 'tabs',
					),
					'text_orientation' => array(
						'default_on_front' => 'left',
					),
				),
			),
			'filters'               => array(
				'child_filters_target' => array(
					'tab_slug' => 'advanced',
					'toggle_slug' => 'icon_settings',
					'depends_show_if' => 'off',
					'css'                 => array(
						'main'  => '%%order_class%% .et_pb_main_blurb_image',
						'hover' => '%%order_class%%:hover .et_pb_main_blurb_image',
					),
				),
			),
			'icon_settings'         => array(
				'css' => array(
					'main' => '%%order_class%% .et_pb_main_blurb_image',
				),
			),
			'button'                => false,
			'text'                	=> false,
		);

		$this->custom_css_fields = array(
			'header_left'   => array(
                'label' => esc_html__('Header Left', 'dnxte-divi-essential'),
                'selector' => '%%order_class%% .dnxte-toggle-head-one label',
            ),
			'header_right'   => array(
                'label' => esc_html__('Header Right', 'dnxte-divi-essential'),
                'selector' => '%%order_class%% .dnxte-toggle-head-two label',
            ),
			'switch_left'   => array(
                'label' => esc_html__('Switch Left', 'dnxte-divi-essential'),
                'selector' => '%%order_class%% .dnxte-content-toggle .dnxte-switch-inner',
            ),
			'switch_right'   => array(
                'label' => esc_html__('Switch Right', 'dnxte-divi-essential'),
                'selector' => '%%order_class%% .dnxte-content-toggle .dnxte-toggle-switch:checked+.dnxte-switch-inner',
            ),
			'switch_round'   => array(
                'label' => esc_html__('Switch Round', 'dnxte-divi-essential'),
                'selector' => '%%order_class%% .dnxte-content-toggle .dnxte-switch-inner::before',
            ),
			'content_left'   => array(
                'label' => esc_html__('Content Left', 'dnxte-divi-essential'),
                'selector' => '%%order_class%% .dnxte-content-toggle-front',
            ),
			'content_right'   => array(
                'label' => esc_html__('Content Right', 'dnxte-divi-essential'),
                'selector' => '%%order_class%% .dnxte-content-toggle-back',
            ),
		);

	}

	public function get_fields() {
		$fields = array(
			'dnxte_heading_left' => array(
                'label'           => esc_html__('Heading Left', 'et_builder'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'description'     => esc_html__('Input the name of the person', 'et_builder'),
                'toggle_slug'     => 'dnxte_content_left',
                'dynamic_content' => 'text',
			),
			'content_type_left'   => array(
				'label'            => esc_html__( 'Content Type', 'et_builder' ),
				'type'             => 'select',
				'default'          => 'content',
				'options'          => array(
					'content' => esc_html__( 'Custom Content', 'et_builder' ),
					'library' => esc_html__( 'Library', 'et_builder' ),
				),
				'toggle_slug'      => 'dnxte_content_left',
				'computed_affects' => array(
					'__libraryLeft',
				),
			),
			'library_id_left'     => array(
				'label'            => __( 'Select Library', 'et_builder' ),
				'type'             => 'select',
				'options'          => Common::get_divi_library_options(),
				'toggle_slug'      => 'dnxte_content_left',
				'computed_affects' => array(
					'__libraryLeft',
				),
				'show_if'          => array(
					'content_type_left' => 'library',
				),
			),
			'content_toggle_warning'=> array(
				'type'       => 'warning',
				'value'      => true,
				'display_if' => true,
				'show_if'          => array(
					'content_type_left' => 'library',
				),
				'message'    => esc_html__('In this option, the layout style will not appear in the Visual Builder; however, once saved and applied to the frontend, it will be visible', 'et_builder'),
				'toggle_slug'      => 'dnxte_content_left',
			),
			'custom_content_left' => array(
				'label'           => esc_html__( 'Content', 'et_builder' ),
				'type'            => 'tiny_mce',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Content entered here will appear inside the module.', 'et_builder' ),
				'toggle_slug'     => 'dnxte_content_left',
				'dynamic_content' => 'text',
				'show_if'         => array(
					'content_type_left' => 'content',
				),
			),
			'dnxte_heading_right' => array(
                'label'           => esc_html__('Heading Right', 'et_builder'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'description'     => esc_html__('Input the name of the person', 'et_builder'),
                'toggle_slug'     => 'dnxte_content_right',
                'dynamic_content' => 'text',
			),
			'content_type_right'   => array(
				'label'            => esc_html__( 'Content Type', 'et_builder' ),
				'type'             => 'select',
				'default'          => 'content',
				'options'          => array(
					'content' => esc_html__( 'Custom Content', 'et_builder' ),
					'library' => esc_html__( 'Library', 'et_builder' ),
				),
				'toggle_slug'      => 'dnxte_content_right',
				'computed_affects' => array(
					'__libraryRight',
				),
			),
			'library_id_right'     => array(
				'label'            => __( 'Select Library', 'et_builder' ),
				'type'             => 'select',
				'options'          => Common::get_divi_library_options(),
				'toggle_slug'      => 'dnxte_content_right',
				'computed_affects' => array(
					'__libraryRight',
				),
				'show_if'          => array(
					'content_type_right' => 'library',
				),
			),
			'content_toggle_warning_right'=> array(
				'type'       => 'warning',
				'value'      => true,
				'display_if' => true,
				'show_if'          => array(
					'content_type_right' => 'library',
				),
				'message'    => esc_html__('In this option, the layout style will not appear in the Visual Builder; however, once saved and applied to the frontend, it will be visible', 'et_builder'),
				'toggle_slug'      => 'dnxte_content_right',
			),
			'custom_content_right' => array(
				'label'           => esc_html__( 'Content', 'et_builder' ),
				'type'            => 'tiny_mce',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Content entered here will appear inside the module.', 'et_builder' ),
				'toggle_slug'     => 'dnxte_content_right',
				'dynamic_content' => 'text',
				'show_if'         => array(
					'content_type_right' => 'content',
				),
			),
			'__libraryLeft'      => array(
				'type'                => 'computed',
				'computed_callback'   => array( 'Next_Content_Toggle', 'get_content_left' ),
				'computed_depends_on' => array(
					'library_id_left',
					'content_type_left',
				),
			),
			'__libraryRight'      => array(
				'type'                => 'computed',
				'computed_callback'   => array( 'Next_Content_Toggle', 'get_content_right' ),
				'computed_depends_on' => array(
					'library_id_right',
					'content_type_right',
				),
			),
		);
		$content_space = array(
			'content_padding_left'     => array(
				'label'          => esc_html__( 'Content Padding Left', 'et_builder' ),
				'type'           => 'custom_padding',
				'default'        => '0px|0px|0px|0px',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'margin_padding',
				'mobile_options' => true,
			),
			'content_margin_left'=> array(
				'label'          => esc_html__( 'Content Margin Left', 'et_builder' ),
				'type'           => 'custom_margin',
				'default'        => '25px|0px|0px|0px',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'margin_padding',
				'mobile_options' => true,
			),
			'content_padding_right'     => array(
				'label'          => __( 'Content Padding Right', 'et_builder' ),
				'type'           => 'custom_padding',
				'default'        => '0px|0px|0px|0px',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'margin_padding',
				'mobile_options' => true,
			),
			'content_margin_right'     => array(
				'label'          => __( 'Content Margin Right', 'et_builder' ),
				'type'           => 'custom_margin',
				'default'        => '25px|0px|0px|0px',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'margin_padding',
				'mobile_options' => true,
			),
		);
		$switch_fields = array(
			'switcher_size'      => array(
				'label'          => esc_html__( 'Switcher Size', 'et_builder' ),
				'type'           => 'range',
				'default'        => '15px',
				'mobile_options' => true,
				'fixed_unit'     => 'px',
				'range_settings' => array(
					'min'  => 0,
					'step' => 1,
					'max'  => 200,
				),
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'dnxte_switcher',
				'hover'           => 'tabs',
			),
			'switch_alignment'=> array(
				'label'            => esc_html__( 'Switch Alignment', 'et_builder' ),
				'description'      => esc_html__( 'Align your switch to the left, right or center of the module.', 'et_builder' ),
				'type'             => 'align',
				'option_category'  => 'configuration',
				'options'          => et_builder_get_text_orientation_options( array('justified') ),
				'tab_slug'         => 'advanced',
				'toggle_slug'      => 'dnxte_switcher',
				'mobile_options'   => true,
				'description'      => esc_html__( 'Here you can define the alignment of switch', 'et_builder' ),
			),
		);


		$hover_arr = array(
            'hover'     => 'tabs'
        );

        // category bg slug = dnxte_blogslider_category_bg_color
		// switch size slug = switch_primary_bg_color
        $switch_primary_bg = Common::background_fields($this, "switch_primary_", "Switch Left Background", "dnxte_switcher", "general", $hover_arr);
		// switch inner bg slug = switch_inner_bg_color
        $switch_inner_bg = Common::background_fields($this, "switch_inner_", "Switch Right Background", "dnxte_switcher", "general", $hover_arr);
		// switch round btn bg slug = switch_round_btn_bg_color
        $switch_round_btn_bg = Common::background_fields($this, "switch_round_btn_", "Switch Round Button Background", "dnxte_switcher", "general", $hover_arr);
		// Content Left bg slug = content_left_bg_color
        $content_left_bg = Common::background_fields($this, "content_left_", "Content Left Background", "dnxte_content_left", "general", $hover_arr);
		// Content Right bg slug = content_right_bg_color
        $content_right_bg = Common::background_fields($this, "content_right_", "Content Right Background", "dnxte_content_right", "general", $hover_arr);

		return array_merge( 
			$fields, 
			$switch_fields,
			$content_space,
			$switch_primary_bg,
			$switch_inner_bg,
			$switch_round_btn_bg,
			$content_left_bg,
			$content_right_bg
		);
	}


	public static function get_content_left( $args = array() ) {

		$defaults = array();
		$args     = wp_parse_args( $args, $defaults );

		if ( empty( $args['library_id_left'] ) ) {
			return;
		}

		ob_start();

		ET_Builder_Element::clean_internal_modules_styles();

		echo do_shortcode(
			sprintf(
				'[et_pb_section global_module="%1$s" template_type="section" fullwidth="on"][/et_pb_section]',
				$args['library_id_left']
			)
		);

		$internal_style = ET_Builder_Element::get_style();
		ET_Builder_Element::clean_internal_modules_styles( false );

		if ( $internal_style ) {
			$modules_style = sprintf(
				'<style id="dnxte_content_toggle_styles-%2$s" type="text/css" class="dnxte_content_toggle_styles-%2$s">
					%1$s
				</style>',
				$internal_style,
				$args['library_id_left']
			);
		}

		if ( function_exists( 'et_core_is_fb_enabled' ) && et_core_is_fb_enabled() ) {
			echo et_core_esc_previously( $modules_style );
		}

		$render_shortcode = ob_get_clean();

		return $render_shortcode;
	}

	public static function get_content_right( $args = array() ) {

		$defaults = array();
		$args     = wp_parse_args( $args, $defaults );

		if ( empty( $args['library_id_right'] ) ) {
			return;
		}

		ob_start();

		ET_Builder_Element::clean_internal_modules_styles();

		echo do_shortcode(
			sprintf(
				'[et_pb_section global_module="%1$s" template_type="section" fullwidth="on"][/et_pb_section]',
				$args['library_id_right']
			)
		);

		$internal_style = ET_Builder_Element::get_style();
		ET_Builder_Element::clean_internal_modules_styles( false );

		if ( $internal_style ) {
			$modules_style = sprintf(
				'<style id="dnxte_content_toggle_styles-%2$s" type="text/css" class="dnxte_content_toggle_styles-%2$s">
					%1$s
				</style>',
				$internal_style,
				$args['library_id_right']
			);
		}

		if ( function_exists( 'et_core_is_fb_enabled' ) && et_core_is_fb_enabled() ) {
			echo et_core_esc_previously( $modules_style );
		}

		$render_shortcode = ob_get_clean();

		return $render_shortcode;
	}

	protected function render_content_left() {
		$content_type_left     = $this->props['content_type_left'];
		$library_id_left       = $this->props['library_id_left'];
		$custom_content_left   = $this->props['custom_content_left'];
		$args                  = array( 'library_id_left' => $library_id_left );

		if( 'content' === $content_type_left ){
			return sprintf(
				'<div class="dnxte-content-toggle-front">
					%1$s
				</div>',
				$custom_content_left
			);
		} else {
			return sprintf(
				'<div class="dnxte-content-toggle-front">
					%1$s
				</div>',
				$this->get_content_left( $args )
			);
		}
	}

	protected function render_content_right() {
		$content_type_right     = $this->props['content_type_right'];
		$library_id_right       = $this->props['library_id_right'];
		$custom_content_right   = $this->props['custom_content_right'];
		$args                  	= array( 'library_id_right' => $library_id_right );

		if( 'content' === $content_type_right){
			return sprintf(
				'<div class="dnxte-content-toggle-back">
					%1$s
				</div>',
				$custom_content_right
			);
		} else {
			return sprintf(
				'<div class="dnxte-content-toggle-back">
					%1$s
				</div>',
				$this->get_content_right( $args )
			);
		}
	}

	public function get_transition_fields_css_props() {
		$fields = parent::get_transition_fields_css_props();

		$fields['header_background_color'] = array( 'background-color' => '%%order_class%% .et_pb_pricing_heading' );

		return $fields;
	}

	public function render( $attrs, $content, $render_slug ) {
		wp_enqueue_script( 'dnext_scripts-public' );

		$dnxte_heading_left		= $this->props['dnxte_heading_left'];
		$dnxte_heading_right	= $this->props['dnxte_heading_right'];
		$this->apply_css($render_slug);
		//Switcher Alingment
		$switch_alignment_classes = Common::get_alignment("switch_alignment", $this, 'dnxte');

		$checkbox_id = ET_Builder_Element::get_module_order_class( $render_slug );

		// print_r($this);

		$_switch = sprintf(
			'<div class="dnxte-toggle-btn">
				<label class="dnxte-switch-label" for="dnxte-input-%1$s">
					<input id="dnxte-input-%1$s" class="dnxte-input dnxte-toggle-switch" type="checkbox">
					<span class="dnxte-switch-inner"></span>
				</label>
			</div>',
			$checkbox_id
		);

		return sprintf( 
			'<div class="dnxte-content-toggle">
				<div class="dnxte-content-toggle-header">
					<div class="dnxte-toggle %6$s">
						<div class="dnxte-toggle-left">
							<div class="dnxte-toggle-head-one">
								<label for="dnxte-input-%7$s">%4$s</label>
							</div>
						</div>
						%1$s
						<div class="dnxte-toggle-right">
							<div class="dnxte-toggle-head-two">
								<label for="dnxte-input-%7$s">%5$s</label>
							</div>
						</div>
					</div>
				</div>
				<div class="dnxte-content-toggle-body">
					%2$s
					%3$s
				</div>
			</div>', 
			$_switch,
			$this->render_content_left(),
			$this->render_content_right(),
			$dnxte_heading_left,
			$dnxte_heading_right,
			$switch_alignment_classes,
			$checkbox_id
		);
	}

	public function apply_css($render_slug) {

        /**
         * Custom Padding Margin Output
         *
        */
        Common::dnxt_set_style($render_slug, $this->props, "content_padding_left", "%%order_class%% .dnxte-content-toggle-front", "padding");
        Common::dnxt_set_style($render_slug, $this->props, "content_margin_left", "%%order_class%% .dnxte-content-toggle-front", "margin");
        
        Common::dnxt_set_style($render_slug, $this->props, "content_padding_right", "%%order_class%% .dnxte-content-toggle-back", "padding");
        Common::dnxt_set_style($render_slug, $this->props, "content_margin_right", "%%order_class%% .dnxte-content-toggle-back", "margin");
        

		// Other Styles
		$this->generate_styles(
			array(
				'base_attr_name'                  => 'switcher_size',
				'selector'                        => '%%order_class%% .dnxte-content-toggle .dnxte-toggle-btn',
				'hover_pseudo_selector_location'  => 'suffix',
				'sticky_pseudo_selector_location' => 'prefix',
				'css_property'                    => 'font-size',
				'render_slug'                     => $render_slug,
				'type'                            => 'range',	
			)
		);

		// Switcher Primary Background color
		$switch_primary_bg_color = array(
			'color_slug' => "switch_primary_bg_color"
		);
		$use_color_gradient = $this->props['switch_primary_bg_use_color_gradient'];
		$gradient = array(
			"gradient_type"           => 'switch_primary_bg_color_gradient_type',
			"gradient_direction"      => 'switch_primary_bg_color_gradient_direction',
			"radial"                  => 'switch_primary_bg_color_gradient_direction_radial',
			"gradient_start"          => 'switch_primary_bg_color_gradient_start',
			"gradient_end"            => 'switch_primary_bg_color_gradient_end',
			"gradient_start_position" => 'switch_primary_bg_color_gradient_start_position',
			"gradient_end_position"   => 'switch_primary_bg_color_gradient_end_position',
			"gradient_overlays_image" => 'switch_primary_bg_color_gradient_overlays_image',
		);

		$css_property = array(
			"desktop" => "%%order_class%% .dnxte-content-toggle .dnxte-switch-inner",
			"hover" => "%%order_class%% .dnxte-content-toggle .dnxte-switch-inner:hover"
		);
		Common::apply_bg_css($render_slug, $this, $switch_primary_bg_color, $use_color_gradient, $gradient, $css_property);
		// Switcher Background color End

		// Switcher Inner Background color
		$switch_inner_bg_color = array(
			'color_slug' => "switch_inner_bg_color"
		);
		$use_color_gradient = $this->props['switch_inner_bg_use_color_gradient'];
		$gradient = array(
			"gradient_type"           => 'switch_inner_bg_color_gradient_type',
			"gradient_direction"      => 'switch_inner_bg_color_gradient_direction',
			"radial"                  => 'switch_inner_bg_color_gradient_direction_radial',
			"gradient_start"          => 'switch_inner_bg_color_gradient_start',
			"gradient_end"            => 'switch_inner_bg_color_gradient_end',
			"gradient_start_position" => 'switch_inner_bg_color_gradient_start_position',
			"gradient_end_position"   => 'switch_inner_bg_color_gradient_end_position',
			"gradient_overlays_image" => 'switch_inner_bg_color_gradient_overlays_image',
		);

		$css_property = array(
			"desktop" => "%%order_class%% .dnxte-content-toggle .dnxte-toggle-switch:checked+.dnxte-switch-inner",
			"hover" => "%%order_class%% .dnxte-content-toggle .dnxte-toggle-switch:checked+.dnxte-switch-inner:hover"
		);
		Common::apply_bg_css($render_slug, $this, $switch_inner_bg_color, $use_color_gradient, $gradient, $css_property);
		// Switcher Inner Background color End

		// Switcher Round Button Background color
		$switch_round_btn_bg_color = array(
			'color_slug' => "switch_round_btn_bg_color"
		);
		$use_color_gradient = $this->props['switch_round_btn_bg_use_color_gradient'];
		$gradient = array(
			"gradient_type"           => 'switch_round_btn_bg_color_gradient_type',
			"gradient_direction"      => 'switch_round_btn_bg_color_gradient_direction',
			"radial"                  => 'switch_round_btn_bg_color_gradient_direction_radial',
			"gradient_start"          => 'switch_round_btn_bg_color_gradient_start',
			"gradient_end"            => 'switch_round_btn_bg_color_gradient_end',
			"gradient_start_position" => 'switch_round_btn_bg_color_gradient_start_position',
			"gradient_end_position"   => 'switch_round_btn_bg_color_gradient_end_position',
			"gradient_overlays_image" => 'switch_round_btn_bg_color_gradient_overlays_image',
		);

		$css_property = array(
			"desktop" => "%%order_class%% .dnxte-content-toggle .dnxte-switch-inner::before",
			"hover" => "%%order_class%% .dnxte-content-toggle .dnxte-switch-inner::before:hover"
		);
		Common::apply_bg_css($render_slug, $this, $switch_round_btn_bg_color, $use_color_gradient, $gradient, $css_property);
		// Switcher Round Button Background color End

		// Content Left Background color
		$content_left_bg_color = array(
			'color_slug' => "content_left_bg_color"
		);
		$use_color_gradient = $this->props['content_left_bg_use_color_gradient'];
		$gradient = array(
			"gradient_type"           => 'content_left_bg_color_gradient_type',
			"gradient_direction"      => 'content_left_bg_color_gradient_direction',
			"radial"                  => 'content_left_bg_color_gradient_direction_radial',
			"gradient_start"          => 'content_left_bg_color_gradient_start',
			"gradient_end"            => 'content_left_bg_color_gradient_end',
			"gradient_start_position" => 'content_left_bg_color_gradient_start_position',
			"gradient_end_position"   => 'content_left_bg_color_gradient_end_position',
			"gradient_overlays_image" => 'content_left_bg_color_gradient_overlays_image',
		);

		$css_property = array(
			"desktop" => "%%order_class%% .dnxte-content-toggle-front, %%order_class%% .dnxte-content-toggle-front > div",
			"hover" => "%%order_class%% .dnxte-content-toggle-front:hover, %%order_class%% .dnxte-content-toggle-front:hover > div"
		);
		Common::apply_bg_css($render_slug, $this, $content_left_bg_color, $use_color_gradient, $gradient, $css_property);
		// Content Left Background color End

		// Content Right Background color
		$content_right_bg_color = array(
			'color_slug' => "content_right_bg_color"
		);
		$use_color_gradient = $this->props['content_right_bg_use_color_gradient'];
		$gradient = array(
			"gradient_type"           => 'content_right_bg_color_gradient_type',
			"gradient_direction"      => 'content_right_bg_color_gradient_direction',
			"radial"                  => 'content_right_bg_color_gradient_direction_radial',
			"gradient_start"          => 'content_right_bg_color_gradient_start',
			"gradient_end"            => 'content_right_bg_color_gradient_end',
			"gradient_start_position" => 'content_right_bg_color_gradient_start_position',
			"gradient_end_position"   => 'content_right_bg_color_gradient_end_position',
			"gradient_overlays_image" => 'content_right_bg_color_gradient_overlays_image',
		);

		$css_property = array(
			"desktop" => "%%order_class%% .dnxte-content-toggle-back, %%order_class%% .dnxte-content-toggle-back > div",
			"hover" => "%%order_class%% .dnxte-content-toggle-back:hover, %%order_class%% .dnxte-content-toggle-back:hover > div"
		);
		Common::apply_bg_css($render_slug, $this, $content_right_bg_color, $use_color_gradient, $gradient, $css_property);
		// Content Right Background color End
	}
}

new Next_Content_Toggle;