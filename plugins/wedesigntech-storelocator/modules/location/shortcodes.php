<?php

/* Shortcode Helper */

if(!function_exists('dtsl_shortcodeHelper_location_module')) {
    function dtsl_shortcodeHelper_location_module($content = null) {
        $content = do_shortcode ( shortcode_unautop ( $content ) );
        $content = preg_replace ( '#^<\/p>|^<br \/>|<p>$#', '', $content );
        $content = preg_replace ( '#<br \/>#', '', $content );
        return trim ( $content );
    }
}


/* Default */

// Listings Map
if(!function_exists('dtsl_listings_map')) {
    function dtsl_listings_map($attrs, $content = null) {

        $attrs = shortcode_atts ( array (

                    'type'                      => 'type1',
                    'additional_info'           => '',
                    'category_background_color' => '',
                    'category_color'            => '',
                    'zoom_level'                => '',
                    'map_type'                  => '',
                    'vc_height'                 => '',
                    'marker_animation'          => 'false',

                    'list_item_ids'             => '',
                    'category_ids'              => '',
                    'cities_ids'                => '',
                    'neighborhoods_ids'         => '',
                    'countiesstates_ids'        => '',
                    'contracttypes_ids'         => '',
                    'tag_ids'                   => '',
                    'country_id'                => '',
                    'seller_ids'                => '',
                    'incharge_ids'              => '',

                    'map_style_type'            => 'color',
                    'map_color'                 => '',
                    'map_style_script'          => '',

                    'class'                     => '',

                ), $attrs, 'dtsl_listings_map' );


        $data_attributes = array ();
        array_push($data_attributes, 'data-type="'.esc_attr($attrs['type']).'"');

        array_push($data_attributes, 'data-additionalinfo="'.esc_attr($attrs['additional_info']).'"');
        array_push($data_attributes, 'data-categorybackgroundcolor="'.esc_attr($attrs['category_background_color']).'"');
        array_push($data_attributes, 'data-categorycolor="'.esc_attr($attrs['category_color']).'"');
        array_push($data_attributes, 'data-zoomlevel="'.esc_attr($attrs['zoom_level']).'"');
        array_push($data_attributes, 'data-maptype="'.esc_attr($attrs['map_type']).'"');
        array_push($data_attributes, 'data-markeranimation="'.esc_attr($attrs['marker_animation']).'"');

        array_push($data_attributes, 'data-listitemids="'.esc_attr($attrs['list_item_ids']).'"');
        array_push($data_attributes, 'data-categoryids="'.esc_attr($attrs['category_ids']).'"');
        array_push($data_attributes, 'data-citiesids="'.esc_attr($attrs['cities_ids']).'"');
        array_push($data_attributes, 'data-neighborhoodsids="'.esc_attr($attrs['neighborhoods_ids']).'"');
        array_push($data_attributes, 'data-countiesstatesids="'.esc_attr($attrs['countiesstates_ids']).'"');
        array_push($data_attributes, 'data-contracttypesids="'.esc_attr($attrs['contracttypes_ids']).'"');
        array_push($data_attributes, 'data-tagids="'.esc_attr($attrs['tag_ids']).'"');
        array_push($data_attributes, 'data-countryid="'.esc_attr($attrs['country_id']).'"');
        array_push($data_attributes, 'data-sellerids="'.esc_attr($attrs['seller_ids']).'"');
        array_push($data_attributes, 'data-inchargeids="'.esc_attr($attrs['incharge_ids']).'"');

        array_push($data_attributes, 'data-mapstyletype="'.esc_attr($attrs['map_style_type']).'"');
        array_push($data_attributes, 'data-mapcolor="'.esc_attr($attrs['map_color']).'"');
        $content = str_replace("\n", "", $content);
        $content = str_replace("\t", "", $content);
        array_push($data_attributes, 'data-mapstylescript="'.esc_js($content).'"');

        if(!empty($data_attributes)) {
            $data_attributes_string = implode(' ', $data_attributes);
        }

        $height_attr = '';
        if($attrs['vc_height'] != '') {
            $height_attr = 'style="height:'.$attrs['vc_height'].'px;"';
        }

        $output = '';

        $mapid = rand();

        $output .= '<div class="dtsl-listing-output-map-container dtsl-direct-list-items '.esc_attr($attrs['class']).'">
                        <div class="dtsl-listing-output-map-holder" '.$data_attributes_string.'>
                            <div class="dtsl-listing-output-map" id="dtsl-listing-output-map-'.esc_attr($mapid).'" '.$height_attr.'></div>
                        </div>
                        '.dtsl_generate_loader_html(false).'
                    </div>';


        return $output;

    }
    add_shortcode ( 'dtsl_listings_map', 'dtsl_listings_map' );
}

