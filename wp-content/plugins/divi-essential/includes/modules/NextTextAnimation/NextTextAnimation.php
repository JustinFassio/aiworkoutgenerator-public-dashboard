<?php

class Next_Text_Animation extends ET_Builder_Module {

	public $slug       = 'dnxte_text_animation';
	public $vb_support = 'on';

	protected $module_credits = array(
		'module_uri' => 'https://www.diviessential.com/divi-text-animation/',
		'author'     => 'Divi Next',
		'author_uri' => 'www.divinext.com',
	);

	public function init() {
		$this->name 		= esc_html__( 'Next Text Animation', 'et_builder' );
		$this->icon_path    = plugin_dir_path( __FILE__ ) . 'icon.svg';
		$this->folder_name 	= 'et_pb_divi_essential';

		$this->settings_modal_toggles = array(
			'general'	=> array(
				'toggles'		=>	array(
					'animation_text'	=> esc_html__( 'Text Animation', 'et_builder' ),
				),
			),
			'advanced'	=> array(
				'toggles'		=>	array(
					'text_font'	=>	array(
						'title'		=>	esc_html__( 'Font', 'et_builder' ),
						'priority'	=>	1
					),
					// Heading font Toggles
					'heading_fonts'       => array(
						'title'             => esc_html__('Fonts', 'et_builder'),
						'priority'          => 2,
						'sub_toggles'       => array(
							'sub_toogle_heading_fonts'   => array(
								'name' => 'Heading Text',
							),
							'sub_toogle_animation_fonts'   => array(
								'name' => 'Animation Text',
							),
						),
						'tabbed_subtoggles' => true,			
					),
				),
			),

		);

        // Custom CSS Field
        $this->custom_css_fields = array(
            'before_text' => array(
                'label'    => esc_html__('Before Text', 'et_builder'),
                'selector' => '%%order_class%% .dnxt-animation-b-text',
            ),
            'text_animation'  => array(
                'label'    => esc_html__('Animation Text', 'et_builder'),
                'selector' => '%%order_class%% .dnxt-text-animation',
            ),  
            'after_text'  => array(
                'label'    => esc_html__('After Text', 'et_builder'),
                'selector' => '%%order_class%% .dnxt-animation-a-text',
            ),
        );
	}

