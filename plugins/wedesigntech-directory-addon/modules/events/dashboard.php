<?php

// Filter Listing Fields
if(!function_exists('dtdr_add_listing_fields_from_events_module')) {
	function dtdr_add_listing_fields_from_events_module($output = '', $edit_item_id) {

		$listing_singular_label = apply_filters( 'listing_label', 'singular' );

		$dtdr_start_date = $dtdr_end_date = $dtdr_start_time = $dtdr_end_time = $dtdr_24_hour_format = '';

		if($edit_item_id > 0) {
			$dtdr_start_date     = get_post_meta($edit_item_id, 'dtdr_start_date', true);
			$dtdr_end_date       = get_post_meta($edit_item_id, 'dtdr_end_date', true);
			$dtdr_start_time     = get_post_meta($edit_item_id, 'dtdr_start_time', true);
			$dtdr_end_time       = get_post_meta($edit_item_id, 'dtdr_end_time', true);
			$dtdr_24_hour_format = get_post_meta($edit_item_id, 'dtdr_24_hour_format', true);
		}

		$output .= '<div class="dtdr-dashbord-section-holder">';

			$output .= '<div class="dtdr-dashbord-section-holder-intro">';
				$output .= '<div class="dtdr-dashbord-section-title">'.esc_html__('Event Details', 'dtdr').'</div>';
				$output .= '<div class="dtdr-dashbord-section-title-notes">'.sprintf( esc_html__('If you wish you can add below information for your %1$s.', 'dtdr'), strtolower($listing_singular_label) ).'</div>';
			$output .= '</div>';

			$output .= '<div class="dtdr-dashbord-section-holder-content">';

				$output .= '<div class="dtdr-column dtdr-one-half first">';
					$output .= '<div class="dtdr-dashboard-option-item">
					               	<label for="dtdr_start_date">'.esc_html__('Start Date', 'dtdr').'</label>
					               	<div class="dtdr-dashboard-option-item-data">
					               		<input type="text" value="'.esc_attr($dtdr_start_date).'" class="dtdr-datepicker" name="dtdr_start_date" />
					               	</div>
					            </div>';
				$output .= '</div>';

				$output .= '<div class="dtdr-column dtdr-one-half">';
					$output .= '<div class="dtdr-dashboard-option-item">
					               	<label for="dtdr_end_date">'.esc_html__('End Date', 'dtdr').'</label>
					               	<div class="dtdr-dashboard-option-item-data">
					               		<input type="text" value="'.esc_attr($dtdr_end_date).'" class="dtdr-datepicker" name="dtdr_end_date" />
					               	</div>
					            </div>';
				$output .= '</div>';

	            $timings = array (
	                        '' => esc_html__('OFF', 'dtdr'),
	                        '00:00' => '00:00 ('.esc_html__('midnight', 'dtdr').')',
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
	                        '12:00' => '12:00 ('.esc_html__('noon', 'dtdr').')',
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

				$output .= '<div class="dtdr-column dtdr-one-half first">';
					$output .= '<div class="dtdr-dashboard-option-item">
					               	<label for="dtdr_start_date">'.esc_html__('Start Time', 'dtdr').'</label>
					               	<div class="dtdr-dashboard-option-item-data">';

				                        $output .= '<select name="dtdr_start_time" class="dtdr-chosen-select" data-placeholder="'.esc_html__('OFF', 'dtlms').'">';
					                        if(count($timings) > 0) {
					                            foreach($timings as $timing_key => $timing_value) {
					                                $selected_attribute = '';
					                                if($timing_key == $dtdr_start_time) {
					                                    $selected_attribute = 'selected="selected"';
					                                }
					                                $output .= '<option value="'.esc_attr($timing_key).'" '.$selected_attribute.'>'.esc_html($timing_value).'</option>';
					                            }
					                        }
				                        $output .= '</select>';

					    $output .= '</div>
					            </div>';
				$output .= '</div>';

				$output .= '<div class="dtdr-column dtdr-one-half">';
					$output .= '<div class="dtdr-dashboard-option-item">
					               	<label for="dtdr_end_date">'.esc_html__('End Time', 'dtdr').'</label>
					               	<div class="dtdr-dashboard-option-item-data">';

				                        $output .= '<select name="dtdr_end_time" class="dtdr-chosen-select" data-placeholder="'.esc_html__('OFF', 'dtlms').'">';
					                        if(count($timings) > 0) {
					                            foreach($timings as $timing_key => $timing_value) {
					                                $selected_attribute = '';
					                                if($timing_key == $dtdr_end_time) {
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
            	if($dtdr_24_hour_format == 'true') {
            		$checked_attribute = 'checked="checked"';
            	}
				$output .= '<div class="dtdr-column dtdr-one-half first">';
					$output .= '<div class="dtdr-dashboard-option-item">
					               	<div class="dtdr-dashboard-option-item-data">
					                    <div class="dtdr-dashboard-option-hour-format-item">
					                    	<input type="checkbox" name="dtdr_24_hour_format" id="dtdr_24_hour_format" value="true" '.$checked_attribute.' />
					                    	<label for="dtdr_24_hour_format">'.esc_html__('24 Hour Format', 'dtdr').'</label>
					                    </div>
					               	</div>
					            </div>';
				$output .= '</div>';

				$output .= '<div class="dtdr-column dtdr-one-half"></div>';

			$output .= '</div>';

		$output .= '</div>';

	    return $output;

	}
	add_filter( 'dtdr_add_listing_fields_from_modules', 'dtdr_add_listing_fields_from_events_module', 10, 2 );
}

?>