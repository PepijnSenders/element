elementManagerApp.controller('ManagerCustomTextCtrl', function($scope, UniqId, PAGE) {

  $scope.customs = [{
    identifier: UniqId.generate(`${PAGE}-`),
    default: ''
  }];

  $scope.addCustom = function() {
    var last = $scope.customs.last(1)[0];
    if (!last.default) {
      return;
    }
    $scope.customs.push({
      identifier: UniqId.generate(`${PAGE}-`),
      default: ''
    });
  };

});