<?php

// Statistics Listing - Default Content
function dtsl_statistics_listings_content() {

	$output = '';

	$output .= '<div class="dtsl-statistics-container dtsl-statistics-listings-container">';

		$seller_singular_label = apply_filters( 'dt_sl_seller_label', 'singular' );

		$output .= '<span>'.sprintf( esc_html__('%1$s', 'dtsl'), $seller_singular_label ).'</span>';

	    $output .= '<select class="dtsl-statistics-listings-seller dtsl-chosen-select" name="dtsl-statistics-listings-seller" data-placeholder="'.sprintf( esc_html__('Choose %1$s ...', 'dtsl'), $seller_singular_label ).'" class="dtsl-chosen-select">';

			$output .= '<option value="-1">'.esc_html__('All', 'dtsl').'</option>';

			$sellers = get_users ( array ('role' => 'seller') );
	        if ( count( $sellers ) > 0 ) {
	            foreach ($sellers as $seller) {
					$seller_id = $seller->data->ID;
	                $output .= '<option value="' . esc_attr( $seller_id ) . '">' . esc_html( $seller->data->display_name ) . '</option>';
	            }
	        }

	    $output .= '</select>';

		$output .= '<div class="dtsl-hr-invisible"></div>';

		$output .= dtsl_generate_loader_html(true);

	    $output .= '<div class="dtsl-statistics-listings-data-container"></div>';

	$output .= '</div>';

	echo dtsl_html_output($output);

}

