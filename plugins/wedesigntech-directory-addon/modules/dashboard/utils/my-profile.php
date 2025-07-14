<?php

function dtdr_dashboard_myprofile_page_content() {

	$output = '';

	$dashboard_page_id = get_the_ID();
	$user_id = get_current_user_id();

	$dtdr_user_first_name     =   get_the_author_meta( 'first_name' , $user_id );
	$dtdr_user_last_name      =   get_the_author_meta( 'last_name' , $user_id );
	$dtdr_user_email          =   get_the_author_meta( 'user_email' , $user_id );
	$dtdr_user_phone          =   get_the_author_meta( 'dtdr_user_phone' , $user_id );
	$dtdr_user_mobile         =   get_the_author_meta( 'dtdr_user_mobile' , $user_id );
	$dtdr_user_skype          =   get_the_author_meta( 'dtdr_user_skype' , $user_id );
	$dtdr_user_website        =   get_the_author_meta( 'dtdr_user_website' , $user_id );
	$dtdr_user_specialization =   get_the_author_meta( 'dtdr_user_specialization' , $user_id );

	wp_enqueue_media();

	$output .= '<form name="dtdr-dashboard-profile-form" method="post" action="" enctype="multipart/form-data" class="dtdr-dashboard-profile-form">';

		// User Details
		$output .= '<div class="dtdr-dashbord-section-holder">';

			$output .= '<div class="dtdr-dashbord-section-holder-intro">';
				$output .= '<div class="dtdr-dashbord-section-title">'.esc_html__('User Details', 'dtdr').'</div>';
				$output .= '<div class="dtdr-dashbord-section-title-notes">'.esc_html__('Update your profile details.', 'dtdr').'</div>';
			$output .= '</div>';

			$output .= '<div class="dtdr-dashbord-section-holder-content">';

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

				$output .= '<div class="dtdr-column dtdr-one-half first">';
					$output .= '<p class="dtdr-dashboard-option-item">
					               <label for="dtdr_user_email">'.esc_html__('Email', 'dtdr').'</label>
					               <input type="text" value="'.esc_attr($dtdr_user_email).'" name="dtdr_user_email" />
					            </p>';
				$output .= '</div>';
				$output .= '<div class="dtdr-column dtdr-one-half">';
					$output .= '<p class="dtdr-dashboard-option-item">
					               <label for="dtdr_user_phone">'.esc_html__('Phone', 'dtdr').'</label>
					               <input type="text" value="'.esc_attr($dtdr_user_phone).'" name="dtdr_user_phone" />
					            </p>';
				$output .= '</div>';

				$output .= '<div class="dtdr-column dtdr-one-half first">';
					$output .= '<p class="dtdr-dashboard-option-item">
					               <label for="dtdr_user_mobile">'.esc_html__('Mobile', 'dtdr').'</label>
					               <input type="text" value="'.esc_attr($dtdr_user_mobile).'" name="dtdr_user_mobile" />
					            </p>';
				$output .= '</div>';
				$output .= '<div class="dtdr-column dtdr-one-half">';
					$output .= '<p class="dtdr-dashboard-option-item">
					               <label for="dtdr_user_skype">'.esc_html__('Skype', 'dtdr').'</label>
					               <input type="text" value="'.esc_attr($dtdr_user_skype).'" name="dtdr_user_skype" />
					            </p>';
				$output .= '</div>';

				$output .= '<div class="dtdr-column dtdr-one-half first">';
					$output .= '<p class="dtdr-dashboard-option-item">
					               <label for="dtdr_user_website">'.esc_html__('Website', 'dtdr').'</label>
					               <input type="text" value="'.esc_attr($dtdr_user_website).'" name="dtdr_user_website" />
					            </p>';
				$output .= '</div>';
				$output .= '<div class="dtdr-column dtdr-one-half">';
					$output .= '<p class="dtdr-dashboard-option-item">
					               <label for="dtdr_user_specialization">'.esc_html__('Specialization', 'dtdr').'</label>
					               <input type="text" value="'.esc_attr($dtdr_user_specialization).'" name="dtdr_user_specialization" />
					            </p>';
				$output .= '</div>';

			$output .= '</div>';

		$output .= '</div>';

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


		// Notice And Submit form

		$output .= '<div class="dtdr-dashbord-section-holder">';

			$output .= '<div class="dtdr-dashboard-notices"></div>';

			$output .= '<input type="hidden" value="'.get_permalink($dashboard_page_id).'" name="dtdr_dashboard_page_url" class="dtdr_dashboard_page_url" />';
			$output .= '<a class="custom-button-style dtdr-update-profile-button" onclick="return false;">'.esc_html__('Update Profile', 'dtdr').'</a>';

		$output .= '</div>';

	$output .= '</form>';


	$output .= '<form name="dtdr-dashboard-profile-changepwd-form" method="post" action="" enctype="multipart/form-data" class="dtdr-dashboard-profile-changepwd-form">';

		// User Change Password
		$output .= '<div class="dtdr-dashbord-section-holder">';

			$output .= '<div class="dtdr-dashbord-section-holder-intro">';
				$output .= '<div class="dtdr-dashbord-section-title">'.esc_html__('Change Password', 'dtdr').'</div>';
				$output .= '<div class="dtdr-dashbord-section-title-notes">'.esc_html__('Update password here. You have to login again, once password changed.', 'dtdr').'</div>';
			$output .= '</div>';

			$output .= '<div class="dtdr-dashbord-section-holder-content">';

				$output .= '<div class="dtdr-column dtdr-one-column first">';
					$output .= '<p class="dtdr-dashboard-option-item">
					               <label for="dtdr_user_old_pwd">'.esc_html__('Old Password', 'dtdr').'</label>
					               <input type="password" value="" name="dtdr_user_old_pwd" />
					            </p>';
				$output .= '</div>';
				$output .= '<div class="dtdr-column dtdr-one-half first">';
					$output .= '<p class="dtdr-dashboard-option-item">
					               <label for="dtdr_user_new_pwd">'.esc_html__('New Password', 'dtdr').'</label>
					               <input type="password" value="" name="dtdr_user_new_pwd" />
					            </p>';
				$output .= '</div>';
				$output .= '<div class="dtdr-column dtdr-one-half">';
					$output .= '<p class="dtdr-dashboard-option-item">
					               <label for="dtdr_user_confirm_new_pwd">'.esc_html__('Confirm New Password', 'dtdr').'</label>
					               <input type="password" value="" name="dtdr_user_confirm_new_pwd" />
					            </p>';
				$output .= '</div>';

				$output .= wp_nonce_field( 'dtdr_change_pwd_ajax_nonce', 'dtdr-allow-change-pwd', true, false );

			$output .= '</div>';

		$output .= '</div>';


		// Notice And Submit form
		$output .= '<div class="dtdr-dashbord-section-holder">';

			$output .= '<div class="dtdr-dashboard-notices"></div>';

			$output .= '<input type="hidden" value="'.get_permalink($dashboard_page_id).'" name="dtdr_dashboard_page_url" class="dtdr_dashboard_page_url" />';
			$output .= '<a class="custom-button-style dtdr-update-userpwd-button" onclick="return false;">'.esc_html__('Update Password', 'dtdr').'</a>';

		$output .= '</div>';

	$output .= '</form>';



	return $output;

}

