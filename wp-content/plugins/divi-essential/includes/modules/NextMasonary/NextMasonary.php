<?php
include_once(DIVI_ESSENTIAL_PATH.'/includes/modules/base/Common.php');

class Next_Masonary extends ET_Builder_Module {

    public $slug = 'dnxte_masonary';
    public $vb_support = 'on';

    protected $module_credits = array(
        'module_uri' => 'https://www.diviessential.com/divi-masonry-gallery/',
        'author'     => 'Divi Next',
        'author_uri' => 'www.divinext.com',
    );

    public function init() {
        $this->name        = esc_html__('Next Masonry Gallery', 'et_builder');
        $this->icon_path   = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->folder_name = 'et_pb_divi_essential';

        $this->settings_modal_toggles = array(
            'general'    => array(
                'toggles' => array(
                    'main_content'     => esc_html__('Images', 'et_builder'),
                    'dnxte_settings'   => esc_html__('Settings', 'et_builder'),
                    'dnxte_filter_bar' => esc_html__('Filtering Bar', 'et_builder'),
                    'dnxte_overlay_bg' => esc_html__('Overlay Background', 'et_builder')
                ),
            ),
            'advanced'   => array(
                'toggles' => array(
                    'dnxte_grid'             => esc_html__('Grid', 'et_builder'),
                    'dnxte_grid_items'       => esc_html__('Image', 'et_builder'),
                    'dnxte_title_settings' => array(
                        'title' => esc_html__('Title', 'et_builder'),
                        'sub_toggles' => array(
                            'title_gallery' => array(
                                'name' => esc_html__('On Gallery', 'et_builder'),
							),
                            'title_lightbox' => array(
                                'name' => esc_html__('On Lightbox', 'et_builder'),
							),
                        ),
                        'tabbed_subtoggles'    => true,
                    ),
                    'dnxte_caption_settings' => array(
                        'title' => esc_html__('Caption', 'et_builder'),
                        'sub_toggles' => array(
                            'caption_gallery' => array(
                                'name' => esc_html__('On Gallery', 'et_builder'),
							),
                            'caption_lightbox' => array(
                                'name' => esc_html__('On Lightbox', 'et_builder'),
							),
                        ),
                        'tabbed_subtoggles'    => true,
                    ),
                    'dnxte_overlay'          => esc_html__('Hover Icon', 'et_builder'),
                    'dnxte_filter_text' => esc_html__('Filter Menu', 'et_builder'),
                    'dnxte_lightbox_colors' => esc_html__('Lightbox Color', 'et_builder')
                ),
            )
        );

        $this->advanced_fields = array(
            'link_options'  => false,
            'fonts'         => array(
				'title'   => array(
					'label'    => esc_html__( 'Title', 'et_builder' ),
					'css'      => array(
						'main'  => "%%order_class%% .dnxte-msnary-details .dnxte-msnary-heading",
						'hover' => "%%order_class%% .dnxte-msnary-details .dnxte-msnary-heading:hover",
                    ),
                    'tab_slug'     => 'advanced',
                    'toggle_slug'  => 'dnxte_title_settings',
                    'sub_toggle'   => 'title_gallery',
					'header_level' => array(
						'default' => 'h3',
					),
				),
                'title_lightbox'   => array(
					'label'    => esc_html__( 'Title', 'dnxte-divi-essential' ),
					'css'      => array(
						'main'  => ".dnxte-msnary-mfp-config .dnxte-mfe-title",
						'hover' => ".dnxte-msnary-mfp-config .dnxte-mfe-title:hover",
                    ),
                    'tab_slug'     => 'advanced',
                    'toggle_slug'  => 'dnxte_title_settings',
                    'sub_toggle'   => 'title_lightbox',
				),
				'caption' => array(
					'label'    => esc_html__( 'Caption', 'et_builder' ),
					'use_all_caps' => true,
					'css'      => array(
						'main'  => "%%order_class%% .dnxte-msnary-details .dnxte-msnary-pra",
						'hover' => "%%order_class%% .dnxte-msnary-details .dnxte-msnary-pra:hover",
                    ),
                    'tab_slug'     => 'advanced',
                    'toggle_slug'  => 'dnxte_caption_settings',
                    'sub_toggle'   => 'caption_gallery',
					'line_height' => array(
						'range_settings' => array(
							'min'  => '1',
							'max'  => '100',
							'step' => '1',
						),
					),
                ),
                'caption_lightbox' => array(
					'label'    => esc_html__( 'Caption', 'et_builder' ),
					'use_all_caps' => true,
					'css'      => array(
						'main'  => ".dnxte-msnary-mfp-config .dnxte-mfe-caption",
						'hover' => ".dnxte-msnary-mfp-config .dnxte-mfe-caption:hover",
                    ),
                    'tab_slug'     => 'advanced',
                    'toggle_slug'  => 'dnxte_caption_settings',
                    'sub_toggle'   => 'caption_lightbox',
					'line_height' => array(
						'range_settings' => array(
							'min'  => '1',
							'max'  => '100',
							'step' => '1',
						),
					),
                ),
				'dnxte_filter_text' => array(
					'label'    => esc_html__( 'Gallery Filter Text', 'et_builder' ),
					'use_all_caps' => true,
					'css'      => array(
						'main'  => "%%order_class%% .dnxte-msnary-filter-items li",
						'hover' => "%%order_class%% .dnxte-msnary-filter-items li:hover",
                        'text_align' => '%%order_class%% .dnxte-msnary-filter-items',
                    ),
                    'tab_slug'     => 'advanced',
                    'toggle_slug'  => 'dnxte_filter_text',
					'line_height' => array(
						'range_settings' => array(
							'min'  => '1',
							'max'  => '100',
							'step' => '1',
						),
					),
                ),
			),
            'borders'        => array(
                'default' => array(),
                'image'   => array(
                    'css'          => array(
                        'main' => array(
                            'border_radii'  => "%%order_class%% .dnxte-msnary-item.et_pb_gallery_image",
                            'border_styles' => "%%order_class%% .dnxte-msnary-item.et_pb_gallery_image",
                        ),
                    ),
                    'label_prefix' => esc_html__('Image'),
                    'tab_slug'     => 'advanced',
                    'toggle_slug'  => 'dnxte_grid_items',
                ),
                'filter_border'   => array(
                    'css'          => array(
                        'main' => array(
                            'border_radii'  => "%%order_class%% li.dnxte-msnary-filter-item",
                            'border_styles' => "%%order_class%% li.dnxte-msnary-filter-item",
                        ),
                    ),
                    'label_prefix' => esc_html__('Filter Bar'),
                    'tab_slug'     => 'advanced',
                    'toggle_slug'  => 'dnxte_filter_text',
                    'depends_on'      => array( 'dnxte_gallery_bar' ),
					'depends_show_if' => 'on',
                ),
                'icon_border'   => array(
                    'css'          => array(
                        'main' => array(
                            'border_radii'  => "%%order_class%% .dnxte_ovl.et_overlay:before",
                            'border_styles' => "%%order_class%% .dnxte_ovl.et_overlay:before",
                        ),
                    ),
                    'label_prefix' => esc_html__('Icon'),
                    'tab_slug'     => 'advanced',
                    'toggle_slug'  => 'dnxte_overlay',
                    'depends_on'      => array( 'use_overlay' ),
					'depends_show_if' => 'on',
                ),
            ),
            'box_shadow'     => array(
                'default' => array(),
                'image'   => array(
                    'css'             => array(
                        'main' => "%%order_class%% .dnxte-msnary-grid .dnxte-msnary-item.et_pb_gallery_image",
                    ),
                    'label'           => esc_html__('Image Box Shadow', 'et_builder'),
                    'option_category' => 'layout',
                    'tab_slug'        => 'advanced',
                    'toggle_slug'     => 'dnxte_grid_items',
                ),
                'filter_menu'   => array(
                    'css'             => array(
                        'main' => "%%order_class%% .dnxte-msnary-filter-item",
                    ),
                    'label'           => esc_html__('Filter Item Box Shadow', 'et_builder'),
                    'option_category' => 'layout',
                    'tab_slug'        => 'advanced',
                    'toggle_slug'     => 'dnxte_filter_text',
                    'depends_on'      => array( 'dnxte_gallery_bar' ),
					'depends_show_if' => 'on',
                ),
            ),
            'margin_padding' => array(
                'css' => array(
                    'important' => 'all',
                ),
            ),
            'max_width'      => array(
                'css' => array(
                    'module_alignment' => '%%order_class%%.et_pb_module.dnxte_masonary',
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
                    'main' => '%%order_class%% .et_pb_gallery_image img',
                ),
            ),
            'scroll_effects' => array(
                'grid_support' => 'yes',
            ),
            'button'         => false,
            'text'           => false,
        );

        $this->custom_css_fields = array(
            'gallery_item' => array(
                'label'    => esc_html__('Gallery Item', 'et_builder'),
                'selector' => '%%order_class%% .dnxte-msnary-item',
            ),
            'overlay'      => array(
                'label'    => esc_html__('Overlay', 'et_builder'),
                'selector' => '%%order_class%% .et_overlay',
            ),
            'overlay_icon' => array(
                'label'    => esc_html__('Overlay Icon', 'et_builder'),
                'selector' => '%%order_class%% .et_overlay:before',
            ),
            'filter_menu' => array(
                'label'    => esc_html__('Filter Menu', 'et_builder'),
                'selector' => '%%order_class%% .dnxte-msnary-filter-items',
            ),
            'filter_menu_item' => array(
                'label'    => esc_html__('Filter Menu Item', 'et_builder'),
                'selector' => '%%order_class%% .dnxte-msnary-filter-items',
            ),
        );
    }

