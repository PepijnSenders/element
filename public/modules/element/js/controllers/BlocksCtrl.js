elementApp.controller('BlocksCtrl', function(Blocks, $scope) {

  $scope.blocks = Blocks.container;

  $scope.close = function(block) {
    for (var index in Blocks.container) {
      var _block = Blocks.container[index];
      if (_block === block) {
        Blocks.remove(index);
      }
    }
  };

});