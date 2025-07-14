var dtStoreLocatorBackendUtils = {

	dtStoreLocatorCheckboxSwitch : function() {

		jQuery('.dtsl-checkbox-switch:not(.disabled)').each( function() {
			jQuery(this).on('click', function(e) {

				var $ele = '#' + jQuery(this).attr('data-for');
				jQuery(this).toggleClass('checkbox-switch-off checkbox-switch-on');

				if (jQuery(this).hasClass('checkbox-switch-on')) {
					jQuery($ele).attr('checked', 'checked');
				} else {
					jQuery($ele).removeAttr('checked');
				}

				e.preventDefault();

			});
		});

	},

	dtStoreLocatorAjaxBeforeSend : function(this_item) {

		if(this_item != undefined) {
			if(!this_item.find('.dtsl-ajax-load-image').hasClass('first')) {
				this_item.find('.dtsl-ajax-load-image').show();
			} else {
				this_item.find('.dtsl-ajax-load-image').removeClass('first');
			}
		} else {
			if(!jQuery('.dtsl-ajax-load-image').hasClass('first')) {
				jQuery('.dtsl-ajax-load-image').show();
			} else {
				jQuery('.dtsl-ajax-load-image').removeClass('first');
			}
		}

	},

	dtStoreLocatorAjaxAfterSend : function(this_item) {

		if(this_item != undefined) {
			this_item.find('.dtsl-ajax-load-image').hide();
		} else {
			jQuery('.dtsl-ajax-load-image').hide();
		}

	},

	dtStoreLocatorVerticalTab : function(this_item) {

		if(('ul.dtsl-tabs-vertical').length > 0) {
			jQuery('ul.dtsl-tabs-vertical').each(function(){
				var $effect = jQuery(this).parent('.dtsl-tabs-vertical-container').attr('data-effect');
				jQuery(this).dtStoreLocatorTabs('> .dtsl-tabs-vertical-content', {
					effect: $effect
				});
			});

			jQuery('.dtsl-tabs-vertical').each(function(){
				jQuery(this).find('li:first').addClass('first').addClass('current');
				jQuery(this).find('li:last').addClass('last');
			});

			jQuery('.dtsl-tabs-vertical li').on('click', function(){
				jQuery(this).parent().children().removeClass('current');
				jQuery(this).addClass('current');
			});
		}

	}

};

var dtStoreLocatorBackend = {

	dtInit : function() {
		dtStoreLocatorBackend.dtStoreLocator();
		dtStoreLocatorBackend.dtSettings();
		dtStoreLocatorBackend.dtImport();
	},

	dtStoreLocator : function() {

		// Checkbox switch
		dtStoreLocatorBackendUtils.dtStoreLocatorCheckboxSwitch();

		// Vertical Tabs
		dtStoreLocatorBackendUtils.dtStoreLocatorVerticalTab();


		// Initaialize color picker
		if(jQuery('.dtsl-color-field').length) {
			jQuery('.dtsl-color-field').wpColorPicker();
		}

	},

	dtSettings : function() {

		// Save Backend Options

		jQuery( 'body' ).delegate( '.dtsl-save-options-settings', 'click', function(e) {

			var this_item = jQuery(this),
				settings = this_item.attr('data-settings');

	        var form = jQuery('.formOptionSettings')[0];
	        var data = new FormData(form);
	        data.append('action', 'dtsl_save_options_settings');
	        data.append('settings', settings);

			jQuery.ajax({
				type: "POST",
				url: dtslbackendobject.ajaxurl,
				data: data,
	            processData: false,
	            contentType: false,
	            cache: false,
				beforeSend: function(){
					this_item.prepend( '<span><i class="fa fa-spinner fa-spin"></i></span>' );
				},
				success: function (response) {
					this_item.parents('.formOptionSettings').find('.dtsl-option-settings-response-holder').html(response);
					this_item.parents('.formOptionSettings').find('.dtsl-option-settings-response-holder').show();
					window.setTimeout(function(){
						this_item.parents('.formOptionSettings').find('.dtsl-option-settings-response-holder').fadeOut('slow');
					}, 2000);
				},
				complete: function(){
					this_item.find('span').remove();
				}
			});

			e.preventDefault();

		});

		// Skin

		jQuery( 'body' ).delegate( '.dtsl-save-skin-settings', 'click', function(e) {

			var this_item = jQuery(this);

	        var form = jQuery('.formSkinSettings')[0];
	        var data = new FormData(form);
	        data.append('action', 'dtsl_save_skin_settings');

			jQuery.ajax({
				type: "POST",
				url: dtslbackendobject.ajaxurl,
				data: data,
	            processData: false,
	            contentType: false,
	            cache: false,
				beforeSend: function(){
					this_item.prepend( '<span><i class="fa fa-spinner fa-spin"></i></span>' );
				},
				success: function (response) {
					this_item.parents('.formSkinSettings').find('.dtsl-skin-settings-response-holder').html(response);
					window.setTimeout(function(){
						this_item.parents('.formSkinSettings').find('.dtsl-skin-settings-response-holder').fadeOut('slow');
					}, 2000);
				},
				complete: function(){
					this_item.find('span').remove();
				}
			});

			e.preventDefault();

		});

	},

	dtImport : function() {

		var file_frame = attachments_url = '';

		jQuery('.dtsl-chooseupload-file-button').on('click', function(e){

		    if ( file_frame ) {
		      file_frame.open();
		      return;
		    }

		    file_frame = wp.media.frames.file_frame = wp.media({
		    	multiple: false,
		    	title : dtslbackendobject.importUploadTitle,
		    	button :{
		    		text : dtslbackendobject.importInsertFile
		    	}
		    });

		    file_frame.on( 'select', function() {

		        var attachments = file_frame.state().get('selection').toJSON();
		        var attachments_url	= attachments[0].url;
		        var attachments_id	= attachments[0].id;

		        jQuery('.dtsl-import-file').val(attachments_url);
		        jQuery('.dtsl-import-file-id').val(attachments_id);

		    });

		    file_frame.open();


		});

		jQuery( 'body' ).delegate( '.dtsl-import-file-button', 'click', function(e) {

			if(!confirm(dtslbackendobject.confirmImport)) {
				return false;
			}

			var this_item = jQuery(this);
			var attachments_url = jQuery('.dtsl-import-file').val();
			var attachments_id = jQuery('.dtsl-import-file-id').val();

			jQuery.ajax({
				type: "POST",
				url: dtslbackendobject.ajaxurl,
				data:
				{
					action: 'dtsl_process_imported_file',
					import_file: attachments_url,
					import_id: attachments_id,
				},
				beforeSend: function(){
					this_item.prepend( '<span><i class="fa fa-spinner fa-spin"></i></span>' );
				},
				success: function (response) {
					this_item.parents('.dtsl-settings-import-container').find('.dtsl-import-settings-response-holder').html(response);
					this_item.parents('.dtsl-settings-import-container').find('.dtsl-import-settings-response-holder').show();
					window.setTimeout(function(){
						this_item.parents('.dtsl-settings-import-container').find('.dtsl-import-settings-response-holder').fadeOut('slow');
					}, 2000);
				},
				complete: function(){
					this_item.find('span').remove();
				}
			});

			e.preventDefault();

		});

	}

};

jQuery(document).ready(function() {

	"use strict";

	dtStoreLocatorBackend.dtInit();

});