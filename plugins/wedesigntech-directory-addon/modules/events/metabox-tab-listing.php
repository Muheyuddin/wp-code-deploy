<div class="dtdr-custom-box">

    <label><?php echo esc_html__('Start Date', 'dtdr'); ?></label>
    <?php $dtdr_start_date = get_post_meta($list_id, 'dtdr_start_date', true); ?>
    <input name="dtdr_start_date" class="dtdr-datepicker" type="text" value="<?php echo esc_attr($dtdr_start_date);?>" />
    <div class="dtdr-note"><?php echo sprintf( esc_html__('Choose start date for your %1$s.', 'dtdr'), strtolower($listing_singular_label) ); ?> </div>

</div>

<div class="dtdr-custom-box">

    <label><?php echo esc_html__('End Date', 'dtdr'); ?></label>
    <?php $dtdr_end_date = get_post_meta($list_id, 'dtdr_end_date', true); ?>
    <input name="dtdr_end_date" class="dtdr-datepicker" type="text" value="<?php echo esc_attr($dtdr_end_date);?>" />
    <div class="dtdr-note"><?php echo sprintf( esc_html__('Choose end date for your %1$s.', 'dtdr'), strtolower($listing_singular_label) ); ?> </div>

</div>

<?php
    $timings = array (
                '' => esc_html__('OFF', 'dtdr'),
                '00:00' => '00:00 ('.esc_html__('midnight', 'dtdr').')',
                '00:30' => '00:30',
                '01:00' => '01:00',
                '01:30' => '01:30',
                '02:00' => '02:00',
                '02:30' => '02:30',
                '03:00' => '03:00',
                '03:30' => '03:30',
                '04:00' => '04:00',
                '04:30' => '04:30',
                '05:00' => '05:00',
                '05:30' => '05:30',
                '06:00' => '06:00',
                '06:30' => '06:30',
                '07:00' => '07:00',
                '07:30' => '07:30',
                '08:00' => '08:00',
                '08:30' => '08:30',
                '09:00' => '09:00',
                '09:30' => '09:30',
                '10:00' => '10:00',
                '10:30' => '10:30',
                '11:00' => '11:00',
                '11:30' => '11:30',
                '12:00' => '12:00 ('.esc_html__('noon', 'dtdr').')',
                '12:30' => '12:30',
                '13:00' => '13:00',
                '13:30' => '13:30',
                '14:00' => '14:00',
                '14:30' => '14:30',
                '15:00' => '15:00',
                '15:30' => '15:30',
                '16:00' => '16:00',
                '16:30' => '16:30',
                '17:00' => '17:00',
                '17:30' => '17:30',
                '18:00' => '18:00',
                '18:30' => '18:30',
                '19:00' => '19:00',
                '19:30' => '19:30',
                '20:00' => '20:00',
                '20:30' => '20:30',
                '21:00' => '21:00',
                '21:30' => '21:30',
                '22:00' => '22:00',
                '22:30' => '22:30',
                '23:00' => '23:00',
                '23:30' => '23:30',
            );
?>

<div class="dtdr-custom-box">

    <label><?php echo esc_html__('Start Time', 'dtdr'); ?></label>
    <?php
    $dtdr_start_time = get_post_meta($list_id, 'dtdr_start_time', true);

    echo '<select name="dtdr_start_time" class="dtdr-chosen-select" data-placeholder="'.esc_html__('OFF', 'dtlms').'">';
        if(count($timings) > 0) {
            foreach($timings as $timing_key => $timing_value) {
                $selected_attribute = '';
                if($timing_key == $dtdr_start_time) {
                    $selected_attribute = 'selected="selected"';
                }
                echo'<option value="'.esc_attr($timing_key).'" '.$selected_attribute.'>'.esc_html( $timing_value).'</option>';
            }
        }
    echo '</select>';
    ?>
    <div class="dtdr-note"><?php echo sprintf( esc_html__('Choose start time for your %1$s.', 'dtdr'), strtolower($listing_singular_label) ); ?> </div>

</div>

<div class="dtdr-custom-box">

    <label><?php echo esc_html__('End Time', 'dtdr'); ?></label>
    <?php
    $dtdr_end_time = get_post_meta($list_id, 'dtdr_end_time', true);

    echo '<select name="dtdr_end_time" class="dtdr-chosen-select" data-placeholder="'.esc_html__('OFF', 'dtlms').'">';
        if(count($timings) > 0) {
            foreach($timings as $timing_key => $timing_value) {
                $selected_attribute = '';
                if($timing_key == $dtdr_end_time) {
                    $selected_attribute = 'selected="selected"';
                }
                echo'<option value="'.esc_attr($timing_key).'" '.$selected_attribute.'>'.esc_html( $timing_value).'</option>';
            }
        }
    echo '</select>';
    ?>
    <div class="dtdr-note"><?php echo sprintf( esc_html__('Choose end time for your %1$s.', 'dtdr'), strtolower($listing_singular_label) ); ?> </div>

</div>

<div class="dtdr-custom-box">

    <label><?php echo esc_html__('24 hour format', 'dtdr'); ?></label>
    <?php
    $dtdr_24_hour_format = get_post_meta($list_id, 'dtdr_24_hour_format', true);
    $switchclass = ($dtdr_24_hour_format == 'true') ? 'checkbox-switch-on' : 'checkbox-switch-off';
    $checked = ($dtdr_24_hour_format == 'true') ? ' checked="checked"' : '';
    ?>
    <div data-for="dtdr_24_hour_format" class="dtdr-checkbox-switch <?php echo esc_attr($switchclass); ?>"></div>
    <input id="dtdr_24_hour_format" class="hidden" type="checkbox" name="dtdr_24_hour_format" value="true" <?php echo dtdr_html_output($checked);?> />
    <div class="dtdr-note"> <?php echo esc_html__('If you like to display time in 24 hour format.', 'dtdr'); ?> </div>

</div>