<?php

function dtsl_dashboard_myprofile_page_content() {

	$output = '';

	$dashboard_page_id = get_the_ID();
	$user_id = get_current_user_id();

	$dtsl_user_first_name     =   get_the_author_meta( 'first_name' , $user_id );
	$dtsl_user_last_name      =   get_the_author_meta( 'last_name' , $user_id );
	$dtsl_user_email          =   get_the_author_meta( 'user_email' , $user_id );
	$dtsl_user_phone          =   get_the_author_meta( 'dtsl_user_phone' , $user_id );
	$dtsl_user_mobile         =   get_the_author_meta( 'dtsl_user_mobile' , $user_id );
	$dtsl_user_skype          =   get_the_author_meta( 'dtsl_user_skype' , $user_id );
	$dtsl_user_website        =   get_the_author_meta( 'dtsl_user_website' , $user_id );
	$dtsl_user_specialization =   get_the_author_meta( 'dtsl_user_specialization' , $user_id );

	wp_enqueue_media();

	$output .= '<form name="dtsl-dashboard-profile-form" method="post" action="" enctype="multipart/form-data" class="dtsl-dashboard-profile-form">';

		// User Details
		$output .= '<div class="dtsl-dashbord-section-holder">';

			$output .= '<div class="dtsl-dashbord-section-holder-intro">';
				$output .= '<div class="dtsl-dashbord-section-title">'.esc_html__('User Details', 'dtsl').'</div>';
				$output .= '<div class="dtsl-dashbord-section-title-notes">'.esc_html__('Update your profile details.', 'dtsl').'</div>';
			$output .= '</div>';

			$output .= '<div class="dtsl-dashbord-section-holder-content">';

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

				$output .= '<div class="dtsl-column dtsl-one-half first">';
					$output .= '<p class="dtsl-dashboard-option-item">
					               <label for="dtsl_user_email">'.esc_html__('Email', 'dtsl').'</label>
					               <input type="text" value="'.esc_attr($dtsl_user_email).'" name="dtsl_user_email" />
					            </p>';
				$output .= '</div>';
				$output .= '<div class="dtsl-column dtsl-one-half">';
					$output .= '<p class="dtsl-dashboard-option-item">
					               <label for="dtsl_user_phone">'.esc_html__('Phone', 'dtsl').'</label>
					               <input type="text" value="'.esc_attr($dtsl_user_phone).'" name="dtsl_user_phone" />
					            </p>';
				$output .= '</div>';

				$output .= '<div class="dtsl-column dtsl-one-half first">';
					$output .= '<p class="dtsl-dashboard-option-item">
					               <label for="dtsl_user_mobile">'.esc_html__('Mobile', 'dtsl').'</label>
					               <input type="text" value="'.esc_attr($dtsl_user_mobile).'" name="dtsl_user_mobile" />
					            </p>';
				$output .= '</div>';
				$output .= '<div class="dtsl-column dtsl-one-half">';
					$output .= '<p class="dtsl-dashboard-option-item">
					               <label for="dtsl_user_skype">'.esc_html__('Skype', 'dtsl').'</label>
					               <input type="text" value="'.esc_attr($dtsl_user_skype).'" name="dtsl_user_skype" />
					            </p>';
				$output .= '</div>';

				$output .= '<div class="dtsl-column dtsl-one-half first">';
					$output .= '<p class="dtsl-dashboard-option-item">
					               <label for="dtsl_user_website">'.esc_html__('Website', 'dtsl').'</label>
					               <input type="text" value="'.esc_attr($dtsl_user_website).'" name="dtsl_user_website" />
					            </p>';
				$output .= '</div>';
				$output .= '<div class="dtsl-column dtsl-one-half">';
					$output .= '<p class="dtsl-dashboard-option-item">
					               <label for="dtsl_user_specialization">'.esc_html__('Specialization', 'dtsl').'</label>
					               <input type="text" value="'.esc_attr($dtsl_user_specialization).'" name="dtsl_user_specialization" />
					            </p>';
				$output .= '</div>';

			$output .= '</div>';

		$output .= '</div>';

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


		// Notice And Submit form

		$output .= '<div class="dtsl-dashbord-section-holder">';

			$output .= '<div class="dtsl-dashboard-notices"></div>';

			$output .= '<input type="hidden" value="'.get_permalink($dashboard_page_id).'" name="dtsl_dashboard_page_url" class="dtsl_dashboard_page_url" />';
			$output .= '<a class="custom-button-style dtsl-update-profile-button" onclick="return false;">'.esc_html__('Update Profile', 'dtsl').'</a>';

		$output .= '</div>';

	$output .= '</form>';


	$output .= '<form name="dtsl-dashboard-profile-changepwd-form" method="post" action="" enctype="multipart/form-data" class="dtsl-dashboard-profile-changepwd-form">';

		// User Change Password
		$output .= '<div class="dtsl-dashbord-section-holder">';

			$output .= '<div class="dtsl-dashbord-section-holder-intro">';
				$output .= '<div class="dtsl-dashbord-section-title">'.esc_html__('Change Password', 'dtsl').'</div>';
				$output .= '<div class="dtsl-dashbord-section-title-notes">'.esc_html__('Update password here. You have to login again, once password changed.', 'dtsl').'</div>';
			$output .= '</div>';

			$output .= '<div class="dtsl-dashbord-section-holder-content">';

				$output .= '<div class="dtsl-column dtsl-one-column first">';
					$output .= '<p class="dtsl-dashboard-option-item">
					               <label for="dtsl_user_old_pwd">'.esc_html__('Old Password', 'dtsl').'</label>
					               <input type="password" value="" name="dtsl_user_old_pwd" />
					            </p>';
				$output .= '</div>';
				$output .= '<div class="dtsl-column dtsl-one-half first">';
					$output .= '<p class="dtsl-dashboard-option-item">
					               <label for="dtsl_user_new_pwd">'.esc_html__('New Password', 'dtsl').'</label>
					               <input type="password" value="" name="dtsl_user_new_pwd" />
					            </p>';
				$output .= '</div>';
				$output .= '<div class="dtsl-column dtsl-one-half">';
					$output .= '<p class="dtsl-dashboard-option-item">
					               <label for="dtsl_user_confirm_new_pwd">'.esc_html__('Confirm New Password', 'dtsl').'</label>
					               <input type="password" value="" name="dtsl_user_confirm_new_pwd" />
					            </p>';
				$output .= '</div>';

				$output .= wp_nonce_field( 'dtsl_change_pwd_ajax_nonce', 'dtsl-allow-change-pwd', true, false );

			$output .= '</div>';

		$output .= '</div>';


		// Notice And Submit form
		$output .= '<div class="dtsl-dashbord-section-holder">';

			$output .= '<div class="dtsl-dashboard-notices"></div>';

			$output .= '<input type="hidden" value="'.get_permalink($dashboard_page_id).'" name="dtsl_dashboard_page_url" class="dtsl_dashboard_page_url" />';
			$output .= '<a class="custom-button-style dtsl-update-userpwd-button" onclick="return false;">'.esc_html__('Update Password', 'dtsl').'</a>';

		$output .= '</div>';

	$output .= '</form>';



	return $output;

}

