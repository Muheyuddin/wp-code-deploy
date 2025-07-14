<?php
/*
 * Template Name: Directory Dashboard Template
 */

$user_id = get_current_user_id();
$current_user = get_userdata($user_id);

$user_roles = (array) $current_user->roles;


if(!is_user_logged_in()) {

	wp_redirect(home_url());
	exit;

} else {

	if(!current_user_can('administrator')) {

		$disabled = get_user_meta( $user_id, 'dtdr_user_status', true );
		if($disabled != 'active') {

		    wp_redirect(home_url());
		    exit;

		}

	}

}

?>

<?php

$dashboard_page_id = get_the_ID();
$dashboard_page = isset($_REQUEST['type']) ? dtdr_recursive_sanitize_text_field($_REQUEST['type']) : 'home';
$edit_item_id = isset($_REQUEST['edit_item_id']) ? dtdr_recursive_sanitize_text_field($_REQUEST['edit_item_id']) : -1;

$listing_singular_label  = apply_filters( 'listing_label', 'singular' );
$listing_plural_label    = apply_filters( 'listing_label', 'plural' );
$incharge_singular_label = apply_filters( 'incharge_label', 'singular' );
$incharge_plural_label   = apply_filters( 'incharge_label', 'plural' );

$seller_id = -1;
$process_seller = false;

if(in_array('seller', $user_roles)) {

	$seller_id = $user_id;
	$process_seller = true;

} else if(in_array('incharge', $user_roles)) {

	$incharge_id = $user_id;

	$user_seller = get_user_meta( $user_id, 'user_seller', true );
	if($user_seller != '' && $user_seller > 0) {

		$seller_id = $user_seller;
		$process_seller = true;

	}

}

$buyer_id = -1;

if(in_array('buyer', $user_roles)) {

	$buyer_id = $user_id;

}

