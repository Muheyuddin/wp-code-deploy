<?php

/**
 * WooCommerce - Single - Module - Buy Now - Customizer Settings
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Netlink_Shop_Customizer_Single_Buy_Now' ) ) {

    class Netlink_Shop_Customizer_Single_Buy_Now {

        private static $_instance = null;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            add_filter( 'netlink_woo_single_page_settings', array( $this, 'single_page_settings' ), 10, 1 );
            add_action( 'customize_register', array( $this, 'register' ), 15);

        }

        function single_page_settings( $settings ) {

            $product_buy_now                   = netlink_customizer_settings('wdt-single-product-buy-now' );
            $settings['product_buy_now']       = $product_buy_now;

            return $settings;

        }

        function register( $wp_customize ) {

             /**
            * Option : Enable Buy Now
            */
                $wp_customize->add_setting(
                    NETLINK_CUSTOMISER_VAL . '[wdt-single-product-buy-now]', array(
                        'type' => 'option'
                    )
                );

                $wp_customize->add_control(
                    new Netlink_Customize_Control_Switch(
                        $wp_customize, NETLINK_CUSTOMISER_VAL . '[wdt-single-product-buy-now]', array(
                            'type'    => 'wdt-switch',
                            'label'   => esc_html__( 'Enable Buy Now', 'netlink-pro'),
                            'section' => 'woocommerce-single-page-default-section',
                            'choices' => array(
                                'on'  => esc_attr__( 'Yes', 'netlink-pro' ),
                                'off' => esc_attr__( 'No', 'netlink-pro' )
                            ),
                            'description'   => esc_html__('This option is applicable only for "WooCommerce Default" single page.', 'netlink-pro')
                        )
                    )
                );

        }

    }

}


if( !function_exists('netlink_shop_customizer_single_buy_now') ) {
	function netlink_shop_customizer_single_buy_now() {
		return Netlink_Shop_Customizer_Single_Buy_Now::instance();
	}
}

netlink_shop_customizer_single_buy_now();