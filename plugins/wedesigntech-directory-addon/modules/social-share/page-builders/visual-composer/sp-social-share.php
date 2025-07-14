<?php
add_action( 'vc_before_init', 'dtdr_sp_social_share_vc_map' );

function dtdr_sp_social_share_vc_map() {

	$listing_singular_label = apply_filters( 'listing_label', 'singular' );

	vc_map( array(
		"name" => esc_html__( 'Social Share', 'dtdr' ),
		"base" => "dtdr_sp_social_share",
		"icon" => "dtdr_sp_social_share",
		"category" => DTDR_PB_MODULE_SINGLEPAGE_TITLE,
		"params" => array(

			// Listing Id
			array(
				'type' => 'textfield',
				'heading' => sprintf( esc_html__('%1$s Id', 'dtdr'), $listing_singular_label ),
				'param_name' => 'listing_id',
				'description' => sprintf( esc_html__('Provide %1$s id for which you have to display favourites, share,... No need to provide ID if it is used in %1$s single page.', 'dtdr'), strtolower($listing_singular_label) ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'admin_label' => true
			),

			// Type
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Type','dtdr'),
				'param_name' => 'type',
				'value' => array(
					esc_html__( 'Type 1', 'dtdr' )  => 'type1',
					esc_html__( 'Type 2', 'dtdr' )  => 'type2'
				),
				'description' => esc_html__('Choose type of social share like to display.', 'dtdr'),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'std' => 'type1',
			),

			// Show Facebook
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show Facebook', 'dtdr'),
				'description' => esc_html__('Choose "True" if you like to show facebook share.', 'dtdr'),
				'param_name' => 'show_facebook',
				'value' => array(
					esc_html__( 'False', 'dtdr' ) => 'false',
					esc_html__( 'True', 'dtdr' ) => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6'
			),

			// Show Delicious
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show Delicious', 'dtdr'),
				'description' => esc_html__('Choose "True" if you like to show delicious share.', 'dtdr'),
				'param_name' => 'show_delicious',
				'value' => array(
					esc_html__( 'False', 'dtdr' ) => 'false',
					esc_html__( 'True', 'dtdr' ) => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6'
			),

			// Show Digg
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show Digg', 'dtdr'),
				'description' => esc_html__('Choose "True" if you like to show digg share.', 'dtdr'),
				'param_name' => 'show_digg',
				'value' => array(
					esc_html__( 'False', 'dtdr' ) => 'false',
					esc_html__( 'True', 'dtdr' ) => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6'
			),

			// Show Stumble Upon
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show Stumble Upon', 'dtdr'),
				'description' => esc_html__('Choose "True" if you like to show stumble upon share.', 'dtdr'),
				'param_name' => 'show_stumbleupon',
				'value' => array(
					esc_html__( 'False', 'dtdr' ) => 'false',
					esc_html__( 'True', 'dtdr' ) => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6'
			),

			// Show Twitter
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show Twitter', 'dtdr'),
				'description' => esc_html__('Choose "True" if you like to show twitter share.', 'dtdr'),
				'param_name' => 'show_twitter',
				'value' => array(
					esc_html__( 'False', 'dtdr' ) => 'false',
					esc_html__( 'True', 'dtdr' ) => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6'
			),

			// Show Google Plus
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show Google Plus', 'dtdr'),
				'description' => esc_html__('Choose "True" if you like to show google plus share.', 'dtdr'),
				'param_name' => 'show_googleplus',
				'value' => array(
					esc_html__( 'False', 'dtdr' ) => 'false',
					esc_html__( 'True', 'dtdr' ) => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6'
			),

			// Show LinkedIn
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show LinkedIn', 'dtdr'),
				'description' => esc_html__('Choose "True" if you like to show linkedin share.', 'dtdr'),
				'param_name' => 'show_linkedin',
				'value' => array(
					esc_html__( 'False', 'dtdr' ) => 'false',
					esc_html__( 'True', 'dtdr' ) => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6'
			),

			// Show Pinterest
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show Pinterest', 'dtdr'),
				'description' => esc_html__('Choose "True" if you like to show pinterest share.', 'dtdr'),
				'param_name' => 'show_pinterest',
				'value' => array(
					esc_html__( 'False', 'dtdr' ) => 'false',
					esc_html__( 'True', 'dtdr' ) => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6'
			),

			// Class
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Class', 'dtdr' ),
				'param_name' => 'class',
				'description' => esc_html__( 'If you wish you can add additional class name here.', 'dtdr' ),
			)

		)
	) );
}
?>