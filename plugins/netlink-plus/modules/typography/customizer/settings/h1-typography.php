<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'NetlinkPlusH1Settings' ) ) {
    class NetlinkPlusH1Settings {

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

            $this->selector = apply_filters( 'netlink_h1_selector', array( 'h1' ) );
            $this->settings = netlink_customizer_settings('h1_typo');

            add_filter( 'netlink_plus_customizer_default', array( $this, 'default' ) );
            add_action( 'customize_register', array( $this, 'register' ), 20);

            add_filter( 'netlink_h1_typo_customizer_update', array( $this, 'h1_typo_customizer_update' ) );

            add_filter( 'netlink_google_fonts_list', array( $this, 'fonts_list' ) );
            add_filter( 'netlink_add_inline_style', array( $this, 'base_style' ) );
            add_filter( 'netlink_add_tablet_landscape_inline_style', array( $this, 'tablet_landscape_style' ) );
            add_filter( 'netlink_add_tablet_portrait_inline_style', array( $this, 'tablet_portrait' ) );
            add_filter( 'netlink_add_mobile_res_inline_style', array( $this, 'mobile_style' ) );
        }

        function default( $option ) {
            $theme_defaults = function_exists('netlink_theme_defaults') ? netlink_theme_defaults() : array ();
            $option['h1_typo'] = $theme_defaults['h1_typo'];
            return $option;
        }

        function register( $wp_customize ) {

            $wp_customize->add_section(
                new Netlink_Customize_Section(
                    $wp_customize,
                    'site-h1-section',
                    array(
                        'title'    => esc_html__('H1 Typography', 'netlink-plus'),
                        'panel'    => 'site-typography-main-panel',
                        'priority' => 5,
                    )
                )
            );

            /**
             * Option :H1 Typo
             */
                $wp_customize->add_setting(
                    NETLINK_CUSTOMISER_VAL . '[h1_typo]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new Netlink_Customize_Control_Typography(
                        $wp_customize, NETLINK_CUSTOMISER_VAL . '[h1_typo]', array(
                            'type'    => 'wdt-typography',
                            'section' => 'site-h1-section',
                            'label'   => esc_html__( 'H1 Tag', 'netlink-plus')
                        )
                    )
                );

            /**
             * Option : H1 Color
             */
                $wp_customize->add_setting(
                    NETLINK_CUSTOMISER_VAL . '[h1_color]', array(
                        'default' => '',
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new WP_Customize_Color_Control(
                        $wp_customize, NETLINK_CUSTOMISER_VAL . '[h1_color]', array(
                            'label'   => esc_html__( 'Color', 'netlink-plus' ),
                            'section' => 'site-h1-section',
                        )
                    )
                );

        }

        function h1_typo_customizer_update( $defaults ) {
            $h1_typo = netlink_customizer_settings( 'h1_typo' );
            if( !empty( $h1_typo ) ) {
                return  $h1_typo;
            }
            return $defaults;
        }

        function fonts_list( $fonts ) {
            return netlink_customizer_frontend_font( $this->settings, $fonts );
        }

        function base_style( $style ) {
            $css   = '';
            $color = netlink_customizer_settings('h1_color');

            $css .= netlink_customizer_typography_settings( $this->settings );
            $css .= netlink_customizer_color_settings( $color );

            $css = netlink_customizer_dynamic_style( $this->selector, $css );

            return $style.$css;
        }

        function tablet_landscape_style( $style ) {
            $css = netlink_customizer_responsive_typography_settings( $this->settings, 'tablet-ls' );
            $css = netlink_customizer_dynamic_style( $this->selector, $css );

            return $style.$css;
        }

        function tablet_portrait( $style ) {
            $css = netlink_customizer_responsive_typography_settings( $this->settings, 'tablet' );
            $css = netlink_customizer_dynamic_style( $this->selector, $css );

            return $style.$css;
        }

        function mobile_style( $style ) {
            $css = netlink_customizer_responsive_typography_settings( $this->settings, 'mobile' );
            $css = netlink_customizer_dynamic_style( $this->selector, $css );

            return $style.$css;
        }

    }
}

NetlinkPlusH1Settings::instance();