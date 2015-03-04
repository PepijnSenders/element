"use strict";
var elementMinimapApp = angular.module('elementMinimapApp', ["eventwatcherApp", "tweenmaxApp"]);
cmsMinimapApp.directive('block', ["Blocks", function(Blocks) {
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
cmsMinimapApp.directive('cmsMinimapHighlight', ["HoverField", function(HoverField) {
  return {link: function postLink(scope, element, attrs) {
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
    }};
}]);
cmsMinimapApp.directive('cmsMinimapScale', ["EventWatcher", "$window", "TweenMax", function(EventWatcher, $window, TweenMax) {
  return {link: function postLink(scope, element, attrs) {
      EventWatcher.addEvent('resize');
      scope.$watch(function() {
        return EventWatcher.events['resize'].timeStamp;
      }, function() {
        TweenMax.set(element.find('#container'), {
          scale: .25 * $window.innerWidth / $window.innerWidth,
          force3D: true
        });
        TweenMax.set(element[0].parentNode, {
          width: '100%',
          position: 'fixed'
        });
      });
    }};
}]);

//# sourceMappingURL=../element/minimap.js.map