    public function get_fields() {
        $fields = array(
            'gallery_ids'         => array(
                'label'            => esc_html__('Images', 'et_builder'),
                'description'      => esc_html__('Choose the images that you would like to appear in the image gallery.', 'et_builder'),
                'type'             => 'upload-gallery',
                'computed_affects' => array(
                    '__gallery',
                ),
                'option_category'  => 'basic_option',
                'toggle_slug'      => 'main_content',
            ),
            'gallery_orderby'     => array(
                'label'       => esc_html__('Image Order', 'et_builder'),
                'description' => esc_html__('Select an ordering method for the gallery. This controls which gallery items appear first in the list.', 'et_builder'),
                'type'        => $this->is_loading_bb_data() ? 'hidden' : 'select',
                'options'     => array(
                    ''     => esc_html__('Default'),
                    'rand' => esc_html__('Random', 'et_builder'),
                ),
                'default'     => 'off',
                'class'       => array('et-pb-gallery-ids-field'),
                'toggle_slug' => 'main_content',
            ),
            'thumb_size'          => array(
				'label'            => esc_html__( 'Featured Image Size', 'et_builder' ),
				'description'      => esc_html__( 'Different featured image size.', 'et_builder' ),
				'type'             => 'select',
				'option_category'  => 'configuration',
				'toggle_slug'      => 'main_content',
				'default'          => 'full',
				'options'          => array(
					'medium'    => esc_html__( 'Small', 'et_builder' ),
					'large'     => esc_html__( 'Medium', 'et_builder' ),
					'full'      => esc_html__( 'Full (Original Image)', 'et_builder' ),
                    'custom'    => esc_html__( 'Custom', 'et_builder' ),
				),
				'default_on_front' => 'full',
				'computed_affects' => array( '__gallery' ),
			),
            'thumb_width'            => array(
				'label'            => esc_html__( 'Featured Image Width', 'et_builder' ),
				'type'             => 'range',
				'default'          => '800',
				'unitless'         => true,
				'range_settings'   => array(
					'min'  => 0,
					'step' => 1,
					'max'  => 800,
				),
				'toggle_slug'      => 'main_content',
				'computed_affects' => array( '__gallery' ),
				'show_if'          => array(
					'thumb_size' => 'custom',
				),
			),
			'thumb_height'           => array(
				'label'            => esc_html__( 'Featured Image Height', 'et_builder' ),
				'type'             => 'range',
				'default'          => '484',
				'unitless'         => true,
				'range_settings'   => array(
					'min'  => 0,
					'step' => 1,
					'max'  => 484,
				),
				'toggle_slug'      => 'main_content',
				'computed_affects' => array( '__gallery' ),
				'show_if'          => array(
					'thumb_size' => 'custom',
				),
			),
            'dnxte_filter_active_text_color'  => array(
                'label'          => esc_html__(' Gallery Filter Active Text Color', 'et_builder'),
                'description'    => esc_html__('Color of the active filter menu text.', 'et_builder'),
                'type'           => 'color-alpha',
                'toggle_slug'    => 'dnxte_filter_text',
                'custom_color'   => true,
                'tab_slug'       => 'advanced',
                'mobile_options' => true,
                'responsive'     => true,
                'hover'          => 'tabs'
            ),
            'responsive_warning' => array(
                'label' => '',
				'type'        => 'warning',
				'value'       => true,
				'display_if'  => true,
				'message'     => esc_html__('The Columns and Gutter responsive values may not work in visual builder, but it works perfectly in frontend.'),
				'toggle_slug' => 'dnxte_grid',
                'tab_slug'         => 'advanced',
			),
            'dnxte_columns'       => array(
                'label'            => esc_html__('Columns', 'et_builder'),
                'type'             => 'range',
                'description'       => esc_html__('Choose column values ​​to display how many columns you want your images in. The columns responsive value may not work in visual builder, but it works perfectly in frontend.'),
                'option_category'  => 'basic_option',
                'toggle_slug'      => 'dnxte_grid',
                'tab_slug'         => 'advanced',
                'default'          => '4',
                'range_settings'   => array(
                    'min'  => '1',
                    'max'  => '10',
                    'step' => '1',
                ),
                'mobile_options'   => true,
                'responsive'       => true,
                'unitless'         => true,
                'computed_affects' => array(
                    '__gallery',
                ),
            ),
            'dnxte_gutter'        => array(
                'label'            => esc_html__('Gutter', 'et_builder'),
                'type'             => 'range',
                'description'     => esc_html__('Set the amount of free space in your images. The gutter responsive value may not work in visual builder, but it works perfectly in frontend.'),
                'option_category'  => 'layout',
                'toggle_slug'      => 'dnxte_grid',
                'tab_slug'         => 'advanced',
                'default'          => '10',
                'range_settings'   => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1',
                ),
                'mobile_options'   => true,
                'responsive'       => true,
                'unitless'         => true,
                'computed_affects' => array(
                    '__gallery',
                ),
            ),
            'dnxte_masonry_hvr_effect' => array(
				'label'           => esc_html__('Hover Effects', 'et_builder'),
				'type'            => 'select',
				'description'     => esc_html__('Select the effect of masonry effect.', 'et_builder'),
				'option_category' => 'basic_option',
				'toggle_slug'     => 'main_content',
				'options'         => array(
					'none'                      => esc_html__('None', 'et_builder'),
					'push-up'                   => esc_html__('Push Up', 'et_builder'),
					'push-down'                 => esc_html__('Push Down', 'et_builder'),
					'push-right'                => esc_html__('Push Right', 'et_builder'),
					'push-left'                 => esc_html__('Push Left', 'et_builder'),
                    'reveal-up'   				=>  esc_html__( 'Reveal Up', 'et_builder' ),
					'reveal-down'   			=>  esc_html__( 'Reveal Down', 'et_builder' ),
					'reveal-left'   			=>  esc_html__( 'Reveal Left', 'et_builder' ),
					'reveal-right'   			=>  esc_html__( 'Reveal Right', 'et_builder' ),
					'reveal-top-left'   		=>  esc_html__( 'Reveal Top Left', 'et_builder' ),
					'reveal-top-right'  		=>  esc_html__( 'Reveal Top Right', 'et_builder' ),
					'reveal-bottom-left'		=>  esc_html__( 'Reveal Bottom Left', 'et_builder' ),
					'reveal-bottom-right'		=>  esc_html__( 'Reveal Bottom Right', 'et_builder' ),
                    'hinge-up'   				=>  esc_html__( 'Hinge Up', 'et_builder' ),
					'hinge-down'   				=>  esc_html__( 'Hinge Down', 'et_builder' ),
					'hinge-left'   				=>  esc_html__( 'Hinge Left', 'et_builder' ),
					'hinge-right'   			=>  esc_html__( 'Hinge Right', 'et_builder' ),
                    'flip-horiz'   				=>  esc_html__( 'Flip Horizontal', 'et_builder' ),
					'flip-vert'   				=>  esc_html__( 'Flip Vertical', 'et_builder' ),
					'flip-diag-1'   			=>  esc_html__( 'Flip Diag 1', 'et_builder' ),
					'flip-diag-2'   			=>  esc_html__( 'Flip Diag 2', 'et_builder' ),
                    'shutter-out-horiz'   		=>  esc_html__( 'Shutter Out Horizontal', 'et_builder' ),
					'shutter-out-vert'   		=>  esc_html__( 'Shutter Out Vertical', 'et_builder' ),
					'shutter-out-diag-1'   		=>  esc_html__( 'Shutter Out Diag 1', 'et_builder' ),
					'shutter-out-diag-2'   		=>  esc_html__( 'Shutter Out Diag 2', 'et_builder' ),
					'shutter-in-horiz'   		=>  esc_html__( 'Shutter In Horizontal', 'et_builder' ),
					'shutter-in-vert'   		=>  esc_html__( 'Shutter In Vertical', 'et_builder' ),
					'shutter-in-out-horiz'   	=>  esc_html__( 'Shutter In Out Horizontal', 'et_builder' ),
					'shutter-in-out-vert'   	=>  esc_html__( 'Shutter In Out Vertical', 'et_builder' ),
					'shutter-in-out-diag-1'   	=>  esc_html__( 'Shutter In Out Diag 1', 'et_builder' ),
					'shutter-in-out-diag-2'   	=>  esc_html__( 'Shutter In Out Diag 2', 'et_builder' ),
                    'fold-up'   				=>  esc_html__( 'Fold Up', 'et_builder' ),
					'fold-down'   				=>  esc_html__( 'Fold Down', 'et_builder' ),
					'fold-left'   				=>  esc_html__( 'Fold Left', 'et_builder' ),
					'fold-right'   				=>  esc_html__( 'Fold Right', 'et_builder' ),
					'zoom-in'   				=>  esc_html__( 'Zoom In', 'et_builder' ),
					'zoom-out'   				=>  esc_html__( 'Zoom Out', 'et_builder' ),
					'zoom-out-up'   			=>  esc_html__( 'Zoom Out Up', 'et_builder' ),
					'zoom-out-down'   			=>  esc_html__( 'Zoom Out Down', 'et_builder' ),
					'zoom-out-left'   			=>  esc_html__( 'Zoom Out Left', 'et_builder' ),
					'zoom-out-right'   			=>  esc_html__( 'Zoom Out Right', 'et_builder' ),
					'zoom-out-flip-horiz'   	=>  esc_html__( 'Zoom Out Flip Horizontal', 'et_builder' ),
					'zoom-out-flip-vert'   		=>  esc_html__( 'Zoom Out Flip Vertical', 'et_builder' ),
                    'image-zoom-center'   		=>  esc_html__( 'Image Zoom Center', 'et_builder' ),
					'image-zoom-out'   			=>  esc_html__( 'Image Zoom Out', 'et_builder' ),
					'image-rotate-left'   		=>  esc_html__( 'Image Rotate Left', 'et_builder' ),
					'image-rotate-right'   		=>  esc_html__( 'Image Rotate Right', 'et_builder' ),
                    'circle-up'   				=>  esc_html__( 'Circle Up', 'et_builder' ),
					'circle-down'   			=>  esc_html__( 'Circle Down', 'et_builder' ),
					'circle-left'   			=>  esc_html__( 'Circle Left', 'et_builder' ),
					'circle-right'   			=>  esc_html__( 'Circle Right', 'et_builder' ),
					'circle-top-left'   		=>  esc_html__( 'Circle Top Left', 'et_builder' ),
					'circle-top-right'   		=>  esc_html__( 'Circle Top Right', 'et_builder' ),
					'circle-bottom-left'   		=>  esc_html__( 'Circle Bottom Left', 'et_builder' ),
					'circle-bottom-right'   	=>  esc_html__( 'Circle Bottom Right', 'et_builder' ),
					'bounce-out'   				=>  esc_html__( 'Bounce Out', 'et_builder' ),
					'bounce-out-up'   			=>  esc_html__( 'Bounce Out Up', 'et_builder' ),
					'bounce-out-down'   		=>  esc_html__( 'Bounce Out Down', 'et_builder' ),
					'bounce-out-left'   		=>  esc_html__( 'Bounce Out Left', 'et_builder' ),
					'bounce-out-right'   		=>  esc_html__( 'Bounce Out Right', 'et_builder' ),
                    'dive-cc'   				=>  esc_html__( 'Dive Corner 1', 'et_builder' ),
					'dive-ccc'   				=>  esc_html__( 'Dive Corner 2', 'et_builder' ),
                    'flash-top-left'   			=>  esc_html__( 'Flash Top Left', 'et_builder' ),
					'flash-top-right'   		=>  esc_html__( 'Flash Top Right', 'et_builder' ),
					'flash-bottom-left'   		=>  esc_html__( 'Flash Bottom Left', 'et_builder' ),
					'flash-bottom-right'   		=>  esc_html__( 'Flash Bottom Right', 'et_builder' ),
				),
				'default'         => 'none',
			),
            'dnxte_gallery_bar'   => array(
                'label'           => esc_html__('Use Filtering Bar', 'et_builder'),
                'type'            => 'yes_no_button',
                'option_category' => 'basic_option',
                'toggle_slug'     => 'dnxte_filter_bar',
                'options'         => array(
                    'off' => esc_html__('Off', 'et_builder'),
                    'on'  => esc_html__('On', 'et_builder'),
                ),
                'default'         =>  'off',
            ),
            'dnxte_masonry_filter_effect' => array(
				'label'           => esc_html__('Filter Bar Layout', 'et_builder'),
				'type'            => 'select',
				'description'     => esc_html__('Select the preffered style for filter menu.', 'et_builder'),
				'option_category' => 'basic_option',
				'toggle_slug'     => 'dnxte_filter_bar',
                'options'         => array(
                    'none'                   => esc_html__('None', 'et_builder'),
                    'one'                   => esc_html__('Layout 1', 'et_builder'),
                    'two'                   => esc_html__('Layout 2', 'et_builder'),
                    'three'                   => esc_html__('Layout 3', 'et_builder'),
                    'four'                   => esc_html__('Layout 4', 'et_builder'),
                    'five'                   => esc_html__('Layout 5', 'et_builder'),
                    'six'                   => esc_html__('Layout 6', 'et_builder'),
                    'seven'                   => esc_html__('Layout 7', 'et_builder'),
                    'eight'                   => esc_html__('Layout 8', 'et_builder'),
                ),
                'default'       => 'two',
                'show_if'       => array(
                    'dnxte_gallery_bar' => 'on'
                )
            ),
        'dnxte_choose_lightbox' => array(
				'label'           => esc_html__('Lightbox/Link', 'et_builder'),
				'type'            => 'select',
				'description'     => esc_html__('Choose between Lightbox and Link', 'et_builder'),
				'option_category' => 'basic_option',
				'toggle_slug'     => 'dnxte_settings',
				'options'         => array(
                    'none' => esc_html__('None', 'et_builder'),
                    'lightbox' => esc_html__('Use Lightbox', 'et_builder'),
                    'link'  => esc_html__('Use Link', 'et_builder'),
                ),
				'default'         => 'lightbox',
			),
            'dnxte_filtering_text_all'=> array(
                'label'           => esc_html__('All', 'et_builder'),
                'type'            => 'text',
                'dynamic_content' => 'text',
                'description'     => esc_html__('Filtering default text', 'et_builder'),
                'default'         => 'All',
                'option_category' => 'basic_option',
                'toggle_slug'     => 'dnxte_filter_bar',
                'show_if'        => array(
                    'dnxte_gallery_bar' => 'on',
                ),
            ),
            'use_overlay'         => array(
                'label'           => esc_html__('Use Hover Icon & Overlay', 'et_builder'),
                'type'            => 'yes_no_button',
                'option_category' => 'basic_option',
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'dnxte_overlay',
                'options'         => array(
                    'off' => esc_html__('Off', 'et_builder'),
                    'on'  => esc_html__('On', 'et_builder'),
                ),
                'default'         =>  'on',
            ),
            'overlay_icon_color'  => array(
                'label'          => esc_html__(' Overlay Icon Color', 'et_builder'),
                'description'    => esc_html__('Color of the overlay icon. The overlay icon is centered horizontally and vertically over the image.', 'et_builder'),
                'type'           => 'color-alpha',
                'toggle_slug'    => 'dnxte_overlay',
                'custom_color'   => true,
                'tab_slug'       => 'advanced',
                'default'        => '#FFFFFF',
                'mobile_options' => true,
                'responsive'     => true,
                'show_if'        => array(
                    'use_overlay' => 'on',
                ),
            ),
            'hover_icon'          => array(
                'label'           => esc_html__('Hover Icon', 'et_builder'),
                'type'            => 'select_icon',
                'option_category' => 'configuration',
                'class'           => array('et-pb-font-icon'),
                'option_category' => 'configuration',
                'default'         => 'L',
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'dnxte_overlay',
                'mobile_options'  => true,
                'responsive'      => true,
                'show_if'         => array(
                    'use_overlay' => 'on',
                ),
            ),
            'dnxte_icon_size'       => array(
                'label'            => esc_html__('Icon Size', 'et_builder'),
                'type'             => 'range',
                'option_category'  => 'basic_option',
                'toggle_slug'      => 'dnxte_overlay',
                'tab_slug'         => 'advanced',
                'default'          => '32',
                'range_settings'   => array(
                    'min'  => '1',
                    'max'  => '100',
                    'step' => '1',
                ),
                'mobile_options'   => true,
                'responsive'       => true,
                'unitless'         => true,
                'show_if'         => array(
                    'use_overlay' => 'on',
                ),
            ),
            'dnxte_show_title' => array(
				'label'              => esc_html__( 'Show Title', 'et_builder' ),
				'type'               => 'yes_no_button',
				'option_category'    => 'basic_option',
				'options'            => array(
					'on'  => 'Yes',
					'off' => 'No' ,
                ),
				'default_on_front'   => 'off',
				'description'        => esc_html__( 'Whether or not to show the title for images (if available).', 'et_builder' ),
				'toggle_slug'        => 'dnxte_settings',
				'mobile_options'     => true,
				'hover'              => 'tabs',
			),
            'dnxte_show_caption' => array(
				'label'              => esc_html__( 'Show Caption', 'et_builder' ),
				'type'               => 'yes_no_button',
				'option_category'    => 'basic_option',
				'options'            => array(
					'on'  => 'Yes',
					'off' => 'No' ,
                ),
				'default_on_front'   => 'off',
				'description'        => esc_html__( 'Whether or not to show the caption for images (if available).', 'et_builder' ),
				'toggle_slug'        => 'dnxte_settings',
				'mobile_options'     => true,
				'hover'              => 'tabs',
			),
            'dnxte_caption_position' => array(
				'label'           => esc_html__('Caption Position', 'et_builder'),
				'type'            => 'select',
				'description'     => esc_html__('Select the position of image caption', 'et_builder'),
				'option_category' => 'basic_option',
				'toggle_slug'     => 'dnxte_settings',
				'options'         => array(
					'both' => esc_html__('Both', 'et_builder'),
					'gallery' => esc_html__('On Gallery', 'et_builder'),
					'lightbox' => esc_html__('On Lightbox', 'et_builder'),
				),
				'default'         => 'both',
                'depends_on'      => array( 'dnxte_show_caption' ),
				'depends_show_if' => 'on',
			),
            'dnxte_details_position_on_lightbox' => array(
				'label'           => esc_html__('Title Caption on Lightbox', 'et_builder'),
				'type'            => 'select',
				'description'     => esc_html__('Select the position of image caption', 'et_builder'),
				'option_category' => 'basic_option',
				'toggle_slug'     => 'dnxte_settings',
				'options'         => array(
					'on_image' => esc_html__('Over the Image', 'et_builder'),
					'bottom_image' => esc_html__('Below the Image', 'et_builder'),
				),
				'default'         => 'on_image',
                'show_if'         => array(
                    'dnxte_show_caption' => 'on',
                    'dnxte_caption_position' => array('both', 'lightbox')
                )
			),
            '__gallery'           => array(
                'type'                => 'computed',
                'computed_callback'   => array('Next_Masonary', 'get_gallery'),
                'computed_depends_on' => array(
                    'gallery_ids',
                ),
            ),
            'dnxtemasonary_title_margin' => array(
                'label' => esc_html__('Title Margin', 'et_builder'),
                'type' => 'custom_margin',
                'mobile_options' => true,
                'hover' => 'tabs',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'default'       => "20px|0|0|0",
                'tab_slug' => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'dnxtemasonary_title_padding' => array(
                'label'           => esc_html__('Title Padding', 'et_builder'),
                'type'            => 'custom_padding',
                'mobile_options'  => true,
                'hover'           => 'tabs',
                'allowed_units'   => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'margin_padding',
            ),
            'dnxtemasonary_caption_margin' => array(
                'label'           => esc_html__('Caption Margin', 'et_builder'),
                'type'            => 'custom_margin',
                'mobile_options'  => true,
                'hover'           => 'tabs',
                'allowed_units'   => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'margin_padding',
            ),
            'dnxtemasonary_caption_padding' => array(
                'label'           => esc_html__('Caption Padding', 'et_builder'),
                'type'            => 'custom_padding',
                'mobile_options'  => true,
                'hover'           => 'tabs',
                'allowed_units'   => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
                'toggle_slug' => 'margin_padding',
            ),
            'dnxtemasonary_icon_margin' => array(
                'label'           => esc_html__('Icon Margin', 'et_builder'),
                'type'            => 'custom_margin',
                'mobile_options'  => true,
                'hover'           => 'tabs',
                'allowed_units'   => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'margin_padding',
            ),
            'dnxtemasonary_icon_padding' => array(
                'label'           => esc_html__('Icon Padding', 'et_builder'),
                'type'            => 'custom_padding',
                'mobile_options'  => true,
                'hover'           => 'tabs',
                'default'         => '10px|10px|10px|10px',
                'allowed_units'   => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'margin_padding',
            ),
            'dnxtemasonary_filter_m_margin' => array(
                'label'           => esc_html__('Filter Menu Margin', 'et_builder'),
                'type'            => 'custom_margin',
                'mobile_options'  => true,
                'hover'           => 'tabs',
                'allowed_units'   => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'margin_padding',
                'show_if'        => array(
                    'dnxte_gallery_bar' => 'on',
                ),
            ),
            'dnxtemasonary_filter_m_padding' => array(
                'label'           => esc_html__('Filter Menu Padding', 'et_builder'),
                'type'            => 'custom_padding',
                'mobile_options'  => true,
                'hover'           => 'tabs',
                'allowed_units'   => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'margin_padding',
                'show_if'        => array(
                    'dnxte_gallery_bar' => 'on',
                ),
            ),
            'dnxtemasonary_filter_mi_margin' => array(
                'label'           => esc_html__('Filter Menu Item Margin', 'et_builder'),
                'type'            => 'custom_margin',
                'mobile_options'  => true,
                'hover'           => 'tabs',
                'allowed_units'   => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'margin_padding',
                'show_if'        => array(
                    'dnxte_gallery_bar' => 'on',
                ),
            ),
            'dnxtemasonary_filter_mi_padding' => array(
                'label'           => esc_html__('Filter Menu Item Padding', 'et_builder'),
                'type'            => 'custom_padding',
                'mobile_options'  => true,
                'hover'           => 'tabs',
                'allowed_units'   => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'margin_padding',
                'show_if'        => array(
                    'dnxte_gallery_bar' => 'on',
                ),
            ),
            'dnxte_lightbox_arrow_color'  => array(
                'label'          => esc_html__('Lightbox Arrow Color', 'et_builder'),
                'description'    => esc_html__('Color of the lightbox arrow.', 'et_builder'),
                'type'           => 'color-alpha',
                'toggle_slug'    => 'dnxte_lightbox_colors',
                'custom_color'   => true,
                'tab_slug'       => 'advanced',
                'mobile_options' => true,
                'responsive'     => true,
                'hover'          => 'tabs'
            ),
            'dnxte_lightbox_close_btn_color'  => array(
                'label'          => esc_html__('Lightbox Close Button Color', 'et_builder'),
                'description'    => esc_html__('Color of the lightbox close button.', 'et_builder'),
                'type'           => 'color-alpha',
                'toggle_slug'    => 'dnxte_lightbox_colors',
                'custom_color'   => true,
                'tab_slug'       => 'advanced',
                'mobile_options' => true,
                'responsive'     => true,
                'hover'          => 'tabs'
            ),
        );
        $additional = array(
            'filter_bg_color' => array(
                'label' => esc_html__('Filter Background', 'et_builder'),
                'type' => 'background-field',
                'base_name' => "filter_bg",
                'context' => "filter_bg",
                'option_category' => 'layout',
                'custom_color' => true,
                'default' => ET_Global_Settings::get_value('all_buttons_bg_color'),
                'depends_on'      => array( 'dnxte_gallery_bar' ),
                'depends_show_if' => 'on',
                'option_category' => 'basic_option',
                'toggle_slug'     => 'dnxte_filter_bar',
                'background_fields' => array_merge(
                    ET_Builder_Element::generate_background_options(
                        'filter_bg',
                        'gradient',
                        "advanced",
						"icon",
                        "filter_bg_gradient"
                    ),
                    ET_Builder_Element::generate_background_options(
                        "filter_bg",
                        "color",
                        "advanced",
                        "icon",
                        "filter_bg_color"
                    )
                    ),
                'mobile_options' => true,
                'hover' => 'tabs'
			),
        );

        $additional = array_merge(
            $additional,
            $this->generate_background_options(
                'filter_bg',
                'skip',
                "advanced",
                "icon",
                "filter_bg_gradient"
            ),
            $this->generate_background_options(
                'filter_bg',
                'skip',
                "advanced",
                "icon",
                "filter_bg_color"
			)
        );

        $hover_arr = array(
            'hover'     => 'tabs',
            'show_if'        => array(
                'use_overlay' => 'on',
            ),
        );

        // dnxte_msnary_filter_active_bg_color
        $filter_active_bg_color = Common::background_fields($this, "dnxte_msnary_filter_active_", "Filter Active Color", "dnxte_filter_bar", "general", array(
            'hover'     => 'tabs',
        ));

        // dnxte_msnary_overlay_bg_color
        $overlay_bg_color = Common::background_fields($this, "dnxte_msnary_overlay_", "Overlay Background Color", "dnxte_overlay_bg", "general", array(
            'hover'     => 'tabs',
            'show_if'        => array(
                'use_overlay' => 'on',
            ),
        ));

        // dnxte_msnary_icon_bg_color
        $icon_bg_color = Common::background_fields($this, "dnxte_msnary_icon_", "Icon Background Color", "dnxte_overlay", "general", $hover_arr);

        // dnxte_lightbox_overlay_bg_color
        $lightbox_overlay_bg_color = Common::background_fields($this, "dnxte_lightbox_overlay_", "Lightbox Overlay Background", "dnxte_lightbox_colors", "general", array(
            'default'   => '#000000cc'
        ));

        return array_merge($fields, $additional, $filter_active_bg_color, $overlay_bg_color, $icon_bg_color, $lightbox_overlay_bg_color);
    }

