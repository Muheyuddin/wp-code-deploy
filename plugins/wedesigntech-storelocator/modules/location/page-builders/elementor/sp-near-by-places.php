<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTStoreLocatorSpNearByPlaces extends Widget_Base {

	public function get_categories() {
		return [ 'dtsl-singlepage-widgets' ];
	}

	public function get_name() {
		return 'dtsl-widget-sp-nearby-places';
	}

	public function get_title() {
		return esc_html__( 'NearBy Places', 'dtsl' );
	}

	public function get_style_depends() {
		return array ('dtsl-location-frontend');
	}

	public function get_script_depends() {
		return array ();
	}

	protected function _register_controls() {

		$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );

		$this->start_controls_section( 'nearby_places_default_section', array(
			'label' => esc_html__( 'General', 'dtsl' ),
		) );

			$this->add_control( 'listing_id', array(
				'label'       => sprintf( esc_html__('%1$s Id', 'dtsl'), $dt_sl_listing_singular_label ),
				'type'        => Controls_Manager::TEXT,
				'description' => sprintf( esc_html__('Provide %1$s id to display your item. No need to provide ID if it is used in %1$s single page.', 'dtsl'), strtolower($dt_sl_listing_singular_label) ),
				'default'     => ''
			) );

			$this->add_control( 'api_type', array(
				'label'       => esc_html__( 'API Type', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'findplacefromtext' => esc_html__('Find Place From Text', 'dtsl'),
					'nearbysearch'  => esc_html__('Near By Search', 'dtsl')
				),
				'description' => esc_html__('Which API type you would like to use ?".', 'dtsl'),
				'default'      => 'findplacefromtext',
			) );

			$this->add_control( 'media_type', array(
				'label'       => esc_html__( 'Media Type', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					''      => esc_html__( 'None', 'dtsl' ),
					'image' => esc_html__( 'Image', 'dtsl' ),
					'icon'  => esc_html__( 'Icon', 'dtsl' )
				),
				'description' => esc_html__('Choose what type of media you like to use.', 'dtsl'),
				'default'      => '',
			) );

			$this->add_control( 'place_type', array(
				'label'       => esc_html__( 'Place Type', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					''                        => '',
				    'accounting'              => 'accounting',
				    'airport'                 => 'airport',
				    'amusement_park'          => 'amusement_park',
				    'aquarium'                => 'aquarium',
				    'art_gallery'             => 'art_gallery',
				    'atm'                     => 'atm',
				    'bakery'                  => 'bakery',
				    'bank'                    => 'bank',
				    'bar'                     => 'bar',
				    'beauty_salon'            => 'beauty_salon',
				    'bicycle_store'           => 'bicycle_store',
				    'book_store'              => 'book_store',
				    'bowling_alley'           => 'bowling_alley',
				    'bus_station'             => 'bus_station',
				    'cafe'                    => 'cafe',
				    'campground'              => 'campground',
				    'car_dealer'              => 'car_dealer',
				    'car_rental'              => 'car_rental',
				    'car_repair'              => 'car_repair',
				    'car_wash'                => 'car_wash',
				    'casino'                  => 'casino',
				    'cemetery'                => 'cemetery',
				    'church'                  => 'church',
				    'city_hall'               => 'city_hall',
				    'clothing_store'          => 'clothing_store',
				    'convenience_store'       => 'convenience_store',
				    'courthouse'              => 'courthouse',
				    'dentist'                 => 'dentist',
				    'department_store'        => 'department_store',
				    'doctor'                  => 'doctor',
				    'electrician'             => 'electrician',
				    'electronics_store'       => 'electronics_store',
				    'embassy'                 => 'embassy',
				    'fire_station'            => 'fire_station',
				    'florist'                 => 'florist',
				    'funeral_home'            => 'funeral_home',
				    'furniture_store'         => 'furniture_store',
				    'gas_station'             => 'gas_station',
				    'gym'                     => 'gym',
				    'hair_care'               => 'hair_care',
				    'hardware_store'          => 'hardware_store',
				    'hindu_temple'            => 'hindu_temple',
				    'home_goods_store'        => 'home_goods_store',
				    'hospital'                => 'hospital',
				    'insurance_agency'        => 'insurance_agency',
				    'jewelry_store'           => 'jewelry_store',
				    'laundry'                 => 'laundry',
				    'lawyer'                  => 'lawyer',
				    'library'                 => 'library',
				    'liquor_store'            => 'liquor_store',
				    'local_government_office' => 'local_government_office',
				    'locksmith'               => 'locksmith',
				    'lodging'                 => 'lodging',
				    'meal_delivery'           => 'meal_delivery',
				    'meal_takeaway'           => 'meal_takeaway',
				    'mosque'                  => 'mosque',
				    'movie_rental'            => 'movie_rental',
				    'movie_theater'           => 'movie_theater',
				    'moving_company'          => 'moving_company',
				    'museum'                  => 'museum',
				    'night_club'              => 'night_club',
				    'painter'                 => 'painter',
				    'park'                    => 'park',
				    'parking'                 => 'parking',
				    'pet_store'               => 'pet_store',
				    'pharmacy'                => 'pharmacy',
				    'physiotherapist'         => 'physiotherapist',
				    'plumber'                 => 'plumber',
				    'police'                  => 'police',
				    'post_office'             => 'post_office',
				    'real_estate_agency'      => 'real_estate_agency',
				    'restaurant'              => 'restaurant',
				    'roofing_contractor'      => 'roofing_contractor',
				    'rv_park'                 => 'rv_park',
				    'school'                  => 'school',
				    'shoe_store'              => 'shoe_store',
				    'shopping_mall'           => 'shopping_mall',
				    'spa'                     => 'spa',
				    'stadium'                 => 'stadium',
				    'storage'                 => 'storage',
				    'store'                   => 'store',
				    'subway_station'          => 'subway_station',
				    'supermarket'             => 'supermarket',
				    'synagogue'               => 'synagogue',
				    'taxi_stand'              => 'taxi_stand',
				    'train_station'           => 'train_station',
				    'transit_station'         => 'transit_station',
				    'travel_agency'           => 'travel_agency',
				    'veterinary_care'         => 'veterinary_care',
				    'zoo' => 'zoo'
				),
				'description' => esc_html__('Choose places that you like to display nearby.', 'dtsl'),
				'default'      => '',
			) );

			$this->add_control( 'count', array(
				'label'       => esc_html__( 'Number Of Items to Show', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					1 => 1,
					2 => 2,
					3 => 3,
					4 => 4,
					5 => 5,
				),
				'description' => esc_html__('Total number of items to show.', 'dtsl'),
				'default'      => 2,
			) );

			$this->add_control( 'radius', array(
				'label'   => esc_html__( 'Radius ( in meters )', 'dtsl' ),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'Provide radius around which you want to search.', 'dtsl' ),
				'default' => 1000
			) );

			$this->add_control( 'api_key', array(
				'label'   => esc_html__( 'Google Map API Key', 'dtsl' ),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'If you wish you can provide separate API key here. If not API key from "Settings" will be considered.', 'dtsl' ),
				'default' => ''
			) );

			$this->add_control( 'class', array(
				'label'   => esc_html__( 'Class', 'dtsl' ),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'If you wish you can add additional class name here.', 'dtsl' ),
				'default' => ''
			) );

		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings();
		$attributes = dtstorelocator_elementor_instance()->dtsl_parse_shortcode_attrs( $settings );
		echo do_shortcode('[dtsl_sp_nearby_places '.$attributes.' /]');

	}

}