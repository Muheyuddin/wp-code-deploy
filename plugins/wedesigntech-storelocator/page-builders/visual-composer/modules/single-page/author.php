<?php
add_action( 'vc_before_init', 'dtsl_sp_author_vc_map' );

function dtsl_sp_author_vc_map() {

	$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );
	$incharge_plural_label = apply_filters( 'dt_sl_incharge_label', 'plural' );

	vc_map( array(
		"name" => esc_html__( 'Author Details', 'dtsl' ),
		"base" => "dtsl_sp_author",
		"icon" => "dtsl_sp_author",
		"category" => DTSL_PB_MODULE_SINGLEPAGE_TITLE,
		"params" => array(

			// Listing Id
			array(
				'type' => 'textfield',
				'heading' => sprintf( esc_html__('%1$s Id', 'dtsl'), $dt_sl_listing_singular_label ),
				'param_name' => 'listing_id',
				'description' => sprintf( esc_html__('Provide %1$s id for which you have to display features. No need to provide ID if it is used in %1$s single page.', 'dtsl'), strtolower($dt_sl_listing_singular_label) ),
				'admin_label' => true,
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Content Type
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Content Type', 'dtsl'),
				'description' => esc_html__('Contact type that you like to display.', 'dtsl'),
				'param_name' => 'content_type',
				'value' => array(
					esc_html__( 'Post Author', 'dtsl' ) => 'author',
					sprintf( esc_html__('%1$s Included', 'dtsl'), $incharge_plural_label ) => 'incharges_included',
					esc_html__( 'Both', 'dtsl' ) => 'both',
				),
				'std' => 'list',
				'admin_label' => true,
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
						),
				'description' => esc_html__( 'Number of columns you like to display for your authors.', 'dtsl' ),
				'std' => 1,
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Class
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Class', 'dtsl' ),
				'param_name' => 'class',
				'description' => esc_html__( 'If you wish you can add additional class name here.', 'dtsl' ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),


			// Carousel

			// Enable Carousel
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Enable Carousel', 'dtsl'),
				'description' => esc_html__('Choose "True" if you like to enable carousel for your authors.', 'dtsl'),
				'param_name' => 'enable_carousel',
				'value' => array(
					esc_html__( 'False', 'dtsl' ) => 'false',
					esc_html__( 'True', 'dtsl' ) => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'group' => 'Carousel',
			),

			// Carousel Pagination
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Carousel Pagination', 'dtsl'),
				'param_name' => 'carousel_pagination',
				'value' => array(
							esc_html__('None', 'dtsl') => '' ,
							esc_html__('Bullets', 'dtsl') => 'bullets' ,
							esc_html__('Arrows', 'dtsl') => 'arrows' ,
						),
				'description' => esc_html__( 'Choose one of the available paginations.', 'dtsl' ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'group' => 'Carousel',
			),

			// Carousel Pagination Type
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Carousel Pagination Type', 'dtsl'),
				'param_name' => 'carousel_pagination_type',
				'value' => array(
							esc_html__('Type 1', 'dtsl') => 'type1' ,
							esc_html__('Type 2', 'dtsl') => 'type2' ,
						),
				'description' => esc_html__( 'Choose one of the available pagination design types.', 'dtsl' ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'std' => 'type1',
				'group' => 'Carousel'
			),

			// Space Between Sliders
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Space Between Sliders','dtsl'),
				'param_name' => 'carousel_spacebetween',
				'description' => esc_html__( 'Space between sliders can be given here.', 'dtsl' ),
				'group' => 'Carousel',
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'std' => 20,
				'dependency' => array( 'element' => 'enable_carousel', 'value' => 'true'),
			)

		)
	) );
}
?>