// Update user profile
add_action( 'wp_ajax_dtsl_dashboard_update_user_profile', 'dtsl_dashboard_update_user_profile' );
add_action( 'wp_ajax_nopriv_dtsl_dashboard_update_user_profile', 'dtsl_dashboard_update_user_profile' );
function dtsl_dashboard_update_user_profile() {

	$current_user = wp_get_current_user();
	$user_id = $current_user->ID;


	extract(dtsl_recursive_sanitize_text_field($_REQUEST));


	$has_error = false;
	$errors = array ();

	if($dtsl_user_first_name == '') {
		$has_error = true;
		$errors[] = '<p>'.esc_html__('First name is empty.', 'dtsl').'</p>';
	}

	if($dtsl_user_email == '') {
		$has_error = true;
		$errors[] = '<p>'.esc_html__('Email field is empty.', 'dtsl').'</p>';
	} else if($current_user->user_email != $dtsl_user_email) {
        $user_id = email_exists($dtsl_user_email);
        if($user_id) {
			$has_error = true;
			$errors[] = '<p>'.esc_html__('Email have been taken taken already by another user.', 'dtsl').'</p>';
        }
    }


    // Update user profile

    if($has_error) {
    	echo json_encode($errors);
    } else {

        update_user_meta( $user_id, 'dtsl_user_phone', sanitize_text_field($dtsl_user_phone));
        update_user_meta( $user_id, 'dtsl_user_mobile', sanitize_text_field($dtsl_user_mobile));
        update_user_meta( $user_id, 'dtsl_user_skype', sanitize_text_field($dtsl_user_skype));
        update_user_meta( $user_id, 'dtsl_user_website', sanitize_text_field($dtsl_user_website));
        update_user_meta( $user_id, 'dtsl_user_specialization', sanitize_text_field($dtsl_user_specialization));

        update_user_meta( $user_id, 'dtsl_user_social_items', $dtsl_social_items );
        update_user_meta( $user_id, 'dtsl_user_social_items_value', $dtsl_social_items_value );

        update_user_meta( $user_id, 'dtsl_user_profile_image', $dtsl_user_profile_image );

        $args = array (
			'ID'         => $user_id,
			'user_email' => $dtsl_user_email,
			'first_name' => sanitize_text_field($dtsl_user_first_name),
			'last_name'  => sanitize_text_field($dtsl_user_last_name)
        );
        wp_update_user($args);

	    echo 'success';

    }


	die();

}

