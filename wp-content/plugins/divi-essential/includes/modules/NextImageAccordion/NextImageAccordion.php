<?php
include_once(DIVI_ESSENTIAL_PATH.'/includes/modules/base/Common.php');

class Next_ImageAccordion extends ET_Builder_Module {

	public $slug       	= 'dnxte_image_accordion';
    public $vb_support 	= 'on';
    public $child_slug 	= 'dnxte_image_accordion_item';

	protected $module_credits = array(
		'module_uri' => 'https://www.diviessential.com/divi-image-accordion/',
		'author'     => 'Divi Next',
		'author_uri' => 'www.divinext.com',
	);

	public function init() {
		$this->name        = esc_html__( 'Next Image Accordion', 'et_builder' );
		$this->icon_path   = plugin_dir_path( __FILE__ ) . 'icon.svg';
		$this->folder_name = 'et_pb_divi_essential';

		$this->settings_modal_toggles = array(
            'general' => array(
                'toggles' => array(
                    'dnxte_accordion_settings' 	=> esc_html__('Accordion Settings', 'et_builder'),
                ),
            ),
            'custom_css' => array(
                'toggles' => array(),
            ),
		);
	}

	public function get_advanced_fields_config(){
		return array(
			'text' => false,
			'fonts' => false
		);
	}

	public function get_fields() {
		$fields = array(
			'dnxte_accordion_style' => array(
				'label' 			=> esc_html__('Accordion Style', 'et_builder'),
				'type' 				=> 'select',
				'default' 			=> 'on_hover',
				'options' 			=> array(
					'on_hover' 		=> esc_html__('On Hover', 'et_builder'),
					'on_click' 		=> esc_html__('On Click', 'et_builder'),
				),
				'toggle_slug' 		=> 'dnxte_accordion_settings',
			),
			'dnxte_expand_last_item'          => array(
                'label'                 => esc_html__('Expand Last Interacted Item.', 'et_builder'),
                'type'                  => 'yes_no_button',
                'options'               => array(
                    'off' => esc_html__('No', 'et_builder'),
                    'on'  => esc_html__('Yes', 'et_builder'),
                ),
				'default'	=> 'off',
                'toggle_slug'           => 'dnxte_accordion_settings',
				'show_if'	=> array(
					'dnxte_accordion_style'	=> 'on_hover'
				)
            ),	
			'dnxte_accordion_direction'	=> array(
				'label' 			=> esc_html__('Accordion Direction', 'et_builder'),
				'type' 				=> 'select',
				'default' 			=> 'row',
				'mobile_options' 	=> true,
				'options' 			=> array(
					'row' 			=> esc_html__('Horizontal', 'et_builder'),
					'column' 		=> esc_html__('Vertical', 'et_builder'),
				),
				'toggle_slug' 		=> 'dnxte_accordion_settings',
			),
			'dnxte_accordion_height'=> array(
				'label' 			=> esc_html__('Accordion Height', 'et_builder'),
				'type' 				=> 'range',
				'default' 			=> '400px',
				'default_unit' 		=> 'px',
				'range_settings' 	=> array(
					'min' => '1',
					'max' => '1200',
					'step' => '10',
				),
				'validate_unit' 	=> true,
				'mobile_options' 	=> true,
				'toggle_slug' 		=> 'dnxte_accordion_settings',
			),
			'dnxte_active_image_width'	=> array(
				'label' 				=> esc_html__('Active Image Size', 'et_builder'),
				'description' 			=> esc_html__('Control how wide or heigh the active image will be in relation to the other images of the accordion.', 'et_builder'),
				'type' 					=> 'range',
				'default' 				=> '5',
				'unitless' 				=> true,
				'range_settings' 		=> array(
					'min' => '1',
					'max' => '10',
					'step' => '1',
				),
				'mobile_options' 		=> true,
				'responsive'			=> true,
				'validate_unit' 		=> true,
				'toggle_slug' 			=> 'dnxte_accordion_settings',
			),
			'dnxte_gutter_space'	=> array(
				'label' 		=> esc_html__('Gutter Space', 'et_builder'),
				'type' 			=> 'range',
				'default' 		=> '0px',
				'default_unit' 	=> 'px',
				'range_settings' => array(
					'min' => '1',
					'max' => '1200',
					'step' => '10',
				),
				'validate_unit' => true,
				'mobile_options' => true,
				'toggle_slug' => 'dnxte_accordion_settings',
            ),
		);

		return $fields;
	}

	public function render( $attrs, $content, $render_slug ) {
		wp_enqueue_script( 'dnext_scripts-public' );
		// Accordion position
		$accordion_position_css_property = 'flex-direction: %1$s !important;';
        $accordion_position_css_selector = array(
            'desktop' => "%%order_class%% .dnxte_image_accordion_wrapper",
        );
		Common::set_css("dnxte_accordion_direction", $accordion_position_css_property, $accordion_position_css_selector, $render_slug, $this);
		// Accordion position end

		// Accordion height
		$accordion_height_css_property = 'height: %1$s;';
        $accordion_height_css_selector = array(
            'desktop' => "%%order_class%% .dnxte_image_accordion_wrapper",
        );
		Common::set_css("dnxte_accordion_height", $accordion_height_css_property, $accordion_height_css_selector, $render_slug, $this);
		// Accordion height end

		// Active Accordion width
		$active_accordion_width_css_property = 'flex: %1$s 0 auto !important;';
        $active_accordion_width_css_selector = array(
            'desktop' => "%%order_class%% .dnxte_image_accordion_item.dnxte-active",
        );
		Common::set_css("dnxte_active_image_width", $active_accordion_width_css_property, $active_accordion_width_css_selector, $render_slug, $this);
		// Accordion height end

		// Accordion gutter space
		$accordion_gutter_css_property = $this->props['dnxte_accordion_direction'] == "row" ? 'margin-right: %1$s !important;' : 'margin-top: %1$s !important;';
        $accordion_gutter_css_selector = array(
            'desktop' => "%%order_class%% .dnxte_image_accordion_item",
        );
		Common::set_css("dnxte_gutter_space", $accordion_gutter_css_property, $accordion_gutter_css_selector, $render_slug, $this);
		// Accordion height end

		return sprintf( 
			'<div class="dnxte_image_accordion_wrapper" data-accordion-type="%2$s"  data-expand-last-item="%3$s">
				%1$s
			</div>', 
			et_core_sanitized_previously($this->content),
			$this->props['dnxte_accordion_style'],
			$this->props['dnxte_expand_last_item']
		);
	}
}

new Next_ImageAccordion;
