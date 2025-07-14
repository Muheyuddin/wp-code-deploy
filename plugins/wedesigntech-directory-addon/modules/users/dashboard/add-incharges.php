<?php

function dtdr_dashboard_addincharge_page_content() {

	$output = '';

	$dashboard_page_id = get_the_ID();
	$dtdr_seller_id = get_current_user_id();

	$incharge_singular_label = apply_filters( 'incharge_label', 'singular' );

	$incharge_mode = 'add';

	$dtdr_username = $dtdr_user_email = $dtdr_user_first_name = $dtdr_user_last_name = $dtdr_user_phone = $dtdr_user_mobile = $dtdr_user_skype = $dtdr_user_website = $dtdr_user_specialization = '';

	$user_id = isset($_REQUEST['edit_item_id']) ? $_REQUEST['edit_item_id'] : -1;

	if($user_id > 0) {

		$dtdr_username            =   get_the_author_meta( 'user_login' , $user_id );
		$dtdr_user_email          =   get_the_author_meta( 'user_email' , $user_id );
		$dtdr_user_first_name     =   get_the_author_meta( 'first_name' , $user_id );
		$dtdr_user_last_name      =   get_the_author_meta( 'last_name' , $user_id );
		$dtdr_user_phone          =   get_the_author_meta( 'dtdr_user_phone' , $user_id );
		$dtdr_user_mobile         =   get_the_author_meta( 'dtdr_user_mobile' , $user_id );
		$dtdr_user_skype          =   get_the_author_meta( 'dtdr_user_skype' , $user_id );
		$dtdr_user_website        =   get_the_author_meta( 'dtdr_user_website' , $user_id );
		$dtdr_user_specialization =   get_the_author_meta( 'dtdr_user_specialization' , $user_id );

	    $incharge_mode = 'edit';

	}


	$output .= '<form name="dtdr-dashboard-addincharge-form" method="post" action="" enctype="multipart/form-data" class="dtdr-dashboard-addincharge-form">';

		$username_attr = '';
		if($incharge_mode == 'edit') {
			$username_attr = 'disabled';
		}

		// User Details
		$output .= '<div class="dtdr-dashbord-section-holder">';

			$output .= '<div class="dtdr-dashbord-section-holder-intro">';
				$output .= '<div class="dtdr-dashbord-section-title">'.esc_html__('User Details', 'dtdr').'</div>';
				$output .= '<div class="dtdr-dashbord-section-title-notes">'.esc_html__('Update your profile details.', 'dtdr').'</div>';
			$output .= '</div>';

			$output .= '<div class="dtdr-dashbord-section-holder-content">';

				$output .= '<div class="dtdr-column dtdr-one-half first">';
					$output .= '<p class="dtdr-dashboard-option-item">
					               <label for="dtdr_username">'.esc_html__('User Name', 'dtdr').' *</label>
					               <input type="text" value="'.esc_attr($dtdr_username).'" name="dtdr_username" '.$username_attr.' />
					            </p>';
				$output .= '</div>';
				$output .= '<div class="dtdr-column dtdr-one-half">';
					$output .= '<p class="dtdr-dashboard-option-item">
					               <label for="dtdr_user_email">'.esc_html__('Email', 'dtdr').' *</label>
					               <input type="text" value="'.esc_attr($dtdr_user_email).'" name="dtdr_user_email" />
					            </p>';
				$output .= '</div>';

				$output .= '<div class="dtdr-column dtdr-one-half first">';
					$output .= '<p class="dtdr-dashboard-option-item">
					               <label for="dtdr_user_first_name">'.esc_html__('First Name', 'dtdr').'</label>
					               <input type="text" value="'.esc_attr($dtdr_user_first_name).'" name="dtdr_user_first_name" />
					            </p>';
				$output .= '</div>';
				$output .= '<div class="dtdr-column dtdr-one-half">';
					$output .= '<p class="dtdr-dashboard-option-item">
					               <label for="dtdr_user_last_name">'.esc_html__('Last Name', 'dtdr').'</label>
					               <input type="text" value="'.esc_attr($dtdr_user_last_name).'" name="dtdr_user_last_name" />
					            </p>';
				$output .= '</div>';

				if($incharge_mode == 'edit') {

					$output .= '<div class="dtdr-column dtdr-one-half first">';
						$output .= '<p class="dtdr-dashboard-option-item">
						               <label for="dtdr_user_phone">'.esc_html__('Phone', 'dtdr').'</label>
						               <input type="text" value="'.esc_attr($dtdr_user_phone).'" name="dtdr_user_phone" />
						            </p>';
					$output .= '</div>';
					$output .= '<div class="dtdr-column dtdr-one-half">';
						$output .= '<p class="dtdr-dashboard-option-item">
						               <label for="dtdr_user_mobile">'.esc_html__('Mobile', 'dtdr').'</label>
						               <input type="text" value="'.esc_attr($dtdr_user_mobile).'" name="dtdr_user_mobile" />
						            </p>';
					$output .= '</div>';

					$output .= '<div class="dtdr-column dtdr-one-half first">';
						$output .= '<p class="dtdr-dashboard-option-item">
						               <label for="dtdr_user_skype">'.esc_html__('Skype', 'dtdr').'</label>
						               <input type="text" value="'.esc_attr($dtdr_user_skype).'" name="dtdr_user_skype" />
						            </p>';
					$output .= '</div>';
					$output .= '<div class="dtdr-column dtdr-one-half">';
						$output .= '<p class="dtdr-dashboard-option-item">
						               <label for="dtdr_user_website">'.esc_html__('Website', 'dtdr').'</label>
						               <input type="text" value="'.esc_attr($dtdr_user_website).'" name="dtdr_user_website" />
						            </p>';
					$output .= '</div>';

					$output .= '<div class="dtdr-column dtdr-one-half first">';
						$output .= '<p class="dtdr-dashboard-option-item">
						               <label for="dtdr_user_specialization">'.esc_html__('Specialization', 'dtdr').'</label>
						               <input type="text" value="'.esc_attr($dtdr_user_specialization).'" name="dtdr_user_specialization" />
						            </p>';
					$output .= '</div>';
					$output .= '<div class="dtdr-column dtdr-one-half">';
					$output .= '</div>';

				}

				if($incharge_mode == 'add') {

					$output .= '<div class="dtdr-column dtdr-one-half first">';
						$output .= '<p class="dtdr-dashboard-option-item">
						               <label for="dtdr_user_password">'.esc_html__('Password', 'dtdr').'</label>
						               <input type="password" value="" name="dtdr_user_password" />
						            </p>';
					$output .= '</div>';
					$output .= '<div class="dtdr-column dtdr-one-half">';
					$output .= '</div>';

					$output .= '<div class="dtdr-column dtdr-one-column first">';
						$output .= '<p class="dtdr-dashboard-option-item">
						               <input type="checkbox" value="on" name="dtdr_user_notification" id="dtdr_user_notification" />
						               <label for="dtdr_user_notification">'.sprintf( esc_html__('Send the new %1$s an email about their account.', 'dtdr'), strtolower($incharge_singular_label) ).'</label>
						            </p>';
					$output .= '</div>';

				}

			$output .= '</div>';

		$output .= '</div>';


		if($incharge_mode == 'edit') {

			// User Social Details
			$output .= '<div class="dtdr-dashbord-section-holder">';

				$output .= '<div class="dtdr-dashbord-section-holder-intro">';
					$output .= '<div class="dtdr-dashbord-section-title">'.esc_html__('User Social Details', 'dtdr').'</div>';
					$output .= '<div class="dtdr-dashbord-section-title-notes">'.esc_html__('Update your social details.', 'dtdr').'</div>';
				$output .= '</div>';

				$output .= '<div class="dtdr-dashbord-section-holder-content">';
					$output .= '<p class="dtdr-dashboard-option-item">'.dtdr_social_details_field($user_id, 'user').'</p>';
				$output .= '</div>';

			$output .= '</div>';

			// User Custom Profile Images
			$output .= '<div class="dtdr-dashbord-section-holder">';

				$output .= '<div class="dtdr-dashbord-section-holder-intro">';
					$output .= '<div class="dtdr-dashbord-section-title">'.esc_html__('Custom Profile Image', 'dtdr').'</div>';
					$output .= '<div class="dtdr-dashbord-section-title-notes">'.esc_html__('Upload your profile photo.', 'dtdr').'</div>';
				$output .= '</div>';

				$output .= '<div class="dtdr-dashbord-section-holder-content">';

					$output .= '<div class="dtdr-column dtdr-one-column first">';
						$output .= '<p class="dtdr-dashboard-option-item">'.dtdr_user_profile_picture_field($user_id).'</p>';
					$output .= '</div>';

				$output .= '</div>';

			$output .= '</div>';

		}


		// Notice And Submit form

		$output .= '<div class="dtdr-dashbord-section-holder">';

			$output .= '<div class="dtdr-dashboard-notices"></div>';

			$output .= '<input type="hidden" value="'.get_permalink($dashboard_page_id).'" name="dtdr_dashboard_page_url" class="dtdr_dashboard_page_url" />';

			if($user_id > 0) {
				$output .= '<a class="custom-button-style dtdr-add-incharge-button" onclick="return false;" data-incharge-mode="'.$incharge_mode.'" data-incharge-edit-item-id="'.$user_id.'" data-seller-id="'.$dtdr_seller_id.'">'.sprintf( esc_html__('Update %1$s', 'dtdr'), $incharge_singular_label ).'</a>';
			} else {
				$output .= '<a class="custom-button-style dtdr-add-incharge-button" onclick="return false;" data-incharge-mode="'.$incharge_mode.'" data-incharge-edit-item-id="'.$user_id.'" data-seller-id="'.$dtdr_seller_id.'">'.sprintf( esc_html__('Add %1$s', 'dtdr'), $incharge_singular_label ).'</a>';
			}

		$output .= '</div>';

	$output .= '</form>';

	return $output;

}

