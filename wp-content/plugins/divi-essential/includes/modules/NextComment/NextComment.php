<?php


class NextComment extends ET_Builder_Module
{
    public $slug = 'dnxte_comment';
    public $vb_support = 'on';

    protected $module_credits = array(
        'module_uri' => 'https://www.diviessential.com/divi-embedded-comment/',
        'author'     => 'Divi Next',
        'author_uri' => 'www.divinext.com',
    );

    public function init(){
        $this->name        = esc_html__('Next FB Comment', 'et_builder');
        $this->icon_path   = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->folder_name = 'et_pb_divi_essential';

        $this->settings_modal_toggles           = array(
            'general'                           => array(
                'toggles'                       => array(
                    'dnxte_comments_elements'   => esc_html__('Comments Elements', 'et_builder')
                )
            )
        );
    }

    public function get_advanced_fields_config(){
        return array(
            'text'                          => false,
            'fonts'                         => false,
            'borders'                       => array(
                'default'                   => array(
                    'css'                   => array(
                        'main'              => array(
                            'border_radii'  => "%%order_class%% .fb-comments",
                            'border_styles' => "%%order_class%% .fb-comments",
                        ),
                        'important'         => 'all'
                    ),
                ),
            ),
            'box_shadow'                    => array(
                'default'                   => array(
                    'css'                   => array(
                        'main'              => '%%order_class%% .fb-comments',
                        'custom_style'      => true,
                    ),
                    'default_on_fronts'     => array(
                        'color'             => '',
                        'position'          => '',
                    ),
                ),
            )
        );
    }

    public function get_fields() {
        return array(
            'dnxte_comment_url'             => array(
                'label'                     => esc_html__('URL', 'et_builder'),
                'type'                      => 'text',
                'option_category'           => 'basic_option',
                'description'               => esc_html__('Input Comments URL.', 'et_builder'),
                'toggle_slug'               => 'dnxte_comments_elements',
                'dynamic_content'           => 'text',
            ),
            'dnxte_comment_number_post'     => array(
                'label'                     => esc_html__( 'Number Of Post', 'et_builder' ),
                'type'                      => 'range',
                'option_category'           => 'basic_option',
                'range_settings'            => array(
                    'step'                  => 1,
                    'min'                   => 1,
                    'max'                   => 10,
                ),
                'default'                   => '5',
                'fixed_unit'                => '',
                'validate_unit'             => false,
                'unitless'                  => true,
                'toggle_slug'               => 'dnxte_comments_elements',
                'computed_affects'          => array(
					'__embeddedpost',
				),
            ),
            'dnxte_comment_width'           => array(
                'label'                     => esc_html__( 'Width', 'et_builder' ),
                'type'                      => 'range',
                'option_category'           => 'basic_option',
                'range_settings'            => array(
                    'step'                  => 1,
                    'min'                   => 1,
                    'max'                   => 1000,
                ),
                'default'                   => '750',
                'fixed_unit'                => '',
                'validate_unit'             => false,
                'unitless'                  => true,
                'toggle_slug'               => 'dnxte_comments_elements',
                'computed_affects'          => array(
					'__comment',
				),
            ),
            'dnxte_comment_orderby'         => array(
                'label'                     => esc_html__('Order By', 'et_builder'),
                'type'                      => 'select',
                'option_category'           => 'basic_option',
                'options'                   => array(
                    'social'                => esc_html__('Normal', 'et_builder'),
                    'time'                  => esc_html__('Time', 'et_builder'),
                    'reverse-time'          => esc_html__('Reverse Time', 'et_builder'),
                ),
                'default'                   => 'light',
                'toggle_slug'               => 'dnxte_comments_elements',
            ),
            '__comment'                     => array(
				'type'                      => 'computed',
				'computed_callback'         => array( 'NextComment' ),
				'computed_depends_on'       => array(
					'dnxte_comment_width'
				),
			),
        );
    }

    public function render($attrs, $content, $render_slug){
        wp_enqueue_script( 'dnext_facebook_sdk' );
        if(!$this->props['border_style_all']){
            ET_Builder_Element::set_style($render_slug, array(
                'selector'                  => "%%order_class%% .fb-comments",
                'declaration'               => sprintf('border-style: solid !important;'),
            ));
        }

        return sprintf('
            <div class="fb-comments" data-href="%1$s" data-numposts="%2$s" data-width="%3$s" data-order-by="%4$s">
            </div>
            <div id="fb-root">
            </div>',
            $this->props['dnxte_comment_url'],
            $this->props['dnxte_comment_number_post'],
            $this->props['dnxte_comment_width'],
            $this->props['dnxte_comment_orderby']
        );
    }

}

new NextComment;