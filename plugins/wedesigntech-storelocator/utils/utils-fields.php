<?php

// Dashboard Features Field
function dtsl_listing_features_field($item_id) {

	$output = '';

    $output .= '<div class="dtsl-features-box-container">';

    	$output .= '<div class="dtsl-features-box-item-holder">';

			$dtsl_features_title = $dtsl_features_subtitle = $dtsl_features_value = $dtsl_features_valueunit = $dtsl_features_icon = $dtsl_features_image = '';
			if($item_id > 0) {
				$dtsl_features_title = get_post_meta($item_id, 'dtsl_features_title', true);
				$dtsl_features_subtitle = get_post_meta($item_id, 'dtsl_features_subtitle', true);
				$dtsl_features_value = get_post_meta($item_id, 'dtsl_features_value', true);
				$dtsl_features_valueunit = get_post_meta($item_id, 'dtsl_features_valueunit', true);
				$dtsl_features_icon = get_post_meta($item_id, 'dtsl_features_icon', true);
				$dtsl_features_image = get_post_meta($item_id, 'dtsl_features_image', true);
			}

			$j = 0;
			if(is_array($dtsl_features_title) && !empty($dtsl_features_title)) {
				foreach($dtsl_features_title as $dtsl_feature_title) {
					$image_url = wp_get_attachment_image_src($dtsl_features_image[$j], 'full');
					$image_url = isset($image_url[0]) ? $image_url[0] : '';

					$output .= '<div class="dtsl-features-box-item">
									<div class="dtsl-column dtsl-one-half first">
										<input name="dtsl_tab_id" class="dtsl_tab_id" type="text" value="'.esc_attr($j).'" readonly />
									</div>
									<div class="dtsl-column dtsl-one-half">
										<input name="dtsl_features_title[]" type="text" value="'.esc_attr($dtsl_feature_title).'" placeholder="'.esc_html__('Title', 'dtsl').'" />
									</div>
									<div class="dtsl-column dtsl-one-half first">
										<input name="dtsl_features_subtitle[]" type="text" value="'.esc_attr($dtsl_features_subtitle[$j]).'" placeholder="'.esc_html__('Sub Title', 'dtsl').'" />
									</div>
									<div class="dtsl-column dtsl-one-half">
										<input name="dtsl_features_value[]" type="text" value="'.esc_attr($dtsl_features_value[$j]).'" placeholder="'.esc_html__('Value', 'dtsl').'" />
									</div>
									<div class="dtsl-column dtsl-one-half first">
										<input name="dtsl_features_valueunit[]" type="text" value="'.esc_attr($dtsl_features_valueunit[$j]).'" placeholder="'.esc_html__('Value Unit', 'dtsl').'" />
									</div>
									<div class="dtsl-column dtsl-one-half">
										<input name="dtsl_features_icon[]" type="text" value="'.esc_attr($dtsl_features_icon[$j]).'" placeholder="'.esc_html__('Icon', 'dtsl').'" />
									</div>
									<div class="dtsl-column dtsl-one-column first dtsl-upload-media-items-container">
										<input name="dtsl_features_image_url" type="text" value="'.esc_url($image_url).'" placeholder="'.esc_html__('Image', 'dtsl').'" class="uploadfieldurl" readonly />
										<input name="dtsl_features_image[]" type="hidden" value="'.esc_attr($dtsl_features_image[$j]).'" placeholder="'.esc_html__('Image', 'dtsl').'" class="uploadfieldid" readonly />
						                <input type="button" value="'.esc_html__('Upload', 'dtsl').'" class="dtsl-upload-media-item-button show-preview" />
						                <input type="button" value="'.esc_html__('Remove', 'dtsl').'" class="dtsl-upload-media-item-reset" />
						                '.dtsl_adminpanel_image_preview($image_url).'
									</div>
									<div class="dtsl-features-box-options">
										<span class="dtsl-remove-features"><span class="fas fa-times"></span></span>
					                    <span class="dtsl-sort-features"><span class="fas fa-arrows-alt"></span></span>
									</div>
								</div>';
					$j++;
				}
			}

		$output .= '</div>';

		$output .= '<a href="#" class="dtsl-add-features-box custom-button-style">'.esc_html__('Add Feature', 'dtsl').'</a>';

		$output .= '<div class="dtsl-features-box-item-toclone hidden">
						<div class="dtsl-column dtsl-one-half first">
							<input name="dtsl_tab_id" id="dtsl_tab_id" type="text" value="" readonly />
						</div>
						<div class="dtsl-column dtsl-one-half">
							<input id="dtsl_features_title" type="text" placeholder="'.esc_html__('Title', 'dtsl').'" />
						</div>
						<div class="dtsl-column dtsl-one-half first">
							<input id="dtsl_features_subtitle" type="text" placeholder="'.esc_html__('Sub Title', 'dtsl').'" />
						</div>
						<div class="dtsl-column dtsl-one-half">
							<input id="dtsl_features_value" type="text" placeholder="'.esc_html__('Value', 'dtsl').'" />
						</div>
						<div class="dtsl-column dtsl-one-half first">
							<input id="dtsl_features_valueunit" type="text" placeholder="'.esc_html__('Value Unit', 'dtsl').'" />
						</div>
						<div class="dtsl-column dtsl-one-half">
							<input id="dtsl_features_icon" type="text" placeholder="'.esc_html__('Icon', 'dtsl').'" />
						</div>
						<div class="dtsl-column dtsl-one-column first dtsl-upload-media-items-container">
							<input name="dtsl_features_image_url" type="text" placeholder="'.esc_html__('Image', 'dtsl').'" class="uploadfieldurl" readonly />
							<input id="dtsl_features_image" type="hidden" placeholder="'.esc_html__('Image', 'dtsl').'" class="uploadfieldid" readonly />
			                <input type="button" value="'.esc_html__('Upload', 'dtsl').'" class="dtsl-upload-media-item-button show-preview" />
			                <input type="button" value="'.esc_html__('Remove', 'dtsl').'" class="dtsl-upload-media-item-reset" />
			                '.dtsl_adminpanel_image_preview('').'
						</div>
						<div class="dtsl-features-box-options">
							<span class="dtsl-remove-features"><span class="fas fa-times"></span></span>
		                    <span class="dtsl-sort-features"><span class="fas fa-arrows-alt"></span></span>
						</div>
					</div>';

    $output .= '</div>';

    return $output;

}