if ( $process_seller && $seller_id > 0 ) {

	$dtdr_seller_package_active = false;
	$active_seller_package_title = '';

	$dtdr_seller_active_package_id = get_user_meta($seller_id, 'dtdr_seller_active_package_id', true);
	$dtdr_seller_active_package_id = (isset($dtdr_seller_active_package_id) && !empty($dtdr_seller_active_package_id)) ? $dtdr_seller_active_package_id : -1;

	if(function_exists('dtdr_check_user_seller_package_is_active') && dtdr_check_user_seller_package_is_active($seller_id, -1)) {

		$dtdr_seller_package_active = true;

		$dtdr_seller_active_package_purchased_date = get_user_meta($seller_id, 'dtdr_seller_active_package_purchased_date', true);
		$dtdr_seller_active_package_purchased_date = ($dtdr_seller_active_package_purchased_date != '') ? date(get_option('date_format'), (int)$dtdr_seller_active_package_purchased_date) : '-';

		$dtdr_seller_active_package_expiry_date    = get_user_meta($seller_id, 'dtdr_seller_active_package_expiry_date', true);
		if($dtdr_seller_active_package_expiry_date == 'LT') {
			$dtdr_seller_active_package_expiry_date = esc_html__('Lifetime', 'dtdr');
		} else if($dtdr_seller_active_package_expiry_date != '') {
			$dtdr_seller_active_package_expiry_date = date(get_option('date_format'), (int)$dtdr_seller_active_package_expiry_date);
		} else {
			$dtdr_seller_active_package_expiry_date = '-';
		}

		$active_seller_package_title = ($dtdr_seller_active_package_id != '') ? get_the_title($dtdr_seller_active_package_id) : esc_html__('NA', 'dtdr');


		// Available counts

		$dtdr_seller_package_listings_count          = get_user_meta($seller_id, 'dtdr_seller_package_listings_count', true);
		$dtdr_seller_package_listings_count          = (isset($dtdr_seller_package_listings_count) && !empty($dtdr_seller_package_listings_count)) ? $dtdr_seller_package_listings_count : 0;

		$dtdr_seller_package_featured_listings_count = get_user_meta($seller_id, 'dtdr_seller_package_featured_listings_count', true);
		$dtdr_seller_package_featured_listings_count = (isset($dtdr_seller_package_featured_listings_count) && !empty($dtdr_seller_package_featured_listings_count)) ? $dtdr_seller_package_featured_listings_count : 0;

		$dtdr_seller_package_incharges_count              = get_user_meta($seller_id, 'dtdr_seller_package_incharges_count', true);
		$dtdr_seller_package_incharges_count              = (isset($dtdr_seller_package_incharges_count) && !empty($dtdr_seller_package_incharges_count)) ? $dtdr_seller_package_incharges_count : 0;

		$dtdr_seller_package_images_count              = get_user_meta($seller_id, 'dtdr_seller_package_images_count', true);
		$dtdr_seller_package_images_count              = (isset($dtdr_seller_package_images_count) && !empty($dtdr_seller_package_images_count)) ? $dtdr_seller_package_images_count : 0;

		// Used counts

		$dtdr_seller_package_used_listings_count          = get_user_meta($seller_id, 'dtdr_seller_package_used_listings_count', true);
		$dtdr_seller_package_used_listings_count          = (isset($dtdr_seller_package_used_listings_count) && !empty($dtdr_seller_package_used_listings_count)) ? $dtdr_seller_package_used_listings_count : 0;

		$dtdr_seller_package_used_featured_listings_count = get_user_meta($seller_id, 'dtdr_seller_package_used_featured_listings_count', true);
		$dtdr_seller_package_used_featured_listings_count = (isset($dtdr_seller_package_used_featured_listings_count) && !empty($dtdr_seller_package_used_featured_listings_count)) ? $dtdr_seller_package_used_featured_listings_count : 0;

		$dtdr_seller_package_used_incharges_count              = get_user_meta($seller_id, 'dtdr_seller_package_used_incharges_count', true);
		$dtdr_seller_package_used_incharges_count              = (isset($dtdr_seller_package_used_incharges_count) && !empty($dtdr_seller_package_used_incharges_count)) ? $dtdr_seller_package_used_incharges_count : 0;

		$dtdr_seller_package_used_images_count              = get_user_meta($seller_id, 'dtdr_seller_package_used_images_count', true);
		$dtdr_seller_package_used_images_count              = (isset($dtdr_seller_package_used_images_count) && !empty($dtdr_seller_package_used_images_count)) ? $dtdr_seller_package_used_images_count : 0;


		// Remaining counts

		$dtdr_seller_allow_listings = false;
		if($dtdr_seller_package_listings_count == -1) {
			$dtdr_seller_package_listings_count   = esc_html__('Unlimited', 'dtdr');
			$dtdr_seller_remaining_listings_count = esc_html__('Unlimited', 'dtdr');
			$dtdr_seller_allow_listings = true;
		} else {
			$dtdr_seller_remaining_listings_count = ($dtdr_seller_package_listings_count - $dtdr_seller_package_used_listings_count);
		}

		if($dtdr_seller_package_featured_listings_count == -1) {
			$dtdr_seller_package_featured_listings_count   = esc_html__('Unlimited', 'dtdr');
			$dtdr_seller_remaining_featured_listings_count = esc_html__('Unlimited', 'dtdr');
		} else {
			$dtdr_seller_remaining_featured_listings_count = ($dtdr_seller_package_featured_listings_count - $dtdr_seller_package_used_featured_listings_count);
		}

		$dtdr_seller_allow_incharges = false;
		if($dtdr_seller_package_incharges_count == -1) {
			$dtdr_seller_package_incharges_count   = esc_html__('Unlimited', 'dtdr');
			$dtdr_seller_remaining_incharges_count = esc_html__('Unlimited', 'dtdr');
			$dtdr_seller_allow_incharges = true;
		} else {
			$dtdr_seller_remaining_incharges_count = ($dtdr_seller_package_incharges_count - $dtdr_seller_package_used_incharges_count);
		}

		if($dtdr_seller_package_images_count == -1) {
			$dtdr_seller_package_images_count   = esc_html__('Unlimited', 'dtdr');
			$dtdr_seller_remaining_images_count = esc_html__('Unlimited', 'dtdr');
		} else {
			$dtdr_seller_remaining_images_count = ($dtdr_seller_package_images_count - $dtdr_seller_package_used_images_count);
		}

	} else {
		$dtdr_seller_previous_package_id = get_user_meta($seller_id, 'dtdr_seller_previous_package_id', true);
	}

}

