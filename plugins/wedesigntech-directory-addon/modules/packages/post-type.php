<?php

if( !class_exists('DTDirectoryPackagesPostType') ) {

	class DTDirectoryPackagesPostType {

		/**
		 * Instance variable
		 */
		private static $_instance = null;

		/**
		 * Instance
		 *
		 * Ensures only one instance of the class is loaded or can be loaded.
		 */
		public static function instance() {

			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		function __construct() {

			add_action ( 'init', array ( $this, 'dtdr_init' ) );
			add_action ( 'admin_init', array ( $this, 'dtdr_admin_init' ) );
			add_filter ( 'template_include', array ( $this, 'dtdr_template_include' ) );

		}

		function dtdr_init() {

			$this->createPostType();
			add_action ( 'save_post', array ( $this, 'dtdr_save_post_meta' ) );

		}

		function createPostType() {

			$package_slug = trim(dtdr_option('permalink', 'package-slug'));

			$labels = array (
						'name' => esc_html__('Packages', 'dtdr'),
						'all_items' => esc_html__('All Packages', 'dtdr'),
						'singular_name' => esc_html__('Package', 'dtdr'),
						'add_new' => esc_html__('Add New', 'dtdr'),
						'add_new_item' => esc_html__('Add New Package', 'dtdr'),
						'edit_item' => esc_html__('Edit Package', 'dtdr'),
						'new_item' => esc_html__('New Package', 'dtdr'),
						'view_item' => esc_html__('View Package', 'dtdr'),
						'search_items' => esc_html__('Search Packages', 'dtdr'),
						'not_found' => esc_html__('No Packages found', 'dtdr'),
						'not_found_in_trash' => esc_html__('No Packages found in Trash', 'dtdr'),
						'parent_item_colon' => esc_html__('Parent Package:', 'dtdr'),
						'menu_name' => esc_html__('Packages', 'dtdr' )
					);

			$args = array (
						'labels' => $labels,
						'hierarchical' => true,
						'description' => 'This is custom post type packages',
						'supports' => array (
							'title',
							'editor',
							'excerpt',
							'author',
							'page-attributes',
							'thumbnail'
						),

						'public' => true,
						'show_ui' => true,
						'show_in_menu' => 'dtdr',
						'show_in_nav_menus' => false,
						'publicly_queryable' => true,
						'exclude_from_search' => false,
						'has_archive' => true,
						'query_var' => true,
						'can_export' => true,
						'rewrite' => array ( 'slug' => $package_slug, 'hierarchical' => true, 'with_front' => false ),
						'capability_type' => 'post'
					);

			register_post_type ( 'dtdr_packages', $args );

		}

		function dtdr_save_post_meta($post_id) {

			if( key_exists ( '_inline_edit', $_POST )) :
				if ( wp_verify_nonce($_POST['_inline_edit'], 'inlineeditnonce')) return;
			endif;

			if( key_exists( 'dtdr_packages_meta_nonce', $_POST ) ) :
				if ( ! wp_verify_nonce( $_POST['dtdr_packages_meta_nonce'], 'dtdr_packages_nonce') ) return;
			endif;

			if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

			if (!current_user_can('edit_post', $post_id)) :
				return;
			endif;

			if ( (key_exists('post_type', $_POST)) && ('dtdr_packages' == $_POST['post_type']) ) :

				if( isset( $_POST['dtdr_period'] ) && $_POST['dtdr_period'] != '' ) {
					update_post_meta ( $post_id, 'dtdr_period', dtdr_recursive_sanitize_text_field ( $_POST['dtdr_period'] ) );
				} else {
					delete_post_meta ( $post_id, 'dtdr_period' );
				}

				if( isset( $_POST['dtdr_term'] ) && $_POST['dtdr_term'] != '' ) {
					update_post_meta ( $post_id, 'dtdr_term', dtdr_recursive_sanitize_text_field ( $_POST['dtdr_term'] ) );
				} else {
					delete_post_meta ( $post_id, 'dtdr_term' );
				}

				if( isset( $_POST['dtdr_package_type'] ) && $_POST['dtdr_package_type'] != '' ) {
					update_post_meta ( $post_id, 'dtdr_package_type', dtdr_recursive_sanitize_text_field ( $_POST['dtdr_package_type'] ) );
				} else {
					delete_post_meta ( $post_id, 'dtdr_package_type' );
				}

				if( isset( $_POST['dtdr_numberof_listings'] ) && !empty($_POST['dtdr_numberof_listings'])) {
					update_post_meta ( $post_id, 'dtdr_numberof_listings', dtdr_recursive_sanitize_text_field ( $_POST['dtdr_numberof_listings'] ) );
				} else {
					delete_post_meta ( $post_id, 'dtdr_numberof_listings' );
				}

				if( isset( $_POST['dtdr_numberof_featured_listings'] ) && !empty($_POST['dtdr_numberof_featured_listings'])) {
					update_post_meta ( $post_id, 'dtdr_numberof_featured_listings', dtdr_recursive_sanitize_text_field ( $_POST['dtdr_numberof_featured_listings'] ) );
				} else {
					delete_post_meta ( $post_id, 'dtdr_numberof_featured_listings' );
				}

				if( isset( $_POST['dtdr_numberof_incharges'] ) && !empty($_POST['dtdr_numberof_incharges'])) {
					update_post_meta ( $post_id, 'dtdr_numberof_incharges', dtdr_recursive_sanitize_text_field ( $_POST['dtdr_numberof_incharges'] ) );
				} else {
					delete_post_meta ( $post_id, 'dtdr_numberof_incharges' );
				}

				if( isset( $_POST['dtdr_numberof_images'] ) && !empty($_POST['dtdr_numberof_images'])) {
					update_post_meta ( $post_id, 'dtdr_numberof_images', dtdr_recursive_sanitize_text_field ( $_POST['dtdr_numberof_images'] ) );
				} else {
					delete_post_meta ( $post_id, 'dtdr_numberof_images' );
				}

				if( isset( $_POST['dtdr_additional_features'] ) && !empty($_POST['dtdr_additional_features'])) {
					update_post_meta ( $post_id, 'dtdr_additional_features', dtdr_recursive_sanitize_text_field ( $_POST['dtdr_additional_features'] ) );
				} else {
					delete_post_meta ( $post_id, 'dtdr_additional_features' );
				}

				update_post_meta($post_id, '_sold_individually', true);

			endif;

		}


		function dtdr_admin_init() {
			add_action ( 'add_meta_boxes', array ( $this, 'dtdr_add_package_default_metabox' ) );
		}

		function dtdr_add_package_default_metabox() {
			add_meta_box ( 'dtdr-package-default-metabox', esc_html__('Package Options', 'dtdr'), array ( $this, 'dtdr_package_default_metabox' ), 'dtdr_packages', 'normal', 'default' );
		}

		function dtdr_package_default_metabox() {
			include_once DTDR_PACKAGES_PLUGIN_PATH . 'metabox.php';
		}

		function dtdr_template_include($template) {

			if (is_singular( 'dtdr_packages' )) {
				$template = DTDR_PACKAGES_PLUGIN_PATH . 'single-dtdr_packages.php';
			}

			return $template;

		}

	}

	DTDirectoryPackagesPostType::instance();

}

?>