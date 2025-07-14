<?php

// Register user roles
if(!function_exists('dtdr_user_roles')) {

    function dtdr_user_roles() {

		$seller_incharge_capability = array (
			'read'                           => true,
			'upload_files'                   => true,
			'edit_dtdr_listing'              => true,
			'read_dtdr_listing'              => true,
			'delete_dtdr_listing'            => true,
			'create_dtdr_listings'           => true,
			'edit_dtdr_listings'             => true,
			'publish_dtdr_listings'          => true,
			'delete_dtdr_listings'           => true,
			'delete_published_dtdr_listings' => true,
			'delete_private_dtdr_listings'   => true,
			'edit_published_dtdr_listings'   => true,
		);

		add_role( 'seller', esc_html__('Seller','dtdr'), $seller_incharge_capability);
		add_role( 'incharge', esc_html__('Incharge','dtdr'), $seller_incharge_capability );

		$buyer_capability = array (
			'read'
		);

		add_role( 'buyer', esc_html__('Buyer','dtdr'), $buyer_capability );

	}

	add_action('init','dtdr_user_roles');

}

// Add Capabilities for Administrator
if(!function_exists('dtdr_add_admin_caps')) {

    function dtdr_add_admin_caps() {

		$role = get_role('administrator');
		$role->add_cap('create_dtdr_listings');
        $role->add_cap('publish_dtdr_listings');
        $role->add_cap('read_dtdr_listing');
        $role->add_cap('delete_dtdr_listing');
        $role->add_cap('edit_dtdr_listing');
        $role->add_cap('edit_dtdr_listings');
        $role->add_cap('delete_dtdr_listings');
        $role->add_cap('edit_published_dtdr_listings');
        $role->add_cap('delete_published_dtdr_listings');
        $role->add_cap('read_private_dtdr_listings');
        $role->add_cap('delete_private_dtdr_listings');
        $role->add_cap('edit_others_dtdr_listings');
        $role->add_cap('delete_others_dtdr_listings');
        $role->add_cap('edit_private_dtdr_listings');
        $role->add_cap('delete_private_dtdr_listings');
        $role->add_cap('edit_published_dtdr_listings');

	}

	add_action('admin_init', 'dtdr_add_admin_caps');

}

// Limit media library access
if(!function_exists('dtdr_ajax_query_attachments_args')) {

    function dtdr_ajax_query_attachments_args($query = array()) {


	    $user_id = get_current_user_id();

	    if($user_id && !current_user_can('edit_others_posts')) {

		    $current_user = get_userdata($user_id);

			if(in_array('seller', (array) $current_user->roles)) {

				$seller_incharges = get_users ( array ('role' => 'incharge', 'meta_key' => 'user_seller', 'meta_value' => $user_id, 'fields' => 'ID') );
				$incharge_ids = '';
				if(!empty($seller_incharges)) {
					$incharge_ids = ','.implode(',', $seller_incharges);
				}

				$query['author'] = $user_id.$incharge_ids;

			} else if(in_array('incharge', (array) $current_user->roles)) {

				$query['author'] = $user_id;

			}

		}

	    return $query;

    }

    add_filter('ajax_query_attachments_args', 'dtdr_ajax_query_attachments_args');

}


// Media access ( number of images ) restriction

