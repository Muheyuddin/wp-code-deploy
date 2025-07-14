<?php

if( !class_exists('DTStoreLocatorListingsPostType') ) {

	class DTStoreLocatorListingsPostType {

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

			add_action ( 'init', array ( $this, 'dtsl_init' ) );
			add_action ( 'admin_notices', array ( $this, 'dtsl_save_post_admin_notices') );
			add_action ( 'admin_footer-post.php', array ( $this, 'dtsl_update_post_status_edit_screen' ) );
			add_action ( 'admin_footer-edit.php', array ( $this, 'dtsl_update_post_status_list_screen' ) );
			add_filter ( 'display_post_states', array ( $this, 'dtsl_display_status_label' ) );

			add_action ( 'admin_init', array ( $this, 'dtsl_admin_init' ) );
			add_filter ( 'template_include', array ( $this, 'dtsl_template_include'  ) );

		}

		function dtsl_init() {

			$this->createPostType();
			add_action ( 'save_post', array ( $this, 'dtsl_save_post_meta' ) );

			/* Taxomony custom fields */
			require_once DTSL_PLUGIN_PATH . 'custom-post-types/taxonomy-custom-fields.php';

			// Register expired post status

			register_post_status( 'expired', array (
				'label'                     => _x( 'Expired', 'Post status', 'dtsl' ),
				'public'                    => true,
				'exclude_from_search'       => false,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				'label_count'               => _n_noop( 'Expired <span class="count">(%s)</span>', 'Expired <span class="count">(%s)</span>', 'dtsl' ),
			) );

			// Register waiting for approval post status

			register_post_status( 'waitingforapproval', array (
				'label'                     => _x( 'Waiting For Approval', 'Post status', 'dtsl' ),
				'public'                    => true,
				'exclude_from_search'       => false,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				'label_count'               => _n_noop( 'Waiting For Approval <span class="count">(%s)</span>', 'Waiting For Approval <span class="count">(%s)</span>', 'dtsl' ),
			) );

		}

		function dtsl_save_post_admin_notices() {

			if(get_option('dtsl_savepost_adminnotices')) {

				$class = 'notice notice-error';
				$message = get_option('dtsl_savepost_adminnotices');

				printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );

				delete_option('dtsl_savepost_adminnotices');

			}

		}

		function dtsl_update_post_status_edit_screen() {

			global $post;

			$complete = '';
			$label = '';

			if($post->post_type == 'dtsl_listings') {

				if($post->post_status == 'expired') {

					$complete = ' selected="selected"';
					$label = esc_html__('Expired', 'dtsl');

					echo '
						<script>
						jQuery(document).ready(function($) {
							$("select#post_status").append(\'<option value="expired" '.$complete.'>'.esc_html__('Expired', 'dtsl').'</option>\');
							$(".misc-pub-section #post-status-display").html(\''.$label.'\');
						});
						</script>
						';

				} else if($post->post_status == 'waitingforapproval') {

					$complete = ' selected="selected"';
					$label = esc_html__('Waiting For Approval', 'dtsl');

					echo '
						<script>
						jQuery(document).ready(function($) {
							$("select#post_status").append(\'<option value="waitingforapproval" '.$complete.'>'.esc_html__('Waiting For Approval', 'dtsl').'</option>\');
							$(".misc-pub-section #post-status-display").html(\''.$label.'\');
						});
						</script>
						';

				} else {

					echo '
						<script>
						jQuery(document).ready(function($) {
							$("select#post_status").append(\'<option value="expired">'.esc_html__('Expired', 'dtsl').'</option>\');
							$("select#post_status").append(\'<option value="waitingforapproval">'.esc_html__('Waiting For Approval', 'dtsl').'</option>\');
						});
						</script>
						';

				}

			}

		}

		function dtsl_update_post_status_list_screen() {

			global $post;

			$complete = '';
			$label = '';

			if(isset($post)) {

				if($post->post_type == 'dtsl_listings') {

					if($post->post_status == 'expired') {

						echo '
							<script>
							jQuery(document).ready(function($) {
								$("select[name=\"_status\"]").append(\'<option value="expired">'.esc_html__('Expired', 'dtsl').'</option>\');
							});
							</script>
							';

					} else if($post->post_status == 'waitingforapproval') {

						echo '
							<script>
							jQuery(document).ready(function($) {
								$("select[name=\"_status\"]").append(\'<option value="waitingforapproval">'.esc_html__('Waiting For Approval', 'dtsl').'</option>\');
							});
							</script>
							';

					} else {

						echo '
							<script>
							jQuery(document).ready(function($) {
								$("select[name=\"_status\"]").append(\'<option value="expired">'.esc_html__('Expired', 'dtsl').'</option>\');
								$("select[name=\"_status\"]").append(\'<option value="waitingforapproval">'.esc_html__('Waiting For Approval', 'dtsl').'</option>\');
							});
							</script>
							';

					}

				}

			}

		}

		function dtsl_display_status_label( $statuses ) {

			global $post;

			if(isset($post) && !empty($post)) {
				if( $post->post_status == 'expired' ) {
					return array ('Expired');
				} else if( $post->post_status == 'waitingforapproval' ) {
					return array ('Waiting For Approval');
				}
			}

			return $statuses;

		}

		function createPostType() {

			$listing_slug = trim(dtsl_option('permalink', 'dt-sl-listing-slug'));
			$listing_category_slug = trim(dtsl_option('permalink','dt-sl-listing-category-slug'));
			$listing_contracttype_slug = trim(dtsl_option('permalink','dt-sl-listing-contracttype-slug'));
			$listing_amenity_slug = trim(dtsl_option('permalink','dt-sl-listing-amenity-slug'));

			$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );
			$listing_plural_label = apply_filters( 'dt_sl_listing_label', 'plural' );

			$dt_sl_amenity_singular_label = apply_filters( 'dt_sl_amenity_label', 'singular' );
			$amenity_plural_label = apply_filters( 'dt_sl_amenity_label', 'plural' );

			$dt_sl_contracttype_singular_label = apply_filters( 'dt_sl_contracttype_label', 'singular' );
			$contracttype_plural_label = apply_filters( 'dt_sl_contracttype_label', 'plural' );

			$labels = array (
					'name' => sprintf( esc_html__('%1$s', 'dtsl'), $listing_plural_label ),
					'all_items' => sprintf( esc_html__('All %1$s', 'dtsl'), $listing_plural_label ),
					'singular_name' => sprintf( esc_html__('%1$s', 'dtsl'), $dt_sl_listing_singular_label ),
					'add_new' => esc_html__( 'Add New', 'dtsl' ),
					'add_new_item' => sprintf( esc_html__('Add New %1$s', 'dtsl'), $dt_sl_listing_singular_label ),
					'edit_item' => sprintf( esc_html__('Edit %1$s', 'dtsl'), $dt_sl_listing_singular_label ),
					'new_item' => sprintf( esc_html__('New %1$s', 'dtsl'), $dt_sl_listing_singular_label ),
					'view_item' => sprintf( esc_html__('View %1$s', 'dtsl'), $dt_sl_listing_singular_label ),
					'search_items' => sprintf( esc_html__('Search %1$s', 'dtsl'), $listing_plural_label ),
					'not_found' => sprintf( esc_html__('No %1$s found', 'dtsl'), $listing_plural_label ),
					'not_found_in_trash' => sprintf( esc_html__('No %1$s found in Trash', 'dtsl'), $listing_plural_label ),
					'parent_item_colon' => sprintf( esc_html__('Parent %1$s:', 'dtsl'), $dt_sl_listing_singular_label ),
					'menu_name' => sprintf( esc_html__('%1$s', 'dtsl'), $listing_plural_label ),
			);

			$args = array (
					'labels' => $labels,
					'hierarchical' => false,
					'description' => sprintf( esc_html__('This is custom post type %1$s', 'dtsl'), strtolower($listing_plural_label) ),
					'supports' => array (
							'title',
							'editor',
							'excerpt',
							'author',
							'comments',
							'page-attributes',
							'thumbnail',
							'revisions'
					),

					'public' => true,
					'show_ui' => true,
					'show_in_menu' => 'dtsl',
					'show_in_nav_menus' => true,
					'publicly_queryable' => true,
					'exclude_from_search' => false,
					'has_archive' => true,
					'query_var' => true,
					'can_export' => true,
					'rewrite' => array ( 'slug' => $listing_slug, 'hierarchical' => true, 'with_front' => false ),
					'capability_type' => 'post',
					'map_meta_cap'        => true,
					'capabilities'        => array (

						// meta caps (don't assign these to roles)
						'edit_post'              => 'edit_dtsl_listing',
						'read_post'              => 'read_dtsl_listing',
						'delete_post'            => 'delete_dtsl_listing',

						// primitive/meta caps
						'create_posts'           => 'create_dtsl_listings',

						// primitive caps used outside of map_meta_cap()
						'edit_posts'             => 'edit_dtsl_listings',
						'edit_others_posts'      => 'edit_others_dtsl_listings',
						'publish_post'           => 'publish_dtsl_listings',
						'read_private_posts'     => 'read_private_dtsl_listings',

						// primitive caps used inside of map_meta_cap()
						'read'                   => 'read',
						'delete_posts'           => 'delete_dtsl_listings',
						'delete_private_posts'   => 'delete_private_dtsl_listings',
						'delete_published_posts' => 'delete_published_dtsl_listings',
						'delete_others_posts'    => 'delete_others_dtsl_listings',
						'edit_private_posts'     => 'edit_private_dtsl_listings',
						'edit_published_posts'   => 'edit_published_dtsl_listings'
					)

			);

			register_post_type ( 'dtsl_listings', $args );


			register_taxonomy ( 'dtsl_listings_category', array (
						'dtsl_listings'
				), array (
						'hierarchical' => true,
						'labels' => array(
							'name' 					=> sprintf( esc_html__('%1$s Categories', 'dtsl'), $dt_sl_listing_singular_label ),
							'singular_name' 		=> sprintf( esc_html__('%1$s Category', 'dtsl'), $dt_sl_listing_singular_label ),
							'search_items'			=> sprintf( esc_html__('Search %1$s Categories', 'dtsl'), $dt_sl_listing_singular_label ),
							'popular_items'			=> sprintf( esc_html__('Popular %1$s Categories', 'dtsl'), $dt_sl_listing_singular_label ),
							'all_items'				=> sprintf( esc_html__('All %1$s Categories', 'dtsl'), $dt_sl_listing_singular_label ),
							'parent_item'			=> sprintf( esc_html__('Parent %1$s Category', 'dtsl'), $dt_sl_listing_singular_label ),
							'parent_item_colon'		=> sprintf( esc_html__('Parent %1$s Category', 'dtsl'), $dt_sl_listing_singular_label ),
							'edit_item'				=> sprintf( esc_html__('Edit %1$s Category', 'dtsl'), $dt_sl_listing_singular_label ),
							'update_item'			=> sprintf( esc_html__('Update %1$s Category', 'dtsl'), $dt_sl_listing_singular_label ),
							'add_new_item'			=> sprintf( esc_html__('Add New %1$s Category', 'dtsl'), $dt_sl_listing_singular_label ),
							'new_item_name'			=> sprintf( esc_html__('New %1$s Category', 'dtsl'), $dt_sl_listing_singular_label ),
							'add_or_remove_items'	=> sprintf( esc_html__('Add or remove', 'dtsl'), $dt_sl_listing_singular_label ),
							'choose_from_most_used'	=> sprintf( esc_html__('Choose from most used', 'dtsl'), $dt_sl_listing_singular_label ),
							'menu_name'				=> sprintf( esc_html__('%1$s Categories', 'dtsl'), $dt_sl_listing_singular_label ),
						),
						'show_admin_column' => true,
						'rewrite' => array( 'slug' => $listing_category_slug, 'hierarchical' => true, 'with_front' => false ),
						'query_var' => true
				)
			);

			register_taxonomy ( 'dtsl_listings_ctype', array (
						'dtsl_listings'
				), array (
						'hierarchical' => true,
						'labels' => array(
							'name' 					=> sprintf( esc_html__('%1$s %2$s', 'dtsl'), $dt_sl_listing_singular_label, $contracttype_plural_label ),
							'singular_name' 		=> sprintf( esc_html__('%1$s %2$s', 'dtsl'), $dt_sl_listing_singular_label, $dt_sl_contracttype_singular_label ),
							'search_items'			=> sprintf( esc_html__('Search %1$s %2$s', 'dtsl'), $dt_sl_listing_singular_label, $contracttype_plural_label ),
							'popular_items'			=> sprintf( esc_html__('Popular %1$s %2$s', 'dtsl'), $dt_sl_listing_singular_label, $contracttype_plural_label ),
							'all_items'				=> sprintf( esc_html__('All %1$s %2$s', 'dtsl'), $dt_sl_listing_singular_label, $contracttype_plural_label ),
							'parent_item'			=> sprintf( esc_html__('Parent %1$s %2$s', 'dtsl'), $dt_sl_listing_singular_label, $dt_sl_contracttype_singular_label ),
							'parent_item_colon'		=> sprintf( esc_html__('Parent %1$s %2$s', 'dtsl'), $dt_sl_listing_singular_label, $dt_sl_contracttype_singular_label ),
							'edit_item'				=> sprintf( esc_html__('Edit %1$s %2$s', 'dtsl'), $dt_sl_listing_singular_label, $dt_sl_contracttype_singular_label ),
							'update_item'			=> sprintf( esc_html__('Update %1$s %2$s', 'dtsl'), $dt_sl_listing_singular_label, $dt_sl_contracttype_singular_label ),
							'add_new_item'			=> sprintf( esc_html__('Add New %1$s %2$s', 'dtsl'), $dt_sl_listing_singular_label, $dt_sl_contracttype_singular_label ),
							'new_item_name'			=> sprintf( esc_html__('New %1$s %2$s', 'dtsl'), $dt_sl_listing_singular_label, $dt_sl_contracttype_singular_label ),
							'add_or_remove_items'	=> sprintf( esc_html__('Add or remove', 'dtsl'), $dt_sl_listing_singular_label, $dt_sl_contracttype_singular_label ),
							'choose_from_most_used'	=> sprintf( esc_html__('Choose from most used', 'dtsl'), $dt_sl_listing_singular_label, $dt_sl_contracttype_singular_label ),
							'menu_name'				=> sprintf( esc_html__('%1$s %2$s', 'dtsl'), $dt_sl_listing_singular_label, $contracttype_plural_label ),
						),
						'show_admin_column' => true,
						'rewrite' => array( 'slug' => $listing_contracttype_slug, 'hierarchical' => true, 'with_front' => false ),
						'query_var' => true
				)
			);

			register_taxonomy ( 'dtsl_listings_amenity', array (
						'dtsl_listings'
				), array (
						'hierarchical' => false,
						'labels' => array(
							'name' 					=> sprintf( esc_html__('%1$s %2$s', 'dtsl'), $dt_sl_listing_singular_label, $amenity_plural_label ),
							'singular_name' 		=> sprintf( esc_html__('%1$s %2$s', 'dtsl'), $dt_sl_listing_singular_label, $dt_sl_amenity_singular_label ),
							'search_items'			=> sprintf( esc_html__('Search %1$s %2$s', 'dtsl'), $dt_sl_listing_singular_label, $amenity_plural_label ),
							'popular_items'			=> sprintf( esc_html__('Popular %1$s %2$s', 'dtsl'), $dt_sl_listing_singular_label, $amenity_plural_label ),
							'all_items'				=> sprintf( esc_html__('All %1$s %2$s', 'dtsl'), $dt_sl_listing_singular_label, $amenity_plural_label ),
							'parent_item'			=> sprintf( esc_html__('Parent %1$s %2$s', 'dtsl'), $dt_sl_listing_singular_label, $dt_sl_amenity_singular_label ),
							'parent_item_colon'		=> sprintf( esc_html__('Parent %1$s %2$s', 'dtsl'), $dt_sl_listing_singular_label, $dt_sl_amenity_singular_label ),
							'edit_item'				=> sprintf( esc_html__('Edit %1$s %2$s', 'dtsl'), $dt_sl_listing_singular_label, $dt_sl_amenity_singular_label ),
							'update_item'			=> sprintf( esc_html__('Update %1$s %2$s', 'dtsl'), $dt_sl_listing_singular_label, $dt_sl_amenity_singular_label ),
							'add_new_item'			=> sprintf( esc_html__('Add New %1$s %2$s', 'dtsl'), $dt_sl_listing_singular_label, $dt_sl_amenity_singular_label ),
							'new_item_name'			=> sprintf( esc_html__('New %1$s %2$s', 'dtsl'), $dt_sl_listing_singular_label, $dt_sl_amenity_singular_label ),
							'add_or_remove_items'	=> sprintf( esc_html__('Add or remove', 'dtsl'), $dt_sl_listing_singular_label, $dt_sl_amenity_singular_label ),
							'choose_from_most_used'	=> sprintf( esc_html__('Choose from most used', 'dtsl'), $dt_sl_listing_singular_label, $dt_sl_amenity_singular_label ),
							'menu_name'				=> sprintf( esc_html__('%1$s %2$s', 'dtsl'), $dt_sl_listing_singular_label, $amenity_plural_label ),
						),
						'show_admin_column' => true,
						'rewrite' => array( 'slug' => $listing_amenity_slug, 'hierarchical' => true, 'with_front' => false ),
						'query_var' => true
				)
			);

		}

		function dtsl_save_post_meta($post_id) {

			if( key_exists ( '_inline_edit', $_POST )) :
				if ( wp_verify_nonce($_POST['_inline_edit'], 'inlineeditnonce')) return;
			endif;

			if( key_exists( 'dtsl_listings_meta_nonce',$_POST ) ) :
				if ( ! wp_verify_nonce( $_POST['dtsl_listings_meta_nonce'], 'dtsl_listings_nonce' ) ) return;
			endif;

			if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

			if (!current_user_can('edit_post', $post_id)) :
				return;
			endif;

			if ( (key_exists('post_type', $_POST)) && ('dtsl_listings' == $_POST['post_type']) ) :

				if( isset( $_POST['dtsl_mls_number'] ) && $_POST['dtsl_mls_number'] != '') {

					$args = array (
								'posts_per_page' => -1,
								'post_type'      => 'dtsl_listings',
								'meta_query'     => array (),
								'post_status'    => array ( 'any' ),
								'post__not_in'   => array ($post_id)
							);

					$args['meta_query'][] = array (
												'key'     => 'dtsl_mls_number',
												'value'   => $_POST['dtsl_mls_number'],
												'compare' => 'LIKE',
											);

					$listings_query = new WP_Query( $args );
					$post_count = $listings_query->found_posts;
					wp_reset_postdata();

					if($post_count > 0) {
						add_option( 'dtsl_savepost_adminnotices', esc_html__('MLS Number you have provided is not unique, please try with unique number.', 'dtsl') );
						return;
					}

				}


				$author_id = get_post_field( 'post_author', $post_id );
				$user_id = get_current_user_id();


				// General

				if( isset( $_POST['dtsl_page_template'] ) && $_POST['dtsl_page_template'] != '') {
					update_post_meta ( $post_id, 'dtsl_page_template', dtsl_recursive_sanitize_text_field ( $_POST['dtsl_page_template'] ) );
				} else {
					delete_post_meta ( $post_id, 'dtsl_page_template' );
				}

				if( isset( $_POST['dtsl_mls_number'] ) && $_POST['dtsl_mls_number'] != '') {
					update_post_meta ( $post_id, 'dtsl_mls_number', dtsl_recursive_sanitize_text_field ( $_POST['dtsl_mls_number'] ) );
				} else {
					delete_post_meta ( $post_id, 'dtsl_mls_number' );
				}

				if( isset( $_POST['dtsl_incharges'] ) && $_POST['dtsl_incharges'] != '') {
					update_post_meta ( $post_id, 'dtsl_incharges', dtsl_recursive_sanitize_text_field( $_POST['dtsl_incharges'] ) );
				} else {
					delete_post_meta ( $post_id, 'dtsl_incharges' );
				}

				if((int)$author_id == (int)$user_id) {

					if( isset( $_POST['dtsl_featured_item'] ) && $_POST['dtsl_featured_item'] != '') {
						update_post_meta ( $post_id, 'dtsl_featured_item', dtsl_recursive_sanitize_text_field ( $_POST['dtsl_featured_item'] ) );
					} else {
						delete_post_meta ( $post_id, 'dtsl_featured_item' );
					}

				}

				if( isset( $_POST['dtsl_excerpt_title'] ) && $_POST['dtsl_excerpt_title'] != '') {
					update_post_meta ( $post_id, 'dtsl_excerpt_title', dtsl_recursive_sanitize_text_field ( $_POST['dtsl_excerpt_title'] ) );
				} else {
					delete_post_meta ( $post_id, 'dtsl_excerpt_title' );
				}

				// Features

				if( isset( $_POST['dtsl_features_title'] ) && $_POST['dtsl_features_title'] != '') {
					update_post_meta ( $post_id, 'dtsl_features_title', dtsl_recursive_sanitize_text_field ( $_POST['dtsl_features_title'] ) );
				} else {
					delete_post_meta ( $post_id, 'dtsl_features_title' );
				}

				if( isset( $_POST['dtsl_features_subtitle'] ) && $_POST['dtsl_features_subtitle'] != '') {
					update_post_meta ( $post_id, 'dtsl_features_subtitle', dtsl_recursive_sanitize_text_field ( $_POST['dtsl_features_subtitle'] ) );
				} else {
					delete_post_meta ( $post_id, 'dtsl_features_subtitle' );
				}

				if( isset( $_POST['dtsl_features_value'] ) && $_POST['dtsl_features_value'] != '') {
					update_post_meta ( $post_id, 'dtsl_features_value', dtsl_recursive_sanitize_text_field ( $_POST['dtsl_features_value'] ) );
				} else {
					delete_post_meta ( $post_id, 'dtsl_features_value' );
				}

				if( isset( $_POST['dtsl_features_valueunit'] ) && $_POST['dtsl_features_valueunit'] != '') {
					update_post_meta ( $post_id, 'dtsl_features_valueunit', dtsl_recursive_sanitize_text_field ( $_POST['dtsl_features_valueunit'] ) );
				} else {
					delete_post_meta ( $post_id, 'dtsl_features_valueunit' );
				}

				if( isset( $_POST['dtsl_features_icon'] ) && $_POST['dtsl_features_icon'] != '') {
					update_post_meta ( $post_id, 'dtsl_features_icon', dtsl_recursive_sanitize_text_field ( $_POST['dtsl_features_icon'] ) );
				} else {
					delete_post_meta ( $post_id, 'dtsl_features_icon' );
				}

				if( isset( $_POST['dtsl_features_image'] ) && $_POST['dtsl_features_image'] != '') {
					update_post_meta ( $post_id, 'dtsl_features_image', dtsl_recursive_sanitize_text_field ( $_POST['dtsl_features_image'] ) );
				} else {
					delete_post_meta ( $post_id, 'dtsl_features_image' );
				}


				// Contact Information

				if( isset( $_POST['dtsl_email'] ) && $_POST['dtsl_email'] != '') {
					update_post_meta ( $post_id, 'dtsl_email', sanitize_email ( $_POST['dtsl_email'] ) );
				} else {
					delete_post_meta ( $post_id, 'dtsl_email' );
				}

				if( isset( $_POST['dtsl_phone'] ) && $_POST['dtsl_phone'] != '') {
					update_post_meta ( $post_id, 'dtsl_phone', dtsl_recursive_sanitize_text_field ( $_POST['dtsl_phone'] ) );
				} else {
					delete_post_meta ( $post_id, 'dtsl_phone' );
				}

				if( isset( $_POST['dtsl_mobile'] ) && $_POST['dtsl_mobile'] != '') {
					update_post_meta ( $post_id, 'dtsl_mobile', dtsl_recursive_sanitize_text_field ( $_POST['dtsl_mobile'] ) );
				} else {
					delete_post_meta ( $post_id, 'dtsl_mobile' );
				}

				if( isset( $_POST['dtsl_skype'] ) && $_POST['dtsl_skype'] != '') {
					update_post_meta ( $post_id, 'dtsl_skype', dtsl_recursive_sanitize_text_field ( $_POST['dtsl_skype'] ) );
				} else {
					delete_post_meta ( $post_id, 'dtsl_skype' );
				}

				if( isset( $_POST['dtsl_website'] ) && $_POST['dtsl_website'] != '') {
					update_post_meta ( $post_id, 'dtsl_website', dtsl_recursive_sanitize_text_field ( $_POST['dtsl_website'] ) );
				} else {
					delete_post_meta ( $post_id, 'dtsl_website' );
				}

				if( isset( $_POST['dtsl_social_items'] ) && $_POST['dtsl_social_items'] != '') {
					update_post_meta ( $post_id, 'dtsl_social_items', dtsl_recursive_sanitize_text_field ( $_POST['dtsl_social_items'] ) );
				} else {
					delete_post_meta ( $post_id, 'dtsl_social_items' );
				}

				if( isset( $_POST['dtsl_social_items_value'] ) && $_POST['dtsl_social_items_value'] != '') {
					update_post_meta ( $post_id, 'dtsl_social_items_value', dtsl_recursive_sanitize_text_field ( $_POST['dtsl_social_items_value'] ) );
				} else {
					delete_post_meta ( $post_id, 'dtsl_social_items_value' );
				}

				// Add or Update listing from modules
				do_action('dtsl_addorupdate_listing_module', $_POST, $post_id);

			endif;

		}

		function dtsl_admin_init() {

			add_action ( 'add_meta_boxes', array ( $this, 'dtsl_add_listing_default_metabox' ) );
			add_filter ( 'manage_dtsl_listings_posts_columns', array ( $this, 'set_custom_edit_dtsl_listings_columns' ) );
			add_action ( 'manage_dtsl_listings_posts_custom_column', array ( $this, 'custom_dtsl_listings_column' ), 10, 2 );

		}

		function dtsl_add_listing_default_metabox() {
			$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );
			add_meta_box ( 'dtsl-listing-default-metabox', sprintf( esc_html__( '%1$s Options', 'dtsl' ), $dt_sl_listing_singular_label ), array ( $this, 'dtsl_listing_default_metabox' ), 'dtsl_listings', 'normal', 'default' );
		}

		function dtsl_listing_default_metabox() {
			include_once DTSL_PLUGIN_PATH . 'custom-post-types/metaboxes/listing-default-metabox.php';
		}

		function set_custom_edit_dtsl_listings_columns($columns) {

			$newcolumns = array (
				'cb' => '<input type="checkbox" />',
				'dtsl_listings_thumb' => esc_html__('Image', 'dtsl'),
				'title' => esc_html__('Title', 'dtsl'),
				'author' => esc_html__('Author', 'dtsl'),
				'status' => esc_html__('Status', 'dtsl')
			);

			$columns = array_merge ( $newcolumns, $columns );

			return $columns;

		}

		function custom_dtsl_listings_column($columns, $id) {

			global $post;

			switch ($columns) {

				case 'dtsl_listings_thumb':
					$image = wp_get_attachment_image(get_post_thumbnail_id($id), array(75,75));
					if(!empty($image)) {
						echo dtsl_html_output($image);
					} else {
						echo '<img src="http'.dtsl_ssl().'://placehold.it/75x75" alt="'.esc_attr($id).'" />';
					}
				break;

				case 'status':

					$author_id = get_the_author_meta('ID');

					$current_user = get_userdata($author_id);

					$seller_id = -1;
					$process_seller = false;

					if(in_array('seller', (array) $current_user->roles)) {

						$seller_id = $author_id;
						$process_seller = true;

					} else if(in_array('incharge', (array) $current_user->roles)) {

						$incharge_id = $author_id;

						$user_seller = get_user_meta( $author_id, 'user_seller', true );
						if($user_seller != '' && $user_seller > 0) {

							$seller_id = $user_seller;
							$process_seller = true;

						}

					}

					if($process_seller) {
						if(function_exists('dtsl_check_user_seller_package_is_active') && dtsl_check_user_seller_package_is_active($seller_id, -1)) {
							echo esc_html__('Active', 'dtsl');
						} else {
							if(isset($post) && !empty($post)) {
								if( $post->post_status == 'expired' ) {
									echo esc_html__('Expired', 'dtsl');
								} else if( $post->post_status == 'waitingforapproval' ) {
									echo esc_html__('Waiting For Approval', 'dtsl');
								}
							}
						}
					}

				break;

			}

		}

		function dtsl_template_include($template) {

			if (is_singular( 'dtsl_listings' )) {
				$template = DTSL_PLUGIN_PATH . 'custom-post-types/templates/single-dtsl_listings.php';
			} elseif (is_tax ( 'dtsl_listings_category' )) {
				$template = DTSL_PLUGIN_PATH . 'custom-post-types/templates/taxonomy-dtsl_listings_category.php';
			} elseif (is_tax ( 'dtsl_listings_ctype' )) {
				$template = DTSL_PLUGIN_PATH . 'custom-post-types/templates/taxonomy-dtsl_listings_ctype.php';
			} elseif (is_tax ( 'dtsl_listings_amenity' )) {
				$template = DTSL_PLUGIN_PATH . 'custom-post-types/templates/taxonomy-dtsl_listings_amenity.php';
			} elseif (is_post_type_archive('dtsl_listings')) {
				$template = DTSL_PLUGIN_PATH . 'custom-post-types/templates/archive-dtsl_listings.php';
			}

			return $template;

		}

	}

	DTStoreLocatorListingsPostType::instance();

}
?>