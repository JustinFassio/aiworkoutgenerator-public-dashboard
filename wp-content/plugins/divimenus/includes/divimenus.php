<?php

/**
 * Creates the plugin's main class instance.
 */
class ddmenus_DiviMenus extends DiviExtension {

	/**
	 * The gettext domain for the plugin translations.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $gettext_domain = 'divimenus';

	/**
	 * The WP plugin name.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $name = 'DiviMenus';

	/**
	 * The plugin version
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $version = DIVIMENUS_VERSION;

	/**
	 * constructor.
	 *
	 * @param string $name
	 * @param array  $args
	 */
	public function __construct( $name = 'divimenus', $args = array() ) {
		$this->plugin_dir     = plugin_dir_path( __FILE__ );
		$this->plugin_dir_url = plugin_dir_url( $this->plugin_dir );

		parent::__construct( $name, $args );

		// Setup translations. Loading here because the parent class uses $this->plugin_dir instead, which does not work.
		load_plugin_textdomain( $this->gettext_domain, false, basename( $this->plugin_dir_url ) . '/languages' ); 

		$this->_builder_js_data = array(
			'i10n' => array(
				'labels' => array(
					'title_l'	=> esc_html__( 'Text', 'et_builder' ),
					'title_d' 	=> esc_html__( 'Define the Text for your Menu Item.', 'divimenus' ),
				),
			),
			'image_data' => ET_BUILDER_PLACEHOLDER_LANDSCAPE_IMAGE_DATA
		);
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_filter( 'et_core_esc_attr', array( $this, 'core_esc_attr' ) );
		add_filter( 'et_global_assets_list', array( $this, 'global_assets_list'), 10, 3); // Divi 4.10.x only receives one parameter
		add_filter( 'et_builder_module_et_pb_divimenus_item_outer_wrapper_attrs',array($this, 'module_outer_wrapper_attrs'), 10, 2);
		add_filter( 'et_builder_module_et_pb_divimenus_flex_item_outer_wrapper_attrs',array($this, 'module_outer_wrapper_attrs'), 10, 2);
		add_filter( 'et_pb_all_fields_unprocessed_et_pb_divimenus_flex', array($this, 'finalize_fields') );
		add_filter( 'woocommerce_add_to_cart_fragments', array( $this, 'update_cart' ) );
	}

	public function core_esc_attr( $allowed_attrs ) {
		if ( ! isset( $allowed_attrs['role'] ) ) {
			$allowed_attrs['role'] = 'esc_attr';
		}
		if ( ! isset( $allowed_attrs['aria-label'] ) ) {
			$allowed_attrs['aria-label'] = 'esc_attr';
		}
		return $allowed_attrs;
	}

	public function enqueue_scripts() {
		wp_register_script( 'divimenus', $this->plugin_dir_url . 'includes/modules/DiviMenus/frontend.min.js', array('jquery'), false, true );
		if (function_exists('et_core_is_fb_enabled') && et_core_is_fb_enabled()) {
			wp_enqueue_script( 'divimenus' );
		}
	}

	public function global_assets_list( $assets, $assets_args, $et_dynamic_assets ) {  
		if ( isset( $assets['et_icons_fa'] ) ) {
			return $assets;
		}
		$content_retriever = \Feature\ContentRetriever\ET_Builder_Content_Retriever::init();
		$all_content = $content_retriever->get_entire_page_content();
		if (strpos($all_content, '||fa||') !== false) {
			$assets_prefix = et_get_dynamic_assets_path();
			$assets['et_icons_fa'] = array(
				'css' => "{$assets_prefix}/css/icons_fa_all.css",
			);
		}
		return $assets;
	}
    public function finalize_fields($fields) {
		$fields['menu_item_text_color']['sticky'] = false;
		return $fields;
	}  

	public function update_cart( $fragments ) {
    	$fragments['.dd-cart-count'] = sprintf('<span class="dd-cart-info dd-cart-count">%s</span>', WC()->cart->get_cart_contents_count());
    	return $fragments; 
	}

	public function module_outer_wrapper_attrs($attrs, $instance) {
		$attrs['role']= 'menuitem';
		return $attrs;
	}
}

new ddmenus_DiviMenus;