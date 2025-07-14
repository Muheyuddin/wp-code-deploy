<?php

if (!class_exists ( 'DTStoreLocatorRegisterSocialShareModule' )) {

	class DTStoreLocatorRegisterSocialShareModule extends DTStoreLocator {

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

			$this->dtsl_define_constants( 'DTSL_SOCIALSHARE_PLUGIN_PATH', DTSL_PLUGIN_PATH . 'modules/social-share/' );
			$this->dtsl_define_constants( 'DTSL_SOCIALSHARE_PLUGIN_URL', DTSL_PLUGIN_URL . 'modules/social-share/' );

			add_action ( 'wp_enqueue_scripts', array ( $this, 'dtsl_enqueue_scripts' ), 130 );

			require_once DTSL_SOCIALSHARE_PLUGIN_PATH . 'shortcodes.php';

		}

		function dtsl_enqueue_scripts() {
			$this->dtsl_register_dependent_files();
			$this->dtsl_enqueue_registered_files();
		}

		function dtsl_register_dependent_files() {

			wp_register_style ( 'dtsl-social-share-frontend', DTSL_SOCIALSHARE_PLUGIN_URL . 'assets/social-share-frontend.css', array ( 'fontawesome', 'material-icon', 'dtsl-base', 'dtsl-common' ) );

			wp_register_script ( 'dtsl-social-share-frontend', DTSL_SOCIALSHARE_PLUGIN_URL . 'assets/frontend.js', array ('jquery', 'dtsl-common'), false, true );

		}

		function dtsl_enqueue_registered_files() {

			wp_enqueue_style ( 'dtsl-social-share-frontend' );

			wp_enqueue_script ( 'dtsl-social-share-frontend' );

		}

	}

}

if( !function_exists('dtslSocialShareModule') ) {
	function dtslSocialShareModule() {
		return DTStoreLocatorRegisterSocialShareModule::instance();
	}
}

dtslSocialShareModule();

?>