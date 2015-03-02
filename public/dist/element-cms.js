"use strict";
var elementCmsApp = angular.module('elementCmsApp', ["elementCmsMinimapApp"]);
cmsApp.constant('MODULE_BASE', 'modules/cms/views');
cmsApp.run(["$rootScope", function($rootScope) {
  var events = ['header.expand'];
  events.forEach(function(event) {
    $rootScope.$on(event, function(e, data) {
      $rootScope.$broadcast(("down-" + event), data);
    });
  });
}]);
cmsApp.controller('BlocksCtrl', ["Blocks", "$scope", function(Blocks, $scope) {
  $scope.blocks = Blocks.container;
  $scope.close = function(block) {
    for (var index in Blocks.container) {
      var _block = Blocks.container[index];
      if (_block === block) {
        Blocks.remove(index);
      }
    }
  };
}]);
cmsApp.controller('EditCtrl', ["$scope", "Editable", function($scope, Editable) {
  $scope.getForBlock = function(block) {
    Editable.getForBlock(block).then(function(editables) {
      $scope.editables = editables;
    });
  };
}]);
cmsApp.controller('InputCtrl', ["$scope", "Field", "History", "Locale", "$q", function($scope, Field, History, Locale, $q) {
  this.init = function() {
    $scope.disabled = true;
    return Field.translation($scope.global.key, Locale.language, Locale.region).then(function(translation) {
      lastValue = translation;
      $scope.input = {value: translation};
      $scope.disabled = false;
      return translation;
    });
  };
  var lastValue;
  this.update = function() {
    if ($scope.input.value === lastValue) {
      return $q.when();
    }
    lastValue = $scope.input.value;
    delete $scope.histories;
    $scope.disabled = true;
    return Field.save($scope.global.key, Locale.language, Locale.region, $scope.input.value).then(function(translation) {
      $scope.input.value = translation;
      $scope.disabled = false;
      return translation;
    });
  };
  var historyPage = 1;
  this.history = function() {
    if ($scope.histories) {
      delete $scope.histories;
      return $q.when();
    } else {
      historyPage = 1;
      return History.getByKey($scope.global.key).then(function(histories) {
        $scope.histories = histories.data;
        return histories;
      });
    }
  };
  this.loadMoreHistories = function() {
    historyPage++;
    return History.getByKey($scope.global.key, historyPage).then(function(histories) {
      $scope.histories = $scope.histories.concat(histories.data);
      return histories;
    });
  };
}]);
cmsApp.factory('Blocks', function() {
  return {
    container: {},
    timestamp: Date.now(),
    update: function() {
      this.timestamp = Date.now();
    },
    add: function(index, block) {
      this.container[index] = block;
      this.update();
    },
    remove: function(index) {
      delete this.container[index];
      this.update();
    }
  };
});
cmsApp.factory('Editable', ["$http", "EDITABLE_GET_FOR_BLOCK", function($http, EDITABLE_GET_FOR_BLOCK) {
  return {getForBlock: function(block) {
      return $http({
        method: 'GET',
        url: EDITABLE_GET_FOR_BLOCK,
        params: {block: block}
      }).then(function(response) {
        return response.data.globals;
      });
    }};
}]);
cmsApp.factory('Field', ["$http", "FIELD_GET", "FIELD_TRANSLATION", "FIELD_SAVE", "Locale", function($http, FIELD_GET, FIELD_TRANSLATION, FIELD_SAVE, Locale) {
  return {
    get: function(key) {
      return $http({
        method: 'GET',
        url: FIELD_GET,
        params: {key: key}
      }).then(function(response) {
        return response.data.field;
      });
    },
    translation: function(key, language, region) {
      return $http({
        method: 'GET',
        url: FIELD_TRANSLATION,
        params: {
          key: key,
          locale: Locale.createLocale(language, region)
        }
      }).then(function(response) {
        return response.data.translation;
      });
    },
    save: function(key, language, region, value) {
      return $http({
        method: 'POST',
        url: FIELD_SAVE,
        params: {
          key: key,
          locale: Locale.createLocale(language, region),
          value: value
        }
      }).then(function(response) {
        return response.data.translation;
      });
    }
  };
}]);
cmsApp.factory('History', ["$http", "HISTORY_GET_KEY", function($http, HISTORY_GET_KEY) {
  return {getByKey: function(key) {
      var page = arguments[1] !== (void 0) ? arguments[1] : 1;
      var count = arguments[2] !== (void 0) ? arguments[2] : 10;
      return $http({
        url: HISTORY_GET_KEY,
        params: {
          key: key,
          page: page,
          count: count
        },
        method: 'GET'
      }).then(function(response) {
        return response.data.histories;
      });
    }};
}]);
cmsApp.factory('HoverField', function() {
  return {currentIdentifier: ''};
});
cmsApp.factory('Input', function() {
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
cmsApp.factory('Locale', function() {
  return {
    language: 'nl',
    region: 'NL',
    createLocale: function(language, region) {
      return (language + "_" + region);
    }
  };
});
cmsApp.directive('cmsInput', ["MODULE_BASE", "Input", function(MODULE_BASE, Input) {
  return {
    scope: {'global': '=cmsInput'},
    templateUrl: MODULE_BASE + '/cms-input.html',
    controller: 'InputCtrl',
    link: Input
  };
}]);
cmsApp.directive('cmsTextarea', ["MODULE_BASE", "Input", function(MODULE_BASE, Input) {
  return {
    scope: {'global': '=cmsTextarea'},
    templateUrl: MODULE_BASE + '/cms-textarea.html',
    controller: 'InputCtrl',
    link: Input
  };
}]);
cmsApp.directive('cmsField', ["Field", "MODULE_BASE", "HoverField", function(Field, MODULE_BASE, HoverField) {
  return {
    scope: {global: '=cmsField'},
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
}]);
cmsApp.directive('cmsHistory', ["MODULE_BASE", "USER_SHOW", function(MODULE_BASE, USER_SHOW) {
  return {
    scope: {'histories': '=cmsHistory'},
    templateUrl: MODULE_BASE + '/cms-history.html',
    link: function postLink(scope, element, attrs) {
      scope.linkBase = USER_SHOW + '/';
      scope.loadMore = function() {
        scope.$parent.loadMoreHistories().then(function(histories) {
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
}]);
cmsApp.filter('title', function() {
  return function(input) {
    var pieces = input.split('.');
    input = pieces[pieces.length - 1];
    return input.replace(/\#/g, ' ').titleize();
  };
});
angular.module("elementCmsApp").run(['$templateCache', function(a) {
  a.put('/modules/element-cms/views/cms-textarea.html', '<div class="input-group">\n' + '  <textarea type="text" ng-disabled="disabled" class="form-control" id="{{ field.key }}" ng-model="input.value"></textarea>\n' + '  <div class="input-group-addon btn-info btn" ng-click="history();">\n' + '    History\n' + '  </div>\n' + '  <div class="input-group-addon btn btn-success" ng-click="update();">\n' + '    Save\n' + '  </div>\n' + '</div>\n' + '<div cms-history="histories"></div>');
  a.put('/modules/element-cms/views/cms-input.html', '<div class="input-group">\n' + '  <input type="text" class="form-control" id="{{ field.key }}" ng-disabled="disabled" ng-model="input.value">\n' + '  <div class="input-group-addon btn-info btn" ng-click="history();">\n' + '    History\n' + '  </div>\n' + '  <div class="input-group-addon btn-success btn" ng-click="update();">\n' + '    Save\n' + '  </div>\n' + '</div>\n' + '<div cms-history="histories"></div>');
  a.put('/modules/element-cms/views/cms-history.html', '<ul ng-if="histories.length" class="history-list">\n' + '  <li ng-repeat="history in histories" class="history-list__item">\n' + '    <samp ng-bind="history.created_at"></samp>: <a target="_blank" ng-bind="history.user" ng-href="{{linkBase + history.user}}"></a> edited to <span ng-bind="history.value"></span>\n' + '  </li>\n' + '  <li>\n' + '    <a ng-click="loadMore();" ng-if="!finished">Load more</a>\n' + '  </li>\n' + '</ul>\n' + '<div class="history-list" ng-if="histories && !histories.length">\n' + '  No recent history on this field.\n' + '</div>');
  a.put('/modules/element-cms/views/cms-field.html', '<td class="col-sm-3">\n' + '  <label for="global.key" ng-bind="global.key | title"></label>\n' + '</td>\n' + '<td ng-switch="type" class="col-sm-9">\n' + '  <div ng-switch-when="input" cms-input="global"></div>\n' + '  <div ng-switch-when="textarea" cms-textarea="global"></div>\n' + '</td>');
}]);

//# sourceMappingURL=element-cms.js.map