<?php

// Default - Sellers
if(!function_exists('dtdr_sellers')) {
	function dtdr_sellers($attrs, $content = null) {

		$attrs = shortcode_atts ( array (

						'type' => 'type1',
						'columns' => '',
						'include' => '',
						'class' => '',

				), $attrs, 'dtdr_sellers' );


		$output = '';

		$listing_singular_label = apply_filters( 'listing_label', 'singular' );
		$listing_plural_label = apply_filters( 'listing_label', 'plural' );

		$seller_singular_label = apply_filters( 'seller_label', 'singular' );

		$column_class = '';
		if($attrs['columns'] == 1) {
			$column_class = 'dtdr-column dtdr-one-column';
		} else if($attrs['columns'] == 2) {
			$column_class = 'dtdr-column dtdr-one-half';
		} else if($attrs['columns'] == 3) {
			$column_class = 'dtdr-column dtdr-one-third';
		}

		// Script to run for author single pages
		$dtdr_asp_user_id = get_query_var('dtdr_asp_user_id');
		if(isset($dtdr_asp_user_id) && !empty($dtdr_asp_user_id)) {
			$attrs['include'] = $dtdr_asp_user_id;
		}

		$seller_args = array ( 'role' => 'seller' );
		if($attrs['include'] != '') {
			$seller_args['include'] = $attrs['include'];
		}
		$seller_args['meta_key'] = 'dtdr_user_status';
		$seller_args['meta_value'] = 'active';
		$seller_args['meta_compare'] = '=';

		$sellers = get_users ( $seller_args );

		if ( count( $sellers ) > 0 ) {

			$i = 1;
			foreach ($sellers as $seller) {

				$user_id = $seller->data->ID;

				if($i == 1) { $first_class = 'first';  } else { $first_class = ''; }
				if($i == $attrs['columns']) { $i = 1; } else { $i = $i + 1; }

				// Profile Image

					$profile_image_html = '';
					$dtdr_user_profile_image_url = get_the_author_meta( 'dtdr_user_profile_image_url' , $user_id );
					if($dtdr_user_profile_image_url != '') {

						$profile_image_html .= '<div class="dtdr-user-image">';
							$profile_image_html .= '<img src="'.esc_url($dtdr_user_profile_image_url).'" alt="'.sprintf( esc_attr__( '%1$s Profile Image', 'dtdr' ), $seller_singular_label ).'" title="'.sprintf( esc_attr__( '%1$s Profile Image', 'dtdr' ), $seller_singular_label ).'" />';
						$profile_image_html .= '</div>';

					}

				// User Name

					$username_html = '<h4><a href="'.get_author_posts_url( $user_id ).'" alt="'.get_the_author_meta( 'display_name', $user_id ).'" title="'.get_the_author_meta( 'display_name', $user_id ).'">'.get_the_author_meta( 'display_name' , $user_id ).'</a></h4>';

				// Specialization

					$specialization_html = '';
					$dtdr_specialization = get_the_author_meta( 'dtdr_user_specialization' , $user_id );
					if($dtdr_specialization != '') {
						$specialization_html .= '<div class="dtdr-user-specialization">'.esc_attr($dtdr_specialization).'</div>';
					}

				// Social Links

					$social_links_html = '';

					$dtdr_social_items = get_the_author_meta('dtdr_user_social_items', $user_id);
					$dtdr_social_items = (isset($dtdr_social_items) && is_array($dtdr_social_items)) ? $dtdr_social_items : array ();

					$dtdr_social_items_value = get_the_author_meta('dtdr_user_social_items_value', $user_id);
					$dtdr_social_items_value = (isset($dtdr_social_items_value) && is_array($dtdr_social_items_value)) ? $dtdr_social_items_value : array ();

					$k = 0;
					if(is_array($dtdr_social_items) && !empty($dtdr_social_items)) {

						$social_links_html .= '<ul class="dtdr-user-sociallinks-list">';

						foreach($dtdr_social_items as $dtdr_social_item) {
							$social_links_html .= '<li><a href="'.esc_url($dtdr_social_items_value[$k]).'"><span class="fab '.esc_attr($dtdr_social_item).'"></span></a></li>';
							$k++;
						}

						$social_links_html .= '</ul>';

					}

				// Contact Details

					$contact_details_html = '';

					$contact_details_html .= '<ul class="dtdr-user-contactdetails-list">';

						$dtdr_phone = get_the_author_meta( 'dtdr_user_phone' , $user_id );
						if($dtdr_phone != '') {
							$contact_details_html .= '<li><span class="fa fa-phone"></span>'.esc_attr($dtdr_phone).'</li>';
						}

						$dtdr_email = get_the_author_meta( 'user_email' , $user_id );
						if($dtdr_email != '') {
							$contact_details_html .= '<li><span class="fa fa-envelope"></span><a href="mailto:'.esc_attr($dtdr_email).'">'.esc_attr($dtdr_email).'</a></li>';
						}

						if($attrs['type'] == 'type3') {

							$dtdr_user_skype = get_the_author_meta( 'dtdr_user_skype' , $user_id );
							if($dtdr_user_skype != '') {
								$contact_details_html .= '<li><span class="fab fa-skype"></span><a href="skype:'.esc_attr($dtdr_user_skype).'?call">'.esc_attr($dtdr_user_skype).'</a></li>';
							}

						}

					$contact_details_html .= '</ul>';

				// Favorite Author Details

					$favourite_author_marker_html = dtdr_favourite_author_marker_html($user_id);

				// Social Share Details

					$social_share_html = do_shortcode('[dtdr_sp_author_social_share user_id='.$user_id.' show_facebook=true show_delicious=true show_digg=true show_stumbleupon=true show_twitter=true show_googleplus=true show_linkedin=true show_pinterest=true /]');


				$output .= '<div class="dtdr-user-list-item dtdr-seller-list-item '.$column_class.' '.$first_class.' '.$attrs['type'].' '.$attrs['class'].'">';

					if($attrs['type'] == 'type1') {

						$output .= $profile_image_html;
						$output .= '<div class="dtdr-user-item-meta-data">';
							$output .= $social_links_html;
							$output .= '<div class="dtdr-user-item-meta-details">';
								$output .= $username_html;
								$output .= $specialization_html;
							$output .= '</div>';
						$output .= '</div>';

					} else if($attrs['type'] == 'type2') {

						$output .= $profile_image_html;
						$output .= '<div class="dtdr-user-item-meta-data">';
							$output .= '<div class="dtdr-user-item-meta-details">';
								$output .= $username_html;
								$output .= $specialization_html;
							$output .= '</div>';
							$output .= $contact_details_html;
						$output .= '</div>';

					} else if($attrs['type'] == 'type3') {

						$output .= $profile_image_html;
						$output .= '<div class="dtdr-user-item-meta-data">';
							$output .= '<div class="dtdr-user-item-meta-details">';
								$output .= '<div class="dtdr-user-item-meta-elements">';
									$output .= $username_html;
									$output .= $favourite_author_marker_html;
									$output .= $social_share_html;
								$output .= '</div>';
								$output .= $specialization_html;
								$output .= $social_links_html;
								$output .= $contact_details_html;
							$output .= '</div>';
						$output .= '</div>';

					}

				$output .= '</div>';

			}

		}


		return $output;

	}
	add_shortcode ( 'dtdr_sellers', 'dtdr_sellers' );
}

