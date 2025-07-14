<?php

// Get package payment details
if(!function_exists('dtdr_get_package_pricing_details')) {
	function dtdr_get_package_pricing_details($package_id, $package_type) {

		$output = '';

		$current_user = wp_get_current_user();
		$user_id = $current_user->ID;

		$purchased_packages = get_user_meta($user_id, 'purchased_packages', true);
		$purchased_packages = (is_array($purchased_packages) && !empty($purchased_packages)) ? $purchased_packages : array ();
		$purchased_packages_keys = array_keys($purchased_packages);

		$output .= '<div class="dtdr-item-status-details">';

			$product = dtdr_get_product_object($package_id);
			$woo_price = dtdr_get_item_price_html($product);

			if($woo_price != '') {

				if(($package_type == 'seller' && function_exists('dtdr_check_user_seller_package_is_active') && dtdr_check_user_seller_package_is_active($user_id, $package_id)) || ($package_type == 'buyer' && function_exists('dtdr_check_user_buyer_package_is_active') && dtdr_check_user_buyer_package_is_active($user_id, $package_id))) {

					$output .= '<span class="dtdr-purchased">
									'.esc_html__('Purchased','dtdr').
								'</span>';

					$output .= '<span class="dtdr-active">
									'.esc_html__('Active','dtdr').
								'</span>';

				} else if(dtdr_check_item_is_in_cart($package_id)) {

					$output .= '<div class="dtdr-proceed-button">';
						$output .= '<a href="'.wc_get_cart_url().'" target="_self" class="custom-button-style dtdr-cart-link"><span class="fa fa-cart-plus"></span>'.esc_html__('View Cart','dtdr').'</a>';
					$output .= '</div>';

				} else {

					if(in_array($package_id, $purchased_packages_keys)) {
						$output .= '<span class="dtdr-expired">
										<span class="fa fa-cart-arrow-down"></span> '.esc_html__('Expired','dtdr').
									'</span>';
					}

					$period = get_post_meta($package_id, 'dtdr_period', true);
					$term = get_post_meta($package_id, 'dtdr_term', true);
					$terms_list = array('D' => 'Day(s)', 'W' => 'Week(s)', 'M' => 'Month(s)', 'Y' => 'Year(s)', 'L' => 'Lifetime');

					$output .= '<div class="dtdr-item-pricing-details">';
						$output .= $woo_price.' / '.$period.' '.$terms_list[$term];
					$output .= '</div>';
					$output .= '<div class="dtdr-proceed-button">';
						$output .= '<a href="'. apply_filters( 'add_to_cart_url', esc_url( $product->add_to_cart_url() ) ) .'" rel="nofollow" data-product_id="'.esc_attr($product->get_id()).'" class="custom-button-style add_to_cart_button ajax_add_to_cart product_type_'.esc_attr($product->get_type()).'"><span class="fa fa-shopping-cart"></span>'.esc_html__('Add to Cart', 'dtdr').'</a>';
					$output .= '</div>';

				}

			}

		$output .= '</div>';

		return $output;

	}
}


/*
* Packages Listing
*/

