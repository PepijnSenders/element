<?php

namespace Pep\Element\Controllers\Site\User;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;

class PagesController extends Controller {

  public function login() {
    return View::make('element-cms::pages.users.login');
  }

  public function show() {
    echo 'empty';
  }

}