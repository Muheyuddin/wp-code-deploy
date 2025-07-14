<?php

namespace DTElementor\widgets;

if (! class_exists ( 'DTStoreLocatorElementor' )) {

	class DTStoreLocatorElementor {

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

		/**
		 * Constructor
		 */
		function __construct() {

			add_action( 'elementor/elements/categories_registered', array( $this, 'dtsl_register_category' ) );

			add_action( 'elementor/widgets/widgets_registered', array( $this, 'dtsl_register_widgets' ) );

			add_action( 'elementor/frontend/after_register_styles', array( $this, 'dtsl_register_widget_styles' ) );
			add_action( 'elementor/frontend/after_register_scripts', array( $this, 'dtsl_register_widget_scripts' ) );

			add_action( 'elementor/preview/enqueue_styles', array( $this, 'dtsl_preview_styles') );

		}

		/**
		 * Register category
		 * Add plugin category in elementor
		 */
		public function dtsl_register_category( $elements_manager ) {

			$elements_manager->add_category(
				'dtsl-default-widgets',array(
					'title' => DTSL_PB_MODULE_DEFAULT_TITLE,
					'icon'  => 'font'
				)
			);

			$elements_manager->add_category(
				'dtsl-singlepage-widgets',array(
					'title' => DTSL_PB_MODULE_SINGLEPAGE_TITLE,
					'icon'  => 'font'
				)
			);

			$dtsl_modules = dtstorelocator_instance()->active_modules;
			if(is_array($dtsl_modules) && !empty($dtsl_modules)) {
				if(in_array('search', $dtsl_modules)) {
					$elements_manager->add_category(
						'dtsl-searchform-widgets',array(
							'title' => DTSL_PB_MODULE_SEARCHFORM_TITLE,
							'icon'  => 'font'
						)
					);
				}
			}

		}

		/**
		 * Parse Attributes
		 * Parse shortcode attributes
		 */
		public function dtsl_parse_shortcode_attrs( $attrs ) {

			$keys_to_filter = array ( 'animation_duration', 'hide_desktop', 'hide_tablet', 'hide_mobile' );

			$attrs_str = '';
			if(is_array($attrs) && !empty($attrs)) {
				foreach($attrs as $attr_key => $attr) {
					$first_character = substr($attr_key, 0, 1);
					if(!is_array($attr) && $first_character != '_' && !in_array($attr_key, $keys_to_filter)) {

						$attrs_str .= $attr_key.'="'.$attr.'" ';
					}
				}
			}

			return $attrs_str;

		}

		/**
		 * Register widgets
		 */
		public function dtsl_register_widgets( $widgets_manager ) {

			$elementor_modules_path = DTSL_PLUGIN_PATH . 'page-builders/elementor/widgets/';

			# Default Modules

				require $elementor_modules_path . 'default/class-login-logout-links.php';
				$widgets_manager->register_widget_type( new DTStoreLocatorDfLoginLogoutLinks() );

				require $elementor_modules_path . 'default/class-listings-listing.php';
				$widgets_manager->register_widget_type( new DTStoreLocatorDfListingsListing() );

				require $elementor_modules_path . 'default/class-listings-taxonomy.php';
				$widgets_manager->register_widget_type( new DTStoreLocatorDfListingsTaxonomy() );

			# Listing Single Page Modules

				require $elementor_modules_path . 'single-page/featured-image.php';
				$widgets_manager->register_widget_type( new DTStoreLocatorSpFeaturedImage() );

				require $elementor_modules_path . 'single-page/featured-item.php';
				$widgets_manager->register_widget_type( new DTStoreLocatorSpFeaturedItem() );

				require $elementor_modules_path . 'single-page/features.php';
				$widgets_manager->register_widget_type( new DTStoreLocatorSpFeatures() );

				require $elementor_modules_path . 'single-page/contact-details.php';
				$widgets_manager->register_widget_type( new DTStoreLocatorSpContactDetails() );

				require $elementor_modules_path . 'single-page/contact-details-request.php';
				$widgets_manager->register_widget_type( new DTStoreLocatorSpContactDetailsRequest() );

				require $elementor_modules_path . 'single-page/social-links.php';
				$widgets_manager->register_widget_type( new DTStoreLocatorSpSocialLinks() );

				require $elementor_modules_path . 'single-page/comments.php';
				$widgets_manager->register_widget_type( new DTStoreLocatorSpComments() );

				require $elementor_modules_path . 'single-page/utils.php';
				$widgets_manager->register_widget_type( new DTStoreLocatorSpUtils() );

				require $elementor_modules_path . 'single-page/taxonomy.php';
				$widgets_manager->register_widget_type( new DTStoreLocatorSpTaxonomy() );

				require $elementor_modules_path . 'single-page/contact-form.php';
				$widgets_manager->register_widget_type( new DTStoreLocatorSpContactForm() );

				require $elementor_modules_path . 'single-page/post-date.php';
				$widgets_manager->register_widget_type( new DTStoreLocatorSpPostDate() );

				require $elementor_modules_path . 'single-page/mls-number.php';
				$widgets_manager->register_widget_type( new DTStoreLocatorSpMlsNumber() );

				require $elementor_modules_path . 'single-page/content.php';
				$widgets_manager->register_widget_type( new DTStoreLocatorSpContent() );


			# Load Modules Elementor widgets

				$dtsl_modules = dtstorelocator_instance()->active_modules;
				if(is_array($dtsl_modules) && !empty($dtsl_modules)) {
					$search_module_exists = false;
					if(in_array('search', $dtsl_modules)) {
						$search_module_exists = true;
					}
					foreach($dtsl_modules as $dtsl_module) {

						$module_epb_path = DTSL_PLUGIN_MODULE_PATH . '/'.$dtsl_module.'/page-builders/elementor/';
						$pb_files = glob($module_epb_path.'*.php');

						if(is_array($pb_files) && !empty($pb_files)) {
							foreach($pb_files as $pb_file) {

								$file_base_name = basename($pb_file, '.php');
								$file_base_name = explode('-', $file_base_name);

								if(($file_base_name[0] == 'sf' && $search_module_exists) || ($file_base_name[0] != 'sf')) {

									require $pb_file;

									$class_name = implode('', array_map("ucfirst", $file_base_name));
									$class_name =  'DTElementor\Widgets\DTStoreLocator'.$class_name;

									$widgets_manager->register_widget_type( new $class_name() );

								}

							}
						}

					}
				}


		}

		/**
		 * Register widgets styles
		 */
		public function dtsl_register_widget_styles() {

			dtsl_dependent_files_instance()->dtsl_register_css_files();

		}


		/**
		 * Register widgets scripts
		 */
		public function dtsl_register_widget_scripts() {

			dtsl_dependent_files_instance()->dtsl_register_js_files();

			# Load Modules Dependent Scripts

				$dtsl_modules = dtstorelocator_instance()->active_modules;
				if(is_array($dtsl_modules) && !empty($dtsl_modules)) {
					foreach($dtsl_modules as $dtsl_module) {
						$dtsl_module = explode('-', $dtsl_module);
						$dtsl_module = implode('', array_map("ucfirst", $dtsl_module));
						$moduleInstance = 'dtsl'.$dtsl_module.'Module';
						if(method_exists($moduleInstance(), 'dtsl_register_dependent_files')) {
							$moduleInstance()->dtsl_register_dependent_files();
						}
					}
				}

		}


		/**
		 * Editor Preview Style
		 */
		public function dtsl_preview_styles() {
		}


	}

}


if( !function_exists('dtstorelocator_elementor_instance') ) {
	function dtstorelocator_elementor_instance() {
		return DTStoreLocatorElementor::instance();
	}
}

dtstorelocator_elementor_instance();
?>