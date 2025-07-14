<?php

// Statistics Listing - Default Content
function dtdr_statistics_listings_content() {

	$output = '';

	$output .= '<div class="dtdr-statistics-container dtdr-statistics-listings-container">';

		$seller_singular_label = apply_filters( 'seller_label', 'singular' );

		$output .= '<span>'.sprintf( esc_html__('%1$s', 'dtdr'), $seller_singular_label ).'</span>';

	    $output .= '<select class="dtdr-statistics-listings-seller dtdr-chosen-select" name="dtdr-statistics-listings-seller" data-placeholder="'.sprintf( esc_html__('Choose %1$s ...', 'dtdr'), $seller_singular_label ).'" class="dtdr-chosen-select">';

			$output .= '<option value="-1">'.esc_html__('All', 'dtdr').'</option>';

			$sellers = get_users ( array ('role' => 'seller') );
	        if ( count( $sellers ) > 0 ) {
	            foreach ($sellers as $seller) {
					$seller_id = $seller->data->ID;
	                $output .= '<option value="' . esc_attr( $seller_id ) . '">' . esc_html( $seller->data->display_name ) . '</option>';
	            }
	        }

	    $output .= '</select>';

		$output .= '<div class="dtdr-hr-invisible"></div>';

		$output .= dtdr_generate_loader_html(true);

	    $output .= '<div class="dtdr-statistics-listings-data-container"></div>';

	$output .= '</div>';

	echo dtdr_html_output($output);

}

// Statistics Listing - Ajax Call
add_action( 'wp_ajax_dtdr_statistics_sellerwise_listings', 'dtdr_statistics_sellerwise_listings' );
add_action( 'wp_ajax_nopriv_dtdr_statistics_sellerwise_listings', 'dtdr_statistics_sellerwise_listings' );
function dtdr_statistics_sellerwise_listings() {

	// Pagination script Start

	$current_page = isset($_REQUEST['current_page']) ? dtdr_recursive_sanitize_text_field($_REQUEST['current_page']) : 1;
	$offset = isset($_REQUEST['offset']) ? dtdr_recursive_sanitize_text_field($_REQUEST['offset']) : 0;
	$backend_postperpage = dtdr_option('general','backend-postperpage');
	$post_per_page = isset($_REQUEST['post_per_page']) ? dtdr_recursive_sanitize_text_field($_REQUEST['post_per_page']) : dtdr_recursive_sanitize_text_field($backend_postperpage);

	// Pagination script End

	$seller_id = isset($_REQUEST['seller_id']) ? dtdr_recursive_sanitize_text_field($_REQUEST['seller_id']) : -1;


	$listing_plural_label = apply_filters( 'listing_label', 'plural' );

	$args = array (
				'post_type' => 'dtdr_listings',
				'offset' => $offset,
				'paged' => $current_page,
				'posts_per_page' => $post_per_page,
			);

	if($seller_id > 0) {

		$author_ids = array ($seller_id);
		$seller_incharges = get_users ( array ('role' => 'incharge', 'meta_key' => 'user_seller', 'meta_value' => $seller_id, 'fields' => 'ID') );
		$author_ids = array_merge($author_ids, $seller_incharges);

		$args['author__in'] = $author_ids;

	}


	$output = '';

	$output .= '<div class="dtdr-column dtdr-one-half first">';

		$output .= '<div class="dtdr-custom-table-wrapper">';
			$output .= '<table border="0" cellpadding="0" cellspacing="0" class="dtdr-custom-table">
							<thead>
								<tr>
									<th>'.esc_html__('#', 'dtdr').'</th>
									<th>'.esc_html($listing_plural_label).'</th>
									<th>'.esc_html__('Added By', 'dtdr').'</th>
									<th>'.esc_html__('Total Views', 'dtdr').'</th>
									<th>'.esc_html__('Average Ratings', 'dtdr').'</th>
								</tr>
							</thead>
							<tbody class="dtdr-custom-table-content">';

								$listings_query = new WP_Query( $args );

								if ( $listings_query->have_posts() ) :

									$i = 1;
									while ( $listings_query->have_posts() ) :
										$listings_query->the_post();

										$listing_id = get_the_ID();

									    $total_views = get_post_meta($listing_id, 'dtdr_total_views', true);
									    $total_views = (isset($total_views) && $total_views != '') ? $total_views : 0;

										$average_ratings = get_post_meta($listing_id, 'dtdr_average_ratings', true);
										$average_ratings = (isset($average_ratings) && $average_ratings != '') ? $average_ratings : 0;

										$author_id = get_post_field( 'post_author', $listing_id );

										$current_user = get_userdata($author_id);
										$user_roles = (array) $current_user->roles;

										$output .= '<tr>
														<td>'.$i.'</td>
														<td>'.get_the_title($listing_id).'</td>
														<td>'.get_the_author_meta( 'display_name' , $author_id ).' ( '.implode(', ', $user_roles).' ) '.'</td>
														<td>'.esc_html($total_views).'</td>
														<td>'.esc_html($average_ratings).'</td>
													</tr>';

										$i++;

									endwhile;
									wp_reset_postdata();

								else:

									$output .= '<tr>
													<td colspan="4">'.esc_html__('No Records Found!', 'dtdr').'</td>
												</tr>';

								endif;

			$output .= '</tbody></table>';
		$output .= '</div>';

		$output .= '<div class="dtdr-statistics-listings-count">'.sprintf( esc_html__( 'Total %1$s', 'dtdr' ), $listing_plural_label ).'<span>'.$listings_query->found_posts.'</span></div>';


		// Pagination script Start
		$max_num_pages = $listings_query->max_num_pages;

		$item_ids['seller_id'] = $seller_id;
		$item_ids['post_per_page'] = $post_per_page;

		$output .= dtdr_ajax_pagination($max_num_pages, $current_page, 'dtdr_statistics_sellerwise_listings', 'dtdr-statistics-listings-data-container', $item_ids);
		// Pagination script End

	$output .= '</div>';
	$output .= '<div class="dtdr-column dtdr-one-half">';

		$output .= '<div class="dtdr-statistics-listings-inner-data-container"></div>';

	$output .= '</div>';

	echo dtdr_html_output($output);

	wp_die();

}

