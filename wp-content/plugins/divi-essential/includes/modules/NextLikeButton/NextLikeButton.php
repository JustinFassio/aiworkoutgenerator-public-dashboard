<?php

class NextLikeButton extends ET_Builder_Module
{
    public $slug = 'dnxte_like_button';
    public $vb_support = 'on';

    protected $module_credits = array(
        'module_uri' => 'https://www.diviessential.com/divi-facebook-like/',
        'author' => 'Divi Next',
        'author_uri' => 'www.divinext.com',
    );

    public function init(){
        $this->name        = esc_html__('Next FB Like Button', 'et_builder');
        $this->icon_path   = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->folder_name = 'et_pb_divi_essential';

        $this->settings_modal_toggles           = array(
            'general'                           => array(
                'toggles'                       => array(
                    'dnxte_embed_like_elements' => esc_html__('Like Elements', 'et_builder')
                )
            )
        );
    }

    public function get_advanced_fields_config(){
        return array(
            'text' => false,
            'fonts' => false,
            'borders'                       => array(
                'default'                   => array(
                    'css'                   => array(
                        'main'              => array(
                            'border_radii'  => "%%order_class%% .fb-like",
                            'border_styles' => "%%order_class%% .fb-like",
                        ),
                        'important'         => 'all'
                    ),
                ),
            ),
            'box_shadow'                    => array(
                'default'                   => array(
                    'css'                   => array(
                        'main'              => '%%order_class%% .fb-like',
                        'custom_style'      => true,
                    ),
                    'default_on_fronts'     => array(
                        'color'             => '',
                        'position'          => '',
                    ),
                ),
            ),
            'margin_padding' => array(
                'css' => array(
                    'margin' => '%%order_class%% .fb-like',
                    'padding' => '%%order_class%% .fb-like',
                ),
            )
        );
    }

    public function get_fields() {
        return array(
            'dnxte_embed_like_url'          => array(
                'label'                     => esc_html__('Page URL', 'et_builder'),
                'type'                      => 'text',
                'option_category'           => 'basic_option',
                'description'               => esc_html__('Input Page URL.', 'et_builder'),
                'toggle_slug'               => 'dnxte_embed_like_elements',
            ),
            'dnxte_embed_like_include_share'=> array(
                'label'                     => esc_html__('Include Share Button', 'et_builder'),
                'type'                      => 'yes_no_button',
                'toggle_slug'               => 'dnxte_embed_like_elements',
                'options'                   => array(
                    'on'                    => esc_html__('Yes', 'et_builder'),
                    'off'                   => esc_html__('No', 'et_builder'),
                ),
                'default_on_front'          => 'on',
            ),
            'dnxte_embed_like_width'        => array(
                'label'                     => esc_html__( 'Width', 'et_builder' ),
                'type'                      => 'range',
                'option_category'           => 'basic_option',
                'range_settings'            => array(
                    'step'                  => 1,
                    'min'                   => 1,
                    'max'                   => 1000,
                ),
                'default'                   => '550',
                'fixed_unit'                => '',
                'validate_unit'             => false,
                'unitless'                  => true,
                'toggle_slug'               => 'dnxte_embed_like_elements',
                'computed_affects'          => array(
					'__embeddedlike',
				),
            ),
            'dnxte_embed_like_layout'       => array(
                'label'                     => esc_html__('Layout', 'et_builder'),
                'type'                      => 'select',
                'description'               => esc_html__('Select the layout of the like button', 'et_builder'),
                'option_category'           => 'basic_option',
                'toggle_slug'               => 'dnxte_embed_like_elements',
                'options'                   => array(
                    'standard'              => esc_html__('Default', 'et_builder'),
                    'button_count'          => esc_html__('Button Count', 'et_builder'),
                    'button'                => esc_html__('Button', 'et_builder'),
                    'box_count'             => esc_html__('Box Count', 'et_builder'),
                ),
                'default'                   => 'standard',
            ),
            'dnxte_embed_like_action'       => array(
                'label'                     => esc_html__('Action', 'et_builder'),
                'type'                      => 'select',
                'description'               => esc_html__('Select the action of the like button', 'et_builder'),
                'option_category'           => 'basic_option',
                'toggle_slug'               => 'dnxte_embed_like_elements',
                'options'                   => array(
                    'like'                  => esc_html__('Like', 'et_builder'),
                    'recommend'             => esc_html__('Recommend', 'et_builder'),
                ),
                'default'                   => 'like',
            ),
            'dnxte_embed_like_size'         => array(
                'label'                     => esc_html__('Size', 'et_builder'),
                'type'                      => 'select',
                'description'               => esc_html__('Select the size of the like button', 'et_builder'),
                'option_category'           => 'basic_option',
                'toggle_slug'               => 'dnxte_embed_like_elements',
                'options'                   => array(
                    'small'                 => esc_html__('Small', 'et_builder'),
                    'large'                 => esc_html__('Large', 'et_builder'),
                ),
                'default'                   => 'small',
            ),
            '__embeddedlike'                => array(
				'type'                      => 'computed',
				'computed_callback'         => array( 'NextLikeButton' ),
				'computed_depends_on'       => array(
					'dnxte_embed_like_width'
				),
			),
        );
    }

    public function render($attrs, $content, $render_slug){
        wp_enqueue_script( 'dnext_facebook_sdk' );
        $includeShare = $this->props['dnxte_embed_like_include_share'] == "on";

        if(!$this->props['border_style_all']){
            ET_Builder_Element::set_style($render_slug, array(
                'selector'      => "%%order_class%% .fb-like",
                'declaration'   => sprintf('border-style: solid !important;'),
            ));
        }

        return sprintf('
        <div class="fb-like" data-href="%1$s" data-width="%3$s" data-layout="%4$s" data-action="%5$s" data-size="%6$s" data-share="%2$s">
        </div>',
        $this->props['dnxte_embed_like_url'],
        $includeShare,
        $this->props['dnxte_embed_like_width'],
        $this->props['dnxte_embed_like_layout'],
        $this->props['dnxte_embed_like_action'],
        $this->props['dnxte_embed_like_size']
    );
    }
}

new NextLikeButton;