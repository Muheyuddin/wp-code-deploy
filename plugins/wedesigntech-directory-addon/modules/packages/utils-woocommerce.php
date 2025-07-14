<?php

if(!function_exists('dtdr_on_order_status_completion_from_packages_module')) {
	function dtdr_on_order_status_completion_from_packages_module($order_id) {

		$order = new WC_Order( $order_id );
		$user_id = get_post_meta($order_id, '_customer_user', true);

		$items = $order->get_items();
		foreach ( $items as $item_id => $item ) {

			$dtdr_item_id = wc_get_order_item_meta($item_id, 'dtdr_item_id');
			$post_type = get_post_type($dtdr_item_id);

			// For Package
			if(in_array($post_type, array('dtdr_packages'))) {

				$package_id = $dtdr_item_id;

				$period = get_post_meta($package_id, 'dtdr_period', true);
				$term = get_post_meta($package_id, 'dtdr_term', true);
				$terms_list = array('D' => 'days', 'W' => 'weeks', 'M' => 'months', 'Y' => 'years', 'L' => 'lifetime');

				$current_timestamp = strtotime(current_time(get_option('date_format')));
				if($term == 'L') {
					$expiry_timestamp = 'LT';
				} else if($term != '') {
					$add_date = '+'.$period.' '.$terms_list[$term];
					$expiry_timestamp = strtotime($add_date, $current_timestamp);
				} else {
					$expiry_timestamp = 'NA';
				}

				$purchased_users = get_post_meta($package_id, 'purchased_users', true);
				$purchased_users = (is_array($purchased_users) && !empty($purchased_users)) ? $purchased_users : array();
				$purchased_users[$user_id] = array (
												'purchased-date' => $current_timestamp,
												'expiry-date' => $expiry_timestamp,
											);
				update_post_meta($package_id, 'purchased_users', $purchased_users);

				$purchased_users_timestamp = get_post_meta($package_id, 'purchased_users_timestamp', true);
				$purchased_users_timestamp = (is_array($purchased_users_timestamp) && !empty($purchased_users_timestamp)) ? $purchased_users_timestamp : array();
				$purchased_users_timestamp[$current_timestamp][] = $user_id;
				update_post_meta($package_id, 'purchased_users_timestamp', $purchased_users_timestamp);


				// Update user status

				update_user_meta( $user_id, 'dtdr_user_status', 'active' );


		        $package_type = get_post_meta($package_id, 'dtdr_package_type', true);
		        $package_type = ($package_type != '') ? $package_type : 'buyer';

		        if($package_type == 'seller') {

					$purchased_seller_packages = get_user_meta($user_id, 'purchased_seller_packages', true);
					$purchased_seller_packages = (is_array($purchased_seller_packages) && !empty($purchased_seller_packages)) ? $purchased_seller_packages : array();
					$purchased_seller_packages[$package_id] = array (
													'purchased-date' => $current_timestamp,
													'expiry-date' => $expiry_timestamp,
												);
					update_user_meta($user_id, 'purchased_seller_packages', $purchased_seller_packages);

					$purchased_seller_packages_timestamp = get_user_meta($user_id, 'purchased_seller_packages_timestamp', true);
					$purchased_seller_packages_timestamp = (is_array($purchased_seller_packages_timestamp) && !empty($purchased_seller_packages_timestamp)) ? $purchased_seller_packages_timestamp : array();
					$purchased_seller_packages_timestamp[$current_timestamp][] = $package_id;
					update_user_meta($user_id, 'purchased_seller_packages_timestamp', $purchased_seller_packages_timestamp);


					$dtdr_seller_active_package_status = get_user_meta($user_id, 'dtdr_seller_active_package_status', true);

					if($dtdr_seller_active_package_status != 'disabled') {

						// Updating active package details

						$dtdr_seller_active_package_id = get_user_meta($user_id, 'dtdr_seller_active_package_id', true);
						$dtdr_seller_active_package_id = (isset($dtdr_seller_active_package_id) && !empty($dtdr_seller_active_package_id)) ? $dtdr_seller_active_package_id : -1;

						update_user_meta($user_id, 'dtdr_seller_previous_package_id', $dtdr_seller_active_package_id);

						update_user_meta($user_id, 'dtdr_seller_active_package_id', $package_id);
						update_user_meta($user_id, 'dtdr_seller_active_package_status', 'active');
						update_user_meta($user_id, 'dtdr_seller_active_package_purchased_date', $current_timestamp);
						update_user_meta($user_id, 'dtdr_seller_active_package_expiry_date', $expiry_timestamp);


						// Updating active package counts

						$dtdr_numberof_listings          = get_post_meta($package_id, 'dtdr_numberof_listings', true);
						$dtdr_numberof_featured_listings = get_post_meta($package_id, 'dtdr_numberof_featured_listings', true);
						$dtdr_numberof_incharges              = get_post_meta($package_id, 'dtdr_numberof_incharges', true);
						$dtdr_numberof_images              = get_post_meta($package_id, 'dtdr_numberof_images', true);

						update_user_meta($user_id, 'dtdr_seller_package_listings_count', $dtdr_numberof_listings);
						update_user_meta($user_id, 'dtdr_seller_package_featured_listings_count', $dtdr_numberof_featured_listings);
						update_user_meta($user_id, 'dtdr_seller_package_incharges_count', $dtdr_numberof_incharges);
						update_user_meta($user_id, 'dtdr_seller_package_images_count', $dtdr_numberof_images);


						// Used package count

						$dtdr_seller_package_used_listings_count          = get_user_meta($user_id, 'dtdr_seller_package_used_listings_count', true);
						$dtdr_seller_package_used_featured_listings_count = get_user_meta($user_id, 'dtdr_seller_package_used_featured_listings_count', true);
						$dtdr_seller_package_used_incharges_count              = get_user_meta($user_id, 'dtdr_seller_package_used_incharges_count', true);
						$dtdr_seller_package_used_images_count              = get_user_meta($user_id, 'dtdr_seller_package_used_images_count', true);



						// Comparing with used package count

						$incharges = get_users ( array ('role' => 'incharge', 'meta_key' => 'user_seller', 'meta_value' => $user_id, 'fields' => array ('ID') ) );

						if($dtdr_numberof_listings < $dtdr_seller_package_used_listings_count) {

							/* Downgrade */

							// Seller listings

							$args = array (
								'post_type'   => 'dtdr_listings',
								'author'      => $user_id,
								'post_status' => 'any'
							);

							$seller_query = new WP_Query( $args );
							if($seller_query->have_posts()) {
								while( $seller_query->have_posts()){
									$seller_query->the_post();

									$listing_id = $seller_query->post->ID;

									$listing_post = array (
										'ID'            => $listing_id,
										'post_type'     => 'dtdr_listings',
										'post_status'   => 'expired'
									);

									wp_update_post($listing_post);

								}
								wp_reset_postdata();
							}

							// Incharge listings

							if(count($incharges) > 0) {
								foreach($incharges as $incharge) {

									$incharge_id = $incharge->ID;

						        	// Incharge listings

									$args = array (
										'post_type'   => 'dtdr_listings',
										'author'      => $incharge_id,
										'post_status' => 'any'
									);

									$incharge_query = new WP_Query($args);
									if($incharge_query->have_posts()) {
										while($incharge_query->have_posts()){
											$incharge_query->the_post();

											$listing_id = $incharge_query->post->ID;

											$listing_post = array (
												'ID'           => $listing_id,
												'post_type'    => 'dtdr_listings',
												'post_status'  => 'expired',
											);

											wp_update_post($listing_post);

										}
										wp_reset_postdata();
									}

								}
							}

							update_user_meta($user_id, 'dtdr_seller_package_used_listings_count', 0);

						} else {

							/* Upgrade */

							// Seller listings

							$args = array (
								'post_type'   => 'dtdr_listings',
								'author'      => $user_id,
								'post_status' => 'any'
							);

							$seller_query = new WP_Query( $args );
							if($seller_query->have_posts()) {
								while( $seller_query->have_posts()){
									$seller_query->the_post();

									$listing_id = $seller_query->post->ID;

									$listing_post = array (
										'ID'            => $listing_id,
										'post_type'     => 'dtdr_listings',
									);

									$status = get_post_status($listing_id);

							    	if('true' ==  dtdr_option('general', 'should-admin-approve-listings') && $status != 'publish') {
								    	$listing_post['post_status'] = 'waitingforapproval';
							    	} else {
							    		$listing_post['post_status'] = 'publish';
							    	}

									wp_update_post($listing_post);

								}

								wp_reset_postdata();
							}

							// Incharge listings

							if(count($incharges) > 0) {
								foreach($incharges as $incharge) {

									$incharge_id = $incharge->ID;

						        	// Incharge listings

									$args = array (
										'post_type'   => 'dtdr_listings',
										'author'      => $incharge_id,
										'post_status' => 'any'
									);

									$incharge_query = new WP_Query($args);
									if($incharge_query->have_posts()) {
										while($incharge_query->have_posts()){
											$incharge_query->the_post();

											$listing_id = $incharge_query->post->ID;

											$listing_post = array (
												'ID'           => $listing_id,
												'post_type'    => 'dtdr_listings',
											);

											$status = get_post_status($listing_id);

									    	if('true' ==  dtdr_option('general', 'should-admin-approve-listings') && $status != 'publish') {
									    		$listing_post['post_status'] = 'waitingforapproval';
									    	} else {
									    		$listing_post['post_status'] = 'publish';
									    	}

											wp_update_post($listing_post);

										}
										wp_reset_postdata();
									}

								}
							}

						}

						if($dtdr_numberof_featured_listings < $dtdr_seller_package_used_featured_listings_count) {

							update_user_meta($user_id, 'dtdr_seller_package_featured_marked_listings', array ());
							update_user_meta($user_id, 'dtdr_seller_package_used_featured_listings_count', 0);

						}


						if($dtdr_numberof_incharges < $dtdr_seller_package_used_incharges_count) {

							/* Downgrade */

							if(count($incharges) > 0) {
								foreach($incharges as $incharge) {

									$incharge_id = $incharge->ID;

									// Disable incharge

									update_user_meta( $incharge_id, 'dtdr_user_status', 'disabled' );

								}
							}

							update_user_meta($user_id, 'dtdr_seller_package_used_incharges_count', 0);

						} else {

							/* Upgrade */

							if(count($incharges) > 0) {
								foreach($incharges as $incharge) {

									$incharge_id = $incharge->ID;

									// Enable incharge

									$dtdr_user_status = get_user_meta( $incharge_id, 'dtdr_user_status', true );

							    	if('true' ==  dtdr_option('general', 'should-admin-approve-incharges') && $dtdr_user_status != 'active') {
							    		update_user_meta( $incharge_id, 'dtdr_user_status', 'waitingforapproval' );
							    	} else {
							    		update_user_meta( $incharge_id, 'dtdr_user_status', 'active' );
							    	}

								}
							}

						}

						// Daily user status schedule
						dtdr_setup_daily_user_schedule();

					} else {

						update_user_meta($user_id, 'dtdr_seller_active_package_status', 'active');

					}

				} else if($package_type == 'buyer') {

					$purchased_buyer_packages = get_user_meta($user_id, 'purchased_buyer_packages', true);
					$purchased_buyer_packages = (is_array($purchased_buyer_packages) && !empty($purchased_buyer_packages)) ? $purchased_buyer_packages : array();
					$purchased_buyer_packages[$package_id] = array (
													'purchased-date' => $current_timestamp,
													'expiry-date' => $expiry_timestamp,
												);
					update_user_meta($user_id, 'purchased_buyer_packages', $purchased_buyer_packages);

					$purchased_buyer_packages_timestamp = get_user_meta($user_id, 'purchased_buyer_packages_timestamp', true);
					$purchased_buyer_packages_timestamp = (is_array($purchased_buyer_packages_timestamp) && !empty($purchased_buyer_packages_timestamp)) ? $purchased_buyer_packages_timestamp : array();
					$purchased_buyer_packages_timestamp[$current_timestamp][] = $package_id;
					update_user_meta($user_id, 'purchased_buyer_packages_timestamp', $purchased_buyer_packages_timestamp);


					$dtdr_buyer_active_package_status = get_user_meta($user_id, 'dtdr_buyer_active_package_status', true);

					if($dtdr_buyer_active_package_status != 'disabled') {

						// Updating active package details

						$dtdr_buyer_active_package_id = get_user_meta($user_id, 'dtdr_buyer_active_package_id', true);
						$dtdr_buyer_active_package_id = (isset($dtdr_buyer_active_package_id) && !empty($dtdr_buyer_active_package_id)) ? $dtdr_buyer_active_package_id : -1;

						update_user_meta($user_id, 'dtdr_buyer_previous_package_id', $dtdr_buyer_active_package_id);

						update_user_meta($user_id, 'dtdr_buyer_active_package_id', $package_id);
						update_user_meta($user_id, 'dtdr_buyer_active_package_status', 'active');
						update_user_meta($user_id, 'dtdr_buyer_active_package_purchased_date', $current_timestamp);
						update_user_meta($user_id, 'dtdr_buyer_active_package_expiry_date', $expiry_timestamp);


						// Updating active package counts

						$dtdr_numberof_listings = get_post_meta($package_id, 'dtdr_numberof_listings', true);
						update_user_meta($user_id, 'dtdr_buyer_package_listings_count', $dtdr_numberof_listings);


						// Used package count

						$dtdr_buyer_package_used_listings_count = get_user_meta($user_id, 'dtdr_buyer_package_used_listings_count', true);


						// Comparing with used package count

						if($dtdr_numberof_listings < $dtdr_buyer_package_used_listings_count) {

							/* Downgrade */

							update_user_meta($user_id, 'dtdr_buyer_package_listings', array ());
							update_user_meta($user_id, 'dtdr_buyer_package_used_listings_count', 0);

						}

						// Daily user status schedule
						dtdr_setup_daily_user_schedule();

					} else {

						update_user_meta($user_id, 'dtdr_buyer_active_package_status', 'active');

					}

				}


				// Change the customer role to seller
			    if ( $user_id > 0 ) {

			    	$user = new WP_User( $user_id );
			        $user->remove_role( 'customer' );
			        $user->remove_role( 'subscriber' );

			        if($package_type == 'buyer') {
			        	$user->add_role( 'buyer' );
			        } else if($package_type == 'seller') {
			        	$user->add_role( 'seller' );
			        }

			    }

			}

		}

	}
	add_action('woocommerce_order_status_completed','dtdr_on_order_status_completion_from_packages_module');
}

