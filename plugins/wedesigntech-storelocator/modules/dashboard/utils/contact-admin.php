<?php

function dtsl_dashboard_contact_admin_content() {

	$output = '';

	$dashboard_page_id = get_the_ID();

	$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );
	$listing_plural_label = apply_filters( 'dt_sl_listing_label', 'plural' );
    $incharge_singular_label = apply_filters( 'dt_sl_incharge_label', 'singular' );


	// Contact Admin
	$output .= '<div class="dtsl-dashbord-section-holder">';

		$output .= '<div class="dtsl-dashbord-section-holder-intro">';
			$output .= '<div class="dtsl-dashbord-section-title">'.esc_html__('Contact Administrator', 'dtsl').'</div>';
			$output .= '<div class="dtsl-dashbord-section-title-notes">'.sprintf( esc_html__('You can use this form to contact administrator. It will be usefull if you want to create %1$s for your ', 'dtsl'), strtolower($incharge_singular_label)).'</div>';
		$output .= '</div>';

		$output .= '<div class="dtsl-dashbord-section-holder-content">';
				$output .= '<p class="dtsl-dashboard-option-item">';
					$output .= '<form method="post" class="dtsl-dashboard-contactadmin-form" name="dtsl-dashboard-contactadmin-form">';

						$output .= '<div class="dtsl-column dtsl-one-column first">
										<textarea class="dtsl-contactadmin-message" name="dtsl_contactadmin_message" rows="5" placeholder="'.esc_html__('Your message', 'dtsl').'"></textarea>
									</div>';

						$output .= '<div class="dtsl-dashboard-contactadmin-notification-box"></div>';

						$output .= '<a class="dtsl-dashboard-contactadmin-submit-button custom-button-style" href="#">'.esc_html__('Send', 'dtsl').'</a>';

					$output .= '</form>';
				$output .= '</p>';
		$output .= '</div>';

	$output .= '</div>';


	return $output;

}


// Contact admin ajax call
add_action( 'wp_ajax_dtsl_process_dashboard_contactadmin', 'dtsl_process_dashboard_contactadmin' );
add_action( 'wp_ajax_nopriv_dtsl_process_dashboard_contactadmin', 'dtsl_process_dashboard_contactadmin' );
function dtsl_process_dashboard_contactadmin() {


	$current_user = wp_get_current_user();
	$user_id = $current_user->ID;

	$errors = false;
	$error_msg = array ();

    $contactadmin_message = wp_kses_post($_REQUEST['dtsl_contactadmin_message']);
    if(empty($contactadmin_message)) {
     	$errors = true;
    	array_push($error_msg, esc_html__('Your message is empty!', 'dtsl'));
    }

    // Throw error message
    if($errors) {

    	$error_content = '<ul class="dtsl-contactadmin-errorlist"><li>';
    	$error_content .= implode('</li><li>', $error_msg);
    	$error_content .= '</li></ul>';

        echo json_encode(array(
            'success' => false,
            'message' => $error_content
        ));
        wp_die();

    }

    // Composing mail

    $dtsl_seller_email = get_the_author_meta( 'user_email' , $user_id );

    $dtsl_admin_email = get_option('admin_email');

    $dtsl_subject = sprintf(esc_html__('You have been contacted by %1$s - %2$s', 'dtsl'), $current_user->display_name, get_bloginfo('name'));

    $dtsl_body = wpautop( $contactadmin_message ) . " <br/><br/>";
    $dtsl_body .= sprintf(esc_html__( 'You can contact %1$s via email %2$s', 'dtsl'), $current_user->display_name, $dtsl_seller_email);

    $dtsl_header = 'Content-type: text/html; charset=utf-8' . "\r\n";
    $dtsl_header .= 'From: ' . $current_user->display_name . " <" . $dtsl_seller_email . "> \r\n";


    if (wp_mail($dtsl_admin_email, $dtsl_subject, $dtsl_body, $dtsl_header)) {
        echo json_encode(array (
            'success' => true,
            'message' => esc_html__('Message Sent Successfully!', 'dtsl')
        ));
        wp_die();
    } else {
        echo json_encode(array (
                'success' => false,
                'message' => '<ul class="dtsl-contactadmin-errorlist"><li>'.esc_html__('Something went wrong!. Please contact administrator!.', 'dtsl').'</li></ul>'
            )
        );
        wp_die();
    }

	wp_die();

}

?>