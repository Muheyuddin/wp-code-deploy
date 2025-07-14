<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTDirectorySfOutputDataContainer extends Widget_Base {

	public function get_categories() {
		return [ 'dtdr-searchform-widgets' ];
	}

	public function get_name() {
		return 'dtdr-widget-sf-output-data-container';
	}

	public function get_title() {
		return esc_html__( 'Output Data Container', 'dtdr' );
	}

	public function get_style_depends() {
		return array ( 'dtdr-fields', 'dtdr-search-frontend');
	}

	public function get_script_depends() {
		return array ( 'dtdr-search-frontend');
	}

	public function dtdr_dynamicregister_controls() {

	}

	protected function register_controls() {

		$listing_singular_label = apply_filters( 'listing_label', 'singular' );

		$this->start_controls_section( 'output_data_container_default_section', array(
			'label' => esc_html__( 'General', 'dtdr' ),
		) );

            $this->add_control( 'type', array(
                'label'       => esc_html__( 'Type', 'dtdr' ),
                'type'        => Controls_Manager::SELECT,
                'options'     => array(
                    'type1' => esc_html__('Type 1', 'dtdr'),
                    'type2' => esc_html__('Type 2', 'dtdr'),
                    'type3' => esc_html__('Type 3', 'dtdr'),
                    'type4' => esc_html__('Type 4', 'dtdr'),
                    'type5' => esc_html__('Type 5', 'dtdr'),
					'type6' => esc_html__('Type 6', 'dtdr'),
					'type7' => esc_html__('Type 7', 'dtdr'),
					'type8' => esc_html__('Type 8', 'dtdr'),
					'type9' => esc_html__('Type 9', 'dtdr'),
					'type10' => esc_html__('Type 10', 'dtdr')
                ),
                'description' => esc_html__('Choose type of layout you like to display.', 'dtdr'),
                'default'      => 'type1',
            ) );

            $this->add_control( 'gallery', array(
                'label'       => esc_html__( 'Gallery', 'dtdr' ),
                'type'        => Controls_Manager::SELECT,
                'options'     => array(
                    'featured_image'        => esc_html__('Featured Image', 'dtdr'),
                    'image_gallery'         => esc_html__('Image Gallery', 'dtdr'),
                    'gallery_with_featured' => esc_html__('Image Gallery With Featured Image', 'dtdr'),
                ),
                'description' => esc_html__( 'Choose how you like to display image gallery.', 'dtdr' ),
                'default'      => 'featured_image',
            ) );

            $this->add_control( 'post_per_page', array(
                'label'   => esc_html__( 'Post Per Page', 'dtdr' ),
                'type'    => Controls_Manager::TEXT,
                'description' => esc_html__( 'Number of posts to show per page. Rest of the posts will be displayed in pagination.', 'dtdr' ),
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
				'condition'   => array( 'type' => array( 'type1', 'type2', 'type4', 'type6', 'type8') ),
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

			$this->add_control( 'excerpt_length', array(
				'label'   => esc_html__( 'Excerpt Length', 'dtdr' ),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'Provide excerpt length here.', 'dtdr' ),
				'default' => 20
			) );

            $this->add_control( 'features_image_or_icon', array(
				'label'       => esc_html__( 'Features Image or Icon', 'dtdr' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					''      => esc_html__('None', 'dtdr'),
					'image' => esc_html__('Image', 'dtdr'),
					'icon'  => esc_html__('Icon', 'dtdr')
				),
				'description' => esc_html__('Choose any of the option available to display features.', 'dtdr'),
				'default'      => '',
			) );

			$this->add_control( 'features_include', array(
				'label'       => esc_html__( 'Features Include', 'dtdr' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__('Give features id separated by comma. Only 4 maximum number of features allowed.', 'dtdr'),
				'default'      => '',
			) );

			$this->add_control( 'no_of_cat_to_display', array(
				'label'       => esc_html__( 'No. Of Categories to Display', 'dtdr' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					1  => 1,
					2  => 2,
					3  => 3,
					4  => 4
				),
				'description' => esc_html__( 'Number of categories you like to display on your items.', 'dtdr' ),
				'default'      => 2,
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

			$this->add_control( 'apply_custom_height', array(
				'label'       => esc_html__( 'Apply Custom Height', 'dtdr' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtdr'),
					'true'  => esc_html__('True', 'dtdr'),
				),
				'description' => esc_html__('Apply custom height for your entire section.', 'dtdr'),
				'default'      => 'false'
			) );

			$this->add_responsive_control( 'height', array(
                'label' => esc_html__( 'Height', 'dtdr' ),
                'type' => Controls_Manager::TEXT,
				'description' => esc_html__( 'Provide height for your section in "px" here.', 'dtdr' ),
				'condition'   => array( 'apply_custom_height' => 'true' ),
                'devices' => array( 'desktop', 'tablet', 'mobile' ),
                'selectors' => array(
					'{{WRAPPER}} .dtdr-listing-output-data-container' => 'height: {{SIZE}}px;',
				),
			) );

			$this->add_control( 'sidebar_widget', array(
				'label'       => esc_html__( 'Sidebar Widget', 'dtdr' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtdr'),
					'true'  => esc_html__('True', 'dtdr'),
				),
				'description' => sprintf( esc_html__('%1$s 1) If you wish to show these items in sidebar set this to "True". %2$s %1$s 2) This options is not applicable for "Type 3", "Type 5" and "Type 7". %2$s', 'dtdr'), '<p>', '</p>' ),
				'default'      => 'false'
			) );

			$this->add_control( 'class', array(
				'label'   => esc_html__( 'Class', 'dtdr' ),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'If you wish you can add additional class name here.', 'dtdr' ),
				'default' => ''
			) );

		$this->end_controls_section();

		$this->dtdr_dynamicregister_controls();

		$this->start_controls_section( 'output_data_container_filter_section', array(
			'label' => esc_html__( 'Filter Options', 'dtdr' ),
		) );

			$this->add_control( 'category_ids', array(
				'label'   => sprintf( esc_html__('%1$s Category Ids', 'dtdr'), $listing_singular_label ),
				'type'    => Controls_Manager::TEXT,
				'description' => sprintf( esc_html__( 'Enter %1$s category ids separated by commas.', 'dtdr' ), $listing_singular_label ),
				'default' => ''
			) );

		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings();
		$attributes = dtdirectory_elementor_instance()->dtdr_parse_shortcode_attrs( $settings );
		echo do_shortcode('[dtdr_sf_output_data_container '.$attributes.' /]');

	}

}