if(!function_exists('dtdr_check_upload_limits')) {

	function dtdr_check_upload_limits( $file ) {


	    $user_id = get_current_user_id();
	    $current_user = get_userdata($user_id);

		$process_seller = false; $seller_id = -1;

		if(in_array('seller', (array) $current_user->roles)) {

			$seller_id = $user_id;
			$process_seller = true;

		} else if(in_array('incharge', (array) $current_user->roles)) {

			$incharge_id = $user_id;

			$user_seller = get_user_meta( $incharge_id, 'user_seller', true );
			if($user_seller != '' && $user_seller > 0) {

				$seller_id = $user_seller;
				$process_seller = true;

			}

		}


		if ( $process_seller && $seller_id > 0 ) {

			if(function_exists('dtdr_check_user_seller_package_is_active') && dtdr_check_user_seller_package_is_active($seller_id, -1)) {

				$package_images_count                  = get_user_meta($seller_id, 'dtdr_seller_package_images_count', true);
				$dtdr_seller_package_used_images_count = get_user_meta($seller_id, 'dtdr_seller_package_used_images_count', true);

			    if($package_images_count != -1 && ($dtdr_seller_package_used_images_count + 1) > $package_images_count) {
			    	$file['error'] = esc_html__('Upload limit has been reached!', 'dtdr');
			    }

			}

		}

	    return $file;

	}

	add_filter( 'wp_handle_upload_prefilter', 'dtdr_check_upload_limits' );

}


if(!function_exists('dtdr_update_upload_stats')) {

	function dtdr_update_upload_stats( $args ) {

	    $user_id = get_current_user_id();
	    $current_user = get_userdata($user_id);

		$process_seller = false; $seller_id = -1;

		if(in_array('seller', (array) $current_user->roles)) {

			$seller_id = $user_id;
			$process_seller = true;

		} else if(in_array('incharge', (array) $current_user->roles)) {

			$incharge_id = $user_id;

			$user_seller = get_user_meta( $incharge_id, 'user_seller', true );
			if($user_seller != '' && $user_seller > 0) {

				$seller_id = $user_seller;
				$process_seller = true;

			}

		}

		if ( $process_seller && $seller_id > 0 ) {

			$dtdr_seller_package_used_images_count = get_user_meta( $seller_id, 'dtdr_seller_package_used_images_count', true );
			$dtdr_seller_package_used_images_count = (isset($dtdr_seller_package_used_images_count) && !empty($dtdr_seller_package_used_images_count)) ? $dtdr_seller_package_used_images_count : 0;
		    update_user_meta( $seller_id, 'dtdr_seller_package_used_images_count', $dtdr_seller_package_used_images_count + 1 );

		}

		return $args;

	}

	add_filter( 'wp_handle_upload', 'dtdr_update_upload_stats' );

}


// Remove admin bar
if(!function_exists('dtdr_remove_admin_bar')) {

    function dtdr_remove_admin_bar() {
        if (!current_user_can('administrator') && !is_admin()) {
         	show_admin_bar(false);
        }
    }

    add_action('after_setup_theme', 'dtdr_remove_admin_bar');

}