if(!function_exists('dtdr_on_order_status_cancellation_from_packages_module')) {
	function dtdr_on_order_status_cancellation_from_packages_module($order_id) {

		$order = new WC_Order( $order_id );
		$user_id = get_post_meta($order_id, '_customer_user', true);

		$items = $order->get_items();
		foreach ( $items as $item_id => $item ) {

			$dtdr_item_id = wc_get_order_item_meta($item_id, 'dtdr_item_id');
			$post_type = get_post_type($dtdr_item_id);

			// For Packages
			if(in_array($post_type, array('dtdr_packages'))) {

				$package_id = $dtdr_item_id;

				$purchased_users = get_post_meta($package_id, 'purchased_users', true);
				$purchased_users = (is_array($purchased_users) && !empty($purchased_users)) ? $purchased_users : array();
				if(array_key_exists($user_id, $purchased_users)) {
				    unset($purchased_users[$user_id]);
				}
				update_post_meta($package_id, 'purchased_users', $purchased_users);

				$purchased_users_timestamp = get_post_meta($package_id, 'purchased_users_timestamp', true);
				$purchased_users_timestamp = (is_array($purchased_users_timestamp) && !empty($purchased_users_timestamp)) ? $purchased_users_timestamp : array();
				foreach($purchased_users_timestamp as $purchased_users_timestamp_key => $purchased_users_timestamp_data) {
					if(in_array($user_id, $purchased_users_timestamp_data)) {
					    unset($purchased_users_timestamp[$purchased_users_timestamp_key][array_search($user_id, $purchased_users_timestamp_data)]);
					}
				}
				update_post_meta($package_id, 'purchased_users_timestamp', $purchased_users_timestamp);


				// Update user status

				update_user_meta( $user_id, 'dtdr_user_status', 'disabled' );


		        $package_type = get_post_meta($package_id, 'dtdr_package_type', true);
		        $package_type = ($package_type != '') ? $package_type : 'buyer';

		        if($package_type == 'seller') {

					$purchased_seller_packages = get_user_meta($user_id, 'purchased_seller_packages', true);
					$purchased_seller_packages = (is_array($purchased_seller_packages) && !empty($purchased_seller_packages)) ? $purchased_seller_packages : array();
					if(array_key_exists($package_id, $purchased_seller_packages)) {
					    unset($purchased_seller_packages[$package_id]);
					}
					update_user_meta($user_id, 'purchased_seller_packages', $purchased_seller_packages);

					$purchased_seller_packages_timestamp = get_user_meta($user_id, 'purchased_seller_packages_timestamp', true);
					$purchased_seller_packages_timestamp = (is_array($purchased_seller_packages_timestamp) && !empty($purchased_seller_packages_timestamp)) ? $purchased_seller_packages_timestamp : array();
					foreach($purchased_seller_packages_timestamp as $purchased_seller_packages_timestamp_key => $purchased_seller_packages_timestamp_data) {
						if(in_array($package_id, $purchased_seller_packages_timestamp_data)) {
						    unset($purchased_seller_packages_timestamp[$purchased_seller_packages_timestamp_key][array_search($package_id, $purchased_seller_packages_timestamp_data)]);
						}
					}
					update_user_meta($user_id, 'purchased_seller_packages_timestamp', $purchased_seller_packages_timestamp);

					// Disable active package
					$dtdr_seller_active_package_id = get_user_meta($user_id, 'dtdr_seller_active_package_id', true);
					if($dtdr_seller_active_package_id == $package_id) {
						update_user_meta($user_id, 'dtdr_seller_active_package_status', 'disabled');
					}

				} else if($package_type == 'buyer') {

					$purchased_buyer_packages = get_user_meta($user_id, 'purchased_buyer_packages', true);
					$purchased_buyer_packages = (is_array($purchased_buyer_packages) && !empty($purchased_buyer_packages)) ? $purchased_buyer_packages : array();
					if(array_key_exists($package_id, $purchased_buyer_packages)) {
					    unset($purchased_buyer_packages[$package_id]);
					}
					update_user_meta($user_id, 'purchased_buyer_packages', $purchased_buyer_packages);

					$purchased_buyer_packages_timestamp = get_user_meta($user_id, 'purchased_buyer_packages_timestamp', true);
					$purchased_buyer_packages_timestamp = (is_array($purchased_buyer_packages_timestamp) && !empty($purchased_buyer_packages_timestamp)) ? $purchased_buyer_packages_timestamp : array();
					foreach($purchased_buyer_packages_timestamp as $purchased_buyer_packages_timestamp_key => $purchased_buyer_packages_timestamp_data) {
						if(in_array($package_id, $purchased_buyer_packages_timestamp_data)) {
						    unset($purchased_buyer_packages_timestamp[$purchased_buyer_packages_timestamp_key][array_search($package_id, $purchased_buyer_packages_timestamp_data)]);
						}
					}
					update_user_meta($user_id, 'purchased_buyer_packages_timestamp', $purchased_buyer_packages_timestamp);

					// Disable active package
					$dtdr_buyer_active_package_id = get_user_meta($user_id, 'dtdr_buyer_active_package_id', true);
					if($dtdr_buyer_active_package_id == $package_id) {
						update_user_meta($user_id, 'dtdr_buyer_active_package_status', 'disabled');
					}

				}

			}

		}

	}
	add_action('woocommerce_order_status_cancelled','dtdr_on_order_status_cancellation_from_packages_module');
	add_action('woocommerce_order_status_refunded','dtdr_on_order_status_cancellation_from_packages_module');
}

