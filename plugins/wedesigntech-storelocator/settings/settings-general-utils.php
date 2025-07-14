<?php

function dtsl_settings_general_content() {

	$output = '';

	$seller_singular_label = apply_filters( 'dt_sl_seller_label', 'singular' );
	$seller_plural_label = apply_filters( 'dt_sl_seller_label', 'plural' );

	$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );
	$incharge_singular_label = apply_filters( 'dt_sl_incharge_label', 'singular' );

	$output .= '<form name="formOptionSettings" class="formOptionSettings" method="post">';

		$output .= '<div class="dtsl-settings-options-holder">';
			$output .= '<div class="dtsl-column dtsl-one-fifth first">';
				$output .= '<label>'.esc_html__( 'Container Width', 'dtsl' ).'</label>';
			$output .= '</div>';
			$output .= '<div class="dtsl-column dtsl-four-fifth">';
				$container_width = dtsl_option('general','container-width');
				$output .= '<input id="container-width" name="dtsl[general][container-width]" type="number" value="'.$container_width.'" min="1" max="2000" step="1"  />';
				$output .= '<div class="dtsl-note">'.esc_html__('Provide container width in "px" here', 'dtsl').'</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtsl-settings-options-holder">';
			$output .= '<div class="dtsl-column dtsl-one-fifth first">';
				$output .= '<label>'.sprintf(esc_html__('%1$s Single Page Template', 'dtsl'), $dt_sl_listing_singular_label).'</label>';
			$output .= '</div>';
			$output .= '<div class="dtsl-column dtsl-four-fifth">';

				$single_page_template = dtsl_option('general','single-page-template');

				$tpl_args = array (
					'post_type' => 'page',
					'meta_key' => '_wp_page_template',
					'meta_value' => 'tpl-single-listing.php',
					'suppress_filters' => 0
				);
				$single_tpl_posts = get_posts($tpl_args);

				$output .= '<select name="dtsl[general][single-page-template]" class="dtsl-chosen-select">';

					$output .= '<option value="custom-template" '.selected('custom-template', $single_page_template, false ).'>'.esc_html__('Custom Template', 'dtsl').'</option>';
					$output .= '<option value="default-template-1" '.selected('default-template-1', $single_page_template, false ).'>'.esc_html__('Default Template 1', 'dtsl').'</option>';

					if(is_array($single_tpl_posts) && !empty($single_tpl_posts)) {
						foreach($single_tpl_posts as $single_tpl_post) {
							$output .= '<option value="'.$single_tpl_post->ID.'" '.selected($single_tpl_post->ID, $single_page_template, false ).'>';
								$output .= $single_tpl_post->post_title;
							$output .= '</option>';
						}
					}

				$output .= '</select>';

				$output .= '<div class="dtsl-note">'.sprintf( esc_html__('If you like to build your %1$s single page by your own choose "Custom Template" else choose one of the predefined templates created using "Store Locator Single Page Template".', 'dtsl'), $dt_sl_listing_singular_label ).'</div>';

			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtsl-settings-options-holder">';
			$output .= '<div class="dtsl-column dtsl-one-fifth first">';
				$output .= '<label>'.esc_html__( 'MLS Number - Prefix', 'dtsl' ).'</label>';
			$output .= '</div>';
			$output .= '<div class="dtsl-column dtsl-four-fifth">';
	            $mls_number_prefix = dtsl_option('general','mls-number-prefix');
	            $output .= '<input id="mls-number-prefix" name="dtsl[general][mls-number-prefix]" type="text" value="'.$mls_number_prefix.'" maxlength="4" style="text-transform:uppercase" />';
	            $output .= '<div class="dtsl-note">'.esc_html__('If you wish you can add prefix for your MLS number.', 'dtsl').'</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtsl-settings-options-holder">';
			$output .= '<div class="dtsl-column dtsl-one-fifth first">';
				$output .= '<label>'.esc_html__( 'MLS Number - Total Digits', 'dtsl' ).'</label>';
			$output .= '</div>';
			$output .= '<div class="dtsl-column dtsl-four-fifth">';
	            $mls_number_digits = dtsl_option('general','mls-number-digits');
	            $output .= '<input id="mls-number-digits" name="dtsl[general][mls-number-digits]" type="number" value="'.$mls_number_digits.'" min="1" max="8" step="1"  />';
	            $output .= '<div class="dtsl-note">'.esc_html__('If you wish you can add digits for your MLS number. Max value : 8', 'dtsl').'</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtsl-settings-options-holder">';
			$output .= '<div class="dtsl-column dtsl-one-fifth first">';
				$output .= '<label>'.esc_html__( 'Backend - Post Per Page', 'dtsl' ).'</label>';
			$output .= '</div>';
			$output .= '<div class="dtsl-column dtsl-four-fifth">';
	            $backend_postperpage = dtsl_option('general','backend-postperpage');
	            $output .= '<input id="backend-postperpage" name="dtsl[general][backend-postperpage]" type="number" value="'.$backend_postperpage.'" />';
	            $output .= '<div class="dtsl-note">'.esc_html__('Number of items to show in backend content listing, ex. statistics,..', 'dtsl').'</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtsl-settings-options-holder">';
			$output .= '<div class="dtsl-column dtsl-one-fifth first">';
				$output .= '<label>'.esc_html__( 'Frontend - Post Per Page', 'dtsl' ).'</label>';
			$output .= '</div>';
			$output .= '<div class="dtsl-column dtsl-four-fifth">';
	            $frontend_postperpage = dtsl_option('general','frontend-postperpage');
	            $output .= '<input id="frontend-postperpage" name="dtsl[general][frontend-postperpage]" type="number" value="'.$frontend_postperpage.'" />';
	            $output .= '<div class="dtsl-note">'.esc_html__('Number of items to show in frontend content listing, ex. dashboard,..', 'dtsl').'</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtsl-settings-options-holder">';
			$output .= '<div class="dtsl-column dtsl-one-fifth first">';
				$output .= '<label>'.esc_html__( 'Purchase Package Shortcode', 'dtsl' ).'</label>';
			$output .= '</div>';
			$output .= '<div class="dtsl-column dtsl-four-fifth">';
				$seller_purchase_package_shortcode = dtsl_option('general','seller-purchase-package-shortcode');
	            $output .= '<textarea id="dt-sl-seller-plural-label" name="dtsl[general][seller-purchase-package-shortcode]">'.stripslashes(sanitize_textarea_field($seller_purchase_package_shortcode)).'</textarea>';
	            $output .= '<div class="dtsl-note">';
	            	$output .= '<p>'.esc_html__('Add purchase packaged shortcode which will be displayed in seller add listing dashboard page.', 'dtsl').'</p>';
					$output .= '<p><strong>'.esc_html__('Shortcode - [dtsl_packages_listing type="type1" post_per_page="3" columns="3" apply_isotope="false" package_type="all" package_item_ids="" excerpt_length="20" show_featured_image="true" apply_equal_height="false" enable_carousel="false" carousel_effect="" carousel_autoplay="" carousel_slidesperview="2" carousel_loopmode="false" carousel_mousewheelcontrol="false" carousel_bulletpagination="true" carousel_arrowpagination="" carousel_spacebetween="20" class="" /].', 'dtsl').'</strong></p>';
	            $output .= '</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtsl-settings-options-holder">';
			$output .= '<div class="dtsl-column dtsl-one-fifth first">';
				$output .= '<label>'.esc_html__( 'Restrict Page View Counter Over User IP', 'dtsl' ).'</label>';
			$output .= '</div>';
			$output .= '<div class="dtsl-column dtsl-four-fifth">';
                $checked = ( 'true' ==  dtsl_option('general', 'restrict-counter-overuserip') ) ? ' checked="checked"' : '';
                $switchclass = ( 'true' ==  dtsl_option('general', 'restrict-counter-overuserip') ) ? 'checkbox-switch-on' :'checkbox-switch-off';
	            $output .= '<div data-for="restrict-counter-overuserip" class="dtsl-checkbox-switch '.$switchclass.'"></div>';
	            $output .= '<input id="restrict-counter-overuserip" class="hidden" type="checkbox" name="dtsl[general][restrict-counter-overuserip]" value="true" '.$checked.' />';
	            $output .= '<div class="dtsl-note">'.esc_html__( 'YES! to restrict page view counter over user ip address. Second entry from same ip address will be restricted.', 'dtsl' ).'</div>';
			$output .= '</div>';
		$output .= '</div>';

		if(defined('DTSL_USERS_PLUGIN_PATH')) {

			$output .= '<div class="dtsl-settings-options-holder">';
				$output .= '<div class="dtsl-column dtsl-one-fifth first">';
					$output .= '<label>'.sprintf(esc_html__('Enable Email - %1$s', 'dtsl'), $seller_singular_label).'</label>';
				$output .= '</div>';
				$output .= '<div class="dtsl-column dtsl-four-fifth">';
					$checked = ( 'true' ==  dtsl_option('general', 'enable-email-seller') ) ? ' checked="checked"' : '';
					$switchclass = ( 'true' ==  dtsl_option('general', 'enable-email-seller') ) ? 'checkbox-switch-on' :'checkbox-switch-off';
					$output .= '<div data-for="enable-email-seller" class="dtsl-checkbox-switch '.$switchclass.'"></div>';
					$output .= '<input id="enable-email-seller" class="hidden" type="checkbox" name="dtsl[general][enable-email-seller]" value="true" '.$checked.' />';
					$output .= '<div class="dtsl-note">'.sprintf(esc_html__('Choose "Yes" to allow %1$s to receive email when %2$s create %3$s.', 'dtsl'), $seller_singular_label, $incharge_singular_label, $dt_sl_listing_singular_label).'</div>';
				$output .= '</div>';
			$output .= '</div>';

		}

		$output .= '<div class="dtsl-settings-options-holder">';
			$output .= '<div class="dtsl-column dtsl-one-fifth first">';
				$output .= '<label>'.esc_html__('Enable Email - Admin', 'dtsl').'</label>';
			$output .= '</div>';
			$output .= '<div class="dtsl-column dtsl-four-fifth">';
                $checked = ( 'true' ==  dtsl_option('general', 'enable-email-admin') ) ? ' checked="checked"' : '';
                $switchclass = ( 'true' ==  dtsl_option('general', 'enable-email-admin') ) ? 'checkbox-switch-on' :'checkbox-switch-off';
	            $output .= '<div data-for="enable-email-admin" class="dtsl-checkbox-switch '.$switchclass.'"></div>';
	            $output .= '<input id="enable-email-admin" class="hidden" type="checkbox" name="dtsl[general][enable-email-admin]" value="true" '.$checked.' />';
	            $output .= '<div class="dtsl-note">'.sprintf(esc_html__('Choose "Yes" to allow Admin to receive email when %1$s and Incharge create %2$s.', 'dtsl'), $seller_singular_label, $dt_sl_listing_singular_label).'</div>';
			$output .= '</div>';
		$output .= '</div>';

		if(defined('DTSL_USERS_PLUGIN_PATH')) {

			$output .= '<div class="dtsl-settings-options-holder">';
				$output .= '<div class="dtsl-column dtsl-one-fifth first">';
					$output .= '<label>'.sprintf(esc_html__('Should admin approve %1$s ?', 'dtsl'), $dt_sl_listing_singular_label).'</label>';
				$output .= '</div>';
				$output .= '<div class="dtsl-column dtsl-four-fifth">';
					$checked = ( 'true' ==  dtsl_option('general', 'should-admin-approve-listings') ) ? ' checked="checked"' : '';
					$switchclass = ( 'true' ==  dtsl_option('general', 'should-admin-approve-listings') ) ? 'checkbox-switch-on' :'checkbox-switch-off';
					$output .= '<div data-for="should-admin-approve-listings" class="dtsl-checkbox-switch '.$switchclass.'"></div>';
					$output .= '<input id="should-admin-approve-listings" class="hidden" type="checkbox" name="dtsl[general][should-admin-approve-listings]" value="true" '.$checked.' />';
					$output .= '<div class="dtsl-note">'.sprintf(esc_html__('Choose "Yes" if admin have to approve each %1$s submitted in frontend manually.', 'dtsl'), $dt_sl_listing_singular_label).'</div>';
				$output .= '</div>';
			$output .= '</div>';

			$output .= '<div class="dtsl-settings-options-holder">';
				$output .= '<div class="dtsl-column dtsl-one-fifth first">';
					$output .= '<label>'.sprintf(esc_html__('Should admin approve %1$s ?', 'dtsl'), $incharge_singular_label).'</label>';
				$output .= '</div>';
				$output .= '<div class="dtsl-column dtsl-four-fifth">';
					$checked = ( 'true' ==  dtsl_option('general', 'should-admin-approve-incharges') ) ? ' checked="checked"' : '';
					$switchclass = ( 'true' ==  dtsl_option('general', 'should-admin-approve-incharges') ) ? 'checkbox-switch-on' :'checkbox-switch-off';
					$output .= '<div data-for="should-admin-approve-incharges" class="dtsl-checkbox-switch '.$switchclass.'"></div>';
					$output .= '<input id="should-admin-approve-incharges" class="hidden" type="checkbox" name="dtsl[general][should-admin-approve-incharges]" value="true" '.$checked.' />';
					$output .= '<div class="dtsl-note">'.sprintf(esc_html__('Choose "Yes" if admin have to approve each %1$s submitted by %2$s.', 'dtsl'), $incharge_singular_label, $seller_singular_label).'</div>';
				$output .= '</div>';
			$output .= '</div>';

			$output .= '<div class="dtsl-settings-options-holder">';
				$output .= '<div class="dtsl-column dtsl-one-fifth first">';
					$output .= '<label>'.sprintf(esc_html__('Allow "%1$s" to "Add %2$s"', 'dtsl'), $incharge_singular_label, $dt_sl_listing_singular_label).'</label>';
				$output .= '</div>';
				$output .= '<div class="dtsl-column dtsl-four-fifth">';
					$checked = ( 'true' ==  dtsl_option('general', 'allow-incharge-add-listing') ) ? ' checked="checked"' : '';
					$switchclass = ( 'true' ==  dtsl_option('general', 'allow-incharge-add-listing') ) ? 'checkbox-switch-on' :'checkbox-switch-off';
					$output .= '<div data-for="allow-incharge-add-listing" class="dtsl-checkbox-switch '.$switchclass.'"></div>';
					$output .= '<input id="allow-incharge-add-listing" class="hidden" type="checkbox" name="dtsl[general][allow-incharge-add-listing]" value="true" '.$checked.' />';
					$output .= '<div class="dtsl-note">'.sprintf(esc_html__('Choose "Yes" to allow %1$s to add %2$s.', 'dtsl'), $incharge_singular_label, $seller_singular_label).'</div>';
				$output .= '</div>';
			$output .= '</div>';

		}

		$output .= '<div class="dtsl-option-settings-response-holder"></div>';

		$output .= '<a href="#" class="custom-button-style dtsl-save-options-settings" data-settings="general">'.esc_html__('Save Settings', 'dtsl').'</a>';

	$output .= '</form>';

	return $output;

}

echo dtsl_settings_general_content();

?>