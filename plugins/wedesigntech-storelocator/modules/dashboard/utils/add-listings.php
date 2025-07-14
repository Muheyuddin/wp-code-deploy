<?php

function dtsl_dashboard_addlisting_page_content($user_id, $seller_id) {

	$output = '';

	$dashboard_page_id = get_the_ID();

	$current_user = get_userdata($user_id);


	$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );
	$dt_sl_amenity_singular_label = apply_filters( 'dt_sl_amenity_label', 'singular' );
	$dt_sl_contracttype_singular_label = apply_filters( 'dt_sl_contracttype_label', 'singular' );
	$contracttype_plural_label = apply_filters( 'dt_sl_contracttype_label', 'plural' );

	$listing_mode = 'add';

	$dtsl_title = $dtsl_description = $dtsl_mls_number = $listing_featured_image_id = $dtsl_virtual_tour = '';

	$dtsl_listings_category_array = $dtsl_listings_ctype_array = $dtsl_listings_amenity_array = array ();

	$edit_item_id = isset($_REQUEST['edit_item_id']) ? dtsl_recursive_sanitize_text_field($_REQUEST['edit_item_id']) : -1;

	if($edit_item_id > 0) {

		$seller_incharges = get_users ( array ('role' => 'incharge', 'meta_key' => 'user_seller', 'meta_value' => $seller_id, 'fields' => 'ID') );

	    $edit_item_post = get_post($edit_item_id);
	    if( $user_id != $edit_item_post->post_author && !in_array($edit_item_post->post_author, $seller_incharges) ) {
	    	$output .= '<div class="dtsl-warning-notice">';
	    		$output .= '<p>'.esc_html__('You don\'t have permission to edit this item', 'dtsl').'</p>';
	    	$output .= '</div>';
	    	echo dtsl_html_output($output);
	    	return;
	    }

		$dtsl_title                       = get_the_title($edit_item_id);
		$dtsl_description                 = get_post_field('post_excerpt', $edit_item_id);
		$dtsl_mls_number                  = get_post_meta($edit_item_id, 'dtsl_mls_number', true);

		$dtsl_listings_category_array     = get_the_terms($edit_item_id, 'dtsl_listings_category');
		$dtsl_listings_ctype_array        = get_the_terms($edit_item_id, 'dtsl_listings_ctype');
		$dtsl_listings_amenity_array      = get_the_terms($edit_item_id, 'dtsl_listings_amenity');

	    $listing_mode = 'edit';

	}

	$output .= '<form name="dtsl-add-listing" method="post" action="" enctype="multipart/form-data" class="dtsl-add-listing">';

		// Title and Description
		$output .= '<div class="dtsl-dashbord-section-holder">';

			$output .= '<div class="dtsl-dashbord-section-holder-intro">';
				$output .= '<div class="dtsl-dashbord-section-title">'.esc_html__('Title & Description', 'dtsl').'</div>';
				$output .= '<div class="dtsl-dashbord-section-title-notes">'.esc_html__('Title & Description Notes.', 'dtsl').'</div>';
			$output .= '</div>';

			$output .= '<div class="dtsl-dashbord-section-holder-content">';
				$output .= '<div class="dtsl-dashboard-option-item">
				               <label for="dtsl_title">'.esc_html__('Title *', 'dtsl').'</label>
				               <input type="text" value="'.esc_attr($dtsl_title).'" name="dtsl_title" />
				            </div>';
				$output .= '<div class="dtsl-dashboard-option-item">
				               <label for="dtsl_description">'.esc_html__('Description', 'dtsl').'</label>
				               <div class="dtsl-dashboard-option-item-data">';

								    ob_start();
								    wp_editor (
					                        $dtsl_description,
					                        'dtsl_description',
					                        array(
					                            'textarea_rows' => 6,
					                            'textarea_name' => 'dtsl_description',
					                            'wpautop'       => true,
					                            'media_buttons' => false,
					                            'tabindex'      => '',
					                            'editor_css'    => '',
					                            'editor_class'  => '',
					                            'teeny'         => false,
					                            'dfw'           => false,
					                            'tinymce'       => false,
					                            'quicktags'     => array ('buttons' => 'strong,em,block,ins,ul,li,ol,close'),
					                           )
					                    );
								    $dtsl_editor = ob_get_contents();
									ob_end_clean();

									$output .= $dtsl_editor;

				    $output .= '</div>';
				$output .= '<div class="dtsl-dashboard-option-item">
				                <label for="dtsl_mls_number">'.esc_html__('MLS Number', 'dtsl').'</label>
			                    <input name="dtsl_mls_number" type="text" value="'.esc_attr($dtsl_mls_number).'" class="dtsl-mls-number" />
			                    <input type="button" value="'.esc_attr__('Generate', 'dtsl').'" class="dtsl-generate-mls-number" />
				            </div>';
				$output .= '<div class="dtsl-dashboard-option-item">
				                <label for="dtsl_page_template">'.esc_html__('Page Template', 'dtsl').'</label>
			                    '.dtsl_listing_page_template_field($edit_item_id, false).'
				            </div>';
				$output .= '</div>';
			$output .= '</div>';

		$output .= '</div>';

		// Category
		$output .= '<div class="dtsl-dashbord-section-holder">';

			$output .= '<div class="dtsl-dashbord-section-holder-intro">';
				$output .= '<div class="dtsl-dashbord-section-title">'.sprintf( esc_html__('Choose Categories, %2$s and %1$s.', 'dtsl'), $dt_sl_amenity_singular_label, $contracttype_plural_label).'</div>';
				$output .= '<div class="dtsl-dashbord-section-title-notes">'.sprintf( esc_html__('Choose categories, %3$s and %2$s for your %1$s.', 'dtsl'), strtolower($dt_sl_listing_singular_label), strtolower($dt_sl_amenity_singular_label), strtolower($contracttype_plural_label) ).'</div>';
			$output .= '</div>';

			$output .= '<div class="dtsl-dashbord-section-holder-content">';

				$output .= '<div class="dtsl-dashboard-option-item">
				               <label for="dtsl_description">'.esc_html__('Category', 'dtsl').'</label>
				               <div class="dtsl-dashboard-option-item-data">';

				               		$dtsl_listings_category_terms = array ();
				               		if(is_array($dtsl_listings_category_array) && !empty($dtsl_listings_category_array)) {
					               		foreach($dtsl_listings_category_array as $dtsl_listing_category_array) {
					               			array_push($dtsl_listings_category_terms, $dtsl_listing_category_array->name);
					               		}
				               		}

				               		$dtsl_listings_category = get_categories('taxonomy=dtsl_listings_category&hide_empty=0');

			                        $output .= '<select name="dtsl_category[]" class="dtsl-chosen-select" data-placeholder="'.esc_html__('None', 'dtsl').'" multiple="multiple">';
				                        if(count($dtsl_listings_category) > 0) {
				                            foreach($dtsl_listings_category as $dtsl_listing_category) {
				                            	$selected_attribute = '';
						                    	if(in_array($dtsl_listing_category->name, $dtsl_listings_category_terms)) {
				                            		$selected_attribute = 'selected="selected"';
				                            	}
				                                $output .= '<option value="'.esc_attr($dtsl_listing_category->name).'" '.$selected_attribute.'>'.esc_html( $dtsl_listing_category->name).'</option>';
				                            }
				                        }
			                        $output .= '</select>';

					$output .= '</div>';
				$output .= '</div>';

				$output .= '<div class="dtsl-dashboard-option-item">
				               <label for="dtsl_description">'.esc_html($dt_sl_contracttype_singular_label).'</label>
				               <div class="dtsl-dashboard-option-item-data">';

				               		$dtsl_listings_ctype_terms = array ();
				               		if(is_array($dtsl_listings_ctype_array) && !empty($dtsl_listings_ctype_array)) {
					               		foreach($dtsl_listings_ctype_array as $dtsl_listing_ctype_array) {
					               			array_push($dtsl_listings_ctype_terms, $dtsl_listing_ctype_array->name);
					               		}
				               		}

				               		$dtsl_listings_ctype = get_categories('taxonomy=dtsl_listings_ctype&hide_empty=0');

			                        $output .= '<select name="dtsl_ctype[]" class="dtsl-chosen-select" data-placeholder="'.esc_html__('None', 'dtsl').'" multiple="multiple">';
				                        if(count($dtsl_listings_ctype) > 0) {
				                            foreach($dtsl_listings_ctype as $dtsl_listing_ctype) {
				                            	$selected_attribute = '';
						                    	if(in_array($dtsl_listing_ctype->name, $dtsl_listings_ctype_terms)) {
				                            		$selected_attribute = 'selected="selected"';
				                            	}
				                                $output .= '<option value="'.esc_attr($dtsl_listing_ctype->name).'" '.$selected_attribute.'>'.esc_html( $dtsl_listing_ctype->name).'</option>';
				                            }
				                        }
			                        $output .= '</select>';

					$output .= '</div>';
				$output .= '</div>';

				$output .= '<div class="dtsl-dashboard-option-item">
				               <label for="dtsl_description">'.sprintf( esc_html__('%1$s', 'dtsl'), $dt_sl_amenity_singular_label).'</label>
				               <div class="dtsl-dashboard-option-item-data dtsl_amenities_list">';

				               		$dtsl_listings_category_amenity = array ();
				               		if(is_array($dtsl_listings_amenity_array) && !empty($dtsl_listings_amenity_array)) {
					               		foreach($dtsl_listings_amenity_array as $dtsl_listing_amenity_array) {
					               			array_push($dtsl_listings_category_amenity, $dtsl_listing_amenity_array->name);
					               		}
				               		}

				               		$dtsl_listings_amenity = get_categories('taxonomy=dtsl_listings_amenity&hide_empty=0');

			                        if(count($dtsl_listings_amenity) > 0) {
			                            foreach($dtsl_listings_amenity as $dtsl_listing_amenity) {

			                            	$checked_attribute = '';
					                    	if(in_array($dtsl_listing_amenity->name, $dtsl_listings_category_amenity)) {
			                            		$checked_attribute = 'checked="checked"';
			                            	}

											$output .= '<div class="dtsl-dashboard-option-item-list">';
												$output .= '<input type="checkbox" name="dtsl_amenity[]" id="dtsl_amenity_'.$dtsl_listing_amenity->slug.'" value="'.$dtsl_listing_amenity->name.'" '.$checked_attribute.' />';
												$output .= '<label for="dtsl_amenity_'.$dtsl_listing_amenity->slug.'">'.$dtsl_listing_amenity->name.'</label>';
											$output .= '</div>';

			                            }
			                        }

			        $output .= '</div>';

				$output .= '</div>';
			$output .= '</div>';

		$output .= '</div>';

		// Features
		$output .= '<div class="dtsl-dashbord-section-holder">';

			$output .= '<div class="dtsl-dashbord-section-holder-intro">';
				$output .= '<div class="dtsl-dashbord-section-title">'.esc_html__('Features', 'dtsl').'</div>';
				$output .= '<div class="dtsl-dashbord-section-title-notes">'.sprintf( esc_html__('You can add any number of features for your %1$s.', 'dtsl'), strtolower($dt_sl_listing_singular_label) ).'</div>';
			$output .= '</div>';

			$output .= '<div class="dtsl-dashbord-section-holder-content">';
				$output .= '<div class="dtsl-dashboard-option-item">
				               	<label for="dtsl_features">'.esc_html__('Add Features', 'dtsl').'</label>
				               	<div class="dtsl-dashboard-option-item-data">';
				                	$output .= dtsl_listing_features_field($edit_item_id);
				    $output .= '</div>';
				$output .= '</div>';
			$output .= '</div>';

		$output .= '</div>';

		// Incharge
		if(!in_array('incharge', (array) $current_user->roles)) {

			$incharge_singular_label = apply_filters( 'dt_sl_incharge_label', 'singular' );

			$output .= '<div class="dtsl-dashbord-section-holder">';

				$output .= '<div class="dtsl-dashbord-section-holder-intro">';
					$output .= '<div class="dtsl-dashbord-section-title">'.sprintf( esc_html__('%1$s', 'dtsl'), $incharge_singular_label ).'</div>';
					$output .= '<div class="dtsl-dashbord-section-title-notes">'.sprintf( esc_html__('If you want to add %2$s person for your %1$s than you can do that here.', 'dtsl'), strtolower($dt_sl_listing_singular_label), strtolower($incharge_singular_label) ).'</div>';
				$output .= '</div>';

				$output .= '<div class="dtsl-dashbord-section-holder-content">';
					$output .= '<div class="dtsl-dashboard-option-item">
					               	<label for="dtsl_incharge">'.sprintf( esc_html__('%1$s', 'dtsl'), $incharge_singular_label ).'</label>
					               	<div class="dtsl-dashboard-option-item-data">
					               		'.dtsl_listing_incharge_field($edit_item_id, 'seller').'
					               	</div>
					            </div>';
				$output .= '</div>';

			$output .= '</div>';

		}


		// Add Listing Fields From Modules

		$output .= apply_filters( 'dtsl_add_listing_fields_from_modules', '', $edit_item_id );


		// Notice And Submit form

		$output .= '<div class="dtsl-dashbord-section-holder">';

			$output .= '<div class="dtsl-dashboard-notices"></div>';

			$output .= '<input type="hidden" value="'.get_permalink($dashboard_page_id).'" name="dtsl_dashboard_page_url" class="dtsl_dashboard_page_url" />';

			if($edit_item_id > 0) {
				$output .= '<a class="custom-button-style dtsl-add-listing-button" onclick="return false;" data-listing-mode="'.$listing_mode.'" data-listing-edit-item-id="'.$edit_item_id.'" data-user-id="'.$user_id.'" data-seller-id="'.$seller_id.'">'.sprintf( esc_html__('Update %1$s', 'dtsl'), $dt_sl_listing_singular_label ).'</a>';
			} else {
				$output .= '<a class="custom-button-style dtsl-add-listing-button" onclick="return false;" data-listing-mode="'.$listing_mode.'" data-listing-edit-item-id="'.$edit_item_id.'" data-user-id="'.$user_id.'" data-seller-id="'.$seller_id.'">'.sprintf( esc_html__('Add %1$s', 'dtsl'), $dt_sl_listing_singular_label ).'</a>';
			}

		$output .= '</div>';

	$output .= '</form>';

	return $output;

}

