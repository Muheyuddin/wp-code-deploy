<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if (! class_exists ( 'NetlinkPlusHeaderPostType' ) ) {

	class NetlinkPlusHeaderPostType {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

		function __construct() {

			add_action ( 'init', array( $this, 'netlink_register_cpt' ), 5 );
			add_filter ( 'template_include', array ( $this, 'netlink_template_include' ) );
		}

		function netlink_register_cpt() {

			$labels = array (
				'name'				 => __( 'Headers', 'netlink-plus' ),
				'singular_name'		 => __( 'Header', 'netlink-plus' ),
				'menu_name'			 => __( 'Headers', 'netlink-plus' ),
				'add_new'			 => __( 'Add Header', 'netlink-plus' ),
				'add_new_item'		 => __( 'Add New Header', 'netlink-plus' ),
				'edit'				 => __( 'Edit Header', 'netlink-plus' ),
				'edit_item'			 => __( 'Edit Header', 'netlink-plus' ),
				'new_item'			 => __( 'New Header', 'netlink-plus' ),
				'view'				 => __( 'View Header', 'netlink-plus' ),
				'view_item' 		 => __( 'View Header', 'netlink-plus' ),
				'search_items' 		 => __( 'Search Headers', 'netlink-plus' ),
				'not_found' 		 => __( 'No Headers found', 'netlink-plus' ),
				'not_found_in_trash' => __( 'No Headers found in Trash', 'netlink-plus' ),
			);

			$args = array (
				'labels' 				=> $labels,
				'public' 				=> true,
				'exclude_from_search'	=> true,
				'show_in_nav_menus' 	=> false,
				'show_in_rest' 			=> true,
				'menu_position'			=> 25,
				'menu_icon' 			=> 'dashicons-heading',
				'hierarchical' 			=> false,
				'supports' 				=> array ( 'title', 'editor', 'revisions' ),
			);

			register_post_type ( 'wdt_headers', $args );
		}

		function netlink_template_include($template) {
			if ( is_singular( 'wdt_headers' ) ) {
				if ( ! file_exists ( get_stylesheet_directory () . '/single-wdt_headers.php' ) ) {
					$template = NETLINK_PLUS_DIR_PATH . 'post-types/templates/single-wdt_headers.php';
				}
			}

			return $template;
		}
	}
}

NetlinkPlusHeaderPostType::instance();