    static function get_gallery($args, $orderby) {
        $attachments = array();

        $defaults = array(
            'gallery_ids'     => array(),
            'gallery_orderby' => '',
            'thumb_size'      => '',
            'thumb_width'     => '',
            'thumb_height'    => '',
        );

        $args = wp_parse_args($args, $defaults);

        if ($orderby == 'rand') {
            $gallery_random = explode(",", $args['gallery_ids']);
            $random = shuffle($gallery_random);
            $gallery_random = implode(",", $gallery_random);
        } else {
            $gallery_random = $args['gallery_ids'];
        }

        $attachments_args = array(
            'include'        => $gallery_random,
            'post_status'    => 'inherit',
            'post_type'      => 'attachment',
            'post_mime_type' => 'image',
            'order'          => 'ASC',
            'orderby'        => 'post__in',
        );

        $thumb_size     ="";
        if ( 'custom' === $args['thumb_size'] ) {
            $thumb_size = array( intval( $args['thumb_width'] ), intval( $args['thumb_height'] ) );
        }else {
            $thumb_size = $args['thumb_size'];
        }

        $_attachments = get_posts($attachments_args);


        foreach ($_attachments as $key => $val) {
            $attachments[$key] = $_attachments[$key];
            $attachments[$key]->image_alt_text  = get_post_meta($val->ID, '_wp_attachment_image_alt', true);
            $attachments[$key]->image_src_full  = wp_get_attachment_image_src($val->ID, 'full');
            $attachments[$key]->image_src_thumb = wp_get_attachment_image($val->ID, $thumb_size );
            $attachments[$key]->link_url        = get_post_meta($val->ID, 'dnxte_link_url', true);
            $attachments[$key]->link_target     = get_post_meta($val->ID, 'dnxte-image-url-target', true);
        }

        return $attachments;
    }

