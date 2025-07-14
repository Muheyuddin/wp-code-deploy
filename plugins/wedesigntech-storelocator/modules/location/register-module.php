<?php

if (!class_exists ( 'DTStoreLocatorRegisterLocationModule' )) {

	class DTStoreLocatorRegisterLocationModule extends DTStoreLocator {

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

			$this->dtsl_define_constants( 'DTSL_LOCATION_PLUGIN_PATH', DTSL_PLUGIN_PATH . 'modules/location/' );
			$this->dtsl_define_constants( 'DTSL_LOCATION_PLUGIN_URL', DTSL_PLUGIN_URL . 'modules/location/' );

			add_filter ( 'dtsl_metabox_tabs', array ( $this, 'dtsl_metabox_tabs_tab' ) );
			add_filter ( 'dtsl_settings', array ( $this, 'dtsl_add_settings' ) );

			add_action ( 'admin_enqueue_scripts', array ( $this, 'dtsl_admin_enqueue_scripts' ), 120 );
			add_action ( 'wp_enqueue_scripts', array ( $this, 'dtsl_enqueue_scripts' ), 130 );

			add_action ( 'dtsl_addorupdate_listing_module', array ( $this, 'dtsl_addorupdate_listing_location_module' ), 10, 2 );

			require_once DTSL_LOCATION_PLUGIN_PATH . 'taxonomies.php';
			require_once DTSL_LOCATION_PLUGIN_PATH . 'shortcodes.php';
			require_once DTSL_LOCATION_PLUGIN_PATH . 'dashboard.php';
			require_once DTSL_LOCATION_PLUGIN_PATH . 'utils.php';

		}

		function dtsl_metabox_tabs_tab($tabs) {

			$tabs['location'] = array (
				'label' => esc_html__('Location', 'dtsl'),
				'icon' => 'fas fa-map',
				'path' => DTSL_LOCATION_PLUGIN_PATH . 'metabox-tab-location.php'
			);
			$tabs['virtual-tour'] = array (
				'label' => esc_html__('Virtual Tour', 'dtsl'),
				'icon' => 'fas fa-eye',
				'path' => DTSL_LOCATION_PLUGIN_PATH . 'metabox-tab-virtual-tour.php'
			);

			return $tabs;

		}

		function dtsl_add_settings($tabs) {

			$tabs['location-map'] = array (
				'label' => esc_html__('Location / Map', 'dtsl'),
				'path' => DTSL_LOCATION_PLUGIN_PATH . 'settings.php'
			);

			return $tabs;

		}

		function dtsl_admin_enqueue_scripts() {

			$this->dtsl_register_dependent_files();
			$this->dtsl_localize_registered_dependent_files();

			$current_screen = get_current_screen();
			if($current_screen->id == 'dtsl_listings') {

				wp_enqueue_script ( 'dtsl-admin-map' );

			}

			// For Taxonomies

			if(in_array($current_screen->id, array ('edit-dtsl_listings_city', 'edit-dtsl_listings_neighborhood', 'edit-dtsl_listings_countystate'))) {

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

		}

		function dtsl_enqueue_scripts() {

			$this->dtsl_register_dependent_files();
			$this->dtsl_localize_registered_dependent_files();
			$this->dtsl_enqueue_registered_files();

			if(is_page_template('tpl-dashboard.php')) {
				wp_enqueue_media();
				wp_enqueue_script ( 'dtsl-map' );
			}

		}

		function dtsl_register_dependent_files() {

			// CSS

			wp_register_style ( 'dtsl-location-frontend', DTSL_LOCATION_PLUGIN_URL . 'assets/location-frontend.css', array ( 'fontawesome', 'material-icon', 'dtsl-base', 'dtsl-common' ) );

			wp_register_style ( 'dtsl-location-search', DTSL_LOCATION_PLUGIN_URL . 'assets/location-search.css', array ( 'dtsl-search-frontend' ) );


			// JS

			$googlemap_api_key = dtsl_option('map', 'googlemap-api-key');
			$enable_ssl = (dtsl_option('map', 'enable-ssl') == 'true') ? true : false;

			$map_language = dtsl_option('map','map-language');
			$map_language = (isset($map_language) && $map_language != '') ? $map_language : 'en';

			$googlemap_url = ( $enable_ssl ) ? 'https://maps-api-ssl.google.com/maps/api/js': 'http://maps.googleapis.com/maps/api/js';
			$googlemap_url = add_query_arg( array( 'key' => $googlemap_api_key, 'libraries' => 'places', 'language' => $map_language ) , $googlemap_url );

			wp_register_script ( 'dtsl-google-map', $googlemap_url, array( 'jquery' ), false, true );

			wp_register_script ( 'dtsl-map-cluster', DTSL_LOCATION_PLUGIN_URL . 'assets/markerclusterer.min.js', array( 'jquery' ), false, true );
			wp_register_script ( 'dtsl-map-info', DTSL_LOCATION_PLUGIN_URL . 'assets/infobox.min.js', array( 'jquery' ), false, true );
			wp_register_script ( 'dtsl-map-overlay', DTSL_LOCATION_PLUGIN_URL . 'assets/map-overlay.js', array( 'jquery' ), false, true );

			wp_register_script ( 'dtsl-map', DTSL_LOCATION_PLUGIN_URL . 'assets/map.js', array( 'jquery', 'dtsl-google-map', 'dtsl-map-cluster', 'dtsl-map-info', 'dtsl-map-overlay' ), false, true );

			wp_register_script ( 'dtsl-admin-map', DTSL_LOCATION_PLUGIN_URL . 'assets/map.js', array( 'jquery', 'dtsl-google-map' ), false, true );

			wp_register_script ( 'dtsl-location-search', DTSL_LOCATION_PLUGIN_URL . 'assets/search.js', array ('jquery', 'dtsl-search-frontend'), false, true );
			wp_register_script ( 'dtsl-location-frontend', DTSL_LOCATION_PLUGIN_URL . 'assets/frontend.js', array ('jquery', 'dtsl-frontend'), false, true );


		}

		function dtsl_localize_registered_dependent_files() {

			$default_latitude          = dtsl_option('map', 'default-latitude');
			$default_longitude         = dtsl_option('map', 'default-longitude');
			$default_zoom_level        = dtsl_option('map', 'default-zoom-level');
			$default_map_type          = dtsl_option('map', 'default-map-type');
			$default_map_color         = dtsl_option('map', 'default-map-color');

			$enable_maptype_control    = dtsl_option('map', 'enable-maptype-control');
			$enable_zoom_control       = dtsl_option('map', 'enable-zoom-control');
			$enable_scale_control      = dtsl_option('map', 'enable-scale-control');
			$enable_streetview_control = dtsl_option('map', 'enable-streetview-control');
			$enable_fullscreen_control = dtsl_option('map', 'enable-fullscreen-control');

			wp_localize_script ( 'dtsl-google-map', 'dtslmapobject', array (
				'defaultLatitude'         => $default_latitude,
				'defaultLongitude'        => $default_longitude,
				'defaultZoomLevel'        => $default_zoom_level,
				'defaultMapType'          => $default_map_type,
				'defaultMapColor'         => $default_map_color,
				'enableMapTypeControl'    => $enable_maptype_control,
				'enableZoomControl'       => $enable_zoom_control,
				'enableScaleControl'      => $enable_scale_control,
				'enableStreetViewControl' => $enable_streetview_control,
				'enableFullscreenControl' => $enable_fullscreen_control
			));

		}

		function dtsl_enqueue_registered_files() {

			wp_enqueue_style ( 'chosen' );
			wp_enqueue_style ( 'jquery-ui' );
			wp_enqueue_style ( 'dtsl-location-frontend' );
			wp_enqueue_style ( 'dtsl-location-search' );

			wp_enqueue_script ( 'chosen' );
			wp_enqueue_script ( 'jquery-ui-slider' );
			wp_enqueue_script ( 'dtsl-map' );
			wp_enqueue_script ( 'dtsl-location-search' );
			wp_enqueue_script ( 'dtsl-location-frontend' );

		}

		function dtsl_addorupdate_listing_location_module($data, $listing_id) {

			extract($data);

			// Location

			if( isset( $dtsl_map_image ) && $dtsl_map_image != '') {
				update_post_meta ( $listing_id, 'dtsl_map_image', $dtsl_map_image );
			} else {
				delete_post_meta ( $listing_id, 'dtsl_map_image' );
			}

			if( isset( $dtsl_address ) && $dtsl_address != '') {
				update_post_meta ( $listing_id, 'dtsl_address', $dtsl_address );
			} else {
				delete_post_meta ( $listing_id, 'dtsl_address' );
			}

			if( isset( $dtsl_zip ) && $dtsl_zip != '') {
				update_post_meta ( $listing_id, 'dtsl_zip', $dtsl_zip );
			} else {
				delete_post_meta ( $listing_id, 'dtsl_zip' );
			}

			if( isset( $dtsl_country ) && $dtsl_country != '') {
				update_post_meta ( $listing_id, 'dtsl_country', $dtsl_country );
			} else {
				delete_post_meta ( $listing_id, 'dtsl_country' );
			}

			if( isset( $dtsl_latitude ) && $dtsl_latitude != '') {
				update_post_meta ( $listing_id, 'dtsl_latitude', $dtsl_latitude );
			} else {
				delete_post_meta ( $listing_id, 'dtsl_latitude' );
			}

			if( isset( $dtsl_longitude ) && $dtsl_longitude != '') {
				update_post_meta ( $listing_id, 'dtsl_longitude', $dtsl_longitude );
			} else {
				delete_post_meta ( $listing_id, 'dtsl_longitude' );
			}


			// Virtual Tour

			if( isset( $dtsl_virtual_tour ) && $dtsl_virtual_tour != '') {
				update_post_meta ( $listing_id, 'dtsl_virtual_tour', $dtsl_virtual_tour );
			} else {
				delete_post_meta ( $listing_id, 'dtsl_virtual_tour' );
			}


			// Taxonomies

			if( is_array( $dtsl_city ) && !empty($dtsl_city) ) {
				wp_set_object_terms($listing_id, $dtsl_city, 'dtsl_listings_city');
			}

			if( is_array( $dtsl_neighborhood ) && !empty($dtsl_neighborhood) ) {
				wp_set_object_terms($listing_id, $dtsl_neighborhood, 'dtsl_listings_neighborhood');
			}

			if( is_array( $dtsl_countystate ) && !empty($dtsl_countystate) ) {
				wp_set_object_terms($listing_id, $dtsl_countystate, 'dtsl_listings_countystate');
			}

		}

	}

}

if( !function_exists('dtslLocationModule') ) {
	function dtslLocationModule() {
		return DTStoreLocatorRegisterLocationModule::instance();
	}
}

dtslLocationModule();

?>