add_action( 'wp_ajax_dtdr_generate_packages_listing_data', 'dtdr_generate_packages_listing_data' );
add_action( 'wp_ajax_nopriv_dtdr_generate_packages_listing_data', 'dtdr_generate_packages_listing_data' );
function dtdr_generate_packages_listing_data() {

	// Pagination script Start
	$current_page = isset($_REQUEST['current_page']) ? dtdr_recursive_sanitize_text_field($_REQUEST['current_page']) : 1;
	$offset = isset($_REQUEST['offset']) ? dtdr_recursive_sanitize_text_field($_REQUEST['offset']) : 0;
	$post_per_page =  isset($_REQUEST['post_per_page']) ? dtdr_recursive_sanitize_text_field($_REQUEST['post_per_page']) : -1;
	// Pagination script End

	// Type
	$type = (isset($_REQUEST['type']) && $_REQUEST['type'] != '') ? dtdr_recursive_sanitize_text_field($_REQUEST['type']) : 'type1';

	// Default options
	$columns =  isset($_REQUEST['columns']) ? dtdr_recursive_sanitize_text_field($_REQUEST['columns']) : 1;

	// Carousel
	$enable_carousel = (isset($_REQUEST['enable_carousel']) && $_REQUEST['enable_carousel'] == 'true') ? true: false;

	// Isotope
	$apply_isotope = (isset($_REQUEST['apply_isotope']) && $_REQUEST['apply_isotope'] == 'true') ? 'true' : '';

	// Package Type
	$package_type = (isset($_REQUEST['package_type']) && $_REQUEST['package_type'] != '') ? dtdr_recursive_sanitize_text_field($_REQUEST['package_type']) : '';

	// Excerpt Length
	$excerpt_length = (isset($_REQUEST['excerpt_length']) && $_REQUEST['excerpt_length'] != '') ? dtdr_recursive_sanitize_text_field($_REQUEST['excerpt_length']) : 20;

	// Show Featured Image
	$show_featured_image = (isset($_REQUEST['show_featured_image']) && $_REQUEST['show_featured_image'] != '') ? dtdr_recursive_sanitize_text_field($_REQUEST['show_featured_image']) : 'true';

	// Apply Equal Height
	$apply_equal_height = (isset($_REQUEST['apply_equal_height']) && $_REQUEST['apply_equal_height'] != '') ? dtdr_recursive_sanitize_text_field($_REQUEST['apply_equal_height']) : 'false';


	// Query to retrieve data based on filter options

	$args = array (
				'posts_per_page' => -1,
				'post_type' => 'dtdr_packages',
				'meta_query' => array (),
				'tax_query' => array (),
			);

	if($package_type != '') {
		$args['meta_query'][] = array (
									'key'     => 'dtdr_package_type',
									'value'   => $package_type,
									'compare' => '=',
								);
	}

	// List Item Ids
	$package_items = isset($_REQUEST['package_items']) ? dtdr_recursive_sanitize_text_field($_REQUEST['package_items']) : '';
	if(!empty($package_items)) {
		$args['post__in'] = $package_items;
	}

	// Configure settings

	$filtered_item_ids = array ();

	$packages_filtered_query = new WP_Query( $args );

	if ( $packages_filtered_query->have_posts() ) :

		$i = 1;
		while ( $packages_filtered_query->have_posts() ) :
			$packages_filtered_query->the_post();

			$package_id = get_the_ID();

			array_push($filtered_item_ids, $package_id);

		endwhile;
		wp_reset_postdata();

	endif;


	// Data Output

	$output_options                        = array ();
	$output_options['current_page']        = $current_page;
	$output_options['offset']              = $offset;
	$output_options['post_per_page']       = $post_per_page;
	$output_options['columns']             = $columns;
	$output_options['enable_carousel']     = $enable_carousel;
	$output_options['apply_isotope']       = $apply_isotope;
	$output_options['type']                = $type;
	$output_options['excerpt_length']      = $excerpt_length;
	$output_options['show_featured_image'] = $show_featured_image;
	$output_options['apply_equal_height']  = $apply_equal_height;

	$data_result = dtdr_generate_package_output_loop($filtered_item_ids, $output_options);


    // Print Output

    echo json_encode(array(
		        'data' => $data_result['data'],
		        'dataids' => $data_result['dataids']
		    ));

	die();

}