function dtdr_dashboard_addincharge_consumed_notices($active_seller_package_id) {

	$output = '';

	$incharge_plural_label = apply_filters( 'incharge_label', 'plural' );

	$output .= '<div class="dtdr-dashbord-section-holder">';
		$output .= '<div class="dtdr-dashbord-section-holder-intro">';
			$output .= '<div class="dtdr-dashbord-section-title">'.esc_html__('Warning!', 'dtdr').'</div>';
		$output .= '</div>';
		$output .= '<div class="dtdr-dashbord-section-holder-content">';
			$output .= '<div class="dtdr-warning-notice">';
				$output .= '<p>'.sprintf(esc_html__('You have consumed all your allowed %1$s from %2$s package', 'dtdr'), strtolower($incharge_plural_label), '<strong>'.get_the_title($active_seller_package_id).'</strong>').'</p>';
			$output .= '</div>';
		$output .= '</div>';
	$output .= '</div>';

	return $output;

}

function dtdr_dashboard_addincharge_expired_notices($active_seller_package_id) {

	$output = '';

	$output .= '<div class="dtdr-dashbord-section-holder">';
		$output .= '<div class="dtdr-dashbord-section-holder-intro">';
			$output .= '<div class="dtdr-dashbord-section-title">'.esc_html__('Warning!', 'dtdr').'</div>';
		$output .= '</div>';
		$output .= '<div class="dtdr-dashbord-section-holder-content">';
			$output .= '<div class="dtdr-warning-notice">';
				$output .= '<p>'.sprintf(esc_html__('Your package %1$s have been expired', 'dtdr'), '<strong>'.get_the_title($active_seller_package_id).'</strong>').'</p>';
			$output .= '</div>';
		$output .= '</div>';
	$output .= '</div>';

	return $output;

}

