jQuery(document).ready(function() {

	"use strict";

	// Attachments

		jQuery('body').delegate('.dtsl-add-attachments-box', 'click', function(e) {

			var clone = jQuery('.dtsl-attachments-box-item-toclone').clone();
			clone.attr('class', 'dtsl-attachments-box-item').removeClass('hidden');
			clone.find('#dtsl_media_attachments_titles').attr('name', 'dtsl_media_attachments_titles[]').removeAttr('id').addClass('dtsl_media_attachments_titles');
			clone.find('#dtsl_media_attachments_items').attr('name', 'dtsl_media_attachments_items[]').removeAttr('id');

			clone.appendTo('.dtsl-attachments-box-item-holder');

			e.preventDefault();

		});

		jQuery('body').delegate('.dtsl-remove-attachments','click', function(e){

			jQuery(this).parents('.dtsl-attachments-box-item').remove();
			e.preventDefault();

		});

		if (jQuery().sortable) {
			jQuery('.dtsl-attachments-box-item-holder').sortable({
				placeholder: 'sortable-placeholder'
			});
		}

});