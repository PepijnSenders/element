cmsApp.directive('cmsField', function(Field, MODULE_BASE, HoverField) {

  return {
    scope: {
      global: '=cmsField'
    },
    templateUrl: MODULE_BASE + '/cms-field.html',
    link: function postLink(scope, element, attrs) {
      var getType = function(translation) {
        if (typeof translation === 'string') {
          if (translation.length > 50) {
            return 'textarea';
          } else {
            return 'input';
          }

          if (scope.global.key.endsWith('image') || scope.global.key.endsWith('image')) {
            return 'img';
          } else {
            return 'link';
          }
        } else if (typeof translation === 'object' && scope.global.key.match('slider')) {
          return 'slider-collection';
        } else {
          return 'specs-list';
        }
      };

      scope.type = getType(scope.global.translation);

      element.hover(function() {
        scope.$apply(function() {
          HoverField.currentIdentifier = scope.global.key;
        });
      }, function() {
        scope.$apply(function() {
          HoverField.currentIdentifier = '';
        });
      });
    }
  };

});