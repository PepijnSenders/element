<?php

use Pep\Element\User\Auth;

Route::filter('admin', function() {

  if (!Auth::check()) {
    return Redirect::route('element-cms.pages.users.login');
  }

});