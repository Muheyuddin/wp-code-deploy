<?php

// Filter Dashboard Modules
if(!function_exists('dtdr_update_users_dashboard_modules')) {
	function dtdr_update_users_dashboard_modules($modules) {

		$incharge_singular_label = apply_filters( 'incharge_label', 'singular' );
		$incharge_plural_label   = apply_filters( 'incharge_label', 'plural' );

		$modules['myincharges'] = array (
			'slug' => 'myincharges',
			'label' => sprintf( esc_html__('My %1$s', 'dtdr'), $incharge_plural_label ),
			'icon' => 'fas fa-user',
			'callback' => 'dtdr_dashboard_myincharges_page_content',
			'callback_args' => ''
		);
		$modules['addincharge'] = array (
			'slug' => 'addincharge',
			'label' => sprintf( esc_html__('Add %1$s', 'dtdr'), $incharge_singular_label ),
			'icon' => 'fas fa-user-plus',
			'callback' => 'dtdr_dashboard_addincharge_page_content',
			'callback_args' => ''
		);

		return $modules;

	}
	add_filter( 'dashboard_modules', 'dtdr_update_users_dashboard_modules', 10, 1 );
}

// Filter Seller Modules
if(!function_exists('dashboard_update_users_seller_modules')) {
	function dashboard_update_users_seller_modules($modules) {

	    array_push($modules, 'myincharges', 'addincharge');

	    return $modules;

	}
	add_filter( 'dashboard_seller_modules', 'dashboard_update_users_seller_modules', 10, 1 );
}

?>