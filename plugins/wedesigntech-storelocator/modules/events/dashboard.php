<?php

// Filter Listing Fields
if(!function_exists('dtsl_add_listing_fields_from_events_module')) {
	function dtsl_add_listing_fields_from_events_module($output = '', $edit_item_id = '') {

		$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );

		$dtsl_start_date = $dtsl_end_date = $dtsl_start_time = $dtsl_end_time = $dtsl_24_hour_format = '';

		if($edit_item_id > 0) {
			$dtsl_start_date     = get_post_meta($edit_item_id, 'dtsl_start_date', true);
			$dtsl_end_date       = get_post_meta($edit_item_id, 'dtsl_end_date', true);
			$dtsl_start_time     = get_post_meta($edit_item_id, 'dtsl_start_time', true);
			$dtsl_end_time       = get_post_meta($edit_item_id, 'dtsl_end_time', true);
			$dtsl_24_hour_format = get_post_meta($edit_item_id, 'dtsl_24_hour_format', true);
		}

		$output .= '<div class="dtsl-dashbord-section-holder">';

			$output .= '<div class="dtsl-dashbord-section-holder-intro">';
				$output .= '<div class="dtsl-dashbord-section-title">'.esc_html__('Event Details', 'dtsl').'</div>';
				$output .= '<div class="dtsl-dashbord-section-title-notes">'.sprintf( esc_html__('If you wish you can add below information for your %1$s.', 'dtsl'), strtolower($dt_sl_listing_singular_label) ).'</div>';
			$output .= '</div>';

			$output .= '<div class="dtsl-dashbord-section-holder-content">';

				$output .= '<div class="dtsl-column dtsl-one-half first">';
					$output .= '<div class="dtsl-dashboard-option-item">
					               	<label for="dtsl_start_date">'.esc_html__('Start Date', 'dtsl').'</label>
					               	<div class="dtsl-dashboard-option-item-data">
					               		<input type="text" value="'.esc_attr($dtsl_start_date).'" class="dtsl-datepicker" name="dtsl_start_date" />
					               	</div>
					            </div>';
				$output .= '</div>';

				$output .= '<div class="dtsl-column dtsl-one-half">';
					$output .= '<div class="dtsl-dashboard-option-item">
					               	<label for="dtsl_end_date">'.esc_html__('End Date', 'dtsl').'</label>
					               	<div class="dtsl-dashboard-option-item-data">
					               		<input type="text" value="'.esc_attr($dtsl_end_date).'" class="dtsl-datepicker" name="dtsl_end_date" />
					               	</div>
					            </div>';
				$output .= '</div>';

	            $timings = array (
	                        '' => esc_html__('OFF', 'dtsl'),
	                        '00:00' => '00:00 ('.esc_html__('midnight', 'dtsl').')',
	                        '00:30' => '00:30',
	                        '01:00' => '01:00',
	                        '01:30' => '01:30',
	                        '02:00' => '02:00',
	                        '02:30' => '02:30',
	                        '03:00' => '03:00',
	                        '03:30' => '03:30',
	                        '04:00' => '04:00',
	                        '04:30' => '04:30',
	                        '05:00' => '05:00',
	                        '05:30' => '05:30',
	                        '06:00' => '06:00',
	                        '06:30' => '06:30',
	                        '07:00' => '07:00',
	                        '07:30' => '07:30',
	                        '08:00' => '08:00',
	                        '08:30' => '08:30',
	                        '09:00' => '09:00',
	                        '09:30' => '09:30',
	                        '10:00' => '10:00',
	                        '10:30' => '10:30',
	                        '11:00' => '11:00',
	                        '11:30' => '11:30',
	                        '12:00' => '12:00 ('.esc_html__('noon', 'dtsl').')',
	                        '12:30' => '12:30',
	                        '13:00' => '13:00',
	                        '13:30' => '13:30',
	                        '14:00' => '14:00',
	                        '14:30' => '14:30',
	                        '15:00' => '15:00',
	                        '15:30' => '15:30',
	                        '16:00' => '16:00',
	                        '16:30' => '16:30',
	                        '17:00' => '17:00',
	                        '17:30' => '17:30',
	                        '18:00' => '18:00',
	                        '18:30' => '18:30',
	                        '19:00' => '19:00',
	                        '19:30' => '19:30',
	                        '20:00' => '20:00',
	                        '20:30' => '20:30',
	                        '21:00' => '21:00',
	                        '21:30' => '21:30',
	                        '22:00' => '22:00',
	                        '22:30' => '22:30',
	                        '23:00' => '23:00',
	                        '23:30' => '23:30',
	                    );

				$output .= '<div class="dtsl-column dtsl-one-half first">';
					$output .= '<div class="dtsl-dashboard-option-item">
					               	<label for="dtsl_start_date">'.esc_html__('Start Time', 'dtsl').'</label>
					               	<div class="dtsl-dashboard-option-item-data">';

				                        $output .= '<select name="dtsl_start_time" class="dtsl-chosen-select" data-placeholder="'.esc_html__('OFF', 'dtlms').'">';
					                        if(count($timings) > 0) {
					                            foreach($timings as $timing_key => $timing_value) {
					                                $selected_attribute = '';
					                                if($timing_key == $dtsl_start_time) {
					                                    $selected_attribute = 'selected="selected"';
					                                }
					                                $output .= '<option value="'.esc_attr($timing_key).'" '.$selected_attribute.'>'.esc_html($timing_value).'</option>';
					                            }
					                        }
				                        $output .= '</select>';

					    $output .= '</div>
					            </div>';
				$output .= '</div>';

				$output .= '<div class="dtsl-column dtsl-one-half">';
					$output .= '<div class="dtsl-dashboard-option-item">
					               	<label for="dtsl_end_date">'.esc_html__('End Time', 'dtsl').'</label>
					               	<div class="dtsl-dashboard-option-item-data">';

				                        $output .= '<select name="dtsl_end_time" class="dtsl-chosen-select" data-placeholder="'.esc_html__('OFF', 'dtlms').'">';
					                        if(count($timings) > 0) {
					                            foreach($timings as $timing_key => $timing_value) {
					                                $selected_attribute = '';
					                                if($timing_key == $dtsl_end_time) {
					                                    $selected_attribute = 'selected="selected"';
					                                }
					                                $output .= '<option value="'.esc_attr($timing_key).'" '.$selected_attribute.'>'.esc_html($timing_value).'</option>';
					                            }
					                        }
				                        $output .= '</select>';

					    $output .= '</div>
					            </div>';
				$output .= '</div>';


            	$checked_attribute = '';
            	if($dtsl_24_hour_format == 'true') {
            		$checked_attribute = 'checked="checked"';
            	}
				$output .= '<div class="dtsl-column dtsl-one-half first">';
					$output .= '<div class="dtsl-dashboard-option-item">
					               	<div class="dtsl-dashboard-option-item-data">
					                    <div class="dtsl-dashboard-option-hour-format-item">
					                    	<input type="checkbox" name="dtsl_24_hour_format" id="dtsl_24_hour_format" value="true" '.$checked_attribute.' />
					                    	<label for="dtsl_24_hour_format">'.esc_html__('24 Hour Format', 'dtsl').'</label>
					                    </div>
					               	</div>
					            </div>';
				$output .= '</div>';

				$output .= '<div class="dtsl-column dtsl-one-half"></div>';

			$output .= '</div>';

		$output .= '</div>';

	    return $output;

	}
	add_filter( 'dtsl_add_listing_fields_from_modules', 'dtsl_add_listing_fields_from_events_module', 10, 2 );
}

?>