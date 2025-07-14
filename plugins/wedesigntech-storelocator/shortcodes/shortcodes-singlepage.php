<?php

if( !class_exists('DTStoreLocatorSinglePageShortcodes') ) {

	class DTStoreLocatorSinglePageShortcodes {

		/**
		 * Instance variable
		 */
		private static $_instance = null;

		/**
		 * Instance
		 *
		 * Ensures only one instance of the class is loaded or can be loaded.
		 */
		public static function instance() {

			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		function __construct() {

			add_shortcode ( 'dtsl_sp_featured_image', array ( $this, 'dtsl_sp_featured_image' ) );
			add_shortcode ( 'dtsl_sp_featured_item', array ( $this, 'dtsl_sp_featured_item' ) );
			add_shortcode ( 'dtsl_sp_features', array ( $this, 'dtsl_sp_features' ) );
			add_shortcode ( 'dtsl_sp_contact_details', array ( $this, 'dtsl_sp_contact_details' ) );
			add_shortcode ( 'dtsl_sp_contact_details_request_btn', array ( $this, 'dtsl_sp_contact_details_request_btn' ) );
			add_shortcode ( 'dtsl_sp_social_links', array ( $this, 'dtsl_sp_social_links' ) );
			add_shortcode ( 'dtsl_sp_comments', array ( $this, 'dtsl_sp_comments' ) );
			add_shortcode ( 'dtsl_sp_utils', array ( $this, 'dtsl_sp_utils' ) );
			add_shortcode ( 'dtsl_sp_taxonomy', array ( $this, 'dtsl_sp_taxonomy' ) );
			add_shortcode ( 'dtsl_sp_contact_form', array ( $this, 'dtsl_sp_contact_form' ) );
			add_shortcode ( 'dtsl_sp_post_date', array ( $this, 'dtsl_sp_post_date' ) );
			add_shortcode ( 'dtsl_sp_mls_number', array ( $this, 'dtsl_sp_mls_number' ) );
			add_shortcode ( 'dtsl_sp_content', array ( $this, 'dtsl_sp_content' ) );

		}


		function dtsl_shortcodeHelper($content = null) {
			$content = do_shortcode ( shortcode_unautop ( $content ) );
			$content = preg_replace ( '#^<\/p>|^<br \/>|<p>$#', '', $content );
			$content = preg_replace ( '#<br \/>#', '', $content );
			return trim ( $content );
		}

		function dtsl_sp_featured_image( $attrs, $content = null ) {

			$attrs = shortcode_atts ( array (

						'listing_id' => '',
						'image_size' => 'full',
						'with_link' => '',
						'class' => '',

					), $attrs, 'dtsl_sp_featured_image' );


			$output = '';

			if($attrs['listing_id'] == '' && is_singular('dtsl_listings')) {
				global $post;
				$attrs['listing_id'] = $post->ID;
			}

			if($attrs['listing_id'] != '') {

				$featured_image_id = get_post_thumbnail_id($attrs['listing_id']);
				$image_details = wp_get_attachment_image_src($featured_image_id, $attrs['image_size']);

				$output .= '<div class="dtsl-listings-feature-image-holder '.$attrs['class'].'">';

					if($attrs['with_link'] == 'true') {
						$output .= '<a href="'.get_permalink($attrs['listing_id']).'">';
					}
						$output .= '<img src="'.esc_url($image_details[0]).'" title="'.esc_html__('Featured Image', 'dtsl').'" all="'.esc_html__('Featured Image', 'dtsl').'" />';
					if($attrs['with_link'] == 'true') {
						$output .= '</a>';
					}

				$output .= '</div>';

			} else {

				$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );

				$output .= sprintf( esc_html__('Please provide %1$s id to display corresponding data!', 'dtsl'), strtolower($dt_sl_listing_singular_label) );

			}

			return $output;

		}

		function dtsl_sp_featured_item( $attrs, $content = null ) {

			$attrs = shortcode_atts ( array (

						'listing_id' => '',
						'type' => 'type1',
						'class' => '',

					), $attrs, 'dtsl_sp_featured_item' );

			$output = '';

			if($attrs['listing_id'] == '' && is_singular('dtsl_listings')) {
				global $post;
				$attrs['listing_id'] = $post->ID;
			}

			if($attrs['listing_id'] != '') {

				$dtsl_featured_item = get_post_meta($attrs['listing_id'], 'dtsl_featured_item', true);
				if($dtsl_featured_item == 'true') {

					$output .= '<div class="dtsl-listings-featured-item-container '.$attrs['class'].' '.$attrs['type'].'">';
						$output .= '<span>'.esc_html__('Featured', 'dtsl').'</span>';
					$output .= '</div>';

				}

			} else {

				$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );
				$output .= sprintf( esc_html__('Please provide %1$s id to display corresponding data!', 'dtsl'), strtolower($dt_sl_listing_singular_label) );

			}

			return $output;

		}

		function dtsl_sp_features( $attrs, $content = null ) {

			$attrs = shortcode_atts ( array (

						'listing_id'             => '',
						'type'                   => 'type1',
						'include'                => '',
						'columns'                => 4,
						'features_image_or_icon' => '',
						'class'                  => '',

					), $attrs, 'dtsl_sp_features' );


			$output = '';

			if($attrs['listing_id'] == '' && is_singular('dtsl_listings')) {
				global $post;
				$attrs['listing_id'] = $post->ID;
			}

			if($attrs['listing_id'] != '') {

				if($attrs['columns'] == 1) {
					$column_class = 'dtsl-column dtsl-one-column';
				} else if($attrs['columns'] == 2) {
					$column_class = 'dtsl-column dtsl-one-half';
				} else if($attrs['columns'] == 3) {
					$column_class = 'dtsl-column dtsl-one-third';
				} else if($attrs['columns'] == 4) {
					$column_class = 'dtsl-column dtsl-one-fourth';
				} else if($attrs['columns'] == -1) {
					if($attrs['type'] == 'listing') {
						$column_class = '';
					} else {
						$column_class = '';
						$attrs['class'] .= ' dtsl-no-column';
					}
				}

				$output .= '<div class="dtsl-listings-features-box-container '.$attrs['type'].' '.$attrs['class'].'">';

					$dtsl_features_title = $dtsl_features_subtitle = $dtsl_features_value = $dtsl_features_valueunit = $dtsl_features_icon = $dtsl_features_image = '';
					if($attrs['listing_id'] > 0) {
						$dtsl_features_title = get_post_meta($attrs['listing_id'], 'dtsl_features_title', true);
						$dtsl_features_subtitle = get_post_meta($attrs['listing_id'], 'dtsl_features_subtitle', true);
						$dtsl_features_value = get_post_meta($attrs['listing_id'], 'dtsl_features_value', true);
						$dtsl_features_valueunit = get_post_meta($attrs['listing_id'], 'dtsl_features_valueunit', true);
						$dtsl_features_icon = get_post_meta($attrs['listing_id'], 'dtsl_features_icon', true);
						$dtsl_features_image = get_post_meta($attrs['listing_id'], 'dtsl_features_image', true);
					}

					if($attrs['include'] != '') {
						$include_keys = explode(',', $attrs['include']);
					} else {
						if($attrs['type'] == 'listing') {
							if( isset($dtsl_features_title) && !empty($dtsl_features_title) ) {
								$include_keys = array_keys($dtsl_features_title);
								array_splice($include_keys, 4);
							}
						} else {
							$include_keys = array_keys($dtsl_features_title);
						}
					}

					$j = 0; $i = 1;
					if(is_array($dtsl_features_title) && !empty($dtsl_features_title)) {
						foreach($dtsl_features_title as $dtsl_feature_title) {

							if(in_array($j, $include_keys)) {

								if($i == 1 && $attrs['columns'] != -1) { $first_class = 'first';  } else { $first_class = ''; }
								if($i == $attrs['columns']) { $i = 1; } else { $i = $i + 1; }

								$dtsl_features_image_html = $style_attr = '';
								$image_url = wp_get_attachment_image_src($dtsl_features_image[$j], 'full');
								if($image_url != '') {
									$dtsl_features_image_html .= ' <div class="dtsl-listings-features-box-item-img"  style="background-image:url('.esc_url($image_url[0]).');"></div>';
									if($attrs['type'] == 'listing' && $attrs['features_image_or_icon'] == 'image') {
										$style_attr .= 'style="background-image:url('.esc_url($image_url[0]).');"';
									}
								}

								$dtsl_features_icon_html = '';
								if(($attrs['type'] == 'listing' && $attrs['features_image_or_icon'] == 'icon' && isset($dtsl_features_icon[$j]) && !empty($dtsl_features_icon[$j])) || ($attrs['type'] != 'listing' && isset($dtsl_features_icon[$j]) && !empty($dtsl_features_icon[$j]))) {
									$dtsl_features_icon_html .= '<div class="dtsl-listings-features-box-item-icon"><span class="'.esc_attr($dtsl_features_icon[$j]).'"></span></div>';
								}

								$dtsl_features_title_html = '';
								if(isset($dtsl_feature_title) && !empty($dtsl_feature_title)) {
									$dtsl_features_title_html .= '<div class="dtsl-listings-features-box-item-title">'.esc_attr($dtsl_feature_title).'</div>';
								}

								$dtsl_features_subtitle_html = '';
								if(isset($dtsl_features_subtitle[$j]) && !empty($dtsl_features_subtitle[$j])) {
									$dtsl_features_subtitle_html .= '<div class="dtsl-listings-features-box-item-subtitle">'.esc_attr($dtsl_features_subtitle[$j]).'</div>';
								}

								$dtsl_features_value_html = '';
								if(isset($dtsl_features_value[$j]) && !empty($dtsl_features_value[$j])) {
									$dtsl_features_value_html .= '<div class="dtsl-listings-features-box-item-value">';
										$dtsl_features_value_html .= esc_attr($dtsl_features_value[$j]);
										if(isset($dtsl_features_valueunit[$j]) && !empty($dtsl_features_valueunit[$j])) {
											$dtsl_features_value_html .= '<span>'.esc_attr($dtsl_features_valueunit[$j]).'</span>';
										}
									$dtsl_features_value_html .= '</div>';
								}


								$output .= '<div class="dtsl-listings-features-box-item '.esc_attr($column_class).' '.esc_attr($first_class).'" '.$style_attr.'>';

									if($attrs['type'] == 'listing') {
										$output .= $dtsl_features_icon_html;
										$output .= $dtsl_features_title_html;
										$output .= $dtsl_features_value_html;
									} else if($attrs['type'] == 'type1') {
										$output .= $dtsl_features_title_html;
										$output .= $dtsl_features_value_html;
									} else if($attrs['type'] == 'type2') {
										$output .= $dtsl_features_image_html;
										$output .= $dtsl_features_title_html;
										$output .= $dtsl_features_value_html;
									} else if($attrs['type'] == 'type3') {
										$output .= $dtsl_features_icon_html;
										$output .= $dtsl_features_title_html;
										$output .= $dtsl_features_value_html;
									} else if($attrs['type'] == 'type4') {
										$output .= $dtsl_features_title_html;
										$output .= $dtsl_features_value_html;
									} else if($attrs['type'] == 'type5') {
										$output .= $dtsl_features_title_html;
										$output .= $dtsl_features_value_html;
									} else if($attrs['type'] == 'type6') {
										$output .= $dtsl_features_image_html;
										$output .= '<div class="dtsl-listings-features-box-item-details">';
											$output .= $dtsl_features_title_html;
											$output .= $dtsl_features_value_html;
										$output .= '</div>';
									} else if($attrs['type'] == 'type7') {
										$output .= $dtsl_features_title_html;
										$output .= $dtsl_features_value_html;
									}

								$output .= '</div>';

							}

							$j++;

						}
					}

				$output .= '</div>';

			} else {

				$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );
				$output .= sprintf( esc_html__('Please provide %1$s id to display corresponding data!', 'dtsl'), strtolower($dt_sl_listing_singular_label) );

			}

			return $output;

		}

		function dtsl_sp_contact_details( $attrs, $content = null ) {

			$attrs = shortcode_atts ( array (

						'listing_id'              => '',
						'type'                    => '',
						'contact_details'         => 'list',
						'include_address'         => '',
						'include_email'           => '',
						'include_phone'           => '',
						'include_mobile'          => '',
						'include_skype'           => '',
						'include_website'         => '',
						'requires_buyer_packages' => '',
						'show_direction_link'     => '',
						'class'                   => '',

					), $attrs, 'dtsl_sp_contact_details' );

			$output = '';

			if($attrs['listing_id'] == '' && is_singular('dtsl_listings')) {
				global $post;
				$attrs['listing_id'] = $post->ID;
			}

			if($attrs['listing_id'] != '') {

				if($attrs['type'] == 'listing') {
					$attrs['type'] = '';
				}

				$current_user = wp_get_current_user();
				$user_id = $current_user->ID;

				$dtsl_buyer_package_listings = get_user_meta($user_id, 'dtsl_buyer_package_listings', true);
				$dtsl_buyer_package_listings = (is_array($dtsl_buyer_package_listings) && !empty($dtsl_buyer_package_listings)) ? $dtsl_buyer_package_listings : array ();
				$dtsl_buyer_package_listings = array_unique($dtsl_buyer_package_listings);


				if(($attrs['requires_buyer_packages'] != 'true') || ($attrs['requires_buyer_packages'] == 'true' && in_array($attrs['listing_id'], $dtsl_buyer_package_listings))) {

					$output .= '<div class="dtsl-listings-contactdetails-container '.$attrs['type'].' '.$attrs['class'].'">';

						$output .= '<ul class="dtsl-listings-contactdetails-list">';

							$dtsl_modules = dtstorelocator_instance()->active_modules;
							$dtsl_modules = (is_array($dtsl_modules) && !empty($dtsl_modules)) ? $dtsl_modules : array ();

							if($attrs['include_address'] == 'true' && in_array('location', $dtsl_modules)) {

								$dtsl_latitude                    = get_post_meta($attrs['listing_id'], 'dtsl_latitude', true);
								$dtsl_longitude                   = get_post_meta($attrs['listing_id'], 'dtsl_longitude', true);

								$dtsl_address                     = get_post_meta($attrs['listing_id'], 'dtsl_address', true);
								$dtsl_zip                         = get_post_meta($attrs['listing_id'], 'dtsl_zip', true);
								$dtsl_country                     = get_post_meta($attrs['listing_id'], 'dtsl_country', true);

								$contact_address = $dtsl_address;
								if($dtsl_country != '') {
									$contact_address .= ', '.$dtsl_country;
								}
								if($dtsl_zip != '') {
									$contact_address .= ' '.$dtsl_zip;
								}

								$contact_address = trim($contact_address, ',');

								if($contact_address != '') {
									$output .= '<li><span class="fa fa-map-marker"></span>';
										$output .= '<p>';
											$output .= $contact_address;
											if($attrs['show_direction_link'] == 'true') {
												$output .= '<br><a href="//maps.google.com/maps?daddr='.$dtsl_latitude.','.$dtsl_longitude.'" class="dtsl-listings-address-directions" target="_blank">'.esc_html__('Get Direction', 'dtsl').'<span class="fa fa-angle-right"></span></a>';
											}
										$output .= '</p>';
									$output .= '</li>';
								}

							}

							if($attrs['contact_details'] == 'author') {

								$author = get_post($attrs['listing_id']);
								$author_id = $author->post_author;

								if($attrs['include_email'] == 'true') {
									$dtsl_email = get_the_author_meta( 'user_email' , $author_id );
									if($dtsl_email != '') {
										$output .= '<li><span class="fa fa-envelope"></span><a href="mailto:'.esc_attr($dtsl_email).'">'.esc_attr($dtsl_email).'</a></li>';
									}
								}

								if($attrs['include_phone'] == 'true') {
									$dtsl_phone = get_the_author_meta( 'dtsl_user_phone' , $author_id );
									if($dtsl_phone != '') {
										$output .= '<li><span class="fa fa-phone"></span><a href="tel:'.esc_attr($dtsl_phone).'" class="phone" data-listingid="'.esc_attr($attrs['listing_id']).'"  data-userid="'.esc_attr($user_id).'" target="_blank">'.esc_attr($dtsl_phone).'</a></li>';
									}
								}

								if($attrs['include_mobile'] == 'true') {
									$dtsl_mobile = get_the_author_meta( 'dtsl_user_mobile' , $author_id );
									if($dtsl_mobile != '') {
										$output .= '<li><span class="fa fa-mobile"></span><a href="tel:'.esc_attr($dtsl_mobile).'" class="mobile" data-listingid="'.esc_attr($attrs['listing_id']).'"  data-userid="'.esc_attr($user_id).'" target="_blank">'.esc_attr($dtsl_mobile).'</a></li>';
									}
								}

								if($attrs['include_skype'] == 'true') {
									$dtsl_skype = get_the_author_meta( 'dtsl_user_skype' , $author_id );
									if($dtsl_skype != '') {
										$output .= '<li><span class="fab fa-skype"></span>'.esc_attr($dtsl_skype).'</li>';
									}
								}

								if($attrs['include_website'] == 'true') {
									$dtsl_website = get_the_author_meta( 'dtsl_user_website' , $author_id );
									if($dtsl_website != '') {
										$output .= '<li><span class="fa fa-globe"></span><a href="'.esc_url($dtsl_website).'" class="web" data-listingid="'.esc_attr($attrs['listing_id']).'"  data-userid="'.esc_attr($user_id).'" target="_blank">'.esc_attr($dtsl_website).'</a></li>';
									}
								}

							} else if($attrs['contact_details'] == 'list') {

								if($attrs['include_email'] == 'true') {
									$dtsl_email = get_post_meta($attrs['listing_id'], 'dtsl_email', true);
									if($dtsl_email != '') {
										$output .= '<li><span class="fa fa-envelope"></span><a href="mailto:'.esc_attr($dtsl_email).'">'.esc_attr($dtsl_email).'</a></li>';
									}
								}

								if($attrs['include_phone'] == 'true') {
									$dtsl_phone = get_post_meta($attrs['listing_id'], 'dtsl_phone', true);
									if($dtsl_phone != '') {
										$output .= '<li><span class="fa fa-phone"></span><a href="tel:'.esc_attr($dtsl_phone).'" class="phone" data-listingid="'.esc_attr($attrs['listing_id']).'"  data-userid="'.esc_attr($user_id).'" target="_blank">'.esc_attr($dtsl_phone).'</a></li>';
									}
								}

								if($attrs['include_mobile'] == 'true') {
									$dtsl_mobile = get_post_meta($attrs['listing_id'], 'dtsl_mobile', true);
									if($dtsl_mobile != '') {
										$output .= '<li><span class="fa fa-mobile"></span><a href="tel:'.esc_attr($dtsl_mobile).'" class="mobile" data-listingid="'.esc_attr($attrs['listing_id']).'"  data-userid="'.esc_attr($user_id).'" target="_blank">'.esc_attr($dtsl_mobile).'</a></li>';
									}
								}

								if($attrs['include_skype'] == 'true') {
									$dtsl_skype = get_post_meta($attrs['listing_id'], 'dtsl_skype', true);
									if($dtsl_skype != '') {
										$output .= '<li><span class="fab fa-skype"></span>'.esc_attr($dtsl_skype).'</li>';
									}
								}

								if($attrs['include_website'] == 'true') {
									$dtsl_website = get_post_meta($attrs['listing_id'], 'dtsl_website', true);
									if($dtsl_website != '') {
										$output .= '<li><span class="fa fa-globe"></span><a href="'.esc_url($dtsl_website).'" class="web" data-listingid="'.esc_attr($attrs['listing_id']).'"  data-userid="'.esc_attr($user_id).'" target="_blank">'.esc_attr($dtsl_website).'</a></li>';
									}
								}

							}

						$output .= '</ul>';

					$output .= '</div>';

				}

			} else {

				$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );

				$output .= sprintf( esc_html__('Please provide %1$s id to display corresponding data!', 'dtsl'), strtolower($dt_sl_listing_singular_label) );

			}

			return $output;

		}

		function dtsl_sp_contact_details_request_btn( $attrs, $content = null ) {

			$attrs = shortcode_atts ( array (

						'listing_id' => '',
						'type' => '',
						'button_label' => '',
						'class' => '',

					), $attrs, 'dtsl_sp_contact_details_request_btn' );

			$output = '';

			if($attrs['listing_id'] == '' && is_singular('dtsl_listings')) {
				global $post;
				$attrs['listing_id'] = $post->ID;
			}

			if($attrs['listing_id'] != '') {

				$button_label_str = esc_html__('Send Request', 'dtsl');
				if(isset($attrs['button_label']) && $attrs['button_label'] != '') {
					$button_label_str = esc_html($attrs['button_label']);
				}

				$current_user = wp_get_current_user();
				$user_id = $current_user->ID;

				if($user_id > 0) {

					$dtsl_buyer_package_listings = get_user_meta($user_id, 'dtsl_buyer_package_listings', true);
					$dtsl_buyer_package_listings = (is_array($dtsl_buyer_package_listings) && !empty($dtsl_buyer_package_listings)) ? $dtsl_buyer_package_listings : array ();

					$dtsl_buyer_package_listings = array_unique($dtsl_buyer_package_listings);

					if(!in_array($attrs['listing_id'], $dtsl_buyer_package_listings)) {

						$output .= '<div class="dtsl-listings-contactdetails-request-container '.$attrs['type'].' '.$attrs['class'].'">';
							$output .= '<a class="dtsl-listings-contactdetails-request-button dtsl-listings-contactdetails-request" data-listingid="'.esc_attr($attrs['listing_id']).'" href="#">'.$button_label_str.'</a>';
						$output .= '</div>';

					}

				} else {

					$output .= '<div class="dtsl-listings-contactdetails-request-container '.$attrs['type'].' '.$attrs['class'].'">';
						$output .= '<a class="dtsl-listings-contactdetails-request-button dtsl-login-link" data-listingid="'.esc_attr($attrs['listing_id']).'" href="#">'.$button_label_str.'</a>';
					$output .= '</div>';

				}

			} else {

				$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );

				$output .= sprintf( esc_html__('Please provide %1$s id to display corresponding data!', 'dtsl'), strtolower($dt_sl_listing_singular_label) );

			}

			return $output;

		}

		function dtsl_sp_social_links( $attrs, $content = null ) {

			$attrs = shortcode_atts ( array (

						'listing_id' => '',
						'social_links' => 'list',
						'type' => '',
						'class' => '',

					), $attrs, 'dtsl_sp_social_links' );

			$output = '';

			if($attrs['listing_id'] == '' && is_singular('dtsl_listings')) {
				global $post;
				$attrs['listing_id'] = $post->ID;
			}

			if($attrs['listing_id'] != '') {

				$output .= '<div class="dtsl-listings-sociallinks-container '.$attrs['type'].' '.$attrs['class'].'">';

					$output .= '<ul class="dtsl-listings-sociallinks-list">';

						if($attrs['social_links'] == 'seller') {

							$author = get_post($attrs['listing_id']);
							$author_id = $author->post_author;

							$dtsl_social_items = get_the_author_meta('dtsl_user_social_items', $author_id);
							$dtsl_social_items = (isset($dtsl_social_items) && is_array($dtsl_social_items)) ? $dtsl_social_items : array ();

							$dtsl_social_items_value = get_the_author_meta('dtsl_user_social_items_value', $author_id);
							$dtsl_social_items_value = (isset($dtsl_social_items_value) && is_array($dtsl_social_items_value)) ? $dtsl_social_items_value : array ();

						} else {

							$dtsl_social_items = get_post_meta($attrs['listing_id'], 'dtsl_social_items', true);
							$dtsl_social_items = (isset($dtsl_social_items) && is_array($dtsl_social_items)) ? $dtsl_social_items : array ();

							$dtsl_social_items_value = get_post_meta($attrs['listing_id'], 'dtsl_social_items_value', true);
							$dtsl_social_items_value = (isset($dtsl_social_items_value) && is_array($dtsl_social_items_value)) ? $dtsl_social_items_value : array ();

						}


						$i = 0;
						if(is_array($dtsl_social_items) && !empty($dtsl_social_items)) {
							foreach($dtsl_social_items as $dtsl_social_item) {
								$output .= '<li><a href="'.esc_url($dtsl_social_items_value[$i]).'"><span class="fab '.esc_attr($dtsl_social_item).'"></span></a></li>';
								$i++;
							}
						}

					$output .= '</ul>';

				$output .= '</div>';

			} else {

				$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );

				$output .= sprintf( esc_html__('Please provide %1$s id to display corresponding data!', 'dtsl'), strtolower($dt_sl_listing_singular_label) );

			}

			return $output;

		}

		function dtsl_sp_comments( $attrs, $content = null ) {

			$attrs = shortcode_atts ( array (

						'class' => '',

					), $attrs, 'dtsl_sp_comments' );

			$output = '';

			ob_start();

				comments_template();
				$comment_list_template = ob_get_contents();

			ob_end_clean();

			$output .= '<div class="dtsl-listings-comment-list-holder '.$attrs['class'].'">';
				$output .= $comment_list_template;
			$output .= '</div>';

			return $output;

		}

		function dtsl_sp_utils( $attrs, $content = null ) {

			$attrs = shortcode_atts ( array (

						'listing_id'                    => '',
						'show_title'                    => '',
						'show_address'                  => '',
						'show_contactdetails'           => '',
						'show_contactdetails_onrequest' => '',
						'show_favourite'                => '',
						'show_pageview'                 => '',
						'show_print'                    => '',
						'show_socialshare'              => '',
						'show_averagerating'            => '',
						'show_featured'                 => '',
						'show_categories'               => '',
						'show_cities'                   => '',
						'show_neighborhoods'            => '',
						'show_countystate'              => '',
						'show_contracttype'             => '',
						'show_amenity'                  => '',
						'show_price'                    => '',
						'show_startdate'                => '',
						'show_enddate'                  => '',
						'show_posteddate'               => '',
						'show_mergeddates'              => '',
						'class'                         => '',

					), $attrs, 'dtsl_sp_utils' );

			$output = '';

			if($attrs['listing_id'] == '' && is_singular('dtsl_listings')) {
				global $post;
				$attrs['listing_id'] = $post->ID;
			}

			if($attrs['listing_id'] != '') {

				$output .= '<div class="dtsl-listings-utils-container '.$attrs['class'].'">';

					if($attrs['show_title'] == 'true') {

						$output .= '<div class="dtsl-listings-utils-item dtsl-listings-utils-title">';
							$output .= '<h3 class="dtsl-listings-utils-title-item"><a href="'.get_permalink($attrs['listing_id']).'">'.get_the_title($attrs['listing_id']).'</a></h3>';
						$output .= '</div>';

					}

					if($attrs['show_startdate'] == 'true' || $attrs['show_enddate'] == 'true' || $attrs['show_posteddate'] == 'true' || $attrs['show_mergeddates'] == 'true') {

						$include_startdate = '';
						if($attrs['show_startdate'] == 'true') {
							$include_startdate = 'true';
						}

						$include_enddate = '';
						if($attrs['show_enddate'] == 'true') {
							$include_enddate = 'true';
						}

						$include_postdate = '';
						if($attrs['show_posteddate'] == 'true') {
							$include_postdate = 'true';
						}

						$merge_dates = '';
						if($attrs['show_mergeddates'] == 'true') {
							$merge_dates = 'true';
						}

						$output .= '<div class="dtsl-listings-utils-item dtsl-listings-utils-dates">';
							$output .= do_shortcode('[dtsl_sp_event_dates listing_id="'.esc_attr($attrs['listing_id']).'" include_startdate="'.esc_attr($include_startdate).'" include_enddate="'.esc_attr($include_enddate).'" include_postdate="'.esc_attr($include_postdate).'" merge_dates="'.esc_attr($merge_dates).'" with_icon="true" type="" /]');
						$output .= '</div>';

					}

					if($attrs['show_address'] == 'true' || $attrs['show_contactdetails'] != '') {

						$include_address = '';
						if($attrs['show_address'] == 'true') {
							$include_address = 'true';
						}

						$include_phone = $include_mobile = '';
						if($attrs['show_contactdetails'] != '') {
							$include_phone = 'true';
							$include_mobile = 'true';
						}

						$requires_buyer_packages = '';
						if($attrs['show_contactdetails_onrequest'] == 'true') {
							$requires_buyer_packages = 'true';
						}

						$output .= '<div class="dtsl-listings-utils-item dtsl-listings-utils-contactdetails">';
							$output .= do_shortcode('[dtsl_sp_contact_details listing_id="'.esc_attr($attrs['listing_id']).'" contact_details="'.esc_attr($attrs['show_contactdetails']).'" include_address="'.esc_attr($include_address).'" include_phone="'.esc_attr($include_phone).'" include_mobile="'.esc_attr($include_mobile).'" requires_buyer_packages="'.esc_attr($requires_buyer_packages).'" /]');
						$output .= '</div>';

					}

					if($attrs['show_favourite'] == 'true') {

						$current_user = wp_get_current_user();
						$user_id = $current_user->ID;

						$favourite_items = get_user_meta($user_id, 'favourite_items', true);
						$favourite_items = (is_array($favourite_items) && !empty($favourite_items)) ? $favourite_items : array();

						$favourite_attr = 'data-listingid="'.$attrs['listing_id'].'"';
						if($user_id > 0) {
							if(in_array($attrs['listing_id'], $favourite_items)) {
								$favourite_class = 'removefavourite';
								$favourite_icon_class = 'fa fa-heart';
							} else {
								$favourite_class = 'addtofavourite';
								$favourite_icon_class = 'far fa-heart';
							}
							$favourite_attr .= ' data-userid="'.$user_id.'"';
						} else {
							$favourite_class = 'dtsl-login-link';
							$favourite_attr = '';
							$favourite_icon_class = 'far fa-heart';
						}

						$output .= '<div class="dtsl-listings-utils-item dtsl-listings-utils-favourite">';
							$output .= '<a class="dtsl-listings-utils-favourite-item '.$favourite_class.'" '.$favourite_attr.'><span class="'.$favourite_icon_class.'"></span></a>';
						$output .= '</div>';

					}

					if($attrs['show_pageview'] == 'true') {

						$total_views = get_post_meta($attrs['listing_id'], 'dtsl_total_views', true);
						$total_views = ($total_views != '') ? $total_views : 0;

						$output .= '<div class="dtsl-listings-utils-item dtsl-listings-utils-pageview">';
							$output .= '<a class="dtsl-listings-utils-pageview-item"><span class="fa fa-eye-slash"></span>'.esc_html($total_views).'</a>';
						$output .= '</div>';

					}

					if($attrs['show_print'] == 'true') {

						$output .= '<div class="dtsl-listings-utils-item dtsl-listings-utils-print">';
							$output .= '<a class="dtsl-listings-utils-print-item"><span class="fa fa-print"></span></a>';
						$output .= '</div>';

					}

					if($attrs['show_socialshare'] == 'true') {

						$output .= '<div class="dtsl-listings-utils-item dtsl-listings-utils-socialshare">';
							$output .= do_shortcode('[dtsl_sp_social_share listing_id="'.esc_attr($attrs['listing_id']).'" show_facebook="true" show_delicious="true" show_digg="true" show_stumbleupon="true" show_twitter="true" show_googleplus="true" show_linkedin="true" show_pinterest="true" show_whatsapp="true" /]');
						$output .= '</div>';

					}

					if($attrs['show_averagerating'] == 'true') {

						$output .= '<div class="dtsl-listings-utils-item dtsl-listings-utils-averagerating">';
							$output .= do_shortcode('[dtsl_sp_average_rating listing_id="'.esc_attr($attrs['listing_id']).'" display="both" type="" /]');
						$output .= '</div>';

					}

					if($attrs['show_featured'] == 'true') {

						$output .= '<div class="dtsl-listings-utils-item dtsl-listings-utils-featured-item">';
							$output .= do_shortcode('[dtsl_sp_featured_item listing_id="'.esc_attr($attrs['listing_id']).'" type="" /]');
						$output .= '</div>';

					}

					if($attrs['show_categories'] == 'true') {

						$output .= '<div class="dtsl-listings-utils-item dtsl-listings-utils-categories">';
							$output .= do_shortcode('[dtsl_sp_taxonomy listing_id="'.esc_attr($attrs['listing_id']).'" taxonomy="dtsl_listings_category" type="utils" /]');
						$output .= '</div>';

					}

					if($attrs['show_cities'] == 'true') {

						$output .= '<div class="dtsl-listings-utils-item dtsl-listings-utils-cities">';
							$output .= do_shortcode('[dtsl_sp_taxonomy listing_id="'.esc_attr($attrs['listing_id']).'" taxonomy="dtsl_listings_city" type="utils" /]');
						$output .= '</div>';

					}

					if($attrs['show_neighborhoods'] == 'true') {

						$output .= '<div class="dtsl-listings-utils-item dtsl-listings-utils-neighborhoods">';
							$output .= do_shortcode('[dtsl_sp_taxonomy listing_id="'.esc_attr($attrs['listing_id']).'" taxonomy="dtsl_listings_neighborhood" type="utils" /]');
						$output .= '</div>';

					}

					if($attrs['show_countystate'] == 'true') {

						$output .= '<div class="dtsl-listings-utils-item dtsl-listings-utils-countystate">';
							$output .= do_shortcode('[dtsl_sp_taxonomy listing_id="'.esc_attr($attrs['listing_id']).'" taxonomy="dtsl_listings_countystate" type="utils" /]');
						$output .= '</div>';

					}

					if($attrs['show_contracttype'] == 'true') {

						$output .= '<div class="dtsl-listings-utils-item dtsl-listings-utils-contracttype">';
							$output .= do_shortcode('[dtsl_sp_taxonomy listing_id="'.esc_attr($attrs['listing_id']).'" taxonomy="dtsl_listings_ctype" type="utils" /]');
						$output .= '</div>';

					}

					if($attrs['show_amenity'] == 'true') {

						$output .= '<div class="dtsl-listings-utils-item dtsl-listings-utils-contracttype">';
							$output .= do_shortcode('[dtsl_sp_taxonomy listing_id="'.esc_attr($attrs['listing_id']).'" taxonomy="dtsl_listings_amenity" type="utils" /]');
						$output .= '</div>';

					}

					if($attrs['show_price'] == 'true' && shortcode_exists('dtsl_sp_price')) {

						$output .= '<div class="dtsl-listings-utils-item dtsl-listings-utils-price">';
							$output .= do_shortcode('[dtsl_sp_price listing_id="'.esc_attr($attrs['listing_id']).'" type="" /]');
						$output .= '</div>';

					}

				$output .= '</div>';

			} else {

				$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );

				$output .= sprintf( esc_html__('Please provide %1$s id to display corresponding data!', 'dtsl'), strtolower($dt_sl_listing_singular_label) );

			}

			return $output;

		}

		function dtsl_sp_taxonomy( $attrs, $content = null ) {

			$attrs = shortcode_atts ( array (

						'listing_id' => '',
						'taxonomy'   => 'dtsl_listings_category',
						'type'       => '',
						'splice'     => '',
						'class'      => '',

					), $attrs, 'dtsl_sp_taxonomy' );

			$output = '';

			if($attrs['listing_id'] == '' && is_singular('dtsl_listings')) {
				global $post;
				$attrs['listing_id'] = $post->ID;
			}

			if($attrs['listing_id'] != '') {

				$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );

				$listing_taxonomies = wp_get_post_terms($attrs['listing_id'], $attrs['taxonomy'], array ('orderby' => 'parent'));
				if(isset($attrs['splice']) && $attrs['splice'] != '') {
					array_splice($listing_taxonomies, $attrs['splice']);
				}

				if(!empty($listing_taxonomies)) {

					$output .= '<div class="dtsl-listings-taxonomy-container '.$attrs['type'].' '.$attrs['class'].'">';

						$output .= '<ul class="dtsl-listings-taxonomy-list">';

							foreach($listing_taxonomies as $listing_taxonomy) {

								if(isset($listing_taxonomy->term_id)) {

									$icon_image_url   = get_term_meta($listing_taxonomy->term_id, 'dtsl-taxonomy-icon-image-url', true);
									$icon             = get_term_meta($listing_taxonomy->term_id, 'dtsl-taxonomy-icon', true);

									$icon_color       = get_term_meta($listing_taxonomy->term_id, 'dtsl-taxonomy-icon-color', true);
									$background_color = get_term_meta($listing_taxonomy->term_id, 'dtsl-taxonomy-background-color', true);
									$text_color       = get_term_meta($listing_taxonomy->term_id, 'dtsl-taxonomy-text-color', true);

									$tax_bg_color     = isset($background_color) ? 'style="background-color:'.$background_color.';"': '';
									$tax_text_color   = isset($text_color) ? 'style="color:'.$text_color.';"': '';
									$tax_icon_color   = isset($icon_color) ? 'style="color:'.$icon_color.';"': '';
									$tax_bg_text_color = '';
									if((isset($background_color) && !empty($background_color)) || (isset($text_color) && !empty($text_color))) {
										$tax_bg_text_color .= 'style="';
										if(isset($background_color) && !empty($background_color)) {
											$tax_bg_text_color .= 'background-color:'.$background_color.';';
										}
										if(isset($text_color) && !empty($text_color)) {
											$tax_bg_text_color .= 'color:'.$text_color.';';
										}
										$tax_bg_text_color .= '"';
									}

									if($attrs['type'] == 'type1') {

										$output .= '<li>';
											$output .= '<a href="'.get_term_link($listing_taxonomy->term_id).'" '.$tax_bg_color.'>';
												$output .= '<span>'.esc_html($listing_taxonomy->name).'</span>';
											$output .= '</a>';
										$output .= '</li>';

									} else if($attrs['type'] == 'type2') {

										$output .= '<li>';
											$output .= '<a href="'.get_term_link($listing_taxonomy->term_id).'" '.$tax_bg_color.'>';
												if($icon != '') {
													$output .= '<span class="'.$icon.'"></span>';
												}
												$output .= '<span>'.esc_html($listing_taxonomy->name).'</span>';
											$output .= '</a>';
										$output .= '</li>';

									} else if($attrs['type'] == 'type3') {

										$output .= '<li>';
											$output .= '<a href="'.get_term_link($listing_taxonomy->term_id).'">';
												if($icon_image_url != '') {
													$output .= '<span class="dtsl-listings-taxonomy-image" '.$tax_bg_color.'><img src="'.$icon_image_url.'" alt="'.sprintf( esc_html__('%1$s Taxonomy Image', 'dtsl'), $dt_sl_listing_singular_label ).'" title="'.sprintf( esc_html__('%1$s Taxonomy Image', 'dtsl'), $dt_sl_listing_singular_label ).'" /></span>';
												}
												$output .= '<span>'.esc_html($listing_taxonomy->name).'</span>';
											$output .= '</a>';
										$output .= '</li>';

									} else if($attrs['type'] == 'type4') {

										$output .= '<li>';
											$output .= '<a href="'.get_term_link($listing_taxonomy->term_id).'" '.$tax_bg_color.'>';
												if($icon != '') {
													$output .= '<span class="'.$icon.'"></span>';
												}
												$output .= '<span>'.esc_html($listing_taxonomy->name).'</span>';
											$output .= '</a>';
										$output .= '</li>';

									} else if($attrs['type'] == 'type5') {

										$output .= '<li>';
											$output .= '<a href="'.get_term_link($listing_taxonomy->term_id).'" '.$tax_bg_color.'>';
												if($icon != '') {
													$output .= '<span class="'.$icon.'"></span>';
												}
												$output .= '<span>'.esc_html($listing_taxonomy->name).'</span>';
											$output .= '</a>';
										$output .= '</li>';

									} else if($attrs['type'] == 'type6') {

										$output .= '<li>';
											$output .= '<a href="'.get_term_link($listing_taxonomy->term_id).'">';
												$output .= '<span '.$tax_text_color.'>'.esc_html($listing_taxonomy->name).'</span>';
											$output .= '</a>';
										$output .= '</li>';

									} else if($attrs['type'] == 'type7') {

										$output .= '<li>';
											$output .= '<a href="'.get_term_link($listing_taxonomy->term_id).'" '.$tax_bg_color.'>';
												$output .= '<span>'.esc_html($listing_taxonomy->name).'</span>';
											$output .= '</a>';
										$output .= '</li>';

									} else if($attrs['type'] == 'type8') {

										$output .= '<li>';
											$output .= '<a href="'.get_term_link($listing_taxonomy->term_id).'" '.$tax_bg_color.'>';
												$output .= '<span>'.esc_html($listing_taxonomy->name).'</span>';
											$output .= '</a>';
										$output .= '</li>';

									} else if($attrs['type'] == 'utils') {

										$output .= '<li>';
											$output .= '<a href="'.get_term_link($listing_taxonomy->term_id).'">';
												if($icon != '') {
													$output .= '<span class="'.$icon.'"></span>';
												}
												$output .= '<span class="dtsl-listings-taxonomy-name">'.esc_html($listing_taxonomy->name).'</span>';
											$output .= '</a>';
										$output .= '</li>';

									}

								}

							}

						$output .= '</ul>';

					$output .= '</div>';

				}

			} else {

				$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );

				$output .= sprintf( esc_html__('Please provide %1$s id to display corresponding data!', 'dtsl'), strtolower($dt_sl_listing_singular_label) );

			}

			return $output;

		}

		function dtsl_sp_contact_form( $attrs, $content = null ) {

			$attrs = shortcode_atts ( array (

						'listing_id' => '',
						'textarea_placeholder' => '',
						'submit_label' => '',
						'contact_point' => '',
						'include_admin' => '',
						'class' => '',

					), $attrs, 'dtsl_sp_contact_form' );

			$output = '';

			if($attrs['listing_id'] == '' && is_singular('dtsl_listings')) {
				global $post;
				$attrs['listing_id'] = $post->ID;
			}

			if($attrs['listing_id'] != '') {

				$output .= '<div class="dtsl-listings-contactform-container '.$attrs['class'].'">';

					$output .= '<form method="post" class="dtsl-listings-contactform" name="dtsl-listings-contactform">';

						$current_user = wp_get_current_user();
						$user_id = $current_user->ID;

						if(!is_user_logged_in()) {

							$output .= '<div class="dtsl-column dtsl-one-column first">
											<input class="dtsl-contactform-name" name="dtsl_contactform_name" type="text" placeholder="'.esc_html__('Name', 'dtsl').'" required />
											<span></span>
										</div>';

							$output .= '<div class="dtsl-listings-contactform-item">';

								$output .= '<div class="dtsl-column dtsl-one-column first">
												<input class="dtsl-contactform-email" name="dtsl_contactform_email" type="text" placeholder="'.esc_html__('Email', 'dtsl').'" required />
												<span></span>
											</div>';

								$output .= '<div class="dtsl-column dtsl-one-column first">
												<input class="dtsl-contactform-phone" name="dtsl_contactform_phone" type="text" placeholder="'.esc_html__('Phone', 'dtsl').'" required />
												<span></span>
											</div>';

							$output .= '</div>';

						}

						if($attrs['textarea_placeholder'] != '') {
							$listing_title = get_the_title($attrs['listing_id']);
							$textarea_placeholder = str_replace('{{title}}', $listing_title, $attrs['textarea_placeholder']);
						} else {
							$textarea_placeholder = esc_html__('Message', 'dtsl');
						}

						if($attrs['submit_label'] != '') {
							$submit_label = $attrs['submit_label'];
						} else {
							$submit_label = esc_html__('Submit', 'dtsl');
						}

						$output .= '<div class="dtsl-column dtsl-one-column first">
										<textarea class="dtsl-contactform-message" name="dtsl_contactform_message" rows="5" placeholder="'.esc_attr($textarea_placeholder).'"></textarea>
										<span></span>
									</div>';

						$output .= '<input class="dtsl-contactform-listingid" name="dtsl_contactform_listingid" type="hidden" value="'.esc_attr($attrs['listing_id']).'" />';
						$output .= '<input class="dtsl-contactform-userid" name="dtsl_contactform_userid" type="hidden" value="'.esc_attr($user_id).'" />';
						$output .= '<input class="dtsl-contactform-contactpoint" name="dtsl_contactform_contactpoint" type="hidden" value="'.esc_attr($attrs['contact_point']).'" />';
						$output .= '<input class="dtsl-contactform-includeadmin" name="dtsl_contactform_includeadmin" type="hidden" value="'.esc_attr($attrs['include_admin']).'" />';
						$output .= '<input class="dtsl-contactform-nonce" name="dtsl_contactform_nonce" type="hidden" value="'.wp_create_nonce('contact_listing_'.$attrs['listing_id']).'" />';

						$output .= '<div class="dtsl-contactform-notification-box"></div>';

						$output .= '<a class="dtsl-contactform-submit-button">'.esc_html__($submit_label).'</a>';

					$output .= '</form>';

				$output .= '</div>';

			} else {

				$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );

				$output .= sprintf( esc_html__('Please provide %1$s id to display corresponding data!', 'dtsl'), strtolower($dt_sl_listing_singular_label) );

			}

			return $output;

		}

		function dtsl_sp_post_date( $attrs, $content = null ) {

			$attrs = shortcode_atts ( array (

						'listing_id'       => '',
						'type'             => 'type1',
						'include_posttime' => '',
						'with_label'       => '',
						'with_icon'        => '',
						'class'            => ''

					), $attrs, 'dtsl_sp_post_date' );

			$output = '';

			if($attrs['listing_id'] == '' && is_singular('dtsl_listings')) {
				global $post;
				$attrs['listing_id'] = $post->ID;
			}

			if($attrs['listing_id'] != '') {

				if($attrs['type'] == 'listing') {
					$attrs['type'] = '';
				}

				$output .= '<div class="dtsl-listings-post-dates-container '.$attrs['type'].' '.$attrs['class'].'">';

					$dtsl_post_date = get_the_date( get_option('date_format'), $attrs['listing_id'] );

					if($dtsl_post_date != '') {

						$output .= '<div class="dtsl-listings-post-date-container">';

							if($attrs['with_icon'] == 'true') {
								$output .= '<span class="dtsl-listings-post-date-icon"></span>';
							}

							if($attrs['with_label'] == 'true') {
								$output .= '<label class="dtsl-listings-post-date-label">'.esc_html__('Posted On: ', 'dtsl').'</label>';
							}

							$output .= '<div class="dtsl-listings-post-datetime-holder">';

								$output .= '<div class="dtsl-listings-post-date-holder">';
									$output .= $dtsl_post_date;
								$output .= '</div>';

								if($attrs['include_posttime'] == 'true') {

									$output .= '<div class="dtsl-listings-post-time-holder">';

										$dtsl_24_hour_format = get_post_meta($attrs['listing_id'], 'dtsl_24_hour_format', true);

										if($dtsl_24_hour_format == 'true') {
											$output .= get_the_time( 'G:i', $attrs['listing_id'] );
										} else {
											$output .= get_the_time( 'g:i A', $attrs['listing_id'] );
										}

									$output .= '</div>';

								}

							$output .= '</div>';

						$output .= '</div>';
					}

				$output .= '</div>';

			} else {

				$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );

				$output .= sprintf( esc_html__('Please provide %1$s id to display corresponding data!', 'dtsl'), strtolower($dt_sl_listing_singular_label) );

			}

			return $output;

		}

		function dtsl_sp_mls_number( $attrs, $content = null ) {

			$attrs = shortcode_atts ( array (

						'listing_id' => '',
						'type'       => 'type1',
						'with_label' => '',
						'class'      => '',

					), $attrs, 'dtsl_sp_mls_number' );

			$output = '';

			if($attrs['listing_id'] == '' && is_singular('dtsl_listings')) {
				global $post;
				$attrs['listing_id'] = $post->ID;
			}

			if($attrs['listing_id'] != '') {

				$dtsl_mls_number = get_post_meta($attrs['listing_id'], 'dtsl_mls_number', true);
				if($dtsl_mls_number != '') {

					if($attrs['type'] == 'listing') {
						$attrs['type'] = '';
					}

					$output .= '<div class="dtsl-listings-mls-number-container '.$attrs['type'].' '.$attrs['class'].'">';
						if($attrs['with_label'] == 'true') {
							$output .= '<label class="dtsl-listings-mls-number-label">'.esc_html__('MLS Number: ', 'dtsl').'</label>';
						}
						$output .= '<span>'.esc_html($dtsl_mls_number).'</span>';
					$output .= '</div>';

				}

			} else {

				$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );

				$output .= sprintf( esc_html__('Please provide %1$s id to display corresponding data!', 'dtsl'), strtolower($dt_sl_listing_singular_label) );

			}

			return $output;

		}

		function dtsl_sp_content( $attrs, $content = null ) {

			$attrs = shortcode_atts ( array (

						'listing_id' => '',
						'type'       => 'excerpt',
						'class'      => '',

					), $attrs, 'dtsl_sp_content' );

			$output = '';

			if($attrs['listing_id'] == '' && is_singular('dtsl_listings')) {
				global $post;
				$attrs['listing_id'] = $post->ID;
			}

			if($attrs['listing_id'] != '') {

				if($attrs['type'] == 'content') {
					$data = get_post_field('post_content', $attrs['listing_id']);
				} else {
					$data = dtsl_custom_excerpt(40, $attrs['listing_id']);
				}

				$output .= '<div class="dtsl-listings-content-container '.$attrs['class'].'">';
					$output .= do_shortcode($data);
				$output .= '</div>';

			} else {

				$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );

				$output .= sprintf( esc_html__('Please provide %1$s id to display corresponding data!', 'dtsl'), strtolower($dt_sl_listing_singular_label) );

			}

			return $output;

		}

	}

	DTStoreLocatorSinglePageShortcodes::instance();

}

?>