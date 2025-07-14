<?php

require_once DTDR_PLUGIN_PATH . 'statistics/statistics-utils.php';


function dtdr_statistics_options() {

	$current = isset( $_GET['tab'] ) ? dtdr_recursive_sanitize_text_field($_GET['tab']) : 'dtdr_statistics_listings';

	dtdr_get_statistics_submenus($current);
	dtdr_get_statistics_tab($current);

}

function dtdr_get_statistics_submenus($current) {

	$current_user = wp_get_current_user();
	$current_user_id = $current_user->ID;

	$listing_plural_label = apply_filters( 'listing_label', 'plural' );
	$seller_plural_label = apply_filters( 'seller_label', 'plural' );

    $tabs = array (
				'dtdr_statistics_listings' => $listing_plural_label,
				'dtdr_statistics_sellers' => $seller_plural_label,
				'dtdr_statistics_packages' => esc_html__('Packages', 'dtdr'),
    		);

    echo '<h2 class="dtdr-custom-nav nav-tab-wrapper">';
		foreach( $tabs as $key => $tab ) {
			$class = ( $key == $current ) ? 'nav-tab-active' : '';
			echo '<a class="nav-tab '.$class.'" href="?page=dtdr-statistics-options&tab='.$key.'">'.$tab.'</a>';
		}
    echo '</h2>';

}

function dtdr_get_statistics_tab($current) {

	$current_user = wp_get_current_user();
	$current_user_id = $current_user->ID;

	switch($current){
		case 'dtdr_statistics_listings':
			dtdr_statistics_listings_content($current_user_id);
		break;
		case 'dtdr_statistics_sellers':
			dtdr_statistics_sellers_content($current_user_id);
		break;
		case 'dtdr_statistics_packages':
			dtdr_statistics_packages_content($current_user_id);
		break;
		default:
			dtdr_statistics_listings_content($current_user_id);
		break;
	}

}

?>