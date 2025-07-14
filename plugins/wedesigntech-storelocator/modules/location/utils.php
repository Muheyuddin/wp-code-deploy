<?php

// Update map based on filter

if( !function_exists('dtsl_generate_load_search_map_ouput') ) {
  function dtsl_generate_load_search_map_ouput() {

    $mapdata_complete = array ();

    $output = '';

    $type = (isset($_REQUEST['type']) && $_REQUEST['type'] != '') ? dtsl_recursive_sanitize_text_field($_REQUEST['type']) : 'type1';

    $zoom_level = isset($_REQUEST['zoom_level']) ? dtsl_recursive_sanitize_text_field($_REQUEST['zoom_level']) : dtsl_option('map','default-zoom-level');
    $map_type = isset($_REQUEST['map_type']) ? dtsl_recursive_sanitize_text_field($_REQUEST['map_type']) : dtsl_option('map', 'default-map-type');
    $map_color = isset($_REQUEST['map_color']) ? dtsl_recursive_sanitize_text_field($_REQUEST['map_color']) : dtsl_option('map', 'default-map-color');

    $user_latitude = isset($_REQUEST['user_latitude']) ? dtsl_recursive_sanitize_text_field($_REQUEST['user_latitude']) : '';
    $user_longitude = isset($_REQUEST['user_longitude']) ? dtsl_recursive_sanitize_text_field($_REQUEST['user_longitude']) : '';
    $radius_unit = dtsl_recursive_sanitize_text_field($_REQUEST['radius_unit']);

    $itemids = dtsl_recursive_sanitize_text_field($_REQUEST['itemids']);
    $additional_info = dtsl_recursive_sanitize_text_field($_REQUEST['additional_info']);
    $category_background_color = dtsl_recursive_sanitize_text_field($_REQUEST['category_background_color']);
    $category_color = dtsl_recursive_sanitize_text_field($_REQUEST['category_color']);

    $mapdefaults[0]['zoom_level'] = $zoom_level;
    $mapdefaults[0]['map_type'] = $map_type;
    $mapdefaults[0]['map_color'] = $map_color;

    if(empty($itemids)) {

      if($user_latitude != '' && $user_longitude != '') {
        $mapdefaults[0]['latitude'] = $user_latitude;
        $mapdefaults[0]['longitude'] = $user_longitude;
        $mapdefaults[0]['image'] = DTSL_LOCATION_PLUGIN_URL.'assets/images/user.png';
        $mapdefaults[0]['origin'] = 'user';
      } else {
        $mapdefaults[0]['latitude'] = dtsl_option('map','default-latitude');
        $mapdefaults[0]['longitude'] = dtsl_option('map','default-longitude');
        $mapdefaults[0]['origin'] = 'default';
      }

        echo json_encode(array(
          'mapdefaults' => $mapdefaults,
          'mapdata' => $mapdata_complete,
        ));

      die();

    }

    if(is_array($itemids) && !empty($itemids)) {

      foreach($itemids as $listing_id) {

        $dtsl_latitude = get_post_meta($listing_id, 'dtsl_latitude', true);
        $dtsl_longitude = get_post_meta($listing_id, 'dtsl_longitude', true);

        if($dtsl_latitude != '' && $dtsl_longitude != '') {

          $dtsl_map_image = get_post_meta($listing_id, 'dtsl_map_image', true);
          $image_url = wp_get_attachment_image_src($dtsl_map_image, 'thumbnail');
          $map_image = (isset($image_url[0]) && !empty($image_url[0])) ? $image_url[0] : DTSL_LOCATION_PLUGIN_URL.'assets/images/marker.png';

          $total_views = get_post_meta($listing_id, 'dtsl_total_views', true);

          $average_ratings = get_post_meta($listing_id, 'dtsl_average_ratings', true);

          $mapdata = array ();

          $mapdata[$listing_id]['listingid'] = $listing_id;
          $mapdata[$listing_id]['latitude'] = $dtsl_latitude;
          $mapdata[$listing_id]['longitude'] = $dtsl_longitude;
          $mapdata[$listing_id]['image'] = $map_image;

          if($additional_info == 'totalviews') {
            $mapdata[$listing_id]['additionalinfotype'] = 'totalviews';
            $mapdata[$listing_id]['additionalinfo'] = $total_views;
          }

          if($additional_info == 'averageratings') {
            $mapdata[$listing_id]['additionalinfotype'] = 'averageratings';
            $mapdata[$listing_id]['additionalinfo'] = $average_ratings;
          }

          if($additional_info == 'categoryimage') {

            $listing_terms = get_the_terms($listing_id, 'dtsl_listings_category');
            if(is_array($listing_terms) && !empty($listing_terms)) {
              foreach ( $listing_terms as $listing_term ) {
                if( $listing_term->parent == 0 ) {
                  $listing_term_id = $listing_term->term_id;
                  break;
                } else {
                  $listing_term_id = $listing_term->term_id;
                }
              }
            }

            $image_url = get_term_meta( $listing_term_id, 'dtsl-taxonomy-map-image-url', true );

            $mapdata[$listing_id]['additionalinfotype'] = 'categoryimage';
            $mapdata[$listing_id]['additionalinfo'] = $image_url;

            if((isset($category_background_color) && $category_background_color!= '') && (isset($category_color) && $category_color!= '')) {

              $mapdata[$listing_id]['categorybackgroundcolor'] = $category_background_color;
              $mapdata[$listing_id]['categorycolor'] = $category_color;

            } else if(isset($category_background_color) && $category_background_color!= '') {

              $icon_color = get_term_meta($listing_term_id, 'dtsl-taxonomy-icon-color', true);

              $mapdata[$listing_id]['categorybackgroundcolor'] = $category_background_color;
              $mapdata[$listing_id]['categorycolor'] = $icon_color;

            } else if(isset($category_color) && $category_color!= '') {

              $background_color = get_term_meta($listing_term_id, 'dtsl-taxonomy-background-color', true);

              $mapdata[$listing_id]['categorybackgroundcolor'] = $background_color;
              $mapdata[$listing_id]['categorycolor'] = $category_color;

            } else {

              $background_color = get_term_meta($listing_term_id, 'dtsl-taxonomy-background-color', true);
              $icon_color = get_term_meta($listing_term_id, 'dtsl-taxonomy-icon-color', true);

              $mapdata[$listing_id]['categorybackgroundcolor'] = $background_color;
              $mapdata[$listing_id]['categorycolor'] = $icon_color;

            }

          }

          if($additional_info == 'categoryicon') {

            $listing_terms = get_the_terms($listing_id, 'dtsl_listings_category');

            if(is_array($listing_terms) && !empty($listing_terms)) {
              foreach ( $listing_terms as $listing_term ) {
                if( $listing_term->parent == 0 ) {
                  $listing_term_id = $listing_term->term_id;
                  break;
                } else {
                  $listing_term_id = $listing_term->term_id;
                }
              }
            }

            $icon = get_term_meta($listing_term_id, 'dtsl-taxonomy-icon', true);

            $mapdata[$listing_id]['additionalinfotype'] = 'categoryicon';
            $mapdata[$listing_id]['additionalinfo'] = $icon;

            if((isset($category_background_color) && $category_background_color!= '') && (isset($category_color) && $category_color!= '')) {

              $mapdata[$listing_id]['categorybackgroundcolor'] = $category_background_color;
              $mapdata[$listing_id]['categorycolor'] = $category_color;

            } else if(isset($category_background_color) && $category_background_color!= '') {

              $icon_color = get_term_meta($listing_term_id, 'dtsl-taxonomy-icon-color', true);

              $mapdata[$listing_id]['categorybackgroundcolor'] = $category_background_color;
              $mapdata[$listing_id]['categorycolor'] = $icon_color;

            } else if(isset($category_color) && $category_color!= '') {

              $background_color = get_term_meta($listing_term_id, 'dtsl-taxonomy-background-color', true);

              $mapdata[$listing_id]['categorybackgroundcolor'] = $background_color;
              $mapdata[$listing_id]['categorycolor'] = $category_color;

            } else {

              $background_color = get_term_meta($listing_term_id, 'dtsl-taxonomy-background-color', true);
              $icon_color = get_term_meta($listing_term_id, 'dtsl-taxonomy-icon-color', true);

              $mapdata[$listing_id]['categorybackgroundcolor'] = $background_color;
              $mapdata[$listing_id]['categorycolor'] = $icon_color;

            }

          }

          if($additional_info == 'distance') {

            $dtsl_latitude = get_post_meta($listing_id, 'dtsl_latitude', true);
            $dtsl_longitude = get_post_meta($listing_id, 'dtsl_longitude', true);

            $mapdata[$listing_id]['additionalinfotype'] = 'distance';

            $radius_calculated = 0;
            if($user_latitude != '' && $user_longitude != '') {
              $radius_calculated = dtsl_calculate_distance_between_location($user_latitude, $user_longitude, $dtsl_latitude, $dtsl_longitude, $radius_unit);
              $mapdata[$listing_id]['additionalinfo'] = $radius_calculated.' '.$radius_unit;
            } else {
              $mapdata[$listing_id]['additionalinfo'] = '';
            }

          }

          // Map Info Popup Content

          $listing_title = get_the_title($listing_id);
          $listing_permalink = get_permalink($listing_id);

          $data_listing_attributes = array ();
          $data_listing_attributes['listing_id'] = $listing_id;
          $data_listing_attributes['listing_title'] = $listing_title;
          $data_listing_attributes['listing_permalink'] = $listing_permalink;
          $data_listing_attributes['type'] = $type;

          $mapdata[$listing_id]['infocontent'] = dtsl_generate_listing_map_item_html($data_listing_attributes);


          // Final array

          $mapdata_complete = array_merge($mapdata_complete, $mapdata);

        }


      }

    }

    if($user_latitude != '' && $user_longitude != '') {
      $mapdefaults[0]['latitude'] = $user_latitude;
      $mapdefaults[0]['longitude'] = $user_longitude;
      $mapdefaults[0]['image'] = DTSL_LOCATION_PLUGIN_URL.'assets/images/user.png';
      $mapdefaults[0]['origin'] = 'user';
    } else {
      $mapdefaults[0]['latitude'] = $mapdata_complete[0]['latitude'];
      $mapdefaults[0]['longitude'] = $mapdata_complete[0]['longitude'];
      $mapdefaults[0]['infocontent'] = $mapdata_complete[0]['infocontent'];
      $mapdefaults[0]['origin'] = 'default';
    }


      echo json_encode(array(
          'mapdefaults' => $mapdefaults,
          'mapdata' => $mapdata_complete,
      ));

    die();

  }
  add_action( 'wp_ajax_dtsl_generate_load_search_map_ouput', 'dtsl_generate_load_search_map_ouput' );
  add_action( 'wp_ajax_nopriv_dtsl_generate_load_search_map_ouput', 'dtsl_generate_load_search_map_ouput' );
}