// Yelp - Nearby Places
if(!function_exists('dtsl_yelp_places')) {
    function dtsl_yelp_places( $attrs, $content = null ) {

        $attrs = shortcode_atts ( array (

                    'categories'    => '',
                    'term'          => '',
                    'location_type' => 'location',
                    'location'      => '',
                    'latitude'      => '',
                    'longitude'     => '',
                    'count'         => '',
                    'api_key'       => '',
                    'class'         => '',

                ), $attrs, 'dtsl_yelp_places' );

        $output = '';

        if($attrs['categories'] != '' || $attrs['term'] != '') {

            $url_params                  = array();
            if($attrs['categories'] != '') {
                $url_params['categories'] = $attrs['categories'];
            } else if($attrs['term'] != '') {
                $url_params['term'] = $attrs['term'];
            }
            if($attrs['location_type'] == 'location') {
                $url_params['location']  = $attrs['location'];
            } else {
                $url_params['latitude']  = $attrs['latitude'];
                $url_params['longitude'] = $attrs['longitude'];
            }
            $url_params['limit']         = $attrs['count'];


            $url = 'https://api.yelp.com/v3/businesses/search'. '?' . http_build_query($url_params);

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "authorization: Bearer " . $attrs['api_key'],
                "cache-control: no-cache",
            ));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


            $result = curl_exec($ch);
            curl_close($ch);

            $decoded_results = json_decode($result, true);
            $decoded_results = $decoded_results['businesses'];

            if(is_array($decoded_results) && !empty($decoded_results)) {
                $output .= '<div class="dtsl-yelp-places-container">';
                    foreach($decoded_results as $decoded_result) {

                        $output .= '<div class="dtsl-yelp-places-item">';

                            if($decoded_result['image_url'] != '') {

                                $output .= '<div class="dtsl-yelp-places-image">';
                                    $output .= '<img src="'.$decoded_result['image_url'].'" />';
                                $output .= '</div>';

                            }

                            $output .= '<div class="dtsl-yelp-places-content">';

                                $output .= '<div class="dtsl-yelp-places-title">'.$decoded_result['name'].'</div>';

                                if($decoded_result['rating'] != '') {
                                    $output .= '<div class="dtsl-yelp-places-ratings">'.$decoded_result['rating'].'</div>';
                                }

                                if($decoded_result['distance'] != ''){
                                    $output .= '<div class="dtsl-yelp-places-distance">'.round($decoded_result['distance'], 2).'m</div>';
                                }

                                $output .= '<div class="dtsl-yelp-places-address">'.$decoded_result['location']['display_address'][0].', '.$decoded_result['location']['display_address'][1].'</div>';

                            $output .= '</div>';

                        $output .= '</div>';

                    }
                $output .= '</div>';
            }

        } else {
            $output .= esc_html__('Insufficient Data!', 'dtsl');
        }

        return $output;

    }
    add_shortcode ( 'dtsl_yelp_places', 'dtsl_yelp_places' );
}


/* Single Page */

// Map
if(!function_exists('dtsl_sp_map')) {
    function dtsl_sp_map( $attrs, $content = null ) {

        $attrs = shortcode_atts ( array (

                    'listing_id' => '',
                    'show_direction_link' => '',
                    'map_color' => '',
                    'class' => '',

                ), $attrs, 'dtsl_sp_map' );


        $output = '';

        if($attrs['listing_id'] == '' && is_singular('dtsl_listings')) {
            global $post;
            $attrs['listing_id'] = $post->ID;
        }

        if($attrs['listing_id'] != '') {

            $dtsl_latitude  = get_post_meta($attrs['listing_id'], 'dtsl_latitude', true);
            $dtsl_longitude = get_post_meta($attrs['listing_id'], 'dtsl_longitude', true);

            if($dtsl_latitude != '' && $dtsl_latitude != '') {

                $dtsl_map_image  	= get_post_meta($attrs['listing_id'], 'dtsl_map_image', true);
                $image_url = wp_get_attachment_image_src($dtsl_map_image, 'full');
                $map_image = (isset($image_url[0]) && !empty($image_url[0])) ? $image_url[0] : DTSL_PLUGIN_URL.'assets/images/marker.png';

                $map_attributes = array ();

                array_push($map_attributes, 'data-latitude="'.$dtsl_latitude.'"');
                array_push($map_attributes, 'data-longitude="'.$dtsl_longitude.'"');
                array_push($map_attributes, 'data-markerimage="'.$map_image.'"');
                array_push($map_attributes, 'data-mapcolor="'.$attrs['map_color'].'"');

                $map_attributes_string = implode(' ', $map_attributes);

                $dtsl_latitude_id = str_replace('.', '', $dtsl_latitude);

                $output .= '<div class="dtsl-listings-map-container '.$attrs['class'].'" '.$map_attributes_string.'>';

                    $output .= '<div id="dtsl-listings-map-holder-'.$dtsl_latitude_id.'" class="dtsl-listings-map-holder"></div>';
                    if($attrs['show_direction_link'] == 'true') {
                        $output .= '<a href="//maps.google.com/maps?daddr='.$dtsl_latitude.','.$dtsl_longitude.'" class="dtsl-listings-address-directions" target="_blank">'.esc_html__('Get Direction', 'dtsl').'<span class="fa fa-angle-right"></span></a>';
                    }

                $output .= '</div>';

            } else {

                $output .= esc_html__('Map data seems to be invalid.', 'dtsl');

            }

        } else {

            $dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );

            $output .= sprintf( esc_html__('Please provide %1$s id to display corresponding data!', 'dtsl'), strtolower($dt_sl_listing_singular_label) );

        }

        return $output;

    }
    add_shortcode ( 'dtsl_sp_map', 'dtsl_sp_map' );
}

