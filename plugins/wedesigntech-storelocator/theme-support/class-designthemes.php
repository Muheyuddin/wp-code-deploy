<?php

if ( ! class_exists( 'DTStoreLocatorDesignThemes' ) ) {

	class DTStoreLocatorDesignThemes {

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

			add_action( 'dtsl_before_content',  array ( $this, 'dtsl_dt_before_content' ), 10 );
			add_action( 'dtsl_after_content',  array ( $this, 'dtsl_dt_after_content' ), 10 );

			add_filter( '_theme_name_breadcrumb_title', array ( $this, 'dtsl_breadcrumb_title_module' ), 10, 1 );
			add_filter( '_theme_name_breadcrumbs', array ( $this, 'dtsl_breadcrumbs_module' ), 10, 1 );

		}

		function dtsl_dt_before_content() {

			if (is_singular( 'dtsl_listings' ) || is_singular( 'dtsl_packages' ) || is_post_type_archive('dtsl_listings') || is_tax('dtsl_listings_category') || is_tax('dtsl_listings_city') || is_tax('dtsl_listings_neighborhood') || is_tax('dtsl_listings_countystate') || is_tax('dtsl_listings_ctype') || is_tax('dtsl_listings_amenity') || is_post_type_archive('dtsl_packages') || is_author() || is_page_template( 'tpl-single-listing.php' ) || is_page_template( 'tpl-users.php' ) || is_page_template( 'tpl-single-seller.php' ) || is_page_template( 'tpl-single-incharge.php' )) {

				echo '<div id="main">';
						echo '<div class="dtsl-container">';
							echo '<section id="primary" class="content-full-width">';

			}

			if (is_page_template( 'tpl-dashboard.php' )) {

				echo '<div id="main">';
						echo '<div class="dtsl-dashboard-container">';
							echo '<section id="primary" class="content-full-width">';

			}

		}

		function dtsl_dt_after_content() {

			if (is_singular( 'dtsl_listings' ) || is_singular( 'dtsl_packages' ) || is_post_type_archive('dtsl_listings') || is_tax('dtsl_listings_category') || is_tax('dtsl_listings_city') || is_tax('dtsl_listings_neighborhood') || is_tax('dtsl_listings_countystate') || is_tax('dtsl_listings_ctype') || is_tax('dtsl_listings_amenity') || is_post_type_archive('dtsl_packages') || is_author() || is_page_template( 'tpl-single-listing.php' ) || is_page_template( 'tpl-dashboard.php' ) || is_page_template( 'tpl-users.php' ) || is_page_template( 'tpl-single-seller.php' ) || is_page_template( 'tpl-single-incharge.php' )) {

						echo '</section>';
					echo '</div>';
				echo '</div>';

		    }

		}

		function dtsl_breadcrumb_title_module( $title ) {

			if( is_author() ) {
				$author_id = get_queried_object_id();
				$title = '<h1>'.esc_html__('Author:', 'dtsl').' '.get_the_author_meta('display_name', $author_id).'</h1>';
			}

			return $title;

		}

		function dtsl_breadcrumbs_module( $breadcrumbs ) {


			if( is_author() ) {
				$breadcrumbs = array ();
			}

			return $breadcrumbs;

		}


	}

	DTStoreLocatorDesignThemes::instance();

}

?>