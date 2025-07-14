jQuery(document).ready(function() {

	"use strict";

	// Make media element as featured item

		jQuery('body').delegate('.dtsl-featured-media-item', 'click', function(e) {

			var this_item = jQuery(this);

			this_item.parents('.dtsl-upload-media-items').find('.dtsl-featured-media-item span').attr('class', 'far fa-user')
			this_item.find('span').attr('class', 'fa fa-user')
			jQuery('#dtsl_featured_image_id').val(this_item.parent('li').find('.uploadfieldid').val());

			e.preventDefault();

		});

});