function dtsl_dashboard_addlisting_consumed_notices($active_seller_package_id) {

	$output = '';

	$listing_plural_label = apply_filters( 'dt_sl_listing_label', 'plural' );

	$output .= '<div class="dtsl-dashbord-section-holder">';
		$output .= '<div class="dtsl-dashbord-section-holder-intro">';
			$output .= '<div class="dtsl-dashbord-section-title">'.esc_html__('Warning!', 'dtsl').'</div>';
		$output .= '</div>';
		$output .= '<div class="dtsl-dashbord-section-holder-content">';
			$output .= '<div class="dtsl-warning-notice">';
				$output .= '<p>'.sprintf(esc_html__('You have consumed all your allowed %1$s from %2$s package', 'dtsl'), strtolower($listing_plural_label), '<strong>'.get_the_title($active_seller_package_id).'</strong>').'</p>';
			$output .= '</div>';
		$output .= '</div>';
	$output .= '</div>';

	return $output;

}

function dtsl_dashboard_addlisting_expired_notices($active_seller_package_id) {

	$output = '';

	$output .= '<div class="dtsl-dashbord-section-holder">';
		$output .= '<div class="dtsl-dashbord-section-holder-intro">';
			$output .= '<div class="dtsl-dashbord-section-title">'.esc_html__('Warning!', 'dtsl').'</div>';
		$output .= '</div>';
		$output .= '<div class="dtsl-dashbord-section-holder-content">';
			$output .= '<div class="dtsl-warning-notice">';
				if($active_seller_package_id == -1) {
					$output .= '<p>'.esc_html__('No package active, please contact your seller for further details', 'dtsl').'</p>';
				} else if($active_seller_package_id > 0) {
					$output .= '<p>'.sprintf(esc_html__('Your package %1$s have been expired', 'dtsl'), '<strong>'.get_the_title($active_seller_package_id).'</strong>').'</p>';
				}
			$output .= '</div>';
		$output .= '</div>';
	$output .= '</div>';

	return $output;

}

