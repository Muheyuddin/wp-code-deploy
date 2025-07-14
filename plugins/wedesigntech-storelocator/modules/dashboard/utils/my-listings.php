<?php

function dtsl_dashboard_mylistings_page_content() {

	$output = '';

	$output .= '<div class="dtsl-my-listings-container list">';

		$output .= '<div class="dtsl-my-listings-item-holder">';

			$output .= dtsl_dashboard_mylistings_items_ajax_content();

		$output .= '</div>';

	$output .= '</div>';


	return $output;

}


add_action( 'wp_ajax_dtsl_dashboard_mylistings_items_ajax_content', 'dtsl_dashboard_mylistings_items_ajax_content' );
add_action( 'wp_ajax_nopriv_dtsl_dashboard_mylistings_items_ajax_content', 'dtsl_dashboard_mylistings_items_ajax_content' );
function dtsl_dashboard_mylistings_items_ajax_content() {

	$output = '';

	$dashboard_page_id = get_the_ID();

	// Pagination script Start
	$ajax_call = (isset($_REQUEST['ajax_call']) && $_REQUEST['ajax_call'] == true) ? true : false;
	$current_page = isset($_REQUEST['current_page']) ? dtsl_recursive_sanitize_text_field($_REQUEST['current_page']) : 1;
	$offset = isset($_REQUEST['offset']) ? dtsl_recursive_sanitize_text_field($_REQUEST['offset']) : 0;
	$frontend_postperpage = dtsl_option('general','frontend-postperpage');
	$post_per_page = isset($_REQUEST['post_per_page']) ? dtsl_recursive_sanitize_text_field($_REQUEST['post_per_page']) : dtsl_recursive_sanitize_text_field($frontend_postperpage);

	$function_call = (isset($_REQUEST['function_call']) && $_REQUEST['function_call'] != '') ? dtsl_recursive_sanitize_text_field($_REQUEST['function_call']) : 'dtsl_dashboard_mylistings_items_ajax_content';
	$output_div = (isset($_REQUEST['output_div']) && $_REQUEST['output_div'] != '') ? dtsl_recursive_sanitize_text_field($_REQUEST['output_div']) : 'dtsl-my-listings-item-holder';
	$dashboard_page_id = (isset($_REQUEST['dashboard_page_id']) && $_REQUEST['dashboard_page_id'] != '') ? dtsl_recursive_sanitize_text_field($_REQUEST['dashboard_page_id']) : $dashboard_page_id;
	// Pagination script End


	$user_id = get_current_user_id();
	$current_user = get_userdata($user_id);

	$seller_id = $admin_id = -1;

	$author_ids = array ();

	if(in_array('administrator', (array) $current_user->roles)) {

		$admin_id = $user_id;

		$author_ids = array ($user_id);

	} else if(in_array('seller', (array) $current_user->roles)) {

		$seller_id = $user_id;

		$author_ids = array ($user_id);

		$seller_incharges = get_users ( array ('role' => 'incharge', 'meta_key' => 'user_seller', 'meta_value' => $user_id, 'fields' => 'ID') );

		$author_ids = array_merge($author_ids, $seller_incharges);


	} else if(in_array('incharge', (array) $current_user->roles)) {

		$author_ids = array ($user_id);

		$user_seller = get_user_meta( $user_id, 'user_seller', true );
		if($user_seller != '' && $user_seller > 0) {

			$seller_id = $user_seller;

		}

	}


	$columns = 2;
	$column_class = 'dtsl-column dtsl-one-half';

	$data_listing_attributes                      = array ();
	$data_listing_attributes['column_class']      = $column_class;
	$data_listing_attributes['dashboard_page_id'] = $dashboard_page_id;
	$data_listing_attributes['roles']             = (array) $current_user->roles;
	$data_listing_attributes['seller_id']         = $seller_id;
	$data_listing_attributes['admin_id']          = $admin_id;

	$args = array (
				'offset' => $offset,
				'paged' => $current_page ,
				'posts_per_page' => $post_per_page,
				'post_type' => 'dtsl_listings',
				'author__in' => $author_ids,
				'post_status' =>  array ( 'any' )
			);

	$mylistings_query = new WP_Query( $args );

	if ( $mylistings_query->have_posts() ) :

		$output .= '<div class="dtsl-dashboard-notices"></div>';


		$i = 1;
		while ( $mylistings_query->have_posts() ) :
			$mylistings_query->the_post();

			if($i == 1) { $first_class = 'first';  } else { $first_class = ''; }
			if($i == $columns) { $i = 1; } else { $i = $i + 1; }

			$data_listing_attributes['first_class'] = $first_class;

			$output .= dtsl_dashboard_mylistings_items($data_listing_attributes);

		endwhile;
		wp_reset_postdata();

	else :

		$output .= '<div class="dtsl-dashboard-notices dtsl-info-notice">'.esc_html__('No records found!', 'dtsl').'</div>';

	endif;


	// Pagination script Start
	$total_post_args = array (
							'posts_per_page' => -1,
							'post_type'=> 'dtsl_listings',
							'author__in' => $author_ids,
							'post_status' =>  array ( 'any' )
						);
	$total_post_listings = get_posts( $total_post_args );
	wp_reset_postdata();

	$listings_post_count = count($total_post_listings);
	$max_num_pages = ceil($listings_post_count / $post_per_page);

	$item_ids['post_per_page'] = $post_per_page;
	$item_ids['dashboard_page_id'] = $dashboard_page_id;

	$output .= dtsl_ajax_pagination($max_num_pages, $current_page, $function_call, $output_div, $item_ids);
	// Pagination script End


	if($ajax_call) {
		echo dtsl_html_output($output);
		die();
	} else {
		return $output;
	}

}

