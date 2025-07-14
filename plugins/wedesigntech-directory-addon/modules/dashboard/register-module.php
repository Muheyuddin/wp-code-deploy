<?php

if (!class_exists ( 'DTDirectoryRegisterDashboardModule' )) {

	class DTDirectoryRegisterDashboardModule extends DTDirectoryAddon {

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

			$this->dtdr_define_constants( 'DTDR_DASHBOARD_PLUGIN_PATH', DTDR_PLUGIN_PATH . 'modules/dashboard/' );
			$this->dtdr_define_constants( 'DTDR_DASHBOARD_PLUGIN_URL', DTDR_PLUGIN_URL . 'modules/dashboard/' );

			add_filter ( 'theme_page_templates', array ( $this, 'dtdr_module_add_new_page_template' ) );
			add_filter ( 'template_include', array ( $this, 'dtdr_modules_template_include' ) );
			add_filter ( 'seller_login_redirect_pages', array ( $this, 'dtdr_module_seller_login_redirect_pages' ) );
			add_filter ( 'incharge_login_redirect_pages', array ( $this, 'dtdr_module_incharge_login_redirect_pages' ) );

			add_action ( 'wp_enqueue_scripts', array ( $this, 'dtdr_enqueue_scripts' ), 130 );

			// Dashboard Functionality
			require_once DTDR_DASHBOARD_PLUGIN_PATH . 'utils/home.php';
			require_once DTDR_DASHBOARD_PLUGIN_PATH . 'utils/my-profile.php';
			require_once DTDR_DASHBOARD_PLUGIN_PATH . 'utils/my-listings.php';
			require_once DTDR_DASHBOARD_PLUGIN_PATH . 'utils/add-listings.php';
			require_once DTDR_DASHBOARD_PLUGIN_PATH . 'utils/inbox.php';
			require_once DTDR_DASHBOARD_PLUGIN_PATH . 'utils/reviews.php';
			require_once DTDR_DASHBOARD_PLUGIN_PATH . 'utils/favourite-listings.php';
			require_once DTDR_DASHBOARD_PLUGIN_PATH . 'utils/buyer-listings.php';
			require_once DTDR_DASHBOARD_PLUGIN_PATH . 'utils/contact-admin.php';

		}

		function dtdr_module_add_new_page_template( $templates ) {

			$templates = array_merge (
				$templates,
				array (
					'tpl-dashboard.php' => esc_html__('Directory Dashboard Template', 'dtdr')
				)
			);

			return $templates;

		}

		function dtdr_modules_template_include( $template ) {

			if( is_singular('page') ) {

				global $post;
				$id = $post->ID;
				$file = get_post_meta( $post->ID, '_wp_page_template', true );

				if( 'tpl-dashboard.php' == $file ) {
					if( ! file_exists( get_stylesheet_directory() . '/tpl-dashboard.php' ) ) {
						$template = DTDR_DASHBOARD_PLUGIN_PATH . 'tpl-dashboard.php';
					}
				}

			}

			return $template;

		}

		function dtdr_module_seller_login_redirect_pages($redirect_pages) {
			$redirect_pages['dashboard'] = esc_html__('Dashboard', 'dtdr');
			return $redirect_pages;
		}

		function dtdr_module_incharge_login_redirect_pages($redirect_pages) {
			$redirect_pages['dashboard'] = esc_html__('Dashboard', 'dtdr');
			return $redirect_pages;
		}

		function dtdr_enqueue_scripts() {

			$this->dtdr_register_dependent_files();

			if(is_page_template('tpl-dashboard.php')) {
				wp_enqueue_style ( 'dtdr-dashboard-frontend' );

				wp_enqueue_script ( 'dtdr-dashboard-frontend' );
			}

		}

		function dtdr_register_dependent_files() {

			wp_register_style ( 'dtdr-dashboard-frontend', DTDR_DASHBOARD_PLUGIN_URL . 'assets/dashboard-frontend.css', array ( 'chosen', 'dtdr-base', 'dtdr-common', 'dtdr-fields', 'fontawesome', 'material-icon' ) );

			wp_register_script ( 'dtdr-dashboard-frontend', DTDR_DASHBOARD_PLUGIN_URL . 'assets/frontend.js', array ( 'jquery', 'chosen', 'dtdr-fields', 'dtdr-frontend' ), false, true );

		}

	}

}

if( !function_exists('dtdrDashboardModule') ) {
	function dtdrDashboardModule() {
		return DTDirectoryRegisterDashboardModule::instance();
	}
}

dtdrDashboardModule();

?>