<?php

/**
 * Listing Options - Overlay Effect
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Netlink_Woo_Listing_Option_Overlay_Effect' ) ) {

    class Netlink_Woo_Listing_Option_Overlay_Effect extends Netlink_Woo_Listing_Option_Core {

        private static $_instance = null;

        public $option_slug;

        public $option_name;

        public $option_type;

        public $option_default_value;

        public $option_value_prefix;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            $this->option_slug          = 'product-overlay-effect';
            $this->option_name          = esc_html__('Overlay Effect', 'netlink');
            $this->option_type          = array ( 'class', 'value-css' );
            $this->option_default_value = '';
            $this->option_value_prefix  = 'product-overlay-';

            $this->render_backend();

        }

        /*
        Backend Render
        */

            function render_backend() {

                /* Custom Product Templates - Options */
                    add_filter( 'netlink_woo_custom_product_template_hover_options', array( $this, 'woo_custom_product_template_hover_options'), 20, 1 );

            }

        /*
        Custom Product Templates - Options
        */
            function woo_custom_product_template_hover_options( $template_options ) {

                array_push( $template_options, $this->setting_args() );

                return $template_options;

            }

        /*
        Setting Group
        */
            function setting_group() {

                return 'hover';

            }

        /*
        Setting Arguments
        */
            function setting_args() {

                $settings                                 =  array ();

                $settings['id']                           =  $this->option_slug;
                $settings['type']                         =  'select';
                $settings['title']                        =  $this->option_name;
                $settings['options']                      =  array (
                    ''                                    => esc_html__('None', 'netlink'),
                    'product-overlay-fixed'               => esc_html__('Fixed', 'netlink'),
                    'product-overlay-toptobottom'         => esc_html__('Top to Bottom', 'netlink'),
                    'product-overlay-bottomtotop'         => esc_html__('Bottom to Top', 'netlink'),
                    'product-overlay-righttoleft'         => esc_html__('Right to Left', 'netlink'),
                    'product-overlay-lefttoright'         => esc_html__('Left to Right', 'netlink'),
                    'product-overlay-middle'              => esc_html__('Middle', 'netlink'),
                    'product-overlay-middleradial'        => esc_html__('Middle Radial', 'netlink'),
                    'product-overlay-gradienttoptobottom' => esc_html__('Gradient - Top to Bottom', 'netlink'),
                    'product-overlay-gradientbottomtotop' => esc_html__('Gradient - Bottom to Top', 'netlink'),
                    'product-overlay-gradientrighttoleft' => esc_html__('Gradient - Right to Left', 'netlink'),
                    'product-overlay-gradientlefttoright' => esc_html__('Gradient - Left to Right', 'netlink'),
                    'product-overlay-gradientradial'      => esc_html__('Gradient - Radial', 'netlink'),
                    'product-overlay-flash'               => esc_html__('Flash', 'netlink'),
                    'product-overlay-scale'               => esc_html__('Scale', 'netlink'),
                    'product-overlay-horizontalelastic'   => esc_html__('Horizontal - Elastic', 'netlink'),
                    'product-overlay-verticalelastic'     => esc_html__('Vertical - Elastic', 'netlink')
                );
                $settings['default']                      =  $this->option_default_value;

                return $settings;

            }

    }

}

if( !function_exists('netlink_woo_listing_option_overlay_effect') ) {
	function netlink_woo_listing_option_overlay_effect() {
		return Netlink_Woo_Listing_Option_Overlay_Effect::instance();
	}
}

netlink_woo_listing_option_overlay_effect();