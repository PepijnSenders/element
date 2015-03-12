<?php

App::before(function() {

  Config::set('auth.multi.element2cms', [
    'driver' => 'eloquent',
    'model' => 'Pep\\Element\\Models\\User\\CmsUser',
  ]);

});

Route::filter('element__cms', function() {
  if (!Auth::element2cms()->check()) {
    return Redirect::route('element::pages.users.login');
  }
});