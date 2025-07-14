<?php

if ( ! class_exists( 'DTDirectoryDesignThemes' ) ) {

	class DTDirectoryDesignThemes {

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

			add_action( 'dtdr_before_content',  array ( $this, 'dtdr_dt_before_content' ), 10 );
			add_action( 'dtdr_after_content',  array ( $this, 'dtdr_dt_after_content' ), 10 );

			add_filter( '_theme_name_breadcrumb_title', array ( $this, 'dtdr_breadcrumb_title_module' ), 10, 1 );
			add_filter( '_theme_name_breadcrumbs', array ( $this, 'dtdr_breadcrumbs_module' ), 10, 1 );

		}

		function dtdr_dt_before_content() {

			if (is_singular( 'dtdr_listings' ) || is_singular( 'dtdr_packages' ) || is_post_type_archive('dtdr_listings') || is_tax('dtdr_listings_category') || is_tax('dtdr_listings_city') || is_tax('dtdr_listings_neighborhood') || is_tax('dtdr_listings_countystate') || is_tax('dtdr_listings_ctype') || is_tax('dtdr_listings_amenity') || is_post_type_archive('dtdr_packages') || is_author() || is_page_template( 'tpl-single-listing.php' ) || is_page_template( 'tpl-users.php' ) || is_page_template( 'tpl-single-seller.php' ) || is_page_template( 'tpl-single-incharge.php' )) {

				echo '<div id="main">';
						echo '<div class="container">';
							echo '<section id="primary" class="content-full-width">';

			}

			if (is_page_template( 'tpl-dashboard.php' )) {

				echo '<div id="main">';
						echo '<div class="dtdr-dashboard-container">';
							echo '<section id="primary" class="content-full-width">';

			}

		}

		function dtdr_dt_after_content() {

			if (is_singular( 'dtdr_listings' ) || is_singular( 'dtdr_packages' ) || is_post_type_archive('dtdr_listings') || is_tax('dtdr_listings_category') || is_tax('dtdr_listings_city') || is_tax('dtdr_listings_neighborhood') || is_tax('dtdr_listings_countystate') || is_tax('dtdr_listings_ctype') || is_tax('dtdr_listings_amenity') || is_post_type_archive('dtdr_packages') || is_author() || is_page_template( 'tpl-single-listing.php' ) || is_page_template( 'tpl-dashboard.php' ) || is_page_template( 'tpl-users.php' ) || is_page_template( 'tpl-single-seller.php' ) || is_page_template( 'tpl-single-incharge.php' )) {

						echo '</section>';
					echo '</div>';
				echo '</div>';

		    }

		}

		function dtdr_breadcrumb_title_module( $title ) {

			if( is_author() ) {
				$author_id = get_queried_object_id();
				$title = '<h1>'.esc_html__('Author:', 'dtdr').' '.get_the_author_meta('display_name', $author_id).'</h1>';
			}

			return $title;

		}

		function dtdr_breadcrumbs_module( $breadcrumbs ) {


			if( is_author() ) {
				$breadcrumbs = array ();
			}

			return $breadcrumbs;

		}


	}

	DTDirectoryDesignThemes::instance();

}

?>