// Dashboard User Profile Picture Field
function dtsl_user_profile_picture_field($user_id) {

	$output = '';

	$dtsl_user_profile_image_url = get_the_author_meta( 'dtsl_user_profile_image_url' , $user_id );
	$dtsl_user_profile_image     = get_the_author_meta( 'dtsl_user_profile_image' , $user_id );

	$output .= '<div class="dtsl-upload-media-items-container">
					'.dtsl_adminpanel_image_holder($dtsl_user_profile_image_url).'
					<input name="dtsl_user_profile_image_url" type="text" value="'.$dtsl_user_profile_image_url.'" placeholder="'.esc_html__('Image', 'dtsl').'" class="uploadfieldurl" readonly />
					<input name="dtsl_user_profile_image" value="'.$dtsl_user_profile_image.'" type="hidden" placeholder="'.esc_html__('Image', 'dtsl').'" class="uploadfieldid" readonly />
	                <input type="button" value="'.esc_html__('Upload', 'dtsl').'" class="dtsl-upload-media-item-button show-image-holder" />
	                <input type="button" value="'.esc_html__('Remove', 'dtsl').'" class="dtsl-upload-media-item-reset" />
				</div>';

	return $output;

}

// Dashboard Social Details Field
function dtsl_social_details_field($item_id, $item_type) {

	$output = '';

	$sociables = array('fa-dribbble' => 'Dribble', 'fa-flickr' => 'Flickr', 'fa-github' => 'GitHub', 'fa-pinterest' => 'Pinterest', 'fa-stack-overflow' => 'Stack Overflow', 'fa-twitter' => 'Twitter', 'fa-youtube' => 'YouTube', 'fa-android' => 'Android', 'fa-dropbox' => 'Dropbox', 'fa-instagram' => 'Instagram', 'fa-facebook' => 'Facebook', 'fa-google-plus' => 'Google Plus', 'fa-linkedin' => 'LinkedIn', 'fa-skype' => 'Skype', 'fa-tumblr' => 'Tumblr', 'fa-vimeo-square' => 'Vimeo', 'fa-whatsapp' => 'Whatsapp');

	$output .= '<div class="dtsl-social-item-details-container">';

			if($item_type == 'user') {
				$dtsl_social_items = get_the_author_meta('dtsl_user_social_items', $item_id);
				$dtsl_social_items = (isset($dtsl_social_items) && is_array($dtsl_social_items)) ? $dtsl_social_items : array ();
			} else {
				$dtsl_social_items = get_post_meta($item_id, 'dtsl_social_items', true);
				$dtsl_social_items = (isset($dtsl_social_items) && is_array($dtsl_social_items)) ? $dtsl_social_items : array ();
			}

			if($item_type == 'user') {
				$dtsl_social_items_value = get_the_author_meta('dtsl_user_social_items_value', $item_id);
				$dtsl_social_items_value = (isset($dtsl_social_items_value) && is_array($dtsl_social_items_value)) ? $dtsl_social_items_value : array ();
			} else {
				$dtsl_social_items_value = get_post_meta($item_id, 'dtsl_social_items_value', true);
				$dtsl_social_items_value = (isset($dtsl_social_items_value) && is_array($dtsl_social_items_value)) ? $dtsl_social_items_value : array ();
			}

			$i = 0;
			foreach($dtsl_social_items as $dtsl_social_item) {

			    $output .=  '<div class="dtsl-social-item-section">';

					$output .=  '<select class="dtsl-social-item-list dtsl-social-chosen-select" name="dtsl_social_items[]">';
						foreach ( $sociables as $sociable_key => $sociable_value ) :
							$s = ($sociable_key == $dtsl_social_item) ? 'selected="selected"' : '';
							$v = ucwords ( $sociable_value );
							$output .=  '<option value="'.$sociable_key.'" '.$s.'>'.$v.'</option>';
						endforeach;
					$output .=  '</select>';

			        $output .=  '<input class="large" type="text" placeholder="'.esc_html__('Social Link', 'dtsl').'" name="dtsl_social_items_value[]" value="'.$dtsl_social_items_value[$i].'" />';

					$output .=  '<div class="dtsl-social-item-section-options">
									<span class="dtsl-remove-social-item"><span class="fas fa-times"></span></span>
				                    <span class="dtsl-sort-features"><span class="fas fa-arrows-alt"></span></span>
								</div>';

			    $output .=  '</div>';

			    $i++;

			}

	$output .=  '</div>';

    $output .=  '<a href="#" class="dtsl-add-social-details custom-button-style">'.esc_html__('Add Social Item', 'dtsl').'</a>';

    $output .=  '<div id="dtsl-social-details-section-to-clone" class="hidden">';

		$output .=  '<select class="dtsl-social-item-list">';
			foreach ( $sociables as $key => $value ) :
				$v = ucwords ( $value );
				$output .=  '<option value="'.$key.'">'.$v.'</option>';
			endforeach;
		$output .=  '</select>';

        $output .=  '<input class="large" type="text" placeholder="'.esc_html__('Social Link', 'dtsl').'" />';

		$output .=  '<div class="dtsl-social-item-section-options">
						<span class="dtsl-remove-social-item"><span class="fas fa-times"></span></span>
	                    <span class="dtsl-sort-features"><span class="fas fa-arrows-alt"></span></span>
					</div>';

    $output .=  '</div>';

    return $output;

}

