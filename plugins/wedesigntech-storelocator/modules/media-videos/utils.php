<?php

// Dashboard Media Videos Field
if(!function_exists('dtsl_listing_media_videos_field')) {
    function dtsl_listing_media_videos_field($item_id) {

        $output = '';

        $output .= '<div class="dtsl-media-videos-box-container">';

            $output .= '<div class="dtsl-media-videos-box-item-holder">';

                $dtsl_media_videos = '';
                if($item_id > 0) {
                    $dtsl_media_videos = get_post_meta($item_id, 'dtsl_media_videos', true);
                }

                $j = 0;
                if(is_array($dtsl_media_videos) && !empty($dtsl_media_videos)) {
                    foreach($dtsl_media_videos as $dtsl_media_video) {

                        $output .= '<div class="dtsl-media-videos-box-item">
                                        <div class="dtsl-column dtsl-one-column first">
                                            <input name="dtsl_media_videos[]" class="dtsl_media_videos" type="text" value="'.esc_attr($dtsl_media_video).'" placeholder="'.esc_html__('Video', 'dtsl').'" />
                                        </div>
                                        <div class="dtsl-media-videos-box-options">
                                            <span class="dtsl-remove-media-videos"><span class="fas fa-times"></span></span>
                                            <span class="dtsl-sort-media-videos"><span class="fas fa-arrows-alt"></span></span>
                                        </div>
                                    </div>';
                        $j++;
                    }
                }

            $output .= '</div>';

            $output .= '<a href="#" class="dtsl-add-media-videos-box custom-button-style">'.esc_html__('Add Video', 'dtsl').'</a>';

            $output .= '<div class="dtsl-media-videos-box-item-toclone hidden">
                            <div class="dtsl-column dtsl-one-column first">
                                <input id="dtsl_media_videos" type="text" placeholder="'.esc_html__('Video', 'dtsl').'" />
                            </div>
                            <div class="dtsl-media-videos-box-options">
                                <span class="dtsl-remove-media-videos"><span class="fas fa-times"></span></span>
                                <span class="dtsl-sort-media-videos"><span class="fas fa-arrows-alt"></span></span>
                            </div>
                        </div>';

        $output .= '</div>';

        return $output;

    }
}

?>