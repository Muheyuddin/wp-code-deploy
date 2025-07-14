<?php

if(!function_exists('dtsl_generate_countdown_html')) {
	function dtsl_generate_countdown_html($date) {

		$output = '';

		$gmt_offset = get_option('gmt_offset');

		$output .= '<div class="dtsl-countdown-holder" data-date="'.$date.'" data-offset="'.$gmt_offset.'">';
			$output .= '<div class="dtsl-countdown-wrapper">';
				$output .= '<div class="dtsl-countdown-icon-wrapper">';
					$output .= '<div class="dtsl-countdown-number days">00</div>';
				$output .= '</div>';
				$output .= '<h3 class="dtsl-countdown-title">'.esc_html__('Days', 'dtsl').'</h3>';
			$output .= '</div>';
			$output .= '<div class="dtsl-countdown-wrapper">';
				$output .= '<div class="dtsl-countdown-icon-wrapper">';
					$output .= '<div class="dtsl-countdown-number hours">00</div>';
				$output .= '</div>';
				$output .= '<h3 class="dtsl-countdown-title">'.esc_html__('Hours', 'dtsl').'</h3>';
			$output .= '</div>';
			$output .= '<div class="dtsl-countdown-wrapper">';
				$output .= '<div class="dtsl-countdown-icon-wrapper">';
					$output .= '<div class="dtsl-countdown-number minutes">00</div>';
				$output .= '</div>';
				$output .= '<h3 class="dtsl-countdown-title">'.esc_html__('Minutes', 'dtsl').'</h3>';
			$output .= '</div>';
			$output .= '<div class="dtsl-countdown-wrapper last">';
				$output .= '<div class="dtsl-countdown-icon-wrapper">';
					$output .= '<div class="dtsl-countdown-number seconds">00</div>';
				$output .= '</div>';
				$output .= '<h3 class="dtsl-countdown-title">'.esc_html__('Seconds', 'dtsl').'</h3>';
			$output .= '</div>';
		$output .= '</div>';

		return $output;

	}
}

if(!function_exists('dtsl_format_datetime')) {
	function dtsl_format_datetime($unixTime, $format, $without_timezone = false) {

		if($without_timezone == true) {

			$date = new DateTime( "@$unixTime" );

			return $date->format($format);

		} else {

			$timezone = get_option('timezone_string');
			if($timezone == '') {
				$timezone = get_option('gmt_offset');
				$timezone = str_replace($timezone, 'UTC', '');
				$timezone = str_replace($timezone, ':', '');
			}

			if($timezone != '') {

				$UTC = new DateTimeZone("UTC");
				$newTZ = new DateTimeZone($timezone);
				$date = new DateTime( "@$unixTime", $UTC );
				$date->setTimezone( $newTZ );

				return $date->format($format);

			} else {

				$UTC = new DateTimeZone("UTC");
				$date = new DateTime( "@$unixTime", $UTC );

				return $date->format($format);

			}

		}

		return false;

	}
}

?>