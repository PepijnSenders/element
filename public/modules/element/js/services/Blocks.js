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