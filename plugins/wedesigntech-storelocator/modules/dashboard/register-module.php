<?php

if (!class_exists ( 'DTStoreLocatorRegisterDashboardModule' )) {

	class DTStoreLocatorRegisterDashboardModule extends DTStoreLocator {

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

			$this->dtsl_define_constants( 'DTSL_DASHBOARD_PLUGIN_PATH', DTSL_PLUGIN_PATH . 'modules/dashboard/' );
			$this->dtsl_define_constants( 'DTSL_DASHBOARD_PLUGIN_URL', DTSL_PLUGIN_URL . 'modules/dashboard/' );

			add_filter ( 'theme_page_templates', array ( $this, 'dtsl_module_add_new_page_template' ) );
			add_filter ( 'template_include', array ( $this, 'dtsl_modules_template_include' ) );
			add_filter ( 'seller_login_redirect_pages', array ( $this, 'dtsl_module_seller_login_redirect_pages' ) );
			add_filter ( 'incharge_login_redirect_pages', array ( $this, 'dtsl_module_incharge_login_redirect_pages' ) );

			add_action ( 'wp_enqueue_scripts', array ( $this, 'dtsl_enqueue_scripts' ), 130 );

			// Dashboard Functionality
			require_once DTSL_DASHBOARD_PLUGIN_PATH . 'utils/home.php';
			require_once DTSL_DASHBOARD_PLUGIN_PATH . 'utils/my-profile.php';
			require_once DTSL_DASHBOARD_PLUGIN_PATH . 'utils/my-listings.php';
			require_once DTSL_DASHBOARD_PLUGIN_PATH . 'utils/add-listings.php';
			require_once DTSL_DASHBOARD_PLUGIN_PATH . 'utils/inbox.php';
			require_once DTSL_DASHBOARD_PLUGIN_PATH . 'utils/reviews.php';
			require_once DTSL_DASHBOARD_PLUGIN_PATH . 'utils/favourite-listings.php';
			require_once DTSL_DASHBOARD_PLUGIN_PATH . 'utils/buyer-listings.php';
			require_once DTSL_DASHBOARD_PLUGIN_PATH . 'utils/contact-admin.php';

		}

		function dtsl_module_add_new_page_template( $templates ) {

			$templates = array_merge (
				$templates,
				array (
					'tpl-dashboard.php' => esc_html__('Store Locator Dashboard Template', 'dtsl')
				)
			);

			return $templates;

		}

		function dtsl_modules_template_include( $template ) {

			if( is_singular('page') ) {

				global $post;
				$id = $post->ID;
				$file = get_post_meta( $post->ID, '_wp_page_template', true );

				if( 'tpl-dashboard.php' == $file ) {
					if( ! file_exists( get_stylesheet_directory() . '/tpl-dashboard.php' ) ) {
						$template = DTSL_DASHBOARD_PLUGIN_PATH . 'tpl-dashboard.php';
					}
				}

			}

			return $template;

		}

		function dtsl_module_seller_login_redirect_pages($redirect_pages) {
			$redirect_pages['dashboard'] = esc_html__('Dashboard', 'dtsl');
			return $redirect_pages;
		}

		function dtsl_module_incharge_login_redirect_pages($redirect_pages) {
			$redirect_pages['dashboard'] = esc_html__('Dashboard', 'dtsl');
			return $redirect_pages;
		}

		function dtsl_enqueue_scripts() {

			$this->dtsl_register_dependent_files();

			if(is_page_template('tpl-dashboard.php')) {
				wp_enqueue_style ( 'dtsl-dashboard-frontend' );

				wp_enqueue_script ( 'dtsl-dashboard-frontend' );
			}

		}

		function dtsl_register_dependent_files() {

			wp_register_style ( 'dtsl-dashboard-frontend', DTSL_DASHBOARD_PLUGIN_URL . 'assets/dashboard-frontend.css', array ( 'chosen', 'dtsl-base', 'dtsl-common', 'dtsl-fields', 'fontawesome', 'material-icon' ) );

			wp_register_script ( 'dtsl-dashboard-frontend', DTSL_DASHBOARD_PLUGIN_URL . 'assets/frontend.js', array ( 'jquery', 'chosen', 'dtsl-fields', 'dtsl-frontend' ), false, true );

		}

	}

}

if( !function_exists('dtslDashboardModule') ) {
	function dtslDashboardModule() {
		return DTStoreLocatorRegisterDashboardModule::instance();
	}
}

dtslDashboardModule();

?>