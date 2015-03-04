cmsApp.controller('InputCtrl', function($scope, Field, History, Locale, $q) {

  this.init = function() {
    $scope.disabled = true;

    return Field.translation($scope.global.key, Locale.language, Locale.region)
      .then(function(translation) {
        lastValue = translation;
        $scope.input = {
          value: translation
        };
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

    return Field.save($scope.global.key, Locale.language, Locale.region, $scope.input.value)
      .then(function(translation) {
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
      return History.getByKey($scope.global.key)
        .then(function(histories) {
          $scope.histories = histories.data;

          return histories;
        });
    }
  };

  this.loadMoreHistories = function() {
    historyPage++;
    return History.getByKey($scope.global.key, historyPage)
      .then(function(histories) {
        $scope.histories = $scope.histories.concat(histories.data);

        return histories;
      });
  };

});