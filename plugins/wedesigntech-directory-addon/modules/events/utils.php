<?php

if(!function_exists('dtdr_generate_countdown_html')) {
	function dtdr_generate_countdown_html($date) {

		$output = '';

		$gmt_offset = get_option('gmt_offset');

		$output .= '<div class="dtdr-countdown-holder" data-date="'.$date.'" data-offset="'.$gmt_offset.'">';
			$output .= '<div class="dtdr-countdown-wrapper">';
				$output .= '<div class="dtdr-countdown-icon-wrapper">';
					$output .= '<div class="dtdr-countdown-number days">00</div>';
				$output .= '</div>';
				$output .= '<h3 class="dtdr-countdown-title">'.esc_html__('Days', 'dtdr').'</h3>';
			$output .= '</div>';
			$output .= '<div class="dtdr-countdown-wrapper">';
				$output .= '<div class="dtdr-countdown-icon-wrapper">';
					$output .= '<div class="dtdr-countdown-number hours">00</div>';
				$output .= '</div>';
				$output .= '<h3 class="dtdr-countdown-title">'.esc_html__('Hours', 'dtdr').'</h3>';
			$output .= '</div>';
			$output .= '<div class="dtdr-countdown-wrapper">';
				$output .= '<div class="dtdr-countdown-icon-wrapper">';
					$output .= '<div class="dtdr-countdown-number minutes">00</div>';
				$output .= '</div>';
				$output .= '<h3 class="dtdr-countdown-title">'.esc_html__('Minutes', 'dtdr').'</h3>';
			$output .= '</div>';
			$output .= '<div class="dtdr-countdown-wrapper last">';
				$output .= '<div class="dtdr-countdown-icon-wrapper">';
					$output .= '<div class="dtdr-countdown-number seconds">00</div>';
				$output .= '</div>';
				$output .= '<h3 class="dtdr-countdown-title">'.esc_html__('Seconds', 'dtdr').'</h3>';
			$output .= '</div>';
		$output .= '</div>';

		return $output;

	}
}

if(!function_exists('dtdr_format_datetime')) {
	function dtdr_format_datetime($unixTime, $format, $without_timezone = false) {

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