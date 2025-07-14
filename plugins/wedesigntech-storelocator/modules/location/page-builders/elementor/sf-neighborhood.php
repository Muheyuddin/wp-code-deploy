<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTStoreLocatorSfNeighborhood extends Widget_Base {

	public function get_categories() {
		return [ 'dtsl-searchform-widgets' ];
	}

	public function get_name() {
		return 'dtsl-widget-sf-neighborhood';
	}

	public function get_title() {
		return esc_html__( 'Neighborhood', 'dtsl' );
	}

	public function get_style_depends() {
		return array ( 'chosen', 'dtsl-location-search' );
	}

	public function get_script_depends() {
		return array ( 'chosen', 'dtsl-location-search' );
	}
	protected function _register_controls() {

		$this->start_controls_section( 'neighborhood_default_section', array(
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

			$this->add_control( 'dropdown_type', array(
				'label'       => esc_html__( 'Dropdown Type', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					''         => esc_html__('Single', 'dtsl'),
					'multiple' => esc_html__('Multiple', 'dtsl'),
				),
				'description' => esc_html__( 'Choose type of dropdown you like to use.', 'dtsl' ),
				'condition'   => array( 'field_type' => 'dropdown' ),
				'default'      => ''
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

			$this->add_control( 'default_item_id', array(
				'label'   => esc_html__( 'Default Item Id', 'dtsl' ),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'Set item id here, by default it will be set.', 'dtsl' ),
				'default' => ''
			) );

			$this->add_control( 'show_parent_items_alone', array(
				'label'       => esc_html__( 'Show Parent Items Alone', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtsl'),
					'true'  => esc_html__('True', 'dtsl'),
				),
				'description' => esc_html__( 'If you like to show parent items alone choose "True".', 'dtsl' ),
				'default'      => 'false'
			) );

			$this->add_control( 'child_of', array(
				'label'   => esc_html__( 'Child Of', 'dtsl' ),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'If you like to show child of any parent item, provide id of your taxonomy here.', 'dtsl' ),
				'condition'   => array( 'show_parent_items_alone' =>'false' ),
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
		echo do_shortcode('[dtsl_sf_neighborhood_field '.$attributes.' /]');

	}

}