(function ($) {

    const wdtSpeedTestWidgetHandler = function($scope, $) {

        var $speedtest_holder     = $scope.find('.wdt-speed-test-container');
        var $downcount            = $speedtest_holder.find('.wdt-speed-test-content');
        var $counttime            = $downcount.find('.wdt-speed-test-time');
        
        const $counter = setInterval(function() {
            var newdate = new Date();
            var speedtime = newdate.getHours( )+ ":" +  newdate.getMinutes() + ":" +  newdate.getSeconds();
            $counttime.html(speedtime);
        }, 1000);

    }


    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/wdt-speed-test.default', wdtSpeedTestWidgetHandler);
    });
    
})(jQuery);