// Nearby Places
if(!function_exists('dtsl_sp_nearby_places')) {
    function dtsl_sp_nearby_places( $attrs, $content = null ) {

        $attrs = shortcode_atts ( array (

                    'listing_id' => '',
                    'api_type'   => 'findplacefromtext',
                    'media_type' => '',
                    'place_type' => '',
                    'count'      => 2,
                    'radius'     => '1000',
                    'api_key'    => '',
                    'class'      => '',

                ), $attrs, 'dtsl_sp_nearby_places' );

        $output = '';

        if($attrs['listing_id'] == '' && is_singular('dtsl_listings')) {
            global $post;
            $attrs['listing_id'] = $post->ID;
        }

        if($attrs['listing_id'] != '') {

            if($attrs['api_key'] != '') {
                $googlemap_api_key = $attrs['api_key'];
            } else {
                $googlemap_api_key = dtsl_option('map', 'googlemap-api-key');
            }

            if($googlemap_api_key != '') {

                $dtsl_latitude  = get_post_meta($attrs['listing_id'], 'dtsl_latitude', true);
                $dtsl_longitude = get_post_meta($attrs['listing_id'], 'dtsl_longitude', true);

                if($dtsl_latitude != '' && $dtsl_latitude != '' && $attrs['place_type'] != '') {

                    if($attrs['place_type'] ==  'nearbysearch') {

                        $query = 'https://maps.googleapis.com/maps/api/place/nearbysearch/json?location='.$dtsl_latitude.','.$dtsl_longitude.'&radius='.$attrs['radius'].'&type='.$attrs['place_type'].'&key='.$googlemap_api_key;
                        $nearby_places = json_decode(file_get_contents($query), true);
                        $nearby_places_data = $nearby_places['results'];

                    } else {

                        $query = 'https://maps.googleapis.com/maps/api/place/findplacefromtext/json?input='.$attrs['place_type'].'&inputtype=textquery&fields=geometry,photos,icon,name,formatted_address&locationbias=circle:'.$attrs['radius'].'@'.$dtsl_latitude.','.$dtsl_longitude.'&key='.$googlemap_api_key;
                        $nearby_places = json_decode(file_get_contents($query), true);
                        $nearby_places_data = $nearby_places['candidates'];

                    }

                    if($nearby_places['status']=='OK') {

                        $output .= '<div class="dtsl-listings-nearby-places-container '.$attrs['class'].'">';

                            $i = 0;
                            foreach($nearby_places_data as $nearby_place) {

                                $nearby_place_lat = $nearby_place['geometry']['location']['lat'];
                                $nearby_place_lng = $nearby_place['geometry']['location']['lng'];

                                $radius_calculated = dtsl_calculate_distance_between_location($dtsl_latitude, $dtsl_longitude, $nearby_place_lat, $nearby_place_lng, 'km');

                                $output .= '<div class="dtsl-listings-nearby-places-item">';

                                    if($attrs['media_type'] == 'image' && isset($nearby_place['photos'][0]['photo_reference'])) {

                                        $output .= '<div class="dtsl-listings-nearby-places-image">';

                                            $output .= '<img src="https://maps.googleapis.com/maps/api/place/photo?maxwidth=400&photoreference='.$nearby_place['photos'][0]['photo_reference'].'&sensor=true&key='.$googlemap_api_key.'" />';

                                        $output .= '</div>';

                                    } else if($attrs['media_type'] == 'icon' && isset($nearby_place['icon'])) {

                                        $output .= '<div class="dtsl-listings-nearby-places-image">';

                                            $output .= '<div class="dtsl-listings-nearby-places-icon" style="-webkit-mask-image:url(\''.$nearby_place['icon'].'\');"></div>';

                                        $output .= '</div>';

                                    }

                                    $output .= '<div class="dtsl-listings-nearby-places-content">';

                                        $output .= '<div class="dtsl-listings-nearby-places-title">'.$nearby_place['name'].'</div>';

                                        if(isset($nearby_place['rating'])) {
                                            $output .= '<div class="dtsl-listings-nearby-places-ratings">'.$nearby_place['rating'].'</div>';
                                        }

                                        if($radius_calculated != ''){
                                            $output .= '<div class="dtsl-listings-nearby-places-distance">'.$radius_calculated.' km</div>';
                                        }

                                        $output .= '<div class="dtsl-listings-nearby-places-address">'.$nearby_place['formatted_address'].'</div>';

                                    $output .= '</div>';

                                $output .= '</div>';

                                if($i == ($attrs['count']-1)) {
                                    break;
                                }
                                $i++;

                            }

                        $output .= '</div>';

                    } else if(isset($nearby_places['error_message'])) {

                        $output .= esc_html($nearby_places['error_message']);
                    }

                } else {

                    $output .= esc_html__('Map data seems to be invalid.', 'dtsl');

                }

            } else {

                $output .= esc_html__('Provide valid Google Map API key.', 'dtsl');

            }

        } else {

            $dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );

            $output .= sprintf( esc_html__('Please provide %1$s id to display corresponding data!', 'dtsl'), strtolower($dt_sl_listing_singular_label) );

        }

        return $output;

    }
    add_shortcode ( 'dtsl_sp_nearby_places', 'dtsl_sp_nearby_places' );
}

// Virtual Tour
if(!function_exists('dtsl_sp_virtual_tour')) {
    function dtsl_sp_virtual_tour( $attrs, $content = null ) {

        $attrs = shortcode_atts ( array (

                    'listing_id' => '',
                    'class' => '',

                ), $attrs, 'dtsl_sp_virtual_tour' );


        $output = '';

        if($attrs['listing_id'] == '' && is_singular('dtsl_listings')) {
            global $post;
            $attrs['listing_id'] = $post->ID;
        }

        if($attrs['listing_id'] != '') {

            $output .= '<div class="dtsl-listings-virtual-tour-holder '.$attrs['class'].'">';
                $dtsl_virtual_tour = get_post_meta($attrs['listing_id'], 'dtsl_virtual_tour', true);
                $output .= dtsl_shortcodeHelper_location_module ( $dtsl_virtual_tour );
            $output .= '</div>';

        }

        return $output;

    }
    add_shortcode ( 'dtsl_sp_virtual_tour', 'dtsl_sp_virtual_tour' );
}

/* Search */

