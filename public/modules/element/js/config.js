elementApp.constant('MODULE_BASE', 'modules/cms/views');

elementApp.run(function($rootScope) {

  var events = [
    'header.expand'
  ];

  events.forEach(function(event) {
    $rootScope.$on(event, function(e, data) {
      $rootScope.$broadcast(`down-${event}`, data);
    });
  });

});