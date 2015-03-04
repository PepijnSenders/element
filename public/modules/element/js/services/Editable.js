elementApp.factory('Editable', function($http, EDITABLE_GET_FOR_BLOCK) {

  return {
    getForBlock: function(block) {
      return $http({
        method: 'GET',
        url: EDITABLE_GET_FOR_BLOCK,
        params: {
          block: block
        }
      }).then(function(response) {
        return response.data.globals;
      });
    }
  };

});