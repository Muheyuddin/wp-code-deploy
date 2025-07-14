<?php

/**
 * WooCommerce - Others - Cart Notification - Customizer Settings
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Netlink_Shop_Customizer_Others_Cart_Notification' ) ) {

    class Netlink_Shop_Customizer_Others_Cart_Notification {

        private static $_instance = null;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            add_filter( 'netlink_woo_others_settings', array( $this, 'others_settings' ), 10, 1 );
            add_action( 'customize_register', array( $this, 'register' ), 15);

        }

        function others_settings( $settings ) {

            $addtocart_custom_action                   = netlink_customizer_settings('wdt-woo-addtocart-custom-action' );
            $settings['addtocart_custom_action']       = $addtocart_custom_action;

            return $settings;

        }

        function register( $wp_customize ) {

            /**
             * Option : Add To Cart Custom Action
             */

                $wp_customize->add_setting(
                    NETLINK_CUSTOMISER_VAL . '[wdt-woo-addtocart-custom-action]', array(
                        'type' => 'option'
                    )
                );

                $wp_customize->add_control(
                    NETLINK_CUSTOMISER_VAL . '[wdt-woo-addtocart-custom-action]', array(
                        'type'     => 'select',
                        'label'    => esc_html__( 'Add To Cart Custom Action', 'netlink-pro'),
                        'section'  => 'woocommerce-others-section',
                        'choices'  => apply_filters( 'netlink_shop_others_addtocart_custom_action',
                            array(
                                ''                    => esc_html__('None', 'netlink-pro'),
                                'sidebar_widget'      => esc_html__('Sidebar Widget', 'netlink-pro'),
                                'notification_widget' => esc_html__('Notification Widget', 'netlink-pro'),
                            )
                        )
                    )
                );

        }

    }

}


if( !function_exists('netlink_shop_customizer_others_cart_notification') ) {
	function netlink_shop_customizer_others_cart_notification() {
		return Netlink_Shop_Customizer_Others_Cart_Notification::instance();
	}
}

netlink_shop_customizer_others_cart_notification();