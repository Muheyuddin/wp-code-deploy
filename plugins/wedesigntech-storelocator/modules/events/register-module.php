<?php

if (!class_exists ( 'DTStoreLocatorRegisterEventsModule' )) {

	class DTStoreLocatorRegisterEventsModule extends DTStoreLocator {

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

			$this->dtsl_define_constants( 'DTSL_EVENTS_PLUGIN_PATH', DTSL_PLUGIN_PATH . 'modules/events/' );
			$this->dtsl_define_constants( 'DTSL_EVENTS_PLUGIN_URL', DTSL_PLUGIN_URL . 'modules/events/' );

			add_filter ( 'dtsl_metabox_tabs', array ( $this, 'dtsl_metabox_tabs_tab' ) );

			add_action ( 'admin_enqueue_scripts', array ( $this, 'dtsl_admin_enqueue_scripts' ), 120 );
			add_action ( 'wp_enqueue_scripts', array ( $this, 'dtsl_enqueue_scripts' ), 130 );
			add_action ( 'dtsl_addorupdate_listing_module', array ( $this, 'dtsl_addorupdate_listing_events_module' ), 10, 2 );

			require_once DTSL_EVENTS_PLUGIN_PATH . 'dashboard.php';
			require_once DTSL_EVENTS_PLUGIN_PATH . 'shortcodes.php';
			require_once DTSL_EVENTS_PLUGIN_PATH . 'utils.php';

		}

		function dtsl_metabox_tabs_tab($tabs) {

			$tabs['event'] = array (
				'label' => esc_html__('Event', 'dtsl'),
				'icon' => 'fas fa-calendar-alt',
				'path' => DTSL_EVENTS_PLUGIN_PATH . 'metabox-tab-listing.php'
			);

			return $tabs;

		}

		function dtsl_admin_enqueue_scripts() {

			$this->dtsl_register_dependent_files();

			$current_screen = get_current_screen();
			if($current_screen->id == 'dtsl_listings') {
				wp_enqueue_style ( 'jquery-ui' );

				wp_enqueue_script ( 'dtsl-events-common' );
			}

		}

		function dtsl_enqueue_scripts() {
			$this->dtsl_register_dependent_files();
			$this->dtsl_enqueue_registered_files();

			if(is_page_template('tpl-dashboard.php')) {
				wp_enqueue_style ( 'jquery-ui' );

				wp_enqueue_script ( 'dtsl-events-common' );
			}
		}

		function dtsl_register_dependent_files() {

			wp_register_style ( 'dtsl-events-frontend', DTSL_EVENTS_PLUGIN_URL . 'assets/events-frontend.css', array ( 'fontawesome', 'material-icon', 'dtsl-base', 'dtsl-common', 'dtsl-modules-singlepage' ) );

			wp_register_script ( 'dtsl-countdown', DTSL_EVENTS_PLUGIN_URL . 'assets/jquery.downCount.min.js', array ('jquery'), false, true );
			wp_register_script ( 'dtsl-events-common', DTSL_EVENTS_PLUGIN_URL . 'assets/common.js', array ( 'jquery', 'jquery-ui-datepicker' ), false, true );
			wp_register_script ( 'dtsl-events-frontend', DTSL_EVENTS_PLUGIN_URL . 'assets/frontend.js', array ('jquery', 'dtsl-common'), false, true );

		}

		function dtsl_enqueue_registered_files() {

			wp_enqueue_style ( 'dtsl-events-frontend' );

			wp_enqueue_script ( 'dtsl-countdown' );
			wp_enqueue_script ( 'dtsl-events-common' );
			wp_enqueue_script ( 'dtsl-events-frontend' );

		}

		function dtsl_addorupdate_listing_events_module($data, $listing_id) {

			extract($data);

			if( isset( $dtsl_start_date ) && $dtsl_start_date != '') {
				update_post_meta ( $listing_id, 'dtsl_start_date', dtsl_recursive_sanitize_text_field( $dtsl_start_date ) );
				$dtsl_start_date_compare_format = date('Ymd', strtotime($dtsl_start_date));
				update_post_meta ( $listing_id, 'dtsl_start_date_compare_format', $dtsl_start_date_compare_format );
			} else {
				delete_post_meta ( $listing_id, 'dtsl_start_date' );
				delete_post_meta ( $listing_id, 'dtsl_start_date_compare_format' );
			}

			if( isset( $dtsl_end_date ) && $dtsl_end_date != '') {
				update_post_meta ( $listing_id, 'dtsl_end_date', dtsl_recursive_sanitize_text_field( $dtsl_end_date ) );
			} else {
				delete_post_meta ( $listing_id, 'dtsl_end_date' );
			}

			if( isset( $dtsl_start_time ) && $dtsl_start_time != '') {
				update_post_meta ( $listing_id, 'dtsl_start_time', dtsl_recursive_sanitize_text_field( $dtsl_start_time ) );
			} else {
				delete_post_meta ( $listing_id, 'dtsl_start_time' );
			}

			if( isset( $dtsl_end_time ) && $dtsl_end_time != '') {
				update_post_meta ( $listing_id, 'dtsl_end_time', dtsl_recursive_sanitize_text_field( $dtsl_end_time ) );
			} else {
				delete_post_meta ( $listing_id, 'dtsl_end_time' );
			}

			if( isset( $dtsl_24_hour_format ) && $dtsl_24_hour_format != '') {
				update_post_meta ( $listing_id, 'dtsl_24_hour_format', dtsl_recursive_sanitize_text_field( $dtsl_24_hour_format ) );
			} else {
				delete_post_meta ( $listing_id, 'dtsl_24_hour_format' );
			}

		}

	}

}

if( !function_exists('dtslEventsModule') ) {
	function dtslEventsModule() {
		return DTStoreLocatorRegisterEventsModule::instance();
	}
}

dtslEventsModule();

?>