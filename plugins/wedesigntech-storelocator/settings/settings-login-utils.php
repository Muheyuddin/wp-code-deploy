<?php

function dtsl_settings_login_content() {

	$seller_singular_label = apply_filters( 'dt_sl_seller_label', 'singular' );
	$incharge_singular_label = apply_filters( 'dt_sl_incharge_label', 'singular' );

	$output = '';

	$output .= '<form name="formOptionSettings" class="formOptionSettings" method="post">';

		$output .= '<div class="dtsl-settings-options-holder">';
			$output .= '<div class="dtsl-column dtsl-one-fifth first">';
				$output .= '<label>'.sprintf( esc_html__( '%1$s Login Redirect Page', 'dtsl' ), $seller_singular_label ).'</label>';
			$output .= '</div>';
			$output .= '<div class="dtsl-column dtsl-four-fifth">';

				$seller_login_redirect_page = dtsl_option('login','seller-login-redirect-page');

				$seller_login_redirectpages = array (
					'homeurl'   => esc_html__('Home', 'dtsl')
				);
				$seller_login_redirectpages = apply_filters( 'seller_login_redirect_pages', $seller_login_redirectpages );

				$output .= '<select id="seller-login-redirect-page" name="dtsl[login][seller-login-redirect-page]" class="dtsl-chosen-select">';

					if(is_array($seller_login_redirectpages) && !empty($seller_login_redirectpages)) {
						foreach($seller_login_redirectpages as $key => $seller_login_redirectpage) {
							$output .= '<option value="'.$key.'" '.selected($key, $seller_login_redirect_page, false ).'>';
								$output .= $seller_login_redirectpage;
							$output .= '</option>';
						}
					}

				$output .= '</select>';
	            $output .= '<div class="dtsl-note">'.sprintf( esc_html__( 'You can choose %1$s login redirect page. Default is home page.', 'dtsl' ), $seller_singular_label ).'</div>';

			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtsl-settings-options-holder">';
			$output .= '<div class="dtsl-column dtsl-one-fifth first">';
				$output .= '<label>'.sprintf( esc_html__( '%1$s Login Redirect Page', 'dtsl' ), $incharge_singular_label ).'</label>';
			$output .= '</div>';
			$output .= '<div class="dtsl-column dtsl-four-fifth">';

				$incharge_login_redirect_page = dtsl_option('login','incharge-login-redirect-page');

				$incharge_login_redirectpages = array (
					'homeurl'   => esc_html__('Home', 'dtsl')
				);
				$incharge_login_redirectpages = apply_filters( 'incharge_login_redirect_pages', $incharge_login_redirectpages );

				$output .= '<select id="incharge-login-redirect-page" name="dtsl[login][incharge-login-redirect-page]" class="dtsl-chosen-select">';

					if(is_array($incharge_login_redirectpages) && !empty($incharge_login_redirectpages)) {
						foreach($incharge_login_redirectpages as $key => $incharge_login_redirectpage) {
							$output .= '<option value="'.$key.'" '.selected($key, $incharge_login_redirect_page, false ).'>';
								$output .= $incharge_login_redirectpage;
							$output .= '</option>';
						}
					}

				$output .= '</select>';
	            $output .= '<div class="dtsl-note">'.sprintf( esc_html__( 'You can choose %1$s login redirect page. Default is home page.', 'dtsl' ), $incharge_singular_label ).'</div>';

			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtsl-option-settings-response-holder"></div>';

		$output .= '<a href="#" class="custom-button-style dtsl-save-options-settings" data-settings="login">'.esc_html__('Save Settings', 'dtsl').'</a>';

	$output .= '</form>';

	return $output;

}

echo dtsl_settings_login_content();

?>