<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTStoreLocatorSfFeatures extends Widget_Base {

	public function get_categories() {
		return [ 'dtsl-searchform-widgets' ];
	}

	public function get_name() {
		return 'dtsl-widget-sf-features';
	}

	public function get_title() {
		return esc_html__( 'Features', 'dtsl' );
	}

	public function get_style_depends() {
		return array ( 'jquery-ui', 'chosen', 'dtsl-fields', 'dtsl-search-frontend');
	}

	public function get_script_depends() {
		return array ( 'jquery-ui-slider', 'chosen', 'dtsl-search-frontend');
	}

	protected function _register_controls() {

		$this->start_controls_section( 'features_default_section', array(
			'label' => esc_html__( 'General', 'dtsl' ),
		) );

            $this->add_control( 'tab_id', array(
                'label'   => esc_html__( 'Tab Id', 'dtsl' ),
                'type'    => Controls_Manager::TEXT,
                'description' => esc_html__( 'Provide tab id for features item that you want to use in search form. Without this tab id shortcode doesn\'t work.', 'dtsl' ),
                'default' => ''
            ) );

            $this->add_control( 'field_type', array(
                'label'       => esc_html__( 'Field Type', 'dtsl' ),
                'type'        => Controls_Manager::SELECT,
                'options'     => array(
                    'range'    => esc_html__('Range', 'dtsl'),
                    'list'     => esc_html__('List', 'dtsl'),
                    'dropdown' => esc_html__('Dropdown', 'dtsl'),
                ),
                'description' => esc_html__('Choose field type that you like to use for this feature item.', 'dtsl'),
                'default'      => 'range'
            ) );

			$this->add_control( 'placeholder_text', array(
				'label'       => esc_html__( 'Placeholder Text', 'dtsl' ),
				'type'        => Controls_Manager::TEXT,
                'description' => esc_html__( 'You can provide your own text for placeholder of this item.', 'dtsl' ),
                'condition'   => array( 'field_type' => 'dropdown' ),
				'default'     => ''
			) );

            $this->add_control( 'min_value', array(
				'label'   => esc_html__( 'Minimum Value', 'dtsl' ),
				'type'    => Controls_Manager::TEXT,
                'description' => esc_html__( 'Set minimum value range.', 'dtsl' ),
                'condition'   => array( 'field_type' => 'range' ),
				'default' => 1
            ) );

            $this->add_control( 'max_value', array(
				'label'   => esc_html__( 'Maximum Value', 'dtsl' ),
				'type'    => Controls_Manager::TEXT,
                'description' => esc_html__( 'Set maximum value range.', 'dtsl' ),
                'condition'   => array( 'field_type' => 'range' ),
				'default' => 100
            ) );

            $this->add_control( 'dropdownlist_options', array(
				'label'   => esc_html__( 'Dropdown Options', 'dtsl' ),
				'type'    => Controls_Manager::TEXTAREA,
                'description' => esc_html__('Add dropdown options in comma separated values.', 'dtsl'),
                'condition'   => array( 'field_type' => array ('dropdown', 'list') ),
				'default' => ''
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

            $this->add_control( 'item_unit', array(
				'label'   => esc_html__( 'Item Unit', 'dtsl' ),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'You can provide item unit for your label here.', 'dtsl' ),
				'default' => ''
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
		echo do_shortcode('[dtsl_sf_features_field '.$attributes.' /]');

	}

}