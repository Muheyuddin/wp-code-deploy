<?php

function dtsl_settings_permalink_content() {

	$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );
	$seller_singular_label = apply_filters( 'dt_sl_seller_label', 'singular' );

	$output = '';

	$output .= '<form name="formOptionSettings" class="formOptionSettings" method="post">';

		$output .= '<div class="dtsl-settings-options-holder">';
			$output .= '<div class="dtsl-column dtsl-one-fifth first">';
				$output .= '<label>'.sprintf( esc_html__( '%1$s Slug', 'dtsl' ), $dt_sl_listing_singular_label ).'</label>';
			$output .= '</div>';
			$output .= '<div class="dtsl-column dtsl-four-fifth">';
	            $listing_slug = dtsl_option('permalink','dt-sl-listing-slug');
	            $output .= '<input id="dt-sl-listing-slug" name="dtsl[permalink][dt-sl-listing-slug]" type="text" value="'.$listing_slug.'" />';
	            $output .= '<div class="dtsl-note">'.esc_html__('Do not use characters not allowed in links. Use, eg. listing After change go to Settings > Permalinks and click Save changes.', 'dtsl').'</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtsl-settings-options-holder">';
			$output .= '<div class="dtsl-column dtsl-one-fifth first">';
				$output .= '<label>'.sprintf( esc_html__( '%1$s Category Slug', 'dtsl' ), $dt_sl_listing_singular_label ).'</label>';
			$output .= '</div>';
			$output .= '<div class="dtsl-column dtsl-four-fifth">';
	            $dtsl_listings_category_slug = dtsl_option('permalink','dt-sl-listing-category-slug');
	            $output .= '<input id="dt-sl-listing-category-slug" name="dtsl[permalink][dt-sl-listing-category-slug]" type="text" value="'.$dtsl_listings_category_slug.'" />';
	            $output .= '<div class="dtsl-note">'.esc_html__('Do not use characters not allowed in links. Use, eg. listing-category After change go to Settings > Permalinks and click Save changes.', 'dtsl').'</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtsl-settings-options-holder">';
			$output .= '<div class="dtsl-column dtsl-one-fifth first">';
				$output .= '<label>'.sprintf( esc_html__( '%1$s Contract Type Slug', 'dtsl' ), $dt_sl_listing_singular_label ).'</label>';
			$output .= '</div>';
			$output .= '<div class="dtsl-column dtsl-four-fifth">';
	            $dtsl_listings_contracttype_slug = dtsl_option('permalink','dt-sl-listing-contracttype-slug');
	            $output .= '<input id="dt-sl-listing-contracttype-slug" name="dtsl[permalink][dt-sl-listing-contracttype-slug]" type="text" value="'.$dtsl_listings_contracttype_slug.'" />';
	            $output .= '<div class="dtsl-note">'.esc_html__('Do not use characters not allowed in links. Use, eg. listing-contracttype After change go to Settings > Permalinks and click Save changes.', 'dtsl').'</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtsl-settings-options-holder">';
			$output .= '<div class="dtsl-column dtsl-one-fifth first">';
				$output .= '<label>'.sprintf( esc_html__( '%1$s Amenity Slug', 'dtsl' ), $dt_sl_listing_singular_label ).'</label>';
			$output .= '</div>';
			$output .= '<div class="dtsl-column dtsl-four-fifth">';
	            $dtsl_listings_amenity_slug = dtsl_option('permalink','dt-sl-listing-amenity-slug');
	            $output .= '<input id="dt-sl-listing-amenity-slug" name="dtsl[permalink][dt-sl-listing-amenity-slug]" type="text" value="'.$dtsl_listings_amenity_slug.'" />';
	            $output .= '<div class="dtsl-note">'.esc_html__('Do not use characters not allowed in links. Use, eg. listing-amenity After change go to Settings > Permalinks and click Save changes.', 'dtsl').'</div>';
			$output .= '</div>';
		$output .= '</div>';


		$output .= '<div class="dtsl-note">'.esc_html__('Do not use characters not allowed in links. Use, eg. courses After change go to Settings > Permalinks and click Save changes.', 'dtsl').'</div>';

		$output .= '<div class="dtsl-option-settings-response-holder"></div>';

		$output .= '<a href="#" class="custom-button-style dtsl-save-options-settings" data-settings="permalink">'.esc_html__('Save Settings', 'dtsl').'</a>';

	$output .= '</form>';

	return $output;

}

echo dtsl_settings_permalink_content();

?>