// Register user profile fields
add_action( 'show_user_profile', 'dtdr_user_profile_fields' );
add_action( 'edit_user_profile', 'dtdr_user_profile_fields' );
function dtdr_user_profile_fields( $user )
{

	$seller_singular_label = apply_filters( 'seller_label', 'singular' );
	$incharge_singular_label = apply_filters( 'incharge_label', 'singular' );

	$user_datas = get_userdata($user->ID);

	echo '<h2>'.esc_html__('Author additional information','dtdr').'</h2>';

	echo '<table class="form-table">
			<tbody>

				<tr class="user-description-wrap">
					<th>'.esc_html__('Specialization', 'dtdr').'</th>
					<td>';
						$dtdr_user_specialization = get_the_author_meta('dtdr_user_specialization', $user->ID);
						$dtdr_user_specialization = isset($dtdr_user_specialization) ? $dtdr_user_specialization : '';
						echo '<input class="large" type="text" placeholder="'.esc_html__('Specialization', 'dtdr').'" id="dtdr_user_specialization" name="dtdr_user_specialization" value="'.$dtdr_user_specialization.'" />
					</td>
				</tr>

				<tr class="user-description-wrap">
					<th>'.esc_html__('Phone', 'dtdr').'</th>
					<td>';
						$dtdr_user_phone = get_the_author_meta('dtdr_user_phone', $user->ID);
						$dtdr_user_phone = isset($dtdr_user_phone) ? $dtdr_user_phone : '';
						echo '<input class="large" type="text" placeholder="'.esc_html__('Phone', 'dtdr').'" id="dtdr_user_phone" name="dtdr_user_phone" value="'.$dtdr_user_phone.'" />
					</td>
				</tr>

				<tr class="user-description-wrap">
					<th>'.esc_html__('Mobile', 'dtdr').'</th>
					<td>';
						$dtdr_user_mobile = get_the_author_meta('dtdr_user_mobile', $user->ID);
						$dtdr_user_mobile = isset($dtdr_user_mobile) ? $dtdr_user_mobile : '';
						echo '<input class="large" type="text" placeholder="'.esc_html__('Mobile', 'dtdr').'" id="dtdr_user_mobile" name="dtdr_user_mobile" value="'.$dtdr_user_mobile.'" />
					</td>
				</tr>

				<tr class="user-description-wrap">
					<th>'.esc_html__('Skype', 'dtdr').'</th>
					<td>';
						$dtdr_user_skype = get_the_author_meta('dtdr_user_skype', $user->ID);
						$dtdr_user_skype = isset($dtdr_user_skype) ? $dtdr_user_skype : '';
						echo '<input class="large" type="text" placeholder="'.esc_html__('Skype', 'dtdr').'" id="dtdr_user_skype" name="dtdr_user_skype" value="'.$dtdr_user_skype.'" />
					</td>
				</tr>

				<tr class="user-description-wrap">
					<th>'.esc_html__('Website', 'dtdr').'</th>
					<td>';
						$dtdr_user_website = get_the_author_meta('dtdr_user_website', $user->ID);
						$dtdr_user_website = isset($dtdr_user_website) ? $dtdr_user_website : '';
						echo '<input class="large" type="text" placeholder="'.esc_html__('Website', 'dtdr').'" id="dtdr_user_website" name="dtdr_user_website" value="'.$dtdr_user_website.'" />
					</td>
				</tr>

				<tr class="user-sociallinks-wrap">
					<th>'.esc_html__('Social Links', 'dtdr').'</th>
					<td>'.dtdr_social_details_field($user->ID, 'user').'</td>
				</tr>

				<tr class="user-profilepicture-wrap">
					<th>'.esc_html__('Custom Profile Picture', 'dtdr').'</th>
					<td>'.dtdr_user_profile_picture_field($user->ID).'</td>
				</tr>';

				if(in_array('incharge', (array) $user_datas->roles)) {

					echo '<tr class="user-description-wrap">
							<th>'.sprintf( esc_html__( '%1$s', 'dtdr' ), $seller_singular_label ).'</th>
							<td>';

								$user_seller = get_the_author_meta('user_seller', $user->ID);
								$user_seller = isset($user_seller) ? $user_seller : '';

			                    echo '<select name="user_seller" class="dtdr-chosen-select">';
			                    	echo '<option value="">'.esc_html__('None', 'dtdr').'</option>';

			                    	$sellers = get_users ( array ('role' => 'seller', 'fields' => array( 'ID', 'display_name' ) ) );
			                        if(count($sellers) > 0) {
			                            foreach($sellers as $seller) {

											$seller_id = $seller->ID;

			                                $selected_attribute = '';
			                                if($user_seller == $seller_id) {
			                                    $selected_attribute = 'selected="selected"';
			                                }
			                                echo '<option value="'.esc_attr($seller_id).'" '.$selected_attribute.'>'.esc_html($seller->display_name).'</option>';

			                            }
			                        }

			                    echo '</select>';

							echo '<div class="dtdr-note">'.sprintf( esc_html__( 'Choose %1$s to which this "%2$s" belongs to.', 'dtdr' ), $seller_singular_label, $incharge_singular_label ).'</div>
							</td>
						</tr>';

				}

			echo '<tr class="user-description-wrap">
					<th>'.esc_html__( 'User Status', 'dtdr' ).'</th>
					<td>';

						$dtdr_user_status = get_the_author_meta('dtdr_user_status', $user->ID);
						$dtdr_user_status = (isset($dtdr_user_status) && $dtdr_user_status != '') ? $dtdr_user_status : 'disabled';

	                    echo '<select name="dtdr_user_status" class="dtdr-chosen-select">';

	                    	$user_disabled_options = array ('disabled' => esc_html__('Disabled', 'dtdr'), 'active' => esc_html__('Active', 'dtdr'), 'waitingforapproval' => esc_html__('Waiting For Approval', 'dtdr'));
	                        if(count($user_disabled_options) > 0) {
	                            foreach($user_disabled_options as $user_disabled_option_key => $user_disabled_option) {

	                                $selected_attribute = '';
	                                if($dtdr_user_status == $user_disabled_option_key) {
	                                    $selected_attribute = 'selected="selected"';
	                                }
	                                echo '<option value="'.esc_attr($user_disabled_option_key).'" '.$selected_attribute.'>'.esc_html($user_disabled_option).'</option>';

	                            }
	                        }

	                    echo '</select>';

					echo '<div class="dtdr-note">'.esc_html__( 'Choose user status here.', 'dtdr' ).'</div>
					</td>
				</tr>

			</tbody>
		</table>';

}

