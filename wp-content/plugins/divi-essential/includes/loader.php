<?php

if ( ! class_exists( 'ET_Builder_Element' ) ) {
	return;
}

function dnxte_register_modules() {

	$inactive_modules = get_option( 'dnxte_inactive_modules', array() );

	if ( ! in_array( 'dnxte-divider', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/DiviNextDivider/DiviNextDivider.php';
	}

	if ( ! in_array( 'dnxte-image-magnifier', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/DiviNextImageMagnifier/DiviNextImageMagnifier.php';
	}

	if ( ! in_array( 'dnxte-image-reveal', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/DiviNextImageReveal/DiviNextImageReveal.php';
	}

	if ( ! in_array( 'dnxte-lottie', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/DiviNextLottie/DiviNextLottie.php';
	}

	if ( ! in_array( 'dnxte-gallery-slider', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/DiviNextThumbsGallery/DiviNextThumbsGallery.php';
		require_once plugin_dir_path( __FILE__ ) . 'modules/DiviNextThumbsGalleryChild/DiviNextThumbsGalleryChild.php';
	}

	if ( ! in_array( 'dnxte-image-hotspot', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/DiviNextTooltip/DiviNextTooltip.php';
		require_once plugin_dir_path( __FILE__ ) . 'modules/DiviNextTooltipChild/DiviNextTooltipChild.php';
	}

	if ( ! in_array( 'dnxte-3d-cube-slider', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/DiviNxte3dCubeSlider/DiviNxte3dCubeSlider.php';
		require_once plugin_dir_path( __FILE__ ) . 'modules/DiviNxte3dCubeSliderChild/DiviNxte3dCubeSliderChild.php';
	}

	if ( ! in_array( 'dnxte-business-hour', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/DiviNxteBusinessHour/DiviNxteBusinessHour.php';
		require_once plugin_dir_path( __FILE__ ) . 'modules/DiviNxteBusinessHourChild/DiviNxteBusinessHourChild.php';
	}

	if ( ! in_array( 'dnxte-coverflow-slider', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/DiviNxteCoverflowSlider/DiviNxteCoverflowSlider.php';
		require_once plugin_dir_path( __FILE__ ) . 'modules/DiviNxteCoverflowSliderChild/DiviNxteCoverflowSliderChild.php';
	}

	if ( ! in_array( 'dnxte-feature-list', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/DiviNxteFeatureList/DiviNxteFeatureList.php';
		require_once plugin_dir_path( __FILE__ ) . 'modules/DiviNxteFeatureListChild/DiviNxteFeatureListChild.php';
	}

	if ( ! in_array( 'dnxte-floating-element', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/DiviNxteFloatingElement/DiviNxteFloatingElement.php';
		require_once plugin_dir_path( __FILE__ ) . 'modules/DiviNxteFloatingElementChild/DiviNxteFloatingElementChild.php';
	}

	if ( ! in_array( 'dnxte-price-list', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/DiviNxtePriceList/DiviNxtePriceList.php';
		require_once plugin_dir_path( __FILE__ ) . 'modules/DiviNxtePriceListChild/DiviNxtePriceListChild.php';
	}

	if ( ! in_array( 'dnxte-promo-box', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/DiviNxtePromobox/DiviNxtePromobox.php';
	}

	if ( ! in_array( 'dnxte-testimonial-slider', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/DiviNxteTestimonial/DiviNxteTestimonial.php';
		require_once plugin_dir_path( __FILE__ ) . 'modules/DiviNxteTestimonialChild/DiviNxteTestimonialChild.php';
	}

	if ( ! in_array( 'dnxte-flip-box', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/DiviNxtFlipbox/DiviNxtFlipbox.php';
	}

	if ( ! in_array( 'dnxte-logo-carousel', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/DiviNxtLogoCarousel/DiviNxtLogoCarousel.php';
		require_once plugin_dir_path( __FILE__ ) . 'modules/DiviNxtLogoCarouselChild/DiviNxtLogoCarouselChild.php';
	}

	if ( ! in_array( 'dnxte-person', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/DiviNxtPerson/DiviNxtPerson.php';
		require_once plugin_dir_path( __FILE__ ) . 'modules/DiviNxtPersonItem/DiviNxtPersonItem.php';
	}

	if ( ! in_array( 'dnxte-3D-flip-box', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/Next3dFlipbox/Next3dFlipbox.php';
	}

	if ( ! in_array( 'dnxte-before-after', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextBeforeAfter/NextBeforeAfter.php';
	}

	if ( ! in_array( 'dnxte-blurb', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextBlurb/NextBlurb.php';
	}

	if ( ! in_array( 'dnxte-button', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextButton/NextButton.php';
	}

	if ( ! in_array( 'dnxte-circular-image-hover', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextCircularImageHover/NextCircularImageHover.php';
	}

	if ( ! in_array( 'dnxte-facbook-comment', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextComment/NextComment.php';
	}

	if ( ! in_array( 'dnxte-dual-button', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextDualButton/NextDualButton.php';
	}

	if ( ! in_array( 'dnxte-facebook-embedded-comment', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextEmbeddedComment/NextEmbeddedComment.php';
	}

	if ( ! in_array( 'dnxte-facebook-embedded-post', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextEmbeddedPost/NextEmbeddedPost.php';
	}

	if ( ! in_array( 'dnxte-facebook-embedded-Video', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextEmbeddedVideo/NextEmbeddedVideo.php';
	}

	if ( ! in_array( 'dnxte-facebook-page', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextFBPage/NextFBPage.php';
	}

	if ( ! in_array( 'dnxte-facebook-share-button', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextFBShareButton/NextFBShareButton.php';
	}

	if ( ! in_array( 'dnxte-text-gradient', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextGradientText/NextGradientText.php';
	}

	if ( ! in_array( 'dnxte-image-accordion', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextImageAccordion/NextImageAccordion.php';
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextImageAccordionItem/NextImageAccordionItem.php';
	}

	if ( ! in_array( 'dnxte-image-hover-box', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextImageHoverBox/NextImageHoverBox.php';
	}

	if ( ! in_array( 'dnxte-image-icon-effect', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextImageIcon/NextImageIcon.php';
	}

	if ( ! in_array( 'dnxte-image-scroll', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextImageScroll/NextImageScroll.php';
	}

	if ( ! in_array( 'dnxte-facebook-like-button', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextLikeButton/NextLikeButton.php';
	}

	if ( ! in_array( 'dnxte-masonry-gallery', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextMasonary/NextMasonary.php';
	}

	if ( ! in_array( 'dnxte-mega-image-effect', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextMegaImageEffect/NextMegaImageEffect.php';
	}

	if ( ! in_array( 'dnxte-minimal-image', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextMinimalImageHover/NextMinimalImageHover.php';
	}

	if ( ! in_array( 'dnxte-text-multi-heading', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextMultiHeading/NextMultiHeading.php';
	}

	if ( ! in_array( 'dnxte-rating', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextRating/NextRating.php';
	}

	if ( ! in_array( 'dnxte-divi-review', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextReview/NextReview.php';
	}

	if ( ! in_array( 'dnxte-step-flow', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextStepFlow/NextStepFlow.php';
	}

	if ( ! in_array( 'dnxte-team-creative', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextTeamCreative/NextTeamCreative.php';
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextTeamCreativeItem/NextTeamCreativeItem.php';
	}

	if ( ! in_array( 'dnxte-team-member-overlay', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextTeamOverlay/NextTeamOverlay.php';
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextTeamOverlayItem/NextTeamOverlayItem.php';
	}

	if ( ! in_array( 'dnxte-team-overlay-card', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextTeamOverlayCard/NextTeamOverlayCard.php';
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextTeamOverlayCardItem/NextTeamOverlayCardItem.php';
	}

	if ( ! in_array( 'dnxte-team-social-reveal', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextTeamSocialReveal/NextTeamSocialReveal.php';
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextTeamSocialRevealChild/NextTeamSocialRevealChild.php';
	}

	if ( ! in_array( 'dnxte-text-animation', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextTextAnimation/NextTextAnimation.php';
	}

	if ( ! in_array( 'dnxte-text-color-motion', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextTextColorMotion/NextTextColorMotion.php';
	}

	if ( ! in_array( 'dnxte-text-divider', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextTextDivider/NextTextDivider.php';
	}

	if ( ! in_array( 'dnxte-text-glitch', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextTextGlitch/NextTextGlitch.php';
	}

	if ( ! in_array( 'dnxte-text-highlight', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextTextHighlight/NextTextHighlight.php';
	}

	if ( ! in_array( 'dnxte-text-hover-highlight', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextTextHoverHighlight/NextTextHoverHighlight.php';
	}

	if ( ! in_array( 'dnxte-text-mask', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextTextMask/NextTextMask.php';
	}

	if ( ! in_array( 'dnxte-text-stroke', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextTextStroke/NextTextStroke.php';
	}

	if ( ! in_array( 'dnxte-text-stroke-motion', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextTextStrokeMotion/NextTextStrokeMotion.php';
	}

	if ( ! in_array( 'dnxte-text-tilt', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextTextTilt/NextTextTilt.php';
	}

	if ( ! in_array( 'dnxte-timeline', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextTimeline/NextTimeline.php';
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextTimelineChild/NextTimelineChild.php';
	}

	if ( ! in_array( 'dnxte-twitter-follow', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextTwitterFollow/NextTwitterFollow.php';
	}

	if ( ! in_array( 'dnxte-twitter-share', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextTwitterShare/NextTwitterShare.php';
	}

	if ( ! in_array( 'dnxte-twitter-timeline', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextTwitterTimeline/NextTwitterTimeline.php';
	}

	if ( ! in_array( 'dnxte-twitter-tweet', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextTwitterTweet/NextTwitterTweet.php';
	}

	if ( ! in_array( 'dnxte-ultimate-image-hover', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextUltimateImageHover/NextUltimateImageHover.php';
	}

	if ( ! in_array( 'dnxte-content-toggle', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextContentToggle/NextContentToggle.php';
	}

	if ( ! in_array( 'dnxte-post-carousel', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextBlogSlider/NextBlogSlider.php';
	}

	if ( ! in_array( 'dnxte-advanced-tab', $inactive_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextAdvancedTab/NextAdvancedTab.php';
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextAdvancedTabItem/NextAdvancedTabItem.php';
	}
}
dnxte_register_modules();