	public function get_fields() {
		$labels = esc_html__("Animation Text", "dnext-divi-next");
		return array(
            // Before Text Field
			'before_text'      	  => array(
				'label'           => esc_html__( 'Before Text', 'et_builder' ),
				//'default'		  => 'Before Text',
				'type'            => 'text',
				'dynamic_content' => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Before Text entered here will appear inside the module.', 'et_builder' ),
				'toggle_slug'     => 'animation_text'
			),
			// Animation Text
			'text_animation'      => array(
				'label'           => esc_html__( 'Animation Text', 'et_builder' ),
				'type'            => 'sortable_list',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Title entered here will appear inside the module.', 'et_builder' ),
				'computed_affects' => array(
					'__animationText',
				),
				'toggle_slug'     => 'animation_text'
			),
			// After Text Field
			'after_text'      => array(
				'label'           => esc_html__( 'After Text', 'et_builder' ),
				//'default'		  => 'After Text',
				'type'            => 'text',
				'dynamic_content' => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'After Text entered here will appear inside the module.', 'et_builder' ),
				'toggle_slug'     => 'animation_text'
			),
			// Animation Text Field
			'__animationText' => array(
				'type'	=> 'computed',
				'computed_callback' => array( 'DNXT_NextTextAnimation', 'dnxt_callback' ),
				'computed_minumum' => array(
					'text_animation'
				),

			),
			// Animation Effect Type
			'dnxt_text_animation_effect'           => array(
				'label'           	=> esc_html__( 'Select Animation Effect', 'et_builder' ),
				'type'              => 'select',
				'option_category'   => 'basic_option',
				'toggle_slug'       => 'animation_text',
				'default'           => 'rotate-1',
				'description'       => esc_html__( 'Here you can adjust the Animation effect.' ),
				'options'			=> array(
					'rotate-1'					=>  esc_html__( 'Flip', 'et_builder' ),
					'letters type'				=>  esc_html__( 'Typing', 'et_builder' ),
					'letters rotate-2'      	=>  esc_html__( 'Spiral', 'et_builder' ),
					'loading-bar'     			=>  esc_html__( 'Loading Bar', 'et_builder' ),
					'slide'           			=>  esc_html__( 'Slide Down', 'et_builder' ),
					'clip'       				=>  esc_html__( 'Clip', 'et_builder' ),
					'zoom'          			=>  esc_html__( 'Drop In', 'et_builder' ),
					'letters rotate-3'        	=>  esc_html__( 'Swirl', 'et_builder' ),
					'letters scale'           	=>  esc_html__( 'Flow', 'et_builder' ),
					'push'    					=>  esc_html__( 'Push', 'et_builder' ),
				),				
			),
			//Animation Loading Bar Color Option
			'loading_bar_color'  => array(
				'label'          => esc_html__('Loading Bar Color', 'et_builder'),
				'type'           => 'color-alpha',
				'toggle_slug'    => 'animation_text',
				'show_if'        => array(
					'dnxt_text_animation_effect' => 'loading-bar',
				),
                'default'        => '#0077FF',
			),
			//Animation Loading Bar Height Option
			'loading_bar_height'	=> array(
				'label'         	=> esc_html__('Loading Bar Height', 'et_builder'),
				'type'				=> 'range',
				'toggle_slug'		=> 'animation_text',
				'option_category'	=> 'layout',
				'default'			=> '3px',				
				'range_settings'  	=> array(
							'min'  => '1',
							'max'  => '100',
							'step' => '1',
				),
				'fixed_unit'      => 'px',
				'validate_unit'   => true,
				'show_if'         => array(
					'dnxt_text_animation_effect' => 'loading-bar',
				),
			),
			// Heading Tag Option
			'heading_tag'         => array(
				'label'           => esc_html__('Select Heading Tag', 'et_builder'),
				'type'            => 'select',
				'description'     => esc_html__('Select the heading tag, which you would like to use', 'et_builder'),
				'option_category' => 'basic_option',
				'toggle_slug'     => 'animation_text',
				'options'         => array(
						'h1'	  => esc_html__('H1', 'et_builder'),
						'h2'	  => esc_html__('H2', 'et_builder'),
						'h3'	  => esc_html__('H3', 'et_builder'),
						'h4'	  => esc_html__('H4', 'et_builder'),
						'h5'	  => esc_html__('H5', 'et_builder'),
						'h6'	  => esc_html__('H6', 'et_builder'),
						'p'	      => esc_html__('P', 'et_builder'),
				),
				'default'         => 'h2',
			),
			// Display Stack
			'display_type_select' => array(
                'label'           => esc_html__('Display Stacked', 'et_builder'),
				'type'            => 'yes_no_button',
				'description'     => esc_html__('Select how you would like to display the heading. Either inline or stacked.', 'et_builder'),
				'toggle_slug'     => 'animation_text',
				'options'         => array(
                    'off'		  => esc_html__('Inline', 'et_builder'),
                    'on'		  => esc_html__('Stack', 'et_builder'),
                ),
                'default'         => 'off',
            ),
		);
	}

	static function dnxt_callback( $args = array() ) {

		$defaults = array(
			'before_text' 				=> '',
			'text_animation'			=> '',
			'after_text'				=> '',
			'dnxt_text_animation_effect'=> '',
			'heading_tag'				=> '',
			'heading_fonts'				=> '',
			'animation_fonts'			=> ''
		);

		$args = wp_parse_args( $args, $defaults );

		$order       		= array('&#91', '&#93', ';' );
		$replace     		= array('[', ']');
		$text_animation     = str_replace( $order, $replace, $args['text_animation'] );
		$text_animation     = json_decode( $text_animation);

		ob_start();
		?>
			<div class="dnxt-animation-intro">
				<<?php echo esc_attr($args['heading_tag']); ?> class="dnxt_next_text_animation dnxt-headline <?php echo esc_attr($args['dnxt_text_animation_effect']); ?>">
					<?php if ( '' != $args['before_text']) : ?>
						<span class="dnxt-animation-b-text dnxt-text-heading"><?php echo et_core_esc_previously($args['before_text']); ?></span>
					<?php endif; ?>
					<span class="dnxt-words-wrapper">
						<?php foreach( $text_animation as $key => $line): ?>
							<b class="dnxt-text-animation <?php echo ($key === 0) ? 'is-visible' : ''; ?>"><?php echo et_core_esc_previously($line->value); ?></b>
						<?php endforeach; ?>
					</span>
					<?php if ( '' != $args['after_text'] && !empty($args['after_text'])) : ?>
						<span class="dnxt-animation-a-text dnxt-text-heading"><?php echo et_core_esc_previously($args['after_text']); ?></span>
					<?php endif; ?>
				</<?php echo esc_attr($args['heading_tag']); ?>>
			</div>
		<?php
		
		$output = ob_get_clean();

		return $output;
	}

	public function get_advanced_fields_config() {
		$advanced_fields = array();
		
		$advanced_fields['fonts'] = array(
            // Before After Fonts
            'heading_fonts'   => array(
                'label'       => esc_html__('', 'et_builder'),
                'toggle_slug' => 'heading_fonts',
				'tab_slug'    => 'advanced',
				'hide_text_align' => true,
				'sub_toggle'  => 'sub_toogle_heading_fonts',
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size'   => array(
                    'default' => '48px', // default = 3rem = 48px
                ),
                'css'         => array(
                    'main' => "%%order_class%% .dnxt-text-heading",
                ),
			),
			// Animation Text
			'animation_fonts'   => array(
				'label'       => esc_html__('', 'et_builder'),
				'toggle_slug' => 'heading_fonts',
				'tab_slug'    => 'advanced',
				'hide_text_align' => true,
				'sub_toggle'  => 'sub_toogle_animation_fonts',
				'line_height' => array(
					'default' => '1em',
				),
				'font_size'   => array(
					'default' => '48px', // 3rem = 48px
				),
				'css'         => array(
					'main' => "%%order_class%% .dnxt-text-animation,%%order_class%% .dnxt-text-animation i, %%order_class%% .dnxt-text-animation i em",
				),
			),
		);
		return $advanced_fields;
	}

	public function render( $attrs, $content, $render_slug ) {
		wp_enqueue_script( 'dnxt_divinexttexts-public' );
		$before_text 		= $this->props['before_text'];
		$after_text 		= $this->props['after_text'];
		$animation_effect 	= $this->props['dnxt_text_animation_effect'];
		$heading_tag 		= $this->props['heading_tag'];
		$heading_fonts		= false;

		if(isset($this->props['heading_fonts'])){
			$heading_fonts = $this->props['heading_fonts'];
		}

		$animation_fonts = false;
		if(isset($this->props['animation_fonts'])){
			$animation_fonts = $this->props['animation_fonts'];
		}
		$this->apply_css($render_slug);


		$order_class 	  	= self::get_module_order_class( $render_slug );
		$order_id	  		= str_replace('_','',str_replace( $this->slug,'', $order_class) );

		$order       		= array('&#91', '&#93', ';' );
		$replace     		= array('[', ']');
		$text_animation     = str_replace( $order, $replace, $this->props['text_animation']);
		$text_animation     = json_decode( $text_animation );

		$data_string 		= '';

		$numItems = count( array($text_animation) );
		$i = 0;
		foreach ( (array) $text_animation as $key => $obj ) {
			if(++$i === $numItems) {
				$data_string  .= $obj->value;
		  } else {
				$data_string  .= $obj->value;
		  }
		}

		$data_strings 	= explode( ' ', $data_string );
		$animation_data = wp_json_encode( $data_strings );

		$heading = self::dnxt_callback( array(
			'before_text' 					=> $before_text,
			'after_text' 					=> $after_text,
			'text_animation' 				=> $this->props['text_animation'],
			'dnxt_text_animation_effect' 	=> $animation_effect,
			'heading_tag'					=> $heading_tag,
			'heading_fonts'					=> $heading_fonts,
			'animation_fonts'				=> $animation_fonts
		));

		return sprintf(
			'%1$s',
			$heading 
		);
	}

	public function apply_css($render_slug){
		$this->props['text_orientation_last_edited'] = "";
		if ('' !== $this->props['text_orientation']) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt_next_text_animation",
				'declaration'	=>	"text-align: {$this->props['text_orientation']};"
			));
		}
		if ( 'on|tablet' === $this->props['text_orientation_last_edited'] ) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt_next_text_animation",
				'declaration' => "text-align: {$this->props['text_orientation_tablet']} !important;",
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
			));
		}
		if ( 'on|phone' === $this->props['text_orientation_last_edited'] ) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt_next_text_animation",
				'declaration' => "text-align: {$this->props['text_orientation_phone']} !important;",
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
			));
		}
		/**
         * Dispaly Inline or Stacked
         *
         */
        if (('on' === $this->props['display_type_select'])) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "%%order_class%% .dnxt-text-heading",
                'declaration' => "display: block;",
            ));
		}
		/**
         * Loading Bar Dispaly Inline or Stacked
         *
         */
		if ('on' === $this->props['display_type_select'] && 'loading-bar' === $this->props['dnxt_text_animation_effect']) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt-headline.loading-bar span",
				'declaration'	=>	"display: block;"
			));
		}
		/**
         * Clip Dispaly Inline or Stacked
         *
         */
		if ('on' === $this->props['display_type_select'] && 'clip' === $this->props['dnxt_text_animation_effect']) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt-headline.clip span",
				'declaration'	=>	"display: block;"
			));
		}
		/**
         * Slide Dispaly Inline or Stacked
         *
         */
		if ('on' === $this->props['display_type_select'] && 'slide' === $this->props['dnxt_text_animation_effect']) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt-headline.slide span",
				'declaration'	=>	"display: block;"
			));
		}
		// Loading Options
		if ('loading-bar' === $this->props['dnxt_text_animation_effect']) {
			// Loading Bar Color
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt-headline.loading-bar .dnxt-words-wrapper::after",
				'declaration'	=>	"background: {$this->props['loading_bar_color']};"
			));
			// Loading Bar Height
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => "%%order_class%% .dnxt-headline.loading-bar .dnxt-words-wrapper::after",
				'declaration'	=>	"height: {$this->props['loading_bar_height']};"
			));
		}

	}
}

new Next_Text_Animation;
