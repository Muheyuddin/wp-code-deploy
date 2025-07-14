<?php

function dtsl_dashboard_addincharge_page_content() {

	$output = '';

	$dashboard_page_id = get_the_ID();
	$dtsl_seller_id = get_current_user_id();

	$incharge_singular_label = apply_filters( 'dt_sl_incharge_label', 'singular' );

	$incharge_mode = 'add';

	$dtsl_username = $dtsl_user_email = $dtsl_user_first_name = $dtsl_user_last_name = $dtsl_user_phone = $dtsl_user_mobile = $dtsl_user_skype = $dtsl_user_website = $dtsl_user_specialization = '';

	$user_id = isset($_REQUEST['edit_item_id']) ? dtsl_recursive_sanitize_text_field($_REQUEST['edit_item_id']) : -1;

	if($user_id > 0) {

		$dtsl_username            =   get_the_author_meta( 'user_login' , $user_id );
		$dtsl_user_email          =   get_the_author_meta( 'user_email' , $user_id );
		$dtsl_user_first_name     =   get_the_author_meta( 'first_name' , $user_id );
		$dtsl_user_last_name      =   get_the_author_meta( 'last_name' , $user_id );
		$dtsl_user_phone          =   get_the_author_meta( 'dtsl_user_phone' , $user_id );
		$dtsl_user_mobile         =   get_the_author_meta( 'dtsl_user_mobile' , $user_id );
		$dtsl_user_skype          =   get_the_author_meta( 'dtsl_user_skype' , $user_id );
		$dtsl_user_website        =   get_the_author_meta( 'dtsl_user_website' , $user_id );
		$dtsl_user_specialization =   get_the_author_meta( 'dtsl_user_specialization' , $user_id );

	    $incharge_mode = 'edit';

	}


	$output .= '<form name="dtsl-dashboard-addincharge-form" method="post" action="" enctype="multipart/form-data" class="dtsl-dashboard-addincharge-form">';

		$username_attr = '';
		if($incharge_mode == 'edit') {
			$username_attr = 'disabled';
		}

		// User Details
		$output .= '<div class="dtsl-dashbord-section-holder">';

			$output .= '<div class="dtsl-dashbord-section-holder-intro">';
				$output .= '<div class="dtsl-dashbord-section-title">'.esc_html__('User Details', 'dtsl').'</div>';
				$output .= '<div class="dtsl-dashbord-section-title-notes">'.esc_html__('Update your profile details.', 'dtsl').'</div>';
			$output .= '</div>';

			$output .= '<div class="dtsl-dashbord-section-holder-content">';

				$output .= '<div class="dtsl-column dtsl-one-half first">';
					$output .= '<p class="dtsl-dashboard-option-item">
					               <label for="dtsl_username">'.esc_html__('User Name', 'dtsl').' *</label>
					               <input type="text" value="'.esc_attr($dtsl_username).'" name="dtsl_username" '.$username_attr.' />
					            </p>';
				$output .= '</div>';
				$output .= '<div class="dtsl-column dtsl-one-half">';
					$output .= '<p class="dtsl-dashboard-option-item">
					               <label for="dtsl_user_email">'.esc_html__('Email', 'dtsl').' *</label>
					               <input type="text" value="'.esc_attr($dtsl_user_email).'" name="dtsl_user_email" />
					            </p>';
				$output .= '</div>';

				$output .= '<div class="dtsl-column dtsl-one-half first">';
					$output .= '<p class="dtsl-dashboard-option-item">
					               <label for="dtsl_user_first_name">'.esc_html__('First Name', 'dtsl').'</label>
					               <input type="text" value="'.esc_attr($dtsl_user_first_name).'" name="dtsl_user_first_name" />
					            </p>';
				$output .= '</div>';
				$output .= '<div class="dtsl-column dtsl-one-half">';
					$output .= '<p class="dtsl-dashboard-option-item">
					               <label for="dtsl_user_last_name">'.esc_html__('Last Name', 'dtsl').'</label>
					               <input type="text" value="'.esc_attr($dtsl_user_last_name).'" name="dtsl_user_last_name" />
					            </p>';
				$output .= '</div>';

				if($incharge_mode == 'edit') {

					$output .= '<div class="dtsl-column dtsl-one-half first">';
						$output .= '<p class="dtsl-dashboard-option-item">
						               <label for="dtsl_user_phone">'.esc_html__('Phone', 'dtsl').'</label>
						               <input type="text" value="'.esc_attr($dtsl_user_phone).'" name="dtsl_user_phone" />
						            </p>';
					$output .= '</div>';
					$output .= '<div class="dtsl-column dtsl-one-half">';
						$output .= '<p class="dtsl-dashboard-option-item">
						               <label for="dtsl_user_mobile">'.esc_html__('Mobile', 'dtsl').'</label>
						               <input type="text" value="'.esc_attr($dtsl_user_mobile).'" name="dtsl_user_mobile" />
						            </p>';
					$output .= '</div>';

					$output .= '<div class="dtsl-column dtsl-one-half first">';
						$output .= '<p class="dtsl-dashboard-option-item">
						               <label for="dtsl_user_skype">'.esc_html__('Skype', 'dtsl').'</label>
						               <input type="text" value="'.esc_attr($dtsl_user_skype).'" name="dtsl_user_skype" />
						            </p>';
					$output .= '</div>';
					$output .= '<div class="dtsl-column dtsl-one-half">';
						$output .= '<p class="dtsl-dashboard-option-item">
						               <label for="dtsl_user_website">'.esc_html__('Website', 'dtsl').'</label>
						               <input type="text" value="'.esc_attr($dtsl_user_website).'" name="dtsl_user_website" />
						            </p>';
					$output .= '</div>';

					$output .= '<div class="dtsl-column dtsl-one-half first">';
						$output .= '<p class="dtsl-dashboard-option-item">
						               <label for="dtsl_user_specialization">'.esc_html__('Specialization', 'dtsl').'</label>
						               <input type="text" value="'.esc_attr($dtsl_user_specialization).'" name="dtsl_user_specialization" />
						            </p>';
					$output .= '</div>';
					$output .= '<div class="dtsl-column dtsl-one-half">';
					$output .= '</div>';

				}

				if($incharge_mode == 'add') {

					$output .= '<div class="dtsl-column dtsl-one-half first">';
						$output .= '<p class="dtsl-dashboard-option-item">
						               <label for="dtsl_user_password">'.esc_html__('Password', 'dtsl').'</label>
						               <input type="password" value="" name="dtsl_user_password" />
						            </p>';
					$output .= '</div>';
					$output .= '<div class="dtsl-column dtsl-one-half">';
					$output .= '</div>';

					$output .= '<div class="dtsl-column dtsl-one-column first">';
						$output .= '<p class="dtsl-dashboard-option-item">
						               <input type="checkbox" value="on" name="dtsl_user_notification" id="dtsl_user_notification" />
						               <label for="dtsl_user_notification">'.sprintf( esc_html__('Send the new %1$s an email about their account.', 'dtsl'), strtolower($incharge_singular_label) ).'</label>
						            </p>';
					$output .= '</div>';

				}

			$output .= '</div>';

		$output .= '</div>';


		if($incharge_mode == 'edit') {

			// User Social Details
			$output .= '<div class="dtsl-dashbord-section-holder">';

				$output .= '<div class="dtsl-dashbord-section-holder-intro">';
					$output .= '<div class="dtsl-dashbord-section-title">'.esc_html__('User Social Details', 'dtsl').'</div>';
					$output .= '<div class="dtsl-dashbord-section-title-notes">'.esc_html__('Update your social details.', 'dtsl').'</div>';
				$output .= '</div>';

				$output .= '<div class="dtsl-dashbord-section-holder-content">';
					$output .= '<p class="dtsl-dashboard-option-item">'.dtsl_social_details_field($user_id, 'user').'</p>';
				$output .= '</div>';

			$output .= '</div>';

			// User Custom Profile Images
			$output .= '<div class="dtsl-dashbord-section-holder">';

				$output .= '<div class="dtsl-dashbord-section-holder-intro">';
					$output .= '<div class="dtsl-dashbord-section-title">'.esc_html__('Custom Profile Image', 'dtsl').'</div>';
					$output .= '<div class="dtsl-dashbord-section-title-notes">'.esc_html__('Upload your profile photo.', 'dtsl').'</div>';
				$output .= '</div>';

				$output .= '<div class="dtsl-dashbord-section-holder-content">';

					$output .= '<div class="dtsl-column dtsl-one-column first">';
						$output .= '<p class="dtsl-dashboard-option-item">'.dtsl_user_profile_picture_field($user_id).'</p>';
					$output .= '</div>';

				$output .= '</div>';

			$output .= '</div>';

		}


		// Notice And Submit form

		$output .= '<div class="dtsl-dashbord-section-holder">';

			$output .= '<div class="dtsl-dashboard-notices"></div>';

			$output .= '<input type="hidden" value="'.get_permalink($dashboard_page_id).'" name="dtsl_dashboard_page_url" class="dtsl_dashboard_page_url" />';

			if($user_id > 0) {
				$output .= '<a class="custom-button-style dtsl-add-incharge-button" onclick="return false;" data-incharge-mode="'.$incharge_mode.'" data-incharge-edit-item-id="'.$user_id.'" data-seller-id="'.$dtsl_seller_id.'">'.sprintf( esc_html__('Update %1$s', 'dtsl'), $incharge_singular_label ).'</a>';
			} else {
				$output .= '<a class="custom-button-style dtsl-add-incharge-button" onclick="return false;" data-incharge-mode="'.$incharge_mode.'" data-incharge-edit-item-id="'.$user_id.'" data-seller-id="'.$dtsl_seller_id.'">'.sprintf( esc_html__('Add %1$s', 'dtsl'), $incharge_singular_label ).'</a>';
			}

		$output .= '</div>';

	$output .= '</form>';

	return $output;

}

