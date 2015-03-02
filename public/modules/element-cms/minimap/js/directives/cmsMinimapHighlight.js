cmsMinimapApp.directive('cmsMinimapHighlight', function(HoverField) {

  return {
    link: function postLink(scope, element, attrs) {
      var elementFinder = function(identifier) {
        var found = element.find(identifier);
        while (!found.length && typeof identifier === 'string') {
          var pieces = identifier.split(' ');
          if (typeof pieces === 'object') {
            pieces.pop();
            identifier = pieces.join(' ');
            found = element.find(identifier);
          }
        }
        return found;
      };

      var lastElement;
      scope.$watch(function() {
        return HoverField.currentIdentifier;
      }, function(newValue) {
        if (newValue) {
          if (lastElement) {
            lastElement.removeClass('minimap__highlight');
          }
          lastElement = elementFinder(newValue);
          lastElement.addClass('minimap__highlight');
        }
      });
    }
  };

});