function dtsl_dashboard_mylistings_items($data_listing_attributes) {

	$output = '';

	$listing_id = get_the_ID();
	$listing_title = get_the_title();
	$listing_permalink = get_permalink();

	$author_id = get_the_author_meta('ID');

	$dashboard_page_id = get_the_ID();

	extract($data_listing_attributes);

	$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );


	$item_classes = array ('dtsl-listing-item-wrapper', 'dtsl-mylisting-item-wrapper');
	array_push($item_classes, $column_class);
	if($first_class != '') {
		array_push($item_classes, $first_class);
	}

	// Options
	$edit_item_url = esc_url_raw ( add_query_arg( array (
							    'type' => 'addlisting',
							    'edit_item_id' => $listing_id,
							), get_permalink($dashboard_page_id) ));


	//$dtsl_seller_active_package_id = get_user_meta($author_id, 'dtsl_active_seller_package_id', true);

	if(in_array('seller', $roles)) {

		$listing_package_status_active = false;

		$dtsl_seller_active_package_id = get_user_meta($seller_id, 'dtsl_seller_active_package_id', true);
		$dtsl_seller_active_package_id = (isset($dtsl_seller_active_package_id) && !empty($dtsl_seller_active_package_id)) ? $dtsl_seller_active_package_id : -1;

		if(function_exists('dtsl_check_user_seller_package_is_active') && dtsl_check_user_seller_package_is_active($seller_id, -1)) {

			$dtsl_seller_package_featured_listings_count      = get_user_meta($seller_id, 'dtsl_seller_package_featured_listings_count', true);
			$dtsl_seller_package_featured_listings_count      = (isset($dtsl_seller_package_featured_listings_count) && !empty($dtsl_seller_package_featured_listings_count)) ? $dtsl_seller_package_featured_listings_count : 0;

			$dtsl_seller_package_used_featured_listings_count = get_user_meta($seller_id, 'dtsl_seller_package_used_featured_listings_count', true);
			$dtsl_seller_package_used_featured_listings_count = (isset($dtsl_seller_package_used_featured_listings_count) && !empty($dtsl_seller_package_used_featured_listings_count)) ? $dtsl_seller_package_used_featured_listings_count : 0;

			$dtsl_seller_allow_featured_listings = false;
			if($dtsl_seller_package_featured_listings_count == -1) {
				$dtsl_seller_allow_featured_listings = true;
			} else {
				$remaining_featured_listings = ($dtsl_seller_package_featured_listings_count - $dtsl_seller_package_used_featured_listings_count);
			}

			$allow_featured_item = false;
			if($dtsl_seller_allow_featured_listings || $remaining_featured_listings > 0) {
				$allow_featured_item = true;
			}

			$listing_package_status_active = true;

		}

		$featured_listings_id = get_user_meta($seller_id,  'dtsl_seller_package_featured_marked_listings', true);
		$featured_listings_id = (is_array($featured_listings_id) && !empty($featured_listings_id)) ? $featured_listings_id : array ();

	}

	if( class_exists( 'Vc_Manager' ) ) {
		WPBMap::addAllMappedShortcodes();
	}

	$output .= '<div class="'.implode(' ', get_post_class($item_classes, $listing_id)).'">';

		if(has_post_thumbnail($listing_id)) {
			$output .= '<div class="dtsl-listing-thumb"><a href="'.$listing_permalink.'" title="'.$listing_title.'">'.get_the_post_thumbnail($listing_id, 'full').'</a></div>';
		}

		$output .= '<div class="dtsl-listing-details">';

			$output .= '<h5><a href="'.$listing_permalink.'" title="'.$listing_title.'">'.$listing_title.'</a></h5>';

			$output .= '<div class="dtsl-listing-description">'.get_the_excerpt($listing_id).'</div>';

			$output .= '<div class="dtsl-mylisting-options-container">';

				if(get_post_status($listing_id) != 'expired') {

	                $output .= '<a data-tooltip="'.sprintf( esc_html__('Edit %1$s', 'dtsl'), $dt_sl_listing_singular_label ).'" href="'.esc_url($edit_item_url).'">
	                				<i class="far fa-edit"></i>
	                			</a>';

	    			$output .= '<a data-tooltip="'.sprintf( esc_html__('Delete %1$s', 'dtsl'), $dt_sl_listing_singular_label ).'" class="dtsl-remove-listing" data-nonce="'.wp_create_nonce('dtsl-delete-listing-'. $listing_id ).'" data-listing-id="'.esc_attr($listing_id).'" data-user-id="'.esc_attr($author_id).'" data-seller-id="'.esc_attr($seller_id).'" data-dashboard-page-url="'.esc_url(get_permalink($dashboard_page_id)).'">
	            				<i class="far fa-times-circle"></i>
	            			</a>';

	            	if(in_array('seller', $roles)) {

		    			if($listing_package_status_active) {

		    				if($allow_featured_item) {

								if(in_array($listing_id, $featured_listings_id)) {

						            $output .= '<a class="dtsl-dashboard-markitem-featured" data-tooltip="'.sprintf( esc_html__('Featured %1$s', 'dtsl'), $dt_sl_listing_singular_label ).'" href="#" onclick="return false;" data-listing-id="'.esc_attr($listing_id).'" data-seller-id="'.esc_attr($seller_id).'" data-admin-id="-1"><i class="fas fa-star"></i></a>';

		        				} else {

					                $output .= '<a class="dtsl-dashboard-markitem-featured" data-tooltip="'.esc_html__('Mark As Featured', 'dtsl').'" href="#" onclick="return false;" data-listing-id="'.esc_attr($listing_id).'" data-seller-id="'.esc_attr($seller_id).'" data-admin-id="-1"><i class="far fa-star"></i></a>';

				                }

				            } else {

								if(in_array($listing_id, $featured_listings_id)) {

						            $output .= '<a class="dtsl-dashboard-markitem-featured" data-tooltip="'.sprintf( esc_html__('Featured %1$s', 'dtsl'), $dt_sl_listing_singular_label ).'" href="#" onclick="return false;" data-listing-id="'.esc_attr($listing_id).'" data-seller-id="'.esc_attr($seller_id).'" data-admin-id="-1"><i class="fas fa-star"></i></a>';

		        				} else {

						            $output .= '<a data-tooltip="'.esc_html__('Mark As Featured', 'dtsl').'" href="#" onclick="return false;">
					                				<i class="far fa-star"></i>
					                			</a>';

				                }

				            }

		    			} else {

		    				if(in_array($listing_id, $featured_listings_id)) {

					            $output .= '<a data-tooltip="'.sprintf( esc_html__('Featured %1$s', 'dtsl'), $dt_sl_listing_singular_label ).'" href="#" onclick="return false;">
				                				<i class="fas fa-star"></i>
				                			</a>';

		    				} else {

					            $output .= '<a data-tooltip="'.esc_html__('Mark As Featured', 'dtsl').'" href="#" onclick="return false;">
				                				<i class="far fa-star"></i>
				                			</a>';

			                }

		    			}

		    		}

	            	if(in_array('administrator', $roles)) {

	            		$dtsl_featured_item = get_post_meta($listing_id, 'dtsl_featured_item', true);

						if($dtsl_featured_item == 'true') {

				            $output .= '<a class="dtsl-dashboard-markitem-featured" data-tooltip="'.sprintf( esc_html__('Featured %1$s', 'dtsl'), $dt_sl_listing_singular_label ).'" href="#" onclick="return false;" data-listing-id="'.esc_attr($listing_id).'" data-seller-id="-1" data-admin-id="'.esc_attr($admin_id).'"><i class="fas fa-star"></i></a>';

        				} else {

			                $output .= '<a class="dtsl-dashboard-markitem-featured" data-tooltip="'.esc_html__('Mark As Featured', 'dtsl').'" href="#" onclick="return false;" data-listing-id="'.esc_attr($listing_id).'" data-seller-id="-1" data-admin-id="'.esc_attr($admin_id).'"><i class="far fa-star"></i></a>';

		                }

		    		}


				    $total_views = get_post_meta($listing_id, 'dtsl_total_views', true);
				    $total_views = ($total_views != '') ? $total_views : 0;

	                $output .= '<a data-tooltip="'.sprintf( esc_html__('Item has %1$s views', 'dtsl'), $total_views ).'" href="#" onclick="return false;">
	                            	<i class="fas fa-eye"></i>
	                            </a>';

                }

                if(in_array('seller', $roles) && $listing_package_status_active) {

                	$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );

            		$requires_admin_approval = 'false';
            		$approve_listing_tooltip = sprintf( esc_html__( 'Publish %1$s', 'dtsl' ), $dt_sl_listing_singular_label );
            		if('true' == dtsl_option('general', 'should-admin-approve-listings')) {
            			$requires_admin_approval = 'true';
            			$approve_listing_tooltip = esc_html__('Submit For Approval', 'dtsl');
            		}

            		if(get_post_status($listing_id) != 'publish') {

		                if(get_post_status($listing_id) == 'expired' || get_post_status($listing_id) == 'pending') {

		                	$output .= '<a class="dtsl-dashboard-submit-listing-for-approval" data-tooltip="'.esc_html($approve_listing_tooltip).'" href="#" onclick="return false;" data-listing-id="'.esc_attr($listing_id).'" data-seller-id="'.esc_attr($seller_id).'" data-requires-admin-approval="'.esc_attr($requires_admin_approval).'" data-nonce="'.wp_create_nonce('dtsl-submit-listing-for-approval-'. $listing_id ).'"><i class="fas fa-share-square"></i></a>';

		                }

		            }

	            }

            $output .= '</div>';

			$output .= '<div class="dtsl-listing-dashboard-datas">';

				if(get_post_status($listing_id) == 'expired') {
					$output .= '<div class="dtsl-listing-dashboard-status">'.esc_html__('Expired', 'dtsl').'</div>';
				} else if(get_post_status($listing_id) == 'waitingforapproval') {
					$output .= '<div class="dtsl-listing-dashboard-status">'.esc_html__('Waiting For Approval', 'dtsl').'</div>';
				} else if(get_post_status($listing_id) == 'pending') {
					$output .= '<div class="dtsl-listing-dashboard-status">'.esc_html__('Pending', 'dtsl').'</div>';
				} else if(get_post_status($listing_id) == 'publish') {
					$output .= '<div class="dtsl-listing-dashboard-status">'.esc_html__('Published', 'dtsl').'</div>';
				}

				if(!in_array('incharge', $roles)) {

					$output .= '<div class="dtsl-listing-dashboard-owner">'.sprintf( esc_html__('Added by %1$s', 'dtsl'), '<a href="'.esc_url(get_author_posts_url($author_id)).'">'.get_the_author_meta('display_name', $author_id).'</a>' ).'</div>';

				}

			$output .= '</div>';


		$output .= '</div>';

	$output .= '</div>';


	return $output;

}

