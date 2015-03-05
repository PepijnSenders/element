elementMinimapApp.directive('elementMinimapHighlight', function(HoverField, ElementFinder) {

  return {
    link: function postLink(scope, element, attrs) {
      scope.$watch(function() {
        return HoverField.currentIdentifier;
      }, function(newValue) {
        $(element).find('.minimap__highlight').removeClass('minimap__highlight');

        if (newValue) {
          var found = ElementFinder.get(element, newValue);

          found.addClass('minimap__highlight');
        }
      });
    }
  };

});