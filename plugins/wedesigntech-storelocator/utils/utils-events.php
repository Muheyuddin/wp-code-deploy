<?php

// Schedule event to seller listings status
if( !function_exists('dtsl_setup_daily_user_schedule') ) {
    function  dtsl_setup_daily_user_schedule() {
    	wp_clear_scheduled_hook('dtsl_check_for_users_event');
        if ( ! wp_next_scheduled( 'dtsl_check_for_users_event' ) ) {
            wp_schedule_event( time(), 'twicedaily', 'dtsl_check_for_users_event');
        }
    }
}

// Check seller listings status
add_action( 'dtsl_check_for_users_event', 'dtsl_check_user_membership_status' );
if( !function_exists('dtsl_check_user_membership_status') ) {
    function dtsl_check_user_membership_status(){

    	// Seller

		$sellers = get_users ( array ('role' => 'seller', 'fields' => array ('ID') ) );

	    if(count($sellers) > 0) {
	        foreach($sellers as $seller) {

				$seller_id = $seller->ID;

		        if(function_exists('dtsl_check_user_seller_package_is_active') && !dtsl_check_user_seller_package_is_active($seller_id, -1)) {

		        	// Seller listings

					$args = array (
						'post_type'   => 'dtsl_listings',
						'author'      => $seller_id,
						'post_status' => 'any'
					);

					$seller_query = new WP_Query($args);
					if($seller_query->have_posts()) {
						while($seller_query->have_posts()){
							$seller_query->the_post();

							$listing_id = $seller_query->post->ID;

							$data = array (
								'ID'           => $listing_id,
								'post_type'    => 'dtsl_listings',
								'post_status'  => 'expired',
							);

							wp_update_post($data);

						}
						wp_reset_postdata();
					}

					// Update all incharges listings

					$incharges = get_users ( array ('role' => 'incharge', 'meta_key' => 'user_seller', 'meta_value' => $seller_id, 'fields' => array ('ID') ) );

					if(count($incharges) > 0) {
						foreach($incharges as $incharge) {

							$incharge_id = $incharge->ID;

				        	// Incharge listings

							$args = array (
								'post_type'   => 'dtsl_listings',
								'author'      => $incharge_id,
								'post_status' => 'any'
							);

							$incharge_query = new WP_Query($args);
							if($incharge_query->have_posts()) {
								while($incharge_query->have_posts()){
									$incharge_query->the_post();

									$listing_id = $incharge_query->post->ID;

									$data = array (
										'ID'           => $listing_id,
										'post_type'    => 'dtsl_listings',
										'post_status'  => 'expired',
									);

									wp_update_post($data);

								}
								wp_reset_postdata();
							}

							// Disable incharge

							update_user_meta( $incharge_id, 'dtsl_user_status', 'disabled' );

						}
					}

				}

		    }

		}

    	// Buyer

		$buyers = get_users ( array ('role' => 'buyer', 'fields' => array ('ID') ) );

	    if(count($buyers) > 0) {
	        foreach($buyers as $buyer) {

				$buyer_id = $buyer->ID;

		        if(function_exists('dtsl_check_user_buyer_package_is_active') && !dtsl_check_user_buyer_package_is_active($buyer_id, -1)) {

					update_user_meta($buyer_id, 'dtsl_buyer_package_listings', array ());
					update_user_meta($buyer_id, 'dtsl_buyer_package_used_listings_count', 0);

				}

		    }

		}

    }
}

?>