<?php
add_action( 'vc_before_init', 'dtsl_listings_taxonomy_vc_map' );

function dtsl_listings_taxonomy_vc_map() {

	$dt_sl_listing_singular_label      = apply_filters( 'dt_sl_listing_label', 'singular' );
	$listing_plural_label        = apply_filters( 'dt_sl_listing_label', 'plural' );

	$taxonomies = apply_filters( 'dtsl_taxonomies', array () );
	$taxonomies = array_flip($taxonomies);

	vc_map( array(
		"name" => sprintf( esc_html__('%1$s Taxonomy', 'dtsl'), $listing_plural_label ),
		"base" => "dtsl_listings_taxonomy",
		"icon" => "dtsl_listings_taxonomy",
		"category" => DTSL_PB_MODULE_DEFAULT_TITLE,
		"params" => array(

			// Taxonomy
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Taxonomy','dtsl'),
				'param_name' => 'taxonomy',
				'value' => $taxonomies,
				'description' => esc_html__( 'Choose type of taxonomy you would like to display.', 'dtsl' ),
				'std' => 'dtsl_listings_category',
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'admin_label' => true
			),

			// Type
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Type','dtsl'),
				'param_name' => 'type',
				'value' => array(
					esc_html__('Type 1', 'dtsl')  => 'type1',
					esc_html__('Type 2', 'dtsl')  => 'type2',
					esc_html__('Type 3', 'dtsl')  => 'type3',
					esc_html__('Type 4', 'dtsl')  => 'type4',
					esc_html__('Type 5', 'dtsl')  => 'type5',
					esc_html__('Type 6', 'dtsl')  => 'type6',
					esc_html__('Type 7', 'dtsl')  => 'type7',
				),
				'description' => esc_html__( 'Choose type of taxonomy to display.', 'dtsl' ),
				'std' => 'type1',
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'admin_label' => true
			),

			// Image or Icon
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Media Type','dtsl'),
				'param_name' => 'media_type',
				'value' => array(
					esc_html__('Image', 'dtsl')      => 'image',
					esc_html__('Icon', 'dtsl')       => 'icon',
					esc_html__('Icon Image', 'dtsl') => 'icon_image'
				),
				'description' => esc_html__( 'Choose whether to display image or icon.', 'dtsl' ),
				'std' => 'image',
				'dependency' => array( 'element' => 'type', 'value' => array ('type1', 'type2', 'type3', 'type4') ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'admin_label' => true
			),

			// Columns
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Columns', 'dtsl'),
				'param_name' => 'columns',
				'value' => array(
							esc_html__('None', 'dtsl') => '' ,
							esc_html__('I Column', 'dtsl') => 1 ,
							esc_html__('II Columns', 'dtsl') => 2 ,
							esc_html__('III Columns', 'dtsl') => 3,
						),
				'description' => esc_html__( 'Number of columns you like to display your taxonomies.', 'dtsl' ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'std' => ''
			),

			// Include
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Include', 'dtsl' ),
				'param_name' => 'include',
				'description' => esc_html__( 'List of taxonomy ids separated by commas.', 'dtsl' ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Show Parent Items Alone
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show Parent Items Alone','dtsl'),
				'param_name' => 'show_parent_items_alone',
				'value' => array(
					esc_html__( 'False', 'dtsl' ) => 'false',
					esc_html__( 'True', 'dtsl' ) => 'true',
				),
				'description' => esc_html__( 'If you like to show parent items alone choose "True".', 'dtsl' ),
				'std' => 'false',
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Child Of
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Child Of', 'dtsl' ),
				'param_name' => 'child_of',
				'description' => esc_html__( 'If you like to show child of any parent item, provide id of your taxonomy here.', 'dtsl' ),
				'dependency' => array( 'element' => 'show_parent_items_alone', 'value' => 'false' ),
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

		)
	) );
}
?>