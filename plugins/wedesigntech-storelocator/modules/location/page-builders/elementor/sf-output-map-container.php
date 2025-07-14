<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTStoreLocatorSfOutputMapContainer extends Widget_Base {

	public function get_categories() {
		return [ 'dtsl-searchform-widgets' ];
	}

	public function get_name() {
		return 'dtsl-widget-sf-output-map-container';
	}

	public function get_title() {
		return esc_html__( 'Output Map Container', 'dtsl' );
	}

	public function get_style_depends() {
		return array ('swiper', 'dtsl-location-frontend');
	}

	public function get_script_depends() {
		return array ('swiper', 'dtsl-map', 'dtsl-frontend');
	}

	protected function _register_controls() {

        $dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );

		$this->start_controls_section( 'output_map_container_default_section', array(
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

            $this->add_control( 'gallery', array(
                'label'       => esc_html__( 'Gallery', 'dtsl' ),
                'type'        => Controls_Manager::SELECT,
                'options'     => array(
                    'featured_image'        => esc_html__('Featured Image', 'dtsl'),
                    'image_gallery'         => esc_html__('Image Gallery', 'dtsl'),
                    'gallery_with_featured' => esc_html__('Image Gallery With Featured Image', 'dtsl'),
                ),
                'description' => esc_html__( 'Choose how you like to display image gallery.', 'dtsl' ),
                'default'      => 'featured_image',
            ) );

            $this->add_control( 'additional_info', array(
                'label'       => esc_html__( 'Additional Info', 'dtsl' ),
                'type'        => Controls_Manager::SELECT,
                'options'     => array(
                    ''               => esc_html__('None', 'dtsl'),
                    'totalviews'     => esc_html__('Total Views', 'dtsl'),
                    'averageratings' => esc_html__('Average Ratings', 'dtsl'),
                    'categoryimage'  => esc_html__('Category Image', 'dtsl'),
                    'categoryicon'   => esc_html__('Category Icon', 'dtsl'),
                    'distance'       => esc_html__('Distance', 'dtsl'),
                ),
                'description' => esc_html__( 'Choose additional info that you like to display along with location marker.', 'dtsl' ),
                'default'      => '',
            ) );

            $this->add_control( 'category_background_color', array(
                'label'       => esc_html__( 'Background Color', 'dtsl' ),
                'type'        => Controls_Manager::COLOR,
                'description' => esc_html__( 'Select background color for your icon. icon will be taken from the category settings.', 'dtsl' ),
                'condition'   => array( 'additional_info' => array ('categoryimage', 'categoryicon') )
            ) );

            $this->add_control( 'category_color', array(
                'label'       => esc_html__( 'Color', 'dtsl' ),
                'type'        => Controls_Manager::COLOR,
                'description' => esc_html__( 'Select background color for your icon. icon will be taken from the category settings.', 'dtsl' ),
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

        $this->start_controls_section( 'output_map_container_filter_section', array(
			'label' => esc_html__( 'Filter Options', 'dtsl' ),
		) );

			$this->add_control( 'category_ids', array(
				'label'   => sprintf( esc_html__('%1$s Category Ids', 'dtsl'), $dt_sl_listing_singular_label ),
				'type'    => Controls_Manager::TEXT,
				'description' => sprintf( esc_html__( 'Enter %1$s category ids separated by commas.', 'dtsl' ), $dt_sl_listing_singular_label ),
				'default' => ''
			) );

        $this->end_controls_section();

        $this->start_controls_section( 'output_map_container_style_section', array(
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
		echo do_shortcode('[dtsl_sf_output_map_container '.$attributes.']'.$map_style_script.'[/dtsl_sf_output_map_container]');

	}

}