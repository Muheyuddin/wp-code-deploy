<?php
add_action( 'vc_before_init', 'dtsl_yelp_places_vc_map' );

function dtsl_yelp_places_vc_map() {

	$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );

	vc_map( array(
		"name" => esc_html__( 'Yelp Places', 'dtsl' ),
		"base" => "dtsl_yelp_places",
		"icon" => "dtsl_yelp_places",
		"category" => DTSL_PB_MODULE_DEFAULT_TITLE,
		"params" => array(

			// Categories
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Categories', 'dtsl' ),
				'param_name' => 'categories',
				'description' => sprintf( esc_html__('%1$s 1) Please specify categories you like to show. %2$s %1$s 2) Refer https://www.yelp.com/developers/documentation/v3/business_search for details. %2$s', 'dtsl'), '<p>', '</p>' ),
				'edit_field_class' => 'vc_column vc_col-sm-6'
			),

			// Term
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Term', 'dtsl' ),
				'param_name' => 'term',
				'description' => sprintf( esc_html__('%1$s 1) Please specify term you like to show. %2$s %1$s 2) Refer https://www.yelp.com/developers/documentation/v3/business_search for details. %2$s', 'dtsl'), '<p>', '</p>' ),
				'edit_field_class' => 'vc_column vc_col-sm-6'
			),

			// Location Type
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Location Type','dtsl'),
				'param_name' => 'location_type',
				'value' => array(
					esc_html__( 'Location', 'dtsl' ) => 'location',
					esc_html__( 'Latitude & Longitude', 'dtsl' )  => 'lat_n_long'
				),
				'description' => esc_html__('Choose whether you like to show Location or Latitude & Longitude', 'dtsl'),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'std' => 'location'
			),

			// Location
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Location', 'dtsl' ),
				'param_name' => 'location',
				'description' => esc_html__( 'Please specify location to display.', 'dtsl' ),
				'edit_field_class' => 'vc_column vc_col-sm-6'
			),

			// Latitude
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Latitude', 'dtsl' ),
				'param_name' => 'latitude',
				'description' => esc_html__( 'Please specify latitude of the location to display.', 'dtsl' ),
				'edit_field_class' => 'vc_column vc_col-sm-6'
			),

			// Longitude
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Longitude', 'dtsl' ),
				'param_name' => 'longitude',
				'description' => esc_html__( 'Please specify longitude of the location to display.', 'dtsl' ),
				'edit_field_class' => 'vc_column vc_col-sm-6'
			),

			// Number Of Items to Show
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Number Of Items to Show','dtsl'),
				'param_name' => 'count',
				'value' => array(
					1 => 1,
					2 => 2,
					3 => 3,
					4 => 4,
					5 => 5,
				),
				'description' => esc_html__('Total number of items to show.', 'dtsl'),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Yelp API Key
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Yelp API Key', 'dtsl' ),
				'param_name' => 'api_key',
				'description' => esc_html__( 'Provide Yelp API key here.', 'dtsl' ),
				'edit_field_class' => 'vc_column vc_col-sm-6'
			),

			// Class
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Class', 'dtsl' ),
				'param_name' => 'class',
				'description' => esc_html__( 'If you wish you can add additional class name here.', 'dtsl' ),
				'edit_field_class' => 'vc_column vc_col-sm-6'
			)

		)
	) );
}
?>