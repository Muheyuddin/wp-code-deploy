<?php

/**
 * WooCommerce - Single - Module - Additional Info - Customizer Settings
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Netlink_Shop_Customizer_Single_Additional_Info' ) ) {

    class Netlink_Shop_Customizer_Single_Additional_Info {

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

            $product_additional_info                   = netlink_customizer_settings('wdt-single-product-additional-info' );
            $settings['product_additional_info']       = $product_additional_info;

            $product_ai_delivery_period                = netlink_customizer_settings('wdt-single-product-ai-delivery-period' );
            $settings['product_ai_delivery_period']    = $product_ai_delivery_period;

            $product_ai_visitors_min_value             = netlink_customizer_settings('wdt-single-product-ai-visitors-min-value' );
            $settings['product_ai_visitors_min_value'] = $product_ai_visitors_min_value;

            $product_ai_visitors_max_value             = netlink_customizer_settings('wdt-single-product-ai-visitors-max-value' );
            $settings['product_ai_visitors_max_value'] = $product_ai_visitors_max_value;

            return $settings;

        }

        function register( $wp_customize ) {

             /**
            * Option : Enable Additional Info
            */
                $wp_customize->add_setting(
                    NETLINK_CUSTOMISER_VAL . '[wdt-single-product-additional-info]', array(
                        'type' => 'option'
                    )
                );

                $wp_customize->add_control(
                    new Netlink_Customize_Control_Switch(
                        $wp_customize, NETLINK_CUSTOMISER_VAL . '[wdt-single-product-additional-info]', array(
                            'type'    => 'wdt-switch',
                            'label'   => esc_html__( 'Enable Additional Info', 'netlink-pro'),
                            'section' => 'woocommerce-single-page-default-section',
                            'choices' => array(
                                'on'  => esc_attr__( 'Yes', 'netlink-pro' ),
                                'off' => esc_attr__( 'No', 'netlink-pro' )
                            ),
                            'description'   => esc_html__('This option is applicable only for "WooCommerce Default" single page.', 'netlink-pro')
                        )
                    )
                );

            /**
             * Option : Additional Info - Delivery Period
             */
                $wp_customize->add_setting(
                    NETLINK_CUSTOMISER_VAL . '[wdt-single-product-ai-delivery-period]', array(
                        'type' => 'option'
                    )
                );

                $wp_customize->add_control(
                    NETLINK_CUSTOMISER_VAL . '[wdt-single-product-ai-delivery-period]', array(
                        'type'        => 'text',
                        'section'     => 'woocommerce-single-page-default-section',
                        'label'       => esc_html__( 'Additional Info - Delivery Period', 'netlink-pro' ),
                        'dependency'  => array( 'wdt-single-product-additional-info', ' == ', 1 ),
                        'description' => esc_html__('Delivery Offer: If purchased today product will be delivered in below mentioned period ( in days ).', 'netlink-pro')
                    )
                );

            /**
             * Option : Additional Info - Visitors Min Value
             */
                $wp_customize->add_setting(
                    NETLINK_CUSTOMISER_VAL . '[wdt-single-product-ai-visitors-min-value]', array(
                        'type' => 'option'
                    )
                );

                $wp_customize->add_control(
                    NETLINK_CUSTOMISER_VAL . '[wdt-single-product-ai-visitors-min-value]', array(
                        'type'        => 'text',
                        'section'     => 'woocommerce-single-page-default-section',
                        'label'       => esc_html__( 'Additional Info - Visitors Min Value', 'netlink-pro' ),
                        'dependency'  => array( 'wdt-single-product-additional-info', ' == ', 1 ),
                        'description' => esc_html__('Real Time Visitors: Minimum value', 'netlink-pro')
                    )
                );

            /**
             * Option : Additional Info - Visitors Max Value
             */
                $wp_customize->add_setting(
                    NETLINK_CUSTOMISER_VAL . '[wdt-single-product-ai-visitors-max-value]', array(
                        'type' => 'option'
                    )
                );

                $wp_customize->add_control(
                    NETLINK_CUSTOMISER_VAL . '[wdt-single-product-ai-visitors-max-value]', array(
                        'type'        => 'text',
                        'section'     => 'woocommerce-single-page-default-section',
                        'label'       => esc_html__( 'Additional Info - Visitors Max Value', 'netlink-pro' ),
                        'dependency'  => array( 'wdt-single-product-additional-info', ' == ', 1 ),
                        'description' => esc_html__('Real Time Visitors: Maximum value', 'netlink-pro')
                    )
                );


        }

    }

}


if( !function_exists('netlink_shop_customizer_single_additional_info') ) {
	function netlink_shop_customizer_single_additional_info() {
		return Netlink_Shop_Customizer_Single_Additional_Info::instance();
	}
}

netlink_shop_customizer_single_additional_info();