// Default - Incharges
if(!function_exists('dtdr_incharges')) {
	function dtdr_incharges($attrs, $content = null) {

		$attrs = shortcode_atts ( array (

						'type' => 'type1',
						'columns' => '',
						'include' => '',
						'class' => '',

				), $attrs, 'dtdr_incharges' );


		$output = '';

		$listing_singular_label = apply_filters( 'listing_label', 'singular' );
		$listing_plural_label = apply_filters( 'listing_label', 'plural' );
		$incharge_singular_label = apply_filters( 'incharge_label', 'singular' );

		$column_class = '';
		if($attrs['columns'] == 1) {
			$column_class = 'dtdr-column dtdr-one-column';
		} else if($attrs['columns'] == 2) {
			$column_class = 'dtdr-column dtdr-one-half';
		} else if($attrs['columns'] == 3) {
			$column_class = 'dtdr-column dtdr-one-third';
		}

		// Script to run for author single pages

		$incharge_args = array ( 'role' => 'incharge', 'meta_query' => array (), );

		$dtdr_asp_user_id = get_query_var('dtdr_asp_user_id');
		$dtdr_asp_user_roles = get_query_var('dtdr_asp_user_roles');
		if(is_array($dtdr_asp_user_roles) && !empty($dtdr_asp_user_roles)) {
			if(in_array('seller', $dtdr_asp_user_roles)) {
				$incharge_args['meta_query'][] = array (
					'key'     => 'user_seller',
					'value'   => $dtdr_asp_user_id,
					'compare' => '=',
				);
				$attrs['include'] = '';
			} else if(in_array('incharge', $dtdr_asp_user_roles)) {
				$attrs['include'] = $dtdr_asp_user_id;
			}
		}

		if($attrs['include'] != '') {
			$incharge_args['include'] = $attrs['include'];
		}

		$incharge_args['meta_query'][] = array (
			'key'     => 'dtdr_user_status',
			'value'   => 'active',
			'compare' => '=',
		);

		$incharges = get_users ( $incharge_args );

		if ( count( $incharges ) > 0 ) {

			$i = 1;
			foreach ($incharges as $incharge) {

				$user_id = $incharge->data->ID;

				if($i == 1) { $first_class = 'first';  } else { $first_class = ''; }
				if($i == $attrs['columns']) { $i = 1; } else { $i = $i + 1; }

				// Profile Image

					$profile_image_html = '';
					$dtdr_user_profile_image_url = get_the_author_meta( 'dtdr_user_profile_image_url' , $user_id );
					if($dtdr_user_profile_image_url != '') {

						$profile_image_html .= '<div class="dtdr-user-image">';
							$profile_image_html .= '<img src="'.esc_url($dtdr_user_profile_image_url).'" alt="'.sprintf( esc_attr__( '%1$s Profile Image', 'dtdr' ), $incharge_singular_label ).'" title="'.sprintf( esc_attr__( '%1$s Profile Image', 'dtdr' ), $incharge_singular_label ).'" />';
						$profile_image_html .= '</div>';

					}

				// User Name

					$username_html = '<h4><a href="'.get_author_posts_url( $user_id ).'" alt="'.get_the_author_meta( 'display_name', $user_id ).'" title="'.get_the_author_meta( 'display_name', $user_id ).'">'.get_the_author_meta( 'display_name' , $user_id ).'</a></h4>';

				// Specialization

					$specialization_html = '';
					$dtdr_specialization = get_the_author_meta( 'dtdr_user_specialization' , $user_id );
					if($dtdr_specialization != '') {
						$specialization_html .= '<div class="dtdr-user-specialization">'.esc_attr($dtdr_specialization).'</div>';
					}

				// Social Links

					$social_links_html = '';

					$dtdr_social_items = get_the_author_meta('dtdr_user_social_items', $user_id);
					$dtdr_social_items = (isset($dtdr_social_items) && is_array($dtdr_social_items)) ? $dtdr_social_items : array ();

					$dtdr_social_items_value = get_the_author_meta('dtdr_user_social_items_value', $user_id);
					$dtdr_social_items_value = (isset($dtdr_social_items_value) && is_array($dtdr_social_items_value)) ? $dtdr_social_items_value : array ();

					$k = 0;
					if(is_array($dtdr_social_items) && !empty($dtdr_social_items)) {

						$social_links_html .= '<ul class="dtdr-user-sociallinks-list">';

						foreach($dtdr_social_items as $dtdr_social_item) {
							$social_links_html .= '<li><a href="'.esc_url($dtdr_social_items_value[$k]).'"><span class="fab '.esc_attr($dtdr_social_item).'"></span></a></li>';
							$k++;
						}

						$social_links_html .= '</ul>';

					}

				// Contact Details

					$contact_details_html = '';

					$contact_details_html .= '<ul class="dtdr-user-contactdetails-list">';

						$dtdr_phone = get_the_author_meta( 'dtdr_user_phone' , $user_id );
						if($dtdr_phone != '') {
							$contact_details_html .= '<li><span class="fa fa-phone"></span>'.esc_attr($dtdr_phone).'</li>';
						}

						$dtdr_email = get_the_author_meta( 'user_email' , $user_id );
						if($dtdr_email != '') {
							$contact_details_html .= '<li><span class="fa fa-envelope"></span><a href="mailto:'.esc_attr($dtdr_email).'">'.esc_attr($dtdr_email).'</a></li>';
						}

						if($attrs['type'] == 'type3') {

							$dtdr_user_skype = get_the_author_meta( 'dtdr_user_skype' , $user_id );
							if($dtdr_user_skype != '') {
								$contact_details_html .= '<li><span class="fab fa-skype"></span><a href="skype:'.esc_attr($dtdr_user_skype).'?call">'.esc_attr($dtdr_user_skype).'</a></li>';
							}

						}

					$contact_details_html .= '</ul>';

				// Favorite Author Details

					$favourite_author_marker_html = dtdr_favourite_author_marker_html($user_id);

				// Social Share Details

					$social_share_html = do_shortcode('[dtdr_sp_author_social_share user_id='.$user_id.' show_facebook=true show_delicious=true show_digg=true show_stumbleupon=true show_twitter=true show_googleplus=true show_linkedin=true show_pinterest=true /]');


				$output .= '<div class="dtdr-user-list-item dtdr-incharge-list-item '.$column_class.' '.$first_class.' '.$attrs['type'].' '.$attrs['class'].'">';

					if($attrs['type'] == 'type1') {

						$output .= $profile_image_html;
						$output .= '<div class="dtdr-user-item-meta-data">';
							$output .= $social_links_html;
							$output .= '<div class="dtdr-user-item-meta-details">';
								$output .= $username_html;
								$output .= $specialization_html;
							$output .= '</div>';
						$output .= '</div>';

					} else if($attrs['type'] == 'type2') {

						$output .= $profile_image_html;
						$output .= '<div class="dtdr-user-item-meta-data">';
							$output .= '<div class="dtdr-user-item-meta-details">';
								$output .= $username_html;
								$output .= $specialization_html;
							$output .= '</div>';
							$output .= $contact_details_html;
						$output .= '</div>';

					} else if($attrs['type'] == 'type3') {

						$output .= $profile_image_html;
						$output .= '<div class="dtdr-user-item-meta-data">';
							$output .= '<div class="dtdr-user-item-meta-details">';
								$output .= '<div class="dtdr-user-item-meta-elements">';
									$output .= $username_html;
									$output .= $favourite_author_marker_html;
									$output .= $social_share_html;
								$output .= '</div>';
								$output .= $specialization_html;
								$output .= $social_links_html;
								$output .= $contact_details_html;
							$output .= '</div>';
						$output .= '</div>';

					}

				$output .= '</div>';

			}

		}


		return $output;

	}
	add_shortcode ( 'dtdr_incharges', 'dtdr_incharges' );
}


