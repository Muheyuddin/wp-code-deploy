<?php
if( !class_exists('DTStoreLocatorVisualComposer') ) {

	class DTStoreLocatorVisualComposer {

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

			add_action( 'admin_enqueue_scripts', array ( $this, 'dtsl_vc_admin_scripts') );
			add_action( 'after_setup_theme', array ( $this, 'dtsl_vc_map_shortcodes' ) , 1000 );

		}

		function dtsl_vc_admin_scripts( $hook ) {

			if($hook == "post.php" || $hook == "post-new.php") {
				wp_enqueue_style( 'dtsl-vc-admin', DTSL_PLUGIN_URL.'page-builders/visual-composer/admin.css', array(), false, 'all' );
			}

		}

		function dtsl_vc_map_shortcodes() {

			global $pagenow;

			$vc_modules_path = DTSL_PLUGIN_PATH . 'page-builders/visual-composer/modules/';

			// General Modules

				$modules['dtsl_login_logout_links']             = $vc_modules_path . 'default/login-logout-links.php';
				$modules['dtsl_listings_listing']               = $vc_modules_path . 'default/listings-listing.php';
				$modules['dtsl_listings_taxonomy']              = $vc_modules_path . 'default/listings-taxonomy.php';


			// Single Page Modules

				$modules['dtsl_sp_featured_image']              = $vc_modules_path . 'single-page/featured-image.php';
				$modules['dtsl_sp_featured_item']               = $vc_modules_path . 'single-page/featured-item.php';
				$modules['dtsl_sp_features']                    = $vc_modules_path . 'single-page/features.php';
				$modules['dtsl_sp_contact_details']             = $vc_modules_path . 'single-page/contact-details.php';
				$modules['dtsl_sp_contact_details_request_btn'] = $vc_modules_path . 'single-page/contact-details-request.php';
				$modules['dtsl_sp_social_links']                = $vc_modules_path . 'single-page/social-links.php';
				$modules['dtsl_sp_comments']                    = $vc_modules_path . 'single-page/comments.php';
				$modules['dtsl_sp_utils']                       = $vc_modules_path . 'single-page/utils.php';
				$modules['dtsl_sp_taxonomy']                    = $vc_modules_path . 'single-page/taxonomy.php';
				$modules['dtsl_sp_contact_form']                = $vc_modules_path . 'single-page/contact-form.php';
				$modules['dtsl_sp_post_date']                   = $vc_modules_path . 'single-page/post-date.php';
				$modules['dtsl_sp_mls_number']                  = $vc_modules_path . 'single-page/mls-number.php';
				$modules['dtsl_sp_content']                  = $vc_modules_path . 'single-page/content.php';


			// Load Modules Visual Composer widgets

				$dtsl_modules = dtstorelocator_instance()->active_modules;
				if(is_array($dtsl_modules) && !empty($dtsl_modules)) {
					foreach($dtsl_modules as $dtsl_module) {

						$module_epb_path = DTSL_PLUGIN_MODULE_PATH . '/'.$dtsl_module.'/page-builders/visual-composer/';
						$pb_files = glob($module_epb_path.'*.php');

						if(is_array($pb_files) && !empty($pb_files)) {
							foreach($pb_files as $pb_file) {

								$file_base_name = basename($pb_file, '.php');

								$pb_file_slug = str_replace('-', '_', strtolower($file_base_name));
								$pb_file_slug = 'dtsl_'.$pb_file_slug;

								$modules[$pb_file_slug] = $pb_file;

							}
						}

					}
				}

			// Apply filters so you can easily modify the modules 100%

				$modules = apply_filters( 'dtsl_vc_modules', $modules );


			// Load Modules
			if( !empty( $modules ) ){
				foreach ( $modules as $key => $val ) {
					require_once( $val );
				}
			}


			// Custom Param
			vc_add_shortcode_param( 'title_with_separator', array ( $this, 'dtsl_title_with_separator_settings' ) );

		}

		function dtsl_title_with_separator_settings( $settings, $value ) {

		   	return '<div class="dtsl_' . esc_attr( $settings['param_name'] ) . '_block">
		            	<div class="dtsl_param_separator"></div>
		          </div>';

		}


	}

	DTStoreLocatorVisualComposer::instance();

}

?>