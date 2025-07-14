<?php
add_action( 'vc_before_init', 'dtsl_sp_nearby_places_vc_map' );

function dtsl_sp_nearby_places_vc_map() {

	$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );

	vc_map( array(
		"name" => esc_html__( 'NearBy Places', 'dtsl' ),
		"base" => "dtsl_sp_nearby_places",
		"icon" => "dtsl_sp_nearby_places",
		"category" => DTSL_PB_MODULE_SINGLEPAGE_TITLE,
		"params" => array(

			// Listing Id
			array(
				'type' => 'textfield',
				'heading' => sprintf( esc_html__('%1$s Id', 'dtsl'), $dt_sl_listing_singular_label ),
				'param_name' => 'listing_id',
				'description' => sprintf( esc_html__('Provide %1$s id for which you have to display map. No need to provide ID if it is used in %1$s single page.', 'dtsl'), strtolower($dt_sl_listing_singular_label) ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'admin_label' => true
			),

			// API Type
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('API Type','dtsl'),
				'param_name' => 'api_type',
				'value' => array(
					esc_html__('Find Place From Text', 'dtsl') => 'findplacefromtext',
					esc_html__('Near By Search', 'dtsl') => 'nearbysearch'
				),
				'description' => esc_html__('Choose "True" if you like to show images".', 'dtsl'),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'std' => 'findplacefromtext',
			),

			// Media Type
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Media Type','dtsl'),
				'param_name' => 'media_type',
				'value' => array(
					esc_html__( 'None', 'dtsl' )  => '',
					esc_html__( 'Image', 'dtsl' ) => 'image',
					esc_html__( 'Icon', 'dtsl' )  => 'icon'
				),
				'description' => esc_html__('Choose what type of media you like to use.', 'dtsl'),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),


			// Place Type
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Place Type', 'dtsl'),
				'description' => esc_html__('Choose places that you like to display nearby.', 'dtsl'),
				'param_name' => 'place_type',
				'value' => array(
					'',
				    'accounting',
				    'airport',
				    'amusement_park',
				    'aquarium',
				    'art_gallery',
				    'atm',
				    'bakery',
				    'bank',
				    'bar',
				    'beauty_salon',
				    'bicycle_store',
				    'book_store',
				    'bowling_alley',
				    'bus_station',
				    'cafe',
				    'campground',
				    'car_dealer',
				    'car_rental',
				    'car_repair',
				    'car_wash',
				    'casino',
				    'cemetery',
				    'church',
				    'city_hall',
				    'clothing_store',
				    'convenience_store',
				    'courthouse',
				    'dentist',
				    'department_store',
				    'doctor',
				    'electrician',
				    'electronics_store',
				    'embassy',
				    'fire_station',
				    'florist',
				    'funeral_home',
				    'furniture_store',
				    'gas_station',
				    'gym',
				    'hair_care',
				    'hardware_store',
				    'hindu_temple',
				    'home_goods_store',
				    'hospital',
				    'insurance_agency',
				    'jewelry_store',
				    'laundry',
				    'lawyer',
				    'library',
				    'liquor_store',
				    'local_government_office',
				    'locksmith',
				    'lodging',
				    'meal_delivery',
				    'meal_takeaway',
				    'mosque',
				    'movie_rental',
				    'movie_theater',
				    'moving_company',
				    'museum',
				    'night_club',
				    'painter',
				    'park',
				    'parking',
				    'pet_store',
				    'pharmacy',
				    'physiotherapist',
				    'plumber',
				    'police',
				    'post_office',
				    'real_estate_agency',
				    'restaurant',
				    'roofing_contractor',
				    'rv_park',
				    'school',
				    'shoe_store',
				    'shopping_mall',
				    'spa',
				    'stadium',
				    'storage',
				    'store',
				    'subway_station',
				    'supermarket',
				    'synagogue',
				    'taxi_stand',
				    'train_station',
				    'transit_station',
				    'travel_agency',
				    'veterinary_care',
				    'zoo'
				),
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

			// Radius
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Radius ( in meters )', 'dtsl' ),
				'param_name' => 'radius',
				'value' => '1000',
				'description' => esc_html__( 'Provide radius around which you want to search.', 'dtsl' ),
				'edit_field_class' => 'vc_column vc_col-sm-6'
			),

			// Google Map API Key
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Google Map API Key', 'dtsl' ),
				'param_name' => 'api_key',
				'description' => esc_html__( 'If you wish you can provide separate API key here. If not API key from "Settings" will be considered.', 'dtsl' ),
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