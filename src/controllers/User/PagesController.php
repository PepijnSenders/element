<?php

namespace Pep\Element\Controllers\Site\User;

use Pep\Element\Controllers\BaseController;
use Illuminate\Support\Facades\View;

class PagesController extends Controller {

  public function login() {
    return View::make('element::pages.users.login');
  }

}