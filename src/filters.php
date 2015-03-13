<?php

App::before(function() {

  Config::set('auth.multi.pep__element', [
    'driver' => 'eloquent',
    'model' => 'Pep\\Element\\Models\\User\\CmsUser',
  ]);

  Config::set('database.connections.pep__element', Config::get('element::database'));

});

Route::filter('element__cms', function() {
  if (!Auth::pep__element()->check()) {
    return Redirect::route('element::pages.users.login', [
      'url' => Request::path(),
    ]);
  }
});