function dtdr_dashboard_addincharge_purchasepackage_notices() {

	$output = '';

	$incharge_plural_label = apply_filters( 'incharge_label', 'plural' );

	$seller_purchase_package_shortcode = dtdr_option('general','seller-purchase-package-shortcode');

	$output .= '<div class="dtdr-dashbord-section-holder">';
		$output .= '<div class="dtdr-dashbord-section-holder-intro">';
			$output .= '<div class="dtdr-dashbord-section-title">'.esc_html__('Available Packages', 'dtdr').'</div>';
			$output .= '<div class="dtdr-dashbord-section-title-notes">'.sprintf( esc_html__( 'Please purchase any of the available packages to add your %1$s', 'dtdr' ), strtolower($incharge_plural_label) ).'</div>';
		$output .= '</div>';
		$output .= '<div class="dtdr-dashbord-section-holder-content">';
			if($seller_purchase_package_shortcode != '') {
				$output .= do_shortcode($seller_purchase_package_shortcode);
			} else {
				$output .= '<div class="dtdr-warning-notice">';
					$output .= '<p>'.esc_html__('No packages available right now', 'dtdr').'</p>';
				$output .= '</div>';
			}
		$output .= '</div>';
	$output .= '</div>';

	return $output;

}

// Add incharge
add_action( 'wp_ajax_dtdr_dashboard_addincharge_profile', 'dtdr_dashboard_addincharge_profile' );
add_action( 'wp_ajax_nopriv_dtdr_dashboard_addincharge_profile', 'dtdr_dashboard_addincharge_profile' );
function dtdr_dashboard_addincharge_profile() {

	extract(dtdr_recursive_sanitize_text_field($_REQUEST));


	$has_error = false;
	$errors = array ();


    // Update user profile

	if($incharge_mode == 'edit' && $incharge_id > 0) {

		if($dtdr_user_email == '') {
			$has_error = true;
			$errors[] = '<p>'.esc_html__('Email field is empty.', 'dtdr').'</p>';
		} else if(email_exists($dtdr_user_email)) {
			if(email_exists($dtdr_user_email) != $incharge_id) {
				$has_error = true;
				$errors[] = '<p>'.esc_html__('Email have been taken already by another user.', 'dtdr').'</p>';
			}
	    }

	    if($has_error) {

	    	echo json_encode($errors);
	    	die();

	    }

	    update_user_meta( $incharge_id, 'user_email', sanitize_text_field($dtdr_user_email));
        update_user_meta( $incharge_id, 'first_name', sanitize_text_field($dtdr_user_first_name));
        update_user_meta( $incharge_id, 'last_name', sanitize_text_field($dtdr_user_last_name));
        update_user_meta( $incharge_id, 'dtdr_user_phone', sanitize_text_field($dtdr_user_phone));
        update_user_meta( $incharge_id, 'dtdr_user_mobile', sanitize_text_field($dtdr_user_mobile));
        update_user_meta( $incharge_id, 'dtdr_user_skype', sanitize_text_field($dtdr_user_skype));
        update_user_meta( $incharge_id, 'dtdr_user_website', sanitize_text_field($dtdr_user_website));
        update_user_meta( $incharge_id, 'dtdr_user_specialization', sanitize_text_field($dtdr_user_specialization));

        update_user_meta( $incharge_id, 'dtdr_user_social_items', $dtdr_social_items );
        update_user_meta( $incharge_id, 'dtdr_user_social_items_value', $dtdr_social_items_value );

        update_user_meta( $incharge_id, 'dtdr_user_profile_image', $dtdr_user_profile_image );

		echo 'success';

		die();

	} else {

		if($dtdr_username == '') {
			$has_error = true;
			$errors[] = '<p>'.esc_html__('Username field is empty.', 'dtdr').'</p>';
		} else if(username_exists($dtdr_username)) {
			$has_error = true;
			$errors[] = '<p>'.esc_html__('Username have been taken already by another user.', 'dtdr').'</p>';
	    }

		if($dtdr_user_email == '') {
			$has_error = true;
			$errors[] = '<p>'.esc_html__('Email field is empty.', 'dtdr').'</p>';
		} else if(email_exists($dtdr_user_email)) {
			$has_error = true;
			$errors[] = '<p>'.esc_html__('Email have been taken already by another user.', 'dtdr').'</p>';
	    }

	    if($has_error) {

	    	echo json_encode($errors);
	    	die();

	    }


    	$user_id = wp_create_user( $dtdr_username, $dtdr_user_password, $dtdr_user_email );

    	if(is_wp_error($user_id)) {

			echo json_encode( array (
				'<p>'.esc_html__('Something went wrong! please try again.', 'dtdr').'</p>'
			) );

			die();

    	} else {

	        $args = array (
				'ID'         => $user_id,
				'first_name' => sanitize_text_field($dtdr_user_first_name),
				'last_name'  => sanitize_text_field($dtdr_user_last_name),
				'role'       => 'incharge'
	        );
	        wp_update_user($args);

	        update_user_meta( $user_id, 'user_seller', $seller_id );


			// Send Notification

			# To Admin
			wp_new_user_notification( $user_id, null, 'admin' );

			# To User
			if( $dtdr_user_notification == 'on' ) {
				wp_new_user_notification( $user_id, null, 'user' );
			}


			// Activate incharge

	    	if('true' ==  dtdr_option('general', 'should-admin-approve-incharges')) {
	    		update_user_meta( $user_id, 'dtdr_user_status', 'waitingforapproval' );
	    	} else {
	    		update_user_meta( $user_id, 'dtdr_user_status', 'active' );
	    	}


	        // Package details

		    $dtdr_seller_package_used_incharges_count = get_user_meta($seller_id, 'dtdr_seller_package_used_incharges_count', true);
		    $dtdr_seller_package_used_incharges_count++;
		    update_user_meta($seller_id, 'dtdr_seller_package_used_incharges_count', $dtdr_seller_package_used_incharges_count);


			echo 'success';

			die();

    	}

    }


	die();

}

?>