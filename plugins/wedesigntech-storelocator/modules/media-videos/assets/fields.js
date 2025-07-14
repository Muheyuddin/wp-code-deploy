jQuery(document).ready(function() {

	"use strict";

	// Media Video

		jQuery('body').delegate('.dtsl-add-media-videos-box', 'click', function(e) {

			var clone = jQuery('.dtsl-media-videos-box-item-toclone').clone();
			clone.attr('class', 'dtsl-media-videos-box-item').removeClass('hidden');
			clone.find('#dtsl_media_videos').attr('name', 'dtsl_media_videos[]').removeAttr('id').addClass('dtsl_media_videos');

			clone.appendTo('.dtsl-media-videos-box-item-holder');

			e.preventDefault();

		});

		jQuery('body').delegate('.dtsl-remove-media-videos','click', function(e){

			jQuery(this).parents('.dtsl-media-videos-box-item').remove();
			e.preventDefault();

		});

		if (jQuery().sortable) {
			jQuery('.dtsl-media-videos-box-item-holder').sortable({
				placeholder: 'sortable-placeholder'
			});
		}

});