function dtdr_generate_package_output_loop($filtered_item_ids, $output_options) {

	// Options

	$current_page        = $output_options['current_page'];
	$offset              = $output_options['offset'];
	$post_per_page       = $output_options['post_per_page'];
	$columns             = $output_options['columns'];
	$enable_carousel     = $output_options['enable_carousel'];
	$apply_isotope       = $output_options['apply_isotope'];
	$type                = $output_options['type'];
	$excerpt_length      = $output_options['excerpt_length'];
	$show_featured_image = $output_options['show_featured_image'];
	$apply_equal_height  = $output_options['apply_equal_height'];


	// Query to retrieve data based on pagination
	$paginated_item_ids = array ();
	$content = '';

	if(!empty($filtered_item_ids)) {

		if($columns == 3) {
			$column_class = array ( 'dtdr-column', 'dtdr-one-third' );
		} else if($columns == 2) {
			$column_class = array ( 'dtdr-column', 'dtdr-one-half' );
		} else {
			$column_class = array ( 'dtdr-column', 'dtdr-one-column' );
		}

		$args = array (
					'offset' => $offset,
					'paged' => $current_page ,
					'posts_per_page' => $post_per_page,
					'post__in' => $filtered_item_ids,
					'post_type' => 'dtdr_packages',
					'orderby' => 'post__in',
				);


		// Configure settings
		$data_package_attributes                        = array ();
		$data_package_attributes['type']                = $type;
		$data_package_attributes['excerpt_length']      = $excerpt_length;
		$data_package_attributes['show_featured_image'] = $show_featured_image;
		$data_package_attributes['apply_equal_height']  = $apply_equal_height;
		$data_package_attributes['column_class']        = $column_class;
		$data_listing_attributes['apply_isotope']       = $apply_isotope;
		if($enable_carousel) {
			$data_package_attributes['carousel_class'] = 'swiper-slide';
		} else {
			$data_package_attributes['carousel_class'] = '';
		}

		$packages_paginated_query = new WP_Query( $args );

		if ( $packages_paginated_query->have_posts() ) :

			if($apply_isotope == 'true') {
				$content .= '<div class="grid-sizer '.implode(' ', $column_class).'"></div>';
			}

			$i = 1;
			while ( $packages_paginated_query->have_posts() ) :
				$packages_paginated_query->the_post();

				$listing_id = get_the_ID();

				if($i == 1) { $first_class = 'first';  } else { $first_class = ''; }
				if($i == $columns) { $i = 1; } else { $i = $i + 1; }

				$data_package_attributes['first_class'] = $first_class;

				$content .= dtdr_generate_package_item_html($data_package_attributes);

				array_push($paginated_item_ids, $listing_id);

			endwhile;
			wp_reset_postdata();

		else :

			$content .= esc_html__('No records found!', 'dtdr');

		endif;

		$total_count = $packages_paginated_query->found_posts;

	} else {
		$total_count = 0;
	}


	// Building output html

	$output = '';

	$swiper_wrapper_class = $swiper_container_class = '';
	if($enable_carousel) {
		$swiper_wrapper_class = 'swiper-wrapper';
		$swiper_container_class = 'swiper-container';
	}

	$isotope_class = '';
	if($apply_isotope == 'true') {
		$isotope_class = 'dtdr-packages-item-apply-isotope';
	}

	$output .= '<div class="dtdr-packages-container '.esc_attr($swiper_container_class).'">';

		$output .= '<div class="dtdr-packages-item-container '.esc_attr($swiper_wrapper_class).' '.esc_attr($isotope_class).'">';

			if($content != '') {
				$output .= $content;
			} else {
				$output .= esc_html__('No records found!', 'dtdr');
			}

		$output .= '</div>';

		if(!$enable_carousel) {

			// Pagination script Start
			$max_num_pages = $packages_paginated_query->max_num_pages;

			$item_ids['type']                = $type;
			$item_ids['post_per_page']       = $post_per_page;
			$item_ids['loader']              = 'true';
			$item_ids['loader_parent']       = '.dtdr-package-output-data-container';
			$item_ids['columns']             = $columns;
			$item_ids['load_data']           = $load_data;
			$item_ids['apply_isotope']       = $apply_isotope;
			$item_ids['show_featured_image'] = $show_featured_image;
			$item_ids['apply_equal_height']  = $apply_equal_height;

			$output .= dtdr_package_ajax_pagination($max_num_pages, $current_page, 'dtdr_generate_packages_listing_data', 'dtdr-package-output-data-holder', $item_ids);
			// Pagination script End

		}

	$output .= '</div>';


    $output = array (
			        'data' => $output,
			        'dataids' => $paginated_item_ids
			    );

	return $output;

}