// Output Map Container
if(!function_exists('dtsl_sf_output_map_container')) {
    function dtsl_sf_output_map_container( $attrs, $content = null ) {

        $attrs = shortcode_atts ( array (

                    'type'                      => 'type1',
                    'gallery'                   => 'featured_image',

                    'zoom_level'                => '',
                    'map_type'                  => '',
                    'additional_info'           => '',
                    'category_background_color' => '',
                    'category_color'            => '',
                    'marker_animation'          => 'false',
                    'vc_height'                 => '',
                    'marker_animation'          => 'false',

                    'category_ids'              => '',

                    'map_style_type'            => 'color',
                    'map_color'                 => '',
                    'map_style_script'          => '',

                    'class'                     => '',

                ), $attrs, 'dtsl_sf_output_map_container' );


        $output = '';

        $data_attributes = array ();
        array_push($data_attributes, 'data-type="'.esc_attr($attrs['type']).'"');
        array_push($data_attributes, 'data-gallery="'.esc_attr($attrs['gallery']).'"');
        array_push($data_attributes, 'data-additionalinfo="'.esc_attr($attrs['additional_info']).'"');
        array_push($data_attributes, 'data-categorybackgroundcolor="'.esc_attr($attrs['category_background_color']).'"');
        array_push($data_attributes, 'data-categorycolor="'.esc_attr($attrs['category_color']).'"');
        array_push($data_attributes, 'data-zoomlevel="'.esc_attr($attrs['zoom_level']).'"');
        array_push($data_attributes, 'data-maptype="'.esc_attr($attrs['map_type']).'"');
        array_push($data_attributes, 'data-markeranimation="'.esc_attr($attrs['marker_animation']).'"');
        array_push($data_attributes, 'data-categoryids="'.esc_attr($attrs['category_ids']).'"');
        array_push($data_attributes, 'data-mapstyletype="'.esc_attr($attrs['map_style_type']).'"');
        array_push($data_attributes, 'data-mapcolor="'.esc_attr($attrs['map_color']).'"');
        $content = str_replace("\n", "", $content);
        $content = str_replace("\t", "", $content);
        array_push($data_attributes, 'data-mapstylescript="'.esc_js($content).'"');

        if(!empty($data_attributes)) {
            $data_attributes_string = implode(' ', $data_attributes);
        }

        $height_attr = '';
        if($attrs['vc_height'] != '') {
            $height_attr = 'style="height:'.$attrs['vc_height'].'px;"';
        }

        $output .= '<div class="dtsl-listing-output-map-container dtsl-search-list-items '.esc_attr($attrs['class']).'">
                        <div class="dtsl-listing-output-map-holder" '.$data_attributes_string.'>
                            <div class="dtsl-listing-output-map" id="dtsl-listing-output-map" '.$height_attr.'></div>
                        </div>
                        '.dtsl_generate_loader_html(false).'
                    </div>';

        return $output;

    }
    add_shortcode ( 'dtsl_sf_output_map_container', 'dtsl_sf_output_map_container' );
}

// Location
if(!function_exists('dtsl_sf_location_field')) {
    function dtsl_sf_location_field( $attrs, $content = null ) {

        $attrs = shortcode_atts ( array (

                    'ajax_load'        => '',
                    'placeholder_text' => '',
                    'auto_complete'    => '',
                    'max_radius'       => 100,
                    'radius_unit'      => 'km',
                    'class'            => '',

                ), $attrs, 'dtsl_sf_location_field' );


        $output = '';

        $output .= '<div class="dtsl-sf-fields-holder dtsl-sf-location-field-holder '.$attrs['class'].'">';

            $placeholder_text = esc_html__('Location', 'dtsl');
            if($attrs['placeholder_text'] != '') {
                $placeholder_text = esc_html($attrs['placeholder_text']);
            }

            $dtsl_sf_location = '';
            if(isset($_REQUEST['dtsl_sf_location']) && $_REQUEST['dtsl_sf_location'] != '') {
                $dtsl_sf_location = dtsl_recursive_sanitize_text_field($_REQUEST['dtsl_sf_location']);
            }

            $dtsl_sf_location_latitude = '';
            if(isset($_REQUEST['dtsl_sf_location_latitude']) && $_REQUEST['dtsl_sf_location_latitude'] != '') {
                $dtsl_sf_location_latitude = dtsl_recursive_sanitize_text_field($_REQUEST['dtsl_sf_location_latitude']);
            }

            $dtsl_sf_location_longitude = '';
            if(isset($_REQUEST['dtsl_sf_location_longitude']) && $_REQUEST['dtsl_sf_location_longitude'] != '') {
                $dtsl_sf_location_longitude = dtsl_recursive_sanitize_text_field($_REQUEST['dtsl_sf_location_longitude']);
            }

            $autocomplete = '';
            if($attrs['auto_complete'] == 'true') {
                $autocomplete = 'dtsl-sf-location';
            }

            $additional_class = '';
            if($attrs['ajax_load'] == 'true') {
                $additional_class = 'dtsl-with-ajax-load';
            }

            $output .= '<div class="dtsl-sf-location-field-inner-holder">';

                $output .= '<input name="dtsl_sf_location" class="dtsl-sf-field dtsl-sf-location '.esc_attr($additional_class).'" type="text" value="'.esc_attr($dtsl_sf_location).'" placeholder="'.esc_attr($placeholder_text).'" id="'.esc_attr($autocomplete).'" />';
                $output .= '<span></span>';

                $output .= '<input name="dtsl_sf_location_latitude" class="dtsl-sf-field dtsl-sf-location-latitude" type="hidden" value="'.esc_attr($dtsl_sf_location_latitude).'" />';
                $output .= '<input name="dtsl_sf_location_longitude" class="dtsl-sf-field dtsl-sf-location-longitude" type="hidden" value="'.esc_attr($dtsl_sf_location_longitude).'" />';

                $output .= '<input name="dtsl_sf_location_max_radius" class="dtsl-sf-field dtsl-sf-location-max-radius" type="hidden" value="'.$attrs['max_radius'].'" />';
                $output .= '<input name="dtsl_sf_location_radius_unit" class="dtsl-sf-field dtsl-sf-location-radius-unit" type="hidden" value="'.$attrs['radius_unit'].'" />';

                $output .= '<span class="fas fa-map-marker-alt dtsl-detect-location '.esc_attr($additional_class).'"></span>';

            $output .= '</div>';

        $output .= '</div>';

        return $output;

    }
    add_shortcode ( 'dtsl_sf_location_field', 'dtsl_sf_location_field' );
}

