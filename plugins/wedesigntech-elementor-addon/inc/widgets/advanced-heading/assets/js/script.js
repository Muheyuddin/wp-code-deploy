(function ($) {

    const wdtAdvancedHeadingwidgetHandler = function($scope, $) {

        var $animation_elements = $scope.find('.wdt-heading-content-wrapper span');
        var $window = $(window);
        
        $window.on('scroll resize', check_if_in_view);

        function check_if_in_view() {

            var window_height = $window.height();
            var window_top_position = $window.scrollTop();
            var window_bottom_position = (window_top_position + window_height);
          
            $.each($animation_elements, function() {
              var $element = $(this);
              var element_height = $element.outerHeight();
              var element_top_position = $element.offset().top;
              var element_bottom_position = (element_top_position + element_height);

              var rotateAngle = 15;
              var x_value = 0;
              var y_value = 200;
              var $prevElement = $element.parent();

              $prevElement.css({"display":"block", "position": "relative"});
          
              //check to see if this current container is within viewport
              if ((element_bottom_position >= window_top_position) &&
                  (element_top_position <= window_bottom_position)) {

                $element.removeAttr('style');

                // $element.css("transform", "translate("+x_value+"%", +y_value+"%)");
                // $element.css("transform", "translate(0%", "200%)");
                // $element.css("transform", "rotate("+ rotateAngle +"deg)");

              } else {
                // $element.removeClass('in-view');

                $element.css({
                    "display":"block", 
                    "text-align":"start", 
                    "position":"relative", 
                    "opacity":"0",
                    "transform": "translate(" +x_value+ "%, "+y_value+"%)",
                    "rotate": rotateAngle +"deg"
                });
                
              }
            });
        }

            
    };
  
    $(window).on('elementor/frontend/init', function () {
          elementorFrontend.hooks.addAction('frontend/element_ready/wdt-advanced-heading.default', wdtAdvancedHeadingwidgetHandler);
    });
  
  })(jQuery);
  