// Remove seller listing
add_action( 'wp_ajax_dtsl_remove_seller_listing', 'dtsl_remove_seller_listing' );
add_action( 'wp_ajax_nopriv_dtsl_remove_seller_listing', 'dtsl_remove_seller_listing' );
function dtsl_remove_seller_listing() {

	extract(dtsl_recursive_sanitize_text_field($_REQUEST));

	$has_error = false;
	$errors = array ();

	if(wp_verify_nonce($nonce, 'dtsl-delete-listing-'.$listing_id)) {

		$seller_incharges = get_users ( array ('role' => 'incharge', 'meta_key' => 'user_seller', 'meta_value' => $seller_id, 'fields' => 'ID') );

	    $delete_item_post = get_post($listing_id);

	    if( $user_id != $delete_item_post->post_author && !in_array($delete_item_post->post_author, $seller_incharges) ) {

			$has_error = true;
			$errors[] = '<p>'.esc_html__('You don\'t have permission to delete this item.', 'dtsl').'</p>';

	    } else {

			wp_delete_post($listing_id);

			echo 'success';

	    }

	}

    if($has_error) {
    	echo json_encode($errors);
    }

	die();

}

// Mark item as featured
add_action( 'wp_ajax_dtsl_dashboard_markitem_featured', 'dtsl_dashboard_markitem_featured' );
add_action( 'wp_ajax_nopriv_dtsl_dashboard_markitem_featured', 'dtsl_dashboard_markitem_featured' );
function dtsl_dashboard_markitem_featured() {

	$output = '';

	$listing_id = isset($_REQUEST['listing_id']) ? dtsl_recursive_sanitize_text_field($_REQUEST['listing_id']) : -1;
	$seller_id = isset($_REQUEST['seller_id']) ? dtsl_recursive_sanitize_text_field($_REQUEST['seller_id']) : -1;
	$admin_id = isset($_REQUEST['admin_id']) ? dtsl_recursive_sanitize_text_field($_REQUEST['admin_id']) : -1;
	$action_type = isset($_REQUEST['action_type']) ? dtsl_recursive_sanitize_text_field($_REQUEST['action_type']) : 'add';


	if($listing_id > 0 && $admin_id > 0) {

		if($action_type == 'add') {

		    update_post_meta($listing_id, 'dtsl_featured_item', 'true');

		    $output .= 'success-add';

		} else if($action_type == 'remove') {

			delete_post_meta($listing_id, 'dtsl_featured_item');

			$output .= 'success-remove';

		} else {

			$output .= 'fail';

		}

	} else if($listing_id > 0 && $seller_id > 0) {

		$dtsl_seller_package_featured_listings_count      = get_user_meta($seller_id, 'dtsl_seller_package_featured_listings_count', true);
		$dtsl_seller_package_featured_listings_count      = (isset($dtsl_seller_package_featured_listings_count) && !empty($dtsl_seller_package_featured_listings_count)) ? $dtsl_seller_package_featured_listings_count : 0;

		$dtsl_seller_package_used_featured_listings_count = get_user_meta($seller_id, 'dtsl_seller_package_used_featured_listings_count', true);
		$dtsl_seller_package_used_featured_listings_count = (isset($dtsl_seller_package_used_featured_listings_count) && !empty($dtsl_seller_package_used_featured_listings_count)) ? $dtsl_seller_package_used_featured_listings_count : 0;

		$dtsl_seller_allow_featured_listings = false;
		if($dtsl_seller_package_featured_listings_count == -1) {
			$dtsl_seller_allow_featured_listings = true;
		} else {
			$remaining_featured_listings = ($dtsl_seller_package_featured_listings_count - $dtsl_seller_package_used_featured_listings_count);
		}

		if($remaining_featured_listings > 0 || $dtsl_seller_allow_featured_listings) {

			if($action_type == 'add') {

			    $dtsl_seller_package_used_featured_listings_count++;
			    update_user_meta($seller_id, 'dtsl_seller_package_used_featured_listings_count', $dtsl_seller_package_used_featured_listings_count);

			    $dtsl_seller_package_featured_marked_listings = get_user_meta($seller_id, 'dtsl_seller_package_featured_marked_listings', true);
			    $dtsl_seller_package_featured_marked_listings = (is_array($dtsl_seller_package_featured_marked_listings) && !empty($dtsl_seller_package_featured_marked_listings)) ? $dtsl_seller_package_featured_marked_listings : array ();
			    array_push($dtsl_seller_package_featured_marked_listings, $listing_id);
			    update_user_meta($seller_id,  'dtsl_seller_package_featured_marked_listings', $dtsl_seller_package_featured_marked_listings);

			    update_post_meta($listing_id, 'dtsl_featured_item', 'true');

			    $output .= 'success-add';

			} else if($action_type == 'remove') {

			    $dtsl_seller_package_used_featured_listings_count--;
			    update_user_meta($seller_id, 'dtsl_seller_package_used_featured_listings_count', $dtsl_seller_package_used_featured_listings_count);

				$dtsl_seller_package_featured_marked_listings = get_user_meta($seller_id,  'dtsl_seller_package_featured_marked_listings', true);
				$dtsl_seller_package_featured_marked_listings = (is_array($dtsl_seller_package_featured_marked_listings) && !empty($dtsl_seller_package_featured_marked_listings)) ? $dtsl_seller_package_featured_marked_listings : array();
				if(in_array($listing_id, $dtsl_seller_package_featured_marked_listings)) {
				    unset($dtsl_seller_package_featured_marked_listings[array_search($listing_id, $dtsl_seller_package_featured_marked_listings)]);
				}
				update_user_meta($seller_id,  'dtsl_seller_package_featured_marked_listings', $dtsl_seller_package_featured_marked_listings);

				delete_post_meta($listing_id, 'dtsl_featured_item');

				$output .= 'success-remove';

			} else {

				$output .= 'fail';

			}

		} else if($action_type == 'remove') {

		    $dtsl_seller_package_used_featured_listings_count--;
		    update_user_meta($seller_id, 'dtsl_seller_package_used_featured_listings_count', $dtsl_seller_package_used_featured_listings_count);

			$dtsl_seller_package_featured_marked_listings = get_user_meta($seller_id,  'dtsl_seller_package_featured_marked_listings', true);
			$dtsl_seller_package_featured_marked_listings = (is_array($dtsl_seller_package_featured_marked_listings) && !empty($dtsl_seller_package_featured_marked_listings)) ? $dtsl_seller_package_featured_marked_listings : array();
			if(in_array($listing_id, $dtsl_seller_package_featured_marked_listings)) {
			    unset($dtsl_seller_package_featured_marked_listings[array_search($listing_id, $dtsl_seller_package_featured_marked_listings)]);
			}
			update_user_meta($seller_id,  'dtsl_seller_package_featured_marked_listings', $dtsl_seller_package_featured_marked_listings);

			delete_post_meta($listing_id, 'dtsl_featured_item');

			$output .= 'success-remove';

		} else {

			$output .= 'fail';

		}

		$dtsl_seller_package_featured_listings_count      = get_user_meta($seller_id, 'dtsl_seller_package_featured_listings_count', true);
		$dtsl_seller_package_featured_listings_count      = (isset($dtsl_seller_package_featured_listings_count) && !empty($dtsl_seller_package_featured_listings_count)) ? $dtsl_seller_package_featured_listings_count : 0;
		$dtsl_seller_package_used_featured_listings_count = get_user_meta($seller_id, 'dtsl_seller_package_used_featured_listings_count', true);
		$dtsl_seller_package_used_featured_listings_count = (isset($dtsl_seller_package_used_featured_listings_count) && !empty($dtsl_seller_package_used_featured_listings_count)) ? $dtsl_seller_package_used_featured_listings_count : 0;

		if($dtsl_seller_package_featured_listings_count == -1) {
			$remaining_featured_listings = esc_html__('Unlimited', 'dtsl');
		} else {
			$remaining_featured_listings = ($dtsl_seller_package_featured_listings_count - $dtsl_seller_package_used_featured_listings_count);
		}

		$output .= '|'.$remaining_featured_listings;

	} else {
		$output .= esc_html__('Something went wrong!', 'dtsl');
	}

	echo dtsl_html_output($output);

	die();

}

