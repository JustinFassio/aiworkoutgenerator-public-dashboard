<?php

namespace Divi_Essential\Includes;

defined( 'ABSPATH' ) || die();

class Admin {

	const MODULES_NONCE = 'dnxte_save_admin';
	

	public function __construct() {
		add_action( 'admin_menu', array( __CLASS__, 'add_menu' ), 21 );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_scripts' ), 21 );
		add_action( 'wp_ajax_' . self::MODULES_NONCE, array( __CLASS__, 'save_data' ) );
		add_action( 'dnxte_save_admin_data', array( __CLASS__, 'save_modules_data') );

	
	}
	
    public static function add_menu() {
		
		add_menu_page(
			__( 'Divi Essential', 'et_builder' ),
			__( 'Divi Essential', 'et_builder' ),
			'manage_options',
			'dnxte-essential',
			array( __CLASS__, 'render_main'),
			dnxte_svg_icon(),
			111
		);
		

	
	}

	public static function enqueue_scripts() {
		if ( ! current_user_can( 'manage_options' )) {
			return;
		}
		global $pagenow;

		if (("admin.php" === $pagenow) && (isset($_GET['page']) && 'dnxte-essential' === $_GET['page'])) {
			wp_enqueue_style(
				'dnxte-admin',
				DIVI_ESSENTIAL_ASSETS . 'admin/css/admin.css'
			);

			wp_enqueue_script(
				'dnxte-admin-js',
				DIVI_ESSENTIAL_ASSETS . 'admin/js/admin.js',
				array( 'jquery' ),
				DIVI_ESSENTIAL_VERSION,
				true
			);
	
			wp_localize_script( 
				'dnxte-admin-js', 
				'Dnxte_Essential', 
				array(
					'ajaxurl'	=>	admin_url( 'admin-ajax.php' ),
					'nonce'   	=>	wp_create_nonce( self::MODULES_NONCE ),
					'action'  	=>	self::MODULES_NONCE,
				) 
			);
		}

	}

	public static function save_data() {

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		if ( ! check_ajax_referer( self::MODULES_NONCE, 'nonce' ) ) {
			wp_send_json_error();
		}


		$posted_data = ! empty( $_POST['data'] ) ? $_POST['data'] : '';
		
		$data = array();

		parse_str( $posted_data, $data );

		do_action( 'dnxte_save_admin_data', $data );

		wp_send_json_success();
	}

	public static function save_modules_data( $data ) {

		$modules = ! empty( $data['modules'] ) ? $data['modules'] : array();
		
		$inactive_modules = array_values( array_diff( array_keys( self::get_modules_map() ), $modules ) );

		self::save_inactive_modules($inactive_modules);
	}

	public static function get_inactive_modules() {
		return get_option( 'dnxte_inactive_modules', array() );
	}

	public static function save_inactive_modules( $modules = array() ) {
		
		update_option( 'dnxte_inactive_modules', $modules );
	
	}

