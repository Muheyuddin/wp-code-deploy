<?php

function dtsl_dashboard_seller_reviews_page_content() {

	$output = '';

	$output .= '<div class="dtsl-my-reviews-container">';

		$output .= '<div class="dtsl-my-reviews-item-holder">';

			$output .= '<div class="dtsl-column dtsl-one-column first">';

				$output .= '<div class="dtsl-dashbord-section-holder">';

					$author_id = get_current_user_id();

					$output .= '<div class="dtsl-dashbord-section-holder-intro">';
						$output .= '<div class="dtsl-dashbord-section-title">'.esc_html__('Reviews', 'dtsl').'</div>';
						$output .= '<div class="dtsl-dashbord-section-title-notes">'.esc_html__('Reviews added by users from frontend comment form.', 'dtsl').'</div>';
					$output .= '</div>';

					$output .= '<div class="dtsl-dashbord-section-holder-content">';

						$output .= '<ul class="dtsl-dashbord-reviews-listing-options-wrapper">';
							$output .= '<li class="dtsl-dashbord-reviews-loader all" data-authorid="'.esc_attr($author_id).'">'.esc_html__('All', 'dtsl').'</li>';
							$output .= '<li class="dtsl-dashbord-reviews-loader received" data-authorid="'.esc_attr($author_id).'">'.esc_html__('Received', 'dtsl').'</li>';
							$output .= '<li class="dtsl-dashbord-reviews-loader submitted" data-authorid="'.esc_attr($author_id).'">'.esc_html__('Submitted', 'dtsl').'</li>';
						$output .= '</ul>';

					$output .= '</div>';

				$output .= '</div>';

			$output .= '</div>';

			$output .= '<div class="dtsl-column dtsl-one-column first">';
				$output .= '<div class="dtsl-dashbord-section-holder">';
					$output .= '<div class="dtsl-dashbord-reviews-listing-wrapper"></div>';
				$output .= '</div>';
			$output .= '</div>';

		$output .= '</div>';

	$output .= '</div>';

	wp_enqueue_style ( 'prettyPhoto' );
	wp_enqueue_script ( 'prettyPhoto' );

	return $output;

}

// Reviews Loader

add_action( 'wp_ajax_dtsl_dashbord_reviews_loader', 'dtsl_dashbord_reviews_loader' );
add_action( 'wp_ajax_nopriv_dtsl_dashbord_reviews_loader', 'dtsl_dashbord_reviews_loader' );
function dtsl_dashbord_reviews_loader() {

	extract(dtsl_recursive_sanitize_text_field($_REQUEST));

	$output = '';

	if($review_type == 'all' || $review_type == 'received') {

		// Author Listing Ids
		$author_listings_args = array (
			'posts_per_page' => -1,
			'post_type'      => 'dtsl_listings',
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

				$dtsl_title    = get_comment_meta( $comment_id, 'dtsl_title', true );
				$dtsl_mediaids = get_comment_meta( $comment_id, 'dtsl_media_ids', true );
				$dtsl_rating   = get_comment_meta( $comment_id, 'dtsl_rating', true );


				$output .= '<div class="dtsl-dashbord-reviews-listing">';

					$output .= '<h4>'.sprintf(esc_html__('%1$s posted review on %2$s', 'dtsl'), $review->comment_author, '<a href="'.get_permalink($listing_id).'">'.get_the_title($listing_id).'</a>').'</h4>';
					$output .= '<h5>'.$dtsl_title.'</h5>';
					$output .= '<div class="dtsl-ratings-holder">';
						$output .= dtsl_comment_rating_display($dtsl_rating);
					$output .= '</div>';
					$output .= '<div class="dtsl-dashbord-reviews-date">'.get_comment_date(get_option('date_format').' '.get_option('time_format'), $comment_id).'</div>';
					$output .= '<p>'.$review->comment_content.'</p>';

					if(is_array($dtsl_mediaids) && !empty($dtsl_mediaids)) {

						$output .= '<ul class="dtsl-dashbord-reviews-gallery">';
						foreach($dtsl_mediaids as $mediaid) {
							$thumbnail_url = wp_get_attachment_image_src($mediaid, 'thumbnail');
							$full_url = wp_get_attachment_image_src($mediaid, 'full');
							$output .= '<li>
											<a href="'.esc_url($full_url[0]).'" rel="prettyPhoto[comment_gallery_'.esc_attr($comment_id).']" class="dtsl_comment_gallery_item"><img src="'.esc_url($thumbnail_url[0]).'" title="'.esc_html__('Comment Media', 'dtsl').'" all="'.esc_html__('Comment Media', 'dtsl').'" /></a>
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

				$dtsl_title    = get_comment_meta( $comment_id, 'dtsl_title', true );
				$dtsl_mediaids = get_comment_meta( $comment_id, 'dtsl_media_ids', true );
				$dtsl_rating   = get_comment_meta( $comment_id, 'dtsl_rating', true );


				$output .= '<div class="dtsl-dashbord-reviews-listing">';

					$output .= '<h4>'.sprintf(esc_html__('You have posted review on %1$s', 'dtsl'), '<a href="'.get_permalink($listing_id).'">'.get_the_title($listing_id).'</a>').'</h4>';
					$output .= '<h5>'.$dtsl_title.'</h5>';
					$output .= '<div class="dtsl-ratings-holder">';
						$output .= dtsl_comment_rating_display($dtsl_rating);
					$output .= '</div>';
					$output .= '<div class="dtsl-dashbord-reviews-date">'.get_comment_date(get_option('date_format').' '.get_option('time_format'), $comment_id).'</div>';
					$output .= '<p>'.$review->comment_content.'</p>';

					if(is_array($dtsl_mediaids) && !empty($dtsl_mediaids)) {

						$output .= '<ul class="dtsl-dashbord-reviews-gallery">';
						foreach($dtsl_mediaids as $mediaid) {
							$thumbnail_url = wp_get_attachment_image_src($mediaid, 'thumbnail');
							$full_url = wp_get_attachment_image_src($mediaid, 'full');
							$output .= '<li>
											<a href="'.esc_url($full_url[0]).'" rel="prettyPhoto[comment_gallery_'.esc_attr($comment_id).']" class="dtsl_comment_gallery_item"><img src="'.esc_url($thumbnail_url[0]).'" title="'.esc_html__('Comment Media', 'dtsl').'" all="'.esc_html__('Comment Media', 'dtsl').'" /></a>
										</li>';
						}
						$output .= '</ul>';

					}

				$output .= '</div>';

			}

		}

	}

	echo dtsl_html_output($output);

	wp_die();

}

?>