// Single Page - Author
if(!function_exists('dtdr_sp_author')) {
	function dtdr_sp_author( $attrs, $content = null ) {

		$attrs = shortcode_atts ( array (

					'listing_id'               => '',
					'content_type'             => '',
					'type'                     => 'type1',
					'columns'                  => 1,

					'enable_carousel'          => '',
					'carousel_pagination'      => '',
					'carousel_pagination_type' => 'type1',
					'carousel_spacebetween'    => 20,
					'class'                    => '',

				), $attrs, 'dtdr_sp_author' );

		$output = '';

		if($attrs['listing_id'] == '' && is_singular('dtdr_listings')) {
			global $post;
			$attrs['listing_id'] = $post->ID;
		}

		if($attrs['listing_id'] != '') {

			$incharge_singular_label = apply_filters( 'incharge_label', 'singular' );

			if($attrs['columns'] == 2) {
				$column_class = 'dtdr-column dtdr-one-half';
			} else {
				$column_class = 'dtdr-column dtdr-one-column';
			}

			if($attrs['enable_carousel'] == 'true') {

				$author_carousel_attributes =array ();

				array_push($author_carousel_attributes, 'data-carouselslidesperview="'.$attrs['columns'].'"');
				array_push($author_carousel_attributes, 'data-carouselpagination="'.$attrs['carousel_pagination'].'"');
				array_push($author_carousel_attributes, 'data-carouselpaginationtype="'.$attrs['carousel_pagination_type'].'"');
				array_push($author_carousel_attributes, 'data-carouselspacebetween="'.$attrs['carousel_spacebetween'].'"');

				if(!empty($author_carousel_attributes)) {
					$author_carousel_attributes_string = implode(' ', $author_carousel_attributes);
				}

				$item_class = 'swiper-slide';
				$output .= '<div class="dtdr-listings-author-container swiper-container '.$attrs['class'].'" '.$author_carousel_attributes_string.'>';

					$output .= '<div class="dtdr-listings-author-gallery swiper-wrapper">';

			} else {

				$item_class = '';
				$output .= '<div class="dtdr-listings-author-container '.$attrs['class'].'">';

			}

			$dtdr_authors = array ();

			if($attrs['content_type'] == 'author') {

				$author = get_post($attrs['listing_id']);
				$authorid = $author->post_author;

				array_push($dtdr_authors, $authorid);

			} else if($attrs['content_type'] == 'incharges_included') {

				$dtdr_incharges = get_post_meta($attrs['listing_id'], 'dtdr_incharges', true);
				$dtdr_incharges = (is_array($dtdr_incharges) && !empty($dtdr_incharges)) ? $dtdr_incharges : array ();

				$dtdr_authors = array_merge($dtdr_authors, $dtdr_incharges);

			} else if($attrs['content_type'] == 'both') {

				$author = get_post($attrs['listing_id']);
				$authorid = $author->post_author;

				array_push($dtdr_authors, $authorid);

				$dtdr_incharges = get_post_meta($attrs['listing_id'], 'dtdr_incharges', true);
				$dtdr_incharges = (is_array($dtdr_incharges) && !empty($dtdr_incharges)) ? $dtdr_incharges : array ();

				$dtdr_authors = array_merge($dtdr_authors, $dtdr_incharges);

			}


			$i = 1;
			if(is_array($dtdr_authors) && !empty($dtdr_authors)) {
				foreach($dtdr_authors as $author_id) {

					$dtdr_user_status = get_the_author_meta('dtdr_user_status', $author_id);
					$dtdr_user_status = (isset($dtdr_user_status) && $dtdr_user_status != '') ? $dtdr_user_status : 'disabled';

					if($dtdr_user_status == 'active') {

						if($attrs['enable_carousel'] == 'true') {
							$first_class = $column_class = '';
						} else {
							if($i == 1) { $first_class = 'first';  } else { $first_class = ''; }
							if($i == $attrs['columns']) { $i = 1; } else { $i = $i + 1; }
						}

						// Profile Image

							$profile_image_html = '';
							$dtdr_user_profile_image_url = get_the_author_meta( 'dtdr_user_profile_image_url' , $author_id );
							if($dtdr_user_profile_image_url != '') {

								$profile_image_html .= '<div class="dtdr-user-image">';
									$profile_image_html .= '<img src="'.esc_url($dtdr_user_profile_image_url).'" alt="'.esc_attr__( 'Author Profile Image', 'dtdr' ).'" title="'.esc_attr__( 'Author Profile Image', 'dtdr' ).'" />';
								$profile_image_html .= '</div>';

							}

						// User Name

							$username_html = '<h4><a href="'.get_author_posts_url( $author_id ).'" alt="'.get_the_author_meta( 'display_name', $author_id ).'" title="'.get_the_author_meta( 'display_name', $author_id ).'">'.get_the_author_meta( 'display_name' , $author_id ).'</a></h4>';

						// Specialization

							$specialization_html = '';
							$dtdr_specialization = get_the_author_meta( 'dtdr_user_specialization' , $author_id );
							if($dtdr_specialization != '') {
								$specialization_html .= '<div class="dtdr-user-specialization">'.esc_attr($dtdr_specialization).'</div>';
							}

						// Social Links

							$social_links_html = '';

							$dtdr_social_items = get_the_author_meta('dtdr_user_social_items', $author_id);
							$dtdr_social_items = (isset($dtdr_social_items) && is_array($dtdr_social_items)) ? $dtdr_social_items : array ();

							$dtdr_social_items_value = get_the_author_meta('dtdr_user_social_items_value', $author_id);
							$dtdr_social_items_value = (isset($dtdr_social_items_value) && is_array($dtdr_social_items_value)) ? $dtdr_social_items_value : array ();

							$k = 0;
							if(is_array($dtdr_social_items) && !empty($dtdr_social_items)) {

								$social_links_html .= '<ul class="dtdr-user-sociallinks-list">';

								foreach($dtdr_social_items as $dtdr_social_item) {
									$social_links_html .= '<li><a href="'.esc_url($dtdr_social_items_value[$k]).'"><span class="fab '.esc_attr($dtdr_social_item).'"></span></a></li>';
									$k++;
								}

								$social_links_html .= '</ul>';

							}

						// Contact Details

							$contact_details_html = '';

							$contact_details_html .= '<ul class="dtdr-user-contactdetails-list">';

								$dtdr_phone = get_the_author_meta( 'dtdr_user_phone' , $author_id );
								if($dtdr_phone != '') {
									$contact_details_html .= '<li><span class="fa fa-phone"></span>'.esc_attr($dtdr_phone).'</li>';
								}

								$dtdr_email = get_the_author_meta( 'user_email' , $author_id );
								if($dtdr_email != '') {
									$contact_details_html .= '<li><span class="fa fa-envelope"></span><a href="mailto:'.esc_attr($dtdr_email).'">'.esc_attr($dtdr_email).'</a></li>';
								}

								if($attrs['type'] == 'type3') {

									$dtdr_user_skype = get_the_author_meta( 'dtdr_user_skype' , $author_id );
									if($dtdr_user_skype != '') {
										$contact_details_html .= '<li><span class="fab fa-skype"></span><a href="skype:'.esc_attr($dtdr_user_skype).'?call">'.esc_attr($dtdr_user_skype).'</a></li>';
									}

								}

							$contact_details_html .= '</ul>';


						$output .= '<div class="dtdr-user-list-item dtdr-author-list-item '.esc_attr($attrs['type']).' '.esc_attr($column_class).' '.esc_attr($item_class).' '.esc_attr($first_class).'">';

							if($attrs['type'] == 'type1') {

								$output .= $profile_image_html;
								$output .= '<div class="dtdr-user-item-meta-data">';
									$output .= $social_links_html;
									$output .= '<div class="dtdr-user-item-meta-details">';
										$output .= $username_html;
										$output .= $specialization_html;
									$output .= '</div>';
								$output .= '</div>';

							} else if($attrs['type'] == 'type2') {

								$output .= $profile_image_html;
								$output .= '<div class="dtdr-user-item-meta-data">';
									$output .= '<div class="dtdr-user-item-meta-details">';
										$output .= $username_html;
										$output .= $specialization_html;
									$output .= '</div>';
									$output .= $contact_details_html;
								$output .= '</div>';

							} else if($attrs['type'] == 'type3') {

								$output .= $profile_image_html;
								$output .= '<div class="dtdr-user-item-meta-data">';
									$output .= '<div class="dtdr-user-item-meta-details">';
										$output .= $username_html;
										$output .= $specialization_html;
										$output .= $social_links_html;
										$output .= $contact_details_html;
									$output .= '</div>';
								$output .= '</div>';

							}

						$output .= '</div>';

					}

				}
			}

			if($attrs['enable_carousel'] == 'true') {
				$output .= '</div>';

					if($attrs['carousel_pagination'] == 'bullets' || $attrs['carousel_pagination'] == 'arrows') {

						$output .= '<div class="dtdr-listings-swiper-pagination-holder '.$attrs['carousel_pagination_type'].'">';

							if($attrs['carousel_pagination'] == 'bullets') {
								$output .= '<div class="dtdr-swiper-bullet-pagination"></div>';
							}

							if($attrs['carousel_pagination'] == 'arrows') {
								$output .= '<div class="dtdr-swiper-arrow-pagination">';
									$output .= '<a href="#" class="dtdr-swiper-arrow-prev">'.esc_html__('Prev', 'dtdr').'</a>';
									$output .= '<a href="#" class="dtdr-swiper-arrow-next">'.esc_html__('Next', 'dtdr').'</a>';
								$output .= '</div>';
							}

						$output .= '</div>';

					}

				$output .= '</div>';
			} else {
				$output .= '</div>';
			}

		} else {

			$listing_singular_label = apply_filters( 'listing_label', 'singular' );

			$output .= sprintf( esc_html__('Please provide %1$s id to display corresponding data!', 'dtdr'), strtolower($listing_singular_label) );

		}

		return $output;

	}
	add_shortcode ( 'dtdr_sp_author', 'dtdr_sp_author' );
}


