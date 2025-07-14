<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'NetlinkPlusSiteToTop' ) ) {
    class NetlinkPlusSiteToTop {

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
            include_once NETLINK_PLUS_DIR_PATH.'modules/site-to-top/customizer/index.php';
        }

        function frontend() {
            $show = netlink_customizer_settings('show_site_to_top');
            if( $show ) {
                add_filter( 'body_class', array( $this, 'add_body_classes' ) );
                add_action( 'netlink_after_main_css', array( $this, 'enqueue_assets' ) );
                add_action( 'wp_footer', array( $this, 'load_template' ), 999 );
            }
        }

        function add_body_classes( $classes ) {
            $classes[] = 'has-go-to-top';
            return $classes;
        }

        function enqueue_assets() {
            wp_enqueue_style( 'site-to-top', NETLINK_PLUS_DIR_URL . 'modules/site-to-top/assets/css/totop.css', false, NETLINK_PLUS_VERSION, 'all' );
            wp_enqueue_script( 'go-to-top', NETLINK_PLUS_DIR_URL . 'modules/site-to-top/assets/js/go-to-top.js', array('jquery'), NETLINK_PLUS_VERSION, true );
        }

        function load_template() {
            $args = array(
                'icon' => '<svg class="wifi-totop" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                    viewBox="0 0 60 40" style="enable-background:new 0 0 60 94.8;" xml:space="preserve">
               <g class="wifi-wrapper">
                   <g class="wifi-top-wrap">
                       <g class="wifi-top-center">
                       <path d="M30,27.8c3.3,0,6-2.7,6-6s-2.7-6-6-6c-3.3,0-6,2.7-6,6S26.7,27.8,30,27.8z M30,19.8c1.1,0,2,0.9,2,2s-0.9,2-2,2
                           s-2-0.9-2-2S28.9,19.8,30,19.8z"/>
                       </g>
                       <g class="wifi-top-left">
                           <path d="M20.1,31.7c0.4,0.4,0.9,0.6,1.4,0.6s1-0.2,1.4-0.6c0.8-0.8,0.8-2,0-2.8C21,27,20,24.5,20,21.8s1-5.2,2.9-7.1
                               c0.8-0.8,0.8-2.1,0-2.8c-0.8-0.8-2-0.8-2.8,0c-2.6,2.6-4.1,6.2-4.1,9.9C16,25.5,17.5,29,20.1,31.7z"/>
                           <path d="M14.4,37.3c0.4,0.4,0.9,0.6,1.4,0.6s1-0.2,1.4-0.6c0.8-0.8,0.8-2,0-2.8c-3.4-3.4-5.3-7.9-5.3-12.7
                               c0-4.8,1.9-9.3,5.3-12.7c0.8-0.8,0.8-2,0-2.8s-2-0.8-2.8,0C10.3,10.4,8,15.9,8,21.8S10.3,33.2,14.4,37.3z"/>
                           <path d="M10.2,43.6c0.5,0,1-0.2,1.4-0.6c0.8-0.8,0.8-2,0-2.8C6.7,35.3,4,28.7,4,21.8S6.7,8.3,11.6,3.4c0.8-0.8,0.8-2,0-2.8
                               s-2-0.8-2.8,0C3.1,6.3,0,13.8,0,21.8S3.1,37.3,8.8,43C9.2,43.4,9.7,43.6,10.2,43.6z"/>
                       </g>
                       <g class="wifi-top-right">
                           <path d="M37.1,31.7c0.4,0.4,0.9,0.6,1.4,0.6s1-0.2,1.4-0.6c2.6-2.6,4.1-6.2,4.1-9.9s-1.5-7.3-4.1-9.9c-0.8-0.8-2-0.8-2.8,0
                               c-0.8,0.8-0.8,2,0,2.8c1.9,1.9,2.9,4.4,2.9,7.1s-1,5.2-2.9,7.1C36.3,29.6,36.3,30.9,37.1,31.7z"/>
                           <path d="M47.9,21.8c0,4.8-1.7,9.3-4.7,12.7c-0.7,0.8-0.7,2,0,2.8c0.3,0.4,0.8,0.6,1.3,0.6c0.5,0,0.9-0.2,1.3-0.6
                               c3.7-4.2,5.8-9.7,5.8-15.6s-2-11.4-5.8-15.6c-0.7-0.8-1.8-0.8-2.5,0c-0.7,0.8-0.7,2,0,2.8C46.2,12.5,47.9,17,47.9,21.8z"/>
                           <path d="M56,21.8c0,6.9-2.7,13.5-7.6,18.4c-0.8,0.8-0.8,2,0,2.8c0.4,0.4,0.9,0.6,1.4,0.6c0.5,0,1-0.2,1.4-0.6
                               c5.7-5.7,8.8-13.2,8.8-21.2S56.9,6.2,51.2,0.6c-0.8-0.8-2-0.8-2.8,0c-0.8,0.8-0.8,2,0,2.8C53.3,8.3,56,14.8,56,21.8z"/>
                       </g>
                   </g>
               </g>
               </svg>'
            );

            echo netlink_get_template_part( 'site-to-top/layouts/', 'template', '', $args );
        }
    }
}

NetlinkPlusSiteToTop::instance();