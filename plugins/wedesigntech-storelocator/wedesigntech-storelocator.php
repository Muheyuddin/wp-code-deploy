<?php
/*
Plugin Name: WeDesignTech Store Locator
Plugin URI: http://dtstorelocator.wpengine.com/
Description: A simple wordpress plugin designed to implements <strong>Store Locator addon features of Netlink</strong>
Version: 1.0.0
Author: the WeDesignTech team
Author URI: https://wedesignthemes.com/
Text Domain: dtsl
*/

if (! class_exists ( 'DTStoreLocator' )) {

	class DTStoreLocator {

		/**
		 * Instance variable
		 */
		private static $_instance = null;

		/**
		 * Active Modules
		 */
		public $active_modules = array ();

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

		/**
		 * Constructor
		 */
		function __construct() {

			$this->dtsl_setup_constants();
			$this->dtsl_action_hooks();
			$this->dtsl_includes();
			$this->dtsl_load_modules();

			// Theme Support
			$this->dtsl_theme_support_includes();

		}

		/**
		 * Define constant if not already set.
		 */
		public function dtsl_define_constants( $name, $value ) {
			if ( ! defined( $name ) ) {
				define( $name, $value );
			}
		}

		/**
		 * Configure Constants
		 */
		public function dtsl_setup_constants() {

			$this->dtsl_define_constants( 'DTSL_PLUGIN_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
			$this->dtsl_define_constants( 'DTSL_PLUGIN_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );

			$this->dtsl_define_constants( 'DTSL_PLUGIN_NAME', esc_html__('DesignThemes Store Locator Addon', 'dtsl') );
			$this->dtsl_define_constants( 'DTSL_PLUGIN_MODULE_PATH', DTSL_PLUGIN_PATH.'modules' );

			$this->dtsl_define_constants( 'DTSL_PB_MODULE_DEFAULT_TITLE', sprintf( esc_html__('%1$s - Default', 'dtsl'), DTSL_PLUGIN_NAME ) );
			$this->dtsl_define_constants( 'DTSL_PB_MODULE_SINGLEPAGE_TITLE', sprintf( esc_html__('%1$s - Single Page', 'dtsl'), DTSL_PLUGIN_NAME ) );

		}

		/**
		 * Action Hooks
		 */
		public function dtsl_action_hooks() {

			add_action ( 'init', array ( $this, 'dtsl_init' ) );
			add_action ( 'plugins_loaded', array( $this, 'dtsl_plugins_loaded' ) );
			add_filter ( 'theme_page_templates', array ( $this, 'dtsl_add_new_page_template' ) );
			add_filter ( 'template_include', array ( $this, 'dtsl_view_project_template' ) );


			add_action ( 'admin_menu', array ( $this, 'dtsl_configure_admin_menu_first_set' ), 10 );
			add_action ( 'admin_menu', array ( $this, 'dtsl_configure_admin_menu_second_set' ), 30 );
			add_action ( 'parent_file', array ( $this, 'dtsl_change_active_menu' ) );

		}

		/**
		 * On Init
		 */
		function dtsl_init() {

			load_plugin_textdomain ( 'dtsl', false, dirname ( plugin_basename ( __FILE__ ) ) . '/languages/' );

			// Register Dependent Styles & Scripts

				require_once DTSL_PLUGIN_PATH . 'script-and-styles.php';

			// WooCommerce Payment Functionality

				// if ( class_exists( 'WooCommerce' ) ) {
				// 	require_once DTSL_PLUGIN_PATH . 'woocommerce/woocommerce.php';
				// }

		}

		/**
		 * Plugins Load
		 */
		function dtsl_plugins_loaded() {

			// Page Builders

				if( class_exists( 'Vc_Manager' ) || did_action( 'elementor/loaded' ) ) {

					// Scan and Include all available page builders
					if(is_dir(DTSL_PLUGIN_PATH . 'page-builders')) {

						$dtsl_page_builders = scandir(DTSL_PLUGIN_PATH . 'page-builders');
						$dtsl_page_builders = array_diff($dtsl_page_builders, array('..', '.'));

						if( class_exists( 'Vc_Manager' ) && in_array( 'visual-composer', $dtsl_page_builders ) ) {
							require_once  DTSL_PLUGIN_PATH . 'page-builders/visual-composer/register-visual-composer.php';
						}

						if ( did_action( 'elementor/loaded' ) && in_array( 'elementor', $dtsl_page_builders ) ) {
							require_once DTSL_PLUGIN_PATH . 'page-builders/elementor/register-elementor.php';
						}

					}

				} else {
					add_action ('admin_notices', array( $this, 'dtsl_pb_plugin_notice' ) );
					return;
				}

		}

		function dtsl_pb_plugin_notice() {

			echo '<div class="updated notice is-dismissible">';
				echo '<p>';
					echo sprintf(esc_html__('%1$s requires %2$s or %3$s plugin to be installed and activated on your site','dtsl'), '<strong>'.DTSL_PLUGIN_NAME.'</strong>', '<strong><a href="https://codecanyon.net/item/visual-composer-page-builder-for-wordpress/242431" target="_blank">'.esc_html__('Visual Composer', 'dtsl').'</a></strong>', '<strong><a href="https://wordpress.org/plugins/elementor/" target="_blank">'.esc_html__('Elementor Page Builder', 'dtsl').'</a></strong>' );
				echo '</p>';
				echo '<button type="button" class="notice-dismiss">';
					echo '<span class="screen-reader-text">'.esc_html__('Dismiss this notice.','dtsl').'</span>';
				echo '</button>';
			echo '</div>';

		}


		/**
		 * Add Custom Templates to page template array
		 */
		function dtsl_add_new_page_template( $templates ) {

			$templates = array_merge (
				$templates,
				array (
					'tpl-single-listing.php'  => esc_html__('Store Locator Listings Single Page Template', 'dtsl'),
				)
			);

			return $templates;

		}

		/**
		 * Include Custom Templates page from plugin
		 */
		function dtsl_view_project_template( $template ) {

			if( is_singular('page') ) {

				global $post;
				$id = $post->ID;
				$file = get_post_meta( $post->ID, '_wp_page_template', true );

				if( 'tpl-single-listing.php' == $file ) {
					if( ! file_exists( get_stylesheet_directory() . '/tpl-single-listing.php' ) ) {
						$template = DTSL_PLUGIN_PATH . 'templates/tpl-single-listing.php';
					}
				}

			}

			return $template;

		}

		/**
		 * Configure admin menu - First Set
		 */
		function dtsl_configure_admin_menu_first_set() {

			$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );
			$listing_plural_label = apply_filters( 'dt_sl_listing_label', 'plural' );

			$dt_sl_category_title = sprintf( esc_html__('%1$s Category', 'dtsl'), $dt_sl_listing_singular_label );

			add_menu_page( sprintf( esc_html__('Store Locator %1$s', 'dtsl'), $listing_plural_label ), esc_html__('Store Locator','dtsl'), 'edit_posts', 'dtsl', '', 'dashicons-location-alt', 6 );
			add_submenu_page( 'dtsl', $dt_sl_category_title, $dt_sl_category_title, 'edit_posts', 'edit-tags.php?taxonomy=dtsl_listings_category&post_type=dtsl_listings' );


		}

		/**
		 * Configure admin menu - Second Set
		 */
		function dtsl_configure_admin_menu_second_set() {

			$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );
			$dt_sl_amenity_singular_label = apply_filters( 'dt_sl_amenity_label', 'singular' );
			$dt_sl_contracttype_singular_label = apply_filters( 'dt_sl_contracttype_label', 'singular' );

			$dt_sl_category_title = sprintf( esc_html__('%1$s Category', 'dtsl'), $dt_sl_listing_singular_label );
			$dt_sl_amenity_title = sprintf( esc_html__('%1$s %2$s', 'dtsl'), $dt_sl_listing_singular_label, $dt_sl_amenity_singular_label );
			$dt_sl_contracttype_title = sprintf( esc_html__('%1$s %2$s', 'dtsl'), $dt_sl_listing_singular_label, $dt_sl_contracttype_singular_label );

			add_submenu_page( 'dtsl', $dt_sl_contracttype_title, $dt_sl_contracttype_title, 'edit_posts', 'edit-tags.php?taxonomy=dtsl_listings_ctype&post_type=dtsl_listings' );
			add_submenu_page( 'dtsl', $dt_sl_amenity_title, $dt_sl_amenity_title, 'edit_posts', 'edit-tags.php?taxonomy=dtsl_listings_amenity&post_type=dtsl_listings' );

			add_submenu_page( 'dtsl', esc_html__('Settings', 'dtsl'), esc_html__('Settings', 'dtsl'), 'edit_posts', 'dtsl-settings-options', 'dtsl_settings_options' );

		}

		/**
		 * Update admin menu
		 */
		function dtsl_change_active_menu($parent_file) {

			global $submenu_file, $current_screen;
			$taxonomy = $current_screen->taxonomy;
			if ($taxonomy == 'dtsl_listings_category') {
				$submenu_file = 'edit-tags.php?taxonomy=dtsl_listings_category&post_type=dtsl_listings';
				$parent_file = 'dtsl';
			} else if ($taxonomy == 'dtsl_listings_ctype') {
				$submenu_file = 'edit-tags.php?taxonomy=dtsl_listings_ctype&post_type=dtsl_listings';
				$parent_file = 'dtsl';
			} else if ($taxonomy == 'dtsl_listings_amenity') {
				$submenu_file = 'edit-tags.php?taxonomy=dtsl_listings_amenity&post_type=dtsl_listings';
				$parent_file = 'dtsl';
			}
			return $parent_file;

		}

		/**
		 * Action Hooks
		 */
		public function dtsl_includes() {

			// Register Custom Post Types
			require_once DTSL_PLUGIN_PATH . 'custom-post-types/register-post-types.php';

			// Register Shortcodes
			require_once DTSL_PLUGIN_PATH . 'shortcodes/shortcodes-default.php';
			require_once DTSL_PLUGIN_PATH . 'shortcodes/shortcodes-singlepage.php';

			// Util files
			require_once DTSL_PLUGIN_PATH . 'utils/utils-admin.php';
			require_once DTSL_PLUGIN_PATH . 'utils/utils.php';
			require_once DTSL_PLUGIN_PATH . 'utils/utils-comment.php';
			require_once DTSL_PLUGIN_PATH . 'utils/utils-listings.php';
			require_once DTSL_PLUGIN_PATH . 'utils/utils-login-form.php';
			require_once DTSL_PLUGIN_PATH . 'utils/utils-events.php';
			require_once DTSL_PLUGIN_PATH . 'utils/utils-fields.php';

			// Settings
			require_once DTSL_PLUGIN_PATH . 'settings/settings.php';

		}

		/**
		 * Scan & Include Active Modules
		 */
		function dtsl_load_modules() {

			if(is_dir(DTSL_PLUGIN_MODULE_PATH)) {
				$dtsl_modules = scandir(DTSL_PLUGIN_MODULE_PATH);
				$dtsl_modules = array_diff($dtsl_modules, array('..', '.'));
				if(is_array($dtsl_modules) && !empty($dtsl_modules)) {
					rsort($dtsl_modules); // To extend search module class in elementor
					$this->active_modules = $dtsl_modules;
					foreach($dtsl_modules as $dtsl_module) {
						$module_path = DTSL_PLUGIN_MODULE_PATH . '/'.$dtsl_module.'/register-module.php';
						if(file_exists($module_path)) {
							require_once $module_path;
						}
					}
				}
			}

		}

		/**
		 * Theme support files include
		 */
		function dtsl_theme_support_includes() {
			switch ( get_template() ) {
				case 'framework':
					include_once DTSL_PLUGIN_PATH . 'theme-support/class-designthemes.php';
				break;
				case 'elementor-fw':
					include_once DTSL_PLUGIN_PATH . 'theme-support/class-designthemes-elementor-fw.php';
				break;
				case 'meni':
					include_once DTSL_PLUGIN_PATH . 'theme-support/class-designthemes-meni.php';
				break;
				case 'ora':
					include_once DTSL_PLUGIN_PATH . 'theme-support/class-designthemes-ora.php';
				break;
				case 'houzy':
					include_once DTSL_PLUGIN_PATH . 'theme-support/class-designthemes-houzy.php';
				break;
				default:
					include_once DTSL_PLUGIN_PATH . 'theme-support/class-default.php';
				break;
			}
		}

	}

}


if( !function_exists('dtstorelocator_instance') ) {
	function dtstorelocator_instance() {
		return DTStoreLocator::instance();
	}
}

dtstorelocator_instance();


?>