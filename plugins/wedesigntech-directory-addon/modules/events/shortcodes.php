<?php

if(!function_exists('dtdr_sp_event_dates')) {
	function dtdr_sp_event_dates($attrs, $content = null) {

		$attrs = shortcode_atts ( array (

			'listing_id'        => '',
			'type'              => 'type1',
			'include_startdate' => '',
			'include_enddate'   => '',
			'include_postdate'  => '',
			'include_starttime' => '',
			'include_endtime'   => '',
			'include_posttime'  => '',
			'with_label'        => '',
			'with_icon'         => '',
			'merge_dates'       => '',
			'class'             => '',

		), $attrs, 'dtdr_sp_event_dates' );

		$output = '';

		if($attrs['listing_id'] == '' && is_singular('dtdr_listings')) {
			global $post;
			$attrs['listing_id'] = $post->ID;
		}

		if($attrs['listing_id'] != '') {

			$output .= '<div class="dtdr-listings-dates-container '.$attrs['type'].' '.$attrs['class'].'">';

				$dtdr_start_date     = get_post_meta($attrs['listing_id'], 'dtdr_start_date', true);
				$dtdr_start_date     = date(get_option('date_format'), strtotime($dtdr_start_date));

				$dtdr_end_date       = get_post_meta($attrs['listing_id'], 'dtdr_end_date', true);
				$dtdr_end_date       = date(get_option('date_format'), strtotime($dtdr_end_date));

				$dtdr_start_time     = get_post_meta($attrs['listing_id'], 'dtdr_start_time', true);
				$dtdr_end_time       = get_post_meta($attrs['listing_id'], 'dtdr_end_time', true);
				$dtdr_24_hour_format = get_post_meta($attrs['listing_id'], 'dtdr_24_hour_format', true);

				if($attrs['merge_dates'] == 'true') {

					$output .= '<div class="dtdr-listings-date-container">';

						if($attrs['with_icon'] == 'true') {
							$output .= '<span class="dtdr-listings-date-icon"></span>';
						}

						$output .= '<div class="dtdr-listings-datetime-holder">';

							$output .= '<div class="dtdr-listings-date-holder">';
								$output .= $dtdr_start_date.' - '.$dtdr_end_date;
							$output .= '</div>';

							if($attrs['include_starttime'] == 'true' || $attrs['include_endtime'] == 'true') {

								$output .= '<div class="dtdr-listings-time-holder">';

									if($attrs['include_starttime'] == 'true') {

										if($dtdr_24_hour_format == 'true') {
											$output .= $dtdr_start_time;
										} else {
											$output .= date('g:i A', strtotime($dtdr_start_time));
										}

									}

									if($attrs['include_endtime'] == 'true') {

										if($dtdr_24_hour_format == 'true') {
											$output .= ' - '.$dtdr_end_time;
										} else {
											$output .= ' - '.date('g:i A', strtotime($dtdr_end_time));
										}

									}

								$output .= '</div>';

							}

						$output .= '</div>';

					$output .= '</div>';

				} else {

					if($attrs['include_startdate'] == 'true') {

						if($dtdr_start_date != '') {

							$output .= '<div class="dtdr-listings-start-date-container">';

								if($attrs['type'] != 'type1' && $attrs['with_icon'] == 'true') {
									$output .= '<span class="dtdr-listings-start-date-icon"></span>';
								}

								if($attrs['with_label'] == 'true') {
									$output .= '<label class="dtdr-listings-start-date-label">';
										if($attrs['type'] == 'type1' && $attrs['with_icon'] == 'true') {
											$output .= '<span class="dtdr-listings-start-date-icon"></span>';
										}
										$output .= esc_html__('Start Date', 'dtdr');
									$output .= '</label>';
								}

								$output .= '<div class="dtdr-listings-start-datetime-holder">';

									$output .= '<div class="dtdr-listings-start-date-holder">';
										$output .= $dtdr_start_date;
									$output .= '</div>';

									if($attrs['include_starttime'] == 'true' || $attrs['include_endtime'] == 'true') {

										$output .= '<div class="dtdr-listings-start-time-holder">';

											if($attrs['include_starttime'] == 'true') {

												if($dtdr_24_hour_format == 'true') {
													$output .= $dtdr_start_time;
												} else {
													$output .= date('g:i A', strtotime($dtdr_start_time));
												}

											}

											if($attrs['include_endtime'] == 'true') {

												if($dtdr_24_hour_format == 'true') {
													$output .= ' - '.$dtdr_end_time;
												} else {
													$output .= ' - '.date('g:i A', strtotime($dtdr_end_time));
												}

											}

										$output .= '</div>';

									}

								$output .= '</div>';

							$output .= '</div>';

						}

					}

					if($attrs['include_enddate'] == 'true') {

						if($dtdr_end_date != '') {

							$output .= '<div class="dtdr-listings-end-date-container">';

								if($attrs['type'] != 'type1' && $attrs['with_icon'] == 'true') {
									$output .= '<span class="dtdr-listings-end-date-icon"></span>';
								}

								if($attrs['with_label'] == 'true') {
									$output .= '<label class="dtdr-listings-end-date-label">';
										if($attrs['type'] == 'type1' && $attrs['with_icon'] == 'true') {
											$output .= '<span class="dtdr-listings-end-date-icon"></span>';
										}
										$output .= esc_html__('End Date', 'dtdr');
									$output .= '</label>';
								}

								$output .= '<div class="dtdr-listings-end-datetime-holder">';

									$output .= '<div class="dtdr-listings-end-date-holder">';
										$output .= $dtdr_end_date;
									$output .= '</div>';

									if($attrs['include_starttime'] == 'true' || $attrs['include_endtime'] == 'true') {

										$output .= '<div class="dtdr-listings-end-time-holder">';

											if($attrs['include_starttime'] == 'true') {

												if($dtdr_24_hour_format == 'true') {
													$output .= $dtdr_start_time;
												} else {
													$output .= date('g:i A', strtotime($dtdr_start_time));
												}

											}

											if($attrs['include_endtime'] == 'true') {

												if($dtdr_24_hour_format == 'true') {
													$output .= ' - '.$dtdr_end_time;
												} else {
													$output .= ' - '.date('g:i A', strtotime($dtdr_end_time));
												}

											}

										$output .= '</div>';

									}

								$output .= '</div>';

							$output .= '</div>';

						}

					}

					if($attrs['include_postdate'] == 'true') {

						$dtdr_post_date = get_the_date( get_option('date_format'), $attrs['listing_id'] );

						if($dtdr_post_date != '') {

							$output .= '<div class="dtdr-listings-post-date-container">';

								if($attrs['type'] != 'type1' && $attrs['with_icon'] == 'true') {
									$output .= '<span class="dtdr-listings-post-date-icon"></span>';
								}

								if($attrs['with_label'] == 'true') {
									$output .= '<label class="dtdr-listings-post-date-label">';
										if($attrs['type'] == 'type1' && $attrs['with_icon'] == 'true') {
											$output .= '<span class="dtdr-listings-post-date-icon"></span>';
										}
										$output .= esc_html__('Released on: ', 'dtdr');
									$output .= '</label>';
								}

								$output .= '<div class="dtdr-listings-post-datetime-holder">';

									$output .= '<div class="dtdr-listings-post-date-holder">';
										$output .= $dtdr_post_date;
									$output .= '</div>';

									if($attrs['include_posttime'] == 'true') {

										$output .= '<div class="dtdr-listings-post-time-holder">';

											$dtdr_24_hour_format = get_post_meta($attrs['listing_id'], 'dtdr_24_hour_format', true);

											if($dtdr_24_hour_format == 'true') {
												$output .= get_the_time( 'G:i', $attrs['listing_id'] );
											} else {
												$output .= get_the_time( 'g:i A', $attrs['listing_id'] );
											}

										$output .= '</div>';

									}

								$output .= '</div>';

							$output .= '</div>';
						}

					}

				}

			$output .= '</div>';

		} else {

			$listing_singular_label = apply_filters( 'listing_label', 'singular' );

			$output .= sprintf( esc_html__('Please provide %1$s id to display corresponding data!', 'dtdr'), strtolower($listing_singular_label) );

		}

		return $output;

	}
	add_shortcode ( 'dtdr_sp_event_dates', 'dtdr_sp_event_dates' );
}

