<?php
include_once(DIVI_ESSENTIAL_PATH.'/includes/modules/base/Common.php');

class Next_Blog_Slider extends ET_Builder_Module_Type_PostBased {

    public $slug = 'dnxte_blog_slider';
    public $vb_support = 'on';

    protected $module_credits = array(
        'module_uri' => 'https://www.diviessential.com/divi-post-carousel/',
        'author'     => 'Divi Next',
        'author_uri' => 'www.divinext.com',
    );

    public function init() {
        $this->name        = esc_html__('Next Post Carousel', 'dnxte-divi-essential');
        $this->icon_path   = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->folder_name = 'et_pb_divi_essential';
        
        $this->settings_modal_toggles = array(
            'general'  => array(
                'toggles' => array(
                    'main_content'            => esc_html__('Post Settings', 'dnxte-divi-essential'),
                    'elements'                => esc_html__('Elements', 'dnxte-divi-essential'),
                    'dnxte_slider_settings'   => esc_html__('Carousel Settings', 'dnxte-divi-essential'),
                    'dnxte_slider_navigation' => esc_html__( 'Navigation Settings', 'dnxte-divi-essential'),
                    'dnxte_slider_effects' => esc_html__( 'Effect Settings', 'dnxte-divi-essential'),
                ),
            ),
            'advanced' => array(
                'toggles' => array(
                    'image'      => esc_html__('Image', 'dnxte-divi-essential'),
                    'blog_item'  => esc_html__('Post Item', 'dnxte-divi-essential'),
                    'blog_texts' => array(
                        'title'             => esc_html__('Post Texts', 'dnxte-divi-essential'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles'       => array(
                            'title'  => array(
                                'name' => 'Title',
                            ),
                            'body'   => array(
                                'name' => 'Body',
                            )
                        ),
                    ),
                    'dnxte_category_settings'   => esc_html__('Category', 'dnxte-divi-essential'),
                    'dnxte_meta'   => esc_html__('Meta Alignment', 'dnxte-divi-essential'),
                    'dnxte_author_settings'   => esc_html__('Author', 'dnxte-divi-essential'),
                    'dnxte_date_settings'   => esc_html__('Date', 'dnxte-divi-essential'),
                    'dnxte_blogslider_arrow_settings' => esc_html__( 'Arrow Settings', 'dnxte-divi-essential'),
                    'dnxte_blogslider_color_settings' => esc_html__( 'Color Settings', 'dnxte-divi-essential'),
                ),
            ),
        );

        $this->advanced_fields = array(
            'button'         => array(
                'button' => array(
                    'label'         => esc_html__('Read More', 'dnxte-divi-essential'),
                    'css'           => array(
                        'main'      => "%%order_class%% .dnxte-readmore-link",
                        'important' => true,
                    ),
                    'use_alignment' => true,
                    'custom_button' => true,
                    'box_shadow'    => array(
                        'css' => array(
                            'main' => '%%order_class%% .dnxte-readmore-link',
                        ),
                    )
                ),
            ),
            'fonts'          => array(
                'header'     => array(
                    'label'        => esc_html__('Title', 'dnxte-divi-essential'),
                    'toggle_slug'  => 'blog_texts',
                    'sub_toggle'   => 'title',
                    'css'          => array(
                        'main'        => "%%order_class%% .dnxte-entry-title a",
                        'font'        => "%%order_class%% .dnxte-entry-title a",
                        'color'       => "%%order_class%% .dnxte-entry-title a",
                        'hover'       => "%%order_class%% .dnxte-entry-title:hover a",
                        'color_hover' => "%%order_class%% .dnxte-entry-title:hover a",
                        'important'   => 'all',
                    ),
                    'header_level' => array(
                        'default'          => 'h2',
                        'computed_affects' => array(
                            '__blogposts',
                        ),
                    ),
                ),
                'body_content'     => array(
                    'label'        => esc_html__('Description', 'dnxte-divi-essential'),
                    'toggle_slug'  => 'blog_texts',
                    'sub_toggle'   => 'body',
                    'css'          => array(
                        'main'        => "%%order_class%% .dnxte-blog-post-content",
                        'font'        => "%%order_class%% .dnxte-blog-post-content",
                        'color'       => "%%order_class%% .dnxte-blog-post-content",
                        'hover'       => "%%order_class%% .dnxte-blog-post-content:hover, %%order_class%% .dnxte-blog-post-content:hover",
                        'color_hover' => "%%order_class%% .dnxte-blog-post-content:hover",
                        'important'   => 'all',
                    ),
                ),
                'meta'     => array(
                    'label'        => esc_html__('Meta', 'dnxte-divi-essential'),
                    'toggle_slug'  => 'blog_texts',
                    'sub_toggle'   => 'body',
                    'css'          => array(
                        'main'        => "%%order_class%% .dnxte-blog-post-content",
                        'font'        => "%%order_class%% .dnxte-blog-post-content",
                        'color'       => "%%order_class%% .dnxte-blog-post-content",
                        'hover'       => "%%order_class%% .dnxte-blog-post-content:hover, %%order_class%% .dnxte-blog-post-content:hover",
                        'color_hover' => "%%order_class%% .dnxte-blog-post-content:hover",
                        'important'   => 'all',
                    ),
                ),
                'meta_text'     => array(
                    'label'        => esc_html__('Category', 'dnxte-divi-essential'),
                    'toggle_slug'  => 'dnxte_category_settings',
                    'css'          => array(
                        'main'        => "%%order_class%% .dnxte-blog-post-categories a",
                        'font'        => "%%order_class%% .dnxte-blog-post-categories a",
                        'color'       => "%%order_class%% .dnxte-blog-post-categories a",
                        'hover'       => "%%order_class%% .dnxte-blog-post-categories a:hover, %%order_class%% .dnxte-blog-post-categories a:hover",
                        'color_hover' => "%%order_class%% .dnxte-blog-post-categories a:hover",
                        'important'   => 'all',
                    ),
                ),
                'meta_author'     => array(
                    'label'        => esc_html__('Author', 'dnxte-divi-essential'),
                    'toggle_slug'  => 'dnxte_author_settings',
                    'css'          => array(
                        'main'        => "%%order_class%% .dnxte-authovcard, %%order_class%% .dnxte-authovcard a",
                        'font'        => "%%order_class%% .dnxte-authovcard, %%order_class%% .dnxte-authovcard a",
                        'color'       => "%%order_class%% .dnxte-authovcard, %%order_class%% .dnxte-authovcard a",
                        'hover'       => "%%order_class%% .dnxte-authovcard:hover, %%order_class%% .dnxte-authovcard .author a:hover",
                        'color_hover' => "%%order_class%% .dnxte-authovcard:hover,",
                        'important'   => 'all',
                    ),
                ),
                'meta_date'     => array(
                    'label'        => esc_html__('Date', 'dnxte-divi-essential'),
                    'toggle_slug'  => 'dnxte_date_settings',
                    'css'          => array(
                        'main'        => "%%order_class%% .dnxte-blog-published, %%order_class%% .dnxte-blog-post-date",
                        'font'        => "%%order_class%% .dnxte-blog-published, %%order_class%% .dnxte-blog-post-date",
                        'color'       => "%%order_class%% .dnxte-blog-published, %%order_class%% .dnxte-blog-post-date",
                        'hover'       => "%%order_class%% .dnxte-blog-published:hover, %%order_class%% .dnxte-blog-post-date:hover",
                        'color_hover' => "%%order_class%% .dnxte-blog-published:hover , %%order_class%% .dnxte-blog-post-date:hover",
                        'important'   => 'all',
                    ),
                ),
            ),
            'text'           => false,
            'background'     => array(
                'css' => array(
                    'main' => '%%order_class%%',
                ),
            ),
            'borders'        => array(
                'default'   => array(
                    'css'             => array(
                        'main' => array(
                            'border_radii'        => "%%order_class%% .et_pb_blog_grid .et_pb_post",
                            'border_styles'       => "%%order_class%% .et_pb_blog_grid .et_pb_post",
                            'border_styles_hover' => "%%order_class%% .et_pb_blog_grid .et_pb_post:hover",
                        ),
                    ),
                    'depends_on'      => array('fullwidth'),
                    'depends_show_if' => 'off',
                    'defaults'        => array(
                        'border_radii'  => 'on||||',
                        'border_styles' => array(
                            'width' => '1px',
                            'color' => '#d8d8d8',
                            'style' => 'solid',
                        ),
                    ),
                    'label_prefix'    => esc_html__('Grid Layout', 'et_builder'),
                ),
                'fullwidth' => array(
                    'css'             => array(
                        'main' => array(
                            'border_radii'  => "%%order_class%%:not(.et_pb_blog_grid_wrapper) .et_pb_post",
                            'border_styles' => "%%order_class%%:not(.et_pb_blog_grid_wrapper) .et_pb_post",
                        ),
                    ),
                    'depends_on'      => array('fullwidth'),
                    'depends_show_if' => 'on',
                    'defaults'        => array(
                        'border_radii'  => 'on||||',
                        'border_styles' => array(
                            'width' => '0px',
                            'color' => '#333333',
                            'style' => 'solid',
                        ),
                    ),
                ),
                'image'     => array(
                    'css'          => array(
                        'main' => array(
                            'border_radii'  => '%%order_class%% .swiper-slide .dnxte-post-thumb',
                            'border_styles' => '%%order_class%% .swiper-slide .dnxte-post-thumb',
                        ),
                    ),
                    'label_prefix' => esc_html__( 'Image', 'dnxte-divi-essential' ),
                    'tab_slug'     => 'advanced',
                    'toggle_slug'  => 'image',
                ),
                'category'     => array(
                    'css'          => array(
                        'main' => array(
                            'border_radii'  => '%%order_class%% .dnxte-blog-post-categories a',
                            'border_styles' => '%%order_class%% .dnxte-blog-post-categories a',
                        ),
                    ),
                    'label_prefix' => esc_html__( 'Category', 'dnxte-divi-essential' ),
                    'tab_slug'     => 'advanced',
                    'toggle_slug'  => 'dnxte_category_settings',
                ),
                'author'     => array(
                    'css'          => array(
                        'main' => array(
                            'border_radii'  => '%%order_class%% .dnxte-authovcard, %%order_class%% .dnxte-authovcard a',
                            'border_styles' => '%%order_class%% .dnxte-authovcard, %%order_class%% .dnxte-authovcard a',
                        ),
                    ),
                    'label_prefix' => esc_html__( 'Author', 'dnxte-divi-essential' ),
                    'tab_slug'     => 'advanced',
                    'toggle_slug'  => 'dnxte_author_settings',
                ),
                'date'     => array(
                    'css'          => array(
                        'main' => array(
                            'border_radii'  => '%%order_class%% .dnxte-blog-published',
                            'border_styles' => '%%order_class%% .dnxte-blog-published',
                        ),
                    ),
                    'label_prefix' => esc_html__( 'Date', 'dnxte-divi-essential' ),
                    'tab_slug'     => 'advanced',
                    'toggle_slug'  => 'dnxte_date_settings',
                ),
                'single_blog'     => array(
                    'css'          => array(
                        'main' => array(
                            'border_radii'  => '%%order_class%% .swiper-slide',
                            'border_styles' => '%%order_class%% .swiper-slide',
                        ),
                    ),
                    'label_prefix' => esc_html__( 'Post Item', 'dnxte-divi-essential' ),
                    'tab_slug'     => 'advanced',
                    'toggle_slug'  => 'blog_item',
                ),
                'arrow'     => array(
                    'css'          => array(
                        'main' => array(
                            'border_radii'  => '%%order_class%% .swiper-button-next, %%order_class%% .swiper-button-prev',
                            'border_styles' => '%%order_class%% .swiper-button-next, %%order_class%% .swiper-button-prev',
                        ),
                    ),
                    'label_prefix' => esc_html__( 'Arrow', 'dnxte-divi-essential' ),
                    'tab_slug'     => 'advanced',
                    'toggle_slug'  => 'dnxte_blogslider_arrow_settings',
                ),
            ),
            'box_shadow'     => array(
                'default' => array(
                    'css'               => array(
                        'main'    => '%%order_class%% .swiper-slide',
                        'overlay' => 'inset',
                    ),
                ),
                'image'   => array(
                    'label'             => esc_html__('Image Box Shadow', 'et_builder'),
                    'option_category'   => 'layout',
                    'tab_slug'          => 'advanced',
                    'toggle_slug'       => 'image',
                    'css'               => array(
                        'main'    => '%%order_class%% .swiper-slide .dnxte-post-thumb img.dnxte-blog-featured-image',
                        'overlay' => 'inset',
                    ),
                    'default_on_fronts' => array(
                        'color'    => '',
                        'position' => '',
                    ),
                ),
                'category'   => array(
                    'label'             => esc_html__('Category Box Shadow', 'et_builder'),
                    'option_category'   => 'layout',
                    'tab_slug'          => 'advanced',
                    'toggle_slug'       => 'dnxte_category_settings',
                    'css'               => array(
                        'main'    => '%%order_class%% .dnxte-blog-post-categories a',
                        'overlay' => 'inset',
                    ),
                    'default_on_fronts' => array(
                        'color'    => '',
                        'position' => '',
                    ),
                ),
                'author'   => array(
                    'label'             => esc_html__('Author Box Shadow', 'et_builder'),
                    'option_category'   => 'layout',
                    'tab_slug'          => 'advanced',
                    'toggle_slug'       => 'dnxte_author_settings',
                    'css'               => array(
                        'main'    => '%%order_class%% .dnxte-authovcard, %%order_class%% .dnxte-authovcard a',
                        'overlay' => 'inset',
                    ),
                    'default_on_fronts' => array(
                        'color'    => '',
                        'position' => '',
                    ),
                ),
                'date'   => array(
                    'label'             => esc_html__('Date Box Shadow', 'et_builder'),
                    'option_category'   => 'layout',
                    'tab_slug'          => 'advanced',
                    'toggle_slug'       => 'dnxte_date_settings',
                    'css'               => array(
                        'main'    => '%%order_class%% .dnxte-blog-published',
                        'overlay' => 'inset',
                    ),
                    'default_on_fronts' => array(
                        'color'    => '',
                        'position' => '',
                    ),
                ),
                'single_blog'   => array(
                    'label'             => esc_html__('Post Item Box Shadow', 'et_builder'),
                    'option_category'   => 'layout',
                    'tab_slug'          => 'advanced',
                    'toggle_slug'       => 'blog_item',
                    'css'               => array(
                        'main'    => '%%order_class%% .swiper-slide',
                        'overlay' => 'inset',
                    ),
                    'default_on_fronts' => array(
                        'color'    => '',
                        'position' => '',
                    ),
                ),
            ),
            'height'         => array(
                'css' => array(
                    'main' => '%%order_class%%',
                ),
            ),
            'margin_padding' => array(
                'css' => array(
                    'main'      => '%%order_class%%',
                    'important' => array('custom_margin'),
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
            'image'          => array(
                'css' => array(
                    'main' => '%%order_class%% .swiper-slide img.dnxte-blog-featured-image'
                ),
            ),
            'scroll_effects' => array(
                'grid_support' => 'yes',
            ),
        );

        $this->custom_css_fields = array(
            'content_wrapper'   => array(
                'label' => esc_html__('Content Wrapper', 'dnxte-divi-essential'),
                'selector' => '%%order_class%% .swiper-slide .dnxte-content-wrapper',
            ),
            'title'         => array(
                'label' => esc_html__('Title', 'dnxte-divi-essential'),
                'selector' => '%%order_class%% .swiper-slide .dnxte-entry-title',
            ),
            'image'         => array(
                'label' => esc_html__('Image', 'dnxte-divi-essential'),
                'selector' => '%%order_class%% .swiper-slide .dnxte-post-thumb',
            ),
            'author'         => array(
                'label' => esc_html__('Author', 'dnxte-divi-essential'),
                'selector' => '%%order_class%% .swiper-slide .dnxte-post-meta .author a',
            ),
            'date'         => array(
                'label' => esc_html__('Date', 'dnxte-divi-essential'),
                'selector' => '%%order_class%% .swiper-slide .dnxte-blog-published',
            ),
            'categories'         => array(
                'label' => esc_html__('Category', 'dnxte-divi-essential'),
                'selector' => '%%order_class%% .swiper-slide .dnxte-blog-post-categories a',
            ),
            'content'         => array(
                'label' => esc_html__('Content', 'dnxte-divi-essential'),
                'selector' => '%%order_class%% .swiper-slide .dnxte-blog-post-content',
            ),
            'button'         => array(
                'label' => esc_html__('Button', 'dnxte-divi-essential'),
                'selector' => '%%order_class%% .swiper-slide .dnxte-readmorewrapper a',
            )
        );
    }

    public function get_fields() {
        $fields = array(
            'blogslider_layouts'               => array(
				'label'            => esc_html__( 'Select Layout', 'dnxte-divi-essential' ),
				'description'      => esc_html__( 'Choose your posts layout.', 'dnxte-divi-essential' ),
				'type'             => 'select',
				'option_category'  => 'basic_option',
				'toggle_slug'      => 'main_content',
				'options'          => array(
					'one'           => esc_html__( 'Layout 1', 'dnxte-divi-essential' ),
					'six'           => esc_html__( 'Layout 2', 'dnxte-divi-essential' ),
					'seven'         => esc_html__( 'Layout 3', 'dnxte-divi-essential' ),
					'eight'         => esc_html__( 'Layout 4', 'dnxte-divi-essential' ),
					'two'           => esc_html__( 'Layout 5', 'dnxte-divi-essential' ),
					'three'         => esc_html__( 'Layout 6', 'dnxte-divi-essential' ),
					'four'          => esc_html__( 'Layout 7', 'dnxte-divi-essential' ),
					'five'          => esc_html__( 'Layout 8', 'dnxte-divi-essential' ),
				),
                'default'          => 'one',
				'default_on_front' => 'one',
				'computed_affects' => array( '__blogposts' ),
			),
            'post_type'            => array(
				'label'            => esc_html__( 'Post Type', 'et_builder' ),
				'type'             => 'select',
				'option_category'  => 'configuration',
				'options'          => et_get_registered_post_type_options( false, false ),
				'description'      => esc_html__( 'Choose posts of which post type you would like to display.', 'et_builder' ),
				'computed_affects' => array(
					'__blogposts',
				),
				'toggle_slug'      => 'main_content',
				'default'          => 'post',
			),
            'posts_number'       => array(
                'label'            => esc_html__('Post Count', 'dnxte-divi-essential'),
                'type'             => 'text',
                'option_category'  => 'configuration',
                'description'      => esc_html__('Choose how much posts you would like to display per page.', 'dnxte-divi-essential'),
                'computed_affects' => array(
                    '__blogposts',
                ),
                'toggle_slug'      => 'main_content',
                'default'          => 5,

            ),
            'posts_offset'       => array(
                'label'            => esc_html__('Post Offset', 'dnxte-divi-essential'),
                'type'             => 'text',
                'option_category'  => 'configuration',
                'description'      => esc_html__('Choose how many posts you would like to remove from first.', 'dnxte-divi-essential'),
                'computed_affects' => array(
                    '__blogposts',
                ),
                'toggle_slug'      => 'main_content',
                'default'          => 0,
            ),
            'include_categories' => array(
                'label'            => esc_html__('Included Categories', 'dnxte-divi-essential'),
                'type'             => 'categories',
                'meta_categories'  => array(
                    'all'     => esc_html__('All Categories', 'dnxte-divi-essential'),
                    'current' => esc_html__('Current Category', 'dnxte-divi-essential'),
                ),
                'option_category'  => 'basic_option',
                'renderer_options' => array(
                    'use_terms' => false,
                ),
                'description'      => esc_html__('Choose which categories you would like to include in the feed.', 'dnxte-divi-essential'),
                'toggle_slug'      => 'main_content',
                'show_if'          => array(
					'post_type'        => 'post',
				),
                'computed_affects' => array(
                    '__blogposts',
                ),
            ),
            'order_by'               => array(
				'label'            => esc_html__( 'Order By', 'dnxte-divi-essential' ),
				'description'      => esc_html__( 'Choose how your posts should be ordered.', 'dnxte-divi-essential' ),
				'type'             => 'select',
				'option_category'  => 'basic_option',
				'toggle_slug'      => 'main_content',
				'options'          => array(
					'date'   => esc_html__( 'Date', 'dnxte-divi-essential' ),
					'author' => esc_html__( 'Author', 'dnxte-divi-essential' ),
					'ID'     => esc_html__( 'ID', 'dnxte-divi-essential' ),
					'parent' => esc_html__( 'Parent', 'dnxte-divi-essential' ),
					'rand'   => esc_html__( 'Random', 'dnxte-divi-essential' ),
					'title'  => esc_html__( 'Title', 'dnxte-divi-essential' ),
				),
                'default'          => 'date',
				'default_on_front' => 'date',
				'computed_affects' => array( '__blogposts' ),
			),
			'order'                  => array(
				'label'            => esc_html__( 'Sorted By', 'dnxte-divi-essential' ),
				'description'      => esc_html__( 'Choose how your posts should be sorted.', 'dnxte-divi-essential' ),
				'type'             => 'select',
				'option_category'  => 'basic_option',
				'toggle_slug'      => 'main_content',
				'options'          => array(
					'ASC'  => esc_html__( 'Ascending', 'dnxte-divi-essential' ),
					'DESC' => esc_html__( 'Descending', 'dnxte-divi-essential' ),
				),
                'default'          => 'ASC',
				'default_on_front' => 'ASC',
				'computed_affects' => array( '__blogposts' ),
			),
            'show_thumbnail'     => array(
                'label'            => esc_html__('Show Featured Image', 'dnxte-divi-essential'),
                'type'             => 'yes_no_button',
                'option_category'  => 'configuration',
                'options'          => array(
                    'on'  => esc_html__('Yes', 'dnxte-divi-essential'),
                    'off' => esc_html__('No', 'dnxte-divi-essential'),
                ),
                'description'      => esc_html__('This will turn thumbnails on and off.', 'dnxte-divi-essential'),
                'toggle_slug'      => 'elements',
                'default_on_front' => 'on',
                'mobile_options'   => true,
                'hover'            => 'tabs',
            ),
            'dnxte_feaimage_thumb_size'             => array(
				'label'            => esc_html__( 'Featured Image Size', 'dnxte-divi-essential' ),
				'description'      => esc_html__( 'Different featured image size. If you use custom, the most appropriate image size will be displayed.', 'dnxte-divi-essential' ),
				'type'             => 'select',
				'option_category'  => 'configuration',
				'toggle_slug'      => 'elements',
				'default'          => 'full',
				'options'          => array(
					'thumbnail' => esc_html__( 'Thumbnail (150px x 150px)', 'dnxte-divi-essential' ),
					'medium'    => esc_html__( 'Medium (300px x 300px)', 'dnxte-divi-essential' ),
					'large'     => esc_html__( 'Large (1024px x 1024px)', 'dnxte-divi-essential' ),
					'full'      => esc_html__( 'Full (Original Image)', 'dnxte-divi-essential' ),
					'custom'    => esc_html__( 'Custom', 'dnxte-divi-essential' ),
				),
				'default_on_front' => 'full',
				'show_if'          => array(
                    'show_thumbnail' => 'on',
				),
                'computed_affects' => array( '__blogposts' ),
			),
            'thumb_width'            => array(
				'label'            => esc_html__( 'Featured Image Width', 'brain-divi-blog' ),
				'type'             => 'range',
				'default'          => '100',
				'unitless'         => true,
				'range_settings'   => array(
					'min'  => 0,
					'step' => 1,
					'max'  => 400,
				),
				'toggle_slug'      => 'elements',
				'computed_affects' => array( '__blogposts' ),
				'show_if'          => array(
					'show_thumbnail' => 'on',
					'dnxte_feaimage_thumb_size' => 'custom',
				),
			),
			'thumb_height'           => array(
				'label'            => esc_html__( 'Featured Image Height', 'brain-divi-blog' ),
				'type'             => 'range',
				'default'          => '100',
				'unitless'         => true,
				'range_settings'   => array(
					'min'  => 0,
					'step' => 1,
					'max'  => 400,
				),
				'toggle_slug'      => 'elements',
				'computed_affects' => array( '__blogposts' ),
				'show_if'          => array(
					'show_thumbnail' => 'on',
					'dnxte_feaimage_thumb_size' => 'custom',
				),
			),
            'show_author'        => array(
                'label'            => esc_html__('Show Author', 'dnxte-divi-essential'),
                'type'             => 'yes_no_button',
                'option_category'  => 'configuration',
                'options'          => array(
                    'on'  => esc_html__('Yes', 'dnxte-divi-essential' ),
                    'off' => esc_html__('No', 'dnxte-divi-essential' ),
                ),
                'description'      => esc_html__('Turn on or off the author link.', 'dnxte-divi-essential'),
                'toggle_slug'      => 'elements',
                'default_on_front' => 'on',
                'mobile_options'   => true,
                'hover'            => 'tabs',
            ),
            'date_position'       => array(
                'label'           => esc_html__('Date Position', 'dnxte-divi-essential'),
                'type'            => 'select',
                'option_category' => 'basic_option',
                'options'         => array(
                    "none"        => esc_html__( 'None', 'dnxte-divi-essential' ),  
                    "top"         => esc_html__( 'Top',  'dnxte-divi-essential' ),
                    'bottom'      => esc_html__( 'Bottom',  'dnxte-divi-essential' ),
                ),
                'default'     => 'bottom',
                'toggle_slug' => 'elements',
                'show_if_not'  => array(
                    'blogslider_layouts'    => array(
                        'six',
                        'seven',
                        'eight',
                        'nine',
                    )
                )
            ),
            'show_date'    => array(
                'label'            => esc_html__('Show Date', 'dnxte-divi-essential'),
                'type'             => 'yes_no_button',
                'option_category'  => 'configuration',
                'options'          => array(
                    'on'  => esc_html__('Yes', 'dnxte-divi-essential'),
                    'off' => esc_html__('No', 'dnxte-divi-essential'),
                ),
                'description'      => esc_html__('Turn the category links on or off.', 'dnxte-divi-essential'),
                'toggle_slug'      => 'elements',
                'default_on_front' => 'on',
                'mobile_options'   => true,
                'hover'            => 'tabs',
                'show_if'      => array(
                    'blogslider_layouts'    => array(
                        'six',
                        'seven',
                        'eight',
                        'nine',
                    )
                )
            ),
            'show_categories'    => array(
                'label'            => esc_html__('Show Categories', 'dnxte-divi-essential'),
                'type'             => 'yes_no_button',
                'option_category'  => 'configuration',
                'options'          => array(
                    'on'  => esc_html__('Yes', 'dnxte-divi-essential'),
                    'off' => esc_html__('No', 'dnxte-divi-essential'),
                ),
                'description'      => esc_html__('Turn the category links on or off.', 'dnxte-divi-essential'),
                'toggle_slug'      => 'elements',
                'default' => 'off',
                'default_on_front' => 'off',
                'mobile_options'   => true,
                'hover'            => 'tabs',
                'show_if_not'      => array(
                    'blogslider_layouts'    => array(
                        'six',
                        'seven'
                    )
                )
            ),
            'show_excerpt'       => array(
                'label'            => esc_html__('Show Excerpt', 'dnxte-divi-essential'),
                'description'      => esc_html__('Turn excerpt on and off.', 'dnxte-divi-essential'),
                'type'             => 'yes_no_button',
                'options'          => array(
                    'on'  => esc_html__('Yes', 'dnxte-divi-essential'),
                    'off' => esc_html__('No', 'dnxte-divi-essential'),
                ),
                'default_on_front' => 'on',
                'depends_show_if'  => 'off',
                'toggle_slug'      => 'elements',
                'option_category'  => 'configuration',
                'mobile_options'   => true,
                'hover'            => 'tabs',
            ),
            'excerpt_length'     => array(
                'label'            => esc_html__('Excerpt Length', 'dnxte-divi-essential'),
                'description'      => esc_html__('Define the length of automatically generated excerpts. Leave blank for default ( 270 ) ', 'dnxte-divi-essential'),
                'type'             => 'text',
                'default'          => '12',
                // 'depends_show_if'  => 'off',
                'toggle_slug'      => 'main_content',
                'option_category'  => 'configuration',
            ),
            'show_more'          => array(
                'label'            => esc_html__('Show Read More Button', 'dnxte-divi-essential'),
                'type'             => 'yes_no_button',
                'option_category'  => 'configuration',
                'options'          => array(
                    'off' => esc_html__('No', 'dnxte-divi-essential'),
                    'on'  => esc_html__('Yes', 'dnxte-divi-essential'),
                ),
                'depends_show_if'  => 'off',
                'description'      => esc_html__('Here you can define whether to show "read more" link after the excerpts or not.', 'dnxte-divi-essential'),
                'toggle_slug'      => 'elements',
                'default_on_front' => 'off',
                'mobile_options'   => true,
                'hover'            => 'tabs',
            ),
            'show_more_text'     => array(
                'label'            => esc_html__('Read More Text', 'dnxte-divi-essential'),
                'type'             => 'text',
                'default'          => 'Read More',
                'show_if'          => array(
                    'show_more' => 'on',
                ),
                'toggle_slug'      => 'elements',
            ),
            'dnxte_blogslider_auto_height' => array(
                'label'           => esc_html__( 'Auto Height', 'dnxte-divi-essential'),
                'type'            => 'yes_no_button',
                'description'     => esc_html__( 'Content entered here will appear inside the module.', 'dnxte-divi-essential' ),                                                
                'options'               => array(
                    'on'  => esc_html__( 'Yes', 'dnxte-divi-essential' ),
                    'off' => esc_html__( 'No', 'dnxte-divi-essential' ),
                ),
                'default'          => 'off',
                'default_on_front' => 'off',
                'toggle_slug'      => 'dnxte_slider_settings'
            ),
            'is_equal_height'       => array(
				'label'           => esc_html__( 'Equalize Item Height', 'dnxte-divi-essential' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'description'     => esc_html__( 'Enable this to Equalize Carousel items with same height.', 'dnxte-divi-essential' ),
				'options'         => array(
					'on'  => esc_html__( 'Yes', 'dnxte-divi-essential' ),
					'off' => esc_html__( 'No', 'dnxte-divi-essential' ),
				),
				'default'         => 'on',
				'toggle_slug'     => 'dnxte_slider_settings',
            ),
            'dnxte_blogslider_speed'   => array(
                'label'           => esc_html__( 'Speed', 'dnxte-divi-essential' ),
                'type'            => 'range',
                'option_category'=> 'basic_option',
                'range_settings'  => array(
                    'step' => 1,
                    'min'  => 1,
                    'max'  => 1000,
                ),
                'default'         => '400',
                'fixed_unit'      => '',
                'validate_unit'   => false,
                'unitless'        => true,
                'toggle_slug'      => 'dnxte_slider_settings'
            ),
            'dnxte_blogslider_centered_slides' => array(
                'label'           => esc_html__( 'Center slide', 'dnxte-divi-essential'),
                'type'            => 'yes_no_button',
                'description'     => esc_html__( 'Content entered here will appear inside the module.', 'dnxte-divi-essential' ),                                                
                'options'               => array(
                    'on'  => esc_html__( 'Yes', 'dnxte-divi-essential' ),
                    'off' => esc_html__( 'No', 'dnxte-divi-essential' ),
                ),
                'default'          => 'off',
                'toggle_slug'      => 'dnxte_slider_settings'
            ),
            'dnxte_blogslider_autoplay_show_hide' => array(
                'label'           => esc_html__( 'Autoplay', 'dnxte-divi-essential'),
                'type'            => 'yes_no_button',
                'description'     => esc_html__( 'Content entered here will appear inside the module.', 'dnxte-divi-essential' ),                                                
                'options'               => array(
                    'on'  => esc_html__( 'Yes', 'dnxte-divi-essential' ),
                    'off' => esc_html__( 'No', 'dnxte-divi-essential' ),
                ),
                'affects'         => array(
                    'dnxte_blogslider_autoplay_delay',
                ),
                'default'          => 'off',
                'default_on_front' => 'off',
                'toggle_slug'      => 'dnxte_slider_settings'
            ),
            'dnxte_blogslider_autoplay_delay' => array(
                'label'           => esc_html__('Autoplay Delay', 'dnxte-divi-essential'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'description'     => esc_html__( 'Adjust the autoplay delay in milliseconds (ms)', 'dnxte-divi-essential' ),                
                'default'         =>'5000',
                'depends_show_if' => 'on',
                'toggle_slug'      => 'dnxte_slider_settings'
            ),
            'dnxte_blogslider_breakpoint_desktop' => array(
                'label'           => esc_html__('Slides Per View', 'dnxte-divi-essential'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'description'     => esc_html__( 'Content entered here will appear inside the module.', 'dnxte-divi-essential' ),
                'default'         => '3',
                'default_on_front' => '3',
                'mobile_options'   => true,
				'responsive'       => true,
                'toggle_slug'      => 'dnxte_slider_settings'
            ),
            'dnxte_blogslider_spacebetween'   => array(
                'label'           => esc_html__( 'Space Between', 'dnxte-divi-essential' ),
                'type'            => 'range',
                'option_category'=> 'basic_option',
                'range_settings'  => array(
                    'step' => 1,
                    'min'  => 0,
                    'max'  => 300,
                ),
                'default'         => '15',
                'fixed_unit'      => '',
                'validate_unit'   => false,
                'unitless'        => true,
                'mobile_options'   => true,
				'responsive'       => true,
                'toggle_slug'      => 'dnxte_slider_settings'
            ),
            'dnxte_blogslider_grab' => array(
                'label'           => esc_html__( 'Use Grab Cursor', 'dnxte-divi-essential'),
                'type'            => 'yes_no_button',
                'description'     => esc_html__( 'Select on or off to control grab cursor', 'dnxte-divi-essential' ),                                                
                'options'               => array(
                    'on'  => esc_html__( 'Yes', 'dnxte-divi-essential' ),
                    'off' => esc_html__( 'No', 'dnxte-divi-essential' ),
                ),
                'default'          => 'on',
                'default_on_front' => 'on',
                'toggle_slug'      => 'dnxte_slider_settings'
            ),
            'dnxte_blogslider_loop' => array(
                'label'       => esc_html__( 'Loop', 'dnxte-divi-essential'),
                'type'        => 'yes_no_button',
                'description' => esc_html__( 'Content entered here will appear inside the module.', 'dnxte-divi-essential' ),
                'options'     => array(
                    'on'  => esc_html__( 'Yes', 'dnxte-divi-essential' ),
                    'off' => esc_html__( 'No', 'dnxte-divi-essential' ),
                ),
                'default'          => 'off',
                'default_on_front' => 'off',
                'toggle_slug'      => 'dnxte_slider_settings'
            ),
            'dnxte_blogslider_pause_on_hover' => array(
                'label' => esc_html__('Pause On Hover', 'dnxte-divi-essential'),
                'type' => 'yes_no_button',
                'description' => esc_html__('Content entered here will appear inside the module.', 'dnxte-divi-essential'),
                'options' => array(
                    'on' => esc_html__('Yes', 'dnxte-divi-essential'),
                    'off' => esc_html__('No', 'dnxte-divi-essential'),
                ),
                'default' => 'off',
                'default_on_front' => 'off',
                'toggle_slug' => 'dnxte_slider_settings',
            ),
            'dnxte_blogslider_pagination_type'    => array(
                'label'           => esc_html__('Type', 'dnxte-divi-essential'),
                'type'            => 'select',
                'option_category' => 'basic_option',
                'options'         => array(
                    "none"        => esc_html__( 'None',  'dnxte-divi-essential' ),
                    'bullets'     => esc_html__( 'Bullets',  'dnxte-divi-essential' ),
                    'fraction'    => esc_html__( 'Fraction', 'dnxte-divi-essential' ),
                    'progressbar' => esc_html__( 'Progress Bar', 'dnxte-divi-essential' ),
                ),
                'default'     => 'bullets',
                'toggle_slug' => 'dnxte_slider_navigation'
            ),
            'dnxte_blogslider_pagination_bullets' => array(
                'label'       => esc_html__( 'Dynamic Bullets', 'dnxte-divi-essential'),
                'type'        => 'yes_no_button',
                'description' => esc_html__( 'Content entered here will appear inside the module.', 'dnxte-divi-essential' ),
                'options'     => array(
                    'on'  => esc_html__( 'Yes', 'dnxte-divi-essential' ),
                    'off' => esc_html__( 'No', 'dnxte-divi-essential' ),
                ),
                'default_on_front' => 'on',
                'toggle_slug'      => 'dnxte_slider_navigation',
                'show_if'          => array(
                    'dnxte_blogslider_pagination_type' => 'bullets'
                ),
            ),
            'dnxte_blogslider_pagination_clickable' => array(
                'label'       => esc_html__( 'Pagination Clickable', 'dnxte-divi-essential'),
                'type'        => 'yes_no_button',
                'description' => esc_html__( 'Pagination Clickable Buttong', 'dnxte-divi-essential' ),
                'options'     => array(
                    'on'  => esc_html__( 'Yes', 'dnxte-divi-essential' ),
                    'off' => esc_html__( 'No', 'dnxte-divi-essential' ),
                ),
                'default_on_front' => 'on',
                'toggle_slug'      => 'dnxte_slider_navigation',
                'show_if'          => array(
                    'dnxte_blogslider_pagination_type' => 'bullets'
                ),
            ),
            'dnxte_blogslider_keyboard_enable' => array(
                'label'           => esc_html__( 'Keyboard Navigation', 'dnxte-divi-essential'),
                'type'            => 'yes_no_button',
                'description'     => esc_html__( 'Select on or off to control keyboard navigation.', 'dnxte-divi-essential' ),                                                
                'options'               => array(
                    'on'  => esc_html__( 'Yes', 'dnxte-divi-essential' ),
                    'off' => esc_html__( 'No', 'dnxte-divi-essential' ),
                ),
                'default'          => 'on',
                'default_on_front' => 'on',
                'toggle_slug'      => 'dnxte_slider_navigation'
            ),
            'dnxte_blogslider_mousewheel_enable' => array(
                'label'           => esc_html__( 'Mousewheel Navigation', 'dnxte-divi-essential'),
                'type'            => 'yes_no_button',
                'description'     => esc_html__( 'Select on or off to control slide using mousewheel.', 'dnxte-divi-essential' ),                                                
                'options'               => array(
                    'on'  => esc_html__( 'Yes', 'dnxte-divi-essential' ),
                    'off' => esc_html__( 'No', 'dnxte-divi-essential' ),
                ),
                'default'          => 'on',
                'default_on_front' => 'on',
                'toggle_slug'      => 'dnxte_slider_navigation'
            ),
            'dnxte_blogslider_arrows' => array(
                'label'           => esc_html__( 'Use Arrow Navigation', 'dnxte-divi-essential'),
                'type'            => 'yes_no_button',
                'description'     => esc_html__( 'Content entered here will appear inside the module.', 'dnxte-divi-essential' ),                                                
                'options'               => array(
                    'on'  => esc_html__( 'Yes', 'dnxte-divi-essential' ),
                    'off' => esc_html__( 'No', 'dnxte-divi-essential' ),
                ),
                'default'          => 'on',
                'default_on_front' => 'on',
                'toggle_slug'      => 'dnxte_slider_navigation',
            ),
            'dnxte_blogslider_slide_shadows' => array(
                'label'           => esc_html__( 'Use Slide Shadows', 'et_builder'),
                'type'            => 'yes_no_button',
                'description'     => esc_html__( 'Content entered here will appear inside the module.', 'et_builder' ),                                                
                'options'               => array(
                    'on'  => esc_html__( 'Yes', 'et_builder' ),
                    'off' => esc_html__( 'No', 'et_builder' ),
                ),
                'default'         => 'off',
                'default_on_front' => 'off',
                'toggle_slug'      => 'dnxte_slider_effects',
            ),
            'dnxte_blogslider_slide_rotate'   => array(
                'label'           => esc_html__( 'Slide Rotate', 'et_builder' ),
                'type'            => 'range',
                'option_category'=> 'basic_option',
                'range_settings'  => array(
                    'step' => 1,
                    'min'  => 1,
                    'max'  => 1000,
                ),
                'default'         => '0',
                'fixed_unit'      => '',
                'validate_unit'   => false,
                'unitless'        => true,
                'toggle_slug'      => 'dnxte_slider_effects'
            ),
            'dnxte_blogslider_slide_stretch'   => array(
                'label'           => esc_html__( 'Slide Stretch', 'et_builder' ),
                'type'            => 'range',
                'option_category'=> 'basic_option',
                'range_settings'  => array(
                    'step' => 1,
                    'min'  => 1,
                    'max'  => 1000,
                ),
                'default'         => '0',
                'fixed_unit'      => '',
                'validate_unit'   => false,
                'unitless'        => true,
                'toggle_slug'      => 'dnxte_slider_effects'
            ),
            'dnxte_blogslider_slide_depth'   => array(
                'label'           => esc_html__( 'Slide Depth', 'et_builder' ),
                'type'            => 'range',
                'option_category'=> 'basic_option',
                'range_settings'  => array(
                    'step' => 1,
                    'min'  => 1,
                    'max'  => 1000,
                ),
                'default'         => '0',
                'fixed_unit'      => '',
                'validate_unit'   => false,
                'unitless'        => true,
                'toggle_slug'      => 'dnxte_slider_effects'
            ),
            'dnxte_blogslider_image_width'   => array(
                'label'           => esc_html__( 'Image Width', 'dnxte-divi-essential' ),
                'type'            => 'range',
                'option_category'=> 'basic_option',
                'range_settings'  => array(
                    'step' => 1,
                    'min'  => 1,
                    'max'  => 100,
                ),
                'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'default'         => '100%',
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'image',
                'responsive'      => true,
            ),
            'dnxte_blogslider_image_height'   => array(
                'label'           => esc_html__( 'Image Height', 'dnxte-divi-essential' ),
                'type'            => 'range',
                'option_category'=> 'basic_option',
                'range_settings'  => array(
                    'step' => 1,
                    'min'  => 1,
                    'max'  => 1000,
                ),
                'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'default'         => '300px',
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'image',
                'responsive'      => true,
            ),
            'dnxte_blogslider_arrow_size'   => array(
                'label'           => esc_html__( 'Font Size', 'dnxte-divi-essential' ),
                'type'            => 'range',
                'option_category'=> 'basic_option',
                'range_settings'  => array(
                    'step' => 1,
                    'min'  => 1,
                    'max'  => 100,
                ),
                'default'         => '30',
                'fixed_unit'      => '',
                'validate_unit'   => false,
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'dnxte_blogslider_arrow_settings'
            ),
            'dnxte_blogslider_arrow_position'   => array(
				'label'           => esc_html__( 'Arrow Position', 'dnxte-divi-essential'),
				'type'            => 'select',
				'description'     => esc_html__( 'Select the types of arrow position', 'dnxte-divi-essential'),
				'option_category' => 'basic_option',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dnxte_blogslider_arrow_settings',
				'options'       	            => array(
                    'default'                   => esc_html__(	'Default', 'dnxte-divi-essential' ),
					'inner'                     => esc_html__(	'Inner', 'dnxte-divi-essential' ),
					'outer'                     => esc_html__(	'Outer', 'dnxte-divi-essential' ),
					'top-left'                  => esc_html__(	'Top Left', 'dnxte-divi-essential' ),
					'top-center'                => esc_html__(	'Top Center', 'dnxte-divi-essential' ),
					'top-right'                 => esc_html__(	'Top Right', 'dnxte-divi-essential' ),
					'bottom-left'               => esc_html__(	'Bottom Left', 'dnxte-divi-essential' ),
					'bottom-center'             => esc_html__(	'Bottom Center', 'dnxte-divi-essential' ),
					'bottom-right'              => esc_html__(	'Bottom Right', 'dnxte-divi-essential' )

				),
				'default' => 'default',
            ),
            'dnxte_blogslide_arrow_color' => array(
                'label'        => esc_html__( 'Arrow Color', 'dnxte-divi-essential' ),
				'type'         => 'color-alpha',
				'custom_color' => true,
                'default'      => '#0c71c3',
                'tab_slug'     => 'advanced',
                'mobile_options'   => true,
				'responsive'       => true,
                'toggle_slug'  => 'dnxte_blogslider_color_settings',
            ),
            'dnxte_blogslide_arrow_bg_color' => array(
                'label'        => esc_html__( 'Arrow Background Color', 'dnxte-divi-essential' ),
				'type'         => 'color-alpha',
				'custom_color' => true,
                'default'      => '#fff',
                'tab_slug'     => 'advanced',
                'mobile_options'   => true,
				'responsive'       => true,
                'toggle_slug'  => 'dnxte_blogslider_color_settings',
            ),
            'dnxte_blogslider_dots_color' => array(
                'label'        => esc_html__( 'Dots Color', 'dnxte-divi-essential' ),
				'type'         => 'color-alpha',
				'custom_color' => true,
                'default'      => '#000',
                'mobile_options'   => true,
				'responsive'       => true,
                'tab_slug'     => 'advanced',
                'toggle_slug'  => 'dnxte_blogslider_color_settings',
                'show_if'      => array(
                    'dnxte_blogslider_pagination_type' => 'bullets'
                ),
            ),
            'dnxte_blogslider_dots_active_color' => array(
                'label'        => esc_html__( 'Dots Active Color', 'dnxte-divi-essential' ),
				'type'         => 'color-alpha',
				'custom_color' => true,
                'default'      => '#0c71c3',
                'mobile_options'   => true,
				'responsive'       => true,
                'tab_slug'     => 'advanced',
                'toggle_slug'  => 'dnxte_blogslider_color_settings',
                'show_if'      => array(
                    'dnxte_blogslider_pagination_type' => 'bullets'
                ),
            ),
            'dnxte_blogslider_progressbar_fill_color' => array(
                'label'        => esc_html__( 'Progressbar Fill Color', 'dnxte-divi-essential' ),
				'type'         => 'color-alpha',
				'custom_color' => true,
                'default'      => '#0c71c3',
                'mobile_options'   => true,
				'responsive'       => true,
                'tab_slug'     => 'advanced',
                'toggle_slug'  => 'dnxte_blogslider_color_settings',
                'show_if'      => array(
                    'dnxte_blogslider_pagination_type' => 'progressbar'
                )
            ),
            'dnxte_blogslider_date_icon_color' => array(
                'label'        => esc_html__( 'Date Icon Color', 'dnxte-divi-essential' ),
				'type'         => 'color-alpha',
				'custom_color' => true,
                'mobile_options'   => true,
				'responsive'       => true,
                'tab_slug'     => 'advanced',
                'toggle_slug'  => 'dnxte_blogslider_color_settings',
                'show_if'      => array(
                    'show_date' => 'on',
                    'date_position' => array('top','bottom')
                )
            ),
            'dnxte_blogslider_category_icon_color' => array(
                'label'        => esc_html__( 'Category Icon Color', 'dnxte-divi-essential' ),
				'type'         => 'color-alpha',
				'custom_color' => true,
                'mobile_options'   => true,
				'responsive'       => true,
                'tab_slug'     => 'advanced',
                'toggle_slug'  => 'dnxte_blogslider_color_settings',
                'show_if'      => array(
                    'show_categories' => 'on'
                )
            ),
            'dnxte_blogslider_title_margin'	=> array(
				'label'           		=> esc_html__('Title Margin', 'dnxte-divi-essential'),
                'type'            		=> 'custom_margin',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding', 
            ),
            'dnxte_blogslider_title_padding'	=> array(
				'label'           		=> esc_html__('Title Padding', 'dnxte-divi-essential'),
                'type'            		=> 'custom_padding',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding', 
            ),
            'dnxte_blogslider_title_margin'	=> array(
				'label'           		=> esc_html__('Title Margin', 'dnxte-divi-essential'),
                'type'            		=> 'custom_margin',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding', 
            ),
            'dnxte_blogslider_content_wrapper_margin'	=> array(
				'label'           		=> esc_html__('Content Wrapper Margin', 'dnxte-divi-essential'),
                'type'            		=> 'custom_margin',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding', 
            ),
            'dnxte_blogslider_content_wrapper_padding'	=> array(
				'label'           		=> esc_html__('Content Wrapper Padding', 'dnxte-divi-essential'),
                'type'            		=> 'custom_padding',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding', 
            ),
            'dnxte_blogslider_content_margin'	=> array(
				'label'           		=> esc_html__('Content Margin', 'dnxte-divi-essential'),
                'type'            		=> 'custom_margin',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding', 
            ),
            'dnxte_blogslider_content_padding'	=> array(
				'label'           		=> esc_html__('Content Padding', 'dnxte-divi-essential'),
                'type'            		=> 'custom_padding',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding', 
            ),
            'dnxte_blogslider_img_margin'	=> array(
				'label'           		=> esc_html__('Image Margin', 'dnxte-divi-essential'),
                'type'            		=> 'custom_margin',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding', 
            ),
            'dnxte_blogslider_img_padding'	=> array(
				'label'           		=> esc_html__('Image Padding', 'dnxte-divi-essential'),
                'type'            		=> 'custom_padding',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding', 
            ),
            'dnxte_blogslider_auth_margin'	=> array(
				'label'           		=> esc_html__('Author Margin', 'dnxte-divi-essential'),
                'type'            		=> 'custom_margin',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding', 
            ),
            'dnxte_blogslider_auth_padding'	=> array(
				'label'           		=> esc_html__('Author Padding', 'dnxte-divi-essential'),
                'type'            		=> 'custom_padding',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding', 
            ),
            'dnxte_blogslider_date_margin'	=> array(
				'label'           		=> esc_html__('Date Margin', 'dnxte-divi-essential'),
                'type'            		=> 'custom_margin',
                'default'               => '0|10px|0|10px',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding', 
            ),
            'dnxte_blogslider_date_padding'	=> array(
				'label'           		=> esc_html__('Date Padding', 'dnxte-divi-essential'),
                'type'            		=> 'custom_padding',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding', 
            ),
            'dnxte_blogslider_categories_margin'	=> array(
				'label'           		=> esc_html__('Categories Margin', 'dnxte-divi-essential'),
                'type'            		=> 'custom_margin',
                'default'               => '0|0|0|10px',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding', 
            ),
            'dnxte_blogslider_categories_padding'	=> array(
				'label'           		=> esc_html__('Categories Padding', 'dnxte-divi-essential'),
                'type'            		=> 'custom_padding',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding', 
            ),
            'dnxte_blogslider_arrow_margin'	=> array(
				'label'           		=> esc_html__('Arrow Margin', 'dnxte-divi-essential'),
                'type'            		=> 'custom_padding',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding', 
            ),
            'dnxte_blogslider_arrow_padding'	=> array(
				'label'           		=> esc_html__('Arrow Padding', 'dnxte-divi-essential'),
                'type'            		=> 'custom_padding',
                'mobile_options'  		=> true,
				'hover'           		=> 'tabs',
				'allowed_units'   		=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
                'default'               => '30px|15px|30px|15px',
                'option_category' 		=> 'layout',
                'tab_slug'        		=> 'advanced',
				'toggle_slug'     		=> 'margin_padding', 
            ),
            'dnxte_meta_alignment'=> array(
				'label'            => esc_html__( 'Meta Texts Alignment', 'et_builder' ),
				'description'      => esc_html__( 'Align your meta text to the left, right or center of the module.', 'et_builder' ),
				'type'             => 'text_align',
				'option_category'  => 'layout',
				'options'          => et_builder_get_text_orientation_options( array('justified') ),
				'tab_slug'         => 'advanced',
				'toggle_slug'      => 'dnxte_meta',
				'mobile_options'   => true,
				'description'      => esc_html__( 'Here you can define the alignment of Meta Texts', 'et_builder' ),
			),
            'show_underline_on_title_hover'     => array(
                'label'            => esc_html__('Show Underline on Hover', 'dnxte-divi-essential'),
                'type'             => 'yes_no_button',
                'option_category'  => 'configuration',
                'options'          => array(
                    'on'  => esc_html__('Yes', 'dnxte-divi-essential'),
                    'off' => esc_html__('No', 'dnxte-divi-essential'),
                ),
                'description'      => esc_html__('This will turn underline title on and off.', 'dnxte-divi-essential'),
                'tab_slug'        		=> 'advanced',
                'toggle_slug'      => 'blog_texts',
                'sub_toggle'	  => 'title',
                'default_on_front' => 'off',
            ),
            '__blogposts'        => array(
                'type'                => 'computed',
                'computed_callback'   => array('Next_Blog_Slider', 'get_blog_posts'),
                'computed_depends_on' => array(
                    'posts_number',
                    'posts_offset',
                    'include_categories',
                    'dnxte_feaimage_thumb_size',
                    'thumb_width',
                    'thumb_height',
                    'post_type',
                    'order_by',
                    'order',
                    'image_clickable',
                    'excerpt_length',
                    'header_level',
                    'button_icon',
                    'button_use_icon',
                    'blogslider_layouts'
                )
            ),
        );

        $additional_options = array(
            'item_bg_color' => array(
                'label'             => esc_html__('Item Background', 'dnxte-divi-essential'),
                'type'              => 'background-field',
                'base_name'         => "item_bg",
                'context'           => "item_bg",
                'option_category'   => 'configuration',
                'custom_color'      => true,
                'default'           => ET_Global_Settings::get_value('all_buttons_bg_color'),
                'depends_show_if'   => 'on',
                'toggle_slug'       => "blog_item",
                'tab_slug'          => 'advanced',
                'hover'             => 'tabs',
                'mobile_options'    => true,
                'background_fields' => array_merge(

                    ET_Builder_Element::generate_background_options(
                        'item_bg',
                        'gradient',
                        "advanced",
                        "blog_item",
                        "item_bg_gradient"
                    ),

                    ET_Builder_Element::generate_background_options(
                        "item_bg",
                        "color",
                        "advanced",
                        "blog_item",
                        "item_bg_color"
                    )
                ),
            ),
        );

        $additional_options = array_merge(
            $additional_options,
            $this->generate_background_options(
                "item_bg",
                'skip',
                "advanced",
                "blog_item",
                "item_bg_gradient"
            )
        );

        $additional_options = array_merge(
            $additional_options,
            $this->generate_background_options(
                "item_bg",
                'skip',
                "advanced",
                "blog_item",
                "item_bg_color"
            )
        );
        
        $hover_arr = array(
            'hover'     => 'tabs'
        );

        // category bg slug = dnxte_blogslider_category_bg_color
        $category_bg = Common::background_fields($this, "dnxte_blogslider_category_", "Category Background", "dnxte_category_settings","general", $hover_arr);

        // Author bg slug = dnxte_blogslider_author_bg_color
        $author_bg = Common::background_fields($this, "dnxte_blogslider_author_", "Author Background", "dnxte_author_settings", "general", $hover_arr);

        // Date bg slug = dnxte_blogslider_date_bg_color
        $date_bg = Common::background_fields($this, "dnxte_blogslider_date_", "Date Background", "dnxte_date_settings", "general", $hover_arr);

        // content_wrapper_
        $content_wrapper_bg = Common::background_fields($this, "content_wrapper_", "Content Wrapper Background", "blog_item", "general", $hover_arr);

        // image_overlay_
        $image_overlay_bg = Common::background_fields($this, "image_overlay_", "Image Overlay Background", "image", "general", array(
            'default'          => 'rgba(105,52,255,0.4)'
        ));

        return array_merge($fields, $additional_options, $category_bg, $author_bg, $date_bg, $content_wrapper_bg, $image_overlay_bg);
    }

    public static function get_blog_posts($args = array(), $conditional_tags = array(), $current_page = array()) {

        $defaults = array(
            'posts_number'              => '',
            'offset'                    => '',
            'include_categories'        => '',
            'post_type'                 => '',
            'order_by'                  => '',
            'order'                     => '',
            'show_thumbnail'            => '',
            'image_clickable'           => '',
            'show_content'              => '',
            'show_author'               => '',
            'date_position'             => '',
            'show_date'                 => '',
            'show_categories'           => '',
            'show_excerpt'              => '',
            'excerpt_length'            => '',
            'header_level'              => 'h2',
            'show_more'                 => '',
            'button_use_icon'           => '',
            'button_icon'               => '',
        );

        $args = wp_parse_args($args, $defaults);


        $processed_header_level = et_pb_process_header_level($args['header_level'], 'h2');
        $processed_header_level = esc_html($processed_header_level);

        $query_args = array(
            'posts_per_page' => intval($args['posts_number']), //phpcs:ignore
            'post_status'    => 'publish',
            'post_type'      => $args['post_type'],
            'orderby'        => $args['order_by'],
            'order'          => $args['order'],
            'offset'         => $args['offset']
        );

        $post_id = isset($current_page['id']) ? (int) $current_page['id'] : 0;
        $query_args['cat'] = implode(',', self::filter_include_categories($args['include_categories'], $post_id));
        

        // Get query
        $query = new WP_Query($query_args);

        ob_start();
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                include dirname(__FILE__) . '/template-parts/blog-post.php';
            }
        }
        wp_reset_postdata();
        if (!$posts = ob_get_clean()) {
            $posts = self::get_no_results_template(et_core_esc_previously($processed_header_level));
        }

        return $posts;
    }

    public function render($attrs, $content, $render_slug) {
        wp_enqueue_script( 'dnext_swiper_frontend' );
        wp_enqueue_script( 'dnext_blog_slider' );
        wp_enqueue_style( 'dnext_swiper-min-css' );

        $blogslider_meta_alignment_classes = Common::get_alignment("dnxte_meta_alignment", $this);

        $multi_view                = et_pb_multi_view_options($this);
        $posts_number              = $this->props['posts_number'];
        $posts_offset              = $this->props['posts_offset'];
        $include_categories        = $this->props['include_categories'];
        $post_type                 = $this->props['post_type'];
        $order_by                  = $this->props['order_by'];
        $order                     = $this->props['order'];
        $show_thumbnail            = $this->props['show_thumbnail'];
        $dnxte_feaimage_thumb_size = $this->props['dnxte_feaimage_thumb_size'];
        $thumb_width               = $this->props['thumb_width'];
        $thumb_height              = $this->props['thumb_height'];
        $show_author               = $this->props['show_author'];
        $show_categories           = $this->props['show_categories'];
        $date_position             = $this->props['date_position'];
        $show_date                 = $this->props['show_date'];
        $header_level              = $this->props['header_level'];
        $excerpt_length            = $this->props['excerpt_length'];
        $show_excerpt              = $this->props['show_excerpt'];
        $show_more                 = $this->props['show_more'];
        $show_more_text            = $this->props['show_more_text'];
        $button_use_icon           = $this->props['button_use_icon'];
        $button_icon               = $this->props['button_icon'];
        $is_custom_btn_on          = $this->props['custom_button'];

        $auto_height           = $this->props['dnxte_blogslider_auto_height'];
        $is_equal_height       = $this->props['is_equal_height'];
        $blogslider_speed      = $this->props['dnxte_blogslider_speed'];
        $centered_slides       = $this->props['dnxte_blogslider_centered_slides'];
        $autoplay_show_hide    = "on" === $this->props['dnxte_blogslider_autoplay_show_hide'];
        $pause_on_hover        = "on" === $this->props['dnxte_blogslider_pause_on_hover'];
        $autoplay_delay        = $this->props['dnxte_blogslider_autoplay_delay'];
        $grab_cursor           = $this->props['dnxte_blogslider_grab'];
        $blogslider_loop       = $this->props['dnxte_blogslider_loop'];
        $blogslider_keyboard   = $this->props['dnxte_blogslider_keyboard_enable'];
        $blogslider_mousewheel = $this->props['dnxte_blogslider_mousewheel_enable'];

        $blogslider_breakpoint             = $this->props['dnxte_blogslider_breakpoint_desktop'];
        $blogslider_breakpoint_tablet      = $this->props['dnxte_blogslider_breakpoint_desktop_tablet'];
        $blogslider_breakpoint_phone       = $this->props['dnxte_blogslider_breakpoint_desktop_phone'];
        $blogslider_breakpoint_last_edited = $this->props['dnxte_blogslider_breakpoint_desktop_last_edited'];
        
        $blogslider_layouts     = $this->props['blogslider_layouts'];
        $custom_button          = $this->props['custom_button'];

        //effect slider slug
        $slide_shadow = $this->props['dnxte_blogslider_slide_shadows'];
        $slide_rotate = $this->props['dnxte_blogslider_slide_rotate'];
        $slide_stretch = $this->props['dnxte_blogslider_slide_stretch'];
        $slide_depth = $this->props['dnxte_blogslider_slide_depth'];

        if ( '' !== $blogslider_breakpoint_tablet || '' !== $blogslider_breakpoint_phone || '' !== $blogslider_breakpoint ) {
			$is_responsive = et_pb_get_responsive_status( $blogslider_breakpoint_last_edited );

			$blogslider_show_values = array(
				'desktop' => $blogslider_breakpoint,
				'tablet'  => $is_responsive ? $blogslider_breakpoint_tablet : '',
				'phone'   => $is_responsive ? $blogslider_breakpoint_phone : '',
			);
        }

        $blogslider_spacebetween              = $this->props['dnxte_blogslider_spacebetween'];
        $blogslider_spacebetween_tablet       = $this->props['dnxte_blogslider_spacebetween_tablet'];
        $blogslider_spacebetween_phone        = $this->props['dnxte_blogslider_spacebetween_phone'];
        $blogslider_spacebetween_last_edited  = $this->props['dnxte_blogslider_spacebetween_last_edited'];

        if ( '' !== $blogslider_spacebetween_tablet || '' !== $blogslider_spacebetween_phone || '' !== $blogslider_spacebetween ) {
			$is_responsive = et_pb_get_responsive_status( $blogslider_spacebetween_last_edited );

			$spacebetween_values = array(
				'desktop' => $blogslider_spacebetween,
				'tablet'  => $is_responsive ? $blogslider_spacebetween_tablet : '',
				'phone'   => $is_responsive ? $blogslider_spacebetween_phone : '',
			);
        }
        //$multi_view->set_custom_prop('post_content', $multi_view->get_values('show_content'));

        $processed_header_level = et_pb_process_header_level($header_level, 'h2');
        
        $blog_content = self::get_blog_posts(
            $args = array(
                'posts_number'              => $posts_number,
                'offset'                    => $posts_offset,
                'include_categories'        => $include_categories,
                'post_type'                 => $post_type,
                'order_by'                  => $order_by,
                'order'                     => $order,
                'show_thumbnail'            => $show_thumbnail,
                'dnxte_feaimage_thumb_size' => $dnxte_feaimage_thumb_size,
                'thumb_width'               => $thumb_width,
                'thumb_height'              => $thumb_height,
                'show_categories'           => $show_categories,
                'show_author'               => $show_author,
                'date_position'             => $date_position,
                'show_date'                 => $show_date,
                'show_excerpt'              => $show_excerpt,
                'excerpt_length'            => $excerpt_length,
                'show_more'                 => $show_more,
                'show_more_text'            => $show_more_text,
                'button_icon'               => $button_icon,
                'button_use_icon'           => $button_use_icon,
                'blogslider_layout'         => $blogslider_layouts,
                'custom_button'             => $custom_button,
                'multi_view'                => et_pb_multi_view_options($this),
                'meta_alignment_class'      => $blogslider_meta_alignment_classes                     
            )
        );

        $this->apply_css($render_slug);



        // if custom button off, button will get 15px margin-left
        $non_margin_left_layout = array('two','three', 'four', 'five');

        if(!in_array($blogslider_layouts, $non_margin_left_layout)) {
            ET_Builder_Element::set_style( $render_slug, array(
                'selector'    => "%%order_class%% .dnxte-readmorewrapper",
                'declaration' => 'margin-left: 20px;',
            ) );
        }


        if("eight" === $blogslider_layouts) {
            ET_Builder_Element::set_style($render_slug, [
                'selector'    => '%%order_class%% .swiper-slide .dnxte-blog-carousel-wrap',
                'declaration' => "flex-direction: row-reverse; -ms-flex-direction:row-reverse;",
            ]);
        }

        // Blog Post Content Color
        $blog_post_content_color = array(
            'color_slug' => 'item_bg_color',
        );
        $use_color_gradient = $this->props['item_bg_use_color_gradient'];

        $gradient = array(
            "gradient_type"           => 'item_bg_color_gradient_type',
            "gradient_direction"      => 'item_bg_color_gradient_direction',
            "radial"                  => 'item_bg_color_gradient_direction_radial',
            "gradient_start"          => 'item_bg_color_gradient_start',
            "gradient_end"            => 'item_bg_color_gradient_end',
            "gradient_start_position" => 'item_bg_color_gradient_start_position',
            "gradient_end_position"   => 'item_bg_color_gradient_end_position',
            "gradient_overlays_image" => 'item_bg_color_gradient_overlays_image',
        );

        $css_property = array(
            "desktop" => "%%order_class%% .swiper-slide",
            "hover"   => "%%order_class%% .swiper-slide:hover",
        );
        Common::apply_bg_css($render_slug, $this, $blog_post_content_color, $use_color_gradient, $gradient, $css_property);

        // category bg color
        $category_color = array(
            'color_slug' => 'dnxte_blogslider_category_bg_color',
        );
        $use_color_gradient = $this->props['dnxte_blogslider_category_bg_use_color_gradient'];

        $gradient = array(
            "gradient_type"           => 'dnxte_blogslider_category_bg_color_gradient_type',
            "gradient_direction"      => 'dnxte_blogslider_category_bg_color_gradient_direction',
            "radial"                  => 'dnxte_blogslider_category_bg_color_gradient_direction_radial',
            "gradient_start"          => 'dnxte_blogslider_category_bg_color_gradient_start',
            "gradient_end"            => 'dnxte_blogslider_category_bg_color_gradient_end',
            "gradient_start_position" => 'dnxte_blogslider_category_bg_color_gradient_start_position',
            "gradient_end_position"   => 'dnxte_blogslider_category_bg_color_gradient_end_position',
            "gradient_overlays_image" => 'dnxte_blogslider_category_bg_color_gradient_overlays_image',
        );

        $css_property = array(
            "desktop" => "%%order_class%% .dnxte-blog-post-categories a",
            "hover"   => "%%order_class%% .dnxte-blog-post-categories a:hover",
        );
        Common::apply_bg_css($render_slug, $this, $category_color, $use_color_gradient, $gradient, $css_property);
        // category bg color end

        // item image width start
        $image_width_css_property = 'width: %1$s !important;';
        $image_width_css_selector = array(
            'desktop' => "%%order_class%% .dnxte-blog-featured-image",
        );
        Common::set_css("dnxte_blogslider_image_width", $image_width_css_property, $image_width_css_selector, $render_slug, $this);
        // item image width end

        // show underline on title hover start
        if("off" !== $this->props['show_underline_on_title_hover']){
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .swiper-slide:hover .dnxte-entry-title a",
                'declaration' => 'background-size: 100% 2px;',
            ));
        }
        // show underline on title hover end


        $non_fixed_height_layouts = array('seven', 'eight', 'nine');
        if(!in_array($blogslider_layouts, $non_fixed_height_layouts)) {
            if("six" != $blogslider_layouts){
                // item image height start
                $image_height_css_property = 'height: %1$s !important;';
                $image_height_css_selector = array(
                    'desktop' => "%%order_class%% .dnxte-blog-featured-image, %%order_class%% .blog-wrap-no-image",
                );
                Common::set_css("dnxte_blogslider_image_height", $image_height_css_property, $image_height_css_selector, $render_slug, $this);
                // item image height end
            }else {
                $image_height_css_property = 'height: %1$s !important;';
                $image_height_css_selector = array(
                    'desktop' => "%%order_class%% .dnxte-post-thumb, %%order_class%% .blog-wrap-no-image",
                );
                Common::set_css("dnxte_blogslider_image_height", $image_height_css_property, $image_height_css_selector, $render_slug, $this);
    
                // Layout six author avater image place adjustment
                $author_avater_css_property = 'top: %1$s !important;';
                $author_avater_css_selector = array(
                    'desktop' => "%%order_class%% .dnxte-author-avatar",
                );
                Common::set_css("dnxte_blogslider_image_height", $author_avater_css_property, $author_avater_css_selector, $render_slug, $this);
            }
        }


        // author bg color
        $author_color = array(
            'color_slug' => 'dnxte_blogslider_author_bg_color',
        );
        $use_color_gradient = $this->props['dnxte_blogslider_author_bg_use_color_gradient'];

        $gradient = array(
            "gradient_type"           => 'dnxte_blogslider_author_bg_color_gradient_type',
            "gradient_direction"      => 'dnxte_blogslider_author_bg_color_gradient_direction',
            "radial"                  => 'dnxte_blogslider_author_bg_color_gradient_direction_radial',
            "gradient_start"          => 'dnxte_blogslider_author_bg_color_gradient_start',
            "gradient_end"            => 'dnxte_blogslider_author_bg_color_gradient_end',
            "gradient_start_position" => 'dnxte_blogslider_author_bg_color_gradient_start_position',
            "gradient_end_position"   => 'dnxte_blogslider_author_bg_color_gradient_end_position',
            "gradient_overlays_image" => 'dnxte_blogslider_author_bg_color_gradient_overlays_image',
        );

        $css_property = array(
            "desktop" => "%%order_class%% .dnxte-authovcard",
            "hover"   => "%%order_class%% .dnxte-authovcard:hover",
        );
        Common::apply_bg_css($render_slug, $this, $author_color, $use_color_gradient, $gradient, $css_property);
        // author bg color end

        //data bg color 
        $date_color = array(
            'color_slug' => 'dnxte_blogslider_date_bg_color',
        );
        $use_color_gradient = $this->props['dnxte_blogslider_date_bg_use_color_gradient'];

        $gradient = array(
            "gradient_type"           => 'dnxte_blogslider_date_bg_color_gradient_type',
            "gradient_direction"      => 'dnxte_blogslider_date_bg_color_gradient_direction',
            "radial"                  => 'dnxte_blogslider_date_bg_color_gradient_direction_radial',
            "gradient_start"          => 'dnxte_blogslider_date_bg_color_gradient_start',
            "gradient_end"            => 'dnxte_blogslider_date_bg_color_gradient_end',
            "gradient_start_position" => 'dnxte_blogslider_date_bg_color_gradient_start_position',
            "gradient_end_position"   => 'dnxte_blogslider_date_bg_color_gradient_end_position',
            "gradient_overlays_image" => 'dnxte_blogslider_date_bg_color_gradient_overlays_image',
        );

        $css_property = array(
            "desktop" => "%%order_class%% .dnxte-blog-published, %%order_class%% .dnxte-blog-post-date",
            "hover"   => "%%order_class%% .dnxte-blog-published:hover, %%order_class%% .dnxte-blog-post-date:hover",
        );
        Common::apply_bg_css($render_slug, $this, $date_color, $use_color_gradient, $gradient, $css_property);
        //data bg color end

        // content wrapper bg color start
        $content_wrapper_bg = array(
            'color_slug' => 'content_wrapper_bg_color',
        );
        $use_color_gradient = $this->props['content_wrapper_bg_use_color_gradient'];

        $gradient = array(
            "gradient_type"           => 'content_wrapper_bg_color_gradient_type',
            "gradient_direction"      => 'content_wrapper_bg_color_gradient_direction',
            "radial"                  => 'content_wrapper_bg_color_gradient_direction_radial',
            "gradient_start"          => 'content_wrapper_bg_color_gradient_start',
            "gradient_end"            => 'content_wrapper_bg_color_gradient_end',
            "gradient_start_position" => 'content_wrapper_bg_color_gradient_start_position',
            "gradient_end_position"   => 'content_wrapper_bg_color_gradient_end_position',
            "gradient_overlays_image" => 'content_wrapper_bg_color_gradient_overlays_image',
        );

        $css_property = array(
            "desktop" => "%%order_class%% .swiper-slide .dnxte-content-wrapper",
            "hover"   => "%%order_class%% .swiper-slide .dnxte-content-wrapper:hover",
        );
        Common::apply_bg_css($render_slug, $this, $content_wrapper_bg, $use_color_gradient, $gradient, $css_property);
        // content wrapper bg color end

        // image overlay bg color start
        $image_overlay_bg = array(
            'color_slug' => 'image_overlay_bg_color',
        );
        $use_color_gradient = $this->props['image_overlay_bg_use_color_gradient'];

        $gradient = array(
            "gradient_type"           => 'image_overlay_bg_color_gradient_type',
            "gradient_direction"      => 'image_overlay_bg_color_gradient_direction',
            "radial"                  => 'image_overlay_bg_color_gradient_direction_radial',
            "gradient_start"          => 'image_overlay_bg_color_gradient_start',
            "gradient_end"            => 'image_overlay_bg_color_gradient_end',
            "gradient_start_position" => 'image_overlay_bg_color_gradient_start_position',
            "gradient_end_position"   => 'image_overlay_bg_color_gradient_end_position',
            "gradient_overlays_image" => 'image_overlay_bg_color_gradient_overlays_image',
        );

        $css_property = array(
            "desktop" => "%%order_class%% .dnxte-post-thumb a:hover::after"
        );
        Common::apply_bg_css($render_slug, $this, $image_overlay_bg, $use_color_gradient, $gradient, $css_property);
        // image overlay bg color end


        // Images: Add CSS Filters and Mix Blend Mode rules (if set)
		if ( array_key_exists( 'image', $this->advanced_fields ) && array_key_exists( 'css', $this->advanced_fields['image'] ) ) {
			$this->add_classname(
				$this->generate_css_filters(
					$render_slug,
					'child_',
					self::$data_utils->array_get( $this->advanced_fields['image']['css'], 'main', '%%order_class%%' )
				)
			);
		}

        // Arrow Color
        $arrow_color_order_class = '%%order_class%% .swiper-button-prev:after,%%order_class%% .swiper-button-next:after';
		$dnxte_arrow_color_values = et_pb_responsive_options()->get_property_values($this->props, 'dnxte_blogslide_arrow_color');
		et_pb_responsive_options()->generate_responsive_css($dnxte_arrow_color_values, $arrow_color_order_class, 'color', $render_slug, '', 'color');
        
        // Arrow BG Color
        $arrow_bg_order_class = '%%order_class%% .swiper-button-prev, %%order_class%% .swiper-button-next';
		$dnxte_arrow_color_values = et_pb_responsive_options()->get_property_values($this->props, 'dnxte_blogslide_arrow_bg_color');
		et_pb_responsive_options()->generate_responsive_css($dnxte_arrow_color_values, $arrow_bg_order_class, 'background-color', $render_slug, '', 'background-color');

        // DOTS COLOR START
        if( "bullets" === $this->props['dnxte_blogslider_pagination_type'] ){

            $dot_color_order_class = '%%order_class%% .swiper-pagination .swiper-pagination-bullet';
            $dnxte_dots_color_values = et_pb_responsive_options()->get_property_values($this->props, 'dnxte_blogslider_dots_color');
            et_pb_responsive_options()->generate_responsive_css($dnxte_dots_color_values, $dot_color_order_class, 'background', $render_slug, '', 'background');
            
        }

        if( "bullets" === $this->props['dnxte_blogslider_pagination_type'] ){

            $dot_color_active_order_class = '%%order_class%% .swiper-pagination .swiper-pagination-bullet-active';
            $dnxte_dots_color_active_values = et_pb_responsive_options()->get_property_values($this->props, 'dnxte_blogslider_dots_active_color');
            et_pb_responsive_options()->generate_responsive_css($dnxte_dots_color_active_values, $dot_color_active_order_class, 'background-color', $render_slug, '', 'background-color');
        }

        // PROGRESSBAR FILL COLOR START
        if( "progressbar" === $this->props['dnxte_blogslider_pagination_type'] ) {
            $progressbar_bg_order_class = "%%order_class%% .swiper-pagination-progressbar .swiper-pagination-progressbar-fill";
            $dnxte_progressbar_bg_values = et_pb_responsive_options()->get_property_values($this->props, 'dnxte_blogslider_progressbar_fill_color');
            et_pb_responsive_options()->generate_responsive_css($dnxte_progressbar_bg_values, $progressbar_bg_order_class, 'background-color', $render_slug, '', 'background-color');
        }


        // date icon color
        if("on" == $this->props['show_date'] || "none" != $this->props['date_position']) {
            $date_icon_orderclass = "%%order_class%% .dnxte-blog-published .dnxte-blogslider-content-icon";
            $date_icon_color_values = et_pb_responsive_options()->get_property_values($this->props, 'dnxte_blogslider_date_icon_color');
            et_pb_responsive_options()->generate_responsive_css($date_icon_color_values, $date_icon_orderclass, 'color', $render_slug, '', 'color');
        }

        // Category icon color
        if("on" == $this->props['show_categories']) {
            $category_icon_orderclass = "%%order_class%% .dnxte-blog-post-categories .dnxte-blogslider-content-icon";
            $category_icon_color_values = et_pb_responsive_options()->get_property_values($this->props, 'dnxte_blogslider_category_icon_color');
            et_pb_responsive_options()->generate_responsive_css($category_icon_color_values, $category_icon_orderclass, 'color', $render_slug, '', 'color');
        }

        // ARROW SIZE START
        $dnxte_blogslider_arrow_size = (int) $this->props['dnxte_blogslider_arrow_size'];
        $arrow_width = $dnxte_blogslider_arrow_size + 10;
        $dnxte_blogslider_arrow_size_style = sprintf('font-size: %1$spx', esc_attr($dnxte_blogslider_arrow_size));
        $dnxte_blogslider_arrow_background_width_height = sprintf('width: %1$spx !important;height:%1$spx !important', esc_attr($arrow_width));

        ET_Builder_Element::set_style( $render_slug, array(
            'selector'    => "%%order_class%% .swiper-button-prev:after,%%order_class%%  .swiper-button-next:after",
            'declaration' => $dnxte_blogslider_arrow_size_style,
        ) );
        ET_Builder_Element::set_style( $render_slug, array(
            'selector'    => "%%order_class%% .swiper-button-prev,%%order_class%% .swiper-button-next",
            'declaration' => $dnxte_blogslider_arrow_background_width_height,
        ) );

        $blogslider_pagination_type    = $this->props['dnxte_blogslider_pagination_type'];
        $blogslider_pagination_bullets = $blogslider_pagination_type === 'bullets' ? $this->props['dnxte_blogslider_pagination_bullets'] : "off";
        $blogslider_pagination_clickable = $blogslider_pagination_type === 'bullets' ? $this->props['dnxte_blogslider_pagination_clickable'] : "off";
        
        // PAGINATION CLASSES
        $pagination_class = "swiper-pagination ";
        if( $blogslider_pagination_type === "bullets" && $blogslider_pagination_bullets === "on"){
            $pagination_class .= "swiper-pagination-bullets swiper-pagination-bullets-dynamic mt-10";
        }else if($blogslider_pagination_type === "bullets") {
            $pagination_class .= "swiper-pagination-bullets mt-10";
        }else if($blogslider_pagination_type === "fraction") {
            $pagination_class .= "swiper-pagination-fraction";
        }else if($blogslider_pagination_type === "progressbar") {
            $pagination_class .= "swiper-pagination-progressbar";
        }

        // USE ARROW CLASSES
        $arrowsClass = "";
        $position_container  = "";
        $arrow_position_string = $this->props['dnxte_blogslider_arrow_position'];
        $arrow_position = array(
            'top-left',
            'top-center',
            'top-right',
            'bottom-left',
            'bottom-center',
            'bottom-right'
        );

        if(in_array($arrow_position_string, $arrow_position)) {
            $position_container = "multi-position-container";
        }

        $arrow_top_bottom = substr($arrow_position_string, 0,3) === "top" ? "arrow-position-top" : "arrow-position-bottom";

        if(substr($arrow_position_string, -strlen("left")) === "left") {
            $arrow_left_right_center = "multi-position-button-left";
        }elseif(substr($arrow_position_string, -strlen("center")) === "center") {
            $arrow_left_right_center = "multi-position-button-center";
        }elseif(substr($arrow_position_string, -strlen("right")) === "right") {
            $arrow_left_right_center = "multi-position-button-right";
        }


        if("off" !== $this->props['dnxte_blogslider_arrows']) {
            if($arrow_position_string === 'inner'){
                $arrowsClass = sprintf(
                    '<div class="swiper-button-prev dnxte_blogslider_arrows_inner_left" data-icon="prev"></div>
                    <div class="swiper-button-next dnxte_blogslider_arrows_inner_right" data-icon="next"></div>'
                ); 
            }else if($arrow_position_string === 'outer') {
                $arrowsClass = sprintf(
                    '<div class="swiper-button-prev dnxte_blogslider_arrows_outer_left" data-icon="prev"></div>
                    <div class="swiper-button-next dnxte_blogslider_arrows_outer_right" data-icon="next"></div>'
                );
            }elseif($arrow_position_string === "default"){
                $arrowsClass = sprintf(
                    '<div class="swiper-button-prev dnxte_blogslider_arrows_default_left" data-icon="prev"></div>
                    <div class="swiper-button-next dnxte_blogslider_arrows_default_right" data-icon="next"></div>'
                );
            }elseif(in_array($arrow_position_string, $arrow_position)) {
                $arrowsClass = sprintf(
                    '<div class="swiper-button-container multi-position-button-container %1$s">
                        <div class="swiper-button-prev multi-position-button" data-icon="prev"></div>
                        <div class="swiper-button-next multi-position-button" data-icon="next"></div>
                    </div>',
                    $arrow_left_right_center
                );
            }
        }
        
        $blog_layout = self::layout_name($blogslider_layouts);

        return sprintf(
            '<div class="dnxte_blog_slider_container %22$s %23$s">
                <div class="swiper-container dnxte-blog-carousel-slide-active is_equal_height_%25$s"
                data-autoheight="%4$s" data-speed="%5$s" data-center="%6$s" data-autoplay="%7$s" 
                data-breakpoints="%8$s|%9$s|%10$s" data-space-between="%11$s|%12$s|%13$s" 
                data-grab-cursor="%14$s" data-loop="%15$s" data-delay="%16$s" data-pagination-type="%17$s" 
                data-pagination-bullets="%18$s" data-clickable="%19$s" data-keyboardenable="%20$s" 
                data-mouse="%21$s" data-direction="horizontal" data-pauseonhover="%24$s" data-covershadow="%27$s" data-coverrotate="%28$s" data-coverstretch="%29$s" data-coverdepth="%30$s">
                    <div class="swiper-wrapper mb-30 dnxte-blog-carousel-layout-%26$s">
                        %1$s
                    </div>
                    <div class="%3$s"></div>
                </div>
                %2$s
            </div>',
            $blog_content,
            $arrowsClass,
            $pagination_class,
            esc_attr( $auto_height ),
            esc_attr( $blogslider_speed ), // #5
            esc_attr( $centered_slides ), 
            esc_attr( $autoplay_show_hide ),
            esc_attr( $blogslider_breakpoint ), 
            '' !== $blogslider_show_values['tablet'] ? esc_attr( $blogslider_show_values['tablet'] ) : 1,
			'' !== $blogslider_show_values['phone'] ? esc_attr( $blogslider_show_values['phone'] ) : 1, // # 10
            esc_attr( $blogslider_spacebetween ), 
            '' !== $spacebetween_values['tablet'] ? esc_attr( $spacebetween_values['tablet'] ) : 1,
            '' !== $spacebetween_values['phone'] ? esc_attr( $spacebetween_values['phone'] ) : 1,
            esc_attr( $grab_cursor ), 
            esc_attr( $blogslider_loop ), // # 15
            esc_attr( $autoplay_delay ),
            esc_attr( $blogslider_pagination_type ),
            esc_attr( $blogslider_pagination_bullets ),
            esc_attr( $blogslider_pagination_clickable ), 
            esc_attr( $blogslider_keyboard ), // # 20
            esc_attr( $blogslider_mousewheel ),
            $position_container,
            $arrow_top_bottom,
            $pause_on_hover,
            $is_equal_height, // # 25
            $blog_layout,
            esc_attr( $slide_shadow ),
            esc_attr( $slide_rotate ),
            esc_attr( $slide_stretch ), 
            esc_attr( $slide_depth ) // # 30
        );
    }

    public static function layout_name($layout) {
        return in_array($layout, array('seven', 'eight')) ? 'seven' : $layout;
    }

    public function apply_css($render_slug) {
        
        $dnxte_button_alignment                   = $this->props['button_alignment'];
        $dnxte_button_alignment_responsive_active = isset($this->props["button_alignment_last_edited"]) && et_pb_get_responsive_status($this->props["button_alignment_last_edited"]);
        $dnxte_button_alignment_tablet            = $dnxte_button_alignment_responsive_active && $this->props["button_alignment_tablet"] ? $this->props["button_alignment_tablet"] : $dnxte_button_alignment;
        $dnxte_button_alignment_phone             = $dnxte_button_alignment_responsive_active && $this->props["button_alignment_phone"] ? $this->props["button_alignment_phone"] : $dnxte_button_alignment_tablet;

        //Button Alignment
        if ('' !== $dnxte_button_alignment) {
            ET_Builder_Element::set_style($render_slug, [
                'selector'    => '%%order_class%% .dnxte-readmorewrapper',
                'declaration' => "text-align: ${dnxte_button_alignment} !important;",
            ]);

            ET_Builder_Element::set_style($render_slug, [
                'selector'    => '%%order_class%% .dnxte-readmorewrapper',
                'declaration' => "text-align: ${dnxte_button_alignment_tablet} !important;",
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ]);

            ET_Builder_Element::set_style($render_slug, [
                'selector'    => '%%order_class%% .dnxte-readmorewrapper',
                'declaration' => "text-align: ${dnxte_button_alignment_phone}  !important;",
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ]);
        }

        /**
         * Custom Padding Margin Output
         *
        */
        Common::dnxt_set_style($render_slug, $this->props, "dnxte_blogslider_arrow_margin", "%%order_class%% .swiper-button-next,%%order_class%% .swiper-button-prev", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "dnxte_blogslider_arrow_padding", "%%order_class%% .swiper-button-next, %%order_class%% .swiper-button-prev", "padding");
        
        Common::dnxt_set_style($render_slug, $this->props, "dnxte_blogslider_title_margin", "%%order_class%% .dnxte-entry-title", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "dnxte_blogslider_title_padding", "%%order_class%% .dnxte-entry-title", "padding");
        
        Common::dnxt_set_style($render_slug, $this->props, "dnxte_blogslider_content_wrapper_margin", "%%order_class%% .dnxte-content-wrapper", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "dnxte_blogslider_content_wrapper_padding", "%%order_class%% .dnxte-content-wrapper", "padding");

        Common::dnxt_set_style($render_slug, $this->props, "dnxte_blogslider_content_margin", "%%order_class%% .dnxte-blog-post-content", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "dnxte_blogslider_content_padding", "%%order_class%% .dnxte-blog-post-content", "padding");
        
        Common::dnxt_set_style($render_slug, $this->props, "dnxte_blogslider_img_margin", "%%order_class%% .dnxte-post-thumb", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "dnxte_blogslider_img_padding", "%%order_class%% .dnxte-post-thumb", "padding");
        
        Common::dnxt_set_style($render_slug, $this->props, "dnxte_blogslider_auth_margin", "%%order_class%% .dnxte-authovcard", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "dnxte_blogslider_auth_padding", "%%order_class%% .dnxte-authovcard", "padding");

        Common::dnxt_set_style($render_slug, $this->props, "dnxte_blogslider_date_margin", "%%order_class%% .dnxte-blog-published", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "dnxte_blogslider_date_padding", "%%order_class%% .dnxte-blog-published", "padding");
        
        Common::dnxt_set_style($render_slug, $this->props, "dnxte_blogslider_categories_margin", "%%order_class%% .dnxte-blog-post-categories a:not(first-of-type), %%order_class%% .dnxte-blog-post-categories span.dnxte-blogslider-content-icon", "margin", false);
        Common::dnxt_set_style($render_slug, $this->props, "dnxte_blogslider_categories_padding", "%%order_class%% .dnxte-blog-post-categories a, %%order_class%% .dnxte-blog-post-categories span.dnxte-blogslider-content-icon", "padding");


    }
}

new Next_Blog_Slider;