// Radius
if(!function_exists('dtsl_sf_radius_field')) {
    function dtsl_sf_radius_field( $attrs, $content = null ) {

        $attrs = shortcode_atts ( array (

                    'ajax_load' => '',
                    'min_radius' => 1,
                    'max_radius' => 100,
                    'default_radius' => 20,
                    'radius_unit' => 'km',
                    'class' => '',

                ), $attrs, 'dtsl_sf_radius_field' );


        $output = '';

        $output .= '<div class="dtsl-sf-fields-holder dtsl-sf-radius-field-holder '.$attrs['class'].'">';

            $additional_class = '';
            if($attrs['ajax_load'] == 'true') {
                $additional_class = 'dtsl-with-ajax-load';
            }

            $dtsl_sf_radius = $attrs['default_radius'];
            if(isset($_REQUEST['dtsl_sf_radius']) && $_REQUEST['dtsl_sf_radius'] != '') {
                $dtsl_sf_radius = dtsl_recursive_sanitize_text_field($_REQUEST['dtsl_sf_radius']);
            }

            $dtsl_sf_radius_unit = $attrs['radius_unit'];
            if(isset($_REQUEST['dtsl_sf_radius_unit']) && $_REQUEST['dtsl_sf_radius_unit'] != '') {
                $dtsl_sf_radius_unit = dtsl_recursive_sanitize_text_field($_REQUEST['dtsl_sf_radius_unit']);
            }

            $output .= '<div class="dtsl-sf-radius-slider '.esc_attr($additional_class).'" data-min="'.esc_attr($attrs['min_radius']).'" data-max="'.esc_attr($attrs['max_radius']).'" data-unit="'.esc_attr($dtsl_sf_radius_unit).'" data-default="'.esc_attr($dtsl_sf_radius).'">';
                $output .= '<div class="dtsl-sf-radius-slider-handle">'.$dtsl_sf_radius.$dtsl_sf_radius_unit.'</div>';
                $output .= '<div class="dtsl-sf-radius-slider-ranges">';
                    $output .= '<div class="dtsl-sf-radius-slider-range-min-holder">';
                        $output .= '<label>'.esc_html__('Min', 'dtsl').'</label>';
                        $output .= '<div class="dtsl-sf-radius-slider-range-min">'.esc_attr($attrs['min_radius']).' '.esc_attr($dtsl_sf_radius_unit).'</div>';
                    $output .= '</div>';
                    $output .= '<div class="dtsl-sf-radius-slider-range-max-holder">';
                        $output .= '<label>'.esc_html__('Max', 'dtsl').'</label>';
                        $output .= '<div class="dtsl-sf-radius-slider-range-max">'.esc_attr($attrs['max_radius']).' '.esc_attr($dtsl_sf_radius_unit).'</div>';
                    $output .= '</div>';
                $output .= '</div>';
            $output .= '</div>';

            $output .= '<input name="dtsl_sf_radius" class="dtsl-sf-field dtsl-sf-radius" type="hidden" value="'.esc_attr($dtsl_sf_radius).'" />';
            $output .= '<input name="dtsl_sf_radius_unit" class="dtsl-sf-field dtsl-sf-radius-unit" type="hidden" value="'.esc_attr($dtsl_sf_radius_unit).'" />';

        $output .= '</div>';

        return $output;

    }
    add_shortcode ( 'dtsl_sf_radius_field', 'dtsl_sf_radius_field' );
}

// NearBy
if(!function_exists('dtsl_sf_nearby_field')) {
    function dtsl_sf_nearby_field( $attrs, $content = null ) {

        $attrs = shortcode_atts ( array (

                    'ajax_load' => '',
                    'max_radius' => 100,
                    'radius_unit' => 'km',
                    'class' => '',

                ), $attrs, 'dtsl_sf_nearby_field' );


        $output = '';

        $output .= '<div class="dtsl-sf-fields-holder dtsl-sf-others-field-holder dtsl-sf-nearby-field-holder '.$attrs['class'].'">';

            $additional_class = '';
            if($attrs['ajax_load'] == 'true') {
                $additional_class = 'dtsl-with-ajax-load';
            }

            $output .= '<div class="dtsl-sf-others-list">';

                $output .= '<div data-itemvalue="nearby" class="dtsl-sf-others-list-item dtsl-detect-location '.esc_attr($additional_class).'">';
                    $output .= esc_html__('Near By', 'dtsl');
                $output .= '</div>';

                $output .= '<input name="dtsl_sf_location_latitude" class="dtsl-sf-field dtsl-sf-location-latitude" type="hidden" value="" />';
                $output .= '<input name="dtsl_sf_location_longitude" class="dtsl-sf-field dtsl-sf-location-longitude" type="hidden" value="" />';
                $output .= '<input name="dtsl_sf_location_max_radius" class="dtsl-sf-field dtsl-sf-location-max-radius" type="hidden" value="'.$attrs['max_radius'].'" />';
                $output .= '<input name="dtsl_sf_location_radius_unit" class="dtsl-sf-field dtsl-sf-location-radius-unit" type="hidden" value="'.$attrs['radius_unit'].'" />';

            $output .= '</div>';

        $output .= '</div>';

        return $output;

    }
    add_shortcode ( 'dtsl_sf_nearby_field', 'dtsl_sf_nearby_field' );
}

