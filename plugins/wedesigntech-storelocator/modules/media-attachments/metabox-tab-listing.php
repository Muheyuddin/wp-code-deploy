<div class="dtsl-custom-box">

    <label><?php echo esc_html__('Add Attachments', 'dtsl'); ?></label>
    <?php echo dtsl_listing_attachments_field($list_id); ?>

    <div class="dtsl-note">
        <?php echo sprintf( esc_html__('Add attachments for your %1$s here.', 'dtsl'), strtolower($dt_sl_listing_singular_label) ); ?>
    </div>

</div>