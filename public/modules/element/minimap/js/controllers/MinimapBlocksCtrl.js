elementMinimapApp.controller('MinimapBlocksCtrl', function($scope, SweetAlert, ElementFinder, Identify) {

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

  $scope.$watch('blocks.identifiers.length', function() {
    $scope.blocks.joined = $scope.blocks.identifiers.join(', ');
  });

  $scope.search = function(identifier) {
    var container = $('#blocks-minimap');

    var found = ElementFinder.get(container, identifier);

    if (found.length > 1) {
      SweetAlert.swal('More than one element with that identifier, please be more specific.');
    } else if (found.length === 1) {
      $scope.addIdentifier(Identify.element(found, container.find('.minimap__scale')));
    } else {
      SweetAlert.swal('Cannot find element.');
    }
  };

});