function dtdr_generate_package_item_html($data_package_attributes) {

	$output = '';

	$package_id = get_the_ID();
	$package_title = get_the_title();
	$package_permalink = get_permalink();

    $package_type = get_post_meta($package_id, 'dtdr_package_type', true);
    $package_type = ($package_type != '') ? $package_type : 'buyer';

	extract($data_package_attributes);

	$item_classes = array ('dtdr-packages-item-wrapper');
	array_push($item_classes, $carousel_class, $type);
	if($first_class != '') {
		array_push($column_class, $first_class);
	}

	$listing_plural_label = apply_filters( 'listing_label', 'plural' );
	$incharge_plural_label = apply_filters( 'incharge_label', 'plural' );

	$dtdr_numberof_listings = get_post_meta($package_id, 'dtdr_numberof_listings', true);
	$dtdr_numberof_featured_listings = get_post_meta($package_id, 'dtdr_numberof_featured_listings', true);
	$dtdr_numberof_incharges = get_post_meta($package_id, 'dtdr_numberof_incharges', true);
	$dtdr_numberof_images = get_post_meta($package_id, 'dtdr_numberof_images', true);

	$dtdr_additional_features = get_post_meta($package_id, 'dtdr_additional_features', true);
	$dtdr_additional_features = explode("\n", $dtdr_additional_features);
	$dtdr_additional_features = implode("</li><li>", $dtdr_additional_features);

	// Excerpt
	$custom_excerpt = dtdr_custom_excerpt($excerpt_length, $package_id);


	if($apply_isotope == 'true') {
		$output .= '<div class="'.implode(' ', $column_class).'">';
			$output .= '<div class="'.implode(' ', get_post_class($item_classes, $package_id)).'">';
	} else {
		$item_classes = array_merge($item_classes, $column_class);
		$output .= '<div class="'.implode(' ', get_post_class($item_classes, $package_id)).'">';
	}

		if($type == 'type1') {

			if(has_post_thumbnail($package_id) && $show_featured_image == 'true') {
				$output .= '<div class="dtdr-packagelist-thumb">';
					$output .= '<a href="'.$package_permalink.'" title="'.$package_title.'">'.get_the_post_thumbnail($package_id, 'full').'</a>';
				$output .= '</div>';
			}

			$output .= '<div class="dtdr-packagelist-details">';

				$output .= '<h5><a href="'.$package_permalink.'" title="'.$package_title.'">'.$package_title.'</a></h5>';

				if($custom_excerpt != '') {
					$output .= '<div class="dtdr-packagelist-description">'.$custom_excerpt.'</div>';
				}

			$output .= '</div>';

			if(class_exists('WooCommerce')) {
				$output .= dtdr_get_package_pricing_details($package_id, $package_type);
			}

			$output .= '<ul class="dtdr-packagelist-features">';

				if($dtdr_numberof_listings == '-1') {
					$output .= '<li>'.sprintf( esc_html__('Unlimited %1$s', 'dtdr'), $listing_plural_label ).'</li>';
				} else if($dtdr_numberof_listings != '') {
					$output .= '<li>'.$dtdr_numberof_listings.' '.$listing_plural_label.'</li>';
				}

				if($package_type == 'seller') {

					if($dtdr_numberof_featured_listings == '-1') {
						$output .= '<li>'.sprintf( esc_html__('Unlimited Featured %1$s', 'dtdr'), $listing_plural_label ).'</li>';
					} else if($dtdr_numberof_featured_listings != '') {
						$output .= '<li>'.sprintf( esc_html__('%1$s Featured %2$s', 'dtdr'), $dtdr_numberof_featured_listings, $listing_plural_label ).'</li>';
					}

					if($dtdr_numberof_incharges == '-1') {
						$output .= '<li>'.sprintf( esc_html__('Unlimited %1$s', 'dtdr'), $incharge_plural_label ).'</li>';
					} else if($dtdr_numberof_incharges != '') {
						$output .= '<li>'.sprintf( esc_html__('%1$s %2$s', 'dtdr'), $dtdr_numberof_incharges, $incharge_plural_label ).'</li>';
					}

					if($dtdr_numberof_images == '-1') {
						$output .= '<li>'.esc_html__('Unlimited Images', 'dtdr').'</li>';
					} else if($dtdr_numberof_images != '') {
						$output .= '<li>'.sprintf( esc_html__('%1$s Images', 'dtdr'), $dtdr_numberof_images ).'</li>';
					}

				}

				if($dtdr_additional_features != '') {
					$output .= '<li>'.$dtdr_additional_features.'</li>';
				}

			$output .= '</ul>';

			$output .= '<div class="dtdr-packagelist-view-details">';
				$output .= '<a href="'.$package_permalink.'" class="dtdr-packagelist-view-details-button custom-button-style"><span class="fas fa-arrow-right"></span>'.esc_html__('View Details', 'dtdr').'</a>';
			$output .= '</div>';

		} else if($type == 'type2') {

			$output .= '<div class="dtdr-packagelist-details">';

				$output .= '<h5><a href="'.$package_permalink.'" title="'.$package_title.'">'.$package_title.'</a></h5>';

				if($custom_excerpt != '') {
					$output .= '<div class="dtdr-packagelist-description">'.$custom_excerpt.'</div>';
				}

			$output .= '</div>';

			$output .= '<ul class="dtdr-packagelist-features">';

				if($dtdr_numberof_listings == '-1') {
					$output .= '<li>'.sprintf( esc_html__('Unlimited %1$s', 'dtdr'), $listing_plural_label ).'</li>';
				} else if($dtdr_numberof_listings != '') {
					$output .= '<li>'.$dtdr_numberof_listings.' '.$listing_plural_label.'</li>';
				}

				if($package_type == 'seller') {

					if($dtdr_numberof_featured_listings == '-1') {
						$output .= '<li>'.sprintf( esc_html__('Unlimited Featured %1$s', 'dtdr'), $listing_plural_label ).'</li>';
					} else if($dtdr_numberof_featured_listings != '') {
						$output .= '<li>'.sprintf( esc_html__('%1$s Featured %2$s', 'dtdr'), $dtdr_numberof_featured_listings, $listing_plural_label ).'</li>';
					}

					if($dtdr_numberof_incharges == '-1') {
						$output .= '<li>'.sprintf( esc_html__('Unlimited %1$s', 'dtdr'), $incharge_plural_label ).'</li>';
					} else if($dtdr_numberof_incharges != '') {
						$output .= '<li>'.sprintf( esc_html__('%1$s %2$s', 'dtdr'), $dtdr_numberof_incharges, $incharge_plural_label ).'</li>';
					}

					if($dtdr_numberof_images == '-1') {
						$output .= '<li>'.esc_html__('Unlimited Images', 'dtdr').'</li>';
					} else if($dtdr_numberof_images != '') {
						$output .= '<li>'.sprintf( esc_html__('%1$s Images', 'dtdr'), $dtdr_numberof_images ).'</li>';
					}

				}

				if($dtdr_additional_features != '') {
					$output .= '<li>'.$dtdr_additional_features.'</li>';
				}

			$output .= '</ul>';

			$output .= '<div class="dtdr-packagelist-button-details">';

				if(class_exists('WooCommerce')) {
					$output .= dtdr_get_package_pricing_details($package_id, $package_type);
				}

				$output .= '<div class="dtdr-packagelist-view-details">';
					$output .= '<a href="'.$package_permalink.'" class="dtdr-packagelist-view-details-button custom-button-style"><span class="fas fa-arrow-right"></span>'.esc_html__('View Details', 'dtdr').'</a>';
				$output .= '</div>';

			$output .= '</div>';

		} else if($type == 'type3') {

			$output .= '<div class="dtdr-packagelist-details">';

				$output .= '<h5><a href="'.$package_permalink.'" title="'.$package_title.'">'.$package_title.'</a></h5>';

				if($custom_excerpt != '') {
					$output .= '<div class="dtdr-packagelist-description">'.$custom_excerpt.'</div>';
				}

				$output .= '<div class="dtdr-packagelist-items">';

					$output .= '<ul class="dtdr-packagelist-features">';

						if($dtdr_numberof_listings == '-1') {
							$output .= '<li>'.sprintf( esc_html__('Unlimited %1$s', 'dtdr'), $listing_plural_label ).'</li>';
						} else if($dtdr_numberof_listings != '') {
							$output .= '<li>'.$dtdr_numberof_listings.' '.$listing_plural_label.'</li>';
						}

						if($package_type == 'seller') {

							if($dtdr_numberof_featured_listings == '-1') {
								$output .= '<li>'.sprintf( esc_html__('Unlimited Featured %1$s', 'dtdr'), $listing_plural_label ).'</li>';
							} else if($dtdr_numberof_featured_listings != '') {
								$output .= '<li>'.sprintf( esc_html__('%1$s Featured %2$s', 'dtdr'), $dtdr_numberof_featured_listings, $listing_plural_label ).'</li>';
							}

							if($dtdr_numberof_incharges == '-1') {
								$output .= '<li>'.sprintf( esc_html__('Unlimited %1$s', 'dtdr'), $incharge_plural_label ).'</li>';
							} else if($dtdr_numberof_incharges != '') {
								$output .= '<li>'.sprintf( esc_html__('%1$s %2$s', 'dtdr'), $dtdr_numberof_incharges, $incharge_plural_label ).'</li>';
							}

							if($dtdr_numberof_images == '-1') {
								$output .= '<li>'.esc_html__('Unlimited Images', 'dtdr').'</li>';
							} else if($dtdr_numberof_images != '') {
								$output .= '<li>'.sprintf( esc_html__('%1$s Images', 'dtdr'), $dtdr_numberof_images ).'</li>';
							}

						}

						if($dtdr_additional_features != '') {
							$output .= '<li>'.$dtdr_additional_features.'</li>';
						}

					$output .= '</ul>';

				$output .= '</div>';

			$output .= '</div>';

			$output .= '<div class="dtdr-packagelist-payment-details">';

				if(class_exists('WooCommerce')) {
					$output .= dtdr_get_package_pricing_details($package_id, $package_type);
				}

				$output .= '<div class="dtdr-packagelist-view-details">';
					$output .= '<a href="'.$package_permalink.'" class="dtdr-packagelist-view-details-button custom-button-style"><span class="fas fa-arrow-right"></span>'.esc_html__('View Details', 'dtdr').'</a>';
				$output .= '</div>';

			$output .= '</div>';

		}

	if($apply_isotope == 'true') {
			$output .= '</div>';
		$output .= '</div>';
	} else {
		$output .= '</div>';
	}

	return $output;

}

