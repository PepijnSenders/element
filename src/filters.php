<?php

App::before(function() {

  Config::set('auth.multi.element2cms', [
    'driver' => 'eloquent',
    'model' => 'Pep\\Element\\Models\\User\\CmsUser',
  ]);

});

Route::filter('admin', function() {
  if (!Auth::element2cms()->check()) {
    return Redirect::route('element::pages.users.login');
  }
});