// Cities
if(!function_exists('dtsl_sf_cities_field')) {
    function dtsl_sf_cities_field( $attrs, $content = null ) {

        $attrs = shortcode_atts ( array (

                    'field_type'              => '',
                    'placeholder_text'        => '',
                    'dropdown_type'           => '',
                    'ajax_load'               => '',
                    'default_item_id'         => '',
                    'show_parent_items_alone' => 'false',
                    'child_of'                => '',
                    'class'            => '',

                ), $attrs, 'dtsl_sf_cities_field' );


        $output = '';

        $output .= '<div class="dtsl-sf-fields-holder dtsl-sf-cities-field-holder '.$attrs['class'].'">';

            $additional_class = '';
            if($attrs['ajax_load'] == 'true') {
                $additional_class = 'dtsl-with-ajax-load';
            }

            $dtsl_sf_cities = array ();
            if(isset($_REQUEST['dtsl_sf_cities'])) {
                if(is_array($_REQUEST['dtsl_sf_cities']) && !empty($_REQUEST['dtsl_sf_cities'])) {
                    $dtsl_sf_cities = dtsl_recursive_sanitize_text_field($_REQUEST['dtsl_sf_cities']);
                } else if($_REQUEST['dtsl_sf_cities'] != '') {
                    $dtsl_sf_cities = explode(',', dtsl_recursive_sanitize_text_field($_REQUEST['dtsl_sf_cities']));
                }
            } elseif($attrs['default_item_id'] != '') {
                $dtsl_sf_cities = explode(',', dtsl_recursive_sanitize_text_field($attrs['default_item_id']));
            }

            $placeholder_text = esc_html__('Cities', 'dtsl');
            if($attrs['placeholder_text'] != '') {
                $placeholder_text = esc_html($attrs['placeholder_text']);
            }

            if($attrs['field_type'] == 'dropdown') {

                $mulitple_attr = '';
                if($attrs['dropdown_type'] == 'multiple') {
                    $mulitple_attr = 'multiple';
                }

                $output .= '<select class="dtsl-sf-field dtsl-sf-cities '.esc_attr($additional_class).' dtsl-chosen-select" name="dtsl_sf_cities" data-placeholder="'.esc_attr($placeholder_text).'" '.esc_attr($mulitple_attr).'>';
                    if($mulitple_attr == '') {
                        $output .= '<option value="">'.esc_attr($placeholder_text).'</option>';
                    }

                    $cities_args = array (
                        'taxonomy'   => 'dtsl_listings_city',
                        'hide_empty' => 1,
                    );

                    if($attrs['child_of'] != '') {
                        $cities_args['child_of'] = $attrs['child_of'];
                    } else {
                        $cities_args['parent'] = 0;
                    }
                    $listing_cities = get_categories($cities_args);

                    if(isset($listing_cities)) {
                        foreach($listing_cities as $listing_city) {
                            $selected_attr = '';
                            if(in_array($listing_city->term_id, $dtsl_sf_cities)) {
                                $selected_attr = 'selected="selected"';
                            }
                            $output .= '<option value="'.esc_attr($listing_city->term_id).'" '.$selected_attr.'>'.esc_html($listing_city->name).'</option>';

                            if($attrs['show_parent_items_alone'] != 'true') {

                                // Child Items
                                $listing_city_childs = get_categories('taxonomy=dtsl_listings_city&hide_empty=1&child_of='.$listing_city->term_id);
                                if(is_array($listing_city_childs) && !empty($listing_city_childs)) {
                                    foreach($listing_city_childs as $listing_city_child) {
                                        $selected_attr = '';
                                        if(in_array($listing_city_child->term_id, $dtsl_sf_cities)) {
                                            $selected_attr = 'selected="selected"';
                                        }
                                        $output .= '<option value="'.esc_attr($listing_city_child->term_id).'" '.$selected_attr.'>'."&emsp;".esc_html($listing_city_child->name).'</option>';
                                    }
                                }

                            }

                        }
                    }
                $output .= '</select>';

            } else {

                $output .= '<ul>';
                    $listing_cities = get_categories('taxonomy=dtsl_listings_city&hide_empty=1');
                    if(isset($listing_cities)) {
                        foreach($listing_cities as $listing_city) {
                            $output .= '<li>
                                            <input type="checkbox" name="dtsl_sf_cities[]" class="dtsl-sf-field dtsl-sf-cities '.esc_attr($additional_class).'" value="'.esc_attr($listing_city->term_id).'" id="dtsl-sf-cities-'.esc_attr($listing_city->term_id).'" '.checked(in_array($listing_city->term_id, $dtsl_sf_cities), true, false).' />
                                            <label for="dtsl-sf-cities-'.esc_attr($listing_city->term_id).'">'.esc_html($listing_city->name).'</label>
                                        </li>';
                        }
                    }
                $output .= '</ul>';

            }

        $output .= '</div>';

        return $output;

    }
    add_shortcode ( 'dtsl_sf_cities_field', 'dtsl_sf_cities_field' );
}

