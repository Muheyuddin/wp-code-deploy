<?php

function dtdr_dashboard_addlisting_page_content($user_id, $seller_id) {

	$output = '';

	$dashboard_page_id = get_the_ID();

	$current_user = get_userdata($user_id);


	$listing_singular_label = apply_filters( 'listing_label', 'singular' );
	$amenity_singular_label = apply_filters( 'amenity_label', 'singular' );
	$contracttype_singular_label = apply_filters( 'contracttype_label', 'singular' );
	$contracttype_plural_label = apply_filters( 'contracttype_label', 'plural' );

	$listing_mode = 'add';

	$dtdr_title = $dtdr_description = $dtdr_mls_number = $listing_featured_image_id = $dtdr_virtual_tour = '';

	$dtdr_listings_category_array = $dtdr_listings_ctype_array = $dtdr_listings_amenity_array = array ();

	$edit_item_id = isset($_REQUEST['edit_item_id']) ? dtdr_recursive_sanitize_text_field($_REQUEST['edit_item_id']) : -1;

	if($edit_item_id > 0) {

		$seller_incharges = get_users ( array ('role' => 'incharge', 'meta_key' => 'user_seller', 'meta_value' => $seller_id, 'fields' => 'ID') );

	    $edit_item_post = get_post($edit_item_id);
	    if( $user_id != $edit_item_post->post_author && !in_array($edit_item_post->post_author, $seller_incharges) ) {
	    	$output .= '<div class="dtdr-warning-notice">';
	    		$output .= '<p>'.esc_html__('You don\'t have permission to edit this item', 'dtdr').'</p>';
	    	$output .= '</div>';
	    	echo dtdr_html_output($output);
	    	return;
	    }

		$dtdr_title                       = get_the_title($edit_item_id);
		$dtdr_description                 = get_post_field('post_excerpt', $edit_item_id);
		$dtdr_mls_number                  = get_post_meta($edit_item_id, 'dtdr_mls_number', true);

		$dtdr_listings_category_array     = get_the_terms($edit_item_id, 'dtdr_listings_category');
		$dtdr_listings_ctype_array        = get_the_terms($edit_item_id, 'dtdr_listings_ctype');
		$dtdr_listings_amenity_array      = get_the_terms($edit_item_id, 'dtdr_listings_amenity');

	    $listing_mode = 'edit';

	}

	$output .= '<form name="dtdr-add-listing" method="post" action="" enctype="multipart/form-data" class="dtdr-add-listing">';

		// Title and Description
		$output .= '<div class="dtdr-dashbord-section-holder">';

			$output .= '<div class="dtdr-dashbord-section-holder-intro">';
				$output .= '<div class="dtdr-dashbord-section-title">'.esc_html__('Title & Description', 'dtdr').'</div>';
				$output .= '<div class="dtdr-dashbord-section-title-notes">'.esc_html__('Title & Description Notes.', 'dtdr').'</div>';
			$output .= '</div>';

			$output .= '<div class="dtdr-dashbord-section-holder-content">';
				$output .= '<div class="dtdr-dashboard-option-item">
				               <label for="dtdr_title">'.esc_html__('Title *', 'dtdr').'</label>
				               <input type="text" value="'.esc_attr($dtdr_title).'" name="dtdr_title" />
				            </div>';
				$output .= '<div class="dtdr-dashboard-option-item">
				               <label for="dtdr_description">'.esc_html__('Description', 'dtdr').'</label>
				               <div class="dtdr-dashboard-option-item-data">';

								    ob_start();
								    wp_editor (
					                        $dtdr_description,
					                        'dtdr_description',
					                        array(
					                            'textarea_rows' => 6,
					                            'textarea_name' => 'dtdr_description',
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
								    $dtdr_editor = ob_get_contents();
									ob_end_clean();

									$output .= $dtdr_editor;

				    $output .= '</div>';
				$output .= '<div class="dtdr-dashboard-option-item">
				                <label for="dtdr_mls_number">'.esc_html__('MLS Number', 'dtdr').'</label>
			                    <input name="dtdr_mls_number" type="text" value="'.esc_attr($dtdr_mls_number).'" class="dtdr-mls-number" />
			                    <input type="button" value="'.esc_attr__('Generate', 'dtdr').'" class="dtdr-generate-mls-number" />
				            </div>';
				$output .= '<div class="dtdr-dashboard-option-item">
				                <label for="dtdr_page_template">'.esc_html__('Page Template', 'dtdr').'</label>
			                    '.dtdr_listing_page_template_field($edit_item_id, false).'
				            </div>';
				$output .= '</div>';
			$output .= '</div>';

		$output .= '</div>';

		// Category
		$output .= '<div class="dtdr-dashbord-section-holder">';

			$output .= '<div class="dtdr-dashbord-section-holder-intro">';
				$output .= '<div class="dtdr-dashbord-section-title">'.sprintf( esc_html__('Choose Categories, %2$s and %1$s.', 'dtdr'), $amenity_singular_label, $contracttype_plural_label).'</div>';
				$output .= '<div class="dtdr-dashbord-section-title-notes">'.sprintf( esc_html__('Choose categories, %3$s and %2$s for your %1$s.', 'dtdr'), strtolower($listing_singular_label), strtolower($amenity_singular_label), strtolower($contracttype_plural_label) ).'</div>';
			$output .= '</div>';

			$output .= '<div class="dtdr-dashbord-section-holder-content">';

				$output .= '<div class="dtdr-dashboard-option-item">
				               <label for="dtdr_description">'.esc_html__('Category', 'dtdr').'</label>
				               <div class="dtdr-dashboard-option-item-data">';

				               		$dtdr_listings_category_terms = array ();
				               		if(is_array($dtdr_listings_category_array) && !empty($dtdr_listings_category_array)) {
					               		foreach($dtdr_listings_category_array as $dtdr_listing_category_array) {
					               			array_push($dtdr_listings_category_terms, $dtdr_listing_category_array->name);
					               		}
				               		}

				               		$dtdr_listings_category = get_categories('taxonomy=dtdr_listings_category&hide_empty=0');

			                        $output .= '<select name="dtdr_category[]" class="dtdr-chosen-select" data-placeholder="'.esc_html__('None', 'dtdr').'" multiple="multiple">';
				                        if(count($dtdr_listings_category) > 0) {
				                            foreach($dtdr_listings_category as $dtdr_listing_category) {
				                            	$selected_attribute = '';
						                    	if(in_array($dtdr_listing_category->name, $dtdr_listings_category_terms)) {
				                            		$selected_attribute = 'selected="selected"';
				                            	}
				                                $output .= '<option value="'.esc_attr($dtdr_listing_category->name).'" '.$selected_attribute.'>'.esc_html( $dtdr_listing_category->name).'</option>';
				                            }
				                        }
			                        $output .= '</select>';

					$output .= '</div>';
				$output .= '</div>';

				$output .= '<div class="dtdr-dashboard-option-item">
				               <label for="dtdr_description">'.esc_html($contracttype_singular_label).'</label>
				               <div class="dtdr-dashboard-option-item-data">';

				               		$dtdr_listings_ctype_terms = array ();
				               		if(is_array($dtdr_listings_ctype_array) && !empty($dtdr_listings_ctype_array)) {
					               		foreach($dtdr_listings_ctype_array as $dtdr_listing_ctype_array) {
					               			array_push($dtdr_listings_ctype_terms, $dtdr_listing_ctype_array->name);
					               		}
				               		}

				               		$dtdr_listings_ctype = get_categories('taxonomy=dtdr_listings_ctype&hide_empty=0');

			                        $output .= '<select name="dtdr_ctype[]" class="dtdr-chosen-select" data-placeholder="'.esc_html__('None', 'dtdr').'" multiple="multiple">';
				                        if(count($dtdr_listings_ctype) > 0) {
				                            foreach($dtdr_listings_ctype as $dtdr_listing_ctype) {
				                            	$selected_attribute = '';
						                    	if(in_array($dtdr_listing_ctype->name, $dtdr_listings_ctype_terms)) {
				                            		$selected_attribute = 'selected="selected"';
				                            	}
				                                $output .= '<option value="'.esc_attr($dtdr_listing_ctype->name).'" '.$selected_attribute.'>'.esc_html( $dtdr_listing_ctype->name).'</option>';
				                            }
				                        }
			                        $output .= '</select>';

					$output .= '</div>';
				$output .= '</div>';

				$output .= '<div class="dtdr-dashboard-option-item">
				               <label for="dtdr_description">'.sprintf( esc_html__('%1$s', 'dtdr'), $amenity_singular_label).'</label>
				               <div class="dtdr-dashboard-option-item-data dtdr_amenities_list">';

				               		$dtdr_listings_category_amenity = array ();
				               		if(is_array($dtdr_listings_amenity_array) && !empty($dtdr_listings_amenity_array)) {
					               		foreach($dtdr_listings_amenity_array as $dtdr_listing_amenity_array) {
					               			array_push($dtdr_listings_category_amenity, $dtdr_listing_amenity_array->name);
					               		}
				               		}

				               		$dtdr_listings_amenity = get_categories('taxonomy=dtdr_listings_amenity&hide_empty=0');

			                        if(count($dtdr_listings_amenity) > 0) {
			                            foreach($dtdr_listings_amenity as $dtdr_listing_amenity) {

			                            	$checked_attribute = '';
					                    	if(in_array($dtdr_listing_amenity->name, $dtdr_listings_category_amenity)) {
			                            		$checked_attribute = 'checked="checked"';
			                            	}

											$output .= '<div class="dtdr-dashboard-option-item-list">';
												$output .= '<input type="checkbox" name="dtdr_amenity[]" id="dtdr_amenity_'.$dtdr_listing_amenity->slug.'" value="'.$dtdr_listing_amenity->name.'" '.$checked_attribute.' />';
												$output .= '<label for="dtdr_amenity_'.$dtdr_listing_amenity->slug.'">'.$dtdr_listing_amenity->name.'</label>';
											$output .= '</div>';

			                            }
			                        }

			        $output .= '</div>';

				$output .= '</div>';
			$output .= '</div>';

		$output .= '</div>';

		// Features
		$output .= '<div class="dtdr-dashbord-section-holder">';

			$output .= '<div class="dtdr-dashbord-section-holder-intro">';
				$output .= '<div class="dtdr-dashbord-section-title">'.esc_html__('Features', 'dtdr').'</div>';
				$output .= '<div class="dtdr-dashbord-section-title-notes">'.sprintf( esc_html__('You can add any number of features for your %1$s.', 'dtdr'), strtolower($listing_singular_label) ).'</div>';
			$output .= '</div>';

			$output .= '<div class="dtdr-dashbord-section-holder-content">';
				$output .= '<div class="dtdr-dashboard-option-item">
				               	<label for="dtdr_features">'.esc_html__('Add Features', 'dtdr').'</label>
				               	<div class="dtdr-dashboard-option-item-data">';
				                	$output .= dtdr_listing_features_field($edit_item_id);
				    $output .= '</div>';
				$output .= '</div>';
			$output .= '</div>';

		$output .= '</div>';

		// Incharge
		if(!in_array('incharge', (array) $current_user->roles)) {

			$incharge_singular_label = apply_filters( 'incharge_label', 'singular' );

			$output .= '<div class="dtdr-dashbord-section-holder">';

				$output .= '<div class="dtdr-dashbord-section-holder-intro">';
					$output .= '<div class="dtdr-dashbord-section-title">'.sprintf( esc_html__('%1$s', 'dtdr'), $incharge_singular_label ).'</div>';
					$output .= '<div class="dtdr-dashbord-section-title-notes">'.sprintf( esc_html__('If you want to add %2$s person for your %1$s than you can do that here.', 'dtdr'), strtolower($listing_singular_label), strtolower($incharge_singular_label) ).'</div>';
				$output .= '</div>';

				$output .= '<div class="dtdr-dashbord-section-holder-content">';
					$output .= '<div class="dtdr-dashboard-option-item">
					               	<label for="dtdr_incharge">'.sprintf( esc_html__('%1$s', 'dtdr'), $incharge_singular_label ).'</label>
					               	<div class="dtdr-dashboard-option-item-data">
					               		'.dtdr_listing_incharge_field($edit_item_id, 'seller').'
					               	</div>
					            </div>';
				$output .= '</div>';

			$output .= '</div>';

		}


		// Add Listing Fields From Modules

		$output .= apply_filters( 'dtdr_add_listing_fields_from_modules', '', $edit_item_id );


		// Notice And Submit form

		$output .= '<div class="dtdr-dashbord-section-holder">';

			$output .= '<div class="dtdr-dashboard-notices"></div>';

			$output .= '<input type="hidden" value="'.get_permalink($dashboard_page_id).'" name="dtdr_dashboard_page_url" class="dtdr_dashboard_page_url" />';

			if($edit_item_id > 0) {
				$output .= '<a class="custom-button-style dtdr-add-listing-button" onclick="return false;" data-listing-mode="'.$listing_mode.'" data-listing-edit-item-id="'.$edit_item_id.'" data-user-id="'.$user_id.'" data-seller-id="'.$seller_id.'">'.sprintf( esc_html__('Update %1$s', 'dtdr'), $listing_singular_label ).'</a>';
			} else {
				$output .= '<a class="custom-button-style dtdr-add-listing-button" onclick="return false;" data-listing-mode="'.$listing_mode.'" data-listing-edit-item-id="'.$edit_item_id.'" data-user-id="'.$user_id.'" data-seller-id="'.$seller_id.'">'.sprintf( esc_html__('Add %1$s', 'dtdr'), $listing_singular_label ).'</a>';
			}

		$output .= '</div>';

	$output .= '</form>';

	return $output;

}

function dtdr_dashboard_addlisting_consumed_notices($active_seller_package_id) {

	$output = '';

	$listing_plural_label = apply_filters( 'listing_label', 'plural' );

	$output .= '<div class="dtdr-dashbord-section-holder">';
		$output .= '<div class="dtdr-dashbord-section-holder-intro">';
			$output .= '<div class="dtdr-dashbord-section-title">'.esc_html__('Warning!', 'dtdr').'</div>';
		$output .= '</div>';
		$output .= '<div class="dtdr-dashbord-section-holder-content">';
			$output .= '<div class="dtdr-warning-notice">';
				$output .= '<p>'.sprintf(esc_html__('You have consumed all your allowed %1$s from %2$s package', 'dtdr'), strtolower($listing_plural_label), '<strong>'.get_the_title($active_seller_package_id).'</strong>').'</p>';
			$output .= '</div>';
		$output .= '</div>';
	$output .= '</div>';

	return $output;

}

function dtdr_dashboard_addlisting_expired_notices($active_seller_package_id) {

	$output = '';

	$output .= '<div class="dtdr-dashbord-section-holder">';
		$output .= '<div class="dtdr-dashbord-section-holder-intro">';
			$output .= '<div class="dtdr-dashbord-section-title">'.esc_html__('Warning!', 'dtdr').'</div>';
		$output .= '</div>';
		$output .= '<div class="dtdr-dashbord-section-holder-content">';
			$output .= '<div class="dtdr-warning-notice">';
				if($active_seller_package_id == -1) {
					$output .= '<p>'.esc_html__('No package active, please contact your seller for further details', 'dtdr').'</p>';
				} else if($active_seller_package_id > 0) {
					$output .= '<p>'.sprintf(esc_html__('Your package %1$s have been expired', 'dtdr'), '<strong>'.get_the_title($active_seller_package_id).'</strong>').'</p>';
				}
			$output .= '</div>';
		$output .= '</div>';
	$output .= '</div>';

	return $output;

}

function dtdr_dashboard_addlisting_purchasepackage_notices() {

	$output = '';

	$listing_plural_label = apply_filters( 'listing_label', 'plural' );

	$seller_purchase_package_shortcode = dtdr_option('general','seller-purchase-package-shortcode');

	$output .= '<div class="dtdr-dashbord-section-holder">';
		$output .= '<div class="dtdr-dashbord-section-holder-intro">';
			$output .= '<div class="dtdr-dashbord-section-title">'.esc_html__('Available Packages', 'dtdr').'</div>';
			$output .= '<div class="dtdr-dashbord-section-title-notes">'.sprintf( esc_html__('Please purchase any of the available packages to add your %1$s.', 'dtdr'), strtolower($listing_plural_label) ).'</div>';
		$output .= '</div>';
		$output .= '<div class="dtdr-dashbord-section-holder-content">';
			$output .= do_shortcode(stripslashes($seller_purchase_package_shortcode));
		$output .= '</div>';
	$output .= '</div>';

	return $output;

}

// Add listing from frontend
add_action( 'wp_ajax_dtdr_add_frontend_listing', 'dtdr_add_frontend_listing' );
add_action( 'wp_ajax_nopriv_dtdr_add_frontend_listing', 'dtdr_add_frontend_listing' );
function dtdr_add_frontend_listing() {

	extract(dtdr_recursive_sanitize_text_field($_REQUEST));

	$current_user = get_userdata($user_id);

	$user_roles = ( array ) $current_user->roles;

	$listing_singular_label = apply_filters( 'listing_label', 'singular' );
	$listing_plural_label = apply_filters( 'listing_label', 'plural' );

	$dtdr_listing_mode         = isset($_REQUEST['dtdr_listing_mode']) ? dtdr_recursive_sanitize_text_field($_REQUEST['dtdr_listing_mode']) : 'add';
	$dtdr_listing_edit_item_id = isset($_REQUEST['dtdr_listing_edit_item_id']) ? dtdr_recursive_sanitize_text_field($_REQUEST['dtdr_listing_edit_item_id']) : -1;


	$has_error = false;
	$errors = array ();
	if($dtdr_title == '') {
		$has_error = true;
		$errors[] = '<p>'.sprintf( esc_html__('Please give title for your %1$s', 'dtdr'), strtolower($listing_singular_label) ).'</p>';
	}

	if( isset( $dtdr_mls_number ) && $dtdr_mls_number != '') {

		$args = array (
					'posts_per_page' => -1,
					'post_type'      => 'dtdr_listings',
					'meta_query'     => array (),
					'post_status'    => array ( 'any' ),
				);

    	if($dtdr_listing_mode == 'edit' && $dtdr_listing_edit_item_id > 0) {
		    $args['post__not_in'] = array ($dtdr_listing_edit_item_id);
    	}

		$args['meta_query'][] = array (
									'key'     => 'dtdr_mls_number',
									'value'   => $dtdr_mls_number,
									'compare' => 'LIKE',
								);

		$listings_query = new WP_Query( $args );
		$post_count = $listings_query->found_posts;
		wp_reset_postdata();

		if($post_count > 0) {
			$has_error = true;
			$errors[] = '<p>'.esc_html__('MLS Number you have provided is not unique, please try with unique number.', 'dtdr').'</p>';
		}

	}


    // Update seller listing count

    if($has_error) {
    	echo json_encode($errors);
    } else {

    	if($dtdr_listing_mode == 'edit' && $dtdr_listing_edit_item_id > 0) {

		    $listing_post = array (
		    	'ID'            => $dtdr_listing_edit_item_id,
		        'post_title'	=> $dtdr_title,
		        'post_excerpt'	=> $dtdr_description,
		        'post_type'     => 'dtdr_listings',
		    );

		    if(in_array('administrator', $user_roles)) {
		    	$listing_post['post_status'] = 'publish';
		    } else {
		    	if('true' ==  dtdr_option('general', 'should-admin-approve-listings')) {
		    		$listing_post['post_status'] = 'waitingforapproval';
		    	} else {
		    		$listing_post['post_status'] = 'publish';
		    	}
		    }

		    $listing_id =  wp_update_post($listing_post);

    	} else {

		    $listing_post = array (
		        'post_title'	=> $dtdr_title,
		        'post_excerpt'	=> $dtdr_description,
		        'post_type'     => 'dtdr_listings',
		        'post_author'   => $user_id
		    );

		    if(in_array('administrator', $user_roles)) {
		    	$listing_post['post_status'] = 'publish';
		    } else {
		    	if('true' ==  dtdr_option('general', 'should-admin-approve-listings')) {
		    		$listing_post['post_status'] = 'waitingforapproval';
		    	} else {
		    		$listing_post['post_status'] = 'publish';
		    	}
		    }

		    $listing_id =  wp_insert_post($listing_post);


	        // Package details
		    if($seller_id > 0) {

			    $dtdr_seller_package_used_listings_count = get_user_meta($seller_id, 'dtdr_seller_package_used_listings_count', true);
			    $dtdr_seller_package_used_listings_count++;
			    update_user_meta($seller_id, 'dtdr_seller_package_used_listings_count', $dtdr_seller_package_used_listings_count);

			}

    	}

    	update_post_meta($listing_id, 'dtdr_mls_number', $dtdr_mls_number);
    	update_post_meta($listing_id, 'dtdr_page_template', $dtdr_page_template);


    	// Category, Contract Types & Tags

    	wp_set_object_terms($listing_id, $dtdr_category, 'dtdr_listings_category');
    	wp_set_object_terms($listing_id, $dtdr_ctype, 'dtdr_listings_ctype');
    	wp_set_object_terms($listing_id, $dtdr_amenity, 'dtdr_listings_amenity');


        // Features

        update_post_meta($listing_id, 'dtdr_features_title', $dtdr_features_title);
        update_post_meta($listing_id, 'dtdr_features_subtitle', $dtdr_features_subtitle);
        update_post_meta($listing_id, 'dtdr_features_value', $dtdr_features_value);
        update_post_meta($listing_id, 'dtdr_features_valueunit', $dtdr_features_valueunit);
        update_post_meta($listing_id, 'dtdr_features_icon', $dtdr_features_icon);
        update_post_meta($listing_id, 'dtdr_features_image', $dtdr_features_image);


        // Incharges

        update_post_meta($listing_id, 'dtdr_incharges', $dtdr_incharges);


		// Add or Update listing from modules
		do_action('dtdr_addorupdate_listing_module', dtdr_recursive_sanitize_text_field($_REQUEST), $listing_id);


        // Email Notification

        if(dtdr_option('general', 'enable-email-seller') == 'true') {

	        if($dtdr_listing_mode == 'add') {

		        if($seller_id > 0 && $user_id > 0) {

			        if($seller_id != $user_id) {

			        	$listing_singular_label = apply_filters( 'listing_label', 'singular' );
			        	$incharge_singular_label = apply_filters( 'incharge_label', 'singular' );

						$seller_email = get_the_author_meta('email', $seller_id);
						$to = array ($seller_email);

						if(dtdr_option('general', 'enable-email-admin') == 'true') {
							$admin_email = get_option('admin_email');
							array_push($to, $admin_email);
						}

						$subject = sprintf(esc_html__('New %1$s Added', 'dtdr'), $listing_singular_label);

			        	$message = sprintf(esc_html__('New %1$s %2$s have been added by %3$s - %4$s.', 'dtdr'), $listing_singular_label, '<strong>'.get_the_title($listing_id).'</strong>', $incharge_singular_label, '<strong>'.get_the_author_meta( 'display_name' , $user_id ).'</strong>');

			        	dtdr_email_configuration($to, $subject, $message);

			        }


			        if($seller_id == $user_id) {

			        	if(dtdr_option('general', 'enable-email-admin') == 'true') {

				        	$listing_singular_label = apply_filters( 'listing_label', 'singular' );
				        	$seller_singular_label = apply_filters( 'seller_label', 'singular' );

							$to = get_option('admin_email');

							$subject = sprintf(esc_html__('New %1$s Added', 'dtdr'), $listing_singular_label);

				        	$message = sprintf(esc_html__('New %1$s %2$s have been added by %3$s - %4$s.', 'dtdr'), $listing_singular_label, '<strong>'.get_the_title($listing_id).'</strong>', $seller_singular_label, '<strong>'.get_the_author_meta( 'display_name' , $user_id ).'</strong>');

				        	dtdr_email_configuration($to, $subject, $message);

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