<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'NetlinkProDemoContent' ) ) {
    class NetlinkProDemoContent {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_filter('fw:ext:backups-demo:demos', array( $this, 'fw_ext_backups_demos' ), 20);
        }

        function fw_ext_backups_demos($demos) {
            $demos_array = array(
                'default-demo' => array(
                    'title' => esc_html__('Default Demo', 'netlink-pro'),
                    'screenshot' => NETLINK_PRO_DIR_URL.'/modules/demo-content/screenshots/default-demo.png',
                    'preview_link' => 'https://wdtnetlink.wpengine.com/',
                ),
                'rtl-demo' => array(
                    'title' => esc_html__('RTL Demo', 'netlink-pro'),
                    'screenshot' => NETLINK_PRO_DIR_URL.'/modules/demo-content/screenshots/rtl-demo.png',
                    'preview_link' => 'https://wdtnetlink.wpengine.com/rtl-demo/',
                )
            );

            $download_url = 'http://phpstack-209721-3692979.cloudwaysapps.com/netlink-demo-content/index.php';

            foreach ($demos_array as $id => $data) {
                $demo = new FW_Ext_Backups_Demo($id, 'piecemeal', array(
                    'url' => $download_url,
                    'file_id' => $id,
                ));
                $demo->set_title($data['title']);
                $demo->set_screenshot($data['screenshot']);
                $demo->set_preview_link($data['preview_link']);

                $demos[ $demo->get_id() ] = $demo;

                unset($demo);
            }

            return $demos;
        }

    }
}

NetlinkProDemoContent::instance();