// Update user profile
add_action( 'wp_ajax_dtdr_dashboard_update_user_profile', 'dtdr_dashboard_update_user_profile' );
add_action( 'wp_ajax_nopriv_dtdr_dashboard_update_user_profile', 'dtdr_dashboard_update_user_profile' );
function dtdr_dashboard_update_user_profile() {

	$current_user = wp_get_current_user();
	$user_id = $current_user->ID;


	extract(dtdr_recursive_sanitize_text_field($_REQUEST));


	$has_error = false;
	$errors = array ();

	if($dtdr_user_first_name == '') {
		$has_error = true;
		$errors[] = '<p>'.esc_html__('First name is empty.', 'dtdr').'</p>';
	}

	if($dtdr_user_email == '') {
		$has_error = true;
		$errors[] = '<p>'.esc_html__('Email field is empty.', 'dtdr').'</p>';
	} else if($current_user->user_email != $dtdr_user_email) {
        $user_id = email_exists($dtdr_user_email);
        if($user_id) {
			$has_error = true;
			$errors[] = '<p>'.esc_html__('Email have been taken taken already by another user.', 'dtdr').'</p>';
        }
    }


    // Update user profile

    if($has_error) {
    	echo json_encode($errors);
    } else {

        update_user_meta( $user_id, 'dtdr_user_phone', sanitize_text_field($dtdr_user_phone));
        update_user_meta( $user_id, 'dtdr_user_mobile', sanitize_text_field($dtdr_user_mobile));
        update_user_meta( $user_id, 'dtdr_user_skype', sanitize_text_field($dtdr_user_skype));
        update_user_meta( $user_id, 'dtdr_user_website', sanitize_text_field($dtdr_user_website));
        update_user_meta( $user_id, 'dtdr_user_specialization', sanitize_text_field($dtdr_user_specialization));

        update_user_meta( $user_id, 'dtdr_user_social_items', $dtdr_social_items );
        update_user_meta( $user_id, 'dtdr_user_social_items_value', $dtdr_social_items_value );

        update_user_meta( $user_id, 'dtdr_user_profile_image', $dtdr_user_profile_image );

        $args = array (
			'ID'         => $user_id,
			'user_email' => $dtdr_user_email,
			'first_name' => sanitize_text_field($dtdr_user_first_name),
			'last_name'  => sanitize_text_field($dtdr_user_last_name)
        );
        wp_update_user($args);

	    echo 'success';

    }


	die();

}

