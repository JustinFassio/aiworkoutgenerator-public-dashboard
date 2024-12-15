<?php
/**
 * Divi Review widget class
 *
 * @package Divi Next
 */
include_once(DIVI_ESSENTIAL_PATH.'/includes/modules/base/Common.php');

class Next_Review extends ET_Builder_Module {

	public $slug       = 'dnxte_review';
	public $vb_support = 'on';

	protected $module_credits = array(
		'module_uri' => 'https://www.diviessential.com/divi-review/',
		'author'     => 'Divi Next',
		'author_uri' => 'www.divinext.com',
	);

	public function init() {
        $this->name        = esc_html__( 'Next Divi Review', 'et_builder' );
        $this->icon_path   = plugin_dir_path( __FILE__ ) . 'icon.svg';
        $this->folder_name = 'et_pb_divi_essential';

		$this->settings_modal_toggles = array(
            'general'    => array(
                'toggles' => array(
                    'review_img'    => array(
                        'title' => esc_html__( 'Image', 'et_builder' ),
					),
					'next_rating'	=> array(
						'title'	=>	esc_html__( 'Rating', 'et_builder' ),
					)
                ),
            ),
            'advanced'   => array(
                'toggles' => array(
                    'review_image'   => array(
                        'title' => esc_html__('Image Settings', 'et_builder'),
                    ),
                    'rating_settings'   => array(
                        'title' => esc_html__('Rating Settings', 'et_builder'),
                    ),
                ),
            ),
            'custom_css' => array(
                'toggles' => array(),
            ),
		);
		
		$this->advanced_fields = array(
            'fonts'          => array(
                'header'   => array(
                    'label'        => esc_html__('Title', 'et_builder' ),
                    'css'          => array(
                        'main'      => "%%order_class%% h4.dnxte-review-header, %%order_class%% h1.dnxte-review-header, %%order_class%% h2.dnxte-review-header, %%order_class%% h3.dnxte-review-header, %%order_class%% h5.dnxte-review-header, %%order_class%% h6.dnxte-review-header",
                        'important' => 'plugin_only',
                    ),
                    'header_level' => array(
                        'default' => 'h4',
                    ),
				),
				'body'     => array(
					'label'          => esc_html__('Body', 'et_builder' ),
					'css'            => array(
						'main' => "%%order_class%% .dnxte-review-pra",
					),
					'block_elements' => array(
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
					),
				),
				'position' => array(
					'label'          => esc_html__( 'Position', 'et_builder' ),
					'css'            => array(
						'main' => "%%order_class%% .dnxte-review-wrapper p.dnxte-review-pos",
					),
					'line_height'    => array(
						'default' => '1.7em',
					),
					'font_size'      => array(
						'default' => absint(et_get_option('body_font_size', '14')) . 'px',
					),
					'letter_spacing' => array(
						'default' => '0px',
					),
				),
			),
			'background'     => array(
                'settings' => array(
                    'color' => 'alpha',
                ),
                'css'      => array(
                    'main'      => "%%order_class%% .dnxte-review-wrap",
                    'important' => true,
                ),
            ),
			'borders'        => array(
                'default'        => array(
                    'css' => array(
                        'main' => array(
                            'border_radii'  => "%%order_class%% .dnxte-review-wrap",
                            'border_styles' => "%%order_class%% .dnxte-review-wrap",
                        ),
                    ),
                ),
                'reviewer_image'          => array(
                    'css'        => array(
                        'main' => array(
                            'border_radii'  => "%%order_class%% .dnxte-review-img img",
                            'border_styles' => "%%order_class%% .dnxte-review-img img",
                        ),
                    ),
                    'defaults'    => array(
                        'border_radii'  => 'on|0px|0px|0px|0px',
                        'border_styles' => array(
                            'width' => '0px',
                            'color' => '#0077FF',
                            'style' => 'solid',
                        ),
                    ),
                    'label_prefix' => esc_html__( '', 'et_builder' ),
                    'tab_slug'     => 'advanced',
                    'toggle_slug'  => 'review_image',
                ),
                'rating_star'          => array(
                    'css'          => array(
                        'main' => array(
                            'border_radii'  => "%%order_class%% .dnxte-review-numb-des, %%order_class%% .dnxte-review-social",
                            'border_styles' => "%%order_class%% .dnxte-review-numb-des, %%order_class%% .dnxte-review-social",
                        ),
					),
					'defaults'        => array(
						'border_radii'  => 'on|20px|20px|20px|20px',
						'border_styles' => array(
							'width' => '0px',
							'color' => '#030303',
							'style' => 'solid',
						),
					),
                    'label_prefix' => esc_html__('Review'),
                    'tab_slug'     => 'advanced',
                    'toggle_slug'  => 'rating_settings',
                ),

			),
			'box_shadow'     => array(
                'default' => array(
                    'css' => array(
                        'main'    => "%%order_class%% .dnxte-review-wrap",
                        'hover'   => '%%order_class%%:hover .dnxte-review-wrap',
                        'overlay' => 'inset',
                    ),
                ),
			),
			'margin_padding' => array(
                'css' => array(
                    'important' => 'all',
                ),
            ),
            'max_width'      => array(
                'css' => array(
                    'module_alignment' => '%%order_class%%.next_review',
                ),
			),
			'filters'        => array(
                'css'                  => array(
                    'main' => '%%order_class%%',
                ),
                'child_filters_target' => array(
                    'tab_slug'    => 'advanced',
                    'toggle_slug' => 'image',
                ),
            ),
            'button'         => false,
            'text'           => false,
		);
		
		// Custom CSS Field
		$this->custom_css_fields = array(
			'review_image_wrapper'    => array(
				'label'    => esc_html__('Image', 'et_builder'),
				'selector' => '%%order_class%% .dnxte-review-img',
			),
			'review_title_wrapper'    => array(
				'label'    => esc_html__('Title', 'et_builder'),
				'selector' => '%%order_class%% .dnxte-review-header',
			),
			'review_position_wrapper' => array(
				'label'    => esc_html__('Position', 'et_builder'),
				'selector' => '%%order_class%% .dnxte-review-pos',
			),
			'review_rating_wrapper'  => array(
				'label'    => esc_html__('Rating', 'et_builder'),
				'selector' => '%%order_class%% .dnxte-review-social, %%order_class%% .dnxte-review-numb-des',
			),
			'review_content_wrapper'     => array(
				'label'    => esc_html__('Content', 'et_builder'),
				'selector' => '%%order_class%% .dnxte-review-details',
			),
		);

	}

