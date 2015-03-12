elementManagerApp.controller('ManagerCustomTextCtrl', function($scope, UniqId, PAGE) {

  $scope.customs = [{
    identifier: UniqId.generate(`${PAGE}-`),
    text: ''
  }];

  $scope.addCustom = function() {
    $scope.customs.push({
      identifier: UniqId.generate(`${PAGE}-`),
      text: ''
    });
  };

});