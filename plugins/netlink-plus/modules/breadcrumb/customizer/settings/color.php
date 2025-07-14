<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'NetlinkPlusBreadCrumbColor' ) ) {
    class NetlinkPlusBreadCrumbColor {

        private static $_instance = null;
        private $settings         = null;
        private $selector         = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_action( 'customize_register', array( $this, 'register' ), 15);
        }

        function register( $wp_customize ) {

            $wp_customize->add_section(
                new Netlink_Customize_Section(
                    $wp_customize,
                    'site-breadcrumb-color-section',
                    array(
                        'title'    => esc_html__('Colors & Background', 'netlink-plus'),
                        'panel'    => 'site-breadcrumb-main-panel',
                        'priority' => 10,
                    )
                )
            );

            if ( ! defined( 'NETLINK_PRO_VERSION' ) ) {
                $wp_customize->add_control(
                    new Netlink_Customize_Control_Separator(
                        $wp_customize, NETLINK_CUSTOMISER_VAL . '[netlink-plus-site-breadcrumb-color-separator]',
                        array(
                            'type'        => 'wdt-separator',
                            'section'     => 'site-breadcrumb-color-section',
                            'settings'    => array(),
                            'caption'     => NETLINK_PLUS_REQ_CAPTION,
                            'description' => NETLINK_PLUS_REQ_DESC,
                        )
                    )
                );
            }

        }
    }
}

NetlinkPlusBreadCrumbColor::instance();