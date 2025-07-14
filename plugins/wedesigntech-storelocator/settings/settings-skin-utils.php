<?php

function dtsl_settings_skin_content() {

	$output = '';

	$skin_settings = get_option('dtsl-skin-settings');

	$primary_color = ( isset($skin_settings['primary-color']) && '' !=  $skin_settings['primary-color'] ) ? $skin_settings['primary-color'] : '#1e306e';
	$secondary_color = ( isset($skin_settings['secondary-color']) && '' !=  $skin_settings['secondary-color'] ) ? $skin_settings['secondary-color'] : '#2fa5fb';
	$tertiary_color = ( isset($skin_settings['tertiary-color']) && '' !=  $skin_settings['tertiary-color'] ) ? $skin_settings['tertiary-color'] : '#d2edf8';

	$primary_alternate_color = ( isset($skin_settings['primary-alternate-color']) && '' !=  $skin_settings['primary-alternate-color'] ) ? $skin_settings['primary-alternate-color'] : '';
	$secondary_alternate_color = ( isset($skin_settings['secondary-alternate-color']) && '' !=  $skin_settings['secondary-alternate-color'] ) ? $skin_settings['secondary-alternate-color'] : '';
	$tertiary_alternate_color = ( isset($skin_settings['tertiary-alternate-color']) && '' !=  $skin_settings['tertiary-alternate-color'] ) ? $skin_settings['tertiary-alternate-color'] : '';


	$output .= '<form name="formSkinSettings" class="formSkinSettings" method="post">';

		$output .= '<div class="dtsl-note">'.esc_html__('Following colors will be used as default colors for "DesignThemes Store Locator Addon".', 'dtsl').'</div>';

		$output .= '<div class="dtsl-column dtsl-one-third first">';
			$output .= '<div class="dtsl-settings-options-holder">';
				$output .= '<div class="dtsl-column dtsl-one-fifth first">';
					$output .= '<label>'.esc_html__( 'Primary Color', 'dtsl' ).'</label>';
				$output .= '</div>';
				$output .= '<div class="dtsl-column dtsl-four-fifth">';
		            $output .= '<input name="dtsl-skin-settings[primary-color]" class="dtsl-color-field color-picker" data-alpha="true" type="text" value="'.$primary_color.'" />';
		            $output .= '<div class="dtsl-note">'.esc_html__('Choose primary color module skin.', 'dtsl').'</div>';
				$output .= '</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtsl-column dtsl-one-third">';
			$output .= '<div class="dtsl-settings-options-holder">';
				$output .= '<div class="dtsl-column dtsl-one-fifth first">';
					$output .= '<label>'.esc_html__( 'Secondary Color', 'dtsl' ).'</label>';
				$output .= '</div>';
				$output .= '<div class="dtsl-column dtsl-four-fifth">';
		            $output .= '<input name="dtsl-skin-settings[secondary-color]" class="dtsl-color-field color-picker" data-alpha="true" type="text" value="'.$secondary_color.'" />';
		            $output .= '<div class="dtsl-note">'.esc_html__('Choose secondary color module skin.', 'dtsl').'</div>';
				$output .= '</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtsl-column dtsl-one-third">';
			$output .= '<div class="dtsl-settings-options-holder">';
				$output .= '<div class="dtsl-column dtsl-one-fifth first">';
					$output .= '<label>'.esc_html__( 'Tertiary Color', 'dtsl' ).'</label>';
				$output .= '</div>';
				$output .= '<div class="dtsl-column dtsl-four-fifth">';
		            $output .= '<input name="dtsl-skin-settings[tertiary-color]" class="dtsl-color-field color-picker" data-alpha="true" type="text" value="'.$tertiary_color.'" />';
		            $output .= '<div class="dtsl-note">'.esc_html__('Choose tertiary color module skin.', 'dtsl').'</div>';
				$output .= '</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtsl-hr-invisible"></div>';

		$output .= '<div class="dtsl-skin-settings-response-holder"></div>';

		$output .= '<a href="#" class="custom-button-style dtsl-save-skin-settings">'.esc_html__('Save Settings', 'dtsl').'</a>';

	$output .= '</form>';

    echo dtsl_html_output($output);

}

echo dtsl_settings_skin_content();

?>