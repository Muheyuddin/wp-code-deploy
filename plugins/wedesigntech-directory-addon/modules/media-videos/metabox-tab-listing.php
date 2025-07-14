<div class="dtdr-custom-box">

    <label><?php echo esc_html__('Add Videos', 'dtdr'); ?></label>
    <?php echo dtdr_listing_media_videos_field($list_id); ?>

    <div class="dtdr-note">
        <?php echo sprintf( esc_html__('Add videos for your %1$s here.', 'dtdr'), strtolower($listing_singular_label) ); ?>
    </div>

</div>