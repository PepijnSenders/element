elementApp.factory('History', function($http, HISTORY_GET_KEY) {

  return {
    getByKey: function(key, page = 1, count = 10) {
      return $http({
        url: HISTORY_GET_KEY,
        params: {
          key: key,
          page: page,
          count: count
        },
        method: 'GET'
      }).then(function(response) {
        return response.data.histories;
      });
    }
  };

});