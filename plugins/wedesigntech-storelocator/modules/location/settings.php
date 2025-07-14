<?php

function dtsl_settings_map_content() {

	$output = '';

	$output .= '<form name="formOptionSettings" class="formOptionSettings" method="post">';

		$output .= '<div class="dtsl-settings-options-holder">';
			$output .= '<label><strong>'.esc_html__( 'Map', 'dtsl') .'</strong></label>';
		$output .= '</div>';

		$output .= '<div class="dtsl-settings-options-holder">';
			$output .= '<div class="dtsl-column dtsl-one-fifth first">';
				$output .= '<label>'.esc_html__( 'Enable Auto Complete In Frontend Form Submission', 'dtsl') .'</label>';
			$output .= '</div>';
			$output .= '<div class="dtsl-column dtsl-four-fifth">';
				$checked = ( 'true' ==  dtsl_option('map','enable-autocomplete-frontend-formsubmission') ) ? ' checked="checked"' : '';
				$switchclass = ( 'true' ==  dtsl_option('map','enable-autocomplete-frontend-formsubmission') ) ? 'checkbox-switch-on' :'checkbox-switch-off';
				$output .= '<div data-for="enable-autocomplete-frontend-formsubmission" class="dtsl-checkbox-switch '.$switchclass.'"></div>';
				$output .= '<input id="enable-autocomplete-frontend-formsubmission" class="hidden" type="checkbox" name="dtsl[map][enable-autocomplete-frontend-formsubmission]" value="true" '.$checked.' />';
				$output .= '<div class="dtsl-note">'.esc_html__( 'You can enable google places auto complete for locations in frontend form submission.', 'dtsl' ).'</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtsl-settings-options-holder">';
			$output .= '<div class="dtsl-column dtsl-one-fifth first">';
				$output .= '<label>'.esc_html__( 'Enable SSL', 'dtsl') .'</label>';
			$output .= '</div>';
			$output .= '<div class="dtsl-column dtsl-four-fifth">';
                $checked = ( 'true' ==  dtsl_option('map','enable-ssl') ) ? ' checked="checked"' : '';
                $switchclass = ( 'true' ==  dtsl_option('map','enable-ssl') ) ? 'checkbox-switch-on' :'checkbox-switch-off';
	            $output .= '<div data-for="enable-ssl" class="dtsl-checkbox-switch '.$switchclass.'"></div>';
	            $output .= '<input id="enable-ssl" class="hidden" type="checkbox" name="dtsl[map][enable-ssl]" value="true" '.$checked.' />';
	            $output .= '<div class="dtsl-note">'.esc_html__( 'You can load map with SSL certificate.', 'dtsl' ).'</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtsl-settings-options-holder">';
			$output .= '<div class="dtsl-column dtsl-one-fifth first">';
				$output .= '<label>'.esc_html__( 'Google Map - API Key', 'dtsl' ).'</label>';
			$output .= '</div>';
			$output .= '<div class="dtsl-column dtsl-four-fifth">';
	            $googlemap_api_key = dtsl_option('map','googlemap-api-key');
	            $output .= '<input id="googlemap-api-key" name="dtsl[map][googlemap-api-key]" type="text" value="'.$googlemap_api_key.'" />';
	            $output .= '<div class="dtsl-note">'.esc_html__('Add your google map API key here.', 'dtsl').'</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtsl-settings-options-holder">';
			$output .= '<div class="dtsl-column dtsl-one-fifth first">';
				$output .= '<label>'.esc_html__('Map Language', 'dtsl').'</label>';
			$output .= '</div>';
			$output .= '<div class="dtsl-column dtsl-four-fifth">';

				$map_languages = array (
					'af' => 'Afrikaans',
					'sq' => 'Albanian',
					'am' => 'Amharic',
					'ar' => 'Arabic',
					'hy' => 'Armenian',
					'az' => 'Azerbaijani',
					'eu' => 'Basque',
					'be' => 'Belarusian',
					'bn' => 'Bengali',
					'bs' => 'Bosnian',
					'bg' => 'Bulgarian',
					'my' => 'Burmese',
					'ca' => 'Catalan',
					'zh' => 'Chinese',
					'zh-CN' => 'Chinese (Simplified)',
					'zh-HK' => 'Chinese (Hong Kong)',
					'zh-TW' => 'Chinese (Traditional)',
					'hr' => 'Croatian',
					'cs' => 'Czech',
					'da' => 'Danish',
					'nl' => 'Dutch',
					'en' => 'English',
					'en-AU' => 'English (Australian)',
					'en-GB' => 'English (Great Britain)',
					'et' => 'Estonian',
					'fa' => 'Farsi',
					'fi' => 'Finnish',
					'fil' => 'Filipino',
					'fr' => 'French',
					'fr-CA' => 'French (Canada)',
					'gl' => 'Galician',
					'ka' => 'Georgian',
					'de' => 'German',
					'el' => 'Greek',
					'gu' => 'Gujarati',
					'iw' => 'Hebrew',
					'hi' => 'Hindi',
					'hu' => 'Hungarian',
					'is' => 'Icelandic',
					'id' => 'Indonesian',
					'it' => 'Italian',
					'ja' => 'Japanese',
					'kn' => 'Kannada',
					'kk' => 'Kazakh',
					'km' => 'Khmer',
					'ko' => 'Korean',
					'ky' => 'Kyrgyz',
					'lo' => 'Lao',
					'lv' => 'Latvian',
					'lt' => 'Lithuanian',
					'mk' => 'Macedonian',
					'ms' => 'Malay',
					'ml' => 'Malayalam',
					'mr' => 'Marathi',
					'mn' => 'Mongolian',
					'ne' => 'Nepali',
					'no' => 'Norwegian',
					'pl' => 'Polish',
					'pt' => 'Portuguese',
					'pt-BR' => 'Portuguese (Brazil)',
					'pt-PT' => 'Portuguese (Portugal)',
					'pa' => 'Punjabi',
					'ro' => 'Romanian',
					'ru' => 'Russian',
					'sr' => 'Serbian',
					'si' => 'Sinhalese',
					'sk' => 'Slovak',
					'sl' => 'Slovenian',
					'es' => 'Spanish',
					'es-419' => 'Spanish (Latin America)',
					'sw' => 'Swahili',
					'sv' => 'Swedish',
					'ta' => 'Tamil',
					'te' => 'Telugu',
					'th' => 'Thai',
					'tr' => 'Turkish',
					'uk' => 'Ukrainian',
					'ur' => 'Urdu',
					'uz' => 'Uzbek',
					'vi' => 'Vietnamese',
					'zu' => 'Zulu'
				);
				$map_language_sel = dtsl_option('map','map-language');
				$map_language_sel = (isset($map_language_sel) && $map_language_sel != '') ? $map_language_sel : 'en';

	            $output .= '<select id="map-language" name="dtsl[map][map-language]" class="dtsl-chosen-select">';
					foreach($map_languages as $key => $map_language) {
						$output .= '<option value="'.$key.'" '.selected($key, $map_language_sel, false).'>';
							$output .= $map_language;
						$output .= '</option>';
					}
				$output .= '</select>';
	            $output .= '<div class="dtsl-note">'.esc_html__('Choose language for your map.', 'dtsl').'</div>';

			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtsl-settings-options-holder">';
			$output .= '<div class="dtsl-column dtsl-one-fifth first">';
				$output .= '<label>'.esc_html__( 'Default Latitude', 'dtsl' ).'</label>';
			$output .= '</div>';
			$output .= '<div class="dtsl-column dtsl-four-fifth">';
	            $default_latitude = dtsl_option('map','default-latitude');
	            $output .= '<input id="default-latitude" name="dtsl[map][default-latitude]" type="text" value="'.$default_latitude.'" />';
	            $output .= '<div class="dtsl-note">'.esc_html__('Provide default latitude value.', 'dtsl').'</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtsl-settings-options-holder">';
			$output .= '<div class="dtsl-column dtsl-one-fifth first">';
				$output .= '<label>'.esc_html__( 'Default Longitude', 'dtsl' ).'</label>';
			$output .= '</div>';
			$output .= '<div class="dtsl-column dtsl-four-fifth">';
	            $default_longitude = dtsl_option('map','default-longitude');
	            $output .= '<input id="default-longitude" name="dtsl[map][default-longitude]" type="text" value="'.$default_longitude.'" />';
	            $output .= '<div class="dtsl-note">'.esc_html__('Provide default longitude value.', 'dtsl').'</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtsl-settings-options-holder">';
			$output .= '<div class="dtsl-column dtsl-one-fifth first">';
				$output .= '<label>'.esc_html__( 'Default Zoom Level', 'dtsl' ).'</label>';
			$output .= '</div>';
			$output .= '<div class="dtsl-column dtsl-four-fifth">';
	            $default_zoom_level = dtsl_option('map','default-zoom-level');
	            $output .= '<input id="default-zoom-level" name="dtsl[map][default-zoom-level]" type="number" value="'.$default_zoom_level.'" min="1" max="20" />';
	            $output .= '<div class="dtsl-note">'.esc_html__('Add default zoom level here. Range - ( 1 to 20 )', 'dtsl').'</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtsl-settings-options-holder">';
			$output .= '<div class="dtsl-column dtsl-one-fifth first">';
				$output .= '<label>'.esc_html__('Default Map Type', 'dtsl').'</label>';
			$output .= '</div>';
			$output .= '<div class="dtsl-column dtsl-four-fifth">';

				$map_types = array ('SATELLITE','HYBRID','TERRAIN','ROADMAP');
				$default_map_type = dtsl_option('map','default-map-type');

	            $output .= '<select id="default-map-type" name="dtsl[map][default-map-type]" class="dtsl-chosen-select">';
					foreach($map_types as $map_type) {
						$output .= '<option value="'.$map_type.'" '.selected($map_type, $default_map_type, false).'>';
							$output .= $map_type;
						$output .= '</option>';
					}
				$output .= '</select>';
	            $output .= '<div class="dtsl-note">'.esc_html__('Choose deafult map type here.', 'dtsl').'</div>';

			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtsl-settings-options-holder">';
			$output .= '<div class="dtsl-column dtsl-one-fifth first">';
				$output .= '<label>'.esc_html__( 'Default Map Color', 'dtsl' ).'</label>';
			$output .= '</div>';
			$output .= '<div class="dtsl-column dtsl-four-fifth">';
	            $map_color = dtsl_option('map','default-map-color');
	            $output .= '<input id="default-map-color" name="dtsl[map][default-map-color]" class="dtsl-color-field color-picker" data-alpha="true" type="text" value="'.$map_color.'" />';
	            $output .= '<div class="dtsl-note">'.esc_html__('Choose map color', 'dtsl').'</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtsl-settings-options-holder">';
			$output .= '<div class="dtsl-column dtsl-one-fifth first">';
				$output .= '<label>'.esc_html__( 'Enable Map Type Control', 'dtsl') .'</label>';
			$output .= '</div>';
			$output .= '<div class="dtsl-column dtsl-four-fifth">';
                $checked = ( 'true' ==  dtsl_option('map','enable-maptype-control') ) ? ' checked="checked"' : '';
                $switchclass = ( 'true' ==  dtsl_option('map','enable-maptype-control') ) ? 'checkbox-switch-on' :'checkbox-switch-off';
	            $output .= '<div data-for="enable-maptype-control" class="dtsl-checkbox-switch '.$switchclass.'"></div>';
	            $output .= '<input id="enable-maptype-control" class="hidden" type="checkbox" name="dtsl[map][enable-maptype-control]" value="true" '.$checked.' />';
	            $output .= '<div class="dtsl-note">'.esc_html__( 'If you wish you can enable map type control here.', 'dtsl' ).'</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtsl-settings-options-holder">';
			$output .= '<div class="dtsl-column dtsl-one-fifth first">';
				$output .= '<label>'.esc_html__( 'Enable Zoom Control', 'dtsl') .'</label>';
			$output .= '</div>';
			$output .= '<div class="dtsl-column dtsl-four-fifth">';
                $checked = ( 'true' ==  dtsl_option('map','enable-zoom-control') ) ? ' checked="checked"' : '';
                $switchclass = ( 'true' ==  dtsl_option('map','enable-zoom-control') ) ? 'checkbox-switch-on' :'checkbox-switch-off';
	            $output .= '<div data-for="enable-zoom-control" class="dtsl-checkbox-switch '.$switchclass.'"></div>';
	            $output .= '<input id="enable-zoom-control" class="hidden" type="checkbox" name="dtsl[map][enable-zoom-control]" value="true" '.$checked.' />';
	            $output .= '<div class="dtsl-note">'.esc_html__( 'If you wish you can enable zoom control here.', 'dtsl' ).'</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtsl-settings-options-holder">';
			$output .= '<div class="dtsl-column dtsl-one-fifth first">';
				$output .= '<label>'.esc_html__( 'Enable Scale Control', 'dtsl') .'</label>';
			$output .= '</div>';
			$output .= '<div class="dtsl-column dtsl-four-fifth">';
                $checked = ( 'true' ==  dtsl_option('map','enable-scale-control') ) ? ' checked="checked"' : '';
                $switchclass = ( 'true' ==  dtsl_option('map','enable-scale-control') ) ? 'checkbox-switch-on' :'checkbox-switch-off';
	            $output .= '<div data-for="enable-scale-control" class="dtsl-checkbox-switch '.$switchclass.'"></div>';
	            $output .= '<input id="enable-scale-control" class="hidden" type="checkbox" name="dtsl[map][enable-scale-control]" value="true" '.$checked.' />';
	            $output .= '<div class="dtsl-note">'.esc_html__( 'If you wish you can enable scale control here.', 'dtsl' ).'</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtsl-settings-options-holder">';
			$output .= '<div class="dtsl-column dtsl-one-fifth first">';
				$output .= '<label>'.esc_html__( 'Enable Street View Control', 'dtsl') .'</label>';
			$output .= '</div>';
			$output .= '<div class="dtsl-column dtsl-four-fifth">';
                $checked = ( 'true' ==  dtsl_option('map','enable-streetview-control') ) ? ' checked="checked"' : '';
                $switchclass = ( 'true' ==  dtsl_option('map','enable-streetview-control') ) ? 'checkbox-switch-on' :'checkbox-switch-off';
	            $output .= '<div data-for="enable-streetview-control" class="dtsl-checkbox-switch '.$switchclass.'"></div>';
	            $output .= '<input id="enable-streetview-control" class="hidden" type="checkbox" name="dtsl[map][enable-streetview-control]" value="true" '.$checked.' />';
	            $output .= '<div class="dtsl-note">'.esc_html__( 'If you wish you can enable street view control here.', 'dtsl' ).'</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtsl-settings-options-holder">';
			$output .= '<div class="dtsl-column dtsl-one-fifth first">';
				$output .= '<label>'.esc_html__( 'Enable Fullscreen Control', 'dtsl') .'</label>';
			$output .= '</div>';
			$output .= '<div class="dtsl-column dtsl-four-fifth">';
                $checked = ( 'true' ==  dtsl_option('map','enable-fullscreen-control') ) ? ' checked="checked"' : '';
                $switchclass = ( 'true' ==  dtsl_option('map','enable-fullscreen-control') ) ? 'checkbox-switch-on' :'checkbox-switch-off';
	            $output .= '<div data-for="enable-fullscreen-control" class="dtsl-checkbox-switch '.$switchclass.'"></div>';
	            $output .= '<input id="enable-fullscreen-control" class="hidden" type="checkbox" name="dtsl[map][enable-fullscreen-control]" value="true" '.$checked.' />';
	            $output .= '<div class="dtsl-note">'.esc_html__( 'If you wish you can enable fullscreen control here.', 'dtsl' ).'</div>';
			$output .= '</div>';
		$output .= '</div>';


		$output .= '<div class="dtsl-settings-options-holder">';
			$output .= '<label><strong>'.esc_html__( 'Location', 'dtsl') .'</strong></label>';
		$output .= '</div>';

		$output .= '<div class="dtsl-settings-options-holder">';
			$output .= '<div class="dtsl-column dtsl-one-fifth first">';
				$output .= '<label>'.esc_html__( 'Enable Auto Complete In Frontend Form Submission', 'dtsl') .'</label>';
			$output .= '</div>';
			$output .= '<div class="dtsl-column dtsl-four-fifth">';
				$checked = ( 'true' ==  dtsl_option('map','enable-autocomplete-frontend-formsubmission') ) ? ' checked="checked"' : '';
				$switchclass = ( 'true' ==  dtsl_option('map','enable-autocomplete-frontend-formsubmission') ) ? 'checkbox-switch-on' :'checkbox-switch-off';
				$output .= '<div data-for="enable-autocomplete-frontend-formsubmission" class="dtsl-checkbox-switch '.$switchclass.'"></div>';
				$output .= '<input id="enable-autocomplete-frontend-formsubmission" class="hidden" type="checkbox" name="dtsl[map][enable-autocomplete-frontend-formsubmission]" value="true" '.$checked.' />';
				$output .= '<div class="dtsl-note">'.esc_html__( 'You can enable google places auto complete for locations in frontend form submission.', 'dtsl' ).'</div>';
			$output .= '</div>';
		$output .= '</div>';


		$output .= '<div class="dtsl-settings-options-holder">';
			$output .= '<label><strong>'.esc_html__( 'Permalinks', 'dtsl') .'</strong></label>';
		$output .= '</div>';

		$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );

		$output .= '<div class="dtsl-settings-options-holder">';
			$output .= '<div class="dtsl-column dtsl-one-fifth first">';
				$output .= '<label>'.sprintf( esc_html__( '%1$s City Slug', 'dtsl' ), $dt_sl_listing_singular_label ).'</label>';
			$output .= '</div>';
			$output .= '<div class="dtsl-column dtsl-four-fifth">';
	            $dtsl_listings_city_slug = dtsl_option('map','listing-city-slug');
	            $output .= '<input id="listing-city-slug" name="dtsl[map][listing-city-slug]" type="text" value="'.$dtsl_listings_city_slug.'" />';
	            $output .= '<div class="dtsl-note">'.esc_html__('Do not use characters not allowed in links. Use, eg. listing-city After change go to Settings > Permalinks and click Save changes.', 'dtsl').'</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtsl-settings-options-holder">';
			$output .= '<div class="dtsl-column dtsl-one-fifth first">';
				$output .= '<label>'.sprintf( esc_html__( '%1$s Neighborhood Slug', 'dtsl' ), $dt_sl_listing_singular_label ).'</label>';
			$output .= '</div>';
			$output .= '<div class="dtsl-column dtsl-four-fifth">';
	            $dtsl_listings_neighborhood_slug = dtsl_option('map','listing-neighborhood-slug');
	            $output .= '<input id="listing-neighborhood-slug" name="dtsl[map][listing-neighborhood-slug]" type="text" value="'.$dtsl_listings_neighborhood_slug.'" />';
	            $output .= '<div class="dtsl-note">'.esc_html__('Do not use characters not allowed in links. Use, eg. listing-neighborhood After change go to Settings > Permalinks and click Save changes.', 'dtsl').'</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtsl-settings-options-holder">';
			$output .= '<div class="dtsl-column dtsl-one-fifth first">';
				$output .= '<label>'.sprintf( esc_html__( '%1$s County / State Slug', 'dtsl' ), $dt_sl_listing_singular_label ).'</label>';
			$output .= '</div>';
			$output .= '<div class="dtsl-column dtsl-four-fifth">';
	            $dtsl_listings_countystate_slug = dtsl_option('map','listing-countystate-slug');
	            $output .= '<input id="listing-countystate-slug" name="dtsl[map][listing-countystate-slug]" type="text" value="'.$dtsl_listings_countystate_slug.'" />';
	            $output .= '<div class="dtsl-note">'.esc_html__('Do not use characters not allowed in links. Use, eg. listing-countystate After change go to Settings > Permalinks and click Save changes.', 'dtsl').'</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtsl-note">'.esc_html__('Do not use characters not allowed in links. Use, eg. courses After change go to Settings > Permalinks and click Save changes.', 'dtsl').'</div>';

		$output .= '<div class="dtsl-option-settings-response-holder"></div>';

		$output .= '<a href="#" class="custom-button-style dtsl-save-options-settings" data-settings="map">'.esc_html__('Save Settings', 'dtsl').'</a>';

	$output .= '</form>';

	return $output;

}

echo dtsl_settings_map_content();

?>