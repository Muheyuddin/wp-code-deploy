<?php

if (!class_exists ( 'DTDirectoryRegisterEventsModule' )) {

	class DTDirectoryRegisterEventsModule extends DTDirectoryAddon {

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

			$this->dtdr_define_constants( 'DTDR_EVENTS_PLUGIN_PATH', DTDR_PLUGIN_PATH . 'modules/events/' );
			$this->dtdr_define_constants( 'DTDR_EVENTS_PLUGIN_URL', DTDR_PLUGIN_URL . 'modules/events/' );

			add_filter ( 'dtdr_metabox_tabs', array ( $this, 'dtdr_metabox_tabs_tab' ) );

			add_action ( 'admin_enqueue_scripts', array ( $this, 'dtdr_admin_enqueue_scripts' ), 120 );
			add_action ( 'wp_enqueue_scripts', array ( $this, 'dtdr_enqueue_scripts' ), 130 );
			add_action ( 'dtdr_addorupdate_listing_module', array ( $this, 'dtdr_addorupdate_listing_events_module' ), 10, 2 );

			require_once DTDR_EVENTS_PLUGIN_PATH . 'dashboard.php';
			require_once DTDR_EVENTS_PLUGIN_PATH . 'shortcodes.php';
			require_once DTDR_EVENTS_PLUGIN_PATH . 'utils.php';

		}

		function dtdr_metabox_tabs_tab($tabs) {

			$tabs['event'] = array (
				'label' => esc_html__('Event', 'dtdr'),
				'icon' => 'fas fa-calendar-alt',
				'path' => DTDR_EVENTS_PLUGIN_PATH . 'metabox-tab-listing.php'
			);

			return $tabs;

		}

		function dtdr_admin_enqueue_scripts() {

			$this->dtdr_register_dependent_files();

			$current_screen = get_current_screen();
			if($current_screen->id == 'dtdr_listings') {
				wp_enqueue_style ( 'jquery-ui' );

				wp_enqueue_script ( 'dtdr-events-common' );
			}

		}

		function dtdr_enqueue_scripts() {
			$this->dtdr_register_dependent_files();
			$this->dtdr_enqueue_registered_files();

			if(is_page_template('tpl-dashboard.php')) {
				wp_enqueue_style ( 'jquery-ui' );

				wp_enqueue_script ( 'dtdr-events-common' );
			}
		}

		function dtdr_register_dependent_files() {

			wp_register_style ( 'dtdr-events-frontend', DTDR_EVENTS_PLUGIN_URL . 'assets/events-frontend.css', array ( 'fontawesome', 'material-icon', 'dtdr-base', 'dtdr-common', 'dtdr-modules-singlepage' ) );

			wp_register_script ( 'dtdr-countdown', DTDR_EVENTS_PLUGIN_URL . 'assets/jquery.downCount.min.js', array ('jquery'), false, true );
			wp_register_script ( 'dtdr-events-common', DTDR_EVENTS_PLUGIN_URL . 'assets/common.js', array ( 'jquery', 'jquery-ui-datepicker' ), false, true );
			wp_register_script ( 'dtdr-events-frontend', DTDR_EVENTS_PLUGIN_URL . 'assets/frontend.js', array ('jquery', 'dtdr-common'), false, true );

		}

		function dtdr_enqueue_registered_files() {

			wp_enqueue_style ( 'dtdr-events-frontend' );

			wp_enqueue_script ( 'dtdr-countdown' );
			wp_enqueue_script ( 'dtdr-events-common' );
			wp_enqueue_script ( 'dtdr-events-frontend' );

		}

		function dtdr_addorupdate_listing_events_module($data, $listing_id) {

			extract($data);

			if( isset( $dtdr_start_date ) && $dtdr_start_date != '') {
				update_post_meta ( $listing_id, 'dtdr_start_date', dtdr_recursive_sanitize_text_field( $dtdr_start_date ) );
				$dtdr_start_date_compare_format = date('Ymd', strtotime($dtdr_start_date));
				update_post_meta ( $listing_id, 'dtdr_start_date_compare_format', $dtdr_start_date_compare_format );
			} else {
				delete_post_meta ( $listing_id, 'dtdr_start_date' );
				delete_post_meta ( $listing_id, 'dtdr_start_date_compare_format' );
			}

			if( isset( $dtdr_end_date ) && $dtdr_end_date != '') {
				update_post_meta ( $listing_id, 'dtdr_end_date', dtdr_recursive_sanitize_text_field( $dtdr_end_date ) );
			} else {
				delete_post_meta ( $listing_id, 'dtdr_end_date' );
			}

			if( isset( $dtdr_start_time ) && $dtdr_start_time != '') {
				update_post_meta ( $listing_id, 'dtdr_start_time', dtdr_recursive_sanitize_text_field( $dtdr_start_time ) );
			} else {
				delete_post_meta ( $listing_id, 'dtdr_start_time' );
			}

			if( isset( $dtdr_end_time ) && $dtdr_end_time != '') {
				update_post_meta ( $listing_id, 'dtdr_end_time', dtdr_recursive_sanitize_text_field( $dtdr_end_time ) );
			} else {
				delete_post_meta ( $listing_id, 'dtdr_end_time' );
			}

			if( isset( $dtdr_24_hour_format ) && $dtdr_24_hour_format != '') {
				update_post_meta ( $listing_id, 'dtdr_24_hour_format', dtdr_recursive_sanitize_text_field( $dtdr_24_hour_format ) );
			} else {
				delete_post_meta ( $listing_id, 'dtdr_24_hour_format' );
			}

		}

	}

}

if( !function_exists('dtdrEventsModule') ) {
	function dtdrEventsModule() {
		return DTDirectoryRegisterEventsModule::instance();
	}
}

dtdrEventsModule();

?>