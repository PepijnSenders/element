cmsApp.controller('EditCtrl', function($scope, Editable) {

  $scope.getForBlock = function(block) {
    Editable.getForBlock(block)
      .then(function(editables) {
        $scope.editables = editables;
      });
  };

});