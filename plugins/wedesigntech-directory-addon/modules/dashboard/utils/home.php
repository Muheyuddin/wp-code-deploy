<?php

function dtdr_dashboard_home_page_content() {

	$output = '';

	$output .= '<div class="dtdr-dashbord-section-holder">';

		$output .= '<div class="dtdr-dashbord-section-holder-content">';

			$author_id = get_current_user_id();

			// Leads
			$leads_count = get_user_meta($author_id, 'dtdr_leads_count', true);
			$leads_count = (isset($leads_count) && !empty($leads_count)) ? $leads_count : 0;

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

			// Total Views
			$total_views = 0;
			if(is_array($author_listings) && !empty($author_listings)) {
				foreach($author_listings as $author_listing) {
					$views = get_post_meta($author_listing, 'dtdr_total_views', true);
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


			$output .= '<div class="dtdr-dashbord-statistics-counter-wrapper">';
				$output .= '<div class="dtdr-column dtdr-one-third first">';
					$output .= '<div class="dtdr-dashbord-statistics-counter-label">'.esc_html__('Leads', 'dtdr').'</div>';
					$output .= '<div class="dtdr-dashbord-statistics-counter">'.esc_html($leads_count).'</div>';
				$output .= '</div>';
				$output .= '<div class="dtdr-column dtdr-one-third">';
					$output .= '<div class="dtdr-dashbord-statistics-counter-label">'.esc_html__('User Views', 'dtdr').'</div>';
					$output .= '<div class="dtdr-dashbord-statistics-counter">'.esc_html($total_views).'</div>';
				$output .= '</div>';
				$output .= '<div class="dtdr-column dtdr-one-third">';
					$output .= '<div class="dtdr-dashbord-statistics-counter-label">'.esc_html__('Reviews', 'dtdr').'</div>';
					$output .= '<div class="dtdr-dashbord-statistics-counter">'.esc_html($total_reviews).'</div>';
				$output .= '</div>';
			$output .= '</div>';

		$output .= '</div>';

	$output .= '</div>';


	$output .= '<div class="dtdr-dashbord-section-holder">';

		$output .= '<div class="dtdr-dashbord-section-holder-intro">';
			$output .= '<div class="dtdr-dashbord-section-title">'.esc_html__('Recent Activities', 'dtdr').'</div>';
			$output .= '<div class="dtdr-dashbord-section-title-notes">'.esc_html__('Recent activities of your listings can be viewed here.', 'dtdr').'</div>';
		$output .= '</div>';

		$output .= '<div class="dtdr-dashbord-section-holder-content">';

			$output .= '<div class="dtdr-dashbord-recent-activites-wrapper">';

				$dtdr_recent_activities = get_user_meta($author_id, 'dtdr_recent_activities', true);

				if(is_array($dtdr_recent_activities) && !empty($dtdr_recent_activities)) {
					$output .= '<div class="dtdr-dashbord-recent-activites-holder">';
					foreach($dtdr_recent_activities as $dtdr_recent_activity) {

						$lead_origin_cls = '';
						if($dtdr_recent_activity['type'] == 'contact') {
							$lead_origin_cls = 'lead-origin-contact-form';
						} else if($dtdr_recent_activity['type'] == 'review') {
							$lead_origin_cls = 'lead-origin-comment-form';
						} else if($dtdr_recent_activity['type'] == 'website') {
							$lead_origin_cls = 'lead-origin-website-visit';
						}

						$output .= '<div class="dtdr-dashbord-recent-activites-content '.esc_attr($lead_origin_cls).'">';

							$user_id    = $dtdr_recent_activity['user_id'];
							$listing_id = $dtdr_recent_activity['listing_id'];
							$date       = $dtdr_recent_activity['date'];

							if($user_id > 0) {

								$dtdr_user_profile_image = get_the_author_meta( 'dtdr_user_profile_image' , $user_id );
								if($dtdr_user_profile_image > 0) {

									$image_url               = wp_get_attachment_image_src($dtdr_user_profile_image, 'thumbnail');
									$profile_image           = (isset($image_url[0]) && !empty($image_url[0])) ? $image_url[0] : '';

									if($profile_image != '') {
										$display_name = get_the_author_meta('display_name', $user_id);
										$user_image   = '<img src="'.esc_url($profile_image).'" alt="'.esc_html__('User Image', 'dtdr').'" title="'.esc_html__('User Image', 'dtdr').'" />';
									}

								}

							} else {

								$display_name = isset($dtdr_recent_activity['name']) ? $dtdr_recent_activity['name'] : '';
								$user_image   = get_avatar(0, 150);

							}

							$output .= $user_image;

							if($dtdr_recent_activity['type'] == 'contact') {

								$output .= '<p>'.sprintf(esc_html__('%1$s has contacted you for %2$s', 'dtdr'), '<strong>'.$display_name.'</strong>', '<a href="'.get_permalink($listing_id).'">'.get_the_title($listing_id).'</a>').'</p>';

							} else if($dtdr_recent_activity['type'] == 'review') {

								$dtdr_rating = get_comment_meta($dtdr_recent_activity['comment_id'], 'dtdr_rating', true);

								$dtdr_rating_str = '';
								if($dtdr_rating != '') {
									$dtdr_rating_str = $dtdr_rating.'/5 rating and ';
								}

								$output .= '<p>'.sprintf(esc_html__('%1$s left %2$s review for your %3$s', 'dtdr'), '<strong>'.$display_name.'</strong>', $dtdr_rating_str, '<a href="'.get_permalink($listing_id).'">'.get_the_title($listing_id).'</a>').'</p>';

							} else if($dtdr_recent_activity['type'] == 'website') {

								$output .= '<p>'.sprintf(esc_html__('Someone has clicked your website link at %1$s', 'dtdr'), '<a href="'.get_permalink($listing_id).'">'.get_the_title($listing_id).'</a>').'</p>';

								$location_details = '';
								if($dtdr_recent_activity['country'] != '') {
									$location_details .= '<ul>';
										$location_details .= '<li>'.esc_html__('Country : ', 'dtdr').'<span>'.$dtdr_recent_activity['country'].'</span></li>';
										$location_details .= '<li>'.esc_html__('City : ', 'dtdr').'<span>'.$dtdr_recent_activity['city'].'</span></li>';
										$location_details .= '<li>'.esc_html__('Zip : ', 'dtdr').'<span>'.$dtdr_recent_activity['zip'].'</span></li>';
									$location_details .= '</ul>';
									$output.= '<div class="dtdr-recent-activites-website-location-details">'.$location_details.'</div>';
								}

							} else if($dtdr_recent_activity['type'] == 'phone') {

								$output .= '<p>'.sprintf(esc_html__('Someone has clicked your phone number at %1$s', 'dtdr'), '<a href="'.get_permalink($listing_id).'">'.get_the_title($listing_id).'</a>').'</p>';

								$location_details = '';
								if($dtdr_recent_activity['country'] != '') {
									$location_details .= '<ul>';
										$location_details .= '<li>'.esc_html__('Country : ', 'dtdr').'<span>'.$dtdr_recent_activity['country'].'</span></li>';
										$location_details .= '<li>'.esc_html__('City : ', 'dtdr').'<span>'.$dtdr_recent_activity['city'].'</span></li>';
										$location_details .= '<li>'.esc_html__('Zip : ', 'dtdr').'<span>'.$dtdr_recent_activity['zip'].'</span></li>';
									$location_details .= '</ul>';
									$output.= '<div class="dtdr-recent-activites-website-location-details">'.$location_details.'</div>';
								}

							} else if($dtdr_recent_activity['type'] == 'mobile') {

								$output .= '<p>'.sprintf(esc_html__('Someone has clicked your mobile number at %1$s', 'dtdr'), '<a href="'.get_permalink($listing_id).'">'.get_the_title($listing_id).'</a>').'</p>';

								$location_details = '';
								if($dtdr_recent_activity['country'] != '') {
									$location_details .= '<ul>';
										$location_details .= '<li>'.esc_html__('Country : ', 'dtdr').'<span>'.$dtdr_recent_activity['country'].'</span></li>';
										$location_details .= '<li>'.esc_html__('City : ', 'dtdr').'<span>'.$dtdr_recent_activity['city'].'</span></li>';
										$location_details .= '<li>'.esc_html__('Zip : ', 'dtdr').'<span>'.$dtdr_recent_activity['zip'].'</span></li>';
									$location_details .= '</ul>';
									$output.= '<div class="dtdr-recent-activites-website-location-details">'.$location_details.'</div>';
								}

							}

							$output.= '<div class="dtdr-dashbord-recent-activites-datetime">'.$date.'</div>';

						$output .= '</div>';

					}
					$output .= '</div>';
				} else {
					$output .= '<div class="dtdr-dashboard-notices">'.esc_html__('No activities found recently!', 'dtdr').'</div>';
				}

			$output .= '</div>';

		$output .= '</div>';

	$output .= '</div>';


	return $output;

}

?>