<?php
class Divi_NxteBusinessHourChild extends ET_Builder_Module
{
    public $slug = 'dnxte_business_hour_child';
    public $vb_support = 'on';
    public $type = 'child';
    public $child_title_var = 'dnxte_businesshour_title';
    public $child_title_fallback_var = 'dnxte_businesshour_title';

    protected $module_credits = array(
        'module_uri' => 'https://www.diviessential.com/divi-business-hour/',
        'author' => 'Divi Next',
        'author_uri' => 'www.divinext.com',
    );

    public function init()
    {
        $this->name = esc_html__('Business Hour Item', 'et_builder');
        $this->icon_path = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->main_css_element = "%%order_class%%.dnxte_business_hour_child";
    }

    public function get_advanced_fields_config()
    {
        return array(
            'background' => array(
                'css' => array(
                    'main' => "{$this->main_css_element} .dnxte-Busihr-wekname",
                    'important' => true,
                ),
            ),
            'fonts' => array(
                'text' => array(
                    'label' => esc_html__('', 'et_builder'),
                    'css' => array(
                        'main' => '%%order_class%% .dnxte-Busihr-wekname',
                    ),
                    'font_size' => array(
                        'default' => '14px',
                    ),
                    'line_height' => array(
                        'default' => '1.7em',
                    ),
                    'letter_spacing' => array(
                        'default' => '0px',
                    ),
                    'hide_header_level' => true,
                    'hide_text_align' => true,
                    'hide_text_shadow' => true,
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'text',
                ),
                'header' => array(
                    'label' => esc_html__('Day', 'et_builder'),
                    'css' => array(
                        'main' => '%%order_class%% .dnxte-Busihr-wekname .dnxte-Busihr-dtday',
                    ),
                    'font_size' => array(
                        'default' => '14px',
                    ),
                    'line_height' => array(
                        'default' => '1.7em',
                    ),
                    'letter_spacing' => array(
                        'default' => '0px',
                    ),
                    'hide_header_level' => true,
                    'hide_text_align' => true,
                ),
                'time' => array(
                    'label' => esc_html__('Time', 'et_builder'),
                    'css' => array(
                        'main' => '%%order_class%% .dnxte-Busihr-wekname .dnxte-Busihr-dttime',
                    ),
                    'font_size' => array(
                        'default' => '14px',
                    ),
                    'line_height' => array(
                        'default' => '1.7em',
                    ),
                    'letter_spacing' => array(
                        'default' => '0px',
                    ),
                    'hide_text_align' => true,
                ),
            ),
            'margin_padding' => array(
                'css' => array(
                    'margin' => '%%order_class%% .dnxte-Busihr-wekname',
                    'padding' => '%%order_class%% .dnxte-Busihr-wekname',

                ),
                'important' => 'all',
            ),
        );
    }

    public function get_fields()
    {
        return array(
            'dnxte_businesshour_time' => array(
                'label' => esc_html__('Time', 'et_builder'),
                'type' => 'text',
                'dynamic_content' => 'text',
                'option_category' => 'basic_option',
                'description' => esc_html__('The time of the day', 'et_builder'),
                'toggle_slug' => 'main_content',
                //'default'         => esc_html__( '9:00 AM - 6:00 PM', 'et_builder' ),
                'default_on_front' => '9:00 AM - 6:00 PM',
            ),
            'dnxte_businesshour_title' => array(
                'label' => esc_html__('Day', 'et_builder'),
                'type' => 'text',
                'dynamic_content' => 'text',
                'option_category' => 'basic_option',
                'description' => esc_html__('The day', 'et_builder'),
                'toggle_slug' => 'main_content',
                //'default'        => esc_html__( 'Monday', 'et_builder' ),
                'default_on_front' => 'Monday',
            ),
        );
    }

    public function render($attrs, $content, $render_slug)
    {
        return sprintf(
            '<div class="dnxte-Busihr-wekname">
			<span class="dnxte-Busihr-dtday">%1$s</span>
			<div class="dnxte-Busihr-separator"></div>
			<span class="dnxte-Busihr-dttime">%2$s</span>
		  </div>',
            $this->props['dnxte_businesshour_title'],
            $this->props['dnxte_businesshour_time']
        );
    }
}

new Divi_NxteBusinessHourChild;
