<div class="dtdr-custom-box">

    <label><?php echo esc_html__('Add Images', 'dtdr'); ?></label>
    <?php echo dtdr_listing_upload_media_field($list_id); ?>

    <div class="dtdr-note">
        <?php echo sprintf( esc_html__('Add images for your %1$s here.', 'dtdr'), strtolower($listing_singular_label) ); ?>
    </div>

</div>