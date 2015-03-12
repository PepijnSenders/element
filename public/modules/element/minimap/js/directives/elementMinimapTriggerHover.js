elementMinimapApp.directive('elementMinimapTriggerHover', function(HoverField) {

  return {
    scope: {
      'trigger': '=elementMinimapTriggerHover'
    },
    link: function postLink(scope, element, attrs) {
      element.on('mouseenter', function() {
        scope.$apply(function() {
          HoverField.currentIdentifier = scope.trigger;
        });
      });

      element.on('mouseleave', function() {
        scope.$apply(function() {
          HoverField.currentIdentifier = '';
        });
      });
    }
  };

});