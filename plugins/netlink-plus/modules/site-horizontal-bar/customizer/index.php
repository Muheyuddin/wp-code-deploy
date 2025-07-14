<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'NetlinkPlusCustomizerSiteHorizontalBar' ) ) {
    class NetlinkPlusCustomizerSiteHorizontalBar {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {

            add_filter( 'netlink_plus_customizer_default', array( $this, 'default' ) );
            add_action( 'netlink_general_cutomizer_options', array( $this, 'register_general' ), 40 );
        }

        function default( $option ) {
            $option['show_site_horizontal_bar'] = '0';
            return $option;
        }

        function register_general( $wp_customize ) {

            $wp_customize->add_section(
                new Netlink_Customize_Section(
                    $wp_customize,
                    'site-horizontal-bar-section',
                    array(
                        'title'    => esc_html__('Horizontal Bar', 'netlink-plus'),
                        'panel'    => 'site-general-main-panel',
                        'priority' => 40,
                    )
                )
            );

                /**
                 * Option : Enable Site Horizontal Bar
                 */
                $wp_customize->add_setting(
                    NETLINK_CUSTOMISER_VAL . '[show_site_horizontal_bar]', array(
                        'type' => 'option',
                    )
                );

                $wp_customize->add_control(
                    new Netlink_Customize_Control_Switch(
                        $wp_customize, NETLINK_CUSTOMISER_VAL . '[show_site_horizontal_bar]', array(
                            'type'    => 'wdt-switch',
                            'section' => 'site-horizontal-bar-section',
                            'label'   => esc_html__( 'Enable Horizontal Bar', 'netlink-plus' ),
                            'choices' => array(
                                'on'  => esc_attr__( 'Yes', 'netlink-plus' ),
                                'off' => esc_attr__( 'No', 'netlink-plus' )
                            )
                        )
                    )
                );
        }
    }
}

NetlinkPlusCustomizerSiteHorizontalBar::instance();