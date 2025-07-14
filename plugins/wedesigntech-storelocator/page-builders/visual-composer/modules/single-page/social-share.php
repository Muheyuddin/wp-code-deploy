<?php
add_action( 'vc_before_init', 'dtsl_sp_social_share_vc_map' );

function dtsl_sp_social_share_vc_map() {

	$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );

	vc_map( array(
		"name" => esc_html__( 'Social Share', 'dtsl' ),
		"base" => "dtsl_sp_social_share",
		"icon" => "dtsl_sp_social_share",
		"category" => DTSL_PB_MODULE_SINGLEPAGE_TITLE,
		"params" => array(

			// Listing Id
			array(
				'type' => 'textfield',
				'heading' => sprintf( esc_html__('%1$s Id', 'dtsl'), $dt_sl_listing_singular_label ),
				'param_name' => 'listing_id',
				'description' => sprintf( esc_html__('Provide %1$s id for which you have to display favourites, share,... No need to provide ID if it is used in %1$s single page.', 'dtsl'), strtolower($dt_sl_listing_singular_label) ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'admin_label' => true
			),

			// Show Facebook
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show Facebook', 'dtsl'),
				'description' => esc_html__('Choose "True" if you like to show facebook share.', 'dtsl'),
				'param_name' => 'show_facebook',
				'value' => array(
					esc_html__( 'False', 'dtsl' ) => 'false',
					esc_html__( 'True', 'dtsl' ) => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6'
			),

			// Show Delicious
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show Delicious', 'dtsl'),
				'description' => esc_html__('Choose "True" if you like to show delicious share.', 'dtsl'),
				'param_name' => 'show_delicious',
				'value' => array(
					esc_html__( 'False', 'dtsl' ) => 'false',
					esc_html__( 'True', 'dtsl' ) => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6'
			),

			// Show Digg
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show Digg', 'dtsl'),
				'description' => esc_html__('Choose "True" if you like to show digg share.', 'dtsl'),
				'param_name' => 'show_digg',
				'value' => array(
					esc_html__( 'False', 'dtsl' ) => 'false',
					esc_html__( 'True', 'dtsl' ) => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6'
			),

			// Show Stumble Upon
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show Stumble Upon', 'dtsl'),
				'description' => esc_html__('Choose "True" if you like to show stumble upon share.', 'dtsl'),
				'param_name' => 'show_stumbleupon',
				'value' => array(
					esc_html__( 'False', 'dtsl' ) => 'false',
					esc_html__( 'True', 'dtsl' ) => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6'
			),

			// Show Twitter
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show Twitter', 'dtsl'),
				'description' => esc_html__('Choose "True" if you like to show twitter share.', 'dtsl'),
				'param_name' => 'show_twitter',
				'value' => array(
					esc_html__( 'False', 'dtsl' ) => 'false',
					esc_html__( 'True', 'dtsl' ) => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6'
			),

			// Show Google Plus
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show Google Plus', 'dtsl'),
				'description' => esc_html__('Choose "True" if you like to show google plus share.', 'dtsl'),
				'param_name' => 'show_googleplus',
				'value' => array(
					esc_html__( 'False', 'dtsl' ) => 'false',
					esc_html__( 'True', 'dtsl' ) => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6'
			),

			// Show LinkedIn
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show LinkedIn', 'dtsl'),
				'description' => esc_html__('Choose "True" if you like to show linkedin share.', 'dtsl'),
				'param_name' => 'show_linkedin',
				'value' => array(
					esc_html__( 'False', 'dtsl' ) => 'false',
					esc_html__( 'True', 'dtsl' ) => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6'
			),

			// Show Pinterest
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show Pinterest', 'dtsl'),
				'description' => esc_html__('Choose "True" if you like to show pinterest share.', 'dtsl'),
				'param_name' => 'show_pinterest',
				'value' => array(
					esc_html__( 'False', 'dtsl' ) => 'false',
					esc_html__( 'True', 'dtsl' ) => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6'
			),

			// Show Whatsapp
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show Whatsapp', 'dtsl'),
				'description' => esc_html__('Choose "True" if you like to show whatsapp share.', 'dtsl'),
				'param_name' => 'show_whatsapp',
				'value' => array(
					esc_html__( 'False', 'dtsl' ) => 'false',
					esc_html__( 'True', 'dtsl' ) => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6'
			),

			// Class
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Class', 'dtsl' ),
				'param_name' => 'class',
				'description' => esc_html__( 'If you wish you can add additional class name here.', 'dtsl' ),
			)

		)
	) );
}
?>