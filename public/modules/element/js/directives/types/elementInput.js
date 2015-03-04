elementApp.directive('cmsInput', function(MODULE_BASE, Input) {

  return {
    scope: {
      'global': '=cmsInput'
    },
    templateUrl: MODULE_BASE + '/cms-input.html',
    controller: 'InputCtrl',
    link: Input
  };

});