<?php

function dtdr_dashboard_contact_admin_content() {

	$output = '';

	$dashboard_page_id = get_the_ID(); 

	$listing_singular_label = apply_filters( 'listing_label', 'singular' );
	$listing_plural_label = apply_filters( 'listing_label', 'plural' );	
    $incharge_singular_label = apply_filters( 'incharge_label', 'singular' );


	// Contact Admin
	$output .= '<div class="dtdr-dashbord-section-holder">';

		$output .= '<div class="dtdr-dashbord-section-holder-intro">';
			$output .= '<div class="dtdr-dashbord-section-title">'.esc_html__('Contact Administrator', 'dtdr').'</div>';
			$output .= '<div class="dtdr-dashbord-section-title-notes">'.sprintf( esc_html__('You can use this form to contact administrator. It will be usefull if you want to create %1$s for your ', 'dtdr'), strtolower($incharge_singular_label)).'</div>';
		$output .= '</div>';

		$output .= '<div class="dtdr-dashbord-section-holder-content">';
				$output .= '<p class="dtdr-dashboard-option-item">';
					$output .= '<form method="post" class="dtdr-dashboard-contactadmin-form" name="dtdr-dashboard-contactadmin-form">';
				
						$output .= '<div class="dtdr-column dtdr-one-column first">
										<textarea class="dtdr-contactadmin-message" name="dtdr_contactadmin_message" rows="5" placeholder="'.esc_html__('Your message', 'dtdr').'"></textarea>
									</div>';

						$output .= '<div class="dtdr-dashboard-contactadmin-notification-box"></div>';

						$output .= '<a class="dtdr-dashboard-contactadmin-submit-button custom-button-style" href="#">'.esc_html__('Send', 'dtdr').'</a>';

					$output .= '</form>';
				$output .= '</p>';        
		$output .= '</div>';

	$output .= '</div>';


	return $output;

}


// Contact admin ajax call
add_action( 'wp_ajax_dtdr_process_dashboard_contactadmin', 'dtdr_process_dashboard_contactadmin' );
add_action( 'wp_ajax_nopriv_dtdr_process_dashboard_contactadmin', 'dtdr_process_dashboard_contactadmin' );
function dtdr_process_dashboard_contactadmin() {


	$current_user = wp_get_current_user();
	$user_id = $current_user->ID;

	$errors = false;
	$error_msg = array ();

    $contactadmin_message = wp_kses_post($_REQUEST['dtdr_contactadmin_message']);
    if(empty($contactadmin_message)) {
     	$errors = true;
    	array_push($error_msg, esc_html__('Your message is empty!', 'dtdr'));
    }      

    // Throw error message
    if($errors) {

    	$error_content = '<ul class="dtdr-contactadmin-errorlist"><li>';
    	$error_content .= implode('</li><li>', $error_msg);
    	$error_content .= '</li></ul>';

        echo json_encode(array(
            'success' => false,
            'message' => $error_content
        ));
        wp_die();

    } 

    // Composing mail

    $dtdr_seller_email = get_the_author_meta( 'user_email' , $user_id );

    $dtdr_admin_email = get_option('admin_email');

    $dtdr_subject = sprintf(esc_html__('You have been contacted by %1$s - %2$s', 'dtdr'), $current_user->display_name, get_bloginfo('name'));

    $dtdr_body = wpautop( $contactadmin_message ) . " <br/><br/>";
    $dtdr_body .= sprintf(esc_html__( 'You can contact %1$s via email %2$s', 'dtdr'), $current_user->display_name, $dtdr_seller_email);

    $dtdr_header = 'Content-type: text/html; charset=utf-8' . "\r\n";
    $dtdr_header .= 'From: ' . $current_user->display_name . " <" . $dtdr_seller_email . "> \r\n";


    if (wp_mail($dtdr_admin_email, $dtdr_subject, $dtdr_body, $dtdr_header)) {
        echo json_encode(array (
            'success' => true,
            'message' => esc_html__('Message Sent Successfully!', 'dtdr')
        ));
        wp_die();
    } else {
        echo json_encode(array (
                'success' => false,
                'message' => '<ul class="dtdr-contactadmin-errorlist"><li>'.esc_html__('Something went wrong!. Please contact administrator!.', 'dtdr').'</li></ul>'
            )
        );
        wp_die();
    }

	wp_die();

}

?>