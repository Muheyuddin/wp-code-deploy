<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTStoreLocatorDfListingsMap extends Widget_Base {

	public function get_categories() {
		return [ 'dtsl-default-widgets' ];
	}

	public function get_name() {
		return 'dtsl-widget-df-listings-map';
	}

	public function get_title() {
		$listing_plural_label = apply_filters( 'dt_sl_listing_label', 'plural' );
		return sprintf( esc_html__('%1$s Map', 'dtsl'), $listing_plural_label );
	}

	public function get_style_depends() {
		return array ('swiper', 'dtsl-location-frontend');
	}

	public function get_script_depends() {
		return array ('swiper', 'dtsl-map', 'dtsl-location-frontend');
	}

	protected function _register_controls() {

		$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );
		$dt_sl_contracttype_singular_label = apply_filters( 'dt_sl_contracttype_label', 'singular' );
		$contracttype_plural_label = apply_filters( 'dt_sl_contracttype_label', 'plural' );
		$seller_singular_label = apply_filters( 'dt_sl_seller_label', 'singular' );
		$incharge_singular_label = apply_filters( 'dt_sl_incharge_label', 'singular' );

		$countries_list = dtsl_countries_list(false);
		$countries_list = array('' => esc_html__('All', 'dtsl')) + $countries_list;

		$this->start_controls_section( 'listings_map_default_section', array(
			'label' => esc_html__( 'General', 'dtsl' ),
		) );

			$this->add_control( 'type', array(
				'label'       => esc_html__( 'Type', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'type1' => esc_html__('Type 1', 'dtsl'),
					'type2' => esc_html__('Type 2', 'dtsl'),
					'type3' => esc_html__('Type 3', 'dtsl'),
					'type4' => esc_html__('Type 4', 'dtsl'),
                    'type5' => esc_html__('Type 5', 'dtsl')
				),
				'description' => esc_html__('Choose type of layout you like to display.', 'dtsl'),
				'default'      => 'type1',
			) );

			$this->add_control( 'additional_info', array(
				'label'       => esc_html__( 'Additional Info', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					''               => esc_html__('None', 'dtsl'),
					'totalviews'     => esc_html__('Total Views', 'dtsl'),
					'averageratings' => esc_html__('Average Ratings', 'dtsl'),
					'categoryimage'  => esc_html__('Category Image', 'dtsl'),
					'categoryicon'  => esc_html__('Category Icon', 'dtsl')
				),
				'description' => esc_html__( 'Choose additional info that you like to display along with location marker. ', 'dtsl' ),
				'default'      => '',
			) );

			$this->add_control( 'category_background_color', array(
				'label'       => esc_html__( 'Background Color', 'dtsl' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select background color for your Category Icon. Icon will be taken from the category settings.', 'dtsl' ),
				'condition'   => array( 'additional_info' => array ('categoryimage', 'categoryicon') )
			) );

			$this->add_control( 'category_color', array(
				'label'       => esc_html__( 'Color', 'dtsl' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select background color for your Category Image / Icon. Image / Icon will be taken from the category settings.', 'dtsl' ),
				'condition'   => array( 'additional_info' => array ('categoryimage', 'categoryicon') )
			) );

			$this->add_control( 'zoom_level', array(
				'label'   => esc_html__( 'Zoom Level', 'dtsl' ),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'Add map zoom level here. This will overwrite the default map zoom level. Ex: ... 9, 10, 11...', 'dtsl' ),
				'default' => ''
			) );

			$this->add_control( 'map_type', array(
				'label'       => esc_html__( 'Map Type', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					''          => esc_html__('Default', 'dtsl'),
					'SATELLITE' => esc_html__('SATELLITE', 'dtsl'),
					'HYBRID'    => esc_html__('HYBRID', 'dtsl'),
					'TERRAIN'   => esc_html__('TERRAIN', 'dtsl'),
					'ROADMAP'   => esc_html__('ROADMAP', 'dtsl'),
				),
				'description' => esc_html__( 'Choose map type for this item.', 'dtsl' ),
				'default'      => '',
			) );

            $this->add_responsive_control( 'height', array(
                'label' => esc_html__( 'Height', 'dtsl' ),
                'type' => Controls_Manager::TEXT,
                'description' => esc_html__( 'Provide height for your map in "px" here.', 'dtsl' ),
                'devices' => array( 'desktop', 'tablet', 'mobile' ),
                'selectors' => array(
					'{{WRAPPER}} .dtsl-listing-output-map' => 'height: {{SIZE}}px;',
				),
            ) );

			$this->add_control( 'marker_animation', array(
                'label'       => esc_html__( 'Marker Animation', 'dtsl' ),
                'type'        => Controls_Manager::SELECT,
                'options'     => array(
                    'false' => esc_html__('False', 'dtsl'),
                    'true' => esc_html__('True', 'dtsl'),
                ),
                'description' => esc_html__( 'Choose true if your like to have animation for your map marker.', 'dtsl' ),
                'default'      => 'false',
            ) );

			$this->add_control( 'class', array(
				'label'   => esc_html__( 'Class', 'dtsl' ),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'If you wish you can add additional class name here.', 'dtsl' ),
				'default' => ''
			) );

		$this->end_controls_section();


		$this->start_controls_section( 'listings_map_filter_section', array(
			'label' => esc_html__( 'Filter Options', 'dtsl' ),
		) );

			$this->add_control( 'list_item_ids', array(
				'label'   => sprintf( esc_html__('%1$s Item Ids', 'dtsl'), $dt_sl_listing_singular_label ),
				'type'    => Controls_Manager::TEXT,
				'description' => sprintf( esc_html__( 'Enter %1$s item ids separated by commas.', 'dtsl' ), $dt_sl_listing_singular_label ),
				'default' => ''
			) );

			$this->add_control( 'category_ids', array(
				'label'   => sprintf( esc_html__('%1$s Category Ids', 'dtsl'), $dt_sl_listing_singular_label ),
				'type'    => Controls_Manager::TEXT,
				'description' => sprintf( esc_html__( 'Enter %1$s category ids separated by commas.', 'dtsl' ), $dt_sl_listing_singular_label ),
				'default' => ''
			) );

			$this->add_control( 'cities_ids', array(
				'label'   => sprintf( esc_html__('%1$s Cities Ids', 'dtsl'), $dt_sl_listing_singular_label ),
				'type'    => Controls_Manager::TEXT,
				'description' => sprintf( esc_html__( 'Enter %1$s cities ids separated by commas.', 'dtsl' ), $dt_sl_listing_singular_label ),
				'default' => ''
			) );

			$this->add_control( 'neighborhoods_ids', array(
				'label'   => sprintf( esc_html__('%1$s Neighborhoods Ids', 'dtsl'), $dt_sl_listing_singular_label ),
				'type'    => Controls_Manager::TEXT,
				'description' => sprintf( esc_html__( 'Enter %1$s neighborhoods ids separated by commas.', 'dtsl' ), $dt_sl_listing_singular_label ),
				'default' => ''
			) );

			$this->add_control( 'countiesstates_ids', array(
				'label'   => sprintf( esc_html__('%1$s Counties / States Ids', 'dtsl'), $dt_sl_listing_singular_label ),
				'type'    => Controls_Manager::TEXT,
				'description' => sprintf( esc_html__( 'Enter %1$s counties / states ids separated by commas.', 'dtsl' ), $dt_sl_listing_singular_label ),
				'default' => ''
			) );

			$this->add_control( 'contracttypes_ids', array(
				'label'   => sprintf( esc_html__('%1$s %2$s', 'dtsl'), $dt_sl_listing_singular_label, $contracttype_plural_label ),
				'type'    => Controls_Manager::TEXT,
				'description' => sprintf( esc_html__('Enter %1$s ids separated by commas', 'dtsl'), $contracttype_plural_label ),
				'default' => ''
			) );

			$this->add_control( 'tag_ids', array(
				'label'   => sprintf( esc_html__('%1$s Tag Ids', 'dtsl'), $dt_sl_listing_singular_label ),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter tag ids separated by commas.', 'dtsl' ),
				'default' => ''
			) );

			$this->add_control( 'country_id', array(
				'label'   => esc_html__('Countries', 'dtsl'),
				'type'        => Controls_Manager::SELECT,
				'options'     => $countries_list,
				'description' => esc_html__( 'Choose countries for which you like to display items.', 'dtsl' ),
				'default' => ''
			) );

			$this->add_control( 'seller_ids', array(
				'label'   => sprintf( esc_html__('%1$s %2$s Ids', 'dtsl'), $dt_sl_listing_singular_label, $seller_singular_label ),
				'type'    => Controls_Manager::TEXT,
				'description' => sprintf( esc_html__('Enter %1$s ids separated by commas.', 'dtsl'), strtolower($seller_singular_label) ),
				'default' => ''
			) );

			$this->add_control( 'incharge_ids', array(
				'label'   => sprintf( esc_html__('%1$s %2$s Ids', 'dtsl'), $dt_sl_listing_singular_label, $incharge_singular_label ),
				'type'    => Controls_Manager::TEXT,
				'description' => sprintf( esc_html__('Enter %1$s ids separated by commas.', 'dtsl'), strtolower($incharge_singular_label) ),
				'default' => ''
			) );

		$this->end_controls_section();

		$this->start_controls_section( 'listings_map_style_section', array(
			'label' => esc_html__( 'Map Style', 'dtsl' ),
		) );

            $this->add_control( 'map_style_type', array(
                'label'       => esc_html__( 'Map Style', 'dtsl' ),
                'type'        => Controls_Manager::SELECT,
                'options'     => array(
                    'color' => esc_html__('Color', 'dtsl'),
                    'style' => esc_html__('Style', 'dtsl'),
                ),
                'description' => esc_html__( 'Choose map style type for this item.', 'dtsl' ),
                'default'      => 'color',
            ) );

            $this->add_control( 'map_color', array(
                'label'       => esc_html__( 'Map Color', 'dtsl' ),
                'type'        => Controls_Manager::COLOR,
                'condition'   => array( 'map_style_type' => 'color' ),
                'description' => esc_html__( 'Select color for your map. This will override the default map color.', 'dtsl' )
            ) );

			$this->add_control( 'map_style_script', array(
				'label'   => esc_html__('Map Style Script', 'dtsl'),
				'type'    => Controls_Manager::TEXTAREA,
                'condition'   => array( 'map_style_type' => 'style' ),
				'description' => esc_html__( 'Please enter "Snazzy Maps" provided "JAVASCRIPT STYLE ARRAY" here.', 'dtsl' ),
				'default' => ''
			) );

        $this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings();
		$map_style_script = $settings['map_style_script'];
        unset($settings['map_style_script']);
		$attributes = dtstorelocator_elementor_instance()->dtsl_parse_shortcode_attrs( $settings );
		echo do_shortcode('[dtsl_listings_map '.$attributes.']'.$map_style_script.'[/dtsl_listings_map]');

	}

}