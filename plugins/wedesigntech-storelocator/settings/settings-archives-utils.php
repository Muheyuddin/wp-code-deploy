<?php

function dtsl_settings_archives_content() {

 	$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );

	$output = '';

	$output .= '<form name="formOptionSettings" class="formOptionSettings" method="post">';

		$output .= '<div class="dtsl-settings-options-holder">';
			$output .= '<div class="dtsl-column dtsl-one-fifth first">';
				$output .= '<label>'.esc_html__('Types', 'dtsl').'</label>';
			$output .= '</div>';
			$output .= '<div class="dtsl-column dtsl-four-fifth">';

				$archive_page_type = dtsl_option('archives','archive-page-type');

				$archive_types = array (
									'type1' => esc_html__('Type 1', 'dtsl'),
									'type2' => esc_html__('Type 2', 'dtsl'),
									'type3' => esc_html__('Type 3', 'dtsl'),
									'type4' => esc_html__('Type 4', 'dtsl'),
									'type5' => esc_html__('Type 5', 'dtsl'),
									'type6' => esc_html__('Type 6', 'dtsl'),
									'type7' => esc_html__('Type 7', 'dtsl'),
									'type8' => esc_html__('Type 8', 'dtsl'),
									'type9' => esc_html__('Type 9', 'dtsl'),
									'type10' => esc_html__('Type 10', 'dtsl')
								);

				$output .= '<select name="dtsl[archives][archive-page-type]" class="dtsl-chosen-select">';

					if(is_array($archive_types) && !empty($archive_types)) {
						foreach($archive_types as $key => $archive_type) {
							$output .= '<option value="'.$key.'" '.selected($key, $archive_page_type, false ).'>';
								$output .= $archive_type;
							$output .= '</option>';
						}
					}

				$output .= '</select>';

				$output .= '<div class="dtsl-note">'.sprintf( esc_html__('Choose type for your %1$s archive pages.', 'dtsl'), strtolower($dt_sl_listing_singular_label) ).'</div>';

			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtsl-settings-options-holder">';
			$output .= '<div class="dtsl-column dtsl-one-fifth first">';
				$output .= '<label>'.esc_html__('Gallery', 'dtsl').'</label>';
			$output .= '</div>';
			$output .= '<div class="dtsl-column dtsl-four-fifth">';

				$archive_page_gallery = dtsl_option('archives','archive-page-gallery');

				$archive_galleries = array (
										'featured_image'        => esc_html__('Featured Image', 'dtsl'),
										'image_gallery'         => esc_html__('Image Gallery', 'dtsl'),
										'gallery_with_featured' => esc_html__('Image Gallery With Featured Image', 'dtsl')
									);

				$output .= '<select name="dtsl[archives][archive-page-gallery]" class="dtsl-chosen-select">';

					if(is_array($archive_galleries) && !empty($archive_galleries)) {
						foreach($archive_galleries as $key => $archive_gallery) {
							$output .= '<option value="'.$key.'" '.selected($key, $archive_page_gallery, false ).'>';
								$output .= $archive_gallery;
							$output .= '</option>';
						}
					}

				$output .= '</select>';

				$output .= '<div class="dtsl-note">'.sprintf( esc_html__('Choose gallery type for your %1$s archive pages.', 'dtsl'), strtolower($dt_sl_listing_singular_label) ).'</div>';

			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtsl-settings-options-holder">';
			$output .= '<div class="dtsl-column dtsl-one-fifth first">';
				$output .= '<label>'.esc_html__('Columns', 'dtsl').'</label>';
			$output .= '</div>';
			$output .= '<div class="dtsl-column dtsl-four-fifth">';

				$archive_page_column = dtsl_option('archives','archive-page-column');

				$archive_columns = array (
										1  => esc_html__('I Column', 'dtsl'),
										2  => esc_html__('II Columns', 'dtsl'),
										3  => esc_html__('III Columns', 'dtsl')
									);

				$output .= '<select name="dtsl[archives][archive-page-column]" class="dtsl-chosen-select">';

					if(is_array($archive_columns) && !empty($archive_columns)) {
						foreach($archive_columns as $key => $archive_column) {
							$output .= '<option value="'.$key.'" '.selected($key, $archive_page_column, false ).'>';
								$output .= $archive_column;
							$output .= '</option>';
						}
					}

				$output .= '</select>';

				$output .= '<div class="dtsl-note">'.sprintf( esc_html__('Choose column for your %1$s archive pages.', 'dtsl'), strtolower($dt_sl_listing_singular_label) ).'</div>';

			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtsl-settings-options-holder">';
			$output .= '<div class="dtsl-column dtsl-one-fifth first">';
				$output .= '<label>'.esc_html__( 'Apply Isotope', 'dtsl' ).'</label>';
			$output .= '</div>';
			$output .= '<div class="dtsl-column dtsl-four-fifth">';
				$checked = ( 'true' ==  dtsl_option('archives', 'archive-page-apply-isotope') ) ? ' checked="checked"' : '';
				$switchclass = ( 'true' ==  dtsl_option('archives', 'archive-page-apply-isotope') ) ? 'checkbox-switch-on' :'checkbox-switch-off';
				$output .= '<div data-for="archive-page-apply-isotope" class="dtsl-checkbox-switch '.$switchclass.'"></div>';
				$output .= '<input id="archive-page-apply-isotope" class="hidden" type="checkbox" name="dtsl[archives][archive-page-apply-isotope]" value="true" '.$checked.' />';
				$output .= '<div class="dtsl-note">'.sprintf( esc_html__('If you like to apply isotope for your %1$s archive pages, check this options.', 'dtsl'), strtolower($dt_sl_listing_singular_label) ).'</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtsl-settings-options-holder">';
			$output .= '<div class="dtsl-column dtsl-one-fifth first">';
				$output .= '<label>'.esc_html__( 'Excerpt Length', 'dtsl' ).'</label>';
			$output .= '</div>';
			$output .= '<div class="dtsl-column dtsl-four-fifth">';
				$archive_page_excerpt_length = dtsl_option('archives','archive-page-excerpt-length');
				$output .= '<input id="archive-page-excerpt-length" name="dtsl[archives][archive-page-excerpt-length]" type="number" value="'.$archive_page_excerpt_length.'" min="1" max="2000" step="1"  />';
				$output .= '<div class="dtsl-note">'.sprintf( esc_html__('Provide excerpt length for your %1$s archive pages.', 'dtsl'), strtolower($dt_sl_listing_singular_label) ).'</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtsl-settings-options-holder">';
			$output .= '<div class="dtsl-column dtsl-one-fifth first">';
				$output .= '<label>'.esc_html__('Features Image or Icon', 'dtsl').'</label>';
			$output .= '</div>';
			$output .= '<div class="dtsl-column dtsl-four-fifth">';

				$archive_page_features_image_or_icon = dtsl_option('archives','archive-page-features-image-or-icon');

				$archive_features_image_or_icons = array (
										''      => esc_html__('None', 'dtsl'),
										'image' => esc_html__('Image', 'dtsl'),
										'icon'  => esc_html__('Icon', 'dtsl')
									);

				$output .= '<select name="dtsl[archives][archive-page-features-image-or-icon]" class="dtsl-chosen-select">';

					if(is_array($archive_features_image_or_icons) && !empty($archive_features_image_or_icons)) {
						foreach($archive_features_image_or_icons as $key => $archive_features_image_or_icon) {
							$output .= '<option value="'.$key.'" '.selected($key, $archive_page_features_image_or_icon, false ).'>';
								$output .= $archive_features_image_or_icon;
							$output .= '</option>';
						}
					}

				$output .= '</select>';

				$output .= '<div class="dtsl-note">'.sprintf( esc_html__('Choose features image or icon to use for your %1$s archive pages. This option won\'t work for "Type 7" & "Type 10".', 'dtsl'), strtolower($dt_sl_listing_singular_label) ).'</div>';

			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtsl-settings-options-holder">';
			$output .= '<div class="dtsl-column dtsl-one-fifth first">';
				$output .= '<label>'.esc_html__( 'Features Include', 'dtsl' ).'</label>';
			$output .= '</div>';
			$output .= '<div class="dtsl-column dtsl-four-fifth">';
				$archive_page_features_include = dtsl_option('archives','archive-page-features-include');
				$output .= '<input id="archive-page-features-include" name="dtsl[archives][archive-page-features-include]" type="text" value="'.$archive_page_features_include.'" />';
				$output .= '<div class="dtsl-note">'.esc_html__('Give features id separated by comma. Only 4 maximum number of features allowed. This option won\'t work for "Type 7" & "Type 10".', 'dtsl').'</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtsl-settings-options-holder">';
			$output .= '<div class="dtsl-column dtsl-one-fifth first">';
				$output .= '<label>'.esc_html__('No. Of Categories to Display', 'dtsl').'</label>';
			$output .= '</div>';
			$output .= '<div class="dtsl-column dtsl-four-fifth">';

				$archive_page_noofcat = dtsl_option('archives','archive-page-noofcat-to-display');

				$archive_noofcats = array (
										1  => 1,
										2  => 2,
										3  => 3,
										4  => 4
									);

				$output .= '<select name="dtsl[archives][archive-page-noofcat-to-display]" class="dtsl-chosen-select">';

					if(is_array($archive_noofcats) && !empty($archive_noofcats)) {
						foreach($archive_noofcats as $key => $archive_noofcat) {
							$output .= '<option value="'.$key.'" '.selected($key, $archive_page_noofcat, false ).'>';
								$output .= $archive_noofcat;
							$output .= '</option>';
						}
					}

				$output .= '</select>';

				$output .= '<div class="dtsl-note">'.esc_html__( 'Number of categories you like to display on your items.', 'dtsl' ).'</div>';

			$output .= '</div>';
		$output .= '</div>';



		$output .= '<div class="dtsl-note">'.esc_html__('This setting is applicable for all archive pages.', 'dtsl').'</div>';

		$output .= '<div class="dtsl-option-settings-response-holder"></div>';

		$output .= '<a href="#" class="custom-button-style dtsl-save-options-settings" data-settings="archives">'.esc_html__('Save Settings', 'dtsl').'</a>';

	$output .= '</form>';

	return $output;

}

echo dtsl_settings_archives_content();

?>