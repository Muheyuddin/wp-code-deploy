<?php

/**
 * WooCommerce - Elementor Search Widgets Core Class
 */

namespace NetlinkElementor\widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Netlink_Shop_Elementor_Search_Widgets {

	/**
	 * A Reference to an instance of this class
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 */
	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Constructor
	 */
	function __construct() {

		add_action( 'netlink_shop_register_widgets', array( $this, 'netlink_shop_register_widgets' ), 10, 1 );

		add_action( 'netlink_shop_register_widget_styles', array( $this, 'netlink_shop_register_widget_styles' ), 10, 1 );
		add_action( 'netlink_shop_register_widget_scripts', array( $this, 'netlink_shop_register_widget_scripts' ), 10, 1 );

		add_action( 'netlink_shop_preview_styles', array( $this, 'netlink_shop_preview_styles') );

	}

	/**
	 * Register widgets
	 */
	function netlink_shop_register_widgets( $widgets_manager ) {

		require netlink_shop_others_search()->module_dir_path() . 'elementor/widgets/product-search/class-product-search.php';
		$widgets_manager->register( new Netlink_Shop_Widget_Product_Search() );

	}

	/**
	 * Register widgets styles
	 */
	function netlink_shop_register_widget_styles( $suffix ) {

		# Product Search

			wp_register_style( 'wdt-shop-product-search',
				netlink_shop_others_search()->module_dir_url() . 'elementor/widgets/product-search/assets/css/style'.$suffix.'.css',
				array()
			);

	}

	/**
	 * Register widgets scripts
	 */
	function netlink_shop_register_widget_scripts( $suffix ) {


	}

	/**
	 * Editor Preview Style
	 */
	function netlink_shop_preview_styles() {

		# Product Search
			wp_enqueue_style( 'wdt-shop-product-search-chosen' );
			wp_enqueue_style( 'wdt-shop-product-search' );

	}

}

Netlink_Shop_Elementor_Search_Widgets::instance();