add_action( 'personal_options_update', 'dtdr_save_social_links_sc' );
add_action( 'edit_user_profile_update', 'dtdr_save_social_links_sc' );
function dtdr_save_social_links_sc( $user_id )
{

	if(isset($_POST['dtdr_user_specialization']) && $_POST['dtdr_user_specialization'] != '') {
		update_user_meta( $user_id,'dtdr_user_specialization', dtdr_recursive_sanitize_text_field ( $_POST['dtdr_user_specialization'] ) );
	} else {
		delete_user_meta( $user_id, 'dtdr_user_specialization' );
	}
	if(isset($_POST['dtdr_user_phone']) && $_POST['dtdr_user_phone'] != '') {
		update_user_meta( $user_id,'dtdr_user_phone', dtdr_recursive_sanitize_text_field ( $_POST['dtdr_user_phone'] ) );
	} else {
		delete_user_meta( $user_id, 'dtdr_user_phone' );
	}
	if(isset($_POST['dtdr_user_mobile']) && $_POST['dtdr_user_mobile'] != '') {
		update_user_meta( $user_id,'dtdr_user_mobile', dtdr_recursive_sanitize_text_field ( $_POST['dtdr_user_mobile'] ) );
	} else {
		delete_user_meta( $user_id, 'dtdr_user_mobile' );
	}
	if(isset($_POST['dtdr_user_skype']) && $_POST['dtdr_user_skype'] != '') {
		update_user_meta( $user_id,'dtdr_user_skype', dtdr_recursive_sanitize_text_field ( $_POST['dtdr_user_skype'] ) );
	} else {
		delete_user_meta( $user_id, 'dtdr_user_skype' );
	}
	if(isset($_POST['dtdr_user_website']) && $_POST['dtdr_user_website'] != '') {
		update_user_meta( $user_id,'dtdr_user_website', dtdr_recursive_sanitize_text_field ( $_POST['dtdr_user_website'] ) );
	} else {
		delete_user_meta( $user_id, 'dtdr_user_website' );
	}
	if(isset($_POST['dtdr_social_items']) && $_POST['dtdr_social_items'] != '') {
		update_user_meta( $user_id,'dtdr_user_social_items', dtdr_recursive_sanitize_text_field ( $_POST['dtdr_social_items'] ) );
	} else {
		delete_user_meta( $user_id, 'dtdr_user_social_items' );
	}
	if(isset($_POST['dtdr_social_items_value']) && $_POST['dtdr_social_items_value'] != '') {
		update_user_meta( $user_id,'dtdr_user_social_items_value', dtdr_recursive_sanitize_text_field ( $_POST['dtdr_social_items_value'] ) );
	} else {
		delete_user_meta( $user_id, 'dtdr_user_social_items_value' );
	}
	if(isset($_POST['dtdr_user_profile_image']) && $_POST['dtdr_user_profile_image'] != '') {
		update_user_meta( $user_id,'dtdr_user_profile_image', dtdr_recursive_sanitize_text_field ( $_POST['dtdr_user_profile_image'] ) );
	} else {
		delete_user_meta( $user_id, 'dtdr_user_profile_image' );
	}
	if(isset($_POST['dtdr_user_profile_image_url']) && $_POST['dtdr_user_profile_image_url'] != '') {
		update_user_meta( $user_id,'dtdr_user_profile_image_url', dtdr_recursive_sanitize_text_field ( $_POST['dtdr_user_profile_image_url'] ) );
	} else {
		delete_user_meta( $user_id, 'dtdr_user_profile_image_url' );
	}
	if(isset($_POST['user_seller']) && $_POST['user_seller'] != '') {
		update_user_meta( $user_id,'user_seller', dtdr_recursive_sanitize_text_field ( $_POST['user_seller'] ) );
	} else {
		delete_user_meta( $user_id, 'user_seller' );
	}

	if(isset($_POST['dtdr_user_status']) && $_POST['dtdr_user_status'] != '') {
		update_user_meta( $user_id,'dtdr_user_status', dtdr_recursive_sanitize_text_field ( $_POST['dtdr_user_status'] ) );
	} else {
		delete_user_meta( $user_id, 'dtdr_user_status' );
	}

}

