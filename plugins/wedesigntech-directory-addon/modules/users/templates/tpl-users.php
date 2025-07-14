<?php

global $wp_query;
$curauth = $wp_query->get_queried_object();

$user_id = $curauth->ID;

$dtdr_user_status = get_user_meta( $user_id, 'dtdr_user_status', true );
if($dtdr_user_status != 'active') {

    wp_redirect(home_url());
    exit;

}

?>


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

			$user_single_page_args = array (
										'post_type'        => 'page',
										'meta_key'         => '_wp_page_template',
										'fields'           => 'ids',
										'suppress_filters' => 0
									);

			$dtdr_asp_user_roles = get_query_var('dtdr_asp_user_roles');
			if(in_array('seller', $dtdr_asp_user_roles)) {
				$user_single_page_args['meta_value'] = 'tpl-single-seller.php';
			} else if(in_array('incharge', $dtdr_asp_user_roles)) {
				$user_single_page_args['meta_value'] = 'tpl-single-incharge.php';
			}

			$user_single_pages = get_posts($user_single_page_args);
			if ( is_array( $user_single_pages ) && count( $user_single_pages ) > 0 ) {
				$user_single_page_id = $user_single_pages[0];

				if(class_exists( '\Elementor\Plugin' ) && \Elementor\Plugin::$instance->db->is_built_with_elementor($user_single_page_id)) {

					echo \Elementor\Plugin::$instance->frontend->get_builder_content( $user_single_page_id );

				} else {

					$single_tpl_content = get_post_field('post_content', $user_single_page_id);
					echo do_shortcode($single_tpl_content);

				}

			}

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