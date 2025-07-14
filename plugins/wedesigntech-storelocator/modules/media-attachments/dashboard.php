<?php

// Filter Listing Fields
if(!function_exists('dtsl_add_listing_fields_from_attachments_module')) {
	function dtsl_add_listing_fields_from_attachments_module($output = '', $edit_item_id = '') {

		$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );

	    // Media - Attachments
			$output .= '<div class="dtsl-dashbord-section-holder">';

				$output .= '<div class="dtsl-dashbord-section-holder-intro">';
					$output .= '<div class="dtsl-dashbord-section-title">'.esc_html__('Media - Attachments', 'dtsl').'</div>';
					$output .= '<div class="dtsl-dashbord-section-title-notes">'.sprintf( esc_html__('You can add any number of attachments for your %1$s.', 'dtsl'), strtolower($dt_sl_listing_singular_label) ).'</div>';
				$output .= '</div>';

				$output .= '<div class="dtsl-dashbord-section-holder-content">';
					$output .= '<div class="dtsl-dashboard-option-item">
									<label for="dtsl_features">'.esc_html__('Add Attachments', 'dtsl').'</label>
									<div class="dtsl-dashboard-option-item-data">';
										$output .= dtsl_listing_attachments_field($edit_item_id);
						$output .= '</div>';
					$output .= '</div>';
				$output .= '</div>';

			$output .= '</div>';

	    return $output;

	}
	add_filter( 'dtsl_add_listing_fields_from_modules', 'dtsl_add_listing_fields_from_attachments_module', 10, 2 );
}

?>