<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTDirectorySfOrderBy extends Widget_Base {

	public function get_categories() {
		return [ 'dtdr-searchform-widgets' ];
	}

	public function get_name() {
		return 'dtdr-widget-sf-orderby';
	}

	public function get_title() {
		return esc_html__( 'Order By', 'dtdr' );
	}

	public function get_style_depends() {
		return array ( 'dtdr-fields', 'dtdr-search-frontend');
	}

	public function get_script_depends() {
		return array ( 'dtdr-search-frontend');
	}

	protected function register_controls() {

		$this->start_controls_section( 'orderby_default_section', array(
			'label' => esc_html__( 'General', 'dtdr' ),
		) );

            $this->add_control( 'field_type', array(
                'label'       => esc_html__( 'Field Type', 'dtdr' ),
                'type'        => Controls_Manager::SELECT,
                'options'     => array(
                    ''         => esc_html__('List', 'dtdr'),
                    'dropdown' => esc_html__('Dropdown', 'dtdr'),
                ),
                'description' => esc_html__( 'Choose type of field you like to use.', 'dtdr' ),
                'default'      => ''
            ) );

			$this->add_control( 'placeholder_text', array(
				'label'       => esc_html__( 'Placeholder Text', 'dtdr' ),
				'type'        => Controls_Manager::TEXT,
                'description' => esc_html__( 'You can provide your own text for placeholder of this item.', 'dtdr' ),
                'condition'   => array( 'field_type' => 'dropdown' ),
				'default'     => ''
			) );

			$this->add_control( 'alphabetical_order', array(
				'label'       => esc_html__( 'Alphabetical Order', 'dtdr' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtdr'),
					'true'  => esc_html__('True', 'dtdr'),
				),
				'description' => esc_html__('Choose "True" if you like to enable alphabetical order.', 'dtdr'),
				'default'      => 'true'
			) );

			$this->add_control( 'highestrated_order', array(
				'label'       => esc_html__( 'Highest Rated Order', 'dtdr' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtdr'),
					'true'  => esc_html__('True', 'dtdr'),
				),
				'description' => esc_html__('Choose "True" if you like to enable highest rated order.', 'dtdr'),
				'default'      => 'true'
			) );

			$this->add_control( 'mostreviewed_order', array(
				'label'       => esc_html__( 'Most Reviewed Order', 'dtdr' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtdr'),
					'true'  => esc_html__('True', 'dtdr'),
				),
				'description' => esc_html__('Choose "True" if you like to enable most reviewed order.', 'dtdr'),
				'default'      => 'true'
			) );

			$this->add_control( 'mostviewed_order', array(
				'label'       => esc_html__( 'Most Viewed Order', 'dtdr' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtdr'),
					'true'  => esc_html__('True', 'dtdr'),
				),
				'description' => esc_html__('Choose "True" if you like to enable most viewed order.', 'dtdr'),
				'default'      => 'true'
			) );

			$this->add_control( 'ajax_load', array(
				'label'       => esc_html__( 'Ajax Load', 'dtdr' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtdr'),
					'true'  => esc_html__('True', 'dtdr'),
				),
				'description' => esc_html__('If you want to display the output in same page choose "True" here.', 'dtdr'),
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
		echo do_shortcode('[dtdr_sf_orderby_field '.$attributes.' /]');

	}

}