// Statistics Listing - Ajax Call
add_action( 'wp_ajax_dtsl_statistics_sellerwise_listings', 'dtsl_statistics_sellerwise_listings' );
add_action( 'wp_ajax_nopriv_dtsl_statistics_sellerwise_listings', 'dtsl_statistics_sellerwise_listings' );
function dtsl_statistics_sellerwise_listings() {

	// Pagination script Start

	$current_page = isset($_REQUEST['current_page']) ? dtsl_recursive_sanitize_text_field($_REQUEST['current_page']) : 1;
	$offset = isset($_REQUEST['offset']) ? dtsl_recursive_sanitize_text_field($_REQUEST['offset']) : 0;
	$backend_postperpage = dtsl_option('general','backend-postperpage');
	$post_per_page = isset($_REQUEST['post_per_page']) ? dtsl_recursive_sanitize_text_field($_REQUEST['post_per_page']) : dtsl_recursive_sanitize_text_field($backend_postperpage);

	// Pagination script End

	$seller_id = isset($_REQUEST['seller_id']) ? dtsl_recursive_sanitize_text_field($_REQUEST['seller_id']) : -1;


	$listing_plural_label = apply_filters( 'dt_sl_listing_label', 'plural' );

	$args = array (
				'post_type' => 'dtsl_listings',
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

	$output .= '<div class="dtsl-column dtsl-one-half first">';

		$output .= '<div class="dtsl-custom-table-wrapper">';
			$output .= '<table border="0" cellpadding="0" cellspacing="0" class="dtsl-custom-table">
							<thead>
								<tr>
									<th>'.esc_html__('#', 'dtsl').'</th>
									<th>'.esc_html($listing_plural_label).'</th>
									<th>'.esc_html__('Added By', 'dtsl').'</th>
									<th>'.esc_html__('Total Views', 'dtsl').'</th>
									<th>'.esc_html__('Average Ratings', 'dtsl').'</th>
								</tr>
							</thead>
							<tbody class="dtsl-custom-table-content">';

								$listings_query = new WP_Query( $args );

								if ( $listings_query->have_posts() ) :

									$i = 1;
									while ( $listings_query->have_posts() ) :
										$listings_query->the_post();

										$listing_id = get_the_ID();

									    $total_views = get_post_meta($listing_id, 'dtsl_total_views', true);
									    $total_views = (isset($total_views) && $total_views != '') ? $total_views : 0;

										$average_ratings = get_post_meta($listing_id, 'dtsl_average_ratings', true);
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
													<td colspan="4">'.esc_html__('No Records Found!', 'dtsl').'</td>
												</tr>';

								endif;

			$output .= '</tbody></table>';
		$output .= '</div>';

		$output .= '<div class="dtsl-statistics-listings-count">'.sprintf( esc_html__( 'Total %1$s', 'dtsl' ), $listing_plural_label ).'<span>'.$listings_query->found_posts.'</span></div>';


		// Pagination script Start
		$max_num_pages = $listings_query->max_num_pages;

		$item_ids['seller_id'] = $seller_id;
		$item_ids['post_per_page'] = $post_per_page;

		$output .= dtsl_ajax_pagination($max_num_pages, $current_page, 'dtsl_statistics_sellerwise_listings', 'dtsl-statistics-listings-data-container', $item_ids);
		// Pagination script End

	$output .= '</div>';
	$output .= '<div class="dtsl-column dtsl-one-half">';

		$output .= '<div class="dtsl-statistics-listings-inner-data-container"></div>';

	$output .= '</div>';

	echo dtsl_html_output($output);

	wp_die();

}

// Statistics Sellers - Default Content
function dtsl_statistics_sellers_content() {

	$output = '';

	$output .= '<div class="dtsl-statistics-container dtsl-statistics-sellers-container">';

		$output .= dtsl_generate_loader_html(true);

	    $output .= '<div class="dtsl-statistics-sellers-data-container"></div>';

	$output .= '</div>';

	echo dtsl_html_output($output);

}

// Statistics Sellers - Ajax Call
add_action( 'wp_ajax_dtsl_statistics_sellers', 'dtsl_statistics_sellers' );
add_action( 'wp_ajax_nopriv_dtsl_statistics_sellers', 'dtsl_statistics_sellers' );
function dtsl_statistics_sellers() {

	// Pagination script Start

	$ajax_call = (isset($_REQUEST['ajax_call']) && $_REQUEST['ajax_call'] == true) ? true : false;
	$current_page = isset($_REQUEST['current_page']) ? dtsl_recursive_sanitize_text_field($_REQUEST['current_page']) : 1;
	$offset = isset($_REQUEST['offset']) ? dtsl_recursive_sanitize_text_field($_REQUEST['offset']) : 0;
	$backend_postperpage = dtsl_option('general','backend-postperpage');
	$post_per_page = isset($_REQUEST['post_per_page']) ? dtsl_recursive_sanitize_text_field($_REQUEST['post_per_page']) : dtsl_recursive_sanitize_text_field($backend_postperpage);

	// Pagination script End


	$listing_plural_label = apply_filters( 'dt_sl_listing_label', 'plural' );
	$seller_plural_label = apply_filters( 'dt_sl_seller_label', 'plural' );
	$seller_singular_label = apply_filters( 'dt_sl_seller_label', 'singular' );
	$incharge_plural_label = apply_filters( 'dt_sl_incharge_label', 'plural' );

	$output = '';

	$output .= '<div class="dtsl-column dtsl-two-third first">';

		$output .= '<div class="dtsl-custom-table-wrapper">';
			$output .= '<table border="0" cellpadding="0" cellspacing="0" class="dtsl-custom-table">
							<thead>
								<tr>
									<th>'.esc_html__('#', 'dtsl').'</th>
									<th>'.esc_html($seller_plural_label).'</th>
									<th>'.sprintf( esc_html__( '%1$s Status', 'dtsl' ), $seller_singular_label ).'</th>
									<th>'.esc_html__('Package Status', 'dtsl').'</th>
									<th>'.esc_html__('Active Package', 'dtsl').'</th>
									<th>'.esc_html__('Purchased Date', 'dtsl').'</th>
									<th>'.esc_html__('Expiry Date', 'dtsl').'</th>
									<th>'.sprintf( esc_html__( 'Total %1$s', 'dtsl' ), $incharge_plural_label ).'</th>
									<th>'.sprintf( esc_html__( 'Total %1$s', 'dtsl' ), $listing_plural_label ).'</th>
								</tr>
							</thead>
							<tbody class="dtsl-custom-table-content">';

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

									$dtsl_user_status = get_the_author_meta('dtsl_user_status', $seller_id);
									$dtsl_user_status = (isset($dtsl_user_status) && $dtsl_user_status != '') ? $dtsl_user_status : 'disabled';
									if ( $dtsl_user_status == 'disabled' ) {
										$dtsl_user_status_html = esc_html__( 'Disabled', 'dtsl' );
									} else if ( $dtsl_user_status == 'active' ) {
										$dtsl_user_status_html = esc_html__( 'Active', 'dtsl' );
									} else if ( $dtsl_user_status == 'waitingforapproval' ) {
										$dtsl_user_status_html = esc_html__( 'Waiting For Approval', 'dtsl' );
									}

									// Package Status
									$dtsl_seller_active_package_id = get_user_meta($seller_id, 'dtsl_seller_active_package_id', true);

									$package_status = $dtsl_seller_active_package_purchased_date = $dtsl_seller_active_package_expiry_date = $active_package_title = '-';
									if(dtsl_check_user_seller_package_is_active($seller_id, $dtsl_seller_active_package_id)) {

										$dtsl_seller_active_package_purchased_date = get_user_meta($seller_id, 'dtsl_seller_active_package_purchased_date', true);
										$dtsl_seller_active_package_purchased_date = ($dtsl_seller_active_package_purchased_date != '') ? date(get_option('date_format'), (int)$dtsl_seller_active_package_purchased_date) : '-';

										$dtsl_seller_active_package_expiry_date    = get_user_meta($seller_id, 'dtsl_seller_active_package_expiry_date', true);
										if($dtsl_seller_active_package_expiry_date == 'LT') {
											$dtsl_seller_active_package_expiry_date = esc_html__('Lifetime', 'dtsl');
										} else if($dtsl_seller_active_package_expiry_date != '') {
											$dtsl_seller_active_package_expiry_date = date(get_option('date_format'), (int)$dtsl_seller_active_package_expiry_date);
										} else {
											$dtsl_seller_active_package_expiry_date = '-';
										}

										$active_package_title = ($dtsl_seller_active_package_id != '') ? get_the_title($dtsl_seller_active_package_id) : '-';

										$package_status = esc_html__('Active', 'dtsl');

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
																'post_type'=> 'dtsl_listings',
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
													<td>'.$dtsl_user_status_html.'</td>
													<td>'.$package_status.'</td>
													<td>'.$active_package_title.'</td>
													<td>'.$dtsl_seller_active_package_purchased_date.'</td>
													<td>'.$dtsl_seller_active_package_expiry_date.'</td>
													<td>';

														$output .= count($seller_incharges);
														if($seller_incharges > 0) {
															$output .= '<a href="#" class="custom-button-style dtsl-statistics-seller-incharges" data-sellerid="'.esc_html($seller_id).'">'.esc_html__('View Details', 'dtsl').'</a>';
														}

													$output .= '</td><td>';

														$output .= $post_cnt;
														if($post_cnt > 0) {
															$output .='<a href="#" class="custom-button-style dtsl-statistics-seller-listings" data-sellerid="'.esc_html($seller_id).'">'.esc_html__('View Details', 'dtsl').'</a>';
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

		$output .= dtsl_ajax_pagination($max_num_pages, $current_page, 'dtsl_statistics_sellers', 'dtsl-statistics-sellers-data-container', $item_ids);
		// Pagination script End

	$output .= '</div>';
	$output .= '<div class="dtsl-column dtsl-one-third">';

		$output .= '<div class="dtsl-statistics-sellers-inner-data-container"></div>';

	$output .= '</div>';

	echo dtsl_html_output($output);

	wp_die();

}

// Statistics Sellers - Incharges
add_action( 'wp_ajax_dtsl_statistics_seller_incharges', 'dtsl_statistics_seller_incharges' );
add_action( 'wp_ajax_nopriv_dtsl_statistics_seller_incharges', 'dtsl_statistics_seller_incharges' );
function dtsl_statistics_seller_incharges() {

	$seller_id = isset($_REQUEST['seller_id']) ? dtsl_recursive_sanitize_text_field($_REQUEST['seller_id']) : -1;
	$seller_incharges = get_users ( array ('role' => 'incharge', 'meta_key' => 'user_seller', 'meta_value' => $seller_id, 'fields' => 'ID') );

	$listing_plural_label = apply_filters( 'dt_sl_listing_label', 'plural' );
	$incharge_singular_label = apply_filters( 'dt_sl_incharge_label', 'singular' );
	$incharge_plural_label = apply_filters( 'dt_sl_incharge_label', 'plural' );

	$output = '';

	$output .= '<div class="dtsl-custom-table-wrapper">';

		$output .= '<table border="0" cellpadding="0" cellspacing="0" class="dtsl-custom-table">
						<thead>
							<tr>
								<th>'.esc_html__('#', 'dtsl').'</th>
								<th>'.sprintf( esc_html__( '%1$s', 'dtsl' ), $incharge_plural_label ).'</th>
								<th>'.sprintf( esc_html__( '%1$s Status', 'dtsl' ), $incharge_singular_label ).'</th>
								<th>'.sprintf( esc_html__( 'Total %1$s', 'dtsl' ), $listing_plural_label ).'</th>
								<th>'.sprintf( esc_html__( 'Total %1$s Published', 'dtsl' ), $listing_plural_label ).'</th>
							</tr>
						</thead>
						<tbody class="dtsl-custom-table-content">';

							$incharges = get_users ( array (
													'role' => 'incharge',
													'include' => $seller_incharges,
												) );

							$i = 1;
							foreach ( $incharges as $incharge ) {
								setup_postdata( $incharge );

								$incharge_id = $incharge->data->ID;

								$dtsl_user_status = get_the_author_meta('dtsl_user_status', $incharge_id);
								$dtsl_user_status = (isset($dtsl_user_status) && $dtsl_user_status != '') ? $dtsl_user_status : 'disabled';
								if ( $dtsl_user_status == 'disabled' ) {
									$dtsl_user_status_html = esc_html__( 'Disabled', 'dtsl' );
								} else if ( $dtsl_user_status == 'active' ) {
									$dtsl_user_status_html = esc_html__( 'Active', 'dtsl' );
								} else if ( $dtsl_user_status == 'waitingforapproval' ) {
									$dtsl_user_status_html = esc_html__( 'Waiting For Approval', 'dtsl' );
								}

								$total_post_args = array (
														'posts_per_page' => -1,
														'post_type'=> 'dtsl_listings',
														'author'=> $incharge_id,
														'post_status' => array ( 'any' )
													);
								$total_post_listings = get_posts( $total_post_args );
								wp_reset_postdata();
								$listings_post_count = count($total_post_listings);

								$output .= '<tr>
												<td>'.$i.'</td>
												<td>'.get_the_author_meta('display_name', $incharge_id).'</td>
												<td>'.$dtsl_user_status_html.'</td>
												<td>'.esc_html($listings_post_count).'</td>
												<td>'.count_user_posts($incharge_id , 'dtsl_listings').'</td>
											</tr>';

								$i++;

							}

		$output .= '</tbody></table>';

	$output .= '</div>';

	echo dtsl_html_output($output);

	wp_die();

}

// Statistics Sellers - Listings
add_action( 'wp_ajax_dtsl_statistics_seller_listings', 'dtsl_statistics_seller_listings' );
add_action( 'wp_ajax_nopriv_dtsl_statistics_seller_listings', 'dtsl_statistics_seller_listings' );
function dtsl_statistics_seller_listings() {

	$seller_id = isset($_REQUEST['seller_id']) ? dtsl_recursive_sanitize_text_field($_REQUEST['seller_id']) : -1;

	$author_ids = array ($seller_id);
	$seller_incharges = get_users ( array ('role' => 'incharge', 'meta_key' => 'user_seller', 'meta_value' => $seller_id, 'fields' => 'ID') );
	$author_ids = array_merge($author_ids, $seller_incharges);


	$listing_plural_label = apply_filters( 'dt_sl_listing_label', 'plural' );


	$output = '';

	$output .= '<div class="dtsl-custom-table-wrapper">';
		$output .= '<table border="0" cellpadding="0" cellspacing="0" class="dtsl-custom-table">
						<thead>
							<tr>
								<th>'.esc_html__('#', 'dtsl').'</th>
								<th>'.esc_html($listing_plural_label).'</th>
								<th>'.esc_html__('Status', 'dtsl').'</th>
								<th>'.esc_html__('Added By', 'dtsl').'</th>
							</tr>
						</thead>
						<tbody class="dtsl-custom-table-content">';

							$args = array (
										'post_type' => 'dtsl_listings',
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
										$listing_status = esc_html__('Expired', 'dtsl');
									} else if($status == 'waitingforapproval') {
										$listing_status = esc_html__('Waiting For Approval', 'dtsl');
									} else if($status == 'pending') {
										$listing_status = esc_html__('Pending', 'dtsl');
									} else if($status == 'publish') {
										$listing_status = esc_html__('Published', 'dtsl');
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

	echo dtsl_html_output($output);

	wp_die();

}

// Statistics Packages - Default Content
function dtsl_statistics_packages_content() {

	$output = '';

	$output .= '<div class="dtsl-statistics-container dtsl-statistics-packages-container">';

		$output .= dtsl_generate_loader_html(true);

	    $output .= '<div class="dtsl-statistics-packages-data-container"></div>';

	$output .= '</div>';

	echo dtsl_html_output($output);

}

// Statistics Packages - Ajax Call
add_action( 'wp_ajax_dtsl_statistics_packages', 'dtsl_statistics_packages' );
add_action( 'wp_ajax_nopriv_dtsl_statistics_packages', 'dtsl_statistics_packages' );
function dtsl_statistics_packages() {

	// Pagination script Start

	$ajax_call = (isset($_REQUEST['ajax_call']) && $_REQUEST['ajax_call'] == true) ? true : false;
	$current_page = isset($_REQUEST['current_page']) ? dtsl_recursive_sanitize_text_field($_REQUEST['current_page']) : 1;
	$offset = isset($_REQUEST['offset']) ? dtsl_recursive_sanitize_text_field($_REQUEST['offset']) : 0;
	$backend_postperpage = dtsl_option('general','backend-postperpage');
	$post_per_page = isset($_REQUEST['post_per_page']) ? dtsl_recursive_sanitize_text_field($_REQUEST['post_per_page']) : dtsl_recursive_sanitize_text_field($backend_postperpage);

	// Pagination script End


	$listing_plural_label = apply_filters( 'dt_sl_listing_label', 'plural' );
	$seller_plural_label = apply_filters( 'dt_sl_seller_label', 'plural' );

	$output = '';

	$output .= '<div class="dtsl-custom-table-wrapper">';

		$output .= '<table border="0" cellpadding="0" cellspacing="0" class="dtsl-custom-table">
						<thead>
							<tr>
								<th>'.esc_html__('#', 'dtsl').'</th>
								<th>'.esc_html__('Packages', 'dtsl').'</th>
								<th>'.esc_html__('Total Purchases', 'dtsl' ).'</th>
							</tr>
						</thead>
						<tbody class="dtsl-custom-table-content">';

							$args = array (
										'post_type' => 'dtsl_packages',
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
															$output .='<a href="#" class="custom-button-style dtsl-statistics-package-purchases" data-packageid="'.esc_html($package_id).'">'.esc_html__('View Details', 'dtsl').'</a>';
														}

										$output .= '</td>';
									$output .= '</tr>';

									$i++;

								endwhile;
								wp_reset_postdata();

							else:

								$output .= '<tr>
												<td colspan="4">'.esc_html__('No Records Found!', 'dtsl').'</td>
											</tr>';

							endif;

		$output .= '</tbody></table>';

		$output .= '<div class="dtsl-statistics-packages-count">'.esc_html__( 'Total Packages', 'dtsl' ).'<span>'.$packages_query->found_posts.'</span></div>';

		// Pagination script Start
		$max_num_pages = $packages_query->max_num_pages;

		$item_ids['post_per_page'] = $post_per_page;

		$output .= dtsl_ajax_pagination($max_num_pages, $current_page, 'dtsl_statistics_packages', 'dtsl-statistics-packages-data-container', $item_ids);
		// Pagination script End

	$output .= '</div>';

	$output .= '<div class="dtsl-statistics-packages-inner-data-container"></div>';


	echo dtsl_html_output($output);

	wp_die();

}

// Statistics Packages - Purchased Users
add_action( 'wp_ajax_dtsl_statistics_packages_purchases_user_details', 'dtsl_statistics_packages_purchases_user_details' );
add_action( 'wp_ajax_nopriv_dtsl_statistics_packages_purchases_user_details', 'dtsl_statistics_packages_purchases_user_details' );
function dtsl_statistics_packages_purchases_user_details() {


	$package_id = isset($_REQUEST['package_id']) ? dtsl_recursive_sanitize_text_field($_REQUEST['package_id']) : -1;

	$listing_plural_label = apply_filters( 'dt_sl_listing_label', 'plural' );
	$seller_singular_label = apply_filters( 'dt_sl_seller_label', 'singular' );

	$output = '';

	$output .= '<div class="dtsl-custom-table-wrapper">';
		$output .= '<table border="0" cellpadding="0" cellspacing="0" class="dtsl-custom-table">
						<thead>
							<tr>
								<th>'.esc_html__('#', 'dtsl').'</th>
								<th>'.sprintf( esc_html__('%1$s', 'dtsl'), $seller_singular_label ).'</th>
								<th>'.esc_html__('Status', 'dtsl').'</th>
							</tr>
						</thead>
						<tbody class="dtsl-custom-table-content">';

							if($package_id > 0) {

								$purchased_users = get_post_meta($package_id, 'purchased_users', true);

								if(is_array($purchased_users) && !empty($purchased_users)) {

									$i = 1;

									foreach($purchased_users as $purchased_user_key => $purchased_user) {

										$package_status = esc_html__('Expired', 'dtsl');
										if(dtsl_check_user_seller_package_is_active($purchased_user_key, $package_id)) {
											$package_status = esc_html__('Active', 'dtsl');
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

	echo dtsl_html_output($output);

	wp_die();

}
?>