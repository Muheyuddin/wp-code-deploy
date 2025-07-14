<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'NetlinkPlusSiteHorizontalBar' ) ) {
    class NetlinkPlusSiteHorizontalBar {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            $this->load_modules();
            $this->frontend();
        }

        function load_modules() {
            include_once NETLINK_PLUS_DIR_PATH.'modules/site-horizontal-bar/customizer/index.php';
        }

        function frontend() {
            $show = netlink_customizer_settings('show_site_horizontal_bar');
            if( $show ) {
                add_filter( 'body_class', array( $this, 'add_body_classes' ) );
                add_action( 'netlink_after_main_css', array( $this, 'enqueue_assets' ) );
                add_action( 'wp_head', array( $this, 'load_template' ), 999 );
            }
        }

        function add_body_classes( $classes ) {
            $classes[] = 'has-horizontal-bar';
            return $classes;
        }

        function enqueue_assets() {
            wp_enqueue_style( 'site-horizontal-bar', NETLINK_PLUS_DIR_URL . 'modules/site-horizontal-bar/assets/css/horizontal-progress-bar.css', false, NETLINK_PLUS_VERSION, 'all' );
            wp_enqueue_script( 'horizontal-progress-bar', NETLINK_PLUS_DIR_URL . 'modules/site-horizontal-bar/assets/js/horizontal-progress-bar.js', array('jquery'), NETLINK_PLUS_VERSION, true );
        }

        function load_template() {
            $args = array(
                'icon' => '<i class="wdticon-angle-up"></i>'
            );

            echo netlink_get_template_part( 'site-horizontal-bar/layouts/', 'template', '', $args );
        }
    }
}

NetlinkPlusSiteHorizontalBar::instance();