	public function get_fields() {
		$fields = array(
			'reviewer_image'         => array(
                'label'              => esc_html__('Image', 'et_builder'),
                'type'               => 'upload',
                'option_category'    => 'basic_option',
                'upload_button_text' => esc_attr__('Upload an image', 'et_builder'),
                'choose_text'        => esc_attr__('Choose an Image', 'et_builder'),
                'update_text'        => esc_attr__('Set As Image', 'et_builder'),
                'description'        => esc_html__('Upload an image to display at the top of your team person.', 'et_builder'),
                'toggle_slug'        => 'review_img',
                'dynamic_content'    => 'image',
                'mobile_options'     => true,
                'hover'              => 'tabs',
			),
			'reviewer_name'       => array(
                'label'           => esc_html__('Name', 'et_builder'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'description'     => esc_html__('Input the name of the person', 'et_builder'),
                'toggle_slug'     => 'main_content',
                'dynamic_content' => 'text',
                'mobile_options'  => true,
                'hover'           => 'tabs',
			),
			'reviewer_position'   => array(
                'label'           => esc_html__('Position', 'et_builder'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'description'     => esc_html__("Input the person's position.", 'et_builder'),
                'toggle_slug'     => 'main_content',
                'dynamic_content' => 'text',
                'mobile_options'  => true,
                'hover'           => 'tabs',
            ),
			'reviewer_description'=> array(
                'label'           => esc_html__('Description', 'et_builder'),
                'type'            => 'tiny_mce',
                'option_category' => 'basic_option',
                'description'     => esc_html__('Input the review description for your module here.', 'et_builder'),
                'toggle_slug'     => 'main_content',
                'dynamic_content' => 'text',
                'mobile_options'  => true,
                'hover'           => 'tabs',
            ),
            'reviewer_img_width'    => array(
                'label'            => esc_html__('Image Width', 'et_builder'),
                'description'      => esc_html__('Adjust the width of the image within the team.', 'et_builder'),
                'type'             => 'range',
                'option_category'  => 'layout',
                'tab_slug'         => 'advanced',
                'toggle_slug'      => 'review_image',
                'allowed_units'    => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'default'          => '100%',
                'default_unit'     => '%',
                'default_on_front' => '',
                'allow_empty'      => true,
                'range_settings'   => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1',
                ),
                'mobile_options'   => true,
                'hover'            => 'tabs',
            ),
			'review_style'        => array(
                'label'           => esc_html__('Select Rating Style', 'et_builder'),
                'description'     => esc_html__('Choose rating Style', 'et_builder'),
                'type'            => 'select',
                'option_category' => 'layout',
                'toggle_slug'     => 'next_rating',
                'options'         => array(
                    'star'  => esc_html__('Star', 'et_builder'),
                    'num' 	=> esc_html__('Number', 'et_builder'),
                ),
				'default'         => 'star',
				'affects'         => array(
					'rating_text_color',
					'rating_bg_color_width'
				),
				'default_on_front'=> 'star',
            ),
			'star_rating'     		=> array(
                'label'            => esc_html__( 'Rating', 'et_builder'),
                'description'      => esc_html__('Adjust the rating of the review.', 'et_builder'),
                'type'             => 'range',
                'option_category'  => 'basic_option',
                'toggle_slug'      => 'next_rating',
                'allowed_units'    => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'default'          => '5',
				'fixed_unit'       => '',
				'validate_unit'    => false,
                'unitless'         => true,
                'default_on_front' => '5',
                'allow_empty'      => true,
                'range_settings'   => array(
                    'min'  => '0',
                    'max'  => '10',
                    'step' => '0.1',
                ),
                'mobile_options'   => true,
				'hover'            => 'tabs',
			),
			'star_scale'        => array(
                'label'           => esc_html__('Rating Scale', 'et_builder'),
                'description'     => esc_html__('Choose your rating scale', 'et_builder'),
                'type'            => 'select',
                'option_category' => 'layout',
                'toggle_slug'     => 'next_rating',
                'options'         => array(
                    '5'  	=> esc_html__('0 - 5', 'et_builder'),
                    '10' 	=> esc_html__('0 - 10', 'et_builder'),
                ),
				'default'         => '5',
				'show_if'         => array(
                    'review_style' => 'star',
                ),
			),
			'reviewer_image_position'	=> array(
                'label'					=> esc_html__('Select Image Postion', 'et_builder'),
                'type'            		=> 'select',
                'description'     		=> esc_html__('Select the types of image position', 'et_builder'),
                'tab_slug'        		=> 'advanced',
                'option_category' 		=> 'layout',
                'toggle_slug'     		=> 'review_image',
                'options'         => array(
                    'review-left' => esc_html__('Left', 'et_builder'),
                    'review-top'  => esc_html__('Top', 'et_builder'),
                ),
				'default'         	=> 'left-top',
				'depends_show_if' => 'on',
            ),
            'review_left'         => array(
                'label'           => esc_html__('Select Image Left Position', 'et_builder'),
                'description'     => esc_html__('Choose where Image', 'et_builder'),
                'type'            => 'select',
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'review_image',
                'options'         => array(
                    'left-top'    => esc_html__('Left Top', 'et_builder'),
                    'left-center' => esc_html__('Left Center', 'et_builder'),
                    'left-bottom' => esc_html__('Left Bottom', 'et_builder'),
                ),
                'default'         => 'left-top',
                'show_if'         => array(
                    'reviewer_image_position' => 'review-left',
                ),
                'mobile_options'  => true,
            ),
            'review_right'         => array(
                'label'           => esc_html__('Select Image Right Position', 'et_builder'),
                'description'     => esc_html__('Choose where Image', 'et_builder'),
                'type'            => 'select',
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'review_image',
                'options'         => array(
                    'right-top'    => esc_html__('Right Top', 'et_builder'),
                    'right-center' => esc_html__('Right Center', 'et_builder'),
                    'right-bottom' => esc_html__('Right Bottom', 'et_builder'),
                ),
                'default'         => 'right-top',
                'show_if'         => array(
                    'reviewer_image_position' => 'review-right',
                ),
                'mobile_options'  => true,
            ),
            'review_top'          => array(
                'label'           => esc_html__('Select Image Top Position', 'et_builder'),
                'description'     => esc_html__('Choose where Image', 'et_builder'),
                'type'            => 'select',
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'review_image',
                'options'         => array(
                    'top-left'   => esc_html__('Top Left', 'et_builder'),
                    'top-center' => esc_html__('Top Center', 'et_builder'),
                    'top-right'  => esc_html__('Top Right', 'et_builder'),
                ),
                'default'         => 'top-left',
                'show_if'         => array(
                    'reviewer_image_position' => 'review-top',
                ),
                'mobile_options'  => true,
            ),
            'review_rating_alignment'    => array(
                'label'           => esc_html__('Rating Alignment', 'et_builder'),
                'description'     => esc_html__('Align rating to the left, right or center.', 'et_builder'),
                'type'            => 'align',
                'option_category' => 'layout',
                'options'         => et_builder_get_text_orientation_options(array('justified')),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'rating_settings',
                'mobile_options'  => true,
            ),
			'rating_bg_color'       => array(
				'label'          => esc_html__('Select Background Color', 'et_builder'),
				'type'           => 'color-alpha',
                'tab_slug'       => 'advanced',
				'toggle_slug'    => 'rating_settings',
				'hover'    		 => 'tabs',
				'default'        => 'rgba(0,0,0,0)',
			),
			'rating_bg_color_width' 	=> array(
				'label'           		=> esc_html__( 'Background Width', 'et_builder' ),
				'description'     		=> esc_html__( 'Adjust the width of the background width.', 'et_builder' ),
				'type'            		=> 'range',
                'tab_slug'       		=> 'advanced',
				'toggle_slug'    		=> 'rating_settings',
				'option_category'		=> 'layout',
				'default'         		=> '100%',
				'default_unit'    		=> '%',
				'default_on_front'		=> '',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'allow_empty'     		=> true,
				'range_settings'  		=> array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'mobile_options'		=> true,
				'responsive'      		=> true,
				'hover'             	=> 'tabs',
				'depends_show_if'		=> 'star',
			),
			'rating_text_color'       => array(
				'label'          => esc_html__('Select Rating Text Color', 'et_builder'),
				'type'           => 'color-alpha',
                'tab_slug'       => 'advanced',
				'toggle_slug'    => 'rating_settings',
				'hover'    		 => 'tabs',
				'default'        => '#0c71c3',
				'depends_show_if'=> 'num',
			),
			'rating_color'       => array(
				'label'          => esc_html__('Select Star Color', 'et_builder'),
				'type'           => 'color-alpha',
                'tab_slug'       => 'advanced',
				'toggle_slug'    => 'rating_settings',
				'hover'    		 => 'tabs',
				'default'        => '#ffbf36',
			),
			'star_size'  => array(
                'label'            => esc_html__('Size', 'et_builder'),
                'description'      => esc_html__('Control the size of the star by increasing or decreasing the font size.', 'et_builder'),
                'type'             => 'range',
                'option_category'  => 'layout',
                'tab_slug'         => 'advanced',
                'toggle_slug'      => 'rating_settings',
                'allowed_units'    => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'default'          => '16px',
                'default_unit'     => 'px',
                'default_on_front' => '',
                'range_settings'   => array(
                    'min'  => '1',
                    'max'  => '120',
                    'step' => '1',
                ),
                'mobile_options'   => true,
                'hover'            => 'tabs',
			),
			'review_image_margin' => array(
                'label'           => esc_html__('Image Margin', 'et_builder'),
                'type'            => 'custom_margin',
                'mobile_options'  => true,
                'hover'           => 'tabs',
                'allowed_units'   => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'margin_padding',
            ),
            'review_image_padding'=> array(
                'label'           => esc_html__('Image Padding', 'et_builder'),
                'type'            => 'custom_padding',
                'mobile_options'  => true,
                'hover'           => 'tabs',
                'allowed_units'   => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'margin_padding',
			),
			'review_title_margin' => array(
                'label'           => esc_html__('Title Margin', 'et_builder'),
                'type'            => 'custom_margin',
                'mobile_options'  => true,
                'hover'           => 'tabs',
                'allowed_units'   => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'margin_padding',
            ),
            'review_title_padding'=> array(
                'label'           => esc_html__('Title Padding', 'et_builder'),
                'type'            => 'custom_padding',
                'mobile_options'  => true,
                'hover'           => 'tabs',
                'allowed_units'   => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'margin_padding',
			),
			'review_position_margin' => array(
                'label'           => esc_html__('Position Margin', 'et_builder'),
                'type'            => 'custom_margin',
                'mobile_options'  => true,
                'hover'           => 'tabs',
                'allowed_units'   => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'margin_padding',
            ),
            'review_position_padding'=> array(
                'label'           => esc_html__('Position Padding', 'et_builder'),
                'type'            => 'custom_padding',
                'mobile_options'  => true,
                'hover'           => 'tabs',
                'allowed_units'   => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'margin_padding',
            ),
			'review_rating_margin' => array(
                'label'           => esc_html__('Rating Margin', 'et_builder'),
                'type'            => 'custom_margin',
                'mobile_options'  => true,
                'hover'           => 'tabs',
                'allowed_units'   => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'margin_padding',
            ),
            'review_rating_padding'=> array(
                'label'           => esc_html__('Rating Padding', 'et_builder'),
                'type'            => 'custom_padding',
                'mobile_options'  => true,
                'hover'           => 'tabs',
                'allowed_units'   => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'margin_padding',
			),
            'review_content_margin'=> array(
                'label'           => esc_html__('Content Margin', 'et_builder'),
                'type'            => 'custom_margin',
                'mobile_options'  => true,
                'hover'           => 'tabs',
                'allowed_units'   => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'margin_padding',
            ),
            'review_content_padding'=> array(
                'label'           => esc_html__('Content Padding', 'et_builder'),
                'type'            => 'custom_padding',
                'mobile_options'  => true,
                'hover'           => 'tabs',
                'allowed_units'   => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'margin_padding',
            ),
		);

		return $fields;
    }
    
	public function render( $attrs, $content, $render_slug ) {

        $multi_view 				           = et_pb_multi_view_options($this);

        // Rating Star Rendering
        $rating_scale 	= (int) $this->props['star_scale'];
        $rating			= (float) $this->props['star_rating'] > $rating_scale ? $rating_scale : $this->props['star_rating'];
        $render_stars = Common::render_stars($rating, $rating_scale);

        // Review Rating Alignment.
        $review_rating_alignment_classes = Common::get_alignment("review_rating_alignment", $this, "dnext");

		$number_rating 				= $this->props['star_rating'];

		$oder_class					= '%%order_class%% .dnext-star-rating i.divinext-star-full::before, %%order_class%% .dnext-star-rating i.divinext-star-1:before, %%order_class%% .dnext-star-rating i.divinext-star-2:before, %%order_class%% .dnext-star-rating i.divinext-star-3:before, %%order_class%% .dnext-star-rating i.divinext-star-4:before, %%order_class%% .dnext-star-rating i.divinext-star-5:before, %%order_class%% .dnext-star-rating i.divinext-star-6:before, %%order_class%% .dnext-star-rating i.divinext-star-7:before, %%order_class%% .dnext-star-rating i.divinext-star-8:before, %%order_class%% .dnext-star-rating i.divinext-star-9:before, %%order_class%% .dnext-star-rating i.divinext-star-10:before';
		// Star Color
		$rating_color_values = et_pb_responsive_options()->get_property_values($this->props, 'rating_color');
		et_pb_responsive_options()->generate_responsive_css($rating_color_values, '%%order_class%% .dnxte-review-numb-des i', 'color', $render_slug, '', 'color');
		
		// Star Color
		$rating_color_values = et_pb_responsive_options()->get_property_values($this->props, 'rating_color');
		et_pb_responsive_options()->generate_responsive_css($rating_color_values, $oder_class, 'color', $render_slug, '', 'color');
		
		// Star Text Color
		$rating_text_color_values = et_pb_responsive_options()->get_property_values($this->props, 'rating_text_color');
		et_pb_responsive_options()->generate_responsive_css($rating_text_color_values, '%%order_class%% .dnxte-review-numb-des', 'color', $render_slug, '', 'color');

		// Star Background Color
		$rating_bg_color_values = et_pb_responsive_options()->get_property_values($this->props, 'rating_bg_color');
		et_pb_responsive_options()->generate_responsive_css($rating_bg_color_values, '%%order_class%% .dnxte-review-numb-des', 'background-color', $render_slug, '', 'background-color');
		
		// Star Background Color
		$rating_bg_color_values = et_pb_responsive_options()->get_property_values($this->props, 'rating_bg_color');
		et_pb_responsive_options()->generate_responsive_css($rating_bg_color_values, '%%order_class%% .dnxte-review-social', 'background-color', $render_slug, '', 'background-color');


        // Image Width
        $reviewer_img_width             = $this->props['reviewer_img_width'];
        $reviewer_img_width_hover       = $this->get_hover_value('reviewer_img_width');
        $reviewer_img_width_tablet      = $this->props['reviewer_img_width_tablet'];
        $reviewer_img_width_phone       = $this->props['reviewer_img_width_phone'];
        $reviewer_img_width_last_edited = $this->props['reviewer_img_width_last_edited'];

        if ('' !== $reviewer_img_width) {
            $reviewer_img_width_responsive_active = et_pb_get_responsive_status($reviewer_img_width_last_edited);

            $reviewer_img_width_values = array(
                'desktop' => $reviewer_img_width,
                'tablet'  => $reviewer_img_width_responsive_active ? $reviewer_img_width_tablet : '',
                'phone'   => $reviewer_img_width_responsive_active ? $reviewer_img_width_phone : '',
            );
            $reviewer_img_width_selector = "%%order_class%% .dnxte-review-img img";
            et_pb_responsive_options()->generate_responsive_css($reviewer_img_width_values, $reviewer_img_width_selector, 'max-width', $render_slug);

            if (et_builder_is_hover_enabled('reviewer_img_width', $this->props)) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector'    => $this->add_hover_to_order_class('%%order_class%% .dnxte-review-img img'),
                    'declaration' => sprintf(
                        'max-width: %1$s;',
                        esc_html($reviewer_img_width_hover)
                    ),
                ));
            }
        }

  		// Number Star Size
		  $star_size			= $this->props['star_size'];
		  $star_size_values		= et_pb_responsive_options()->get_property_values( $this->props, 'star_size' );
		  $star_size_tablet		= isset( $star_size_values['tablet'] ) ? $star_size_values['tablet'] : '';
		  $star_size_phone		= isset( $star_size_values['phone'] ) ? $star_size_values['phone'] : '';
  
		  // Size
		  if ( '' !== $star_size ) {
			$star_size_style 		 	= sprintf( 'font-size: %1$s !important;', esc_attr( $star_size ) );
			$star_size_tablet_style 	= '' !== $star_size_tablet ? sprintf( 'font-size: %1$s !important;', esc_attr( $star_size_tablet ) ) : '';
			$star_size_phone_style  	= '' !== $star_size_phone ? sprintf( 'font-size: %1$s !important;', esc_attr( $star_size_phone ) ) : '';
			

			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnxte-review-numb-des .et-pb-icon, %%order_class%% .dnxte-review-numb-des .review-num, %%order_class%% .dnext-star-rating .et-pb-icon",
				'declaration' => $star_size_style,
			) );
			
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnxte-review-numb-des .et-pb-icon, %%order_class%% .dnxte-review-numb-des .review-num, %%order_class%% .dnext-star-rating .et-pb-icon",
				'declaration' => $star_size_tablet_style,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
			) );

			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnxte-review-numb-des .et-pb-icon, %%order_class%% .dnxte-review-numb-des .review-num, %%order_class%% .dnext-star-rating .et-pb-icon",
				'declaration' => $star_size_phone_style,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
			) );
		}

		$rating_bg_color_width				= $this->props['rating_bg_color_width'];
		$rating_bg_color_width_tablet		= $this->props['rating_bg_color_width_tablet'];
		$rating_bg_color_width_phone		= $this->props['rating_bg_color_width_phone'];
		$rating_bg_color_width_last_edited	= $this->props['rating_bg_color_width_last_edited'];

		if ( '' !== $rating_bg_color_width ) { 
			$rating_bg_color_width_style 		 	= sprintf( 'max-width: %1$s;', esc_attr( $rating_bg_color_width ) );
			$rating_bg_color_width_tablet_style 	= '' !== $rating_bg_color_width_tablet ? sprintf( 'max-width: %1$s;', esc_attr( $rating_bg_color_width_tablet ) ) : '';
			$rating_bg_color_width_phone_style  	= '' !== $rating_bg_color_width_phone ? sprintf( 'max-width: %1$s;', esc_attr( $rating_bg_color_width_phone ) ) : '';
			

			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnxte-review-social",
				'declaration' => $rating_bg_color_width_style,
			) );
			
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnxte-review-social",
				'declaration' => $rating_bg_color_width_tablet_style,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
			) );

			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => "%%order_class%% .dnxte-review-social",
				'declaration' => $rating_bg_color_width_phone_style,
				'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
			) );
		}


		$review_top 	= '';
        $review_left 	= '';
        $review_right 	= '';

        if ( 'review-left' === $this->props['reviewer_image_position'] ) {
            $review_left = $this->props['review_left'];

        } else if('review-right' === $this->props['reviewer_image_position']){
            $review_right = $this->props['review_right'];
        } else {
            $review_top = $this->props['review_top'];
        }

		if ("num" === $this->props['review_style'] ) {
			$stars_output = sprintf(
				'<div class="dnxte-review-numb-des">
					<span class="review-num">%1$s </span> 
					<i class="divinext-star-full et-pb-icon"></i>
				</div>',
				$number_rating
			);
		} else {
			$stars_output = '<div class="dnxte-review-social dnext-star-rating">' . $render_stars . '</div> ';
		}

        $reviewer_image = $this->props['reviewer_image'];
        $image_pathinfo = pathinfo( $reviewer_image );
		$is_image_svg   = isset( $image_pathinfo['extension'] ) ? 'svg' === $image_pathinfo['extension'] : false;
		
		//Image
		$dnext_reviewer_image = "";
		if ($multi_view->has_value('reviewer_image')) {
			$dnext_reviewer_image_classes = array(
				'dnxte-review-img',
				'dnxte-review-' . esc_attr( $review_top ),
			);

			$dnext_reviewer_image = $multi_view->render_element(array(
				'tag'     => 'div',
				'content' => $multi_view->render_element(array(
					'tag'   => 'img',
					'attrs' => array(
						'src' => '{{reviewer_image}}',
						'alt' => '{{reviewer_name}}',
					),
				)),
				'attrs'   => array(
					'class' => implode(' ', $dnext_reviewer_image_classes),
				),
				'classes' => array(
					'et-svg' => array(
						'reviewer_image' => true,
					),
				),
			) );
		}

		//Reviewer Name
		$reviewerName = $multi_view->render_element(array(
			'tag'     => et_pb_process_header_level($this->props['header_level'], 'h4'),
			'content' => '{{reviewer_name}}',
			'attrs'   => array(
				'class' => 'dnxte-review-header',
			),
		) );

		// Reviewer Postion
		$reviewer_position = $multi_view->render_element(array(
			'tag'     => 'p',
			'content' => '{{reviewer_position}}',
			'attrs'   => array(
				'class' => 'dnxte-review-pos',
			),
		) );

        $reviewer_description = "";
        if($this->props['reviewer_description']) {
            $reviewer_description = sprintf('<div class="dnxte-review-pra">%1$s</div>', $this->props['reviewer_description']);
        }

		$this->apply_css($render_slug);

		return sprintf( 
			'<div class="dnxte-review-wrap dnxte-review-%6$s dnxte-review-%8$s">
				%1$s
				<div class="dnxte-review-des">
					<div class="dnxte-review-wrapper">
						%2$s
						%3$s
                    </div>
                    <div class="dnxte-review-star %7$s">
                        %5$s
                    </div>
                    <div class="dnxte-review-content">
                        %4$s
                    </div>
				</div>
			</div>', 
			et_core_esc_previously( $dnext_reviewer_image ),
			et_core_esc_previously( $reviewerName ),
			et_core_esc_previously( $reviewer_position ),
			wpautop( et_core_esc_previously($reviewer_description) ),
			$stars_output, // #5
            esc_attr( $review_left ),
            esc_attr( $review_rating_alignment_classes ),
            esc_attr( $review_right )
		);
	}

	public function apply_css($render_slug) {
        /**
         * Custom Padding Margin Output
         *
         */

        Common::dnxt_set_style($render_slug, $this->props, "review_image_margin", "%%order_class%% .dnxte-review-img", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "review_image_padding", "%%order_class%% .dnxte-review-img", "padding");

		Common::dnxt_set_style($render_slug, $this->props, "review_title_margin", "%%order_class%% .dnxte-review-header", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "review_title_padding", "%%order_class%% .dnxte-review-header", "padding");
		
		Common::dnxt_set_style($render_slug, $this->props, "review_position_margin", "%%order_class%% .dnxte-review-pos", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "review_position_padding", "%%order_class%% .dnxte-review-pos", "padding");

        Common::dnxt_set_style($render_slug, $this->props, "review_rating_margin", "%%order_class%% .dnxte-review-social,%%order_class%% .dnxte-review-numb-des", "margin");
		Common::dnxt_set_style($render_slug, $this->props, "review_rating_padding", "%%order_class%% .dnxte-review-social,%%order_class%% .dnxte-review-numb-des", "padding");
		
		Common::dnxt_set_style($render_slug, $this->props, "review_content_margin", "%%order_class%% .dnxte-review-details", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "review_content_padding", "%%order_class%% .dnxte-review-details", "padding");

	}
	/**
     * Check if image has svg extension
     *
     * @param string $dnext_reviewer_image Image URL.
     *
     * @return bool
     */
    public function is_svg($dnext_reviewer_image) {
        if (!$dnext_reviewer_image) {
            return false;
        }

        $image_pathinfo = pathinfo($dnext_reviewer_image);

        return isset($image_pathinfo['extension']) ? 'svg' === $image_pathinfo['extension'] : false;
    }
}

new Next_Review;
