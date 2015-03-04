<?php

namespace Pep\Element\Controllers\Site\User;

use Pep\Element\Controllers\BaseController;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class PagesController extends BaseController {

  public function login() {
    if (Auth::element2cms()->check()) {
      return Redirect::route('element::pages.home');
    }

    return View::make('element::pages.users.login');
  }

}