<?php

function dtsl_settings_import_content() {

	$output = '';

	$incharge_singular_label = apply_filters( 'dt_sl_incharge_label', 'singular' );

	$output .= '<div class="dtsl-settings-import-overall-container">';

		$output .= '<div class="dtsl-settings-import-container">';

			$output .= '<div class="dtsl-import-settings-response-holder"></div>';

			$output .= '<div class="dtsl-settings-import-field">';

				$output .= '<input type="text" name="dtsl-import-file" class="dtsl-import-file" style="width:30%;" value="" readonly="readonly">';
				$output .= '<input type="hidden" name="dtsl-import-file-id" class="dtsl-import-file-id" style="width:30%;" value="">';
				$output .= '<input type="button" name="dtsl-chooseupload-file-button" class="dtsl-chooseupload-file-button" value="'.esc_html__('Choose / Upload File', 'dtsl').'">';

			$output .= '</div>';

			$output .= '<h4>'.esc_html__('( or ) leave empty to import below 2 sample data to start with.', 'dtsl').'</h4>';

			$output .= '<a href="#" class="custom-button-style dtsl-import-file-button">'.esc_html__('Import', 'dtsl').'</a>';

		$output .= '</div>';

		$output .= '<div class="dtsl-hr-invisible"></div>';

		$output .= '<h4><strong>'.esc_html__('XLSX Sample File Format', 'dtsl').'</strong></h4>';

		$output .= '<div class="dtsl-settings-data-holder">';

			$output .= '<table class="dtsl-custom-table" style="width:100%">
							<tr>
								<th>'.esc_html__('Title', 'dtsl').'</th>
								<th>'.esc_html__('MLS Number', 'dtsl').'</th>
								<th>'.sprintf(esc_html__('%1$s Ids', 'dtsl'), $incharge_singular_label).'</th>
								<th>'.esc_html__('Currency Symbol', 'dtsl').'</th>
								<th>'.esc_html__('Currency Symbol - Position', 'dtsl').'</th>
								<th>'.esc_html__('Regular Price', 'dtsl').'</th>
								<th>'.esc_html__('Sale Price', 'dtsl').'</th>
								<th>'.esc_html__('Before Price Label', 'dtsl').'</th>
								<th>'.esc_html__('After Price Label', 'dtsl').'</th>
								<th>'.esc_html__('Map Image', 'dtsl').'</th>
								<th>'.esc_html__('Address', 'dtsl').'</th>
								<th>'.esc_html__('Zip', 'dtsl').'</th>
								<th>'.esc_html__('Country', 'dtsl').'</th>
								<th>'.esc_html__('Latitude', 'dtsl').'</th>
								<th>'.esc_html__('Longitude', 'dtsl').'</th>
								<th>'.esc_html__('Media - Gallery', 'dtsl').'</th>
								<th>'.esc_html__('Media - Video', 'dtsl').'</th>
								<th>'.esc_html__('Media - Attachments', 'dtsl').'</th>
								<th>'.esc_html__('Virtual Tour', 'dtsl').'</th>
								<th>'.esc_html__('Features', 'dtsl').'</th>
								<th>'.esc_html__('Floor Plan', 'dtsl').'</th>

								<th>'.esc_html__('Start Date', 'dtsl').'</th>
								<th>'.esc_html__('End Date', 'dtsl').'</th>
								<th>'.esc_html__('Start Time', 'dtsl').'</th>
								<th>'.esc_html__('End Time', 'dtsl').'</th>
								<th>'.esc_html__('24 Hour Format', 'dtsl').'</th>

								<th>'.esc_html__('Business Hours', 'dtsl').'</th>
								<th>'.esc_html__('Business Hours- 24 Hour Format', 'dtsl').'</th>

								<th>'.esc_html__('Email', 'dtsl').'</th>
								<th>'.esc_html__('Phone', 'dtsl').'</th>
								<th>'.esc_html__('Mobile', 'dtsl').'</th>
								<th>'.esc_html__('Skype Id', 'dtsl').'</th>
								<th>'.esc_html__('Website', 'dtsl').'</th>
								<th>'.esc_html__('Social Details', 'dtsl').'</th>
								<th>'.esc_html__('Featured Image', 'dtsl').'</th>
								<th>'.esc_html__('Categories', 'dtsl').'</th>
								<th>'.esc_html__('Cities', 'dtsl').'</th>
								<th>'.esc_html__('Neighborhoods', 'dtsl').'</th>
								<th>'.esc_html__('Counties / States', 'dtsl').'</th>
								<th>'.esc_html__('Contract Types', 'dtsl').'</th>
								<th>'.esc_html__('Amenities', 'dtsl').'</th>
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

echo dtsl_settings_import_content();

?>