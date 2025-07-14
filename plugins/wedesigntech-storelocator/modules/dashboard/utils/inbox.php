<?php

function dtsl_dashboard_seller_inbox_page_content() {

	$output = '';

	$output .= '<div class="dtsl-my-inbox-container">';

		$output .= '<div class="dtsl-my-inbox-item-holder">';

			$output .= '<div class="dtsl-column dtsl-one-half first">';

				$output .= '<div class="dtsl-dashbord-section-holder">';

					// Inbox Messages

					$output .= '<div class="dtsl-dashbord-section-holder-intro">';
						$output .= '<div class="dtsl-dashbord-section-title">'.esc_html__('Messages', 'dtsl').'</div>';
						$output .= '<div class="dtsl-dashbord-section-title-notes">'.esc_html__('Messages added by users from frontend contact form.', 'dtsl').'</div>';
					$output .= '</div>';

					$output .= '<div class="dtsl-dashbord-section-holder-content">';

						$author_id = get_current_user_id();

						$dtsl_lead_messages = get_user_meta($author_id, 'dtsl_lead_messages', true);

						if(is_array($dtsl_lead_messages) && !empty($dtsl_lead_messages)) {
							foreach($dtsl_lead_messages as $listing_id => $dtsl_lead_listing_messages) {
								if($listing_id > 0) {
									$output .= '<h5 class="dtsl-dashbord-inbox-listing-title">'.get_the_title($listing_id).'</h5>';
									$output .= '<ul class="dtsl-dashbord-inbox-listing-messages-wrapper">';
										foreach($dtsl_lead_listing_messages as $user_emailid => $dtsl_lead_user_messages) {

											$unread_cnt = 0;
											$unread_class = '';
											foreach($dtsl_lead_user_messages['leads']['conversation'] as $dtsl_lead_user_data) {
												if($dtsl_lead_user_data['status'] == 'unread') {
													$unread_cnt++;
												}
											}
											if($unread_cnt > 0) {
												$unread_class = 'unread';
											}
											$output .= '<li class="dtsl-dashbord-inbox-conversation-loader '.esc_attr($unread_class).'" data-authorid="'.esc_attr($author_id).'"  data-listingid="'.esc_attr($listing_id).'" data-useremail="'.esc_attr($user_emailid).'">'.esc_html($dtsl_lead_user_messages['leads']['name']).'<span class="dtsl-inbox-listing-user-email">'.esc_url($user_emailid).'</span><span class="dtsl-inbox-listing-user-unread-count">'.esc_html($unread_cnt).'</span></li>';
										}
									$output .= '</ul>';
								}
							}
						}

					$output .= '</div>';

				$output .= '</div>';

			$output .= '</div>';

			$output .= '<div class="dtsl-column dtsl-one-half">';

			$output .= '<div class="dtsl-dashbord-inbox-listing-conversation-wrapper"></div>';

			$output .= '</div>';

		$output .= '</div>';

	$output .= '</div>';


	return $output;

}

// Inbox Load Conversation

add_action( 'wp_ajax_dtsl_inbox_conversation_loader', 'dtsl_inbox_conversation_loader' );
add_action( 'wp_ajax_nopriv_dtsl_inbox_conversation_loader', 'dtsl_inbox_conversation_loader' );
function dtsl_inbox_conversation_loader() {

	extract(dtsl_recursive_sanitize_text_field($_REQUEST));

	$dtsl_lead_messages = get_user_meta($author_id, 'dtsl_lead_messages', true);

	$dtsl_conversations = array_reverse($dtsl_lead_messages[$listing_id][$user_email]['leads']['conversation'], true);

	$output = '';
	if(is_array($dtsl_conversations) && !empty($dtsl_conversations)) {
		$output .= '<ul class="dtsl-dashbord-inbox-conversation-list">';
		foreach($dtsl_conversations as $conversation_id => $dtsl_conversation) {
			if($dtsl_conversation['leadData']['message'] != '') {

				$unread_class = '';
				if($dtsl_conversation['status'] == 'unread') {
					$unread_class = 'unread';
				}

				$output .= '<li class="'.$unread_class.'">';

					$output .= $dtsl_conversation['leadData']['message'];
					$output .= '<span>'.$dtsl_conversation['leadData']['date'].'</span>';

					$output .= '<a class="dtsl-dashbord-inbox-conversation-reply-loader">'.esc_html__('Reply').'</a>';

					$output .= '<div class="dtsl-dashbord-inbox-conversation-reply-wrapper hidden">';

						$output .= '<form method="post" class="dtsl-inbox-conversation-reply-form" name="dtsl-inbox-conversation-reply-form">';

							$output .= '<textarea class="message" name="message" rows="5" placeholder="'.esc_html__('Give a Reply', 'dtsl').'"></textarea>';

							$output .= '<input class="author_id" name="author_id" type="hidden" value="'.esc_attr($author_id).'" />';
							$output .= '<input class="listing_id" name="listing_id" type="hidden" value="'.esc_attr($listing_id).'" />';
							$output .= '<input class="user_email" name="user_email" type="hidden" value="'.esc_attr($user_email).'" />';
							$output .= '<input class="conversation_id" name="conversation_id" type="hidden" value="'.esc_attr($conversation_id).'" />';

							$output .= '<div class="dtsl-inbox-conversation-reply-notification-box"></div>';

							$output .= '<a class="dtsl-inbox-conversation-reply-submit">'.esc_html__('Send Reply', 'dtsl').'</a>';

						$output .= '</form>';

					$output .= '</div>';

					$output .= '<div class="dtsl-dashbord-inbox-conversation-reply-list-wrapper">';

						$dtsl_conversation_replies = $dtsl_conversation['replyData'];
						if(is_array($dtsl_conversation_replies) && !empty($dtsl_conversation_replies)) {
							$output .= '<ul class="dtsl-dashbord-inbox-conversation-reply-list">';
							foreach($dtsl_conversation_replies as $key => $dtsl_conversation_reply) {
								$output .= '<li>';
									$output .= $dtsl_conversation_reply['message'];
									$output .= '<span>'.$dtsl_conversation_reply['date'].'</span>';
								$output .= '</li>';
							}
							$output .= '</ul>';
						}

					$output .= '</div>';

				$output .= '</li>';
			}
		}
		$output .= '</ul>';
	}

	echo dtsl_html_output($output);

	die();

}

