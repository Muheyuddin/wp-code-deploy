<?php

// Single Page - Media Videos
if(!function_exists('dtdr_sp_media_videos')) {
	function dtdr_sp_media_videos( $attrs, $content = null ) {

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
					'popup_mode' 					=> 'false',

				), $attrs, 'dtdr_sp_media_videos' );


		$output = '';

		if($attrs['listing_id'] == '' && is_singular('dtdr_listings')) {
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


			$dtdr_media_videos = get_post_meta($attrs['listing_id'], 'dtdr_media_videos', true);
			$uniqid = uniqid();


			if($attrs['popup_mode'] == 'true') {

				$output .= '<div class="dtdr-listings-media-videos-holder">';

					$output .= '<div class="dtdr-listings-media-videos-popup-container dtdr-listings-media-videos" data-mfpsrc="'.esc_url($dtdr_media_videos[0]).'" data-popup="'.$attrs['popup_mode'].'" >';

						if(is_array($dtdr_media_videos) && !empty($dtdr_media_videos)) {
							$i = 0;
							foreach($dtdr_media_videos as $dtdr_media_video) {

									$featured_image_id = get_post_thumbnail_id($attrs['listing_id']);
										if($featured_image_id > 0) {
											$image_details = wp_get_attachment_image_src($featured_image_id, 'full');
											$output .= '<div class="dtdr-listing-media-popup"><img src="'.esc_url($image_details[0]).'" title="'.esc_html__('Featured Image', 'dtdr').'" alt="'.esc_html__('Featured Image', 'dtdr').'" /></div>';
											$output .= '<div class="dtdr-listing-media-popup-icon"></div>';
										}
								
								$i++;
							}
						}

						$popup_login_link = get_permalink( get_page_by_path( 'registration' ) );

						$output .= '<div class="dtdr-listings-popup-login">';
							$output .= '<div class="dtdr-listingsvideos-popup-login-content">'.sprintf( esc_html__('Please %1$s to watch this video.', 'dtdr'), '<a href="'.esc_attr($popup_login_link).'">'.esc_html__( 'login', 'dtdr').'</a>' ).'</div>';
						$output .= '</div>';

					$output .= '</div>';

				$output .= '</div>';

				
				
			} else {

				$output .= '<div class="dtdr-listings-media-videos-holder '.$attrs['class'].'">';

					// Media Videos
					$output .= '<div class="dtdr-listings-media-videos-container swiper-container" '.$media_carousel_attributes_string.'>';
						$output .= '<div class="dtdr-listings-media-videos swiper-wrapper">';

										if(is_array($dtdr_media_videos) && !empty($dtdr_media_videos)) {
											$i = 0;
											foreach($dtdr_media_videos as $dtdr_media_video) {

												if(wp_oembed_get( $dtdr_media_video ) != '') {
													$output .= '<div class="swiper-slide" data-hash="slide-'.$uniqid.$i.'">'.wp_oembed_get( $dtdr_media_video ).'</div>';
												} else {
													$output .= '<div class="swiper-slide" data-hash="slide-'.$uniqid.$i.'">'.wp_video_shortcode( array('src' => $dtdr_media_video) ).'</div>';
												}

												$i++;
											}
										}

						$output .= '</div>';

						$output .= '<div class="dtdr-listings-swiper-pagination-holder">';

							if($attrs['carousel_paginationtype'] == 'bullets') {
								$output .= '<div class="dtdr-swiper-bullet-pagination"></div>';
							}

							if($attrs['carousel_paginationtype'] == 'progressbar') {
								$output .= '<div class="dtdr-swiper-progress-pagination"></div>';
							}

							if($attrs['carousel_paginationtype'] == 'fraction') {
								$output .= '<div class="dtdr-swiper-fraction-pagination"></div>';
							}

							if($attrs['carousel_arrowpagination'] == 'true') {
								$output .= '<div class="dtdr-swiper-arrow-pagination '.$attrs['carousel_arrowpagination_type'].'">';
									$output .= '<a href="#" class="dtdr-swiper-arrow-prev">'.esc_html__('Prev', 'dtdr').'</a>';
									$output .= '<a href="#" class="dtdr-swiper-arrow-next">'.esc_html__('Next', 'dtdr').'</a>';
								$output .= '</div>';
							}

						$output .= '</div>';
					$output .= '</div>';

				$output .= '</div>';
				
			}
			

		} else {

			$listing_singular_label = apply_filters( 'listing_label', 'singular' );

			$output .= sprintf( esc_html__('Please provide %1$s id to display corresponding data!', 'dtdr'), strtolower($listing_singular_label) );

		}

		return $output;

	}
	add_shortcode ( 'dtdr_sp_media_videos', 'dtdr_sp_media_videos' );
}

?>