// Statistics Sellers - Default Content
function dtdr_statistics_sellers_content() {

	$output = '';

	$output .= '<div class="dtdr-statistics-container dtdr-statistics-sellers-container">';

		$output .= dtdr_generate_loader_html(true);

	    $output .= '<div class="dtdr-statistics-sellers-data-container"></div>';

	$output .= '</div>';

	echo dtdr_html_output($output);

}

// Statistics Sellers - Ajax Call
add_action( 'wp_ajax_dtdr_statistics_sellers', 'dtdr_statistics_sellers' );
add_action( 'wp_ajax_nopriv_dtdr_statistics_sellers', 'dtdr_statistics_sellers' );
function dtdr_statistics_sellers() {

	// Pagination script Start

	$ajax_call = (isset($_REQUEST['ajax_call']) && $_REQUEST['ajax_call'] == true) ? true : false;
	$current_page = isset($_REQUEST['current_page']) ? dtdr_recursive_sanitize_text_field($_REQUEST['current_page']) : 1;
	$offset = isset($_REQUEST['offset']) ? dtdr_recursive_sanitize_text_field($_REQUEST['offset']) : 0;
	$backend_postperpage = dtdr_option('general','backend-postperpage');
	$post_per_page = isset($_REQUEST['post_per_page']) ? dtdr_recursive_sanitize_text_field($_REQUEST['post_per_page']) : dtdr_recursive_sanitize_text_field($backend_postperpage);

	// Pagination script End


	$listing_plural_label = apply_filters( 'listing_label', 'plural' );
	$seller_plural_label = apply_filters( 'seller_label', 'plural' );
	$seller_singular_label = apply_filters( 'seller_label', 'singular' );
	$incharge_plural_label = apply_filters( 'incharge_label', 'plural' );

	$output = '';

	$output .= '<div class="dtdr-column dtdr-two-third first">';

		$output .= '<div class="dtdr-custom-table-wrapper">';
			$output .= '<table border="0" cellpadding="0" cellspacing="0" class="dtdr-custom-table">
							<thead>
								<tr>
									<th>'.esc_html__('#', 'dtdr').'</th>
									<th>'.esc_html($seller_plural_label).'</th>
									<th>'.sprintf( esc_html__( '%1$s Status', 'dtdr' ), $seller_singular_label ).'</th>
									<th>'.esc_html__('Package Status', 'dtdr').'</th>
									<th>'.esc_html__('Active Package', 'dtdr').'</th>
									<th>'.esc_html__('Purchased Date', 'dtdr').'</th>
									<th>'.esc_html__('Expiry Date', 'dtdr').'</th>
									<th>'.sprintf( esc_html__( 'Total %1$s', 'dtdr' ), $incharge_plural_label ).'</th>
									<th>'.sprintf( esc_html__( 'Total %1$s', 'dtdr' ), $listing_plural_label ).'</th>
								</tr>
							</thead>
							<tbody class="dtdr-custom-table-content">';

								$sellers = get_users ( array (
														'role' => 'seller',
														'offset' => $offset,
														'paged' => $current_page,
														'number' => $post_per_page,
													) );

								$i = 1;
								foreach ( $sellers as $seller ) {
									setup_postdata( $seller );

									$seller_id = $seller->data->ID;

									$dtdr_user_status = get_the_author_meta('dtdr_user_status', $seller_id);
									$dtdr_user_status = (isset($dtdr_user_status) && $dtdr_user_status != '') ? $dtdr_user_status : 'disabled';
									if ( $dtdr_user_status == 'disabled' ) {
										$dtdr_user_status_html = esc_html__( 'Disabled', 'dtdr' );
									} else if ( $dtdr_user_status == 'active' ) {
										$dtdr_user_status_html = esc_html__( 'Active', 'dtdr' );
									} else if ( $dtdr_user_status == 'waitingforapproval' ) {
										$dtdr_user_status_html = esc_html__( 'Waiting For Approval', 'dtdr' );
									}

									// Package Status
									$dtdr_seller_active_package_id = get_user_meta($seller_id, 'dtdr_seller_active_package_id', true);

									$package_status = $dtdr_seller_active_package_purchased_date = $dtdr_seller_active_package_expiry_date = $active_package_title = '-';
									if(dtdr_check_user_seller_package_is_active($seller_id, $dtdr_seller_active_package_id)) {

										$dtdr_seller_active_package_purchased_date = get_user_meta($seller_id, 'dtdr_seller_active_package_purchased_date', true);
										$dtdr_seller_active_package_purchased_date = ($dtdr_seller_active_package_purchased_date != '') ? date(get_option('date_format'), (int)$dtdr_seller_active_package_purchased_date) : '-';

										$dtdr_seller_active_package_expiry_date    = get_user_meta($seller_id, 'dtdr_seller_active_package_expiry_date', true);
										if($dtdr_seller_active_package_expiry_date == 'LT') {
											$dtdr_seller_active_package_expiry_date = esc_html__('Lifetime', 'dtdr');
										} else if($dtdr_seller_active_package_expiry_date != '') {
											$dtdr_seller_active_package_expiry_date = date(get_option('date_format'), (int)$dtdr_seller_active_package_expiry_date);
										} else {
											$dtdr_seller_active_package_expiry_date = '-';
										}

										$active_package_title = ($dtdr_seller_active_package_id != '') ? get_the_title($dtdr_seller_active_package_id) : '-';

										$package_status = esc_html__('Active', 'dtdr');

									}

									// Incharges
									$author_ids = array ($seller_id);
									$seller_incharges = get_users ( array ('role' => 'incharge', 'meta_key' => 'user_seller', 'meta_value' => $seller_id, 'fields' => 'ID') );
									$author_ids = array_merge($author_ids, $seller_incharges);

									// Listings
									$post_cnt = 0;
									foreach($author_ids as $author_id) {

										$total_post_args = array (
																'posts_per_page' => -1,
																'post_type'=> 'dtdr_listings',
																'author'=> $author_id,
																'post_status' => array ( 'any' )
															);
										$total_post_listings = get_posts( $total_post_args );
										wp_reset_postdata();
										$listings_post_count = count($total_post_listings);

										$post_cnt = $post_cnt + $listings_post_count;
									}

									$output .= '<tr>
													<td>'.$i.'</td>
													<td>'.get_the_author_meta('display_name', $seller_id).'</td>
													<td>'.$dtdr_user_status_html.'</td>
													<td>'.$package_status.'</td>
													<td>'.$active_package_title.'</td>
													<td>'.$dtdr_seller_active_package_purchased_date.'</td>
													<td>'.$dtdr_seller_active_package_expiry_date.'</td>
													<td>';

														$output .= count($seller_incharges);
														if($seller_incharges > 0) {
															$output .= '<a href="#" class="custom-button-style dtdr-statistics-seller-incharges" data-sellerid="'.esc_html($seller_id).'">'.esc_html__('View Details', 'dtdr').'</a>';
														}

													$output .= '</td><td>';

														$output .= $post_cnt;
														if($post_cnt > 0) {
															$output .='<a href="#" class="custom-button-style dtdr-statistics-seller-listings" data-sellerid="'.esc_html($seller_id).'">'.esc_html__('View Details', 'dtdr').'</a>';
														}

										$output .= '</td>';
									$output .= '</tr>';

									$i++;

								}

			$output .= '</tbody></table>';
		$output .= '</div>';


		// Pagination script Start
		$total_users_args = array (
								'role' => 'seller',
							);
		$total_users = get_users( $total_users_args );

		$total_users_count = count($total_users);
		$max_num_pages = ceil($total_users_count / $post_per_page);


		$item_ids['post_per_page'] = $post_per_page;

		$output .= dtdr_ajax_pagination($max_num_pages, $current_page, 'dtdr_statistics_sellers', 'dtdr-statistics-sellers-data-container', $item_ids);
		// Pagination script End

	$output .= '</div>';
	$output .= '<div class="dtdr-column dtdr-one-third">';

		$output .= '<div class="dtdr-statistics-sellers-inner-data-container"></div>';

	$output .= '</div>';

	echo dtdr_html_output($output);

	wp_die();

}