function dtdr_package_ajax_pagination($max_num_pages, $current_page, $function_call, $output_div, $item_ids) {

	$output = '';

	if($max_num_pages > 1) {

		$loader = $loader_parent = $type = '';
		$postperpage = -1;
		$columns = 1;
		$categories = $tags = $cities = $countries = $sellers = '';

		if(isset($item_ids['type']) && $item_ids['type'] != '') {
			$type = $item_ids['type'];
		}

		if(isset($item_ids['loader']) && $item_ids['loader'] != '') {
			$loader = $item_ids['loader'];
		}

		if(isset($item_ids['loader_parent']) && $item_ids['loader_parent'] != '') {
			$loader_parent = $item_ids['loader_parent'];
		}

		if(isset($item_ids['post_per_page']) && $item_ids['post_per_page'] != '') {
			$postperpage = $item_ids['post_per_page'];
		}

		if(isset($item_ids['columns']) && $item_ids['columns'] != '') {
			$columns = $item_ids['columns'];
		}

		if(isset($item_ids['load_data']) && $item_ids['load_data'] != '') {
			$load_data = $item_ids['load_data'];
		}

		if(isset($item_ids['apply_isotope']) && $item_ids['apply_isotope'] != '') {
			$apply_isotope = $item_ids['apply_isotope'];
		}

		$output .= '<div class="dtdr-pagination dtdr-package-pagination dtdr-ajax-pagination" data-postperpage="'.$postperpage.'" data-functioncall="'.$function_call.'" data-outputdiv="'.$output_div.'" data-type="'.$type.'" data-loader="'.$loader.'" data-loaderparent="'.$loader_parent.'" data-columns="'.$columns.'" data-loaddata="'.$load_data.'" data-applyisotope="'.$apply_isotope.'" data-showfeaturedimage="'.$item_ids['show_featured_image'].'" data-applyequalheight="'.$item_ids['apply_equal_height'].'">';

			if($current_page > 1) {
				$output .= '<div class="prev-post"><a href="#" data-currentpage="'.$current_page.'"><span class="fa fa-caret-left"></span>&nbsp;'.esc_html__('Prev', 'dtdr').'</a></div>';
			}

			$output .= paginate_links ( array (
						  'base' 		 => '#',
						  'format' 		 => '',
						  'current' 	 => $current_page,
						  'type'     	 => 'list',
						  'end_size'     => 2,
						  'mid_size'     => 3,
						  'prev_next'    => false,
						  'total' 		 => $max_num_pages
					  ) );

			if ($current_page < $max_num_pages) {
				$output .= '<div class="next-post"><a href="#" data-currentpage="'.$current_page.'">'.esc_html__('Next', 'dtdr').'&nbsp;<span class="fa fa-caret-right"></span></a></div>';
			}

		$output .= '</div>';

    }

    return $output;

}

