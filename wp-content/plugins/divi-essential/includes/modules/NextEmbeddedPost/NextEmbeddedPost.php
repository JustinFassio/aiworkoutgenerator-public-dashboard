<?php


class NextEmbeddedPost extends ET_Builder_Module
{
    public $slug = 'dnxte_embedded_post';
    public $vb_support = 'on';

    protected $module_credits = array(
        'module_uri' => 'https://www.diviessential.com/divi-facebook-embedded-post/',
        'author' => 'Divi Next',
        'author_uri' => 'www.divinext.com',
    );

    public function init(){
        $this->name        = esc_html__('Next FB Embedded Post', 'et_builder');
        $this->icon_path   = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->folder_name = 'et_pb_divi_essential';

        $this->settings_modal_toggles = array(
            'general'                           => array(
                'toggles'                       => array(
                    'dnxte_embed_post_elements' => esc_html__( 'Embed Post Elements', 'et_builder')
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
                            'border_radii'  => "%%order_class%% .fb-post iframe",
                            'border_styles' => "%%order_class%% .fb-post iframe",
                        ),
                        'important'         => 'all'
                    ),
                ),
            ),
            'box_shadow'                    => array(
                'default'                   => array(
                    'css'                   => array(
                        'main'              => '%%order_class%% .fb-post',
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
            'dnxte_embed_post_url'          => array(
                'label'                     => esc_html__('Post URL', 'et_builder'),
                'type'                      => 'text',
                'option_category'           => 'basic_option',
                'description'               => esc_html__('Input Post URL.', 'et_builder'),
                'toggle_slug'               => 'dnxte_embed_post_elements',
                'dynamic_content'           => 'text',
            ),
            'dnxte_embed_post_include_text' => array(
                'label'                     => esc_html__('Include Text', 'et_builder'),
                'type'                      => 'yes_no_button',
                'toggle_slug'               => 'dnxte_embed_post_elements',
                'options'                   => array(
                    'on'                    => esc_html__('Yes', 'et_builder'),
                    'off'                   => esc_html__('No', 'et_builder'),
                ),
                'default_on_front'          => 'on',
            ),
            'dnxte_embed_post_width'        => array(
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
                'toggle_slug'               => 'dnxte_embed_post_elements',
                'computed_affects'          => array(
					'__embeddedpost',
				),
            ),
            '__embeddedpost'                => array(
				'type'                      => 'computed',
				'computed_callback'         => array( 'NextEmbeddedPost' ),
				'computed_depends_on'       => array(
					'dnxte_embed_post_width'
				),
			),
        );
    }

    public function render($attrs, $content, $render_slug){
        wp_enqueue_script( 'dnext_facebook_sdk' );
        if(!$this->props['border_style_all']){
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .fb-post iframe",
                'declaration' => sprintf('border-style: solid !important;'),
            ));
        }

        $show_text = $this->props['dnxte_embed_post_include_text'] == "on";
        return sprintf('
            <div class="fb-post" data-href="%1$s"
            data-show-text="%2$s" data-width="%3$s">
            <blockquote cite="%1$s"
                class="fb-xfbml-parse-ignore">
            </blockquote>
            </div>
            <div id="fb-root"></div>
            ',
            $this->props['dnxte_embed_post_url'],
            $show_text,
            $this->props['dnxte_embed_post_width']
        );
    }
}

new NextEmbeddedPost;