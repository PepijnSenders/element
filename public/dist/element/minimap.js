"use strict";
var elementMinimapApp = angular.module('elementMinimapApp', []);
elementMinimapApp.controller('MinimapBlocksCtrl', ["$scope", "SweetAlert", function($scope, SweetAlert) {
  $scope.blocks = {identifiers: []};
  $scope.addIdentifier = function(identifier) {
    if (!!~$scope.blocks.identifiers.indexOf(identifier)) {
      SweetAlert.swal('You cannot add one block twice.');
    } else {
      $scope.blocks.identifiers.push(identifier);
    }
  };
}]);
elementMinimapApp.factory('ElementFinder', function() {
  return {get: function(element, identifier) {
      identifier = identifier.compact();
      var found = $(element).find(identifier);
      while (!found.length && identifier.length) {
        var pieces = identifier.split(' ');
        pieces.pop();
        identifier = pieces.join(' ').compact();
        found = $(element).find(identifier);
      }
      while (!found.is(':visible') && $(element).has(found).length) {
        found = found.parent();
      }
      return found;
    }};
});
elementMinimapApp.directive('block', ["Blocks", function(Blocks) {
  return {
    scope: {'id': '@block'},
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
}]);
elementMinimapApp.directive('elementMinimapHighlight', ["HoverField", "ElementFinder", function(HoverField, ElementFinder) {
  return {link: function postLink(scope, element, attrs) {
      scope.$watch(function() {
        return HoverField.currentIdentifier;
      }, function(newValue) {
        $(element).find('.minimap__highlight').removeClass('minimap__highlight');
        if (newValue) {
          var found = ElementFinder.get(element, newValue);
          found.addClass('minimap__highlight');
        }
      });
    }};
}]);
elementMinimapApp.directive('elementMinimapScale', ["EventWatcher", "$window", "TweenMax", function(EventWatcher, $window, TweenMax) {
  return {
    scope: {'scale': '=elementMinimapScale'},
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
}]);
elementMinimapApp.directive('elementMinimapTriggerHover', ["HoverField", function(HoverField) {
  return {
    scope: {'trigger': '=elementMinimapTriggerHover'},
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
}]);

//# sourceMappingURL=../element/minimap.js.map