// While deleting user
if(!function_exists('dtdr_on_user_deletion_from_packages_module')) {
    function dtdr_on_user_deletion_from_packages_module($user_id) {

		$args = array (
					'posts_per_page' => -1,
					'post_type' => 'dtdr_packages',
					'meta_query' => array (),
					'tax_query' => array (),
				);


		$packages_query = new WP_Query( $args );

		if ( $packages_query->have_posts() ) :

			$i = 1;
			while ( $packages_query->have_posts() ) :
				$packages_query->the_post();

				$package_id = get_the_ID();

				// Remove user from package

				$purchased_users = get_post_meta($package_id, 'purchased_users', true);
				$purchased_users = (is_array($purchased_users) && !empty($purchased_users)) ? $purchased_users : array();
				if(array_key_exists($user_id, $purchased_users)) {
				    unset($purchased_users[$user_id]);
				}
				update_post_meta($package_id, 'purchased_users', $purchased_users);

				$purchased_users_timestamp = get_post_meta($package_id, 'purchased_users_timestamp', true);
				$purchased_users_timestamp = (is_array($purchased_users_timestamp) && !empty($purchased_users_timestamp)) ? $purchased_users_timestamp : array();
				foreach($purchased_users_timestamp as $purchased_users_timestamp_key => $purchased_users_timestamp_data) {
					if(in_array($user_id, $purchased_users_timestamp_data)) {
					    unset($purchased_users_timestamp[$purchased_users_timestamp_key][array_search($user_id, $purchased_users_timestamp_data)]);
					}
				}
				update_post_meta($package_id, 'purchased_users_timestamp', $purchased_users_timestamp);

			endwhile;
			wp_reset_postdata();

		endif;

    }
    add_action('delete_user', 'dtdr_on_user_deletion_from_packages_module');
}

?>