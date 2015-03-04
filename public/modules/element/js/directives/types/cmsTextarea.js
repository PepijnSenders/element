cmsApp.directive('cmsTextarea', function(MODULE_BASE, Input) {

  return {
    scope: {
      'global': '=cmsTextarea'
    },
    templateUrl: MODULE_BASE + '/cms-textarea.html',
    controller: 'InputCtrl',
    link: Input
  };

});