// Statistics Sellers - Incharges
add_action( 'wp_ajax_dtdr_statistics_seller_incharges', 'dtdr_statistics_seller_incharges' );
add_action( 'wp_ajax_nopriv_dtdr_statistics_seller_incharges', 'dtdr_statistics_seller_incharges' );
function dtdr_statistics_seller_incharges() {

	$seller_id = isset($_REQUEST['seller_id']) ? dtdr_recursive_sanitize_text_field($_REQUEST['seller_id']) : -1;
	$seller_incharges = get_users ( array ('role' => 'incharge', 'meta_key' => 'user_seller', 'meta_value' => $seller_id, 'fields' => 'ID') );

	$listing_plural_label = apply_filters( 'listing_label', 'plural' );
	$incharge_singular_label = apply_filters( 'incharge_label', 'singular' );
	$incharge_plural_label = apply_filters( 'incharge_label', 'plural' );

	$output = '';

	$output .= '<div class="dtdr-custom-table-wrapper">';

		$output .= '<table border="0" cellpadding="0" cellspacing="0" class="dtdr-custom-table">
						<thead>
							<tr>
								<th>'.esc_html__('#', 'dtdr').'</th>
								<th>'.sprintf( esc_html__( '%1$s', 'dtdr' ), $incharge_plural_label ).'</th>
								<th>'.sprintf( esc_html__( '%1$s Status', 'dtdr' ), $incharge_singular_label ).'</th>
								<th>'.sprintf( esc_html__( 'Total %1$s', 'dtdr' ), $listing_plural_label ).'</th>
								<th>'.sprintf( esc_html__( 'Total %1$s Published', 'dtdr' ), $listing_plural_label ).'</th>
							</tr>
						</thead>
						<tbody class="dtdr-custom-table-content">';

							$incharges = get_users ( array (
													'role' => 'incharge',
													'include' => $seller_incharges,
												) );

							$i = 1;
							foreach ( $incharges as $incharge ) {
								setup_postdata( $incharge );

								$incharge_id = $incharge->data->ID;

								$dtdr_user_status = get_the_author_meta('dtdr_user_status', $incharge_id);
								$dtdr_user_status = (isset($dtdr_user_status) && $dtdr_user_status != '') ? $dtdr_user_status : 'disabled';
								if ( $dtdr_user_status == 'disabled' ) {
									$dtdr_user_status_html = esc_html__( 'Disabled', 'dtdr' );
								} else if ( $dtdr_user_status == 'active' ) {
									$dtdr_user_status_html = esc_html__( 'Active', 'dtdr' );
								} else if ( $dtdr_user_status == 'waitingforapproval' ) {
									$dtdr_user_status_html = esc_html__( 'Waiting For Approval', 'dtdr' );
								}

								$total_post_args = array (
														'posts_per_page' => -1,
														'post_type'=> 'dtdr_listings',
														'author'=> $incharge_id,
														'post_status' => array ( 'any' )
													);
								$total_post_listings = get_posts( $total_post_args );
								wp_reset_postdata();
								$listings_post_count = count($total_post_listings);

								$output .= '<tr>
												<td>'.$i.'</td>
												<td>'.get_the_author_meta('display_name', $incharge_id).'</td>
												<td>'.$dtdr_user_status_html.'</td>
												<td>'.esc_html($listings_post_count).'</td>
												<td>'.count_user_posts($incharge_id , 'dtdr_listings').'</td>
											</tr>';

								$i++;

							}

		$output .= '</tbody></table>';

	$output .= '</div>';

	echo dtdr_html_output($output);

	wp_die();

}

