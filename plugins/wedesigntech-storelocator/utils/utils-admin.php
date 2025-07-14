<?php

if( !function_exists( 'dtsl_adminpanel_image_preview' ) ){
	function dtsl_adminpanel_image_preview($src) {

		$default = DTSL_PLUGIN_URL.'assets/images/backend/no-image.jpg';
		$src = !empty($src) ? $src : $default;

		$output = '';

		$output .= '<div class="dtsl-image-preview-holder">';
			$output .= '<a href="#" class="dtsl-image-preview" onclick="return false;">';
				$output .= '<img src="'.DTSL_PLUGIN_URL.'assets/images/backend/image-preview.png" alt="'.esc_html__('Image Preview', 'dtsl').'" title="'.esc_html__('Image Preview', 'dtsl').'" />';
				$output .= '<div class="dtsl-image-preview-tooltip">';
					$output .= '<img src="'.$src.'" data-default="'.$default.'"  alt="'.esc_html__('Image Preview Tooltip', 'dtsl').'" title="'.esc_html__('Image Preview Tooltip', 'dtsl').'" />';
				$output .= '</div>';
			$output .= '</a>';
		$output .= '</div>';

		return $output;

	}
}

if( !function_exists( 'dtsl_adminpanel_image_holder' ) ){
	function dtsl_adminpanel_image_holder($src) {

		$default = DTSL_PLUGIN_URL.'assets/images/backend/no-image.jpg';
		$src = !empty($src) ? $src : $default;

		$output = '';

		$output .= '<div class="dtsl-image-holder">
						<img src="'.$src.'" data-default="'.$default.'"  alt="'.esc_html__('Image Preview', 'dtsl').'" title="'.esc_html__('Image Preview', 'dtsl').'" />
					</div>';

		return $output;

	}
}
?>