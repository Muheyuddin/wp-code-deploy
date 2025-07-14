<?php
use NetlinkElementor\Widgets\NetlinkElementorWidgetBase;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;

class Elementor_Blog_Posts extends NetlinkElementorWidgetBase {

    public function get_name() {
        return 'wdt-blog-posts';
    }

    public function get_title() {
        return esc_html__('Blog Posts', 'netlink-plus');
    }

    public function get_icon() {
		return 'eicon-posts-grid wdt-icon';
	}

	public function get_style_depends() {
		return array( 'swiper', 'wdt-blogcarousel' );
	}

	public function get_script_depends() {
		return array( 'jquery-swiper', 'wdt-blogcarousel' );
	}

    protected function register_controls() {

        $this->start_controls_section( 'wdt_section_general', array(
            'label' => esc_html__( 'General', 'netlink-plus'),
        ) );

            $this->add_control( 'query_posts_by', array(
                'type'    => Controls_Manager::SELECT,
                'label'   => esc_html__('Query posts by', 'netlink-plus'),
                'default' => 'category',
                'options' => array(
                    'category'  => esc_html__('From Category (for Posts only)', 'netlink-plus'),
                    'ids'       => esc_html__('By Specific IDs', 'netlink-plus'),
                )
            ) );

            $this->add_control( '_post_categories', array(
                'label'       => esc_html__( 'Categories', 'netlink-plus' ),
                'type'        => Controls_Manager:: SELECT2,
                'label_block' => true,
                'multiple'    => true,
                'options'     => $this->netlink_post_categories(),
                'condition'   => array( 'query_posts_by' => 'category' )
            ) );

            $this->add_control( '_post_ids', array(
                'label'       => esc_html__( 'Select Specific Posts', 'netlink-plus' ),
                'type'        => Controls_Manager::SELECT2,
                'label_block' => true,
                'multiple'    => true,
                'options'     => $this->netlink_post_ids(),
                'condition' => array( 'query_posts_by' => 'ids' )
            ) );

            $this->add_control( 'count', array(
                'type'        => Controls_Manager::NUMBER,
                'label'       => esc_html__('Post Counts', 'netlink-plus'),
                'default'     => '5',
                'placeholder' => esc_html__( 'Enter post count', 'netlink-plus' ),
            ) );

            $this->add_control( 'blog_post_layout', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__('Post Layout', 'netlink-plus'),
                'default' => 'entry-grid',
                'options' => array(
                    'entry-grid'  => esc_html__('Grid', 'netlink-plus'),
                    'entry-list'  => esc_html__('List', 'netlink-plus'),
                    'entry-cover' => esc_html__('Cover', 'netlink-plus'),
                )
            ) );

