<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'NetlinkPlusBreadcrumbRight' ) ) {
    class NetlinkPlusBreadcrumbRight {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_filter( 'netlink_plus_breadcrumb_layouts', array( $this, 'add_option' ) );
        }

        function add_option( $options ) {
            $options['breadcrumb-right'] = esc_html__('Breadcrumb Right', 'netlink-plus');
            return $options;
        }
    }
}

NetlinkPlusBreadcrumbRight::instance();