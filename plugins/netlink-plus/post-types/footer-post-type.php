<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if (! class_exists ( 'NetlinkPlusFooterPostType' ) ) {

	class NetlinkPlusFooterPostType {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

		function __construct() {

			add_action ( 'init', array( $this, 'netlink_register_cpt' ) );
			add_filter ( 'template_include', array ( $this, 'netlink_template_include' ) );
		}

		function netlink_register_cpt() {

			$labels = array (
				'name'				 => __( 'Footers', 'netlink-plus' ),
				'singular_name'		 => __( 'Footer', 'netlink-plus' ),
				'menu_name'			 => __( 'Footers', 'netlink-plus' ),
				'add_new'			 => __( 'Add Footer', 'netlink-plus' ),
				'add_new_item'		 => __( 'Add New Footer', 'netlink-plus' ),
				'edit'				 => __( 'Edit Footer', 'netlink-plus' ),
				'edit_item'			 => __( 'Edit Footer', 'netlink-plus' ),
				'new_item'			 => __( 'New Footer', 'netlink-plus' ),
				'view'				 => __( 'View Footer', 'netlink-plus' ),
				'view_item' 		 => __( 'View Footer', 'netlink-plus' ),
				'search_items' 		 => __( 'Search Footers', 'netlink-plus' ),
				'not_found' 		 => __( 'No Footers found', 'netlink-plus' ),
				'not_found_in_trash' => __( 'No Footers found in Trash', 'netlink-plus' ),
			);

			$args = array (
				'labels' 				=> $labels,
				'public' 				=> true,
				'exclude_from_search'	=> true,
				'show_in_nav_menus' 	=> false,
				'show_in_rest' 			=> true,
				'menu_position'			=> 26,
				'menu_icon' 			=> 'dashicons-editor-insertmore',
				'hierarchical' 			=> false,
				'supports' 				=> array ( 'title', 'editor', 'revisions' ),
			);

			register_post_type ( 'wdt_footers', $args );
		}

		function netlink_template_include($template) {
			if ( is_singular( 'wdt_footers' ) ) {
				if ( ! file_exists ( get_stylesheet_directory () . '/single-wdt_footers.php' ) ) {
					$template = NETLINK_PLUS_DIR_PATH . 'post-types/templates/single-wdt_footers.php';
				}
			}

			return $template;
		}
	}
}

NetlinkPlusFooterPostType::instance();