if(!function_exists('dtdr_sf_startdate_field')) {
	function dtdr_sf_startdate_field( $attrs, $content = null ) {

		$attrs = shortcode_atts ( array (

					'placeholder_text' => '',
					'ajax_load' => '',
					'class' => '',

				), $attrs, 'dtdr_sf_startdate_field' );


		$output = '';

		$output .= '<div class="dtdr-sf-fields-holder dtdr-sf-startdate-field-holder '.$attrs['class'].'">';

			$additional_class = '';
			if($attrs['ajax_load'] == 'true') {
				$additional_class = 'dtdr-with-ajax-load';
			}

			$dtdr_sf_startdate = '';
			if(isset($_REQUEST['dtdr_sf_startdate'])) {
				if($_REQUEST['dtdr_sf_startdate'] != '') {
					$dtdr_sf_startdate = dtdr_recursive_sanitize_text_field($_REQUEST['dtdr_sf_startdate']);
				}
			}

			$placeholder_text = esc_html__('Start Date', 'dtdr');
			if($attrs['placeholder_text'] != '') {
				$placeholder_text = esc_html($attrs['placeholder_text']);
			}

			$output .= '<input type="text" name="dtdr_sf_startdate" class="dtdr-sf-field dtdr-sf-startdate '.esc_attr($additional_class).' dtdr-datepicker" placeholder="'.esc_attr($placeholder_text).'" value="'.esc_attr($dtdr_sf_startdate).'">';
			$output .= '<span></span>';

		$output .= '</div>';

		return $output;

	}
	add_shortcode ( 'dtdr_sf_startdate_field', 'dtdr_sf_startdate_field' );
}

