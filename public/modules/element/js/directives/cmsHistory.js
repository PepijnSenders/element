cmsApp.directive('cmsHistory', function(MODULE_BASE, USER_SHOW) {

  return {
    scope: {
      'histories': '=cmsHistory'
    },
    templateUrl: MODULE_BASE + '/cms-history.html',
    link: function postLink(scope, element, attrs) {
      scope.linkBase = USER_SHOW + '/';

      scope.loadMore = function() {
        scope.$parent.loadMoreHistories()
          .then(function(histories) {
            scope.finished = histories.current_page === histories.last_page;
          });
      };

      scope.$watch('histories.length', function(newValue) {
        if (newValue === void 0) {
          scope.finished = false;
        }
      });
    }
  };

});