<?php

global $wp_query;
$curauth = $wp_query->get_queried_object();

$user_id = $curauth->ID;

$dtsl_user_status = get_user_meta( $user_id, 'dtsl_user_status', true );
if($dtsl_user_status != 'active') {

    wp_redirect(home_url());
    exit;

}

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

			$user_meta	= get_userdata($user_id);
			$user_roles	= $user_meta->roles;

			echo '<div class="dtsl-author-details-container">';
				if(in_array('seller', $user_roles)) {
					echo do_shortcode('[dtsl_sellers type="" columns="" include="'.esc_attr($user_id).'" /]');
				} else if(in_array('incharge', $user_roles)) {
					echo do_shortcode('[dtsl_incharges type="" columns="" include="'.esc_attr($user_id).'" /]');
				}
			echo '</div>';


			$seller_singular_label = apply_filters( 'dt_sl_seller_label', 'singular' );
			$incharge_singular_label = apply_filters( 'dt_sl_incharge_label', 'singular' );
			$listing_plural_label = apply_filters( 'dt_sl_listing_label', 'plural' );

			if(in_array('seller', $user_roles)) {

				echo '<div class="dtsl-author-listings-container">';

					echo '<h4>'.sprintf( esc_html__('%1$s %2$s', 'dtsl'), $seller_singular_label, $listing_plural_label ).'</h4>';

					echo do_shortcode('[dtsl_listings_listing post_per_page="6" columns="3" apply_isotope="true" seller_ids="'.esc_attr($user_id).'" /]');

				echo '</div>';

			} else if(in_array('incharge', $user_roles)) {

				echo '<div class="dtsl-author-listings-container">';

					echo '<h4>'.sprintf( esc_html__('%1$s %2$s', 'dtsl'), $incharge_singular_label, $listing_plural_label ).'</h4>';

					echo do_shortcode('[dtsl_listings_listing post_per_page="6" columns="3" apply_isotope="true" incharge_ids="'.esc_attr($user_id).'" /]');

				echo '</div>';

			}

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