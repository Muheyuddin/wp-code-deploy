<?php

function dtdr_dashboard_buyer_listings_page_content() {

	$output = '';

	$dashboard_page_id = get_the_ID();

	$listing_singular_label = apply_filters( 'listing_label', 'singular' );
	$listing_plural_label = apply_filters( 'listing_label', 'plural' );


	// Subscribed Listings
	$output .= '<div class="dtdr-dashbord-section-holder">';

		$output .= '<div class="dtdr-dashbord-section-holder-intro">';
			$output .= '<div class="dtdr-dashbord-section-title">'.sprintf( esc_html__('Subscribed %1$s', 'dtdr'), $listing_plural_label ).'</div>';
			$output .= '<div class="dtdr-dashbord-section-title-notes">'.sprintf( esc_html__('%1$s that have been subscribed to view its contact information have been displayed here.', 'dtdr'), $listing_plural_label ).'</div>';
		$output .= '</div>';

		$output .= '<div class="dtdr-dashbord-section-holder-content dtdr-dashbord-load-buyer-listings-content">';
			$output .= dtdr_dashboard_buyer_listings_table_content();
		$output .= '</div>';

	$output .= '</div>';


	return $output;

}

add_action( 'wp_ajax_dtdr_dashboard_buyer_listings_table_content', 'dtdr_dashboard_buyer_listings_table_content' );
add_action( 'wp_ajax_nopriv_dtdr_dashboard_buyer_listings_table_content', 'dtdr_dashboard_buyer_listings_table_content' );
function dtdr_dashboard_buyer_listings_table_content() {

	$output = '';

	// Pagination script Start
	$ajax_call = (isset($_REQUEST['ajax_call']) && $_REQUEST['ajax_call'] == true) ? true : false;
	$current_page = isset($_REQUEST['current_page']) ? dtdr_recursive_sanitize_text_field($_REQUEST['current_page']) : 1;
	$offset = isset($_REQUEST['offset']) ? dtdr_recursive_sanitize_text_field($_REQUEST['offset']) : 0;
	$frontend_postperpage = dtdr_option('general','frontend-postperpage');
	$post_per_page = isset($_REQUEST['post_per_page']) ? dtdr_recursive_sanitize_text_field($_REQUEST['post_per_page']) : dtdr_recursive_sanitize_text_field($frontend_postperpage);

	$function_call = (isset($_REQUEST['function_call']) && $_REQUEST['function_call'] != '') ? dtdr_recursive_sanitize_text_field($_REQUEST['function_call']) : 'dtdr_dashboard_buyer_listings_table_content';
	$output_div = (isset($_REQUEST['output_div']) && $_REQUEST['output_div'] != '') ? dtdr_recursive_sanitize_text_field($_REQUEST['output_div']) : 'dtdr-dashbord-load-buyer-listings-content';
	// Pagination script End

	$listing_singular_label = apply_filters( 'listing_label', 'singular' );
	$listing_plural_label = apply_filters( 'listing_label', 'plural' );


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

						$dtdr_buyer_package_listings = get_user_meta($user_id, 'dtdr_buyer_package_listings', true);
						$dtdr_buyer_package_listings = (is_array($dtdr_buyer_package_listings) && !empty($dtdr_buyer_package_listings)) ? $dtdr_buyer_package_listings : array ();

						$dtdr_buyer_package_listings_filtered = array_slice($dtdr_buyer_package_listings, $offset, $post_per_page, true);

						if(is_array($dtdr_buyer_package_listings_filtered) && !empty($dtdr_buyer_package_listings_filtered)) {
							$i = 1;
							foreach($dtdr_buyer_package_listings_filtered as $package_listing_id) {
								$output .= '<tr>
												<td>'.$i.'</td>
												<td>'.get_the_title($package_listing_id).'</td>
												<td>

				                					<a data-tooltip="'.sprintf( esc_html__( 'View %1$s', 'dtdr' ), $listing_singular_label ).'" href="'.get_permalink($package_listing_id).'">
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
	$dtdr_buyer_package_listings_count = count($dtdr_buyer_package_listings);
	$max_num_pages = ceil($dtdr_buyer_package_listings_count / $post_per_page);

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

?>