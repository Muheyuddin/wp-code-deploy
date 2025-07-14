<?php

require_once DTSL_PLUGIN_PATH . 'statistics/statistics-utils.php';


function dtsl_statistics_options() {

	$current = isset( $_GET['tab'] ) ? dtsl_recursive_sanitize_text_field($_GET['tab']) : 'dtsl_statistics_listings';

	dtsl_get_statistics_submenus($current);
	dtsl_get_statistics_tab($current);

}

function dtsl_get_statistics_submenus($current) {

	$current_user = wp_get_current_user();
	$current_user_id = $current_user->ID;

	$listing_plural_label = apply_filters( 'dt_sl_listing_label', 'plural' );
	$seller_plural_label = apply_filters( 'dt_sl_seller_label', 'plural' );

    $tabs = array (
				'dtsl_statistics_listings' => $listing_plural_label,
				'dtsl_statistics_sellers' => $seller_plural_label,
				'dtsl_statistics_packages' => esc_html__('Packages', 'dtsl'),
    		);

    echo '<h2 class="dtsl-custom-nav nav-tab-wrapper">';
		foreach( $tabs as $key => $tab ) {
			$class = ( $key == $current ) ? 'nav-tab-active' : '';
			echo '<a class="nav-tab '.$class.'" href="?page=dtsl-statistics-options&tab='.$key.'">'.$tab.'</a>';
		}
    echo '</h2>';

}

function dtsl_get_statistics_tab($current) {

	$current_user = wp_get_current_user();
	$current_user_id = $current_user->ID;

	switch($current){
		case 'dtsl_statistics_listings':
			dtsl_statistics_listings_content($current_user_id);
		break;
		case 'dtsl_statistics_sellers':
			dtsl_statistics_sellers_content($current_user_id);
		break;
		case 'dtsl_statistics_packages':
			dtsl_statistics_packages_content($current_user_id);
		break;
		default:
			dtsl_statistics_listings_content($current_user_id);
		break;
	}

}

?>