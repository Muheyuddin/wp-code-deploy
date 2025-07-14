<?php

/**
 * WooCommerce - Single - Module - Social Share & Follow - Customizer Settings
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Netlink_Shop_Customizer_Single_Social_Share_And_Follow' ) ) {

    class Netlink_Shop_Customizer_Single_Social_Share_And_Follow {

        private static $_instance = null;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            add_filter( 'netlink_woo_single_page_settings', array( $this, 'single_page_settings' ), 10, 1 );
            add_action( 'customize_register', array( $this, 'register' ), 15);

        }

        function single_page_settings( $settings ) {

            $product_show_sharer_facebook                = netlink_customizer_settings('wdt-single-product-show-sharer-facebook' );
            $settings['product_show_sharer_facebook']    = $product_show_sharer_facebook;

            $product_show_sharer_delicious               = netlink_customizer_settings('wdt-single-product-show-sharer-delicious' );
            $settings['product_show_sharer_delicious']   = $product_show_sharer_delicious;

            $product_show_sharer_digg                    = netlink_customizer_settings('wdt-single-product-show-sharer-digg' );
            $settings['product_show_sharer_digg']        = $product_show_sharer_digg;

            $product_show_sharer_twitter                 = netlink_customizer_settings('wdt-single-product-show-sharer-twitter' );
            $settings['product_show_sharer_twitter']     = $product_show_sharer_twitter;

            $product_show_sharer_linkedin                = netlink_customizer_settings('wdt-single-product-show-sharer-linkedin' );
            $settings['product_show_sharer_linkedin']    = $product_show_sharer_linkedin;

            $product_show_sharer_pinterest               = netlink_customizer_settings('wdt-single-product-show-sharer-pinterest' );
            $settings['product_show_sharer_pinterest']   = $product_show_sharer_pinterest;

            return $settings;

        }

        function register( $wp_customize ) {

            /**
            * Share
            */

                /**
                * Option : Sharer Description
                */
                    $wp_customize->add_setting(
                        NETLINK_CUSTOMISER_VAL . '[wdt-single-product-show-sharer-description]', array(
                            'type' => 'option'
                        )
                    );

                    $wp_customize->add_control(
                        new Netlink_Customize_Control_Switch(
                            $wp_customize, NETLINK_CUSTOMISER_VAL . '[wdt-single-product-show-sharer-description]', array(
                                'type'        => 'wdt-description',
                                'label'       => esc_html__( 'Note: ', 'netlink-pro'),
                                'section'     => 'woocommerce-single-page-sociable-share-section',
                                'description' => esc_html__( 'This option is applicable only for WooCommerce "Custom Template".', 'netlink-pro')
                            )
                        )
                    );

                /**
                * Option : Show Facebook Sharer
                */
                    $wp_customize->add_setting(
                        NETLINK_CUSTOMISER_VAL . '[wdt-single-product-show-sharer-facebook]', array(
                            'type' => 'option'
                        )
                    );

                    $wp_customize->add_control(
                        new Netlink_Customize_Control_Switch(
                            $wp_customize, NETLINK_CUSTOMISER_VAL . '[wdt-single-product-show-sharer-facebook]', array(
                                'type'    => 'wdt-switch',
                                'label'   => esc_html__( 'Show Facebook Sharer', 'netlink-pro'),
                                'section' => 'woocommerce-single-page-sociable-share-section',
                                'choices' => array(
                                    'on'  => esc_attr__( 'Yes', 'netlink-pro' ),
                                    'off' => esc_attr__( 'No', 'netlink-pro' )
                                )
                            )
                        )
                    );

                /**
                * Option : Show Delicious Sharer
                */
                    $wp_customize->add_setting(
                        NETLINK_CUSTOMISER_VAL . '[wdt-single-product-show-sharer-delicious]', array(
                            'type' => 'option'
                        )
                    );

                    $wp_customize->add_control(
                        new Netlink_Customize_Control_Switch(
                            $wp_customize, NETLINK_CUSTOMISER_VAL . '[wdt-single-product-show-sharer-delicious]', array(
                                'type'    => 'wdt-switch',
                                'label'   => esc_html__( 'Show Delicious Sharer', 'netlink-pro'),
                                'section' => 'woocommerce-single-page-sociable-share-section',
                                'choices' => array(
                                    'on'  => esc_attr__( 'Yes', 'netlink-pro' ),
                                    'off' => esc_attr__( 'No', 'netlink-pro' )
                                )
                            )
                        )
                    );

                /**
                * Option : Show Digg Sharer
                */
                    $wp_customize->add_setting(
                        NETLINK_CUSTOMISER_VAL . '[wdt-single-product-show-sharer-digg]', array(
                            'type' => 'option'
                        )
                    );

                    $wp_customize->add_control(
                        new Netlink_Customize_Control_Switch(
                            $wp_customize, NETLINK_CUSTOMISER_VAL . '[wdt-single-product-show-sharer-digg]', array(
                                'type'    => 'wdt-switch',
                                'label'   => esc_html__( 'Show Digg Sharer', 'netlink-pro'),
                                'section' => 'woocommerce-single-page-sociable-share-section',
                                'choices' => array(
                                    'on'  => esc_attr__( 'Yes', 'netlink-pro' ),
                                    'off' => esc_attr__( 'No', 'netlink-pro' )
                                )
                            )
                        )
                    );

                /**
                * Option : Show Twitter Sharer
                */
                    $wp_customize->add_setting(
                        NETLINK_CUSTOMISER_VAL . '[wdt-single-product-show-sharer-twitter]', array(
                            'type' => 'option'
                        )
                    );

                    $wp_customize->add_control(
                        new Netlink_Customize_Control_Switch(
                            $wp_customize, NETLINK_CUSTOMISER_VAL . '[wdt-single-product-show-sharer-twitter]', array(
                                'type'    => 'wdt-switch',
                                'label'   => esc_html__( 'Show Twitter Sharer', 'netlink-pro'),
                                'section' => 'woocommerce-single-page-sociable-share-section',
                                'choices' => array(
                                    'on'  => esc_attr__( 'Yes', 'netlink-pro' ),
                                    'off' => esc_attr__( 'No', 'netlink-pro' )
                                )
                            )
                        )
                    );

                /**
                * Option : Show LinkedIn Sharer
                */
                    $wp_customize->add_setting(
                        NETLINK_CUSTOMISER_VAL . '[wdt-single-product-show-sharer-linkedin]', array(
                            'type' => 'option'
                        )
                    );

                    $wp_customize->add_control(
                        new Netlink_Customize_Control_Switch(
                            $wp_customize, NETLINK_CUSTOMISER_VAL . '[wdt-single-product-show-sharer-linkedin]', array(
                                'type'    => 'wdt-switch',
                                'label'   => esc_html__( 'Show LinkedIn Sharer', 'netlink-pro'),
                                'section' => 'woocommerce-single-page-sociable-share-section',
                                'choices' => array(
                                    'on'  => esc_attr__( 'Yes', 'netlink-pro' ),
                                    'off' => esc_attr__( 'No', 'netlink-pro' )
                                )
                            )
                        )
                    );

                /**
                * Option : Show Pinterest Sharer
                */
                    $wp_customize->add_setting(
                        NETLINK_CUSTOMISER_VAL . '[wdt-single-product-show-sharer-pinterest]', array(
                            'type' => 'option'
                        )
                    );

                    $wp_customize->add_control(
                        new Netlink_Customize_Control_Switch(
                            $wp_customize, NETLINK_CUSTOMISER_VAL . '[wdt-single-product-show-sharer-pinterest]', array(
                                'type'    => 'wdt-switch',
                                'label'   => esc_html__( 'Show Pinterest Sharer', 'netlink-pro'),
                                'section' => 'woocommerce-single-page-sociable-share-section',
                                'choices' => array(
                                    'on'  => esc_attr__( 'Yes', 'netlink-pro' ),
                                    'off' => esc_attr__( 'No', 'netlink-pro' )
                                )
                            )
                        )
                    );

            /**
            * Follow
            */

                /**
                * Option : Follow Description
                */
                    $wp_customize->add_setting(
                        NETLINK_CUSTOMISER_VAL . '[wdt-single-product-show-follow-description]', array(
                            'type' => 'option'
                        )
                    );

                    $wp_customize->add_control(
                        new Netlink_Customize_Control_Switch(
                            $wp_customize, NETLINK_CUSTOMISER_VAL . '[wdt-single-product-show-follow-description]', array(
                                'type'    => 'wdt-description',
                                'label'   => esc_html__( 'Note :', 'netlink-pro'),
                                'section' => 'woocommerce-single-page-sociable-follow-section',
                                'description'   => esc_html__( 'This option is applicable only for WooCommerce "Custom Template".', 'netlink-pro'),
                            )
                        )
                    );

                    $social_follow = array (
                        'delicious'   => esc_html__('Delicious', 'netlink-pro'),
                        'deviantart'  => esc_html__('Deviantart', 'netlink-pro'),
                        'digg'        => esc_html__('Digg', 'netlink-pro'),
                        'dribbble'    => esc_html__('Dribbble', 'netlink-pro'),
                        'envelope'    => esc_html__('Envelope', 'netlink-pro'),
                        'facebook'    => esc_html__('Facebook', 'netlink-pro'),
                        'flickr'      => esc_html__('Flickr', 'netlink-pro'),
                        'google-plus' => esc_html__('Google Plus', 'netlink-pro'),
                        'instagram'   => esc_html__('Instagram', 'netlink-pro'),
                        'lastfm'      => esc_html__('Lastfm', 'netlink-pro'),
                        'linkedin'    => esc_html__('Linkedin', 'netlink-pro'),
                        'myspace'     => esc_html__('Myspace', 'netlink-pro'),
                        'pinterest'   => esc_html__('Pinterest', 'netlink-pro'),
                        'reddit'      => esc_html__('Reddit', 'netlink-pro'),
                        'rss'         => esc_html__('RSS', 'netlink-pro'),
                        'skype'       => esc_html__('Skype', 'netlink-pro'),
                        'stumbleupon' => esc_html__('Stumbleupon', 'netlink-pro'),
                        'tumblr'      => esc_html__('Tumblr', 'netlink-pro'),
                        'twitter'     => esc_html__('Twitter', 'netlink-pro'),
                        'viadeo'      => esc_html__('Viadeo', 'netlink-pro'),
                        'vimeo'       => esc_html__('Vimeo', 'netlink-pro'),
                        'yahoo'       => esc_html__('Yahoo', 'netlink-pro'),
                        'youtube'     => esc_html__('Youtube', 'netlink-pro')
                    );

                    foreach($social_follow as $socialfollow_key => $socialfollow) {

                        $wp_customize->add_setting(
                            NETLINK_CUSTOMISER_VAL . '[wdt-single-product-show-follow-'.$socialfollow_key.']', array(
                                'type' => 'option'
                            )
                        );

                        $wp_customize->add_control(
                            new Netlink_Customize_Control_Switch(
                                $wp_customize, NETLINK_CUSTOMISER_VAL . '[wdt-single-product-show-follow-'.$socialfollow_key.']', array(
                                    'type'    => 'wdt-switch',
                                    'label'   => sprintf(esc_html__('Show %1$s Follow', 'netlink-pro'), $socialfollow),
                                    'section' => 'woocommerce-single-page-sociable-follow-section',
                                    'choices' => array(
                                        'on'  => esc_attr__( 'Yes', 'netlink-pro' ),
                                        'off' => esc_attr__( 'No', 'netlink-pro' )
                                    )
                                )
                            )
                        );

                        $wp_customize->add_setting(
                            NETLINK_CUSTOMISER_VAL . '[wdt-single-product-follow-'.$socialfollow_key.'-link]', array(
                                'type' => 'option'
                            )
                        );

                        $wp_customize->add_control(
                            new Netlink_Customize_Control(
                                $wp_customize, NETLINK_CUSTOMISER_VAL . '[wdt-single-product-follow-'.$socialfollow_key.'-link]', array(
                                    'type'       => 'text',
                                    'section'    => 'woocommerce-single-page-sociable-follow-section',
                                    'input_attrs' => array(
                                        'placeholder' => sprintf(esc_html__('%1$s Link', 'netlink-pro'), $socialfollow)
                                    ),
                                    'dependency' => array ( 'wdt-single-product-show-follow-'.$socialfollow_key, '==', '1' )
                                )
                            )
                        );

                    }

        }

    }

}


if( !function_exists('netlink_shop_customizer_single_social_share_and_follow') ) {
	function netlink_shop_customizer_single_social_share_and_follow() {
		return Netlink_Shop_Customizer_Single_Social_Share_And_Follow::instance();
	}
}

netlink_shop_customizer_single_social_share_and_follow();