<?php
add_action( 'vc_before_init', 'dtsl_sf_output_data_container_vc_map' );

function dtsl_sf_output_data_container_vc_map() {

	$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );

	$dtsl_sf_output_data_container_vc_map_module_args = apply_filters('dtsl_sf_output_data_container_vc_map_module_args', array ());

	vc_map( array (
		"name" => esc_html__( 'Output Data Container', 'dtsl' ),
		"base" => "dtsl_sf_output_data_container",
		"icon" => "dtsl_sf_output_data_container",
		"category" => DTSL_PB_MODULE_SEARCHFORM_TITLE,
		"params" => array (

						// Default Options

							// Type
							array(
								'type' => 'dropdown',
								'heading' => esc_html__('Type','dtsl'),
								'param_name' => 'type',
								'value' => array(
									esc_html__( 'Type 1', 'dtsl' )  => 'type1',
									esc_html__( 'Type 2', 'dtsl' )  => 'type2',
									esc_html__( 'Type 3', 'dtsl' )  => 'type3',
									esc_html__( 'Type 4', 'dtsl' )  => 'type4',
									esc_html__( 'Type 5', 'dtsl' )  => 'type5',
									esc_html__( 'Type 6', 'dtsl' )  => 'type6',
									esc_html__( 'Type 7', 'dtsl' )  => 'type7',
									esc_html__( 'Type 8', 'dtsl' )  => 'type8',
									esc_html__( 'Type 9', 'dtsl' )  => 'type9',
									esc_html__( 'Type 10', 'dtsl' ) => 'type10',
									esc_html__( 'Type 11', 'dtsl' ) => 'type11',
									esc_html__( 'Type 12', 'dtsl' ) => 'type12'
								),
								'description' => esc_html__('Choose type of layout you like to display.', 'dtsl'),
								'edit_field_class' => 'vc_column vc_col-sm-6',
							),

							// Gallery
							array (
								'type' => 'dropdown',
								'heading' => esc_html__('Gallery','dtsl'),
								'param_name' => 'gallery',
								'value' => array(
									esc_html__('Featured Image', 'dtsl') => 'featured_image',
									esc_html__('Image Gallery', 'dtsl') => 'image_gallery',
									esc_html__('Image Gallery With Featured Image', 'dtsl') => 'gallery_with_featured',
								),
								'description' => esc_html__( 'Choose how you like to display image gallery.', 'dtsl' ),
								'dependency' => array( 'element' => 'type', 'value' => array( 'type1', 'type2', 'type3', 'type4', 'type5', 'type6', 'type7', 'type8', 'type9', 'type10' )),
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'std' => 'featured_image',
							),

							// Post Per Page
							array(
								'type' => 'textfield',
								'heading' => esc_html__( 'Post Per Page', 'dtsl' ),
								'param_name' => 'post_per_page',
								'description' => esc_html__( 'Number of posts to show per page. Rest of the posts will be displayed in pagination.', 'dtsl' ),
								'edit_field_class' => 'vc_column vc_col-sm-6',
							),

							// Columns
							array(
								'type' => 'dropdown',
								'heading' => esc_html__('Columns', 'dtsl'),
								'param_name' => 'columns',
								'value' => array(
											esc_html__('I Column', 'dtsl') => 1 ,
											esc_html__('II Columns', 'dtsl') => 2 ,
											esc_html__('III Columns', 'dtsl') => 3
										),
								'description' => esc_html__( 'Number of columns you like to display your items.', 'dtsl' ),
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'dependency' => array( 'element' => 'type', 'value' => array( 'type1', 'type2', 'type4', 'type6', 'type8')),
								'std' => 1
							),

							// Apply Isotope
							array(
								'type' => 'dropdown',
								'heading' => esc_html__('Apply Isotope','dtsl'),
								'param_name' => 'apply_isotope',
								'value' => array(
									esc_html__( 'False', 'dtsl' ) => 'false',
									esc_html__( 'True', 'dtsl' ) => 'true',
								),
								'description' => esc_html__('Choose true if you like to apply isotope for your items.', 'dtsl'),
								'edit_field_class' => 'vc_column vc_col-sm-6',
							),

							// Excerpt Length
							array(
								'type' => 'textfield',
								'heading' => esc_html__( 'Excerpt Length', 'dtsl' ),
								'param_name' => 'excerpt_length',
								'description' => esc_html__( 'Provide excerpt length here.', 'dtsl' ),
								'dependency' => array( 'element' => 'type', 'value' => array(  'type1', 'type2', 'type3', 'type4', 'type5', 'type7', 'type8', 'type9', 'type10' )),
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'std' => 20
							),

							// Features Image or Icon
							array(
								'type' => 'dropdown',
								'heading' => esc_html__('Features Image or Icon','dtsl'),
								'param_name' => 'features_image_or_icon',
								'value' => array(
									esc_html__( 'None', 'dtsl' ) => '',
									esc_html__( 'Image', 'dtsl' ) => 'image',
									esc_html__( 'Icon', 'dtsl' ) => 'icon'
								),
								'description' => esc_html__('Choose any of the option available to display features.', 'dtsl'),
								'dependency' => array( 'element' => 'type', 'value' => array ( 'type1', 'type2', 'type3', 'type4', 'type5', 'type6', 'type8', 'type9' )),
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'std' => '',
							),

							// Features Include
							array(
								'type' => 'dropdown',
								'heading' => esc_html__('Features Include','dtsl'),
								'param_name' => 'features_include',
								'description' => esc_html__('Give features id separated by comma. Only 4 maximum number of features allowed.', 'dtsl'),
								'dependency' => array( 'element' => 'type', 'value' => array ( 'type1', 'type2', 'type3', 'type4', 'type5', 'type6', 'type8', 'type9' )),
								'std' => '',
								'edit_field_class' => 'vc_column vc_col-sm-6',
							),

							// No. Of Categories to Display
							array(
								'type' => 'dropdown',
								'heading' => esc_html__('No. Of Categories to Display', 'dtsl'),
								'param_name' => 'no_of_cat_to_display',
								'value' => array(
									1  => 1,
									2  => 2,
									3  => 3,
									4  => 4
								),
								'description' => esc_html__( 'Number of categories you like to display on your items.', 'dtsl' ),
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'std' => 2
							),

							// Apply Category Toggle
							array(
								'type' => 'dropdown',
								'heading' => esc_html__('Apply Category Toggle','dtsl'),
								'param_name' => 'apply_category_toggle',
								'value' => array(
									esc_html__( 'False', 'dtsl' ) => 'false',
									esc_html__( 'True', 'dtsl' ) => 'true',
								),
								'description' => esc_html__('Apply category toggle for you items list.', 'dtsl'),
								'std' => 'false',
								'dependency' => array( 'element' => 'apply_isotope', 'value' =>'false' ),
								'edit_field_class' => 'vc_column vc_col-sm-6',
							),

							// Category Toggle Type
							array(
								'type' => 'dropdown',
								'heading' => esc_html__('Category Toggle Type','dtsl'),
								'param_name' => 'category_toggle_type',
								'value' => array(
									esc_html__( 'Type 1', 'dtsl' )  => 'type1',
									esc_html__( 'Type 2', 'dtsl' )  => 'type2',
									esc_html__( 'Type 3', 'dtsl' )  => 'type3',
									esc_html__( 'Type 4', 'dtsl' )  => 'type4',
									esc_html__( 'Type 5', 'dtsl' )  => 'type5'
								),
								'description' => esc_html__('Choose category toggle type for you items list.', 'dtsl'),
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'dependency' => array( 'element' => 'apply_category_toggle', 'value' =>'false' ),
								'std' => 'type1',
							),

							// Apply Equal Height
							array(
								'type' => 'dropdown',
								'heading' => esc_html__('Apply Equal Height','dtsl'),
								'param_name' => 'apply_equal_height',
								'value' => array(
									esc_html__( 'False', 'dtsl' ) => 'false',
									esc_html__( 'True', 'dtsl' ) => 'true',
								),
								'description' => esc_html__('Apply equal height for you items.', 'dtsl'),
								'std' => 'false',
								'dependency' => array( 'element' => 'apply_isotope', 'value' =>'false' ),
								'edit_field_class' => 'vc_column vc_col-sm-6',
							),

							// Apply Custom Height
							array(
								'type' => 'dropdown',
								'heading' => esc_html__('Apply Custom Height','dtsl'),
								'param_name' => 'apply_custom_height',
								'value' => array(
									esc_html__( 'False', 'dtsl' ) => 'false',
									esc_html__( 'True', 'dtsl' ) => 'true',
								),
								'description' => esc_html__('Apply custom height for your entire section.', 'dtsl'),
								'std' => 'false',
								'edit_field_class' => 'vc_column vc_col-sm-6',
							),

							// Height
							array (
								'type' => 'textfield',
								'heading' => esc_html__( 'Height', 'dtsl' ),
								'param_name' => 'vc_height',
								'description' => esc_html__( 'Provide height for your section in "px" here.', 'dtsl' ),
								'dependency' => array( 'element' => 'apply_custom_height', 'value' =>'true' ),
								'edit_field_class' => 'vc_column vc_col-sm-6'
							),

							// Sidebar Widget
							array(
								'type' => 'dropdown',
								'heading' => esc_html__('Sidebar Widget','dtsl'),
								'param_name' => 'sidebar_widget',
								'value' => array(
									esc_html__( 'False', 'dtsl' ) => 'false',
									esc_html__( 'True', 'dtsl' ) => 'true',
								),
								'description' => esc_html__('If you wish to show these items in sidebar set this to "True". This options is not applicable for "Type 3", "Type 5" and "Type 7"', 'dtsl'),
								'std' => 'false',
								'edit_field_class' => 'vc_column vc_col-sm-6',
							),

							// Class
							array (
								'type' => 'textfield',
								'heading' => esc_html__( 'Class', 'dtsl' ),
								'param_name' => 'class',
								'description' => esc_html__( 'If you wish you can add additional class name here.', 'dtsl' ),
								'edit_field_class' => 'vc_column vc_col-sm-6',
							),

						// Module Options

							$dtsl_sf_output_data_container_vc_map_module_args,

						// Filter Options

							// Category Ids
							array(
								'type' => 'textfield',
								'heading' => sprintf( esc_html__('%1$s Category Ids', 'dtsl'), $dt_sl_listing_singular_label ),
								'param_name' => 'category_ids',
								'value' => '',
								'description' => esc_html__( 'Enter category ids separated by commas.', 'dtsl' ),
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'group' => 'Filters',
								'std' => ''
							),

					)

	) );

}
?>