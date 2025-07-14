<?php

if(!function_exists('dtsl_sp_event_dates')) {
	function dtsl_sp_event_dates($attrs, $content = null) {

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

		), $attrs, 'dtsl_sp_event_dates' );

		$output = '';

		if($attrs['listing_id'] == '' && is_singular('dtsl_listings')) {
			global $post;
			$attrs['listing_id'] = $post->ID;
		}

		if($attrs['listing_id'] != '') {

			$output .= '<div class="dtsl-listings-dates-container '.$attrs['type'].' '.$attrs['class'].'">';

				$dtsl_start_date     = get_post_meta($attrs['listing_id'], 'dtsl_start_date', true);
				$dtsl_start_date     = date(get_option('date_format'), strtotime($dtsl_start_date));

				$dtsl_end_date       = get_post_meta($attrs['listing_id'], 'dtsl_end_date', true);
				$dtsl_end_date       = date(get_option('date_format'), strtotime($dtsl_end_date));

				$dtsl_start_time     = get_post_meta($attrs['listing_id'], 'dtsl_start_time', true);
				$dtsl_end_time       = get_post_meta($attrs['listing_id'], 'dtsl_end_time', true);
				$dtsl_24_hour_format = get_post_meta($attrs['listing_id'], 'dtsl_24_hour_format', true);

				if($attrs['merge_dates'] == 'true') {

					$output .= '<div class="dtsl-listings-date-container">';

						if($attrs['with_icon'] == 'true') {
							$output .= '<span class="dtsl-listings-date-icon"></span>';
						}

						$output .= '<div class="dtsl-listings-datetime-holder">';

							$output .= '<div class="dtsl-listings-date-holder">';
								$output .= $dtsl_start_date.' - '.$dtsl_end_date;
							$output .= '</div>';

							if($attrs['include_starttime'] == 'true' || $attrs['include_endtime'] == 'true') {

								$output .= '<div class="dtsl-listings-time-holder">';

									if($attrs['include_starttime'] == 'true') {

										if($dtsl_24_hour_format == 'true') {
											$output .= $dtsl_start_time;
										} else {
											$output .= date('g:i A', strtotime($dtsl_start_time));
										}

									}

									if($attrs['include_endtime'] == 'true') {

										if($dtsl_24_hour_format == 'true') {
											$output .= ' - '.$dtsl_end_time;
										} else {
											$output .= ' - '.date('g:i A', strtotime($dtsl_end_time));
										}

									}

								$output .= '</div>';

							}

						$output .= '</div>';

					$output .= '</div>';

				} else {

					if($attrs['include_startdate'] == 'true') {

						if($dtsl_start_date != '') {

							$output .= '<div class="dtsl-listings-start-date-container">';

								if($attrs['type'] != 'type1' && $attrs['with_icon'] == 'true') {
									$output .= '<span class="dtsl-listings-start-date-icon"></span>';
								}

								if($attrs['with_label'] == 'true') {
									$output .= '<label class="dtsl-listings-start-date-label">';
										if($attrs['type'] == 'type1' && $attrs['with_icon'] == 'true') {
											$output .= '<span class="dtsl-listings-start-date-icon"></span>';
										}
										$output .= esc_html__('Start Date', 'dtsl');
									$output .= '</label>';
								}

								$output .= '<div class="dtsl-listings-start-datetime-holder">';

									$output .= '<div class="dtsl-listings-start-date-holder">';
										$output .= $dtsl_start_date;
									$output .= '</div>';

									if($attrs['include_starttime'] == 'true' || $attrs['include_endtime'] == 'true') {

										$output .= '<div class="dtsl-listings-start-time-holder">';

											if($attrs['include_starttime'] == 'true') {

												if($dtsl_24_hour_format == 'true') {
													$output .= $dtsl_start_time;
												} else {
													$output .= date('g:i A', strtotime($dtsl_start_time));
												}

											}

											if($attrs['include_endtime'] == 'true') {

												if($dtsl_24_hour_format == 'true') {
													$output .= ' - '.$dtsl_end_time;
												} else {
													$output .= ' - '.date('g:i A', strtotime($dtsl_end_time));
												}

											}

										$output .= '</div>';

									}

								$output .= '</div>';

							$output .= '</div>';

						}

					}

					if($attrs['include_enddate'] == 'true') {

						if($dtsl_end_date != '') {

							$output .= '<div class="dtsl-listings-end-date-container">';

								if($attrs['type'] != 'type1' && $attrs['with_icon'] == 'true') {
									$output .= '<span class="dtsl-listings-end-date-icon"></span>';
								}

								if($attrs['with_label'] == 'true') {
									$output .= '<label class="dtsl-listings-end-date-label">';
										if($attrs['type'] == 'type1' && $attrs['with_icon'] == 'true') {
											$output .= '<span class="dtsl-listings-end-date-icon"></span>';
										}
										$output .= esc_html__('End Date', 'dtsl');
									$output .= '</label>';
								}

								$output .= '<div class="dtsl-listings-end-datetime-holder">';

									$output .= '<div class="dtsl-listings-end-date-holder">';
										$output .= $dtsl_end_date;
									$output .= '</div>';

									if($attrs['include_starttime'] == 'true' || $attrs['include_endtime'] == 'true') {

										$output .= '<div class="dtsl-listings-end-time-holder">';

											if($attrs['include_starttime'] == 'true') {

												if($dtsl_24_hour_format == 'true') {
													$output .= $dtsl_start_time;
												} else {
													$output .= date('g:i A', strtotime($dtsl_start_time));
												}

											}

											if($attrs['include_endtime'] == 'true') {

												if($dtsl_24_hour_format == 'true') {
													$output .= ' - '.$dtsl_end_time;
												} else {
													$output .= ' - '.date('g:i A', strtotime($dtsl_end_time));
												}

											}

										$output .= '</div>';

									}

								$output .= '</div>';

							$output .= '</div>';

						}

					}

					if($attrs['include_postdate'] == 'true') {

						$dtsl_post_date = get_the_date( get_option('date_format'), $attrs['listing_id'] );

						if($dtsl_post_date != '') {

							$output .= '<div class="dtsl-listings-post-date-container">';

								if($attrs['type'] != 'type1' && $attrs['with_icon'] == 'true') {
									$output .= '<span class="dtsl-listings-post-date-icon"></span>';
								}

								if($attrs['with_label'] == 'true') {
									$output .= '<label class="dtsl-listings-post-date-label">';
										if($attrs['type'] == 'type1' && $attrs['with_icon'] == 'true') {
											$output .= '<span class="dtsl-listings-post-date-icon"></span>';
										}
										$output .= esc_html__('Posted On: ', 'dtsl');
									$output .= '</label>';
								}

								$output .= '<div class="dtsl-listings-post-datetime-holder">';

									$output .= '<div class="dtsl-listings-post-date-holder">';
										$output .= $dtsl_post_date;
									$output .= '</div>';

									if($attrs['include_posttime'] == 'true') {

										$output .= '<div class="dtsl-listings-post-time-holder">';

											$dtsl_24_hour_format = get_post_meta($attrs['listing_id'], 'dtsl_24_hour_format', true);

											if($dtsl_24_hour_format == 'true') {
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

			$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );

			$output .= sprintf( esc_html__('Please provide %1$s id to display corresponding data!', 'dtsl'), strtolower($dt_sl_listing_singular_label) );

		}

		return $output;

	}
	add_shortcode ( 'dtsl_sp_event_dates', 'dtsl_sp_event_dates' );
}

if(!function_exists('dtsl_sf_startdate_field')) {
	function dtsl_sf_startdate_field( $attrs, $content = null ) {

		$attrs = shortcode_atts ( array (

					'placeholder_text' => '',
					'ajax_load' => '',
					'class' => '',

				), $attrs, 'dtsl_sf_startdate_field' );


		$output = '';

		$output .= '<div class="dtsl-sf-fields-holder dtsl-sf-startdate-field-holder '.$attrs['class'].'">';

			$additional_class = '';
			if($attrs['ajax_load'] == 'true') {
				$additional_class = 'dtsl-with-ajax-load';
			}

			$dtsl_sf_startdate = '';
			if(isset($_REQUEST['dtsl_sf_startdate'])) {
				if($_REQUEST['dtsl_sf_startdate'] != '') {
					$dtsl_sf_startdate = dtsl_recursive_sanitize_text_field($_REQUEST['dtsl_sf_startdate']);
				}
			}

			$placeholder_text = esc_html__('Start Date', 'dtsl');
			if($attrs['placeholder_text'] != '') {
				$placeholder_text = esc_html($attrs['placeholder_text']);
			}

			$output .= '<input type="text" name="dtsl_sf_startdate" class="dtsl-sf-field dtsl-sf-startdate '.esc_attr($additional_class).' dtsl-datepicker" placeholder="'.esc_attr($placeholder_text).'" value="'.esc_attr($dtsl_sf_startdate).'">';
			$output .= '<span></span>';

		$output .= '</div>';

		return $output;

	}
	add_shortcode ( 'dtsl_sf_startdate_field', 'dtsl_sf_startdate_field' );
}

if(!function_exists('dtsl_sp_countdown_timer')) {
	function dtsl_sp_countdown_timer( $attrs, $content = null ) {

		$attrs = shortcode_atts ( array (

					'listing_id'                => '',
					'type'                      => 'type1',
					'timer_for'                 => 'start-date',
					'include_time'              => '',
					'disable_shortcode_section' => '',
					'countdown_completed_text'  => '',
					'class'                     => ''

				), $attrs, 'dtsl_sp_countdown_timer' );

		$output = '';

		if($attrs['listing_id'] == '' && is_singular('dtsl_listings')) {
			global $post;
			$attrs['listing_id'] = $post->ID;
		}

		if($attrs['listing_id'] != '') {

			if($attrs['timer_for'] == 'end-date') {

				$dtsl_end_date = get_post_meta($attrs['listing_id'], 'dtsl_end_date', true);
				$dtsl_end_time = '';
				if($attrs['include_time'] == 'true') {
					$dtsl_end_time = get_post_meta($attrs['listing_id'], 'dtsl_end_time', true);
					$dtsl_end_time = ' '.$dtsl_end_time;
				}
				$dtsl_countdown_date = strtotime($dtsl_end_date.$dtsl_end_time);

			} else {

				$dtsl_start_date = get_post_meta($attrs['listing_id'], 'dtsl_start_date', true);
				$dtsl_start_time = '';
				if($attrs['include_time'] == 'true') {
					$dtsl_start_time = get_post_meta($attrs['listing_id'], 'dtsl_start_time', true);
					$dtsl_start_time = ' '.$dtsl_start_time;
				}
				$dtsl_countdown_date = strtotime($dtsl_start_date.$dtsl_start_time);

			}

			$current_timestamp = strtotime(current_time(get_option('date_format').' '.get_option('time_format')));
			if($current_timestamp > $dtsl_countdown_date) {

				if($attrs['disable_shortcode_section'] != 'true') {

					$output .= '<div class="dtsl-listings-countdown-timer-container '.$attrs['type'].' '.$attrs['class'].'">';

						$countdown_completed_text = esc_html__('Event is active now!', 'dtsl');
						if($attrs['countdown_completed_text'] != '') {
							$countdown_completed_text = $attrs['countdown_completed_text'];
						}
						$output .= '<div class="dtsl-listings-countdown-timer-holder">';
							$output .= '<div class="dtsl-listings-countdown-timer-notice"><span>'.$countdown_completed_text.'</span></div>';
						$output .= '</div>';

					$output .= '</div>';

				}

			} else {

				$output .= '<div class="dtsl-listings-countdown-timer-container '.$attrs['type'].' '.$attrs['class'].'">';

					$countdown_date = dtsl_format_datetime($dtsl_countdown_date, 'm/d/Y H:i:s', true);
					$output .= '<div class="dtsl-listings-countdown-timer-holder">';
						$output .= dtsl_generate_countdown_html($countdown_date);
					$output .= '</div>';

				$output .= '</div>';

			}

		} else {

			$dt_sl_listing_singular_label = apply_filters( 'dt_sl_listing_label', 'singular' );

			$output .= sprintf( esc_html__('Please provide %1$s id to display corresponding data!', 'dtsl'), strtolower($dt_sl_listing_singular_label) );

		}

		return $output;

	}
	add_shortcode ( 'dtsl_sp_countdown_timer', 'dtsl_sp_countdown_timer' );
}

?>