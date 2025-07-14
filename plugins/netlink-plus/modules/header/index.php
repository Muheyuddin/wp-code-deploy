<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'NetlinkPlusHeader' ) ) {
    class NetlinkPlusHeader {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            $this->load_header_layouts();
            $this->load_modules();
            $this->frontend();
        }

        function load_header_layouts() {
            foreach( glob( NETLINK_PLUS_DIR_PATH. 'modules/header/layouts/*/index.php'  ) as $module ) {
                include_once $module;
            }
        }

        function load_modules() {
            include_once NETLINK_PLUS_DIR_PATH.'modules/header/customizer/index.php';
            include_once NETLINK_PLUS_DIR_PATH.'modules/header/elementor/index.php';
        }

        function frontend() {
            add_action( 'netlink_after_main_css', array( $this, 'enqueue_assets' ) );
        }

        function enqueue_assets() {
            wp_enqueue_style( 'site-header', NETLINK_PLUS_DIR_URL . 'modules/header/assets/css/header.css', NETLINK_PLUS_VERSION );
        }

    }
}

NetlinkPlusHeader::instance();