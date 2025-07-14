<?php

function dtsl_statistics_options() {

	$listing_plural_label = apply_filters( 'dt_sl_listing_label', 'plural' );
	$seller_plural_label = apply_filters( 'dt_sl_seller_label', 'plural' );

	$tabs = array (
		'listings'   => array (
			'label' => $listing_plural_label,
			'callback' => 'dtsl_statistics_listings_content',
			'path' => dtslStatisticsModule()->module_path . 'statistics-listings.php'
		),
		'sellers'     =>  array (
			'label' => $seller_plural_label,
			'path' => dtslStatisticsModule()->module_path . 'statistics-sellers.php'
		),
		'packages'     =>  array (
			'label' => esc_html__('Packages', 'dtsl'),
			'path' => dtslStatisticsModule()->module_path . 'statistics-packages.php'
		)
	);

	$tabs = apply_filters( 'dtsl_statistics', $tabs );

	$current = isset( $_GET['parenttab'] ) ? dtsl_recursive_sanitize_text_field($_GET['parenttab']) : 'listings';

	dtsl_get_statistics_submenus($current, $tabs);
	dtsl_get_statistics_tab($current, $tabs);

}

function dtsl_get_statistics_submenus($current, $tabs) {

	echo '<h2 class="dtsl-custom-nav nav-tab-wrapper">';
		foreach( $tabs as $key => $tab ) {
			$class = ( $key == $current ) ? 'nav-tab-active' : '';
			echo '<a class="nav-tab '.$class.'" href="?page=dtsl-statistics-options&parenttab='.$key.'">'.$tab['label'].'</a>';
		}
	echo '</h2>';

}

function dtsl_get_statistics_tab($current, $tabs) {

	require_once $tabs[$current]['path'];
	call_user_func($tabs[$current]['callback']);

}

?>