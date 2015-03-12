elementMinimapApp.controller('MinimapBlocksCtrl', function($scope, SweetAlert) {

  $scope.blocks = {
    identifiers: []
  };

  $scope.addIdentifier = function(identifier) {
    if (!!~$scope.blocks.identifiers.indexOf(identifier)) {
      SweetAlert.swal('You cannot add one block twice.')
    } else {
      $scope.blocks.identifiers.push(identifier);
    }
  };

});