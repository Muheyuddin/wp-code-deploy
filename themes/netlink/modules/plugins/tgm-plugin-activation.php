<?php
/**
 * Recommends plugins for use with the theme via the TGMA Script
 *
 * @package Netlink WordPress theme
 */

function netlink_tgmpa_plugins_register() {

	// Get array of recommended plugins.

   $plugins_list = array(
        array(
            'name'               => esc_html__('Netlink Plus', 'netlink'),
            'slug'               => 'netlink-plus',
            'source'             => NETLINK_MODULE_DIR . '/plugins/netlink-plus.zip',
            'required'           => true,
            'version'            => '1.0.1',
            'force_activation'   => false,
            'force_deactivation' => false,
        ),
        array(
            'name'               => esc_html__('Netlink Pro', 'netlink'),
            'slug'               => 'netlink-pro',
            'source'             => NETLINK_MODULE_DIR . '/plugins/netlink-pro.zip',
            'required'           => true,
            'version'            => '1.0.2',
            'force_activation'   => false,
            'force_deactivation' => false,
        ),
        array(
            'name'     => esc_html__('Elementor', 'netlink'),
            'slug'     => 'elementor',
            'required' => true,
        ),
        array(
            'name'               => esc_html__('WeDesignTech Elementor Addon', 'netlink'),
            'slug'               => 'wedesigntech-elementor-addon',
            'source'             => NETLINK_MODULE_DIR . '/plugins/wedesigntech-elementor-addon.zip',
            'required'           => true,
            'version'            => '1.0.3',
            'force_activation'   => false,
            'force_deactivation' => false,
        ),
        array(
            'name'               => esc_html__('WeDesignTech Directory Addon', 'netlink'),
            'slug'               => 'wedesigntech-directory-addon',
            'source'             => NETLINK_MODULE_DIR . '/plugins/wedesigntech-directory-addon.zip',
            'required'           => true,
            'version'            => '1.0.0',
            'force_activation'   => false,
            'force_deactivation' => false,
        ),
        array(
            'name'               => esc_html__('WeDesignTech Store Locator', 'netlink'),
            'slug'               => 'wedesigntech-storelocator',
            'source'             => NETLINK_MODULE_DIR . '/plugins/wedesigntech-storelocator.zip',
            'required'           => true,
            'version'            => '1.0.0',
            'force_activation'   => false,
            'force_deactivation' => false,
        ),
        array(
            'name'     => esc_html__('WooCommerce', 'netlink'),
            'slug'     => 'woocommerce',
            'required' => false,
        ),
        array(
            'name'               => esc_html__('Netlink Shop', 'netlink'),
            'slug'               => 'netlink-shop',
            'source'             => NETLINK_MODULE_DIR . '/plugins/netlink-shop.zip',
            'required'           => false,
            'version'            => '1.0.0',
            'force_activation'   => false,
            'force_deactivation' => false,
        ),
        array(
            'name'     => esc_html__('TI WooCommerce Wishlist ', 'netlink'),
            'slug'     => 'ti-woocommerce-wishlist',
            'required' => false,
        ),
        array(
            'name'     => esc_html__('Variation Swatches for WooCommerce ', 'netlink'),
            'slug'     => 'woo-variation-swatches',
            'required' => false,
        ),
        array(
            'name'     => esc_html__('YITH WooCommerce Compare', 'netlink'),
            'slug'     => 'yith-woocommerce-compare',
            'required' => false,
        ),
        array(
            'name'     => esc_html__('Contact Form 7', 'netlink'),
            'slug'     => 'contact-form-7',
            'required' => true,
        ),

        array(
            'name'               => esc_html__('WDT Demo Importer', 'netlink'),
            'slug'               => 'wdt-demo-importer',
            'source'             => NETLINK_MODULE_DIR . '/plugins/wdt-demo-importer.zip',
            'required'           => true,
            'version'            => '1.0.0',
            'force_activation'   => false,
            'force_deactivation' => false,
        )

	);

   
    $plugins = apply_filters('netlink_required_plugins_list',$plugins_list);

	// Register notice
	tgmpa( $plugins, array(
		'id'           => 'netlink_theme',
		'domain'       => 'netlink',
		'menu'         => 'install-required-plugins',
		'has_notices'  => true,
		'is_automatic' => true,
		'dismissable'  => true,
	) );

}
add_action( 'tgmpa_register', 'netlink_tgmpa_plugins_register' );