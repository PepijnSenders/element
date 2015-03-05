elementMinimapApp.directive('elementMinimapScale', function(EventWatcher, $window, TweenMax) {

  return {
    scope: {
      'scale': '=elementMinimapScale'
    },
    link: function postLink(scope, element, attrs) {
      EventWatcher.addEvent('resize');
      scope.$watch(function() {
        return EventWatcher.events['resize'].timeStamp;
      }, function() {
        TweenMax.set($(element).find('#container'), {
          scale: scope.scale || .25,
          force3D: true
        });
        TweenMax.set(element[0].parentNode, {
          width: '100%',
          position: 'fixed'
        });
      });
    }
  };

});