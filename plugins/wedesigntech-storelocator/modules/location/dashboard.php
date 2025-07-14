<?php

// Filter Listing Fields
if(!function_exists('dtsl_add_listing_fields_from_location_modules')) {
	function dtsl_add_listing_fields_from_location_modules($output = '', $edit_item_id = '') {

		$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );

		$dtsl_listings_city_array         = get_the_terms($edit_item_id, 'dtsl_listings_city');
		$dtsl_listings_neighborhood_array = get_the_terms($edit_item_id, 'dtsl_listings_neighborhood');
		$dtsl_listings_countystate_array  = get_the_terms($edit_item_id, 'dtsl_listings_countystate');

		$dtsl_address                     = get_post_meta($edit_item_id, 'dtsl_address', true);
		$dtsl_zip                         = get_post_meta($edit_item_id, 'dtsl_zip', true);
		$dtsl_country                     = get_post_meta($edit_item_id, 'dtsl_country', true);

		$dtsl_latitude                    = get_post_meta($edit_item_id, 'dtsl_latitude', true);
		$dtsl_longitude                   = get_post_meta($edit_item_id, 'dtsl_longitude', true);

		$dtsl_virtual_tour                = get_post_meta($edit_item_id, 'dtsl_virtual_tour', true);

		// Setting ids for location fields
		$dtsl_address_id = $dtsl_city_id = $dtsl_neighborhood_id = $dtsl_zip_id = $dtsl_countystate_id = $dtsl_country_id = $dtsl_latitude_id = $dtsl_longitude_id = '';
		if('true' ==  dtsl_option('map','enable-autocomplete-frontend-formsubmission')) {
				$dtsl_address_id = 'id="dtsl_address"';
				$dtsl_city_id = 'id="dtsl_city"';
				$dtsl_neighborhood_id = 'id="dtsl_neighborhood"';
				$dtsl_zip_id = 'id="dtsl_zip"';
				$dtsl_countystate_id = 'id="dtsl_countystate"';
				$dtsl_country_id = 'id="dtsl_country"';
		}

		$dtsl_latitude_id = 'id="dtsl_latitude"';
		$dtsl_longitude_id = 'id="dtsl_longitude"';

		wp_enqueue_script ( 'dtsl-map' );


		// Address and Location
		$output .= '<div class="dtsl-dashbord-section-holder">';

			$output .= '<div class="dtsl-dashbord-section-holder-intro">';
				$output .= '<div class="dtsl-dashbord-section-title">'.esc_html__('Location', 'dtsl').'</div>';
				$output .= '<div class="dtsl-dashbord-section-title-notes">'.sprintf( esc_html__('Add address and location for your %1$s.', 'dtsl'), strtolower($dt_sl_listing_singular_label) ).'</div>';
			$output .= '</div>';

			$output .= '<div class="dtsl-dashbord-section-holder-content">';

				$output .= '<div class="dtsl-column dtsl-one-column first">';
					$output .= '<div class="dtsl-dashboard-option-item">
					              	<label for="dtsl_description">'.esc_html__('Map Image', 'dtsl').'</label>
					               	<div class="dtsl-dashboard-option-item-data">
				   						'.dtsl_upload_promoflash_image($edit_item_id).'
				   					</div>
				   				</div>';
			   	$output .= '</div>';

				$output .= '<div class="dtsl-column dtsl-one-column first">';
					$output .= '<div class="dtsl-dashboard-option-item">
					                <label for="dtsl_address">'.esc_html__('Address', 'dtsl').'</label>
					               	<div class="dtsl-dashboard-option-item-data">';

					   					$output .= '<input type="text" value="'.esc_attr($dtsl_address).'" name="dtsl_address" '.$dtsl_address_id.' placeholder="'.esc_html__('Enter Address', 'dtsl').'" />

					            	</div>
					            </div>';
				$output .= '</div>';

				$output .= '<div class="dtsl-column dtsl-one-half first">';
					$output .= '<div class="dtsl-dashboard-option-item">
					               <label for="dtsl_city">'.esc_html__('City', 'dtsl').'</label>
					               <div class="dtsl-dashboard-option-item-data">';

						               if('true' ==  dtsl_option('map','enable-autocomplete-frontend-formsubmission')) {

						               		$dtsl_city = '';
										    if(isset($dtsl_listings_city_array[0])) {
										          $dtsl_city = $dtsl_listings_city_array[0]->name;
										    }

						               		$output .= '<input type="text" value="'.esc_attr($dtsl_city).'" name="dtsl_city" '.$dtsl_city_id.' placeholder="'.esc_html__('Enter City', 'dtsl').'" />';

						               } else {

						               		$dtsl_listings_city_terms = array ();
						               		if(is_array($dtsl_listings_city_array) && !empty($dtsl_listings_city_array)) {
							               		foreach($dtsl_listings_city_array as $dtsl_listing_city_array) {
							               			array_push($dtsl_listings_city_terms, $dtsl_listing_city_array->name);
							               		}
						               		}

						               		$dtsl_listings_city = get_categories('taxonomy=dtsl_listings_city&hide_empty=0');

					                        $output .= '<select name="dtsl_city[]" class="dtsl-chosen-select" data-placeholder="'.esc_html__('None', 'dtsl').'" multiple="multiple">';
						                        if(count($dtsl_listings_city) > 0) {
						                            foreach($dtsl_listings_city as $dtsl_listing_city) {
						                            	$selected_attribute = '';
								                    	if(in_array($dtsl_listing_city->name, $dtsl_listings_city_terms)) {
						                            		$selected_attribute = 'selected="selected"';
						                            	}
						                                $output .= '<option value="'.esc_attr($dtsl_listing_city->name).'" '.$selected_attribute.'>'.esc_html( $dtsl_listing_city->name).'</option>';
						                            }
						                        }
					                        $output .= '</select>';

						               }

						$output .= '</div>';
					$output .= '</div>';
				$output .= '</div>';

				$output .= '<div class="dtsl-column dtsl-one-half">';
					$output .= '<div class="dtsl-dashboard-option-item">
					               <label for="dtsl_neighborhood">'.esc_html__('Neighborhood', 'dtsl').'</label>
					               <div class="dtsl-dashboard-option-item-data">';

					               if('true' ==  dtsl_option('map','enable-autocomplete-frontend-formsubmission')) {

					               		$dtsl_neighborhood = '';
									    if(isset($dtsl_listings_neighborhood_array[0])) {
									          $dtsl_neighborhood = $dtsl_listings_neighborhood_array[0]->name;
									    }

					               		$output .= '<input type="text" value="'.esc_attr($dtsl_neighborhood).'" name="dtsl_neighborhood" '.$dtsl_neighborhood_id.' />';

					               } else {

					               		$dtsl_listings_neighborhood_terms = array ();
					               		if(is_array($dtsl_listings_neighborhood_array) && !empty($dtsl_listings_neighborhood_array)) {
						               		foreach($dtsl_listings_neighborhood_array as $dtsl_listing_neighbor_array) {
						               			array_push($dtsl_listings_neighborhood_terms, $dtsl_listing_neighbor_array->name);
						               		}
					               		}

					               		$dtsl_listings_neighborhood = get_categories('taxonomy=dtsl_listings_neighborhood&hide_empty=0');

				                        $output .= '<select name="dtsl_neighborhood[]" class="dtsl-chosen-select" data-placeholder="'.esc_html__('None', 'dtsl').'" multiple="multiple">';
					                        if(count($dtsl_listings_neighborhood) > 0) {
					                            foreach($dtsl_listings_neighborhood as $dtsl_listing_neighbor) {
					                            	$selected_attribute = '';
							                    	if(in_array($dtsl_listing_neighbor->name, $dtsl_listings_neighborhood_terms)) {
					                            		$selected_attribute = 'selected="selected"';
					                            	}
					                                $output .= '<option value="'.esc_attr($dtsl_listing_neighbor->name).'" '.$selected_attribute.'>'.esc_html( $dtsl_listing_neighbor->name).'</option>';
					                            }
					                        }
				                        $output .= '</select>';

					               }

					    $output .= '</div>';
					$output .= '</div>';
				$output .= '</div>';

				$output .= '<div class="dtsl-column dtsl-one-half first">';
					$output .= '<div class="dtsl-dashboard-option-item">
					               	<label for="dtsl_zip">'.esc_html__('Zip', 'dtsl').'</label>
					               	<div class="dtsl-dashboard-option-item-data">
					               		<input type="text" name="dtsl_zip" value="'.esc_attr($dtsl_zip).'" '.$dtsl_zip_id.' />
					               	</div>
					            </div>';
				$output .= '</div>';

				$output .= '<div class="dtsl-column dtsl-one-half">';
					$output .= '<div class="dtsl-dashboard-option-item">
					               <label for="dtsl_neighborhood">'.esc_html__('County / State', 'dtsl').'</label>
					               <div class="dtsl-dashboard-option-item-data">';

						               if('true' ==  dtsl_option('map','enable-autocomplete-frontend-formsubmission')) {

						               		$dtsl_countystate = '';
										    if(isset($dtsl_listings_countystate_array[0])) {
										          $dtsl_countystate = $dtsl_listings_countystate_array[0]->name;
										    }

						               		$output .= '<input type="text" value="'.esc_attr($dtsl_countystate).'" name="dtsl_countystate" '.$dtsl_countystate_id.' />';

						               } else {

						               		$dtsl_listings_countystate_terms = array ();
						               		if(is_array($dtsl_listings_countystate_array) && !empty($dtsl_listings_countystate_array)) {
							               		foreach($dtsl_listings_countystate_array as $dtsl_listing_countystate_array) {
							               			array_push($dtsl_listings_countystate_terms, $dtsl_listing_countystate_array->name);
							               		}
						               		}

						               		$dtsl_listings_countystate = get_categories('taxonomy=dtsl_listings_countystate&hide_empty=0');

					                        $output .= '<select name="dtsl_countystate[]" class="dtsl-chosen-select" data-placeholder="'.esc_html__('None', 'dtsl').'" multiple="multiple">';
						                        if(count($dtsl_listings_countystate) > 0) {
						                            foreach($dtsl_listings_countystate as $dtsl_listing_countystate) {
						                            	$selected_attribute = '';
								                    	if(in_array($dtsl_listing_countystate->name, $dtsl_listings_countystate_terms)) {
						                            		$selected_attribute = 'selected="selected"';
						                            	}
						                                $output .= '<option value="'.esc_attr($dtsl_listing_countystate->name).'" '.$selected_attribute.'>'.esc_html($dtsl_listing_countystate->name).'</option>';
						                            }
						                        }
					                        $output .= '</select>';

						               }

						$output .= '</div>';
					$output .= '</div>';
				$output .= '</div>';

				$output .= '<div class="dtsl-column dtsl-one-column first">';
					$output .= '<div class="dtsl-dashboard-option-item">
					                <label for="dtsl_country">'.esc_html__('Country', 'dtsl').'</label>
					                <div class="dtsl-dashboard-option-item-data">
						               <select name="dtsl_country" class="dtsl-chosen-select" '.$dtsl_country_id.'>';
		                                    $countries_list = dtsl_countries_list(true);
		                                    foreach( $countries_list as $key => $country ):
		                                        $output .= '<option value="'.$key.'" '.selected($dtsl_country, $key, false).'>'.$country.'</option>';
		                                    endforeach;
		                    $output .= '</select>
		                    		</div>
	                    </div>';
				$output .= '</div>';

				$output .= '<div class="dtsl-column dtsl-one-half first">';
					$output .= '<div class="dtsl-dashboard-option-item">
					               	<label for="dtsl_latitude">'.esc_html__('Latitude', 'dtsl').'</label>
					              	<div class="dtsl-dashboard-option-item-data">
					               		<input type="text" name="dtsl_latitude" value="'.esc_attr($dtsl_latitude).'" '.$dtsl_latitude_id.' />
					               	</div>
					            </div>';
				$output .= '</div>';

				$output .= '<div class="dtsl-column dtsl-one-half">';
					$output .= '<div class="dtsl-dashboard-option-item">
					               	<label for="dtsl_longitude">'.esc_html__('Longitude', 'dtsl').'</label>
					               	<div class="dtsl-dashboard-option-item-data">
					               		<input type="text" name="dtsl_longitude" value="'.esc_attr($dtsl_longitude).'" '.$dtsl_longitude_id.' />
					               	</div>
					            </div>';
				$output .= '</div>';

				$output .= '<div class="dtsl-column dtsl-one-column first">';
					$output .= '<div class="dtsl-dashboard-option-item">
									<div class="dtsl-dashboard-option-item-data">
					              		<div id="dtsl-addlist-map-holder"></div>
					              	</div>
					            </div>';
				$output .= '</div>';

				$output .= '<div class="dtsl-notes">'.esc_html__('You can also drag and place marker to identify your location.', 'dtsl').'</div>';

			$output .= '</div>';

		$output .= '</div>';

		// Virtual Tour
		$output .= '<div class="dtsl-dashbord-section-holder">';

			$output .= '<div class="dtsl-dashbord-section-holder-intro">';
				$output .= '<div class="dtsl-dashbord-section-title">'.esc_html__('Virtual Tour', 'dtsl').'</div>';
				$output .= '<div class="dtsl-dashbord-section-title-notes">'.sprintf( esc_html__('Add iframe code of your %1$s virtual tour.', 'dtsl'), strtolower($dt_sl_listing_singular_label) ).'</div>';
			$output .= '</div>';

			$output .= '<div class="dtsl-dashbord-section-holder-content">';
				$output .= '<div class="dtsl-dashboard-option-item">
				               	<label for="dtsl_virtual_tour">'.esc_html__('Virtual Tour Code', 'dtsl').'</label>
				               	<div class="dtsl-dashboard-option-item-data">
				               		<input type="text" value="'.esc_attr($dtsl_virtual_tour).'" name="dtsl_virtual_tour" />
				               	</div>
				            </div>';
			$output .= '</div>';

		$output .= '</div>';

	    return $output;

	}
	add_filter( 'dtsl_add_listing_fields_from_modules', 'dtsl_add_listing_fields_from_location_modules', 10, 2 );
}

?>