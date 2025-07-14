<?php

if (!class_exists ( 'DTDirectoryRegisterMediaVideosModule' )) {

	class DTDirectoryRegisterMediaVideosModule extends DTDirectoryAddon {

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

			$this->dtdr_define_constants( 'DTDR_MVIDEOS_PLUGIN_PATH', DTDR_PLUGIN_PATH . 'modules/media-videos/' );
			$this->dtdr_define_constants( 'DTDR_MVIDEOS_PLUGIN_URL', DTDR_PLUGIN_URL . 'modules/media-videos/' );

			add_filter ( 'dtdr_metabox_tabs', array ( $this, 'dtdr_metabox_tabs_tab' ) );

			add_action ( 'admin_enqueue_scripts', array ( $this, 'dtdr_admin_enqueue_scripts' ), 120 );
			add_action ( 'wp_enqueue_scripts', array ( $this, 'dtdr_enqueue_scripts' ), 130 );

			add_action ( 'dtdr_addorupdate_listing_module', array ( $this, 'dtdr_addorupdate_listing_mediavideos_module' ), 10, 2 );

			require_once DTDR_MVIDEOS_PLUGIN_PATH . 'utils.php';
			require_once DTDR_MVIDEOS_PLUGIN_PATH . 'shortcodes.php';
			require_once DTDR_MVIDEOS_PLUGIN_PATH . 'dashboard.php';

		}

		function dtdr_metabox_tabs_tab($tabs) {

			$tabs['media-videos'] = array (
				'label' => esc_html__('Media - Videos', 'dtdr'),
				'icon' => 'fas fa-camera-retro',
				'path' => DTDR_MVIDEOS_PLUGIN_PATH . 'metabox-tab-listing.php'
			);

			return $tabs;

		}

		function dtdr_admin_enqueue_scripts() {

			$this->dtdr_register_dependent_files();

			$current_screen = get_current_screen();
			if($current_screen->id == 'dtdr_listings') {
				wp_enqueue_style ( 'dtdr-media-videos-fields' );
				wp_enqueue_script ( 'dtdr-media-videos-fields' );
			}

		}

		function dtdr_enqueue_scripts() {

			$this->dtdr_register_dependent_files();
			$this->dtdr_enqueue_registered_files();

			if(is_page_template('tpl-dashboard.php')) {
				wp_enqueue_media();
				wp_enqueue_style ( 'dtdr-media-videos-fields' );
				wp_enqueue_script ( 'dtdr-media-videos-fields' );
			}

		}

		function dtdr_register_dependent_files() {

			wp_register_style ( 'dtdr-media-videos-fields', DTDR_MVIDEOS_PLUGIN_URL . 'assets/media-videos-fields.css', array ( 'dtdr-fields' ) );
			wp_register_style ( 'dtdr-media-videos-frontend', DTDR_MVIDEOS_PLUGIN_URL . 'assets/media-videos-frontend.css', array ( 'fontawesome', 'material-icon', 'dtdr-base', 'dtdr-common', 'swiper' ) );
			wp_register_style ( 'jquery.magnific-popup', DTDR_MVIDEOS_PLUGIN_URL . 'assets/jquery.magnific-popup.css' );

			wp_register_script ( 'dtdr-media-videos-fields', DTDR_MVIDEOS_PLUGIN_URL . 'assets/fields.js', array ('jquery', 'dtdr-fields'), false, true );
			wp_register_script ( 'dtdr-media-videos-frontend', DTDR_MVIDEOS_PLUGIN_URL . 'assets/frontend.js', array ('jquery', 'dtdr-frontend', 'swiper'), false, true );
			wp_register_script ( 'jquery.magnific-popup', DTDR_MVIDEOS_PLUGIN_URL . 'assets/jquery.magnific-popup.min.js', array());
			wp_register_script ( 'dtdr-media-videos-popup', DTDR_MVIDEOS_PLUGIN_URL . 'assets/popup.js', array (), false, true );

		}

		function dtdr_enqueue_registered_files() {

			wp_enqueue_style ( 'dtdr-media-videos-frontend' );
			wp_enqueue_style ( 'jquery.magnific-popup' );

			wp_enqueue_script ( 'dtdr-media-videos-frontend' );
			wp_enqueue_script ( 'jquery.magnific-popup' );
			wp_enqueue_script ( 'dtdr-media-videos-popup' );

		}

		function dtdr_addorupdate_listing_mediavideos_module($data, $listing_id) {

			extract($data);

			update_post_meta($listing_id, 'dtdr_media_videos', $dtdr_media_videos);
			update_post_meta($listing_id, 'dtdr_media_video_quality', $dtdr_media_video_quality);

		}

	}

}

if( !function_exists('dtdrMediaVideosModule') ) {
	function dtdrMediaVideosModule() {
		return DTDirectoryRegisterMediaVideosModule::instance();
	}
}

dtdrMediaVideosModule();

?>