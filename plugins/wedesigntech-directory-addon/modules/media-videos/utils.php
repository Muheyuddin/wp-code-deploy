<?php

// Dashboard Media Videos Field
if(!function_exists('dtdr_listing_media_videos_field')) {
    function dtdr_listing_media_videos_field($item_id) {

        $output = '';

        $output .= '<div class="dtdr-media-videos-box-container">';

            $output .= '<div class="dtdr-media-videos-box-item-holder">';

                $dtdr_media_videos = $dtdr_media_video_quality = '';
                if($item_id > 0) {
                    $dtdr_media_videos = get_post_meta($item_id, 'dtdr_media_videos', true);
                    $dtdr_media_video_quality = get_post_meta($item_id, 'dtdr_media_video_quality', true);
                }

                $j = 0;
                if(is_array($dtdr_media_videos) && !empty($dtdr_media_videos)) {
                    foreach($dtdr_media_videos as $dtdr_media_video) {

                        $output .= '<div class="dtdr-media-videos-box-item">
                                        <div class="dtdr-column dtdr-one-column first">
                                            <input name="dtdr_media_videos[]" class="dtdr_media_videos" type="text" value="'.esc_attr($dtdr_media_video).'" placeholder="'.esc_html__('Video', 'dtdr').'" />
                                        </div>
                                        <div class="dtdr-column dtdr-one-column first">
                                            <input name="dtdr_media_video_quality[]" class="dtdr_media_video_quality" type="text" value="'.esc_attr($dtdr_media_video_quality[$j]).'" placeholder="'.esc_html__('Video Quality', 'dtdr').'" />
                                        </div>
                                        <div class="dtdr-media-videos-box-options">
                                            <span class="dtdr-remove-media-videos"><span class="fas fa-times"></span></span>
                                            <span class="dtdr-sort-media-videos"><span class="fas fa-arrows-alt"></span></span>
                                        </div>
                                    </div>';
                        $j++;
                    }
                }

            $output .= '</div>';

            $output .= '<a href="#" class="dtdr-add-media-videos-box custom-button-style">'.esc_html__('Add Video', 'dtdr').'</a>';

            $output .= '<div class="dtdr-media-videos-box-item-toclone hidden">
                            <div class="dtdr-column dtdr-one-column first">
                                <input id="dtdr_media_videos" type="text" placeholder="'.esc_html__('Video', 'dtdr').'" />
                            </div>
                            <div class="dtdr-column dtdr-one-column first">
                                <input id="dtdr_media_video_quality" type="text" placeholder="'.esc_html__('Video Quality', 'dtdr').'" />
                            </div>
                            <div class="dtdr-media-videos-box-options">
                                <span class="dtdr-remove-media-videos"><span class="fas fa-times"></span></span>
                                <span class="dtdr-sort-media-videos"><span class="fas fa-arrows-alt"></span></span>
                            </div>
                        </div>';

        $output .= '</div>';

        return $output;

    }
}

?>