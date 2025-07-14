<?php
/**
 * Plugin Name:	Netlink Pro
 * Description: Adds advanced features for Netlink Theme.
 * Version: 1.0.2
 * Author: the WeDesignTech team
 * Author URI: https://wedesignthemes.com/
 * Text Domain: netlink-pro
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'NetlinkPro' ) ) {
    class NetlinkPro {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {

            $this->define_constants();

            /**
             * Before Hook
             */
            do_action( 'netlink_pro_before_plugin_load' );

                $this->load_helper();
                $this->load_modules();
                $this->frontend();
                $this->load_post_types();
                $this->load_widget_area_generator();

                add_filter( 'cs_framework_settings', array ( $this, 'netlink_cs_framework_settings' ) );

                add_action( 'plugins_loaded', array( $this, 'check_if_user_logged_in' ) );

            /**
             * After Hook
             */
            do_action( 'netlink_pro_after_plugin_load' );
        }

        function check_if_user_logged_in() {

            $this->load_codestar();

        }

        function define_constants() {

            define( 'NETLINK_PRO_VERSION', '1.0.0' );
            define( 'NETLINK_PRO_DIR_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
            define( 'NETLINK_PRO_DIR_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );
            if( !defined('NETLINK_CUSTOMISER_VAL') ) {
                define( 'NETLINK_CUSTOMISER_VAL', 'netlink-customiser-option');
            }

        }

        function i18n() {
            add_action( 'plugins_loaded', array( $this, 'i18n' ) );
            load_plugin_textdomain( 'netlink-pro', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
        }

        function load_codestar() {
            if( !defined( 'CS_OPTION' ) ) {
                define( 'CS_OPTION', '_netlink_cs_options' );
            }
            define( 'WDT_CS_FOLDER_PATH', 'netlink-pro' );
            require_once NETLINK_PRO_DIR_PATH . 'cs-framework/cs-framework.php';
        }

        function load_helper() {
            require_once NETLINK_PRO_DIR_PATH . 'functions.php';
        }

        function load_modules() {

            /**
             * Before Hook
             */
            do_action( 'netlink_pro_before_load_modules' );

                foreach( glob( NETLINK_PRO_DIR_PATH. 'modules/*/index.php'  ) as $module ) {
                    include_once $module;
                }

            /**
             * After Hook
             */
            do_action( 'netlink_pro_after_load_modules' );

        }

        function load_post_types() {
            require_once NETLINK_PRO_DIR_PATH . 'post-types/post-types.php';
        }

        function load_widget_area_generator() {
            require_once NETLINK_PRO_DIR_PATH . 'widget-area/widget-area.php';
        }

        function frontend() {
            add_filter( 'body_class', array( $this, 'add_body_classes' ) );
            add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
        }

        function add_body_classes( $classes ) {
            $classes[] = 'netlink-pro-'.NETLINK_PRO_VERSION;
            return $classes;
        }

        function enqueue_assets() {

            /**
             * Add Common css & javascript
             */

            wp_enqueue_style( 'netlink-pro-widget', NETLINK_PRO_DIR_URL . 'assets/css/widget.css', false, NETLINK_PRO_VERSION, 'all');

            do_action( 'netlink_pro_after_asset_enqueue' );
        }

        function netlink_cs_framework_settings($settings){

	        $settings           = array(
	          'menu_title'      => esc_html__('Netlink Settings', 'netlink-pro'),
	          'menu_type'       => 'menu',
	          'menu_slug'       => 'netlink-pro-settings',
	          'ajax_save'       => true,
	          'show_reset_all'  => false,
	          'framework_title' => esc_html__('Netlink', 'netlink-pro'),
	        );

            return apply_filters( 'netlink_pro_cs_framework_settings', $settings );
        }

    }
}

if( !function_exists( 'netlink_pro' ) ) {
    function netlink_pro() {
        return NetlinkPro::instance();
    }
}

register_activation_hook( __FILE__, 'netlink_pro_activation_hook' );
function netlink_pro_activation_hook() {
    if (!class_exists ( 'NetlinkPlus' )) {
        deactivate_plugins( plugin_basename( __FILE__ ) );
        $message = sprintf(
            esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'netlink-pro' ),
            '<strong>' . esc_html__( 'Netlink Pro Plugin', 'netlink-pro' ) . '</strong>',
            '<strong>' . esc_html__( 'Netlink Plus Plugin', 'netlink-pro' ) . '</strong>'
        );
        wp_die( sprintf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message ), 'Plugin dependency check', array( 'back_link' => true ) );
    } else {
        netlink_pro();

        // Updating customizer default values
        $saved_settings = get_option( NETLINK_CUSTOMISER_VAL );
        $saved_settings = (is_array($saved_settings) && !empty($saved_settings)) ? $saved_settings : array ();

        if(!array_key_exists('pro-settings-updated',  $saved_settings)) {
            $pro_defaults = apply_filters( 'netlink_pro_customizer_default', array( 'pro-settings-updated' => true ) );
            $saved_settings = array_merge($saved_settings, $pro_defaults);
        }

        if(class_exists('WooCommerce')) {
            if(!array_key_exists('shop-pro-settings-updated',  $saved_settings)) {
                $shop_pro_defaults = apply_filters( 'netlink_shop_pro_customizer_default', array( 'shop-pro-settings-updated' => true ) );
                $saved_settings = array_merge($saved_settings, $shop_pro_defaults);
            }
        }

        if(!empty($saved_settings)) {
            update_option( constant( 'NETLINK_CUSTOMISER_VAL' ), $saved_settings );
        }

    }
}

if (class_exists ( 'NetlinkPlus' ) && class_exists ( 'NetlinkPro' )) {
    netlink_pro();
} else {
    add_action( 'admin_init', 'netlink_init' );
    function netlink_init() {
        deactivate_plugins( __FILE__ );
    }
}