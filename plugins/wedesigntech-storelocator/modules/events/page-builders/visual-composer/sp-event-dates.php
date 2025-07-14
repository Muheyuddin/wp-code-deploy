<?php
add_action( 'vc_before_init', 'dtsl_sp_event_dates_vc_map' );

function dtsl_sp_event_dates_vc_map() {

	$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );

	vc_map( array(
		"name" => esc_html__( 'Event Dates', 'dtsl' ),
		"base" => "dtsl_sp_event_dates",
		"icon" => "dtsl_sp_event_dates",
		"category" => DTSL_PB_MODULE_SINGLEPAGE_TITLE,
		"params" => array(

			// Listing Id
			array(
				'type' => 'textfield',
				'heading' => sprintf( esc_html__('%1$s Id', 'dtsl'), $dt_sl_listing_singular_label ),
				'param_name' => 'listing_id',
				'description' => sprintf( esc_html__('Provide %1$s id for which you have to display dates. No need to provide ID if it is used in %1$s single page.', 'dtsl'), strtolower($dt_sl_listing_singular_label) ),
				'admin_label' => true
			),

			// Type
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Type','dtsl'),
				'param_name' => 'type',
				'value' => array(
					esc_html__('Type 1', 'dtsl') => 'type1',
					esc_html__('Type 2', 'dtsl') => 'type2',
					esc_html__('Type 3', 'dtsl') => 'type3',
					esc_html__('Type 4', 'dtsl') => 'type4',
					esc_html__('Type 5', 'dtsl') => 'type5'
				),
				'description' => esc_html__( 'Choose any of the available type.', 'dtsl' ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'admin_label' => true,
				'admintype_label' => 'type1'
			),

			// Include Start Date
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Include Start Date', 'dtsl'),
				'description' => esc_html__('Choose "True" if you like to display start date in this shortcode. If "Merge Date" option is chosen "Start Date" will be included automatically.', 'dtsl'),
				'param_name' => 'include_startdate',
				'value' => array(
					esc_html__( 'False', 'dtsl' ) => 'false',
					esc_html__( 'True', 'dtsl' ) => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Include End Date
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Include End Date', 'dtsl'),
				'description' => esc_html__('Choose "True" if you like to display end date in this shortcode. If "Merge Date" option is chosen "End Date" will be included automatically.', 'dtsl'),
				'param_name' => 'include_enddate',
				'value' => array(
					esc_html__( 'False', 'dtsl' ) => 'false',
					esc_html__( 'True', 'dtsl' ) => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Include Start Time
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Include Start Time', 'dtsl'),
				'description' => esc_html__('Choose "True" if you like to display start time along with date.', 'dtsl'),
				'param_name' => 'include_starttime',
				'value' => array(
					esc_html__( 'False', 'dtsl' ) => 'false',
					esc_html__( 'True', 'dtsl' ) => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Include End Time
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Include End Time', 'dtsl'),
				'description' => esc_html__('Choose "True" if you like to display end time along with date.', 'dtsl'),
				'param_name' => 'include_endtime',
				'value' => array(
					esc_html__( 'False', 'dtsl' ) => 'false',
					esc_html__( 'True', 'dtsl' ) => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Include Post Date
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Include Post Date', 'dtsl'),
				'description' => esc_html__('Choose "True" if you like to display post date in this shortcode.', 'dtsl'),
				'param_name' => 'include_postdate',
				'value' => array(
					esc_html__( 'False', 'dtsl' ) => 'false',
					esc_html__( 'True', 'dtsl' ) => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Include Post Time
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Include Post Time', 'dtsl'),
				'description' => esc_html__('Choose "True" if you like to display post time along with date.', 'dtsl'),
				'param_name' => 'include_posttime',
				'value' => array(
					esc_html__( 'False', 'dtsl' ) => 'false',
					esc_html__( 'True', 'dtsl' ) => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// With Label
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('With Label', 'dtsl'),
				'description' => esc_html__('Choose "True" if you like to display label along with date.', 'dtsl'),
				'param_name' => 'with_label',
				'value' => array(
					esc_html__( 'False', 'dtsl' ) => 'false',
					esc_html__( 'True', 'dtsl' ) => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// With Icon
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('With Icon', 'dtsl'),
				'description' => esc_html__('Choose "True" if you like to display icon along with date.', 'dtsl'),
				'param_name' => 'with_icon',
				'value' => array(
					esc_html__( 'False', 'dtsl' ) => 'false',
					esc_html__( 'True', 'dtsl' ) => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Merge Dates
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Merge Dates', 'dtsl'),
				'description' => esc_html__('Choose "True" if you like to merge start and end dates.', 'dtsl'),
				'param_name' => 'merge_dates',
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
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

		)
	) );
}
?>