<?php

if (!class_exists ( 'DTStoreLocatorRegisterMediaImagesModule' )) {

	class DTStoreLocatorRegisterMediaImagesModule extends DTStoreLocator {

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

			$this->dtsl_define_constants( 'DTSL_MIMAGES_PLUGIN_PATH', DTSL_PLUGIN_PATH . 'modules/media-images/' );
			$this->dtsl_define_constants( 'DTSL_MIMAGES_PLUGIN_URL', DTSL_PLUGIN_URL . 'modules/media-images/' );

			add_filter ( 'dtsl_metabox_tabs', array ( $this, 'dtsl_metabox_tabs_tab' ) );

			add_action ( 'admin_enqueue_scripts', array ( $this, 'dtsl_admin_enqueue_scripts' ), 120 );
			add_action ( 'wp_enqueue_scripts', array ( $this, 'dtsl_enqueue_scripts' ), 130 );

			add_action ( 'dtsl_addorupdate_listing_module', array ( $this, 'dtsl_addorupdate_listing_mediaimages_module' ), 10, 2 );

			require_once DTSL_MIMAGES_PLUGIN_PATH . 'utils.php';
			require_once DTSL_MIMAGES_PLUGIN_PATH . 'shortcodes.php';
			require_once DTSL_MIMAGES_PLUGIN_PATH . 'dashboard.php';

		}

		function dtsl_metabox_tabs_tab($tabs) {

			$tabs['media-images'] = array (
				'label' => esc_html__('Media - Images', 'dtsl'),
				'icon' => 'fas fa-camera-retro',
				'path' => DTSL_MIMAGES_PLUGIN_PATH . 'metabox-tab-listing.php'
			);

			return $tabs;

		}

		function dtsl_admin_enqueue_scripts() {

			$this->dtsl_register_dependent_files();

			$current_screen = get_current_screen();
			if($current_screen->id == 'dtsl_listings') {
				wp_enqueue_style ( 'dtsl-media-images-fields' );
				wp_enqueue_script ( 'dtsl-media-images-fields' );
			}

		}

		function dtsl_enqueue_scripts() {

			$this->dtsl_register_dependent_files();
			$this->dtsl_enqueue_registered_files();

			if(is_page_template('tpl-dashboard.php')) {
				wp_enqueue_media();
				wp_enqueue_script ( 'dtsl-media-images-fields' );
			}

		}

		function dtsl_register_dependent_files() {

			wp_register_style ( 'dtsl-media-images-frontend', DTSL_MIMAGES_PLUGIN_URL . 'assets/media-images-frontend.css', array ( 'fontawesome', 'material-icon', 'dtsl-base', 'dtsl-common', 'swiper' ) );

			wp_register_script ( 'dtsl-media-images-fields', DTSL_MIMAGES_PLUGIN_URL . 'assets/fields.js', array ('jquery', 'dtsl-fields'), false, true );
			wp_register_script ( 'dtsl-media-images-frontend', DTSL_MIMAGES_PLUGIN_URL . 'assets/frontend.js', array ('jquery', 'dtsl-frontend', 'swiper'), false, true );

		}

		function dtsl_enqueue_registered_files() {

			wp_enqueue_style ( 'dtsl-media-images-frontend' );

			wp_enqueue_script ( 'dtsl-media-images-frontend' );

		}

		function dtsl_addorupdate_listing_mediaimages_module($data, $listing_id) {

			extract($data);

			update_post_meta($listing_id, 'dtsl_media_images_ids', $dtsl_media_attachment_ids);
			update_post_meta($listing_id, 'dtsl_media_images_titles', $dtsl_media_attachment_titles);

			if(isset($dtsl_featured_image_id) && $dtsl_featured_image_id != '') {
				set_post_thumbnail($listing_id, $dtsl_featured_image_id);
			}

		}

	}

}

if( !function_exists('dtslMediaImagesModule') ) {
	function dtslMediaImagesModule() {
		return DTStoreLocatorRegisterMediaImagesModule::instance();
	}
}

dtslMediaImagesModule();

?>