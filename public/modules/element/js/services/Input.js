elementApp.factory('Input', function() {

  return function postLink(scope, element, attrs, ctrl) {
    ctrl.init();

    scope.history = function() {
      return ctrl.history();
    };

    scope.update = function() {
      return ctrl.update();
    };

    scope.loadMoreHistories = function() {
      return ctrl.loadMoreHistories();
    };
  };

});