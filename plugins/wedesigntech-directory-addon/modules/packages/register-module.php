<?php

if (!class_exists ( 'DTDirectoryRegisterPackagesModule' )) {

	class DTDirectoryRegisterPackagesModule extends DTDirectoryAddon {

		private $module_name;
		private $module_url;

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

			$this->dtdr_define_constants( 'DTDR_PACKAGES_PLUGIN_PATH', DTDR_PLUGIN_PATH . 'modules/packages/' );
			$this->dtdr_define_constants( 'DTDR_PACKAGES_PLUGIN_URL', DTDR_PLUGIN_URL . 'modules/packages/' );

			add_filter ( 'dtdr_woo_purchase_cpt', array ( $this, 'dtdr_woo_purchase_cpt_update' ), 10, 1 );

			add_action ( 'admin_enqueue_scripts', array ( $this, 'dtdr_admin_enqueue_scripts' ), 120 );
			add_action ( 'wp_enqueue_scripts', array ( $this, 'dtdr_enqueue_scripts' ), 130 );

			require_once DTDR_PACKAGES_PLUGIN_PATH . 'post-type.php';
			require_once DTDR_PACKAGES_PLUGIN_PATH . 'shortcodes.php';
			require_once DTDR_PACKAGES_PLUGIN_PATH . 'statistics.php';
			require_once DTDR_PACKAGES_PLUGIN_PATH . 'utils.php';
			require_once DTDR_PACKAGES_PLUGIN_PATH . 'utils-woocommerce.php';

		}

		function dtdr_woo_purchase_cpt_update($cpt) {

			array_push($cpt, 'dtdr_packages');

			return $cpt;

		}

		function dtdr_plugins_loaded_from_package_module() {

			// WooCommerce Payment Functionality

				if ( class_exists( 'WooCommerce' ) ) {
					require_once DTDR_PACKAGES_PLUGIN_PATH . 'woocommerce.php';
				}

		}

		function dtdr_admin_enqueue_scripts() {

			$this->dtdr_register_dependent_files();

			$current_screen = get_current_screen();
			if($current_screen->id == 'dtdr_packages') {
				wp_enqueue_style ( 'dtdr-packages-backend' );

				wp_enqueue_script ( 'dtdr-packages-backend' );
			}

		}

		function dtdr_enqueue_scripts() {

			$this->dtdr_register_dependent_files();
			$this->dtdr_enqueue_registered_files();

		}

		function dtdr_register_dependent_files() {

			wp_register_style ( 'dtdr-packages-backend', DTDR_PACKAGES_PLUGIN_URL . 'assets/packages-backend.css', array ( 'chosen', 'dtdr-fields', 'dtdr-backend', 'dtdr-common' ) );
			wp_register_style ( 'dtdr-packages-frontend', DTDR_PACKAGES_PLUGIN_URL . 'assets/packages-frontend.css', array ( 'fontawesome', 'material-icon', 'dtdr-base', 'dtdr-common' ) );

			wp_register_script ( 'dtdr-packages-backend', DTDR_PACKAGES_PLUGIN_URL . 'assets/backend.js', array ( 'chosen', 'dtdr-fields', 'dtdr-backend', 'dtdr-common' ), false, true );
			wp_register_script ( 'dtdr-packages-frontend', DTDR_PACKAGES_PLUGIN_URL . 'assets/frontend.js', array ('jquery', 'dtdr-frontend'), false, true );
			wp_register_script ( 'dtdr-packages-statistics', DTDR_PACKAGES_PLUGIN_URL . 'assets/statistics.js', array ('jquery', 'dtdr-statistics-backend'), false, true );

		}

		function dtdr_enqueue_registered_files() {

			wp_enqueue_style ( 'dtdr-packages-frontend' );

			wp_enqueue_script ( 'dtdr-packages-frontend' );

		}

	}

}

if( !function_exists('dtdrPackagesModule') ) {
	function dtdrPackagesModule() {
		return DTDirectoryRegisterPackagesModule::instance();
	}
}

dtdrPackagesModule();

?>