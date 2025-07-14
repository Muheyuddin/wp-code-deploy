<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTDirectoryDfPackagesListing extends Widget_Base {

	public function get_categories() {
		return [ 'dtdr-default-widgets' ];
	}

	public function get_name() {
		return 'dtdr-widget-df-packages-listing';
	}

	public function get_title() {
		return esc_html__( 'Packages Listing', 'dtdr' );
	}

	public function get_style_depends() {
		return array ('swiper', 'dtdr-packages-frontend');
	}

	public function get_script_depends() {
		return  array ('swiper', 'isotope', 'dtdr-packages-frontend');
	}

	protected function register_controls() {

		$this->start_controls_section( 'packages_listing_default_section', array(
			'label' => esc_html__( 'General', 'dtdr' ),
		) );

			$this->add_control( 'type', array(
				'label'       => esc_html__( 'Type', 'dtdr' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'type1' => esc_html__('Type 1', 'dtdr'),
					'type2' => esc_html__('Type 2', 'dtdr'),
					'type3' => esc_html__('Type 3', 'dtdr')
				),
				'description' => esc_html__('Choose type of layout you like to display.', 'dtdr'),
				'default'      => 'type1',
			) );

			$this->add_control( 'post_per_page', array(
				'label'   => esc_html__( 'Post Per Page', 'dtdr' ),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'Number of posts to show.', 'dtdr' ),
				'default' => -1
			) );

			$this->add_control( 'columns', array(
				'label'       => esc_html__( 'Columns', 'dtdr' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					1  => esc_html__('I Column', 'dtdr'),
					2  => esc_html__('II Columns', 'dtdr'),
					3  => esc_html__('III Columns', 'dtdr')
				),
				'description' => esc_html__( 'Number of columns you like to display your items.', 'dtdr' ),
				'condition'   => array( 'type' => 'type1' ),
				'default'      => 1,
			) );

			$this->add_control( 'apply_isotope', array(
				'label'       => esc_html__( 'Apply Isotope', 'dtdr' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtdr'),
					'true'  => esc_html__('True', 'dtdr'),
				),
				'description' => esc_html__('Choose true if you like to apply isotope for your items.  Isotope won\'t work along with Carousel.', 'dtdr'),
				'default'      => 'false'
			) );

			$this->add_control( 'package_type', array(
				'label'       => esc_html__( 'Package Type', 'dtdr' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					''       => esc_html__('All', 'dtdr'),
					'buyer'  => esc_html__('Buyer', 'dtdr'),
					'seller' => esc_html__('Seller', 'dtdr'),
				),
				'description' => esc_html__( 'If you wish you can display packages based on its type.', 'dtdr' ),
				'default'      => ''
			) );

			$this->add_control( 'package_item_ids', array(
				'label'       => esc_html__( 'Package Item Ids', 'dtdr' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter package item ids separated by commas.', 'dtdr' ),
				'default'      => ''
			) );

			$this->add_control( 'excerpt_length', array(
				'label'   => esc_html__( 'Excerpt Length', 'dtdr' ),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'Provide excerpt length here.', 'dtdr' ),
				'default' => 20
			) );

			$this->add_control( 'show_featured_image', array(
				'label'       => esc_html__( 'Show Featured Image', 'dtdr' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtdr'),
					'true'  => esc_html__('True', 'dtdr'),
				),
				'description' => esc_html__('Show featured image along with your items.', 'dtdr'),
				'condition'   => array( 'type' => 'type1' ),
				'default'      => 'false'
			) );

			$this->add_control( 'apply_equal_height', array(
				'label'       => esc_html__( 'Apply Equal Height', 'dtdr' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtdr'),
					'true'  => esc_html__('True', 'dtdr'),
				),
				'condition'   => array( 'apply_isotope' => 'false' ),
				'description' => esc_html__('Apply equal height for you items.', 'dtdr'),
				'default'      => 'false'
			) );

			$this->add_control( 'class', array(
				'label'   => esc_html__( 'Class', 'dtdr' ),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'If you wish you can add additional class name here.', 'dtdr' ),
				'default' => ''
			) );

		$this->end_controls_section();


		$this->start_controls_section( 'packages_listing_carousel_section', array(
			'label' => esc_html__( 'Carousel Options', 'dtdr' ),
		) );

			$this->add_control( 'enable_carousel', array(
				'label'       => esc_html__( 'Enable Carousel', 'dtdr' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtdr'),
					'true'  => esc_html__('True', 'dtdr'),
				),
				'description' => esc_html__( 'If you wish you can enable carousel for your item listings. Carousel won\'t work along with Isotope.', 'dtdr' ),
				'condition'   => array( 'apply_isotope' => 'false' ),
				'default'      => 'false'
			) );

			$this->add_control( 'carousel_effect', array(
				'label'       => esc_html__( 'Effect', 'dtdr' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'' => esc_html__('Default', 'dtdr'),
					'fade'  => esc_html__('Fade', 'dtdr'),
				),
				'description' => esc_html__( 'Choose effect for your carousel. Slides Per View has to be 1 for Fade effect.', 'dtdr' ),
				'condition'   => array( 'enable_carousel' => 'true' ),
				'default'      => ''
			) );

			$this->add_control( 'carousel_autoplay', array(
				'label'   => esc_html__( 'Auto Play', 'dtdr' ),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'Delay between transitions ( in ms ). Leave empty if you don\'t want to auto play.', 'dtdr' ),
				'condition'   => array( 'enable_carousel' => 'true' ),
				'default' => ''
			) );

			$this->add_control( 'carousel_slidesperview', array(
				'label'       => esc_html__( 'Slides Per View', 'dtdr' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					1 => 1,
					2 => 2,
					3 => 3
				),
				'description' => esc_html__( 'Number slides of to show in view port. 2,3 options applicable only for "Type 1" design.', 'dtdr' ),
				'condition'   => array( 'enable_carousel' => 'true' ),
				'default'      => 2
			) );

			$this->add_control( 'carousel_loopmode', array(
				'label'       => esc_html__( 'Enable Loop Mode', 'dtdr' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtdr'),
					'true'  => esc_html__('True', 'dtdr'),
				),
				'description' => esc_html__( 'If you wish you can enable continous loop mode for your carousel.', 'dtdr' ),
				'condition'   => array( 'enable_carousel' => 'true' ),
				'default'      => 'false'
			) );

			$this->add_control( 'carousel_mousewheelcontrol', array(
				'label'       => esc_html__( 'Enable Mousewheel Control', 'dtdr' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtdr'),
					'true'  => esc_html__('True', 'dtdr'),
				),
				'description' => esc_html__( 'If you wish you can enable mouse wheel control for your carousel.', 'dtdr' ),
				'condition'   => array( 'enable_carousel' => 'true' ),
				'default'      => 'false'
			) );

			$this->add_control( 'carousel_bulletpagination', array(
				'label'       => esc_html__('Enable Bullet Pagination', 'dtdr'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtdr'),
					'true'  => esc_html__('True', 'dtdr'),
				),
				'description' => esc_html__( 'To enable bullet pagination.', 'dtdr' ),
				'condition'   => array( 'enable_carousel' => 'true' ),
				'default'      => 'false'
			) );

			$this->add_control( 'carousel_arrowpagination', array(
				'label'       => esc_html__( 'Enable Arrow Pagination', 'dtdr' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtdr'),
					'true'  => esc_html__('True', 'dtdr'),
				),
				'description' => esc_html__( 'To enable arrow pagination.', 'dtdr' ),
				'condition'   => array( 'enable_carousel' => 'true' ),
				'default'      => 'false'
			) );

			$this->add_control( 'carousel_spacebetween', array(
				'label'   => esc_html__( 'Space Between Sliders', 'dtdr' ),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'Space between sliders can be given here.', 'dtdr' ),
				'condition'   => array( 'enable_carousel' => 'true' ),
				'default' => 20
			) );

		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings();
		$attributes = dtdirectory_elementor_instance()->dtdr_parse_shortcode_attrs( $settings );
		echo do_shortcode('[dtdr_packages_listing '.$attributes.' /]');

	}

}