    public function callingScriptAndStyles() {
        wp_enqueue_script( 'dnext_isotope' );
        wp_enqueue_script( 'dnext_scripts-public' );
        wp_script_is( 'magnific-popup', 'enqueued' ) ? wp_enqueue_script( 'magnific-popup' ) : wp_enqueue_script( 'dnext_magnific_popup');

        wp_enqueue_style( 'dnext_magnific_popup' );
        wp_enqueue_style( 'dnext_msnary_hvr_css' );
        wp_enqueue_style( 'dnext_msnary_filterbar_css' );
    }

    public function render($attrs, $content, $render_slug) {
        $this->callingScriptAndStyles();

        $multi_view                       = et_pb_multi_view_options($this);
        $gallery_ids                      = $this->props['gallery_ids'];
        $gallery_orderby                  = $this->props['gallery_orderby'];
        $header_level                     = $this->props['title_level'];
        $dnxte_gallery_bar                = $this->props['dnxte_gallery_bar'];
        $dnxte_filtering_text_all         = $this->props['dnxte_filtering_text_all'];
        $dnxte_choose_lightbox            = $this->props['dnxte_choose_lightbox'];
        $thumb_size                       = $this->props['thumb_size'];
        $thumb_width                      = $this->props['thumb_width'];
        $thumb_height                     = $this->props['thumb_height'];


        $hover_icon = $hover_icon_values = $hover_icon_tablet = $hover_icon_phone = '';
        $hover_icon_weight = $hover_icon_weight_tablet = $hover_icon_weight_phone = '';

        $icon_fontawesome = explode('||', $this->props['hover_icon']);
        $icon_fontawesome_values = et_pb_responsive_options()->get_property_values($this->props, 'hover_icon');
		$icon_fontawesome_tablet = isset($icon_fontawesome_values['tablet']) ? explode( '||', $icon_fontawesome_values['tablet'] ) : '';
		$icon_fontawesome_phone = isset($icon_fontawesome_values['phone']) ? explode( '||', $icon_fontawesome_values['phone'] ) : '';

        if('off' !== $this->props['use_overlay']) {
            $hover_icon = isset($icon_fontawesome[0]) ? $icon_fontawesome[0] : '';
            $hover_icon_weight = isset($icon_fontawesome[2]) ? $icon_fontawesome[2] : '';
			$hover_icon_tablet = isset($icon_fontawesome_tablet[0]) && '' !== $icon_fontawesome_tablet[0] ? $icon_fontawesome_tablet[0] : $hover_icon;
			$hover_icon_weight_tablet = isset($icon_fontawesome_tablet[2]) ? $icon_fontawesome_tablet[2] : $hover_icon_weight;
			$hover_icon_phone = isset($icon_fontawesome_phone[0]) && '' !== $icon_fontawesome_phone[0] ? $icon_fontawesome_phone[0] : $hover_icon_tablet;
			$hover_icon_weight_phone = isset($icon_fontawesome_phone[2]) ? $icon_fontawesome_phone[2] : $hover_icon_weight_tablet;
        }

        $font_name = array('fa' => 'FontAwesome', 'divi' => 'ETmodules');
		$font_styles = isset($icon_fontawesome[1]) && array_key_exists($icon_fontawesome[1], $font_name) ? sprintf('font-family: %1$s !important;font-weight: %2$s !important;', $font_name[$icon_fontawesome[1]], $hover_icon_weight) : "font-family: ETmodules !important;";
        $font_styles_tablet = isset($icon_fontawesome_tablet[1]) && array_key_exists($icon_fontawesome_tablet[1], $font_name) ? sprintf('font-family: %1$s !important;font-weight: %2$s !important;', $font_name[$icon_fontawesome_tablet[1]], $hover_icon_weight_tablet) : "font-family: ETmodules !important;";
        $font_styles_phone = isset($icon_fontawesome_phone[1]) && array_key_exists($icon_fontawesome_phone[1], $font_name) ? sprintf('font-family: %1$s !important;font-weight: %2$s !important;', $font_name[$icon_fontawesome_phone[1]], $hover_icon_weight_phone) : "font-family: ETmodules !important;";

        ET_Builder_Element::set_style($render_slug, array(
            'selector'    	=> "%%order_class%% .dnxte_ovl.et_overlay::before",
            'declaration'	=> $font_styles
        ) );
        ET_Builder_Element::set_style($render_slug, array(
            'selector'    	=> "%%order_class%% .dnxte_ovl.et_overlay::before",
            'declaration'	=> $font_styles_tablet,
            'media_query'   => ET_Builder_Element::get_media_query('max_width_980')
        ) );
        ET_Builder_Element::set_style($render_slug, array(
            'selector'    	=> "%%order_class%% .dnxte_ovl.et_overlay::before",
            'declaration'	=> $font_styles_phone,
            'media_query'   => ET_Builder_Element::get_media_query('max_width_767')
        ) );

        // Overlay Settings.
        if ("off" !== $this->props['use_overlay']) {
            $overlay_icon_color_values = et_pb_responsive_options()->get_property_values($this->props, 'overlay_icon_color');
            et_pb_responsive_options()->generate_responsive_css($overlay_icon_color_values, '%%order_class%% .dnxte_ovl.et_overlay:before', 'color', $render_slug, '', 'color');
        }

        $this->dnxte_apply_css($render_slug);

        // Get gallery item data
        $attachments = $this->get_gallery(array(
            'gallery_ids'     => $gallery_ids,
            'gallery_orderby' => $gallery_orderby,
            'thumb_size'      => $thumb_size,
            'thumb_width'     => $thumb_width,
            'thumb_height'    => $thumb_height,
        ), $gallery_orderby);

        $terms = get_terms( array(
            'hide_empty' => false,
            'taxonomy'   => 'gallery_categories',
        ) );

        if (empty($attachments)) return '';

        $termArray = array();
        foreach($attachments as $value) {
            $term_slug = $this->get_gllary_the_terms($value->ID, "arr");
            if(is_array($term_slug)) {
                foreach ($term_slug as $t) {
                    if(!in_array($t, $termArray)) {
                        array_push($termArray, $t);
                    }
                }
            }else {
                if(!in_array($term, $termArray)) {
                    array_push($termArray, $term);
                }
            }
        }

        $output = '<div class="dnxte-msnary-wrapper">';
            if( 'off' !== $dnxte_gallery_bar ){
                $output .= sprintf('<div class="dnxte-msnary-item-wrapper"><ul class="dnxte-msnary-filter-items dnxte-msnary-layout-%1$s">', $this->props['dnxte_masonry_filter_effect']);

                $output .= '<li class="dnxte-msnary-filter-item active" data-filter="*">'.esc_html( $dnxte_filtering_text_all ).'</li>';

                if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
                    foreach( $terms as $term ){
                       if(in_array($term->slug, $termArray)) {
                        $output .= '<li class="dnxte-msnary-filter-item" data-filter=".'.esc_attr( $term->slug ).'">'.esc_html( $term->name).'</li>';
                       }
                    }
                }

                $output .= '</ul></div>';
            }