// Search Form - Sellers
if(!function_exists('dtdr_sf_sellers_field')) {
	function dtdr_sf_sellers_field( $attrs, $content = null ) {

		$attrs = shortcode_atts ( array (

					'field_type' => '',
					'placeholder_text' => '',
					'dropdown_type' => '',
					'ajax_load' => '',
					'class' => '',

				), $attrs, 'dtdr_sf_sellers_field' );


		$output = '';

		$output .= '<div class="dtdr-sf-fields-holder dtdr-sf-sellers-field-holder '.$attrs['class'].'">';

			$additional_class = '';
			if($attrs['ajax_load'] == 'true') {
				$additional_class = 'dtdr-with-ajax-load';
			}

			$dtdr_sf_sellers = array ();
			if(isset($_REQUEST['dtdr_sf_sellers'])) {
				if(is_array($_REQUEST['dtdr_sf_sellers']) && !empty($_REQUEST['dtdr_sf_sellers'])) {
					$dtdr_sf_sellers = dtdr_recursive_sanitize_text_field($_REQUEST['dtdr_sf_sellers']);
				} else if($_REQUEST['dtdr_sf_sellers'] != '') {
					$dtdr_sf_sellers = explode(',', dtdr_recursive_sanitize_text_field($_REQUEST['dtdr_sf_sellers']));
				}

			} else {

				// Script to run for author single pages

				$dtdr_asp_user_id = get_query_var('dtdr_asp_user_id');
				$dtdr_asp_user_roles = get_query_var('dtdr_asp_user_roles');
				if(is_array($dtdr_asp_user_roles) && !empty($dtdr_asp_user_roles)) {
					if(in_array('seller', $dtdr_asp_user_roles)) {
						$dtdr_sf_sellers = array ($dtdr_asp_user_id);
					}
				}

			}

			$seller_plural_label = apply_filters( 'seller_label', 'plural' );
			$placeholder_text = $seller_plural_label;
			if($attrs['placeholder_text'] != '') {
				$placeholder_text = esc_html($attrs['placeholder_text']);
			}

			if($attrs['field_type'] == 'dropdown') {

				$mulitple_attr = '';
				if($attrs['dropdown_type'] == 'multiple') {
					$mulitple_attr = 'multiple';
				}

				$output .= '<select class="dtdr-sf-field dtdr-sf-sellers '.esc_attr($additional_class).' dtdr-chosen-select" name="dtdr_sf_sellers" data-placeholder="'.esc_attr($placeholder_text).'" '.esc_attr($mulitple_attr).'>';

					if($mulitple_attr == '') {
						$output .= '<option value="">'.esc_attr($placeholder_text).'</option>';
					}

					$sellers = get_users ( array ('role' => 'seller', 'meta_key' => 'dtdr_user_status', 'meta_value' => 'active', 'meta_compare' => '=', 'fields' => array( 'ID', 'display_name' ) ) );
					if(count($sellers) > 0) {
						foreach($sellers as $seller) {

							$seller_id = $seller->ID;

							$selected_attr = '';
							if(in_array($seller_id, $dtdr_sf_sellers)) {
								$selected_attr = 'selected="selected"';
							}

							$output .= '<option value="'.esc_attr($seller_id).'" '.$selected_attr.'>'.esc_html($seller->display_name).'</option>';

						}
					}

				$output .= '</select>';

			} else {

				$output .= '<ul>';
					$sellers = get_users ( array ('role' => 'seller', 'meta_key' => 'dtdr_user_status', 'meta_value' => 'active', 'meta_compare' => '=', 'fields' => array( 'ID', 'display_name' ) ) );
					if(count($sellers) > 0) {
						foreach($sellers as $seller) {

							$seller_id = $seller->ID;

							$output .= '<li>
											<input type="checkbox" name="dtdr_sf_sellers[]" class="dtdr-sf-field dtdr-sf-sellers '.esc_attr($additional_class).'" value="'.esc_attr($seller_id).'" id="dtdr-sf-sellers-'.esc_attr($seller_id).'" '.checked(in_array($seller_id, $dtdr_sf_sellers), true, false).' />
											<label for="dtdr-sf-sellers-'.esc_attr($seller_id).'">'.esc_html($seller->display_name).'</label>
										</li>';

						}
					}
				$output .= '</ul>';

			}

		$output .= '</div>';

		return $output;

	}
	add_shortcode ( 'dtdr_sf_sellers_field', 'dtdr_sf_sellers_field' );
}