// Statistics Sellers - Listings
add_action( 'wp_ajax_dtdr_statistics_seller_listings', 'dtdr_statistics_seller_listings' );
add_action( 'wp_ajax_nopriv_dtdr_statistics_seller_listings', 'dtdr_statistics_seller_listings' );
function dtdr_statistics_seller_listings() {

	$seller_id = isset($_REQUEST['seller_id']) ? dtdr_recursive_sanitize_text_field($_REQUEST['seller_id']) : -1;

	$author_ids = array ($seller_id);
	$seller_incharges = get_users ( array ('role' => 'incharge', 'meta_key' => 'user_seller', 'meta_value' => $seller_id, 'fields' => 'ID') );
	$author_ids = array_merge($author_ids, $seller_incharges);


	$listing_plural_label = apply_filters( 'listing_label', 'plural' );


	$output = '';

	$output .= '<div class="dtdr-custom-table-wrapper">';
		$output .= '<table border="0" cellpadding="0" cellspacing="0" class="dtdr-custom-table">
						<thead>
							<tr>
								<th>'.esc_html__('#', 'dtdr').'</th>
								<th>'.esc_html($listing_plural_label).'</th>
								<th>'.esc_html__('Status', 'dtdr').'</th>
								<th>'.esc_html__('Added By', 'dtdr').'</th>
							</tr>
						</thead>
						<tbody class="dtdr-custom-table-content">';

							$args = array (
										'post_type' => 'dtdr_listings',
										'author__in' => $author_ids
									);

							$seller_listings_query = new WP_Query( $args );

							if ( $seller_listings_query->have_posts() ) :

								$i = 1;
								while ( $seller_listings_query->have_posts() ) :
									$seller_listings_query->the_post();

									$listing_id = get_the_ID();
									$author_id = get_post_field( 'post_author', $listing_id );

									$current_user = get_userdata($author_id);
									$user_roles = (array) $current_user->roles;

									$status = get_post_status($listing_id);

									$listing_status = '';
									if($status == 'expired') {
										$listing_status = esc_html__('Expired', 'dtdr');
									} else if($status == 'waitingforapproval') {
										$listing_status = esc_html__('Waiting For Approval', 'dtdr');
									} else if($status == 'pending') {
										$listing_status = esc_html__('Pending', 'dtdr');
									} else if($status == 'publish') {
										$listing_status = esc_html__('Published', 'dtdr');
									}

									$output .= '<tr>
													<td>'.$i.'</td>
													<td>'.get_the_title($listing_id).'</td>
													<td>'.esc_html($listing_status).'</td>
													<td>'.get_the_author_meta( 'display_name' , $author_id ).' ( '.implode(', ', $user_roles).' ) '.'</td>
												</tr>';

									$i++;

								endwhile;
								wp_reset_postdata();

							endif;


	$output .= '</tbody></table>';

	echo dtdr_html_output($output);

	wp_die();

}

