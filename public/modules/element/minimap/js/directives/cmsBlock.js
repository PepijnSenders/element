cmsMinimapApp.directive('block', function(Blocks) {

  return {
    scope: {
      'id': '@block'
    },
    link: function postLink(scope, element, attrs) {
      element.addClass('block');
      var index = $('*[block]').index(element);

      element.on('click', function(e) {
        e.preventDefault();
        scope.$apply(function() {
          if (index in Blocks.container) {
            Blocks.remove(index);
          } else {
            Blocks.add(index, scope.id);
          }
        });
      });

      scope.$watch(function() {
        return Blocks.timestamp;
      }, function() {
        if (index in Blocks.container) {
          element.addClass('block--active');
        } else {
          element.removeClass('block--active');
        }
      });
    }
  };

});