// Inbox Reply Conversation

add_action( 'wp_ajax_dtsl_process_inbox_conversation_reply_form', 'dtsl_process_inbox_conversation_reply_form' );
add_action( 'wp_ajax_nopriv_dtsl_process_inbox_conversation_reply_form', 'dtsl_process_inbox_conversation_reply_form' );
function dtsl_process_inbox_conversation_reply_form() {

	extract(dtsl_recursive_sanitize_text_field($_REQUEST));

	$errors = false;
	$error_msg = array ();

	$message = sanitize_text_field($message);
	if(empty($message)) {
		$errors = true;
		array_push($error_msg, esc_html__('Your message is empty!', 'dtsl'));
	}

	// Throw error message
	if($errors) {

		$error_content = '<div class="dtsl-inbox-conversation-reply-form-errorlist">';
			$error_content .= implode("\n", $error_msg);
		$error_content .= '</div>';

		echo json_encode(array(
			'success' => false,
			'message' => $error_content
		));
		wp_die();

	}


    $dtsl_subject  = sprintf(esc_html__('Reply for your message from %1$s', 'dtsl'), get_the_title($listing_id));
    $dtsl_body     = sprintf(esc_html__('Reply for your message from %1$s', 'dtsl'), get_the_title($listing_id)) . " <br/>";
    $dtsl_body 	 .= $message;
    $dtsl_header   = 'Content-type: text/html; charset = utf-8' . "\r\n";

    if (wp_mail($user_email, $dtsl_subject, $dtsl_body, $dtsl_header)) {

		$dtsl_lead_messages = get_user_meta($author_id, 'dtsl_lead_messages', true);

		$conversationData = $dtsl_lead_messages[$listing_id][$user_email]['leads']['conversation'][$conversation_id];

		if(!empty($conversationData)) {

			$replyDate = date(get_option('date_format'));

			$leadReply['message'] = $message;
			$leadReply['date']    = $replyDate;


			if (array_key_exists('replyData', $conversationData)) { // If message already exists

				$replyData = $conversationData['replyData'];

				array_push($replyData, $leadReply);


				$conversationData['replyData'] = $replyData;

			} else {

				$conversationData['replyData'][0] = $leadReply;

			}

		}

		$dtsl_lead_messages[$listing_id][$user_email]['leads']['conversation'][$conversation_id] = $conversationData;
		$dtsl_lead_messages[$listing_id][$user_email]['leads']['conversation'][$conversation_id]['status'] = 'read';

		update_user_meta($author_id, 'dtsl_lead_messages', $dtsl_lead_messages);


		$dtsl_conversation_replies = $dtsl_lead_messages[$listing_id][$user_email]['leads']['conversation'][$conversation_id]['replyData'];

		$replay_message = '<div class="dtsl-dashbord-inbox-conversation-reply-list-wrapper">';
		if(is_array($dtsl_conversation_replies) && !empty($dtsl_conversation_replies)) {
			$replay_message .= '<ul class="dtsl-dashbord-inbox-conversation-reply-list">';
			foreach($dtsl_conversation_replies as $key => $dtsl_conversation_reply) {
				$replay_message .= '<li>';
					$replay_message .= $dtsl_conversation_reply['message'];
					$replay_message .= '<span>'.$dtsl_conversation_reply['date'].'</span>';
				$replay_message .= '</li>';
			}
			$replay_message .= '</ul>';
		}
		$replay_message .= '</div>';

        echo json_encode(array (
            'success' 		   => true,
			'message'          => esc_html__('Your Message Conveyed Successfully!', 'dtsl'),
			'replay_message'   => $replay_message
		));

	}

	wp_die();

}


?>