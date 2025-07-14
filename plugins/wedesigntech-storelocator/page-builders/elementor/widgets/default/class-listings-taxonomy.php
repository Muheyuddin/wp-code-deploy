<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTStoreLocatorDfListingsTaxonomy extends Widget_Base {

	public function get_categories() {
		return [ 'dtsl-default-widgets' ];
	}

	public function get_name() {
		return 'dtsl-widget-df-listings-taxonomy';
	}

	public function get_title() {
		$listing_plural_label = apply_filters( 'dt_sl_listing_label', 'plural' );
		return sprintf( esc_html__('%1$s Taxonomy', 'dtsl'), $listing_plural_label );
	}

	public function get_style_depends() {
		return array ( 'dtsl-modules-default' );
	}

	public function get_script_depends() {
		return array ( 'dtsl-frontend' );
	}

	protected function _register_controls() {

		$dt_sl_listing_singular_label      = apply_filters( 'dt_sl_listing_label', 'singular' );
		$listing_plural_label        = apply_filters( 'dt_sl_listing_label', 'plural' );

		$taxonomies = apply_filters( 'dtsl_taxonomies', array () );

		$this->start_controls_section( 'listings_taxonomy_default_section', array(
			'label' => esc_html__( 'General', 'dtsl' ),
		) );

			$this->add_control( 'taxonomy', array(
				'label'       => esc_html__( 'Taxonomy', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => $taxonomies,
				'description' => esc_html__( 'Choose type of taxonomy you would like to display.', 'dtsl' ),
				'default'      => 'dtsl_listings_category',
			) );

			$this->add_control( 'type', array(
				'label'       => esc_html__( 'Type', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'type1' => esc_html__('Type 1', 'dtsl'),
					'type2' => esc_html__('Type 2', 'dtsl'),
					'type3' => esc_html__('Type 3', 'dtsl'),
					'type4' => esc_html__('Type 4', 'dtsl'),
					'type5' => esc_html__('Type 5', 'dtsl'),
					'type6' => esc_html__('Type 6', 'dtsl'),
					'type7' => esc_html__('Type 7', 'dtsl')
				),
				'description' => esc_html__( 'Choose type of taxonomy to display.', 'dtsl' ),
				'default'      => 'type1',
			) );

			$this->add_control( 'media_type', array(
				'label'       => esc_html__( 'Media Type', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'image'      => esc_html__('Image', 'dtsl'),
					'icon'       => esc_html__('Icon', 'dtsl'),
					'icon_image' => esc_html__('Icon Image', 'dtsl')
				),
				'description' => esc_html__( 'Choose whether to display image or icon.', 'dtsl' ),
				'condition'   => array( 'type' => array ('type1', 'type2', 'type3', 'type4') ),
				'default'      => 'image',
			) );

			$this->add_control( 'columns', array(
				'label'       => esc_html__( 'Columns', 'dtsl' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					''  => esc_html__('None', 'dtsl'),
					1  => esc_html__('I Column', 'dtsl'),
					2  => esc_html__('II Columns', 'dtsl'),
					3  => esc_html__('III Columns', 'dtsl')
				),
				'description' => esc_html__( 'Number of columns you like to display your taxonomies.', 'dtsl' ),
				'default'      => '',
			) );

			$this->add_control( 'include', array(
				'label'   => esc_html__( 'Include', 'dtsl' ),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'List of taxonomy ids separated by commas.', 'dtsl' ),
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
		echo do_shortcode('[dtsl_listings_taxonomy '.$attributes.' /]');

	}

}