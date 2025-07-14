<?php

// Make zero price product purchaseable

add_filter('woocommerce_is_purchasable', '__return_TRUE');


// Get product object
if(!function_exists('dtdr_get_product_object')) {
	function dtdr_get_product_object ( $wc_product_id = 0 ) {

		if ( class_exists( 'WooCommerce' ) ) {

			$wc_product_object = wc_get_product( $wc_product_id );
			return $wc_product_object;

		}

	}
}


// Check item is in cart
if(!function_exists('dtdr_check_item_is_in_cart')) {
	function dtdr_check_item_is_in_cart( $product_id ){

		if ( $product_id > 0 ) {

			if(!is_null(WC()->cart)) {
				foreach( WC()->cart->get_cart() as $cart_item_key => $values ) {
					$cart_product = $values['data'];
					if( $product_id == $cart_product->get_id() ) {
						return true;
					}
				}
			}

		}

		return false;

	}
}

if(!function_exists('dtdr_get_item_price_html')) {
	function dtdr_get_item_price_html($product) {

		$woo_price = '';

		if(!empty($product)) {
			$woo_price = $product->get_price_html();
		}

		return $woo_price;

	}
}

if(!function_exists('dtdr_check_item_has_price')) {
	function dtdr_check_item_has_price($product) {

		$woo_regular_price = $product->get_regular_price();
		$woo_sale_price = $product->get_sale_price();

		if($woo_regular_price > 0 || $woo_sale_price > 0) {
			return true;
		}

		return false;

	}
}

?>