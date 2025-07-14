<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'NetlinkPlusSiteLoaderTwo' ) ) {
    class NetlinkPlusSiteLoaderTwo {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_filter( 'netlink_loader_layouts', array( $this, 'add_option' ) );

            $site_loader = netlink_customizer_settings( 'site_loader' );

            if( $site_loader == 'loader-2' ) {

                add_action( 'netlink_after_main_css', array( $this, 'enqueue_assets' ) );

                /**
                 * filter: netlink_primary_color_style - to use primary color
                 * filter: netlink_secondary_color_style - to use secondary color
                 * filter: netlink_tertiary_color_style - to use tertiary color
                 */
                add_filter( 'netlink_primary_color_style', array( $this, 'primary_color_css' ) );
                add_filter( 'netlink_tertiary_color_style', array( $this, 'tertiary_color_style' ) );
            }

        }

        function add_option( $options ) {
            $options['loader-2'] = esc_html__('Loader 2', 'netlink-plus');
            return $options;
        }

        function enqueue_assets() {
            wp_enqueue_style( 'site-loader', NETLINK_PLUS_DIR_URL . 'modules/site-loader/layouts/loader-2/assets/css/loader-2.css', false, NETLINK_PLUS_VERSION, 'all' );
        }

        function primary_color_css( $style ) {
            $style .= ".loader2 { background-color:var( --wdtBodyBGColor );}";
            return $style;
        }

        function tertiary_color_style( $style ) {
            $style .= ".loader2:before { background-color:var( --wdtTertiaryColor );}";
            return $style;
        }
    }
}

NetlinkPlusSiteLoaderTwo::instance();