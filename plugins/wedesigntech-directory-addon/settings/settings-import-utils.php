<?php

function dtdr_settings_import_content() {

	$output = '';

	$incharge_singular_label = apply_filters( 'incharge_label', 'singular' );

	$output .= '<div class="dtdr-settings-import-overall-container">';

		$output .= '<div class="dtdr-settings-import-container">';

			$output .= '<div class="dtdr-import-settings-response-holder"></div>';

			$output .= '<div class="dtdr-settings-import-field">';

				$output .= '<input type="text" name="dtdr-import-file" class="dtdr-import-file" style="width:30%;" value="" readonly="readonly">';
				$output .= '<input type="hidden" name="dtdr-import-file-id" class="dtdr-import-file-id" style="width:30%;" value="">';
				$output .= '<input type="button" name="dtdr-chooseupload-file-button" class="dtdr-chooseupload-file-button" value="'.esc_html__('Choose / Upload File', 'dtdr').'">';

			$output .= '</div>';

			$output .= '<h4>'.esc_html__('( or ) leave empty to import below 2 sample data to start with.', 'dtdr').'</h4>';

			$output .= '<a href="#" class="custom-button-style dtdr-import-file-button">'.esc_html__('Import', 'dtdr').'</a>';

		$output .= '</div>';

		$output .= '<div class="dtdr-hr-invisible"></div>';

		$output .= '<h4><strong>'.esc_html__('XLSX Sample File Format', 'dtdr').'</strong></h4>';

		$output .= '<div class="dtdr-settings-data-holder">';

			$output .= '<table class="dtdr-custom-table" style="width:100%">
							<tr>
								<th>'.esc_html__('Title', 'dtdr').'</th>
								<th>'.esc_html__('MLS Number', 'dtdr').'</th>
								<th>'.sprintf(esc_html__('%1$s Ids', 'dtdr'), $incharge_singular_label).'</th>
								<th>'.esc_html__('Currency Symbol', 'dtdr').'</th>
								<th>'.esc_html__('Currency Symbol - Position', 'dtdr').'</th>
								<th>'.esc_html__('Regular Price', 'dtdr').'</th>
								<th>'.esc_html__('Sale Price', 'dtdr').'</th>
								<th>'.esc_html__('Before Price Label', 'dtdr').'</th>
								<th>'.esc_html__('After Price Label', 'dtdr').'</th>
								<th>'.esc_html__('Map Image', 'dtdr').'</th>
								<th>'.esc_html__('Address', 'dtdr').'</th>
								<th>'.esc_html__('Zip', 'dtdr').'</th>
								<th>'.esc_html__('Country', 'dtdr').'</th>
								<th>'.esc_html__('Latitude', 'dtdr').'</th>
								<th>'.esc_html__('Longitude', 'dtdr').'</th>
								<th>'.esc_html__('Media - Gallery', 'dtdr').'</th>
								<th>'.esc_html__('Media - Video', 'dtdr').'</th>
								<th>'.esc_html__('Media - Attachments', 'dtdr').'</th>
								<th>'.esc_html__('Virtual Tour', 'dtdr').'</th>
								<th>'.esc_html__('Features', 'dtdr').'</th>
								<th>'.esc_html__('Floor Plan', 'dtdr').'</th>

								<th>'.esc_html__('Start Date', 'dtdr').'</th>
								<th>'.esc_html__('End Date', 'dtdr').'</th>
								<th>'.esc_html__('Start Time', 'dtdr').'</th>
								<th>'.esc_html__('End Time', 'dtdr').'</th>
								<th>'.esc_html__('24 Hour Format', 'dtdr').'</th>

								<th>'.esc_html__('Business Hours', 'dtdr').'</th>
								<th>'.esc_html__('Business Hours- 24 Hour Format', 'dtdr').'</th>

								<th>'.esc_html__('Email', 'dtdr').'</th>
								<th>'.esc_html__('Phone', 'dtdr').'</th>
								<th>'.esc_html__('Mobile', 'dtdr').'</th>
								<th>'.esc_html__('Skype Id', 'dtdr').'</th>
								<th>'.esc_html__('Website', 'dtdr').'</th>
								<th>'.esc_html__('Social Details', 'dtdr').'</th>
								<th>'.esc_html__('Featured Image', 'dtdr').'</th>
								<th>'.esc_html__('Categories', 'dtdr').'</th>
								<th>'.esc_html__('Cities', 'dtdr').'</th>
								<th>'.esc_html__('Neighborhoods', 'dtdr').'</th>
								<th>'.esc_html__('Counties / States', 'dtdr').'</th>
								<th>'.esc_html__('Contract Types', 'dtdr').'</th>
								<th>'.esc_html__('Amenities', 'dtdr').'</th>
							</tr>
							<tr>
								<td>DTDIR Listing 1</td>
								<td>DTDIR10000001</td>
								<td>1,2</td>
								<td>$</td>
								<td>left</td>
								<td>50</td>
								<td>45</td>
								<td></td>
								<td></td>
								<td></td>
								<td>625 @ David Blake Road, Sanfrancisco 14536, USA</td>
								<td>14536</td>
								<td>US</td>
								<td></td>
								<td></td>
								<td>1,2,3,4</td>
								<td></td>
								<td>Landard Document+102|Approval Document+103</td>
								<td></td>
								<td>Area+Total Areas+1200+sq.ft.+fa fa-home+101|Bedrooms+Number of bedrooms+3++fa fa-home+102|Bathrooms+Number of bathrooms+2++fa fa-home+103|Garages+Number of garages+1++fa fa-home+104|Year Built++2018+++105|Land Size+Total Land Size+1500+sq.ft.++106</td>
								<td>First Floor+Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.+101+1200 sq.ft+4+2+$ 50000|Second Floor+Lorem ipsum dolor sit amet, consectetuer adipiscing elit.+102+1000 sq.ft+3+2+$ 30000</td>

								<td>November 1, 2018</td>
								<td>November 30, 2018</td>
								<td>09:00</td>
								<td>18:00</td>
								<td>true</td>

								<td>sunday++|monday+09:00+18:00|tuesday+09:00+18:00|wednesday+09:00+18:00|thursday+09:00+18:00|friday+09:00+18:00|saturday++</td>
								<td>true</td>

								<td>abc@proprety.com</td>
								<td>123456789</td>
								<td>987654321</td>
								<td>abcskype</td>
								<td>google.com</td>
								<td>fa-google-plus+abc.googleplus.com|fa-facebook+abc.facebook.com</td>
								<td>151</td>
								<td>2,24</td>
								<td>3</td>
								<td>4</td>
								<td>5</td>
								<td>29</td>
								<td>7,8</td>
							</tr>
							<tr>
								<td>DTDIR Listing 2</td>
								<td>DTDIR10000002</td>
								<td>3,4</td>
								<td>$</td>
								<td>left</td>
								<td>100</td>
								<td>90</td>
								<td></td>
								<td></td>
								<td></td>
								<td>625 @ David Blake Road, Sanfrancisco 14536, USA</td>
								<td>14536</td>
								<td>US</td>
								<td></td>
								<td></td>
								<td>5,6,7,8</td>
								<td></td>
								<td>Landard Document+102|Approval Document+103</td>
								<td></td>
								<td></td>
								<td></td>

								<td>November 1, 2018</td>
								<td>November 30, 2018</td>
								<td>09:00</td>
								<td>18:00</td>
								<td>true</td>

								<td>sunday++|monday+09:00+18:00|tuesday+09:00+18:00|wednesday+09:00+18:00|thursday+09:00+18:00|friday+09:00+18:00|saturday++</td>
								<td>true</td>

								<td>abc@proprety.com</td>
								<td>123456789</td>
								<td>987654321</td>
								<td>abcskype</td>
								<td>google.com</td>
								<td>fa-google-plus+abc.googleplus.com|fa-facebook+abc.facebook.com</td>
								<td>151</td>
								<td>24,2</td>
								<td>3</td>
								<td>4</td>
								<td>5</td>
								<td>29</td>
								<td>8,9</td>
							</tr>
						</table>';


		$output .= '</div>';

	$output .= '</div>';

    return $output;

}

echo dtdr_settings_import_content();

?>