// Dashboard Upload Map Marker
function dtsl_upload_promoflash_image($item_id) {

	$output = '';

	$dtsl_map_image = get_post_meta($item_id, 'dtsl_map_image', true);

	$image_url = wp_get_attachment_image_src($dtsl_map_image, 'full');
	$map_image = isset($image_url[0]) ? $image_url[0] : '';

	$output .= '<div class="dtsl-upload-media-items-container">
					'.dtsl_adminpanel_image_holder($map_image).'
					<input name="dtsl_promoflash_url" type="text" value="'.$map_image.'" placeholder="'.esc_html__('Image', 'dtsl').'" class="uploadfieldurl" readonly />
					<input name="dtsl_map_image" value="'.$dtsl_map_image.'" type="hidden" placeholder="'.esc_html__('Image', 'dtsl').'" class="uploadfieldid" readonly />
					<input type="button" value="'.esc_html__('Upload', 'dtsl').'" class="dtsl-upload-media-item-button show-image-holder" />
					<input type="button" value="'.esc_html__('Remove', 'dtsl').'" class="dtsl-upload-media-item-reset" />
				</div>';

	return $output;

}

// Incharge filed
function dtsl_listing_incharge_field($item_id, $user_type) {

	$output = '';

	$dtsl_incharges = get_post_meta($item_id, 'dtsl_incharges', true);
	$dtsl_incharges = (is_array($dtsl_incharges) && !empty($dtsl_incharges)) ? $dtsl_incharges : array ();

	$output .= '<div class="dtsl-incharge-module-container">';

        $output .= '<select name="dtsl_incharges[]" class="dtsl-chosen-select" data-placeholder="'.esc_html__('None', 'dtsl').'" multiple="multiple">';

        	if($user_type == 'admin') {
				$incharges = get_users ( array ('role' => 'incharge') );
			} else {
				$current_user_id = get_current_user_id();
				$incharges = get_users ( array ('role' => 'incharge', 'meta_key' => 'user_seller', 'meta_value' => $current_user_id) );
			}


			if(is_array($incharges) && !empty($incharges)) {
				foreach ( $incharges as $incharge ) {
					setup_postdata( $incharge );

					$incharge_id = $incharge->data->ID;

                	$selected_attribute = '';
                	if(in_array($incharge_id, $dtsl_incharges)) {
                		$selected_attribute = 'selected="selected"';
                	}

					$output .= '<option value="'.esc_attr($incharge_id).'" '.$selected_attribute.'>'.esc_html(get_the_author_meta('display_name', $incharge_id)).'</option>';

				}

			}

        $output .= '</select>';

	$output .= '</div>';


	return $output;

}

