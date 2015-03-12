elementApp.factory('UniqId', function() {

  return {
    uniqidSeed: Math.floor(Math.random() * 0x75bcd15),
    generate: function(prefix = '', moreEntropy = false) {
      var retId;
      var formatSeed = function (seed, reqWidth) {
        seed = parseInt(seed, 10)
          .toString(16);
        if (reqWidth < seed.length) {
          return seed.slice(seed.length - reqWidth);
        }
        if (reqWidth > seed.length) {
          return Array(1 + (reqWidth - seed.length))
            .join('0') + seed;
        }
        return seed;
      };

      this.uniqidSeed++;

      retId = prefix;
      retId += formatSeed(parseInt(new Date()
        .getTime() / 1000, 10), 8);

      retId += formatSeed(this.uniqidSeed, 5);
      if (moreEntropy) {
        retId += (Math.random() * 10)
          .toFixed(8)
          .toString();
      }

      return retId;
    }
  };

});