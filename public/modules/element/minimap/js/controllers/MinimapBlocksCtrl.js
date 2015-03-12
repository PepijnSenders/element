elementMinimapApp.controller('MinimapBlocksCtrl', function($scope) {

  $scope.blocks = {
    identifiers: []
  };

  $scope.addIdentifier = function(identifier) {
    $scope.blocks.identifiers.push(identifier);
    console.log($scope.blocks);
  };

});