// Disable users column
if(!function_exists('dtdr_manage_users_columns')) {
	function dtdr_manage_users_columns($defaults) {

		$defaults['dtdr_user_status'] = esc_html__( 'Status', 'dtdr' );
		return $defaults;

	}
	add_filter( 'manage_users_columns', 'dtdr_manage_users_columns' );
}

if(!function_exists('dtdr_manage_users_column_content')) {
	function dtdr_manage_users_column_content($empty, $column_name, $user_ID) {

		if ( $column_name == 'dtdr_user_status' ) {
			if ( get_the_author_meta( 'dtdr_user_status', $user_ID ) == 'disabled' ) {
				return esc_html__( 'Disabled', 'dtdr' );
			} else if ( get_the_author_meta( 'dtdr_user_status', $user_ID ) == 'active' ) {
				return esc_html__( 'Active', 'dtdr' );
			} else if ( get_the_author_meta( 'dtdr_user_status', $user_ID ) == 'waitingforapproval' ) {
				return esc_html__( 'Waiting For Approval', 'dtdr' );
			}
		}

	}
	add_action( 'manage_users_custom_column', 'dtdr_manage_users_column_content', 10, 3 );
}

// Filter disabled user when user logs in
if(!function_exists('dtdr_user_login')) {
	function dtdr_user_login($user_login, $user = null) {

		if(!$user) {
			$user = get_user_by('login', $user_login);
		}
		if(!$user) {
			return;
		}

		if(!in_array('administrator', (array) $user->roles)) {

			$disabled = get_user_meta( $user->ID, 'dtdr_user_status', true );

			if($disabled == 'disabled') {
				wp_clear_auth_cookie();

				$login_url = site_url( 'wp-login.php', 'login' );
				$login_url = add_query_arg( 'disabled', '1', $login_url );
				wp_redirect( $login_url );
				exit;
			}

		}

	}
	add_action( 'wp_login', 'dtdr_user_login', 10, 2 );
}


// User log in message
if(!function_exists('dtdr_user_login_message')) {
	function dtdr_user_login_message($message) {

		// Show the error message if it seems to be a disabled user
		if ( isset( $_GET['disabled'] ) && $_GET['disabled'] == 1 ) {
			$message =  '<div id="login_error">' . apply_filters( 'dtdr_user_status_notice', esc_html__( 'Account disabled', 'dtdr' ) ) . '</div>';
		}

		return $message;

	}
	add_filter( 'login_message', 'dtdr_user_login_message' );
}

?>