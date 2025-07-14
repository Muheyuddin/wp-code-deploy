<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'NetlinkPlusWidgetContentSettings' ) ) {
    class NetlinkPlusWidgetContentSettings {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_action( 'customize_register', array( $this, 'register' ), 15);
        }

        function register( $wp_customize ){

            /**
             * Content Section
             */
            $wp_customize->add_section(
                new Netlink_Customize_Section(
                    $wp_customize,
                    'site-widgets-content-style-section',
                    array(
                        'title'    => esc_html__('Widget Content', 'netlink-plus'),
                        'panel'    => 'site-widget-settings-panel',
                        'priority' => 10,
                    )
                )
            );

            if ( ! defined( 'NETLINK_PRO_VERSION' ) ) {
                $wp_customize->add_control(
                    new Netlink_Customize_Control_Separator(
                        $wp_customize, NETLINK_CUSTOMISER_VAL . '[netlink-plus-site-widgets-content-style-separator]',
                        array(
                            'type'        => 'wdt-separator',
                            'section'     => 'site-widgets-content-style-section',
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

NetlinkPlusWidgetContentSettings::instance();