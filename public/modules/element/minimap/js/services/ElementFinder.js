elementMinimapApp.factory('ElementFinder', function() {

  return {
    get: function(element, identifier) {
      identifier = identifier.compact();
      var found = $(element).find(identifier);

      while (!found.length && identifier.length) {
        var pieces = identifier.split(' ');
        pieces.pop();
        identifier = pieces.join(' ').compact();
        found = $(element).find(identifier);
      }

      while (!found.is(':visible') && $(element).has(found).length) {
        found = found.parent();
      }

      return found;
    }
  };

});