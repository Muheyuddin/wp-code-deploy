<?php

/**
 * WooCommerce - Others - Quantity Plus Minus - Customizer Settings
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Netlink_Shop_Customizer_Others_Quantity_Plus_Minus' ) ) {

    class Netlink_Shop_Customizer_Others_Quantity_Plus_Minus {

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

            $enable_quantity_plusminus             = netlink_customizer_settings('wdt-woo-others-enable-quantity-plusminus' );
            $settings['enable_quantity_plusminus'] = $enable_quantity_plusminus;

            return $settings;

        }

        function register( $wp_customize ) {

            /**
             * Option : Enable Quantity Plus Minus
             */

                $wp_customize->add_setting(
                    NETLINK_CUSTOMISER_VAL . '[wdt-woo-others-enable-quantity-plusminus]', array(
                        'type' => 'option',
                        'sanitize_callback' => 'wp_filter_nohtml_kses'
                    )
                );

                $wp_customize->add_control(
                    new Netlink_Customize_Control_Switch(
                        $wp_customize, NETLINK_CUSTOMISER_VAL . '[wdt-woo-others-enable-quantity-plusminus]', array(
                            'type'    => 'wdt-switch',
                            'label'   => esc_html__( 'Enable Quantity Plus Minus', 'netlink'),
                            'section' => 'woocommerce-others-section',
                            'choices' => array(
                                'on'  => esc_attr__( 'Yes', 'netlink' ),
                                'off' => esc_attr__( 'No', 'netlink' )
                            )
                        )
                    )
                );

        }

    }

}


if( !function_exists('netlink_shop_customizer_others_quantity_plus_minus') ) {
	function netlink_shop_customizer_others_quantity_plus_minus() {
		return Netlink_Shop_Customizer_Others_Quantity_Plus_Minus::instance();
	}
}

netlink_shop_customizer_others_quantity_plus_minus();