if ( $buyer_id > 0 ) {

	$dtdr_buyer_package_active = false;

	$dtdr_buyer_active_package_id = get_user_meta($buyer_id, 'dtdr_buyer_active_package_id', true);
	$dtdr_buyer_active_package_id = (isset($dtdr_buyer_active_package_id) && !empty($dtdr_buyer_active_package_id)) ? $dtdr_buyer_active_package_id : -1;

	$active_buyer_package_title = esc_html__('NA', 'dtdr');

	if(function_exists('dtdr_check_user_buyer_package_is_active') && dtdr_check_user_buyer_package_is_active($buyer_id, -1)) {

		$dtdr_buyer_package_active = true;

		$dtdr_buyer_active_package_purchased_date = get_user_meta($buyer_id, 'dtdr_buyer_active_package_purchased_date', true);
		$dtdr_buyer_active_package_purchased_date = ($dtdr_buyer_active_package_purchased_date != '') ? date(get_option('date_format'), (int)$dtdr_buyer_active_package_purchased_date) : '-';

		$dtdr_buyer_active_package_expiry_date    = get_user_meta($buyer_id, 'dtdr_buyer_active_package_expiry_date', true);
		if($dtdr_buyer_active_package_expiry_date == 'LT') {
			$dtdr_buyer_active_package_expiry_date = esc_html__('Lifetime', 'dtdr');
		} else if($dtdr_buyer_active_package_expiry_date != '') {
			$dtdr_buyer_active_package_expiry_date = date(get_option('date_format'), (int)$dtdr_buyer_active_package_expiry_date);
		} else {
			$dtdr_buyer_active_package_expiry_date = '-';
		}

		$active_buyer_package_title = ($dtdr_buyer_active_package_id != '') ? get_the_title($dtdr_buyer_active_package_id) : esc_html__('NA', 'dtdr');


		// Available counts

		$dtdr_buyer_package_listings_count = get_user_meta($buyer_id, 'dtdr_buyer_package_listings_count', true);
		$dtdr_buyer_package_listings_count = (isset($dtdr_buyer_package_listings_count) && !empty($dtdr_buyer_package_listings_count)) ? $dtdr_buyer_package_listings_count : 0;


		// Used counts

		$dtdr_buyer_package_used_listings_count = get_user_meta($buyer_id, 'dtdr_buyer_package_used_listings_count', true);
		$dtdr_buyer_package_used_listings_count = (isset($dtdr_buyer_package_used_listings_count) && !empty($dtdr_buyer_package_used_listings_count)) ? $dtdr_buyer_package_used_listings_count : 0;


		// Remaining counts

		if($dtdr_buyer_package_listings_count == -1) {
			$dtdr_buyer_package_listings_count   = esc_html__('Unlimited', 'dtdr');
			$dtdr_buyer_remaining_listings_count = esc_html__('Unlimited', 'dtdr');
		} else {
			$dtdr_buyer_remaining_listings_count = ($dtdr_buyer_package_listings_count - $dtdr_buyer_package_used_listings_count);
		}

	} else {
		$dtdr_buyer_previous_package_id = get_user_meta($buyer_id, 'dtdr_buyer_previous_package_id', true);
	}

}


// Dashboard Modules

$dashboard_modules = array ();

