"use strict";
var elementManagerApp = angular.module('elementManagerApp', []);
elementManagerApp.controller('ManagerCustomTextCtrl', ["$scope", "UniqId", "PAGE", function($scope, UniqId, PAGE) {
  $scope.customs = [{
    identifier: UniqId.generate((PAGE + "-")),
    text: ''
  }];
  $scope.addCustom = function() {
    $scope.customs.push({
      identifier: UniqId.generate((PAGE + "-")),
      text: ''
    });
  };
}]);
elementManagerApp.directive('elementManagerRoutes', ["ROUTES", function(ROUTES) {
  return {link: function postLink(scope, element, attrs) {
      $(element).typeahead({
        hint: true,
        highlight: true,
        minLength: 1
      }, {
        name: 'routes',
        displayKey: 'name',
        source: function(q, cb) {
          var matches = [];
          var substrRegex = new RegExp(q, 'i');
          ROUTES.forEach(function(route) {
            if (substrRegex.test(route.path) || substrRegex.test(route.name)) {
              matches.push({
                name: route.name,
                path: route.path
              });
            }
          });
          cb(matches);
        }
      });
    }};
}]);

//# sourceMappingURL=../element/manager.js.map