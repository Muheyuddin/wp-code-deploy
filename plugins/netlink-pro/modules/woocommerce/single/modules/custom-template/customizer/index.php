<?php

/**
 * WooCommerce - Single - Module - Custom Template - Customizer Settings
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Netlink_Shop_Customizer_Single_Default_CT' ) ) {

    class Netlink_Shop_Customizer_Single_Default_CT {

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

            $product_default_template             = netlink_customizer_settings('wdt-single-product-default-template' );
            $settings['product_default_template'] = $product_default_template;

            return $settings;

        }

        function register( $wp_customize ) {

            /**
             * Option : Product Template
             */
                $wp_customize->add_setting(
                    NETLINK_CUSTOMISER_VAL . '[wdt-single-product-default-template]', array(
                        'type' => 'option'
                    )
                );

                $wp_customize->add_control(
                    NETLINK_CUSTOMISER_VAL . '[wdt-single-product-default-template]', array(
                        'type'     => 'select',
                        'label'    => esc_html__( 'Product Template', 'netlink-pro'),
                        'section'  => 'woocommerce-single-page-default-section',
                        'choices'  => apply_filters( 'netlink_shop_single_product_default_template', array(
                                        'woo-default'     => esc_html__( 'WooCommerce Default', 'netlink-pro' ),
                                        'custom-template' => esc_html__( 'Custom Template', 'netlink-pro' )
                                    ) )
                    )
                );

        }

    }

}


if( !function_exists('netlink_shop_customizer_single_default_ct') ) {
	function netlink_shop_customizer_single_default_ct() {
		return Netlink_Shop_Customizer_Single_Default_CT::instance();
	}
}

netlink_shop_customizer_single_default_ct();