elementApp.filter('title', function() {

  return function(input) {
    var pieces = input.split('.');
    input = pieces[pieces.length - 1];
    return input.replace(/\#/g, ' ').titleize();
  };

});