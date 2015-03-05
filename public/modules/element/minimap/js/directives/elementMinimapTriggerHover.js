elementMinimapApp.directive('elementMinimapTriggerHover', function(HoverField) {

  return {
    scope: {
      'trigger': '=elementMinimapTriggerHover'
    },
    link: function postLink(scope, element, attrs) {
      $(element).hover(function() {
        scope.$apply(function() {
          HoverField.currentIdentifier = scope.trigger;
        });
      }, function() {
        scope.$apply(function() {
          HoverField.currentIdentifier = '';
        });
      });
    }
  };

});