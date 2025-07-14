<?php get_header('dtdr'); ?>

	<?php
	/**
	* dtdr_before_main_content hook.
	*/
	do_action( 'dtdr_before_main_content' );
	?>

		<?php
		/**
		* dtdr_before_content hook.
		*/
		do_action( 'dtdr_before_content' );
		?>


			<?php
			if( have_posts() ):
				while( have_posts() ):
					the_post();

					$package_id = get_the_ID();
					$package_title = get_the_title();
					$package_permalink = get_permalink();

			        $package_type = get_post_meta($package_id, 'dtdr_package_type', true);
			        $package_type = ($package_type != '') ? $package_type : 'buyer';

				    $listing_plural_label = apply_filters( 'listing_label', 'plural' );
				    $incharge_plural_label = apply_filters( 'incharge_label', 'plural' );
					?>

					<?php
					if(has_post_thumbnail($package_id)) {
						echo get_the_post_thumbnail($package_id, 'full');
					}

					echo '<div class="dtdr-payment-details">'.dtdr_get_package_pricing_details($package_id, $package_type).'</div>';
					?>

					<div class="dtdr-packagelist-description">
						<?php the_content(); ?>
					</div>

					<div class="dtdr-packagelist-items">

						<h3><?php echo esc_html__('Package Inclusion', 'dtdr'); ?></h3>

						<?php
						$dtdr_numberof_listings          = get_post_meta($package_id, 'dtdr_numberof_listings', true);
						$dtdr_numberof_featured_listings = get_post_meta($package_id, 'dtdr_numberof_featured_listings', true);
						$dtdr_numberof_incharges         = get_post_meta($package_id, 'dtdr_numberof_incharges', true);
						$dtdr_numberof_images            = get_post_meta($package_id, 'dtdr_numberof_images', true);

						$dtdr_additional_features = get_post_meta($package_id, 'dtdr_additional_features', true);
						$dtdr_additional_features = explode("\n", $dtdr_additional_features);
						$dtdr_additional_features = implode("</li><li>", $dtdr_additional_features);

						echo '<ul class="dtdr-packagelist-features">';

							if($dtdr_numberof_listings == '-1') {
								echo '<li>'.sprintf( esc_html__('Unlimited %1$s', 'dtdr'), $listing_plural_label ).'</li>';
							} else if($dtdr_numberof_listings != '') {
								echo '<li>'.$dtdr_numberof_listings.' '.$listing_plural_label.'</li>';
							}

							if($package_type == 'seller') {

								if($dtdr_numberof_featured_listings == '-1') {
									echo '<li>'.sprintf( esc_html__('Unlimited Featured %1$s', 'dtdr'), $listing_plural_label ).'</li>';
								} else if($dtdr_numberof_featured_listings != '') {
									echo '<li>'.sprintf( esc_html__('%1$s Featured %2$s', 'dtdr'), $dtdr_numberof_featured_listings, $listing_plural_label ).'</li>';
								}

								if($dtdr_numberof_incharges == '-1') {
									echo '<li>'.sprintf( esc_html__('Unlimited %1$s', 'dtdr'), $incharge_plural_label ).'</li>';
								} else if($dtdr_numberof_incharges != '') {
									echo '<li>'.sprintf( esc_html__('%1$s %2$s', 'dtdr'), $dtdr_numberof_incharges, $incharge_plural_label ).'</li>';
								}

								if($dtdr_numberof_images == '-1') {
									echo '<li>'.esc_html__('Unlimited Images', 'dtdr').'</li>';
								} else if($dtdr_numberof_images != '') {
									echo '<li>'.sprintf( esc_html__('%1$s Images', 'dtdr'), $dtdr_numberof_images ).'</li>';
								}

							}

							if($dtdr_additional_features != '') {
								echo '<li>'.$dtdr_additional_features.'</li>';
							}

						echo '</ul>';
						?>

					</div>

					<?php

				endwhile;
			endif;
			?>

		<?php
		/**
		* dtdr_after_content hook.
		*/
		do_action( 'dtdr_after_content' );
		?>

	<?php
	/**
	* dtdr_after_main_content hook.
	*/
	do_action( 'dtdr_after_main_content' );
	?>

<?php get_footer('dtdr'); ?>