cmsApp.factory('Field', function($http, FIELD_GET, FIELD_TRANSLATION, FIELD_SAVE, Locale) {

  return {
    get: function(key) {
      return $http({
        method: 'GET',
        url: FIELD_GET,
        params: {
          key: key
        }
      }).then(function(response) {
        return response.data.field;
      });
    },
    translation: function(key, language, region) {
      return $http({
        method: 'GET',
        url: FIELD_TRANSLATION,
        params: {
          key: key,
          locale: Locale.createLocale(language, region)
        }
      }).then(function(response) {
        return response.data.translation;
      });
    },
    save: function(key, language, region, value) {
      return $http({
        method: 'POST',
        url: FIELD_SAVE,
        params: {
          key: key,
          locale: Locale.createLocale(language, region),
          value: value
        }
      }).then(function(response) {
        return response.data.translation;
      });
    }
  };

});