// Update user password
add_action( 'wp_ajax_dtsl_dashboard_update_user_password', 'dtsl_dashboard_update_user_password' );
add_action( 'wp_ajax_nopriv_dtsl_dashboard_update_user_password', 'dtsl_dashboard_update_user_password' );
function dtsl_dashboard_update_user_password() {

	$current_user = wp_get_current_user();
	$user_id = $current_user->ID;

    if(!is_user_logged_in()) {
        die();
    }

    if($userID === 0) {
       die();
    }

	extract(dtsl_recursive_sanitize_text_field($_REQUEST));

    $dtsl_user_old_pwd        	=  sanitize_text_field ( $dtsl_user_old_pwd );
    $dtsl_user_new_pwd        	=  sanitize_text_field ( $dtsl_user_new_pwd );
    $dtsl_user_confirm_new_pwd   =  sanitize_text_field ( $dtsl_user_confirm_new_pwd ) ;

	$has_error = false;
	$errors = array ();

    if($dtsl_user_old_pwd == '') {
		$has_error = true;
		$errors[] = '<p>'.esc_html__('Old password field is blank.', 'dtsl').'</p>';
    }

    if($dtsl_user_new_pwd == '') {
		$has_error = true;
		$errors[] = '<p>'.esc_html__('New password field is blank.', 'dtsl').'</p>';
    }

    if($dtsl_user_confirm_new_pwd == '') {
		$has_error = true;
		$errors[] = '<p>'.esc_html__('New confirm password field is blank.', 'dtsl').'</p>';
    }

    if($dtsl_user_new_pwd != $dtsl_user_confirm_new_pwd) {
		$has_error = true;
		$errors[] = '<p>'.esc_html__('Passwords does not match.', 'dtsl').'</p>';
    }

    if($has_error) {
    	echo json_encode($errors);
    	die();
    }

    check_ajax_referer('dtsl_change_pwd_ajax_nonce', 'dtsl-allow-change-pwd');

    $user = get_user_by('id', $user_id);

    if($user && wp_check_password($dtsl_user_old_pwd, $user->data->user_pass, $user->ID)) {
        wp_set_password( $dtsl_user_new_pwd, $user->ID );
        echo 'success';
    } else {
 		$has_error = true;
		$errors[] = '<p>'.esc_html__('Your old password is not correct.', 'dtsl').'</p>';
    }

    if($has_error) {
    	echo json_encode($errors);
    }

	die();

}

?>