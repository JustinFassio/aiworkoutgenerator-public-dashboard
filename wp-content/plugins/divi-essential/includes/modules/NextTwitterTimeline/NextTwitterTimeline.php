<?php

class NextTwitterTimeline extends ET_Builder_Module
{
    public $slug        = 'dnxte_twitter_timeline';
    public $vb_support  = 'on';

    protected $module_credits = array(
        'module_uri'    => 'https://www.diviessential.com/divi-twitter-timeline/',
        'author'        => 'Divi Next',
        'author_uri'    => 'www.divinext.com',
    );

    public function init(){
        $this->name         = esc_html__('Next Twitter Timeline', 'et_builder');
        $this->icon_path    = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->folder_name  = 'et_pb_divi_essential';

        $this->settings_modal_toggles = array(
            'general'                                   => array(
                'toggles'                               => array(
                    'dnxte_twitter_timeline_elements'   => esc_html__('Twitter Timeline Elements', 'et_builder')
                )
            )
        );
    }

    public function get_advanced_fields_config(){
        return array(
            'text'      => false,
            'fonts'     => false,
            'height'    => false
        );
    }

    public function get_fields() {
        return array(
            'twitter_timeline_screenname'   => array(
                'label'                     => esc_html__('Twitter Username', 'et_builder'),
                'type'                      => 'text',
                'option_category'           => 'basic_option',
                'description'               => esc_html__('Input twitter username here.', 'et_builder'),
                'toggle_slug'               => 'dnxte_twitter_timeline_elements',
				'default'                   => 'divi_next'
            ),
            'twitter_timeline_theme'	    => array(
				'label'				        => esc_html__( 'Theme', 'et_builder' ),
				'description'               => esc_html__( 'Choose twitter timeline theme.', 'et_builder' ),
				'type'                      => 'select',
				'option_category'	        => 'layout',
				'toggle_slug'               => 'dnxte_twitter_timeline_elements',
				'option_category'           => 'layout',
				'options'                   => array(
					'light'		            => esc_html__( 'Light', 'et_builder' ),
					'dark'			        => esc_html__( 'Dark', 'et_builder' ),
				),
				'default'                   => 'light',
            ),
            'twitter_timeline_show_replies' => array(
                'label'                     => esc_html__( 'Show Replies', 'et_builder'),
                'description'               => esc_html__('Choose Yes or No to show Tweets in response to another Tweet or account.', 'et_builder'),
				'type'                      => 'yes_no_button',
				'toggle_slug'               => 'dnxte_twitter_timeline_elements',
				'options'                   => array(
					'on'                    => esc_html__( 'Yes', 'et_builder' ),
					'off'                   => esc_html__( 'No', 'et_builder' ),
				),
				'default_on_front'          => 'off',
            ),
            'twitter_timeline_limit'        => array(
                'label'                     => esc_html__( 'Limit Tweets', 'et_builder'),
                'description'               => esc_html__('Choose Yes or No to limit number of tweet.', 'et_builder'),
				'type'                      => 'yes_no_button',
				'toggle_slug'               => 'dnxte_twitter_timeline_elements',
				'options'                   => array(
					'on'                    => esc_html__( 'Yes', 'et_builder' ),
					'off'                   => esc_html__( 'No', 'et_builder' ),
				),
                'default_on_front'          => 'off',
                'affects'                   => array(
                    'twitter_timeline_tweet_number'
                )
            ),
            'twitter_timeline_tweet_number' => array(
                'label'                     => esc_html__( 'Number Of Tweets', 'et_builder' ),
                'type'                      => 'range',
                'option_category'           => 'basic_option',
                'range_settings'            => array(
                    'step'                  => 1,
                    'min'                   => 1,
                    'max'                   => 20,
                ),
                'default'                   => '3',
                'default_on_front'          => '3',
                'fixed_unit'                => '',
                'validate_unit'             => false,
                'unitless'                  => true,
                'toggle_slug'               => 'dnxte_twitter_timeline_elements',
                'computed_affects'          => array(
					'__twittertimeline',
				),
            ),
            'twitter_timeline_height'       => array(
                'label'                     => esc_html__( 'Height', 'et_builder' ),
                'type'                      => 'range',
                'option_category'           => 'basic_option',
                'range_settings'            => array(
                    'step'                  => 1,
                    'min'                   => 250,
                    'max'                   => 1000,
                ),
                'default'                   => '600',
                'fixed_unit'                => '',
                'validate_unit'             => false,
                'unitless'                  => true,
                'toggle_slug'               => 'dnxte_twitter_timeline_elements',
                'computed_affects'          => array(
					'__twittertimeline',
				),
            ),
            'twitter_timeline_use_header'   => array(
                'label'                     => esc_html__( 'Use Header', 'et_builder'),
                'description'               => esc_html__('Choose Yes or No to show header.', 'et_builder'),
				'type'                      => 'yes_no_button',
				'toggle_slug'               => 'dnxte_twitter_timeline_elements',
				'options'                   => array(
					'on'                    => esc_html__( 'Yes', 'et_builder' ),
					'off'                   => esc_html__( 'No', 'et_builder' ),
				),
				'default_on_front'          => 'on',
            ),
            'twitter_timeline_use_footer'   => array(
                'label'                     => esc_html__( 'Use Footer', 'et_builder'),
                'description'               => esc_html__('Choose Yes or No to show footer.', 'et_builder'),
				'type'                      => 'yes_no_button',
				'toggle_slug'               => 'dnxte_twitter_timeline_elements',
				'options'                   => array(
					'on'                    => esc_html__( 'Yes', 'et_builder' ),
					'off'                   => esc_html__( 'No', 'et_builder' ),
				),
				'default_on_front'          => 'off',
            ),
            'twitter_timeline_use_borders'  => array(
                'label'                     => esc_html__( 'Use Borders', 'et_builder'),
                'description'               => esc_html__('Choose Yes or No to show borders.', 'et_builder'),
				'type'                      => 'yes_no_button',
				'toggle_slug'               => 'dnxte_twitter_timeline_elements',
				'options'                   => array(
					'on'                    => esc_html__( 'Yes', 'et_builder' ),
					'off'                   => esc_html__( 'No', 'et_builder' ),
				),
				'default_on_front'          => 'on',
            ),
            'twitter_timeline_transparent'  => array(
                'label'                     => esc_html__( 'Transparent', 'et_builder'),
                'description'               => esc_html__('Choose Yes or No to show borders.', 'et_builder'),
				'type'                      => 'yes_no_button',
				'toggle_slug'               => 'dnxte_twitter_timeline_elements',
				'options'                   => array(
					'on'                    => esc_html__( 'Yes', 'et_builder' ),
					'off'                   => esc_html__( 'No', 'et_builder' ),
				),
				'default_on_front'          => 'off',
            ),
            'twitter_timeline_show_scrollbar'=> array(
                'label'                     => esc_html__( 'Show Scrollbar', 'et_builder'),
                'description'               => esc_html__('Choose Yes or No to show scrollbar.', 'et_builder'),
				'type'                      => 'yes_no_button',
				'toggle_slug'               => 'dnxte_twitter_timeline_elements',
				'options'                   => array(
					'on'                    => esc_html__( 'Yes', 'et_builder' ),
					'off'                   => esc_html__( 'No', 'et_builder' ),
				),
				'default_on_front'          => 'on',
            ),
            'twitter_timeline_border_color' => array(
				'label'                     => esc_html__('Select Border Color', 'et_builder'),
				'type'                      => 'color-alpha',
				'toggle_slug'               => 'dnxte_twitter_timeline_elements',
				'default'                   => '#a80000',
			),
            '__twittertimeline'             => array(
				'type'                      => 'computed',
				'computed_callback'         => array( 'NextTwitterTimeline' ),
				'computed_depends_on'       => array(
                    'twitter_timeline_tweet_number',
                    'twitter_timeline_height'
				),
			),
        );
    }

