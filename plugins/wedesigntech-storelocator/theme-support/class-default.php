<?php

if ( ! class_exists( 'DTStoreLocatorDefault' ) ) {

	class DTStoreLocatorDefault {

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

			add_action( 'dtsl_before_content', array( $this, 'dtsl_df_before_content' ), 10 );
			add_action( 'dtsl_after_content', array( $this, 'dtsl_df_after_content' ), 10 );

		}

		function dtsl_df_before_content() {

			if (is_singular( 'dtsl_listings' ) || is_singular( 'dtsl_packages' ) || is_post_type_archive('dtsl_listings') || is_tax('dtsl_listings_category') || is_tax('dtsl_listings_city') || is_tax('dtsl_listings_neighborhood') || is_tax('dtsl_listings_countystate') || is_tax('dtsl_listings_ctype') || is_tax('dtsl_listings_amenity') || is_post_type_archive('dtsl_packages') || is_author() || is_page_template( 'tpl-single-listing.php' ) || is_page_template( 'tpl-single-incharge.php' ) || is_page_template( 'tpl-single-seller.php' )) {

				echo '<div id="main">';
					echo '<div class="dtsl-container">';

			}

			if(is_page_template( 'tpl-dashboard.php' )) {

				echo '<div id="main">';
					echo '<div class="dtsl-dashboard-container">';

			}

			if(!is_author()) {
				global $post;
				echo '<article id="post-'.$post->ID.'" class="'.implode(' ', get_post_class()).'">';
			}

		}

		function dtsl_df_after_content() {

			if(!is_author()) {
				echo '</article>';
			}

			if (is_singular( 'dtsl_listings' ) || is_singular( 'dtsl_packages' ) || is_post_type_archive('dtsl_listings') || is_tax('dtsl_listings_category') || is_tax('dtsl_listings_city') || is_tax('dtsl_listings_neighborhood') || is_tax('dtsl_listings_countystate') || is_tax('dtsl_listings_ctype') || is_tax('dtsl_listings_amenity') || is_post_type_archive('dtsl_packages') || is_author() || is_page_template( 'tpl-single-listing.php' ) || is_page_template( 'tpl-single-incharge.php' ) || is_page_template( 'tpl-single-seller.php' )) {

					echo '</div>';
				echo '</div>';

			}

		}

	}

	DTStoreLocatorDefault::instance();

}

?>