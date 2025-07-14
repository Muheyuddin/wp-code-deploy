<div class="dtsl-custom-box">

    <label><?php echo esc_html__('Virtual Tour', 'dtsl'); ?></label>
    <?php $dtsl_virtual_tour = get_post_meta($list_id, 'dtsl_virtual_tour', true); ?>
    <textarea name="dtsl_virtual_tour" cols="160" rows="8"><?php echo dtsl_html_output($dtsl_virtual_tour); ?></textarea>
    <div class="dtsl-note"><?php echo sprintf( esc_html__('Add iframe code of your %1$s virtual tour.', 'dtsl'), strtolower($dt_sl_listing_singular_label) ); ?> </div>

</div>