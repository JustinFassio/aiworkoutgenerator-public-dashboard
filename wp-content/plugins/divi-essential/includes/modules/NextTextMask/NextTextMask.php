<?php

class Next_Text_Mask extends ET_Builder_Module {

	public $slug       = 'dnxte_text_mask';
	public $vb_support = 'on';

	protected $module_credits = array(
		'module_uri' => 'https://www.diviessential.com/divi-text-mask/',
		'author'     => 'Divi Next',
		'author_uri' => 'www.divinext.com',
	);

	public function init() {
		$this->name 		= esc_html__( 'Next Text Mask', 'et_builder' );
		$this->icon_path    = plugin_dir_path( __FILE__ ) . 'icon.svg';
		$this->folder_name 	= 'et_pb_divi_essential';

		$this->settings_modal_toggles = array(
			'general'	=> array(
				'toggles'		=>	array(
					'text'			=> esc_html__( 'Text', 'et_builder' ),
					'image_mask'	=>	array(
						'title'			=>	esc_html__( 'Image Mask', 'et_builder' ),
						'priority'		=>	48
					)
				),
			),
			'advanced'	=> array(
				'toggles'		=>	array(
					'heading_mask'	=>	array(
						'title'		=>	esc_html__( 'Fonts', 'et_builder' ),
						'priority'	=>	1
					),
					// Hover Effect
					'dnxt_text_hover_effect'	=> array(
						'title'             	=> esc_html__('Hover Effect', 'et_builder'),
						'priority'          	=> 4,
					),
				),
			),
		);
		
		// Custom CSS Field
		$this->custom_css_fields = array(
			'gradient_title_css' => array(
				'label'    => esc_html__('Text Mask CSS', 'et_builder'),
				'selector' => '%%order_class%% .dn-dtm-text-masking',
			)
		);
	}

