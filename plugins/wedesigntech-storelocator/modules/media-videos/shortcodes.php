<?php

// Single Page - Media Videos
if(!function_exists('dtsl_sp_media_videos')) {
	function dtsl_sp_media_videos( $attrs, $content = null ) {

		$attrs = shortcode_atts ( array (

					'listing_id'                    => '',
					'class'                         => '',

					'carousel_effect'               => '',
					'carousel_slidesperview'        => 1,
					'carousel_loopmode'             => '',
					'carousel_mousewheelcontrol'    => '',
					'carousel_paginationtype'       => 'bullets',
					'carousel_arrowpagination'      => '',
					'carousel_arrowpagination_type' => 'type1',
					'carousel_spacebetween'         => '',

				), $attrs, 'dtsl_sp_media_videos' );


		$output = '';

		if($attrs['listing_id'] == '' && is_singular('dtsl_listings')) {
			global $post;
			$attrs['listing_id'] = $post->ID;
		}

		if($attrs['listing_id'] != '') {

			$media_carousel_attributes = array ();

			array_push($media_carousel_attributes, 'data-enablecarousel="true"');
			array_push($media_carousel_attributes, 'data-carouseleffect="'.$attrs['carousel_effect'].'"');
			array_push($media_carousel_attributes, 'data-carouselslidesperview="'.$attrs['carousel_slidesperview'].'"');
			array_push($media_carousel_attributes, 'data-carouselloopmode="'.$attrs['carousel_loopmode'].'"');
			array_push($media_carousel_attributes, 'data-carouselmousewheelcontrol="'.$attrs['carousel_mousewheelcontrol'].'"');
			array_push($media_carousel_attributes, 'data-carouselpaginationtype="'.$attrs['carousel_paginationtype'].'"');
			array_push($media_carousel_attributes, 'data-carouselarrowpagination="'.$attrs['carousel_arrowpagination'].'"');
			array_push($media_carousel_attributes, 'data-carouselspacebetween="'.$attrs['carousel_spacebetween'].'"');

			if(!empty($media_carousel_attributes)) {
				$media_carousel_attributes_string = implode(' ', $media_carousel_attributes);
			}


			$dtsl_media_videos = get_post_meta($attrs['listing_id'], 'dtsl_media_videos', true);
			$uniqid = uniqid();

			$output .= '<div class="dtsl-listings-media-videos-holder '.$attrs['class'].'">';

				// Media Videos
				$output .= '<div class="dtsl-listings-media-videos-container swiper-container" '.$media_carousel_attributes_string.'>';
					$output .= '<div class="dtsl-listings-media-videos swiper-wrapper">';

									if(is_array($dtsl_media_videos) && !empty($dtsl_media_videos)) {
										$i = 0;
										foreach($dtsl_media_videos as $dtsl_media_video) {

											if(wp_oembed_get( $dtsl_media_video ) != '') {
												$output .= '<div class="swiper-slide" data-hash="slide-'.$uniqid.$i.'">'.wp_oembed_get( $dtsl_media_video ).'</div>';
											} else {
												$output .= '<div class="swiper-slide" data-hash="slide-'.$uniqid.$i.'">'.wp_video_shortcode( array('src' => $dtsl_media_video) ).'</div>';
											}

											$i++;
										}
									}

					$output .= '</div>';

					$output .= '<div class="dtsl-listings-swiper-pagination-holder">';

						if($attrs['carousel_paginationtype'] == 'bullets') {
							$output .= '<div class="dtsl-swiper-bullet-pagination"></div>';
						}

						if($attrs['carousel_paginationtype'] == 'progressbar') {
							$output .= '<div class="dtsl-swiper-progress-pagination"></div>';
						}

						if($attrs['carousel_paginationtype'] == 'fraction') {
							$output .= '<div class="dtsl-swiper-fraction-pagination"></div>';
						}

						if($attrs['carousel_arrowpagination'] == 'true') {
							$output .= '<div class="dtsl-swiper-arrow-pagination '.$attrs['carousel_arrowpagination_type'].'">';
								$output .= '<a href="#" class="dtsl-swiper-arrow-prev">'.esc_html__('Prev', 'dtsl').'</a>';
								$output .= '<a href="#" class="dtsl-swiper-arrow-next">'.esc_html__('Next', 'dtsl').'</a>';
							$output .= '</div>';
						}

					$output .= '</div>';
				$output .= '</div>';

			$output .= '</div>';

		} else {

			$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );

			$output .= sprintf( esc_html__('Please provide %1$s id to display corresponding data!', 'dtsl'), strtolower($dt_sl_listing_singular_label) );

		}

		return $output;

	}
	add_shortcode ( 'dtsl_sp_media_videos', 'dtsl_sp_media_videos' );
}

?>