function dtsl_dashboard_addincharge_consumed_notices($active_seller_package_id) {

	$output = '';

	$incharge_plural_label = apply_filters( 'dt_sl_incharge_label', 'plural' );

	$output .= '<div class="dtsl-dashbord-section-holder">';
		$output .= '<div class="dtsl-dashbord-section-holder-intro">';
			$output .= '<div class="dtsl-dashbord-section-title">'.esc_html__('Warning!', 'dtsl').'</div>';
		$output .= '</div>';
		$output .= '<div class="dtsl-dashbord-section-holder-content">';
			$output .= '<div class="dtsl-warning-notice">';
				$output .= '<p>'.sprintf(esc_html__('You have consumed all your allowed %1$s from %2$s package', 'dtsl'), strtolower($incharge_plural_label), '<strong>'.get_the_title($active_seller_package_id).'</strong>').'</p>';
			$output .= '</div>';
		$output .= '</div>';
	$output .= '</div>';

	return $output;

}

function dtsl_dashboard_addincharge_expired_notices($active_seller_package_id) {

	$output = '';

	$output .= '<div class="dtsl-dashbord-section-holder">';
		$output .= '<div class="dtsl-dashbord-section-holder-intro">';
			$output .= '<div class="dtsl-dashbord-section-title">'.esc_html__('Warning!', 'dtsl').'</div>';
		$output .= '</div>';
		$output .= '<div class="dtsl-dashbord-section-holder-content">';
			$output .= '<div class="dtsl-warning-notice">';
				$output .= '<p>'.sprintf(esc_html__('Your package %1$s have been expired', 'dtsl'), '<strong>'.get_the_title($active_seller_package_id).'</strong>').'</p>';
			$output .= '</div>';
		$output .= '</div>';
	$output .= '</div>';

	return $output;

}

