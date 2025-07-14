<?php

/*
* Update Summary Options Filter
*/

if( ! function_exists( 'netlink_shop_woo_single_summary_options_ssf_render' ) ) {
	function netlink_shop_woo_single_summary_options_ssf_render( $options ) {

		$options['share_follow'] = esc_html__('Summary Share / Follow', 'netlink-pro');
		return $options;

	}
	add_filter( 'netlink_shop_woo_single_summary_options', 'netlink_shop_woo_single_summary_options_ssf_render', 10, 1 );

}


/*
* Update Summary - Styles Filter
*/

if( ! function_exists( 'netlink_shop_woo_single_summary_styles_ssf_render' ) ) {
	function netlink_shop_woo_single_summary_styles_ssf_render( $styles ) {

		array_push( $styles, 'wdt-shop-social-share-and-follow' );
		return $styles;

	}
	add_filter( 'netlink_shop_woo_single_summary_styles', 'netlink_shop_woo_single_summary_styles_ssf_render', 10, 1 );

}