// Neighborhood
if(!function_exists('dtsl_sf_neighborhood_field')) {
    function dtsl_sf_neighborhood_field( $attrs, $content = null ) {

        $attrs = shortcode_atts ( array (

                    'field_type'              => '',
                    'placeholder_text'        => '',
                    'dropdown_type'           => '',
                    'ajax_load'               => '',
                    'default_item_id'         => '',
                    'show_parent_items_alone' => 'false',
                    'child_of'                => '',
                    'class'                   => '',

                ), $attrs, 'dtsl_sf_neighborhood_field' );


        $output = '';

        $output .= '<div class="dtsl-sf-fields-holder dtsl-sf-neighborhood-field-holder '.$attrs['class'].'">';

            $additional_class = '';
            if($attrs['ajax_load'] == 'true') {
                $additional_class = 'dtsl-with-ajax-load';
            }

            $dtsl_sf_neighborhood = array ();
            if(isset($_REQUEST['dtsl_sf_neighborhood'])) {
                if(is_array($_REQUEST['dtsl_sf_neighborhood']) && !empty($_REQUEST['dtsl_sf_neighborhood'])) {
                    $dtsl_sf_neighborhood = dtsl_recursive_sanitize_text_field($_REQUEST['dtsl_sf_neighborhood']);
                } else if($_REQUEST['dtsl_sf_neighborhood'] != '') {
                    $dtsl_sf_neighborhood = explode(',', dtsl_recursive_sanitize_text_field($_REQUEST['dtsl_sf_neighborhood']));
                }
            } elseif($attrs['default_item_id'] != '') {
                $dtsl_sf_neighborhood = explode(',', dtsl_recursive_sanitize_text_field($attrs['default_item_id']));
            }

            $placeholder_text = esc_html__('Neighborhood', 'dtsl');
            if($attrs['placeholder_text'] != '') {
                $placeholder_text = esc_html($attrs['placeholder_text']);
            }

            if($attrs['field_type'] == 'dropdown') {

                $mulitple_attr = '';
                if($attrs['dropdown_type'] == 'multiple') {
                    $mulitple_attr = 'multiple';
                }

                $output .= '<select class="dtsl-sf-field dtsl-sf-neighborhood '.esc_attr($additional_class).' dtsl-chosen-select" name="dtsl_sf_neighborhood" data-placeholder="'.esc_attr($placeholder_text).'" '.esc_attr($mulitple_attr).'>';
                    if($mulitple_attr == '') {
                        $output .= '<option value="">'.esc_attr($placeholder_text).'</option>';
                    }

                    $neighborhoods_args = array (
                        'taxonomy'   => 'dtsl_listings_neighborhood',
                        'hide_empty' => 1,
                    );

                    if($attrs['child_of'] != '') {
                        $neighborhoods_args['child_of'] = $attrs['child_of'];
                    } else {
                        $neighborhoods_args['parent'] = 0;
                    }
                    $listing_neighborhoods = get_categories($neighborhoods_args);

                    if(isset($listing_neighborhoods)) {
                        foreach($listing_neighborhoods as $listing_neighborhood) {
                            $selected_attr = '';
                            if(in_array($listing_neighborhood->term_id, $dtsl_sf_neighborhood)) {
                                $selected_attr = 'selected="selected"';
                            }
                            $output .= '<option value="'.esc_attr($listing_neighborhood->term_id).'" '.$selected_attr.'>'.esc_html($listing_neighborhood->name).'</option>';

                            if($attrs['show_parent_items_alone'] != 'true') {

                                // Child Items
                                $listing_neighborhood_childs = get_categories('taxonomy=dtsl_listings_category&hide_empty=1&child_of='.$listing_neighborhood->term_id);
                                if(is_array($listing_neighborhood_childs) && !empty($listing_neighborhood_childs)) {
                                    foreach($listing_neighborhood_childs as $listing_neighborhood_child) {
                                        $selected_attr = '';
                                        if(in_array($listing_neighborhood_child->term_id, $dtsl_sf_neighborhood)) {
                                            $selected_attr = 'selected="selected"';
                                        }
                                        $output .= '<option value="'.esc_attr($listing_neighborhood_child->term_id).'" '.$selected_attr.'>'."&emsp;".esc_html($listing_neighborhood_child->name).'</option>';
                                    }
                                }

                            }

                        }
                    }
                $output .= '</select>';

            } else {

                $output .= '<ul>';
                    $listing_neighborhoods = get_categories('taxonomy=dtsl_listings_neighborhood&hide_empty=1');
                    if(isset($listing_neighborhoods)) {
                        foreach($listing_neighborhoods as $listing_neighborhood) {
                            $output .= '<li>
                                            <input type="checkbox" name="dtsl_sf_neighborhood[]" class="dtsl-sf-field dtsl-sf-neighborhood '.esc_attr($additional_class).'" value="'.esc_attr($listing_neighborhood->term_id).'" id="dtsl-sf-neighborhood-'.esc_attr($listing_neighborhood->term_id).'" '.checked(in_array($listing_neighborhood->term_id, $dtsl_sf_neighborhood), true, false).' />
                                            <label for="dtsl-sf-neighborhood-'.esc_attr($listing_neighborhood->term_id).'">'.esc_html($listing_neighborhood->name).'</label>
                                        </li>';
                        }
                    }
                $output .= '</ul>';

            }

        $output .= '</div>';

        return $output;

    }
    add_shortcode ( 'dtsl_sf_neighborhood_field', 'dtsl_sf_neighborhood_field' );
}

// Countystate
if(!function_exists('dtsl_sf_countystate_field')) {
    function dtsl_sf_countystate_field( $attrs, $content = null ) {

        $attrs = shortcode_atts ( array (

                    'field_type'              => '',
                    'placeholder_text'        => '',
                    'dropdown_type'           => '',
                    'ajax_load'               => '',
                    'default_item_id'         => '',
                    'show_parent_items_alone' => 'false',
                    'child_of'                => '',
                    'class'                   => '',

                ), $attrs, 'dtsl_sf_countystate_field' );


        $output = '';

        $output .= '<div class="dtsl-sf-fields-holder dtsl-sf-countystate-field-holder '.$attrs['class'].'">';

            $additional_class = '';
            if($attrs['ajax_load'] == 'true') {
                $additional_class = 'dtsl-with-ajax-load';
            }

            $dtsl_sf_countystate = array ();
            if(isset($_REQUEST['dtsl_sf_countystate'])) {
                if(is_array($_REQUEST['dtsl_sf_countystate']) && !empty($_REQUEST['dtsl_sf_countystate'])) {
                    $dtsl_sf_countystate = dtsl_recursive_sanitize_text_field($_REQUEST['dtsl_sf_countystate']);
                } else if($_REQUEST['dtsl_sf_countystate'] != '') {
                    $dtsl_sf_countystate = explode(',', dtsl_recursive_sanitize_text_field($_REQUEST['dtsl_sf_countystate']));
                }
            } elseif($attrs['default_item_id'] != '') {
                $dtsl_sf_countystate = explode(',', dtsl_recursive_sanitize_text_field($attrs['default_item_id']));
            }

            $placeholder_text = esc_html__('Counties / States', 'dtsl');
            if($attrs['placeholder_text'] != '') {
                $placeholder_text = esc_html($attrs['placeholder_text']);
            }

            if($attrs['field_type'] == 'dropdown') {

                $mulitple_attr = '';
                if($attrs['dropdown_type'] == 'multiple') {
                    $mulitple_attr = 'multiple';
                }

                $output .= '<select class="dtsl-sf-field dtsl-sf-countystate '.esc_attr($additional_class).' dtsl-chosen-select" name="dtsl_sf_countystate" data-placeholder="'.esc_attr($placeholder_text).'" '.esc_attr($mulitple_attr).'>';
                    if($mulitple_attr == '') {
                        $output .= '<option value="">'.esc_attr($placeholder_text).'</option>';
                    }

                    $countiesstates_args = array (
                        'taxonomy'   => 'dtsl_listings_countystate',
                        'hide_empty' => 1,
                    );

                    if($attrs['child_of'] != '') {
                        $countiesstates_args['child_of'] = $attrs['child_of'];
                    } else {
                        $countiesstates_args['parent'] = 0;
                    }
                    $listing_countiesstates = get_categories($countiesstates_args);

                    if(isset($listing_countiesstates)) {
                        foreach($listing_countiesstates as $listing_countystate) {
                            $selected_attr = '';
                            if(in_array($listing_countystate->term_id, $dtsl_sf_countystate)) {
                                $selected_attr = 'selected="selected"';
                            }
                            $output .= '<option value="'.esc_attr($listing_countystate->term_id).'" '.$selected_attr.'>'.esc_html($listing_countystate->name).'</option>';

                            if($attrs['show_parent_items_alone'] != 'true') {

                                // Child Items
                                $listing_countystate_childs = get_categories('taxonomy=dtsl_listings_category&hide_empty=1&child_of='.$listing_countystate->term_id);
                                if(is_array($listing_countystate_childs) && !empty($listing_countystate_childs)) {
                                    foreach($listing_countystate_childs as $listing_countystate_child) {
                                        $selected_attr = '';
                                        if(in_array($listing_countystate_child->term_id, $dtsl_sf_countystate)) {
                                            $selected_attr = 'selected="selected"';
                                        }
                                        $output .= '<option value="'.esc_attr($listing_countystate_child->term_id).'" '.$selected_attr.'>'."&emsp;".esc_html($listing_countystate_child->name).'</option>';
                                    }
                                }

                            }

                        }
                    }
                $output .= '</select>';

            } else {

                $output .= '<ul>';
                    $listing_countiesstates = get_categories('taxonomy=dtsl_listings_countystate&hide_empty=1');
                    if(isset($listing_countiesstates)) {
                        foreach($listing_countiesstates as $listing_countystate) {
                            $output .= '<li>
                                            <input type="checkbox" name="dtsl_sf_countystate[]" class="dtsl-sf-field dtsl-sf-countystate '.esc_attr($additional_class).'" value="'.esc_attr($listing_countystate->term_id).'" id="dtsl-sf-countystate-'.esc_attr($listing_countystate->term_id).'" '.checked(in_array($listing_countystate->term_id, $dtsl_sf_countystate), true, false).' />
                                            <label for="dtsl-sf-countystate-'.esc_attr($listing_countystate->term_id).'">'.esc_html($listing_countystate->name).'</label>
                                        </li>';
                        }
                    }
                $output .= '</ul>';

            }

        $output .= '</div>';

        return $output;

    }
    add_shortcode ( 'dtsl_sf_countystate_field', 'dtsl_sf_countystate_field' );
}