$dashboard_modules['home'] = array (
	'slug' => 'home',
	'label' => esc_html__('Home', 'dtdr'),
	'icon' => 'fas fa-home',
	'callback' => 'dtdr_dashboard_home_page_content',
	'callback_args' => '',
);
$dashboard_modules['myprofile'] = array (
	'slug' => 'myprofile',
	'label' => esc_html__('My Profile', 'dtdr'),
	'icon' => 'fas fa-user-tie',
	'callback' => 'dtdr_dashboard_myprofile_page_content',
	'callback_args' => ''
);
$dashboard_modules['mylistings'] = array (
	'slug' => 'mylistings',
	'label' => sprintf( esc_html__('My %1$s', 'dtdr'), $listing_plural_label ),
	'icon' => 'fas fa-list-ul',
	'callback' => 'dtdr_dashboard_mylistings_page_content',
	'callback_args' => ''
);
$dashboard_modules['addlisting'] = array (
	'slug' => 'addlisting',
	'label' => sprintf( esc_html__('Add %1$s', 'dtdr'), $listing_singular_label ),
	'icon' => 'fas fa-clipboard-list',
	'callback' => 'dtdr_dashboard_addlisting_page_content',
	'callback_args' => array ($user_id, $seller_id)
);
$dashboard_modules['favouritelisting'] = array (
	'slug' => 'favouritelisting',
	'label' => sprintf( esc_html__('Favourite %1$s', 'dtdr'), $listing_singular_label ),
	'icon' => 'far fa-heart',
	'callback' => 'dtdr_dashboard_favourite_listings_page_content',
	'callback_args' => ''
);
$dashboard_modules['inbox'] = array (
	'slug' => 'inbox',
	'label' => esc_html__('Inbox', 'dtdr'),
	'icon' => 'fas fa-envelope-open-text',
	'callback' => 'dtdr_dashboard_seller_inbox_page_content',
	'callback_args' => ''
);
$dashboard_modules['reviews'] = array (
	'slug' => 'reviews',
	'label' => esc_html__('Reviews', 'dtdr'),
	'icon' => 'fas fa-star-half-alt',
	'callback' => 'dtdr_dashboard_seller_reviews_page_content',
	'callback_args' => ''
);
$dashboard_modules['membership'] = array (
	'slug' => 'membership',
	'label' => esc_html__('Membership', 'dtdr'),
	'icon' => 'fas fa-users',
	'callback' => 'custom',
	'callback_args' => ''
);
if ( class_exists( 'WooCommerce' ) ) {
	$dashboard_modules['orders'] = array (
		'slug' => 'orders',
		'label' => esc_html__('Orders', 'dtdr'),
		'icon' => 'fas fa-cart-plus',
		'callback' => 'custom',
		'callback_args' => ''
	);
}
$dashboard_modules['contactadmin'] = array (
	'slug' => 'contactadmin',
	'label' => esc_html__('Contact Admin', 'dtdr'),
	'icon' => 'fas fa-user-cog',
	'callback' => 'dtdr_dashboard_contact_admin_content',
	'callback_args' => ''
);

$dashboard_modules['listingsrequested'] = array (
	'slug' => 'listingsrequested',
	'label' => sprintf( esc_html__('%1$s Requested', 'dtdr'), $listing_plural_label ),
	'icon' => 'fas fa-list-alt',
	'callback' => 'dtdr_dashboard_buyer_listings_page_content',
	'callback_args' => ''
);

$dashboard_modules = apply_filters( 'dashboard_modules', $dashboard_modules );


// Admin Modules
$dashboard_admin_modules = array ( 'home', 'myprofile', 'myincharges', 'addincharge', 'mylistings', 'addlisting', 'favouritelisting' );
$dashboard_admin_modules = apply_filters( 'dashboard_admin_modules', $dashboard_admin_modules );

// Seller Modules
$dashboard_seller_modules = array ( 'home', 'myprofile', 'mylistings', 'addlisting', 'inbox', 'reviews' );
if(in_array('buyer', $user_roles)) {
	array_push($dashboard_seller_modules, 'listingsrequested');
}
array_push($dashboard_seller_modules, 'favouritelisting', 'membership');
if(class_exists( 'WooCommerce' )) {
	array_push($dashboard_seller_modules, 'orders');
}
array_push($dashboard_seller_modules, 'contactadmin');
$dashboard_seller_modules = apply_filters( 'dashboard_seller_modules', $dashboard_seller_modules );

// Incharge Modules
$dashboard_incharge_modules = array ( 'myprofile' );
if( 'true' ==  dtdr_option('general', 'allow-incharge-add-listing') ) {
	array_push($dashboard_incharge_modules, 'mylistings', 'addlisting');
}
if(in_array('buyer', $user_roles)) {
	array_push($dashboard_incharge_modules, 'listingsrequested');
}
array_push($dashboard_incharge_modules, 'favouritelisting');
$dashboard_incharge_modules = apply_filters( 'dashboard_incharge_modules', $dashboard_incharge_modules );

// Buyer Modules
$dashboard_buyer_modules = array ( 'myprofile', 'listingsrequested', 'favouritelisting' );
$dashboard_buyer_modules = apply_filters( 'dashboard_buyer_modules', $dashboard_buyer_modules );


$modules_to_load = array ();

if(in_array('administrator', $user_roles)) {
	$modules_to_load = $dashboard_admin_modules;
} else if(in_array('seller', $user_roles)) {
	$modules_to_load = $dashboard_seller_modules;
} else if(in_array('incharge', $user_roles)) {
	$modules_to_load = $dashboard_incharge_modules;
} else if(in_array('buyer', $user_roles)) {
	$modules_to_load = $dashboard_buyer_modules;
}

