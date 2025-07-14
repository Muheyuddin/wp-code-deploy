<?php

if (!class_exists ( 'DTStoreLocatorRegisterSearchModule' )) {

	class DTStoreLocatorRegisterSearchModule extends DTStoreLocator {

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

			$this->dtsl_define_constants( 'DTSL_SEARCH_PLUGIN_PATH', DTSL_PLUGIN_PATH . 'modules/search/' );
			$this->dtsl_define_constants( 'DTSL_SEARCH_PLUGIN_URL', DTSL_PLUGIN_URL . 'modules/search/' );

			$this->dtsl_define_constants( 'DTSL_PB_MODULE_SEARCHFORM_TITLE', sprintf( esc_html__('%1$s - Search Form', 'dtsl'), DTSL_PLUGIN_NAME ) );

			add_action ( 'wp_enqueue_scripts', array ( $this, 'dtsl_enqueue_scripts' ), 130 );

			require_once DTSL_SEARCH_PLUGIN_PATH . 'shortcodes.php';

		}

		function dtsl_enqueue_scripts() {

			$this->dtsl_register_dependent_files();
			$this->dtsl_enqueue_registered_files();

		}

		function dtsl_register_dependent_files() {

			wp_register_style ( 'dtsl-search-frontend', DTSL_SEARCH_PLUGIN_URL . 'assets/search-frontend.css', array ( 'fontawesome', 'material-icon', 'dtsl-base', 'dtsl-common', 'dtsl-fields' ) );

			wp_register_script ( 'dtsl-search-frontend', DTSL_SEARCH_PLUGIN_URL . 'assets/frontend.js', array ('jquery', 'dtsl-frontend'), false, true );

		}

		function dtsl_enqueue_registered_files() {

			wp_enqueue_style ( 'jquery-ui' );
			wp_enqueue_style ( 'chosen' );
			wp_enqueue_style ( 'dtsl-search-frontend' );

			wp_enqueue_script ( 'jquery-ui-slider' );
			wp_enqueue_script ( 'chosen' );
			wp_enqueue_script ( 'jquery-ui-datepicker' );
			wp_enqueue_script ( 'dtsl-search-frontend' );

		}

	}

}

if( !function_exists('dtslSearchModule') ) {
	function dtslSearchModule() {
		return DTStoreLocatorRegisterSearchModule::instance();
	}
}

dtslSearchModule();

?>