// Update user password
add_action( 'wp_ajax_dtdr_dashboard_update_user_password', 'dtdr_dashboard_update_user_password' );
add_action( 'wp_ajax_nopriv_dtdr_dashboard_update_user_password', 'dtdr_dashboard_update_user_password' );
function dtdr_dashboard_update_user_password() {

	$current_user = wp_get_current_user();
	$user_id = $current_user->ID;

    if(!is_user_logged_in()) {
        die();
    }

    if($userID === 0) {
       die();
    }

	extract(dtdr_recursive_sanitize_text_field($_REQUEST));

    $dtdr_user_old_pwd        	=  sanitize_text_field ( $dtdr_user_old_pwd );
    $dtdr_user_new_pwd        	=  sanitize_text_field ( $dtdr_user_new_pwd );
    $dtdr_user_confirm_new_pwd   =  sanitize_text_field ( $dtdr_user_confirm_new_pwd ) ;

	$has_error = false;
	$errors = array ();

    if($dtdr_user_old_pwd == '') {
		$has_error = true;
		$errors[] = '<p>'.esc_html__('Old password field is blank.', 'dtdr').'</p>';
    }

    if($dtdr_user_new_pwd == '') {
		$has_error = true;
		$errors[] = '<p>'.esc_html__('New password field is blank.', 'dtdr').'</p>';
    }

    if($dtdr_user_confirm_new_pwd == '') {
		$has_error = true;
		$errors[] = '<p>'.esc_html__('New confirm password field is blank.', 'dtdr').'</p>';
    }

    if($dtdr_user_new_pwd != $dtdr_user_confirm_new_pwd) {
		$has_error = true;
		$errors[] = '<p>'.esc_html__('Passwords does not match.', 'dtdr').'</p>';
    }

    if($has_error) {
    	echo json_encode($errors);
    	die();
    }

    check_ajax_referer('dtdr_change_pwd_ajax_nonce', 'dtdr-allow-change-pwd');

    $user = get_user_by('id', $user_id);

    if($user && wp_check_password($dtdr_user_old_pwd, $user->data->user_pass, $user->ID)) {
        wp_set_password( $dtdr_user_new_pwd, $user->ID );
        echo 'success';
    } else {
 		$has_error = true;
		$errors[] = '<p>'.esc_html__('Your old password is not correct.', 'dtdr').'</p>';
    }

    if($has_error) {
    	echo json_encode($errors);
    }

	die();

}

?>