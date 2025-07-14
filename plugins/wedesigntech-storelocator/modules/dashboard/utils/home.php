<?php

function dtsl_dashboard_home_page_content() {

	$output = '';

	$output .= '<div class="dtsl-dashbord-section-holder">';

		$output .= '<div class="dtsl-dashbord-section-holder-content">';

			$author_id = get_current_user_id();

			// Leads
			$leads_count = get_user_meta($author_id, 'dtsl_leads_count', true);
			$leads_count = (isset($leads_count) && !empty($leads_count)) ? $leads_count : 0;

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

			// Total Views
			$total_views = 0;
			if(is_array($author_listings) && !empty($author_listings)) {
				foreach($author_listings as $author_listing) {
					$views = get_post_meta($author_listing, 'dtsl_total_views', true);
					$views = ($views != '') ? $views : 0;
					$total_views = $total_views + $views;
				}
			}

			// Total Reviews
			$args = array(
				'post__in' => $author_listings,

			);
			$comments = get_comments($args);

			$total_reviews = count($comments);


			$output .= '<div class="dtsl-dashbord-statistics-counter-wrapper">';
				$output .= '<div class="dtsl-column dtsl-one-third first">';
					$output .= '<div class="dtsl-dashbord-statistics-counter-label">'.esc_html__('Leads', 'dtsl').'</div>';
					$output .= '<div class="dtsl-dashbord-statistics-counter">'.esc_html($leads_count).'</div>';
				$output .= '</div>';
				$output .= '<div class="dtsl-column dtsl-one-third">';
					$output .= '<div class="dtsl-dashbord-statistics-counter-label">'.esc_html__('User Views', 'dtsl').'</div>';
					$output .= '<div class="dtsl-dashbord-statistics-counter">'.esc_html($total_views).'</div>';
				$output .= '</div>';
				$output .= '<div class="dtsl-column dtsl-one-third">';
					$output .= '<div class="dtsl-dashbord-statistics-counter-label">'.esc_html__('Reviews', 'dtsl').'</div>';
					$output .= '<div class="dtsl-dashbord-statistics-counter">'.esc_html($total_reviews).'</div>';
				$output .= '</div>';
			$output .= '</div>';

		$output .= '</div>';

	$output .= '</div>';


	$output .= '<div class="dtsl-dashbord-section-holder">';

		$output .= '<div class="dtsl-dashbord-section-holder-intro">';
			$output .= '<div class="dtsl-dashbord-section-title">'.esc_html__('Recent Activities', 'dtsl').'</div>';
			$output .= '<div class="dtsl-dashbord-section-title-notes">'.esc_html__('Recent activities of your listings can be viewed here.', 'dtsl').'</div>';
		$output .= '</div>';

		$output .= '<div class="dtsl-dashbord-section-holder-content">';

			$output .= '<div class="dtsl-dashbord-recent-activites-wrapper">';

				$dtsl_recent_activities = get_user_meta($author_id, 'dtsl_recent_activities', true);

				if(is_array($dtsl_recent_activities) && !empty($dtsl_recent_activities)) {
					$output .= '<div class="dtsl-dashbord-recent-activites-holder">';
					foreach($dtsl_recent_activities as $dtsl_recent_activity) {

						$lead_origin_cls = '';
						if($dtsl_recent_activity['type'] == 'contact') {
							$lead_origin_cls = 'lead-origin-contact-form';
						} else if($dtsl_recent_activity['type'] == 'review') {
							$lead_origin_cls = 'lead-origin-comment-form';
						} else if($dtsl_recent_activity['type'] == 'website') {
							$lead_origin_cls = 'lead-origin-website-visit';
						}

						$output .= '<div class="dtsl-dashbord-recent-activites-content '.esc_attr($lead_origin_cls).'">';

							$user_id    = $dtsl_recent_activity['user_id'];
							$listing_id = $dtsl_recent_activity['listing_id'];
							$date       = $dtsl_recent_activity['date'];

							if($user_id > 0) {

								$dtsl_user_profile_image = get_the_author_meta( 'dtsl_user_profile_image' , $user_id );
								if($dtsl_user_profile_image > 0) {

									$image_url               = wp_get_attachment_image_src($dtsl_user_profile_image, 'thumbnail');
									$profile_image           = (isset($image_url[0]) && !empty($image_url[0])) ? $image_url[0] : '';

									if($profile_image != '') {
										$display_name = get_the_author_meta('display_name', $user_id);
										$user_image   = '<img src="'.esc_url($profile_image).'" alt="'.esc_html__('User Image', 'dtsl').'" title="'.esc_html__('User Image', 'dtsl').'" />';
									}

								}

							} else {

								$display_name = isset($dtsl_recent_activity['name']) ? $dtsl_recent_activity['name'] : '';
								$user_image   = get_avatar(0, 150);

							}

							$output .= $user_image;

							if($dtsl_recent_activity['type'] == 'contact') {

								$output .= '<p>'.sprintf(esc_html__('%1$s has contacted you for %2$s', 'dtsl'), '<strong>'.$display_name.'</strong>', '<a href="'.get_permalink($listing_id).'">'.get_the_title($listing_id).'</a>').'</p>';

							} else if($dtsl_recent_activity['type'] == 'review') {

								$dtsl_rating = get_comment_meta($dtsl_recent_activity['comment_id'], 'dtsl_rating', true);

								$dtsl_rating_str = '';
								if($dtsl_rating != '') {
									$dtsl_rating_str = $dtsl_rating.'/5 rating and ';
								}

								$output .= '<p>'.sprintf(esc_html__('%1$s left %2$s review for your %3$s', 'dtsl'), '<strong>'.$display_name.'</strong>', $dtsl_rating_str, '<a href="'.get_permalink($listing_id).'">'.get_the_title($listing_id).'</a>').'</p>';

							} else if($dtsl_recent_activity['type'] == 'website') {

								$output .= '<p>'.sprintf(esc_html__('Someone has clicked your website link at %1$s', 'dtsl'), '<a href="'.get_permalink($listing_id).'">'.get_the_title($listing_id).'</a>').'</p>';

								$location_details = '';
								if($dtsl_recent_activity['country'] != '') {
									$location_details .= '<ul>';
										$location_details .= '<li>'.esc_html__('Country : ', 'dtsl').'<span>'.$dtsl_recent_activity['country'].'</span></li>';
										$location_details .= '<li>'.esc_html__('City : ', 'dtsl').'<span>'.$dtsl_recent_activity['city'].'</span></li>';
										$location_details .= '<li>'.esc_html__('Zip : ', 'dtsl').'<span>'.$dtsl_recent_activity['zip'].'</span></li>';
									$location_details .= '</ul>';
									$output.= '<div class="dtsl-recent-activites-website-location-details">'.$location_details.'</div>';
								}

							} else if($dtsl_recent_activity['type'] == 'phone') {

								$output .= '<p>'.sprintf(esc_html__('Someone has clicked your phone number at %1$s', 'dtsl'), '<a href="'.get_permalink($listing_id).'">'.get_the_title($listing_id).'</a>').'</p>';

								$location_details = '';
								if($dtsl_recent_activity['country'] != '') {
									$location_details .= '<ul>';
										$location_details .= '<li>'.esc_html__('Country : ', 'dtsl').'<span>'.$dtsl_recent_activity['country'].'</span></li>';
										$location_details .= '<li>'.esc_html__('City : ', 'dtsl').'<span>'.$dtsl_recent_activity['city'].'</span></li>';
										$location_details .= '<li>'.esc_html__('Zip : ', 'dtsl').'<span>'.$dtsl_recent_activity['zip'].'</span></li>';
									$location_details .= '</ul>';
									$output.= '<div class="dtsl-recent-activites-website-location-details">'.$location_details.'</div>';
								}

							} else if($dtsl_recent_activity['type'] == 'mobile') {

								$output .= '<p>'.sprintf(esc_html__('Someone has clicked your mobile number at %1$s', 'dtsl'), '<a href="'.get_permalink($listing_id).'">'.get_the_title($listing_id).'</a>').'</p>';

								$location_details = '';
								if($dtsl_recent_activity['country'] != '') {
									$location_details .= '<ul>';
										$location_details .= '<li>'.esc_html__('Country : ', 'dtsl').'<span>'.$dtsl_recent_activity['country'].'</span></li>';
										$location_details .= '<li>'.esc_html__('City : ', 'dtsl').'<span>'.$dtsl_recent_activity['city'].'</span></li>';
										$location_details .= '<li>'.esc_html__('Zip : ', 'dtsl').'<span>'.$dtsl_recent_activity['zip'].'</span></li>';
									$location_details .= '</ul>';
									$output.= '<div class="dtsl-recent-activites-website-location-details">'.$location_details.'</div>';
								}

							}

							$output.= '<div class="dtsl-dashbord-recent-activites-datetime">'.$date.'</div>';

						$output .= '</div>';

					}
					$output .= '</div>';
				} else {
					$output .= '<div class="dtsl-dashboard-notices">'.esc_html__('No activities found recently!', 'dtsl').'</div>';
				}

			$output .= '</div>';

		$output .= '</div>';

	$output .= '</div>';


	return $output;

}

?>