// Search Form - Incharges
if(!function_exists('dtdr_sf_incharges_field')) {
	function dtdr_sf_incharges_field( $attrs, $content = null ) {

		$attrs = shortcode_atts ( array (

					'field_type' => '',
					'placeholder_text' => '',
					'dropdown_type' => '',
					'ajax_load' => '',
					'class' => '',

				), $attrs, 'dtdr_sf_incharges_field' );


		$output = '';

		$output .= '<div class="dtdr-sf-fields-holder dtdr-sf-incharges-field-holder '.$attrs['class'].'">';

			$additional_class = '';
			if($attrs['ajax_load'] == 'true') {
				$additional_class = 'dtdr-with-ajax-load';
			}

			$dtdr_sf_incharges = array ();
			if(isset($_REQUEST['dtdr_sf_incharges'])) {
				if(is_array($_REQUEST['dtdr_sf_incharges']) && !empty($_REQUEST['dtdr_sf_incharges'])) {
					$dtdr_sf_incharges = dtdr_recursive_sanitize_text_field($_REQUEST['dtdr_sf_incharges']);
				} else if($_REQUEST['dtdr_sf_incharges'] != '') {
					$dtdr_sf_incharges = explode(',', dtdr_recursive_sanitize_text_field($_REQUEST['dtdr_sf_incharges']));
				}
			} else {

				// Script to run for author single pages

				$dtdr_asp_user_id = get_query_var('dtdr_asp_user_id');
				$dtdr_asp_user_roles = get_query_var('dtdr_asp_user_roles');
				if(is_array($dtdr_asp_user_roles) && !empty($dtdr_asp_user_roles)) {
					if(in_array('incharge', $dtdr_asp_user_roles)) {
						$dtdr_sf_incharges = array ($dtdr_asp_user_id);
					}
				}

			}

			$incharge_plural_label = apply_filters( 'incharge_label', 'plural' );
			$placeholder_text = $incharge_plural_label;
			if($attrs['placeholder_text'] != '') {
				$placeholder_text = esc_html($attrs['placeholder_text']);
			}

			if($attrs['field_type'] == 'dropdown') {

				$mulitple_attr = '';
				if($attrs['dropdown_type'] == 'multiple') {
					$mulitple_attr = 'multiple';
				}

				$output .= '<select class="dtdr-sf-field dtdr-sf-incharges '.esc_attr($additional_class).' dtdr-chosen-select" name="dtdr_sf_incharges" data-placeholder="'.esc_attr($placeholder_text).'" '.esc_attr($mulitple_attr).'>';

					if($mulitple_attr == '') {
						$output .= '<option value="">'.esc_attr($placeholder_text).'</option>';
					}

					$incharges = get_users ( array ('role' => 'incharge', 'meta_key' => 'dtdr_user_status', 'meta_value' => 'active', 'meta_compare' => '=', 'fields' => array( 'ID', 'display_name' ) ) );
					if(count($incharges) > 0) {
						foreach($incharges as $incharge) {

							$incharge_id = $incharge->ID;

							$selected_attr = '';
							if(in_array($incharge_id, $dtdr_sf_incharges)) {
								$selected_attr = 'selected="selected"';
							}

							$output .= '<option value="'.esc_attr($incharge_id).'" '.$selected_attr.'>'.esc_html($incharge->display_name).'</option>';

						}
					}

				$output .= '</select>';

			} else {

				$output .= '<ul>';
					$incharges = get_users ( array ('role' => 'incharge', 'meta_key' => 'dtdr_user_status', 'meta_value' => 'active', 'meta_compare' => '=', 'fields' => array( 'ID', 'display_name' ) ) );
					if(count($incharges) > 0) {
						foreach($incharges as $incharge) {

							$incharge_id = $incharge->ID;

							$output .= '<li>
											<input type="checkbox" name="dtdr_sf_incharges[]" class="dtdr-sf-field dtdr-sf-incharges '.esc_attr($additional_class).'" value="'.esc_attr($incharge_id).'" id="dtdr-sf-incharges-'.esc_attr($incharge_id).'" '.checked(in_array($incharge_id, $dtdr_sf_incharges), true, false).' />
											<label for="dtdr-sf-incharges-'.esc_attr($incharge_id).'">'.esc_html($incharge->display_name).'</label>
										</li>';

						}
					}
				$output .= '</ul>';

			}

		$output .= '</div>';

		return $output;

	}
	add_shortcode ( 'dtdr_sf_incharges_field', 'dtdr_sf_incharges_field' );
}