function dtsl_dashboard_addlisting_purchasepackage_notices() {

	$output = '';

	$listing_plural_label = apply_filters( 'dt_sl_listing_label', 'plural' );

	$seller_purchase_package_shortcode = dtsl_option('general','seller-purchase-package-shortcode');

	$output .= '<div class="dtsl-dashbord-section-holder">';
		$output .= '<div class="dtsl-dashbord-section-holder-intro">';
			$output .= '<div class="dtsl-dashbord-section-title">'.esc_html__('Available Packages', 'dtsl').'</div>';
			$output .= '<div class="dtsl-dashbord-section-title-notes">'.sprintf( esc_html__('Please purchase any of the available packages to add your %1$s.', 'dtsl'), strtolower($listing_plural_label) ).'</div>';
		$output .= '</div>';
		$output .= '<div class="dtsl-dashbord-section-holder-content">';
			$output .= do_shortcode(stripslashes($seller_purchase_package_shortcode));
		$output .= '</div>';
	$output .= '</div>';

	return $output;

}

// Add listing from frontend
add_action( 'wp_ajax_dtsl_add_frontend_listing', 'dtsl_add_frontend_listing' );
add_action( 'wp_ajax_nopriv_dtsl_add_frontend_listing', 'dtsl_add_frontend_listing' );
function dtsl_add_frontend_listing() {

	extract(dtsl_recursive_sanitize_text_field($_REQUEST));

	$current_user = get_userdata($user_id);

	$user_roles = ( array ) $current_user->roles;

	$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );
	$listing_plural_label = apply_filters( 'dt_sl_listing_label', 'plural' );

	$dtsl_listing_mode         = isset($_REQUEST['dtsl_listing_mode']) ? dtsl_recursive_sanitize_text_field($_REQUEST['dtsl_listing_mode']) : 'add';
	$dtsl_listing_edit_item_id = isset($_REQUEST['dtsl_listing_edit_item_id']) ? dtsl_recursive_sanitize_text_field($_REQUEST['dtsl_listing_edit_item_id']) : -1;


	$has_error = false;
	$errors = array ();
	if($dtsl_title == '') {
		$has_error = true;
		$errors[] = '<p>'.sprintf( esc_html__('Please give title for your %1$s', 'dtsl'), strtolower($dt_sl_listing_singular_label) ).'</p>';
	}

	if( isset( $dtsl_mls_number ) && $dtsl_mls_number != '') {

		$args = array (
					'posts_per_page' => -1,
					'post_type'      => 'dtsl_listings',
					'meta_query'     => array (),
					'post_status'    => array ( 'any' ),
				);

    	if($dtsl_listing_mode == 'edit' && $dtsl_listing_edit_item_id > 0) {
		    $args['post__not_in'] = array ($dtsl_listing_edit_item_id);
    	}

		$args['meta_query'][] = array (
									'key'     => 'dtsl_mls_number',
									'value'   => $dtsl_mls_number,
									'compare' => 'LIKE',
								);

		$listings_query = new WP_Query( $args );
		$post_count = $listings_query->found_posts;
		wp_reset_postdata();

		if($post_count > 0) {
			$has_error = true;
			$errors[] = '<p>'.esc_html__('MLS Number you have provided is not unique, please try with unique number.', 'dtsl').'</p>';
		}

	}


    // Update seller listing count

    if($has_error) {
    	echo json_encode($errors);
    } else {

    	if($dtsl_listing_mode == 'edit' && $dtsl_listing_edit_item_id > 0) {

		    $listing_post = array (
		    	'ID'            => $dtsl_listing_edit_item_id,
		        'post_title'	=> $dtsl_title,
		        'post_excerpt'	=> $dtsl_description,
		        'post_type'     => 'dtsl_listings',
		    );

		    if(in_array('administrator', $user_roles)) {
		    	$listing_post['post_status'] = 'publish';
		    } else {
		    	if('true' ==  dtsl_option('general', 'should-admin-approve-listings')) {
		    		$listing_post['post_status'] = 'waitingforapproval';
		    	} else {
		    		$listing_post['post_status'] = 'publish';
		    	}
		    }

		    $listing_id =  wp_update_post($listing_post);

    	} else {

		    $listing_post = array (
		        'post_title'	=> $dtsl_title,
		        'post_excerpt'	=> $dtsl_description,
		        'post_type'     => 'dtsl_listings',
		        'post_author'   => $user_id
		    );

		    if(in_array('administrator', $user_roles)) {
		    	$listing_post['post_status'] = 'publish';
		    } else {
		    	if('true' ==  dtsl_option('general', 'should-admin-approve-listings')) {
		    		$listing_post['post_status'] = 'waitingforapproval';
		    	} else {
		    		$listing_post['post_status'] = 'publish';
		    	}
		    }

		    $listing_id =  wp_insert_post($listing_post);


	        // Package details
		    if($seller_id > 0) {

			    $dtsl_seller_package_used_listings_count = get_user_meta($seller_id, 'dtsl_seller_package_used_listings_count', true);
			    $dtsl_seller_package_used_listings_count++;
			    update_user_meta($seller_id, 'dtsl_seller_package_used_listings_count', $dtsl_seller_package_used_listings_count);

			}

    	}

    	update_post_meta($listing_id, 'dtsl_mls_number', $dtsl_mls_number);
    	update_post_meta($listing_id, 'dtsl_page_template', $dtsl_page_template);


    	// Category, Contract Types & Tags

    	wp_set_object_terms($listing_id, $dtsl_category, 'dtsl_listings_category');
    	wp_set_object_terms($listing_id, $dtsl_ctype, 'dtsl_listings_ctype');
    	wp_set_object_terms($listing_id, $dtsl_amenity, 'dtsl_listings_amenity');


        // Features

        update_post_meta($listing_id, 'dtsl_features_title', $dtsl_features_title);
        update_post_meta($listing_id, 'dtsl_features_subtitle', $dtsl_features_subtitle);
        update_post_meta($listing_id, 'dtsl_features_value', $dtsl_features_value);
        update_post_meta($listing_id, 'dtsl_features_valueunit', $dtsl_features_valueunit);
        update_post_meta($listing_id, 'dtsl_features_icon', $dtsl_features_icon);
        update_post_meta($listing_id, 'dtsl_features_image', $dtsl_features_image);


        // Incharges

        update_post_meta($listing_id, 'dtsl_incharges', $dtsl_incharges);


		// Add or Update listing from modules
		do_action('dtsl_addorupdate_listing_module', dtsl_recursive_sanitize_text_field($_REQUEST), $listing_id);


        // Email Notification

        if(dtsl_option('general', 'enable-email-seller') == 'true') {

	        if($dtsl_listing_mode == 'add') {

		        if($seller_id > 0 && $user_id > 0) {

			        if($seller_id != $user_id) {

			        	$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );
			        	$incharge_singular_label = apply_filters( 'dt_sl_incharge_label', 'singular' );

						$seller_email = get_the_author_meta('email', $seller_id);
						$to = array ($seller_email);

						if(dtsl_option('general', 'enable-email-admin') == 'true') {
							$admin_email = get_option('admin_email');
							array_push($to, $admin_email);
						}

						$subject = sprintf(esc_html__('New %1$s Added', 'dtsl'), $dt_sl_listing_singular_label);

			        	$message = sprintf(esc_html__('New %1$s %2$s have been added by %3$s - %4$s.', 'dtsl'), $dt_sl_listing_singular_label, '<strong>'.get_the_title($listing_id).'</strong>', $incharge_singular_label, '<strong>'.get_the_author_meta( 'display_name' , $user_id ).'</strong>');

			        	dtsl_email_configuration($to, $subject, $message);

			        }


			        if($seller_id == $user_id) {

			        	if(dtsl_option('general', 'enable-email-admin') == 'true') {

				        	$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );
				        	$seller_singular_label = apply_filters( 'dt_sl_seller_label', 'singular' );

							$to = get_option('admin_email');

							$subject = sprintf(esc_html__('New %1$s Added', 'dtsl'), $dt_sl_listing_singular_label);

				        	$message = sprintf(esc_html__('New %1$s %2$s have been added by %3$s - %4$s.', 'dtsl'), $dt_sl_listing_singular_label, '<strong>'.get_the_title($listing_id).'</strong>', $seller_singular_label, '<strong>'.get_the_author_meta( 'display_name' , $user_id ).'</strong>');

				        	dtsl_email_configuration($to, $subject, $message);

				        }

			        }



			    }

			}

		}


	    echo 'success';

    }


	die();

}

?>