	public function get_fields() {

		return array(
			//Thumbnail Image Mask
			'thumbnail_image_mask'	=> array(
				'label'           	=> esc_html__( 'Thumbnail Image Mask', 'et_builder' ),
				'type'            	=> 'upload',
				'data_type'		  	=> 'image',
				'description'     	=> esc_html__( 'Image entered here will appear inside the module.', 'et_builder' ),
				'upload_button_text'=>	esc_html__( 'Upload Image', 'et_builder' ),
				'choose_text'		=>	esc_html__( 'Choose Image', 'et_builder' ),
				'update_text'		=>	esc_html__( 'Update Image', 'et_builder' ),
				'option_category' 	=> 'basic_option',
				'toggle_slug'     	=> 'image_mask',
				'hide_metadata'		=>	true,
			),
			//Background Image Size
			'background_image_size'	=> array(
				'label'				=> esc_html__( 'Background Image Size', 'et_builder' ),
				'type'				=> 'select',
				'description'     	=> esc_html__( 'Choose between Cover, Fit and Actual size and check how it looks as a background to your text.', 'et_builder' ),
				'option_category'	=> 'basic_option',
				'toggle_slug'		=> 'image_mask',
				'options'       	=> array(
						'cover'		=> esc_html__( 'Cover', 'et_builder' ),
						'contain'	=> esc_html__( 'Fit', 'et_builder' ),
						'initial'	=> esc_html__( 'Actual Size', 'et_builder' ),
				),
				'default'         	=> 'cover',
			),
			//Background Image Position
			'background_image_position' =>	array(
				'label'				=> esc_html__( 'Background Image Position', 'et_builder' ),
				'type'				=> 'select',
				'description'     	=> esc_html__( 'Choose a position from the options below and see what best fits your text.', 'et_builder' ),
				'option_category'	=> 'basic_option',
				'toggle_slug'		=> 'image_mask',
				'options'       	=> array(
					'top left'      => esc_html__( 'Top Left', 'et_builder' ),
					'top center'    => esc_html__( 'Top Center', 'et_builder' ),
					'top right'     => esc_html__( 'Top Right', 'et_builder' ),
					'center left'   => esc_html__( 'Center Left', 'et_builder' ),
					'center'        => esc_html__( 'Center', 'et_builder' ),
					'center right'  => esc_html__( 'Center Right', 'et_builder' ),
					'bottom left'   => esc_html__( 'Bottom Left', 'et_builder' ),
					'bottom center' => esc_html__( 'Bottom Center', 'et_builder' ),
					'bottom right'  => esc_html__( 'Bottom Right', 'et_builder' ),
				),
				'default'         	=> 'top left',
			),
			//Background Image Repeat
			'background_image_repeat'	=>	array(
				'label'				=> esc_html__( 'Background Image Repeat', 'et_builder' ),
				'type'				=> 'select',
				'description'     	=> esc_html__( 'Adjust the repetition of the image you picked and see whether it suits your text.', 'et_builder' ),
				'option_category'	=> 'basic_option',
				'toggle_slug'		=> 'image_mask',
				'options'       	=> array(
						'no-repeat' => esc_html__( 'No Repeat', 'et_builder' ),
						'repeat'    => esc_html__( 'Repeat', 'et_builder' ),
						'repeat-x'  => esc_html__( 'Repeat X (horizontal)', 'et_builder' ),
						'repeat-y'  => esc_html__( 'Repeat Y (vertical)', 'et_builder' ),
						'space'     => esc_html__( 'Space', 'et_builder' ),
						'round'     => esc_html__( 'Round', 'et_builder' ),
				),
				'default'         	=> 'no-repeat',
			),
			//Title Text
			'text_mask'			  =>	array(
				'label'           => esc_html__( 'Title', 'et_builder' ),
				'type'            => 'text',
				'dynamic_content' => 'text',
				'description'     => esc_html__( 'Title entered here will appear inside the module.', 'et_builder' ),
				//'default'         => 'Text Mask',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'main_content',
				
			),
			//Heading Tag
			'heading_tag'		  =>	array(
				'label'           => esc_html__('Select Heading Tag', 'et_builder'),
				'type'            => 'select',
				'description'     => esc_html__('Select the heading tag, which you would like to use', 'et_builder'),
				'option_category' => 'basic_option',
				'toggle_slug'     => 'main_content',
				'options'         => array(
						'h1'	  => esc_html__('H1', 'et_builder'),
						'h2'	  => esc_html__('H2', 'et_builder'),
						'h3'	  => esc_html__('H3', 'et_builder'),
						'h4'	  => esc_html__('H4', 'et_builder'),
						'h5'	  => esc_html__('H5', 'et_builder'),
						'h6'	  => esc_html__('H6', 'et_builder'),
				),
				'default'         => 'h2',
			),
			// Rotate Text Vertically
			'text_switch'			=>	array(
				'label'				=> esc_html__( 'Rotate Text Vertically', 'et_builder' ),
				'type'				=> 'yes_no_button',
				'description'		=> esc_html__( 'Turn this on for rotated text effect', 'et_builder' ),
				'toggle_slug'		=> 'main_content',
				'options'			=> array(
							'off'	=> 'Off',
							'on'	=>	'On',		  
				),
				'default'           => 'off',
			),
			// Rotate Text Vertically Flip
			'text_vertically_flip'	=>	array(
				'label'				=> esc_html__( 'Rotate Text Vertically Flip', 'et_builder' ),
				'type'				=> 'yes_no_button',
				'description'		=> esc_html__( 'Turn this on for rotated text effect flip', 'et_builder' ),
				'toggle_slug'		=> 'main_content',
				'options'			=> array(
							'off'	=> 'Off',
							'on'	=>	'On',		  
				),
				'default'           => 'off',
				'show_if'             => array(
                    'text_switch' => 'on',
				)
			),
			// Text Hover Switch
			'dnxt_text_hover_effect_switch' => array(
				'label'           => esc_html__('Text Hover Effect', 'et_builder'),
				'type'            => 'yes_no_button',                
				'description'     => esc_html__('Select if you would like to use text hover effect', 'et_builder'),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dnxt_text_hover_effect',
				'options'         => array(
						'off'     => esc_html__('Off', 'et_builder'),
						'on'      => esc_html__('On', 'et_builder'),
				),
				'default'         => 'off',				
				'show_if'         => array(
                    'text_switch' => 'off',
				)
			),
            // Select Hover Effect
            'dnxt_text_hover_effect_select'           => array(
                'label'             => esc_html__( 'Select Hover Effect', 'et_builder' ),
                'type'              => 'select',
                'option_category'   => 'configuration',
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'dnxt_text_hover_effect',
                'default'           => 'grow',
                'description'       => esc_html__( 'Here you can adjust the hover effect.' ),
                'options'           => array(
                    'backward'               =>  esc_html__( 'Backward', 'et_builder' ),
                    'bob'                    =>  esc_html__( 'Bob', 'et_builder' ),
                    'bounce-in'              =>  esc_html__( 'Bounce In', 'et_builder' ),
                    'bounce-out'             =>  esc_html__( 'Bounce Out', 'et_builder' ),
                    'buzz'                   =>  esc_html__( 'Buzz', 'et_builder' ),
                    'buzz-out'               =>  esc_html__( 'Buzz Out', 'et_builder' ),
                    'float'                  =>  esc_html__( 'Float', 'et_builder' ),
                    'forward'                =>  esc_html__( 'Forward', 'et_builder' ),
                    'grow'                   =>  esc_html__( 'Grow', 'et_builder' ),
                    'grow-rotate'            =>  esc_html__( 'Grow Rotate', 'et_builder' ),
                    'hang'                   =>  esc_html__( 'Hang', 'et_builder' ),
                    'pop'                    =>  esc_html__( 'Pop', 'et_builder' ),
                    'pulse'                  =>  esc_html__( 'Pulse', 'et_builder' ),
                    'pulse-grow'             =>  esc_html__( 'Pulse Grow', 'et_builder' ),
                    'pulse-shrink'           =>  esc_html__( 'Pulse Shrink', 'et_builder' ),
                    'push'                   =>  esc_html__( 'Push', 'et_builder' ),
                    'rotate'                 =>  esc_html__( 'Rotate', 'et_builder' ),
                    'shrink'                 =>  esc_html__( 'Shrink', 'et_builder' ),
                    'sink'                   =>  esc_html__( 'Sink', 'et_builder' ),
                    'skew'                   =>  esc_html__( 'Skew', 'et_builder' ),
                    'skew-backward'          =>  esc_html__( 'Skew Backward', 'et_builder' ),
                    'skew-forward'           =>  esc_html__( 'Skew Forward', 'et_builder' ),
                    'wobble-bottom'          =>  esc_html__( 'Wobble Bottom', 'et_builder' ),
                    'wobble-horizontal'      =>  esc_html__( 'Wobble Horizontal', 'et_builder' ),
                    'wobble-skew'            =>  esc_html__( 'Wobble Skew', 'et_builder' ),
                    'wobble-top'             =>  esc_html__( 'Wobble Top', 'et_builder' ),
                    'wobble-to-bottom-right' =>  esc_html__( 'Wobble To Bottom Right', 'et_builder' ),
                    'wobble-to-top-right'    =>  esc_html__( 'Wobble To Top Right', 'et_builder' ),
                    'wobble-vertical'        =>  esc_html__( 'Wobble Vertical', 'et_builder' ),
				),
                'mobile_options'      => true,
                'show_if'             => array(
                    'dnxt_text_hover_effect_switch' => 'on',
				)
            ),
		);
	}

