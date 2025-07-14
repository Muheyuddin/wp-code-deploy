<?php

/* ---------------------------------------------------------------------------
 * Login Redirect Utils
 * --------------------------------------------------------------------------- */

if(!function_exists('dtdr_get_login_redirect_url')) {
	function dtdr_get_login_redirect_url($user_info) {

		$dtdr_redirect_url = '';

		if(isset($user_info->data->ID)) {

			$current_user = $user_info;

			if ( in_array( 'seller', (array) $current_user->roles ) ) {

				$seller_login_redirect_page = dtdr_option('login','seller-login-redirect-page');

				if($seller_login_redirect_page == 'dashboard') {
					$dtdr_redirect_url = home_url( 'dashboard' );
				}

			}

			if ( in_array( 'incharge', (array) $current_user->roles ) ) {

				$incharge_login_redirect_page = dtdr_option('login','incharge-login-redirect-page');

				if($incharge_login_redirect_page == 'dashboard') {
					$dtdr_redirect_url = home_url( 'dashboard' );
				}

			}

		}

		return $dtdr_redirect_url;

	}
}

// Redirect user from default login form

if(!function_exists('dtdr_default_login_form_redirect')) {
	function dtdr_default_login_form_redirect( $redirect_to, $request, $user ) {

		$dtdr_redirect_url = dtdr_get_login_redirect_url($user);

		if($dtdr_redirect_url != '') {
			return $dtdr_redirect_url;
		} else {
			return $redirect_to;
		}

	}
	add_filter( 'login_redirect', 'dtdr_default_login_form_redirect', 10, 3 );
}


// Redirect user from woocommerce login form

if(!function_exists('dtdr_woocommerce_login_form_redirect')) {
	function dtdr_woocommerce_login_form_redirect( $redirect, $user ) {

		$dtdr_redirect_url = dtdr_get_login_redirect_url($user);

		if($dtdr_redirect_url != '') {
			return $dtdr_redirect_url;
		} else {
			return $redirect_to;
		}

	}
	add_filter( 'woocommerce_login_redirect', 'dtdr_woocommerce_login_form_redirect', 10, 2 );
}

?>