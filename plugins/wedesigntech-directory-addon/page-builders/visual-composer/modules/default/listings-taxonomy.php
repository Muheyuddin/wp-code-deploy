<?php
add_action( 'vc_before_init', 'dtdr_listings_taxonomy_vc_map' );

function dtdr_listings_taxonomy_vc_map() {

	$listing_singular_label      = apply_filters( 'listing_label', 'singular' );
	$listing_plural_label        = apply_filters( 'listing_label', 'plural' );

	$taxonomies = apply_filters( 'dtdr_taxonomies', array () );
	$taxonomies = array_flip($taxonomies);

	vc_map( array(
		"name" => sprintf( esc_html__('%1$s Taxonomy', 'dtdr'), $listing_plural_label ),
		"base" => "dtdr_listings_taxonomy",
		"icon" => "dtdr_listings_taxonomy",
		"category" => DTDR_PB_MODULE_DEFAULT_TITLE,
		"params" => array(

			// Taxonomy
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Taxonomy','dtdr'),
				'param_name' => 'taxonomy',
				'value' => $taxonomies,
				'description' => esc_html__( 'Choose type of taxonomy you would like to display.', 'dtdr' ),
				'std' => 'dtdr_listings_category',
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'admin_label' => true
			),

			// Type
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Type','dtdr'),
				'param_name' => 'type',
				'value' => array(
					esc_html__('Type 1', 'dtdr')  => 'type1',
					esc_html__('Type 2', 'dtdr')  => 'type2',
					esc_html__('Type 3', 'dtdr')  => 'type3',
					esc_html__('Type 4', 'dtdr')  => 'type4',
					esc_html__('Type 5', 'dtdr')  => 'type5',
					esc_html__('Type 6', 'dtdr')  => 'type6',
					esc_html__('Type 7', 'dtdr')  => 'type7',
				),
				'description' => esc_html__( 'Choose type of taxonomy to display.', 'dtdr' ),
				'std' => 'type1',
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'admin_label' => true
			),

			// Image or Icon
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Media Type','dtdr'),
				'param_name' => 'media_type',
				'value' => array(
					esc_html__('Image', 'dtdr')      => 'image',
					esc_html__('Icon', 'dtdr')       => 'icon',
					esc_html__('Icon Image', 'dtdr') => 'icon_image'
				),
				'description' => esc_html__( 'Choose whether to display image or icon.', 'dtdr' ),
				'std' => 'image',
				'dependency' => array( 'element' => 'type', 'value' => array ('type1', 'type2', 'type3', 'type4') ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'admin_label' => true
			),

			// Columns
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Columns', 'dtdr'),
				'param_name' => 'columns',
				'value' => array(
							esc_html__('None', 'dtdr') => '' ,
							esc_html__('I Column', 'dtdr') => 1 ,
							esc_html__('II Columns', 'dtdr') => 2 ,
							esc_html__('III Columns', 'dtdr') => 3,
						),
				'description' => esc_html__( 'Number of columns you like to display your taxonomies.', 'dtdr' ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'std' => ''
			),

			// Include
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Include', 'dtdr' ),
				'param_name' => 'include',
				'description' => esc_html__( 'List of taxonomy ids separated by commas.', 'dtdr' ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Show Parent Items Alone
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show Parent Items Alone','dtdr'),
				'param_name' => 'show_parent_items_alone',
				'value' => array(
					esc_html__( 'False', 'dtdr' ) => 'false',
					esc_html__( 'True', 'dtdr' ) => 'true',
				),
				'description' => esc_html__( 'If you like to show parent items alone choose "True".', 'dtdr' ),
				'std' => 'false',
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Child Of
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Child Of', 'dtdr' ),
				'param_name' => 'child_of',
				'description' => esc_html__( 'If you like to show child of any parent item, provide id of your taxonomy here.', 'dtdr' ),
				'dependency' => array( 'element' => 'show_parent_items_alone', 'value' => 'false' ),
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

		)
	) );
}
?>