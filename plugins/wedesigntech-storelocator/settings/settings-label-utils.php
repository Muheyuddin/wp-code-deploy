<?php

function dtsl_settings_label_content() {

	$output = '';

	$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );
	$listing_plural_label = apply_filters( 'dt_sl_listing_label', 'plural' );

	$dt_sl_contracttype_singular_label = apply_filters( 'dt_sl_contracttype_label', 'singular' );
	$contracttype_plural_label = apply_filters( 'dt_sl_contracttype_label', 'plural' );

	$dt_sl_amenity_singular_label = apply_filters( 'dt_sl_amenity_label', 'singular' );
	$amenity_plural_label = apply_filters( 'dt_sl_amenity_label', 'plural' );

	$seller_singular_label = apply_filters( 'dt_sl_seller_label', 'singular' );
	$seller_plural_label = apply_filters( 'dt_sl_seller_label', 'plural' );

	$incharge_singular_label = apply_filters( 'dt_sl_incharge_label', 'singular' );
	$incharge_plural_label = apply_filters( 'dt_sl_incharge_label', 'plural' );

	$output .= '<form name="formOptionSettings" class="formOptionSettings" method="post">';

		$output .= '<div class="dtsl-settings-options-holder">';
			$output .= '<div class="dtsl-column dtsl-one-fifth first">';
				$output .= '<label>'.sprintf( esc_html__( '%1$s Singular Label', 'dtsl' ), $dt_sl_listing_singular_label ).'</label>';
			$output .= '</div>';
			$output .= '<div class="dtsl-column dtsl-four-fifth">';
	            $output .= '<input id="dt-sl-listing-singular-label" name="dtsl[label][dt-sl-listing-singular-label]" type="text" value="'.$dt_sl_listing_singular_label.'" />';
	            $output .= '<div class="dtsl-note">'.esc_html__('You can replace the "Listing" label as per your requirement.', 'dtsl').'</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtsl-settings-options-holder">';
			$output .= '<div class="dtsl-column dtsl-one-fifth first">';
				$output .= '<label>'.sprintf( esc_html__( '%1$s Plural Label', 'dtsl' ), $listing_plural_label ).'</label>';
			$output .= '</div>';
			$output .= '<div class="dtsl-column dtsl-four-fifth">';
	            $output .= '<input id="dt-sl-listing-plural-label" name="dtsl[label][dt-sl-listing-plural-label]" type="text" value="'.$listing_plural_label.'" />';
	            $output .= '<div class="dtsl-note">'.esc_html__('You can replace the "Listings" label as per your requirement.', 'dtsl').'</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtsl-settings-options-holder">';
			$output .= '<div class="dtsl-column dtsl-one-fifth first">';
				$output .= '<label>'.sprintf( esc_html__( '%1$s Singular Label', 'dtsl' ), $dt_sl_contracttype_singular_label ).'</label>';
			$output .= '</div>';
			$output .= '<div class="dtsl-column dtsl-four-fifth">';
	            $output .= '<input id="dt-sl-contracttype-singular-label" name="dtsl[label][dt-sl-contracttype-singular-label]" type="text" value="'.$dt_sl_contracttype_singular_label.'" />';
	            $output .= '<div class="dtsl-note">'.esc_html__('You can replace the "Contract Type" label as per your requirement.', 'dtsl').'</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtsl-settings-options-holder">';
			$output .= '<div class="dtsl-column dtsl-one-fifth first">';
				$output .= '<label>'.sprintf( esc_html__( '%1$s Plural Label', 'dtsl' ), $contracttype_plural_label ).'</label>';
			$output .= '</div>';
			$output .= '<div class="dtsl-column dtsl-four-fifth">';
	            $output .= '<input id="dt-sl-contracttype-plural-label" name="dtsl[label][dt-sl-contracttype-plural-label]" type="text" value="'.$contracttype_plural_label.'" />';
	            $output .= '<div class="dtsl-note">'.esc_html__('You can replace the "Contract Types" label as per your requirement.', 'dtsl').'</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtsl-settings-options-holder">';
			$output .= '<div class="dtsl-column dtsl-one-fifth first">';
				$output .= '<label>'.sprintf( esc_html__( '%1$s Singular Label', 'dtsl' ), $dt_sl_amenity_singular_label ).'</label>';
			$output .= '</div>';
			$output .= '<div class="dtsl-column dtsl-four-fifth">';
	            $output .= '<input id="dt-sl-amenity-singular-label" name="dtsl[label][dt-sl-amenity-singular-label]" type="text" value="'.$dt_sl_amenity_singular_label.'" />';
	            $output .= '<div class="dtsl-note">'.esc_html__('You can replace the "Amenity" label as per your requirement.', 'dtsl').'</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtsl-settings-options-holder">';
			$output .= '<div class="dtsl-column dtsl-one-fifth first">';
				$output .= '<label>'.sprintf( esc_html__( '%1$s Plural Label', 'dtsl' ), $amenity_plural_label ).'</label>';
			$output .= '</div>';
			$output .= '<div class="dtsl-column dtsl-four-fifth">';
	            $output .= '<input id="dt-sl-amenity-plural-label" name="dtsl[label][dt-sl-amenity-plural-label]" type="text" value="'.$amenity_plural_label.'" />';
	            $output .= '<div class="dtsl-note">'.esc_html__('You can replace the "Amenities" label as per your requirement.', 'dtsl').'</div>';
			$output .= '</div>';
		$output .= '</div>';

		if(defined('DTSL_USERS_PLUGIN_PATH')) {

			$output .= '<div class="dtsl-settings-options-holder">';
				$output .= '<div class="dtsl-column dtsl-one-fifth first">';
					$output .= '<label>'.sprintf( esc_html__( '%1$s Singular Label', 'dtsl' ), $seller_singular_label ).'</label>';
				$output .= '</div>';
				$output .= '<div class="dtsl-column dtsl-four-fifth">';
					$output .= '<input id="dt-sl-seller-singular-label" name="dtsl[label][dt-sl-seller-singular-label]" type="text" value="'.$seller_singular_label.'" />';
					$output .= '<div class="dtsl-note">'.esc_html__('You can replace the "Seller" label as per your requirement.', 'dtsl').'</div>';
				$output .= '</div>';
			$output .= '</div>';

			$output .= '<div class="dtsl-settings-options-holder">';
				$output .= '<div class="dtsl-column dtsl-one-fifth first">';
					$output .= '<label>'.sprintf( esc_html__( '%1$s Plural Label', 'dtsl' ), $seller_plural_label ).'</label>';
				$output .= '</div>';
				$output .= '<div class="dtsl-column dtsl-four-fifth">';
					$output .= '<input id="dt-sl-seller-plural-label" name="dtsl[label][dt-sl-seller-plural-label]" type="text" value="'.$seller_plural_label.'" />';
				$output .= '<div class="dtsl-note">'.esc_html__('You can replace the "Sellers" label as per your requirement.', 'dtsl').'</div>';
				$output .= '</div>';
			$output .= '</div>';

			$output .= '<div class="dtsl-settings-options-holder">';
				$output .= '<div class="dtsl-column dtsl-one-fifth first">';
					$output .= '<label>'.sprintf( esc_html__( '%1$s Singular Label', 'dtsl' ), $incharge_singular_label ).'</label>';
				$output .= '</div>';
				$output .= '<div class="dtsl-column dtsl-four-fifth">';
					$output .= '<input id="dt-sl-incharge-singular-label" name="dtsl[label][dt-sl-incharge-singular-label]" type="text" value="'.$incharge_singular_label.'" />';
					$output .= '<div class="dtsl-note">'.esc_html__('You can replace the "Incharge" label as per your requirement.', 'dtsl').'</div>';
				$output .= '</div>';
			$output .= '</div>';

			$output .= '<div class="dtsl-settings-options-holder">';
				$output .= '<div class="dtsl-column dtsl-one-fifth first">';
					$output .= '<label>'.sprintf( esc_html__( '%1$s Plural Label', 'dtsl' ), $incharge_plural_label ).'</label>';
				$output .= '</div>';
				$output .= '<div class="dtsl-column dtsl-four-fifth">';
					$output .= '<input id="dt-sl-incharge-plural-label" name="dtsl[label][dt-sl-incharge-plural-label]" type="text" value="'.$incharge_plural_label.'" />';
				$output .= '<div class="dtsl-note">'.esc_html__('You can replace the "Incharges" label as per your requirement.', 'dtsl').'</div>';
				$output .= '</div>';
			$output .= '</div>';

		}

		$output .= '<div class="dtsl-option-settings-response-holder"></div>';

		$output .= '<a href="#" class="custom-button-style dtsl-save-options-settings" data-settings="label">'.esc_html__('Save Settings', 'dtsl').'</a>';

	$output .= '</form>';

	return $output;

}

echo dtsl_settings_label_content();

?>