<?php
/*
 * Template Name: Store Locator Listings Single Page Template
 */
?>

<?php get_header('dtsl'); ?>

	<?php
	/**
	* dtsl_before_main_content hook.
	*/
	do_action( 'dtsl_before_main_content' );
	?>

		<?php
		/**
		* dtsl_before_content hook.
		*/
		do_action( 'dtsl_before_content' );
		?>

			<?php
			if( have_posts() ):
				while( have_posts() ):
				the_post();

					the_content();

				endwhile;
			endif;
			?>

		<?php
		/**
		* dtsl_after_content hook.
		*/
		do_action( 'dtsl_after_content' );
		?>

	<?php
	/**
	* dtsl_after_main_content hook.
	*/
	do_action( 'dtsl_after_main_content' );
	?>

<?php get_footer('dtsl'); ?>