<?php

function dtdr_dashboard_seller_reviews_page_content() {

	$output = '';

	$output .= '<div class="dtdr-my-reviews-container">';

		$output .= '<div class="dtdr-my-reviews-item-holder">';

			$output .= '<div class="dtdr-column dtdr-one-column first">';

				$output .= '<div class="dtdr-dashbord-section-holder">';

					$author_id = get_current_user_id();

					$output .= '<div class="dtdr-dashbord-section-holder-intro">';
						$output .= '<div class="dtdr-dashbord-section-title">'.esc_html__('Reviews', 'dtdr').'</div>';
						$output .= '<div class="dtdr-dashbord-section-title-notes">'.esc_html__('Reviews added by users from frontend comment form.', 'dtdr').'</div>';
					$output .= '</div>';

					$output .= '<div class="dtdr-dashbord-section-holder-content">';

						$output .= '<ul class="dtdr-dashbord-reviews-listing-options-wrapper">';
							$output .= '<li class="dtdr-dashbord-reviews-loader all" data-authorid="'.esc_attr($author_id).'">'.esc_html__('All', 'dtdr').'</li>';
							$output .= '<li class="dtdr-dashbord-reviews-loader received" data-authorid="'.esc_attr($author_id).'">'.esc_html__('Received', 'dtdr').'</li>';
							$output .= '<li class="dtdr-dashbord-reviews-loader submitted" data-authorid="'.esc_attr($author_id).'">'.esc_html__('Submitted', 'dtdr').'</li>';
						$output .= '</ul>';

					$output .= '</div>';

				$output .= '</div>';

			$output .= '</div>';

			$output .= '<div class="dtdr-column dtdr-one-column first">';
				$output .= '<div class="dtdr-dashbord-section-holder">';
					$output .= '<div class="dtdr-dashbord-reviews-listing-wrapper"></div>';
				$output .= '</div>';
			$output .= '</div>';

		$output .= '</div>';

	$output .= '</div>';

	wp_enqueue_style ( 'prettyPhoto' );
	wp_enqueue_script ( 'prettyPhoto' );

	return $output;

}

// Reviews Loader

add_action( 'wp_ajax_dtdr_dashbord_reviews_loader', 'dtdr_dashbord_reviews_loader' );
add_action( 'wp_ajax_nopriv_dtdr_dashbord_reviews_loader', 'dtdr_dashbord_reviews_loader' );
function dtdr_dashbord_reviews_loader() {

	extract(dtdr_recursive_sanitize_text_field($_REQUEST));

	$output = '';

	if($review_type == 'all' || $review_type == 'received') {

		// Author Listing Ids
		$author_listings_args = array (
			'posts_per_page' => -1,
			'post_type'      => 'dtdr_listings',
			'author'         => $author_id,
			'post_status'    => 'publish',
			'fields'		 => 'ids'
		);
		$author_listings = get_posts( $author_listings_args );
		wp_reset_postdata();

		// Reviews received for author listings
		$args = array(
			'post__in' => $author_listings
		);
		$reviews = get_comments($args);

		if(is_array($reviews) && !empty($reviews)) {

			foreach($reviews as $review) {

				$comment_id   = $review->comment_ID;
				$listing_id    = $review->comment_post_ID;

				$dtdr_title    = get_comment_meta( $comment_id, 'dtdr_title', true );
				$dtdr_mediaids = get_comment_meta( $comment_id, 'dtdr_media_ids', true );
				$dtdr_rating   = get_comment_meta( $comment_id, 'dtdr_rating', true );


				$output .= '<div class="dtdr-dashbord-reviews-listing">';

					$output .= '<h4>'.sprintf(esc_html__('%1$s posted review on %2$s', 'dtdr'), $review->comment_author, '<a href="'.get_permalink($listing_id).'">'.get_the_title($listing_id).'</a>').'</h4>';
					$output .= '<h5>'.$dtdr_title.'</h5>';
					$output .= '<div class="dtdr-ratings-holder">';
						$output .= dtdr_comment_rating_display($dtdr_rating);
					$output .= '</div>';
					$output .= '<div class="dtdr-dashbord-reviews-date">'.get_comment_date(get_option('date_format').' '.get_option('time_format'), $comment_id).'</div>';
					$output .= '<p>'.$review->comment_content.'</p>';

					if(is_array($dtdr_mediaids) && !empty($dtdr_mediaids)) {

						$output .= '<ul class="dtdr-dashbord-reviews-gallery">';
						foreach($dtdr_mediaids as $mediaid) {
							$thumbnail_url = wp_get_attachment_image_src($mediaid, 'thumbnail');
							$full_url = wp_get_attachment_image_src($mediaid, 'full');
							$output .= '<li>
											<a href="'.esc_url($full_url[0]).'" rel="prettyPhoto[comment_gallery_'.esc_attr($comment_id).']" class="dtdr_comment_gallery_item"><img src="'.esc_url($thumbnail_url[0]).'" title="'.esc_html__('Comment Media', 'dtdr').'" all="'.esc_html__('Comment Media', 'dtdr').'" /></a>
										</li>';
						}
						$output .= '</ul>';

					}

				$output .= '</div>';

			}

		}

	}

	if($review_type == 'all' || $review_type == 'submitted') {

		// Reviews submitted by author
		$args = array(
			'author__in' => $author_id
		);
		$reviews = get_comments($args);

		if(is_array($reviews) && !empty($reviews)) {

			foreach($reviews as $review) {

				$comment_id   = $review->comment_ID;
				$listing_id    = $review->comment_post_ID;

				$dtdr_title    = get_comment_meta( $comment_id, 'dtdr_title', true );
				$dtdr_mediaids = get_comment_meta( $comment_id, 'dtdr_media_ids', true );
				$dtdr_rating   = get_comment_meta( $comment_id, 'dtdr_rating', true );


				$output .= '<div class="dtdr-dashbord-reviews-listing">';

					$output .= '<h4>'.sprintf(esc_html__('You have posted review on %1$s', 'dtdr'), '<a href="'.get_permalink($listing_id).'">'.get_the_title($listing_id).'</a>').'</h4>';
					$output .= '<h5>'.$dtdr_title.'</h5>';
					$output .= '<div class="dtdr-ratings-holder">';
						$output .= dtdr_comment_rating_display($dtdr_rating);
					$output .= '</div>';
					$output .= '<div class="dtdr-dashbord-reviews-date">'.get_comment_date(get_option('date_format').' '.get_option('time_format'), $comment_id).'</div>';
					$output .= '<p>'.$review->comment_content.'</p>';

					if(is_array($dtdr_mediaids) && !empty($dtdr_mediaids)) {

						$output .= '<ul class="dtdr-dashbord-reviews-gallery">';
						foreach($dtdr_mediaids as $mediaid) {
							$thumbnail_url = wp_get_attachment_image_src($mediaid, 'thumbnail');
							$full_url = wp_get_attachment_image_src($mediaid, 'full');
							$output .= '<li>
											<a href="'.esc_url($full_url[0]).'" rel="prettyPhoto[comment_gallery_'.esc_attr($comment_id).']" class="dtdr_comment_gallery_item"><img src="'.esc_url($thumbnail_url[0]).'" title="'.esc_html__('Comment Media', 'dtdr').'" all="'.esc_html__('Comment Media', 'dtdr').'" /></a>
										</li>';
						}
						$output .= '</ul>';

					}

				$output .= '</div>';

			}

		}

	}

	echo dtdr_html_output($output);

	wp_die();

}

?>