<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTStoreLocatorSfOrderBy extends Widget_Base {

	public function get_categories() {
		return [ 'dtsl-searchform-widgets' ];
	}

	public function get_name() {
		return 'dtsl-widget-sf-orderby';
	}

	public function get_title() {
		return esc_html__( 'Order By', 'dtsl' );
	}

	public function get_style_depends() {
		return array ( 'dtsl-fields', 'dtsl-search-frontend');
	}

	public function get_script_depends() {
		return array ( 'dtsl-search-frontend');
	}

	protected function _register_controls() {

		$this->start_controls_section( 'orderby_default_section', array(
			'label' => esc_html__( 'General', 'dtsl' ),
		) );

            $this->add_control( 'field_type', array(
                'label'       => esc_html__( 'Field Type', 'dtsl' ),
                'type'        => Controls_Manager::SELECT,
                'options'     => array(
                    ''         => esc_html__('List', 'dtsl'),
                    'dropdown' => esc_html__('Dropdown', 'dtsl'),
                ),
                'description' => esc_html__( 'Choose type of field you like to use.', 'dtsl' ),
                'default'      => ''
            ) );

			$this->add_control( 'placeholder_text', array(
				'label'       => esc_html__( 'Placeholder Text', 'dtsl' ),
				'type'        => Controls_Manager::TEXT,
                'description' => esc_html__( 'You can provide your own text for placeholder of this item.', 'dtsl' ),
                'condition'   => array( 'field_type' => 'dropdown' ),
				'default'     => ''
			) );

			$this->add_control( 'alphabetical_order', array(
				'label'       => esc_html__( 'Alphabetical Order', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtsl'),
					'true'  => esc_html__('True', 'dtsl'),
				),
				'description' => esc_html__('Choose "True" if you like to enable alphabetical order.', 'dtsl'),
				'default'      => 'true'
			) );

			$this->add_control( 'highestrated_order', array(
				'label'       => esc_html__( 'Highest Rated Order', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtsl'),
					'true'  => esc_html__('True', 'dtsl'),
				),
				'description' => esc_html__('Choose "True" if you like to enable highest rated order.', 'dtsl'),
				'default'      => 'true'
			) );

			$this->add_control( 'mostreviewed_order', array(
				'label'       => esc_html__( 'Most Reviewed Order', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtsl'),
					'true'  => esc_html__('True', 'dtsl'),
				),
				'description' => esc_html__('Choose "True" if you like to enable most reviewed order.', 'dtsl'),
				'default'      => 'true'
			) );

			$this->add_control( 'mostviewed_order', array(
				'label'       => esc_html__( 'Most Viewed Order', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtsl'),
					'true'  => esc_html__('True', 'dtsl'),
				),
				'description' => esc_html__('Choose "True" if you like to enable most viewed order.', 'dtsl'),
				'default'      => 'true'
			) );

			$this->add_control( 'ajax_load', array(
				'label'       => esc_html__( 'Ajax Load', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtsl'),
					'true'  => esc_html__('True', 'dtsl'),
				),
				'description' => esc_html__('If you want to display the output in same page choose "True" here.', 'dtsl'),
				'default'      => 'false'
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
		echo do_shortcode('[dtsl_sf_orderby_field '.$attributes.' /]');

	}

}