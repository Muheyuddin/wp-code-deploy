<?php
add_action( 'vc_before_init', 'dtsl_sp_utils_vc_map' );

function dtsl_sp_utils_vc_map() {

	$dt_sl_listing_singular_label      = apply_filters( 'dt_sl_listing_label', 'singular' );
	$dt_sl_contracttype_singular_label = apply_filters( 'dt_sl_contracttype_label', 'singular' );
	$seller_singular_label       = apply_filters( 'dt_sl_seller_label', 'singular' );
	$dt_sl_amenity_singular_label      = apply_filters( 'dt_sl_amenity_label', 'singular' );

	vc_map( array(
		"name" => esc_html__( 'Utils', 'dtsl' ),
		"base" => "dtsl_sp_utils",
		"icon" => "dtsl_sp_utils",
		"category" => DTSL_PB_MODULE_SINGLEPAGE_TITLE,
		"params" => array(

			// Listing Id
			array(
				'type' => 'textfield',
				'heading' => sprintf( esc_html__('%1$s Id', 'dtsl'), $dt_sl_listing_singular_label ),
				'param_name' => 'listing_id',
				'description' => sprintf( esc_html__('Provide %1$s id for which you have to display favourites, share,... No need to provide ID if it is used in %1$s single page.', 'dtsl'), strtolower($dt_sl_listing_singular_label) ),
				'admin_label' => true
			),

			// Show Title
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show Title', 'dtsl'),
				'description' => esc_html__('Choose "True" if you like to show title.', 'dtsl'),
				'param_name' => 'show_title',
				'value' => array(
					esc_html__( 'False', 'dtsl' ) => 'false',
					esc_html__( 'True', 'dtsl' ) => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Show Favourite
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show Favourite', 'dtsl'),
				'description' => esc_html__('Choose "True" if you like to show favourite option.', 'dtsl'),
				'param_name' => 'show_favourite',
				'value' => array(
					esc_html__( 'False', 'dtsl' ) => 'false',
					esc_html__( 'True', 'dtsl' ) => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Show Page View
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show Page View', 'dtsl'),
				'description' => esc_html__('Choose "True" if you like to show page view.', 'dtsl'),
				'param_name' => 'show_pageview',
				'value' => array(
					esc_html__( 'False', 'dtsl' ) => 'false',
					esc_html__( 'True', 'dtsl' ) => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Show Print
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show Print', 'dtsl'),
				'description' => esc_html__('Choose "True" if you like to show print option.', 'dtsl'),
				'param_name' => 'show_print',
				'value' => array(
					esc_html__( 'False', 'dtsl' ) => 'false',
					esc_html__( 'True', 'dtsl' ) => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Show Social Share
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show Social Share', 'dtsl'),
				'description' => esc_html__('Choose "True" if you like to show social share option.', 'dtsl'),
				'param_name' => 'show_socialshare',
				'value' => array(
					esc_html__( 'False', 'dtsl' ) => 'false',
					esc_html__( 'True', 'dtsl' ) => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Show Average Rating
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show Average Rating', 'dtsl'),
				'description' => esc_html__('Choose "True" if you like to show average rating.', 'dtsl'),
				'param_name' => 'show_averagerating',
				'value' => array(
					esc_html__( 'False', 'dtsl' ) => 'false',
					esc_html__( 'True', 'dtsl' ) => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Show Featured Item
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show Featured Item', 'dtsl'),
				'description' => esc_html__('Choose "True" if you like to show featured item.', 'dtsl'),
				'param_name' => 'show_featured',
				'value' => array(
					esc_html__( 'False', 'dtsl' ) => 'false',
					esc_html__( 'True', 'dtsl' ) => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Show Categories
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show Categories', 'dtsl'),
				'description' => esc_html__('Choose "True" if you like to show categories.', 'dtsl'),
				'param_name' => 'show_categories',
				'value' => array(
					esc_html__( 'False', 'dtsl' ) => 'false',
					esc_html__( 'True', 'dtsl' ) => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Show Cities
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show Cities', 'dtsl'),
				'description' => esc_html__('Choose "True" if you like to show cities.', 'dtsl'),
				'param_name' => 'show_cities',
				'value' => array(
					esc_html__( 'False', 'dtsl' ) => 'false',
					esc_html__( 'True', 'dtsl' ) => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Show Neighborhoods
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show Neighborhoods', 'dtsl'),
				'description' => esc_html__('Choose "True" if you like to show neighborhoods.', 'dtsl'),
				'param_name' => 'show_neighborhoods',
				'value' => array(
					esc_html__( 'False', 'dtsl' ) => 'false',
					esc_html__( 'True', 'dtsl' ) => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Show County / State
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show County / State', 'dtsl'),
				'description' => esc_html__('Choose "True" if you like to show county / state.', 'dtsl'),
				'param_name' => 'show_countystate',
				'value' => array(
					esc_html__( 'False', 'dtsl' ) => 'false',
					esc_html__( 'True', 'dtsl' ) => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Show Contract Type
			array(
				'type' => 'dropdown',
				'heading' => sprintf( esc_html__('Show %1$s', 'dtsl'), $dt_sl_contracttype_singular_label ),
				'description' =>sprintf( esc_html__('Choose "True" if you like to show %1$s', 'dtsl'), strtolower($dt_sl_contracttype_singular_label) ),
				'param_name' => 'show_contracttype',
				'value' => array(
					esc_html__( 'False', 'dtsl' ) => 'false',
					esc_html__( 'True', 'dtsl' ) => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Show Amenity
			array(
				'type' => 'dropdown',
				'heading' => sprintf( esc_html__('Show %1$s', 'dtsl'), $dt_sl_amenity_singular_label ),
				'description' =>sprintf( esc_html__('Choose "True" if you like to show %1$s', 'dtsl'), strtolower($dt_sl_amenity_singular_label) ),
				'param_name' => 'show_amenity',
				'value' => array(
					esc_html__( 'False', 'dtsl' ) => 'false',
					esc_html__( 'True', 'dtsl' ) => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Show Price
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show Price', 'dtsl'),
				'description' => esc_html__('Choose "True" if you like to show price.', 'dtsl'),
				'param_name' => 'show_price',
				'value' => array(
					esc_html__( 'False', 'dtsl' ) => 'false',
					esc_html__( 'True', 'dtsl' ) => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Show Address
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show Address', 'dtsl'),
				'description' => esc_html__('Choose "True" if you like to show address.', 'dtsl'),
				'param_name' => 'show_address',
				'value' => array(
					esc_html__( 'False', 'dtsl' ) => 'false',
					esc_html__( 'True', 'dtsl' ) => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Show Contact Details
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show Contact Details', 'dtsl'),
				'description' => esc_html__('Contact details that you like to display.', 'dtsl'),
				'param_name' => 'show_contactdetails',
				'value' => array(
					esc_html__( 'None', 'dtsl' ) => '',
					sprintf( esc_html__('%1$s', 'dtsl'), $dt_sl_listing_singular_label ) => 'list',
					sprintf( esc_html__('%1$s', 'dtsl'), $seller_singular_label ) => 'seller',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Show Contact Details - On Request
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show Contact Details - On Request', 'dtsl'),
				'description' => esc_html__('Choose "True" if you like to show contact details on request.', 'dtsl'),
				'param_name' => 'show_contactdetails_onrequest',
				'value' => array(
					esc_html__( 'False', 'dtsl' ) => 'false',
					esc_html__( 'True', 'dtsl' ) => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Show Start Date
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show Start Date', 'dtsl'),
				'description' => esc_html__('Choose "True" if you like to show start date.', 'dtsl'),
				'param_name' => 'show_startdate',
				'value' => array(
					esc_html__( 'False', 'dtsl' ) => 'false',
					esc_html__( 'True', 'dtsl' ) => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Show End Date
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show End Date', 'dtsl'),
				'description' => esc_html__('Choose "True" if you like to show end date.', 'dtsl'),
				'param_name' => 'show_enddate',
				'value' => array(
					esc_html__( 'False', 'dtsl' ) => 'false',
					esc_html__( 'True', 'dtsl' ) => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Show Posted Date
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show Posted Date', 'dtsl'),
				'description' => esc_html__('Choose "True" if you like to show posted date.', 'dtsl'),
				'param_name' => 'show_posteddate',
				'value' => array(
					esc_html__( 'False', 'dtsl' ) => 'false',
					esc_html__( 'True', 'dtsl' ) => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Show Merged Date
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show Merged Dates', 'dtsl'),
				'description' => esc_html__('Choose "True" if you like to show merged date.', 'dtsl'),
				'param_name' => 'show_mergeddates',
				'value' => array(
					esc_html__( 'False', 'dtsl' ) => 'false',
					esc_html__( 'True', 'dtsl' ) => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Class
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Class', 'dtsl' ),
				'param_name' => 'class',
				'description' => esc_html__( 'If you wish you can add additional class name here.', 'dtsl' ),
			),

		)
	) );
}
?>