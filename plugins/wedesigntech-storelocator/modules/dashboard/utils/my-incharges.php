<?php

function dtsl_dashboard_myincharges_page_content() {

	$output = '';

	$output .= '<div class="dtsl-my-incharges-container">';

		$output .= '<div class="dtsl-my-incharges-item-holder">';

			$output .= dtsl_dashboard_myincharges_items_ajax_content();

		$output .= '</div>';

	$output .= '</div>';


	return $output;

}

add_action( 'wp_ajax_dtsl_dashboard_myincharges_items_ajax_content', 'dtsl_dashboard_myincharges_items_ajax_content' );
add_action( 'wp_ajax_nopriv_dtsl_dashboard_myincharges_items_ajax_content', 'dtsl_dashboard_myincharges_items_ajax_content' );
function dtsl_dashboard_myincharges_items_ajax_content() {

	$output = '';


	// Pagination script Start
	$ajax_call = (isset($_REQUEST['ajax_call']) && $_REQUEST['ajax_call'] == true) ? true : false;
	$current_page = isset($_REQUEST['current_page']) ? dtsl_recursive_sanitize_text_field($_REQUEST['current_page']) : 1;
	$offset = isset($_REQUEST['offset']) ? dtsl_recursive_sanitize_text_field($_REQUEST['offset']) : 0;
	$frontend_postperpage = dtsl_option('general','frontend-postperpage');
	$post_per_page = isset($_REQUEST['post_per_page']) ? dtsl_recursive_sanitize_text_field($_REQUEST['post_per_page']) : dtsl_recursive_sanitize_text_field($frontend_postperpage);

	$function_call = (isset($_REQUEST['function_call']) && $_REQUEST['function_call'] != '') ? dtsl_recursive_sanitize_text_field($_REQUEST['function_call']) : 'dtsl_dashboard_myincharges_items_ajax_content';
	$output_div = (isset($_REQUEST['output_div']) && $_REQUEST['output_div'] != '') ? dtsl_recursive_sanitize_text_field($_REQUEST['output_div']) : 'dtsl-my-incharges-item-holder';

	$dashboard_page_id = get_the_ID();
	$dashboard_page_id = (isset($_REQUEST['dashboard_page_id']) && $_REQUEST['dashboard_page_id'] != '') ? dtsl_recursive_sanitize_text_field($_REQUEST['dashboard_page_id']) : $dashboard_page_id;
	// Pagination script End

	$listing_plural_label = apply_filters( 'dt_sl_listing_label', 'plural' );
	$incharge_singular_label = apply_filters( 'dt_sl_incharge_label', 'singular' );


	$seller_id = get_current_user_id();
	$incharges = get_users ( array ('role' => 'incharge', 'meta_key' => 'user_seller', 'meta_value' => $seller_id, 'offset' => $offset, 'number' => $post_per_page) );

	if(is_array($incharges) && !empty($incharges)) {

		$output .= '<div class="dtsl-dashboard-notices"></div>';

		$output .= '<table class="dtsl-my-incharges-table">
						<thead>
							<tr>
								<th class="dtsl-incharge-thumbnail">&nbsp;</th>
								<th class="dtsl-incharge-name">'.sprintf( esc_html__( '%1$s', 'dtsl' ), $incharge_singular_label ).'</th>
								<th class="dtsl-incharge-email">'.esc_html__('Email', 'dtsl').'</th>
								<th class="dtsl-incharge-listings">'.sprintf( esc_html__( '%1$s', 'dtsl' ), $listing_plural_label ).'</th>
								<th class="dtsl-incharge-phone">'.esc_html__('Phone', 'dtsl').'</th>
								<th class="dtsl-incharge-mobile">'.esc_html__('Mobile', 'dtsl').'</th>
								<th class="dtsl-incharge-status">'.esc_html__('Status', 'dtsl').'</th>
								<th class="dtsl-incharge-option">'.esc_html__('Options', 'dtsl').'</th>
							</tr>
						</thead>
						<tbody>';

		foreach ( $incharges as $incharge ) {
			setup_postdata( $incharge );

			$incharge_id = $incharge->data->ID;

			$edit_item_url = esc_url_raw ( add_query_arg( array (
									    'type' => 'addincharge',
									    'edit_item_id' => $incharge_id,
									), get_permalink($dashboard_page_id) ));

			$incharge_posts_url = get_author_posts_url( $incharge_id );

			$user_status = '';
			$dtsl_user_status = get_user_meta( $incharge_id, 'dtsl_user_status', true );
			if($dtsl_user_status == 'disabled') {
				$user_status = esc_html__('Disabled', 'dtsl');
			} else if($dtsl_user_status == 'active') {
				$user_status = esc_html__('Active', 'dtsl');
			} else if($dtsl_user_status == 'waitingforapproval') {
				$user_status = esc_html__('Waiting For Approval', 'dtsl');
			}

			$seller_id = get_user_meta( $incharge_id, 'user_seller', true );

            $output .= '<tr>';

	            $output .= '<td class="dtsl-incharge-thumbnail">';
					$dtsl_user_profile_image = get_the_author_meta( 'dtsl_user_profile_image' , $incharge_id );

					$image_url = wp_get_attachment_image_src($dtsl_user_profile_image, 'thumbnail');
					$profile_image = $image_url[0];

					if(!empty($profile_image)) {
						$output .= dtsl_adminpanel_image_holder($profile_image);
					}
	            $output .= '</td>';

            	$output .= '<td class="dtsl-incharge-name">';
            		$output .= esc_html($incharge->data->display_name);
            	$output .= '</td>';

            	$output .= '<td class="dtsl-incharge-email">'.esc_html($incharge->data->user_email).'</td>';
            	$output .= '<td class="dtsl-incharge-listings">'.count_user_posts( $incharge_id, 'dtsl_listings' ).'</td>';
            	$output .= '<td class="dtsl-incharge-phone">'.get_the_author_meta( 'dtsl_user_phone', $incharge_id).'</td>';
            	$output .= '<td class="dtsl-incharge-mobile">'.get_the_author_meta( 'dtsl_user_mobile', $incharge_id).'</td>';
            	$output .= '<td class="dtsl-incharge-status">'.$user_status.'</td>';
            	$output .= '<td class="dtsl-incharge-option">';

            			if($dtsl_user_status != 'disabled') {

	                		$output .= '<a data-tooltip="'.sprintf( esc_html__( 'Edit %1$s', 'dtsl' ), $incharge_singular_label ).'" href="'.esc_url($edit_item_url).'">
			                				<i class="far fa-edit"></i>
			                			</a>';

			                $output .= '<a data-tooltip="'.sprintf( esc_html__( 'Delete %1$s', 'dtsl' ), $incharge_singular_label ).'" class="dtsl-remove-incharge" data-nonce="'.wp_create_nonce('dtsl-delete-incharge-'. $incharge_id ).'"  data-seller-id="'.esc_attr($seller_id).'" data-incharge-id="'.esc_attr($incharge_id).'" data-dashboard-page-url="'.esc_url(get_permalink($dashboard_page_id)).'">
			                				<i class="far fa-times-circle"></i>
			                			</a>';

	            			if($incharge_posts_url) {

		                		$output .= '<a data-tooltip="'.sprintf( esc_html__( 'View %1$s', 'dtsl' ), $incharge_singular_label ).'" href="'.esc_url($incharge_posts_url).'">
				                				<i class="far fa-eye"></i>
				                			</a>';

	            			}

	            		}

		                if(function_exists('dtsl_check_user_seller_package_is_active') && dtsl_check_user_seller_package_is_active($seller_id, -1)) {

		            		$requires_admin_approval = 'false';
		            		$approve_incharge_tooltip = sprintf( esc_html__( 'Activate %1$s', 'dtsl' ), $incharge_singular_label );
		            		if('true' == dtsl_option('general', 'should-admin-approve-incharges')) {
		            			$requires_admin_approval = 'true';
		            			$approve_incharge_tooltip = esc_html__('Submit For Approval', 'dtsl');
		            		}

			                if($dtsl_user_status == 'disabled') {

			                	$output .= '<a class="dtsl-dashboard-activate-disabled-incharge" data-tooltip="'.esc_html($approve_incharge_tooltip).'" href="#" onclick="return false;" data-seller-id="'.esc_attr($seller_id).'" data-incharge-id="'.esc_attr($incharge_id).'" data-requires-admin-approval="'.esc_attr($requires_admin_approval).'" data-nonce="'.wp_create_nonce('dtsl-submit-incharge-for-approval-'. $incharge_id ).'"><i class="fas fa-share-square"></i></a>';

			                }

			            }


            	$output .= '</td>';

            $output .= '</tr>';

		}

		$output .= '</tbody>
				</table>';

	} else {

		$output .= '<div class="dtsl-dashboard-notices dtsl-info-notice">'.esc_html__('No records found!', 'dtsl').'</div>';

	}


	// Pagination script Start

	$total_incharges = get_users ( array ('role' => 'incharge', 'meta_key' => 'user_seller', 'meta_value' => $seller_id ) );

	$incharges_count = count($total_incharges);
	$max_num_pages = ceil($incharges_count / $post_per_page);

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

// Remove seller incharges
add_action( 'wp_ajax_dtsl_remove_seller_incharge', 'dtsl_remove_seller_incharge' );
add_action( 'wp_ajax_nopriv_dtsl_remove_seller_incharge', 'dtsl_remove_seller_incharge' );
function dtsl_remove_seller_incharge() {

	extract(dtsl_recursive_sanitize_text_field($_REQUEST));

	$has_error = false;
	$errors = array ();

	if(wp_verify_nonce($nonce, 'dtsl-delete-incharge-'.$incharge_id)) {

		$incharges = get_users ( array ('role' => 'incharge', 'meta_key' => 'user_seller', 'meta_value' => $seller_id, 'include' => array ($incharge_id) ) );

		if(!empty($incharges)) {

			$return = wp_delete_user($incharge_id, $seller_id);

			if($return) {

				echo 'success';

			} else {

				$has_error = true;
				$errors[] = '<p>'.esc_html__('Something went wrong!, Please try again.', 'dtsl').'</p>';

			}

		}

	}

    if($has_error) {
    	echo json_encode($errors);
    }


	die();

}

// Activate disabled incharge
add_action( 'wp_ajax_dtsl_dashboard_activate_disabled_incharge', 'dtsl_dashboard_activate_disabled_incharge' );
add_action( 'wp_ajax_nopriv_dtsl_dashboard_activate_disabled_incharge', 'dtsl_dashboard_activate_disabled_incharge' );
function dtsl_dashboard_activate_disabled_incharge() {

	$output = '';

	$incharge_id = isset($_REQUEST['incharge_id']) ? dtsl_recursive_sanitize_text_field($_REQUEST['incharge_id']) : -1;
	$seller_id = isset($_REQUEST['seller_id']) ? dtsl_recursive_sanitize_text_field($_REQUEST['seller_id']) : -1;
	$requires_admin_approval = isset($_REQUEST['requires_admin_approval']) ? dtsl_recursive_sanitize_text_field($_REQUEST['requires_admin_approval']) : 'true';
	$nonce = isset($_REQUEST['nonce']) ? dtsl_recursive_sanitize_text_field($_REQUEST['nonce']) : '';

	if(wp_verify_nonce($nonce, 'dtsl-submit-incharge-for-approval-'.$incharge_id) && $incharge_id > 0 && $seller_id > 0) {

		$dtsl_seller_package_incharges_count      = get_user_meta($seller_id, 'dtsl_seller_package_incharges_count', true);
		$dtsl_seller_package_incharges_count      = (isset($dtsl_seller_package_incharges_count) && !empty($dtsl_seller_package_incharges_count)) ? $dtsl_seller_package_incharges_count : 0;

		$dtsl_seller_package_used_incharges_count = get_user_meta($seller_id, 'dtsl_seller_package_used_incharges_count', true);
		$dtsl_seller_package_used_incharges_count = (isset($dtsl_seller_package_used_incharges_count) && !empty($dtsl_seller_package_used_incharges_count)) ? $dtsl_seller_package_used_incharges_count : 0;

		$dtsl_seller_allow_incharges = false;
		if($dtsl_seller_package_incharges_count == -1) {
			$dtsl_seller_allow_incharges = true;
		} else {
			$dtsl_seller_remaining_incharges_count = ($dtsl_seller_package_incharges_count - $dtsl_seller_package_used_incharges_count);
		}

		if($dtsl_seller_remaining_incharges_count > 0 || $dtsl_seller_allow_incharges) {

		    $dtsl_seller_package_used_incharges_count++;
		    update_user_meta($seller_id, 'dtsl_seller_package_used_incharges_count', $dtsl_seller_package_used_incharges_count);

		    if($requires_admin_approval == 'true') {

				update_user_meta($incharge_id, 'dtsl_user_status', 'waitingforapproval' );

			} else {

				update_user_meta($incharge_id, 'dtsl_user_status', 'active' );

			}

		    $output .= 'success';

		} else {

			$output .= 'fail';

		}

		$dtsl_seller_package_incharges_count      = get_user_meta($seller_id, 'dtsl_seller_package_incharges_count', true);
		$dtsl_seller_package_incharges_count      = (isset($dtsl_seller_package_incharges_count) && !empty($dtsl_seller_package_incharges_count)) ? $dtsl_seller_package_incharges_count : 0;

		$dtsl_seller_package_used_incharges_count = get_user_meta($seller_id, 'dtsl_seller_package_used_incharges_count', true);
		$dtsl_seller_package_used_incharges_count = (isset($dtsl_seller_package_used_incharges_count) && !empty($dtsl_seller_package_used_incharges_count)) ? $dtsl_seller_package_used_incharges_count : 0;

		if($dtsl_seller_package_incharges_count == -1) {
			$dtsl_seller_remaining_incharges_count = esc_html__('Unlimited', 'dtsl');
		} else {
			$dtsl_seller_remaining_incharges_count = ($dtsl_seller_package_incharges_count - $dtsl_seller_package_used_incharges_count);
		}

		$output .= '|'.$dtsl_seller_remaining_incharges_count;

	} else {
		$output .= esc_html__('Something went wrong!', 'dtsl');
	}

	echo dtsl_html_output($output);

	die();

}

?>