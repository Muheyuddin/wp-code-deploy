<?php

if( !class_exists('DTStoreLocatorDependentFiles') ) {

	class DTStoreLocatorDependentFiles {

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

			add_action ( 'admin_enqueue_scripts', array ( $this, 'dtsl_admin_enqueue_scripts' ), 100 );
			add_action ( 'wp_enqueue_scripts', array ( $this, 'dtsl_enqueue_dependent_files' ), 120 );
			add_action ( 'wp_enqueue_scripts', array ( $this, 'dtsl_dequeue_files' ), 999 );

			require_once DTSL_PLUGIN_PATH . 'assets/css/skin.php';

		}

		/**
		 * Admin enqueue scripts
		 */
		function dtsl_admin_enqueue_scripts() {

			$current_screen = get_current_screen();

			wp_enqueue_media();

			wp_register_style ( 'jquery-ui', DTSL_PLUGIN_URL . 'assets/css/jquery-ui.min.css' );
			wp_register_style ( 'fontawesome', DTSL_PLUGIN_URL . 'assets/css/all.min.css' );
			wp_register_style ( 'material-icon', DTSL_PLUGIN_URL . 'assets/css/material-design-iconic-font.min.css' );
			wp_register_style ( 'chosen', DTSL_PLUGIN_URL . 'assets/css/chosen.css' );
			wp_register_style ( 'dtsl-fields', DTSL_PLUGIN_URL . 'assets/css/fields.css' );
			wp_register_style ( 'dtsl-backend', DTSL_PLUGIN_URL . 'assets/css/backend.css' );
			wp_register_style ( 'dtsl-common', DTSL_PLUGIN_URL . 'assets/css/common.css' );

			wp_register_script ( 'wp-color-picker-alpha', DTSL_PLUGIN_URL . 'assets/js/wp-color-picker-alpha.min.js', array (), false, true );
			wp_register_script ( 'chosen', DTSL_PLUGIN_URL . 'assets/js/chosen.jquery.min.js', array ('jquery'), false, true );
			wp_register_script ( 'dtsl-tabs', DTSL_PLUGIN_URL . 'assets/js/jquery.tabs.min.js', array (), false, true );
			wp_register_script ( 'dtsl-fields', DTSL_PLUGIN_URL . 'assets/js/fields.js', array ('jquery'), false, true );

			wp_register_script ( 'dtsl-common', DTSL_PLUGIN_URL . 'assets/js/common.js', array (), false, true );
			wp_localize_script ( 'dtsl-common', 'dtslcommonobject', array (
					'ajaxurl'  => admin_url('admin-ajax.php'),
					'noResult' => esc_html__('No Results Found!', 'dtsl')
				));

			wp_register_script ( 'dtsl-backend', DTSL_PLUGIN_URL . 'assets/js/backend.js', array (), false, true );
			wp_localize_script ( 'dtsl-backend', 'dtslbackendobject', array (
					'ajaxurl'        => admin_url('admin-ajax.php'),
					'locationAlert1' => esc_html__('To get GPS location please fill address.', 'dtsl'),
					'locationAlert2' => esc_html__('Please add latitude and longitude', 'dtsl'),
					'confirmImport'  => esc_html__('Confirm to import listings', 'dtsl')
				));


			// For Taxonomies & Settings

			if(in_array($current_screen->id, array ('edit-dtsl_listings_category', 'edit-dtsl_listings_ctype', 'edit-dtsl_listings_amenity', 'store-locator_page_dtsl-settings-options'))) {

				// CSS

				wp_enqueue_style ( 'wp-color-picker' );
				wp_enqueue_style ( 'dtsl-fields' );

				wp_enqueue_style ( 'dtsl-backend' );
				wp_enqueue_style ( 'dtsl-common' );


				// JS

				wp_enqueue_script ( 'wp-color-picker' );
				wp_enqueue_script ( 'wp-color-picker-alpha' );
				wp_enqueue_script ( 'dtsl-fields' );

				wp_enqueue_script ( 'dtsl-common' );
				wp_enqueue_script ( 'dtsl-backend' );


			}

			// For Listings

			if($current_screen->id == 'dtsl_listings') {

				// CSS

				wp_enqueue_style ( 'fontawesome' );
				wp_enqueue_style ( 'chosen' );
				wp_enqueue_style ( 'dtsl-fields' );

				wp_enqueue_style ( 'dtsl-backend' );
				wp_enqueue_style ( 'dtsl-common' );


				// JS

				wp_enqueue_script ( 'chosen' );
				wp_enqueue_script ( 'dtsl-tabs' );
				wp_enqueue_script ( 'dtsl-fields' );

				wp_enqueue_script ( 'dtsl-common' );
				wp_enqueue_script ( 'dtsl-backend' );

			}

		}

		/**
		 * Frontend - Register CSS Files
		 */
		function dtsl_enqueue_dependent_files() {

			$this->dtsl_register_css_files();
			$this->dtsl_register_js_files();
			$this->dtsl_localize_registered_js_files();
			$this->dtsl_register_custom_options();
			$this->dtsl_enqueue_registered_files();


			// CSS

				$rtl = isset($_REQUEST['rtl']) ? dtsl_recursive_sanitize_text_field($_REQUEST['rtl']) : '';
				if(is_rtl() || $rtl == 'yes') {
					wp_enqueue_style ( 'dtsl-rtl' );
				}

				if (is_plugin_active('responsive-mortgage-calculator/responsive-mortgage-calculator.php') || is_plugin_active_for_network('responsive-mortgage-calculator/responsive-mortgage-calculator.php')) {
					wp_enqueue_style ( 'dtsl-rmc' );
				}

		}

		/**
		 * Frontend - Register CSS Files
		 */
		function dtsl_register_css_files() {

			wp_register_style ( 'jquery-ui', DTSL_PLUGIN_URL . 'assets/css/jquery-ui.min.css' );
			wp_register_style ( 'fontawesome', DTSL_PLUGIN_URL . 'assets/css/all.min.css' );
			wp_register_style ( 'material-icon', DTSL_PLUGIN_URL . 'assets/css/material-design-iconic-font.min.css' );
			wp_register_style ( 'chosen', DTSL_PLUGIN_URL . 'assets/css/chosen.css' );
			wp_register_style ( 'swiper', DTSL_PLUGIN_URL . 'assets/css/swiper.min.css' );
			wp_register_style ( 'prettyPhoto', DTSL_PLUGIN_URL . 'assets/css/prettyPhoto.css' );
			wp_register_style ( 'dtsl-common', DTSL_PLUGIN_URL . 'assets/css/common.css' );
			wp_register_style ( 'dtsl-base', DTSL_PLUGIN_URL . 'assets/css/base.css' );
			wp_register_style ( 'dtsl-fields', DTSL_PLUGIN_URL . 'assets/css/fields.css' );

			wp_register_style ( 'dtsl-modules-listing', DTSL_PLUGIN_URL . 'assets/css/modules-listing.css', array ( 'fontawesome', 'material-icon', 'dtsl-base', 'dtsl-common' ) );
			wp_register_style ( 'dtsl-modules-default', DTSL_PLUGIN_URL . 'assets/css/modules-default.css', array ( 'fontawesome', 'material-icon', 'dtsl-base', 'dtsl-common' ) );
			wp_register_style ( 'dtsl-modules-singlepage', DTSL_PLUGIN_URL . 'assets/css/modules-singlepage.css', array ( 'fontawesome', 'material-icon', 'dtsl-base', 'dtsl-common' )  );
			wp_register_style ( 'dtsl-rtl', DTSL_PLUGIN_URL . 'assets/css/rtl.css' );
			wp_register_style ( 'dtsl-rmc', DTSL_PLUGIN_URL . 'assets/css/rmc.css' );

		}

		/**
		 * Frontend - Register JS Files
		 */
		function dtsl_register_js_files() {

			wp_register_script ( 'chosen', DTSL_PLUGIN_URL . 'assets/js/chosen.jquery.min.js', array ('jquery'), false, true );
			wp_register_script ( 'swiper', DTSL_PLUGIN_URL . 'assets/js/swiper.min.js', array ('jquery'), false, true );
			wp_register_script ( 'prettyPhoto', DTSL_PLUGIN_URL . 'assets/js/jquery.prettyPhoto.min.js', array ('jquery'), false, true);
			wp_register_script ( 'isotope', DTSL_PLUGIN_URL . 'assets/js/isotope.pkgd.min.js', array ('jquery'), false, true);
			wp_register_script ( 'matchheight', DTSL_PLUGIN_URL . 'assets/js/matchHeight.js', array(), false, true);
			wp_register_script ( 'nicescroll', DTSL_PLUGIN_URL . 'assets/js/jquery.nicescroll.js', array(), false, true);
			wp_register_script ( 'dtsl-fields', DTSL_PLUGIN_URL . 'assets/js/fields.js', array ('jquery', 'jquery-ui-sortable'), false, true );
			wp_register_script ( 'dtsl-common', DTSL_PLUGIN_URL . 'assets/js/common.js', array ('jquery'), false, true );

			wp_register_script ( 'dtsl-frontend', DTSL_PLUGIN_URL . 'assets/js/frontend.js', array ('jquery', 'dtsl-common'), false, true );

			wp_register_script ( 'dtsl-modules-singlepage', DTSL_PLUGIN_URL . 'assets/js/single-page.js', array ('jquery', 'dtsl-frontend'), false, true );

		}

		/**
		 * Frontend - Localize Registered JS Files
		 */
		function dtsl_localize_registered_js_files() {

			$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );
			$incharge_singular_label = apply_filters( 'dt_sl_incharge_label', 'singular' );

			$elementor_preview_mode = false;

			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			if (is_plugin_active('elementor/elementor.php') || is_plugin_active_for_network('elementor/elementor.php')) {  // Elementor Plugin

				if ( \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
					$elementor_preview_mode = true;
				}

			}

			$skin_settings = get_option('dtsl-skin-settings');
			$primary_color = ( isset($skin_settings['primary-color']) && '' !=  $skin_settings['primary-color'] ) ? $skin_settings['primary-color'] : '#1e306e';
			$secondary_color = ( isset($skin_settings['secondary-color']) && '' !=  $skin_settings['secondary-color'] ) ? $skin_settings['secondary-color'] : '#2fa5fb';
			$tertiary_color = ( isset($skin_settings['tertiary-color']) && '' !=  $skin_settings['tertiary-color'] ) ? $skin_settings['tertiary-color'] : '#d2edf8';


			wp_localize_script ( 'dtsl-common', 'dtslcommonobject', array (
				'ajaxurl' => admin_url('admin-ajax.php'),
				'noResult' => esc_html__('No Results Found!', 'dtsl'),
			));

			wp_localize_script ( 'dtsl-frontend', 'dtslfrontendobject', array (
				'pluginFolderPath'                 => plugins_url().'/',
				'pluginPath'                       => DTSL_PLUGIN_URL,
				'ajaxurl'                          => admin_url('admin-ajax.php'),
				'purchased'                        => '<p>'.esc_html__('Purchased', 'dtsl').'</p>',
				'somethingWentWrong'               => '<p>'.esc_html__('Something Went Wrong', 'dtsl').'</p>',
				'addListingSuccess'                => '<p>'.sprintf( esc_html__('Successfully posted your %1$s', 'dtsl'), strtolower($dt_sl_listing_singular_label) ).'</p>',
				'updateProfileSuccess'             => '<p>'.esc_html__('Your profile have been updated successfully.', 'dtsl').'</p>',
				'updateProfilePwdSuccess'          => '<p>'.esc_html__('Password updated successfully.', 'dtsl').'</p>
				<p>'.esc_html__('You will be logged out, please loggin again.', 'dtsl').'</p>',
				'updateInchargeSuccess'            => '<p>'.sprintf( esc_html__('%1$s updated successfully.', 'dtsl'), $incharge_singular_label ).'</p>',
				'naviagtorAlert'                   => esc_html__('Geolocation is not supported by this browser.', 'dtsl'),
				'outputDivAlert'                   => esc_html__('Please make sure you have added output shortcode.', 'dtsl'),
				'confirmRemoveIncharge'            => sprintf( esc_html__('Are you sure, you wish to delete this %1$s ?', 'dtsl'), strtolower($incharge_singular_label) ),
				'confirmRemoveListing'             => sprintf( esc_html__('Are you sure, you wish to delete this %1$s ?', 'dtsl'), strtolower($dt_sl_listing_singular_label) ),
				'confirmRemoveFavouriteListing'    => sprintf( esc_html__('Are you sure, you wish to remove this %1$s from your favourites ?', 'dtsl'), strtolower($dt_sl_listing_singular_label) ),
				'printerTitle'                     => sprintf( esc_html__('%1$s Printer', 'dtsl'), $dt_sl_listing_singular_label ),
				'inchargeStatusActive'             => esc_html__('Active', 'dtsl'),
				'inchargeStatusDisable'            => esc_html__('Disabled', 'dtsl'),
				'inchargeStatusWaitingForApproval' => esc_html__('Waiting For Approval', 'dtsl'),
				'listingWaitingForApproval'        => esc_html__('Waiting For Approval', 'dtsl'),
				'listingPending'                   => esc_html__('Pending', 'dtsl'),
				'listingPublish'                   => esc_html__('Publish', 'dtsl'),
				'listingTooltipSubmitForApproval'  => esc_html__('Submit For Approval', 'dtsl'),
				'listingTooltipRevokeSubmission'   => esc_html__('Revoke Submission For Approval', 'dtsl'),
				'adDurationWarning'                => esc_html__('Please provide duration for your ad', 'dtsl'),
				'adPricingWarning'                 => esc_html__('Please choose any of the pricing available for your ad', 'dtsl'),
				'elementorPreviewMode'             => esc_js($elementor_preview_mode),
				'primaryColor'                     => $primary_color,
				'secondaryColor'                   => $secondary_color,
				'tertiaryColor'                    => $tertiary_color,
			));

		}

		/**
		 * Frontend - Enqueue Registered Files
		 */
		function dtsl_enqueue_registered_files() {

			// CSS

				wp_enqueue_style ( 'swiper' );
				wp_enqueue_style ( 'dtsl-modules-listing' );
				wp_enqueue_style ( 'dtsl-modules-default' );

			// JS

				wp_enqueue_script ( 'swiper' );
				wp_enqueue_script ( 'isotope' );
				wp_enqueue_script ( 'nicescroll' );
				wp_enqueue_script ( 'matchheight' );
				wp_enqueue_script ( 'dtsl-frontend' );

			// Modulewise

				if (is_singular( 'dtsl_listings' )|| is_page_template( 'tpl-single-listing.php' )) {

					wp_enqueue_style ( 'dtsl-modules-singlepage' );

					wp_enqueue_script ( 'dtsl-modules-singlepage' );

				}

		}

		/**
		 * Register Custom Options
		 */
		function dtsl_register_custom_options() {

			if (is_singular( 'dtsl_listings' ) || is_singular( 'dtsl_packages' ) || is_post_type_archive('dtsl_listings') || is_tax('dtsl_listings_category') || is_tax('dtsl_listings_city') || is_tax('dtsl_listings_neighborhood') || is_tax('dtsl_listings_countystate') || is_tax('dtsl_listings_ctype') || is_tax('dtsl_listings_amenity') || is_post_type_archive('dtsl_packages') || is_author() || is_page_template( 'tpl-single-listing.php' ) || is_page_template( 'tpl-dashboard.php' )) {

				$css = '';

				$container_width = dtsl_option('general','container-width');
				if(isset($container_width) && !empty($container_width)) {
					$css = '.dtsl-container { max-width:'.$container_width.'px; }';
				}

				if($css != '') {
					wp_register_style( 'dtsl-custom-options', false );
					wp_enqueue_style( 'dtsl-custom-options' );
					wp_add_inline_style( 'dtsl-custom-options', $css );
				}

			}

		}

		/**
		 * Dequeue Files
		 */
		function dtsl_dequeue_files() {
			if(is_singular( 'post' )) {
				global $wp_styles;
				unset($wp_styles->registered['dtsl-fields']);
			}
		}

	}

}

if( !function_exists('dtsl_dependent_files_instance') ) {
	function dtsl_dependent_files_instance() {
		return DTStoreLocatorDependentFiles::instance();
	}
}

dtsl_dependent_files_instance();

?>