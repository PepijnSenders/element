<?php

namespace Pep\Element\Controllers\Site;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;
use Pep\Cms\Minimap;
use Pep\Cms\MinimapException;
use Pep\Cms\ExceptionResponse;

class PagesController extends Controller {

  public function home() {

  }

  public function minimap($key) {
    if (!Minimap::check($key)) {
      return ExceptionResponse::notFound();
    }

    $minimap = new Minimap('site.pages.' . str_replace('/', '.', $key));

    return View::make('element-cms::pages.minimap')
      ->with('minimap', $minimap)
      ->with('key', $key);
  }

}