// Social Share - Incharges / Sellers
if(!function_exists('dtdr_sp_author_social_share')) {
	function dtdr_sp_author_social_share( $attrs, $content = null ) {

		$attrs = shortcode_atts ( array (

					'user_id'	       => '',
					'type'             => 'type1',
					'show_facebook'    => '',
					'show_delicious'   => '',
					'show_digg'        => '',
					'show_stumbleupon' => '',
					'show_twitter'     => '',
					'show_googleplus'  => '',
					'show_linkedin'    => '',
					'show_pinterest'   => '',
					'class'            => '',

				), $attrs, 'dtdr_sp_author_social_share' );

		$output = '';

		// Script to run for author single pages
		$dtdr_asp_user_id = get_query_var('dtdr_asp_user_id');
		if($attrs['user_id'] == '' && isset($dtdr_asp_user_id) && !empty($dtdr_asp_user_id)) {
			$attrs['user_id'] = $dtdr_asp_user_id;
		}

		if($attrs['user_id'] != '') {

			if($attrs['show_facebook'] == 'true' || $attrs['show_delicious'] == 'true' || $attrs['show_digg'] == 'true' || $attrs['show_stumbleupon'] == 'true' || $attrs['show_twitter'] == 'true' || $attrs['show_googleplus'] == 'true' || $attrs['show_linkedin'] == 'true' || $attrs['show_pinterest'] == 'true') {

				$output .= '<div class="dtdr-listings-social-share-container '.$attrs['type'].' '.$attrs['class'].'">';

					$output .= '<a class="dtdr-listings-social-share-item-icon"><span class="fas fa-share-alt"></span></a>';

					$output .= '<ul class="dtdr-listings-social-share-list">';

						$sstitle = get_the_author_meta( 'display_name' , $attrs['user_id'] );
						$ssurl 	 = get_author_posts_url( $attrs['user_id'] );

						if($attrs['show_facebook'] == 'true') {
							$output .= '<li> <a href="//www.facebook.com/sharer.php?u='.$ssurl.'&amp;t='.urlencode($sstitle).'" title="facebook" target="_blank"> <span class="fab fa-facebook"></span>  </a> </li>';
						}
						if($attrs['show_delicious'] == 'true') {
							$output .= '<li> <a href="//del.icio.us/post?url='.$ssurl.'&amp;title='.urlencode($sstitle).'" title="delicious" target="_blank"> <span class="fab fa-delicious"></span>  </a> </li>';
						}
						if($attrs['show_digg'] == 'true') {
							$output .= '<li> <a href="//digg.com/submit?phase=2&amp;url='.$ssurl.'&amp;title='.urlencode($sstitle).'" title="digg" target="_blank"> <span class="fab fa-digg"></span>  </a> </li>';
						}
						if($attrs['show_stumbleupon'] == 'true') {
							$output .= '<li> <a href="//www.stumbleupon.com/submit?url='.$ssurl.'&amp;title='.urlencode($sstitle).'" title="stumbleupon" target="_blank"> <span class="fab fa-stumbleupon"></span>  </a> </li>';
						}
						if($attrs['show_twitter'] == 'true') {
							$output .= '<li> <a href="//twitter.com/home/?status='.$ssurl.':'.urlencode($sstitle).'" title="twitter" target="_blank"> <span class="fab fa-twitter"></span>  </a> </li>';
						}
						if($attrs['show_googleplus'] == 'true') {
							$output .= '<li> <a href="//plus.google.com/share?url='.$ssurl.'" title="googleplus" target="_blank" onclick="javascript:window.open(this.href,\"\",\"menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600\");return false;"> <span class="fab fa-google-plus"></span>  </a> </li>';
						}
						if($attrs['show_linkedin'] == 'true') {
							$output .= '<li> <a href="//www.linkedin.com/shareArticle?mini=true&amp;title='.urlencode($sstitle).'&amp;url='.$ssurl.'" title="linkedin" target="_blank"> <span class="fab fa-linkedin"></span>  </a> </li>';
						}
						if($attrs['show_pinterest'] == 'true') {

							$media = get_the_author_meta( 'dtdr_user_profile_image_url' , $attrs['user_id'] );

							$output .= '<li> <a href="//pinterest.com/pin/create/button/?url='.$ssurl.'&amp;media='.$media.'" title="pinterest" target="_blank"> <span class="fab fa-pinterest"></span>  </a> </li>';

						}

					$output .= '</ul>';

				$output .= '</div>';

				wp_enqueue_style ( 'dtdr-social-share-frontend' );

				wp_enqueue_script ( 'dtdr-social-share-frontend' );

			}

		}

		return $output;

	}
	add_shortcode ( 'dtdr_sp_author_social_share', 'dtdr_sp_author_social_share' );
}