// Statistics Packages - Default Content
function dtdr_statistics_packages_content() {

	$output = '';

	$output .= '<div class="dtdr-statistics-container dtdr-statistics-packages-container">';

		$output .= dtdr_generate_loader_html(true);

	    $output .= '<div class="dtdr-statistics-packages-data-container"></div>';

	$output .= '</div>';

	echo dtdr_html_output($output);

}

// Statistics Packages - Ajax Call
add_action( 'wp_ajax_dtdr_statistics_packages', 'dtdr_statistics_packages' );
add_action( 'wp_ajax_nopriv_dtdr_statistics_packages', 'dtdr_statistics_packages' );
function dtdr_statistics_packages() {

	// Pagination script Start

	$ajax_call = (isset($_REQUEST['ajax_call']) && $_REQUEST['ajax_call'] == true) ? true : false;
	$current_page = isset($_REQUEST['current_page']) ? dtdr_recursive_sanitize_text_field($_REQUEST['current_page']) : 1;
	$offset = isset($_REQUEST['offset']) ? dtdr_recursive_sanitize_text_field($_REQUEST['offset']) : 0;
	$backend_postperpage = dtdr_option('general','backend-postperpage');
	$post_per_page = isset($_REQUEST['post_per_page']) ? dtdr_recursive_sanitize_text_field($_REQUEST['post_per_page']) : dtdr_recursive_sanitize_text_field($backend_postperpage);

	// Pagination script End


	$listing_plural_label = apply_filters( 'listing_label', 'plural' );
	$seller_plural_label = apply_filters( 'seller_label', 'plural' );

	$output = '';

	$output .= '<div class="dtdr-custom-table-wrapper">';

		$output .= '<table border="0" cellpadding="0" cellspacing="0" class="dtdr-custom-table">
						<thead>
							<tr>
								<th>'.esc_html__('#', 'dtdr').'</th>
								<th>'.esc_html__('Packages', 'dtdr').'</th>
								<th>'.esc_html__('Total Purchases', 'dtdr' ).'</th>
							</tr>
						</thead>
						<tbody class="dtdr-custom-table-content">';

							$args = array (
										'post_type' => 'dtdr_packages',
										'offset' => $offset,
										'paged' => $current_page,
										'posts_per_page' => $post_per_page,
									);

							$packages_query = new WP_Query( $args );

							if ( $packages_query->have_posts() ) :

								$i = 1;
								while ( $packages_query->have_posts() ) :
									$packages_query->the_post();

									$package_id = get_the_ID();

									$purchased_users = get_post_meta($package_id, 'purchased_users', true);
									$purchased_users = (is_array($purchased_users) && !empty($purchased_users)) ? $purchased_users : array ();

									$output .= '<tr>
													<td>'.$i.'</td>
													<td>'.get_the_title($package_id).'</td>
													<td>';

														$output .= count($purchased_users);
														if(count($purchased_users) > 0) {
															$output .='<a href="#" class="custom-button-style dtdr-statistics-package-purchases" data-packageid="'.esc_html($package_id).'">'.esc_html__('View Details', 'dtdr').'</a>';
														}

										$output .= '</td>';
									$output .= '</tr>';

									$i++;

								endwhile;
								wp_reset_postdata();

							else:

								$output .= '<tr>
												<td colspan="4">'.esc_html__('No Records Found!', 'dtdr').'</td>
											</tr>';

							endif;

		$output .= '</tbody></table>';

		$output .= '<div class="dtdr-statistics-packages-count">'.esc_html__( 'Total Packages', 'dtdr' ).'<span>'.$packages_query->found_posts.'</span></div>';

		// Pagination script Start
		$max_num_pages = $packages_query->max_num_pages;

		$item_ids['post_per_page'] = $post_per_page;

		$output .= dtdr_ajax_pagination($max_num_pages, $current_page, 'dtdr_statistics_packages', 'dtdr-statistics-packages-data-container', $item_ids);
		// Pagination script End

	$output .= '</div>';

	$output .= '<div class="dtdr-statistics-packages-inner-data-container"></div>';


	echo dtdr_html_output($output);

	wp_die();

}

