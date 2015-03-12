elementMinimapApp.factory('Identify', function() {

  return {
    element: function(element, container) {
      if (!(element instanceof $)) {
        element = $(element);
      }

      var id = element.attr('id');
      if (id && !id.startsWith('minimap-')) {
        return '#' + id;
      } else {
        var identifier = '';
        while (element.length && container.has(element).length) {
          var id = element.attr('id');
          if (id && !id.startsWith('minimap-')) {
            identifier = '#' + id + ' ' + identifier;
          } else if (element[0].className) {
            identifier = '.' + element[0].className.split(' ').join('.') + ' ' + identifier;
          }
          element = element.parent();
        }

        return identifier;
      }
    }
  };

});