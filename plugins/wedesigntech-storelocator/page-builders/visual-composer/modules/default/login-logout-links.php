<?php
add_action( 'vc_before_init', 'dtsl_login_logout_links_vc_map' );

function dtsl_login_logout_links_vc_map() {
	vc_map( array(
		"name" => esc_html__( 'Login / Logout Links', 'dtsl' ),
		"base" => "dtsl_login_logout_links",
		"icon" => "dtsl_login_logout_links",
		"category" => DTSL_PB_MODULE_DEFAULT_TITLE,
		"params" => array(

			// Class
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Class', 'dtsl' ),
				'param_name' => 'class',
				'description' => esc_html__( 'If you wish you can add additional class name here.', 'dtsl' ),
				'admin_label' => true
			),

		)
	) );
}
?>