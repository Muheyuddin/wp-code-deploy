<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTDirectorySpEventDates extends Widget_Base {

	public function get_categories() {
		return [ 'dtdr-singlepage-widgets' ];
	}

	public function get_name() {
		return 'dtdr-widget-sp-event-dates';
	}

	public function get_title() {
		return esc_html__( 'Event Dates', 'dtdr' );
	}

	public function get_style_depends() {
		return array ('dtdr-events-frontend');
	}

	public function get_script_depends() {
		return array ();
	}

	protected function register_controls() {

		$listing_singular_label = apply_filters( 'listing_label', 'singular' );

		$this->start_controls_section( 'event_dates_default_section', array(
			'label' => esc_html__( 'General', 'dtdr' ),
		) );

			$this->add_control( 'listing_id', array(
				'label'       => sprintf( esc_html__('%1$s Id', 'dtdr'), $listing_singular_label ),
				'type'        => Controls_Manager::TEXT,
				'description' => sprintf( esc_html__('Provide %1$s id to display your item. No need to provide ID if it is used in %1$s single page.', 'dtdr'), strtolower($listing_singular_label) ),
				'default'     => ''
			) );

			$this->add_control( 'type', array(
				'label'       => esc_html__( 'Type', 'dtdr' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'type1' => esc_html__('Type 1', 'dtdr'),
					'type2' => esc_html__('Type 2', 'dtdr'),
					'type3' => esc_html__('Type 3', 'dtdr'),
					'type4' => esc_html__('Type 4', 'dtdr'),
					'type5' => esc_html__('Type 5', 'dtdr')
				),
				'description' => esc_html__( 'Choose any of the available type.', 'dtdr' ),
				'default'      => 'type1',
			) );

			$this->add_control( 'include_startdate', array(
				'label'       => esc_html__( 'Include Start Date', 'dtdr' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtdr'),
					'true'  => esc_html__('True', 'dtdr'),
				),
				'description' => esc_html__('Choose "True" if you like to display start date in this shortcode. If "Merge Date" option is chosen "Start Date" will be included automatically.', 'dtdr'),
				'default'      => 'false'
			) );

			$this->add_control( 'include_enddate', array(
				'label'       => esc_html__( 'Include End Date', 'dtdr' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtdr'),
					'true'  => esc_html__('True', 'dtdr'),
				),
				'description' => esc_html__('Choose "True" if you like to display start date in this shortcode. If "Merge Date" option is chosen "End Date" will be included automatically.', 'dtdr'),
				'default'      => 'false'
			) );

			$this->add_control( 'include_starttime', array(
				'label'       => esc_html__( 'Include Start Time', 'dtdr' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtdr'),
					'true'  => esc_html__('True', 'dtdr'),
				),
				'description' => esc_html__('Choose "True" if you like to display start time along with date.', 'dtdr'),
				'default'      => 'false'
			) );

			$this->add_control( 'include_endtime', array(
				'label'       => esc_html__( 'Include End Time', 'dtdr' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtdr'),
					'true'  => esc_html__('True', 'dtdr'),
				),
				'description' => esc_html__('Choose "True" if you like to display end time along with date.', 'dtdr'),
				'default'      => 'false'
			) );

			$this->add_control( 'include_postdate', array(
				'label'       => esc_html__( 'Include Post Date', 'dtdr' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtdr'),
					'true'  => esc_html__('True', 'dtdr'),
				),
				'description' => esc_html__('Choose "True" if you like to display post date in this shortcode.', 'dtdr'),
				'default'      => 'false'
			) );

			$this->add_control( 'include_posttime', array(
				'label'       => esc_html__( 'Include Post Time', 'dtdr' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtdr'),
					'true'  => esc_html__('True', 'dtdr'),
				),
				'description' => esc_html__('Choose "True" if you like to display post time along with date.', 'dtdr'),
				'default'      => 'false'
			) );

			$this->add_control( 'with_label', array(
				'label'       => esc_html__( 'With Label', 'dtdr' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtdr'),
					'true'  => esc_html__('True', 'dtdr'),
				),
				'description' => esc_html__('Choose "True" if you like to display label along with date.', 'dtdr'),
				'default'      => 'false'
			) );

			$this->add_control( 'with_icon', array(
				'label'       => esc_html__( 'With Icon', 'dtdr' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtdr'),
					'true'  => esc_html__('True', 'dtdr'),
				),
				'description' => esc_html__('Choose "True" if you like to display icon along with date.', 'dtdr'),
				'default'      => 'false'
			) );

			$this->add_control( 'merge_dates', array(
				'label'       => esc_html__( 'Merge Dates', 'dtdr' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtdr'),
					'true'  => esc_html__('True', 'dtdr'),
				),
				'description' => esc_html__('Choose "True" if you like to merge start and end dates.', 'dtdr'),
				'default'      => 'false'
			) );

			$this->add_control( 'class', array(
				'label'   => esc_html__( 'Class', 'dtdr' ),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'If you wish you can add additional class name here.', 'dtdr' ),
				'default' => ''
			) );

		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings();
		$attributes = dtdirectory_elementor_instance()->dtdr_parse_shortcode_attrs( $settings );
		echo do_shortcode('[dtdr_sp_event_dates '.$attributes.' /]');

	}

}