// Frontend Listing Map - Generate Html

if( !function_exists('dtsl_generate_listing_map_item_html') ) {
  function dtsl_generate_listing_map_item_html($data_listing_attributes) {

    $output = '';

    extract($data_listing_attributes);

    $item_classes = array ('dtsl-listings-map-item-wrapper');
    array_push($item_classes, $type);


    if($type == 'type1') {

      $output .= '<div class="'.implode(' ', get_post_class($item_classes, $listing_id)).'">';

        $output .= '<div class="dtsl-listings-item-top-section">';

          $output .= '<div class="dtsl-listings-item-image-gallery">';
            $output .= do_shortcode('[dtsl_sp_featured_image listing_id="'.esc_attr($listing_id).'" image_size="full" /]');
          $output .= '</div>';

          $output .= '<a class="custom-button-style dtsl-listing-view-details" href="'.get_permalink($listing_id).'">'.esc_html__('View Details', 'dtsl').'</a>';

        $output .= '</div>';

        $output .= '<div class="dtsl-listings-item-bottom-section">';

          $output .= '<div class="dtsl-listings-item-bottom-section-content">';

            $output .= '<div class="dtsl-listings-item-title">';
              $output .= '<a href="'.get_permalink($listing_id).'">'.get_the_title($listing_id).'</a>';
            $output .= '</div>';

            $output .= do_shortcode('[dtsl_sp_contact_details listing_id="'.esc_attr($listing_id).'" include_address="true" include_email="true" include_phone="true" include_mobile="true" include_skype="true" include_website="true" type="listing" /]');

          $output .= '</div>';

        $output .= '</div>';

      $output .= '</div>';

    } else if($type == 'type2') {

      $output .= '<div class="'.implode(' ', get_post_class($item_classes, $listing_id)).'">';

        $output .= '<div class="dtsl-listings-item-top-section">';

          $output .= '<div class="dtsl-listings-item-image-gallery">';
            $output .= do_shortcode('[dtsl_sp_featured_image listing_id="'.esc_attr($listing_id).'" image_size="full" /]');
          $output .= '</div>';

        $output .= '</div>';

        $output .= '<div class="dtsl-listings-item-bottom-section">';

          $output .= '<div class="dtsl-listings-utils-item-holder">';
            $output .= dtsl_favourite_marker_html($listing_id);
            $output .= '<div class="dtsl-listings-utils-item dtsl-listings-utils-totalimages">';
              $output .= '<div class="dtsl-listings-utils-totalimages-item"><span class="far fa-images"></span><p>'.esc_html($total_images_cnt).'</p></div>';
            $output .= '</div>';
          $output .= '</div>';

          $output .= '<div class="dtsl-listings-item-title">';
            $output .= '<a href="'.get_permalink($listing_id).'">'.get_the_title($listing_id).'</a>';
          $output .= '</div>';

          if(shortcode_exists('dtsl_sp_price')) {
            $output .= do_shortcode('[dtsl_sp_price listing_id="'.esc_attr($listing_id).'" /]');
          }

        $output .= '</div>';

      $output .= '</div>';

    } else if($type == 'type3') {

      $output .= '<div class="'.implode(' ', get_post_class($item_classes, $listing_id)).'">';

        $output .= '<div class="dtsl-listings-item-top-section">';

          $output .= '<div class="dtsl-listings-item-image-gallery">';
            $output .= do_shortcode('[dtsl_sp_featured_image listing_id="'.esc_attr($listing_id).'" image_size="full" /]');
          $output .= '</div>';

          if(shortcode_exists('dtsl_sp_price')) {
            $output .= do_shortcode('[dtsl_sp_price listing_id="'.esc_attr($listing_id).'" /]');
          }

        $output .= '</div>';

        $output .= '<div class="dtsl-listings-item-bottom-section">';

          $output .= '<div class="dtsl-listings-item-title">';
            $output .= '<a href="'.get_permalink($listing_id).'">'.get_the_title($listing_id).'</a>';
          $output .= '</div>';

          $output .= do_shortcode('[dtsl_sp_contact_details listing_id="'.esc_attr($listing_id).'" include_address="true" include_email="true" include_phone="true" include_mobile="true" include_skype="true" include_website="true" type="listing" /]');

        $output .= '</div>';

      $output .= '</div>';

    } else if($type == 'type4') {

      $output .= '<div class="'.implode(' ', get_post_class($item_classes, $listing_id)).'">';

        $output .= '<div class="dtsl-listings-item-top-section">';

          $output .= '<div class="dtsl-listings-item-title">';
            $output .= '<a href="'.get_permalink($listing_id).'">'.get_the_title($listing_id).'</a>';
          $output .= '</div>';

        $output .= '</div>';

        $output .= '<div class="dtsl-listings-item-bottom-section">';

          $output .= '<div class="dtsl-listings-item-bottom-section-content">';

            if($custom_excerpt != '') {
              $output .= '<div class="dtsl-listings-excerpt">';
                $output .= '<p>';
                  if( get_post_meta($listing_id, 'dtsl_excerpt_title', true) != '' ) {
                    $output .= '<span>'.get_post_meta($listing_id, 'dtsl_excerpt_title', true).'</span>';
                  }
                  $output .= $custom_excerpt;
                $output .= '</p>';
              $output .= '</div>';
            }

            $output .= do_shortcode('[dtsl_sp_contact_details listing_id="'.esc_attr($listing_id).'" include_address="true" include_email="true" include_phone="true" include_mobile="true" include_skype="true" include_website="true" type="listing" /]');

            $output .= '<a class="custom-button-style dtsl-listing-view-details" href="'.get_permalink($listing_id).'">'.esc_html__('View Details', 'dtsl').'</a>';

          $output .= '</div>';

        $output .= '</div>';

      $output .= '</div>';

    } else if($type == 'type5') {

      $output .= '<div class="'.implode(' ', get_post_class($item_classes, $listing_id)).'">';

        $output .= '<div class="dtsl-listings-item-top-section">';

          $output .= '<div class="dtsl-listings-item-title">';
            $output .= '<a href="'.get_permalink($listing_id).'">'.get_the_title($listing_id).'</a>';
          $output .= '</div>';

        $output .= '</div>';

        $output .= '<div class="dtsl-listings-item-bottom-section">';

          $output .= '<div class="dtsl-listings-item-bottom-section-content">';

            if($custom_excerpt != '') {
              $output .= '<div class="dtsl-listings-excerpt">';
                $output .= '<p>';
                  if( get_post_meta($listing_id, 'dtsl_excerpt_title', true) != '' ) {
                    $output .= '<span>'.get_post_meta($listing_id, 'dtsl_excerpt_title', true).'</span>';
                  }
                  $output .= $custom_excerpt;
                $output .= '</p>';
              $output .= '</div>';
            }

            $output .= do_shortcode('[dtsl_sp_contact_details listing_id="'.esc_attr($listing_id).'" include_address="true" include_email="true" include_phone="true" include_mobile="true" include_skype="true" include_website="true" type="listing" /]');

          $output .= '</div>';

        $output .= '</div>';

        $output .= '<a class="custom-button-style dtsl-listing-view-details" href="'.get_permalink($listing_id).'">'.esc_html__('View Details', 'dtsl').'</a>';

      $output .= '</div>';

    }

    return $output;

  }
}

