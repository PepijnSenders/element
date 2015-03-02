var gulp = require('gulp');
var sugar = require('sugar');
var noprotocol = require('gulp-noprotocol');
var changeCase = require('change-case');
var concat = require('gulp-concat');
var exec = require('child_process').exec;

var modules = require('./modules.json');

var ugly = false;

var watchers = {
  'sass': [],
  'js': [],
  'libs': []
};

for (var module in modules) {
  var properties = modules[module];
  if ('sass' in properties && properties.sass) {
    var source = 'public/modules/' + module + '/sass/**/*.{scss,sass}',
        task = 'sass-' + module,
        to = 'public/css/' + module;
    gulp.task(task, function() {
      var assetString = '/assets/$2$3';
      return gulp.src(this.source)
        .pipe(noprotocol.css({
          minify: ugly
        }))
        .on('error', noprotocol.notify)
        .pipe(gulp.dest(this.to));
    }.bind({
      source: source,
      module: module,
      to: to
    }));
    watchers.sass.push({
      source: source,
      task: task,
      to: to
    });
  }
  if ('libs' in properties && properties.libs.length > 0) {
    var task = 'bundle-libs-' + module;
    gulp.task(task, function() {
      var stream = gulp.src(this.libs)
        .pipe(concat(this.module + '.bundle.js'))
        .on('error', noprotocol.notify);
      if (false) {
        stream.pipe(uglify());
      }
      return stream.pipe(gulp.dest('public/dist'));
    }.bind({
      libs: properties.libs,
      module: module
    }));
    watchers.libs.push({
      source: properties.libs,
      task: task
    });
  }
  if ('app' in properties) {
    var source = [
      'public/modules/' + module + '/js/config.js',
      'public/modules/' + module + '/js/controllers/**/*.js',
      'public/modules/' + module + '/js/services/**/*.js',
      'public/modules/' + module + '/js/directives/**/*.js',
      'public/modules/' + module + '/js/models/**/*.js',
      'public/modules/' + module + '/js/filters/**/*.js',
      'public/modules/' + module + '/js/bootstrap.js',
      'public/modules/' + module + '/views/**/*.html'
    ],
      task = 'bundle-' + module;
    watchers.js.push({
      source: source,
      task: task
    });
    gulp.task(task, function() {
      return gulp.src(this.source)
        .pipe(noprotocol.angular({
          deps: this.app.deps,
          module: changeCase.camel(this.module) + 'App',
          bundle: this.module + '.js',
          minify: ugly
        }))
        .on('error', noprotocol.notify)
        .pipe(gulp.dest('public/dist'));
    }.bind({
      module: module,
      app: properties.app,
      source: source
    }));
  }
}

var sassTasks = watchers.sass.map(function(sass) {
    return sass.task;
  }),
  jsTasks = watchers.js.map(function(js) {
    return js.task;
  }),
  libsTasks = watchers.libs.map(function(libs) {
    return libs.task;
  });

var initTasks = [sassTasks, jsTasks, libsTasks].flatten();

gulp.task('autoload', function() {
  var composer = exec('composer dump-autoload');
});

gulp.task('setUgly', function() {
  ugly = true;
});

gulp.task('clean', function() {
  return gulp.src([
      'public/dist/**/*.js',
      'public/css/**/*.css'
    ])
    .pipe(clean({
      force: true
    }));
});

gulp.task('watch', initTasks, function() {
  watchers.sass.forEach(function(sass) {
    gulp.watch(sass.source, [sass.task]);
  });

  watchers.js.forEach(function(js) {
    gulp.watch(js.source, [js.task]);
  });

  watchers.libs.forEach(function(libs) {
    gulp.watch(libs.source, [libs.task]);
  });

  gulp.watch([
    'app/controllers/**/*.php',
    'app/models/**/*.php',
    'app/libraries/**/*.php',
    "app/router/**/*.php"
  ], ['autoload']);

  livereload.listen();
  gulp.watch([
    'public/dist/**/*.js',
    'public/css/**/*.css',
    'app/views/**/*.php'
  ]).on('change', livereload.changed);

    gulp.watch('gulpfile.js', function() {
        console.log('gulpfile.js has changed, restart required...');
        process.exit(0);
    });
});

gulp.task('deploy', ['setUgly'].concat(initTasks));

gulp.task('default', ['watch']);
