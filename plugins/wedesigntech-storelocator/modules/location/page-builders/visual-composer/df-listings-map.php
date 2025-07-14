<?php
add_action( 'vc_before_init', 'dtsl_listings_map_vc_map' );

function dtsl_listings_map_vc_map() {

	$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );
	$listing_plural_label = apply_filters( 'dt_sl_listing_label', 'plural' );
	$contracttype_plural_label = apply_filters( 'dt_sl_contracttype_label', 'plural' );
	$seller_singular_label = apply_filters( 'dt_sl_seller_label', 'singular' );
	$incharge_singular_label = apply_filters( 'dt_sl_incharge_label', 'singular' );

	$countries_list = dtsl_countries_list(false);
	$countries_list = array_flip($countries_list);

	$countries_list = array(esc_html__('All', 'dtsl') => '') + $countries_list;

	vc_map( array(
		"name" => sprintf( esc_html__('%1$s Map', 'dtsl'), $listing_plural_label ),
		"base" => "dtsl_listings_map",
		"icon" => "dtsl_listings_map",
		"category" => DTSL_PB_MODULE_DEFAULT_TITLE,
		"params" => array_merge (

						array(

							// Type
							array(
								'type' => 'dropdown',
								'heading' => esc_html__('Type','dtsl'),
								'param_name' => 'type',
								'value' => array(
									esc_html__( 'Type 1', 'dtsl' ) => 'type1',
									esc_html__( 'Type 2', 'dtsl' ) => 'type2',
									esc_html__( 'Type 3', 'dtsl' ) => 'type3',
									esc_html__( 'Type 4', 'dtsl' ) => 'type4'
								),
								'description' => esc_html__('Choose type of layout you like to display.', 'dtsl'),
								'edit_field_class' => 'vc_column vc_col-sm-6',
							),

							// Additional Info
							array (
								'type' => 'dropdown',
								'heading' => esc_html__('Additional Info','dtsl'),
								'param_name' => 'additional_info',
								'value' => array(
									esc_html__('None', 'dtsl') => '',
									esc_html__('Total Views', 'dtsl') => 'totalviews',
									esc_html__('Average Ratings', 'dtsl') => 'averageratings',
									esc_html__('Category Image', 'dtsl') => 'categoryimage',
									esc_html__('Category Icon', 'dtsl') => 'categoryicon'
								),
								'description' => esc_html__( 'Choose additional info that you like to display along with location marker.', 'dtsl' ),
								'std' => '',
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'admin_label' => true
							),

							// Background Color
				      		array(
				      			'type' => 'colorpicker',
				      			'heading' => esc_html__( 'Background Color', 'dtsl' ),
				      			'param_name' => 'category_background_color',
								'dependency' => array( 'element' => 'additional_info', 'value' => array ('categoryimage', 'categoryicon') ),
				      			'description' => esc_html__( 'Select background color for your Category Icon. Icon will be taken from the category settings.', 'dtsl' ),
				      			'edit_field_class' => 'vc_column vc_col-sm-6',
				      		),

							// Color
				      		array(
				      			'type' => 'colorpicker',
				      			'heading' => esc_html__( 'Color', 'dtsl' ),
				      			'param_name' => 'category_color',
								'dependency' => array( 'element' => 'additional_info', 'value' => array ('categoryimage', 'categoryicon') ),
				      			'description' => esc_html__( 'Select icon color for your Category Image / Icon. Image / Icon will be taken from the category settings.', 'dtsl' ),
				      			'edit_field_class' => 'vc_column vc_col-sm-6',
				      		),

							// Zoom Level
							array(
								'type' => 'textfield',
								'heading' => esc_html__( 'Zoom Level', 'dtsl' ),
								'param_name' => 'zoom_level',
								'description' => esc_html__( 'Add map zoom level here. This will overwrite the default map zoom level. Ex: ... 9, 10, 11...', 'dtsl' ),
								'edit_field_class' => 'vc_column vc_col-sm-6',
							),

							// Map Type
							array (
								'type' => 'dropdown',
								'heading' => esc_html__('Map Type','dtsl'),
								'param_name' => 'map_type',
								'value' => array(
									esc_html__('Default', 'dtsl') => '',
									esc_html__('SATELLITE', 'dtsl') => 'SATELLITE',
									esc_html__('HYBRID', 'dtsl') => 'HYBRID',
									esc_html__('TERRAIN', 'dtsl') => 'TERRAIN',
									esc_html__('ROADMAP', 'dtsl') => 'ROADMAP',
								),
								'description' => esc_html__( 'Choose map type for this item.', 'dtsl' ),
								'edit_field_class' => 'vc_column vc_col-sm-6',
							),

							// Height
							array (
								'type' => 'textfield',
								'heading' => esc_html__( 'Height', 'dtsl' ),
								'param_name' => 'vc_height',
								'description' => esc_html__( 'Provide height for your map in "px" here.', 'dtsl' ),
								'edit_field_class' => 'vc_column vc_col-sm-6'
							),

							// Marker Animation
							array (
								'type' => 'dropdown',
								'heading' => esc_html__('Marker Animation','dtsl'),
								'param_name' => 'marker_animation',
								'value' => array(
									esc_html__('False', 'dtsl') => 'false',
									esc_html__('True', 'dtsl') => 'true'
								),
								'description' => esc_html__( 'Choose true if your like to have animation for your map marker.', 'dtsl' ),
								'std' => 'false'
							),

							// Class
							array (
								'type' => 'textfield',
								'heading' => esc_html__( 'Class', 'dtsl' ),
								'param_name' => 'class',
								'description' => esc_html__( 'If you wish you can add additional class name here.', 'dtsl' ),
							),


							// Filter Options

							// Listing Item Ids
							array(
								'type' => 'textfield',
								'heading' => sprintf( esc_html__('%1$s Item Ids', 'dtsl'), $dt_sl_listing_singular_label ),
								'param_name' => 'list_item_ids',
								'value' => '',
								'description' => sprintf( esc_html__( 'Enter %1$s item ids separated by commas.', 'dtsl' ), $dt_sl_listing_singular_label ),
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'group' => 'Filters',
								'std' => ''
							),

							// Category Ids
							array(
								'type' => 'textfield',
								'heading' => sprintf( esc_html__('%1$s Category Ids', 'dtsl'), $dt_sl_listing_singular_label ),
								'param_name' => 'category_ids',
								'value' => '',
								'description' => esc_html__( 'Enter category ids separated by comma.', 'dtsl' ),
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'group' => 'Filters',
								'std' => ''
							),

							// Cities Ids
							array(
								'type' => 'textfield',
								'heading' => sprintf( esc_html__('%1$s Cities Ids', 'dtsl'), $dt_sl_listing_singular_label ),
								'param_name' => 'cities_ids',
								'value' => '',
								'description' => esc_html__( 'Enter cities ids separated by comma.', 'dtsl' ),
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'group' => 'Filters',
								'std' => ''
							),

							// Neighborhoods Ids
							array(
								'type' => 'textfield',
								'heading' => sprintf( esc_html__('%1$s Neighborhoods Ids', 'dtsl'), $dt_sl_listing_singular_label ),
								'param_name' => 'neighborhoods_ids',
								'value' => '',
								'description' => esc_html__( 'Enter neighborhoods ids separated by commas.', 'dtsl' ),
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'group' => 'Filters',
								'std' => ''
							),

							// Counties / States Ids
							array(
								'type' => 'textfield',
								'heading' => sprintf( esc_html__('%1$s Counties / States Ids', 'dtsl'), $dt_sl_listing_singular_label ),
								'param_name' => 'countiesstates_ids',
								'value' => '',
								'description' => esc_html__( 'Enter countiesstates ids separated by commas.', 'dtsl' ),
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'group' => 'Filters',
								'std' => ''
							),

							// Contract Types Ids
							array(
								'type' => 'textfield',
								'heading' => sprintf( esc_html__('%1$s %2$s', 'dtsl'), $dt_sl_listing_singular_label, $contracttype_plural_label ),
								'param_name' => 'contracttypes_ids',
								'value' => '',
								'description' => esc_html__( 'Enter contract types ids separated by commas.', 'dtsl' ),
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'group' => 'Filters',
								'std' => ''
							),

							// Tag Ids
							array(
								'type' => 'textfield',
								'heading' => sprintf( esc_html__('%1$s Tag Ids', 'dtsl'), $dt_sl_listing_singular_label ),
								'param_name' => 'tag_ids',
								'value' => '',
								'description' => esc_html__( 'Enter tag ids separated by comma.', 'dtsl' ),
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'group' => 'Filters',
								'std' => ''
							),

							// Countries
							array(
								'type' => 'dropdown',
								'heading' => esc_html__('Countries','dtsl'),
								'param_name' => 'country_id',
								'value' => $countries_list,
								'description' => esc_html__( 'Choose countries for which you like to display items.', 'dtsl' ),
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'group' => 'Filters',
								'std' => ''
							),

							// Seller Ids
							array(
								'type' => 'textfield',
								'heading' => sprintf( esc_html__('%1$s %2$s Ids', 'dtsl'), $dt_sl_listing_singular_label, $seller_singular_label ),
								'param_name' => 'seller_ids',
								'value' => '',
								'description' => sprintf( esc_html__('Enter %1$s ids separated by commas.', 'dtsl'), strtolower($seller_singular_label) ),
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'group' => 'Filters',
								'std' => ''
							),

							// Incharge Ids
							array(
								'type' => 'textfield',
								'heading' => sprintf( esc_html__('%1$s %2$s Ids', 'dtsl'), $dt_sl_listing_singular_label, $incharge_singular_label ),
								'param_name' => 'incharge_ids',
								'value' => '',
								'description' => esc_html__( 'Enter incharge ids separated by commas.', 'dtsl' ),
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'group' => 'Filters',
								'std' => ''
							),

							// Map Style Options

							// Map Style
							array (
								'type' => 'dropdown',
								'heading' => esc_html__('Map Style','dtsl'),
								'param_name' => 'map_style_type',
								'value' => array(
									esc_html__('Color', 'dtsl') => 'color',
									esc_html__('Style', 'dtsl') => 'style'
								),
								'description' => esc_html__( 'Choose map style type for this item.', 'dtsl' ),
								'std' => 'color'
							),

							// Map Color
							array(
								'type' => 'colorpicker',
								'heading' => esc_html__( 'Map Color', 'dtsl' ),
								'param_name' => 'map_color',
								'description' => esc_html__( 'Select color for your map. This will override the default map color.', 'dtsl' ),
								'dependency' => array( 'element' => 'map_style_type', 'value' => 'color' )
							),

							// Map Style Script
							array (
								'type' => 'textarea',
								'heading' => esc_html__( 'Map Style Script', 'dtsl' ),
								'param_name' => 'map_style_script',
								'description' => esc_html__( 'Please enter "Snazzy Maps" provided "JAVASCRIPT STYLE ARRAY" here.', 'dtsl' ),
								'dependency' => array( 'element' => 'map_style_type', 'value' => 'style' ),
								'edit_field_class' => 'vc_column vc_col-sm-6'
							)

						)

					)


	) );
}
?>