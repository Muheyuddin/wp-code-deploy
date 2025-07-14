<?php

// Statistics Listing - Default Content
if(!function_exists('dtsl_statistics_listings_content')) {
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
}

// Statistics Listing - Ajax Call
if(!function_exists('dtsl_statistics_sellerwise_listings')) {
	function dtsl_statistics_sellerwise_listings() {

		// Pagination script Start

		$current_page = isset($_REQUEST['current_page']) ? dtsl_recursive_sanitize_text_field($_REQUEST['current_page']) : 1;
		$offset = isset($_REQUEST['offset']) ? dtsl_recursive_sanitize_text_field($_REQUEST['offset']) : 0;
		$backend_postperpage = dtsl_option('general','backend-postperpage');
		$post_per_page = isset($_REQUEST['post_per_page']) ? dtsl_recursive_sanitize_text_field($_REQUEST['post_per_page']) : $backend_postperpage;

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
										<th>'.esc_html__('Purchases', 'dtsl').'</th>
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

											$purchased_users = get_post_meta($listing_id, 'purchased_users', true);
											$purchased_users = (is_array($purchased_users) && !empty($purchased_users)) ? count($purchased_users) : 0;

											$output .= '<tr>
															<td>'.$i.'</td>
															<td>'.get_the_title($listing_id).'</td>
															<td>'.get_the_author_meta( 'display_name' , $author_id ).' ( '.implode(', ', $user_roles).' ) '.'</td>
															<td>'.esc_html($total_views).'</td>
															<td>'.esc_html($average_ratings).'</td>
															<td>'.esc_html($purchased_users).'</td>
														</tr>';

											$i++;

										endwhile;
										wp_reset_postdata();

									else:

										$output .= '<tr>
														<td colspan="5">'.esc_html__('No Records Found!', 'dtsl').'</td>
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
	add_action( 'wp_ajax_dtsl_statistics_sellerwise_listings', 'dtsl_statistics_sellerwise_listings' );
	add_action( 'wp_ajax_nopriv_dtsl_statistics_sellerwise_listings', 'dtsl_statistics_sellerwise_listings' );
}

?>