<?php

if (!class_exists ( 'DTStoreLocatorRegisterStatisticsModule' )) {

	class DTStoreLocatorRegisterStatisticsModule extends DTStoreLocator {

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

			$this->dtsl_define_constants( 'DTSL_STATISTICS_PLUGIN_PATH', DTSL_PLUGIN_PATH . 'modules/statistics/' );
			$this->dtsl_define_constants( 'DTSL_STATISTICS_PLUGIN_URL', DTSL_PLUGIN_URL . 'modules/statistics/' );

			add_action ( 'admin_menu', array ( $this, 'dtsl_configure_statistics_admin_menu' ), 40 );

			add_action ( 'admin_enqueue_scripts', array ( $this, 'dtsl_admin_enqueue_scripts' ), 120 );

			require_once DTSL_STATISTICS_PLUGIN_PATH . 'statistics-listings.php';
			require_once DTSL_STATISTICS_PLUGIN_PATH . 'statistics-sellers.php';

		}

		function dtsl_configure_statistics_admin_menu() {
			add_submenu_page( 'dtsl', 'Statistics', 'Statistics', 'edit_posts', 'dtsl-statistics-options', array ( $this, 'dtsl_statistics_options' ) );
		}

		function dtsl_statistics_options() {

			$listing_plural_label = apply_filters( 'dt_sl_listing_label', 'plural' );
			$seller_plural_label = apply_filters( 'dt_sl_seller_label', 'plural' );

			$tabs = array (
				'listings'   => array (
					'label' => $listing_plural_label,
					'callback' => 'dtsl_statistics_listings_content'
				),
				'sellers'     =>  array (
					'label' => $seller_plural_label,
					'callback' => 'dtsl_statistics_sellers_content'
				)
			);

			$tabs = apply_filters( 'dtsl_statistics', $tabs );

			$current = isset( $_GET['parenttab'] ) ? dtsl_recursive_sanitize_text_field($_GET['parenttab']) : 'listings';

			$this->dtsl_get_statistics_submenus($current, $tabs);
			$this->dtsl_get_statistics_tab($current, $tabs);

		}

		function dtsl_get_statistics_submenus($current, $tabs) {

			echo '<h2 class="dtsl-custom-nav nav-tab-wrapper">';
				foreach( $tabs as $key => $tab ) {
					$class = ( $key == $current ) ? 'nav-tab-active' : '';
					echo '<a class="nav-tab '.$class.'" href="?page=dtsl-statistics-options&parenttab='.$key.'">'.$tab['label'].'</a>';
				}
			echo '</h2>';

		}

		function dtsl_get_statistics_tab($current, $tabs) {
			call_user_func($tabs[$current]['callback']);
		}

		function dtsl_admin_enqueue_scripts() {
			$this->dtsl_register_dependent_files();

			$current_screen = get_current_screen();
			if($current_screen->id == 'store-locator_page_dtsl-statistics-options') {
				wp_enqueue_style ( 'dtsl-statistics-backend' );

				wp_enqueue_script ( 'dtsl-statistics-backend' );
			}
		}

		function dtsl_register_dependent_files() {

			wp_register_style ( 'dtsl-statistics-backend', DTSL_STATISTICS_PLUGIN_URL . 'assets/statistics-backend.css', array ( 'fontawesome', 'chosen', 'dtsl-fields', 'dtsl-backend', 'dtsl-common' ) );

			wp_register_script ( 'dtsl-statistics-backend', DTSL_STATISTICS_PLUGIN_URL . 'assets/backend.js', array ( 'jquery', 'dtsl-fields', 'dtsl-common', 'dtsl-backend' ), false, true );

		}

	}

}

if( !function_exists('dtslStatisticsModule') ) {
	function dtslStatisticsModule() {
		return DTStoreLocatorRegisterStatisticsModule::instance();
	}
}

dtslStatisticsModule();

?>