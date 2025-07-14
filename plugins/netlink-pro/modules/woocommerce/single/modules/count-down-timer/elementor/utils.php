<?php

/*
* Update Summary - Options Filter
*/

if( ! function_exists( 'netlink_shop_woo_single_summary_options_cnetlink_render' ) ) {
	function netlink_shop_woo_single_summary_options_cnetlink_render( $options ) {

		$options['countdown'] = esc_html__('Summary Count Down', 'netlink-pro');
		return $options;

	}
	add_filter( 'netlink_shop_woo_single_summary_options', 'netlink_shop_woo_single_summary_options_cnetlink_render', 10, 1 );

}

/*
* Update Summary - Styles Filter
*/

if( ! function_exists( 'netlink_shop_woo_single_summary_styles_cnetlink_render' ) ) {
	function netlink_shop_woo_single_summary_styles_cnetlink_render( $styles ) {

		array_push( $styles, 'wdt-shop-coundown-timer' );
		return $styles;

	}
	add_filter( 'netlink_shop_woo_single_summary_styles', 'netlink_shop_woo_single_summary_styles_cnetlink_render', 10, 1 );

}

/*
* Update Summary - Scripts Filter
*/

if( ! function_exists( 'netlink_shop_woo_single_summary_scripts_cnetlink_render' ) ) {
	function netlink_shop_woo_single_summary_scripts_cnetlink_render( $scripts ) {

		array_push( $scripts, 'jquery-downcount' );
		array_push( $scripts, 'wdt-shop-coundown-timer' );
		return $scripts;

	}
	add_filter( 'netlink_shop_woo_single_summary_scripts', 'netlink_shop_woo_single_summary_scripts_cnetlink_render', 10, 1 );

}