// Submit listing for approval
add_action( 'wp_ajax_dtsl_dashboard_submit_listing_for_approval', 'dtsl_dashboard_submit_listing_for_approval' );
add_action( 'wp_ajax_nopriv_dtsl_dashboard_submit_listing_for_approval', 'dtsl_dashboard_submit_listing_for_approval' );
function dtsl_dashboard_submit_listing_for_approval() {

	$output = '';

	$listing_id = isset($_REQUEST['listing_id']) ? dtsl_recursive_sanitize_text_field($_REQUEST['listing_id']) : -1;
	$seller_id = isset($_REQUEST['seller_id']) ? dtsl_recursive_sanitize_text_field($_REQUEST['seller_id']) : -1;
	$requires_admin_approval = isset($_REQUEST['requires_admin_approval']) ? dtsl_recursive_sanitize_text_field($_REQUEST['requires_admin_approval']) : 'true';
	$nonce = isset($_REQUEST['nonce']) ? dtsl_recursive_sanitize_text_field($_REQUEST['nonce']) : '';

	if(wp_verify_nonce($nonce, 'dtsl-submit-listing-for-approval-'.$listing_id) && $listing_id > 0 && $seller_id > 0) {

		$dtsl_seller_package_listings_count      = get_user_meta($seller_id, 'dtsl_seller_package_listings_count', true);
		$dtsl_seller_package_listings_count      = (isset($dtsl_seller_package_listings_count) && !empty($dtsl_seller_package_listings_count)) ? $dtsl_seller_package_listings_count : 0;

		$dtsl_seller_package_used_listings_count = get_user_meta($seller_id, 'dtsl_seller_package_used_listings_count', true);
		$dtsl_seller_package_used_listings_count = (isset($dtsl_seller_package_used_listings_count) && !empty($dtsl_seller_package_used_listings_count)) ? $dtsl_seller_package_used_listings_count : 0;

		$dtsl_seller_remaining_listings_count    = ($dtsl_seller_package_listings_count - $dtsl_seller_package_used_listings_count);

		$dtsl_seller_allow_listings = false;
		if($dtsl_seller_package_listings_count == -1) {
			$dtsl_seller_allow_listings = true;
		} else {
			$dtsl_seller_remaining_listings_count = ($dtsl_seller_package_listings_count - $dtsl_seller_package_used_listings_count);
		}


		if($dtsl_seller_remaining_listings_count > 0 || $dtsl_seller_allow_listings) {

		    $dtsl_seller_package_used_listings_count++;
		    update_user_meta($seller_id, 'dtsl_seller_package_used_listings_count', $dtsl_seller_package_used_listings_count);

		    if($requires_admin_approval == 'true') {

				$data = array (
					'ID'           => $listing_id,
					'post_type'    => 'dtsl_listings',
					'post_status'  => 'waitingforapproval',
				);

			} else {

				$data = array (
					'ID'           => $listing_id,
					'post_type'    => 'dtsl_listings',
					'post_status'  => 'publish',
				);

			}

			wp_update_post($data);

		    $output .= 'success';

		} else {

			$output .= 'fail';

		}

		$dtsl_seller_package_listings_count      = get_user_meta($seller_id, 'dtsl_seller_package_listings_count', true);
		$dtsl_seller_package_listings_count      = (isset($dtsl_seller_package_listings_count) && !empty($dtsl_seller_package_listings_count)) ? $dtsl_seller_package_listings_count : 0;

		$dtsl_seller_package_used_listings_count = get_user_meta($seller_id, 'dtsl_seller_package_used_listings_count', true);
		$dtsl_seller_package_used_listings_count = (isset($dtsl_seller_package_used_listings_count) && !empty($dtsl_seller_package_used_listings_count)) ? $dtsl_seller_package_used_listings_count : 0;

		if($dtsl_seller_package_listings_count == -1) {
			$dtsl_seller_remaining_listings_count = esc_html__('Unlimited', 'dtsl');
		} else {
			$dtsl_seller_remaining_listings_count = ($dtsl_seller_package_listings_count - $dtsl_seller_package_used_listings_count);
		}

		$output .= '|'.$dtsl_seller_remaining_listings_count;

	} else {
		$output .= esc_html__('Something went wrong!', 'dtsl');
	}

	echo dtsl_html_output($output);

	die();

}

?>