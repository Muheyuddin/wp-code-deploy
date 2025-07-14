<?php
add_action( 'vc_before_init', 'dtdr_sp_author_vc_map' );

function dtdr_sp_author_vc_map() {

	$listing_singular_label = apply_filters( 'listing_label', 'singular' );
	$incharge_plural_label = apply_filters( 'incharge_label', 'plural' );

	vc_map( array(
		"name" => esc_html__( 'Author Details', 'dtdr' ),
		"base" => "dtdr_sp_author",
		"icon" => "dtdr_sp_author",
		"category" => DTDR_PB_MODULE_SINGLEPAGE_TITLE,
		"params" => array(

			// Listing Id
			array(
				'type' => 'textfield',
				'heading' => sprintf( esc_html__('%1$s Id', 'dtdr'), $listing_singular_label ),
				'param_name' => 'listing_id',
				'description' => sprintf( esc_html__('Provide %1$s id for which you have to display features. No need to provide ID if it is used in %1$s single page.', 'dtdr'), strtolower($listing_singular_label) ),
				'admin_label' => true,
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Type
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Type','dtdr'),
				'param_name' => 'type',
				'value' => array(
					esc_html__('Type 1', 'dtdr') => 'type1',
					esc_html__('Type 2', 'dtdr') => 'type2',
					esc_html__('Type 3', 'dtdr') => 'type3'
				),
				'description' => esc_html__( 'Choose one of the available type to display.', 'dtdr' ),
				'std' => 'type1',
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'admin_label' => true
			),

			// Content Type
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Content Type', 'dtdr'),
				'description' => esc_html__('Contact type that you like to display.', 'dtdr'),
				'param_name' => 'content_type',
				'value' => array(
					esc_html__( 'Post Author', 'dtdr' ) => 'author',
					sprintf( esc_html__('%1$s Included', 'dtdr'), $incharge_plural_label ) => 'incharges_included',
					esc_html__( 'Both', 'dtdr' ) => 'both',
				),
				'std' => 'list',
				'admin_label' => true,
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Columns
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Columns', 'dtdr'),
				'param_name' => 'columns',
				'value' => array(
							esc_html__('I Column', 'dtdr') => 1 ,
							esc_html__('II Columns', 'dtdr') => 2 ,
						),
				'description' => esc_html__( 'Number of columns you like to display for your authors.', 'dtdr' ),
				'std' => 1,
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Class
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Class', 'dtdr' ),
				'param_name' => 'class',
				'description' => esc_html__( 'If you wish you can add additional class name here.', 'dtdr' ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),


			// Carousel

			// Enable Carousel
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Enable Carousel', 'dtdr'),
				'description' => esc_html__('Choose "True" if you like to enable carousel for your authors.', 'dtdr'),
				'param_name' => 'enable_carousel',
				'value' => array(
					esc_html__( 'False', 'dtdr' ) => 'false',
					esc_html__( 'True', 'dtdr' ) => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'group' => 'Carousel',
			),

			// Carousel Pagination
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Carousel Pagination', 'dtdr'),
				'param_name' => 'carousel_pagination',
				'value' => array(
							esc_html__('None', 'dtdr') => '' ,
							esc_html__('Bullets', 'dtdr') => 'bullets' ,
							esc_html__('Arrows', 'dtdr') => 'arrows' ,
						),
				'description' => esc_html__( 'Choose one of the available paginations.', 'dtdr' ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'group' => 'Carousel',
			),

			// Carousel Pagination Type
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Carousel Pagination Type', 'dtdr'),
				'param_name' => 'carousel_pagination_type',
				'value' => array(
							esc_html__('Type 1', 'dtdr') => 'type1' ,
							esc_html__('Type 2', 'dtdr') => 'type2' ,
						),
				'description' => esc_html__( 'Choose one of the available pagination design types.', 'dtdr' ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'std' => 'type1',
				'group' => 'Carousel'
			),

			// Space Between Sliders
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Space Between Sliders','dtdr'),
				'param_name' => 'carousel_spacebetween',
				'description' => esc_html__( 'Space between sliders can be given here.', 'dtdr' ),
				'group' => 'Carousel',
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'std' => 20,
				'dependency' => array( 'element' => 'enable_carousel', 'value' => 'true'),
			)

		)
	) );
}
?>