if(!function_exists('dtdr_sp_countdown_timer')) {
	function dtdr_sp_countdown_timer( $attrs, $content = null ) {

		$attrs = shortcode_atts ( array (

					'listing_id'                => '',
					'type'                      => 'type1',
					'timer_for'                 => 'start-date',
					'include_time'              => '',
					'disable_shortcode_section' => '',
					'countdown_completed_text'  => '',
					'class'                     => ''

				), $attrs, 'dtdr_sp_countdown_timer' );

		$output = '';

		if($attrs['listing_id'] == '' && is_singular('dtdr_listings')) {
			global $post;
			$attrs['listing_id'] = $post->ID;
		}

		if($attrs['listing_id'] != '') {

			if($attrs['timer_for'] == 'end-date') {

				$dtdr_end_date = get_post_meta($attrs['listing_id'], 'dtdr_end_date', true);
				$dtdr_end_time = '';
				if($attrs['include_time'] == 'true') {
					$dtdr_end_time = get_post_meta($attrs['listing_id'], 'dtdr_end_time', true);
					$dtdr_end_time = ' '.$dtdr_end_time;
				}
				$dtdr_countdown_date = strtotime($dtdr_end_date.$dtdr_end_time);

			} else {

				$dtdr_start_date = get_post_meta($attrs['listing_id'], 'dtdr_start_date', true);
				$dtdr_start_time = '';
				if($attrs['include_time'] == 'true') {
					$dtdr_start_time = get_post_meta($attrs['listing_id'], 'dtdr_start_time', true);
					$dtdr_start_time = ' '.$dtdr_start_time;
				}
				$dtdr_countdown_date = strtotime($dtdr_start_date.$dtdr_start_time);

			}

			$current_timestamp = strtotime(current_time(get_option('date_format').' '.get_option('time_format')));
			if($current_timestamp > $dtdr_countdown_date) {

				if($attrs['disable_shortcode_section'] != 'true') {

					$output .= '<div class="dtdr-listings-countdown-timer-container '.$attrs['type'].' '.$attrs['class'].'">';

						$countdown_completed_text = esc_html__('Event is active now!', 'dtdr');
						if($attrs['countdown_completed_text'] != '') {
							$countdown_completed_text = $attrs['countdown_completed_text'];
						}
						$output .= '<div class="dtdr-listings-countdown-timer-holder">';
							$output .= '<div class="dtdr-listings-countdown-timer-notice"><span>'.$countdown_completed_text.'</span></div>';
						$output .= '</div>';

					$output .= '</div>';

				}

			} else {

				$output .= '<div class="dtdr-listings-countdown-timer-container '.$attrs['type'].' '.$attrs['class'].'">';

					$countdown_date = dtdr_format_datetime($dtdr_countdown_date, 'm/d/Y H:i:s', true);
					$output .= '<div class="dtdr-listings-countdown-timer-holder">';
						$output .= dtdr_generate_countdown_html($countdown_date);
					$output .= '</div>';

				$output .= '</div>';

			}

		} else {

			$listing_singular_label = apply_filters( 'listing_label', 'singular' );

			$output .= sprintf( esc_html__('Please provide %1$s id to display corresponding data!', 'dtdr'), strtolower($listing_singular_label) );

		}

		return $output;

	}
	add_shortcode ( 'dtdr_sp_countdown_timer', 'dtdr_sp_countdown_timer' );
}

?>