// Page Template Field
function dtsl_listing_page_template_field($item_id, $admin = false) {

	$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );

	$output = '';

	$output .= '<div class="dtsl-page-template-module-container">';

		$dtsl_page_template = get_post_meta($item_id, 'dtsl_page_template', true);
		$dtsl_page_template = ($dtsl_page_template != '') ? $dtsl_page_template : 'admin-option';

		$tpl_args = array (
			'post_type' => 'page',
			'meta_key' => '_wp_page_template',
			'meta_value' => 'tpl-single-listing.php',
			'posts_per_page' => -1,
			'suppress_filters' => 0
		);
		$single_tpl_posts = get_posts($tpl_args);

		$output .= '<select name="dtsl_page_template" class="dtsl-chosen-select">';

			$output .= '<option value="admin-option" '.selected('admin-option', $dtsl_page_template, false ).'>'.esc_html__('Admin Option', 'dtsl').'</option>';
			$output .= '<option value="custom-template" '.selected('custom-template', $dtsl_page_template, false ).'>'.esc_html__('Custom Template', 'dtsl').'</option>';
			$output .= '<option value="default-template-1" '.selected('default-template-1', $dtsl_page_template, false ).'>'.esc_html__('Default Template 1', 'dtsl').'</option>';

			if(is_array($single_tpl_posts) && !empty($single_tpl_posts)) {
				foreach($single_tpl_posts as $single_tpl_post) {
					$output .= '<option value="'.$single_tpl_post->ID.'" '.selected($single_tpl_post->ID, $dtsl_page_template, false ).'>';
						$output .= $single_tpl_post->post_title;
					$output .= '</option>';
				}
			}

		$output .= '</select>';

		if($admin) {
			$output .= '<div class="dtsl-note">'.sprintf( esc_html__('If you like to build your %1$s single page by your own choose "Custom Template" else choose one of the predefined templates created using "Store Locator Single Page Template".', 'dtsl'), $dt_sl_listing_singular_label ).'</div>';
		} else {
			$output .= '<div class="dtsl-note">'.sprintf( esc_html__('If you like to build your %1$s single page by your own choose "Custom Template" else choose one of the predefined templates created using "Store Locator Single Page Template". Get Admin support to build your "Custom Template"', 'dtsl'), $dt_sl_listing_singular_label ).'</div>';
		}

	$output .= '</div>';


	return $output;

}
?>