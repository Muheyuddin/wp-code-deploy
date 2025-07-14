<?php

// Statistics Packages - Default Content
if(!function_exists('dtsl_statistics_packages_content')) {
	function dtsl_statistics_packages_content() {

		$output = '';

		$output .= '<div class="dtsl-statistics-container dtsl-statistics-packages-container">';

			$output .= dtsl_generate_loader_html(true);

			$output .= '<div class="dtsl-statistics-packages-data-container"></div>';

		$output .= '</div>';

		echo dtsl_html_output($output);

	}
}

// Statistics Packages - Ajax Call
if(!function_exists('dtsl_statistics_packages')) {
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
	add_action( 'wp_ajax_dtsl_statistics_packages', 'dtsl_statistics_packages' );
	add_action( 'wp_ajax_nopriv_dtsl_statistics_packages', 'dtsl_statistics_packages' );
}

// Statistics Packages - Purchased Users
if(!function_exists('dtsl_statistics_packages_purchases_user_details')) {
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
	add_action( 'wp_ajax_dtsl_statistics_packages_purchases_user_details', 'dtsl_statistics_packages_purchases_user_details' );
	add_action( 'wp_ajax_nopriv_dtsl_statistics_packages_purchases_user_details', 'dtsl_statistics_packages_purchases_user_details' );
}

?>