// Statistics Packages - Purchased Users
add_action( 'wp_ajax_dtdr_statistics_packages_purchases_user_details', 'dtdr_statistics_packages_purchases_user_details' );
add_action( 'wp_ajax_nopriv_dtdr_statistics_packages_purchases_user_details', 'dtdr_statistics_packages_purchases_user_details' );
function dtdr_statistics_packages_purchases_user_details() {


	$package_id = isset($_REQUEST['package_id']) ? dtdr_recursive_sanitize_text_field($_REQUEST['package_id']) : -1;

	$listing_plural_label = apply_filters( 'listing_label', 'plural' );
	$seller_singular_label = apply_filters( 'seller_label', 'singular' );

	$output = '';

	$output .= '<div class="dtdr-custom-table-wrapper">';
		$output .= '<table border="0" cellpadding="0" cellspacing="0" class="dtdr-custom-table">
						<thead>
							<tr>
								<th>'.esc_html__('#', 'dtdr').'</th>
								<th>'.sprintf( esc_html__('%1$s', 'dtdr'), $seller_singular_label ).'</th>
								<th>'.esc_html__('Status', 'dtdr').'</th>
							</tr>
						</thead>
						<tbody class="dtdr-custom-table-content">';

							if($package_id > 0) {

								$purchased_users = get_post_meta($package_id, 'purchased_users', true);

								if(is_array($purchased_users) && !empty($purchased_users)) {

									$i = 1;

									foreach($purchased_users as $purchased_user_key => $purchased_user) {

										$package_status = esc_html__('Expired', 'dtdr');
										if(dtdr_check_user_seller_package_is_active($purchased_user_key, $package_id)) {
											$package_status = esc_html__('Active', 'dtdr');
										}

										$output .= '<tr>
														<td>'.$i.'</td>
														<td>'.get_the_author_meta('display_name', $purchased_user_key).'</td>
														<td>'.$package_status.'</td>
													</tr>';

										$i++;

									}

								}

							}

		$output .= '</tbody></table>';
	$output .= '</div>';

	echo dtdr_html_output($output);

	wp_die();

}
?>