// Calculate distance between location

if( !function_exists('dtsl_calculate_distance_between_location') ) {
  function dtsl_calculate_distance_between_location($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $unit) {

    $googlemap_api_key = dtsl_option('map', 'googlemap-api-key');

    $url = 'https://maps.googleapis.com/maps/api/distancematrix/json?origins='.$latitudeFrom.','.$longitudeFrom.'&destinations='.$latitudeTo.",".$longitudeTo.'&mode=driving&units=metric&key='.$googlemap_api_key;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch);
    curl_close($ch);
    $response_a = json_decode($response, true);

    if(isset($response_a['rows'][0]['elements'][0]['distance']['value'])) {

      $distance = $response_a['rows'][0]['elements'][0]['distance']['value'];

      if ($unit == 'km') {
        $finaldistance = ($distance/1000);
        $finaldistance = round($finaldistance, 0);
        return $finaldistance;
      } else if ($unit == 'mi') {
        $finaldistance = ($distance * 0.00062137);
        $finaldistance = round($finaldistance, 0);
        return $finaldistance;
      } else {
        return $distance;
      }

    } else {
      return -1;
    }

  }
}

if( !function_exists('dtsl_countries_list') ) {
    function dtsl_countries_list($with_none = false) {

      $Countries = array (
            'US' => esc_html__('United States', 'dtsl'),
            'CA' => esc_html__('Canada', 'dtsl'),
            'AU' => esc_html__('Australia', 'dtsl'),
            'FR' => esc_html__('France', 'dtsl'),
            'DE' => esc_html__('Germany', 'dtsl'),
            'IS' => esc_html__('Iceland', 'dtsl'),
            'IE' => esc_html__('Ireland', 'dtsl'),
            'IT' => esc_html__('Italy', 'dtsl'),
            'ES' => esc_html__('Spain', 'dtsl'),
            'SE' => esc_html__('Sweden', 'dtsl'),
            'AT' => esc_html__('Austria', 'dtsl'),
            'BE' => esc_html__('Belgium', 'dtsl'),
            'FI' => esc_html__('Finland', 'dtsl'),
            'CZ' => esc_html__('Czech Republic', 'dtsl'),
            'DK' => esc_html__('Denmark', 'dtsl'),
            'NO' => esc_html__('Norway', 'dtsl'),
            'GB' => esc_html__('United Kingdom', 'dtsl'),
            'CH' => esc_html__('Switzerland', 'dtsl'),
            'NZ' => esc_html__('New Zealand', 'dtsl'),
            'RU' => esc_html__('Russian Federation', 'dtsl'),
            'PT' => esc_html__('Portugal', 'dtsl'),
            'NL' => esc_html__('Netherlands', 'dtsl'),
            'IM' => esc_html__('Isle of Man', 'dtsl'),
            'AF' => esc_html__('Afghanistan', 'dtsl'),
            'AX' => esc_html__('Aland Islands ', 'dtsl'),
            'AL' => esc_html__('Albania', 'dtsl'),
            'DZ' => esc_html__('Algeria', 'dtsl'),
            'AS' => esc_html__('American Samoa', 'dtsl'),
            'AD' => esc_html__('Andorra', 'dtsl'),
            'AO' => esc_html__('Angola', 'dtsl'),
            'AI' => esc_html__('Anguilla', 'dtsl'),
            'AQ' => esc_html__('Antarctica', 'dtsl'),
            'AG' => esc_html__('Antigua and Barbuda', 'dtsl'),
            'AR' => esc_html__('Argentina', 'dtsl'),
            'AM' => esc_html__('Armenia', 'dtsl'),
            'AW' => esc_html__('Aruba', 'dtsl'),
            'AZ' => esc_html__('Azerbaijan', 'dtsl'),
            'BS' => esc_html__('Bahamas', 'dtsl'),
            'BH' => esc_html__('Bahrain', 'dtsl'),
            'BD' => esc_html__('Bangladesh', 'dtsl'),
            'BB' => esc_html__('Barbados', 'dtsl'),
            'BY' => esc_html__('Belarus', 'dtsl'),
            'BZ' => esc_html__('Belize', 'dtsl'),
            'BJ' => esc_html__('Benin', 'dtsl'),
            'BM' => esc_html__('Bermuda', 'dtsl'),
            'BT' => esc_html__('Bhutan', 'dtsl'),
            'BO' => esc_html__('Bolivia, Plurinational State of', 'dtsl'),
            'BQ' => esc_html__('Bonaire, Sint Eustatius and Saba', 'dtsl'),
            'BA' => esc_html__('Bosnia and Herzegovina', 'dtsl'),
            'BW' => esc_html__('Botswana', 'dtsl'),
            'BV' => esc_html__('Bouvet Island', 'dtsl'),
            'BR' => esc_html__('Brazil', 'dtsl'),
            'IO' => esc_html__('British Indian Ocean Territory', 'dtsl'),
            'BN' => esc_html__('Brunei Darussalam', 'dtsl'),
            'BG' => esc_html__('Bulgaria', 'dtsl'),
            'BF' => esc_html__('Burkina Faso', 'dtsl'),
            'BI' => esc_html__('Burundi', 'dtsl'),
            'KH' => esc_html__('Cambodia', 'dtsl'),
            'CM' => esc_html__('Cameroon', 'dtsl'),
            'CV' => esc_html__('Cape Verde', 'dtsl'),
            'KY' => esc_html__('Cayman Islands', 'dtsl'),
            'CF' => esc_html__('Central African Republic', 'dtsl'),
            'TD' => esc_html__('Chad', 'dtsl'),
            'CL' => esc_html__('Chile', 'dtsl'),
            'CN' => esc_html__('China', 'dtsl'),
            'CX' => esc_html__('Christmas Island', 'dtsl'),
            'CC' => esc_html__('Cocos (Keeling) Islands', 'dtsl'),
            'CO' => esc_html__('Colombia', 'dtsl'),
            'KM' => esc_html__('Comoros', 'dtsl'),
            'CG' => esc_html__('Congo', 'dtsl'),
            'CD' => esc_html__('Congo, the Democratic Republic of the', 'dtsl'),
            'CK' => esc_html__('Cook Islands', 'dtsl'),
            'CR' => esc_html__('Costa Rica', 'dtsl'),
            'CI' => esc_html__("Cote d'Ivoire", 'dtsl'),
            'HR' => esc_html__('Croatia', 'dtsl'),
            'CU' => esc_html__('Cuba', 'dtsl'),
            'CW' => esc_html__('Curacao', 'dtsl'),
            'CY' => esc_html__('Cyprus', 'dtsl'),
            'DJ' => esc_html__('Djibouti', 'dtsl'),
            'DM' => esc_html__('Dominica', 'dtsl'),
            'DO' => esc_html__('Dominican Republic', 'dtsl'),
            'EC' => esc_html__('Ecuador', 'dtsl'),
            'EG' => esc_html__('Egypt', 'dtsl'),
            'SV' => esc_html__('El Salvador', 'dtsl'),
            'GQ' => esc_html__('Equatorial Guinea', 'dtsl'),
            'ER' => esc_html__('Eritrea', 'dtsl'),
            'EE' => esc_html__('Estonia', 'dtsl'),
            'ET' => esc_html__('Ethiopia', 'dtsl'),
            'FK' => esc_html__('Falkland Islands (Malvinas)', 'dtsl'),
            'FO' => esc_html__('Faroe Islands', 'dtsl'),
            'FJ' => esc_html__('Fiji', 'dtsl'),
            'GF' => esc_html__('French Guiana', 'dtsl'),
            'PF' => esc_html__('French Polynesia', 'dtsl'),
            'TF' => esc_html__('French Southern Territories', 'dtsl'),
            'GA' => esc_html__('Gabon', 'dtsl'),
            'GM' => esc_html__('Gambia', 'dtsl'),
            'GE' => esc_html__('Georgia', 'dtsl'),
            'GH' => esc_html__('Ghana', 'dtsl'),
            'GI' => esc_html__('Gibraltar', 'dtsl'),
            'GR' => esc_html__('Greece', 'dtsl'),
            'GL' => esc_html__('Greenland', 'dtsl'),
            'GD' => esc_html__('Grenada', 'dtsl'),
            'GP' => esc_html__('Guadeloupe', 'dtsl'),
            'GU' => esc_html__('Guam', 'dtsl'),
            'GT' => esc_html__('Guatemala', 'dtsl'),
            'GG' => esc_html__('Guernsey', 'dtsl'),
            'GN' => esc_html__('Guinea', 'dtsl'),
            'GW' => esc_html__('Guinea-Bissau', 'dtsl'),
            'GY' => esc_html__('Guyana', 'dtsl'),
            'HT' => esc_html__('Haiti', 'dtsl'),
            'HM' => esc_html__('Heard Island and McDonald Islands', 'dtsl'),
            'VA' => esc_html__('Holy See (Vatican City State)', 'dtsl'),
            'HN' => esc_html__('Honduras', 'dtsl'),
            'HK' => esc_html__('Hong Kong', 'dtsl'),
            'HU' => esc_html__('Hungary', 'dtsl'),
            'IN' => esc_html__('India', 'dtsl'),
            'ID' => esc_html__('Indonesia', 'dtsl'),
            'IR' => esc_html__('Iran, Islamic Republic of', 'dtsl'),
            'IQ' => esc_html__('Iraq', 'dtsl'),
            'IL' => esc_html__('Israel', 'dtsl'),
            'JM' => esc_html__('Jamaica', 'dtsl'),
            'JP' => esc_html__('Japan', 'dtsl'),
            'JE' => esc_html__('Jersey', 'dtsl'),
            'JO' => esc_html__('Jordan', 'dtsl'),
            'KZ' => esc_html__('Kazakhstan', 'dtsl'),
            'KE' => esc_html__('Kenya', 'dtsl'),
            'KI' => esc_html__('Kiribati', 'dtsl'),
            'KP' => esc_html__('Korea, Democratic People\'s Republic of', 'dtsl'),
            'KR' => esc_html__('Korea, Republic of', 'dtsl'),
            'KV' => esc_html__('kosovo', 'dtsl'),
            'KW' => esc_html__('Kuwait', 'dtsl'),
            'KG' => esc_html__('Kyrgyzstan', 'dtsl'),
            'LA' => esc_html__('Lao People\'s Democratic Republic', 'dtsl'),
            'LV' => esc_html__('Latvia', 'dtsl'),
            'LB' => esc_html__('Lebanon', 'dtsl'),
            'LS' => esc_html__('Lesotho', 'dtsl'),
            'LR' => esc_html__('Liberia', 'dtsl'),
            'LY' => esc_html__('Libyan Arab Jamahiriya', 'dtsl'),
            'LI' => esc_html__('Liechtenstein', 'dtsl'),
            'LT' => esc_html__('Lithuania', 'dtsl'),
            'LU' => esc_html__('Luxembourg', 'dtsl'),
            'MO' => esc_html__('Macao', 'dtsl'),
            'MK' => esc_html__('Macedonia', 'dtsl'),
            'MG' => esc_html__('Madagascar', 'dtsl'),
            'MW' => esc_html__('Malawi', 'dtsl'),
            'MY' => esc_html__('Malaysia', 'dtsl'),
            'MV' => esc_html__('Maldives', 'dtsl'),
            'ML' => esc_html__('Mali', 'dtsl'),
            'MT' => esc_html__('Malta', 'dtsl'),
            'MH' => esc_html__('Marshall Islands', 'dtsl'),
            'MQ' => esc_html__('Martinique', 'dtsl'),
            'MR' => esc_html__('Mauritania', 'dtsl'),
            'MU' => esc_html__('Mauritius', 'dtsl'),
            'YT' => esc_html__('Mayotte', 'dtsl'),
            'MX' => esc_html__('Mexico', 'dtsl'),
            'FM' => esc_html__('Micronesia, Federated States of', 'dtsl'),
            'MD' => esc_html__('Moldova, Republic of', 'dtsl'),
            'MC' => esc_html__('Monaco', 'dtsl'),
            'MN' => esc_html__('Mongolia', 'dtsl'),
            'ME' => esc_html__('Montenegro', 'dtsl'),
            'MS' => esc_html__('Montserrat', 'dtsl'),
            'MA' => esc_html__('Morocco', 'dtsl'),
            'MZ' => esc_html__('Mozambique', 'dtsl'),
            'MM' => esc_html__('Myanmar', 'dtsl'),
            'NA' => esc_html__('Namibia', 'dtsl'),
            'NR' => esc_html__('Nauru', 'dtsl'),
            'NP' => esc_html__('Nepal', 'dtsl'),
            'NC' => esc_html__('New Caledonia', 'dtsl'),
            'NI' => esc_html__('Nicaragua', 'dtsl'),
            'NE' => esc_html__('Niger', 'dtsl'),
            'NG' => esc_html__('Nigeria', 'dtsl'),
            'NU' => esc_html__('Niue', 'dtsl'),
            'NF' => esc_html__('Norfolk Island', 'dtsl'),
            'MP' => esc_html__('Northern Mariana Islands', 'dtsl'),
            'OM' => esc_html__('Oman', 'dtsl'),
            'PK' => esc_html__('Pakistan', 'dtsl'),
            'PW' => esc_html__('Palau', 'dtsl'),
            'PS' => esc_html__('Palestinian Territory, Occupied', 'dtsl'),
            'PA' => esc_html__('Panama', 'dtsl'),
            'PG' => esc_html__('Papua New Guinea', 'dtsl'),
            'PY' => esc_html__('Paraguay', 'dtsl'),
            'PE' => esc_html__('Peru', 'dtsl'),
            'PH' => esc_html__('Philippines', 'dtsl'),
            'PN' => esc_html__('Pitcairn', 'dtsl'),
            'PL' => esc_html__('Poland', 'dtsl'),
            'PR' => esc_html__('Puerto Rico', 'dtsl'),
            'QA' => esc_html__('Qatar', 'dtsl'),
            'RE' => esc_html__('Reunion', 'dtsl'),
            'RO' => esc_html__('Romania', 'dtsl'),
            'RW' => esc_html__('Rwanda', 'dtsl'),
            'BL' => esc_html__('Saint Barthelemy', 'dtsl'),
            'SH' => esc_html__('Saint Helena', 'dtsl'),
            'KN' => esc_html__('Saint Kitts and Nevis', 'dtsl'),
            'LC' => esc_html__('Saint Lucia', 'dtsl'),
            'MF' => esc_html__('Saint Martin (French part)', 'dtsl'),
            'PM' => esc_html__('Saint Pierre and Miquelon', 'dtsl'),
            'VC' => esc_html__('Saint Vincent and the Grenadines', 'dtsl'),
            'WS' => esc_html__('Samoa', 'dtsl'),
            'SM' => esc_html__('San Marino', 'dtsl'),
            'ST' => esc_html__('Sao Tome and Principe', 'dtsl'),
            'SA' => esc_html__('Saudi Arabia', 'dtsl'),
            'SN' => esc_html__('Senegal', 'dtsl'),
            'RS' => esc_html__('Serbia', 'dtsl'),
            'SC' => esc_html__('Seychelles', 'dtsl'),
            'SL' => esc_html__('Sierra Leone', 'dtsl'),
            'SG' => esc_html__('Singapore', 'dtsl'),
            'SX' => esc_html__('Sint Maarten (Dutch part)', 'dtsl'),
            'SK' => esc_html__('Slovakia', 'dtsl'),
            'SI' => esc_html__('Slovenia', 'dtsl'),
            'SB' => esc_html__('Solomon Islands', 'dtsl'),
            'SO' => esc_html__('Somalia', 'dtsl'),
            'ZA' => esc_html__('South Africa', 'dtsl'),
            'GS' => esc_html__('South Georgia and the South Sandwich Islands', 'dtsl'),
            'LK' => esc_html__('Sri Lanka', 'dtsl'),
            'SD' => esc_html__('Sudan', 'dtsl'),
            'SR' => esc_html__('Suriname', 'dtsl'),
            'SJ' => esc_html__('Svalbard and Jan Mayen', 'dtsl'),
            'SZ' => esc_html__('Swaziland', 'dtsl'),
            'SY' => esc_html__('Syrian Arab Republic', 'dtsl'),
            'TW' => esc_html__('Taiwan, Province of China', 'dtsl'),
            'TJ' => esc_html__('Tajikistan', 'dtsl'),
            'TZ' => esc_html__('Tanzania, United Republic of', 'dtsl'),
            'TH' => esc_html__('Thailand', 'dtsl'),
            'TL' => esc_html__('Timor-Leste', 'dtsl'),
            'TG' => esc_html__('Togo', 'dtsl'),
            'TK' => esc_html__('Tokelau', 'dtsl'),
            'TO' => esc_html__('Tonga', 'dtsl'),
            'TT' => esc_html__('Trinidad and Tobago', 'dtsl'),
            'TN' => esc_html__('Tunisia', 'dtsl'),
            'TR' => esc_html__('Turkey', 'dtsl'),
            'TM' => esc_html__('Turkmenistan', 'dtsl'),
            'TC' => esc_html__('Turks and Caicos Islands', 'dtsl'),
            'TV' => esc_html__('Tuvalu', 'dtsl'),
            'UG' => esc_html__('Uganda', 'dtsl'),
            'UA' => esc_html__('Ukraine', 'dtsl'),
            'AE' => esc_html__('United Arab Emirates', 'dtsl'),
            'UM' => esc_html__('United States Minor Outlying Islands', 'dtsl'),
            'UY' => esc_html__('Uruguay', 'dtsl'),
            'UZ' => esc_html__('Uzbekistan', 'dtsl'),
            'VU' => esc_html__('Vanuatu', 'dtsl'),
            'VE' => esc_html__('Venezuela, Bolivarian Republic of', 'dtsl'),
            'VN' => esc_html__('Viet Nam', 'dtsl'),
            'VG' => esc_html__('Virgin Islands, British', 'dtsl'),
            'VI' => esc_html__('Virgin Islands, U.S.', 'dtsl'),
            'WF' => esc_html__('Wallis and Futuna', 'dtsl'),
            'EH' => esc_html__('Western Sahara', 'dtsl'),
            'YE' => esc_html__('Yemen', 'dtsl'),
            'ZM' => esc_html__('Zambia', 'dtsl'),
            'ZW' => esc_html__('Zimbabwe', 'dtsl')
        );

      if($with_none) {
            $Countries = array ('' => esc_html__('None', 'dtsl'))+$Countries;
      }

      return $Countries;

    }
}

?>