            $this->add_control( 'blog_post_grid_list_style', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__('Post Style', 'netlink-plus'),
                'default' => 'wdt-classic',
                'options' => apply_filters( 'blog_post_grid_list_style_update', array(
                    'wdt-classic' => esc_html__('Classic', 'netlink-plus'),
                )),
                'condition' => array( 'blog_post_layout' => array( 'entry-grid', 'entry-list' ) )
            ) );

            $this->add_control( 'blog_post_cover_style', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__('Post Style', 'netlink-plus'),
                'default' => 'wdt-classic',
                'options' => apply_filters('blog_post_cover_style_update', array(
                    'wdt-classic' => esc_html__('Classic', 'netlink-plus')
                )),
                'condition' => array( 'blog_post_layout' => 'entry-cover' )
            ) );

            $this->add_control( 'blog_post_columns', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__('Columns', 'netlink-plus'),
                'default' => 'one-third-column',
                'options' => array(
                    'one-column'        => esc_html__('I Column', 'netlink-plus'),
                    'one-half-column'   => esc_html__('II Columns', 'netlink-plus'),
                    'one-third-column'  => esc_html__('III Columns', 'netlink-plus'),
                    'one-fourth-column' => esc_html__('IV Columns', 'netlink-plus'),
                ),
                'condition' => array( 'blog_post_layout' => array( 'entry-grid', 'entry-cover' ) )
            ) );

            $this->add_control( 'blog_list_thumb', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__('List Type', 'netlink-plus'),
                'default' => 'entry-left-thumb',
                'options' => array(
                    'entry-left-thumb'  => esc_html__('Left Thumb', 'netlink-plus'),
                    'entry-right-thumb' => esc_html__('Right Thumb', 'netlink-plus'),
                ),
                'condition' => array( 'blog_post_layout' => 'entry-list' )
            ) );

            $this->add_control( 'blog_alignment', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__('Elements Alignment', 'netlink-plus'),
                'default' => 'alignnone',
                'options' => array(
                    'alignnone'   => esc_html__('None', 'netlink-plus'),
                    'alignleft'   => esc_html__('Align Left', 'netlink-plus'),
                    'aligncenter' => esc_html__('Align Center', 'netlink-plus'),
                    'alignright'  => esc_html__('Align Right', 'netlink-plus'),
                ),
                'condition' => array( 'blog_post_layout' => array( 'entry-grid', 'entry-cover' ) )
            ) );

            $this->add_control( 'enable_equal_height', array(
                'type'         => Controls_Manager::SWITCHER,
                'label'        => esc_html__('Enable Equal Height?', 'netlink-plus'),
                'label_on'     => esc_html__( 'Yes', 'netlink-plus' ),
                'label_off'    => esc_html__( 'No', 'netlink-plus' ),
                'return_value' => 'yes',
                'default'      => '',
                'condition'    => array( 'blog_post_layout' => array( 'entry-grid', 'entry-cover' ) )
            ) );

            $this->add_control( 'enable_no_space', array(
                'type'         => Controls_Manager::SWITCHER,
                'label'        => esc_html__('Enable No Space?', 'netlink-plus'),
                'label_on'     => esc_html__( 'Yes', 'netlink-plus' ),
                'label_off'    => esc_html__( 'No', 'netlink-plus' ),
                'return_value' => 'yes',
                'default'      => '',
                'condition'    => array( 'blog_post_layout' => array( 'entry-grid', 'entry-cover' ) )
            ) );

            $this->add_control( 'enable_gallery_slider', array(
                'type'         => Controls_Manager::SWITCHER,
                'label'        => esc_html__('Display Gallery Slider?', 'netlink-plus'),
                'label_on'     => esc_html__( 'Yes', 'netlink-plus' ),
                'label_off'    => esc_html__( 'No', 'netlink-plus' ),
                'return_value' => 'yes',
                'default'      => '',
                'condition'    => array( 'blog_post_layout' => array( 'entry-grid', 'entry-list' ) ),
            ) );

            $content = new Repeater();
            $content->add_control( 'element_value', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__('Element', 'netlink-plus'),
                'default' => 'feature_image',
                'options' => array(
                    'feature_image' => esc_html__('Feature Image', 'netlink-plus'),
                    'title'         => esc_html__('Title', 'netlink-plus'),
                    'content'       => esc_html__('Content', 'netlink-plus'),
                    'read_more'     => esc_html__('Read More', 'netlink-plus'),
                    'meta_group'    => esc_html__('Meta Group', 'netlink-plus'),
                    'author'        => esc_html__('Author', 'netlink-plus'),
                    'date'          => esc_html__('Date', 'netlink-plus'),
                    'comment'       => esc_html__('Comments', 'netlink-plus'),
                    'category'      => esc_html__('Categories', 'netlink-plus'),
                    'tag'           => esc_html__('Tags', 'netlink-plus'),
                    'social'        => esc_html__('Social Share', 'netlink-plus'),
                    'likes_views'   => esc_html__('Likes & Views', 'netlink-plus'),
                ),
            ) );

            $this->add_control( 'blog_elements_position', array(
                'type'        => Controls_Manager::REPEATER,
                'label'       => esc_html__('Elements & Positioning', 'netlink-plus'),
                'fields'      => array_values( $content->get_controls() ),
                'default'     => array(
                    array( 'element_value' => 'title' ),
                ),
                'title_field' => '{{{ element_value.replace( \'_\', \' \' ).replace( /\b\w/g, function( letter ){ return letter.toUpperCase() } ) }}}'
            ) );

            $content = new Repeater();
            $content->add_control( 'element_value', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__('Element', 'netlink-plus'),
                'default' => 'author',
                'options' => array(
                    'author'       => esc_html__('Author', 'netlink-plus'),
                    'date'         => esc_html__('Date', 'netlink-plus'),
                    'comment'      => esc_html__('Comments', 'netlink-plus'),
                    'category'     => esc_html__('Categories', 'netlink-plus'),
                    'tag'          => esc_html__('Tags', 'netlink-plus'),
                    'social'       => esc_html__('Social Share', 'netlink-plus'),
                    'likes_views'  => esc_html__('Likes & Views', 'netlink-plus'),
                ),
            ) );

            $this->add_control( 'blog_meta_position', array(
                'type'        => Controls_Manager::REPEATER,
                'label'       => esc_html__('Meta Group Positioning', 'netlink-plus'),
                'fields'      => array_values( $content->get_controls() ),
                'default'     => array(
                    array( 'element_value' => 'author' ),
                ),
                'title_field' => '{{{ element_value.replace( \'_\', \' \' ).replace( /\b\w/g, function( letter ){ return letter.toUpperCase() } ) }}}'
            ) );

            $this->add_control( 'enable_post_format', array(
                'type'         => Controls_Manager::SWITCHER,
                'label'        => esc_html__('Enable Post Format?', 'netlink-plus'),
                'label_on'     => esc_html__( 'Yes', 'netlink-plus' ),
                'label_off'    => esc_html__( 'No', 'netlink-plus' ),
                'return_value' => 'yes',
                'default'      => '',
            ) );

            $this->add_control( 'enable_video_audio', array(
                'type'         => Controls_Manager::SWITCHER,
                'label'        => esc_html__('Display Video & Audio for Posts?', 'netlink-plus'),
                'label_on'     => esc_html__( 'Yes', 'netlink-plus' ),
                'label_off'    => esc_html__( 'No', 'netlink-plus' ),
                'return_value' => 'yes',
                'default'      => '',
                'condition'    => array( 'blog_post_layout' => array( 'entry-grid', 'entry-list' ) ),
                'description'  => esc_html__( 'YES! to display video & audio, instead of feature image for posts', 'netlink-plus' ),
            ) );

            $this->add_control( 'enable_excerpt_text', array(
                'type'         => Controls_Manager::SWITCHER,
                'label'        => esc_html__('Enable Excerpt Text?', 'netlink-plus'),
                'label_on'     => esc_html__( 'Yes', 'netlink-plus' ),
                'label_off'    => esc_html__( 'No', 'netlink-plus' ),
                'return_value' => 'yes',
                'default'      => '',
            ) );

            $this->add_control( 'blog_excerpt_length', array(
                'type'      => Controls_Manager::NUMBER,
                'label'     => esc_html__('Excerpt Length', 'netlink-plus'),
                'default'   => '25',
                'condition' => array( 'enable_excerpt_text' => 'yes' )
            ) );

            $this->add_control( 'blog_readmore_text', array(
                'type'        => Controls_Manager::TEXT,
                'label'       => esc_html__('Read More Text', 'netlink-plus'),
                'default'     => esc_html__('Read More', 'netlink-plus'),
            ) );

            $this->add_control( 'blog_image_hover_style', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__('Image Hover Style', 'netlink-plus'),
                'default' => 'wdt-default',
                'options' => array(
                    'wdt-default'     => esc_html__('Default', 'netlink-plus'),
                    'wdt-blur'        => esc_html__('Blur', 'netlink-plus'),
                    'wdt-bw'          => esc_html__('Black and White', 'netlink-plus'),
                    'wdt-brightness'  => esc_html__('Brightness', 'netlink-plus'),
                    'wdt-fadeinleft'  => esc_html__('Fade InLeft', 'netlink-plus'),
                    'wdt-fadeinright' => esc_html__('Fade InRight', 'netlink-plus'),
                    'wdt-hue-rotate'  => esc_html__('Hue-Rotate', 'netlink-plus'),
                    'wdt-invert'      => esc_html__('Invert', 'netlink-plus'),
                    'wdt-opacity'     => esc_html__('Opacity', 'netlink-plus'),
                    'wdt-rotate'      => esc_html__('Rotate', 'netlink-plus'),
                    'wdt-rotate-alt'  => esc_html__('Rotate Alt', 'netlink-plus'),
                    'wdt-scalein'     => esc_html__('Scale In', 'netlink-plus'),
                    'wdt-scaleout'    => esc_html__('Scale Out', 'netlink-plus'),
                    'wdt-sepia'       => esc_html__('Sepia', 'netlink-plus'),
                    'wdt-tint'        => esc_html__('Tint', 'netlink-plus'),
                ),
                'description' => esc_html__('Note: Fade, Rotate & Scale Styles will not work for Gallery Sliders.', 'netlink-plus'),
            ) );

            $this->add_control( 'blog_image_overlay_style', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__('Image Overlay Style', 'netlink-plus'),
                'default' => 'wdt-default',
                'options' => array(
                    'wdt-default'         => esc_html__('None', 'netlink-plus'),
                    'wdt-fixed'           => esc_html__('Fixed', 'netlink-plus'),
                    'wdt-tb'              => esc_html__('Top to Bottom', 'netlink-plus'),
                    'wdt-bt'              => esc_html__('Bottom to Top', 'netlink-plus'),
                    'wdt-rl'              => esc_html__('Right to Left', 'netlink-plus'),
                    'wdt-lr'              => esc_html__('Left to Right', 'netlink-plus'),
                    'wdt-middle'          => esc_html__('Middle', 'netlink-plus'),
                    'wdt-middle-radial'   => esc_html__('Middle Radial', 'netlink-plus'),
                    'wdt-tb-gradient'     => esc_html__('Gradient - Top to Bottom', 'netlink-plus'),
                    'wdt-bt-gradient'     => esc_html__('Gradient - Bottom to Top', 'netlink-plus'),
                    'wdt-rl-gradient'     => esc_html__('Gradient - Right to Left', 'netlink-plus'),
                    'wdt-lr-gradient'     => esc_html__('Gradient - Left to Right', 'netlink-plus'),
                    'wdt-radial-gradient' => esc_html__('Gradient - Radial', 'netlink-plus'),
                    'wdt-flash'           => esc_html__('Flash', 'netlink-plus'),
                    'wdt-circle'          => esc_html__('Circle', 'netlink-plus'),
                    'wdt-hm-elastic'      => esc_html__('Horizontal Elastic', 'netlink-plus'),
                    'wdt-vm-elastic'      => esc_html__('Vertical Elastic', 'netlink-plus'),
                ),
                'condition' => array( 'blog_post_layout' => array( 'entry-grid', 'entry-list' ) )
            ) );

            $this->add_control( 'blog_pagination', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__('Pagination Style', 'netlink-plus'),
                'default' => 'older_newer',
                'options' => array(
                    ''                => esc_html__('None', 'netlink-plus'),
                    'older_newer'     => esc_html__('Older & Newer', 'netlink-plus'),
                    'numbered'        => esc_html__('Numbered', 'netlink-plus'),
                    'load_more'       => esc_html__('Load More', 'netlink-plus'),
                    'infinite_scroll' => esc_html__('Infinite Scroll', 'netlink-plus'),
                    'carousel'        => esc_html__('Carousel', 'netlink-plus'),
                ),
            ) );

            $this->add_control( 'el_class', array(
                'type'        => Controls_Manager::TEXT,
                'label'       => esc_html__('Extra class name', 'netlink-plus'),
                'description' => esc_html__('Style particular element differently - add a class name and refer to it in custom CSS', 'netlink-plus')
            ) );

        $this->end_controls_section();

		$this->start_controls_section( 'blog_carousel_section', array(
			'label'     => esc_html__( 'Carousel Settings', 'netlink-plus' ),
			'condition' => array( 'blog_pagination' => 'carousel' ),
		) );
			$this->add_control( 'carousel_effect', array(
				'label'       => esc_html__( 'Effect', 'netlink-plus' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Choose effect for your carousel. Slides Per View has to be 1 for Fade effect.', 'netlink-plus' ),
				'default'     => '',
				'options'     => array(
					''     => esc_html__( 'Default', 'netlink-plus' ),
					'fade' => esc_html__( 'Fade', 'netlink-plus' ),
	            ),
	        ) );

			$this->add_responsive_control( 'carousel_slidesperview', array(
				'label'       => esc_html__( 'Slides Per View', 'netlink-plus' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Number slides of to show in view port.', 'netlink-plus' ),
				'options'     => array( 1 => 1, 2 => 2, 3 => 3, 4 => 4 ),
                'desktop_default'      => 4,
				'laptop_default'       => 4,
				'tablet_default'       => 2,
				'tablet_extra_default' => 2,
				'mobile_default'       => 1,
				'mobile_extra_default' => 1,
				'frontend_available'   => true,
				'default'     => 1,
	        ) );

			$this->add_control( 'carousel_loopmode', array(
				'label'        => esc_html__( 'Enable Loop Mode', 'netlink-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__('If you wish, you can enable continuous loop mode for your carousel.', 'netlink-plus'),
				'label_on'     => esc_html__( 'yes', 'netlink-plus' ),
				'label_off'    => esc_html__( 'no', 'netlink-plus' ),
				'default'      => '',
				'return_value' => 'true',
			) );

			$this->add_control( 'carousel_mousewheelcontrol', array(
				'label'        => esc_html__( 'Enable Mousewheel Control', 'netlink-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__('If you wish, you can enable mouse wheel control for your carousel.', 'netlink-plus'),
				'label_on'     => esc_html__( 'yes', 'netlink-plus' ),
				'label_off'    => esc_html__( 'no', 'netlink-plus' ),
				'default'      => '',
				'return_value' => 'true',
			) );

			$this->add_control( 'carousel_bulletpagination', array(
				'label'        => esc_html__( 'Enable Bullet Pagination', 'netlink-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__('To enable bullet pagination.', 'netlink-plus'),
				'label_on'     => esc_html__( 'yes', 'netlink-plus' ),
				'label_off'    => esc_html__( 'no', 'netlink-plus' ),
				'default'      => '',
				'return_value' => 'true',
			) );

			$this->add_control( 'carousel_arrowpagination', array(
				'label'        => esc_html__( 'Enable Arrow Pagination', 'netlink-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__('To enable arrow pagination.', 'netlink-plus'),
				'label_on'     => esc_html__( 'yes', 'netlink-plus' ),
				'label_off'    => esc_html__( 'no', 'netlink-plus' ),
				'default'      => '',
				'return_value' => 'true',
			) );

			$this->add_control( 'carousel_arrowpagination_type', array(
				'label'       => esc_html__( 'Arrow Type', 'netlink-plus' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Choose arrow pagination type for your carousel.', 'netlink-plus' ),
				'options'     => array(
					''      => esc_html__('Default', 'netlink-plus'),
					'type2' => esc_html__('Type 2', 'netlink-plus'),
				),
				'condition'   => array( 'carousel_arrowpagination' => 'true' ),
				'default'     => '',
	        ) );

			$this->add_control( 'carousel_scrollbar', array(
				'label'        => esc_html__( 'Enable Scrollbar', 'netlink-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__('To enable scrollbar for your carousel.', 'netlink-plus'),
				'label_on'     => esc_html__( 'yes', 'netlink-plus' ),
				'label_off'    => esc_html__( 'no', 'netlink-plus' ),
				'default'      => '',
				'return_value' => 'true',
			) );

		$this->end_controls_section();
    }

    protected function render() {

        $settings = $this->get_settings_for_display();

        extract($settings);

		$out = '';
        $settings['module_id'] = $this->get_id();

		$media_carousel_attributes_string = $container_class = $wrapper_class = $item_class = '';

		if( $blog_pagination == 'carousel' ) {

			$media_carousel_attributes = array ();


            $settings['columns'] = $settings['carousel_slidesperview'];

				$slides_to_show = $settings['carousel_slidesperview'];
				$slides_to_scroll = 1;
		
				extract($settings);
					// Responsive control carousel
					$carousel_settings = array (
						'carousel_slidesperview' => $slides_to_show,
					);
			
					$active_breakpoints = \Elementor\Plugin::$instance->breakpoints->get_active_breakpoints();
					$breakpoint_keys = array_keys($active_breakpoints);
		
					$swiper_breakpoints = array ();
					$swiper_breakpoints[] = array (
						'breakpoint' => 0
					);
					$swiper_breakpoints_slides = array ();
					
					foreach($breakpoint_keys as $breakpoint) {
						$breakpoint_show_str = 'carousel_slidesperview_'.$breakpoint;
						$breakpoint_toshow = $$breakpoint_show_str;
						if($breakpoint_toshow == '') {
							if($breakpoint == 'mobile') {
								$breakpoint_toshow = 1;
							} else if($breakpoint == 'mobile_extra') {
								$breakpoint_toshow = 1;
							} else if($breakpoint == 'tablet') {
								$breakpoint_toshow = 2;
							} else if($breakpoint == 'tablet_extra') {
								$breakpoint_toshow = 2;
							} else if($breakpoint == 'laptop') {
								$breakpoint_toshow = 4;
							} else if($breakpoint == 'widescreen') {
								$breakpoint_toshow = 4;
							} else {
								$breakpoint_toshow = 4;
							}
						}
		
						$breakpoint_toscroll = 1;
			
						array_push($swiper_breakpoints, array (
								'breakpoint' => $active_breakpoints[$breakpoint]->get_value() + 1
							)
						);
						array_push($swiper_breakpoints_slides, array (
								'toshow' => (int)$breakpoint_toshow,
								'toscroll' => (int)$breakpoint_toscroll
							)
						);
			
					}
		
					array_push($swiper_breakpoints_slides, array (
							'toshow' => (int)$slides_to_show,
							'toscroll' => (int)$slides_to_scroll
						)
					);
		
					$responsive_breakpoints = array ();
		
					if(is_array($swiper_breakpoints) && !empty($swiper_breakpoints)) {
						foreach($swiper_breakpoints as $key => $swiper_breakpoint) {
							$responsive_breakpoints[] = array_merge($swiper_breakpoint, $swiper_breakpoints_slides[$key]);
						}
					}
		
					$carousel_settings['responsive'] = $responsive_breakpoints;
		
					$carousel_settings_value = wp_json_encode($carousel_settings);

			array_push( $media_carousel_attributes, 'data-carouseleffect="'.esc_attr($settings['carousel_effect']).'"' );
			array_push( $media_carousel_attributes, 'data-carouselslidesperview="'.esc_attr($settings['carousel_slidesperview']).'"' );
			array_push( $media_carousel_attributes, 'data-carouselloopmode="'.esc_attr($settings['carousel_loopmode']).'"' );
			array_push( $media_carousel_attributes, 'data-carouselmousewheelcontrol="'.esc_attr($settings['carousel_mousewheelcontrol']).'"' );
			array_push( $media_carousel_attributes, 'data-carouselbulletpagination="'.esc_attr($settings['carousel_bulletpagination']).'"' );
			array_push( $media_carousel_attributes, 'data-carouselarrowpagination="'.esc_attr($settings['carousel_arrowpagination']).'"' );
			array_push( $media_carousel_attributes, 'data-carouselscrollbar="'.esc_attr($settings['carousel_scrollbar']).'"' );
            array_push( $media_carousel_attributes, 'data-id="'.esc_attr($settings['module_id']).'"' );
            array_push( $media_carousel_attributes, 'data-carouselresponsive="'.esc_js($carousel_settings_value).'"');

			if( !empty( $media_carousel_attributes ) ) {
				$media_carousel_attributes_string = implode(' ', $media_carousel_attributes);
			}

			$container_class = 'swiper-container';
			$wrapper_class = 'swiper-wrapper';
			$item_class = 'swiper-slide';

			$out .= '<div class="wdt-post-list-carousel-container">';
		}

		$out .= '<div class="wdt-posts-list-wrapper '.esc_attr($container_class).' '.esc_attr($el_class).'wdt-post-list-carousel-'.esc_attr($settings['module_id']).'" '.netlink_html_output($media_carousel_attributes_string).'>';

		if ( get_query_var('paged') ) {
			$paged = get_query_var('paged');
		} elseif ( get_query_var('page') ) {
			$paged = get_query_var('page');
		} else {
			$paged = 1;
		}

		$args = array( 'paged' => $paged, 'posts_per_page' => $count, 'orderby' => 'date', 'ignore_sticky_posts' => true, 'post_status' => 'publish' );
		$warning = esc_html__('No Posts Found','netlink-plus');

        if( !empty( $_post_categories ) && $query_posts_by == 'category' ) {
            $_post_categories = implode( ',', $_post_categories );
			$args = array( 'paged' => $paged, 'posts_per_page' => $count, 'orderby' => 'date', 'cat' => $_post_categories, 'ignore_sticky_posts' => true, 'post_status' => 'publish' );
			$warning = esc_html__('No Posts Found in Category ','designthemes-theme').$_post_categories;
		} elseif( $query_posts_by == 'ids' && !empty( $_post_ids ) ) {
            $args = array( 'paged' => $paged, 'posts_per_page' => $count, 'orderby' => 'date', 'post__in' => $_post_ids, 'ignore_sticky_posts' => true, 'post_status' => 'publish' );
            $warning = esc_html__('No Posts Found in Criteria ','designthemes-theme').$_post_categories;
        }

		if( !empty( $_post_not_in ) ) {
			$args['post__not_in'] = array( $_post_not_in );
            $settings['blog_excerpt_length'] = $settings['blog_excerpt_length2'];
		}

		$rposts = new WP_Query( $args );
		if ( $rposts->have_posts() ) :

           	do_action( 'call_blog_elementor_sc_filters', $settings );

            $holder_class = '';
            if($wrapper_class == '') {
                $holder_class = netlink_get_archive_post_holder_class();
            }
            $combine_class = netlink_get_archive_post_combine_class();

            $post_style    = netlink_get_archive_post_style();
            $template_args['Post_Style'] = $post_style;
            $template_args = array_merge( $template_args, netlink_archive_blog_post_params() );
            $template_args = apply_filters( 'netlink_blog_archive_elem_order_params', $template_args );

            // css enqueue
            wp_enqueue_style( 'netlink-plus-blog', NETLINK_PLUS_DIR_URL . 'modules/blog/assets/css/blog.css', false, NETLINK_PLUS_VERSION, 'all');

            $pro_active = false;
            $editor_css = '';
            if( defined('NETLINK_PRO_DIR_PATH') ) {
                $pro_active = true;
                $file_path = NETLINK_PRO_DIR_PATH . 'modules/blog/templates/'.esc_attr($post_style).'/assets/css/blog-archive-'.esc_attr($post_style).'.css';
            }

            if ( file_exists( get_theme_file_path('/modules/blog/templates/'.$post_style.'/assets/css/blog-archive-'.$post_style.'.css') ) ) {
                wp_enqueue_style( 'wdt-blog-archive-'.$post_style, get_theme_file_uri('/modules/blog/templates/'.$post_style.'/assets/css/blog-archive-'.$post_style.'.css'), false, NETLINK_THEME_VERSION, 'all');
            } else if ( $pro_active && file_exists( $file_path ) ) {
                wp_enqueue_style( 'wdt-blog-archive-'.esc_attr($post_style), NETLINK_PRO_DIR_URL . 'modules/blog/templates/'.esc_attr($post_style).'/assets/css/blog-archive-'.esc_attr($post_style).'.css', false, NETLINK_PRO_VERSION, 'all');
                ob_start();
                include( $file_path );
                $editor_css .= "\n\n".ob_get_clean();
            } else {
                $file_path = NETLINK_PLUS_DIR_PATH . 'modules/blog/templates/'.esc_attr($post_style).'/assets/css/blog-archive-'.esc_attr($post_style).'.css';
                if ( file_exists( $file_path ) ) {
                    wp_enqueue_style( 'wdt-blog-archive-'.esc_attr($post_style), NETLINK_PLUS_DIR_URL . 'modules/blog/templates/'.esc_attr($post_style).'/assets/css/blog-archive-'.esc_attr($post_style).'.css', false, NETLINK_PLUS_VERSION, 'all');
                    ob_start();
                    include( $file_path );
                    $editor_css .= "\n\n".ob_get_clean();
                }
            }

            $out .= "<div class='tpl-blog-holder ".$holder_class." ".$wrapper_class."'>";

                if($wrapper_class == '') {
                    $out .= "<div class='grid-sizer ".$combine_class."'></div>";
                }

                while( $rposts->have_posts() ) :
                    $rposts->the_post();
                    $post_ID = get_the_ID();

                    $out .= '<div class="'.esc_attr($combine_class.' '.$item_class).'">';
                        $out .= '<article id="post-'.esc_attr($post_ID).'" class="' . implode( ' ', get_post_class( '', $post_ID ) ) . '">';

                            $template_args['ID'] = $post_ID;
                            $out .= netlink_get_template_part( 'blog', 'templates/'.esc_attr($post_style).'/post', '', $template_args );
                        $out .= '</article>';
                    $out .= '</div>';
                endwhile;

			    wp_reset_postdata($rposts);

            $out .= '</div>';

			if( $blog_pagination == 'numbered' ):

				$out .= '<div class="pagination blog-pagination">'.netlink_pagination($rposts).'</div>';

			elseif( $blog_pagination == 'older_newer' ):

				$out .= '<div class="pagination blog-pagination"><div class="newer-posts">'.get_previous_posts_link( '<i class="wdticon-angle-left"></i>'.esc_html__(' Newer Posts', 'netlink-plus') ).'</div>';
				$out .= '<div class="older-posts">'.get_next_posts_link( esc_html__('Older Posts ', 'netlink-plus').'<i class="wdticon-angle-right"></i>', $rposts->max_num_pages ).'</div></div>';

			elseif( $blog_pagination == 'load_more' ):

				//$pos = $count % $columns;
				//$pos += 1;
                $pos = 1;
                $_post_categories = !empty( $_post_categories ) ? $_post_categories : '';

				$out .= "<div class='pagination blog-pagination'><a class='loadmore-elementor-btn more-items' data-count='".$count."' data-cats='".$_post_categories."' data-maxpage='".esc_attr($rposts->max_num_pages)."' data-pos='".esc_attr($pos)."' data-eheight='".esc_attr($enable_equal_height)."' data-style='".esc_attr($post_style)."' data-layout='".esc_attr($blog_post_layout)."' data-column='".esc_attr($blog_post_columns)."' data-listtype='".esc_attr($blog_list_thumb)."' data-hover='".esc_attr($blog_image_hover_style)."' data-overlay='".esc_attr($blog_image_overlay_style)."' data-align='".esc_attr($blog_alignment)."' href='javascript:void(0);' data-meta='' data-blogpostloadmore-nonce='".wp_create_nonce('blogpostloadmore_nonce')."' data-settings='".http_build_query($settings)."'>".esc_html__('Load More', 'netlink-plus')."</a></div>";

			elseif( $blog_pagination == 'infinite_scroll' ):

				//$pos = $count % $columns;
				//$pos += 1;
                $pos = 1;
                $_post_categories = !empty( $_post_categories ) ? $_post_categories : '';

                $out .= "<div class='pagination blog-pagination'><div class='infinite-elementor-btn more-items' data-count='".$count."' data-cats='".$_post_categories."' data-maxpage='".esc_attr($rposts->max_num_pages)."' data-pos='".esc_attr($pos)."' data-eheight='".esc_attr($enable_equal_height)."' data-style='".esc_attr($post_style)."' data-layout='".esc_attr($blog_post_layout)."' data-column='".esc_attr($blog_post_columns)."' data-listtype='".esc_attr($blog_list_thumb)."' data-hover='".esc_attr($blog_image_hover_style)."' data-overlay='".esc_attr($blog_image_overlay_style)."' data-align='".esc_attr($blog_alignment)."' data-meta='' data-blogpostloadmore-nonce='".wp_create_nonce('blogpostloadmore_nonce')."' data-settings='".http_build_query($settings)."'></div></div>";

			elseif( $blog_pagination == 'carousel' ):

				$out .= '<div class="wdt-products-pagination-holder">';

					if( $settings['carousel_bulletpagination'] == 'true' ) {
						$out .= '<div class="wdt-products-bullet-pagination"></div>';
					}

					if( $settings['carousel_scrollbar'] == 'true' ) {
						$out .= '<div class="wdt-products-scrollbar"></div>';
					}

					if( $settings['carousel_arrowpagination'] == 'true' ) {
						$out .= '<div class="wdt-products-arrow-pagination '.esc_attr($settings['carousel_arrowpagination_type']).'">';
                        $out .= '<a href="#" class="wdt-products-arrow-prev wdt-products-arrow-prev-'.esc_attr($settings['module_id']).'">'.esc_html__('Prev', 'netlink-plus').'</a>';
                        $out .= '<a href="#" class="wdt-products-arrow-next wdt-products-arrow-next-'.esc_attr($settings['module_id']).'">'.esc_html__('Next', 'netlink-plus').'</a>';
						$out .= '</div>';
					}

				$out .= '</div>';

			endif;

            if(\Elementor\Plugin::$instance->editor->is_edit_mode()):
                $out .= '<style type="text/css">'."\n".$editor_css."\n".'</style>';
            endif;

		else:
			$out .= "<div class='wdt-warning-box'>{$warning}</div>";
		endif;

		$out .= '</div>';

		if( $blog_pagination == 'carousel' ) {
			$out .= '</div>';
		}

        echo netlink_html_output($out);
    }

}