        $lightbox_on_off = 'lightbox' === $dnxte_choose_lightbox ? true : false;
        $output .= sprintf('<div class="dnxte-grid"><div class="dnxte-msnary-grid" data-lightbox="%2$s" data-gutter="%1$s" data-columns="%3$s"><div class="grid-sizer"></div><div class="gutter-sizer"></div>', $this->props['dnxte_gutter'], $lightbox_on_off, $this->props['dnxte_columns']);

        $images_count = 0;

        foreach ($attachments as $id => $attachment) {
            $link_url    = $attachment->link_url;
            $link_target = $attachment->link_target;

            $title = 'off' !== $this->props['dnxte_show_title'] ? sprintf('<div class='.'dnxte-mfe-title'.'>%1$s</div>', wptexturize( $attachment->post_title )) : '';
            $caption = 'off' !== $this->props['dnxte_show_caption'] && ('both' === $this->props['dnxte_caption_position'] || 'lightbox' === $this->props['dnxte_caption_position']) ? sprintf('<small class='.'dnxte-mfe-caption'.'>%1$s</small>', wptexturize( $attachment->post_excerpt )) : '';

            $lightbox_or_link =  ('link' !== $dnxte_choose_lightbox ? esc_url($attachment->image_src_full[0]) : esc_url( $link_url ));

            $href = 'none' !== $dnxte_choose_lightbox ? sprintf('href="%1$s"', $lightbox_or_link) : '';

            $image_output = sprintf(
                '<a class="image-link imghvr-msnary-%6$s imghve-color" %1$s target="%5$s" data-title="%3$s" data-caption="%4$s">
                    %2$s
                </a>',
                $href,
                $attachment->image_src_thumb,
                $title,
                $caption,
                ('link' !== $dnxte_choose_lightbox ? '' : esc_html( $link_target )),
                $this->props['dnxte_masonry_hvr_effect']
            );

            $images_count++;

            $_term_slug = $this->get_gllary_the_terms($attachment->ID);

            $output .= sprintf(
                '<div class="dnxte-msnary-item et_pb_gallery_image %2$s"> %1$s',
				$image_output,
                $_term_slug
            );

            $details = "<div class='dnxte-msnary-details'>";
            if ( "off" !== $this->props['dnxte_show_title'] || "off" !== $this->props['dnxte_show_caption']) {
                if ( trim( $attachment->post_title ) ) {
                    $details .= $multi_view->render_element( array(
                        'tag'     => et_pb_process_header_level( $header_level, 'h3' ),
                        'content' => wptexturize( $attachment->post_title ),
                        'attrs'   => array(
                            'class' => 'dnxte-msnary-heading',
                        ),
                        'visibility' => array(
                            'dnxte_show_title' => 'on',
                        ),
                    ) );
                }
                if ( trim( $attachment->post_excerpt ) ) {
                    $details .= $multi_view->render_element( array(
                        'tag'     => 'p',
                        'content' => wptexturize( $attachment->post_excerpt ),
                        'attrs'   => array(
                            'class' => 'dnxte-msnary-pra',
                        ),
                        'visibility' => array(
                            'dnxte_show_caption' => 'on',
                            'dnxte_caption_position' => array(
                                'both',
                                'gallery'
                            )
                        ),
                    ) );
                }
            }
            $details .= "</div></div><!-- .dnxte-msnary-details -->";

            $output .= sprintf(
                '<span class="dnxte_ovl et_overlay" data-icon="%1$s" data-icon-tablet="%2$s" data-icon-phone="%3$s" >
                    %4$s
                </span>',
                esc_attr(et_pb_process_font_icon($hover_icon)),
                esc_attr(et_pb_process_font_icon($hover_icon_tablet)),
                esc_attr(et_pb_process_font_icon($hover_icon_phone)),
                $details
            );
        }
        $output .= "</div></div></div><!-- .dnxte-msnary-grid -->";