    public function render($attrs, $content, $render_slug){
        wp_enqueue_script( 'dnext_twitter_widgets' );
        $data_chrome = "";
        $tweet_limit = "on" == $this->props['twitter_timeline_limit'] ? $this->props['twitter_timeline_tweet_number'] : "";

        if($this->props['twitter_timeline_use_header']!=="on"){
            $data_chrome .="noheader ";
        }
        if($this->props['twitter_timeline_use_footer']!=="on"){
            $data_chrome .="nofooter ";
        }
        if($this->props['twitter_timeline_use_borders']!=="on"){
            $data_chrome .="noborders ";
        }
        if($this->props['twitter_timeline_transparent']==="on"){
            $data_chrome .="transparent ";
        }
        if($this->props['twitter_timeline_show_scrollbar']!=="on"){
            $data_chrome .="noscrollbar";
        }

        

        return sprintf('
            <a class="twitter-timeline" href="https://twitter.com/%1$s" data-height="%2$s" data-chrome="%3$s" data-theme="%4$s" data-show-replies="%5$s" data-tweet-limit="%6$s" data-border-color="%7$s">
            </a>',
            $this->props['twitter_timeline_screenname'],
            $this->props['twitter_timeline_height'],
            $data_chrome,
            $this->props['twitter_timeline_theme'],
            "on" === $this->props['twitter_timeline_show_replies'] ? true : false,
            $tweet_limit,
            "on" === $this->props['twitter_timeline_border_color'] ? true : false
        );
    }

}

new NextTwitterTimeline;