function dtsl_dashboard_addincharge_purchasepackage_notices() {

	$output = '';

	$incharge_plural_label = apply_filters( 'dt_sl_incharge_label', 'plural' );

	$seller_purchase_package_shortcode = dtsl_option('general','seller-purchase-package-shortcode');

	$output .= '<div class="dtsl-dashbord-section-holder">';
		$output .= '<div class="dtsl-dashbord-section-holder-intro">';
			$output .= '<div class="dtsl-dashbord-section-title">'.esc_html__('Available Packages', 'dtsl').'</div>';
			$output .= '<div class="dtsl-dashbord-section-title-notes">'.sprintf( esc_html__( 'Please purchase any of the available packages to add your %1$s', 'dtsl' ), strtolower($incharge_plural_label) ).'</div>';
		$output .= '</div>';
		$output .= '<div class="dtsl-dashbord-section-holder-content">';
			if($seller_purchase_package_shortcode != '') {
				$output .= do_shortcode($seller_purchase_package_shortcode);
			} else {
				$output .= '<div class="dtsl-warning-notice">';
					$output .= '<p>'.esc_html__('No packages available right now', 'dtsl').'</p>';
				$output .= '</div>';
			}
		$output .= '</div>';
	$output .= '</div>';

	return $output;

}

// Add incharge
add_action( 'wp_ajax_dtsl_dashboard_addincharge_profile', 'dtsl_dashboard_addincharge_profile' );
add_action( 'wp_ajax_nopriv_dtsl_dashboard_addincharge_profile', 'dtsl_dashboard_addincharge_profile' );
function dtsl_dashboard_addincharge_profile() {

	extract(dtsl_recursive_sanitize_text_field($_REQUEST));


	$has_error = false;
	$errors = array ();


    // Update user profile

	if($incharge_mode == 'edit' && $incharge_id > 0) {

		if($dtsl_user_email == '') {
			$has_error = true;
			$errors[] = '<p>'.esc_html__('Email field is empty.', 'dtsl').'</p>';
		} else if(email_exists($dtsl_user_email)) {
			if(email_exists($dtsl_user_email) != $incharge_id) {
				$has_error = true;
				$errors[] = '<p>'.esc_html__('Email have been taken already by another user.', 'dtsl').'</p>';
			}
	    }

	    if($has_error) {

	    	echo json_encode($errors);
	    	die();

	    }

	    update_user_meta( $incharge_id, 'user_email', sanitize_text_field($dtsl_user_email));
        update_user_meta( $incharge_id, 'first_name', sanitize_text_field($dtsl_user_first_name));
        update_user_meta( $incharge_id, 'last_name', sanitize_text_field($dtsl_user_last_name));
        update_user_meta( $incharge_id, 'dtsl_user_phone', sanitize_text_field($dtsl_user_phone));
        update_user_meta( $incharge_id, 'dtsl_user_mobile', sanitize_text_field($dtsl_user_mobile));
        update_user_meta( $incharge_id, 'dtsl_user_skype', sanitize_text_field($dtsl_user_skype));
        update_user_meta( $incharge_id, 'dtsl_user_website', sanitize_text_field($dtsl_user_website));
        update_user_meta( $incharge_id, 'dtsl_user_specialization', sanitize_text_field($dtsl_user_specialization));

        update_user_meta( $incharge_id, 'dtsl_user_social_items', $dtsl_social_items );
        update_user_meta( $incharge_id, 'dtsl_user_social_items_value', $dtsl_social_items_value );

        update_user_meta( $incharge_id, 'dtsl_user_profile_image', $dtsl_user_profile_image );

		echo 'success';

		die();

	} else {

		if($dtsl_username == '') {
			$has_error = true;
			$errors[] = '<p>'.esc_html__('Username field is empty.', 'dtsl').'</p>';
		} else if(username_exists($dtsl_username)) {
			$has_error = true;
			$errors[] = '<p>'.esc_html__('Username have been taken already by another user.', 'dtsl').'</p>';
	    }

		if($dtsl_user_email == '') {
			$has_error = true;
			$errors[] = '<p>'.esc_html__('Email field is empty.', 'dtsl').'</p>';
		} else if(email_exists($dtsl_user_email)) {
			$has_error = true;
			$errors[] = '<p>'.esc_html__('Email have been taken already by another user.', 'dtsl').'</p>';
	    }

	    if($has_error) {

	    	echo json_encode($errors);
	    	die();

	    }


    	$user_id = wp_create_user( $dtsl_username, $dtsl_user_password, $dtsl_user_email );

    	if(is_wp_error($user_id)) {

			echo json_encode( array (
				'<p>'.esc_html__('Something went wrong! please try again.', 'dtsl').'</p>'
			) );

			die();

    	} else {

	        $args = array (
				'ID'         => $user_id,
				'first_name' => sanitize_text_field($dtsl_user_first_name),
				'last_name'  => sanitize_text_field($dtsl_user_last_name),
				'role'       => 'incharge'
	        );
	        wp_update_user($args);

	        update_user_meta( $user_id, 'user_seller', $seller_id );


			// Send Notification

			# To Admin
			wp_new_user_notification( $user_id, null, 'admin' );

			# To User
			if( $dtsl_user_notification == 'on' ) {
				wp_new_user_notification( $user_id, null, 'user' );
			}


			// Activate incharge

	    	if('true' ==  dtsl_option('general', 'should-admin-approve-incharges')) {
	    		update_user_meta( $user_id, 'dtsl_user_status', 'waitingforapproval' );
	    	} else {
	    		update_user_meta( $user_id, 'dtsl_user_status', 'active' );
	    	}


	        // Package details

		    $dtsl_seller_package_used_incharges_count = get_user_meta($seller_id, 'dtsl_seller_package_used_incharges_count', true);
		    $dtsl_seller_package_used_incharges_count++;
		    update_user_meta($seller_id, 'dtsl_seller_package_used_incharges_count', $dtsl_seller_package_used_incharges_count);


			echo 'success';

			die();

    	}

    }


	die();

}

?>