	private static function get_free_modules_map() {
		
		return array(
			'dnxte-divider'      => array(
				'title'  => __( 'Next Divider', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/divi-next-divider/',
				'icon'   => DIVI_ESSENTIAL_ICON . "DiviNextDivider/icon.svg",
				'is_active' => true,
			),
			'dnxte-image-magnifier'      => array(
				'title'  => __( 'Image Magnifier', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/divi-image-magnifier/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'DiviNextImageMagnifier/icon.svg',
				'is_active' => true,
			),
			'dnxte-image-reveal'     => array(
				'title'  => __( 'Image Reveal', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/divi-image-reveal/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'DiviNextImageReveal/icon.svg',
				'is_active' => true,
			),
			'dnxte-lottie'     => array(
				'title'  => __( 'Lottie', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/divi-lottie/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'DiviNextLottie/icon.svg',
				'is_active' => true,
			),
			'dnxte-gallery-slider'     => array(
				'title'  => __( 'Gallery Slider', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/divi-gallery-slider/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'DiviNextThumbsGallery/icon.svg',
				'is_active' => true,
			),
			'dnxte-image-hotspot'     => array(
				'title'  => __( 'Image Hotspot', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/divi-hotspot/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'DiviNextTooltip/icon.svg',
				'is_active' => true,
			),
			'dnxte-3d-cube-slider'     => array(
				'title'  => __( '3d Cube Slider', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/divi-3d-cube-slider/',
				'icon'   => DIVI_ESSENTIAL_ICON .'DiviNxte3dCubeSlider/icon.svg',
				'is_active' => true,
			),
			'dnxte-business-hour'     => array(
				'title'  => __( 'Business Hour', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/divi-business-hour/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'DiviNxteBusinessHour/icon.svg',
				'is_active' => true,
			),
			'dnxte-coverflow-slider'     => array(
				'title'  => __( 'Divi Carousel', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/divi-coverflow-slider/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'DiviNxteCoverflowSlider/icon.svg',
				'is_active' => true,
			),
			'dnxte-feature-list'     => array(
				'title'  => __( 'Feature List', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/divi-feature-list/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'DiviNxteFeatureList/icon.svg',
				'is_active' => true,
			),
			'dnxte-floating-element'     => array(
				'title'  => __( 'Floating Element', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/divi-floating-elements/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'DiviNxteFloatingElement/icon.svg',
				'is_active' => true,
			),
			'dnxte-price-list'     => array(
				'title'  => __( 'Price List', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/divi-price-list/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'DiviNxtePriceList/icon.svg',
				'is_active' => true,
			),
			'dnxte-promo-box'     => array(
				'title'  => __( 'Promo Box', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/next-promo-box/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'DiviNxtePromobox/icon.svg',
				'is_active' => true,
			),
			'dnxte-testimonial-slider'     => array(
				'title'  => __( 'Testimonial Slider', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/divi-testimonial-carousel/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'DiviNxteTestimonial/icon.svg',
				'is_active' => true,
			),
			'dnxte-flip-box'      => array(
				'title'  => __( 'Flip Box', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/divi-flip-box/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'DiviNxtFlipbox/icon.svg',
				'is_active' => true,
			),
			'dnxte-logo-carousel'     => array(
				'title'  => __( 'Logo Carousel', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/divi-logo-carousel/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'DiviNxtLogoCarousel/icon.svg',
				'is_active' => true,
			),
			'dnxte-person'     => array(
				'title'  => __( 'Person', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/divi-next-person/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'DiviNxtPerson/icon.svg',
				'is_active' => true,
			),
			'dnxte-3D-flip-box'     => array(
				'title'  => __( '3D Flip Box', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/3d-flip-box/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'Next3dFlipbox/icon.svg',
				'is_active' => true,
			),
			'dnxte-before-after'     => array(
				'title'  => __( 'Before After', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/divi-before-after-module/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'NextBeforeAfter/icon.svg',
				'is_active' => true,
			),
			'dnxte-blurb'     => array(
				'title'  => __( 'Blurb', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/divi-next-blurb/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'NextBlurb/icon.svg',
				'is_active' => true,
			),
			'dnxte-button'     => array(
				'title'  => __( 'Button', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/divi-next-button/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'NextButton/icon.svg',
				'is_active' => true,
			),
			'dnxte-circular-image-hover'     => array(
				'title'  => __( 'Circular Image Hover', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/divi-circular-image-effect/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'NextCircularImageHover/icon.svg',
				'is_active' => true,
			),
			'dnxte-facbook-comment'     => array(
				'title'  => __( 'Facbook Comment', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/divi-facebook-comment/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'NextComment/icon.svg',
				'is_active' => true,
			),
			'dnxte-dual-button'     => array(
				'title'  => __( 'Dual Button', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/divi-dual-button/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'NextDualButton/icon.svg',
				'is_active' => true,
			),
			'dnxte-facebook-embedded-comment'     => array(
				'title'  => __( 'Facebook Embedded Comment', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/divi-embedded-comment/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'NextEmbeddedComment/icon.svg',
				'is_active' => true,
			),
			'dnxte-facebook-embedded-post'     => array(
				'title'  => __( 'Facebook Embedded Post', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/divi-facebook-embedded-post/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'NextEmbeddedPost/icon.svg',
				'is_active' => true,
			),
			'dnxte-facebook-embedded-Video'     => array(
				'title'  => __( 'Facebook Embedded Video', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/divi-facebook-embedded-video/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'NextEmbeddedVideo/icon.svg',
				'is_active' => true,
			),
			'dnxte-facebook-page'     => array(
				'title'  => __( 'Facebook Page', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/divi-facebook-page/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'NextFBPage/icon.svg',
				'is_active' => true,
			),
			'dnxte-facebook-share-button'     => array(
				'title'  => __( 'Facebook Share Button', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/divi-facebook-share/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'NextFBShareButton/icon.svg',
				'is_active' => true,
			),
			'dnxte-text-gradient'     => array(
				'title'  => __( 'Text Gradient', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/divi-gradient-text/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'NextGradientText/icon.svg',
				'is_active' => true,
			),
			'dnxte-image-accordion'     => array(
				'title'  => __( 'Image Accordion', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/divi-image-accordion/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'NextImageAccordion/icon.svg',
				'is_active' => true,
			),
			'dnxte-image-hover-box'     => array(
				'title'  => __( 'Image Hover Box', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/divi-image-hover-box-effect/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'NextImageHoverBox/icon.svg',
				'is_active' => true,
			),
			'dnxte-image-icon-effect'     => array(
				'title'  => __( 'Image Icon Effect', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/divi-image-icon-effect/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'NextImageIcon/icon.svg',
				'is_active' => true,
			),
			'dnxte-image-scroll'     => array(
				'title'  => __( 'Image Scroll', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/divi-image-scroll-effect/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'NextImageScroll/icon.svg',
				'is_active' => true,
			),
			'dnxte-facebook-like-button'     => array(
				'title'  => __( 'Facebook Like Button', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/divi-facebook-like/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'NextLikeButton/icon.svg',
				'is_active' => true,
			),
			'dnxte-masonry-gallery'     => array(
				'title'  => __( 'Masonry Gallery', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/divi-masonry-gallery/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'NextMasonary/icon.svg',
				'is_active' => true,
			),
			'dnxte-mega-image-effect'     => array(
				'title'  => __( 'Mega Image Effect', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/divi-mega-image-effect/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'NextMegaImageEffect/icon.svg',
				'is_active' => true,
			),
			'dnxte-minimal-image'     => array(
				'title'  => __( 'Minimal Image', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/divi-minimal-image-hover-effect/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'NextMinimalImageHover/icon.svg',
				'is_active' => true,
			),
			'dnxte-text-multi-heading'     => array(
				'title'  => __( 'Text Multi Heading', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/divi-multi-heading/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'NextMultiHeading/icon.svg',
				'is_active' => true,
			),
			'dnxte-rating'     => array(
				'title'  => __( 'Divi Rating', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/divi-rating/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'NextRating/icon.svg',
				'is_active' => true,
			),
			'dnxte-divi-review'     => array(
				'title'  => __( 'Divi Review', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/divi-review/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'NextReview/icon.svg',
				'is_active' => true,
			),
			'dnxte-step-flow'     => array(
				'title'  => __( 'Step Flow', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/step-flow/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'NextStepFlow/icon.svg',
				'is_active' => true,
			),
			'dnxte-team-creative'     => array(
				'title'  => __( 'Divi Creative Team', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/divi-creative-team/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'NextTeamCreative/icon.svg',
				'is_active' => true,
			),
			'dnxte-team-member-overlay'     => array(
				'title'  => __( 'Team Member Overlay', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/divi-team-member-overlay/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'NextTeamOverlay/icon.svg',
				'is_active' => true,
			),
			'dnxte-team-overlay-card'     => array(
				'title'  => __( 'Divi Team Overlay Card', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/divi-team-overlay-card/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'NextTeamOverlayCard/icon.svg',
				'is_active' => true,
			),
			'dnxte-team-social-reveal'     => array(
				'title'  => __( 'Team Social Reveal', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/divi-team-social-reveal/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'NextTeamSocialReveal/icon.svg',
				'is_active' => true,
			),
			'dnxte-text-animation'     => array(
				'title'  => __( 'Text Animation', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/divi-text-animation/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'NextTextAnimation/icon.svg',
				'is_active' => true,
			),
			'dnxte-text-color-motion'     => array(
				'title'  => __( 'Text Color Motion', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/divi-text-color-motion/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'NextTextColorMotion/icon.svg',
				'is_active' => true,
			),
			'dnxte-text-divider'     => array(
				'title'  => __( 'Text Divider', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/divi-text-divider/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'NextTextDivider/icon.svg',
				'is_active' => true,
			),
			'dnxte-text-glitch'     => array(
				'title'  => __( 'Text Glitch', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/divi-glitch-text/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'NextTextGlitch/icon.svg',
				'is_active' => true,
			),
			'dnxte-text-highlight'     => array(
				'title'  => __( 'Text Highlight', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/divi-text-highlight/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'NextTextHighlight/icon.svg',
				'is_active' => true,
			),
			'dnxte-text-hover-highlight'  => array(
				'title'  => __( 'Text Hover Highlight', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/divi-text-hover-highlight/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'NextTextHoverHighlight/icon.svg',
				'is_active' => true,
			),
			'dnxte-text-mask'  => array(
				'title'  => __( 'Text Mask', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/divi-text-mask/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'NextTextMask/icon.svg',
				'is_active' => true,
			),
			'dnxte-text-stroke'  => array(
				'title'  => __( 'Text Stroke', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/divi-text-stroke/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'NextTextStroke/icon.svg',
				'is_active' => true,
			),
			'dnxte-text-stroke-motion'  => array(
				'title'  => __( 'Text Stroke Motion', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/divi-text-stroke-motion/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'NextTextStrokeMotion/icon.svg',
				'is_active' => true,
			),
			'dnxte-text-tilt'  => array(
				'title'  => __( 'Text Tilt', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/divi-text-tilt/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'NextTextTilt/icon.svg',
				'is_active' => true,
			),
			'dnxte-timeline'  => array(
				'title'  => __( 'Timeline', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/divi-timeline/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'NextTimeline/icon.svg',
				'is_active' => true,
			),
			'dnxte-twitter-follow'  => array(
				'title'  => __( 'Twitter Follow Button', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/divi-twitter-follow/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'NextTwitterFollow/icon.svg',
				'is_active' => true,
			),
			'dnxte-twitter-share'  => array(
				'title'  => __( 'Twitter Tweet Button', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/divi-twitter-button/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'NextTwitterShare/icon.svg',
				'is_active' => true,
			),
			'dnxte-twitter-timeline'  => array(
				'title'  => __( 'Twitter Timeline', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/divi-twitter-timeline/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'NextTwitterTimeline/icon.svg',
				'is_active' => true,
			),
			'dnxte-twitter-tweet'  => array(
				'title'  => __( 'Twitter Tweet', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/divi-twitter-tweet/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'NextTwitterTweet/icon.svg',
				'is_active' => true,
			),
			'dnxte-ultimate-image-hover'  => array(
				'title'  => __( 'Ultimate Image Hover', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/divi-ultimate-image-effect/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'NextUltimateImageHover/icon.svg',
				'is_active' => true,
			),
			'dnxte-content-toggle'  => array(
				'title'  => __( 'Content Toggle', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/divi-content-toggle/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'NextContentToggle/icon.svg',
				'is_active' => true,
			),
			'dnxte-post-carousel' => array(
				'title'  => __( 'Post Carousel', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/divi-post-carousel/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'NextBlogSlider/icon.svg',
			),
			'dnxte-advanced-tab' => array(
				'title'  => __( 'Advanced tab', 'et_builder' ),
				'demo'   => 'https://www.diviessential.com/divi-advanced-tab/',
				'icon'   => DIVI_ESSENTIAL_ICON . 'NextAdvancedTab/icon.svg',
			),
		);
	}

	private static function get_pro_modules_map() {
		return array();
	}

	public static function get_modules_map() {

		$free_modules_map 	= self::get_free_modules_map();
		$modules_map 		= array_merge( $free_modules_map, self::get_pro_modules_map() );

		uksort( $modules_map, array( __CLASS__, 'sort_widgets') );
		return $modules_map;

	}

	public static function sort_widgets($k1, $k2) {
		return strcasecmp( $k1, $k2 );
	}

	public static function get_tabs() {

		$icon_url = DIVI_ESSENTIAL_ASSETS . 'images/admin/';

		$tabs = array(
			'home'      => array(
				'title'    => esc_html__( 'Home', 'dnxte-divi-essential' ),
				'icon'     => '',
				'renderer' => array( __CLASS__, 'render_home' ),
			),

			'modules'      => array(
				'title'    => esc_html__( 'Modules', 'et_builder' ),
				'icon'     => '',
				'renderer' => array( __CLASS__, 'render_modules' ),
			),
		);

		return $tabs;
	}

	private static function load_template( $template ) {
		$file = DIVI_ESSENTIAL_DIR . 'includes/admin/view/admin-' . $template . '.php';
		if ( is_readable( $file ) ) {
			include $file;
		}
	}

	public static function render_main() {
		self::load_template( 'main' );
	}

	public static function render_home() {
		self::load_template( 'home' );
	}

	public static function render_modules() {
		self::load_template( 'modules' );
	}


	
}