        return $output;
    }

    private function get_gllary_the_terms( $post_id, $type="" ){
        $terms = get_the_terms( $post_id, 'gallery_categories' );
        $_terms = array();
        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
            foreach ( $terms as $term ) {
                $_terms[$term->term_id] = $term->slug;
            }
        }

        return $type != "arr" ? join(' ', $_terms) : $_terms;
    }

    public function dnxte_apply_css($render_slug) {
        // Custom Margin & Padding Output
        Common::dnxt_set_style($render_slug, $this->props, "dnxtemasonary_title_margin", "%%order_class%% .dnxte-msnary-heading", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "dnxtemasonary_title_padding", "%%order_class%% .dnxte-msnary-heading", "padding");

        Common::dnxt_set_style($render_slug, $this->props, "dnxtemasonary_caption_margin", "%%order_class%% .dnxte-msnary-pra", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "dnxtemasonary_caption_padding", "%%order_class%% .dnxte-msnary-pra", "padding");

        Common::dnxt_set_style($render_slug, $this->props, "dnxtemasonary_icon_margin", "%%order_class%% .dnxte_ovl::before", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "dnxtemasonary_icon_padding", "%%order_class%% .dnxte_ovl::before", "padding");

        Common::dnxt_set_style($render_slug, $this->props, "dnxtemasonary_filter_m_margin", "%%order_class%% .dnxte-msnary-filter-items", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "dnxtemasonary_filter_m_padding", "%%order_class%% .dnxte-msnary-filter-items", "padding");

        Common::dnxt_set_style($render_slug, $this->props, "dnxtemasonary_filter_mi_margin", "%%order_class%% .dnxte-msnary-filter-item", "margin");
        Common::dnxt_set_style($render_slug, $this->props, "dnxtemasonary_filter_mi_padding", "%%order_class%% .dnxte-msnary-filter-item", "padding");

        $dnxte_columns                   = $this->props["dnxte_columns"];
        $dnxte_columns_responsive_active = isset($this->props["dnxte_columns_last_edited"]) && et_pb_get_responsive_status($this->props["dnxte_columns_last_edited"]);
        $dnxte_columns_tablet            = $dnxte_columns_responsive_active && $this->props["dnxte_columns_tablet"] ? $this->props["dnxte_columns_tablet"] : $dnxte_columns;
        $dnxte_columns_phone             = $dnxte_columns_responsive_active && $this->props["dnxte_columns_phone"] ? $this->props["dnxte_columns_phone"] : $dnxte_columns_tablet;

        $dnxte_gutter                   = $this->props["dnxte_gutter"];
        $dnxte_gutter_responsive_active = isset($this->props["dnxte_gutter_last_edited"]) && et_pb_get_responsive_status($this->props["dnxte_gutter_last_edited"]);
        $dnxte_gutter_tablet            = $dnxte_gutter_responsive_active && isset($this->props["dnxte_gutter_tablet"]) ? $this->props["dnxte_gutter_tablet"] : $dnxte_gutter;
        $dnxte_gutter_phone             = $dnxte_gutter_responsive_active && isset($this->props["dnxte_gutter_phone"]) ? $this->props["dnxte_gutter_phone"] : $dnxte_gutter_tablet;

        //Width of grid items
        if ('' !== $dnxte_columns || '' !== $dnxte_gutter) {
            ET_Builder_Element::set_style($render_slug, [
                'selector'    => '%%order_class%% .grid-sizer, %%order_class%% .dnxte-msnary-item',
                'declaration' => "width: calc((100% - ({$dnxte_columns} - 1) * {$dnxte_gutter}px) / {$dnxte_columns});",
            ]);

            ET_Builder_Element::set_style($render_slug, [
                'selector'    => '%%order_class%% .grid-sizer, %%order_class%% .dnxte-msnary-item',
                'declaration' => "width: calc((100% - ({$dnxte_columns_tablet} - 1) * {$dnxte_gutter_tablet}px) / {$dnxte_columns_tablet});",
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ]);

            ET_Builder_Element::set_style($render_slug, [
                'selector'    => '%%order_class%% .grid-sizer, %%order_class%% .dnxte-msnary-item',
                'declaration' => "width: calc((100% - ({$dnxte_columns_phone} - 1) * {$dnxte_gutter_phone}px) / {$dnxte_columns_phone});",
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ]);
        }

        //Gutter of grid items
        if ("" !== $dnxte_gutter) {
            ET_Builder_Element::set_style($render_slug, [
                'selector'    => '%%order_class%% .dnxte-msnary-item',
                'declaration' => "margin-bottom: {$dnxte_gutter}px;",
            ]);

            ET_Builder_Element::set_style($render_slug, [
                'selector'    => '%%order_class%% .dnxte-msnary-item',
                'declaration' => "margin-bottom: {$dnxte_gutter_tablet}px;",
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ]);

            ET_Builder_Element::set_style($render_slug, [
                'selector'    => '%%order_class%% .dnxte-msnary-item',
                'declaration' => "margin-bottom: {$dnxte_gutter_phone}px;",
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ]);

            ET_Builder_Element::set_style($render_slug, [
                'selector'    => '%%order_class%% .gutter-sizer',
                'declaration' => "width: {$dnxte_gutter}px;",
            ]);

            ET_Builder_Element::set_style($render_slug, [
                'selector'    => '%%order_class%% .gutter-sizer',
                'declaration' => "width: {$dnxte_gutter_tablet}px;",
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ]);

            ET_Builder_Element::set_style($render_slug, [
                'selector'    => '%%order_class%% .gutter-sizer',
                'declaration' => "width: {$dnxte_gutter_phone}px;",
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ]);
        }

        // Filter Background color start
        $filter_bg_color = array(
            'color_slug' => "filter_bg_color"
        );
        $use_color_gradient = $this->props['filter_bg_use_color_gradient'];
        $gradient = array(
            "gradient_type"           => 'filter_bg_color_gradient_type',
            "gradient_direction"      => 'filter_bg_color_gradient_direction',
            "radial"                  => 'filter_bg_color_gradient_direction_radial',
            "gradient_start"          => 'filter_bg_color_gradient_start',
            "gradient_end"            => 'filter_bg_color_gradient_end',
            "gradient_start_position" => 'filter_bg_color_gradient_start_position',
            "gradient_end_position"   => 'filter_bg_color_gradient_end_position',
            "gradient_overlays_image" => 'filter_bg_color_gradient_overlays_image',
        );
        $css_property = array(
            "desktop" => "%%order_class%% .dnxte-msnary-filter-item",
            "hover" => "%%order_class%% .dnxte-msnary-filter-item:hover"
        );
        Common::apply_bg_css($render_slug, $this, $filter_bg_color, $use_color_gradient, $gradient, $css_property);
        // Filter background color end
        // Filter active background color start
        $filter_active_bg_color = array(
            'color_slug' => "dnxte_msnary_filter_active_bg_color"
        );
        $use_color_gradient = $this->props['dnxte_msnary_filter_active_bg_use_color_gradient'];
        $gradient = array(
            "gradient_type"           => 'dnxte_msnary_filter_active_bg_color_gradient_type',
            "gradient_direction"      => 'dnxte_msnary_filter_active_bg_color_gradient_direction',
            "radial"                  => 'dnxte_msnary_filter_active_bg_color_gradient_direction_radial',
            "gradient_start"          => 'dnxte_msnary_filter_active_bg_color_gradient_start',
            "gradient_end"            => 'dnxte_msnary_filter_active_bg_color_gradient_end',
            "gradient_start_position" => 'dnxte_msnary_filter_active_bg_color_gradient_start_position',
            "gradient_end_position"   => 'dnxte_msnary_filter_active_bg_color_gradient_end_position',
            "gradient_overlays_image" => 'dnxte_msnary_filter_active_bg_color_gradient_overlays_image',
        );
        $css_property = array(
            "desktop" => "%%order_class%% .dnxte-msnary-filter-items li.active, %%order_class%% .dnxte-msnary-filter-items li:hover",
            "hover" => "%%order_class%% .dnxte-msnary-filter-items li:hover"
        );
        Common::apply_bg_css($render_slug, $this, $filter_active_bg_color, $use_color_gradient, $gradient, $css_property);
        // Filter active background color end

        // Overlay Background Color Start
        $overlay_bg_color = array(
            'color_slug' => "dnxte_msnary_overlay_bg_color"
        );
        $use_color_gradient = $this->props['dnxte_msnary_overlay_bg_use_color_gradient'];
        $gradient = array(
            "gradient_type"           => 'dnxte_msnary_overlay_bg_color_gradient_type',
            "gradient_direction"      => 'dnxte_msnary_overlay_bg_color_gradient_direction',
            "radial"                  => 'dnxte_msnary_overlay_bg_color_gradient_direction_radial',
            "gradient_start"          => 'dnxte_msnary_overlay_bg_color_gradient_start',
            "gradient_end"            => 'dnxte_msnary_overlay_bg_color_gradient_end',
            "gradient_start_position" => 'dnxte_msnary_overlay_bg_color_gradient_start_position',
            "gradient_end_position"   => 'dnxte_msnary_overlay_bg_color_gradient_end_position',
            "gradient_overlays_image" => 'dnxte_msnary_overlay_bg_color_gradient_overlays_image',
        );
        $css_property = array(
            "desktop" => "%%order_class%% .dnxte_ovl.et_overlay, %%order_class%% .imghve-color:before,%%order_class%% .imghve-color:after",
            "hover" => "%%order_class%% .dnxte_ovl.et_overlay:hover"
        );
        Common::apply_bg_css($render_slug, $this, $overlay_bg_color, $use_color_gradient, $gradient, $css_property);
        // Overlay Background Color End

        // Icon Background Color Start
        $icon_bg_color = array(
            'color_slug' => "dnxte_msnary_icon_bg_color"
        );
        $use_color_gradient = $this->props['dnxte_msnary_icon_bg_use_color_gradient'];
        $gradient = array(
            "gradient_type"           => 'dnxte_msnary_icon_bg_color_gradient_type',
            "gradient_direction"      => 'dnxte_msnary_icon_bg_color_gradient_direction',
            "radial"                  => 'dnxte_msnary_icon_bg_color_gradient_direction_radial',
            "gradient_start"          => 'dnxte_msnary_icon_bg_color_gradient_start',
            "gradient_end"            => 'dnxte_msnary_icon_bg_color_gradient_end',
            "gradient_start_position" => 'dnxte_msnary_icon_bg_color_gradient_start_position',
            "gradient_end_position"   => 'dnxte_msnary_icon_bg_color_gradient_end_position',
            "gradient_overlays_image" => 'dnxte_msnary_icon_bg_color_gradient_overlays_image',
        );
        $css_property = array(
            "desktop" => "%%order_class%% .dnxte_ovl.et_overlay:before",
            "hover" => "%%order_class%% .dnxte_ovl.et_overlay:hover::before"
        );
        Common::apply_bg_css($render_slug, $this, $icon_bg_color, $use_color_gradient, $gradient, $css_property);
        // Icon Background Color End

        // Lightbox Overlay background color start
        $lightbox_overlay = array(
            'color_slug' => "dnxte_lightbox_overlay_bg_color"
        );
        $use_color_gradient = $this->props['dnxte_lightbox_overlay_bg_use_color_gradient'];
        $gradient = array(
            "gradient_type"           => 'dnxte_lightbox_overlay_bg_color_gradient_type',
            "gradient_direction"      => 'dnxte_lightbox_overlay_bg_color_gradient_direction',
            "radial"                  => 'dnxte_lightbox_overlay_bg_color_gradient_direction_radial',
            "gradient_start"          => 'dnxte_lightbox_overlay_bg_color_gradient_start',
            "gradient_end"            => 'dnxte_lightbox_overlay_bg_color_gradient_end',
            "gradient_start_position" => 'dnxte_lightbox_overlay_bg_color_gradient_start_position',
            "gradient_end_position"   => 'dnxte_lightbox_overlay_bg_color_gradient_end_position',
            "gradient_overlays_image" => 'dnxte_lightbox_overlay_bg_color_gradient_overlays_image',
        );
        $css_property = array(
            "desktop" => ".mfp-bg",
            "hover" => ".mfp-bg"
        );
        Common::apply_bg_css($render_slug, $this, $lightbox_overlay, $use_color_gradient, $gradient, $css_property);
        // Lightbox Overlay background color end

        // Gallery Filter active text color start
        $active_text_color_css_property = 'color: %1$s !important;';
        $active_text_color_css_selector = array(
            'desktop' => "%%order_class%% .dnxte-msnary-filter-items li.active",
            'hover'   => "%%order_class%% .dnxte-msnary-filter-items li.active:hover"
        );
        Common::set_css("dnxte_filter_active_text_color", $active_text_color_css_property, $active_text_color_css_selector, $render_slug, $this);
        // Gallery Filter active text color end

        // lightbox arrow color start
        $arrow_color_css_property = 'color: %1$s !important;';
        $arrow_color_css_selector = array(
            'desktop' => ".mfp-arrow:after",
            'hover'   => ".mfp-arrow:hover::after"
        );
        Common::set_css("dnxte_lightbox_arrow_color", $arrow_color_css_property, $arrow_color_css_selector, $render_slug, $this);
        // lightbox arrow color end

        // lightbox close btnn color start
        $close_btn_color_css_property = 'color: %1$s !important;';
        $close_btn_color_css_selector = array(
            'desktop' => ".dnxte-msnary-mfp-config .mfp-close",
            'hover'   => ".dnxte-msnary-mfp-config .mfp-close:hover"
        );
        Common::set_css("dnxte_lightbox_close_btn_color", $close_btn_color_css_property, $close_btn_color_css_selector, $render_slug, $this);
        // lightbox close btnn color end


        // hover icon size
        $icon_size = $this->props['dnxte_icon_size'];
        // $icon_area = $icon_size + 8;
        $icon_size_responsive_active = isset($this->props['dnxte_icon_size_last_edited']) && et_pb_get_responsive_status($this->props['dnxte_icon_size_last_edited']);
        $icon_size_tablet = $icon_size_responsive_active && $this->props['dnxte_icon_size_tablet'] ? $this->props['dnxte_icon_size_tablet'] : $icon_size;
        // $icon_area_tablet = $icon_size_tablet + 8;
        $icon_size_phone = $icon_size_responsive_active && $this->props['dnxte_icon_size_phone'] ? $this->props['dnxte_icon_size_phone'] : $icon_size_tablet;
        // $icon_area_phone = $icon_size_phone + 8;

        $icon_size_style = sprintf('font-size: %1$spx;', $icon_size);
        $icon_size_style_tablet = sprintf('font-size: %1$spx;', $icon_size_tablet);
        $icon_size_style_phone = sprintf('font-size: %1$spx;', $icon_size_phone);

        ET_Builder_Element::set_style($render_slug, [
            'selector'    => '%%order_class%% .dnxte_ovl:before',
            'declaration' => $icon_size_style,
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector'    => '%%order_class%% .dnxte_ovl:before',
            'declaration' => $icon_size_style_tablet,
            'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector'    => '%%order_class%% .dnxte_ovl:before',
            'declaration' => $icon_size_style_phone,
            'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
        ]);
        // hover icon size end

        // Details position On lightbox
        $details_position_on_lightbox = "on_image" === $this->props['dnxte_details_position_on_lightbox'] ? 'position:absolute' : 'position:relative';

        ET_Builder_Element::set_style($render_slug, [
            'selector'    => '.dnxte-msnary-mfp-config .mfp-bottom-bar .mfp-title',
            'declaration' => $details_position_on_lightbox,
        ]);
        // Details position on lightbox end
    }
}

new Next_Masonary;