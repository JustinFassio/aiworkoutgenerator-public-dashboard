<?php

class Next_Team_Social_Reveal_Child extends ET_Builder_Module {
	public $slug       		= 'dnxte_team_social_reveal_child';
	public $vb_support 		= 'on';
	public $type 	   		= 'child';
	public $child_title_var = 'content';

	protected $module_credits = array(
		'module_uri' => 'https://www.diviessential.com/divi-team-social-reveal/',
		'author'     => 'Divi Next',
		'author_uri' => 'www.divinext.com',
	);

	public function init() {
		$this->name 	= esc_html__( 'Social Network', 'et_builder' );

		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Network', 'et_builder' ),
					'social_network_icon'  => esc_html__('Social Icon', 'et_builder'),
					'link'         => esc_html__( 'Link', 'et_builder' ),
					'link_window'  => esc_html__( 'Link Window', 'et_builder' ),
				),
			),
			'advanced' => array(
				'toggles' => array(
					'icon' => esc_html__( 'Icon', 'et_builder' ),
				),
			),
		);

		$this->advanced_setting_title_text = esc_html__( 'New Social Network', 'et_builder' );
		$this->settings_text               = esc_html__( 'Social Network Settings', 'et_builder' );

		$this->custom_css_fields = array(
			'social_icon' => array(
				'label'    => esc_html__( 'Social Icon', 'et_builder' ),
				'selector' => 'li.dnxte-teamsorev-sn a span',
			),
		);

		$this->advanced_fields = array(
			'background'            => array(
				'css' => array(
					'main'      => '%%order_class%% .dnxte-teamsorev-sn a span::before',
					'important' => 'all',
				),
			),
			'borders'               => array(
				'default' => array(
					'css'      => array(
						'main' => array(
							'border_radii'  => "%%order_class%% li.dnxte-teamsorev-sn a span",
							'border_styles' => "%%order_class%% li.dnxte-teamsorev-sn a span",
						),
					),
					'defaults' => array(
						'border_radii' => 'on|3px|3px|3px|3px',
						'border_styles' => array(
							'width' => '0px',
							'color' => '#333333',
							'style' => 'solid',
						),
					),
				),
			),
			'box_shadow'            => array(
				'default' => array(
					'css' => array(
						'main'      => '%%order_class%% .dnxte-teamsorev-sn',
						'important' => true,
					),
				),
			),
			'margin_padding' => array(
				'css' => array(
					'padding' => 'li%%order_class%% .dnxte-teamsorev-sn',
					'main'    => '%%order_class%% .dnxte-teamsorev-sn',
					'important' => array( 'custom_margin' ), // needed to overwrite last module margin-bottom styling
				),
			),
			'fonts'                 => false,
			'text'                  => false,
			'max_width'             => false,
			'height'                => false,
			'link_options'          => false,
		);
	}

	public function get_fields() {
		$fields = array(
			'dnext_social_network' => array(
				'label'           => esc_html__( 'Social Network', 'et_builder' ),
				'type'            => 'select',
				'option_category' => 'basic_option',
				'description' => esc_html__( 'If you need more social icon Select Other Network', 'et_builder' ),
				'toggle_slug' => 'main_content',
				'options' 	=> array(
					'facebook'    => esc_html__( 'Facebook', 'et_builder' ),
					'twitter'     => esc_html__( 'Twitter', 'et_builder' ),
					'pinterest'   => esc_html__( 'Pinterest', 'et_builder' ),
					'linkedin'    => esc_html__( 'Linkedin', 'et_builder' ),
					'tumblr'      => esc_html__( 'tumblr', 'et_builder' ),
					'instagram'   => esc_html__( 'Instagram', 'et_builder' ),
					'skype'       => esc_html__( 'skype', 'et_builder' ),
					'flikr'       => esc_html__( 'Flikr', 'et_builder' ),
					'dribbble'    => esc_html__( 'dribbble', 'et_builder' ),
					'youtube'     => esc_html__( 'Youtube', 'et_builder' ),
					'vimeo'       => esc_html__( 'Vimeo', 'et_builder' ),
					'social-items'=> esc_html__( 'Social Item', 'et_builder' ),
				),
				'default'             => 'facebook',
			),
			'dnext_social_icon' 	  => array(
				'label'               => esc_html__( 'Social Icon', 'et_builder' ),
				'type'                => 'select_icon',
				'option_category'     => 'basic_option',
				'class'               => array( 'et-pb-font-icon' ),
				'toggle_slug'     	  => 'social_network_icon',
				'description'         => esc_html__( 'Select Social Icon.', 'et_builder' ),
				// 'hover'               => 'tabs',
				'mobile_options'	  => true,
				'show_if' 	  		  => array(
					'dnext_social_network'  => 'social-items',
				),
			),
			'content' => array(
				'label'       => esc_html__( 'Body', 'et_builder' ),
				'type'        => 'hidden',
				'toggle_slug' => 'main_content',
			),
			'url' => array(
				'label'               => esc_html__( 'Account Link URL', 'et_builder' ),
				'type'                => 'text',
				'option_category'     => 'basic_option',
				'description'         => esc_html__( 'The URL for this social network link.', 'et_builder' ),
				'depends_show_if_not' => 'skype',
				'depends_on'          => array(
					'dnext_social_network'
				),
				'toggle_slug'         => 'link',
				'default_on_front'    => '#',
			),
			'skype_url' => array(
				'label'           => esc_html__( 'Account Name', 'et_builder' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'The Skype account name.', 'et_builder' ),
				'toggle_slug'     => 'main_content',
				'show_if' 	  		  => array(
					'dnext_social_network'  => array('skype',),
				),
			),
			'skype_action' => array(
				'label'           => esc_html__( 'Skype Button Action', 'et_builder' ),
				'type'            => 'select',
				'option_category' => 'basic_option',
				'options'         => array(
					'call' => esc_html__( 'Call', 'et_builder' ),
					'chat' => esc_html__( 'Chat', 'et_builder' ),
				),
				'show_if' 	  		  => array(
					'dnext_social_network'  => array('skype',),
				),
				'description'     => esc_html__( 'Here you can choose which action to execute on button click', 'et_builder' ),
				'toggle_slug'     => 'main_content',
				'default_on_front' => 'call',
			),
			'teamsorev_link_new_window'           => array(
                'label'            => esc_html__('Link Target', 'et_builder'),
                'type'             => 'select',
                'option_category'  => 'configuration',
                'options'          => array(
                    'off' => esc_html__('In The Same Window', 'et_builder'),
                    'on'  => esc_html__('In The New Tab', 'et_builder'),
                ),
                'toggle_slug'      => 'link_window',
                'description'      => esc_html__('Here you can choose whether or not your link opens in a new window', 'et_builder'),
            ),
			'teamsorev_icon_color'         => array(
				'label'          => esc_html__( 'Icon Color', 'et_builder' ),
				'description'    => esc_html__( 'Here you can define a custom color for the social network icon.', 'et_builder' ),
				'type'           => 'color-alpha',
				'default'        => '#ffffff',
				'custom_color'   => true,
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'icon',
				'hover'          => 'tabs',
				'mobile_options' => true,
			),
			'teamsorev_icon_font_size'  => array(
				'label'            		=> esc_html__( 'Icon Font Size', 'et_builder' ),
				'description'      		=> esc_html__( 'Control the size of the icon by increasing or decreasing the font size.', 'et_builder' ),
				'type'             		=> 'range',
				'option_category'  		=> 'font_option',
				'tab_slug'         		=> 'advanced',
				'toggle_slug'      		=> 'icon',
				'allowed_units'    		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'default'          		=> '16px',
				'default_unit'     		=> 'px',
				'default_on_front' 		=> '',
				'range_settings'   		=> array(
						'min'  => '1',
						'max'  => '120',
						'step' => '1',
				),
				'mobile_options'   		=> true,
				'hover'            		=> 'tabs',
			),
		);

		return $fields;
	}

	public function render( $attrs, $content, $render_slug ) {

		$multi_view = et_pb_multi_view_options( $this );

		$dnext_social_network		= $this->props['dnext_social_network'];
		$url						= $this->props['url'];
		$skype_url					= $this->props['skype_url'];
		$skype_action				= $this->props['skype_action'];
		$teamsorev_link_new_window	= $this->props['teamsorev_link_new_window'];

		// Social Icon Color
		$teamsorev_icon_color			= $this->props['teamsorev_icon_color'];
		$teamsorev_icon_color_hover 	= $this->get_hover_value( 'teamsorev_icon_color' );
		$teamsorev_icon_color_values	= et_pb_responsive_options()->get_property_values( $this->props, 'teamsorev_icon_color' );
		$teamsorev_icon_color_tablet	= isset( $teamsorev_icon_color_values['tablet'] ) ? $teamsorev_icon_color_values['tablet'] : '';
		$teamsorev_icon_color_phone		= isset( $teamsorev_icon_color_values['phone'] ) ? $teamsorev_icon_color_values['phone'] : '';

		// Social Icon Color
		if ( '' !== $teamsorev_icon_color ) {
			$teamsorev_icon_color_style 		= sprintf( 'color: %1$s;', esc_attr( $teamsorev_icon_color ) );
			$teamsorev_icon_color_tablet_style 	= '' !== $teamsorev_icon_color_tablet ? sprintf( 'color: %1$s;', esc_attr( $teamsorev_icon_color_tablet ) ) : '';
			$teamsorev_icon_color_phone_style  	= '' !== $teamsorev_icon_color_phone ? sprintf( 'color: %1$s;', esc_attr( $teamsorev_icon_color_phone ) ) : '';
			
			$teamsorev_icon_color_style_hover  = '';

			if ( et_builder_is_hover_enabled( 'teamsorev_icon_color', $this->props ) ) {
				$teamsorev_icon_color_style_hover = sprintf( 'color: %1$s;', esc_attr( $teamsorev_icon_color_hover ) );
			}

			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnxte-teamsorev-sn a span",
				'declaration' => $teamsorev_icon_color_style,
			) );
			
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnxte-teamsorev-sn a span",
				'declaration' => $teamsorev_icon_color_tablet_style,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
			) );

			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnxte-teamsorev-sn a span",
				'declaration' => $teamsorev_icon_color_phone_style,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
			) );

			if ( "" !== $teamsorev_icon_color_style_hover ) {
				ET_Builder_Element::set_style( $render_slug, array(
					'selector'    => $this->add_hover_to_order_class( "%%order_class%% .dnxte-teamsorev-sn a span:hover" ),
					'declaration' => $teamsorev_icon_color_style_hover,
				) );
			}
		}

		// Social Icon Size
		$teamsorev_icon_font_size 				= $this->props['teamsorev_icon_font_size'];
		$teamsorev_icon_font_size_hover			= $this->get_hover_value('teamsorev_icon_font_size');
		$teamsorev_icon_font_size_tablet 		= $this->props['teamsorev_icon_font_size_tablet'];
		$teamsorev_icon_font_size_phone 		= $this->props['teamsorev_icon_font_size_phone'];
		$teamsorev_icon_font_size_last_edited 	= $this->props['teamsorev_icon_font_size_last_edited'];

		if ( '' !== $teamsorev_icon_font_size ) {

			$teamsorev_icon_font_size_responsive_active = et_pb_get_responsive_status( $teamsorev_icon_font_size_last_edited );
			$teamsorev_icon_font_size_values = array(
				'desktop' => $teamsorev_icon_font_size,
				'tablet'  => $teamsorev_icon_font_size_responsive_active ? $teamsorev_icon_font_size_tablet : '',
				'phone'   => $teamsorev_icon_font_size_responsive_active ? $teamsorev_icon_font_size_phone : '',
			);

			$teamsorev_icon_font_size_selector = "%%order_class%% .dnxte-teamsorev-sn a span";
			et_pb_responsive_options()->generate_responsive_css( $teamsorev_icon_font_size_values, $teamsorev_icon_font_size_selector, 'font-size', $render_slug );
		
		}

		$_icon = "<span></span>";
        if($dnext_social_network === 'social-items') {
			$icon_css_property = array(
				'selector'    	=> '%%order_class%% .dnext-social-items span::before',
				'class' 		=> ''
			);
			$_icon = Common::get_icon_html_using_psuedo("dnext_social_icon", $this, $render_slug, $icon_css_property);
        }



		if ( 'skype' === $dnext_social_network ) {
			$skype_url = sprintf(
				'skype:%1$s?%2$s',
				sanitize_text_field( $skype_url ),
				sanitize_text_field( $skype_action )
			);
		}

		$teamsorev_url = 'skype' === $dnext_social_network ? $skype_url : esc_url( $url );

		$teamsorev_target = 'on' === $this->props['teamsorev_link_new_window'] ? '_blank' : '';

		$social_bg_color = array(
			"facebook",
			"twitter",
			"pinterest",
			"linkedin",
			"tumblr",
			"instagram",
			"skype",
			"flikr",
			"dribbble",
			"youtube",
			"vimeo",
		);

		if (in_array($dnext_social_network, $social_bg_color, true )) {
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% {$this->props['dnext_social_network']} span::before",
				'declaration' => "background-color: {$this->props['background_color']} !important",
			) );
		}


		
		$output ="<li class='dnxte-teamsorev-sn'>
				<a href='{$teamsorev_url}' class='dnext-{$dnext_social_network}' target={$teamsorev_target}>{$_icon}</a>
			</li>";

		return $output;
		
	}
}

new Next_Team_Social_Reveal_Child;
