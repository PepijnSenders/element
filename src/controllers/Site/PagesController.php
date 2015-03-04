<?php

namespace Pep\Element\Controllers\Site;

use Pep\Element\Controllers\BaseController;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class PagesController extends BaseController {

  public function home() {
    $user = Auth::element2cms()->user();

    return View::make('element::pages.home')
      ->with('user', $user);
  }

}