// Favourite author marker html
function dtdr_favourite_author_marker_html($author_id) {

	$favourite_marker = '';

	$current_user = wp_get_current_user();
	$user_id = $current_user->ID;

	$favourite_authors = get_user_meta($user_id, 'favourite_authors', true);
	$favourite_authors = (is_array($favourite_authors) && !empty($favourite_authors)) ? $favourite_authors : array();

	$favourite_attr = 'data-authorid="'.$author_id.'"';
	if($user_id > 0) {
		if(in_array($author_id, $favourite_authors)) {
			$favourite_class = 'removefavourite';
			$favourite_icon_class = 'fa fa-heart';
		} else {
			$favourite_class = 'addtofavourite';
			$favourite_icon_class = 'far fa-heart';
		}
		$favourite_attr .= ' data-userid="'.$user_id.'"';
	} else {
		$favourite_class = 'dtdr-login-link';
		$favourite_attr = '';
		$favourite_icon_class = 'far fa-heart';
	}

	$favourite_marker .= '<div class="dtdr-listings-utils-item dtdr-listings-utils-favourite">';
		$favourite_marker .= '<a class="dtdr-listings-utils-favourite-author '.$favourite_class.'" '.$favourite_attr.'><span class="'.$favourite_icon_class.'"></span></a>';
	$favourite_marker .= '</div>';

	return $favourite_marker;

}

// Author favourite marker
add_action( 'wp_ajax_dtdr_listing_favourite_author_marker', 'dtdr_listing_favourite_author_marker' );
add_action( 'wp_ajax_nopriv_dtdr_listing_favourite_author_marker', 'dtdr_listing_favourite_author_marker' );
function dtdr_listing_favourite_author_marker() {

	$author_id = isset($_REQUEST['author_id']) ? dtdr_recursive_sanitize_text_field($_REQUEST['author_id']) : -1;
	$user_id   = isset($_REQUEST['user_id']) ? dtdr_recursive_sanitize_text_field($_REQUEST['user_id']) : -1;

	if($author_id > 0 && $user_id > 0) {

		$favourite_authors = get_user_meta($user_id, 'favourite_authors', true);
		$favourite_authors = (is_array($favourite_authors) && !empty($favourite_authors)) ? $favourite_authors : array();

		if(in_array($author_id, $favourite_authors)) {
			unset($favourite_authors[array_search($author_id, $favourite_authors)]);
		} else {
			array_push($favourite_authors, $author_id);
		}

		update_user_meta($user_id, 'favourite_authors', $favourite_authors);

	}

	die();

}

?>