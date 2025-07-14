<?php

function dtdr_dashboard_favourite_listings_page_content() {

	$output = '';

	$dashboard_page_id = get_the_ID();

	$listing_singular_label = apply_filters( 'listing_label', 'singular' );
	$listing_plural_label = apply_filters( 'listing_label', 'plural' );


	// Favourite Listings
	$output .= '<div class="dtdr-dashbord-section-holder">';

		$output .= '<div class="dtdr-dashbord-section-holder-intro">';
			$output .= '<div class="dtdr-dashbord-section-title">'.sprintf( esc_html__('Favourite %1$s', 'dtdr'), $listing_plural_label ).'</div>';
			$output .= '<div class="dtdr-dashbord-section-title-notes">'.sprintf( esc_html__('%1$s that you have marked as your favourite.', 'dtdr'), $listing_plural_label ).'</div>';
		$output .= '</div>';

		$output .= '<div class="dtdr-dashbord-section-holder-content dtdr-dashbord-load-favourite-listings-content">';
			$output .= dtdr_dashboard_favourite_listings_table_content();
		$output .= '</div>';

	$output .= '</div>';


	return $output;

}

add_action( 'wp_ajax_dtdr_dashboard_favourite_listings_table_content', 'dtdr_dashboard_favourite_listings_table_content' );
add_action( 'wp_ajax_nopriv_dtdr_dashboard_favourite_listings_table_content', 'dtdr_dashboard_favourite_listings_table_content' );
function dtdr_dashboard_favourite_listings_table_content() {

	$output = '';

	// Pagination script Start
	$ajax_call = (isset($_REQUEST['ajax_call']) && $_REQUEST['ajax_call'] == true) ? true : false;
	$current_page = isset($_REQUEST['current_page']) ? dtdr_recursive_sanitize_text_field($_REQUEST['current_page']) : 1;
	$offset = isset($_REQUEST['offset']) ? dtdr_recursive_sanitize_text_field($_REQUEST['offset']) : 0;
	$frontend_postperpage = dtdr_option('general','frontend-postperpage');
	$post_per_page = isset($_REQUEST['post_per_page']) ? dtdr_recursive_sanitize_text_field($_REQUEST['post_per_page']) : dtdr_recursive_sanitize_text_field($frontend_postperpage);

	$function_call = (isset($_REQUEST['function_call']) && $_REQUEST['function_call'] != '') ? dtdr_recursive_sanitize_text_field($_REQUEST['function_call']) : 'dtdr_dashboard_favourite_listings_table_content';
	$output_div = (isset($_REQUEST['output_div']) && $_REQUEST['output_div'] != '') ? dtdr_recursive_sanitize_text_field($_REQUEST['output_div']) : 'dtdr-dashbord-load-favourite-listings-content';
	// Pagination script End

	$listing_singular_label = apply_filters( 'listing_label', 'singular' );
	$listing_plural_label = apply_filters( 'listing_label', 'plural' );

	$dashboard_page_id = get_the_ID();

	$output .= '<div class="dtdr-dashboard-notices"></div>';

	$output .= '<table border="0" cellpadding="0" cellspacing="0">
					<thead>
						<tr>
							<th scope="col">'.esc_html__('#', 'dtlms').'</th>
							<th scope="col">'.sprintf( esc_html__('%1$s', 'dtdr'), $listing_plural_label ).'</th>
							<th scope="col">'.esc_html__('Options', 'dtlms').'</th>
						</tr>
					</thead>
					<tbody>';

						$current_user = wp_get_current_user();
						$user_id = $current_user->ID;

						$favourite_items = get_user_meta($user_id, 'favourite_items', true);
						$favourite_items = (is_array($favourite_items) && !empty($favourite_items)) ? $favourite_items : array ();

						$favourite_items_filtered = array_slice($favourite_items, $offset, $post_per_page, true);

						if(is_array($favourite_items_filtered) && !empty($favourite_items_filtered)) {
							$i = 1;
							foreach($favourite_items_filtered as $package_listing_id) {
								$output .= '<tr>
												<td>'.$i.'</td>
												<td>'.get_the_title($package_listing_id).'</td>
												<td>

									                <a data-tooltip="'.sprintf( esc_html__( 'Remove Favourite %1$s', 'dtdr' ), $listing_singular_label ).'" class="dtdr-remove-favourite-listing" data-nonce="'.wp_create_nonce('dtdr-remove-favourite-listing-'. $package_listing_id ).'"  data-listing-id="'.esc_attr($package_listing_id).'" data-user-id="'.esc_attr($user_id).'" data-dashboard-page-url="'.esc_url(get_permalink($dashboard_page_id)).'">
						                				<i class="far fa-times-circle"></i>
						                			</a>

				                					<a data-tooltip="'.sprintf( esc_html__( 'View Favourite %1$s', 'dtdr' ), $listing_singular_label ).'" href="'.get_permalink($package_listing_id).'">
						                				<i class="far fa-eye"></i>
						                			</a>

												</td>
											</tr>';
								$i++;
							}
						} else {
							$output .= '<tr>
											<td colspan="3">'.esc_html__('No records found!', 'dtdr').'</td>
										</tr>';
						}

		$output .= '</tbody>';
	$output .= '</table>';


	// Pagination script Start
	$favourite_items_count = count($favourite_items);
	$max_num_pages = ceil($favourite_items_count / $post_per_page);

	$item_ids['pagination'] = 'frontend';

	$output .= dtdr_ajax_pagination($max_num_pages, $current_page, $function_call, $output_div, $item_ids);
	// Pagination script End


	if($ajax_call) {

		echo dtdr_html_output($output);

		die();

	} else {

		return $output;

	}

}

// Remove favourite listing
add_action( 'wp_ajax_dtdr_remove_favourite_listing', 'dtdr_remove_favourite_listing' );
add_action( 'wp_ajax_nopriv_dtdr_remove_favourite_listing', 'dtdr_remove_favourite_listing' );
function dtdr_remove_favourite_listing() {

	extract(dtdr_recursive_sanitize_text_field($_REQUEST));

	$has_error = false;
	$errors = array ();

	if(wp_verify_nonce($nonce, 'dtdr-remove-favourite-listing-'.$listing_id)) {

		if($listing_id > 0 && $user_id > 0){

			$favourite_items = get_user_meta($user_id, 'favourite_items', true);
			$favourite_items = (is_array($favourite_items) && !empty($favourite_items)) ? $favourite_items : array ();

			if (($key = array_search($listing_id, $favourite_items)) !== false) {

				unset($favourite_items[$key]);

				update_user_meta($user_id, 'favourite_items', $favourite_items);
				echo 'success';

			} else {

				$has_error = true;
				$errors[] = '<p>'.esc_html__('Something went wrong!, Please try again.', 'dtdr').'</p>';

			}


		} else {

			$has_error = true;
			$errors[] = '<p>'.esc_html__('Something went wrong!, Please try again.', 'dtdr').'</p>';

		}

	}

    if($has_error) {
    	echo json_encode($errors);
    }


	die();

}

?>