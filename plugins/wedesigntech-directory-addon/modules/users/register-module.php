<?php

if (!class_exists ( 'DTDirectoryRegisterUsersModule' )) {

	class DTDirectoryRegisterUsersModule extends DTDirectoryAddon {

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

			$this->dtdr_define_constants( 'DTDR_USERS_PLUGIN_PATH', DTDR_PLUGIN_PATH . 'modules/users/' );
			$this->dtdr_define_constants( 'DTDR_USERS_PLUGIN_URL', DTDR_PLUGIN_URL . 'modules/users/' );

			add_filter ( 'theme_page_templates', array ( $this, 'dtdr_add_new_page_template' ) );
			add_filter ( 'template_include', array ( $this, 'dtdr_modules_template_include' ) );
			add_filter ( 'dtdr_settings', array ( $this, 'dtdr_add_settings' ) );

			add_action ( 'admin_enqueue_scripts', array ( $this, 'dtdr_admin_enqueue_scripts' ), 120 );
			add_action ( 'wp_enqueue_scripts', array ( $this, 'dtdr_enqueue_scripts' ), 130 );

			require_once DTDR_USERS_PLUGIN_PATH . 'shortcodes.php';
			require_once DTDR_USERS_PLUGIN_PATH . 'dashboard.php';
			require_once DTDR_USERS_PLUGIN_PATH . 'dashboard/my-incharges.php';
			require_once DTDR_USERS_PLUGIN_PATH . 'dashboard/add-incharges.php';
			require_once DTDR_USERS_PLUGIN_PATH . 'utils.php';
			require_once DTDR_USERS_PLUGIN_PATH . 'utils-login.php';

		}

		/**
		 * Add Custom Templates to page template array
		 */
		function dtdr_add_new_page_template( $templates ) {

			$templates = array_merge (
				$templates,
				array (
					'tpl-single-seller.php'   => esc_html__('Directory Seller Single Page Template', 'dtdr'),
					'tpl-single-incharge.php' => esc_html__('Directory Incharge Single Page Template', 'dtdr')
				)
			);

			return $templates;

		}

		function dtdr_modules_template_include( $template ) {

			if(is_author()) {

				global $wp_query;
				$curauth = $wp_query->get_queried_object();

				$user_id = $curauth->ID;

				$user_meta	= get_userdata($user_id);
				$user_roles	= $user_meta->roles;

				if(in_array('seller', $user_roles) || in_array('incharge', $user_roles)) {
					set_query_var('dtdr_asp_user_id', $user_id);
					set_query_var('dtdr_asp_user_roles', $user_roles);
					$template = DTDR_USERS_PLUGIN_PATH . 'templates/tpl-users.php';
				}

			}

			if( is_singular('page') ) {

				global $post;
				$id = $post->ID;
				$file = get_post_meta( $post->ID, '_wp_page_template', true );

				if( 'tpl-single-seller.php' == $file ) {
					if( ! file_exists( get_stylesheet_directory() . '/tpl-single-seller.php' ) ) {
						$template = DTDR_USERS_PLUGIN_PATH . 'templates/tpl-single-seller.php';
					}
				}

				if( 'tpl-single-incharge.php' == $file ) {
					if( ! file_exists( get_stylesheet_directory() . '/tpl-single-incharge.php' ) ) {
						$template = DTDR_USERS_PLUGIN_PATH . 'templates/tpl-single-incharge.php';
					}
				}

			}

			return $template;

		}

		function dtdr_add_settings($tabs) {

			$tabs['login'] = array (
				'label' => esc_html__('Login', 'dtdr'),
				'path'  => DTDR_USERS_PLUGIN_PATH . 'settings.php'
			);

			return $tabs;

		}

		function dtdr_admin_enqueue_scripts() {

			$this->dtdr_register_dependent_files();

			$current_screen = get_current_screen();
			if($current_screen->id == 'profile' || $current_screen->id == 'user-edit') {

				// CSS

				wp_enqueue_style ( 'dtdr-users-backend' );


				// JS

				wp_enqueue_script ( 'dtdr-fields' );

				wp_enqueue_script ( 'dtdr-common' );
				wp_enqueue_script ( 'dtdr-backend' );

			}

		}

		function dtdr_enqueue_scripts() {

			$this->dtdr_register_dependent_files();
			$this->dtdr_enqueue_registered_files();

			if(is_page_template('tpl-dashboard.php')) {
				wp_enqueue_style ( 'dtdr-users-dashboard' );
			}

		}

		function dtdr_register_dependent_files() {

			wp_register_style ( 'dtdr-users-dashboard', DTDR_USERS_PLUGIN_URL . 'assets/users-dashboard.css', array ( 'chosen', 'dtdr-base', 'dtdr-common', 'dtdr-fields', 'fontawesome', 'material-icon' ) );
			wp_register_style ( 'dtdr-users-backend', DTDR_USERS_PLUGIN_URL . 'assets/users-backend.css', array ( 'fontawesome', 'material-icon', 'chosen', 'dtdr-fields', 'dtdr-backend', 'dtdr-common' ) );
			wp_register_style ( 'dtdr-users-frontend', DTDR_USERS_PLUGIN_URL . 'assets/users-frontend.css', array ( 'fontawesome', 'material-icon', 'dtdr-base', 'dtdr-common' ) );

			wp_register_script ( 'dtdr-users-search', DTDR_USERS_PLUGIN_URL . 'assets/search.js', array ('jquery', 'dtdr-search-frontend'), false, true );
			wp_register_script ( 'dtdr-users-frontend', DTDR_USERS_PLUGIN_URL . 'assets/frontend.js', array ('jquery', 'dtdr-modules-singlepage'), false, true );

		}

		function dtdr_enqueue_registered_files() {

			wp_enqueue_style ( 'dtdr-users-frontend' );

			wp_enqueue_script ( 'dtdr-users-search' );
			wp_enqueue_script ( 'dtdr-users-frontend' );

		}

		function dtdr_addorupdate_listing_users_module($data, $listing_id) {


		}

	}

}

if( !function_exists('dtdrUsersModule') ) {
	function dtdrUsersModule() {
		return DTDirectoryRegisterUsersModule::instance();
	}
}

dtdrUsersModule();

?>