// Countries
if(!function_exists('dtsl_sf_countries_field')) {
    function dtsl_sf_countries_field( $attrs, $content = null ) {

        $attrs = shortcode_atts ( array (

                    'field_type' => '',
                    'placeholder_text' => '',
                    'dropdown_type' => '',
                    'ajax_load' => '',
                    'class' => '',

                ), $attrs, 'dtsl_sf_countries_field' );


        $output = '';

        $output .= '<div class="dtsl-sf-fields-holder dtsl-sf-countries-field-holder '.$attrs['class'].'">';

            $additional_class = '';
            if($attrs['ajax_load'] == 'true') {
                $additional_class = 'dtsl-with-ajax-load';
            }

            $dtsl_sf_countries = array ();
            if(isset($_REQUEST['dtsl_sf_countries'])) {
                if(is_array($_REQUEST['dtsl_sf_countries']) && !empty($_REQUEST['dtsl_sf_countries'])) {
                    $dtsl_sf_countries = dtsl_recursive_sanitize_text_field($_REQUEST['dtsl_sf_countries']);
                } else if($_REQUEST['dtsl_sf_countries'] != '') {
                    $dtsl_sf_countries = explode(',', dtsl_recursive_sanitize_text_field($_REQUEST['dtsl_sf_countries']));
                }
            }

            $placeholder_text = esc_html__('Countries', 'dtsl');
            if($attrs['placeholder_text'] != '') {
                $placeholder_text = esc_html($attrs['placeholder_text']);
            }

            if($attrs['field_type'] == 'dropdown') {

                $mulitple_attr = '';
                if($attrs['dropdown_type'] == 'multiple') {
                    $mulitple_attr = 'multiple';
                }

                $output .= '<select class="dtsl-sf-field dtsl-sf-countries '.esc_attr($additional_class).' dtsl-chosen-select" name="dtsl_sf_countries" data-placeholder="'.esc_attr($placeholder_text).'" '.esc_attr($mulitple_attr).'>';
                    if($mulitple_attr == '') {
                        $output .= '<option value="">'.esc_attr($placeholder_text).'</option>';
                    }
                    $listing_countries = dtsl_countries_list(false);
                        if(isset($listing_countries)) {
                            foreach($listing_countries as $listing_country_key => $listing_country) {
                                $selected_attr = '';
                                if(in_array($listing_country_key, $dtsl_sf_countries)) {
                                    $selected_attr = 'selected="selected"';
                                }
                                $output .= '<option value="'.esc_attr($listing_country_key).'" '.$selected_attr.'>'.esc_html($listing_country).'</option>';
                            }
                        }
                $output .= '</select>';

            } else {

                $output .= '<ul>';
                    $listing_countries = dtsl_countries_list(false);
                    if(isset($listing_countries)) {
                        foreach($listing_countries as $listing_country_key => $listing_country) {
                            $output .= '<li>
                                            <input type="checkbox" name="dtsl_sf_countries[]" class="dtsl-sf-field dtsl-sf-countries '.esc_attr($additional_class).'" value="'.esc_attr($listing_country_key).'" id="dtsl-sf-countries-'.esc_attr($listing_country_key).'" '.checked(in_array($listing_country_key, $dtsl_sf_countries), true, false).' />
                                            <label for="dtsl-sf-countries-'.esc_attr($listing_country_key).'">'.esc_html($listing_country).'</label>
                                        </li>';
                        }
                    }
                $output .= '</ul>';

            }

        $output .= '</div>';

        return $output;

    }
    add_shortcode ( 'dtsl_sf_countries_field', 'dtsl_sf_countries_field' );
}

?>