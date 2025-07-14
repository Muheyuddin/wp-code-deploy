<?php

/**
 * WooCommerce - Others Class
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Netlink_Pro_Others' ) ) {

    class Netlink_Pro_Others {

        private static $_instance = null;

        private $settings;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            // Load Modules
                $this->load_modules();

        }

        /*
        Load Modules
        */
        function load_modules() {

            // Customizer
                include_once NETLINK_PRO_DIR_PATH . 'modules/woocommerce/others/customizer/index.php';

        }

    }

}

if( !function_exists('netlink_others') ) {
	function netlink_others() {
		return Netlink_Pro_Others::instance();
	}
}

netlink_others();