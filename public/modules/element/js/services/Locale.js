elementApp.factory('Locale', function() {

  return {
    language: 'nl',
    region: 'NL',
    createLocale: function(language, region) {
      return `${language}_${region}`;
    }
  };

});