<?php 
add_action( 'vc_before_init', 'dtdr_sp_countdown_timer_vc_map' );

function dtdr_sp_countdown_timer_vc_map() {

	$listing_singular_label = apply_filters( 'listing_label', 'singular' );

	vc_map( array(
		"name" => esc_html__( 'Countdown Timer', 'dtdr' ),
		"base" => "dtdr_sp_countdown_timer",
		"icon" => "dtdr_sp_countdown_timer",
		"category" => DTDR_PB_MODULE_SINGLEPAGE_TITLE,
		"params" => array(

			// Listing Id
			array(
				'type' => 'textfield',
				'heading' => sprintf( esc_html__('%1$s Id', 'dtdr'), $listing_singular_label ),
				'param_name' => 'listing_id',
				'description' => sprintf( esc_html__('Provide %1$s id for which you have to display dates. No need to provide ID if it is used in %1$s single page.', 'dtdr'), strtolower($listing_singular_label) ),
				'admin_label' => true
			),

			// Type
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Type','dtdr'),
				'param_name' => 'type',
				'value' => array(
					esc_html__('Type 1', 'dtdr') => 'type1',
					esc_html__('Type 2', 'dtdr') => 'type2'
				),
				'description' => esc_html__( 'Choose any of the available type.', 'dtdr' ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'admin_label' => true,
				'admintype_label' => 'type1'
			),

			// Timer For
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Timer For', 'dtdr'),
				'description' => esc_html__('Choose for which you like to have timer.', 'dtdr'),
				'param_name' => 'timer_for',
				'value' => array(
					esc_html__( 'Start Date', 'dtdr' ) => 'start-date',
					esc_html__( 'End Date', 'dtdr' ) => 'end-date',
				),
				'std' => 'start-date',
			),		

			// Include Time
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Include Time', 'dtdr'),
				'description' => esc_html__('Choose "True" if you like to include time along with date.', 'dtdr'),
				'param_name' => 'include_time',
				'value' => array(
					esc_html__( 'False', 'dtdr' ) => 'false',
					esc_html__( 'True', 'dtdr' ) => 'true',
				),
			),

			// Disable Shortcode Section
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Disable Shortcode Section', 'dtdr'),
				'description' => esc_html__('Choose "True" if you like to disable this shortcode section completely on countdown timer completion.', 'dtdr'),
				'param_name' => 'disable_shortcode_section',
				'value' => array(
					esc_html__( 'False', 'dtdr' ) => 'false',
					esc_html__( 'True', 'dtdr' ) => 'true',
				),
			),			

			// Countdown Completed Text
			array(
				'type' => 'textarea_html',
				'heading' => esc_html__('Countdown Completed Text', 'dtdr'),
				'description' => esc_html__('Add text that you like to display on countdown completion.', 'dtdr'),
				'param_name' => 'countdown_completed_text',
			),									

			// Class
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Class', 'dtdr' ),
				'param_name' => 'class',
				'description' => esc_html__( 'If you wish you can add additional class name here.', 'dtdr' ),				
			),			

		)
	) );
}
?>