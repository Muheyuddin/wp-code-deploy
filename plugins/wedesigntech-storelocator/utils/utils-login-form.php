<?php

// Login form

if(!function_exists('dtsl_login_form')) {
	function dtsl_login_form() {

		$redirect_url = (isset($_REQUEST['redirect_url']) && $_REQUEST['redirect_url'] != '') ? dtsl_recursive_sanitize_text_field($_REQUEST['redirect_url']) : home_url('/');

		$output = '<div class="dtsl-login-form-container">';

			$output .= '<div class="dtsl-login-form">';

				$output .= '<div class="dtsl-login-form-holder">';

					$output .= '<div class="dtsl-title dtsl-login-title"><h2><span>'.esc_html__('Welcome!', 'dtsl').'<strong>'.esc_html__('Login', 'dtsl').'</strong></span></h2></div>';
					$output .= wp_login_form(array ('redirect' => $redirect_url, 'echo' => false));
		    		$output .= '<p class="tpl-forget-pwd"><a href="'.wp_lostpassword_url( get_permalink() ).'">'.esc_html__('Forgot password ?','dtsl').'</a></p>';

				$output .= '</div>';

				$social_logins_module = apply_filters('dtsl_social_logins_module', array ());
				if(!empty($social_logins_module)) {
					$output .= $social_logins_module;
				}

			$output .= '</div>';

		$output .= '</div>';

		$output .= '<div class="dtsl-login-form-overlay"></div>';


		return $output;

	}
}

if(!function_exists('dtsl_show_login_form_popup')) {
	function dtsl_show_login_form_popup() {

		echo dtsl_login_form();

		die();

	}
	add_action( 'wp_ajax_dtsl_show_login_form_popup', 'dtsl_show_login_form_popup' );
	add_action( 'wp_ajax_nopriv_dtsl_show_login_form_popup', 'dtsl_show_login_form_popup' );
}

?>