// Seller Package Status
function dtdr_check_user_seller_package_is_active($user_id, $package_id) {

	$dtdr_seller_active_package_id = get_user_meta($user_id, 'dtdr_seller_active_package_id', true);
	$dtdr_seller_active_package_id = (isset($dtdr_seller_active_package_id) && !empty($dtdr_seller_active_package_id)) ? $dtdr_seller_active_package_id : -1;

	if($package_id > 0 && $package_id != $dtdr_seller_active_package_id) {
		return false;
	}

	$dtdr_seller_active_package_status = get_user_meta($user_id, 'dtdr_seller_active_package_status', true);

	if($dtdr_seller_active_package_id > 0 && $dtdr_seller_active_package_status == 'active') {

		$dtdr_seller_active_package_expiry_date = get_user_meta($user_id, 'dtdr_seller_active_package_expiry_date', true);

		if($dtdr_seller_active_package_expiry_date == 'LT') {

			return true;

		} else if($dtdr_seller_active_package_expiry_date != 'NA') {

			$current_timestamp = strtotime(current_time(get_option('date_format')));
			if($current_timestamp <= $dtdr_seller_active_package_expiry_date) {
				return true;
			}

		}

	}

    return false;

}

// Buyer Package Status
function dtdr_check_user_buyer_package_is_active($user_id, $package_id) {

	$dtdr_buyer_active_package_id = get_user_meta($user_id, 'dtdr_buyer_active_package_id', true);
	$dtdr_buyer_active_package_id = (isset($dtdr_buyer_active_package_id) && !empty($dtdr_buyer_active_package_id)) ? $dtdr_buyer_active_package_id : -1;

	if($package_id > 0 && $package_id != $dtdr_buyer_active_package_id) {
		return false;
	}

	$dtdr_buyer_active_package_status = get_user_meta($user_id, 'dtdr_buyer_active_package_status', true);

	if($dtdr_buyer_active_package_id > 0 && $dtdr_buyer_active_package_status == 'active') {

		$dtdr_buyer_active_package_expiry_date = get_user_meta($user_id, 'dtdr_buyer_active_package_expiry_date', true);

		if($dtdr_buyer_active_package_expiry_date == 'LT') {

			return true;

		} else if($dtdr_buyer_active_package_expiry_date != 'NA') {

			$current_timestamp = strtotime(current_time(get_option('date_format')));
			if($current_timestamp <= $dtdr_buyer_active_package_expiry_date) {
				return true;
			}

		}

	}

    return false;

}
?>