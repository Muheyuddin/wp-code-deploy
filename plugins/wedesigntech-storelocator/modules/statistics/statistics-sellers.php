<?php

// Statistics Sellers - Default Content
if(!function_exists('dtsl_statistics_sellers_content')) {
	function dtsl_statistics_sellers_content() {

		$output = '';

		$output .= '<div class="dtsl-statistics-container dtsl-statistics-sellers-container">';

			$output .= dtsl_generate_loader_html(true);

			$output .= '<div class="dtsl-statistics-sellers-data-container"></div>';

		$output .= '</div>';

		echo dtsl_html_output($output);

	}
}

// Statistics Sellers - Ajax Call
if(!function_exists('dtsl_statistics_sellers')) {
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
										if(function_exists('dtsl_check_user_seller_package_is_active') && dtsl_check_user_seller_package_is_active($seller_id, $dtsl_seller_active_package_id)) {

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
	add_action( 'wp_ajax_dtsl_statistics_sellers', 'dtsl_statistics_sellers' );
	add_action( 'wp_ajax_nopriv_dtsl_statistics_sellers', 'dtsl_statistics_sellers' );
}

// Statistics Sellers - Incharges
if(!function_exists('dtsl_statistics_seller_incharges')) {
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
	add_action( 'wp_ajax_dtsl_statistics_seller_incharges', 'dtsl_statistics_seller_incharges' );
	add_action( 'wp_ajax_nopriv_dtsl_statistics_seller_incharges', 'dtsl_statistics_seller_incharges' );
}

// Statistics Sellers - Listings
if(!function_exists('dtsl_statistics_seller_listings')) {
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
	add_action( 'wp_ajax_dtsl_statistics_seller_listings', 'dtsl_statistics_seller_listings' );
	add_action( 'wp_ajax_nopriv_dtsl_statistics_seller_listings', 'dtsl_statistics_seller_listings' );
}

?>