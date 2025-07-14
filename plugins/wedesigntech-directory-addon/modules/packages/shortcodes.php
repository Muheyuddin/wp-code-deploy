<?php

if(!function_exists('dtdr_packages_listing')) {
	function dtdr_packages_listing($attrs, $content = null) {

		$attrs = shortcode_atts ( array (

						'type'                       => 'type1',
						'post_per_page'              => '-1',
						'columns'                    => 1,
						'apply_isotope'              => '',
						'package_type'               => '',
						'package_item_ids'           => '',
						'excerpt_length'             => 20,
						'show_featured_image'        => 'true',
						'apply_equal_height'         => 'false',

						'enable_carousel'            => '',
						'carousel_effect'            => '',
						'carousel_autoplay'          => 0,
						'carousel_slidesperview'     => 2,
						'carousel_loopmode'          => '',
						'carousel_mousewheelcontrol' => '',
						'carousel_bulletpagination'  => 'true',
						'carousel_arrowpagination'   => '',
						'carousel_spacebetween'      => 20,

						'class'                      => '',

				), $attrs, 'dtdr_packages_listing' );

		if($attrs['enable_carousel'] == 'true') {
			$attrs['columns'] = $attrs['carousel_slidesperview'];
		}

		$data_attributes = array ();
		array_push($data_attributes, 'data-type="'.esc_attr($attrs['type']).'"');
		array_push($data_attributes, 'data-postperpage="'.$attrs['post_per_page'].'"');
		array_push($data_attributes, 'data-columns="'.$attrs['columns'].'"');
		array_push($data_attributes, 'data-applyisotope="'.$attrs['apply_isotope'].'"');
		array_push($data_attributes, 'data-packagetype="'.$attrs['package_type'].'"');
		array_push($data_attributes, 'data-packageitemids="'.$attrs['package_item_ids'].'"');
		array_push($data_attributes, 'data-excerptlength="'.$attrs['excerpt_length'].'"');
		array_push($data_attributes, 'data-showfeaturedimage="'.$attrs['show_featured_image'].'"');
		array_push($data_attributes, 'data-applyequalheight="'.esc_attr($attrs['apply_equal_height']).'"');

		if(!empty($data_attributes)) {
			$data_attributes_string = implode(' ', $data_attributes);
		}

		$package_carousel_attributes = array ();
		$package_carousel_attributes_string = '';
		$swipper_container_class = '';

		if($attrs['enable_carousel'] == 'true') {

			array_push($package_carousel_attributes, 'data-enablecarousel="true"');
			array_push($package_carousel_attributes, 'data-carouseleffect="'.esc_attr($attrs['carousel_effect']).'"');
			array_push($package_carousel_attributes, 'data-carouselautoplay="'.esc_attr($attrs['carousel_autoplay']).'"');
			array_push($package_carousel_attributes, 'data-carouselslidesperview="'.esc_attr($attrs['carousel_slidesperview']).'"');
			array_push($package_carousel_attributes, 'data-carouselloopmode="'.esc_attr($attrs['carousel_loopmode']).'"');
			array_push($package_carousel_attributes, 'data-carouselmousewheelcontrol="'.esc_attr($attrs['carousel_mousewheelcontrol']).'"');
			array_push($package_carousel_attributes, 'data-carouselbulletpagination="'.esc_attr($attrs['carousel_bulletpagination']).'"');
			array_push($package_carousel_attributes, 'data-carouselarrowpagination="'.esc_attr($attrs['carousel_arrowpagination']).'"');
			array_push($package_carousel_attributes, 'data-carouselspacebetween="'.esc_attr($attrs['carousel_spacebetween']).'"');

			if(!empty($package_carousel_attributes)) {
				$package_carousel_attributes_string = implode(' ', $package_carousel_attributes);
			}

		}

		$output = '';

		$output .= '<div class="dtdr-package-output-data-container dtdr-direct-package-items '.$attrs['class'].'" '.$package_carousel_attributes_string.'>';

			$output .= '<div class="dtdr-package-output-data-holder" '.$data_attributes_string.'></div>';

			if($attrs['enable_carousel'] == 'true') {

				if($attrs['carousel_bulletpagination'] == 'true' || $attrs['carousel_arrowpagination'] == 'true') {
					$output .= '<div class="dtdr-swiper-pagination-holder">';

						if($attrs['carousel_bulletpagination'] == 'true') {
							$output .= '<div class="dtdr-swiper-bullet-pagination"></div>';
						}

						if($attrs['carousel_arrowpagination'] == 'true') {
							$output .= '<div class="dtdr-swiper-arrow-pagination">';
								$output .= '<a href="#" class="dtdr-swiper-arrow-prev">'.esc_html__('Prev', 'dtdr').'</a>';
								$output .= '<a href="#" class="dtdr-swiper-arrow-next">'.esc_html__('Next', 'dtdr').'</a>';
							$output .= '</div>';
						}

					$output .= '</div>';
				}

			}

			$output .= dtdr_generate_loader_html(false);

		$output .= '</div>';

		return $output;

	}
	add_shortcode ( 'dtdr_packages_listing', 'dtdr_packages_listing' );
}

?>