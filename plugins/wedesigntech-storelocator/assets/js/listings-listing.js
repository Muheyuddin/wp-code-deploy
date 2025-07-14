( function( $ ) {

	"use strict";

	var dtStoreLocatorListingsListing = function($scope, $){
		dtStoreLocatorFrontend.dtInit();
	};

    $(window).on('elementor/frontend/init', function(){
		elementorFrontend.hooks.addAction('frontend/element_ready/dtsl-widget-df-listings-listing.default', dtStoreLocatorListingsListing);
    });

} )( jQuery );