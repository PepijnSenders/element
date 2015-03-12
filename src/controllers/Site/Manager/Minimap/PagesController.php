<?php

namespace Pep\Element\Controllers\Site\Manager\Minimap;

use Pep\Element\Controllers\BaseController;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Pep\Element\Models\Manager\Page;
use Pep\Element\Minimap\Minimap;

class PagesController extends BaseController {

  public function load() {
    $availableRoutes = Page::getAvailableRoutes();

    return View::make('element::pages.manager.minimap.load')
      ->with('availableRoutes', $availableRoutes)
      ->with('messages', Session::get('messages', []));
  }

  public function blocks(Page $page) {
    $minimap = new Minimap($page);

    return View::make('element::pages.manager.minimap.blocks')
      ->with('minimap', $minimap);
  }

  public function finalize(Page $page) {
    return View::make('element::pages.manager.minimap.finalize');
  }

}