	public function get_advanced_fields_config() {
		$advanced_fields = array();

		$advanced_fields['text'] 		= false;
		$advanced_fields['text_shadow'] = false;
		$advanced_fields['fonts'] 		= false;


		$advanced_fields['fonts'] = array(
            //Text
            'text_mask'   => array(
					'label'       => esc_html__('', 'et_builder'),
					'toggle_slug' => 'heading_mask',
					'tab_slug'    => 'advanced',
					'line_height' => array(
						'default' => '1em',
					),
					'font_size'   => array(
						'default' => '70px',
					),
					'css'         => array(
						'main' => "%%order_class%% .dn-dtm-text-masking",
					),
				),
			);
		return $advanced_fields;
	}

	public function render( $attrs, $content, $render_slug ) {
		wp_enqueue_style('dnext_hvr_common_css');
		$headingTag  				= $this->props['heading_tag'];
		$thumbnail_image_mask		= $this->props['thumbnail_image_mask'];
		$background_image_size  	= $this->props['background_image_size'];
		$background_image_position	= $this->props['background_image_position'];
		$background_image_repeat	= $this->props['background_image_repeat'];

		$text_vertically = '';
		if ( 'on' === $this->props['text_switch'] && 'off' === $this->props['text_vertically_flip'] ) {
            $text_vertically = " dn-dtm-text-masking text_bg dnxt-text-writting-mode";
        } else if ( 'on' === $this->props['text_switch'] && 'on' === $this->props['text_vertically_flip'] ){
			$text_vertically = " dn-dtm-text-masking text_bg dnxt-text-writting-mode dnxt-text-transform";
		} else {
            $text_vertically = "dn-dtm-text-masking text_bg";
		}
		 
        if ( '' !== $thumbnail_image_mask ) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'		=>	"%%order_class%% .dn-dtm-text-masking",
				'declaration'	=>	"background-image: url({$thumbnail_image_mask});"
			));
		}

		if ( '' !== $background_image_size ) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'		=>	"%%order_class%% .dn-dtm-text-masking",
				'declaration'	=>	"background-size: {$background_image_size};"
			));
		}

		if ( '' !== $background_image_position ) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'		=>	"%%order_class%% .dn-dtm-text-masking",
				'declaration'	=>	"background-position: {$background_image_position};"
			));
		}
		
		if ( '' !== $background_image_repeat ) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector'		=>	"%%order_class%% .dn-dtm-text-masking",
				'declaration'	=>	"background-repeat: {$background_image_repeat};"
			));
		}

		$text_hover_effect_enable = '';
        if ( 'on' === $this->props['dnxt_text_hover_effect_switch'] ) {
            $text_hover_effect_enable = $this->props['dnxt_text_hover_effect_select'];
        } else {
            $text_hover_effect_enable = "";
		}
		
		return sprintf(
			'<%3$s class="%1$s dnxt-hover-%4$s">
				%2$s
			</%3$s>',
			$text_vertically,
			$this->props['text_mask'],
			$headingTag,
			$text_hover_effect_enable  
		 );
	}
}

new Next_Text_Mask;