$modules_to_load = apply_filters( 'modules_to_load', $modules_to_load );

?>


<?php get_header('dtdr'); ?>

	<?php
	/**
	* dtdr_before_main_content hook.
	*/
	do_action( 'dtdr_before_main_content' );
	?>

		<?php
		/**
		* dtdr_before_content hook.
		*/
		do_action( 'dtdr_before_content' );
		?>

			<div class="dtdr-column dtdr-one-fifth first">

				<div class="dtdr-dashboard-user-info">
					<div class="dtdr-dashboard-profile">
						<?php
						$dtdr_user_profile_image_url = get_the_author_meta( 'dtdr_user_profile_image_url' , $user_id );
						if($dtdr_user_profile_image_url != '') {
							echo '<img src="'.esc_url($dtdr_user_profile_image_url).'" alt="'.esc_attr__( 'Profile Image', 'dtdr' ).'" title="'.esc_attr__( 'Profile Image', 'dtdr' ).'" />';
						}
						?>
					</div>
					<div class="dashboard_username">
						<?php echo esc_html__('Welcome back, ', 'dtdr'); echo esc_html($current_user->display_name).'!';?>
					</div>
				</div>

				<div class="dtdr-dashbord-menu-holder">

			        <ul class="dtdr-dashboard-menus">
			            <?php

						if(is_array($modules_to_load) && !empty($modules_to_load)) {
							foreach($modules_to_load as $module_to_load) {
								$class = '';
								if($dashboard_modules[$module_to_load]['slug'] == $dashboard_page) {
									$class = 'dtdr-active';
								}
								echo '<li>';
									echo '<a href="'.add_query_arg( 'type', $dashboard_modules[$module_to_load]['slug'], get_permalink($dashboard_page_id) ).'" class="'.esc_attr($class).'">';
										echo '<span class="'.esc_attr($dashboard_modules[$module_to_load]['icon']).'"></span>';
										echo esc_html($dashboard_modules[$module_to_load]['label']);
									echo '</a>';
								echo '</li>';
							}
						}

				        ?>
			            <li>
			            	<a href="<?php echo wp_logout_url( home_url() );?>">
			            		<span class="fa fa-power-off"></span>
			            		<?php echo esc_html__('Log Out', 'dtdr'); ?>
			            	</a>
			            </li>
			        </ul>

			    </div>

			</div>

			<div class="dtdr-column dtdr-three-fifth">

				<div class="dtdr-dashbord-container">

					<?php

					if($dashboard_page == 'addincharge') {

						if(in_array( 'administrator', $user_roles )) {

							if(!empty($dashboard_modules[$dashboard_page]['callback_args'])) {
								echo call_user_func_array($dashboard_modules[$dashboard_page]['callback'], $dashboard_modules[$dashboard_page]['callback_args']);
							} else {
								echo call_user_func($dashboard_modules[$dashboard_page]['callback']);
							}

						} else if(in_array( 'seller', $user_roles )) {

							if($edit_item_id > 0) {

								if(!empty($dashboard_modules[$dashboard_page]['callback_args'])) {
									echo call_user_func_array($dashboard_modules[$dashboard_page]['callback'], $dashboard_modules[$dashboard_page]['callback_args']);
								} else {
									echo call_user_func($dashboard_modules[$dashboard_page]['callback']);
								}

							} else if($dtdr_seller_package_active) {

								if($dtdr_seller_remaining_incharges_count > 0 || $dtdr_seller_allow_incharges) {
									if(!empty($dashboard_modules[$dashboard_page]['callback_args'])) {
										echo call_user_func_array($dashboard_modules[$dashboard_page]['callback'], $dashboard_modules[$dashboard_page]['callback_args']);
									} else {
										echo call_user_func($dashboard_modules[$dashboard_page]['callback']);
									}
								} else {
									echo dtdr_dashboard_addincharge_consumed_notices($dtdr_seller_active_package_id);
									echo dtdr_dashboard_addincharge_purchasepackage_notices();
								}

							} else if($dtdr_seller_previous_package_id > 0) {

								echo dtdr_dashboard_addincharge_expired_notices($dtdr_seller_previous_package_id);
								echo dtdr_dashboard_addincharge_purchasepackage_notices();

							} else {

								echo dtdr_dashboard_addincharge_purchasepackage_notices();

							}

						}

					} else if($dashboard_page == 'addlisting') {

						if(in_array( 'administrator', $user_roles )) {

							if(!empty($dashboard_modules[$dashboard_page]['callback_args'])) {
								echo call_user_func_array($dashboard_modules[$dashboard_page]['callback'], $dashboard_modules[$dashboard_page]['callback_args']);
							} else {
								echo call_user_func($dashboard_modules[$dashboard_page]['callback']);
							}

						} else if(in_array( 'seller', $user_roles )) {

							if($edit_item_id > 0) {

								if(!empty($dashboard_modules[$dashboard_page]['callback_args'])) {
									echo call_user_func_array($dashboard_modules[$dashboard_page]['callback'], $dashboard_modules[$dashboard_page]['callback_args']);
								} else {
									echo call_user_func($dashboard_modules[$dashboard_page]['callback']);
								}

							} else if($dtdr_seller_package_active) {

								if($dtdr_seller_remaining_listings_count > 0 || $dtdr_seller_allow_listings) {
									if(!empty($dashboard_modules[$dashboard_page]['callback_args'])) {
										echo call_user_func_array($dashboard_modules[$dashboard_page]['callback'], $dashboard_modules[$dashboard_page]['callback_args']);
									} else {
										echo call_user_func($dashboard_modules[$dashboard_page]['callback']);
									}
								} else {
									echo dtdr_dashboard_addlisting_consumed_notices($dtdr_seller_active_package_id);
									echo dtdr_dashboard_addlisting_purchasepackage_notices();
								}

							} else if($dtdr_seller_previous_package_id > 0) {

								echo dtdr_dashboard_addlisting_expired_notices($dtdr_seller_previous_package_id);
								echo dtdr_dashboard_addlisting_purchasepackage_notices();

							} else {

								echo dtdr_dashboard_addlisting_purchasepackage_notices();

							}

						} else if(in_array( 'incharge', $user_roles ) && 'true' ==  dtdr_option('general', 'allow-incharge-add-listing')) {

							if($edit_item_id > 0) {

								if(!empty($dashboard_modules[$dashboard_page]['callback_args'])) {
									echo call_user_func_array($dashboard_modules[$dashboard_page]['callback'], $dashboard_modules[$dashboard_page]['callback_args']);
								} else {
									echo call_user_func($dashboard_modules[$dashboard_page]['callback']);
								}

							} else if($dtdr_seller_package_active) {

								if($dtdr_seller_remaining_listings_count > 0 || $dtdr_seller_allow_listings) {
									if(!empty($dashboard_modules[$dashboard_page]['callback_args'])) {
										echo call_user_func_array($dashboard_modules[$dashboard_page]['callback'], $dashboard_modules[$dashboard_page]['callback_args']);
									} else {
										echo call_user_func($dashboard_modules[$dashboard_page]['callback']);
									}
								} else {
									echo dtdr_dashboard_addlisting_consumed_notices($dtdr_seller_active_package_id);
								}

							} else if($dtdr_seller_previous_package_id == -1 || $dtdr_seller_previous_package_id > 0) {

								echo dtdr_dashboard_addlisting_expired_notices($dtdr_seller_previous_package_id);

							}

						}

					} else if($dashboard_page == 'membership') {

						echo '<div class="dtdr-warning-notice">';
							echo '<p>'.esc_html__('If you wish you can change your package, please select any of the available packages below.', 'dtdr').'</p>';
						echo '</div>';

						echo dtdr_dashboard_addlisting_purchasepackage_notices();

					} else if($dashboard_page == 'orders') {

						woocommerce_account_orders( '' );

					} else {

						if(isset($dashboard_modules[$dashboard_page]) && !empty($dashboard_modules[$dashboard_page])) {
							if(!empty($dashboard_modules[$dashboard_page]['callback_args'])) {
								echo call_user_func_array($dashboard_modules[$dashboard_page]['callback'], $dashboard_modules[$dashboard_page]['callback_args']);
							} else {
								echo call_user_func($dashboard_modules[$dashboard_page]['callback']);
							}
						}

					}

					?>

				</div>

			</div>

			<div class="dtdr-column dtdr-one-fifth">
				<div class="dtdr-dashboard-user-package-details">
					<?php
					$output = '';

					if ( in_array( 'administrator', $user_roles ) ) {

						$output .= '<div class="dtdr-dashboard-package-detail">';
							$output .= '<span class="dtdr-dashboard-package-detail-value">'.esc_html(count_user_posts($user_id , 'dtdr_listings')).'</span>';
							$output .= '<span class="dtdr-dashboard-package-detail-label">'.sprintf(esc_html__('Total %1$s', 'dtdr'), $listing_singular_label).'</span>';
						$output .= '</div>';

					} else if ( in_array( 'seller', $user_roles ) ) {

						$seller_singular_label = apply_filters( 'seller_label', 'singular' );

						$output .= '<div class="dtdr-dashboard-package-detail dtdr-seller_package">';
							$output .= '<span class="dtdr-dashboard-package-detail-title">'.sprintf(esc_html__('%1$s Package', 'dtdr'), $seller_singular_label).'</span>';
							$output .= '<span class="dtdr-dashboard-package-detail-sub-title">'.esc_html($active_seller_package_title).'</span>';
						$output .= '</div>';

						if($dtdr_seller_package_active) {

							$output .= '<div class="dtdr-dashboard-package-detail dtdr-purchased_date">';
								$output .= '<span class="dtdr-dashboard-package-detail-value">'.esc_html__('Purchase Date', 'dtdr').'</span>';
								$output .= '<span class="dtdr-dashboard-package-detail-label">'.esc_html($dtdr_seller_active_package_purchased_date).'</span>';
							$output .= '</div>';

							$output .= '<div class="dtdr-dashboard-package-detail dtdr-expiry_date">';
								$output .= '<span class="dtdr-dashboard-package-detail-value">'.esc_html__('Expiry Date', 'dtdr').'</span>';
								$output .= '<span class="dtdr-dashboard-package-detail-label">'.esc_html($dtdr_seller_active_package_expiry_date).'</span>';
							$output .= '</div>';

							$output .= '<div class="dtdr-dashboard-package-detail">';
								$output .= '<span class="dtdr-dashboard-package-detail-value">'.esc_html($dtdr_seller_package_listings_count).'</span>';
								$output .= '<span class="dtdr-dashboard-package-detail-label">'.sprintf(esc_html__('Total %1$s', 'dtdr'), $listing_singular_label).'</span>';
							$output .= '</div>';

							$output .= '<div class="dtdr-dashboard-package-detail">';
								$output .= '<span class="dtdr-dashboard-package-detail-value dtdr-listings-remaining-data">'.esc_html($dtdr_seller_remaining_listings_count).'</span>';
								$output .= '<span class="dtdr-dashboard-package-detail-label">'.sprintf(esc_html__('Remaining %1$s', 'dtdr'), $listing_singular_label).'</span>';
							$output .= '</div>';

							$output .= '<div class="dtdr-dashboard-package-detail">';
								$output .= '<span class="dtdr-dashboard-package-detail-value">'.esc_html($dtdr_seller_package_featured_listings_count).'</span>';
								$output .= '<span class="dtdr-dashboard-package-detail-label">'.sprintf(esc_html__('Total Featured %1$s', 'dtdr'), $listing_singular_label).'</span>';
							$output .= '</div>';

							$output .= '<div class="dtdr-dashboard-package-detail">';
								$output .= '<span class="dtdr-dashboard-package-detail-value dtdr-featured-remaining-data">'.esc_html__($dtdr_seller_remaining_featured_listings_count).'</span>';
								$output .= '<span class="dtdr-dashboard-package-detail-label">'.sprintf(esc_html__('Remaining Featured %1$s', 'dtdr'), $listing_singular_label).'</span>';
							$output .= '</div>';

							$output .= '<div class="dtdr-dashboard-package-detail">';
								$output .= '<span class="dtdr-dashboard-package-detail-value">'.esc_html($dtdr_seller_package_incharges_count).'</span>';
								$output .= '<span class="dtdr-dashboard-package-detail-label">'.sprintf(esc_html__('Total %1$s', 'dtdr'), $incharge_plural_label).'</span>';
							$output .= '</div>';

							$output .= '<div class="dtdr-dashboard-package-detail">';
								$output .= '<span class="dtdr-dashboard-package-detail-value dtdr-incharges-remaining-data">'.esc_html__($dtdr_seller_remaining_incharges_count).'</span>';
								$output .= '<span class="dtdr-dashboard-package-detail-label">'.sprintf(esc_html__('Remaining %1$s', 'dtdr'), $incharge_plural_label).'</span>';
							$output .= '</div>';

							$output .= '<div class="dtdr-dashboard-package-detail">';
								$output .= '<span class="dtdr-dashboard-package-detail-value">'.esc_html($dtdr_seller_package_images_count).'</span>';
								$output .= '<span class="dtdr-dashboard-package-detail-label">'.esc_html__('Total Images', 'dtdr').'</span>';
							$output .= '</div>';

							$output .= '<div class="dtdr-dashboard-package-detail">';
								$output .= '<span class="dtdr-dashboard-package-detail-value">'.esc_html__($dtdr_seller_remaining_images_count).'</span>';
								$output .= '<span class="dtdr-dashboard-package-detail-label">'.esc_html__('Remaining Images', 'dtdr').'</span>';
							$output .= '</div>';

						} else {

							$output .= '<div class="dtdr-dashboard-package-detail">';
								$output .= '<h4><span>'.esc_html__('No active package found !').'</span></h4>';
							$output .= '</div>';

						}

					} else if(in_array( 'incharge', $user_roles )) {

						$total_post_args = array (
												'posts_per_page' => -1,
												'post_type'=> 'dtdr_listings',
												'author'=> $incharge_id,
												'post_status' => array ( 'any' )
											);
						$total_post_listings = get_posts( $total_post_args );
						wp_reset_postdata();
						$listings_post_count = count($total_post_listings);

						$output .= '<div class="dtdr-dashboard-package-detail">';
							$output .= '<span class="dtdr-dashboard-package-detail-value">'.esc_html($listings_post_count).'</span>';
							$output .= '<span class="dtdr-dashboard-package-detail-label">'.sprintf(esc_html__('Total %1$s', 'dtdr'), $listing_singular_label).'</span>';
						$output .= '</div>';


					}

					if ( in_array( 'buyer', $user_roles ) ) {

						$output .= '<div class="dtdr-dashboard-package-detail">';
							$output .= '<h4>'.esc_html__('Buyer Package :', 'dtdr').' <span>'.esc_html($active_buyer_package_title).'</span></h4>';
						$output .= '</div>';

						if($dtdr_buyer_package_active) {

							$output .= '<div class="dtdr-dashboard-package-detail">';
								$output .= '<span class="dtdr-dashboard-package-detail-value">'.esc_html($dtdr_buyer_package_listings_count).'</span>';
								$output .= '<span class="dtdr-dashboard-package-detail-label">'.sprintf(esc_html__('Total %1$s', 'dtdr'), $listing_singular_label).'</span>';
							$output .= '</div>';

							$output .= '<div class="dtdr-dashboard-package-detail">';
								$output .= '<span class="dtdr-dashboard-package-detail-value dtdr-listings-remaining-data">'.esc_html($dtdr_buyer_remaining_listings_count).'</span>';
								$output .= '<span class="dtdr-dashboard-package-detail-label">'.sprintf(esc_html__('Remaining %1$s', 'dtdr'), $listing_singular_label).'</span>';
							$output .= '</div>';

							$output .= '<div class="dtdr-dashboard-package-detail">';
								$output .= '<span class="dtdr-dashboard-package-detail-value">'.esc_html__('Purchase Date', 'dtdr').'</span>';
								$output .= '<span class="dtdr-dashboard-package-detail-label">'.esc_html($dtdr_buyer_active_package_purchased_date).'</span>';
							$output .= '</div>';

							$output .= '<div class="dtdr-dashboard-package-detail">';
								$output .= '<span class="dtdr-dashboard-package-detail-value">'.esc_html__('Expiry Date', 'dtdr').'</span>';
								$output .= '<span class="dtdr-dashboard-package-detail-label">'.esc_html($dtdr_buyer_active_package_expiry_date).'</span>';
							$output .= '</div>';

						} else {

							$output .= '<div class="dtdr-dashboard-package-detail">';
								$output .= '<h4><span>'.esc_html__('No active package found !').'</span></h4>';
							$output .= '</div>';

						}

					}

					echo dtdr_html_output($output);

					?>
				</div>
			</div>

		<?php
		/**
		* dtdr_after_content hook.
		*/
		do_action( 'dtdr_after_content' );
		?>

	<?php
	/**
	* dtdr_after_main_content hook.
	*/
	do_action( 'dtdr_after_main_content' );
	?>

<?php get_footer('dtdr'); ?>