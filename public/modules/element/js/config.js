cmsApp.constant('MODULE_BASE', 'modules/cms/views');

cmsApp.run(function($rootScope) {

  var events = [
    'header.expand'
  ];

  events.forEach(function(event) {
    $rootScope.$on(event, function(e, data) {
      $rootScope.$broadcast(`down-${event}`, data);
    });
  });

});